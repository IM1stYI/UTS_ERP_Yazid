<?php
/**
 * META ERP Enterprise Suite - Konfigurasi Database MySQL
 * Mendukung cPanel (Hosting Live) dan Localhost (XAMPP / Laragon)
 */

// Kredensial MySQL Utama (Sesuaikan DB_PASS jika user cPanel memiliki password)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'pagitrpl_ERPyazid');
define('DB_USER', getenv('DB_USER') ?: 'pagitrpl_yazid_sisir');
define('DB_PASS', getenv('DB_PASS') ?: 'cGF24naXR^y%cGw');

// Kredensial Alternatif / Fallback untuk XAMPP Lokal
const FALLBACK_DB_NAME = 'erp_praktikum';
const FALLBACK_DB_USER = 'root';
const FALLBACK_DB_PASS = '';

/**
 * Mendapatkan koneksi PDO MySQL dengan fallback otomatis
 */
function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 3
    ];

    // 1. Coba koneksi cPanel / kredensial utama
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (Throwable $e1) {
        // 2. Coba kredensial cPanel dengan user root (jika diuji di VPS atau MySQL lokal)
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', 'root', '', $options);
            return $pdo;
        } catch (Throwable $e2) {
            // 3. Coba database lokal 'erp_praktikum'
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=' . FALLBACK_DB_NAME . ';charset=utf8mb4', FALLBACK_DB_USER, FALLBACK_DB_PASS, $options);
                return $pdo;
            } catch (Throwable $e3) {
                // Lempar pesan error jelas dan bersahabat
                throw new Exception("Koneksi MySQL Gagal: Tidak dapat menghubungi database '" . DB_NAME . "' atau '" . FALLBACK_DB_NAME . "'. Pastikan database sudah di-import di phpMyAdmin.");
            }
        }
    }
}
