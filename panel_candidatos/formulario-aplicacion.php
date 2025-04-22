<?php
session_start();
require_once 'conexion.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['id_candidato'])) {
    echo "<p style='color: red;'>❌ Debes iniciar sesión para aplicar.</p>";
    exit;
}

$id_candidato = $_SESSION['id_candidato']; // tomado desde la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_oferta = $_POST['id_oferta'];
    $fecha_aplicacion = date('Y-m-d');

    // Validar si ya aplicó antes (opcional, por si quieres evitar aplicaciones duplicadas)
    $verificar = $conn->query("SELECT * FROM Aplicaciones WHERE id_candidato = '$id_candidato' AND id_oferta = '$id_oferta'");
    if ($verificar->num_rows > 0) {
        echo "<p style='color: orange;'>⚠️ Ya has aplicado a esta oferta.</p>";
    } else {
        $sql = "INSERT INTO Aplicaciones (id_candidato, id_oferta, fecha_aplicacion)
                VALUES ('$id_candidato', '$id_oferta', '$fecha_aplicacion')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>✅ Aplicación enviada con éxito.</p>";
        } else {
            echo "<p style='color: red;'>❌ Error al aplicar: " . $conn->error . "</p>";
        }
    }
}

// Obtener las ofertas de empleo para el formulario
$ofertas = $conn->query("SELECT id_oferta, titulo FROM Ofertas");
?>

