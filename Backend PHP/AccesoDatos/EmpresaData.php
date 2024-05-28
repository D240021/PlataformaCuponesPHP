<?php

class EmpresaData {
    private $conexion;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'plataforma_cupones_db';
        $user = 'root'; 
        $pass = ''; 

        try {
            $this->conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            // Establecer el modo de error de PDO a excepción
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexión exitosa";
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function crearEmpresa($empresa) {
        $sql = "INSERT INTO empresa (nombre, direccion, cedula, fecha_creacion, correo, telefono) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$empresa->nombre, $empresa->direccion, $empresa->cedula, $empresa->fecha_creacion, $empresa->correo, $empresa->telefono]);
    }
}

?>
