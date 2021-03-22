import Vue from 'vue'
// import { createApp } from 'vue' -> para vue3
import App from './App.vue'

Vue.config.productionTip = false

// createApp(App).mount('#app') -> para vue3
new Vue({
  render: h => h(App),
}).$mount('#app')
