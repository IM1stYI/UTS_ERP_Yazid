/**
 * META ERP SUITE - POLITEKNIK META INDUSTRI
 * Clean, Friendly & Minimalist Modern ERP Application
 * Dosen: Adie Kusna Wibowo | Mahasiswa: Yazid | TRPL 2026/2027
 */

const API = 'api/api.php';

// Safe API Call Helpers with error catching
const apiPost = (r, b) => fetch(API + '?r=' + r, {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(b)
}).then(x => { if (x.status === 401) { location.replace('login.php'); return null; } return x.ok ? x.json() : null; }).catch(() => null);

const apiGet = r => fetch(API + '?r=' + r)
  .then(x => { if (x.status === 401) { location.replace('login.php'); return null; } return x.ok ? x.json() : null; })
  .catch(() => null);

// Hybrid Data Persistence (Local Storage + MySQL API)
const erpDB = {
  save(k, v) {
    try { localStorage.setItem('erp_' + k, JSON.stringify(v)); } catch (e) {}
    if (k === 'p4') apiPost('p4', v);
  },
  load(k, def) {
    try {
      const v = localStorage.getItem('erp_' + k);
      return v ? JSON.parse(v) : def;
    } catch (e) {
      return def;
    }
  }
};

// Global format currency IDR
window.formatIDR = function(num) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    maximumFractionDigits: 0
  }).format(num);
};

// ==========================================================================
// APPLICATION INITIALIZATION
// ==========================================================================
document.addEventListener('DOMContentLoaded', () => {
  // 1. Initialize Database Monitor & Diagnostics
  initDbDiagnostics();

  // 2. Initialize Authentication & Demo Accounts
  initAuthSystem();

  // 3. Initialize Core Router & Tabs
  initRouter();
  initSubtabs();

  // 4. Initialize ERP Modules (P1 s/d P5)
  initPraktikum1();
  initPraktikum2();
  initPraktikum3();
  initPraktikum4();
  initPraktikum5();
});

// ==========================================================================
// 1. DATABASE DIAGNOSTICS & STATUS MONITOR
// ==========================================================================
let gDbInfo = null;

function initDbDiagnostics() {
  const badge = document.getElementById('db-status-badge');
  const modal = document.getElementById('db-modal');
  const btnClose = document.getElementById('db-modal-close');
  const btnRetry = document.getElementById('btn-retry-db');

  function checkDatabase(showModalAfter = false) {
    if (badge) {
      badge.innerHTML = '🔄 <small>Mengecek DB...</small>';
      badge.className = 'tag tag-gray';
    }

    apiGet('status').then(res => {
      gDbInfo = res;
      if (res && res.ok && res.database === 'connected') {
        if (badge) {
          badge.innerHTML = `🟢 ${res.driver || 'MySQL'}: <strong>${res.db_name || 'Aktif'}</strong>`;
          badge.className = 'tag tag-green';
          badge.title = 'Database MySQL terhubung. Klik untuk melihat detail tabel.';
        }
      } else {
        if (badge) {
          badge.innerHTML = `🟡 Mode Demo (Lokal)`;
          badge.className = 'tag tag-amber';
          badge.title = 'Database offline / belum disetup. Klik untuk panduan integrasi.';
        }
      }
      renderDbModalContent(res);
      if (showModalAfter && modal) modal.classList.add('active');
    }).catch(err => {
      gDbInfo = { ok: false, database: 'disconnected', error: err ? err.message : 'Gagal menghubungi api.php' };
      if (badge) {
        badge.innerHTML = `🟡 Mode Demo (Lokal)`;
        badge.className = 'tag tag-amber';
      }
      renderDbModalContent(gDbInfo);
    });
  }

  function renderDbModalContent(info) {
    const statusBox = document.getElementById('db-modal-status-box');
    const tableList = document.getElementById('db-modal-table-list');
    if (!statusBox) return;

    if (info && info.ok && info.database === 'connected') {
      statusBox.className = 'clean-callout callout-green';
      statusBox.innerHTML = `
        <strong>🟢 STATUS: TERHUBUNG KE DATABASE ${(info.driver || 'MySQL').toUpperCase()}</strong><br>
        Database: <code>${info.db_name}</code> • Server: <code>localhost</code> • Driver: <code>${info.driver ? info.driver + ' (offline)' : 'PDO MySQL'}</code><br>
        <small style="color:var(--text-muted);">Seluruh modul P1, P2, P3, P4, P5 dan Akun sinkron langsung ke database server.</small>
      `;

      if (tableList && info.tables) {
        tableList.innerHTML = `
          <tr><td><code>akun</code> (Multi-Role Demo Users)</td><td><span class="tag tag-green">Tersedia</span></td><td class="text-right font-mono">${info.tables.akun || 0} Akun</td></tr>
          <tr><td><code>p1_sales_order</code> & <code>p1_master_data</code></td><td><span class="tag tag-green">Tersedia</span></td><td class="text-right font-mono">${info.tables.p1_sales_order || 0} Baris SO</td></tr>
          <tr><td><code>p2_rbac</code> & <code>p2_chaos_logs</code></td><td><span class="tag tag-green">Tersedia</span></td><td class="text-right font-mono">${info.tables.p2_rbac || 0} Peran</td></tr>
          <tr><td><code>p3_pengadaan</code> & <code>p3_approval_rules</code></td><td><span class="tag tag-green">Tersedia</span></td><td class="text-right font-mono">${info.tables.p3_pengadaan || 0} Pengadaan</td></tr>
          <tr><td><code>coa</code>, <code>p4_jurnal</code>, <code>p4_status</code></td><td><span class="tag tag-green">Tersedia</span></td><td class="text-right font-mono">${info.tables.p4_jurnal || 0} Jurnal</td></tr>
          <tr><td><code>p5_material</code>, <code>p5_grn</code>, <code>p5_mrp_log</code></td><td><span class="tag tag-green">Tersedia</span></td><td class="text-right font-mono">${info.tables.p5_material || 0} Material</td></tr>
        `;
      }
    } else {
      statusBox.className = 'clean-callout callout-amber';
      statusBox.innerHTML = `
        <strong>🟡 STATUS: MODE DEMO LOKAL (OFFLINE STORAGE)</strong><br>
        ${info && info.error ? `<small style="color:#b91c1c;">Keterangan: ${info.error}</small><br>` : ''}
        Sistem saat ini menggunakan memori browser & LocalStorage. Semua fitur simulator (P1 s/d P5) tetap dapat diuji dengan lancar.<br>
        <small style="color:var(--text-muted);">Untuk mengaktifkan database di hosting: Import <code>database.sql</code> via phpMyAdmin dan sesuaikan kredensial di <code>api/config.php</code>.</small>
      `;

      if (tableList) {
        tableList.innerHTML = `
          <tr><td><code>akun</code> (Akun Login)</td><td><span class="tag tag-green">MySQL + bcrypt</span></td><td class="text-right font-mono">Sesi PHP</td></tr>
          <tr><td><code>p1_master_data</code> (Modul 1)</td><td><span class="tag tag-amber">Memori Browser</span></td><td class="text-right font-mono">${erpData.p1.masterDataList.length} Master</td></tr>
          <tr><td><code>p2_rbac</code> (Modul 2)</td><td><span class="tag tag-amber">Memori Browser</span></td><td class="text-right font-mono">${erpData.p2.rbacMatrix.length} Matriks</td></tr>
          <tr><td><code>p3_business_rules</code> (Modul 3)</td><td><span class="tag tag-amber">Memori Browser</span></td><td class="text-right font-mono">${erpData.p3.businessRules.length} Aturan</td></tr>
          <tr><td><code>coa</code> & <code>p4_jurnal</code> (Modul 4)</td><td><span class="tag tag-amber">LocalStorage</span></td><td class="text-right font-mono">${erpData.p4.standardTransactions.length} Jurnal</td></tr>
          <tr><td><code>p5_material</code> & BOM (Modul 5)</td><td><span class="tag tag-amber">Memori Browser</span></td><td class="text-right font-mono">${erpData.p5.bom.length} Material</td></tr>
        `;
      }
    }
  }

  if (badge) {
    badge.addEventListener('click', () => {
      renderDbModalContent(gDbInfo);
      if (modal) modal.classList.add('active');
    });
  }

  if (btnClose && modal) {
    btnClose.addEventListener('click', () => modal.classList.remove('active'));
  }

  if (btnRetry) {
    btnRetry.addEventListener('click', () => checkDatabase(false));
  }

  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.remove('active');
    });
  }

  checkDatabase(false);
}

