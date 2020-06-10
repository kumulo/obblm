<template>
    <v-form
            ref="form"
            lazy-validation
            @submit.prevent="handleSubmit(item)"
    >
        <v-btn
                :disabled="!valid"
                color="success"
                class="mr-4"
                @click="validate"
        >
            Validate
        </v-btn>

        <v-btn
                color="error"
                class="mr-4"
                @click="reset"
        >
            Reset Form
        </v-btn>

        <v-btn
                color="warning"
                @click="resetValidation"
        >
            Reset Validation
        </v-btn>
    </v-form>
</template>

<script>
    import { find, get, isUndefined } from 'lodash';
    import { mapFields } from 'vuex-map-fields';
    import { mapActions } from 'vuex';

    export default {
        props: {
            valid: {
                type: Boolean,
                default: false
            },
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
            validate () {
                this.$refs.form.validate()
            },
            reset () {
                this.$refs.form.reset()
            },
            resetValidation () {
                this.$refs.form.resetValidation()
            },
        },
    };
</script>
