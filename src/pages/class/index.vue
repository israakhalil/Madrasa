<template>
  <div class="grid">
    <div class="col-12 md:col-12">
      <div class="card">
        <div class="grid my-2 font-bold">
            <div class="col-7 md:col-7 justify-content-right mr-10">
              <span class="font-bold text-xl "
                >المراحل المدرسية > {{ this.class.level_name }} >
                {{ this.class.name }}</span
              >
            </div>
            <div class="col-5 md:col-5 justify-content-left">
                <div class="grid">
                    <div class="col-6 md:col-6">
                        <span class="col-12 p-input-icon-right">
                            <i class="pi pi-search mr-3" />
                            <InputText type="text" v-model="value3" placeholder="بحث ... " />
                        </span>

                     </div>
                    <div class="col-3 md:col-3 justify-content-center mt-2">
                        <FileUpload
                        style="width:100%"
                            mode="basic"
                            accept="image/*"
                            :maxFileSize="1000000"
                            label="سحب البيانات"
                            chooseLabel="سحب البيانات"
                            uploadIcon ="pi pi-folder-open"
                            class="p-button-outlined p-button-success "
                        />
                    </div>
                
                    <div class="col-3 md:col-3 justify-content-right mt-2">
                        <Button label="إضافة طالب"  icon="pi pi-plus" class="p-button-outlined " @click="openNew"/>

                    </div>
                  
            </div>
            <div>

            </div>
            </div>
        </div>

        <div>
          <DataTable :value="products" responsiveLayout="scroll">
            <Column
              v-for="col of columns"
              :field="col.field"
              :header="col.header"
              :key="col.field"
            ></Column>
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

        <Dialog
          id="successMsg"
          v-model:visible="successMsg"
          :style="{ width: '450px' }"
          header=""
          :modal="true"
          class="font-bold text-3xl"
        >
          <div>
            <div class="justify-content-center text-center md:text-center">
              <i class="pi pi-check-circle" style="font-size: 5rem"></i>
            </div>

            <div class="justify-content-center text-center md:text-center">
              <span>تمت إضافة الطالب بنجاح </span>
            </div>
          </div>
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
      columns: null,
      class: [],
      AddStudentDialog: false,
      students: [],
      classesService: null,
      studentsService: null,
      successMsg: false,
      submitted:false
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

    this.columns = [
      { field: 'id_number', header: 'الرقم' },
      { field: "name", header: "اسم الطالب ثلاثي" },
      { field: 'absence', header: 'الغياب' },
      { field: 'quantity', header: 'الاستئذان' },
      { field: 'absence', header: 'التأخير الصباحي' },
      { field: 'quantity', header: 'المخالفات السلوكية' },
      { field: 'quantity', header: ' تسليم الكتب' }
    ];

  
  },
  methods:{ 
    openNew() {
      this.submitted = false;
      this.AddStudentDialog = true;
    },
    saveStudent(isFormValid) {
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
        console.log("hello");
        this.AddStudentDialog = false;
        this.submitted = false;
         this.successMsg = true;
        this.restform()

      });
},

uploadFile(e) {
  this.form.attached_id = e.target.files[0].name;
   this.attachment=e.target.files[0]

},

restform() {    
        this.form.name= null,
    this.form.attached_id = null
        }
  },

  mounted() {
    this.query = { id: this.id };

    // this.classesService.index(this.query).then(data => this.classes = data);

    this.classesService.index(this.query).then(({ data }) => {
      if (data.code == 200) {
        this.class = data.data.Classes[0];
      }
    });
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


</style>
