import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import Vue from 'vue'
// import { createApp } from 'vue' -> para vue3
import App from './App.vue'
import store from './config/store'

Vue.config.productionTip = false

// createApp(App).mount('#app') -> para vue3
new Vue({
  store,
  render: h => h(App),
}).$mount('#app')
