require('./bootstrap');
window.Vue = require('vue');
import Router from "vue-router";
// import {createWebHistory, createRouter} from "vue-router";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// import routes from './router'

Vue.use(Router)
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)


// const router = new Router({
//     mode: 'history',
//     routes: routes
// })
// const router = createRouter({
//     history: createWebHistory(),
//     routes
// });
const routes = [
    { path: '/', name: 'product_list', component: require('./components/Product/List.vue').default },
    { path: '/products/add', name: 'product_add', component: require('./components/Product/Add.vue').default, props: true }
]

const router = new Router({
    mode: 'history',
    routes
})
const app = new Vue({
    el: '#app',
    router
});