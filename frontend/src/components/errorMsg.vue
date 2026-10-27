<template>
  <Dialog
    id="errorMsg"
    v-model:visible="visible"
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
        <span> {{Msg}} </span>
      </div>
    </div>
  </Dialog>
</template>

<script>
export default {
  props: {
    errorMsg: Boolean,
    Msg: String
  },
  data() {
    return { visible: this.errorMsg };
  },
  watch: {
    errorMsg(value) {
      this.visible = value;
    }
  }
}
</script>
