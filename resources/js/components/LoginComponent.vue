<template>
<v-app id="inspire">
    <v-main>
        <v-container class="fill-height" fluid>
            <v-row align="center" justify="center">
                <v-col cols="12" sm="8" md="4">
                    <v-card class="elevation-12">
                        <v-toolbar color="error" dark flat>
                            <v-toolbar-title>Login form</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                            <v-progress-linear :active="loading" :indeterminate="loading" absolute bottom color="deep-purple accent-4"></v-progress-linear>
                            <v-form ref="form" v-model="valid">
                                <v-text-field label="Email" color="error" name="email" :rules="emailRules" required v-model="form.email" prepend-icon="mdi-account" type="text"></v-text-field>

                                <v-text-field id="password" color="error" label="Password" name="password" required :rules="passwordRules" v-model="form.password" prepend-icon="mdi-lock" type="password"></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="error" @click="Login" :disabled="!valid">Login</v-btn>
                        </v-card-actions>
                    </v-card>
                    <v-snackbar v-model="snackbar" color="error">
                        {{ text }}
                        <template v-slot:action="{ attrs }">
                            <v-btn color="white" text v-bind="attrs" @click="snackbar = false">Close</v-btn>
                        </template>
                    </v-snackbar>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</v-app>
</template>

<script>
export default {
    name: "LoginComponent",
    data() {
        return {
            valid: true,
            emailRules: [
                (v) => !!v || "E-mail is required",
                (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
            ],
            passwordRules: [(v) => !!v || "Password is required"],
            form: {
                email: "",
                password: "",
            },

            loading: false,
            snackbar: false,
            text: "",
        };
    },
    methods: {
        Login() {
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
            axios
                .post("auth/login", this.form)
                .then((res) => {
                    // console.dir(res)
                    localStorage.setItem("token", res.data.access_token);
                    localStorage.setItem("loggedIn", true);
                    this.$router
                        .push("/admin")
                        .then((res) => console.log("logged in"))
                        .catch((err) => console.log("Wrong User"));
                })
                .catch((err) => {
                    // console.dir(err.response.data.status);
                    this.text = err.response.data.status;
                    this.snackbar = true;
                });
        },
    },
    created() {
        this.$vuetify.theme.dark = false;
    },
};
</script>

<style scoped>
</style>
