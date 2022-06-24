<template>
  <div>
    <ais-instant-search
      index-name="prod_news_searchable_posts"
      :search-client="searchClient"
    >
      <h2 class="text-h2-prose mb-5">Recommended for You</h2>
      <div>
        <ais-index
          index-name="prod_news_searchable_posts"
          index-id="noresult-videos"
        >
          <ais-configure
            :hits-per-page.camel="12"
            query=""
            :filters="'post_type:post'"
          />
          <div>
            <div class="wp-block nc-slider-with-teaser-pair">
              <ais-hits>
                <template #default="{ items }">
                  <div class="mb-10">
                    <div class="grid md:grid-cols-2 gap-8">
                      <div
                        v-for="item in items.slice(0, 2)"
                        :key="item.objectID"
                      >
                        <div class="flex flex-col space-y-1 text-base-minus-2">
                          <div class="cursor-pointer">
                            <div class="relative group">
                              <a :href="item.permalink">
                                <img
                                  :src="item.images.teaser_new.url"
                                  class="hover:brightness-90 transition ease-in-out duration-300"
                                  :alt="`${item.post_title}: ${item.summary}`"
                                />
                              </a>
                            </div>
                          </div>
                          <div class="pt-1 text-sm uppercase">
                            <a
                              :href="`https://news.colby.edu/story/category/${item.primary_category.replace(
                                /\s+/g,
                                '-'
                              )}`"
                              >{{ item.primary_category }}</a
                            >
                          </div>

                          <h3 class="font-bold">
                            <a :href="item.permalink">{{ item.post_title }}</a>
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- slider -->

                  <div class="">
                    <div class="space-y-2 sm:space-y-4">
                      <div class="relative sliding-teasers-container">
                        <div class="-mx-container-gutter" style="">
                          <ul
                            ref="slidingTeasers"
                            class="flex space-x-8 overflow-x-auto sliding-teasers pl-container-gutter"
                            style="
                              scroll-snap-type: x mandatory;
                              scroll-behavior: smooth;
                            "
                          >
                            <!-- teaser -->
                            <li
                              v-for="item in items.slice(2, items.length)"
                              :key="item.objectID"
                              class="sliding-teaser min-h-[6.5rem] min-w-[16rem] max-w-[16rem]"
                              style="scroll-snap-align: center"
                            >
                              <div class="cursor-pointer">
                                <div class="relative group">
                                  <a :href="item.permalink">
                                    <img
                                      width="1080"
                                      height="720"
                                      :src="item.images.teaser_new.url"
                                      class="attachment-teaser_new size-teaser_new hover:brightness-90 transition ease-in-out duration-300"
                                      sizes="(max-width: 1080px) 100vw, 1080px"
                                      :alt="`${item.post_title}: ${item.summary}`"
                                    />
                                  </a>
                                </div>
                              </div>
                              <div class="pt-1 text-sm uppercase">
                                <a
                                  :href="`https://news.colby.edu/story/category/${item.primary_category.replace(
                                    /\s+/g,
                                    '-'
                                  )}`"
                                  >{{ item.primary_category }}</a
                                >
                              </div>
                              <h3 class="font-bold">
                                <a :href="item.permalink">{{
                                  item.post_title
                                }}</a>
                              </h3>
                            </li>
                          </ul>
                        </div>
                        <button
                          aria-hidden="true"
                          class="sliding-teasers-prev absolute rounded-full p-1.5 border bg-white hover:bg-gray-300 transition-colors top-16 left-0 2xl:-left-10"
                          @click="slidePrev"
                        >
                          <svg
                            class="w-4 h-4 transform -translate-x-px"
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
                          class="sliding-teasers-next absolute rounded-full p-1.5 border bg-white hover:bg-gray-300 transition-colors top-16 right-0 2xl:-right-10"
                          @click="slideNext"
                        >
                          <svg
                            class="w-4 h-4 transform translate-x-px"
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
                  </div>
                </template>
              </ais-hits>
            </div>
          </div>
        </ais-index>
      </div>
    </ais-instant-search>
  </div>
</template>
<script>
import algoliasearch from 'algoliasearch/lite';
import { createInsightsMiddleware } from 'instantsearch.js/es/middlewares';
const insightsMiddleware = createInsightsMiddleware({
  // eslint-disable-next-line no-undef
  insightsClient: aa,
});
// eslint-disable-next-line no-undef
aa('init', {
  appId: '2XJQHYFX2S',
  apiKey: '63c304c04c478fd0c4cb1fb36cd666cb',
  useCookie: true,
  cookieDuration: 15552000000,
});
export default {
  components: {},
  data() {
    return {
      middlewares: [insightsMiddleware],
      searchClient: algoliasearch(
        '2XJQHYFX2S',
        '63c304c04c478fd0c4cb1fb36cd666cb'
      ),
    };
  },
  computed: {},
  methods: {
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
<style></style>
