<?php
// blog.php
require_once 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY fecha_publicacion DESC, id DESC");
$posts = $stmt->fetchAll();

$header = file_get_contents('includes/header.html');
$footer = file_get_contents('includes/footer.html');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Tuevent</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .blog-hero {
            background: linear-gradient(135deg, #2c3e50 0%, #000000 100%);
            padding: 120px 0 60px;
            text-align: center;
            color: white;
        }
        .blog-hero h1 { font-size: 3.5rem; margin: 0; color: #f39c12; }
        
        .blog-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
        }

        .blog-entry {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            text-decoration: none;
            color: inherit;
        }
        .blog-entry:hover { transform: translateY(-5px); }

        /* Estilo para el primer post (Ancho completo) */
        .blog-entry.featured {
            width: 100%;
        }
        
        /* Estilo para el resto (50%) */
        .blog-entry.regular {
            width: calc(50% - 20px);
        }

        .blog-entry-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        .regular .blog-entry-image {
            height: 250px;
        }

        .blog-entry-content {
            padding: 30px;
        }
        .featured .blog-entry-content {
            padding: 40px;
        }

        .blog-entry-date {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        .blog-entry-title {
            font-size: 2.5rem;
            margin: 0 0 15px 0;
            color: #2c3e50;
            line-height: 1.2;
        }
        .regular .blog-entry-title {
            font-size: 1.8rem;
        }

        .blog-entry-excerpt {
            color: #34495e;
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .featured .blog-entry-excerpt {
            -webkit-line-clamp: 4;
            font-size: 1.1rem;
        }

        .btn-read-more {
            display: inline-block;
            color: #f39c12;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .blog-entry.regular {
                width: 100%;
            }
            .blog-entry-image {
                height: 250px;
            }
            .blog-entry-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <?php echo $header; ?>

    <section class="blog-hero">
        <h1>NUESTRO BLOG</h1>
        <p>Actualidad, noticias y tendencias del sector eventos</p>
    </section>

    <main class="blog-container">
        <?php foreach ($posts as $index => $post): 
            $class = ($index === 0) ? 'featured' : 'regular';
            // Limpiar HTML para el extracto
            $excerpt = strip_tags($post['contenido']);
        ?>
            <a href="post.php?id=<?php echo $post['id']; ?>" class="blog-entry <?php echo $class; ?>">
                <?php if ($post['imagen']): ?>
                    <img src="<?php echo $post['imagen']; ?>" alt="<?php echo htmlspecialchars($post['titulo']); ?>" class="blog-entry-image">
                <?php else: ?>
                    <div class="blog-entry-image" style="background: #eee; display: flex; align-items: center; justify-content: center; color: #999;">Sin imagen</div>
                <?php endif; ?>
                
                <div class="blog-entry-content">
                    <div class="blog-entry-date"><?php echo date('d/m/Y', strtotime($post['fecha_publicacion'])); ?></div>
                    <h2 class="blog-entry-title"><?php echo htmlspecialchars($post['titulo']); ?></h2>
                    <div class="blog-entry-excerpt"><?php echo $excerpt; ?></div>
                    <span class="btn-read-more">Ver más →</span>
                </div>
            </a>
        <?php endforeach; ?>

        <?php if (empty($posts)): ?>
            <div style="text-align: center; width: 100%; padding: 100px 0;">
                <h3>Próximamente nuevas entradas...</h3>
            </div>
        <?php endif; ?>
    </main>

    <?php echo $footer; ?>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/navigation.js"></script>
</body>
</html>
