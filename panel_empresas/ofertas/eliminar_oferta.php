<?php
$id = $_GET['id'] ?? null;
if (!$id) {
     echo "ID no especificado.";
     exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <title>Eliminar Oferta</title>
     <link rel="stylesheet" href="../Libreria/style.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
     <main class="container text-center mt-5">
          <h2 class="text-danger">¿Estás seguro de que deseas eliminar esta oferta?</h2>
          <form action="eliminar_oferta_procesar.php" method="POST" class="mt-3">
               <input type="hidden" name="id" value="<?= $id ?>">
               <button type="submit" class="btn btn-danger">Sí, eliminar</button>
               <a href="listar_ofertas.php" class="btn btn-secondary">Cancelar</a>
          </form>
     </main>
</body>

</html>