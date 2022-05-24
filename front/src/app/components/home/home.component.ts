import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { LicitacionService } from 'src/app/services/licitacion.service';
import { UsuarioService } from 'src/app/services/usuario.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
/**
 * Componente para la pagina de inicio
 */
export class HomeComponent implements OnInit {

  /**
   * @constructor
   * @param usuarioService servicio del usuario
   */
  constructor(private usuarioService:UsuarioService, private router:Router, private licitacionesService:LicitacionService) { }

  ngOnInit(): void {
  }

  /**
   * Funcion que llama al servicio para comprobar si hay un usuario logeado
   * @returns true/false si lo esta
   */
  usuarioAccedido():boolean {
    return this.usuarioService.usuarioAccedido();
  }

  /**
   * Funcion encargada de redireccionar a las licitaciones y vaciar el filtrado para la carga del listado
   */
  goLicitaciones():void {
    this.licitacionesService.data = {};
    this.licitacionesService.getInitialData();
    this.router.navigate(['/licitaciones']);
  }
}
