import XeError from 'xe/error'

/**
 * ValidationError
 * @module XeError/ValidationError
 * @extends XeError
 * @property {string} name
 */
class ValidationError extends XeError {
  constructor (message, request, responseData = null, responseHeaders = null) {
    super(message)

    this.name = this.constructor.name
  }
}

export {
  ValidationError
}
