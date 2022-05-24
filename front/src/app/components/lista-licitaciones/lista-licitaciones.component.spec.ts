import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListaLicitacionesComponent } from './lista-licitaciones.component';

describe('ListaLicitacionesComponent', () => {
  let component: ListaLicitacionesComponent;
  let fixture: ComponentFixture<ListaLicitacionesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ListaLicitacionesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ListaLicitacionesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
