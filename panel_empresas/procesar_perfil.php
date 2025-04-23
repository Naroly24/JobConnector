<?php
require('../libreria/motor.php');
session_start();

$idUsuario = $_SESSION['id_usuario'] ?? null;

if (!$idUsuario) {
    die("Acceso no autorizado.");
}

// Recibir datos del formulario
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$correo = $_POST['correo'] ?? '';
$rnc = $_POST['rnc'] ?? ''; // ✅ Agregado

$password_actual = $_POST['password_actual'] ?? '';
$nueva_password = $_POST['nueva_password'] ?? '';
$confirmar_password = $_POST['confirmar_password'] ?? '';

// Datos de empresa
$nombre_empresa = $_POST['nombre_empresa'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$industria = $_POST['industria'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? '';
$sitio_web = $_POST['sitio_web'] ?? '';
$correo_contacto = $_POST['correo_contacto'] ?? '';
$telefono = $_POST['telefono'] ?? '';

// --- VALIDAR CAMBIO DE CONTRASEÑA ---
$cambiar_contrasena = false;
if (!empty($password_actual) && !empty($nueva_password) && !empty($confirmar_password)) {
    if ($nueva_password !== $confirmar_password) {
        die("❌ La nueva contraseña y la confirmación no coinciden.");
    }

    // Obtener contraseña actual de la base
    $sql = "SELECT contraseña FROM Usuarios WHERE id_usuario = ?";
    $result = Conexion::select($sql, [$idUsuario]);

    if (!$result || !password_verify($password_actual, $result['contraseña'])) {
        die("❌ La contraseña actual es incorrecta.");
    }

    $nueva_contraseña_hashed = password_hash($nueva_password, PASSWORD_DEFAULT);
    $cambiar_contrasena = true;
}

// --- ACTUALIZAR USUARIO ---
$sqlUsuario = "UPDATE Usuarios SET nombre = ?, apellido = ?, correo = ? " . ($cambiar_contrasena ? ", contraseña = ?" : "") . " WHERE id_usuario = ?";
$paramsUsuario = [$nombre, $apellido, $correo];
if ($cambiar_contrasena) {
    $paramsUsuario[] = $nueva_contraseña_hashed;
}
$paramsUsuario[] = $idUsuario;

Conexion::ejecutar($sqlUsuario, $paramsUsuario);

// --- ACTUALIZAR EMPRESA ---
$sqlEmpresa = "UPDATE Empresas SET 
    rnc = ?,
    descripcion = ?, 
    sector = ?, 
    direccion = ?, 
    sitio_web = ?, 
    correo_corporativo = ?, 
    telefono = ? 
    WHERE id_usuario = ?";

$paramsEmpresa = [
    $rnc,             // ✅ Asegúrate que este sea el primer parámetro
    $descripcion,
    $industria,
    $ubicacion,
    $sitio_web,
    $correo_contacto,
    $telefono,
    $idUsuario
];

Conexion::ejecutar($sqlEmpresa, $paramsEmpresa);

// Redirigir o mostrar mensaje
echo "<script>alert('✅ Perfil actualizado correctamente.'); window.location.href='perfil_empresa.php';</script>";
exit;
?>
