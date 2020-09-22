<template lang="pug">
#parameters-tab
  h3.title.is-3 Parameters

  template(
    v-if="!parameters"
  )
    p No parameters

  template(v-else)
    table.table.is-bordered.is-hoverable.is-fullwidth.mb-6
      thead
        tr
          th Name
          th Type
          th

      tbody
        tr(
          v-for="(params, key) in parameters"
          :key="`table-params-${key}`"
        )
          td {{key}}
          td {{params.type}}
          td {{params.required ? 'Required' : 'Optional'}}

    div(
      v-for="(params, key) in parameters"
      :key="`single-params-${key}`"
    )
      h4.title.is-4 {{key}}
      ul
        li Type:
          code {{params.type}}
        li Required:
          code {{params.required ? 'true' : 'false'}}
        li(
          v-if="params.description"
        ) Description: {{params.description}}
      hr

</template>

<script>
export default {
  name: 'ParametersTab',
  props: {
    parameters: { type: [Object, String], default: () => ({}) },
  },
};
</script>

<style lang="scss">
</style>
