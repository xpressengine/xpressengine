import XEeditor from './editor.core.js'
import Validation from './editor.validation.js'
import InstanceObj from './editor.instanceObj.js'

/**
 * @private
 * @class Editor
 * @param {object} editorSettings
 * @param {object}interfaces
 **/
let Editor = function (editorSettings, interfaces) {
  this.name = editorSettings.name
  this.configs = editorSettings.configs
  this.editorList = []
  this.interfaces = {}

  if (editorSettings.hasOwnProperty('plugins') &&
    editorSettings.plugins instanceof Array &&
    editorSettings.plugins.length > 0 &&
    editorSettings.hasOwnProperty('addPlugins')) {
    editorSettings.addPlugins(editorSettings.plugins)
  }

  for (var o in interfaces) {
    this[o] = interfaces[o]
  }
}

Editor.prototype = {
  /**
   * 에디터를 생성 및 툴을 추가한다.
   * @memberof Editor
   * @param {string} sel selector
   * @param {object} options
   * @param {object} editorOptions
   * @param {array} toolInfoList
   **/
  create: function (sel, options, editorOptions, toolInfoList) {
    toolInfoList = toolInfoList || []
    editorOptions = $.extend(this.configs || {}, editorOptions || {})

    if (Validation.isValidBeforeCreateInstance(sel, toolInfoList, this)) {
      this.editorList[sel] = new InstanceObj(this.name, sel, editorOptions, toolInfoList)
      this.initialize.call(this.editorList[sel], sel, options, editorOptions)

      if (!!toolInfoList && toolInfoList.length > 0) {
        let tools = {}
        let toolInfoListFilter = []

        for (let i = 0, max = toolInfoList.length; i < max; i += 1) {
          if (XEeditor.tools.get(toolInfoList[i].id)) {
            tools[toolInfoList[i].id] = XEeditor.tools.get(toolInfoList[i].id)
            toolInfoListFilter.push(toolInfoList[i])
          } else {
            console.error('define된 tool이 존재하지 않음. [' + toolInfoList[i].id + ']')
          }
        }

        if (this.addTools && typeof this.addTools === 'function') {
          this.addTools.call(this.editorList[sel], tools, toolInfoListFilter)
        }
      }

      // return this.editorList[sel];
      return this.editorList[sel]
    }
  }
}

export default Editor
