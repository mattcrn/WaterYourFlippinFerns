
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('App', require('./components/App.vue'));
/* Vue.component('Plants', require('./components/Plants.vue')); */

const app = new Vue({
    el: '#app',
    data: {
        plants: [{name: 'aloe-vera', water: 2, id: 1},
        {name: 'basil', water: 3, id: 2},],
    }
});
