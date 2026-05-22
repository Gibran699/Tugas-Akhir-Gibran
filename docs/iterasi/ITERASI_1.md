# Iterasi 1 — Autentikasi, Manajemen User & RBAC

**Tema:** Autentikasi berbasis sesi web + API Passport, manajemen user, manajemen role & permission menggunakan Spatie Laravel Permission.

**Tabel database:** `users`, `data_pengguna`, `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`

**Tanggal selesai:** 20 Mei 2026

---

## 📁 Migration

| File | Keterangan |
|------|------------|
| `database/migrations/2014_10_12_000000_create_users_table.php` | Tabel `users` dengan UUID primary key, kolom: name, email, password, remember_token |
| `database/migrations/2026_04_22_000001_add_is_active_to_users_table.php` | Tambah kolom `is_active` (boolean, default true) ke tabel `users` |
| `database/migrations/2025_02_05_114052_create_data_pengguna_table.php` | Tabel `data_pengguna` (profil detail user): nik, nama, contact, instansi, nama_instansi, user_id, soft deletes |
| `database/migrations/2025_02_05_014627_create_permission_tables.php` | Tabel Spatie Permission: `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions` — dimodifikasi untuk UUID |
| `database/migrations/2016_06_01_000001_create_oauth_auth_codes_table.php` | Laravel Passport: tabel oauth_auth_codes |
| `database/migrations/2016_06_01_000002_create_oauth_access_tokens_table.php` | Laravel Passport: tabel oauth_access_tokens |
| `database/migrations/2016_06_01_000003_create_oauth_refresh_tokens_table.php` | Laravel Passport: tabel oauth_refresh_tokens |
| `database/migrations/2016_06_01_000004_create_oauth_clients_table.php` | Laravel Passport: tabel oauth_clients |
| `database/migrations/2016_06_01_000005_create_oauth_personal_access_clients_table.php` | Laravel Passport: tabel oauth_personal_access_clients |

---

## 📁 Model

| File | Keterangan |
|------|------------|
| `app/Models/User.php` | Model user: implements `HasApiTokens` (Passport), `HasRoles` (Spatie), `HasUuids`; relasi `hasOne DataPengguna`; cast `is_active` sebagai boolean |
| `app/Models/DataPengguna.php` | Model profil detail user: `HasUuids`, `SoftDeletes`; relasi `belongsTo User`; fillable: nik, nama, contact, instansi, nama_instansi |
| `app/Models/Role.php` | Model role kustom: extends `Spatie\Permission\Models\Role`, tambah `HasUuids`, primary key `uuid` |

---

## 📁 Seeder & Factory

| File | Keterangan |
|------|------------|
| `database/seeders/DatabaseSeeder.php` | Entry point seeder; memanggil `PermissionSeeder::class` |
| `database/seeders/UserSeeder.php` | Seed user admin default (email: admin@gmail.com, password: password123) dengan UUID manual |
| `database/factories/UserFactory.php` | Factory bawaan Laravel untuk generate data user testing |

> ⚠️ **Catatan:** File `database/seeders/PermissionSeeder.php` dipanggil di `DatabaseSeeder` tetapi **belum dibuat**. Seed permission & role belum tersedia — perlu dibuat manual atau ditambah di iterasi berikutnya.

---

## 📁 Controller

| File | Keterangan |
|------|------------|
| `app/Http/Controllers/Auth/MainController.php` | Autentikasi web: `login()` (cek is_active + session), `logout()` (invalidate session), `changePassword()` (Hash::check + DB transaction) |
| `app/Http/Controllers/API/AuthController.php` | Autentikasi API: `login()` menggunakan Laravel Passport, cek role `developer\|api_smart_rt`, kembalikan Bearer token |
| `app/Http/Controllers/System/UserController.php` | Manajemen user: `index`, `store` (create + assign role), `update`, `destroy`, `edit`, `toggleStatus` (tidak bisa nonaktifkan diri sendiri) |
| `app/Http/Controllers/System/RoleController.php` | Manajemen role: `index`, `store` (create + syncPermissions), `update`, `destroy`, `edit` — semua berbasis UUID |
| `app/Http/Controllers/System/PermissionController.php` | Placeholder kosong (belum diimplementasi) |

---

## 📁 Middleware

| File | Keterangan |
|------|------------|
| `app/Http/Middleware/CheckUserActive.php` | Cek `is_active` user saat setiap request; paksa logout dan redirect ke login jika akun dinonaktifkan |
| `app/Http/Kernel.php` | Registrasi alias middleware `'user.active' => CheckUserActive::class` di `$routeMiddleware` |

---

## 📁 Route

| File | Keterangan |
|------|------------|
| `routes/web.php` | Semua route aplikasi: guest route `GET/POST /login`, grup `auth + user.active` mencakup logout, change-password, user resource, role resource, toggle-status |

---

## 📁 View

| File | Keterangan |
|------|------------|
| `resources/views/auth/login.blade.php` | Halaman form login (email + password) |
| `resources/views/pengaturan/user/create_index.blade.php` | Halaman CRUD manajemen user (tabel daftar user + form tambah/edit) |
| `resources/views/pengaturan/role/create_index.blade.php` | Halaman CRUD manajemen role beserta daftar permission yang dapat di-assign |

---

## ✅ Checklist Iterasi 1

- [x] `php artisan migrate` berhasil — semua tabel terbentuk
- [x] Kolom `is_active` tersedia di tabel `users`
- [x] `POST /login` mengembalikan respons JSON dengan session (web auth)
- [x] `POST /api/login` mengembalikan Bearer token (Passport API auth)
- [x] User `is_active = false` ditolak dengan pesan "Akun Anda telah dinonaktifkan"
- [x] Middleware `user.active` aktif di semua route yang dilindungi
- [x] CRUD user berjalan (store, update, destroy, toggleStatus)
- [x] CRUD role + syncPermissions berjalan
- [ ] `database/seeders/PermissionSeeder.php` **belum dibuat** — seed role & permission belum tersedia
- [ ] Tidak ada Form Request kelas — validasi langsung di controller
- [ ] Tidak ada unit/feature test (`tests/Feature/`) — belum ditulis

---

## 📝 Catatan

- Semua primary key menggunakan **UUID** (bukan auto-increment), termasuk pada tabel Spatie Permission yang dimodifikasi foreign key-nya ke `uuid`.
- Password default user baru dibuat via `UserController` adalah `6472Dukcapil` (hardcoded di `Hash::make`).
- `PermissionSeeder.php` direferensikan di `DatabaseSeeder` tapi tidak ditemukan di filesystem — perlu dibuat atau dihapus referensinya.
- `PermissionController.php` ada tapi masih kosong (placeholder).
- Tidak ada pemisahan Service layer; logika bisnis langsung di Controller.
- Autentikasi web menggunakan **Laravel Session**, sedangkan autentikasi API menggunakan **Laravel Passport** (Bearer token, expire 7 hari).
