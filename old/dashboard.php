<?php
// dashboard.php
include 'includes/auth.php';
require_login();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Bienvenido al CRM del Gimnasio</h2>
    <a href="socios.php" class="btn btn-outline-primary mt-3">Gestionar Socios</a>
</div>
</body>
</html>