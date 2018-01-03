(function (exports) {
  'use strict';

  var editorSet = {};
  var editorOptionSet = {};

  /**
   * @private
   * @class
   * @param {string} editorName
   * @param {string} sel selector
   * @param {object} editorOptions
   * @param {array} toolInfoList 에디터에 추가될 tool 정보 리스트
   * */
  var InstanceObj = function (editorName, sel, editorOptions, toolInfoList) {

    /** @private */
    var _options = {
      editorOptions: editorOptions,
      toolInfoList: toolInfoList,
    };

    /** @public */
    this.editorName = editorName;
    /** @public */
    this.selector = sel;
    /** @public */
    this.props = {};
    /**
     * 에디터 옵션을 반환한다.
     * @public
     * @method
     * */
    this.getOptions = function () {
      return _options;
    };

  };

  InstanceObj.prototype = {
    /**
     * 생성된 instance를 반환한다InstanceObj.
     * @method
     * @return {object}
     * */
    getInstance: function () {
      return editorSet[this.editorName].editorList[this.selector];
    },
    /**
     * 에디터에 작성된 컨텐츠를 반환한다.
     * @method
     * @return {string}
     * */
    getContents: function () {
      return editorSet[this.editorName].interfaces.getContents.call(this.getInstance());
    },
    /**
     * 에디터에 내용을 입력한다.
     * @method
     * @param {string} text
     * */
    setContents: function (text) {
      editorSet[this.editorName].interfaces.setContents.call(this.getInstance(), text);
    },
    /**
     * 에디터에 내용을 입력한다.
     * @method
     * @param {string} text
     * */
    addContents: function (text) {
      editorSet[this.editorName].interfaces.addContents.call(this.getInstance(), text);
    },
    /**
     * 생성된 instance에 property를 등록한다.
     * @method
     * @param {object} obj
     * */
    addProps: function (obj) {
      for (var o in obj) {
        this.getInstance().props[o] = obj[o];
      }
    },
    /**
     * 에디터에 툴을 추가한다.
     * @method
     * @param {array} toolInstanceList
     * */
    addTools: function (toolInstanceList) {
      editorSet[this.editorName].interfaces.addTools.call(this.getInstance(), this.getOptions().toolInfoList, toolInstanceList);
    },
    /**
     * 구현된 에디터에 이벤트를 할당한다.
     * @method
     * @param {string} eventName
     * @param {function} callback event callback
     * */
    on: function (eventName, callback) {
      editorSet[this.editorName].interfaces.on.call(this.getInstance(), eventName, callback);
    },
    /**
     * 구현된 에디터 파일 업로드 기능을 호춣한다.
     * @method
     * @param {object} customOptions
     * */
    renderFileUploader: function (customOptions) {
      editorSet[this.editorName].interfaces.renderFileUploader.call(this.getInstance(), customOptions);
    },
    /**
     * 구현된 에디터 reset 함수를 호출한다.
     * @method
     * @param {object} customOptions
     * */
    reset: function () {
      editorSet[this.editorName].interfaces.reset.call(this.getInstance());
    },
  };

  /**
   * @private
   * @class Editor
   * @param {object} editorSettings
   * @param {object}interfaces
   * */
  var Editor = function (editorSettings, interfaces) {
    this.name = editorSettings.name;
    this.configs = editorSettings.configs;
    this.editorList = [];
    this.interfaces = {};

    if (editorSettings.hasOwnProperty('plugins')
      && editorSettings.plugins instanceof Array
      && editorSettings.plugins.length > 0
      && editorSettings.hasOwnProperty('addPlugins')) {
      editorSettings.addPlugins(editorSettings.plugins);
    }

    for (var o in interfaces) {
      this.interfaces[o] = interfaces[o];
    }
  };

  Editor.prototype = {
    configs: {},
    interfaces: {},
    /**
     * 에디터를 생성 및 툴을 추가한다.
     * @memberof Editor
     * @param {string} sel selector
     * @param {object} options
     * @param {object} editorOptions
     * @param {array} toolInfoList
     * */
    create: function (sel, options, editorOptions, toolInfoList) {
      var editorOptions = editorOptions || {};
      var toolInfoList = toolInfoList || [];

      var editorOptions = $.extend(this.configs || {}, editorOptions);

      if (Validation.isValidBeforeCreateInstance(sel, toolInfoList, this)) {

        this.editorList[sel] = new InstanceObj(this.name, sel, editorOptions, toolInfoList);
        this.interfaces.initialize.call(this.editorList[sel], sel, options, editorOptions);

        if (!!toolInfoList && toolInfoList.length > 0) {
          var tools = {};
          var toolInfoListFilter = [];

          for (var i = 0, max = toolInfoList.length; i < max; i += 1) {
            if (XEeditor.tools.get(toolInfoList[i].id)) {
              tools[toolInfoList[i].id] = XEeditor.tools.get(toolInfoList[i].id);
              toolInfoListFilter.push(toolInfoList[i]);

            } else {
              console.error('define된 tool이 존재하지 않음. [' + toolInfoList[i].id + ']');
            }
          }

          if (this.interfaces.addTools && typeof this.interfaces.addTools === "function") {
            this.interfaces.addTools.call(this.editorList[sel], tools, toolInfoListFilter);
          }
        }

        // return this.editorList[sel];
        return this.editorList[sel];
      }
    },
  };

  /**
   * @private
   * @class Tools
   * */
  var Tools = function (obj) {
    for (var o in obj) {
      this[o] = obj[o];
    }
  };

  /** @private */
  var toolsSet = {};

  /**
   * @namespace XEeditor
   * */
  var XEeditor = (function () {
    return {
      /**
       * 에디터를 정의한다.
       * @memberof XEeditor
       * @param {object} obj
       * <pre>
       *   - editorSettings : 에디터 설정 정보
       *   - interfaces : 구현된 에디터 인터페이스
       * </pre>
       * */
      define: function (obj) {
        var editorSettings = obj.editorSettings;
        var interfaces = obj.interfaces;

        if (Validation.isValidEditorOptions(editorSettings, interfaces)) {
          editorOptionSet[editorSettings.name] = editorSettings;
          editorSet[editorSettings.name] = new Editor(editorSettings, interfaces);
        }
      },
      /**
       * 에디터를 반환한다.
       * @memberof XEeditor
       * @param {string} name
       * @return {object}
       * */
      getEditor: function (name) {
        return editorSet[name];
      },
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
       * */
      tools: {
        define: function (obj) {
          if (Validation.isValidToolsObject(obj)) {
            toolsSet[obj.id] = new Tools(obj);
          }
        },

        get: function (id) {
          return toolsSet[id];
        },
      },
      /**
       * 컨텐츠에 tool id를 xe-tool-id attribute에 할당하여 반환한다.
       * @memberof XEeditor
       * @param {string} content
       * @param {string} id
       * @return {string} HTML markup string
       * */
      attachDomId: function (content, id) {
        return $(content).attr('xe-tool-id', id).clone().wrapAll('<div/>').parent().html();
      },
      /**
       *
       * @memberof XEeditor
       * @param {string} id
       * @return {string} HTML selector string
       * */
      getDomSelector: function (id) {
        return '[xe-tool-id="' + id + '"]';
      },
    };
  })();

  /**
   * @private
   * */
  var Validation = (function () {

    /** @private */
    var requireOptions = {
      editorSettings: [
        'name',
      ],
      interfaces: [
        'initialize',
        'getContents', 'setContents', 'addContents',
      ],
      tools: {
        property: [
          'id', 'events',
        ],
        events: [
          'iconClick', 'elementDoubleClick',
        ],
      },
    };

    return {
      isValidBeforeCreateInstance: function (sel, toolIdList, editorParent) {
        if (!sel) {
          console.error('error: 중복 editor id. (' + sel + ')');
          return false;
        }

        if (editorParent.editorList.length > 0) {
          var selValid = true;
          for (var i = 0, max = editorParent.editorList.length; i < max; i += 1) {
            if (editorParent.editorList[i] === sel) {
              selValid = false;

              console.error();
              break;
            }
          }

          if (!selValid) {
            return false;
          }
        }

        return true;
      },

      isValidEditorOptions: function (editorSettings, interfaces) {
        var valid = true;
        for (var eSettings in requireOptions.editorSettings) {
          if (!editorSettings.hasOwnProperty(requireOptions.editorSettings[eSettings])) {
            console.error('구현 필요 [editorSettings.' + requireOptions.editorSettings[eSettings] + ']');
            valid = false;
          }
        }

        for (var eInterface in requireOptions.interfaces) {
          if (!interfaces.hasOwnProperty(requireOptions.interfaces[eInterface])) {
            console.error('구현 필요 [' + requireOptions.interfaces[eInterface] + ']');
            valid = false;
          }
        }

        if (editorSettings.hasOwnProperty('plugins')
          && editorSettings.plugins instanceof Array
          && editorSettings.plugins.length > 0
          && !editorSettings.hasOwnProperty('addPlugins')) {
          console.error('구현 필요 [fn:addPlugins]');
        }

        if (!!editorSet.hasOwnProperty(editorSettings.name)) {
          console.error('등록된 에디터 있음 [' + editorSettings.name + ']');
          valid = false;
        }

        return (!valid) ? false : true;
      },

      isValidToolsObject: function (obj) {
        var valid = true;

        for (var i = 0, max = requireOptions.tools.property.length; i < max; i += 1) {
          if (!obj.hasOwnProperty(requireOptions.tools.property[i])) {
            console.error('구현 필요 [XEeditor.tools.define => fn:' + requireOptions.tools.property[i] + ']');
            valid = false;
          }
        }

        for (var i = 0, max = requireOptions.tools.events.length; i < max; i += 1) {
          if (!obj.events.hasOwnProperty(requireOptions.tools.events[i])) {
            console.error('구현 필요[XEeditor.tools.define => event' + requireOptions.tools.events[i] + ']');
            valid = false;
          }
        }

        return valid;
      },
    };
  })();

  exports.XEeditor = XEeditor;

})(window);
