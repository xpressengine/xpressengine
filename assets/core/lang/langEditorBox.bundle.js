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
/******/ 	return __webpack_require__(__webpack_require__.s = "./core/lang/LangEditorBox.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./core/config/index.js":
/*!**************************************************************************!*\
  !*** delegated ./core/config/index.js from dll-reference _xe_dll_common ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(36);

/***/ }),

/***/ "./core/lang/LangEditorBox.js":
/*!************************************!*\
  !*** ./core/lang/LangEditorBox.js ***!
  \************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/map */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/concat */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/for-each */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/bind */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/bind.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var xe_config__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! xe/config */ "./core/config/index.js");









/**
 * @private
 * @FIXME
 * @description
 * <pre>
 * 다국어 입력 컴포넌트를 만드는 방식 2가지
 * 1)DOM data속성을 사용하여 document ready상태일 경우 ajax로 한번에 다국어를 요청하여 컴포넌트를 만든다.
 * - ajax이후 langEditorBoxRender 사용시 type이 'obj'로 들어감.
 *
 * 2)langEditorBoxRender:fn 외부에서 직접호출하여 컴포넌트를 만든다
 * - 컴포넌트 state에 다국어 정보가 없으면 하나의 컴포넌트에 대한 다국어 정보를 ajax로 요청하여 상태를 갱신한다.
 * </pre>
 * */

