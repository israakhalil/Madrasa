<template>
<div class="col-12 md:col-12" >
    <div class="grid">
    <div class="col-12 md:col-9 div-right">
            <span class="font-bold text-xl" style="color: var(--primary-color)">
            المخالفات السلوكية
            </span>
    </div>
    <div class="col-12 md:col-2 sm:col-7 button-dispaly" >
    <Button 
        width="70%"
        label=" اضافة مخالفة"
        icon="pi pi-plus"
        class="p-button-outlined align-left"
        @click="openNew"
        v-if="this.can('VIOLATION_ADD_EDIT')"
        />
    </div>
    <div class="col-12 md:col-1 sm:col-5 button-dispaly">
    <Button 
            width="70%"
            label="طباعة"
            class="p-button-outlined align-left"
            @click="printViolations"
            v-if="this.can('VIOLATION_ADD_EDIT')"
            />
    </div>
    </div>
    <div class="col-12 md:col-12 mr-10">

    <DataTable  :value="student_violations" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll" dire>
    <Column field="id_number" header="الرقم ">
        <template #body="slotProps">
                {{slotProps.index+1}}
            </template>
            </Column>
    <Column field="violation_day" header="يوم المخالفة" headerStyle="text-align: center">
    <template #body="slotProps">
        {{getDay(slotProps.data.violation_date)}}
    </template>
      </Column>
      <Column field="hijri_date" header="تاريخ الهجري" headerStyle="text-align: center">
        </Column>
    <Column field="violation_date" header="تاريخ المخالفة" headerStyle="text-align: center">
    </Column>
    <Column field="violation_degree_name" header="درجة المخالفة" headerStyle="text-align: center">
        
      </Column>
      <Column field="violation_procedure_name" header="الاجراء" headerStyle="text-align: center">
        
      </Column>
      <Column field="violation_procedure_type" header="نوع الاجراء" headerStyle="text-align: center" >
        <template #body="slotProps">
          <div v-if="slotProps.data.violation_procedure_type.length>=1">
            <div v-for="(item, index) in slotProps.data.violation_procedure_type">
                <span > {{ (index+1) }} - {{  item}}</span>
            </div>
          </div>
        <!-- {{slotProps.data.violation_procedure_type}} -->
    </template>
      </Column>
    <Column field="action_performed" header=" الاجراء المتخذ" headerStyle="text-align: center" >
      <template #body="slotProps">
          <div v-if="slotProps.data.action_performed.length>=1">
            <div v-for="(item, index) in slotProps.data.action_performed">
                <span> {{ (index+1) }} - {{  item}}</span>
            </div>
          </div>
    </template>
    </Column>


    <Column field="student_signature" header="توقيع الطالب" headerStyle="text-align: center">
        
    </Column>
    <Column field="supervisor_signature" header=" توقيع الاداري" headerStyle="text-align: center">
        
    </Column>

    <Column header="  الاجراءات" style="min-width:10rem">
        <template #body="slotProps">
          <Button v-if="slotProps.data.attached" icon="pi pi-download" class="p-button-rounded p-button-help ml-2" @click="download(slotProps.data.file)"/> 
          <Button v-if="slotProps.data.audio" icon="pi pi-volume-up" class="p-button-rounded p-button-secandary ml-2" @click="download(slotProps.data.audio_file)"/> 

            <Button v-if="this.can('VIOLATION_ADD_EDIT')" icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
            <Button v-if="this.can('VIOLATION_DELETE')" icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
        </template>

    </Column>
    </DataTable>

  </div>
