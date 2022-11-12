const routes = [

    {
        path: '/',
        component: () => import('../pages/layouts/DashboardLayout.vue'),
        redirect: '/home',
        children: [
            {
                path: '/home',
                name:"home",
                component: () => import('../pages/Dashboard.vue'),

            },
            {
                path: '/panel',
                component: () => import('../pages/panel/layout.vue'),
                children: [
                    {
                        path: '/grades',
                        name:"grades-index",
                        component: () => import('../pages/panel/grades.vue'),
                       
                    },
                    {
                        path: '/records',
                        name:"records-index",
                        component: () => import('../pages/panel/records.vue'),
                        
                    },
                    {
                        path: '/administrators',
                        name:"administrators-index",
                        component: () => import('../pages/panel/administrators.vue'),
                    },
                    {
                        path: '/certificates',
                        name:"certificates-index",
                        component: () => import('../pages/panel/certificates.vue'),
                    },
                    {
                        path: '/levels',
                        name:"levels-index",
                        component: () => import('../pages/panel/levels.vue'),
                    },
                 
                ]
            },

            {
                path: '/class',
                component: () => import('../pages/class/layout.vue'),
                children: [
                    {
                        path: `:id/all`,
                        name: "class-all",
                        props:true,
                        component: () => import('../pages/class/index.vue'),
                    },
                    {
                        path: `:class_id/student/:id/profile`,
                        name: "student-index",
                        props:true,
                        component: () => import('../pages/class/profile.vue'),
                    }
                ]
            },
            {
                path: '/quick',
                component: () => import('../pages/quick/layout.vue'),
                children: [
                    {
                        path: `:type/quick`,
                        name: "quick-index",
                        props:true,
                        component: () => import('../pages/quick/index.vue'),
                    }
                ]
                   
            },
            {
                path: '/admin',
                component: () => import('../pages/admin/layout.vue'),
                children: [
                    {
                        path: '/schools',
                        name:"schools-index",
                        component: () => import('../pages/admin/schools.vue'),
                       
                    },
                    {
                        path: '/supervisors',
                        name:"supervisors-index",
                        component: () => import('../pages/admin/supervisors.vue'),
                       
                    },
                ]
            },
            {
                path: '/account',
                component: () => import('../pages/account/layout.vue'),
                children:[
            {
                name: "user-profile",
                path: 'profile',
                component: () => import('../pages/account/profile.vue'),
            },

            {
                name: 'user-change-password',
                path: 'change-password',
                component: () => import('../pages/account/change-password.vue'),
            },]
            }
        ]    
    },
    
    {
        path: '/auth',
        component: () => import('../pages/auth/index.vue'),
        children: [
            {
                path: '/login',
                name:"login",
                component: () => import('../pages/auth/login.vue'),
            },
            {
                path: '/forget',
                name: "forget",
                component: () => import('../pages/auth/forget.vue'),
            },
        ]
    },
    {
        path: "/",
        component: () => import('../pages/errors/index.vue'),
        children: [
            {
                path: "404",
                name: "404",
                component: () => import("../pages/errors/Error.vue")
            },
            {
                path: "403",
                name: "403",
                component: () => import("../pages/errors/Forbidden.vue")
            }
        ]
    },

    {
        path: "/:pathMatch(.*)*",
        redirect: "/404"
    },

   
];


export default routes;