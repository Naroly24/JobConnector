<?php
require_once 'bd/config.php'; // Asegúrate de que la ruta es correcta

try {
     $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     echo "✅ Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
     echo "❌ Error de conexión: " . $e->getMessage();
}
