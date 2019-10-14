import { trimEnd } from 'xe/utils'

const namespaced = true

export const STORE_URL = 'STORE_URL'
export const CHANGE_ORIGIN = 'CHANGE_ORIGIN'
export const STORE_ROUTES = 'STORE_ROUTES'

const state = {
  origin: (window && window.location) ? window.location.origin : '',
  assetsOrigin: (window && window.location) ? window.location.origin : '',
  fixedPrefix: 'plugin',
  settingsPrefix: 'settings',
  routes: {}
}

const getters = {
  origin: state => {
    return state.origin
  },
  assetsOrigin: state => {
    return state.assetsOrigin
  }
}

const actions = {
  setUrl: ({ commit }, payload) => {
    commit(STORE_URL, payload)
  },
  changeOrigin: ({ commit }, origin) => {
    commit(CHANGE_ORIGIN, origin)
  },
  setRoutes: ({ commit }, routes) => {
    commit(STORE_ROUTES, routes)
  }
}

const mutations = {
  [STORE_URL]: (state, payload) => {
    payload.origin = trimEnd(payload.origin, '/#? ')
    payload.assetsOrigin = trimEnd(payload.assetsOrigin, '/#? ')
    state = Object.assign(state, payload)
  },
  [CHANGE_ORIGIN]: (state, origin) => {
    state.origin = trimEnd(origin, '/#? ')
  },
  [STORE_ROUTES]: (state, routes) => {
    state.routes = routes
  }
}

export const module = {
  namespaced,
  state,
  getters,
  actions,
  mutations
}
