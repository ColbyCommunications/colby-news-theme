<template>
  <nav>
    <ul class="Tabs">
      <li
        v-for="(tabName, index) in this.tabNames"
        :key="index"
        class="text-lg Tabs__tab Tab"
        :class="{ 'activeTab': currentTab === tabName }"
      >
        <button @click="$emit('nav-click', tabName)">{{ tabName }}</button>
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
