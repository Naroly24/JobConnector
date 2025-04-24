<?php
if (!file_exists(__DIR__ . '/db_config.php')) {
    if (headers_sent()) {
        echo "<script>window.location.href='/Libreria/bd/instalador.php';</script>";
        exit;
    }
    header("Location: /Libreria/bd/instalador.php");
    exit;
}

require_once __DIR__ . '/db_config.php';

class conexion
{
    public $conexion;
    private static $instancia;

    public function __construct()
    {
        try {
            $this->conexion = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            // If database doesn't exist, redirect to installer
            if (strpos($e->getMessage(), 'Unknown database') !== false) {
                header("Location: /Libreria/bd/instalador.php");
                exit;
            }
            error_log("Error de conexión: " . $e->getMessage());
            die("Error de conexión a la base de datos. Por favor, verifica la configuración.");
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en consulta: " . $e->getMessage());
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    static function ejecutar($sql, $parametros = [])
    {
        try {
            $c = self::getInstancia()->conexion;
            $stmt = $c->prepare($sql);
            return $stmt->execute($parametros);
        } catch (PDOException $e) {
            error_log("Error al ejecutar consulta: " . $e->getMessage());
            die("Error al ejecutar la consulta: " . $e->getMessage());
        }
    }

    static function select($sql, $parametros = [])
    {
        try {
            $c = self::getInstancia()->conexion;
            $stmt = $c->prepare($sql);
            $stmt->execute($parametros);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en consulta SELECT: " . $e->getMessage());
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
            error_log("Error al insertar datos: " . $e->getMessage());
            die("Error al insertar datos: " . $e->getMessage());
        }
    }

    static function beginTransaction()
    {
        try {
            self::getInstancia()->conexion->beginTransaction();
        } catch (PDOException $e) {
            error_log("Error al iniciar transacción: " . $e->getMessage());
            die("Error al iniciar transacción: " . $e->getMessage());
        }
    }

    static function commit()
    {
        try {
            self::getInstancia()->conexion->commit();
        } catch (PDOException $e) {
            error_log("Error al confirmar transacción: " . $e->getMessage());
            die("Error al confirmar transacción: " . $e->getMessage());
        }
    }

    static function rollback()
    {
        try {
            self::getInstancia()->conexion->rollBack();
        } catch (PDOException $e) {
            error_log("Error al deshacer transacción: " . $e->getMessage());
            die("Error al deshacer transacción: " . $e->getMessage());
        }
    }
}