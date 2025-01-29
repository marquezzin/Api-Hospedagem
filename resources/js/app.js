/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import router from './router/index'; 
import AppComponent from './App.vue';
import { createPinia } from 'pinia';
import 'vue3-toastify/dist/index.css';



/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({
    components: {
        AppComponent
        //<app-component></app-component> chamado no blade
    }
});

const pinia = createPinia();



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(pinia);

// Isso permite que a navegação entre rotas seja gerenciada através do arquivo ./router/index.js.
app.use(router);

//Monta a aplicação Vue no elemento HTML que possui o atributo id="app". Este elemento está definido no arquivo Blade
//O Vue substitui <app-component> pelo conteúdo do componente AppComponent.
app.mount('#app');
