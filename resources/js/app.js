/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// import 'bulma-start/css/main.css';
import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import Login from './components/Login';
import Home from './components/Home';
import Board from './components/Board'
import SelectedBoard from './components/SelectedBoard'
import Register from './components/Register'
//Authentications libraries
import VueAuth from '@websanova/vue-auth';
import VueAuthAuth from '@websanova/vue-auth/drivers/auth/bearer.js';
import VueAuthHttp from '@websanova/vue-auth/drivers/http/axios.1.x.js';
import VueAuthRouter from '@websanova/vue-auth/drivers/router/vue-router.2.x.js';
import App from './components/App'
import VueCookie from 'vue-cookie';




require('./bootstrap');

window.Vue = require('vue');
window.axios = axios;
// window.token = localStorage.getItem('token');
window.Event = new Vue;

Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(VueCookie)

Vue.directive('focus', {
    inserted: function(el) {
        el.focus();
    }
});


const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/',
            name: 'root',
            component: Home,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                auth: false
            }
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                auth: false
            }
        },
        {
            path: '/boards',
            name: 'boards',
            component: Board,
            meta: {
                auth: true
            }
        },
        {
            path: '/boards/:id',
            name: 'SelectedBoard',
            component: SelectedBoard,
            meta: {
                auth: true
            }
        }
    ]
})

Vue.router = router

Vue.use(VueAuth, {
    auth: VueAuthAuth,
    http: VueAuthHttp,
    router: VueAuthRouter,
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('home', require('./components/Home.vue').default);

// Vue.component('testcomponent', {
//     template: '<h1>Hello World</h1>',
//     data: function() {
//         return {

//         }
//     },
//     methods: {

//     }
// });

axios.defaults.baseURL = 'http://localhost:8000/api';


// console.log(token);


const app = new Vue({
    data: {
        boards: ''
    },
    components: {
        App
    },
    template: '<App/>',
    el: '#app',
    router,
    // methods: {
    //     logoutUser() {
    //         console.log('loggin out user')
    //         this.$auth.logout({
    //             success: function(resp) {
    //                 console.log('successfully log out user')
    //             },
    //             error: function(resp) {
    //                 console.log(resp)
    //             }
    //         });
    //     }
    // },
})