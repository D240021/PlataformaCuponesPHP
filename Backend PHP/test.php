<?php

require_once __DIR__ . '/LogicaNegocio/TodoCuponBusiness.php';

try {
    // Crear una instancia de TodoCuponBusiness
    $todoCuponBusiness = new TodoCuponBusiness();

    // Probar la obtención de todos los cupones
    echo "Obteniendo todos los cupones...\n";
    $cupones = $todoCuponBusiness->obtenerTodoCupones();
    echo json_encode($cupones, JSON_PRETTY_PRINT);

    // Probar la obtención de un cupón por ID
    echo "\nObteniendo cupón por ID...\n";
    $idCupon = 1; // Reemplaza con el ID del cupón a probar
    $cupon = $todoCuponBusiness->obtenerTodoCuponID($idCupon);
    echo json_encode($cupon, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
