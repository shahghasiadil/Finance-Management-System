/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.$ = require('jquery')
window.JQuery = require('jquery')
require( 'datatables.net');
require( 'datatables.net-buttons' );
// import { GridPlugin, DetailRow, Grid, PdfExport, ExcelExport, Toolbar } from "@syncfusion/ej2-vue-grids";
// import { ClickEventArgs } from "@syncfusion/ej2-navigations";
// Vue.use(GridPlugin);
// the moment library for the filters like: date, capital letters and etc...
import moment from 'moment';
Vue.filter('dates', function(created){
    return moment(created).format('MMMM Do YYYY, h:mm:ss a');
});

//
import Vuex from 'vuex';

import vuexI18n from 'vuex-i18n';

const store = new Vuex.Store();

Vue.use(vuexI18n.plugin, store);

import Locales from './vue-i18n-locales.generated.js';
Vue.i18n.add('en', Locales.en);
Vue.i18n.add('fa', Locales.fa);

// set the start locale to use
Vue.i18n.set('fa');

// the v form libarary for nice server side validation
import { Form, HasError, AlertError } from 'vform'
window.form = Form;

// require('datatables.net');
import Multiselect from 'vue-multiselect'
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('multiselect', Multiselect)

// the progress bar libraries
import VueProgressBar from 'vue-progressbar'
const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}
Vue.use(VueProgressBar, options)

// ES6 Modules or TypeScript for sweetalert2
import Swal from 'sweetalert2'
window.swal = Swal;


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: false,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

window.toast = Toast;


// components loading
import Projects from './components/Projects.vue'
import Allocations from './components/Allocation.vue'
import BudgetCode from './components/BudgetCode.vue'
import BudgetCatCode from './components/BudgetCatCode.vue'
import ExpenseCode from './components/ExpenseCode.vue'
import BudgetAllocation from './components/BudgetAllocation.vue'
import AllocationReport from './components/AllocationReport.vue'
import Reports from './components/Reports.vue'
import Users from './components/Users.vue'
import Dashboard from './components/Dashboard.vue'
import Journal from './components/Journal.vue'
import Voucher from './components/Voucher.vue'
import VoucherEntry from './components/VoucherEntry.vue'
import ProjectReport from './components/ProjectReport.vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    {path:'/projectReport', component:ProjectReport},
    { path: '/projects', component: Projects },
    { path: '/createvoucher', component: VoucherEntry },
    { path: '/budgetcode', component: BudgetCode},
    { path: '/journal', component: Journal},
    { path: '/voucher', component: Voucher},
    { path: '/dashboard', component: Dashboard},
    { path: '/budgetcatcode', component: BudgetCatCode},
    { path: '/expensecode', component: ExpenseCode},
    { path: '/budgetallocation', component: BudgetAllocation},
    { path: '/users', component: Users},
    { path: '/allocationreport', component: AllocationReport},
    { path: '/allocation', component: Allocations,
    props(route) {
      return {  id: route.query.id }
    }},
    { path: '/report', component: Reports,
    props(route) {
      return {  allocation: route.query.allocation }
    }},
  ]

 // 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

// Custom event functions
window.Fire =  new Vue();

// vue pagination
Vue.component('pagination', require('laravel-vue-pagination'));

// datepicker
import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
Vue.component('date-picker', VuePersianDatetimePicker);

Vue.component('project-component',Projects)
Vue.component('dashboard-component',Dashboard)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
    data: {

    },
    methods:{

    }
}).$mount('#app');
