<?php
    namespace Tema05\Ejercicio0304\Controlador;
    use Tema05\Ejercicio0304\Controlador\ControladorLicitacion;
    require_once ("ControladorLicitacion.php");
    
    $listaLicitaciones = [];
    $numPag = 1;
    $tamPag = 10;
    $ultPag = ceil(ControladorLicitacion::numLicitaciones() / $tamPag);
    
    $listaLicitaciones = ControladorLicitacion::listar($numPag, $tamPag);
    
    if (isset($_GET['pag']) && $_GET['pag'] <= $ultPag && $_GET['pag'] >= 1) {
        $numPag = intval($_GET['pag']);
        $listaLicitaciones = ControladorLicitacion::listar($numPag, $tamPag);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    require_once ("../Vista/VistaLicitacion.php");
?>