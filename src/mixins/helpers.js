import moment from "moment";
import 'moment/min/locales.min'
export default {


    methods: {
        schoolLogo() {
            return (process.env.NODE_ENV === 'production' ? '': '') + '/images/logo-white.svg';
        }, 

        formatDate(date) {
            return moment(date).format("MM/DD/YYYY");
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
        },

        getDay(date) {
            var day = moment(date, "YYYY-MM-DD HH:mm:ss").locale("ar").format('dddd')
            //let day = dt.format('dddd');
            // Thursday
            if (day == 'Thursday') {
                return "الخميس"
            }
            else if (day == "Wednesday") {
                return "الاربعاء"
            }
            else if(day == 'Tuesday') {
                return 'الثلاثاء'
            }
            else if (day == 'Monday') {
                return "الاثنين"
            }
            else if (day == "Sunday") {
                return 'الاحد'
            }
            else if (day == 'Saturday') {
                return 'السبت'
            }
            else if (day == 'Friday') {
                return 'الجمعة'
            }
            // return day
        }
 
    }


}