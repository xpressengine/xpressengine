import { EditorDefineError, EditorToolDefineError, EditorUsedContainer, EditorUndefinedContainer } from './errors/editor.error'

/**
 * @private
 */
const requireOptions = {
  editorSettings: [
    'name'
  ],
  interfaces: [
    'initialize',
    'addContents',
    'getContents',
    'setContents',
    'getContentDom'
  ],
  tools: {
    property: [
      'id',
      'events'
    ],
    events: [
      'iconClick',
      'elementDoubleClick'
    ]
  }
}

/**
 * @class
 */
class EditorValidation {
  /**
   * Editor의 instance를 생성하기 전 중복 검사 등 수행
   * @param {string} sel jQuery selector
   * @param {array} toolIdList
   * @param {object} editorParent
   * @return {boolean}
   * @throws {EditorUndefinedContainer}
   * @throws {EditorUsedContainer}
   */
  static isValidBeforeCreateInstance (sel, toolIdList, editorParent) {
    if (!sel) {
      // selector가 없음
      throw new EditorUndefinedContainer('Editor가 사용할 field를 지정해야 합니다.')
    }

    if (editorParent.editorList.length > 0) {
      let selValid = true
      for (let i = 0, max = editorParent.editorList.length; i < max; i += 1) {
        if (editorParent.editorList[i] === sel) {
          selValid = false
          throw new EditorUsedContainer(`Editor가 이미 사용 중입니다: ${sel}`)
        }
      }

      if (!selValid) {
        return false
      }
    }

    return true
  }

  /**
   * @typedef {Object} editorDefinition
   * @property {object} editorDefinition.editorSettings 에디터 설정 정보
   * @property {string} editorDefinition.editorSettings.name 에디터 설정 정보
   * @property {object} editorDefinition.interfaces 구현된 에디터 인터페이스
   * @property {function} editorDefinition.interfaces.initialize
   * @property {function} editorDefinition.interfaces.addContents
   * @property {function} editorDefinition.interfaces.getContents
   * @property {function} editorDefinition.interfaces.setContents
   * @property {function} editorDefinition.interfaces.getContentDom
   */

  /**
   * Editor 정의가 올바른지 검사
   * @param {editorDefinition.editorSettings} editorSettings
   * @param {editorDefinition.interfaces} interfaces
   * @return {boolean}
   * @throws {EditorDefineError}
   */
  static isValidEditorOptions (editorSettings, interfaces) {
    let valid = true
    for (let eSettings in requireOptions.editorSettings) {
      if (!editorSettings.hasOwnProperty(requireOptions.editorSettings[eSettings])) {
        valid = false
        throw new EditorDefineError(`Editor 규격이 맞지 않음 (구현 필요 [editorSettings: ${requireOptions.editorSettings[eSettings]}])`)
      }
    }

    for (let eInterface in requireOptions.interfaces) {
      if (!interfaces.hasOwnProperty(requireOptions.interfaces[eInterface])) {
        valid = false
        throw new EditorDefineError(`Editor 규격이 맞지 않음 (구현 필요 [interface: ${requireOptions.interfaces[eInterface]}])`)
      }
    }

    if (editorSettings.hasOwnProperty('plugins') &&
      editorSettings.plugins instanceof Array &&
      editorSettings.plugins.length > 0 &&
      !editorSettings.hasOwnProperty('addPlugins')) {
      valid = false
      throw new EditorDefineError(`Editor 규격이 맞지 않음 (구현 필요 [fn:addPlugins])`)
    }

    if (window.XEeditor.editorSet.hasOwnProperty(editorSettings.name)) {
      valid = false
      throw new EditorDefineError(`이미 같은 이름의 에디터가 등록되어 있음: ${editorSettings.name}`)
    }

    return !(!valid)
  }

  /**
   * @typedef {Object} editorToolDefinition
   * @property {string} id
   * @property {object} events
   * @property {function} events.iconClick
   * @property {function} events.elementDoubleClick
   * @deprecated
   */

  /**
   * EditorTool 정의가 올바른지 검사
   * @param {editorToolDefinition} toolDefine
   * @return {boolean}
   * @throws {EditorToolDefineError}
   */
  static isValidToolsObject (toolDefine) {
    let valid = true

    for (let i = 0, max = requireOptions.tools.property.length; i < max; i += 1) {
      if (!toolDefine.hasOwnProperty(requireOptions.tools.property[i])) {
        valid = false
        throw new EditorToolDefineError(`EditorTool 규격이 맞지 않음 (속성이 없음: ${requireOptions.tools.property[i]})`)
      }
    }

    for (let i = 0, max = requireOptions.tools.events.length; i < max; i += 1) {
      if (!toolDefine.events.hasOwnProperty(requireOptions.tools.events[i])) {
        valid = false
        throw new EditorToolDefineError(`EditorTool 규격이 맞지 않음 (이벤트가 정의되지 않음: ${requireOptions.tools.events[i]})`)
      }
    }

    return valid
  }
}

export default EditorValidation

export {
  requireOptions
}
