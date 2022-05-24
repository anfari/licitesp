import { Component, OnInit } from '@angular/core';
import { Usuario } from 'src/app/data/usuario';
import { UsuarioService } from 'src/app/services/usuario.service';

@Component({
  selector: 'app-usuario',
  templateUrl: './usuario.component.html',
  styleUrls: ['./usuario.component.css']
})
/**
 * Componente para el area del perfil del usuario
 */
export class UsuarioComponent implements OnInit {
  //variable que determina que componente se muestra
  opcion = "perfil";

  /**
   * @constructor
   * @param usuarioService servicio del usuario
   */
  constructor(private usuarioService:UsuarioService) { }

  ngOnInit(): void {
  }

  /**
   * Funcion encargada de obtener el usuario logeado del servicio
   * @returns usuario
   */
  getUsuario():Usuario {
    return this.usuarioService.getUsuario();
  }
}
