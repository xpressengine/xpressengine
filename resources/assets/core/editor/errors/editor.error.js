import XeError from 'xe/error'

/**
 * @module XeError/EditorDefineError
 * @extends XeError
 */
class EditorDefineError extends XeError {
  constructor (message) {
    super(message)
  }
}

/**
 * @module XeError/EditorToolDefineError
 * @extends XeError
 */
class EditorToolDefineError extends XeError {
  constructor (message) {
    super(message)
  }
}

/**
 * @module XeError/EditorUsedContainer
 * @extends XeError
 */
class EditorUsedContainer extends XeError {
  constructor (message) {
    super(message)
  }
}

/**
 * @module XeError/EditorUndefinedContainer
 * @extends XeError
 */
class EditorUndefinedContainer extends XeError {
  constructor (message) {
    super(message)
  }
}

export {
  EditorDefineError,
  EditorToolDefineError,
  EditorUsedContainer,
  EditorUndefinedContainer
}
