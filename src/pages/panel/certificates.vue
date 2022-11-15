<template>
    <div class="grid">
          <div id="right" class="md:col-2 sm:col-12 xs:col-12 lg:col-2 ">
        <div class="card p-fluid">
          <div class="grid formgrid">
  
            <div class="col-12 md:col-12 lg:col-12" style="height:100vh" >
              <div class="flex-1 justify-content-center text-center md:text-center" >
                <div class="font-bold text-2xl pt-7 " style="cursor: pointer"> الشهادات</div>
              </div>
              <Card style="cursor: pointer " class="mt-6" @click="getName(1)">
                <template #content>
                  <div  class="flex-1 justify-content-center text-center md:text-center" >
                    <i class =" pi pi-id-card"   style="font-size: 10rem; "/>
                    <div class="font-bold text-lg">
                        <span>النموذج الخاص بالطلاب</span>
                      </div>
                  </div> 
                  
                </template>
                <template #footer> </template>
              </Card>
              <Card style="cursor: pointer " class="mt-6" @click="getName(2)">
                <template #content>
                  <div  class="flex-1 justify-content-center text-center md:text-center" >
                    <i class =" pi pi-id-card"   style="font-size: 10rem; "/>
                    <div class="font-bold text-lg">
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
  
      <div id="left" class="md:col-10 sm:col-12 xs:col-12">
        
        <div class="card p-fluid" v-if="type==1">
            
            <div class="col-12 md:col-12 lg:col-12" >
               <div class="font-bold text-2xl" style="cursor: pointer">نموذج خاص بالطلاب</div>
            </div>               
            <div class="col-12 md:col-12 lg:col-12" >
                <Card style="cursor: pointer" >
                    <template #title>
                        <div class="flex-1 justify-content-center text-center md:text-center"> شهادة شكر وتقدير</div>
                        <div class="flex-1 justify-content-center text-center md:text-center"> من   {{currentSchool.name}}</div>
                        <div class="flex-1 justify-content-center text-center md:text-center"> الطالب</div>
    </template>

                    <template #content>
                    <div  class="flex-1 justify-content-center text-center md:text-center">
                        <InputText type="text" v-model="value" />
                        <span>
                            الصف الاول ثانوي فصل (3) على النظافة وعدم غيابه خلال شهر ربيع الاول  متمنيين له دوام التوفيق
                        </span>

                        <div class="font-bold text-lg">
                        <span></span>
                        </div>
                    </div> 
                    </template>
                  <template #footer> </template>
              </Card>
                             
            </div>
        </div>
        <div class="card p-fluid" v-if="type==2">
            
            <div class="col-12 md:col-12 lg:col-12" >
               <div class="font-bold text-2xl" style="cursor: pointer">نموذج خاص بالطالبات</div>
            </div>               
            <div class="col-12 md:col-12 lg:col-12" >
                <Card style="cursor: pointer" >
                    <template #content>
                    <div  class="flex-1 justify-content-center text-center md:text-center">
                        <img src="/images/1.png" class="shadow-2 mb-3 res_image" />

                        <div class="font-bold text-lg">
                        <span></span>
                        </div>
                    </div> 
                    </template>
                  <template #footer> </template>
              </Card>
                             
            </div>
        </div>
      </div>

    </div>
</template>
  <script>      
  export default {
    data() {
          return {
            currentSchool:{},
        type:1,
        name:"النموذج الخاص بالطالب"
    }
    },
    mounted() {
		// this.$store.dispatch('settings/fetchSchool');
		this.currentSchool = this.$store.getters['settings/currentSchool'];
    // this.currentUser = this.$store.getters['settings/currentUser'];
	},
    methods: {
        getName(type) {
            this.type = type;
            
        }
    }
   
  };
  </script>
  
<style lang="scss" scoped>
#right .p-card:hover{
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}
.res_image{
  max-width: 90%;
  height: auto;
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

#left .card {
  padding: 50px;
}

#left .p-card {
  box-shadow: none;
  border: 1px solid #b9afaf;
  margin-left: 15px;
  margin-right: 15px;
}
#left .card .col-12 {
  padding: 20px;
}

</style>