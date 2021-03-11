import { NativeStorage } from '@ionic-native/native-storage/ngx';
import { ToastController } from '@ionic/angular';
import { ActivatedRoute, Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';
import { Post } from 'src/services/post';

@Component({
  selector: 'app-add-clientes',
  templateUrl: './add-clientes.page.html',
  styleUrls: ['./add-clientes.page.scss'],
})
export class AddClientesPage implements OnInit {

  nome: string = "";
  endereco: string = "";
  obs: string = "";
  cpf: string = "";
  email: string = "";
  telefone: string = "";
  pessoa: string = "";
  id: string = "";
  dadosLogin : any;
  cpf_adv : string;

  constructor(private storage: NativeStorage, private actRouter: ActivatedRoute, private router: Router, private provider: Post, public toastController: ToastController) { }

  
  ionViewWillEnter(){
    this.storage.getItem('session_storage').then((res)=>{
      this.dadosLogin = res;
     
     // this.cpf_adv = this.dadosLogin.cpf;
      
    }); 
    this.cpf_adv = '000.000.000-10';
   
  }
  
  
  ngOnInit() {
    this.actRouter.params.subscribe((data:any)=>{
      this.id = data.id;
      this.nome = data.nome;
      this.endereco = data.endereco;
      this.obs = data.obs;
      this.email = data.email;
      this.telefone = data.telefone;
      this.cpf = data.cpf;
     

    });
  }


  async mensagemSalvar() {
    const toast = await this.toastController.create({
      message: 'Salvo com Sucesso!!',
      duration: 1000
    });
    toast.present();
  }

  Clientes(){
    this.router.navigate(['/clientes']);
  }

  cadastrar(){
    return new Promise(resolve => {
      
      let dados = {
        requisicao : 'add',
        nome : this.nome, 
        endereco : this.endereco, 
        telefone : this.telefone, 
        email : this.email, 
        pessoa : this.pessoa, 
        cpf : this.cpf, 
        obs : this.obs,
        cpf_adv : this.cpf_adv,
        };

        this.provider.dadosApi(dados, 'apiClientes.php').subscribe(data => {
          this.router.navigate(['/clientes']);
          this.mensagemSalvar();
        });
    });
  }

  editar(){
    return new Promise(resolve => {
      
      let dados = {
        requisicao : 'editar',
        nome : this.nome, 
        endereco : this.endereco, 
        telefone : this.telefone, 
        email : this.email, 
        cpf : this.cpf,
        obs : this.obs,
        id : this.id, 
        };

        this.provider.dadosApi(dados, 'apiClientes.php').subscribe(data => {
          this.router.navigate(['/clientes']);
          this.mensagemSalvar();
        });
    });
  }


}