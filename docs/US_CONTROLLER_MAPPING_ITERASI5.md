# Peta Implementasi User Story — Controller Code (Iterasi 5)

**Tanggal:** 21 Mei 2026
**Scope:** Analisis Distribusi Umur Kustom — filter rentang umur (`from`–`to`) + periode (`semester`, `tahun`)

---

## Fitur: Custom Date Range Umur (Analisis Distribusi Umur)

**File:** `app/Http/Controllers/System/CalculateDataController.php`

**Pola kunci yang membedakan dari Iterasi 3:**
- Filter umur menggunakan `whereBetween('umur', [$request->from, $request->to])` — bukan fixed kelompok umur
- `dataTitle` menyertakan label dinamis: `'title' => 'Kelompok Umur ' . $request['from'] . '-' . $request['to']`
- Semua method tetap 3 level agregasi: perkelurahan → perkecamatan → keseluruhan

---

### 1. Penduduk — Umur Kustom

```php
// Baris 2833–2882 — dateRangeAgePendudukUmur()
// Entitas: Penduduk | Tabel: umur_tunggal_penduduk | Kolom: lk, pr, jumlah
public function dateRangeAgePendudukUmur($request)
{
    // Per kelurahan
    $dataPerkelurahan = \App\Models\StrukturUmur\Penduduk\UmurTunggal::select(
        DB::raw('SUM(lk) as lk'),
        DB::raw('SUM(pr) as pr'),
        DB::raw('SUM(jumlah) as jumlah'),
        'mstr_kelurahan.nama as kelurahan_nama',
        'mstr_kecamatan.nama as kecamatan_nama'
    )
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_penduduk.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->whereBetween('umur', [$request->from, $request->to])   // ← filter rentang umur kustom
        ->where('umur_tunggal_penduduk.semester', $request['semester'])
        ->where('umur_tunggal_penduduk.tahun', $request['tahun'])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kelurahan.nama', 'mstr_kecamatan.nama')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // Per kecamatan
    $dataPerkecamatan = \App\Models\StrukturUmur\Penduduk\UmurTunggal::select(
        DB::raw('SUM(lk) as lk'),
        DB::raw('SUM(pr) as pr'),
        DB::raw('SUM(jumlah) as jumlah'),
        'mstr_kecamatan.nama as kecamatan_nama'
    )
        ->join('mstr_kelurahan', ...)->join('mstr_kecamatan', ...)
        ->whereBetween('umur', [$request->from, $request->to])
        ->where(...semester...)->where(...tahun...)
        ->groupBy('mstr_kecamatan.kode', 'mstr_kecamatan.nama')
        ->get();

    // Keseluruhan kota
    $dataKeseluruhan = \App\Models\StrukturUmur\Penduduk\UmurTunggal::select(
        DB::raw('SUM(lk) as lk'),
        DB::raw('SUM(pr) as pr'),
        DB::raw('SUM(jumlah) as jumlah'),
    )
        ->whereBetween('umur', [$request->from, $request->to])
        ->where(...semester...)->where(...tahun...)
        ->get();

    $dataTitle = [
        'semester' => $request['semester'],
        'tahun'    => $request['tahun'],
        'title'    => 'Kelompok Umur ' . $request['from'] . '-' . $request['to'],
    ];

    return response()->json([
        'dataPerkelurahan' => $dataPerkelurahan,
        'dataKeseluruhan'  => $dataKeseluruhan,
        'dataPerkecamatan' => $dataPerkecamatan,
        'dataTitle'        => $dataTitle,
    ], 200);
}
```

---

### 2. Penduduk — Status Kawin × Umur Kustom

