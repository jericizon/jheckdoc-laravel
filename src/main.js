import Vue from 'vue';
import axios from 'axios';
import BaseLayout from './scripts/BaseLayout.vue';
// import store from './store/store';
import store from './scripts/store/store';
import router from './scripts/router';

import * as BaseUI from './scripts/views/BaseUI';

import './scripts/assets/css/tailwind.css';

window.axios = axios;

// register all BaseUI components to be universally used
Object.values(BaseUI).forEach((Component) => {
  Vue.component(Component.name, Component);
});

new Vue({
  router,
  store,
  render: h => h(BaseLayout),
}).$mount('#app');
