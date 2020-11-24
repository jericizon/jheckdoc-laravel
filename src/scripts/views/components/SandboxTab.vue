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

      <template v-if="hasHeaders">

        <h4 class="mt-5 mb-2 uppercase text-base font-semibold text-gray-600">Headers</h4>

        <div
          class="py-2 p-4"
          v-for="(header, key) in inputHeaders"
          :key="`header-${key}`"
        >
          <label class="block text-sm">
            <span class="capitalize text-gray-700 text-gray-400">
              {{key}}<span v-if="isRequired(key, 'headers')" class="text-red text-sm font-bold">*</span>:
            </span>
            <input
              class="block w-full mt-1 p-2 text-sm rounded-lg text-gray-900 border form-input"
              v-model="inputHeaders[key]"
              :placeholder="key"
              :class="{'form-incomplete': isRequired(key, 'headers') && !inputHeaders[key], 'border-red-500' : isRequired(key, 'headers') && !inputHeaders[key] && showValidationError}"
            >
            <span
              class="text-xs text-red-600 text-red-400"
              v-if="isRequired(key, 'headers') && !inputHeaders[key] && showValidationError"
            >
              This field is required
            </span>
          </label>

        </div>

      </template>

      <template v-if="hasParameters">
        <h4 class="mt-5 mb-2 uppercase text-base font-semibold text-gray-600">Parameters</h4>

        <div
          class="py-2 p-4"
          v-for="(parameter, key) in parameters"
          :key="`parameter-${key}`"
        >
          <span class="text-gray-700 text-gray-400">
            {{key}}<span v-if="isRequired(key)" class="text-red text-sm font-bold">*</span>:
          </span>

          <template v-if="parameter.type === 'bool'">

            <div class="block mt-1">
              <label class="mr-3 cursor-pointer">
                <input
                  type="radio"
                  v-model="inputParameters[key]"
                  v-bind:value="'true'"
                > True
              </label>
              <label class="cursor-pointer">
                <input
                  type="radio"
                  v-model="inputParameters[key]"
                  v-bind:value="'false'"
                > False
              </label>
            </div>


          </template>

          <template v-else-if="parameter.options">
            <select
              class="block w-full mt-1 p-2 text-sm rounded-lg text-gray-900 border form-input"
              v-model="inputParameters[key]"
              :class="{'form-incomplete': isRequired(key) && !inputParameters[key], 'border-red-500' : isRequired(key) && !inputParameters[key] && showValidationError}"
            >
              <option class="text-gray-500" v-html="`Select ${key}`" value=""></option>
              <option
                v-for="(option, optionKey) in parameter.options"
                :key="`parameter-${option}-${optionKey}`"
                :value="option"
                >{{option}}</option>
            </select>
          </template>

          <template v-else>
            <input
              class="block w-full mt-1 p-2 text-sm rounded-lg text-gray-900 border form-input"
              :placeholder="key"
              v-model="inputParameters[key]"
              :class="{'form-incomplete': isRequired(key) && !inputParameters[key], 'border-red-500' : isRequired(key) && !inputParameters[key] && showValidationError}"
            >
          </template>
          <span
            class="text-xs text-red-600 text-red-400"
            v-if="isRequired(key) && !inputParameters[key] && showValidationError"
          >
            This field is required
          </span>
        </div>

      </template>

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
            <pre class="bg-black break-words max-w- p-5 text-xs text-yellow-500 whitespace-pre-wrap">{{serverResponseError}}</pre>
          </div>
        </Card>

        <template
          v-if="hasServerResponse"
        >
          <Card :title="`Server response - ${serverResponsePerformance}`">
            <div class="server-response-content">
              <pre class="bg-black break-words max-w- p-5 text-xs text-yellow-500 whitespace-pre-wrap">{{serverResponseContent}}</pre>
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
    ]),
    ...mapState('sandbox', [
      'sandboxResponses',
    ]),
    ...mapGetters([
      'getActiveRouteContent',
      'getRouteLink',
    ]),
    ...mapGetters('sandbox', [
      'getActiveRouteServerPerformance',
      'getActiveRouteServerResponse',
      'getActiveRouteHeaderInput',
      'getActiveRouteParameterInput',
    ]),
    ...mapGetters('globalOptions', [
      'getGlobalHeaderInput',
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
      let requestHtmlUrl;
      let params = this.getRouteLink.split('/');

      params = params.map((item) => {
        if (item.includes('{') && item.includes('}')) {
          const param = item.replace('{', '').replace('}', '');
          const newItem = this.inputParameters[param] ? this.inputParameters[param] : item;
          return `<span class="border-b border-black font-bold text-black">${newItem}</span>`;
        }
        return item;
      });

      requestHtmlUrl = params.join('/');

      if (this.activeMethod.toLowerCase() === 'get') {
        const data = JSON.parse(JSON.stringify(this.inputParameters));
        const getParams = new URLSearchParams();
        Object.keys(data).map((key) => {
          getParams.append(key, data[key]);
          return data[key];
        });
        return `${requestHtmlUrl}?${getParams}`;
      }

      return requestHtmlUrl;
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
    hasHeaders() {
      return Object.keys(this.headers).length;
    },
    hasParameters() {
      return Object.keys(this.parameters).length;
    },
    isFormUrlEncoded() {
      const inputHeaders = JSON.parse(JSON.stringify(this.inputHeaders));
      const headers = { headers: inputHeaders };

      if ((typeof headers.headers['Content-Type'] !== 'undefined' && headers.headers['Content-Type'] === 'application/x-www-form-urlencoded')
          || (typeof headers.headers['content-type'] !== 'undefined' && headers.headers['content-type'] === 'application/x-www-form-urlencoded')
      ) {
        return true;
      }

      return false;
    },
  },
  methods: {
    ...mapMutations('sandbox', [
      'setSandboxHeaderInput',
      'setSandboxParameterInput',
      'setSandboxResponses',
    ]),
    defaultValue(input, defaultContent = '') {
      if (typeof input === 'undefined') return defaultContent;

      return input;
    },
    isRequired(index, type = '') {
      if (type === 'headers') {
        return !!(typeof this.headers[index] !== 'undefined' && typeof this.headers[index].required !== 'undefined' && this.headers[index].required);
      }
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

      let data = JSON.parse(JSON.stringify(this.inputParameters));

      Object.keys(data).map((index) => {
        // convert to boolean values
        if (data[index] === 'false') data[index] = false;
        if (data[index] === 'true') data[index] = true;

        return index;
      });

      const inputHeaders = JSON.parse(JSON.stringify(this.inputHeaders));
      const headers = { headers: inputHeaders };
      const method = this.activeMethod;

      // console.log(data, headers, method);

      this.isRequesting = true;

      // clear old value
      this.setSandboxResponses({
        route: this.activeRoute,
        method: this.activeMethod,
        response: {},
      });

      this.setSandboxHeaderInput({
        route: this.activeRoute,
        method: this.activeMethod,
        headers: inputHeaders,
      });

      this.setSandboxParameterInput({
        route: this.activeRoute,
        method: this.activeMethod,
        parameters: data,
      });

      let axiosRequest = '';

      if (this.isFormUrlEncoded) {
        const params = new URLSearchParams();
        Object.keys(data).map((key) => {
          params.append(key, data[key]);
          return data[key];
        });
        data = params;
      }


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
          axiosRequest = axios.get(this.requestUrl, {
            headers: inputHeaders,
            params: data,
          });
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
            method: this.activeMethod,
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
              method: this.activeMethod,
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
        const headers = JSON.parse(JSON.stringify(this.headers));
        Object.keys(headers).map((key) => {
          const header = headers[key];

          let headerValue;

          if (typeof this.getActiveRouteHeaderInput[key] !== 'undefined') {
            // normal input
            headerValue = this.getActiveRouteHeaderInput[key];
          } else if (typeof this.getGlobalHeaderInput(key) !== 'undefined') {
            // global headers
            headerValue = this.getGlobalHeaderInput(key);
          } else {
            // default value
            headerValue = header.value;
          }

          return this.$set(this.inputHeaders, key, headerValue);
        });
      }
      if (this.parameters) {
        const parameters = JSON.parse(JSON.stringify(this.parameters));
        Object.keys(parameters).map((key) => {
          const parameter = parameters[key];
          let parameterValue = parameter.value;
          // console.log('parameter', parameter);
          if (typeof this.getActiveRouteParameterInput[key] !== 'undefined') {
            parameterValue = this.getActiveRouteParameterInput[key];
          } else if (parameter.type === 'bool') {
            parameterValue = typeof parameter.value !== 'undefined' ? parameter.value : 'false';
          }

          return this.$set(this.inputParameters, key, parameterValue);
        });
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
    sandboxResponses(val) {
      // console.log(val, this.getActiveRouteServerResponse);
    },
  },
};
</script>

<style lang="scss">
.server-response-content{
  position: relative;
  max-width: 850px;
  width: 100%;

  pre{
    max-height: 500px;
    overflow: auto;
  }
}

</style>
