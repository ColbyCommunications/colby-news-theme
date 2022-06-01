<template>
  <div v-show="currentTab === 'Stories'" id="site-search-hits-container">
    <ais-index index-name="prod_news_searchable_posts" index-id="stories">
      <ais-configure :filters="'post_type:post'" :hits-per-page.camel="5" />
      <stories-filter-section
        :currentTab="currentTab"
        :isOpen="isOpen"
        :toggleFilters="toggleFilters"
        :checkTabStories="checkTabStories"
      ></stories-filter-section>
      <ais-hits>
        <template v-slot="{ items, sendEvent }">
          <ul>
            <li v-for="item in items" :key="item.objectID">
              <div class="!flex !flex-row pb-8 mb-12 border-b border-gray-700">
                <div
                  class="!w-1/4 !m-0 !p-0 transition ease-in-out duration-300"
                  :class="{
                    'brightness-90': this.hover === item.objectID,
                  }"
                >
                  <a :href="item.permalink">
                    <img
                      class="!object-cover"
                      :src="item.images.teaser_new.url"
                      @mouseover="hover = item.objectID"
                      @mouseleave="hover = null"
                      :alt="item.post_title"
                    />
                  </a>
                </div>
                <div class="w-3/4">
                  <a
                    class="pl-6 font-sans text-xs mb-1.5 uppercase hover:text-link-hover"
                    :href="`https://news.colby.edu/story/category/${item.primary_category.replace(
                      /\s+/g,
                      '-'
                    )}`"
                    >{{ item.primary_category }}</a
                  >
                  <a
                    :href="item.permalink"
                    :class="{
                      'text-link-hover': this.hover === item.objectID,
                    }"
                    @mouseover="hover = item.objectID"
                    @mouseleave="hover = null"
                    @click="sendEvent('click', item, 'Story Clicked')"
                  >
                    <h2 class="pl-6 font-bold text-base mb-1.5">
                      <ais-highlight attribute="post_title" :hit="item" />
                    </h2>
                    <p class="pl-6 font-sans text-base">
                      <ais-snippet attribute="content" :hit="item" />
                    </p>
                  </a>
                </div>
              </div>
            </li>
          </ul>
        </template>
      </ais-hits>
      <pagination></pagination>
    </ais-index>
  </div>
</template>
<script>
import Pagination from '../components/Pagination.vue';
import StoriesFilterSection from '../components/StoriesFilterSection.vue';
export default {
  components: {
    Pagination,
    StoriesFilterSection,
  },
  props: ['currentTab', 'isOpen', 'toggleFilters', 'checkTabStories'],
  data() {
    return {
      hover: null,
    };
  },
};
</script>
