import Plugin from 'xe/plugin'
import $ from 'jquery'

const defaultOptions = {
  selectors: {
    elGroup: '.xu-form-group, .form-group',
    elMessage: '.xu-form-group__validation'
  },
  classes: {
    message: ['xu-form-group__validation']
  },
  tags: {
    message: 'p'
  }
}

function scrollToElement ($element) {
  if ($element instanceof $) {
    $('body').animate({
      scrollTop: $element.offset().top - (window.innerHeight / 3)
    }, 800)
  }
}

export default class Form extends Plugin {
  constructor () {
    super()

    this.options = Object.assign({}, defaultOptions)
  }

  get name () {
    return 'Form'
  }

  boot (XE, App) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE, App)

      const that = this

      this.$$app.form = this.form.bind(this)
      // @deprecated
      this.$$app.form.fn = this.$$app.form.prototype = (function () {
        return {
          message: that.message,
          constructor: that.$$app.form,
          options: that.options,
          getGroup: that.getGroup,
          putByElement: that.putByElement,
          put: that.put,
          clear: that.clear
        }
      }())
    })
  }

  /**
   * 메시지 출력
   */
  message ($element, message, type = 'error', replace = true) {
    this.putByElement($element, message, type, replace)
    scrollToElement($element)
  }

  /**
   * 메시지 삭제
   */
  // clear () {

  // }

  form ($element, message, type = 'error', replace = true) {
    this.putByElement($element, message, type, replace)
    scrollToElement($element)
  }

  /**
   * @private
   */
  putByElement ($element, message, type, replace) {
    let $elMessage = $element.closest(this.getGroup($element)).find(this.options.selectors.elMessage)

    if (!replace || !$elMessage.length) {
      $elMessage = this.put(this.getGroup($element), message, $element)
    }

    $elMessage
      .attr('class', this.options.classes.message.join(' '))
      .text(message)

    if (type) {
      $elMessage.addClass('xu-text--' + type)
    }
  }

  put ($group, message, $element) {
    var $elMessage = $('<' + this.options.tags.message + '>')
      .addClass(this.options.classes.message.join(' '))
      .text(message)

    if ($group.length) {
      $group.append($elMessage)
    } else {
      $element.after($elMessage)
    }

    return $elMessage
  }

  /**
   * 옵션 지정
   * @param {object} options
   */
  setOption (options = {}) {
    Object.assign(this.optinos, options || {})
  }

  /**
   * @private
   * @param {jQuery} $element
   */
  getGroup ($element) {
    return $element.closest(this.options.selectors.elGroup)
  }

  clear ($form) {
    $form.find(this.options.selectors.elMessage).remove()
    $form.find('.xe-form-group--invalid').removeClass('xe-form-group--invalid')
    $form.find('.xe-form-control--invalid').removeClass('xe-form-control--invalid')
  }
}
