<template>
    <div>
        <h1>Add competition</h1>
            <VJsf v-if="schema" :schema="schema" :model="dataObject" :options="options" @error="showError" />
    </div>
</template>
<script>
    import VJsf from '@koumoul/vjsf';
    import Form from "./Form";
    import store from '../../store';
    import schema from '../../schema';

    export default {
        components: {VJsf},
        data: () => ({
            schema: schema.Championship,
            store: store,
            formValid: false,
            dataObject: {},
            options: {
                debug: false,
                disableAll: false,
                autoFoldObjects: true
            }
        }),
        mounted() {
            console.log(this.store);
            console.log(this.schema);
        },
        methods: {
            showError(err) {
                window.alert(err)
            }
        }
    }
</script>