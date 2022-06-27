<script>
/* eslint-disable vuejs-accessibility/anchor-has-content */
/* eslint-disable vuejs-accessibility/heading-has-content */

import Pagination from '../Pagination.vue';
import NoResults from '../NoResults.vue';
import { createWidgetMixin } from 'vue-instantsearch/vue3/es';
const connector = (renderFn, unmountFn) => () => ({
  init() {
    renderFn({ hasResult: true }, true);
  },

  render({ scopedResults, helper }) {
    const hasResult =
      scopedResults &&
      scopedResults.find(
        (indexResult) =>
          indexResult.indexId === 'faculty' && indexResult.results.nbHits > 0
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
    NoResults,
  },
  mixins: [createWidgetMixin({ connector })],
  props: {
    currentTab: { type: String, required: true },
  },
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
};
</script>
<template>
  <div
    v-show="currentTab === 'Faculty Accomplishments'"
    id="site-search-hits-container"
    :class="{ 'pt-10': currentTab === 'Faculty Accomplishments' }"
  >
    <div v-if="state">
      <ais-index index-name="prod_news_searchable_posts" index-id="faculty">
        <ais-configure
          :filters="'taxonomies.story_type:\'Faculty Accomplishments\''"
          :hits-per-page.camel="5"
        />
        <ais-hits>
          <template #default="{ items, sendEvent }">
            <ul v-show="state.hasResult">
              <li v-for="item in items" :key="item.objectID">
                <a
                  class="group block text-base-minus-2 space-y-1.5 hover:text-link-hover"
                  :href="item.external_url"
                  @click="
                    sendEvent('click', item, 'Faculty Accomplishment Clicked')
                  "
                >
                  <div
                    class="!flex !flex-row pb-8 mb-12 border-b border-gray-700"
                  >
                    <div>
                      <h2 class="font-bold text-base mb-5">
                        <ais-highlight attribute="post_title" :hit="item" />
                      </h2>
                      <p class="font-sans text-base">
                        <ais-snippet attribute="content" :hit="item" />
                      </p>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </template>
        </ais-hits>
        <div v-show="state.hasResult">
          <pagination></pagination>
        </div>
      </ais-index>
      <!-- no results -->
      <div v-show="!state.hasResult && state.query">
        <NoResults :query="state.query" />
      </div>
    </div>
  </div>
</template>
