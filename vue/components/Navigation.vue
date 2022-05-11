<template>
  <nav>
    <ul class="Tabs">
      <li
        v-for="(tabName, index) in this.tabNames"
        :key="index"
        @click="$emit('navClick', tabName)"
        class="text-xl Tabs__tab Tab"
        v-bind:class="{ 'activeTab': currentTab === tabName }"
      >
        <button>{{ tabName }}</button>
      </li>
      <li class="Tabs__presentation-slider" role="presentation"></li>
    </ul>
  </nav>
</template>
<script>
export default {
  props: ['currentTab'],
  data() {
    return {
      tabNames: [
        'Stories',
        'Media Coverage',
        'Faculty Accomplishments',
        'Videos',
      ],
    };
  },
};
</script>
