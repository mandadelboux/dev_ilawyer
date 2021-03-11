import { ActivatedRoute, Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-mostrar-processo',
  templateUrl: './mostrar-processo.page.html',
  styleUrls: ['./mostrar-processo.page.scss'],
})
export class MostrarProcessoPage implements OnInit {

  status: string = "";
  cliente: string = "";
  processo: string = "";
  obs: string = "";
  acao: string = "";
  id: string = "";
  vara: string = "";
  audiencias: string = "";
  data_audiencia: string = "";

  constructor(private actRouter: ActivatedRoute, private router: Router) { }

  ngOnInit() {
    this.actRouter.params.subscribe((data:any)=>{
      this.id = data.id;
      this.cliente = data.cliente;
      this.processo = data.processo;
      this.status = data.status;
      this.acao = data.acao;
      this.obs = data.obs;
      this.vara = data.vara;
      this.audiencias = data.audiencias;
      this.data_audiencia = data.data_audiencia;

    });
  }


   Processos(){
    this.router.navigate(['/processos']);
  }


}
