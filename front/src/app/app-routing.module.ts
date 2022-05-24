import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AccesoComponent } from './components/acceso/acceso.component';
import { HomeComponent } from './components/home/home.component';
import { LicitacionComponent } from './components/licitacion/licitacion.component';
import { ListaAvisosComponent } from './components/lista-avisos/lista-avisos.component';
import { ListaLicitacionesComponent } from './components/lista-licitaciones/lista-licitaciones.component';
import { PerfilComponent } from './components/perfil/perfil.component';
import { RegistroComponent } from './components/registro/registro.component';
import { UsuarioComponent } from './components/usuario/usuario.component';

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  { path: 'licitaciones', component: ListaLicitacionesComponent },
  { path: 'licitacion', component: LicitacionComponent },
  { path: 'home', component: HomeComponent },
  { path: 'avisos', component: ListaAvisosComponent },
  { path: 'registro', component: RegistroComponent },
  { path: 'acceso', component: AccesoComponent },
  { path: 'perfil', component: PerfilComponent },
  { path: 'usuario', component: UsuarioComponent }
  //{ path: 'perfil',   }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
