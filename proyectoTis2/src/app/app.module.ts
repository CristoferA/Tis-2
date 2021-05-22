import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';

import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';
import { ListPage } from '../pages/list/list';
import { PublicacionPage } from '../pages/publicacion/publicacion';
import { FiltroPage } from '../pages/filtro/filtro';
import { LoginPage } from '../pages/login/login';
import { CrearPublicacionPage } from '../pages/crear-publicacion/crear-publicacion';
import { RegistroPage } from '../pages/registro/registro';
import {CuentaPage} from '../pages/cuenta/cuenta';

import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';

@NgModule({
  declarations: [
    MyApp,
    HomePage,
    ListPage,
    PublicacionPage,
    FiltroPage,
    LoginPage,
    CrearPublicacionPage,
    RegistroPage,
    CuentaPage
  ],
  imports: [
    BrowserModule,
    IonicModule.forRoot(MyApp),
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    ListPage,
    PublicacionPage,
    FiltroPage,
    LoginPage,
    CrearPublicacionPage,
    RegistroPage,
    CuentaPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler}
  ]
})
export class AppModule {
  
}
