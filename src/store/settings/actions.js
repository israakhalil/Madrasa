import router from '@/router'

export default {
  async fetchSchool(context) {
     globalApp.request().get('/schools/index')
    .then(({data}) => {
      if(data.status){
        localStorage.setItem("school" , JSON.stringify(data.data.School));
        context.state.school = data.data.School;
      }
    })
},
  
  async fetchUser(context , payload) {
    await globalApp.request().get('/system/users/fetch-data')
      .then(({data}) => {
        if(data.status){
          context.state.user = data.data;
          context.state.permissions = data.data.permissions;
          context.state.unread_permission_requests_count = data.data.unread_permission_requests_count;
          localStorage.setItem("user" , JSON.stringify(data.data));
          // localStorage.setItem("unread_permission_requests_count" , data.data.unread_permission_requests_count);
        }
      }).catch(()=>{
      })
  },

  async login(context, payload) {
   
     globalApp.request().post('/auth/login' , payload)
      .then(({ data }) => {     
        if(data.status){
          context.state.access_token = data.data.token;
          context.state.user = data.data.user;
          context.state.school = data.data.school;
          localStorage.setItem('token' ,data.data.token);
          localStorage.setItem("user", JSON.stringify(data.data.user));
          localStorage.setItem("school", JSON.stringify(data.data.school));  
          router.replace('/grades')
        }
      }).catch(() => {
        
        console.log("error");
      })
  },
  async logout(context) {
    await globalApp.request().post('/auth/logout')
      .then(({data}) => {
        if(data.status){
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          setTimeout(() => {
            router.push({ name: 'login' });
          }, 3000); 
        }
      })
  },
   
};
