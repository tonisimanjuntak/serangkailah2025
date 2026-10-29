# Tech Context

> **Terakhir Diperbarui:** 2026-10-29  
> **Status:** Draft

---

## 1. Daftar Teknologi
- **Server Runtime / Language Engine:** Runtime berbasis web (TBD / Mengikuti instalasi server lokal/produksi)
- **Framework Aplikasi:** Framework arsitektur MVC berbasis web (TBD / Mengikuti dependensi proyek terpasang)
- **Database Engine:** Relational Database Management System (RDBMS) berbasis SQL (contoh: MySQL / MariaDB)
- **Document / PDF Rendering Engine:** Library generator PDF berbasis server (termasuk modul renderer dokumen terintegrasi)
- **Frontend Assets & UI Layer:** HTML5, CSS3, JavaScript, UI Admin Template (contoh: AdminLTE / bootstrap-based assets)
- **Komponen UI Tambahan:** Datatables, Bootbox, JQuery UI / Confirm, Sweetalert, Select2

<!-- UPDATE: Tentukan versi spesifik runtime dan library setelah inventarisasi lengkap -->

---

## 2. Persyaratan Environment
- **Operating System:** Platform-agnostic (Windows / Linux / macOS didukung).
- **Web Server:** HTTP Server berkemampuan routing URL (contoh: Apache HTTPD, Nginx, atau built-in CLI server).
- **Database Server:** Server RDBMS aktif dengan hak akses pembuatan/pembacaan tabel.
- **Dependency & Package Manager:** Package manager pendukung (jika dependensi eksternal dikelola via manifest).
- **Ekstensi Runtime Wajib:**
  - Driver koneksi basis data.
  - Modul manipulasi string multibyte dan encoding.
  - Modul grafis / image processing (untuk rendering logo dan watermark pada dokumen).

---

## 3. Setup & Instalasi (Langkah Generik)
1. **Clone / Persiapkan Repositori:**
   Tempatkan direktori proyek pada document root web server lokal.
2. **Konfigurasi Lingkungan:**
   Salin berkas konfigurasi template menjadi berkas konfigurasi aktif:
   ```bash
   cp config.example.ext config.active.ext
   ```
3. **Pengaturan Basis Data:**
   - Buat skema database baru di RDBMS.
   - Eksekusi berkas skrip DDL/skema yang terdapat di folder basis data (contoh: direktori `db/`).
   - Sesuaikan konfigurasi koneksi (`hostname`, `username`, `password`, `database`).
4. **Izin Berkas & Direktori:**
   Pastikan folder penyimpanan sementara dan upload (`uploads/`, cache, logs) memiliki hak akses tulis (write permission).
5. **Jalankan Aplikasi:**
   Akses aplikasi melalui peramban web pada URL lokal yang telah dikonfigurasi.

<!-- UPDATE: Sesuaikan detail port dan URL host lokal yang digunakan -->

---

## 4. Konvensi Environment Variable & Konfigurasi
- Konfigurasi parameter lingkungan disimpan pada berkas konfigurasi sentral atau environment configuration:
  - `BASE_URL`: URL utama penunjuk host aplikasi.
  - `DB_HOST`: Alamat host server database.
  - `DB_USER`: Akun pengguna basis data.
  - `DB_PASS`: Kata sandi pengguna basis data.
  - `DB_NAME`: Nama basis data aktif.
  - `APP_ENV`: Status lingkungan (`development`, `testing`, `production`).

---

## 5. Perintah Umum (Command Placeholders)
```bash
# Menjalankan server lokal (contoh generik)
$ [COMMAND_RUN_SERVER]

# Eksekusi migrasi skema database (contoh generik)
$ [COMMAND_DB_MIGRATE]

# Menjalankan unit test / integrasi (contoh generik)
$ [COMMAND_RUN_TESTS]

# Build / kompilasi asset antarmuka (contoh generik)
$ [COMMAND_BUILD_ASSETS]
```

<!-- UPDATE: Isi perintah operasional aktual sesuai toolchain yang diaktifkan -->

---

## 6. Batasan Teknis yang Diketahui
- **Memory Limit pada Ekspor Dokumen:** Pembuatan laporan berkapasitas ribuan baris memerlukan alokasi memori runtime yang memadai untuk mencegah pemutusan eksekusi di tengah proses.
- **Timezone & Sinkronisasi Jam Server:** Seluruh transaksi persediaan bergantung pada stempel waktu server; pastikan timezone tersinkronisasi.
- **Batas Waktu Input Transaksi:** Terdapat mekanisme penguncian tanggal input operasional per unit/ruangan yang menghentikan mutasi lampau secara otomatis.
- **Kompatibilitas Encoding Karakter:** Penggunaan karakter non-standar pada nama barang membutuhkan collation basis data UTF-8 untuk mencegah korupsi data cetak.
