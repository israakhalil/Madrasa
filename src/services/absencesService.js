export default class absencesService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/absences/store/',data);
    }





}