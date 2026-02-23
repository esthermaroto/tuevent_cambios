<?php
// config/db.php

// Load environment variables
$envCtx = __DIR__ . '/../.env';
if (file_exists($envCtx)) {
    $env = parse_ini_file($envCtx);
} else {
    // Fallback or error
    $env = [];
}

define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASS', $env['DB_PASS']);
define('DB_CHARSET', 'utf8mb4');

// Handle port in host if present
$hostParts = explode(':', DB_HOST);
$host = $hostParts[0];
$port = $hostParts[1] ?? '3306';

$dsn = "mysql:host=$host;port=$port;dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    error_log($e->getMessage());
    die("Error de conexión a la base de datos.");
}

