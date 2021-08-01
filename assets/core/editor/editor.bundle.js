/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./core/app.js":
/*!*****************************************************************!*\
  !*** delegated ./core/app.js from dll-reference _xe_dll_common ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(28);

/***/ }),

/***/ "./core/editor/editorDefine.js":
/*!*************************************!*\
  !*** ./core/editor/editorDefine.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _editorValidation__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editorValidation */ "./core/editor/editorValidation.js");
/* harmony import */ var _editorInstance__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./editorInstance */ "./core/editor/editorInstance.js");
/* harmony import */ var xe_utils__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! xe/utils */ "./core/utils/index.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_6__);







/**
 * @class
 */

var EditorDefine = /*#__PURE__*/function () {
  /**
   * @param {object} editorSettings
   * @param {object} interfaces
   */
  function EditorDefine(editorSettings, interfaces) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorDefine);

    this.name = editorSettings.name;
    this.configs = editorSettings.configs;
    this.editorList = [];
    this.interfaces = {};
    Object(xe_utils__WEBPACK_IMPORTED_MODULE_5__["eventify"])(this);

    if (editorSettings.hasOwnProperty('plugins') && editorSettings.plugins instanceof Array && editorSettings.plugins.length > 0 && editorSettings.hasOwnProperty('addPlugins')) {
      editorSettings.addPlugins(editorSettings.plugins);
    }

    for (var o in interfaces) {
      this[o] = interfaces[o];
    }
  }
  /**
   * 에디터를 생성 및 툴을 추가한다.
   * @param {string} sel selector
   * @param {object} options
   * @param {object} editorOptions
   * @param {array} toolInfoList
   */


  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(EditorDefine, [{
    key: "create",
    value: function create(sel, options, editorOptions, toolInfoList) {
      toolInfoList = toolInfoList || [];
      editorOptions = jquery__WEBPACK_IMPORTED_MODULE_6___default.a.extend(this.configs || {}, editorOptions || {});

      if (_editorValidation__WEBPACK_IMPORTED_MODULE_3__["default"].isValidBeforeCreateInstance(sel, toolInfoList, this)) {
        var editorIntance = new _editorInstance__WEBPACK_IMPORTED_MODULE_4__["default"](this.name, sel, editorOptions, toolInfoList);
        editorIntance._editor = this;
        this.editorList[sel] = editorIntance;
        this.initialize.call(this.editorList[sel], sel, options, editorOptions);

        if (!!toolInfoList && toolInfoList.length > 0) {
          var tools = {};
          var toolInfoListFilter = [];

          for (var i = 0, max = toolInfoList.length; i < max; i += 1) {
            if (window.XEeditor.getTool(toolInfoList[i].id)) {
              tools[toolInfoList[i].id] = window.XEeditor.getTool(toolInfoList[i].id);
              toolInfoListFilter.push(toolInfoList[i]);
            } else {
              console.error('define된 tool이 존재하지 않음. [' + toolInfoList[i].id + ']');
            }
          }

          if (this.addTools && typeof this.addTools === 'function') {
            this.addTools.call(this.editorList[sel], tools, toolInfoListFilter);
          }
        }

        this.$$emit('editor.created', this.editorList[sel]);
        return this.editorList[sel];
      }
    }
  }]);

  return EditorDefine;
}();

/* harmony default export */ __webpack_exports__["default"] = (EditorDefine);

/***/ }),

/***/ "./core/editor/editorInstance.js":
/*!***************************************!*\
  !*** ./core/editor/editorInstance.js ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var xe_utils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! xe-utils */ "./core/utils/index.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_3__);


 // @FIXME https://github.com/xpressengine/xpressengine/issues/765


/**
 * @class
 */

var EditorInstance = /*#__PURE__*/function () {
  /**
   * @constructor
   * @param {string} editorName
   * @param {string} sel selector
   * @param {object} editorOptions
   * @param {array} toolInfoList 에디터에 추가될 tool 정보 리스트
   */
  function EditorInstance(editorName, sel, editorOptions, toolInfoList) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorInstance);

    /** @private */
    var _options = {
      editorOptions: editorOptions,
      toolInfoList: toolInfoList
    };
    Object(xe_utils__WEBPACK_IMPORTED_MODULE_2__["eventify"])(this);
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
     */

    this.getOptions = function () {
      return _options;
    };
  }
  /**
   * 생성된 instance를 반환한다InstanceObj.
   * @method
   * @return {object}
   */


  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(EditorInstance, [{
    key: "getInstance",
    value: function getInstance() {
      return this;
    }
    /**
     * 에디터에 작성된 컨텐츠를 반환한다.
     * @method
     * @return {string}
     */

  }, {
    key: "getContents",
    value: function getContents() {
      return XEeditor.editorSet[this.editorName].getContents.call(this);
    }
    /**
     * 에디터에 내용을 입력한다.
     * @method
     * @param {string} text
     */

  }, {
    key: "setContents",
    value: function setContents(text) {
      XEeditor.editorSet[this.editorName].setContents.call(this, text);
    }
    /**
     * 에디터에 내용을 입력한다.
     * @method
     * @param {string} text
     */

  }, {
    key: "addContents",
    value: function addContents(text) {
      XEeditor.editorSet[this.editorName].addContents.call(this, text);
    }
    /**
     * 생성된 instance에 property를 등록한다.
     * @method
     * @param {object} obj
     */

  }, {
    key: "addProps",
    value: function addProps(obj) {
      for (var o in obj) {
        this.props[o] = obj[o];
      }
    }
    /**
     * 에디터에 툴을 추가한다.
     * @method
     * @param {array} toolInstanceList
     */

  }, {
    key: "addTools",
    value: function addTools(toolInstanceList) {
      XEeditor.editorSet[this.editorName].addTools.call(this, this.getOptions().toolInfoList, toolInstanceList);
    }
    /**
     * 구현된 에디터에 이벤트를 할당한다.
     * @method
     * @param {string} eventName
     * @param {function} callback event callback
     */

  }, {
    key: "on",
    value: function on(eventName, callback) {
      XEeditor.editorSet[this.editorName].on.call(this, eventName, callback);
    }
    /**
     * 구현된 에디터 파일 업로드 기능을 호춣한다.
     * @method
     * @param {object} customOptions
     */

  }, {
    key: "renderFileUploader",
    value: function renderFileUploader(customOptions) {
      XEeditor.editorSet[this.editorName].renderFileUploader.call(this, customOptions);
    }
  }, {
    key: "getContentDom",
    value: function getContentDom() {
      if (typeof XEeditor.editorSet[this.editorName].getContentDom === 'function') {
        return XEeditor.editorSet[this.editorName].getContentDom.call(this);
      }

      return false;
    }
    /**
     * 구현된 에디터 reset 함수를 호출한다.
     * @method
     * @param {object} customOptions
     */

  }, {
    key: "reset",
    value: function reset() {
      XEeditor.editorSet[this.editorName].reset.call(this);
    }
  }]);

  return EditorInstance;
}();

/* harmony default export */ __webpack_exports__["default"] = (EditorInstance);

/***/ }),

/***/ "./core/editor/editorTool.js":
/*!***********************************!*\
  !*** ./core/editor/editorTool.js ***!
  \***********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);


/**
 * @class
 */
var EditorTool = function EditorTool(obj) {
  _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorTool);

  for (var o in obj) {
    this[o] = obj[o];
  }
};

/* harmony default export */ __webpack_exports__["default"] = (EditorTool);

/***/ }),

/***/ "./core/editor/editorValidation.js":
/*!*****************************************!*\
  !*** ./core/editor/editorValidation.js ***!
  \*****************************************/
/*! exports provided: default, requireOptions */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "requireOptions", function() { return requireOptions; });
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./errors/editor.error */ "./core/editor/errors/editor.error.js");




/**
 * @private
 */

var requireOptions = {
  editorSettings: ['name'],
  interfaces: ['initialize', 'addContents', 'getContents', 'setContents', 'getContentDom'],
  tools: {
    property: ['id', 'events'],
    events: ['iconClick', 'elementDoubleClick']
  }
};
/**
 * @class
 */

var EditorValidation = /*#__PURE__*/function () {
  function EditorValidation() {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorValidation);
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(EditorValidation, null, [{
    key: "isValidBeforeCreateInstance",
    value:
    /**
     * Editor의 instance를 생성하기 전 중복 검사 등 수행
     * @param {string} sel jQuery selector
     * @param {array} toolIdList
     * @param {object} editorParent
     * @return {boolean}
     * @throws {EditorUndefinedContainer}
     * @throws {EditorUsedContainer}
     */
    function isValidBeforeCreateInstance(sel, toolIdList, editorParent) {
      if (!sel) {
        // selector가 없음
        throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__["EditorUndefinedContainer"]('Editor가 사용할 field를 지정해야 합니다.');
      }

      if (editorParent.editorList.length > 0) {
        var selValid = true;

        for (var i = 0, max = editorParent.editorList.length; i < max; i += 1) {
          if (editorParent.editorList[i] === sel) {
            selValid = false;
            throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__["EditorUsedContainer"]("Editor\uAC00 \uC774\uBBF8 \uC0AC\uC6A9 \uC911\uC785\uB2C8\uB2E4: ".concat(sel));
          }
        }

        if (!selValid) {
          return false;
        }
      }

      return true;
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

  }, {
    key: "isValidEditorOptions",
    value: function isValidEditorOptions(editorSettings, interfaces) {
      var valid = true;

      for (var eSettings in requireOptions.editorSettings) {
        if (!editorSettings.hasOwnProperty(requireOptions.editorSettings[eSettings])) {
          valid = false;
          throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__["EditorDefineError"]("Editor \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uAD6C\uD604 \uD544\uC694 [editorSettings: ".concat(requireOptions.editorSettings[eSettings], "])"));
        }
      }

      for (var eInterface in requireOptions.interfaces) {
        if (!interfaces.hasOwnProperty(requireOptions.interfaces[eInterface])) {
          valid = false;
          throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__["EditorDefineError"]("Editor \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uAD6C\uD604 \uD544\uC694 [interface: ".concat(requireOptions.interfaces[eInterface], "])"));
        }
      }

      if (editorSettings.hasOwnProperty('plugins') && editorSettings.plugins instanceof Array && editorSettings.plugins.length > 0 && !editorSettings.hasOwnProperty('addPlugins')) {
        valid = false;
        throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__["EditorDefineError"]("Editor \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uAD6C\uD604 \uD544\uC694 [fn:addPlugins])");
      }

      if (window.XEeditor.editorSet.hasOwnProperty(editorSettings.name)) {
        valid = false;
        throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__["EditorDefineError"]("\uC774\uBBF8 \uAC19\uC740 \uC774\uB984\uC758 \uC5D0\uB514\uD130\uAC00 \uB4F1\uB85D\uB418\uC5B4 \uC788\uC74C: ".concat(editorSettings.name));
      }

      return !!valid;
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

  }, {
    key: "isValidToolsObject",
    value: function isValidToolsObject(toolDefine) {
      var valid = true;

      for (var i = 0, max = requireOptions.tools.property.length; i < max; i += 1) {
        if (!toolDefine.hasOwnProperty(requireOptions.tools.property[i])) {
          valid = false;
          throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__["EditorToolDefineError"]("EditorTool \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uC18D\uC131\uC774 \uC5C6\uC74C: ".concat(requireOptions.tools.property[i], ")"));
        }
      }

      for (var _i = 0, _max = requireOptions.tools.events.length; _i < _max; _i += 1) {
        if (!toolDefine.events.hasOwnProperty(requireOptions.tools.events[_i])) {
          valid = false;
          throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_3__["EditorToolDefineError"]("EditorTool \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uC774\uBCA4\uD2B8\uAC00 \uC815\uC758\uB418\uC9C0 \uC54A\uC74C: ".concat(requireOptions.tools.events[_i], ")"));
        }
      }

      return valid;
    }
  }]);

  return EditorValidation;
}();

/* harmony default export */ __webpack_exports__["default"] = (EditorValidation);


/***/ }),