// ==========================================================================
// 2. AUTHENTICATION & DEMO ACCOUNT SYSTEM
// ==========================================================================
let gActiveUser = null;

function initAuthSystem() {
  const wrap = document.getElementById('profile-menu');
  const btnOpen = document.getElementById('btn-user-profile');
  const dd = document.getElementById('profile-dropdown');
  const btnLogout = document.getElementById('btn-logout');
  const set = (id, v) => { const el = document.getElementById(id); if (el) el.textContent = v; };

  function render(u) {
    gActiveUser = { username: u.username, name: u.nama_lengkap, role: u.peran, dept: u.departemen, avatar: u.avatar || '👤' };
    set('user-badge-avatar', gActiveUser.avatar);
    set('user-badge-name', gActiveUser.name.split(',')[0]);
    set('user-badge-role', '(' + gActiveUser.role + ')');
    set('pd-avatar', gActiveUser.avatar);
    set('pd-name', gActiveUser.name);
    set('pd-role', gActiveUser.role);
    set('pd-dept', gActiveUser.dept);
    set('pd-user', '@' + gActiveUser.username);
    set('pps-avatar', gActiveUser.avatar);
    set('pps-name', gActiveUser.name);
    set('pps-user', '@' + gActiveUser.username);
    set('pps-role', gActiveUser.role);
    set('pps-dept', gActiveUser.dept);
  }
  (window.erpAuthReady || Promise.resolve(null)).then(u => { if (u) render(u); });

  function toggle(open) {
    if (!dd || !btnOpen) return;
    dd.hidden = !open;
    btnOpen.setAttribute('aria-expanded', open ? 'true' : 'false');
  }
  if (btnOpen) btnOpen.addEventListener('click', e => { e.stopPropagation(); toggle(dd.hidden); });
  document.addEventListener('click', e => { if (wrap && !wrap.contains(e.target)) toggle(false); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') { toggle(false); btnOpen && btnOpen.focus(); } });

  function doPrint(profileOnly) {
    toggle(false);
    if (profileOnly) set('pps-date', new Date().toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' }));
    document.body.classList.toggle('print-profile', !!profileOnly);
    const cleanup = () => { document.body.classList.remove('print-profile'); window.removeEventListener('afterprint', cleanup); };
    window.addEventListener('afterprint', cleanup);
    setTimeout(() => window.print(), 50);
  }
  const bp = document.getElementById('btn-print-pdf');
  const bpp = document.getElementById('btn-print-profile');
  const bdb = document.getElementById('btn-db-status');
  if (bp) bp.addEventListener('click', () => doPrint(false));
  if (bpp) bpp.addEventListener('click', () => doPrint(true));
  if (bdb) bdb.addEventListener('click', () => { toggle(false); const b = document.getElementById('db-status-badge'); if (b) b.click(); });

  if (btnLogout) btnLogout.addEventListener('click', () => {
    btnLogout.disabled = true;
    fetch(API + '?r=logout', { method: 'POST', credentials: 'same-origin' }).catch(() => null).then(() => location.replace('login.php'));
  });
}

// ==========================================================================
// 3. ROUTER & MAIN TAB NAVIGATION
// ==========================================================================
function initRouter() {
  const navBtns = document.querySelectorAll('.nav-pill-btn');
  const tabPanes = document.querySelectorAll('.tab-pane');

  function switchTab(targetId) {
    const cleanId = targetId.replace('#', '') || 'beranda';

    navBtns.forEach(btn => {
      if (btn.getAttribute('data-tab') === cleanId) {
        btn.classList.add('active');
      } else {
        btn.classList.remove('active');
      }
    });

    tabPanes.forEach(pane => {
      if (pane.id === cleanId) {
        pane.classList.add('active');
      } else {
        pane.classList.remove('active');
      }
    });

    window.location.hash = cleanId;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  navBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const tab = btn.getAttribute('data-tab');
      switchTab(tab);
    });
  });

  if (window.location.hash) {
    switchTab(window.location.hash);
  } else {
    switchTab('beranda');
  }

  window.addEventListener('hashchange', () => {
    switchTab(window.location.hash);
  });
}

// Global helper for card navigation
window.navigateToTab = function(tabId) {
  const btn = document.querySelector(`.nav-pill-btn[data-tab="${tabId}"]`);
  if (btn) btn.click();
};

