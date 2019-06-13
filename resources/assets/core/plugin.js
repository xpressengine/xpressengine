import * as $$ from 'xe/utils'
const symbolBooted = Symbol('booted')

export default class Plugin {
  constructor () {
    $$.eventify(this)
    this[symbolBooted] = false
  }

  boot (XE, App) {
    return new Promise((resolve) => {
      if (this[symbolBooted]) {
        resolve(this)
      } else {
        this.$$xe = XE
        this.$$app = App
      }

      resolve(this)
      this[symbolBooted] = true
    })
  }

  booted () {
    return this[symbolBooted]
  }
}
