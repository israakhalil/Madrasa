export default class levelsService {

    items = [];
    async index(data) {
        return  globalApp.request().get('/levels/index'  , {params :data });
    }
    async grouped(data) {
        return  globalApp.request().get('/levels/grouped'  , {params :data });
    }

    async store(data , id = null) {
        return  globalApp.request().post('/levels/store/' + (id ? id : '') , data);
    }

    delete(id) {
        return globalApp.request().delete(`/levels/${id}/delete`);
    }




}