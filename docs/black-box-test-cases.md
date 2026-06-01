# Black Box Testing — Rumah Data Dukcapil 2.0

**Metode:** Black Box Testing  
**Tanggal Dokumen:** 25 Mei 2026  
**Total Test Case:** **118 TC**  
**Format Kode:** `SIMADKB-BT-US[XX]-[YY]`  
> SIMADKB = Sistem Informasi Manajemen Data Kependudukan · BT = Black Box Testing · US = User Story

---

## Peta Iterasi → User Story

| Iterasi | Scope | US |
|---|---|---|
| **Iterasi 1** | Autentikasi, Manajemen User & RBAC | US01 – US03 |
| **Iterasi 2** | Master Wilayah | US04 |
| **Iterasi 3 Sub1** | Agregat DKB (Penduduk, KK, Status Kawin, Pendidikan, Disabilitas) | US05 – US09 |
| **Iterasi 3 Sub2** | Struktur Umur — Umur Tunggal & Custom Date Range | US10 – US11 |
| **Iterasi 4** | Kepemilikan Dokumen & Laporan Kinerja PDAK & API Eksternal | US12 – US14 |
| **Iterasi 5** | Statistik Kelompok Umur | US15 – US16 |
| **Cross-cutting** | Download Template & Kontrol Akses | US17 – US18 |

---

## ITERASI 1 — Autentikasi & Manajemen User

### US01 — Login & Logout (5 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US01-01 | Login berhasil dengan kredensial valid | 1. Buka halaman `/login`<br>2. Masukkan email: `admin@gmail.com`<br>3. Masukkan password: `password123`<br>4. Klik tombol Login | Sistem memvalidasi kredensial, membuat sesi baru, dan mengarahkan user ke halaman dashboard utama | | |
| SIMADKB-BT-US01-02 | Login gagal — password salah | 1. Buka halaman `/login`<br>2. Masukkan email valid<br>3. Masukkan password yang salah<br>4. Klik tombol Login | Sistem menolak login dan menampilkan pesan error "Kredensial tidak valid", halaman tetap di halaman login | | |
| SIMADKB-BT-US01-03 | Login gagal — email tidak terdaftar | 1. Buka halaman `/login`<br>2. Masukkan email yang tidak terdaftar<br>3. Masukkan password apapun<br>4. Klik tombol Login | Sistem menampilkan pesan "Email tidak terdaftar!", login ditolak | | |
| SIMADKB-BT-US01-04 | Login gagal — akun user dinonaktifkan | 1. Nonaktifkan akun user target melalui menu admin<br>2. Buka halaman `/login`<br>3. Masukkan email & password user yang dinonaktifkan<br>4. Klik tombol Login | Sistem menampilkan pesan "Akun Anda telah dinonaktifkan, hubungi administrator", login ditolak | | |
| SIMADKB-BT-US01-05 | Logout berhasil | 1. Login ke sistem<br>2. Klik tombol Logout di menu navigasi | Sesi dihapus, token sesi diperbarui, dan user diarahkan kembali ke halaman login | | |

---

### US02 — Manajemen User (4 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US02-01 | Tambah user baru berhasil | 1. Login sebagai admin<br>2. Buka menu Pengaturan → User<br>3. Isi form: nama, email, NIK, instansi<br>4. Pilih role<br>5. Klik Simpan | User baru tersimpan di tabel `users` & `data_pengguna`, password default `6472Dukcapil`, role terassign | | |
| SIMADKB-BT-US02-02 | Edit data user berhasil | 1. Login sebagai admin<br>2. Buka menu Pengaturan → User<br>3. Klik Edit pada user tertentu<br>4. Ubah data (misal nama instansi)<br>5. Klik Simpan | Data user terupdate di database, perubahan tampil di daftar user | | |
| SIMADKB-BT-US02-03 | Nonaktifkan akun user | 1. Login sebagai admin<br>2. Buka menu Pengaturan → User<br>3. Klik Toggle Status pada user target (bukan diri sendiri)<br>4. Konfirmasi aksi | Status akun berubah menjadi tidak aktif, user tidak dapat login kembali | | |
| SIMADKB-BT-US02-04 | Nonaktifkan diri sendiri ditolak | 1. Login sebagai admin<br>2. Buka menu Pengaturan → User<br>3. Klik Toggle Status pada akun sendiri | Sistem menolak aksi dan menampilkan pesan error bahwa user tidak dapat menonaktifkan akunnya sendiri | | |

---

### US03 — Manajemen Role & Permission (3 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US03-01 | Tambah role baru dengan permission | 1. Login sebagai admin<br>2. Buka menu Pengaturan → Role<br>3. Isi nama role baru<br>4. Centang permission yang diinginkan<br>5. Klik Simpan | Role baru tersimpan dengan UUID di tabel `roles`, permission tersinkron di tabel `role_has_permissions` | | |
| SIMADKB-BT-US03-02 | Edit role — ubah permission | 1. Login sebagai admin<br>2. Buka menu Pengaturan → Role<br>3. Klik Edit pada role tertentu<br>4. Tambah atau hapus centang permission<br>5. Klik Simpan | Daftar permission role diperbarui dan disinkronkan secara otomatis, perubahan langsung berlaku untuk semua pengguna dengan role tersebut | | |
| SIMADKB-BT-US03-03 | Hapus role berhasil | 1. Login sebagai admin<br>2. Buka menu Pengaturan → Role<br>3. Klik Hapus pada role yang tidak memiliki user aktif<br>4. Konfirmasi penghapusan | Role terhapus dari tabel `roles`, relasi di `role_has_permissions` ikut terhapus | | |

