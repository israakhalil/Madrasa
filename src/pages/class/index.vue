<template>
  <div class="grid list_container" style="height: 87vh; padding:0rem;">
    <div class="col-12 md:col-12 re_quick">
      <div class="card list_container2">
        <div class="grid my-2 font-bold mr-10">
            <div class="col-5 md:col-5  py-4">
              <span class="font-bold text-xl"
                >المراحل المدرسية > {{ this.class.level_name }} >
                {{ this.class.name }}</span
              >
            </div>
            <div class="col-7 md:col-7">
                <div class="grid">
                    <div class="col-5 md:col-5">
                        <span class="col-12 p-input-icon-right">
                            <i class="pi pi-search mr-3" />
                            <InputText type="text" 
                            v-model="filter_name" 
                            @input="onFilter"
                            placeholder="بحث ... " />
                        </span>

                     </div>
                    <div class="col-4 md:col-4 justify-content-center mt-2"  v-tooltip="'يجب على الاقل ان يحتوي الملف على عمود الاسم  '">
                        <FileUpload
                        v-if="this.can('STUDENT_IMPORT')"
                        style="width:100%"
                       
                            mode="basic"
                            accept=".xlsx"
                            :maxFileSize="1000000"
                            label="سحب البيانات"
                            chooseLabel="سحب البيانات"
                            uploadIcon ="pi pi-folder-open"
                            class="p-button-outlined p-button-success "
                            :customUpload="true"
                            @uploader="onUpload"
                        />
                    </div>
                
                    <div class="col-3 md:col-3 justify-content-right mt-2">
                        <Button  v-if="this.can('STUDENT_ADD_EDIT')" label="إضافة طالب"   icon="pi pi-plus" class="p-button-outlined " @click="openNew"/>

                    </div>
                  
            </div>
            <div>

            </div>
            </div>
        </div>

        <div>


          <DataTable :value="students" :loading="loading" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
            <Column field="id_number" header="الرقم ">
              <template #body="slotProps">
                        {{slotProps.index+1}}
                    </template>
                    </Column>

            <Column field="name" header=" اسم الطالب ثلاثي">
              <template #body="slotProps">
                <div class="join">
                      <span  class="font-semibold" style="cursor: pointer" 
                      @click="this.$router.push({ name: 'student-index', params: { id: slotProps.data.id,class_id: slotProps.data.class_id} })"> 
                      {{slotProps.data.name}} 
                      </span> 
                      </div>
               </template>
            </Column>
            <Column field="absence_count" header="الغياب">
              
            </Column>
            <Column field="leave_count" header="الاذونات">
              
            </Column>
            <Column field="delay_count" header="التأخير الصباحي">
              
            </Column>
            <Column field="violation_count" header="المخالفات السلوكية">
              
            </Column>
            <Column field="book_count" header=" تسليم الكتب">
              
            </Column>
            <Column fheader="  الاجراءات" style="max-width:8rem">
            <template #body="slotProps">
                <Button icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
            </template>

        </Column>
            <template #footer>
                في المجمل هناك  {{students ? students.length : 0 }} طالب.
            </template>
        </DataTable>
        </div>
      </div>

      <Dialog
          v-model:visible="AddStudentDialog"
          :style="{ width: '500px' }"
          header="اضافة طالب جدبد "
          :modal="true"
          class="p-fluid font-bold text-lg">

          <div class="field">
            <label for="name"> اسم الطالب</label>
            <InputText
              id="name"
              v-model.trim="form.name"
              required="true"
              autofocus
              :class="{ 'p-error':v$.form.name.$invalid && submitted }"/>
              <small class="p-error" v-if="v$.form.name.$invalid && submitted">يرجى ادخال اسم الطالب</small>
          </div>
          <div class="field">
            <label for="attached_id">الملف التعريفي للطالب</label>
            <div class="inputfile-box">
              <input
                type="file"
                id="file"
                class="inputfile"
                @change="uploadFile"
                accept=".xlsx"
              />
              <label for="file">
                <span class="p-input-icon-left">
                  <i class="pi pi-upload" aria-hidden="true"></i>
                  <span id="file-name" class="file-box">{{form.attached_id}}</span>
                </span>
              </label>
            </div>
                 
          </div>

          <div class="field">
            <Button label="حفظ" class="mt-5" type="submit" @click="saveStudent(!v$.$invalid)" />
          </div>
        </Dialog>

        <SuccessMsg :successMsg=successMsg  :Msg=Msg />

        
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
             <Button label="حذف"  class=" p-button-outlined mt-5"   @click="deleteStudent" />
        </div>
        <div class="col-6 md:col-6">            
             <Button label="الغاء"  class="p-button-outlined mt-5" @click="deleteconfirm = false"  />
        </div>
    </div>
        </template>

