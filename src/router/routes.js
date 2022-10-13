const routes = [

    {
        path: '/',
        component: () => import('../pages/layouts/DashboardLayout.vue'),
        redirect: "/grades",
        children: [
            // {
            //     path: '/home',
            //     name:"home",
            //     component: () => import('../pages/Dashboard.vue'),
               
            // },
            {
                path: '/grades',
                name:"grades",
                component: () => import('../pages/panel/grades.vue'),
               
            },
            {
                path: 'records',
                name:"records",
                component: () => import('../pages/panel/records.vue'),
                
            },
            {
                path: 'adminstration',
                name:"adminstration",
                component: () => import('../pages/panel/administrators.vue'),
            },
            {
                path: 'certificates',
                name:"certificates",
                component: () => import('../pages/panel/certificates.vue'),
            },
            // {
            //     path: '/login',
            //     name:"login",
            //     component: () => import('../pages/auth/login.vue'),
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