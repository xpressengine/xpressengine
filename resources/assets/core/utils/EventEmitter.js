export default class EventEmitter {
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

    target.$on = (eventName, listener, context = null) => {
      return emitter.$on(eventName, listener, context)
    }

    target.$once = (eventName, listener, context = null) => {
      return emitter.$once(eventName, listener, context)
    }

    target.$emit = (eventName, ...args) => {
      return emitter.$emit(eventName, ...args)
    }

    target.$off = (eventName, symbolKey) => {
      return emitter.$off(eventName, symbolKey)
    }

    target.$offAll = (eventName) => {
      return emitter.$offAll(eventName)
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

  $on (eventName, listener, context = null, options = {}) {
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
      listener,
      context,
      once: options.once
    })

    return symbolKey
  }

  $once (eventName, listener, context = null) {
    return this.$on(eventName, listener, context, { 'once': true })
  }

  $emit (eventName, ...args) {
    if (typeof eventName !== 'string') return
    if (!(this.eventMaps[eventName] instanceof Map)) return

    // listener 호출
    this.eventMaps[eventName].forEach((item, symbolKey) => {
      let listenerContext = item.context || this.target

      if (item.once) this.eventMaps[eventName].delete(symbolKey)

      let listenerArgs = (args.length) ? [eventName, ...args] : [eventName]
      item.listener.apply(listenerContext, listenerArgs)
    })
  }

  $off (eventName, symbolKey) {
    if (typeof eventName !== 'string') return
    if (typeof symbolKey !== 'symbol') return
    if (!(this.eventMaps[eventName] instanceof Map)) return

    this.eventMaps[eventName].delete(symbolKey)
  }

  $offAll (eventName) {
    if (typeof eventName !== 'string') return

    this.eventMaps[eventName] = new Map()
  }
}