</Dialog>

    </div>
  </div>
</template>

<script>
import ClassesService from "@/services/classesService";
import StudentsService from "@/services/studentsService";
import { useVuelidate } from "@vuelidate/core";
import {required} from "@vuelidate/validators";

export default {
  setup () {
    return { v$: useVuelidate() }
  },
  props: ["id"],
  data() {
    return {
      form: {
            name: null,
            attached_id: null,
            class_id:null
      },
      loading: false,

      columns: null,
      class: [],
      AddStudentDialog: false,
      students: [],
      filter_name:null,
       filter: {},
       Msg:null,
      classesService: null,
      studentsService: null,
      successMsg: false,
      submitted: false,
      deleteconfirm: false,
      deleteMsg:false
    };
  },
  validations() {
    return {
      form: {
        name: { required },     
      }
    }
  },
  created() {
    this.classesService = new ClassesService();
    this.studentsService = new StudentsService();
  
  },
  methods:{ 
    openNew() {
      this.submitted = false;
      this.AddStudentDialog = true;
    },
    saveStudent(isFormValid) {
      this.successMsg = false;
      this.submitted = true;
      if (!isFormValid) {
        return;
      }
        const formData = new FormData()
        this.form.class_id=this.id
        formData.append('file_name', this.attachment)
        formData.append('data', JSON.stringify(this.form))
          const config = { headers: { 'Content-Type': 'multipart/form-data' } }   

          this.studentsService.store(formData, config).then(({ data }) => {
            this.AddStudentDialog = false;
            this.submitted = false;
            this.Msg = "تمت إضافة الطالب بنجاح ";
            this.successMsg = true;
            this.getStudents();  
            this.restform()

          });
    },


    onUpload(event) {
      this.loading = true;
      this.successMsg=false
      const formData = new FormData(event.target);
      formData.append('file_name', event.files[0])
      formData.append('class_id', this.id)

      this.classesService.import(formData).then((response) => {
        if(response.data.code===200){
          this.Msg = "تم الاسترداد بنجاح";
          this.successMsg = true
          this.loading=false
          this.getStudents()
        }
      });

    },

uploadFile(e) {
  this.form.attached_id = e.target.files[0].name;
   this.attachment=e.target.files[0]

},
  restform() {    
          this.form= {}
      },

  onFilter() {
    this.getStudents()
    },
  getStudents() {
    this.filter = { class_id: this.id, name: this.filter_name };

    this.studentsService.index( this.filter).then(({ data }) => {
      if (data.code == 200) {
      this.students = data.data.Students;
    }
  });
    },
    openDelete(data) { 
        this.form = data;
        this.deleteconfirm = true;
        this.deleteMsg = "هل انت متاكد من الحذف ";
    },
    deleteStudent() { 
        this.successMsg = false;

        this.studentsService.delete(this.form.id).then(({ data }) => {
          if (data.code == 200) {
            // this.students = this.students.filter(val => val.id !== this.form.id);
            this.deleteconfirm = false;
            this.successMsg = true;
                this.Msg = data.msg;
                this.getStudents()
                
        }
        });
        this.form = {};
    },
  },

  mounted() {
    this.query = { id: this.id };
    this.classesService.index(this.query).then(({ data }) => {
      if (data.code == 200) {
        this.class = data.data.Classes[0];
      }
    });
    this.getStudents()

  },
};
</script>

<style scoped>

.inputfile-box {
  position: relative;
}

.inputfile {
  display: none;
}
/* .hover{
  color: var(--primary-color)

} */
a {
 font-size: 1.2rem;
}
.join:hover span {
    color:var(--primary-color);
   font-size: 1.1rem;
}
.file-box {
  display: inline-block;
  width: 100%;
  border: 1px solid;
  padding: 5px 0px 5px 5px;
  box-sizing: border-box;
  height: calc(3.9rem - 2px);
  font-family: Cairo, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
    "Segoe UI Symbol";
  font-size: 1rem;
  color: #495057;
  background: #ffffff;
  padding: 0.75rem 0.75rem;
  border: 1px solid #ced4da;
  transition: background-color 0.2s, color 0.2s, border-color 0.2s,
    box-shadow 0.2s;
  appearance: none;
  border-radius: 6px;
}

.p-button:enabled:hover {
background: #7C3AED;
color: #ffffff;
border-color: #7C3AED;
}
.p-dialog .p-dialog-footer button{
width:100%
}
.card {
  border-radius: 0%;
  /*padding: 0rem;*/
}
.grid {
  margin-left: 0rem;
  margin-right: 0rem;
}
::-webkit-scrollbar {
    width: 14px !important;

  }

</style>
