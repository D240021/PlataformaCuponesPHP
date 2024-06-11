<?php

require_once __DIR__ . '/LogicaNegocio/PromocionBusiness.php';
require_once __DIR__ . '/Dominio/Promocion.php';

try {
    // Crear una instancia de PromocionBusiness
    $promocionBusiness = new PromocionBusiness();

    // Definir el ID del cupón al que se asociarán las promociones
    $idCupon = 13; // Reemplaza con el ID del cupón a probar

    // Probar la creación de una promoción
    echo "\nCreando una nueva promoción...\n";
    $nuevaPromocion = new Promocion(null, $idCupon, 'Nueva Promoción', '2024-06-01', '2024-06-30', 15, 'Activo');
    $promocionBusiness->crearPromocion($nuevaPromocion);
    echo "Promoción creada exitosamente\n";

    // Probar la obtención de promociones por cupón ID
    echo "\nObteniendo promociones por cupón ID...\n";
    $promociones = $promocionBusiness->obtenerPromocionesCuponID($idCupon);
    echo json_encode($promociones, JSON_PRETTY_PRINT);

    // Probar la actualización de una promoción
    echo "\nActualizando una promoción...\n";
    $promocionAActualizar = (object) $promociones[0];
    $promocionAActualizar->descripcion = 'Promoción Actualizada';
    $promocionBusiness->actualizarPromocion($promocionAActualizar);
    echo "Promoción actualizada exitosamente\n";

    // Probar la eliminación de una promoción
    echo "\nEliminando una promoción...\n";
    $idPromocionAEliminar = $promocionAActualizar->id;
    $promocionBusiness->eliminarPromocion($idPromocionAEliminar);
    echo "Promoción eliminada exitosamente\n";

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
