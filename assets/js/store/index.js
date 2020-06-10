import league from './modules/league';
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const store = new Vuex.Store({
    entrypoint: '/api',
    modules: {
        league
    },
    strict: process.env.NODE_ENV !== 'production'
});

export default store;
