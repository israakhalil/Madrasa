<template>
  <div class="grid list_container" style="height: 87vh; padding:0rem;">
    <div class="col-12 md:col-12 re_quick" >
      <div class="card  list_container2">
        <div class="grid my-2 font-bold mr-10 ">
          <div class="col-6 md:col-6 py-4">
            <span class="font-bold text-xl">قائمة المراحل الدراسية </span>

          </div>
          <div class="col-6 md:col-6">
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
                <Button label="إضافة مرحلة"   icon="pi pi-plus" class="p-button-outlined " @click="openNew"/>

              </div>

            </div>
            <div>

            </div>
          </div>
        </div>

        <div>


          <DataTable :value="levels" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
            <Column field="id" header="الرقم ">
              <template #body="slotProps">
                {{slotProps.index+1}}
              </template>
            </Column>

            <Column field="name" header="اسم المرحلة">
            </Column>
            <Column fheader="  الاجراءات" style="max-width:8rem">
              <template #body="slotProps">
                <Button icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
                <Button icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
              </template>

            </Column>
            <template #footer>
              في المجمل هناك  {{levels ? levels.length : 0 }} مرحلة.
            </template>
          </DataTable>
        </div>
      </div>

      <Dialog
          v-model:visible="AddLevelsDialog"
          :style="{ width: '500px' }"
          :header=header
          :modal="true"
          class="p-fluid font-bold text-lg">

        <div class="field">
          <label for="name"> اسم المرحلة</label>
          <InputText
              id="name"
              v-model.trim="form.name"
              required="true"
              autofocus
              :class="{ 'p-error':v$.form.name.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.name.$invalid && submitted">يرجى ادخال اسم المرحلة </small>
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
import levelsService from "@/services/levelsService";

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
      levels: [],
      AddLevelsDialog: false,
      filter_name:null,
      filter: {},
      Msg: null,

      levelsService: null,
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
    this.levelsService = new levelsService();

  },
  methods:{
    openNew() {
      this.form={}
      this.header="اضافة مرحلة دراسية جديدة "
      this.submitted = false;
      this.AddLevelsDialog = true;
    },
    openEdit(data) {
      this.header="تعديل مرحلة دراسية"
      this.form = { ...data };
      this.AddLevelsDialog = true;
    },
    openDelete(data) {
      this.form = data;
      this.deleteconfirm = true;
      this.deleteMsg = "هل انت متاكد من الحذف ";
    },
    deleteObj() {
      this.successMsg = false;
      this.levelsService.delete(this.form.id).then(({ data }) => {
        if (data.code == 200) {
          this.deleteconfirm = false;
          this.successMsg = true;
          this.Msg = data.msg;
          this.getLevels();

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

      this.levelsService.store(this.form,this.form.id).then(({ data }) => {
        this.AddLevelsDialog = false;
        this.submitted = false;
        this.Msg = "تمت العملية بنجاح ";
        this.successMsg = true;
        this.getLevels();
        this.form = {};

      });
    },


    onFilter() {
      this.getLevels()
    },
    getLevels() {
      this.filter = { name: this.filter_name };

      this.levelsService.index(this.filter).then(({ data }) => {
        if (data.code == 200) {
          this.levels = data.data.Levels;

        }
      });
    }
  },

  mounted() {
    this.getLevels()

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
 /* .re_quick{
  overflow: auto;
  height: 80vh;
} */
</style>
