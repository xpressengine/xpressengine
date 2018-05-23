import Utils from 'xe-common/utils' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import $ from 'jquery'
import XE from 'xe-common/xe'

/**
 * @namespace DynamicLoadManager
 * */
var DynamicLoadManager = (function (exports) {
  'use strict'

  var _assets = {
    js: {}, css: {}
  }

  _assets.js[window.xeBaseURL + '/assets/vendor.js'] = ''
  _assets.js[window.xeBaseURL + '/assets/common.js'] = ''
  _assets.js[window.xeBaseURL + '/assets/core/common/js/xe.bundle.js'] = ''

  return {
    init: function () {
      return this
    },
    /**
     * 여러개의 js 파일을 동적으로 로드합니다.
     * @memberof DynamicLoadManager
     * @param {array} arrjs
     * @param {object}} callbackObj
     * <pre>
     *     - load
     *     - error
     *     - complete
     * </pre>
     * */
    jsLoadMultiple: function (arrjs, callbackObj) {
      var count = 0
      callbackObj = callbackObj || {}

      for (var i = 0, max = arrjs.length; i < max; i += 1) {
        var src = Utils.asset(arrjs[i])

        if (!_assets.js.hasOwnProperty(src)) {
          _assets.js[src] = ''

          XE.ajax({
            url: src,
            async: false,
            dataType: 'script',
            success: function () {
              count++

              if (callbackObj.load) {
                callbackObj.load()
              }

              if (count === arrjs.length && !!callbackObj.complete) {
                callbackObj.complete()
              }
            },

            error: callbackObj.error
          })
        } else {
          count++
          if (callbackObj.load) {
            callbackObj.load()
          }

          if (count === arrjs.length && !!callbackObj.complete) {
            callbackObj.complete()
          }
        }
      }
    },

    /**
     * js 파일을 동적으로 로드합니다.
     * @memberof DynamicLoadManager
     * @param {string} url
     * @param {function} load
     * @param {function} error
     * */
    jsLoad: function (url, load, error) {
      var src = Utils.asset(url)

      if (!_assets.js.hasOwnProperty(src) && !$('script[src*="' + src + '"]').length) {
        var el = document.createElement('script')

        el.src = src
        el.async = true

        if (load) {
          el.onload = load
        }

        if (error) {
          el.onerror = error
        }

        document.head.appendChild(el)

        _assets.js[src] = ''
      } else {
        if (load) {
          load()
        }
      }
    },

    /**
     * css 파일을 동적으로 로드합니다.
     * @memberof DynamicLoadManager
     * @param {string} url
     * @param {function} load
     * @param {function} error
     * */
    cssLoad: function (url, load, error) {
      var src = Utils.asset(url)

      if (!_assets.css.hasOwnProperty(src) && !$('link[href*="' + src + '"]').length) {
        var $css = $('<link>', { rel: 'stylesheet', type: 'text/css', href: src })

        if (load) {
          $css.on('load', load)
        }

        if (error) {
          $css.on('error', error)
        }

        $('head').append($css)

        _assets.css[src] = ''
      } else {
        if (load) {
          load()
        }
      }
    }
  }.init()
})(window)

export default DynamicLoadManager
