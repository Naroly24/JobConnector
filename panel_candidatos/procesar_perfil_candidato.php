<?php
require('../libreria/motor.php');
session_start();

$idUsuario = $_SESSION['id_usuario'] ?? null;

if (!$idUsuario) {
    die("Acceso no autorizado.");
}

// Datos del formulario
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$correo = $_POST['correo'] ?? '';

$password_actual = $_POST['password_actual'] ?? '';
$nueva_password = $_POST['nueva_password'] ?? '';
$confirmar_password = $_POST['confirmar_password'] ?? '';

$telefono = $_POST['telefono'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$profesion = $_POST['profesion'] ?? '';
$disponibilidad = $_POST['disponibilidad'] ?? '';

$cambiar_contrasena = false;
if (!empty($password_actual) && !empty($nueva_password) && !empty($confirmar_password)) {
    if ($nueva_password !== $confirmar_password) {
        die("❌ La nueva contraseña y la confirmación no coinciden.");
    }

    $sql = "SELECT contraseña FROM Usuarios WHERE id_usuario = ?";
    $result = Conexion::select($sql, [$idUsuario]);

    if (!$result || !password_verify($password_actual, $result['contraseña'])) {
        die("❌ La contraseña actual es incorrecta.");
    }

    $nueva_contraseña_hashed = password_hash($nueva_password, PASSWORD_DEFAULT);
    $cambiar_contrasena = true;
}

// Actualizar tabla Usuarios
$sqlUsuario = "UPDATE Usuarios SET nombre = ?, apellido = ?, correo = ?";
$paramsUsuario = [$nombre, $apellido, $correo];

if ($cambiar_contrasena) {
    $sqlUsuario .= ", contraseña = ?";
    $paramsUsuario[] = $nueva_contraseña_hashed;
}

$sqlUsuario .= " WHERE id_usuario = ?";
$paramsUsuario[] = $idUsuario;
Conexion::ejecutar($sqlUsuario, $paramsUsuario);

// Obtener ID del candidato asociado
$sqlIdCandidato = "SELECT id_candidato FROM Candidatos WHERE id_usuario = ?";
$res = Conexion::select($sqlIdCandidato, [$idUsuario]);
$idCandidato = $res['id_candidato'] ?? null;

if ($idCandidato) {
    $sqlCandidato = "UPDATE Candidatos SET 
        telefono = ?, 
        ciudad = ?, 
        profesion = ?, 
        disponibilidad = ?, 
        WHERE id_candidato = ?";

    $paramsCandidato = [
        $telefono,
        $ciudad,
        $profesion,
        $disponibilidad,
        $idCandidato
    ];

    Conexion::ejecutar($sqlCandidato, $paramsCandidato);
}

// Redirigir
echo "<script>alert('✅ Perfil actualizado correctamente.'); window.location.href='perfil_candidato.php';</script>";
exit;