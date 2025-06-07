<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';

if (isset($_SESSION['usuario'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        if (login($usuario, $clave)) {
            $_SESSION['usuario'] = $usuario;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Usuario o clave incorrectos';
        }
    }

    if (isset($_POST['registro'])) {
        $nuevoUsuario = trim($_POST['nuevo_usuario']);
        $nuevaClave = $_POST['nueva_clave'];

        if (strlen($nuevoUsuario) < 3 || strlen($nuevaClave) < 4) {
            $error = 'El usuario debe tener al menos 3 caracteres y la clave al menos 4.';
        } elseif (registrar($nuevoUsuario, $nuevaClave)) {
            $exito = 'Usuario creado correctamente. Ya puedes iniciar sesión.';
        } else {
            $error = 'Error al registrar. Puede que el usuario ya exista.';
        }
    }
}
?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - CRM TBP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon_io/favicon.ico" type="image/x-icon">
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card p-4 shadow mb-4">
                <h4 class="text-center">CRM - Iniciar Sesión</h4>
                <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
                <?php if ($exito): ?><div class="alert alert-success"><?= $exito ?></div><?php endif; ?>

                <form method="post">
                    <input type="hidden" name="login" value="1">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="form-label">Clave</label>
                        <input type="password" class="form-control" name="clave" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    <div class="text-center mt-2">
                        <a href="recuperar.php">¿Olvidaste tu contraseña?</a>
                    </div>
                </form>
            </div>

            <div class="card p-4 shadow">
                <h5 class="text-center">¿No tienes cuenta?</h5>
                <form method="post">
                    <input type="hidden" name="registro" value="1">
                    <div class="mb-3">
                        <label for="nuevo_usuario" class="form-label">Nuevo usuario</label>
                        <input type="text" class="form-control" name="nuevo_usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="nueva_clave" class="form-label">Nueva clave</label>
                        <input type="password" class="form-control" name="nueva_clave" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Registrarse</button>
                </form>
            </div>

        </div>
    </div>
</div>
</body>
</html>
