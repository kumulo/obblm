<template>
    <div>
        <h1>Championships</h1>
        <v-form v-model="formValid">
            <v-jsonschema-form v-if="schema && schema[schemaName]" :schema="schema[schemaName]" :model="dataObject" :options="options" @error="showError" />
        </v-form>
        <div v-if="loading">Loading...</div>
        <ul v-else>
            <li v-for="(championship, key) in championships">{{ championship.name }}</li>
        </ul>
    </div>
</template>
<script>
    import axios from "axios";
    import store from '../../store';

    import VJsonschemaForm from '@koumoul/vuetify-jsonschema-form'
    export default {
        components: {VJsonschemaForm},
        data: () => ({
            championships: [],
            loading: true,
            schemaName: 'Championship:jsonld',
            schema: store.apiSchema,
            dataObject: {},
            formValid: false,
            options: {
                debug: false,
                disableAll: false,
                autoFoldObjects: true
            }
        }),
        props: {
            entrypoint: String,
        },
        mounted() {
            axios
                .get(store.entrypoint + "/championships")
                .then(response => {
                    this.loading = false;
                    this.championships = response.data
                })
        },
        methods: {
            showError(err) {
                window.alert(err)
            }
        }
    }
</script>