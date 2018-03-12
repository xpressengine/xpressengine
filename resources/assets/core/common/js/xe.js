import griper from 'xe-common/griper'
import Progress from 'xe-common/progress'
import Lang from 'xe-common/lang'
import Component from 'xe-common/component'
import Request from 'xe-common/request'
import Validator from 'xe-common/validator'
import * as Utils from 'xe-common/utils'
import DynamicLoadManager from 'xe-common/dynamicLoadManager'
import Translator from 'xe-common/translator'
import $ from 'jquery'
import blankshield from 'blankshield'
import URI from 'urijs'

/**
 * @global
 * @namespace XE
 * @type {object}
 **/
class XE {
  constructor () {
    let that = this
    this.options = {}
    this.validator = Validator
    this.Lang = Lang
    this.Progress = Progress
    this.Request = Request
    this.Component = Component
    this.util = Utils

    window.Utils = Utils
    window.DynamicLoadManager = DynamicLoadManager
    window.Translator = Translator
    window.blankshield = blankshield

    $(function () {
      $('body').on('click', 'a[target]', function (e) {
        var $this = $(this)
        var href = $this.attr('href').trim()

        if (!href) return
        if (!href.match(/^(https?:\/\/)/)) return

        if (!that.isSameHost(href)) {
          var rel = $this.attr('rel')

          if (typeof rel === 'string') {
            $this.attr('rel', rel + ' noopener')
          } else {
            $this.attr('rel', 'noopener')
          }

          blankshield.open(href)
          e.preventDefault()
        }
      })
    })
  }

  /**
   * XE 기본설정을 세팅한다.
   * @memberof XE
   * @param {object} options
   * <pre>
   *   - loginUserId
   *   - X-CSRF-TOKEN : CSRF Token 값 세팅
   *   - useXESpinner : ajax요청시 UI상에 spinner 사용여부
   * </pre>
   **/
  setup (options) {
    this.options.loginUserId = options.loginUserId
    this.Request.setup({
      headers: {
        'X-CSRF-TOKEN': options['X-CSRF-TOKEN']
      },
      useXeSpinner: options.useXeSpinner
    })
  }

  configure (options) {
    $.extend(this.options, options)
  }

  /**
   * css 파일을 로드한다.
   * @memberof XE
   * @param {url} url css file path
   * @DEPRECATED
   **/
  cssLoad (url) {
    DynamicLoadManager.cssLoad(url)
  }

  /**
   * js 파일을 로드한다.
   * @memberof XE
   * @param {string} url js file path
   * @DEPRECATED
   **/
  jsLoad (url) {
    DynamicLoadManager.jsLoad(url)
  }

  /**
   * Ajax를 요청한다.
   * @memberof XE
   * @param {string|object} url request url
   * @param {object} options jQuery ajax options
   **/
  ajax (url, options) {
    if (typeof url === 'object') {
      options = $.extend({}, this.Request.options, url)
      url = undefined
    } else {
      options = $.extend({}, options, this.Request.options, { url: url })
      url = undefined
    }

    return $.ajax(url, options)
  }

  isSameHost (url) {
    if (typeof url !== 'string') return false

    let baseUrl
    let targetUrl = URI(url).normalizePathname()
    let _xeBaseURL = URI(window.xeBaseURL).normalizePathname()

    if (targetUrl.is('urn')) return false

    let port = _xeBaseURL.port() || (_xeBaseURL.protocol() === 'http') ? 80 : 443

    if (!targetUrl.hostname()) {
      targetUrl = targetUrl.absoluteTo(window.xeBaseURL)
    }

    let targetPort = targetUrl.port()
    if (!targetPort) {
      targetPort = (targetUrl.protocol() === 'http') ? 80 : 443
    }

    if ($.inArray(Number(targetPort), port) === -1) {
      return false
    }

    if (!baseUrl) {
      baseUrl = URI(window.xeBaseURL).normalizePathname()
      baseUrl = baseUrl.hostname() + baseUrl.directory()
    }
    targetUrl = targetUrl.hostname() + targetUrl.directory()

    return targetUrl.indexOf(baseUrl) === 0
  }

  /**
   * type에 따른 토스트 팝업을 출력한다.
   * @memberof XE
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
   **/
  toast (type = 'danger', message, pos) {
    griper.toast(type, message, pos)
  }

  /**
   * status에 따른 토스트 팝업을 출력한다.
   * @memberof XE
   * @param {number}
   * <pre>
   *   - 500 : danger
   *   - 401 : warning
   * </pre>
   * @param {string} 팝업에 출력될 메시지
   **/
  toastByStatus (status, message) {
    return griper.toast(griper.toast.fn.statusToType(status), message)
  }

  /**
   * 폼 요소 엘리먼트에 메시지를 출력한다.
   * @memberof XE
   * @param {object} form element object
   * @param {string} message 엘리먼트에 출력될 메시지
   **/
  formError ($element, message) {
    return griper.form($element, message)
  }

  /**
   * 폼 요소의 메시지를 모두 제거한다.
   * @memberof XE
   * @param {object} jquery form object
   **/
  formErrorClear ($form) {
    return griper.form.fn.clear($form)
  }

  /**
   * 설정된 폼의 유효성 체크를 한다.
   * @memberof XE
   * @param {object} jquery form object
   **/
  formValidate ($form) {
    Validator.formValidate($form)
  }

  /**
   * locale 정보를 반환한다.
   * @memberof XE
   * @return {string} locale
   **/
  getLocale () {
    return this.options.locale
  }

  /**
   * default locale 정보를 반환한다.
   * @memberof XE
   * @return {string} defaultLocale
   **/
  getDefaultLocale () {
    return this.options.defaultLocale
  }
}

window.XE = new XE()

export default window.XE
