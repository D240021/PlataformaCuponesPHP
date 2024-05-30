<?php

class Cupon {
    public $id;
    public $codigo;
    public $nombre;
    public $precio;
    public $empresa_id;
    public $estado;
    public $imagen;
    public $tipo;
    
    public function __construct($id, $codigo, $nombre, $precio, $empresa_id, $estado, $imagen, $tipo) {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->empresa_id = $empresa_id;
        $this->estado = $estado;
        $this->imagen = $imagen;
        $this->tipo = $tipo;
    }
}
