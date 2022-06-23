<template>
  <div v-show="currentTab === 'Media Coverage'" id="site-search-hits-container">
    <div v-if="state">
      <ais-index index-name="prod_news_searchable_posts" index-id="media">
        <ais-configure
          :filters="'taxonomies.story_type:\'Media Coverage\''"
          :hits-per-page.camel="5"
        />
        <media-filter-section
          :currentTab="currentTab"
          :isOpen="isOpen"
          :toggleFilters="toggleFilters"
          :checkTabMedia="checkTabMedia"
          :hasResult="state.hasResult"
        ></media-filter-section>
        <ais-hits>
          <template v-slot="{ items, sendEvent }">
            <ul v-show="state.hasResult">
              <li v-for="item in items" :key="item.objectID">
                <a
                  class="group block text-base-minus-2 space-y-1.5 hover:text-link-hover"
                  :href="item.external_url"
                  @click="sendEvent('click', item, 'External Media Clicked')"
                >
                  <div
                    class="!flex !flex-row pb-16 mb-12 border-b border-gray-700"
                  >
                    <div class="!w-1/8 !m-0 !p-0 flex justify-center">
                      <img class="external-image" :src="item.external_image" />
                    </div>
                    <div class="w-7/8">
                      <h3 class="pl-6 font-sans text-xs mb-1.5 uppercase">
                        {{ item.media_source }}
                      </h3>
                      <h2 class="pl-6 font-bold text-base mb-1.5">
                        <ais-highlight attribute="post_title" :hit="item" />
                      </h2>
                      <p class="pl-6 font-sans text-base">
                        <ais-snippet attribute="content" :hit="item" />
                      </p>
                    </div>
                  </div>
                </a>
              </li>
              <pagination></pagination>
            </ul>
          </template>
        </ais-hits>
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
import MediaFilterSection from '../MediaFilterSection.vue';
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
            indexResult.indexId === 'media' && indexResult.results.nbHits > 0
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
    MediaFilterSection,
    NoResults,
  },
  props: ['currentTab', 'isOpen', 'toggleFilters', 'checkTabMedia'],
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
