import Plugin from 'xe/plugin'
import $ from 'jquery'

const defaultOptions = {
  toastContainer: {
    template: '<div class="__xe_toast_container xe-toast-container"></div>',
    boxTemplate: '<div class="toast_box"></div>'
  },
  classSet: {
    danger: 'xe-danger',
    positive: 'xe-positive',
    warning: 'xe-warning',
    success: 'xe-success',
    fail: 'xe-fail',
    error: 'xe-danger',
    info: 'xe-positive'
  },
  expireTimes: {
    'xe-danger': 0,
    'xe-positive': 5,
    'xe-warning': 0,
    'xe-success': 2,
    'xe-fail': 5
  },
  status: { 500: 'xe-danger', 401: 'xe-warning' },
  template: '<div class="alert-dismissable xe-alert" style="display:none;"><button type="button" class="__xe_close xe-btn-alert-close" aria-label="Close"><i class="xi-close"></i><span class="text" style="display:none;"> 닫기</span></button>' +
'<span class="message"></span></div>'
}
let $toastBox = null
const toastBoxMap = {}

export default class Toast extends Plugin {
  constructor () {
    super()

    this.options = Object.assign({}, defaultOptions)
  }

  get name () {
    return 'Toast'
  }

  boot (XE, App) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    const that = this

    XE.$$emit('toast.boot', this, App, defaultOptions)

    return new Promise((resolve) => {
      super.boot(XE, App)

      this.$$app.toast = (type, message, options = {}) => {
        // type = options.type || 'danger'
        const position = options.position || 'bottom'
        this.toast(type, message, position)
      }
      // @deprecated
      this.$$app.toast.fn = this.$$app.toast.prototype = (function () {
        return {
          constructor: that.$$app.toast,
          options: that.options,
          statusToType: that.statusToType,
          add: that.add,
          create: that.create,
          show: that.show,
          destroy: that.destroy,
          container: that.container
        }
      }())
    })
  }

  setOption (options = {}) {
    Object.assign(this.optinos, options || {})
  }

  toast (type, message, pos) {
    let position = ''

    if (window.navigator.userAgent.toLowerCase().indexOf('mobile') !== -1) {
      if (pos && pos.indexOf('top') !== -1) {
        position = 'top'
      } else {
        position = 'bottom'
      }
    } else {
      position = pos || 'bottom'
    }

    this.add(type, message, position)
  }

  statusToType (status) {
    var type = this.options.status[status]
    return type === undefined ? 'danger' : type.split('-')[1]
  }

  add (type, message, pos) {
    if (type === 'danger' || type === 'warning' || type === 'failed') {
      pos = 'center'
    }

    this.create(type, message, pos)
    return this
  }

  create (type, message, pos) {
    let expireTime = 0
    type = this.options.classSet[type] || 'xe-danger'

    if (type === 'danger' || type === 'warning') {
      pos = 'center'
      this.container(pos).addClass('xe-toast-container--center').show()
    }

    if (this.options.expireTimes[type] !== 0) {
      expireTime = parseInt(new Date().getTime() / 1000) + this.options.expireTimes[type]
    }

    const $alert = $(this.options.template)
    $alert.attr('data-expire-time', expireTime).addClass(type).find('.message').remove()
    $alert.append(message)

    if (pos && pos.indexOf('top') !== -1) {
      this.container(pos).prepend($alert)
    } else {
      this.container(pos).append($alert).show()
    }

    if (pos !== 'center') {
      this.show($alert)
    } else {
      $('.xe-toast-container--center').show()
    }
  }

  show (alert) {
    alert.slideDown()
  }

  destroy (alert) {
    alert.slideUp(function () {
      alert.remove()
      if ($('.xe-toast-container--center').length) {
        if (!$('.xe-toast-container--center .xe-alert').length) {
          $('.xe-toast-container--center').hide()
        }
      }
    })
  }

  container (pos) {
    if (toastBoxMap.hasOwnProperty(pos)) {
      return toastBoxMap[pos]
    }

    const that = this
    const cssJSON = {}

    if (!pos) {
      pos = 'bottom'
    }

    switch (pos) {
      case 'top':
        $.extend(cssJSON, {
          top: 0,
          bottom: 'initial',
          margin: '0 auto'
        })
        break

      case 'topLeft':
        $.extend(cssJSON, {
          margin: 0,
          top: 0,
          left: 0,
          right: 'initial',
          bottom: 'initial',
          minWidth: '50%'
        })
        break

      case 'topRight':
        $.extend(cssJSON, {
          margin: 0,
          top: 0,
          right: 0,
          left: 'initial',
          bottom: 'initial',
          minWidth: '50%'
        })
        break

      case 'bottom':
        $.extend(cssJSON, {
          bottom: 0,
          left: 0,
          right: 0,
          top: 'initial',
          margin: '0 auto'
        })
        break

      case 'bottomLeft':
        $.extend(cssJSON, {
          margin: 0,
          bottom: 0,
          left: 0,
          right: 'initial',
          top: 'initial',
          minWidth: '50%'
        })
        break

      case 'bottomRight':
        $.extend(cssJSON, {
          margin: 0,
          bottom: 0,
          left: 'initial',
          right: 0,
          top: 'initial',
          minWidth: '50%'
        })
        break
    }

    $toastBox = $(this.options.toastContainer.boxTemplate)
    const container = $(this.options.toastContainer.template).append($toastBox).css(cssJSON)

    if (pos === 'center') {
      container.addClass('xe-toast-container--center').show()
    }

    toastBoxMap[pos] = $toastBox

    $('body').append(container)

    container.on('click', 'button.__xe_close', function (e) {
      that.destroy($(this).parents('.xe-alert'))
      e.preventDefault()
    })

    const timeChecker = function ($box) {
      let interval
      return function () {
        interval = setInterval(function () {
          let time = parseInt(new Date().getTime() / 1000)
          $box
            .find('div.xe-alert')
            .each(function () {
              const expireTime = parseInt($(this).data('expire-time'))
              if (expireTime !== 0 && time > expireTime) {
                that.destroy($(this))
              }
            })
        }, 1000)
      }
    }

    timeChecker($toastBox)()

    return $toastBox
  }
}
