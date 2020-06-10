<template>
    <div>
        <h1>Add league</h1>
        <Form
            :values="item"
            :handle-submit="onSendForm"
        ></Form>
    </div>
</template>
<script>
    import Form from './Form';
    import {mapActions} from "vuex";

    export default {
        components: {
            Form
        },
        data: () => ({
            item: {}
        }),

        methods: {
            ...mapActions('league/add', [
                'add',
            ]),

            onSendForm () {
                this.create(this.item);
            },
        },
    }
</script>