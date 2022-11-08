<template>
    <div v-for="(item, index) in items">
      <div class="grid p-fluid mt-3 font-bold mr-5">
        <div class="field col-12 md:col-12">
          <span class="font-bold text-xl"> إضافة استئذان جديد :</span>
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
          <label for="leave_date">تاريخ الاستئذان </label>
          <Calendar :showIcon="true" v-model="item.leave_date"></Calendar>
        </div>
        <div class="field col-12 md:col-4">
          <label for="leave_time">وقت الاستئذان </label>
          <Calendar :showIcon="true"  inputId="time12" :timeOnly="true" v-model="item.leave_time" hourFormat="12"></Calendar>
        </div>
        <div class="field col-12 md:col-4">
          <label for="leave_reason"> سبب الاستئذان </label>
          <InputText
            id="leave_reason"
            v-model.trim="item.leave_reason"
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
        <Button label=" حفظ" class="p-button-primary" @click="saveLeaves" />
      </div>
      <div class="field col-12 md:col-4 sm:col-4">
        <Button
          label="اضافة مغادرة جديدة"
          class="p-button-outlined"
          @click="addItem()"
        />
      </div>
    </div>
  
  <SuccessMsg :successMsg=successMsg :Msg=Msg />
  <ErrorMsg :errorMsg=errorMsg />
   
</template>
  
  <script>
  import LevelsService from "@/services/levelsService";
  import ClassesService from "@/services/classesService";
  import StudentsService from "@/services/studentsService";
  import LeavesService from "@/services/leavesService";

  export default {
    data() {
      return {
        newItem: {
          level_id: null,
          class_id: null,
              student_id: null,
          
              leave_date: null,
              leave_time: null,
              student_signature: null,
              leave_reason: null,
  
          classes: [],
          students: [],
        },
        items: [],
        Msg: null,

        levels: [],
  
        levelsService: null,
        classesService: null,
        studentsService: null,
        leavesService: null,
  
        errorMsg: false,
        successMsg: false,
      };
    },
    created() {
      this.levelsService = new LevelsService();
      this.classesService = new ClassesService();
      this.studentsService = new StudentsService();
      this.leavesService = new LeavesService();
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
      saveLeaves() {
        this.errorMsg = false; 
        this.successMsg = false;

        const formData = new FormData();
        formData.append("items", JSON.stringify(this.items));
        this.leavesService.store(this.items).then(({ data }) => {
          if (data.code == 200) {
            this.Msg = data.msg;
            this.successMsg = true;
            this.errorMsg = false;
            this.resetFrom(this.items)
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
            item.leave_date= null,
            item.leave_time= null,
            item.student_signature= null,
            item.leave_reason = null
          });
      },
    
    },
    mounted() {
      this.getLevels();
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
  