// ==========================================================================
// 4. SUBTAB CONTROLLER
// ==========================================================================
function initSubtabs() {
  const subtabBars = document.querySelectorAll('.subtabs-bar');

  subtabBars.forEach(bar => {
    const buttons = bar.querySelectorAll('.subtab-btn');
    const moduleContainer = bar.parentElement;

    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        const targetSubtab = btn.getAttribute('data-subtab');

        buttons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const contents = moduleContainer.querySelectorAll('.subtab-content');
        contents.forEach(c => {
          if (c.id === targetSubtab) {
            c.classList.add('active');
          } else {
            c.classList.remove('active');
          }
        });
      });
    });
  });
}

// ==========================================================================
// 5. PRAKTIKUM 1: EVOLUSI DAN INTEGRASI ERP
// ==========================================================================
function initPraktikum1() {
  // Render Silo Issues Table
  const siloTableBody = document.getElementById('p1-silo-table-body');
  if (siloTableBody) {
    siloTableBody.innerHTML = erpData.p1.siloIssues.map(item => `
      <tr>
        <td><strong>${item.dept}</strong></td>
        <td><span class="tag tag-amber">${item.currentSystem}</span></td>
        <td style="color: #b91c1c; font-weight: 600;">${item.problem}</td>
        <td>${item.impact}</td>
        <td><span class="tag tag-green">${item.solution}</span></td>
      </tr>
    `).join('');
  }

  // Render Master Data Table
  const masterTableBody = document.getElementById('p1-master-table-body');
  if (masterTableBody) {
    masterTableBody.innerHTML = erpData.p1.masterDataList.map(item => `
      <tr>
        <td><strong class="font-mono" style="color: var(--brand-primary);">${item.code}</strong></td>
        <td><strong>${item.name}</strong></td>
        <td><span class="tag tag-blue">${item.primaryOwner}</span></td>
        <td><small style="color:var(--text-muted);">${item.usedBy}</small></td>
        <td><small style="color:var(--text-muted);">${item.attributes}</small></td>
        <td><code style="font-size:0.75rem; background:#f1f5f9; padding:2px 6px; border-radius:4px;">${item.dummyExample}</code></td>
      </tr>
    `).join('');
  }

  // Individual Challenge Switcher
  const challengePills = document.querySelectorAll('.p1-challenge-btn');
  const challengeOutput = document.getElementById('p1-challenge-output');

  function renderChallenge(challengeId) {
    const ch = erpData.p1.individualChallenges.find(c => c.id === challengeId);
    if (!ch || !challengeOutput) return;

    challengeOutput.innerHTML = `
      <div style="background: #ffffff; border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 18px; margin-top: 10px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
          <h4 style="font-size: 0.98rem; color: var(--text-main); font-weight: 700;">${ch.title}</h4>
          <span class="tag tag-red">Kondisi Pengujian</span>
        </div>
        <div style="margin-bottom: 10px;">
          <strong style="font-size:0.8rem; color: var(--text-muted); text-transform:uppercase;">Pemicu Kondisi:</strong>
          <p style="font-size:0.88rem; color: var(--text-main); margin-top:2px;">${ch.trigger}</p>
        </div>
        <div style="margin-bottom: 12px;">
          <strong style="font-size:0.8rem; color: var(--text-muted); text-transform:uppercase;">Modul Terdampak:</strong>
          <p style="font-size:0.88rem; color: var(--brand-primary); font-weight:600; margin-top:2px;">${ch.affectedModule}</p>
        </div>
        <div class="clean-callout callout-green">
          <strong style="font-size:0.8rem; text-transform:uppercase;">Aksi Otomatis & Solusi Sistem ERP:</strong>
          <p style="font-size:0.86rem; margin-top:2px;">${ch.systemAction}</p>
        </div>
      </div>
    `;
  }

  challengePills.forEach(btn => {
    btn.addEventListener('click', () => {
      challengePills.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      renderChallenge(btn.getAttribute('data-challenge'));
    });
  });

  if (challengePills.length > 0) {
    renderChallenge('c1');
  }

  // Interactive Order Simulation
  const runSimBtn = document.getElementById('p1-run-order-sim');
  const simTerminal = document.getElementById('p1-sim-terminal');

  if (runSimBtn && simTerminal) {
    runSimBtn.addEventListener('click', () => {
      const cust = document.getElementById('p1-sim-cust').value;
      const item = document.getElementById('p1-sim-item').value;
      const qty = parseInt(document.getElementById('p1-sim-qty').value, 10) || 50;

      const FG = {
        'Brake Caliper Assy Type-C (MAT-FG-001)': { stok: 120, harga: 240000, cost: 185000 },
        'Piston Master Cylinder (MAT-FG-002)': { stok: 80, harga: 150000, cost: 110000 }
      }[item] || { stok: 120, harga: 240000, cost: 185000 };
      const bahanCukupUntuk = 80;
      const dariStok = Math.min(FG.stok, qty);
      const kurang = qty - dariStok;
      const bisaProduksi = Math.min(kurang, bahanCukupUntuk);
      const defisitBahan = kurang - bisaProduksi;
      const nilai = qty * FG.harga;
      const sisaLimit = 200000000 - 45000000;
      const blokir = nilai > sisaLimit;

      // Sinkron ke API MySQL bila aktif
      const soNumber = 'SO-' + new Date().getFullYear() + '-' + Math.floor(1000 + Math.random() * 9000);
      apiPost('so', {
        no_so: soNumber,
        pelanggan: cust,
        produk: item,
        qty: qty,
        nilai: nilai,
        status: blokir ? 'CREDIT BLOCKED' : 'APPROVED',
        catatan_kredit: blokir ? 'Nilai pesanan melebihi sisa limit kredit' : 'Limit kredit aman'
      });

      simTerminal.innerHTML = `
[SD] Sales Order #${soNumber} | ${cust} | ${item} | ${qty} unit | Nilai ${formatIDR(nilai)}
[CREDIT CHECK] Limit Rp 200.000.000 | Outstanding Rp 45.000.000 | Sisa ${formatIDR(sisaLimit)} -> ${blokir ? 'CREDIT BLOCKED (SO ditahan, Keuangan harus rilis)' : 'LOLOS'}
[GUDANG] Stok jadi ${FG.stok} unit | Dialokasikan ${dariStok} unit | Stok bebas setelah alokasi: ${FG.stok - dariStok} unit
[PRODUKSI] ${kurang === 0 ? 'Stok cukup, tidak ada Work Order.' : 'Kekurangan ' + kurang + ' unit -> Work Order ' + bisaProduksi + ' unit (bahan baku cukup untuk ' + bahanCukupUntuk + ' unit)' + (defisitBahan > 0 ? ' + Purchase Requisition bahan baku untuk ' + defisitBahan + ' unit, pengiriman parsial/ditunda' : '')}
[KEUANGAN] Jurnal otomatis saat faktur: Dr Piutang Usaha ${formatIDR(nilai)} / Cr Penjualan ${formatIDR(nilai)}
[KEUANGAN] Saat Surat Jalan ${dariStok} unit dikirim: Dr HPP ${formatIDR(dariStok * FG.cost)} / Cr Persediaan Barang Jadi ${formatIDR(dariStok * FG.cost)}
[HASIL] Satu transaksi menggerakkan Gudang, Produksi, dan Keuangan tanpa input ulang (Single Source of Truth terintegrasi).
      `;
    });
  }
}

