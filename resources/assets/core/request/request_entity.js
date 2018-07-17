const symbolRawResponse = Symbol('Response')

export default class RequestEntity {
  constructor (request) {
    this[symbolRawResponse] = request
    return this
  }

  get method () {
    return this[symbolRawResponse].method
  }

  get container () {
    return this[symbolRawResponse].container
  }
}
