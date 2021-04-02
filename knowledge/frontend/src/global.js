import axios from 'axios'
import Vue from 'vue'

export const http = axios.create({
    baseURL: 'http://localhost:8000/api/'
})

export const baseUrlApi = 'http://localhost:8000/api/'
// .interceptors.response.use((response) => {
//     console.log(response)
//     return response
// })

// Logar o erro no backend. Não está mostrando o erro no frontend. 
export function showError(e) {
    if(e && e.response && e.response.data) {
        Vue.toasted.global.defaultError({ msg : e.response.data })
    } else if(typeof e === 'string') {
        Vue.toasted.global.defaultError({ msg : e})
    } else {
        Vue.toasted.global.defaultError()
    }
}

export default { http, showError, baseUrlApi }