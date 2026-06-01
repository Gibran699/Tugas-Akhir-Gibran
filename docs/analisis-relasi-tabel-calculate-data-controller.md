# Analisis Relasi Tabel — CalculateDataController
### Disusun Berdasarkan Hierarki: Fitur → Sub-Fitur → Halaman

> **File sumber:** `app/Http/Controllers/System/CalculateDataController.php`  
> **Tanggal analisis:** 24 Mei 2026  
> **Total method yang dianalisis:** 53 method  
> **Total tabel fitur:** 44 tabel  
> **Tabel JOIN universal:** `mstr_kelurahan`, `mstr_kecamatan` (Iterasi 2)

---

## Keterangan Kolom Tabel

| Kolom | Keterangan |
|---|---|
| **Halaman (View)** | Nama file blade di `resources/views/` |
| **Method Controller** | Nama method di `CalculateDataController` |
| **Tabel Utama** | Tabel fitur yang di-query sebagai FROM |
| **JOIN ke** | Tabel yang di-JOIN untuk mengambil nama wilayah |
| **GROUP BY Tambahan** | Kolom dimensi selain kecamatan/kelurahan yang di-GROUP |
| **Filter** | Parameter yang digunakan untuk memfilter data |

---

## Pola JOIN Universal (Berlaku di Semua Fitur)

```sql
[tabel_utama]
  JOIN mstr_kelurahan  ON mstr_kelurahan.kode  = [tabel_utama].kode_wilayah
  JOIN mstr_kecamatan  ON mstr_kecamatan.kode  = mstr_kelurahan.kec_id
```

---

## FITUR 1 — Agregat DKB
> **Direktori view:** `resources/views/agregat_dkb/`  
> **Filter standar:** `semester`, `tahun`  
> **Struktur respons:** `dataPerkelurahan`, `dataKeseluruhan` (flat SUM), `dataPerkecamatan` (GROUP BY kecamatan)

---

### Sub-Fitur: Penduduk
> `resources/views/agregat_dkb/penduduk/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `penduduk/agama_index` | `dataPendudukAgama` | `agama_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryReligious` config |
| `penduduk/jenis_kelamin_index` | `dataPendudukJenisKelamin` | `jenis_kelamin_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | — |
| `penduduk/golongan_darah_index` | `dataPendudukGoldar` | `golongan_darah_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryBlood` config |
| `penduduk/hubungan_keluarga_index` | `dataPendudukHubKel` | `hubungan_keluarga_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | — |
| `penduduk/pekerjaan_index` | `dataPendudukPekerjaan` | `pekerjaan_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryJob` config |

**Relasi tabel yang dijadikan satu pada sub-fitur ini:**
```
agama_penduduk           → JOIN mstr_kelurahan → JOIN mstr_kecamatan
jenis_kelamin_penduduk   → JOIN mstr_kelurahan → JOIN mstr_kecamatan
golongan_darah_penduduk  → JOIN mstr_kelurahan → JOIN mstr_kecamatan
hubungan_keluarga_penduduk → JOIN mstr_kelurahan → JOIN mstr_kecamatan
pekerjaan_penduduk       → JOIN mstr_kelurahan → JOIN mstr_kecamatan
```

---

### Sub-Fitur: Kepala Keluarga
> `resources/views/agregat_dkb/kepala_keluarga/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `kepala_keluarga/agama_index` | `dataKepalaKeluargaAgama` | `agama_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryReligious` config |
| `kepala_keluarga/jenis_kelamin_index` | `dataKepalaKeluargaJenisKelamin` | `jenis_kelamin_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | — | — |
| `kepala_keluarga/pekerjaan_index` | `dataKepalaKeluargaPekerjaan` | `pekerjaan_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryJob` config |
| `kepala_keluarga/pendidikan_index` | `dataKepalaKeluargaPendidikan` | `pendidikan_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryEducation` config |
| `kepala_keluarga/status_kawin_index` | `dataKelapaKeluargaStatusKawin` | `status_kawin_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryMarriageStatus` config |

**Relasi tabel yang dijadikan satu pada sub-fitur ini:**
```
agama_kepala_keluarga          → JOIN mstr_kelurahan → JOIN mstr_kecamatan
jenis_kelamin_kepala_keluarga  → JOIN mstr_kelurahan → JOIN mstr_kecamatan
pekerjaan_kepala_keluarga      → JOIN mstr_kelurahan → JOIN mstr_kecamatan
pendidikan_kepala_keluarga     → JOIN mstr_kelurahan → JOIN mstr_kecamatan
status_kawin_kepala_keluarga   → JOIN mstr_kelurahan → JOIN mstr_kecamatan
```

---

### Sub-Fitur: Status Kawin
> `resources/views/agregat_dkb/status_kawin/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `status_kawin/agama_index` | `dataStatusKawinAgama` | `status_kawin_penduduk_agama` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryReligious` config |
| `status_kawin/jenis_kelamin_index` | `dataStatusKawinJenisKelamin` | `status_kawin_penduduk_jenis_kelamin` | `mstr_kelurahan`, `mstr_kecamatan` | — | — |
| `status_kawin/pekerjaan_index` | `dataStatusKawinPekerjaan` | `status_kawin_penduduk_pekerjaan` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryJob` config |

