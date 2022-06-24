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
            <ul v-show="state.hasResult" class="pb-10">
              <li v-for="(item, index) in items" :key="item.objectID">
                <a
                  class="group block text-base-minus-2 space-y-1.5 hover:text-link-hover"
                  :href="item.external_url"
                  @click="sendEvent('click', item, 'External Media Clicked')"
                >
                  <div
                    :class="[
                      'post-list-item',
                      'border-b',
                      'border-gray-700',
                      index !== 0 ? 'py-8' : 'pt-0 pb-8',
                    ]"
                  >
                    <div class="space-y-2">
                      <div
                        class="grid gap-x-4 gap-y-2 media-coverage-item-grid--standard"
                      >
                        <div class="lg:self-center lg:mx-auto logo-wrapper">
                          <div class="lg:w-24">
                            <div>
                              <img
                                class=""
                                :src="item.external_image"
                                :alt="item.media_source"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="superhead-wrapper">
                          <div class="text-xs uppercase">
                            {{ item.media_source }}
                          </div>
                        </div>
                        <div class="space-y-1 title-wrapper lg:space-y-2">
                          <h3 class="leading-tight">
                            <ais-highlight attribute="post_title" :hit="item" />
                          </h3>
                        </div>
                        <div class="blurb-wrapper">
                          <div class="text-base-minus-2 lg:text-base">
                            <ais-snippet attribute="content" :hit="item" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
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
