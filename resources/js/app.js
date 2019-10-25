require('./bootstrap');

import VueRouter from "vue-router";
import routes from "./routes.js";
import App from "./components/App.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass:'active',
    routes:routes
});

new Vue(Vue.until.extend({router},App)).$mount("#app");