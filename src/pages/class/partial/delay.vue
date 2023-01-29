<template>
<div class="col-12 md:col-12" id="printDelays">
    <div class="grid">
        <div class="col-12 md:col-9 div-right">
            <span class="font-bold text-xl" style="color: var(--primary-color)">
            التاخير
            </span>
    </div>
    <div class="col-12 md:col-2 sm:col-7 button-dispaly">
    <Button 
        label=" اضافة تاخير"
        icon="pi pi-plus"
        class="p-button-outlined align-left"
        @click="openNew"
        v-if="this.can('DELAY_ADD_EDIT')"
        />
    </div>
    <div class="col-12 md:col-1 sm:col-5 button-dispaly">
        <Button 
            width="70%"
            label="طباعة"
            class="p-button-outlined align-left"
            @click="printDelays"
            v-if="this.can('DELAY_ADD_EDIT')"
            />
        </div>
    </div>

   
     <div class="col-12 md:col-12 mr-10" >
        <div hidden class="name">  الطالب : {{student_name}}</div>
    <DataTable  :value="student_delays" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
    <Column field="id_number" header="الرقم ">
        <template #body="slotProps">
                {{slotProps.index+1}}
            </template>
            </Column>
    <Column field="delay_day" header="يوم التاخير">
    <template #body="slotProps">
        {{getDay(slotProps.data.delay_date)}}
    </template>
      </Column>
      <Column field="hijri_date" header="تاريخ الهجري">
        </Column>
    <Column field="delay_date" header="تاريخ التاخير">
    </Column>
    <Column field="delay_reason" header="سبب التاخير">
        
    </Column>
    <Column field="delay_amount" header="مقدار التاخير">
        
    </Column>
    <Column field="student_signature" header=" توقيع الطالب">
        
    </Column>

    <Column  header="  الاجراءات" style="max-width:8rem">
        <template #body="slotProps">
            <!-- <Button icon="pi pi-download" class="p-button-rounded p-button-help ml-2" /> -->
            <Button   v-if="this.can('DELAY_ADD_EDIT')" icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
            <Button   v-if="this.can('DELAY_DELETE')" icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
        </template>

    </Column>
    </DataTable>

</div>
</div>
<Dialog v-model:visible="DelayDialog" :style="{width: '450px'}" :header="header" :modal="true" 
class="p-fluid font-bold text-lg">
<div class="field col">
    <label for="">تاريخ التأخير / هجري </label>           
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
        <label for="delay_date">تاريخ التاخير  / ميلادي</label>
        <Calendar id="delay_date" :showIcon="true" 
        v-model="form.delay_date"
        :class="{ 'p-invalid':v$.form.delay_date.$invalid && submitted }"></Calendar>
        <small class="p-error" v-if="v$.form.delay_date.$invalid && submitted">يرجى اختيار  تاريخ  </small>

      </div>
      
      <div class="field">
        <label for="delay_reason"> سبب التاخير </label>
        <InputText
        id="delay_reason"
        v-model.trim="form.delay_reason"
        :class="{ 'p-invalid':v$.form.delay_reason.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.delay_reason.$invalid && submitted">يرجى  ادخال سبب     </small>

        </div >
        <div class="field">
        <label for="delay_amount"> مقدار التاخير </label>
        <InputText
        id="delay_amount"
        v-model.trim="form.delay_amount"
        :class="{ 'p-invalid':v$.form.delay_amount.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.delay_amount.$invalid && submitted">يرجى  ادخال مقدار     </small>

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
             <Button label="حذف"  class=" p-button-outlined mt-5"   @click="deleteDelay" />
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
import DelaysService from "@/services/delaysService";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import {hijri_months} from "@/services/constants.js";
export default {
setup () {
    return { v$: useVuelidate() }
},
props: ["student_id",'class_id','student_name'],

data() {
    return {
        submitted:false,
        student_delays: [],
        header:null,
        DelayDialog: false,
        successMsg: false,
        Msg: null,
        deleteMsg:null,
        errorMsg: false,
        deleteconfirm:false,
        form:{},
        submitted: false,
        
        delaysService: null,
        days: Array.from({ length: 31 }, (_, i) => ({ id: String((i+1)), name: (i+1) })),
            hijri_months: [],
            years: Array.from({ length: 10 }, (_, i) => ({ id: String((i+1444)), name: (i+1444) })),
    }  
},
validations() {
    return {
    form: {
        delay_date: { required },
        delay_reason: { required },
        delay_amount: { required },
            student_signature: { required },
            day: { required },
                month:{ required },
            year:{ required },
    }
    }
  },
created() {
    this.delaysService = new DelaysService();  
},
methods: {
    openNew() {
        this.header="اضافة تاخير"
        this.form = {};
        this.submitted = false;
        this.DelayDialog = true;

    },
    openEdit(data) {
        this.header="تعديل تاخير"
        this.form = { ...data };  
        this.DelayDialog = true;
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
    save(isFormValid) {
            this.successMsg = false;
            this.submitted = true;
            if (!isFormValid) {
                return;
        } 
        this.form.class_id = this.class_id;  
        this.form.student_id = this.student_id
        this.form.delay_date = this.formatDate(this.form.delay_date);
        this.form.hijri_date = this.form.day + ' ,' + this.form.month+' ,'+this.form.year;

        this.delaysService.save(this.form, this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.DelayDialog = false;
            this.successMsg = true;
                this.Msg = data.msg;
                this.getDelays();
        }
        });        },
    deleteDelay() { 
        this.successMsg = false;

        this.delaysService.delete(this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.deleteconfirm = false;
            this.successMsg = true;
                this.Msg = data.msg;
                this.student_delays = this.student_delays.filter(val => val.id !== this.form.id);
                this.form={}
        }
        });
    },

    getDelays() {
        this.query = { student_id: this.student_id };
        this.delaysService.index(this.query).then(({ data }) => {
        if (data.code == 200) {
            this.student_delays = data.data.delays;
        }
    });
    },
    printDelays () {
        this.$htmlToPaper('printDelays');
      },

},

mounted() { 
    this.getDelays();
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