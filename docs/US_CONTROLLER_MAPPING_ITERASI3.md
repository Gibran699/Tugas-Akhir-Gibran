# Peta Implementasi User Story — Controller Code (Iterasi 3)

**Tanggal:** 21 Mei 2026
**Scope:** Controller code per User Story (US-07, US-08, US-09)

---

## US-09 — Import File Excel

**File:** `app/Http/Controllers/System/MainController.php`

```php
// Baris 21–93 — importData(): entry point upload & proses Excel
function importData(Request $request)
{
    // Resolusi kelas Import & Model dari config berdasarkan kode kategori
    $listFileImport = config('dataArray.listFileImport');
    $listFileModel  = config('dataArray.listFileModel');

    if (isset($listFileImport[$request->keterangan_file])) {
        $listFileImport = $listFileImport[$request->keterangan_file];
    }
    if (isset($listFileModel[$request->keterangan_file])) {
        $listFileModel = $listFileModel[$request->keterangan_file];
    }

    // Validasi input: semester, tahun, file (xlsx/xls/csv, max 20MB)
    $request->validate([
        'semester' => 'required|integer',
        'tahun'    => 'required|integer',
        'file'     => 'required|file|mimes:xlsx,xls,csv|max:20480',
    ]);

    $file     = $request->file('file');
    $tahun    = $request->input('tahun');
    $semester = $request->input('semester');

    // Cegah duplikasi: tolak jika data periode sudah ada → HTTP 409
    if ($listFileModel::where('tahun', $tahun)->where('semester', $semester)->exists()) {
        return response()->json('Data Sudah ada', 409);
    }

    try {
        DB::beginTransaction();

        // Deteksi tipe file
        $fileType  = \Maatwebsite\Excel\Excel::XLSX;
        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension === 'xls') {
            $fileType = \Maatwebsite\Excel\Excel::XLS;
        } elseif ($extension === 'csv') {
            $fileType = \Maatwebsite\Excel\Excel::CSV;
        }

        // File > 2MB: naikkan resource limit + chunk reading
        $fileSize = $file->getSize();
        if ($fileSize > 2 * 1024 * 1024) {
            ini_set('memory_limit', '1024M');
            set_time_limit(600);

            $import = new $listFileImport($tahun, $semester);
            if (method_exists($import, 'setChunkSize')) {
                $import->setChunkSize(500);
            }
            Excel::import($import, $file, null, $fileType);
        } else {
            // File kecil: proses normal
            Excel::import(new $listFileImport($tahun, $semester), $file, null, $fileType);
        }

        DB::commit();
        return response()->json('Import berhasil', 200);
    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('Import Error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        return response()->json('Proses gagal: ' . $e->getMessage(), 500);
    }
}
```

**Dispatch ke CalculateDataController:**

```php
// Baris 94–102 — searchData(): router dinamis ke method CalculateDataController
function searchData(Request $request, $jenisData)
{
    $listCalculateDataFunction = config('dataArray.listCalculateDataFunction');
    if (isset($listCalculateDataFunction[$jenisData])) {
        $listCalculateDataFunction = $listCalculateDataFunction[$jenisData];
        return $this->calculateDateFunction->$listCalculateDataFunction($request);
    }
    return response()->json(['error' => 'Invalid data type'], 400);
}
```

---

## US-07 — Agregat DKB

**File:** `app/Http/Controllers/System/CalculateDataController.php`

Semua method mengikuti pola yang sama: **3 level agregasi** (per kelurahan, per kecamatan, keseluruhan) + JOIN ke `mstr_kelurahan` dan `mstr_kecamatan`.

**Pola umum (contoh: `dataPendudukJenisKelamin` baris 71–112):**

