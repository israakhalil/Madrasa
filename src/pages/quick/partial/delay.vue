<template>
  <div v-for="(item, index) in items">
    <div class="grid p-fluid mt-3 font-bold mr-5">
      <div class="field col-12 md:col-12">
        <span class="font-bold text-xl"> إضافة تأخير جديد :</span>
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
        <label for="name"> اسم الطالب </label>
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
        <label for="delay_date">تاريخ التأخير </label>
        <Calendar :showIcon="true" v-model="item.delay_date"></Calendar>
      </div>
      <div class="field col-12 md:col-4">
        <label for="delay_reason"> سبب التأخير </label>
        <InputText
          id="delay_reason"
          v-model.trim="item.delay_reason"
          required="true"
        />
      </div>
      <div class="field col-12 md:col-4">
        <label for="delay_amount"> مقدار التاخير</label>
        <InputText
          id="delay_amount"
          v-model.trim="item.delay_amount"
          required="true"
        />
      </div>

      <div class="field col-12 md:col-4">
        <label for="student_signature"> توقيع الطالب </label>
        <InputText
          id="student_signature"
          v-model.trim="item.student_signature"
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
      <Button label=" حفظ" class="p-button-primary" @click="saveDelays" />
    </div>
    <div class="field col-12 md:col-4 sm:col-4">
      <Button
        label="اضافة تأخير جديد"
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
import DelaysService from "@/services/delaysService";
export default {
  props: { levels:Array, classes:Array ,students:Array },
  data() {
    return {
      newItem: {
        level_id: null,
        class_id: null,
        student_id: null,
        
        delay_date: null,
        delay_reason: null,
        delay_amount:null,
        student_signature: null,
       
        // classes: [],
        // students: [],
        },
        items: [],          
        // levels: [],
        Msg: null,

        // levelsService: null,
        // classesService: null,
        // studentsService: null,
        delaysService : null,
        
       
        errorMsg: false,
        successMsg:false
    };
  },
  created() {
      // this.levelsService = new LevelsService();
      // this.classesService = new ClassesService();
      // this.studentsService = new StudentsService();
      this.delaysService = new DelaysService();

      
    },
    methods: {
    addItem() {
        this.getLevels();
        this.items.push(Object.assign({}, this.newItem))
    },
    unset(obj, key) {
      obj.splice(key, 1)
    },
    getClasses(item) { 
        item.classes=this.classes.filter((_class) => { return _class.level_id == item.level_id });
    },
    getStudents(item) {
      item.students=this.students.filter((std) => { return std.class_id == item.class_id });
    },
    // getLevels() { 
    //        this.levelsService.index().then(({ data }) => {
    //            if (data.code == 200) {
    //                this.levels = data.data.Levels;
    //            }
    //        })
    //    },
    //    getClasses(item) {
    //        this.query = { level_id: item.level_id };
    //        this.classesService.index(this.query).then(({ data }) => {  
    //         item.classes = data.data.Classes;
    //        })
    //    }, 
    //    getStudents(item) {
    //        this.query = { class_id: item.class_id };
    //        this.studentsService.index(this.query).then(({ data }) => {  
    //         item.students = data.data.Students;
    //        })
    //    }, 
      saveDelays() { 

        this.errorMsg = false; 
        this.successMsg = false;
        this.Msg = null;
        
            const formData = new FormData()
            formData.append('items', JSON.stringify(this.items))

        this.delaysService.store(this.items).then(({ data }) => {  
          if (data.code == 200) {
            this.Msg = data.msg;
              this.successMsg = true;
                this.resetFrom(this.items)
            }
          if (data.code == 500) { 
            this.Msg = data.msg; 
          this.errorMsg = true;
        }
           })
      },
      resetFrom(items) { 
      items.forEach((item) => { 
            item.level_id= null,
            item.class_id= null,
            item.student_id = null,
            item.delay_date= null,
            item.delay_reason= null,
            item.delay_amount= null,
            item.student_signature = null

          });
    },
       
  },
    mounted() {
        // this.getLevels()
        this.items.push(Object.assign({}, this.newItem))
  },
};
</script>

<style scoped>
.btndelete{
    margin-right: 25px;
margin-top: 35px;
}
</style>