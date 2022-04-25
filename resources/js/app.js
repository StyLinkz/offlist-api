/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Vue
window.Vue = require('vue');

// Vuelidate
window.Vuelidate = require('vuelidate');
Vue.use(Vuelidate);

// Vuetify
window.Vuetify = require('vuetify');
Vue.use(Vuetify);

// Vue2Filters
import Vue2Filters from 'vue2-filters';
Vue.use(Vue2Filters);

// Google Map
import * as GmapVue from 'gmap-vue';
Vue.use(GmapVue, {
  load: {
    key: 'AIzaSyAEu81nqJqarzuaHRQJGXS3cBqRPtB8OUI',
    libraries: 'places',
  },
});

// Vue Easy Lightbox
import VueEasyLightbox from 'vue-easy-lightbox';
Vue.use(VueEasyLightbox);

// import VuetifyGoogleAutocomplete from 'vuetify-google-autocomplete';
// Vue.use(VuetifyGoogleAutocomplete, {
//     apiKey: 'AIzaSyBmyaXLRg7yZ--rvspkdZAYY1e5OZaGYtU', // Can also be an object. E.g, for Google Maps Premium API, pass `{ client: <YOUR-CLIENT-ID> }`
// });

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
Vue.component('home-component', require('./components/HomeComponent.vue').default);
Vue.component('offers-component', require('./components/OffersComponent.vue').default);
Vue.component('offer-detail-component', require('./components/OfferDetailComponent.vue').default);
Vue.component('offer-create-component', require('./components/OfferCreateComponent.vue').default);
Vue.component('my-offers', require('./components/MyOffersComponent.vue').default);
Vue.component('my-requests', require('./components/MyRequestsComponent.vue').default);
Vue.component('my-contacts', require('./components/MyContactsComponent.vue').default);
Vue.component('my-invitations', require('./components/MyInvitationsComponent.vue').default);
Vue.component('my-groups', require('./components/MyGroupsComponent.vue').default);
Vue.component('my-favorites', require('./components/MyFavoritesComponent.vue').default);
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('login-component', require('./components/LoginComponent.vue').default);
// Vue.component('offer-list-component', require('./components/OfferListComponent.vue').default);
// Vue.component('offer-create-component', require('./components/OfferCreateComponent.vue').default);
// Vue.component('imprint-component', require('./components/ImprintComponent.vue').default);
// Vue.component('free-listing-component', require('./components/FreeListingComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// VueX
import Vuex from 'vuex';
const store = new Vuex.Store({
  state: {
    user: null,
    isLoading: false,
    isSignInModalOpen: false,
    isSignUpModalOpen: false,
    notification: {
      isActive: false,
      message: '',
      type: 'default',
    },
  },
  mutations: {
    setUser (state, user) {
      state.user = user;
    },
    setLoading (state, isLoading) {
      state.isLoading = isLoading;
    },
    openSignInModal (state) {
      state.isSignInModalOpen = true;
    },
    closeSignInModal (state) {
      state.isSignInModalOpen = false;
    },
    openSignUpModal (state) {
      state.isSignUpModalOpen = true;
    },
    closeSignUpModal (state) {
      state.isSignUpModalOpen = false;
    },
    openNotification (state, { message = '', type = 'default' }) {
      state.notification = {
        isActive: true,
        message,
        type,
      };
    },
    closeNotification (state) {
      state.notification = {
        isActive: false,
        message: '',
        type: 'default',
      };
    },
  },
});

// Routes
import AppComponent from './components/AppComponent';
import VueRouter from 'vue-router';
import routes from './routes';
Vue.use(VueRouter);
const router = new VueRouter({
  routes,
  mode: 'history'
});

// Initialize
const app = new Vue({
    el: '#app',
    router,
    render: h => h(AppComponent),
    store: store,
    vuetify : new Vuetify(),
});
