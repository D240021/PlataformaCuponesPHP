<?php

require_once 'AccesoDatos/CuponData.php';
require_once 'Dominio/Cupon.php';

class CuponBusiness {
    private $cuponData;

    public function __construct() {
        $this->cuponData = new CuponData();
    }

    public function crearCupon($cupon) {
        // Validaciones
        if (empty($cupon->codigo) || empty($cupon->nombre) || empty($cupon->precio) || empty($cupon->empresa_id) || empty($cupon->estado)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        // Llamada al método crearCupon de CuponData
        $this->cuponData->crearCupon($cupon);
    }

    public function obtenerCupon($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de cupón inválido");
        }

        return $this->cuponData->obtenerCuponID($id);
    }

    public function obtenerCupones() {
        return $this->cuponData->obtenerCupones();
    }

    public function actualizarCupon($cupon) {
        // Validaciones
        if (empty($cupon->id) || !is_numeric($cupon->id)) {
            throw new Exception("ID de cupón inválido");
        }

        if (empty($cupon->codigo) || empty($cupon->nombre) || empty($cupon->precio) || empty($cupon->empresa_id) || empty($cupon->estado)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $this->cuponData->actualizarCupon($cupon);
    }

    public function eliminarCupon($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de cupón inválido");
        }

        $this->cuponData->eliminarCupon($id);
    }
}

?>
