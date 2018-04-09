import $ from 'jquery'
import { eventify } from 'xe-utils'
import Editor from './editor.editor'
import EditorValidation from './editor.validation'

/**
 * @class
 **/
class EditorCore {
  constructor () {
    this.toolsSet = {}
    this.editorSet = {}
    this.editorOptionSet = {}

    eventify(this)

    /**
     * @DEPRECATED
     **/
    this.tools = {}
    /**
     * @DEPRECATED
     **/
    this.tools.define = obj => {
      if ($.isFunction(console.warn) && $.isFunction(console.trace)) {
        console.warn('DEPRECATED: XEeditor.tools.define() is deprecated. use XEeditor.defineTool')
        console.trace()
      }
      this.defineTool(obj)
    }
    /**
     * @DEPRECATED
     **/
    this.tools.get = id => {
      if ($.isFunction(console.warn) && $.isFunction(console.trace)) {
        console.warn('DEPRECATED: XEeditor.tools.get() is deprecated. use XEeditor.getTool')
        console.trace()
      }
      return this.getTool(id)
    }
  }

  /**
   * 에디터를 정의한다.
   * @param {object} obj
   * <pre>
   *   - editorSettings : 에디터 설정 정보
   *   - interfaces : 구현된 에디터 인터페이스
   * </pre>
   **/
  define (obj) {
    const editorSettings = obj.editorSettings
    const interfaces = obj.interfaces

    if (EditorValidation.isValidEditorOptions(editorSettings, interfaces)) {
      const editor = new Editor(editorSettings, interfaces)
      this.editorSet[editorSettings.name] = editor
      this.editorOptionSet[editorSettings.name] = editorSettings
    }
  }

  /**
   * 에디터를 반환한다.
   * @param {string} name
   * @return {object}
   **/
  getEditor (name) {
    return this.editorSet[name]
  }

  /**
   * EditorTool 정의
   *
   * @param {object} obj
   */
  defineTool (obj) {
    if (EditorValidation.isValidToolsObject(obj)) {
      this.toolsSet[obj.id] = new Tools(obj)
    }
  }

  /**
   * EditorTool 반환
   *
   * @param {string} id
   * @return {object}
   */
  getTool (id) {
    return this.toolsSet[id]
  }

  /**
   * 컨텐츠에 tool id를 xe-tool-id attribute에 할당하여 반환한다.
   * @param {string} content
   * @param {string} id
   * @return {string} HTML markup string
   **/
  attachDomId (content, id) {
    return $(content).attr('xe-tool-id', id).clone().wrapAll('<div/>').parent().html()
  }

  /**
   * @DEPRECATED
   * @param {string} id
   * @return {string} HTML selector string
   **/
  getDomSelector (id) {
    return '[xe-tool-id="' + id + '"]'
  }
}

/**
 * @private
 * @class Tools
 **/
const Tools = function (obj) {
  for (let o in obj) {
    this[o] = obj[o]
  }
}

/**
 * @type       {EditorCore}
 */
const XEeditor = new EditorCore()
window.XEeditor = XEeditor

export default XEeditor
