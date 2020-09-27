import Vue from 'vue'
import App from './App.vue'
import Vuelidate from 'vuelidate'
import BootstrapVue from "bootstrap-vue"
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"

Vue.config.productionTip = false

Vue.use(Vuelidate)
Vue.use(BootstrapVue)


new Vue({
  render: h => h(App),
}).$mount('#app')
