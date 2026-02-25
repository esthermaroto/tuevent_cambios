<?php
// Incluimos tu conexión de base de datos para extraer los posts
require_once 'includes/db.php';
$header = file_get_contents('includes/header.html');
$footer = file_get_contents('includes/footer.html');

try {
    $stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY fecha_publicacion DESC, id DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Si la tabla no existe o hay algún error
    $posts = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Tuevent</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body style="background-color: #fff;">
    <?php echo $header; ?>

    <main class="blog-list-container">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post):
                $excerpt = strip_tags($post['contenido']);
                $id = $post['id'];
                $slug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($post['titulo'])), '-');
                $permalink = $slug;
                ?>
                <div class="blog-post-row">
                    <div class="blog-post-image-col">
                        <a href="post.php?id=<?php echo $id; ?>" style="display:block;">
                            <div class="blog-post-img-wrapper">
                                <?php if ($post['imagen']): ?>
                                    <img src="<?php echo htmlspecialchars($post['imagen']); ?>"
                                        alt="<?php echo htmlspecialchars($post['titulo']); ?>">
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <div class="blog-post-content-col">
                        <h2 class="blog-post-title">
                            <a href="post.php?id=<?php echo $id; ?>">
                                <?php echo htmlspecialchars($post['titulo']); ?>
                            </a>
                        </h2>
                        <div class="blog-post-excerpt">
                            <?php echo $excerpt; ?>
                        </div>
                        <a href="post.php?id=<?php echo $id; ?>" class="blog-post-readmore">
                            Leer más &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 100px 0;">
                <h2>Próximamente nuevas entradas...</h2>
            </div>
        <?php endif; ?>
    </main>

    <?php echo $footer; ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/navigation.js"></script>
</body>

</html>