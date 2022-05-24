<template>
  <div>
    <!-- filters modal -->
    <Transition>
      <div
        v-show="checkTabStories"
        :class="{ 'mb-12': this.isOpen }"
        class="bg-gray-200 px-8 filters-modal"
      >
        <h2 class="text-lg py-4">Category</h2>
        <ais-refinement-list
          attribute="primary_category"
          :limit="12"
          class="pb-8"
        />
      </div>
    </Transition>
    <Transition>
      <div
        v-show="checkTabMedia"
        :class="{ 'mb-12': this.isOpen }"
        class="bg-gray-200 px-8 filters-modal"
      >
        <h2 class="text-lg py-4">Media Source</h2>
        <ais-refinement-list
          class="pb-10"
          attribute="media_source"
          :searchable="true"
          :show-more="false"
          :limit="10"
          :searchable-placeholder="`Search among ${totalPubs} publications...`"
        />
      </div>
    </Transition>
  </div>
</template>
<script>
import CurrentRefinements from './CurrentRefinements.vue';
import FiltersButton from './FiltersButton.vue';
export default {
  components: {
    CurrentRefinements,
    FiltersButton,
  },
  props: ['isOpen', 'checkTabStories', 'checkTabMedia'],
  data() {
    return {
      totalPubs: window.colbyNews.totalPubs,
    };
  },
  computed: {},
  methods: {},
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
  width: 30%;
  min-width: 300px;
}
</style>
