<template>
  <div class="flex flex-col min-h-4">
    <div class="flex justify-between items-start pt-4 pb-3">
      <div class="flex flex-wrap items-center">
        <ul v-if="selectedCategories.length" class="flex flex-wrap">
          <li
            v-for="cat in selectedCategories"
            :key="cat"
            class="flex items-center p-0.5 pr-2 bg-gray-200 mr-4 my-1 text-base"
          >
            <button
              class="cursor-pointer flex items-center border-r border-gray-400 mr-1.5 h-5/6"
              @click.prevent="removeCategory(cat)"
            >
              <span class="material-icons-sharp text-base pr-0.5"> close </span>
            </button>
            <div>{{ cat }}</div>
          </li>

          <li class="flex items-center my-1">
            <button
              class="text-sm italic hover:underline"
              @click="clearCategories"
            >
              Clear Filters
            </button>
          </li>
        </ul>
      </div>

      <div class="flex justify-end shrink-0">
        <button class="flex items-center" @click="toggleFilters">
          <span
            class="material-icons-sharp filters-icon cursor-pointer"
            :class="{ 'bg-gray-200 rounded-md': isOpen }"
          >
            tune
          </span>
        </button>
      </div>
    </div>

    <Transition>
      <div
        v-show="isOpen"
        class="bg-gray-200 px-8 filters-modal"
        :class="{ 'mb-12': isOpen }"
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
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const emit = defineEmits(['update:selected-categories']);

const isOpen = ref(false);
const categories = ref(window.colbyNews?.allCategories || []);
const selectedCategories = ref([]);

const toggleFilters = () => (isOpen.value = !isOpen.value);
const removeCategory = (cat) =>
  (selectedCategories.value = selectedCategories.value.filter(
    (c) => c !== cat
  ));
const clearCategories = () => (selectedCategories.value = []);

watch(selectedCategories, (newVal) => {
  emit('update:selected-categories', newVal);
});
</script>

<style>
.filters-icon {
  font-size: 28px;
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
</style>
