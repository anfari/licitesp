<?php
    namespace Tema05\Ejercicio0304\Modelo;
    use PDO, PDOException;
    require_once ("Licitacion.php");
    
    /**
     * Clase ModeloLicitacion con las funciones de conexion a la BBDD, CRUD y demas
     */
    class ModeloLicitacion {
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
         * Funcion encargada de insertar una licitacion en la base de datos
         * 
         * $licitacion -> licitacion a insertar
         */
        public static function insertar(Licitacion $licitacion): bool {
            if ($licitacion->expediente != null) {
                $resultado = self::consulta("SELECT * FROM licitacion WHERE expediente='".$licitacion->expediente."'");
                if ($resultado->fetch(PDO::FETCH_ASSOC) != null) {
                    return false;
                }
            }
            [$expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $enlace] = [$licitacion->expediente, $licitacion->organo_contratacion, $licitacion->objeto_contrato, $licitacion->valor_estimado, $licitacion->tipo, $licitacion->lugar_ejecucion, $licitacion->plazo, $licitacion->enlace];
            $resultado = self::consulta("INSERT INTO licitacion (expediente, organo_contratacion, objeto_contrato, valor_estimado, tipo, lugar_ejecucion, plazo, enlace) VALUES ('$expediente', '$organo_contratacion', '$objeto_contrato', '$valor_estimado', '$tipo', '$lugar_ejecucion', '$plazo', '$enlace');");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de eliminar una licitacion de la base de datos
         * 
         * $expediente -> expediente de la licitacion a eliminar
         */
        public static function eliminar(string $expediente): bool {
            $resultado = self::consulta("DELETE FROM licitacion WHERE expediente='$expediente'");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de actualizar una licitacion en la base de datos
         * 
         * $licitacion -> nuevos datos de la licitacion a actualizar
         */
        public static function actualizar(Licitacion $licitacion): bool {
            [$expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $enlace] = [$licitacion->expediente, $licitacion->organo_contratacion, $licitacion->objeto_contrato, $licitacion->valor_estimado, $licitacion->tipo, $licitacion->lugar_ejecucion, $licitacion->plazo, $licitacion->enlace];
            $resultado = self::consulta("UPDATE licitacion SET organo_contratacion='$organo_contratacion', objeto_contrato='$objeto_contrato', valor_estimado='$valor_estimado', tipo='$tipo', lugar_ejecucion='$lugar_ejecucion', plazo='$plazo', enlace='$enlace' WHERE expediente='$expediente'");
            if ($resultado->rowCount() == 1) {
                return true;
            }
            return false;
        }
        
        /**
         * Funcion encargada de listar las licitaciones de la base de datos paginadas
         * 
         * $numPag -> pagina a mostrar
         * $tamPag -> tamanio de la pagina / licitaciones por pagina
         */
        public static function listar(int $numPag=1, int $tamPag=10): array {
            $inicio = ($numPag-1)*$tamPag;
            $resultado = self::consulta("SELECT * FROM licitacion LIMIT $inicio, $tamPag");
            $lista = [];
            while ($licitacion = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $licitacion);
            }
            return $lista;
        }

        /**
         * Funcion encargada de listar las licitaciones solicitadas mediante filtrado
         * 
         * $data -> informacion del filtrado
         * $numPag -> pagina a mostrar
         * $tamPag -> tamanio de la pagina / licitaciones por pagina
         */
        public static function listarFiltrado($data, int $numPag=1, int $tamPag=10): array {
            $inicio = ($numPag-1)*$tamPag;
            $resultado = self::consulta("SELECT * FROM licitacion WHERE LOWER(expediente) LIKE LOWER('%".$data->expediente."%') AND UPPER(organo_contratacion) like UPPER('%".$data->contratante."%') AND lugar_ejecucion LIKE '%".$data->lugar."%' AND tipo like '%".$data->tipo."%' LIMIT $inicio, $tamPag");
            $lista = [];
            while ($licitacion = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $licitacion);
            }
            return $lista;
        }
        
        /**
         * Funcion encargada de devolver el numero de licitacion existentes
         */
        public static function numLicitaciones() {
            $resultado = self::consulta("SELECT count(*) as numLicitaciones FROM licitacion");
            $count = $resultado->fetch(PDO::FETCH_ASSOC);
            return intval($count['numLicitaciones']);
        }
        
        /**
         * Funcion encargada de buscar y devolver una licitacion en concreto
         * 
         * $expediente -> expediente de la licitacion a buscar
         */
        public static function buscarLicitacion($expediente) {
            $resultado = self::consulta("SELECT * FROM licitacion WHERE expediente='$expediente'");
            return $resultado->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Funcion encargada de devolver los diferentes lugares de ejecucion de las licitaciones
         */
        public static function obtenerLugares() {
            $resultado = self::consulta("SELECT DISTINCT lugar_ejecucion FROM licitacion");
            $lugares = [];
            while ($lugar = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($lugares, $lugar);
            }
            return $lugares;
        }

        /**
         * Funcion encargada de devolver los diferentes tipos/sectores de las licitaciones
         */
        public static function obtenerTipos() {
            $resultado = self::consulta("SELECT DISTINCT tipo FROM licitacion");
            $tipos = [];
            while ($tipo = $resultado->fetch(PDO::FETCH_ASSOC)) {
                array_push($tipos, $tipo);
            }
            return $tipos;
        }
    }
    
?>