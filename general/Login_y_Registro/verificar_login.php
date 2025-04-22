<?php
session_start();
require('../../libreria/conexion.php');

// Obtener datos del formulario
$usuario = $_POST['correo'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

try {
    // Buscar en la tabla "registro" por correo
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $parametros = [$usuario];
    $resultado = Conexion::select($sql, $parametros);


    if ($resultado && password_verify($contrasena, $resultado['contrasena'])) {
        // Iniciar sesión
        $_SESSION['id_usuario'] = $resultado[0]['id_usuario']; // O el nombre correcto de la columna
        $_SESSION['nombre'] = $resultado[0]['nombre'];
        $_SESSION['correo'] = $resultado[0]['correo'];

        // Redirigir al panel o página protegida
        header("Location: login.php?success=Autenticado correctamente");
        exit;
    } else {
        // Redirigir con error
        header("Location: login.php?error=Credenciales inválidas");
        exit;
    }
} catch (Exception $e) {
    header("Location: login.php?error=Error en la conexión");
    exit;
}
