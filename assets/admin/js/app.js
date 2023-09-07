window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
window.axios.defaults.headers.common['Access-Control-Allow-Headers'] = '*';
window.axios.defaults.headers.common['Access-Control-Allow-Credentials'] = 'false';

import * as Vue from 'vue'
import { createApp } from 'vue'

import App from './vue/app.vue'
window.Vue = Vue;

import router from './router/index'
import store from './store/index';

import moment from 'moment';
var momentTZ = require('moment-timezone');

import 'moment/locale/en-gb';
momentTZ.locale('en-gb');
moment.tz.setDefault('America/Los_Angeles');

import stylesConfig from '../sass/_variables.module.scss';

import {LoadingPlugin} from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

import Antd from 'ant-design-vue';
import { notification } from "ant-design-vue";

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import MobilePlugin from '../../plugins/mobile.plugin.js';
import UtilsPlugin from '../../plugins/utils.plugin.js';

(async () => {
    
  const app = createApp(App)
    .use(router)
    .use(store)
    .use(Antd)
    .use(MobilePlugin)
    .use(UtilsPlugin)
    .use(LoadingPlugin, {
      height:40,
      color: stylesConfig.mainColor.replaceAll('"', '')
    });
  
  app.component('QuillEditor', QuillEditor);
  
  app.config.globalProperties.$_router = router;
  app.config.globalProperties.$_store = store;
  app.config.globalProperties.$moment = momentTZ;
  app.config.globalProperties.$http = axios;
  app.config.globalProperties.$stylesConfig = stylesConfig;
  app.config.globalProperties.$notification = notification;
  
  app.config.globalProperties.$filters = {
    filterDate(value) {
      return value? momentTZ(value).format('ll hh:mma') : null;
    }
  };
  
  setTimeout(() => {
    console.log('------->');
    console.log(document.getElementById('app-user-asnwer-form-admin'));
    app.mount('#app-user-asnwer-form-admin');
  }, 1000);
  
  window.appAdminUserForm = app;
  
  await store.dispatch('FETCH_STORE_SITE');
})();

