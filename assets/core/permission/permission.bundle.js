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
/******/ 	return __webpack_require__(__webpack_require__.s = "./core/permission/permission.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./core/index.js":
/*!*******************************************************************!*\
  !*** delegated ./core/index.js from dll-reference _xe_dll_common ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(447);

/***/ }),

/***/ "./core/permission/permission.js":
/*!***************************************!*\
  !*** ./core/permission/permission.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.join */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_regexp_constructor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.regexp.constructor */ "./node_modules/core-js/modules/es.regexp.constructor.js");
/* harmony import */ var core_js_modules_es_regexp_constructor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_constructor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.regexp.exec */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_regexp_to_string__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.regexp.to-string */ "./node_modules/core-js/modules/es.regexp.to-string.js");
/* harmony import */ var core_js_modules_es_regexp_to_string__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_to_string__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.string.replace */ "./node_modules/core-js/modules/es.string.replace.js");
/* harmony import */ var core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/json/stringify */ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/splice */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/index-of */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/concat */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/map */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/for-each */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_parse_int__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/parse-int */ "./node_modules/@babel/runtime-corejs3/core-js-stable/parse-int.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_parse_int__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_parse_int__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/trim */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_15__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_16__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_17___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_17__);
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! xe */ "./core/index.js");


















 // TODO:: mouseover,

var Keys = {
  ENTER: 13,
  TAB: 9,
  BACKSPACE: 8,
  UP_ARROW: 38,
  DOWN_ARROW: 40,
  ESCAPE: 27
};

