<template>
  <ais-instant-search
    id="modal-top"
    index-name="prod_news_searchable_posts"
    :search-client="searchClient"
    :middlewares="middlewares"
    ref="aisIS"
  >
    <ais-configure :hits-per-page.camel="1" />
    <!-- Widgets -->
    <!-- searchbox widget-->
    <searchbox ref="searchBox"></searchbox>
    <!-- query suggestions -->
    <div class="qs mb-12">
      <ais-index
        index-name="prod_news_searchable_posts_query_suggestions"
        index-id="news-qs"
      >
        <ais-configure :hits-per-page.camel="8" />
        <ais-hits :transform-items="removeExactQueryQuerySuggestion">
          <template v-slot:item="{ item }">
            <ais-highlight
              :hit="item"
              attribute="query"
              @click="search(item.query)"
            />
          </template>
        </ais-hits>
      </ais-index>
    </div>

    <!-- tab navigation -->
    <navigation :currentTab="currentTab" @nav-click="changeTab"></navigation>
    <!-- stories tab -->
    <stories-tab
      :currentTab="currentTab"
      :isOpen="isOpen"
      :toggleFilters="toggleFilters"
      :checkTabStories="checkTabStories"
    ></stories-tab>

    <!-- media tab-->
    <media-tab
      :currentTab="currentTab"
      :isOpen="isOpen"
      :toggleFilters="toggleFilters"
      :checkTabMedia="checkTabMedia"
    ></media-tab>
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
import StoriesTab from './tabs/StoriesTab.vue';
import MediaTab from './tabs/MediaTab.vue';
import FacultyAccomplishmentsTab from './tabs/FacultyAccomplishmentsTab.vue';
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
      isOpen: false,
    };
  },
  computed: {
    checkTabStories() {
      return this.isOpen && this.currentTab === 'Stories';
    },
    checkTabMedia() {
      return this.isOpen && this.currentTab === 'Media Coverage';
    },
  },
  methods: {
    changeTab(tabName) {
      if (this.isOpen) {
        this.isOpen = false;
        setTimeout(() => {
          this.currentTab = tabName;
        }, 400);
      } else {
        this.currentTab = tabName;
      }
    },
    search(query) {
      // queries the query suggestion (this runs when clicking on the QS)
      this.$refs.searchBox.value = query;
      this.$refs.aisIS.instantSearchInstance.helper.setQuery(query).search();
    },
    removeExactQueryQuerySuggestion(items) {
      // checks if input matches query suggestion exactly and removes it from QS if it does
      const currentQuery =
        this.$refs.aisIS.instantSearchInstance.helper.state.query.toLowerCase();
      return items.filter((item) => item.query.toLowerCase() !== currentQuery);
    },
    toggleFilters() {
      this.isOpen = !this.isOpen;
    },
  },
};
</script>
<style>
.qs ol {
  display: flex;
  flex-direction: row;
}
.qs ol li.ais-Hits-item {
  margin-right: 12px;
  padding: 0.5rem;
  cursor: pointer;
  background-color: rgb(229 231 235);
  border-radius: 0.375rem;
  font-size: 0.875rem;
}
.qs ol li.ais-Hits-item:last-child {
  margin: 0;
}
</style>
