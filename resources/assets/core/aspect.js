const symbolAdvices = Symbol('Advices')
const mapTargets = new WeakMap()
const symbolDummy = Symbol('dummy')

export default class Aspect {
  constructor (pointcut, target) {
    if (this.proxy) return this

    if (mapTargets.has(target.prototype)) {
      return mapTargets.get(target.prototype)
    }

    const that = this
    this.pointcut = pointcut
    this.target = target
    if (!this[symbolAdvices]) {
      this[symbolAdvices] = new Map()
    }

    this.proxy = new Proxy(target, {
      apply (target, thisArg, params) {
        // console.debug('params', ...params)
        let result = symbolDummy
        const adviceArguments = { params, result }
        that.applyTarget('before', thisArg, adviceArguments)

        try {
          result = Reflect.apply(target, thisArg, adviceArguments.params)

          if (result) {
            adviceArguments.result = result
            that.applyTarget('afterReturn', thisArg, adviceArguments)

            if (result instanceof Promise) {
              result.catch((error) => {
                throw (error)
              })
            }
          }
        } catch (error) {
          that.applyTarget('thrown', thisArg, adviceArguments)
        }

        that.applyTarget('after', thisArg, adviceArguments)

        if (adviceArguments.result !== symbolDummy) {
          return adviceArguments.result
        }
      }
    })

    mapTargets.set(target.prototype, this)

    return this
  }

  static aspect (pointcut, target) {
    if (mapTargets.has(target.prototype)) {
      return mapTargets.get(target.prototype)
    }

    return new Aspect(pointcut, target)
  }

  before (name, advice) {
    this.registerAdvice('before', name, advice)

    return this
  }

  after (name, advice) {
    this.registerAdvice('after', name, advice)

    return this
  }

  applyTarget (position, thisArg, adviceArguments) {
    if (this[symbolAdvices].has(position)) {
      let advices = this[symbolAdvices].get(position)

      advices.forEach((advice) => {
        advice(adviceArguments)
      })
    }
  }

  getAdvice (position, name) {
    return this[symbolAdvices].get(position).get(name)
  }

  registerAdvice (position, name, advice) {
    if (!this[symbolAdvices].has(position)) {
      this[symbolAdvices].set(position, new Map())
    }

    const mapPosition = this[symbolAdvices].get(position)

    if (!mapPosition.has(name)) {
      mapPosition.set(name, advice)
    }
  }
}
