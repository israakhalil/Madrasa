<template>
    <div :class="containerClass" @click="onWrapperClick">
        <AppTopBar @menu-toggle="onMenuToggle" :showSideMenu="showSideMenu" />

        <!-- <div class="layout-sidebar" @click="onSidebarClick" v-if="showSideMenu">
            <AppMenu :model="menu" @menuitem-click="onMenuItemClick" />
        </div> -->

        <div class="layout-main-container">
            <AppTopMenu :model="menu"/>

            <div class="layout-main" style="padding-top: 55px;">
                <router-view />
            </div>
            <!-- <AppFooter /> -->
        </div>

        <transition name="layout-mask">
            <div class="layout-mask p-component-overlay" v-if="mobileMenuActive"></div>
        </transition>

        <ConfirmDialog></ConfirmDialog>
    </div>
</template>

<script>
import '@/assets/styles/layout.scss';
import authorize from '@/mixins/authorize';

import AppTopBar from './AppTopbar.vue';
import AppTopMenu from './AppTopMenu.vue';
import { reactive } from 'vue';
import '@/primevue';

globalApp.app.config.globalProperties.$appState = reactive({ theme: 'lara-light-purple', darkTheme: false });

export default {
    data() {
        return {
            layoutMode: 'overlay',
            staticMenuInactive: true,
            overlayMenuActive: false,
            mobileMenuActive: false,
            showSideMenu: false,
            menu : [
                {
                   label:'المراحل',
                   icon:'pi pi-fw pi-sitemap',
                   to: '/grades',
                  visible: () => (authorize.methods.can('GRADE_VIEW_ALL'))
                 },
				// {
				// 	label:'السجلات',
        //             icon: 'pi pi-fw pi-book',
        //             to: '/records',
        //   visible: () => (authorize.methods.can('RECORDS_VIEW_ALL'))
        //
        // },
				{
					label:'الادرايين',
                    icon: 'pi pi-fw pi-users',
                    to:'/administrators',
          visible: () => (authorize.methods.can('ADMINISTRATOR_VIEW_ALL'))

        },
          // {
          //     label:'الشهادات',
          //     icon: 'pi pi-fw pi-money-bill',
          //     to:'/certificates',
          //     visible: () => (authorize.methods.can('GRADES_VIEW_ALL'))
          // },
              {
                label:'المراحل الدراسية',
                icon: 'pi pi-fw pi-money-bill',
                to:'/levels',
                visible: () => (authorize.methods.can('LEVEL_VIEW_ALL'))

              },
          {
               label:' المدارس',
              icon: 'pi pi-fw pi-money-bill',
              to:'/schools',
              visible: () => (authorize.methods.can('SCHOOL_VIEW_ALL'))

          },
                {
				          	label:' المشرفين',
                    icon: 'pi pi-fw pi-money-bill',
                    to:'/supervisors',
                    visible: () => (authorize.methods.can('SUPERVISOR_VIEW_ALL'))

                }
            ],
         
        };
    },

    watch: {
        $route() {
            this.menuActive = false;
        },
    },
    created() { },
    mounted() { 

    },
    methods: {
        onWrapperClick() {
            if (!this.menuClick) {
                this.overlayMenuActive = false;
                this.mobileMenuActive = false;
            }

            this.menuClick = false;
        },
        onMenuToggle() {
            this.menuClick = true;
            if (this.isDesktop()) {
                if (this.layoutMode === 'overlay') {
                    if (this.mobileMenuActive === true) {
                        this.overlayMenuActive = true;
                    }

                    this.overlayMenuActive = !this.overlayMenuActive;
                    this.mobileMenuActive = false;
                } else if (this.layoutMode === 'static') {
                    this.staticMenuInactive = !this.staticMenuInactive;
                }
            } else {
                this.mobileMenuActive = !this.mobileMenuActive;
            }

            event.preventDefault();
        },
        onSidebarClick() {
            this.menuClick = true;
        },
        onMenuItemClick(event) {
            if (event.item && !event.item.items) {
                this.overlayMenuActive = false;
                this.mobileMenuActive = false;
            }
        },
        onLayoutChange(layoutMode) {
            this.layoutMode = layoutMode;
        },
        addClass(element, className) {
            if (element.classList) element.classList.add(className);
            else element.className += ' ' + className;
        },
        removeClass(element, className) {
            if (element.classList) element.classList.remove(className);
            else element.className = element.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
        },
        isDesktop() {
            return window.innerWidth >= 992;
        },
        isSidebarVisible() {
            if (this.isDesktop()) {
                if (this.layoutMode === 'static') return !this.staticMenuInactive;
                else if (this.layoutMode === 'overlay') return this.overlayMenuActive;
            }

            return true;
        },
    },

    computed: {
        containerClass() {
            return [
                'layout-wrapper',
                {
                    'layout-overlay': this.layoutMode === 'overlay',
                    'layout-static': this.layoutMode === 'static',
                    'layout-static-sidebar-inactive': this.staticMenuInactive && this.layoutMode === 'static',
                    'layout-overlay-sidebar-active': this.overlayMenuActive && this.layoutMode === 'overlay',
                    'layout-mobile-sidebar-active': this.mobileMenuActive,
                    'p-input-filled': this.$primevue.config.inputStyle === 'filled',
                    'p-ripple-disabled': this.$primevue.config.ripple === false,
                    'layout-theme-light': this.$appState.theme.startsWith('saga'),
                },
            ];
        },
        logo() {
            return this.$appState.darkTheme ? 'images/logo-white.svg' : 'images/logo.svg';
        },
    },
    beforeUpdate() {
        if (this.mobileMenuActive) this.addClass(document.body, 'body-overflow-hidden');
        else this.removeClass(document.body, 'body-overflow-hidden');
    },
    components: {
        AppTopBar: AppTopBar,
        // AppMenu: AppMenu,
        AppTopMenu: AppTopMenu,
        // AppFooter: AppFooter,
    },
};
</script>

<style lang="scss">
@import '@/App.scss';
</style>



 <style lang="scss" scoped>
::v-deep(.p-paginator) {
    .p-paginator-current {
        margin-left: auto;
    }
}

::v-deep(.p-progressbar) {
    height: 0.5rem;
    background-color: #d8dadc;

    .p-progressbar-value {
        background-color: #607d8b;
    }
}

::v-deep(.p-datepicker) {
    min-width: 25rem;

    td {
        font-weight: 400;
    }
}

::v-deep(.p-datatable.p-datatable-customers) {
    .p-datatable-header {
        padding: 1rem;
        text-align: left;
        font-size: 1.5rem;
    }

    .p-paginator {
        padding: 1rem;
    }

    .p-datatable-thead > tr > th {
        text-align: left;
    }

    .p-datatable-tbody > tr > td {
        cursor: auto;
    }

    .p-dropdown-label:not(.p-placeholder) {
        text-transform: uppercase;
    }
}
</style>

