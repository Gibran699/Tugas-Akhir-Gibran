# Sinkronisasi: 45 File Import → Tabel MySQL → Method CalculateDataController

> Dokumen ini memetakan seluruh **45 file Excel import**, **tabel MySQL tujuan**, dan **method yang membaca data** tersebut secara lengkap, terorganisasi per fitur.

---

## Ringkasan Sinkronisasi

| Komponen | Jumlah | Status |
|---|:---:|:---:|
| Method `CalculateDataController` (total) | **54** | ✅ |
| Method berbasis DB + Import | **45** | ✅ |
| Method `dateRange*` (reuse tabel umur_tunggal) | **6** | ✅ Tidak butuh import baru |
| Method External API (tidak akses DB) | **3** | ✅ Tidak butuh import |
| Import class PHP di `app/Imports/` | **45** | ✅ Semua ada |
| Entry `listFileImport` di `config/dataArray.php` | **45** | ✅ Semua terdaftar |

---

## ⚠️ Anomali yang Ditemukan

| Item | Keterangan |
|---|---|
| `"Struktur Umur Pendidikan Umur Tunggal"` di `listDataFileExcelFormatImport` | **Tidak ada pasangannya** di `listFileImport` dan tidak ada Import class-nya. Berbeda dari entry yang sudah ada `"Struktur Umur Disabilitas Pendidikan Umur Tunggal"`. Perlu klarifikasi: fitur baru atau salah nama? |
| `LaporanKinerjaCapilFormatPdakImport` & `LaporanKinerjaDafdukFormatPdakImport` | Tidak ada template download di `listDataFileExcelFormatImport` (disengaja — format dari pemerintah) |
| Typo method `dataSturukUmurPendudukKelompokUmur` | Seharusnya `dataStrukturUmurPendudukKelompokUmur` — fungsional karena config merujuk ke nama yang sama |

---

## Fitur 1 — Agregat DKB: Penduduk

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method |
|:---:|---|---|---|---|
| 1 | `penduduk_agama.xlsx` | `PendudukAgamaImport` | `agama_penduduk` | `dataPendudukAgama` |
| 2 | `penduduk_golongan_darah.xlsx` | `PendudukGolonganDarahImport` | `golongan_darah_penduduk` | `dataPendudukGoldar` |
| 3 | `penduduk_jenis_kelamin.xlsx` | `PendudukJenisKelaminImport` | `jenis_kelamin_penduduk` | `dataPendudukJenisKelamin` |
| 4 | `penduduk_pekerjaan.xlsx` | `PendudukPekerjaanImport` | `pekerjaan_penduduk` | `dataPendudukPekerjaan` |
| 5 | `penduduk_hubungan_keluarga.xlsx` | `PendudukHubunganKeluargaImport` | `hubungan_keluarga_penduduk` | `dataPendudukHubKel` |

---

## Fitur 2 — Agregat DKB: Kepala Keluarga

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method |
|:---:|---|---|---|---|
| 6 | `kepala_keluarga_agama.xlsx` | `KepalaKeluargaAgamaImport` | `agama_kepala_keluarga` | `dataKepalaKeluargaAgama` |
| 7 | `kepala_keluarga_jenis_kelamin.xlsx` | `KepalaKeluargaJenisKelaminImport` | `jenis_kelamin_kepala_keluarga` | `dataKepalaKeluargaJenisKelamin` |
| 8 | `kepala_keluarga_pekerjaan.xlsx` | `KepalaKeluargaPekerjaanImport` | `pekerjaan_kepala_keluarga` | `dataKepalaKeluargaPekerjaan` |
| 9 | `kepala_keluarga_pendidikan.xlsx` | `KepalaKeluargaPendidikanImport` | `pendidikan_kepala_keluarga` | `dataKepalaKeluargaPendidikan` |
| 10 | `kepala_keluarga_status_kawin.xlsx` | `KepalaKeluargaStatusKawinImport` | `status_kawin_kepala_keluarga` | `dataKelapaKeluargaStatusKawin` |

---

## Fitur 3 — Agregat DKB: Status Kawin

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method |
|:---:|---|---|---|---|
| 11 | `status_kawin_agama.xlsx` | `StatusKawinPendudukAgamaImport` | `status_kawin_penduduk_agama` | `dataStatusKawinAgama` |
| 12 | `status_kawin_jenis_kelamin.xlsx` | `StatusKawinPendudukJenisKelaminImport` | `status_kawin_penduduk_jenis_kelamin` | `dataStatusKawinJenisKelamin` |
| 13 | `status_kawin_pekerjaan.xlsx` | `StatusKawinPendudukPekerjaanImport` | `status_kawin_penduduk_pekerjaan` | `dataStatusKawinPekerjaan` |

