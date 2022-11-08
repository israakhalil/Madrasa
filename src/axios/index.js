import axios from "axios";
import store_x from '@/store'
import router from '@/router'
let BASE_URL = null ;
if (process.env.NODE_ENV == "development") {
    BASE_URL = "http://127.0.0.1:8000/api";
}else{
    BASE_URL = "moqsit.com/attendance/api";
}

// const API_VERSION = "v1";

// const instance = axios.create({baseURL: (BASE_URL + "/" + API_VERSION) || ''})
 const instance = axios.create({baseURL: BASE_URL || ''})

instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;


// let access_token = localStorage.getItem('token');
// if (access_token) {
//     instance.defaults.headers.common['Authorization'] = `Bearer ${access_token}`
// }

instance.interceptors.request.use(
    
    config => {

        config.headers['Accept'] = 'application/json';
        config.headers['Accept-Language'] = (localStorage.getItem('lang') || 'ar');

        let school_id = store_x.getters['settings/getSchoolId'];
        if (school_id) {
            config.headers['School-Id'] = school_id;
        }
        let access_token = localStorage.getItem('token');
        if (access_token) {
            config.headers['Authorization'] = `Bearer ${access_token}`;
        }
       
        return config;
        },
        error => {
            return Promise.reject(error);
        }
    
    );



 

instance.interceptors.response.use(
    response => {
        return response
    },
    error => {
        if (error instanceof axios.Cancel) {
            return Promise.reject(error)
        }

        const { status } = error.response
        console.log(status);

        // Show the user a 500 error
        if (status >= 500) {
            globalApp.error(error.response.data.message)
        }

        // Handle Session Timeouts
        if (status === 401) {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            globalApp.warning('انتهت الجلسة الخاصة بك')
            router.push({name: 'login'})
        }

        if (status === 404) {
            router.push({name: '404'})
        }
 

        if (status == 422 || status == 429) {
            globalApp.warning(error.response.data.message)
        }

        return Promise.reject(error)
    }
)

export default instance;

