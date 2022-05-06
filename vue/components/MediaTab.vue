<template>
  <div v-if="currentTab === 'media'" id="site-search-hits-container">
    <ais-configure
      :filters="'taxonomies.story_type:\'Media Coverage\''"
      :hits-per-page.camel="4"
    />
    <ais-hits class="mt-10 sm:mt-16">
      <template v-slot="{ items, sendEvent }">
        <ul>
          <li v-for="item in items" :key="item.objectID">
            <a
              class="group block text-base-minus-2 space-y-1.5"
              :href="item.external_url"
              @click="sendEvent('click', item, 'External Media Clicked')"
            >
              <div class="!flex !flex-row pb-8 mb-12 border-b border-gray-300">
                <div class="!w-1/8 !m-0 !p-0 flex justify-center">
                  <img class="external-image" :src="item.external_image" />
                </div>
                <div class="w-7/8 pl-6">
                  <h2
                    class="group-hover:text-link-hover transition-colors font-bold text-xl mb-5"
                    v-html="item.post_title"
                  ></h2>
                  <h3 class="font-sans text-16 mb-1.5">
                    {{ item.taxonomies.media_source.toString().toUpperCase() }}
                  </h3>
                  <p class="font-sans text-base">
                    {{ item.content }}
                  </p>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </template>
    </ais-hits>
  </div>
</template>
<script>
export default {
  props: ['currentTab'],
  data() {
    return {};
  },
};
</script>
