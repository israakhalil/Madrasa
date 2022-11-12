import store from '@/store'
let open_permissions = false;

export default {
  methods: {
    can(permission) {

      let permissions = store.getters['settings/getPermissions'];

      if (permissions && permissions.length) {
        // console.log(permission)
        const isAuthorized = permissions.find(p => p.code == permission);
        return !!isAuthorized || this.isSuperAdmin();
      }else{
          return open_permissions;
      }
    },
    canAny(permissions_list) {
      let permissions = store.getters['settings/getPermissions'];

      if (permissions && permissions.length) {

        const isAuthorized = permissions.filter(permission => permissions_list.includes(permission.name))
        return !!isAuthorized || this.isSuperAdmin();
      }else{
          return open_permissions;
      }
    },

    hasPermissionTo(permission) {
      let permissions = store.getters['settings/getPermissions'];
      // console.log(permissions);
      if (permissions && permissions.length) {
        const isAuthorized = permissions.find(p => p.code == permission);
        return !!isAuthorized;
      }else{
          return open_permissions;
      }
    },

    hasRole(role) {
      let roles = store.getters['settings/getRoles'];
      roles = roles && roles.length? roles : ['dev'];
      const isAuthorized = roles.find(p => p.name == role);
      return !!isAuthorized;
    },

    isSuperAdmin() {
      return this.hasRole('super-admin');
    }
  }
}
