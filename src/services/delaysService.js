export default class delaysService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/delays/store',data);
    }

    async index(data) {
        return await globalApp.request().get('/delays/index'  , {params :data });
    }

    async save(data, id = null) {
        return await globalApp.request().post('/delays/save/'+ (id ? id : ''),data);
    }
    delete(id) {
        return globalApp.request().delete(`/delays/${id}/delete`);
    }

}