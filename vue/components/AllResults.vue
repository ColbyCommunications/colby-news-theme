<template>
  <div v-if="state">
    <div v-show="state.hasResult"><slot></slot></div>
    <div v-show="!state.hasResult && state.query">
      <h2 class="py-8 text-lg">
        <b>No results found for {{ state.query }}.</b>
      </h2>
      <h2 class="pb-8">Recommended for you</h2>

      <ais-index index-name="prod_news_searchable_posts" index-id="noresult">
        <ais-configure
          :filters="'post_type:post'"
          :hits-per-page.camel="10"
          query=""
        />
        <div class="wp-block">
          <div class="wp-block nc-slider-with-teaser-pair">
            <div class="mb-10">
              <ais-hits :transform-items="getTeaserPair">
                <template v-slot="{ items }">
                  <div class="grid md:grid-cols-2 gap-8">
                    <div v-for="item in items" :key="item.objectID">
                      <div class="flex flex-col space-y-1 text-base-minus-2">
                        <div class="cursor-pointer">
                          <div class="relative group">
                            <div
                              class="after:content-empty after:absolute after:inset-0 after:bg-black after:bg-opacity-0 group-hover:after:bg-opacity-10 after:transition-colors"
                            >
                              <img :src="item.images.teaser_new.url" />
                            </div>
                          </div>
                        </div>
                        <div class="pt-1 text-sm uppercase">
                          <a>{{ item.primary_category }}</a>
                        </div>

                        <h3 class="font-bold">
                          <a>{{ item.post_title }}</a>
                        </h3>
                      </div>
                    </div>
                  </div>
                </template>
              </ais-hits>

              <ais-hits :transform-items="getTeaserSlider">
                <template v-slot:item="{ item }">
                  {{ item.post_title }}
                </template>
              </ais-hits>
            </div>
          </div>
        </div>
      </ais-index>
    </div>
  </div>
</template>

<script>
import { createWidgetMixin } from 'vue-instantsearch/vue3/es';
import { provide, computed, ref } from 'vue';

/*
        <div v-show="state.hasResult"><slot></slot></div>
        <div v-show="!state.hasResult">Oups</div>
*/

const connector =
  (renderFn, unmountFn) =>
  (widgetParams = {}) => ({
    init({}) {
      renderFn({ hasResult: true }, true);
    },

    render({ scopedResults, helper }) {
      const hasResult =
        scopedResults &&
        scopedResults.some(
          (indexResult) =>
            indexResult.indexId !== 'noresult' && indexResult.results.nbHits > 0
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
  props: {},
  data() {
    return {};
  },
  methods: {
    getTeaserPair(items) {
      return items.slice(0, 2);
    },
    getTeaserSlider(items) {
      return items.slice(2, items.length - 1);
    },
  },

  mixins: [createWidgetMixin({ connector })],
};
</script>
