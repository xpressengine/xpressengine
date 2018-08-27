export const STORE_TOKEN = 'STORE_TOKEN'

const state = {
  xsrfToken: null
}

const getters = {
  xsrfToken: state => {
    return state.xsrfToken
  }
}

const actions = {
  setXsrfToken: ({ commit }, token) => {
    commit(STORE_TOKEN, token)
  }
}

const mutations = {
  [STORE_TOKEN]: (state, token) => {
    state.xsrfToken = token
  }
}

export const module = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
