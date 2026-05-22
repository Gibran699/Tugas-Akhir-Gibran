# Peta Implementasi User Story — Controller Code (Iterasi 2)

**Tanggal:** 21 Mei 2026
**Scope:** Controller code per User Story (US-03, US-05, US-06, US-16)

---

## US-03 — Ganti Password

**File:** `app/Http/Controllers/Auth/MainController.php`

```php
// Baris 45–69 — Method changePassword()
function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Validasi password lama
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'message' => 'Kata sandi yang dimasukkan tidak sesuai dengan kata sandi lama.'
        ], 403);
    }

    try {
        DB::beginTransaction();

        $user->password = Hash::make($request->new_password);
        $user->save();

        DB::commit();
        return response()->json(['message' => 'Ganti sandi berhasil.'], 200);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'proses gagal'], 500);
    }
}
```

> **Catatan:** Fitur toggle visibility password dan tampilan nama + role pada header diimplementasikan di sisi frontend (Blade view / JavaScript), tidak di controller.

---

## US-16 — Hirarki Wilayah & Peta Interaktif

**File:** `app/Http/Controllers/System/WilayahController.php`

```php
// Baris 12–48 — indexKelurahan(): list kelurahan beserta info kecamatan induknya
function indexKelurahan()
{
    /*
     * Dual LEFT JOIN resolves kecamatan regardless of whether kec_id stores
     * mstr_kecamatan.id  (most common)  or  mstr_kecamatan.kode (some setups).
     * COALESCE picks whichever join matched, so one query handles both FK variants.
     */
    $rows = DB::table('mstr_kelurahan as kel')
        ->leftJoin('mstr_kecamatan as ka', 'ka.id',   '=', 'kel.kec_id')  // join by PK id
        ->leftJoin('mstr_kecamatan as kb', 'kb.kode', '=', 'kel.kec_id')  // join by kode
        ->select(
            'kel.uuid',
            'kel.kode',
            'kel.nama',
            'kel.kec_id',
            DB::raw("COALESCE(ka.id,   kb.id)                                   AS kecamatan_id"),
            DB::raw("COALESCE(ka.uuid, kb.uuid)                                 AS kecamatan_uuid"),
            DB::raw("COALESCE(ka.kode, kb.kode, '')                             AS kode_kecamatan"),
            DB::raw("UPPER(TRIM(COALESCE(ka.nama, kb.nama, 'TIDAK DIKETAHUI'))) AS nama_kecamatan")
        )
        ->whereNull('kel.deleted_at')
        ->orderBy(DB::raw("COALESCE(ka.kode, kb.kode, 9999)"), 'asc')
        ->orderBy('kel.nama', 'asc')
        ->get();

    $data = $rows->map(fn($r) => [
        'uuid'           => $r->uuid,
        'kode'           => $r->kode,
        'nama'           => $r->nama,
        'kec_id'         => $r->kec_id,
        'kecamatan_id'   => $r->kecamatan_id,
        'kecamatan_uuid' => $r->kecamatan_uuid,
        'kode_kecamatan' => $r->kode_kecamatan,
        'nama_kecamatan' => $r->nama_kecamatan,
    ]);

    return response()->json(['data' => $data], 200);
}

// Baris 50–63 — indexKecamatan(): list semua kecamatan
function indexKecamatan()
{
    $rows = DB::table('mstr_kecamatan')
        ->select('id', 'uuid', 'kode', 'nama')
        ->whereNull('deleted_at')
        ->orderBy('kode', 'asc')
        ->get()
        ->map(fn($r) => [
            'id'   => $r->id,
            'uuid' => $r->uuid,
            'kode' => $r->kode,
            'nama' => strtoupper(trim($r->nama)),
        ]);

    return response()->json(['data' => $rows], 200);
}
```

---

## US-05 — Dashboard: Ringkasan Kependudukan & Kelompok Umur

