<template>
    <div v-for="(item, index) in items">
      <div class="grid p-fluid mt-3 font-bold mr-5">
        <div class="field col-12 md:col-12">
          <span class="font-bold text-xl"> إضافة تسليم كتاب جديد :</span>
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
            :filter=true
            v-model="item.student_id"
            :options="item.students"
            optionLabel="name"
            placeholder="اختر الطالب"
            option-value="id"
          />
        </div>
        <div class="field col-12 md:col-4">
          <label for="book_name"> اسم الكتاب</label>
          <InputText
            id="book_name"
            v-model.trim="item.book_name"
            required="true"
          />
        </div>
        <div class="field col-12 md:col-4">
          <label for="received_date">تاريخ الاستلام </label>
          <Calendar :showIcon="true" v-model="item.received_date"></Calendar>
        </div>
        <div class="field col-12 md:col-4">
          <label for="is_delivered"> التسليم</label>
          <Dropdown
            id="is_delivered"
            :filter=true
            v-model="item.is_delivered"
            :options="delivered_options"
            optionLabel="name"
            placeholder=" اختر"
            option-value="id"
          />
        </div>

        <div class="field col-12 md:col-4">
          <label for="student_signature"> توقيع الطالب </label>
          <InputText
            id="student_signature"
            v-model.trim="item.student_signature"
            required="true"
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
        <Button label=" حفظ" class="p-button-primary" @click="saveBooks" />
      </div>
      <div class="field col-12 md:col-4 sm:col-4">
        <Button
          label="اضافة تسليم كتاب جديد"
          class="p-button-outlined"
          @click="addItem()"
        />
      </div>
    </div>
  
  <SuccessMsg :successMsg=successMsg :Msg=Msg />
  <ErrorMsg :errorMsg=errorMsg :Msg=Msg />
   
</template>
  
  <script>
  // import LevelsService from "@/services/levelsService";
  // import ClassesService from "@/services/classesService";
  // import StudentsService from "@/services/studentsService";
  import BooksService from "@/services/booksService";
export default {
  props: { levels:Array, classes:Array ,students:Array },

  data() {
      
      return {
        newItem: {
          level_id: null,
          class_id: null,
          student_id: null,
          
          received_date: null,
          book_name: null,
          is_delivered: null,
          student_signature: null,
  
          // classes: [],
          // students: [],
        },
        items: [],
        Msg: null,

          // levels: [],
          delivered_options: [
					{
						id: '1',
						name: 'تم التسليم'
					},
					{
						id: '2',
						name: 'لم يتم التسليم'
					}],
        // levelsService: null,
        // classesService: null,
        // studentsService: null,
        booksService: null,
  
        errorMsg: false,
        successMsg: false,
      };
    },
    created() {
      // this.levelsService = new LevelsService();
      // this.classesService = new ClassesService();
      // this.studentsService = new StudentsService();
      this.booksService = new BooksService();
    },
    methods: {
      addItem() {
        // this.getLevels();
        this.items.push(Object.assign({}, this.newItem));
      },
      unset(obj, key) {
        obj.splice(key, 1);
      },
  
      // getLevels() {
      //   this.levelsService.index().then(({ data }) => {
      //     if (data.code == 200) {
      //       this.levels = data.data.Levels;
      //     }
      //   });
      // },
      // getClasses(item) {
      //   this.query = { level_id: item.level_id };
      //   this.classesService.index(this.query).then(({ data }) => {
      //     item.classes = data.data.Classes;
      //   });
      // },
      // getStudents(item) {
      //   this.query = { class_id: item.class_id };
      //   this.studentsService.index(this.query).then(({ data }) => {
      //     item.students = data.data.Students;
      //   });
      // },
      getClasses(item) { 
        item.classes=this.classes.filter((_class) => { return _class.level_id == item.level_id });
    },
    getStudents(item) {
      item.students=this.students.filter((std) => { return std.class_id == item.class_id });
    },
      saveBooks() {

        this.errorMsg = false; 
        this.successMsg = false;
        this.Msg=null;
        
        const formData = new FormData();
        formData.append("items", JSON.stringify(this.items));
  
        this.booksService.store(this.items).then(({ data }) => {
          if (data.code == 200) {
            this.Msg = data.msg;
            this.successMsg = true;
            this.resetFrom(this.items);
          }
          if (data.code == 500) { 
            this.Msg = data.msg; 
            this.errorMsg = true;
        }
        });
      },

      resetFrom(items) { 
      items.forEach((item) => { 
            item.level_id= null,
            item.class_id= null,
            item.student_id = null,
            item.received_date= null,
            item.book_name= null,
            item.is_delivered= null,
            item.student_signature= null
          });
    },
  },

    mounted() {
      // this.getLevels();
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
  