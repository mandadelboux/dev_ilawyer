import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { NativeStorage } from '@ionic-native/native-storage/ngx';

@Component({
  selector: 'app-folder',
  templateUrl: './folder.page.html',
  styleUrls: ['./folder.page.scss'],
})
export class FolderPage implements OnInit {

  nome: string;
  dadosLogin: any;
  clientes: string;
  processos: string;
  audiencias: string;
  tarefas: string;
  
  constructor(private storage: NativeStorage, private activatedRoute: ActivatedRoute) { }

  ngOnInit() {
 
  }

  // Fazendo storage para recuperar usuário no mobile
  ionViewWillEnter(){
    this.storage.getItem('session_storage').then((res)=>{
      this.dadosLogin = res;
      this.nome = this.dadosLogin.nome;
     // this.cpf = this.dadosLogin.cpf;
      
    }); 
    // this.cpf = '000.000.000-10';
    this.carregar();
  }

  logout(){}

  carregar(){}

}
