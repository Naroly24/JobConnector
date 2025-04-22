<?php
require_once '../../bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_oferta'])) {
     $id_oferta = $_POST['id_oferta'];

     eliminarOferta($id_oferta, $_SESSION['id_empresa']);
}
