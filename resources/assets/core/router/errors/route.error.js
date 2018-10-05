import XeError from 'xe/error'

class RouteNotFoundError extends XeError {
  constructor (message) {
    super(message)
  }
}

export {
  RouteNotFoundError
}
