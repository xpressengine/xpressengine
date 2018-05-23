const symbolRawResponse = Symbol('Response')

export default class ResponseEntity {
  constructor (response) {
    this[symbolRawResponse] = response
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
}
