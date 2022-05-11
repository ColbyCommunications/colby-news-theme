<template>
  <div class="flex justify-end items-center pt-4 pb-2 pr-3">
    <span class="material-icons-sharp settings-icon cursor-pointer">
      tune
    </span>
  </div>
</template>
<script>
export default {
  props: ['currentTab'],
  data() {
    return {};
  },
};
</script>
<style scoped>
.settings-icon {
  font-size: 44px;
}
</style>
