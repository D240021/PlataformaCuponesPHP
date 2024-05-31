<?php

require_once __DIR__ . '/../Conexion/Conexion.php';

class TodoCuponData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function obtenerTodoCupones() {
        $sql = "SELECT cupon.*, empresa.*, promocion.* 
                FROM cupon 
                LEFT JOIN empresa ON cupon.empresa_id = empresa.id
                LEFT JOIN promocion ON cupon.id = promocion.cupon_id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTodoCuponID($id) {
        $sql = "SELECT cupon.*, empresa.*, promocion.* 
                FROM cupon 
                LEFT JOIN empresa ON cupon.empresa_id = empresa.id
                LEFT JOIN promocion ON cupon.id = promocion.cupon_id
                WHERE cupon.id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
