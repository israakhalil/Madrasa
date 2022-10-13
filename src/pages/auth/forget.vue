<template>
    <div class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="grid justify-content-center p-2 lg:p-0" style="min-width: 80%">
            <div
                class="col-12 xl:col-6 p-component font-bold"
                style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color), rgba(33, 150, 243, 0) 30%)"
            >
                <div
                    class="h-full w-full m-0 py-7 px-4"
                    style="border-radius: 53px; background: linear-gradient(180deg, var(--surface-50) 38.9%, var(--surface-0))"
                >
                    <div class="text-center mb-5">
                        <!-- <img :src="this.siteLogo()" alt="Image" height="50" class="mb-3" /> -->
                        <!-- <img src="white.svg" alt="Image" height="50" class="mb-3" /> -->

                        <div class="text-3xl font-medium mb-3">{{مدرسة  }}</div>
                        <span class="">{{ $t('auth.forget_password_hint') }}</span>
                    </div>

                    <div class="w-full md:w-10 mx-auto">
                        <form @submit.prevent="doLogin()">
                            <label for="email1" class="text-xl font-medium mb-2">{{ $t('user.username') }}</label>
                            <InputText
                                id="email1"
                                v-model="username.val"
                                type="text"
                                class="w-full mb-3"
                               
                                style="padding: 1rem"
                            />


                            <Button
                                :label="this.$t('auth.request_reset_password')"
                                class="w-full p-3 text-xl mt-3"
                                iconPos="right"
                                :loading="loading"
                                type="submit"
                            >
                            </Button>

                          <div class="flex align-items-center justify-content-center mt-3">
                            <router-link to="/login" class=" ml-2 text-left cursor-pointer" style="color: var(--primary-color)">
                              {{ $t('auth.back_to_login') }}
                            </router-link>
                          </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import UserService from '@/services/UserService';

export default {
    data() {
        return {
            service: null,
            loading: false,
            username: {
                val: '',
            },
            password: {
                val: '',
            },
        };
    },

    mounted() {
        // this.service = new UserService();
    },
    methods: {
        doLogin() {
            // this.loading = true;
            // this.$store
            //     .dispatch('settings/login', {
            //         username: this.username.val,
            //         password: this.password.val,
            //     })
            //     .then(() => {
            //         this.loading = false;
            //     });
        },
    },

    created() {
        // let page_title = document.getElementById('page_title');
        // page_title.innerText = this.$t('app_title');
    },
};
</script>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}

.min-h-screen {
    min-height: 98vh !important;
}
.min-w-screen {
    min-width: 98vw !important;
}
</style>