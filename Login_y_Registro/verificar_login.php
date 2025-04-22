<?php
session_start();
require('libreria/conexion.php');

// Obtener datos del formulario
$usuario = $_POST['correo'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

try {
    // Buscar en la tabla "usuarios" por correo
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $parametros = [$usuario];
    $resultado = Conexion::select($sql, $parametros);

    if ($resultado && password_verify($contrasena, $resultado['contrasena'])) {
        // Iniciar sesión
        $_SESSION['id_usuario'] = $resultado['id_usuario'];
        $_SESSION['nombre'] = $resultado['nombre'];
        $_SESSION['apellido'] = $resultado['apellido'];
        $_SESSION['correo'] = $resultado['correo'];
        $_SESSION['tipo_usuario'] = $resultado['tipo_usuario']; // 'candidato' o 'empresa'

        // Redirigir al perfil
        header("Location: perfil.php");
        exit;
    } else {
        header("Location: login.php?error=Credenciales inválidas");
        exit;
    }
} catch (Exception $e) {
    header("Location: login.php?error=Error en la conexión");
    exit;
}
