<?php
    namespace Tema05\Ejercicio0304\Modelo;
    //use Tema05\Ejercicio0304\Modelo\Producto;
    use PDO, PDOException;
    require_once ("Licitacion.php");
    
    class ModeloLicitacion {
        public static function consulta(string $sql) {
            [$host,$usuario,$passwd,$bd]=['localhost','gestisimal','gestisimal2021','gestisimal'];
            try {
                $conexion = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $usuario, $passwd);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $resultado = $conexion->query($sql);
            } catch (PDOException $e) {
                exit($e);
            }
            return $resultado;
        }
        
        public static function insertar(Licitacion $licitacion): bool {
            if ($licitacion->id != null) {
                $resultado = self::consulta("SELECT * FROM licitacion WHERE id=".$licitacion->id."");
                if ($resultado->fetch(PDO::FETCH_ASSOC) != null) {
                    return false;
                }
            }
            [$id, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo_ejecucion, $url] = [$licitacion->id, $licitacion->organo_contratacion, $licitacion->objeto_contrato, $licitacion->valor_estimado, $licitacion->tipo, $licitacion->lugar_ejecucion, $licitacion->plazo_ejecucion, $licitacion->url];
            $resultado = self::consulta("INSERT INTO licitacion VALUES($id, '$organo_contratacion', '$objeto_contrato', $valor_estimado, '$tipo', '$lugar_ejecucion', '$plazo_ejecucion', '$url');");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function eliminar(string $id): bool {
            $resultado = self::consulta("DELETE FROM licitacion WHERE id=$id");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function actualizar(Licitacion $licitacion): bool {
            [$id, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo_ejecucion, $url] = [$licitacion->id, $licitacion->organo_contratacion, $licitacion->objeto_contrato, $licitacion->valor_estimado, $licitacion->tipo, $licitacion->lugar_ejecucion, $licitacion->plazo_ejecucion, $licitacion->url];
            $resultado = self::consulta("UPDATE licitacion SET organo_contratacion='$organo_contratacion', objeto_contrato='$objeto_contrato', valor_estimado=$valor_estimado, tipo='$tipo', lugar_ejecucion='$lugar_ejecucion', plazo_ejecucion='$plazo_ejecucion', url='$url' WHERE id=$licitacion->id");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        public static function listar(int $numPag=1, int $tamPag=10): array {
            $inicio = ($numPag-1)*$tamPag;
            $resultado = self::consulta("SELECT * FROM licitacion LIMIT $inicio, $tamPag");
            $lista = [];
            while ($licitacion = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, Licitacion::getLicitacion($licitacion));
            }
            return $lista;
        }
        
        public static function numPLicitaciones() {
            $resultado = self::consulta("SELECT count(*) as numLicitaciones FROM licitacion");
            $count = $resultado->fetch(PDO::FETCH_ASSOC);
            return intval($count['numLicitaciones']);
        }
        
        public static function buscarLicitacion($id) {
            $resultado = self::consulta("SELECT * FROM licitacion WHERE id=$id");
            $licitacion = Licitacion::getLicitacion($resultado->fetch(PDO::FETCH_ASSOC));
            return $licitacion;
        }
    }
    
?>