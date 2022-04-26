<?php
    namespace Tema05\Ejercicio0304\Controlador;
    require_once ("../Modelo/Aviso.php");
    use Tema05\Ejercicio0304\Modelo\ModeloAviso;
    use Tema05\Ejercicio0304\Modelo\Aviso;
    require_once ("../Modelo/ModeloAviso.php");
                
    class ControladorAviso {
        
        public function listar(int $numPag=1, int $tamPag=10):array {
            return ModeloAviso::listar($numPag, $tamPag);
        }
        
        public function numAvisos() {
            return ModeloAviso::numAvisos();
        }
    }

    if (isset($_POST['operacion']) && $_POST['operacion'] == 'obtener') {
        $id = $_POST['id'];
        $aviso = Aviso::buscarAviso($id);
        return $aviso;
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "insertar") {
        $atributos = [
            "id" => intval($_POST['id']),
            "id_licitacion" => intval($_POST['id_licitacion']),
            "id_usuario" => intval($_POST['id_usuario']),
            "leido" => $_POST['leido']
        ];
        $aviso = Aviso::getAviso($atributos);
        $resultado = ModeloAviso::insertar($aviso);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "eliminar") {
        $id = $_POST['id'];
        $resultado = ModeloAviso::eliminar($id);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "actualizar") {
        $atributos = [
            "id" => intval($_POST['id']),
            "id_licitacion" => intval($_POST['id_licitacion']),
            "id_usuario" => intval($_POST['id_usuario']),
            "leido" => $_POST['leido']
        ];
        $aviso = Aviso::getAviso($atributos);
        $resultado = ModeloAviso::actualizar($aviso);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
?>