<?php

require_once __DIR__ . '/../Conexion/Conexion.php';

class PromocionData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function crearPromocion($promocion) {
        $sql = "INSERT INTO promocion (cupon_id, descripcion, fecha_inicio, fecha_vencimiento, descuento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$promocion->cupon_id, $promocion->descripcion, $promocion->fecha_inicio, $promocion->fecha_vencimiento, $promocion->descuento]);
    }

    public function obtenerPromocionID($id) {
        $sql = "SELECT * FROM promocion WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPromociones() {
        $sql = "SELECT * FROM promocion";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarPromocion($promocion) {
        $sql = "UPDATE promocion SET cupon_id = ?, descripcion = ?, fecha_inicio = ?, fecha_vencimiento = ?, descuento = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$promocion->cupon_id, $promocion->descripcion, $promocion->fecha_inicio, $promocion->fecha_vencimiento, $promocion->descuento, $promocion->id]);
    }

    public function eliminarPromocion($id) {
        $sql = "DELETE FROM promocion WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
    }
}

?>
