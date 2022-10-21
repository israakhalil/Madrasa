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


            <template v-if="type==1">
                <AbsenceLayout/>
            </template>

            <template v-if="type==2">
                <DelayLayout/>
            </template>

            
            <template v-if="type==3">
                <ViolationLayout/>
            </template>

            
            <template v-if="type==4">
                <LeaveLayout/>
            </template>
            
            <template v-if="type==5">
                <BookLayout />
            </template>
        </div>
   
  

      </div>
    </div>
</template>

<script>
  
export default {
    props: ["type"],
    data() {
        return {
            name:null
        }  
    },
    watch: {
        type() {
            if (this.type == 1) {
            this.name="اضافة غياب"
        }
        if (this.type == 2) {
            this.name="اضافة تاخير"
        }
        if (this.type == 3) {
            this.name="اضافة مخالفة سلوكية"
        }
        if (this.type == 4) {
            this.name="اضافة استئذان"
        }
        if (this.type == 5) {
            this.name="اضافة تسليم كتاب"
        }
        },
    },
    mounted() { 
        if (this.type == 1) {
            this.name="اضافة غياب"
        }
        if (this.type == 2) {
            this.name="اضافة تاخير"
        }
        if (this.type == 3) {
            this.name="اضافة مخالفة سلوكية"
        }
        if (this.type == 4) {
            this.name="اضافة استئذان"
        }
        if (this.type == 5) {
            this.name="اضافة تسليم كتاب"
        }
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
.middle{
    width: 70%;
    /* margin-right: 5rem; */
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
  
