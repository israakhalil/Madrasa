<template>
    <div class="grid">
      <div class="col-12 md:col-12">
        <div class="card">
          <div class="grid my-2 font-bold mr-10">
              <div class="col-8 md:col-8 py-4">
                <span class="font-bold text-xl">قائمة المدارس </span>
             
              </div>
              <div class="col-4 md:col-4">
                  <div class="grid">
                      <div class="col-8 md:col-8">
                          <span class="col-12 p-input-icon-right">
                              <i class="pi pi-search mr-3" />
                              <InputText type="text" 
                              v-model="filter_name" 
                              @input="onFilter"
                              placeholder="بحث ... " />
                          </span>
  
                       </div>
                      <div class="col-4 md:col-4 justify-content-right mt-2">
                          <Button label="إضافة مدرسة"   icon="pi pi-plus" class="p-button-outlined " @click="openNew"/>
  
                      </div>
                    
              </div>
              <div>
  
              </div>
              </div>
          </div>
  
          <div>
  
  
            <DataTable :value="schools" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
              <Column field="id" header="الرقم ">
                <template #body="slotProps">
                          {{slotProps.index+1}}
                      </template>
                      </Column>

              <Column field="name" header="اسم المدرسة">
                
              </Column>

              <Column header="logo" style="width: 15%;">
                     <template #body="slotProps">
                        <img :src=slotProps.data.link :alt="slotProps.data.image"  width="100" />
                    </template>
                </Column>
              <!-- <Column field="is_active" header="فعال "> -->
              <!-- </Column> -->
              <Column fheader="  الاجراءات" style="max-width:8rem">
            <template #body="slotProps">
                <!-- <Button icon="pi pi-download" class="p-button-rounded p-button-help ml-2" /> -->
                <Button icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
                <Button icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
            </template>

        </Column>
              <template #footer>
                  في المجمل هناك  {{schools ? schools.length : 0 }} مدرسة.
              </template>
          </DataTable>
          </div>
        </div>
  
        <Dialog
            v-model:visible="AddSchoolDialog"
            :style="{ width: '500px' }"
            :header=header
            :modal="true"
            class="p-fluid font-bold text-lg">
  
            <div class="field">
              <label for="name"> اسم المدرسة</label>
              <InputText
                id="name"
                v-model.trim="form.name"
                required="true"
                autofocus
                :class="{ 'p-error':v$.form.name.$invalid && submitted }"/>
                <small class="p-error" v-if="v$.form.name.$invalid && submitted">يرجى ادخال اسم المدرسة </small>
            </div>
            <div class="field">
              <label for="logo">شعار المدرسة  </label>
              <!-- <img v-if="form.id" :src=form.link  width="100" /> -->
              <div class="inputfile-box">
                <input
                  type="file"
                  accept="image/png, image/gif, image/jpeg, image/svg"
                  id="file"
                  class="inputfile"
                  @change="uploadFile"
                />
                <label for="file">
                  <span class="p-input-icon-left">
                    <i class="pi pi-upload" aria-hidden="true"></i>
                    <span id="file-name" class="file-box">{{form.logo}}</span>
                  </span>
                </label>
              </div>
                   
            </div>
  
            <div class="field">
              <Button label="حفظ" class="mt-5" type="submit" @click="saveSchool(!v$.$invalid)" />
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
                 <Button label="حذف"  class=" p-button-outlined mt-5"   @click="deleteObj" />
            </div>
            <div class="col-6 md:col-6">            
                 <Button label="الغاء"  class="p-button-outlined mt-5" @click="deleteconfirm = false"  />
            </div>
        </div>
            </template>

    </Dialog>

          <SuccessMsg :successMsg=successMsg  :Msg=Msg />

      </div>
    </div>
</template>
  
  <script>
  import SchoolsService from "@/services/schoolsService";

  import { useVuelidate } from "@vuelidate/core";
  import {required} from "@vuelidate/validators";
  
  export default {
    setup () {
      return { v$: useVuelidate() }
    },
    props: ["id"],
    data() {
      return {
        form: { },
        schools: [],
        AddSchoolDialog: false,
        filter_name:null,
         filter: {},
          Msg: null,
         
          schoolsService: null,
        successMsg: false,
        submitted:false,
        logo: null,
        header: null,
        deleteconfirm:null
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
      this.schoolsService = new SchoolsService();
    
    },
    methods:{ 
        openNew() {
          this.form={}
        this.header="اضافة مدرسة جديدة "
        this.submitted = false;
        this.AddSchoolDialog = true;
        },
        openEdit(data) {
        this.header="تعديل مدرسة"
        this.form = { ...data };  
        this.AddSchoolDialog = true;
    },
    openDelete(data) { 
        this.form = data;
        this.deleteconfirm = true;
        this.deleteMsg = "هل انت متاكد من الحذف ";
      },
      deleteObj() { 
            this.successMsg = false;
            this.schoolsService.delete(this.form.id).then(({ data }) => {
                if (data.code == 200) {
                this.deleteconfirm = false;
                this.successMsg = true;
                this.Msg = data.msg;
                  this.getSchools();

            }
            });
            this.form = {};
      },
        
      saveSchool(isFormValid) {
        this.successMsg = false;
        this.submitted = true;
        if (!isFormValid) {
          return;
        }
          const formData = new FormData()

          formData.append('logo', this.logo)
          formData.append('data', JSON.stringify(this.form))
            const config = { headers: { 'Content-Type': 'multipart/form-data' } }   
  
            this.schoolsService.store(formData,this.form.id).then(({ data }) => {
              this.AddSchoolDialog = false;
              this.submitted = false;
              this.Msg = "تمت إضافة المدرسة بنجاح ";
              this.successMsg = true;
              this.getSchools();
              this.form = {};
  
            });
      },
  
  
  uploadFile(e) {
    this.form.logo = e.target.files[0].name;
     this.logo=e.target.files[0]
  
  },

        onFilter() {
            this.getSchools()
       },
       getSchools() {
        this.filter = { name: this.filter_name };
  
        this.schoolsService.schools(this.filter).then(({ data }) => {
          if (data.code == 200) {
              this.schools = data.data.Schools;

        }
      });
  }
    },
  
    mounted() {
      this.getSchools()
  
    },
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

  .inputfile-box {
    position: relative;
  }
  
  .inputfile {
    display: none;
  }

.card {
  border-radius: 0%;
  /*padding: 0rem;*/
}
.grid {
   margin-left: 0rem;
   margin-right: 0rem;
}
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
  
  
  </style>
  