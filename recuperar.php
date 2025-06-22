<?php
$error = $msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'includes/db.php';

    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $pdo->prepare("UPDATE usuarios SET reset_token = ?, reset_expira = ? WHERE usuario = ?");
        $stmt->execute([$token, $expira, $email]);

        $enlace = "http://tusitio.com/resetear.php?token=$token"; // Cambia a tu dominio
        $asunto = "Recuperación de contraseña";
        $mensaje = "Haz clic en el siguiente enlace para restablecer tu contraseña:\n$enlace";

        mail($email, $asunto, $mensaje); // O usa PHPMailer si lo prefieres

        $msg = "Se ha enviado un enlace a tu correo para restablecer la contraseña.";
    } else {
        $error = "No se encontró ese correo.";
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
        <div class="col-md-4">
            <div class="card p-4 shadow">
                <h4 class="text-center">Recuperar contraseña</h4>
                <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
                <?php if ($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar enlace</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
