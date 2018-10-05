export const STORE_RULES = 'STORE_RULES'

const state = {
  ruleSet: []
}

const getters = {
  rule: state => ruleName => {
    return state.ruleSet.find(element => element.ruleName === ruleName)
  }
}

const actions = {
  setRuleSet: ({ commit }, rules) => {
    commit(STORE_RULES, rules)
  }
}

const mutations = {
  [STORE_RULES]: (state, rules) => {
    state.ruleSet = rules
  }
}

export const module = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
