<?php

require_once 'LogicaNegocio/TodoCuponBusiness.php';

// Crear una instancia de TodoCuponBusiness
$todoCuponBusiness = new TodoCuponBusiness();

try {
    // Prueba de obtención de todos los cupones
    echo "Obteniendo todos los cupones...\n";
    $cupones = $todoCuponBusiness->obtenerTodoCupones();
    echo json_encode($cupones, JSON_PRETTY_PRINT);
    
    // Prueba de obtención de un cupón por ID
    echo "Obteniendo un cupón por ID...\n";
    if (!empty($cupones) && isset($cupones[0]['idCupon'])) {
        $cuponId = $cupones[0]['idCupon'];
        $cuponArray = $todoCuponBusiness->obtenerTodoCuponID($cuponId);
        echo json_encode($cuponArray, JSON_PRETTY_PRINT);
    } else {
        echo "No se encontró ningún cupón para probar.\n";
    }

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
