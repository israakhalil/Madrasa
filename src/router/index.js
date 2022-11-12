import { createRouter, createWebHistory } from "vue-router";
import routes from './routes'

const router = createRouter({
  base: process.env.NODE_ENV === 'production' ? '/': '/',
  history: createWebHistory((process.env.NODE_ENV === 'production' ? '/': '/')),
  routes
});



function isLoggedIn() {

    return localStorage.getItem("token");
}

router.beforeEach((to, from, next) => {
    
    if(to.name == 'login' && isLoggedIn() ) {
        next({ name: 'home' });
    }
    if (to.name != 'login' && !isLoggedIn()) {
        next({ name: 'login' });
    } else{
        next();
    }
});

export default router;