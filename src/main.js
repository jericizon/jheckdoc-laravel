import Vue from 'vue';
import axios from 'axios';
import BaseLayout from './scripts/BaseLayout.vue';
// import store from './store/store';
import store from './scripts/store';
import router from './scripts/router';

window.axios = axios;

new Vue({
  router,
  store,
  render: h => h(BaseLayout),
}).$mount('#app');
