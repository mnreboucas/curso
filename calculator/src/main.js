import Vue from 'vue'
import App from './App'

new Vue({
    render: h => h(App)
    // A função acima represeta o descrito 
    // abaixo.
    // render(createElement) {
    //     return createElement(App)
    // }
}).$mount('#app')