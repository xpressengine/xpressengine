import App from 'xe/app'
import Route from './route'
import { RouteNotFoundError } from './errors/route.error'
import { STORE_URL } from 'xe/router/store'

/**
 * @class
 * @extends App
 */
class Router extends App {
  constructor (base, fixed = 'plugin', settings = '') {
    super()

    this.routes = new Map()
    this.setup(base, fixed, settings)
  }

  static appName () {
    return 'Router'
  }

  boot (XE) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    super.boot(XE)

    return new Promise((resolve) => {
      this.baseURL = XE.options.baseURL
      this.assetsURL = XE.options.assetsURL
      this.fixedPrefix = XE.options.fixedPrefix
      this.settingsPrefix = XE.options.settingsPrefix
      if (XE.options.routes) this.addRoutes(XE.options.routes)

      this.$$config.subscribe((mutation, state) => {
        if (mutation.type === `router/${STORE_URL}`) {
          this.baseURL = state.router.origin
          this.assetsURL = state.router.assetsOrigin
          this.fixedPrefix = state.router.fixedPrefix
          this.settingsPrefix = state.router.settingsPrefix
        }
      })

      this.$$config.dispatch('router/setUrl', {
        origin: XE.options.baseURL,
        assetsOrigin: XE.options.assetsURL,
        fixedPrefix: XE.options.fixedPrefix,
        settingsPrefix: XE.options.settingsPrefix
      })

      XE.$$on('setup', (eventName, options) => {
        this.$$config.dispatch('router/setUrl', {
          origin: options.baseURL,
          assetsOrigin: options.assetsURL,
          fixedPrefix: options.fixedPrefix,
          settingsPrefix: options.settingsPrefix
        })
      })

      XE.app('Request', (request) => {
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
    // this.baseURL = base
    // this.fixedPrefix = fixed
    // this.settingsPrefix = settings

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
