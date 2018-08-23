import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'

Vue.use(Vuex)

const state = {
  url: {
    origin: (window && window.location) ? window.location.origin : '',
    fixedPrefix: 'plugin',
    settingsPrefix: 'settings'
  }
}

const getters = {
  urlOrigin: state => {
    return state.url.origin
  }
}

const actions = {}

export default new Vuex.Store({
  state,
  getters,
  actions,
  mutations
})
