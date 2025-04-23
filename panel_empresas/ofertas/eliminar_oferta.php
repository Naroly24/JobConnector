<?php
session_start();
require('../../libreria/motor.php');

// Check if empresa is logged in
if (!isset($_SESSION['id_empresa'])) {
     header("Location: ../../general/Login_y_Registro/login.php");
     exit();
}

// Ensure id_oferta is provided via GET
if (!isset($_GET['id_oferta']) || !is_numeric($_GET['id_oferta'])) {
     header("Location: ../empresa_panel.php?error=ID de oferta inválido");
     exit();
}

require_once 'crud_ofertas.php';

$id_oferta = (int)$_GET['id_oferta'];
$id_empresa = $_SESSION['id_empresa'];

$resultado = eliminarOferta($id_oferta, $id_empresa);

if ($resultado) {
     header("Location: ../empresa_panel.php?msg=Oferta eliminada exitosamente");
} else {
     header("Location: ../empresa_panel.php?error=No se pudo eliminar la oferta");
}
exit();