```php
// Baris 71–112 — dataPendudukJenisKelamin(): contoh pola dasar
public function dataPendudukJenisKelamin($request)
{
    // Level 1: per kelurahan (data mentah + nama wilayah dari JOIN)
    $dataPerkelurahan = PendudukJenisKelamin::select([
        'jenis_kelamin_penduduk.*',
        'mstr_kelurahan.nama as kelurahan_nama',
        'mstr_kecamatan.nama as kecamatan_nama'
    ])
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_penduduk.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->where('jenis_kelamin_penduduk.semester', $request['semester'])
        ->where('jenis_kelamin_penduduk.tahun', $request['tahun'])
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // Level 2: keseluruhan kota (SUM semua baris)
    $dataKeseluruhan = PendudukJenisKelamin::select(
        DB::raw('sum(lk) as total_lk'),
        DB::raw('sum(pr) as total_pr'),
        DB::raw('sum(jumlah) as total_jumlah'),
    )->where('semester', $request['semester'])
        ->where('tahun', $request['tahun'])
        ->first();

    // Level 3: per kecamatan (GROUP BY kecamatan)
    $dataPerkecamatan = PendudukJenisKelamin::select([
        DB::raw('sum(lk) as total_lk'),
        DB::raw('sum(pr) as total_pr'),
        DB::raw('sum(jumlah) as total_jumlah'),
        'mstr_kecamatan.nama as kecamatan_nama'
    ])
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'jenis_kelamin_penduduk.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->where('jenis_kelamin_penduduk.semester', $request['semester'])
        ->where('jenis_kelamin_penduduk.tahun', $request['tahun'])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    $dataTitle = ['semester' => $request['semester'], 'tahun' => $request['tahun']];

    return response()->json([
        'dataPerkelurahan' => $dataPerkelurahan,
        'dataKeseluruhan'  => $dataKeseluruhan,
        'dataPerkecamatan' => $dataPerkecamatan,
        'dataTitle'        => $dataTitle
    ], 200);
}
```

**Daftar lengkap 19 method Agregat DKB:**

| # | Method | Baris | Entitas | Dimensi |
|---|---|---|---|---|
| 1 | `dataPendudukJenisKelamin` | 71 | Penduduk | Jenis Kelamin |
| 2 | `dataPendudukAgama` | 113 | Penduduk | Agama |
| 3 | `dataPendudukGoldar` | 191 | Penduduk | Golongan Darah |
| 4 | `dataPendudukHubKel` | 239 | Penduduk | Hubungan Keluarga |
| 5 | `dataPendudukPekerjaan` | 286 | Penduduk | Pekerjaan |
| 6 | `dataKepalaKeluargaAgama` | 334 | Kepala Keluarga | Agama |
| 7 | `dataKepalaKeluargaJenisKelamin` | 381 | Kepala Keluarga | Jenis Kelamin |
| 8 | `dataKepalaKeluargaPekerjaan` | 423 | Kepala Keluarga | Pekerjaan |
| 9 | `dataKepalaKeluargaPendidikan` | 470 | Kepala Keluarga | Pendidikan |
| 10 | `dataKelapaKeluargaStatusKawin` | 517 | Kepala Keluarga | Status Kawin |
| 11 | `dataStatusKawinAgama` | 567 | Status Kawin | Agama |
| 12 | `dataStatusKawinJenisKelamin` | 620 | Status Kawin | Jenis Kelamin |
| 13 | `dataStatusKawinPekerjaan` | 668 | Status Kawin | Pekerjaan |
| 14 | `dataPendidikanPendudukJenisKelamin` | 721 | Pendidikan | Jenis Kelamin |
| 15 | `dataPendidikanPekerjaan` | 764 | Pendidikan | Pekerjaan |
| 16 | `dataPendidikanGolonganDarah` | 816 | Pendidikan | Golongan Darah |
| 17 | `dataDisabilitasJenisKelamin` | 869 | Disabilitas | Jenis Kelamin |
| 18 | `dataDisabilitasPekerjaan` | 918 | Disabilitas | Pekerjaan |
| 19 | `dataDisabilitasPendidikan` | 970 | Disabilitas | Pendidikan |

---

## US-08 — Statistik Kelompok Umur & Struktur Umur

**File:** `app/Http/Controllers/System/CalculateDataController.php`

Pola sama seperti US-07 (3 level agregasi), dengan tambahan `GROUP BY kelompok_umur` pada data agregat. Contoh method Kelompok Umur dengan dimensi:

