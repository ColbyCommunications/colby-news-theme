<template>
  <div>
    <ais-instant-search
      index-name="prod_news_searchable_posts"
      :search-client="searchClient"
    >
      <h2 class="text-h2-prose">Recommended for you</h2>
      <div class="wp-block">
        <ais-index
          index-name="prod_news_searchable_posts"
          index-id="noresult-videos"
        >
          <ais-configure
            :hits-per-page.camel="10"
            query=""
            :filters="'post_type:post'"
          />
          <ais-hits>
            <template v-slot="{ items, sendEvent }">
              <!-- slider -->
              <div class="wp-block">
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
                          v-for="item in items"
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
        </ais-index>
      </div>
    </ais-instant-search>
  </div>
</template>
<script>
import algoliasearch from 'algoliasearch/lite';
import { createInsightsMiddleware } from 'instantsearch.js/es/middlewares';
const insightsMiddleware = createInsightsMiddleware({
  insightsClient: aa,
});
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
