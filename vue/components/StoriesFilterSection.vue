<template>
  <div v-show="this.currentTab === 'Stories'" class="flex flex-col">
    <div class="flex flex-row justify-between">
      <!-- current refinements -->
      <div class="flex items-center">
        <ais-current-refinements :included-attributes="['primary_category']">
          <template v-slot="{ items, refine }">
            <ul>
              <li v-for="item in items" :key="item.attribute">
                <ul class="flex flex-wrap">
                  <li
                    class="flex items-center p-0.5 pr-2 bg-gray-200 mr-4 my-1 text-base"
                    v-for="refinement in item.refinements"
                    :key="
                      [
                        refinement.attribute,
                        refinement.type,
                        refinement.value,
                        refinement.operator,
                      ].join(':')
                    "
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
                      :included-attributes="['primary_category']"
                    >
                      <template v-slot="{ canRefine, refine, createURL }">
                        <a
                          :href="createURL()"
                          @click.prevent="refine"
                          v-if="canRefine"
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
      <div v-if="this.hasResult">
        <!-- filters button -->
        <filters-button
          :isOpen="isOpen"
          :toggleFilters="toggleFilters"
        ></filters-button>
      </div>
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
import FiltersButton from './filter_section_parts/FiltersButton.vue';
import FiltersModal from './filter_section_parts/FiltersModal.vue';
export default {
  components: {
    FiltersButton,
    FiltersModal,
  },
  props: [
    'currentTab',
    'isOpen',
    'toggleFilters',
    'checkTabStories',
    'checkTabMedia',
    'hasResult',
  ],
  data() {
    return {};
  },
  computed: {},
  methods: {},
};
</script>
<style></style>
