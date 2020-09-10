import Vue from 'vue';
import Vuetify from 'vuetify'
import ObblmApp from './components/Layout/index'
import BblmForm from './components/Form/index'
import 'vuetify/dist/vuetify.min.css';

import VueRouter from 'vue-router'

Vue.use(Vuetify);
Vue.use(VueRouter);

import axios from 'axios';
import store from './store';

axios.defaults.headers.common['Accept'] = 'application/json';

const myrouter = new VueRouter();

Vue.component('bblm-app', ObblmApp);
Vue.component('bblm-form', BblmForm);

var obblm = new Vue({
    vuetify: new Vuetify(),
    store: store,
    router: myrouter,
    el: "#bblm-layout",
    icons: {
        iconfont: 'mdi',
    }
});
