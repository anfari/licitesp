<?php
    namespace Tema05\Ejercicio0304\Modelo;
    class Aviso {
        private $id;
        private $id_licitacion;
        private $id_usuario;
        private $leido;
        
        function __construct($id, $id_licitacion, $id_usuario, $leido = false) {
            $this->id = $id;
            $this->id_licitacion = $id_licitacion;
            $this->id_usuario = $id_usuario;
            $this->leido = $leido;
        }
        
        public function __get($atributo) {
            return $this->$atributo;
        }
        
        public function __set($atributo, $valor) {
           $this->$atributo = $valor;
        }
        
        public static function getAviso($array): Aviso {
            [$id, $id_licitacion, $id_usuario, $leido] = [$array['id'], $array['id_licitacion'], $array['id_usuario'], $array['leido']];
            return new Aviso($id, $id_licitacion, $id_usuario, $leido);
        }
    }
?>