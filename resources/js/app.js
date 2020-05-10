require('./bootstrap');
import Index from './Index';

import Vue from 'vue';
import VueRouter from 'vue-router';
import { routes } from './Routes';
import { store } from './store';

window.Vue = require('vue');

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes
});

import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        Index,
    }
});
