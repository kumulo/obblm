<template>
    <div>
        <h1>Championships</h1>
        <div v-if="loading">Loading...</div>
        <ul v-else>
            <li v-for="(competition, key) in competitions">{{ competition.name }}</li>
        </ul>
    </div>
</template>
<script>
    import axios from "axios";
    import store from '../../store';

    export default {
        data: () => ({
            competitions: [],
            loading: true
        }),
        props: {
            entrypoint: String,
        },
        mounted() {
            axios
                .get(store.entrypoint + "/competitions")
                .then(response => {
                    this.loading = false;
                    this.competitions = response.data
                })
        }
    }
</script>