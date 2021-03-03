import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ProcessosPage } from './processos.page';

const routes: Routes = [
  {
    path: '',
    component: ProcessosPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProcessosPageRoutingModule {}
