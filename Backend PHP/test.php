<?php

require_once 'LogicaNegocio/CuponBusiness.php';
require_once 'Dominio/Cupon.php';

// Crear una instancia de CuponBusiness
$cuponBusiness = new CuponBusiness();

try {


    // Actualizar el cupón
    echo "Actualizando el último cupón creado...\n";
        $cuponParaActualizar = new Cupon(
            26,
            "CODIGO123_MODIFICADO",   // Código modificado
            "Nombre del Cupón Modificado", // Nombre modificado
            150.75,                   // Precio modificado
            19,                       // empresa_id (sin cambios)
            "Inactivo",               // Estado modificado
            "http://example.com/imagen_modificada.jpg", // Imagen modificada
            3,                        // categoria_id (sin cambios)
            "2024-06-15",             // Fecha de inicio modificada
            "2024-12-15",             // Fecha de vencimiento modificada
            date("Y-m-d")             // Fecha de creación (sin cambios)
        );

        // Llamar al método actualizarCupon
        $cuponBusiness->actualizarCupon($cuponParaActualizar);
        echo "Cupón actualizado con éxito.\n";

        // Verificar que el cupón se haya actualizado correctamente
        echo "Obteniendo el cupón actualizado por ID...\n";
        $cuponActualizado = $cuponBusiness->obtenerCupon(26);
        echo json_encode($cuponActualizado, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
