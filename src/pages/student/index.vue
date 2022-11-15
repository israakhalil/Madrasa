<template>
    <div class="grid">
      <div class="col-12 md:col-12">
        <div class="card">
          <div class="grid p-fluid mt-3 font-bold mr-5">
              <div class="col-12 md:col-12 justify-content-right">
                <span class="font-bold text-xl ">المراحل المدرسية <i class="pi pi-chevron-right"></i> <span style="color: var(--primary-color)">{{this.name}}</span></span>
              </div>
           
          </div>
          <div class="grid p-fluid mt-3 mr-5">
            <div class="field col-12 md:col-12"><span class="font-bold text-xl "> الاضافات السريعة </span></div> 
            <div class="field col-12 md:col-2 sm:col-4">
                <Button label="اضافة غياب" class="p-button-outlined" :class="[type==1?'x':'']" @click="this.$router.push({ name: 'quick-index', params: { type: 1 } })"/>
             </div>
             <div class="field col-12 md:col-2 sm:col-4">
                <Button label="اضافة تاخير" class="p-button-outlined"  :class="[type==2?'x':'']"  @click="this.$router.push({ name: 'quick-index', params: { type: 2 } })"/>
             </div>
             <div class="field col-12 md:col-2 sm:col-4">
                <Button label="اضافة مخالفة سلوكية" class="p-button-outlined" :class="[type==3?'x':'']" @click="this.$router.push({ name: 'quick-index', params: { type: 3 } })"/>
             </div>
             <div class="field col-12 md:col-2 sm:col-4">
                <Button label="اضافة استئذان" class="p-button-outlined" :class="[type==4?'x':'']" @click="this.$router.push({ name: 'quick-index', params: { type: 4 } })"/>
             </div>
             <div class="field col-12 md:col-2 sm:col-4">
                <Button label="اضافة تسليم كتب" class="p-button-outlined" :class="[type==5?'x':'']" @click="this.$router.push({ name: 'quick-index', params: { type: 5 } })"/>
             </div>
            </div>
        </div>
   
  

      </div>
    </div>
</template>

<script>
import ClassesService from "@/services/classesService";
import StudentsService from "@/services/studentsService";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
    props: ["class_id","id"],
    data() {
        return {
            name:null
        }  
    },
    watch: {
       
       
    },
    created() {
    this.classesService = new ClassesService();
    this.studentsService = new StudentsService();
  
  },
    mounted() { 
        this.query = { id: this.class_id };
        this.classesService.index(this.query).then(({ data }) => {
      if (data.code == 200) {
        this.class = data.data.Classes[0];
      }
    });
    // this.getStudents(this.query)
    }
  };
  </script>
  
  <style scoped>
 
 .card {
  border-radius: 0%;
}
.grid{
    margin-left: -0.035rem;
}
.md\:col-12{
    padding:0.5rem 0.5rem 0.5rem 0.0rem ;
}

.x{
    background-color: blueviolet;
    color: white;
}
.p-button.p-button-outlined:enabled:hover {
    background-color: blueviolet;
    color: white;
}
  </style>
  
