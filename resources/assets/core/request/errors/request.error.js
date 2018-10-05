import XeError from 'xe/error'
/**
 * @module XeError/RequestError
 * @extends XeError
 */
class RequestError extends XeError {
  constructor (message, request, responseData = null, responseHeaders = null) {
    super(message)

    this.name = this.constructor.name

    this.request = request
    this.status = request.status
    this.statusText = request.statusText

    this.data = responseData
    this.headers = responseHeaders
  }
}

export default RequestError
