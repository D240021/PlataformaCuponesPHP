<?php

require_once 'Conexion/Conexion.php';
require_once 'Dominio/Usuario.php';

class UsuarioData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function crearUsuario($usuario) {
        $sql = "INSERT INTO usuario (nombre, apellidos, cedula, fecha_nacimiento, correo, contrasena) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario->nombre, $usuario->apellidos, $usuario->cedula, $usuario->fecha_nacimiento, $usuario->correo, $usuario->contrasena]);
        echo "Usuario creado exitosamente\n";
    }

    public function obtenerUsuarioID($id) {
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerUsuarios() {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function actualizarUsuario($usuario) {
        $sql = "UPDATE usuario SET nombre = ?, apellidos = ?, cedula = ?, fecha_nacimiento = ?, correo = ?, contrasena = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario->nombre, $usuario->apellidos, $usuario->cedula, $usuario->fecha_nacimiento, $usuario->correo, $usuario->contrasena, $usuario->id]);
        echo "Usuario actualizado exitosamente\n";
    }

    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        echo "Usuario eliminado exitosamente\n";
    }
}

?>
