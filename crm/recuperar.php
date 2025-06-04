<?php
require 'includes/db.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];

    // Verificar si el usuario existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
    $stmt->execute(['usuario' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generar una clave temporal (por ejemplo: 6 caracteres aleatorios)
        $nueva_clave = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 8);
        $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);

        // Guardar nueva clave en la base de datos
        $update = $pdo->prepare("UPDATE usuarios SET clave = :clave WHERE id = :id");
        $update->execute(['clave' => $clave_hash, 'id' => $user['id']]);

        // Mostrar la nueva clave (en producción deberías enviarla por email)
        $mensaje = "Tu nueva contraseña temporal es: <strong>$nueva_clave</strong>";
    } else {
        $mensaje = "No se encontró un usuario con ese nombre.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow">
                <h4 class="text-center">Recuperar contraseña</h4>
                <?php if ($mensaje): ?>
                    <div class="alert alert-info text-center"><?= $mensaje ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" name="usuario" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Generar nueva contraseña</button>
                    <a href="index.php" class="btn btn-link w-100 mt-2">Volver al login</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
