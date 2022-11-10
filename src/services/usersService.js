export default class usersService {  
    
    items = [];
    totalRecords = 0;
    single_item = 0;
    pagination = [];
    user_roles = [];
    user_permissions = [];
    // user_departments = [];

    async index(data) {
        return  globalApp.request().get('/users/index'  , {params :data });
    }

    async store(data, id = null) {
        return await globalApp.request().post('/users/store/'+ (id ? id : ''),data);
    }

    getItems(params) {
        return globalApp.request().get(`'/users/index'` , {params:params }  ).then(  ({data}) => {
            this.items = data.data;
            return this;
        });
        
    }
    delete(id) {
        return globalApp.request().delete(`/users/${id}/delete`);
    }
    
    createItem(data){
        return globalApp.request().post(`/system/users/store` , data);
    }

    updateItem(id , data){
        return globalApp.request().put(`/system/users/${id}/update `, data);
    }

    async  fetchItem(id){
        const { data }  = await globalApp.request().get(`/system/users/${id}/show`);
        this.single_item = data.data.user;
        this.user_roles = data.data.roles;
        this.user_permissions = data.data.permissions;
        // this.user_departments = data.data.departments;
    }


    deleteItem(id){
        return globalApp.request().delete(`/system/users/${id}/delete`).then(  ({data}) => {
            this.items = this.items.filter(item =>item.id != id);
            this.totalRecords = this.totalRecords - 1;
            return this;
        });
    }

    deleteSelectedItem(ids){
        return globalApp.request().delete(`/system/users/delete-selected `, {params:{ids} });
    }
    

    
    updateProfile(data) {
        return globalApp.request().post(`/account/profile/update-profile` , data); 
    }
    
    changePassword(data) {
        return globalApp.request().post(`/account/profile/update-password` , data); 
    }
    

    onImportUsers(data){
        return globalApp.request().post(`/system/users/import`, data);
    }
    getUserId(){
        return globalApp.request().get(`system/users/username`);
    }
}