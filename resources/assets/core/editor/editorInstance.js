import { eventify } from 'xe-utils' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import $ from 'jquery'

/**
 * @class
 */
class EditorInstance {
  /**
   * @constructor
   * @param {string} editorName
   * @param {string} sel selector
   * @param {object} editorOptions
   * @param {array} toolInfoList 에디터에 추가될 tool 정보 리스트
   */
  constructor (editorName, sel, editorOptions, toolInfoList) {
    /** @private */
    let _options = {
      editorOptions: editorOptions,
      toolInfoList: toolInfoList
    }

    eventify(this)

    /** @public */
    this.editorName = editorName
    /** @public */
    this.selector = sel
    /** @public */
    this.props = {}
    /**
     * 에디터 옵션을 반환한다.
     * @public
     * @method
     */
    this.getOptions = function () {
      return _options
    }
  }

  /**
   * 생성된 instance를 반환한다InstanceObj.
   * @method
   * @return {object}
   */
  getInstance () {
    return this
  }

  /**
   * 에디터에 작성된 컨텐츠를 반환한다.
   * @method
   * @return {string}
   */
  getContents () {
    return XEeditor.editorSet[this.editorName].getContents.call(this)
  }

  /**
   * 에디터에 내용을 입력한다.
   * @method
   * @param {string} text
   */
  setContents (text) {
    XEeditor.editorSet[this.editorName].setContents.call(this, text)
  }

  /**
   * 에디터에 내용을 입력한다.
   * @method
   * @param {string} text
   */
  addContents (text) {
    XEeditor.editorSet[this.editorName].addContents.call(this, text)
  }

  /**
   * 생성된 instance에 property를 등록한다.
   * @method
   * @param {object} obj
   */
  addProps (obj) {
    for (var o in obj) {
      this.props[o] = obj[o]
    }
  }

  /**
   * 에디터에 툴을 추가한다.
   * @method
   * @param {array} toolInstanceList
   */
  addTools (toolInstanceList) {
    XEeditor.editorSet[this.editorName].addTools.call(this, this.getOptions().toolInfoList, toolInstanceList)
  }

  /**
   * 구현된 에디터에 이벤트를 할당한다.
   * @method
   * @param {string} eventName
   * @param {function} callback event callback
   */
  on (eventName, callback) {
    XEeditor.editorSet[this.editorName].on.call(this, eventName, callback)
  }

  /**
   * 구현된 에디터 파일 업로드 기능을 호춣한다.
   * @method
   * @param {object} customOptions
   */
  renderFileUploader (customOptions) {
    XEeditor.editorSet[this.editorName].renderFileUploader.call(this, customOptions)
  }

  getContentDom () {
    if (typeof XEeditor.editorSet[this.editorName].getContentDom === 'function') {
      return XEeditor.editorSet[this.editorName].getContentDom.call(this)
    }
    return false
  }

  /**
   * 구현된 에디터 reset 함수를 호출한다.
   * @method
   * @param {object} customOptions
   */
  reset () {
    XEeditor.editorSet[this.editorName].reset.call(this)
  }
}

export default EditorInstance
