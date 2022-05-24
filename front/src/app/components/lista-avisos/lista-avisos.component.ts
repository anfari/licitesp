import { Component, HostListener, OnInit } from '@angular/core';
import { Aviso } from 'src/app/data/aviso';
import { Licitacion } from 'src/app/data/licitacion';
import { AvisoService } from 'src/app/services/aviso.service';
import { LicitacionService } from 'src/app/services/licitacion.service';
import { UsuarioService } from 'src/app/services/usuario.service';


@Component({
  selector: 'app-lista-avisos',
  templateUrl: './lista-avisos.component.html',
  styleUrls: ['./lista-avisos.component.css']
})
/**
 * Componente para la lista de avisos
 */
export class ListaAvisosComponent implements OnInit {
  //lista de avisos
  avisos!: Array<Aviso>;
  //licitacion a mostrar
  licitacion!: Licitacion;

  /**
   * @constructor
   * @param avisoService servicio de avisos
   */
  constructor(private avisoService:AvisoService) { }

  /**
   * Al cargar el componente obtiene los avisos del servicio
   */
  ngOnInit(): void {
    this.getAvisos();
  }

  /**
   * Funcion encargada de obtener la lista de avisos del servicio
   */
  async getAvisos():Promise<void> {
    await this.avisoService.getAvisos().subscribe(avisos => this.avisos = avisos);
  }

  /**
   * Funcion encargada de llamar al servicio para obtener la licitacion a mostrar
   * @param expediente 
   */
  async getLicitacion(expediente:string): Promise<void> {
    await this.avisoService.getLicitacion(expediente).subscribe(licitacion => {
      this.licitacion = new Licitacion(licitacion.expediente, licitacion.organo_contratacion, licitacion.objeto_contrato, licitacion.valor_estimado, licitacion.tipo, licitacion.lugar_ejecucion, licitacion.plazo, licitacion.enlace);
    });
  }

  /**
   * Evento que modifica el color de un elemento de la lista al seleccionarlo
   * @param event evento
   */
  @HostListener('click', ['$event']) onClick(event:any) {
    if (event.target.classList.contains("list-group-item")) {
      let lista = document.getElementsByTagName('li');
      for (let i = 0; i < lista.length; i++) {
        lista[i].classList.remove("active");
      }
      document.getElementById(event.target.id)?.classList.add("active");
    }
  }
}
