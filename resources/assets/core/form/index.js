import $ from 'jquery'
import App from 'xe/app'
import FormEntity from 'xe/form/entity'

const formElements = new WeakMap()

/**
 * @class
 */
class Form extends App {
  constructor (element) {
    super()
  }

  static appName () {
    return 'Form'
  }

  boot (XE) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE)

      resolve(this)
    })
  }

  /**
   * @param {DOM|jQuery} element
   */
  get (element) {
    // jQuery instance
    if (element instanceof $) {
      if (!element.length) return null
      element = element[0]
    }

    if (element.tagName !== 'FORM') {
      element = $(element).closest('form')[0]
    }

    if (!formElements.has(element)) {
      formElements.set(element, new FormEntity(element))
    }

    return formElements.get(element)
  }
}

export default Form

/**
 * @deprecated
 * @param {DOM|jQuery} element
 */
export function getForm (element) {
  // jQuery instance
  if (element instanceof $) {
    if (!element.length) return null
    element = element[0]
  }

  if (element.tagName !== 'FORM') {
    element = $(element).closest('form')[0]
  }

  if (!formElements.has(element)) {
    formElements.set(element, new FormEntity(element))
  }

  return formElements.get(element)
}
