<template>
<div
  class="my-5 relative"
  v-if="hasData"
>
  <Card title="Parameters">
    <button
      class="absolute font-light right-0 text-sm top-0 underline mr-2 mt-3 px-3"
      @click="showTable = !showTable"
    >
      {{ showTable ? 'Hide' : 'Show'}}
    </button>

    <template
      v-if="showTable"
    >

      <table class="w-full whitespace-no-wrap mb-10">

        <thead>
          <tr
            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase"
          >
            <th class="px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Name</th>
            <th class="px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Type</th>
            <th class="px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Required</th>
          </tr>
        </thead>
        <tbody
          class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
        >
          <tr
            class="text-gray-700 dark:text-gray-400"
            v-for="(parameter, key) in parameters"
            :key="`table-parameter-${key}`"
          >
            <td class="font-medium px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400">{{key}}</td>
            <td class="font-medium px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400">{{parameter.type}}</td>
            <td class="font-medium px-4 py-3 border dark:border-gray-700 bg-gray-50 dark:text-gray-400">{{parameter.required ? 'Required' : 'Optional'}}</td>
          </tr>
        </tbody>
      </table>

      <div
        class="m-3"
        v-for="(params, key) in parameters"
        :key="`parameter-description-${key}`"
      >
        <h4 class="mb-2 text-base font-semibold text-gray-500">{{key}}</h4>
        <ul
          class="border-b pb-5"
        >
          <li class="mb-1 text-gray-700 text-sm font-medium">Type: <span class="font-normal">{{params.type}}</span></li>
          <li class="mb-1 text-gray-700 text-sm font-medium">Required: <span class="font-normal">{{params.required ? 'true' : 'false'}}</span></li>
          <li class="mb-1 text-gray-700 text-sm font-medium">Description: <span class="font-normal">{{params.description}}</span></li>
          <li
            v-if="params.options"
            class="mb-1 text-gray-700 text-sm font-medium">Options: <span class="bg-yellow-300 font-normal px-2">{{params.options.join(', ')}}</span>
          </li>

        </ul>
      </div>
    </template>
  </Card>
</div>

</template>

<script>
export default {
  name: 'ParametersTab',
  props: {
    parameters: { type: [Object, String], default: () => ({}) },
  },
  data() {
    return {
      showTable: true,
    };
  },
  computed: {
    hasData() {
      return Object.keys(this.parameters).length;
    },
  },
};
</script>

<style lang="scss">
</style>
