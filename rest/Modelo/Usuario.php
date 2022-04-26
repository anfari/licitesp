<?php
    namespace Tema05\Ejercicio0304\Modelo;
    class Usuario {
        private $id;
        private $nombre;
        private $password;
        private $email;
        private $localidad;
        private $localidades_interes;
        private $sectores_interes;
        
        function __construct($id, $nombre, $password, $email, $localidad, $localidades_interes, $sectores_interes) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->password = $password;
            $this->email = $email;
            $this->localidad = $localidad;
            $this->localidades_interes = $localidades_interes;
            $this->sectores_interes = $sectores_interes;
        }

        public function __get($atributo) {
            return $this->$atributo;
        }
        
        public function __set($atributo, $valor) {
           $this->$atributo = $valor;
        }
        
        public static function getUsuario($array): Usuario {
            [$id, $nombre, $password, $email, $localidad, $localidades_interes, $sectores_interes] = [$array['id'], $array['nombre'], $array['password'], $array['email'], $array['localidad'], $array['localidades_interes'], $array['sectores_interes']];
            return new Usuario($id, $nombre, $password, $email, $localidad, $localidades_interes, $sectores_interes);
        }
    }
?>