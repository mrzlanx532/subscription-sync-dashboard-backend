import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/views/Home.vue'
import Subscriptions from "@/views/Subscriptions.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/subscriptions',
        name: 'subscriptions',
        component: Subscriptions
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router