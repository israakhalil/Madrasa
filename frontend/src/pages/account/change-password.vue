<template>
  <div class="grid">
    <div class="col-12 md:col-12">
      <div class="card p-fluid">
        <div class="col-10 md:col-10 mr-10 mb-4">
                <span class="font-bold text-xl" style="color: var(--primary-color)">
                 تغيير كلمة المرور
                </span>
        </div>

        <form @submit.prevent="submitForm()">
          <div class="col-12 md:col-12">
            <div class="field">
              <label for="old_password">كلمة المرور القديمة</label>
              <InputText id="old_password" type="password" v-model="old_password" />
            </div>

            <div class="field">
              <label for="password">كلمة المرور الجديدة</label>
              <InputText id="password" type="password" v-model="password" />
            </div>

            <div class="field">
              <label for="password_confirmation">تاكيد كلمة المرور</label>
              <InputText id="password_confirmation" type="password" v-model="password_confirmation" />
            </div>

          </div>
          <div class="flex">
            <Button
                :label="$t('actions.save')"
                type="submit"
                class="flex-auto mt-4"
            />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import usersService from "../../services/usersService";

export default {
  data() {
    return {
      old_password: null,
      password: null,
      password_confirmation: null,
      service: null,
    };
  },

  mounted() {
    this.service = new usersService();
  },
  methods: {
    submitForm() {
      this.service.changePassword({
        'old_password' : this.old_password,
        'password' : this.password,
        'password_confirmation' : this.password_confirmation,
      }).then(({ data }) => {
        if (data.code ==200) { 
          globalApp.success(data.msg);

        }
        else {
          if (data.code == 422) { 
            globalApp.error(data.msg);

        }
          
        }

      });;

      this.old_password = this.password = this.password_confirmation =null;
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
