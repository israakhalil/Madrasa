<template>
    <div>

        <div class="grid p-fluid mt-5 font-bold mr-5">
            <span class="font-bold text-xl">بيانات الطالب  </span>
           </div>

            <DataTable  :value="student" class="p-datatable-lg font-bold"  showGridlines  responsiveLayout="scroll">
                <Column field="name" header="اسم الطالب"></Column>
                <Column field="id_number" header="رقم الهوية"> </Column>
                <Column field="date_of_birth" header="تاريخ الميلاد"></Column>
                <Column field="phone_1" header=" هاتف ولي الامر (الاول)"></Column>
            </DataTable> 
    </div>
    
</template>

<script>

export default {
    props:['student'],
   data() {
       return {};
   },
    mounted() {
        // this.$store.dispatch('settings/fetchSchool');
   },
   methods: {},

};
</script>