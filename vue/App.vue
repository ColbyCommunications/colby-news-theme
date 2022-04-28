<template>
  <ais-instant-search
    index-name="prod_news_searchable_posts"
    :search-client="searchClient"
    :middlewares="middlewares"
  >
    <ais-configure :filters="'post_type:post'" :hits-per-page.camel="4" />
    <!-- Widgets -->
    <ais-search-box
      id="site-search-searchbox"
      placeholder="Start typing to search"
      submit-title="Search"
    >
      <template v-slot:submit-icon>SEARCH</template>
    </ais-search-box>
    <div id="site-search-hits-container">
      <ais-hits class="ais-InfiniteHits-loadMore mt-10 sm:mt-16">
        <template v-slot="{ items, sendEvent }">
          <ul>
            <li v-for="item in items" :key="item.objectID">
              <a
                class="group block text-base-minus-2 space-y-1.5"
                :href="item.permalink"
                @click="sendEvent('click', item, 'Story Clicked')"
              >
                <div
                  class="!flex !flex-row pb-8 mb-12 border-b border-gray-300"
                >
                  <div class="!w-1/4 !m-0 !p-0">
                    <img
                      class="!object-cover"
                      :src="item.images.teaser_new.url"
                    />
                  </div>
                  <div class="w-3/4 pl-6">
                    <h2
                      class="group-hover:text-link-hover transition-colors font-bold text-xl mb-5"
                    >
                      {{ item.post_title }}
                    </h2>
                    <h3 class="font-sans text-base">
                      {{ item.taxonomies.category }}
                    </h3>
                    <p class="font-sans text-base">
                      {{ item.summary }}
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </template>
      </ais-hits>
    </div>
    <div>
      <ais-pagination>
        <template
          v-slot="{
            currentRefinement,
            nbPages,
            pages,
            isFirstPage,
            isLastPage,
            refine,
            createURL,
          }"
        >
          <ul class="flex flex-row items-center justify-end">
            <li class="w-32">
              <p :style="paginationText">
                {{ `Page ${currentRefinement + 1} of ${nbPages}` }}
              </p>
            </li>
            <li class="relative bottom-1">
              <a
                class="text-5xl"
                :href="createURL(currentRefinement - 1)"
                @click.prevent="refine(currentRefinement - 1)"
                :style="{ color: isFirstPage ? '#D8D8D8' : 'black' }"
              >
                ‹
              </a>
              <a
                class="text-5xl"
                :href="createURL(currentRefinement + 1)"
                @click.prevent="refine(currentRefinement + 1)"
                :style="{ color: isLastPage ? '#D8D8D8' : 'black' }"
              >
                ›
              </a>
            </li>
          </ul>
        </template>
      </ais-pagination>
    </div>
  </ais-instant-search>
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
});

aa('init', {
  appId: '2XJQHYFX2S',
  apiKey: '63c304c04c478fd0c4cb1fb36cd666cb',
  useCookie: true,
});

export default {
  data() {
    return {
      paginationText: {
        fontSize: '15px',
      },
      middlewares: [insightsMiddleware],
      searchClient: algoliasearch(
        '2XJQHYFX2S',
        '63c304c04c478fd0c4cb1fb36cd666cb'
      ),
    };
  },
};
</script>
