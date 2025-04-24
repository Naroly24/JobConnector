<?php
session_start();
require('../libreria/motor.php');

if (!isset($_SESSION['id_usuario'])) {
    echo "<div class='alert alert-danger'>Debes iniciar sesión.</div>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener el id_candidato más reciente
$sql_candidato = "SELECT id_candidato FROM Candidatos WHERE id_usuario = ? ORDER BY id_candidato DESC LIMIT 1";
$candidato_result = Conexion::select($sql_candidato, [$id_usuario]);
$id_candidato = $candidato_result['id_candidato'] ?? null;

if (!$id_candidato) {
    echo "<div class='alert alert-danger'>Error: No se encontró un registro de candidato. Por favor, completa tu perfil primero.</div>";
    exit;
}

// Recibir datos del formulario
$institucion = $_POST['institucion'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$fecha_inicio_formacion = $_POST['fecha_inicio_formacion'] ?? null;
$fecha_fin_formacion = $_POST['fecha_fin_formacion'] ?? null;

$empresa = $_POST['empresa'] ?? '';
$puesto = $_POST['puesto'] ?? '';
$fecha_inicio_experiencia = $_POST['fecha_inicio_experiencia'] ?? null;
$fecha_fin_experiencia = $_POST['fecha_fin_experiencia'] ?? null;

$habilidades = $_POST['habilidades'] ?? '';

$idioma = $_POST['idioma'] ?? '';
$nivel_idioma = $_POST['nivel_idioma'] ?? '';

$logros = $_POST['logros'] ?? '';
$referencias = $_POST['referencias'] ?? '';
$objetivo = $_POST['resumen'] ?? '';
$disponibilidad = $_POST['disponibilidad'] ?? '';
$redes = $_POST['redes'] ?? '';
$direccion = $_POST['direccion'] ?? '';

// Procesar archivo CV
$cv_data = null;
if (isset($_FILES['cv_pdf']) && $_FILES['cv_pdf']['error'] === UPLOAD_ERR_OK) {
    $cv_data = file_get_contents($_FILES['cv_pdf']['tmp_name']);
}

// Procesar archivo de foto
$foto_data = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $foto_data = file_get_contents($_FILES['foto']['tmp_name']);
}

// Actualizar datos generales del candidato
$sql_update_candidato = "UPDATE Candidatos SET direccion = ?, resumen_profesional = ?, disponibilidad = ?, redes_profesionales = ?, cv_pdf = ?, foto = ? WHERE id_candidato = ?";
Conexion::ejecutar($sql_update_candidato, [$direccion, $objetivo, $disponibilidad, $redes, $cv_data, $foto_data, $id_candidato]);

// Insertar Formación Académica
if ($institucion && $titulo) {
    $sql_formacion = "INSERT INTO Formaciones_Academicas (id_candidato, institucion, titulo, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)";
    Conexion::ejecutar($sql_formacion, [$id_candidato, $institucion, $titulo, $fecha_inicio_formacion, $fecha_fin_formacion]);
}

// Insertar Experiencia Laboral
if ($empresa && $puesto) {
    $sql_experiencia = "INSERT INTO Experiencias_Laborales (id_candidato, empresa, puesto, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)";
    Conexion::ejecutar($sql_experiencia, [$id_candidato, $empresa, $puesto, $fecha_inicio_experiencia, $fecha_fin_experiencia]);
}

// Insertar Habilidades
if ($habilidades) {
    $sql_habilidades = "INSERT INTO Habilidades (id_candidato, habilidad) VALUES (?, ?)";
    Conexion::ejecutar($sql_habilidades, [$id_candidato, $habilidades]);
}

// Insertar Idiomas
if ($idioma && $nivel_idioma) {
    $sql_idiomas = "INSERT INTO Idiomas (id_candidato, idioma, nivel) VALUES (?, ?, ?)";
    Conexion::ejecutar($sql_idiomas, [$id_candidato, $idioma, $nivel_idioma]);
}

// Insertar Logros
if ($logros) {
    $sql_logros = "INSERT INTO Logros_Proyectos (id_candidato, descripcion) VALUES (?, ?)";
    Conexion::ejecutar($sql_logros, [$id_candidato, $logros]);
}

// Insertar Referencias
if ($referencias) {
    $sql_referencias = "INSERT INTO Referencias (id_candidato, nombre_contacto, descripcion_contacto) VALUES (?, ?, ?)";
    Conexion::ejecutar($sql_referencias, [$id_candidato, $referencias, $referencias]);
}

// Redireccionar con éxito
header('Location: curriculum.php?success=1');
exit;
