<template>
        <div class="grid justify-content-center"  style="margin-bottom: -30rem;">
            <div class="col-12 md:col-6" style=" padding-top: 210px; padding-bottom: 229px; margin-bottom: 0.6rem;">
                <div class="p-component font-bold ">
                    <div class="text-center mb-5">
                        <div class="text-3xl mb-4">أهلا بك مرة اخرى</div>
                        <span class="text-xl " style="color: var(--primary-color)">تسجيل الدخول</span>
                    </div>
                
                    <div class="w-full md:w-10 mx-auto">
                        <label for="username" class="block text-xl  mb-2">ايميل المستخدم</label>
                        <InputText id="username" v-model="email.val" type="text" class="w-full mb-3" style="padding:1rem;" />
                
                        <label for="password1" class="block text-xl mb-2">كلمة المرور</label>
                        <Password id="password1" v-model="password.val"  :toggleMask="true" class="w-full mb-3" inputClass="w-full" inputStyle="padding:1rem 2rem 1rem 10rem;"></Password>
                        
                        <Button label="تسجيل الدخول" class="w-full p-3 text-xl" @click="doLogin"></button>

                        <div class="flex align-items-center justify-content-center mt-3">
                            <span>هل نسيت كلمة المرور ؟ </span>
                            <router-link to="/forget" class="font-bolder no-underline  ml-1 mr-4 text-center cursor-pointer" style="color: var(--primary-color)">
                                استعادة كلمة المرور  </router-link>
                        </div>


                       
                    </div>
                </div>
            </div>
            <div class="col-12 md:col-6" style="background: var(--primary-color)"></div>
        </div> 


        
</template>

<script>
export default {
    data() {
        return {
          
            loading: false,
          email: {
                val: '',
            },
            password: {
                val: '',
            },
        }
    },
    methods: {
        doLogin() {
            this.loading = true;
            this.$store
                .dispatch('settings/login', {
                    email: this.email.val,
                    password: this.password.val,
                })
                .then(() => {
                    this.loading = false;
                });
        },
    },
    computed: {
        logoColor() {
             return 'white';
            // return 'dark';
        }
    }
}
</script>

<style scoped>
.pi-eye {
    transform:scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform:scale(1.6);
    margin-right: 1rem;
}
</style>