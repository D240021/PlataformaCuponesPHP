<?php

require_once __DIR__ . '/../Conexion/Conexion.php';
require_once __DIR__ . '/../Dominio/Usuario.php';

class UsuarioData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function obtenerUsuarioPorCedulaYContrasenna($username, $contrasenna) {
        $sql = "SELECT * FROM usuario WHERE username = ? AND contrasena = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$username, $contrasenna]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
