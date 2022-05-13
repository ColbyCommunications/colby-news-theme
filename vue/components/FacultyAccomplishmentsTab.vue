<template>
  <div
    v-show="currentTab === 'Faculty Accomplishments'"
    id="site-search-hits-container"
  >
    <ais-index index-name="prod_news_searchable_posts" index-id="faculty">
      <ais-configure
        :filters="'taxonomies.story_type:\'Faculty Accomplishments\''"
        :hits-per-page.camel="5"
      />
      <ais-hits>
        <template v-slot="{ items, sendEvent }">
          <ul>
            <li v-for="item in items" :key="item.objectID">
              <a
                class="group block text-base-minus-2 space-y-1.5"
                :href="item.external_url"
                @click="
                  sendEvent('click', item, 'Faculty Accomplishment Clicked')
                "
              >
                <div
                  class="!flex !flex-row pb-8 mb-12 border-b border-gray-700"
                >
                  <div>
                    <h2
                      class="group-hover:text-link-hover transition-colors font-bold text-base mb-5"
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
