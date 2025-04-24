<?php

//include_once __DIR__ .'/bd/db_config.php';
include_once __DIR__ .'/bd/conexion.php';

try {
     $testConnection = conexion::getInstancia()->conexion;
} catch (Exception $e) {
     if (strpos($e->getMessage(), 'Unknown database') !== false || strpos($e->getMessage(), 'No such file or directory') !== false) {
          if (!headers_sent()) {
               header("Location: /Libreria/bd/instalador.php");
               exit;
          }
          echo "<script>window.location.href='/Libreria/bd/instalador.php';</script>";
          exit;
     }
     die("Error de conexión: " . $e->getMessage());
}

// // Utility function to sanitize input
// function sanitizeInput($data)
// {
//      return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
// }

?>