// ==========================================================================
// 6. PRAKTIKUM 2: ARSITEKTUR TEKNIS ERP
// ==========================================================================
function initPraktikum2() {
  const rbacBody = document.getElementById('p2-rbac-body');
  if (rbacBody) {
    rbacBody.innerHTML = erpData.p2.rbacMatrix.map(row => `
      <tr>
        <td><strong>${row.role}</strong></td>
        <td><span class="tag ${getPermTag(row.sales)}">${row.sales}</span></td>
        <td><span class="tag ${getPermTag(row.warehouse)}">${row.warehouse}</span></td>
        <td><span class="tag ${getPermTag(row.production)}">${row.production}</span></td>
        <td><span class="tag ${getPermTag(row.purchasing)}">${row.purchasing}</span></td>
        <td><span class="tag ${getPermTag(row.finance)}">${row.finance}</span></td>
        <td><small style="color:var(--text-muted);">${row.notes}</small></td>
      </tr>
    `).join('');
  }

  function getPermTag(perm) {
    if (perm === 'CRUD') return 'tag-green';
    if (perm === 'R') return 'tag-blue';
    return 'tag-gray';
  }

  const disasterPills = document.querySelectorAll('.p2-disaster-btn');
  const simCard = document.getElementById('p2-disaster-card');

  function renderDisaster(disasterId) {
    const ds = erpData.p2.disasterScenarios.find(d => d.id === disasterId);
    if (!ds || !simCard) return;

    let sevTag = ds.severity.includes('CRITICAL') ? 'tag-red' : (ds.severity.includes('HIGH') ? 'tag-amber' : 'tag-blue');

    simCard.innerHTML = `
      <div style="background: #ffffff; border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 18px; margin-top: 10px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 12px;">
          <h4 style="font-size: 0.98rem; color: var(--text-main); font-weight: 700;">${ds.name}</h4>
          <span class="tag ${sevTag}">${ds.severity}</span>
        </div>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:14px; margin-bottom: 12px;">
          <div style="background:#fef2f2; border:1px solid #fee2e2; padding:12px; border-radius:var(--radius-sm);">
            <strong style="font-size:0.76rem; color:#991b1b; text-transform:uppercase;">Akar Masalah (Root Cause):</strong>
            <p style="font-size:0.84rem; color:#7f1d1d; margin-top:3px;">${ds.rootCause}</p>
          </div>
          <div style="background:#fffbeb; border:1px solid #fef3c7; padding:12px; border-radius:var(--radius-sm);">
            <strong style="font-size:0.76rem; color:#92400e; text-transform:uppercase;">Dampak Operasional:</strong>
            <p style="font-size:0.84rem; color:#78350f; margin-top:3px;">${ds.impact}</p>
          </div>
        </div>
        <div class="clean-callout callout-green">
          <strong style="font-size:0.78rem; text-transform:uppercase;">Tindakan Penanganan & Rancangan Redundansi:</strong>
          <p style="font-size:0.85rem; margin-top:3px;">${ds.mitigation}</p>
        </div>
        <div style="display:flex; justify-content:flex-end;">
          <button id="p2-btn-test-failover" class="btn-primary" style="font-size:0.82rem;">
            ⚡ Jalankan Uji Failover Otomatis
          </button>
        </div>
        <div id="p2-failover-log" class="output-card" style="display:none;"></div>
      </div>
    `;

    const failoverBtn = document.getElementById('p2-btn-test-failover');
    const logBox = document.getElementById('p2-failover-log');
    if (failoverBtn && logBox) {
      failoverBtn.addEventListener('click', () => {
        logBox.style.display = 'block';
        apiPost('chaos', {
          kode: ds.id,
          nama: ds.name,
          kategori: 'Chaos Failover Test',
          dampak: ds.impact,
          status: 'Auto-Failover Berhasil (RTO 3.2 detik)'
        });
        logBox.innerHTML = `
[SYSTEM MONITOR] Terdeteksi simulasi kondisi: ${ds.name}
[AUTOMATION ENGINE] Memicu failover script otomatis...
[HEALTH CHECK] Status node primer: UNREACHABLE.
[FAILOVER] Mengalihkan koneksi ke node cadangan (Hot Standby / Replica)...
[VERIFICATION] Menjalankan integrity check database & API endpoints...
[RESTORED] Sistem kembali beroperasi penuh dalam 3.2 detik. Semua data transaksi aman!
        `;
      });
    }
  }

  disasterPills.forEach(btn => {
    btn.addEventListener('click', () => {
      disasterPills.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      renderDisaster(btn.getAttribute('data-disaster'));
    });
  });

  if (disasterPills.length > 0) {
    renderDisaster('ds1');
  }
}

