<?php
require_once '../../bd/config.php';
require_once 'crud_ofertas.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $data = [
          'titulo' => $_POST['titulo'],
          'descripcion' => $_POST['descripcion'],
          'requisitos' => $_POST['requisitos'],
     ];

     if (actualizarOferta($data)) {
          echo "<script>alert('✅ Oferta actualizada con éxito'); window.location.href='../empresa_panel.php';</script>";
     } else {
            echo "<script>alert('❌ Error al actualizar/procesar la oferta'); window.location.href='../empresa_panel.php';</script>";
     }
}