---

## ITERASI 2 — Master Wilayah

### US04 — Melihat Data Master Wilayah (2 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US04-01 | Melihat daftar data kecamatan | 1. Login ke sistem<br>2. Buka menu Master Wilayah → Kecamatan | Sistem menampilkan seluruh data kecamatan dari tabel `mstr_kecamatan` dengan kolom kode dan nama kecamatan | | |
| SIMADKB-BT-US04-02 | Melihat daftar data kelurahan | 1. Login ke sistem<br>2. Buka menu Master Wilayah → Kelurahan | Sistem menampilkan seluruh data kelurahan dari tabel `mstr_kelurahan` beserta nama kecamatan induknya | | |

---

## ITERASI 3 Sub1 — Agregat DKB

### US05 — Import & Tampil Data Penduduk (12 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US05-01 | Import Penduduk Jenis Kelamin berhasil | 1. Login ke sistem<br>2. Buka menu Import Excel<br>3. Pilih jenis data: Penduduk Jenis Kelamin<br>4. Isi semester dan tahun yang belum ada datanya<br>5. Unggah file `penduduk_jenis_kelamin.xlsx` (≤ 2 MB, format sesuai template)<br>6. Klik Import | Sistem menerima file, memproses data, menyimpan ke tabel `jenis_kelamin_penduduk`, menampilkan notifikasi import berhasil | | |
| SIMADKB-BT-US05-02 | Import Penduduk Agama berhasil | 1. Login ke sistem<br>2. Buka menu Import Excel<br>3. Pilih jenis data: Penduduk Agama<br>4. Isi semester dan tahun<br>5. Unggah file `penduduk_agama.xlsx` sesuai template<br>6. Klik Import | Data tersimpan ke tabel `agama_penduduk`, notifikasi berhasil tampil | | |
| SIMADKB-BT-US05-03 | Import Penduduk Golongan Darah berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Penduduk Golongan Darah<br>3. Isi semester & tahun<br>4. Unggah file `penduduk_golongan_darah.xlsx`<br>5. Klik Import | Data tersimpan ke tabel `golongan_darah_penduduk`, notifikasi berhasil | | |
| SIMADKB-BT-US05-04 | Import Penduduk Hubungan Keluarga berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Penduduk Hubungan Keluarga<br>3. Isi semester & tahun<br>4. Unggah file `penduduk_hubungan_keluarga.xlsx`<br>5. Klik Import | Data tersimpan ke tabel `hubungan_keluarga_penduduk`, notifikasi berhasil | | |
| SIMADKB-BT-US05-05 | Import Penduduk Pekerjaan berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Penduduk Pekerjaan<br>3. Isi semester & tahun<br>4. Unggah file `penduduk_pekerjaan.xlsx`<br>5. Klik Import | Data tersimpan ke tabel `pekerjaan_penduduk`, notifikasi berhasil | | |
| SIMADKB-BT-US05-06 | Import gagal — ukuran file melebihi 2 MB | 1. Login ke sistem<br>2. Buka menu Import Excel<br>3. Pilih sembarang jenis data<br>4. Unggah file .xlsx berukuran > 2 MB<br>5. Klik Import | Sistem menolak file, menampilkan pesan error ukuran file melebihi batas 2 MB, tidak ada data yang tersimpan ke database | | |
| SIMADKB-BT-US05-07 | Import gagal — format file bukan .xlsx | 1. Login ke sistem<br>2. Buka menu Import Excel<br>3. Pilih sembarang jenis data<br>4. Unggah file berformat .csv atau .xls<br>5. Klik Import | Sistem menolak file, menampilkan pesan error format file tidak valid, tidak ada data tersimpan | | |
| SIMADKB-BT-US05-08 | Tampilkan data Jenis Kelamin Penduduk | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Penduduk → Jenis Kelamin<br>3. Pilih semester dan tahun yang memiliki data<br>4. Klik Tampilkan | Sistem menampilkan tabel data per kelurahan, per kecamatan, dan total keseluruhan dari tabel `jenis_kelamin_penduduk`, dilengkapi nama kelurahan dan kecamatan | | |
| SIMADKB-BT-US05-09 | Tampilkan data Agama Penduduk | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Penduduk → Agama<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data agama penduduk tampil dari tabel `agama_penduduk` per kelurahan, kecamatan, dan total | | |
| SIMADKB-BT-US05-10 | Tampilkan data Golongan Darah Penduduk | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Penduduk → Golongan Darah<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data golongan darah penduduk tampil dari tabel `golongan_darah_penduduk` dengan 3 level agregasi | | |
| SIMADKB-BT-US05-11 | Tampilkan data Hubungan Keluarga Penduduk | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Penduduk → Hubungan Keluarga<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `hubungan_keluarga_penduduk` tampil lengkap per wilayah | | |
| SIMADKB-BT-US05-12 | Tampilkan data Pekerjaan Penduduk | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Penduduk → Pekerjaan<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `pekerjaan_penduduk` tampil per kelurahan, kecamatan, dan total | | |

---

