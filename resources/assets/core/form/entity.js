import $ from 'jquery'
import * as $$ from 'xe/utils'

/**
* @class
*/
class formEntity {
  /**
  * @param {DOM|jQuery} element
  */
  constructor (element) {
    $$.eventify(this)

    this.preventedSubmit = false

    if (element.tagName !== 'FORM') {
      element = $(element).closest('form')[0]
    }

    this.element = element
    this.$element = $(element)

    this.init()
  }

  /**
   * @private
   */
  init () {
    const that = this

    const emitFormSubmit = $$.debounce(function emitFormSubmit (element, event) {
      return that.$$emit('submit', element, event, that.preventSubmit.bind(that))
    }, 750, { leading: true, trailing: false })

    this.$element.on('submit', function (event) {
      event.preventDefault()

      emitFormSubmit(that.element, event)
        .then(() => {
          if (that.preventedSubmit === false && !that.$element.is('[data-submit="xe-ajax"]')) {
            that.submit()
          }
        })
        .catch(() => {
          event.preventDefault()
        })
    })
  }

  submit () {
    this.element.submit()
  }

  preventSubmit () {
    this.preventedSubmit = true
  }
}

export default formEntity
