import * as $$ from 'xe/utils'
const booted = Symbol('booted')

export default class Plugin {
  constructor () {
    $$.eventify(this)
    this[booted] = false
  }

  boot (XE, App) {
    if (!this[booted]) {
      this.$$xe = XE
      this.$$app = App
      this[booted] = true

      return !this[booted]
    }

    return true
  }

  get booted () {
    return this[booted]
  }
}
