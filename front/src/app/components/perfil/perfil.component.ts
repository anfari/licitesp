import { Component, OnInit } from '@angular/core';
import { Usuario } from 'src/app/data/usuario';
import { LicitacionService } from 'src/app/services/licitacion.service';
import { UsuarioService } from 'src/app/services/usuario.service';
import { AddSpacePipe } from 'src/app/pipes/add-space.pipe';

@Component({
  selector: 'app-perfil',
  templateUrl: './perfil.component.html',
  styleUrls: ['./perfil.component.css']
})
/**
 * Componente para el perfil del usuario
 */
export class PerfilComponent implements OnInit {

  /**
   * @constructor
   * @param usuarioService servicio de usuario
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
