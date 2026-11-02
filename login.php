<?php
session_name('ERPSESS');
session_start();
if (!empty($_SESSION['user'])) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk | META ERP Portal</title>
<link rel="stylesheet" href="fonts/fonts.css">
<style>
  :root { --primary:#3b82f6; --primary-dark:#1d4ed8; --text:#1e293b; --muted:#64748b; --border:#e2e8f0; --bg:#f8fafc; --card:#fff; --danger:#b91c1c; --danger-bg:#fef2f2; }
  @media (prefers-color-scheme: dark) { :root { --text:#e2e8f0; --muted:#94a3b8; --border:#334155; --bg:#0f172a; --card:#1e293b; --danger:#fca5a5; --danger-bg:#450a0a; } }
  * { box-sizing:border-box; margin:0; }
  body { font-family:'Plus Jakarta Sans',-apple-system,'Segoe UI',Roboto,sans-serif; background:var(--bg); color:var(--text); min-height:100vh; display:grid; place-items:center; padding:20px; }
  .box { width:100%; max-width:440px; background:var(--card); border:1px solid var(--border); border-radius:16px; padding:32px 28px; box-shadow:0 10px 30px rgba(0,0,0,.08); }
  .logo { width:48px; height:48px; border-radius:12px; background:var(--primary); color:#fff; display:grid; place-items:center; margin-bottom:16px; }
  h1 { font-size:1.35rem; } .sub { color:var(--muted); font-size:.85rem; margin:4px 0 22px; }
  label { display:block; font-size:.8rem; font-weight:600; margin-bottom:6px; }
  .field { margin-bottom:16px; position:relative; }
  input { width:100%; padding:11px 12px; border:1px solid var(--border); border-radius:10px; background:transparent; color:var(--text); font:inherit; font-size:.92rem; }
  input:focus { outline:2px solid var(--primary); outline-offset:1px; border-color:var(--primary); }
  .toggle { position:absolute; right:8px; top:30px; background:none; border:0; color:var(--muted); cursor:pointer; font-size:.78rem; padding:4px 6px; }
  button.go { width:100%; padding:12px; border:0; border-radius:10px; background:var(--primary); color:#fff; font:inherit; font-weight:700; cursor:pointer; }
  button.go:hover { background:var(--primary-dark); } button.go:disabled { opacity:.6; cursor:wait; }
  .err { display:none; background:var(--danger-bg); color:var(--danger); border-radius:10px; padding:10px 12px; font-size:.83rem; margin-bottom:16px; }
  .foot { text-align:center; color:var(--muted); font-size:.74rem; margin-top:20px; }
  .demo { margin-top:22px; border-top:1px dashed var(--border); padding-top:18px; }
  .demo h2 { font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color:var(--muted); margin-bottom:4px; }
  .demo p { font-size:.76rem; color:var(--muted); margin-bottom:12px; }
  .demo-list { display:grid; gap:8px; max-height:300px; overflow-y:auto; padding-right:2px; }
  .demo-item { display:flex; align-items:center; gap:10px; width:100%; text-align:left; background:transparent; border:1px solid var(--border); border-radius:10px; padding:8px 10px; cursor:pointer; font:inherit; color:var(--text); transition:border-color .15s, background .15s; }
  .demo-item:hover, .demo-item:focus-visible { border-color:var(--primary); background:rgba(59,130,246,.08); outline:none; }
  .demo-item.sel { border-color:var(--primary); background:rgba(59,130,246,.12); }
  .demo-av { font-size:1.15rem; width:34px; height:34px; flex:0 0 34px; display:grid; place-items:center; border-radius:50%; background:rgba(100,116,139,.15); }
  .demo-info { flex:1; min-width:0; }
  .demo-info b { display:block; font-size:.82rem; }
  .demo-info small { display:block; font-size:.72rem; color:var(--muted); }
  .demo-cred { font-family:ui-monospace,Menlo,Consolas,monospace; font-size:.7rem; color:var(--muted); text-align:right; line-height:1.35; white-space:nowrap; }
  .demo-cred span { color:var(--text); font-weight:600; }
</style>
</head>
<body>
  <main class="box">
    <div class="logo"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L3 7v6c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7l-9-5z"/><path d="M12 8v8M8 12h8"/></svg></div>
    <h1>Masuk ke META ERP</h1>
    <p class="sub">Politeknik META Industri • TRPL PL/4008</p>
    <div id="err" class="err" role="alert"></div>
    <form id="f" autocomplete="on">
      <div class="field"><label for="u">Username</label><input id="u" name="username" autocomplete="username" required autofocus></div>
      <div class="field"><label for="p">Password</label><input id="p" name="password" type="password" autocomplete="current-password" required><button type="button" class="toggle" id="t">Tampilkan</button></div>
      <button class="go" id="b" type="submit">Masuk</button>
    </form>
    <section class="demo" aria-labelledby="demo-title">
      <h2 id="demo-title">Akun Demo</h2>
      <p>Klik salah satu akun untuk mengisi username &amp; password otomatis.</p>
      <div class="demo-list" id="demo-list"></div>
    </section>
    <p class="foot">Lupa sandi? Hubungi administrator sistem.</p>
  </main>
<script>
  const err = document.getElementById('err'), btn = document.getElementById('b');
  const DEMO = [
    ['👑','admin','admin123','Administrator Utama','Super Administrator ERP'],
    ['🎓','adie.kusna','dosen123','Adie Kusna Wibowo','Dosen Pengampu'],
    ['⭐','yazid','meta2026','Yazid','Mahasiswa Praktikan'],
    ['💼','sales.andi','sales123','Andi Pratama','Staff Penjualan'],
    ['🛠️','it.budi','it123','Budi Santoso','IT System Administrator'],
    ['📋','proc.citra','proc123','Citra Lestari','Procurement Officer'],
    ['💰','fin.dewi','fin123','Dewi Anggraini','Staff Akuntansi & Keuangan'],
    ['📦','wh.eko','wh123','Eko Saputra','Staff Gudang & Logistik']
  ];
  const list = document.getElementById('demo-list');
  DEMO.forEach(([av, u, p, nama, peran]) => {
    const b = document.createElement('button');
    b.type = 'button'; b.className = 'demo-item';
    const a = document.createElement('span'); a.className = 'demo-av'; a.textContent = av;
    const i = document.createElement('span'); i.className = 'demo-info';
    const n = document.createElement('b'); n.textContent = nama;
    const r = document.createElement('small'); r.textContent = peran;
    i.append(n, r);
    const c = document.createElement('span'); c.className = 'demo-cred';
    c.innerHTML = 'user: <span></span><br>pass: <span></span>';
    c.querySelectorAll('span')[0].textContent = u; c.querySelectorAll('span')[1].textContent = p;
    b.append(a, i, c);
    b.onclick = () => {
      document.getElementById('u').value = u;
      const pw = document.getElementById('p'); pw.value = p;
      list.querySelectorAll('.demo-item').forEach(x => x.classList.remove('sel'));
      b.classList.add('sel'); err.style.display = 'none';
      document.getElementById('b').focus();
    };
    list.appendChild(b);
  });
  const show = m => { err.textContent = m; err.style.display = 'block'; };
  fetch('api/api.php?r=me', { credentials: 'same-origin' }).then(r => r.ok ? r.json() : null).then(d => { if (d && d.ok) location.replace('index.php'); }).catch(() => {});
  document.getElementById('t').onclick = e => { const p = document.getElementById('p'); const h = p.type === 'password'; p.type = h ? 'text' : 'password'; e.target.textContent = h ? 'Sembunyikan' : 'Tampilkan'; };
  document.getElementById('f').addEventListener('submit', async e => {
    e.preventDefault(); err.style.display = 'none'; btn.disabled = true; btn.textContent = 'Memeriksa...';
    try {
      const r = await fetch('api/api.php?r=login', { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username: document.getElementById('u').value.trim(), password: document.getElementById('p').value }) });
      let d = null; try { d = await r.json(); } catch (x) {}
      if (r.ok && d && d.ok) { location.replace('index.php'); return; }
      show(d && d.error ? d.error : 'Server tidak merespons dengan benar. Pastikan PHP dan database aktif.');
    } catch (x) { show('Tidak dapat menghubungi server. Pastikan situs dibuka lewat hosting PHP, bukan file lokal.'); }
    btn.disabled = false; btn.textContent = 'Masuk';
  });
</script>
</body>
</html>
