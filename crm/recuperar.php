<?php
require 'includes/db.php';

/*
 Mejores prácticas a futuro
No muestres la clave en pantalla, envíala por correo (con PHPMailer, por ejemplo).

Añade una URL temporal de reseteo con tokens.

Registra cada intento de recuperación.

Implementa reCAPTCHA para evitar abuso.
*/

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $nueva_clave = $_POST['nueva_clave'];
    $repetir_clave = $_POST['repetir_clave'];

    if ($nueva_clave !== $repetir_clave) {
        $mensaje = 'Las contraseñas no coinciden.';
    } else {
        // Verificar si el usuario existe
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE usuarios SET clave = :clave WHERE id = :id");
            $update->execute(['clave' => $clave_hash, 'id' => $user['id']]);

            $mensaje = 'Contraseña actualizada correctamente. <a href="index.php">Iniciar sesión</a>';
        } else {
            $mensaje = 'No se encontró un usuario con ese nombre.';
        }
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
                <h4 class="text-center">Restablecer contraseña</h4>
                <?php if ($mensaje): ?>
                    <div class="alert alert-info text-center"><?= $mensaje ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="nueva_clave" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" name="nueva_clave" required>
                    </div>
                    <div class="mb-3">
                        <label for="repetir_clave" class="form-label">Repetir contraseña</label>
                        <input type="password" class="form-control" name="repetir_clave" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Actualizar contraseña</button>
                    <a href="index.php" class="btn btn-link w-100 mt-2">Volver al login</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>