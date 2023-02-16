<template>
  <div class="grid">
    <div class="col-12 md:col-12 list_container re_quick" >
    <div class="card list_container2">
      <div class="grid p-fluid mt-5 font-bold mr-5">
        <AbsenceTypes />
        </div>
        <div class="grid p-fluid mt-5 font-bold mr-5">
          <violationDegrees/>
        </div>
        <div class="grid p-fluid mt-5 font-bold mr-5">
          <violationsProcedures/>
        </div>

    </div>
      

</div>
  </div>


</template>

<script>
import AbsenceTypes from "./partial/AbsenceTypes.vue";
import violationDegrees from "./partial/violationDegrees.vue";
import violationsProcedures from "./partial/violationsProcedures.vue";
export default {
   data() {
       return {};
  },
  components: { AbsenceTypes,violationDegrees, violationsProcedures},

    mounted() {
   },
   methods: {},

};
</script>
<style scoped>
.card {
  border-radius: 0%;
}
.grid {
  margin-left: -0.035rem;
}
.grid {
  margin-left: 0rem;
  margin-right: 0rem;
}
::-webkit-scrollbar {
    width: 14px !important;

  }
</style>