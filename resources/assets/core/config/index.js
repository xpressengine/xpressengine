import Vue from 'vue'
import Vuex from 'vuex'
import { module as lang } from 'xe/lang/store'
import { module as router } from 'xe/router/store'
import { module as validator } from 'xe/validator/store'
import { module as request } from 'xe/request/store'
import { module as user } from 'xe/user/store'

Vue.use(Vuex)
Vue.config.productionTip = false

const store = () => new Vuex.Store({
  modules: {
    lang,
    request,
    router,
    user,
    validator
  }
})

export default store()
