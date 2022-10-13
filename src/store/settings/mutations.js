export default {
 
  setAccessToken(state) {
    if (state.access_token != null) {
      return state.access_token;
    }else{
      let token = localStorage.getItem('token');
      if (token != undefined) {
        state.access_token = token;
      }
      return state.access_token;
    }
  },

  setUser(state) {
     if (state.user != null ) {
      return state.user;
    }else{

      let user = localStorage.getItem('user');
      if (user != undefined) {
        state.user = JSON.parse(user);
      }
      this.commit("settings/setAccessToken")

      return state.user;
    }

  },
 
  setSchool(state) {
    if (state.school != null ) {
     return state.school;
   }else{

     let school = localStorage.getItem('school');
     if (school != undefined) {
       state.school = JSON.parse(school);
     }
     this.commit("settings/setAccessToken")

     return state.school;
   }

 },
};