/***/ "./core/editor/errors/editor.error.js":
/*!********************************************!*\
  !*** ./core/editor/errors/editor.error.js ***!
  \********************************************/
/*! exports provided: EditorDefineError, EditorToolDefineError, EditorUsedContainer, EditorUndefinedContainer */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "EditorDefineError", function() { return EditorDefineError; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "EditorToolDefineError", function() { return EditorToolDefineError; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "EditorUsedContainer", function() { return EditorUsedContainer; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "EditorUndefinedContainer", function() { return EditorUndefinedContainer; });
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/reflect/construct */ "./node_modules/@babel/runtime-corejs3/core-js-stable/reflect/construct.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/inherits */ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/getPrototypeOf */ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var xe_error__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! xe/error */ "./core/error/index.js");






function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(this).constructor; result = _babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default()(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default()(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default.a) return false; if (_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default.a.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default()(Boolean, [], function () {})); return true; } catch (e) { return false; } }


/**
 * @module XeError/EditorDefineError
 * @extends XeError
 */

var EditorDefineError = /*#__PURE__*/function (_XeError) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default()(EditorDefineError, _XeError);

  var _super = _createSuper(EditorDefineError);

  function EditorDefineError(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, EditorDefineError);

    return _super.call(this, message);
  }

  return EditorDefineError;
}(xe_error__WEBPACK_IMPORTED_MODULE_5__["default"]);
/**
 * @module XeError/EditorToolDefineError
 * @extends XeError
 */


var EditorToolDefineError = /*#__PURE__*/function (_XeError2) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default()(EditorToolDefineError, _XeError2);

  var _super2 = _createSuper(EditorToolDefineError);

  function EditorToolDefineError(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, EditorToolDefineError);

    return _super2.call(this, message);
  }

  return EditorToolDefineError;
}(xe_error__WEBPACK_IMPORTED_MODULE_5__["default"]);
/**
 * @module XeError/EditorUsedContainer
 * @extends XeError
 */


var EditorUsedContainer = /*#__PURE__*/function (_XeError3) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default()(EditorUsedContainer, _XeError3);

  var _super3 = _createSuper(EditorUsedContainer);

  function EditorUsedContainer(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, EditorUsedContainer);

    return _super3.call(this, message);
  }

  return EditorUsedContainer;
}(xe_error__WEBPACK_IMPORTED_MODULE_5__["default"]);
/**
 * @module XeError/EditorUndefinedContainer
 * @extends XeError
 */


var EditorUndefinedContainer = /*#__PURE__*/function (_XeError4) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default()(EditorUndefinedContainer, _XeError4);

  var _super4 = _createSuper(EditorUndefinedContainer);

  function EditorUndefinedContainer(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, EditorUndefinedContainer);

    return _super4.call(this, message);
  }

  return EditorUndefinedContainer;
}(xe_error__WEBPACK_IMPORTED_MODULE_5__["default"]);



/***/ }),

/***/ "./core/editor/index.js":
/*!******************************!*\
  !*** ./core/editor/index.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/reflect/construct */ "./node_modules/@babel/runtime-corejs3/core-js-stable/reflect/construct.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/get */ "./node_modules/@babel/runtime-corejs3/helpers/get.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/inherits */ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/getPrototypeOf */ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/promise */ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var xe_app__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! xe/app */ "./core/app.js");
/* harmony import */ var _editorDefine__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./editorDefine */ "./core/editor/editorDefine.js");
/* harmony import */ var _editorValidation__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./editorValidation */ "./core/editor/editorValidation.js");
/* harmony import */ var _editorTool__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./editorTool */ "./core/editor/editorTool.js");
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! xe */ "./core/index.js");










function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default()(this).constructor; result = _babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default()(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5___default()(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default.a) return false; if (_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default.a.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default()(Boolean, [], function () {})); return true; } catch (e) { return false; } }







/**
 * @class
 * @extends App
 */

var Editor = /*#__PURE__*/function (_App) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default()(Editor, _App);

  var _super = _createSuper(Editor);

  function Editor() {
    var _this;

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, Editor);

    _this = _super.call(this);
    _this.toolsSet = {};
    _this.editorSet = {};
    _this.editorOptionSet = {};
    /**
     * @DEPRECATED
     **/

    _this.tools = {
      define: function define(obj) {
        if (jquery__WEBPACK_IMPORTED_MODULE_9___default.a.isFunction(console.warn) && jquery__WEBPACK_IMPORTED_MODULE_9___default.a.isFunction(console.trace)) {
          console.warn('DEPRECATED: XEeditor.tools.define() is deprecated. use XEeditor.defineTool');
          console.trace();
        }

        _this.defineTool(obj);
      },
      get: function get(id) {
        if (jquery__WEBPACK_IMPORTED_MODULE_9___default.a.isFunction(console.warn) && jquery__WEBPACK_IMPORTED_MODULE_9___default.a.isFunction(console.trace)) {
          console.warn('DEPRECATED: XEeditor.tools.get() is deprecated. use XEeditor.getTool');
          console.trace();
        }

        return _this.getTool(id);
      }
    };
    return _this;
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(Editor, [{
    key: "boot",
    value: function boot(XE) {
      var _this2 = this;

      if (this.booted()) {
        return _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_8___default.a.resolve(this);
      }

      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_8___default.a(function (resolve) {
        _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_3___default()(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default()(Editor.prototype), "boot", _this2).call(_this2, XE);

        resolve(_this2);
      });
    }
    /**
     * 에디터를 정의한다.
     * @property {editorDefinition} obj
     **/

  }, {
    key: "define",
    value: function define(obj) {
      var editorSettings = obj.editorSettings;
      var interfaces = obj.interfaces;

      try {
        if (_editorValidation__WEBPACK_IMPORTED_MODULE_12__["default"].isValidEditorOptions(editorSettings, interfaces)) {
          var editor = new _editorDefine__WEBPACK_IMPORTED_MODULE_11__["default"](editorSettings, interfaces);
          this.editorSet[editorSettings.name] = editor;
          this.editorOptionSet[editorSettings.name] = editorSettings;
          this.$$emit('editor.define', editor);
        }
      } catch (e) {// console.error(e)
      }
    }
    /**
     * 에디터를 반환한다.
     * @param {string} name
     * @return {Promise}
     **/

  }, {
    key: "getEditor",
    value: function getEditor(name) {
      var _this3 = this;

      if (this.editorSet[name]) {
        return _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_8___default.a.resolve(this.editorSet[name]);
      }

      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_8___default.a(function (resolve) {
        _this3.$$on('editor.define', function (eventName, editor) {
          resolve(editor);
        });
      });
    }
    /**
     * EditorTool 정의
     *
     * @param {editorToolDefinition} obj
     */

  }, {
    key: "defineTool",
    value: function defineTool(obj) {
      try {
        if (_editorValidation__WEBPACK_IMPORTED_MODULE_12__["default"].isValidToolsObject(obj)) {
          this.toolsSet[obj.id] = new _editorTool__WEBPACK_IMPORTED_MODULE_13__["default"](obj);
        }
      } catch (e) {
        console.error(e);
      }
    }
    /**
     * EditorTool 반환
     *
     * @param {string} id
     * @return {EditorTool}
     */

  }, {
    key: "getTool",
    value: function getTool(id) {
      return this.toolsSet[id];
    }
    /**
     * 컨텐츠에 tool id를 xe-tool-id attribute에 할당하여 반환한다.
     * @param {string} content
     * @param {string} id
     * @return {string} HTML markup string
     **/

  }, {
    key: "attachDomId",
    value: function attachDomId(content, id) {
      return jquery__WEBPACK_IMPORTED_MODULE_9___default()(content).attr('xe-tool-id', id).clone().wrapAll('<div/>').parent().html();
    }
    /**
     * @DEPRECATED
     * @param {string} id
     * @return {string} HTML selector string
     **/

  }, {
    key: "getDomSelector",
    value: function getDomSelector(id) {
      return '[xe-tool-id="' + id + '"]';
    }
  }], [{
    key: "appName",
    value: function appName() {
      return 'Editor';
    }
  }]);

  return Editor;
}(xe_app__WEBPACK_IMPORTED_MODULE_10__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (Editor);
/**
 * @type       {Editor}
 */

var XEeditor = new Editor();
if (!window.XEeditor) window.XEeditor = XEeditor;
xe__WEBPACK_IMPORTED_MODULE_14__["default"].registerApp('Editor', XEeditor);

/***/ }),

/***/ "./core/editor/textarea.define.js":
/*!****************************************!*\
  !*** ./core/editor/textarea.define.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.join.js */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! xe */ "./core/index.js");



