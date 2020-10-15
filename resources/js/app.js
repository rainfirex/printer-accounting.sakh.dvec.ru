import App from "./vue/App";
import VueRouter from 'vue-router';
import router from "./vue/routes";
import Vuelidate from 'vuelidate'
import store from "./vue/store";

import '../sass/style.scss';
import './assets/bootstrap/bootstrap.min.css';
import './assets/bootstrap/bootstrap.min.js';
import './jquery-3.4.1.min';

require('./bootstrap');
window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(Vuelidate);

new Vue({
    el: '#app',
    components: {},
    store,
    router,
    render : h => h(App)
});
