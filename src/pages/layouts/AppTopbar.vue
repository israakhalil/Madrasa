<template>
	<div class="layout-topbar">
    <div class="layout-topbar-logo">
      <img alt="Logo" :src="this.schoolLogo()"/>
	  
    </div>
	<div class="layout-topbar-logo_text">
		<span> {{currentSchool.name}}</span>
	</div>
<!--    <button class="p-link layout-topbar-button">-->
<!--      <i class="pi pi-cog"></i>-->
<!--      <span>Settings</span>-->
<!--    </button>-->

    <ul class="layout-topbar-menu hidden lg:flex origin-top">

	  <li>
<!--      <Button-->
<!--          type="button"-->
<!--          @click="toggleMenu"-->
<!--          aria-haspopup="true"-->
<!--          icon="pi pi-cog"-->
<!--          class="button"-->

<!--      />-->
				<button class="p-link layout-topbar-button" @click="toggleMenu" aria-haspopup="true" aria-controls="overlay_menu">
					<i class="pi pi-cog"></i>

				</button>
      <Menu id="overlay_menu" ref="menu" :model="drop_down_items" :popup="true" />

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
			currentSchool:{},
      drop_down_items: [
        // {
        //   label: "الصفحة الشخصية",
        //   icon: 'pi pi-user',
        //   to: {name: 'user-profile'},
        // },
        // {
        //   label: "تغيير كلمة السر",
        //   icon: 'pi pi-unlock',
        //   // to: {name: 'user-change-password'},
        // },
        {
          label: " تسجيل خروج",
          icon: 'pi pi-unlock',
          command: () => {
            this.$store.dispatch('settings/logout');
          },
        },
      ],
		}
	},
	mounted() {
		// this.$store.dispatch('settings/fetchSchool');
		this.currentSchool = this.$store.getters['settings/currentSchool'];
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
		},
      toggleMenu(event) {
        console.log("hi")
        this.$refs.menu.toggle(event);
      },
    },
	computed: {
		darkTheme() {
			return this.$appState.darkTheme;
		}
	}
}
</script>

<style scoped>
.p-menuitem-icon{
  padding-left: 10px;
}
</style>