// ==========================================================================
// 7. PRAKTIKUM 3: PEMETAAN PROSES BISNIS & APPROVAL
// ==========================================================================
function initPraktikum3() {
  const asIsBody = document.getElementById('p3-asis-defects-body');
  if (asIsBody) {
    asIsBody.innerHTML = erpData.p3.asIsDefects.map(d => `
      <tr>
        <td><strong style="color:#b91c1c;">${d.defect}</strong></td>
        <td>${d.cause}</td>
        <td><span class="tag tag-red">RISK</span> ${d.impact}</td>
      </tr>
    `).join('');
  }

  const rulesList = document.getElementById('p3-business-rules-list');
  if (rulesList) {
    rulesList.innerHTML = erpData.p3.businessRules.map(r => `
      <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:12px; margin-bottom:10px;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
          <span class="tag tag-blue">${r.ruleId}</span>
          <strong style="font-size:0.88rem; color:var(--text-main);">${r.title}</strong>
        </div>
        <p style="font-size:0.82rem; color:var(--text-muted); line-height:1.5;">${r.desc}</p>
      </div>
    `).join('');
  }

  const raciBody = document.getElementById('p3-raci-body');
  if (raciBody) {
    raciBody.innerHTML = erpData.p3.raciMatrix.map(row => `
      <tr>
        <td><strong>${row.activity}</strong></td>
        <td class="text-center font-mono">${row.dosen}</td>
        <td class="text-center font-mono">${row.kalab}</td>
        <td class="text-center font-mono">${row.gudang}</td>
        <td class="text-center font-mono">${row.pembelian}</td>
        <td class="text-center font-mono">${row.pimpinan}</td>
        <td class="text-center font-mono">${row.keuangan}</td>
      </tr>
    `).join('');
  }

  const nominalInput = document.getElementById('p3-sim-nominal');
  const nominalDisplay = document.getElementById('p3-sim-nominal-display');
  const approvalPathBox = document.getElementById('p3-approval-path-box');
  const triggerSpikeBtn = document.getElementById('p3-trigger-spike-btn');

  function updateApprovalPath(amount) {
    if (nominalDisplay) nominalDisplay.innerText = formatIDR(amount);

    let levelTitle = '';
    let approver = '';
    let tagClass = 'tag-blue';
    let explanation = '';

    if (amount <= 2000000) {
      levelTitle = 'Level 1: Pembelian Rutin (<= Rp 2.000.000)';
      approver = 'Kepala Laboratorium Manufaktur';
      tagClass = 'tag-green';
      explanation = 'Cukup disetujui digital oleh Kepala Lab berdasarkan pagu anggaran semesteran.';
    } else if (amount <= 10000000) {
      levelTitle = 'Level 2: Pembelian Menengah (Rp 2.000.001 - Rp 10.000.000)';
      approver = 'Ka.Lab + Pudir II Bidang Keuangan';
      tagClass = 'tag-amber';
      explanation = 'Wajib 2-Step Approval: Verifikasi teknis Ka.Lab, lalu review anggaran oleh Pudir II Keuangan.';
    } else {
      levelTitle = 'Level 3: Pembelian Bernilai Besar (> Rp 10.000.000)';
      approver = 'Ka.Lab + Pudir II Keuangan + Direktur Politeknik';
      tagClass = 'tag-red';
      explanation = 'Wajib 3-Step Approval hingga tingkat Direktur Politeknik disertai perbandingan 3 penawaran vendor.';
    }

    if (approvalPathBox) {
      approvalPathBox.innerHTML = `
        <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:14px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <strong style="font-size:0.9rem; color:var(--text-main);">${levelTitle}</strong>
            <span class="tag ${tagClass}">Tingkat Wewenang</span>
          </div>
          <p style="font-size:0.86rem; color:var(--brand-primary-dark); font-weight:700; margin-bottom:4px;">
            Pejabat Pemberi Otorisasi: ${approver}
          </p>
          <p style="font-size:0.82rem; color:var(--text-muted);">${explanation}</p>
        </div>
      `;
    }
  }

  if (nominalInput) {
    nominalInput.addEventListener('input', (e) => {
      updateApprovalPath(parseInt(e.target.value, 10));
    });
    updateApprovalPath(parseInt(nominalInput.value, 10));
  }

  if (triggerSpikeBtn && nominalInput) {
    const lvl = v => v <= 2000000 ? 1 : (v <= 10000000 ? 2 : 3);
    let box = document.getElementById('p3-spike-result');
    if (!box) {
      box = document.createElement('div');
      box.id = 'p3-spike-result';
      box.style.marginTop = '14px';
      triggerSpikeBtn.insertAdjacentElement('afterend', box);
    }

    triggerSpikeBtn.addEventListener('click', () => {
      const lama = parseInt(nominalInput.value, 10);
      const baru = lama + 900000;
      const naik = (baru - lama) / lama * 100;
      const lewatLevel = lvl(baru) !== lvl(lama);
      const ulang = naik > 10 || lewatLevel;
      nominalInput.value = baru;
      updateApprovalPath(baru);

      // Sinkron ke database pengadaan bila aktif
      apiPost('pr', {
        no_pr: 'PR-TEST-' + Math.floor(1000 + Math.random() * 9000),
        pemohon: (gActiveUser && gActiveUser.name) || 'Lab Manufaktur TRPL',
        departemen: 'Lab Manufaktur',
        item: 'Pengadaan Bahan Praktikum (Uji Kenaikan Penawaran BR-05)',
        nominal: baru,
        urgensi: 'Normal',
        level: 'Level ' + lvl(baru),
        status: ulang ? 'PENDING APPROVAL ULANG' : 'APPROVED',
        disetujui_oleh: ulang ? 'Menunggu Approval Pejabat Baru' : 'Persetujuan Tetap Sah',
        catatan: `Kenaikan nilai ${naik.toFixed(1)}% dari ${formatIDR(lama)} ke ${formatIDR(baru)}`
      });

      box.innerHTML = `
        <div class="clean-callout ${ulang ? 'callout-amber' : 'callout-blue'}">
          <strong>Hasil Uji Aturan BR-05 (Kenaikan Harga):</strong> Nilai semula ${formatIDR(lama)} (Level ${lvl(lama)}) naik menjadi ${formatIDR(baru)} (Level ${lvl(baru)}), lonjakan sebesar ${naik.toFixed(1)}%.<br>
          ${ulang ? '<strong>Persetujuan lama GUGUR dan wajib diajukan ulang!</strong> Terjadi karena ' + [naik > 10 ? 'kenaikan melebihi toleransi 10%' : '', lewatLevel ? 'melewati ambang level otorisasi baru' : ''].filter(Boolean).join(' dan ') + '. Status PR berubah menjadi "Menunggu Approval Baru".' : 'Persetujuan lama tetap berlaku; pejabat pemberi approval hanya menerima notifikasi perubahan.'}
        </div>
      `;
    });
  }
}

