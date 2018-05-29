import { eventify, default as Utils } from 'xe-common/utils' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import $ from 'jquery'
import XE from 'xe-common/xe'

const assets = {
  css: new Set(),
  js: new Set()
}

/**
 * @namespace DynamicLoadManager
 * */
var DynamicLoadManager = (function (exports) {
  'use strict'

  return {
    init: function () {
      eventify(this)

      return this
    },
    boot: function () {
      assets.js.add(XE.baseURL + '/assets/vendor.js')
      assets.js.add(XE.baseURL + '/assets/common.js')
      assets.js.add(XE.baseURL + '/assets/core/common/js/xe.bundle.js')
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

        if (!assets.js.has(src)) {
          assets.js.add(src)

          XE.ajax({
            url: src,
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

      if (!assets.js.has(src) && !$('script[src*="' + src + '"]').length) {
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

        assets.js.add(src)
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

      if (!assets.css.has(src) && !$('link[href*="' + src + '"]').length) {
        var $css = $('<link>', { rel: 'stylesheet', type: 'text/css', href: src })

        if (load) {
          $css.on('load', load)
        }

        if (error) {
          $css.on('error', error)
        }

        $('head').append($css)

        assets.css.add(src)
      } else {
        if (load) {
          load()
        }
      }
    }
  }.init()
})(window)

export default DynamicLoadManager
