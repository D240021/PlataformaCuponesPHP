<?php

class ConexionBD {
    private static $instancia = null;
    private $conexion;

    private function __construct() {
        $host = 'localhost';
        $dbname = 'plataforma_cupones_db';
        $user = 'root'; 
        $pass = ''; 

        try {
            $this->conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            // Establecer el modo de error de PDO a excepción
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexión exitosa :)\n";
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    public function obtenerConexion() {
        return $this->conexion;
    }
}

?>
