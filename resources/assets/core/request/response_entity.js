const symbolRawResponse = Symbol('Response')
const symbolExposed = Symbol('exposed')

export default class ResponseEntity {
  constructor (response) {
    this[symbolRawResponse] = response
    this[symbolExposed] = response.data._XE_
    return this
  }

  get data () {
    return this[symbolRawResponse].data
  }

  get headers () {
    return this[symbolRawResponse].headers
  }

  get status () {
    return this[symbolRawResponse].status
  }

  get statusText () {
    return this[symbolRawResponse].statusText
  }

  get method () {
    return this[symbolRawResponse].config.method
  }

  get exposed () {
    return this[symbolExposed]
  }

  removeExposed () {
    delete this[symbolRawResponse].data._XE_
  }
}
