<template lang="pug">
#responses-tab
  h3.title.is-3 Responses

  template(
    v-if="!responses"
  )
    p No responses

  template(v-else)

    table.table.is-bordered.is-hoverable.is-fullwidth.mb-6
      thead
        tr
          th Code
          th Description

      tbody
        tr(
          v-for="(response, key) in responses"
          :key="`table-response-${key}`"
        )
          td {{key}}
          td {{response.description}}

</template>

<script>
export default {
  name: 'ResponsesTab',
  props: {
    responses: { type: [Object, String], default: () => ({}) },
  },
};
</script>

<style lang="scss">
</style>
