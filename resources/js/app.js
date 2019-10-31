/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from "vue-router";
import VueHotKey from "v-hotkey";

import routes from "./routes.js";
import App from "./components/App.vue";

import NProgress from "nprogress";
import 'nprogress/nprogress.css';

axios.interceptors.request.use(function(config){
    // do something before request is send
    NProgress.start();
    return config;
},function(error){
    // do something with request error
    console.log(error)
    return Promise.reject(error);
});

// add a response interceptor
axios.interceptors.response.use(function(resp){
    // do something with response data
    NProgress.done();
    
    return resp;
},function(error){
    // do something with response error
    console.log(error);
    return Promise.reject(error);
});

$(document).ajaxComplete(function(event,request,setting){
    console.log(2);
    NProgress.done();
});

$(document).ajaxStart(function(event,request,setting){
    NProgress.start();
});

Vue.use(VueRouter);
Vue.use(VueHotKey);

const router = new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass:'active',
    routes:routes
});

new Vue(Vue.util.extend({router},App)).$mount("#app");