---

## Fitur 4 — Agregat DKB: Pendidikan

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method |
|:---:|---|---|---|---|
| 14 | `pendidikan_jenis_kelamin.xlsx` | `PendidikanJenisKelaminImport` | `jenis_kelamin_pendidikan` | `dataPendidikanPendudukJenisKelamin` |
| 15 | `pendidikan_pekerjaan.xlsx` | `PendidikanPekerjaanImport` | `pendidikan_penduduk_pekerjaan` | `dataPendidikanPekerjaan` |
| 16 | `pendidikan_golongan_darah.xlsx` | `PendidikanGolonganDarahImport` | `golongan_darah_pendidikan` | `dataPendidikanGolonganDarah` |

---

## Fitur 5 — Agregat DKB: Disabilitas

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method |
|:---:|---|---|---|---|
| 17 | `disabilitas_jenis_kelamin.xlsx` | `DisabilitasJenisKelaminImport` | `jenis_kelamin_disabilitas` | `dataDisabilitasJenisKelamin` |
| 18 | `disabilitas_pekerjaan.xlsx` | `DisabilitasPekerjaanImport` | `pekerjaan_disabilitas` | `dataDisabilitasPekerjaan` |
| 19 | `disabilitas_pendidikan.xlsx` | `DisabilitasPendidikanImport` | `pendidikan_disabilitas` | `dataDisabilitasPendidikan` |

---

## Fitur 6 — Kepemilikan Dokumen

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method |
|:---:|---|---|---|---|
| 20 | `kepemilikan_akta_kelahiran.xlsx` | `KepemilikanAktaKelahiranImport` | `akta_kelahiran` | `dataKepemilikanAktaKelahiran` |
| 21 | `kepemilikan_akta_kawin.xlsx` | `KepemilikanAktaKawinImport` | `akta_kawin` | `dataKepemilikanAktaPerkawinan` |
| 22 | `kepemilikan_akta_kawin_agama.xlsx` | `KepemilikanAktaAgamaKawinImport` | `akta_kawin_agama` | `dataKepemilikanAktaPerkawinanAgama` |
| 23 | `kepemilikan_akta_cerai.xlsx` | `KepemilikanAktaCeraiImport` | `akta_cerai` | `dataKepemilikanAktaCerai` |
| 24 | `kepemilikan_akta_cerai_agama.xlsx` | `KepemilikanAktaCeraiAgamaImport` | `akta_cerai_agama` | `dataKepemilikanAktaCeraiAgama` |
| 25 | `kepemilikan_kia.xlsx` | `KepemilikanKIAImport` | `kia` | `dataKepemilikanKia` |
| 26 | `kepemilikan_kartu_keluarga.xlsx` | `KepemilikanKartuKeluargaImport` | `kartu_keluarga` | `dataKepemilikanKartuKeluarga` |
| 27 | `kepemilikan_ktp.xlsx` | `KepemilikanKtpImport` | `ktp` | `dataKepemilikanKTP` |

---

## Fitur 7 — Struktur Umur: Agama

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method |
|:---:|---|---|---|---|
| 28 | `struktur_umur_agama_kelompok_umur.xlsx` | `StrukturUmurAgamaKelompokUmurImport` | `kelompok_umur_agama` | `dataStrukturUmurAgamaKelompokUmur` |

---

## Fitur 8 — Struktur Umur: Disabilitas

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method | Catatan |
|:---:|---|---|---|---|---|
| 29 | `struktur_umur_disabilitas_kelompok_umur.xlsx` | `StrukturUmurDisabilitasKelompokUmurImport` | `kelompok_umur_disabilitas` | `dataStrukturUmurDisabilitasKelompokUmur` | |
| 30 | `struktur_umur_disabilitas_pendidikan_umur_tunggal.xlsx` | `StrukturUmurDisabilitasPendidikanUmurTunggalImport` | `pendidikan_umur_tunggal_disabilitas` | `dataStrukturUmurDisabilitasPendidikan` | ✳️ Juga dipakai `dateRangeAgeDisabilitasPendidikan` |
| 31 | `struktur_umur_disabilitas_umur_tunggal.xlsx` | `StrukturUmurDisabilitasUmurTunggalImport` | `umur_tunggal_disabilitas` | `dataStrukturUmurDisabilitasUmurTunggal` | ✳️ Juga dipakai `dateRangeAgeDisabilitasUmur` |
| 32 | `struktur_umur_disabilitas_usia_sekolah.xlsx` | `StrukturUmurDisabilitasUsiaSekolahKelompokUmurImport` | `usia_sekolah_kelompok_umur_disabilitas` | `dataStrukturUmurDisabilitasUsiaSekolah` | |