var Permission =
/*#__PURE__*/
function () {
  function Permission(_ref) {
    var $wrapper = _ref.$wrapper,
        key = _ref.key,
        userSearchUrl = _ref.userSearchUrl,
        groupSearchUrl = _ref.groupSearchUrl,
        permission = _ref.permission,
        type = _ref.type,
        vgroupAll = _ref.vgroupAll;

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_15___default()(this, Permission);

    this.$wrapper = $wrapper;
    this.key = key;
    this.userSearchUrl = userSearchUrl;
    this.groupSearchUrl = groupSearchUrl;
    this.permission = permission;
    this.type = type;
    this.vgroupAll = vgroupAll;
    this.query = '';
    this.suggestion = [];
    this.placeholder = xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::explainIncludeUserOrGroup');
    this.selectedIndex = '';
    this.includeSelectedIndex = -1;
    this.excludeSelectedIndex = -1;
    this.MIN_QUERY_LENGTH = 2;
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_16___default()(Permission, [{
    key: "bindEvents",
    value: function bindEvents() {
      var _context11, _context12;

      var _this = this;

      this.$wrapper.on('change', '.chkModeAble', function (e) {
        var $target = jquery__WEBPACK_IMPORTED_MODULE_17___default()(e.target);
        var checked = $target.is(':checked');

        if (checked) {
          var _context;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context = _this.$wrapper).call(_context, 'input:not(.chkModeAble)').prop('disabled', true);
        } else {
          var _context2;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context2 = _this.$wrapper).call(_context2, 'input:not(.chkModeAble)').prop('disabled', false);
        }
      });
      this.$wrapper.on('keydown', '.inputUserGroup', function (e) {
        var _context3, _context4;

        var query = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default()(_context3 = e.target.value).call(_context3);

        var $this = jquery__WEBPACK_IMPORTED_MODULE_17___default()(this);
        var keyCode = e.keyCode;

        var $ul = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context4 = $this.parent()).call(_context4, '.ReactTags__suggestions ul');

        var dataInput = $this.data('input'); // include, exclude

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          if ($ul.length > 0) {
            var index = _babel_runtime_corejs3_core_js_stable_parse_int__WEBPACK_IMPORTED_MODULE_12___default()($this.data('index'), 10);

            var focusedIndex = 0;

            switch (keyCode) {
              case Keys.UP_ARROW:
                if (index == 0) {
                  focusedIndex = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()($ul).call($ul, 'li').length - 1;
                } else {
                  focusedIndex = index - 1;
                }

                $this.data('index', focusedIndex);

                _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()($ul).call($ul, 'li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;

              case Keys.DOWN_ARROW:
                if (index == _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()($ul).call($ul, 'li').length - 1) {
                  focusedIndex = 0;
                } else {
                  focusedIndex = index + 1;
                }

                $this.data('index', focusedIndex);

                _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()($ul).call($ul, 'li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;

              case Keys.ENTER:
              case Keys.TAB:
                e.preventDefault();

                if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()($ul).call($ul, 'li.active').length > 0) {
                  var _context5;

                  var tag = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()($ul).call($ul, 'li.active').data('tag');

                  var name = '';
                  var pType = '';
                  var prefix = ''; // user

                  if ($ul.data('target') == 'user') {
                    // include
                    if (dataInput == 'include') {
                      name = _this.type + 'User';
                      pType = 'user';
                      prefix = '@'; // exclude
                    } else {
                      name = _this.type + 'Except';
                      pType = 'except';
                      prefix = '@';
                    } // group

                  } else {
                    name = _this.type + 'Group';
                    pType = 'group';
                    prefix = '%';
                  }

                  var pTypes = _this.permission[pType];
                  var bSameWord = false;

                  if (pTypes.length > 0) {
                    _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(pTypes).call(pTypes, function (type, i) {
                      if (type.id === tag.id) {
                        bSameWord = true;
                      }
                    });

                    if (!bSameWord) {
                      _this.permission[pType].push(tag);
                    }
                  } else {
                    _this.permission[pType].push(tag);
                  }

                  var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10___default()(_context5 = _this.permission[pType]).call(_context5, function (tag) {
                    return tag.id;
                  });

                  if (!bSameWord) {
                    var _context6, _context7, _context8, _context9;

                    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context6 = $ul.closest('.ReactTags__tags')).call(_context6, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default()(_context7 = ids.join()).call(_context7));

                    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context8 = $ul.closest('.ReactTags__tags')).call(_context8, '.' + pType + 'Wrap').append(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context9 = "<span class=\"ReactTags__tag\">".concat(prefix + (tag.display_name || tag.name), "<a class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context9, tag.id, "\">x</a></span>"));
                  }

                  $ul.remove();
                  $this.val('').data('index', -1).focus();
                }

                e.preventDefault(); // prevent tab

                break;

              case Keys.ESCAPE:
                _this[dataInput + 'SelectedIndex'] = 0;
                $ul.parent().empty();
                $this.focus();
                break;
            }
          }
        } else {
          if (Keys.BACKSPACE === keyCode) {
            var _context10;

            var $tag = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context10 = $this.closest('.ReactTags__tags')).call(_context10, '.ReactTags__selected span');

            if (!query && $tag.length > 0) {
              _this.removeTag($tag.eq($tag.length - 1));
            }
          }
        }
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context11 = this.$wrapper).call(_context11, '.ReactTags__suggestions').on('mouseenter', 'li', function () {
        var $this = jquery__WEBPACK_IMPORTED_MODULE_17___default()(this);
        var $ul = $this.closest('ul');
        $this.addClass('active').siblings().removeClass('active');
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context12 = this.$wrapper).call(_context12, '.ReactTags__suggestions').on('click', 'li', function () {
        var _context13, _context14;

        var $this = jquery__WEBPACK_IMPORTED_MODULE_17___default()(this);
        var tag = $this.data('tag');
        var $ul = $this.closest('ul');

        var $input = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context13 = $this.closest('.ReactTags__tagInput')).call(_context13, 'input:text');

        var dataInput = $input.data('input');
        var id = tag.id;
        var name = '';
        var pType = '';
        var prefix = '';

        if ($ul.data('target') == 'user') {
          // include
          if (dataInput == 'include') {
            name = _this.type + 'User';
            pType = 'user';
            prefix = '@'; // exclude
          } else {
            name = _this.type + 'Except';
            pType = 'except';
            prefix = '@';
          } // group

        } else {
          name = _this.type + 'Group';
          pType = 'group';
          prefix = '%';
        }

        var pTypes = _this.permission[pType];
        var bSameWord = false;

        if (pTypes.length > 0) {
          _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(pTypes).call(pTypes, function (type, i) {
            if (type.id === tag.id) {
              bSameWord = true;
            }
          });

          if (!bSameWord) {
            _this.permission[pType].push(tag);
          }
        } else {
          _this.permission[pType].push(tag);
        }

        var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10___default()(_context14 = _this.permission[pType]).call(_context14, function (tag) {
          return tag.id;
        });

        if (!bSameWord) {
          var _context15, _context16, _context17, _context18;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context15 = $ul.closest('.ReactTags__tags')).call(_context15, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default()(_context16 = ids.join()).call(_context16));

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context17 = $ul.closest('.ReactTags__tags')).call(_context17, '.' + pType + 'Wrap').append(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context18 = "<span class=\"ReactTags__tag\">".concat(prefix + (tag.display_name || tag.name), "<a class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context18, tag.id, "\">x</a></span>"));
        }

        $ul.remove();
        $input.val('').data('index', -1).focus();
      });

      this.$wrapper.on('keyup', '.inputUserGroup', function (e) {
        var _context19;

        var query = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default()(_context19 = e.target.value).call(_context19);

        var $this = jquery__WEBPACK_IMPORTED_MODULE_17___default()(this);
        var keyCode = e.keyCode;

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          var _context20;

          if (_babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_8___default()(_context20 = [Keys.ENTER, Keys.TAB, Keys.UP_ARROW, Keys.DOWN_ARROW, Keys.ESCAPE, 37, 39]).call(_context20, keyCode) == -1) {
            var _context21;

            var temp = '';
            temp += "<ul>";
            temp += "<li>Searching ... <span class=\"spinner\" role=\"spinner\"><span class=\"spinner-icon\"></span></span></li>";
            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context21 = $this.parent()).call(_context21, '.ReactTags__suggestions').html(temp);

            var identifier = query.substr(0, 1);

            switch (identifier) {
              case '@':
                query = query.substr(1, query.length);

                _this.searchUser($this, query);

                break;

              case '%':
                query = query.substr(1, query.length);

                _this.searchGroup($this, query);

                break;

              default:
                break;
            }
          }
        } else {
          var _context22;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context22 = $this.parent()).call(_context22, '.ReactTags__suggestions').empty();
        }
      });
      this.$wrapper.on('click', '.btnRemoveTag', function (e) {
        e.preventDefault();

        _this.removeTag(jquery__WEBPACK_IMPORTED_MODULE_17___default()(this).closest('span'));
      });
    }
  }, {
    key: "makeIt",
    value: function makeIt(item, query) {
      var escapedRegex = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default()(query).call(query).replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');

      var r = RegExp(escapedRegex, 'gi');
      var itemName = item.display_name || item.name;
      return itemName.replace(r, '<mark>$&</mark>');
    }
  }, {
    key: "removeTag",
    value: function removeTag($target) {
      var _context24, _context25, _context26;

      var _this = this;

      var pType = $target.closest('.ReactTags__selected').data('ptype');
      var id = $target.data('id');
      var name = '';

      switch (pType) {
        case 'user':
          name = _this.type + 'User';
          break;

        case 'except':
          name = _this.type + 'Except';
          break;

        case 'group':
          name = _this.type + 'Group';
          break;
      }

      var pTypes = _this.permission[pType];

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(pTypes).call(pTypes, function (type, i) {
        if (type.id !== id) {
          var _context23;

          _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_7___default()(_context23 = _this.permission[pType]).call(_context23, i, 1); // .push(tag);

        }
      });

      var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10___default()(_context24 = _this.permission[pType]).call(_context24, function (tag) {
        return tag.id;
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context25 = $target.closest('.ReactTags__tags')).call(_context25, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default()(_context26 = ids.join()).call(_context26));

      $target.remove();
    }
  }, {
    key: "searchUser",
    value: function searchUser($input, keyword) {
      var _this = this;

      var searchUserUrl = _this.userSearchUrl;
      xe__WEBPACK_IMPORTED_MODULE_18__["default"].ajax({
        url: searchUserUrl + '/' + keyword,
        method: 'get',
        dataType: 'json',
        cache: false,
        success: function success(data) {
          if (data.length > 0) {
            var _context27;

            var temp = '';
            temp += "<ul data-target=\"user\">";

            _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(data).call(data, function (item, i) {
              temp += "<li class=\"\" data-tag='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_6___default()(item), "'>");
              temp += "<span>".concat(_this.makeIt(item, keyword), "</span>");
              temp += "</li>";
            });

            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context27 = $input.parent()).call(_context27, '.ReactTags__suggestions').html(temp);
          } else {
            var _context28;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context28 = $input.parent()).call(_context28, '.ReactTags__suggestions').empty();
          }
        },
        error: function error(xhr, status, err) {}
      });
    }
  }, {
    key: "searchGroup",
    value: function searchGroup($input, keyword) {
      var _this = this;

      var searchGroupUrl = _this.groupSearchUrl;
      xe__WEBPACK_IMPORTED_MODULE_18__["default"].ajax({
        url: searchGroupUrl + '/' + keyword,
        method: 'get',
        dataType: 'json',
        cache: false,
        success: function success(data) {
          // TODO:: view renderin
          if (data.length > 0) {
            var _context29;

            var temp = '';
            temp += "<ul data-target=\"group\">";

            _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(data).call(data, function (item, i) {
              temp += "<li data-tag='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_6___default()(item), "'>");
              temp += "<span>".concat(_this.makeIt(item, keyword), "</span>");
              temp += "</li>";
            });

            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context29 = $input.parent()).call(_context29, '.ReactTags__suggestions').html(temp);
          } else {
            var _context30;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_14___default()(_context30 = $input.parent()).call(_context30, '.ReactTags__suggestions').empty();
          }
        },
        error: function error(xhr, status, err) {}
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _context31, _context32, _context33, _context40, _context42, _context44, _context45, _context46, _context47, _context48, _context49, _context55, _context57, _context58;

      var _this = this;

      var mode = this.permission.mode;
      var rating = this.permission.rating;
      var modeEnable = false;
      var permissionTypes = [{
        value: 'super',
        name: xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::userRatingAdministrator')
      }, {
        value: 'manager',
        name: xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::userRatingManager')
      }, {
        value: 'user',
        name: xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::user')
      }, {
        value: 'guest',
        name: xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::guest')
      }];
      var disabled = false;

      if (mode === 'manual' || mode === 'inherit') {
        modeEnable = true;

        if (mode !== 'manual') {
          disabled = true;
        }
      }

      var includeGroups = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10___default()(_context31 = this.permission.group).call(_context31, function (group) {
        return group.id;
      });

      var includeUsers = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10___default()(_context32 = this.permission.user).call(_context32, function (user) {
        return user.id;
      });

      var excludeUsers = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10___default()(_context33 = this.permission.except).call(_context33, function (user) {
        return user.id;
      });

      var temp = '';
      temp += "<div>";

      if (modeEnable) {
        var _context34, _context35;

        var checked = mode === 'inherit' ? 'checked="checked"' : '';
        temp += "<div class=\"form-group\">";
        temp += "<div class=\"checkbox\">";
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context34 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context35 = "<label><input type=\"checkbox\" name=\"".concat(this.type + 'Mode', "\" class=\"chkModeAble\" value=\"inherit\" ")).call(_context35, checked, " /> ")).call(_context34, xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::inheritMode'), "</label>");
        temp += "</div>";
        temp += "</div>";
      }

      temp += "<div class=\"form-group\">";
      temp += "<label>\uD68C\uC6D0 \uB4F1\uAE09</label>";
      temp += '<div class="radio">';

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(permissionTypes).call(permissionTypes, function (permissionType) {
        var _context36, _context37, _context38, _context39;

        var checked = permissionType.value == rating ? 'checked' : '';
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context36 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context37 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context38 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context39 = "<label><input type=\"radio\" ".concat(disabled ? 'disabled="disabled"' : '', " name=\"")).call(_context39, _this.type + 'Rating', "\" value=\"")).call(_context38, permissionType.value, "\" ")).call(_context37, checked ? 'checked="checked"' : '', " /> ")).call(_context36, permissionType.name, " &nbsp;</label>");
      });

      temp += "</div>";
      temp += "</div>";
      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::includeUserOrGroup'), "</label>");
      temp += "<div class=\"ReactTags__tags\">";
      temp += "<div class=\"ReactTags__selected groupWrap\" data-ptype=\"group\">";

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(_context40 = this.permission.group).call(_context40, function (g) {
        var _context41;

        var tag = g;
        var label = '%' + (tag.display_name || tag.name);
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context41 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context41, tag.id, "\">x</a></span>");
      });

      temp += '</div>';
      temp += '<div class="ReactTags__selected userWrap" data-ptype="user">';

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(_context42 = this.permission.user).call(_context42, function (tag) {
        var _context43;

        var label = '@' + (tag.display_name || tag.name);
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context43 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context43, tag.id, "|\">x</a></span>");
      });

      temp += "</div>";
      temp += "<div class=\"ReactTags__tagInput\">";
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context44 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context45 = "<input type=\"text\" placeholder=\"".concat(this.placeholder, "\" class=\"form-control inputUserGroup\" data-input=\"include\" ")).call(_context45, disabled ? 'disabled="disabled"' : '', " value=\"")).call(_context44, this.query, "\" data-index=\"-1\" />"); // TODO:: PermissionInclude handleKeyDown

      temp += "<div class=\"ReactTags__suggestions\" data-input=\"include\"></div>";
      temp += "</div>"; // ReactTags__tagInput

      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context46 = "<input type=\"hidden\" name=\"".concat(this.type + 'Group', "\" class=\"form-control includeGroups\" value=\"")).call(_context46, _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default()(_context47 = includeGroups.join()).call(_context47), "\" />");
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context48 = "<input type=\"hidden\" name=\"".concat(this.type + 'User', "\" class=\"form-control includeUsers\" value=\"")).call(_context48, _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_13___default()(_context49 = includeUsers.join()).call(_context49), "\" />");
      temp += "</div>"; // ReactTags__tags

      temp += "</div>"; // form-group

      if (this.vgroupAll.length >= 1) {
        var _context50;

        temp += "<div class=\"form-group\">";
        temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::includeVGroup'), "</label>");
        temp += _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_10___default()(_context50 = _this.vgroupAll).call(_context50, function (data) {
          var _context51, _context52, _context53, _context54;

          var checked = false;

          var inArray = function inArray(val, arr) {
            for (var i = 0; i < arr.length; i++) {
              if (arr[i] == val) {
                return i;
              }
            }

            return -1;
          };

          if (inArray(data.id, this.permission.vgroup) != -1) {
            checked = true;
          }

          return _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context51 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context52 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context53 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context54 = "<label><input type=\"checkbox\" ".concat(disabled ? 'disabled="disabled"' : '', " name=\"")).call(_context54, _this.type + 'VGroup[]', "\" value=\"")).call(_context53, data.id, "\" ")).call(_context52, checked ? 'checked="checked"' : '', " /> ")).call(_context51, data.title, " &nbsp;</label>");
        });
        temp += '</div>';
      }

      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::excludeUser'), "</label>");
      temp += "<div class=\"ReactTags__tags\">";
      temp += "<div class=\"ReactTags__selected exceptWrap\" data-ptype=\"except\">";

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_11___default()(_context55 = this.permission.except).call(_context55, function (tag) {
        var _context56;

        var label = tag.display_name || tag.name;
        label = '@' + label;
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context56 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context56, tag.id, "\">x</a></span>");
      });

      temp += "</div>";
      temp += "<div class=\"ReactTags__tagInput\">";
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context57 = "<input type=\"text\" placeholder=\"".concat(xe__WEBPACK_IMPORTED_MODULE_18__["default"].Lang.trans('xe::explainExcludeUser'), "\" class=\"form-control inputUserGroup\" data-input=\"exclude\" ")).call(_context57, disabled ? 'disabled="disabled"' : '', " data-index=\"-1\" />"); // TODO:: PermissionExclude handleKeyDown

      temp += "<div class=\"ReactTags__suggestions\" data-input=\"exclude\"></div>";
      temp += "</div>"; // ReactTags__tagInput

      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_9___default()(_context58 = "<input type=\"hidden\" name=\"".concat(this.type + 'Except', "\" class=\"form-control excludeUsers\" value=\"")).call(_context58, excludeUsers, "\" />");
      temp += "</div>"; // ReactTags__tags

      temp += "</div>"; // form-group

      temp += "</div>";
      this.$wrapper.html(temp);
    }
  }]);

  return Permission;
}();

