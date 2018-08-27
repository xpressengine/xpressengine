import * as $$ from 'xe/utils'
import Aspect from 'xe/aspect'
import config from 'xe/config'

const symbolPlugins = Symbol('Plugin')
const symbolBooted = Symbol('booted')
const instances = new Map()

export default class App {
  constructor () {
    if (instances.has(this.constructor.appName())) {
      return instances.get(this.constructor.appName())
    }

    instances.set(this.constructor.appName(), this)

    this.$$config = config
    $$.eventify(this)

    this[symbolBooted] = false
    this[symbolPlugins] = new Map()

    return instances.get(this.constructor.appName())
  }

  // IE에서 오류로 인해 사용하지 않음
  // static getInstance () {
  //   if (instances.has(this.appName())) {
  //     return instances.get(this.appName())
  //   }

  //   return new this()
  // }

  booted () {
    return this[symbolBooted]
  }

  boot (XE) {
    return new Promise((resolve) => {
      if (this[symbolBooted]) {
        resolve(this)
      } else {
        this.$$xe = XE

        resolve(this)
        this[symbolBooted] = true
      }
    })
  }

  intercept (pointcut, name = null, advice = null) {
    const inst = Aspect.aspect(pointcut, this[pointcut])

    this[pointcut] = inst.proxy

    // if (name && advice) {
    //   return inst.around(name, advice)
    // }

    return inst
  }
}
