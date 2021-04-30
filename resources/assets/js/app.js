
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';
import VueInternationalization from 'vue-i18n';
import Locale from '../../js/vue-i18n-locales.generated';
// ui frameworks
import AtComponents from 'at-ui'
// import 'at-ui-style'    // Import CSS
import Vuesax from 'vuesax'
// import 'vuesax/dist/vuesax.css' //Vuesax styles


Vue.use(VueInternationalization);

// const lang = document.documentElement.lang.substr(0, 2);
const lang = document.documentElement.lang.substr(0, 2);
// or however you determine your current app locale

const i18n = new VueInternationalization({
    locale: lang,
    messages: Locale
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('lesson-show', require('./components/frontend/lessons/Show.vue'));
Vue.component('memorize-create', require('./components/admin/form/memorize/create.vue'));
Vue.component('memorize-index', require('./components/admin/form/memorize/index.vue'));
Vue.component('file-manager', require('./components/system/FileManager.vue'));
Vue.component('to-do', require('./components/system/ToDo.vue'));
Vue.component('product-index', require('./components/frontend/products/index.vue'));
Vue.component('product-items', require('./components/frontend/products/items.vue'));
Vue.component('form-show', require('./components/frontend/forms/Show.vue'));
Vue.component('smart-form-create', require('./components/admin/form/smart_form/Create.vue'));
Vue.component('register-form', require('./components/system/forms/RegisterForm.vue'));

// If you want to use it in your vue components
Vue.use(AtComponents)
Vue.use(Vuesax)



const app = new Vue({
    el: '#vue-app',
    i18n,
});

