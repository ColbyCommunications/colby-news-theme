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
          :hits-per-page.camel="4"
          query=""
        />
        <ais-hits>
          <template v-slot:item="{ item }">
            <div class="space-y-2 sm:space-y-4">
              <div class="relative sliding-teasers-container">
                <div class="-mx-container-gutter">
                  <div
                    class="test flex space-x-8 overflow-x-auto sliding-teasers pl-container-gutter"
                    style="
                      scroll-snap-type: x mandatory;
                      scroll-behavior: smooth;
                    "
                  >
                    <div
                      class="sliding-teaser min-h-[6.5rem] min-w-[16rem] max-w-[16rem]"
                      style="scroll-snap-align: center"
                    >
                      <div class="flex flex-col space-y-1 text-base-minus-2">
                        <div class="cursor-pointer">
                          <div class="relative group">
                            <div
                              class="after:content-empty after:absolute after:inset-0 after:bg-black after:bg-opacity-0 group-hover:after:bg-opacity-10 after:transition-colors"
                            >
                              <img
                                width="1080"
                                height="720"
                                :src="item.images.teaser_new.url"
                                class="attachment-teaser_new size-teaser_new"
                                loading="lazy"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="pt-1 text-sm uppercase">
                          {{ item.primary_category }}
                        </div>
                        <h3 class="font-bold">
                          {{ item.post_title }}
                        </h3>
                      </div>
                    </div>
                  </div>
                </div>
                <button
                  aria-hidden="true"
                  class="sliding-teasers-prev {{ buttonClasses }} left-0 2xl:-left-10"
                >
                  <svg
                    class="{{ svgClasses }} -translate-x-px"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                  >
                    <path
                      d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"
                    />
                  </svg>
                </button>

                <button
                  aria-hidden="true"
                  class="sliding-teasers-next {{ buttonClasses }} right-0 2xl:-right-10"
                >
                  <svg
                    class="{{ svgClasses }} translate-x-px"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                  >
                    <path
                      d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </template>
        </ais-hits>
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
  methods: {},

  mixins: [createWidgetMixin({ connector })],
};
</script>
