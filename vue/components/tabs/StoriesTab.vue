<template>
  <div v-show="currentTab === 'Stories'" id="site-search-hits-container">
    <div v-if="state">
      <ais-index index-name="prod_news_searchable_posts" index-id="stories">
        <ais-configure :filters="'post_type:post'" :hits-per-page.camel="5" />
        <stories-filter-section
          :currentTab="currentTab"
          :isOpen="isOpen"
          :toggleFilters="toggleFilters"
          :checkTabStories="checkTabStories"
          :hasResult="state.hasResult"
        ></stories-filter-section>
        <ais-hits>
          <template v-slot="{ items, sendEvent }">
            <ul v-show="state.hasResult">
              <li v-for="item in items" :key="item.objectID">
                <div
                  class="flex flex-col md:flex-row pb-8 mb-12 border-b border-gray-700"
                >
                  <div
                    class="w-full md:w-1/4 !m-0 !p-0 transition ease-in-out duration-300"
                    :class="{
                      'brightness-90': this.hover === item.objectID,
                    }"
                  >
                    <a :href="item.permalink">
                      <img
                        class="!object-cover"
                        :src="item.images.teaser_new.url"
                        @mouseover="hover = item.objectID"
                        @mouseleave="hover = null"
                        :alt="`${item.post_title}: ${item.summary}`"
                      />
                    </a>
                  </div>
                  <div class="w-full md:w-3/4 md:ml-4">
                    <a
                      class="font-sans text-xs mb-1.5 uppercase hover:text-link-hover"
                      :href="`https://news.colby.edu/story/category/${item.primary_category.replace(
                        /\s+/g,
                        '-'
                      )}`"
                      >{{ item.primary_category }}</a
                    >
                    <a
                      :href="item.permalink"
                      :class="{
                        'text-link-hover': this.hover === item.objectID,
                      }"
                      @mouseover="hover = item.objectID"
                      @mouseleave="hover = null"
                      @click="sendEvent('click', item, 'Story Clicked')"
                    >
                      <h2 class="font-bold text-base mb-1.5">
                        <ais-highlight attribute="post_title" :hit="item" />
                      </h2>
                      <p class="font-sans text-base">
                        <ais-snippet attribute="content" :hit="item" />
                      </p>
                    </a>
                  </div>
                </div>
              </li>
            </ul>
          </template>
        </ais-hits>
        <pagination></pagination>
      </ais-index>
      <!-- no results -->
      <div v-show="!state.hasResult && state.query">
        <NoResults :query="state.query" />
      </div>
    </div>
  </div>
</template>
<script>
import Pagination from '../Pagination.vue';
import StoriesFilterSection from '../StoriesFilterSection.vue';
import NoResults from '../NoResults.vue';
import { createWidgetMixin } from 'vue-instantsearch/vue3/es';

const connector =
  (renderFn, unmountFn) =>
  (widgetParams = {}) => ({
    init({}) {
      renderFn({ hasResult: true }, true);
    },

    render({ scopedResults, helper }) {
      const hasResult =
        scopedResults &&
        scopedResults.find(
          (indexResult) =>
            indexResult.indexId === 'stories' && indexResult.results.nbHits > 0
        );

      renderFn(
        {
          hasResult,
          query: helper.state.query,
        },
        false
      );
    },

    dispose() {
      unmountFn();
    },
  });
export default {
  components: {
    Pagination,
    StoriesFilterSection,
    NoResults,
  },
  props: ['currentTab', 'isOpen', 'toggleFilters', 'checkTabStories'],
  data() {
    return {
      hover: null,
    };
  },
  methods: {
    getTeaserPair(items) {
      return items.slice(0, 2);
    },
    getTeaserSlider(items) {
      return items.slice(2, items.length + 1);
    },
    slidePrev() {
      const slidingTeasers = this.$refs.slidingTeasers;
      const slidingTeasersWidth = this.$refs.slidingTeasers.scrollWidth;
      const teasersLength = this.$refs.slidingTeasers.children.length;
      const x = slidingTeasersWidth / teasersLength;
      slidingTeasers.scrollLeft -= x;
    },
    slideNext() {
      const slidingTeasers = this.$refs.slidingTeasers;
      const slidingTeasersWidth = this.$refs.slidingTeasers.scrollWidth;
      const teasersLength = this.$refs.slidingTeasers.children.length;
      const x = slidingTeasersWidth / teasersLength;
      slidingTeasers.scrollLeft += x;
    },
  },
  mixins: [createWidgetMixin({ connector })],
};
</script>
