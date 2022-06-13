<template>
  <div>
    <div class="flex items-center">
      <span
        class="material-icons-sharp filters-icon cursor-pointer"
        :class="{ 'bg-gray-200 rounded-md': this.isOpen }"
        @click="toggleFilters()"
      >
        tune
      </span>
    </div>
  </div>
</template>
<script>
import CurrentRefinements from './CurrentRefinements.vue';
export default {
  components: {
    CurrentRefinements,
  },
  props: [
    'currentTab',
    'isOpen',
    'toggleFilters',
    'checkTabStories',
    'checkTabMedia',
  ],
  data() {
    return {};
  },
  computed: {},
  methods: {},
};
</script>
<style>
.filters-icon {
  font-size: 28px;
}
</style>
