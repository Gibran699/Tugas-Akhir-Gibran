<?php

namespace App\services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

/**
 * DataAvailabilityService
 *
 * Mengecek ketersediaan data pada setiap kombinasi fitur/entitas/dimensi
 * berdasarkan tahun, semester, dan cakupan wilayah (kecamatan/kelurahan).
 *
 * Semua tabel data diasumsikan memiliki kolom:
 *   kode_wilayah, tahun, semester
 * Kolom deleted_at bersifat opsional — dicek otomatis via schema builder.
 */
class DataAvailabilityService
{
    const STATUS_AVAILABLE = 'available';
    const STATUS_PARTIAL   = 'partial';
    const STATUS_MISSING   = 'missing';
    const STATUS_UNKNOWN   = 'unknown';

    // ──────────────────────────────────────────────────────────
    //  PUBLIC METHODS
    // ──────────────────────────────────────────────────────────

    /**
     * Ambil satu entri registry berdasarkan feature / entity / dimension.
     *
     * @return array|null  null jika tidak ditemukan
     */
    public function resolveEntry(string $feature, string $entity, string $dimension): ?array
    {
        $dim = config("data_availability.{$feature}.entities.{$entity}.dimensions.{$dimension}");

        if (!$dim) {
            return null;
        }

        return [
            'feature'         => $feature,
            'feature_label'   => config("data_availability.{$feature}.label", $feature),
            'entity'          => $entity,
            'entity_label'    => config("data_availability.{$feature}.entities.{$entity}.label", $entity),
            'dimension'       => $dimension,
            'dimension_label' => $dim['label'] ?? $dimension,
            'table'           => $dim['table'] ?? $dim['table_name'] ?? null,
            'columns'         => array_merge([
                'wilayah' => 'kode_wilayah',
                'tahun'   => 'tahun',
                'semester'=> 'semester',
                'deleted' => 'deleted_at',
            ], $dim['columns'] ?? []),
            'required_filters'=> $dim['required_filters'] ?? ['tahun', 'semester', 'kode_wilayah'],
            'route_name'      => $dim['route_name'] ?? config("data_availability.{$feature}.route_name"),
            'menu_target'     => $dim['menu_target'] ?? config("data_availability.{$feature}.menu_target"),
            'user_message'    => $dim['user_message'] ?? null,
            'admin_message'   => $dim['admin_message'] ?? null,
        ];
    }

    /**
     * Kembalikan daftar kode + nama kelurahan yang menjadi scope pengecekan.
     *
     * Prioritas:
     *  1. $kodeKelurahan diisi → hanya 1 kelurahan
     *  2. $kodeKecamatan diisi → semua kelurahan di kecamatan tersebut
     *  3. Keduanya null      → semua kelurahan aktif
     *
     * @return array<string, object>  key = kode_kelurahan, value = {kode, nama}
     */
    public function getKelurahanScope(?string $kodeKecamatan, ?string $kodeKelurahan): array
    {
        $query = DB::table('mstr_kelurahan')
            ->whereNull('deleted_at')
            ->select('kode', 'nama');

        if ($kodeKelurahan !== null && $kodeKelurahan !== '') {
            $query->where('kode', $kodeKelurahan);
        } elseif ($kodeKecamatan !== null && $kodeKecamatan !== '') {
            // WilayahController menggunakan dual-join karena kec_id bisa berisi
            // mstr_kecamatan.id ATAU mstr_kecamatan.kode — tangani keduanya.
            $kecId = DB::table('mstr_kecamatan')
                ->where('kode', $kodeKecamatan)
                ->whereNull('deleted_at')
                ->value('id');

            $query->where(function ($q) use ($kodeKecamatan, $kecId) {
                $q->where('kec_id', $kodeKecamatan);
                if ($kecId !== null) {
                    $q->orWhere('kec_id', (string) $kecId);
                }
            });
        }

        return $query->get()->keyBy('kode')->toArray();
    }

    public function availableYears(): array
    {
        $registry = config('data_availability', []);
        $years = [];

        foreach ($registry as $feature) {
            foreach (($feature['entities'] ?? []) as $entity) {
                foreach (($entity['dimensions'] ?? []) as $dim) {
                    $table = $dim['table'] ?? $dim['table_name'] ?? null;
                    $columns = array_merge([
                        'tahun' => 'tahun',
                        'deleted' => 'deleted_at',
                    ], $dim['columns'] ?? []);
                    $tahunColumn = $columns['tahun'];
                    $deletedColumn = $columns['deleted'] ?? 'deleted_at';

                    if (!$table || !$this->tableExists($table) || !$this->columnExists($table, $tahunColumn)) {
                        continue;
                    }

                    try {
                        $q = DB::table($table)
                            ->whereNotNull($tahunColumn)
                            ->select($tahunColumn)
                            ->distinct();

                        if ($deletedColumn && $this->columnExists($table, $deletedColumn)) {
                            $q->whereNull($deletedColumn);
                        }

                        foreach ($q->pluck($tahunColumn)->toArray() as $year) {
                            $year = (int) $year;
                            if ($year >= 2000 && $year <= 2100) {
                                $years[$year] = $year;
                            }
                        }
                    } catch (\Throwable $e) {
                        continue;
                    }
                }
            }
        }

        if (empty($years)) {
            $currentYear = (int) date('Y');
            for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                $years[$year] = $year;
            }
        }

