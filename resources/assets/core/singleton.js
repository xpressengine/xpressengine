const booted = Symbol('booted')
const singleton = Symbol('singleton')

export default class Singleton {
  constructor () {
    const Class = this.constructor

    if (!Class[singleton]) {
      Class[singleton] = this
    }

    return Class[singleton]
  }

  static get instance () {
    if (!this[singleton]) {
      this[singleton] = new this()
    }

    return this[singleton]
  }

  boot () {
    if (!this[booted]) {
      this[booted] = true
      return !this[booted]
    }

    return true
  }

  get booted () {
    return !!this[booted]
  }
}
