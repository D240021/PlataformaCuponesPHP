<?php

class Cupon {
    public $id;
    public $codigo;
    public $nombre;
    public $precio;
    public $empresa_id;
    public $estado;
    public $imagen;
    public $categoria_id;
    public $fecha_inicio;
    public $fecha_vencimiento;
    public $fecha_creacion;

    
    public function __construct($id, $codigo, $nombre, $precio, $empresa_id, $estado, $imagen, $categoria_id, $fecha_inicio, $fecha_vencimiento, $fecha_creacion) {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->empresa_id = $empresa_id;
        $this->estado = $estado;
        $this->imagen = $imagen;
        $this->categoria_id = $categoria_id;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->fecha_creacion = $fecha_creacion;
    }
}
