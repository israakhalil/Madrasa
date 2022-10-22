<template>
  <div v-for="(item, index) in items">
    <div class="grid p-fluid mt-3 font-bold mr-5">
      <div class="field col-12 md:col-12">
        <span class="font-bold text-xl"> إضافة غياب جديد :</span>
      </div>

      <div class="field col-12 md:col-4">
        <label for="level_id">المرحلة </label>
        <Dropdown
          id="level_id"
          v-model="item.level_id"
          :options="levels"
          optionLabel="name"
          placeholder="اختر المرحلة الدراسية"
          option-value="id"
          @change="getClasses(item)"
        />
      </div>
      <div class="field col-12 md:col-4">
        <label for="class_id"> الصف</label>
        <Dropdown
          id="class_id"
          v-model="item.class_id"
          :options="item.classes"
          optionLabel="name"
          placeholder="اختر الصف"
          option-value="id"
          @change="getStudents(item)"
        />
      </div>
      <div class="field col-12 md:col-4">
        <label for="student_id"> اسم الطالب </label>
        <Dropdown
          id="student_id"
          filter="true"
          v-model="item.student_id"
          :options="item.students"
          optionLabel="name"
          placeholder="اختر الطالب"
          option-value="id"
        />
      </div>
      <div class="field col-12 md:col-4">
        <label for="absence_date">تاريخ الغياب </label>
        <Calendar id="absence_date" :showIcon="true" v-model="item.absence_date"></Calendar>
      </div>
      <div class="field col-12 md:col-4">
        <label for="absence_type_id"> نوع الغياب</label>
        <Dropdown
          id="absence_type_id"
          filter="true"
          v-model="item.absence_type_id"
          :options="absence_types"
          optionLabel="name"
          placeholder="اختر"
          option-value="id"
        />
      </div>
      <div class="field col-12 md:col-4">
        <label for="absence_reason"> سبب الغياب </label>
        <InputText
          id="absence_reason"
          v-model.trim="item.absence_reason"
          required="true"
          autofocus
        />
      </div>
      <div class="field col-12 md:col-4">
        <label for="teacher_signature"> توقيع المعلم </label>
        <InputText
          id="teacher_signature"
          v-model.trim="item.teacher_signature"
          required="true"
          autofocus
        />
      </div>
      <div class="field col-12 md:col-2">
        <Button
          v-if="this.items.length > 1"
          icon="pi pi-times"
          class="p-button-rounded p-button-danger btndelete"
          @click="unset(items, index)"
        />
      </div>
    </div>
  </div>

  <div class="grid p-fluid mt-3 font-bold mr-5">
    <div class="field col-12 md:col-4 sm:col-4">
      <Button label=" حفظ" class="p-button-primary" @click="saveAbsences" />
    </div>
    <div class="field col-12 md:col-4 sm:col-4">
      <Button
        label="اضافة غياب جديد"
        class="p-button-outlined"
        @click="addItem()"
      />
    </div>
  </div>

  <SuccessMsg :successMsg=successMsg />
  <ErrorMsg :errorMsg=errorMsg />


<!--  <template v-if="this.errorMsg==true">
  <ErrorMsg :errorMsg=errorMsg />
</template> -->

 
</template>

<script>
import LevelsService from "@/services/levelsService";
import ClassesService from "@/services/classesService";
import StudentsService from "@/services/studentsService";
import ConstantsService from "@/services/constantsService";
import AbsencesService from "@/services/absencesService";
export default {
  data() {
    return {
      newItem: {
        level_id: null,
        class_id: null,
        student_id: null,
        absence_date: null,
        absence_type_id: null,
        absence_reason: null,
        teacher_signature: null,

        classes: [],
        students: [],
        absence_types: [],
      },
      items: [],

      levels: [],

      levelsService: null,
      classesService: null,
      studentsService: null,
      constantsService: null,
      absencesService: null,

      errorMsg: false,
      successMsg: false,
    };
  },
  created() {
    this.levelsService = new LevelsService();
    this.classesService = new ClassesService();
    this.studentsService = new StudentsService();
    this.constantsService = new ConstantsService();
    this.absencesService = new AbsencesService();
  },
  methods: {
    addItem() {
      this.getLevels();
      this.items.push(Object.assign({}, this.newItem));
    },
    unset(obj, key) {
      obj.splice(key, 1);
    },

    getLevels() {
      this.levelsService.index().then(({ data }) => {
        if (data.code == 200) {
          this.levels = data.data.Levels;
        }
      });
    },
    getClasses(item) {
      this.query = { level_id: item.level_id };
      this.classesService.index(this.query).then(({ data }) => {
        item.classes = data.data.Classes;
      });
    },
    getStudents(item) {
      this.query = { class_id: item.class_id };
      this.studentsService.index(this.query).then(({ data }) => {
        item.students = data.data.Students;
      });
    },
    getAbsenceType() {
      this.constantsService.fetchAbsenceTypes().then(({ data }) => {
        this.absence_types = data.data.absenceTypes;
      });
    },
    saveAbsences() {
      const formData = new FormData();
      formData.append("items", JSON.stringify(this.items));
      this.errorMsg = false; 
        this.successMsg = false;
      this.absencesService.store(this.items).then(({ data }) => {
        if (data.code == 200) {
          this.errorMsg = false;
          this.successMsg = true;
          this.resetFrom(this.items)

        }  if (data.code == 500) { 
          this.errorMsg = true;
          this.successMsg = false;
        }
      });
    },
    resetFrom(items) { 
      items.forEach((item) => { 
            item.level_id= null,
            item.class_id= null,
            item.student_id= null,
            item.absence_date= null,
            item.absence_type_id= null,
            item.absence_reason= null,
            item.teacher_signature= null
          });
    },
  },
  mounted() {
    this.getLevels();
    this.getAbsenceType();
    this.items.push(Object.assign({}, this.newItem));
  },
};
</script>

<style scoped>
.btndelete {
  margin-right: 25px;
  margin-top: 35px;
}
</style>
