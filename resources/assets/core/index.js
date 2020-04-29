// external libraries
// import $ from 'jquery'
import blankshield from 'blankshield'
import moment from 'moment'
import URI from 'urijs'
import config from 'xe/config'
import lodash from 'lodash'
import qs from 'qs'

// internal libraries
import * as $$ from 'xe/utils'
import Component from 'xe/component'
import DynamicLoadManager from 'xe/dynamic-load-manager'
import Form from 'xe/form'
import Griper from 'xe/griper'
import Lang from 'xe/lang'
import MediaLibrary from 'xe/media_library'
import Progress from 'xe/common/js/progress'
import Request from 'xe/request'
import Router from 'xe/router'
import Translator from 'xe/common/js/translator'
import Validator from 'xe/validator'
import { STORE_URL, CHANGE_ORIGIN } from './router/store'
import { STORE_LOCALE, CHANGE_LOCALE } from './lang/store'
import { STORE_TOKEN } from './request/store'

const booted = Symbol('booted')
const symbolApp = Symbol('App')
const $ = window.$

const defaultConfig = {
  baseURL: window.location.origin,
  fixedPrefix: 'plugin',
  settingsPrefix: 'settings',
  useXeSpinner: true,
  translation: {
    locales: [
      { code: 'ko', nativeName: '한국어' },
      { code: 'en', nativeName: 'English' }
    ]
  }
}

/**
 * XE
 * @class XE
 * @borrows EventEmitter#$$emit
 * @borrows EventEmitter#$$on
 * @borrows EventEmitter#$$once
 * @borrows EventEmitter#$$off
 * @borrows EventEmitter#$$offAll
 * @borrows config
 */
class XE {
  constructor () {
    if (typeof window.XE !== 'undefined') return window.XE
    window.XE = this

    $$.eventify(this)
    this[booted] = false
    this[symbolApp] = new Map()
    // @deprecated
    this.options = defaultConfig
    this.config = config

    this.config.subscribe((mutation, state) => {
      if (mutation.type === `router/${STORE_URL}`) {
        this.options.baseURL = state.router.origin
        this.options.fixedPrefix = state.router.fixedPrefix
        this.options.settingsPrefix = state.router.settingsPrefix
      } else if (mutation.type === `router/${CHANGE_ORIGIN}`) {
        this.options.baseURL = state.router.origin
      } else if (mutation.type === `lang/${STORE_LOCALE}`) {
        this.options.translation.locales = []
        state.lang.locales.forEach(locale => {
          this.options.translation.locales.push(locale.code)
        })
        this.options.translation.defaultLocale = state.lang.default
        this.options.translation.locale = state.lang.current
      } else if (mutation.type === `lang/${CHANGE_LOCALE}`) {
        this.options.locale = state.lang.current
      } else if (mutation.type === `request/${STORE_TOKEN}`) {
        this.options.locale = state.lang.current
      }
    })

    // internal libraries
    this.Utils = $$
    this.Griper = this.registerApp('Griper', new Griper())
    this.Progress = this.registerApp('Progress', Progress)
    this.Router = this.registerApp('Router', new Router())
    this.Request = this.registerApp('Request', new Request())
    this.Lang = this.registerApp('Lang', new Lang())
    this.DynamicLoadManager = this.registerApp('DynamicLoadManager', new DynamicLoadManager())
    this.Validator = this.registerApp('Validator', new Validator())
    this.Form = this.registerApp('Form', new Form())
    this.Component = this.registerApp('Component', new Component())
    this.MediaLibrary = this.registerApp('MediaLibrary', new MediaLibrary())

    // external libraries
    this._ = lodash
    this.moment = moment // @DEPRECATED
    this.Translator = Translator // @DEPRECATED
  }

  /**
   *
   * @param {*} name App Name
   * @param {*} callback pass instance
   * @return {Promise}
   */
  app (name, callback) {
    const app = this[symbolApp].get(name)

    if (typeof callback === 'function') {
      callback(app)
    }

    return app.boot(this, this.options) // return promise
  }

