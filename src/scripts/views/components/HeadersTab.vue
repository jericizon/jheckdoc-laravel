<template lang="pug">
#headers-tab
  h3.title.is-3 Headers

  template(
    v-if="!headers"
  )
    p No headers

  template(v-else)

    table.table.is-bordered.is-hoverable.is-fullwidth.mb-6
      thead
        tr
          th Content
          th Value
          th

      tbody
        tr(
          v-for="(header, key) in headers"
          :key="`table-header-${key}`"
        )
          td {{key}}
          td {{header.value}}
          td {{header.required ? 'Required' : 'Optional'}}

</template>

<script>
export default {
  name: 'HeadersTab',
  props: {
    headers: { type: [Object, String], default: () => ({}) },
  },
};
</script>

<style lang="scss">
</style>
