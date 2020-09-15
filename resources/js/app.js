
window._ = require('lodash');


window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);



window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


const app = new Vue({
    el: '#app',
});
