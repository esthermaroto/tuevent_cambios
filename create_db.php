<?php
// create_db.php

// Load environment variables from .env
$envCtx = __DIR__ . '/.env';
if (file_exists($envCtx)) {
    $env = parse_ini_file($envCtx);
} else {
    die("Error: No se encontró el archivo .env\n");
}

$db_host = $env['DB_HOST'] ?? 'localhost:3306';
$db_user = $env['DB_USER'] ?? 'root';
$db_pass = $env['DB_PASS'] ?? '';
$db_name = $env['DB_NAME'] ?? 'tuevent';

// Handle port in host if present
$hostParts = explode(':', $db_host);
$host = $hostParts[0];
$port = $hostParts[1] ?? '3306';

// Connect to MySQL server (without specifying a database)
$dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    echo "Conectando al servidor de base de datos en $host:$port...\n";
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    
    echo "Creando base de datos '$db_name' si no existe...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "Base de datos '$db_name' creada o ya existente con éxito.\n";
} catch (\PDOException $e) {
    echo "ERROR al crear la base de datos: " . $e->getMessage() . "\n";
    
    // Attempt local fallback if 'despliegues_mysql' fails
    if (strpos($e->getMessage(), 'php_network_getaddresses') !== false && $host !== 'localhost' && $host !== '127.0.0.1') {
        echo "Intentando conectar usando 'localhost' como fallback...\n";
        try {
            $dsn_local = "mysql:host=localhost;port=3306;charset=utf8mb4";
            $pdo_local = new PDO($dsn_local, $db_user, $db_pass, $options);
            $pdo_local->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "Base de datos '$db_name' creada con éxito usando 'localhost'.\n";
        } catch (\PDOException $e_local) {
            echo "ERROR persistente incluso con localhost: " . $e_local->getMessage() . "\n";
            exit(1);
        }
    } else {
        exit(1);
    }
}
