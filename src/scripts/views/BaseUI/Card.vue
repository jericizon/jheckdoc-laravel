<template lang="pug">
.card.mb-6
  .card-header
    .card-header-title {{title}}

  .card-content
    .content
      slot(:modalContent="this.$refs.modalContent")

</template>

<script>
export default {
  name: 'Card',
  props: {
    title: { type: String, default: '' },
    content: { type: String, default: '' },
  },
};
</script>

<style lang="scss">
</style>
