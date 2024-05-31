<?php

require_once __DIR__ . '/../Conexion/Conexion.php';

class EmpresaData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function crearEmpresa($empresa) {
        $sql = "INSERT INTO empresa (nombre, direccion, cedula, fecha_creacion, correo, telefono, imagen, contrasenna, isHabilitado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$empresa->nombre, $empresa->direccion, $empresa->cedula, $empresa->fecha_creacion, $empresa->correo, $empresa->telefono, $empresa->imagen, $empresa->contrasenna, $empresa->isHabilitado]);
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
        $sql = "UPDATE empresa SET nombre = ?, direccion = ?, cedula = ?, fecha_creacion = ?, correo = ?, telefono = ?, imagen = ?, contrasenna = ?, isHabilitado = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$empresa->nombre, $empresa->direccion, $empresa->cedula, $empresa->fecha_creacion, $empresa->correo, $empresa->telefono, $empresa->imagen, $empresa->contrasenna, $empresa->isHabilitado, $empresa->id]);
    }

    public function actualizarContrasennaEmpresa($id, $contrasenna) {
        $sql = "UPDATE empresa SET contrasenna = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$contrasenna, $id]);
    }

    public function eliminarEmpresa($id) {
        $sql = "DELETE FROM empresa WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
    }
}

?>
