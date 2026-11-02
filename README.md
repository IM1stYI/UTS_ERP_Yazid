# META ERP Enterprise Suite — Aplikasi Web Praktikum ERP (1 - 5)
**Ujian Tengah Semester (UTS) Semester Ganjil 2026/2027**  
**Politeknik META Industri — Teknologi Rekayasa Perangkat Lunak (TRPL)**  
**Mata Kuliah:** Enterprise Resource Planning (PL/4008) — 3 SKS  
**Dosen Pengampu:** Adie Kusna Wibowo  

---

## 📌 Ringkasan Aplikasi
Aplikasi web ini dibangun menggunakan **Vanilla HTML5, Vanilla CSS3, dan Vanilla JavaScript murni** (tanpa dependensi eksternal/framework berat) dengan standar estetika antarmuka modern (*glassmorphism*, tipografi *Plus Jakarta Sans*, kartu visual, simulator interaktif, dan matriks keputusan bisnis).

Aplikasi ini menyajikan seluruh pemenuhan soal dan indikator penilaian dari **Halaman 6 sampai 11 dokumen PDF UTS**:
1. **Beranda (Portal Hub):** Pilihan navigasi langsung ke Praktikum 1, 2, 3, 4, dan 5 beserta informasi rubrik penilaian resmi (50% Praktikum, 50% Esai).
2. **Praktikum 1 — Menganalisis Evolusi dan Integrasi ERP:**
   - Analisis 4 silo data departemen (Penjualan, Gudang, Produksi, Keuangan).
   - Diagram arsitektur proses *As-Is* (sebelum ERP) vs *To-Be* (*Single Source of Truth*).
   - 5 Data Master bersama (*Customer, Material, Vendor, BOM, Chart of Accounts*).
   - Simulator satu transaksi pesanan penjualan (*Sales Order flow*).
   - Pengujian 4 tantangan individual dosen (Stok kurang, pesanan berubah, pembayaran belum diterima, keterlambatan mesin).
3. **Praktikum 2 — Merancang dan Menguji Arsitektur Teknis ERP:**
   - Rancangan arsitektur teknis 3-Tier Enterprise untuk 100 pengguna (Web Client/VPN, NGINX Load Balancer & App Cluster, PostgreSQL Primary-Replica, Automated Backup 3-2-1).
   - Matriks Hak Akses Pengguna (*Role-Based Access Control* / RBAC Matrix) 5 departemen.
   - Kebijakan pencadangan (*3-2-1 Backup Rule*) dan SOP Pemulihan Data (*RTO < 30 menit, RPO < 5 menit*).
   - Alur data transaksi pembelian (*PR ➔ PO ➔ GRN ➔ AP Invoice ➔ Payment*).
   - *Chaos Engineering Simulator:* Pengujian 5 skenario gangguan teknis (Database crash, Server OOM, Internet putus, Percobaan akses ilegal, Kegagalan backup manual).
4. **Praktikum 3 — Pemetaan Proses Bisnis dan Perancangan Alur Persetujuan:**
   - Studi kasus pengadaan bahan praktik Lab Manufaktur Politeknik META Industri.
   - Evaluasi 4 kelemahan mendasar proses manual *As-Is* (via WhatsApp pribadi, perkiraan tanpa cek stok, dll).
   - Diagram alur kerja *To-Be ERP* dengan gerbang otomasi dan validasi digital.
   - 4 Aturan Bisnis (*Business Rules Engine*) baku & Tabel RACI Matrix.
   - Simulator dinamis wewenang otorisasi pengadaan berjenjang (*slider* nominal).
   - Pengujian kondisi khusus dosen: Kenaikan harga penawaran vendor & SOP Pengadaan Darurat 24 Jam (Ujian Mahasiswa).
5. **Praktikum 4 — Konfigurasi dan Simulasi Modul Keuangan ERP:**
   - Saldo awal kas: **Rp 30.000.000** (Ekuitas Modal Awal: Rp 30.000.000).
   - Konfigurasi 6 akun minimal (1101 Kas, 1102 Piutang, 1103 Persediaan, 2101 Utang Usaha, 3101 Modal, 4101 Penjualan, 5101 Beban Operasional).
   - Penjurnalan otomatis 5 transaksi skenario:
     1. Pembelian bahan baku kredit: Rp 8.000.000
     2. Pembayaran utang pemasok: Rp 3.000.000
     3. Penjualan produk kredit: Rp 12.000.000
     4. Penerimaan pelunasan piutang: Rp 5.000.000
     5. Pembayaran biaya operasional tunai: Rp 1.500.000
   - Laporan Laba Rugi sederhana, Buku Besar (*General Ledger*), dan Neraca Saldo (*Trial Balance*) seimbang (**Total Debit Rp 47.000.000 = Total Kredit Rp 47.000.000**).
   - Pengujian kesalahan duplikasi pembayaran pemasok (Rp 3.000.000 tercatat 2x), analisis dampak, dan tombol **Jurnal Koreksi / Pembalik (*Reversing Entry*)** yang menjaga keutuhan jejak audit (*audit trail integrity*).
