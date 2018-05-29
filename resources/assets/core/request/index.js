import Singleton from 'xe/singleton'
import Axios from 'axios'
import Qs from 'qs'
import { eventify } from 'xe/common/js/utils'
import Router from 'xe/router'

import Config from './config'
import RequestEntity from './request_entity'
import ResponseEntity from './response_entity'
import RequestError from './errors/request.error'

export default class Request extends Singleton {
  constructor () {
    super()
    eventify(this)

    this.config = new Config()
  }

  boot (XE) {
    if (super.boot()) return

    XE.$on('setup', (eventName, options) => {
      this.setup(options)
    })
  }

  /**
   * ajax 옵션을 세팅한다.
   * @param {object} options jQuery ajax options
   */
  setup (options) {
    this.config.set(options)

    this.axiosInstance = Axios.create({
      baseURL: this.config.baseURL
    })

    this.axiosInstance.interceptors.response.use(response => {
      const res = new ResponseEntity(response)
      this.$emit('sucess', res)

      if (res.exposed) {
        this.$emit('exposed', res.exposed)
        res.removeExposed()
      }

      return res
    }, error => {
      const errorObj = new RequestError(error, error.response.request, error.response.data, error.response.headers)
      errorObj._axiosConfig = error.config
      this.$emit('error', errorObj)
      return Promise.reject(errorObj)
    })
  }

  /**
   *
   * @param {string} url
   * @param {object} params
   * @param {object} config
   * @return {Promise}
   */
  get (url, params = null, config = {}) {
    this.$emit('start', new RequestEntity({
      method: 'get',
      context: config.context
    }))

    url = this.resolveRoute(url)

    return this.axiosInstance.get(url, { params })
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
    this.$emit('start', new RequestEntity({
      method: 'post',
      context: config.context
    }))

    url = this.resolveRoute(url)

    return this.axiosInstance.post(url, this.prepareData(data), config)
  }

  /**
   *
   * @param {string} url
   * @param {object} data
   * @param {object} config
   * @return {Promise}
   */
  delete (url, data = null, config = {}) {
    this.$emit('start', new RequestEntity({
      method: 'delete',
      context: config.context
    }))
    data._method = 'delete' // @see https://laravel.com/docs/5.5/routing#form-method-spoofing

    url = this.resolveRoute(url)

    return this.axiosInstance.post(url, this.prepareData(data))
  }

  /**
   *
   * @param {string} url
   * @param {object} data
   * @param {object} config
   * @return {Promise}
   */
  put (url, data, config = {}) {
    this.$emit('start', new RequestEntity({
      method: 'put',
      context: config.context
    }))

    url = this.resolveRoute(url)

    return this.axiosInstance.put(url, this.prepareData(data), config)
  }

  /**
   *
   * @param {string} url
   * @param {object} data
   * @param {object} headers
   * @param {object} config
   * @return {Promise}
   */
  head (url, data = null, headers = null, config = {}) {
    this.$emit('start', new RequestEntity({
      method: 'head',
      context: config.context
    }))

    url = this.resolveRoute(url)

    return this.axiosInstance.head(url, { data: this.prepareData(data), headers })
  }

  prepareData (data) {
    if (typeof data === 'string') {
      return data
    } else {
      return Qs.stringify(data)
    }
  }

  resolveRoute (uri) {
    let routeName
    let params = {}
    let url

    if (Array.isArray(uri)) {
      routeName = uri[0]
      params = uri[1] || {}
    } else {
      routeName = uri
    }

    if (Router.instance.has(routeName)) {
      url = Router.instance.get(routeName).url(params)
    } else {
      url = uri
    }

    return url
  }
}

export const requestInstance = new Request()
