import { createApp } from 'vue';
import InstantSearch from 'vue-instantsearch/vue3/es';
import AlgoliaPersonalizedBlock from './components/AlgoliaPersonalizedBlock.vue';
import HeaderSearchButton from './components/HeaderSearchButton.vue';
import SearchModal from './components/SearchModal.vue';

import { createPinia } from 'pinia';

const store = createPinia();

const headerSearchButton = createApp(HeaderSearchButton);
headerSearchButton.use(store);
headerSearchButton.mount('#vue-search-button');

const modal = createApp(SearchModal);
modal.use(store);
modal.use(InstantSearch);
modal.mount('#vue-search-modal');

const algoliaPersonalizedBlock = createApp(AlgoliaPersonalizedBlock);
algoliaPersonalizedBlock.use(InstantSearch);
algoliaPersonalizedBlock.mount('.vue-block');
