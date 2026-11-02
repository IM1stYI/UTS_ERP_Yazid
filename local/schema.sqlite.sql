CREATE TABLE IF NOT EXISTS akun (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100) NOT NULL,
  peran VARCHAR(60) NOT NULL,
  departemen VARCHAR(60) NOT NULL,
  avatar VARCHAR(10) DEFAULT '👤',
  created_at TEXT DEFAULT (datetime('now','localtime'))
);

INSERT OR IGNORE INTO akun (id, username, password, nama_lengkap, peran, departemen, avatar) VALUES
(1, 'admin', '', 'Administrator Utama', 'Super Administrator ERP', 'IT & Sistem Informasi', '👑'),
(2, 'adie.kusna', '', 'Adie Kusna Wibowo, S.T., M.Kom.', 'Dosen Pengampu', 'Akademik TRPL', '🎓'),
(3, 'yazid', '', 'Yazid (Mahasiswa TRPL)', 'Mahasiswa Praktikan', 'Politeknik META Industri', '⭐'),
(4, 'sales.andi', '', 'Andi Pratama', 'Staff Penjualan', 'Sales & Marketing (SD)', '💼'),
(5, 'it.budi', '', 'Budi Santoso', 'IT System Administrator', 'Infrastruktur & Keamanan', '🛠️'),
(6, 'proc.citra', '', 'Citra Lestari', 'Procurement Officer', 'Pengadaan & Pembelian (MM)', '📋'),
(7, 'fin.dewi', '', 'Dewi Anggraini', 'Staff Akuntansi & Keuangan', 'Finance & Controlling (FI)', '💰'),
(8, 'wh.eko', '', 'Eko Saputra', 'Staff Gudang & Logistik', 'Warehouse & Supply Chain', '📦');

CREATE TABLE IF NOT EXISTS p1_master_data (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  kategori TEXT NOT NULL,
  kode VARCHAR(30) NOT NULL UNIQUE,
  nama VARCHAR(120) NOT NULL,
  departemen_pemilik VARCHAR(60) NOT NULL,
  digunakan_oleh VARCHAR(150) NOT NULL,
  atribut_kunci TEXT NOT NULL,
  contoh_data VARCHAR(255) NOT NULL,
  created_at TEXT DEFAULT (datetime('now','localtime'))
);

INSERT OR IGNORE INTO p1_master_data (kategori, kode, nama, departemen_pemilik, digunakan_oleh, atribut_kunci, contoh_data) VALUES
('Customer', 'MD-CUST', 'Master Pelanggan (Customer Master)', 'Marketing / Sales', 'Penjualan, Gudang, Keuangan (AR)', 'ID Pelanggan, Nama PT, Alamat Kirim, TOP, Credit Limit', 'CUST-001 | PT Astra Honda Motor | Limit Rp200.000.000'),
('Material', 'MD-MAT', 'Master Material & Produk (Material Master)', 'Eng. / PPIC / Gudang', 'Penjualan, Gudang, Produksi, Pembelian, Keuangan', 'Part Number, Deskripsi, Satuan (UoM), Tipe, Lead Time', 'MAT-FG-001 | Brake Caliper Assy Type-C | Min Stock 50'),
('Vendor', 'MD-VEND', 'Master Pemasok (Vendor Master)', 'Procurement / Purchasing', 'Pembelian, Gudang (Receiving), Keuangan (AP)', 'ID Pemasok, Nama Rekanan, Rekening Bank, Lead Time', 'VEND-001 | PT Alumindo Jaya Perkasa | TOP 45 Hari'),
('BOM', 'MD-BOM', 'Master Formula Produk (Bill of Materials)', 'R&D / Engineering / PPIC', 'Produksi, Pembelian, Keuangan (HPP Standard)', 'Level Hierarki, Part Number Komponen, Rasio per Unit', 'BOM-KPP300 | 1 Unit KPP-300 = 3 Unit Bahan A + 2 Unit Bahan B'),
('COA', 'MD-COA', 'Bagan Akun Standar (Chart of Accounts)', 'Finance & Accounting', 'Seluruh Departemen Operasional Perusahaan', 'Nomor Akun, Nama Akun, Klasifikasi, Saldo Normal', '1101 Kas (Aset Lancar / Debit)');

CREATE TABLE IF NOT EXISTS p1_sales_order (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  no_so VARCHAR(30) NOT NULL UNIQUE,
  pelanggan VARCHAR(100) NOT NULL,
  produk VARCHAR(100) NOT NULL,
  qty INT NOT NULL,
  nilai BIGINT NOT NULL,
  status VARCHAR(40) NOT NULL,
  catatan_kredit VARCHAR(255),
  created_at TEXT DEFAULT (datetime('now','localtime'))
);

