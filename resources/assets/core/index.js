const booted = Symbol('booted')

// external libraries
import $ from 'jquery'
import blankshield from 'blankshield'
import moment from 'moment'
import URI from 'urijs'
import config from 'xe/config'

// internal libraries
import * as $$ from 'xe/utils'
import Component from 'xe/component'
import DynamicLoadManager from 'xe/dynamic-load-manager'
import griper from 'xe/common/js/griper'
import Lang from 'xe/lang'
import Progress from 'xe/common/js/progress'
import Request from 'xe/request'
import Router from 'xe/router'
import Translator from 'xe/common/js/translator'
import Validator from 'xe/validator'
import { STORE_URL, CHANGE_ORIGIN } from './router/store'
import { STORE_LOCALE, CHANGE_LOCALE } from './lang/store'

const symbolApp = Symbol('App')

const defaultConfig = {
  baseURL: window.location.origin,
  fixedPrefix: 'plugin',
  settingsPrefix: 'settings',
  translation: {
    locales: [
      { code: 'ko', nativeName: '한국어' },
      { code: 'en', nativeName: 'English' }
    ]
  }
}

/**
 * @class XE
 * @global
 * @namespace XE
 * @type {object}
 */
class XE {
  constructor () {
    $$.eventify(this)
    this[booted] = false
    // @deprecated
    this.options = defaultConfig
    /**
     * veux store
     */
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
      }
    })

    this[symbolApp] = new Map()

    // internal libraries
    this.Utils = $$
    this.Progress = this.registerApp('Progress', Progress)
    this.Router = this.registerApp('Router', new Router())
    this.Request = this.registerApp('Request', new Request())
    this.Lang = this.registerApp('Lang', new Lang())
    this.DynamicLoadManager = this.registerApp('DynamicLoadManager', new DynamicLoadManager())
    this.Validator = this.registerApp('Validator', new Validator())
    this.Component = this.registerApp('Component', new Component())

    // external libraries
    this.moment = moment // @DEPRECATED
    this.Translator = Translator // @DEPRECATED
  }

  /**
   *
   * @param {*} name App Name
   * @param {*} callback pass instance
   * @return {Promise}
   */
  getApp (name, callback) {
    const app = this[symbolApp].get(name)

    if (typeof callback === 'function') {
      callback(app)
    }

    return app.boot(this) // return promise
  }

  registerApp (name, appInstance) {
    if (!this[symbolApp].has(name)) {
      this[symbolApp].set(name, appInstance)
    }

    return appInstance
  }

  intercept (appName, pointcut) {
    const app = this.getApp(appName)
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

      Object.entries(exposed.rules).forEach((rule) => {
        if (rule[1]) {
          this.Validator.setRules(rule[0], rule[1])
        }
      })
    })

    $(() => {
      $('body').on('click', 'a[target]', (e) => {
        const $this = $(e.target)
        const href = String($this.attr('href')).trim()
        const target = String($this.attr('target'))

        if (!href) return
        if (target === '_top' || target === '_self' || target === '_parent') return
        if (!href.match(/^(https?:\/\/)/)) return
        if (this.isSameHost(href)) return

        let rel = $this.attr('rel')

        if (typeof rel === 'string') {
          $this.attr('rel', rel + ' noopener')
        } else {
          $this.attr('rel', 'noopener')
        }

        blankshield.open(href)
        e.preventDefault()
      })
    })

    return Promise.all([
      this.Router.boot(this),
      this.Request.boot(this),
      this.Lang.boot(this),
      this.DynamicLoadManager.boot(this),
      this.Validator.boot(this),
      this.Component.boot(this)
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
        })
        this.Request.$$on('sucess', (eventName, options) => {
          Progress.done((typeof options.container === 'undefined') ? 'body' : options.container)
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
          }

          this.toastByStatus(error.status, errorMessage)
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

    Object.assign(this.options, config)

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
    if (config.loginUserId) {
      this.config.dispatch('user/login', { id: config.loginUserId })
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
      options = $.extend({}, this.Request.config, {headers: {'X-CSRF-TOKEN': this.Request.config.userToken}}, url)
      url = undefined
    } else {
      options = $.extend({}, options, this.Request.config, {headers: {'X-CSRF-TOKEN': this.Request.config.userToken}}, { url: url })
      url = undefined
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
    griper.toast(type, message, pos)
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
    return griper.toast(griper.toast.fn.statusToType(status), message)
  }

  /**
   * 폼 요소 엘리먼트에 메시지를 출력한다.
   * @param {object} form element object
   * @param {string} message 엘리먼트에 출력될 메시지
   */
  formError ($element, message) {
    return griper.form($element, message)
  }

  /**
   * 폼 요소의 메시지를 모두 제거한다.
   * @param {object} jquery form object
   */
  formErrorClear ($form) {
    return griper.form.fn.clear($form)
  }

  /**
   * 설정된 폼의 유효성 체크를 한다.
   * @param {object} jquery form object
   */
  formValidate ($form) {
    Validator.formValidate($form)
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

window.XE = new XE()

export default window.XE