### US06 — Import & Tampil Data Kepala Keluarga (10 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US06-01 | Import Kepala Keluarga Agama berhasil | 1. Login ke sistem<br>2. Pilih jenis data: KK Agama<br>3. Isi semester & tahun<br>4. Unggah file `kepala_keluarga_agama.xlsx`<br>5. Klik Import | Data tersimpan ke tabel `agama_kepala_keluarga`, notifikasi berhasil | | |
| SIMADKB-BT-US06-02 | Import Kepala Keluarga Jenis Kelamin berhasil | 1. Login ke sistem<br>2. Pilih jenis data: KK Jenis Kelamin<br>3. Isi semester & tahun<br>4. Unggah file `kepala_keluarga_jenis_kelamin.xlsx`<br>5. Klik Import | Data tersimpan ke tabel `jenis_kelamin_kepala_keluarga` | | |
| SIMADKB-BT-US06-03 | Import Kepala Keluarga Pekerjaan berhasil | 1. Login ke sistem<br>2. Pilih jenis data: KK Pekerjaan<br>3. Unggah file `kepala_keluarga_pekerjaan.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `pekerjaan_kepala_keluarga` | | |
| SIMADKB-BT-US06-04 | Import Kepala Keluarga Pendidikan berhasil | 1. Login ke sistem<br>2. Pilih jenis data: KK Pendidikan<br>3. Unggah file `kepala_keluarga_pendidikan.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `pendidikan_kepala_keluarga` | | |
| SIMADKB-BT-US06-05 | Import Kepala Keluarga Status Kawin berhasil | 1. Login ke sistem<br>2. Pilih jenis data: KK Status Kawin<br>3. Unggah file `kepala_keluarga_status_kawin.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `status_kawin_kepala_keluarga` | | |
| SIMADKB-BT-US06-06 | Tampilkan data KK Agama | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Kepala Keluarga → Agama<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `agama_kepala_keluarga` tampil per kelurahan, kecamatan, dan total | | |
| SIMADKB-BT-US06-07 | Tampilkan data KK Jenis Kelamin | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Kepala Keluarga → Jenis Kelamin<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `jenis_kelamin_kepala_keluarga` tampil dengan 3 level agregasi | | |
| SIMADKB-BT-US06-08 | Tampilkan data KK Pekerjaan | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Kepala Keluarga → Pekerjaan<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `pekerjaan_kepala_keluarga` tampil per wilayah | | |
| SIMADKB-BT-US06-09 | Tampilkan data KK Pendidikan | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Kepala Keluarga → Pendidikan<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `pendidikan_kepala_keluarga` tampil per wilayah | | |
| SIMADKB-BT-US06-10 | Tampilkan data KK Status Kawin | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Kepala Keluarga → Status Kawin<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `status_kawin_kepala_keluarga` tampil per wilayah | | |

---

### US07 — Import & Tampil Status Kawin (6 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US07-01 | Import Status Kawin Agama berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Status Kawin Agama<br>3. Unggah file `status_kawin_agama.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `status_kawin_penduduk_agama` | | |
| SIMADKB-BT-US07-02 | Import Status Kawin Jenis Kelamin berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Status Kawin Jenis Kelamin<br>3. Unggah file `status_kawin_jenis_kelamin.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `status_kawin_penduduk_jenis_kelamin` | | |
| SIMADKB-BT-US07-03 | Import Status Kawin Pekerjaan berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Status Kawin Pekerjaan<br>3. Unggah file `status_kawin_pekerjaan.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `status_kawin_penduduk_pekerjaan` | | |
| SIMADKB-BT-US07-04 | Tampilkan data Status Kawin Agama | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Status Kawin → Agama<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `status_kawin_penduduk_agama` tampil per kelurahan, kecamatan, dan total | | |
| SIMADKB-BT-US07-05 | Tampilkan data Status Kawin Jenis Kelamin | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Status Kawin → Jenis Kelamin<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `status_kawin_penduduk_jenis_kelamin` tampil per wilayah | | |
| SIMADKB-BT-US07-06 | Tampilkan data Status Kawin Pekerjaan | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Status Kawin → Pekerjaan<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `status_kawin_penduduk_pekerjaan` tampil per wilayah | | |

---

### US08 — Import & Tampil Pendidikan (6 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US08-01 | Import Pendidikan Jenis Kelamin berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Pendidikan Jenis Kelamin<br>3. Unggah file `pendidikan_jenis_kelamin.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `jenis_kelamin_pendidikan` | | |
| SIMADKB-BT-US08-02 | Import Pendidikan Pekerjaan berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Pendidikan Pekerjaan<br>3. Unggah file `pendidikan_pekerjaan.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `pendidikan_penduduk_pekerjaan` | | |
| SIMADKB-BT-US08-03 | Import Pendidikan Golongan Darah berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Pendidikan Golongan Darah<br>3. Unggah file `pendidikan_golongan_darah.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `golongan_darah_pendidikan` | | |
| SIMADKB-BT-US08-04 | Tampilkan data Pendidikan Jenis Kelamin | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Pendidikan → Jenis Kelamin<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `jenis_kelamin_pendidikan` tampil per wilayah | | |
| SIMADKB-BT-US08-05 | Tampilkan data Pendidikan Pekerjaan | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Pendidikan → Pekerjaan<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `pendidikan_penduduk_pekerjaan` tampil dengan pemisahan per jenjang pendidikan | | |
| SIMADKB-BT-US08-06 | Tampilkan data Pendidikan Golongan Darah | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Pendidikan → Golongan Darah<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `golongan_darah_pendidikan` tampil dengan pemisahan per keterangan golongan darah | | |

---

