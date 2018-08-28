import $ from 'jquery'
import * as $$ from 'xe/utils'

const formElements = new WeakMap()

export function getForm (element) {
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

    // @TODO debounce
    this.$element.on('submit', function (jqueryEvent) {
      that.$$emit('submit', element, jqueryEvent)
    })
  }
}
