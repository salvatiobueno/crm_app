<?php
// socios.php
include 'includes/auth.php';
require_login();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    $stmt = $pdo->prepare("INSERT INTO socios (nombre, email, telefono, estado) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $email, $telefono, $estado]);
    header("Location: socios.php");
    exit();
}

$socios = $pdo->query("SELECT * FROM socios")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Listado de Socios</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($socios as $socio): ?>
                <tr>
                    <td><?= $socio['id'] ?></td>
                    <td><?= $socio['nombre'] ?></td>
                    <td><?= $socio['email'] ?></td>
                    <td><?= $socio['telefono'] ?></td>
                    <td><?= $socio['estado'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="mt-5">Agregar Nuevo Socio</h4>
    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="col-md-6">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-6">
            <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
        </div>
        <div class="col-md-6">
            <select name="estado" class="form-select">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
                <option value="moroso">Moroso</option>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Guardar Socio</button>
        </div>
    </form>
</div>
</body>
</html>