INSERT OR IGNORE INTO p1_sales_order (no_so, pelanggan, produk, qty, nilai, status, catatan_kredit) VALUES
('SO-2026-001', 'PT Astra Honda Motor', 'Brake Caliper Assy Type-C (MAT-FG-001)', 50, 12000000, 'APPROVED', 'Limit Rp200jt, Outstanding Rp45jt (Lolos Credit Check)'),
('SO-2026-002', 'PT Yamaha Indonesia Motor', 'Piston Master Cylinder (MAT-FG-002)', 100, 15000000, 'APPROVED', 'Limit Rp150jt, Saldo piutang lancar'),
('SO-2026-003', 'PT Suzuki Indomobil Motor', 'Brake Caliper Assy Type-C (MAT-FG-001)', 800, 192000000, 'CREDIT BLOCKED', 'Nilai pesanan Rp192jt melampaui sisa limit kredit Rp155jt');

CREATE TABLE IF NOT EXISTS p2_rbac (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  peran VARCHAR(60) NOT NULL UNIQUE,
  departemen VARCHAR(60) NOT NULL,
  akses_sd VARCHAR(20) NOT NULL,
  akses_mm VARCHAR(20) NOT NULL,
  akses_pp VARCHAR(20) NOT NULL,
  akses_fi VARCHAR(20) NOT NULL,
  keterangan VARCHAR(255) NOT NULL
);

INSERT OR IGNORE INTO p2_rbac (peran, departemen, akses_sd, akses_mm, akses_pp, akses_fi, keterangan) VALUES
('Staff Penjualan', 'Marketing & Sales', 'CRUD', 'R', '-', '-', 'Hanya mengelola Sales Order dan melihat ketersediaan stok'),
('Staff Gudang', 'Warehouse / Inventory', 'R', 'CRUD', 'R', '-', 'Mengelola mutasi stok fisik dan penerimaan barang (GRN)'),
('Supervisor Produksi', 'Shop Floor / PPIC', '-', 'R', 'CRUD', '-', 'Merilis Work Order dan mencatat konsumsi material BOM'),
('Staff Pembelian', 'Procurement', '-', 'CRUD', 'R', 'R', 'Membuat PR/PO dan memantau status tagihan supplier'),
('Staff Keuangan', 'Finance & Accounting', 'R', 'R', 'R', 'CRUD', 'Menjurnal transaksi, rekonsiliasi kas, dan laporan keuangan');

CREATE TABLE IF NOT EXISTS p2_chaos_logs (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  skenario_kode VARCHAR(20) NOT NULL,
  nama_skenario VARCHAR(100) NOT NULL,
  kategori VARCHAR(60) NOT NULL,
  dampak VARCHAR(255) NOT NULL,
  status_mitigasi VARCHAR(60) NOT NULL,
  waktu_uji TEXT DEFAULT (datetime('now','localtime'))
);

INSERT OR IGNORE INTO p2_chaos_logs (skenario_kode, nama_skenario, kategori, dampak, status_mitigasi) VALUES
('DS-01', 'Database Server Primary Down (Crash)', 'Infrastruktur Database', 'Seluruh transaksi write terhenti sementara', 'Auto-failover ke PostgreSQL Replica dalam 3.2 detik (RTO < 5 menit)'),
('DS-02', 'Out-Of-Memory (OOM) App Server 1', 'Application Tier', 'Load balancer mendeteksi node 1 unready', 'Traffic dialihkan 100% ke App Server 2 tanpa downtime pengguna'),
('DS-03', 'Koneksi Internet Kampus Terputus', 'Jaringan & Akses', 'Pengguna lokal kehilangan akses web public', 'Internal LAN Gigabit switchover ke link cadangan 4G Failover');

CREATE TABLE IF NOT EXISTS p3_approval_rules (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  kode_aturan VARCHAR(20) NOT NULL UNIQUE,
  rentang_nominal VARCHAR(60) NOT NULL,
  nominal_min BIGINT NOT NULL,
  nominal_max BIGINT NOT NULL,
  otoritas VARCHAR(100) NOT NULL,
  sla_waktu VARCHAR(50) NOT NULL,
  syarat_dokumen VARCHAR(255) NOT NULL
);

