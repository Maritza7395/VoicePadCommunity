
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

window.Bus=new Vue;
Vue.component('home', require('./components/Home.vue').default);
Vue.component('commands', require('./components/commands/Commands.vue').default);
Vue.component('motivation-text', require('./components/motivations/MotivationText.vue').default);
Vue.component('genre', require('./components/genres/Genres.vue').default);
Vue.component('notification', require('./components/Notifications').default);
Vue.component('notification-index', require('./components/NotificationsIndex').default);
Vue.component('motivation-user', require('./components/motivations/MotivationUser.vue').default);
Vue.component('category', require('./components/categories/Categories.vue').default);
Vue.component('user', require('./components/users/Users.vue').default);
Vue.component('administrators', require('./components/users/Administrators.vue').default);
Vue.component('show_user', require('./components/users/Show.vue').default);
Vue.component('complaint_users', require('./components/users/Complaint.vue').default);
Vue.component('details_complaint_users', require('./components/users/DetailsComplaint.vue').default);
Vue.component('complaint_summernotes', require('./components/summernote/Complaint.vue').default);
Vue.component('details_complaint_summernotes', require('./components/summernote/DetailsComplaint.vue').default);
Vue.component('summernote', require('./components/summernote/Summernotes.vue').default);

Vue.component('index_for_user', require('./components/summernote/IndexForUser.vue').default);
//SummernoteComponents
Vue.component('text-information', require('./components/summernote/Show.vue').default);
Vue.component('create-book', require('./components/summernote/Create.vue').default);
Vue.component('edit-summernote', require('./components/summernote/Edit.vue').default);

Vue.component('search', require('./components/filter/Search.vue').default);
Vue.component('categories_filter', require('./components/filter/categoriesFilter.vue').default);
Vue.component('nav_filter', require('./components/filter/navbSearch.vue').default);


const app = new Vue({
    el: '#app',
    data:{
    	menu:0
    }
});