</div>
<Dialog v-model:visible="ViolationDialog" :style="{width: '450px'}" :header="header" :modal="true" 
class="p-fluid font-bold text-lg">
<div class="field col">
  <label >تاريخ المخالفة / هجري </label>           
           
            <div class="grid">
                <div class="col-3">       
                        <Dropdown
                        v-model="form.day"
                        :options="days"
                        optionLabel="name"
                        placeholder="يوم"
                        option-value="id"
                        :class="{ 'p-invalid':v$.form.day.$invalid && submitted }"
                        />
                </div>
                <div class="col-5">
                    <Dropdown
                        v-model="form.month"
                        :options="hijri_months"
                        optionLabel="name"
                        ref="monthName"
                        placeholder="شهر"
                        option-value="id"
                        :class="{ 'p-invalid':v$.form.month.$invalid && submitted }"
                        />
                </div>
                <div class="col-4">
                    <Dropdown
                        v-model="form.year"
                        
                        :options="years"
                        optionLabel="name"
                        placeholder="سنة"
                        option-value="id"
                        :class="{ 'p-invalid':v$.form.year.$invalid && submitted }"
                        />
                </div>
            </div>

           
            <small class="p-error" v-if="v$.form.day.$invalid && submitted">يرجى اختيار  يوم , </small>
            <small class="p-error" v-if="v$.form.month.$invalid && submitted">يرجى اختيار  شهر ,  </small> 
            <small class="p-error" v-if="v$.form.year.$invalid && submitted">يرجى اختيار  سنة  </small>

          </div>
    <div class="field">
        <label for="violation_date">تاريخ المخالفة  / ميلادي</label>
        <Calendar id="violation_date" :showIcon="true" 
        v-model="form.violation_date"
        :class="{ 'p-invalid':v$.form.violation_date.$invalid && submitted }"></Calendar>
        <small class="p-error" v-if="v$.form.violation_date.$invalid && submitted">يرجى اختيار  تاريخ  </small>

      </div>
      <div class="field">
        <label for="violation_degree_id">درجة المخالفة</label>
        <Dropdown
          id="violation_degree_id"
          :filter=true
          v-model="form.violation_degree_id"
          :options="violation_degrees"
          optionLabel="name"
          placeholder="اختر"
          option-value="id"
          :class="{ 'p-invalid':v$.form.violation_degree_id.$invalid && submitted }"
        />
        <small class="p-error" v-if="v$.form.violation_degree_id.$invalid && submitted">يرجى  اختيار درجةالمخالفة  </small>
      </div>
      <div class="field">
        <label for="violation_procedure_id"> الاجراء</label>
        <Dropdown
          id="violation_procedure_id"
          :filter=true
          v-model="form.violation_procedure_id"
          :options="violation_procedures"
          optionLabel="name"
          placeholder="اختر"
          option-value="id"
          :class="{ 'p-invalid':v$.form.violation_procedure_id.$invalid && submitted }"
        />
        <small class="p-error" v-if="v$.form.violation_procedure_id.$invalid && submitted">يرجى  اختيار الاجراء </small>
      </div>
      <div class="field" >
        <label for="violation_procedure_type"> نوع الاجراء</label>
        <div class=" grid p-fluid" v-for="(item, index) in types">
          <div class="field col-11 md:col-11 sm:col-10">
              <InputText id="violation_procedure_type" v-model.trim="item.violation_procedure_type"/>
       
           </div>
            <div class="field col-1 md:col-1 sm:col-2">
              <i class="pi pi-plus-circle" v-if="this.types.length>=1 && (index+1) > this.types.length-1"  @click="addItem()" style="cursor:pointer"></i>
              <i class="pi pi-times" @click="unset(types, index)" v-if="this.types.length>=1 && (index+1)!=1" style="cursor:pointer"></i>
            </div>
        </div>
       
      </div>
      <div class="field">
        <label for="action_performed"> الاجراء المنفذ  </label>
        <div class=" grid p-fluid" v-for="(item, index) in actions">
          <div class="field col-11 md:col-11 sm:col-10">
              <InputText id="action_performed" v-model.trim="item.action_performed"/>
       
           </div>
            <div class="field col-1 md:col-1 sm:col-2">
              <i class="pi pi-plus-circle" v-if="this.actions.length>=1 && (index+1) > this.actions.length-1"  @click="addAction()" style="cursor:pointer"></i>
              <i class="pi pi-times" @click="unset(actions, index)" v-if="this.actions.length>=1 && (index+1)!=1" style="cursor:pointer"></i>
            </div>
        </div>
      </div >

      <div class="field"> 
         <label for="file">الملف المرفق</label>
            <div class="inputfile-box">
              <input
                type="file"
                id="file"
                class="inputfile"
                @change="uploadFile"
                accept="image/*,.pdf,.doc,.docx"
              />
              <label for="file">
                <span class="p-input-icon-left">
                  <i class="pi pi-upload" aria-hidden="true"></i>
                  <span id="file-name" class="file-box">{{form.attached}}</span>
                </span>
              </label>
            </div>
            </div>
            <div class="field"> 
         <label for="audio">ارفاق ملف صوتي </label>
            <div class="inputfile-box">
              <input
                type="file"
                id="audio"
                class="inputfile"
                @change="uploadAudio"
                accept="audio/*"
              />
              <label for="audio">
                <span class="p-input-icon-left">
                  <i class="pi pi-upload" aria-hidden="true"></i>
                  <span id="file-name" class="file-box">{{form.audio}}</span>
                </span>
              </label>
            </div>
            </div>

     <div  class="field">
            <label for="student_signature"> توقيع الطالب </label>
            <InputText
            id="student_signature"
            v-model.trim="form.student_signature"
            required="true"
            :class="{ 'p-invalid':v$.form.student_signature.$invalid && submitted }"
            />
            <small class="p-error" v-if="v$.form.student_signature.$invalid && submitted">يرجى  ادخال توقيع الطالب     </small>

        </div>

        <div  class="field">
            <label for="supervisor_signature"> توقيع الاداري </label>
            <InputText
            id="supervisor_signature"
            v-model.trim="form.supervisor_signature"
            required="true"
            :class="{ 'p-invalid':v$.form.supervisor_signature.$invalid && submitted }"
            />
            <small class="p-error" v-if="v$.form.supervisor_signature.$invalid && submitted">يرجى  ادخال توقيع الاداري    </small>

        </div>
      <div class="field" >
        <Button :loading="loading" label="تعديل" v-if="form.id" class="mt-5" type="submit" @click="save(!v$.$invalid)"  />
        <Button :loading="loading" label="حفظ" v-if="form.id==null" class="mt-5" type="submit" @click="save(!v$.$invalid)"  />
      </div>
    </Dialog>

    <Dialog
  id="deleteconfirm"
  v-model:visible="deleteconfirm"
  :style="{ width: '450px' }"
  header=""
  :modal="true"
  class="font-bold text-3xl"
