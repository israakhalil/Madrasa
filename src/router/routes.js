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
                        name:"grades",
                        component: () => import('../pages/panel/grades.vue'),
                       
                    },
                    {
                        path: '/records',
                        name:"records",
                        component: () => import('../pages/panel/records.vue'),
                        
                    },
                    {
                        path: '/adminstration',
                        name:"adminstration",
                        component: () => import('../pages/panel/administrators.vue'),
                    },
                    {
                        path: '/certificates',
                        name:"certificates",
                        component: () => import('../pages/panel/certificates.vue'),
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
            // {
            //     path: '/student',
            //     component: () => import('../pages/student/layout.vue'),
            //     children: [
            //         {
            //             path: `:id/profile`,
            //             name: "student-index",
            //             props:true,
            //             component: () => import('../pages/student/index.vue'),
            //         }]
            // },
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