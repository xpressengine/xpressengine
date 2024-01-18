(function (XE, $) {
  if (!XE) return

  var _this = this

  var _pageCommon = (function () {
    return {
      init: function () {
        _this = this
        _this.bindEvent()

        return this
      },

      bindEvent: function () {
        $(document).on('click', '[data-toggle=xe-page]', _this.execPage)
        $(document).on('click', '[data-toggle=xe-page-modal]', _this.execPageModal)
        $(document).on('click', '[data-toggle=xe-page-toggle-menu]', _this.execPageToggleMenu)
        $(document).on('click', _this.execPageCheck)
      },

      execPage: function (e) {
        e.preventDefault()

        var $this = $(this)
        var targetSelector = $this.data('target')
        var data = $this.data('params')
        var callback = $this.data('callback')
        var url = $this.data('url')

        data = data ? (typeof data === 'object') ? data : JSON.parse(data) : {}

        var objStack = callback ? callback.split('.') : []
        var callbackFunc = (objStack.length > 0) ? window : ''

        var options = {
          data: data
        }

        if (!url &&
          $this.get(0).tagName === 'A' &&
          $this.attr('href')) {
          url = $this.attr('href')
        }

        if (!url) {
          url = $this.attr('href')
        }

        if (objStack.length > 0) {
          for (var i = 0, max = objStack.length; i < max; i += 1) {
            callbackFunc = callbackFunc[objStack[i]]
          }
        }

        XE.page(url, targetSelector, options, callbackFunc)
      },

      execPageModal: function (e) {
        e.preventDefault()

        var $this = $(this)
        var data = $this.data('data')
        var callback = $this.data('callback')
        var url = $this.data('url')

        data = data ? (typeof data === 'object') ? data : JSON.parse(data) : {}

        var objStack = callback ? callback.split('.') : []
        var callbackFunc = (objStack.length > 0) ? window : ''

        var options = {
          data: data
        }

        if (!url &&
          $this.get(0).tagName === 'A' &&
          $this.attr('href')) {
          url = $this.attr('href')
        }

        if (objStack.length > 0) {
          for (var i = 0, max = objStack.length; i < max; i += 1) {
            callbackFunc = callbackFunc[objStack[i]]
          }
        }

        XE.pageModal(url, options, callbackFunc)
      },

      execPageToggleMenu: function (e) {
        e.preventDefault()

        var $this = $(this)
        var data = $this.data('data')
        var side = $this.data('side')
        var callback = $this.data('callback')
        var url = $this.data('url')

        data = data ? (typeof data === 'object') ? data : JSON.parse(data) : {}

        var objStack = callback ? callback.split('.') : []
        var callbackFunc = (objStack.length > 0) ? window : ''

        var options = {
          data: data,
          side: side
        }

        if (!url &&
          $this.get(0).tagName === 'A' &&
          $this.attr('href')) {
          url = $this.attr('href')
        }

        if (objStack.length > 0) {
          for (var i = 0, max = objStack.length; i < max; i += 1) {
            callbackFunc = callbackFunc[objStack[i]]
          }
        }

        XE.pageToggleMenu(url, $this, options, callbackFunc)
      },

      loadDone: function (cssLen, jsLen, next) {
        var loadingCount = 0

        return function (e) {
          loadingCount++

          if ((cssLen + jsLen) === loadingCount && !!next) {
            next()
          }
        }
      },

      getModalTemplate: function () {
        return [
          '<div class="xe-modal fade" data-use="xe-page">',
          '<div class="xe-modal-dialog ">',
          '<div class="xe-modal-content"></div>',
          '</div>',
          '</div>'
        ].join('\n')
      },

      getLayerPopupTemplate: function () {
        return [
          '<ul class="xe-dropdown-menu xe-toggle-menu"></ul>'
        ].join('\n')
      },

      execPageCheck: function (e) {
        var $target = $(e.target)

        // close ToggleMenu
        if ($target.closest('.xe-dropdown').length == 0) {
          $('[data-toggle=xe-page-toggle-menu]').parent('.xe-dropdown').removeClass('open')
        }
      }
    }.init()
  })()

  /**
   * @private
   * @description validtion
   */
  var _validation = (function () {
    return {
      isValidPage: function (options) {
        var isValid = true

        if (!options.hasOwnProperty('url') || options.url === '') {
          console.error('page: 필수 option [url]')
        }

        return isValid
      },

      isValidPageModal: function (options) {
        var isValid = true

        if (!options.hasOwnProperty('url') || options.url === '') {
          console.error('pageModal: 필수 option [url]')
        }

        return isValid
      },

      isValidPageToggleMenu: function (options) {
        var isValid = true

        if (!options.hasOwnProperty('url') || options.url === '') {
          console.error('pageToggleMenu: Require option [url]')
        }

        return isValid
      }
    }
  })()

  /**
   * @private
   * @param {object} options
   * <pre>
   *     - target   : {string} css selector
   *     - url        : {stirng} html file path
   *     - type       : {string} method
   * </pre>
   * @param {function} callback
   */
  var _page = function (options, callback) {
    var $target = options.target
    var addType = options.hasOwnProperty('addType') ? options.addType : ''

    if (typeof $target === 'string') {
      $target = $($target)
    }

    var defaultOptions = {
      url: options.url,
      type: options.type || 'get',
      dataType: 'json',
      data: options.data || {},
      headers: {
        'X-CSRF-TOKEN': XE.config.getters['request/xsrfToken'],
        'X-XE-Async-Expose': true
      }
    }

    var pageOptions = $.extend(defaultOptions, {
      success: function (data) {
        var exposed = XE._.get(data, '_XE_', { })
        var css = XE._.get(exposed, 'assets.css', [])
        var js = XE._.get(exposed, 'assets.js', [])
        var html = data.result || ''
        var cssLen = css.length
        var jsLen = js.length

        var next = function () {
          switch (addType) {
            case 'append':
              $target.append(html)
              break

            case 'prepend':
              $target.prepend(html)
              break

            case 'after':
              $target.after(html)
              break

            case 'before':
              $target.before(html)
              break

            default:
              $target.html(html)
          }

          $('form', $target).each(function (idx, form) {
            /* eslint no-new:off */
            XE.Form.get(form)
          })

          if (callback) {
            callback(data)
          }
        }

        var loadDone = _pageCommon.loadDone(cssLen, jsLen, next)

        if (cssLen > 0) {
          for (var i = 0, max = cssLen; i < max; i += 1) {
            XE.DynamicLoadManager.cssLoad(css[i], loadDone, loadDone)
          }
        }

        if (jsLen > 0) {
          XE.DynamicLoadManager.jsLoadMultiple(js, {
            load: loadDone,
            error: loadDone
          })
        }

        if (exposed.translations) {
          XE.Lang.set(exposed.translations)
        }

        if (exposed.routes) {
          XE.Router.addRoutes(exposed.routes)
        }

        Object.entries(exposed.rules || {}).forEach(function (rule) {
          if (rule[1]) {
            XE.Validator.setRules(rule[0], rule[1])
          }
        })

        if ((cssLen + jsLen) === 0) {
          next()
        }
      }
    })
    return XE.ajax(pageOptions)
  }

  /**
   * selecor영역에 html을 로드하여 보여준다. html 랜더링 전에 assets파일들의 로드가 선행된다.
   * @memberof XE.prototype
   * @param {string} url
   * @param {string} target selector
   * @param {object} options
   * <pre>
   *     - data : request parameters
   *     - type : http method (get | post) default 'get'
   *     - addType : 'append' | 'prepend' default 'jquery fn.html'
   * </pre>
   * @param {function} callback
   * @description
   * <pre>
   *     동작 순서
   *     1)css로드 + js로드
   *     2)html string append
   *     3)callback 실행
   * </pre>
   */
  function page (url, target, options, callback) {
    var defaultOptions = {
      type: 'get'
    }

    // @FIXME redeclare
    var options = $.extend(defaultOptions, options || {}, {
      url: url,
      target: target
    })

    if (_validation.isValidPage(options)) {
      return _page(options, callback)
    }
  }
  XE.page = page

  /**
   * modal을 실행하여 .xe-modal-content 영역에 html을 로드하여 보여준다. html 랜더링 전에 assets파일들의 로드가 선행된다.
   * @memberof XE
   * @param {string} url
   * @param {object} options
   * <pre>
   *     - data : request parameters
   *     - type : http method (get | post) default 'get'
   * </pre>
   * @param {function} callback
   * @description
   * <pre>
   *     동작 순서
   *     1)css로드 + js로드
   *     2)html string append
   *     3)callback 실행
   *     4)modal show
   * </pre>
   */
  function pageModal (url, options, callback) {
    var defaultOptions = {
      type: 'get'
    }

    // @FIXME redeclare
    var options = $.extend(defaultOptions, options || {}, {
      target: '.xe-modal[data-use=xe-page] .xe-modal-content',
      url: url
    })

    if (_validation.isValidPageModal(options)) {
      var $modal = $('.xe-modal[data-use=xe-page]')

      if ($modal.length > 0) {
        $modal.find('.xe-modal-content').empty()
      } else {
        var modalTemplate = _pageCommon.getModalTemplate()

        $('body').append(modalTemplate)
      }

      _page(options, function () {
        if (callback) {
          callback()
        }

        $('.xe-modal[data-use=xe-page]').xeModal()
      })
    }
  }
  XE.pageModal = pageModal

  /**
   * 실행하여 .xe-toggle-menu-items 영역에 html을 로드하고 .xe-toggle-popup 을 보여준다. html 랜더링 전에 assets파일들의 로드가 선행된다.
   * @memberof XE
   * @param {string} url
   * @param {object} $this
   * @param {object} options
   * <pre>
   *     - data : request parameters
   *     - type : http method (get | post) default 'get'
   *     - side : dropdown-menu-right, dropdown-menu-left
   * </pre>
   * @param {function} callback
   * @description
   * <pre>
   *     동작 순서
   *     1)css로드 + js로드
   *     2)html string append
   *     3)callback 실행
   *     4)modal show
   * </pre>
   */
  function pageToggleMenu (url, $this, options, callback) {
    var $container = $this.parent()

    if ($container.hasClass('xe-dropdown') == false) {
      $container.addClass('xe-dropdown')
    }

    if ($container.hasClass('open')) {
      $container.removeClass('open')
      return
    }

    var $target = $container.find('.xe-dropdown-menu')
    if ($target.length == 0) {
      var toggleMenuTemplate = _pageCommon.getLayerPopupTemplate()
      $container.append(toggleMenuTemplate)
      $target = $container.find('.xe-dropdown-menu')
    }

    if (options.side) {
      $target.addClass(options.side)
    }

    // @FIXME redeclare
    var options = $.extend(options, {
      target: $target,
      url: url,
      type: options.type || 'get'
    })

    if (_validation.isValidPageToggleMenu(options)) {
      _page(options, function () {
        if (callback) {
          callback()
        }

        $container.addClass('open')
      })
    }
  }
  XE.pageToggleMenu = pageToggleMenu
})(window.XE, window.jQuery)
