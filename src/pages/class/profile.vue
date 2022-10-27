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
        <div class="grid mt-5 font-bold mr-5">
          <div class="col-10 md:col-10 justify-content-right mr-10">
            <span class="font-bold text-xl" style="color: var(--primary-color)">
              البيانات الرئيسية
            </span>
          </div>
          <div class="col-2 md:col-2 justify-content-left">
            <Button
              label="طباعة"
              icon="pi pi-print"
              class="p-button-outlined ml-3" />
            <Button
              label=" تعديل"
              icon="pi pi-pencil"
              class="p-button-outlined"
              @click="openEdit"/>
          <div>

            </div>
          </div>
        </div>

        <div class="grid p-fluid mt-5 font-bold mr-5">
      <div class="field col-12 md:col-2">
        <label for="name">اسم الطالب </label>
        <InputText
          id="name"
          v-model.trim="student.name"
        />
      </div>
      <div class="field col-12 md:col-2">
        <label for="id_number"> رقم الهوية</label>
        <InputText
          id="id_number"
          v-model.trim="student.id_number"

        />
      </div>
      <div class="field col-12 md:col-2">
        <label for="date_of_birth"> تاريخ الميلاد </label>
        <InputText
          id="date_of_birth"
          v-model.trim="student.date_of_birth"
          autofocus
        />
      </div>
      <div class="field col-12 md:col-2">
        <label for="phone_1"> هاتف ولي الامر (الاول) </label>
        <InputText
          id="phone_1"
          v-model.trim="student.phone_1"
        />
              </div>
      <div class="field col-12 md:col-2">
        <label for="phone_2">  هاتف ولي الامر (الثاني)</label>
        <InputText
          id="phone_2"
          v-model.trim="student.phone_2"
        />
      </div>
      <div class="field col-12 md:col-2">
        <label for="phone_3"> هاتف ولي الامر (الثالث) </label>
        <InputText
          id="phone_3"
          v-model.trim="student.phone_3"         
        />
      </div>
         </div>
        <hr/>

        <div class="grid p-fluid mt-5 font-bold mr-5">
            <span class="font-bold text-xl">البيانات المسجلة</span>
        </div>

        <div class="grid p-fluid mt-4 font-bold mr-5">
        
           <AbsenceStudent  :student_id="id"/>
        </div>
        <div class="grid p-fluid mt-5 font-bold mr-5">
        
        <DelayStudent  :student_id="id"/>
     </div>
     <div class="grid p-fluid mt-5 font-bold mr-5">
        
        <LeaveStudent  :student_id="id"/>
     </div>
     <div class="grid p-fluid mt-5 font-bold mr-5">
        
        <ViolationStudent  :student_id="id"/>
     </div>
     <div class="grid p-fluid mt-5 font-bold mr-5">
        
        <BookStudent  :student_id="id"/>
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

export default {
    props: ["class_id", "id"],
    data() {
        return {
            name: null,
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
                    console.log(this.student);
                }
            });
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
    components: { DelayStudent ,LeaveStudent, ViolationStudent, BookStudent}
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
