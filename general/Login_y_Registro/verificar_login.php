<?php
session_start();
require('../../libreria/bd/conexion.php');

// Obtener datos del formulario
$usuario = $_POST['correo'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

try {
    // Buscar en la tabla "Usuarios" por correo
    $sql = "SELECT id_usuario, contrasena, tipo_usuario FROM Usuarios WHERE correo = ?";
    $parametros = [$usuario];
    $resultado = Conexion::select($sql, $parametros);

    if ($resultado && password_verify($contrasena, $resultado['contrasena'])) {
        // Iniciar sesión
        $_SESSION['id_usuario'] = $resultado['id_usuario'];
        $_SESSION['tipo_usuario'] = $resultado['tipo_usuario'];

        // Obtener id_empresa o id_candidato
        if ($resultado['tipo_usuario'] == 'empresa') {
            $sql_empresa = "SELECT id_empresa FROM Empresas WHERE id_usuario = ?";
            $parametros_empresa = [$resultado['id_usuario']];
            $resultado_empresa = Conexion::select($sql_empresa, $parametros_empresa);
            if ($resultado_empresa) {
                $_SESSION['id_empresa'] = $resultado_empresa['id_empresa'];
                header("Location: ../../panel_empresas/empresa_panel.php");
                exit;
            }
        } else if ($resultado['tipo_usuario'] == 'candidato') {
            $sql_candidato = "SELECT id_candidato FROM Candidatos WHERE id_usuario = ?";
            $parametros_candidato = [$resultado['id_usuario']];
            $resultado_candidato = Conexion::select($sql_candidato, $parametros_candidato);
            if ($resultado_candidato) {
                $_SESSION['id_candidato'] = $resultado_candidato['id_candidato'];
                header("Location: ../../panel_candidatos/candidato_panel.php");
                exit;
            }
        }
        header("Location: login.php?error=Perfil no encontrado");
        exit;
    } else {
        header("Location: login.php?error=Credenciales inválidas");
        exit;
    }
} catch (Exception $e) {
    header("Location: login.php?error=Error en la conexión");
    exit;
}
