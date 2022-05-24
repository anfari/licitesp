<?php
    namespace Tema05\Ejercicio0304\Modelo;
    /**
     * Clase Usuario con los atributos del objeto usuario
     * 
     * $email -> email del usuario
     * $nombre -> nombre del usuario
     * $passwd -> contrasenia del usuario
     * $localidad -> localidad del usuario
     * $lugares_interes -> lugares de interes para la ejecucion de proyectos para el usuario
     * $tipos_interes -> tipos de contrato de interes para el usuario
     */
    class Usuario {
        private $email;
        private $nombre;
        private $passwd;
        private $localidad;
        private $lugares_interes;
        private $tipos_interes;
        
        /**
         * Constructor de la clase Usuario
         */
        function __construct($email, $nombre, $passwd, $localidad, $lugares_interes, $tipos_interes) {
            $this->email = $email;
            $this->nombre = $nombre;
            $this->passwd = $passwd;
            $this->localidad = $localidad;
            $this->lugares_interes = $lugares_interes;
            $this->tipos_interes = $tipos_interes;
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
         * Funcion encargada de transformar el array de datos devuelto por la BBDD a un objeto usuario
         * 
         * $array -> array asociativo devuelto por la BBDD
         */
        public static function getUsuario($array): Usuario {
            [$email, $nombre, $passwd, $localidad, $lugares_interes, $tipos_interes] = [$array['email'], $array['nombre'], $array['passwd'], $array['localidad'], $array['lugares_interes'], $array['tipos_interes']];
            return new Usuario($email, $nombre, $passwd, $localidad, $lugares_interes, $tipos_interes);
        }
    }
?>