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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(24);

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
/* harmony import */ var _editorValidation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./editorValidation */ "./core/editor/editorValidation.js");
/* harmony import */ var _editorInstance__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editorInstance */ "./core/editor/editorInstance.js");
/* harmony import */ var xe_utils__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! xe/utils */ "./core/utils/index.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_5__);






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
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorDefine);

    this.name = editorSettings.name;
    this.configs = editorSettings.configs;
    this.editorList = [];
    this.interfaces = {};
    Object(xe_utils__WEBPACK_IMPORTED_MODULE_4__["eventify"])(this);

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
      editorOptions = jquery__WEBPACK_IMPORTED_MODULE_5___default.a.extend(this.configs || {}, editorOptions || {});

      if (_editorValidation__WEBPACK_IMPORTED_MODULE_2__["default"].isValidBeforeCreateInstance(sel, toolInfoList, this)) {
        var editorIntance = new _editorInstance__WEBPACK_IMPORTED_MODULE_3__["default"](this.name, sel, editorOptions, toolInfoList);
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
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./errors/editor.error */ "./core/editor/errors/editor.error.js");



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
  /**
   * @class
   */

};

var EditorValidation =
/*#__PURE__*/
function () {
  function EditorValidation() {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, EditorValidation);
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(EditorValidation, null, [{
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
        throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__["EditorUndefinedContainer"]('Editor가 사용할 field를 지정해야 합니다.');
      }

      if (editorParent.editorList.length > 0) {
        var selValid = true;

        for (var i = 0, max = editorParent.editorList.length; i < max; i += 1) {
          if (editorParent.editorList[i] === sel) {
            selValid = false;
            throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__["EditorUsedContainer"]("Editor\uAC00 \uC774\uBBF8 \uC0AC\uC6A9 \uC911\uC785\uB2C8\uB2E4: ".concat(sel));
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
          throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__["EditorDefineError"]("Editor \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uAD6C\uD604 \uD544\uC694 [editorSettings: ".concat(requireOptions.editorSettings[eSettings], "])"));
        }
      }

      for (var eInterface in requireOptions.interfaces) {
        if (!interfaces.hasOwnProperty(requireOptions.interfaces[eInterface])) {
          valid = false;
          throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__["EditorDefineError"]("Editor \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uAD6C\uD604 \uD544\uC694 [interface: ".concat(requireOptions.interfaces[eInterface], "])"));
        }
      }

      if (editorSettings.hasOwnProperty('plugins') && editorSettings.plugins instanceof Array && editorSettings.plugins.length > 0 && !editorSettings.hasOwnProperty('addPlugins')) {
        valid = false;
        throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__["EditorDefineError"]("Editor \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uAD6C\uD604 \uD544\uC694 [fn:addPlugins])");
      }

      if (window.XEeditor.editorSet.hasOwnProperty(editorSettings.name)) {
        valid = false;
        throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__["EditorDefineError"]("\uC774\uBBF8 \uAC19\uC740 \uC774\uB984\uC758 \uC5D0\uB514\uD130\uAC00 \uB4F1\uB85D\uB418\uC5B4 \uC788\uC74C: ".concat(editorSettings.name));
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
          throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__["EditorToolDefineError"]("EditorTool \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uC18D\uC131\uC774 \uC5C6\uC74C: ".concat(requireOptions.tools.property[i], ")"));
        }
      }

      for (var _i = 0, _max = requireOptions.tools.events.length; _i < _max; _i += 1) {
        if (!toolDefine.events.hasOwnProperty(requireOptions.tools.events[_i])) {
          valid = false;
          throw new _errors_editor_error__WEBPACK_IMPORTED_MODULE_2__["EditorToolDefineError"]("EditorTool \uADDC\uACA9\uC774 \uB9DE\uC9C0 \uC54A\uC74C (\uC774\uBCA4\uD2B8\uAC00 \uC815\uC758\uB418\uC9C0 \uC54A\uC74C: ".concat(requireOptions.tools.events[_i], ")"));
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
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/promise */ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/getPrototypeOf */ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/get */ "./node_modules/@babel/runtime-corejs3/helpers/get.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/inherits */ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var xe_app__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! xe/app */ "./core/app.js");
/* harmony import */ var _editorDefine__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./editorDefine */ "./core/editor/editorDefine.js");
/* harmony import */ var _editorValidation__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./editorValidation */ "./core/editor/editorValidation.js");
/* harmony import */ var _editorTool__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./editorTool */ "./core/editor/editorTool.js");
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! xe */ "./core/index.js");













/**
 * @class
 * @extends App
 */

var Editor =
/*#__PURE__*/
function (_App) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_6___default()(Editor, _App);

  function Editor() {
    var _this;

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, Editor);

    _this = _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default()(this, _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(Editor).call(this));
    _this.toolsSet = {};
    _this.editorSet = {};
    _this.editorOptionSet = {};
    /**
     * @DEPRECATED
     **/

    _this.tools = {
      define: function define(obj) {
        if (jquery__WEBPACK_IMPORTED_MODULE_7___default.a.isFunction(console.warn) && jquery__WEBPACK_IMPORTED_MODULE_7___default.a.isFunction(console.trace)) {
          console.warn('DEPRECATED: XEeditor.tools.define() is deprecated. use XEeditor.defineTool');
          console.trace();
        }

        _this.defineTool(obj);
      },
      get: function get(id) {
        if (jquery__WEBPACK_IMPORTED_MODULE_7___default.a.isFunction(console.warn) && jquery__WEBPACK_IMPORTED_MODULE_7___default.a.isFunction(console.trace)) {
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
        return _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0___default.a.resolve(this);
      }

      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0___default.a(function (resolve) {
        _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_5___default()(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(Editor.prototype), "boot", _this2).call(_this2, XE);

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
        if (_editorValidation__WEBPACK_IMPORTED_MODULE_10__["default"].isValidEditorOptions(editorSettings, interfaces)) {
          var editor = new _editorDefine__WEBPACK_IMPORTED_MODULE_9__["default"](editorSettings, interfaces);
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
        return _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0___default.a.resolve(this.editorSet[name]);
      }

      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0___default.a(function (resolve) {
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
        if (_editorValidation__WEBPACK_IMPORTED_MODULE_10__["default"].isValidToolsObject(obj)) {
          this.toolsSet[obj.id] = new _editorTool__WEBPACK_IMPORTED_MODULE_11__["default"](obj);
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
      return jquery__WEBPACK_IMPORTED_MODULE_7___default()(content).attr('xe-tool-id', id).clone().wrapAll('<div/>').parent().html();
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
}(xe_app__WEBPACK_IMPORTED_MODULE_8__["default"]);
/**
 * @type       {Editor}
 */


var XEeditor = new Editor();
if (!window.XEeditor) window.XEeditor = XEeditor;
xe__WEBPACK_IMPORTED_MODULE_12__["default"].registerApp('Editor', XEeditor);
/* harmony default export */ __webpack_exports__["default"] = (Editor);

/***/ }),

/***/ "./core/editor/textarea.define.js":
/*!****************************************!*\
  !*** ./core/editor/textarea.define.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! xe */ "./core/index.js");


xe__WEBPACK_IMPORTED_MODULE_1__["default"].app('Editor', function (Editor) {
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
        options = jquery__WEBPACK_IMPORTED_MODULE_0___default.a.extend(true, {
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
        var $editor = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#' + selector);
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
          var $paramWrap = jquery__WEBPACK_IMPORTED_MODULE_0___default()(); // files input삭제 후 생성

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(67);

/***/ }),

/***/ "./core/index.js":
/*!*******************************************************************!*\
  !*** delegated ./core/index.js from dll-reference _xe_dll_common ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(270);

/***/ }),

/***/ "./core/utils/index.js":
/*!*************************************************************************!*\
  !*** delegated ./core/utils/index.js from dll-reference _xe_dll_common ***!
  \*************************************************************************/
/*! exports provided: EventEmitter, curry, debounce, find, forEach, mapValues, throttle, trim, trimEnd, trimStart, setBaseURL, eventify, isImage, isVideo, isAudio, formatSizeUnits, sizeFormatToBytes, isURL, asset, openWindow, getUri, addCommas, strtotime */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(3);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(2);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js":
/*!****************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/createClass.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(7);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/get.js":
/*!********************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/get.js from dll-reference _xe_dll_common ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(16);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(5);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js":
/*!*************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/inherits.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(11);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js":
/*!******************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(10);

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

__webpack_require__(/*! /Users/bnu/dev/xpressengine/resources/assets/core/editor/index */"./core/editor/index.js");
module.exports = __webpack_require__(/*! /Users/bnu/dev/xpressengine/resources/assets/core/editor/textarea.define.js */"./core/editor/textarea.define.js");


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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvYXBwLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9jb3JlL2VkaXRvci9lZGl0b3JEZWZpbmUuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvZWRpdG9ySW5zdGFuY2UuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvZWRpdG9yVG9vbC5qcyIsIndlYnBhY2s6Ly8vLi9jb3JlL2VkaXRvci9lZGl0b3JWYWxpZGF0aW9uLmpzIiwid2VicGFjazovLy8uL2NvcmUvZWRpdG9yL2Vycm9ycy9lZGl0b3IuZXJyb3IuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvaW5kZXguanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvdGV4dGFyZWEuZGVmaW5lLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9jb3JlL2Vycm9yL2luZGV4LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vY29yZS9pbmRleC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvdXRpbHMvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9wcm9taXNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jbGFzc0NhbGxDaGVjay5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvY3JlYXRlQ2xhc3MuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2dldC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvZ2V0UHJvdG90eXBlT2YuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2luaGVyaXRzLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9wb3NzaWJsZUNvbnN0cnVjdG9yUmV0dXJuLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2pxdWVyeS9zcmMvanF1ZXJ5LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZXh0ZXJuYWwgXCJfeGVfZGxsX2NvbW1vblwiIl0sIm5hbWVzIjpbIkVkaXRvckRlZmluZSIsImVkaXRvclNldHRpbmdzIiwiaW50ZXJmYWNlcyIsIm5hbWUiLCJjb25maWdzIiwiZWRpdG9yTGlzdCIsImV2ZW50aWZ5IiwiaGFzT3duUHJvcGVydHkiLCJwbHVnaW5zIiwiQXJyYXkiLCJsZW5ndGgiLCJhZGRQbHVnaW5zIiwibyIsInNlbCIsIm9wdGlvbnMiLCJlZGl0b3JPcHRpb25zIiwidG9vbEluZm9MaXN0IiwiJCIsImV4dGVuZCIsIkVkaXRvclZhbGlkYXRpb24iLCJpc1ZhbGlkQmVmb3JlQ3JlYXRlSW5zdGFuY2UiLCJlZGl0b3JJbnRhbmNlIiwiRWRpdG9ySW5zdGFuY2UiLCJfZWRpdG9yIiwiaW5pdGlhbGl6ZSIsImNhbGwiLCJ0b29scyIsInRvb2xJbmZvTGlzdEZpbHRlciIsImkiLCJtYXgiLCJ3aW5kb3ciLCJYRWVkaXRvciIsImdldFRvb2wiLCJpZCIsInB1c2giLCJjb25zb2xlIiwiZXJyb3IiLCJhZGRUb29scyIsImVkaXRvck5hbWUiLCJfb3B0aW9ucyIsInNlbGVjdG9yIiwicHJvcHMiLCJnZXRPcHRpb25zIiwiZWRpdG9yU2V0IiwiZ2V0Q29udGVudHMiLCJ0ZXh0Iiwic2V0Q29udGVudHMiLCJhZGRDb250ZW50cyIsIm9iaiIsInRvb2xJbnN0YW5jZUxpc3QiLCJldmVudE5hbWUiLCJjYWxsYmFjayIsIm9uIiwiY3VzdG9tT3B0aW9ucyIsInJlbmRlckZpbGVVcGxvYWRlciIsImdldENvbnRlbnREb20iLCJyZXNldCIsIkVkaXRvclRvb2wiLCJyZXF1aXJlT3B0aW9ucyIsInByb3BlcnR5IiwiZXZlbnRzIiwidG9vbElkTGlzdCIsImVkaXRvclBhcmVudCIsIkVkaXRvclVuZGVmaW5lZENvbnRhaW5lciIsInNlbFZhbGlkIiwiRWRpdG9yVXNlZENvbnRhaW5lciIsInZhbGlkIiwiZVNldHRpbmdzIiwiRWRpdG9yRGVmaW5lRXJyb3IiLCJlSW50ZXJmYWNlIiwidG9vbERlZmluZSIsIkVkaXRvclRvb2xEZWZpbmVFcnJvciIsIm1lc3NhZ2UiLCJYZUVycm9yIiwiRWRpdG9yIiwidG9vbHNTZXQiLCJlZGl0b3JPcHRpb25TZXQiLCJkZWZpbmUiLCJpc0Z1bmN0aW9uIiwid2FybiIsInRyYWNlIiwiZGVmaW5lVG9vbCIsImdldCIsIlhFIiwiYm9vdGVkIiwicmVzb2x2ZSIsImlzVmFsaWRFZGl0b3JPcHRpb25zIiwiZWRpdG9yIiwiJCRlbWl0IiwiZSIsIiQkb24iLCJpc1ZhbGlkVG9vbHNPYmplY3QiLCJjb250ZW50IiwiYXR0ciIsImNsb25lIiwid3JhcEFsbCIsInBhcmVudCIsImh0bWwiLCJBcHAiLCJyZWdpc3RlckFwcCIsImFwcCIsImZpbGVVcGxvYWQiLCJzdWdnZXN0aW9uIiwibmFtZXMiLCJmaWxlIiwiaW1hZ2UiLCJ0YWciLCJtZW50aW9uIiwiZXh0ZW5zaW9ucyIsImZvbnRGYW1pbHkiLCJwZXJtcyIsImZpbGVzIiwiJGVkaXRvciIsImhlaWdodCIsImZvbnRTaXplIiwiYWRkUHJvcHMiLCJjc3MiLCJqb2luIiwicGFyZW50cyIsImZpbGVJbnB1dCIsImlucHV0IiwiJHBhcmFtV3JhcCIsIm5leHRBbGwiLCJyZW1vdmUiLCJhZnRlciIsImFwcGVuZCIsInZhbCIsImZvY3VzIl0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7OztBQUdBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxrREFBMEMsZ0NBQWdDO0FBQzFFO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsZ0VBQXdELGtCQUFrQjtBQUMxRTtBQUNBLHlEQUFpRCxjQUFjO0FBQy9EOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpREFBeUMsaUNBQWlDO0FBQzFFLHdIQUFnSCxtQkFBbUIsRUFBRTtBQUNySTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLG1DQUEyQiwwQkFBMEIsRUFBRTtBQUN2RCx5Q0FBaUMsZUFBZTtBQUNoRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQSw4REFBc0QsK0RBQStEOztBQUVySDtBQUNBOzs7QUFHQTtBQUNBOzs7Ozs7Ozs7Ozs7QUNsRkEsK0c7Ozs7Ozs7Ozs7Ozs7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LE1BQVgsQ0FBa0J1QyxHQUFsQixDQUFzQmpGLElBQXRCO0FBQ0QsT0FwRVM7QUFzRVZFLGlCQUFXLEVBQUUscUJBQVVGLElBQVYsRUFBZ0I7QUFDM0IsWUFBSW9ELElBQUksR0FBRyxLQUFLeEQsS0FBTCxDQUFXOEMsTUFBWCxDQUFrQnVDLEdBQWxCLEVBQVg7QUFDQSxhQUFLckYsS0FBTCxDQUFXOEMsTUFBWCxDQUFrQnVDLEdBQWxCLENBQXNCN0IsSUFBdEI7QUFDRCxPQXpFUztBQTJFVjdDLFFBQUUsRUFBRSxZQUFVRixTQUFWLEVBQXFCQyxRQUFyQixFQUErQjtBQUNqQyxhQUFLVixLQUFMLENBQVc4QyxNQUFYLENBQWtCbkMsRUFBbEIsQ0FBcUJGLFNBQXJCLEVBQWdDQyxRQUFoQztBQUNELE9BN0VTO0FBOEVWSSxtQkFBYSxFQUFFLHlCQUFZO0FBQ3pCLGVBQU8sS0FBUDtBQUNELE9BaEZTO0FBaUZWQyxXQUFLLEVBQUUsaUJBQVk7QUFDakI7QUFDQSxhQUFLZixLQUFMLENBQVc4QyxNQUFYLENBQWtCdUMsR0FBbEIsQ0FBc0IsRUFBdEIsRUFBMEJDLEtBQTFCLEdBRmlCLENBSWpCOztBQUNBLGFBQUt0RixLQUFMLENBQVc4QyxNQUFYLENBQWtCbUMsT0FBbEIsQ0FBMEIsWUFBMUIsRUFBd0NDLE1BQXhDO0FBQ0Q7QUF2RlM7QUFoQ0EsR0FBZDtBQTBIRCxDQTNIRCxFOzs7Ozs7Ozs7OztBQ0hBLCtHOzs7Ozs7Ozs7OztBQ0FBLGdIOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9lZGl0b3IvZWRpdG9yLmJ1bmRsZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSAxKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyNCk7IiwiaW1wb3J0IEVkaXRvclZhbGlkYXRpb24gZnJvbSAnLi9lZGl0b3JWYWxpZGF0aW9uJ1xuaW1wb3J0IEVkaXRvckluc3RhbmNlIGZyb20gJy4vZWRpdG9ySW5zdGFuY2UnXG5pbXBvcnQgeyBldmVudGlmeSB9IGZyb20gJ3hlL3V0aWxzJ1xuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuXG4vKipcbiAqIEBjbGFzc1xuICovXG5jbGFzcyBFZGl0b3JEZWZpbmUge1xuICAvKipcbiAgICogQHBhcmFtIHtvYmplY3R9IGVkaXRvclNldHRpbmdzXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBpbnRlcmZhY2VzXG4gICAqL1xuICBjb25zdHJ1Y3RvciAoZWRpdG9yU2V0dGluZ3MsIGludGVyZmFjZXMpIHtcbiAgICB0aGlzLm5hbWUgPSBlZGl0b3JTZXR0aW5ncy5uYW1lXG4gICAgdGhpcy5jb25maWdzID0gZWRpdG9yU2V0dGluZ3MuY29uZmlnc1xuICAgIHRoaXMuZWRpdG9yTGlzdCA9IFtdXG4gICAgdGhpcy5pbnRlcmZhY2VzID0ge31cblxuICAgIGV2ZW50aWZ5KHRoaXMpXG5cbiAgICBpZiAoZWRpdG9yU2V0dGluZ3MuaGFzT3duUHJvcGVydHkoJ3BsdWdpbnMnKSAmJlxuICAgICAgZWRpdG9yU2V0dGluZ3MucGx1Z2lucyBpbnN0YW5jZW9mIEFycmF5ICYmXG4gICAgICBlZGl0b3JTZXR0aW5ncy5wbHVnaW5zLmxlbmd0aCA+IDAgJiZcbiAgICAgIGVkaXRvclNldHRpbmdzLmhhc093blByb3BlcnR5KCdhZGRQbHVnaW5zJykpIHtcbiAgICAgIGVkaXRvclNldHRpbmdzLmFkZFBsdWdpbnMoZWRpdG9yU2V0dGluZ3MucGx1Z2lucylcbiAgICB9XG5cbiAgICBmb3IgKHZhciBvIGluIGludGVyZmFjZXMpIHtcbiAgICAgIHRoaXNbb10gPSBpbnRlcmZhY2VzW29dXG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIOyXkOuUlO2EsOulvCDsg53shLEg67CPIO2ItOydhCDstpTqsIDtlZzri6QuXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBzZWwgc2VsZWN0b3JcbiAgICogQHBhcmFtIHtvYmplY3R9IG9wdGlvbnNcbiAgICogQHBhcmFtIHtvYmplY3R9IGVkaXRvck9wdGlvbnNcbiAgICogQHBhcmFtIHthcnJheX0gdG9vbEluZm9MaXN0XG4gICAqL1xuICBjcmVhdGUgKHNlbCwgb3B0aW9ucywgZWRpdG9yT3B0aW9ucywgdG9vbEluZm9MaXN0KSB7XG4gICAgdG9vbEluZm9MaXN0ID0gdG9vbEluZm9MaXN0IHx8IFtdXG4gICAgZWRpdG9yT3B0aW9ucyA9ICQuZXh0ZW5kKHRoaXMuY29uZmlncyB8fCB7fSwgZWRpdG9yT3B0aW9ucyB8fCB7fSlcblxuICAgIGlmIChFZGl0b3JWYWxpZGF0aW9uLmlzVmFsaWRCZWZvcmVDcmVhdGVJbnN0YW5jZShzZWwsIHRvb2xJbmZvTGlzdCwgdGhpcykpIHtcbiAgICAgIGNvbnN0IGVkaXRvckludGFuY2UgPSBuZXcgRWRpdG9ySW5zdGFuY2UodGhpcy5uYW1lLCBzZWwsIGVkaXRvck9wdGlvbnMsIHRvb2xJbmZvTGlzdClcbiAgICAgIGVkaXRvckludGFuY2UuX2VkaXRvciA9IHRoaXNcbiAgICAgIHRoaXMuZWRpdG9yTGlzdFtzZWxdID0gZWRpdG9ySW50YW5jZVxuICAgICAgdGhpcy5pbml0aWFsaXplLmNhbGwodGhpcy5lZGl0b3JMaXN0W3NlbF0sIHNlbCwgb3B0aW9ucywgZWRpdG9yT3B0aW9ucylcblxuICAgICAgaWYgKCEhdG9vbEluZm9MaXN0ICYmIHRvb2xJbmZvTGlzdC5sZW5ndGggPiAwKSB7XG4gICAgICAgIGxldCB0b29scyA9IHt9XG4gICAgICAgIGxldCB0b29sSW5mb0xpc3RGaWx0ZXIgPSBbXVxuXG4gICAgICAgIGZvciAobGV0IGkgPSAwLCBtYXggPSB0b29sSW5mb0xpc3QubGVuZ3RoOyBpIDwgbWF4OyBpICs9IDEpIHtcbiAgICAgICAgICBpZiAod2luZG93LlhFZWRpdG9yLmdldFRvb2wodG9vbEluZm9MaXN0W2ldLmlkKSkge1xuICAgICAgICAgICAgdG9vbHNbdG9vbEluZm9MaXN0W2ldLmlkXSA9IHdpbmRvdy5YRWVkaXRvci5nZXRUb29sKHRvb2xJbmZvTGlzdFtpXS5pZClcbiAgICAgICAgICAgIHRvb2xJbmZvTGlzdEZpbHRlci5wdXNoKHRvb2xJbmZvTGlzdFtpXSlcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgY29uc29sZS5lcnJvcignZGVmaW5l65CcIHRvb2zsnbQg7KG07J6s7ZWY7KeAIOyViuydjC4gWycgKyB0b29sSW5mb0xpc3RbaV0uaWQgKyAnXScpXG4gICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKHRoaXMuYWRkVG9vbHMgJiYgdHlwZW9mIHRoaXMuYWRkVG9vbHMgPT09ICdmdW5jdGlvbicpIHtcbiAgICAgICAgICB0aGlzLmFkZFRvb2xzLmNhbGwodGhpcy5lZGl0b3JMaXN0W3NlbF0sIHRvb2xzLCB0b29sSW5mb0xpc3RGaWx0ZXIpXG4gICAgICAgIH1cbiAgICAgIH1cblxuICAgICAgcmV0dXJuIHRoaXMuZWRpdG9yTGlzdFtzZWxdXG4gICAgfVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IEVkaXRvckRlZmluZVxuIiwiaW1wb3J0IHsgZXZlbnRpZnkgfSBmcm9tICd4ZS11dGlscycgLy8gQEZJWE1FIGh0dHBzOi8vZ2l0aHViLmNvbS94cHJlc3NlbmdpbmUveHByZXNzZW5naW5lL2lzc3Vlcy83NjVcbmltcG9ydCAkIGZyb20gJ2pxdWVyeSdcblxuLyoqXG4gKiBAY2xhc3NcbiAqL1xuY2xhc3MgRWRpdG9ySW5zdGFuY2Uge1xuICAvKipcbiAgICogQGNvbnN0cnVjdG9yXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBlZGl0b3JOYW1lXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBzZWwgc2VsZWN0b3JcbiAgICogQHBhcmFtIHtvYmplY3R9IGVkaXRvck9wdGlvbnNcbiAgICogQHBhcmFtIHthcnJheX0gdG9vbEluZm9MaXN0IOyXkOuUlO2EsOyXkCDstpTqsIDrkKAgdG9vbCDsoJXrs7Qg66as7Iqk7Yq4XG4gICAqL1xuICBjb25zdHJ1Y3RvciAoZWRpdG9yTmFtZSwgc2VsLCBlZGl0b3JPcHRpb25zLCB0b29sSW5mb0xpc3QpIHtcbiAgICAvKiogQHByaXZhdGUgKi9cbiAgICBsZXQgX29wdGlvbnMgPSB7XG4gICAgICBlZGl0b3JPcHRpb25zOiBlZGl0b3JPcHRpb25zLFxuICAgICAgdG9vbEluZm9MaXN0OiB0b29sSW5mb0xpc3RcbiAgICB9XG5cbiAgICBldmVudGlmeSh0aGlzKVxuXG4gICAgLyoqIEBwdWJsaWMgKi9cbiAgICB0aGlzLmVkaXRvck5hbWUgPSBlZGl0b3JOYW1lXG4gICAgLyoqIEBwdWJsaWMgKi9cbiAgICB0aGlzLnNlbGVjdG9yID0gc2VsXG4gICAgLyoqIEBwdWJsaWMgKi9cbiAgICB0aGlzLnByb3BzID0ge31cbiAgICAvKipcbiAgICAgKiDsl5DrlJTthLAg7Ji17IWY7J2EIOuwmO2ZmO2VnOuLpC5cbiAgICAgKiBAcHVibGljXG4gICAgICogQG1ldGhvZFxuICAgICAqL1xuICAgIHRoaXMuZ2V0T3B0aW9ucyA9IGZ1bmN0aW9uICgpIHtcbiAgICAgIHJldHVybiBfb3B0aW9uc1xuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDsg53shLHrkJwgaW5zdGFuY2Xrpbwg67CY7ZmY7ZWc64ukSW5zdGFuY2VPYmouXG4gICAqIEBtZXRob2RcbiAgICogQHJldHVybiB7b2JqZWN0fVxuICAgKi9cbiAgZ2V0SW5zdGFuY2UgKCkge1xuICAgIHJldHVybiB0aGlzXG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw7JeQIOyekeyEseuQnCDsu6jthZDsuKDrpbwg67CY7ZmY7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEByZXR1cm4ge3N0cmluZ31cbiAgICovXG4gIGdldENvbnRlbnRzICgpIHtcbiAgICByZXR1cm4gWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0uZ2V0Q29udGVudHMuY2FsbCh0aGlzKVxuICB9XG5cbiAgLyoqXG4gICAqIOyXkOuUlO2EsOyXkCDrgrTsmqnsnYQg7J6F66Cl7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB0ZXh0XG4gICAqL1xuICBzZXRDb250ZW50cyAodGV4dCkge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLnNldENvbnRlbnRzLmNhbGwodGhpcywgdGV4dClcbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDsl5Ag64K07Jqp7J2EIOyeheugpe2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge3N0cmluZ30gdGV4dFxuICAgKi9cbiAgYWRkQ29udGVudHMgKHRleHQpIHtcbiAgICBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5hZGRDb250ZW50cy5jYWxsKHRoaXMsIHRleHQpXG4gIH1cblxuICAvKipcbiAgICog7IOd7ISx65CcIGluc3RhbmNl7JeQIHByb3BlcnR566W8IOuTseuhne2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge29iamVjdH0gb2JqXG4gICAqL1xuICBhZGRQcm9wcyAob2JqKSB7XG4gICAgZm9yICh2YXIgbyBpbiBvYmopIHtcbiAgICAgIHRoaXMucHJvcHNbb10gPSBvYmpbb11cbiAgICB9XG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw7JeQIO2ItOydhCDstpTqsIDtlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHthcnJheX0gdG9vbEluc3RhbmNlTGlzdFxuICAgKi9cbiAgYWRkVG9vbHMgKHRvb2xJbnN0YW5jZUxpc3QpIHtcbiAgICBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5hZGRUb29scy5jYWxsKHRoaXMsIHRoaXMuZ2V0T3B0aW9ucygpLnRvb2xJbmZvTGlzdCwgdG9vbEluc3RhbmNlTGlzdClcbiAgfVxuXG4gIC8qKlxuICAgKiDqtaztmITrkJwg7JeQ65SU7YSw7JeQIOydtOuypO2KuOulvCDtlaDri7ntlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHtzdHJpbmd9IGV2ZW50TmFtZVxuICAgKiBAcGFyYW0ge2Z1bmN0aW9ufSBjYWxsYmFjayBldmVudCBjYWxsYmFja1xuICAgKi9cbiAgb24gKGV2ZW50TmFtZSwgY2FsbGJhY2spIHtcbiAgICBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5vbi5jYWxsKHRoaXMsIGV2ZW50TmFtZSwgY2FsbGJhY2spXG4gIH1cblxuICAvKipcbiAgICog6rWs7ZiE65CcIOyXkOuUlO2EsCDtjIzsnbwg7JeF66Gc65OcIOq4sOuKpeydhCDtmLjstqPtlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHtvYmplY3R9IGN1c3RvbU9wdGlvbnNcbiAgICovXG4gIHJlbmRlckZpbGVVcGxvYWRlciAoY3VzdG9tT3B0aW9ucykge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLnJlbmRlckZpbGVVcGxvYWRlci5jYWxsKHRoaXMsIGN1c3RvbU9wdGlvbnMpXG4gIH1cblxuICBnZXRDb250ZW50RG9tICgpIHtcbiAgICBpZiAodHlwZW9mIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLmdldENvbnRlbnREb20gPT09ICdmdW5jdGlvbicpIHtcbiAgICAgIHJldHVybiBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5nZXRDb250ZW50RG9tLmNhbGwodGhpcylcbiAgICB9XG4gICAgcmV0dXJuIGZhbHNlXG4gIH1cblxuICAvKipcbiAgICog6rWs7ZiE65CcIOyXkOuUlO2EsCByZXNldCDtlajsiJjrpbwg7Zi47Lac7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBjdXN0b21PcHRpb25zXG4gICAqL1xuICByZXNldCAoKSB7XG4gICAgWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0ucmVzZXQuY2FsbCh0aGlzKVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IEVkaXRvckluc3RhbmNlXG4iLCIvKipcbiAqIEBjbGFzc1xuICovXG5jbGFzcyBFZGl0b3JUb29sIHtcbiAgY29uc3RydWN0b3IgKG9iaikge1xuICAgIGZvciAobGV0IG8gaW4gb2JqKSB7XG4gICAgICB0aGlzW29dID0gb2JqW29dXG4gICAgfVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IEVkaXRvclRvb2xcbiIsImltcG9ydCB7IEVkaXRvckRlZmluZUVycm9yLCBFZGl0b3JUb29sRGVmaW5lRXJyb3IsIEVkaXRvclVzZWRDb250YWluZXIsIEVkaXRvclVuZGVmaW5lZENvbnRhaW5lciB9IGZyb20gJy4vZXJyb3JzL2VkaXRvci5lcnJvcidcblxuLyoqXG4gKiBAcHJpdmF0ZVxuICovXG5jb25zdCByZXF1aXJlT3B0aW9ucyA9IHtcbiAgZWRpdG9yU2V0dGluZ3M6IFtcbiAgICAnbmFtZSdcbiAgXSxcbiAgaW50ZXJmYWNlczogW1xuICAgICdpbml0aWFsaXplJyxcbiAgICAnYWRkQ29udGVudHMnLFxuICAgICdnZXRDb250ZW50cycsXG4gICAgJ3NldENvbnRlbnRzJyxcbiAgICAnZ2V0Q29udGVudERvbSdcbiAgXSxcbiAgdG9vbHM6IHtcbiAgICBwcm9wZXJ0eTogW1xuICAgICAgJ2lkJyxcbiAgICAgICdldmVudHMnXG4gICAgXSxcbiAgICBldmVudHM6IFtcbiAgICAgICdpY29uQ2xpY2snLFxuICAgICAgJ2VsZW1lbnREb3VibGVDbGljaydcbiAgICBdXG4gIH1cbn1cblxuLyoqXG4gKiBAY2xhc3NcbiAqL1xuY2xhc3MgRWRpdG9yVmFsaWRhdGlvbiB7XG4gIC8qKlxuICAgKiBFZGl0b3LsnZggaW5zdGFuY2Xrpbwg7IOd7ISx7ZWY6riwIOyghCDspJHrs7Ug6rKA7IKsIOuTsSDsiJjtlolcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbCBqUXVlcnkgc2VsZWN0b3JcbiAgICogQHBhcmFtIHthcnJheX0gdG9vbElkTGlzdFxuICAgKiBAcGFyYW0ge29iamVjdH0gZWRpdG9yUGFyZW50XG4gICAqIEByZXR1cm4ge2Jvb2xlYW59XG4gICAqIEB0aHJvd3Mge0VkaXRvclVuZGVmaW5lZENvbnRhaW5lcn1cbiAgICogQHRocm93cyB7RWRpdG9yVXNlZENvbnRhaW5lcn1cbiAgICovXG4gIHN0YXRpYyBpc1ZhbGlkQmVmb3JlQ3JlYXRlSW5zdGFuY2UgKHNlbCwgdG9vbElkTGlzdCwgZWRpdG9yUGFyZW50KSB7XG4gICAgaWYgKCFzZWwpIHtcbiAgICAgIC8vIHNlbGVjdG9y6rCAIOyXhuydjFxuICAgICAgdGhyb3cgbmV3IEVkaXRvclVuZGVmaW5lZENvbnRhaW5lcignRWRpdG9y6rCAIOyCrOyaqe2VoCBmaWVsZOulvCDsp4DsoJXtlbTslbwg7ZWp64uI64ukLicpXG4gICAgfVxuXG4gICAgaWYgKGVkaXRvclBhcmVudC5lZGl0b3JMaXN0Lmxlbmd0aCA+IDApIHtcbiAgICAgIGxldCBzZWxWYWxpZCA9IHRydWVcbiAgICAgIGZvciAobGV0IGkgPSAwLCBtYXggPSBlZGl0b3JQYXJlbnQuZWRpdG9yTGlzdC5sZW5ndGg7IGkgPCBtYXg7IGkgKz0gMSkge1xuICAgICAgICBpZiAoZWRpdG9yUGFyZW50LmVkaXRvckxpc3RbaV0gPT09IHNlbCkge1xuICAgICAgICAgIHNlbFZhbGlkID0gZmFsc2VcbiAgICAgICAgICB0aHJvdyBuZXcgRWRpdG9yVXNlZENvbnRhaW5lcihgRWRpdG9y6rCAIOydtOuvuCDsgqzsmqkg7KSR7J6F64uI64ukOiAke3NlbH1gKVxuICAgICAgICB9XG4gICAgICB9XG5cbiAgICAgIGlmICghc2VsVmFsaWQpIHtcbiAgICAgICAgcmV0dXJuIGZhbHNlXG4gICAgICB9XG4gICAgfVxuXG4gICAgcmV0dXJuIHRydWVcbiAgfVxuXG4gIC8qKlxuICAgKiBAdHlwZWRlZiB7T2JqZWN0fSBlZGl0b3JEZWZpbml0aW9uXG4gICAqIEBwcm9wZXJ0eSB7b2JqZWN0fSBlZGl0b3JEZWZpbml0aW9uLmVkaXRvclNldHRpbmdzIOyXkOuUlO2EsCDshKTsoJUg7KCV67O0XG4gICAqIEBwcm9wZXJ0eSB7c3RyaW5nfSBlZGl0b3JEZWZpbml0aW9uLmVkaXRvclNldHRpbmdzLm5hbWUg7JeQ65SU7YSwIOyEpOyglSDsoJXrs7RcbiAgICogQHByb3BlcnR5IHtvYmplY3R9IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcyDqtaztmITrkJwg7JeQ65SU7YSwIOyduO2EsO2OmOydtOyKpFxuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXMuaW5pdGlhbGl6ZVxuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXMuYWRkQ29udGVudHNcbiAgICogQHByb3BlcnR5IHtmdW5jdGlvbn0gZWRpdG9yRGVmaW5pdGlvbi5pbnRlcmZhY2VzLmdldENvbnRlbnRzXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcy5zZXRDb250ZW50c1xuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXMuZ2V0Q29udGVudERvbVxuICAgKi9cblxuICAvKipcbiAgICogRWRpdG9yIOygleydmOqwgCDsmKzrsJTrpbjsp4Ag6rKA7IKsXG4gICAqIEBwYXJhbSB7ZWRpdG9yRGVmaW5pdGlvbi5lZGl0b3JTZXR0aW5nc30gZWRpdG9yU2V0dGluZ3NcbiAgICogQHBhcmFtIHtlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXN9IGludGVyZmFjZXNcbiAgICogQHJldHVybiB7Ym9vbGVhbn1cbiAgICogQHRocm93cyB7RWRpdG9yRGVmaW5lRXJyb3J9XG4gICAqL1xuICBzdGF0aWMgaXNWYWxpZEVkaXRvck9wdGlvbnMgKGVkaXRvclNldHRpbmdzLCBpbnRlcmZhY2VzKSB7XG4gICAgbGV0IHZhbGlkID0gdHJ1ZVxuICAgIGZvciAobGV0IGVTZXR0aW5ncyBpbiByZXF1aXJlT3B0aW9ucy5lZGl0b3JTZXR0aW5ncykge1xuICAgICAgaWYgKCFlZGl0b3JTZXR0aW5ncy5oYXNPd25Qcm9wZXJ0eShyZXF1aXJlT3B0aW9ucy5lZGl0b3JTZXR0aW5nc1tlU2V0dGluZ3NdKSkge1xuICAgICAgICB2YWxpZCA9IGZhbHNlXG4gICAgICAgIHRocm93IG5ldyBFZGl0b3JEZWZpbmVFcnJvcihgRWRpdG9yIOq3nOqyqeydtCDrp57sp4Ag7JWK7J2MICjqtaztmIQg7ZWE7JqUIFtlZGl0b3JTZXR0aW5nczogJHtyZXF1aXJlT3B0aW9ucy5lZGl0b3JTZXR0aW5nc1tlU2V0dGluZ3NdfV0pYClcbiAgICAgIH1cbiAgICB9XG5cbiAgICBmb3IgKGxldCBlSW50ZXJmYWNlIGluIHJlcXVpcmVPcHRpb25zLmludGVyZmFjZXMpIHtcbiAgICAgIGlmICghaW50ZXJmYWNlcy5oYXNPd25Qcm9wZXJ0eShyZXF1aXJlT3B0aW9ucy5pbnRlcmZhY2VzW2VJbnRlcmZhY2VdKSkge1xuICAgICAgICB2YWxpZCA9IGZhbHNlXG4gICAgICAgIHRocm93IG5ldyBFZGl0b3JEZWZpbmVFcnJvcihgRWRpdG9yIOq3nOqyqeydtCDrp57sp4Ag7JWK7J2MICjqtaztmIQg7ZWE7JqUIFtpbnRlcmZhY2U6ICR7cmVxdWlyZU9wdGlvbnMuaW50ZXJmYWNlc1tlSW50ZXJmYWNlXX1dKWApXG4gICAgICB9XG4gICAgfVxuXG4gICAgaWYgKGVkaXRvclNldHRpbmdzLmhhc093blByb3BlcnR5KCdwbHVnaW5zJykgJiZcbiAgICAgIGVkaXRvclNldHRpbmdzLnBsdWdpbnMgaW5zdGFuY2VvZiBBcnJheSAmJlxuICAgICAgZWRpdG9yU2V0dGluZ3MucGx1Z2lucy5sZW5ndGggPiAwICYmXG4gICAgICAhZWRpdG9yU2V0dGluZ3MuaGFzT3duUHJvcGVydHkoJ2FkZFBsdWdpbnMnKSkge1xuICAgICAgdmFsaWQgPSBmYWxzZVxuICAgICAgdGhyb3cgbmV3IEVkaXRvckRlZmluZUVycm9yKGBFZGl0b3Ig6rec6rKp7J20IOunnuyngCDslYrsnYwgKOq1rO2YhCDtlYTsmpQgW2ZuOmFkZFBsdWdpbnNdKWApXG4gICAgfVxuXG4gICAgaWYgKHdpbmRvdy5YRWVkaXRvci5lZGl0b3JTZXQuaGFzT3duUHJvcGVydHkoZWRpdG9yU2V0dGluZ3MubmFtZSkpIHtcbiAgICAgIHZhbGlkID0gZmFsc2VcbiAgICAgIHRocm93IG5ldyBFZGl0b3JEZWZpbmVFcnJvcihg7J2066+4IOqwmeydgCDsnbTrpoTsnZgg7JeQ65SU7YSw6rCAIOuTseuhneuQmOyWtCDsnojsnYw6ICR7ZWRpdG9yU2V0dGluZ3MubmFtZX1gKVxuICAgIH1cblxuICAgIHJldHVybiAhKCF2YWxpZClcbiAgfVxuXG4gIC8qKlxuICAgKiBAdHlwZWRlZiB7T2JqZWN0fSBlZGl0b3JUb29sRGVmaW5pdGlvblxuICAgKiBAcHJvcGVydHkge3N0cmluZ30gaWRcbiAgICogQHByb3BlcnR5IHtvYmplY3R9IGV2ZW50c1xuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBldmVudHMuaWNvbkNsaWNrXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGV2ZW50cy5lbGVtZW50RG91YmxlQ2xpY2tcbiAgICogQGRlcHJlY2F0ZWRcbiAgICovXG5cbiAgLyoqXG4gICAqIEVkaXRvclRvb2wg7KCV7J2Y6rCAIOyYrOuwlOuluOyngCDqsoDsgqxcbiAgICogQHBhcmFtIHtlZGl0b3JUb29sRGVmaW5pdGlvbn0gdG9vbERlZmluZVxuICAgKiBAcmV0dXJuIHtib29sZWFufVxuICAgKiBAdGhyb3dzIHtFZGl0b3JUb29sRGVmaW5lRXJyb3J9XG4gICAqL1xuICBzdGF0aWMgaXNWYWxpZFRvb2xzT2JqZWN0ICh0b29sRGVmaW5lKSB7XG4gICAgbGV0IHZhbGlkID0gdHJ1ZVxuXG4gICAgZm9yIChsZXQgaSA9IDAsIG1heCA9IHJlcXVpcmVPcHRpb25zLnRvb2xzLnByb3BlcnR5Lmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICBpZiAoIXRvb2xEZWZpbmUuaGFzT3duUHJvcGVydHkocmVxdWlyZU9wdGlvbnMudG9vbHMucHJvcGVydHlbaV0pKSB7XG4gICAgICAgIHZhbGlkID0gZmFsc2VcbiAgICAgICAgdGhyb3cgbmV3IEVkaXRvclRvb2xEZWZpbmVFcnJvcihgRWRpdG9yVG9vbCDqt5zqsqnsnbQg66ee7KeAIOyViuydjCAo7IaN7ISx7J20IOyXhuydjDogJHtyZXF1aXJlT3B0aW9ucy50b29scy5wcm9wZXJ0eVtpXX0pYClcbiAgICAgIH1cbiAgICB9XG5cbiAgICBmb3IgKGxldCBpID0gMCwgbWF4ID0gcmVxdWlyZU9wdGlvbnMudG9vbHMuZXZlbnRzLmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICBpZiAoIXRvb2xEZWZpbmUuZXZlbnRzLmhhc093blByb3BlcnR5KHJlcXVpcmVPcHRpb25zLnRvb2xzLmV2ZW50c1tpXSkpIHtcbiAgICAgICAgdmFsaWQgPSBmYWxzZVxuICAgICAgICB0aHJvdyBuZXcgRWRpdG9yVG9vbERlZmluZUVycm9yKGBFZGl0b3JUb29sIOq3nOqyqeydtCDrp57sp4Ag7JWK7J2MICjsnbTrsqTtirjqsIAg7KCV7J2Y65CY7KeAIOyViuydjDogJHtyZXF1aXJlT3B0aW9ucy50b29scy5ldmVudHNbaV19KWApXG4gICAgICB9XG4gICAgfVxuXG4gICAgcmV0dXJuIHZhbGlkXG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9yVmFsaWRhdGlvblxuXG5leHBvcnQge1xuICByZXF1aXJlT3B0aW9uc1xufVxuIiwiaW1wb3J0IFhlRXJyb3IgZnJvbSAneGUvZXJyb3InXG5cbi8qKlxuICogQG1vZHVsZSBYZUVycm9yL0VkaXRvckRlZmluZUVycm9yXG4gKiBAZXh0ZW5kcyBYZUVycm9yXG4gKi9cbmNsYXNzIEVkaXRvckRlZmluZUVycm9yIGV4dGVuZHMgWGVFcnJvciB7XG4gIGNvbnN0cnVjdG9yIChtZXNzYWdlKSB7XG4gICAgc3VwZXIobWVzc2FnZSlcbiAgfVxufVxuXG4vKipcbiAqIEBtb2R1bGUgWGVFcnJvci9FZGl0b3JUb29sRGVmaW5lRXJyb3JcbiAqIEBleHRlbmRzIFhlRXJyb3JcbiAqL1xuY2xhc3MgRWRpdG9yVG9vbERlZmluZUVycm9yIGV4dGVuZHMgWGVFcnJvciB7XG4gIGNvbnN0cnVjdG9yIChtZXNzYWdlKSB7XG4gICAgc3VwZXIobWVzc2FnZSlcbiAgfVxufVxuXG4vKipcbiAqIEBtb2R1bGUgWGVFcnJvci9FZGl0b3JVc2VkQ29udGFpbmVyXG4gKiBAZXh0ZW5kcyBYZUVycm9yXG4gKi9cbmNsYXNzIEVkaXRvclVzZWRDb250YWluZXIgZXh0ZW5kcyBYZUVycm9yIHtcbiAgY29uc3RydWN0b3IgKG1lc3NhZ2UpIHtcbiAgICBzdXBlcihtZXNzYWdlKVxuICB9XG59XG5cbi8qKlxuICogQG1vZHVsZSBYZUVycm9yL0VkaXRvclVuZGVmaW5lZENvbnRhaW5lclxuICogQGV4dGVuZHMgWGVFcnJvclxuICovXG5jbGFzcyBFZGl0b3JVbmRlZmluZWRDb250YWluZXIgZXh0ZW5kcyBYZUVycm9yIHtcbiAgY29uc3RydWN0b3IgKG1lc3NhZ2UpIHtcbiAgICBzdXBlcihtZXNzYWdlKVxuICB9XG59XG5cbmV4cG9ydCB7XG4gIEVkaXRvckRlZmluZUVycm9yLFxuICBFZGl0b3JUb29sRGVmaW5lRXJyb3IsXG4gIEVkaXRvclVzZWRDb250YWluZXIsXG4gIEVkaXRvclVuZGVmaW5lZENvbnRhaW5lclxufVxuIiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IEFwcCBmcm9tICd4ZS9hcHAnXG5pbXBvcnQgRWRpdG9yRGVmaW5lIGZyb20gJy4vZWRpdG9yRGVmaW5lJ1xuaW1wb3J0IEVkaXRvclZhbGlkYXRpb24gZnJvbSAnLi9lZGl0b3JWYWxpZGF0aW9uJ1xuaW1wb3J0IEVkaXRvclRvb2wgZnJvbSAnLi9lZGl0b3JUb29sJ1xuaW1wb3J0IFhFIGZyb20gJ3hlJ1xuXG4vKipcbiAqIEBjbGFzc1xuICogQGV4dGVuZHMgQXBwXG4gKi9cbmNsYXNzIEVkaXRvciBleHRlbmRzIEFwcCB7XG4gIGNvbnN0cnVjdG9yICgpIHtcbiAgICBzdXBlcigpXG5cbiAgICB0aGlzLnRvb2xzU2V0ID0ge31cbiAgICB0aGlzLmVkaXRvclNldCA9IHt9XG4gICAgdGhpcy5lZGl0b3JPcHRpb25TZXQgPSB7fVxuXG4gICAgLyoqXG4gICAgICogQERFUFJFQ0FURURcbiAgICAgKiovXG4gICAgdGhpcy50b29scyA9IHtcbiAgICAgIGRlZmluZTogb2JqID0+IHtcbiAgICAgICAgaWYgKCQuaXNGdW5jdGlvbihjb25zb2xlLndhcm4pICYmICQuaXNGdW5jdGlvbihjb25zb2xlLnRyYWNlKSkge1xuICAgICAgICAgIGNvbnNvbGUud2FybignREVQUkVDQVRFRDogWEVlZGl0b3IudG9vbHMuZGVmaW5lKCkgaXMgZGVwcmVjYXRlZC4gdXNlIFhFZWRpdG9yLmRlZmluZVRvb2wnKVxuICAgICAgICAgIGNvbnNvbGUudHJhY2UoKVxuICAgICAgICB9XG4gICAgICAgIHRoaXMuZGVmaW5lVG9vbChvYmopXG4gICAgICB9LFxuICAgICAgZ2V0OiBpZCA9PiB7XG4gICAgICAgIGlmICgkLmlzRnVuY3Rpb24oY29uc29sZS53YXJuKSAmJiAkLmlzRnVuY3Rpb24oY29uc29sZS50cmFjZSkpIHtcbiAgICAgICAgICBjb25zb2xlLndhcm4oJ0RFUFJFQ0FURUQ6IFhFZWRpdG9yLnRvb2xzLmdldCgpIGlzIGRlcHJlY2F0ZWQuIHVzZSBYRWVkaXRvci5nZXRUb29sJylcbiAgICAgICAgICBjb25zb2xlLnRyYWNlKClcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gdGhpcy5nZXRUb29sKGlkKVxuICAgICAgfVxuICAgIH1cbiAgfVxuXG4gIHN0YXRpYyBhcHBOYW1lICgpIHtcbiAgICByZXR1cm4gJ0VkaXRvcidcbiAgfVxuXG4gIGJvb3QgKFhFKSB7XG4gICAgaWYgKHRoaXMuYm9vdGVkKCkpIHtcbiAgICAgIHJldHVybiBQcm9taXNlLnJlc29sdmUodGhpcylcbiAgICB9XG5cbiAgICByZXR1cm4gbmV3IFByb21pc2UoKHJlc29sdmUpID0+IHtcbiAgICAgIHN1cGVyLmJvb3QoWEUpXG5cbiAgICAgIHJlc29sdmUodGhpcylcbiAgICB9KVxuICB9XG5cbiAgLyoqXG4gICAqIOyXkOuUlO2EsOulvCDsoJXsnZjtlZzri6QuXG4gICAqIEBwcm9wZXJ0eSB7ZWRpdG9yRGVmaW5pdGlvbn0gb2JqXG4gICAqKi9cbiAgZGVmaW5lIChvYmopIHtcbiAgICBjb25zdCBlZGl0b3JTZXR0aW5ncyA9IG9iai5lZGl0b3JTZXR0aW5nc1xuICAgIGNvbnN0IGludGVyZmFjZXMgPSBvYmouaW50ZXJmYWNlc1xuXG4gICAgdHJ5IHtcbiAgICAgIGlmIChFZGl0b3JWYWxpZGF0aW9uLmlzVmFsaWRFZGl0b3JPcHRpb25zKGVkaXRvclNldHRpbmdzLCBpbnRlcmZhY2VzKSkge1xuICAgICAgICBjb25zdCBlZGl0b3IgPSBuZXcgRWRpdG9yRGVmaW5lKGVkaXRvclNldHRpbmdzLCBpbnRlcmZhY2VzKVxuICAgICAgICB0aGlzLmVkaXRvclNldFtlZGl0b3JTZXR0aW5ncy5uYW1lXSA9IGVkaXRvclxuICAgICAgICB0aGlzLmVkaXRvck9wdGlvblNldFtlZGl0b3JTZXR0aW5ncy5uYW1lXSA9IGVkaXRvclNldHRpbmdzXG4gICAgICAgIHRoaXMuJCRlbWl0KCdlZGl0b3IuZGVmaW5lJywgZWRpdG9yKVxuICAgICAgfVxuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIC8vIGNvbnNvbGUuZXJyb3IoZSlcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw66W8IOuwmO2ZmO2VnOuLpC5cbiAgICogQHBhcmFtIHtzdHJpbmd9IG5hbWVcbiAgICogQHJldHVybiB7UHJvbWlzZX1cbiAgICoqL1xuICBnZXRFZGl0b3IgKG5hbWUpIHtcbiAgICBpZiAodGhpcy5lZGl0b3JTZXRbbmFtZV0pIHtcbiAgICAgIHJldHVybiBQcm9taXNlLnJlc29sdmUodGhpcy5lZGl0b3JTZXRbbmFtZV0pXG4gICAgfVxuXG4gICAgcmV0dXJuIG5ldyBQcm9taXNlKChyZXNvbHZlKSA9PiB7XG4gICAgICB0aGlzLiQkb24oJ2VkaXRvci5kZWZpbmUnLCAoZXZlbnROYW1lLCBlZGl0b3IpID0+IHtcbiAgICAgICAgcmVzb2x2ZShlZGl0b3IpXG4gICAgICB9KVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICogRWRpdG9yVG9vbCDsoJXsnZhcbiAgICpcbiAgICogQHBhcmFtIHtlZGl0b3JUb29sRGVmaW5pdGlvbn0gb2JqXG4gICAqL1xuICBkZWZpbmVUb29sIChvYmopIHtcbiAgICB0cnkge1xuICAgICAgaWYgKEVkaXRvclZhbGlkYXRpb24uaXNWYWxpZFRvb2xzT2JqZWN0KG9iaikpIHtcbiAgICAgICAgdGhpcy50b29sc1NldFtvYmouaWRdID0gbmV3IEVkaXRvclRvb2wob2JqKVxuICAgICAgfVxuICAgIH0gY2F0Y2ggKGUpIHtcbiAgICAgIGNvbnNvbGUuZXJyb3IoZSlcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICogRWRpdG9yVG9vbCDrsJjtmZhcbiAgICpcbiAgICogQHBhcmFtIHtzdHJpbmd9IGlkXG4gICAqIEByZXR1cm4ge0VkaXRvclRvb2x9XG4gICAqL1xuICBnZXRUb29sIChpZCkge1xuICAgIHJldHVybiB0aGlzLnRvb2xzU2V0W2lkXVxuICB9XG5cbiAgLyoqXG4gICAqIOy7qO2FkOy4oOyXkCB0b29sIGlk66W8IHhlLXRvb2wtaWQgYXR0cmlidXRl7JeQIO2VoOuLue2VmOyXrCDrsJjtmZjtlZzri6QuXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBjb250ZW50XG4gICAqIEBwYXJhbSB7c3RyaW5nfSBpZFxuICAgKiBAcmV0dXJuIHtzdHJpbmd9IEhUTUwgbWFya3VwIHN0cmluZ1xuICAgKiovXG4gIGF0dGFjaERvbUlkIChjb250ZW50LCBpZCkge1xuICAgIHJldHVybiAkKGNvbnRlbnQpLmF0dHIoJ3hlLXRvb2wtaWQnLCBpZCkuY2xvbmUoKS53cmFwQWxsKCc8ZGl2Lz4nKS5wYXJlbnQoKS5odG1sKClcbiAgfVxuXG4gIC8qKlxuICAgKiBAREVQUkVDQVRFRFxuICAgKiBAcGFyYW0ge3N0cmluZ30gaWRcbiAgICogQHJldHVybiB7c3RyaW5nfSBIVE1MIHNlbGVjdG9yIHN0cmluZ1xuICAgKiovXG4gIGdldERvbVNlbGVjdG9yIChpZCkge1xuICAgIHJldHVybiAnW3hlLXRvb2wtaWQ9XCInICsgaWQgKyAnXCJdJ1xuICB9XG59XG5cbi8qKlxuICogQHR5cGUgICAgICAge0VkaXRvcn1cbiAqL1xuY29uc3QgWEVlZGl0b3IgPSBuZXcgRWRpdG9yKClcbmlmICghd2luZG93LlhFZWRpdG9yKSB3aW5kb3cuWEVlZGl0b3IgPSBYRWVkaXRvclxuWEUucmVnaXN0ZXJBcHAoJ0VkaXRvcicsIFhFZWRpdG9yKVxuXG5leHBvcnQgZGVmYXVsdCBFZGl0b3JcbiIsImltcG9ydCAkIGZyb20gJ2pxdWVyeSdcbmltcG9ydCBYRSBmcm9tICd4ZSdcblxuWEUuYXBwKCdFZGl0b3InLCAoRWRpdG9yKSA9PiB7XG4gIEVkaXRvci5kZWZpbmUoe1xuICAgIGVkaXRvclNldHRpbmdzOiB7XG4gICAgICBuYW1lOiAnWEV0ZXh0YXJlYScsXG4gICAgICBjb25maWdzOiB7fVxuICAgIH0sXG4gICAgLyoqXG4gICAgICogQHByb3Age29iamVjdH0gaW50ZXJmYWNlc1xuICAgICAqIEBwcm9wIHtmdW5jdGlvbihzZWxlY3RvcixvcHRpb25zKX0gaW50ZXJmYWNlcy5pbml0aWFsaXplXG4gICAgICogPHByZT5cbiAgICAgKiAgIGFyZ3VtZW50c1xuICAgICAqICAgLSBzZWxlY3RvciA6IHN0cmluZ1xuICAgICAqICAgLSBvcHRpb25zIDogb2JqZWN0XG4gICAgICogPC9wcmU+XG4gICAgICogQHByb3Age2Z1bmN0aW9ufSBpbnRlcmZhY2VzLmdldENvbnRlbnRzIOyXkOuUlO2EsCDsu6jthZDsuKDrpbwg66as7YS07ZWc64ukLlxuICAgICAqIEBwcm9wIHtmdW5jdGlvbn0gaW50ZXJmYWNlcy5zZXRDb250ZW50cyDsl5DrlJTthLDsl5Ag7Luo7YWQ7Lig66W8IOuNruyWtOyTtOuLpC5cbiAgICAgKiA8cHJlPlxuICAgICAqICAgYXJndW1lbnRzXG4gICAgICogICAtIHRleHQgOiBzdHJpbmdcbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcHJvcCB7ZnVuY3Rpb259IGludGVyZmFjZXMuYWRkQ29udGVudHMg7JeQ65SU7YSw7JeQIOy7qO2FkOy4oOulvCDstpTqsIDtlZzri6QuXG4gICAgICogPHByZT5cbiAgICAgKiAgIGFyZ3VtZW50c1xuICAgICAqICAgLSB0ZXh0IDogc3RyaW5nXG4gICAgICogPC9wcmU+XG4gICAgICogQHByb3Age2Z1bmN0aW9ufSBpbnRlcmZhY2VzLm9uIOyXkOuUlO2EsOyXkCDsnbTrsqTtirgg7ZW465Ok65+s66W8IOy2lOqwgO2VnOuLpC5cbiAgICAgKiA8cHJlPlxuICAgICAqICAgYXJndW1lbnRzXG4gICAgICogICAtIGV2ZW50TmFtZSA6IHN0cmluZ1xuICAgICAqICAgLSBjYWxsYmFjayA6IGZ1bmN0aW9uXG4gICAgICogPC9wcmU+XG4gICAgICogQHByb3Age2Z1bmN0aW9ufSBpbnRlcmZhY2VzLnJlc2V0IOyXkOuUlO2EsCDsu6jthZDsuKDrpbwg7LSI6riw7ZmU7ZWc64ukLlxuICAgICAqL1xuICAgIGludGVyZmFjZXM6IHtcbiAgICAgIGluaXRpYWxpemU6IGZ1bmN0aW9uIChzZWxlY3Rvciwgb3B0aW9ucykge1xuICAgICAgICBvcHRpb25zID0gJC5leHRlbmQodHJ1ZSwge1xuICAgICAgICAgIGZpbGVVcGxvYWQ6IHt9LFxuICAgICAgICAgIHN1Z2dlc3Rpb246IHt9LFxuICAgICAgICAgIG5hbWVzOiB7XG4gICAgICAgICAgICBmaWxlOiB7XG4gICAgICAgICAgICAgIGltYWdlOiB7fVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIHRhZzoge30sXG4gICAgICAgICAgICBtZW50aW9uOiB7fVxuICAgICAgICAgIH0sXG4gICAgICAgICAgZXh0ZW5zaW9uczogW10sXG4gICAgICAgICAgZm9udEZhbWlseTogW10sXG4gICAgICAgICAgcGVybXM6IHt9LFxuICAgICAgICAgIGZpbGVzOiBbXVxuICAgICAgICB9LCBvcHRpb25zKVxuXG4gICAgICAgIGxldCAkZWRpdG9yID0gJCgnIycgKyBzZWxlY3RvcilcbiAgICAgICAgbGV0IGhlaWdodCA9IG9wdGlvbnMuaGVpZ2h0XG4gICAgICAgIGxldCBmb250RmFtaWx5ID0gb3B0aW9ucy5mb250RmFtaWx5XG4gICAgICAgIGxldCBmb250U2l6ZSA9IG9wdGlvbnMuZm9udFNpemVcblxuICAgICAgICB0aGlzLmFkZFByb3BzKHtcbiAgICAgICAgICBlZGl0b3I6ICRlZGl0b3IsIHNlbGVjdG9yOiBzZWxlY3Rvciwgb3B0aW9uczogb3B0aW9uc1xuICAgICAgICB9KVxuXG4gICAgICAgIGlmIChoZWlnaHQpIHtcbiAgICAgICAgICAkZWRpdG9yLmNzcygnaGVpZ2h0JywgaGVpZ2h0ICsgJ3B4JylcbiAgICAgICAgfVxuXG4gICAgICAgIGlmIChmb250RmFtaWx5IHx8IGZvbnRTaXplKSB7XG4gICAgICAgICAgaWYgKGZvbnRGYW1pbHkgJiYgZm9udEZhbWlseS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAkZWRpdG9yLmNzcygnZm9udC1mYW1pbHknLCBmb250RmFtaWx5LmpvaW4oJywnKSlcbiAgICAgICAgICB9XG5cbiAgICAgICAgICBpZiAoZm9udFNpemUpIHtcbiAgICAgICAgICAgICRlZGl0b3IuY3NzKCdmb250LXNpemUnLCBmb250U2l6ZSlcbiAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICAkZWRpdG9yLnBhcmVudHMoJ2Zvcm0nKS5vbignc3VibWl0JywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgIGxldCBmaWxlSW5wdXQgPSBvcHRpb25zLm5hbWVzLmZpbGUuaW5wdXRcbiAgICAgICAgICBsZXQgZmlsZXMgPSBvcHRpb25zLmZpbGVzXG4gICAgICAgICAgbGV0ICRwYXJhbVdyYXAgPSAkKClcblxuICAgICAgICAgIC8vIGZpbGVzIGlucHV07IKt7KCcIO2bhCDsg53shLFcbiAgICAgICAgICAkZWRpdG9yLm5leHRBbGwoJy5wYXJhbVdyYXAnKS5yZW1vdmUoKVxuICAgICAgICAgICRlZGl0b3IuYWZ0ZXIoXCI8ZGl2IGNsYXNzPSdwYXJhbVdyYXAnPlwiKVxuICAgICAgICAgICRwYXJhbVdyYXAgPSAkZWRpdG9yLm5leHRBbGwoJy5wYXJhbVdyYXAnKVxuXG4gICAgICAgICAgLy8gZmlsZXNcbiAgICAgICAgICBpZiAoZmlsZXMubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgZm9yIChsZXQgaSA9IDAsIG1heCA9IGZpbGVzLmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICAgICAgICAgIGxldCBmaWxlID0gZmlsZXNbaV1cblxuICAgICAgICAgICAgICAkcGFyYW1XcmFwLmFwcGVuZChcIjxpbnB1dCB0eXBlPSdoaWRkZW4nbmFtZT0nXCIgKyBmaWxlSW5wdXQgKyBcIltdJyB2YWx1ZT0nXCIgKyBmaWxlLmlkICsgXCInIC8+XCIpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfVxuICAgICAgICB9KVxuICAgICAgfSxcblxuICAgICAgZ2V0Q29udGVudHM6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgcmV0dXJuIHRoaXMucHJvcHMuZWRpdG9yLnZhbCgpXG4gICAgICB9LFxuXG4gICAgICBzZXRDb250ZW50czogZnVuY3Rpb24gKHRleHQpIHtcbiAgICAgICAgdGhpcy5wcm9wcy5lZGl0b3IudmFsKHRleHQpXG4gICAgICB9LFxuXG4gICAgICBhZGRDb250ZW50czogZnVuY3Rpb24gKHRleHQpIHtcbiAgICAgICAgdmFyIGh0bWwgPSB0aGlzLnByb3BzLmVkaXRvci52YWwoKVxuICAgICAgICB0aGlzLnByb3BzLmVkaXRvci52YWwoaHRtbClcbiAgICAgIH0sXG5cbiAgICAgIG9uOiBmdW5jdGlvbiAoZXZlbnROYW1lLCBjYWxsYmFjaykge1xuICAgICAgICB0aGlzLnByb3BzLmVkaXRvci5vbihldmVudE5hbWUsIGNhbGxiYWNrKVxuICAgICAgfSxcbiAgICAgIGdldENvbnRlbnREb206IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgcmV0dXJuIGZhbHNlXG4gICAgICB9LFxuICAgICAgcmVzZXQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgLy8gY29udGVudHMg7IKt7KCcXG4gICAgICAgIHRoaXMucHJvcHMuZWRpdG9yLnZhbCgnJykuZm9jdXMoKVxuXG4gICAgICAgIC8vIGlucHV0IGhpZGRlbiDsgq3soJxcbiAgICAgICAgdGhpcy5wcm9wcy5lZGl0b3IubmV4dEFsbCgnLnBhcmFtV3JhcCcpLnJlbW92ZSgpXG4gICAgICB9XG4gICAgfVxuICB9KVxufSlcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2Nyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDI3MCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDMpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDcpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDUpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxMSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMCk7IiwibW9kdWxlLmV4cG9ydHMgPSBfeGVfZGxsX2NvbW1vbjsiXSwic291cmNlUm9vdCI6IiJ9