<?php

require_once __DIR__ . '/../Conexion/Conexion.php';
class CuponData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function crearCupon($cupon) {
        $sql = "INSERT INTO cupon (codigo, nombre, precio, empresa_id, estado, imagen, tipo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$cupon->codigo, $cupon->nombre, $cupon->precio, $cupon->empresa_id, $cupon->estado, $cupon->imagen, $cupon->tipo]);
    }

    public function obtenerCuponID($id) {
        $sql = "SELECT * FROM cupon WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerCupones() {
        $sql = "SELECT * FROM cupon";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    

    public function actualizarCupon($cupon) {
        $sql = "UPDATE cupon SET codigo = ?, nombre = ?, precio = ?, empresa_id = ?, estado = ?, imagen = ?, tipo = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$cupon->codigo, $cupon->nombre, $cupon->precio, $cupon->empresa_id, $cupon->estado, $cupon->id, $cupon->imagen, $cupon->tipo]);
    }

    public function eliminarCupon($id) {
        $sql = "DELETE FROM cupon WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
    }
}

?>
