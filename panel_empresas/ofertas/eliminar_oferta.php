<?php
require_once '../../bd/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_oferta'])) {
     $id_oferta = $_POST['id_oferta'];

     try {
          $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare("DELETE FROM Ofertas WHERE id_oferta = :id_oferta");
          $stmt->bindParam(':id_oferta', $id_oferta);
          $stmt->execute();

          header("Location: listar_ofertas.php");
          exit;
     } catch (PDOException $e) {
          die("Error al eliminar la oferta: " . $e->getMessage());
     }
}
