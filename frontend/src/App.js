import {createApp} from "vue";
import i18n from './localization';
import router from './router';
import store from './store'
import axios from './axios'
import AppLayout from './App.vue';
import Toaster from "@meforma/vue-toaster";
import ConfirmationService from 'primevue/confirmationservice'; 
import mixins from "./mixins"; 
import VueHtmlToPaper from './plugin/VueHtmlToPaper';

const options = {
  // name: '_blank',
  // specs: [
  //   'fullscreen=yes',
  //   'titlebar=yes',
  //   'scrollbars=yes'
  // ],
  styles: [
    // 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    
    '/themes/lara-light-purple/theme.css',

    // 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',

    'themes/lara-light-purple/_tajawal.scss',
    '/themes/lara-light-purple/landscape.css',
    '/themes/lara-light-purple/absence.css',
  ],
  timeout: 1000, // default timeout before the print window appears
  autoClose: true, // if false, the window will not close after printing
  windowTitle: window.document.title, // override the window title
}

export default class App {
  
  constructor(config) {
    this.config = config
  }

  async liftOff() {
    this.app = await createApp(AppLayout).use(router)
      .use(i18n)
      .use(store)
      .use(Toaster)
      .use(ConfirmationService)
      .use(VueHtmlToPaper,options);
 
    // this.app.config.warnHandler = () => null;;

    
    this.app.mount("#app");
    mixins(this.app); 
    this.app.config.productionTip = true

  }


  request(options) {
    if (options !== undefined) {
      return axios(options)
    }
    return axios
  }
 
  error(message) {
    this.app.$toast.error(message);
  }


  success(message) {
    this.app.$toast.success(message);
  }


  warning(message) {
    this.app.$toast.warning(message);
  }
}