
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import BootstrapVue3 from 'bootstrap-vue-3'

import '@/libs/axios'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'

// Import Bootstrap and BootstrapVue CSS files (order is important)

// Make BootstrapVue available throughout your project
//Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
//Vue.use(IconsPlugin)
import 'mosha-vue-toastify/dist/style.css'


import Echo from 'laravel-echo'

declare global {
    interface Window {
        Pusher: any,
        Echo: any; }
}
window.Pusher = require('pusher-js')

const token = store.getters['user/getToken']
if (token) {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.VUE_APP_MIX_PUSHER_APP_KEY,
        wsHost: process.env.VUE_APP_MIX_WS_HOST,
        authEndpoint: process.env.VUE_APP_MIX_BASE_URL_BACK + '/api/broadcasting/auth',
        encrypted: true,
        forceTLS: false,
        wsPort: 6001,
        wssPort: 6001,
        disableStats: true,
        enabledTransports: ['ws', 'wss'],
        auth: {
            headers: {
                authorization: 'Bearer ' + token,
            }
        }
    })

}

createApp(App)
    .use(store)
    .use(router)
    .use(BootstrapVue3)
    .mount('#app')

