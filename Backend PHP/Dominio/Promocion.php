<?php

class Promocion {
    public $id;
    public $cupon_id;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_vencimiento;
    public $descuento;
    public $estado;
    
    public function __construct($id, $cupon_id, $descripcion, $fecha_inicio, $fecha_vencimiento, $descuento, $estado) {
        $this->id = $id;
        $this->cupon_id = $cupon_id;
        $this->descripcion = $descripcion;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->descuento = $descuento;
        $this->estado = $estado;
    }
}


?>
