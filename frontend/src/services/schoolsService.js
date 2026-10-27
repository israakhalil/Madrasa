export default class schoolsService {

    items = [];
    async index(data) {
        return  globalApp.request().get('/schools/index'  , {params :data });
    }

    async schools(data) {
        return  globalApp.request().get('/schools/all', {params :data });
    }


    async store(data , id = null) {
        return  globalApp.request().post('/schools/store/' + (id ? id : '') , data);
    }


    async edit(id) {
        return  globalApp.request().get(`/schools/${id}/edit` );
    }


    delete(id) {
        return globalApp.request().delete(`/schools/${id}/delete`);
    }
    deleteSelectedItem(ids){
        return globalApp.request().delete(`/schools/delete-selected `, {params:{ids} });
    }



}