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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(42);

/***/ }),

/***/ "./core/editor/editorDefine.js":
/*!*************************************!*\
  !*** ./core/editor/editorDefine.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/asyncToGenerator */ "./node_modules/@babel/runtime-corejs3/helpers/asyncToGenerator.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_regenerator__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/regenerator */ "./node_modules/@babel/runtime-corejs3/regenerator/index.js");
/* harmony import */ var _babel_runtime_corejs3_regenerator__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_regenerator__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/promise */ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _editorValidation__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./editorValidation */ "./core/editor/editorValidation.js");
/* harmony import */ var _editorInstance__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./editorInstance */ "./core/editor/editorInstance.js");
/* harmony import */ var xe_utils__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! xe/utils */ "./core/utils/index.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_9__);










/**
 * @class
 */

var EditorDefine = /*#__PURE__*/function () {
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
    Object(xe_utils__WEBPACK_IMPORTED_MODULE_8__["eventify"])(this);

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
    value: function () {
      var _create = _babel_runtime_corejs3_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0___default()( /*#__PURE__*/_babel_runtime_corejs3_regenerator__WEBPACK_IMPORTED_MODULE_3___default.a.mark(function _callee(sel, options, editorOptions, toolInfoList) {
        var editorIntance, result, tools, toolInfoListFilter, i, max;
        return _babel_runtime_corejs3_regenerator__WEBPACK_IMPORTED_MODULE_3___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                toolInfoList = toolInfoList || [];
                editorOptions = jquery__WEBPACK_IMPORTED_MODULE_9___default.a.extend(this.configs || {}, editorOptions || {});

                if (!_editorValidation__WEBPACK_IMPORTED_MODULE_6__["default"].isValidBeforeCreateInstance(sel, toolInfoList, this)) {
                  _context.next = 13;
                  break;
                }

                editorIntance = new _editorInstance__WEBPACK_IMPORTED_MODULE_7__["default"](this.name, sel, editorOptions, toolInfoList);
                editorIntance._editor = this;
                this.editorList[sel] = editorIntance;
                result = this.initialize.call(this.editorList[sel], sel, options, editorOptions);

                if (!(result instanceof _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_4___default.a)) {
                  _context.next = 10;
                  break;
                }

                _context.next = 10;
                return result;

              case 10:
                if (!!toolInfoList && toolInfoList.length > 0) {
                  tools = {};
                  toolInfoListFilter = [];

                  for (i = 0, max = toolInfoList.length; i < max; i += 1) {
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
                return _context.abrupt("return", this.editorList[sel]);

              case 13:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function create(_x, _x2, _x3, _x4) {
        return _create.apply(this, arguments);
      }

      return create;
    }()
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
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);



/**
 * @class
 */
var EditorTool = /*#__PURE__*/_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_0___default()(function EditorTool(obj) {
  _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, EditorTool);

  for (var o in obj) {
    this[o] = obj[o];
  }
});

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
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/inherits */ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/getPrototypeOf */ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var xe_error__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! xe/error */ "./core/error/index.js");








function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default()(this).constructor; result = _babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default()(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5___default()(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default.a) return false; if (_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default.a.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default()(Boolean, [], function () {})); return true; } catch (e) { return false; } }


/**
 * @module XeError/EditorDefineError
 * @extends XeError
 */

var EditorDefineError = /*#__PURE__*/function (_XeError) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default()(EditorDefineError, _XeError);

  var _super = _createSuper(EditorDefineError);

  function EditorDefineError(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_3___default()(this, EditorDefineError);

    return _super.call(this, message);
  }

  return _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(EditorDefineError);
}(xe_error__WEBPACK_IMPORTED_MODULE_7__["default"]);
/**
 * @module XeError/EditorToolDefineError
 * @extends XeError
 */


var EditorToolDefineError = /*#__PURE__*/function (_XeError2) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default()(EditorToolDefineError, _XeError2);

  var _super2 = _createSuper(EditorToolDefineError);

  function EditorToolDefineError(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_3___default()(this, EditorToolDefineError);

    return _super2.call(this, message);
  }

  return _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(EditorToolDefineError);
}(xe_error__WEBPACK_IMPORTED_MODULE_7__["default"]);
/**
 * @module XeError/EditorUsedContainer
 * @extends XeError
 */


var EditorUsedContainer = /*#__PURE__*/function (_XeError3) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default()(EditorUsedContainer, _XeError3);

  var _super3 = _createSuper(EditorUsedContainer);

  function EditorUsedContainer(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_3___default()(this, EditorUsedContainer);

    return _super3.call(this, message);
  }

  return _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(EditorUsedContainer);
}(xe_error__WEBPACK_IMPORTED_MODULE_7__["default"]);
/**
 * @module XeError/EditorUndefinedContainer
 * @extends XeError
 */


var EditorUndefinedContainer = /*#__PURE__*/function (_XeError4) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default()(EditorUndefinedContainer, _XeError4);

  var _super4 = _createSuper(EditorUndefinedContainer);

  function EditorUndefinedContainer(message) {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_3___default()(this, EditorUndefinedContainer);

    return _super4.call(this, message);
  }

  return _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(EditorUndefinedContainer);
}(xe_error__WEBPACK_IMPORTED_MODULE_7__["default"]);



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
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/get */ "./node_modules/@babel/runtime-corejs3/helpers/get.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/inherits */ "./node_modules/@babel/runtime-corejs3/helpers/inherits.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/getPrototypeOf */ "./node_modules/@babel/runtime-corejs3/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/promise */ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var xe_app__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! xe/app */ "./core/app.js");
/* harmony import */ var _editorDefine__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./editorDefine */ "./core/editor/editorDefine.js");
/* harmony import */ var _editorValidation__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./editorValidation */ "./core/editor/editorValidation.js");
/* harmony import */ var _editorTool__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./editorTool */ "./core/editor/editorTool.js");
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! xe */ "./core/index.js");











function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7___default()(this).constructor; result = _babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default()(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_corejs3_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_6___default()(this, result); }; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default.a) return false; if (_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default.a.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(_babel_runtime_corejs3_core_js_stable_reflect_construct__WEBPACK_IMPORTED_MODULE_0___default()(Boolean, [], function () {})); return true; } catch (e) { return false; } }







/**
 * @class
 * @extends App
 */

var Editor = /*#__PURE__*/function (_App) {
  _babel_runtime_corejs3_helpers_inherits__WEBPACK_IMPORTED_MODULE_5___default()(Editor, _App);

  var _super = _createSuper(Editor);

  function Editor() {
    var _this;

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_2___default()(this, Editor);

    _this = _super.call(this);
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

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_3___default()(Editor, [{
    key: "boot",
    value: function boot(XE) {
      var _this2 = this;

      if (this.booted()) {
        return _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_9___default.a.resolve(this);
      }

      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_9___default.a(function (resolve) {
        _babel_runtime_corejs3_helpers_get__WEBPACK_IMPORTED_MODULE_4___default()(_babel_runtime_corejs3_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_7___default()(Editor.prototype), "boot", _this2).call(_this2, XE);

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
        return _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_9___default.a.resolve(this.editorSet[name]);
      }

      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_9___default.a(function (resolve) {
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(141);

/***/ }),

/***/ "./core/index.js":
/*!*******************************************************************!*\
  !*** delegated ./core/index.js from dll-reference _xe_dll_common ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(514);

/***/ }),

/***/ "./core/utils/index.js":
/*!*************************************************************************!*\
  !*** delegated ./core/utils/index.js from dll-reference _xe_dll_common ***!
  \*************************************************************************/
/*! exports provided: getUri, addCommas, strtotime, EventEmitter, curry, debounce, find, forEach, mapValues, throttle, trim, trimEnd, trimStart, setBaseURL, eventify, isImage, isVideo, isAudio, formatSizeUnits, sizeFormatToBytes, isURL, asset, openWindow */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(9);

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

/***/ "./node_modules/@babel/runtime-corejs3/helpers/asyncToGenerator.js":
/*!*********************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/asyncToGenerator.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(340);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(7);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(30);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(17);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js":
/*!******************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/possibleConstructorReturn.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(18);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/regenerator/index.js":
/*!**************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/regenerator/index.js from dll-reference _xe_dll_common ***!
  \**************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(175);

/***/ }),

/***/ "./node_modules/core-js/modules/es.array.join.js":
/*!***************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.array.join.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(166);

/***/ }),

/***/ "./node_modules/core-js/modules/es.function.name.js":
/*!******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.function.name.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(76);

/***/ }),

