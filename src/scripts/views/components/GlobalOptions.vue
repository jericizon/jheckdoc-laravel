<template>
<div id="global-options" class="mt-10">
  <Card
    title="Global options"
    backgroundClass="bg-green-200"
  >
    <p class="mb-1 text-gray-700 text-sm font-medium">Any declarations here will be used as default value in sandbox input.</p>
    <div id="global-options-wrapper" class="overflow-auto pb-10">

      <h4 class="mt-5 mb-2 uppercase text-base font-semibold text-gray-600">Headers</h4>

      <div
        class="py-2 p-4"
        v-for="(header, key) in inputHeaderKey"
        :key="`header-${key}`"
      >

        <div class="flex items-end justify-between mt-4">
          <button
            class="bg-gray-900 font-bold p-2 rounded text-sm text-white"
            @click="deleteHeader(key)"
          >X</button>
          <div class="w-full md:w-1/2 px-3">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Key</label>
              <input
                class="block w-full mt-1 p-2 text-sm rounded-lg text-gray-900 bg-gray-100 border form-input"
                type="text"
                v-model="inputHeaderKey[key]"
                @change="inputChanged(key)"
              >
          </div>
          <div class="w-full md:w-1/2 px-3">
              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Value</label>
              <input
                class="block w-full mt-1 p-2 text-sm rounded-lg text-gray-900 bg-gray-100 border form-input"
                type="text"
                v-model="inputHeaderValue[key]"
                @change="inputChanged(key)"
              >
          </div>
        </div>
      </div>

      <button
        class="p-2 m-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
        @click="addNewHeader"
      >
        Add new header
      </button>
    </div>
  </Card>
</div>
</template>

<script>

import {
  mapState, mapMutations, mapActions, mapGetters,
} from 'vuex';

export default {
  name: 'GlobalOptions',
  data() {
    return {
      inputHeaderKey: [],
      inputHeaderValue: [],
    };
  },
  computed: {
    ...mapState('globalOptions', [
      'globalHeaderInput',
    ]),
    ...mapGetters('globalOptions', [
      'getGlobalHeaderInput',
    ]),
  },
  methods: {
    ...mapActions('globalOptions', [
      'insertGlobalHeaderInput',
      'removeGlobalHeaderInput',
    ]),
    addNewHeader() {
      const count = this.inputHeaderKey.length;
      const key = `Header - ${count + 1}`;
      this.insertGlobalHeaderInput({
        index: count,
        key,
        value: '',
      });

      // this.$set(this.inputHeaders, key, '');
      this.inputHeaderKey.push(key);
      this.inputHeaderValue.push('');
    },
    inputChanged(index) {
      // console.log('inputChanged', this.inputHeaderKey[index], this.inputHeaderValue[index]);
      this.insertGlobalHeaderInput({
        index,
        key: this.inputHeaderKey[index],
        value: this.inputHeaderValue[index],
      });
    },
    deleteHeader(index) {
      this.inputHeaderKey.splice(index, 1);
      this.inputHeaderValue.splice(index, 1);
      this.removeGlobalHeaderInput(index);
    },
  },
  mounted() {
    const headers = JSON.parse(JSON.stringify(this.globalHeaderInput));
    headers.map((item) => {
      this.inputHeaderKey.push(item.key);
      this.inputHeaderValue.push(item.value);
    });
  },
  watch: {
  },
};
</script>

<style scoped>
#global-options-wrapper{
  max-height: 400px;
}
</style>
