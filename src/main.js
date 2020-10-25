import Vue from 'vue'
import Vuelidate from 'vuelidate'
import Auth from './Auth.vue'

Vue.config.productionTip = false
Vue.use(Vuelidate)

new Vue({
  render: h => h(Auth),
}).$mount('#app')
