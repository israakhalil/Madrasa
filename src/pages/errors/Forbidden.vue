<template>
    <div class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="grid justify-content-center p-2 lg:p-0" style="min-width: 80%">
            <div
                class="col-12 xl:col-6"
                style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, rgba(233, 30, 99, 0.4) 10%, rgba(33, 150, 243, 0) 30%)"
            >
                <div
                    class="h-full w-full m-0 py-7 px-4"
                    style="border-radius: 53px; background: linear-gradient(180deg, var(--surface-50) 38.9%, var(--surface-0))"
                >
                    <div class="grid flex flex-column align-items-center">
                        <div class="col-12 xl:mt-0 text-center">
                            <!-- <img :src="this.siteLogo()" alt="Sakai logo" style="width: 100px; height: 100px" /> -->
                        </div>
                        <h3 class="font-bold text-5xl text-900 mb-2">ليس لديك صلاحية وصول لهذا العنصر</h3>
                        <!-- <img src="/layout/images/asset-error.svg" style="width: 80% !important" alt="Error" class="mt-5" width="80%" /> -->
                        <div class="col-12 mt-5 text-center">
                            <i class="pi pi-fw pi-arrow-right text-blue-500 mx-2" style="vertical-align: center"></i>
                            <router-link to="/" class="text-blue-500">{{ $t('go_home') }}</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


 <style scoped>
.min-h-screen {
    min-height: 98vh !important;
}
.min-w-screen {
    min-width: 98vw !important;
}
</style>