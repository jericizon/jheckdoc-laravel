import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const assetUrl = typeof window.__JHECKDOC__ !== 'undefined' ? window.__JHECKDOC__.asset_url : process.env.VUE_APP_JHECKDOC_ASSETS;

export default new Vuex.Store({
  state: {
    assetUrl,
    jheckdocVersion: '',
    appInfo: {},
    mainUrl: '',
    serverUrl: '',
    routes: {},
    activeRoute: '',
    activeMethod: '',
    sandboxResponses: {},
  },
  mutations: {
    setAssetUrl(state, item) {
      state.assetUrl = item;
    },
    setAppInfo(state, item) {
      state.appInfo = item;
    },
    setJheckDocVersion(state, item) {
      state.jheckdocVersion = item;
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
    setActiveMethod(state, item) {
      state.activeMethod = item;
    },
    setSandboxResponses(state, item) {
      const { route, response, performance } = item;
      Vue.set(state.sandboxResponses, route, { response, performance });
    },
  },
  actions: {
    async updateInitStates({ state, commit }, item) {
      const {
        jheckdoc, main_url, info, routes,
      } = item;

      const { servers } = info;

      commit('setJheckDocVersion', jheckdoc || '1.0.0');
      commit('setMainUrl', main_url || '');
      commit('setAppInfo', info, {});
      // commit('setServerUrl', server_url || '');
      commit('setRoutes', routes || {});

      if (servers.length) {
        commit('setServerUrl', servers[0].url);
      }
    },
  },
  getters: {
    getMenuLinks: (state) => {
      if (Object.keys(state.routes).length === 0) return [];

      const menu = {};
      const entries = Object.entries(state.routes);

      menu.ungrouped = [];

      entries.map((item) => {
        const routeUrl = item[0];
        const routeItem = state.routes[routeUrl];

        Object.keys(routeItem).map((method) => {
          const route = routeItem[method];
          if (!route.group) {
            menu.ungrouped.push({
              url: routeUrl,
              name: route.name,
              method,
            });
          } else {
            if (typeof menu[route.group] === 'undefined') menu[route.group] = [];
            menu[route.group].push({
              url: routeUrl,
              name: route.name,
              method,
            });
          }
        });
      });

      return menu;
    },
    getActiveRouteContent: (state) => {
      if (typeof state.routes[state.activeRoute] !== 'undefined' && typeof state.routes[state.activeRoute][state.activeMethod] !== 'undefined') {
        return state.routes[state.activeRoute][state.activeMethod];
      }
      return '';
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
    getServers: state => state.appInfo.servers,
  },
});
