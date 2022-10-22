export default class studentsService {

    items = [];
    async index(data) {
        return await globalApp.request().get('/students/index'  , {params :data });
    }

    async create() {
        return await globalApp.request().get('/students/create');
    }


    async store(data,config) {
        return await globalApp.request().post('/students/store' ,data,config);
    }


    async edit(id) {
        return await globalApp.request().get(`/students/${id}/edit` );
    }


    deleteItem(id) {
        return globalApp.request().delete(`/students/${id}/delete`);
    }
    deleteSelectedItem(ids){
        return globalApp.request().delete(`/students/delete-selected `, {params:{ids} });
    }



}