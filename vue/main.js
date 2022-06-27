import { createApp } from 'vue';
import InstantSearch from 'vue-instantsearch/vue3/es';
import AlgoliaPersonalizedBlock from './components/AlgoliaPersonalizedBlock.vue';
import MenuButtons from './components/MenuButtons.vue';
import SearchModal from './components/SearchModal.vue';
import MenuModal from './components/MenuModal.vue';

import { createPinia } from 'pinia';

const store = createPinia();

const menuButtons = createApp(MenuButtons);
menuButtons.use(store);
menuButtons.mount('#vue-menu-buttons');

const modal = createApp(SearchModal);
modal.use(store);
modal.use(InstantSearch);
modal.mount('#vue-search-modal');

const menuModal = createApp(MenuModal);
menuModal.use(store);
menuModal.mount('#vue-menu-modal');

const algoliaPersonalizedBlock = createApp(AlgoliaPersonalizedBlock);
algoliaPersonalizedBlock.use(InstantSearch);
algoliaPersonalizedBlock.mount('.vue-block');
