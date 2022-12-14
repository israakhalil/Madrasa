<template>
    <div class="grid list_container" style="height: 87vh; padding:0rem;">
      <div class="col-12 md:col-12 re_quick">
        <div class="card list_container2">
          <div class="grid p-fluid mt-3 font-bold mr-5">
              <div class="col-12 md:col-12 justify-content-right">
                <span class="font-bold text-xl ">المراحل المدرسية <i class="pi pi-chevron-right"></i> <span style="color: var(--primary-color)">{{this.name}}</span></span>
              </div>
           
          </div>
          <div class="grid p-fluid mt-3 mr-5">
            <div class="field col-12 md:col-12"><span class="font-bold text-xl "> الاضافات السريعة </span></div> 
            <div v-if="this.can('ABSENCE_ADD_EDIT')" class="field col-12 md:col-2 sm:col-4">
                <Button label="اضافة غياب" class="p-button-outlined" :class="[type==1?'x':'']" @click="this.$router.push({ name: 'quick-index', params: { type: 1 } })"/>
             </div>
             <div v-if="this.can('DELAY_ADD_EDIT')" class="field col-12 md:col-2 sm:col-4">
                <Button label="اضافة تاخير" class="p-button-outlined"  :class="[type==2?'x':'']"  @click="this.$router.push({ name: 'quick-index', params: { type: 2 } })"/>
             </div>
             <div v-if="this.can('VIOLATION_ADD_EDIT')" class="field col-12 md:col-3 sm:col-4">
                <Button label="اضافة مخالفة سلوكية" class="p-button-outlined" :class="[type==3?'x':'']" @click="this.$router.push({ name: 'quick-index', params: { type: 3 } })"/>
             </div>
             <div v-if="this.can('LEAVE_ADD_EDIT')" class="field col-12 md:col-2 sm:col-4">
                <Button label="اضافة استئذان" class="p-button-outlined" :class="[type==4?'x':'']" @click="this.$router.push({ name: 'quick-index', params: { type: 4 } })"/>
             </div>
             <div v-if="this.can('BOOK_ADD_EDIT')" class="field col-12 md:col-3 sm:col-4">
                <Button label="اضافة تسليم كتب" class="p-button-outlined" :class="[type==5?'x':'']" @click="this.$router.push({ name: 'quick-index', params: { type: 5 } })"/>
             </div>
            </div>
            <template v-if="type==1"> 
                <AbsenceLayout :levels=levels :classes=classes :students=students />
            </template>

            <template v-if="type==2" >
                <DelayLayout :levels=levels :classes=classes :students=students />
            </template>

            
            <template v-if="type==3">
                <ViolationLayout :levels=levels :classes=classes :students=students />
            </template>

            
            <template v-if="type==4">
                <LeaveLayout :levels=levels :classes=classes :students=students />
            </template>
            
            <template v-if="type==5">
                <BookLayout :levels=levels :classes=classes :students=students />
            </template>
        </div>
   
  

      </div>
    </div>
</template>

<script>
import LevelsService from "@/services/levelsService";
import SchoolsService from "@/services/schoolsService";
import StudentsService from "@/services/studentsService";



export default {
    props: ["type"],
    data() {
        return {
            name: null,
            classes: [],
            levels: [],
            students:[],
        }
    },
    created() {
        // this.levelsService = new LevelsService();
        this.service = new SchoolsService();
        this.studentsService = new StudentsService();

    },

    methods: {

        // getClasses() {
        //     if (this.classes.length) {
        //         item.classes=this.classes.filter((_class) => { return _class.level_id == item.level_id });

        //     }
        //     else {
        //         this.query = { level_id: item.level_id };
        //         this.classesService.index(this.query).then(({ data }) => {
        //         item.classes = data.data.Classes;
        //         });
        //     }
        // },
        getStudents() {
            // this.query = { class_id: item.class_id };
            this.studentsService.index(this.query).then(({ data }) => {
                this.students = data.data.Students;
            });
    },
    
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
        // this.getLevels();
        this.currentUser = this.$store.getters['settings/currentUser'];
        
        this.service.index(this.query).then(({ data }) => {
            if (data.code == 200) {
                this.levels = data.data.Levels;
                this.classes = data.data.Classes;

                if (this.currentUser.role_id == 3) {
                    this.classes = this.currentUser.classes;
                    this.levels = this.levels.filter(level => {
                        return this.currentUser.classes.map((el) => { return el.level_id }).includes(level.id)
                    });
                }
            }
            else {
                this.error = true;
            }


        });
        this.getStudents();
            
        // this.levelsService.index().then(({ data }) => {
        // if (data.code == 200) {
        //     this.levels = data.data.Levels;
        //     this.currentClasses =data.data.Classes;
        //     console.log( this.currentClasses);
          
        // if (this.currentUser.role_id == 3) {
        //     this.currentClasses = this.currentUser.classes;
        //     this.levels= this.levels.filter(level => {
        //     return this.currentClasses.map((el) => { return el.level_id }).includes(level.id)
        // });
        
        // } else {
        //     this.currentClasses =data.data.Classes;
        //     } 
        // console.log( this.currentClasses);
        
                   
    //     }
    //   });

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
::-webkit-scrollbar {
    width: 14px !important;

  }

  .grid {
  margin-left: 0rem;
  margin-right: 0rem;
}
  </style>
  
