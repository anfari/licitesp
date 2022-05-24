import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './components/header/header.component';
import { LicitacionComponent } from './components/licitacion/licitacion.component';
import { ListaLicitacionesComponent } from './components/lista-licitaciones/lista-licitaciones.component';
import { ListaAvisosComponent } from './components/lista-avisos/lista-avisos.component';
import { HttpClientModule } from '@angular/common/http';
import { HomeComponent } from './components/home/home.component';
import { AccesoComponent } from './components/acceso/acceso.component';
import { RegistroComponent } from './components/registro/registro.component';
import { PerfilComponent } from './components/perfil/perfil.component';
import { UsuarioComponent } from './components/usuario/usuario.component';
import { EditarPerfilComponent } from './components/editar-perfil/editar-perfil.component';
import { AddSpacePipe } from './pipes/add-space.pipe';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    LicitacionComponent,
    ListaLicitacionesComponent,
    ListaAvisosComponent,
    HomeComponent,
    AccesoComponent,
    RegistroComponent,
    PerfilComponent,
    UsuarioComponent,
    EditarPerfilComponent,
    AddSpacePipe
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
