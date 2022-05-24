import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { lastValueFrom } from 'rxjs';
import { Usuario } from 'src/app/data/usuario';
import { UsuarioService } from 'src/app/services/usuario.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styleUrls: ['./registro.component.css']
})
/**
 * Componente para el resgistro de usuario
 */
export class RegistroComponent implements OnInit {
  //formulario de registo
  formRegistro: FormGroup;

  /**
   * @constructor
   * @param usuarioService servicio del usuario
   * @param form formbuilder
   * @param router router para la paginacion
   */
  constructor(private usuarioService:UsuarioService, private form: FormBuilder, private router:Router) { 
    //El formulario requiere y valida los campos con expresiones regulares
    this.formRegistro = this.form.group({
      email: new FormControl('', [Validators.email, Validators.required]),
      nombre: new FormControl('', [Validators.required, Validators.pattern(/^[A-Za-z]+$/)]),
      password: new FormControl('', [Validators.required, Validators.pattern(/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,32}/)]),
      confirmPassword: new FormControl('', [Validators.required, Validators.pattern(/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,32}/)]),
      localidad: new FormControl('')
    });
  }

  ngOnInit(): void {
  }

  /**
   * Funcion encargada realizar la peticion de registro al servicio con los datos introducidos en el formulario
   */
  async registrar(): Promise<void> {
    let email = this.formRegistro.get('email')!.value;
    let nombre = this.formRegistro.get('nombre')!.value;
    let password = this.formRegistro.get('password')!.value;
    let confirmPassword = this.formRegistro.get('confirmPassword')!.value;
    let localidad = this.formRegistro.get('localidad')!.value;

    if (password != confirmPassword) {
      alert('Las contraseñas no coinciden.');
    } else {
      let usuario = new Usuario(email, nombre, password, localidad, "", "");
      let result = await lastValueFrom(this.usuarioService.registrar(usuario));
      console.log(result);
      if (result) {
        this.usuarioService.setUsuario(usuario);
      } else {
        alert("El usuario ya existe.");
      }
      this.router.navigate(['/home'])
    }
  }
}