// ==========================================================================
// 8. PRAKTIKUM 4: MODUL KEUANGAN & AUDIT TRAIL
// ==========================================================================
function initPraktikum4() {
  const saved = erpDB.load('p4', null);
  let transactions = saved ? saved.transactions : JSON.parse(JSON.stringify(erpData.p4.standardTransactions));
  let isDuplicated = saved ? saved.isDuplicated : false;
  let isCorrected = saved ? saved.isCorrected : false;

  const initialCash = erpData.p4.initialCash;
  const initialEquity = erpData.p4.initialEquity;

  const coaBody = document.getElementById('p4-coa-body');
  if (coaBody) {
    coaBody.innerHTML = erpData.p4.accounts.map(acc => `
      <tr>
        <td><strong class="font-mono" style="color:var(--brand-primary);">${acc.code}</strong></td>
        <td><strong>${acc.name}</strong></td>
        <td><span class="tag tag-blue">${acc.class}</span></td>
        <td class="text-center font-mono">${acc.normal}</td>
        <td class="text-right font-mono">${formatIDR(acc.initialBalance)}</td>
      </tr>
    `).join('');
  }

  const trxTableBody = document.getElementById('p4-trx-table-body');
  const tbBody = document.getElementById('p4-tb-body');
  const tbTotalDebit = document.getElementById('p4-tb-total-debit');
  const tbTotalCredit = document.getElementById('p4-tb-total-credit');
  const tbStatusTag = document.getElementById('p4-tb-status-tag');
  const glBody = document.getElementById('p4-gl-body');
  const isRevenue = document.getElementById('p4-is-revenue');
  const isExpense = document.getElementById('p4-is-expense');
  const isNetProfit = document.getElementById('p4-is-net-profit');
  const statusBanner = document.getElementById('p4-simulation-status-banner');

  const btnDuplicateTrx = document.getElementById('p4-btn-duplicate-trx');
  const btnCorrectTrx = document.getElementById('p4-btn-correct-trx');
  const btnResetTrx = document.getElementById('p4-btn-reset-trx');

  function calculateFinancials() {
    erpDB.save('p4', { transactions, isDuplicated, isCorrected });

    if (trxTableBody) {
      trxTableBody.innerHTML = transactions.map(t => {
        const isDup = t.id === 'TRX-02-DUP';
        const isCorr = t.id === 'CORR-01';
        let rowStyle = '';
        let tagHtml = '';

        if (isDup) {
          rowStyle = 'background-color: #fef2f2;';
          tagHtml = '<span class="tag tag-red" style="margin-left:6px;">DUPLIKASI (ERROR)</span>';
        } else if (isCorr) {
          rowStyle = 'background-color: #ecfdf5;';
          tagHtml = '<span class="tag tag-green" style="margin-left:6px;">JURNAL PEMBALIK</span>';
        }

        const debitAccObj = erpData.p4.accounts.find(a => a.code === t.debitAccount);
        const creditAccObj = erpData.p4.accounts.find(a => a.code === t.creditAccount);

        return `
          <tr style="${rowStyle}">
            <td><strong class="font-mono">${t.id}</strong>${tagHtml}</td>
            <td>
              <strong>${t.desc}</strong>
              <small style="display:block; color:var(--text-muted); margin-top:2px;">${t.reason}</small>
            </td>
            <td><span class="tag tag-blue">${t.debitAccount}</span> ${debitAccObj ? debitAccObj.name : ''}</td>
            <td><span class="tag tag-gray">${t.creditAccount}</span> ${creditAccObj ? creditAccObj.name : ''}</td>
            <td class="text-right font-mono" style="font-weight:700;">${formatIDR(t.amount)}</td>
          </tr>
        `;
      }).join('');
    }

    const balances = {};
    (erpData.p4.accounts || erpData.p4.coa.map(a => ({ code: a.code, name: a.name, class: a.type, normal: a.normalBalance }))).forEach(a => {
      balances[a.code] = {
        name: a.name,
        class: a.class,
        normal: a.normal,
        debitTotal: 0,
        creditTotal: 0,
        netBalance: 0
      };
    });

    balances['1101'].debitTotal += initialCash;
    balances['3101'].creditTotal += initialEquity;

    transactions.forEach(t => {
      if (balances[t.debitAccount]) balances[t.debitAccount].debitTotal += t.amount;
      if (balances[t.creditAccount]) balances[t.creditAccount].creditTotal += t.amount;
    });

    let sumDebit = 0;
    let sumCredit = 0;

    let glHtml = '';

    erpData.p4.accounts.forEach(a => {
      const b = balances[a.code];
      let endingDebit = 0;
      let endingCredit = 0;

      if (b.normal === 'Debit') {
        const net = b.debitTotal - b.creditTotal;
        b.netBalance = net;
        if (net >= 0) {
          endingDebit = net;
        } else {
          endingCredit = Math.abs(net);
        }
      } else {
        const net = b.creditTotal - b.debitTotal;
        b.netBalance = net;
        if (net >= 0) {
          endingCredit = net;
        } else {
          endingDebit = Math.abs(net);
        }
      }

      sumDebit += endingDebit;
      sumCredit += endingCredit;

      glHtml += `
        <tr>
          <td><strong class="font-mono" style="color:var(--brand-primary);">${a.code}</strong></td>
          <td><strong>${a.name}</strong></td>
          <td class="text-right font-mono">${formatIDR(b.debitTotal)}</td>
          <td class="text-right font-mono">${formatIDR(b.creditTotal)}</td>
          <td class="text-right font-mono" style="font-weight:700; color:${b.netBalance < 0 ? '#b91c1c' : 'inherit'};">
            ${formatIDR(b.netBalance)} (${b.normal})
          </td>
        </tr>
      `;
    });

    if (glBody) glBody.innerHTML = glHtml;

    if (tbBody) {
      tbBody.innerHTML = erpData.p4.accounts.map(a => {
        const b = balances[a.code];
        let d = 0, c = 0;
        if (b.normal === 'Debit') {
          if (b.netBalance >= 0) d = b.netBalance; else c = Math.abs(b.netBalance);
        } else {
          if (b.netBalance >= 0) c = b.netBalance; else d = Math.abs(b.netBalance);
        }

        return `
          <tr>
            <td><strong class="font-mono">${a.code}</strong></td>
            <td><strong>${a.name}</strong></td>
            <td class="text-right font-mono">${d > 0 ? formatIDR(d) : '-'}</td>
            <td class="text-right font-mono">${c > 0 ? formatIDR(c) : '-'}</td>
          </tr>
        `;
      }).join('');
    }

    if (tbTotalDebit) tbTotalDebit.innerText = formatIDR(sumDebit);
    if (tbTotalCredit) tbTotalCredit.innerText = formatIDR(sumCredit);

    const isBalanced = sumDebit === sumCredit;
    if (tbStatusTag) {
      if (isBalanced) {
        tbStatusTag.className = 'tag tag-green';
        tbStatusTag.innerText = 'SEIMBANG (BALANCED) ✓';
      } else {
        tbStatusTag.className = 'tag tag-red';
        tbStatusTag.innerText = 'TIDAK SEIMBANG ⚠️';
      }
    }

    const revenue = balances['4101'].netBalance;
    const expense = balances['5101'].netBalance;
    const netProfit = revenue - expense;

    if (isRevenue) isRevenue.innerText = formatIDR(revenue);
    if (isExpense) isExpense.innerText = formatIDR(expense);
    if (isNetProfit) {
      isNetProfit.innerText = formatIDR(netProfit);
      isNetProfit.style.color = netProfit >= 0 ? '#059669' : '#b91c1c';
    }

    if (statusBanner) {
      if (isCorrected) {
        statusBanner.className = 'clean-callout callout-green';
        statusBanner.innerHTML = `
          <strong>STATUS: JURNAL KOREKSI BERHASIL DITERAPKAN.</strong><br>
          Transaksi duplikasi (TRX-02-DUP) telah dinetralkan menggunakan Jurnal Pembalik resmi (CORR-01) tanpa menghapus data mentah. Saldo Kas kembali normal di Rp 30.500.000 dan Neraca Saldo tetap seimbang (Total Rp 50.000.000).
        `;
      } else if (isDuplicated) {
        statusBanner.className = 'clean-callout callout-red';
        statusBanner.innerHTML = `
          <strong>STATUS: KESALAHAN DUPLIKASI TRANSAKSI AKTIF!</strong><br>
          Pembayaran utang Rp 3.000.000 tercatat 2 kali. Akibatnya Kas berkurang menjadi Rp 27.500.000 (defisit Rp 3.000.000) dan Utang Usaha tersisa Rp 2.000.000 padahal seharusnya Rp 5.000.000.
        `;
      } else {
        statusBanner.className = 'clean-callout callout-blue';
        statusBanner.innerHTML = `
          <strong>STATUS: NORMAL (SESUAI SKENARIO).</strong> Seluruh 5 transaksi tercatat dengan benar. Total Kas Rp 30.500.000 dan Neraca Saldo Seimbang (Total Debit Rp 47.000.000 = Total Kredit Rp 47.000.000).
        `;
      }
    }
  }

  if (btnDuplicateTrx) {
    btnDuplicateTrx.addEventListener('click', () => {
      if (isDuplicated) {
        alert('Transaksi sudah dalam kondisi terduplikasi.');
        return;
      }
      isDuplicated = true;
      isCorrected = false;

      transactions.push({
        id: "TRX-02-DUP",
        desc: "[KESALAHAN DUPLIKASI] Pembayaran utang pemasok yang sama tercatat kembali",
        amount: 3000000,
        debitAccount: "2101",
        creditAccount: "1101",
        reason: "Kesalahan pengguna: Mengklik tombol bayar dua kali tanpa validasi nomor voucher."
      });

      calculateFinancials();
    });
  }

  if (btnCorrectTrx) {
    btnCorrectTrx.addEventListener('click', () => {
      if (!isDuplicated) {
        alert('Silakan simulasikan duplikasi transaksi terlebih dahulu.');
        return;
      }
      if (isCorrected) {
        alert('Koreksi sudah diterapkan.');
        return;
      }

      isCorrected = true;
      transactions.push({
        id: "CORR-01",
        desc: "[JURNAL PEMBALIK / KOREKSI] Pembatalan transaksi duplikasi TRX-02-DUP",
        amount: 3000000,
        debitAccount: "1101",
        creditAccount: "2101",
        reason: "Jurnal koreksi resmi: Mengembalikan Kas (Dr Kas) dan memulihkan Utang Usaha (Cr Utang Usaha) dengan ref audit TRX-02-DUP."
      });

      calculateFinancials();
    });
  }

  if (btnResetTrx) {
    btnResetTrx.addEventListener('click', () => {
      transactions = JSON.parse(JSON.stringify(erpData.p4.standardTransactions));
      isDuplicated = false;
      isCorrected = false;
      calculateFinancials();
    });
  }

  apiGet('p4').then(d => {
    if (d && d.ok && d.transactions && d.transactions.length) {
      transactions = d.transactions;
      isDuplicated = d.isDuplicated;
      isCorrected = d.isCorrected;
    }
    calculateFinancials();
  }).catch(() => {
    calculateFinancials();
  });
}

