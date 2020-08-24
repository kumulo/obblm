<template>
    <v-app v-if="this.user">
        <v-navigation-drawer
                v-model="drawer"
                app
                clipped
        >
            <v-list dense>
                <v-list-item link to="/">
                    <v-list-item-action>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{name: 'championships'}">
                    <v-list-item-action>
                        <v-icon>emoji_events</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Championships</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{name: 'leagues'}">
                    <v-list-item-action>
                        <v-icon>mdi-cog</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Leagues</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar
            app
            clipped-left
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Application</v-toolbar-title>
        </v-app-bar>

        <v-content>
            <v-container
                fluid
            >
                <v-row>
                    <v-col>
                        <router-view></router-view>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>

        <v-footer app>
            <span>&copy; 2020</span>
        </v-footer>
    </v-app>
    <v-app class="shrink" v-else>
        <loginForm></loginForm>
    </v-app>
</template>

<script>
    import axios from 'axios';
    import loginForm from '../LoginForm';
    import store from '../../store';

    export default {
        components: {
            loginForm
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
            console.log(this.$store);
            if (window.user) {
                this.user = window.user;
            }
        },
        created () {
            this.$vuetify.theme.grey = true
        },
    }
</script>
