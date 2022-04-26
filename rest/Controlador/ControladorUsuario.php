<?php
    namespace Tema05\Ejercicio0304\Controlador;
    require_once ("../Modelo/Usuario.php");
    use Tema05\Ejercicio0304\Modelo\ModeloUsuario;
    use Tema05\Ejercicio0304\Modelo\Usuario;
    require_once ("../Modelo/ModeloUsuario.php");
                
    class ControladorUsuario {
        
        public function listar(int $numPag=1, int $tamPag=10):array {
            return ModeloUsuario::listar($numPag, $tamPag);
        }
        
        public function numUsuarios() {
            return ModeloUsuario::numUsuarios();
        }
    }

    if (isset($_POST['operacion']) && $_POST['operacion'] == 'obtener') {
        $id = $_POST['id'];
        $usuario = Usuario::buscarUsuario($id);
        return $usuario;
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "insertar") {
        $atributos = [
            "id" => intval($_POST['id']),
            "nombre" => $_POST['nombre'],
            "password" => $_POST['password'],
            "email" => $_POST['email'],
            "localidad" => $_POST['localidad'],
            "localidades_interes" => $_POST['localidades_interes'],
            "sectores_interes" => $_POST['sectores_interes']
        ];
        $usuario = Usuario::getUsuario($atributos);
        $resultado = ModeloUsuario::insertar($usuario);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
    
    if (isset($_POST['operacion']) && $_POST['operacion'] == "eliminar") {
        $id = $_POST['id'];
        $resultado = ModeloUsuario::eliminar($id);
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
        $usuario = Usuario::getUsuario($atributos);
        $resultado = ModeloUsuario::actualizar($usuario);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
?>