**File:** `app/Http/Controllers/MainController.php`

```php
// Baris 81–122 — dataDashBoard(): entry point, memanggil semua private method
public function dataDashBoard()
{
    $tahunSemester = config('dataArray.dataDashboard');

    $jumlahPenduduk           = $this->penduduk($tahunSemester);
    $jumlahKepalaKeluarga     = $this->kepalaKeluarga($tahunSemester);
    $jumlahPenduduk017        = $this->penduduk017($tahunSemester);
    $wajibKtp                 = $this->wajibKtp($tahunSemester);

    $top10Pekejaan            = $this->top10Pekerjaan($tahunSemester);
    $pendidikan               = $this->pendidikan($tahunSemester);
    $statusKawin              = $this->statusKawin($tahunSemester);

    $kepemilikanKtp           = $this->kepemilikanKtp($tahunSemester);
    $kepemilikanKk            = $this->kepemilikanKk($tahunSemester);
    $kepemilikanAktaLahir     = $this->kepemilikanAktaLahir($tahunSemester);
    $kepemilikanKia           = $this->kepemilikanKia($tahunSemester);
    $kepemilikanKawin         = $this->kepemilikanKawin($tahunSemester);
    $kepemilikanCerai         = $this->kepemilikanCerai($tahunSemester);

    $pendudukKelompokUmur     = $this->pendudukKelompokUmur($tahunSemester);
    $kepalaKeluargaKelompokUmur = $this->kepalaKeluargaKelompokUmur($tahunSemester);

    $dataResponse = [
        'penduduk'                      => $jumlahPenduduk,
        'kepala_keluarga'               => $jumlahKepalaKeluarga,
        'penduduk_017'                  => $jumlahPenduduk017,
        'wajib_ktp'                     => $wajibKtp,
        'top10_pekerjaan'               => $top10Pekejaan,
        'pendidikan'                    => $pendidikan,
        'status_kawin'                  => $statusKawin,
        'kepemilikan_ktp'               => $kepemilikanKtp,
        'kepemilikan_kk'                => $kepemilikanKk,
        'kepemilikan_akta_lahir'        => $kepemilikanAktaLahir,
        'kepemilikan_kia'               => $kepemilikanKia,
        'kepemilikan_kawin'             => $kepemilikanKawin,
        'kepemilikan_cerai'             => $kepemilikanCerai,
        'penduduk_kelompok_umur'        => $pendudukKelompokUmur,
        'kepala_keluarga_kelompok_umur' => $kepalaKeluargaKelompokUmur,
    ];

    return response()->json($dataResponse, 200);
}

// Baris 125–128 — total penduduk (dari tabel jenis_kelamin_penduduk)
private function penduduk($tahunSemester)
{
    return JenisKelamin::where('tahun', $tahunSemester['tahun'])
        ->where('semester', $tahunSemester['semester'])->sum('jumlah');
}

// Baris 130–133 — total kepala keluarga
private function kepalaKeluarga($tahunSemester)
{
    return \App\Models\AgregatDKB\KepalaKeluarga\JenisKelamin::where('tahun', $tahunSemester['tahun'])
        ->where('semester', $tahunSemester['semester'])->sum('jumlah');
}

// Baris 135–138 — penduduk usia 0–17 tahun (dari tabel kia)
private function penduduk017($tahunSemester)
{
    return \App\Models\Kepemilikan\KIA::where('tahun', $tahunSemester['tahun'])
        ->where('semester', $tahunSemester['semester'])->sum('jumlah_awal_jml');
}

// Baris 140–143 — jumlah wajib KTP (dari tabel ktp)
private function wajibKtp($tahunSemester)
{
    return \App\Models\Kepemilikan\Ktp::where('tahun', $tahunSemester['tahun'])
        ->where('semester', $tahunSemester['semester'])->sum('wajib_ktp_jml');
}

// Baris 218–247 — capaian kepemilikan 6 jenis dokumen
private function kepemilikanKtp($tahunSemester) {
    return \App\Models\Kepemilikan\Ktp::where('semester', $tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])->sum('ktp_jml');
}
private function kepemilikanKk($tahunSemester) {
    return \App\Models\Kepemilikan\KartuKeluarga::where('semester', $tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])->sum('memiliki_jml');
}
private function kepemilikanAktaLahir($tahunSemester) {
    return \App\Models\Kepemilikan\AktaKelahiran::where('semester', $tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])->sum('memiliki_awal_jml');
}
private function kepemilikanKia($tahunSemester) {
    return \App\Models\Kepemilikan\KIA::where('semester', $tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])->sum('memiliki_awal_jml');
}
private function kepemilikanKawin($tahunSemester) {
    return \App\Models\Kepemilikan\AktaKawin::where('semester', $tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])->sum('memiliki_akta_kawin_jml');
}
private function kepemilikanCerai($tahunSemester) {
    return \App\Models\Kepemilikan\AktaCerai::where('semester', $tahunSemester['semester'])
        ->where('tahun', $tahunSemester['tahun'])->sum('memiliki_akta_cerai_jml');
}

// Baris 250–295 — distribusi kelompok umur 16 kategori
private function pendudukKelompokUmur($tahunSemester)
{
    return \App\Models\StrukturUmur\Penduduk\KelompokUmur::select(
        DB::raw('SUM(00_04_tahun_jml) as 00_04_tahun_jml'),
        DB::raw('SUM(05_09_tahun_jml) as 05_09_tahun_jml'),
        DB::raw('SUM(10_14_tahun_jml) as 10_14_tahun_jml'),
        DB::raw('SUM(15_19_tahun_jml) as 15_19_tahun_jml'),
        DB::raw('SUM(20_24_tahun_jml) as 20_24_tahun_jml'),
        DB::raw('SUM(25_29_tahun_jml) as 25_29_tahun_jml'),
        DB::raw('SUM(30_34_tahun_jml) as 30_34_tahun_jml'),
        DB::raw('SUM(35_39_tahun_jml) as 35_39_tahun_jml'),
        DB::raw('SUM(40_44_tahun_jml) as 40_44_tahun_jml'),
        DB::raw('SUM(45_49_tahun_jml) as 45_49_tahun_jml'),
        DB::raw('SUM(50_54_tahun_jml) as 50_54_tahun_jml'),
        DB::raw('SUM(55_59_tahun_jml) as 55_59_tahun_jml'),
        DB::raw('SUM(60_64_tahun_jml) as 60_64_tahun_jml'),
        DB::raw('SUM(65_69_tahun_jml) as 65_69_tahun_jml'),
        DB::raw('SUM(70_74_tahun_jml) as 70_74_tahun_jml'),
        DB::raw('SUM(lebih_75_tahun_jml) as lebih_75_tahun_jml'),
    )
    ->where('semester', $tahunSemester['semester'])
    ->where('tahun', $tahunSemester['tahun'])
    ->first();
}
```

