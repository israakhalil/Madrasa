export default class constantsService {

    async fetchAbsenceTypes() {
        return await globalApp.request().get('/constants/absenceTypes');
    }  
    async fetchViolationDegrees() {
        return await globalApp.request().get('/constants/violationDegrees');
    }  
    async fetchViolationProcedures() {
        return await globalApp.request().get('/constants/violationProcedures');
    }  

}