>
  <div>
    <div class="justify-content-center text-center md:text-center">
      <i class="pi pi-times-circle" style="font-size: 5rem; color:red"></i>
    </div>

    <div class="justify-content-center text-center md:text-center">
      <span> {{deleteMsg}} </span>
    </div>
  </div>

  <template #footer>
    <div class="grid p-fluid">
        <div class="col-6 md:col-6">  
             <Button label="حذف"  class=" p-button-outlined mt-5"   @click="deleteViolation" />
        </div>
        <div class="col-6 md:col-6">            
             <Button label="الغاء"  class="p-button-outlined mt-5" @click="deleteconfirm = false"  />
        </div>
    </div>
        </template>

</Dialog>

    <SuccessMsg :successMsg=successMsg  :Msg=Msg />
    <!-- <ErrorMsg :errorMsg=errorMsg /> -->
</template>


<script>
import ViolationsService from "@/services/violationsService";
import ConstantsService from "@/services/constantsService";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import {hijri_months} from "@/services/constants.js";
export default {
setup () {
    return { v$: useVuelidate() }
},
  props: ["student_id", 'class_id'],
  emits:['sign'],


data() {
    return {
        loading:false,
        student_violations: [],
        violation_procedures: [],
        violation_degrees: [],
        header:null,
        ViolationDialog: false,
        attached:null,

        successMsg: false,
        Msg: null,
        deleteMsg:null,
        errorMsg: false,
        deleteconfirm:false,
        form:{},
        submitted: false,
        
        violationsService: null,
        constantsService: null,
        days: Array.from({ length: 31 }, (_, i) => ({ id: String((i+1)), name: (i+1) })),
        hijri_months: [],
        years: Array.from({ length: 10 }, (_, i) => ({ id: String((i+1444)), name: (i+1444) })),
      types: [],
      type: {
        violation_procedure_type:null
      },
      actions: [],
      action: {
        action_performed:null
      },
      audio:null,
    }  
},
validations() {
    return {
    form: {
        violation_date: { required },
        violation_procedure_id: { required },
        violation_degree_id: { required },
        supervisor_signature: { required },
        student_signature: { required },
        day: { required },
        month:{ required },
         year:{ required },
    }
    }
  },
created() {
    this.violationsService = new ViolationsService();  
    this.constantsService = new ConstantsService();
},
  methods: {
    addItem() {
      this.type={}
      this.types.push(Object.assign({}, this.type));
    },
    addAction() {
      this.action={}
      this.actions.push(Object.assign({}, this.action));
    },
    unset(obj, key) {
      obj.splice(key, 1);
    },
    openNew() {
        this.header="اضافة مخالفة"
        this.form = {};
        // this.types = [];
        // this.actions = [];
        this.submitted = false;
        this.ViolationDialog = true;
        this.getViolationProcedures();
        this.getViolationDegrees();

    },
    openEdit(data) {
        this.header="تعديل مخالفة"
        this.form = { ...data };  
        this.types = [];
        this.actions = [];
        this.form.violation_procedure_type.forEach(type => {
            this.type.violation_procedure_type = type;
          this.types.push(Object.assign({}, this.type));
            
        });
        this.form.action_performed.forEach(action => {
            this.action.action_performed = action;
            this.actions.push(Object.assign({}, this.action));
        });
        this.ViolationDialog = true;
        this.getViolationProcedures();
        this.getViolationDegrees();
        let hijri = this.form.hijri_date.split(',');
        this.form.day = hijri[0].trim();
        this.form.month = hijri[1].trim();
        this.form.year = hijri[2];
    },
    openDelete(data) { 
        this.form = data;
        this.deleteconfirm = true;
        this.deleteMsg = "هل انت متاكد من الحذف ";
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
  uploadFile(e) {
        this.form.attached = e.target.files[0].name;
        this.attached = e.target.files[0]
    },
    uploadAudio(e) {
        this.form.audio = e.target.files[0].name;
        this.audio = e.target.files[0]
    },
  download(link) {
            window.open(link,'_blank')
    },
    save(isFormValid) {
   
      this.loading = true; 
      this.successMsg = false;
      this.submitted = true;


      if (!isFormValid) {
        this.loading = false; 
                  return;
      } 

      let violation_actions = ""; let violation_types = "";
      this.types.forEach(type => {
        violation_types += type.violation_procedure_type + '&';
      });
      this.actions.forEach(action => {
        violation_actions += action.action_performed + '&';
      });

        const formData = new FormData()     
        this.form.violation_procedure_type = violation_types;
        this.form.action_performed = violation_actions;
        this.form.class_id = this.class_id;
        this.form.student_id = this.student_id;
        this.form.violation_date = this.formatDate(this.form.violation_date);
        this.form.hijri_date = this.form.day + ' ,' + this.form.month+' ,'+this.form.year;
          formData.append('attached', this.attached)
          formData.append('audio', this.audio)
          formData.append('data', JSON.stringify(this.form))
          this.violationsService.save(formData, this.form.id).then(({ data }) => {
              if (data.code == 200) {
              this.ViolationDialog = false;
              this.successMsg = true;
                this.Msg = data.msg;
                this.loading = false; 
                  this.getViolations();
          }
          }).finally(() => {
             this.loading = false; 
      });
    },
    deleteViolation() { 
        this.successMsg = false;

        this.violationsService.delete(this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.deleteconfirm = false;
            this.successMsg = true;
                this.Msg = data.msg;
                this.student_violations = this.student_violations.filter(val => val.id !== this.form.id);
                this.form={}
        }
        });
    },

    getViolations() {
        this.query = { student_id: this.student_id };
        this.violationsService.index(this.query).then(({ data }) => {
        if (data.code == 200) {
            this.student_violations = data.data.violations;
        }
    });
  },
  printViolations() {
        this.$emit('sign', 1)
        setTimeout(() => this.$htmlToPaper('printViolations'), 10)
        // this.$htmlToPaper('printViolations');
      },

},

mounted() { 
  this.getViolations();
  this.hijri_months = hijri_months;
  this.types.push(Object.assign({}, this.type));
  this.actions.push(Object.assign({}, this.action));
}
};
</script>

<style scoped>
.p-button:enabled:hover {
background: #7C3AED;
color: #ffffff;
border-color: #7C3AED;
}
.p-dialog .p-dialog-footer button{
width:100%
}
</style>