**Relasi tabel yang dijadikan satu pada sub-fitur ini:**
```
status_kawin_penduduk_agama          → JOIN mstr_kelurahan → JOIN mstr_kecamatan
status_kawin_penduduk_jenis_kelamin  → JOIN mstr_kelurahan → JOIN mstr_kecamatan
status_kawin_penduduk_pekerjaan      → JOIN mstr_kelurahan → JOIN mstr_kecamatan
```

---

### Sub-Fitur: Pendidikan
> `resources/views/agregat_dkb/pendidikan/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `pendidikan/jenis_kelamin_index` | `dataPendidikanPendudukJenisKelamin` | `jenis_kelamin_pendidikan` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryEducation` config |
| `pendidikan/pekerjaan_index` | `dataPendidikanPekerjaan` | `pendidikan_penduduk_pekerjaan` | `mstr_kelurahan`, `mstr_kecamatan` | `pendidikan` ⚠️ | `categoryJob` config, dataKeseluruhan GROUP BY `pendidikan` |
| `pendidikan/golongan_darah_index` | `dataPendidikanGolonganDarah` | `golongan_darah_pendidikan` | `mstr_kelurahan`, `mstr_kecamatan` | `keterangan` ⚠️ | `categoryBlood` config, dataKeseluruhan GROUP BY `keterangan` |

**Relasi tabel yang dijadikan satu pada sub-fitur ini:**
```
jenis_kelamin_pendidikan     → JOIN mstr_kelurahan → JOIN mstr_kecamatan
pendidikan_penduduk_pekerjaan → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                               + GROUP BY pendidikan (dimensi jenjang pendidikan)
golongan_darah_pendidikan    → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                               + GROUP BY keterangan (dimensi golongan darah)
```

---

### Sub-Fitur: Disabilitas
> `resources/views/agregat_dkb/disabilitas/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `disabilitas/jenis_kelamin_index` | `dataDisabilitasJenisKelamin` | `jenis_kelamin_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryDisabilities` config |
| `disabilitas/pekerjaan_index` | `dataDisabilitasPekerjaan` | `pekerjaan_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | `keterangan` ⚠️ | `categoryJob`, GROUP BY `keterangan` (jenis disabilitas) |
| `disabilitas/pendidikan_index` | `dataDisabilitasPendidikan` | `pendidikan_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | `keterangan` ⚠️ | `categoryEducation`, GROUP BY `keterangan` (jenis disabilitas) |

**Relasi tabel yang dijadikan satu pada sub-fitur ini:**
```
jenis_kelamin_disabilitas → JOIN mstr_kelurahan → JOIN mstr_kecamatan
pekerjaan_disabilitas     → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                            + GROUP BY keterangan (dimensi jenis disabilitas)
pendidikan_disabilitas    → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                            + GROUP BY keterangan (dimensi jenis disabilitas)
```

---

## FITUR 2 — Struktur Umur (Kelompok Umur)
> **Direktori view:** `resources/views/struktur_umur/`  
> **Filter standar:** `semester`, `tahun`  
> **Filter tambahan:** `kelompok_umur` (digunakan sebagai GROUP BY dimensi)  
> **Struktur respons:** `dataPerkelurahan`, `dataKeseluruhan` (GROUP BY `kelompok_umur`), `dataPerkecamatan` (GROUP BY kecamatan + `kelompok_umur`)

---

### Sub-Fitur: Agama
> `resources/views/struktur_umur/agama/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `agama/kelompok_umur_index` | `dataStrukturUmurAgamaKelompokUmur` | `kelompok_umur_agama` | `mstr_kelurahan`, `mstr_kecamatan` | `kelompok_umur` | `categoryReligious` config |

**Relasi tabel:**
```
kelompok_umur_agama → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                      GROUP BY kelompok_umur (dimensi rentang usia)
```

---

### Sub-Fitur: Disabilitas
> `resources/views/struktur_umur/disabilitas/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `disabilitas/kelompok_umur_index` | `dataStrukturUmurDisabilitasKelompokUmur` | `kelompok_umur_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | `kelompok_umur` | `categoryDisabilities` config |
| `disabilitas/umur_tunggal_index` | `dataStrukturUmurDisabilitasUmurTunggal` | `umur_tunggal_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | `umur` | Filter request `umur` spesifik |
| `disabilitas/pendidikan_umur_tunggal_index` | `dataStrukturUmurDisabilitasPendidikan` | `pendidikan_umur_tunggal_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | `umur` | `categoryEducationDisabilites`, filter `umur` |
| `disabilitas/usia_sekolah_kelompok_umur_index` | `dataStrukturUmurDisabilitasUsiaSekolah` | `usia_sekolah_kelompok_umur_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryAgeSchollDisabilities` config |

**Relasi tabel:**
```
kelompok_umur_disabilitas              → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                                         GROUP BY kelompok_umur
umur_tunggal_disabilitas               → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                                         GROUP BY umur (filter umur tunggal)
pendidikan_umur_tunggal_disabilitas    → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                                         GROUP BY umur (filter umur tunggal)
usia_sekolah_kelompok_umur_disabilitas → JOIN mstr_kelurahan → JOIN mstr_kecamatan
```

---

