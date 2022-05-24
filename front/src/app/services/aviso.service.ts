import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Aviso } from '../data/aviso';
import { Licitacion } from '../data/licitacion';
import { LicitacionService } from './licitacion.service';
import { UsuarioService } from './usuario.service';

@Injectable({
  providedIn: 'root'
})
/**
 * Servicio encargado de realizar las acciones correspondientes a los avisos
 */
export class AvisoService {
  //lista de avisos
  avisos: Aviso[] = [];
  //licitacion del aviso a consultar
  licitacion!: Licitacion;

  /**
   * @constructor
   * @param http libreria para realizar llamadas al servidor
   * @param usuarioService servicio del usuario
   * @param licitacionService servicio de licitaciones
   */
  constructor(private http:HttpClient, private usuarioService:UsuarioService, private licitacionService:LicitacionService) { 
    this.getInitialData();
  }

  //URL del controlador de avisos
  private avisosUrl = 'http://licitesp/rest/Controlador/ControladorAviso.php';

  /**
   * Funcion encargada de obtener los datos iniciales cuando el servicio carga
   * Recoge todos los avisos del usuario logeado y los almacena en la variable avisos
   */
  getInitialData():void {
    let queryParams = new HttpParams().append("usuario",this.usuarioService.getUsuario().email);
    this.http.get<any>(this.avisosUrl+"?listar",{params:queryParams}).subscribe(data => {
        data.forEach((element:any) => {
            let aviso = new Aviso(element.id, element.licitacion, element.usuario, element.leido);
            this.avisos.push(aviso);
        });
    });
  }

  /**
   * Funcion encargada de buscar y almacenar en la variable licitacion la licitacion deseada
   * @param expediente expediente de la licitacion a obtener
   * @returns licitacion especificada
   */
  getLicitacion(expediente:string):Observable<Licitacion> {
    return this.licitacionService.getLicitacion(expediente);
  }  

  /**
   * Funcin encargada de devolver los avisos almacenados
   * @returns avisos almacenados en el servicio
   */
  getAvisos(): Observable<Aviso[]> {
    let queryParams = new HttpParams().append("usuario",this.usuarioService.getUsuario().email);
    this.http.get<any>(this.avisosUrl+"?listar",{params:queryParams}).subscribe(data => {
        data.forEach((element:any) => {
            let aviso = new Aviso(element.id, element.licitacion, element.usuario, element.leido);
            this.avisos.push(aviso);
        });
    });
    return of(this.avisos);
  }
}
