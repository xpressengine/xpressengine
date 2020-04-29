export default class Config {
  constructor (options = {}) {
    Object.assign(this, options)
  }

  set (key, value = undefined) {
    if (typeof key === 'string') {
      this[key] = value
    } else {
      let options = key
      Object.assign(this, options)
    }
  }

  get (key) {
    return this[key]
  }
}
