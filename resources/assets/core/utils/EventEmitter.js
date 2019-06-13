import _ from 'lodash'

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
   * @param {function} target
   */
  static mixin (target) {
    EventEmitter.extend(target.prototype)
  }

  /**
   * 객체 확장
   *
   * @param {object} target  The target
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

    target.$$hasListener = (eventName) => {
      return emitter.$$hasListener(eventName)
    }

    emitter.target = target
  }

  /**
   * @param {(object|function)} target
   */
  static eventify (target) {
    if (typeof target === 'function') {
      EventEmitter.mixin(target)
    } else if (typeof target === 'object') {
      EventEmitter.extend(target)
    }
  }

  /**
   * @param {string} eventName 이벤트 이름
   * @param {function} listener
   * @param {object} [options]
   */
  $$on (eventName, listener, options = { once: false }) {
    if (typeof eventName !== 'string') return
    if (typeof listener !== 'function') return

    // listener를 담을 맵 생성
    if (!(this.eventMaps[eventName] instanceof Map)) {
      this.eventMaps[eventName] = new Map()
    }

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
   * @param {function} listener
   * @param {object} options
   */
  $$once (eventName, listener, options = {}) {
    options.once = true
    return this.$$on(eventName, listener, options)
  }

  /**
   *
   * @param {string} eventName
   * @param {...*} args
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
      if (_.isUndefined(item) && _.isUndefined(symbolKey)) return

      if (item.options.once) this.eventMaps[eventName].delete(symbolKey)

      let listenerArgs = (args.length) ? [eventName, ...args] : [eventName]
      listenerChain = listenerChain.then((chainArgs = { stop: false }) => {
        if (chainArgs.stop === true) {
          return Promise.resolve(chainArgs)
        }

        return item.listener.apply(this.target, listenerArgs)
      })
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

  $$hasListener (eventName) {
    return (this.eventMaps[eventName] instanceof Map && this.eventMaps[eventName].size)
  }
}

/**
 * @private
 * @param {ArrayLike} arr
 * @returns {Array}
 */
const sortListener = (arr) => {
  if (arr.size < 2) {
    return arr
  }

  const result = new Map()
  let sortList = Array.from(arr).map(([symbol, listener]) => ({ symbol, listener, name: listener.name, before: listener.options.before }))
  sortList.sort((a, b) => {
    const targetIsA = sortList.indexOf(a) < sortList.indexOf(b)
    let targetItem = a
    let currentItem = b

    if (!targetIsA) {
      targetItem = b
      currentItem = a
    }

    // before를 지정하지 않았으면 유지
    if (_.isUndefined(currentItem.before)) return 0

    // before로 지정한 대상이 앞에 있으면 재정렬
    if (_.findIndex(sortList, { 'name': currentItem.before }) < sortList.indexOf(currentItem)) return (targetIsA) ? 1 : -1
    if (targetItem.name === currentItem.before) return (targetIsA) ? 1 : -1

    return 0
  })

  sortList.forEach((item) => {
    result.set(item.symbol, item.listener)
  })

  return result
}

export default EventEmitter
