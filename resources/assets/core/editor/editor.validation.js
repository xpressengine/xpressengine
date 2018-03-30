import XEeditor from './editor.core'

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

class Validation {
  static isValidBeforeCreateInstance (sel, toolIdList, editorParent) {
    if (!sel) {
      console.error('error: 중복 editor id. (' + sel + ')')
      return false
    }

    if (editorParent.editorList.length > 0) {
      let selValid = true
      for (let i = 0, max = editorParent.editorList.length; i < max; i += 1) {
        if (editorParent.editorList[i] === sel) {
          selValid = false

          console.error()
          break
        }
      }

      if (!selValid) {
        return false
      }
    }

    return true
  }

  static isValidEditorOptions (editorSettings, interfaces) {
    let valid = true
    for (let eSettings in requireOptions.editorSettings) {
      if (!editorSettings.hasOwnProperty(requireOptions.editorSettings[eSettings])) {
        console.error('구현 필요 [editorSettings.' + requireOptions.editorSettings[eSettings] + ']')
        valid = false
      }
    }

    for (let eInterface in requireOptions.interfaces) {
      if (!interfaces.hasOwnProperty(requireOptions.interfaces[eInterface])) {
        console.error('구현 필요 [' + requireOptions.interfaces[eInterface] + ']')
        valid = false
      }
    }

    if (editorSettings.hasOwnProperty('plugins') &&
      editorSettings.plugins instanceof Array &&
      editorSettings.plugins.length > 0 &&
      !editorSettings.hasOwnProperty('addPlugins')) {
      console.error('구현 필요 [fn:addPlugins]')
    }

    if (XEeditor.editorSet.hasOwnProperty(editorSettings.name)) {
      console.error('등록된 에디터 있음 [' + editorSettings.name + ']')
      valid = false
    }

    return !(!valid)
  }

  static isValidToolsObject (obj) {
    let valid = true

    for (let i = 0, max = requireOptions.tools.property.length; i < max; i += 1) {
      if (!obj.hasOwnProperty(requireOptions.tools.property[i])) {
        console.error('구현 필요 [XEeditor.tools.define => fn:' + requireOptions.tools.property[i] + ']')
        valid = false
      }
    }

    for (let i = 0, max = requireOptions.tools.events.length; i < max; i += 1) {
      if (!obj.events.hasOwnProperty(requireOptions.tools.events[i])) {
        console.error('구현 필요[XEeditor.tools.define => event' + requireOptions.tools.events[i] + ']')
        valid = false
      }
    }

    return valid
  }
}

export default Validation
