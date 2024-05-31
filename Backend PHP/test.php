<?php

require_once 'LogicaNegocio/TodoCuponBusiness.php';
require_once 'Dominio/Cupon.php';
require_once 'Dominio/Empresa.php';
require_once 'Dominio/Promocion.php';

$todoCuponBusiness = new TodoCuponBusiness();

try {
    // Prueba de obtención de todos los cupones
    echo "Obteniendo todos los cupones...\n";
    $cupones = $todoCuponBusiness->obtenerTodoCupones();

    
    // Prueba de obtención de un cupón por ID
    echo "Obteniendo un cupón por ID...\n";
    $cuponId = $cupones[0]['id']; // Asumiendo que el primer cupón en la lista es el que queremos obtener
    $cuponArray = $todoCuponBusiness->obtenerTodoCuponID(10);
    echo json_encode($cuponArray, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
