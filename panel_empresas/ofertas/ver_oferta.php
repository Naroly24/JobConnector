<?php
require_once '../../bd/config.php';

if (!isset($_GET['id'])) {
     echo "ID de oferta no proporcionado.";
     exit;
}

$id = $_GET['id'];

try {
     $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $stmt = $conn->prepare("SELECT * FROM Ofertas WHERE id = :id");
     $stmt->bindParam(':id', $id);
     $stmt->execute();
     $oferta = $stmt->fetch(PDO::FETCH_ASSOC);

     if (!$oferta) {
          echo "Oferta no encontrada.";
          exit;
     }
} catch (PDOException $e) {
     die("Error al obtener la oferta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <title>Detalle de la Oferta</title>
     <link rel="stylesheet" href="../../assets/style.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
     <main class="container my-5">
          <h1 class="text-center text-primary"><?= htmlspecialchars($oferta['titulo']) ?></h1>
          <p><strong>Fecha de publicación:</strong> <?= $oferta['fecha_publicacion'] ?></p>
          <p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($oferta['descripcion'])) ?></p>
          <p><strong>Requisitos:</strong><br><?= nl2br(htmlspecialchars($oferta['requisitos'])) ?></p>
          <a href="listar_ofertas.php" class="btn btn-secondary">⬅ Volver</a>
     </main>
</body>

</html>