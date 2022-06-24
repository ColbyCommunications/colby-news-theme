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
              :disabled="isFirstPage ? true : false"
              :class="[isFirstPage ? 'pointer-events-none' : '', 'mr-2']"
              :style="{ color: isFirstPage ? '#8b8b8b' : 'black' }"
            >
              <span
                :class="[
                  'material-icons-sharp',
                  isFirstPage
                    ? 'text-black text-xl leading-none border border-black rounded'
                    : 'text-white text-xl leading-none border border-black rounded bg-black hover:text-black hover:bg-white',
                ]"
              >
                chevron_left
              </span>
            </a>
            <a
              :href="createURL(currentRefinement + 1)"
              @click.prevent="refine(currentRefinement + 1)"
              :disabled="isLastPage ? true : false"
              :class="[isLastPage ? 'pointer-events-none' : '']"
              :style="{ color: isLastPage ? '#8b8b8b' : 'black' }"
            >
              <span
                :class="[
                  'material-icons-sharp',
                  isLastPage
                    ? 'text-black text-xl leading-none border border-black rounded'
                    : 'text-white text-xl leading-none border border-black rounded bg-black hover:text-black hover:bg-white',
                ]"
              >
                chevron_right
              </span>
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
