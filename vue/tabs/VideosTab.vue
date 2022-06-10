<template>
  <div
    v-show="currentTab === 'Videos'"
    id="site-search-hits-container"
    class="pt-10"
  >
    <ais-index index-name="prod_news_videos" index-id="videos">
      <ais-configure :hits-per-page.camel="5" />
      <ais-hits>
        <template v-slot="{ items, sendEvent }">
          <ul v-if="items.length > 0">
            <li v-for="item in items" :key="item.objectID">
              <div class="!flex !flex-row pb-8 mb-12 border-b border-gray-700">
                <div
                  class="!w-1/4 !m-0 !p-0 transition ease-in-out duration-300"
                  :class="{
                    'brightness-90': this.hover === item.objectID,
                  }"
                  v-if="item.thumbnail"
                >
                  <a
                    :href="`https://www.youtube.com/watch?v=${item.objectID}`"
                    :target="'_blank'"
                  >
                    <img
                      class="!object-cover"
                      :src="item.thumbnail.url"
                      @mouseover="hover = item.objectID"
                      @mouseleave="hover = null"
                      :alt="item.title"
                    />
                  </a>
                </div>
                <div class="w-3/4">
                  <a
                    :href="`https://www.youtube.com/watch?v=${item.objectID}`"
                    :class="{
                      'text-link-hover': this.hover === item.objectID,
                    }"
                    @mouseover="hover = item.objectID"
                    @mouseleave="hover = null"
                    @click="sendEvent('click', item, 'Story Clicked')"
                    :target="'_blank'"
                  >
                    <h2
                      :class="[
                        'thumbnail' in item ? 'pl-6' : 'pl-0',
                        'font-bold',
                        'text-base',
                        'mb-1.5',
                      ]"
                    >
                      <ais-highlight attribute="title" :hit="item" />
                    </h2>
                  </a>
                  <p
                    :class="[
                      'thumbnail' in item ? 'pl-6' : 'pl-0',
                      'font-sans',
                      'text-base',
                    ]"
                  >
                    <ais-snippet attribute="description" :hit="item" />
                  </p>
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
