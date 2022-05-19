<template>
  <div class="mb-5 w-3/4 flex items-center border-b border-black">
    <div class="pr-2 flex items-center">
      <span class="material-icons-sharp"> search </span>
    </div>
    <ais-search-box
      id="site-search-searchbox"
      placeholder="Start typing to search"
      submit-title="Search"
      class="w-full"
    >
      <template v-slot:reset-icon
        ><i class="whitespace-nowrap">Clear</i></template
      >
    </ais-search-box>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
};
</script>
