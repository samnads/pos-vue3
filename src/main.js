import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
// bootsrap 5
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.min.js"
// bootsrap icons
import "bootstrap-icons/font/bootstrap-icons.css"
import "bootstrap"
// font awesome
import "@fortawesome/fontawesome-free/css/all.css";
axios.defaults.withCredentials = true
// eslint-disable-next-line
createApp(App).use(store).use(router).use(VueAxios, axios).mount('#app')
