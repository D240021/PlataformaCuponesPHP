<?php

require_once 'LogicaNegocio/UsuarioBusiness.php';
require_once 'Dominio/Usuario.php';

// Crear una instancia de UsuarioBusiness
$usuarioBusiness = new UsuarioBusiness();

// Crear un nuevo usuario para la prueba
$usuario = new Usuario(null, "Juan", "Perez", "123456789", "1990-01-01", "juan.perez@example.com", "contrasena123");

try {
    // Prueba de creación de usuario
    echo "Creando usuario...\n";
    $usuarioBusiness->crearUsuario($usuario);

    // Prueba de obtención de todos los usuarios
    echo "Obteniendo todos los usuarios...\n";
    $usuarios = $usuarioBusiness->obtenerUsuarios();
    print_r($usuarios);

    // Prueba de obtención de un usuario por ID
    $usuarioCreado = end($usuarios); // Asumimos que el usuario creado es el último en la lista
    $idUsuarioCreado = $usuarioCreado['id'];
    echo "Obteniendo usuario con ID: $idUsuarioCreado...\n";
    $usuarioObtenido = $usuarioBusiness->obtenerUsuario($idUsuarioCreado);
    print_r($usuarioObtenido);

    // Prueba de actualización de usuario
    echo "Actualizando usuario con ID: $idUsuarioCreado...\n";
    $usuarioObtenido['nombre'] = "Juan Actualizado";
    $usuarioActualizado = new Usuario(
        $usuarioObtenido['id'],
        $usuarioObtenido['nombre'],
        $usuarioObtenido['apellidos'],
        $usuarioObtenido['cedula'],
        $usuarioObtenido['fecha_nacimiento'],
        $usuarioObtenido['correo'],
        $usuarioObtenido['contrasena']
    );
    $usuarioBusiness->actualizarUsuario($usuarioActualizado);

    // Verificar la actualización
    $usuarioObtenidoActualizado = $usuarioBusiness->obtenerUsuario($idUsuarioCreado);
    echo "Usuario actualizado:\n";
    print_r($usuarioObtenidoActualizado);



} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
