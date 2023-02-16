export default class constantsService {

    async fetchAbsenceTypes() {
        return await globalApp.request().get('/constants/absenceTypes');
    }  
    async storeAbsence(data, id = null) {
        // return await globalApp.request().post('/absences/save/'+ (id ? id : ''),data);
        return await globalApp.request().post('/constants/storeAbsence/' + (id ? id : '') ,data);
    }
    deleteAbsence(id) {
        return globalApp.request().delete(`/constants/${id}/deleteAbsence`);
    }



    async fetchViolationDegrees() {
        return await globalApp.request().get('/constants/violationDegrees');
    } 
    async storeDegrees(data,id = null) {
        return await globalApp.request().post('/constants/storeDegrees/' + (id ? id : '') ,data);
    }
    deleteDegrees(id) {
        return globalApp.request().delete(`/constants/${id}/deleteDegrees`);
    }



    async fetchViolationProcedures() {
        return await globalApp.request().get('/constants/violationProcedures');
    }  
    async storeProcedures(data,id = null) {
        return await globalApp.request().post('/constants/storeProcedures/' + (id ? id : '') ,data);
    }
    deleteProcedures(id) {
        return globalApp.request().delete(`/constants/${id}/deleteProcedures`);
    }
}