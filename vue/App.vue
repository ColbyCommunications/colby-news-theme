<template>
  <ais-instant-search
    index-name="prod_news_searchable_posts"
    :search-client="searchClient"
  >
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
        <template v-slot="{ items }">
          <ul>
            <li v-for="item in getPost" :key="item.objectID">
              <h2>{{ item.post_type }}</h2>
            </li>
          </ul>
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
  computed: {
    getPost: function (items) {
      return items.filter((p) => p.post_type === 'post');
    },
  },
};
</script>
