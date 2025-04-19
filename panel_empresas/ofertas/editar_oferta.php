<?php
require_once '../../bd/config.php';

if (!isset($_GET['id'])) {
     echo "ID no proporcionado.";
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
     <title>Editar Oferta</title>
     <link rel="stylesheet" href="../../assets/style.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
     <main>
          <h1 class="text-center text-primary mt-4">Editar Oferta</h1>
          <form action="procesar_edicion.php" method="POST" class="container mt-4">
               <input type="hidden" name="id" value="<?= $oferta['id'] ?>">
               <div class="form-group mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($oferta['titulo']) ?>" required>
               </div>
               <div class="form-group mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($oferta['descripcion']) ?></textarea>
               </div>
               <div class="form-group mb-3">
                    <label class="form-label">Requisitos</label>
                    <textarea name="requisitos" class="form-control" required><?= htmlspecialchars($oferta['requisitos']) ?></textarea>
               </div>
               <div class="form-group mb-4">
                    <label class="form-label">Fecha de publicación</label>
                    <input type="date" name="fecha_publicacion" class="form-control" value="<?= $oferta['fecha_publicacion'] ?>" required>
               </div>
               <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
          </form>
     </main>
</body>

</html>