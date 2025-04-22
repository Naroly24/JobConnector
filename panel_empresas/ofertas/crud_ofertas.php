<?php
require_once __DIR__ . '/../../Libreria/bd/conexion.php';

// Crear oferta
function crearOferta($datos)
{
     try {
          $sql = "INSERT INTO Ofertas (id_empresa, titulo, descripcion, requisitos, fecha_publicacion)
                VALUES (:id_empresa, :titulo, :descripcion, :requisitos, :fecha_publicacion)";
          return conexion::ejecutar($sql, $datos);
     } catch (PDOException $e) {
          error_log("❌ Error al crear oferta: " . $e->getMessage());
          return false;
     }
}

// Listar ofertas de una empresa
function listarOfertas($id_empresa)
{
     try {
          $sql = "SELECT * FROM Ofertas WHERE id_empresa = :id_empresa ORDER BY fecha_publicacion DESC";
          return conexion::consulta($sql, [':id_empresa' => $id_empresa]);
     } catch (PDOException $e) {
          error_log("❌ Error al cargar ofertas: " . $e->getMessage());
          return [];
     }
}

// Obtener oferta por ID
function verOferta($id_oferta, $id_empresa)
{
     try {
          $sql = "SELECT * FROM Ofertas WHERE id_oferta = :id_oferta AND id_empresa = :id_empresa";
          return conexion::consulta($sql, [
               ':id_oferta' => $id_oferta,
               ':id_empresa' => $id_empresa
          ])[0] ?? null;
     } catch (PDOException $e) {
          error_log("❌ Error al obtener oferta: " . $e->getMessage());
          return null;
     }
}
// Eliminar oferta
function eliminarOferta($id_oferta, $id_empresa)
{
     try {
          $sql = "DELETE FROM Ofertas WHERE id_oferta = :id_oferta AND id_empresa = :id_empresa";
          return conexion::ejecutar($sql, [
               ':id_oferta' => $id_oferta,
               ':id_empresa' => $id_empresa
          ]);
     } catch (PDOException $e) {
          error_log("❌ Error al eliminar oferta: " . $e->getMessage());
          return false;
     }
}

// Actualizar oferta
function actualizarOferta($data)
{
     try {
          $sql = "UPDATE Ofertas SET titulo = :titulo, descripcion = :descripcion, requisitos = :requisitos
                WHERE id_oferta = :id_oferta AND id_empresa = :id_empresa";
          return conexion::ejecutar($sql, $data);
     } catch (PDOException $e) {
          error_log("❌ Error al actualizar oferta: " . $e->getMessage());
          return false;
     }
}