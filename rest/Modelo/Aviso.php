<?php
    namespace Tema05\Ejercicio0304\Modelo;
    /**
     * Clase Aviso con los atributos del objeto aviso
     * 
     * $id -> id del aviso
     * $licitacion -> expediente de la licitacion del aviso
     * $usuario -> email del usuario a notificar
     * $leido -> variable para comprobar si el usuario a leido el aviso
     */
    class Aviso {
        private $id;
        private $licitacion;
        private $usuario;
        private $leido;
        
        /**
         * Constructor de la clase Aviso
         */
        function __construct($id, $licitacion, $usuario, $leido = false) {
            $this->id = $id;
            $this->licitacion = $licitacion;
            $this->usuario = $usuario;
            $this->leido = $leido;
        }
        
        /**
         * Funcion encargada de devolver el atributo especioficado
         * 
         * $atributo -> atributo a devolver
         */
        public function __get($atributo) {
            return $this->$atributo;
        }
        
        /**
         * Funcion encargada de asignar el atributo especificado
         * 
         * $atributo -> atributo a asignar
         * $valor -> valor a asignar al atributo
         */
        public function __set($atributo, $valor) {
           $this->$atributo = $valor;
        }
        
        /**
         * Funcion encargada de transformar el array de datos devuelto por la BBDD a un objeto aviso
         * 
         * $array -> array asociativo devuelto por la BBDD
         */
        public static function getAviso($array): Aviso {
            echo json_encode($array);
            [$id, $licitacion, $usuario, $leido] = [$array['id'], $array['licitacion'], $array['usuario'], $array['leido']];
            return new Aviso($id, $licitacion, $usuario, $leido);
        }
    }
?>