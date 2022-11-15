<template>
  <div class="grid">
    <div class="col-12 md:col-12">
      <div class="card p-fluid">

        <div class="col-10 md:col-10 mr-10 mb-4">
                <span class="font-bold text-xl" style="color: var(--primary-color)">
                البيانات الشخصية
                </span>
        </div>

<!--      </div>-->
<!--      <div class="card p-fluid">-->
        <form @submit.prevent="submitForm()">

          <div class="field">
            <label for="name"> الاسم </label>
            <InputText
                id="name"
                v-model.trim="user.name"
                :class="{ 'p-invalid':v$.user.name.$invalid && submitted }"/>
            <small class="p-error" v-if="v$.user.name.$invalid && submitted">يرجى  ادخال اسم  </small>

          </div >
          <div class="field">
            <label for="email"> الايميل </label>
            <InputText
                id="email"
                v-model.trim="user.email"
                :class="{ 'p-invalid':v$.user.name.$invalid && submitted }"/>
            <small class="p-error" v-if="v$.user.name.$invalid && submitted">يرجى  ادخال الايميل  </small>

          </div >

          <div class="flex">
            <Button
                label="تعديـــل"
                type="submit"
                class="mt-4"
            />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import usersService from "../../services/usersService";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
let service = new usersService();

export default {
  setup () {
    return { v$: useVuelidate() }
  },
  data() {
    return {
      user: {
        name: null,
        email: null,
      },

      submitted:false
    };
  },
  validations() {
    return {
      user: {
        name: { required },
        email: { required },
      }
    }
  },
  mounted() {
    this.user = this.$store.getters['settings/currentUser'];
  },
  methods: {
    submitForm() {
      service.updateProfile(this.user).then(({ data }) => {
        if (data.code ==200) { 
          globalApp.success(data.msg);

        }
        else {
          if (data.code == 422) { 
            globalApp.error(data.msg);

        }
          
        }

      });

    },
  },
};
</script>

<style scoped>
.grid {
  margin-left: 0rem;
  margin-right: 0rem;
}
</style>
