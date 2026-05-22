# Peta Implementasi User Story — Controller Code (Iterasi 4)

**Tanggal:** 21 Mei 2026
**Scope:** Controller code per User Story (US-11, US-12)

---

## US-11 — Pelayanan: Laporan Kinerja & Data Harian

**File:** `app/Http/Controllers/System/CalculateDataController.php`

---

### Laporan Kinerja Capil (Format PDAK)

```php
// Baris 2335–2408 — laporanKinerjaPdakCapil(): filter rentang tanggal, agregasi 3 level
public function laporanKinerjaPdakCapil($request)
{
    // Rentang tanggal: dari pagi hari awal s.d. 23:59 hari akhir
    $from = Carbon::parse($request['form'])->addSeconds(0);
    $to   = Carbon::parse($request['to'])->addHours(23)->addMinutes(59)->addSeconds(0);

    $attributTable = [
        'cetak_akta_kelahiran_lk', 'cetak_akta_kelahiran_pr', 'cetak_akta_kelahiran_jml',
        'pembatalan_kelahiran', 'pembetulan_kelahiran',
        'cetak_akta_kematian_lk', 'cetak_akta_kematian_pr', 'cetak_akta_kematian_jml',
        'cetak_akta_kawin', 'pembatalan_akta_kawin',
        'cetak_akta_cerai', 'pembatalan_akta_cerai',
        'perubahan_wni_wna', 'perubahan_wna_wni', 'perubahan_nama', 'perubahan_jenis_kelamin',
        'pengesahan_anak_lk', 'pengesahan_anak_pr', 'pengesahan_anak_jml',
        'pengangkatan_anak_lk', 'pengangkatan_anak_pr', 'pengangkatan_anak_jml',
    ];

    // Per kelurahan: data mentah + nama wilayah dari JOIN
    $dataPerkelurahan = Capil::select([
        'laporan_kinerja_capil_format_pdak.*',
        'mstr_kelurahan.nama as kelurahan_nama',
        'mstr_kecamatan.nama as kecamatan_nama'
    ])
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'laporan_kinerja_capil_format_pdak.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->whereBetween('tanggal_laporan', [$from, $to])
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // Per kecamatan: SUM per kecamatan
    $dataPerkecamatan = Capil::select(array_merge(
        array_map(fn($item) => DB::raw("SUM($item) as $item"), $attributTable),
        ['mstr_kecamatan.nama as kecamatan_nama']
    ))
        ->join('mstr_kelurahan', ...)
        ->join('mstr_kecamatan', ...)
        ->whereBetween('tanggal_laporan', [$from, $to])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
        ->get();

    // Keseluruhan kota: total SUM
    $dataKeseluruhan = Capil::select(
        array_map(fn($item) => DB::raw("SUM($item) as $item"), $attributTable)
    )->whereBetween('tanggal_laporan', [$from, $to])->get();

    return response()->json([
        'dataPerkelurahan' => $dataPerkelurahan,
        'dataKeseluruhan'  => $dataKeseluruhan,
        'dataPerkecamatan' => $dataPerkecamatan,
        'dataTitle'        => ['dari' => $request['from'], 'sampai' => $request['to']],
    ], 200);
}
```

---

### Laporan Kinerja Dafduk (Format PDAK)

```php
// Baris 2409–2485 — laporanKinerjaPdakDafduk(): pola identik dengan Capil, beda kolom
public function laporanKinerjaPdakDafduk($request)
{
    $from = Carbon::parse($request['form'])->addSeconds(0);
    $to   = Carbon::parse($request['to'])->addHours(23)->addMinutes(59)->addSeconds(0);

    $attributTable = [
        'penerbitan_kk', 'perubahan_kk',
        'penerbitan_nik_wni_lk', 'penerbitan_nik_wni_pr', 'penerbitan_nik_wni_jml',
        'penerbitan_nik_oa_lk',  'penerbitan_nik_oa_pr',  'penerbitan_nik_oa_jml',
        'pencetakan_kia_lk',     'pencetakan_kia_pr',      'pencetakan_kia_jml',
        'ktp_el_rekam_lk',       'ktp_el_rekam_pr',        'ktp_el_rekam_jml',
        'ktp_el_cetak_lk',       'ktp_el_cetak_pr',        'ktp_el_cetak_jml',
        'jml_surat_pindah',      'jml_pindah_lk',          'jml_pindah_pr',  'jml_pindah_jml',
        'jml_surat_datang',      'jml_datang_lk',          'jml_datang_pr',  'jml_datang_jml',
    ];

    $dataPerkelurahan = Dafduk::select([
        'laporan_kinerja_dafduk_format_pdak.*',
        'mstr_kelurahan.nama as kelurahan_nama',
        'mstr_kecamatan.nama as kecamatan_nama'
    ])
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'laporan_kinerja_dafduk_format_pdak.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->whereBetween('tanggal_laporan', [$from, $to])
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // dataPerkecamatan & dataKeseluruhan: pola SUM sama seperti Capil
    // ...

    return response()->json([...], 200);
}
```

