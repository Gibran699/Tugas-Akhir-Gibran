<?php

namespace App\Imports\Concerns;

use Maatwebsite\Excel\Validators\Failure;

trait ImportReconciliationTrait
{
    /**
     * Nama class model untuk mendeteksi kolom secara dinamis.
     */
    public ?string $modelClass = null;

    /**
     * Array penampung semua baris yang gagal (validasi maupun error DB).
     * Setiap elemen: ['row' => N, 'attribute' => '...', 'errors' => [...], 'values' => [...]]
     */
    protected array $importFailures = [];

    /**
     * Callback dari concern SkipsOnFailure.
     * Dipanggil otomatis oleh Laravel Excel setiap kali ada baris gagal validasi.
     */
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            $this->importFailures[] = [
                'row'       => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors'    => $failure->errors(),
                'values'    => $failure->values(),
            ];
        }
    }

    /**
     * Callback dari concern SkipsOnError.
     * Dipanggil saat terjadi error-level exception (misal: SQL error, type mismatch).
     * Baris yang error akan dilewati dan dicatat — proses import tetap lanjut.
     */
    public function onError(\Throwable $e): void
    {
        $this->importFailures[] = [
            'row'       => null,
            'attribute' => 'system',
            'errors'    => [$e->getMessage()],
            'values'    => [],
        ];
    }

    /**
     * Cache static untuk menyimpan aturan validasi dinamis agar tidak melakukan query schema berulang kali.
     */
    protected static array $dynamicRulesCache = [];

    /**
     * Aturan validasi kolom numerik yang wajib ada di setiap baris.
     * Import class dapat meng-override method ini untuk menyesuaikan kolom yang divalidasi.
     * Dipanggil oleh concern WithValidation.
     */
    public function rules(): array
    {
        if (empty($this->modelClass)) {
            return [
                'kode_wilayah' => ['required'],
            ];
        }

        if (isset(self::$dynamicRulesCache[$this->modelClass])) {
            return self::$dynamicRulesCache[$this->modelClass];
        }

        try {
            $model = new $this->modelClass;
            $table = $model->getTable();
            
            // Dapatkan seluruh kolom dari table
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
            
            // Kolom audit / metadata yang tidak di-input langsung dari Excel
            $exclude = [
                'id',
                'uuid',
                'semester',
                'tahun',
                'tanggal_laporan',
                'created_at',
                'updated_at',
                'deleted_at'
            ];
            
            $rules = [];
            foreach ($columns as $column) {
                if (in_array($column, $exclude)) {
                    continue;
                }
                
                // Cek tipe data kolom di DB
                $type = \Illuminate\Support\Facades\Schema::getColumnType($table, $column);
                
                if (in_array($type, ['integer', 'bigint', 'smallint', 'tinyint', 'mediumint'])) {
                    // Seluruh kolom angka/kalkulasi kependudukan wajib bertipe integer dan minimal 0
                    $rules[$column] = ['required', 'integer', 'min:0'];
                } else {
                    // Kolom string/keterangan wajib ada
                    $rules[$column] = ['required'];
                }
            }
            
            self::$dynamicRulesCache[$this->modelClass] = $rules;
            return $rules;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("Dynamic validation rules generation failed for model class {$this->modelClass}: " . $e->getMessage());
            return [
                'kode_wilayah' => ['required'],
            ];
        }
    }

    /**
     * Kembalikan semua detail baris yang gagal.
     */
    public function getImportFailures(): array
    {
        return $this->importFailures;
    }

    /**
     * Jumlah baris yang gagal diproses.
     */
    public function getImportFailureCount(): int
    {
        return count($this->importFailures);
    }
}
