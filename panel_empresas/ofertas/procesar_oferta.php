<?php
require_once '../../bd/config.php'; // Tu archivo de configuración de BD

session_start();
if (!isset($_SESSION['id_empresa'])) {
     echo "No se ha encontrado la empresa. Por favor, inicie sesión.";
     exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Recoger datos del formulario
     $titulo = $_POST['titulo'];
     $descripcion = $_POST['descripcion'];
     $ubicacion = $_POST['ubicacion'];
     $tipo = $_POST['tipo'];
     $salario = $_POST['salario'];
     $categoria = $_POST['categoria'];
     $requisitos = $_POST['requisitos'];
     $fecha_publicacion = $_POST['fecha_publicacion'];
     $id_empresa = $_SESSION['id_empresa'];

     try {
          $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = "INSERT INTO Ofertas (id_empresa, titulo, descripcion, ubicacion, tipo, salario, categoria, requisitos, fecha_publicacion)
                VALUES (:id_empresa, :titulo, :descripcion, :ubicacion, :tipo, :salario, :categoria, :requisitos, :fecha_publicacion)";

          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':id_empresa', $id_empresa);
          $stmt->bindParam(':titulo', $titulo);
          $stmt->bindParam(':descripcion', $descripcion);
          $stmt->bindParam(':ubicacion', $ubicacion);
          $stmt->bindParam(':tipo', $tipo);
          $stmt->bindParam(':salario', $salario);
          $stmt->bindParam(':categoria', $categoria);
          $stmt->bindParam(':requisitos', $requisitos);
          $stmt->bindParam(':fecha_publicacion', $fecha_publicacion);

          $stmt->execute();

          // Redirigir a la lista de ofertas
          header("Location: ofertas_empleo.php");
          exit;
     } catch (PDOException $e) {
          echo "Error al crear la oferta: " . $e->getMessage();
     }
} else {
     // Mostrar error si se intenta acceder directamente
     http_response_code(405);
     echo "Método no permitido.";
}