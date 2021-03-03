import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Post } from 'src/services/post';
import { ToastController } from '@ionic/angular';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  usuario: string = "";
  senha: string = "";

  constructor(private router: Router, private provider: Post, public toast: ToastController) { }

  ngOnInit() {
  }

  async login() {
    if (this.usuario == "") {
      const toast = await this.toast.create({
        message: 'Preencha o Usuário',
        duration: 2000,
        color: 'warning'
      });
      toast.present();
      return;
    }

    if (this.senha == "") {
      const toast = await this.toast.create({
        message: 'Preencha a Senha',
        duration: 2000,
        color: 'warning'
      });
      toast.present();
      return;
    }

    let dados = {
      requisicao: 'login',
      usuario: this.usuario,
      senha: this.senha

    };

    // Chamada para API

    this.provider.dadosApi(dados, 'apiAdv.php').subscribe(async data => {
      var alert = data['msg'];
      if (data['success']) {
        // this.storage.setItem('session_storage', data['result']);
        if (data['result']['nivel'] == 'Advogado') { // Só vai ter acesso quem for advogado
          this.router.navigate(['/folder']);
        } else {
          this.router.navigate(['/login']);
        }

        const toast = await this.toast.create({
          message: 'Logado com Sucesso!!',
          duration: 1000,
          color: 'success'
        });
        toast.present();
        this.usuario = "";
        this.senha = "";
        console.log(data);
      } else {
        const toast = await this.toast.create({
          message: alert,
          duration: 2000,
          color: 'danger'
        });
        toast.present();
      }


    });
  }
}