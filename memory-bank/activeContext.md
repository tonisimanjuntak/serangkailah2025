# Active Context

> **Terakhir Diperbarui:** 2026-10-29  
> **Status:** Aktif  
> **Peran Dokumen:** Catatan konteks dinamis mengenai fokus pekerjaan, status terkini, dan panduan kerja aktif.

---

## 1. Fokus Saat Ini (Current Work)
- Inisialisasi struktur dokumentasi Memory Bank terpadu di folder `memory-bank/`.
- Memastikan seluruh panduan arsitektur, konvensi template dokumen, dan panduan generasi laporan terstandarisasi sebagai single source of truth untuk AI assistant.
- Evaluasi kesiapan modul laporan persediaan dan kartu stok.

<!-- UPDATE: Perbarui saat beralih ke tugas teknis baru -->

---

## 2. Perubahan Terbaru (Changelog)
- **2026-10-29:** Konfigurasi `.github/copilot-instructions.md` untuk mengarahkan AI selalu membaca Memory Bank.
- **2026-10-29:** Pembuatan fondasi Memory Bank (`projectbrief.md`, `productContext.md`, `systemPatterns.md`, `techContext.md`).
- **2026-10-29:** Penyusunan panduan kondisional generasi laporan PDF dan konvensi template cetak.
- **2026-10-29:** Penyesuaian aturan framework-agnostic pada dokumen inti.
- **2026-10-29:** Inventarisasi struktur direktori aplikasi dan modul transaksi persediaan barang.
- **2026-10-29:** Dokumentasi pola filter multi-parameter pada controller pelaporan.

<!-- UPDATE: Tambahkan 5-10 catatan progres perubahan terkini -->

---

## 3. Langkah Selanjutnya (Next Steps)
1. Verifikasi kelengkapan seluruh berkas dalam `memory-bank/`.
2. Validasi konsistensi data transaksi persediaan (saldo awal, penerimaan, pemakaian) terhadap kalkulasi kartu stok.
3. Review implementasi library pencetakan dokumen PDF untuk memastikan stabilitas format tata letak cetak.
4. Uji coba fungsionalitas batas waktu penginputan data per ruangan/unit kerja.

---

## 4. Keputusan Aktif & Pertimbangan
- **Isolasi Dokumentasi Laporan:** Panduan pembuatan laporan (`report-generation.md`) dan aturan styling cetak (`template-conventions.md`) dipisahkan menjadi file kondisional agar konteks percakapan tetap efisien dan tidak dimuat saat pengerjaan modul non-laporan.
- **Pendekatan Framework-Agnostic pada Dokumen Inti:** Deskripsi arsitektur dan teknis dibuat netral dan fokus pada konsep desain sistem agar relevan lintas pembaruan teknologi.
- **Validasi Terpusat di Base Controller:** Pengecekan otentikasi login dan batas waktu mutasi diwajibkan melewati controller turunan utama sebelum mengeksekusi logika bisnis.

---

## 5. Pola / Preferensi yang Sedang Berlaku
- Gunakan pola filter parameter URI/query string yang seragam pada modul pelaporan (`ruangan`, `kelompok_barang`, `barang`, `rentang_tanggal`).
- Format respon AJAX wajib konsisten dengan payload status boolean dan deskripsi pesan.
- Setiap dokumen cetak wajib menyertakan blok penandatangan resmi sesuai referensi tabel penandatangan/pengaturan.

---

## 6. Hal Penting yang Harus Diingat Assistant
- **Batas Waktu Penginputan:** Selalu periksa apakah aksi penambahan/pengubahan data transaksi dibatasi oleh aturan `bataswaktuperruangan` atau `pengaturan`.
- **Integritas Stok FIFO:** Perubahan pada penerimaan atau pemakaian barang berdampak langsung pada kalkulasi sisa stok dan histori kartu stok.
- **Windows Path Handling:** Pada environment operasi Windows, perhatikan separator berkas dan path sistem.
- **Jangan Muat Berkas Laporan Jika Bukan Tugas Laporan:** Jangan memanggil atau membaca `report-generation.md` dan `template-conventions.md` kecuali tugas secara spesifik melibatkan pembuatan/modifikasi laporan.
