const symbolRawResponse = Symbol('Response')

/**
 * @class
 */
class RequestEntity {
  /**
   *
   * @param {Axios#Request} request
   */
  constructor (request) {
    this[symbolRawResponse] = request
    return this
  }

  /**
   * @type {string}
   */
  get method () {
    return this[symbolRawResponse].method
  }

  /**
   * @type {string}
   */
  get container () {
    return this[symbolRawResponse].container
  }
}

export default RequestEntity
