import Vue from 'vue';

const sandbox = {
  namespaced: true,
  state: {
    sandboxHeaderInput: {},
    sandboxParameterInput: {},
    sandboxResponses: {},
  },
  mutations: {
    setSandboxHeaderInput(state, item) {
      const { route, method, headers } = item;

      if (typeof state.sandboxHeaderInput[route] === 'undefined') {
        Vue.set(state.sandboxHeaderInput, route, {});
      }
      Vue.set(state.sandboxHeaderInput[route], method, headers);
    },
    setSandboxParameterInput(state, item) {
      const { route, method, parameters } = item;

      if (typeof state.sandboxParameterInput[route] === 'undefined') {
        Vue.set(state.sandboxParameterInput, route, {});
      }
      Vue.set(state.sandboxParameterInput[route], method, parameters);
    },
    setSandboxResponses(state, item) {
      const {
        route, method, response, performance,
      } = item;

      if (typeof state.sandboxResponses[route] === 'undefined') {
        Vue.set(state.sandboxResponses, route, {});
      }
      Vue.set(state.sandboxResponses[route], method, { response, performance });
    },
  },
  actions: {

  },
  getters: {
    getActiveRouteHeaderInput: (state, getters, rootState) => {
      const { activeRoute, activeMethod } = rootState;
      if (typeof state.sandboxHeaderInput[activeRoute] !== 'undefined' && typeof state.sandboxHeaderInput[activeRoute][activeMethod] !== 'undefined') {
        return state.sandboxHeaderInput[activeRoute][activeMethod];
      }
      return {};
    },
    getActiveRouteParameterInput: (state, getters, rootState) => {
      const { activeRoute, activeMethod } = rootState;
      if (typeof state.sandboxParameterInput[activeRoute] !== 'undefined' && typeof state.sandboxParameterInput[activeRoute][activeMethod] !== 'undefined') {
        return state.sandboxParameterInput[activeRoute][activeMethod];
      }
      return {};
    },
    getActiveRouteServerResponse: (state, getters, rootState) => {
      const { activeRoute, activeMethod } = rootState;
      if (typeof state.sandboxResponses[activeRoute] !== 'undefined' && typeof state.sandboxResponses[activeRoute][activeMethod] !== 'undefined') {
        return state.sandboxResponses[activeRoute][activeMethod].response;
      }
      return {};
    },
    getActiveRouteServerPerformance: (state, getters, rootState) => {
      const { activeRoute, activeMethod } = rootState;
      if (typeof state.sandboxResponses[activeRoute] !== 'undefined' && typeof state.sandboxResponses[activeRoute][activeMethod] !== 'undefined') {
        return state.sandboxResponses[activeRoute][activeMethod].performance;
      }
      return {};
    },
  },
};

export default sandbox;
