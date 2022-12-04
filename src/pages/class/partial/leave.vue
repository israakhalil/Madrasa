<template>

    <div class="col-10 md:col-10 mr-10">
            <span class="font-bold text-xl" style="color: var(--primary-color)">
            الاذونات
            </span>
    </div>
    <div class="col-2 md:col-2">
    <Button 
        width="70%"
        label=" اضافة استئذان"
        icon="pi pi-plus"
        class="p-button-outlined align-left"
        @click="openNew"
        v-if="this.can('LEAVE_ADD_EDIT')"
        />
    </div>
    <div class="col-12 md:col-12 mr-10">
    <DataTable  :value="student_leaves" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
    <Column  header="الاستئذان ">
        <template #body="slotProps">
                {{slotProps.index+1}}
            </template>
            </Column>

    <Column field="leave_date" header="تاريخ الاستئذان">
    </Column>
    <Column field="leave_reason" header="سبب الاستئذان">
        
    </Column>
    <Column field="leave_time" header="وقت الاستئذان">
        
    </Column>
    <Column field="student_signature" header=" توقيع الطالب">
        
    </Column>

    <Column  header="  الاجراءات" style="max-width:8rem">
        <template #body="slotProps">
            <!-- <Button icon="pi pi-download" class="p-button-rounded p-button-help ml-2" /> -->
            <Button   v-if="this.can('LEAVE_ADD_EDIT')" icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
            <Button   v-if="this.can('LEAVE_DELETE')" icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
        </template>

    </Column>
    </DataTable>

</div>

<Dialog v-model:visible="LeaveDialog" :style="{width: '450px'}" :header="header" :modal="true" 
class="p-fluid font-bold text-lg">

    <div class="field">
        <label for="leave_date">تاريخ الاستئذان </label>
        <Calendar id="leave_date" :showIcon="true" 
        v-model="form.leave_date"
        :class="{ 'p-invalid':v$.form.leave_date.$invalid && submitted }"></Calendar>
        <small class="p-error" v-if="v$.form.leave_date.$invalid && submitted">يرجى اختبار  تاريخ  </small>

      </div>
      <div class="field">
        <label for="leave_reason"> سبب الاستئذان </label>
        <InputText
        id="leave_reason"
        v-model.trim="form.leave_reason"
        :class="{ 'p-invalid':v$.form.leave_reason.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.leave_reason.$invalid && submitted">يرجى  ادخال سبب     </small>

        </div >
        <div class="field">
        <label for="leave_time"> وقت الخروج </label>
        <Calendar :showIcon="true"  inputId="time12" :timeOnly="true" 
        hourFormat="12"
        v-model="form.leave_time"
        :class="{ 'p-invalid':v$.form.leave_time.$invalid && submitted }"></Calendar>
        <small class="p-error" v-if="v$.form.leave_time.$invalid && submitted">يرجى  ادخال وقت التاخير     </small> 


        <!-- <InputText
        id="leave_time"
        v-model.trim="form.leave_time"
        :class="{ 'p-invalid':v$.form.leave_time.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.leave_time.$invalid && submitted">يرجى  ادخال مقدار     </small> -->

        </div >
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
             <Button label="حذف"  class=" p-button-outlined mt-5"   @click="deleteLeave" />
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
import LeavesService from "@/services/leavesService";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
setup () {
    return { v$: useVuelidate() }
},
props: ["student_id",'class_id'],

data() {
    return {
        submitted:false,
        student_leaves: [],
        header:null,
        LeaveDialog: false,
        successMsg: false,
        Msg: null,
        deleteMsg:null,
        errorMsg: false,
        deleteconfirm:false,
        form:{},
        submitted: false,
        
        leavesService: null,
    }  
},
validations() {
    return {
    form: {
        leave_date: { required },
        leave_reason: { required },
        leave_time: { required },
        student_signature: { required },
    }
    }
  },
created() {
    this.leavesService = new LeavesService();  
},
methods: {
    openNew() {
        this.header="اضافة استئذان"
        this.form = {};
        this.submitted = false;
        this.LeaveDialog = true;

    },
    openEdit(data) {
        this.header="تعديل استئذان"
        this.form = { ...data };  
        this.LeaveDialog = true;
    },
    openDelete(data) { 
        this.form = data;
        this.deleteconfirm = true;
        this.deleteMsg = "هل انت متاكد من الحذف ";
    },
    save(isFormValid) {
            this.successMsg = false;
            this.submitted = true;
            if (!isFormValid) {
                return;
        }   
        this.form.class_id = this.class_id;
        this.form.student_id = this.student_id;
        this.form.leave_date=this.formatDate(this.form.leave_date)

        this.leavesService.save(this.form, this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.LeaveDialog = false;
            this.successMsg = true;
            this.Msg = data.msg;
            this.getLeaves();
        }
        });        },
    deleteLeave() { 
        this.successMsg = false;

        this.leavesService.delete(this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.deleteconfirm = false;
            this.successMsg = true;
                this.Msg = data.msg;
                this.student_leaves = this.student_leaves.filter(val => val.id !== this.form.id);

        }
        });
        this.form = {};
    },

    getLeaves() {
        this.query = { student_id: this.student_id };
        this.leavesService.index(this.query).then(({ data }) => {
        if (data.code == 200) {
            this.student_leaves = data.data.leaves;
        }
    });
    }

},

mounted() { 
    this.getLeaves();
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