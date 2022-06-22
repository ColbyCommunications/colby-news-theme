<template>
  <div
    v-show="currentTab === 'Videos'"
    id="site-search-hits-container"
    class="pt-10"
  >
    <div v-if="state">
      <div v-show="state.hasResult">
        <ais-index index-name="prod_news_videos" index-id="videos">
          <ais-configure :hits-per-page.camel="5" />
          <ais-hits>
            <template v-slot="{ items, sendEvent }">
              <ul>
                <li v-for="item in items" :key="item.objectID">
                  <div
                    class="flex flex-col md:flex-row pb-8 mb-12 border-b border-gray-700"
                  >
                    <div
                      class="w-full mt-4 md:w-1/4 !m-0 !p-0 transition ease-in-out duration-300"
                      :class="{
                        'brightness-90': this.hover === item.objectID,
                      }"
                      v-if="item.thumbnail"
                    >
                      <a
                        :href="`https://www.youtube.com/watch?v=${item.objectID}`"
                        :target="'_blank'"
                        @click="sendEvent('click', item, 'Video Clicked')"
                      >
                        <img
                          class="!object-cover"
                          :src="item.thumbnail.url"
                          @mouseover="hover = item.objectID"
                          @mouseleave="hover = null"
                          :alt="item.title"
                        />
                      </a>
                    </div>
                    <div class="w-full md:w-3/4 md:ml-4">
                      <a
                        :href="`https://www.youtube.com/watch?v=${item.objectID}`"
                        :class="{
                          'text-link-hover': this.hover === item.objectID,
                        }"
                        @mouseover="hover = item.objectID"
                        @mouseleave="hover = null"
                        @click="sendEvent('click', item, 'Video Clicked')"
                        :target="'_blank'"
                      >
                        <h2
                          :class="[
                            'thumbnail' in item ? 'pl-0 md:pl-6' : 'pl-0',
                            'font-bold',
                            'text-base',
                            'mb-1.5',
                          ]"
                        >
                          <ais-highlight attribute="title" :hit="item" />
                        </h2>

                        <p
                          :class="[
                            'thumbnail' in item ? 'pl-0 md:pl-6' : 'pl-0',
                            'font-sans',
                            'text-base',
                          ]"
                        >
                          <ais-snippet attribute="description" :hit="item" /></p
                      ></a>
                    </div>
                  </div>
                </li>
              </ul>
            </template>
          </ais-hits>
          <pagination></pagination>
        </ais-index>
      </div>
      <div v-show="!state.hasResult && state.query">
        <NoResults :query="state.query" />
      </div>
    </div>
  </div>
</template>
<script>
import Pagination from '../components/Pagination.vue';
import NoResults from '../components/NoResults.vue';
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
            indexResult.indexId === 'videos' && indexResult.results.nbHits > 0
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
  props: ['currentTab'],
  data() {
    return {
      hover: null,
    };
  },
  mixins: [createWidgetMixin({ connector })],
};
</script>
