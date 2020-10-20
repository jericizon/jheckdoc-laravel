<template>
<div
  class="flex h-screen bg-gray-100 dark:bg-gray-900"
  :class="{ 'overflow-hidden': isSideMenuOpen }"
>
  <!-- Desktop sidebar -->
  <aside
    class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0"
  >
    <div class="py-4 text-gray-500 dark:text-gray-400">
      <router-link
        class="flex justify-center items-center text-lg font-bold text-gray-800 dark:text-gray-200"
        :to="{url: '/'}"
      >
        <img
          alt="JheckDoc"
          width="50"
          height="50"
          :src="jheckDocLogo"
        >
        <span class="ml-2">Jheck Doc</span>
      </router-link>
      <ul class="mt-6">
        <li
          v-for="(routes, group) in getMenuLinks"
          :key="`group-menu-${group}`"
          :class="`menu-${group.split(' ').join('-')}`"
        >
          <div
            v-if="routes.length"
            class="relative px-6 py-3"
          >

            <div class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <span class="inline-flex items-center uppercase">
                {{group.split('_').join(' ').split('-').join(' ')}}
              </span>
            </div>

            <ul
              class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-100 dark:text-gray-400 dark:bg-gray-900"
              aria-label="submenu"
            >
              <li
                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                v-for="(route, key) in routes"
                :key="`menu-${key}`"
              >
                <span
                  v-if="activeMenu === `${route.url}__${route.method}`"
                  class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                  aria-hidden="true"
                ></span>
                <router-link
                  class="w-full block"
                  :to="{ name: 'app', query: { url: route.url, method: route.method }}"
                  :class="{'text-gray-700' : activeMenu === `${route.url}__${route.method}` }"
                >
                  {{ route.name }}
                </router-link>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </aside>
  <!-- Mobile sidebar -->
  <!-- Backdrop -->
  <div
    v-if="isSideMenuOpen"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
  ></div>
  <aside
    class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    v-show="isSideMenuOpen"
    @click.away="isSideMenuOpen = !isSideMenuOpen"
    @keydown.escape="isSideMenuOpen = !isSideMenuOpen"
  >
    <div class="py-4 text-gray-500 dark:text-gray-400">
      <router-link
        class="flex justify-center items-center text-lg font-bold text-gray-800 dark:text-gray-200"
        :to="{url: '/'}"
      >
        <img
          alt="JheckDoc"
          width="50"
          height="50"
          :src="jheckDocLogo"
        >
        <span class="ml-2">Jheck Doc</span>
      </router-link>
      <ul class="mt-6">
        <li
          v-for="(routes, group) in getMenuLinks"
          :key="`group-menu-${group}`"
          :class="`menu-${group.split(' ').join('-')}`"
        >
          <div
            v-if="routes.length"
            class="relative px-6 py-3"
          >

            <div class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <span class="inline-flex items-center uppercase">
                {{group}}
              </span>
            </div>

            <ul
              class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-100 dark:text-gray-400 dark:bg-gray-900"
              aria-label="submenu"
            >
              <li
                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                v-for="(route, key) in routes"
                :key="`menu-${key}`"
              >
                <span
                  v-if="activeMenu === `${route.url}__${route.method}`"
                  class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                  aria-hidden="true"
                ></span>
                <router-link
                  class="w-full block"
                  :to="{ name: 'app', query: { url: route.url, method: route.method }}"
                  :class="{'text-gray-700' : activeMenu === `${route.url}__${route.method}` }"
                >
                  {{ route.name }}
                </router-link>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </aside>
  <div class="flex flex-col flex-1 w-full">
    <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
      <div
        class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300"
      >
        <!-- Mobile hamburger -->
        <button
          class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
          @click="toggleSideMenu"
          aria-label="Menu"
        >
          <svg
            class="w-6 h-6"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </button>
        <!-- Search input -->
        <div class="flex justify-center flex-1 lg:mr-32">
          <div
            class="relative w-full max-w-xl mr-6 focus-within:text-purple-500"
          >
            <!-- <div class="absolute inset-y-0 flex items-center pl-2">
              <svg
                class="w-4 h-4"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </div>
            <input
              class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
              type="text"
              placeholder="Search for projects"
              aria-label="Search"
            /> -->
          </div>
        </div>
          <!-- Profile menu -->
        <ul>
          <li class="relative">

            <button
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              @click="showServerOptions = !showServerOptions"
              @keydown.escape="showServerOptions = false"
              aria-label="Server options"
              aria-haspopup="true"
            >
              <span class="inline-flex items-center">
                <span class="ml-4">{{serverUrl}}</span>
              </span>
              <svg
                v-if="hasMultipleServers"
                class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </button>
            <template v-if="hasMultipleServers && showServerOptions">
              <ul
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click.away="showServerOptions = false"
                @keydown.escape="showServerOptions = false"
                class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                aria-label="submenu"
              >
                <li
                  v-for="(server, key) in getServers"
                  :key="`server-options-${key}`"
                  class="relative px-2 cursor-pointer pb-3 hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                  :class="{'border-b' : key < getServers.length - 1}"
                  @click="setServerUrl(server.url)"
                >
                  <span
                    v-if="serverUrl === server.url"
                    aria-hidden="true" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                  ></span>
                  <span class="block w-full py-1 font-semibold transition-colors duration-150 rounded-md">
                    {{server.url}}
                  </span>
                  <span
                    v-if="server.description"
                    class="px-2 text-sm"
                  >
                    {{server.description}}
                  </span>
                </li>
              </ul>
            </template>
          </li>
        </ul>
      </div>
    </header>
    <main class="h-full overflow-y-auto">
      <div class="container px-6 mx-auto grid">

        <template v-if="showInfo">
          <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
          >
            {{appInfo.title}}
            <span
              v-if="appInfo.version"
              class="mb-1 text-gray-500 text-sm"
            >
              ({{appInfo.version}})
            </span>
          </h2>

          <p class="mb-1 text-gray-700 text-base font-medium">
            {{appInfo.description}}
          </p>

          <p>
            <a
              class="mb-1 text-purple-600 text-base font-medium"
              :href="`mailto:${appInfo.contact}`
            ">{{appInfo.contact}}</a>
          </p>

        </template>

        <template v-else>
          <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
          >
            {{getActiveRouteContent.name}}
          </h2>
          <div
            class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-white rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
            :class="badgeClass"
          >
            <div class="flex items-center">
              <span class="uppercase">{{activeMethod}}</span>
              <span> – {{getRouteLink}}</span>
            </div>
          </div>


          <p class="font-medium text-gray-700 mb-8" v-if="getActiveRouteContent.description">
            {{getActiveRouteContent.description}}
          </p>

          <HeadersTab :headers="getHeaders"></HeadersTab>

          <ParametersTab :parameters="getParameters"></ParametersTab>

          <ResponsesTab :responses="getResponses"></ResponsesTab>

          <SandboxTab
            :parameters="getParameters"
            :headers="getHeaders"
            :responses="getResponses"
          ></SandboxTab>

          </template>
      </div>
    </main>
  </div>
