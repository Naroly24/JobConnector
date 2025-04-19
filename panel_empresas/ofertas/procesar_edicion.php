<?php
require_once '../../bd/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $id = $_POST['id'];
     $titulo = $_POST['titulo'];
     $descripcion = $_POST['descripcion'];
     $requisitos = $_POST['requisitos'];
     $fecha = $_POST['fecha_publicacion'];

     try {
          $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare("UPDATE Ofertas SET titulo = :titulo, descripcion = :descripcion, requisitos = :requisitos, fecha_publicacion = :fecha WHERE id = :id");
          $stmt->bindParam(':titulo', $titulo);
          $stmt->bindParam(':descripcion', $descripcion);
          $stmt->bindParam(':requisitos', $requisitos);
          $stmt->bindParam(':fecha', $fecha);
          $stmt->bindParam(':id', $id);
          $stmt->execute();

          header("Location: listar_ofertas.php");
          exit;
     } catch (PDOException $e) {
          die("Error al actualizar la oferta: " . $e->getMessage());
     }
}
