<?php

class Usuario {
    public $id;
    public $username;
    public $contrasena;
    
    public function __construct($id, $username, $contrasena) {
        $this->id = $id;
        $this->username = $username;
        $this->contrasena = $contrasena;
    }
}
