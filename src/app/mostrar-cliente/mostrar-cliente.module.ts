import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { MostrarClientePageRoutingModule } from './mostrar-cliente-routing.module';

import { MostrarClientePage } from './mostrar-cliente.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MostrarClientePageRoutingModule
  ],
  declarations: [MostrarClientePage]
})
export class MostrarClientePageModule {}
