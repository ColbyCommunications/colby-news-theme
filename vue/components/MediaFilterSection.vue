<template>
  <div v-show="currentTab === 'Media Coverage'" class="flex flex-col">
    <div class="flex flex-row justify-between pt-4 pb-3">
      <!-- current refinements -->
      <div class="flex items-center">
        <ais-current-refinements :included-attributes="['media_source']">
          <template #default="{ items, refine }">
            <ul>
              <li v-for="item in items" :key="item.attribute">
                <ul class="flex flex-wrap">
                  <li
                    v-for="refinement in item.refinements"
                    :key="
                      [
                        refinement.attribute,
                        refinement.type,
                        refinement.value,
                        refinement.operator,
                      ].join(':')
                    "
                    class="flex items-center p-0.5 pr-2 bg-gray-200 mr-4 my-1 text-base"
                  >
                    <button
                      class="cursor-pointer flex items-center border-r border-gray-400 mr-1.5 h-5/6"
                      @click.prevent="refine(refinement)"
                    >
                      <span class="material-icons-sharp text-base pr-0.5">
                        close
                      </span>
                    </button>
                    <div>{{ refinement.label }}</div>
                  </li>
                  <li class="flex justify-center items-center">
                    <ais-clear-refinements
                      :included-attributes="['media_source']"
                    >
                      <template #default="{ canRefine, refine, createURL }">
                        <a
                          v-if="canRefine"
                          :href="createURL()"
                          @click.prevent="refine"
                        >
                          <i class="text-sm">Clear Filters</i>
                        </a>
                      </template>
                    </ais-clear-refinements>
                  </li>
                </ul>
              </li>
            </ul>
          </template>
        </ais-current-refinements>
      </div>
      <div v-show="hasResult">
        <!-- filters button -->
        <filters-button
          :isOpen="isOpen"
          :toggleFilters="toggleFilters"
        ></filters-button>
      </div>
    </div>
    <!-- filters modal -->
    <filters-modal
      v-show="hasResult"
      :isOpen="isOpen"
      :checkTabStories="checkTabStories"
      :checkTabMedia="checkTabMedia"
    ></filters-modal>
  </div>
</template>
<script>
import FiltersButton from './filter_section_parts/FiltersButton.vue';
import FiltersModal from './filter_section_parts/FiltersModal.vue';
export default {
  components: {
    FiltersButton,
    FiltersModal,
  },
  props: {
    currentTab: { type: String, required: true },
    isOpen: { type: Boolean, required: true },
    toggleFilters: { type: Function, required: true },
    checkTabMedia: { type: Boolean, required: true },
    checkTabStories: { type: Boolean },
    hasResult: { type: [Boolean, Object], required: true },
  },
  data() {
    return {};
  },
  computed: {},
  methods: {},
};
</script>
<style></style>
