import { NativeStorage } from '@ionic-native/native-storage/ngx';
import { Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';
import { Post } from 'src/services/post';

@Component({
  selector: 'app-clientes',
  templateUrl: './clientes.page.html',
  styleUrls: ['./clientes.page.scss'],
})
export class ClientesPage implements OnInit {

  clientes : any = [];
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
     
     // this.cpf_adv = this.dadosLogin.cpf;
      
    }); 
    this.cpf_adv = '000.000.000-10';

    this.clientes = [];
    this.start = 0;
    this.carregar();
  }

  addClientes(){
    this.router.navigate(['/add-clientes']);
  }

  carregar(){
    return new Promise(resolve => {
      this.clientes = [];
      let dados = {
        requisicao : 'listar',
        nome : this.nome,
        cpf_adv : this.cpf_adv,
        limit : this.limit,
        start : this.start
        };

        this.provider.dadosApi(dados, 'apiClientes.php').subscribe(data => {

        if(data['result'] == '0') {
          this.ionViewWillEnter();
        }else{
          for(let item of data['result']){
            this.clientes.push(item);
            
          }
        }
         
         resolve(true);
         
        });
    });
    
  }


  editar(id, nome, cpf, telefone, email, endereco, obs){
    this.router.navigate(['/add-clientes/' + id + '/' + nome + '/' + cpf + '/' + telefone + '/' + email + '/' + endereco + '/' + obs]);
  }

  mostrar(id, nome, cpf, telefone, email, endereco, obs){
    this.router.navigate(['/mostrar-cliente/' + id + '/' + nome + '/' + cpf + '/' + telefone + '/' + email + '/' + endereco + '/' + obs]);
  }

  
  excluir(id){
    return new Promise(resolve => {
      
      let dados = {
        requisicao : 'excluir',
        id : id, 
        };

        this.provider.dadosApi(dados, 'apiClientes.php').subscribe(data => {
         this.ionViewWillEnter();
        });
    });
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