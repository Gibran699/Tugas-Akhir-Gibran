# Database Overview — Rumah Data Dukcapil 2.0

**Total tabel:** 62 (60 dari migration + 2 dari SQL dump manual)
**Tanggal dokumentasi:** 20 Mei 2026

---

## Daftar Tabel per Fitur

### 1. 📈 Agregat DKB — 19 Tabel

#### Entitas: Penduduk (5 tabel)

| # | Nama Tabel | Model |
|---|---|---|
| 1 | `jenis_kelamin_penduduk` | `AgregatDKB/Penduduk/JenisKelamin` |
| 2 | `agama_penduduk` | `AgregatDKB/Penduduk/Agama` |
| 3 | `golongan_darah_penduduk` | `AgregatDKB/Penduduk/GolonganDarah` |
| 4 | `hubungan_keluarga_penduduk` | `AgregatDKB/Penduduk/HubunganKeluarga` |
| 5 | `pekerjaan_penduduk` | `AgregatDKB/Penduduk/Pekerjaan` |

#### Entitas: Kepala Keluarga (5 tabel)

| # | Nama Tabel | Model |
|---|---|---|
| 6 | `jenis_kelamin_kepala_keluarga` | `AgregatDKB/KepalaKeluarga/JenisKelamin` |
| 7 | `agama_kepala_keluarga` | `AgregatDKB/KepalaKeluarga/Agama` |
| 8 | `pekerjaan_kepala_keluarga` | `AgregatDKB/KepalaKeluarga/Pekerjaan` |
| 9 | `pendidikan_kepala_keluarga` | `AgregatDKB/KepalaKeluarga/Pendidikan` |
| 10 | `status_kawin_kepala_keluarga` | `AgregatDKB/KepalaKeluarga/StatusKawin` |

#### Entitas: Pendidikan (3 tabel)

| # | Nama Tabel | Model |
|---|---|---|
| 11 | `jenis_kelamin_pendidikan` | `AgregatDKB/Pendidikan/JenisKelamin` |
| 12 | `golongan_darah_pendidikan` | `AgregatDKB/Pendidikan/GolonganDarah` |
| 13 | `pendidikan_penduduk_pekerjaan` | `AgregatDKB/Pendidikan/Pekerjaan` |

#### Entitas: Disabilitas (3 tabel)

| # | Nama Tabel | Model |
|---|---|---|
| 14 | `jenis_kelamin_disabilitas` | `AgregatDKB/Disabilitas/JenisKelamin` |
| 15 | `pekerjaan_disabilitas` | `AgregatDKB/Disabilitas/Pekerjaan` |
| 16 | `pendidikan_disabilitas` | `AgregatDKB/Disabilitas/Pendidikan` |

#### Entitas: Status Kawin (3 tabel)

| # | Nama Tabel | Model |
|---|---|---|
| 17 | `status_kawin_penduduk_jenis_kelamin` | `AgregatDKB/StatusKawin/JenisKelamin` |
| 18 | `status_kawin_penduduk_agama` | `AgregatDKB/StatusKawin/Agama` |
| 19 | `status_kawin_penduduk_pekerjaan` | `AgregatDKB/StatusKawin/Pekerjaan` |

---

### 2. 📄 Kepemilikan Dokumen — 8 Tabel

| # | Nama Tabel | Model | Jenis Dokumen |
|---|---|---|---|
| 20 | `ktp` | `Kepemilikan/Ktp` | KTP (Kartu Tanda Penduduk) |
| 21 | `kartu_keluarga` | `Kepemilikan/KartuKeluarga` | Kartu Keluarga |
| 22 | `kia` | `Kepemilikan/KIA` | Kartu Identitas Anak |
| 23 | `akta_kelahiran` | `Kepemilikan/AktaKelahiran` | Akta Kelahiran |
| 24 | `akta_kawin` | `Kepemilikan/AktaKawin` | Akta Nikah (Sipil) |
| 25 | `akta_kawin_agama` | `Kepemilikan/AktaKawinAgama` | Akta Nikah (Agama) |
| 26 | `akta_cerai` | `Kepemilikan/AktaCerai` | Akta Cerai (Sipil) |
| 27 | `akta_cerai_agama` | `Kepemilikan/AktaCeraiAgama` | Akta Cerai (Agama) |

---

### 3. 🔢 Struktur Umur — 8 Tabel

> Distribusi penduduk per kelompok umur (rentang 5 tahun)

