import Index from './index.vue';

window.Vue = require('vue');

import SuiVue from 'semantic-ui-vue';

Vue.component('index', require('./index.vue').default);

Vue.use(SuiVue);

const app = new Vue({
  el: '#app',
  components: {
    Index: Index,
  },
});
