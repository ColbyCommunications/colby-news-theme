<template>
  <div v-show="currentTab === 'Stories'" id="site-search-hits-container">
    <ais-index index-name="prod_news_searchable_posts" index-id="stories">
      <ais-configure :filters="'post_type:post'" :hits-per-page.camel="5" />
      <settings
        :currentTab="currentTab"
        :isOpen="isOpen"
        :toggleFilters="toggleFilters"
        :checkTabStories="checkTabStories"
      ></settings>
      <ais-hits>
        <template v-slot="{ items, sendEvent }">
          <ul>
            <li v-for="item in items" :key="item.objectID">
              <a
                class="group block text-base-minus-2 space-y-1.5"
                :href="item.permalink"
                @click="sendEvent('click', item, 'Story Clicked')"
              >
                <div
                  class="!flex !flex-row pb-8 mb-12 border-b border-gray-700"
                >
                  <div class="!w-1/4 !m-0 !p-0">
                    <img
                      class="!object-cover"
                      :src="item.images.teaser_new.url"
                    />
                  </div>
                  <div class="w-3/4 pl-6">
                    <h3 class="font-sans text-xs mb-1.5 uppercase">
                      {{ item.primary_category }}
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
import Settings from './Settings.vue';
export default {
  components: {
    Pagination,
    Settings,
  },
  props: ['currentTab', 'isOpen', 'toggleFilters', 'checkTabStories'],
  data() {
    return {};
  },
};
</script>
