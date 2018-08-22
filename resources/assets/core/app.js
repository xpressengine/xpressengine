import * as $$ from 'xe/utils'
import Aspect from 'xe/aspect'
const symbolPlugins = Symbol('Plugin')
const booted = Symbol('booted')
const symbolResolveBoot = Symbol('Resolve boot')

const instances = new Map()

export default class App {
  constructor () {
    if (instances.has(this.constructor.appName())) {
      return instances.get(this.constructor.appName())
    }

    instances.set(this.constructor.appName(), this)

    $$.eventify(this)

    this[booted] = false
    this[symbolPlugins] = new Map()

    return instances.get(this.constructor.appName())
  }

  static getInstance () {
    if (instances.has(this.appName())) {
      return instances.get(this.appName())
    }

    return new this()
  }

  booted () {
    return this[booted]
  }

  boot (XE) {
    return new Promise((resolve) => {
      this[symbolResolveBoot] = resolve

      if (this[booted]) {
        resolve(this)
      } else {
        this.$$xe = XE

        resolve(this)
        this[booted] = true
      }
    })
  }
}
