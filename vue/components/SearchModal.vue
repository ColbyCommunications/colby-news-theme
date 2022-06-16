<template>
  <div
    v-if="store.searchOpen"
    id="site-search"
    aria-hidden="false"
    :class="[
      'fixed',
      'inset-0',
      'z-50',
      'overflow-y-auto',
      'bg-white',
      'animate-opacity-in',
      'aria-hidden:animate-opacity-out',
      '!block',
    ]"
  >
    <div
      role="dialog"
      aria-modal="true"
      aria-label="Site Search"
      style="position: relative"
    >
      <div
        class="sticky-events--sentinel sticky-events--sentinel-top"
        style="
          left: 0px;
          position: relative;
          right: 0px;
          visibility: hidden;
          top: calc(0px);
        "
      ></div>
      <header
        class="sticky top-0 z-20 transition-colors bg-white site-header stuck:border-b stuck:border-black stuck:border-opacity-10 stuck:shadow"
        style="position: sticky"
      >
        <div class="container">
          <div class="flex justify-between items-center py-5">
            <a href="/" aria-label="Home">
              <svg
                class="h-[1.0625rem] sm:h-[1.625rem]"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 918.78 129.832"
              >
                <path
                  d="M582.7,7.611H559.406l-33.925,56.3-35.392-56.3H465.883l48.228,72.8v49.329H535.2V80.6ZM439.623,97.1c0,8.435-4.585,15.22-17.971,15.22H384.426V76.378H420c13.57,0,19.622,6.418,19.622,16.321Zm-.55-52.63c0,9.719-6.235,16.321-19.622,16.321H384.426V25.4H421.1c13.386,0,17.971,6.785,17.971,15.22ZM461.445,98.2V93.249c0-11.737-6.968-22.739-23.656-25.49,14.487-2.751,21.822-12.47,21.822-26.223V38.6c0-18.521-12.1-30.991-39.426-30.991H363.154v122.13H421.1c27.14,0,40.343-12.653,40.343-31.541M347.313,129.741V111.4h-70.6V7.611H255.624v122.13ZM217.85,82.063c0,18.154-11.736,33.191-34.108,33.191s-34.109-15.037-34.109-33.191V55.106c0-18.154,11.737-33.008,34.109-33.008S217.85,36.952,217.85,55.106Zm21.272-.184V55.289c0-27.69-19.988-51.529-55.38-51.529S128.361,27.6,128.361,55.289v26.59c0,27.507,19.989,51.713,55.381,51.713s55.38-24.206,55.38-51.713M115.27,36.585C108.852,20.081,89.6,3.76,63.19,3.76,26.882,3.76,5.61,28.333,5.61,58.04V80.045c0,29.341,20.171,53.547,56.847,53.547,27.69,0,45.661-16.321,52.813-33.192L97.849,92.515c-5.868,13.2-17.421,22.739-34.292,22.739-23.839,0-36.675-14.67-36.675-34.475V57.307c0-20.355,12.469-35.209,35.942-35.209,17.6,0,28.79,10.819,34.658,22.372Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
                <path
                  d="M657.24,45.715h11.39v83.748H658.319l-55.991-64.5v64.5h-11.27V45.715h9.711l56.471,65.047Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
                <path
                  d="M689.011,45.715h47.478V56.386H701V81.923h34.291V92.655H701v26.017h36.629v10.671H689.011Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
                <path
                  d="M859.533,45.715H871.49l-33.859,84.107H835l-27.382-68.1-27.666,68.1h-2.574L743.62,45.715H755.7l23.079,57.73,23.233-57.73h11.334l23.343,57.73Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
                <path
                  d="M902.09,94.373l-9.113-5.535q-8.573-5.235-12.2-10.3a19.509,19.509,0,0,1-3.627-11.66q0-9.891,6.864-16.066t17.835-6.175a33.747,33.747,0,0,1,19.244,5.89V64.134q-9.054-8.706-19.484-8.707a16.13,16.13,0,0,0-9.652,2.717,8.245,8.245,0,0,0-3.776,6.956,10.716,10.716,0,0,0,2.782,7.047,34.993,34.993,0,0,0,8.947,6.9l9.157,5.418q15.322,9.153,15.322,23.3,0,10.071-6.744,16.365t-17.535,6.3a36.831,36.831,0,0,1-22.6-7.629V107.567q9.711,12.3,22.481,12.3a14.117,14.117,0,0,0,9.381-3.136,9.827,9.827,0,0,0,3.747-7.855Q913.12,101.235,902.09,94.373Z"
                  transform="translate(-5.61 -3.76)"
                ></path>
              </svg>
            </a>
            <div class="space-x-1 js-focus-visible">
              <div class="inline-block cursor-pointer open-menu-wrapper">
                <button
                  class="open-menu bg-white p-2 rounded-lg group transition-colors selected:bg-black selected:bg-opacity-[7%] disabled:pointer-events-none"
                  aria-label="Open menu (modal)"
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
                  class="open-search bg-white p-2 rounded-lg group transition-colors selected:bg-black selected:bg-opacity-[7%] disabled:pointer-events-none selected"
                  aria-label="Open search (modal)"
                  disabled=""
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
          </div>
        </div>
      </header>
      <div class="container text-right">
        <button
          class="p-2 transition-colors bg-white rounded-lg pointer-events-auto close-modal bg-opacity-90 hover:bg-opacity-100 group disabled:pointer-events-none"
          id="close-search"
          aria-label="Close modal"
          @click="closeSearch"
        >
          <svg
            class="w-6 h-6 transition-transform transform group-hover:scale-125"
            aria-hidden="true"
            viewBox="0 0 50 50"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"
            ></path>
          </svg>
        </button>
      </div>
    </div>
    <div
      class="flex flex-col justify-between"
      style="min-height: calc(100vh - var(--header-height))"
    >
      <div class="pt-2 md:pt-12">
        <div>
          <Algolia />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { useMainStore } from '../stores/main';
import Algolia from './Algolia.vue';
// const store = useMainStore();

export default {
  setup() {
    const store = useMainStore();
    return {
      store,
    };
  },
  methods: {
    closeSearch() {
      console.log(this.store);
      this.store.closeSearch();
    },
  },
  components: {
    Algolia,
  },
};
</script>
