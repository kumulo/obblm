<template>
    <form @submit.prevent="handleSubmit(item)">

        <button
                type="submit"
                class="btn btn-success">Submit</button>
    </form>
</template>

<script>
    import { find, get, isUndefined } from 'lodash';
    import { mapFields } from 'vuex-map-fields';
    import { mapActions } from 'vuex';

    export default {
        props: {
            handleSubmit: {
                type: Function,
                required: true,
            },

            values: {
                type: Object,
                required: true,
            },

            errors: {
                type: Object,
                default: () => {},
            },

            initialValues: {
                type: Object,
                default: () => {},
            }
        },

        mounted() {
        },

        computed: {

            // eslint-disable-next-line
            item() {
                return this.initialValues || this.values;
            },

            violations() {
                return this.errors || {};
            },
        },

        methods: {
            ...mapActions({
            }),

            isSelected(collection, id) {
                return find(this.item[collection], ['@id', id]) !== undefined;
            },

            isValid(key) {
                return isUndefined(get(this.violations, key));
            },
        },
    };
</script>
