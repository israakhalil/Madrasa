<template>
    
  <Dialog
    id="errorMsg"
    v-model:visible="errorMsg"
    :style="{ width: '450px' }"
    header=""
    :modal="true"
    class="font-bold text-3xl"
  >
    <div>
      <div class="justify-content-center text-center md:text-center">
        <i class="pi pi-times-circle" style="font-size: 5rem"></i>
      </div>

      <div class="justify-content-center text-center md:text-center">
        <span> يجب ادخال جميع الحقول </span>
      </div>
    </div>
  </Dialog>
</template>

<script>
export default {

    props: {
      errorMsg: String,  
} 
}
</script>