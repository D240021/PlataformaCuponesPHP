<?php

require_once __DIR__ . '/../AccesoDatos/PromocionData.php';
require_once __DIR__ . '/../Dominio/Promocion.php';

class PromocionBusiness {
    private $promocionData;

    public function __construct() {
        $this->promocionData = new PromocionData();
    }

    public function crearPromocion($promocion) {
        if (empty($promocion->cupon_id) || empty($promocion->descripcion) || empty($promocion->fecha_inicio) || empty($promocion->fecha_vencimiento) || empty($promocion->descuento)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $this->promocionData->crearPromocion($promocion);
    }

    public function obtenerPromocion($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de promoción inválido");
        }

        return $this->promocionData->obtenerPromocionID($id);
    }

    public function obtenerPromociones() {
        return $this->promocionData->obtenerPromociones();
    }

    public function obtenerPromocionesCuponID($cupon_id) {
        return $this->promocionData->obtenerPromocionesCuponID($cupon_id);
    }

    public function actualizarPromocion($promocion) {
        if (empty($promocion->id) || !is_numeric($promocion->id)) {
            throw new Exception("ID de promoción inválido");
        }

        if (empty($promocion->cupon_id) || empty($promocion->descripcion) || empty($promocion->fecha_inicio) || empty($promocion->fecha_vencimiento) || empty($promocion->descuento)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $this->promocionData->actualizarPromocion($promocion);
    }

    public function eliminarPromocion($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de promoción inválido");
        }

        $this->promocionData->eliminarPromocion($id);
    }
}

?>