```php
// Baris 2883–2966 — dateRangeAgePendudukStatKawin()
// Entitas: Penduduk | Tabel: status_kawin_umur_tunggal_penduduk
// Dimensi silang: Status Kawin (belum kawin, kawin, cerai hidup, cerai mati)
public function dateRangeAgePendudukStatKawin($request)
{
    $atributField = [
        'belum_kawin_lk', 'belum_kawin_pr',
        'kawin_lk',       'kawin_pr',
        'cerai_hidup_lk', 'cerai_hidup_pr',
        'cerai_mati_lk',  'cerai_mati_pr',
    ];

    $dataPerkelurahan = \App\Models\StrukturUmur\Penduduk\StatusKawinUmurTunggal::select(
        array_merge(
            array_map(fn($item) => DB::raw("SUM($item) as $item"), $atributField),
            [
                // Total LK+PR dihitung langsung di query
                DB::raw('SUM(belum_kawin_lk) + SUM(belum_kawin_pr) as belum_kawin_jml'),
                DB::raw('SUM(kawin_lk)       + SUM(kawin_pr)       as kawin_jml'),
                DB::raw('SUM(cerai_hidup_lk) + SUM(cerai_hidup_pr) as cerai_hidup_jml'),
                DB::raw('SUM(cerai_mati_lk)  + SUM(cerai_mati_pr)  as cerai_mati_jml'),
                'mstr_kelurahan.nama as kelurahan_nama',
                'mstr_kecamatan.nama as kecamatan_nama',
            ]
        )
    )
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'status_kawin_umur_tunggal_penduduk.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->whereBetween('umur', [$request->from, $request->to])
        ->where('status_kawin_umur_tunggal_penduduk.semester', $request['semester'])
        ->where('status_kawin_umur_tunggal_penduduk.tahun', $request['tahun'])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kelurahan.nama', 'mstr_kecamatan.nama')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // dataPerkecamatan & dataKeseluruhan: pola SUM sama
    // ...

    return response()->json([...], 200);
}
```

---

### 3. Kepala Keluarga — Umur Kustom

```php
// Baris 2783–2832 — dateRangeAgeKepalaKeluargaUmur()
// Entitas: Kepala Keluarga | Tabel: umur_tunggal_kepala_keluarga | Kolom: lk, pr, jumlah
public function dateRangeAgeKepalaKeluargaUmur($request)
{
    $dataPerkelurahan = \App\Models\StrukturUmur\KepalaKeluarga\UmurTunggal::select(
        DB::raw('SUM(lk)'),
        DB::raw('SUM(pr)'),
        DB::raw('SUM(jumlah)'),
        'mstr_kelurahan.nama as kelurahan_nama',
        'mstr_kecamatan.nama as kecamatan_nama'
    )
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_kepala_keluarga.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->whereBetween('umur', [$request->from, $request->to])
        ->where('umur_tunggal_kepala_keluarga.semester', $request['semester'])
        ->where('umur_tunggal_kepala_keluarga.tahun', $request['tahun'])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kelurahan.nama', 'mstr_kecamatan.nama')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // dataPerkecamatan & dataKeseluruhan: pola sama
    // ...

    return response()->json([...], 200);
}
```

---

### 4. Golongan Darah — Umur Kustom

```php
// Baris 2722–2782 — dateRangeAgeBloodTypeUmur()
// Entitas: Golongan Darah | Tabel: umur_tunggal_golongan_darah
// Dimensi: config('dataArray.categoryBlood') → A, B, O, AB + rhesus
public function dateRangeAgeBloodTypeUmur($request)
{
    $atributField = config('dataArray.categoryBlood');

    $dataPerkelurahan = \App\Models\StrukturUmur\GolonganDarah\UmurTunggal::select(
        array_merge(
            array_map(fn($item) => DB::raw("SUM($item) as $item"), $atributField),
            ['mstr_kelurahan.nama as kelurahan_nama', 'mstr_kecamatan.nama as kecamatan_nama']
        )
    )
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_golongan_darah.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->whereBetween('umur', [$request->from, $request->to])
        ->where('umur_tunggal_golongan_darah.semester', $request['semester'])
        ->where('umur_tunggal_golongan_darah.tahun', $request['tahun'])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kelurahan.nama', 'mstr_kecamatan.nama')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    // ...
    return response()->json([...], 200);
}
```

---

### 5. Disabilitas — Umur Kustom

```php
// Baris 2661–2721 — dateRangeAgeDisabilitasUmur()
// Entitas: Disabilitas | Tabel: umur_tunggal_disabilitas
// Dimensi: config('dataArray.categoryDisabilities')
public function dateRangeAgeDisabilitasUmur($request)
{
    $atributField = config('dataArray.categoryDisabilities');

    $dataPerkelurahan = \App\Models\StrukturUmur\Disabilitas\UmurTunggal::select(
        array_merge(
            array_map(fn($item) => DB::raw("SUM($item) as $item"), $atributField),
            ['mstr_kelurahan.nama as kelurahan_nama', 'mstr_kecamatan.nama as kecamatan_nama']
        )
    )
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'umur_tunggal_disabilitas.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->whereBetween('umur', [$request->from, $request->to])
        ->where('umur_tunggal_disabilitas.semester', $request['semester'])
        ->where('umur_tunggal_disabilitas.tahun', $request['tahun'])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kelurahan.nama', 'mstr_kecamatan.nama')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    $dataTitle = [
        'semester' => $request['semester'],
        'tahun'    => $request['tahun'],
        'title'    => 'Kelompok Umur ' . $request['from'] . '-' . $request['to'],
    ];

    return response()->json([...], 200);
}
```

