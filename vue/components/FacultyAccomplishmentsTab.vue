<template>
  <div v-if="currentTab === 'faculty'" id="site-search-hits-container">
    <ais-configure
      :filters="'taxonomies.story_type:\'Faculty Accomplishments\''"
      :hits-per-page.camel="4"
    />
    <ais-hits class="mt-10 sm:mt-16">
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
              <div class="!flex !flex-row pb-8 mb-12 border-b border-gray-700">
                <div class="w-3/4 pl-6">
                  <h2
                    class="group-hover:text-link-hover transition-colors font-bold text-base mb-5"
                    v-html="item.post_title"
                  ></h2>
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
