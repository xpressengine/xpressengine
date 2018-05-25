// external libraries
import $ from 'jquery'
import blankshield from 'blankshield'
import moment from 'moment'
import URI from 'urijs'

// internal libraries
import Component from 'xe/common/js/component'
import DynamicLoadManager from 'xe/common/js/dynamicLoadManager'
import griper from 'xe/common/js/griper'
import Lang from 'xe/common/js/lang'
import Progress from 'xe/common/js/progress'
import Request from 'xe/request'
import Router from 'xe/router'
import * as Utils from 'xe/common/js/utils'
import Translator from 'xe/common/js/translator'
import Validator from 'xe/common/js/validator'

/**
 * @class XE
 * @global
 * @namespace XE
 * @type {object}
 */
class XE {
  constructor () {
    Utils.eventify(this)
    this.options = {}

    // internal libraries
    this.Utils = Utils
    this.Validator = Validator
    this.Lang = Lang
    this.Router = Router.instance
    this.Request = Request.instance
    this.Progress = Progress
    this.Component = Component
    this.DynamicLoadManager = DynamicLoadManager

    // external libraries
    this.moment = moment // @DEPRECATED
    this.Translator = Translator // @DEPRECATED
  }

  boot () {
    this.Router.boot(this)
    this.Request.boot(this)

    $(() => {
      $('body').on('click', 'a[target]', (e) => {
        console.debug(e)
        const $this = $(e.target)
        const href = $this.attr('href').trim()
        const target = $this.attr('target')

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
  setup (options) {
    this.boot()
    this.configure(options)

    this.$emit('setup', this.options)
  }

  configure (options) {
    $.extend(this.options, options)
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
    DynamicLoadManager.cssLoad(url, load, error)
  }

  /**
   * js 파일을 로드한다.
   * @param {string} url js file path
   * @DEPRECATED
   */
  jsLoad (url, load, error) {
    DynamicLoadManager.jsLoad(url)
  }

  /**
   * Ajax를 요청한다.
   * @param {string|object} url request url
   * @param {object} options jQuery ajax options
   */
  ajax (url, options) {
    if (typeof url === 'object') {
      options = $.extend({}, this.Request.config, {headers: {'X-CSRF-TOKEN':this.Request.config.userToken}}, url)
      url = undefined
    } else {
      options = $.extend({}, options, this.Request.config, {headers: {'X-CSRF-TOKEN':this.Request.config.userToken}}, { url: url })
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
console.log(this.baseURL)
    const base = {
      url: URI(this.baseURL).normalizePathname()
    }
    const target = {
      url: URI(url).normalizePathname()
    }

    if (target.url.is('urn')) return false

    if (!target.url.hostname()) {
      target.url = target.url.absoluteTo(this.baseURL)
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
    return this.options.baseURL
  }

  /**
   * locale 정보를 반환
   * @return {string} locale
   */
  get locale () {
    return this.options.locale
  }

  /**
   * locale 지정
   * @param {string} 변경할 locale
   */
  set locale (locale) {
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
    return this.options.defaultLocale
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