### Sub-Fitur: Golongan Darah
> `resources/views/struktur_umur/golongan_darah/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `golongan_darah/kelompok_umur_index` | `dataStrukturUmurGolonganDarahKelompokUmur` | `kelompok_umur_golongan_darah` | `mstr_kelurahan`, `mstr_kecamatan` | `kelompok_umur` | `categoryBlood` config |
| `golongan_darah/umur_tunggal_index` | `dataStrukturUmurGolonganDarahUmurTunggal` | `umur_tunggal_golongan_darah` | `mstr_kelurahan`, `mstr_kecamatan` | `umur` | Filter request `umur` spesifik |

**Relasi tabel:**
```
kelompok_umur_golongan_darah → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                               GROUP BY kelompok_umur
umur_tunggal_golongan_darah  → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                               GROUP BY umur (filter umur tunggal)
```

---

### Sub-Fitur: Kepala Keluarga
> `resources/views/struktur_umur/kepala_keluarga/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `kepala_keluarga/kelompok_umur_index` | `dataStrukturUmurKepalaKeluargaKelompokUmur` | `kelompok_umur_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryAgeGroup` (flat SUM) |
| `kepala_keluarga/status_kawin_kelompok_umur_index` | `dataStrukturUmurKepalaKeluargaStatusKawin` | `status_kawin_kelompok_umur_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryAgeGroupMarriageStatus` |
| `kepala_keluarga/umur_tunggal_index` | `dataStrukturUmurKepalaKeluargaUmurTunggal` | `umur_tunggal_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | `umur` | SUM(lk/pr/jumlah), filter `umur` |

**Relasi tabel:**
```
kelompok_umur_kepala_keluarga              → JOIN mstr_kelurahan → JOIN mstr_kecamatan
status_kawin_kelompok_umur_kepala_keluarga → JOIN mstr_kelurahan → JOIN mstr_kecamatan
umur_tunggal_kepala_keluarga               → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                                             GROUP BY umur (filter umur tunggal)
```

---

### Sub-Fitur: Penduduk
> `resources/views/struktur_umur/penduduk/`

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY Tambahan | Catatan |
|---|---|---|---|---|---|
| `penduduk/kelompok_umur_index` | `dataSturukUmurPendudukKelompokUmur` ⚠️ | `kelompok_umur_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryAgeGroup` (flat SUM) |
| `penduduk/status_kawin_kelompok_umur_index` | `dataStrukturUmurPendudukStatusKawinKelompokUmur` | `status_kawin_kelompok_umur_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryAgeGroupMarriageStatus` |
| `penduduk/umur_tunggal_index` | `dataStrukturUmurPendudukUmurTunggal` | `umur_tunggal_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | `umur` | SUM(lk/pr/jumlah), filter `umur` |
| `penduduk/status_kawin_umur_tunggal_index` | `dataStrukturUmurPendudukStatuKawinUmurTunggal` ⚠️ | `status_kawin_umur_tunggal_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | `umur` | `categoryMarriageStatus`, filter `umur` |
| `penduduk/usia_sekolah_index` | `dataStrukturUmurPendudukUsiaSekolah` | `usia_sekolah_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | SUM kolom 4 jenjang sekolah |
| `penduduk/usia_muda_produkif_tua_index` | `dataStrukturUmurPendudukUsiaMudaProduktifTua` | `usia_muda_produktif_tua_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | — | SUM(usia_muda/produktif/tua) |

**Relasi tabel:**
```
kelompok_umur_penduduk                → JOIN mstr_kelurahan → JOIN mstr_kecamatan
status_kawin_kelompok_umur_penduduk   → JOIN mstr_kelurahan → JOIN mstr_kecamatan
umur_tunggal_penduduk                 → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                                        GROUP BY umur (filter umur tunggal)
status_kawin_umur_tunggal_penduduk    → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                                        GROUP BY umur (filter umur tunggal)
usia_sekolah_penduduk                 → JOIN mstr_kelurahan → JOIN mstr_kecamatan
usia_muda_produktif_tua_penduduk      → JOIN mstr_kelurahan → JOIN mstr_kecamatan
```

---

## FITUR 3 — Struktur Umur (Custom Date Range / Rentang Usia)
> **Direktori view:** `resources/views/costum_date_range/`  
> **Filter:** `semester`, `tahun`, **`from` (umur awal)**, **`to` (umur akhir)**  
> **Perbedaan:** Filter menggunakan `whereBetween('umur', [$from, $to])` — bukan umur tunggal melainkan **rentang umur yang dapat dikustomisasi**  
> **Catatan:** Method-method ini menggunakan **tabel yang sama** dengan Fitur Struktur Umur (Iterasi 3) namun dengan filter berbeda

---

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | GROUP BY | Catatan |
|---|---|---|---|---|---|
| `costum_date_range/disabilitas_index` | `dateRangeAgeDisabilitasUmur` | `umur_tunggal_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | kecamatan + kelurahan | `whereBetween(umur, [from, to])` |
| `costum_date_range/disabilitas_pendidikan_index` | `dateRangeAgeDisabilitasPendidikan` | `pendidikan_umur_tunggal_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | kecamatan + kelurahan | `whereBetween(umur, [from, to])` |
| `costum_date_range/golongan_darah_index` | `dateRangeAgeBloodTypeUmur` | `umur_tunggal_golongan_darah` | `mstr_kelurahan`, `mstr_kecamatan` | kecamatan + kelurahan | `whereBetween(umur, [from, to])` |
| `costum_date_range/kepala_keluarga_index` | `dateRangeAgeKepalaKeluargaUmur` | `umur_tunggal_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | kecamatan + kelurahan | `whereBetween(umur, [from, to])` |
| `costum_date_range/penduduk_index` | `dateRangeAgePendudukUmur` | `umur_tunggal_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | kecamatan + kelurahan | `whereBetween(umur, [from, to])` |
| `costum_date_range/stat_kawin_index` | `dateRangeAgePendudukStatKawin` | `status_kawin_umur_tunggal_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | kecamatan + kelurahan | `whereBetween(umur, [from, to])` + kalkulasi `_jml` inline |

