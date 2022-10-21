export default class violationsService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/violations/store/',data);
    }





}