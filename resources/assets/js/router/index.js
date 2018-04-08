import Vue from 'vue'
import VueRouter from 'vue-router'


import LandingPage from '../views/Auth/LandingPage.vue'
import Home from '../views/Home/Home.vue'
import Profile from '../views/Home/Profile.vue'
import NotFound from '../views/NotFound.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: LandingPage },
        { path: '/home', component: Home },
        { path: '/not-found', component: NotFound },
        { path: '*', component: NotFound },
        {path: '/profile', component: Profile },
    ]
})

export default router