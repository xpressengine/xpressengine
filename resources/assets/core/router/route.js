import trimEnd from 'lodash/trimEnd'
import config from 'xe/config'

export default class Route {
  constructor (router, name, route) {
    this.router = router
    this.name = name
    this.uri = route.uri
    this.methods = route.methods || []
    this.params = route.params || {}
  }

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

    return trimEnd(config.getters.urlOrigin + '/' + uri, '/#? ')
  }

  getParams () {
    return this.params
  }

  allowedMethods () {
    return this.methods
  }

  isAllow (method) {
    let isAllow = true

    if (this.methods.length) {
      isAllow = this.methods.includes(method.toUpperCase())
    }

    return isAllow
  }
}