INSERT OR IGNORE INTO p3_approval_rules (kode_aturan, rentang_nominal, nominal_min, nominal_max, otoritas, sla_waktu, syarat_dokumen) VALUES
('BR-01', '<= Rp 2.000.000 (Rutin)', 0, 2000000, 'Kepala Laboratorium Manufaktur', 'Max 1 Hari Kerja', 'Formulir PR Digital + Cek Kuota Anggaran Lab'),
('BR-02', 'Rp 2.000.001 - Rp 10.000.000 (Menengah)', 2000001, 10000000, 'Ka.Lab + Pudir II Bidang Keuangan', 'Max 2 Hari Kerja', 'Minimal 2 Penawaran Vendor + Verifikasi Keuangan'),
('BR-03', '> Rp 10.000.000 (Investasi Besar)', 10000001, 999999999, 'Ka.Lab + Pudir II + Direktur Politeknik', 'Max 3 Hari Kerja', 'Minimal 3 Penawaran Resmi + Justifikasi Kebutuhan Strategis'),
('BR-04', 'Pengadaan Darurat (Emergency 24 Jam)', 0, 5000000, 'Ka.Lab + Notifikasi Cepat Pudir II', 'Maksimal 24 Jam', 'Pernyataan Urgensi Praktikum Mahasiswa Besok Pagi');

CREATE TABLE IF NOT EXISTS p3_pengadaan (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  no_pr VARCHAR(30) NOT NULL UNIQUE,
  pemohon VARCHAR(80) NOT NULL,
  departemen VARCHAR(60) NOT NULL,
  item_barang VARCHAR(120) NOT NULL,
  nominal BIGINT NOT NULL,
  kategori_urgensi TEXT DEFAULT 'Normal',
  level_approval VARCHAR(80) NOT NULL,
  status VARCHAR(40) NOT NULL,
  disetujui_oleh VARCHAR(100),
  catatan TEXT,
  created_at TEXT DEFAULT (datetime('now','localtime'))
);

INSERT OR IGNORE INTO p3_pengadaan (no_pr, pemohon, departemen, item_barang, nominal, kategori_urgensi, level_approval, status, disetujui_oleh, catatan) VALUES
('PR-LAB-001', 'Ir. Bambang Triyono', 'Lab Manufaktur TRPL', 'Mata Pahat Bubut Insert Karbida (10 Pcs)', 1800000, 'Normal', 'Level 1: Ka.Lab', 'APPROVED', 'Kepala Lab Manufaktur', 'Disetujui sesuai pagu praktikum Semester Ganjil'),
('PR-LAB-002', 'Adie Kusna Wibowo', 'Lab Otomasi Industri', 'Modul PLC Siemens S7-1200 Starter Kit', 8500000, 'Normal', 'Level 2: Ka.Lab + Pudir II', 'APPROVED', 'Pudir II Bidang Keuangan', 'Sesuai rencana investasi peralatan lab modern'),
('PR-LAB-003', 'Staff Lab TRPL', 'Lab CNC Politeknik', 'Bahan Aluminium Billet Ujian Praktikum Besok', 2500000, 'Darurat 24 Jam', 'Emergency Fast-Track 24 Jam', 'APPROVED', 'Ka.Lab (Dispensasi Khusus)', 'SOP Fast-Track: Barang tiba malam ini untuk ujian mahasiswa');

CREATE TABLE IF NOT EXISTS coa (
  kode VARCHAR(10) PRIMARY KEY,
  nama VARCHAR(80) NOT NULL,
  klasifikasi VARCHAR(40) NOT NULL,
  saldo_normal TEXT NOT NULL,
  saldo_awal BIGINT NOT NULL DEFAULT 0
);

INSERT OR IGNORE INTO coa (kode, nama, klasifikasi, saldo_normal, saldo_awal) VALUES
('1101', 'Kas', 'Aset Lancar', 'Debit', 30000000),
('1102', 'Piutang Usaha', 'Aset Lancar', 'Debit', 0),
('1103', 'Persediaan Bahan Baku', 'Aset Lancar', 'Debit', 0),
('2101', 'Utang Usaha', 'Kewajiban', 'Kredit', 0),
('3101', 'Modal Pemilik', 'Ekuitas', 'Kredit', 30000000),
('4101', 'Penjualan Produk', 'Pendapatan', 'Kredit', 0),
('5101', 'Beban Operasional', 'Beban', 'Debit', 0);

CREATE TABLE IF NOT EXISTS p4_jurnal (
  id_trx VARCHAR(30) PRIMARY KEY,
  urut INT NOT NULL,
  deskripsi VARCHAR(255) NOT NULL,
  jumlah BIGINT NOT NULL,
  akun_debit VARCHAR(10) NOT NULL,
  akun_kredit VARCHAR(10) NOT NULL,
  alasan TEXT,
  created_at TEXT DEFAULT (datetime('now','localtime')),
  FOREIGN KEY (akun_debit) REFERENCES coa(kode),
  FOREIGN KEY (akun_kredit) REFERENCES coa(kode)
);

