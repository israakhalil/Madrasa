<template>
  <div class="grid">
    <div class="col-12 md:col-12">
      <div class="card">
        <div class="grid p-fluid mt-3 font-bold mr-5">

          <div class="col-12 md:col-12 justify-content-right">
            <span class="font-bold text-xl">المراحل المدرسية <i class="pi pi-chevron-right"></i>
              {{ this.class.level_name }} <i class="pi pi-chevron-right"></i>
              <span style="cursor: pointer"
                @click="this.$router.push({name: 'class-all',params: { id: this.class_id }, })">
                {{ this.class.name }} <i class="pi pi-chevron-right"></i></span>
              <span style="color: var(--primary-color)">{{ this.student.name }}
              </span>
            </span>
          </div>
        </div>
        <Student :id="id" />
        <hr/>

        <div class="grid p-fluid mt-5 font-bold mr-5">
            <span class="font-bold text-xl">البيانات المسجلة</span>
        </div>

        <div class="grid p-fluid mt-4 font-bold mr-5">
        
           <AbsenceStudent  :student_id="id" :class_id="class_id"/>
        </div>

        <div class="grid p-fluid mt-5 font-bold mr-5">
        
        <DelayStudent  :student_id="id" :class_id="class_id" />
        </div>
   
        <div class="grid p-fluid mt-5 font-bold mr-5">
            
            <LeaveStudent  :student_id="id" :class_id="class_id"/>
        </div>

        <div class="grid p-fluid mt-5 font-bold mr-5">
            
            <ViolationStudent  :student_id="id" :class_id="class_id" />
        </div>

        <div class="grid p-fluid mt-5 font-bold mr-5">
            
            <BookStudent  :student_id="id" :class_id="class_id" />
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


export default {
    props: ["class_id", "id"],
    data() {
        return {
            class: [],
            student: [],
        };
    },
    watch: {},
    created() {
        this.classesService = new ClassesService();
        this.studentsService = new StudentsService();
    },
    methods: {
        getStudents() {
            this.studentsService.index({ id: this.id }).then(({ data }) => {
                if (data.code == 200) {
                    this.student = data.data.Students[0];
                }
            });
        },

    },
    mounted() {
        this.query = { id: this.class_id };
        this.classesService.index(this.query).then(({ data }) => {
            if (data.code == 200) {
              this.class = data.data.Classes[0];
                console.log(thi.class);
            }
        });
      this.getStudents();
    },
    components: { DelayStudent ,LeaveStudent, ViolationStudent, BookStudent ,Student}
};
</script>

<style scoped>
.card {
  border-radius: 0%;
}
.grid {
  margin-left: -0.035rem;
}
.md\:col-12 {
  padding: 0.5rem 0.5rem 0.5rem 0rem;
}

.x {
  background-color: blueviolet;
  color: white;
}
.p-button.p-button-outlined:enabled:hover {
  background-color: blueviolet;
  color: white;
}
</style>
