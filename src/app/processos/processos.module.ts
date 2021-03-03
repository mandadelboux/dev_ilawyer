import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ProcessosPageRoutingModule } from './processos-routing.module';

import { ProcessosPage } from './processos.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ProcessosPageRoutingModule
  ],
  declarations: [ProcessosPage]
})
export class ProcessosPageModule {}
