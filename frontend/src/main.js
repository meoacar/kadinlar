import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'

// Axios global config
axios.defaults.baseURL = 'http://localhost:8001/api'
axios.defaults.headers.common['Content-Type'] = 'application/json'

const app = createApp(App)

// Make axios available globally
app.config.globalProperties.$axios = axios

app.mount('#app')