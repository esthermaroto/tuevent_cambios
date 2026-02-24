<?php
// admin/index.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
require_once '../includes/db.php';

// Eliminar post si se solicita
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT imagen FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    
    if ($post) {
        if ($post['imagen'] && file_exists('../' . $post['imagen'])) {
            unlink('../' . $post['imagen']);
        }
        $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: index.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY fecha_publicacion DESC");
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesti&oacute;n de Blog - Admin</title>
    <style>
        :root { --primary: #f39c12; --dark: #2c3e50; --light: #ecf0f1; }
        body { font-family: sans-serif; background: #f4f7f6; margin: 0; padding: 0; }
        header { background: var(--dark); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .container { padding: 2rem; max-width: 1200px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        .btn { padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.9rem; font-weight: bold; cursor: pointer; }
        .btn-new { background: #27ae60; color: white; }
        .btn-edit { background: #3498db; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .btn-logout { background: #95a5a6; color: white; font-size: 0.8rem; }
        .actions { display: flex; gap: 0.5rem; }
        img { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>
    <header>
        <h1>Panel Blog</h1>
        <div>
            <span>Hola, <?php echo htmlspecialchars($_SESSION['admin_user']); ?></span>
            <a href="logout.php" class="btn btn-logout">Cerrar Sesi&oacute;n</a>
        </div>
    </header>
    <div class="container">
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h2>Entradas del Blog</h2>
            <a href="post_edit.php" class="btn btn-new">+ Nueva Entrada</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Imagen</th>
                    <th>T&iacute;tulo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo $post['fecha_publicacion']; ?></td>
                    <td>
                        <?php if ($post['imagen']): ?>
                            <img src="../<?php echo $post['imagen']; ?>" alt="">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($post['titulo']); ?></td>
                    <td class="actions">
                        <a href="post_edit.php?id=<?php echo $post['id']; ?>" class="btn btn-edit">Editar</a>
                        <a href="index.php?delete=<?php echo $post['id']; ?>" class="btn btn-delete" onclick="return confirm('&iquest;Seguro que quieres eliminar este post?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($posts)): ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No hay entradas a&uacute;n.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>


