import { defineStore } from 'pinia';

export const useMainStore = defineStore('main', {
  state: () => {
    return {
      searchOpen: false,
    };
  },
  actions: {
    openSearch() {
      const el = document.body;
      el.classList.add('no-scroll');
      this.searchOpen = true;
    },
    closeSearch() {
      const el = document.body;
      el.classList.remove('no-scroll');
      this.searchOpen = false;
    },
  },
});
