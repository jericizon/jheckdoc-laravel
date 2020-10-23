import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';

import sandbox from './sandbox';
import globalOptions from './global-options';

Vue.use(Vuex);

const assetUrl = typeof window.__JHECKDOC__ !== 'undefined' ? window.__JHECKDOC__.asset_url : process.env.VUE_APP_JHECKDOC_ASSETS;

export default new Vuex.Store({
  modules: {
    sandbox,
    globalOptions,
  },
  state: {
    assetUrl,
    jheckdocVersion: '',
    appInfo: {},
    mainUrl: '',
    serverUrl: '',
    routes: {},
    activeRoute: '',
    activeMethod: '',
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
  },
  actions: {
    async updateInitStates({ state, commit }, item) {
      const {
        jheckdoc, main_url, info, routes,
      } = item;


      commit('setJheckDocVersion', jheckdoc || '1.0.0');
      commit('setMainUrl', main_url || '');
      commit('setAppInfo', info, {});
      commit('setRoutes', routes || {});

      if (typeof info === 'undefined') {
        commit('setServerUrl', '');
      } else {
        const { servers } = info;
        if (typeof servers !== 'undefined' && servers.length) {
          commit('setServerUrl', servers[0].url);
        }
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
    getServers: state => (typeof state.appInfo !== 'undefined' ? state.appInfo.servers : {}),
  },
});
