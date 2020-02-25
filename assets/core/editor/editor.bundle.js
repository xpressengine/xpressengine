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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(33);

/***/ }),

/***/ "./core/editor/editorDefine.js":
/*!*************************************!*\
  !*** ./core/editor/editorDefine.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _editorValidation__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editorValidation */ "./core/editor/editorValidation.js");
/* harmony import */ var _editorInstance__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./editorInstance */ "./core/editor/editorInstance.js");
/* harmony import */ var xe_utils__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! xe/utils */ "./core/utils/index.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_6__);







/**
 * @class
 */

var EditorDefine =
/*#__PURE__*/
function () {
  /**
   * @param {object} editorSettings
   * @param {object} interfaces
   */
  function EditorDefine(editorSettings, interfaces) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, EditorDefine);

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


  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(EditorDefine, [{
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

var EditorInstance =
/*#__PURE__*/
function () {
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
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);
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

var EditorValidation =
/*#__PURE__*/
function () {
  function EditorValidation() {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, EditorValidation);
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(EditorValidation, null, [{
    key: "isValidBeforeCreateInstance",

    /**
     * Editor의 instance를 생성하기 전 중복 검사 등 수행
     * @param {string} sel jQuery selector
     * @param {array} toolIdList
     * @param {object} editorParent
     * @return {boolean}
     * @throws {EditorUndefinedContainer}
     * @throws {EditorUsedContainer}
     */
    value: function isValidBeforeCreateInstance(sel, toolIdList, editorParent) {
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
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/getPrototypeOf */ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/inherits */ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var xe_error__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! xe/error */ "./core/error/index.js");





/**
 * @module XeError/EditorDefineError
 * @extends XeError
 */

var EditorDefineError =
/*#__PURE__*/
function (_XeError) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_3___default()(EditorDefineError, _XeError);

  function EditorDefineError(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorDefineError);

    return _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_1___default()(this, _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_2___default()(EditorDefineError).call(this, message));
  }

  return EditorDefineError;
}(xe_error__WEBPACK_IMPORTED_MODULE_4__["default"]);
/**
 * @module XeError/EditorToolDefineError
 * @extends XeError
 */


var EditorToolDefineError =
/*#__PURE__*/
function (_XeError2) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_3___default()(EditorToolDefineError, _XeError2);

  function EditorToolDefineError(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorToolDefineError);

    return _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_1___default()(this, _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_2___default()(EditorToolDefineError).call(this, message));
  }

  return EditorToolDefineError;
}(xe_error__WEBPACK_IMPORTED_MODULE_4__["default"]);
/**
 * @module XeError/EditorUsedContainer
 * @extends XeError
 */


var EditorUsedContainer =
/*#__PURE__*/
function (_XeError3) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_3___default()(EditorUsedContainer, _XeError3);

  function EditorUsedContainer(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorUsedContainer);

    return _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_1___default()(this, _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_2___default()(EditorUsedContainer).call(this, message));
  }

  return EditorUsedContainer;
}(xe_error__WEBPACK_IMPORTED_MODULE_4__["default"]);
/**
 * @module XeError/EditorUndefinedContainer
 * @extends XeError
 */


var EditorUndefinedContainer =
/*#__PURE__*/
function (_XeError4) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_3___default()(EditorUndefinedContainer, _XeError4);

  function EditorUndefinedContainer(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorUndefinedContainer);

    return _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_1___default()(this, _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_2___default()(EditorUndefinedContainer).call(this, message));
  }

  return EditorUndefinedContainer;
}(xe_error__WEBPACK_IMPORTED_MODULE_4__["default"]);



/***/ }),

/***/ "./core/editor/index.js":
/*!******************************!*\
  !*** ./core/editor/index.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_object_to_string__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.object.to-string */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_promise__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.promise */ "./node_modules/core-js/modules/es.promise.js");
/* harmony import */ var core_js_modules_es_promise__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_promise__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/promise */ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/getPrototypeOf */ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/get */ "./node_modules/@babel/runtime-corejs3/helpers/get.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/inherits */ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var xe_app__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! xe/app */ "./core/app.js");
/* harmony import */ var _editorDefine__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./editorDefine */ "./core/editor/editorDefine.js");
/* harmony import */ var _editorValidation__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./editorValidation */ "./core/editor/editorValidation.js");
/* harmony import */ var _editorTool__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./editorTool */ "./core/editor/editorTool.js");
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! xe */ "./core/index.js");
















/**
 * @class
 * @extends App
 */

var Editor =
/*#__PURE__*/
function (_App) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_9___default()(Editor, _App);

  function Editor() {
    var _this;

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_4___default()(this, Editor);

    _this = _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_6___default()(this, _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7___default()(Editor).call(this));
    _this.toolsSet = {};
    _this.editorSet = {};
    _this.editorOptionSet = {};
    /**
     * @DEPRECATED
     **/

    _this.tools = {
      define: function define(obj) {
        if (jquery__WEBPACK_IMPORTED_MODULE_10___default.a.isFunction(console.warn) && jquery__WEBPACK_IMPORTED_MODULE_10___default.a.isFunction(console.trace)) {
          console.warn('DEPRECATED: XEeditor.tools.define() is deprecated. use XEeditor.defineTool');
          console.trace();
        }

        _this.defineTool(obj);
      },
      get: function get(id) {
        if (jquery__WEBPACK_IMPORTED_MODULE_10___default.a.isFunction(console.warn) && jquery__WEBPACK_IMPORTED_MODULE_10___default.a.isFunction(console.trace)) {
          console.warn('DEPRECATED: XEeditor.tools.get() is deprecated. use XEeditor.getTool');
          console.trace();
        }

        return _this.getTool(id);
      }
    };
    return _this;
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_5___default()(Editor, [{
    key: "boot",
    value: function boot(XE) {
      var _this2 = this;

      if (this.booted()) {
        return _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_3___default.a.resolve(this);
      }

      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_3___default.a(function (resolve) {
        _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_8___default()(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7___default()(Editor.prototype), "boot", _this2).call(_this2, XE);

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
        if (_editorValidation__WEBPACK_IMPORTED_MODULE_13__["default"].isValidEditorOptions(editorSettings, interfaces)) {
          var editor = new _editorDefine__WEBPACK_IMPORTED_MODULE_12__["default"](editorSettings, interfaces);
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
        return _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_3___default.a.resolve(this.editorSet[name]);
      }

      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_3___default.a(function (resolve) {
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
        if (_editorValidation__WEBPACK_IMPORTED_MODULE_13__["default"].isValidToolsObject(obj)) {
          this.toolsSet[obj.id] = new _editorTool__WEBPACK_IMPORTED_MODULE_14__["default"](obj);
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
      return jquery__WEBPACK_IMPORTED_MODULE_10___default()(content).attr('xe-tool-id', id).clone().wrapAll('<div/>').parent().html();
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
}(xe_app__WEBPACK_IMPORTED_MODULE_11__["default"]);

/* harmony default export */ __webpack_exports__["default"] = (Editor);
/**
 * @type       {Editor}
 */

var XEeditor = new Editor();
if (!window.XEeditor) window.XEeditor = XEeditor;
xe__WEBPACK_IMPORTED_MODULE_15__["default"].registerApp('Editor', XEeditor);

/***/ }),

/***/ "./core/editor/textarea.define.js":
/*!****************************************!*\
  !*** ./core/editor/textarea.define.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.join */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_0__);
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(114);

/***/ }),

/***/ "./core/index.js":
/*!*******************************************************************!*\
  !*** delegated ./core/index.js from dll-reference _xe_dll_common ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(447);

/***/ }),

/***/ "./core/utils/index.js":
/*!*************************************************************************!*\
  !*** delegated ./core/utils/index.js from dll-reference _xe_dll_common ***!
  \*************************************************************************/
/*! exports provided: getUri, addCommas, strtotime, EventEmitter, curry, debounce, find, forEach, mapValues, throttle, trim, trimEnd, trimStart, setBaseURL, eventify, isImage, isVideo, isAudio, formatSizeUnits, sizeFormatToBytes, isURL, asset, openWindow */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(6);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(3);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js":
/*!****************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/createClass.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(9);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/get.js":
/*!********************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/get.js from dll-reference _xe_dll_common ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(23);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(7);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js":
/*!*************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/inherits.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(14);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js":
/*!******************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(13);

/***/ }),

