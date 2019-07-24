import $ from 'jquery'
import App from 'xe/app'
import EditorDefine from './editorDefine'
import EditorValidation from './editorValidation'
import EditorTool from './editorTool'
import XE from 'xe'

/**
 * @class
 * @extends App
 */
class Editor extends App {
  constructor () {
    super()

    this.toolsSet = {}
    this.editorSet = {}
    this.editorOptionSet = {}

    /**
     * @DEPRECATED
     **/
    this.tools = {
      define: obj => {
        if ($.isFunction(console.warn) && $.isFunction(console.trace)) {
          console.warn('DEPRECATED: XEeditor.tools.define() is deprecated. use XEeditor.defineTool')
          console.trace()
        }
        this.defineTool(obj)
      },
      get: id => {
        if ($.isFunction(console.warn) && $.isFunction(console.trace)) {
          console.warn('DEPRECATED: XEeditor.tools.get() is deprecated. use XEeditor.getTool')
          console.trace()
        }
        return this.getTool(id)
      }
    }
  }

  static appName () {
    return 'Editor'
  }

  boot (XE) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE)

      resolve(this)
    })
  }

  /**
   * 에디터를 정의한다.
   * @property {editorDefinition} obj
   **/
  define (obj) {
    const editorSettings = obj.editorSettings
    const interfaces = obj.interfaces

    try {
      if (EditorValidation.isValidEditorOptions(editorSettings, interfaces)) {
        const editor = new EditorDefine(editorSettings, interfaces)
        this.editorSet[editorSettings.name] = editor
        this.editorOptionSet[editorSettings.name] = editorSettings
        this.$$emit('editor.define', editor)
      }
    } catch (e) {
      // console.error(e)
    }
  }

  /**
   * 에디터를 반환한다.
   * @param {string} name
   * @return {Promise}
   **/
  getEditor (name) {
    if (this.editorSet[name]) {
      return Promise.resolve(this.editorSet[name])
    }

    return new Promise((resolve) => {
      this.$$on('editor.define', (eventName, editor) => {
        resolve(editor)
      })
    })
  }

  /**
   * EditorTool 정의
   *
   * @param {editorToolDefinition} obj
   */
  defineTool (obj) {
    try {
      if (EditorValidation.isValidToolsObject(obj)) {
        this.toolsSet[obj.id] = new EditorTool(obj)
      }
    } catch (e) {
      console.error(e)
    }
  }

  /**
   * EditorTool 반환
   *
   * @param {string} id
   * @return {EditorTool}
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

export default Editor

/**
 * @type       {Editor}
 */
const XEeditor = new Editor()
if (!window.XEeditor) window.XEeditor = XEeditor
XE.registerApp('Editor', XEeditor)
