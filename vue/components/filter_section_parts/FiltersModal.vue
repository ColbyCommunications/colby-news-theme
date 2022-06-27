<template>
  <div>
    <!-- filters modal -->
    <Transition>
      <div
        v-show="checkTabStories"
        :class="{ 'mb-12': isOpen }"
        class="bg-gray-200 px-8 filters-modal"
      >
        <h2 class="text-lg py-4">Category</h2>
        <ais-refinement-list
          attribute="primary_category"
          :transformItems="getStaticValues"
          class="pb-8"
        />
      </div>
    </Transition>
    <Transition>
      <div
        v-show="checkTabMedia"
        :class="{ 'mb-12': isOpen }"
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
export default {
  props: {
    isOpen: { type: Boolean, required: true },
    checkTabStories: { type: Boolean, required: true },
    checkTabMedia: { type: Boolean, required: true },
  },
  data() {
    return {
      totalPubs: window.colbyNews.totalPubs,
    };
  },
  computed: {},
  methods: {
    getStaticValues: (items) => {
      const staticValues = window.colbyNews.allCategories;
      return staticValues.map((value) => {
        const item = items.find((item) => item.label === value);
        return (
          item || {
            label: value,
            value,
            count: 0,
            isRefined: false,
            highlighted: value,
          }
        );
      });
    },
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
