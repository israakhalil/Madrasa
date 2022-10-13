export default class gradesService {

    items = [];
    async index(data) {
        return await globalApp.request().get('/classes/index'  , {params :data });
    }

    async create() {
        return await globalApp.request().get('/classes/create');
    }


    async store(data,config,id = null) {
        return await globalApp.request().post('/classes/store/' + (id ? id : '') ,data,config);
    }


    async edit(id) {
        return await globalApp.request().get(`/classes/${id}/edit` );
    }


    deleteItem(id) {
        return globalApp.request().delete(`/classes/${id}/delete`);
    }
    deleteSelectedItem(ids){
        return globalApp.request().delete(`/classes/delete-selected `, {params:{ids} });
    }



}