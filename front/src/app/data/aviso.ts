/**
 * Clase Aviso
 */
export class Aviso {
    id: number;
    licitacion: string;
    usuario: string;
    leido: boolean

    /**
     * @constructor
     * @param id identificador del aviso
     * @param licitacion expediente de la licitacion
     * @param usuario email del usuario a notificar
     * @param leido variable que determina si el aviso ya a sido leido
     */
    constructor(id:number = 0, licitacion:string = "", usuario:string = "", leido:boolean = false) {
        this.id = id;
        this.licitacion = licitacion;
        this.usuario = usuario;
        this.leido = leido;
    }
}