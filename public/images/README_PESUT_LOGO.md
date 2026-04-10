# Instruksi Menyimpan Logo Pesut Samarinda

## 📁 Lokasi File

Simpan gambar logo Pesut Samarinda yang telah Anda upload ke path berikut:

```
/Applications/XAMPP/xamppfiles/htdocs/rumahdata 2.0/public/images/pesut-logo.png
```

## 📝 Langkah-langkah:

1. **Download/Save gambar** logo Pesut Samarinda yang Anda miliki
2. **Rename file** menjadi: `pesut-logo.png`
3. **Copy file** ke folder: `public/images/`
4. **Refresh browser** untuk melihat loading animation dengan logo asli

## ✅ Verifikasi

Setelah menyimpan gambar, test loading animation dengan:

1. Buka browser console (F12)
2. Jalankan command:
   ```javascript
   window.loadingAnimation.show('Testing...');
   ```
3. Logo Pesut Samarinda harus muncul dengan efek shake
4. Hide dengan:
   ```javascript
   window.loadingAnimation.hide();
   ```

## 🎨 Spesifikasi Gambar

- **Format:** PNG (dengan transparent background lebih baik)
- **Ukuran:** Optimal 500x500px atau lebih
- **Nama File:** `pesut-logo.png` (case-sensitive)
- **Lokasi:** `public/images/pesut-logo.png`

## 🔄 Jika Gambar Tidak Muncul

Jika setelah menyimpan gambar masih tidak muncul:

1. **Clear browser cache** (Ctrl+Shift+R atau Cmd+Shift+R)
2. **Periksa path file** - pastikan nama file exact: `pesut-logo.png`
3. **Periksa permissions** - file harus readable
4. **Check console** - buka browser console untuk error messages

## 📍 Path Lengkap

```
/Applications/XAMPP/xamppfiles/htdocs/rumahdata 2.0/
└── public/
    └── images/
        └── pesut-logo.png  ← SIMPAN DI SINI
```

## 🎯 URL Akses

Setelah disimpan, gambar dapat diakses via:
```
http://localhost/images/pesut-logo.png
```
atau
```
http://127.0.0.1/images/pesut-logo.png
```

---

**Note:** Gambar ini akan digunakan untuk loading animation dengan efek shake di seluruh aplikasi.
