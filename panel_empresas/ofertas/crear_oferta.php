<?php
require_once '../../bd/config.php';
session_start();

// Simulación para pruebas: si no hay sesión, usar empresa de prueba
if (!isset($_SESSION['id_empresa'])) {
     $_SESSION['id_empresa'] = 2; // ⚠️ Asegúrate de que la empresa con id_empresa = 1 exista en tu base de datos
}

echo "Método recibido: " . $_SERVER['REQUEST_METHOD'] . "<br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $titulo = $_POST['titulo'];
     $descripcion = $_POST['descripcion'];
     $requisitos = $_POST['requisitos'];
     $fecha_publicacion = $_POST['fecha_publicacion'];
     $id_empresa = $_SESSION['id_empresa'];

     try {
          $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = "INSERT INTO Ofertas (id_empresa, titulo, descripcion, requisitos, fecha_publicacion)
                VALUES (:id_empresa, :titulo, :descripcion, :requisitos, :fecha_publicacion)";

          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':id_empresa', $id_empresa);
          $stmt->bindParam(':titulo', $titulo);
          $stmt->bindParam(':descripcion', $descripcion);
          $stmt->bindParam(':requisitos', $requisitos);
          $stmt->bindParam(':fecha_publicacion', $fecha_publicacion);

          $stmt->execute();

          echo "✅ Oferta publicada correctamente.";
          // header("Location: ofertas_empleo.php");
          // exit;
     } catch (PDOException $e) {
          echo "❌ Error al crear la oferta: " . $e->getMessage();
     }
     header("Location: ofertas_empleo.html?success=1");
     exit;
} else {
     // Formulario de prueba
?>
     <h2>Crear Oferta</h2>
     <form method="POST">
          <label>Título:</label><br>
          <input type="text" name="titulo"><br>

          <label>Descripción:</label><br>
          <textarea name="descripcion"></textarea><br>

          <label>Requisitos:</label><br>
          <textarea name="requisitos"></textarea><br>

          <label>Fecha de Publicación:</label><br>
          <input type="date" name="fecha_publicacion"><br><br>

          <input type="submit" value="Crear Oferta">
     </form>
<?php
}
?>