<?php
// admin/post_edit.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
require_once '../includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = ['titulo' => '', 'contenido' => '', 'fecha_publicacion' => date('Y-m-d'), 'imagen' => ''];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    if (!$post) {
        header('Location: index.php');
        exit;
    }
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $fecha = $_POST['fecha_publicacion'] ?? '';
    $imagen_path = $post['imagen'];

    // Procesar Imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/blog/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_tmp = $_FILES['imagen']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['imagen']['name']);
        $target_file = $upload_dir . $file_name;
        $relative_path = '../assets/images/blog/' . $file_name;

        // Optimizaci&oacute;n de imagen
        $info = getimagesize($file_tmp);
        if ($info) {
            $mime = $info['mime'];
            switch ($mime) {
                case 'image/jpeg': $src = imagecreatefromjpeg($file_tmp); break;
                case 'image/png': $src = imagecreatefrompng($file_tmp); break;
                case 'image/gif': $src = imagecreatefromgif($file_tmp); break;
                default: $src = null;
            }

            if ($src) {
                $width = imagesx($src);
                $height = imagesy($src);
                $max_width = 1200;

                if ($width > $max_width) {
                    $new_width = $max_width;
                    $new_height = floor($height * ($max_width / $width));
                    $tmp_img = imagecreatetruecolor($new_width, $new_height);
                    
                    if ($mime == 'image/png' || $mime == 'image/gif') {
                        imagealphablending($tmp_img, false);
                        imagesavealpha($tmp_img, true);
                    }
                    
                    imagecopyresampled($tmp_img, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    imagedestroy($src);
                    $src = $tmp_img;
                }

                // Guardar optimizada
                if ($mime == 'image/png') {
                    imagepng($src, $target_file, 8); // Compresi&oacute;n 0-9
                } elseif ($mime == 'image/gif') {
                    imagegif($src, $target_file);
                } else {
                    imagejpeg($src, $target_file, 85); // Calidad 85%
                }
                imagedestroy($src);
                
                // Borrar imagen anterior si existe
                if ($post['imagen'] && file_exists('../' . $post['imagen'])) {
                    unlink('../' . $post['imagen']);
                }
                $imagen_path = $relative_path;
            }
        }
    }

    if ($titulo && $contenido && $fecha) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE blog_posts SET titulo = ?, contenido = ?, fecha_publicacion = ?, imagen = ? WHERE id = ?");
            $stmt->execute([$titulo, $contenido, $fecha, $imagen_path, $id]);
            $success = 'Post actualizado correctamente';
        } else {
            $stmt = $pdo->prepare("INSERT INTO blog_posts (titulo, contenido, fecha_publicacion, imagen) VALUES (?, ?, ?, ?)");
            $stmt->execute([$titulo, $contenido, $fecha, $imagen_path]);
            header('Location: index.php');
            exit;
        }
    } else {
        $error = 'Por favor, rellene todos los campos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Editar' : 'Nuevo'; ?> Post - Admin</title>
    <style>
        :root { --primary: #f39c12; --dark: #2c3e50; --light: #ecf0f1; }
        body { font-family: sans-serif; background: #f4f7f6; margin: 0; padding: 0; }
        header { background: var(--dark); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .container { padding: 2rem; max-width: 900px; margin: 0 auto; }
        .form-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input[type="text"], input[type="date"], textarea { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-family: inherit; }
        textarea { height: 300px; resize: vertical; }
        .btn { padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: bold; cursor: pointer; border: none; }
        .btn-save { background: #27ae60; color: white; }
        .btn-cancel { background: #95a5a6; color: white; margin-left: 1rem; }
        .error { color: #e74c3c; margin-bottom: 1rem; }
        .success { color: #27ae60; margin-bottom: 1rem; }
        .preview-img { max-width: 200px; display: block; margin-top: 10px; border-radius: 4px; }
        .toolbar { background: #f8f9fa; border: 1px solid #ddd; border-bottom: none; padding: 5px; border-radius: 4px 4px 0 0; display: flex; gap: 5px; }
        .toolbar button { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>
    <header>
        <h1><?php echo $id ? 'Editar Post' : 'Nueva Entrada'; ?></h1>
        <a href="index.php" class="btn btn-cancel">Volver</a>
    </header>
    <div class="container">
        <?php if ($error): ?> <div class="error"><?php echo $error; ?></div> <?php endif; ?>
        <?php if ($success): ?> <div class="success"><?php echo $success; ?></div> <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data" class="form-card">
            <div class="form-group">
                <label for="titulo">T&iacute;tulo</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($post['titulo']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="fecha">Fecha de Publicaci&oacute;n</label>
                <input type="date" id="fecha" name="fecha_publicacion" value="<?php echo $post['fecha_publicacion']; ?>" required>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen (Recomendado 1200x800px)</label>
                <?php if ($post['imagen']): ?>
                    <img src="../<?php echo $post['imagen']; ?>" class="preview-img" alt="Vista previa">
                <?php endif; ?>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>

            <div class="form-group">
                <label for="contenido">Contenido (HTML Permitido)</label>
                <div class="toolbar">
                    <button type="button" onclick="formatDoc('bold')"><b>B</b></button>
                    <button type="button" onclick="formatDoc('italic')"><i>I</i></button>
                    <button type="button" onclick="formatDoc('insertUnorderedList')">â€¢ Lista</button>
                    <button type="button" onclick="formatDoc('formatBlock', 'h3')">H3</button>
                    <button type="button" onclick="formatDoc('createLink')">Link</button>
                </div>
                <div id="editor" contenteditable="true" style="border: 1px solid #ddd; padding: 10px; min-height: 200px; border-radius: 0 0 4px 4px;"><?php echo $post['contenido']; ?></div>
                <textarea name="contenido" id="realContent" style="display:none;"><?php echo $post['contenido']; ?></textarea>
            </div>

            <button type="submit" class="btn btn-save" onclick="syncContent()">Guardar Entrada</button>
        </form>
    </div>

    <script>
        function formatDoc(cmd, val) {
            if (cmd === 'createLink') {
                val = prompt("Introduce la URL:");
            }
            document.execCommand(cmd, false, val);
        }

        function syncContent() {
            document.getElementById('realContent').value = document.getElementById('editor').innerHTML;
        }
        
        // Mantener sincronizado mientras se edita para evitar p&eacute;rdida accidental
        document.getElementById('editor').addEventListener('input', syncContent);
    </script>
</body>
</html>


