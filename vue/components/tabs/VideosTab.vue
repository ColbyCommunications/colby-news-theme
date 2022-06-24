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
  mixins: [createWidgetMixin({ connector })],
  props: {
    currentTab: { type: String, required: true },
  },
  data() {
    return {
      hover: null,
    };
  },
};
</script>
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
            <template #default="{ items, sendEvent }">
              <ul>
                <li v-for="item in items" :key="item.objectID">
                  <div
                    class="flex flex-col md:flex-row pb-8 mb-12 border-b border-gray-700"
                  >
                    <div
                      v-if="item.thumbnail"
                      class=""
                      :class="[
                        hover === item.objectID ? 'brightness-90' : '',
                        'w-full',
                        'mt-4',
                        'md:w-1/4',
                        '!m-0',
                        '!p-0',
                        'transition',
                        'ease-in-out',
                        'duration-300',
                      ]"
                    >
                      <a
                        :href="`https://www.youtube.com/watch?v=${item.objectID}`"
                        :target="'_blank'"
                        @click="sendEvent('click', item, 'Video Clicked')"
                      >
                        <img
                          :alt="item.title"
                          class="!object-cover"
                          :src="item.thumbnail.url"
                          @mouseover="hover = item.objectID"
                          @focus="hover = item.objectID"
                          @mouseleave="hover = null"
                          @blur="hover = null"
                        />
                      </a>
                    </div>
                    <div class="w-full mt-4 md:mt-0 md:w-3/4 md:ml-4">
                      <a
                        :href="`https://www.youtube.com/watch?v=${item.objectID}`"
                        :class="{
                          'text-link-hover': hover === item.objectID,
                        }"
                        :target="'_blank'"
                        @mouseover="hover = item.objectID"
                        @focus="hover = item.objectID"
                        @mouseleave="hover = null"
                        @blur="hover = null"
                        @click="sendEvent('click', item, 'Video Clicked')"
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
          <div v-show="state.hasResult">
            <pagination></pagination>
          </div>
        </ais-index>
      </div>
      <div v-show="!state.hasResult && state.query">
        <NoResults :query="state.query" />
      </div>
    </div>
  </div>
</template>
