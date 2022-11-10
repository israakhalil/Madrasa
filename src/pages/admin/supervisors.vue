<template>
    <div class="grid">
      <div class="col-12 md:col-12">
        <div class="card">
          <div class="grid my-2 font-bold mr-10">
              <div class="col-8 md:col-8 py-4">
                <span class="font-bold text-xl">قائمة المشرفين </span>
             
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
                          <Button label="إضافة مشرف"   icon="pi pi-plus" class="p-button-outlined " @click="openNew"/>
  
                      </div>
                    
              </div>
              <div>
  
              </div>
              </div>
          </div>
  
          <div>
  
  
            <DataTable :value="users" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
              <Column field="id" header="الرقم ">
                <template #body="slotProps">
                          {{slotProps.index+1}}
                      </template>
                      </Column>

              <Column field="name" header="اسم المشرف">
                
              </Column>
              <Column field="username" header="اسم المستخدم">
                
              </Column>
              <Column field="id_number" header="رقم الهوية">
                
              </Column>
              <Column field="email" header="الايميل">
                
              </Column>
              <Column field="school_name" header="اسم المدرسة">
                
              </Column>
              
              <Column fheader="  الاجراءات" style="max-width:8rem">
            <template #body="slotProps">
                <!-- <Button icon="pi pi-download" class="p-button-rounded p-button-help ml-2" /> -->
                <Button icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
                <Button icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
            </template>

        </Column>
              <template #footer>
                  في المجمل هناك  {{users ? users.length : 0 }} مدرسة.
              </template>
          </DataTable>
          </div>
        </div>
  
        <Dialog
            v-model:visible="AddUserDialog"
            :style="{ width: '500px' }"
            header="اضافة مشرف مدرسة "
            :modal="true"
            class="p-fluid font-bold text-lg">
  
            <div class="field">
              <label for="name"> اسم المشرف</label>
              <InputText
                id="name"
                v-model.trim="form.name"
                required="true"
                autofocus
                :class="{ 'p-error':v$.form.name.$invalid && submitted }"/>
                <small class="p-error" v-if="v$.form.name.$invalid && submitted">يرجى ادخال اسم المشرف </small>
            </div>
            <div class="field">
              <label for="id_number"> رقم الهوية </label>
              <InputText
                id="id_number"
                v-model.trim="form.id_number"
                :class="{ 'p-error':v$.form.id_number.$invalid && submitted }"/>
                <small class="p-error" v-if="v$.form.id_number.$invalid && submitted">يرجى ادخال رقم الهوية </small>
            </div>
            <div class="field">
              <label for="school_id">المدرسة التابع لها </label>
              <Dropdown
              id="school_id"
              :filter=true
              v-model="form.school_id"
              :options=" schools"
              optionLabel="name"
              placeholder="اختر"
              option-value="id"
              :class="{ 'p-invalid':v$.form.school_id.$invalid && submitted }"
              />
              <small class="p-error" v-if="v$.form.school_id.$invalid && submitted">يرجى  اختبار المدرسة التابع لها  </small>
            </div>
            <div class="field">
              <label for="email"> ايميل المشرف  </label>
              <InputText
                id="email"
                v-model.trim="form.email"
                :class="{ 'p-error':v$.form.email.$invalid && submitted }"/>
                <small class="p-error" v-if="v$.form.email.$invalid && submitted">يرجى ادخال ايميل  </small>
            </div>
            
            <div class="field">
              <label for="password">كلمة السر   </label>
              <Password id="password" v-model="form.password"  class="w-full mb-3" 
              inputClass="w-full" inputStyle="padding:1rem 2rem 1rem 10rem;" 
              :class="{ 'p-error':v$.form.password.$invalid && submitted }"></Password>

              <!-- <InputText
                id="password"
                v-model.trim="form.password"
                :class="{ 'p-error':v$.form.password.$invalid && submitted }"/> -->
                <small class="p-error" v-if="v$.form.password.$invalid && submitted">يرجى ادخال كلمة السر  </small>
            </div>
          
            <div class="field">
              <Button label="حفظ" class="mt-5" type="submit" @click="save(!v$.$invalid)" />
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
  import UsersService from "@/services/usersService";
  import SchoolsService from "@/services/schoolsService";

  import { useVuelidate } from "@vuelidate/core";
  import {email, required, minLength} from "@vuelidate/validators";
  
  export default {
    setup () {
      return { v$: useVuelidate() }
    },
    props: ["id"],
    data() {
      return {
        form: { },
        users: [],
        schools:[],
        AddUserDialog: false,
        filter_name:null,
         filter: {},
          Msg: null,
         
          userService: null,
        successMsg: false,
        submitted: false,
        schoolsService: null,
        deleteconfirm:false
      };
    },
    validations() {
      return {
        form: {
              name: { required },  
              email: { email, required },
               password: { required, minLength: minLength(6) },
              id_number: {required},
          // password: { required },
          school_id:{ required },
              
        }
      }
    },
    created() {
      this.userService = new UsersService();
      this.schoolsService = new SchoolsService();

    },
  methods: {
    openNew() {
      this.restform()
      this.getSchools();
      this.submitted = false;
      this.AddUserDialog = true;
    },
    openEdit(data) {
      this.header = "تعديل مشرف"
      this.getSchools();
      this.form = { ...data };
      // console.log(this.form);
      this.AddUserDialog = true;
    },
    openDelete(data) {
      this.form = data;
      this.deleteconfirm = true;
      this.deleteMsg = "هل انت متاكد من الحذف ";
    },
    deleteObj() { 
            this.successMsg = false;
            this.userService.delete(this.form.id).then(({ data }) => {
                if (data.code == 200) {
                this.deleteconfirm = false;
                this.successMsg = true;
                this.Msg = data.msg;
                  this.getSupervisors();

            }
            });
            this.form = {};
      },
    save(isFormValid) {
      this.successMsg = false;
      this.submitted = true;
      if (!isFormValid) {
        return;
      }
      this.userService.store(this.form, this.form.id).then(({ data }) => {
        if (data.code == 200) {
          this.AddUserDialog = false;
          this.successMsg = true;
          this.Msg = data.msg;
          this.getSupervisors();
          this.restform()
        }
      });
    },

    restform() {
      this.form = {}
    },

    onFilter() {
      this.getSupervisors()
    },
    getSchools() {
      this.filter = { name: this.filter_name };

      this.schoolsService.schools(this.filter).then(({ data }) => {
        if (data.code == 200) {
          this.schools = data.data.Schools;

        }
      });
    },
    getSupervisors() {
      this.filter = { name: this.filter_name };

      this.userService.index(this.filter).then(({ data }) => {
        if (data.code == 200) {
          this.users = data.data.Users;

        }
      });

    },

  },
    mounted() {
      this.getSupervisors()
  
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

  .p-button:enabled:hover {
    background: #7C3AED;
    color: #ffffff;
    border-color: #7C3AED;
}
.p-dialog .p-dialog-footer button{
    width:100%
}
  
  
  </style>
  