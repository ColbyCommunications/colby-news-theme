<template>
  <div class="flex flex-col" :class="{ 'mb-12': this.isOpen }">
    <div class="flex justify-end items-center pt-4 pb-3">
      <span
        class="material-icons-sharp filters-icon cursor-pointer"
        :class="{ 'bg-gray-200 rounded-md': this.isOpen }"
        @click="toggleFilters()"
      >
        tune
      </span>
    </div>
    <div v-if="checkTabStories" class="bg-gray-200 px-8 py-8">
      <h2 class="text-2xl">Category</h2>
      <ais-refinement-list
        attribute="primary_category"
        :sort-by="['name:desc']"
        show-more
      />
    </div>
  </div>
</template>
<script>
export default {
  props: ['currentTab'],
  data() {
    return {
      isOpen: false,
    };
  },
  computed: {
    checkTabStories() {
      return this.isOpen && this.currentTab === 'Stories';
    },
  },
  methods: {
    toggleFilters() {
      this.isOpen = !this.isOpen;
    },
  },
};
</script>
<style scoped>
.filters-icon {
  font-size: 44px;
}
</style>
