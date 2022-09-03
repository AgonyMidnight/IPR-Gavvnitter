import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Timeline from '@/views/pages/Timeline.vue'
import Registration from '@/views/pages/authorization/Registration.vue'
import store from '@/store'
import Profile from "@/views/pages/Profile.vue";
import UserPage from "@/views/pages/UserPage.vue";
import LikePage from "@/views/pages/LikePage.vue";
import CommentPage from "@/views/pages/CommentPage.vue";

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'home',
        component: () => import('../views/pages/Timeline.vue'),//Timeline,
        meta: {
            redirectIfNotLogin: true,
        },
    },
    {
        path: '/about',
        name: 'about',
        meta: {
            layout: 'full',
            redirectIfNotLogin: true,
        },
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../views/pages/authorization/Login.vue'),
        meta: {
            resource: 'Auth',
        },
    },
    {
        path: '/registration',
        name: 'registration',
        component: () => import('../views/pages/authorization/Registration.vue'),//Registration,
        meta: {
            //layout: 'full',
        },
    },
    {
        path: '/user/profile',
        name: 'user-profile',
        component: () => import('../views/pages/Profile.vue'), //Profile,
        meta: {
            redirectIfNotLogin: true,
        },
    },
    {
        path: '/user/:id',
        name: 'user-page',
        component: () => import('../views/pages/UserPage.vue'), //UserPage,
        meta: {
            redirectIfNotLogin: true,
        },
    },
    {
        path: '/user/like',
        name: 'user-like',
        component: () => import('../views/pages/LikePage.vue'), //LikePage,
        meta: {
            redirectIfNotLogin: true,
        },
    },
    {
        path: '/user/post',
        name: 'user-post',
        component: () =>  import('../views/pages/CommentPage.vue'),//CommentPage,
        meta: {
            redirectIfNotLogin: true,
        },
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        component: () => import('../views/pages/forgot-password/ForgotPassword.vue'),
        meta: {
            resource: 'Auth',
        },
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: () => import('../views/pages/forgot-password/ResetPassword.vue'),
        meta: {
            resource: 'Auth',
        },
    },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

router.beforeEach((route, redirect, next) => {
    let token: string | null = store.getters['user/getToken']
    if (route.meta.redirectIfNotLogin === true && !token) {
        next('login');
    }
    next();
});

router.afterEach((to, from) => {
    if (to.name === "user-like") store.commit('notification/setCountLikes', 0);
    if (to.name === 'user-post') store.commit('notification/setCountComments', 0);
})

export default router
