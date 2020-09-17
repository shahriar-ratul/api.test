<template>
<v-data-table :headers="headers" :items="employees.data" sort-by="id" class="elevation-1" :loading="loading" loading-text="Loading... Please wait" :items-per-page="5" @pagination="paginate" :footer-props="{
            itemsPerPageOptions:[10,15,20,-1],
            itemsPerPageText:'employees Per Page',
            showCurrentPage:true,
            showFirstLastPage:true,
            }">
    <template v-slot:top>
        <v-toolbar flat>
            <v-toolbar-title>employees</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>

            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New Item</v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-select :items="company" label="Company"></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                        <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-eye</v-icon>
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
    </template>
    <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>

    <v-snackbar v-model="snackbar" color="success">
        {{ text }}
        <template v-slot:action="{ attrs }">
            <v-btn color="error" text v-bind="attrs" @click="snackbar = false">Close</v-btn>
        </template>
    </v-snackbar>
</v-data-table>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        loading: false,
        snackbar: false,
        text: "item deleted successfully",
        total: 0,

        headers: [{
                text: "#",
                align: "left",
                sortable: true,
                value: "id",
            },
            {
                text: "Name",
                value: "name",
            },
            {
                text: "Email",
                value: "email",
            },

            {
                text: "Actions",
                value: "actions",
                sortable: false,
            },
        ],
        employees: [],
        company: [],
        editedIndex: -1,
        editedItem: {
            id: "",
            name: "",
            email: "",
            company_id: "",
        },
        defaultItem: {
            id: "",
            name: "",
            email: "",
            company_id: "",
        },
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Item" : "Edit Item";
        },
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
    },

    created() {
        this.initialize();
    },

    methods: {
        paginate(e) {
            axios
                .get(`employees`)
                .then((res) => {
                    this.employees = res.data;
                })
                .catch((err) => {
                    console.dir(err);
                    if ((err.response.status = 401)) {
                        localStorage.removeItem("token");
                        this.$router.push("/login");
                    }
                });
        },
        initialize() {
            // Add a request interceptor
            axios.interceptors.request.use(
                (config) => {
                    this.loading = true;
                    return config;
                },
                (error) => {
                    // Do something with request error
                    return Promise.reject(error);
                }
            );

            // Add a response interceptor
            axios.interceptors.response.use(
                (response) => {
                    this.loading = false;
                    return response;
                },
                (error) => {
                    this.loading = false;
                    return Promise.reject(error);
                }
            );
        },

        editItem(item) {
            this.editedIndex = this.employees.data.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            const index = this.employees.data.indexOf(item);
            let decide = confirm("Are you sure you want to delete this item?");
            if (decide) {
                axios
                    .delete("employees/" + item.id)
                    .then((result) => {
                        this.snackbar = true;
                        this.text = result.data.message;
                        this.employees.data.splice(index, 1);
                    })
                    .catch((err) => {
                        console.log(err.response);
                    });
            }
        },

        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        save() {
            if (this.editedIndex > -1) {
                // console.log('edit')
                const index = this.editedIndex;
                this.$nextTick(function () {
                    axios
                        .put("admin/tag/" + this.editedItem.id, {
                            name: this.editedItem.name,
                        })
                        .then((res) => {
                            // console.log(res.data.tag);
                            // console.log(this.employees[index])
                            Object.assign(this.employees.data[index], res.data.tag);
                            // this.$set(this.editedItem, this.editedItem.id, res.data.tag)
                        })
                        .catch((err) => {
                            // console.log(err.response);
                        });
                });
                // Object.assign(this.employees[this.editedIndex], this.editedItem)
            } else {
                axios
                    .post("employees", {
                        name: this.editedItem.name,
                    })
                    .then((res) => {
                        // console.log(res.data);
                        this.employees.push(res.data.tag);
                    })
                    .catch((err) => {
                        console.dir(err);
                    });
                // this.employees.push(this.editedItem)
            }
            this.close();
        },
    },
};
</script>
