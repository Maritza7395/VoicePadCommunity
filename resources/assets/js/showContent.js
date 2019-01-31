
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.axios = require('axios');

import moment from 'moment'

Vue.prototype.moment = moment

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);
Vue.component('show-content', require('./components/summernote/ShowContent.vue').default);



const app = new Vue({
    el: '#showContent',
    data:{
    	menu:0
    }
});
