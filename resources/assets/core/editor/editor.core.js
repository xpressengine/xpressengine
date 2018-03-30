import $ from 'jquery'
import { eventify } from 'xe-utils'
import Editor from './editor.editor'
import Validation from './editor.validation'

class EditorCore {
  constructor () {
    this.toolsSet = {}
    this.editorSet = {}
    this.editorOptionSet = {}

    eventify(this)

    /**
     * @memberof XEeditor
     * @prop {object} tools
     * @prop {function} define
     * <pre>
     *   tool을 정의한다.
     *
     *   arguments
     *   - obj : object
     * </pre>
     * @prop {function} get
     * <pre>
     *   tool을 리턴한다.
     *
     *   arguments
     *   - id : string
     * </pre>
     **/
    this.tools = {}
    this.tools.define = obj => this.addTool.call(this, obj)
    this.tools.get = id => this.getTool.call(this, id)
  }

  addTool (obj) {
    if (Validation.isValidToolsObject(obj)) {
      this.toolsSet[obj.id] = new Tools(obj)
    }
  }

  getTool (id) {
    return this.toolsSet[id]
  }

  /**
   * 에디터를 정의한다.
   * @memberof XEeditor
   * @param {object} obj
   * <pre>
   *   - editorSettings : 에디터 설정 정보
   *   - interfaces : 구현된 에디터 인터페이스
   * </pre>
   **/
  define (obj) {
    const editorSettings = obj.editorSettings
    const interfaces = obj.interfaces

    if (Validation.isValidEditorOptions(editorSettings, interfaces)) {
      const editor = new Editor(editorSettings, interfaces)
      editor._core = this

      this.editorSet[editorSettings.name] = editor
      this.editorOptionSet[editorSettings.name] = editorSettings
    }
  }

  /**
   * 에디터를 반환한다.
   * @memberof XEeditor
   * @param {string} name
   * @return {object}
   **/
  getEditor (name) {
    return this.editorSet[name]
  }

  /**
   * 컨텐츠에 tool id를 xe-tool-id attribute에 할당하여 반환한다.
   * @memberof XEeditor
   * @param {string} content
   * @param {string} id
   * @return {string} HTML markup string
   **/
  attachDomId (content, id) {
    return $(content).attr('xe-tool-id', id).clone().wrapAll('<div/>').parent().html()
  }

  /**
   * @memberof XEeditor
   * @param {string} id
   * @return {string} HTML selector string
   * @DEPRECATED
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

const XEeditor = new EditorCore()
window.XEeditor = XEeditor

export default XEeditor
