<?php
    namespace Tema05\Ejercicio0304\Controlador;
    require_once("headers.php");
    require_once ("../Modelo/Licitacion.php");
    require_once ("../Modelo/Aviso.php");
    require_once ("../Modelo/Usuario.php");
    use Tema05\Ejercicio0304\Modelo\ModeloLicitacion;
    use Tema05\Ejercicio0304\Modelo\Licitacion;
    use Tema05\Ejercicio0304\Modelo\ModeloAviso;
    use Tema05\Ejercicio0304\Modelo\Aviso;
    use Tema05\Ejercicio0304\Modelo\ModeloUsuario;
    use Tema05\Ejercicio0304\Modelo\Usuario;
    require_once ("../Modelo/ModeloLicitacion.php");
    require_once ("../Modelo/ModeloAviso.php");
    require_once ("../Modelo/ModeloUsuario.php");
                

    /**
     * ----------------------------------------------------------------------------------------
     * Controlador encargado de recibir las peticiones del cliente respecto a las licitaciones
     * ----------------------------------------------------------------------------------------
     */


    /**
     * Funcion encargada de insertar los avisos tras insertar una nueva licitacion
     * Comprueba si el tipo o lugar de la licitacion coincide con los interes de los usuarios
     * 
     * $licitacion -> licitacion insertada
     */
    function insertarAvisos($licitacion) {
        $tipo = $licitacion->tipo;
        $lugar = $licitacion->lugar_ejecucion;
        $usuarios = ModeloUsuario::listar();
        foreach ($usuarios as $usuario) {
            $lugares_interes = explode(",", $usuario->lugares_interes);
            $tipos_interes = explode(",", $usuario->tipos_interes);
            $insertar = false;
            if (count($lugares_interes) > 0) {
                foreach ($lugares_interes as $lugar_interes) {
                    if ($lugar == $lugar_interes) {
                        $insertar = true;
                    }
                }
            }
            if (count($tipos_interes) > 0) {
                foreach ($tipos_interes as $tipo_interes) {
                    if ($tipo == $tipo_interes) {
                        $insertar = true;
                    }
                }
            }
            if ($insertar) {
                ModeloAviso::insertar(new Aviso("NULL", $licitacion->expediente, $usuario->email, 0));
            }
        }
    }

    /**
     * Recibe las peticiones de tipo GET realizadas y comprueba y ejecuta la accion a realizar
     * 
     * listar -> lista las licitaciones paginadas
     * expediente -> devuele una licitacion en concreto
     * lugares -> devuelve los diferentes lugares de ejecucion existentes
     * tipos -> devuelves los diferentes tipos de licitacion existentes
     * filtrar -> devuelve una lista de licitaciones filtradas
     * maxPag -> devuelve la ultima pagina de la paginacion 
     */
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['listar'])) {
            $numPag = $_GET['pag'];
            $tamPag = $_GET['tamPag'];
            $licitaciones = ModeloLicitacion::listar($numPag, $tamPag);
            echo json_encode($licitaciones);
        } else if (isset($_GET['expediente'])) {
            $expediente = $_GET['expediente'];
            $licitacion = ModeloLicitacion::buscarLicitacion($expediente);
            echo json_encode($licitacion);
        } else if (isset($_GET['lugares'])) {
            $resultado = ModeloLicitacion::obtenerLugares();
            echo json_encode($resultado);
        } else if (isset($_GET['tipos'])) {
            $resultado = ModeloLicitacion::obtenerTipos();
            echo json_encode($resultado);
        } else if (isset($_GET['filtrar'])) {
            $numPag = $_GET['pag'];
            $tamPag = $_GET['tamPag'];
            $filtros = json_decode($_GET['filtros']); 
            $result = ModeloLicitacion::listarFiltrado($filtros, $numPag, $tamPag);
            echo json_encode($result);
        } else if (isset($_GET['maxPag'])) {
            $tamPag = $_GET['tamPag'];
            $ultPag = ceil(ModeloLicitacion::numLicitaciones() / $tamPag);
            echo $ultPag;
        } else {
            $response = array("mensaje" => "Operación inválida");
            echo json_encode($response);
        }
    }

    /**
     * Recibe las peticiones de tipo POST del cliente e inserta las licitaciones recibidas
     */
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'));
        $body = file_get_contents('php://input');
        $datos = json_encode($body);
        $count = 0;
        foreach (json_decode($data->data) as $dato) {
            $licitacion = new Licitacion($dato->expediente, $dato->organo_contratacion, $dato->objeto_contrato, $dato->valor_estimado, $dato->tipo, $dato->lugar_ejecucion, $dato->plazo, $dato->enlace);
            $result = ModeloLicitacion::insertar($licitacion);
            
            if (!$result) {
                $count++;
            } else {
                insertarAvisos($licitacion);
            }
        }
        if ($count > 0) {
            echo "Han ocurrido errores en $count insercion/es";
        }else {
            echo "Insercion correcta";
        }
    }


    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    }
    
?>