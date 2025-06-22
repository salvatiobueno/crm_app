<?php


require 'includes/header.php';
require 'includes/db.php'; // Asegúrate de que aquí estás conectando correctamente a la base de datos

$mensaje = '';

// Mostrar errores durante desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video'])) {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $video = $_FILES['video'];

    // Validaciones
    $permitidos = ['video/mp4', 'video/quicktime', 'video/x-matroska'];
    if (!in_array($video['type'], $permitidos)) {
        $mensaje = 'Formato de video no permitido.';
    } elseif ($video['size'] > 500 * 1024 * 1024) { // 500MB máx
        $mensaje = 'El archivo es demasiado grande.';
    } else {
        $nombreArchivo = time() . '_' . basename($video['name']);

        // Rutas
        $rutaFisica = 'D:/xampp/htdocs/crm/uploads/videos/' . $nombreArchivo;
        $rutaWeb = 'uploads/videos/' . $nombreArchivo;

        // Crear carpeta si no existe
        if (!is_dir('D:/xampp/htdocs/crm/uploads/videos')) {
            mkdir('D:/xampp/htdocs/crm/uploads/videos', 0777, true);
        }

       // Mover archivo
        if (move_uploaded_file($video['tmp_name'], $rutaFisica)) {
            // Guardar en la base de datos
            $stmt = $pdo->prepare("INSERT INTO videos (titulo, descripcion, ruta, fecha_subida) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$titulo, $descripcion, $rutaWeb]);
            $mensaje = 'Video subido correctamente.';
        } else {
            $mensaje = 'Error al mover el archivo al servidor.';
        }
		
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Video - CRM TBP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
 <!-- Si tienes un navbar común -->
<div class="container py-5">
    <h2 class="mb-4">Subir nuevo video</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form action="subir_video.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título del video</label>
            <input type="text" class="form-control" name="titulo" id="titulo" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción (opcional)</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Archivo de video</label>
            <input type="file" class="form-control" name="video" id="video" accept="video/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir video</button>
    </form>
</div>
</body>
</html>
