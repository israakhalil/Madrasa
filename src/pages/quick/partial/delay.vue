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
      <div class="field col">
            <label>تاريخ التاخير / هجري </label>
           
            <div class="grid">
                <div class="col-3">       
                        <Dropdown
                        v-model="item.day"
                        :options="days"
                        optionLabel="name"
                        placeholder="يوم"
                        option-value="id"
                       
                        />
                </div>
                <div class="col-5">
                    <Dropdown
                        v-model="item.month"
                        :options="hijri_months"
                        optionLabel="name"
                        ref="monthName"
                        placeholder="شهر"
                        option-value="id"
                      
                        />
                </div>
                <div class="col-4">
                    <Dropdown
                        v-model="item.year"
                        
                        :options="years"
                        optionLabel="name"
                        placeholder="سنة"
                        option-value="id"
                        
                        />
                </div>
            </div>
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
import DelaysService from "@/services/delaysService";
import {hijri_months} from "@/services/constants.js";
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
        },
        items: [],          
        Msg: null,
        delaysService : null,
        
       
        errorMsg: false,
      successMsg: false,
      days: Array.from({ length: 31 }, (_, i) => ({ id: String((i+1)), name: (i+1) })),
            hijri_months: [],
            years: Array.from({ length: 10 }, (_, i) => ({ id: String((i+1444)), name: (i+1444) })),
    };
  },
  created() {
      this.delaysService = new DelaysService();

      
    },
    methods: {
    addItem() {
        // this.getLevels();
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
        this.items.forEach(item => {
        if (item.delay_date) {
          item.delay_date = this.formatDate(item.delay_date);
          item.hijri_date = item.day + ' ,' + item.month+' ,'+item.year;

        }
      });
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
          item.student_signature = null,
          item.day = null,
          item.month = null,
          item.year= null

          });
    },
       
  },
    mounted() {
        // this.getLevels()
      this.items.push(Object.assign({}, this.newItem));
      this.hijri_months = hijri_months;
  },
};
</script>

<style scoped>
.btndelete{
    margin-right: 25px;
margin-top: 35px;
}
</style>