        rsort($years);

        return array_values($years);
    }

    /**
     * Cek ketersediaan data untuk satu kombinasi fitur/entitas/dimensi.
     *
     * @return array  Hasil lengkap termasuk status, jumlah data, dan daftar wilayah yang belum ada data
     */
    public function checkAvailability(
        string  $feature,
        string  $entity,
        string  $dimension,
        int     $tahun,
        int     $semester,
        ?string $kodeKecamatan = null,
        ?string $kodeKelurahan = null
    ): array {
        // 1. Resolve registry entry
        $entry = $this->resolveEntry($feature, $entity, $dimension);

        if (!$entry) {
            return $this->buildUnknownResult($feature, $entity, $dimension, [
                'error' => "Kombinasi fitur='{$feature}', entitas='{$entity}', dimensi='{$dimension}' tidak ditemukan dalam registry.",
            ]);
        }

        $table = $entry['table'];

        // 2. Cek keberadaan tabel
        if (!$this->tableExists($table)) {
            return $this->buildUnknownResult($feature, $entity, $dimension, [
                'error' => "Tabel '{$table}' tidak ditemukan di database.",
                'table' => $table,
            ]);
        }

        // 3. Tentukan scope wilayah
        $scope      = $this->getKelurahanScope($kodeKecamatan, $kodeKelurahan);
        $scopeCodes = array_keys($scope);
        $totalScope = count($scopeCodes);

        if ($totalScope === 0) {
            return array_merge(
                $this->buildBaseResult($entry, $tahun, $semester, 0, 0, [], []),
                ['status' => self::STATUS_MISSING,
                 'error'  => 'Tidak ada wilayah yang sesuai dengan filter yang dipilih.']
            );
        }

        // 4. Query: distinct kode_wilayah yang sudah punya data
        $columns = $entry['columns'];
        $wilayahColumn = $columns['wilayah'];
        $tahunColumn = $columns['tahun'];
        $semesterColumn = $columns['semester'];
        $deletedColumn = $columns['deleted'] ?? 'deleted_at';

        foreach ([$wilayahColumn, $tahunColumn, $semesterColumn] as $column) {
            if (!$this->columnExists($table, $column)) {
                return $this->buildUnknownResult($feature, $entity, $dimension, [
                    'error' => "Kolom '{$column}' tidak ditemukan pada tabel '{$table}'.",
                    'table' => $table,
                ]);
            }
        }

        $hasDeletedAt = $deletedColumn && $this->columnExists($table, $deletedColumn);

        $q = DB::table($table)
            ->whereIn($wilayahColumn, $scopeCodes)
            ->where($tahunColumn, $tahun)
            ->where($semesterColumn, $semester);

        if ($hasDeletedAt) {
            $q->whereNull($deletedColumn);
        }

        $presentCodes = $q->distinct()->pluck($wilayahColumn)->map(fn($kode) => (string) $kode)->toArray();
        $totalData    = count($presentCodes);

        // 5. Hitung wilayah yang BELUM punya data
        $missingCodes   = array_values(array_diff($scopeCodes, $presentCodes));
        $missingCount   = count($missingCodes);

        $missingWilayah = array_map(
            fn($kode) => [
                'kode' => $kode,
                'nama' => isset($scope[$kode]) ? $scope[$kode]->nama : $kode,
            ],
            $missingCodes
        );

        // 6. Tentukan status
        if ($totalData === 0) {
            $status = self::STATUS_MISSING;
        } elseif ($missingCount === 0) {
            $status = self::STATUS_AVAILABLE;
        } else {
            $status = self::STATUS_PARTIAL;
        }

        return $this->buildBaseResult(
            $entry, $tahun, $semester,
            $totalData, $totalScope, $missingWilayah, $scope,
            $status
        );
    }

    /**
     * Ringkasan semua entri dalam registry untuk tahun & semester tertentu.
     * Opsional: filter ke feature tertentu saja.
     *
     * CATATAN: Metode ini menjalankan satu query per entri dimensi.
     * Pertimbangkan caching (Cache::remember) untuk produksi.
     *
     * @return array
     */
    public function summaryAll(int $tahun, int $semester, ?string $featureKey = null, ?string $entityKey = null, ?string $dimensionKey = null): array
    {
        $registry = config('data_availability', []);
        $items    = [];

        foreach ($registry as $fKey => $feature) {
            if ($featureKey && $fKey !== $featureKey) {
                continue;
            }

            foreach ($feature['entities'] as $eKey => $entity) {
                if ($entityKey && $eKey !== $entityKey) {
                    continue;
                }

                foreach ($entity['dimensions'] as $dKey => $dim) {
                    if ($dimensionKey && $dKey !== $dimensionKey) {
                        continue;
                    }

                    $check = $this->checkAvailability($fKey, $eKey, $dKey, $tahun, $semester);

                    $items[] = [
                        'feature'           => $fKey,
                        'feature_label'     => $feature['label'],
                        'entity'            => $eKey,
                        'entity_label'      => $entity['label'],
                        'dimension'         => $dKey,
                        'dimension_label'   => $dim['label'],
                        'table'             => $dim['table'] ?? $dim['table_name'] ?? null,
                        'route_name'        => $dim['route_name'] ?? Arr::get($feature, 'route_name'),
                        'menu_target'       => $dim['menu_target'] ?? Arr::get($feature, 'menu_target'),
                        'status'            => $check['status'],
                        'total_data'        => $check['total_data']     ?? 0,
                        'total_wilayah'     => $check['total_wilayah']  ?? 0,
                        'missing_count'     => $check['missing_count']  ?? 0,
                        'missing_wilayah'   => $check['missing_wilayah'] ?? [],
                        'message_for_admin' => $check['message_for_admin'] ?? ($check['error'] ?? ''),
                    ];
                }
            }
        }

        $col = collect($items);

        return [
            'tahun'     => $tahun,
            'semester'  => $semester,
            'feature'   => $featureKey,
            'entity'    => $entityKey,
            'dimension' => $dimensionKey,
            'total'     => $col->count(),
            'available' => $col->where('status', self::STATUS_AVAILABLE)->count(),
            'partial'   => $col->where('status', self::STATUS_PARTIAL)->count(),
            'missing'   => $col->where('status', self::STATUS_MISSING)->count(),
            'unknown'   => $col->where('status', self::STATUS_UNKNOWN)->count(),
            'items'     => $items,
        ];
    }

    // ──────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ──────────────────────────────────────────────────────────

    private function buildBaseResult(
        array  $entry,
        int    $tahun,
        int    $semester,
        int    $totalData,
        int    $totalScope,
        array  $missingWilayah,
        array  $scope,
        string $status = self::STATUS_MISSING
    ): array {
        $el  = $entry['entity_label'];
        $dl  = $entry['dimension_label'];
        $sl  = "Semester {$semester}";
        $tl  = "Tahun {$tahun}";
        $mc  = count($missingWilayah);

        $adminMsg = match ($status) {
            self::STATUS_AVAILABLE => "Data {$el} – {$dl} {$sl} {$tl} tersedia lengkap ({$totalData}/{$totalScope} wilayah).",
            self::STATUS_PARTIAL   => "Data {$el} – {$dl} {$sl} {$tl} belum lengkap. Masih terdapat {$mc} wilayah yang belum memiliki data.",
            self::STATUS_MISSING   => "Data {$el} – {$dl} {$sl} {$tl} belum tersedia. Silakan import data terlebih dahulu.",
            default                => 'Status tidak diketahui.',
        };

        $userMsg = match ($status) {
            self::STATUS_AVAILABLE => "Data untuk periode yang dipilih telah tersedia.",
            self::STATUS_PARTIAL   => "Data untuk periode atau wilayah yang dipilih belum lengkap.",
            self::STATUS_MISSING   => "Data untuk periode atau wilayah yang dipilih belum tersedia.",
            default                => 'Status data tidak diketahui.',
        };

        return [
            'status'            => $status,
            'feature'           => $entry['feature'],
            'feature_label'     => $entry['feature_label'],
            'entity'            => $entry['entity'],
            'entity_label'      => $entry['entity_label'],
            'dimension'         => $entry['dimension'],
            'dimension_label'   => $entry['dimension_label'],
            'table'             => $entry['table'],
            'tahun'             => $tahun,
            'semester'          => $semester,
            'total_data'        => $totalData,
            'total_wilayah'     => $totalScope,
            'missing_count'     => count($missingWilayah),
            'missing_wilayah'   => $missingWilayah,
            'message_for_admin' => $adminMsg,
            'message_for_user'  => $userMsg,
        ];
    }

    private function buildUnknownResult(string $feature, string $entity, string $dimension, array $extra = []): array
    {
        return array_merge([
            'status'            => self::STATUS_UNKNOWN,
            'feature'           => $feature,
            'entity'            => $entity,
            'dimension'         => $dimension,
            'table'             => null,
            'tahun'             => null,
            'semester'          => null,
            'total_data'        => 0,
            'total_wilayah'     => 0,
            'missing_count'     => 0,
            'missing_wilayah'   => [],
            'message_for_admin' => 'Konfigurasi registry tidak ditemukan atau tabel tidak ada.',
            'message_for_user'  => 'Terjadi kesalahan konfigurasi. Hubungi administrator.',
        ], $extra);
    }

    private function tableExists(string $table): bool
    {
        try {
            return DB::getSchemaBuilder()->hasTable($table);
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function columnExists(string $table, string $column): bool
    {
        try {
            return DB::getSchemaBuilder()->hasColumn($table, $column);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
