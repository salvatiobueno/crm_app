<?php
// pagos.php
include 'includes/auth.php';
require_login();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $socio_id = $_POST['socio_id'];
    $fecha_pago = $_POST['fecha_pago'];
    $monto = $_POST['monto'];
    $metodo = $_POST['metodo_pago'];
    $obs = $_POST['observaciones'];

    $stmt = $pdo->prepare("INSERT INTO pagos (socio_id, fecha_pago, monto, metodo_pago, observaciones) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$socio_id, $fecha_pago, $monto, $metodo, $obs]);
    header("Location: pagos.php");
    exit();
}

$pagos = $pdo->query("SELECT pagos.*, socios.nombre FROM pagos JOIN socios ON pagos.socio_id = socios.id ORDER BY fecha_pago DESC")->fetchAll();
$socios = $pdo->query("SELECT id, nombre FROM socios ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Registrar Pago</h3>
    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <select name="socio_id" class="form-select" required>
                <?php foreach ($socios as $s): ?>
                    <option value="<?= $s['id'] ?>"><?= $s['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="fecha_pago" class="form-control" required>
        </div>
        <div class="col-md-3">
            <input type="number" step="0.01" name="monto" class="form-control" placeholder="Monto" required>
        </div>
        <div class="col-md-6">
            <input type="text" name="metodo_pago" class="form-control" placeholder="Método de Pago" required>
        </div>
        <div class="col-md-6">
            <input type="text" name="observaciones" class="form-control" placeholder="Observaciones">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Guardar Pago</button>
        </div>
    </form>

    <h4 class="mt-5">Historial de Pagos</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Socio</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagos as $pago): ?>
                <tr>
                    <td><?= $pago['nombre'] ?></td>
                    <td><?= $pago['fecha_pago'] ?></td>
                    <td><?= $pago['monto'] ?> €</td>
                    <td><?= $pago['metodo_pago'] ?></td>
                    <td><?= $pago['observaciones'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>