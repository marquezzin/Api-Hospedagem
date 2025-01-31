import { createRouter,createWebHistory } from "vue-router"; 
import LoginComponent from '../components/LoginComponent.vue';
import DashboardComponent from '../components/DashboardComponent.vue';
import ReservationComponent from "../components/ReservationComponent.vue";
import NewReservationComponent from "../components/NewReservationComponent.vue";
import RegisterComponent from "../components/RegisterComponent.vue";

const routes = [
    {
        path: '/',
        component: LoginComponent
    },
    {
        path: '/register',
        component: RegisterComponent
    },
    {
        path: '/dashboard',
        component: DashboardComponent
    },
    {
        path: '/reservation',
        component: ReservationComponent
    },
    {
        path: '/new-reservation',
        component: NewReservationComponent
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;