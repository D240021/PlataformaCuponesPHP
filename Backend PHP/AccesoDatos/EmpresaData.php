<?php

require_once 'Conexion/Conexion.php';

class EmpresaData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function crearEmpresa($empresa) {
        $sql = "INSERT INTO empresa (nombre, direccion, cedula, fecha_creacion, correo, telefono) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$empresa->nombre, $empresa->direccion, $empresa->cedula, $empresa->fecha_creacion, $empresa->correo, $empresa->telefono]);
        echo "Empresa creada exitosamente\n";
    }

    public function obtenerEmpresaID($id) {
        $sql = "SELECT * FROM empresa WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerEmpresas() {
        $sql = "SELECT * FROM empresa";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    

    public function actualizarEmpresa($empresa) {
        $sql = "UPDATE empresa SET nombre = ?, direccion = ?, cedula = ?, fecha_creacion = ?, correo = ?, telefono = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$empresa->nombre, $empresa->direccion, $empresa->cedula, $empresa->fecha_creacion, $empresa->correo, $empresa->telefono, $empresa->id]);
        echo "Empresa actualizada exitosamente\n";
    }

    public function eliminarEmpresa($id) {
        $sql = "DELETE FROM empresa WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        echo "Empresa eliminada exitosamente\n";
    }
}

?>
