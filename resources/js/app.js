/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue/dist/vue';
import App from './Layouts/AppLayout.vue';
import AppNav from './Layouts/AppNav.vue';

import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import {
    routes
} from './routes';
import swal from 'sweetalert'
import Permissions from './mixins/Permissions.vue';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.Vue = Vue
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

Vue.mixin(Permissions);

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');



const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
const app_nav = new Vue({
    el: '#app_nav',
    router: router,
    render: h => h(AppNav),
});