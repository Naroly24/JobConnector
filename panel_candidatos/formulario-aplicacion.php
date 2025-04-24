<?php
$ocultar_footer = true;
require_once('../libreria/bd/conexion.php'); // ← Asegúrate de incluir aquí tu clase conexión
require_once '../panel_empresas/ofertas/crud_ofertas.php';
require('../libreria/motor.php');
require('../libreria/plantilla.php');

plantilla::aplicar();

if (isset($ocultar_footer) && $ocultar_footer) {
    echo '<style>footer { display: none !important; }</style>';
}

plantilla::navbar();

// Verificar sesión
if (!isset($_SESSION['id_candidato'])) {
    echo "<p style='color: red;'>❌ Debes iniciar sesión para aplicar.</p>";
    exit;
}

$id_candidato = $_SESSION['id_candidato'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_oferta = $_POST['id_oferta'] ?? null;
    $fecha_aplicacion = date('Y-m-d');

    // Verificar si ya aplicó
    $verificacion = conexion::select("SELECT * FROM Aplicaciones WHERE id_candidato = ? AND id_oferta = ?", [
        $id_candidato, $id_oferta
    ]);

    if ($verificacion) {
        echo "<p style='color: orange;'>⚠️ Ya has aplicado a esta oferta.</p>";
    } else {
        $sql = "INSERT INTO Aplicaciones (id_candidato, id_oferta, fecha_aplicacion) VALUES (?, ?, ?)";
        $exito = conexion::ejecutar($sql, [$id_candidato, $id_oferta, $fecha_aplicacion]);

        if ($exito) {
            header("Location: candidato_panel.php?mensaje=aplicacion_exitosa");
            exit;
        } else {
            header("Location: candidato_panel.php?mensaje=error");
            exit;
        }
    }
}

// Obtener ofertas
$ofertas = conexion::consulta("SELECT id_oferta, titulo FROM Ofertas");
?>
