<?php

class Empresa {
    public $id;
    public $nombre;
    public $direccion;
    public $cedula;
    public $fecha_creacion;
    public $correo;
    public $telefono;
    
    public function __construct($id, $nombre, $direccion, $cedula, $fecha_creacion, $correo, $telefono) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->cedula = $cedula;
        $this->fecha_creacion = $fecha_creacion;
        $this->correo = $correo;
        $this->telefono = $telefono;
    }
}
