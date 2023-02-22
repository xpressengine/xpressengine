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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(65);

/***/ }),

/***/ "./core/lang/LangEditorBox.js":
/*!************************************!*\
  !*** ./core/lang/LangEditorBox.js ***!
  \************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/concat */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/map */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.array.join.js */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var xe_config__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! xe/config */ "./core/config/index.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_11__);












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

var LangEditorBox = /*#__PURE__*/function () {
  function LangEditorBox(_ref) {
    var $wrapper = _ref.$wrapper,
        seq = _ref.seq,
        name = _ref.name,
        langKey = _ref.langKey,
        multiline = _ref.multiline,
        lines = _ref.lines,
        autocomplete = _ref.autocomplete,
        placeholder = _ref.placeholder,
        required = _ref.required;

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, LangEditorBox);

    this.$wrapper = $wrapper;
    this.seq = seq;
    this.name = name;
    this.langKey = langKey;
    this.multiline = multiline;
    this.lines = lines || [];
    this.autocomplete = autocomplete;
    this.placeholder = placeholder;
    this.required = required;
    var that = this;
    window.XE.app('Lang').then(function (appLang) {
      jquery__WEBPACK_IMPORTED_MODULE_9___default()(function () {
        that.init();
      });
    });
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(LangEditorBox, [{
    key: "init",
    value: function init() {
      if (this.langKey && this.lines.length === 0) {
        window.XE.ajax({
          type: 'get',
          dataType: 'json',
          url: xe_config__WEBPACK_IMPORTED_MODULE_10__["default"].getters['router/origin'] + '/lang/lines/' + this.langKey,
          success: function (result) {
            this.setLines(result);
            this.render();
            this.bindEvents();
          }.bind(this)
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
        var _context;

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context = this.$wrapper).call(_context, 'input[type=text]:first,textarea:first').autocomplete({
          source: '/lang/search/' + xe_config__WEBPACK_IMPORTED_MODULE_10__["default"].getters['lang/current'].code,
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
      var _context3, _context4, _context5, _context6;

      var _this = this;

      var locale = xe_config__WEBPACK_IMPORTED_MODULE_10__["default"].getters['lang/default'];
      var fallback = xe_config__WEBPACK_IMPORTED_MODULE_10__["default"].getters['lang/fallback'];
      var resource = 'xe_lang_preprocessor://lang/seq/' + this.seq;
      var value = this.getValueFromLinesWithLocale(locale.code) || '';
      var inputClass = this.multiline ? 'textarea' : 'text';
      var multiline = this.multiline ? "<input type=\"hidden\" name=\"".concat(resource + '/multiline', "\" value=\"true\" />") : '';
      var editor = this.getEditor(resource, locale.code, value);
      var subTemplate = '';
      fallback.forEach(function (locale, i) {
        var _context2;

        var value = _this.getValueFromLinesWithLocale(locale.code) || '';

        var editor = _this.getEditor(resource, locale.code, value);

        subTemplate += ["<div key=\"".concat(locale.code, "\" class=\"input-group\">"), "".concat(editor), "<span class=\"input-group-addon\">", _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context2 = "<span class=\"flag-code\"><i class=\"".concat(locale.code + ' xe-flag', "\"></i>")).call(_context2, locale.nativeName, "</span>"), "</span>", "</div>"].join('\n');
      });
      var template = ["<div class=\"".concat(inputClass, "\">"), "<input type=\"hidden\" name=\"xe_use_request_preprocessor\" value=\"Y\"/>", _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context3 = "<input type=\"hidden\" name=\"".concat(resource + '/name', "\" value=\"")).call(_context3, this.name, "\" />"), _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context4 = "<input type=\"hidden\" name=\"".concat(resource + '/key', "\" value=\"")).call(_context4, this.langKey || '', "\" />"), "".concat(multiline), _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context5 = "<input type=\"hidden\" name=\"".concat(this.name, "\" value=\"")).call(_context5, this.langKey || '', "\" />"), "<div key=\"".concat(locale.code, "\" class=\"input-group\">"), "".concat(editor), "<span class=\"input-group-addon\">", _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context6 = "<span class=\"flag-code\"><i class=\"".concat(locale.code + ' xe-flag', "\"></i>")).call(_context6, locale.nativeName, "</span>"), "</span>", "</div>", "<div class=\"sub\">".concat(subTemplate, "</div>"), "</div>"].join('\n');
      this.$wrapper.html(template);
    }
  }, {
    key: "setLines",
    value: function setLines(lines) {
      var _context7;

      var _this = this;

      this.lines = lines;

      _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default()(_context7 = window.XE.Lang.locales).call(_context7, function (locale) {
        var selector = '#input-' + _this.seq + '-' + locale.code;

        var value = _this.getValueFromLinesWithLocale(locale.code);

        jquery__WEBPACK_IMPORTED_MODULE_9___default()(selector).val(value);
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
      var placeholder = this.placeholder;
      var required = '';

      if (lodash__WEBPACK_IMPORTED_MODULE_11___default.a.isArray(placeholder)) {
        placeholder = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(lodash__WEBPACK_IMPORTED_MODULE_11___default.a).call(lodash__WEBPACK_IMPORTED_MODULE_11___default.a, placeholder, function (o) {
          return o.locale === locale;
        }).value;
      }

      if (this.required === 'required' || this.required === 'true' || this.required === true || this.required === 1) {
        required = 'required';
      }

      if (!this.multiline) {
        var _context8, _context9, _context10;

        edit = jquery__WEBPACK_IMPORTED_MODULE_9___default()(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context8 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context9 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context10 = "<input type=\"text\" class=\"form-control\" id=\"".concat(id, "\" name=\"")).call(_context10, name, "\" placeholder=\"")).call(_context9, placeholder, "\" ")).call(_context8, required, " />")).attr('value', value).attr('data-origin-value', value);
      } else {
        var _context11;

        edit = jquery__WEBPACK_IMPORTED_MODULE_9___default()(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context11 = "<textarea class=\"form-control\" id=\"".concat(id, "\" name=\"")).call(_context11, name, "\"></textarea>")).text(value).attr('data-origin-value', value);
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
    var placeholder = $data.placeholder;
    var required = $data.required;
    new LangEditorBox({
      $wrapper: jquery__WEBPACK_IMPORTED_MODULE_9___default()($data.target),
      seq: seq,
      name: _name,
      langKey: _langKey,
      multiline: _multiline,
      lines: _lines,
      autocomplete: _autocomplete,
      placeholder: placeholder,
      required: required
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


jquery__WEBPACK_IMPORTED_MODULE_9___default()(function () {
  renderLangEditorBox();
}); // @FIXME

function renderLangEditorBox() {
  var langKeys = [];
  var langObj = {};
  var langs = [];
  var idx = 0;

  if (jquery__WEBPACK_IMPORTED_MODULE_9___default()('.lang-editor-box').length > 0) {
    jquery__WEBPACK_IMPORTED_MODULE_9___default()('.lang-editor-box').each(function (key, i) {
      var $this = jquery__WEBPACK_IMPORTED_MODULE_9___default()(this);
      var name = $this.data('name');
      var langKey = $this.data('lang-key');
      var multiline = $this.data('multiline');
      var lines = $this.data('lines');
      var autocomplete = $this.data('autocomplete');
      var placeholder = $this.data('placeholder');
      var required = $this.data('required');

      if (langKey) {
        langKeys.push(langKey);
      }

      if (placeholder) {
        langKeys.push(placeholder);
      }

      langs.push({
        name: name,
        langKey: langKey,
        multiline: multiline,
        lines: lines,
        autocomplete: autocomplete,
        placeholder: placeholder,
        required: required,
        target: $this[0]
      });
      idx++;
    });

    if (langKeys.length > 0) {
      window.XE.ajax({
        type: 'post',
        dataType: 'json',
        url: xe_config__WEBPACK_IMPORTED_MODULE_10__["default"].getters['router/origin'] + '/lang/lines/many',
        data: {
          keys: langKeys
        },
        success: function success(result) {
          jquery__WEBPACK_IMPORTED_MODULE_9___default.a.each(result, function (key, arr) {
            jquery__WEBPACK_IMPORTED_MODULE_9___default.a.each(langs, function () {
              if (key === this.langKey) {
                this.lines = arr;
              }
            });
          });
          jquery__WEBPACK_IMPORTED_MODULE_9___default.a.each(langs, function () {
            if (lodash__WEBPACK_IMPORTED_MODULE_11___default.a.hasIn(result, this.placeholder) && !lodash__WEBPACK_IMPORTED_MODULE_11___default.a.isEmpty(result[this.placeholder])) {
              this.placeholder = result[this.placeholder];
            }

            window.langEditorBoxRender(this, 'obj'); // @FIXME
          });
        }
      });
    } else {
      jquery__WEBPACK_IMPORTED_MODULE_9___default.a.each(langs, function () {
        window.langEditorBoxRender(this, 'obj'); // @FIXME
      });
    }
  }

  window.XE.Validator.put('langrequired', function ($dst, parameters) {
    var _context12;

    var $input = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context12 = $dst.closest('.lang-editor-box')).call(_context12, "input[name^='xe_lang_preprocessor']:not(:hidden):first");

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


jquery__WEBPACK_IMPORTED_MODULE_9___default()(document).on('focus', '.lang-editor-box input, textarea', function () {
  var box = jquery__WEBPACK_IMPORTED_MODULE_9___default()(this).closest('.lang-editor-box');

  var el = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(box).call(box, '.sub');

  if (jquery__WEBPACK_IMPORTED_MODULE_9___default()(el).is(':hidden')) {
    jquery__WEBPACK_IMPORTED_MODULE_9___default()(el).slideDown('fast');
  }
});

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(170);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(6);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js":
/*!************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(472);

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

/***/ "./node_modules/core-js/modules/web.dom-collections.for-each.js":
/*!******************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/web.dom-collections.for-each.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(73);

/***/ }),

/***/ "./node_modules/jquery/src/jquery.js":
/*!***************************************************************************************!*\
  !*** delegated ./node_modules/jquery/src/jquery.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(0);

/***/ }),

/***/ "./node_modules/lodash/lodash.js":
/*!***********************************************************************************!*\
  !*** delegated ./node_modules/lodash/lodash.js from dll-reference _xe_dll_common ***!
  \***********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(19);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvY29uZmlnL2luZGV4LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9jb3JlL2xhbmcvTGFuZ0VkaXRvckJveC5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvY29uY2F0LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvZmluZC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL21hcC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvY2xhc3NDYWxsQ2hlY2suanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NyZWF0ZUNsYXNzLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5hcnJheS5qb2luLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5mdW5jdGlvbi5uYW1lLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5vYmplY3QudG8tc3RyaW5nLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy93ZWIuZG9tLWNvbGxlY3Rpb25zLmZvci1lYWNoLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2pxdWVyeS9zcmMvanF1ZXJ5LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2xvZGFzaC9sb2Rhc2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsiTGFuZ0VkaXRvckJveCIsIiR3cmFwcGVyIiwic2VxIiwibmFtZSIsImxhbmdLZXkiLCJtdWx0aWxpbmUiLCJsaW5lcyIsImF1dG9jb21wbGV0ZSIsInBsYWNlaG9sZGVyIiwicmVxdWlyZWQiLCJ0aGF0Iiwid2luZG93IiwiWEUiLCJhcHAiLCJ0aGVuIiwiYXBwTGFuZyIsIiQiLCJpbml0IiwibGVuZ3RoIiwiYWpheCIsInR5cGUiLCJkYXRhVHlwZSIsInVybCIsImNvbmZpZyIsImdldHRlcnMiLCJzdWNjZXNzIiwicmVzdWx0Iiwic2V0TGluZXMiLCJyZW5kZXIiLCJiaW5kRXZlbnRzIiwiYmluZCIsInNvdXJjZSIsImNvZGUiLCJtaW5MZW5ndGgiLCJmb2N1cyIsImV2ZW50IiwidWkiLCJwcmV2ZW50RGVmYXVsdCIsInNlbGVjdCIsIml0ZW0iLCJfdGhpcyIsImxvY2FsZSIsImZhbGxiYWNrIiwicmVzb3VyY2UiLCJ2YWx1ZSIsImdldFZhbHVlRnJvbUxpbmVzV2l0aExvY2FsZSIsImlucHV0Q2xhc3MiLCJlZGl0b3IiLCJnZXRFZGl0b3IiLCJzdWJUZW1wbGF0ZSIsImZvckVhY2giLCJpIiwibmF0aXZlTmFtZSIsImpvaW4iLCJ0ZW1wbGF0ZSIsImh0bWwiLCJMYW5nIiwibG9jYWxlcyIsInNlbGVjdG9yIiwidmFsIiwibCIsImVkaXQiLCJpZCIsIl8iLCJpc0FycmF5IiwibyIsImF0dHIiLCJ0ZXh0IiwicHJvcCIsImxhbmdFZGl0b3JCb3hSZW5kZXIiLCIkZGF0YSIsInRhcmdldCIsImRhdGEiLCJyZW5kZXJMYW5nRWRpdG9yQm94IiwibGFuZ0tleXMiLCJsYW5nT2JqIiwibGFuZ3MiLCJpZHgiLCJlYWNoIiwia2V5IiwiJHRoaXMiLCJwdXNoIiwia2V5cyIsImFyciIsImhhc0luIiwiaXNFbXB0eSIsIlZhbGlkYXRvciIsInB1dCIsIiRkc3QiLCJwYXJhbWV0ZXJzIiwiJGlucHV0IiwiY2xvc2VzdCIsImVycm9yIiwidHJhbnMiLCJhdHRyaWJ1dGUiLCJkb2N1bWVudCIsIm9uIiwiYm94IiwiZWwiLCJpcyIsInNsaWRlRG93biJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7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LEdBQUcsR0FBR2pGLDZDQUFDLENBQUMsSUFBRCxDQUFELENBQVEyRSxPQUFSLENBQWdCLGtCQUFoQixDQUFWOztFQUNBLElBQUlPLEVBQUUsR0FBRywyRkFBQUQsR0FBRyxNQUFILENBQUFBLEdBQUcsRUFBTSxNQUFOLENBQVo7O0VBQ0EsSUFBSWpGLDZDQUFDLENBQUNrRixFQUFELENBQUQsQ0FBTUMsRUFBTixDQUFTLFNBQVQsQ0FBSixFQUF5QjtJQUN2Qm5GLDZDQUFDLENBQUNrRixFQUFELENBQUQsQ0FBTUUsU0FBTixDQUFnQixNQUFoQjtFQUNEO0FBQ0YsQ0FORCxFOzs7Ozs7Ozs7OztBQ3ZTQSxnSDs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9sYW5nL2xhbmdFZGl0b3JCb3guYnVuZGxlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL2xhbmcvTGFuZ0VkaXRvckJveC5qc1wiKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2NSk7IiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IGNvbmZpZyBmcm9tICd4ZS9jb25maWcnXG5pbXBvcnQgXyBmcm9tICdsb2Rhc2gnXG5cbi8qKlxuICogQHByaXZhdGVcbiAqIEBGSVhNRVxuICogQGRlc2NyaXB0aW9uXG4gKiA8cHJlPlxuICog64uk6rWt7Ja0IOyeheugpSDsu7Ttj6zrhIztirjrpbwg66eM65Oc64qUIOuwqeyLnSAy6rCA7KeAXG4gKiAxKURPTSBkYXRh7IaN7ISx7J2EIOyCrOyaqe2VmOyXrCBkb2N1bWVudCByZWFkeeyDge2DnOydvCDqsr3smrAgYWpheOuhnCDtlZzrsojsl5Ag64uk6rWt7Ja066W8IOyalOyyre2VmOyXrCDsu7Ttj6zrhIztirjrpbwg66eM65Og64ukLlxuICogLSBhamF47J207ZuEIGxhbmdFZGl0b3JCb3hSZW5kZXIg7IKs7Jqp7IucIHR5cGXsnbQgJ29iaifroZwg65Ok7Ja06rCQLlxuICpcbiAqIDIpbGFuZ0VkaXRvckJveFJlbmRlcjpmbiDsmbjrtoDsl5DshJwg7KeB7KCR7Zi47Lac7ZWY7JesIOy7tO2PrOuEjO2KuOulvCDrp4zrk6Dri6RcbiAqIC0g7Lu07Y+s64SM7Yq4IHN0YXRl7JeQIOuLpOq1reyWtCDsoJXrs7TqsIAg7JeG7Jy866m0IO2VmOuCmOydmCDsu7Ttj6zrhIztirjsl5Ag64yA7ZWcIOuLpOq1reyWtCDsoJXrs7TrpbwgYWpheOuhnCDsmpTssq3tlZjsl6wg7IOB7YOc66W8IOqwseyLoO2VnOuLpC5cbiAqIDwvcHJlPlxuICogKi9cbmNsYXNzIExhbmdFZGl0b3JCb3gge1xuICBjb25zdHJ1Y3RvciAoeyAkd3JhcHBlciwgc2VxLCBuYW1lLCBsYW5nS2V5LCBtdWx0aWxpbmUsIGxpbmVzLCBhdXRvY29tcGxldGUsIHBsYWNlaG9sZGVyLCByZXF1aXJlZCB9KSB7XG4gICAgdGhpcy4kd3JhcHBlciA9ICR3cmFwcGVyXG4gICAgdGhpcy5zZXEgPSBzZXFcbiAgICB0aGlzLm5hbWUgPSBuYW1lXG4gICAgdGhpcy5sYW5nS2V5ID0gbGFuZ0tleVxuICAgIHRoaXMubXVsdGlsaW5lID0gbXVsdGlsaW5lXG4gICAgdGhpcy5saW5lcyA9IGxpbmVzIHx8IFtdXG4gICAgdGhpcy5hdXRvY29tcGxldGUgPSBhdXRvY29tcGxldGVcbiAgICB0aGlzLnBsYWNlaG9sZGVyID0gcGxhY2Vob2xkZXJcbiAgICB0aGlzLnJlcXVpcmVkID0gcmVxdWlyZWRcblxuICAgIHZhciB0aGF0ID0gdGhpc1xuICAgIHdpbmRvdy5YRS5hcHAoJ0xhbmcnKS50aGVuKChhcHBMYW5nKSA9PiB7XG4gICAgICAkKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdGhhdC5pbml0KClcbiAgICAgIH0pXG4gICAgfSlcbiAgfVxuXG4gIGluaXQgKCkge1xuXG5cblxuICAgIGlmICh0aGlzLmxhbmdLZXkgJiYgdGhpcy5saW5lcy5sZW5ndGggPT09IDApIHtcbiAgICAgIHdpbmRvdy5YRS5hamF4KHtcbiAgICAgICAgdHlwZTogJ2dldCcsXG4gICAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICAgIHVybDogY29uZmlnLmdldHRlcnNbJ3JvdXRlci9vcmlnaW4nXSArICcvbGFuZy9saW5lcy8nICsgdGhpcy5sYW5nS2V5LFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAocmVzdWx0KSB7XG4gICAgICAgICAgdGhpcy5zZXRMaW5lcyhyZXN1bHQpXG4gICAgICAgICAgdGhpcy5yZW5kZXIoKVxuICAgICAgICAgIHRoaXMuYmluZEV2ZW50cygpXG4gICAgICAgIH0uYmluZCh0aGlzKVxuICAgICAgfSlcbiAgICB9IGVsc2Uge1xuICAgICAgdGhpcy5yZW5kZXIoKVxuICAgICAgdGhpcy5iaW5kRXZlbnRzKClcbiAgICB9XG4gIH1cblxuICBiaW5kRXZlbnRzICgpIHtcbiAgICBpZiAodGhpcy5hdXRvY29tcGxldGUpIHtcbiAgICAgIHRoaXMuJHdyYXBwZXIuZmluZCgnaW5wdXRbdHlwZT10ZXh0XTpmaXJzdCx0ZXh0YXJlYTpmaXJzdCcpLmF1dG9jb21wbGV0ZSh7XG4gICAgICAgIHNvdXJjZTogJy9sYW5nL3NlYXJjaC8nICsgY29uZmlnLmdldHRlcnNbJ2xhbmcvY3VycmVudCddLmNvZGUsXG4gICAgICAgIG1pbkxlbmd0aDogMSxcbiAgICAgICAgZm9jdXM6IGZ1bmN0aW9uIChldmVudCwgdWkpIHtcbiAgICAgICAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpXG4gICAgICAgIH0sXG5cbiAgICAgICAgc2VsZWN0OiBmdW5jdGlvbiAoZXZlbnQsIHVpKSB7XG4gICAgICAgICAgdGhpcy5zZXRMaW5lcyh1aS5pdGVtLmxpbmVzKVxuICAgICAgICB9XG4gICAgICB9KVxuICAgIH1cbiAgfVxuXG4gIHJlbmRlciAoKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHZhciBsb2NhbGUgPSBjb25maWcuZ2V0dGVyc1snbGFuZy9kZWZhdWx0J11cbiAgICB2YXIgZmFsbGJhY2sgPSBjb25maWcuZ2V0dGVyc1snbGFuZy9mYWxsYmFjayddXG4gICAgdmFyIHJlc291cmNlID0gJ3hlX2xhbmdfcHJlcHJvY2Vzc29yOi8vbGFuZy9zZXEvJyArIHRoaXMuc2VxXG4gICAgdmFyIHZhbHVlID0gdGhpcy5nZXRWYWx1ZUZyb21MaW5lc1dpdGhMb2NhbGUobG9jYWxlLmNvZGUpIHx8ICcnXG4gICAgdmFyIGlucHV0Q2xhc3MgPSB0aGlzLm11bHRpbGluZSA/ICd0ZXh0YXJlYScgOiAndGV4dCdcbiAgICB2YXIgbXVsdGlsaW5lID0gdGhpcy5tdWx0aWxpbmVcbiAgICAgID8gYDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cIiR7cmVzb3VyY2UgKyAnL211bHRpbGluZSd9XCIgdmFsdWU9XCJ0cnVlXCIgLz5gXG4gICAgICA6ICcnXG5cbiAgICB2YXIgZWRpdG9yID0gdGhpcy5nZXRFZGl0b3IocmVzb3VyY2UsIGxvY2FsZS5jb2RlLCB2YWx1ZSlcbiAgICB2YXIgc3ViVGVtcGxhdGUgPSAnJ1xuXG4gICAgZmFsbGJhY2suZm9yRWFjaChmdW5jdGlvbiAobG9jYWxlLCBpKSB7XG4gICAgICB2YXIgdmFsdWUgPSBfdGhpcy5nZXRWYWx1ZUZyb21MaW5lc1dpdGhMb2NhbGUobG9jYWxlLmNvZGUpIHx8ICcnXG4gICAgICB2YXIgZWRpdG9yID0gX3RoaXMuZ2V0RWRpdG9yKHJlc291cmNlLCBsb2NhbGUuY29kZSwgdmFsdWUpXG5cbiAgICAgIHN1YlRlbXBsYXRlICs9IFtcbiAgICAgICAgYDxkaXYga2V5PVwiJHtsb2NhbGUuY29kZX1cIiBjbGFzcz1cImlucHV0LWdyb3VwXCI+YCxcbiAgICAgICAgYCR7ZWRpdG9yfWAsXG4gICAgICAgIGA8c3BhbiBjbGFzcz1cImlucHV0LWdyb3VwLWFkZG9uXCI+YCxcbiAgICAgICAgYDxzcGFuIGNsYXNzPVwiZmxhZy1jb2RlXCI+PGkgY2xhc3M9XCIke2xvY2FsZS5jb2RlICsgJyB4ZS1mbGFnJ31cIj48L2k+JHtsb2NhbGUubmF0aXZlTmFtZX08L3NwYW4+YCxcbiAgICAgICAgYDwvc3Bhbj5gLFxuICAgICAgICBgPC9kaXY+YFxuICAgICAgXS5qb2luKCdcXG4nKVxuICAgIH0pXG5cbiAgICB2YXIgdGVtcGxhdGUgPSBbXG4gICAgICBgPGRpdiBjbGFzcz1cIiR7aW5wdXRDbGFzc31cIj5gLFxuICAgICAgYDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cInhlX3VzZV9yZXF1ZXN0X3ByZXByb2Nlc3NvclwiIHZhbHVlPVwiWVwiLz5gLFxuICAgICAgYDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cIiR7cmVzb3VyY2UgKyAnL25hbWUnfVwiIHZhbHVlPVwiJHt0aGlzLm5hbWV9XCIgLz5gLFxuICAgICAgYDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cIiR7cmVzb3VyY2UgKyAnL2tleSd9XCIgdmFsdWU9XCIke3RoaXMubGFuZ0tleSB8fCAnJ31cIiAvPmAsXG4gICAgICBgJHttdWx0aWxpbmV9YCxcbiAgICAgIGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3RoaXMubmFtZX1cIiB2YWx1ZT1cIiR7dGhpcy5sYW5nS2V5IHx8ICcnfVwiIC8+YCxcbiAgICAgIGA8ZGl2IGtleT1cIiR7bG9jYWxlLmNvZGV9XCIgY2xhc3M9XCJpbnB1dC1ncm91cFwiPmAsXG4gICAgICBgJHtlZGl0b3J9YCxcbiAgICAgIGA8c3BhbiBjbGFzcz1cImlucHV0LWdyb3VwLWFkZG9uXCI+YCxcbiAgICAgIGA8c3BhbiBjbGFzcz1cImZsYWctY29kZVwiPjxpIGNsYXNzPVwiJHtsb2NhbGUuY29kZSArICcgeGUtZmxhZyd9XCI+PC9pPiR7bG9jYWxlLm5hdGl2ZU5hbWV9PC9zcGFuPmAsXG4gICAgICBgPC9zcGFuPmAsXG4gICAgICBgPC9kaXY+YCxcbiAgICAgIGA8ZGl2IGNsYXNzPVwic3ViXCI+JHtzdWJUZW1wbGF0ZX08L2Rpdj5gLFxuICAgICAgYDwvZGl2PmBcbiAgICBdLmpvaW4oJ1xcbicpXG5cbiAgICB0aGlzLiR3cmFwcGVyLmh0bWwodGVtcGxhdGUpXG4gIH1cblxuICBzZXRMaW5lcyAobGluZXMpIHtcbiAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgdGhpcy5saW5lcyA9IGxpbmVzXG5cbiAgICB3aW5kb3cuWEUuTGFuZy5sb2NhbGVzLm1hcChmdW5jdGlvbiAobG9jYWxlKSB7XG4gICAgICB2YXIgc2VsZWN0b3IgPSAnI2lucHV0LScgKyBfdGhpcy5zZXEgKyAnLScgKyBsb2NhbGUuY29kZVxuICAgICAgdmFyIHZhbHVlID0gX3RoaXMuZ2V0VmFsdWVGcm9tTGluZXNXaXRoTG9jYWxlKGxvY2FsZS5jb2RlKVxuICAgICAgJChzZWxlY3RvcikudmFsKHZhbHVlKVxuICAgIH0pXG4gIH1cblxuICBnZXRWYWx1ZUZyb21MaW5lc1dpdGhMb2NhbGUgKGxvY2FsZSkge1xuICAgIHZhciBsaW5lcyA9IHRoaXMubGluZXNcbiAgICB2YXIgaSA9IGxpbmVzLmxlbmd0aFxuICAgIHZhciBsID0ge31cblxuICAgIHdoaWxlIChpLS0pIHtcbiAgICAgIGwgPSBsaW5lc1tpXVxuICAgICAgaWYgKGwubG9jYWxlID09IGxvY2FsZSkge1xuICAgICAgICByZXR1cm4gbC52YWx1ZVxuICAgICAgfVxuICAgIH1cbiAgfVxuXG4gIGdldEVkaXRvciAocmVzb3VyY2UsIGxvY2FsZSwgdmFsdWUpIHtcbiAgICB2YXIgZWRpdCA9IG51bGxcbiAgICB2YXIgaWQgPSAoJ2lucHV0LScgKyB0aGlzLnNlcSArICctJyArIGxvY2FsZSlcbiAgICB2YXIgbmFtZSA9IChyZXNvdXJjZSArICcvbG9jYWxlLycgKyBsb2NhbGUpXG4gICAgdmFyIHBsYWNlaG9sZGVyID0gdGhpcy5wbGFjZWhvbGRlcjtcbiAgICB2YXIgcmVxdWlyZWQgPSAnJztcblxuICAgIGlmKF8uaXNBcnJheShwbGFjZWhvbGRlcikpIHtcbiAgICAgIHBsYWNlaG9sZGVyID0gXy5maW5kKHBsYWNlaG9sZGVyLCAobykgPT4geyByZXR1cm4gby5sb2NhbGUgPT09IGxvY2FsZSB9KS52YWx1ZTtcbiAgICB9XG4gICAgaWYodGhpcy5yZXF1aXJlZCA9PT0gJ3JlcXVpcmVkJyB8fCB0aGlzLnJlcXVpcmVkID09PSAndHJ1ZScgfHwgdGhpcy5yZXF1aXJlZCA9PT0gdHJ1ZSB8fCB0aGlzLnJlcXVpcmVkID09PSAxKSB7XG4gICAgICByZXF1aXJlZCA9ICdyZXF1aXJlZCdcbiAgICB9XG5cbiAgICBpZiAoIXRoaXMubXVsdGlsaW5lKSB7XG4gICAgICBlZGl0ID0gJChgPGlucHV0IHR5cGU9XCJ0ZXh0XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2xcIiBpZD1cIiR7aWR9XCIgbmFtZT1cIiR7bmFtZX1cIiBwbGFjZWhvbGRlcj1cIiR7cGxhY2Vob2xkZXJ9XCIgJHtyZXF1aXJlZH0gLz5gKS5hdHRyKCd2YWx1ZScsIHZhbHVlKS5hdHRyKCdkYXRhLW9yaWdpbi12YWx1ZScsIHZhbHVlKVxuICAgIH0gZWxzZSB7XG4gICAgICBlZGl0ID0gJChgPHRleHRhcmVhIGNsYXNzPVwiZm9ybS1jb250cm9sXCIgaWQ9XCIke2lkfVwiIG5hbWU9XCIke25hbWV9XCI+PC90ZXh0YXJlYT5gKS50ZXh0KHZhbHVlKS5hdHRyKCdkYXRhLW9yaWdpbi12YWx1ZScsIHZhbHVlKVxuICAgIH1cblxuICAgIHJldHVybiBlZGl0LnByb3AoJ291dGVySFRNTCcpXG4gIH1cbn1cblxudmFyIHNlcSA9IDBcbi8qKlxuICogdGFyZ2V0IGVsZW1lbnTsl5AgTGFuZ0VkaXRvckJveOulvCDrnpzrjZTrp4HtlaguXG4gKiBARklYTUVcbiAqIEBnbG9iYWxcbiAqIEBmdW5jdGlvbiBsYW5nRWRpdG9yQm94UmVuZGVyXG4gKiAqL1xud2luZG93LmxhbmdFZGl0b3JCb3hSZW5kZXIgPSBmdW5jdGlvbiAoJGRhdGEsIHR5cGUpIHtcbiAgaWYgKHR5cGUgPT09ICdvYmonKSB7XG4gICAgLy8geyBuYW1lLCBsYW5nS2V5LCBtdWx0aWxpbmUsIGxpbmVzLCBhdXRvY29tcGxldGUsIHRhcmdldCB9XG4gICAgbGV0IG5hbWUgPSAkZGF0YS5uYW1lXG4gICAgbGV0IGxhbmdLZXkgPSAkZGF0YS5sYW5nS2V5XG4gICAgbGV0IG11bHRpbGluZSA9ICRkYXRhLm11bHRpbGluZVxuICAgIGxldCBsaW5lcyA9ICRkYXRhLmxpbmVzXG4gICAgbGV0IGF1dG9jb21wbGV0ZSA9ICRkYXRhLmF1dG9jb21wbGV0ZVxuICAgIGxldCB0YXJnZXQgPSAkZGF0YS50YXJnZXRcbiAgICBsZXQgcGxhY2Vob2xkZXIgPSAkZGF0YS5wbGFjZWhvbGRlclxuICAgIGxldCByZXF1aXJlZCA9ICRkYXRhLnJlcXVpcmVkXG4gICAgbmV3IExhbmdFZGl0b3JCb3goeyAkd3JhcHBlcjogJCgkZGF0YS50YXJnZXQpLCBzZXEsIG5hbWUsIGxhbmdLZXksIG11bHRpbGluZSwgbGluZXMsIGF1dG9jb21wbGV0ZSwgcGxhY2Vob2xkZXIsIHJlcXVpcmVkIH0pXG4gIH0gZWxzZSB7XG4gICAgdmFyIG5hbWUgPSAkZGF0YS5kYXRhKCduYW1lJylcbiAgICB2YXIgbGFuZ0tleSA9ICRkYXRhLmRhdGEoJ2xhbmcta2V5JylcbiAgICB2YXIgbXVsdGlsaW5lID0gJGRhdGEuZGF0YSgnbXVsdGlsaW5lJylcbiAgICB2YXIgbGluZXMgPSAkZGF0YS5kYXRhKCdsaW5lcycpXG4gICAgdmFyIGF1dG9jb21wbGV0ZSA9ICRkYXRhLmRhdGEoJ2F1dG9jb21wbGV0ZScpXG5cbiAgICBuZXcgTGFuZ0VkaXRvckJveCh7ICR3cmFwcGVyOiAkZGF0YSwgc2VxLCBuYW1lLCBsYW5nS2V5LCBtdWx0aWxpbmUsIGxpbmVzLCBhdXRvY29tcGxldGUgfSlcbiAgfVxuXG4gIHNlcSsrXG59XG5cbi8vIEBGSVhNRVxuJChmdW5jdGlvbiAoKSB7XG4gIHJlbmRlckxhbmdFZGl0b3JCb3goKVxufSlcblxuLy8gQEZJWE1FXG5mdW5jdGlvbiByZW5kZXJMYW5nRWRpdG9yQm94ICgpIHtcbiAgbGV0IGxhbmdLZXlzID0gW11cbiAgbGV0IGxhbmdPYmogPSB7fVxuICBsZXQgbGFuZ3MgPSBbXVxuICBsZXQgaWR4ID0gMFxuXG4gIGlmICgkKCcubGFuZy1lZGl0b3ItYm94JykubGVuZ3RoID4gMCkge1xuICAgICQoJy5sYW5nLWVkaXRvci1ib3gnKS5lYWNoKGZ1bmN0aW9uIChrZXksIGkpIHtcbiAgICAgIGxldCAkdGhpcyA9ICQodGhpcylcblxuICAgICAgbGV0IG5hbWUgPSAkdGhpcy5kYXRhKCduYW1lJylcbiAgICAgIGxldCBsYW5nS2V5ID0gJHRoaXMuZGF0YSgnbGFuZy1rZXknKVxuICAgICAgbGV0IG11bHRpbGluZSA9ICR0aGlzLmRhdGEoJ211bHRpbGluZScpXG4gICAgICBsZXQgbGluZXMgPSAkdGhpcy5kYXRhKCdsaW5lcycpXG4gICAgICBsZXQgYXV0b2NvbXBsZXRlID0gJHRoaXMuZGF0YSgnYXV0b2NvbXBsZXRlJylcbiAgICAgIGxldCBwbGFjZWhvbGRlciA9ICR0aGlzLmRhdGEoJ3BsYWNlaG9sZGVyJylcbiAgICAgIGxldCByZXF1aXJlZCA9ICR0aGlzLmRhdGEoJ3JlcXVpcmVkJylcblxuICAgICAgaWYgKGxhbmdLZXkpIHtcbiAgICAgICAgbGFuZ0tleXMucHVzaChsYW5nS2V5KVxuICAgICAgfVxuXG4gICAgICBpZiAocGxhY2Vob2xkZXIpIHtcbiAgICAgICAgbGFuZ0tleXMucHVzaChwbGFjZWhvbGRlcilcbiAgICAgIH1cblxuICAgICAgbGFuZ3MucHVzaCh7XG4gICAgICAgIG5hbWUsXG4gICAgICAgIGxhbmdLZXksXG4gICAgICAgIG11bHRpbGluZSxcbiAgICAgICAgbGluZXMsXG4gICAgICAgIGF1dG9jb21wbGV0ZSxcbiAgICAgICAgcGxhY2Vob2xkZXIsXG4gICAgICAgIHJlcXVpcmVkLFxuICAgICAgICB0YXJnZXQ6ICR0aGlzWzBdXG4gICAgICB9KVxuXG4gICAgICBpZHgrK1xuXG4gICAgfSlcblxuICAgIGlmIChsYW5nS2V5cy5sZW5ndGggPiAwKSB7XG4gICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgIHR5cGU6ICdwb3N0JyxcbiAgICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgICAgdXJsOiBjb25maWcuZ2V0dGVyc1sncm91dGVyL29yaWdpbiddICsgJy9sYW5nL2xpbmVzL21hbnknLFxuICAgICAgICBkYXRhOiB7XG4gICAgICAgICAga2V5czogbGFuZ0tleXNcbiAgICAgICAgfSxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3VsdCkge1xuICAgICAgICAgICQuZWFjaChyZXN1bHQsIChrZXksIGFycikgPT4ge1xuICAgICAgICAgICAgJC5lYWNoKGxhbmdzLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgIGlmIChrZXkgPT09IHRoaXMubGFuZ0tleSkge1xuICAgICAgICAgICAgICAgIHRoaXMubGluZXMgPSBhcnJcbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSlcbiAgICAgICAgICB9KVxuICAgICAgICAgICQuZWFjaChsYW5ncywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaWYoXy5oYXNJbihyZXN1bHQsIHRoaXMucGxhY2Vob2xkZXIpICYmICFfLmlzRW1wdHkocmVzdWx0W3RoaXMucGxhY2Vob2xkZXJdKSkge1xuICAgICAgICAgICAgICB0aGlzLnBsYWNlaG9sZGVyID0gcmVzdWx0W3RoaXMucGxhY2Vob2xkZXJdO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgd2luZG93LmxhbmdFZGl0b3JCb3hSZW5kZXIodGhpcywgJ29iaicpIC8vIEBGSVhNRVxuICAgICAgICAgIH0pXG4gICAgICAgIH1cbiAgICAgIH0pXG4gICAgfSBlbHNlIHtcbiAgICAgICQuZWFjaChsYW5ncywgZnVuY3Rpb24gKCkge1xuICAgICAgICB3aW5kb3cubGFuZ0VkaXRvckJveFJlbmRlcih0aGlzLCAnb2JqJykgLy8gQEZJWE1FXG4gICAgICB9KVxuICAgIH1cbiAgfVxuXG4gIHdpbmRvdy5YRS5WYWxpZGF0b3IucHV0KCdsYW5ncmVxdWlyZWQnLCBmdW5jdGlvbiAoJGRzdCwgcGFyYW1ldGVycykge1xuICAgIHZhciAkaW5wdXQgPSAkZHN0LmNsb3Nlc3QoJy5sYW5nLWVkaXRvci1ib3gnKS5maW5kKFwiaW5wdXRbbmFtZV49J3hlX2xhbmdfcHJlcHJvY2Vzc29yJ106bm90KDpoaWRkZW4pOmZpcnN0XCIpXG4gICAgdmFyIHZhbHVlID0gJGlucHV0LnZhbCgpXG4gICAgdmFyIG5hbWUgPSAkZHN0LmNsb3Nlc3QoJy5sYW5nLWVkaXRvci1ib3gnKS5kYXRhKCd2YWxpZC1uYW1lJykgfHwgJGRzdC5jbG9zZXN0KCcubGFuZy1lZGl0b3ItYm94JykuZGF0YSgnbmFtZScpXG5cbiAgICBpZiAodmFsdWUgPT09ICcnKSB7XG4gICAgICB3aW5kb3cuWEUuVmFsaWRhdG9yLmVycm9yKCRpbnB1dCwgd2luZG93LlhFLkxhbmcudHJhbnMoJ3ZhbGlkYXRpb24ucmVxdWlyZWQnLCB7IGF0dHJpYnV0ZTogbmFtZSB9KSlcbiAgICAgIHJldHVybiBmYWxzZVxuICAgIH1cblxuICAgIHJldHVybiB0cnVlXG4gIH0pXG59XG5cbi8vIEBGSVhNRVxuJChkb2N1bWVudCkub24oJ2ZvY3VzJywgJy5sYW5nLWVkaXRvci1ib3ggaW5wdXQsIHRleHRhcmVhJywgZnVuY3Rpb24gKCkge1xuICB2YXIgYm94ID0gJCh0aGlzKS5jbG9zZXN0KCcubGFuZy1lZGl0b3ItYm94JylcbiAgdmFyIGVsID0gYm94LmZpbmQoJy5zdWInKVxuICBpZiAoJChlbCkuaXMoJzpoaWRkZW4nKSkge1xuICAgICQoZWwpLnNsaWRlRG93bignZmFzdCcpXG4gIH1cbn0pXG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTcwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQ3Mik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDcpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg4KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTY2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNzYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyNik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDczKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE5KTsiLCJtb2R1bGUuZXhwb3J0cyA9IF94ZV9kbGxfY29tbW9uOyJdLCJzb3VyY2VSb290IjoiIn0=