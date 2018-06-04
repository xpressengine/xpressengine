import Singleton from 'xe/singleton'
import Route from './route'
import { requestInstance } from 'xe/request'
import RouteNotFoundError from './errors/route.notfound.error'

export default class Router extends Singleton {
  constructor (base = '/', fixed = 'plugin', settings = '') {
    super()

    this.routes = new Map()
    this.setup(base, fixed, settings)
  }

  boot (XE) {
    if (super.boot()) return

    XE.$on('setup', (eventName, options) => {
      this.setup(options.baseURL, options.fixedPrefix, options.settingsPrefix)
      if (options.routes) this.addRoutes(options.routes)
    })

    requestInstance.$on('exposed', (eventName, exposed) => {
      if (exposed.routes) this.addRoutes(exposed.routes)
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
        this.routes.set(key, new Route(key, routes[key]))
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

export const routerInstance = new Router()
