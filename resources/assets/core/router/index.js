import App from 'xe/app'
import Route from './route'
import RouteNotFoundError from './errors/route.notfound.error'
import { STORE_URL } from 'xe/router/store'

/**
 * @class
 * @extends App
 */
class Router extends App {
  constructor (base, fixed = 'plugin', settings = '') {
    super()

    this.setup(base, fixed, settings)
  }

  static appName () {
    return 'Router'
  }

  /**
   *
   * @param {XE} XE
   */
  boot (XE) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    this.routes = new Map()

    return new Promise((resolve) => {
      super.boot(XE)

      this.$$config.subscribe((mutation, state) => {
        if (mutation.type === `router/${STORE_URL}`) {
          this.baseURL = state.router.origin
          this.fixedPrefix = state.router.fixedPrefix
          this.settingsPrefix = state.router.settingsPrefix
        }
      })

      XE.$$on('setup', (eventName, options) => {
        if (options.routes) this.addRoutes(options.routes)

        this.$$config.dispatch('router/setUrl', {
          origin: options.baseURL,
          fixedPrefix: options.fixedPrefix,
          settingsPrefix: options.settingsPrefix
        })
      })

      XE.getApp('Request', (request) => {
        request.$$on('exposed', (eventName, exposed) => {
          if (exposed.routes) this.addRoutes(exposed.routes)
        })
      })

      resolve(this)
    })
  }

  /**
   * @deprecated
   */
  setup (base, fixed = 'plugin', settings = '') {
    this.baseURL = base
    this.fixedPrefix = fixed
    this.settingsPrefix = settings

    this.$$config.dispatch('router/setUrl', {
      origin: base,
      fixedPrefix: fixed,
      settingsPrefix: settings
    })
  }

  /**
   *
   * @param {object} routes
   */
  addRoutes (routes) {
    for (const key in routes) {
      if (routes.hasOwnProperty(key)) {
        this.routes.set(key, new Route(this, key, routes[key]))
      }
    }
  }

  /**
   *
   * @param {string} routeName
   */
  has (routeName) {
    return this.routes.has(routeName)
  }

  /**
   *
   * @param {string} routeName
   * @return {Route}
   * @throws {RouteNotFoundError}
   */
  get (routeName) {
    if (!this.has(routeName)) {
      throw new RouteNotFoundError(routeName)
    }

    return this.routes.get(routeName)
  }
}

export default Router
export const routerInstance = new Router()
