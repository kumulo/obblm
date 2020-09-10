<script>
    import axios from 'axios';
    import loginForm from '../LoginForm';
    import BblmForm from '../Form';
    import store from '../../store';

    export default {
        components: {
          loginForm,
          BblmForm
        },
        props: {
            entrypoint: String,
            source: String,
        },
        methods: {
            onUserAuthenticated(userUri) {
                axios
                    .get(userUri)
                    .then(response => (this.user = response.data))
            }
        },
        data: () => ({
                drawer: false,
                user: null
        }),
        mounted() {
            store.entrypoint = this.entrypoint;
            this.$store.commit('loadSchema');
            console.log(window.user);
            if (window.user) {
                this.user = window.user;
            }
        },
        created () {
            this.$vuetify.theme.grey = true
        },
    }
</script>
