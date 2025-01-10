import { createRouter,createWebHistory } from "vue-router"; 
import LoginComponent from '../components/LoginComponent.vue';
import ExampleComponent from '../components/ExampleComponent.vue';

const routes = [
    {
        path: '/',
        component: LoginComponent
    },
    {
        path: '/dashboard',
        component: ExampleComponent
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;