---

## Fitur 9 — Struktur Umur: Golongan Darah

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method | Catatan |
|:---:|---|---|---|---|---|
| 33 | `struktur_umur_golongan_darah_kelompok_umur.xlsx` | `StrukturUmurGolonganDarahKelompokUmurImport` | `kelompok_umur_golongan_darah` | `dataStrukturUmurGolonganDarahKelompokUmur` | |
| 34 | `struktur_umur_golongan_darah_umur_tunggal.xlsx` | `StrukturUmurGolonganDarahUmurTunggalImport` | `umur_tunggal_golongan_darah` | `dataStrukturUmurGolonganDarahUmurTunggal` | ✳️ Juga dipakai `dateRangeAgeBloodTypeUmur` |

---

## Fitur 10 — Struktur Umur: Kepala Keluarga

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method | Catatan |
|:---:|---|---|---|---|---|
| 35 | `struktur_umur_kepala_keluarga_kelompok_umur.xlsx` | `StrukturUmurKepalaKeluargaKelompokUmurImport` | `kelompok_umur_kepala_keluarga` | `dataStrukturUmurKepalaKeluargaKelompokUmur` | |
| 36 | `struktur_umur_kepala_keluarga_status_kawin_kelompok_umur.xlsx` | `StrukturUmurKepalaKeluargaStatusKawinImport` | `status_kawin_kelompok_umur_kepala_keluarga` | `dataStrukturUmurKepalaKeluargaStatusKawin` | |
| 37 | `struktur_umur_kepala_keluarga_umur_tunggal.xlsx` | `StrukturUmurKepalaKeluargaUmurTunggalImport` | `umur_tunggal_kepala_keluarga` | `dataStrukturUmurKepalaKeluargaUmurTunggal` | ✳️ Juga dipakai `dateRangeAgeKepalaKeluargaUmur` |

---

## Fitur 11 — Struktur Umur: Penduduk

| # | File Excel (`/format_file_excel_import/`) | Import Class | Tabel MySQL | Method | Catatan |
|:---:|---|---|---|---|---|
| 38 | `struktur_umur_penduduk_kelompok_umur.xlsx` | `StrukturUmurPendudukKelompokUmurImport` | `kelompok_umur_penduduk` | `dataSturukUmurPendudukKelompokUmur` ⚠️ | Typo: `Sturuk` |
| 39 | `struktur_umur_penduduk_status_kawin_kelompok_umur.xlsx` | `StrukturUmurPendudukStatusKawinKelompokUmurImport` | `status_kawin_kelompok_umur_penduduk` | `dataStrukturUmurPendudukStatusKawinKelompokUmur` | |
| 40 | `struktur_umur_penduduk_status_kawin_umur_tunggal.xlsx` | `StrukturUmurPendudukStatusKawinUmurTunggalImport` | `status_kawin_umur_tunggal_penduduk` | `dataStrukturUmurPendudukStatuKawinUmurTunggal` | ✳️ Juga dipakai `dateRangeAgePendudukStatKawin` |
| 41 | `struktur_umur_penduduk_umur_tunggal.xlsx` | `StrukturUmurPendudukUmurTunggalImport` | `umur_tunggal_penduduk` | `dataStrukturUmurPendudukUmurTunggal` | ✳️ Juga dipakai `dateRangeAgePendudukUmur` |
| 42 | `struktur_umur_penduduk_demografi_usia.xlsx` | `StrukturUmurPendudukUsiaMudaProduktifImport` | `usia_muda_produktif_tua_penduduk` | `dataStrukturUmurPendudukUsiaMudaProduktifTua` | |
| 43 | `struktur_umur_penduduk_usia_sekolah.xlsx` | `StrukturUmurPendudukUsiaSekolahImport` | `usia_sekolah_penduduk` | `dataStrukturUmurPendudukUsiaSekolah` | |

---

## Fitur 12 — Laporan Kinerja Format PDAK

> ⚠️ Tidak ada template download di `listDataFileExcelFormatImport` — format file bersumber dari pemerintah.

| # | File Excel | Import Class | Tabel MySQL | Method |
|:---:|---|---|---|---|
| 44 | *(tanpa template download)* | `LaporanKinerjaCapilFormatPdakImport` | `laporan_kinerja_capil_format_pdak` | `laporanKinerjaPdakCapil` |
| 45 | *(tanpa template download)* | `LaporanKinerjaDafdukFormatPdakImport` | `laporan_kinerja_dafduk_format_pdak` | `laporanKinerjaPdakDafduk` |

