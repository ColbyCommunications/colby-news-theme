<template>
  <div class="flex flex-col">
    <div class="flex flex-row justify-between">
      <!-- current refinements -->
      <current-refinements></current-refinements>
      <!-- filters button -->
      <filters-button
        :isOpen="isOpen"
        :toggleFilters="toggleFilters"
      ></filters-button>
    </div>
    <!-- filters modal -->
    <filters-modal
      :isOpen="isOpen"
      :checkTabStories="checkTabStories"
      :checkTabMedia="checkTabMedia"
    ></filters-modal>
  </div>
</template>
<script>
import CurrentRefinements from './filter_section_parts/CurrentRefinements.vue';
import FiltersButton from './filter_section_parts/FiltersButton.vue';
import FiltersModal from './filter_section_parts/FiltersModal.vue';
export default {
  components: {
    CurrentRefinements,
    FiltersButton,
    FiltersModal,
  },
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
  computed: {},
  methods: {},
};
</script>
<style></style>
