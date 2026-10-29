# Template Conventions

> **Terakhir Diperbarui:** 2026-10-29  
> **Status:** Draft — Kondisional  
> **Peran Dokumen:** Aturan khusus template dokumen cetak/laporan. **TIDAK dibaca kecuali sedang membuat atau mengubah laporan/dokumen.**

---

## 1. Struktur Template (Layout, Partial, Section)
- **Layout Utama:** Setiap halaman aplikasi menggunakan template induk yang memuat:
  - `header` — Navigasi atas, identitas sistem, info pengguna aktif.
  - `sidebar` — Menu navigasi modul berdasarkan hak akses pengguna.
  - `content` — Area konten dinamis yang dimuat dari sub-view.
  - `footer` — Informasi versi dan hak cipta.
- **Partial View:** Komponen reusable (misalnya: filter form, modal konfirmasi) diletakkan pada sub-folder terpisah atau di-include langsung.
- **View Laporan:** Setiap jenis laporan memiliki folder tersendiri dalam `views/laporan/{nama_laporan}/`:
  - `index` — Halaman filter / parameter laporan.
  - `cetak` — Template output cetak / PDF.
  - `excel` — Template output spreadsheet / tabel download.

---

## 2. Konvensi CSS / Print (A4, Margin, Font)
- **Ukuran Halaman Cetak:** A4 (210 × 297 mm) untuk orientasi portrait; A4 landscape untuk laporan tabel lebar.
- **Margin Halaman:**
  - Atas: 15–20 mm
  - Bawah: 15–20 mm
  - Kiri: 20–25 mm
  - Kanan: 15–20 mm
- **Font Cetak:** Font serif standar (contoh: Times New Roman atau padanan sistem) ukuran 10–12pt untuk isi tabel, 14–16pt untuk judul.
- **CSS Print Media Query:** Gunakan `@media print { ... }` untuk menyembunyikan elemen non-cetak (navigasi, tombol, sidebar).
- **Tabel:** Border solid 1px warna gelap, header tabel diberi warna latar abu-abu muda. Gunakan `page-break-inside: avoid` pada baris data penting.

---

## 3. Placeholder & Variabel Dinamis
Variabel berikut umumnya tersedia di template laporan dan disuplai oleh controller:

| Variabel | Deskripsi |
|---|---|
| `$namaruangan` | Nama ruangan / unit kerja terkait |
| `$subjudul` | Sub-judul laporan (kelompok barang, nama barang) |
| `$tglawal` / `$tglakhir` | Rentang tanggal periode laporan |
| `$tahunanggaran` | Tahun anggaran aktif |
| `$rslaporan` | Hasil dataset query untuk ditampilkan dalam tabel |
| `$kdruangan`, `$kdupt` | Kode identifikasi ruangan dan unit pelaksana teknis |

<!-- UPDATE: Tambahkan variabel baru saat controller laporan baru dibuat -->

---

## 4. Komponen Reusable (Header, Footer, Signature Block)
- **Kop Surat / Header Laporan:**
  - Logo instansi (kiri) + Nama instansi, alamat, kota (tengah/kanan).
  - Garis horizontal pemisah di bawah kop.
- **Footer Laporan:**
  - Nomor halaman (jika multi-page PDF).
  - Tanggal cetak otomatis.
- **Blok Tanda Tangan:**
  - Posisi di bawah tabel data, rata kanan atau dua kolom (kiri: mengetahui, kanan: pembuat).
  - Data penandatangan diambil dari tabel `penandatangan` / `pengaturan`.
  - Format: Jabatan, nama, NIP.

---

## 5. Konvensi Penamaan File Template
- Folder: `views/laporan/{nama_modul_laporan}/`
- File filter: `index.php` (atau nama deskriptif `filter.php`)
- File cetak HTML/PDF: `cetak.php`, `cetak_fifo.php`, `cetak_fifo_grouping.php`
- File ekspor spreadsheet: `excel.php`, `excel_fifo.php`, `excel_fifo_grouping.php`
- Gunakan underscore (`_`) sebagai separator kata, huruf kecil semua.

<!-- UPDATE: Standarisasi penamaan bila ada perubahan pola -->
