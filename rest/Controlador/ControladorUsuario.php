<?php
    namespace Tema05\Ejercicio0304\Controlador;
    require_once("headers.php");
    require_once ("../Modelo/Usuario.php");
    use Tema05\Ejercicio0304\Modelo\ModeloUsuario;
    use Tema05\Ejercicio0304\Modelo\Usuario;
    require_once ("../Modelo/ModeloUsuario.php");
                

    /**
     * ------------------------------------------------------------------------------------
     * Controlador encargado de recibir las peticiones del cliente respecto a los usuarios
     * ------------------------------------------------------------------------------------
     */


    /**
     * Se encarga de realizar la peticion de registro, insertando un nuevo usuario en la base de datos
     */
    if (isset($_GET['registro'])) {
        $data = json_decode(file_get_contents("php://input"));
        $email = trim($data->email);
        $nombre = trim($data->nombre);
        $passwd = password_hash(trim($data->password), PASSWORD_DEFAULT);
        $localidad = trim($data->localidad);
        $lugares_interes = "";
        $tipos_interes = "";
        $usuario = new Usuario($email, $nombre, $passwd, $localidad, $lugares_interes, $tipos_interes);
        $resultado = ModeloUsuario::insertar($usuario);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }

    /**
     * Se encarga de la peticion de acceso, devolviendo los datos del usuario accedido o el error corespondiente 
     */
    if (isset($_GET['acceso'])) {
        $data = json_decode(file_get_contents("php://input"));
        $email = trim($data->email);
        $passwd = trim($data->password);
        $usuario = ModeloUsuario::buscarUsuario($email);

        if ($usuario) {
            //if ($passwd == $usuario->passwd) {
            if (password_verify($passwd, $usuario->passwd)) {
                echo '{
                    "email":"'.$usuario->email.'",
                    "nombre":"'.$usuario->nombre.'",
                    "passwd":"'.$usuario->passwd.'",
                    "localidad":"'.$usuario->localidad.'",
                    "lugares_interes":"'.$usuario->lugares_interes.'",
                    "tipos_interes":"'.$usuario->tipos_interes.'"
                }';
            } else {
                echo '{"error":"Contraseña incorrecta"}';
            }
        } else {
            echo '{"error":"El usuario no existe"}';
        }
    }

    /**
     * Se encarga de actualizar los datos del usuario en la base de datos
     */
    if (isset($_GET['actualizar'])) {
        $data = json_decode(file_get_contents("php://input"));
        $email = trim($data->email);
        $nombre = trim($data->nombre);
        $passwd = trim($data->password);
        $localidad = trim($data->localidad);
        $lugares_interes = $data->lugares_interes;
        $tipos_interes = $data->tipos_interes;
        $usuario = new Usuario($email, $nombre, $passwd, $localidad, $lugares_interes, $tipos_interes);
        $resultado = ModeloUsuario::actualizar($usuario);
        if ($resultado) {
            echo '{"respuesta": true}';
        } else {
            echo '{"respuesta": false}';
        }
    }
?>