xe__WEBPACK_IMPORTED_MODULE_2__["default"].app('Editor', function (Editor) {
  Editor.define({
    editorSettings: {
      name: 'XEtextarea',
      configs: {}
    },

    /**
     * @prop {object} interfaces
     * @prop {function(selector,options)} interfaces.initialize
     * <pre>
     *   arguments
     *   - selector : string
     *   - options : object
     * </pre>
     * @prop {function} interfaces.getContents 에디터 컨텐츠를 리턴한다.
     * @prop {function} interfaces.setContents 에디터에 컨텐츠를 덮어쓴다.
     * <pre>
     *   arguments
     *   - text : string
     * </pre>
     * @prop {function} interfaces.addContents 에디터에 컨텐츠를 추가한다.
     * <pre>
     *   arguments
     *   - text : string
     * </pre>
     * @prop {function} interfaces.on 에디터에 이벤트 핸들러를 추가한다.
     * <pre>
     *   arguments
     *   - eventName : string
     *   - callback : function
     * </pre>
     * @prop {function} interfaces.reset 에디터 컨텐츠를 초기화한다.
     */
    interfaces: {
      initialize: function initialize(selector, options) {
        options = jquery__WEBPACK_IMPORTED_MODULE_1___default.a.extend(true, {
          fileUpload: {},
          suggestion: {},
          names: {
            file: {
              image: {}
            },
            tag: {},
            mention: {}
          },
          extensions: [],
          fontFamily: [],
          perms: {},
          files: []
        }, options);
        var $editor = jquery__WEBPACK_IMPORTED_MODULE_1___default()('#' + selector);
        var height = options.height;
        var fontFamily = options.fontFamily;
        var fontSize = options.fontSize;
        this.addProps({
          editor: $editor,
          selector: selector,
          options: options
        });

        if (height) {
          $editor.css('height', height + 'px');
        }

        if (fontFamily || fontSize) {
          if (fontFamily && fontFamily.length > 0) {
            $editor.css('font-family', fontFamily.join(','));
          }

          if (fontSize) {
            $editor.css('font-size', fontSize);
          }
        }

        $editor.parents('form').on('submit', function () {
          var fileInput = options.names.file.input;
          var files = options.files;
          var $paramWrap = jquery__WEBPACK_IMPORTED_MODULE_1___default()(); // files input삭제 후 생성

          $editor.nextAll('.paramWrap').remove();
          $editor.after("<div class='paramWrap'>");
          $paramWrap = $editor.nextAll('.paramWrap'); // files

          if (files.length > 0) {
            for (var i = 0, max = files.length; i < max; i += 1) {
              var file = files[i];
              $paramWrap.append("<input type='hidden'name='" + fileInput + "[]' value='" + file.id + "' />");
            }
          }
        });
      },
      getContents: function getContents() {
        return this.props.editor.val();
      },
      setContents: function setContents(text) {
        this.props.editor.val(text);
      },
      addContents: function addContents(text) {
        var html = this.props.editor.val();
        this.props.editor.val(html);
      },
      on: function on(eventName, callback) {
        this.props.editor.on(eventName, callback);
      },
      getContentDom: function getContentDom() {
        return false;
      },
      reset: function reset() {
        // contents 삭제
        this.props.editor.val('').focus(); // input hidden 삭제

        this.props.editor.nextAll('.paramWrap').remove();
      }
    }
  });
});

/***/ }),

/***/ "./core/error/index.js":
/*!*************************************************************************!*\
  !*** delegated ./core/error/index.js from dll-reference _xe_dll_common ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(106);

/***/ }),

/***/ "./core/index.js":
/*!*******************************************************************!*\
  !*** delegated ./core/index.js from dll-reference _xe_dll_common ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(444);

/***/ }),

/***/ "./core/utils/index.js":
/*!*************************************************************************!*\
  !*** delegated ./core/utils/index.js from dll-reference _xe_dll_common ***!
  \*************************************************************************/
/*! exports provided: getUri, addCommas, strtotime, EventEmitter, curry, debounce, find, forEach, mapValues, throttle, trim, trimEnd, trimStart, setBaseURL, eventify, isImage, isVideo, isAudio, formatSizeUnits, sizeFormatToBytes, isURL, asset, openWindow */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(7);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(2);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/reflect/construct.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/reflect/construct.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(1);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(6);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js":
/*!****************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/createClass.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(8);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/get.js":
/*!********************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/get.js from dll-reference _xe_dll_common ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(21);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(4);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js":
/*!*************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/inherits.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(13);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js":
/*!******************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(14);

/***/ }),

/***/ "./node_modules/core-js/modules/es.array.join.js":
/*!***************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.array.join.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(131);

/***/ }),

/***/ "./node_modules/core-js/modules/es.function.name.js":
/*!******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.function.name.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(68);

/***/ }),

/***/ "./node_modules/jquery/src/jquery.js":
/*!***************************************************************************************!*\
  !*** delegated ./node_modules/jquery/src/jquery.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(0);

/***/ }),

/***/ 1:
/*!******************************************************************!*\
  !*** multi ./core/editor/index ./core/editor/textarea.define.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/bkim/Documents/xehub/xpressengine/resources/assets/core/editor/index */"./core/editor/index.js");
module.exports = __webpack_require__(/*! /Users/bkim/Documents/xehub/xpressengine/resources/assets/core/editor/textarea.define.js */"./core/editor/textarea.define.js");


/***/ }),

