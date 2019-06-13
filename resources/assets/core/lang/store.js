import _ from 'lodash'

export const STORE_LOCALE = 'STORE_LOCALE'
export const CHANGE_LOCALE = 'CHANGE_LOCALE'
export const STORE_TERMS = 'STORE_TERMS'

const state = {
  locales: [],
  default: null,
  current: null,
  terms: []
}

const getters = {
  locales: state => {
    return state.locales
  },
  default: state => {
    return state.locales.find(el => el.code === state.default)
  },
  current: state => {
    return state.locales.find(el => el.code === state.current) || state.current
  },
  fallback: state => {
    return state.locales.splice(1)
  }
}

const actions = {
  setLocales: ({ commit }, payload) => {
    commit(STORE_LOCALE, payload)
  },
  changeLocale: ({ commit }, locale) => {
    commit(CHANGE_LOCALE, locale)
  },
  setTerms: ({ commit }, terms) => {
    const data = []
    Object.entries(terms).forEach(element => {
      data.push({ id: element[0], message: element[1] })
    })

    commit(STORE_TERMS, data)
  }
}

const mutations = {
  [STORE_LOCALE]: (state, payload) => {
    if (typeof payload.locales[0] === 'string') {
      payload.locales.forEach((locale, idx) => {
        payload.locales[idx] = { code: locale, nativeName: locale }
      })
    }

    if (_.isNil(payload.default)) {
      payload.default = payload.locales[0].code
    }

    state.locales = payload.locales
    state.default = payload.default
    state.current = existsLocale(payload.current) || payload.default
  },
  [CHANGE_LOCALE]: (state, locale) => {
    if (typeof existsLocale(locale) !== 'undefined') {
      state.current = locale
    }
  },
  [STORE_TERMS]: (state, terms) => {
    state.terms = terms
  }
}

function existsLocale (locale) {
  return state.locales.find(item => {
    return item.code === locale
  })
}

export const module = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