/***/ "./node_modules/core-js/modules/es.object.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.object.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(26);

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

__webpack_require__(/*! /Users/bkim/Documents/GitHub/xpressengine/resources/assets/core/editor/index */"./core/editor/index.js");
module.exports = __webpack_require__(/*! /Users/bkim/Documents/GitHub/xpressengine/resources/assets/core/editor/textarea.define.js */"./core/editor/textarea.define.js");


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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvYXBwLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9jb3JlL2VkaXRvci9lZGl0b3JEZWZpbmUuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvZWRpdG9ySW5zdGFuY2UuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvZWRpdG9yVG9vbC5qcyIsIndlYnBhY2s6Ly8vLi9jb3JlL2VkaXRvci9lZGl0b3JWYWxpZGF0aW9uLmpzIiwid2VicGFjazovLy8uL2NvcmUvZWRpdG9yL2Vycm9ycy9lZGl0b3IuZXJyb3IuanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvaW5kZXguanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS9lZGl0b3IvdGV4dGFyZWEuZGVmaW5lLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9jb3JlL2Vycm9yL2luZGV4LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vY29yZS9pbmRleC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvdXRpbHMvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9wcm9taXNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvcmVmbGVjdC9jb25zdHJ1Y3QuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2FzeW5jVG9HZW5lcmF0b3IuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NsYXNzQ2FsbENoZWNrLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jcmVhdGVDbGFzcy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvZ2V0LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9nZXRQcm90b3R5cGVPZi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvaW5oZXJpdHMuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL3Bvc3NpYmxlQ29uc3RydWN0b3JSZXR1cm4uanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9yZWdlbmVyYXRvci9pbmRleC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuYXJyYXkuam9pbi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuZnVuY3Rpb24ubmFtZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMub2JqZWN0LnRvLXN0cmluZy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9qcXVlcnkvc3JjL2pxdWVyeS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2V4dGVybmFsIFwiX3hlX2RsbF9jb21tb25cIiJdLCJuYW1lcyI6WyJFZGl0b3JEZWZpbmUiLCJlZGl0b3JTZXR0aW5ncyIsImludGVyZmFjZXMiLCJuYW1lIiwiY29uZmlncyIsImVkaXRvckxpc3QiLCJldmVudGlmeSIsImhhc093blByb3BlcnR5IiwicGx1Z2lucyIsIkFycmF5IiwibGVuZ3RoIiwiYWRkUGx1Z2lucyIsIm8iLCJzZWwiLCJvcHRpb25zIiwiZWRpdG9yT3B0aW9ucyIsInRvb2xJbmZvTGlzdCIsIiQiLCJleHRlbmQiLCJFZGl0b3JWYWxpZGF0aW9uIiwiaXNWYWxpZEJlZm9yZUNyZWF0ZUluc3RhbmNlIiwiZWRpdG9ySW50YW5jZSIsIkVkaXRvckluc3RhbmNlIiwiX2VkaXRvciIsInJlc3VsdCIsImluaXRpYWxpemUiLCJjYWxsIiwidG9vbHMiLCJ0b29sSW5mb0xpc3RGaWx0ZXIiLCJpIiwibWF4Iiwid2luZG93IiwiWEVlZGl0b3IiLCJnZXRUb29sIiwiaWQiLCJwdXNoIiwiY29uc29sZSIsImVycm9yIiwiYWRkVG9vbHMiLCIkJGVtaXQiLCJlZGl0b3JOYW1lIiwiX29wdGlvbnMiLCJzZWxlY3RvciIsInByb3BzIiwiZ2V0T3B0aW9ucyIsImVkaXRvclNldCIsImdldENvbnRlbnRzIiwidGV4dCIsInNldENvbnRlbnRzIiwiYWRkQ29udGVudHMiLCJvYmoiLCJ0b29sSW5zdGFuY2VMaXN0IiwiZXZlbnROYW1lIiwiY2FsbGJhY2siLCJvbiIsImN1c3RvbU9wdGlvbnMiLCJyZW5kZXJGaWxlVXBsb2FkZXIiLCJnZXRDb250ZW50RG9tIiwicmVzZXQiLCJFZGl0b3JUb29sIiwicmVxdWlyZU9wdGlvbnMiLCJwcm9wZXJ0eSIsImV2ZW50cyIsInRvb2xJZExpc3QiLCJlZGl0b3JQYXJlbnQiLCJFZGl0b3JVbmRlZmluZWRDb250YWluZXIiLCJzZWxWYWxpZCIsIkVkaXRvclVzZWRDb250YWluZXIiLCJ2YWxpZCIsImVTZXR0aW5ncyIsIkVkaXRvckRlZmluZUVycm9yIiwiZUludGVyZmFjZSIsInRvb2xEZWZpbmUiLCJFZGl0b3JUb29sRGVmaW5lRXJyb3IiLCJtZXNzYWdlIiwiWGVFcnJvciIsIkVkaXRvciIsInRvb2xzU2V0IiwiZWRpdG9yT3B0aW9uU2V0IiwiZGVmaW5lIiwiaXNGdW5jdGlvbiIsIndhcm4iLCJ0cmFjZSIsImRlZmluZVRvb2wiLCJnZXQiLCJYRSIsImJvb3RlZCIsInJlc29sdmUiLCJpc1ZhbGlkRWRpdG9yT3B0aW9ucyIsImVkaXRvciIsImUiLCIkJG9uIiwiaXNWYWxpZFRvb2xzT2JqZWN0IiwiY29udGVudCIsImF0dHIiLCJjbG9uZSIsIndyYXBBbGwiLCJwYXJlbnQiLCJodG1sIiwiQXBwIiwicmVnaXN0ZXJBcHAiLCJhcHAiLCJmaWxlVXBsb2FkIiwic3VnZ2VzdGlvbiIsIm5hbWVzIiwiZmlsZSIsImltYWdlIiwidGFnIiwibWVudGlvbiIsImV4dGVuc2lvbnMiLCJmb250RmFtaWx5IiwicGVybXMiLCJmaWxlcyIsIiRlZGl0b3IiLCJoZWlnaHQiLCJmb250U2l6ZSIsImFkZFByb3BzIiwiY3NzIiwiam9pbiIsInBhcmVudHMiLCJmaWxlSW5wdXQiLCJpbnB1dCIsIiRwYXJhbVdyYXAiLCJuZXh0QWxsIiwicmVtb3ZlIiwiYWZ0ZXIiLCJhcHBlbmQiLCJ2YWwiLCJmb2N1cyJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7UUFDdkQsaUNBQWlDLGVBQWU7UUFDaEQ7UUFDQTtRQUNBOztRQUVBO1FBQ0Esc0RBQXNELCtEQUErRDs7UUFFckg7UUFDQTs7O1FBR0E7UUFDQTs7Ozs7Ozs7Ozs7O0FDbEZBLCtHOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTs7SUFDTUEsWTtFQUNKO0FBQ0Y7QUFDQTtBQUNBO0VBQ0Usc0JBQWFDLGNBQWIsRUFBNkJDLFVBQTdCLEVBQXlDO0lBQUE7O0lBQ3ZDLEtBQUtDLElBQUwsR0FBWUYsY0FBYyxDQUFDRSxJQUEzQjtJQUNBLEtBQUtDLE9BQUwsR0FBZUgsY0FBYyxD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LCtHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9lZGl0b3IvZWRpdG9yLmJ1bmRsZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSAxKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0Mik7IiwiaW1wb3J0IEVkaXRvclZhbGlkYXRpb24gZnJvbSAnLi9lZGl0b3JWYWxpZGF0aW9uJ1xuaW1wb3J0IEVkaXRvckluc3RhbmNlIGZyb20gJy4vZWRpdG9ySW5zdGFuY2UnXG5pbXBvcnQgeyBldmVudGlmeSB9IGZyb20gJ3hlL3V0aWxzJ1xuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuXG4vKipcbiAqIEBjbGFzc1xuICovXG5jbGFzcyBFZGl0b3JEZWZpbmUge1xuICAvKipcbiAgICogQHBhcmFtIHtvYmplY3R9IGVkaXRvclNldHRpbmdzXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBpbnRlcmZhY2VzXG4gICAqL1xuICBjb25zdHJ1Y3RvciAoZWRpdG9yU2V0dGluZ3MsIGludGVyZmFjZXMpIHtcbiAgICB0aGlzLm5hbWUgPSBlZGl0b3JTZXR0aW5ncy5uYW1lXG4gICAgdGhpcy5jb25maWdzID0gZWRpdG9yU2V0dGluZ3MuY29uZmlnc1xuICAgIHRoaXMuZWRpdG9yTGlzdCA9IFtdXG4gICAgdGhpcy5pbnRlcmZhY2VzID0ge31cblxuICAgIGV2ZW50aWZ5KHRoaXMpXG5cbiAgICBpZiAoZWRpdG9yU2V0dGluZ3MuaGFzT3duUHJvcGVydHkoJ3BsdWdpbnMnKSAmJlxuICAgICAgZWRpdG9yU2V0dGluZ3MucGx1Z2lucyBpbnN0YW5jZW9mIEFycmF5ICYmXG4gICAgICBlZGl0b3JTZXR0aW5ncy5wbHVnaW5zLmxlbmd0aCA+IDAgJiZcbiAgICAgIGVkaXRvclNldHRpbmdzLmhhc093blByb3BlcnR5KCdhZGRQbHVnaW5zJykpIHtcbiAgICAgIGVkaXRvclNldHRpbmdzLmFkZFBsdWdpbnMoZWRpdG9yU2V0dGluZ3MucGx1Z2lucylcbiAgICB9XG5cbiAgICBmb3IgKHZhciBvIGluIGludGVyZmFjZXMpIHtcbiAgICAgIHRoaXNbb10gPSBpbnRlcmZhY2VzW29dXG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIOyXkOuUlO2EsOulvCDsg53shLEg67CPIO2ItOydhCDstpTqsIDtlZzri6QuXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBzZWwgc2VsZWN0b3JcbiAgICogQHBhcmFtIHtvYmplY3R9IG9wdGlvbnNcbiAgICogQHBhcmFtIHtvYmplY3R9IGVkaXRvck9wdGlvbnNcbiAgICogQHBhcmFtIHthcnJheX0gdG9vbEluZm9MaXN0XG4gICAqL1xuICBhc3luYyBjcmVhdGUgKHNlbCwgb3B0aW9ucywgZWRpdG9yT3B0aW9ucywgdG9vbEluZm9MaXN0KSB7XG4gICAgdG9vbEluZm9MaXN0ID0gdG9vbEluZm9MaXN0IHx8IFtdXG4gICAgZWRpdG9yT3B0aW9ucyA9ICQuZXh0ZW5kKHRoaXMuY29uZmlncyB8fCB7fSwgZWRpdG9yT3B0aW9ucyB8fCB7fSlcblxuICAgIGlmIChFZGl0b3JWYWxpZGF0aW9uLmlzVmFsaWRCZWZvcmVDcmVhdGVJbnN0YW5jZShzZWwsIHRvb2xJbmZvTGlzdCwgdGhpcykpIHtcbiAgICAgIGNvbnN0IGVkaXRvckludGFuY2UgPSBuZXcgRWRpdG9ySW5zdGFuY2UodGhpcy5uYW1lLCBzZWwsIGVkaXRvck9wdGlvbnMsIHRvb2xJbmZvTGlzdClcbiAgICAgIGVkaXRvckludGFuY2UuX2VkaXRvciA9IHRoaXNcbiAgICAgIHRoaXMuZWRpdG9yTGlzdFtzZWxdID0gZWRpdG9ySW50YW5jZVxuICAgICAgdmFyIHJlc3VsdCA9IHRoaXMuaW5pdGlhbGl6ZS5jYWxsKHRoaXMuZWRpdG9yTGlzdFtzZWxdLCBzZWwsIG9wdGlvbnMsIGVkaXRvck9wdGlvbnMpXG4gICAgICBpZiAocmVzdWx0IGluc3RhbmNlb2YgUHJvbWlzZSkge1xuICAgICAgICBhd2FpdCByZXN1bHRcbiAgICAgIH1cblxuICAgICAgaWYgKCEhdG9vbEluZm9MaXN0ICYmIHRvb2xJbmZvTGlzdC5sZW5ndGggPiAwKSB7XG4gICAgICAgIGxldCB0b29scyA9IHt9XG4gICAgICAgIGxldCB0b29sSW5mb0xpc3RGaWx0ZXIgPSBbXVxuXG4gICAgICAgIGZvciAobGV0IGkgPSAwLCBtYXggPSB0b29sSW5mb0xpc3QubGVuZ3RoOyBpIDwgbWF4OyBpICs9IDEpIHtcbiAgICAgICAgICBpZiAod2luZG93LlhFZWRpdG9yLmdldFRvb2wodG9vbEluZm9MaXN0W2ldLmlkKSkge1xuICAgICAgICAgICAgdG9vbHNbdG9vbEluZm9MaXN0W2ldLmlkXSA9IHdpbmRvdy5YRWVkaXRvci5nZXRUb29sKHRvb2xJbmZvTGlzdFtpXS5pZClcbiAgICAgICAgICAgIHRvb2xJbmZvTGlzdEZpbHRlci5wdXNoKHRvb2xJbmZvTGlzdFtpXSlcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgY29uc29sZS5lcnJvcignZGVmaW5l65CcIHRvb2zsnbQg7KG07J6s7ZWY7KeAIOyViuydjC4gWycgKyB0b29sSW5mb0xpc3RbaV0uaWQgKyAnXScpXG4gICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKHRoaXMuYWRkVG9vbHMgJiYgdHlwZW9mIHRoaXMuYWRkVG9vbHMgPT09ICdmdW5jdGlvbicpIHtcbiAgICAgICAgICB0aGlzLmFkZFRvb2xzLmNhbGwodGhpcy5lZGl0b3JMaXN0W3NlbF0sIHRvb2xzLCB0b29sSW5mb0xpc3RGaWx0ZXIpXG4gICAgICAgIH1cbiAgICAgIH1cblxuICAgICAgdGhpcy4kJGVtaXQoJ2VkaXRvci5jcmVhdGVkJywgdGhpcy5lZGl0b3JMaXN0W3NlbF0pXG4gICAgICByZXR1cm4gdGhpcy5lZGl0b3JMaXN0W3NlbF1cbiAgICB9XG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9yRGVmaW5lXG4iLCJpbXBvcnQgeyBldmVudGlmeSB9IGZyb20gJ3hlLXV0aWxzJyAvLyBARklYTUUgaHR0cHM6Ly9naXRodWIuY29tL3hwcmVzc2VuZ2luZS94cHJlc3NlbmdpbmUvaXNzdWVzLzc2NVxuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuXG4vKipcbiAqIEBjbGFzc1xuICovXG5jbGFzcyBFZGl0b3JJbnN0YW5jZSB7XG4gIC8qKlxuICAgKiBAY29uc3RydWN0b3JcbiAgICogQHBhcmFtIHtzdHJpbmd9IGVkaXRvck5hbWVcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbCBzZWxlY3RvclxuICAgKiBAcGFyYW0ge29iamVjdH0gZWRpdG9yT3B0aW9uc1xuICAgKiBAcGFyYW0ge2FycmF5fSB0b29sSW5mb0xpc3Qg7JeQ65SU7YSw7JeQIOy2lOqwgOuQoCB0b29sIOygleuztCDrpqzsiqTtirhcbiAgICovXG4gIGNvbnN0cnVjdG9yIChlZGl0b3JOYW1lLCBzZWwsIGVkaXRvck9wdGlvbnMsIHRvb2xJbmZvTGlzdCkge1xuICAgIC8qKiBAcHJpdmF0ZSAqL1xuICAgIGxldCBfb3B0aW9ucyA9IHtcbiAgICAgIGVkaXRvck9wdGlvbnM6IGVkaXRvck9wdGlvbnMsXG4gICAgICB0b29sSW5mb0xpc3Q6IHRvb2xJbmZvTGlzdFxuICAgIH1cblxuICAgIGV2ZW50aWZ5KHRoaXMpXG5cbiAgICAvKiogQHB1YmxpYyAqL1xuICAgIHRoaXMuZWRpdG9yTmFtZSA9IGVkaXRvck5hbWVcbiAgICAvKiogQHB1YmxpYyAqL1xuICAgIHRoaXMuc2VsZWN0b3IgPSBzZWxcbiAgICAvKiogQHB1YmxpYyAqL1xuICAgIHRoaXMucHJvcHMgPSB7fVxuICAgIC8qKlxuICAgICAqIOyXkOuUlO2EsCDsmLXshZjsnYQg67CY7ZmY7ZWc64ukLlxuICAgICAqIEBwdWJsaWNcbiAgICAgKiBAbWV0aG9kXG4gICAgICovXG4gICAgdGhpcy5nZXRPcHRpb25zID0gZnVuY3Rpb24gKCkge1xuICAgICAgcmV0dXJuIF9vcHRpb25zXG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIOyDneyEseuQnCBpbnN0YW5jZeulvCDrsJjtmZjtlZzri6RJbnN0YW5jZU9iai5cbiAgICogQG1ldGhvZFxuICAgKiBAcmV0dXJuIHtvYmplY3R9XG4gICAqL1xuICBnZXRJbnN0YW5jZSAoKSB7XG4gICAgcmV0dXJuIHRoaXNcbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDsl5Ag7J6R7ISx65CcIOy7qO2FkOy4oOulvCDrsJjtmZjtlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHJldHVybiB7c3RyaW5nfVxuICAgKi9cbiAgZ2V0Q29udGVudHMgKCkge1xuICAgIHJldHVybiBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5nZXRDb250ZW50cy5jYWxsKHRoaXMpXG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw7JeQIOuCtOyaqeydhCDsnoXroKXtlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHtzdHJpbmd9IHRleHRcbiAgICovXG4gIHNldENvbnRlbnRzICh0ZXh0KSB7XG4gICAgWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0uc2V0Q29udGVudHMuY2FsbCh0aGlzLCB0ZXh0KVxuICB9XG5cbiAgLyoqXG4gICAqIOyXkOuUlO2EsOyXkCDrgrTsmqnsnYQg7J6F66Cl7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEBwYXJhbSB7c3RyaW5nfSB0ZXh0XG4gICAqL1xuICBhZGRDb250ZW50cyAodGV4dCkge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLmFkZENvbnRlbnRzLmNhbGwodGhpcywgdGV4dClcbiAgfVxuXG4gIC8qKlxuICAgKiDsg53shLHrkJwgaW5zdGFuY2Xsl5AgcHJvcGVydHnrpbwg65Ox66Gd7ZWc64ukLlxuICAgKiBAbWV0aG9kXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBvYmpcbiAgICovXG4gIGFkZFByb3BzIChvYmopIHtcbiAgICBmb3IgKHZhciBvIGluIG9iaikge1xuICAgICAgdGhpcy5wcm9wc1tvXSA9IG9ialtvXVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDsl5Ag7Yi07J2EIOy2lOqwgO2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge2FycmF5fSB0b29sSW5zdGFuY2VMaXN0XG4gICAqL1xuICBhZGRUb29scyAodG9vbEluc3RhbmNlTGlzdCkge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLmFkZFRvb2xzLmNhbGwodGhpcywgdGhpcy5nZXRPcHRpb25zKCkudG9vbEluZm9MaXN0LCB0b29sSW5zdGFuY2VMaXN0KVxuICB9XG5cbiAgLyoqXG4gICAqIOq1rO2YhOuQnCDsl5DrlJTthLDsl5Ag7J2067Kk7Yq466W8IO2VoOuLue2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge3N0cmluZ30gZXZlbnROYW1lXG4gICAqIEBwYXJhbSB7ZnVuY3Rpb259IGNhbGxiYWNrIGV2ZW50IGNhbGxiYWNrXG4gICAqL1xuICBvbiAoZXZlbnROYW1lLCBjYWxsYmFjaykge1xuICAgIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLm9uLmNhbGwodGhpcywgZXZlbnROYW1lLCBjYWxsYmFjaylcbiAgfVxuXG4gIC8qKlxuICAgKiDqtaztmITrkJwg7JeQ65SU7YSwIO2MjOydvCDsl4XroZzrk5wg6riw64ql7J2EIO2YuOy2o+2VnOuLpC5cbiAgICogQG1ldGhvZFxuICAgKiBAcGFyYW0ge29iamVjdH0gY3VzdG9tT3B0aW9uc1xuICAgKi9cbiAgcmVuZGVyRmlsZVVwbG9hZGVyIChjdXN0b21PcHRpb25zKSB7XG4gICAgWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0ucmVuZGVyRmlsZVVwbG9hZGVyLmNhbGwodGhpcywgY3VzdG9tT3B0aW9ucylcbiAgfVxuXG4gIGdldENvbnRlbnREb20gKCkge1xuICAgIGlmICh0eXBlb2YgWEVlZGl0b3IuZWRpdG9yU2V0W3RoaXMuZWRpdG9yTmFtZV0uZ2V0Q29udGVudERvbSA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgcmV0dXJuIFhFZWRpdG9yLmVkaXRvclNldFt0aGlzLmVkaXRvck5hbWVdLmdldENvbnRlbnREb20uY2FsbCh0aGlzKVxuICAgIH1cbiAgICByZXR1cm4gZmFsc2VcbiAgfVxuXG4gIC8qKlxuICAgKiDqtaztmITrkJwg7JeQ65SU7YSwIHJlc2V0IO2VqOyImOulvCDtmLjstpztlZzri6QuXG4gICAqIEBtZXRob2RcbiAgICogQHBhcmFtIHtvYmplY3R9IGN1c3RvbU9wdGlvbnNcbiAgICovXG4gIHJlc2V0ICgpIHtcbiAgICBYRWVkaXRvci5lZGl0b3JTZXRbdGhpcy5lZGl0b3JOYW1lXS5yZXNldC5jYWxsKHRoaXMpXG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9ySW5zdGFuY2VcbiIsIi8qKlxuICogQGNsYXNzXG4gKi9cbmNsYXNzIEVkaXRvclRvb2wge1xuICBjb25zdHJ1Y3RvciAob2JqKSB7XG4gICAgZm9yIChsZXQgbyBpbiBvYmopIHtcbiAgICAgIHRoaXNbb10gPSBvYmpbb11cbiAgICB9XG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9yVG9vbFxuIiwiaW1wb3J0IHsgRWRpdG9yRGVmaW5lRXJyb3IsIEVkaXRvclRvb2xEZWZpbmVFcnJvciwgRWRpdG9yVXNlZENvbnRhaW5lciwgRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyIH0gZnJvbSAnLi9lcnJvcnMvZWRpdG9yLmVycm9yJ1xuXG4vKipcbiAqIEBwcml2YXRlXG4gKi9cbmNvbnN0IHJlcXVpcmVPcHRpb25zID0ge1xuICBlZGl0b3JTZXR0aW5nczogW1xuICAgICduYW1lJ1xuICBdLFxuICBpbnRlcmZhY2VzOiBbXG4gICAgJ2luaXRpYWxpemUnLFxuICAgICdhZGRDb250ZW50cycsXG4gICAgJ2dldENvbnRlbnRzJyxcbiAgICAnc2V0Q29udGVudHMnLFxuICAgICdnZXRDb250ZW50RG9tJ1xuICBdLFxuICB0b29sczoge1xuICAgIHByb3BlcnR5OiBbXG4gICAgICAnaWQnLFxuICAgICAgJ2V2ZW50cydcbiAgICBdLFxuICAgIGV2ZW50czogW1xuICAgICAgJ2ljb25DbGljaycsXG4gICAgICAnZWxlbWVudERvdWJsZUNsaWNrJ1xuICAgIF1cbiAgfVxufVxuXG4vKipcbiAqIEBjbGFzc1xuICovXG5jbGFzcyBFZGl0b3JWYWxpZGF0aW9uIHtcbiAgLyoqXG4gICAqIEVkaXRvcuydmCBpbnN0YW5jZeulvCDsg53shLHtlZjquLAg7KCEIOykkeuztSDqsoDsgqwg65OxIOyImO2WiVxuICAgKiBAcGFyYW0ge3N0cmluZ30gc2VsIGpRdWVyeSBzZWxlY3RvclxuICAgKiBAcGFyYW0ge2FycmF5fSB0b29sSWRMaXN0XG4gICAqIEBwYXJhbSB7b2JqZWN0fSBlZGl0b3JQYXJlbnRcbiAgICogQHJldHVybiB7Ym9vbGVhbn1cbiAgICogQHRocm93cyB7RWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyfVxuICAgKiBAdGhyb3dzIHtFZGl0b3JVc2VkQ29udGFpbmVyfVxuICAgKi9cbiAgc3RhdGljIGlzVmFsaWRCZWZvcmVDcmVhdGVJbnN0YW5jZSAoc2VsLCB0b29sSWRMaXN0LCBlZGl0b3JQYXJlbnQpIHtcbiAgICBpZiAoIXNlbCkge1xuICAgICAgLy8gc2VsZWN0b3LqsIAg7JeG7J2MXG4gICAgICB0aHJvdyBuZXcgRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyKCdFZGl0b3LqsIAg7IKs7Jqp7ZWgIGZpZWxk66W8IOyngOygle2VtOyVvCDtlanri4jri6QuJylcbiAgICB9XG5cbiAgICBpZiAoZWRpdG9yUGFyZW50LmVkaXRvckxpc3QubGVuZ3RoID4gMCkge1xuICAgICAgbGV0IHNlbFZhbGlkID0gdHJ1ZVxuICAgICAgZm9yIChsZXQgaSA9IDAsIG1heCA9IGVkaXRvclBhcmVudC5lZGl0b3JMaXN0Lmxlbmd0aDsgaSA8IG1heDsgaSArPSAxKSB7XG4gICAgICAgIGlmIChlZGl0b3JQYXJlbnQuZWRpdG9yTGlzdFtpXSA9PT0gc2VsKSB7XG4gICAgICAgICAgc2VsVmFsaWQgPSBmYWxzZVxuICAgICAgICAgIHRocm93IG5ldyBFZGl0b3JVc2VkQ29udGFpbmVyKGBFZGl0b3LqsIAg7J2066+4IOyCrOyaqSDspJHsnoXri4jri6Q6ICR7c2VsfWApXG4gICAgICAgIH1cbiAgICAgIH1cblxuICAgICAgaWYgKCFzZWxWYWxpZCkge1xuICAgICAgICByZXR1cm4gZmFsc2VcbiAgICAgIH1cbiAgICB9XG5cbiAgICByZXR1cm4gdHJ1ZVxuICB9XG5cbiAgLyoqXG4gICAqIEB0eXBlZGVmIHtPYmplY3R9IGVkaXRvckRlZmluaXRpb25cbiAgICogQHByb3BlcnR5IHtvYmplY3R9IGVkaXRvckRlZmluaXRpb24uZWRpdG9yU2V0dGluZ3Mg7JeQ65SU7YSwIOyEpOyglSDsoJXrs7RcbiAgICogQHByb3BlcnR5IHtzdHJpbmd9IGVkaXRvckRlZmluaXRpb24uZWRpdG9yU2V0dGluZ3MubmFtZSDsl5DrlJTthLAg7ISk7KCVIOygleuztFxuICAgKiBAcHJvcGVydHkge29iamVjdH0gZWRpdG9yRGVmaW5pdGlvbi5pbnRlcmZhY2VzIOq1rO2YhOuQnCDsl5DrlJTthLAg7J247YSw7Y6Y7J207IqkXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcy5pbml0aWFsaXplXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcy5hZGRDb250ZW50c1xuICAgKiBAcHJvcGVydHkge2Z1bmN0aW9ufSBlZGl0b3JEZWZpbml0aW9uLmludGVyZmFjZXMuZ2V0Q29udGVudHNcbiAgICogQHByb3BlcnR5IHtmdW5jdGlvbn0gZWRpdG9yRGVmaW5pdGlvbi5pbnRlcmZhY2VzLnNldENvbnRlbnRzXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGVkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlcy5nZXRDb250ZW50RG9tXG4gICAqL1xuXG4gIC8qKlxuICAgKiBFZGl0b3Ig7KCV7J2Y6rCAIOyYrOuwlOuluOyngCDqsoDsgqxcbiAgICogQHBhcmFtIHtlZGl0b3JEZWZpbml0aW9uLmVkaXRvclNldHRpbmdzfSBlZGl0b3JTZXR0aW5nc1xuICAgKiBAcGFyYW0ge2VkaXRvckRlZmluaXRpb24uaW50ZXJmYWNlc30gaW50ZXJmYWNlc1xuICAgKiBAcmV0dXJuIHtib29sZWFufVxuICAgKiBAdGhyb3dzIHtFZGl0b3JEZWZpbmVFcnJvcn1cbiAgICovXG4gIHN0YXRpYyBpc1ZhbGlkRWRpdG9yT3B0aW9ucyAoZWRpdG9yU2V0dGluZ3MsIGludGVyZmFjZXMpIHtcbiAgICBsZXQgdmFsaWQgPSB0cnVlXG4gICAgZm9yIChsZXQgZVNldHRpbmdzIGluIHJlcXVpcmVPcHRpb25zLmVkaXRvclNldHRpbmdzKSB7XG4gICAgICBpZiAoIWVkaXRvclNldHRpbmdzLmhhc093blByb3BlcnR5KHJlcXVpcmVPcHRpb25zLmVkaXRvclNldHRpbmdzW2VTZXR0aW5nc10pKSB7XG4gICAgICAgIHZhbGlkID0gZmFsc2VcbiAgICAgICAgdGhyb3cgbmV3IEVkaXRvckRlZmluZUVycm9yKGBFZGl0b3Ig6rec6rKp7J20IOunnuyngCDslYrsnYwgKOq1rO2YhCDtlYTsmpQgW2VkaXRvclNldHRpbmdzOiAke3JlcXVpcmVPcHRpb25zLmVkaXRvclNldHRpbmdzW2VTZXR0aW5nc119XSlgKVxuICAgICAgfVxuICAgIH1cblxuICAgIGZvciAobGV0IGVJbnRlcmZhY2UgaW4gcmVxdWlyZU9wdGlvbnMuaW50ZXJmYWNlcykge1xuICAgICAgaWYgKCFpbnRlcmZhY2VzLmhhc093blByb3BlcnR5KHJlcXVpcmVPcHRpb25zLmludGVyZmFjZXNbZUludGVyZmFjZV0pKSB7XG4gICAgICAgIHZhbGlkID0gZmFsc2VcbiAgICAgICAgdGhyb3cgbmV3IEVkaXRvckRlZmluZUVycm9yKGBFZGl0b3Ig6rec6rKp7J20IOunnuyngCDslYrsnYwgKOq1rO2YhCDtlYTsmpQgW2ludGVyZmFjZTogJHtyZXF1aXJlT3B0aW9ucy5pbnRlcmZhY2VzW2VJbnRlcmZhY2VdfV0pYClcbiAgICAgIH1cbiAgICB9XG5cbiAgICBpZiAoZWRpdG9yU2V0dGluZ3MuaGFzT3duUHJvcGVydHkoJ3BsdWdpbnMnKSAmJlxuICAgICAgZWRpdG9yU2V0dGluZ3MucGx1Z2lucyBpbnN0YW5jZW9mIEFycmF5ICYmXG4gICAgICBlZGl0b3JTZXR0aW5ncy5wbHVnaW5zLmxlbmd0aCA+IDAgJiZcbiAgICAgICFlZGl0b3JTZXR0aW5ncy5oYXNPd25Qcm9wZXJ0eSgnYWRkUGx1Z2lucycpKSB7XG4gICAgICB2YWxpZCA9IGZhbHNlXG4gICAgICB0aHJvdyBuZXcgRWRpdG9yRGVmaW5lRXJyb3IoYEVkaXRvciDqt5zqsqnsnbQg66ee7KeAIOyViuydjCAo6rWs7ZiEIO2VhOyalCBbZm46YWRkUGx1Z2luc10pYClcbiAgICB9XG5cbiAgICBpZiAod2luZG93LlhFZWRpdG9yLmVkaXRvclNldC5oYXNPd25Qcm9wZXJ0eShlZGl0b3JTZXR0aW5ncy5uYW1lKSkge1xuICAgICAgdmFsaWQgPSBmYWxzZVxuICAgICAgdGhyb3cgbmV3IEVkaXRvckRlZmluZUVycm9yKGDsnbTrr7gg6rCZ7J2AIOydtOumhOydmCDsl5DrlJTthLDqsIAg65Ox66Gd65CY7Ja0IOyeiOydjDogJHtlZGl0b3JTZXR0aW5ncy5uYW1lfWApXG4gICAgfVxuXG4gICAgcmV0dXJuICEoIXZhbGlkKVxuICB9XG5cbiAgLyoqXG4gICAqIEB0eXBlZGVmIHtPYmplY3R9IGVkaXRvclRvb2xEZWZpbml0aW9uXG4gICAqIEBwcm9wZXJ0eSB7c3RyaW5nfSBpZFxuICAgKiBAcHJvcGVydHkge29iamVjdH0gZXZlbnRzXG4gICAqIEBwcm9wZXJ0eSB7ZnVuY3Rpb259IGV2ZW50cy5pY29uQ2xpY2tcbiAgICogQHByb3BlcnR5IHtmdW5jdGlvbn0gZXZlbnRzLmVsZW1lbnREb3VibGVDbGlja1xuICAgKiBAZGVwcmVjYXRlZFxuICAgKi9cblxuICAvKipcbiAgICogRWRpdG9yVG9vbCDsoJXsnZjqsIAg7Jis67CU66W47KeAIOqygOyCrFxuICAgKiBAcGFyYW0ge2VkaXRvclRvb2xEZWZpbml0aW9ufSB0b29sRGVmaW5lXG4gICAqIEByZXR1cm4ge2Jvb2xlYW59XG4gICAqIEB0aHJvd3Mge0VkaXRvclRvb2xEZWZpbmVFcnJvcn1cbiAgICovXG4gIHN0YXRpYyBpc1ZhbGlkVG9vbHNPYmplY3QgKHRvb2xEZWZpbmUpIHtcbiAgICBsZXQgdmFsaWQgPSB0cnVlXG5cbiAgICBmb3IgKGxldCBpID0gMCwgbWF4ID0gcmVxdWlyZU9wdGlvbnMudG9vbHMucHJvcGVydHkubGVuZ3RoOyBpIDwgbWF4OyBpICs9IDEpIHtcbiAgICAgIGlmICghdG9vbERlZmluZS5oYXNPd25Qcm9wZXJ0eShyZXF1aXJlT3B0aW9ucy50b29scy5wcm9wZXJ0eVtpXSkpIHtcbiAgICAgICAgdmFsaWQgPSBmYWxzZVxuICAgICAgICB0aHJvdyBuZXcgRWRpdG9yVG9vbERlZmluZUVycm9yKGBFZGl0b3JUb29sIOq3nOqyqeydtCDrp57sp4Ag7JWK7J2MICjsho3shLHsnbQg7JeG7J2MOiAke3JlcXVpcmVPcHRpb25zLnRvb2xzLnByb3BlcnR5W2ldfSlgKVxuICAgICAgfVxuICAgIH1cblxuICAgIGZvciAobGV0IGkgPSAwLCBtYXggPSByZXF1aXJlT3B0aW9ucy50b29scy5ldmVudHMubGVuZ3RoOyBpIDwgbWF4OyBpICs9IDEpIHtcbiAgICAgIGlmICghdG9vbERlZmluZS5ldmVudHMuaGFzT3duUHJvcGVydHkocmVxdWlyZU9wdGlvbnMudG9vbHMuZXZlbnRzW2ldKSkge1xuICAgICAgICB2YWxpZCA9IGZhbHNlXG4gICAgICAgIHRocm93IG5ldyBFZGl0b3JUb29sRGVmaW5lRXJyb3IoYEVkaXRvclRvb2wg6rec6rKp7J20IOunnuyngCDslYrsnYwgKOydtOuypO2KuOqwgCDsoJXsnZjrkJjsp4Ag7JWK7J2MOiAke3JlcXVpcmVPcHRpb25zLnRvb2xzLmV2ZW50c1tpXX0pYClcbiAgICAgIH1cbiAgICB9XG5cbiAgICByZXR1cm4gdmFsaWRcbiAgfVxufVxuXG5leHBvcnQgZGVmYXVsdCBFZGl0b3JWYWxpZGF0aW9uXG5cbmV4cG9ydCB7XG4gIHJlcXVpcmVPcHRpb25zXG59XG4iLCJpbXBvcnQgWGVFcnJvciBmcm9tICd4ZS9lcnJvcidcblxuLyoqXG4gKiBAbW9kdWxlIFhlRXJyb3IvRWRpdG9yRGVmaW5lRXJyb3JcbiAqIEBleHRlbmRzIFhlRXJyb3JcbiAqL1xuY2xhc3MgRWRpdG9yRGVmaW5lRXJyb3IgZXh0ZW5kcyBYZUVycm9yIHtcbiAgY29uc3RydWN0b3IgKG1lc3NhZ2UpIHtcbiAgICBzdXBlcihtZXNzYWdlKVxuICB9XG59XG5cbi8qKlxuICogQG1vZHVsZSBYZUVycm9yL0VkaXRvclRvb2xEZWZpbmVFcnJvclxuICogQGV4dGVuZHMgWGVFcnJvclxuICovXG5jbGFzcyBFZGl0b3JUb29sRGVmaW5lRXJyb3IgZXh0ZW5kcyBYZUVycm9yIHtcbiAgY29uc3RydWN0b3IgKG1lc3NhZ2UpIHtcbiAgICBzdXBlcihtZXNzYWdlKVxuICB9XG59XG5cbi8qKlxuICogQG1vZHVsZSBYZUVycm9yL0VkaXRvclVzZWRDb250YWluZXJcbiAqIEBleHRlbmRzIFhlRXJyb3JcbiAqL1xuY2xhc3MgRWRpdG9yVXNlZENvbnRhaW5lciBleHRlbmRzIFhlRXJyb3Ige1xuICBjb25zdHJ1Y3RvciAobWVzc2FnZSkge1xuICAgIHN1cGVyKG1lc3NhZ2UpXG4gIH1cbn1cblxuLyoqXG4gKiBAbW9kdWxlIFhlRXJyb3IvRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyXG4gKiBAZXh0ZW5kcyBYZUVycm9yXG4gKi9cbmNsYXNzIEVkaXRvclVuZGVmaW5lZENvbnRhaW5lciBleHRlbmRzIFhlRXJyb3Ige1xuICBjb25zdHJ1Y3RvciAobWVzc2FnZSkge1xuICAgIHN1cGVyKG1lc3NhZ2UpXG4gIH1cbn1cblxuZXhwb3J0IHtcbiAgRWRpdG9yRGVmaW5lRXJyb3IsXG4gIEVkaXRvclRvb2xEZWZpbmVFcnJvcixcbiAgRWRpdG9yVXNlZENvbnRhaW5lcixcbiAgRWRpdG9yVW5kZWZpbmVkQ29udGFpbmVyXG59XG4iLCJpbXBvcnQgJCBmcm9tICdqcXVlcnknXG5pbXBvcnQgQXBwIGZyb20gJ3hlL2FwcCdcbmltcG9ydCBFZGl0b3JEZWZpbmUgZnJvbSAnLi9lZGl0b3JEZWZpbmUnXG5pbXBvcnQgRWRpdG9yVmFsaWRhdGlvbiBmcm9tICcuL2VkaXRvclZhbGlkYXRpb24nXG5pbXBvcnQgRWRpdG9yVG9vbCBmcm9tICcuL2VkaXRvclRvb2wnXG5pbXBvcnQgWEUgZnJvbSAneGUnXG5cbi8qKlxuICogQGNsYXNzXG4gKiBAZXh0ZW5kcyBBcHBcbiAqL1xuY2xhc3MgRWRpdG9yIGV4dGVuZHMgQXBwIHtcbiAgY29uc3RydWN0b3IgKCkge1xuICAgIHN1cGVyKClcblxuICAgIHRoaXMudG9vbHNTZXQgPSB7fVxuICAgIHRoaXMuZWRpdG9yU2V0ID0ge31cbiAgICB0aGlzLmVkaXRvck9wdGlvblNldCA9IHt9XG5cbiAgICAvKipcbiAgICAgKiBAREVQUkVDQVRFRFxuICAgICAqKi9cbiAgICB0aGlzLnRvb2xzID0ge1xuICAgICAgZGVmaW5lOiBvYmogPT4ge1xuICAgICAgICBpZiAoJC5pc0Z1bmN0aW9uKGNvbnNvbGUud2FybikgJiYgJC5pc0Z1bmN0aW9uKGNvbnNvbGUudHJhY2UpKSB7XG4gICAgICAgICAgY29uc29sZS53YXJuKCdERVBSRUNBVEVEOiBYRWVkaXRvci50b29scy5kZWZpbmUoKSBpcyBkZXByZWNhdGVkLiB1c2UgWEVlZGl0b3IuZGVmaW5lVG9vbCcpXG4gICAgICAgICAgY29uc29sZS50cmFjZSgpXG4gICAgICAgIH1cbiAgICAgICAgdGhpcy5kZWZpbmVUb29sKG9iailcbiAgICAgIH0sXG4gICAgICBnZXQ6IGlkID0+IHtcbiAgICAgICAgaWYgKCQuaXNGdW5jdGlvbihjb25zb2xlLndhcm4pICYmICQuaXNGdW5jdGlvbihjb25zb2xlLnRyYWNlKSkge1xuICAgICAgICAgIGNvbnNvbGUud2FybignREVQUkVDQVRFRDogWEVlZGl0b3IudG9vbHMuZ2V0KCkgaXMgZGVwcmVjYXRlZC4gdXNlIFhFZWRpdG9yLmdldFRvb2wnKVxuICAgICAgICAgIGNvbnNvbGUudHJhY2UoKVxuICAgICAgICB9XG4gICAgICAgIHJldHVybiB0aGlzLmdldFRvb2woaWQpXG4gICAgICB9XG4gICAgfVxuICB9XG5cbiAgc3RhdGljIGFwcE5hbWUgKCkge1xuICAgIHJldHVybiAnRWRpdG9yJ1xuICB9XG5cbiAgYm9vdCAoWEUpIHtcbiAgICBpZiAodGhpcy5ib290ZWQoKSkge1xuICAgICAgcmV0dXJuIFByb21pc2UucmVzb2x2ZSh0aGlzKVxuICAgIH1cblxuICAgIHJldHVybiBuZXcgUHJvbWlzZSgocmVzb2x2ZSkgPT4ge1xuICAgICAgc3VwZXIuYm9vdChYRSlcblxuICAgICAgcmVzb2x2ZSh0aGlzKVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICog7JeQ65SU7YSw66W8IOygleydmO2VnOuLpC5cbiAgICogQHByb3BlcnR5IHtlZGl0b3JEZWZpbml0aW9ufSBvYmpcbiAgICoqL1xuICBkZWZpbmUgKG9iaikge1xuICAgIGNvbnN0IGVkaXRvclNldHRpbmdzID0gb2JqLmVkaXRvclNldHRpbmdzXG4gICAgY29uc3QgaW50ZXJmYWNlcyA9IG9iai5pbnRlcmZhY2VzXG5cbiAgICB0cnkge1xuICAgICAgaWYgKEVkaXRvclZhbGlkYXRpb24uaXNWYWxpZEVkaXRvck9wdGlvbnMoZWRpdG9yU2V0dGluZ3MsIGludGVyZmFjZXMpKSB7XG4gICAgICAgIGNvbnN0IGVkaXRvciA9IG5ldyBFZGl0b3JEZWZpbmUoZWRpdG9yU2V0dGluZ3MsIGludGVyZmFjZXMpXG4gICAgICAgIHRoaXMuZWRpdG9yU2V0W2VkaXRvclNldHRpbmdzLm5hbWVdID0gZWRpdG9yXG4gICAgICAgIHRoaXMuZWRpdG9yT3B0aW9uU2V0W2VkaXRvclNldHRpbmdzLm5hbWVdID0gZWRpdG9yU2V0dGluZ3NcbiAgICAgICAgdGhpcy4kJGVtaXQoJ2VkaXRvci5kZWZpbmUnLCBlZGl0b3IpXG4gICAgICB9XG4gICAgfSBjYXRjaCAoZSkge1xuICAgICAgLy8gY29uc29sZS5lcnJvcihlKVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDsl5DrlJTthLDrpbwg67CY7ZmY7ZWc64ukLlxuICAgKiBAcGFyYW0ge3N0cmluZ30gbmFtZVxuICAgKiBAcmV0dXJuIHtQcm9taXNlfVxuICAgKiovXG4gIGdldEVkaXRvciAobmFtZSkge1xuICAgIGlmICh0aGlzLmVkaXRvclNldFtuYW1lXSkge1xuICAgICAgcmV0dXJuIFByb21pc2UucmVzb2x2ZSh0aGlzLmVkaXRvclNldFtuYW1lXSlcbiAgICB9XG5cbiAgICByZXR1cm4gbmV3IFByb21pc2UoKHJlc29sdmUpID0+IHtcbiAgICAgIHRoaXMuJCRvbignZWRpdG9yLmRlZmluZScsIChldmVudE5hbWUsIGVkaXRvcikgPT4ge1xuICAgICAgICByZXNvbHZlKGVkaXRvcilcbiAgICAgIH0pXG4gICAgfSlcbiAgfVxuXG4gIC8qKlxuICAgKiBFZGl0b3JUb29sIOygleydmFxuICAgKlxuICAgKiBAcGFyYW0ge2VkaXRvclRvb2xEZWZpbml0aW9ufSBvYmpcbiAgICovXG4gIGRlZmluZVRvb2wgKG9iaikge1xuICAgIHRyeSB7XG4gICAgICBpZiAoRWRpdG9yVmFsaWRhdGlvbi5pc1ZhbGlkVG9vbHNPYmplY3Qob2JqKSkge1xuICAgICAgICB0aGlzLnRvb2xzU2V0W29iai5pZF0gPSBuZXcgRWRpdG9yVG9vbChvYmopXG4gICAgICB9XG4gICAgfSBjYXRjaCAoZSkge1xuICAgICAgY29uc29sZS5lcnJvcihlKVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBFZGl0b3JUb29sIOuwmO2ZmFxuICAgKlxuICAgKiBAcGFyYW0ge3N0cmluZ30gaWRcbiAgICogQHJldHVybiB7RWRpdG9yVG9vbH1cbiAgICovXG4gIGdldFRvb2wgKGlkKSB7XG4gICAgcmV0dXJuIHRoaXMudG9vbHNTZXRbaWRdXG4gIH1cblxuICAvKipcbiAgICog7Luo7YWQ7Lig7JeQIHRvb2wgaWTrpbwgeGUtdG9vbC1pZCBhdHRyaWJ1dGXsl5Ag7ZWg64u57ZWY7JesIOuwmO2ZmO2VnOuLpC5cbiAgICogQHBhcmFtIHtzdHJpbmd9IGNvbnRlbnRcbiAgICogQHBhcmFtIHtzdHJpbmd9IGlkXG4gICAqIEByZXR1cm4ge3N0cmluZ30gSFRNTCBtYXJrdXAgc3RyaW5nXG4gICAqKi9cbiAgYXR0YWNoRG9tSWQgKGNvbnRlbnQsIGlkKSB7XG4gICAgcmV0dXJuICQoY29udGVudCkuYXR0cigneGUtdG9vbC1pZCcsIGlkKS5jbG9uZSgpLndyYXBBbGwoJzxkaXYvPicpLnBhcmVudCgpLmh0bWwoKVxuICB9XG5cbiAgLyoqXG4gICAqIEBERVBSRUNBVEVEXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBpZFxuICAgKiBAcmV0dXJuIHtzdHJpbmd9IEhUTUwgc2VsZWN0b3Igc3RyaW5nXG4gICAqKi9cbiAgZ2V0RG9tU2VsZWN0b3IgKGlkKSB7XG4gICAgcmV0dXJuICdbeGUtdG9vbC1pZD1cIicgKyBpZCArICdcIl0nXG4gIH1cbn1cblxuZXhwb3J0IGRlZmF1bHQgRWRpdG9yXG5cbi8qKlxuICogQHR5cGUgICAgICAge0VkaXRvcn1cbiAqL1xuY29uc3QgWEVlZGl0b3IgPSBuZXcgRWRpdG9yKClcbmlmICghd2luZG93LlhFZWRpdG9yKSB3aW5kb3cuWEVlZGl0b3IgPSBYRWVkaXRvclxuWEUucmVnaXN0ZXJBcHAoJ0VkaXRvcicsIFhFZWRpdG9yKVxuIiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IFhFIGZyb20gJ3hlJ1xuXG5YRS5hcHAoJ0VkaXRvcicsIChFZGl0b3IpID0+IHtcbiAgRWRpdG9yLmRlZmluZSh7XG4gICAgZWRpdG9yU2V0dGluZ3M6IHtcbiAgICAgIG5hbWU6ICdYRXRleHRhcmVhJyxcbiAgICAgIGNvbmZpZ3M6IHt9XG4gICAgfSxcbiAgICAvKipcbiAgICAgKiBAcHJvcCB7b2JqZWN0fSBpbnRlcmZhY2VzXG4gICAgICogQHByb3Age2Z1bmN0aW9uKHNlbGVjdG9yLG9wdGlvbnMpfSBpbnRlcmZhY2VzLmluaXRpYWxpemVcbiAgICAgKiA8cHJlPlxuICAgICAqICAgYXJndW1lbnRzXG4gICAgICogICAtIHNlbGVjdG9yIDogc3RyaW5nXG4gICAgICogICAtIG9wdGlvbnMgOiBvYmplY3RcbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcHJvcCB7ZnVuY3Rpb259IGludGVyZmFjZXMuZ2V0Q29udGVudHMg7JeQ65SU7YSwIOy7qO2FkOy4oOulvCDrpqzthLTtlZzri6QuXG4gICAgICogQHByb3Age2Z1bmN0aW9ufSBpbnRlcmZhY2VzLnNldENvbnRlbnRzIOyXkOuUlO2EsOyXkCDsu6jthZDsuKDrpbwg642u7Ja07JO064ukLlxuICAgICAqIDxwcmU+XG4gICAgICogICBhcmd1bWVudHNcbiAgICAgKiAgIC0gdGV4dCA6IHN0cmluZ1xuICAgICAqIDwvcHJlPlxuICAgICAqIEBwcm9wIHtmdW5jdGlvbn0gaW50ZXJmYWNlcy5hZGRDb250ZW50cyDsl5DrlJTthLDsl5Ag7Luo7YWQ7Lig66W8IOy2lOqwgO2VnOuLpC5cbiAgICAgKiA8cHJlPlxuICAgICAqICAgYXJndW1lbnRzXG4gICAgICogICAtIHRleHQgOiBzdHJpbmdcbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcHJvcCB7ZnVuY3Rpb259IGludGVyZmFjZXMub24g7JeQ65SU7YSw7JeQIOydtOuypO2KuCDtlbjrk6Trn6zrpbwg7LaU6rCA7ZWc64ukLlxuICAgICAqIDxwcmU+XG4gICAgICogICBhcmd1bWVudHNcbiAgICAgKiAgIC0gZXZlbnROYW1lIDogc3RyaW5nXG4gICAgICogICAtIGNhbGxiYWNrIDogZnVuY3Rpb25cbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcHJvcCB7ZnVuY3Rpb259IGludGVyZmFjZXMucmVzZXQg7JeQ65SU7YSwIOy7qO2FkOy4oOulvCDstIjquLDtmZTtlZzri6QuXG4gICAgICovXG4gICAgaW50ZXJmYWNlczoge1xuICAgICAgaW5pdGlhbGl6ZTogZnVuY3Rpb24gKHNlbGVjdG9yLCBvcHRpb25zKSB7XG4gICAgICAgIG9wdGlvbnMgPSAkLmV4dGVuZCh0cnVlLCB7XG4gICAgICAgICAgZmlsZVVwbG9hZDoge30sXG4gICAgICAgICAgc3VnZ2VzdGlvbjoge30sXG4gICAgICAgICAgbmFtZXM6IHtcbiAgICAgICAgICAgIGZpbGU6IHtcbiAgICAgICAgICAgICAgaW1hZ2U6IHt9XG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgdGFnOiB7fSxcbiAgICAgICAgICAgIG1lbnRpb246IHt9XG4gICAgICAgICAgfSxcbiAgICAgICAgICBleHRlbnNpb25zOiBbXSxcbiAgICAgICAgICBmb250RmFtaWx5OiBbXSxcbiAgICAgICAgICBwZXJtczoge30sXG4gICAgICAgICAgZmlsZXM6IFtdXG4gICAgICAgIH0sIG9wdGlvbnMpXG5cbiAgICAgICAgbGV0ICRlZGl0b3IgPSAkKCcjJyArIHNlbGVjdG9yKVxuICAgICAgICBsZXQgaGVpZ2h0ID0gb3B0aW9ucy5oZWlnaHRcbiAgICAgICAgbGV0IGZvbnRGYW1pbHkgPSBvcHRpb25zLmZvbnRGYW1pbHlcbiAgICAgICAgbGV0IGZvbnRTaXplID0gb3B0aW9ucy5mb250U2l6ZVxuXG4gICAgICAgIHRoaXMuYWRkUHJvcHMoe1xuICAgICAgICAgIGVkaXRvcjogJGVkaXRvciwgc2VsZWN0b3I6IHNlbGVjdG9yLCBvcHRpb25zOiBvcHRpb25zXG4gICAgICAgIH0pXG5cbiAgICAgICAgaWYgKGhlaWdodCkge1xuICAgICAgICAgICRlZGl0b3IuY3NzKCdoZWlnaHQnLCBoZWlnaHQgKyAncHgnKVxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKGZvbnRGYW1pbHkgfHwgZm9udFNpemUpIHtcbiAgICAgICAgICBpZiAoZm9udEZhbWlseSAmJiBmb250RmFtaWx5Lmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICRlZGl0b3IuY3NzKCdmb250LWZhbWlseScsIGZvbnRGYW1pbHkuam9pbignLCcpKVxuICAgICAgICAgIH1cblxuICAgICAgICAgIGlmIChmb250U2l6ZSkge1xuICAgICAgICAgICAgJGVkaXRvci5jc3MoJ2ZvbnQtc2l6ZScsIGZvbnRTaXplKVxuICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgICRlZGl0b3IucGFyZW50cygnZm9ybScpLm9uKCdzdWJtaXQnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgbGV0IGZpbGVJbnB1dCA9IG9wdGlvbnMubmFtZXMuZmlsZS5pbnB1dFxuICAgICAgICAgIGxldCBmaWxlcyA9IG9wdGlvbnMuZmlsZXNcbiAgICAgICAgICBsZXQgJHBhcmFtV3JhcCA9ICQoKVxuXG4gICAgICAgICAgLy8gZmlsZXMgaW5wdXTsgq3soJwg7ZuEIOyDneyEsVxuICAgICAgICAgICRlZGl0b3IubmV4dEFsbCgnLnBhcmFtV3JhcCcpLnJlbW92ZSgpXG4gICAgICAgICAgJGVkaXRvci5hZnRlcihcIjxkaXYgY2xhc3M9J3BhcmFtV3JhcCc+XCIpXG4gICAgICAgICAgJHBhcmFtV3JhcCA9ICRlZGl0b3IubmV4dEFsbCgnLnBhcmFtV3JhcCcpXG5cbiAgICAgICAgICAvLyBmaWxlc1xuICAgICAgICAgIGlmIChmaWxlcy5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBmb3IgKGxldCBpID0gMCwgbWF4ID0gZmlsZXMubGVuZ3RoOyBpIDwgbWF4OyBpICs9IDEpIHtcbiAgICAgICAgICAgICAgbGV0IGZpbGUgPSBmaWxlc1tpXVxuXG4gICAgICAgICAgICAgICRwYXJhbVdyYXAuYXBwZW5kKFwiPGlucHV0IHR5cGU9J2hpZGRlbiduYW1lPSdcIiArIGZpbGVJbnB1dCArIFwiW10nIHZhbHVlPSdcIiArIGZpbGUuaWQgKyBcIicgLz5cIilcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9XG4gICAgICAgIH0pXG4gICAgICB9LFxuXG4gICAgICBnZXRDb250ZW50czogZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gdGhpcy5wcm9wcy5lZGl0b3IudmFsKClcbiAgICAgIH0sXG5cbiAgICAgIHNldENvbnRlbnRzOiBmdW5jdGlvbiAodGV4dCkge1xuICAgICAgICB0aGlzLnByb3BzLmVkaXRvci52YWwodGV4dClcbiAgICAgIH0sXG5cbiAgICAgIGFkZENvbnRlbnRzOiBmdW5jdGlvbiAodGV4dCkge1xuICAgICAgICB2YXIgaHRtbCA9IHRoaXMucHJvcHMuZWRpdG9yLnZhbCgpXG4gICAgICAgIHRoaXMucHJvcHMuZWRpdG9yLnZhbChodG1sKVxuICAgICAgfSxcblxuICAgICAgb246IGZ1bmN0aW9uIChldmVudE5hbWUsIGNhbGxiYWNrKSB7XG4gICAgICAgIHRoaXMucHJvcHMuZWRpdG9yLm9uKGV2ZW50TmFtZSwgY2FsbGJhY2spXG4gICAgICB9LFxuICAgICAgZ2V0Q29udGVudERvbTogZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gZmFsc2VcbiAgICAgIH0sXG4gICAgICByZXNldDogZnVuY3Rpb24gKCkge1xuICAgICAgICAvLyBjb250ZW50cyDsgq3soJxcbiAgICAgICAgdGhpcy5wcm9wcy5lZGl0b3IudmFsKCcnKS5mb2N1cygpXG5cbiAgICAgICAgLy8gaW5wdXQgaGlkZGVuIOyCreygnFxuICAgICAgICB0aGlzLnByb3BzLmVkaXRvci5uZXh0QWxsKCcucGFyYW1XcmFwJykucmVtb3ZlKClcbiAgICAgIH1cbiAgICB9XG4gIH0pXG59KVxuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE0MSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDUxNCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDkpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDM0MCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDcpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg4KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMzApOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTcpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxOCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE3NSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE2Nik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDc2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IF94ZV9kbGxfY29tbW9uOyJdLCJzb3VyY2VSb290IjoiIn0=