### US09 — Import & Tampil Disabilitas (6 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US09-01 | Import Disabilitas Jenis Kelamin berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Disabilitas Jenis Kelamin<br>3. Unggah file `disabilitas_jenis_kelamin.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `jenis_kelamin_disabilitas` | | |
| SIMADKB-BT-US09-02 | Import Disabilitas Pekerjaan berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Disabilitas Pekerjaan<br>3. Unggah file `disabilitas_pekerjaan.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `pekerjaan_disabilitas` | | |
| SIMADKB-BT-US09-03 | Import Disabilitas Pendidikan berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Disabilitas Pendidikan<br>3. Unggah file `disabilitas_pendidikan.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `pendidikan_disabilitas` | | |
| SIMADKB-BT-US09-04 | Tampilkan data Disabilitas Jenis Kelamin | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Disabilitas → Jenis Kelamin<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `jenis_kelamin_disabilitas` tampil per wilayah dengan kolom jenis disabilitas | | |
| SIMADKB-BT-US09-05 | Tampilkan data Disabilitas Pekerjaan | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Disabilitas → Pekerjaan<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `pekerjaan_disabilitas` tampil dengan pemisahan per jenis disabilitas | | |
| SIMADKB-BT-US09-06 | Tampilkan data Disabilitas Pendidikan | 1. Login ke sistem<br>2. Buka menu Agregat DKB → Disabilitas → Pendidikan<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `pendidikan_disabilitas` tampil dengan pemisahan per jenis disabilitas | | |

---

## ITERASI 3 Sub2 — Struktur Umur

