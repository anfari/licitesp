<?php
    namespace Tema05\Ejercicio0304\Modelo;
    use PDO, PDOException;
    require_once ("Aviso.php");
    
    class ModeloAviso {
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
        
        public static function insertar(Aviso $aviso): bool {
            if ($aviso->id != null) {
                $resultado = self::consulta("SELECT * FROM aviso WHERE id=$aviso->id");
                if ($resultado->fetch(PDO::FETCH_ASSOC) != null) {
                    return false;
                }
            }
            [$id, $id_licitacion, $id_usuario, $leido] = [$aviso->id, $aviso->id_licitacion, $aviso->id_usuario, $aviso->leido];
            $resultado = self::consulta("INSERT INTO aviso VALUES($id, $id_licitacion, $id_usuario, $leido);");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function eliminar(string $id): bool {
            $resultado = self::consulta("DELETE FROM aviso WHERE if=$id");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function actualizar(Aviso $aviso): bool {
            [$id, $id_licitacion, $id_usuario, $leido] = [$aviso->id, $aviso->id_licitacion, $aviso->id_usuario, $aviso->leido];
            $resultado = self::consulta("UPDATE aviso SET id_licitacion=$id_licitacion, id_usuario=$id_usuario, leido=$leido WHERE id=$aviso->id");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function listar(int $numPag=1, int $tamPag=10): array {
            $inicio = ($numPag-1)*$tamPag;
            $resultado = self::consulta("SELECT * FROM aviso LIMIT $inicio, $tamPag");
            $lista = [];
            while ($aviso = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, Aviso::getAviso($aviso));
            }
            return $lista;
        }
        
        public static function numAvisos() {
            $resultado = self::consulta("SELECT count(*) as numAvisos FROM avisos");
            $count = $resultado->fetch(PDO::FETCH_ASSOC);
            return intval($count['numAvisos']);
        }
        
        public static function buscarAviso($id) {
            $resultado = self::consulta("SELECT * FROM aviso WHERE id=$id");
            $aviso = Aviso::getAviso($resultado->fetch(PDO::FETCH_ASSOC));
            return $aviso;
        }
    }
    
?>