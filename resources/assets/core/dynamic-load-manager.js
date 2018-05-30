import Singleton from 'xe/singleton'
import XE from 'xe'
import * as $$ from 'xe/utils'
import $ from 'jquery'

const assets = {
  css: new Set(),
  js: new Set()
}

export default class DynamicLoadManager extends Singleton {
  constructor () {
    super()

    $$.eventify(this)
  }

  boot (XE) {
    XE.$on('setup', (eventName, options) => {
    })

    assets.js.add(XE.baseURL + '/assets/vendor.js')
    assets.js.add(XE.baseURL + '/assets/common.js')
    assets.js.add(XE.baseURL + '/assets/core/common/js/xe.bundle.js')
  }

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
  */
  jsLoadMultiple (arrjs, callbackObj) {
    var count = 0
    callbackObj = callbackObj || {}

    for (var i = 0, max = arrjs.length; i < max; i += 1) {
      var src = $$.asset(arrjs[i])

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
  }

  /**
  * js 파일을 동적으로 로드합니다.
  * @memberof DynamicLoadManager
  * @param {string} url
  * @param {function} load
  * @param {function} error
  */
  jsLoad (url, load, error) {
    var src = $$.asset(url)

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
  }

  /**
  * css 파일을 동적으로 로드합니다.
  * @memberof DynamicLoadManager
  * @param {string} url
  * @param {function} load
  * @param {function} error
  */
  cssLoad (url, load, error) {
    const src = $$.asset(url)

    if (!assets.css.has(src) && !$('link[href*="' + src + '"]').length) {
      const $css = $('<link>', { rel: 'stylesheet', type: 'text/css', href: src })

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
}
