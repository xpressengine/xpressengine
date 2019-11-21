export const LOGIN = 'LOGIN'
export const LOGOUT = 'LOGOUT'

const state = {
  logged: false,
  id: null,
  rating: 'guest'
}

const getters = {
  id: state => {
    return state.id
  },
  logged: state => {
    return state.logged
  },
  rating: state => {
    return state.rating
  }
}

const actions = {
  login: ({ commit }, user) => {
    commit(LOGIN, user)
  },
  logout: ({ commit }) => {
    commit(LOGOUT)
  }
}

const mutations = {
  [LOGIN]: (state, payload) => {
    state.id = payload.id
    state.logged = true
    state.rating = payload.rating
  },
  [LOGOUT]: (state, payload) => {
    state.id = null
    state.logged = false
    state.rating = 'guest'
  }
}

export const module = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
