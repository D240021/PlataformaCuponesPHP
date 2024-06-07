<?php

require_once __DIR__ . '/../AccesoDatos/CuponData.php';
require_once __DIR__ . '/../Dominio/Cupon.php';

class CuponBusiness {
    private $cuponData;

    public function __construct() {
        $this->cuponData = new CuponData();
    }

    public function crearCupon($cupon) {
        if (empty($cupon->codigo) || empty($cupon->nombre) || empty($cupon->precio) || empty($cupon->empresa_id) || empty($cupon->estado) || empty($cupon->imagen) || empty($cupon->categoria_id) || empty($cupon->fecha_inicio) || empty($cupon->fecha_vencimiento) || empty($cupon->fecha_creacion)) {
            throw new Exception("Todos los campos son obligatorios");
        }

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

    public function obtenerCuponesPorEmpresa($empresa_id) {
        return $this->cuponData->obtenerCuponesPorEmpresa($empresa_id);
    }

    public function obtenerCuponesNoVencidos() {
        return $this->cuponData->obtenerCuponesNoVencidos();
    }

    public function actualizarCupon($cupon) {
        if (empty($cupon->id) || !is_numeric($cupon->id)) {
            throw new Exception("ID de cupón inválido");
        }

        if (empty($cupon->codigo) || empty($cupon->nombre) || empty($cupon->precio) || empty($cupon->empresa_id) || empty($cupon->estado) || empty($cupon->imagen) || empty($cupon->categoria_id) || empty($cupon->fecha_inicio) || empty($cupon->fecha_vencimiento) || empty($cupon->fecha_creacion)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $this->cuponData->actualizarCupon($cupon);
    }

    public function actualizarCupones($cupones) {
        foreach ($cupones as $cupon) {
            $this->actualizarCupon($cupon);
        }
    }

    public function eliminarCupon($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de cupón inválido");
        }

        $this->cuponData->eliminarCupon($id);
    }
}

?>