**Relasi tabel yang dijadikan satu pada fitur ini (semua menggunakan tabel yang sama dengan Fitur Struktur Umur):**
```
umur_tunggal_disabilitas           → JOIN mstr_kelurahan → JOIN mstr_kecamatan + WHERE umur BETWEEN from AND to
pendidikan_umur_tunggal_disabilitas → JOIN mstr_kelurahan → JOIN mstr_kecamatan + WHERE umur BETWEEN from AND to
umur_tunggal_golongan_darah        → JOIN mstr_kelurahan → JOIN mstr_kecamatan + WHERE umur BETWEEN from AND to
umur_tunggal_kepala_keluarga       → JOIN mstr_kelurahan → JOIN mstr_kecamatan + WHERE umur BETWEEN from AND to
umur_tunggal_penduduk              → JOIN mstr_kelurahan → JOIN mstr_kecamatan + WHERE umur BETWEEN from AND to
status_kawin_umur_tunggal_penduduk → JOIN mstr_kelurahan → JOIN mstr_kecamatan + WHERE umur BETWEEN from AND to
```

---

## FITUR 4 — Kepemilikan Dokumen Kependudukan
> **Direktori view:** `resources/views/kepemilikan/`  
> **Filter standar:** `semester`, `tahun`  
> **Filter tambahan akta kelahiran:** `keterangan` (kategori usia: semua usia, 0-1, 0-4, 0-5, 0-18)  
> **Kalkulasi khusus:** Setiap method menghitung persentase kepemilikan via `IF(SUM(wajib)/SUM(memiliki)*100, 0)`

---

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | Kalkulasi Khusus | Catatan |
|---|---|---|---|---|---|
| `kepemilikan/akta_kelahiran` | `dataKepemilikanAktaKelahiran` | `akta_kelahiran` | `mstr_kelurahan`, `mstr_kecamatan` | `persen_awal`, `persen_dinamis`, CASE keterangan usia | Filter tambahan `keterangan` (kategori usia) |
| `kepemilikan/akta_kawin` | `dataKepemilikanAktaPerkawinan` | `akta_kawin` | `mstr_kelurahan`, `mstr_kecamatan` | `persen_memiliki` | — |
| `kepemilikan/akta_kawin_agama` | `dataKepemilikanAktaPerkawinanAgama` | `akta_kawin_agama` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryReligiosOwnerShip` config |
| `kepemilikan/akta_cerai` | `dataKepemilikanAktaCerai` | `akta_cerai` | `mstr_kelurahan`, `mstr_kecamatan` | `persen_memiliki` | — |
| `kepemilikan/akta_cerai_agama` | `dataKepemilikanAktaCeraiAgama` | `akta_cerai_agama` | `mstr_kelurahan`, `mstr_kecamatan` | — | `categoryReligiosOwnerShip` config |
| `kepemilikan/kia` | `dataKepemilikanKia` | `kia` | `mstr_kelurahan`, `mstr_kecamatan` | `persen_awal`, `persen_dinamis` | `categoryKiaOwnerShip` config |
| `kepemilikan/kartu_keluarga` | `dataKepemilikanKartuKeluarga` | `kartu_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | `persen_memiliki` | — |
| `kepemilikan/ktp` | `dataKepemilikanKTP` | `ktp` | `mstr_kelurahan`, `mstr_kecamatan` | `persen_memiliki_ktp`, `persen_sudah_rekam` | 15 kolom atribut |

**Relasi tabel yang dijadikan satu pada fitur ini:**
```
akta_kelahiran  → JOIN mstr_kelurahan → JOIN mstr_kecamatan + CASE WHEN keterangan
akta_kawin      → JOIN mstr_kelurahan → JOIN mstr_kecamatan + IF(SUM persen)
akta_kawin_agama → JOIN mstr_kelurahan → JOIN mstr_kecamatan
akta_cerai      → JOIN mstr_kelurahan → JOIN mstr_kecamatan + IF(SUM persen)
akta_cerai_agama → JOIN mstr_kelurahan → JOIN mstr_kecamatan
kia             → JOIN mstr_kelurahan → JOIN mstr_kecamatan + IF(SUM persen)
kartu_keluarga  → JOIN mstr_kelurahan → JOIN mstr_kecamatan + IF(SUM persen)
ktp             → JOIN mstr_kelurahan → JOIN mstr_kecamatan + IF(SUM persen x2)
```