---

### Pelayanan Online

```php
// Baris 2486–2500 — dataPelayananOnline(): forward ke API eksternal
public function dataPelayananOnline($request)
{
    $dataTitle = ['start' => $request['start'], 'finish' => $request['finish']];
    try {
        // Tidak menggunakan tabel lokal — data dari API eksternal
        $data = $this->apiService->post('/api/data_layanan_online', $request->all());
        return response()->json($data, 200);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
```

---

### Data Harian Cetak e-KTP

```php
// Baris 2501–2549 — dataCetakEktp(): KTP API, harian, support detail modal
public function dataCetakEktp($request)
{
    try {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'draw'       => 'sometimes|integer',
            'detailed'   => 'sometimes|boolean'
        ]);

        // Konversi format: Y-m-d (form) → d-m-Y (API)
        $apiStartDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->format('d-m-Y');
        $apiEndDate   = Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->format('d-m-Y');

        $apiResponse = $this->ktpApi->getKtpData($apiStartDate, $apiEndDate);

        // Mode detail (modal): kembalikan per-user harian
        if ($request->input('detailed')) {
            return response()->json([
                'data' => ['daily_data' => [
                    $request->input('start_date') => [
                        'users'      => $apiResponse['data'],
                        'date_total' => array_sum(array_column($apiResponse['data'], 'JUMLAH'))
                    ]
                ]]
            ]);
        }

        // Mode DataTable: kembalikan format DataTables server-side
        return response()->json([
            'draw'            => $request->input('draw', 1),
            'recordsTotal'    => count($apiResponse['data']),
            'recordsFiltered' => count($apiResponse['data']),
            'data'            => $apiResponse['data']
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'draw' => $request->input('draw', 1),
            'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []], 500);
    }
}
```

---

### Data Harian Perekaman e-KTP

```php
// Baris 2550–2598 — dataPerekaman(): Perekaman API, pola identik dengan dataCetakEktp
public function dataPerekaman($request)
{
    try {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'draw'       => 'sometimes|integer',
            'detailed'   => 'sometimes|boolean'
        ]);

        $apiStartDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'))->format('d-m-Y');
        $apiEndDate   = Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->format('d-m-Y');

        // Memanggil perekamanService (bukan ktpApi)
        $apiResponse = $this->perekamanApi->getData($apiStartDate, $apiEndDate);

        if ($request->input('detailed')) {
            return response()->json([
                'data' => ['daily_data' => [
                    $request->input('start_date') => [
                        'users'      => $apiResponse['data'],
                        'date_total' => array_sum(array_column($apiResponse['data'], 'JUMLAH'))
                    ]
                ]]
            ]);
        }

        return response()->json([
            'draw'            => $request->input('draw', 1),
            'recordsTotal'    => count($apiResponse['data']),
            'recordsFiltered' => count($apiResponse['data']),
            'data'            => $apiResponse['data']
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'draw' => 1,
            'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []], 500);
    }
}
```

---

## US-12 — Kepemilikan Dokumen Kependudukan

**File:** `app/Http/Controllers/System/CalculateDataController.php`

Pola umum: **3 level agregasi** + filter `semester`, `tahun`, dan **optional `keterangan`/`agama`**. Setiap method menghitung persentase cakupan (`persen_awal`, `persen_dinamis`) via `IF(SUM(...) = 0, 0, ...)`.

**Contoh pola (Akta Kelahiran — paling kompleks, baris 1023–1128):**

