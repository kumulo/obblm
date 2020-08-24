import Vue from 'vue';
import Vuetify from 'vuetify'
import ObblmApp from './components/Layout/index'
import 'vuetify/dist/vuetify.min.css';

import VueRouter from 'vue-router'

Vue.use(Vuetify);
Vue.use(VueRouter);

import router from './router';
import axios from 'axios';
import store from './store';

axios.defaults.headers.common['Accept'] = 'application/json';

const myrouter = new VueRouter({routes: router.routes});

Vue.component('obblm-app', ObblmApp);

var obblm = new Vue({
    vuetify: new Vuetify(),
    store: store,
    router: myrouter,
    el: "#obblm",
    icons: {
        iconfont: 'md',
        //iconfont: 'mdi', // default - only for display purposes
    }
});
