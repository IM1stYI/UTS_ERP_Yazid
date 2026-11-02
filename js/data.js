/**
 * META ERP SUITE - POLITEKNIK META INDUSTRI
 * Database Dummy & Konfigurasi Praktikum 1 - 5 ERP
 * Dosen: Adie Kusna Wibowo | TRPL 2026/2027
 */

const erpData = {
  meta: {
    institution: "Politeknik META Industri Cikarang",
    course: "Enterprise Resource Planning (ERP)",
    courseCode: "PL/4008",
    lecturer: "Adie Kusna Wibowo",
    program: "Teknologi Rekayasa Perangkat Lunak (TRPL)",
    credits: "3 SKS",
    term: "Semester Ganjil 2026/2027",
    location: "Kawasan Cikarang Technopark, Lippo Cikarang"
  },

  // ==========================================
  // PRAKTIKUM 1: EVOLUSI DAN INTEGRASI ERP
  // ==========================================
  p1: {
    siloIssues: [
      {
        dept: "Departemen Penjualan (Marketing)",
        currentSystem: "Spreadsheet",
        problem: "Data pesanan terlambat diperbarui",
        impact: "Marketing menjanjikan tanggal delivery yang tidak realistis tanpa cek kapasitas produksi nyata.",
        solution: "Modul Sales & Distribution (SD) terintegrasi langsung dengan modul Inventory dan Production Planning (PP)."
      },
      {
        dept: "Departemen Gudang (Warehouse)",
        currentSystem: "Aplikasi stok",
        problem: "Stok berbeda dengan catatan pembelian",
        impact: "Terjadi over-stock atau dead-stock bahan baku dan ketidakcocokan nilai persediaan saat stock-opname.",
        solution: "Modul Material Management (MM) dengan pencatatan otomatis Goods Receipt terikat Purchase Order (PO)."
      },
      {
        dept: "Departemen Produksi (Shop Floor)",
        currentSystem: "Formulir manual",
        problem: "Jadwal produksi sering berubah",
        impact: "Lini perakitan sering terhenti (idle time) karena kekurangan material kritis di tengah proses kerja.",
        solution: "Modul Production Planning (PP) & MRP otomatis yang membaca status ketersediaan bahan baku di gudang secara real-time."
      },
      {
        dept: "Departemen Keuangan (Finance & Accounting)",
        currentSystem: "Aplikasi akuntansi",
        problem: "Transaksi harus dimasukkan ulang",
        impact: "Penyusunan laporan laba-rugi terlambat, rawan salah input data (human error), dan rekonsiliasi faktur berlarut-larut.",
        solution: "Modul Financials & Controlling (FI/CO) dengan automatic journal posting untuk setiap mutasi penjualan, pembelian, dan persediaan."
      }
    ],

    masterDataList: [
      {
        code: "MD-CUST",
        name: "Master Pelanggan (Customer Master)",
        primaryOwner: "Marketing / Sales",
        usedBy: "Penjualan, Gudang (Shipping/Logistik), Keuangan (AR / Invoicing)",
        attributes: "ID Pelanggan, Nama PT, Alamat Pengiriman, Contact Person, NPWP, Termin Pembayaran (TOP), Batas Kredit (Credit Limit)",
        dummyExample: "CUST-001 | PT Astra Honda Motor | TOP 30 Hari | Limit Rp200.000.000"
      },
      {
        code: "MD-MAT",
        name: "Master Material & Produk (Material Master)",
        primaryOwner: "Eng. / PPIC / Gudang",
        usedBy: "Penjualan, Gudang, Produksi, Pembelian, Keuangan",
        attributes: "Part Number, Deskripsi, Satuan (UoM), Tipe (Raw Material/WIP/FG), Standar Biaya, Safety Stock, Lead Time",
        dummyExample: "MAT-FG-001 | Brake Caliper Assy Type-C | Unit | Std Cost Rp185.000 | Min Stock 50"
      },
      {
        code: "MD-VEND",
        name: "Master Pemasok (Vendor/Supplier Master)",
        primaryOwner: "Procurement / Purchasing",
        usedBy: "Pembelian, Gudang (Receiving), Keuangan (AP / Payment)",
        attributes: "ID Pemasok, Nama Rekanan, Alamat, Syarat Bayar, Bank Rekening, Lead Time Pemasok, Rating Kinerja",
        dummyExample: "VEND-101 | PT Alumindo Baja Presisi | Rekening BCA 88921 | TOP 45 Hari"
      },
      {
        code: "MD-BOM",
        name: "Master Bill of Materials (BOM)",
        primaryOwner: "Engineering / R&D",
        usedBy: "Produksi (Work Order), Pembelian (MRP), Keuangan (Standard Costing)",
        attributes: "Level Hierarchy, Kode Komponen Induk, Kode Komponen Anak, Rasio Kebutuhan per Unit, Satuan Konsumsi",
        dummyExample: "BOM-BC-01 | 1 Unit Caliper = 2 unit Aluminium AL-6061 + 4 unit Seal Ring + 2 Baut HT-88"
      },
      {
        code: "MD-COA",
        name: "Bagan Akun (Chart of Accounts - COA)",
        primaryOwner: "Accounting / Finance",
        usedBy: "Seluruh Modul (Penjualan, Pembelian, Inventori, Gaji, Aset)",
        attributes: "Nomor Akun, Nama Akun, Golongan (Aset/Kewajiban/Ekuitas/Pendapatan/Beban), Saldo Normal",
        dummyExample: "1101 (Kas), 1102 (Piutang Usaha), 1103 (Persediaan), 2101 (Utang Usaha), 4101 (Penjualan)"
      }
    ],

    individualChallenges: [
      {
        id: "c1",
        title: "Tantangan 1: Stok Bahan Baku Ternyata Tidak Mencukupi",
        trigger: "Pelanggan memesan 150 unit, namun bahan baku di gudang hanya cukup untuk 80 unit.",
        affectedModule: "Production Planning (PP) & Material Management (MM)",
        systemAction: "Sistem ERP secara otomatis mendeteksi defisit saat Sales Order di-input. Sistem men-generate Purchase Requisition (PR) darurat ke bagian Pembelian, sekaligus menahan rilis Work Order dan memberikan estimasi delivery date yang realistis ke Marketing."
      },
      {
        id: "c2",
        title: "Tantangan 2: Pelanggan Mengubah Jumlah Pesanan Mendadak",
        trigger: "Pelanggan minta kenaikan pesanan dari 50 unit menjadi 120 unit saat produksi sedang berjalan.",
        affectedModule: "Sales (SD), Production Planning (PP), Inventory (MM)",
        systemAction: "Sistem melakukan revisi Sales Order (Versioning SO-001 Rev.1). Sistem otomatis mengecek delta kebutuhan material (+70 unit BOM), mengkalkulasi ulang ketersediaan stok, dan menerbitkan Work Order batch tambahan tanpa menduplikasi pesanan awal."
      },
      {
        id: "c3",
        title: "Tantangan 3: Pembayaran Pelanggan Belum Diterima (Overdue)",
        trigger: "Pelanggan mengajukan pesanan baru senilai Rp45.000.000 padahal faktur sebelumnya telah melewati jatuh tempo (overdue > 30 hari).",
        affectedModule: "Finance (FI/AR) & Sales Order Processing",
        systemAction: "Fitur 'Credit Management Hold' langsung aktif. Sales Order secara otomatis terkunci dengan status 'Credit Blocked'. Surat penagihan (Dunning Letter) otomatis terkirim, dan bagian Gudang dicegah mencetak Surat Jalan (Delivery Order) sampai Finance merilis hold."
      },
      {
        id: "c4",
        title: "Tantangan 4: Produksi Mengalami Keterlambatan Mesin (Breakdown)",
        trigger: "Mesin CNC utama rusak selama 2 hari kerja sehingga target output harian meleset 40%.",
        affectedModule: "Production Planning (PP) & Plant Maintenance (PM)",
        systemAction: "Tiket Maintenance diterbitkan di modul PM. Kapasitas Work Center otomatis disesuaikan (derated capacity). Sistem menggeser Master Production Schedule (MPS) dan otomatis mengirim peringatan dini ke modul Sales agar proaktif memberitahu pelanggan."
      }
    ]
  },

  // ==========================================
  // PRAKTIKUM 2: ARSITEKTUR TEKNIS ERP
  // ==========================================
  p2: {
    specs: {
      users: 100,
      departments: [
        { name: "Penjualan (Sales)", users: 20, devices: "Laptop & PC Kantor" },
        { name: "Gudang (Warehouse)", users: 15, devices: "Barcode Scanner & PC Terminal" },
        { name: "Produksi (Production)", users: 30, devices: "Touch Terminal & Tablet Lapangan" },
        { name: "Pembelian (Purchasing)", users: 15, devices: "PC Kantor" },
        { name: "Keuangan (Finance/Acc)", users: 20, devices: "PC Desktop Dedicated & Secure VPN" }
      ]
    },

    rbacMatrix: [
      { role: "Staff Penjualan", sales: "CRUD", warehouse: "R", production: "R", purchasing: "No", finance: "No", notes: "Hanya input SO & lihat ketersediaan stok produk jadi" },
      { role: "Petugas Gudang", sales: "R", warehouse: "CRUD", production: "R", purchasing: "R", finance: "No", notes: "Penerimaan barang (GRN), mutasi stock, packing slip" },
      { role: "Supervisor Produksi", sales: "R", warehouse: "R", production: "CRUD", purchasing: "No", finance: "No", notes: "Rilis Work Order, catat konsumsi bahan, input hasil jadi" },
      { role: "Buyer / Pengadaan", sales: "R", warehouse: "R", production: "R", purchasing: "CRUD", finance: "R", notes: "Input RFQ, rilis PO, pantau status lead time vendor" },
      { role: "Finance & Accounting", sales: "R", warehouse: "R", production: "R", purchasing: "R", finance: "CRUD", notes: "Akses penuh jurnal, buku besar, approval pembayaran AP/AR" },
      { role: "IT Admin & Auditor", sales: "R", warehouse: "R", production: "R", purchasing: "R", finance: "R", notes: "Kelola konfigurasi sistem, audit log, tidak boleh manipulasi transaksi" }
    ],

    disasterScenarios: [
      {
        id: "ds1",
        name: "Kondisi 1: Database Utama Tidak Dapat Diakses (Crash / Disk Failure)",
        severity: "CRITICAL",
        rootCause: "Kegagalan storage array atau freeze pada engine PostgreSQL/MySQL primer.",
        impact: "Seluruh transaksi berhenti, pengguna tidak dapat menyimpan data baru maupun membaca laporan.",
        mitigation: "Terapkan High Availability Database Clustering dengan Streaming Replication ke Read/Write Hot Standby. Gunakan PgBouncer / ProxySQL untuk automatic failover dalam waktu < 60 detik tanpa intervensi manual (target RTO < 30 menit dan RPO < 5 menit, konsisten dengan kebijakan backup)."
      },
      {
        id: "ds2",
        name: "Kondisi 2: Server Aplikasi Mengalami Gangguan (Out of Memory / High Load)",
        severity: "HIGH",
        rootCause: "Server aplikasi tunggal (Single Point of Failure - SPOF) kehabisan resource memori.",
        impact: "Pengguna mendapat error HTTP 502/504 Bad Gateway, meskipun database tetap sehat.",
        mitigation: "Penerapan Arsitektur Multi-Instance di belakang NGINX Load Balancer. Jika Instance 1 crash, NGINX secara instan mengarahkan traffic ke Instance 2 (Zero Downtime)."
      },
      {
        id: "ds3",
        name: "Kondisi 3: Koneksi Internet Eksternal Terputus Total",
        severity: "MEDIUM",
        rootCause: "Fiber optic ISP putus terkena galian jalan di luar area kawasan industri.",
        impact: "Karyawan WFH/laptop remote tidak bisa akses, namun operasional intranet kantor tetap berjalan.",
        mitigation: "Dual-WAN ISP Failover (ISP Utama Fiber Optic + ISP Cadangan Seluler 5G Enterprise/Microwave). Aktifkan modul offline queueing pada scanner gudang."
      },
      {
        id: "ds4",
        name: "Kondisi 4: Percobaan Akses Menu Keuangan oleh Pengguna Tidak Berwenang",
        severity: "HIGH SECURITY",
        rootCause: "Staff gudang mencoba membuka URL endpoint `/api/finance/general-ledger`.",
        impact: "Potensi kebocoran data penggajian karyawan atau manipulasi saldo akun kas.",
        mitigation: "Implementasi RBAC Strict Middleware di level server API (JWT Claims Token & Scope Verification). Sistem mengembalikan response 403 Forbidden dan langsung mencatat Security Audit Event ke SIEM."
      },
      {
        id: "ds5",
        name: "Kondisi 5: Data Transaksi Hilang Akibat Backup Manual Terlupa",
        severity: "CRITICAL",
        rootCause: "SOP pencadangan manual tidak dijalankan oleh operator karena libur akhir pekan.",
        impact: "Kerugian data transaksi selama 3 hari terakhir; laporan keuangan tidak dapat direkonstruksi.",
        mitigation: "Otomasi Pencadangan 3-2-1 Rule: Cronjob otomatis dump database setiap malam pukul 01.00, continuous WAL archiving per 5 menit ke Object Storage Cloud (S3/GCS terenkripsi), dan uji restore otomatis mingguan."
      }
    ]
  },

  // ==========================================
  // PRAKTIKUM 3: PEMETAAN PROSES BISNIS & APPROVAL
  // ==========================================
  p3: {
    asIsDefects: [
      {
        defect: "Pengajuan Kebutuhan via WhatsApp Pribadi",
        cause: "Belum ada form pengajuan terstandar dan portal terpusat",
        impact: "Pesan tertumpuk, spesifikasi barang tidak jelas, tidak ada nomor pelacakan dokumen."
      },
      {
        defect: "Pemeriksaan Kebutuhan Berdasarkan Perkiraan",
        cause: "Kepala Lab tidak memiliki akses dashboard inventaris real-time",
        impact: "Barang yang masih banyak di lemari lab diajukan kembali secara membabi buta."
      },
      {
        defect: "Pembelian Dilakukan Tanpa Pengecekan Stok Gudang",
        cause: "Bagian pembelian dan gudang tidak terhubung sistem",
        impact: "Terjadi duplikasi pembelian (pembelian ganda) dan penumpukan bahan berbahaya di lab."
      },
      {
        defect: "Bukti Penerimaan Hanya Difoto & Dikirim via Chat",
        cause: "Tidak ada dokumen formal Goods Receipt Note (GRN)",
        impact: "Keuangan membayar invoice tanpa verifikasi kesesuaian jumlah fisik (rawan fraud/selisih bayar)."
      }
    ],

    businessRules: [
      {
        ruleId: "BR-01",
        title: "Mandatory User Identity & Syllabus Tagging",
        desc: "Setiap Purchase Requisition (PR) wajib mencantumkan NIDN Dosen pengaju, kode mata kuliah praktik, dan peruntukan modul praktikum."
      },
      {
        ruleId: "BR-02",
        title: "Automated Stock Availability & Reservation Gate",
        desc: "Sistem ERP wajib melakukan auto-check saldo persediaan di seluruh gudang. Jika stok fisik tersedia >= jumlah yang diminta, PR tidak diteruskan ke Pembelian dan dialihkan menjadi Permintaan Pengeluaran Barang Internal (Material Issue)."
      },
      {
        ruleId: "BR-03",
        title: "Multi-Tier Value Authorization Matrix",
        desc: "Nominal <= Rp2.000.000 cukup approval Kepala Lab; Rp2.000.001 - Rp10.000.000 butuh approval Ka.Lab + Pudir II Keuangan; > Rp10.000.000 wajib persetujuan Direktur Politeknik."
      },
      {
        ruleId: "BR-05",
        title: "Re-Approval Saat Nilai Pembelian Naik (Kondisi Khusus)",
        desc: "Persetujuan lama GUGUR dan wajib diajukan ulang bila nilai baru dari penawaran terbaru (a) naik > 10% dari nilai yang telah disetujui, atau (b) melewati ambang level otorisasi BR-03. Jika kenaikan <= 10% dan level wewenang tidak berubah, persetujuan lama tetap berlaku dan pemberi approval hanya diberi notifikasi."
      },
      {
        ruleId: "BR-04",
        title: "Strict 3-Way Matching for Payment",
        desc: "Bagian keuangan dilarang keras menerbitkan Payment Voucher sebelum sistem mencocokkan Purchase Order (PO), Bukti Penerimaan Barang (GRN), dan Faktur Tagihan Vendor (Invoice) dengan batas toleransi selisih 0%."
      }
    ],

    raciMatrix: [
      { activity: "Pengajuan Kebutuhan Bahan Praktik", dosen: "R (Responsible)", kalab: "A (Accountable)", gudang: "I (Informed)", pembelian: "I", pimpinan: "I", keuangan: "I" },
      { activity: "Verifikasi Kebutuhan oleh Kepala Laboratorium", dosen: "C (Consulted)", kalab: "R & A", gudang: "I", pembelian: "I", pimpinan: "I", keuangan: "I" },
      { activity: "Pemeriksaan Stok oleh Gudang", dosen: "I", kalab: "A", gudang: "R", pembelian: "I", pimpinan: "I", keuangan: "I" },
      { activity: "Permintaan Penawaran & Pemilihan Vendor (RFQ)", dosen: "I", kalab: "C", gudang: "I", pembelian: "R & A", pimpinan: "I", keuangan: "I" },
      { activity: "Persetujuan Pembelian Berjenjang (PO Approval)", dosen: "I", kalab: "C", gudang: "I", pembelian: "R", pimpinan: "A", keuangan: "C" },
      { activity: "Penerimaan Fisik & Pemeriksaan Kualitas (QC/GRN)", dosen: "C", kalab: "C", gudang: "R & A", pembelian: "I", pimpinan: "I", keuangan: "I" },
      { activity: "Verifikasi 3-Way Match & Pembayaran Tagihan", dosen: "I", kalab: "I", gudang: "C", pembelian: "C", pimpinan: "I", keuangan: "R & A" }
    ]
  },

  // ==========================================
  // PRAKTIKUM 4: MODUL KEUANGAN
  // ==========================================
  p4: {
    initialCash: 30000000,
    coa: [
      { code: "1101", name: "Kas", type: "Aset Lancar", normalBalance: "Debit", defaultOpening: 30000000 },
      { code: "1102", name: "Piutang Usaha", type: "Aset Lancar", normalBalance: "Debit", defaultOpening: 0 },
      { code: "1103", name: "Persediaan Bahan Baku", type: "Aset Lancar", normalBalance: "Debit", defaultOpening: 0 },
      { code: "2101", name: "Utang Usaha", type: "Kewajiban Jangka Pendek", normalBalance: "Kredit", defaultOpening: 0 },
      { code: "3101", name: "Modal Pemilik (Saldo Awal)", type: "Ekuitas", normalBalance: "Kredit", defaultOpening: 30000000 },
      { code: "4101", name: "Penjualan Produk", type: "Pendapatan Operasional", normalBalance: "Kredit", defaultOpening: 0 },
      { code: "5101", name: "Beban Operasional", type: "Beban Operasional", normalBalance: "Debit", defaultOpening: 0 }
    ],

    standardTransactions: [
      {
        id: "TRX-01",
        desc: "Pembelian bahan baku secara kredit dari PT Sumber Baja",
        amount: 8000000,
        debitAccount: "1103",
        creditAccount: "2101",
        reason: "Persediaan bahan baku bertambah (Aset bertambah di sisi Debit), kewajiban kepada pemasok bertambah (Utang bertambah di sisi Kredit)."
      },
      {
        id: "TRX-02",
        desc: "Pembayaran sebagian utang pemasok",
        amount: 3000000,
        debitAccount: "2101",
        creditAccount: "1101",
        reason: "Kewajiban kepada pemasok berkurang (Utang berkurang di sisi Debit), aset kas perusahaan berkurang (Kas berkurang di sisi Kredit)."
      },
      {
        id: "TRX-03",
        desc: "Penjualan produk secara kredit kepada pelanggan CV Mandiri",
        amount: 12000000,
        debitAccount: "1102",
        creditAccount: "4101",
        reason: "Hak tagih kepada pelanggan bertambah (Piutang Usaha bertambah di sisi Debit), pendapatan perusahaan diakui (Penjualan bertambah di sisi Kredit)."
      },
      {
        id: "TRX-04",
        desc: "Penerimaan pembayaran sebagian piutang pelanggan",
        amount: 5000000,
        debitAccount: "1101",
        creditAccount: "1102",
        reason: "Aset kas bertambah dari pelunasan (Kas bertambah di sisi Debit), hak tagih piutang berkurang (Piutang berkurang di sisi Kredit)."
      },
      {
        id: "TRX-05",
        desc: "Pembayaran biaya operasional secara tunai (listrik & internet)",
        amount: 1500000,
        debitAccount: "5101",
        creditAccount: "1101",
        reason: "Beban operasional diakui pada periode berjalan (Beban bertambah di sisi Debit), kas berkurang untuk pembayaran (Kas berkurang di sisi Kredit)."
      }
    ]
  },

  // ==========================================
  // PRAKTIKUM 5: SCM DAN MATERIAL REQUIREMENT PLANNING (MRP)
  // ==========================================
  p5: {
    targetProduction: 300,
    productName: "Komponen Presisi Poros Mesin (KPP-300)",
    productionDeadlineDays: 6,

    bom: [
      {
        itemCode: "MAT-A",
        name: "Bahan Baku A (Aluminium Billet AL-6061)",
        ratioPerUnit: 3,
        uom: "Unit",
        currentStock: 400,
        onOrderStock: 100,
        leadTimeDays: 4,
        supplierName: "PT Alumindo Jaya Perkasa",
        unitPrice: 45000
      },
      {
        itemCode: "MAT-B",
        name: "Bahan Baku B (Baut High-Tensile HT-88)",
        ratioPerUnit: 2,
        uom: "Unit",
        currentStock: 250,
        onOrderStock: 0,
        leadTimeDays: 7,
        supplierName: "PT Fastener Baja Utama",
        unitPrice: 18000
      }
    ],

    orderRules: [
      { itemCode: "MAT-A", rule: "Lot-for-Lot (pesan sebesar kebutuhan bersih), MOQ 50 unit, pesan paling lambat Hari ke-2 agar tiba Hari ke-6", warehouse: "GD-01 Gudang Bahan Baku" },
      { itemCode: "MAT-B", rule: "Lot-for-Lot, MOQ 50 unit, lead time 7 hari sudah melewati target 6 hari sehingga wajib dipercepat/diganti sumbernya", warehouse: "GD-01 Gudang Bahan Baku" }
    ],

    shockScenario: {
      title: "Kondisi Baru: Keterlambatan Pemasok Bahan B",
      description: "Pemasok bahan B (PT Fastener Baja Utama) menginformasikan bahwa pesanan baru hanya dapat dikirim dalam 8 hari kerja (molor dari standar 7 hari), sedangkan target produksi 300 unit harus tuntas dalam 6 hari kerja.",
      options: [
        {
          id: "OPT-1",
          name: "Strategi 1: Split Production (Produksi Bertahap Sesuai Stok)",
          feasible: true,
          delayRisk: "Sedang (175 unit sisanya tetap terlambat bila berdiri sendiri)",
          extraCost: "Rp 0 (pengiriman parsial ke pelanggan)",
          leadTime: "125 unit selesai tepat waktu; 175 unit baru selesai setelah hari ke-8",
          description: "Gunakan 250 unit Bahan B yang ada di gudang untuk segera memproduksi 125 unit produk jadi pada hari 1-3. Sisa 175 unit produk dirakit segera setelah kiriman tiba, dengan komunikasi pengiriman parsial ke pelanggan."
        },
        {
          id: "OPT-2",
          name: "Strategi 2: Pengadaan Kilat dari Pemasok Alternatif Lokal",
          feasible: true,
          delayRisk: "Sangat Rendah",
          extraCost: "+Rp 756.000 (Markup 12% ongkir express)",
          leadTime: "3 hari kerja",
          description: "Beli 350 unit Bahan B dari supplier lokal mitra sekunder dengan lead time 3 hari kerja. Menjamin seluruh 300 unit produk selesai tuntas sebelum batas 6 hari kerja."
        },
        {
          id: "OPT-3",
          name: "Strategi 3: Pinjam / Transfer Stok Antar Fasilitas (Inter-Plant Transfer)",
          feasible: true,
          delayRisk: "Rendah",
          extraCost: "+Rp 250.000 (Biaya logistik internal)",
          leadTime: "2 hari kerja",
          description: "Melakukan transfer stok konsinyasi dari gudang lab manufaktur Politeknik rekanan atau cabang industri terdekat di Kawasan Cikarang."
        },
        {
          id: "OPT-4",
          name: "Strategi 4: Menunggu Pemasok Eksisting Tanpa Tindakan",
          feasible: false,
          delayRisk: "SANGAT TINGGI (Pasti Terlambat 2 Hari)",
          extraCost: "Denda penalti keterlambatan kontrak pelanggan",
          leadTime: "8 hari kerja (> target 6 hari)",
          description: "Opsi ini tidak direkomendasikan karena melanggar SLA kontrak pelanggan dan merusak reputasi perusahaan."
        }
      ]
    }
  },

  // ==========================================
  // AKUN PENGGUNA DEMO LOGIN
  // ==========================================
  demoAccounts: [
    { username: 'admin', password: 'admin123', name: 'Administrator Utama', role: 'Super Administrator ERP', dept: 'IT & Sistem Informasi', avatar: '👑' },
    { username: 'adie.kusna', password: 'dosen123', name: 'Adie Kusna Wibowo, S.T., M.Kom.', role: 'Dosen Pengampu ERP', dept: 'Akademik TRPL', avatar: '🎓' },
    { username: 'yazid', password: 'meta2026', name: 'Yazid (Mahasiswa TRPL)', role: 'Mahasiswa Praktikan', dept: 'Politeknik META Industri', avatar: '⭐' },
    { username: 'sales.andi', password: 'sales123', name: 'Andi Pratama', role: 'Staff Penjualan', dept: 'Sales & Marketing (SD)', avatar: '💼' },
    { username: 'it.budi', password: 'it123', name: 'Budi Santoso', role: 'IT System Administrator', dept: 'Infrastruktur & Keamanan', avatar: '🛠️' },
    { username: 'proc.citra', password: 'proc123', role: 'Procurement Officer', name: 'Citra Lestari', dept: 'Pengadaan & Pembelian (MM)', avatar: '📋' },
    { username: 'fin.dewi', password: 'fin123', name: 'Dewi Anggraini', role: 'Staff Akuntansi & Keuangan', dept: 'Finance & Controlling (FI)', avatar: '💰' },
    { username: 'wh.eko', password: 'wh123', name: 'Eko Saputra', role: 'Staff Gudang & Logistik', dept: 'Warehouse & Supply Chain', avatar: '📦' }
  ]
};


// Alias akun P4 (diturunkan dari coa) agar sesuai pemakaian di app.js
if (!erpData.p4.accounts) {
  erpData.p4.accounts = erpData.p4.coa.map(a => ({ code: a.code, name: a.name, class: a.type, normal: a.normalBalance, opening: a.defaultOpening }));
}
