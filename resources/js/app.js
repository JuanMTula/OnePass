window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
require('materialize-css');
import select2 from './select2.full'
require('./functions.js');
require('./rutas.js');
window.Swal  = require('sweetalert2');
window.Materialize = require('materialize-css');


import '@shoelace-style/shoelace/dist/themes/base.css';
import SlButton from '@shoelace-style/shoelace/dist/components/button/button.js';
import SlIcon from '@shoelace-style/shoelace/dist/components/icon/icon.js';
import SlInput from '@shoelace-style/shoelace/dist/components/input/input.js';
import SlRating from '@shoelace-style/shoelace/dist/components/rating/rating.js';
import SlDetails from '@shoelace-style/shoelace/dist/components/details/details';
import SlDialog from '@shoelace-style/shoelace/dist/components/dialog/dialog';
import Sliconbutton from '@shoelace-style/shoelace/dist/components/icon-button/icon-button';
import { setBasePath } from '@shoelace-style/shoelace/dist/utilities/base-path.js';

// Set the base path to the folder you copied Shoelace's assets to
setBasePath('/dist/shoelace');

window.Vue = require('vue');
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

Vue.component('V-MaterialIcon', require('vue-materials-icon/MaterialIcon.vue').default);

Vue.config.ignoredElements = [
    'another-web-component',
    /^sl-/
]

const routes = [
    {
        path: '/',
        name: 'home',
        component: require('./vue/views/home.vue').default
    },
    {
        path: '/categorias',
        name: 'categorias',
        component: require('./vue/views/categorias.vue').default
    },

]

const router = new VueRouter({
    routes
})

const app = new Vue({
    el: '#app',
    router
});