### US10 — Import Struktur Umur Umur Tunggal (8 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US10-01 | Import Struktur Umur Penduduk Umur Tunggal berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Penduduk Umur Tunggal<br>3. Isi semester dan tahun<br>4. Unggah file `struktur_umur_penduduk_umur_tunggal.xlsx`<br>5. Klik Import | Data tersimpan ke tabel `umur_tunggal_penduduk`, notifikasi berhasil | | |
| SIMADKB-BT-US10-02 | Import Struktur Umur Penduduk Status Kawin Umur Tunggal berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Penduduk Status Kawin Umur Tunggal<br>3. Unggah file `struktur_umur_penduduk_status_kawin_umur_tunggal.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `status_kawin_umur_tunggal_penduduk` | | |
| SIMADKB-BT-US10-03 | Import Struktur Umur Penduduk Usia Sekolah berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Penduduk Usia Sekolah<br>3. Unggah file `struktur_umur_penduduk_usia_sekolah.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `usia_sekolah_penduduk` | | |
| SIMADKB-BT-US10-04 | Import Struktur Umur Penduduk Demografi Usia berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Penduduk Demografi Usia<br>3. Unggah file `struktur_umur_penduduk_demografi_usia.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `usia_muda_produktif_tua_penduduk` | | |
| SIMADKB-BT-US10-05 | Import Struktur Umur KK Umur Tunggal berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Kepala Keluarga Umur Tunggal<br>3. Unggah file `struktur_umur_kepala_keluarga_umur_tunggal.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `umur_tunggal_kepala_keluarga` | | |
| SIMADKB-BT-US10-06 | Import Struktur Umur Disabilitas Umur Tunggal berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Disabilitas Umur Tunggal<br>3. Unggah file `struktur_umur_disabilitas_umur_tunggal.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `umur_tunggal_disabilitas` | | |
| SIMADKB-BT-US10-07 | Import Struktur Umur Disabilitas Pendidikan Umur Tunggal berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Disabilitas Pendidikan Umur Tunggal<br>3. Unggah file `struktur_umur_disabilitas_pendidikan_umur_tunggal.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `pendidikan_umur_tunggal_disabilitas` | | |
| SIMADKB-BT-US10-08 | Import Struktur Umur Golongan Darah Umur Tunggal berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Golongan Darah Umur Tunggal<br>3. Unggah file `struktur_umur_golongan_darah_umur_tunggal.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `umur_tunggal_golongan_darah` | | |

---

### US11 — Tampil & Custom Date Range Struktur Umur (13 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US11-01 | Tampilkan Penduduk Umur Tunggal dengan filter umur | 1. Login ke sistem<br>2. Buka menu Struktur Umur → Penduduk → Umur Tunggal<br>3. Pilih semester, tahun, dan isi nilai umur (misal: 25)<br>4. Klik Tampilkan | Data penduduk berumur 25 tahun dari tabel `umur_tunggal_penduduk` tampil per kelurahan dan kecamatan | | |
| SIMADKB-BT-US11-02 | Tampilkan Penduduk Status Kawin Umur Tunggal | 1. Login ke sistem<br>2. Buka menu Struktur Umur → Penduduk → Status Kawin Umur Tunggal<br>3. Pilih semester, tahun, dan umur<br>4. Klik Tampilkan | Data dari tabel `status_kawin_umur_tunggal_penduduk` tampil dengan kolom status kawin per wilayah | | |
| SIMADKB-BT-US11-03 | Tampilkan Penduduk Usia Sekolah | 1. Login ke sistem<br>2. Buka menu Struktur Umur → Penduduk → Usia Sekolah<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `usia_sekolah_penduduk` tampil dengan 4 jenjang sekolah per wilayah | | |
| SIMADKB-BT-US11-04 | Tampilkan Penduduk Demografi Usia (Muda/Produktif/Tua) | 1. Login ke sistem<br>2. Buka menu Struktur Umur → Penduduk → Demografi Usia<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `usia_muda_produktif_tua_penduduk` tampil dengan kolom usia muda, produktif, dan tua per wilayah | | |
| SIMADKB-BT-US11-05 | Tampilkan KK Umur Tunggal | 1. Login ke sistem<br>2. Buka menu Struktur Umur → Kepala Keluarga → Umur Tunggal<br>3. Pilih semester, tahun, dan umur<br>4. Klik Tampilkan | Data dari tabel `umur_tunggal_kepala_keluarga` tampil (lk, pr, jumlah) per wilayah untuk umur yang dipilih | | |
| SIMADKB-BT-US11-06 | Tampilkan Disabilitas Umur Tunggal | 1. Login ke sistem<br>2. Buka menu Struktur Umur → Disabilitas → Umur Tunggal<br>3. Pilih semester, tahun, dan umur<br>4. Klik Tampilkan | Data dari tabel `umur_tunggal_disabilitas` tampil dengan kolom jenis disabilitas per wilayah | | |
| SIMADKB-BT-US11-07 | Tampilkan Disabilitas Pendidikan Umur Tunggal | 1. Login ke sistem<br>2. Buka menu Struktur Umur → Disabilitas → Pendidikan Umur Tunggal<br>3. Pilih semester, tahun, dan umur<br>4. Klik Tampilkan | Data dari tabel `pendidikan_umur_tunggal_disabilitas` tampil per wilayah | | |
| SIMADKB-BT-US11-08 | Tampilkan Golongan Darah Umur Tunggal | 1. Login ke sistem<br>2. Buka menu Struktur Umur → Golongan Darah → Umur Tunggal<br>3. Pilih semester, tahun, dan umur<br>4. Klik Tampilkan | Data dari tabel `umur_tunggal_golongan_darah` tampil per wilayah | | |
| SIMADKB-BT-US11-09 | Filter umur tidak ada data | 1. Login ke sistem<br>2. Buka halaman Umur Tunggal manapun<br>3. Pilih semester, tahun, dan umur yang tidak memiliki data<br>4. Klik Tampilkan | Sistem menampilkan pesan "data tidak ditemukan" | | |
| SIMADKB-BT-US11-10 | Custom Date Range — Penduduk (from=0, to=17) | 1. Login ke sistem<br>2. Buka menu Custom Date Range → Penduduk<br>3. Pilih semester, tahun, isi from=0 dan to=17<br>4. Klik Tampilkan | Data penduduk usia 0–17 tahun dari tabel `umur_tunggal_penduduk` ditampilkan dengan jumlah total (laki-laki, perempuan, jumlah keseluruhan) per wilayah, judul menampilkan "Kelompok Umur 0-17" | | |
| SIMADKB-BT-US11-11 | Custom Date Range — Penduduk Status Kawin | 1. Login ke sistem<br>2. Buka menu Custom Date Range → Status Kawin<br>3. Isi from=18 dan to=35<br>4. Klik Tampilkan | Data status kawin penduduk usia 18–35 dari tabel `status_kawin_umur_tunggal_penduduk` tampil dengan kolom belum kawin, kawin, cerai hidup, cerai mati | | |
| SIMADKB-BT-US11-12 | Custom Date Range — Disabilitas | 1. Login ke sistem<br>2. Buka menu Custom Date Range → Disabilitas<br>3. Isi from=5 dan to=19<br>4. Klik Tampilkan | Data disabilitas usia 5–19 dari tabel `umur_tunggal_disabilitas` tampil teragregasi per wilayah | | |
| SIMADKB-BT-US11-13 | Custom Date Range — validasi from > to | 1. Login ke sistem<br>2. Buka menu Custom Date Range<br>3. Isi from=50 dan to=10 (from lebih besar dari to)<br>4. Klik Tampilkan | Sistem tidak menampilkan data atau menampilkan pesan validasi bahwa rentang umur tidak valid (from harus ≤ to) | | |

---

## ITERASI 4 — Kepemilikan Dokumen & Laporan Kinerja

### US12 — Import & Tampil Kepemilikan Dokumen (17 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US12-01 | Import data berhasil untuk file ≤ 2 MB | 1. Login ke sistem<br>2. Buka menu Import Excel<br>3. Pilih jenis data, isi semester dan tahun yang belum ada<br>4. Unggah file .xlsx sesuai template dengan ukuran ≤ 2 MB<br>5. Tekan tombol Import | Sistem menerima dan memproses file, menyimpan seluruh data ke database, menampilkan notifikasi import berhasil, dan data tersedia pada menu terkait | | |
| SIMADKB-BT-US12-02 | Import Kepemilikan Akta Kelahiran berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Kepemilikan Akta Kelahiran<br>3. Unggah file `kepemilikan_akta_kelahiran.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `akta_kelahiran` dengan kolom wajib_akta, memiliki, keterangan usia | | |
| SIMADKB-BT-US12-03 | Import Kepemilikan Akta Kawin (Sipil) berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Kepemilikan Akta Kawin<br>3. Unggah file `kepemilikan_akta_kawin.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `akta_kawin` | | |
| SIMADKB-BT-US12-04 | Import Kepemilikan Akta Kawin Agama berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Kepemilikan Akta Kawin Agama<br>3. Unggah file `kepemilikan_akta_kawin_agama.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `akta_kawin_agama` | | |
| SIMADKB-BT-US12-05 | Import Kepemilikan Akta Cerai (Sipil) berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Kepemilikan Akta Cerai<br>3. Unggah file `kepemilikan_akta_cerai.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `akta_cerai` | | |
| SIMADKB-BT-US12-06 | Import Kepemilikan Akta Cerai Agama berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Kepemilikan Akta Cerai Agama<br>3. Unggah file `kepemilikan_akta_cerai_agama.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `akta_cerai_agama` | | |
| SIMADKB-BT-US12-07 | Import Kepemilikan KIA berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Kepemilikan KIA<br>3. Unggah file `kepemilikan_kia.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `kia` dengan kolom jumlah awal, dinamis, memiliki | | |
| SIMADKB-BT-US12-08 | Import Kepemilikan Kartu Keluarga berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Kepemilikan Kartu Keluarga<br>3. Unggah file `kepemilikan_kartu_keluarga.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `kartu_keluarga` | | |
| SIMADKB-BT-US12-09 | Import Kepemilikan KTP berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Kepemilikan KTP<br>3. Unggah file `kepemilikan_ktp.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `ktp` dengan 15 kolom atribut (wajib_ktp, rekam, belum_rekam, ktp, blm_ktp — per LK/PR/JML) | | |
| SIMADKB-BT-US12-10 | Tampilkan Kepemilikan Akta Kelahiran — semua usia | 1. Login ke sistem<br>2. Buka menu Kepemilikan → Akta Kelahiran<br>3. Pilih semester, tahun, dan keterangan: Semua Usia<br>4. Klik Tampilkan | Data dari tabel `akta_kelahiran` tampil dengan kolom wajib akta, memiliki, persentase awal & dinamis, dikelompokkan berdasarkan kategori usia | | |
| SIMADKB-BT-US12-11 | Tampilkan Kepemilikan Akta Kelahiran — filter 0–1 tahun | 1. Login ke sistem<br>2. Buka menu Kepemilikan → Akta Kelahiran<br>3. Pilih keterangan: 0-1 Tahun<br>4. Klik Tampilkan | Data tampil hanya untuk kategori "0-1 Tahun", persentase kepemilikan terhitung | | |
| SIMADKB-BT-US12-12 | Tampilkan Kepemilikan Akta Kawin (Sipil) | 1. Login ke sistem<br>2. Buka menu Kepemilikan → Akta Kawin<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `akta_kawin` tampil dengan persentase kepemilikan per wilayah | | |
| SIMADKB-BT-US12-13 | Tampilkan Kepemilikan Akta Cerai Agama | 1. Login ke sistem<br>2. Buka menu Kepemilikan → Akta Cerai Agama<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `akta_cerai_agama` tampil per wilayah dengan kolom religius berdasarkan kategori agama pemilik dokumen | | |
| SIMADKB-BT-US12-14 | Tampilkan Kepemilikan KIA | 1. Login ke sistem<br>2. Buka menu Kepemilikan → KIA<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `kia` tampil dengan persentase awal dan dinamis per wilayah | | |
| SIMADKB-BT-US12-15 | Tampilkan Kepemilikan Kartu Keluarga | 1. Login ke sistem<br>2. Buka menu Kepemilikan → Kartu Keluarga<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `kartu_keluarga` tampil dengan kolom jumlah kartu keluarga, yang memiliki, belum memiliki, dan persentase per wilayah | | |
| SIMADKB-BT-US12-16 | Tampilkan Kepemilikan KTP | 1. Login ke sistem<br>2. Buka menu Kepemilikan → KTP<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `ktp` tampil dengan dua persentase: persentase sudah rekam dan persentase memiliki KTP per wilayah | | |
| SIMADKB-BT-US12-17 | Tampilkan data kepemilikan — tidak ada data | 1. Login ke sistem<br>2. Buka halaman kepemilikan manapun<br>3. Pilih semester dan tahun yang tidak memiliki data<br>4. Klik Tampilkan | Sistem menampilkan pesan "data tidak ditemukan" | | |

---

### US13 — Import & Tampil Laporan Kinerja PDAK (4 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US13-01 | Import Laporan Kinerja Capil Format PDAK berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Laporan Kinerja Capil Format PDAK<br>3. Unggah file Excel sesuai format pemerintah<br>4. Klik Import | Data tersimpan ke tabel `laporan_kinerja_capil_format_pdak` dengan 22 kolom atribut layanan | | |
| SIMADKB-BT-US13-02 | Import Laporan Kinerja Dafduk Format PDAK berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Laporan Kinerja Dafduk Format PDAK<br>3. Unggah file Excel sesuai format pemerintah<br>4. Klik Import | Data tersimpan ke tabel `laporan_kinerja_dafduk_format_pdak` dengan 24 kolom atribut | | |
| SIMADKB-BT-US13-03 | Tampilkan Laporan Kinerja Capil dengan filter tanggal | 1. Login ke sistem<br>2. Buka menu Laporan Kinerja → Capil PDAK<br>3. Isi tanggal mulai dan tanggal selesai (contoh: 2025-01-01)<br>4. Klik Tampilkan | Data dari tabel `laporan_kinerja_capil_format_pdak` tampil dengan berdasarkan filter rentang tanggal yang dipilih, per kelurahan dan kecamatan | | |
| SIMADKB-BT-US13-04 | Tampilkan Laporan Kinerja Dafduk dengan filter tanggal | 1. Login ke sistem<br>2. Buka menu Laporan Kinerja → Dafduk PDAK<br>3. Isi tanggal mulai dan selesai<br>4. Klik Tampilkan | Data dari tabel `laporan_kinerja_dafduk_format_pdak` tampil per wilayah berdasarkan rentang tanggal laporan | | |

---

### US14 — Layanan Eksternal API (4 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US14-01 | Tampilkan data Pelayanan Online (API Eksternal berhasil) | 1. Login ke sistem<br>2. Buka menu Laporan → Pelayanan Online<br>3. Isi tanggal start dan finish<br>4. Klik Tampilkan | Sistem menghubungi layanan data pelayanan online, data berhasil diambil dan ditampilkan. Token login disimpan sementara selama 1 jam | | |
| SIMADKB-BT-US14-02 | Tampilkan data Cetak e-KTP (API Eksternal berhasil) | 1. Login ke sistem<br>2. Buka menu Laporan → Cetak e-KTP<br>3. Isi tanggal mulai dan tanggal selesai (contoh: 01-01-2025)<br>4. Klik Tampilkan | Sistem menghubungi layanan cetak e-KTP Kota Samarinda, data cetak KTP berhasil diambil dan ditampilkan | | |
| SIMADKB-BT-US14-03 | Tampilkan data Perekaman e-KTP (API Eksternal berhasil) | 1. Login ke sistem<br>2. Buka menu Laporan → Perekaman e-KTP<br>3. Isi tanggal mulai dan tanggal selesai<br>4. Klik Tampilkan | Sistem menghubungi layanan perekaman e-KTP Kota Samarinda, data perekaman berhasil diambil dan ditampilkan | | |
| SIMADKB-BT-US14-04 | Layanan eksternal tidak dapat diakses (gangguan koneksi) | 1. Login ke sistem<br>2. Buka menu Laporan → Pelayanan Online / Cetak e-KTP / Perekaman<br>3. Isi filter dan klik Tampilkan saat server API eksternal tidak merespons | Sistem menangani kegagalan koneksi, menampilkan pesan kesalahan yang informatif, halaman tidak crash | | |

---

## ITERASI 5 — Statistik Kelompok Umur

### US15 — Import Statistik Kelompok Umur (8 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US15-01 | Import Kelompok Umur Penduduk berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Penduduk Kelompok Umur<br>3. Unggah file `struktur_umur_penduduk_kelompok_umur.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `kelompok_umur_penduduk`, notifikasi berhasil | | |
| SIMADKB-BT-US15-02 | Import Status Kawin Kelompok Umur Penduduk berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Penduduk Status Kawin Kelompok Umur<br>3. Unggah file `struktur_umur_penduduk_status_kawin_kelompok_umur.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `status_kawin_kelompok_umur_penduduk` | | |
| SIMADKB-BT-US15-03 | Import Kelompok Umur Kepala Keluarga berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Kepala Keluarga Kelompok Umur<br>3. Unggah file `struktur_umur_kepala_keluarga_kelompok_umur.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `kelompok_umur_kepala_keluarga` | | |
| SIMADKB-BT-US15-04 | Import Status Kawin KU Kepala Keluarga berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur KK Status Kawin Kelompok Umur<br>3. Unggah file `struktur_umur_kepala_keluarga_status_kawin_kelompok_umur.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `status_kawin_kelompok_umur_kepala_keluarga` | | |
| SIMADKB-BT-US15-05 | Import Kelompok Umur Disabilitas berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Disabilitas Kelompok Umur<br>3. Unggah file `struktur_umur_disabilitas_kelompok_umur.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `kelompok_umur_disabilitas` | | |
| SIMADKB-BT-US15-06 | Import Usia Sekolah Kelompok Umur Disabilitas berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Disabilitas Usia Sekolah<br>3. Unggah file `struktur_umur_disabilitas_usia_sekolah.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `usia_sekolah_kelompok_umur_disabilitas` | | |
| SIMADKB-BT-US15-07 | Import Kelompok Umur Golongan Darah berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Golongan Darah Kelompok Umur<br>3. Unggah file `struktur_umur_golongan_darah_kelompok_umur.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `kelompok_umur_golongan_darah` | | |
| SIMADKB-BT-US15-08 | Import Kelompok Umur Agama berhasil | 1. Login ke sistem<br>2. Pilih jenis data: Struktur Umur Agama Kelompok Umur<br>3. Unggah file `struktur_umur_agama_kelompok_umur.xlsx`<br>4. Klik Import | Data tersimpan ke tabel `kelompok_umur_agama` | | |

