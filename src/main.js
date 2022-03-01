import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
// bootsrap 5
import "bootstrap/dist/css/bootstrap.min.css" // css
import "bootstrap" // js
// fontawesome
import "@fortawesome/fontawesome-free/css/all.min.css" // css
import "@fortawesome/fontawesome-free/js/all.min" // js
//
import Notifications from '@kyvg/vue3-notification'
//
axios.defaults.withCredentials = true
// eslint-disable-next-line
const app = createApp(App);
app.use(store);
app.use(router);
app.use(VueAxios, axios);
app.use(Notifications)
app.mount('#app')