```php
// Baris 1538–1585 — dataStrukturUmurAgamaKelompokUmur(): contoh pola Struktur Umur
public function dataStrukturUmurAgamaKelompokUmur($request)
{
    $categoryReligious = config('dataArray.categoryReligious');

    // Per kelurahan
    $dataPerkelurahan = KelompokUmurAgama::select([
        'kelompok_umur_agama.*',
        'mstr_kelurahan.nama as kelurahan_nama',
        'mstr_kecamatan.nama as kecamatan_nama'
    ])
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_agama.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->where('kelompok_umur_agama.semester', $request['semester'])
        ->where('kelompok_umur_agama.tahun', $request['tahun'])
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // Keseluruhan: GROUP BY kelompok_umur untuk piramida penduduk
    $dataKeseluruhan = KelompokUmurAgama::select(
        array_merge(
            ['kelompok_umur'],
            array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryReligious)
        )
    )->where('semester', $request['semester'])
        ->where('tahun', $request['tahun'])
        ->groupBy('kelompok_umur_agama.kelompok_umur')
        ->get();

    // Per kecamatan: GROUP BY kecamatan + kelompok_umur
    $dataPerkecamatan = KelompokUmurAgama::select(array_merge(
        ['kelompok_umur_agama.kelompok_umur', 'mstr_kecamatan.nama as kecamatan_nama'],
        array_map(fn($item) => DB::raw("COALESCE(SUM($item),0) as $item"), $categoryReligious)
    ))
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'kelompok_umur_agama.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->where('kelompok_umur_agama.semester', $request['semester'])
        ->where('kelompok_umur_agama.tahun', $request['tahun'])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama', 'kelompok_umur_agama.kelompok_umur')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    return response()->json([
        'dataPerkelurahan' => $dataPerkelurahan,
        'dataKeseluruhan'  => $dataKeseluruhan,
        'dataPerkecamatan' => $dataPerkecamatan,
        'dataTitle'        => ['semester' => $request['semester'], 'tahun' => $request['tahun']]
    ], 200);
}
```

**Daftar lengkap 15 method Struktur Umur & Statistik Kelompok Umur:**

| # | Method | Baris | Entitas | Jenis Data |
|---|---|---|---|---|
| 1 | `dataStrukturUmurAgamaKelompokUmur` | 1538 | Agama | Kelompok Umur |
| 2 | `dataStrukturUmurDisabilitasKelompokUmur` | 1586 | Disabilitas | Kelompok Umur |
| 3 | `dataStrukturUmurDisabilitasPendidikan` | 1636 | Disabilitas | Pendidikan × Umur Tunggal |
| 4 | `dataStrukturUmurDisabilitasUmurTunggal` | 1693 | Disabilitas | Umur Tunggal |
| 5 | `dataStrukturUmurDisabilitasUsiaSekolah` | 1747 | Disabilitas | Usia Sekolah |
| 6 | `dataStrukturUmurGolonganDarahKelompokUmur` | 1794 | Golongan Darah | Kelompok Umur |
| 7 | `dataStrukturUmurGolonganDarahUmurTunggal` | 1847 | Golongan Darah | Umur Tunggal |
| 8 | `dataStrukturUmurKepalaKeluargaKelompokUmur` | 1902 | Kepala Keluarga | Kelompok Umur |
| 9 | `dataStrukturUmurKepalaKeluargaUmurTunggal` | 1951 | Kepala Keluarga | Umur Tunggal |
| 10 | `dataStrukturUmurKepalaKeluargaStatusKawin` | 1999 | Kepala Keluarga | Status Kawin × Kelompok Umur |
| 11 | `dataStrukturUmurPendudukUmurTunggal` | 2047 | Penduduk | Umur Tunggal |
| 12 | `dataStrukturUmurPendudukStatuKawinUmurTunggal` | 2096 | Penduduk | Status Kawin × Umur Tunggal |
| 13 | `dataStrukturUmurPendudukStatusKawinKelompokUmur` | 2200 | Penduduk | Status Kawin × Kelompok Umur |
| 14 | `dataStrukturUmurPendudukUsiaSekolah` | 2249 | Penduduk | Usia Sekolah |
| 15 | `dataStrukturUmurPendudukUsiaMudaProduktifTua` | 2293 | Penduduk | Muda/Produktif/Tua |

---

## Ringkasan Controller per US

| US | Controller File | Method Utama | Jumlah Method |
|---|---|---|---|
| US-09 | `System/MainController.php` | `importData()` · `searchData()` | 2 |
| US-07 | `System/CalculateDataController.php` | `dataPenduduk*` · `dataKepalaKeluarga*` · `dataStatusKawin*` · `dataPendidikan*` · `dataDisabilitas*` | 19 |
| US-08 | `System/CalculateDataController.php` | `dataStrukturUmur*` | 15 |

> **Catatan arsitektur:** `System/MainController.php` berfungsi sebagai **dispatcher** — `searchData()` menerima kode dari frontend, lookup ke `config/dataArray.listCalculateDataFunction`, lalu memanggil method yang sesuai di `CalculateDataController` secara dinamis.
