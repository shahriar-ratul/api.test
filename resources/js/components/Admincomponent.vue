<template>
<v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
        <v-list dense>
            <v-list-item v-for="item in items" :key="item.text" link :to="item.action">
                <v-list-item-action>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>{{ item.text }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item class="mt-4">
                <v-list-item-title>
                    <v-switch v-model="theme" class="ma-4" color="error" label="Swich Theme"></v-switch>
                </v-list-item-title>
            </v-list-item>
            <v-list-item link>
                <v-list-item-action>
                    <v-icon color="grey darken-1">mdi-cog</v-icon>
                </v-list-item-action>
                <v-list-item-title>Logout</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left color="red" dense dark>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-btn to="/admin" color="error">
            <v-icon class="mx-4" large>mdi-view-dashboard-variant</v-icon>
            <v-toolbar-title class="mr-12 align-center">
                <span class="title">Dashboard</span>
            </v-toolbar-title>
        </v-btn>

        <v-spacer></v-spacer>
        <v-row align="center" style="max-width: 650px"></v-row>
    </v-app-bar>

    <v-main>
        <v-container>
            <v-row justify="center" align="center">
                <v-col>
                    <!-- admin route view-->
                    <router-view></router-view>

                    <v-snackbar v-model="snackbar" color="success">
                        {{ text }}
                        <template v-slot:action="{ attrs }">
                            <v-btn color="success" text v-bind="attrs" @click="snackbar = false">Close</v-btn>
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
    name: "AdminComponent",
    props: {
        source: String,
    },
    data: () => ({
        drawer: null,
        snackbar: false,
        theme: true,
        text: "You are Logged in Successfully",
        items: [{
            icon: "mdi-tag",
            text: "Employee",
            action: "/admin/employee",
        }, ],
    }),

    mounted: function () {
        this.snackbar = !!localStorage.getItem("loggedIn");
        localStorage.removeItem("loggedIn");
    },
    watch: {
        theme: function (old, newval) {
            this.$vuetify.theme.dark = newval;
        },
    },
    created() {
        this.$vuetify.theme.dark = false;
    },
};
</script>

<style scoped></style>
