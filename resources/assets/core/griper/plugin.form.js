import Plugin from 'xe/plugin'
import $ from 'jquery'

const defaultOptions = {
  selectors: {
    elementGroup: '.form-group',
    errorText: '.__xe_error_text'
  },
  classes: {
    message: ['error-text', '__xe_error_text']
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

  setOption (options = {}) {
    Object.assign(this.optinos, options || {})
  }

  form ($element, message) {
    this.putByElement($element, message)
    scrollToElement($element)
  }

  getGroup ($element) {
    return $element.closest(this.options.selectors.elementGroup)
  }

  putByElement ($element, message) {
    this.put(this.getGroup($element), message, $element)
  }

  put ($group, message, $element) {
    if ($group.length) {
      $group.append(
        $('<' + this.options.tags.message + '>')
          .addClass(this.options.classes.message.join(' '))
          .text(message)
      )
      $group.addClass('xe-form-group--invalid')
    } else {
      $element.after(
        $('<' + this.options.tags.message + '>')
          .addClass(this.options.classes.message.join(' '))
          .text(message)
      )
      $element.addClass('xe-form-control--invalid')
    }
  }

  clear ($form) {
    $form.find(this.options.tags.message + this.options.selectors.errorText).remove()
    $form.find('.xe-form-group--invalid').removeClass('xe-form-group--invalid')
    $form.find('.xe-form-control--invalid').removeClass('xe-form-control--invalid')
  }
}
