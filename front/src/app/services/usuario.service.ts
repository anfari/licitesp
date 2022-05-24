import { Injectable } from '@angular/core';
import { Usuario } from '../data/usuario';
import { lastValueFrom, Observable, of } from 'rxjs';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
/**
 * Servicio encargado de realizar las acciones correspondientes a los usuarios
 */
export class UsuarioService {

  /**
   * @constructor
   * @param http libreria para realizar llamadas al servidor
   */
  constructor(private http:HttpClient, private router:Router) { }

  //URL del controlador de usuarios
  private usuarioUrl = 'http://licitesp/rest/Controlador/ControladorUsuario.php';

  //usuario logeado
  usuario: Usuario = new Usuario;

  /**
   * Funcion que devuelve el usuario almacenado
   * @returns usuario almacenado
   */
  getUsuario():Usuario {
    return this.usuario;
  }

  /**
   * Funcion encargada de asignar un usuario al almacenado en el servicio
   * @param usuario usuario a almacenar
   */
  setUsuario(usuario:Usuario):void {
    this.usuario = usuario;
  }

  /**
   * Funcion encargada de comprobar en las variables de sesion si el usuario esta logeado
   */
  async comprobarSession():Promise<void> {
    if (sessionStorage.getItem("licitesp_user") != null && sessionStorage.getItem("licitesp_passwd") != null) {
      let email = sessionStorage.getItem("licitesp_user");
      let passwd = sessionStorage.getItem("licitesp_passwd");
      let data = {
        "email": email,
        "password": passwd
      }

      let result = await lastValueFrom(this.acceder(data));
      let usuario = new Usuario(result.email, result.nombre, result.passwd, result.localidad, result.lugares_interes, result.tipos_interes);
      this.setUsuario(usuario);
    }
  }

  /**
   * Funcion encargado de comprobar si hay un usuario logeado
   * @returns true/false si esta o no logeado
   */
  usuarioAccedido():boolean {
    if (this.usuario.email != "") {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Funcion encargada de guardar el usuario en las variables de sesion
   * @param email email del usuario
   * @param password contrasenia del usuario
   */
  guardarUsuario(email:string, password:string):void {
    sessionStorage.setItem("licitesp_user", email);
    sessionStorage.setItem("licitesp_passwd", password);
  }

  /**
   * Funcion encargada de borrar las variables de session y el usuario almacenado al desconectar
   */
  desconectar(): void {
    this.setUsuario(new Usuario);
    sessionStorage.removeItem("licitesp_user");
    sessionStorage.removeItem("licitesp_passwd");
  }

  /**
   * Funcion encargada de realizar la peticion de acceso al servidor
   * @param data informacion de acceso del usuario
   * @returns resultado de la peticion
   */
  acceder(data:any):Observable<any> {
    return this.http.post(this.usuarioUrl+"?acceso", data);
  }

  /**
   * Funcion encargada de realizar la peticion de registro al servidor
   * @param usuario usuario a registrar
   * @returns resultado de la peticion
   */
  registrar(usuario: Usuario):Observable<any> {
    return this.http.post(this.usuarioUrl+"?registro", usuario);
  }

  /**
   * Funcion encargada de realizar la peticion de actualizacion de usuario al servidor
   * @param usuario usaurio con sus datos para modificar
   * @returns resultado de la peticion
   */
  actualizarUsuario(usuario:Usuario):Observable<any> {
    return this.http.post(this.usuarioUrl+"?actualizar", usuario);
  }

  /**
   * Funcion encargada de devolver los tipos de licitacion de interes del usuario
   * @returns array con los tipos de interes
   */
  getTiposInteres():Array<string> {
    return this.getUsuario().tipos_interes.split(",");
  }

  /**
   * Funcion encargada de devolver los lugares de ejecucion de interes del usuario
   * @returns aray con los lugares de interes
   */
  getLugaresInteres():Array<string> {
    return this.getUsuario().lugares_interes.split(",");
  }
}
