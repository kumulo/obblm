import league from './modules/league';
import axios from 'axios';

import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const store = new Vuex.Store({
    entrypoint: '/api',
    apiSchema: {},
    strict: process.env.NODE_ENV !== 'production',
    mutations: {
        loadSchema (apiSchema) {
            console.log(apiSchema);
            axios.get(this.entrypoint + "/docs.json").then(response => {
                this.apiSchema = response.data.components.schemas;
                console.log(this.apiSchema);
            });
        }
    }
});

export default store;
