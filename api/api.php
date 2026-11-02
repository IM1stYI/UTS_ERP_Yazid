<?php
/**
 * META ERP Enterprise Suite - RESTful API Gateway (P1 - P5 & Akun Demo)
 * Politeknik META Industri Cikarang
 */

require_once __DIR__ . '/config.php';

session_name('ERPSESS');
session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$r = $_GET['r'] ?? '';
$isPost = $method === 'POST';
$input = json_decode(file_get_contents('php://input'), true) ?? [];


// -----------------------------------------------------------------------------
// Sesi login: me / logout tanpa DB, semua endpoint lain wajib login
// -----------------------------------------------------------------------------
if ($r === 'me') {
    echo json_encode(empty($_SESSION['user']) ? ['ok' => false] : ['ok' => true, 'user' => $_SESSION['user']]);
    exit;
}
if ($r === 'logout') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) { $c = session_get_cookie_params(); setcookie(session_name(), '', time() - 3600, $c['path'], $c['domain'], $c['secure'], $c['httponly']); }
    session_destroy();
    echo json_encode(['ok' => true]);
    exit;
}
if ($r !== 'login' && empty($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Belum login']);
    exit;
}

// -----------------------------------------------------------------------------
// Endpoint Status / Check Koneksi (Tidak boleh melempar 500 fatal jika DB mati)
// -----------------------------------------------------------------------------
if ($r === 'status' || $r === 'check') {
    try {
        $pdo = db();
        $counts = [];
        $tables = ['akun', 'p1_sales_order', 'p2_rbac', 'p3_pengadaan', 'p4_jurnal', 'p5_material'];
        foreach ($tables as $tbl) {
            try {
                $c = $pdo->query("SELECT COUNT(*) as c FROM $tbl")->fetch()['c'] ?? 0;
                $counts[$tbl] = (int)$c;
            } catch (Throwable $e) {
                $counts[$tbl] = 0;
            }
        }
        echo json_encode([
            'ok' => true,
            'database' => 'connected',
            'db_name' => DB_NAME,
            'tables' => $counts,
            'message' => 'Database MySQL terhubung dan aktif.'
        ]);
    } catch (Throwable $e) {
        echo json_encode([
            'ok' => false,
            'database' => 'disconnected',
            'error' => $e->getMessage(),
            'message' => 'Database belum terhubung. Sistem menggunakan mode demo lokal.'
        ]);
    }
    exit;
}

// -----------------------------------------------------------------------------
// Endpoint Utama Memerlukan Koneksi DB
// -----------------------------------------------------------------------------
try {
    $pdo = db();

    // 0. AKUN & DEMO LOGIN
    if ($r === 'accounts') {
        $rows = $pdo->query('SELECT id, username, nama_lengkap, peran, departemen, avatar FROM akun ORDER BY id ASC')->fetchAll();
        echo json_encode(['ok' => true, 'accounts' => $rows]);
    } elseif ($r === 'login' && $isPost) {
        $username = trim($input['username'] ?? '');
        $password = (string)($input['password'] ?? '');

        $stmt = $pdo->prepare('SELECT id, username, password, nama_lengkap, peran, departemen, avatar FROM akun WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        $ok = false;
        if ($user) {
            $hash = $user['password'];
            if (preg_match('/^\$2[aby]\$/', $hash)) {
                $ok = password_verify($password, $hash);
            } elseif (hash_equals($hash, $password)) { // sandi lama (teks biasa): terima sekali lalu ubah jadi hash
                $ok = true;
                $pdo->prepare('UPDATE akun SET password = ? WHERE id = ?')->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
            }
        }

        if ($ok) {
            unset($user['password']);
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            echo json_encode(['ok' => true, 'user' => $user]);
        } else {
            usleep(600000); // perlambat tebakan sandi
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'Username atau password salah']);
        }
    }

    // 1. PRAKTIKUM 1 (SALES ORDER & SO LOGS)
    elseif ($r === 'so' || $r === 'p1_so') {
        if ($isPost) {
            $no_so = $input['no_so'] ?? ('SO-' . date('Ymd-His'));
            $st = $pdo->prepare('INSERT INTO p1_sales_order (no_so, pelanggan, produk, qty, nilai, status, catatan_kredit) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $st->execute([
                $no_so,
                $input['pelanggan'] ?? 'Pelanggan Umum',
                $input['produk'] ?? 'Produk Komponen',
                (int)($input['qty'] ?? 1),
                (int)($input['nilai'] ?? 0),
                $input['status'] ?? 'APPROVED',
                $input['catatan_kredit'] ?? ''
            ]);
            echo json_encode(['ok' => true, 'no_so' => $no_so, 'id' => $pdo->lastInsertId()]);
        } else {
            $rows = $pdo->query('SELECT * FROM p1_sales_order ORDER BY id DESC LIMIT 15')->fetchAll();
            echo json_encode(['ok' => true, 'sales_orders' => $rows]);
        }
    }

    // 2. PRAKTIKUM 2 (CHAOS FAILOVER LOGS)
    elseif ($r === 'chaos' || $r === 'p2_chaos') {
        if ($isPost) {
            $pdo->prepare('INSERT INTO p2_chaos_logs (skenario_kode, nama_skenario, kategori, dampak, status_mitigasi) VALUES (?, ?, ?, ?, ?)')
                ->execute([
                    $input['kode'] ?? 'DS-TEST',
                    $input['nama'] ?? 'Simulasi Uji Gangguan',
                    $input['kategori'] ?? 'Infrastruktur',
                    $input['dampak'] ?? 'Failover terpicu',
                    $input['status'] ?? 'Mitigated Otomatis'
                ]);
            echo json_encode(['ok' => true]);
        } else {
            $rows = $pdo->query('SELECT * FROM p2_chaos_logs ORDER BY waktu_uji DESC LIMIT 10')->fetchAll();
            echo json_encode(['ok' => true, 'chaos_logs' => $rows]);
        }
    }

    // 3. PRAKTIKUM 3 (PENGADAAN & APPROVAL)
    elseif ($r === 'pr' || $r === 'p3_pr') {
        if ($isPost) {
            $no_pr = $input['no_pr'] ?? ('PR-' . date('Ymd-His'));
            $pdo->prepare('INSERT INTO p3_pengadaan (no_pr, pemohon, departemen, item_barang, nominal, kategori_urgensi, level_approval, status, disetujui_oleh, catatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')
                ->execute([
                    $no_pr,
                    $input['pemohon'] ?? 'Staff Pengadaan',
                    $input['departemen'] ?? 'Lab Manufaktur',
                    $input['item'] ?? 'Barang Pengadaan',
                    (int)($input['nominal'] ?? 0),
                    $input['urgensi'] ?? 'Normal',
                    $input['level'] ?? 'Level 1: Rutin',
                    $input['status'] ?? 'APPROVED',
                    $input['disetujui_oleh'] ?? 'Kepala Lab',
                    $input['catatan'] ?? ''
                ]);
            echo json_encode(['ok' => true, 'no_pr' => $no_pr]);
        } else {
            $rows = $pdo->query('SELECT * FROM p3_pengadaan ORDER BY id DESC LIMIT 15')->fetchAll();
            echo json_encode(['ok' => true, 'procurements' => $rows]);
        }
    }

    // 4. PRAKTIKUM 4 (JURNAL KEUANGAN & AUDIT TRAIL)
    elseif ($r === 'p4') {
        if ($isPost) {
            $pdo->beginTransaction();
            $pdo->exec('DELETE FROM p4_jurnal');
            $st = $pdo->prepare('INSERT INTO p4_jurnal (id_trx, urut, deskripsi, jumlah, akun_debit, akun_kredit, alasan) VALUES (?, ?, ?, ?, ?, ?, ?)');
            foreach (($input['transactions'] ?? []) as $i => $t) {
                $st->execute([
                    $t['id'],
                    $i,
                    $t['desc'],
                    (int)$t['amount'],
                    $t['debitAccount'],
                    $t['creditAccount'],
                    $t['reason'] ?? ''
                ]);
            }
            $pdo->prepare('INSERT INTO p4_status (id, is_duplicated, is_corrected) VALUES (1, ?, ?) ON DUPLICATE KEY UPDATE is_duplicated = VALUES(is_duplicated), is_corrected = VALUES(is_corrected)')
                ->execute([(int)!empty($input['isDuplicated']), (int)!empty($input['isCorrected'])]);
            $pdo->commit();
            echo json_encode(['ok' => true]);
        } else {
            $rows = $pdo->query('SELECT id_trx id, deskripsi `desc`, jumlah amount, akun_debit debitAccount, akun_kredit creditAccount, alasan reason FROM p4_jurnal ORDER BY urut')->fetchAll();
            foreach ($rows as &$x) {
                $x['amount'] = (int)$x['amount'];
            }
            $s = $pdo->query('SELECT * FROM p4_status WHERE id=1')->fetch() ?: ['is_duplicated' => 0, 'is_corrected' => 0];
            echo json_encode([
                'ok' => true,
                'transactions' => $rows,
                'isDuplicated' => (bool)$s['is_duplicated'],
                'isCorrected' => (bool)$s['is_corrected']
            ]);
        }
    }

    // 5. PRAKTIKUM 5 (MATERIAL, GRN, & MRP LOG)
    elseif ($r === 'material' || $r === 'p5_material') {
        $rows = $pdo->query('SELECT * FROM p5_material')->fetchAll();
        echo json_encode(['ok' => true, 'materials' => $rows]);
    } elseif ($r === 'grn' || $r === 'p5_grn') {
        if ($isPost) {
            $qty = (int)($input['qty'] ?? 200);
            $mat = $input['material'] ?? 'MAT-A';
            $pdo->prepare('INSERT INTO p5_grn (po_no, kode_material, qty_po, qty_diterima, sisa, status, catatan_qc) VALUES (?, ?, ?, ?, ?, ?, ?)')
                ->execute([
                    $input['po'] ?? 'PO-MAT-A-01',
                    $mat,
                    (int)($input['qtyPo'] ?? 400),
                    $qty,
                    (int)($input['sisa'] ?? 200),
                    $input['status'] ?? 'PARTIALLY RECEIVED',
                    $input['qc'] ?? 'Lolos QC Inspection'
                ]);
            // Update penambahan stok fisik di gudang
            $pdo->prepare('UPDATE p5_material SET stok = stok + ? WHERE kode = ?')->execute([$qty, $mat]);
            echo json_encode(['ok' => true]);
        } else {
            $rows = $pdo->query('SELECT * FROM p5_grn ORDER BY id DESC LIMIT 10')->fetchAll();
            echo json_encode(['ok' => true, 'grn_list' => $rows]);
        }
    } elseif ($r === 'mrp' || $r === 'p5_mrp') {
        if ($isPost) {
            $pdo->prepare('INSERT INTO p5_mrp_log (rencana_output, deadline_hari, kebutuhan_bruto_a, kebutuhan_bersih_a, kebutuhan_bruto_b, kebutuhan_bersih_b, status_bottleneck) VALUES (?, ?, ?, ?, ?, ?, ?)')
                ->execute([
                    (int)($input['output'] ?? 300),
                    (int)($input['deadline'] ?? 6),
                    (int)($input['brutoA'] ?? 900),
                    (int)($input['netA'] ?? 400),
                    (int)($input['brutoB'] ?? 600),
                    (int)($input['netB'] ?? 350),
                    $input['statusBottleneck'] ?? 'Bahan B Bottleneck'
                ]);
            echo json_encode(['ok' => true]);
        } else {
            $rows = $pdo->query('SELECT * FROM p5_mrp_log ORDER BY id DESC LIMIT 5')->fetchAll();
            echo json_encode(['ok' => true, 'mrp_logs' => $rows]);
        }
    } else {
        http_response_code(404);
        echo json_encode(['ok' => false, 'error' => 'Endpoint API tidak dikenal']);
    }
} catch (Throwable $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'Kesalahan database: ' . $e->getMessage()
    ]);
}
