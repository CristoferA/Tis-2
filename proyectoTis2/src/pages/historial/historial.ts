import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { PublicacionPage } from '../publicacion/publicacion';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';

/**
 * Generated class for the HistorialPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-historial',
  templateUrl: 'historial.html',
})
export class HistorialPage {
  
  data:Observable<any>;
  id_usuario:any;
  publicacionesHistorial: any;

  constructor(public navCtrl: NavController, public navParams: NavParams, public http: Http) {

    var respuesta = JSON.parse(localStorage.getItem('respuesta'));
    var id_usuario = respuesta.data.id_usuario;
    console.log(id_usuario);  
    

    this.http.get('http://localhost/apiRest/public/publicaciones_historial/'+id_usuario)
    .map(response => response.json())
    .subscribe(data =>{
      
        this.publicacionesHistorial = data;
        console.log(data);
        
      },
      err => {
        console.log("Oops!");
      }
    );


  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad HistorialPage');
  }


  irPublicacion(id_publicacion){
    this.navCtrl.push(PublicacionPage, {valor: id_publicacion});
  }


}