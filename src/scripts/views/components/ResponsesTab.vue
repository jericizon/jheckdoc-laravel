<template>
<div
  class="my-5 relative"
  v-if="responses"
>
  <Card title="Responses">
      <button
        class="absolute font-light right-0 text-sm top-0 underline mr-2 mt-3 px-3"
        @click="showTable = !showTable"
      >
        {{ showTable ? 'Hide' : 'Show'}}
      </button>
      <table
        v-if="showTable"
        class="w-full whitespace-no-wrap mb-10"
      >
        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase"
          >
            <th class="px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Code</th>
            <th class="px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Description</th>
          </tr>
        </thead>
        <tbody
          class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
        >
          <tr
            class="text-gray-700 dark:text-gray-400"
            v-for="(response, key) in responses"
            :key="`table-response-${key}`"
          >
            <td class="font-medium px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400">{{key}}</td>
            <td class="font-medium px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400">{{response.description}}</td>
          </tr>
        </tbody>
      </table>
  </Card>
</div>

<!-- #responses-tab
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
          td {{response.description}} -->

</template>

<script>
export default {
  name: 'ResponsesTab',
  props: {
    responses: { type: [Object, String], default: () => ({}) },
  },
  data() {
    return {
      showDescription: false,
      showTable: true,
    };
  },
};
</script>
