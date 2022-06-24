<template>
  <div>
    <ais-current-refinements>
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
                <ais-clear-refinements>
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
</template>
<script>
export default {
  props: {
    currentTab: { type: String, required: true },
  },
  data() {
    return {};
  },
};
</script>
<style></style>
