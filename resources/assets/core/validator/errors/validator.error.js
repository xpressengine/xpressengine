import XeError from 'xe/error'

/**
 * ValidationError
 * @module XeError/ValidationError
 * @extends XeError
 * @property {string} name
 */
class ValidationError extends XeError {
  constructor (message, field = null) {
    super(message)

    this.name = this.constructor.name
    this.field = field
  }
}

export {
  ValidationError
}
