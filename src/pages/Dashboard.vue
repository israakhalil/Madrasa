<template>
    <div class="grid">
        <div class="col-12 md:col-12">
            <div class="card p-fluid">

                <Message severity="success" :closable="true" 
                class="bold font-semibold"> مرحبا بكم في نظام المدرسين 
            </Message>
            </div>
        </div>
    </div>
</template>

<script>


  
export default {
    data() {
        return {};
    },
mounted() {
  // let permissions = this.$store.getters['settings/getPermissions'];
  // console.log(permissions);
}

};
</script>