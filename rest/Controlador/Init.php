<?php
    namespace Tema05\Ejercicio0304\Controlador;
    use Tema05\Ejercicio0304\Controlador\ControladorProducto;
    require_once ("ControladorProducto.php");
    
    $listaProductos = [];
    $numPag = 1;
    $tamPag = 10;
    $ultPag = ceil(ControladorProducto::numProductos() / $tamPag);
    
    $listaProductos = ControladorProducto::listar($numPag, $tamPag);
    
    if (isset($_GET['pag']) && $_GET['pag'] <= $ultPag && $_GET['pag'] >= 1) {
        $numPag = intval($_GET['pag']);
        $listaProductos = ControladorProducto::listar($numPag, $tamPag);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    require_once ("../Vista/VistaProducto.php");
?>