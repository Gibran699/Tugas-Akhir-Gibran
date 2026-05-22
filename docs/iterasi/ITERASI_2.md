# Iterasi 2 — Manajemen Data Wilayah (Kecamatan & Kelurahan)

**Tema:** Manajemen master data wilayah (kecamatan dan kelurahan) sebagai referensi geografis seluruh data DKB; penambahan index performa pada tabel users dan data_pengguna.

**Tabel database:** `mstr_kecamatan`, `mstr_kelurahan`

**Tanggal selesai:** 20 Mei 2026

---

## 📁 Migration

| File | Keterangan |
|------|------------|
| `database/migrations/2026_03_11_133436_add_indexes_to_users_and_data_pengguna_tables.php` | Tambah index performa: `email` pada tabel `users`; `user_id`, `nik`, `nama`, `contact` pada tabel `data_pengguna` |

> ⚠️ **Catatan:** Tidak ditemukan file migration untuk tabel `mstr_kecamatan` dan `mstr_kelurahan` di folder `database/migrations/`. Tabel kemungkinan dibuat melalui SQL dump / import manual di luar sistem migrasi Laravel. Disarankan dibuat migration resmi agar dapat di-rollback dan di-reproduce di environment lain.

---

## 📁 Model

| File | Keterangan |
|------|------------|
| `app/Models/WilayahKecamatan.php` | Model untuk tabel `mstr_kecamatan`; menggunakan `SoftDeletes`; fillable: uuid, kode, nama |
| `app/Models/WilayahKelurahan.php` | Model untuk tabel `mstr_kelurahan`; `SoftDeletes`; fillable: uuid, kode, nama, kec_id; relasi `belongsTo WilayahKecamatan` |

---

## 📁 Seeder & Factory

| File | Keterangan |
|------|------------|
| — | Tidak ada seeder wilayah |

> ⚠️ **Catatan:** `MstrWilayahSeeder` belum dibuat. Data wilayah saat ini diisi secara manual atau melalui import SQL. Disarankan dibuat seeder resmi untuk reproducibility.

---

## 📁 Controller

| File | Keterangan |
|------|------------|
| `app/Http/Controllers/System/WilayahController.php` | `indexKecamatan()` — daftar semua kecamatan (id, uuid, kode, nama) ordered by kode; `indexKelurahan()` — daftar kelurahan dengan dual LEFT JOIN COALESCE untuk fleksibilitas FK (id atau kode), ordered by kode kecamatan |

---

## 📁 Route

| File | Keterangan |
|------|------------|
| `routes/web.php` | `GET json/wilayah-kecamatan` → `WilayahController@indexKecamatan`; `GET json/wilayah-kelurahan` → `WilayahController@indexKelurahan`; keduanya dalam grup middleware `auth + user.active` |

---

## 📁 View

| File | Keterangan |
|------|------------|
| `resources/views/pengaturan/wilayah_kelurahan/create_index.blade.php` | Halaman manajemen wilayah kelurahan; layout dua panel: tabel kelurahan (42%) + peta interaktif Leaflet v1.9.4 (58%) |

---

## ✅ Checklist Iterasi 2

- [x] Model `WilayahKecamatan` dan `WilayahKelurahan` tersedia
- [x] `GET /json/wilayah-kecamatan` mengembalikan data JSON semua kecamatan
- [x] `GET /json/wilayah-kelurahan` mengembalikan data JSON semua kelurahan beserta info kecamatan induknya
- [x] Halaman `Pengaturan – Wilayah Kelurahan` dapat diakses dan menampilkan peta Leaflet
- [x] Index performa pada `users` (email) dan `data_pengguna` (user_id, nik, nama, contact) sudah ditambahkan via migration
- [ ] **Tidak ada** migration untuk `mstr_kecamatan` dan `mstr_kelurahan` — perlu dibuat
- [ ] **Tidak ada** `MstrWilayahSeeder` — perlu dibuat agar data wilayah bisa di-seed ulang
- [ ] `GET /json/wilayah-kelurahan` belum mendukung filter by `kec_id` — saat ini mengembalikan semua data sekaligus

---

## 📝 Catatan

- Rute JSON wilayah menggunakan prefix `json/` (bukan `/api/v1/`), konsisten dengan pola route project yang berbasis web session bukan API token.
- `WilayahController@indexKelurahan` menggunakan **dual LEFT JOIN + COALESCE** untuk menangani dua kemungkinan isi kolom `kec_id` (berisi `id` integer atau `kode` string), sehingga query tidak bergantung pada satu skema FK.
- Halaman wilayah kelurahan mengintegrasikan **Leaflet.js** (CDN `unpkg.com/leaflet@1.9.4`) untuk visualisasi peta — satu-satunya halaman dalam project yang menggunakan library peta.
- Filter kelurahan by `kec_id` belum diimplementasi di controller; frontend mungkin memfilter di sisi klien (JavaScript).
