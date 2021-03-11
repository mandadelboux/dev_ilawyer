import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddClientesPage } from './add-clientes.page';

const routes: Routes = [
  {
    path: '',
    component: AddClientesPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddClientesPageRoutingModule {}
