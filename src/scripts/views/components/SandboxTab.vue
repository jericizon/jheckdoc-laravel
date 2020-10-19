<template>

<div
  class="my-5 relative"
  v-if="headers"
>
  <Card
    title="Sandbox"
    backgroundClass="bg-yellow-100"
  >
    <button
      class="absolute font-light right-0 text-sm top-0 underline mr-2 mt-3 px-3"
      @click="showTable = !showTable"
    >
      {{ showTable ? 'Hide' : 'Show'}}
    </button>

    <template
      v-if="showTable"
    >
      <h4 class="mb-2 uppercase text-base font-semibold text-gray-600">Request URL</h4>

      <div class="py-2 p-4">
        <div class="block w-full mt-1 p-2 text-sm rounded-lg text-gray-500 bg-gray-100 border" v-html="requestHtmlUrl"></div>
      </div>

      <h4 class="mt-5 mb-2 uppercase text-base font-semibold text-gray-600">Headers</h4>

      <div
        class="py-2 p-4"
        v-for="(header, key) in inputHeaders"
        :key="`header-${key}`"
      >
        <label class="block text-sm">
          <span class="capitalize text-gray-700 text-gray-400">
            {{key}}:
          </span>
          <input
            class="block w-full mt-1 p-2 text-sm rounded-lg text-gray-900 bg-gray-100 border form-input"
            v-model="inputHeaders[key]"
            :placeholder="key"
          >
        </label>

      </div>

      <template v-if="parameters">
        <h4 class="mt-5 mb-2 uppercase text-base font-semibold text-gray-600">Parameters</h4>

        <div
          class="py-2 p-4"
          v-for="(parameter, key) in inputParameters"
          :key="`parameter-${key}`"
        >
          <span class="text-gray-700 text-gray-400">
            {{key}}<span v-if="isRequired(key)" class="text-red text-sm font-bold">*</span>:
          </span>
          <input
            class="block w-full mt-1 p-2 text-sm rounded-lg text-gray-900 bg-gray-100 border form-input"
            :placeholder="key"
            v-model="inputParameters[key]"
            :class="{'form-incomplete': isRequired(key) && !inputParameters[key], 'border-red-500' : isRequired(key) && !inputParameters[key] && showValidationError}"
          >
          <span
            class="text-xs text-red-600 text-red-400"
            v-if="isRequired(key) && !inputParameters[key] && showValidationError"
          >
            This field is required
          </span>
        </div>

        <button
          class="my-10 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
          @click="executeRequest"
          :disabled="isRequesting"
        >
          {{isRequesting ? `Processing...` : 'Execute'}}
        </button>


        <Card
          v-if="serverResponseError"
          title="Error encountered"
        >
          <div class="server-response-content">
            <pre class="bg-black text-xs p-5 text-yellow-500">{{serverResponseError}}</pre>
          </div>
        </Card>

        <template
          v-if="hasServerResponse"
        >
          <Card :title="`Server response - ${serverResponsePerformance}`">
            <div class="server-response-content">
              <pre class="bg-black text-xs p-5 text-yellow-500">{{serverResponseContent}}</pre>
            </div>
          </Card>

          <Card
            title="Response headers"
            class="mt-2"
          >
            <ul>
              <li
                class="mb-1 text-gray-700 text-sm font-medium"
                v-for="(serverResponseHeader, key) in serverResponseHeaders"
                :key="`server-response-header-${key}`"
              >{{key}} : <span class="font-normal">{{serverResponseHeader}}</span></li>
            </ul>
          </Card>

          <Card
            title="Request info"
            class="mt-2"
          >
            <ul>
              <li class="mb-1 text-gray-700 text-sm font-medium">Request Method: <span class="font-normal uppercase">{{serverResponseConfig.method}}</span></li>
              <li class="mb-1 text-gray-700 text-sm font-medium">Status code: <span class="font-normal">{{serverResponseCode}}</span></li>
            </ul>
          </Card>
        </template>
      </template>
    </template>

  </Card>
</div>
</template>

<script>

import { mapGetters, mapMutations, mapState } from 'vuex';
import axios from 'axios';


import Card from '../BaseUI/Card.vue';

export default {
  name: 'SandboxTab',
  props: {
    parameters: { type: [Object, String], default: () => ({}) },
    headers: { type: [Object, String], default: () => ({}) },
    responses: { type: [Object, String], default: () => ({}) },
  },
  components: {
    Card,
  },
  data() {
    return {
      showTable: true,
      inputHeaders: {},
      inputParameters: {},
      isRequesting: false,
      showValidationError: false,
      serverResponseError: '',
    };
  },
  computed: {
    ...mapState([
      'activeRoute',
      'activeMethod',
      'sandboxResponses',
    ]),
    ...mapGetters([
      'getActiveRouteContent',
      'getActiveRouteServerResponse',
      'getActiveRouteServerPerformance',
      'getRouteLink',
    ]),
    serverResponseCode() {
      return typeof this.getActiveRouteServerResponse.status !== 'undefined'
        ? this.getActiveRouteServerResponse.status
        : '';
    },
    serverResponseContent() {
      return typeof this.getActiveRouteServerResponse.data !== 'undefined'
        ? this.getActiveRouteServerResponse.data
        : '';
    },
    serverResponseHeaders() {
      return typeof this.getActiveRouteServerResponse.headers !== 'undefined'
        ? this.getActiveRouteServerResponse.headers
        : {};
    },
    serverResponseConfig() {
      return typeof this.getActiveRouteServerResponse.config !== 'undefined'
        ? this.getActiveRouteServerResponse.config
        : {};
    },
    serverResponsePerformance() {
      return typeof this.getActiveRouteServerPerformance !== 'undefined'
        ? this.getActiveRouteServerPerformance
        : '0s';
    },
    hasServerResponse() {
      return typeof this.getActiveRouteServerResponse.data !== 'undefined';
    },
    requestHtmlUrl() {
      let params = this.getRouteLink.split('/');
      params = params.map((item) => {
        if (item.includes('{') && item.includes('}')) {
          const param = item.replace('{', '').replace('}', '');
          const newItem = this.inputParameters[param] ? this.inputParameters[param] : item;
          return `<span class="border-b border-black font-bold text-black">${newItem}</span>`;
        }
        return item;
      });
      return params.join('/');
    },
    requestUrl() {
      let params = this.getRouteLink.split('/');
      params = params.map((item) => {
        if (item.includes('{') && item.includes('}')) {
          const param = item.replace('{', '').replace('}', '');
          return this.inputParameters[param] ? this.inputParameters[param] : '';
        }
        return item;
      });
      return params.join('/');
    },
  },
  methods: {
    ...mapMutations([
      'setSandboxResponses',
    ]),
    defaultValue(input, defaultContent = '') {
      if (typeof input === 'undefined') return defaultContent;

      return input;
    },
    isRequired(index) {
      return !!(typeof this.parameters[index] !== 'undefined' && typeof this.parameters[index].required !== 'undefined' && this.parameters[index].required);
    },
    executeRequest() {
      // console.log(this.getActiveRouteContent);

      this.serverResponseError = '';

      if (document.getElementsByClassName('form-incomplete').length) {
        this.showValidationError = true;
        return;
      }

      const execStart = performance.now();

      const data = JSON.parse(JSON.stringify(this.inputParameters));
      let headers = JSON.parse(JSON.stringify(this.inputHeaders));
      const method = this.activeMethod;

      headers = { headers };

      console.log(data, headers, method);

      this.isRequesting = true;

      // clear old value
      this.setSandboxResponses({
        route: this.activeRoute,
        response: {},
      });

      let axiosRequest = '';

      switch (method.toLowerCase()) {
        case 'delete':
          axiosRequest = axios.delete(this.requestUrl, data, headers);
          break;
        case 'patch':
          axiosRequest = axios.patch(this.requestUrl, data, headers);
          break;
        case 'put':
          axiosRequest = axios.put(this.requestUrl, data, headers);
          break;
        case 'get':
          axiosRequest = axios.get(this.requestUrl, headers, data);
          break;
        case 'post':
          axiosRequest = axios.post(this.requestUrl, data, headers);
          break;
        default:
          axiosRequest = axios({
            url: this.requestUrl,
            method,
            data,
            headers,
          });
      }

      axiosRequest
        .then((response) => {
          // console.log(response);

          const total = ((performance.now() - execStart) / 1000).toFixed(2);
          const execTime = `${total}s`;

          this.setSandboxResponses({
            route: this.activeRoute,
            response,
            performance: execTime,
          });
        })
        .catch((error) => {
          if (typeof error.response === 'undefined') {
            this.serverResponseError = error;
          } else {
            const total = ((performance.now() - execStart) / 1000).toFixed(2);
            const execTime = `${total}s`;
            this.setSandboxResponses({
              route: this.activeRoute,
              response: error.response,
              performance: execTime,
            });
          }
        })
        .then((always) => {
          // console.log('always', always);
          this.showValidationError = false;
          this.isRequesting = false;
        });
    },
    refreshState() {
      // console.log('refresh state');
      this.inputHeaders = {};
      this.inputParameters = {};
      this.isRequesting = false;
      this.showValidationError = false;
      this.serverResponseError = '';

      if (this.headers) {
        const headers = Object.entries(this.headers);
        for (const [key, header] of headers) {
          this.$set(this.inputHeaders, key, header.value);
        }
      }
      if (this.parameters) {
        const parameters = Object.entries(this.parameters);
        for (const [key, parameter] of parameters) {
          this.$set(this.inputParameters, key, parameter.value);
        }
      }
    },
  },
  mounted() {
    this.refreshState();
  },
  watch: {
    activeRoute() {
      this.refreshState();
    },
    // sandboxResponses(val) {
    //   console.log(val);
    // },
  },
};
</script>

<style lang="scss">
.server-response-content{
  pre{
    max-height: 400px;
    overflow: auto;
  }
}

</style>
