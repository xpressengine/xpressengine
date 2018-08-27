import { trimEnd } from 'xe/utils'

export const STORE_URL = 'STORE_URL'
export const STORE_LOCALE = 'STORE_LOCALE'
export const CHANGE_LOCALE = 'CHANGE_LOCALE'

export default {
  [STORE_URL]: (state, payload) => {
    payload.origin = trimEnd(payload.origin, '/#? ')
    state.url = Object.assign(state.url, payload)
  }
}
