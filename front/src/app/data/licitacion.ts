/**
 * Clase Licitacion
 */
export class Licitacion {
    expediente: string;
    organo_contratacion: string;
    objeto_contrato: string;
    valor_estimado: string;
    tipo: string;
    lugar_ejecucion: string;
    plazo: string;
    enlace: string;

    /**
     * @constructor
     * @param expediente expediente de la licitacion
     * @param organo_contratacion organo contratante del proyecto de licitacion
     * @param objeto_contrato objetivo del contrato de la licitacion
     * @param valor_estimado valor estimado de la licitacion
     * @param tipo tipo de licitacion
     * @param lugar_ejecucion luagr de ejecucion de la licitacion
     * @param plazo fecha maxima de presentacion de la solicitud
     * @param enlace enlace a la pagina oficial
     */
    constructor(expediente:string = "", organo_contratacion:string = "", objeto_contrato:string = "", valor_estimado:string = "", tipo:string = "", lugar_ejecucion:string = "", plazo:string = "", enlace:string = "") {
        this.expediente = expediente;
        this.organo_contratacion = organo_contratacion;
        this.objeto_contrato = objeto_contrato;
        this.valor_estimado = valor_estimado;
        this.tipo = tipo;
        this.lugar_ejecucion = lugar_ejecucion;
        this.plazo = plazo;
        this.enlace = enlace;
    }
}