<?php
    namespace Tema05\Ejercicio0304\Modelo;
    use PDO, PDOException;
    require_once ("Usuario.php");
    
    /**
     * Clase ModeloUsuario con las funciones de conexion a la BBDD, CRUD y demas
     */
    class ModeloUsuario {
        /**
         * Funcion encargada de realizar la consulta a la base de datos
         * 
         * $sql -> sentencia a ejecutar
         */
        public static function consulta(string $sql) {
            [$host,$usuario,$passwd,$bd]=['localhost','licitesp','12345678','licitesp'];
            try {
                $conexion = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $usuario, $passwd);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $resultado = $conexion->query($sql);
            } catch (PDOException $e) {
                exit($e);
            }
            return $resultado;
        }
        
        /**
         * Funcion encargada de insertar un usuario en la base de datos
         * 
         * $usuario -> usuario a insertar
         */
        public static function insertar(Usuario $usuario): bool {
            if ($usuario->email != null) {
                $resultado = self::consulta("SELECT * FROM usuario WHERE email='$usuario->email'");
                if ($resultado->fetch(PDO::FETCH_ASSOC) != null) {
                    return false;
                }
            }
            [$email, $nombre, $passwd, $localidad, $lugares_interes, $tipos_interes] = [$usuario->email, $usuario->nombre, $usuario->passwd, $usuario->localidad, $usuario->lugares_interes, $usuario->tipos_interes];
            $resultado = self::consulta("INSERT INTO usuario (email, nombre, passwd, localidad, lugares_interes, tipos_interes) VALUES('$email', '$nombre', '$passwd', '$localidad', '$lugares_interes', '$tipos_interes');");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de eliminar un usuario de la base de datos
         * 
         * $email -> email del usuario a eliminar
         */
        public static function eliminar(string $email): bool {
            $resultado = self::consulta("DELETE FROM usuario WHERE email=$email");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de actualizar un usuario en la base de datos
         * 
         * $usuario -> nuevos datos del usuario a actualizar
         */
        public static function actualizar(Usuario $usuario): bool {
            [$email, $nombre, $passwd, $localidad, $lugares_interes, $tipos_interes] = [$usuario->email, $usuario->nombre, $usuario->passwd, $usuario->localidad, $usuario->lugares_interes, $usuario->tipos_interes];
            $resultado = self::consulta("UPDATE usuario SET nombre='$nombre', passwd='$passwd', localidad='$localidad', lugares_interes='$lugares_interes', tipos_interes='$tipos_interes' WHERE email='$email'");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de listar los usuarios de la base de datos
         */
        public static function listar(): array {
            $resultado = self::consulta("SELECT * FROM usuario");
            $lista = [];
            while ($usuario = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, Usuario::getUsuario($usuario));
            }
            return $lista;
        }
        
        /**
         * Funcion encargada de devolver el numero de usuarios existentes
         */
        public static function numUsuarios() {
            $resultado = self::consulta("SELECT count(*) as numUsuarios FROM usuario");
            $count = $resultado->fetch(PDO::FETCH_ASSOC);
            return intval($count['numUsuarios']);
        }
        
        /**
         * Funcion encargada de buscar y devolver un usuario concreto
         * 
         * $email -> email del usuario a buscar
         */
        public static function buscarUsuario($email) {
            $resultado = self::consulta("SELECT * FROM usuario WHERE email='$email'");
            $tmpUsuario = $resultado->fetch(PDO::FETCH_ASSOC);
            if ($tmpUsuario) {
                $usuario = Usuario::getUsuario($tmpUsuario);
                return $usuario;
            }
            return null;
        }
    }
    
?>