---

### US16 — Tampil Statistik Kelompok Umur (8 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US16-01 | Tampilkan Statistik Kelompok Umur Penduduk | 1. Login ke sistem<br>2. Buka menu Statistik Kelompok Umur → Penduduk<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `kelompok_umur_penduduk` tampil per kelompok umur (rentang 5 tahun), per kelurahan, kecamatan, dan total. Data keseluruhan dikelompokkan per rentang kelompok umur | | |
| SIMADKB-BT-US16-02 | Tampilkan Statistik Status Kawin KU Penduduk | 1. Login ke sistem<br>2. Buka menu Statistik Kelompok Umur → Penduduk → Status Kawin<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `status_kawin_kelompok_umur_penduduk` tampil per wilayah dengan kolom status kawin | | |
| SIMADKB-BT-US16-03 | Tampilkan Statistik Kelompok Umur Kepala Keluarga | 1. Login ke sistem<br>2. Buka menu Statistik Kelompok Umur → Kepala Keluarga<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `kelompok_umur_kepala_keluarga` tampil dengan penjumlahan total semua kolom per wilayah | | |
| SIMADKB-BT-US16-04 | Tampilkan Statistik Status Kawin KU Kepala Keluarga | 1. Login ke sistem<br>2. Buka menu Statistik Kelompok Umur → KK → Status Kawin<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `status_kawin_kelompok_umur_kepala_keluarga` tampil per wilayah | | |
| SIMADKB-BT-US16-05 | Tampilkan Statistik Kelompok Umur Disabilitas | 1. Login ke sistem<br>2. Buka menu Statistik Kelompok Umur → Disabilitas<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `kelompok_umur_disabilitas` tampil per kelompok umur dan per wilayah | | |
| SIMADKB-BT-US16-06 | Tampilkan Statistik Usia Sekolah Disabilitas | 1. Login ke sistem<br>2. Buka menu Statistik Kelompok Umur → Disabilitas → Usia Sekolah<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `usia_sekolah_kelompok_umur_disabilitas` tampil per wilayah | | |
| SIMADKB-BT-US16-07 | Tampilkan Statistik Kelompok Umur Golongan Darah | 1. Login ke sistem<br>2. Buka menu Statistik Kelompok Umur → Golongan Darah<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `kelompok_umur_golongan_darah` tampil per kelompok umur dan per wilayah | | |
| SIMADKB-BT-US16-08 | Tampilkan Statistik Kelompok Umur Agama | 1. Login ke sistem<br>2. Buka menu Statistik Kelompok Umur → Agama<br>3. Pilih semester dan tahun<br>4. Klik Tampilkan | Data dari tabel `kelompok_umur_agama` tampil per kelompok umur dan per wilayah berdasarkan kategori agama | | |

