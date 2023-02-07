<template>
  <div class="grid list_container" style="height: 87vh">
    <div class="col-12 md:col-12 re_quick">
      <div class="card list_container2">
        <div class="grid p-fluid mt-3 font-bold mr-5">

          <div class="col-12 md:col-11 justify-content-right">
            <span class="font-bold text-xl">المراحل المدرسية <i class="pi pi-chevron-right"></i>
              {{ this.class.level_name }} <i class="pi pi-chevron-right"></i>
              <span style="cursor: pointer"
                @click="this.$router.push({name: 'class-all',params: { id: this.class_id }, })">
                {{ this.class.name }} <i class="pi pi-chevron-right"></i></span>
              <span style="color: var(--primary-color)">{{ this.student.name }}
              </span>
            </span>
          </div>
          <div class="col-12 md:col-1 ">
            <Button 
              width="70%"
              label="طباعة"
              class="p-button-outlined align-left"
              @click="printall"
              />
            </div>

        </div>
        <div id="printall">
        <Student :id="id" />
        <hr class="student_print_hide"/>

       
        <div class="grid p-fluid mt-5 font-bold mr-5">
            <span class="font-bold text-xl">البيانات المسجلة</span>
        </div>

        <div id="printAbsence"  v-if="this.can('ABSENCE_ADD_EDIT')" class="grid  p-fluid mt-5 font-bold mr-5">
          <!-- <div  hidden :class="'name-'+grp_sign"  >
            <div class="grid p-fluid mt-5 font-bold mr-5">
            <span class="font-bold text-xl">بيانات الطالب  </span>
        </div>
         الطالب : {{this.student.name}}</div>  -->

          <div hidden class="col-12 md:col-12 mt-5" :class="'name-'+grp_sign">
            <printStudent :student="student1"/>
          
            <!-- <div class="grid p-fluid mt-5 font-bold mr-5">
            <span class="font-bold text-xl">بيانات الطالب  </span>
           </div>

            <DataTable  :value="student1" class="p-datatable-lg font-bold"  showGridlines  responsiveLayout="scroll">
                <Column field="name" header="اسم الطالب"></Column>
                <Column field="id_number" header="رقم الهوية"> </Column>
                <Column field="date_of_birth" header="تاريخ الميلاد"></Column>
                <Column field="phone_1" header=" هاتف ولي الامر (الاول)"></Column>
            </DataTable>  -->
      </div>
           <AbsenceStudent  :student_id="id" :class_id="class_id"  @sign="sign" />
        </div>

        <div id="printDelays"  v-if="this.can('DELAY_ADD_EDIT')" class="grid p-fluid mt-5 font-bold mr-5">
          <div hidden class="col-12 md:col-12 mt-5" :class="'name-'+grp_sign">
            <printStudent :student="student1"/>
            </div>
            <DelayStudent  :student_id="id" :class_id="class_id" @sign="sign" />
        </div>
   
        <div  id="printLeaves" v-if="this.can('LEAVE_ADD_EDIT')" class="grid p-fluid mt-5 font-bold mr-5">
          <div hidden class="col-12 md:col-12 mt-5" :class="'name-'+grp_sign">
            <printStudent :student="student1"/>
            </div>
            <LeaveStudent  :student_id="id" :class_id="class_id" @sign="sign" />
        </div>

        <div id="printViolations" v-if="this.can('VIOLATION_ADD_EDIT')"  class="grid p-fluid mt-5 font-bold mr-5">
          <div hidden class="col-12 md:col-12 mt-5" :class="'name-'+grp_sign">
            <printStudent :student="student1"/>
            </div>
            <ViolationStudent  :student_id="id" :class_id="class_id" @sign="sign" />
        </div>

        <div id="printBook" v-if="this.can('BOOK_ADD_EDIT')" class="grid p-fluid mt-5 font-bold mr-5">
          <div hidden class="col-12 md:col-12 mt-5" :class="'name-'+grp_sign">
            <printStudent :student="student1"/>
            </div>
            <BookStudent  :student_id="id" :class_id="class_id" @sign="sign" />
        </div>
      </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClassesService from "@/services/classesService";
import StudentsService from "@/services/studentsService";
import DelayStudent from "./partial/delay.vue";
import LeaveStudent from "./partial/leave.vue";
import ViolationStudent from "./partial/violation.vue";
import BookStudent from "./partial/book.vue";
import Student from "./partial/student.vue";
import printStudent from "./partial/printStudent.vue";

export default {
    props: ["class_id", "id"],
    data() {
        return {
            class: [],
          student: [],
          student1:[],
          grp_sign:1,
            show:false
        };
    },
    watch: {},
    created() {
        this.classesService = new ClassesService();
        this.studentsService = new StudentsService();
    },
  methods: {
    sign(value) {
      console.log(value);
      this.grp_sign=value
    },
        getStudents() {
            this.studentsService.index({ id: this.id }).then(({ data }) => {
                if (data.code == 200) {
                  this.student = data.data.Students[0];
                  this.student1 = data.data.Students;
                   
                }
            });
      },
      printall() {
        this.grp_sign = 2;
        setTimeout(() => this.$htmlToPaper('printall'), 10)

        // this.$htmlToPaper('printall');
      },

    },
    mounted() {
        this.query = { id: this.class_id };
        this.classesService.index(this.query).then(({ data }) => {
            if (data.code == 200) {
              this.class = data.data.Classes[0];
            }
        });
      this.getStudents();
    },
    components: { DelayStudent ,LeaveStudent, ViolationStudent, BookStudent ,Student,printStudent}
};
</script>

<style scoped>
.card {
  border-radius: 0%;
}
.grid {
  margin-left: -0.035rem;
}
/* .md\:col-12 {
  padding: 0.5rem 0.5rem 0.5rem 0rem;
} */

.x {
  background-color: blueviolet;
  color: white;
}
.p-button.p-button-outlined:enabled:hover {
  background-color: blueviolet;
  color: white;
}
.grid {
  margin-left: 0rem;
  margin-right: 0rem;
}
::-webkit-scrollbar {
    width: 14px !important;

  }
</style>
