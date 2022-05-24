<?php
    namespace Tema05\Ejercicio0304\Controlador;
    require_once("headers.php");
    require_once ("../Modelo/Aviso.php");
    use Tema05\Ejercicio0304\Modelo\ModeloAviso;
    use Tema05\Ejercicio0304\Modelo\Aviso;
    require_once ("../Modelo/ModeloAviso.php");
                

    /**
     * ----------------------------------------------------------------------------------
     * Controlador encargado de recibir las peticiones del cliente respecto a los avisos
     * ----------------------------------------------------------------------------------
     */

    
    /**
     * Recibe las peticion de tipo GET listar, encargada de devolver todos los avisos de un usuario
     */
    if(isset($_GET['listar'])) {
        $email = $_GET['usuario'];
        $avisos = ModeloAviso::listar($email);
        echo json_encode($avisos);
    }

?>