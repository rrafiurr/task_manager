/*
|--------------------------------------------------------------------------
| Main entry point
|--------------------------------------------------------------------------
| Files in the "resources/scripts" directory are considered entrypoints
| by default. 
| 
| -> https://vitejs.dev
| -> https://github.com/innocenzi/laravel-vite
*/

import { createApp } from 'vue'
import App from '@/views/App.vue'

import router from '../views/router'
import axios from 'axios'
import store from '../views/store'

const vueSetup = createApp(App)
vueSetup.use(router)
vueSetup.use(store)
vueSetup.mount('#app')
//createApp(App).mount('#app')
