<template>
  <div class="space-x-1 js-focus-visible">
    <div class="inline-block cursor-pointer open-menu-wrapper">
      <button
        class="open-menu bg-white p-2 rounded-lg group transition-colors selected:bg-black selected:bg-opacity-[7%]"
        aria-label="Open menu (modal)"
        @click="openMenu"
      >
        <svg
          class="w-6 h-6 group-hover:scale-125 transform transition-transform"
          aria-hidden="true"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M 0 11 L 0 13 L 24 13 L 24 11 L 0 11 Z"></path>
          <path d="M 0 18 L 0 20 L 24 20 L 24 18 L 0 18 Z"></path>
          <path d="M 0 4 L 0 6 L 24 6 L 24 4 L 0 4 Z"></path>
        </svg>
      </button>
    </div>
    <div class="inline-block cursor-pointer open-search-wrapper">
      <button
        class="open-search bg-white p-2 rounded-lg group transition-colors selected:bg-black selected:bg-opacity-[7%]"
        aria-label="Open search (modal)"
        @click="openSearch"
      >
        <svg
          class="w-6 h-6 group-hover:scale-125 transform transition-transform"
          aria-hidden="true"
          viewBox="0 0 50 50"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"
          ></path>
        </svg>
      </button>
    </div>
  </div>
</template>
<script>
import { useMainStore } from '../stores/main';

export default {
  setup() {
    // eslint-disable-next-line react-hooks/rules-of-hooks
    const store = useMainStore();
    return {
      store,
    };
  },
  methods: {
    openSearch() {
      this.store.openSearch();
    },
    openMenu() {
      this.store.openMenu();
    },
  },
};
</script>