6. **Praktikum 5 — Konfigurasi SCM dan Pembelian Berbasis Kebutuhan Material (MRP):**
   - Rencana produksi: 300 unit *Komponen Poros Mesin (KPP-300)* dalam **6 hari kerja**.
   - Formula BOM: 1 Unit KPP-300 = 3 Unit Bahan A + 2 Unit Bahan B.
   - Perhitungan Kebutuhan Bruto: Bahan A = 900 unit, Bahan B = 600 unit.
   - Posisi Stok:
     - Bahan A: Stok 400 unit, On-order 100 unit (tiba hari ke-4). Kebutuhan bersih = 400 unit (Lead time 4 hari <= 6 hari, **AMAN**).
     - Bahan B: Stok 250 unit, On-order 0 unit. Kebutuhan bersih = 350 unit (Lead time 7 hari > 6 hari target, **BOTTLENECK KRITIS**).
   - Simulasi penerbitan PO & Penerimaan Barang Parsial (*Partial Goods Receipt*) dengan mutasi stok *real-time*.
     - *Delay Shock Test*: Pemasok Bahan B molor menjadi 8 hari kerja. Disertai *Decision Matrix* perbandingan 4 alternatif manajerial (Split production, supplier alternatif kilat, transfer stok antar gudang, penolakan menunggu pasif).

---

## 👥 Akun Demo Login Sistem ERP
Sistem telah dilengkapi dengan fitur multi-role login dan 1-click account switch:

| Avatar | Username | Password | Nama Lengkap | Peran / Role | Departemen |
| :---: | :--- | :--- | :--- | :--- | :--- |
| 👑 | `admin` | `admin123` | Administrator Utama | Super Administrator ERP | IT & Sistem Informasi |
| 🎓 | `adie.kusna` | `dosen123` | Adie Kusna Wibowo, S.T., M.Kom. | Dosen Pengampu | Akademik TRPL |
| ⭐ | `yazid` | `meta2026` | Yazid (Mahasiswa TRPL) | Mahasiswa Praktikan | Politeknik META Industri |
| 💼 | `sales.andi` | `sales123` | Andi Pratama | Staff Penjualan | Sales & Marketing (SD - P1) |
| 🛠️ | `it.budi` | `it123` | Budi Santoso | IT System Administrator | Infrastruktur & Keamanan (P2) |
| 📋 | `proc.citra` | `proc123` | Citra Lestari | Procurement Officer | Pengadaan & Pembelian (MM - P3) |
| 💰 | `fin.dewi` | `fin123` | Dewi Anggraini | Staff Akuntansi & Keuangan | Finance & Controlling (FI - P4) |
| 📦 | `wh.eko` | `wh123` | Eko Saputra | Staff Gudang & Logistik | Warehouse & SCM (P5) |

---

## 🗄️ Struktur Tabel Database (`database.sql`)
Database mencakup tabel lengkap untuk autentikasi dan modul P1 s/d P5:
1. **`akun`**: Data pengguna, password, peran, departemen, dan avatar demo.
2. **`p1_sales_order` & `p1_master_data`**: Data transaksi pesanan penjualan dan 5 data master bersama.
3. **`p2_rbac` & `p2_chaos_logs`**: Matriks hak akses pengguna (RBAC) dan riwayat pengujian failover otomatis.
4. **`p3_pengadaan` & `p3_approval_rules`**: Data pengajuan PR, aturan otorisasi bertingkat, dan pengujian kenaikan penawaran.
5. **`coa`, `p4_jurnal`, `p4_status`**: Bagan akun (*Chart of Accounts*), jurnal 5 transaksi standar, status duplikasi, dan jurnal pembalik.
6. **`p5_material`, `p5_grn`, `p5_mrp_log`**: Data master material, log penerimaan barang parsial (GRN), dan riwayat kalkulasi kebutuhan bersih MRP.

---

## 🌐 Panduan Integrasi ke Hosting cPanel (`yazid.pagitrpl.my.id/ERP/`)
1. **Import Database:**
   - Masuk ke cPanel ➔ **phpMyAdmin**.
   - Pilih database Anda (misal `pagitrpl_ERPyazid`).
   - Klik tab **Import** ➔ Pilih berkas `database.sql` ➔ Klik **Go / Kirim**.