---

## FITUR 5 — Laporan Pelayanan
> **Direktori view:** `resources/views/laporan_pelayanan/`

---

### Sub-Fitur: Laporan Kinerja PDAK (Database)
> **Filter:** `tanggal_laporan BETWEEN from AND to` — **berbeda dari semua fitur lain** (tidak pakai `semester`/`tahun`)

| Halaman (View) | Method Controller | Tabel Utama | JOIN ke | Filter | Catatan |
|---|---|---|---|---|---|
| `laporan_pelayanan/layanan_capil_index` | `laporanKinerjaPdakCapil` | `laporan_kinerja_capil_format_pdak` | `mstr_kelurahan`, `mstr_kecamatan` | `whereBetween('tanggal_laporan', [from, to])` | 22 kolom atribut |
| `laporan_pelayanan/layanan_dafduk_index` | `laporanKinerjaPdakDafduk` | `laporan_kinerja_dafduk_format_pdak` | `mstr_kelurahan`, `mstr_kecamatan` | `whereBetween('tanggal_laporan', [from, to])` | 24 kolom atribut |

**Relasi tabel:**
```
laporan_kinerja_capil_format_pdak  → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                                     WHERE tanggal_laporan BETWEEN from AND to
laporan_kinerja_dafduk_format_pdak → JOIN mstr_kelurahan → JOIN mstr_kecamatan
                                     WHERE tanggal_laporan BETWEEN from AND to
```

---

### Sub-Fitur: Layanan Eksternal (External API — Tanpa Akses Database)
> ⚠️ Ketiga halaman ini **tidak melakukan query database** sama sekali. Data diambil 100% dari layanan API eksternal.

| Halaman (View) | Method Controller | Sumber Data | Service Class | Filter |
|---|---|---|---|---|
| `laporan_pelayanan/layanan_ektp_index` | `dataCetakEktp` | External API | `KtpApiService::getKtpData()` | `start_date`, `end_date` (format d-m-Y) |
| `laporan_pelayanan/layanan_perekaman_index` | `dataPerekaman` | External API | `perekamanService::getData()` | `start_date`, `end_date` (format d-m-Y) |
| `laporan_pelayanan/online/index` | `dataPelayananOnline` | External API | `ExternalApiService::post()` | `start`, `finish` |

---

## Rekapitulasi Akhir

### Jumlah Halaman dan Tabel per Fitur

| Fitur | Jumlah Sub-Fitur | Jumlah Halaman | Jumlah Tabel DB | Tabel JOIN Wilayah |
|---|:---:|:---:|:---:|:---:|
| Agregat DKB | 5 | 19 | 19 | `mstr_kelurahan`, `mstr_kecamatan` |
| Struktur Umur (Kelompok) | 5 | 16 | 16 | `mstr_kelurahan`, `mstr_kecamatan` |
| Struktur Umur (Date Range) | — | 6 | 6* | `mstr_kelurahan`, `mstr_kecamatan` |
| Kepemilikan Dokumen | — | 8 | 8 | `mstr_kelurahan`, `mstr_kecamatan` |
| Laporan Kinerja PDAK | — | 2 | 2 | `mstr_kelurahan`, `mstr_kecamatan` |
| Layanan Eksternal API | — | 3 | 0 | — |
| **TOTAL** | **10** | **54** | **51** | |

> \* 6 tabel Date Range adalah **tabel yang sama** dengan Struktur Umur (tidak tabel baru)

---

### Anomali Teknis

| # | Tipe | Detail |
|---|---|---|
| 1 | ⚠️ Typo method | `dataSturukUmurPendudukKelompokUmur` — `Sturuk` harusnya `Struktur` |
| 2 | ⚠️ Typo method | `dataStrukturUmurPendudukStatuKawinUmurTunggal` — `Statu` harusnya `Status` |
| 3 | ⚠️ Typo response key | `dataStrukturUmurDisabilitasUmurTunggal` mengembalikan `dataTilte` bukan `dataTitle` |
| 4 | ⚠️ Filter berbeda | Laporan Kinerja PDAK memakai `tanggal_laporan BETWEEN`, bukan `semester`/`tahun` |
| 5 | ⚠️ dateKeseluruhan berbeda | 4 method Agregat DKB (`dataPendidikanPekerjaan`, `dataPendidikanGolonganDarah`, `dataDisabilitasPekerjaan`, `dataDisabilitasPendidikan`) — `$dataKeseluruhan` di-GROUP BY kolom dimensi, bukan flat SUM |

---

## Ringkasan Pola JOIN Global

Seluruh method pada controller ini (kecuali yang memanggil API eksternal) menerapkan **pola JOIN yang konsisten**:

```sql
JOIN mstr_kelurahan ON mstr_kelurahan.kode = [tabel_fitur].kode_wilayah
JOIN mstr_kecamatan ON mstr_kecamatan.kode = mstr_kelurahan.kec_id
```

Artinya: **Iterasi 3, 4, dan 5 semuanya bergantung pada tabel Master Wilayah (Iterasi 2)** untuk menghasilkan data berbasis nama kelurahan dan kecamatan.

---

## Struktur Query Standar (3 Level)

Setiap method mengembalikan tiga level agregasi:

