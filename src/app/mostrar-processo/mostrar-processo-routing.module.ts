import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MostrarProcessoPage } from './mostrar-processo.page';

const routes: Routes = [
  {
    path: '',
    component: MostrarProcessoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class MostrarProcessoPageRoutingModule {}
