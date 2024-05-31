<?php

require_once __DIR__ . '/../Conexion/Conexion.php';

class CategoriaData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function crearCategoria($categoria) {
        $sql = "INSERT INTO categoria (nombre) VALUES (?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$categoria->nombre]);
    }

    public function obtenerCategoriaID($id) {
        $sql = "SELECT * FROM categoria WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerCategorias() {
        $sql = "SELECT * FROM categoria";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarCategoria($categoria) {
        $sql = "UPDATE categoria SET nombre = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$categoria->nombre, $categoria->id]);
    }

    public function eliminarCategoria($id) {
        $sql = "DELETE FROM categoria WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
    }
}

?>
