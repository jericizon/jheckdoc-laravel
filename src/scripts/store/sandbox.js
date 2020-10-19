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
      const { route, headers } = item;
      Vue.set(state.sandboxHeaderInput, route, headers);
    },
    setSandboxParameterInput(state, item) {
      const { route, parameters } = item;
      Vue.set(state.sandboxParameterInput, route, parameters);
    },
    setSandboxResponses(state, item) {
      const { route, response, performance } = item;
      Vue.set(state.sandboxResponses, route, { response, performance });
    },
  },
  actions: {

  },
  getters: {
    getActiveRouteHeaderInput: (state, getters, rootState) => {
      if (typeof state.sandboxHeaderInput[rootState.activeRoute] === 'undefined') return {};
      return state.sandboxHeaderInput[rootState.activeRoute];
    },
    getActiveRouteParameterInput: (state, getters, rootState) => {
      if (typeof state.sandboxParameterInput[rootState.activeRoute] === 'undefined') return {};
      return state.sandboxParameterInput[rootState.activeRoute];
    },
    getActiveRouteServerResponse: (state, getters, rootState) => {
      if (typeof state.sandboxResponses[rootState.activeRoute] === 'undefined') return {};
      return state.sandboxResponses[rootState.activeRoute].response;
    },
    getActiveRouteServerPerformance: (state, getters, rootState) => {
      if (typeof state.sandboxResponses[rootState.activeRoute] === 'undefined') return {};
      return state.sandboxResponses[rootState.activeRoute].performance;
    },
  },
};

export default sandbox;
