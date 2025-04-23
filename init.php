<?php
$sessionPath = __DIR__ . '/.phpsessions';

// Debug - affiche le chemin pour vérification
var_dump('Session path: ' . $sessionPath);

if (!file_exists($sessionPath)) {
    if (!mkdir($sessionPath, 0777, true)) {
        die('Failed to create sessions directory');
    }
}

ini_set('session.save_path', $sessionPath);
ini_set('session.save_handler', 'files');
session_start();

// Test session
$_SESSION['debug_test'] = 'test_' . time();