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
    await globalApp.request().get('/users/fetch-data')
      .then(({data}) => {
        if(data.status){
          context.state.user = data.data;
          localStorage.setItem("user" , JSON.stringify(data.data));
        }
      }).catch(()=>{
      })
  },

   login(context, payload) {
     globalApp.request().post('/auth/login' , payload)
      .then(({ data }) => {     
        if(data.status){
          context.state.access_token = data.data.token;
          context.state.user = data.data.user;
          context.state.school = data.data.school;
          localStorage.setItem('token' ,data.data.token);
          localStorage.setItem("user", JSON.stringify(data.data.user));
          // console.log(JSON.stringify(data.data.user))
          localStorage.setItem("school", JSON.stringify(data.data.school));  
          router.replace('/home')
        }
      }).catch(() => {
        
        console.log("error");
      })
  },
   logout(context) {
     globalApp.request().post('/auth/logout')
      .then(({data}) => {
        if (data.status) {
          window.location.href = "/";

          localStorage.removeItem('token');
          localStorage.removeItem('user');
          localStorage.removeItem('school');
          localStorage.clear();

          setTimeout(() => {
            router.push({ name: 'login' });
          },); 
        }
      })
  },
   
};
