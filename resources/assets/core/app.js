import * as $$ from 'xe/utils'
import Aspect from 'xe/aspect'
import config from 'xe/config'

const symbolPlugins = Symbol('Plugin')
const symbolBooted = Symbol('booted')
const instances = new Map()

/**
* @class
* @property {Vuex.Store} $$config vuex store
* @property {XE} [$$xe] App.boot 실행 후 생성됨
* @borrows EventEmitter#$$emit
* @borrows EventEmitter#$$on
* @borrows EventEmitter#$$once
* @borrows EventEmitter#$$off
* @borrows EventEmitter#$$offAll
* @borrows config as $$config
*/
class App {
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

  /**
   * 앱 이름 반환
   * @static
   * @returns {String}
   */
  static appName () {
    return 'Unknown'
  }

  /**
  * booting이 끝났는지 확인
  */
  booted () {
    return this[symbolBooted]
  }

  /**
  * @param {XE} XE
  * @returns {Promise}
  */
  boot (XE) {
    return new Promise((resolve) => {
      if (this[symbolBooted]) {
        resolve(this)
      } else {
        this.$$xe = XE

        this[symbolPlugins].forEach((plugin, name) => {
          try {
            if (!plugin.booted) {
              plugin.boot(this.$$xe, this)
            }
          } catch (e) {
            console.debug('Error! Plugin boot failed')
          }
        })

        resolve(this)
        this[symbolBooted] = true
      }
    })
  }

  /**
  *
  * @param {string} pointcut
  * @return {Aspect}
  */
  intercept (pointcut, name = null, advice = null) {
    const inst = Aspect.aspect(pointcut, this[pointcut])

    this[pointcut] = inst.proxy

    // if (name && advice) {
    //   return inst.around(name, advice)
    // }

    return inst
  }

  registerPlugin (plugin) {
    this[symbolPlugins].set(plugin.name, plugin)

    try {
      if (this.booted && this.$$xe) {
        plugin.boot(this.$$xe, this)
      }
    } catch (e) {
      console.debug('Error! Plugin boot failed')
    }
  }
}

export default App
