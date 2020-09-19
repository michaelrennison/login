import Vue from 'vue'
import App from './App.vue'
import Login from "@/components/Login";
import Register from "@/components/Register";
import Welcome from "@/components/Welcome";
import VueRouter from "vue-router";
import RouterView from 'vue-router'
const config = require('../config.json');

Vue.config.productionTip = false
Vue.use(RouterView);
// Define the routes for the application to use
const routes = [
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/', name: 'welcome', component: Welcome}
]

const router = new VueRouter({
  routes // short for `routes: routes`
})
new Vue({
  data: function() {
    return {
      config
    }
  },
  router,
  render: h => h(App),
}).$mount('#app')
