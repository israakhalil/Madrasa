<template>
    <div class="col-12 md:col-12" >
        <div class="grid">
            <div class="col-12 md:col-10 div-right " >
                    <span class="font-bold text-xl" style="color: var(--primary-color)">
                     أنواع الغياب 
                    </span>
            </div>
            <div class="col-12 md:col-2 sm:col-12 button-dispaly">
            <Button 
                label=" اضافة نوع غياب"
                icon="pi pi-plus"
                class="col-12 p-fluid p-button-outlined align-left"
                @click="openNew"
                v-if="this.can('CONSTANTS_ADD_EDIT_DELETE')"
                />
            </div>
        </div>
         <div class="col-12 md:col-12 mr-10" >
            <DataTable  :value="student_absences_types"  class="table td p-datatable-lg font-bold"   showGridlines  responsiveLayout="scroll">
            <Column field="id_number" header="الرقم ">
                <template #body="slotProps">
                        {{slotProps.index+1}}
                    </template>
                    </Column>
              <Column field="name" header="نوع الغياب ">
            </Column>
            <Column header="  الاجراءات" style="max-width:8rem">
                <template #body="slotProps">
                    <Button v-if="this.can('CONSTANTS_ADD_EDIT_DELETE')" icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
                    <Button v-if="this.can('CONSTANTS_ADD_EDIT_DELETE')" icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
                </template>
            </Column>
            </DataTable>
       
        </div>
    </div>
    
    
        <Dialog v-model:visible="AbsenceTypeDialog" :style="{width: '450px' }" :header="header" :modal="true"  class="p-fluid font-bold text-lg" >
              <div class="field">
                <label for="name"> سبب الغياب </label>
                <InputText id="name" v-model.trim="form.name" />
             </div>
              <div class="field">
                <Button :loading="loading" label="تعديل" v-if="form.id" class="mt-5" type="submit" @click="save()"  />
                <Button :loading="loading" label="حفظ" v-if="form.id==null" class="mt-5" type="submit" @click="save()"  />
              </div>
        </Dialog>
        <Dialog id="deleteconfirm" v-model:visible="deleteconfirm" :style="{ width: '450px' }" header="" :modal="true" class="font-bold text-3xl">
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
                            <Button label="حذف"  class=" p-button-outlined mt-5"   @click="deleteAbsenceType" />
                        </div>
                        <div class="col-6 md:col-6">            
                            <Button label="الغاء"  class="p-button-outlined mt-5" @click="deleteconfirm = false"  />
                        </div>
                    </div>
            </template>
        </Dialog>
    
            <SuccessMsg :successMsg=successMsg  :Msg=Msg />

</template>
    
<script>
import ConstantsService from "@/services/constantsService";
    export default {
       data() {
        return {
            form: {},
            student_absences_types: [],
            AbsenceTypeDialog: false,
            loading:false,
            submitted:false,
            header: null,
            successMsg: false,
            Msg: null,
            deleteconfirm:false,    
            constantsService:null,
    
            }  
        },

      created() {
            this.constantsService = new ConstantsService();
      },
        methods: {
    
            openNew() {
                this.header="اضافة نوع غياب"
                this.form = {};
                this.submitted = false;
                this.AbsenceTypeDialog = true;
    
            },
            openEdit(data) {
                this.header="تعديل نوع غياب"
                this.form = { ...data };  
                this.AbsenceTypeDialog = true;

            },
            openDelete(data) { 
                this.form = data;
                this.deleteconfirm = true;
                this.deleteMsg = "هل انت متاكد من الحذف ";
            },
          save() {
                 this.loading = true; 
                 this.successMsg = false;
                this.constantsService.storeAbsence(this.form, this.form.id).then(({ data }) => {
                    if (data.code == 200) {
                    this.AbsenceTypeDialog = false;
                    this.successMsg = true;
                    this.Msg = data.msg;
                    this.loading = false;
                   this.getAbsencesTypes();
                    }
                }).finally(() => {
                      this.loading = false; 
                });
            },
            deleteAbsenceType() { 
                this.successMsg = false;
                this.constantsService.deleteAbsence(this.form.id).then(({ data }) => {
                    if (data.code == 200) {
                    this.deleteconfirm = false;
                    this.successMsg = true;
                    this.Msg = data.msg;
                    this.student_absences_types = this.student_absences_types.filter(val => val.id !== this.form.id);
                    this.form={}
                    }
                });
              
            },
    
            getAbsencesTypes() {
                this.constantsService.fetchAbsenceTypes().then(({ data }) => {
                if (data.code == 200) {
                    this.student_absences_types = data.data.absenceTypes;
    
                }
            });
            },
    
        },
    
        mounted() { 
            this.getAbsencesTypes();
        }
};
</script>
      
     <style scoped>
     .font{
        color: #ffffff;
     }
    .p-button:enabled:hover {
        background: #7C3AED;
        color: #ffffff;
        border-color: #7C3AED;
    }
    .p-dialog .p-dialog-footer button{
        width:100%
    }
    ::-webkit-scrollbar {
        width: 10px !important;
    
      }
      /* .re_quick{
        overflow: auto;
        height: 75vh;
        padding: 10px;
      } */
    </style>