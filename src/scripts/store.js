import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const assetUrl = typeof window.__JHECKDOC__ !== 'undefined' ? window.__JHECKDOC__.asset_url : process.env.VUE_APP_JHECKDOC_ASSETS;

export default new Vuex.Store({
  state: {
    assetUrl,
    version: '',
    mainUrl: '',
    serverUrl: '',
    routes: {},
    activeRoute: '',
    sandboxResponses: {},
  },
  mutations: {
    setAssetUrl(state, item) {
      state.assetUrl = item;
    },
    setVersion(state, item) {
      state.version = item;
    },
    setMainUrl(state, item) {
      state.mainUrl = item;
    },
    setServerUrl(state, item) {
      state.serverUrl = item;
    },
    setRoutes(state, item) {
      state.routes = item;
    },
    setActiveRoute(state, item) {
      state.activeRoute = item;
    },
    setSandboxResponses(state, item) {
      const { route, response, performance } = item;
      Vue.set(state.sandboxResponses, route, { response, performance });
    },
  },
  actions: {
    async updateInitStates({ state, commit }, item) {
      const {
        version, main_url, server_url, routes,
      } = item;

      commit('setVersion', version || '1.0.0');
      commit('setMainUrl', main_url || '');
      commit('setServerUrl', server_url || '');
      commit('setRoutes', routes || {});
    },
  },
  getters: {
    getMenuLinks: (state) => {
      if (Object.keys(state.routes).length === 0) return [];

      const menu = {};
      const entries = Object.entries(state.routes);

      for (const [key, value] of entries) {
        if (!value.group) {
          menu.push({
            url: key,
            name: value.name,
          });
        } else {
          if (typeof menu[value.group] === 'undefined') menu[value.group] = [];

          menu[value.group].push({
            url: key,
            name: value.name,
          });
        }
      }

      return menu;
    },
    getActiveRouteContent: (state) => {
      if (typeof state.routes[state.activeRoute] === 'undefined') return '';
      return state.routes[state.activeRoute];
    },
    getRouteLink: (state) => {
      if (!state.activeRoute) return '';
      return `${state.serverUrl}${state.activeRoute}`;
    },
    getActiveRouteServerResponse: (state) => {
      if (typeof state.sandboxResponses[state.activeRoute] === 'undefined') return {};
      return state.sandboxResponses[state.activeRoute].response;
    },
    getActiveRouteServerPerformance: (state) => {
      if (typeof state.sandboxResponses[state.activeRoute] === 'undefined') return {};
      return state.sandboxResponses[state.activeRoute].performance;
    },
  },
});