// ==========================================================================
// 9. PRAKTIKUM 5: SCM & MATERIAL REQUIREMENT PLANNING (MRP)
// ==========================================================================
function initPraktikum5() {
  const prodQtyInput = document.getElementById('p5-prod-qty');
  const targetDaysInput = document.getElementById('p5-target-days');
  const btnCalcMRP = document.getElementById('p5-btn-calc-mrp');

  function runMRP() {
    const plannedUnits = parseInt(prodQtyInput ? prodQtyInput.value : 300, 10) || 300;
    const deadlineDays = parseInt(targetDaysInput ? targetDaysInput.value : 6, 10) || 6;

    const mrpTableBody = document.getElementById('p5-mrp-table-body');
    if (!mrpTableBody) return;

    let rowsHtml = '';
    erpData.p5.bom.forEach(b => {
      const grossReq = plannedUnits * b.ratioPerUnit;
      const totalAvailable = b.currentStock + b.onOrderStock;
      const netReq = Math.max(0, grossReq - totalAvailable);
      const isLate = b.leadTimeDays > deadlineDays;

      rowsHtml += `
        <tr>
          <td><strong class="font-mono" style="color:var(--brand-primary);">${b.itemCode}</strong></td>
          <td><strong>${b.name}</strong></td>
          <td class="text-center font-mono">${b.ratioPerUnit} ${b.uom}</td>
          <td class="text-right font-mono" style="font-weight:700;">${grossReq}</td>
          <td class="text-right font-mono">${b.currentStock}</td>
          <td class="text-right font-mono" style="color:var(--brand-primary);">${b.onOrderStock}</td>
          <td class="text-right font-mono" style="font-weight:800; color:${netReq > 0 ? '#b91c1c' : '#059669'};">${netReq}</td>
          <td class="text-center font-mono">
            ${b.leadTimeDays} Hari Kerja 
            ${isLate ? '<span class="tag tag-red">BOTTLENECK ⚠️</span>' : '<span class="tag tag-green">OK ✓</span>'}
          </td>
          <td>
            ${netReq > 0 
              ? `<span class="tag tag-amber">Rilis PO: ${netReq} ${b.uom}</span>` 
              : `<span class="tag tag-green">Stok Cukup</span>`}
          </td>
        </tr>
      `;
    });

    mrpTableBody.innerHTML = rowsHtml;

    const rows5 = erpData.p5.bom.map(b => {
      const gross = plannedUnits * b.ratioPerUnit, net = Math.max(0, gross - b.currentStock - b.onOrderStock);
      return { b, gross, net, telat: b.leadTimeDays - deadlineDays };
    });

    const mrpConclusion = document.getElementById('p5-mrp-conclusion');
    if (mrpConclusion) {
      mrpConclusion.innerHTML = `
        <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:14px;">
          <strong style="font-size:0.9rem; color:var(--text-main); display:block; margin-bottom:6px;">
            📊 Hasil Analisis Lead Time Pengadaan vs Deadline (${deadlineDays} Hari Kerja):
          </strong>
          <ul style="font-size:0.84rem; color:var(--text-muted); padding-left:18px; line-height:1.6;">
            <li><strong>Bahan Baku A:</strong> Kebutuhan bersih 400 unit. Waktu pengadaan 4 hari kerja <= ${deadlineDays} hari deadline. <strong>Pesanan selesai tepat waktu</strong> jika PO diterbitkan pada Hari 1.</li>
            <li><strong style="color:#b91c1c;">Bahan Baku B (Bottleneck):</strong> Kebutuhan bersih 350 unit. Waktu pengadaan 7 hari kerja > ${deadlineDays} hari deadline. <strong>TERLAMBAT 1 HARI</strong> bila melalui jalur normal!</li>
            <li><strong>Asumsi Pesanan Terjadwal (On Order 100 Bahan A):</strong> Dijadwalkan tiba hari ke-4, sehingga langsung dapat dipakai sebelum perakitan hari ke-6.</li>
          </ul>
        </div>
      `;
    }

    const prBox = document.getElementById('p5-pr-box');
    if (prBox) {
      prBox.innerHTML = '<table class="clean-table"><thead><tr><th>No PR</th><th>Bahan</th><th>Qty</th><th>Pemasok</th><th>Estimasi Nilai</th><th>Harus Tiba</th><th>Status</th></tr></thead><tbody>' +
        rows5.map((r, i) => r.net > 0 ? `<tr><td class="font-mono">PR-2026-00${i + 1}</td><td>${r.b.itemCode} ${r.b.name}</td><td class="text-right font-mono">${r.net} ${r.b.uom}</td><td>${r.b.supplierName}</td><td class="text-right font-mono">${formatIDR(r.net * r.b.unitPrice)}</td><td>Hari ke-${deadlineDays}</td><td>${r.telat > 0 ? '<span class="tag tag-red">Lead time melebihi deadline - perlu percepatan</span>' : '<span class="tag tag-green">Siap diproses jadi PO</span>'}</td></tr>` : '').join('') + '</tbody></table>';
    }

    // Log ke server database jika online
    apiPost('mrp', {
      output: plannedUnits,
      deadline: deadlineDays,
      brutoA: plannedUnits * 3,
      netA: Math.max(0, (plannedUnits * 3) - 500),
      brutoB: plannedUnits * 2,
      netB: Math.max(0, (plannedUnits * 2) - 250),
      statusBottleneck: deadlineDays < 7 ? 'Bottleneck Bahan B (7 Hari)' : 'Aman'
    });
  }

  if (btnCalcMRP) {
    btnCalcMRP.addEventListener('click', runMRP);
  }

  // Partial Goods Receipt
  const btnReceivePartial = document.getElementById('p5-btn-receive-partial');
  const grnLog = document.getElementById('p5-grn-log');

  if (btnReceivePartial && grnLog) {
    btnReceivePartial.addEventListener('click', () => {
      const receiveQty = parseInt(document.getElementById('p5-receive-qty').value, 10) || 200;
      grnLog.style.display = 'block';
      const poQty = 400;
      const qtyIn = Math.min(Math.max(receiveQty, 1), poQty);
      const sisa = poQty - qtyIn;

      apiPost('grn', {
        po: 'PO-MAT-A-01',
        material: 'MAT-A',
        qtyPo: poQty,
        qty: qtyIn,
        sisa: sisa,
        status: sisa > 0 ? 'PARTIALLY RECEIVED' : 'FULLY RECEIVED',
        qc: 'Lolos QC Inspection'
      });

      grnLog.innerHTML = `
[GUDANG RECEIVING] Memproses Surat Jalan Pemasok #SJ-8891...
[BARCODE SCAN] ${qtyIn} Unit Bahan Baku A (Aluminium Billet AL-6061) lolos Quality Inspection.
[ERP UPDATE] Status PO #PO-MAT-A-01 berubah menjadi: '${sisa > 0 ? 'PARTIALLY RECEIVED (' + qtyIn + '/400 Unit)' : 'FULLY RECEIVED'}' (Sisa: ${sisa} Unit).
[MUTASI STOK] Stok Fisik Bahan A di Gudang bertambah dari 400 -> ${400 + qtyIn} Unit.
[FINANCE INTEGRATION] Sistem mencatat Goods Receipt / Invoice Receipt (GR/IR Clearing) sebesar ${formatIDR(qtyIn * 45000)}.
[SIAP PRODUKSI] Bahan ${qtyIn} unit segera dialokasikan untuk Work Order Batch 1.
      `;
    });
  }

  // Shock Scenario Options
  const shockContainer = document.getElementById('p5-shock-options-container');
  if (shockContainer) {
    shockContainer.innerHTML = erpData.p5.shockScenario.options.map(opt => `
      <div style="background:#ffffff; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:14px; margin-bottom:10px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
          <strong style="font-size:0.92rem; color:var(--text-main);">${opt.name}</strong>
          <span class="tag ${opt.feasible ? 'tag-green' : 'tag-red'}">${opt.feasible ? 'Direkomendasikan' : 'Ditolak'}</span>
        </div>
        <div style="display:flex; gap:14px; font-size:0.78rem; color:var(--text-muted); margin-bottom:6px;">
          <span>⏱️ Lead Time: <strong style="color:var(--text-main);">${opt.leadTime}</strong></span>
          <span>💰 Biaya Tambahan: <strong style="color:var(--text-main);">${opt.extraCost}</strong></span>
          <span>⚡ Risiko: <strong style="color:${opt.delayRisk.includes('Tinggi') ? '#b91c1c' : '#047857'};">${opt.delayRisk}</strong></span>
        </div>
        <p style="font-size:0.83rem; color:var(--text-muted); line-height:1.5;">${opt.description}</p>
      </div>
    `).join('');
  }

  runMRP();
}
