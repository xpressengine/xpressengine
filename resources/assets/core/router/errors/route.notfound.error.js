import XeError from 'xe/error'
export default class RouteNotFoundError extends XeError {
  constructor (message) {
    super(message)

    this.name = 'RouteNotFoundError'
    this.message = message
    this.routeName = message
  }
}
