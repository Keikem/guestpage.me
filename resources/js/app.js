require('./bootstrap');

window.Vue = require('vue').default;

import App from './components/App'
import store from './store'
import router from './router'
import vuetify from './plugins/vuetify'

Vue.component('app', require('./components/App.vue').default);

Vue.config.productionTip = false

new Vue({
    vuetify,
    router,
    store,
    render: h => h(App)
}).$mount('#app');
