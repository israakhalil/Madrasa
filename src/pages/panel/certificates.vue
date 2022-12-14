<template>
    <div class="grid"  style="height: 87vh;">
          <div id="right" class="md:col-3 sm:col-12 xs:col-12 lg:col-3 " >
        <div class="card p-fluid re_quick list_container" >
          <div class="grid formgrid ">
  
            <div class="col-12 md:col-12 lg:col-12 list_container2">
              <div class="flex-1 justify-content-center text-center md:text-center" >
                <div class="font-bold text-2xl pt-7 " style="cursor: pointer"> الشهادات</div>
              </div>
              <Card style="cursor: pointer " class="mt-6" @click="getName(1)">
                <template #content>
                  <div  class="flex-1 justify-content-center text-center md:text-center" >
                    <i class =" pi pi-id-card"   style="font-size: 16vh; "/>
                    <div class="font-bold text-2xl">
                     
                        <span>النموذج الخاص بالطلاب</span>
                      </div>
                  </div> 
                  
                </template>
                <template #footer> </template>
              </Card>
              <Card style="cursor: pointer " class="mt-6" @click="getName(2)">
                <template #content>
                  <div  class="flex-1 justify-content-center text-center md:text-center" >
                    <i class =" pi pi-id-card"   style="font-size: 16vh; "/>
                    <div class="font-bold text-2xl">
                        <span>النموذج الخاص بالطالبات</span>
                      </div>
                  </div> 
                  
                </template>
                <template #footer> </template>
              </Card>
            </div>

  
          </div>
        </div>
      </div>
  
      <div id="left" class="md:col-9 sm:col-12 xs:col-12 " >

        <div class="card p-fluid " v-if="type==1">
            
          <div class="grid mt-2 font-bold mr-5" >
              <div class="col-6 md:col-6 lg:col-6 justify-content-right">
                <span class="font-bold text-xl" style="color: var(--primary-color)">
                  النموذج الخاص بالطلاب
                </span>
              </div>
              <div class="col-6 md:col-6 lg:col-6 justify-content-left">
                <div class="grid">
                  <div class="field col-8 md:col-8 lg:col-8">
                    <Button
                  label="ادخال بيانات الشهادة"
                  
                  class="p-button-outlined ml-3" 
                  @click="openNew"/>
                </div>
                <div class="field col-4 md:col-4 lg:col-4">
                  <Button
                  label="طباعة"
                  icon="pi pi-print"
                  class="p-button-outlined ml-3" 
                  @click="print"/>
                </div>
                </div>
             
          
          <div>
          </div>
      </div>
            
          </div>
            <div class="col-12 md:col-12 lg:col-12" id="printMe" >
              <img src="/images/certifications.png" alt="Snow" style="width:100%; height: 700px" >
               <div class="centered flex-1 justify-content-center text-center">
                <div class="col-12 md:col-12 lg:col-12 text-">
                <span class="font-bold font-b text-5xl"> شهادة شكر وتقدير </span>
                </div>
                <div class="col-12 md:col-12 lg:col-12 mt-1">
                <span class="font-bold text-3xl"> من {{currentSchool.name}} 
                 </span>
                </div>
                <div class="col-12 md:col-12 lg:col-12 mt-2">
                <span class="text-2xl" style="padding-top:100px">  الطالب 
                 </span>
                </div>
                <div class="col-12 md:col-12 lg:col-12">
                <span class=" font-bold text-6xl" >  {{certification.name}}
                 </span>
                 </div>

                <div class="col-12 md:col-12 lg:col-12 mt-0">
                <span class="text-2xl">  
                  {{certification.text}}
                 </span>
                </div>

                <div class="col-12 md:col-12 lg:col-12 mt-4">
                  <div class="grid grid1 justify-content-center text-center">
                    <div class="field col-3" style="border-bottom: 4px ridge;" > {{certification.date}} </div>
                    <div class="field col-3">  </div>
                    <div class="field col-3">  </div>
                    <div class="field col-3 " style="border-bottom: 4px ridge;">{{certification.sign}}  </div>
                  </div>

                  <div class="grid grid1 justify-content-center text-center">
                    <div class="field col-3" > التاريخ </div>
                    <div class="field col-3">  </div>
                    <div class="field col-3">  </div>
                    <div class="field col-3">  توقيع مديرة المدرسة</div>
                  </div>
                 </div>
               </div>
            </div>
        </div>

        <div class="card p-fluid " v-if="type==2">
            
          <div class="grid mt-2 font-bold mr-5 ">
              <div class="col-6 md:col-6 lg:col-6 justify-content-right">
                <span class="font-bold text-xl" style="color: var(--primary-color)">
                  النموذج الخاص بالطالبات
                </span>
              </div>
              <div class="col-6 md:col-6 lg:col-6 justify-content-left">
                <div class="grid">
                  <div class="field col-8 md:col-8 lg:col-8">
                    <Button
                  label="ادخال بيانات الشهادة"
                  
                  class="p-button-outlined ml-3" 
                  @click="openNew"/>
                </div>
                <div class="field col-4 md:col-4 lg:col-4">
                  <Button
                  label="طباعة"
                  icon="pi pi-print"
                  class="p-button-outlined ml-3" 
                  @click="printFemale"/>
                </div>
                </div>
             
          
          <div>
          </div>
      </div>
            
        </div>             

            <div class="col-12 md:col-12 lg:col-12" id="printFemale" >
              <img src="/images/certification_female.png" alt="Snow" style="width:100%; height: 700px" >
               <div class="centered flex-1 justify-content-center text-center">
                <div class="col-12 md:col-12 lg:col-12 text-">
                <span class="font-bold font-b text-5xl"> شهادة شكر وتقدير </span>
                </div>
                <div class="col-12 md:col-12 lg:col-12 mt-1">
                <span class="font-bold text-3xl"> من {{currentSchool.name}} 
                 </span>
                </div>
                <div class="col-12 md:col-12 lg:col-12 mt-2">
                <span class="text-2xl" style="padding-top:100px">  الطالب 
                 </span>
                </div>
                <div class="col-12 md:col-12 lg:col-12">
                <span class=" font-bold text-6xl" >  {{certification.name}}
                 </span>
                 </div>

                <div class="col-12 md:col-12 lg:col-12 mt-0">
                <span class="text-2xl">  
                  {{certification.text}}
                 </span>
                </div>

                <div class="col-12 md:col-12 lg:col-12 mt-4">
                  <div class="grid grid1 justify-content-center text-center">
                    <div class="field col-3" style="border-bottom: 4px ridge;" > {{certification.date}} </div>
                    <div class="field col-3">  </div>
                    <div class="field col-3">  </div>
                    <div class="field col-3 " style="border-bottom: 4px ridge;">{{certification.sign}}  </div>
                  </div>

                  <div class="grid grid1 justify-content-center text-center">
                    <div class="field col-3" > التاريخ </div>
                    <div class="field col-3">  </div>
                    <div class="field col-3">  </div>
                    <div class="field col-3">  توقيع مديرة المدرسة</div>
                  </div>
                 </div>
               </div>
            </div>
        </div>



        <Dialog
          v-model:visible="infoDialog"
          :style="{ width: '500px' }"
          header="بيانات الشهادة "
          :modal="true"
          class="p-fluid font-bold text-lg">
          <div class="field">
            <label for="name" class="mb-3">اسم الطالب </label>
            <InputText
              id="name"
              v-model.trim="certification.name"
            />
          </div>
          <div class="field">
            <label for="text" class="mb-3">نص الشهادة    </label>
            <Textarea
              id="text"
              v-model.trim="certification.text"
            />
          </div>
          <!-- <div class="field">
            <label for="name" class="mb-3">اسم الصف كاملا  </label>
            <InputText
              id="name"
              v-model.trim="certification.class_name"
            />
          </div>

          <div class="field">
            <label for="name" class="mb-3">الشهر </label>
            <InputText
              id="name"
              v-model.trim="certification.month"
            />
          </div> -->
          <div class="field">
            <label for="name" class="mb-3">التاريخ  </label>
            <InputText
              id="name"
              v-model.trim="certification.date"
            />
          </div>
          <div class="field">
            <label for="name" class="mb-3">توقيع </label>
            <InputText
              id="name"
              v-model.trim="certification.sign"
            />
          </div>

          <div class="field">
            <!-- <Button label="اغلاق" icon="pi pi-times" class="p-button-text" @click="hideDialog"/> -->

            <Button label="اغلاق" class="mt-5" type="submit" @click="hideDialog"  />
          </div>
        </Dialog>
        
      </div>

    </div>