/***/ "dll-reference _xe_dll_common":
/*!*********************************!*\
  !*** external "_xe_dll_common" ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = _xe_dll_common;

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvYXBwLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9jb3JlL2VkaXRvci9lZGl0b3JEZWZpbmUuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvZWRpdG9ySW5zdGFuY2UuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvZWRpdG9yVG9vbC5qcyIsIndlYnBhY2s6Ly8vLi9jb3JlL2VkaXRvci9lZGl0b3JWYWxpZGF0aW9uLmpzIiwid2VicGFjazovLy8uL2NvcmUvZWRpdG9yL2Vycm9ycy9lZGl0b3IuZXJyb3IuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvaW5kZXguanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvdGV4dGFyZWEuZGVmaW5lLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9jb3JlL2Vycm9yL2luZGV4LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vY29yZS9pbmRleC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvdXRpbHMvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9wcm9taXNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvcmVmbGVjdC9jb25zdHJ1Y3QuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NsYXNzQ2FsbENoZWNrLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jcmVhdGVDbGFzcy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvZ2V0LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9nZXRQcm90b3R5cGVPZi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvaW5oZXJpdHMuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL3Bvc3NpYmxlQ29uc3RydWN0b3JSZXR1cm4uanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLmFycmF5LmpvaW4uanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLmZ1bmN0aW9uLm5hbWUuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvanF1ZXJ5L3NyYy9qcXVlcnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsiRWRpdG9yRGVmaW5lIiwiZWRpdG9yU2V0dGluZ3MiLCJpbnRlcmZhY2VzIiwibmFtZSIsImNvbmZpZ3MiLCJlZGl0b3JMaXN0IiwiZXZlbnRpZnkiLCJoYXNPd25Qcm9wZXJ0eSIsInBsdWdpbnMiLCJBcnJheSIsImxlbmd0aCIsImFkZFBsdWdpbnMiLCJvIiwic2VsIiwib3B0aW9ucyIsImVkaXRvck9wdGlvbnMiLCJ0b29sSW5mb0xpc3QiLCIkIiwiZXh0ZW5kIiwiRWRpdG9yVmFsaWRhdGlvbiIsImlzVmFsaWRCZWZvcmVDcmVhdGVJbnN0YW5jZSIsImVkaXRvckludGFuY2UiLCJFZGl0b3JJbnN0YW5jZSIsIl9lZGl0b3IiLCJpbml0aWFsaXplIiwiY2FsbCIsInRvb2xzIiwidG9vbEluZm9MaXN0RmlsdGVyIiwiaSIsIm1heCIsIndpbmRvdyIsIlhFZWRpdG9yIiwiZ2V0VG9vbCIsImlkIiwicHVzaCIsImNvbnNvbGUiLCJlcnJvciIsImFkZFRvb2xzIiwiJCRlbWl0IiwiZWRpdG9yTmFtZSIsIl9vcHRpb25zIiwic2VsZWN0b3IiLCJwcm9wcyIsImdldE9wdGlvbnMiLCJlZGl0b3JTZXQiLCJnZXRDb250ZW50cyIsInRleHQiLCJzZXRDb250ZW50cyIsImFkZENvbnRlbnRzIiwib2JqIiwidG9vbEluc3RhbmNlTGlzdCIsImV2ZW50TmFtZSIsImNhbGxiYWNrIiwib24iLCJjdXN0b21PcHRpb25zIiwicmVuZGVyRmlsZVVwbG9hZGVyIiwiZ2V0Q29udGVudERvbSIsInJlc2V0IiwiRWRpdG9yVG9vbCIsInJlcXVpcmVPcHRpb25zIiwicHJvcGVydHkiLCJldmVudHMiLCJ0b29sSWRMaXN0IiwiZWRpdG9yUGFyZW50IiwiRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyIiwic2VsVmFsaWQiLCJFZGl0b3JVc2VkQ29udGFpbmVyIiwidmFsaWQiLCJlU2V0dGluZ3MiLCJFZGl0b3JEZWZpbmVFcnJvciIsImVJbnRlcmZhY2UiLCJ0b29sRGVmaW5lIiwiRWRpdG9yVG9vbERlZmluZUVycm9yIiwibWVzc2FnZSIsIlhlRXJyb3IiLCJFZGl0b3IiLCJ0b29sc1NldCIsImVkaXRvck9wdGlvblNldCIsImRlZmluZSIsImlzRnVuY3Rpb24iLCJ3YXJuIiwidHJhY2UiLCJkZWZpbmVUb29sIiwiZ2V0IiwiWEUiLCJib290ZWQiLCJyZXNvbHZlIiwiaXNWYWxpZEVkaXRvck9wdGlvbnMiLCJlZGl0b3IiLCJlIiwiJCRvbiIsImlzVmFsaWRUb29sc09iamVjdCIsImNvbnRlbnQiLCJhdHRyIiwiY2xvbmUiLCJ3cmFwQWxsIiwicGFyZW50IiwiaHRtbCIsIkFwcCIsInJlZ2lzdGVyQXBwIiwiYXBwIiwiZmlsZVVwbG9hZCIsInN1Z2dlc3Rpb24iLCJuYW1lcyIsImZpbGUiLCJpbWFnZSIsInRhZyIsIm1lbnRpb24iLCJleHRlbnNpb25zIiwiZm9udEZhbWlseSIsInBlcm1zIiwiZmlsZXMiLCIkZWRpdG9yIiwiaGVpZ2h0IiwiZm9udFNpemUiLCJhZGRQcm9wcyIsImNzcyIsImpvaW4iLCJwYXJlbnRzIiwiZmlsZUlucHV0IiwiaW5wdXQiLCIkcGFyYW1XcmFwIiwibmV4dEFsbCIsInJlbW92ZSIsImFmdGVyIiwiYXBwZW5kIiwidmFsIiwiZm9jdXMiXSwibWFwcGluZ3MiOiI7UUFBQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTs7O1FBR0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLDBDQUEwQyxnQ0FB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QUZpQixDQUlqQjs7QUFDQSxhQUFLckYsS0FBTCxDQUFXOEMsTUFBWCxDQUFrQmtDLE9BQWxCLENBQTBCLFlBQTFCLEVBQXdDQyxNQUF4QztBQUNEO0FBdkZTO0FBaENBLEdBQWQ7QUEwSEQsQ0EzSEQsRTs7Ozs7Ozs7Ozs7QUNIQSxnSDs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDQUEsZ0MiLCJmaWxlIjoiYXNzZXRzL2NvcmUvZWRpdG9yL2VkaXRvci5idW5kbGUuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIlwiO1xuXG5cbiBcdC8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuIFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oX193ZWJwYWNrX3JlcXVpcmVfXy5zID0gMSk7XG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjgpOyIsImltcG9ydCBFZGl0b3JWYWxpZGF0aW9uIGZyb20gJy4vZWRpdG9yVmFsaWRhdGlvbidcbmltcG9ydCBFZGl0b3JJbnN0YW5jZSBmcm9tICcuL2VkaXRvckluc3RhbmNlJ1xuaW1wb3J0IHsgZXZlbnRpZnkgfSBmcm9tICd4ZS91dGlscydcbmltcG9ydCAkIGZyb20gJ2pxdWVyeSdcblxuLyoqXG4gKiBAY2xhc3NcbiAqL1xuY2xhc3MgRWRpdG9yRGVmaW5lIHtcbiAgLyoqXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBlZGl0b3JTZXR0aW5nc1xuICAgKiBAcGFyYW0ge29iamVjdH0gaW50ZXJmYWNlc1xuICAgKi9cbiAgY29uc3RydWN0b3IgKGVkaXRvclNldHRpbmdzLCBpbnRlcmZhY2VzKSB7XG4gICAgdGhpcy5uYW1lID0gZWRpdG9yU2V0dGluZ3MubmFtZVxuICAgIHRoaXMuY29uZmlncyA9IGVkaXRvclNldHRpbmdzLmNvbmZpZ3NcbiAgICB0aGlzLmVkaXRvckxpc3QgPSBbXVxuICAgIHRoaXMuaW50ZXJmYWNlcyA9IHt9XG5cbiAgICBldmVudGlmeSh0aGlzKVxuXG4gICAgaWYgKGVkaXRvclNldHRpbmdzLmhhc093blByb3BlcnR5KCdwbHVnaW5zJykgJiZcbiAgICAgIGVkaXRvclNldHRpbmdzLnBsdWdpbnMgaW5zdGFuY2VvZiBBcnJheSAmJlxuICAgICAgZWRpdG9yU2V0dGluZ3MucGx1Z2lucy5sZW5ndGggPiAwICYmXG4gICAgICBlZGl0b3JTZXR0aW5ncy5oYXNPd25Qcm9wZXJ0eSgnYWRkUGx1Z2lucycpKSB7XG4gICAgICBlZGl0b3JTZXR0aW5ncy5hZGRQbHVnaW5zKGVkaXRvclNldHRpbmdzLnBsdWdpbnMpXG4gICAgfVxuXG4gICAgZm9yICh2YXIgbyBpbiBpbnRlcmZhY2VzKSB7XG4gICAgICB0aGlzW29dID0gaW50ZXJmYWNlc1tvXVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDrpbwg7IOd7ISxIOuwjyDtiLTsnYQg7LaU6rCA7ZWc64ukLlxuICAgKiBAcGFyYW0ge3N0cmluZ30gc2VsIHNlbGVjdG9yXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBvcHRpb25zXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBlZGl0b3JPcHRpb25zXG4gICAqIEBwYXJhbSB7YXJyYXl9IHRvb2xJbmZvTGlzdFxuICAgKi9cbiAgY3JlYXRlIChzZWwsIG9wdGlvbnMsIGVkaXRvck9wdGlvbnMsIHRvb2xJbmZvTGlzdCkge1xuICAgIHRvb2xJbmZvTGlzdCA9IHRvb2xJbmZvTGlzdCB8fCBbXVxuICAgIGVkaXRvck9wdGlvbnMgPSAkLmV4dGVuZCh0aGlzLmNvbmZpZ3MgfHwge30sIGVkaXRvck9wdGlvbnMgfHwge30pXG5cbiAgICBpZiAoRWRpdG9yVmFsaWRhdGlvbi5pc1ZhbGlkQmVmb3JlQ3JlYXRlSW5zdGFuY2Uoc2VsLCB0b29sSW5mb0xpc3QsIHRoaXMpKSB7XG4gICAgICBjb25zdCBlZGl0b3JJbnRhbmNlID0gbmV3IEVkaXRvckluc3RhbmNlKHRoaXMubmFtZSwgc2VsLCBlZGl0b3JPcHRpb25zLCB0b29sSW5mb0xpc3QpXG4gICAgICBlZGl0b3JJbnRhbmNlLl9lZGl0b3IgPSB0aGlzXG4gICAgICB0aGlzLmVkaXRvckxpc3Rbc2VsXSA9IGVkaXRvckludGFuY2VcbiAgICAgIHRoaXMuaW5pdGlhbGl6ZS5jYWxsKHRoaXMuZWRpdG9yTGlzdFtzZWxdLCBzZWwsIG9wdGlvbnMsIGVkaXRvck9wdGlvbnMpXG5cbiAgICAgIGlmICghIXRvb2xJbmZvTGlzdCAmJiB0b29sSW5mb0xpc3QubGVuZ3RoID4gMCkge1xuICAgICAgICBsZXQgdG9vbHMgPSB7fVxuICAgICAgICBsZXQgdG9vbEluZm9MaXN0RmlsdGVyID0gW11cblxuICAgICAgICBmb3IgKGxldCBpID0gMCwgbWF4ID0gdG9vbEluZm9MaXN0Lmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICAgICAgaWYgKHdpbmRvdy5YRWVkaXRvci5nZXRUb29sKHRvb2xJbmZvTGlzdFtpXS5pZCkpIHtcbiAgICAgICAgICAgIHRvb2xzW3Rvb2xJbmZvTGlzdFtpXS5pZF0gPSB3aW5kb3cuWEVlZGl0b3IuZ2V0VG9vbCh0b29sSW5mb0xpc3RbaV0uaWQpXG4gICAgICAgICAgICB0b29sSW5mb0xpc3RGaWx0ZXIucHVzaCh0b29sSW5mb0xpc3RbaV0pXG4gICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGNvbnNvbGUuZXJyb3IoJ2RlZmluZeuQnCB0b29s7J20IOyhtOyerO2VmOyngCDslYrsnYwuIFsnICsgdG9vbEluZm9MaXN0W2ldLmlkICsgJ10nKVxuICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIGlmICh0aGlzLmFkZFRvb2xzICYmIHR5cGVvZiB0aGlzLmFkZFRvb2xzID09PSAnZnVuY3Rpb24nKSB7XG4gICAgICAgICAgdGhpcy5hZGRUb29scy5jYWxsKHRoaXMuZWRpdG9yTGlzdFtzZWxdLCB0b29scywgdG9vbEluZm9MaXN0RmlsdGVyKVxuICAgICAgICB9XG4gICAgICB9XG5cbiAgICAgIHRoaXMuJCRlbWl0KCdlZGl0b3IuY3JlYXRlZCcsIHRoaXMuZWRpdG9yTGlzdFtzZWxdKVxuICAgICAgcmV0dXJuIHRoaXMuZWRpdG9yTGlzdFtzZWxdXG4gICAgfVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IEVkaXRvckRlZmluZVxuIiwiaW1wb3J0IHsgZXZlbnRpZnkgfSBmcm9tICd4ZS11dGlscycgLy8gQEZJWE1FIGh0dHBzOi8vZ2l0aHViLmNvbS94cHJlc3NlbmdpbmUveHByZXNzZW5naW5lL2lzc3Vlcy83NjVcbmltcG9ydCAkIGZyb20gJ2pxdWVyeSdcblxuLyoqXG4gKiBAY2xhc3NcbiAqL1xuY2xhc3MgRWRpdG9ySW5zdGFuY2Uge1xuICAvKipcbiAgICogQGNvbnN0cnVjdG9yXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBlZGl0b3JOYW1lXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBzZWwgc2VsZWN0b3JcbiAgICogQHBhcmFtIHtvYmplY3R9IGVkaXRvck9wdGlvbnNcbiAgICogQHBhcmFtIHthcnJheX0gdG9vbEluZm9MaXN0IOyXkOuUlO2EsOyXkCDstpTqsIDrkKAgdG9vbCDsoJXrs7Qg66as7Iqk7Yq4XG4gICAqL1xuICBjb25zdHJ1Y3RvciAoZWRpdG9yTmFtZSwgc2VsLCBlZGl0b3JPcHRpb25zLCB0b29sSW5mb0xpc3QpIHtcbiAgICAvKiogQHByaXZhdGUgKi9cbiAgICBsZXQgX29wdGlvbnMgPSB7XG4gICAgICBlZGl0b3JPcHRpb25zOiBlZGl0b3JPcHRpb25zLFxuICAgICAgdG9vbEluZm9MaXN0OiB0b29sSW5mb0xpc3RcbiAgICB9XG5cbiAgICBldmVudGlmeSh0aGlzKVxuXG4gICAgLyoqIEBwdWJsaWMgKi9cbiAgICB0aGlzLmVkaXRvck5hbWUgPSBlZGl0b3JOYW1lXG4gICAgLyoqIEBwdWJsaWMgKi9cbiAgICB0aGlzLnNlbGVjdG9yID0gc2VsXG4gICAgLyoqIEBwdWJsaWMgKi9cbiAgICB0aGlzLnByb3BzID0ge31cbiAgICAvKipcbiAgICAgKiDsl5DrlJTthLAg7Ji17IWY7J2EIOuwmO2ZmO2VnOuLpC5cbiAgICAgKiBAcHVibGljXG4gICAgICogQG1ldGhvZFxuICAgICAqL1xuICAgIHRoaXMuZ2V0T3B0aW9ucyA9IGZ1bmN0aW9uICgpIHtcbiAgICAgIHJldHVybiBfb3B0aW9uc1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDsg53shLHrkJwgaW5zdGFuY2Xrpbwg67CY7ZmY7ZWc64ukSW5zdGFuY2VPYmouXG4gICAqIEBtZXRob2RcbiAgICogQHJldHVybiB7b2JqZWN0fVxuICAgKi9cbiAgZ2V0SW5zdGFuY2UgKCkge1xuICAgIHJldHVybiB0aGlzXG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw7JeQIOyekeyEseuQnCDsu6jthZDsuKDrpbwg67CY7ZmY7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEByZXR1cm4ge3N0cmluZ31cbiAgICovXG4gIGdldENvbnRlbnRzICgpIHtcbiAgICByZXR1cm4gWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0uZ2V0Q29udGVudHMuY2FsbCh0aGlzKVxuICB9XG5cbiAgLyoqXG4gICAqIOyXkOuUlO2EsOyXkCDrgrTsmqnsnYQg7J6F66Cl7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB0ZXh0XG4gICAqL1xuICBzZXRDb250ZW50cyAodGV4dCkge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLnNldENvbnRlbnRzLmNhbGwodGhpcywgdGV4dClcbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDsl5Ag64K07Jqp7J2EIOyeheugpe2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge3N0cmluZ30gdGV4dFxuICAgKi9cbiAgYWRkQ29udGVudHMgKHRleHQpIHtcbiAgICBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5hZGRDb250ZW50cy5jYWxsKHRoaXMsIHRleHQpXG4gIH1cblxuICAvKipcbiAgICog7IOd7ISx65CcIGluc3RhbmNl7JeQIHByb3BlcnR566W8IOuTseuhne2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge29iamVjdH0gb2JqXG4gICAqL1xuICBhZGRQcm9wcyAob2JqKSB7XG4gICAgZm9yICh2YXIgbyBpbiBvYmopIHtcbiAgICAgIHRoaXMucHJvcHNbb10gPSBvYmpbb11cbiAgICB9XG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw7JeQIO2ItOydhCDstpTqsIDtlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHthcnJheX0gdG9vbEluc3RhbmNlTGlzdFxuICAgKi9cbiAgYWRkVG9vbHMgKHRvb2xJbnN0YW5jZUxpc3QpIHtcbiAgICBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5hZGRUb29scy5jYWxsKHRoaXMsIHRoaXMuZ2V0T3B0aW9ucygpLnRvb2xJbmZvTGlzdCwgdG9vbEluc3RhbmNlTGlzdClcbiAgfVxuXG4gIC8qKlxuICAgKiDqtaztmITrkJwg7JeQ65SU7YSw7JeQIOydtOuypO2KuOulvCDtlaDri7ntlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHtzdHJpbmd9IGV2ZW50TmFtZVxuICAgKiBAcGFyYW0ge2Z1bmN0aW9ufSBjYWxsYmFjayBldmVudCBjYWxsYmFja1xuICAgKi9cbiAgb24gKGV2ZW50TmFtZSwgY2FsbGJhY2spIHtcbiAgICBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5vbi5jYWxsKHRoaXMsIGV2ZW50TmFtZSwgY2FsbGJhY2spXG4gIH1cblxuICAvKipcbiAgICog6rWs7ZiE65CcIOyXkOuUlO2EsCDtjIzsnbwg7JeF66Gc65OcIOq4sOuKpeydhCDtmLjstqPtlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHtvYmplY3R9IGN1c3RvbU9wdGlvbnNcbiAgICovXG4gIHJlbmRlckZpbGVVcGxvYWRlciAoY3VzdG9tT3B0aW9ucykge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLnJlbmRlckZpbGVVcGxvYWRlci5jYWxsKHRoaXMsIGN1c3RvbU9wdGlvbnMpXG4gIH1cblxuICBnZXRDb250ZW50RG9tICgpIHtcbiAgICBpZiAodHlwZW9mIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLmdldENvbnRlbnREb20gPT09ICdmdW5jdGlvbicpIHtcbiAgICAgIHJldHVybiBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5nZXRDb250ZW50RG9tLmNhbGwodGhpcylcbiAgICB9XG4gICAgcmV0dXJuIGZhbHNlXG4gIH1cblxuICAvKipcbiAgICog6rWs7ZiE65CcIOyXkOuUlO2EsCByZXNldCDtlajsiJjrpbwg7Zi47Lac7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBjdXN0b21PcHRpb25zXG4gICAqL1xuICByZXNldCAoKSB7XG4gICAgWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0ucmVzZXQuY2FsbCh0aGlzKVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IEVkaXRvckluc3RhbmNlXG4iLCIvKipcbiAqIEBjbGFzc1xuICovXG5jbGFzcyBFZGl0b3JUb29sIHtcbiAgY29uc3RydWN0b3IgKG9iaikge1xuICAgIGZvciAobGV0IG8gaW4gb2JqKSB7XG4gICAgICB0aGlzW29dID0gb2JqW29dXG4gICAgfVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IEVkaXRvclRvb2xcbiIsImltcG9ydCB7IEVkaXRvckRlZmluZUVycm9yLCBFZGl0b3JUb29sRGVmaW5lRXJyb3IsIEVkaXRvclVzZWRDb250YWluZXIsIEVkaXRvclVuZGVmaW5lZENvbnRhaW5lciB9IGZyb20gJy4vZXJyb3JzL2VkaXRvci5lcnJvcidcblxuLyoqXG4gKiBAcHJpdmF0ZVxuICovXG5jb25zdCByZXF1aXJlT3B0aW9ucyA9IHtcbiAgZWRpdG9yU2V0dGluZ3M6IFtcbiAgICAnbmFtZSdcbiAgXSxcbiAgaW50ZXJmYWNlczogW1xuICAgICdpbml0aWFsaXplJyxcbiAgICAnYWRkQ29udGVudHMnLFxuICAgICdnZXRDb250ZW50cycsXG4gICAgJ3NldENvbnRlbnRzJyxcbiAgICAnZ2V0Q29udGVudERvbSdcbiAgXSxcbiAgdG9vbHM6IHtcbiAgICBwcm9wZXJ0eTogW1xuICAgICAgJ2lkJyxcbiAgICAgICdldmVudHMnXG4gICAgXSxcbiAgICBldmVudHM6IFtcbiAgICAgICdpY29uQ2xpY2snLFxuICAgICAgJ2VsZW1lbnREb3VibGVDbGljaydcbiAgICBdXG4gIH1cbn1cblxuLyoqXG4gKiBAY2xhc3NcbiAqL1xuY2xhc3MgRWRpdG9yVmFsaWRhdGlvbiB7XG4gIC8qKlxuICAgKiBFZGl0b3LsnZggaW5zdGFuY2Xrpbwg7IOd7ISx7ZWY6riwIOyghCDspJHrs7Ug6rKA7IKsIOuTsSDsiJjtlolcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbCBqUXVlcnkgc2VsZWN0b3JcbiAgICogQHBhcmFtIHthcnJheX0gdG9vbElkTGlzdFxuICAgKiBAcGFyYW0ge29iamVjdH0gZWRpdG9yUGFyZW50XG4gICAqIEByZXR1cm4ge2Jvb2xlYW59XG4gICAqIEB0aHJvd3Mge0VkaXRvclVuZGVmaW5lZENvbnRhaW5lcn1cbiAgICogQHRocm93cyB7RWRpdG9yVXNlZENvbnRhaW5lcn1cbiAgICovXG4gIHN0YXRpYyBpc1ZhbGlkQmVmb3JlQ3JlYXRlSW5zdGFuY2UgKHNlbCwgdG9vbElkTGlzdCwgZWRpdG9yUGFyZW50KSB7XG4gICAgaWYgKCFzZWwpIHtcbiAgICAgIC8vIHNlbGVjdG9y6rCAIOyXhuydjFxuICAgICAgdGhyb3cgbmV3IEVkaXRvclVuZGVmaW5lZENvbnRhaW5lcignRWRpdG9y6rCAIOyCrOyaqe2VoCBmaWVsZOulvCDsp4DsoJXtlbTslbwg7ZWp64uI64ukLicpXG4gICAgfVxuXG4gICAgaWYgKGVkaXRvclBhcmVudC5lZGl0b3JMaXN0Lmxlbmd0aCA+IDApIHtcbiAgICAgIGxldCBzZWxWYWxpZCA9IHRydWVcbiAgICAgIGZvciAobGV0IGkgPSAwLCBtYXggPSBlZGl0b3JQYXJlbnQuZWRpdG9yTGlzdC5sZW5ndGg7IGkgPCBtYXg7IGkgKz0gMSkge1xuICAgICAgICBpZiAoZWRpdG9yUGFyZW50LmVkaXRvckxpc3RbaV0gPT09IHNlbCkge1xuICAgICAgICAgIHNlbFZhbGlkID0gZmFsc2VcbiAgICAgICAgICB0aHJvdyBuZXcgRWRpdG9yVXNlZENvbnRhaW5lcihgRWRpdG9y6rCAIOydtOuvuCDsgqzsmqkg7KSR7J6F64uI64ukOiAke3NlbH1gKVxuICAgICAgICB9XG4gICAgICB9XG5cbiAgICAgIGlmICghc2VsVmFsaWQpIHtcbiAgICAgICAgcmV0dXJuIGZhbHNlXG4gICAgICB9XG4gICAgfVxuXG4gICAgcmV0dXJuIHRydWVcbiAgfVxuXG4gIC8qKlxuICAgKiBAdHlwZWRlZiB7T2JqZWN0fSBlZGl0b3JEZWZpbml0aW9uXG4gICAqIEBwcm9wZXJ0eSB7b2JqZWN0fSBlZGl0b3JEZWZpbml0aW9uLmVkaXRvclNldHRpbmdzIOyXkOuUlO2EsCDshKTsoJUg7KCV67O0XG4gICAqIEBwcm9wZXJ0eSB7c3RyaW5nfSBlZGl0b3JEZWZpbml0aW9uLmVkaXRvclNldHRpbmdzLm5hbWUg7JeQ65SU7YSwIOyEpOyglSDsoJXrs7RcbiAgICogQHByb3BlcnR5IHtvYmplY3R9IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcyDqtaztmITrkJwg7JeQ65SU7YSwIOyduO2EsO2OmOydtOyKpFxuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXMuaW5pdGlhbGl6ZVxuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXMuYWRkQ29udGVudHNcbiAgICogQHByb3BlcnR5IHtmdW5jdGlvbn0gZWRpdG9yRGVmaW5pdGlvbi5pbnRlcmZhY2VzLmdldENvbnRlbnRzXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcy5zZXRDb250ZW50c1xuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXMuZ2V0Q29udGVudERvbVxuICAgKi9cblxuICAvKipcbiAgICogRWRpdG9yIOygleydmOqwgCDsmKzrsJTrpbjsp4Ag6rKA7IKsXG4gICAqIEBwYXJhbSB7ZWRpdG9yRGVmaW5pdGlvbi5lZGl0b3JTZXR0aW5nc30gZWRpdG9yU2V0dGluZ3NcbiAgICogQHBhcmFtIHtlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXN9IGludGVyZmFjZXNcbiAgICogQHJldHVybiB7Ym9vbGVhbn1cbiAgICogQHRocm93cyB7RWRpdG9yRGVmaW5lRXJyb3J9XG4gICAqL1xuICBzdGF0aWMgaXNWYWxpZEVkaXRvck9wdGlvbnMgKGVkaXRvclNldHRpbmdzLCBpbnRlcmZhY2VzKSB7XG4gICAgbGV0IHZhbGlkID0gdHJ1ZVxuICAgIGZvciAobGV0IGVTZXR0aW5ncyBpbiByZXF1aXJlT3B0aW9ucy5lZGl0b3JTZXR0aW5ncykge1xuICAgICAgaWYgKCFlZGl0b3JTZXR0aW5ncy5oYXNPd25Qcm9wZXJ0eShyZXF1aXJlT3B0aW9ucy5lZGl0b3JTZXR0aW5nc1tlU2V0dGluZ3NdKSkge1xuICAgICAgICB2YWxpZCA9IGZhbHNlXG4gICAgICAgIHRocm93IG5ldyBFZGl0b3JEZWZpbmVFcnJvcihgRWRpdG9yIOq3nOqyqeydtCDrp57sp4Ag7JWK7J2MICjqtaztmIQg7ZWE7JqUIFtlZGl0b3JTZXR0aW5nczogJHtyZXF1aXJlT3B0aW9ucy5lZGl0b3JTZXR0aW5nc1tlU2V0dGluZ3NdfV0pYClcbiAgICAgIH1cbiAgICB9XG5cbiAgICBmb3IgKGxldCBlSW50ZXJmYWNlIGluIHJlcXVpcmVPcHRpb25zLmludGVyZmFjZXMpIHtcbiAgICAgIGlmICghaW50ZXJmYWNlcy5oYXNPd25Qcm9wZXJ0eShyZXF1aXJlT3B0aW9ucy5pbnRlcmZhY2VzW2VJbnRlcmZhY2VdKSkge1xuICAgICAgICB2YWxpZCA9IGZhbHNlXG4gICAgICAgIHRocm93IG5ldyBFZGl0b3JEZWZpbmVFcnJvcihgRWRpdG9yIOq3nOqyqeydtCDrp57sp4Ag7JWK7J2MICjqtaztmIQg7ZWE7JqUIFtpbnRlcmZhY2U6ICR7cmVxdWlyZU9wdGlvbnMuaW50ZXJmYWNlc1tlSW50ZXJmYWNlXX1dKWApXG4gICAgICB9XG4gICAgfVxuXG4gICAgaWYgKGVkaXRvclNldHRpbmdzLmhhc093blByb3BlcnR5KCdwbHVnaW5zJykgJiZcbiAgICAgIGVkaXRvclNldHRpbmdzLnBsdWdpbnMgaW5zdGFuY2VvZiBBcnJheSAmJlxuICAgICAgZWRpdG9yU2V0dGluZ3MucGx1Z2lucy5sZW5ndGggPiAwICYmXG4gICAgICAhZWRpdG9yU2V0dGluZ3MuaGFzT3duUHJvcGVydHkoJ2FkZFBsdWdpbnMnKSkge1xuICAgICAgdmFsaWQgPSBmYWxzZVxuICAgICAgdGhyb3cgbmV3IEVkaXRvckRlZmluZUVycm9yKGBFZGl0b3Ig6rec6rKp7J20IOunnuyngCDslYrsnYwgKOq1rO2YhCDtlYTsmpQgW2ZuOmFkZFBsdWdpbnNdKWApXG4gICAgfVxuXG4gICAgaWYgKHdpbmRvdy5YRWVkaXRvci5lZGl0b3JTZXQuaGFzT3duUHJvcGVydHkoZWRpdG9yU2V0dGluZ3MubmFtZSkpIHtcbiAgICAgIHZhbGlkID0gZmFsc2VcbiAgICAgIHRocm93IG5ldyBFZGl0b3JEZWZpbmVFcnJvcihg7J2066+4IOqwmeydgCDsnbTrpoTsnZgg7JeQ65SU7YSw6rCAIOuTseuhneuQmOyWtCDsnojsnYw6ICR7ZWRpdG9yU2V0dGluZ3MubmFtZX1gKVxuICAgIH1cblxuICAgIHJldHVybiAhKCF2YWxpZClcbiAgfVxuXG4gIC8qKlxuICAgKiBAdHlwZWRlZiB7T2JqZWN0fSBlZGl0b3JUb29sRGVmaW5pdGlvblxuICAgKiBAcHJvcGVydHkge3N0cmluZ30gaWRcbiAgICogQHByb3BlcnR5IHtvYmplY3R9IGV2ZW50c1xuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBldmVudHMuaWNvbkNsaWNrXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGV2ZW50cy5lbGVtZW50RG91YmxlQ2xpY2tcbiAgICogQGRlcHJlY2F0ZWRcbiAgICovXG5cbiAgLyoqXG4gICAqIEVkaXRvclRvb2wg7KCV7J2Y6rCAIOyYrOuwlOuluOyngCDqsoDsgqxcbiAgICogQHBhcmFtIHtlZGl0b3JUb29sRGVmaW5pdGlvbn0gdG9vbERlZmluZVxuICAgKiBAcmV0dXJuIHtib29sZWFufVxuICAgKiBAdGhyb3dzIHtFZGl0b3JUb29sRGVmaW5lRXJyb3J9XG4gICAqL1xuICBzdGF0aWMgaXNWYWxpZFRvb2xzT2JqZWN0ICh0b29sRGVmaW5lKSB7XG4gICAgbGV0IHZhbGlkID0gdHJ1ZVxuXG4gICAgZm9yIChsZXQgaSA9IDAsIG1heCA9IHJlcXVpcmVPcHRpb25zLnRvb2xzLnByb3BlcnR5Lmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICBpZiAoIXRvb2xEZWZpbmUuaGFzT3duUHJvcGVydHkocmVxdWlyZU9wdGlvbnMudG9vbHMucHJvcGVydHlbaV0pKSB7XG4gICAgICAgIHZhbGlkID0gZmFsc2VcbiAgICAgICAgdGhyb3cgbmV3IEVkaXRvclRvb2xEZWZpbmVFcnJvcihgRWRpdG9yVG9vbCDqt5zqsqnsnbQg66ee7KeAIOyViuydjCAo7IaN7ISx7J20IOyXhuydjDogJHtyZXF1aXJlT3B0aW9ucy50b29scy5wcm9wZXJ0eVtpXX0pYClcbiAgICAgIH1cbiAgICB9XG5cbiAgICBmb3IgKGxldCBpID0gMCwgbWF4ID0gcmVxdWlyZU9wdGlvbnMudG9vbHMuZXZlbnRzLmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICBpZiAoIXRvb2xEZWZpbmUuZXZlbnRzLmhhc093blByb3BlcnR5KHJlcXVpcmVPcHRpb25zLnRvb2xzLmV2ZW50c1tpXSkpIHtcbiAgICAgICAgdmFsaWQgPSBmYWxzZVxuICAgICAgICB0aHJvdyBuZXcgRWRpdG9yVG9vbERlZmluZUVycm9yKGBFZGl0b3JUb29sIOq3nOqyqeydtCDrp57sp4Ag7JWK7J2MICjsnbTrsqTtirjqsIAg7KCV7J2Y65CY7KeAIOyViuydjDogJHtyZXF1aXJlT3B0aW9ucy50b29scy5ldmVudHNbaV19KWApXG4gICAgICB9XG4gICAgfVxuXG4gICAgcmV0dXJuIHZhbGlkXG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9yVmFsaWRhdGlvblxuXG5leHBvcnQge1xuICByZXF1aXJlT3B0aW9uc1xufVxuIiwiaW1wb3J0IFhlRXJyb3IgZnJvbSAneGUvZXJyb3InXG5cbi8qKlxuICogQG1vZHVsZSBYZUVycm9yL0VkaXRvckRlZmluZUVycm9yXG4gKiBAZXh0ZW5kcyBYZUVycm9yXG4gKi9cbmNsYXNzIEVkaXRvckRlZmluZUVycm9yIGV4dGVuZHMgWGVFcnJvciB7XG4gIGNvbnN0cnVjdG9yIChtZXNzYWdlKSB7XG4gICAgc3VwZXIobWVzc2FnZSlcbiAgfVxufVxuXG4vKipcbiAqIEBtb2R1bGUgWGVFcnJvci9FZGl0b3JUb29sRGVmaW5lRXJyb3JcbiAqIEBleHRlbmRzIFhlRXJyb3JcbiAqL1xuY2xhc3MgRWRpdG9yVG9vbERlZmluZUVycm9yIGV4dGVuZHMgWGVFcnJvciB7XG4gIGNvbnN0cnVjdG9yIChtZXNzYWdlKSB7XG4gICAgc3VwZXIobWVzc2FnZSlcbiAgfVxufVxuXG4vKipcbiAqIEBtb2R1bGUgWGVFcnJvci9FZGl0b3JVc2VkQ29udGFpbmVyXG4gKiBAZXh0ZW5kcyBYZUVycm9yXG4gKi9cbmNsYXNzIEVkaXRvclVzZWRDb250YWluZXIgZXh0ZW5kcyBYZUVycm9yIHtcbiAgY29uc3RydWN0b3IgKG1lc3NhZ2UpIHtcbiAgICBzdXBlcihtZXNzYWdlKVxuICB9XG59XG5cbi8qKlxuICogQG1vZHVsZSBYZUVycm9yL0VkaXRvclVuZGVmaW5lZENvbnRhaW5lclxuICogQGV4dGVuZHMgWGVFcnJvclxuICovXG5jbGFzcyBFZGl0b3JVbmRlZmluZWRDb250YWluZXIgZXh0ZW5kcyBYZUVycm9yIHtcbiAgY29uc3RydWN0b3IgKG1lc3NhZ2UpIHtcbiAgICBzdXBlcihtZXNzYWdlKVxuICB9XG59XG5cbmV4cG9ydCB7XG4gIEVkaXRvckRlZmluZUVycm9yLFxuICBFZGl0b3JUb29sRGVmaW5lRXJyb3IsXG4gIEVkaXRvclVzZWRDb250YWluZXIsXG4gIEVkaXRvclVuZGVmaW5lZENvbnRhaW5lclxufVxuIiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IEFwcCBmcm9tICd4ZS9hcHAnXG5pbXBvcnQgRWRpdG9yRGVmaW5lIGZyb20gJy4vZWRpdG9yRGVmaW5lJ1xuaW1wb3J0IEVkaXRvclZhbGlkYXRpb24gZnJvbSAnLi9lZGl0b3JWYWxpZGF0aW9uJ1xuaW1wb3J0IEVkaXRvclRvb2wgZnJvbSAnLi9lZGl0b3JUb29sJ1xuaW1wb3J0IFhFIGZyb20gJ3hlJ1xuXG4vKipcbiAqIEBjbGFzc1xuICogQGV4dGVuZHMgQXBwXG4gKi9cbmNsYXNzIEVkaXRvciBleHRlbmRzIEFwcCB7XG4gIGNvbnN0cnVjdG9yICgpIHtcbiAgICBzdXBlcigpXG5cbiAgICB0aGlzLnRvb2xzU2V0ID0ge31cbiAgICB0aGlzLmVkaXRvclNldCA9IHt9XG4gICAgdGhpcy5lZGl0b3JPcHRpb25TZXQgPSB7fVxuXG4gICAgLyoqXG4gICAgICogQERFUFJFQ0FURURcbiAgICAgKiovXG4gICAgdGhpcy50b29scyA9IHtcbiAgICAgIGRlZmluZTogb2JqID0+IHtcbiAgICAgICAgaWYgKCQuaXNGdW5jdGlvbihjb25zb2xlLndhcm4pICYmICQuaXNGdW5jdGlvbihjb25zb2xlLnRyYWNlKSkge1xuICAgICAgICAgIGNvbnNvbGUud2FybignREVQUkVDQVRFRDogWEVlZGl0b3IudG9vbHMuZGVmaW5lKCkgaXMgZGVwcmVjYXRlZC4gdXNlIFhFZWRpdG9yLmRlZmluZVRvb2wnKVxuICAgICAgICAgIGNvbnNvbGUudHJhY2UoKVxuICAgICAgICB9XG4gICAgICAgIHRoaXMuZGVmaW5lVG9vbChvYmopXG4gICAgICB9LFxuICAgICAgZ2V0OiBpZCA9PiB7XG4gICAgICAgIGlmICgkLmlzRnVuY3Rpb24oY29uc29sZS53YXJuKSAmJiAkLmlzRnVuY3Rpb24oY29uc29sZS50cmFjZSkpIHtcbiAgICAgICAgICBjb25zb2xlLndhcm4oJ0RFUFJFQ0FURUQ6IFhFZWRpdG9yLnRvb2xzLmdldCgpIGlzIGRlcHJlY2F0ZWQuIHVzZSBYRWVkaXRvci5nZXRUb29sJylcbiAgICAgICAgICBjb25zb2xlLnRyYWNlKClcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gdGhpcy5nZXRUb29sKGlkKVxuICAgICAgfVxuICAgIH1cbiAgfVxuXG4gIHN0YXRpYyBhcHBOYW1lICgpIHtcbiAgICByZXR1cm4gJ0VkaXRvcidcbiAgfVxuXG4gIGJvb3QgKFhFKSB7XG4gICAgaWYgKHRoaXMuYm9vdGVkKCkpIHtcbiAgICAgIHJldHVybiBQcm9taXNlLnJlc29sdmUodGhpcylcbiAgICB9XG5cbiAgICByZXR1cm4gbmV3IFByb21pc2UoKHJlc29sdmUpID0+IHtcbiAgICAgIHN1cGVyLmJvb3QoWEUpXG5cbiAgICAgIHJlc29sdmUodGhpcylcbiAgICB9KVxuICB9XG5cbiAgLyoqXG4gICAqIOyXkOuUlO2EsOulvCDsoJXsnZjtlZzri6QuXG4gICAqIEBwcm9wZXJ0eSB7ZWRpdG9yRGVmaW5pdGlvbn0gb2JqXG4gICAqKi9cbiAgZGVmaW5lIChvYmopIHtcbiAgICBjb25zdCBlZGl0b3JTZXR0aW5ncyA9IG9iai5lZGl0b3JTZXR0aW5nc1xuICAgIGNvbnN0IGludGVyZmFjZXMgPSBvYmouaW50ZXJmYWNlc1xuXG4gICAgdHJ5IHtcbiAgICAgIGlmIChFZGl0b3JWYWxpZGF0aW9uLmlzVmFsaWRFZGl0b3JPcHRpb25zKGVkaXRvclNldHRpbmdzLCBpbnRlcmZhY2VzKSkge1xuICAgICAgICBjb25zdCBlZGl0b3IgPSBuZXcgRWRpdG9yRGVmaW5lKGVkaXRvclNldHRpbmdzLCBpbnRlcmZhY2VzKVxuICAgICAgICB0aGlzLmVkaXRvclNldFtlZGl0b3JTZXR0aW5ncy5uYW1lXSA9IGVkaXRvclxuICAgICAgICB0aGlzLmVkaXRvck9wdGlvblNldFtlZGl0b3JTZXR0aW5ncy5uYW1lXSA9IGVkaXRvclNldHRpbmdzXG4gICAgICAgIHRoaXMuJCRlbWl0KCdlZGl0b3IuZGVmaW5lJywgZWRpdG9yKVxuICAgICAgfVxuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIC8vIGNvbnNvbGUuZXJyb3IoZSlcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw66W8IOuwmO2ZmO2VnOuLpC5cbiAgICogQHBhcmFtIHtzdHJpbmd9IG5hbWVcbiAgICogQHJldHVybiB7UHJvbWlzZX1cbiAgICoqL1xuICBnZXRFZGl0b3IgKG5hbWUpIHtcbiAgICBpZiAodGhpcy5lZGl0b3JTZXRbbmFtZV0pIHtcbiAgICAgIHJldHVybiBQcm9taXNlLnJlc29sdmUodGhpcy5lZGl0b3JTZXRbbmFtZV0pXG4gICAgfVxuXG4gICAgcmV0dXJuIG5ldyBQcm9taXNlKChyZXNvbHZlKSA9PiB7XG4gICAgICB0aGlzLiQkb24oJ2VkaXRvci5kZWZpbmUnLCAoZXZlbnROYW1lLCBlZGl0b3IpID0+IHtcbiAgICAgICAgcmVzb2x2ZShlZGl0b3IpXG4gICAgICB9KVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICogRWRpdG9yVG9vbCDsoJXsnZhcbiAgICpcbiAgICogQHBhcmFtIHtlZGl0b3JUb29sRGVmaW5pdGlvbn0gb2JqXG4gICAqL1xuICBkZWZpbmVUb29sIChvYmopIHtcbiAgICB0cnkge1xuICAgICAgaWYgKEVkaXRvclZhbGlkYXRpb24uaXNWYWxpZFRvb2xzT2JqZWN0KG9iaikpIHtcbiAgICAgICAgdGhpcy50b29sc1NldFtvYmouaWRdID0gbmV3IEVkaXRvclRvb2wob2JqKVxuICAgICAgfVxuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIGNvbnNvbGUuZXJyb3IoZSlcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogRWRpdG9yVG9vbCDrsJjtmZhcbiAgICpcbiAgICogQHBhcmFtIHtzdHJpbmd9IGlkXG4gICAqIEByZXR1cm4ge0VkaXRvclRvb2x9XG4gICAqL1xuICBnZXRUb29sIChpZCkge1xuICAgIHJldHVybiB0aGlzLnRvb2xzU2V0W2lkXVxuICB9XG5cbiAgLyoqXG4gICAqIOy7qO2FkOy4oOyXkCB0b29sIGlk66W8IHhlLXRvb2wtaWQgYXR0cmlidXRl7JeQIO2VoOuLue2VmOyXrCDrsJjtmZjtlZzri6QuXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBjb250ZW50XG4gICAqIEBwYXJhbSB7c3RyaW5nfSBpZFxuICAgKiBAcmV0dXJuIHtzdHJpbmd9IEhUTUwgbWFya3VwIHN0cmluZ1xuICAgKiovXG4gIGF0dGFjaERvbUlkIChjb250ZW50LCBpZCkge1xuICAgIHJldHVybiAkKGNvbnRlbnQpLmF0dHIoJ3hlLXRvb2wtaWQnLCBpZCkuY2xvbmUoKS53cmFwQWxsKCc8ZGl2Lz4nKS5wYXJlbnQoKS5odG1sKClcbiAgfVxuXG4gIC8qKlxuICAgKiBAREVQUkVDQVRFRFxuICAgKiBAcGFyYW0ge3N0cmluZ30gaWRcbiAgICogQHJldHVybiB7c3RyaW5nfSBIVE1MIHNlbGVjdG9yIHN0cmluZ1xuICAgKiovXG4gIGdldERvbVNlbGVjdG9yIChpZCkge1xuICAgIHJldHVybiAnW3hlLXRvb2wtaWQ9XCInICsgaWQgKyAnXCJdJ1xuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IEVkaXRvclxuXG4vKipcbiAqIEB0eXBlICAgICAgIHtFZGl0b3J9XG4gKi9cbmNvbnN0IFhFZWRpdG9yID0gbmV3IEVkaXRvcigpXG5pZiAoIXdpbmRvdy5YRWVkaXRvcikgd2luZG93LlhFZWRpdG9yID0gWEVlZGl0b3JcblhFLnJlZ2lzdGVyQXBwKCdFZGl0b3InLCBYRWVkaXRvcilcbiIsImltcG9ydCAkIGZyb20gJ2pxdWVyeSdcbmltcG9ydCBYRSBmcm9tICd4ZSdcblxuWEUuYXBwKCdFZGl0b3InLCAoRWRpdG9yKSA9PiB7XG4gIEVkaXRvci5kZWZpbmUoe1xuICAgIGVkaXRvclNldHRpbmdzOiB7XG4gICAgICBuYW1lOiAnWEV0ZXh0YXJlYScsXG4gICAgICBjb25maWdzOiB7fVxuICAgIH0sXG4gICAgLyoqXG4gICAgICogQHByb3Age29iamVjdH0gaW50ZXJmYWNlc1xuICAgICAqIEBwcm9wIHtmdW5jdGlvbihzZWxlY3RvcixvcHRpb25zKX0gaW50ZXJmYWNlcy5pbml0aWFsaXplXG4gICAgICogPHByZT5cbiAgICAgKiAgIGFyZ3VtZW50c1xuICAgICAqICAgLSBzZWxlY3RvciA6IHN0cmluZ1xuICAgICAqICAgLSBvcHRpb25zIDogb2JqZWN0XG4gICAgICogPC9wcmU+XG4gICAgICogQHByb3Age2Z1bmN0aW9ufSBpbnRlcmZhY2VzLmdldENvbnRlbnRzIOyXkOuUlO2EsCDsu6jthZDsuKDrpbwg66as7YS07ZWc64ukLlxuICAgICAqIEBwcm9wIHtmdW5jdGlvbn0gaW50ZXJmYWNlcy5zZXRDb250ZW50cyDsl5DrlJTthLDsl5Ag7Luo7YWQ7Lig66W8IOuNruyWtOyTtOuLpC5cbiAgICAgKiA8cHJlPlxuICAgICAqICAgYXJndW1lbnRzXG4gICAgICogICAtIHRleHQgOiBzdHJpbmdcbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcHJvcCB7ZnVuY3Rpb259IGludGVyZmFjZXMuYWRkQ29udGVudHMg7JeQ65SU7YSw7JeQIOy7qO2FkOy4oOulvCDstpTqsIDtlZzri6QuXG4gICAgICogPHByZT5cbiAgICAgKiAgIGFyZ3VtZW50c1xuICAgICAqICAgLSB0ZXh0IDogc3RyaW5nXG4gICAgICogPC9wcmU+XG4gICAgICogQHByb3Age2Z1bmN0aW9ufSBpbnRlcmZhY2VzLm9uIOyXkOuUlO2EsOyXkCDsnbTrsqTtirgg7ZW465Ok65+s66W8IOy2lOqwgO2VnOuLpC5cbiAgICAgKiA8cHJlPlxuICAgICAqICAgYXJndW1lbnRzXG4gICAgICogICAtIGV2ZW50TmFtZSA6IHN0cmluZ1xuICAgICAqICAgLSBjYWxsYmFjayA6IGZ1bmN0aW9uXG4gICAgICogPC9wcmU+XG4gICAgICogQHByb3Age2Z1bmN0aW9ufSBpbnRlcmZhY2VzLnJlc2V0IOyXkOuUlO2EsCDsu6jthZDsuKDrpbwg7LSI6riw7ZmU7ZWc64ukLlxuICAgICAqL1xuICAgIGludGVyZmFjZXM6IHtcbiAgICAgIGluaXRpYWxpemU6IGZ1bmN0aW9uIChzZWxlY3Rvciwgb3B0aW9ucykge1xuICAgICAgICBvcHRpb25zID0gJC5leHRlbmQodHJ1ZSwge1xuICAgICAgICAgIGZpbGVVcGxvYWQ6IHt9LFxuICAgICAgICAgIHN1Z2dlc3Rpb246IHt9LFxuICAgICAgICAgIG5hbWVzOiB7XG4gICAgICAgICAgICBmaWxlOiB7XG4gICAgICAgICAgICAgIGltYWdlOiB7fVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIHRhZzoge30sXG4gICAgICAgICAgICBtZW50aW9uOiB7fVxuICAgICAgICAgIH0sXG4gICAgICAgICAgZXh0ZW5zaW9uczogW10sXG4gICAgICAgICAgZm9udEZhbWlseTogW10sXG4gICAgICAgICAgcGVybXM6IHt9LFxuICAgICAgICAgIGZpbGVzOiBbXVxuICAgICAgICB9LCBvcHRpb25zKVxuXG4gICAgICAgIGxldCAkZWRpdG9yID0gJCgnIycgKyBzZWxlY3RvcilcbiAgICAgICAgbGV0IGhlaWdodCA9IG9wdGlvbnMuaGVpZ2h0XG4gICAgICAgIGxldCBmb250RmFtaWx5ID0gb3B0aW9ucy5mb250RmFtaWx5XG4gICAgICAgIGxldCBmb250U2l6ZSA9IG9wdGlvbnMuZm9udFNpemVcblxuICAgICAgICB0aGlzLmFkZFByb3BzKHtcbiAgICAgICAgICBlZGl0b3I6ICRlZGl0b3IsIHNlbGVjdG9yOiBzZWxlY3Rvciwgb3B0aW9uczogb3B0aW9uc1xuICAgICAgICB9KVxuXG4gICAgICAgIGlmIChoZWlnaHQpIHtcbiAgICAgICAgICAkZWRpdG9yLmNzcygnaGVpZ2h0JywgaGVpZ2h0ICsgJ3B4JylcbiAgICAgICAgfVxuXG4gICAgICAgIGlmIChmb250RmFtaWx5IHx8IGZvbnRTaXplKSB7XG4gICAgICAgICAgaWYgKGZvbnRGYW1pbHkgJiYgZm9udEZhbWlseS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAkZWRpdG9yLmNzcygnZm9udC1mYW1pbHknLCBmb250RmFtaWx5LmpvaW4oJywnKSlcbiAgICAgICAgICB9XG5cbiAgICAgICAgICBpZiAoZm9udFNpemUpIHtcbiAgICAgICAgICAgICRlZGl0b3IuY3NzKCdmb250LXNpemUnLCBmb250U2l6ZSlcbiAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICAkZWRpdG9yLnBhcmVudHMoJ2Zvcm0nKS5vbignc3VibWl0JywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgIGxldCBmaWxlSW5wdXQgPSBvcHRpb25zLm5hbWVzLmZpbGUuaW5wdXRcbiAgICAgICAgICBsZXQgZmlsZXMgPSBvcHRpb25zLmZpbGVzXG4gICAgICAgICAgbGV0ICRwYXJhbVdyYXAgPSAkKClcblxuICAgICAgICAgIC8vIGZpbGVzIGlucHV07IKt7KCcIO2bhCDsg53shLFcbiAgICAgICAgICAkZWRpdG9yLm5leHRBbGwoJy5wYXJhbVdyYXAnKS5yZW1vdmUoKVxuICAgICAgICAgICRlZGl0b3IuYWZ0ZXIoXCI8ZGl2IGNsYXNzPSdwYXJhbVdyYXAnPlwiKVxuICAgICAgICAgICRwYXJhbVdyYXAgPSAkZWRpdG9yLm5leHRBbGwoJy5wYXJhbVdyYXAnKVxuXG4gICAgICAgICAgLy8gZmlsZXNcbiAgICAgICAgICBpZiAoZmlsZXMubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgZm9yIChsZXQgaSA9IDAsIG1heCA9IGZpbGVzLmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICAgICAgICAgIGxldCBmaWxlID0gZmlsZXNbaV1cblxuICAgICAgICAgICAgICAkcGFyYW1XcmFwLmFwcGVuZChcIjxpbnB1dCB0eXBlPSdoaWRkZW4nbmFtZT0nXCIgKyBmaWxlSW5wdXQgKyBcIltdJyB2YWx1ZT0nXCIgKyBmaWxlLmlkICsgXCInIC8+XCIpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfVxuICAgICAgICB9KVxuICAgICAgfSxcblxuICAgICAgZ2V0Q29udGVudHM6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgcmV0dXJuIHRoaXMucHJvcHMuZWRpdG9yLnZhbCgpXG4gICAgICB9LFxuXG4gICAgICBzZXRDb250ZW50czogZnVuY3Rpb24gKHRleHQpIHtcbiAgICAgICAgdGhpcy5wcm9wcy5lZGl0b3IudmFsKHRleHQpXG4gICAgICB9LFxuXG4gICAgICBhZGRDb250ZW50czogZnVuY3Rpb24gKHRleHQpIHtcbiAgICAgICAgdmFyIGh0bWwgPSB0aGlzLnByb3BzLmVkaXRvci52YWwoKVxuICAgICAgICB0aGlzLnByb3BzLmVkaXRvci52YWwoaHRtbClcbiAgICAgIH0sXG5cbiAgICAgIG9uOiBmdW5jdGlvbiAoZXZlbnROYW1lLCBjYWxsYmFjaykge1xuICAgICAgICB0aGlzLnByb3BzLmVkaXRvci5vbihldmVudE5hbWUsIGNhbGxiYWNrKVxuICAgICAgfSxcbiAgICAgIGdldENvbnRlbnREb206IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgcmV0dXJuIGZhbHNlXG4gICAgICB9LFxuICAgICAgcmVzZXQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgLy8gY29udGVudHMg7IKt7KCcXG4gICAgICAgIHRoaXMucHJvcHMuZWRpdG9yLnZhbCgnJykuZm9jdXMoKVxuXG4gICAgICAgIC8vIGlucHV0IGhpZGRlbiDsgq3soJxcbiAgICAgICAgdGhpcy5wcm9wcy5lZGl0b3IubmV4dEFsbCgnLnBhcmFtV3JhcCcpLnJlbW92ZSgpXG4gICAgICB9XG4gICAgfVxuICB9KVxufSlcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxMDYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0NDQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg3KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoOCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDIxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEzKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxMzEpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2OCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDApOyIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==