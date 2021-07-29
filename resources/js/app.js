require('./bootstrap');

import Vue from 'vue';
import VModal from 'vue-js-modal';

import App from './Pages/App';

const app = new Vue({
    el: '#app',
    components: { App },
});
Vue.use(VModal);
