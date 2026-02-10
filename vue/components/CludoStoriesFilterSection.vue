<template>
  <div class="flex flex-col">
    <div class="flex flex-row justify-end pt-4 pb-3">
      <button class="flex items-center" @click="toggleFilters">
        <span
          class="material-icons-sharp filters-icon cursor-pointer"
          :class="{ 'bg-gray-200 rounded-md': isOpen }"
        >
          tune
        </span>
      </button>
    </div>

    <!-- FILTER MODAL -->
    <Transition>
      <div v-show="isOpen" class="bg-gray-200 px-8 filters-modal mb-12">
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
  </div>
</template>

<script>
export default {
  name: 'Filters',
  data() {
    return {
      isOpen: false,

      categories: ['Campus', 'Research', 'Events', 'Alumni', 'Athletics'],
      selectedCategories: [],

      mediaSources: ['New York Times', 'Washington Post', 'BBC', 'NPR'],
      selectedMedia: [],
    };
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

/* Transition animation */
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
</style>