```php
// Baris 1023–1128 — dataKepemilikanAktaKelahiran()
// Filter tambahan: keterangan (rentang usia: Semua Usia / 0-1 / 0-4 / 0-5 / 0-18 tahun)
public function dataKepemilikanAktaKelahiran($request)
{
    $categoryAktaKelahiranOwnerShip = config('dataArray.categoryAktaKelahiranOwnerShip');

    $dataPerkelurahan = KepemilikanAktaKelahiran::select(array_merge([
        'mstr_kelurahan.nama as kelurahan_nama',
        'mstr_kecamatan.nama as kecamatan_nama',
        DB::raw('COALESCE(SUM(wajib_akta_awal_jml), 0) as total_wajib_awal'),
        DB::raw('COALESCE(SUM(memiliki_awal_jml), 0) as total_memiliki_awal'),
        DB::raw('COALESCE(SUM(wajib_akta_dinamis_jml), 0) as total_wajib_dinamis'),
        DB::raw('COALESCE(SUM(memiliki_dinamis_jml), 0) as total_memiliki_dinamis'),
        // Persentase cakupan: hindari divide-by-zero
        DB::raw('IF(SUM(wajib_akta_awal_jml) = 0, 0,
            (SUM(memiliki_awal_jml) / SUM(wajib_akta_awal_jml)) * 100) as persen_awal'),
        DB::raw('IF(SUM(wajib_akta_dinamis_jml) = 0, 0,
            (SUM(memiliki_dinamis_jml) / SUM(wajib_akta_dinamis_jml)) * 100) as persen_dinamis'),
        // Label keterangan usia dari kode integer
        DB::raw("CASE
            WHEN keterangan = 1 THEN 'Semua Usia'
            WHEN keterangan = 2 THEN '0-1 Tahun'
            WHEN keterangan = 3 THEN '0-4 Tahun'
            WHEN keterangan = 4 THEN '0-5 Tahun'
            WHEN keterangan = 5 THEN '0-18 Tahun Kurang 1 Hari'
            ELSE 'Tidak Diketahui'
        END as keterangan"),
    ], array_map(fn($item) => DB::raw("COALESCE(SUM($item), 0) as $item"), $categoryAktaKelahiranOwnerShip)))
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'akta_kelahiran.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->where('akta_kelahiran.semester', $request['semester'])
        ->where('akta_kelahiran.tahun', $request['tahun'])
        ->where('akta_kelahiran.keterangan', $request['keterangan'])  // filter rentang usia
        ->groupBy('mstr_kelurahan.nama', 'mstr_kecamatan.nama', 'mstr_kecamatan.kode', 'keterangan')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // dataKeseluruhan & dataPerkecamatan: pola SUM sama, GROUP BY berbeda
    // ...

    return response()->json([
        'dataPerkelurahan' => $dataPerkelurahan,
        'dataKeseluruhan'  => $dataKeseluruhan,
        'dataPerkecamatan' => $dataPerkecamatan,
        'dataTitle'        => ['semester' => $request['semester'], 'tahun' => $request['tahun']],
    ], 200);
}
```

**Daftar lengkap 8 method Kepemilikan Dokumen:**

| # | Method | Baris | Dokumen | Filter Khusus |
|---|---|---|---|---|
| 1 | `dataKepemilikanAktaKelahiran` | 1023 | Akta Kelahiran | `keterangan` (rentang usia 1–5) |
| 2 | `dataKepemilikanAktaPerkawinan` | 1129 | Akta Kawin (Sipil) | — |
| 3 | `dataKepemilikanAktaPerkawinanAgama` | 1195 | Akta Kawin (Agama) | `categoryReligiosOwnerShip` (per agama) |
| 4 | `dataKepemilikanAktaCerai` | 1242 | Akta Cerai (Sipil) | — |
| 5 | `dataKepemilikanAktaCeraiAgama` | 1305 | Akta Cerai (Agama) | `categoryReligiosOwnerShip` (per agama) |
| 6 | `dataKepemilikanKia` | 1352 | KIA | `categoryKiaOwnerShip` |
| 7 | `dataKepemilikanKartuKeluarga` | 1406 | Kartu Keluarga | — |
| 8 | `dataKepemilikanKTP` | 1467 | KTP | — |

---

## Ringkasan Controller per US

| US | Controller File | Method | Jumlah |
|---|---|---|---|
| US-11 | `System/CalculateDataController.php` | `laporanKinerjaPdakCapil()` · `laporanKinerjaPdakDafduk()` · `dataPelayananOnline()` · `dataCetakEktp()` · `dataPerekaman()` | 5 |
| US-12 | `System/CalculateDataController.php` | `dataKepemilikan*` (8 method) | 8 |

> **Catatan perbedaan sumber data US-11:**
> - `laporanKinerjaPdakCapil` & `laporanKinerjaPdakDafduk` → **tabel lokal** `laporan_kinerja_*_format_pdak`, filter `whereBetween tanggal_laporan`
> - `dataPelayananOnline` → **API eksternal** `ExternalApiService` (Bearer token)
> - `dataCetakEktp` & `dataPerekaman` → **API eksternal** `KtpApiService` / `perekamanService` (HTTP Basic Auth ke `ektp.samarindakota.go.id`)