  registerApp (name, appInstance) {
    if (!this[symbolApp].has(name)) {
      this[symbolApp].set(name, appInstance)
    }

    return appInstance
  }

  intercept (appName, pointcut) {
    const app = this.app(appName)
    return app.intercept(pointcut)
  }

  boot () {
    if (this[booted]) {
      Promise.resolve()
    }

    this[booted] = true

    this.Request.$$on('exposed', (eventName, exposed) => {
      if (exposed.assets) {
        if (exposed.assets.js) {
          this.DynamicLoadManager.jsLoadMultiple(exposed.assets.js)
        }

        if (exposed.assets.css) {
          exposed.assets.css.forEach((src) => {
            this.DynamicLoadManager.cssLoad(src)
          })
        }
      }

      this.Router.addRoutes(exposed.routes)

      this.Lang.set(exposed.translations)

      if (exposed.rules) {
        Object.entries(exposed.rules).forEach((rule) => {
          if (rule[1]) {
            this.Validator.setRules(rule[0], rule[1])
          }
        })
      }

      return Promise.resolve()
    })

    $(() => {
      const isChrome = window.navigator.userAgent.indexOf('Chrome/') > -1

      $('form').each((idx, form) => {
        /* eslint no-new:off */
        this.Form.get(form)
      })

      $('xe-content').each((idx, element) => {
        this.$$emit('content.render', { element })
      })

      $('body').on('click', 'a[target]', (e) => {
        const $this = $(e.target)
        const href = String($this.attr('href')).trim()
        const target = String($this.attr('target')).trim()

        if (!href) return
        if (!target || target === '_top' || target === '_self' || target === '_parent') return
        if (!href.match(/^(https?:\/\/)/)) return
        if (this.isSameHost(href)) return
        if ($this.closest('.xe-content-editable').length) return

        let rel = $this.attr('rel')

        if (typeof rel === 'string') {
          $this.attr('rel', rel + ' noopener')
        } else {
          $this.attr('rel', 'noopener')
        }

        // https://github.com/xpressengine/xpressengine/issues/980
        if (isChrome) {
          return
        }

        e.preventDefault()
        blankshield.open(href)
      })
    })

    return Promise.all([
      this.Griper.boot(this, this.options),
      this.Router.boot(this, this.options),
      this.Request.boot(this, this.options),
      this.Lang.boot(this, this.options),
      this.DynamicLoadManager.boot(this, this.options),
      this.Form.boot(this, this.options),
      this.Validator.boot(this, this.options),
      this.Component.boot(this, this.options),
      this.MediaLibrary.boot(this, this.options)
    ])
      .then(() => {
        // @FIXME
        $(document).ajaxSend((event, jqxhr, settings) => {
          if (settings.useXeSpinner) {
            Progress.start((typeof settings.context === 'undefined') ? $('body') : settings.context)
          }
        }).ajaxComplete((event, jqxhr, settings) => {
          if (settings.useXeSpinner) {
            Progress.done((typeof settings.context === 'undefined') ? $('body') : settings.context)
          }
        }).ajaxError((event, jqxhr, settings, thrownError) => {
          if (settings.useXeSpinner) {
            Progress.done()
          }

          if (settings.useXeToast === false) {
            return
          }

          const status = jqxhr.status
          let errorMessage = 'Not defined error message (' + status + ')'

          // @TODO dataType 에 따라 메시지 획득 방식을 추가 해야함.
          if (jqxhr.status === 422) {
            var list = JSON.parse(jqxhr.responseText).errors || {}

            errorMessage = ''
            errorMessage += '<ul>'
            for (var i in list) {
              errorMessage += '<li>' + list[i] + '</li>'
            }

            errorMessage += '</ul>'
          } else if (settings.dataType === 'json') {
            errorMessage = JSON.parse(jqxhr.responseText).message
          } else {
            errorMessage = jqxhr.statusText
          }

          this.toastByStatus(status, errorMessage)
        })

        // @FIXME 분리
        this.Request.$$on('start', (eventName, options) => {
          Progress.start((typeof options.container === 'undefined') ? 'body' : options.container)
          return Promise.resolve()
        })
        this.Request.$$on('sucess', (eventName, options) => {
          Progress.done((typeof options.container === 'undefined') ? 'body' : options.container)
          return Promise.resolve()
        })
        this.Request.$$on('error', (eventName, error) => {
          Progress.done((typeof error._axiosConfig.container === 'undefined') ? 'body' : error._axiosConfig.container)

          let errorMessage = ''

          if (error.status === 422) {
            var list = error.data.errors || {}

            errorMessage = error.data.message
            errorMessage += '<ul>'
            for (var i in list) {
              errorMessage += '<li>' + list[i] + '</li>'
            }

            errorMessage += '</ul>'
          } else if (error.request.responseType === 'json') {
            errorMessage = JSON.parse(error.request.responseText).message
          } else {
            errorMessage = error.statusText

            if (error.data && error.data.message) {
              errorMessage = error.data.message
            }
          }

          this.toastByStatus(error.status, errorMessage)

          return Promise.resolve()
        })
      })
      .catch((e) => {
        console.debug('app.promise error', e)
      })
  }

