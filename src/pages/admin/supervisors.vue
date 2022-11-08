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
                <small class="p-error" v-if="v$.form.name.$invalid && submitted">يرجى ادخال اسم المدرسة </small>
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
              <label for="email"> ايميل المشرف  </label>
              <InputText
                id="email"
                v-model.trim="form.email"
                :class="{ 'p-error':v$.form.email.$invalid && submitted }"/>
                <small class="p-error" v-if="v$.form.email.$invalid && submitted">يرجى ادخال ايميل  </small>
            </div>
            
            <div class="field">
              <label for="password">كلمة السر   </label>
              <Password id="password1" v-model="form.password"  class="w-full mb-3" 
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
  
          <SuccessMsg :successMsg=successMsg  :Msg=Msg />
      </div>
    </div>
</template>
  
  <script>
  import UsersService from "@/services/usersService";

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
        users: [],
        AddUserDialog: false,
        filter_name:null,
         filter: {},
          Msg: null,
         
          userService: null,
        successMsg: false,
        submitted:false
      };
    },
    validations() {
      return {
        form: {
              name: { required },  
              email: { required },
              id_number: {required},
              password:{required}
              
        }
      }
    },
    created() {
      this.userService = new UsersService();
    
    },
    methods:{ 
        openNew() {
        this.restform()
        this.submitted = false;
        this.AddUserDialog = true;
        },
        openEdit(data) {
        this.header="تعديل مشرف"
        this.form = { ...data };  
        this.AddUserDialog = true;
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
    this.form={}
      },
  
        onFilter() {
            this.getSupervisors()
       },
       getSupervisors() {
        this.filter = { name: this.filter_name };
  
        this.userService.index(this.filter).then(({ data }) => {
          if (data.code == 200) {
              this.users = data.data.Users;

        }
      });
  }
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

  
  
  </style>
  