import { createApp } from 'vue';
import InstantSearch from 'vue-instantsearch/vue3/es';
import App from './App.vue';
import App2 from './App2.vue';

const app = createApp(App);
app.use(InstantSearch);
app.mount('#vue');

const app2 = createApp(App2);
app2.use(InstantSearch);
app2.mount('#vue-block');
