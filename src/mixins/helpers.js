import moment from "moment";
export default {


    methods: {
        schoolLogo() {
            return (process.env.NODE_ENV === 'production' ? '': '') + '/images/logo-white.svg';
        }, 

        formatDate(date) {
            return moment(date).format("DD-MM-YYYY");
        },
        formatDateForSearch(date) {
            return moment(date).format("YYYY-MM-DD");
        },
        parseDateRange(filter_date) {
            let dates = [];
            if (Object.keys(filter_date).length) {
                Object.entries(filter_date).forEach((item, index) => {
                    dates[index] = item[1] ? this.formatDate(item[1]) : null
                })
            }

            return dates;
        },
        getConstant(arr, value){
            let obj= arr.find((item)=>item.id==value )
            return obj.name
        }
 
    }


}