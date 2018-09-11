import App from 'xe/app'
import * as $$ from 'xe/utils'
import $ from 'jquery'

const assets = {
  css: new Set(),
  js: new Set()
}

export default class DynamicLoadManager extends App {
  constructor () {
    super()

    $$.eventify(this)
  }

  boot (XE) {
    return new Promise((resolve) => {
      if (this.booted()) {
        resolve(this)
      } else {
        super.boot(XE)

        assets.js.add(this.$$config.getters['router/origin'] + '/assets/vendor.js')
        assets.js.add(this.$$config.getters['router/origin'] + '/assets/common.js')
        assets.js.add(this.$$config.getters['router/origin'] + '/assets/core/common/js/xe.bundle.js')

        resolve(this)
      }
    })
  }

  static appName () {
    return 'DynamicLoadManager'
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
    let result = Promise.resolve()

    for (let idx in arrjs) {
      let src = $$.asset(arrjs[idx])
      if (!assets.js.has(src)) {
        result = result.then(() => new Promise((resolve, reject) => {
          this.$$xe.ajax({
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

              resolve()
            },
            error: callbackObj.error
          })
        }))
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
    return new Promise((resolve, reject) => {
      const src = $$.asset(url)

      if (!assets.css.has(src) && !$('link[href*="' + src + '"]').length) {
        const $css = $('<link>', { rel: 'stylesheet', type: 'text/css', href: src })

        $css.on('load', () => {
          resolve(src)
          if (load) {
            load()
          }
        })

        $css.on('error', (err) => {
          reject(src)
          if (error) {
            error(err)
          }
        })

        $('head').append($css)

        assets.css.add(src)
      } else {
        resolve(src)
        if (load) {
          load()
        }
      }
    })
  }
}
