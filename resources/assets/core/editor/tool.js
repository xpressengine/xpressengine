export default class Tool {
  constructor (obj) {
    for (let o in obj) {
      this[o] = obj[o]
    }
  }
}
