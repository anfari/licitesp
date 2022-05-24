<?php
    namespace Tema05\Ejercicio0304\Modelo;
    /**
     * Clase Licitacion con los atributos del objeto licitacion
     * 
     * $expediente -> expediente de la licitacion
     * $organo_contratacion -> organo que realiza la peticion de licitacion
     * $objeto_contrato -> Objeto de contrato a cumplir en la licitacion
     * $valor_estimado -> valor en euros estimado de la licitacion
     * $tipo -> tipo/sector de la licitacion
     * $lugar_ejecucion -> Ciudad o localidad en la que se debe ejecutar la licitacion
     * $plazo -> fecha maxima para presentar la licitacion
     * $enlace -> enlace a la página oficial de la licitacion
     */
    class Licitacion {
        private $expediente;
        private $organo_contratacion;
        private $objeto_contrato;
        private $valor_estimado;
        private $tipo;
        private $lugar_ejecucion;
        private $plazo;
        private $enlace;

        /**
         * Constructor de la clase Licitacion
         */
        function __construct($expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $enlace) {
            $this->expediente = $expediente;
            $this->organo_contratacion = $organo_contratacion;
            $this->objeto_contrato = $objeto_contrato;
            $this->valor_estimado = $valor_estimado;
            $this->tipo = $tipo;
            $this->lugar_ejecucion = $lugar_ejecucion;
            $this->plazo = $plazo;
            $this->enlace = $enlace;
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
    }
?>