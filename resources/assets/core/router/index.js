import App from 'xe/app'
import Route from './route'
import RouteNotFoundError from './errors/route.notfound.error'
import { STORE_URL } from 'xe/config/mutations'

export default class Router extends App {
  constructor () {
    super()
  }

  static appName () {
    return 'Router'
  }

  boot (XE) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    this.routes = new Map()

    return new Promise((resolve) => {
      super.boot(XE)

      this.$$config.subscribe((mutation, state) => {
        if (mutation.type === STORE_URL) {
          this.baseURL = state.url.origin
          this.fixedPrefix = state.url.fixedPrefix
          this.settingsPrefix = state.url.settingsPrefix
        }
      })

      XE.$$on('setup', (eventName, options) => {
        if (options.routes) this.addRoutes(options.routes)
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
    this.$$config.commit(STORE_URL, {
      origin: base,
      fixedPrefix: fixed,
      settingsPrefix: settings
    })
  }

  addRoutes (routes) {
    for (const key in routes) {
      if (routes.hasOwnProperty(key)) {
        this.routes.set(key, new Route(this, key, routes[key]))
      }
    }
  }

  has (routeName) {
    return this.routes.has(routeName)
  }

  get (routeName) {
    if (!this.has(routeName)) {
      throw new RouteNotFoundError(routeName)
    }

    return this.routes.get(routeName)
  }
}

export const routerInstance = Router.getInstance()
