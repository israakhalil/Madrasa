export default class schoolsService {

    items = [];
    async index(data) {
        return  globalApp.request().get('/schools/index'  , {params :data });
    }

    async create() {
        return  globalApp.request().get('/schools/create');
    }


    async store(data , id = null) {
        return  globalApp.request().post('/schools/store/' + (id ? id : '') , data);
    }


    async edit(id) {
        return  globalApp.request().get(`/schools/${id}/edit` );
    }


    deleteItem(id) {
        return globalApp.request().delete(`/schools/${id}/delete`);
    }
    deleteSelectedItem(ids){
        return globalApp.request().delete(`/schools/delete-selected `, {params:{ids} });
    }



}