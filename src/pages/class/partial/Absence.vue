<template>

        <div class="col-10 md:col-10 mr-10">
                <span class="font-bold text-xl" style="color: var(--primary-color)">
                الغياب
                </span>
        </div>
        <div class="col-2 md:col-2">
        <Button 
            width="70%"
            label=" اضافة غياب"
            icon="pi pi-plus"
            class="p-button-outlined align-left"
            @click="openNew"
            />
        </div>
        <div class="col-12 md:col-12 mr-10">
        <DataTable  :value="student_absences" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
        <Column field="id_number" header="الرقم ">
            <template #body="slotProps">
                    {{slotProps.index+1}}
                </template>
                </Column>

        <Column field="absence_date" header="تاريخ الغياب">
        </Column>
        <Column field="absence_reason" header="سبب الغياب">
            
        </Column>
        <Column field="absence_type_name" header="نوع الغياب">
            
        </Column>
        <Column field="teacher_signature" header=" توقيع المعلم">
            
        </Column>

        <Column fheader="  الاجراءات" style="max-width:8rem">
            <template #body="slotProps">
                <!-- <Button icon="pi pi-download" class="p-button-rounded p-button-help ml-2" /> -->
                <Button icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
                <Button icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
            </template>

        </Column>
        </DataTable>
   
    </div>

    <Dialog v-model:visible="AbsenceDialog" :style="{width: '450px'}" :header="header" :modal="true" 
    class="p-fluid font-bold text-lg">

        <div class="field">
            <label for="absence_date">تاريخ الغياب </label>
            <Calendar id="absence_date" :showIcon="true" 
            v-model="form.absence_date"
            :class="{ 'p-invalid':v$.form.absence_date.$invalid && submitted }"></Calendar>
            <small class="p-error" v-if="v$.form.absence_date.$invalid && submitted">يرجى اختبار  تاريخ  </small>

          </div>
          <div class="field">
            <label for="absence_type_id"> نوع الغياب</label>
            <Dropdown
            id="absence_type_id"
            :filter=true
            v-model="form.absence_type_id"
            :options="absence_types"
            optionLabel="name"
            placeholder="اختر"
            option-value="id"
            :class="{ 'p-invalid':v$.form.absence_type_id.$invalid && submitted }"
            />
            <small class="p-error" v-if="v$.form.absence_type_id.$invalid && submitted">يرجى  اختبار نوع الغياب </small>
          </div>
          <div class="field">
            <label for="absence_reason"> سبب الغياب </label>
            <InputText
            id="absence_reason"
            v-model.trim="form.absence_reason"
            :class="{ 'p-invalid':v$.form.absence_reason.$invalid && submitted }"/>
              <small class="p-error" v-if="v$.form.absence_reason.$invalid && submitted">يرجى  ادخال سبب     </small>

            </div >
            <div  class="field">
                <label for="teacher_signature"> توقيع المعلم </label>
        <InputText
          id="teacher_signature"
          v-model.trim="form.teacher_signature"
          required="true"
          :class="{ 'p-invalid':v$.form.teacher_signature.$invalid && submitted }"
        />
        <small class="p-error" v-if="v$.form.teacher_signature.$invalid && submitted">يرجى  ادخال توقيع     </small>

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
                 <Button label="حذف"  class=" p-button-outlined mt-5"   @click="deleteAbsence" />
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
import AbsencesService from "@/services/absencesService";
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
            submitted:false,
            student_absences: [],
            absence_types: [],
            header:null,
            AbsenceDialog: false,
            successMsg: false,
            Msg: null,
            deleteMsg:null,
            errorMsg: false,
            deleteconfirm:false,
            form:{},
            submitted: false,
            
            absencesService: null,
            constantsService:null,
        }  
    },
    validations() {
        return {
        form: {
            absence_date: { required },
            absence_type_id: { required },
            absence_reason: { required },
            teacher_signature: { required },
        }
        }
      },
  created() {
        this.absencesService = new AbsencesService();  
        this.constantsService = new ConstantsService();
  },
    methods: {
        openNew() {
            this.header="اضافة غياب"
            this.form = {};
            this.submitted = false;
            this.AbsenceDialog = true;
            this.getAbsenceType();

        },
        openEdit(data) {
            this.header="تعديل غياب"
            this.form = { ...data };  
            this.AbsenceDialog = true;
            this.getAbsenceType();
        },
        openDelete(data) { 
            this.form = data;
            this.deleteconfirm = true;
            this.deleteMsg = "هل انت متاكد من الحذف ";
        },
        getAbsenceType() {
            this.constantsService.fetchAbsenceTypes().then(({ data }) => {
                this.absence_types = data.data.absenceTypes;
            });
        },
        save(isFormValid) {
                 this.successMsg = false;

                this.submitted = true;
                if (!isFormValid) {
                    return;
            }   
            this.form.student_id=this.student_id
            this.absencesService.save(this.form, this.form.id).then(({ data }) => {
                if (data.code == 200) {
                this.AbsenceDialog = false;
                this.successMsg = true;
                    this.Msg = data.msg;
                    this.getAbsences();
            }
            });        },
        deleteAbsence() { 
            this.successMsg = false;
            this.absencesService.delete(this.form.id).then(({ data }) => {
                if (data.code == 200) {
                this.deleteconfirm = false;
                this.successMsg = true;
                this.Msg = data.msg;
                this.student_absences = this.student_absences.filter(val => val.id !== this.form.id);

            }
            });
            this.form = {};
        },

        getAbsences() {
            this.query = { student_id: this.student_id };
            this.absencesService.index(this.query).then(({ data }) => {
            if (data.code == 200) {
                this.student_absences = data.data.absences;
            }
        });
        }

    },

    mounted() { 
        this.getAbsences();
        // this.query = { student_id: this.student_id };
        // this.absencesService.index(this.query).then(({ data }) => {
        //     if (data.code == 200) {
        //         this.student_absences = data.data.absences;
        //     }
        // });
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