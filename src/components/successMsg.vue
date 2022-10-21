
<template>
   <Dialog
id="successMsg"
v-model:visible="successMsg"
:style="{ width: '450px' }"
header=""
:modal="true"
class="font-bold text-3xl"
>
<div>
  <div class="justify-content-center text-center md:text-center">
    <i class="pi pi-check-circle" style="font-size: 5rem"></i>
  </div>

  <div class="justify-content-center text-center md:text-center">
    <span>تمت الاضافة بنجاح </span>
  </div>
</div>
</Dialog> 
</template>

<script>
export default {

    props: {
        successMsg: String,  
} 
}
</script>
