import App from 'xe/app'
import PluginToast from './plugin.toast'
import PluginForm from './plugin.form'

const defaultOptions = {
  method: 'toast'
}

/**
 * @class
 * @extends App
 */
class Griper extends App {
  constructor () {
    super()
  }

  static appName () {
    return 'Griper'
  }

  boot (XE, config) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE)

      this.registerPlugin(new PluginToast())
      this.registerPlugin(new PluginForm())

      resolve(this)
    })
  }

  error (message, options = {}) {
    this[defaultOptions.method]('danger', message)
  }
}

export default Griper
