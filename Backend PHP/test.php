<?php

require_once 'LogicaNegocio/UsuarioBusiness.php';
// require_once 'Dominio/Usuario.php'; // Comentado ya que no es necesario para la prueba actual

// Crear una instancia de UsuarioBusiness
$usuarioBusiness = new UsuarioBusiness();

try {
    // Probar la autenticación de un usuario
    echo "Autenticando usuario...\n";
    $username = 'admin'; // Reemplaza con el nombre de usuario a probar
    $contrasena = 'admin'; // Reemplaza con la contraseña a probar
    
    $usuarioAutenticado = $usuarioBusiness->autenticarUsuario($username, $contrasena);
    echo json_encode($usuarioAutenticado, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
