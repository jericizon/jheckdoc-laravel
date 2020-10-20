<template>
<div
  class="my-5 relative"
  v-if="hasData"
>
  <Card title="Headers">
    <button
      class="absolute font-light right-0 text-sm top-0 underline mr-2 mt-3 px-3"
      @click="showTable = !showTable"
    >
      {{ showTable ? 'Hide' : 'Show'}}
    </button>
    <table
      v-if="showTable"
      class="w-full whitespace-no-wrap"
    >
      <thead>
        <tr
          class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase"
        >
          <th class="px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Content</th>
          <th class="px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Value</th>
          <th class="px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Required</th>
        </tr>
      </thead>
      <tbody
        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
      >
        <tr
          class="text-gray-700 dark:text-gray-400"
          v-for="(header, key) in headers"
          :key="`table-header-${key}`"
        >
          <td class="font-medium px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400">{{key}}</td>
          <td class="font-medium px-4 py-3 border dark:border-gray-700 bg-gray-50">
            <template v-if="header.placeholder">
              <span class="text-purple-600 italic">{{header.placeholder}}</span>
            </template>

            <template v-else>
              <span>{{header.value}}</span>
            </template>
          </td>
          <td class="font-medium px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400">{{header.required ? 'Required' : 'Optional'}}</td>
        </tr>
      </tbody>
    </table>
  </Card>
</div>
</template>

<script>
export default {
  name: 'HeadersTab',
  props: {
    headers: { type: [Object, String], default: () => ({}) },
  },
  data() {
    return {
      showTable: true,
    };
  },
  computed: {
    hasData() {
      return Object.keys(this.headers).length;
    },
  },
};
</script>

<style lang="scss">
</style>
