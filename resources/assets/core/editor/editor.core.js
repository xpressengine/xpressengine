import $ from 'jquery'
import { eventify } from 'xe-utils'

class editorCore {
  constructor () {
    let toolsSet = {}

    eventify(this)

    this.editorSet = {}
    this.editorOptionSet = {}

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
    this.tools.define = (obj) => {
      if (Validation.isValidToolsObject(obj)) {
        toolsSet[obj.id] = new Tools(obj)
      }
    }
    this.tools.get = (id) => {
      return toolsSet[id]
    }
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
  define (editorSettings, interfaces) {
    if (Validation.isValidEditorOptions(editorSettings, interfaces)) {
      this.editorOptionSet[editorSettings.name] = editorSettings
      this.editorSet[editorSettings.name] = new Editor(editorSettings, interfaces)
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
     *
     * @memberof XEeditor
     * @param {string} id
     * @return {string} HTML selector string
     **/
  getDomSelector (id) {
    return '[xe-tool-id="' + id + '"]'
  }
}

let XEeditor = new editorCore()

/**
 * @private
 * @class Editor
 * @param {object} editorSettings
 * @param {object}interfaces
 **/
var Editor = function (editorSettings, interfaces) {
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

/**
 * @private
 * @class
 * @param {string} editorName
 * @param {string} sel selector
 * @param {object} editorOptions
 * @param {array} toolInfoList 에디터에 추가될 tool 정보 리스트
 **/
let InstanceObj = function (editorName, sel, editorOptions, toolInfoList) {
  /** @private */
  let _options = {
    editorOptions: editorOptions,
    toolInfoList: toolInfoList
  }

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
   **/
  this.getOptions = function () {
    return _options
  }
}

InstanceObj.prototype = {
  /**
   * 생성된 instance를 반환한다InstanceObj.
   * @method
   * @return {object}
   **/
  getInstance: function () {
    return this
  },
  /**
   * 에디터에 작성된 컨텐츠를 반환한다.
   * @method
   * @return {string}
   **/
  getContents: function () {
    return XEeditor.editorSet[this.editorName].getContents.call(this)
  },
  /**
   * 에디터에 내용을 입력한다.
   * @method
   * @param {string} text
   **/
  setContents: function (text) {
    XEeditor.editorSet[this.editorName].setContents.call(this, text)
  },
  /**
   * 에디터에 내용을 입력한다.
   * @method
   * @param {string} text
   **/
  addContents: function (text) {
    XEeditor.editorSet[this.editorName].addContents.call(this, text)
  },
  /**
   * 생성된 instance에 property를 등록한다.
   * @method
   * @param {object} obj
   **/
  addProps: function (obj) {
    for (var o in obj) {
      this.props[o] = obj[o]
    }
  },
  /**
   * 에디터에 툴을 추가한다.
   * @method
   * @param {array} toolInstanceList
   **/
  addTools: function (toolInstanceList) {
    XEeditor.editorSet[this.editorName].addTools.call(this, this.getOptions().toolInfoList, toolInstanceList)
  },
  /**
   * 구현된 에디터에 이벤트를 할당한다.
   * @method
   * @param {string} eventName
   * @param {function} callback event callback
   **/
  on: function (eventName, callback) {
    XEeditor.editorSet[this.editorName].on.call(this, eventName, callback)
  },
  /**
   * 구현된 에디터 파일 업로드 기능을 호춣한다.
   * @method
   * @param {object} customOptions
   **/
  renderFileUploader: function (customOptions) {
    XEeditor.editorSet[this.editorName].renderFileUploader.call(this, customOptions)
  },
  /**
   * 구현된 에디터 reset 함수를 호출한다.
   * @method
   * @param {object} customOptions
   **/
  reset: function () {
    XEeditor.editorSet[this.editorName].reset.call(this)
  }
}

/**
 * @private
 * @class Tools
 **/
var Tools = function (obj) {
  for (var o in obj) {
    this[o] = obj[o]
  }
}

/**
 * @private
 **/
var Validation = (function () {
  /** @private */
  let requireOptions = {
    editorSettings: [
      'name'
    ],
    interfaces: [
      'initialize',
      'getContents',
      'setContents',
      'addContents'
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

  return {
    isValidBeforeCreateInstance: function (sel, toolIdList, editorParent) {
      if (!sel) {
        console.error('error: 중복 editor id. (' + sel + ')')
        return false
      }

      if (editorParent.editorList.length > 0) {
        var selValid = true
        for (var i = 0, max = editorParent.editorList.length; i < max; i += 1) {
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
    },

    isValidEditorOptions: function (editorSettings, interfaces) {
      var valid = true
      for (var eSettings in requireOptions.editorSettings) {
        if (!editorSettings.hasOwnProperty(requireOptions.editorSettings[eSettings])) {
          console.error('구현 필요 [editorSettings.' + requireOptions.editorSettings[eSettings] + ']')
          valid = false
        }
      }

      for (var eInterface in requireOptions.interfaces) {
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
    },

    isValidToolsObject: function (obj) {
      var valid = true

      for (var i = 0, max = requireOptions.tools.property.length; i < max; i += 1) {
        if (!obj.hasOwnProperty(requireOptions.tools.property[i])) {
          console.error('구현 필요 [XEeditor.tools.define => fn:' + requireOptions.tools.property[i] + ']')
          valid = false
        }
      }

      for (var i = 0, max = requireOptions.tools.events.length; i < max; i += 1) {
        if (!obj.events.hasOwnProperty(requireOptions.tools.events[i])) {
          console.error('구현 필요[XEeditor.tools.define => event' + requireOptions.tools.events[i] + ']')
          valid = false
        }
      }

      return valid
    }
  }
})()

window.XEeditor = XEeditor

export default XEeditor
