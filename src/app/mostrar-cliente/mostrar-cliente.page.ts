import { ActivatedRoute, Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-mostrar-cliente',
  templateUrl: './mostrar-cliente.page.html',
  styleUrls: ['./mostrar-cliente.page.scss'],
})
export class MostrarClientePage implements OnInit {

  nome: string = "";
  email: string = "";
  telefone: string = "";
  obs: string = "";
  endereco: string = "";
  id: string = "";

  constructor(private actRouter: ActivatedRoute, private router: Router) { }

  ngOnInit() {
    this.actRouter.params.subscribe((data:any)=>{
      this.id = data.id;
      this.nome = data.nome;
      this.email = data.email;
      this.telefone = data.telefone;
      this.endereco = data.endereco;
      this.obs = data.obs;

    });
  }


   Clientes(){
    this.router.navigate(['/clientes']);
  }


}