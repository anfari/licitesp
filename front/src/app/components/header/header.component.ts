import { Component, OnInit } from '@angular/core';
import { Usuario } from 'src/app/data/usuario';
import { UsuarioService } from 'src/app/services/usuario.service';
import { Location } from '@angular/common';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
/**
 * Componente para la cabecera de la pagina
 */
export class HeaderComponent implements OnInit {

  /**
   * @constructor
   * @param usuarioService servicio del usuario 
   * @param location permite controlar la navegacion
   */
  constructor(private usuarioService: UsuarioService, private location: Location) { }

  /**
   * Al cargar el componente comprueba si existe una sesion abierta y la carga
   */
  ngOnInit(): void {
    this.usuarioService.comprobarSession();
  }

  /**
   * Funcion encargada de ir a la pagina anterior
   */
  goBack():void {
    this.location.back();
  }

  /**
   * Funcion encargada de llamar al servicio para saber si hay un usuario logeado
   * @returns true/false si lo esta
   */
  usuarioAccedido():boolean {
    return this.usuarioService.usuarioAccedido();
  }

  /**
   * Funcion encargada de mandar al servicio la orden de desconexion
   */
  desconectar():void {
    this.usuarioService.desconectar();
  }

}
