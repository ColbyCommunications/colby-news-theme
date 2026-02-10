<template>
  <div role="region" aria-label="Search Filters">
    <!-- filters modal -->
    <Transition>
      <div
        v-show="checkTabStories && isOpen"
        class="bg-gray-200 px-8 filters-modal mb-12"
      >
        <h2 class="text-lg py-4">Category</h2>

        <ul class="pb-8">
          <li v-for="cat in categories" :key="cat" class="mb-2">
            <label class="flex items-center cursor-pointer">
              <input
                type="checkbox"
                class="mr-2"
                :value="cat"
                v-model="selectedCategories"
              />
              {{ cat }}
            </label>
          </li>
        </ul>
      </div>
    </Transition>
    <Transition>
      <div
        v-show="checkTabMedia && isOpen"
        class="bg-gray-200 px-8 filters-modal mb-12"
      >
        <h2 class="text-lg py-4">Media Source</h2>

        <ul class="pb-8">
          <li v-for="media in mediaSources" :key="media" class="mb-2">
            <label class="flex items-center cursor-pointer">
              <input
                type="checkbox"
                class="mr-2"
                :value="media"
                v-model="selectedMedia"
              />
              {{ media }}
            </label>
          </li>
        </ul>
      </div>
    </Transition>
  </div>
</template>
<script>
export default {
  props: {
    isOpen: { type: Boolean, required: true },
    checkTabStories: { type: Boolean, required: true },
    checkTabMedia: { type: Boolean, required: true },
  },
  data() {
    return {
      categories: ['Campus', 'Research', 'Events', 'Alumni', 'Athletics'],
      selectedCategories: [],
      mediaSources: ['New York Times', 'Washington Post', 'BBC', 'NPR'],
      selectedMedia: [],
    };
  },
};
</script>
<style>
.ais-RefinementList-list {
  margin-bottom: 1rem;
}

.ais-RefinementList-checkbox {
  transform: scale(1.3);
  border: 1px solid rgb(107 114 128);
  border-radius: unset;
}

.ais-RefinementList-labelText,
.ais-RefinementList-checkbox:hover {
  cursor: pointer;
}

.ais-RefinementList-labelText {
  font-size: 1rem;
  padding-left: 0.5rem;
}

.ais-RefinementList-count {
  display: none;
}

.v-enter-active,
.v-leave-active {
  max-height: 40rem;
  transition: max-height 0.3s linear;
  overflow: hidden;
}

.v-enter-from,
.v-leave-to {
  max-height: 0;
  transition: max-height 0.5s cubic-bezier(0, 1, 0, 1);
}

.ais-SearchBox-submitIcon {
  display: none;
}

.filters-modal .ais-RefinementList-list {
  padding-top: 1rem;
}

.filters-modal .ais-SearchBox-input {
  min-width: 300px;
  padding-left: 5px;
  padding-right: 5px;
}

@media only screen and (max-width: 450px) {
  .filters-modal .ais-SearchBox-input {
    min-width: 200px;
    max-width: 200px;
  }
}

@media only screen and (max-width: 320px) {
  .filters-modal .ais-SearchBox-input {
    min-width: 100px;
    max-width: 100px;
  }
}
</style>
