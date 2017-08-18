import griper from 'griper';
import Progress from './xe.progress';
import Lang from './xe.lang';
import Component from './xe.component';
import Request from './xe.request';
import window from 'window';
import validator from 'validator';

/**
 * @global
 * @namespace XE
 * @type {object}
 * */
var XE = {
  ajax: ajax,
  setup: setup,
  configure: configure,
  cssLoad: cssLoad,
  jsLoad: jsLoad,
  toast: toast,
  toastByStatus: toastByStatus,
  formError: formError,
  formErrorClear: formErrorClear,
  formValidate: formValidate,
  getLocale: getLocale,
  getDefaultLocale: getDefaultLocale,

  validator: validator,
  options: {},

  /**
   * @memberof XE
   * @borrows Lang as Lang
   * */
  Lang: Lang,
  /**
   * @memberof XE
   * @borrows Progress as Progress
   * */
  Progress: Progress,
  /**
   * @memberof XE
   * @borrows Request as Request
   * */
  Request: Request,
  /**
   * @memberof XE
   * @borrows Component as Component
   * */
  Component: Component,
};

/**
 * Ajax를 요청한다.
 * @memberof XE
 * @param {string|object} url request url
 * @param {object} options jQuery ajax options
 * */
function ajax(url, options) {
  if (typeof url === 'object') {
    options = $.extend({}, XE.Request.options, url);
    url = undefined;
  } else {
    options = $.extend({}, options, XE.Request.options, { url: url });
    url = undefined;
  }

  return $.ajax(url, options);
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
 * */
function setup(options) {
  XE.options.loginUserId = options.loginUserId;
  XE.Request.setup({
    headers: {
      'X-CSRF-TOKEN': options['X-CSRF-TOKEN'],
    },
    useXeSpinner: (options.useXeSpinner) ? true : false,
  });

}

/**
 * XE locale 정보 및 prefix 설정을 옵션 정보에 세팅한다.
 * @memberof XE
 * @param {object} options
 * <pre>
 *  - locale
 *  - defaultLocale
 *  - managePrefix
 * </pre>
 * */
function configure(options) {
  $.extend(XE.options, options);
}

/**
 * css 파일을 로드한다.
 * @memberof XE
 * @param {url} url css file path
 * */
function cssLoad(url) {
  DynamicLoadManager.cssLoad(url);
}

/**
 * js 파일을 로드한다.
 * @memberof XE
 * @param {string} url js file path
 * */
function jsLoad(url) {
  DynamicLoadManager.jsLoad(url);
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
 * */
function toast(type, message, pos) {
  if (type == '') {
    type = 'danger';
  }

  griper.toast(type, message, pos);
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
 * */
function toastByStatus(status, message) {
  return griper.toast(griper.toast.fn.statusToType(status), message);
}

/**
 * 폼 요소 엘리먼트에 메시지를 출력한다.
 * @memberof XE
 * @param {object} form element object
 * @param {string} message 엘리먼트에 출력될 메시지
 * */
function formError($element, message) {
  return griper.form($element, message);
}

/**
 * 폼 요소의 메시지를 모두 제거한다.
 * @memberof XE
 * @param {object} jquery form object
 * */
function formErrorClear($form) {
  return griper.form.fn.clear($form);
}

/**
 * 설정된 폼의 유효성 체크를 한다.
 * @memberof XE
 * @param {object} jquery form object
 * */
function formValidate($form) {
  validator.formValidate($form);
}

/**
 * locale 정보를 반환한다.
 * @memberof XE
 * @return {string} locale
 * */
function getLocale() {
  return XE.options.locale;
}

/**
 * default locale 정보를 반환한다.
 * @memberof XE
 * @return {string} defaultLocale
 * */
function getDefaultLocale() {
  return XE.options.defaultLocale;
}

window.XE = XE;
