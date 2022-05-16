<template>
  <div>
    <ais-pagination @page-change="pageChange">
      <template
        v-slot="{
          currentRefinement,
          nbPages,
          isFirstPage,
          isLastPage,
          refine,
          createURL,
        }"
      >
        <ul class="flex flex-row items-center justify-end">
          <li class="w-32">
            <p :style="paginationText">
              {{ `Page ${currentRefinement + 1} of ${nbPages}` }}
            </p>
          </li>
          <li class="flex justify-center items-center">
            <a
              :href="createURL(currentRefinement - 1)"
              @click.prevent="refine(currentRefinement - 1)"
              :style="{ color: isFirstPage ? '#D8D8D8' : 'black' }"
            >
              <span class="material-icons-sharp chevron"> chevron_left </span>
            </a>
            <a
              :href="createURL(currentRefinement + 1)"
              @click.prevent="refine(currentRefinement + 1)"
              :style="{ color: isLastPage ? '#D8D8D8' : 'black' }"
            >
              <span class="material-icons-sharp chevron"> chevron_right </span>
            </a>
          </li>
        </ul>
      </template>
    </ais-pagination>
  </div>
</template>
<script>
export default {
  data() {
    return {
      paginationText: {
        fontSize: '15px',
      },
    };
  },
  methods: {
    pageChange(...args) {
      const element = document.getElementById('site-search-searchbox');
      element.scrollIntoView({ behavior: 'smooth', block: 'end' });
    },
  },
};
</script>
