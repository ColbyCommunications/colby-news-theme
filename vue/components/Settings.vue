<template>
  <div class="flex flex-col">
    <div class="flex flex-row justify-end">
      <ais-current-refinements />
      <div>
        <div class="flex items-center pt-4 pb-3">
          <span
            class="material-icons-sharp filters-icon cursor-pointer"
            :class="{ 'bg-gray-200 rounded-md': this.isOpen }"
            @click="toggleFilters()"
          >
            tune
          </span>
        </div>
      </div>
    </div>
    <!-- filter modal for stories -->
    <Transition>
      <div
        :class="{ 'mb-12': this.isOpen }"
        v-show="checkTabStories"
        class="bg-gray-200 px-8 filters-modal"
      >
        <h2 class="text-lg my-4">Category</h2>
        <ais-refinement-list attribute="primary_category" class="mb-4" />
        <ais-clear-refinements
          class="flex justify-center mb-10 w-52 px-10 py-2 text-sm text-white uppercase transition-colors bg-black rounded-lg hover:bg-gray-800"
        >
          <template v-slot:resetLabel>CLEAR FILTERS</template>
        </ais-clear-refinements>
      </div>
    </Transition>
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
<style>
.filters-icon {
  font-size: 28px;
}

.ais-RefinementList-list {
  margin-bottom: 1rem;
}

/* .ais-RefinementList-label {
  display: flex;
  align-items: center;
} */

.ais-RefinementList-checkbox {
  transform: scale(1.3);
  border: 1px solid rgb(107 114 128);
  border-radius: unset;
}

.ais-RefinementList-labelText,
.ais-RefinementList-checkbox:hover {
  cursor: pointer;
}

.ais-CurrentRefinements-item {
  display: flex;
  flex-wrap: wrap;
}

.ais-RefinementList-labelText {
  font-size: 1rem;
  padding-left: 0.5rem;
}

.ais-RefinementList-count,
.ais-CurrentRefinements-label {
  display: none;
}

.ais-CurrentRefinements-category {
  display: flex;
  flex-direction: row-reverse;
  justify-content: space-between;
  margin-right: 12px;
}

.ais-CurrentRefinements-delete {
  margin-right: 3px;
}

/* .ais-CurrentRefinements-categoryLabel {
  margin-right: 5px;
} */

.v-enter-active,
.v-leave-active {
  max-height: 40rem;
  transition: max-height 0.5s ease-out;
  overflow: hidden;
}

.v-enter-from,
.v-leave-to {
  max-height: 0;
  transition: max-height 0.5s cubic-bezier(0, 1, 0, 1);
}
</style>
