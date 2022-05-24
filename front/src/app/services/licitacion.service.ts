import { Injectable } from '@angular/core';
import { Licitacion } from '../data/licitacion';
import { Observable, of } from 'rxjs';
import { HttpClient, HttpParams } from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
/**
 * Servicio encargado de realizar las acciones correspondientes a las licitaciones
 */
export class LicitacionService {
    //lista de licitaciones
    licitaciones: Licitacion[] = [];
    //licitacion concreta a consultar
    licitacion: Licitacion = new Licitacion();
    //tipos de licitacion existentes
    tipos: string[] = [];
    //lugares de ejecucion de licitaciones existentes
    lugares: string[] = [];
    //pagina actual del paginado
    pag: number = 1;
    //ultima pagina del paginado
    maxPag: number = 999;
    //datos para el filtrado de licitaciones
    data = {};
    //variable que controla si se desea filtrar
    filtrar = false;
    
    /**
     * @constructor
     * @param http libreria para realizar llamadas al servidor
     */
    constructor(private http:HttpClient) { 
        this.getInitialData(1, 7);
    }

    //URL del controlador de licitaciones
    private licitacionesUrl = 'http://licitesp/rest/Controlador/ControladorLicitacion.php';


    /**
     * Funcion encargada de obtener los datos iniciales cuando el servicio carga
     * Recoge las licitaciones de las primera página y las almacena en la variable licitaciones
     * Recoge los tipos disponibles y los almacena en la variable tipos
     * Recoge los lugares disponibles y los almacena en la variable lugares
     * Recoge la ultima pagina del paginado y la almacena en la variable maxPag
     */
    getInitialData(pag=1, tamPag=7):void {
        this.licitaciones = [];
        let queryParams = new HttpParams().append("pag",pag).append("tamPag",tamPag);

        this.http.get<any>(this.licitacionesUrl+"?listar",{params:queryParams}).subscribe(data => {
            data.forEach((element:any) => {
                let licitacion = new Licitacion(element.expediente, element.organo_contratacion, element.objeto_contrato, element.valor_estimado, element.tipo, element.lugar_ejecucion, element.plazo, element.enlace);
                this.licitaciones.push(licitacion);
            });
        });

        this.http.get<any>(this.licitacionesUrl+"?tipos").subscribe(data => {
            data.forEach((element: any) => {
                this.tipos.push(element.tipo);
            });
        });

        this.http.get<any>(this.licitacionesUrl+"?lugares").subscribe(data => {
            data.forEach((element: any) => {
                this.lugares.push(element.lugar_ejecucion);
            });
        })

        this.http.get<string>(this.licitacionesUrl+"?maxPag&tamPag=7").subscribe(data => {
            this.maxPag = parseInt(data);
        })
    }

    /**
     * Realiza una peticion para obtener las licitaciones deseadas, que pueden ser:
     * Una pagina concreta, un filtrado o una pagina del filtrado
     * @param pag pagina a obtener 
     * @param $tamPag numero de licitaciones por pagina
     */
    getLicitacionesData(pag=1, $tamPag=7):void {
        let queryParams = new HttpParams().append("pag",pag).append("tamPag",$tamPag).append("filtros",JSON.stringify(this.data));

        if (!this.filtrar) {
            this.licitaciones = [];
            this.http.get<any>(this.licitacionesUrl+"?listar",{params:queryParams}).subscribe(data => {
                data.forEach((element:any) => {
                    let licitacion = new Licitacion(element.expediente, element.organo_contratacion, element.objeto_contrato, element.valor_estimado, element.tipo, element.lugar_ejecucion, element.plazo, element.url);
                    this.licitaciones.push(licitacion);
                });
            });
        } else {
            this.licitaciones = [];
            this.http.get<any>(this.licitacionesUrl+"?filtrar",{params:queryParams}).subscribe(data => {
                data.forEach((element:any) => {
                    let licitacion = new Licitacion(element.expediente, element.organo_contratacion, element.objeto_contrato, element.valor_estimado, element.tipo, element.lugar_ejecucion, element.plazo, element.url);
                    this.licitaciones.push(licitacion);
                });
            });
        }
    }

    /**
     * Funcion encargada de obtener una licitacion en concreto del servidor
     * @param expediente expediente de la licitacion a obtener
     * @returns observable de licitacion
     */
    getLicitacion(expediente:string):Observable<Licitacion> {
        let queryParams = new HttpParams().append("expediente", expediente);
        return this.http.get<Licitacion>(this.licitacionesUrl,{params:queryParams});
    }

    /**
     * Funcion encargada de devolver las licitaciones almacenadas en el servidio
     * @returns licitaciones almacenadas en el servicio
     */
    getLicitaciones(): Observable<Licitacion[]> {
        return of(this.licitaciones);
    }

    /**
     * Funcion encargada de devolver los tipos de licitacion almacenadas
     * @returns tipos de licitacion almacenados
     */
    getTipos(): Array<string> {
        return this.tipos;
    }

    /**
     * Funcion encargada de devolver los lugares de ejecucion almacenados
     * @returns lugares de ejecucion almacenador
     */
    getLugares(): Array<string> {
        return this.lugares;
    }

}
