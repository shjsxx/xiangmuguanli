import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8000/api'; // 后端 API 地址

const app = createApp(App);
app.use(router);
app.mount('#app');