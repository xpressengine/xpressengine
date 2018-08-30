import $ from 'jquery'
import * as $$ from 'xe/utils'

const formElements = new WeakMap()

export function getForm (element) {
  // jQuery instance
  if (element instanceof $) {
    element = element[0]
  }

  if (typeof element.name === 'string' && element.name !== 'form') {
    element = $(element).closest('form')[0]
  }

  if (!formElements.has(element)) {
    formElements.set(element, new Form(element))
  }

  return formElements.get(element)
}

export default class Form {
  constructor (element) {
    $$.eventify(this)

    const that = this

    if (typeof element.name === 'string' && element.name !== 'form') {
      element = $(element).closest('form')[0]
    }

    this.$element = $(element)
    formElements.set(element, this)

    const emitFormSubmit = $$.debounce(function emitFormSubmit (element, event) {
      return that.$$emit('submit', element, event)
    }, 750, { leading: true, trailing: false })

    this.$element.on('submit', function (event) {
      event.preventDefault()

      emitFormSubmit(element, event)
        .then(() => {
          if (event.isDefaultPrevented()) {
            this.submit()
          }
        })
        .catch(() => {
        })
    })
  }
}