2. **Konfigurasi Kredensial:**
   - Buka file manager di cPanel, edit file `api/config.php`.
   - Pastikan `DB_USER` dan `DB_PASS` sesuai dengan user database yang telah di-assign di menu **MySQL Databases** cPanel.
3. **Upload File Web:**
   - Upload file `index.php`, `login.php`, `js/`, `css/`, `api/`, dan `database.sql` ke folder `public_html/ERP/`.
4. **Verifikasi:**
   - Buka `https://yazid.pagitrpl.my.id/ERP/login.php`.
   - Indikator di kanan atas akan otomatis menampilkan **🟢 MySQL: pagitrpl_ERPyazid**.

---

## 💻 Mode Offline / Localhost (Tanpa Internet, Tanpa XAMPP)
Aplikasi ini butuh API + database (login memakai sesi server), jadi **tidak bisa** dibuka dengan klik ganda `index.php`.
Untuk localhost offline tersedia server mandiri `server.py` (Python 3.7+, **tanpa** `pip install`, tanpa PHP/MySQL):

| Sistem | Cara menjalankan |
| :--- | :--- |
| **Windows** | Klik ganda **`jalankan.bat`** |
| **macOS / Linux** | `./jalankan.sh` atau `python3 server.py` |

Browser terbuka otomatis di **http://localhost:8000** (jika port terpakai, otomatis pindah ke 8001, 8002, dst).
Login memakai akun demo pada tabel di atas, misalnya `yazid` / `meta2026`.

- **Halaman `.php`:** `server.py` bukan PHP asli. Ia menjalankan ulang penjaga sesi di awal `index.php` / `login.php` (belum login ➔ ke `login.php`, sudah login ➔ ke `index.php`), lalu membuang blok `<?php ... ?>` sebelum dikirim ke browser. Jika kelak ada kode PHP lain di dua file itu, server akan menampilkan peringatan di terminal. Tautan lama `.html` otomatis diarahkan ke `.php`.
- **Database:** SQLite, tersimpan di `local/erp_offline.sqlite` (dibuat otomatis saat pertama jalan). Data yang Anda input tetap tersimpan setelah server dimatikan.
- **Reset ke data awal:** `python server.py --reset`
- **Ganti port:** `python server.py --port 9000`
- **Akses dari HP/laptop lain di Wi-Fi yang sama:** `python server.py --lan`, lalu buka `http://<IP-komputer>:8000`
- **Font** (Plus Jakarta Sans & JetBrains Mono) sudah tersimpan di folder `fonts/`, sehingga tampilan sama persis tanpa internet.
- Folder `api/` (PHP) dan `database.sql` (MySQL) **tidak diubah**, jadi paket yang sama tetap bisa di-upload ke cPanel atau dijalankan di XAMPP/Laragon.
- Server hanya melayani `index.php`, `login.php`, `css/`, `js/`, `fonts/`; file `server.py`, database, dan `api/config.php` tidak bisa diunduh lewat browser.

---

## 🚀 Cara Menjalankan Alternatif (Hanya Tampilan, Tanpa Login/DB)
1. **XAMPP / Laragon:** letakkan folder `ERP` di `htdocs` (atau `www`), import `database.sql`, lalu buka `http://localhost/ERP/login.php`.
2. **PHP built-in server:**
   ```bash
   php -S localhost:8000
   ```
   Lalu buka `http://localhost:8000/login.php`.

> Karena halaman kini berformat `.php` dan memakai sesi PHP, aplikasi **tidak bisa** dibuka dengan klik ganda file.

---

## 📂 Struktur Berkas
```
Praktikum UTS/
├── login.php         # Halaman login + daftar akun demo
├── index.php         # Halaman portal utama, UI modul P1-P5, modal login, modal status DB
├── css/
│   └── style.css      # Desain sistem modern, modal styles, responsif & print styles
├── js/
│   ├── data.js        # Konfigurasi data dummy, COA, BOM, akun demo login
│   └── app.js         # Logika interaktif: router, monitor DB, autentikasi, simulator P1-P5
├── api/
│   ├── config.php     # Konfigurasi koneksi MySQL cPanel & fallback lokal
│   └── api.php        # REST API gateway (Status DB, Login Akun, P1, P2, P3, P4, P5)
├── database.sql       # Skema database MySQL lengkap + initial data seed
└── README.md          # Dokumentasi teknis & panduan lengkap
```

