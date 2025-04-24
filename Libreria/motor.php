<?php
include_once __DIR__ . '/bd/conexion.php';

class Motor
{
     public static function getConnection()
     {
          return conexion::getInstancia()->conexion;
     }
}
