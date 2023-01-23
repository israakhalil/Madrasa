<template>
<div class="layout-topbar">


<div class="col-12 md:col-12">
    <div class="grid">
        <div class="col-3 md:col-1 flex  justify-content-center" >
          <div class="layout-topbar-logo"> 
              <span> الشعار</span>
           </div> 
        </div>
        <div class="col-8 md:col-10 flex  justify-content-center" >
          <div class="layout-topbar-logo flex  justify-content-center">
            <span> {{currentSchool.name}} - {{ currentUser.name}}</span>
          </div>  
        </div>
        <div class="col-1 md:col-1 ">
          <button class="p-link layout-topbar-button" @click="toggleMenu" aria-haspopup="true" aria-controls="overlay_menu">
            <i class="pi pi-cog"></i>
          </button>
          <Menu id="overlay_menu" ref="menu" :model="drop_down_items" :popup="true" />
        </div>
    </div>
</div>
</div>
<!-- <div class="layout-topbar">

    <div class="layout-topbar-logo_text">
		<span> الشعار</span>
	</div>
	<div class="layout-topbar-logo_text">
		<span> {{currentSchool.name}} - {{ currentUser.name}}</span>
	</div>

    <ul class="layout-topbar-menu hidden lg:flex origin-top layout-topbar-logo_text">

	  <li>
				<button class="p-link layout-topbar-button" @click="toggleMenu" aria-haspopup="true" aria-controls="overlay_menu">
					<i class="pi pi-cog"></i>

				</button>
      <Menu id="overlay_menu" ref="menu" :model="drop_down_items" :popup="true" />

    </li>
</ul>
  </div> -->
<!-- <div class="layout-topbar">
  <div class="router-link-active layout-topbar-logo">

    <span class="layout-topbar-logo_text"> الشعار</span>
  </div>
	<div class="layout-topbar-logo flex  justify-content-center">
		<span> {{currentSchool.name}} - {{ currentUser.name}}</span>
	</div>

<div class="layout-topbar-menu_">
  <button class="p-link layout-topbar-button" @click="toggleMenu" aria-haspopup="true" aria-controls="overlay_menu">
    <i class="pi pi-cog"></i>
  </button>
  <Menu id="overlay_menu" ref="menu" :model="drop_down_items" :popup="true" />
  </div>
</div> -->

</template>

<script>
export default {
	// props:{
	// 	showSideMenue:Boolean,
	// },
	data() { 
		return {
			currentSchool:{},
      currentUser:{},
      drop_down_items: [
        {
          label: "الصفحة الشخصية",
          icon: 'pi pi-user',
          to: {name: 'user-profile'},
        },
        {
          label: "تغيير كلمة السر",
          icon: 'pi pi-unlock',
          to: {name: 'user-change-password'},
        },
        {
          label: " تسجيل خروج",
          icon: 'pi pi-sign-out',
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
    this.currentUser = this.$store.getters['settings/currentUser'];
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


.p-menu .p-menuitem-link .p-menuitem-icon {

    padding-left: 5%;}
</style>