INSERT OR IGNORE INTO p4_jurnal (id_trx, urut, deskripsi, jumlah, akun_debit, akun_kredit, alasan) VALUES
('TRX-01', 0, '1. Pembelian bahan baku secara kredit', 8000000, '1103', '2101', 'Bahan baku masuk menambah aset persediaan (Dr Persediaan), kewajiban kepada pemasok timbul (Cr Utang Usaha).'),
('TRX-02', 1, '2. Pembayaran utang kepada pemasok', 3000000, '2101', '1101', 'Kewajiban dilunasi sebagian sehingga utang berkurang (Dr Utang Usaha), uang kas keluar (Cr Kas).'),
('TRX-03', 2, '3. Penjualan produk secara kredit', 12000000, '1102', '4101', 'Hak klaim penagihan bertambah (Dr Piutang Usaha), omzet pendapatan diakui (Cr Penjualan Produk).'),
('TRX-04', 3, '4. Penerimaan kas dari pelunasan piutang pelanggan', 5000000, '1101', '1102', 'Uang tunai diterima menambah kas perusahaan (Dr Kas), tagihan pelanggan berkurang (Cr Piutang Usaha).'),
('TRX-05', 4, '5. Pembayaran beban operasional kantor (tunai)', 1500000, '5101', '1101', 'Biaya operasional dikeluarkan mengurangi ekuitas/laba (Dr Beban Operasional), kas berkurang (Cr Kas).');

CREATE TABLE IF NOT EXISTS p4_status (
  id TINYINT PRIMARY KEY,
  is_duplicated TINYINT NOT NULL DEFAULT 0,
  is_corrected TINYINT NOT NULL DEFAULT 0,
  saldo_kas_saat_ini BIGINT DEFAULT 30500000
);

INSERT OR IGNORE INTO p4_status (id, is_duplicated, is_corrected, saldo_kas_saat_ini) VALUES
(1, 0, 0, 30500000);

CREATE TABLE IF NOT EXISTS p5_material (
  kode VARCHAR(10) PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  rasio_bom INT NOT NULL,
  satuan VARCHAR(10) NOT NULL,
  stok INT NOT NULL,
  on_order INT NOT NULL,
  lead_time_hari INT NOT NULL,
  pemasok VARCHAR(80) NOT NULL,
  harga INT NOT NULL,
  gudang VARCHAR(40) NOT NULL,
  aturan_pesan VARCHAR(120) NOT NULL
);

INSERT OR IGNORE INTO p5_material (kode, nama, rasio_bom, satuan, stok, on_order, lead_time_hari, pemasok, harga, gudang, aturan_pesan) VALUES
('MAT-A', 'Bahan Baku A (Aluminium Billet AL-6061)', 3, 'Unit', 400, 100, 4, 'PT Alumindo Jaya Perkasa', 45000, 'GD-01 Gudang Logistik', 'Lot-for-Lot, MOQ 50'),
('MAT-B', 'Bahan Baku B (Baut High-Tensile HT-88)', 2, 'Unit', 250, 0, 7, 'PT Fastener Baja Utama', 18000, 'GD-01 Gudang Logistik', 'Lot-for-Lot, MOQ 50');

CREATE TABLE IF NOT EXISTS p5_grn (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  po_no VARCHAR(30) NOT NULL,
  kode_material VARCHAR(10) NOT NULL,
  qty_po INT NOT NULL,
  qty_diterima INT NOT NULL,
  sisa INT NOT NULL,
  status VARCHAR(40) NOT NULL,
  catatan_qc VARCHAR(255) DEFAULT 'Lolos QC Inspection',
  created_at TEXT DEFAULT (datetime('now','localtime')),
  FOREIGN KEY (kode_material) REFERENCES p5_material(kode)
);

INSERT OR IGNORE INTO p5_grn (po_no, kode_material, qty_po, qty_diterima, sisa, status, catatan_qc) VALUES
('PO-MAT-A-01', 'MAT-A', 400, 200, 200, 'PARTIALLY RECEIVED', '200 Unit Bahan A lolos QC, dicatat pada GR/IR Clearing otomatis');

CREATE TABLE IF NOT EXISTS p5_mrp_log (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  rencana_output INT NOT NULL,
  deadline_hari INT NOT NULL,
  kebutuhan_bruto_a INT NOT NULL,
  kebutuhan_bersih_a INT NOT NULL,
  kebutuhan_bruto_b INT NOT NULL,
  kebutuhan_bersih_b INT NOT NULL,
  status_bottleneck VARCHAR(150) NOT NULL,
  waktu_kalkulasi TEXT DEFAULT (datetime('now','localtime'))
);

INSERT OR IGNORE INTO p5_mrp_log (rencana_output, deadline_hari, kebutuhan_bruto_a, kebutuhan_bersih_a, kebutuhan_bruto_b, kebutuhan_bersih_b, status_bottleneck) VALUES
(300, 6, 900, 400, 600, 350, 'Bahan Baku B Bottleneck: Lead time 7 hari > batas waktu 6 hari');
