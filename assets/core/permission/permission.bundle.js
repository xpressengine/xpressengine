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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(429);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(140);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(3);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(15);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js from dll-reference _xe_dll_common ***!
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(389);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(71);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(138);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(6);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(4);

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

var core = __webpack_require__(/*! ../../internals/path */ "./node_modules/core-js-pure/internals/path.js");
var $JSON = core.JSON || (core.JSON = { stringify: JSON.stringify });

module.exports = function stringify(it) { // eslint-disable-line no-unused-vars
  return $JSON.stringify.apply($JSON, arguments);
};


/***/ }),

/***/ "./node_modules/core-js-pure/internals/path.js":
/*!*************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/path.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(16);

/***/ }),

/***/ "./node_modules/core-js-pure/stable/json/stringify.js":
/*!************************************************************!*\
  !*** ./node_modules/core-js-pure/stable/json/stringify.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ../../es/json/stringify */ "./node_modules/core-js-pure/es/json/stringify.js");


/***/ }),

/***/ "./node_modules/core-js/modules/es.array.join.js":
/*!***************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.array.join.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(135);

/***/ }),

/***/ "./node_modules/core-js/modules/es.function.name.js":
/*!******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.function.name.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(70);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.constructor.js":
/*!***********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.constructor.js from dll-reference _xe_dll_common ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(261);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.exec.js":
/*!****************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.exec.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(41);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(77);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL2NvcmUvcGVybWlzc2lvbi9wZXJtaXNzaW9uLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9jb25jYXQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9maW5kLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvZm9yLWVhY2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9pbmRleC1vZi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL21hcC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL3NwbGljZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL3RyaW0uanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9wYXJzZS1pbnQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NsYXNzQ2FsbENoZWNrLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jcmVhdGVDbGFzcy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9lcy9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9pbnRlcm5hbHMvcGF0aC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9zdGFibGUvanNvbi9zdHJpbmdpZnkuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuYXJyYXkuam9pbi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuZnVuY3Rpb24ubmFtZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMucmVnZXhwLmNvbnN0cnVjdG9yLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5yZWdleHAuZXhlYy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMucmVnZXhwLnRvLXN0cmluZy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuc3RyaW5nLnJlcGxhY2UuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvanF1ZXJ5L3NyYy9qcXVlcnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsiS2V5cyIsIkVOVEVSIiwiVEFCIiwiQkFDS1NQQUNFIiwiVVBfQVJST1ciLCJET1dOX0FSUk9XIiwiRVNDQVBFIiwiUGVybWlzc2lvbiIsIiR3cmFwcGVyIiwia2V5IiwidXNlclNlYXJjaFVybCIsImdyb3VwU2VhcmNoVXJsIiwicGVybWlzc2lvbiIsInR5cGUiLCJ2Z3JvdXBBbGwiLCJxdWVyeSIsInN1Z2dlc3Rpb24iLCJwbGFjZWhvbGRlciIsIlhFIiwiTGFuZyIsInRyYW5zIiwic2VsZWN0ZWRJbmRleCIsImluY2x1ZGVTZWxlY3RlZEluZGV4IiwiZXhjbHVkZVNlbGVjdGVkSW5kZXgiLCJNSU5fUVVFUllfTEVOR1RIIiwiX3RoaXMiLCJvbiIsImUiLCIkdGFyZ2V0IiwiJCIsInRhcmdldCIsImNoZWNrZWQiLCJpcyIsInByb3AiLCJ2YWx1ZSIsIiR0aGlzIiwia2V5Q29kZSIsIiR1bCIsInBhcmVudCIsImRhdGFJbnB1dCIsImRhdGEiLCJsZW5ndGgiLCJpbmRleCIsImZvY3VzZWRJbmRleCIsImVxIiwiYWRkQ2xhc3MiLCJzaWJsaW5ncyIsInJlbW92ZUNsYXNzIiwicHJldmVudERlZmF1bHQiLCJ0YWciLCJuYW1lIiwicFR5cGUiLCJwcmVmaXgiLCJwVHlwZXMiLCJiU2FtZVdvcmQiLCJpIiwiaWQiLCJwdXNoIiwiaWRzIiwiY2xvc2VzdCIsInZhbCIsImpvaW4iLCJhcHBlbmQiLCJkaXNwbGF5X25hbWUiLCJyZW1vdmUiLCJmb2N1cyIsImVtcHR5IiwiJHRhZyIsInJlbW92ZVRhZyIsIiRpbnB1dCIsInRlbXAiLCJodG1sIiwiaWRlbnRpZmllciIsInN1YnN0ciIsInNlYXJjaFVzZXIiLCJzZWFyY2hHcm91cCIsIml0ZW0iLCJlc2NhcGVkUmVnZXgiLCJyZXBsYWNlIiwiciIsIlJlZ0V4cCIsIml0ZW1OYW1lIiwia2V5d29yZCIsInNlYXJjaFVzZXJVcmwiLCJhamF4IiwidXJsIiwibWV0aG9kIiwiZGF0YVR5cGUiLCJjYWNoZSIsInN1Y2Nlc3MiLCJtYWtlSXQiLCJlcnJvciIsInhociIsInN0YXR1cyIsImVyciIsInNlYXJjaEdyb3VwVXJsIiwibW9kZSIsInJhdGluZyIsIm1vZGVFbmFibGUiLCJwZXJtaXNzaW9uVHlwZXMiLCJkaXNhYmxlZCIsImluY2x1ZGVHcm91cHMiLCJncm91cCIsImluY2x1ZGVVc2VycyIsInVzZXIiLCJleGNsdWRlVXNlcnMiLCJleGNlcHQiLCJwZXJtaXNzaW9uVHlwZSIsImciLCJsYWJlbCIsImluQXJyYXkiLCJhcnIiLCJ2Z3JvdXAiLCJ0aXRsZSIsImVhY2giLCJwIiwicmVuZGVyIiwiYmluZEV2ZW50cyJdLCJtYXBwaW5ncyI6IjtBQUFBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOzs7QUFHQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0Esa0RBQTBDLGdDQUFnQztBQUMxRTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLGdFQUF3RCxrQkFBa0I7QUFDMUU7QUFDQSx5REFBaUQsY0FBYztBQUMvRDs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsaURBQXlDLGlDQUFpQztBQUMxRSx3SEFBZ0gsbUJBQW1CLEVBQUU7QUFDckk7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxtQ0FBMkIsMEJBQTBCLEVBQUU7QUFDdkQseUNBQWlDLGVBQWU7QUFDaEQ7QUFDQTtBQUNBOztBQUVBO0FBQ0EsOERBQXNELCtEQUErRDs7QUFFckg7QUFDQTs7O0FBR0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDbEZBLGdIOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDQUE7Q0FHQTs7QUFFQSxJQUFNQSxJQUFJLEdBQUc7QUFDWEMsT0FBSyxFQUFFLEVBREk7QUFFWEMsS0FBRyxFQUFFLENBRk07QUFHWEMsV0FBUyxFQUFFLENBSEE7QUFJWEMsVUFBUSxFQUFFLEVBSkM7QUFLWEMsWUFBVSxFQUFFLEVBTEQ7QUFNWEMsUUFBTSxFQUFFO0FBTkcsQ0FBYjs7SUFTTUMsVTs7O0FBQ0osNEJBQTRGO0FBQUEsUUFBN0VDLFFBQTZFLFFBQTdFQSxRQUE2RTtBQUFB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QU8sQ0FBQyxpRkFBeUI7Ozs7Ozs7Ozs7OztBQ0FsRCxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9wZXJtaXNzaW9uL3Blcm1pc3Npb24uYnVuZGxlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL3Blcm1pc3Npb24vcGVybWlzc2lvbi5qc1wiKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0MjkpOyIsImltcG9ydCAkIGZyb20gJ2pxdWVyeSdcbmltcG9ydCBYRSBmcm9tICd4ZSdcblxuLy8gVE9ETzo6IG1vdXNlb3ZlcixcblxuY29uc3QgS2V5cyA9IHtcbiAgRU5URVI6IDEzLFxuICBUQUI6IDksXG4gIEJBQ0tTUEFDRTogOCxcbiAgVVBfQVJST1c6IDM4LFxuICBET1dOX0FSUk9XOiA0MCxcbiAgRVNDQVBFOiAyN1xufVxuXG5jbGFzcyBQZXJtaXNzaW9uIHtcbiAgY29uc3RydWN0b3IgKHsgJHdyYXBwZXIsIGtleSwgdXNlclNlYXJjaFVybCwgZ3JvdXBTZWFyY2hVcmwsIHBlcm1pc3Npb24sIHR5cGUsIHZncm91cEFsbCB9KSB7XG4gICAgdGhpcy4kd3JhcHBlciA9ICR3cmFwcGVyXG4gICAgdGhpcy5rZXkgPSBrZXlcbiAgICB0aGlzLnVzZXJTZWFyY2hVcmwgPSB1c2VyU2VhcmNoVXJsXG4gICAgdGhpcy5ncm91cFNlYXJjaFVybCA9IGdyb3VwU2VhcmNoVXJsXG4gICAgdGhpcy5wZXJtaXNzaW9uID0gcGVybWlzc2lvblxuICAgIHRoaXMudHlwZSA9IHR5cGVcbiAgICB0aGlzLnZncm91cEFsbCA9IHZncm91cEFsbFxuICAgIHRoaXMucXVlcnkgPSAnJ1xuICAgIHRoaXMuc3VnZ2VzdGlvbiA9IFtdXG4gICAgdGhpcy5wbGFjZWhvbGRlciA9IFhFLkxhbmcudHJhbnMoJ3hlOjpleHBsYWluSW5jbHVkZVVzZXJPckdyb3VwJylcbiAgICB0aGlzLnNlbGVjdGVkSW5kZXggPSAnJ1xuICAgIHRoaXMuaW5jbHVkZVNlbGVjdGVkSW5kZXggPSAtMVxuICAgIHRoaXMuZXhjbHVkZVNlbGVjdGVkSW5kZXggPSAtMVxuICAgIHRoaXMuTUlOX1FVRVJZX0xFTkdUSCA9IDJcbiAgfVxuXG4gIGJpbmRFdmVudHMgKCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcblxuICAgIHRoaXMuJHdyYXBwZXIub24oJ2NoYW5nZScsICcuY2hrTW9kZUFibGUnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyICR0YXJnZXQgPSAkKGUudGFyZ2V0KVxuICAgICAgdmFyIGNoZWNrZWQgPSAkdGFyZ2V0LmlzKCc6Y2hlY2tlZCcpXG5cbiAgICAgIGlmIChjaGVja2VkKSB7XG4gICAgICAgIF90aGlzLiR3cmFwcGVyLmZpbmQoJ2lucHV0Om5vdCguY2hrTW9kZUFibGUpJykucHJvcCgnZGlzYWJsZWQnLCB0cnVlKVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgX3RoaXMuJHdyYXBwZXIuZmluZCgnaW5wdXQ6bm90KC5jaGtNb2RlQWJsZSknKS5wcm9wKCdkaXNhYmxlZCcsIGZhbHNlKVxuICAgICAgfVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLm9uKCdrZXlkb3duJywgJy5pbnB1dFVzZXJHcm91cCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgcXVlcnkgPSBlLnRhcmdldC52YWx1ZS50cmltKClcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgIHZhciBrZXlDb2RlID0gZS5rZXlDb2RlXG4gICAgICB2YXIgJHVsID0gJHRoaXMucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMgdWwnKVxuICAgICAgdmFyIGRhdGFJbnB1dCA9ICR0aGlzLmRhdGEoJ2lucHV0JykgLy8gaW5jbHVkZSwgZXhjbHVkZVxuXG4gICAgICBpZiAocXVlcnkubGVuZ3RoID49IF90aGlzLk1JTl9RVUVSWV9MRU5HVEgpIHtcbiAgICAgICAgaWYgKCR1bC5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgdmFyIGluZGV4ID0gcGFyc2VJbnQoJHRoaXMuZGF0YSgnaW5kZXgnKSwgMTApXG4gICAgICAgICAgdmFyIGZvY3VzZWRJbmRleCA9IDBcblxuICAgICAgICAgIHN3aXRjaCAoa2V5Q29kZSkge1xuICAgICAgICAgICAgY2FzZSBLZXlzLlVQX0FSUk9XIDpcbiAgICAgICAgICAgICAgaWYgKGluZGV4ID09IDApIHtcbiAgICAgICAgICAgICAgICBmb2N1c2VkSW5kZXggPSAkdWwuZmluZCgnbGknKS5sZW5ndGggLSAxXG4gICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgZm9jdXNlZEluZGV4ID0gKGluZGV4IC0gMSlcbiAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICR0aGlzLmRhdGEoJ2luZGV4JywgZm9jdXNlZEluZGV4KVxuICAgICAgICAgICAgICAkdWwuZmluZCgnbGknKS5lcShmb2N1c2VkSW5kZXgpLmFkZENsYXNzKCdhY3RpdmUnKS5zaWJsaW5ncygpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKVxuXG4gICAgICAgICAgICAgIGJyZWFrXG4gICAgICAgICAgICBjYXNlIEtleXMuRE9XTl9BUlJPVyA6XG4gICAgICAgICAgICAgIGlmIChpbmRleCA9PSAkdWwuZmluZCgnbGknKS5sZW5ndGggLSAxKSB7XG4gICAgICAgICAgICAgICAgZm9jdXNlZEluZGV4ID0gMFxuICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgIGZvY3VzZWRJbmRleCA9IGluZGV4ICsgMVxuICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgJHRoaXMuZGF0YSgnaW5kZXgnLCBmb2N1c2VkSW5kZXgpXG4gICAgICAgICAgICAgICR1bC5maW5kKCdsaScpLmVxKGZvY3VzZWRJbmRleCkuYWRkQ2xhc3MoJ2FjdGl2ZScpLnNpYmxpbmdzKCkucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpXG5cbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICAgIGNhc2UgS2V5cy5FTlRFUiA6XG4gICAgICAgICAgICBjYXNlIEtleXMuVEFCIDpcbiAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgICAgICAgICAgaWYgKCR1bC5maW5kKCdsaS5hY3RpdmUnKS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhZyA9ICR1bC5maW5kKCdsaS5hY3RpdmUnKS5kYXRhKCd0YWcnKVxuICAgICAgICAgICAgICAgIHZhciBuYW1lID0gJydcbiAgICAgICAgICAgICAgICB2YXIgcFR5cGUgPSAnJ1xuICAgICAgICAgICAgICAgIHZhciBwcmVmaXggPSAnJ1xuXG4gICAgICAgICAgICAgICAgLy8gdXNlclxuICAgICAgICAgICAgICAgIGlmICgkdWwuZGF0YSgndGFyZ2V0JykgPT0gJ3VzZXInKSB7XG4gICAgICAgICAgICAgICAgICAvLyBpbmNsdWRlXG4gICAgICAgICAgICAgICAgICBpZiAoZGF0YUlucHV0ID09ICdpbmNsdWRlJykge1xuICAgICAgICAgICAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdVc2VyJ1xuICAgICAgICAgICAgICAgICAgICBwVHlwZSA9ICd1c2VyJ1xuICAgICAgICAgICAgICAgICAgICBwcmVmaXggPSAnQCdcbiAgICAgICAgICAgICAgICAgICAgLy8gZXhjbHVkZVxuICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnRXhjZXB0J1xuICAgICAgICAgICAgICAgICAgICBwVHlwZSA9ICdleGNlcHQnXG4gICAgICAgICAgICAgICAgICAgIHByZWZpeCA9ICdAJ1xuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgLy8gZ3JvdXBcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnR3JvdXAnXG4gICAgICAgICAgICAgICAgICBwVHlwZSA9ICdncm91cCdcbiAgICAgICAgICAgICAgICAgIHByZWZpeCA9ICclJ1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHZhciBwVHlwZXMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXVxuICAgICAgICAgICAgICAgIHZhciBiU2FtZVdvcmQgPSBmYWxzZVxuXG4gICAgICAgICAgICAgICAgaWYgKHBUeXBlcy5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAgICAgICBwVHlwZXMuZm9yRWFjaChmdW5jdGlvbiAodHlwZSwgaSkge1xuICAgICAgICAgICAgICAgICAgICBpZiAodHlwZS5pZCA9PT0gdGFnLmlkKSB7XG4gICAgICAgICAgICAgICAgICAgICAgYlNhbWVXb3JkID0gdHJ1ZVxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICB9KVxuXG4gICAgICAgICAgICAgICAgICBpZiAoIWJTYW1lV29yZCkge1xuICAgICAgICAgICAgICAgICAgICBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5wdXNoKHRhZylcbiAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0ucHVzaCh0YWcpXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgdmFyIGlkcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLm1hcChmdW5jdGlvbiAodGFnKSB7XG4gICAgICAgICAgICAgICAgICByZXR1cm4gdGFnLmlkXG4gICAgICAgICAgICAgICAgfSlcblxuICAgICAgICAgICAgICAgIGlmICghYlNhbWVXb3JkKSB7XG4gICAgICAgICAgICAgICAgICAkdWwuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJ1tuYW1lPScgKyBuYW1lICsgJ10nKS52YWwoaWRzLmpvaW4oKS50cmltKCkpXG4gICAgICAgICAgICAgICAgICAkdWwuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJy4nICsgcFR5cGUgKyAnV3JhcCcpXG4gICAgICAgICAgICAgICAgICAgIC5hcHBlbmQoYDxzcGFuIGNsYXNzPVwiUmVhY3RUYWdzX190YWdcIj4ke3ByZWZpeCArICh0YWcuZGlzcGxheV9uYW1lIHx8IHRhZy5uYW1lKX08YSBjbGFzcz1cIlJlYWN0VGFnc19fcmVtb3ZlIGJ0blJlbW92ZVRhZ1wiIGRhdGEtaWQ9XCIke3RhZy5pZH1cIj54PC9hPjwvc3Bhbj5gKVxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICR1bC5yZW1vdmUoKVxuICAgICAgICAgICAgICAgICR0aGlzLnZhbCgnJykuZGF0YSgnaW5kZXgnLCAtMSkuZm9jdXMoKVxuICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXHQvLyBwcmV2ZW50IHRhYlxuXG4gICAgICAgICAgICAgIGJyZWFrXG4gICAgICAgICAgICBjYXNlIEtleXMuRVNDQVBFIDpcbiAgICAgICAgICAgICAgX3RoaXNbZGF0YUlucHV0ICsgJ1NlbGVjdGVkSW5kZXgnXSA9IDBcbiAgICAgICAgICAgICAgJHVsLnBhcmVudCgpLmVtcHR5KClcbiAgICAgICAgICAgICAgJHRoaXMuZm9jdXMoKVxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgaWYgKEtleXMuQkFDS1NQQUNFID09PSBrZXlDb2RlKSB7XG4gICAgICAgICAgdmFyICR0YWcgPSAkdGhpcy5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnLlJlYWN0VGFnc19fc2VsZWN0ZWQgc3BhbicpXG4gICAgICAgICAgaWYgKCFxdWVyeSAmJiAkdGFnLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIF90aGlzLnJlbW92ZVRhZygkdGFnLmVxKCR0YWcubGVuZ3RoIC0gMSkpXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9XG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5vbignbW91c2VlbnRlcicsICdsaScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgIHZhciAkdWwgPSAkdGhpcy5jbG9zZXN0KCd1bCcpXG5cbiAgICAgICR0aGlzLmFkZENsYXNzKCdhY3RpdmUnKS5zaWJsaW5ncygpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykub24oJ2NsaWNrJywgJ2xpJywgZnVuY3Rpb24gKCkge1xuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyIHRhZyA9ICR0aGlzLmRhdGEoJ3RhZycpXG4gICAgICB2YXIgJHVsID0gJHRoaXMuY2xvc2VzdCgndWwnKVxuICAgICAgdmFyICRpbnB1dCA9ICR0aGlzLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ0lucHV0JykuZmluZCgnaW5wdXQ6dGV4dCcpXG4gICAgICB2YXIgZGF0YUlucHV0ID0gJGlucHV0LmRhdGEoJ2lucHV0JylcbiAgICAgIHZhciBpZCA9IHRhZy5pZFxuICAgICAgdmFyIG5hbWUgPSAnJ1xuICAgICAgdmFyIHBUeXBlID0gJydcbiAgICAgIHZhciBwcmVmaXggPSAnJ1xuXG4gICAgICBpZiAoJHVsLmRhdGEoJ3RhcmdldCcpID09ICd1c2VyJykge1xuICAgICAgICAvLyBpbmNsdWRlXG4gICAgICAgIGlmIChkYXRhSW5wdXQgPT0gJ2luY2x1ZGUnKSB7XG4gICAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnVXNlcidcbiAgICAgICAgICBwVHlwZSA9ICd1c2VyJ1xuICAgICAgICAgIHByZWZpeCA9ICdAJ1xuICAgICAgICAgIC8vIGV4Y2x1ZGVcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdFeGNlcHQnXG4gICAgICAgICAgcFR5cGUgPSAnZXhjZXB0J1xuICAgICAgICAgIHByZWZpeCA9ICdAJ1xuICAgICAgICB9XG4gICAgICAgIC8vIGdyb3VwXG4gICAgICB9IGVsc2Uge1xuICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdHcm91cCdcbiAgICAgICAgcFR5cGUgPSAnZ3JvdXAnXG4gICAgICAgIHByZWZpeCA9ICclJ1xuICAgICAgfVxuXG4gICAgICB2YXIgcFR5cGVzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV1cbiAgICAgIHZhciBiU2FtZVdvcmQgPSBmYWxzZVxuXG4gICAgICBpZiAocFR5cGVzLmxlbmd0aCA+IDApIHtcbiAgICAgICAgcFR5cGVzLmZvckVhY2goZnVuY3Rpb24gKHR5cGUsIGkpIHtcbiAgICAgICAgICBpZiAodHlwZS5pZCA9PT0gdGFnLmlkKSB7XG4gICAgICAgICAgICBiU2FtZVdvcmQgPSB0cnVlXG4gICAgICAgICAgfVxuICAgICAgICB9KVxuXG4gICAgICAgIGlmICghYlNhbWVXb3JkKSB7XG4gICAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0ucHVzaCh0YWcpXG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnB1c2godGFnKVxuICAgICAgfVxuXG4gICAgICB2YXIgaWRzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV0ubWFwKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgICAgcmV0dXJuIHRhZy5pZFxuICAgICAgfSlcblxuICAgICAgaWYgKCFiU2FtZVdvcmQpIHtcbiAgICAgICAgJHVsLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCdbbmFtZT0nICsgbmFtZSArICddJykudmFsKGlkcy5qb2luKCkudHJpbSgpKVxuICAgICAgICAkdWwuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJy4nICsgcFR5cGUgKyAnV3JhcCcpXG4gICAgICAgICAgLmFwcGVuZChgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7cHJlZml4ICsgKHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWUpfTxhIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfVwiPng8L2E+PC9zcGFuPmApXG4gICAgICB9XG5cbiAgICAgICR1bC5yZW1vdmUoKVxuICAgICAgJGlucHV0LnZhbCgnJykuZGF0YSgnaW5kZXgnLCAtMSkuZm9jdXMoKVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLm9uKCdrZXl1cCcsICcuaW5wdXRVc2VyR3JvdXAnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyIHF1ZXJ5ID0gZS50YXJnZXQudmFsdWUudHJpbSgpXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIga2V5Q29kZSA9IGUua2V5Q29kZVxuXG4gICAgICBpZiAocXVlcnkubGVuZ3RoID49IF90aGlzLk1JTl9RVUVSWV9MRU5HVEgpIHtcbiAgICAgICAgaWYgKFtLZXlzLkVOVEVSLCBLZXlzLlRBQiwgS2V5cy5VUF9BUlJPVywgS2V5cy5ET1dOX0FSUk9XLCBLZXlzLkVTQ0FQRSwgMzcsIDM5XS5pbmRleE9mKGtleUNvZGUpID09IC0xKSB7XG4gICAgICAgICAgdmFyIHRlbXAgPSAnJ1xuICAgICAgICAgIHRlbXAgKz0gXHRgPHVsPmBcbiAgICAgICAgICB0ZW1wICs9XHRcdFx0YDxsaT5TZWFyY2hpbmcgLi4uIDxzcGFuIGNsYXNzPVwic3Bpbm5lclwiIHJvbGU9XCJzcGlubmVyXCI+PHNwYW4gY2xhc3M9XCJzcGlubmVyLWljb25cIj48L3NwYW4+PC9zcGFuPjwvbGk+YFxuICAgICAgICAgIHRlbXAgKz0gXHRgPC91bD5gXG5cbiAgICAgICAgICAkdGhpcy5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmh0bWwodGVtcClcblxuICAgICAgICAgIHZhciBpZGVudGlmaWVyID0gcXVlcnkuc3Vic3RyKDAsIDEpXG4gICAgICAgICAgc3dpdGNoIChpZGVudGlmaWVyKSB7XG4gICAgICAgICAgICBjYXNlICdAJzpcbiAgICAgICAgICAgICAgcXVlcnkgPSBxdWVyeS5zdWJzdHIoMSwgcXVlcnkubGVuZ3RoKVxuICAgICAgICAgICAgICBfdGhpcy5zZWFyY2hVc2VyKCR0aGlzLCBxdWVyeSlcbiAgICAgICAgICAgICAgYnJlYWtcblxuICAgICAgICAgICAgY2FzZSAnJSc6XG4gICAgICAgICAgICAgIHF1ZXJ5ID0gcXVlcnkuc3Vic3RyKDEsIHF1ZXJ5Lmxlbmd0aClcbiAgICAgICAgICAgICAgX3RoaXMuc2VhcmNoR3JvdXAoJHRoaXMsIHF1ZXJ5KVxuICAgICAgICAgICAgICBicmVha1xuXG4gICAgICAgICAgICBkZWZhdWx0IDpcbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSB7XG4gICAgICAgICR0aGlzLnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuZW1wdHkoKVxuICAgICAgfVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLm9uKCdjbGljaycsICcuYnRuUmVtb3ZlVGFnJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICBfdGhpcy5yZW1vdmVUYWcoJCh0aGlzKS5jbG9zZXN0KCdzcGFuJykpXG4gICAgfSlcbiAgfVxuXG4gIG1ha2VJdCAoaXRlbSwgcXVlcnkpIHtcbiAgICB2YXIgZXNjYXBlZFJlZ2V4ID0gcXVlcnkudHJpbSgpLnJlcGxhY2UoL1stXFxcXF4kKis/LigpfFtcXF17fV0vZywgJ1xcXFwkJicpXG4gICAgdmFyIHIgPSBSZWdFeHAoZXNjYXBlZFJlZ2V4LCAnZ2knKVxuICAgIHZhciBpdGVtTmFtZSA9IGl0ZW0uZGlzcGxheV9uYW1lIHx8IGl0ZW0ubmFtZVxuXG4gICAgcmV0dXJuIGl0ZW1OYW1lLnJlcGxhY2UociwgJzxtYXJrPiQmPC9tYXJrPicpXG4gIH1cblxuICByZW1vdmVUYWcgKCR0YXJnZXQpIHtcbiAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgdmFyIHBUeXBlID0gJHRhcmdldC5jbG9zZXN0KCcuUmVhY3RUYWdzX19zZWxlY3RlZCcpLmRhdGEoJ3B0eXBlJylcbiAgICB2YXIgaWQgPSAkdGFyZ2V0LmRhdGEoJ2lkJylcbiAgICB2YXIgbmFtZSA9ICcnXG5cbiAgICBzd2l0Y2ggKHBUeXBlKSB7XG4gICAgICBjYXNlICd1c2VyJyA6XG4gICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ1VzZXInXG4gICAgICAgIGJyZWFrXG4gICAgICBjYXNlICdleGNlcHQnIDpcbiAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnRXhjZXB0J1xuICAgICAgICBicmVha1xuICAgICAgY2FzZSAnZ3JvdXAnIDpcbiAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnR3JvdXAnXG4gICAgICAgIGJyZWFrXG4gICAgfVxuXG4gICAgdmFyIHBUeXBlcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdXG5cbiAgICBwVHlwZXMuZm9yRWFjaChmdW5jdGlvbiAodHlwZSwgaSkge1xuICAgICAgaWYgKHR5cGUuaWQgIT09IGlkKSB7XG4gICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnNwbGljZShpLCAxKS8vIC5wdXNoKHRhZyk7XG4gICAgICB9XG4gICAgfSlcblxuICAgIHZhciBpZHMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5tYXAoZnVuY3Rpb24gKHRhZykge1xuICAgICAgcmV0dXJuIHRhZy5pZFxuICAgIH0pXG5cbiAgICAkdGFyZ2V0LmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCdbbmFtZT0nICsgbmFtZSArICddJykudmFsKGlkcy5qb2luKCkudHJpbSgpKVxuICAgICR0YXJnZXQucmVtb3ZlKClcbiAgfVxuXG4gIHNlYXJjaFVzZXIgKCRpbnB1dCwga2V5d29yZCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICB2YXIgc2VhcmNoVXNlclVybCA9IF90aGlzLnVzZXJTZWFyY2hVcmxcblxuICAgIFhFLmFqYXgoe1xuICAgICAgdXJsOiBzZWFyY2hVc2VyVXJsICsgJy8nICsga2V5d29yZCxcbiAgICAgIG1ldGhvZDogJ2dldCcsXG4gICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgY2FjaGU6IGZhbHNlLFxuICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgaWYgKGRhdGEubGVuZ3RoID4gMCkge1xuICAgICAgICAgIHZhciB0ZW1wID0gJydcbiAgICAgICAgICB0ZW1wICs9IFx0YDx1bCBkYXRhLXRhcmdldD1cInVzZXJcIj5gXG5cbiAgICAgICAgICBkYXRhLmZvckVhY2goZnVuY3Rpb24gKGl0ZW0sIGkpIHtcbiAgICAgICAgICAgIHRlbXAgKz0gXHRcdGA8bGkgY2xhc3M9XCJcIiBkYXRhLXRhZz0nJHtKU09OLnN0cmluZ2lmeShpdGVtKX0nPmBcbiAgICAgICAgICAgIHRlbXAgKz0gXHRcdFx0YDxzcGFuPiR7X3RoaXMubWFrZUl0KGl0ZW0sIGtleXdvcmQpfTwvc3Bhbj5gXG4gICAgICAgICAgICB0ZW1wICs9IFx0XHRgPC9saT5gXG4gICAgICAgICAgfSlcblxuICAgICAgICAgIHRlbXAgKz0gXHRgPC91bD5gXG5cbiAgICAgICAgICAkaW5wdXQucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5odG1sKHRlbXApXG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgJGlucHV0LnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuZW1wdHkoKVxuICAgICAgICB9XG4gICAgICB9LFxuICAgICAgZXJyb3I6IGZ1bmN0aW9uICh4aHIsIHN0YXR1cywgZXJyKSB7XG5cbiAgICAgIH1cbiAgICB9KVxuICB9XG5cbiAgc2VhcmNoR3JvdXAgKCRpbnB1dCwga2V5d29yZCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICB2YXIgc2VhcmNoR3JvdXBVcmwgPSBfdGhpcy5ncm91cFNlYXJjaFVybFxuXG4gICAgWEUuYWpheCh7XG4gICAgICB1cmw6IHNlYXJjaEdyb3VwVXJsICsgJy8nICsga2V5d29yZCxcbiAgICAgIG1ldGhvZDogJ2dldCcsXG4gICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgY2FjaGU6IGZhbHNlLFxuICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgLy8gVE9ETzo6IHZpZXcgcmVuZGVyaW5cbiAgICAgICAgaWYgKGRhdGEubGVuZ3RoID4gMCkge1xuICAgICAgICAgIHZhciB0ZW1wID0gJydcbiAgICAgICAgICB0ZW1wICs9IFx0YDx1bCBkYXRhLXRhcmdldD1cImdyb3VwXCI+YFxuXG4gICAgICAgICAgZGF0YS5mb3JFYWNoKGZ1bmN0aW9uIChpdGVtLCBpKSB7XG4gICAgICAgICAgICB0ZW1wICs9IFx0XHRgPGxpIGRhdGEtdGFnPScke0pTT04uc3RyaW5naWZ5KGl0ZW0pfSc+YFxuICAgICAgICAgICAgdGVtcCArPSBcdFx0XHRgPHNwYW4+JHtfdGhpcy5tYWtlSXQoaXRlbSwga2V5d29yZCl9PC9zcGFuPmBcbiAgICAgICAgICAgIHRlbXAgKz0gXHRcdGA8L2xpPmBcbiAgICAgICAgICB9KVxuXG4gICAgICAgICAgdGVtcCArPSBcdGA8L3VsPmBcblxuICAgICAgICAgICRpbnB1dC5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmh0bWwodGVtcClcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAkaW5wdXQucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5lbXB0eSgpXG4gICAgICAgIH1cbiAgICAgIH0sXG4gICAgICBlcnJvcjogZnVuY3Rpb24gKHhociwgc3RhdHVzLCBlcnIpIHt9XG4gICAgfSlcbiAgfVxuXG4gIHJlbmRlciAoKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHZhciBtb2RlID0gdGhpcy5wZXJtaXNzaW9uLm1vZGVcbiAgICB2YXIgcmF0aW5nID0gdGhpcy5wZXJtaXNzaW9uLnJhdGluZ1xuICAgIHZhciBtb2RlRW5hYmxlID0gZmFsc2VcbiAgICB2YXIgcGVybWlzc2lvblR5cGVzID0gW1xuICAgICAgeyB2YWx1ZTogJ3N1cGVyJywgbmFtZTogWEUuTGFuZy50cmFucygneGU6OnVzZXJSYXRpbmdBZG1pbmlzdHJhdG9yJykgfSxcbiAgICAgIHsgdmFsdWU6ICdtYW5hZ2VyJywgbmFtZTogWEUuTGFuZy50cmFucygneGU6OnVzZXJSYXRpbmdNYW5hZ2VyJykgfSxcbiAgICAgIHsgdmFsdWU6ICd1c2VyJywgbmFtZTogWEUuTGFuZy50cmFucygneGU6OnVzZXInKSB9LFxuICAgICAgeyB2YWx1ZTogJ2d1ZXN0JywgbmFtZTogWEUuTGFuZy50cmFucygneGU6Omd1ZXN0JykgfVxuICAgIF1cblxuICAgIHZhciBkaXNhYmxlZCA9IGZhbHNlXG5cbiAgICBpZiAobW9kZSA9PT0gJ21hbnVhbCcgfHwgbW9kZSA9PT0gJ2luaGVyaXQnKSB7XG4gICAgICBtb2RlRW5hYmxlID0gdHJ1ZVxuICAgICAgaWYgKG1vZGUgIT09ICdtYW51YWwnKSB7XG4gICAgICAgIGRpc2FibGVkID0gdHJ1ZVxuICAgICAgfVxuICAgIH1cblxuICAgIHZhciBpbmNsdWRlR3JvdXBzID0gdGhpcy5wZXJtaXNzaW9uLmdyb3VwLm1hcChmdW5jdGlvbiAoZ3JvdXApIHtcbiAgICAgIHJldHVybiBncm91cC5pZFxuICAgIH0pXG5cbiAgICB2YXIgaW5jbHVkZVVzZXJzID0gdGhpcy5wZXJtaXNzaW9uLnVzZXIubWFwKGZ1bmN0aW9uICh1c2VyKSB7XG4gICAgICByZXR1cm4gdXNlci5pZFxuICAgIH0pXG5cbiAgICB2YXIgZXhjbHVkZVVzZXJzID0gdGhpcy5wZXJtaXNzaW9uLmV4Y2VwdC5tYXAoZnVuY3Rpb24gKHVzZXIpIHtcbiAgICAgIHJldHVybiB1c2VyLmlkXG4gICAgfSlcblxuICAgIHZhciB0ZW1wID0gJydcbiAgICB0ZW1wICs9IGA8ZGl2PmBcblxuICAgIGlmIChtb2RlRW5hYmxlKSB7XG4gICAgICB2YXIgY2hlY2tlZCA9IChtb2RlID09PSAnaW5oZXJpdCcpID8gJ2NoZWNrZWQ9XCJjaGVja2VkXCInIDogJydcblxuICAgICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgICB0ZW1wICs9IFx0YDxkaXYgY2xhc3M9XCJjaGVja2JveFwiPmBcbiAgICAgIHRlbXAgKz1cdFx0XHRgPGxhYmVsPjxpbnB1dCB0eXBlPVwiY2hlY2tib3hcIiBuYW1lPVwiJHt0aGlzLnR5cGUgKyAnTW9kZSd9XCIgY2xhc3M9XCJjaGtNb2RlQWJsZVwiIHZhbHVlPVwiaW5oZXJpdFwiICR7Y2hlY2tlZH0gLz4gJHtYRS5MYW5nLnRyYW5zKCd4ZTo6aW5oZXJpdE1vZGUnKX08L2xhYmVsPmBcbiAgICAgIHRlbXAgKz0gXHRgPC9kaXY+YFxuICAgICAgdGVtcCArPSBgPC9kaXY+YFxuICAgIH1cblxuICAgIHRlbXAgKz0gXHRgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgdGVtcCArPVx0XHRcdGA8bGFiZWw+7ZqM7JuQIOuTseq4iTwvbGFiZWw+YFxuICAgIHRlbXAgKz0gXHRcdCc8ZGl2IGNsYXNzPVwicmFkaW9cIj4nXG4gICAgcGVybWlzc2lvblR5cGVzLmZvckVhY2goZnVuY3Rpb24gKHBlcm1pc3Npb25UeXBlKSB7XG4gICAgICB2YXIgY2hlY2tlZCA9IChwZXJtaXNzaW9uVHlwZS52YWx1ZSA9PSByYXRpbmcpID8gJ2NoZWNrZWQnIDogJydcblxuICAgICAgdGVtcCArPSBgPGxhYmVsPjxpbnB1dCB0eXBlPVwicmFkaW9cIiAkeyhkaXNhYmxlZCkgPyAnZGlzYWJsZWQ9XCJkaXNhYmxlZFwiJyA6ICcnfSBuYW1lPVwiJHtfdGhpcy50eXBlICsgJ1JhdGluZyd9XCIgdmFsdWU9XCIke3Blcm1pc3Npb25UeXBlLnZhbHVlfVwiICR7KGNoZWNrZWQpID8gJ2NoZWNrZWQ9XCJjaGVja2VkXCInIDogJyd9IC8+ICR7cGVybWlzc2lvblR5cGUubmFtZX0gJm5ic3A7PC9sYWJlbD5gXG4gICAgfSlcbiAgICB0ZW1wICs9XHRcdFx0YDwvZGl2PmBcbiAgICB0ZW1wICs9XHRcdGA8L2Rpdj5gXG4gICAgdGVtcCArPSBcdGA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiPmBcbiAgICB0ZW1wICs9XHRcdFx0YDxsYWJlbD4ke1hFLkxhbmcudHJhbnMoJ3hlOjppbmNsdWRlVXNlck9yR3JvdXAnKX08L2xhYmVsPmBcbiAgICB0ZW1wICs9XHRcdFx0YDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ3NcIj5gXG5cbiAgICB0ZW1wICs9IFx0XHRcdGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX19zZWxlY3RlZCBncm91cFdyYXBcIiBkYXRhLXB0eXBlPVwiZ3JvdXBcIj5gXG4gICAgdGhpcy5wZXJtaXNzaW9uLmdyb3VwLmZvckVhY2goZnVuY3Rpb24gKGcpIHtcbiAgICAgIHZhciB0YWcgPSBnXG4gICAgICB2YXIgbGFiZWwgPSAnJScgKyAodGFnLmRpc3BsYXlfbmFtZSB8fCB0YWcubmFtZSlcblxuICAgICAgdGVtcCArPSBcdFx0XHRgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7bGFiZWx9PGEgaHJlZj1cIiNcIiBjbGFzcz1cIlJlYWN0VGFnc19fcmVtb3ZlIGJ0blJlbW92ZVRhZ1wiIGRhdGEtaWQ9XCIke3RhZy5pZH1cIj54PC9hPjwvc3Bhbj5gXG4gICAgfSlcbiAgICB0ZW1wICs9XHRcdFx0XHQnPC9kaXY+J1xuXG4gICAgdGVtcCArPVx0XHRcdFx0JzxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3NlbGVjdGVkIHVzZXJXcmFwXCIgZGF0YS1wdHlwZT1cInVzZXJcIj4nXG4gICAgdGhpcy5wZXJtaXNzaW9uLnVzZXIuZm9yRWFjaChmdW5jdGlvbiAodGFnKSB7XG4gICAgICB2YXIgbGFiZWwgPSAnQCcgKyAodGFnLmRpc3BsYXlfbmFtZSB8fCB0YWcubmFtZSlcblxuICAgICAgdGVtcCArPSBcdFx0XHRgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7bGFiZWx9PGEgaHJlZj1cIiNcIiBjbGFzcz1cIlJlYWN0VGFnc19fcmVtb3ZlIGJ0blJlbW92ZVRhZ1wiIGRhdGEtaWQ9XCIke3RhZy5pZH18XCI+eDwvYT48L3NwYW4+YFxuICAgIH0pXG4gICAgdGVtcCArPVx0XHRcdFx0YDwvZGl2PmBcblxuICAgIHRlbXAgKz1cdFx0XHRcdGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX190YWdJbnB1dFwiPmBcbiAgICB0ZW1wICs9IFx0XHRcdFx0YDxpbnB1dCB0eXBlPVwidGV4dFwiIHBsYWNlaG9sZGVyPVwiJHt0aGlzLnBsYWNlaG9sZGVyfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGlucHV0VXNlckdyb3VwXCIgZGF0YS1pbnB1dD1cImluY2x1ZGVcIiAkeyhkaXNhYmxlZCkgPyAnZGlzYWJsZWQ9XCJkaXNhYmxlZFwiJyA6ICcnfSB2YWx1ZT1cIiR7dGhpcy5xdWVyeX1cIiBkYXRhLWluZGV4PVwiLTFcIiAvPmBcdC8vIFRPRE86OiBQZXJtaXNzaW9uSW5jbHVkZSBoYW5kbGVLZXlEb3duXG4gICAgdGVtcCArPSBcdFx0XHRcdGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX19zdWdnZXN0aW9uc1wiIGRhdGEtaW5wdXQ9XCJpbmNsdWRlXCI+PC9kaXY+YFxuICAgIHRlbXAgKz1cdFx0XHRcdGA8L2Rpdj5gIC8vIFJlYWN0VGFnc19fdGFnSW5wdXRcbiAgICB0ZW1wICs9IFx0XHRcdGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3RoaXMudHlwZSArICdHcm91cCd9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgaW5jbHVkZUdyb3Vwc1wiIHZhbHVlPVwiJHtpbmNsdWRlR3JvdXBzLmpvaW4oKS50cmltKCl9XCIgLz5gXG4gICAgdGVtcCArPVx0XHRcdFx0YDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cIiR7dGhpcy50eXBlICsgJ1VzZXInfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGluY2x1ZGVVc2Vyc1wiIHZhbHVlPVwiJHtpbmNsdWRlVXNlcnMuam9pbigpLnRyaW0oKX1cIiAvPmBcbiAgICB0ZW1wICs9XHRcdFx0YDwvZGl2PmBcdC8vIFJlYWN0VGFnc19fdGFnc1xuICAgIHRlbXAgKz1cdFx0YDwvZGl2PmAvLyBmb3JtLWdyb3VwXG5cbiAgICBpZiAodGhpcy52Z3JvdXBBbGwubGVuZ3RoID49IDEpIHtcbiAgICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+YFxuICAgICAgdGVtcCArPSBcdGA8bGFiZWw+JHtYRS5MYW5nLnRyYW5zKCd4ZTo6aW5jbHVkZVZHcm91cCcpfTwvbGFiZWw+YFxuXG4gICAgICB0ZW1wICs9IF90aGlzLnZncm91cEFsbC5tYXAoZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgdmFyIGNoZWNrZWQgPSBmYWxzZVxuXG4gICAgICAgIHZhciBpbkFycmF5ID0gZnVuY3Rpb24gKHZhbCwgYXJyKSB7XG4gICAgICAgICAgZm9yICh2YXIgaSA9IDA7IGkgPCBhcnIubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIGlmIChhcnJbaV0gPT0gdmFsKSB7XG4gICAgICAgICAgICAgIHJldHVybiBpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfVxuXG4gICAgICAgICAgcmV0dXJuIC0xXG4gICAgICAgIH1cblxuICAgICAgICBpZiAoaW5BcnJheShkYXRhLmlkLCB0aGlzLnBlcm1pc3Npb24udmdyb3VwKSAhPSAtMSkge1xuICAgICAgICAgIGNoZWNrZWQgPSB0cnVlXG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gYDxsYWJlbD48aW5wdXQgdHlwZT1cImNoZWNrYm94XCIgJHsoZGlzYWJsZWQpID8gJ2Rpc2FibGVkPVwiZGlzYWJsZWRcIicgOiAnJ30gbmFtZT1cIiR7X3RoaXMudHlwZSArICdWR3JvdXBbXSd9XCIgdmFsdWU9XCIke2RhdGEuaWR9XCIgJHsoY2hlY2tlZCkgPyAnY2hlY2tlZD1cImNoZWNrZWRcIicgOiAnJ30gLz4gJHtkYXRhLnRpdGxlfSAmbmJzcDs8L2xhYmVsPmBcbiAgICAgIH0pXG5cbiAgICAgIHRlbXAgKz0gJzwvZGl2PidcbiAgICB9XG5cbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiPmBcbiAgICB0ZW1wICs9IFx0YDxsYWJlbD4ke1hFLkxhbmcudHJhbnMoJ3hlOjpleGNsdWRlVXNlcicpfTwvbGFiZWw+YFxuICAgIHRlbXAgKz1cdFx0YDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ3NcIj5gXG4gICAgdGVtcCArPVx0XHRcdGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX19zZWxlY3RlZCBleGNlcHRXcmFwXCIgZGF0YS1wdHlwZT1cImV4Y2VwdFwiPmBcblxuICAgIHRoaXMucGVybWlzc2lvbi5leGNlcHQuZm9yRWFjaChmdW5jdGlvbiAodGFnKSB7XG4gICAgICB2YXIgbGFiZWwgPSB0YWcuZGlzcGxheV9uYW1lIHx8IHRhZy5uYW1lXG4gICAgICBsYWJlbCA9ICdAJyArIGxhYmVsXG5cbiAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiUmVhY3RUYWdzX190YWdcIj4ke2xhYmVsfTxhIGhyZWY9XCIjXCIgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9XCI+eDwvYT48L3NwYW4+YFxuICAgIH0pXG5cbiAgICB0ZW1wICs9XHRcdFx0YDwvZGl2PmBcbiAgICB0ZW1wICs9IFx0XHRgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnSW5wdXRcIj5gXG4gICAgdGVtcCArPVx0XHRcdFx0YDxpbnB1dCB0eXBlPVwidGV4dFwiIHBsYWNlaG9sZGVyPVwiJHtYRS5MYW5nLnRyYW5zKCd4ZTo6ZXhwbGFpbkV4Y2x1ZGVVc2VyJyl9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgaW5wdXRVc2VyR3JvdXBcIiBkYXRhLWlucHV0PVwiZXhjbHVkZVwiICR7KGRpc2FibGVkKSA/ICdkaXNhYmxlZD1cImRpc2FibGVkXCInIDogJyd9IGRhdGEtaW5kZXg9XCItMVwiIC8+YCBcdC8vIFRPRE86OiBQZXJtaXNzaW9uRXhjbHVkZSBoYW5kbGVLZXlEb3duXG4gICAgdGVtcCArPSBcdFx0XHRgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc3VnZ2VzdGlvbnNcIiBkYXRhLWlucHV0PVwiZXhjbHVkZVwiPjwvZGl2PmBcbiAgICB0ZW1wICs9IFx0XHRgPC9kaXY+YCAvLyBSZWFjdFRhZ3NfX3RhZ0lucHV0XG4gICAgdGVtcCArPVx0XHRgPGlucHV0IHR5cGU9XCJoaWRkZW5cIiBuYW1lPVwiJHt0aGlzLnR5cGUgKyAnRXhjZXB0J31cIiBjbGFzcz1cImZvcm0tY29udHJvbCBleGNsdWRlVXNlcnNcIiB2YWx1ZT1cIiR7ZXhjbHVkZVVzZXJzfVwiIC8+YFxuICAgIHRlbXAgKz1cdFx0YDwvZGl2PmAgLy8gUmVhY3RUYWdzX190YWdzXG4gICAgdGVtcCArPSBgPC9kaXY+YC8vIGZvcm0tZ3JvdXBcblxuICAgIHRlbXAgKz0gYDwvZGl2PmBcblxuICAgIHRoaXMuJHdyYXBwZXIuaHRtbCh0ZW1wKVxuICB9XG59XG5cbiQoJy5fX3hlX191aW9iamVjdF9wZXJtaXNzaW9uJykuZWFjaChmdW5jdGlvbiAoaSkge1xuICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gIHZhciBwZXJtaXNzaW9uID0gJHRoaXMuZGF0YSgnZGF0YScpXG5cbiAgdmFyIGtleSA9ICR0aGlzLmRhdGEoJ2tleScpXG4gIHZhciB0eXBlID0gJHRoaXMuZGF0YSgndHlwZScpXG4gIHZhciB1c2VyU2VhcmNoVXJsID0gJHRoaXMuZGF0YSgndXNlclVybCcpXG4gIHZhciBncm91cFNlYXJjaFVybCA9ICR0aGlzLmRhdGEoJ2dyb3VwVXJsJylcbiAgdmFyIHZncm91cEFsbCA9ICR0aGlzLmRhdGEoJ3Zncm91cEFsbCcpXG5cbiAgdmFyIHAgPSBuZXcgUGVybWlzc2lvbih7ICR3cmFwcGVyOiAkdGhpcywga2V5LCB1c2VyU2VhcmNoVXJsLCBncm91cFNlYXJjaFVybCwgcGVybWlzc2lvbiwgdHlwZSwgdmdyb3VwQWxsIH0pXG4gIHAucmVuZGVyKClcbiAgcC5iaW5kRXZlbnRzKClcbn0pXG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTQwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE1KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTgpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgzODkpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg3MSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEzOCk7IiwibW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKFwiY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeVwiKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg5KTsiLCJ2YXIgY29yZSA9IHJlcXVpcmUoJy4uLy4uL2ludGVybmFscy9wYXRoJyk7XG52YXIgJEpTT04gPSBjb3JlLkpTT04gfHwgKGNvcmUuSlNPTiA9IHsgc3RyaW5naWZ5OiBKU09OLnN0cmluZ2lmeSB9KTtcblxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiBzdHJpbmdpZnkoaXQpIHsgLy8gZXNsaW50LWRpc2FibGUtbGluZSBuby11bnVzZWQtdmFyc1xuICByZXR1cm4gJEpTT04uc3RyaW5naWZ5LmFwcGx5KCRKU09OLCBhcmd1bWVudHMpO1xufTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNik7IiwibW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKCcuLi8uLi9lcy9qc29uL3N0cmluZ2lmeScpO1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEzNSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDcwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjYxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNDEpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNzApOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg3Nyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDApOyIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==