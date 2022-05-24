import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { lastValueFrom } from 'rxjs';
import { Usuario } from 'src/app/data/usuario';
import { LicitacionService } from 'src/app/services/licitacion.service';
import { UsuarioService } from 'src/app/services/usuario.service';
import { UsuarioComponent } from '../usuario/usuario.component';

@Component({
  selector: 'app-editar-perfil',
  templateUrl: './editar-perfil.component.html',
  styleUrls: ['./editar-perfil.component.css']
})
/**
 * Componente para la edicion de los datos del usuario
 */
export class EditarPerfilComponent implements OnInit {
  //lista de tipos de licitacion existentes
  tipos:string[] = [];
  //lista de lugares de ejecucion existentes
  lugares:string[] = [];

  /**
   * @constructor
   * @param usuarioService servicio del usuario
   * @param licitacionService servicio de las licitaciones
   * @param usuario componente usuario en el que se carga
   */
  constructor(private usuarioService:UsuarioService, private licitacionService:LicitacionService, private usuario:UsuarioComponent) { }

  /**
   * Al cargar el componente recoge los tipos y lugares disponibles
   */
  ngOnInit(): void {
    this.getTipos();
    this.getLugares();
  }

  /**
   * Funcion encargada de recoger el usuario logeado del servicio de usuario
   * @returns usuario logeado
   */
  getUsuario():Usuario {
    return this.usuarioService.getUsuario();
  }

  /**
   * Funcion encargada de recoger los tipos de licitacion del servicio de licitaciones
   */
  getTipos():void {
    this.tipos = this.licitacionService.getTipos();
  }

  /**
   * Funcion encargada de recoger los lugares de ejecucion del servicio de licitaciones
   */
  getLugares():void {
    this.lugares = this.licitacionService.getLugares();
  }

  /**
   * Funcion encargada de comprobar si un tipo de licitacion esta entre los intereses del usuario
   * @param tipo tipo de licitacion a comprobar
   * @returns true/false si esta o no
   */
  inTiposInteres(tipo:string):boolean {
    if (this.usuarioService.getTiposInteres().includes(tipo)) {
      return true;
    }
    return false;
  }

  /**
   * Funcion encargada de comprobar si un lugar de ejecucion esta entre los intereses del usuario
   * @param lugar lugar de ejecucion a comprobar
   * @returns true/false si esta o no
   */
  inLugaresInteres(lugar:string):boolean {
    if (this.usuarioService.getLugaresInteres().includes(lugar)) {
      return true;
    }
    return false;
  }
  
  /**
   * Funcion encargada de guardar los cambios efectuados en el perfil del usuario y mandarselos al servicio para su actualizacion
   */
  async guardarCambios(): Promise<void> {
    let tipos: string = "";
    let lugares: string = "";
    let nombre = (<HTMLInputElement>document.getElementById('nombre')).value;
    let localidad = (<HTMLInputElement>document.getElementById('localidad')).value;
    let tiposInputs = document.getElementById('tipos')?.querySelectorAll('input');
    let lugaresInputs = document.getElementById('lugares')?.querySelectorAll('input');

    tiposInputs?.forEach(element => {
      if (element.checked) {
        tipos += element.value + ",";
      }
    });
    if (tipos.length > 1) {
      tipos = tipos.substring(0, tipos.length-1);
    }

    lugaresInputs?.forEach(element => {
      if (element.checked) {
        lugares += element.value + ",";
      }
    });
    if (lugares.length > 1) {
      lugares = lugares.substring(0, lugares.length-1);
    }

    let usuario = new Usuario(this.getUsuario().email, nombre, this.getUsuario().password, localidad, lugares, tipos);
    let result = await lastValueFrom(this.usuarioService.actualizarUsuario(usuario));

    if (result.respuesta) {
      this.usuarioService.setUsuario(usuario);
    }
    this.usuario.opcion = "perfil";
  }

}
