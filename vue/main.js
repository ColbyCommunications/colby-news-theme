import { createApp } from 'vue';
import InstantSearch from 'vue-instantsearch/vue3/es';
import App from './App.vue';
import VueAutosuggest from 'vue-autosuggest';

const app = createApp(App);
app.use(InstantSearch);
app.use(VueAutosuggest);
app.mount('#vue');