/***/ "./node_modules/core-js/modules/es.array.join.js":
/*!***************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.array.join.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(141);

/***/ }),

/***/ "./node_modules/core-js/modules/es.function.name.js":
/*!******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.function.name.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(73);

/***/ }),

/***/ "./node_modules/core-js/modules/es.object.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.object.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(43);

/***/ }),

/***/ "./node_modules/core-js/modules/es.promise.js":
/*!************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.promise.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(46);

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

__webpack_require__(/*! /Users/bnu/dev/boldjournal/resources/assets/core/editor/index */"./core/editor/index.js");
module.exports = __webpack_require__(/*! /Users/bnu/dev/boldjournal/resources/assets/core/editor/textarea.define.js */"./core/editor/textarea.define.js");


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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvYXBwLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9jb3JlL2VkaXRvci9lZGl0b3JEZWZpbmUuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvZWRpdG9ySW5zdGFuY2UuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvZWRpdG9yVG9vbC5qcyIsIndlYnBhY2s6Ly8vLi9jb3JlL2VkaXRvci9lZGl0b3JWYWxpZGF0aW9uLmpzIiwid2VicGFjazovLy8uL2NvcmUvZWRpdG9yL2Vycm9ycy9lZGl0b3IuZXJyb3IuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvaW5kZXguanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvdGV4dGFyZWEuZGVmaW5lLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9jb3JlL2Vycm9yL2luZGV4LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vY29yZS9pbmRleC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvdXRpbHMvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9wcm9taXNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jbGFzc0NhbGxDaGVjay5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvY3JlYXRlQ2xhc3MuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2dldC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvZ2V0UHJvdG90eXBlT2YuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2luaGVyaXRzLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9wb3NzaWJsZUNvbnN0cnVjdG9yUmV0dXJuLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5hcnJheS5qb2luLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5mdW5jdGlvbi5uYW1lLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5vYmplY3QudG8tc3RyaW5nLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5wcm9taXNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2pxdWVyeS9zcmMvanF1ZXJ5LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZXh0ZXJuYWwgXCJfeGVfZGxsX2NvbW1vblwiIl0sIm5hbWVzIjpbIkVkaXRvckRlZmluZSIsImVkaXRvclNldHRpbmdzIiwiaW50ZXJmYWNlcyIsIm5hbWUiLCJjb25maWdzIiwiZWRpdG9yTGlzdCIsImV2ZW50aWZ5IiwiaGFzT3duUHJvcGVydHkiLCJwbHVnaW5zIiwiQXJyYXkiLCJsZW5ndGgiLCJhZGRQbHVnaW5zIiwibyIsInNlbCIsIm9wdGlvbnMiLCJlZGl0b3JPcHRpb25zIiwidG9vbEluZm9MaXN0IiwiJCIsImV4dGVuZCIsIkVkaXRvclZhbGlkYXRpb24iLCJpc1ZhbGlkQmVmb3JlQ3JlYXRlSW5zdGFuY2UiLCJlZGl0b3JJbnRhbmNlIiwiRWRpdG9ySW5zdGFuY2UiLCJfZWRpdG9yIiwiaW5pdGlhbGl6ZSIsImNhbGwiLCJ0b29scyIsInRvb2xJbmZvTGlzdEZpbHRlciIsImkiLCJtYXgiLCJ3aW5kb3ciLCJYRWVkaXRvciIsImdldFRvb2wiLCJpZCIsInB1c2giLCJjb25zb2xlIiwiZXJyb3IiLCJhZGRUb29scyIsImVkaXRvck5hbWUiLCJfb3B0aW9ucyIsInNlbGVjdG9yIiwicHJvcHMiLCJnZXRPcHRpb25zIiwiZWRpdG9yU2V0IiwiZ2V0Q29udGVudHMiLCJ0ZXh0Iiwic2V0Q29udGVudHMiLCJhZGRDb250ZW50cyIsIm9iaiIsInRvb2xJbnN0YW5jZUxpc3QiLCJldmVudE5hbWUiLCJjYWxsYmFjayIsIm9uIiwiY3VzdG9tT3B0aW9ucyIsInJlbmRlckZpbGVVcGxvYWRlciIsImdldENvbnRlbnREb20iLCJyZXNldCIsIkVkaXRvclRvb2wiLCJyZXF1aXJlT3B0aW9ucyIsInByb3BlcnR5IiwiZXZlbnRzIiwidG9vbElkTGlzdCIsImVkaXRvclBhcmVudCIsIkVkaXRvclVuZGVmaW5lZENvbnRhaW5lciIsInNlbFZhbGlkIiwiRWRpdG9yVXNlZENvbnRhaW5lciIsInZhbGlkIiwiZVNldHRpbmdzIiwiRWRpdG9yRGVmaW5lRXJyb3IiLCJlSW50ZXJmYWNlIiwidG9vbERlZmluZSIsIkVkaXRvclRvb2xEZWZpbmVFcnJvciIsIm1lc3NhZ2UiLCJYZUVycm9yIiwiRWRpdG9yIiwidG9vbHNTZXQiLCJlZGl0b3JPcHRpb25TZXQiLCJkZWZpbmUiLCJpc0Z1bmN0aW9uIiwid2FybiIsInRyYWNlIiwiZGVmaW5lVG9vbCIsImdldCIsIlhFIiwiYm9vdGVkIiwicmVzb2x2ZSIsImlzVmFsaWRFZGl0b3JPcHRpb25zIiwiZWRpdG9yIiwiJCRlbWl0IiwiZSIsIiQkb24iLCJpc1ZhbGlkVG9vbHNPYmplY3QiLCJjb250ZW50IiwiYXR0ciIsImNsb25lIiwid3JhcEFsbCIsInBhcmVudCIsImh0bWwiLCJBcHAiLCJyZWdpc3RlckFwcCIsImFwcCIsImZpbGVVcGxvYWQiLCJzdWdnZXN0aW9uIiwibmFtZXMiLCJmaWxlIiwiaW1hZ2UiLCJ0YWciLCJtZW50aW9uIiwiZXh0ZW5zaW9ucyIsImZvbnRGYW1pbHkiLCJwZXJtcyIsImZpbGVzIiwiJGVkaXRvciIsImhlaWdodCIsImZvbnRTaXplIiwiYWRkUHJvcHMiLCJjc3MiLCJqb2luIiwicGFyZW50cyIsImZpbGVJbnB1dCIsImlucHV0IiwiJHBhcmFtV3JhcCIsIm5leHRBbGwiLCJyZW1vdmUiLCJhZnRlciIsImFwcGVuZCIsInZhbCIsImZvY3VzIl0sIm1hcHBpbmdzIjoiO1FBQUE7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBOztRQUVBO1FBQ0E7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QixFQUEwQkMsS0FBMUIsR0FGaUIsQ0FJakI7O0FBQ0EsYUFBS3RGLEtBQUwsQ0FBVzhDLE1BQVgsQ0FBa0JtQyxPQUFsQixDQUEwQixZQUExQixFQUF3Q0MsTUFBeEM7QUFDRDtBQXZGUztBQWhDQSxHQUFkO0FBMEhELENBM0hELEU7Ozs7Ozs7Ozs7O0FDSEEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQ0FBLGdDIiwiZmlsZSI6ImFzc2V0cy9jb3JlL2VkaXRvci9lZGl0b3IuYnVuZGxlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IDEpO1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDMzKTsiLCJpbXBvcnQgRWRpdG9yVmFsaWRhdGlvbiBmcm9tICcuL2VkaXRvclZhbGlkYXRpb24nXG5pbXBvcnQgRWRpdG9ySW5zdGFuY2UgZnJvbSAnLi9lZGl0b3JJbnN0YW5jZSdcbmltcG9ydCB7IGV2ZW50aWZ5IH0gZnJvbSAneGUvdXRpbHMnXG5pbXBvcnQgJCBmcm9tICdqcXVlcnknXG5cbi8qKlxuICogQGNsYXNzXG4gKi9cbmNsYXNzIEVkaXRvckRlZmluZSB7XG4gIC8qKlxuICAgKiBAcGFyYW0ge29iamVjdH0gZWRpdG9yU2V0dGluZ3NcbiAgICogQHBhcmFtIHtvYmplY3R9IGludGVyZmFjZXNcbiAgICovXG4gIGNvbnN0cnVjdG9yIChlZGl0b3JTZXR0aW5ncywgaW50ZXJmYWNlcykge1xuICAgIHRoaXMubmFtZSA9IGVkaXRvclNldHRpbmdzLm5hbWVcbiAgICB0aGlzLmNvbmZpZ3MgPSBlZGl0b3JTZXR0aW5ncy5jb25maWdzXG4gICAgdGhpcy5lZGl0b3JMaXN0ID0gW11cbiAgICB0aGlzLmludGVyZmFjZXMgPSB7fVxuXG4gICAgZXZlbnRpZnkodGhpcylcblxuICAgIGlmIChlZGl0b3JTZXR0aW5ncy5oYXNPd25Qcm9wZXJ0eSgncGx1Z2lucycpICYmXG4gICAgICBlZGl0b3JTZXR0aW5ncy5wbHVnaW5zIGluc3RhbmNlb2YgQXJyYXkgJiZcbiAgICAgIGVkaXRvclNldHRpbmdzLnBsdWdpbnMubGVuZ3RoID4gMCAmJlxuICAgICAgZWRpdG9yU2V0dGluZ3MuaGFzT3duUHJvcGVydHkoJ2FkZFBsdWdpbnMnKSkge1xuICAgICAgZWRpdG9yU2V0dGluZ3MuYWRkUGx1Z2lucyhlZGl0b3JTZXR0aW5ncy5wbHVnaW5zKVxuICAgIH1cblxuICAgIGZvciAodmFyIG8gaW4gaW50ZXJmYWNlcykge1xuICAgICAgdGhpc1tvXSA9IGludGVyZmFjZXNbb11cbiAgICB9XG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw66W8IOyDneyEsSDrsI8g7Yi07J2EIOy2lOqwgO2VnOuLpC5cbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbCBzZWxlY3RvclxuICAgKiBAcGFyYW0ge29iamVjdH0gb3B0aW9uc1xuICAgKiBAcGFyYW0ge29iamVjdH0gZWRpdG9yT3B0aW9uc1xuICAgKiBAcGFyYW0ge2FycmF5fSB0b29sSW5mb0xpc3RcbiAgICovXG4gIGNyZWF0ZSAoc2VsLCBvcHRpb25zLCBlZGl0b3JPcHRpb25zLCB0b29sSW5mb0xpc3QpIHtcbiAgICB0b29sSW5mb0xpc3QgPSB0b29sSW5mb0xpc3QgfHwgW11cbiAgICBlZGl0b3JPcHRpb25zID0gJC5leHRlbmQodGhpcy5jb25maWdzIHx8IHt9LCBlZGl0b3JPcHRpb25zIHx8IHt9KVxuXG4gICAgaWYgKEVkaXRvclZhbGlkYXRpb24uaXNWYWxpZEJlZm9yZUNyZWF0ZUluc3RhbmNlKHNlbCwgdG9vbEluZm9MaXN0LCB0aGlzKSkge1xuICAgICAgY29uc3QgZWRpdG9ySW50YW5jZSA9IG5ldyBFZGl0b3JJbnN0YW5jZSh0aGlzLm5hbWUsIHNlbCwgZWRpdG9yT3B0aW9ucywgdG9vbEluZm9MaXN0KVxuICAgICAgZWRpdG9ySW50YW5jZS5fZWRpdG9yID0gdGhpc1xuICAgICAgdGhpcy5lZGl0b3JMaXN0W3NlbF0gPSBlZGl0b3JJbnRhbmNlXG4gICAgICB0aGlzLmluaXRpYWxpemUuY2FsbCh0aGlzLmVkaXRvckxpc3Rbc2VsXSwgc2VsLCBvcHRpb25zLCBlZGl0b3JPcHRpb25zKVxuXG4gICAgICBpZiAoISF0b29sSW5mb0xpc3QgJiYgdG9vbEluZm9MaXN0Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgbGV0IHRvb2xzID0ge31cbiAgICAgICAgbGV0IHRvb2xJbmZvTGlzdEZpbHRlciA9IFtdXG5cbiAgICAgICAgZm9yIChsZXQgaSA9IDAsIG1heCA9IHRvb2xJbmZvTGlzdC5sZW5ndGg7IGkgPCBtYXg7IGkgKz0gMSkge1xuICAgICAgICAgIGlmICh3aW5kb3cuWEVlZGl0b3IuZ2V0VG9vbCh0b29sSW5mb0xpc3RbaV0uaWQpKSB7XG4gICAgICAgICAgICB0b29sc1t0b29sSW5mb0xpc3RbaV0uaWRdID0gd2luZG93LlhFZWRpdG9yLmdldFRvb2wodG9vbEluZm9MaXN0W2ldLmlkKVxuICAgICAgICAgICAgdG9vbEluZm9MaXN0RmlsdGVyLnB1c2godG9vbEluZm9MaXN0W2ldKVxuICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBjb25zb2xlLmVycm9yKCdkZWZpbmXrkJwgdG9vbOydtCDsobTsnqztlZjsp4Ag7JWK7J2MLiBbJyArIHRvb2xJbmZvTGlzdFtpXS5pZCArICddJylcbiAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICBpZiAodGhpcy5hZGRUb29scyAmJiB0eXBlb2YgdGhpcy5hZGRUb29scyA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgICAgIHRoaXMuYWRkVG9vbHMuY2FsbCh0aGlzLmVkaXRvckxpc3Rbc2VsXSwgdG9vbHMsIHRvb2xJbmZvTGlzdEZpbHRlcilcbiAgICAgICAgfVxuICAgICAgfVxuXG4gICAgICByZXR1cm4gdGhpcy5lZGl0b3JMaXN0W3NlbF1cbiAgICB9XG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9yRGVmaW5lXG4iLCJpbXBvcnQgeyBldmVudGlmeSB9IGZyb20gJ3hlLXV0aWxzJyAvLyBARklYTUUgaHR0cHM6Ly9naXRodWIuY29tL3hwcmVzc2VuZ2luZS94cHJlc3NlbmdpbmUvaXNzdWVzLzc2NVxuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuXG4vKipcbiAqIEBjbGFzc1xuICovXG5jbGFzcyBFZGl0b3JJbnN0YW5jZSB7XG4gIC8qKlxuICAgKiBAY29uc3RydWN0b3JcbiAgICogQHBhcmFtIHtzdHJpbmd9IGVkaXRvck5hbWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbCBzZWxlY3RvclxuICAgKiBAcGFyYW0ge29iamVjdH0gZWRpdG9yT3B0aW9uc1xuICAgKiBAcGFyYW0ge2FycmF5fSB0b29sSW5mb0xpc3Qg7JeQ65SU7YSw7JeQIOy2lOqwgOuQoCB0b29sIOygleuztCDrpqzsiqTtirhcbiAgICovXG4gIGNvbnN0cnVjdG9yIChlZGl0b3JOYW1lLCBzZWwsIGVkaXRvck9wdGlvbnMsIHRvb2xJbmZvTGlzdCkge1xuICAgIC8qKiBAcHJpdmF0ZSAqL1xuICAgIGxldCBfb3B0aW9ucyA9IHtcbiAgICAgIGVkaXRvck9wdGlvbnM6IGVkaXRvck9wdGlvbnMsXG4gICAgICB0b29sSW5mb0xpc3Q6IHRvb2xJbmZvTGlzdFxuICAgIH1cblxuICAgIGV2ZW50aWZ5KHRoaXMpXG5cbiAgICAvKiogQHB1YmxpYyAqL1xuICAgIHRoaXMuZWRpdG9yTmFtZSA9IGVkaXRvck5hbWVcbiAgICAvKiogQHB1YmxpYyAqL1xuICAgIHRoaXMuc2VsZWN0b3IgPSBzZWxcbiAgICAvKiogQHB1YmxpYyAqL1xuICAgIHRoaXMucHJvcHMgPSB7fVxuICAgIC8qKlxuICAgICAqIOyXkOuUlO2EsCDsmLXshZjsnYQg67CY7ZmY7ZWc64ukLlxuICAgICAqIEBwdWJsaWNcbiAgICAgKiBAbWV0aG9kXG4gICAgICovXG4gICAgdGhpcy5nZXRPcHRpb25zID0gZnVuY3Rpb24gKCkge1xuICAgICAgcmV0dXJuIF9vcHRpb25zXG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIOyDneyEseuQnCBpbnN0YW5jZeulvCDrsJjtmZjtlZzri6RJbnN0YW5jZU9iai5cbiAgICogQG1ldGhvZFxuICAgKiBAcmV0dXJuIHtvYmplY3R9XG4gICAqL1xuICBnZXRJbnN0YW5jZSAoKSB7XG4gICAgcmV0dXJuIHRoaXNcbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDsl5Ag7J6R7ISx65CcIOy7qO2FkOy4oOulvCDrsJjtmZjtlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHJldHVybiB7c3RyaW5nfVxuICAgKi9cbiAgZ2V0Q29udGVudHMgKCkge1xuICAgIHJldHVybiBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5nZXRDb250ZW50cy5jYWxsKHRoaXMpXG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw7JeQIOuCtOyaqeydhCDsnoXroKXtlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHtzdHJpbmd9IHRleHRcbiAgICovXG4gIHNldENvbnRlbnRzICh0ZXh0KSB7XG4gICAgWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0uc2V0Q29udGVudHMuY2FsbCh0aGlzLCB0ZXh0KVxuICB9XG5cbiAgLyoqXG4gICAqIOyXkOuUlO2EsOyXkCDrgrTsmqnsnYQg7J6F66Cl7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB0ZXh0XG4gICAqL1xuICBhZGRDb250ZW50cyAodGV4dCkge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLmFkZENvbnRlbnRzLmNhbGwodGhpcywgdGV4dClcbiAgfVxuXG4gIC8qKlxuICAgKiDsg53shLHrkJwgaW5zdGFuY2Xsl5AgcHJvcGVydHnrpbwg65Ox66Gd7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBvYmpcbiAgICovXG4gIGFkZFByb3BzIChvYmopIHtcbiAgICBmb3IgKHZhciBvIGluIG9iaikge1xuICAgICAgdGhpcy5wcm9wc1tvXSA9IG9ialtvXVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDsl5Ag7Yi07J2EIOy2lOqwgO2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge2FycmF5fSB0b29sSW5zdGFuY2VMaXN0XG4gICAqL1xuICBhZGRUb29scyAodG9vbEluc3RhbmNlTGlzdCkge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLmFkZFRvb2xzLmNhbGwodGhpcywgdGhpcy5nZXRPcHRpb25zKCkudG9vbEluZm9MaXN0LCB0b29sSW5zdGFuY2VMaXN0KVxuICB9XG5cbiAgLyoqXG4gICAqIOq1rO2YhOuQnCDsl5DrlJTthLDsl5Ag7J2067Kk7Yq466W8IO2VoOuLue2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge3N0cmluZ30gZXZlbnROYW1lXG4gICAqIEBwYXJhbSB7ZnVuY3Rpb259IGNhbGxiYWNrIGV2ZW50IGNhbGxiYWNrXG4gICAqL1xuICBvbiAoZXZlbnROYW1lLCBjYWxsYmFjaykge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLm9uLmNhbGwodGhpcywgZXZlbnROYW1lLCBjYWxsYmFjaylcbiAgfVxuXG4gIC8qKlxuICAgKiDqtaztmITrkJwg7JeQ65SU7YSwIO2MjOydvCDsl4XroZzrk5wg6riw64ql7J2EIO2YuOy2o+2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge29iamVjdH0gY3VzdG9tT3B0aW9uc1xuICAgKi9cbiAgcmVuZGVyRmlsZVVwbG9hZGVyIChjdXN0b21PcHRpb25zKSB7XG4gICAgWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0ucmVuZGVyRmlsZVVwbG9hZGVyLmNhbGwodGhpcywgY3VzdG9tT3B0aW9ucylcbiAgfVxuXG4gIGdldENvbnRlbnREb20gKCkge1xuICAgIGlmICh0eXBlb2YgWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0uZ2V0Q29udGVudERvbSA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgcmV0dXJuIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLmdldENvbnRlbnREb20uY2FsbCh0aGlzKVxuICAgIH1cbiAgICByZXR1cm4gZmFsc2VcbiAgfVxuXG4gIC8qKlxuICAgKiDqtaztmITrkJwg7JeQ65SU7YSwIHJlc2V0IO2VqOyImOulvCDtmLjstpztlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHtvYmplY3R9IGN1c3RvbU9wdGlvbnNcbiAgICovXG4gIHJlc2V0ICgpIHtcbiAgICBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5yZXNldC5jYWxsKHRoaXMpXG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9ySW5zdGFuY2VcbiIsIi8qKlxuICogQGNsYXNzXG4gKi9cbmNsYXNzIEVkaXRvclRvb2wge1xuICBjb25zdHJ1Y3RvciAob2JqKSB7XG4gICAgZm9yIChsZXQgbyBpbiBvYmopIHtcbiAgICAgIHRoaXNbb10gPSBvYmpbb11cbiAgICB9XG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9yVG9vbFxuIiwiaW1wb3J0IHsgRWRpdG9yRGVmaW5lRXJyb3IsIEVkaXRvclRvb2xEZWZpbmVFcnJvciwgRWRpdG9yVXNlZENvbnRhaW5lciwgRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyIH0gZnJvbSAnLi9lcnJvcnMvZWRpdG9yLmVycm9yJ1xuXG4vKipcbiAqIEBwcml2YXRlXG4gKi9cbmNvbnN0IHJlcXVpcmVPcHRpb25zID0ge1xuICBlZGl0b3JTZXR0aW5nczogW1xuICAgICduYW1lJ1xuICBdLFxuICBpbnRlcmZhY2VzOiBbXG4gICAgJ2luaXRpYWxpemUnLFxuICAgICdhZGRDb250ZW50cycsXG4gICAgJ2dldENvbnRlbnRzJyxcbiAgICAnc2V0Q29udGVudHMnLFxuICAgICdnZXRDb250ZW50RG9tJ1xuICBdLFxuICB0b29sczoge1xuICAgIHByb3BlcnR5OiBbXG4gICAgICAnaWQnLFxuICAgICAgJ2V2ZW50cydcbiAgICBdLFxuICAgIGV2ZW50czogW1xuICAgICAgJ2ljb25DbGljaycsXG4gICAgICAnZWxlbWVudERvdWJsZUNsaWNrJ1xuICAgIF1cbiAgfVxufVxuXG4vKipcbiAqIEBjbGFzc1xuICovXG5jbGFzcyBFZGl0b3JWYWxpZGF0aW9uIHtcbiAgLyoqXG4gICAqIEVkaXRvcuydmCBpbnN0YW5jZeulvCDsg53shLHtlZjquLAg7KCEIOykkeuztSDqsoDsgqwg65OxIOyImO2WiVxuICAgKiBAcGFyYW0ge3N0cmluZ30gc2VsIGpRdWVyeSBzZWxlY3RvclxuICAgKiBAcGFyYW0ge2FycmF5fSB0b29sSWRMaXN0XG4gICAqIEBwYXJhbSB7b2JqZWN0fSBlZGl0b3JQYXJlbnRcbiAgICogQHJldHVybiB7Ym9vbGVhbn1cbiAgICogQHRocm93cyB7RWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyfVxuICAgKiBAdGhyb3dzIHtFZGl0b3JVc2VkQ29udGFpbmVyfVxuICAgKi9cbiAgc3RhdGljIGlzVmFsaWRCZWZvcmVDcmVhdGVJbnN0YW5jZSAoc2VsLCB0b29sSWRMaXN0LCBlZGl0b3JQYXJlbnQpIHtcbiAgICBpZiAoIXNlbCkge1xuICAgICAgLy8gc2VsZWN0b3LqsIAg7JeG7J2MXG4gICAgICB0aHJvdyBuZXcgRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyKCdFZGl0b3LqsIAg7IKs7Jqp7ZWgIGZpZWxk66W8IOyngOygle2VtOyVvCDtlanri4jri6QuJylcbiAgICB9XG5cbiAgICBpZiAoZWRpdG9yUGFyZW50LmVkaXRvckxpc3QubGVuZ3RoID4gMCkge1xuICAgICAgbGV0IHNlbFZhbGlkID0gdHJ1ZVxuICAgICAgZm9yIChsZXQgaSA9IDAsIG1heCA9IGVkaXRvclBhcmVudC5lZGl0b3JMaXN0Lmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICAgIGlmIChlZGl0b3JQYXJlbnQuZWRpdG9yTGlzdFtpXSA9PT0gc2VsKSB7XG4gICAgICAgICAgc2VsVmFsaWQgPSBmYWxzZVxuICAgICAgICAgIHRocm93IG5ldyBFZGl0b3JVc2VkQ29udGFpbmVyKGBFZGl0b3LqsIAg7J2066+4IOyCrOyaqSDspJHsnoXri4jri6Q6ICR7c2VsfWApXG4gICAgICAgIH1cbiAgICAgIH1cblxuICAgICAgaWYgKCFzZWxWYWxpZCkge1xuICAgICAgICByZXR1cm4gZmFsc2VcbiAgICAgIH1cbiAgICB9XG5cbiAgICByZXR1cm4gdHJ1ZVxuICB9XG5cbiAgLyoqXG4gICAqIEB0eXBlZGVmIHtPYmplY3R9IGVkaXRvckRlZmluaXRpb25cbiAgICogQHByb3BlcnR5IHtvYmplY3R9IGVkaXRvckRlZmluaXRpb24uZWRpdG9yU2V0dGluZ3Mg7JeQ65SU7YSwIOyEpOyglSDsoJXrs7RcbiAgICogQHByb3BlcnR5IHtzdHJpbmd9IGVkaXRvckRlZmluaXRpb24uZWRpdG9yU2V0dGluZ3MubmFtZSDsl5DrlJTthLAg7ISk7KCVIOygleuztFxuICAgKiBAcHJvcGVydHkge29iamVjdH0gZWRpdG9yRGVmaW5pdGlvbi5pbnRlcmZhY2VzIOq1rO2YhOuQnCDsl5DrlJTthLAg7J247YSw7Y6Y7J207IqkXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcy5pbml0aWFsaXplXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcy5hZGRDb250ZW50c1xuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXMuZ2V0Q29udGVudHNcbiAgICogQHByb3BlcnR5IHtmdW5jdGlvbn0gZWRpdG9yRGVmaW5pdGlvbi5pbnRlcmZhY2VzLnNldENvbnRlbnRzXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcy5nZXRDb250ZW50RG9tXG4gICAqL1xuXG4gIC8qKlxuICAgKiBFZGl0b3Ig7KCV7J2Y6rCAIOyYrOuwlOuluOyngCDqsoDsgqxcbiAgICogQHBhcmFtIHtlZGl0b3JEZWZpbml0aW9uLmVkaXRvclNldHRpbmdzfSBlZGl0b3JTZXR0aW5nc1xuICAgKiBAcGFyYW0ge2VkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlc30gaW50ZXJmYWNlc1xuICAgKiBAcmV0dXJuIHtib29sZWFufVxuICAgKiBAdGhyb3dzIHtFZGl0b3JEZWZpbmVFcnJvcn1cbiAgICovXG4gIHN0YXRpYyBpc1ZhbGlkRWRpdG9yT3B0aW9ucyAoZWRpdG9yU2V0dGluZ3MsIGludGVyZmFjZXMpIHtcbiAgICBsZXQgdmFsaWQgPSB0cnVlXG4gICAgZm9yIChsZXQgZVNldHRpbmdzIGluIHJlcXVpcmVPcHRpb25zLmVkaXRvclNldHRpbmdzKSB7XG4gICAgICBpZiAoIWVkaXRvclNldHRpbmdzLmhhc093blByb3BlcnR5KHJlcXVpcmVPcHRpb25zLmVkaXRvclNldHRpbmdzW2VTZXR0aW5nc10pKSB7XG4gICAgICAgIHZhbGlkID0gZmFsc2VcbiAgICAgICAgdGhyb3cgbmV3IEVkaXRvckRlZmluZUVycm9yKGBFZGl0b3Ig6rec6rKp7J20IOunnuyngCDslYrsnYwgKOq1rO2YhCDtlYTsmpQgW2VkaXRvclNldHRpbmdzOiAke3JlcXVpcmVPcHRpb25zLmVkaXRvclNldHRpbmdzW2VTZXR0aW5nc119XSlgKVxuICAgICAgfVxuICAgIH1cblxuICAgIGZvciAobGV0IGVJbnRlcmZhY2UgaW4gcmVxdWlyZU9wdGlvbnMuaW50ZXJmYWNlcykge1xuICAgICAgaWYgKCFpbnRlcmZhY2VzLmhhc093blByb3BlcnR5KHJlcXVpcmVPcHRpb25zLmludGVyZmFjZXNbZUludGVyZmFjZV0pKSB7XG4gICAgICAgIHZhbGlkID0gZmFsc2VcbiAgICAgICAgdGhyb3cgbmV3IEVkaXRvckRlZmluZUVycm9yKGBFZGl0b3Ig6rec6rKp7J20IOunnuyngCDslYrsnYwgKOq1rO2YhCDtlYTsmpQgW2ludGVyZmFjZTogJHtyZXF1aXJlT3B0aW9ucy5pbnRlcmZhY2VzW2VJbnRlcmZhY2VdfV0pYClcbiAgICAgIH1cbiAgICB9XG5cbiAgICBpZiAoZWRpdG9yU2V0dGluZ3MuaGFzT3duUHJvcGVydHkoJ3BsdWdpbnMnKSAmJlxuICAgICAgZWRpdG9yU2V0dGluZ3MucGx1Z2lucyBpbnN0YW5jZW9mIEFycmF5ICYmXG4gICAgICBlZGl0b3JTZXR0aW5ncy5wbHVnaW5zLmxlbmd0aCA+IDAgJiZcbiAgICAgICFlZGl0b3JTZXR0aW5ncy5oYXNPd25Qcm9wZXJ0eSgnYWRkUGx1Z2lucycpKSB7XG4gICAgICB2YWxpZCA9IGZhbHNlXG4gICAgICB0aHJvdyBuZXcgRWRpdG9yRGVmaW5lRXJyb3IoYEVkaXRvciDqt5zqsqnsnbQg66ee7KeAIOyViuydjCAo6rWs7ZiEIO2VhOyalCBbZm46YWRkUGx1Z2luc10pYClcbiAgICB9XG5cbiAgICBpZiAod2luZG93LlhFZWRpdG9yLmVkaXRvclNldC5oYXNPd25Qcm9wZXJ0eShlZGl0b3JTZXR0aW5ncy5uYW1lKSkge1xuICAgICAgdmFsaWQgPSBmYWxzZVxuICAgICAgdGhyb3cgbmV3IEVkaXRvckRlZmluZUVycm9yKGDsnbTrr7gg6rCZ7J2AIOydtOumhOydmCDsl5DrlJTthLDqsIAg65Ox66Gd65CY7Ja0IOyeiOydjDogJHtlZGl0b3JTZXR0aW5ncy5uYW1lfWApXG4gICAgfVxuXG4gICAgcmV0dXJuICEoIXZhbGlkKVxuICB9XG5cbiAgLyoqXG4gICAqIEB0eXBlZGVmIHtPYmplY3R9IGVkaXRvclRvb2xEZWZpbml0aW9uXG4gICAqIEBwcm9wZXJ0eSB7c3RyaW5nfSBpZFxuICAgKiBAcHJvcGVydHkge29iamVjdH0gZXZlbnRzXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGV2ZW50cy5pY29uQ2xpY2tcbiAgICogQHByb3BlcnR5IHtmdW5jdGlvbn0gZXZlbnRzLmVsZW1lbnREb3VibGVDbGlja1xuICAgKiBAZGVwcmVjYXRlZFxuICAgKi9cblxuICAvKipcbiAgICogRWRpdG9yVG9vbCDsoJXsnZjqsIAg7Jis67CU66W47KeAIOqygOyCrFxuICAgKiBAcGFyYW0ge2VkaXRvclRvb2xEZWZpbml0aW9ufSB0b29sRGVmaW5lXG4gICAqIEByZXR1cm4ge2Jvb2xlYW59XG4gICAqIEB0aHJvd3Mge0VkaXRvclRvb2xEZWZpbmVFcnJvcn1cbiAgICovXG4gIHN0YXRpYyBpc1ZhbGlkVG9vbHNPYmplY3QgKHRvb2xEZWZpbmUpIHtcbiAgICBsZXQgdmFsaWQgPSB0cnVlXG5cbiAgICBmb3IgKGxldCBpID0gMCwgbWF4ID0gcmVxdWlyZU9wdGlvbnMudG9vbHMucHJvcGVydHkubGVuZ3RoOyBpIDwgbWF4OyBpICs9IDEpIHtcbiAgICAgIGlmICghdG9vbERlZmluZS5oYXNPd25Qcm9wZXJ0eShyZXF1aXJlT3B0aW9ucy50b29scy5wcm9wZXJ0eVtpXSkpIHtcbiAgICAgICAgdmFsaWQgPSBmYWxzZVxuICAgICAgICB0aHJvdyBuZXcgRWRpdG9yVG9vbERlZmluZUVycm9yKGBFZGl0b3JUb29sIOq3nOqyqeydtCDrp57sp4Ag7JWK7J2MICjsho3shLHsnbQg7JeG7J2MOiAke3JlcXVpcmVPcHRpb25zLnRvb2xzLnByb3BlcnR5W2ldfSlgKVxuICAgICAgfVxuICAgIH1cblxuICAgIGZvciAobGV0IGkgPSAwLCBtYXggPSByZXF1aXJlT3B0aW9ucy50b29scy5ldmVudHMubGVuZ3RoOyBpIDwgbWF4OyBpICs9IDEpIHtcbiAgICAgIGlmICghdG9vbERlZmluZS5ldmVudHMuaGFzT3duUHJvcGVydHkocmVxdWlyZU9wdGlvbnMudG9vbHMuZXZlbnRzW2ldKSkge1xuICAgICAgICB2YWxpZCA9IGZhbHNlXG4gICAgICAgIHRocm93IG5ldyBFZGl0b3JUb29sRGVmaW5lRXJyb3IoYEVkaXRvclRvb2wg6rec6rKp7J20IOunnuyngCDslYrsnYwgKOydtOuypO2KuOqwgCDsoJXsnZjrkJjsp4Ag7JWK7J2MOiAke3JlcXVpcmVPcHRpb25zLnRvb2xzLmV2ZW50c1tpXX0pYClcbiAgICAgIH1cbiAgICB9XG5cbiAgICByZXR1cm4gdmFsaWRcbiAgfVxufVxuXG5leHBvcnQgZGVmYXVsdCBFZGl0b3JWYWxpZGF0aW9uXG5cbmV4cG9ydCB7XG4gIHJlcXVpcmVPcHRpb25zXG59XG4iLCJpbXBvcnQgWGVFcnJvciBmcm9tICd4ZS9lcnJvcidcblxuLyoqXG4gKiBAbW9kdWxlIFhlRXJyb3IvRWRpdG9yRGVmaW5lRXJyb3JcbiAqIEBleHRlbmRzIFhlRXJyb3JcbiAqL1xuY2xhc3MgRWRpdG9yRGVmaW5lRXJyb3IgZXh0ZW5kcyBYZUVycm9yIHtcbiAgY29uc3RydWN0b3IgKG1lc3NhZ2UpIHtcbiAgICBzdXBlcihtZXNzYWdlKVxuICB9XG59XG5cbi8qKlxuICogQG1vZHVsZSBYZUVycm9yL0VkaXRvclRvb2xEZWZpbmVFcnJvclxuICogQGV4dGVuZHMgWGVFcnJvclxuICovXG5jbGFzcyBFZGl0b3JUb29sRGVmaW5lRXJyb3IgZXh0ZW5kcyBYZUVycm9yIHtcbiAgY29uc3RydWN0b3IgKG1lc3NhZ2UpIHtcbiAgICBzdXBlcihtZXNzYWdlKVxuICB9XG59XG5cbi8qKlxuICogQG1vZHVsZSBYZUVycm9yL0VkaXRvclVzZWRDb250YWluZXJcbiAqIEBleHRlbmRzIFhlRXJyb3JcbiAqL1xuY2xhc3MgRWRpdG9yVXNlZENvbnRhaW5lciBleHRlbmRzIFhlRXJyb3Ige1xuICBjb25zdHJ1Y3RvciAobWVzc2FnZSkge1xuICAgIHN1cGVyKG1lc3NhZ2UpXG4gIH1cbn1cblxuLyoqXG4gKiBAbW9kdWxlIFhlRXJyb3IvRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyXG4gKiBAZXh0ZW5kcyBYZUVycm9yXG4gKi9cbmNsYXNzIEVkaXRvclVuZGVmaW5lZENvbnRhaW5lciBleHRlbmRzIFhlRXJyb3Ige1xuICBjb25zdHJ1Y3RvciAobWVzc2FnZSkge1xuICAgIHN1cGVyKG1lc3NhZ2UpXG4gIH1cbn1cblxuZXhwb3J0IHtcbiAgRWRpdG9yRGVmaW5lRXJyb3IsXG4gIEVkaXRvclRvb2xEZWZpbmVFcnJvcixcbiAgRWRpdG9yVXNlZENvbnRhaW5lcixcbiAgRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyXG59XG4iLCJpbXBvcnQgJCBmcm9tICdqcXVlcnknXG5pbXBvcnQgQXBwIGZyb20gJ3hlL2FwcCdcbmltcG9ydCBFZGl0b3JEZWZpbmUgZnJvbSAnLi9lZGl0b3JEZWZpbmUnXG5pbXBvcnQgRWRpdG9yVmFsaWRhdGlvbiBmcm9tICcuL2VkaXRvclZhbGlkYXRpb24nXG5pbXBvcnQgRWRpdG9yVG9vbCBmcm9tICcuL2VkaXRvclRvb2wnXG5pbXBvcnQgWEUgZnJvbSAneGUnXG5cbi8qKlxuICogQGNsYXNzXG4gKiBAZXh0ZW5kcyBBcHBcbiAqL1xuY2xhc3MgRWRpdG9yIGV4dGVuZHMgQXBwIHtcbiAgY29uc3RydWN0b3IgKCkge1xuICAgIHN1cGVyKClcblxuICAgIHRoaXMudG9vbHNTZXQgPSB7fVxuICAgIHRoaXMuZWRpdG9yU2V0ID0ge31cbiAgICB0aGlzLmVkaXRvck9wdGlvblNldCA9IHt9XG5cbiAgICAvKipcbiAgICAgKiBAREVQUkVDQVRFRFxuICAgICAqKi9cbiAgICB0aGlzLnRvb2xzID0ge1xuICAgICAgZGVmaW5lOiBvYmogPT4ge1xuICAgICAgICBpZiAoJC5pc0Z1bmN0aW9uKGNvbnNvbGUud2FybikgJiYgJC5pc0Z1bmN0aW9uKGNvbnNvbGUudHJhY2UpKSB7XG4gICAgICAgICAgY29uc29sZS53YXJuKCdERVBSRUNBVEVEOiBYRWVkaXRvci50b29scy5kZWZpbmUoKSBpcyBkZXByZWNhdGVkLiB1c2UgWEVlZGl0b3IuZGVmaW5lVG9vbCcpXG4gICAgICAgICAgY29uc29sZS50cmFjZSgpXG4gICAgICAgIH1cbiAgICAgICAgdGhpcy5kZWZpbmVUb29sKG9iailcbiAgICAgIH0sXG4gICAgICBnZXQ6IGlkID0+IHtcbiAgICAgICAgaWYgKCQuaXNGdW5jdGlvbihjb25zb2xlLndhcm4pICYmICQuaXNGdW5jdGlvbihjb25zb2xlLnRyYWNlKSkge1xuICAgICAgICAgIGNvbnNvbGUud2FybignREVQUkVDQVRFRDogWEVlZGl0b3IudG9vbHMuZ2V0KCkgaXMgZGVwcmVjYXRlZC4gdXNlIFhFZWRpdG9yLmdldFRvb2wnKVxuICAgICAgICAgIGNvbnNvbGUudHJhY2UoKVxuICAgICAgICB9XG4gICAgICAgIHJldHVybiB0aGlzLmdldFRvb2woaWQpXG4gICAgICB9XG4gICAgfVxuICB9XG5cbiAgc3RhdGljIGFwcE5hbWUgKCkge1xuICAgIHJldHVybiAnRWRpdG9yJ1xuICB9XG5cbiAgYm9vdCAoWEUpIHtcbiAgICBpZiAodGhpcy5ib290ZWQoKSkge1xuICAgICAgcmV0dXJuIFByb21pc2UucmVzb2x2ZSh0aGlzKVxuICAgIH1cblxuICAgIHJldHVybiBuZXcgUHJvbWlzZSgocmVzb2x2ZSkgPT4ge1xuICAgICAgc3VwZXIuYm9vdChYRSlcblxuICAgICAgcmVzb2x2ZSh0aGlzKVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw66W8IOygleydmO2VnOuLpC5cbiAgICogQHByb3BlcnR5IHtlZGl0b3JEZWZpbml0aW9ufSBvYmpcbiAgICoqL1xuICBkZWZpbmUgKG9iaikge1xuICAgIGNvbnN0IGVkaXRvclNldHRpbmdzID0gb2JqLmVkaXRvclNldHRpbmdzXG4gICAgY29uc3QgaW50ZXJmYWNlcyA9IG9iai5pbnRlcmZhY2VzXG5cbiAgICB0cnkge1xuICAgICAgaWYgKEVkaXRvclZhbGlkYXRpb24uaXNWYWxpZEVkaXRvck9wdGlvbnMoZWRpdG9yU2V0dGluZ3MsIGludGVyZmFjZXMpKSB7XG4gICAgICAgIGNvbnN0IGVkaXRvciA9IG5ldyBFZGl0b3JEZWZpbmUoZWRpdG9yU2V0dGluZ3MsIGludGVyZmFjZXMpXG4gICAgICAgIHRoaXMuZWRpdG9yU2V0W2VkaXRvclNldHRpbmdzLm5hbWVdID0gZWRpdG9yXG4gICAgICAgIHRoaXMuZWRpdG9yT3B0aW9uU2V0W2VkaXRvclNldHRpbmdzLm5hbWVdID0gZWRpdG9yU2V0dGluZ3NcbiAgICAgICAgdGhpcy4kJGVtaXQoJ2VkaXRvci5kZWZpbmUnLCBlZGl0b3IpXG4gICAgICB9XG4gICAgfSBjYXRjaCAoZSkge1xuICAgICAgLy8gY29uc29sZS5lcnJvcihlKVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDrpbwg67CY7ZmY7ZWc64ukLlxuICAgKiBAcGFyYW0ge3N0cmluZ30gbmFtZVxuICAgKiBAcmV0dXJuIHtQcm9taXNlfVxuICAgKiovXG4gIGdldEVkaXRvciAobmFtZSkge1xuICAgIGlmICh0aGlzLmVkaXRvclNldFtuYW1lXSkge1xuICAgICAgcmV0dXJuIFByb21pc2UucmVzb2x2ZSh0aGlzLmVkaXRvclNldFtuYW1lXSlcbiAgICB9XG5cbiAgICByZXR1cm4gbmV3IFByb21pc2UoKHJlc29sdmUpID0+IHtcbiAgICAgIHRoaXMuJCRvbignZWRpdG9yLmRlZmluZScsIChldmVudE5hbWUsIGVkaXRvcikgPT4ge1xuICAgICAgICByZXNvbHZlKGVkaXRvcilcbiAgICAgIH0pXG4gICAgfSlcbiAgfVxuXG4gIC8qKlxuICAgKiBFZGl0b3JUb29sIOygleydmFxuICAgKlxuICAgKiBAcGFyYW0ge2VkaXRvclRvb2xEZWZpbml0aW9ufSBvYmpcbiAgICovXG4gIGRlZmluZVRvb2wgKG9iaikge1xuICAgIHRyeSB7XG4gICAgICBpZiAoRWRpdG9yVmFsaWRhdGlvbi5pc1ZhbGlkVG9vbHNPYmplY3Qob2JqKSkge1xuICAgICAgICB0aGlzLnRvb2xzU2V0W29iai5pZF0gPSBuZXcgRWRpdG9yVG9vbChvYmopXG4gICAgICB9XG4gICAgfSBjYXRjaCAoZSkge1xuICAgICAgY29uc29sZS5lcnJvcihlKVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBFZGl0b3JUb29sIOuwmO2ZmFxuICAgKlxuICAgKiBAcGFyYW0ge3N0cmluZ30gaWRcbiAgICogQHJldHVybiB7RWRpdG9yVG9vbH1cbiAgICovXG4gIGdldFRvb2wgKGlkKSB7XG4gICAgcmV0dXJuIHRoaXMudG9vbHNTZXRbaWRdXG4gIH1cblxuICAvKipcbiAgICog7Luo7YWQ7Lig7JeQIHRvb2wgaWTrpbwgeGUtdG9vbC1pZCBhdHRyaWJ1dGXsl5Ag7ZWg64u57ZWY7JesIOuwmO2ZmO2VnOuLpC5cbiAgICogQHBhcmFtIHtzdHJpbmd9IGNvbnRlbnRcbiAgICogQHBhcmFtIHtzdHJpbmd9IGlkXG4gICAqIEByZXR1cm4ge3N0cmluZ30gSFRNTCBtYXJrdXAgc3RyaW5nXG4gICAqKi9cbiAgYXR0YWNoRG9tSWQgKGNvbnRlbnQsIGlkKSB7XG4gICAgcmV0dXJuICQoY29udGVudCkuYXR0cigneGUtdG9vbC1pZCcsIGlkKS5jbG9uZSgpLndyYXBBbGwoJzxkaXYvPicpLnBhcmVudCgpLmh0bWwoKVxuICB9XG5cbiAgLyoqXG4gICAqIEBERVBSRUNBVEVEXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBpZFxuICAgKiBAcmV0dXJuIHtzdHJpbmd9IEhUTUwgc2VsZWN0b3Igc3RyaW5nXG4gICAqKi9cbiAgZ2V0RG9tU2VsZWN0b3IgKGlkKSB7XG4gICAgcmV0dXJuICdbeGUtdG9vbC1pZD1cIicgKyBpZCArICdcIl0nXG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9yXG5cbi8qKlxuICogQHR5cGUgICAgICAge0VkaXRvcn1cbiAqL1xuY29uc3QgWEVlZGl0b3IgPSBuZXcgRWRpdG9yKClcbmlmICghd2luZG93LlhFZWRpdG9yKSB3aW5kb3cuWEVlZGl0b3IgPSBYRWVkaXRvclxuWEUucmVnaXN0ZXJBcHAoJ0VkaXRvcicsIFhFZWRpdG9yKVxuIiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IFhFIGZyb20gJ3hlJ1xuXG5YRS5hcHAoJ0VkaXRvcicsIChFZGl0b3IpID0+IHtcbiAgRWRpdG9yLmRlZmluZSh7XG4gICAgZWRpdG9yU2V0dGluZ3M6IHtcbiAgICAgIG5hbWU6ICdYRXRleHRhcmVhJyxcbiAgICAgIGNvbmZpZ3M6IHt9XG4gICAgfSxcbiAgICAvKipcbiAgICAgKiBAcHJvcCB7b2JqZWN0fSBpbnRlcmZhY2VzXG4gICAgICogQHByb3Age2Z1bmN0aW9uKHNlbGVjdG9yLG9wdGlvbnMpfSBpbnRlcmZhY2VzLmluaXRpYWxpemVcbiAgICAgKiA8cHJlPlxuICAgICAqICAgYXJndW1lbnRzXG4gICAgICogICAtIHNlbGVjdG9yIDogc3RyaW5nXG4gICAgICogICAtIG9wdGlvbnMgOiBvYmplY3RcbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcHJvcCB7ZnVuY3Rpb259IGludGVyZmFjZXMuZ2V0Q29udGVudHMg7JeQ65SU7YSwIOy7qO2FkOy4oOulvCDrpqzthLTtlZzri6QuXG4gICAgICogQHByb3Age2Z1bmN0aW9ufSBpbnRlcmZhY2VzLnNldENvbnRlbnRzIOyXkOuUlO2EsOyXkCDsu6jthZDsuKDrpbwg642u7Ja07JO064ukLlxuICAgICAqIDxwcmU+XG4gICAgICogICBhcmd1bWVudHNcbiAgICAgKiAgIC0gdGV4dCA6IHN0cmluZ1xuICAgICAqIDwvcHJlPlxuICAgICAqIEBwcm9wIHtmdW5jdGlvbn0gaW50ZXJmYWNlcy5hZGRDb250ZW50cyDsl5DrlJTthLDsl5Ag7Luo7YWQ7Lig66W8IOy2lOqwgO2VnOuLpC5cbiAgICAgKiA8cHJlPlxuICAgICAqICAgYXJndW1lbnRzXG4gICAgICogICAtIHRleHQgOiBzdHJpbmdcbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcHJvcCB7ZnVuY3Rpb259IGludGVyZmFjZXMub24g7JeQ65SU7YSw7JeQIOydtOuypO2KuCDtlbjrk6Trn6zrpbwg7LaU6rCA7ZWc64ukLlxuICAgICAqIDxwcmU+XG4gICAgICogICBhcmd1bWVudHNcbiAgICAgKiAgIC0gZXZlbnROYW1lIDogc3RyaW5nXG4gICAgICogICAtIGNhbGxiYWNrIDogZnVuY3Rpb25cbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcHJvcCB7ZnVuY3Rpb259IGludGVyZmFjZXMucmVzZXQg7JeQ65SU7YSwIOy7qO2FkOy4oOulvCDstIjquLDtmZTtlZzri6QuXG4gICAgICovXG4gICAgaW50ZXJmYWNlczoge1xuICAgICAgaW5pdGlhbGl6ZTogZnVuY3Rpb24gKHNlbGVjdG9yLCBvcHRpb25zKSB7XG4gICAgICAgIG9wdGlvbnMgPSAkLmV4dGVuZCh0cnVlLCB7XG4gICAgICAgICAgZmlsZVVwbG9hZDoge30sXG4gICAgICAgICAgc3VnZ2VzdGlvbjoge30sXG4gICAgICAgICAgbmFtZXM6IHtcbiAgICAgICAgICAgIGZpbGU6IHtcbiAgICAgICAgICAgICAgaW1hZ2U6IHt9XG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgdGFnOiB7fSxcbiAgICAgICAgICAgIG1lbnRpb246IHt9XG4gICAgICAgICAgfSxcbiAgICAgICAgICBleHRlbnNpb25zOiBbXSxcbiAgICAgICAgICBmb250RmFtaWx5OiBbXSxcbiAgICAgICAgICBwZXJtczoge30sXG4gICAgICAgICAgZmlsZXM6IFtdXG4gICAgICAgIH0sIG9wdGlvbnMpXG5cbiAgICAgICAgbGV0ICRlZGl0b3IgPSAkKCcjJyArIHNlbGVjdG9yKVxuICAgICAgICBsZXQgaGVpZ2h0ID0gb3B0aW9ucy5oZWlnaHRcbiAgICAgICAgbGV0IGZvbnRGYW1pbHkgPSBvcHRpb25zLmZvbnRGYW1pbHlcbiAgICAgICAgbGV0IGZvbnRTaXplID0gb3B0aW9ucy5mb250U2l6ZVxuXG4gICAgICAgIHRoaXMuYWRkUHJvcHMoe1xuICAgICAgICAgIGVkaXRvcjogJGVkaXRvciwgc2VsZWN0b3I6IHNlbGVjdG9yLCBvcHRpb25zOiBvcHRpb25zXG4gICAgICAgIH0pXG5cbiAgICAgICAgaWYgKGhlaWdodCkge1xuICAgICAgICAgICRlZGl0b3IuY3NzKCdoZWlnaHQnLCBoZWlnaHQgKyAncHgnKVxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKGZvbnRGYW1pbHkgfHwgZm9udFNpemUpIHtcbiAgICAgICAgICBpZiAoZm9udEZhbWlseSAmJiBmb250RmFtaWx5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICRlZGl0b3IuY3NzKCdmb250LWZhbWlseScsIGZvbnRGYW1pbHkuam9pbignLCcpKVxuICAgICAgICAgIH1cblxuICAgICAgICAgIGlmIChmb250U2l6ZSkge1xuICAgICAgICAgICAgJGVkaXRvci5jc3MoJ2ZvbnQtc2l6ZScsIGZvbnRTaXplKVxuICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgICRlZGl0b3IucGFyZW50cygnZm9ybScpLm9uKCdzdWJtaXQnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgbGV0IGZpbGVJbnB1dCA9IG9wdGlvbnMubmFtZXMuZmlsZS5pbnB1dFxuICAgICAgICAgIGxldCBmaWxlcyA9IG9wdGlvbnMuZmlsZXNcbiAgICAgICAgICBsZXQgJHBhcmFtV3JhcCA9ICQoKVxuXG4gICAgICAgICAgLy8gZmlsZXMgaW5wdXTsgq3soJwg7ZuEIOyDneyEsVxuICAgICAgICAgICRlZGl0b3IubmV4dEFsbCgnLnBhcmFtV3JhcCcpLnJlbW92ZSgpXG4gICAgICAgICAgJGVkaXRvci5hZnRlcihcIjxkaXYgY2xhc3M9J3BhcmFtV3JhcCc+XCIpXG4gICAgICAgICAgJHBhcmFtV3JhcCA9ICRlZGl0b3IubmV4dEFsbCgnLnBhcmFtV3JhcCcpXG5cbiAgICAgICAgICAvLyBmaWxlc1xuICAgICAgICAgIGlmIChmaWxlcy5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBmb3IgKGxldCBpID0gMCwgbWF4ID0gZmlsZXMubGVuZ3RoOyBpIDwgbWF4OyBpICs9IDEpIHtcbiAgICAgICAgICAgICAgbGV0IGZpbGUgPSBmaWxlc1tpXVxuXG4gICAgICAgICAgICAgICRwYXJhbVdyYXAuYXBwZW5kKFwiPGlucHV0IHR5cGU9J2hpZGRlbiduYW1lPSdcIiArIGZpbGVJbnB1dCArIFwiW10nIHZhbHVlPSdcIiArIGZpbGUuaWQgKyBcIicgLz5cIilcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9XG4gICAgICAgIH0pXG4gICAgICB9LFxuXG4gICAgICBnZXRDb250ZW50czogZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gdGhpcy5wcm9wcy5lZGl0b3IudmFsKClcbiAgICAgIH0sXG5cbiAgICAgIHNldENvbnRlbnRzOiBmdW5jdGlvbiAodGV4dCkge1xuICAgICAgICB0aGlzLnByb3BzLmVkaXRvci52YWwodGV4dClcbiAgICAgIH0sXG5cbiAgICAgIGFkZENvbnRlbnRzOiBmdW5jdGlvbiAodGV4dCkge1xuICAgICAgICB2YXIgaHRtbCA9IHRoaXMucHJvcHMuZWRpdG9yLnZhbCgpXG4gICAgICAgIHRoaXMucHJvcHMuZWRpdG9yLnZhbChodG1sKVxuICAgICAgfSxcblxuICAgICAgb246IGZ1bmN0aW9uIChldmVudE5hbWUsIGNhbGxiYWNrKSB7XG4gICAgICAgIHRoaXMucHJvcHMuZWRpdG9yLm9uKGV2ZW50TmFtZSwgY2FsbGJhY2spXG4gICAgICB9LFxuICAgICAgZ2V0Q29udGVudERvbTogZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gZmFsc2VcbiAgICAgIH0sXG4gICAgICByZXNldDogZnVuY3Rpb24gKCkge1xuICAgICAgICAvLyBjb250ZW50cyDsgq3soJxcbiAgICAgICAgdGhpcy5wcm9wcy5lZGl0b3IudmFsKCcnKS5mb2N1cygpXG5cbiAgICAgICAgLy8gaW5wdXQgaGlkZGVuIOyCreygnFxuICAgICAgICB0aGlzLnByb3BzLmVkaXRvci5uZXh0QWxsKCcucGFyYW1XcmFwJykucmVtb3ZlKClcbiAgICAgIH1cbiAgICB9XG4gIH0pXG59KVxuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDExNCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQ0Nyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDkpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyMyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDcpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEzKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTQxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNzMpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0Myk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQ2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMCk7IiwibW9kdWxlLmV4cG9ydHMgPSBfeGVfZGxsX2NvbW1vbjsiXSwic291cmNlUm9vdCI6IiJ9