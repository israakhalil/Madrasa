<template>
        <div class="grid p-fluid mt-5 font-bold mr-5">
          <div class="col-12 md:col-9 justify-content-right mr-10">
            <span class="font-bold text-xl" style="color: var(--primary-color)">
              البيانات الرئيسية
            </span>
          </div>
          <div class="col-12 md:col-3 button-dispaly">
            <Button
              width="70%"
              label=" تعديل بيانات الطالب"
              icon="pi pi-pencil"
              class="p-button-outlined ml-10"            
              v-if="this.can('STUDENT_ADD_EDIT')"
              @click="openEdit(this.student)"/>
          

            </div>
          
        </div>

        <div class="grid p-fluid mt-5 font-bold mr-5 student_print_hide">
      <div class="field col-12 md:col-2">
        <label for="name">اسم الطالب </label>
        <InputText
          id="name" disabled
          v-model.trim="student.name"
         
        />
      </div>
      <div class="field col-12 md:col-2">
        <label for="id_number"> رقم الهوية</label>
        <InputText 
          id="id_number" disabled
          v-model.trim="student.id_number"

        />
      </div>
      <div class="field col-12 md:col-2">
        <label for="date_of_birth"> تاريخ الميلاد </label>
        <InputText
          id="date_of_birth" disabled
          v-model.trim="student.date_of_birth"
          autofocus
        />
      </div>
      <div class="field col-12 md:col-2">
        <label for="phone_1"> هاتف ولي الامر (الاول) </label>
        <InputText 
          id="phone_1" disabled
          v-model.trim="student.phone_1"
        />
              </div>
      <div class="field col-12 md:col-2">
        <label for="phone_2">  هاتف ولي الامر (الثاني)</label>
        <InputText
          id="phone_2" disabled
          v-model.trim="student.phone_2"
        />
      </div>
      <div class="field col-12 md:col-2">
        <label for="phone_3"> هاتف ولي الامر (الثالث) </label>
        <InputText
          id="phone_3" disabled
          v-model.trim="student.phone_3"         
        />
      </div>
         </div>


         <div class="col-12 md:col-12 mt-5" >
            <DataTable  :value="student1" class="p-datatable-lg font-bold student_print_show" showGridlines  responsiveLayout="scroll">
                <Column field="name" header="اسم الطالب"></Column>
                <Column field="id_number" header="رقم الهوية"> </Column>
                <Column field="date_of_birth" header="تاريخ الميلاد"></Column>
                <Column field="phone_1" header=" هاتف ولي الامر (الاول)"></Column>
                <Column field="phone_2" header=" هاتف ولي الامر (الثاني)"></Column>
                <Column  header="  الاجراءات" style="max-width:8rem"></Column>
            </DataTable>
      </div>
         <Dialog v-model:visible="StudentEditDialog" :style="{width: '450px'}" 
        header="تعديل بيانات الطالب" :modal="true" 
            class="p-fluid font-bold text-lg">
        <form @submit.prevent="save(!v$.$invalid)">


        <div class="field">
            <label for="name"> اسم الطالب </label>
            <InputText
            id="name"
            v-model.trim="student_profile.name"
            :class="{ 'p-invalid':v$.student_profile.name.$invalid && submitted }"/>
              <small class="p-error" v-if="v$.student_profile.name.$invalid && submitted">
                يرجى  ادخال اسم الطالب     </small>
          </div>

          <div class="field">
            <label for="id_number"> رقم الهوية  </label>
            <InputText
            id="id_number"
            v-model.trim="student_profile.id_number"
            :class="{ 'p-invalid':v$.student_profile.id_number.$invalid && submitted }"/>
              <small class="p-error" v-if="v$.student_profile.id_number.$invalid && submitted">يرجى  ادخال رقم الهوية      </small>
            </div >
            <div class="field">
                <label for="date_of_birth">تاريخ الميلاد </label>
                <Calendar id="date_of_birth" :showIcon="true" 
                v-model="student_profile.date_of_birth"
                :class="{ 'p-invalid':v$.student_profile.date_of_birth.$invalid && submitted }"></Calendar>
                <small class="p-error" v-if="v$.student_profile.date_of_birth.$invalid && submitted">يرجى اختبار  تاريخ الميلاد  </small>

            </div>
          <div class="field">
            <label for="phone_1"> (الاول) هاتف ولي الامر  </label>
            <InputText
            id="phone_1"
            v-model.trim="student_profile.phone_1"
            :class="{ 'p-invalid':v$.student_profile.phone_1.$invalid && submitted }"/>
              <small class="p-error" v-if="v$.student_profile.phone_1.$invalid && submitted">يرجى  ادخال هاتف ولي الامر     </small>
            </div>
            <div class="field">
                <label for="phone_2"> (الثاني) هاتف ولي الامر  </label>
                <InputText
                id="phone_2"
                v-model.trim="student_profile.phone_2"
                />
            </div>
            <div class="field">
                <label for="phone_3"> (الثالث) هاتف ولي الامر  </label>
                <InputText
                id="phone_3"
                v-model.trim="student_profile.phone_3"
                />
            </div>
          <div class="field">
            <Button label="تعديل"  ffclass="mt-5"  type="submit"  />
          </div>

        </form>
        </Dialog>


</template>
  

<script>
import StudentsService from "@/services/studentsService";

import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";

export default {
    props: [ "id"],
    setup () {
        return {
            v$: useVuelidate()
        }
},
    data() {
        return {
          student: [],
          student1:[],
            StudentEditDialog: false,
            student_profile: {},
            submitted: false,
            studentsService:null

        };
    },
    validations() {
    return {
        student_profile: {
            name: { required },
            id_number: { required },
            phone_1: { required },
            date_of_birth: {required},
        
        }
    }
  },

    created() {
        this.studentsService = new StudentsService();
    },
    methods: {
        getStudents() {
            this.studentsService.index({ id: this.id }).then(({ data }) => {
                if (data.code == 200) {
                  this.student = data.data.Students[0];
                    this.student1=  data.data.Students
                }
            });
        },
        openEdit(data) { 
            this.StudentEditDialog = true
             this.student_profile = { ...data };  
        },

        save(isFormValid) {

            // this.successMsg = false
          this.submitted = true;
            if (!isFormValid) {
                return;
            }
        this.student_profile.class_id = this.class_id;
          this.student_profile.date_of_birth = this.formatDate(this.student_profile.date_of_birth)
        this.studentsService.edit(this.student_profile, this.id).then(({ data }) => {
            if (data.code == 200) {
                this.StudentEditDialog = false;
                this.submitted = false
                this.getStudents();
        }
        });
        },


    },
    mounted() {
        this.getStudents();
    },

}
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
.student_print_show{
  display: none;
}
</style>