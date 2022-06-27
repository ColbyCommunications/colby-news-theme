<template>
  <div>
    <button class="flex items-center" @click="toggleFilters">
      <span
        class="material-icons-sharp filters-icon cursor-pointer"
        :class="{ 'bg-gray-200 rounded-md': isOpen }"
      >
        tune
      </span>
    </button>
  </div>
</template>
<script>
export default {
  props: {
    isOpen: { type: Boolean, required: true },
    toggleFilters: { type: Function, required: true },
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
