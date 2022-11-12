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

  async login(context, payload) {
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
  async logout(context) {
    await globalApp.request().post('/auth/logout')
      .then(({data}) => {
        if(data.status){
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          localStorage.removeItem('school');
          setTimeout(() => {
            router.push({ name: 'login' });
          }, 3000); 
        }
      })
  },
   
};
