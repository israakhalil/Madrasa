<template>
  <div class="grid">
    <div class="col-12 md:col-12">
      <div class="card">
        <div class="grid my-2 font-bold mr-10">
          <div class="col-8 md:col-8 py-4">
            <span class="font-bold text-xl">قائمة الاداريين </span>

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
                <Button label="إضافة اداري"   icon="pi pi-plus" class="p-button-outlined " @click="openNew"/>

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

            <Column field="name" header="اسم الاداري">

            </Column>
            <Column field="email" header="الايميل">

            </Column>
            <Column field="classes_name" header=" الصفوف المتاحة" style="width: 35%;">
              <template #body="slotProps">
                <span v-for="element in slotProps.data.classes" class="item">
                  <span>{{ element.name  }} - {{element.level_name}}</span>
                </span>
              </template>

            </Column>
            <Column field="permissions_name" header="الصلاحيات المتاحة" style="width: 35%;">
              <template #body="slotProps">
                <span v-for="element in slotProps.data.permissions" class="item">
                  <span>{{ element.name  }} </span>
                </span>
              </template>

            </Column>

            <Column fheader="  الاجراءات" style="max-width:8rem">
              <template #body="slotProps">
                <Button icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
                <Button icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
              </template>

            </Column>
            <template #footer>
              في المجمل هناك  {{users ? users.length : 0 }} اداري.
            </template>
          </DataTable>
        </div>
      </div>

      <Dialog
          v-model:visible="AddUserDialog"
          :style="{ width: '500px' }"
          :header=header
          :modal="true"
          class="p-fluid font-bold text-lg">

        <div class="field">
          <label for="name"> اسم الاداري</label>
          <InputText
              id="name"
              v-model.trim="form.name"
              required="true"
              autofocus
              :class="{ 'p-error':v$.form.name.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.name.$invalid && submitted">يرجى ادخال اسم الاداري </small>
        </div>
        <div class="field">
          <label for="class_id">الصفوف المتاحة للاداري  </label>
<!--          <MultiSelect v-model="form.classesIds" :options="classes" optionLabel="full_class_name"-->
<!--                       placeholder="اختر"-->
<!--                       option-value="id" />-->

          <MultiSelect v-model="form.classesIds" :options="levels"
                       optionLabel="name" optionGroupLabel="name" option-value="id" optionGroupChildren="classes">
          </MultiSelect>
          <small class="p-error" v-if="v$.form.classesIds.$invalid && submitted">يرجى  اختيار الصفوف </small>
        </div>
        <div class="field">
            <label for="permissions" class="mb-3"> صلاحيات الاداري</label>
            <MultiSelect v-model="form.permissionIds" :options="permissions" option-value="id" optionLabel="name" />
            <small class="p-error" v-if="v$.form.permissionIds.$invalid && submitted">يرجى اختيار الصلاحيات   </small>

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
      <ErrorMsg :errorMsg=errorMsg :Msg=Msg />
    </div>
  </div>
</template>

<script>
import UsersService from "@/services/usersService";
import LevelsService from "@/services/levelsService";
import PermissionsService from "@/services/permissionsService";


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
      levels: [],
      permissions:[],
      AddUserDialog: false,
      filter_name:null,
      filter: {},
      Msg: null,

      userService: null,
      successMsg: false,
      errorMsg:false,
      submitted: false,
      levelsService: null,
      permissionsService:null,
      deleteconfirm:false,
      classes_name:null,
      header: null,
      permissionIds: [],
      classesIds:[]
    };
  },
  validations() {
    return {
      form: {
        name: { required },
        email: { email, required },
        password: { required, minLength: minLength(6) },
        classesIds: { required },
        permissionIds:{required}

      }
    }
  },
  created() {
    this.userService = new UsersService();
    this.levelsService = new LevelsService();
    this.permissionsService = new PermissionsService();

  },
  methods: {
    openNew() {
      this.header="اضافة اداري"
      this.form = {}
      this.getClasses();
      this.getPermissions();
      this.submitted = false;
      this.AddUserDialog = true;
    },
    openEdit(data) {
      this.header = "تعديل اداري"
      this.getClasses();
      this.getPermissions();
      this.form = { ...data };
      this.form.classesIds = this.form.classesIds.map(({ id }) => id);
      this.form.permissionIds = this.form.permissionIds.map(({ id }) => id);
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
          this.getAdministrator();
        }
      });
      this.form = {};
    },
    save(isFormValid) {
      this.successMsg = false;
      this.submitted = true;
      this.errorMsg=false;
      if (!isFormValid) {
        return;
      }
      this.form.role_id=3
      this.userService.store_administrator(this.form, this.form.id).then(({ data }) => {
        if (data.code == 200) {
          this.AddUserDialog = false;
          this.successMsg = true;
          this.Msg = data.msg;
          this.getAdministrator();
          this.restform()
        }
        else if(data.code == 501){
          this.errorMsg = true;
          this.Msg = data.msg;
        }
        else if(data.code == 502){
          this.errorMsg = true;
          this.Msg = data.msg;
        }
        else{
          this.errorMsg = true;
          this.Msg = "هناك خطأ";
        }
      });
    },

    restform() {
      this.form = {}
    },

    onFilter() {
      this.getAdministrator()
    },
    getClasses() {
      this.levelsService.grouped().then(({ data }) => {
        this.levels = data.data.Classes;
      });
    },
    getPermissions() {
      this.permissionsService.index().then(({ data }) => {
        this.permissions = data.data.Permissions;
      });
    },
    getAdministrator() {
      this.filter = { name: this.filter_name };

      this.userService.administrators(this.filter).then(({ data }) => {
        if (data.code == 200) {
          this.users = data.data.Users;
        }
      });

    },

  },
  mounted() {
    this.getAdministrator()

  },
};
</script>

<style scoped>
.item + .item:before {
  content: ", ";
}
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
