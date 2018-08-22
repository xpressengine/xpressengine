import App from 'xe/app'
import Route from './route'
import RouteNotFoundError from './errors/route.notfound.error'

export default class Router extends App {
  constructor (base = '/', fixed = 'plugin', settings = '') {
    super()

    this.setup(base, fixed, settings)
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

      XE.$$on('setup', (eventName, options) => {
        this.setup(options.baseURL, options.fixedPrefix, options.settingsPrefix)
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

  setup (base, fixed = 'plugin', settings = '') {
    this.baseURL = base
    this.fixedPrefix = fixed
    this.settingsPrefix = settings
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
