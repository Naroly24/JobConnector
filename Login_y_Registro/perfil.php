<?php
session_start(); // Esto debe ir exactamente al principio

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php?error=Debes iniciar sesión primero");
    exit;
}

$nombre = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario</title>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($nombre) ?> 👋</h1>
    <p>¡Has iniciado sesión correctamente!</p>
    <a href="Login.php">Cerrar sesión</a>
</body>
</html>