var LangEditorBox =
/*#__PURE__*/
function () {
  function LangEditorBox(_ref) {
    var $wrapper = _ref.$wrapper,
        seq = _ref.seq,
        name = _ref.name,
        langKey = _ref.langKey,
        multiline = _ref.multiline,
        lines = _ref.lines,
        autocomplete = _ref.autocomplete;

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_5___default()(this, LangEditorBox);

    this.$wrapper = $wrapper;
    this.seq = seq;
    this.name = name;
    this.langKey = langKey;
    this.multiline = multiline;
    this.lines = lines || [];
    this.autocomplete = autocomplete;
    var that = this;
    window.XE.app('Lang').then(function (appLang) {
      jquery__WEBPACK_IMPORTED_MODULE_7___default()(function () {
        that.init();
      });
    });
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_6___default()(LangEditorBox, [{
    key: "init",
    value: function init() {
      if (this.langKey && this.lines.length === 0) {
        var _context;

        window.XE.ajax({
          type: 'get',
          dataType: 'json',
          url: xe_config__WEBPACK_IMPORTED_MODULE_8__["default"].getters['router/origin'] + '/lang/lines/' + this.langKey,
          success: _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_4___default()(_context = function _context(result) {
            this.setLines(result);
            this.render();
            this.bindEvents();
          }).call(_context, this)
        });
      } else {
        this.render();
        this.bindEvents();
      }
    }
  }, {
    key: "bindEvents",
    value: function bindEvents() {
      if (this.autocomplete) {
        var _context2;

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()(_context2 = this.$wrapper).call(_context2, 'input[type=text]:first,textarea:first').autocomplete({
          source: '/lang/search/' + xe_config__WEBPACK_IMPORTED_MODULE_8__["default"].getters['lang/current'].code,
          minLength: 1,
          focus: function focus(event, ui) {
            event.preventDefault();
          },
          select: function select(event, ui) {
            this.setLines(ui.item.lines);
          }
        });
      }
    }
  }, {
    key: "render",
    value: function render() {
      var _context4, _context5, _context6, _context7;

      var _this = this;

      var locale = xe_config__WEBPACK_IMPORTED_MODULE_8__["default"].getters['lang/default'];
      var fallback = xe_config__WEBPACK_IMPORTED_MODULE_8__["default"].getters['lang/fallback'];
      var resource = 'xe_lang_preprocessor://lang/seq/' + this.seq;
      var value = this.getValueFromLinesWithLocale(locale.code) || '';
      var inputClass = this.multiline ? 'textarea' : 'text';
      var multiline = this.multiline ? "<input type=\"hidden\" name=\"".concat(resource + '/multiline', "\" value=\"true\" />") : '';
      var editor = this.getEditor(resource, locale.code, value);
      var subTemplate = '';

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_2___default()(fallback).call(fallback, function (locale, i) {
        var _context3;

        var value = _this.getValueFromLinesWithLocale(locale.code) || '';

        var editor = _this.getEditor(resource, locale.code, value);

        subTemplate += ["<div key=\"".concat(locale.code, "\" class=\"input-group\">"), "".concat(editor), "<span class=\"input-group-addon\">", _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1___default()(_context3 = "<span class=\"flag-code\"><i class=\"".concat(locale.code + ' xe-flag', "\"></i>")).call(_context3, locale.nativeName, "</span>"), "</span>", "</div>"].join('\n');
      });

      var template = ["<div class=\"".concat(inputClass, "\">"), "<input type=\"hidden\" name=\"xe_use_request_preprocessor\" value=\"Y\"/>", _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1___default()(_context4 = "<input type=\"hidden\" name=\"".concat(resource + '/name', "\" value=\"")).call(_context4, this.name, "\" />"), _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1___default()(_context5 = "<input type=\"hidden\" name=\"".concat(resource + '/key', "\" value=\"")).call(_context5, this.langKey || '', "\" />"), "".concat(multiline), _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1___default()(_context6 = "<input type=\"hidden\" name=\"".concat(this.name, "\" value=\"")).call(_context6, this.langKey || '', "\" />"), "<div key=\"".concat(locale.code, "\" class=\"input-group\">"), "".concat(editor), "<span class=\"input-group-addon\">", _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1___default()(_context7 = "<span class=\"flag-code\"><i class=\"".concat(locale.code + ' xe-flag', "\"></i>")).call(_context7, locale.nativeName, "</span>"), "</span>", "</div>", "<div class=\"sub\">".concat(subTemplate, "</div>"), "</div>"].join('\n');
      this.$wrapper.html(template);
    }
  }, {
    key: "setLines",
    value: function setLines(lines) {
      var _context8;

      var _this = this;

      this.lines = lines;

      _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_0___default()(_context8 = window.XE.Lang.locales).call(_context8, function (locale) {
        var selector = '#input-' + _this.seq + '-' + locale.code;

        var value = _this.getValueFromLinesWithLocale(locale.code);

        jquery__WEBPACK_IMPORTED_MODULE_7___default()(selector).val(value);
      });
    }
  }, {
    key: "getValueFromLinesWithLocale",
    value: function getValueFromLinesWithLocale(locale) {
      var lines = this.lines;
      var i = lines.length;
      var l = {};

      while (i--) {
        l = lines[i];

        if (l.locale == locale) {
          return l.value;
        }
      }
    }
  }, {
    key: "getEditor",
    value: function getEditor(resource, locale, value) {
      var edit = null;
      var id = 'input-' + this.seq + '-' + locale;
      var name = resource + '/locale/' + locale;

      if (!this.multiline) {
        var _context9;

        edit = jquery__WEBPACK_IMPORTED_MODULE_7___default()(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1___default()(_context9 = "<input type=\"text\" class=\"form-control\" id=\"".concat(id, "\" name=\"")).call(_context9, name, "\" />")).attr('value', value);
      } else {
        var _context10;

        edit = jquery__WEBPACK_IMPORTED_MODULE_7___default()(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_1___default()(_context10 = "<textarea class=\"form-control\" id=\"".concat(id, "\" name=\"")).call(_context10, name, "\"></textarea>")).text(value);
      }

      return edit.prop('outerHTML');
    }
  }]);

  return LangEditorBox;
}();

var seq = 0;
/**
 * target element에 LangEditorBox를 랜더링함.
 * @FIXME
 * @global
 * @function langEditorBoxRender
 * */

window.langEditorBoxRender = function ($data, type) {
  if (type === 'obj') {
    // { name, langKey, multiline, lines, autocomplete, target }
    var _name = $data.name;
    var _langKey = $data.langKey;
    var _multiline = $data.multiline;
    var _lines = $data.lines;
    var _autocomplete = $data.autocomplete;
    var target = $data.target;
    new LangEditorBox({
      $wrapper: jquery__WEBPACK_IMPORTED_MODULE_7___default()($data.target),
      seq: seq,
      name: _name,
      langKey: _langKey,
      multiline: _multiline,
      lines: _lines,
      autocomplete: _autocomplete
    });
  } else {
    var name = $data.data('name');
    var langKey = $data.data('lang-key');
    var multiline = $data.data('multiline');
    var lines = $data.data('lines');
    var autocomplete = $data.data('autocomplete');
    new LangEditorBox({
      $wrapper: $data,
      seq: seq,
      name: name,
      langKey: langKey,
      multiline: multiline,
      lines: lines,
      autocomplete: autocomplete
    });
  }

  seq++;
}; // @FIXME


jquery__WEBPACK_IMPORTED_MODULE_7___default()(function () {
  renderLangEditorBox();
}); // @FIXME

function renderLangEditorBox() {
  var langKeys = [];
  var langObj = {};
  var langs = [];
  var idx = 0;

  if (jquery__WEBPACK_IMPORTED_MODULE_7___default()('.lang-editor-box').length > 0) {
    jquery__WEBPACK_IMPORTED_MODULE_7___default()('.lang-editor-box').each(function (key, i) {
      var $this = jquery__WEBPACK_IMPORTED_MODULE_7___default()(this);
      var name = $this.data('name');
      var langKey = $this.data('lang-key');
      var multiline = $this.data('multiline');
      var lines = $this.data('lines');
      var autocomplete = $this.data('autocomplete');

      if (langKey) {
        langKeys.push(langKey);
      }

      langs.push({
        name: name,
        langKey: langKey,
        multiline: multiline,
        lines: lines,
        autocomplete: autocomplete,
        target: $this[0]
      });
      idx++;
    });

    if (langKeys.length > 0) {
      window.XE.ajax({
        type: 'get',
        dataType: 'json',
        url: xe_config__WEBPACK_IMPORTED_MODULE_8__["default"].getters['router/origin'] + '/lang/lines/many',
        data: {
          keys: langKeys
        },
        success: function success(result) {
          jquery__WEBPACK_IMPORTED_MODULE_7___default.a.each(result, function (key, arr) {
            jquery__WEBPACK_IMPORTED_MODULE_7___default.a.each(langs, function () {
              if (key === this.langKey) {
                this.lines = arr;
              }
            });
          });
          jquery__WEBPACK_IMPORTED_MODULE_7___default.a.each(langs, function () {
            window.langEditorBoxRender(this, 'obj'); // @FIXME
          });
        }
      });
    } else {
      jquery__WEBPACK_IMPORTED_MODULE_7___default.a.each(langs, function () {
        window.langEditorBoxRender(this, 'obj'); // @FIXME
      });
    }
  }

  window.XE.Validator.put('langrequired', function ($dst, parameters) {
    var _context11;

    var $input = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()(_context11 = $dst.closest('.lang-editor-box')).call(_context11, "input[name^='xe_lang_preprocessor']:not(:hidden):first");

    var value = $input.val();
    var name = $dst.closest('.lang-editor-box').data('valid-name') || $dst.closest('.lang-editor-box').data('name');

    if (value === '') {
      window.XE.Validator.error($input, window.XE.Lang.trans('validation.required', {
        attribute: name
      }));
      return false;
    }

    return true;
  });
} // @FIXME


jquery__WEBPACK_IMPORTED_MODULE_7___default()(document).on('focus', '.lang-editor-box input, textarea', function () {
  var box = jquery__WEBPACK_IMPORTED_MODULE_7___default()(this).closest('.lang-editor-box');

  var el = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()(box).call(box, '.sub');

  if (jquery__WEBPACK_IMPORTED_MODULE_7___default()(el).is(':hidden')) {
    jquery__WEBPACK_IMPORTED_MODULE_7___default()(el).slideDown('fast');
  }
});

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/bind.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/bind.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(57);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(84);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(6);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(18);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js":
/*!************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(244);

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

/***/ "./node_modules/jquery/src/jquery.js":
/*!***************************************************************************************!*\
  !*** delegated ./node_modules/jquery/src/jquery.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(0);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvY29uZmlnL2luZGV4LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9jb3JlL2xhbmcvTGFuZ0VkaXRvckJveC5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvYmluZC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2NvbmNhdC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9mb3ItZWFjaC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL21hcC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvY2xhc3NDYWxsQ2hlY2suanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NyZWF0ZUNsYXNzLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2pxdWVyeS9zcmMvanF1ZXJ5LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZXh0ZXJuYWwgXCJfeGVfZGxsX2NvbW1vblwiIl0sIm5hbWVzIjpbIkxhbmdFZGl0b3JCb3giLCIkd3JhcHBlciIsInNlcSIsIm5hbWUiLCJsYW5nS2V5IiwibXVsdGlsaW5lIiwibGluZXMiLCJhdXRvY29tcGxldGUiLCJ0aGF0Iiwid2luZG93IiwiWEUiLCJhcHAiLCJ0aGVuIiwiYXBwTGFuZyIsIiQiLCJpbml0IiwibGVuZ3RoIiwiYWpheCIsInR5cGUiLCJkYXRhVHlwZSIsInVybCIsImNvbmZpZyIsImdldHRlcnMiLCJzdWNjZXNzIiwicmVzdWx0Iiwic2V0TGluZXMiLCJyZW5kZXIiLCJiaW5kRXZlbnRzIiwic291cmNlIiwiY29kZSIsIm1pbkxlbmd0aCIsImZvY3VzIiwiZXZlbnQiLCJ1aSIsInByZXZlbnREZWZhdWx0Iiwic2VsZWN0IiwiaXRlbSIsIl90aGlzIiwibG9jYWxlIiwiZmFsbGJhY2siLCJyZXNvdXJjZSIsInZhbHVlIiwiZ2V0VmFsdWVGcm9tTGluZXNXaXRoTG9jYWxlIiwiaW5wdXRDbGFzcyIsImVkaXRvciIsImdldEVkaXRvciIsInN1YlRlbXBsYXRlIiwiaSIsIm5hdGl2ZU5hbWUiLCJqb2luIiwidGVtcGxhdGUiLCJodG1sIiwiTGFuZyIsImxvY2FsZXMiLCJzZWxlY3RvciIsInZhbCIsImwiLCJlZGl0IiwiaWQiLCJhdHRyIiwidGV4dCIsInByb3AiLCJsYW5nRWRpdG9yQm94UmVuZGVyIiwiJGRhdGEiLCJ0YXJnZXQiLCJkYXRhIiwicmVuZGVyTGFuZ0VkaXRvckJveCIsImxhbmdLZXlzIiwibGFuZ09iaiIsImxhbmdzIiwiaWR4IiwiZWFjaCIsImtleSIsIiR0aGlzIiwicHVzaCIsImtleXMiLCJhcnIiLCJWYWxpZGF0b3IiLCJwdXQiLCIkZHN0IiwicGFyYW1ldGVycyIsIiRpbnB1dCIsImNsb3Nlc3QiLCJlcnJvciIsInRyYW5zIiwiYXR0cmlidXRlIiwiZG9jdW1lbnQiLCJvbiIsImJveCIsImVsIiwiaXMiLCJzbGlkZURvd24iXSwibWFwcGluZ3MiOiI7QUFBQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7O0FBR0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLGtEQUEwQyxnQ0FBZ0M7QUFDMUU7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxnRUFBd0Qsa0JBQWtCO0FBQzFFO0FBQ0EseURBQWlELGNBQWM7QUFDL0Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlEQUF5QyxpQ0FBaUM7QUFDMUUsd0hBQWdILG1CQUFtQixFQUFFO0FBQ3JJO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsbUNBQTJCLDBCQUEwQixFQUFFO0FBQ3ZELHlDQUFpQyxlQUFlO0FBQ2hEO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLDhEQUFzRCwrREFBK0Q7O0FBRXJIO0FBQ0E7OztBQUdBO0FBQ0E7Ozs7Ozs7Ozs7OztBQ2xGQSwrRzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQ0FBO0FBQ0E7QUFFQTs7Ozs7Ozs7Ozs7Ozs7SUFhTUEsYTs7O0FBQ0osK0JBQStFO0FBQUEsUUFBaEVDLFFBQWdFLFFBQWhFQSxRQUFnRTtBQUFBLFFBQXREQyxHQUFzRCxRQUF0REEsR0FB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QUFsQztBQUNBLGFBQU8sS0FBUDtBQUNEOztBQUVELFdBQU8sSUFBUDtBQUNELEdBWEQ7QUFZRCxDLENBRUQ7OztBQUNBVyw2Q0FBQyxDQUFDd0UsUUFBRCxDQUFELENBQVlDLEVBQVosQ0FBZSxPQUFmLEVBQXdCLGtDQUF4QixFQUE0RCxZQUFZO0FBQ3RFLE1BQUlDLEdBQUcsR0FBRzFFLDZDQUFDLENBQUMsSUFBRCxDQUFELENBQVFvRSxPQUFSLENBQWdCLGtCQUFoQixDQUFWOztBQUNBLE1BQUlPLEVBQUUsR0FBRywyRkFBQUQsR0FBRyxNQUFILENBQUFBLEdBQUcsRUFBTSxNQUFOLENBQVo7O0FBQ0EsTUFBSTFFLDZDQUFDLENBQUMyRSxFQUFELENBQUQsQ0FBTUMsRUFBTixDQUFTLFNBQVQsQ0FBSixFQUF5QjtBQUN2QjVFLGlEQUFDLENBQUMyRSxFQUFELENBQUQsQ0FBTUUsU0FBTixDQUFnQixNQUFoQjtBQUNEO0FBQ0YsQ0FORCxFOzs7Ozs7Ozs7OztBQzVRQSwrRzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9sYW5nL2xhbmdFZGl0b3JCb3guYnVuZGxlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL2xhbmcvTGFuZ0VkaXRvckJveC5qc1wiKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgzNik7IiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IGNvbmZpZyBmcm9tICd4ZS9jb25maWcnXG5cbi8qKlxuICogQHByaXZhdGVcbiAqIEBGSVhNRVxuICogQGRlc2NyaXB0aW9uXG4gKiA8cHJlPlxuICog64uk6rWt7Ja0IOyeheugpSDsu7Ttj6zrhIztirjrpbwg66eM65Oc64qUIOuwqeyLnSAy6rCA7KeAXG4gKiAxKURPTSBkYXRh7IaN7ISx7J2EIOyCrOyaqe2VmOyXrCBkb2N1bWVudCByZWFkeeyDge2DnOydvCDqsr3smrAgYWpheOuhnCDtlZzrsojsl5Ag64uk6rWt7Ja066W8IOyalOyyre2VmOyXrCDsu7Ttj6zrhIztirjrpbwg66eM65Og64ukLlxuICogLSBhamF47J207ZuEIGxhbmdFZGl0b3JCb3hSZW5kZXIg7IKs7Jqp7IucIHR5cGXsnbQgJ29iaifroZwg65Ok7Ja06rCQLlxuICpcbiAqIDIpbGFuZ0VkaXRvckJveFJlbmRlcjpmbiDsmbjrtoDsl5DshJwg7KeB7KCR7Zi47Lac7ZWY7JesIOy7tO2PrOuEjO2KuOulvCDrp4zrk6Dri6RcbiAqIC0g7Lu07Y+s64SM7Yq4IHN0YXRl7JeQIOuLpOq1reyWtCDsoJXrs7TqsIAg7JeG7Jy866m0IO2VmOuCmOydmCDsu7Ttj6zrhIztirjsl5Ag64yA7ZWcIOuLpOq1reyWtCDsoJXrs7TrpbwgYWpheOuhnCDsmpTssq3tlZjsl6wg7IOB7YOc66W8IOqwseyLoO2VnOuLpC5cbiAqIDwvcHJlPlxuICogKi9cbmNsYXNzIExhbmdFZGl0b3JCb3gge1xuICBjb25zdHJ1Y3RvciAoeyAkd3JhcHBlciwgc2VxLCBuYW1lLCBsYW5nS2V5LCBtdWx0aWxpbmUsIGxpbmVzLCBhdXRvY29tcGxldGUgfSkge1xuICAgIHRoaXMuJHdyYXBwZXIgPSAkd3JhcHBlclxuICAgIHRoaXMuc2VxID0gc2VxXG4gICAgdGhpcy5uYW1lID0gbmFtZVxuICAgIHRoaXMubGFuZ0tleSA9IGxhbmdLZXlcbiAgICB0aGlzLm11bHRpbGluZSA9IG11bHRpbGluZVxuICAgIHRoaXMubGluZXMgPSBsaW5lcyB8fCBbXVxuICAgIHRoaXMuYXV0b2NvbXBsZXRlID0gYXV0b2NvbXBsZXRlXG5cbiAgICB2YXIgdGhhdCA9IHRoaXNcbiAgICB3aW5kb3cuWEUuYXBwKCdMYW5nJykudGhlbigoYXBwTGFuZykgPT4ge1xuICAgICAgJChmdW5jdGlvbiAoKSB7XG4gICAgICAgIHRoYXQuaW5pdCgpXG4gICAgICB9KVxuICAgIH0pXG4gIH1cblxuICBpbml0ICgpIHtcbiAgICBpZiAodGhpcy5sYW5nS2V5ICYmIHRoaXMubGluZXMubGVuZ3RoID09PSAwKSB7XG4gICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgIHR5cGU6ICdnZXQnLFxuICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgICB1cmw6IGNvbmZpZy5nZXR0ZXJzWydyb3V0ZXIvb3JpZ2luJ10gKyAnL2xhbmcvbGluZXMvJyArIHRoaXMubGFuZ0tleSxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3VsdCkge1xuICAgICAgICAgIHRoaXMuc2V0TGluZXMocmVzdWx0KVxuICAgICAgICAgIHRoaXMucmVuZGVyKClcbiAgICAgICAgICB0aGlzLmJpbmRFdmVudHMoKVxuICAgICAgICB9LmJpbmQodGhpcylcbiAgICAgIH0pXG4gICAgfSBlbHNlIHtcbiAgICAgIHRoaXMucmVuZGVyKClcbiAgICAgIHRoaXMuYmluZEV2ZW50cygpXG4gICAgfVxuICB9XG5cbiAgYmluZEV2ZW50cyAoKSB7XG4gICAgaWYgKHRoaXMuYXV0b2NvbXBsZXRlKSB7XG4gICAgICB0aGlzLiR3cmFwcGVyLmZpbmQoJ2lucHV0W3R5cGU9dGV4dF06Zmlyc3QsdGV4dGFyZWE6Zmlyc3QnKS5hdXRvY29tcGxldGUoe1xuICAgICAgICBzb3VyY2U6ICcvbGFuZy9zZWFyY2gvJyArIGNvbmZpZy5nZXR0ZXJzWydsYW5nL2N1cnJlbnQnXS5jb2RlLFxuICAgICAgICBtaW5MZW5ndGg6IDEsXG4gICAgICAgIGZvY3VzOiBmdW5jdGlvbiAoZXZlbnQsIHVpKSB7XG4gICAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKVxuICAgICAgICB9LFxuXG4gICAgICAgIHNlbGVjdDogZnVuY3Rpb24gKGV2ZW50LCB1aSkge1xuICAgICAgICAgIHRoaXMuc2V0TGluZXModWkuaXRlbS5saW5lcylcbiAgICAgICAgfVxuICAgICAgfSlcbiAgICB9XG4gIH1cblxuICByZW5kZXIgKCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICB2YXIgbG9jYWxlID0gY29uZmlnLmdldHRlcnNbJ2xhbmcvZGVmYXVsdCddXG4gICAgdmFyIGZhbGxiYWNrID0gY29uZmlnLmdldHRlcnNbJ2xhbmcvZmFsbGJhY2snXVxuICAgIHZhciByZXNvdXJjZSA9ICd4ZV9sYW5nX3ByZXByb2Nlc3NvcjovL2xhbmcvc2VxLycgKyB0aGlzLnNlcVxuICAgIHZhciB2YWx1ZSA9IHRoaXMuZ2V0VmFsdWVGcm9tTGluZXNXaXRoTG9jYWxlKGxvY2FsZS5jb2RlKSB8fCAnJ1xuICAgIHZhciBpbnB1dENsYXNzID0gdGhpcy5tdWx0aWxpbmUgPyAndGV4dGFyZWEnIDogJ3RleHQnXG4gICAgdmFyIG11bHRpbGluZSA9IHRoaXMubXVsdGlsaW5lXG4gICAgICA/IGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3Jlc291cmNlICsgJy9tdWx0aWxpbmUnfVwiIHZhbHVlPVwidHJ1ZVwiIC8+YFxuICAgICAgOiAnJ1xuXG4gICAgdmFyIGVkaXRvciA9IHRoaXMuZ2V0RWRpdG9yKHJlc291cmNlLCBsb2NhbGUuY29kZSwgdmFsdWUpXG4gICAgdmFyIHN1YlRlbXBsYXRlID0gJydcblxuICAgIGZhbGxiYWNrLmZvckVhY2goZnVuY3Rpb24gKGxvY2FsZSwgaSkge1xuICAgICAgdmFyIHZhbHVlID0gX3RoaXMuZ2V0VmFsdWVGcm9tTGluZXNXaXRoTG9jYWxlKGxvY2FsZS5jb2RlKSB8fCAnJ1xuICAgICAgdmFyIGVkaXRvciA9IF90aGlzLmdldEVkaXRvcihyZXNvdXJjZSwgbG9jYWxlLmNvZGUsIHZhbHVlKVxuXG4gICAgICBzdWJUZW1wbGF0ZSArPSBbXG4gICAgICAgIGA8ZGl2IGtleT1cIiR7bG9jYWxlLmNvZGV9XCIgY2xhc3M9XCJpbnB1dC1ncm91cFwiPmAsXG4gICAgICAgIGAke2VkaXRvcn1gLFxuICAgICAgICBgPHNwYW4gY2xhc3M9XCJpbnB1dC1ncm91cC1hZGRvblwiPmAsXG4gICAgICAgIGA8c3BhbiBjbGFzcz1cImZsYWctY29kZVwiPjxpIGNsYXNzPVwiJHtsb2NhbGUuY29kZSArICcgeGUtZmxhZyd9XCI+PC9pPiR7bG9jYWxlLm5hdGl2ZU5hbWV9PC9zcGFuPmAsXG4gICAgICAgIGA8L3NwYW4+YCxcbiAgICAgICAgYDwvZGl2PmBcbiAgICAgIF0uam9pbignXFxuJylcbiAgICB9KVxuXG4gICAgdmFyIHRlbXBsYXRlID0gW1xuICAgICAgYDxkaXYgY2xhc3M9XCIke2lucHV0Q2xhc3N9XCI+YCxcbiAgICAgIGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCJ4ZV91c2VfcmVxdWVzdF9wcmVwcm9jZXNzb3JcIiB2YWx1ZT1cIllcIi8+YCxcbiAgICAgIGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3Jlc291cmNlICsgJy9uYW1lJ31cIiB2YWx1ZT1cIiR7dGhpcy5uYW1lfVwiIC8+YCxcbiAgICAgIGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3Jlc291cmNlICsgJy9rZXknfVwiIHZhbHVlPVwiJHt0aGlzLmxhbmdLZXkgfHwgJyd9XCIgLz5gLFxuICAgICAgYCR7bXVsdGlsaW5lfWAsXG4gICAgICBgPGlucHV0IHR5cGU9XCJoaWRkZW5cIiBuYW1lPVwiJHt0aGlzLm5hbWV9XCIgdmFsdWU9XCIke3RoaXMubGFuZ0tleSB8fCAnJ31cIiAvPmAsXG4gICAgICBgPGRpdiBrZXk9XCIke2xvY2FsZS5jb2RlfVwiIGNsYXNzPVwiaW5wdXQtZ3JvdXBcIj5gLFxuICAgICAgYCR7ZWRpdG9yfWAsXG4gICAgICBgPHNwYW4gY2xhc3M9XCJpbnB1dC1ncm91cC1hZGRvblwiPmAsXG4gICAgICBgPHNwYW4gY2xhc3M9XCJmbGFnLWNvZGVcIj48aSBjbGFzcz1cIiR7bG9jYWxlLmNvZGUgKyAnIHhlLWZsYWcnfVwiPjwvaT4ke2xvY2FsZS5uYXRpdmVOYW1lfTwvc3Bhbj5gLFxuICAgICAgYDwvc3Bhbj5gLFxuICAgICAgYDwvZGl2PmAsXG4gICAgICBgPGRpdiBjbGFzcz1cInN1YlwiPiR7c3ViVGVtcGxhdGV9PC9kaXY+YCxcbiAgICAgIGA8L2Rpdj5gXG4gICAgXS5qb2luKCdcXG4nKVxuXG4gICAgdGhpcy4kd3JhcHBlci5odG1sKHRlbXBsYXRlKVxuICB9XG5cbiAgc2V0TGluZXMgKGxpbmVzKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHRoaXMubGluZXMgPSBsaW5lc1xuXG4gICAgd2luZG93LlhFLkxhbmcubG9jYWxlcy5tYXAoZnVuY3Rpb24gKGxvY2FsZSkge1xuICAgICAgdmFyIHNlbGVjdG9yID0gJyNpbnB1dC0nICsgX3RoaXMuc2VxICsgJy0nICsgbG9jYWxlLmNvZGVcbiAgICAgIHZhciB2YWx1ZSA9IF90aGlzLmdldFZhbHVlRnJvbUxpbmVzV2l0aExvY2FsZShsb2NhbGUuY29kZSlcbiAgICAgICQoc2VsZWN0b3IpLnZhbCh2YWx1ZSlcbiAgICB9KVxuICB9XG5cbiAgZ2V0VmFsdWVGcm9tTGluZXNXaXRoTG9jYWxlIChsb2NhbGUpIHtcbiAgICB2YXIgbGluZXMgPSB0aGlzLmxpbmVzXG4gICAgdmFyIGkgPSBsaW5lcy5sZW5ndGhcbiAgICB2YXIgbCA9IHt9XG5cbiAgICB3aGlsZSAoaS0tKSB7XG4gICAgICBsID0gbGluZXNbaV1cbiAgICAgIGlmIChsLmxvY2FsZSA9PSBsb2NhbGUpIHtcbiAgICAgICAgcmV0dXJuIGwudmFsdWVcbiAgICAgIH1cbiAgICB9XG4gIH1cblxuICBnZXRFZGl0b3IgKHJlc291cmNlLCBsb2NhbGUsIHZhbHVlKSB7XG4gICAgdmFyIGVkaXQgPSBudWxsXG4gICAgdmFyIGlkID0gKCdpbnB1dC0nICsgdGhpcy5zZXEgKyAnLScgKyBsb2NhbGUpXG4gICAgdmFyIG5hbWUgPSAocmVzb3VyY2UgKyAnL2xvY2FsZS8nICsgbG9jYWxlKVxuXG4gICAgaWYgKCF0aGlzLm11bHRpbGluZSkge1xuICAgICAgZWRpdCA9ICQoYDxpbnB1dCB0eXBlPVwidGV4dFwiIGNsYXNzPVwiZm9ybS1jb250cm9sXCIgaWQ9XCIke2lkfVwiIG5hbWU9XCIke25hbWV9XCIgLz5gKS5hdHRyKCd2YWx1ZScsIHZhbHVlKVxuICAgIH0gZWxzZSB7XG4gICAgICBlZGl0ID0gJChgPHRleHRhcmVhIGNsYXNzPVwiZm9ybS1jb250cm9sXCIgaWQ9XCIke2lkfVwiIG5hbWU9XCIke25hbWV9XCI+PC90ZXh0YXJlYT5gKS50ZXh0KHZhbHVlKVxuICAgIH1cblxuICAgIHJldHVybiBlZGl0LnByb3AoJ291dGVySFRNTCcpXG4gIH1cbn1cblxudmFyIHNlcSA9IDBcbi8qKlxuICogdGFyZ2V0IGVsZW1lbnTsl5AgTGFuZ0VkaXRvckJveOulvCDrnpzrjZTrp4HtlaguXG4gKiBARklYTUVcbiAqIEBnbG9iYWxcbiAqIEBmdW5jdGlvbiBsYW5nRWRpdG9yQm94UmVuZGVyXG4gKiAqL1xud2luZG93LmxhbmdFZGl0b3JCb3hSZW5kZXIgPSBmdW5jdGlvbiAoJGRhdGEsIHR5cGUpIHtcbiAgaWYgKHR5cGUgPT09ICdvYmonKSB7XG4gICAgLy8geyBuYW1lLCBsYW5nS2V5LCBtdWx0aWxpbmUsIGxpbmVzLCBhdXRvY29tcGxldGUsIHRhcmdldCB9XG4gICAgbGV0IG5hbWUgPSAkZGF0YS5uYW1lXG4gICAgbGV0IGxhbmdLZXkgPSAkZGF0YS5sYW5nS2V5XG4gICAgbGV0IG11bHRpbGluZSA9ICRkYXRhLm11bHRpbGluZVxuICAgIGxldCBsaW5lcyA9ICRkYXRhLmxpbmVzXG4gICAgbGV0IGF1dG9jb21wbGV0ZSA9ICRkYXRhLmF1dG9jb21wbGV0ZVxuICAgIGxldCB0YXJnZXQgPSAkZGF0YS50YXJnZXRcblxuICAgIG5ldyBMYW5nRWRpdG9yQm94KHsgJHdyYXBwZXI6ICQoJGRhdGEudGFyZ2V0KSwgc2VxLCBuYW1lLCBsYW5nS2V5LCBtdWx0aWxpbmUsIGxpbmVzLCBhdXRvY29tcGxldGUgfSlcbiAgfSBlbHNlIHtcbiAgICB2YXIgbmFtZSA9ICRkYXRhLmRhdGEoJ25hbWUnKVxuICAgIHZhciBsYW5nS2V5ID0gJGRhdGEuZGF0YSgnbGFuZy1rZXknKVxuICAgIHZhciBtdWx0aWxpbmUgPSAkZGF0YS5kYXRhKCdtdWx0aWxpbmUnKVxuICAgIHZhciBsaW5lcyA9ICRkYXRhLmRhdGEoJ2xpbmVzJylcbiAgICB2YXIgYXV0b2NvbXBsZXRlID0gJGRhdGEuZGF0YSgnYXV0b2NvbXBsZXRlJylcblxuICAgIG5ldyBMYW5nRWRpdG9yQm94KHsgJHdyYXBwZXI6ICRkYXRhLCBzZXEsIG5hbWUsIGxhbmdLZXksIG11bHRpbGluZSwgbGluZXMsIGF1dG9jb21wbGV0ZSB9KVxuICB9XG5cbiAgc2VxKytcbn1cblxuLy8gQEZJWE1FXG4kKGZ1bmN0aW9uICgpIHtcbiAgcmVuZGVyTGFuZ0VkaXRvckJveCgpXG59KVxuXG4vLyBARklYTUVcbmZ1bmN0aW9uIHJlbmRlckxhbmdFZGl0b3JCb3ggKCkge1xuICBsZXQgbGFuZ0tleXMgPSBbXVxuICBsZXQgbGFuZ09iaiA9IHt9XG4gIGxldCBsYW5ncyA9IFtdXG4gIGxldCBpZHggPSAwXG5cbiAgaWYgKCQoJy5sYW5nLWVkaXRvci1ib3gnKS5sZW5ndGggPiAwKSB7XG4gICAgJCgnLmxhbmctZWRpdG9yLWJveCcpLmVhY2goZnVuY3Rpb24gKGtleSwgaSkge1xuICAgICAgbGV0ICR0aGlzID0gJCh0aGlzKVxuXG4gICAgICBsZXQgbmFtZSA9ICR0aGlzLmRhdGEoJ25hbWUnKVxuICAgICAgbGV0IGxhbmdLZXkgPSAkdGhpcy5kYXRhKCdsYW5nLWtleScpXG4gICAgICBsZXQgbXVsdGlsaW5lID0gJHRoaXMuZGF0YSgnbXVsdGlsaW5lJylcbiAgICAgIGxldCBsaW5lcyA9ICR0aGlzLmRhdGEoJ2xpbmVzJylcbiAgICAgIGxldCBhdXRvY29tcGxldGUgPSAkdGhpcy5kYXRhKCdhdXRvY29tcGxldGUnKVxuXG4gICAgICBpZiAobGFuZ0tleSkge1xuICAgICAgICBsYW5nS2V5cy5wdXNoKGxhbmdLZXkpXG4gICAgICB9XG5cbiAgICAgIGxhbmdzLnB1c2goe1xuICAgICAgICBuYW1lLFxuICAgICAgICBsYW5nS2V5LFxuICAgICAgICBtdWx0aWxpbmUsXG4gICAgICAgIGxpbmVzLFxuICAgICAgICBhdXRvY29tcGxldGUsXG4gICAgICAgIHRhcmdldDogJHRoaXNbMF1cbiAgICAgIH0pXG5cbiAgICAgIGlkeCsrXG4gICAgfSlcblxuICAgIGlmIChsYW5nS2V5cy5sZW5ndGggPiAwKSB7XG4gICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgIHR5cGU6ICdnZXQnLFxuICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgICB1cmw6IGNvbmZpZy5nZXR0ZXJzWydyb3V0ZXIvb3JpZ2luJ10gKyAnL2xhbmcvbGluZXMvbWFueScsXG4gICAgICAgIGRhdGE6IHtcbiAgICAgICAgICBrZXlzOiBsYW5nS2V5c1xuICAgICAgICB9LFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAocmVzdWx0KSB7XG4gICAgICAgICAgJC5lYWNoKHJlc3VsdCwgKGtleSwgYXJyKSA9PiB7XG4gICAgICAgICAgICAkLmVhY2gobGFuZ3MsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgaWYgKGtleSA9PT0gdGhpcy5sYW5nS2V5KSB7XG4gICAgICAgICAgICAgICAgdGhpcy5saW5lcyA9IGFyclxuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KVxuICAgICAgICAgIH0pXG5cbiAgICAgICAgICAkLmVhY2gobGFuZ3MsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHdpbmRvdy5sYW5nRWRpdG9yQm94UmVuZGVyKHRoaXMsICdvYmonKSAvLyBARklYTUVcbiAgICAgICAgICB9KVxuICAgICAgICB9XG4gICAgICB9KVxuICAgIH0gZWxzZSB7XG4gICAgICAkLmVhY2gobGFuZ3MsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgd2luZG93LmxhbmdFZGl0b3JCb3hSZW5kZXIodGhpcywgJ29iaicpIC8vIEBGSVhNRVxuICAgICAgfSlcbiAgICB9XG4gIH1cblxuICB3aW5kb3cuWEUuVmFsaWRhdG9yLnB1dCgnbGFuZ3JlcXVpcmVkJywgZnVuY3Rpb24gKCRkc3QsIHBhcmFtZXRlcnMpIHtcbiAgICB2YXIgJGlucHV0ID0gJGRzdC5jbG9zZXN0KCcubGFuZy1lZGl0b3ItYm94JykuZmluZChcImlucHV0W25hbWVePSd4ZV9sYW5nX3ByZXByb2Nlc3NvciddOm5vdCg6aGlkZGVuKTpmaXJzdFwiKVxuICAgIHZhciB2YWx1ZSA9ICRpbnB1dC52YWwoKVxuICAgIHZhciBuYW1lID0gJGRzdC5jbG9zZXN0KCcubGFuZy1lZGl0b3ItYm94JykuZGF0YSgndmFsaWQtbmFtZScpIHx8ICRkc3QuY2xvc2VzdCgnLmxhbmctZWRpdG9yLWJveCcpLmRhdGEoJ25hbWUnKVxuXG4gICAgaWYgKHZhbHVlID09PSAnJykge1xuICAgICAgd2luZG93LlhFLlZhbGlkYXRvci5lcnJvcigkaW5wdXQsIHdpbmRvdy5YRS5MYW5nLnRyYW5zKCd2YWxpZGF0aW9uLnJlcXVpcmVkJywgeyBhdHRyaWJ1dGU6IG5hbWUgfSkpXG4gICAgICByZXR1cm4gZmFsc2VcbiAgICB9XG5cbiAgICByZXR1cm4gdHJ1ZVxuICB9KVxufVxuXG4vLyBARklYTUVcbiQoZG9jdW1lbnQpLm9uKCdmb2N1cycsICcubGFuZy1lZGl0b3ItYm94IGlucHV0LCB0ZXh0YXJlYScsIGZ1bmN0aW9uICgpIHtcbiAgdmFyIGJveCA9ICQodGhpcykuY2xvc2VzdCgnLmxhbmctZWRpdG9yLWJveCcpXG4gIHZhciBlbCA9IGJveC5maW5kKCcuc3ViJylcbiAgaWYgKCQoZWwpLmlzKCc6aGlkZGVuJykpIHtcbiAgICAkKGVsKS5zbGlkZURvd24oJ2Zhc3QnKVxuICB9XG59KVxuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDU3KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoODQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTgpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyNDQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDApOyIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==