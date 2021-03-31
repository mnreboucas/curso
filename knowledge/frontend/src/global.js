import axios from 'axios'

export const http = axios.create({
    baseURL: 'http://localhost:8000/api/'
})
// .interceptors.response.use((response) => {
//     console.log(response)
//     return response
// })