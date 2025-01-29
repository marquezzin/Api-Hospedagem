import { createRouter,createWebHistory } from "vue-router"; 
import LoginComponent from '../components/LoginComponent.vue';
import DashboardComponent from '../components/DashboardComponent.vue';
import ReservationComponent from "../components/ReservationComponent.vue";

const routes = [
    {
        path: '/',
        component: LoginComponent
    },
    {
        path: '/dashboard',
        component: DashboardComponent
    },
    {
        path: '/reservation',
        component: ReservationComponent
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;