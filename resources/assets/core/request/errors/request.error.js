import XeError from 'xe/error'
export default class RequestError extends XeError {
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
