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
    <nav>
      <ul class="Tabs">
        <li
          @click="changeTab('stories')"
          class="text-xl Tabs__tab Tab"
          v-bind:class="{ 'activeTab': currentTab === 'stories' }"
        >
          <button>Stories</button>
        </li>
        <li
          @click="changeTab('media')"
          class="text-xl Tabs__tab Tab"
          v-bind:class="{ 'activeTab': currentTab === 'media' }"
        >
          <button>Media Coverage</button>
        </li>
        <li
          @click="changeTab('faculty')"
          class="text-xl Tabs__tab Tab"
          v-bind:class="{ 'activeTab': currentTab === 'faculty' }"
        >
          <button>Faculty Accomplishments</button>
        </li>
        <li
          @click="changeTab('videos')"
          class="text-xl Tabs__tab Tab"
          v-bind:class="{ 'activeTab': currentTab === 'videos' }"
        >
          <button>Videos</button>
        </li>
        <li class="Tabs__presentation-slider" role="presentation"></li>
      </ul>
    </nav>
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
  components: { StoriesTab, MediaTab, FacultyAccomplishmentsTab, Pagination },
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
