<?php
    namespace Tema05\Ejercicio0304\Modelo;
    use PDO, PDOException;
    require_once ("Aviso.php");
    
    /**
     * Clase ModeloAviso con las funciones de conexion a la BBDD, CRUD y demas
     */
    class ModeloAviso {
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
         * Funcion encargada de insertar un aviso en la base de datos
         * 
         * $aviso -> aviso a insertar
         */
        public static function insertar(Aviso $aviso): bool {
            if ($aviso->id != null) {
                $resultado = self::consulta("SELECT * FROM aviso WHERE id=$aviso->id");
                if ($resultado->fetch(PDO::FETCH_ASSOC) != null) {
                    return false;
                }
            }
            [$id, $licitacion, $usuario, $leido] = [$aviso->id, $aviso->licitacion, $aviso->usuario, $aviso->leido];
            $resultado = self::consulta("INSERT INTO aviso (id, licitacion, usuario, leido) VALUES($id, '$licitacion', '$usuario', $leido);");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de eliminar un aviso de la base de datos
         * 
         * $id -> id del aviso a eliminar
         */
        public static function eliminar(string $id): bool {
            $resultado = self::consulta("DELETE FROM aviso WHERE id=$id");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de actualizar un aviso en la base de datos
         * 
         * $aviso -> nuevos datos del aviso a actualizar
         */
        public static function actualizar(Aviso $aviso): bool {
            [$id, $licitacion, $usuario, $leido] = [$aviso->id, $aviso->licitacion, $aviso->usuario, $aviso->leido];
            $resultado = self::consulta("UPDATE aviso SET licitacion=$licitacion, usuario=$usuario, leido=$leido WHERE id=$id");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de listar los avisos de la base de datos
         * 
         * $email -> email del usuario del que listar los avisos
         */
        public static function listar($email): array {
            $resultado = self::consulta("SELECT * FROM aviso WHERE usuario='$email'");
            $lista = [];
            while ($aviso = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $aviso);
            }
            return $lista;
        }
        
        /**
         * Funcion encargada de devolver el numero de avisos existentes
         */
        public static function numAvisos() {
            $resultado = self::consulta("SELECT count(*) as numAvisos FROM avisos");
            $count = $resultado->fetch(PDO::FETCH_ASSOC);
            return intval($count['numAvisos']);
        }
        
        /**
         * Funcion encargada de buscar y devolver un aviso en concreto
         * 
         * $id -> id del aviso a buscar
         */
        public static function buscarAviso($id) {
            $resultado = self::consulta("SELECT * FROM aviso WHERE id=$id");
            $aviso = Aviso::getAviso($resultado->fetch(PDO::FETCH_ASSOC));
            return $aviso;
        }
    }
    
?>