import {createApp} from "vue";
import i18n from './localization';
import router from './router';
import store from './store'
import axios from './axios'
import AppLayout from './App.vue';
import Toaster from "@meforma/vue-toaster";
import ConfirmationService from 'primevue/confirmationservice'; 
import mixins from "./mixins"; 
import ToastService from 'primevue/toastservice';


export default class App {
  
  constructor(config) {
    this.config = config
  }

  async liftOff() {
    this.app = await createApp(AppLayout).use(router)
      .use(i18n)
      .use(store)
      .use(Toaster)
      .use(ConfirmationService);
 
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