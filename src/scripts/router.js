import Vue from 'vue';
import Router from 'vue-router';
import App from './views/App.vue';
// import PageNotFound from './views/PageNotFound.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  base: '/jheckdoc',
  routes: [
    {
      path: '/',
      name: 'app',
      component: App,
    },
    // { path: '*', component: PageNotFound },
  ],
});