| Variabel | Keterangan | JOIN Wilayah |
|---|---|:---:|
| `$dataPerkelurahan` | Detail mentah per kelurahan | ✅ |
| `$dataKeseluruhan` | Aggregate total seluruh wilayah | ❌ (tanpa JOIN) |
| `$dataPerkecamatan` | Aggregate per kecamatan (GROUP BY kecamatan) | ✅ |

---

## ITERASI 2 — Master Wilayah (Tabel Referensi JOIN)

Kedua tabel ini **tidak dihitung sebagai tabel fitur**, namun **selalu di-JOIN** oleh semua fitur di bawah.

| Nama Tabel | Peran dalam JOIN |
|---|---|
| `mstr_kelurahan` | Menyediakan `nama` kelurahan via `kode_wilayah` |
| `mstr_kecamatan` | Menyediakan `nama` kecamatan via `mstr_kelurahan.kec_id` |

---

## ITERASI 3 — Agregat DKB (Subfitur 1)

Semua 19 method berikut menggunakan filter: `semester` + `tahun`

### Kelompok: Penduduk

| Method | Tabel Utama | JOIN ke Wilayah | GROUP BY Tambahan |
|---|---|:---:|---|
| `dataPendudukJenisKelamin` | `jenis_kelamin_penduduk` | ✅ | — |
| `dataPendudukAgama` | `agama_penduduk` | ✅ | — |
| `dataPendudukGoldar` | `golongan_darah_penduduk` | ✅ | — |
| `dataPendudukHubKel` | `hubungan_keluarga_penduduk` | ✅ | — |
| `dataPendudukPekerjaan` | `pekerjaan_penduduk` | ✅ | — |

**Tabel yang digabungkan:**  
`jenis_kelamin_penduduk` / `agama_penduduk` / `golongan_darah_penduduk` / `hubungan_keluarga_penduduk` / `pekerjaan_penduduk`  
→ masing-masing JOIN ke `mstr_kelurahan` + `mstr_kecamatan`

---

### Kelompok: Kepala Keluarga

| Method | Tabel Utama | JOIN ke Wilayah | GROUP BY Tambahan |
|---|---|:---:|---|
| `dataKepalaKeluargaAgama` | `agama_kepala_keluarga` | ✅ | — |
| `dataKepalaKeluargaJenisKelamin` | `jenis_kelamin_kepala_keluarga` | ✅ | — |
| `dataKepalaKeluargaPekerjaan` | `pekerjaan_kepala_keluarga` | ✅ | — |
| `dataKepalaKeluargaPendidikan` | `pendidikan_kepala_keluarga` | ✅ | — |
| `dataKelapaKeluargaStatusKawin` | `status_kawin_kepala_keluarga` | ✅ | — |

---

### Kelompok: Status Kawin Penduduk

| Method | Tabel Utama | JOIN ke Wilayah | GROUP BY Tambahan |
|---|---|:---:|---|
| `dataStatusKawinAgama` | `status_kawin_penduduk_agama` | ✅ | — |
| `dataStatusKawinJenisKelamin` | `status_kawin_penduduk_jenis_kelamin` | ✅ | — |
| `dataStatusKawinPekerjaan` | `status_kawin_penduduk_pekerjaan` | ✅ | — |

---

### Kelompok: Pendidikan

| Method | Tabel Utama | JOIN ke Wilayah | GROUP BY Tambahan |
|---|---|:---:|---|
| `dataPendidikanPendudukJenisKelamin` | `jenis_kelamin_pendidikan` | ✅ | — |
| `dataPendidikanPekerjaan` | `pendidikan_penduduk_pekerjaan` | ✅ | `pendidikan` (jenjang) ⚠️ |
| `dataPendidikanGolonganDarah` | `golongan_darah_pendidikan` | ✅ | `keterangan` (goldar) ⚠️ |

> ⚠️ Kedua method ini memiliki `$dataKeseluruhan` yang di-GROUP BY kolom dimensi, bukan flat SUM.

---

### Kelompok: Disabilitas

| Method | Tabel Utama | JOIN ke Wilayah | GROUP BY Tambahan |
|---|---|:---:|---|
| `dataDisabilitasJenisKelamin` | `jenis_kelamin_disabilitas` | ✅ | — |
| `dataDisabilitasPekerjaan` | `pekerjaan_disabilitas` | ✅ | `keterangan` (jenis disabilitas) ⚠️ |
| `dataDisabilitasPendidikan` | `pendidikan_disabilitas` | ✅ | `keterangan` (jenis disabilitas) ⚠️ |

> ⚠️ `$dataKeseluruhan` di-GROUP BY `keterangan`.

---

## ITERASI 5 — Statistik Kelompok Umur

Semua 8 method berikut menggunakan filter: `semester` + `tahun`  
**Tambahan:** `$dataKeseluruhan` di-GROUP BY kolom `kelompok_umur`

