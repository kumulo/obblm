import axios from 'axios';
import store from '../store';


const schema = {
    data() {
        return {
            loading: false,
            store: store,
            schema: false,
            error: false
        };
    },
    async created() {
        axios.get(this.store.entrypoint + "/docs.json").then(response => {
            this.schema = response.data.components.schema
        });
    }
}

export default schema