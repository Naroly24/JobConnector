<?php
include_once __DIR__ . '/db_config.php';

class conexion
{
     private static $instancia = null;
     public $conexion;

     private function __construct()
     {
          try {
               $this->conexion = new PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                    DB_USER,
                    DB_PASS,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
               );
          } catch (PDOException $e) {
               throw new Exception("Error de conexión: " . $e->getMessage());
          }
     }

     public static function getInstancia()
     {
          if (!isset(self::$instancia)) {
               self::$instancia = new conexion();
          }
          return self::$instancia;
     }

     static function consulta($sql, $parametros = [])
     {
          try {
               $c = self::getInstancia()->conexion;
               $stmt = $c->prepare($sql);
               $stmt->execute($parametros);

               $rsx = $stmt->fetchAll(PDO::FETCH_ASSOC);
               return $rsx;
          } catch (PDOException $e) {
               die("Error en la consulta: " . $e->getMessage());
          }
     }


     // Metodo para ejecutar consultas INSERT, UPDATE, DELETE
     static function ejecutar($sql, $parametros = [])
     {
          try {
               $c = self::getInstancia()->conexion;
               $stmt = $c->prepare($sql);
               return $stmt->execute($parametros);
          } catch (PDOException $e) {
               die("Error al ejecutar la consulta: " . $e->getMessage());
          }
     }

     //Metodo para SELECT que devuelva una sola fila
     static function select($sql, $parametros = [])
     {
          try {
               $c = self::getInstancia()->conexion;
               $stmt = $c->prepare($sql);
               $stmt->execute($parametros);

               $rsx = $stmt->fetch(PDO::FETCH_ASSOC);
               return $rsx;
          } catch (PDOException $e) {
               die("Error en la consulta SELECT: " . $e->getMessage());
          }
     }

     static function insert($sql, $parametros = [])
     {
          try {
               $c = self::getInstancia()->conexion;
               $stmt = $c->prepare($sql);
               $stmt->execute($parametros);

               return $c->lastInsertId();
          } catch (PDOException $e) {
               die("Error al insertar datos: " . $e->getMessage());
          }
     }
}