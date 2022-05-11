import { createApp } from 'vue';
import InstantSearch from 'vue-instantsearch/vue3/es';
import App from './App.vue';
import { createPinia } from 'pinia';

const app = createApp(App);
app.use(InstantSearch);
app.use(createPinia());
app.mount('#vue');
