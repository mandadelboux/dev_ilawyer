import { Router } from '@angular/router';
import { NativeStorage } from '@ionic-native/native-storage/ngx';
import { Component, OnInit } from '@angular/core';
import { Post } from 'src/services/post';

@Component({
  selector: 'app-processos',
  templateUrl: './processos.page.html',
  styleUrls: ['./processos.page.scss'],
})
export class ProcessosPage implements OnInit {

  lista : any = [];
  limit : number = 10;
  start : number = 0;
  nome : string = "";
  dadosLogin : any;
  cpf_adv: string = "";
  
  constructor(private storage: NativeStorage, private router: Router,  private provider: Post) { }

  ngOnInit() {
  }

  ionViewWillEnter(){
    this.storage.getItem('session_storage').then((res)=>{
      this.dadosLogin = res;
     
      //this.cpf_adv = this.dadosLogin.cpf;
      
    }); 
    this.cpf_adv = '000.000.000-10';

    this.lista = [];
    this.start = 0;
    this.carregar();
  }

 
  carregar(){
    return new Promise(resolve => {
      this.lista = [];
      let dados = {
        requisicao : 'listar',
        nome : this.nome,
        cpf_adv : this.cpf_adv,
        limit : this.limit,
        start : this.start
        };

        this.provider.dadosApi(dados, 'apiProcessos.php').subscribe(data => {

        if(data['result'] == '0') {
          this.ionViewWillEnter();
        }else{
          for(let item of data['result']){
            this.lista.push(item);
            
          }
        }
         
         resolve(true);
         
        });
    });
    
  }


 

  mostrar(id, processo, vara, acao, cliente, status, obs, data_audiencia, audiencias){
    this.router.navigate(['/mostrar-processo/' + id + '/' + processo + '/' + vara + '/' + acao + '/' + cliente + '/' + status + '/' + obs + '/' + data_audiencia + '/' + audiencias]);
  }

  mov(processo){
    this.router.navigate(['/add-movimentacoes/' + processo ]);
  }
  

 //atualizar o list view

 doRefresh(event) {
    
  setTimeout(() => {
    this.ionViewWillEnter();
    event.target.complete();
  }, 500);
}


//barra de rolagem
loadData(event) {

  this.start += this.limit;

  setTimeout(() => {
    this.carregar().then(()=>{ 
      event.target.complete();
     });
   
  }, 500);
  

}
  

}