</div>
</template>

<script>

import {
  mapState, mapMutations, mapActions, mapGetters,
} from 'vuex';

import { base64Logo } from '../assets/js/utilities';

import ParametersTab from './components/ParametersTab.vue';
import ResponsesTab from './components/ResponsesTab.vue';
import HeadersTab from './components/HeadersTab.vue';
import SandboxTab from './components/SandboxTab.vue';

export default {
  name: 'App',
  components: {
    ParametersTab,
    ResponsesTab,
    HeadersTab,
    SandboxTab,
  },
  data() {
    return {
      tabs: [
        'parameters',
        'headers',
        'responses',
        'sandbox',
      ],
      jheckDocLogo: '',
      activeTab: 'parameters',
      activeMenu: '',
      menuIsActive: false,
      isSideMenuOpen: false,
      showServerOptions: false,
    };
  },
  computed: {
    ...mapState([
      'assetUrl',
      'activeRoute',
      'activeMethod',
      'serverUrl',
      'appInfo',
    ]),
    ...mapGetters([
      'getMenuLinks',
      'getActiveRouteContent',
      'getRouteLink',
      'getServers',
    ]),
    badgeClass() {
      const style = [];

      switch (this.activeMethod.toLowerCase()) {
        case 'post':
          style.push('bg-green-600');
          break;
        case 'put':
        case 'patch':
          style.push('bg-yellow-600');
          break;
        case 'delete':
          style.push('bg-red-600');
          break;
        default:
          style.push('bg-purple-600');
          break;
      }

      return style;
    },
    getParameters() {
      if (typeof this.getActiveRouteContent.params !== 'object') return '';

      return this.getActiveRouteContent.params;
    },
    getResponses() {
      if (typeof this.getActiveRouteContent.responses !== 'object') return '';

      return this.getActiveRouteContent.responses;
    },
    getHeaders() {
      if (typeof this.getActiveRouteContent.headers !== 'object') return '';

      return this.getActiveRouteContent.headers;
    },
    showInfo() {
      return !this.getRouteLink;
    },
    hasMultipleServers() {
      return typeof this.getServers !== 'undefined' && this.getServers.length > 1;
    },
  },
  methods: {
    ...mapActions([
      'updateInitStates',
    ]),
    ...mapMutations([
      'setActiveRoute',
      'setActiveMethod',
      'setServerUrl',
    ]),
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen;
    },
  },
  mounted() {
    this.jheckDocLogo = base64Logo();
    const axiosRequest = {
      method: 'GET',
      url: `${this.assetUrl}/fetchdata.json`,
    };
    axios(axiosRequest)
      .then((response) => {
        // console.log(response.data);
        this.updateInitStates(response.data);
      })
      .catch((error) => {

      })
      .then(() => {
        this.$nextTick(() => {
          const { query } = this.$route;
          this.setActiveRoute(query.url);
          this.setActiveMethod(query.method);


          this.activeMenu = `${query.url}__${query.method}`;
        });
      });
  },
  watch: {
    $route(to, from) {
      // react to route changes...
      // console.log('App.vue $route', to, from);
      const { query } = to;
      this.setActiveRoute(query.url);
      this.setActiveMethod(query.method);
      this.activeMenu = `${query.url}__${query.method}`;
    },
    serverUrl() {
      axios.defaults.baseURL = this.serverUrl;
    },
    getActiveRouteContent() {
      // console.log(this.getActiveRouteContent);
    },
    getParameters(val) {
      // console.log(val);
    },
  },
};
</script>
