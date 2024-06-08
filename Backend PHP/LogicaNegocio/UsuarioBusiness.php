<?php

require_once __DIR__ . '/../AccesoDatos/UsuarioData.php';
require_once __DIR__ . '/../Dominio/Usuario.php';

class UsuarioBusiness {
    private $usuarioData;

    public function __construct() {
        $this->usuarioData = new UsuarioData();
    }

    public function autenticarUsuario($username, $contrasenna) {
        if (empty($username) || empty($contrasenna)) {
            throw new Exception("Cédula y contraseña son obligatorios");
        }
    
        $usuario = $this->usuarioData->obtenerUsuarioPorCedulaYContrasenna($username, $contrasenna);
        if ($usuario === false) {
            throw new Exception("Usuario o contraseña incorrectos");
        }
        
        return $usuario;
    }   
}

?>
