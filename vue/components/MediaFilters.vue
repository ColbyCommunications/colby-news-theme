<template>
  <div class="flex flex-col">
    <div class="flex flex-row justify-between">
      <!-- current refinements -->
      <current-refinements></current-refinements>
      <!-- filters button -->
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
    <!-- filter modal for media -->
    <Transition>
      <div
        :class="{ 'mb-12': this.isOpen }"
        v-show="checkTabMedia"
        class="bg-gray-200 px-8 filters-modal"
      >
        <h2 class="text-lg my-4">Media Source</h2>
        <ais-refinement-list
          class="mb-10"
          attribute="media_source"
          :searchable="true"
          :show-more="true"
        />
      </div>
    </Transition>
  </div>
</template>
<script>
import CurrentRefinements from './CurrentRefinements.vue';
export default {
  components: {
    CurrentRefinements,
  },
  props: ['currentTab', 'isOpen', 'toggleFilters', 'checkTabMedia'],
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
</style>
