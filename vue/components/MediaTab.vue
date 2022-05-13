<template>
  <div v-show="currentTab === 'Media Coverage'" id="site-search-hits-container">
    <ais-index index-name="prod_news_searchable_posts" index-id="media">
      <ais-configure
        :filters="'taxonomies.story_type:\'Media Coverage\''"
        :hits-per-page.camel="5"
      />
      <ais-hits>
        <template v-slot="{ items, sendEvent }">
          <ul>
            <li v-for="item in items" :key="item.objectID">
              <a
                class="group block text-base-minus-2 space-y-1.5"
                :href="item.external_url"
                @click="sendEvent('click', item, 'External Media Clicked')"
              >
                <div
                  class="!flex !flex-row pb-16 mb-12 border-b border-gray-700"
                >
                  <div class="!w-1/8 !m-0 !p-0 flex justify-center">
                    <img class="external-image" :src="item.external_image" />
                  </div>
                  <div class="w-7/8 pl-6">
                    <h3 class="font-sans text-xs mb-1.5 uppercase">
                      {{ item.media_source }}
                    </h3>
                    <h2
                      class="group-hover:text-link-hover transition-colors font-bold text-base mb-1.5"
                    >
                      <ais-highlight attribute="post_title" :hit="item" />
                    </h2>
                    <p class="font-sans text-base">
                      <ais-snippet attribute="content" :hit="item" />
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </template>
      </ais-hits>
      <pagination></pagination>
    </ais-index>
  </div>
</template>
<script>
import Pagination from './Pagination.vue';
export default {
  components: {
    Pagination,
  },
  props: ['currentTab'],
  data() {
    return {};
  },
};
</script>
