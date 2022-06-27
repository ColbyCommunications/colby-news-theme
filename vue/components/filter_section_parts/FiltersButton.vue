<template>
  <div>
    <button class="flex items-center">
      <span
        class="material-icons-sharp filters-icon cursor-pointer"
        :class="{ 'bg-gray-200 rounded-md': isOpen }"
        @click="toggleFilters()"
        @keyup.enter="toggleFilters()"
      >
        tune
      </span>
    </button>
  </div>
</template>
<script>
export default {
  props: {
    currentTab: { type: String, required: true },
    isOpen: { type: Boolean, required: true },
    toggleFilters: { type: Function, required: true },
    checkTabMedia: { type: Function, required: true },
    checkTabStories: { type: Function, required: true },
  },
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
