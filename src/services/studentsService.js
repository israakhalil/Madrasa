export default class studentsService {

    items = [];
    async index(data) {
        return await globalApp.request().get('/students/index'  , {params :data });
    }

    async store(data,config) {
        return await globalApp.request().post('/students/store' ,data,config);
    }

    async edit(data, id = null) {
        return await globalApp.request().post('/students/edit/'+ (id ? id : ''),data);
    }
 
    delete(id) {
        return globalApp.request().delete(`/students/${id}/delete`);
    }

}