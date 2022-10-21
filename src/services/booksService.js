export default class booksService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/books/store/',data);
    }





}