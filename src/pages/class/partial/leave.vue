<template>
<div class="col-12 md:col-12" >
    <div class="grid">
    <div class="col-12 md:col-9 div-right">
            <span class="font-bold text-xl" style="color: var(--primary-color)">
            الاذونات
            </span>
    </div>
    <div class="col-12 md:col-2 sm:col-7 button-dispaly">
    <Button 
        width="70%"
        label=" اضافة استئذان"
        icon="pi pi-plus"
        class="p-button-outlined align-left"
        @click="openNew"
        v-if="this.can('LEAVE_ADD_EDIT')"
        />
    </div>
    <div class="col-12 md:col-1 sm:col-5 button-dispaly">
    <Button 
            width="70%"
            label="طباعة"
            class="p-button-outlined align-left"
            @click="printLeaves"
            v-if="this.can('LEAVE_ADD_EDIT')"
            />
    </div>
    </div>
    <div class="col-12 md:col-12 mr-10" >

    <DataTable  :value="student_leaves" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
    <Column  header="الاستئذان ">
        <template #body="slotProps">
                {{slotProps.index+1}}
            </template>
            </Column>
     <Column field="leave_day" header="يوم الاستئذان">
    <template #body="slotProps">
        {{getDay(slotProps.data.leave_date)}}
    </template>
      </Column>
      <Column field="hijri_date" header="تاريخ الهجري">
        </Column>
    <Column field="leave_date" header="تاريخ الاستئذان">
    </Column>
    <Column field="leave_reason" header="سبب الاستئذان">
        
    </Column>
    <Column field="leave_time" header="وقت الاستئذان">
        
    </Column>
    <Column field="leave_time" header="وقت الاستئذان">
        
    </Column>
    <Column field="student_signature" header=" توقيع الطالب">
        
    </Column>
    <Column field="student_signature" header="ولي الامر">
        <template #body="slotProps">
        {{slotProps.data.guardian_id}} - {{slotProps.data.guardian_name}}
        </template>
    </Column>

    <Column  header="  الاجراءات" style="max-width:10rem">
        <template #body="slotProps">
            <Button v-if="slotProps.data.attached" icon="pi pi-download" class="p-button-rounded p-button-help ml-2" @click="download(slotProps.data.file)"/> 
            <Button   v-if="this.can('LEAVE_ADD_EDIT')" icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
            <Button   v-if="this.can('LEAVE_DELETE')" icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
        </template>

    </Column>
    </DataTable>

</div>
</div>
<Dialog v-model:visible="LeaveDialog" :style="{width: '450px'}" :header="header" :modal="true" 
class="p-fluid font-bold text-lg">
<div class="field col">
    <label for="">تاريخ الاستئذان / هجري </label>           
           
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
        <label for="leave_date">تاريخ الاستئذان / ميلادي</label>
        <Calendar id="leave_date" :showIcon="true" 
        v-model="form.leave_date"
        :class="{ 'p-invalid':v$.form.leave_date.$invalid && submitted }"></Calendar>
        <small class="p-error" v-if="v$.form.leave_date.$invalid && submitted">يرجى اختيار  تاريخ  </small>

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

        <div class="field">
            <label for="guardian_name">اسم ولي الامر الذي خرج معه الطالب</label>
            <InputText id="guardian_name" v-model.trim="form.guardian_name"/>
        </div >
        <div class="field">
            <label for="guardian_id">رقم هوية ولي الامر  </label>
            <InputText id="guardian_id" v-model.trim="form.guardian_id"/>
        </div>
        <!-- <InputText
        id="leave_time"
        v-model.trim="form.leave_time"
        :class="{ 'p-invalid':v$.form.leave_time.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.leave_time.$invalid && submitted">يرجى  ادخال مقدار     </small> -->

        </div >
        <div class="field">
        <label for="file">الملف المرفق</label>
        <div class="inputfile-box">
            <input
            type="file"
            id="file"
            class="inputfile"
            @change="uploadFile"
            />
            <label for="file">
            <span class="p-input-icon-left">
                <i class="pi pi-upload" aria-hidden="true"></i>
                <span id="file-name" class="file-box">{{form.attached}}</span>
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
            <small class="p-error" v-if="v$.form.student_signature.$invalid && submitted">يرجى  ادخال توقيع     </small>

        </div>
      <div class="field">
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
import { hijri_months } from "@/services/constants.js";

export default {
setup () {
    return { v$: useVuelidate() }
},
    props: ["student_id", 'class_id'],
    emits:['sign'],

data() {
    return {
        loading:false,
        submitted:false,
        student_leaves: [],
        header:null,
        LeaveDialog: false,
        successMsg: false,
        Msg: null,
        attached:null,
        deleteMsg:null,
        errorMsg: false,
        deleteconfirm:false,
        form:{},
        submitted: false,
        
        leavesService: null,
        days: Array.from({ length: 31 }, (_, i) => ({ id: String((i+1)), name: (i+1) })),
            hijri_months: [],
            years: Array.from({ length: 10 }, (_, i) => ({ id: String((i+1444)), name: (i+1444) })),
    }  
},
validations() {
    return {
    form: {
        leave_date: { required },
        leave_reason: { required },
        leave_time: { required },
            student_signature: { required },
            day: { required },
                month:{ required },
            year:{ required },
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
    uploadFile(e) {
        this.form.attached = e.target.files[0].name;
        this.attached = e.target.files[0]
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
        const formData = new FormData()   
        this.form.class_id = this.class_id;
        this.form.student_id = this.student_id;
        this.form.leave_date = this.formatDate(this.form.leave_date);
        this.form.hijri_date = this.form.day + ' ,' + this.form.month+' ,'+this.form.year;

        formData.append('attached', this.attached)
        formData.append('data', JSON.stringify(this.form))
        this.leavesService.save(formData, this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.LeaveDialog = false;
            this.successMsg = true;
                this.Msg = data.msg;
                this.loading = false; 
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
                this.form={}
        }
        });
    },

    getLeaves() {
        this.query = { student_id: this.student_id };
        this.leavesService.index(this.query).then(({ data }) => {
        if (data.code == 200) {
            this.student_leaves = data.data.leaves;
        }
    });
    },
    printLeaves() {
        this.$emit('sign', 1)
        setTimeout(() => this.$htmlToPaper('printLeaves'), 10)
        // this.$htmlToPaper('printLeaves');
      },

},

mounted() { 
    this.getLeaves();
    this.hijri_months = hijri_months;
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