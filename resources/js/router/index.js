import Vue from "vue";
import VueRouter from "vue-router";
import AdminDashboard from '../components/AdminComponent.vue'
import LoginComponent from "../components/LoginComponent.vue";
import DashboardComponent from '../components/pages/Dashboard.vue'
import EmployeeComponent from '../components/pages/Employee.vue'



Vue.use(VueRouter);

const routes = [

    {
        path: "/",
        redirect: 'Login'
    },
    {
        path: "/login",
        name: "Login",
        component: LoginComponent,

    },
    {
        path: "/admin",
        component: AdminDashboard,

        children: [{
                path: '/',
                component: DashboardComponent,
            },
            {
                path: 'employee',
                component: EmployeeComponent,
            },


        ],
        beforeEnter: (to, from, next) => {
            axios.get('/auth/me', {})
                .then(res => {
                    next();
                })
                .catch(err => {
                    next('/login')
                })
        }

    },


];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

// const router = new VueRouter({routes})

router.beforeEach((to, from, next) => {


    const token = localStorage.getItem("token") || null
    window.axios.defaults.headers['Authorization'] = 'Bearer ' + token;
    next();


})

export default router;