| # | Nama Tabel | Model |
|---|---|---|
| 28 | `kelompok_umur_penduduk` | `StrukturUmur/Penduduk/KelompokUmur` |
| 29 | `status_kawin_kelompok_umur_penduduk` | `StrukturUmur/Penduduk/StatusKawinKelompokUmur` |
| 30 | `kelompok_umur_kepala_keluarga` | `StrukturUmur/KepalaKeluarga/KelompokUmur` |
| 31 | `status_kawin_kelompok_umur_kepala_keluarga` | `StrukturUmur/KepalaKeluarga/StatusKawinKelompokUmur` |
| 32 | `kelompok_umur_disabilitas` | `StrukturUmur/Disabilitas/KelompokUmur` |
| 33 | `usia_sekolah_kelompok_umur_disabilitas` | `StrukturUmur/Disabilitas/UsiaSekolahKelompokUmur` |
| 34 | `kelompok_umur_golongan_darah` | `StrukturUmur/GolonganDarah/KelompokUmur` |
| 35 | `kelompok_umur_agama` | `StrukturUmur/Agama/KelompokUmur` |

---

### 4. 📉 Statistik Kelompok Umur — 8 Tabel

> Distribusi per umur tunggal (per 1 tahun) dan kategori usia khusus

| # | Nama Tabel | Model |
|---|---|---|
| 36 | `umur_tunggal_penduduk` | `StrukturUmur/Penduduk/UmurTunggal` |
| 37 | `status_kawin_umur_tunggal_penduduk` | `StrukturUmur/Penduduk/StatusKawinUmurTunggal` |
| 38 | `usia_sekolah_penduduk` | `StrukturUmur/Penduduk/UsiaSekolah` |
| 39 | `usia_muda_produktif_tua_penduduk` | `StrukturUmur/Penduduk/UsiaMudaProduktifTua` |
| 40 | `umur_tunggal_kepala_keluarga` | `StrukturUmur/KepalaKeluarga/UmurTunggal` |
| 41 | `umur_tunggal_disabilitas` | `StrukturUmur/Disabilitas/UmurTunggal` |
| 42 | `pendidikan_umur_tunggal_disabilitas` | `StrukturUmur/Disabilitas/PendidikanUmurTunggal` |
| 43 | `umur_tunggal_golongan_darah` | `StrukturUmur/GolonganDarah/UmurTunggal` |

---

### 5. 🏢 Pelayanan — 2 Tabel Lokal + 3 Sub-fitur via API Eksternal

#### Tabel database lokal (2 tabel)

| # | Nama Tabel | Model | Sub-fitur |
|---|---|---|---|
| 44 | `laporan_kinerja_capil_format_pdak` | `LaporanKinerjaFormatPdak/Capil` | Laporan Kinerja Capil (Format PDAK) |
| 45 | `laporan_kinerja_dafduk_format_pdak` | `LaporanKinerjaFormatPdak/Dafduk` | Laporan Kinerja Dafduk (Format PDAK) |

> Kedua tabel di atas juga melakukan JOIN ke `mstr_kelurahan` dan `mstr_kecamatan` untuk resolusi nama wilayah.

#### Sub-fitur via API eksternal (tanpa tabel lokal)

| Sub-fitur | Service | Endpoint |
|---|---|---|
| Pelayanan Online | `ExternalApiService` | `POST {EXTERNAL_API_URL}/api/data_layanan_online` |
| Cetak e-KTP | `KtpApiService` | `GET ektp.samarindakota.go.id/API/costum_date_cetak_ktp.php` |
| Perekaman | `perekamanService` | `GET ektp.samarindakota.go.id/API/costum_date_perekaman.php` |

---

### 6. ⚙️ Sistem & Infrastruktur — 17 Tabel

#### Auth & User (2 tabel)

| # | Nama Tabel | Keterangan |
|---|---|---|
| 46 | `users` | Akun login; UUID PK, kolom `is_active` |
| 47 | `data_pengguna` | Profil detail user (NIK, nama, instansi) |

#### RBAC — Spatie Laravel Permission (5 tabel)

| # | Nama Tabel | Keterangan |
|---|---|---|
| 48 | `roles` | Daftar role (UUID PK) |
| 49 | `permissions` | Daftar permission (UUID PK) |
| 50 | `model_has_roles` | Pivot user ↔ role |
| 51 | `model_has_permissions` | Pivot user ↔ permission |
| 52 | `role_has_permissions` | Pivot role ↔ permission |

#### Wilayah Master — dari SQL dump, tanpa migration (2 tabel)

| # | Nama Tabel | Keterangan |
|---|---|---|
| 53 | `mstr_kecamatan` | Master kecamatan; diisi via `rumahdata.sql` |
| 54 | `mstr_kelurahan` | Master kelurahan; relasi FK ke `mstr_kecamatan` |