---

## Method Tanpa Import (9 Method)

### Kelompok A — External API (3 method, tidak akses DB sama sekali)

| Method | Keterangan |
|---|---|
| `dataPelayananOnline` | Data dari API eksternal `/api/data_layanan_online` |
| `dataCetakEktp` | Data dari KTP API (`KtpApiService`) |
| `dataPerekaman` | Data dari API Perekaman (`perekamanService`) |

### Kelompok B — Date Range / Rentang Umur (6 method, reuse tabel umur_tunggal)

> Method ini **tidak butuh import baru** — tabel sudah terisi melalui import no. 30, 31, 34, 37, 40, 41 di atas.

| Method | Tabel yang Digunakan | Import yang Mengisi Tabel |
|---|---|---|
| `dateRangeAgeDisabilitasPendidikan` | `pendidikan_umur_tunggal_disabilitas` | No. 30 — `StrukturUmurDisabilitasPendidikanUmurTunggalImport` |
| `dateRangeAgeDisabilitasUmur` | `umur_tunggal_disabilitas` | No. 31 — `StrukturUmurDisabilitasUmurTunggalImport` |
| `dateRangeAgeBloodTypeUmur` | `umur_tunggal_golongan_darah` | No. 34 — `StrukturUmurGolonganDarahUmurTunggalImport` |
| `dateRangeAgeKepalaKeluargaUmur` | `umur_tunggal_kepala_keluarga` | No. 37 — `StrukturUmurKepalaKeluargaUmurTunggalImport` |
| `dateRangeAgePendudukUmur` | `umur_tunggal_penduduk` | No. 41 — `StrukturUmurPendudukUmurTunggalImport` |
| `dateRangeAgePendudukStatKawin` | `status_kawin_umur_tunggal_penduduk` | No. 40 — `StrukturUmurPendudukStatusKawinUmurTunggalImport` |

---

## Rekap 45 Tabel MySQL Tujuan Import

| Fitur | Tabel MySQL |
|---|---|
| Agregat DKB - Penduduk | `agama_penduduk`, `golongan_darah_penduduk`, `jenis_kelamin_penduduk`, `pekerjaan_penduduk`, `hubungan_keluarga_penduduk` |
| Agregat DKB - Kepala Keluarga | `agama_kepala_keluarga`, `jenis_kelamin_kepala_keluarga`, `pekerjaan_kepala_keluarga`, `pendidikan_kepala_keluarga`, `status_kawin_kepala_keluarga` |
| Agregat DKB - Status Kawin | `status_kawin_penduduk_agama`, `status_kawin_penduduk_jenis_kelamin`, `status_kawin_penduduk_pekerjaan` |
| Agregat DKB - Pendidikan | `jenis_kelamin_pendidikan`, `pendidikan_penduduk_pekerjaan`, `golongan_darah_pendidikan` |
| Agregat DKB - Disabilitas | `jenis_kelamin_disabilitas`, `pekerjaan_disabilitas`, `pendidikan_disabilitas` |
| Kepemilikan Dokumen | `akta_kelahiran`, `akta_kawin`, `akta_kawin_agama`, `akta_cerai`, `akta_cerai_agama`, `kia`, `kartu_keluarga`, `ktp` |
| Struktur Umur - Agama | `kelompok_umur_agama` |
| Struktur Umur - Disabilitas | `kelompok_umur_disabilitas`, `pendidikan_umur_tunggal_disabilitas`, `umur_tunggal_disabilitas`, `usia_sekolah_kelompok_umur_disabilitas` |
| Struktur Umur - Golongan Darah | `kelompok_umur_golongan_darah`, `umur_tunggal_golongan_darah` |
| Struktur Umur - Kepala Keluarga | `kelompok_umur_kepala_keluarga`, `status_kawin_kelompok_umur_kepala_keluarga`, `umur_tunggal_kepala_keluarga` |
| Struktur Umur - Penduduk | `kelompok_umur_penduduk`, `status_kawin_kelompok_umur_penduduk`, `status_kawin_umur_tunggal_penduduk`, `umur_tunggal_penduduk`, `usia_muda_produktif_tua_penduduk`, `usia_sekolah_penduduk` |
| Laporan Kinerja PDAK | `laporan_kinerja_capil_format_pdak`, `laporan_kinerja_dafduk_format_pdak` |

**Total: 45 tabel**
