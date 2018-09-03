/**
 * @class
 * @property {object} eventMaps
 * @property {?function} target
 */
class EventEmitter {
  constructor () {
    this.eventMaps = {}
    this.target = null
  }

  /**
   * prototype 확장
   *
   * @param      {<type>}  target  The target
   */
  static mixin (target) {
    EventEmitter.extend(target.prototype)
  }

  /**
   * 객체 확장
   *
   * @param      {<type>}  target  The target
   * @return     {<type>}  { description_of_the_return_value }
   */
  static extend (target) {
    const emitter = new EventEmitter(target)

    target.$$on = (eventName, listener, options = {}) => {
      return emitter.$$on(eventName, listener, options)
    }

    target.$$once = (eventName, listener, options = {}) => {
      return emitter.$$once(eventName, listener, options)
    }

    target.$$emit = (eventName, ...args) => {
      return emitter.$$emit(eventName, ...args)
    }

    target.$$off = (eventName, symbolKey) => {
      return emitter.$$off(eventName, symbolKey)
    }

    target.$$offAll = (eventName) => {
      return emitter.$$offAll(eventName)
    }

    emitter.target = target
  }

  static eventify (target) {
    if (typeof target === 'function') {
      EventEmitter.mixin(target)
    } else if (typeof target === 'object') {
      EventEmitter.extend(target)
    }
  }

  /**
   *
   * @param {string} eventName 이벤트 이름
   * @param {function} listener
   * @param {object} [options]
   */
  $$on (eventName, listener, options = {}) {
    if (typeof eventName !== 'string') return
    if (typeof listener !== 'function') return

    // listener를 담을 맵 생성
    if (!(this.eventMaps[eventName] instanceof Map)) {
      this.eventMaps[eventName] = new Map()
    }

    options.once = (typeof options.once === 'boolean') ? options.once : false

    // listener 등록
    const symbolKey = Symbol('EventEmitter Listener')
    this.eventMaps[eventName].set(symbolKey, {
      name: options.name,
      listener,
      options
    })

    this.eventMaps[eventName] = sortListener(this.eventMaps[eventName])

    return symbolKey
  }

  /**
   *
   * @param {string} eventName
   * @param {*} listener
   * @param {*} options
   */
  $$once (eventName, listener, options = {}) {
    options.once = true
    return this.$$on(eventName, listener, options)
  }

  /**
   *
   * @param {string} eventName
   * @param  {...any} args
   */
  $$emit (eventName, ...args) {
    if (typeof eventName !== 'string') {
      return Promise.resolve()
    }
    if (!(this.eventMaps[eventName] instanceof Map)) {
      return Promise.resolve()
    }

    let listenerChain = Promise.resolve()

    // listener 호출
    this.eventMaps[eventName].forEach((item, symbolKey) => {
      if (item.options.once) this.eventMaps[eventName].delete(symbolKey)

      let listenerArgs = (args.length) ? [eventName, ...args] : [eventName]

      listenerChain = listenerChain.then(() => item.listener.apply(this.target, listenerArgs))
    })

    return listenerChain
  }

  /**
   *
   * @param {string} eventName
   * @param {Symbol} symbolKey
   */
  $$off (eventName, symbolKey) {
    if (typeof eventName !== 'string') return
    if (typeof symbolKey !== 'symbol') return
    if (!(this.eventMaps[eventName] instanceof Map)) return

    this.eventMaps[eventName].delete(symbolKey)
  }

  /**
   *
   * @param {string} eventName
   */
  $$offAll (eventName) {
    if (typeof eventName !== 'string') return

    this.eventMaps[eventName] = new Map()
  }
}

const sortListener = (arr) => {
  const sortList = Array.from(arr)
    .map(([symbol, listener]) => ({symbol, listener}))
    .sort((a, b) => {
      const name = b.listener.name
      const before = a.listener.options.before

      if (!name || !before) {
        return 0
      }

      if (before === name) {
        return -1
      }

      return 0
    })

  const result = new Map()

  sortList.forEach((item) => {
    result.set(item.symbol, item.listener)
  })

  return result
}

export default EventEmitter
