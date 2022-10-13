<template>
     <div class="card p-fluid">         

    </div>
</template>

<script>
export default {
}
</script>

<style lang="scss" scoped>
::v-deep(.custom-scrolltop) {
    width: 2rem;
    height: 2rem;
    border-radius: 4px;
    background-color: var(--primary-color);

    &:hover {
		background-color: var(--primary-color);
	}

    .p-scrolltop-icon {
        font-size: 1rem;
        color: var(--primary-color-text);
    }
}
</style>