  /**
   * XE 기본설정을 세팅한다.
   * @param {object} options
   * <pre>
   *   - loginUserId
   *   - X-CSRF-TOKEN : CSRF Token 값 세팅
   *   - useXESpinner : ajax요청시 UI상에 spinner 사용여부
   * </pre>
   */
  setup (options = {}) {
    this.configure(options)
    this.boot().then(() => {
      this.$$emit('setup', this.options)
    })
  }

  configure (options = {}) {
    const config = Object.assign({}, defaultConfig, options)
    this.options = Object.assign({}, this.options, config)

    if (config.routes) {
      this.config.dispatch('router/setRoutes', config.routes)
    }

    if (config.translation.locales) {
      this.config.dispatch('lang/setLocales', {
        locales: config.translation.locales,
        default: config.defaultLocale,
        current: config.locale
      })
    }

    if (config.translation.terms) {
      this.config.dispatch('lang/setTerms', config.translation.terms)
    }
    this.config.dispatch('request/setXsrfToken', config.userToken)
    if (config.ruleSet) {
      this.config.dispatch('validator/setRuleSet', config.ruleSet)
    }
    if (config.user) {
      this.config.dispatch('user/login', config.user)
    }
  }

  route (routeName, params = {}) {
    return this.Router.get(routeName).url(params)
  }

  /**
   * css 파일을 로드한다.
   * @param {url} url css file path
   * @DEPRECATED
   */
  cssLoad (url, load, error) {
    this.DynamicLoadManager.cssLoad(url, load, error)
  }

  /**
   * js 파일을 로드한다.
   * @param {string} url js file path
   * @DEPRECATED
   */
  jsLoad (url, load, error) {
    this.DynamicLoadManager.jsLoad(url)
  }

  /**
   * Ajax를 요청한다.
   * @param {string|object} url request url
   * @param {object} options jQuery ajax options
   */
  ajax (url, options) {
    if (typeof url === 'object') {
      options = $.extend({}, this.Request.config, { headers: { 'X-CSRF-TOKEN': this.config.getters['request/xsrfToken'] } }, url)
      url = undefined
    } else {
      options = $.extend({}, options, this.Request.config, { headers: { 'X-CSRF-TOKEN': this.config.getters['request/xsrfToken'] } }, { url: url })
      url = undefined
    }

    var requestMethod = options.type || options.method

    if (requestMethod === 'put' || requestMethod === 'delete') {
      if (typeof options.data === 'string') {
        options.data = qs.parse(options.data)
      }

      if (typeof options.data === 'undefined') {
        options.data = {}
      }

      options.data._method = requestMethod
      options.data = qs.stringify(options.data)
      options.type = options.method = 'post'
    }

    return $.ajax(url, options)
  }

  /**
   * @alias Request.get
   */
  get (...args) {
    return this.Request.get(...args)
  }

  /**
   * @alias Request.post
   */
  post (...args) {
    return this.Request.post(...args)
  }

