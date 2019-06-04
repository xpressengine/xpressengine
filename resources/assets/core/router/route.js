import _ from 'lodash'
import config from 'xe/config'

/**
 * @class
 * @extends App
 */
class Route {
  constructor (router, name, route) {
    this.router = router
    this.name = name
    this.uri = route.uri
    this.methods = route.methods || []
    this.params = route.params || {}
  }

  /**
   *
   * @param {object} params
   * @return {string}
   */
  url (params = {}) {
    let uri = this.uri
    let _params = Object.assign({}, this.params, params)

    // params 치환
    for (const key in _params) {
      if (_params.hasOwnProperty(key)) {
        const val = _params[key]
        if (val) {
          uri = uri.replace(new RegExp('\{' + key + '\\??\}'), val)
        } else {
          const originVal = this.params[key]
          if (originVal) {
            uri = uri.replace(new RegExp('\{' + key + '\}'), originVal)
          }
        }
      }
    }

    // 값이 지정되지 않은 필수적이지 않은 params 제거
    uri = uri.replace(/\{[a-z_]+\?\}/i, '').replace('//', '/')

    return _.trimEnd(config.getters['router/origin'] + '/' + uri, '/#? ')
  }

  /**
   * @return {object}
   */
  getParams () {
    return this.params
  }

  /**
   * @return {array}
   */
  allowedMethods () {
    return this.methods
  }

  /**
   *
   * @param {string} method
   * @return {boolean}
   */
  isAllow (method) {
    let isAllow = true

    if (this.methods.length) {
      isAllow = this.methods.includes(method.toUpperCase())
    }

    return isAllow
  }
}

export default Route
