<?php
    namespace Tema05\Ejercicio0304\Modelo;
    class Licitacion {
        private $id;
        private $expediente;
        private $organo_contratacion;
        private $objeto_contrato;
        private $valor_estimado;
        private $tipo;
        private $lugar_ejecucion;
        private $plazo;
        private $url;

        
        function __construct($id, $expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $url) {
            $this->id = $id;
            $this->expediente = $expediente;
            $this->organo_contratacion = $organo_contratacion;
            $this->objeto_contrato = $objeto_contrato;
            $this->valor_estimado = $valor_estimado;
            $this->tipo = $tipo;
            $this->lugar_ejecucion = $lugar_ejecucion;
            $this->plazo = $plazo;
            $this->url = $url;
        }
        
        public function __get($atributo) {
            return $this->$atributo;
        }
        
        public function __set($atributo, $valor) {
           $this->$atributo = $valor;
        }
        
        public static function getLicitacion($array): Licitacion {
            if (isset($array['id'])) {
                [$id, $expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $url] = [$array['id'], $array['expediente'], $array['organo_contratacion'], $array['objeto_contrato'], $array['valor_estimado'], $array['tipo'], $array['lugar_ejecucion'], $array['plazo'], $array['url']];
                return new Licitacion($id, $expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $url);
            } else {
                [$expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $url] = [$array['expediente'], $array['organo_contratacion'], $array['objeto_contrato'], $array['valor_estimado'], $array['tipo'], $array['lugar_ejecucion'], $array['plazo'], $array['url']];
                return new Licitacion(null, $expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $url);
            }
            //[$id, $expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $url] = [$array['id'], $array['expediente'], $array['organo_contratacion'], $array['objeto_contrato'], $array['valor_estimado'], $array['tipo'], $array['lugar_ejecucion'], $array['plazo'], $array['url']];
            //return new Licitacion($id, $expediente, $organo_contratacion, $objeto_contrato, $valor_estimado, $tipo, $lugar_ejecucion, $plazo, $url);
        }
    }
?>