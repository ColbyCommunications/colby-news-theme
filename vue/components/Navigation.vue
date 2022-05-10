<template>
  <nav>
    <ul class="Tabs">
      <li
        @click="$emit('navClick', 'stories')"
        class="text-xl Tabs__tab Tab"
        v-bind:class="{ 'activeTab': currentTab === 'stories' }"
      >
        <button>Stories</button>
      </li>
      <li
        @click="$emit('navClick', 'media')"
        class="text-xl Tabs__tab Tab"
        v-bind:class="{ 'activeTab': currentTab === 'media' }"
      >
        <button>Media Coverage</button>
      </li>
      <li
        @click="$emit('navClick', 'faculty')"
        class="text-xl Tabs__tab Tab"
        v-bind:class="{ 'activeTab': currentTab === 'faculty' }"
      >
        <button>Faculty Accomplishments</button>
      </li>
      <li
        @click="$emit('navClick', 'videos')"
        class="text-xl Tabs__tab Tab"
        v-bind:class="{ 'activeTab': currentTab === 'videos' }"
      >
        <button>Videos</button>
      </li>
      <li class="Tabs__presentation-slider" role="presentation"></li>
    </ul>
  </nav>
</template>
<script>
export default {
  props: ['currentTab'],
  data() {
    return {};
  },
};
</script>
