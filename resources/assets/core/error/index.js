export default class XeError extends Error {
  constructor (message) {
    super(message)

    this.name = 'XeError'

    if (Error.captureStackTrace) {
      Error.captureStackTrace(this, this.constructor)
    }
  }
}
