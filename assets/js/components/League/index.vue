<template>
    <div>
        <h1 class="font-weight-light mb-2">Leagues</h1>
        <div class="text-right">
            <v-btn
                    class="ma-2"
                    :disabled="loading"
                    tile outlined color="success"
                    link :to="{name: 'LeagueAdd'}"
            >
                <v-icon left>mdi-pencil</v-icon>
                New item
            </v-btn>
        </div>
        <section>
            <div v-if="loading">Loading...</div>
            <div v-else class="align-center px-1">
                <h2 class="font-weight-light mb-2">
                    Vuetify CRUD Example
                </h2>
                <v-card>
                    <v-data-table
                            :headers="headers"
                            :items="leagues">
                        <template v-slot:item.actions="{ item }">
                            <div class="text-truncate">
                                <v-icon
                                        small
                                        class="mr-2"
                                        @click="showEditDialog(item)"
                                        color="primary"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                        small
                                        @click="deleteItem(item)"
                                        color="pink"
                                >
                                    mdi-delete
                                </v-icon>
                            </div>
                        </template>
                        <template v-slot:item.details="{ item }">
                            <div class="text-truncate" style="width: 180px">
                                {{item.Details}}
                            </div>
                        </template>
                    </v-data-table>
                </v-card>
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on }">
                        <div class="d-flex">
                            <v-btn color="primary" dark class="ml-auto ma-3" v-on="on">
                                New
                                <v-icon small>mdi-plus-circle-outline</v-icon>
                            </v-btn>
                        </div>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span v-if="editedItem.id">Edit {{editedItem.id}}</span>
                            <span v-else>Create</span>
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="showEditDialog()">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="saveItem(editedItem)">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </section>
    </div>
</template>
<script>
    import axios from "axios";
    import store from '../../store';

    export default {
        data: () => ({
            leagues: [],
            loader: null,
            loading: true,
            headers: [
                { text: 'Id', value: 'id' },
                { text: 'Name', value: 'name' },
                { text: 'Actions', value: 'actions'}
            ],
            dialog: false, // used to toggle the dialog
            editedItem: {} // empty holder for create/update ops
        }),
        props: {
            entrypoint: String,
        },
        mounted() {
            this.loadItems();
        },
        methods: {
            showEditDialog(item) {
                this.editedItem = item||{}
                this.dialog = !this.dialog
            },
            loadItems()
            {
                this.items = []
                axios
                    .get(store.entrypoint + "/leagues")
                    .then(response => {
                        this.loading = false;
                        this.leagues = response.data.map((item) => {
                            return {
                                id: item.id,
                                name: item.name
                            }
                        })
                    })
            },
            saveItem(item) {
                /* this is used for both creating and updating API records
                 the default method is POST for creating a new item */

                let method = "post"
                let url = store.entrypoint + "/leagues"
                let id = item.id

                // airtable API needs the data to be placed in fields object
                let data = item

                if (id) {
                    // if the item has an id, we're updating an existing item
                    method = "put"
                    url = `${store.entrypoint}/leagues/${id}`

                    // must remove id from the data for airtable patch to work
                    delete data.id
                }

                // save the record
                axios[method](url,
                    data,
                    {}).then((response) => {
                    if (response.data && response.data.id) {
                        // add new item to state
                        this.editedItem.id = response.data.id
                        if (!id) {
                            // add the new item to items state
                            this.items.push(this.editedItem)
                        }
                        this.editedItem = {}
                    }
                    this.dialog = !this.dialog
                    this.loadItems()
                })
            },
            deleteItem(item) {
                //console.log('deleteItem', item)
                let id = item.id
                let idx = this.items.findIndex(item => item.id===id)
                if (confirm('Are you sure you want to delete this?')) {

                    axios.delete(`${store.entrypoint}/leagues/${id}`,
                        {}).then((response) => {
                        this.items.splice(idx, 1)
                    })
                    this.items.splice(idx, 1)
                    this.loadItems()
                }
            },
        },
    }
</script>