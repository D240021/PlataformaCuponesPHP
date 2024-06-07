<?php

require_once 'LogicaNegocio/TodoCuponBusiness.php';
// require_once 'Dominio/TodoCupon.php'; // Comentado ya que no es necesario para la prueba actual

// Crear una instancia de TodoCuponBusiness
$todoCuponBusiness = new TodoCuponBusiness();

try {
    // Obtener todos los cupones
    echo "Obteniendo todos los cupones...\n";
    $cupones = $todoCuponBusiness->obtenerTodoCupones();
    //echo json_encode($cupones, JSON_PRETTY_PRINT);

    // Obtener un cupón específico por su ID
    echo "Obteniendo un cupón específico por su ID...\n";
    if (!empty($cupones)) {
        $cupon = end($cupones);
        $cuponId = $cupon['idCupon']; // Usar la clave correcta para obtener el ID del cupón
        $cuponDetalles = $todoCuponBusiness->obtenerTodoCuponID($cuponId);
        echo json_encode($cuponDetalles, JSON_PRETTY_PRINT);
    } else {
        echo "No se encontró ningún cupón para probar.\n";
    }

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
