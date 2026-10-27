export default class violationsService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/violations/store/',data);
    }


    async index(data) {
        return await globalApp.request().get('/violations/index'  , {params :data });
    }

    async save(data, id = null) {
        return await globalApp.request().post('/violations/save/'+ (id ? id : ''),data);
    }
    delete(id) {
        return globalApp.request().delete(`/violations/${id}/delete`);
    }
}