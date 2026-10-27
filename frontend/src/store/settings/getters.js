import store from '@/store'

export default {

  getRoles(state) {
    return state.roles;
  },

  getPermissions(state) {

    if (state.permissions.length) {
      return state.permissions  
    }else{
      let user = localStorage.getItem('user');
      if (user != undefined) {
        state.permissions = JSON.parse(user).permissions;
      }

      return state.permissions;
    }
  },
  
  currentUser(state) {
    if (!state.user) {
       store.commit('settings/setUser')
     }
    return state.user  ;
  },
  

  currentAccessToken(state) {
    return state.access_token;
  },
  
  getSchoolId(state) {

    if (state.school_id != null) {
      return state.school_id;
    }

    var user = store.getters['settings/currentUser']; 
    return user ? user.school_id : null;
  },

 currentSchool(state) {

    if (!state.school) {
      store.commit('settings/setSchool')
    }

    return state.school ;
  },
};
