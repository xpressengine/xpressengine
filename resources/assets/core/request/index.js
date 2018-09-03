import App from 'xe/app'
import Axios from 'axios'
import Qs from 'qs'
import { eventify } from 'xe/utils'
import $ from 'jquery'

import Config from './config'
import RequestEntity from './request_entity'
import ResponseEntity from './response_entity'
import RequestError from './errors/request.error'
import { STORE_TOKEN } from './store';

/**
 * @class
 * @extends App
 */
class Request extends App {
  constructor () {
    super()
    eventify(this)

    this.config = new Config()
    this.options = {
      headers: {
        'X-CSRF-TOKEN': this.$$config.getters['request/xsrfToken']
      }
    }
  }

  static appName () {
    return 'Request'
  }

  /**
   *
   * @param {XE} XE
   * @return {Promise}
   */
  boot (XE) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE)

      this.$$config.subscribe((mutation, state) => {
        if (mutation.type === `request/${STORE_TOKEN}`) {
          this.options.headers['X-CSRF-TOKEN'] = state.request.xsrfToken
        }
      })

      XE.$$on('setup', (eventName, options) => {
        this.setup(options)
      })

      XE.getApp('Router').then(app => {
        this.router = app
      })

      resolve(this)
    })
  }

  /**
  * ajax 옵션을 세팅한다.
  * @param {object} options jQuery ajax options
  */
  setup (options) {
    this.config.set(options)

    this.axiosInstance = Axios.create({
      baseURL: this.$$config.getters['router/origin']
    })

    this.axiosInstance.interceptors.response.use(response => {
      const res = new ResponseEntity(response)
      this.$$emit('sucess', res)

      if (res.exposed) {
        this.$$emit('exposed', res.exposed)
        res.removeExposed()
      }

      return res
    }, error => {
      const errorObj = new RequestError(error, error.response.request, error.response.data, error.response.headers)
      errorObj._axiosConfig = error.config
      this.$$emit('error', errorObj)
      return Promise.reject(errorObj)
    })
  }

  /**
   *
   * @param {string} url
   * @param {*} options
   * @param {*} axiosConfig
   * @return {Axios}
   */
  request (url, options, axiosConfig = {}) {
    this.$$emit('start', new RequestEntity({
      method: (options.method === 'delete') ? 'post' : options.method,
      container: (options.container) ? options.container : $('body')
    }))

    axiosConfig = Object.assign({}, axiosConfig)
    axiosConfig.url = this.resolveRoute(url)
    axiosConfig.method = options.method || 'get'
    axiosConfig.data = options.data
    axiosConfig.params = options.params
    // axiosConfig.headers = Object.assign({}, this.axiosInstance.defaults.headers[axiosConfig.method], options.headers)
    axiosConfig.container = (options.container) ? options.container : $('body')

    return this.axiosInstance.request(axiosConfig)
  }

  /**
  *
  * @param {string} url
  * @param {object} params
  * @param {object} config
  * @return {Promise}
  */
  get (url, params = null, config = {}) {
    config.method = 'get'
    return this.request(url, Object.assign({}, { params }, config))
  }

  /**
  * ajax를 method post 방식으로 호출한다.
  * @param {string} url
  * @param {object} data
  * @param {function} success
  * @param {string} dataType
  * @return {Promise}
  */
  post (url, data, config = {}) {
    config.method = 'post'
    return this.request(url, Object.assign({}, { data: this.prepareData(data) }, config))
  }

  /**
  *
  * @param {string} url
  * @param {object} data
  * @param {object} config
  * @return {Promise}
  */
  delete (url, params = null, config = {}) {
    config.method = 'delete'
    return this.request(url, Object.assign({}, { params }, config))
  }

  /**
  *
  * @param {string} url
  * @param {object} data
  * @param {object} config
  * @return {Promise}
  */
  put (url, data, config = {}) {
    config.method = 'put'
    return this.request(url, Object.assign({}, { data }, config))
  }

  /**
  *
  * @param {string} url
  * @param {object} data
  * @param {object} headers
  * @param {object} config
  * @return {Promise}
  */
  head (url, params = null, headers = null, config = {}) {
    config.method = 'head'
    return this.request(url, Object.assign({}, { params, headers }, config))
  }

  prepareData (data) {
    if (typeof data === 'string') {
      return data
    } else {
      return Qs.stringify(data)
    }
  }

  resolveRoute (uri) {
    if (!this.router) return

    let routeName
    let params = {}
    let url

    if (Array.isArray(uri)) {
      routeName = uri[0]
      params = uri[1] || {}
    } else {
      routeName = uri
    }

    if (this.router.has(routeName)) {
      url = this.router.get(routeName).url(params)
    } else {
      url = uri
    }

    return url
  }
}

export default Request
export const requestInstance = new Request()
