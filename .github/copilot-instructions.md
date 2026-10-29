# Copilot Instructions

> **Terakhir Diperbarui:** 2026-10-29  
> **Status:** Aktif  
> **Peran Dokumen:** Instruksi operasional GitHub Copilot untuk repo serangkailah2025.

---

## 1. Identitas Proyek
Sistem terpadu pencatatan, pengelolaan stok, dan pertanggungjawaban barang inventaris/operasional (persediaan). Platform mengotomatisasi siklus saldo awal, penerimaan/pembelian, pemakaian/pengeluaran barang, mutasi, kartu stok FIFO, pembatasan waktu input transaksi, serta pencetakan laporan dan ekspor dokumen pertanggungjawaban.

---

## 2. Aturan Wajib: Membaca Memory Bank
Sebelum menganalisis, merencanakan, atau mengeksekusi kode apa pun, Copilot **WAJIB** membaca berkas Memory Bank di direktori `memory-bank/` sebagai single source of truth:

### Berkas Inti (Wajib Dibaca di Awal Setiap Sesi / Task)
1. `memory-bank/projectbrief.md` — Visi, misi, ruang lingkup, stakeholder, roadmap.
2. `memory-bank/productContext.md` — Latar belakang masalah, use case, persona, alur kerja pengguna.
3. `memory-bank/systemPatterns.md` — Arsitektur sistem (MVC), pola desain, konvensi penamaan, data flow.
4. `memory-bank/techContext.md` — Lingkungan teknis, batasan sistem, konfigurasi, dependency.
5. `memory-bank/activeContext.md` — Fokus aktif terkini, changelog, preferensi, catatan kritis.
6. `memory-bank/progress.md` — Fitur berjalan, checklist fitur, known bugs, milestone.

### Berkas Kondisional (HANYA Dibaca Saat Relevan)
- `memory-bank/template-conventions.md` — **HANYA** dibaca saat tugas membuat/memodifikasi template tampilan cetak atau dokumen. **JANGAN** muat untuk tugas non-laporan.
- `memory-bank/report-generation.md` — **HANYA** dibaca saat tugas berkaitan dengan ekspor/generate PDF dan TCPDF. **JANGAN** muat untuk tugas non-laporan.

---

## 3. Aturan Pembaruan Memory Bank
Setelah menyelesaikan perubahan signifikan atau task:
- Perbarui `memory-bank/activeContext.md` dengan status fokus terbaru dan entri changelog.
- Perbarui `memory-bank/progress.md` jika ada fitur yang selesai, berubah status, atau bug baru yang teridentifikasi.
- Perbarui `memory-bank/systemPatterns.md` atau `memory-bank/techContext.md` jika terdapat penambahan pola baru atau dependensi teknologi baru.
- Sertakan atau pertahankan tag komentar `<!-- UPDATE: ... -->` pada bagian yang memerlukan input developer.

---

## 4. Konvensi Rekayasa & Prinsip Kerja
- **Surgical & Precise:** Modifikasi hanya kode yang relevan dengan tugas. Jangan ubah fungsi yang bekerja tanpa instruksi eksplisit.
- **Patuhi Pola Arsitektur Proyek:**
  - Logika HTTP dan orkestasi berada di Controller.
  - Logika query data berada di Model.
  - Tampilan antarmuka dan berkas cetak berada di View.
  - Fungsi utilitas bersama berada di Helper / Library.
- **Validasi Akses & Input:** Selalu periksa sesi login dan batasan waktu penginputan transaksi (`isBatasPenginputan` / `cekbataswaktupenginputan`) saat memodifikasi alur mutasi barang.
- **Kepatuhan Lingkungan:** Sistem berjalan di Windows host (`\` untuk file path Windows). Pastikan kompatibilitas query database, encoding UTF-8, dan alokasi memori untuk ekspor berkas massal.
