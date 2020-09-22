<template lang="pug">
#sandbox-tab
  h3.title.is-3 Sandbox

  template(v-if="headers")

    Card(title="Headers")

      div.field.is-horizontal(
        v-for="(header, key) in inputHeaders"
        :key="`header-${key}`"
      )
        .field-label.is-normal
          label.label {{key}}

        .field-body
          .field
            p.control
              input.input(
                v-model="inputHeaders[key]"
              )

    template(v-if="parameters")
      Card(title="Parameters")
        div.field.is-horizontal(
          v-for="(parameter, key) in inputParameters"
          :key="`parameter-${key}`"
        )
          .field-label.is-normal
            label.label {{key}}
              span.required(v-if="parameters[key].required") &nbsp;*

          .field-body
            .field
              p.control
                input.input(
                  v-model="inputParameters[key]"
                  :class="{'form-incomplete': parameters[key].required && !inputParameters[key], 'is-danger' : parameters[key].required && !inputParameters[key] && showValidationError}"
                )
                span.mt-1.tag.is-danger(v-if="parameters[key].required && !inputParameters[key] && showValidationError") This field is required

    button.button.is-primary(
      @click="executeRequest"
      :disabled="isRequesting"
    ) Execute

    template(
      v-if="hasServerResponse"
    )
      hr
      h4.title.is-4 Server response

      Card(:title="`Response content - ${serverResponsePerformance}`")
        .server-response-content
          pre(
            v-html="serverResponseContent"
          )

      Card(title="Response headers")
        ul.server-response-headers
          li(
            v-for="(serverResponseHeader, key) in serverResponseHeaders"
            :key="`server-response-header-${key}`"
          ) {{key}} : {{serverResponseHeader}}

      Card(title="Request info")
        ul
          li Request URL: {{serverResponseConfig.url}}
          li Request Method: {{serverResponseConfig.method}}
          li Status code: {{serverResponseCode}}

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
      inputHeaders: {},
      inputParameters: {},
      isRequesting: false,
      showValidationError: false,
    };
  },
  computed: {
    ...mapState([
      'activeRoute',
      'sandboxResponses',
    ]),
    ...mapGetters([
      'getActiveRouteContent',
      'getActiveRouteServerResponse',
      'getActiveRouteServerPerformance',
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
  },
  methods: {
    ...mapMutations([
      'setSandboxResponses',
    ]),
    defaultValue(input, defaultContent = '') {
      if (typeof input === 'undefined') return defaultContent;

      return input;
    },
    executeRequest() {
      // console.log(this.getActiveRouteContent);

      if (document.getElementsByClassName('form-incomplete').length) {
        this.showValidationError = true;
        return;
      }

      const execStart = performance.now();

      const data = JSON.parse(JSON.stringify(this.inputParameters));
      const headers = JSON.parse(JSON.stringify(this.inputHeaders));
      const { method } = this.getActiveRouteContent;

      this.isRequesting = true;

      // clear old value
      this.setSandboxResponses({
        route: this.activeRoute,
        response: {},
      });

      let axiosRequest = '';

      if (method.toLowerCase() === 'post') {
        axiosRequest = axios.post;
      } else {
        axiosRequest = axios;
      }
      axiosRequest(this.activeRoute, data, headers)
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
          // console.log(error.response);

          const total = ((performance.now() - execStart) / 1000).toFixed(2);
          const execTime = `${total}s`;

          console.log(error.data);

          // this.setSandboxResponses({
          //   route: this.activeRoute,
          //   response: error.response,
          //   performance: execTime,
          // });
        })
        .then((always) => {
          // console.log('always', always);
          this.showValidationError = false;
          this.isRequesting = false;
        });
    },
  },
  mounted() {
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
  watch: {
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
