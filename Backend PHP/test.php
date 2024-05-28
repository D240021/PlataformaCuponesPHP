<?php

// Incluir la clase EmpresaBusiness y la clase Empresa del dominio
require_once 'LogicaNegocio/EmpresaBusiness.php';
require_once 'Dominio/Empresa.php';

try {
    $empresaBusiness = new EmpresaBusiness();


        $empresaBusiness->eliminarEmpresa(3);
        echo "Empresa eliminada exitosamente\n";


} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
