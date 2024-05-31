<?php

require_once 'LogicaNegocio/PromocionBusiness.php';
require_once 'Dominio/Promocion.php';

// Crear una instancia de PromocionBusiness
$promocionBusiness = new PromocionBusiness();

try {
    // Prueba de creación de una promoción
    echo "Creando una nueva promoción...\n";
    $nuevaPromocion = new Promocion(null, 10, 'Promocion Test', '2024-01-01', '2024-12-31', 20);
    $promocionBusiness->crearPromocion($nuevaPromocion);
    echo "Promoción creada exitosamente.\n";

    // Prueba de obtención de todas las promociones
    echo "Obteniendo todas las promociones...\n";
    $promociones = $promocionBusiness->obtenerPromociones();
    echo json_encode($promociones, JSON_PRETTY_PRINT);
    
    // Prueba de obtención de una promoción por ID
    echo "Obteniendo una promoción por ID...\n";
    $promocionId = $promociones[0]['id']; // Asumiendo que la primera promoción en la lista es la que acabamos de crear
    $promocionArray = $promocionBusiness->obtenerPromocion($promocionId);
    $promocion = new Promocion(
        $promocionArray['id'], 
        $promocionArray['cupon_id'], 
        $promocionArray['descripcion'], 
        $promocionArray['fecha_inicio'], 
        $promocionArray['fecha_vencimiento'], 
        $promocionArray['descuento']
    );
    echo json_encode($promocionArray, JSON_PRETTY_PRINT);
    
    // Prueba de actualización de una promoción
    echo "Actualizando la promoción...\n";
    $promocion->descripcion = 'Promocion Actualizada';
    $promocionBusiness->actualizarPromocion($promocion);
    echo "Promoción actualizada exitosamente.\n";
    


} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
