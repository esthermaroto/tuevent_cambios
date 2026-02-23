<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Limpiar Caché CSS</title>
</head>
<body>
    <h1>Limpieza de Caché</h1>
    <?php
    // Agregar timestamp al CSS para forzar recarga
    $timestamp = time();
    echo "<p>Timestamp actual: " . $timestamp . "</p>";
    echo "<p>Agrega este parámetro a tu archivo CSS:</p>";
    echo "<code>css/style.css?v=" . $timestamp . "</code>";
    ?>
    
    <h2>Verificación de archivos:</h2>
    <?php
    $files = [
        'css/style.css',
        'includes/header.html',
        'js/load-common.js'
    ];
    
    foreach ($files as $file) {
        if (file_exists($file)) {
            $size = filesize($file);
            $modified = date("Y-m-d H:i:s", filemtime($file));
            echo "<p>✓ $file - Tamaño: $size bytes - Modificado: $modified</p>";
        } else {
            echo "<p>✗ $file - NO ENCONTRADO</p>";
        }
    }
    ?>
</body>
</html>
