<?php
require_once __DIR__ . '/../../bd/config.php';

function conectarBD()
{
     try {
          $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $conn;
     } catch (PDOException $e) {
          die("Error de conexión: " . $e->getMessage());
     }
}

// Crear oferta
function crearOferta($datos)
{
     try {
          $conn = conectarBD();
          $stmt = $conn->prepare("INSERT INTO Ofertas (id_empresa, titulo, descripcion, requisitos, fecha_publicacion)
                                VALUES (:id_empresa, :titulo, :descripcion, :requisitos, :fecha_publicacion)");
          $stmt->execute([
               ':id_empresa' => $datos['id_empresa'],
               ':titulo' => $datos['titulo'],
               ':descripcion' => $datos['descripcion'],
               ':requisitos' => $datos['requisitos'],
               ':fecha_publicacion' => $datos['fecha_publicacion']
          ]);
          return true;
     } catch (PDOException $e) {
          error_log("❌ Error al crear oferta: " . $e->getMessage());
          return false;
     }
}

// Listar ofertas de una empresa
function listarOfertas($id_empresa)
{
     try {
          $conn = conectarBD();
          $stmt = $conn->prepare("SELECT * FROM Ofertas WHERE id_empresa = :id_empresa ORDER BY fecha_publicacion DESC");
          $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
          $stmt->execute();
          $ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $ofertas;

     } catch (PDOException $e) {
          echo "❌ Error al cargar ofertas: " . $e->getMessage();
          return []; // para evitar errores si falla
     }
}


// ❌ Eliminar oferta
function eliminarOferta($id_oferta, $id_empresa)
{
     try {
          $conn = conectarBD();
          $stmt = $conn->prepare("DELETE FROM Ofertas WHERE id_oferta = :id_oferta AND id_empresa = :id_empresa");
          $stmt->execute([
               ':id_oferta' => $id_oferta,
               ':id_empresa' => $id_empresa
          ]);
          return true;
     } catch (PDOException $e) {
          echo "❌ Error al eliminar oferta: " . $e->getMessage();
          return false;
     }
}

// 🔁 Actualizar oferta
function actualizarOferta($data)
{
     try {
          $conn = conectarBD();
          $stmt = $conn->prepare("UPDATE Ofertas SET titulo = :titulo, descripcion = :descripcion, requisitos = :requisitos
                                WHERE id_oferta = :id_oferta AND id_empresa = :id_empresa");
          $stmt->execute([
               ':titulo' => $data['titulo'],
               ':descripcion' => $data['descripcion'],
               ':requisitos' => $data['requisitos'],
               ':id_oferta' => $data['id_oferta'],
               ':id_empresa' => $data['id_empresa']
          ]);
          return true;
     } catch (PDOException $e) {
          echo "❌ Error al actualizar oferta: " . $e->getMessage();
          return false;
     }
}