| Method | Tabel Utama | JOIN ke Wilayah | GROUP BY Tambahan |
|---|---|:---:|---|
| `dataStrukturUmurAgamaKelompokUmur` | `kelompok_umur_agama` | ✅ | `kelompok_umur` |
| `dataStrukturUmurDisabilitasKelompokUmur` | `kelompok_umur_disabilitas` | ✅ | `kelompok_umur` |
| `dataStrukturUmurDisabilitasUsiaSekolah` ⚠️ | `usia_sekolah_kelompok_umur_disabilitas` | ✅ | — |
| `dataStrukturUmurGolonganDarahKelompokUmur` | `kelompok_umur_golongan_darah` | ✅ | `kelompok_umur` |
| `dataStrukturUmurKepalaKeluargaKelompokUmur` | `kelompok_umur_kepala_keluarga` | ✅ | — (flat SUM) |
| `dataStrukturUmurKepalaKeluargaStatusKawin` ⚠️ | `status_kawin_kelompok_umur_kepala_keluarga` | ✅ | — (flat SUM) |
| `dataSturukUmurPendudukKelompokUmur` ⚠️ | `kelompok_umur_penduduk` | ✅ | — (flat SUM) |
| `dataStrukturUmurPendudukStatusKawinKelompokUmur` | `status_kawin_kelompok_umur_penduduk` | ✅ | — (flat SUM) |

> ⚠️ Nama method tidak konsisten (tidak mencantumkan `KelompokUmur`), lihat bagian anomali.

---

## ITERASI 4 — Pelayanan dan Dokumen Kependudukan

### Kelompok: Kepemilikan Dokumen (filter: `semester` + `tahun` + opsional `keterangan`)

| Method | Tabel Utama | JOIN ke Wilayah | Kalkulasi Khusus |
|---|---|:---:|---|
| `dataKepemilikanAktaKelahiran` | `akta_kelahiran` | ✅ | `persen_awal`, `persen_dinamis`, CASE keterangan usia |
| `dataKepemilikanAktaPerkawinan` | `akta_kawin` | ✅ | `persen_memiliki` (IF/SUM) |
| `dataKepemilikanAktaPerkawinanAgama` | `akta_kawin_agama` | ✅ | — |
| `dataKepemilikanAktaCerai` | `akta_cerai` | ✅ | `persen_memiliki` (IF/SUM) |
| `dataKepemilikanAktaCeraiAgama` | `akta_cerai_agama` | ✅ | — |
| `dataKepemilikanKia` | `kia` | ✅ | `persen_awal`, `persen_dinamis` |
| `dataKepemilikanKartuKeluarga` | `kartu_keluarga` | ✅ | `persen_memiliki` (IF/SUM) |
| `dataKepemilikanKTP` | `ktp` | ✅ | `persen_memiliki_ktp`, `persen_sudah_rekam` |

> ℹ️ Seluruh method Kepemilikan menggunakan `COALESCE(SUM(...), 0)` dan kalkulasi persentase inline via `DB::raw IF(...)`.

### Kelompok: Laporan Kinerja (filter: `tanggal_laporan` BETWEEN `from`–`to`, bukan semester/tahun)

| Method | Tabel Utama | JOIN ke Wilayah | Filter Waktu |
|---|---|:---:|---|
| `laporanKinerjaPdakCapil` | `laporan_kinerja_capil_format_pdak` | ✅ | `whereBetween('tanggal_laporan', [$from, $to])` |
| `laporanKinerjaPdakDafduk` | `laporan_kinerja_dafduk_format_pdak` | ✅ | `whereBetween('tanggal_laporan', [$from, $to])` |

> ⚠️ **Perbedaan penting:** Dua method ini **tidak menggunakan `semester`/`tahun`** melainkan filter rentang tanggal (`from`–`to`). Ini berbeda dari seluruh method lainnya.

### Kelompok: Layanan Eksternal API (tidak ada JOIN database)

| Method | Sumber Data | Tabel DB |
|---|---|---|
| `dataPelayananOnline` | External API (`/api/data_layanan_online`) | ❌ Tidak ada |
| `dataCetakEktp` | External API via `KtpApiService` | ❌ Tidak ada |
| `dataPerekaman` | External API via `perekamanService` | ❌ Tidak ada |

---

## ITERASI 3 — Struktur Umur (Subfitur 2)

Semua 8 method berikut menggunakan filter: `semester` + `tahun` + **`umur`** (umur tunggal spesifik)

| Method | Tabel Utama | JOIN ke Wilayah | GROUP BY Tambahan |
|---|---|:---:|---|
| `dataStrukturUmurPendudukUmurTunggal` | `umur_tunggal_penduduk` | ✅ | `umur` |
| `dataStrukturUmurPendudukStatuKawinUmurTunggal` ⚠️ | `status_kawin_umur_tunggal_penduduk` | ✅ | `umur` |
| `dataStrukturUmurPendudukUsiaSekolah` | `usia_sekolah_penduduk` | ✅ | — |
| `dataStrukturUmurPendudukUsiaMudaProduktifTua` | `usia_muda_produktif_tua_penduduk` | ✅ | — |
| `dataStrukturUmurKepalaKeluargaUmurTunggal` | `umur_tunggal_kepala_keluarga` | ✅ | `umur` |
| `dataStrukturUmurDisabilitasUmurTunggal` | `umur_tunggal_disabilitas` | ✅ | `umur` |
| `dataStrukturUmurDisabilitasPendidikan` ⚠️ | `pendidikan_umur_tunggal_disabilitas` | ✅ | `umur` |
| `dataStrukturUmurGolonganDarahUmurTunggal` | `umur_tunggal_golongan_darah` | ✅ | `umur` |

