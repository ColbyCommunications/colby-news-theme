<template>
  <ais-instant-search
    index-name="prod_news_searchable_posts"
    :search-client="searchClient"
    :middlewares="middlewares"
  >
    <ais-configure :hits-per-page.camel="1" />
    <!-- Widgets -->
    <ais-search-box
      id="site-search-searchbox"
      placeholder="Start typing to search"
      submit-title="Search"
      class="mb-28"
    >
      <template v-slot:submit-icon>SEARCH</template>
    </ais-search-box>
    <!-- tab navigation -->
    <navigation :currentTab="currentTab" @nav-Click="changeTab"></navigation>
    <!-- stories tab -->
    <stories-tab :currentTab="currentTab"></stories-tab>
    <!-- media tab-->
    <media-tab :currentTab="currentTab"></media-tab>
    <!-- faculty accomplishments tab-->
    <faculty-accomplishments-tab
      :currentTab="currentTab"
    ></faculty-accomplishments-tab>
    <!-- pagination widget -->
    <pagination></pagination>
  </ais-instant-search>
</template>

<script>
import algoliasearch from 'algoliasearch/lite';
import { createInsightsMiddleware } from 'instantsearch.js/es/middlewares';
import Navigation from './components/Navigation.vue';
import StoriesTab from './components/StoriesTab.vue';
import MediaTab from './components/MediaTab.vue';
import Pagination from './components/Pagination.vue';
import FacultyAccomplishmentsTab from './components/FacultyAccomplishmentsTab.vue';

const insightsMiddleware = createInsightsMiddleware({
  insightsClient: aa,
});

aa('init', {
  appId: '2XJQHYFX2S',
  apiKey: '63c304c04c478fd0c4cb1fb36cd666cb',
  useCookie: true,
  cookieDuration: 15552000000,
});

export default {
  components: {
    Navigation,
    StoriesTab,
    MediaTab,
    FacultyAccomplishmentsTab,
    Pagination,
  },
  data() {
    return {
      currentTab: 'stories',
      middlewares: [insightsMiddleware],
      searchClient: algoliasearch(
        '2XJQHYFX2S',
        '63c304c04c478fd0c4cb1fb36cd666cb'
      ),
    };
  },
  methods: {
    changeTab(tabName) {
      this.currentTab = tabName;
    },
  },
};
</script>
