import { BaseError } from 'make-error'

/**
 * XeError
 * @module XeError
 * @extends BaseError
 * @see {@link https://www.npmjs.com/package/make-error|npm make-error(BaseError)}
 */
class XeError extends BaseError {
  constructor (message) {
    super(message)
  }
}

export default XeError
