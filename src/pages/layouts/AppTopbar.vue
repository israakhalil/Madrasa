<template>
	<!-- <div class="layout-topbar">
		<router-link to="/" class="layout-topbar-logo text-black text-xl">
			<img alt="Logo" :src="topbarImage()" />
		
		</router-link>

<div class="flex justify-content-between">
	<span>مدرسة الاستقلال</span>
</div>
<div class="flex justify-content-center text-left">
	<ul class="layout-topbar-menu hidden lg:flex origin-top">
		<li>
                <Button
                    type="button"
                    aria-haspopup="true"
                    icon="pi pi-cog"
                    class="p-component layout-topbar-button p-button-icon-only pe"
                   
                />

            </li>
		</ul>
</div>
		
	</div> -->


	<div class="layout-topbar">
    <div class="layout-topbar-logo">
      <img alt="Logo" :src="this.schoolLogo()"/>
	  
    </div>
	<div class="layout-topbar-logo_text">
		<span> {{currentSchool.name}}</span>
	</div>


    <ul class="layout-topbar-menu hidden lg:flex origin-top">

	  <li>
				<button class="p-link layout-topbar-button">
					<i class="pi pi-cog"></i>
					<span>Settings</span>
				</button>
			</li>
</ul>
  </div>
</template>

<script>
export default {
	// props:{
	// 	showSideMenue:Boolean,
	// },
	data() { 
		return {
			currentSchool:{}
		}
	},
	mounted() {
		// this.$store.dispatch('settings/fetchSchool');
		this.currentSchool = this.$store.getters['settings/currentSchool'];
		// console.log(this.currentSchool);
	},
    methods: {
        // onMenuToggle(event) {
        //     this.$emit('menu-toggle', event);
        // },
		// onTopbarMenuToggle(event) {
        //     this.$emit('topbar-menu-toggle', event);
        // },
		topbarImage() {
			return this.$appState.darkTheme ? 'images/logo-white.svg' : 'images/logo-dark.svg';
		}
    },
	computed: {
		darkTheme() {
			return this.$appState.darkTheme;
		}
	}
}
</script>