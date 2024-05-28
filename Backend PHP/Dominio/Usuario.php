<?php

class Usuario {
    public $id;
    public $nombre;
    public $apellidos;
    public $cedula;
    public $fecha_nacimiento;
    public $correo;
    public $contrasena;
    
    public function __construct($id, $nombre, $apellidos, $cedula, $fecha_nacimiento, $correo, $contrasena) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->cedula = $cedula;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
    }
}
