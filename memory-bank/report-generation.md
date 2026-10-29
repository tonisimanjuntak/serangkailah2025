# Report Generation

> **Terakhir Diperbarui:** 2026-10-29  
> **Status:** Draft — Kondisional  
> **Peran Dokumen:** Panduan pembuatan laporan PDF (TCPDF). **HANYA dibaca saat task terkait laporan.**

---

## 1. Alur Generate Laporan (Data → Render → PDF)
1. **Ambil Parameter** (rentang tanggal, ruangan, kelompok, barang) dari URI atau POST.
2. **Query Data** lewat model laporan (`Laporan_model->get_*`).
3. **Load Library PDF** (`$this->load->library('Pdf');`).
4. **Instansiasi TCPDF** dengan konfigurasi dasar (orientasi, ukuran A4, margin, font).
5. **Set Header / Footer** menggunakan method `setHeaderData()` dan `setFooterData()`.
6. **Add Page**, tulis HTML view laporan (`$this->load->view('laporan/.../cetak', $data, TRUE)`).
7. **Write HTML** ke PDF (`$pdf->writeHTML($html, true, false, true, false, '');`).
8. **Output PDF** (`$pdf->Output($filename, 'I');`).

---

## 2. Daftar Jenis Laporan
- **Laporan Stok FIFO** – `laporan/laporanpemakaian/cetak`
- **Daftar Mutasi Persediaan** – `laporan/daftarmutasipersediaan/cetak`
- **Laporan Mutasi FIFO Grouping** – `laporan/daftarmutasipersediaan/cetak_fifo_grouping`
- **Laporan Rekapitulasi Tahunan** – (belum ada, placeholder).

---

## 3. Struktur File TCPDF (Folder, Class, Config)
```
application/
├─ libraries/
│  └─ Pdf.php            # Extends TCPDF, optional custom overrides
├─ third_party/
│  └─ tcpdf/              # Vendor library source
```
- **Pdf.php** biasanya berisi class `Pdf extends TCPDF` dengan konstruktor memanggil `parent::__construct();` dan optional set default header/footer.
- **Config** dapat didefinisikan di `application/config/pdf.php` (jika ada) untuk mengatur default font, margin, dll.

---

## 4. Contoh Pola Inisialisasi TCPDF (Header, Footer, Page Break, Font)
```php
$this->load->library('Pdf');
$pdf = new Pdf();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Inventaris');
$pdf->SetTitle('Laporan Stok FIFO');
$pdf->SetSubject('Stok');
$pdf->SetKeywords('stok, laporan');
$pdf->SetHeaderData('', 0, 'Nama Instansi', "Alamat Instansi\nTelp: 12345678");
$pdf->setHeaderFont(Array('helvetica', '', 10));
$pdf->setFooterFont(Array('helvetica', '', 8));
$pdf->SetMargins(20, 30, 20);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();
$html = $this->load->view('laporan/laporanpemakaian/cetak', $data, TRUE);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('laporan_stok_fifo.pdf', 'I');
```

---

## 5. Konvensi Penamaan Laporan & File Output
- **Nama File PDF:** `laporan_{tipe}_{yyyyMMddHHmm}.pdf` (contoh: `laporan_stokfifo_202610291200.pdf`).
- **Folder Output (jika disimpan):** `uploads/laporan/` dengan subfolder per tahun.
- **Variabel Penamaan:** gunakan snake_case untuk file dan variabel.

---

## 6. Step‑by‑Step Menambahkan Laporan Baru
1. Tambah method controller (`cetak_{nama}`) yang menerima parameter.
2. Buat model method (`get_{nama}`) mengembalikan dataset.
3. Buat view HTML (`cetak_{nama}.php`) di folder `views/laporan/{nama}/`.
4. Update routing (`application/config/routes.php`) jika diperlukan.
5. Uji generate PDF via browser, periksa layout, margin, page break.

---

## 7. Troubleshooting Umum
- **Memory Limit:** Tambah `ini_set('memory_limit', '256M');` sebelum inisialisasi TCPDF bila laporan > 10k baris.
- **Font / Charset:** Pastikan font yang dipilih mendukung karakter UTF‑8 (misal `dejavusans`). Set `SetFont('dejavusans', '', 10);`.
- **Page Break Tidak Berfungsi:** Tambahkan CSS `page-break-after: always;` pada elemen HTML yang harus dipisah.
- **Tabel Lebar Terpotong:** Gunakan `SetAutoPageBreak(TRUE, 15);` dan sesuaikan margin atau ubah orientasi ke landscape (`$pdf->AddPage('L');`).

---

## 8. Aturan Pemakaian
- **Jangan Muat File Ini** kecuali tugas eksplisit pembuatan/ubah laporan.
- **Pastikan Library TCPDF Terinstal** di `third_party/tcpdf/`.
- **Gunakan Placeholder** bila belum ada data spesifik.
- **Update Tanggal & Versi** pada header setiap perubahan.

<!-- UPDATE: Tambahkan catatan khusus bila ada perubahan library atau konfigurasi -->
