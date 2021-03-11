import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MostrarClientePage } from './mostrar-cliente.page';

const routes: Routes = [
  {
    path: '',
    component: MostrarClientePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class MostrarClientePageRoutingModule {}
