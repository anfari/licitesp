import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { lastValueFrom } from 'rxjs';
import { Usuario } from 'src/app/data/usuario';
import { UsuarioService } from 'src/app/services/usuario.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-acceso',
  templateUrl: './acceso.component.html',
  styleUrls: ['./acceso.component.css']
})
/**
 * Componente para el acceso de los usuarios
 */
export class AccesoComponent implements OnInit {
  //formulario de acceso
  formAcceso: FormGroup;

  /**
   * @constructor
   * @param usuarioService servicio del usuario
   * @param form formulario de aceso
   * @param router router para la navegacion
   */
  constructor(private usuarioService:UsuarioService, private form: FormBuilder, private router:Router) { 
    this.formAcceso = this.form.group({
      email:[''],
      password:['']
    });
  }

  ngOnInit(): void {
  }

  /**
   * Funcion encargada de realizar el acceso del usuario haciendo la llamada al servicio con los datos introducidos
   */
  async acceder(): Promise<void> {
    let result = await lastValueFrom(this.usuarioService.acceder(this.formAcceso.value));
    if (!result.error) {
      this.usuarioService.guardarUsuario(this.formAcceso.get("email")!.value, this.formAcceso.get("password")!.value);
      let usuario = new Usuario(result.email, result.nombre, result.passwd, result.localidad, result.lugares_interes, result.tipos_interes);
      this.usuarioService.setUsuario(usuario);
      this.router.navigate(['/home']);
    } else {
      alert(result.error);
    }
  }
}
