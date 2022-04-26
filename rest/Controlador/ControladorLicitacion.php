<?php
    namespace Tema05\Ejercicio0304\Controlador;
    require_once ("../Modelo/Licitacion.php");
    use Tema05\Ejercicio0304\Modelo\ModeloLicitacion;
    use Tema05\Ejercicio0304\Modelo\Licitacion;
    require_once ("../Modelo/ModeloLicitacion.php");
                
    class ControladorLicitacion {
        
        public function listar(int $numPag=1, int $tamPag=10):array {
            return ModeloLicitacion::listar($numPag, $tamPag);
        }
        
        public function numLicitaciones() {
            return ModeloLicitacion::numLicitaciones();
        }
    }

    if (isset($_POST['operacion']) && $_POST['operacion'] == 'obtener') {
        $id = $_POST['id'];
        $licitacion = Licitacion::buscarLicitacion($id);
        return $licitacion;
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "insertar") {
        $atributos = [
            "id" => $_POST['id'],
            "organo_contratacion" => $_POST['organo_contratacion'],
            "objeto_contrato" => $_POST['objeto_contrato'],
            "valor_estimado" => floatval($_POST['valor_estimado']),
            "tipo" => $_POST['tipo'],
            "lugar_ejecucion" => $_POST['lugar_ejecucion'],
            "plazo_ejecucion" => $_POST['plazo_ejecucion'],
            "url" => $_POST['url']
        ];
        $licitacion = Licitacion::getLicitacion($atributos);
        $resultado = ModeloLicitacion::insertar($licitacion);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "eliminar") {
        $id = $_POST['id'];
        $resultado = ModeloLicitacion::eliminar($id);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "actualizar") {
        $atributos = [
            "id" => $_POST['id'],
            "organo_contratacion" => $_POST['organo_contratacion'],
            "objeto_contrato" => $_POST['objeto_contrato'],
            "valor_estimado" => floatval($_POST['valor_estimado']),
            "tipo" => $_POST['tipo'],
            "lugar_ejecucion" => $_POST['lugar_ejecucion'],
            "plazo_ejecucion" => $_POST['plazo_ejecucion'],
            "url" => $_POST['url']
        ];
        $licitacion = Licitacion::getLicitacion($atributos);
        $resultado = ModeloLicitacion::actualizar($licitacion);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
?>