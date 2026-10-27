<template>
<!--   <div class="layout-menu-container">-->
        <TabMenu :model="model"></TabMenu>
<!--    </div>-->
</template>
 

<script>

export default {
    props: {
        model: Array,
    }, 
};
</script>
 