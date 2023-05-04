require('./bootstrap');
window.Vue = require('vue');
import Router from "vue-router";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Multiselect from 'vue-multiselect'
import routes from "./router";
 
Vue.use(Router)
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

 // register globally
 Vue.component('multiselect', Multiselect)


const router = new Router({
    mode: 'history',
    routes
})
const app = new Vue({
    el: '#app',
    router
});