---

## Cross-Cutting

### US17 — Download Template Excel (3 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US17-01 | Daftar template tampil lengkap | 1. Login ke sistem<br>2. Buka halaman menu Download Template / Import Excel | Sistem menampilkan semua **43 template** yang tersedia dengan nama file dan tombol download | | |
| SIMADKB-BT-US17-02 | Download template Excel berhasil | 1. Login ke sistem<br>2. Buka menu Download Template<br>3. Klik tombol Download pada salah satu template (misal: `penduduk_agama.xlsx`) | File `.xlsx` berhasil diunduh dari direktori `/format_file_excel_import/`, file tidak kosong dan sesuai format yang diharapkan | | |
| SIMADKB-BT-US17-03 | Akses halaman download tanpa login ditolak | 1. Buka URL halaman download template secara langsung tanpa login | Sistem mengarahkan pengguna ke halaman login, akses ditolak karena belum masuk | | |

---

### US18 — Kontrol Akses & Otorisasi (3 TC)

| Test Code | Test Case | Test Steps | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|
| SIMADKB-BT-US18-01 | User tanpa permission import tidak dapat mengakses halaman import | 1. Login sebagai user dengan role yang tidak memiliki permission import<br>2. Coba akses halaman Import Excel | Sistem menolak akses dan menampilkan halaman 403 Forbidden atau mengarahkan ke halaman utama dengan pesan error | | |
| SIMADKB-BT-US18-02 | User tanpa permission view tidak dapat melihat data | 1. Login sebagai user dengan role terbatas<br>2. Coba akses halaman tampilan data (misal: Agregat DKB → Penduduk) | Sistem menolak akses, menampilkan 403 atau redirect sesuai kebijakan permission Spatie | | |
| SIMADKB-BT-US18-03 | Admin dapat mengakses seluruh fitur | 1. Login sebagai user dengan role Admin<br>2. Akses semua menu: Import, Tampil Data (semua fitur), Manajemen User, Manajemen Role, Download Template | Semua halaman dan fitur dapat diakses tanpa error, tidak ada pembatasan akses | | |

