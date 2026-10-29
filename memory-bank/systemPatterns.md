# System Patterns

> **Terakhir Diperbarui:** 2026-10-29  
> **Status:** Draft

---

## High-Level Architecture
Sistem mengikuti arsitektur MVC (Model-View-Controller) klasik berbasis web:

```
[ Client Browser ]
        │
        ▼ (HTTP Request)
[ Routing / Front Controller ]
        │
        ▼
[ Controllers / Application Layer ]
   ├── Input Validation & Auth Check
   ├── Business Logic & Helper Utilities
   └── PDF / Report Generation Service
        │               │
        ▼               ▼
[ Models / Data Access ]   [ Views / Templates ]
        │               │
        ▼               ▼
[ Relational Database ]    [ Rendered HTML / Output PDF / File Download ]
```

<!-- UPDATE: Tambahkan diagram integrasi eksternal jika ada service pihak ketiga -->

---

## Design Patterns Utama
- **MVC (Model-View-Controller):** Pemisahan tegas antara logika presentasi (View), logika orkestasi aplikasi (Controller), dan akses data/persisten (Model).
- **Front Controller:** Seluruh permintaan HTTP diarahkan melalui titik masuk tunggal untuk routing, penanganan sesi, dan bootstrap lingkungan.
- **Base Controller Inheritance:** Abstraksi otentikasi, pengecekan batas waktu input, dan helper global diletakkan pada base controller bersama.
- **Service / Helper Utility Pattern:** Logika manipulasi data format tanggal, angka mata uang, dan formatting cetak diisolasi dalam modul helper khusus.
- **Template Method / View Composite:** Tampilan aplikasi menggunakan template induk (header, sidebar, content wrapper, footer) yang memuat sub-view modular.

---

## Struktur Folder Proyek (Logis)
```
/
├── application/         # Kode inti aplikasi
│   ├── config/          # Konfigurasi aplikasi, rute, dan database
│   ├── controllers/     # Penangan request HTTP dan alur kerja bisnis
│   ├── core/            # Kelas dasar ekstensi (Base Controller, dll.)
│   ├── helpers/         # Fungsi bantuan modular (format mata uang, tanggal)
│   ├── libraries/       # Library eksternal/internal (engine PDF, generator dokumen)
│   ├── models/          # Abstraksi query dan manipulasi data database
│   └── views/           # Template antarmuka pengguna dan berkas cetak
├── assets/              # Berkas statis (CSS, JS, plugin antarmuka, font)
├── db/                  # Skrip migrasi, skema DDL, dan backup basis data
├── images/              # Aset gambar sistem, logo, dan identitas visual
├── uploads/             # Direktori penyimpanan berkas berkas yang diunggah pengguna
└── memory-bank/         # Dokumentasi terstruktur dan single source of truth AI
```

<!-- UPDATE: Perbarui struktur folder jika ada penambahan direktori baru -->

---

## Konvensi Penamaan

### File & Direktori
- **Controllers:** PascalCase tunggal/jamak deskriptif fitur (contoh: `Barang.php`, `Laporan.php`).
- **Models:** PascalCase berakhiran suffix peran (contoh: `Barang_model.php`, `App.php`).
- **Views:** lower_case atau kebab-case diorganisir per folder modul (contoh: `views/laporan/laporanstokfifo/index.php`).
- **Helpers / Libraries:** snake_case atau PascalCase sesuai peran (contoh: `mdata_helper.php`, `Pdf.php`).

### Variabel & Fungsi
- Variabel PHP: camelCase atau snake_case konsisten per modul (contoh: `$kdRuangan`, `$tglAwal`, `$rsLaporan`).
- Fungsi/Metode: camelCase atau snake_case deskriptif aksi (contoh: `cekBatasWaktuPenginputan()`, `get_laporanstokfifo()`).
- Kolom Database: lower_case tanpa spasi atau snake_case (contoh: `kdruangan`, `namabarang`, `tahunanggaran`).

### Endpoint / Routing URL
- Format URL: `/{nama_modul}/{nama_aksi}/{param1}/{param2}/...`
- Contoh pola rute: `/laporan/laporanstokfifo_cetak/{jenis}/{ruangan}/{kelompok}/{barang}`

---

## Data Flow Utama

### 1. Alur Transaksi Persediaan (Input Barang / Pemakaian)
1. Klien mengirim formulir transaksi via POST.
2. Controller memeriksa validitas sesi (`is_login`) dan batasan waktu input (`isBatasPenginputan`).
3. Controller memvalidasi integritas data masukan (kuantitas, referensi barang, tanggal).
4. Model menjalankan mutasi transaksi (insert data transaksi & pembaruan kartu stok).
5. Controller mengembalikan respon JSON / redirect dengan flash message status.

### 2. Alur Pelaporan & Ekspor Data
1. Pengguna memilih parameter filter (periode tanggal, ruangan, kelompok barang) pada view filter.
2. Request GET/POST diteruskan ke controller laporan terkait.
3. Controller memanggil Model untuk mengambil dataset berdasarkan klausa filter.
4. Controller menentukan format keluaran:
   - Jika HTML: Me-render view tabel.
   - Jika Cetak / PDF: Menginstansiasi engine PDF, memasukkan HTML template dokumen, dan men-generate stream file.
   - Jika Spreadsheet: Men-set header HTTP download dan mem-parsing tabel data.

---

## Konvensi Error Handling & Logging
- **Otentikasi Gagal:** Redirect otomatis ke halaman login disertai pesan flash notifikasi error.
- **Validasi Gagal:** Menampilkan pesan error spesifik per kolom masukan di form atau via modal dialog.
- **Database Error:** Pada mode produksi, sembunyikan pesan error query mentah (`db_debug = FALSE`) dan catat ke file log aplikasi.
- **Halaman Tidak Ditemukan:** Ditangani oleh controller error dedicated (contoh: `My404`) untuk pengalaman pengguna yang ramah.

<!-- UPDATE: Tentukan format log eksternal atau monitoring tools bila diadopsi -->

---

## Konvensi API & Pertukaran Data
- Endpoint internal AJAX menggunakan metode POST/GET dengan balasan berformat JSON:
  ```json
  {
    "status": true,
    "message": "Data berhasil disimpan",
    "data": {}
  }
  ```
- Endpoint Datatables menggunakan struktur parameter pagination, searching, dan sorting standar server-side.
