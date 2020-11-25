/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform';
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

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
Vue.component('profile', require('./components/Profile/Profile.vue').default);
Vue.component('post-add', require('./components/PostAddingHeader.vue').default);
Vue.component('posts', require('./components/Posts.vue').default);
Vue.component('own-posts', require('./components/ownPost.vue').default);
Vue.component('single-post', require('./components/SinglePost.vue').default);
Vue.component('friend', require('./components/FriendCategories.vue').default);
Vue.component('chat', require('./components/ChatComponent.vue').default);
Vue.component('notifications', require('./components/notification.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
export const bus = new Vue();
const app = new Vue({
    el: '#app',

});
