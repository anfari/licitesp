import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Licitacion } from 'src/app/data/licitacion';
import { LicitacionService } from 'src/app/services/licitacion.service';

@Component({
  selector: 'app-lista-licitaciones',
  templateUrl: './lista-licitaciones.component.html',
  styleUrls: ['./lista-licitaciones.component.css']
})
/**
 * Componente para la lista de licitaciones
 */
export class ListaLicitacionesComponent implements OnInit {
  //lista de licitaciones
  licitaciones: Licitacion[] = [];
  
  /**
   * @constructor
   * @param licitacionesService servicio de licitaciones
   * @param router router para la navegacion
   */
  constructor(private licitacionesService: LicitacionService, private router:Router) { }

  /**
   * Al cargar el componente obtiene la lista de licitaciones
   */
  ngOnInit(): void {
    this.getLicitaciones();
  }

  /**
   * Funcion encargada de obtener la lista de licitaciones del servicio
   */
  getLicitaciones(): void {
    this.licitacionesService.getLicitaciones().subscribe(licitaciones => this.licitaciones = licitaciones);
  }

  /**
   * Funcion encargada de obtener la pagina actual del servicio
   * @returns pagina actual
   */
  getPag():number {
    return this.licitacionesService.pag;
  }

  /**
   * Funcion encargada de obtener la ultima pagina del servicio
   * @returns ultima pagina
   */
  getMaxPag():number {
    return this.licitacionesService.maxPag;
  }

  /**
   * Funcion encargada de cargar las licitaciones filtrdas y/o de otra pagina
   * @param pagina pagina a cargar
   */
  paginar(pagina:number): void {
    if (pagina > 0 && pagina <= this.licitacionesService.maxPag) {
      this.licitacionesService.pag = pagina;
      this.licitacionesService.getLicitacionesData(pagina);
      this.router.navigateByUrl('/home', { skipLocationChange: true }).then(() => {
        this.router.navigate(['/licitaciones']);
      });
    }
  }

  /**
   * Funcion encargada de llamar al servicio para obtener un nuevo listado de licitaciones filtradas
   */
  search(): void {
    this.licitacionesService.pag = 1;
    let expediente = (<HTMLInputElement>document.getElementById("expediente")).value;
    let contratante = (<HTMLInputElement>document.getElementById("contratante")).value;
    let lugar = (<HTMLInputElement>document.getElementById("lugar")).value;
    let tipo = (<HTMLInputElement>document.getElementById("tipo")).value;
    
    let data = {
      "expediente": expediente,
      "contratante": contratante,
      "lugar": lugar,
      "tipo": tipo
    }

    if (expediente == "" && contratante == "" && lugar == "" && tipo == "") {
      this.licitacionesService.filtrar = false;
    } else {
      this.licitacionesService.filtrar = true;
      this.licitacionesService.data = data;
    }
    
    this.licitacionesService.getLicitacionesData(1);
    this.router.navigateByUrl('/home', { skipLocationChange: true }).then(() => {
      this.router.navigate(['/licitaciones']);
    }); 
  }

  /**
   * Funcion encargada de obtener los tipos de licitacion disponibles del servicio
   * @returns tipos de licitacion
   */
  getTipos(): Array<string> {
    return this.licitacionesService.getTipos();
  }

  /**
   * Funcion encargada de obtener los lugares de ejecucion disponibles del servicio
   * @returns lugares de ejecucion
   */
  getLugares(): Array<string> {
      return this.licitacionesService.getLugares();
  }

  /**
   * Funcion encargada de enviar al servicio la licitacion que se desea consultar
   * @param licitacion licitacion a consultar
   */
  consultar(licitacion:Licitacion):void {
    this.licitacionesService.licitacion = licitacion;
    this.router.navigate(['/licitacion']);
  }

}
