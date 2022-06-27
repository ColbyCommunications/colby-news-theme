<template>
  <div>
    <div class="flex items-center">
      <span
        class="material-icons-sharp filters-icon cursor-pointer"
        :class="{ 'bg-gray-200 rounded-md': isOpen }"
        @click="toggleFilters()"
        @keyup.enter="toggleFilters()"
      >
        tune
      </span>
    </div>
  </div>
</template>
<script>
export default {
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
};
</script>
<style>
.filters-icon {
  font-size: 28px;
}
</style>
