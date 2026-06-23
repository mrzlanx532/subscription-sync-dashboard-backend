import { createApp } from 'vue'
import './style.css'
import router from './router'
import Buefy from 'buefy'
import 'buefy/dist/css/buefy.css'
import App from './App.vue'

const app = createApp(App)

app.use(router)
app.use(Buefy)

app.mount('#app')