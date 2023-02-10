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
          :filter=true
          v-model="item.student_id"
          :options="item.students"
          optionLabel="name"
          placeholder="اختر الطالب"
          option-value="id"
        />
      </div>
      <div class="field col">
            <label>تاريخ الغياب / هجري </label>
           
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

           
            <!-- <small class="p-error" v-if="v$.form.day.$invalid && submitted">يرجى اختيار  يوم , </small>
            <small class="p-error" v-if="v$.form.month.$invalid && submitted">يرجى اختيار  شهر ,  </small> 
            <small class="p-error" v-if="v$.form.year.$invalid && submitted">يرجى اختيار  سنة  </small> -->

          </div>
      <div class="field col-12 md:col-4">
        <label for="absence_date">تاريخ الغياب / ميلادي</label>
        <Calendar  :showIcon="true" v-model="item.absence_date"></Calendar>
        
      </div>
      <div class="field col-12 md:col-4">
        <label for="absence_type_id"> نوع الغياب</label>
        <Dropdown
          id="absence_type_id"
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
        />
      </div>
      <div class="field col-12 md:col-4">
              <label for="respondent">المجيب </label>
              <InputText id="respondent" v-model.trim="item.respondent"/>
            </div>
            <div class="field col-12 md:col-4">
              <label for="contact_number">رقم التواصل </label>
              <InputText id="contact_number" v-model.trim="item.contact_number"/>
            </div>
            <div class="field col-12 md:col-4">
              <label for="time">الوقت </label>
              <InputText id="time" v-model.trim="item.time"/>
            </div>

      <!-- "'name-'+grp_sign" -->
      <!-- <div class="field col-12 md:col-4">
            <label :for="'file-'+index">الملف المرفق</label>
            <div class="inputfile-box">
              <input
                type="file"
                :id="'file-'+index"
                class="inputfile"
                @change="uploadFile($event,item)"
              />
              <label :for="'file-'+index">
                <span class="p-input-icon-left">
                  <i class="pi pi-upload" aria-hidden="true"></i>
                  <span  class="file-box">{{item.name}}</span>
                </span>
              </label>
            </div>  
          </div> -->

      <div class="field col-12 md:col-4">
        <label for="teacher_signature"> توقيع المعلم </label>
        <InputText
          id="teacher_signature"
          v-model.trim="item.teacher_signature"
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
    <div class="field col-12 md:col-4 sm:col-6">
      <Button :loading="loading" label=" حفظ" class="p-button-primary" @click="saveAbsences" />
    </div>
    <div class="field col-12 md:col-4 sm:col-6">
      <Button
        label="اضافة غياب جديد"
        class="p-button-outlined"
        @click="addItem()"
      />
    </div>
  </div>

  <SuccessMsg :successMsg=successMsg :Msg=Msg />
  <ErrorMsg :errorMsg=errorMsg :Msg=Msg />


<!--  <template v-if="this.errorMsg==true">
  <ErrorMsg :errorMsg=errorMsg />
</template> -->

 
</template>

<script>
import ConstantsService from "@/services/constantsService";
import AbsencesService from "@/services/absencesService";
import {hijri_months} from "@/services/constants.js";

export default {
  props: { levels:Array, classes:Array ,students:Array },
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
        attached:null
      },
      absence_types:[],
      items: [],
      Msg: null,
      loading:false,
      constantsService: null,
      absencesService: null,

      errorMsg: false,
      successMsg: false,
      days: Array.from({ length: 31 }, (_, i) => ({ id: String((i+1)), name: (i+1) })),
            hijri_months: [],
            years: Array.from({ length: 10 }, (_, i) => ({ id: String((i+1444)), name: (i+1444) })),
    };
  },
  created() {
    this.constantsService = new ConstantsService();
    this.absencesService = new AbsencesService();
  },
  methods: {
    addItem() {
      this.items.push(Object.assign({}, this.newItem));
    },
    unset(obj, key) {
      obj.splice(key, 1);
    },
    // uploadFile(e, item) {

    //       item.name = e.target.files[0].name;
    //   item.attached = e.target.files[0]
    //       console.log(item);
        
    //     },
    getClasses(item) { 
        item.classes=this.classes.filter((_class) => { return _class.level_id == item.level_id });
    },
    getStudents(item) {
      item.students=this.students.filter((std) => { return std.class_id == item.class_id });
    },
    getAbsenceType() {
      this.constantsService.fetchAbsenceTypes().then(({ data }) => {
        this.absence_types = data.data.absenceTypes;
      });
    },
    saveAbsences() {
      this.loading = true; 
      this.errorMsg = false; 
      this.successMsg = false;
      this.Msg = null;
      this.items.forEach(item => {
        if (item.absence_date) {
          item.absence_date = this.formatDate(item.absence_date);
          item.hijri_date = item.day + ' ,' + item.month+' ,'+item.year;


        }
      });
      const formData = new FormData();
      formData.append("items", JSON.stringify(this.items));

      this.absencesService.store(this.items).then(({ data }) => {
        if (data.code == 200) {
          this.Msg = data.msg;
          this.successMsg = true;
          this.loading = false; 
          this.resetFrom(this.items)

        } if (data.code == 500) { 
          this.Msg = data.msg; 
          this.errorMsg = true;
          this.loading = false; 
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
          item.teacher_signature = null
        item.day = null,
          item.month = null,
          item.year= null
          });
    },
  },
  mounted() {
    // this.levels;
    this.getAbsenceType();
    this.items.push(Object.assign({}, this.newItem));
    this.hijri_months = hijri_months;

  },
};
</script>

<style scoped>
.btndelete {
  margin-right: 25px;
  margin-top: 35px;
}
</style>
