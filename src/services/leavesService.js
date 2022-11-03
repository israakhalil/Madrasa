export default class leavesService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/leaves/store',data);
    }


    async index(data) {
        return await globalApp.request().get('/leaves/index'  , {params :data });
    }
    async save(data, id = null) {
        return await globalApp.request().post('/leaves/save/'+ (id ? id : ''),data);
    }
    delete(id) {
        return globalApp.request().delete(`/leaves/${id}/delete`);
    }

}