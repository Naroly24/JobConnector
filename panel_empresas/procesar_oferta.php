<?php
// Incluir la configuración para la base de datos
require_once 'config.php'; // Asegúrate de tener esta configuración con los datos de conexión

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Recibir los datos del formulario
     $titulo = $_POST['titulo'];
     $descripcion = $_POST['descripcion'];
     $requisitos = $_POST['requisitos'];
     $fecha_publicacion = $_POST['fecha_publicacion'];

     // Obtener el ID de la empresa (esto depende de la lógica de tu aplicación)
     // Aquí se asume que el ID de la empresa está guardado en la sesión del usuario que está logueado
     session_start();
     if (!isset($_SESSION['id_empresa'])) {
          echo "No se ha encontrado la empresa. Por favor, inicie sesión.";
          exit;
     }
     $id_empresa = $_SESSION['id_empresa'];

     // Conectar a la base de datos usando PDO
     try {
          $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
          // Configurar el modo de errores de PDO
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // Preparar la consulta SQL para insertar la oferta
          $sql = "INSERT INTO Ofertas (id_empresa, titulo, descripcion, requisitos, fecha_publicacion) 
                VALUES (:id_empresa, :titulo, :descripcion, :requisitos, :fecha_publicacion)";

          $stmt = $conn->prepare($sql);

          // Vincular los parámetros con los valores del formulario
          $stmt->bindParam(':id_empresa', $id_empresa);
          $stmt->bindParam(':titulo', $titulo);
          $stmt->bindParam(':descripcion', $descripcion);
          $stmt->bindParam(':requisitos', $requisitos);
          $stmt->bindParam(':fecha_publicacion', $fecha_publicacion);

          // Ejecutar la consulta
          $stmt->execute();

          // Redirigir o mostrar un mensaje de éxito
          echo "¡Oferta de empleo creada exitosamente!";
     } catch (PDOException $e) {
          echo "Error al crear la oferta: " . $e->getMessage();
     }
} else {
     echo "No se enviaron datos.";
}
