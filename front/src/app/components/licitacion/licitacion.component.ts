import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Licitacion } from 'src/app/data/licitacion';
import { LicitacionService } from 'src/app/services/licitacion.service';

@Component({
  selector: 'app-licitacion',
  templateUrl: './licitacion.component.html',
  styleUrls: ['./licitacion.component.css']
})
/**
 * Componente para la muestra de una licitacion concreta
 */
export class LicitacionComponent implements OnInit {
  //licitacion a mostrar
  licitacion!: Licitacion;

  /**
   * @constructor
   * @param licitacionService servicio de licitaciones
   */
  constructor(private licitacionService:LicitacionService) { }

  /**
   * Al cargar el componente pide los datos de la licitacion a cargar
   */
  ngOnInit(): void {
    this.getLicitacion();
  }

  /**
   * Funcion encargada de pedir al servicio los datos de la licitacion a cargar
   */
  async getLicitacion(): Promise<void> {    
    let expediente = this.licitacionService.licitacion.expediente;

    await this.licitacionService.getLicitacion(expediente).subscribe(licitacion => {
      this.licitacion = new Licitacion(licitacion.expediente, licitacion.organo_contratacion, licitacion.objeto_contrato, licitacion.valor_estimado, licitacion.tipo, licitacion.lugar_ejecucion, licitacion.plazo, licitacion.enlace);
    });
  }
}