</template>
  <script>      
  export default {
    data() {
          return {
            currentSchool: {},
            infoDialog: false,
            type: 0,
            certification: {
              name: "تجربة اسم ",
              month:"ربيع الاول"
            },
            name:"النموذج الخاص بالطالب"
    }
    },
    mounted() {
		// this.$store.dispatch('settings/fetchSchool');
		this.currentSchool = this.$store.getters['settings/currentSchool'];
    // this.currentUser = this.$store.getters['settings/currentUser'];
	},
    methods: {
        getName(type=0) {
        this.type = type;
        this.certification={}
        this.certification;
      },
      openNew() {
        this.infoDialog = true;
      },
      hideDialog() {
            this.infoDialog = false;
            // this.submitted = false;
        },
      print () {
      // Pass the element id here
        this.$htmlToPaper('printMe');
      this.certification={}
      },
      printFemale () {
      // Pass the element id here
        this.$htmlToPaper('printFemale');
        this.certification={}

      },
    }
   
  };
  </script>

<style lang="scss" scoped>

// .re_quick{
//   overflow-y: scroll;
//   height: 90vh;
// }
.centered {
  position: absolute;
  top: 51%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.text-5xl {
    font-size: 3rem !important;
    color: green;
}

// .product-badge.status-lowstock {
//     background: #ff9946;
//     color: #ffffff;
// }
#right .p-card:hover{
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}
.res_image{
  max-width: 100%;
  height: 90vh;
 }

 #right {
  right: 0;
  position: fixed;
  padding-right: 0%;
  padding-left: 0%;
  //    z-index: 1;
}

#right .p-card{
    box-shadow: none;
    border: 1px solid #b9afaf;
    // box-shadow:none;
}

#left {
  left: 0;
  position: absolute;
}

.card {
  border-radius: 0%;
  /*padding: 0rem;*/
}
.grid {
  margin-left: 0rem;
  margin-right: 0rem;
}
// #left .card {
//   padding: 50px;
// }

// #left .p-card {
//   box-shadow: none;
//   border: 1px solid #b9afaf;
//   margin-left: 15px;
//   margin-right: 15px;
// }
// #left .card .col-12 {
//   padding: 20px;
// }

// #student_image{
//   background: url("/images/crrrrr.png"); 
//   background-repeat: no-repeat;
//   background-size: 100% 100%;
  
// }
::-webkit-scrollbar {
    width: 14px;
  }
</style>