  /**
   * @alias Request.put
   */
  put (...args) {
    return this.Request.put(...args)
  }

  /**
   * @alias Request.delete
   */
  delete (...args) {
    return this.Request.delete(...args)
  }

  /**
   * 주어진 URL이 현재 호스트와 동일 호스트인지 확인
   * @param {string|object} url request url
   * @param {object} options jQuery ajax options
   * @return {boolean}
   */
  isSameHost (url) {
    if (typeof url !== 'string') return false

    const base = {
      url: URI(this.config.getters['router/origin']).normalizePathname()
    }
    const target = {
      url: URI(url).normalizePathname()
    }

    if (target.url.is('urn')) return false

    if (!target.url.hostname()) {
      target.url = target.url.absoluteTo(this.config.getters['router/origin'])
    }

    base.port = Number(base.url.port())
    target.port = Number(target.url.port())
    base.protocol = base.url.protocol()
    target.protocol = target.url.protocol() || base.protocol

    // port
    if (!base.port) {
      base.port = (base.protocol === 'http') ? 80 : 443
    }
    if (!target.port) {
      target.port = (target.protocol === 'http') ? 80 : 443
    }

    if (base.port !== target.port) {
      return false
    }

    // protocol
    if (![80, 443].includes(base.port)) {
      if (base.protocol !== target.protocol) {
        return false
      }
    }

    base.url = base.url.hostname() + base.url.directory()
    target.url = target.url.hostname() + target.url.directory()

    return target.url.indexOf(base.url) === 0
  }

  /**
   * type에 따른 토스트 팝업을 출력한다.
   * @param {string} type
   * <pre>
   *   - danger
   *   - positive
   *   - warning
   *   - success
   *   - info
   *   - fail
   *   - error
   * </pre>
   * @param {string} message 토스트 팝업에 노출할 메시지
   * @param {string} pos default 'bottom'
   * <pre>
   *   - top
   *   - topLeft
   *   - topRight
   *   - bottom
   *   - bottomLeft
   *   - bottomRight
   * </pre>
   */
  toast (type = 'danger', message, pos) {
    this.Griper.toast(type, message, pos)
  }

  /**
   * status에 따른 토스트 팝업을 출력한다.
   * @param {number}
   * <pre>
   *   - 500 : danger
   *   - 401 : warning
   * </pre>
   * @param {string} 팝업에 출력될 메시지
   */
  toastByStatus (status, message) {
    this.Griper.toast(this.Griper.toast.fn.statusToType(status), message)
  }

  /**
   * 폼 요소 엘리먼트에 메시지를 출력한다.
   * @param {object} form element object
   * @param {string} message 엘리먼트에 출력될 메시지
   */
  formError ($element, message) {
    this.Griper.form($element, message)
  }

  /**
   * 폼 요소의 메시지를 모두 제거한다.
   * @param {object} jquery form object
   */
  formErrorClear ($form) {
    return this.Griper.form.fn.clear($form)
  }

  /**
   * 설정된 폼의 유효성 체크를 한다.
   * @param {object} jquery form object
   */
  formValidate ($form) {
    this.Validator.formValidate($form)
  }

  /**
   * baseURL 반환
   * @return {string} baseURL
   */
  get baseURL () {
    return this.config.getters['router/origin']
  }

  /**
   * locale 정보를 반환
   * @return {string} locale
   */
  get locale () {
    return this.config.getters['lang/current'].code
  }

  /**
   * locale 지정
   * @param {string} 변경할 locale
   */
  set locale (locale) {
    this.config.dispatch('lang/changeLocale', locale)
    this.options.locale = locale
  }

  /**
   * @DEPRECATED
   */
  getLocale () {
    return this.locale
  }

  /**
   * default locale 정보를 반환한다.
   * @return {string} defaultLocale
   */
  get defaultLocale () {
    return this.config.getters['lang/default'].code
  }

  /**
   * @DEPRECATED
   */
  getDefaultLocale () {
    return this.defaultLocale
  }
}

export default new XE()
