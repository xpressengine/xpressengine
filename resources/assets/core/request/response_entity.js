const symbolRawResponse = Symbol('Response')
const symbolExposed = Symbol('exposed')

/**
 * @class
 */
class ResponseEntity {
  /**
   * @param {object} response
   */
  constructor (response) {
    this[symbolRawResponse] = response
    this[symbolExposed] = response.data._XE_
    return this
  }

  /**
   * @type {*}
   */
  get data () {
    return this[symbolRawResponse].data
  }

  /**
   * @type {object}
   */
  get headers () {
    return this[symbolRawResponse].headers
  }

  /**
   * @type {number}
   */
  get status () {
    return this[symbolRawResponse].status
  }

  /**
   * @type {string}
   */
  get statusText () {
    return this[symbolRawResponse].statusText
  }

  /**
   * @type {string}
   */
  get method () {
    return this[symbolRawResponse].config.method
  }

  /**
   * @type {object}
   */
  get exposed () {
    return this[symbolExposed]
  }

  /**
   * data에서 exposed 제거
   */
  removeExposed () {
    delete this[symbolRawResponse].data._XE_
  }
}

export default ResponseEntity
