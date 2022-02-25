import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
// bootsrap 5
import "bootstrap/dist/css/bootstrap.min.css" // css
import "bootstrap" // js
// bootsrap icons
import "bootstrap-icons/font/bootstrap-icons.css"
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import specific icons */
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
/* add icons to the library */
library.add(faUserSecret)
axios.defaults.withCredentials = true
// eslint-disable-next-line
const app = createApp(App);
app.component("font-awesome-icon", FontAwesomeIcon);
app.use(store);
app.use(router);
app.use(VueAxios, axios);
app.mount('#app')
