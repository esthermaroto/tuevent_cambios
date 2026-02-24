<?php
// post.php
require_once 'includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: blog.php');
    exit;
}

$header = file_get_contents('includes/header.html');
$footer = file_get_contents('includes/footer.html');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['titulo']); ?> - Blog Tuevent</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .post-container {
            max-width: 900px;
            margin: 120px auto 60px;
            padding: 0 20px;
        }
        .post-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .post-title {
            font-size: 3.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
            line-height: 1.1;
        }
        .post-meta {
            color: #7f8c8d;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .post-image {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        .post-content {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #2c3e50;
        }
        .post-content h2, .post-content h3 {
            color: #f39c12;
            margin-top: 40px;
        }
        .post-content p {
            margin-bottom: 20px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 30px;
            color: #f39c12;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .post-title { font-size: 2.5rem; }
            .post-container { margin-top: 80px; }
        }
    </style>
</head>
<body>
    <?php echo $header; ?>

    <main class="post-container">
        <a href="blog.php" class="back-link">Volver al blog</a>
        
        <header class="post-header">
            <div class="post-meta"><?php echo date('d / m / Y', strtotime($post['fecha_publicacion'])); ?></div>
            <h1 class="post-title"><?php echo htmlspecialchars($post['titulo']); ?></h1>
        </header>

        <?php if ($post['imagen']): ?>
            <img src="<?php echo $post['imagen']; ?>" alt="<?php echo htmlspecialchars($post['titulo']); ?>" class="post-image">
        <?php endif; ?>

        <div class="post-content">
            <?php echo $post['contenido']; ?>
        </div>
    </main>

    <?php echo $footer; ?>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/navigation.js"></script>
</body>
</html>

