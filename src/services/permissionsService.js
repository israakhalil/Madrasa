export default class permissionService {

    items = [];
    async index(data) {
        return  globalApp.request().get('/permissions/index'  , {params :data });
    }




}