export default class delaysService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/delays/store/',data);
    }





}