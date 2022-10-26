export default class absencesService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/absences/store/',data);
    }
    async save(data, id = null) {
        return await globalApp.request().post('/absences/save/'+ (id ? id : ''),data);
    }

    async index(data) {
        return await globalApp.request().get('/absences/index'  , {params :data });
    }

    delete(id) {
        return globalApp.request().delete(`/absences/${id}/delete`);
    }


}