<script>
/* eslint-disable vuejs-accessibility/anchor-has-content */
/* eslint-disable vuejs-accessibility/heading-has-content */
import Pagination from '../Pagination.vue';
import MediaFilterSection from '../MediaFilterSection.vue';
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
  mixins: [createWidgetMixin({ connector })],
  props: {
    currentTab: { type: String, required: true },
    isOpen: { type: Boolean, required: true },
    toggleFilters: { type: Function, required: true },
    checkTabMedia: { type: Boolean, required: true },
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
    v-show="currentTab === 'Media Coverage'"
    id="media-coverage-hits-container"
  >
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
          :hasResult="state.hasResult ? state.hasResult : false"
        />
        <ais-hits>
          <template v-slot="{ items, sendEvent }">
            <ul v-show="state.hasResult" class="pb-10 space-y-2">
              <li v-for="(item, index) in items" :key="item.objectID">
                <a
                  :href="item.external_url"
                  @click="sendEvent('click', item, 'External Media Clicked')"
                  class="block hover:text-link-hover"
                >
                  <!-- Outer container: border + flex -->
                  <div
                    :class="[
                      'border-b border-gray-700',
                      index !== 0 ? 'py-8' : 'pt-0 pb-8',
                      'flex flex-col',
                    ]"
                  >
                    <!-- Header row: image + superhead/title -->
                    <div class="flex flex-row gap-x-4 lg:gap-x-9 items-start">
                      <!-- Image column -->
                      <div class="flex-shrink-0">
                        <div v-if="item.external_image" class="w-24">
                          <img
                            :src="item.external_image"
                            :alt="item.media_source"
                          />
                        </div>
                      </div>

                      <!-- Header column: superhead + title -->
                      <div class="flex-1 flex flex-col space-y-1">
                        <div v-if="item.media_source" class="text-xs uppercase">
                          {{ item.media_source }}
                        </div>
                        <h3 class="leading-tight font-bold">
                          <ais-highlight attribute="post_title" :hit="item" />
                        </h3>

                        <!-- Content for medium+ screens -->
                        <div class="mt-2 md:mt-4 hidden md:block">
                          <div class="text-base-minus-2 lg:text-base">
                            <ais-snippet attribute="content" :hit="item" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Content for small screens -->
                    <div class="mt-2 md:hidden w-full">
                      <div class="text-base-minus-2 lg:text-base">
                        <ais-snippet attribute="content" :hit="item" />
                      </div>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </template>
        </ais-hits>

        <!-- Pagination -->
        <div v-show="state.hasResult">
          <pagination />
        </div>

        <!-- No results -->
        <div v-show="!state.hasResult && state.query">
          <NoResults :query="state.query" />
        </div>
      </ais-index>
    </div>
  </div>
</template>
