/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.Vuelidate = require('vuelidate');
Vue.use(Vuelidate);

window.Vuetify = require('vuetify');
Vue.use(Vuetify);

import VuetifyGoogleAutocomplete from 'vuetify-google-autocomplete';
Vue.use(VuetifyGoogleAutocomplete, {
    apiKey: 'AIzaSyBmyaXLRg7yZ--rvspkdZAYY1e5OZaGYtU', // Can also be an object. E.g, for Google Maps Premium API, pass `{ client: <YOUR-CLIENT-ID> }`
});

import Vue2Filters from 'vue2-filters';
Vue.use(Vue2Filters);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/* Components */
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('offer-list-component', require('./components/OfferListComponent.vue').default);
Vue.component('offer-create-component', require('./components/OfferCreateComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify : new Vuetify(),
});
