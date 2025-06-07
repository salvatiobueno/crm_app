<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - CRM TBP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon_io/favicon.ico" type="image/x-icon"> <!-- https://favicon.io/ -->
    </head>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="dashboard.php">CRM TBP</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="socios.php">Socios</a></li>
            <li class="nav-item"><a class="nav-link" href="pagos.php">Pagos</a></li>
			<li class="nav-item"><a class="nav-link" href="videos.php">Videos</a></li>
        </ul>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
    </div>
</nav>
<div class="container py-4">
