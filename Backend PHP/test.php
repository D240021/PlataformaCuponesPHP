<?php

require_once 'LogicaNegocio/CuponBusiness.php';
require_once 'Dominio/Cupon.php';

// Crear una instancia de CuponBusiness
$cuponBusiness = new CuponBusiness();

try {

    // Prueba de obtención de todos los cupones
    echo "Obteniendo todos los cupones...\n";
    $cupones = $cuponBusiness->obtenerCupones();
    echo json_encode($cupones, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