jquery__WEBPACK_IMPORTED_MODULE_17___default()('.__xe__uiobject_permission').each(function (i) {
  var $this = jquery__WEBPACK_IMPORTED_MODULE_17___default()(this);
  var permission = $this.data('data');
  var key = $this.data('key');
  var type = $this.data('type');
  var userSearchUrl = $this.data('userUrl');
  var groupSearchUrl = $this.data('groupUrl');
  var vgroupAll = $this.data('vgroupAll');
  var p = new Permission({
    $wrapper: $this,
    key: key,
    userSearchUrl: userSearchUrl,
    groupSearchUrl: groupSearchUrl,
    permission: permission,
    type: type,
    vgroupAll: vgroupAll
  });
  p.render();
  p.bindEvents();
});

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(145);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(4);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(17);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(19);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js":
/*!************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(408);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(74);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(143);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! core-js-pure/stable/json/stringify */ "./node_modules/core-js-pure/stable/json/stringify.js");

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/parse-int.js":
/*!*********************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/parse-int.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(5);

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

/***/ "./node_modules/core-js-pure/es/json/stringify.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js-pure/es/json/stringify.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../../modules/es.json.stringify */ "./node_modules/core-js-pure/modules/es.json.stringify.js");
var core = __webpack_require__(/*! ../../internals/path */ "./node_modules/core-js-pure/internals/path.js");

if (!core.JSON) core.JSON = { stringify: JSON.stringify };

// eslint-disable-next-line no-unused-vars
module.exports = function stringify(it, replacer, space) {
  return core.JSON.stringify.apply(null, arguments);
};


/***/ }),

/***/ "./node_modules/core-js-pure/internals/export.js":
/*!***************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/export.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(8);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/fails.js":
/*!**************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/fails.js from dll-reference _xe_dll_common ***!
  \**************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(25);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/get-built-in.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/get-built-in.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(63);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/path.js":
/*!*************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/path.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(18);

/***/ }),

/***/ "./node_modules/core-js-pure/modules/es.json.stringify.js":
/*!****************************************************************!*\
  !*** ./node_modules/core-js-pure/modules/es.json.stringify.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js-pure/internals/export.js");
var getBuiltIn = __webpack_require__(/*! ../internals/get-built-in */ "./node_modules/core-js-pure/internals/get-built-in.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js-pure/internals/fails.js");

var $stringify = getBuiltIn('JSON', 'stringify');
var re = /[\uD800-\uDFFF]/g;
var low = /^[\uD800-\uDBFF]$/;
var hi = /^[\uDC00-\uDFFF]$/;

var fix = function (match, offset, string) {
  var prev = string.charAt(offset - 1);
  var next = string.charAt(offset + 1);
  if ((low.test(match) && !hi.test(next)) || (hi.test(match) && !low.test(prev))) {
    return '\\u' + match.charCodeAt(0).toString(16);
  } return match;
};

var FORCED = fails(function () {
  return $stringify('\uDF06\uD834') !== '"\\udf06\\ud834"'
    || $stringify('\uDEAD') !== '"\\udead"';
});

if ($stringify) {
  // https://github.com/tc39/proposal-well-formed-stringify
  $({ target: 'JSON', stat: true, forced: FORCED }, {
    // eslint-disable-next-line no-unused-vars
    stringify: function stringify(it, replacer, space) {
      var result = $stringify.apply(null, arguments);
      return typeof result == 'string' ? result.replace(re, fix) : result;
    }
  });
}


/***/ }),

/***/ "./node_modules/core-js-pure/stable/json/stringify.js":
/*!************************************************************!*\
  !*** ./node_modules/core-js-pure/stable/json/stringify.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__(/*! ../../es/json/stringify */ "./node_modules/core-js-pure/es/json/stringify.js");

module.exports = parent;


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

/***/ "./node_modules/core-js/modules/es.regexp.constructor.js":
/*!***********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.constructor.js from dll-reference _xe_dll_common ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(269);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.exec.js":
/*!****************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.exec.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(38);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(170);

/***/ }),