---

## Rekap Total Test Case

| Iterasi | User Story | Jumlah TC |
|---|---|:---:|
| Iterasi 1 — Autentikasi & RBAC | US01, US02, US03 | **12** |
| Iterasi 2 — Master Wilayah | US04 | **2** |
| Iterasi 3 Sub1 — Agregat DKB: Penduduk | US05 | **12** |
| Iterasi 3 Sub1 — Agregat DKB: Kepala Keluarga | US06 | **10** |
| Iterasi 3 Sub1 — Agregat DKB: Status Kawin | US07 | **6** |
| Iterasi 3 Sub1 — Agregat DKB: Pendidikan | US08 | **6** |
| Iterasi 3 Sub1 — Agregat DKB: Disabilitas | US09 | **6** |
| Iterasi 3 Sub2 — Struktur Umur: Import Umur Tunggal | US10 | **8** |
| Iterasi 3 Sub2 — Struktur Umur: Tampil & Custom Date Range | US11 | **13** |
| Iterasi 4 — Kepemilikan Dokumen | US12 | **17** |
| Iterasi 4 — Laporan Kinerja PDAK | US13 | **4** |
| Iterasi 4 — Layanan Eksternal API | US14 | **4** |
| Iterasi 5 — Statistik Kelompok Umur: Import | US15 | **8** |
| Iterasi 5 — Statistik Kelompok Umur: Tampil | US16 | **8** |
| Cross-cutting — Download Template | US17 | **3** |
| Cross-cutting — Kontrol Akses | US18 | **3** |
| | **GRAND TOTAL** | **122** |
