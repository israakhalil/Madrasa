export default class booksService {

    items = [];

    async store(data) {
        return await globalApp.request().post('/books/store',data);
    }

    async index(data) {
        return await globalApp.request().get('/books/index'  , {params :data });
    }


    async save(data, id = null) {
        return await globalApp.request().post('/books/save/'+ (id ? id : ''),data);
    }
    delete(id) {
        return globalApp.request().delete(`/books/${id}/delete`);
    }
}