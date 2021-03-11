import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { MostrarProcessoPageRoutingModule } from './mostrar-processo-routing.module';

import { MostrarProcessoPage } from './mostrar-processo.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MostrarProcessoPageRoutingModule
  ],
  declarations: [MostrarProcessoPage]
})
export class MostrarProcessoPageModule {}
