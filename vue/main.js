import { createApp } from 'vue';
import InstantSearch from 'vue-instantsearch/vue3/es';
import App from './App.vue';

const app = createApp(App);
// app.prototype.$bool = true;

app.use(InstantSearch);
app.mount('#vue');
