<?php
require 'includes/header.php';
require 'includes/db.php';
require 'includes/functions.php';

$socios = obtenerSocios($pdo);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Video</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background-color: #000;
      color: #fff;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      font-family: Arial, sans-serif;
    }
    h1 {
      margin: 20px;
    }
    video {
      width: 90%;
      max-width: 800px;
      height: auto;
      border: 2px solid #fff;
      border-radius: 10px;
    }
  </style>
</head>
<body>

  <h1>Mi Video</h1>

  <video controls>
    <source src="video.mp4" type="video/mp4">
    Tu navegador no soporta la reproducción de video.
  </video>

</body>
</html>
