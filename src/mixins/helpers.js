
export default {


    methods: {
        schoolLogo() {
            return (process.env.NODE_ENV === 'production' ? '': '') + '/images/logo-white.svg';
        }, 

        
        getConstant(arr, value){
            let obj= arr.find((item)=>item.id==value )
            return obj.name
        }
 
    }


}