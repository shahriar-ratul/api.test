window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers['crossDomain'] = true;
window.axios.defaults.headers['Access-Control-Allow-Origin'] = '*';

import Vue from 'vue';
import vuetify from './plugin/vuetify';
import MainApp from './components/AppComponent';
import router from './router';
import store from './store';


axios.defaults.baseURL = 'http://127.0.0.1:8000/api'



const app = new Vue({
    vuetify: vuetify,
    router,
    store,
    el: '#app',
    components: {
        MainApp
    },
});
