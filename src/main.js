// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import 'core-js/es6/promise'
import 'core-js/es6/string'
import 'core-js/es7/array'
// import cssVars from 'css-vars-ponyfill'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import router from './router'
import VeeValidate from "vee-validate";
import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

// todo
// cssVars()

Vue.use(BootstrapVue)
Vue.use(require('vue-moment'));
Vue.use(VeeValidate, {
  validity: true
});
Vue.use(Datetime)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: {
    App
  }
})