> ⚠️ Tidak ada file migration Laravel untuk kedua tabel ini. Sumber: `rumahdata.sql` (SQL dump manual).

#### Laravel Passport — OAuth (5 tabel)

| # | Nama Tabel |
|---|---|
| 55 | `oauth_auth_codes` |
| 56 | `oauth_access_tokens` |
| 57 | `oauth_refresh_tokens` |
| 58 | `oauth_clients` |
| 59 | `oauth_personal_access_clients` |

#### Laravel System (3 tabel)

| # | Nama Tabel | Keterangan |
|---|---|---|
| 60 | `password_reset_tokens` | Token reset password |
| 61 | `personal_access_tokens` | Laravel Sanctum tokens |
| 62 | `failed_jobs` | Antrian job yang gagal |

---

## Rekap Grand Total

| Fitur / Kelompok | Jumlah Tabel |
|---|---|
| Agregat DKB | 19 |
| Kepemilikan Dokumen | 8 |
| Struktur Umur | 8 |
| Statistik Kelompok Umur | 8 |
| Pelayanan | 2 |
| Auth & User | 2 |
| RBAC Spatie | 5 |
| Wilayah Master (SQL dump) | 2 |
| Laravel Passport OAuth | 5 |
| Laravel System | 3 |
| **GRAND TOTAL** | **62** |

---

## Skema API Eksternal

Project menggunakan 3 service untuk mengakses data dari sistem luar. Semua dikonfigurasi di `config/externalApi.php` dan membaca nilai dari `.env`.

### API 1 — ExternalApiService (Pelayanan Online)

| Aspek | Detail |
|---|---|
| File | `app/services/ExternalApiService.php` |
| Base URL | `env('EXTERNAL_API_URL')` |
| Autentikasi | POST `/api/login` → email + password → Bearer token |
| Cache token | `Cache::remember` 1 jam, auto-invalidate jika HTTP 401 |
| SSL | Production: `storage/certs/cacert.pem` · Dev: `verify=false` |
| Library | Laravel `Http` facade |
| Method | `get()`, `post()`, `put()`, `delete()` |

**Flow autentikasi:**
```
POST {EXTERNAL_API_URL}/api/login
  Body: { "email": "...", "password": "..." }
  Response: { "access_token": "..." }
  → Token disimpan di Cache selama 1 jam
  → Setiap request berikutnya: Authorization: Bearer {token}
  → Jika 401, cache dihapus dan re-authenticate otomatis (max 1 retry)
```

### API 2 — KtpApiService (Cetak e-KTP)

| Aspek | Detail |
|---|---|
| File | `app/services/KtpApiService.php` |
| Base URL | `env('KTP_API_URL')` · default: `http://ektp.samarindakota.go.id/API/` |
| Autentikasi | HTTP Basic Auth (`KTP_API_USERNAME` + `KTP_API_PASSWORD`) |
| Endpoint | `GET costum_date_cetak_ktp.php?start_date=d-m-Y&end_date=d-m-Y` |
| Library | GuzzleHTTP `Client` |
| SSL | `verify=false` |

### API 3 — perekamanService (Perekaman e-KTP)

| Aspek | Detail |
|---|---|
| File | `app/services/perekamanService.php` |
| Base URL | `env('KTP_API_URL')` · default: `http://ektp.samarindakota.go.id/API/` |
| Autentikasi | HTTP Basic Auth (`KTP_API_USERNAME` + `KTP_API_PASSWORD`) |
| Endpoint | `GET costum_date_perekaman.php?start_date=d-m-Y&end_date=d-m-Y` |
| Library | GuzzleHTTP `Client` |
| SSL | `verify=false` |

### Arsitektur Koneksi API

```
Rumah Data Dukcapil 2.0
  │
  ├── ExternalApiService ──► {EXTERNAL_API_URL}/api/...
  │     └── dataPelayananOnline()          [Bearer Token, Cache 1 jam]
  │
  ├── KtpApiService ────────► ektp.samarindakota.go.id/API/costum_date_cetak_ktp.php
  │     └── dataCetakEktp()               [HTTP Basic Auth]
  │
  └── perekamanService ─────► ektp.samarindakota.go.id/API/costum_date_perekaman.php
        └── dataPerekaman()               [HTTP Basic Auth]
```

### Environment Variables yang Dibutuhkan

```env
# External API (Pelayanan Online)
EXTERNAL_API_URL=
EXTERNAL_API_EMAIL=
EXTERNAL_API_PASSWORD=
EXTERNAL_API_TOKEN_KEY=

# KTP & Perekaman API
KTP_API_URL=http://ektp.samarindakota.go.id/API/
KTP_API_USERNAME=
KTP_API_PASSWORD=
```
