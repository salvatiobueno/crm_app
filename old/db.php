<?php
// includes/db.php
$pdo = new PDO("mysql:host=localhost;dbname=gimnasio", "usuario", "clave");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<?php
// includes/auth.php
function require_login() {
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }
}
?>