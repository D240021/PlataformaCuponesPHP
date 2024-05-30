<?php

require_once __DIR__ . '/../AccesoDatos/UsuarioData.php';
require_once __DIR__ . '/../Dominio/Usuario.php';

class UsuarioBusiness {
    private $usuarioData;

    public function __construct() {
        $this->usuarioData = new UsuarioData();
    }

    public function crearUsuario($usuario) {
        if (empty($usuario->nombre) || empty($usuario->apellidos) || empty($usuario->cedula) || empty($usuario->fecha_nacimiento) || empty($usuario->correo) || empty($usuario->contrasena)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $this->usuarioData->crearUsuario($usuario);
    }

    public function obtenerUsuario($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de usuario inválido");
        }

        return $this->usuarioData->obtenerUsuarioID($id);
    }

    public function obtenerUsuarios() {
        return $this->usuarioData->obtenerUsuarios();
    }

    public function actualizarUsuario($usuario) {
        if (empty($usuario->id) || !is_numeric($usuario->id)) {
            throw new Exception("ID de usuario inválido");
        }

        if (empty($usuario->nombre) || empty($usuario->apellidos) || empty($usuario->cedula) || empty($usuario->fecha_nacimiento) || empty($usuario->correo) || empty($usuario->contrasena)) {
            throw new Exception("Todos los campos son obligatorios");
        }
        
        $this->usuarioData->actualizarUsuario($usuario);
    }

    public function eliminarUsuario($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de usuario inválido");
        }

        $this->usuarioData->eliminarUsuario($id);
    }
}

?>
