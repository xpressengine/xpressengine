/**
 * @class
 */
class EditorTool {
  constructor (obj) {
    for (let o in obj) {
      this[o] = obj[o]
    }
  }
}

export default EditorTool
