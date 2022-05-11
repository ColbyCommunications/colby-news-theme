<template>
  <ais-instant-search
    index-name="prod_news_searchable_posts"
    :search-client="searchClient"
    :middlewares="middlewares"
  >
    <ais-configure :hits-per-page.camel="1" />
    <!-- Widgets -->
    <!-- searchbox widget-->
    <searchbox></searchbox>
    <!-- tab navigation -->
    <navigation :currentTab="currentTab" @nav-click="changeTab"></navigation>
    <!-- settings menu-->
    <settings></settings>
    <!-- stories tab -->
    <stories-tab :currentTab="currentTab"></stories-tab>
    <!-- media tab-->
    <media-tab :currentTab="currentTab"></media-tab>
    <!-- faculty accomplishments tab-->
    <faculty-accomplishments-tab
      :currentTab="currentTab"
    ></faculty-accomplishments-tab>
  </ais-instant-search>
</template>

<script>
import algoliasearch from 'algoliasearch/lite';
import { createInsightsMiddleware } from 'instantsearch.js/es/middlewares';
import Searchbox from './components/Searchbox.vue';
import Navigation from './components/Navigation.vue';
import Settings from './components/Settings.vue';
import StoriesTab from './components/StoriesTab.vue';
import MediaTab from './components/MediaTab.vue';
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
    Searchbox,
    Navigation,
    Settings,
    StoriesTab,
    MediaTab,
    FacultyAccomplishmentsTab,
  },
  data() {
    return {
      currentTab: 'Stories',
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
