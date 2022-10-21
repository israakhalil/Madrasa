export default class leavesService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/leaves/store/',data);
    }





}