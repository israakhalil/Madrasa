<template>

    <div class="col-10 md:col-10 mr-10">
            <span class="font-bold text-xl" style="color: var(--primary-color)">
            المخالفات السلوكية
            </span>
    </div>
    <div class="col-2 md:col-2">
    <Button 
        width="70%"
        label=" اضافة مخالفة"
        icon="pi pi-plus"
        class="p-button-outlined align-left"
        @click="openNew"
        />
    </div>
    <div class="col-12 md:col-12 mr-10">
    <DataTable  :value="student_violations" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
    <Column field="id_number" header="الرقم ">
        <template #body="slotProps">
                {{slotProps.index+1}}
            </template>
            </Column>

    <Column field="violation_date" header="تاريخ المخالفة">
    </Column>
    <Column field="action_performed" header=" الاجراء المنفذ">
        
    </Column>
    <Column field="violation_procedure_id" header="نوع الاجراء">
        
    </Column>
    <Column field="violation_degree_id" header="درجة المخالفة">
        
    </Column>
    <Column field="student_signature" header="توقيع الطالب">
        
    </Column>
    <Column field="suprvisore_signature" header=" توقيع الاداري">
        
    </Column>

    <Column fheader="  الاجراءات" style="max-width:8rem">
        <template #body="slotProps">
            <Button icon="pi pi-download" class="p-button-rounded p-button-help ml-2" />
            <Button icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
            <Button icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
        </template>

    </Column>
    </DataTable>

</div>

<Dialog v-model:visible="ViolationDialog" :style="{width: '450px'}" :header="header" :modal="true" 
class="p-fluid font-bold text-lg">

    <div class="field">
        <label for="violation_date">تاريخ المخالفة </label>
        <Calendar id="violation_date" :showIcon="true" 
        v-model="form.violation_date"
        :class="{ 'p-invalid':v$.form.violation_date.$invalid && submitted }"></Calendar>
        <small class="p-error" v-if="v$.form.violation_date.$invalid && submitted">يرجى اختبار  تاريخ  </small>

      </div>
      <div class="field">
        <label for="action_performed"> الاجراء المنفذ  </label>
        <InputText
        id="action_performed"
        v-model.trim="form.action_performed"
        :class="{ 'p-invalid':v$.form.action_performed.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.action_performed.$invalid && submitted">يرجى  ادخال سبب     </small>

        </div >

      <div class="field">
        <label for="violation_procedure_id"> نوع الاجراء</label>
        <Dropdown
        id="violation_procedure_id"
        filter="true"
        v-model="form.violation_procedure_id"
        :options="violation_procedures"
        optionLabel="name"
        placeholder="اختر"
        option-value="id"
        :class="{ 'p-invalid':v$.form.violation_procedure_id.$invalid && submitted }"
        />
        <small class="p-error" v-if="v$.form.violation_procedure_id.$invalid && submitted">يرجى  اختبار نوع الاجراء </small>
      </div>
      <div class="field">
        <label for="violation_degree_id">درجة المخالفة</label>
        <Dropdown
        id="violation_degree_id"
        filter="true"
        v-model="form.violation_degree_id"
        :options="violation_degrees"
        optionLabel="name"
        placeholder="اختر"
        option-value="id"
        :class="{ 'p-invalid':v$.form.violation_degree_id.$invalid && submitted }"
        />
        <small class="p-error" v-if="v$.form.violation_degree_id.$invalid && submitted">يرجى  اختبار درجةالمخالفة  </small>
      </div>

     <div  class="field">
            <label for="student_signature"> توقيع الطالب </label>
            <InputText
            id="student_signature"
            v-model.trim="form.student_signature"
            required="true"
            :class="{ 'p-invalid':v$.form.student_signature.$invalid && submitted }"
            />
            <small class="p-error" v-if="v$.form.student_signature.$invalid && submitted">يرجى  ادخال توقيع     </small>

        </div>

        <div  class="field">
            <label for="suprvisore_signature"> توقيع الاداري </label>
            <InputText
            id="suprvisore_signature"
            v-model.trim="form.suprvisore_signature"
            required="true"
            :class="{ 'p-invalid':v$.form.suprvisore_signature.$invalid && submitted }"
            />
            <small class="p-error" v-if="v$.form.suprvisore_signature.$invalid && submitted">يرجى  ادخال توقيع     </small>

        </div>
      <div class="field">
        <Button label="تعديل" v-if="form.id" class="mt-5" type="submit" @click="save(!v$.$invalid)"  />
        <Button label="حفظ" v-if="form.id==null" class="mt-5" type="submit" @click="save(!v$.$invalid)"  />
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

export default {
setup () {
    return { v$: useVuelidate() }
},
props: ["student_id"],

data() {
    return {
        
        student_violations: [],
        violation_procedures: [],
        violation_degrees: [],
        header:null,
        ViolationDialog: false,


        successMsg: false,
        Msg: null,
        deleteMsg:null,
        errorMsg: false,
        deleteconfirm:false,
        form:{},
        submitted: false,
        
        violationsService: null,
        constantsService:null,
    }  
},
validations() {
    return {
    form: {
        violation_date: { required },
        action_performed: { required },
        violation_procedure_id: { required },
        violation_degree_id: { required },
        suprvisore_signature: { required },
        student_signature: { required },
    }
    }
  },
created() {
    this.violationsService = new ViolationsService();  
    this.constantsService = new ConstantsService();
},
methods: {
    openNew() {
        this.header="اضافة مخالفة"
        this.form = {};
        this.submitted = false;
        this.ViolationDialog = true;
        this.getViolationProcedures();
        this.getViolationDegrees();

    },
    openEdit(data) {
        this.header="تعديل مخالفة"
        this.form = { ...data };  
        this.ViolationDialog = true;
        this.getViolationProcedures();
        this.getViolationDegrees();
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
    save(isFormValid) {
   
            this.submitted = true;
            if (!isFormValid) {
                return;
        }   
        this.form.student_id=this.student_id
        this.violationsService.save(this.form, this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.ViolationDialog = false;
            this.successMsg = true;
                this.Msg = data.msg;
                this.getViolations();
        }
        });        },
    deleteViolation() { 
        this.violationsService.delete(this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.deleteconfirm = false;
            this.successMsg = true;
            this.Msg = data.msg;
        }
        });
        this.student_violations = this.student_violations.filter(val => val.id !== this.form.id);
        this.form = {};
    },

    getViolations() {
        this.query = { student_id: this.student_id };
        this.violationsService.index(this.query).then(({ data }) => {
        if (data.code == 200) {
            this.student_violations = data.data.violations;
        }
    });
    }

},

mounted() { 
    this.getViolations();
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