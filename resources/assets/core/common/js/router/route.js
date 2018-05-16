import {trimEnd} from 'lodash'
import Router from '../router'

export default class Route {
  constructor (name, route) {
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

    let url = Router.baseURL + '/' + uri
    // 마지막 `/` 제거
    url = trimEnd(url, '/')

    return url
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