---

## US-06 — Dashboard: Grafik Distribusi Kependudukan

**File:** `app/Http/Controllers/MainController.php`

```php
// Baris 145–186 — top10Pekerjaan(): grafik bar horizontal Top 10 Pekerjaan
private function top10Pekerjaan($tahunSemester)
{
    $fillable   = config('dataArray.categoryJob');

    // Ekstrak kategori pekerjaan unik (hapus suffix _l / _p)
    $categories = [];
    foreach ($fillable as $field) {
        $category = preg_replace('/(_l|_p)$/', '', $field);
        $categories[$category] = $category;
    }
    $categories = array_values($categories);

    // Buat sub-query SUM per kategori
    $queries = [];
    foreach ($categories as $category) {
        $queries[] = DB::table('pekerjaan_penduduk')
            ->selectRaw("'{$category}' as pekerjaan")
            ->selectRaw("SUM(COALESCE({$category}_l, 0) + COALESCE({$category}_p, 0)) as total")
            ->where('tahun', $tahunSemester['tahun'])
            ->where('semester', $tahunSemester['semester']);
    }

    // Gabungkan dengan UNION ALL, ambil 10 teratas
    $unionQuery = array_shift($queries);
    foreach ($queries as $query) {
        $unionQuery->unionAll($query);
    }

    $topTen = DB::query()
        ->fromSub($unionQuery, 'sub')
        ->orderByDesc('total')
        ->take(10)
        ->get();

    // Format nama: snake_case → Title Case
    $topTen->transform(function ($item) {
        $item->pekerjaan = str_replace('_', ' ', ucwords($item->pekerjaan, '_'));
        return $item;
    });

    return $topTen;
}

// Baris 187–204 — pendidikan(): grafik bar Tingkat Pendidikan
private function pendidikan($tahunSemester)
{
    return \App\Models\AgregatDKB\Pendidikan\JenisKelamin::select(
        DB::raw('SUM(tidak_blm_sekolah_jml)          as tidak_blm_sekolah_jml'),
        DB::raw('SUM(belum_tamat_sd_sederajat_jml)   as belum_tamat_sd_sederajat_jml'),
        DB::raw('SUM(tamat_sd_sederajat_jml)         as tamat_sd_sederajat_jml'),
        DB::raw('SUM(sltp_sederajat_jml)             as sltp_sederajat_jml'),
        DB::raw('SUM(slta_sederajat_jml)             as slta_sederajat_jml'),
        DB::raw('SUM(diploma_i_ii_jml)               as diploma_i_ii_jml'),
        DB::raw('SUM(akademi_dipl_iii_s_muda_jml)    as akademi_dipl_iii_s_muda_jml'),
        DB::raw('SUM(diploma_iv_strata_i_jml)        as diploma_iv_strata_i_jml'),
        DB::raw('SUM(strata_ii_jml)                  as strata_ii_jml'),
        DB::raw('SUM(strata_iii_jml)                 as strata_iii_jml'),
    )
    ->where('semester', $tahunSemester['semester'])
    ->where('tahun', $tahunSemester['tahun'])
    ->first();
}

// Baris 205–217 — statusKawin(): grafik doughnut Komposisi Status Kawin
private function statusKawin($tahunSemester)
{
    return \App\Models\AgregatDKB\StatusKawin\JenisKelamin::select(
        DB::raw('SUM(COALESCE(belum_kawin_lk,  0) + COALESCE(belum_kawin_pr,  0)) as belum_kawin'),
        DB::raw('SUM(COALESCE(kawin_lk,        0) + COALESCE(kawin_pr,        0)) as sudah_kawin'),
        DB::raw('SUM(COALESCE(cerai_hidup_lk,  0) + COALESCE(cerai_hidup_pr,  0)) as cerai_hidup'),
        DB::raw('SUM(COALESCE(cerai_mati_lk,   0) + COALESCE(cerai_mati_pr,   0)) as cerai_mati'),
    )
    ->where('tahun', $tahunSemester['tahun'])
    ->where('semester', $tahunSemester['semester'])
    ->first();
}
```

---

## Ringkasan Controller per US

| US | Controller File | Method | Baris |
|---|---|---|---|
| US-03 | `Auth/MainController.php` | `changePassword()` | 45–69 |
| US-16 | `System/WilayahController.php` | `indexKecamatan()` · `indexKelurahan()` | 50–63 · 12–48 |
| US-05 | `MainController.php` | `dataDashBoard()` + `penduduk()` + `kepalaKeluarga()` + `penduduk017()` + `wajibKtp()` + `kepemilikan*()` + `pendudukKelompokUmur()` | 81–295 |
| US-06 | `MainController.php` | `top10Pekerjaan()` · `pendidikan()` · `statusKawin()` | 145–217 |
