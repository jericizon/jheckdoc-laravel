<template lang="pug">

</template>

<script>
export default {
  name: '',
  props: {
    string: { type: String, default: '' },
    number: { type: Number, default: 0 },
    array: { type: Array, default: () => [] },
    object: { type: Object, default: () => ({}) },
    boolean: { type: Boolean, default: false },
  },
};
</script>

<style lang="scss">
</style>
