<?php
require_once '../../bd/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
     $id = $_POST['id'];

     try {
          $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare("DELETE FROM Ofertas WHERE id = :id");
          $stmt->bindParam(':id', $id);
          $stmt->execute();

          header("Location: listar_ofertas.php");
          exit;
     } catch (PDOException $e) {
          die("Error al eliminar la oferta: " . $e->getMessage());
     }
}
