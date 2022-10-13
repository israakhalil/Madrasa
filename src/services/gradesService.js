export default class gradesService {

    items = [];
    async index(data) {
        return  globalApp.request().get('/levels/index'  , {params :data });
    }

    async create() {
        return  globalApp.request().get('/levels/create');
    }


    async store(data , id = null) {
        return  globalApp.request().post('/levels/store/' + (id ? id : '') , data);
    }


    async edit(id) {
        return  globalApp.request().get(`/levels/${id}/edit` );
    }


    deleteItem(id) {
        return globalApp.request().delete(`/levels/${id}/delete`);
    }
    deleteSelectedItem(ids){
        return globalApp.request().delete(`/levels/delete-selected `, {params:{ids} });
    }



}