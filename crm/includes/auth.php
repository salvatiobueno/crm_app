<?php
function login($usuario, $clave) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user && password_verify($clave, $user['clave']);
}
?>