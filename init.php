<?php
$sessionPath = __DIR__ . '/.phpsessions';

// Configuration renforcée des sessions
ini_set('session.save_path', $sessionPath);
ini_set('session.name', 'MONSITE_SESSID');
ini_set('session.cookie_lifetime', 86400); // 1 jour
ini_set('session.gc_maxlifetime', 86400); // 1 jour
ini_set('session.cookie_secure', isset($_SERVER['HTTPS'])); // Secure en HTTPS
ini_set('session.cookie_httponly', true);
ini_set('session.use_strict_mode', true);
ini_set('session.cookie_samesite', 'Lax'); // Protection CSRF

if (!file_exists($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}

session_start();