> ⚠️ Nama method tidak konsisten, lihat bagian anomali.

---

## Daftar Lengkap: Tabel yang Dijadikan Satu (Relasi JOIN)

| Tabel Fitur | Di-JOIN dengan | Tujuan |
|---|---|---|
| `jenis_kelamin_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `agama_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `golongan_darah_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `hubungan_keluarga_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `pekerjaan_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `agama_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `jenis_kelamin_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `pekerjaan_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `pendidikan_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `status_kawin_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `status_kawin_penduduk_agama` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `status_kawin_penduduk_jenis_kelamin` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `status_kawin_penduduk_pekerjaan` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `jenis_kelamin_pendidikan` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `pendidikan_penduduk_pekerjaan` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY pendidikan |
| `golongan_darah_pendidikan` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY keterangan |
| `jenis_kelamin_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `pekerjaan_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY keterangan |
| `pendidikan_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY keterangan |
| `kelompok_umur_agama` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY kelompok_umur |
| `kelompok_umur_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY kelompok_umur |
| `usia_sekolah_kelompok_umur_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `kelompok_umur_golongan_darah` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY kelompok_umur |
| `kelompok_umur_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `status_kawin_kelompok_umur_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `kelompok_umur_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `status_kawin_kelompok_umur_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `akta_kelahiran` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + CASE keterangan usia |
| `akta_kawin` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `akta_kawin_agama` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `akta_cerai` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `akta_cerai_agama` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `kia` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `kartu_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `ktp` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `laporan_kinerja_capil_format_pdak` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah (filter tanggal) |
| `laporan_kinerja_dafduk_format_pdak` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah (filter tanggal) |
| `umur_tunggal_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY umur |
| `status_kawin_umur_tunggal_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY umur |
| `usia_sekolah_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `usia_muda_produktif_tua_penduduk` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah |
| `umur_tunggal_kepala_keluarga` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY umur |
| `umur_tunggal_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY umur |
| `pendidikan_umur_tunggal_disabilitas` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY umur |
| `umur_tunggal_golongan_darah` | `mstr_kelurahan`, `mstr_kecamatan` | Tampilkan nama wilayah + GROUP BY umur |

**Total tabel fitur yang di-JOIN: 44 tabel**  
**Tabel yang selalu menjadi target JOIN: `mstr_kelurahan` dan `mstr_kecamatan`**

---

## Anomali dan Catatan Teknis

| # | Anomali | Lokasi | Detail |
|---|---|---|---|
| 1 | Typo nama method | `dataSturukUmurPendudukKelompokUmur` (baris 2151) | `Sturuk` seharusnya `Struktur` |
| 2 | Typo nama method | `dataStrukturUmurPendudukStatuKawinUmurTunggal` (baris 2096) | `Statu` seharusnya `Status` |
| 3 | Nama method ambigu | `dataStrukturUmurDisabilitasUsiaSekolah` (baris 1747) | Tabel asli: `usia_sekolah_kelompok_umur_disabilitas` (Iter. 5), bukan Iter. 3 |
| 4 | Nama method ambigu | `dataStrukturUmurKepalaKeluargaStatusKawin` (baris 1999) | Tabel asli: `status_kawin_kelompok_umur_kepala_keluarga` (Iter. 5) |
| 5 | Nama method ambigu | `dataStrukturUmurDisabilitasPendidikan` (baris 1636) | Tabel asli: `pendidikan_umur_tunggal_disabilitas` — nama tidak mencantumkan `UmurTunggal` |
| 6 | Filter waktu berbeda | `laporanKinerjaPdakCapil`, `laporanKinerjaPdakDafduk` | Pakai `whereBetween tanggal_laporan`, bukan `semester`/`tahun` |
| 7 | Typo key response | `dataStrukturUmurDisabilitasUmurTunggal` (baris 1745) | Mengembalikan `dataTilte` (harusnya `dataTitle`) |
| 8 | Iter.5 + Iter.3 dicampur | Semua method `dataStrukturUmur*` | Controller tidak memisahkan method kelompok_umur (Iter.5) dan umur_tunggal (Iter.3) |

---

## Kesimpulan

1. **Tidak ada tabel fitur yang di-JOIN satu sama lain** — setiap method hanya query satu tabel fitur utama.
2. **Semua 44 tabel fitur di-JOIN ke `mstr_kelurahan` + `mstr_kecamatan`** untuk mendapatkan label nama wilayah administratif.
3. **Iterasi 3, 4, dan 5 semuanya bergantung secara fungsional pada Iterasi 2** (Master Wilayah — dikerjakan lebih dahulu).
4. **Iterasi 5 dan Iterasi 3 Subfitur 2 dicampur dalam satu controller** dengan penamaan prefix `dataStrukturUmur*` untuk semua.
5. **Laporan Kinerja (Iterasi 4) menggunakan filter tanggal**, berbeda dari seluruh fitur lain yang menggunakan `semester` + `tahun`.
6. **Tiga method (Pelayanan Online, Cetak eKTP, Perekaman) tidak mengakses database** — menggunakan external API.