---

### 6. Disabilitas — Pendidikan × Umur Kustom

```php
// Baris 2600–2660 — dateRangeAgeDisabilitasPendidikan()
// Entitas: Disabilitas | Tabel: pendidikan_umur_tunggal_disabilitas
// Dimensi silang: Pendidikan × config('dataArray.categoryEducationDisabilites')
public function dateRangeAgeDisabilitasPendidikan($request)
{
    $atributField = config('dataArray.categoryEducationDisabilites');

    $dataPerkelurahan = \App\Models\StrukturUmur\Disabilitas\PendidikanUmurTunggal::select(
        array_merge(
            array_map(fn($item) => DB::raw("SUM($item) as $item"), $atributField),
            ['mstr_kelurahan.nama as kelurahan_nama', 'mstr_kecamatan.nama as kecamatan_nama']
        )
    )
        ->join('mstr_kelurahan', 'mstr_kelurahan.kode', '=', 'pendidikan_umur_tunggal_disabilitas.kode_wilayah')
        ->join('mstr_kecamatan', 'mstr_kecamatan.kode', '=', 'mstr_kelurahan.kec_id')
        ->whereBetween('umur', [$request->from, $request->to])
        ->where('pendidikan_umur_tunggal_disabilitas.semester', $request['semester'])
        ->where('pendidikan_umur_tunggal_disabilitas.tahun', $request['tahun'])
        ->groupBy('mstr_kecamatan.kode', 'mstr_kelurahan.nama', 'mstr_kecamatan.nama')
        ->orderBy('mstr_kecamatan.kode', 'asc')
        ->get();

    $dataTitle = [
        'semester' => $request['semester'],
        'tahun'    => $request['tahun'],
        'title'    => 'Kelompok Umur ' . $request['from'] . '-' . $request['to'],
    ];

    return response()->json([...], 200);
}
```

---

## Daftar Lengkap 6 Method Custom Date Range

| # | Method | Baris | Entitas | Dimensi Silang | Tabel |
|---|---|---|---|---|---|
| 1 | `dateRangeAgePendudukUmur` | 2833 | Penduduk | — (lk/pr/jumlah) | `umur_tunggal_penduduk` |
| 2 | `dateRangeAgePendudukStatKawin` | 2883 | Penduduk | Status Kawin | `status_kawin_umur_tunggal_penduduk` |
| 3 | `dateRangeAgeKepalaKeluargaUmur` | 2783 | Kepala Keluarga | — (lk/pr/jumlah) | `umur_tunggal_kepala_keluarga` |
| 4 | `dateRangeAgeBloodTypeUmur` | 2722 | Golongan Darah | Jenis Goldar | `umur_tunggal_golongan_darah` |
| 5 | `dateRangeAgeDisabilitasUmur` | 2661 | Disabilitas | Jenis Disabilitas | `umur_tunggal_disabilitas` |
| 6 | `dateRangeAgeDisabilitasPendidikan` | 2600 | Disabilitas | Pendidikan | `pendidikan_umur_tunggal_disabilitas` |

---

## Perbedaan dengan Iterasi 3 (Struktur Umur Standar)

| Aspek | Iterasi 3 (US-08) | Iterasi 5 |
|---|---|---|
| Filter umur | Fixed: `kelompok_umur` (per 5 tahun) | Kustom: `whereBetween('umur', [from, to])` |
| `dataTitle` | `semester` + `tahun` saja | `semester` + `tahun` + `title: 'Kelompok Umur X-Y'` |
| Granularitas | Rentang 5 tahun (00-04, 05-09, ...) | Umur tunggal per 1 tahun, dirangkum sesuai input |
| Tabel yang digunakan | `kelompok_umur_*` | `umur_tunggal_*` |
| Config dimensi | `categoryAgeGroup`, dll | `categoryDisabilities`, `categoryBlood`, dll |

> **Catatan:** Entitas **Agama** tidak memiliki method `dateRange` tersendiri di `CalculateDataController`. Analisis agama × umur kustom belum diimplementasikan pada controller.
