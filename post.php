<?php
require_once 'includes/db.php';

// Obtener el id de la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    // Si no hay id, redirigir al blog principal
    header("Location: blog_tuevent.php");
    exit;
}

try {
    // Obtener el post correspondiente
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        // Post no encontrado (404)
        $post = null;
    }
} catch (Exception $e) {
    $post = null;
}

$header = file_get_contents('includes/header.html');
$footer = file_get_contents('includes/footer.html');

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post ? htmlspecialchars($post['titulo']) . ' - Tuevent' : 'Post no encontrado'; ?></title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body style="background-color: #fff;">
    <?php echo $header; ?>

    <main class="single-post-container">
        <?php if ($post): ?>

            <header class="single-post-header">
                <h1 class="single-post-title"><?php echo htmlspecialchars($post['titulo']); ?></h1>
                <?php
                // Formateamos la fecha a español como en la web
                setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
                $fecha_timestamp = strtotime($post['fecha_publicacion']);
                $dia = date('j', $fecha_timestamp);
                $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                $mes = $meses[date('n', $fecha_timestamp) - 1];
                $anio = date('Y', $fecha_timestamp);
                $fecha_es = "$dia de $mes de $anio";
                ?>
                <div class="single-post-meta">
                    <?php echo htmlspecialchars($fecha_es); ?>
                </div>
            </header>

            <article class="single-post-content">
                <?php
                // Imprimimos el contenido HTML guardado en la BBDD
                if (!empty($post['contenido_html'])) {
                    echo $post['contenido_html'];
                } else {
                    // Fallback si no hay HTML, mostramos el texto plano y la imagen principal
                    echo '<p>' . nl2br(htmlspecialchars($post['contenido'])) . '</p>';
                    if ($post['imagen']) {
                        echo '<img src="' . htmlspecialchars($post['imagen']) . '" alt="" class="single-post-image">';
                    }
                }
                ?>
            </article>

            <a href="blog_tuevent.php" class="back-to-blog">&larr; Volver al Blog</a>

        <?php else: ?>
            <div style="text-align: center; padding: 100px 0;">
                <h2>Entrada no encontrada (404)</h2>
                <p>Lo sentimos, el artículo que buscas no existe o ha sido movido.</p>
                <a href="blog_tuevent.php" class="back-to-blog" style="margin-top:20px;">&larr; Volver al Blog</a>
            </div>
        <?php endif; ?>
    </main>

    <?php echo $footer; ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/navigation.js"></script>
</body>

</html>