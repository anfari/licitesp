<?php
    namespace Tema05\Ejercicio0304\Modelo;
    class Licitacion {
        private $id;
        private $organo_contratacion;
        private $objeto_contrato;
        private $valor_estimado;
        private $tipo;
        private $lugar_ejecucion;
        private $plazo_ejecucion;
        private $url;

        
        function __construct($id, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo_ejecucion, $url) {
            $this->id = $id;
            $this->organo_contratacion = $organo_contratacion;
            $this->objeto_contrato = $objeto_contrato;
            $this->valor_estimado = $valor_estimado;
            $this->tipo = $tipo;
            $this->lugar_ejecucion = $lugar_ejecucion;
            $this->plazo_ejecucion = $plazo_ejecucion;
            $this->url = $url;
        }
        
        public function __get($atributo) {
            return $this->$atributo;
        }
        
        public function __set($atributo, $valor) {
           $this->$atributo = $valor;
        }
        
        public static function getLicitacion($array): Licitacion {
            [$id, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo_ejecucion, $url] = [$array['id'], $array['organo_contratacion'], $array['objeto_contrato'], $array['valor_estimado'], $array['tipo'], $array['lugar_ejecucion'], $array['plazo_ejecucion'], $array['url']];
            return new Licitacion($id, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo_ejecucion, $url);
        }
    }
?>