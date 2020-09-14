/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// the moment library for the filters like: date, capital letters and etc...
import moment from 'moment';
Vue.filter('dates', function(created){
    return moment(created).format('MMMM Do YYYY, h:mm:ss a');
});

// the v form libarary for nice server side validation 
import { Form, HasError, AlertError } from 'vform'
window.form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

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
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

window.toast = Toast;

// the vue router library 
import VueRouter from 'vue-router'
Vue.use(VueRouter) 

let routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/profile', component: Profile},
    { path: '/customers', component: Customers},

  ]

  // 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    routes // short for `routes: routes`
  })
  

// Custom event functions
window.Fire =  new Vue();



// components loading 
import Dashboard from './components/Dashboard'
import Profile from './components/Profile'
import Customers from './components/Customers'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data: {
        message: 'Hello Vue!',
        
      }
}).$mount('#app');
