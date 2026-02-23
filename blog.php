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
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Cabin:ital,wght@0,400..700;1,400..700&family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&subset=latin-ext&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/style.css">
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
                    <span class="btn-read-more">Ver m&aacute;s â†&rsquo;</span>
                </div>
            </a>
        <?php endforeach; ?>

        <?php if (empty($posts)): ?>
            <div style="text-align: center; width: 100%; padding: 100px 0;">
                <h3>Pr&oacute;ximamente nuevas entradas...</h3>
            </div>
        <?php endif; ?>
    </main>

    <?php echo $footer; ?>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/navigation.js"></script>
    <script>
        // Inicializar navegación del header para que coincida con el resto del sitio
        document.addEventListener('DOMContentLoaded', function () {
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            const mainNav = document.querySelector('.main-navigation');

            if (mobileToggle && mainNav) {
                mobileToggle.addEventListener('click', function () {
                    this.classList.toggle('active');
                    mainNav.classList.toggle('active');
                });
            }

            const hasSubmenu = document.querySelectorAll('.has-submenu');
            hasSubmenu.forEach(item => {
                const link = item.querySelector('a');
                if (link && window.innerWidth <= 768) {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        item.classList.toggle('active');
                    });
                }
            });

            const currentPage = window.location.pathname.split('/').pop() || 'index.html';
            const navLinks = document.querySelectorAll('.nav-menu a');
            navLinks.forEach(link => {
                link.classList.remove('active');
                const href = link.getAttribute('href');
                if (href === currentPage || (currentPage === '' && href === 'index.html')) {
                    link.classList.add('active');
                }
            });

            const navMenuLinks = document.querySelectorAll('.nav-menu a');
            navMenuLinks.forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768 && !this.parentElement.classList.contains('has-submenu')) {
                        if (mobileToggle) mobileToggle.classList.remove('active');
                        if (mainNav) mainNav.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>

