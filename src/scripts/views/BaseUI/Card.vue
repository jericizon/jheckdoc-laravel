<template>
<div
  class="min-w-0 p-4 rounded-lg shadow-lg dark:bg-gray-800"
  :class="backgroundClass"
>
  <h4
    class="mb-4 font-semibold text-gray-800 dark:text-gray-300"
    v-if="title"
  >
    {{title}}
  </h4>
  <slot
    :modalContent="this.$refs.modalContent"
  ></slot>
</div>
</template>

<script>
export default {
  name: 'Card',
  props: {
    title: { type: String, default: '' },
    content: { type: String, default: '' },
    backgroundClass: { type: String, default: 'bg-white' },
  },
};
</script>

<style lang="scss">
</style>
