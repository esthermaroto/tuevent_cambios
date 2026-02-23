<?php
// db_setup.php
require_once 'includes/db.php';

try {
    // Tabla de usuarios
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id SERIAL PRIMARY KEY,
        usuario VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Tabla de blog
    $pdo->exec("CREATE TABLE IF NOT EXISTS blog_posts (
        id SERIAL PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        contenido TEXT NOT NULL,
        imagen VARCHAR(255),
        fecha_publicacion DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    echo "Tablas creadas correctamente.<br>";

    // Crear usuario daniel si no existe
    $usuario = 'daniel';
    $password = password_hash('cabello2026', PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
        $stmt->execute([$usuario, $password]);
        echo "Usuario 'daniel' creado correctamente.<br>";
    } else {
        echo "El usuario 'daniel' ya existe.<br>";
    }

} catch (PDOException $e) {
    die("Error al configurar la base de datos: " . $e->getMessage());
}
?>
