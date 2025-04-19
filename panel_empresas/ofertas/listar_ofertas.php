<?php
session_start();
require_once '../../bd/config.php';

if (!isset($_SESSION['id_empresa'])) {
     echo "No ha iniciado sesión como empresa.";
     exit;
}

$id_empresa = $_SESSION['id_empresa'];

try {
     $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $stmt = $conn->prepare("SELECT * FROM Ofertas WHERE id_empresa = :id_empresa ORDER BY fecha_publicacion DESC");
     $stmt->bindParam(':id_empresa', $id_empresa);
     $stmt->execute();
     $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
     die("Error al obtener las ofertas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <title>Mis Ofertas</title>
     <link rel="stylesheet" href="../../assets/style.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
     <main class="container my-4">
          <h1 class="text-primary text-center">Mis Ofertas de Empleo</h1>
          <a href="crear_oferta.html" class="btn btn-success mb-3">➕ Crear nueva oferta</a>
          <?php if (count($ofertas) > 0): ?>
               <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                         <tr>
                              <th>Título</th>
                              <th>Fecha de Publicación</th>
                              <th>Acciones</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php foreach ($ofertas as $oferta): ?>
                              <tr>
                                   <td><?= htmlspecialchars($oferta['titulo']) ?></td>
                                   <td><?= $oferta['fecha_publicacion'] ?></td>
                                   <td>
                                        <a href="editar_oferta.php?id=<?= $oferta['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                                        <a href="eliminar_oferta.php?id=<?= $oferta['id'] ?>" class="btn btn-danger btn-sm">🗑 Eliminar</a>
                                   </td>
                              </tr>
                         <?php endforeach ?>
                    </tbody>
               </table>
          <?php else: ?>
               <div class="alert alert-info">No hay ofertas registradas aún.</div>
          <?php endif ?>
     </main>
</body>

</html>