/***/ "./node_modules/core-js/modules/es.string.replace.js":
/*!*******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.string.replace.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(80);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL2NvcmUvcGVybWlzc2lvbi9wZXJtaXNzaW9uLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9jb25jYXQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9maW5kLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvZm9yLWVhY2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9pbmRleC1vZi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL21hcC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL3NwbGljZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL3RyaW0uanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9wYXJzZS1pbnQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NsYXNzQ2FsbENoZWNrLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jcmVhdGVDbGFzcy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9lcy9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9pbnRlcm5hbHMvZXhwb3J0LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9pbnRlcm5hbHMvZmFpbHMuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9nZXQtYnVpbHQtaW4uanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9wYXRoLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL21vZHVsZXMvZXMuanNvbi5zdHJpbmdpZnkuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9zdGFibGUvanNvbi9zdHJpbmdpZnkuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuYXJyYXkuam9pbi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuZnVuY3Rpb24ubmFtZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMucmVnZXhwLmNvbnN0cnVjdG9yLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5yZWdleHAuZXhlYy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMucmVnZXhwLnRvLXN0cmluZy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuc3RyaW5nLnJlcGxhY2UuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvanF1ZXJ5L3NyYy9qcXVlcnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsiS2V5cyIsIkVOVEVSIiwiVEFCIiwiQkFDS1NQQUNFIiwiVVBfQVJST1ciLCJET1dOX0FSUk9XIiwiRVNDQVBFIiwiUGVybWlzc2lvbiIsIiR3cmFwcGVyIiwia2V5IiwidXNlclNlYXJjaFVybCIsImdyb3VwU2VhcmNoVXJsIiwicGVybWlzc2lvbiIsInR5cGUiLCJ2Z3JvdXBBbGwiLCJxdWVyeSIsInN1Z2dlc3Rpb24iLCJwbGFjZWhvbGRlciIsIlhFIiwiTGFuZyIsInRyYW5zIiwic2VsZWN0ZWRJbmRleCIsImluY2x1ZGVTZWxlY3RlZEluZGV4IiwiZXhjbHVkZVNlbGVjdGVkSW5kZXgiLCJNSU5fUVVFUllfTEVOR1RIIiwiX3RoaXMiLCJvbiIsImUiLCIkdGFyZ2V0IiwiJCIsInRhcmdldCIsImNoZWNrZWQiLCJpcyIsInByb3AiLCJ2YWx1ZSIsIiR0aGlzIiwia2V5Q29kZSIsIiR1bCIsInBhcmVudCIsImRhdGFJbnB1dCIsImRhdGEiLCJsZW5ndGgiLCJpbmRleCIsImZvY3VzZWRJbmRleCIsImVxIiwiYWRkQ2xhc3MiLCJzaWJsaW5ncyIsInJlbW92ZUNsYXNzIiwicHJldmVudERlZmF1bHQiLCJ0YWciLCJuYW1lIiwicFR5cGUiLCJwcmVmaXgiLCJwVHlwZXMiLCJiU2FtZVdvcmQiLCJpIiwiaWQiLCJwdXNoIiwiaWRzIiwiY2xvc2VzdCIsInZhbCIsImpvaW4iLCJhcHBlbmQiLCJkaXNwbGF5X25hbWUiLCJyZW1vdmUiLCJmb2N1cyIsImVtcHR5IiwiJHRhZyIsInJlbW92ZVRhZyIsIiRpbnB1dCIsInRlbXAiLCJodG1sIiwiaWRlbnRpZmllciIsInN1YnN0ciIsInNlYXJjaFVzZXIiLCJzZWFyY2hHcm91cCIsIml0ZW0iLCJlc2NhcGVkUmVnZXgiLCJyZXBsYWNlIiwiciIsIlJlZ0V4cCIsIml0ZW1OYW1lIiwia2V5d29yZCIsInNlYXJjaFVzZXJVcmwiLCJhamF4IiwidXJsIiwibWV0aG9kIiwiZGF0YVR5cGUiLCJjYWNoZSIsInN1Y2Nlc3MiLCJtYWtlSXQiLCJlcnJvciIsInhociIsInN0YXR1cyIsImVyciIsInNlYXJjaEdyb3VwVXJsIiwibW9kZSIsInJhdGluZyIsIm1vZGVFbmFibGUiLCJwZXJtaXNzaW9uVHlwZXMiLCJkaXNhYmxlZCIsImluY2x1ZGVHcm91cHMiLCJncm91cCIsImluY2x1ZGVVc2VycyIsInVzZXIiLCJleGNsdWRlVXNlcnMiLCJleGNlcHQiLCJwZXJtaXNzaW9uVHlwZSIsImciLCJsYWJlbCIsImluQXJyYXkiLCJhcnIiLCJ2Z3JvdXAiLCJ0aXRsZSIsImVhY2giLCJwIiwicmVuZGVyIiwiYmluZEV2ZW50cyJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7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cmUvcGVybWlzc2lvbi9wZXJtaXNzaW9uLmJ1bmRsZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vY29yZS9wZXJtaXNzaW9uL3Blcm1pc3Npb24uanNcIik7XG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNDQ3KTsiLCJpbXBvcnQgJCBmcm9tICdqcXVlcnknXG5pbXBvcnQgWEUgZnJvbSAneGUnXG5cbi8vIFRPRE86OiBtb3VzZW92ZXIsXG5cbmNvbnN0IEtleXMgPSB7XG4gIEVOVEVSOiAxMyxcbiAgVEFCOiA5LFxuICBCQUNLU1BBQ0U6IDgsXG4gIFVQX0FSUk9XOiAzOCxcbiAgRE9XTl9BUlJPVzogNDAsXG4gIEVTQ0FQRTogMjdcbn1cblxuY2xhc3MgUGVybWlzc2lvbiB7XG4gIGNvbnN0cnVjdG9yICh7ICR3cmFwcGVyLCBrZXksIHVzZXJTZWFyY2hVcmwsIGdyb3VwU2VhcmNoVXJsLCBwZXJtaXNzaW9uLCB0eXBlLCB2Z3JvdXBBbGwgfSkge1xuICAgIHRoaXMuJHdyYXBwZXIgPSAkd3JhcHBlclxuICAgIHRoaXMua2V5ID0ga2V5XG4gICAgdGhpcy51c2VyU2VhcmNoVXJsID0gdXNlclNlYXJjaFVybFxuICAgIHRoaXMuZ3JvdXBTZWFyY2hVcmwgPSBncm91cFNlYXJjaFVybFxuICAgIHRoaXMucGVybWlzc2lvbiA9IHBlcm1pc3Npb25cbiAgICB0aGlzLnR5cGUgPSB0eXBlXG4gICAgdGhpcy52Z3JvdXBBbGwgPSB2Z3JvdXBBbGxcbiAgICB0aGlzLnF1ZXJ5ID0gJydcbiAgICB0aGlzLnN1Z2dlc3Rpb24gPSBbXVxuICAgIHRoaXMucGxhY2Vob2xkZXIgPSBYRS5MYW5nLnRyYW5zKCd4ZTo6ZXhwbGFpbkluY2x1ZGVVc2VyT3JHcm91cCcpXG4gICAgdGhpcy5zZWxlY3RlZEluZGV4ID0gJydcbiAgICB0aGlzLmluY2x1ZGVTZWxlY3RlZEluZGV4ID0gLTFcbiAgICB0aGlzLmV4Y2x1ZGVTZWxlY3RlZEluZGV4ID0gLTFcbiAgICB0aGlzLk1JTl9RVUVSWV9MRU5HVEggPSAyXG4gIH1cblxuICBiaW5kRXZlbnRzICgpIHtcbiAgICB2YXIgX3RoaXMgPSB0aGlzXG5cbiAgICB0aGlzLiR3cmFwcGVyLm9uKCdjaGFuZ2UnLCAnLmNoa01vZGVBYmxlJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIHZhciAkdGFyZ2V0ID0gJChlLnRhcmdldClcbiAgICAgIHZhciBjaGVja2VkID0gJHRhcmdldC5pcygnOmNoZWNrZWQnKVxuXG4gICAgICBpZiAoY2hlY2tlZCkge1xuICAgICAgICBfdGhpcy4kd3JhcHBlci5maW5kKCdpbnB1dDpub3QoLmNoa01vZGVBYmxlKScpLnByb3AoJ2Rpc2FibGVkJywgdHJ1ZSlcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIF90aGlzLiR3cmFwcGVyLmZpbmQoJ2lucHV0Om5vdCguY2hrTW9kZUFibGUpJykucHJvcCgnZGlzYWJsZWQnLCBmYWxzZSlcbiAgICAgIH1cbiAgICB9KVxuXG4gICAgdGhpcy4kd3JhcHBlci5vbigna2V5ZG93bicsICcuaW5wdXRVc2VyR3JvdXAnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyIHF1ZXJ5ID0gZS50YXJnZXQudmFsdWUudHJpbSgpXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIga2V5Q29kZSA9IGUua2V5Q29kZVxuICAgICAgdmFyICR1bCA9ICR0aGlzLnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zIHVsJylcbiAgICAgIHZhciBkYXRhSW5wdXQgPSAkdGhpcy5kYXRhKCdpbnB1dCcpIC8vIGluY2x1ZGUsIGV4Y2x1ZGVcblxuICAgICAgaWYgKHF1ZXJ5Lmxlbmd0aCA+PSBfdGhpcy5NSU5fUVVFUllfTEVOR1RIKSB7XG4gICAgICAgIGlmICgkdWwubGVuZ3RoID4gMCkge1xuICAgICAgICAgIHZhciBpbmRleCA9IHBhcnNlSW50KCR0aGlzLmRhdGEoJ2luZGV4JyksIDEwKVxuICAgICAgICAgIHZhciBmb2N1c2VkSW5kZXggPSAwXG5cbiAgICAgICAgICBzd2l0Y2ggKGtleUNvZGUpIHtcbiAgICAgICAgICAgIGNhc2UgS2V5cy5VUF9BUlJPVyA6XG4gICAgICAgICAgICAgIGlmIChpbmRleCA9PSAwKSB7XG4gICAgICAgICAgICAgICAgZm9jdXNlZEluZGV4ID0gJHVsLmZpbmQoJ2xpJykubGVuZ3RoIC0gMVxuICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgIGZvY3VzZWRJbmRleCA9IChpbmRleCAtIDEpXG4gICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAkdGhpcy5kYXRhKCdpbmRleCcsIGZvY3VzZWRJbmRleClcbiAgICAgICAgICAgICAgJHVsLmZpbmQoJ2xpJykuZXEoZm9jdXNlZEluZGV4KS5hZGRDbGFzcygnYWN0aXZlJykuc2libGluZ3MoKS5yZW1vdmVDbGFzcygnYWN0aXZlJylcblxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgICAgY2FzZSBLZXlzLkRPV05fQVJST1cgOlxuICAgICAgICAgICAgICBpZiAoaW5kZXggPT0gJHVsLmZpbmQoJ2xpJykubGVuZ3RoIC0gMSkge1xuICAgICAgICAgICAgICAgIGZvY3VzZWRJbmRleCA9IDBcbiAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBmb2N1c2VkSW5kZXggPSBpbmRleCArIDFcbiAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICR0aGlzLmRhdGEoJ2luZGV4JywgZm9jdXNlZEluZGV4KVxuICAgICAgICAgICAgICAkdWwuZmluZCgnbGknKS5lcShmb2N1c2VkSW5kZXgpLmFkZENsYXNzKCdhY3RpdmUnKS5zaWJsaW5ncygpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKVxuXG4gICAgICAgICAgICAgIGJyZWFrXG4gICAgICAgICAgICBjYXNlIEtleXMuRU5URVIgOlxuICAgICAgICAgICAgY2FzZSBLZXlzLlRBQiA6XG4gICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICAgICAgICAgIGlmICgkdWwuZmluZCgnbGkuYWN0aXZlJykubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgICAgIHZhciB0YWcgPSAkdWwuZmluZCgnbGkuYWN0aXZlJykuZGF0YSgndGFnJylcbiAgICAgICAgICAgICAgICB2YXIgbmFtZSA9ICcnXG4gICAgICAgICAgICAgICAgdmFyIHBUeXBlID0gJydcbiAgICAgICAgICAgICAgICB2YXIgcHJlZml4ID0gJydcblxuICAgICAgICAgICAgICAgIC8vIHVzZXJcbiAgICAgICAgICAgICAgICBpZiAoJHVsLmRhdGEoJ3RhcmdldCcpID09ICd1c2VyJykge1xuICAgICAgICAgICAgICAgICAgLy8gaW5jbHVkZVxuICAgICAgICAgICAgICAgICAgaWYgKGRhdGFJbnB1dCA9PSAnaW5jbHVkZScpIHtcbiAgICAgICAgICAgICAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnVXNlcidcbiAgICAgICAgICAgICAgICAgICAgcFR5cGUgPSAndXNlcidcbiAgICAgICAgICAgICAgICAgICAgcHJlZml4ID0gJ0AnXG4gICAgICAgICAgICAgICAgICAgIC8vIGV4Y2x1ZGVcbiAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0V4Y2VwdCdcbiAgICAgICAgICAgICAgICAgICAgcFR5cGUgPSAnZXhjZXB0J1xuICAgICAgICAgICAgICAgICAgICBwcmVmaXggPSAnQCdcbiAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgIC8vIGdyb3VwXG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0dyb3VwJ1xuICAgICAgICAgICAgICAgICAgcFR5cGUgPSAnZ3JvdXAnXG4gICAgICAgICAgICAgICAgICBwcmVmaXggPSAnJSdcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB2YXIgcFR5cGVzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV1cbiAgICAgICAgICAgICAgICB2YXIgYlNhbWVXb3JkID0gZmFsc2VcblxuICAgICAgICAgICAgICAgIGlmIChwVHlwZXMubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgICAgICAgcFR5cGVzLmZvckVhY2goZnVuY3Rpb24gKHR5cGUsIGkpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHR5cGUuaWQgPT09IHRhZy5pZCkge1xuICAgICAgICAgICAgICAgICAgICAgIGJTYW1lV29yZCA9IHRydWVcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgfSlcblxuICAgICAgICAgICAgICAgICAgaWYgKCFiU2FtZVdvcmQpIHtcbiAgICAgICAgICAgICAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0ucHVzaCh0YWcpXG4gICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnB1c2godGFnKVxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHZhciBpZHMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5tYXAoZnVuY3Rpb24gKHRhZykge1xuICAgICAgICAgICAgICAgICAgcmV0dXJuIHRhZy5pZFxuICAgICAgICAgICAgICAgIH0pXG5cbiAgICAgICAgICAgICAgICBpZiAoIWJTYW1lV29yZCkge1xuICAgICAgICAgICAgICAgICAgJHVsLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCdbbmFtZT0nICsgbmFtZSArICddJykudmFsKGlkcy5qb2luKCkudHJpbSgpKVxuICAgICAgICAgICAgICAgICAgJHVsLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCcuJyArIHBUeXBlICsgJ1dyYXAnKVxuICAgICAgICAgICAgICAgICAgICAuYXBwZW5kKGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtwcmVmaXggKyAodGFnLmRpc3BsYXlfbmFtZSB8fCB0YWcubmFtZSl9PGEgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9XCI+eDwvYT48L3NwYW4+YClcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAkdWwucmVtb3ZlKClcbiAgICAgICAgICAgICAgICAkdGhpcy52YWwoJycpLmRhdGEoJ2luZGV4JywgLTEpLmZvY3VzKClcbiAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKVx0Ly8gcHJldmVudCB0YWJcblxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgICAgY2FzZSBLZXlzLkVTQ0FQRSA6XG4gICAgICAgICAgICAgIF90aGlzW2RhdGFJbnB1dCArICdTZWxlY3RlZEluZGV4J10gPSAwXG4gICAgICAgICAgICAgICR1bC5wYXJlbnQoKS5lbXB0eSgpXG4gICAgICAgICAgICAgICR0aGlzLmZvY3VzKClcbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIGlmIChLZXlzLkJBQ0tTUEFDRSA9PT0ga2V5Q29kZSkge1xuICAgICAgICAgIHZhciAkdGFnID0gJHRoaXMuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJy5SZWFjdFRhZ3NfX3NlbGVjdGVkIHNwYW4nKVxuICAgICAgICAgIGlmICghcXVlcnkgJiYgJHRhZy5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBfdGhpcy5yZW1vdmVUYWcoJHRhZy5lcSgkdGFnLmxlbmd0aCAtIDEpKVxuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykub24oJ21vdXNlZW50ZXInLCAnbGknLCBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIgJHVsID0gJHRoaXMuY2xvc2VzdCgndWwnKVxuXG4gICAgICAkdGhpcy5hZGRDbGFzcygnYWN0aXZlJykuc2libGluZ3MoKS5yZW1vdmVDbGFzcygnYWN0aXZlJylcbiAgICB9KVxuXG4gICAgdGhpcy4kd3JhcHBlci5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLm9uKCdjbGljaycsICdsaScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgIHZhciB0YWcgPSAkdGhpcy5kYXRhKCd0YWcnKVxuICAgICAgdmFyICR1bCA9ICR0aGlzLmNsb3Nlc3QoJ3VsJylcbiAgICAgIHZhciAkaW5wdXQgPSAkdGhpcy5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdJbnB1dCcpLmZpbmQoJ2lucHV0OnRleHQnKVxuICAgICAgdmFyIGRhdGFJbnB1dCA9ICRpbnB1dC5kYXRhKCdpbnB1dCcpXG4gICAgICB2YXIgaWQgPSB0YWcuaWRcbiAgICAgIHZhciBuYW1lID0gJydcbiAgICAgIHZhciBwVHlwZSA9ICcnXG4gICAgICB2YXIgcHJlZml4ID0gJydcblxuICAgICAgaWYgKCR1bC5kYXRhKCd0YXJnZXQnKSA9PSAndXNlcicpIHtcbiAgICAgICAgLy8gaW5jbHVkZVxuICAgICAgICBpZiAoZGF0YUlucHV0ID09ICdpbmNsdWRlJykge1xuICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ1VzZXInXG4gICAgICAgICAgcFR5cGUgPSAndXNlcidcbiAgICAgICAgICBwcmVmaXggPSAnQCdcbiAgICAgICAgICAvLyBleGNsdWRlXG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnRXhjZXB0J1xuICAgICAgICAgIHBUeXBlID0gJ2V4Y2VwdCdcbiAgICAgICAgICBwcmVmaXggPSAnQCdcbiAgICAgICAgfVxuICAgICAgICAvLyBncm91cFxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnR3JvdXAnXG4gICAgICAgIHBUeXBlID0gJ2dyb3VwJ1xuICAgICAgICBwcmVmaXggPSAnJSdcbiAgICAgIH1cblxuICAgICAgdmFyIHBUeXBlcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdXG4gICAgICB2YXIgYlNhbWVXb3JkID0gZmFsc2VcblxuICAgICAgaWYgKHBUeXBlcy5sZW5ndGggPiAwKSB7XG4gICAgICAgIHBUeXBlcy5mb3JFYWNoKGZ1bmN0aW9uICh0eXBlLCBpKSB7XG4gICAgICAgICAgaWYgKHR5cGUuaWQgPT09IHRhZy5pZCkge1xuICAgICAgICAgICAgYlNhbWVXb3JkID0gdHJ1ZVxuICAgICAgICAgIH1cbiAgICAgICAgfSlcblxuICAgICAgICBpZiAoIWJTYW1lV29yZCkge1xuICAgICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnB1c2godGFnKVxuICAgICAgICB9XG4gICAgICB9IGVsc2Uge1xuICAgICAgICBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5wdXNoKHRhZylcbiAgICAgIH1cblxuICAgICAgdmFyIGlkcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLm1hcChmdW5jdGlvbiAodGFnKSB7XG4gICAgICAgIHJldHVybiB0YWcuaWRcbiAgICAgIH0pXG5cbiAgICAgIGlmICghYlNhbWVXb3JkKSB7XG4gICAgICAgICR1bC5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnW25hbWU9JyArIG5hbWUgKyAnXScpLnZhbChpZHMuam9pbigpLnRyaW0oKSlcbiAgICAgICAgJHVsLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCcuJyArIHBUeXBlICsgJ1dyYXAnKVxuICAgICAgICAgIC5hcHBlbmQoYDxzcGFuIGNsYXNzPVwiUmVhY3RUYWdzX190YWdcIj4ke3ByZWZpeCArICh0YWcuZGlzcGxheV9uYW1lIHx8IHRhZy5uYW1lKX08YSBjbGFzcz1cIlJlYWN0VGFnc19fcmVtb3ZlIGJ0blJlbW92ZVRhZ1wiIGRhdGEtaWQ9XCIke3RhZy5pZH1cIj54PC9hPjwvc3Bhbj5gKVxuICAgICAgfVxuXG4gICAgICAkdWwucmVtb3ZlKClcbiAgICAgICRpbnB1dC52YWwoJycpLmRhdGEoJ2luZGV4JywgLTEpLmZvY3VzKClcbiAgICB9KVxuXG4gICAgdGhpcy4kd3JhcHBlci5vbigna2V5dXAnLCAnLmlucHV0VXNlckdyb3VwJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIHZhciBxdWVyeSA9IGUudGFyZ2V0LnZhbHVlLnRyaW0oKVxuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyIGtleUNvZGUgPSBlLmtleUNvZGVcblxuICAgICAgaWYgKHF1ZXJ5Lmxlbmd0aCA+PSBfdGhpcy5NSU5fUVVFUllfTEVOR1RIKSB7XG4gICAgICAgIGlmIChbS2V5cy5FTlRFUiwgS2V5cy5UQUIsIEtleXMuVVBfQVJST1csIEtleXMuRE9XTl9BUlJPVywgS2V5cy5FU0NBUEUsIDM3LCAzOV0uaW5kZXhPZihrZXlDb2RlKSA9PSAtMSkge1xuICAgICAgICAgIHZhciB0ZW1wID0gJydcbiAgICAgICAgICB0ZW1wICs9IFx0YDx1bD5gXG4gICAgICAgICAgdGVtcCArPVx0XHRcdGA8bGk+U2VhcmNoaW5nIC4uLiA8c3BhbiBjbGFzcz1cInNwaW5uZXJcIiByb2xlPVwic3Bpbm5lclwiPjxzcGFuIGNsYXNzPVwic3Bpbm5lci1pY29uXCI+PC9zcGFuPjwvc3Bhbj48L2xpPmBcbiAgICAgICAgICB0ZW1wICs9IFx0YDwvdWw+YFxuXG4gICAgICAgICAgJHRoaXMucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5odG1sKHRlbXApXG5cbiAgICAgICAgICB2YXIgaWRlbnRpZmllciA9IHF1ZXJ5LnN1YnN0cigwLCAxKVxuICAgICAgICAgIHN3aXRjaCAoaWRlbnRpZmllcikge1xuICAgICAgICAgICAgY2FzZSAnQCc6XG4gICAgICAgICAgICAgIHF1ZXJ5ID0gcXVlcnkuc3Vic3RyKDEsIHF1ZXJ5Lmxlbmd0aClcbiAgICAgICAgICAgICAgX3RoaXMuc2VhcmNoVXNlcigkdGhpcywgcXVlcnkpXG4gICAgICAgICAgICAgIGJyZWFrXG5cbiAgICAgICAgICAgIGNhc2UgJyUnOlxuICAgICAgICAgICAgICBxdWVyeSA9IHF1ZXJ5LnN1YnN0cigxLCBxdWVyeS5sZW5ndGgpXG4gICAgICAgICAgICAgIF90aGlzLnNlYXJjaEdyb3VwKCR0aGlzLCBxdWVyeSlcbiAgICAgICAgICAgICAgYnJlYWtcblxuICAgICAgICAgICAgZGVmYXVsdCA6XG4gICAgICAgICAgICAgIGJyZWFrXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9IGVsc2Uge1xuICAgICAgICAkdGhpcy5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmVtcHR5KClcbiAgICAgIH1cbiAgICB9KVxuXG4gICAgdGhpcy4kd3JhcHBlci5vbignY2xpY2snLCAnLmJ0blJlbW92ZVRhZycsIGZ1bmN0aW9uIChlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KClcblxuICAgICAgX3RoaXMucmVtb3ZlVGFnKCQodGhpcykuY2xvc2VzdCgnc3BhbicpKVxuICAgIH0pXG4gIH1cblxuICBtYWtlSXQgKGl0ZW0sIHF1ZXJ5KSB7XG4gICAgdmFyIGVzY2FwZWRSZWdleCA9IHF1ZXJ5LnRyaW0oKS5yZXBsYWNlKC9bLVxcXFxeJCorPy4oKXxbXFxde31dL2csICdcXFxcJCYnKVxuICAgIHZhciByID0gUmVnRXhwKGVzY2FwZWRSZWdleCwgJ2dpJylcbiAgICB2YXIgaXRlbU5hbWUgPSBpdGVtLmRpc3BsYXlfbmFtZSB8fCBpdGVtLm5hbWVcblxuICAgIHJldHVybiBpdGVtTmFtZS5yZXBsYWNlKHIsICc8bWFyaz4kJjwvbWFyaz4nKVxuICB9XG5cbiAgcmVtb3ZlVGFnICgkdGFyZ2V0KSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHZhciBwVHlwZSA9ICR0YXJnZXQuY2xvc2VzdCgnLlJlYWN0VGFnc19fc2VsZWN0ZWQnKS5kYXRhKCdwdHlwZScpXG4gICAgdmFyIGlkID0gJHRhcmdldC5kYXRhKCdpZCcpXG4gICAgdmFyIG5hbWUgPSAnJ1xuXG4gICAgc3dpdGNoIChwVHlwZSkge1xuICAgICAgY2FzZSAndXNlcicgOlxuICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdVc2VyJ1xuICAgICAgICBicmVha1xuICAgICAgY2FzZSAnZXhjZXB0JyA6XG4gICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0V4Y2VwdCdcbiAgICAgICAgYnJlYWtcbiAgICAgIGNhc2UgJ2dyb3VwJyA6XG4gICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0dyb3VwJ1xuICAgICAgICBicmVha1xuICAgIH1cblxuICAgIHZhciBwVHlwZXMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXVxuXG4gICAgcFR5cGVzLmZvckVhY2goZnVuY3Rpb24gKHR5cGUsIGkpIHtcbiAgICAgIGlmICh0eXBlLmlkICE9PSBpZCkge1xuICAgICAgICBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5zcGxpY2UoaSwgMSkvLyAucHVzaCh0YWcpO1xuICAgICAgfVxuICAgIH0pXG5cbiAgICB2YXIgaWRzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV0ubWFwKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgIHJldHVybiB0YWcuaWRcbiAgICB9KVxuXG4gICAgJHRhcmdldC5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnW25hbWU9JyArIG5hbWUgKyAnXScpLnZhbChpZHMuam9pbigpLnRyaW0oKSlcbiAgICAkdGFyZ2V0LnJlbW92ZSgpXG4gIH1cblxuICBzZWFyY2hVc2VyICgkaW5wdXQsIGtleXdvcmQpIHtcbiAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgdmFyIHNlYXJjaFVzZXJVcmwgPSBfdGhpcy51c2VyU2VhcmNoVXJsXG5cbiAgICBYRS5hamF4KHtcbiAgICAgIHVybDogc2VhcmNoVXNlclVybCArICcvJyArIGtleXdvcmQsXG4gICAgICBtZXRob2Q6ICdnZXQnLFxuICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgIGNhY2hlOiBmYWxzZSxcbiAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgIGlmIChkYXRhLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICB2YXIgdGVtcCA9ICcnXG4gICAgICAgICAgdGVtcCArPSBcdGA8dWwgZGF0YS10YXJnZXQ9XCJ1c2VyXCI+YFxuXG4gICAgICAgICAgZGF0YS5mb3JFYWNoKGZ1bmN0aW9uIChpdGVtLCBpKSB7XG4gICAgICAgICAgICB0ZW1wICs9IFx0XHRgPGxpIGNsYXNzPVwiXCIgZGF0YS10YWc9JyR7SlNPTi5zdHJpbmdpZnkoaXRlbSl9Jz5gXG4gICAgICAgICAgICB0ZW1wICs9IFx0XHRcdGA8c3Bhbj4ke190aGlzLm1ha2VJdChpdGVtLCBrZXl3b3JkKX08L3NwYW4+YFxuICAgICAgICAgICAgdGVtcCArPSBcdFx0YDwvbGk+YFxuICAgICAgICAgIH0pXG5cbiAgICAgICAgICB0ZW1wICs9IFx0YDwvdWw+YFxuXG4gICAgICAgICAgJGlucHV0LnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuaHRtbCh0ZW1wKVxuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICRpbnB1dC5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmVtcHR5KClcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICAgIGVycm9yOiBmdW5jdGlvbiAoeGhyLCBzdGF0dXMsIGVycikge1xuXG4gICAgICB9XG4gICAgfSlcbiAgfVxuXG4gIHNlYXJjaEdyb3VwICgkaW5wdXQsIGtleXdvcmQpIHtcbiAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgdmFyIHNlYXJjaEdyb3VwVXJsID0gX3RoaXMuZ3JvdXBTZWFyY2hVcmxcblxuICAgIFhFLmFqYXgoe1xuICAgICAgdXJsOiBzZWFyY2hHcm91cFVybCArICcvJyArIGtleXdvcmQsXG4gICAgICBtZXRob2Q6ICdnZXQnLFxuICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgIGNhY2hlOiBmYWxzZSxcbiAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgIC8vIFRPRE86OiB2aWV3IHJlbmRlcmluXG4gICAgICAgIGlmIChkYXRhLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICB2YXIgdGVtcCA9ICcnXG4gICAgICAgICAgdGVtcCArPSBcdGA8dWwgZGF0YS10YXJnZXQ9XCJncm91cFwiPmBcblxuICAgICAgICAgIGRhdGEuZm9yRWFjaChmdW5jdGlvbiAoaXRlbSwgaSkge1xuICAgICAgICAgICAgdGVtcCArPSBcdFx0YDxsaSBkYXRhLXRhZz0nJHtKU09OLnN0cmluZ2lmeShpdGVtKX0nPmBcbiAgICAgICAgICAgIHRlbXAgKz0gXHRcdFx0YDxzcGFuPiR7X3RoaXMubWFrZUl0KGl0ZW0sIGtleXdvcmQpfTwvc3Bhbj5gXG4gICAgICAgICAgICB0ZW1wICs9IFx0XHRgPC9saT5gXG4gICAgICAgICAgfSlcblxuICAgICAgICAgIHRlbXAgKz0gXHRgPC91bD5gXG5cbiAgICAgICAgICAkaW5wdXQucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5odG1sKHRlbXApXG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgJGlucHV0LnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuZW1wdHkoKVxuICAgICAgICB9XG4gICAgICB9LFxuICAgICAgZXJyb3I6IGZ1bmN0aW9uICh4aHIsIHN0YXR1cywgZXJyKSB7fVxuICAgIH0pXG4gIH1cblxuICByZW5kZXIgKCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICB2YXIgbW9kZSA9IHRoaXMucGVybWlzc2lvbi5tb2RlXG4gICAgdmFyIHJhdGluZyA9IHRoaXMucGVybWlzc2lvbi5yYXRpbmdcbiAgICB2YXIgbW9kZUVuYWJsZSA9IGZhbHNlXG4gICAgdmFyIHBlcm1pc3Npb25UeXBlcyA9IFtcbiAgICAgIHsgdmFsdWU6ICdzdXBlcicsIG5hbWU6IFhFLkxhbmcudHJhbnMoJ3hlOjp1c2VyUmF0aW5nQWRtaW5pc3RyYXRvcicpIH0sXG4gICAgICB7IHZhbHVlOiAnbWFuYWdlcicsIG5hbWU6IFhFLkxhbmcudHJhbnMoJ3hlOjp1c2VyUmF0aW5nTWFuYWdlcicpIH0sXG4gICAgICB7IHZhbHVlOiAndXNlcicsIG5hbWU6IFhFLkxhbmcudHJhbnMoJ3hlOjp1c2VyJykgfSxcbiAgICAgIHsgdmFsdWU6ICdndWVzdCcsIG5hbWU6IFhFLkxhbmcudHJhbnMoJ3hlOjpndWVzdCcpIH1cbiAgICBdXG5cbiAgICB2YXIgZGlzYWJsZWQgPSBmYWxzZVxuXG4gICAgaWYgKG1vZGUgPT09ICdtYW51YWwnIHx8IG1vZGUgPT09ICdpbmhlcml0Jykge1xuICAgICAgbW9kZUVuYWJsZSA9IHRydWVcbiAgICAgIGlmIChtb2RlICE9PSAnbWFudWFsJykge1xuICAgICAgICBkaXNhYmxlZCA9IHRydWVcbiAgICAgIH1cbiAgICB9XG5cbiAgICB2YXIgaW5jbHVkZUdyb3VwcyA9IHRoaXMucGVybWlzc2lvbi5ncm91cC5tYXAoZnVuY3Rpb24gKGdyb3VwKSB7XG4gICAgICByZXR1cm4gZ3JvdXAuaWRcbiAgICB9KVxuXG4gICAgdmFyIGluY2x1ZGVVc2VycyA9IHRoaXMucGVybWlzc2lvbi51c2VyLm1hcChmdW5jdGlvbiAodXNlcikge1xuICAgICAgcmV0dXJuIHVzZXIuaWRcbiAgICB9KVxuXG4gICAgdmFyIGV4Y2x1ZGVVc2VycyA9IHRoaXMucGVybWlzc2lvbi5leGNlcHQubWFwKGZ1bmN0aW9uICh1c2VyKSB7XG4gICAgICByZXR1cm4gdXNlci5pZFxuICAgIH0pXG5cbiAgICB2YXIgdGVtcCA9ICcnXG4gICAgdGVtcCArPSBgPGRpdj5gXG5cbiAgICBpZiAobW9kZUVuYWJsZSkge1xuICAgICAgdmFyIGNoZWNrZWQgPSAobW9kZSA9PT0gJ2luaGVyaXQnKSA/ICdjaGVja2VkPVwiY2hlY2tlZFwiJyA6ICcnXG5cbiAgICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+YFxuICAgICAgdGVtcCArPSBcdGA8ZGl2IGNsYXNzPVwiY2hlY2tib3hcIj5gXG4gICAgICB0ZW1wICs9XHRcdFx0YDxsYWJlbD48aW5wdXQgdHlwZT1cImNoZWNrYm94XCIgbmFtZT1cIiR7dGhpcy50eXBlICsgJ01vZGUnfVwiIGNsYXNzPVwiY2hrTW9kZUFibGVcIiB2YWx1ZT1cImluaGVyaXRcIiAke2NoZWNrZWR9IC8+ICR7WEUuTGFuZy50cmFucygneGU6OmluaGVyaXRNb2RlJyl9PC9sYWJlbD5gXG4gICAgICB0ZW1wICs9IFx0YDwvZGl2PmBcbiAgICAgIHRlbXAgKz0gYDwvZGl2PmBcbiAgICB9XG5cbiAgICB0ZW1wICs9IFx0YDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+YFxuICAgIHRlbXAgKz1cdFx0XHRgPGxhYmVsPu2ajOybkCDrk7HquIk8L2xhYmVsPmBcbiAgICB0ZW1wICs9IFx0XHQnPGRpdiBjbGFzcz1cInJhZGlvXCI+J1xuICAgIHBlcm1pc3Npb25UeXBlcy5mb3JFYWNoKGZ1bmN0aW9uIChwZXJtaXNzaW9uVHlwZSkge1xuICAgICAgdmFyIGNoZWNrZWQgPSAocGVybWlzc2lvblR5cGUudmFsdWUgPT0gcmF0aW5nKSA/ICdjaGVja2VkJyA6ICcnXG5cbiAgICAgIHRlbXAgKz0gYDxsYWJlbD48aW5wdXQgdHlwZT1cInJhZGlvXCIgJHsoZGlzYWJsZWQpID8gJ2Rpc2FibGVkPVwiZGlzYWJsZWRcIicgOiAnJ30gbmFtZT1cIiR7X3RoaXMudHlwZSArICdSYXRpbmcnfVwiIHZhbHVlPVwiJHtwZXJtaXNzaW9uVHlwZS52YWx1ZX1cIiAkeyhjaGVja2VkKSA/ICdjaGVja2VkPVwiY2hlY2tlZFwiJyA6ICcnfSAvPiAke3Blcm1pc3Npb25UeXBlLm5hbWV9ICZuYnNwOzwvbGFiZWw+YFxuICAgIH0pXG4gICAgdGVtcCArPVx0XHRcdGA8L2Rpdj5gXG4gICAgdGVtcCArPVx0XHRgPC9kaXY+YFxuICAgIHRlbXAgKz0gXHRgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgdGVtcCArPVx0XHRcdGA8bGFiZWw+JHtYRS5MYW5nLnRyYW5zKCd4ZTo6aW5jbHVkZVVzZXJPckdyb3VwJyl9PC9sYWJlbD5gXG4gICAgdGVtcCArPVx0XHRcdGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX190YWdzXCI+YFxuXG4gICAgdGVtcCArPSBcdFx0XHRgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc2VsZWN0ZWQgZ3JvdXBXcmFwXCIgZGF0YS1wdHlwZT1cImdyb3VwXCI+YFxuICAgIHRoaXMucGVybWlzc2lvbi5ncm91cC5mb3JFYWNoKGZ1bmN0aW9uIChnKSB7XG4gICAgICB2YXIgdGFnID0gZ1xuICAgICAgdmFyIGxhYmVsID0gJyUnICsgKHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWUpXG5cbiAgICAgIHRlbXAgKz0gXHRcdFx0YDxzcGFuIGNsYXNzPVwiUmVhY3RUYWdzX190YWdcIj4ke2xhYmVsfTxhIGhyZWY9XCIjXCIgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9XCI+eDwvYT48L3NwYW4+YFxuICAgIH0pXG4gICAgdGVtcCArPVx0XHRcdFx0JzwvZGl2PidcblxuICAgIHRlbXAgKz1cdFx0XHRcdCc8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX19zZWxlY3RlZCB1c2VyV3JhcFwiIGRhdGEtcHR5cGU9XCJ1c2VyXCI+J1xuICAgIHRoaXMucGVybWlzc2lvbi51c2VyLmZvckVhY2goZnVuY3Rpb24gKHRhZykge1xuICAgICAgdmFyIGxhYmVsID0gJ0AnICsgKHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWUpXG5cbiAgICAgIHRlbXAgKz0gXHRcdFx0YDxzcGFuIGNsYXNzPVwiUmVhY3RUYWdzX190YWdcIj4ke2xhYmVsfTxhIGhyZWY9XCIjXCIgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9fFwiPng8L2E+PC9zcGFuPmBcbiAgICB9KVxuICAgIHRlbXAgKz1cdFx0XHRcdGA8L2Rpdj5gXG5cbiAgICB0ZW1wICs9XHRcdFx0XHRgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnSW5wdXRcIj5gXG4gICAgdGVtcCArPSBcdFx0XHRcdGA8aW5wdXQgdHlwZT1cInRleHRcIiBwbGFjZWhvbGRlcj1cIiR7dGhpcy5wbGFjZWhvbGRlcn1cIiBjbGFzcz1cImZvcm0tY29udHJvbCBpbnB1dFVzZXJHcm91cFwiIGRhdGEtaW5wdXQ9XCJpbmNsdWRlXCIgJHsoZGlzYWJsZWQpID8gJ2Rpc2FibGVkPVwiZGlzYWJsZWRcIicgOiAnJ30gdmFsdWU9XCIke3RoaXMucXVlcnl9XCIgZGF0YS1pbmRleD1cIi0xXCIgLz5gXHQvLyBUT0RPOjogUGVybWlzc2lvbkluY2x1ZGUgaGFuZGxlS2V5RG93blxuICAgIHRlbXAgKz0gXHRcdFx0XHRgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc3VnZ2VzdGlvbnNcIiBkYXRhLWlucHV0PVwiaW5jbHVkZVwiPjwvZGl2PmBcbiAgICB0ZW1wICs9XHRcdFx0XHRgPC9kaXY+YCAvLyBSZWFjdFRhZ3NfX3RhZ0lucHV0XG4gICAgdGVtcCArPSBcdFx0XHRgPGlucHV0IHR5cGU9XCJoaWRkZW5cIiBuYW1lPVwiJHt0aGlzLnR5cGUgKyAnR3JvdXAnfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGluY2x1ZGVHcm91cHNcIiB2YWx1ZT1cIiR7aW5jbHVkZUdyb3Vwcy5qb2luKCkudHJpbSgpfVwiIC8+YFxuICAgIHRlbXAgKz1cdFx0XHRcdGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3RoaXMudHlwZSArICdVc2VyJ31cIiBjbGFzcz1cImZvcm0tY29udHJvbCBpbmNsdWRlVXNlcnNcIiB2YWx1ZT1cIiR7aW5jbHVkZVVzZXJzLmpvaW4oKS50cmltKCl9XCIgLz5gXG4gICAgdGVtcCArPVx0XHRcdGA8L2Rpdj5gXHQvLyBSZWFjdFRhZ3NfX3RhZ3NcbiAgICB0ZW1wICs9XHRcdGA8L2Rpdj5gLy8gZm9ybS1ncm91cFxuXG4gICAgaWYgKHRoaXMudmdyb3VwQWxsLmxlbmd0aCA+PSAxKSB7XG4gICAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiPmBcbiAgICAgIHRlbXAgKz0gXHRgPGxhYmVsPiR7WEUuTGFuZy50cmFucygneGU6OmluY2x1ZGVWR3JvdXAnKX08L2xhYmVsPmBcblxuICAgICAgdGVtcCArPSBfdGhpcy52Z3JvdXBBbGwubWFwKGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgIHZhciBjaGVja2VkID0gZmFsc2VcblxuICAgICAgICB2YXIgaW5BcnJheSA9IGZ1bmN0aW9uICh2YWwsIGFycikge1xuICAgICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgYXJyLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICBpZiAoYXJyW2ldID09IHZhbCkge1xuICAgICAgICAgICAgICByZXR1cm4gaVxuICAgICAgICAgICAgfVxuICAgICAgICAgIH1cblxuICAgICAgICAgIHJldHVybiAtMVxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKGluQXJyYXkoZGF0YS5pZCwgdGhpcy5wZXJtaXNzaW9uLnZncm91cCkgIT0gLTEpIHtcbiAgICAgICAgICBjaGVja2VkID0gdHJ1ZVxuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIGA8bGFiZWw+PGlucHV0IHR5cGU9XCJjaGVja2JveFwiICR7KGRpc2FibGVkKSA/ICdkaXNhYmxlZD1cImRpc2FibGVkXCInIDogJyd9IG5hbWU9XCIke190aGlzLnR5cGUgKyAnVkdyb3VwW10nfVwiIHZhbHVlPVwiJHtkYXRhLmlkfVwiICR7KGNoZWNrZWQpID8gJ2NoZWNrZWQ9XCJjaGVja2VkXCInIDogJyd9IC8+ICR7ZGF0YS50aXRsZX0gJm5ic3A7PC9sYWJlbD5gXG4gICAgICB9KVxuXG4gICAgICB0ZW1wICs9ICc8L2Rpdj4nXG4gICAgfVxuXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgdGVtcCArPSBcdGA8bGFiZWw+JHtYRS5MYW5nLnRyYW5zKCd4ZTo6ZXhjbHVkZVVzZXInKX08L2xhYmVsPmBcbiAgICB0ZW1wICs9XHRcdGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX190YWdzXCI+YFxuICAgIHRlbXAgKz1cdFx0XHRgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc2VsZWN0ZWQgZXhjZXB0V3JhcFwiIGRhdGEtcHR5cGU9XCJleGNlcHRcIj5gXG5cbiAgICB0aGlzLnBlcm1pc3Npb24uZXhjZXB0LmZvckVhY2goZnVuY3Rpb24gKHRhZykge1xuICAgICAgdmFyIGxhYmVsID0gdGFnLmRpc3BsYXlfbmFtZSB8fCB0YWcubmFtZVxuICAgICAgbGFiZWwgPSAnQCcgKyBsYWJlbFxuXG4gICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtsYWJlbH08YSBocmVmPVwiI1wiIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfVwiPng8L2E+PC9zcGFuPmBcbiAgICB9KVxuXG4gICAgdGVtcCArPVx0XHRcdGA8L2Rpdj5gXG4gICAgdGVtcCArPSBcdFx0YDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ0lucHV0XCI+YFxuICAgIHRlbXAgKz1cdFx0XHRcdGA8aW5wdXQgdHlwZT1cInRleHRcIiBwbGFjZWhvbGRlcj1cIiR7WEUuTGFuZy50cmFucygneGU6OmV4cGxhaW5FeGNsdWRlVXNlcicpfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGlucHV0VXNlckdyb3VwXCIgZGF0YS1pbnB1dD1cImV4Y2x1ZGVcIiAkeyhkaXNhYmxlZCkgPyAnZGlzYWJsZWQ9XCJkaXNhYmxlZFwiJyA6ICcnfSBkYXRhLWluZGV4PVwiLTFcIiAvPmAgXHQvLyBUT0RPOjogUGVybWlzc2lvbkV4Y2x1ZGUgaGFuZGxlS2V5RG93blxuICAgIHRlbXAgKz0gXHRcdFx0YDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zXCIgZGF0YS1pbnB1dD1cImV4Y2x1ZGVcIj48L2Rpdj5gXG4gICAgdGVtcCArPSBcdFx0YDwvZGl2PmAgLy8gUmVhY3RUYWdzX190YWdJbnB1dFxuICAgIHRlbXAgKz1cdFx0YDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cIiR7dGhpcy50eXBlICsgJ0V4Y2VwdCd9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgZXhjbHVkZVVzZXJzXCIgdmFsdWU9XCIke2V4Y2x1ZGVVc2Vyc31cIiAvPmBcbiAgICB0ZW1wICs9XHRcdGA8L2Rpdj5gIC8vIFJlYWN0VGFnc19fdGFnc1xuICAgIHRlbXAgKz0gYDwvZGl2PmAvLyBmb3JtLWdyb3VwXG5cbiAgICB0ZW1wICs9IGA8L2Rpdj5gXG5cbiAgICB0aGlzLiR3cmFwcGVyLmh0bWwodGVtcClcbiAgfVxufVxuXG4kKCcuX194ZV9fdWlvYmplY3RfcGVybWlzc2lvbicpLmVhY2goZnVuY3Rpb24gKGkpIHtcbiAgdmFyICR0aGlzID0gJCh0aGlzKVxuICB2YXIgcGVybWlzc2lvbiA9ICR0aGlzLmRhdGEoJ2RhdGEnKVxuXG4gIHZhciBrZXkgPSAkdGhpcy5kYXRhKCdrZXknKVxuICB2YXIgdHlwZSA9ICR0aGlzLmRhdGEoJ3R5cGUnKVxuICB2YXIgdXNlclNlYXJjaFVybCA9ICR0aGlzLmRhdGEoJ3VzZXJVcmwnKVxuICB2YXIgZ3JvdXBTZWFyY2hVcmwgPSAkdGhpcy5kYXRhKCdncm91cFVybCcpXG4gIHZhciB2Z3JvdXBBbGwgPSAkdGhpcy5kYXRhKCd2Z3JvdXBBbGwnKVxuXG4gIHZhciBwID0gbmV3IFBlcm1pc3Npb24oeyAkd3JhcHBlcjogJHRoaXMsIGtleSwgdXNlclNlYXJjaFVybCwgZ3JvdXBTZWFyY2hVcmwsIHBlcm1pc3Npb24sIHR5cGUsIHZncm91cEFsbCB9KVxuICBwLnJlbmRlcigpXG4gIHAuYmluZEV2ZW50cygpXG59KVxuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE0NSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE5KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNDA4KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNzQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNDMpOyIsIm1vZHVsZS5leHBvcnRzID0gcmVxdWlyZShcImNvcmUtanMtcHVyZS9zdGFibGUvanNvbi9zdHJpbmdpZnlcIik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDUpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgzKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoOSk7IiwicmVxdWlyZSgnLi4vLi4vbW9kdWxlcy9lcy5qc29uLnN0cmluZ2lmeScpO1xudmFyIGNvcmUgPSByZXF1aXJlKCcuLi8uLi9pbnRlcm5hbHMvcGF0aCcpO1xuXG5pZiAoIWNvcmUuSlNPTikgY29yZS5KU09OID0geyBzdHJpbmdpZnk6IEpTT04uc3RyaW5naWZ5IH07XG5cbi8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBuby11bnVzZWQtdmFyc1xubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiBzdHJpbmdpZnkoaXQsIHJlcGxhY2VyLCBzcGFjZSkge1xuICByZXR1cm4gY29yZS5KU09OLnN0cmluZ2lmeS5hcHBseShudWxsLCBhcmd1bWVudHMpO1xufTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg4KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjUpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2Myk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE4KTsiLCJ2YXIgJCA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9leHBvcnQnKTtcbnZhciBnZXRCdWlsdEluID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2dldC1idWlsdC1pbicpO1xudmFyIGZhaWxzID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2ZhaWxzJyk7XG5cbnZhciAkc3RyaW5naWZ5ID0gZ2V0QnVpbHRJbignSlNPTicsICdzdHJpbmdpZnknKTtcbnZhciByZSA9IC9bXFx1RDgwMC1cXHVERkZGXS9nO1xudmFyIGxvdyA9IC9eW1xcdUQ4MDAtXFx1REJGRl0kLztcbnZhciBoaSA9IC9eW1xcdURDMDAtXFx1REZGRl0kLztcblxudmFyIGZpeCA9IGZ1bmN0aW9uIChtYXRjaCwgb2Zmc2V0LCBzdHJpbmcpIHtcbiAgdmFyIHByZXYgPSBzdHJpbmcuY2hhckF0KG9mZnNldCAtIDEpO1xuICB2YXIgbmV4dCA9IHN0cmluZy5jaGFyQXQob2Zmc2V0ICsgMSk7XG4gIGlmICgobG93LnRlc3QobWF0Y2gpICYmICFoaS50ZXN0KG5leHQpKSB8fCAoaGkudGVzdChtYXRjaCkgJiYgIWxvdy50ZXN0KHByZXYpKSkge1xuICAgIHJldHVybiAnXFxcXHUnICsgbWF0Y2guY2hhckNvZGVBdCgwKS50b1N0cmluZygxNik7XG4gIH0gcmV0dXJuIG1hdGNoO1xufTtcblxudmFyIEZPUkNFRCA9IGZhaWxzKGZ1bmN0aW9uICgpIHtcbiAgcmV0dXJuICRzdHJpbmdpZnkoJ1xcdURGMDZcXHVEODM0JykgIT09ICdcIlxcXFx1ZGYwNlxcXFx1ZDgzNFwiJ1xuICAgIHx8ICRzdHJpbmdpZnkoJ1xcdURFQUQnKSAhPT0gJ1wiXFxcXHVkZWFkXCInO1xufSk7XG5cbmlmICgkc3RyaW5naWZ5KSB7XG4gIC8vIGh0dHBzOi8vZ2l0aHViLmNvbS90YzM5L3Byb3Bvc2FsLXdlbGwtZm9ybWVkLXN0cmluZ2lmeVxuICAkKHsgdGFyZ2V0OiAnSlNPTicsIHN0YXQ6IHRydWUsIGZvcmNlZDogRk9SQ0VEIH0sIHtcbiAgICAvLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgbm8tdW51c2VkLXZhcnNcbiAgICBzdHJpbmdpZnk6IGZ1bmN0aW9uIHN0cmluZ2lmeShpdCwgcmVwbGFjZXIsIHNwYWNlKSB7XG4gICAgICB2YXIgcmVzdWx0ID0gJHN0cmluZ2lmeS5hcHBseShudWxsLCBhcmd1bWVudHMpO1xuICAgICAgcmV0dXJuIHR5cGVvZiByZXN1bHQgPT0gJ3N0cmluZycgPyByZXN1bHQucmVwbGFjZShyZSwgZml4KSA6IHJlc3VsdDtcbiAgICB9XG4gIH0pO1xufVxuIiwidmFyIHBhcmVudCA9IHJlcXVpcmUoJy4uLy4uL2VzL2pzb24vc3RyaW5naWZ5Jyk7XG5cbm1vZHVsZS5leHBvcnRzID0gcGFyZW50O1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE0MSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDczKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjY5KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMzgpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNzApOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg4MCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDApOyIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==