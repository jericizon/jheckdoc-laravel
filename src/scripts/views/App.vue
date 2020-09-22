<template lang="pug">
div
  nav.navbar
    div.navbar-brand
      a.navbar-item.jheckdoc-logo(
        href="javascript:void(0)"
      )
        img(
          alt="JheckDoc"
          width="50"
          height="50"
          :src="jheckDocLogo"
        )
        span.ml-2 Jheck Doc

      a.navbar-burger.burger(
        role="button"
        aria-label="menu"
        aria-expanded="false"
        data-target="main-menu"
      )
        span(aria-hidden="true")
        span(aria-hidden="true")
        span(aria-hidden="true")

  #main-wrapper
    div.left-col
      #main-menu.menu
        div(
          v-for="(routes, group) in getMenuLinks"
          :key="`group-menu-${group}`"
        )
          p.menu-label {{group}}

          ul.menu-list(
            :class="{'no-group' : group === 'ungrouped'}"
          )
            li(
              v-for="(route, key) in routes"
              :key="`menu-${key}`"
            )
              router-link(
                :class="{'is-active' : activeMenu === route.url}"
                :to="{ name: 'app', query: { url: route.url }}"
              ) {{ route.name }}


    div.right-col
      #main-content(v-if="getActiveRouteContent")
        h1.title.is-1 {{ getActiveRouteContent.name }}

        .notification.endpoint
          span.tag.method.is-success {{getActiveRouteContent.method}}
          span &nbsp; – {{getRouteLink}}

        p(
          v-if="getActiveRouteContent.description"
        ) {{ getActiveRouteContent.description }}

        hr

        .tabs
          ul
            li(
              v-for="(tab, key) in tabs"
              :key="`tab-${key}`"
              :class="{'is-active' : activeTab === tab}"
            )
              a(
                @click="activeTab = tab"
              ) {{ tab }}

        ParametersTab(
          v-if="activeTab === 'parameters'"
          :parameters="getParameters"
        )

        HeadersTab(
          v-if="activeTab === 'headers'"
          :headers="getHeaders"
        )

        ResponsesTab(
          v-if="activeTab === 'responses'"
          :responses="getResponses"
        )

        SandboxTab(
          v-if="activeTab === 'sandbox'"
          :parameters="getParameters"
          :headers="getHeaders"
          :responses="getResponses"
        )

</template>

<script>

import {
  mapState, mapMutations, mapActions, mapGetters,
} from 'vuex';

import Bulma from 'bulma';

import { base64Logo } from '../assets/utilities';

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
    };
  },
  computed: {
    ...mapState([
      'assetUrl',
      'activeRoute',
      'serverUrl',
    ]),
    ...mapGetters([
      'getMenuLinks',
      'getActiveRouteContent',
      'getRouteLink',
    ]),
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
  },
  methods: {
    ...mapActions([
      'updateInitStates',
    ]),
    ...mapMutations([
      'setActiveRoute',
    ]),
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
        });
      });
  },
  watch: {
    $route(to, from) {
      // react to route changes...
      // console.log('App.vue $route', to, from);
      const { query } = to;
      this.setActiveRoute(query.url);
    },
    activeRoute(val) {
      this.activeMenu = val;
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

<style lang="scss">

.navbar{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;

  & + div {
    margin-top: 60px;
  }

  .navbar-item{
    img{
      max-height: 100%;
    }
  }

}

#main-wrapper{
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  min-height: calc(100vh - 50px);

  > div{
    width: 100%;
  }

  .left-col{
    padding: 10px;
    max-width: 300px;
  }
  .right-col {
    max-width: calc(100% - 300px);
    padding: 20px;
  }
}
#main-menu {
  overflow-y: auto;
  height: 100%;
  position: fixed;
  top: 70px;
  left: 0;
  width: 300px;
  padding: 10px;
  padding-bottom: 50px;
  border-right: 1px solid #ccc;

    ul {
        margin-bottom: 50px;

        &.no-group{
            margin-bottom: 10px;
        }
    }

    li {
        a {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            text-transform: capitalize;
        }
    }
}

#main-content {
  max-width: 1080px;
  margin: auto;
}

.tabs{
  a{
    text-transform: capitalize;
  }
}
</style>
