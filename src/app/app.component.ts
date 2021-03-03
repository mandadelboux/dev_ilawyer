import { Component } from '@angular/core';
@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})

// Páginas
export class AppComponent {
  public appPages = [
    { title: 'Home', url: '/folder', icon: 'home' },
    { title: 'Processos', url: '/processos', icon: 'document' },
    { title: 'Clientes', url: '/clientes', icon: 'people' },
    { title: 'Agenda', url: '/agenda', icon: 'archive' }
  ];
  constructor() {}
}
