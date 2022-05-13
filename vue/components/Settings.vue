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
    <!-- filter modal for stories -->
    <div v-show="checkTabStories" class="bg-gray-200 px-8 py-8">
      <h2 class="text-lg mb-4">Category</h2>
      <ais-refinement-list
        attribute="primary_category"
        :sort-by="['name:desc']"
        :transform-items="transformItems"
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
    transformItems(items) {
      return items.map((item) => ({
        ...item,
        count: `(${item.count})`,
      }));
    },
  },
};
</script>
<style>
.filters-icon {
  font-size: 28px;
}

.ais-RefinementList-list {
  margin-bottom: 1rem;
}

.ais-RefinementList-label {
  display: flex;
  align-items: center;
}

.ais-RefinementList-checkbox {
  transform: scale(1.3);
  border: 1px solid rgb(107 114 128);
}

.ais-RefinementList-labelText {
  font-size: 1rem;
  padding-left: 0.5rem;
}

.ais-RefinementList-count {
  padding-left: 0.5rem;
}
</style>
