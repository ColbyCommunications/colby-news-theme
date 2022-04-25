<template>
  <ais-instant-search
    index-name="prod_news_searchable_posts"
    :search-client="searchClient"
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
      <ais-infinite-hits class="ais-InfiniteHits-loadMore mt-10 sm:mt-16">
        <template v-slot:item="{ item }">
          <a
            class="group block text-base-minus-2 space-y-1.5"
            :href="item.permalink"
          >
            <div class="!flex !flex-row">
              <div class="!w-80 !m-0 !p-0">
                <img class="!object-cover" :src="item.images.teaser_new.url" />
              </div>
              <div class="w-80">
                <h2
                  class="group-hover:text-link-hover transition-colors font-bold text-lg mb-6"
                >
                  {{ item.post_title }}
                </h2>
                <h3>
                  {{ item.taxonomies.category }}
                </h3>
                <p>
                  {{ item.summary }}
                </p>
              </div>
            </div>
          </a>
        </template>
      </ais-infinite-hits>
    </div>
  </ais-instant-search>
</template>

<script>
import algoliasearch from 'algoliasearch/lite';

export default {
  data() {
    return {
      searchClient: algoliasearch(
        '2XJQHYFX2S',
        '63c304c04c478fd0c4cb1fb36cd666cb'
      ),
    };
  },
};
</script>
