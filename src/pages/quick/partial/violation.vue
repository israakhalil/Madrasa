<template>
    <div v-for="(item, index) in items">
      <div class="grid p-fluid mt-3 font-bold mr-5">
        <div class="field col-12 md:col-12">
          <span class="font-bold text-xl"> إضافة مخالفة سلوكية جديدة :</span>
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
          <label for="violation_date">تاريخ المخالفة </label>
          <Calendar :showIcon="true" v-model="item.violation_date"></Calendar>
        </div>
        <div class="field col-12 md:col-4">
          <label for="action_performed">  الاجراء المنفذ </label>
          <InputText
            id="action_performed"
            v-model.trim="item.action_performed"
            required="true"
            autofocus
          />
        </div>

        <div class="field col-12 md:col-4">
          <label for="violation_procedure_id"> نوع الاجراء</label>
          <Dropdown
            id="violation_procedure_id"
            v-model="item.violation_procedure_id"
            :options="violation_procedures"
            optionLabel="name"
            placeholder="  اختر"
            option-value="id"
          />
        </div>
        <div class="field col-12 md:col-4">
          <label for="violation_degree_id"> درجة المخالفة</label>
          <Dropdown
            id="violation_degree_id"
            v-model="item.violation_degree_id"
            :options="violation_degrees"
            optionLabel="name"
            placeholder="  اختر"
            option-value="id"
          />
        </div>
        
        <div class="field col-12 md:col-4">
          <label for="suprvisore_signature"> توقيع الاداري </label>
          <InputText
            id="suprvisore_signature"
            v-model.trim="item.suprvisore_signature"
            required="true"
            autofocus
          />
        </div>
        <div class="field col-12 md:col-4">
          <label for="student_signature"> توقيع الطالب </label>
          <InputText
            id="student_signature"
            v-model.trim="item.student_signature"
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
        <Button label=" حفظ" class="p-button-primary" @click="saveViolations" />
      </div>
      <div class="field col-12 md:col-4 sm:col-4">
        <Button
          label="اضافة مخالفة سلوكية جديدة"
          class="p-button-outlined"
          @click="addItem()"
        />
      </div>
    </div>
  
  <SuccessMsg :successMsg=successMsg />
  <ErrorMsg :errorMsg=errorMsg />
   
</template>
  
  <script>
  import LevelsService from "@/services/levelsService";
  import ClassesService from "@/services/classesService";
  import StudentsService from "@/services/studentsService";
  import ConstantsService from "@/services/constantsService";
  import ViolationsService from "@/services/violationsService";
  export default {
    data() {
      return {
        newItem: {
          level_id: null,
          class_id: null,
          student_id: null,
          
        violation_date: null,
        action_performed: null,
        violation_procedure_id: null,
        violation_degree_id: null,
        suprvisore_signature: null,
        student_signature: null,
  
          classes: [],
          students: [],
          violation_procedures: [],
          violation_degrees:[]
        },
        items: [],
  
        levels: [],
  
        levelsService: null,
        classesService: null,
        studentsService: null,
        constantsService: null,
        violationsService: null,
  
        errorMsg: false,
        successMsg: false,
      };
    },
    created() {
      this.levelsService = new LevelsService();
      this.classesService = new ClassesService();
      this.studentsService = new StudentsService();
      this.constantsService = new ConstantsService();
      this.violationsService = new ViolationsService();
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
      getViolationProcedures() {
        this.constantsService.fetchViolationProcedures().then(({ data }) => {
          this.violation_procedures = data.data.violationProcedures;
        });
        },
        getViolationDegrees() {
        this.constantsService.fetchViolationDegrees().then(({ data }) => {
          this.violation_degrees = data.data.violationDegrees;
        });
      },
      saveViolations() {
        this.errorMsg = false; 
        this.successMsg = false;

        const formData = new FormData();
        formData.append("items", JSON.stringify(this.items));
  
        this.violationsService.store(this.items).then(({ data }) => {
          if (data.code == 200) {
            this.successMsg = true;
            this.errorMsg = false;
            this.resetFrom(this.items);
          }
          if (data.code == 500) { 
          this.errorMsg = true;
          this.successMsg = false;
          }
        });
      },
      resetFrom(items) { 
         items.forEach((item) => { 
            item.level_id= null,
            item.class_id= null,
            item.student_id = null,        
            item.violation_date= null,
            item.action_performed= null,
            item.violation_procedure_id= null,
            item.violation_degree_id = null
            item.suprvisore_signature= null,
            item.student_signature = null
         });

        // items.forEach((item){

        // });
        // while (items.length > 1) { 

        //   items.splice(items.length, 1);
         
        // }
      },
    },
    mounted() {
      this.getLevels();
      this.getViolationProcedures();
      this.getViolationDegrees();
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
  