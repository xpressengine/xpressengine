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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(444);

/***/ }),

/***/ "./core/permission/permission.js":
/*!***************************************!*\
  !*** ./core/permission/permission.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.array.join.js */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.regexp.constructor.js */ "./node_modules/core-js/modules/es.regexp.constructor.js");
/* harmony import */ var core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.regexp.to-string.js */ "./node_modules/core-js/modules/es.regexp.to-string.js");
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/trim */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/map */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/concat */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/splice */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/json/stringify */ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_15__);
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! xe */ "./core/index.js");
















 // TODO:: mouseover,

var Keys = {
  ENTER: 13,
  TAB: 9,
  BACKSPACE: 8,
  UP_ARROW: 38,
  DOWN_ARROW: 40,
  ESCAPE: 27
};

var Permission = /*#__PURE__*/function () {
  function Permission(_ref) {
    var $wrapper = _ref.$wrapper,
        key = _ref.key,
        userSearchUrl = _ref.userSearchUrl,
        groupSearchUrl = _ref.groupSearchUrl,
        permission = _ref.permission,
        type = _ref.type,
        vgroupAll = _ref.vgroupAll;

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, Permission);

    this.$wrapper = $wrapper;
    this.key = key;
    this.userSearchUrl = userSearchUrl;
    this.groupSearchUrl = groupSearchUrl;
    this.permission = permission;
    this.type = type;
    this.vgroupAll = vgroupAll;
    this.query = '';
    this.suggestion = [];
    this.placeholder = xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::explainIncludeUserOrGroup');
    this.selectedIndex = '';
    this.includeSelectedIndex = -1;
    this.excludeSelectedIndex = -1;
    this.MIN_QUERY_LENGTH = 2;
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(Permission, [{
    key: "bindEvents",
    value: function bindEvents() {
      var _context11, _context12;

      var _this = this;

      this.$wrapper.on('change', '.chkModeAble', function (e) {
        var $target = jquery__WEBPACK_IMPORTED_MODULE_15___default()(e.target);
        var checked = $target.is(':checked');

        if (checked) {
          var _context;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context = _this.$wrapper).call(_context, 'input:not(.chkModeAble)').prop('disabled', true);
        } else {
          var _context2;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context2 = _this.$wrapper).call(_context2, 'input:not(.chkModeAble)').prop('disabled', false);
        }
      });
      this.$wrapper.on('keydown', '.inputUserGroup', function (e) {
        var _context3, _context4;

        var query = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default()(_context3 = e.target.value).call(_context3);

        var $this = jquery__WEBPACK_IMPORTED_MODULE_15___default()(this);
        var keyCode = e.keyCode;

        var $ul = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context4 = $this.parent()).call(_context4, '.ReactTags__suggestions ul');

        var dataInput = $this.data('input'); // include, exclude

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          if ($ul.length > 0) {
            var index = parseInt($this.data('index'), 10);
            var focusedIndex = 0;

            switch (keyCode) {
              case Keys.UP_ARROW:
                if (index == 0) {
                  focusedIndex = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()($ul).call($ul, 'li').length - 1;
                } else {
                  focusedIndex = index - 1;
                }

                $this.data('index', focusedIndex);

                _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()($ul).call($ul, 'li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;

              case Keys.DOWN_ARROW:
                if (index == _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()($ul).call($ul, 'li').length - 1) {
                  focusedIndex = 0;
                } else {
                  focusedIndex = index + 1;
                }

                $this.data('index', focusedIndex);

                _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()($ul).call($ul, 'li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;

              case Keys.ENTER:
              case Keys.TAB:
                e.preventDefault();

                if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()($ul).call($ul, 'li.active').length > 0) {
                  var _context5;

                  var tag = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()($ul).call($ul, 'li.active').data('tag');

                  var name = '';
                  var pType = '';
                  var prefix = ''; // user

                  if ($ul.data('target') === 'user') {
                    // include
                    if (dataInput === 'include') {
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
                    pTypes.forEach(function (type, i) {
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

                  var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11___default()(_context5 = _this.permission[pType]).call(_context5, function (tag) {
                    return tag.id;
                  });

                  if (!bSameWord) {
                    var _context6, _context7, _context8, _context9;

                    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context6 = $ul.closest('.ReactTags__tags')).call(_context6, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default()(_context7 = ids.join()).call(_context7));

                    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context8 = $ul.closest('.ReactTags__tags')).call(_context8, '.' + pType + 'Wrap').append(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context9 = "<span class=\"ReactTags__tag\">".concat(prefix + (tag.display_name || tag.name), "<a class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context9, tag.id, "\">x</a></span>"));
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

            var $tag = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context10 = $this.closest('.ReactTags__tags')).call(_context10, '.ReactTags__selected span');

            if (!query && $tag.length > 0) {
              _this.removeTag($tag.eq($tag.length - 1));
            }
          }
        }
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context11 = this.$wrapper).call(_context11, '.ReactTags__suggestions').on('mouseenter', 'li', function () {
        var $this = jquery__WEBPACK_IMPORTED_MODULE_15___default()(this);
        $this.addClass('active').siblings().removeClass('active');
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context12 = this.$wrapper).call(_context12, '.ReactTags__suggestions').on('click', 'li', function () {
        var _context13, _context14;

        var $this = jquery__WEBPACK_IMPORTED_MODULE_15___default()(this);
        var tag = $this.data('tag');
        var $ul = $this.closest('ul');

        var $input = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context13 = $this.closest('.ReactTags__tagInput')).call(_context13, 'input:text');

        var dataInput = $input.data('input');
        var name = '';
        var pType = '';
        var prefix = '';

        if ($ul.data('target') === 'user') {
          // include
          if (dataInput === 'include') {
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
          pTypes.forEach(function (type, i) {
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

        var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11___default()(_context14 = _this.permission[pType]).call(_context14, function (tag) {
          return tag.id;
        });

        if (!bSameWord) {
          var _context15, _context16, _context17, _context18;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context15 = $ul.closest('.ReactTags__tags')).call(_context15, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default()(_context16 = ids.join()).call(_context16));

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context17 = $ul.closest('.ReactTags__tags')).call(_context17, '.' + pType + 'Wrap').append(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context18 = "<span class=\"ReactTags__tag\">".concat(prefix + (tag.display_name || tag.name), "<a class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context18, tag.id, "\">x</a></span>"));
        }

        $ul.remove();
        $input.val('').data('index', -1).focus();
      });

      this.$wrapper.on('keyup', '.inputUserGroup', function (e) {
        var _context19;

        var query = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default()(_context19 = e.target.value).call(_context19);

        var $this = jquery__WEBPACK_IMPORTED_MODULE_15___default()(this);
        var keyCode = e.keyCode;

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          if ([Keys.ENTER, Keys.TAB, Keys.UP_ARROW, Keys.DOWN_ARROW, Keys.ESCAPE, 37, 39].indexOf(keyCode) == -1) {
            var _context20;

            var temp = '';
            temp += "<ul>";
            temp += "<li>Searching ... <span class=\"spinner\" role=\"spinner\"><span class=\"spinner-icon\"></span></span></li>";
            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context20 = $this.parent()).call(_context20, '.ReactTags__suggestions').html(temp);

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
          var _context21;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context21 = $this.parent()).call(_context21, '.ReactTags__suggestions').empty();
        }
      });
      this.$wrapper.on('click', '.btnRemoveTag', function (e) {
        e.preventDefault();

        _this.removeTag(jquery__WEBPACK_IMPORTED_MODULE_15___default()(this).closest('span'));
      });
    }
  }, {
    key: "makeIt",
    value: function makeIt(item, query) {
      var escapedRegex = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default()(query).call(query).replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');

      var r = RegExp(escapedRegex, 'gi');
      var itemName = item.display_name || item.name;
      return itemName.replace(r, '<mark>$&</mark>');
    }
  }, {
    key: "removeTag",
    value: function removeTag($target) {
      var _context23, _context24, _context25;

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
      pTypes.forEach(function (type, i) {
        if (type.id !== id) {
          var _context22;

          _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_13___default()(_context22 = _this.permission[pType]).call(_context22, i, 1); // .push(tag);

        }
      });

      var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11___default()(_context23 = _this.permission[pType]).call(_context23, function (tag) {
        return tag.id;
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context24 = $target.closest('.ReactTags__tags')).call(_context24, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default()(_context25 = ids.join()).call(_context25));

      $target.remove();
    }
  }, {
    key: "searchUser",
    value: function searchUser($input, keyword) {
      var _this = this;

      var searchUserUrl = _this.userSearchUrl;
      xe__WEBPACK_IMPORTED_MODULE_16__["default"].ajax({
        url: searchUserUrl + '/' + keyword,
        method: 'get',
        dataType: 'json',
        cache: false,
        success: function success(data) {
          if (data.length > 0) {
            var _context26;

            var temp = '';
            temp += "<ul data-target=\"user\">";
            data.forEach(function (item, i) {
              temp += "<li class=\"\" data-tag='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_14___default()(item), "'>");
              temp += "<span>".concat(_this.makeIt(item, keyword), "</span>");
              temp += "</li>";
            });
            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context26 = $input.parent()).call(_context26, '.ReactTags__suggestions').html(temp);
          } else {
            var _context27;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context27 = $input.parent()).call(_context27, '.ReactTags__suggestions').empty();
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
      xe__WEBPACK_IMPORTED_MODULE_16__["default"].ajax({
        url: searchGroupUrl + '/' + keyword,
        method: 'get',
        dataType: 'json',
        cache: false,
        success: function success(data) {
          // TODO:: view renderin
          if (data.length > 0) {
            var _context28;

            var temp = '';
            temp += "<ul data-target=\"group\">";
            data.forEach(function (item, i) {
              temp += "<li data-tag='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_14___default()(item), "'>");
              temp += "<span>".concat(_this.makeIt(item, keyword), "</span>");
              temp += "</li>";
            });
            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context28 = $input.parent()).call(_context28, '.ReactTags__suggestions').html(temp);
          } else {
            var _context29;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_9___default()(_context29 = $input.parent()).call(_context29, '.ReactTags__suggestions').empty();
          }
        },
        error: function error(xhr, status, err) {}
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _context30, _context31, _context32, _context41, _context42, _context43, _context44, _context45, _context46, _context53, _context54;

      var _this = this;

      var mode = this.permission.mode;
      var rating = this.permission.rating;
      var modeEnable = false;
      var permissionTypes = [{
        value: 'super',
        name: xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::userRatingAdministrator')
      }, {
        value: 'manager',
        name: xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::userRatingManager')
      }, {
        value: 'user',
        name: xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::user')
      }, {
        value: 'guest',
        name: xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::guest')
      }];
      var disabled = false;

      if (mode === 'manual' || mode === 'inherit') {
        modeEnable = true;

        if (mode !== 'manual') {
          disabled = true;
        }
      }

      var includeGroups = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11___default()(_context30 = this.permission.group).call(_context30, function (group) {
        return group.id;
      });

      var includeUsers = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11___default()(_context31 = this.permission.user).call(_context31, function (user) {
        return user.id;
      });

      var excludeUsers = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11___default()(_context32 = this.permission.except).call(_context32, function (user) {
        return user.id;
      });

      var temp = '';
      temp += "<div>";

      if (modeEnable) {
        var _context33, _context34;

        var checked = mode === 'inherit' ? 'checked="checked"' : '';
        temp += "<div class=\"form-group\">";
        temp += "<div class=\"checkbox\">";
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context33 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context34 = "<label><input type=\"checkbox\" name=\"".concat(this.type + 'Mode', "\" class=\"chkModeAble\" value=\"inherit\" ")).call(_context34, checked, " /> ")).call(_context33, xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::inheritMode'), "</label>");
        temp += "</div>";
        temp += "</div>";
      }

      temp += "<div class=\"form-group\">";
      temp += "<label>\uD68C\uC6D0 \uB4F1\uAE09</label>";
      temp += '<div class="radio">';
      permissionTypes.forEach(function (permissionType) {
        var _context35, _context36, _context37, _context38;

        var checked = permissionType.value == rating ? 'checked' : '';
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context35 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context36 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context37 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context38 = "<label><input type=\"radio\" ".concat(disabled ? 'disabled="disabled"' : '', " name=\"")).call(_context38, _this.type + 'Rating', "\" value=\"")).call(_context37, permissionType.value, "\" ")).call(_context36, checked ? 'checked="checked"' : '', " /> ")).call(_context35, permissionType.name, " &nbsp;</label>");
      });
      temp += "</div>";
      temp += "</div>";
      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::includeUserOrGroup'), "</label>");
      temp += "<div class=\"ReactTags__tags\">";
      temp += "<div class=\"ReactTags__selected groupWrap\" data-ptype=\"group\">";
      this.permission.group.forEach(function (g) {
        var _context39;

        var tag = g;
        var label = '%' + (tag.display_name || tag.name);
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context39 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context39, tag.id, "\">x</a></span>");
      });
      temp += '</div>';
      temp += '<div class="ReactTags__selected userWrap" data-ptype="user">';
      this.permission.user.forEach(function (tag) {
        var _context40;

        var label = '@' + (tag.display_name || tag.name);
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context40 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context40, tag.id, "|\">x</a></span>");
      });
      temp += "</div>";
      temp += "<div class=\"ReactTags__tagInput\">";
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context41 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context42 = "<input type=\"text\" placeholder=\"".concat(this.placeholder, "\" class=\"form-control inputUserGroup\" data-input=\"include\" ")).call(_context42, disabled ? 'disabled="disabled"' : '', " value=\"")).call(_context41, this.query, "\" data-index=\"-1\" />"); // TODO:: PermissionInclude handleKeyDown

      temp += "<div class=\"ReactTags__suggestions\" data-input=\"include\"></div>";
      temp += "</div>"; // ReactTags__tagInput

      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context43 = "<input type=\"hidden\" name=\"".concat(this.type + 'Group', "\" class=\"form-control includeGroups\" value=\"")).call(_context43, _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default()(_context44 = includeGroups.join()).call(_context44), "\" />");
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context45 = "<input type=\"hidden\" name=\"".concat(this.type + 'User', "\" class=\"form-control includeUsers\" value=\"")).call(_context45, _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_10___default()(_context46 = includeUsers.join()).call(_context46), "\" />");
      temp += "</div>"; // ReactTags__tags

      temp += "</div>"; // form-group

      if (this.vgroupAll.length >= 1) {
        var _context47;

        temp += "<div class=\"form-group\">";
        temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::includeVGroup'), "</label>");
        temp += _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_11___default()(_context47 = _this.vgroupAll).call(_context47, function (data) {
          var _context48, _context49, _context50, _context51;

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

          return _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context48 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context49 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context50 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context51 = "<label><input type=\"checkbox\" ".concat(disabled ? 'disabled="disabled"' : '', " name=\"")).call(_context51, _this.type + 'VGroup[]', "\" value=\"")).call(_context50, data.id, "\" ")).call(_context49, checked ? 'checked="checked"' : '', " /> ")).call(_context48, data.title, " &nbsp;</label>");
        });
        temp += '</div>';
      }

      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::excludeUser'), "</label>");
      temp += "<div class=\"ReactTags__tags\">";
      temp += "<div class=\"ReactTags__selected exceptWrap\" data-ptype=\"except\">";
      this.permission.except.forEach(function (tag) {
        var _context52;

        var label = tag.display_name || tag.name;
        label = '@' + label;
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context52 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context52, tag.id, "\">x</a></span>");
      });
      temp += "</div>";
      temp += "<div class=\"ReactTags__tagInput\">";
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context53 = "<input type=\"text\" placeholder=\"".concat(xe__WEBPACK_IMPORTED_MODULE_16__["default"].Lang.trans('xe::explainExcludeUser'), "\" class=\"form-control inputUserGroup\" data-input=\"exclude\" ")).call(_context53, disabled ? 'disabled="disabled"' : '', " data-index=\"-1\" />"); // TODO:: PermissionExclude handleKeyDown

      temp += "<div class=\"ReactTags__suggestions\" data-input=\"exclude\"></div>";
      temp += "</div>"; // ReactTags__tagInput

      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_12___default()(_context54 = "<input type=\"hidden\" name=\"".concat(this.type + 'Except', "\" class=\"form-control excludeUsers\" value=\"")).call(_context54, excludeUsers, "\" />");
      temp += "</div>"; // ReactTags__tags

      temp += "</div>"; // form-group

      temp += "</div>";
      this.$wrapper.html(temp);
    }
  }]);

  return Permission;
}();

jquery__WEBPACK_IMPORTED_MODULE_15___default()('.__xe__uiobject_permission').each(function (i) {
  var $this = jquery__WEBPACK_IMPORTED_MODULE_15___default()(this);
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(135);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(5);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js":
/*!************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(402);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(69);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(88);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! core-js-pure/stable/json/stringify */ "./node_modules/core-js-pure/stable/json/stringify.js");

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

/***/ "./node_modules/core-js-pure/es/json/stringify.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js-pure/es/json/stringify.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../../modules/es.json.stringify */ "./node_modules/core-js-pure/modules/es.json.stringify.js");
var core = __webpack_require__(/*! ../../internals/path */ "./node_modules/core-js-pure/internals/path.js");

// eslint-disable-next-line es/no-json -- safe
if (!core.JSON) core.JSON = { stringify: JSON.stringify };

// eslint-disable-next-line no-unused-vars -- required for `.length`
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(10);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/fails.js":
/*!**************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/fails.js from dll-reference _xe_dll_common ***!
  \**************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(20);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/get-built-in.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/get-built-in.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(50);

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
  // `JSON.stringify` method
  // https://tc39.es/ecma262/#sec-json.stringify
  // https://github.com/tc39/proposal-well-formed-stringify
  $({ target: 'JSON', stat: true, forced: FORCED }, {
    // eslint-disable-next-line no-unused-vars -- required for `.length`
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

/***/ "./node_modules/core-js/modules/es.regexp.constructor.js":
/*!***********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.constructor.js from dll-reference _xe_dll_common ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(260);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.exec.js":
/*!****************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.exec.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(35);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(165);

/***/ }),

/***/ "./node_modules/core-js/modules/es.string.replace.js":
/*!*******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.string.replace.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(75);

/***/ }),

/***/ "./node_modules/core-js/modules/web.dom-collections.for-each.js":
/*!******************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/web.dom-collections.for-each.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(58);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL2NvcmUvcGVybWlzc2lvbi9wZXJtaXNzaW9uLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9jb25jYXQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9maW5kLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvbWFwLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2Uvc3BsaWNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvdHJpbS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvanNvbi9zdHJpbmdpZnkuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvY2xhc3NDYWxsQ2hlY2suanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NyZWF0ZUNsYXNzLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2VzL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9leHBvcnQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9mYWlscy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvaW50ZXJuYWxzL2dldC1idWlsdC1pbi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvaW50ZXJuYWxzL3BhdGguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvbW9kdWxlcy9lcy5qc29uLnN0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5hcnJheS5qb2luLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5mdW5jdGlvbi5uYW1lLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5yZWdleHAuY29uc3RydWN0b3IuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLnJlZ2V4cC5leGVjLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5yZWdleHAudG8tc3RyaW5nLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5zdHJpbmcucmVwbGFjZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvd2ViLmRvbS1jb2xsZWN0aW9ucy5mb3ItZWFjaC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9qcXVlcnkvc3JjL2pxdWVyeS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2V4dGVybmFsIFwiX3hlX2RsbF9jb21tb25cIiJdLCJuYW1lcyI6WyJLZXlzIiwiRU5URVIiLCJUQUIiLCJCQUNLU1BBQ0UiLCJVUF9BUlJPVyIsIkRPV05fQVJST1ciLCJFU0NBUEUiLCJQZXJtaXNzaW9uIiwiJHdyYXBwZXIiLCJrZXkiLCJ1c2VyU2VhcmNoVXJsIiwiZ3JvdXBTZWFyY2hVcmwiLCJwZXJtaXNzaW9uIiwidHlwZSIsInZncm91cEFsbCIsInF1ZXJ5Iiwic3VnZ2VzdGlvbiIsInBsYWNlaG9sZGVyIiwiWEUiLCJMYW5nIiwidHJhbnMiLCJzZWxlY3RlZEluZGV4IiwiaW5jbHVkZVNlbGVjdGVkSW5kZXgiLCJleGNsdWRlU2VsZWN0ZWRJbmRleCIsIk1JTl9RVUVSWV9MRU5HVEgiLCJfdGhpcyIsIm9uIiwiZSIsIiR0YXJnZXQiLCIkIiwidGFyZ2V0IiwiY2hlY2tlZCIsImlzIiwicHJvcCIsInZhbHVlIiwiJHRoaXMiLCJrZXlDb2RlIiwiJHVsIiwicGFyZW50IiwiZGF0YUlucHV0IiwiZGF0YSIsImxlbmd0aCIsImluZGV4IiwicGFyc2VJbnQiLCJmb2N1c2VkSW5kZXgiLCJlcSIsImFkZENsYXNzIiwic2libGluZ3MiLCJyZW1vdmVDbGFzcyIsInByZXZlbnREZWZhdWx0IiwidGFnIiwibmFtZSIsInBUeXBlIiwicHJlZml4IiwicFR5cGVzIiwiYlNhbWVXb3JkIiwiZm9yRWFjaCIsImkiLCJpZCIsInB1c2giLCJpZHMiLCJjbG9zZXN0IiwidmFsIiwiam9pbiIsImFwcGVuZCIsImRpc3BsYXlfbmFtZSIsInJlbW92ZSIsImZvY3VzIiwiZW1wdHkiLCIkdGFnIiwicmVtb3ZlVGFnIiwiJGlucHV0IiwiaW5kZXhPZiIsInRlbXAiLCJodG1sIiwiaWRlbnRpZmllciIsInN1YnN0ciIsInNlYXJjaFVzZXIiLCJzZWFyY2hHcm91cCIsIml0ZW0iLCJlc2NhcGVkUmVnZXgiLCJyZXBsYWNlIiwiciIsIlJlZ0V4cCIsIml0ZW1OYW1lIiwia2V5d29yZCIsInNlYXJjaFVzZXJVcmwiLCJhamF4IiwidXJsIiwibWV0aG9kIiwiZGF0YVR5cGUiLCJjYWNoZSIsInN1Y2Nlc3MiLCJtYWtlSXQiLCJlcnJvciIsInhociIsInN0YXR1cyIsImVyciIsInNlYXJjaEdyb3VwVXJsIiwibW9kZSIsInJhdGluZyIsIm1vZGVFbmFibGUiLCJwZXJtaXNzaW9uVHlwZXMiLCJkaXNhYmxlZCIsImluY2x1ZGVHcm91cHMiLCJncm91cCIsImluY2x1ZGVVc2VycyIsInVzZXIiLCJleGNsdWRlVXNlcnMiLCJleGNlcHQiLCJwZXJtaXNzaW9uVHlwZSIsImciLCJsYWJlbCIsImluQXJyYXkiLCJhcnIiLCJ2Z3JvdXAiLCJ0aXRsZSIsImVhY2giLCJwIiwicmVuZGVyIiwiYmluZEV2ZW50cyJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7UUFDdkQsaUNBQWlDLGVBQWU7UUFDaEQ7UUFDQTtRQUNBOztRQUVBO1FBQ0Esc0RBQXNELCtEQUErRDs7UUFFckg7UUFDQTs7O1FBR0E7UUFDQTs7Ozs7Ozs7Ozs7O0FDbEZBLGdIOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDQUE7Q0FHQTs7QUFFQSxJQUFNQSxJQUFJLEdBQUc7QUFDWEMsT0FBSyxFQUFFLEVBREk7QUFFWEMsS0FBRyxFQUFFLENB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QTs7Ozs7Ozs7Ozs7O0FDVEEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsUUFBUSxtQkFBTyxDQUFDLDRFQUFxQjtBQUNyQyxpQkFBaUIsbUJBQU8sQ0FBQyx3RkFBMkI7QUFDcEQsWUFBWSxtQkFBTyxDQUFDLDBFQUFvQjs7QUFFeEM7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSDs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSyw2Q0FBNkM7QUFDbEQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSDs7Ozs7Ozs7Ozs7O0FDakNBLGFBQWEsbUJBQU8sQ0FBQyxpRkFBeUI7O0FBRTlDOzs7Ozs7Ozs7Ozs7QUNGQSxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9wZXJtaXNzaW9uL3Blcm1pc3Npb24uYnVuZGxlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL3Blcm1pc3Npb24vcGVybWlzc2lvbi5qc1wiKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0NDQpOyIsImltcG9ydCAkIGZyb20gJ2pxdWVyeSdcbmltcG9ydCBYRSBmcm9tICd4ZSdcblxuLy8gVE9ETzo6IG1vdXNlb3ZlcixcblxuY29uc3QgS2V5cyA9IHtcbiAgRU5URVI6IDEzLFxuICBUQUI6IDksXG4gIEJBQ0tTUEFDRTogOCxcbiAgVVBfQVJST1c6IDM4LFxuICBET1dOX0FSUk9XOiA0MCxcbiAgRVNDQVBFOiAyN1xufVxuXG5jbGFzcyBQZXJtaXNzaW9uIHtcbiAgY29uc3RydWN0b3IgKHsgJHdyYXBwZXIsIGtleSwgdXNlclNlYXJjaFVybCwgZ3JvdXBTZWFyY2hVcmwsIHBlcm1pc3Npb24sIHR5cGUsIHZncm91cEFsbCB9KSB7XG4gICAgdGhpcy4kd3JhcHBlciA9ICR3cmFwcGVyXG4gICAgdGhpcy5rZXkgPSBrZXlcbiAgICB0aGlzLnVzZXJTZWFyY2hVcmwgPSB1c2VyU2VhcmNoVXJsXG4gICAgdGhpcy5ncm91cFNlYXJjaFVybCA9IGdyb3VwU2VhcmNoVXJsXG4gICAgdGhpcy5wZXJtaXNzaW9uID0gcGVybWlzc2lvblxuICAgIHRoaXMudHlwZSA9IHR5cGVcbiAgICB0aGlzLnZncm91cEFsbCA9IHZncm91cEFsbFxuICAgIHRoaXMucXVlcnkgPSAnJ1xuICAgIHRoaXMuc3VnZ2VzdGlvbiA9IFtdXG4gICAgdGhpcy5wbGFjZWhvbGRlciA9IFhFLkxhbmcudHJhbnMoJ3hlOjpleHBsYWluSW5jbHVkZVVzZXJPckdyb3VwJylcbiAgICB0aGlzLnNlbGVjdGVkSW5kZXggPSAnJ1xuICAgIHRoaXMuaW5jbHVkZVNlbGVjdGVkSW5kZXggPSAtMVxuICAgIHRoaXMuZXhjbHVkZVNlbGVjdGVkSW5kZXggPSAtMVxuICAgIHRoaXMuTUlOX1FVRVJZX0xFTkdUSCA9IDJcbiAgfVxuXG4gIGJpbmRFdmVudHMgKCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcblxuICAgIHRoaXMuJHdyYXBwZXIub24oJ2NoYW5nZScsICcuY2hrTW9kZUFibGUnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyICR0YXJnZXQgPSAkKGUudGFyZ2V0KVxuICAgICAgdmFyIGNoZWNrZWQgPSAkdGFyZ2V0LmlzKCc6Y2hlY2tlZCcpXG5cbiAgICAgIGlmIChjaGVja2VkKSB7XG4gICAgICAgIF90aGlzLiR3cmFwcGVyLmZpbmQoJ2lucHV0Om5vdCguY2hrTW9kZUFibGUpJykucHJvcCgnZGlzYWJsZWQnLCB0cnVlKVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgX3RoaXMuJHdyYXBwZXIuZmluZCgnaW5wdXQ6bm90KC5jaGtNb2RlQWJsZSknKS5wcm9wKCdkaXNhYmxlZCcsIGZhbHNlKVxuICAgICAgfVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLm9uKCdrZXlkb3duJywgJy5pbnB1dFVzZXJHcm91cCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgcXVlcnkgPSBlLnRhcmdldC52YWx1ZS50cmltKClcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgIHZhciBrZXlDb2RlID0gZS5rZXlDb2RlXG4gICAgICB2YXIgJHVsID0gJHRoaXMucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMgdWwnKVxuICAgICAgdmFyIGRhdGFJbnB1dCA9ICR0aGlzLmRhdGEoJ2lucHV0JykgLy8gaW5jbHVkZSwgZXhjbHVkZVxuXG4gICAgICBpZiAocXVlcnkubGVuZ3RoID49IF90aGlzLk1JTl9RVUVSWV9MRU5HVEgpIHtcbiAgICAgICAgaWYgKCR1bC5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgdmFyIGluZGV4ID0gcGFyc2VJbnQoJHRoaXMuZGF0YSgnaW5kZXgnKSwgMTApXG4gICAgICAgICAgdmFyIGZvY3VzZWRJbmRleCA9IDBcblxuICAgICAgICAgIHN3aXRjaCAoa2V5Q29kZSkge1xuICAgICAgICAgICAgY2FzZSBLZXlzLlVQX0FSUk9XIDpcbiAgICAgICAgICAgICAgaWYgKGluZGV4ID09IDApIHtcbiAgICAgICAgICAgICAgICBmb2N1c2VkSW5kZXggPSAkdWwuZmluZCgnbGknKS5sZW5ndGggLSAxXG4gICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgZm9jdXNlZEluZGV4ID0gKGluZGV4IC0gMSlcbiAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICR0aGlzLmRhdGEoJ2luZGV4JywgZm9jdXNlZEluZGV4KVxuICAgICAgICAgICAgICAkdWwuZmluZCgnbGknKS5lcShmb2N1c2VkSW5kZXgpLmFkZENsYXNzKCdhY3RpdmUnKS5zaWJsaW5ncygpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKVxuXG4gICAgICAgICAgICAgIGJyZWFrXG4gICAgICAgICAgICBjYXNlIEtleXMuRE9XTl9BUlJPVyA6XG4gICAgICAgICAgICAgIGlmIChpbmRleCA9PSAkdWwuZmluZCgnbGknKS5sZW5ndGggLSAxKSB7XG4gICAgICAgICAgICAgICAgZm9jdXNlZEluZGV4ID0gMFxuICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgIGZvY3VzZWRJbmRleCA9IGluZGV4ICsgMVxuICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgJHRoaXMuZGF0YSgnaW5kZXgnLCBmb2N1c2VkSW5kZXgpXG4gICAgICAgICAgICAgICR1bC5maW5kKCdsaScpLmVxKGZvY3VzZWRJbmRleCkuYWRkQ2xhc3MoJ2FjdGl2ZScpLnNpYmxpbmdzKCkucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpXG5cbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICAgIGNhc2UgS2V5cy5FTlRFUiA6XG4gICAgICAgICAgICBjYXNlIEtleXMuVEFCIDpcbiAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgICAgICAgICAgaWYgKCR1bC5maW5kKCdsaS5hY3RpdmUnKS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRhZyA9ICR1bC5maW5kKCdsaS5hY3RpdmUnKS5kYXRhKCd0YWcnKVxuICAgICAgICAgICAgICAgIHZhciBuYW1lID0gJydcbiAgICAgICAgICAgICAgICB2YXIgcFR5cGUgPSAnJ1xuICAgICAgICAgICAgICAgIHZhciBwcmVmaXggPSAnJ1xuXG4gICAgICAgICAgICAgICAgLy8gdXNlclxuICAgICAgICAgICAgICAgIGlmICgkdWwuZGF0YSgndGFyZ2V0JykgPT09ICd1c2VyJykge1xuICAgICAgICAgICAgICAgICAgLy8gaW5jbHVkZVxuICAgICAgICAgICAgICAgICAgaWYgKGRhdGFJbnB1dCA9PT0gJ2luY2x1ZGUnKSB7XG4gICAgICAgICAgICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ1VzZXInXG4gICAgICAgICAgICAgICAgICAgIHBUeXBlID0gJ3VzZXInXG4gICAgICAgICAgICAgICAgICAgIHByZWZpeCA9ICdAJ1xuICAgICAgICAgICAgICAgICAgICAvLyBleGNsdWRlXG4gICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdFeGNlcHQnXG4gICAgICAgICAgICAgICAgICAgIHBUeXBlID0gJ2V4Y2VwdCdcbiAgICAgICAgICAgICAgICAgICAgcHJlZml4ID0gJ0AnXG4gICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAvLyBncm91cFxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdHcm91cCdcbiAgICAgICAgICAgICAgICAgIHBUeXBlID0gJ2dyb3VwJ1xuICAgICAgICAgICAgICAgICAgcHJlZml4ID0gJyUnXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgdmFyIHBUeXBlcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdXG4gICAgICAgICAgICAgICAgdmFyIGJTYW1lV29yZCA9IGZhbHNlXG5cbiAgICAgICAgICAgICAgICBpZiAocFR5cGVzLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICAgICAgIHBUeXBlcy5mb3JFYWNoKGZ1bmN0aW9uICh0eXBlLCBpKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmICh0eXBlLmlkID09PSB0YWcuaWQpIHtcbiAgICAgICAgICAgICAgICAgICAgICBiU2FtZVdvcmQgPSB0cnVlXG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgIH0pXG5cbiAgICAgICAgICAgICAgICAgIGlmICghYlNhbWVXb3JkKSB7XG4gICAgICAgICAgICAgICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnB1c2godGFnKVxuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5wdXNoKHRhZylcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB2YXIgaWRzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV0ubWFwKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgICAgICAgICAgICAgIHJldHVybiB0YWcuaWRcbiAgICAgICAgICAgICAgICB9KVxuXG4gICAgICAgICAgICAgICAgaWYgKCFiU2FtZVdvcmQpIHtcbiAgICAgICAgICAgICAgICAgICR1bC5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnW25hbWU9JyArIG5hbWUgKyAnXScpLnZhbChpZHMuam9pbigpLnRyaW0oKSlcbiAgICAgICAgICAgICAgICAgICR1bC5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnLicgKyBwVHlwZSArICdXcmFwJylcbiAgICAgICAgICAgICAgICAgICAgLmFwcGVuZChgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7cHJlZml4ICsgKHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWUpfTxhIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfVwiPng8L2E+PC9zcGFuPmApXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgJHVsLnJlbW92ZSgpXG4gICAgICAgICAgICAgICAgJHRoaXMudmFsKCcnKS5kYXRhKCdpbmRleCcsIC0xKS5mb2N1cygpXG4gICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCkgLy8gcHJldmVudCB0YWJcblxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgICAgY2FzZSBLZXlzLkVTQ0FQRSA6XG4gICAgICAgICAgICAgIF90aGlzW2RhdGFJbnB1dCArICdTZWxlY3RlZEluZGV4J10gPSAwXG4gICAgICAgICAgICAgICR1bC5wYXJlbnQoKS5lbXB0eSgpXG4gICAgICAgICAgICAgICR0aGlzLmZvY3VzKClcbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIGlmIChLZXlzLkJBQ0tTUEFDRSA9PT0ga2V5Q29kZSkge1xuICAgICAgICAgIHZhciAkdGFnID0gJHRoaXMuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJy5SZWFjdFRhZ3NfX3NlbGVjdGVkIHNwYW4nKVxuICAgICAgICAgIGlmICghcXVlcnkgJiYgJHRhZy5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICBfdGhpcy5yZW1vdmVUYWcoJHRhZy5lcSgkdGFnLmxlbmd0aCAtIDEpKVxuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykub24oJ21vdXNlZW50ZXInLCAnbGknLCBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG5cbiAgICAgICR0aGlzLmFkZENsYXNzKCdhY3RpdmUnKS5zaWJsaW5ncygpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykub24oJ2NsaWNrJywgJ2xpJywgZnVuY3Rpb24gKCkge1xuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyIHRhZyA9ICR0aGlzLmRhdGEoJ3RhZycpXG4gICAgICB2YXIgJHVsID0gJHRoaXMuY2xvc2VzdCgndWwnKVxuICAgICAgdmFyICRpbnB1dCA9ICR0aGlzLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ0lucHV0JykuZmluZCgnaW5wdXQ6dGV4dCcpXG4gICAgICB2YXIgZGF0YUlucHV0ID0gJGlucHV0LmRhdGEoJ2lucHV0JylcbiAgICAgIHZhciBuYW1lID0gJydcbiAgICAgIHZhciBwVHlwZSA9ICcnXG4gICAgICB2YXIgcHJlZml4ID0gJydcblxuICAgICAgaWYgKCR1bC5kYXRhKCd0YXJnZXQnKSA9PT0gJ3VzZXInKSB7XG4gICAgICAgIC8vIGluY2x1ZGVcbiAgICAgICAgaWYgKGRhdGFJbnB1dCA9PT0gJ2luY2x1ZGUnKSB7XG4gICAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnVXNlcidcbiAgICAgICAgICBwVHlwZSA9ICd1c2VyJ1xuICAgICAgICAgIHByZWZpeCA9ICdAJ1xuICAgICAgICAgIC8vIGV4Y2x1ZGVcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdFeGNlcHQnXG4gICAgICAgICAgcFR5cGUgPSAnZXhjZXB0J1xuICAgICAgICAgIHByZWZpeCA9ICdAJ1xuICAgICAgICB9XG4gICAgICAgIC8vIGdyb3VwXG4gICAgICB9IGVsc2Uge1xuICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdHcm91cCdcbiAgICAgICAgcFR5cGUgPSAnZ3JvdXAnXG4gICAgICAgIHByZWZpeCA9ICclJ1xuICAgICAgfVxuXG4gICAgICB2YXIgcFR5cGVzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV1cbiAgICAgIHZhciBiU2FtZVdvcmQgPSBmYWxzZVxuXG4gICAgICBpZiAocFR5cGVzLmxlbmd0aCA+IDApIHtcbiAgICAgICAgcFR5cGVzLmZvckVhY2goZnVuY3Rpb24gKHR5cGUsIGkpIHtcbiAgICAgICAgICBpZiAodHlwZS5pZCA9PT0gdGFnLmlkKSB7XG4gICAgICAgICAgICBiU2FtZVdvcmQgPSB0cnVlXG4gICAgICAgICAgfVxuICAgICAgICB9KVxuXG4gICAgICAgIGlmICghYlNhbWVXb3JkKSB7XG4gICAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0ucHVzaCh0YWcpXG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnB1c2godGFnKVxuICAgICAgfVxuXG4gICAgICB2YXIgaWRzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV0ubWFwKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgICAgcmV0dXJuIHRhZy5pZFxuICAgICAgfSlcblxuICAgICAgaWYgKCFiU2FtZVdvcmQpIHtcbiAgICAgICAgJHVsLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCdbbmFtZT0nICsgbmFtZSArICddJykudmFsKGlkcy5qb2luKCkudHJpbSgpKVxuICAgICAgICAkdWwuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJy4nICsgcFR5cGUgKyAnV3JhcCcpXG4gICAgICAgICAgLmFwcGVuZChgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7cHJlZml4ICsgKHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWUpfTxhIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfVwiPng8L2E+PC9zcGFuPmApXG4gICAgICB9XG5cbiAgICAgICR1bC5yZW1vdmUoKVxuICAgICAgJGlucHV0LnZhbCgnJykuZGF0YSgnaW5kZXgnLCAtMSkuZm9jdXMoKVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLm9uKCdrZXl1cCcsICcuaW5wdXRVc2VyR3JvdXAnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyIHF1ZXJ5ID0gZS50YXJnZXQudmFsdWUudHJpbSgpXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIga2V5Q29kZSA9IGUua2V5Q29kZVxuXG4gICAgICBpZiAocXVlcnkubGVuZ3RoID49IF90aGlzLk1JTl9RVUVSWV9MRU5HVEgpIHtcbiAgICAgICAgaWYgKFtLZXlzLkVOVEVSLCBLZXlzLlRBQiwgS2V5cy5VUF9BUlJPVywgS2V5cy5ET1dOX0FSUk9XLCBLZXlzLkVTQ0FQRSwgMzcsIDM5XS5pbmRleE9mKGtleUNvZGUpID09IC0xKSB7XG4gICAgICAgICAgdmFyIHRlbXAgPSAnJ1xuICAgICAgICAgIHRlbXAgKz0gYDx1bD5gXG4gICAgICAgICAgdGVtcCArPSBgPGxpPlNlYXJjaGluZyAuLi4gPHNwYW4gY2xhc3M9XCJzcGlubmVyXCIgcm9sZT1cInNwaW5uZXJcIj48c3BhbiBjbGFzcz1cInNwaW5uZXItaWNvblwiPjwvc3Bhbj48L3NwYW4+PC9saT5gXG4gICAgICAgICAgdGVtcCArPSBgPC91bD5gXG5cbiAgICAgICAgICAkdGhpcy5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmh0bWwodGVtcClcblxuICAgICAgICAgIHZhciBpZGVudGlmaWVyID0gcXVlcnkuc3Vic3RyKDAsIDEpXG4gICAgICAgICAgc3dpdGNoIChpZGVudGlmaWVyKSB7XG4gICAgICAgICAgICBjYXNlICdAJzpcbiAgICAgICAgICAgICAgcXVlcnkgPSBxdWVyeS5zdWJzdHIoMSwgcXVlcnkubGVuZ3RoKVxuICAgICAgICAgICAgICBfdGhpcy5zZWFyY2hVc2VyKCR0aGlzLCBxdWVyeSlcbiAgICAgICAgICAgICAgYnJlYWtcblxuICAgICAgICAgICAgY2FzZSAnJSc6XG4gICAgICAgICAgICAgIHF1ZXJ5ID0gcXVlcnkuc3Vic3RyKDEsIHF1ZXJ5Lmxlbmd0aClcbiAgICAgICAgICAgICAgX3RoaXMuc2VhcmNoR3JvdXAoJHRoaXMsIHF1ZXJ5KVxuICAgICAgICAgICAgICBicmVha1xuXG4gICAgICAgICAgICBkZWZhdWx0IDpcbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSB7XG4gICAgICAgICR0aGlzLnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuZW1wdHkoKVxuICAgICAgfVxuICAgIH0pXG5cbiAgICB0aGlzLiR3cmFwcGVyLm9uKCdjbGljaycsICcuYnRuUmVtb3ZlVGFnJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICBfdGhpcy5yZW1vdmVUYWcoJCh0aGlzKS5jbG9zZXN0KCdzcGFuJykpXG4gICAgfSlcbiAgfVxuXG4gIG1ha2VJdCAoaXRlbSwgcXVlcnkpIHtcbiAgICB2YXIgZXNjYXBlZFJlZ2V4ID0gcXVlcnkudHJpbSgpLnJlcGxhY2UoL1stXFxcXF4kKis/LigpfFtcXF17fV0vZywgJ1xcXFwkJicpXG4gICAgdmFyIHIgPSBSZWdFeHAoZXNjYXBlZFJlZ2V4LCAnZ2knKVxuICAgIHZhciBpdGVtTmFtZSA9IGl0ZW0uZGlzcGxheV9uYW1lIHx8IGl0ZW0ubmFtZVxuXG4gICAgcmV0dXJuIGl0ZW1OYW1lLnJlcGxhY2UociwgJzxtYXJrPiQmPC9tYXJrPicpXG4gIH1cblxuICByZW1vdmVUYWcgKCR0YXJnZXQpIHtcbiAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgdmFyIHBUeXBlID0gJHRhcmdldC5jbG9zZXN0KCcuUmVhY3RUYWdzX19zZWxlY3RlZCcpLmRhdGEoJ3B0eXBlJylcbiAgICB2YXIgaWQgPSAkdGFyZ2V0LmRhdGEoJ2lkJylcbiAgICB2YXIgbmFtZSA9ICcnXG5cbiAgICBzd2l0Y2ggKHBUeXBlKSB7XG4gICAgICBjYXNlICd1c2VyJyA6XG4gICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ1VzZXInXG4gICAgICAgIGJyZWFrXG4gICAgICBjYXNlICdleGNlcHQnIDpcbiAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnRXhjZXB0J1xuICAgICAgICBicmVha1xuICAgICAgY2FzZSAnZ3JvdXAnIDpcbiAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnR3JvdXAnXG4gICAgICAgIGJyZWFrXG4gICAgfVxuXG4gICAgdmFyIHBUeXBlcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdXG5cbiAgICBwVHlwZXMuZm9yRWFjaChmdW5jdGlvbiAodHlwZSwgaSkge1xuICAgICAgaWYgKHR5cGUuaWQgIT09IGlkKSB7XG4gICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnNwbGljZShpLCAxKS8vIC5wdXNoKHRhZyk7XG4gICAgICB9XG4gICAgfSlcblxuICAgIHZhciBpZHMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5tYXAoZnVuY3Rpb24gKHRhZykge1xuICAgICAgcmV0dXJuIHRhZy5pZFxuICAgIH0pXG5cbiAgICAkdGFyZ2V0LmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCdbbmFtZT0nICsgbmFtZSArICddJykudmFsKGlkcy5qb2luKCkudHJpbSgpKVxuICAgICR0YXJnZXQucmVtb3ZlKClcbiAgfVxuXG4gIHNlYXJjaFVzZXIgKCRpbnB1dCwga2V5d29yZCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICB2YXIgc2VhcmNoVXNlclVybCA9IF90aGlzLnVzZXJTZWFyY2hVcmxcblxuICAgIFhFLmFqYXgoe1xuICAgICAgdXJsOiBzZWFyY2hVc2VyVXJsICsgJy8nICsga2V5d29yZCxcbiAgICAgIG1ldGhvZDogJ2dldCcsXG4gICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgY2FjaGU6IGZhbHNlLFxuICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgaWYgKGRhdGEubGVuZ3RoID4gMCkge1xuICAgICAgICAgIHZhciB0ZW1wID0gJydcbiAgICAgICAgICB0ZW1wICs9IGA8dWwgZGF0YS10YXJnZXQ9XCJ1c2VyXCI+YFxuXG4gICAgICAgICAgZGF0YS5mb3JFYWNoKGZ1bmN0aW9uIChpdGVtLCBpKSB7XG4gICAgICAgICAgICB0ZW1wICs9IGA8bGkgY2xhc3M9XCJcIiBkYXRhLXRhZz0nJHtKU09OLnN0cmluZ2lmeShpdGVtKX0nPmBcbiAgICAgICAgICAgIHRlbXAgKz0gYDxzcGFuPiR7X3RoaXMubWFrZUl0KGl0ZW0sIGtleXdvcmQpfTwvc3Bhbj5gXG4gICAgICAgICAgICB0ZW1wICs9IGA8L2xpPmBcbiAgICAgICAgICB9KVxuXG4gICAgICAgICAgdGVtcCArPSBgPC91bD5gXG5cbiAgICAgICAgICAkaW5wdXQucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5odG1sKHRlbXApXG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgJGlucHV0LnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuZW1wdHkoKVxuICAgICAgICB9XG4gICAgICB9LFxuICAgICAgZXJyb3I6IGZ1bmN0aW9uICh4aHIsIHN0YXR1cywgZXJyKSB7XG5cbiAgICAgIH1cbiAgICB9KVxuICB9XG5cbiAgc2VhcmNoR3JvdXAgKCRpbnB1dCwga2V5d29yZCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICB2YXIgc2VhcmNoR3JvdXBVcmwgPSBfdGhpcy5ncm91cFNlYXJjaFVybFxuXG4gICAgWEUuYWpheCh7XG4gICAgICB1cmw6IHNlYXJjaEdyb3VwVXJsICsgJy8nICsga2V5d29yZCxcbiAgICAgIG1ldGhvZDogJ2dldCcsXG4gICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgY2FjaGU6IGZhbHNlLFxuICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgLy8gVE9ETzo6IHZpZXcgcmVuZGVyaW5cbiAgICAgICAgaWYgKGRhdGEubGVuZ3RoID4gMCkge1xuICAgICAgICAgIHZhciB0ZW1wID0gJydcbiAgICAgICAgICB0ZW1wICs9IGA8dWwgZGF0YS10YXJnZXQ9XCJncm91cFwiPmBcblxuICAgICAgICAgIGRhdGEuZm9yRWFjaChmdW5jdGlvbiAoaXRlbSwgaSkge1xuICAgICAgICAgICAgdGVtcCArPSBgPGxpIGRhdGEtdGFnPScke0pTT04uc3RyaW5naWZ5KGl0ZW0pfSc+YFxuICAgICAgICAgICAgdGVtcCArPSBgPHNwYW4+JHtfdGhpcy5tYWtlSXQoaXRlbSwga2V5d29yZCl9PC9zcGFuPmBcbiAgICAgICAgICAgIHRlbXAgKz0gYDwvbGk+YFxuICAgICAgICAgIH0pXG5cbiAgICAgICAgICB0ZW1wICs9IGA8L3VsPmBcblxuICAgICAgICAgICRpbnB1dC5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmh0bWwodGVtcClcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAkaW5wdXQucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5lbXB0eSgpXG4gICAgICAgIH1cbiAgICAgIH0sXG4gICAgICBlcnJvcjogZnVuY3Rpb24gKHhociwgc3RhdHVzLCBlcnIpIHt9XG4gICAgfSlcbiAgfVxuXG4gIHJlbmRlciAoKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHZhciBtb2RlID0gdGhpcy5wZXJtaXNzaW9uLm1vZGVcbiAgICB2YXIgcmF0aW5nID0gdGhpcy5wZXJtaXNzaW9uLnJhdGluZ1xuICAgIHZhciBtb2RlRW5hYmxlID0gZmFsc2VcbiAgICB2YXIgcGVybWlzc2lvblR5cGVzID0gW1xuICAgICAgeyB2YWx1ZTogJ3N1cGVyJywgbmFtZTogWEUuTGFuZy50cmFucygneGU6OnVzZXJSYXRpbmdBZG1pbmlzdHJhdG9yJykgfSxcbiAgICAgIHsgdmFsdWU6ICdtYW5hZ2VyJywgbmFtZTogWEUuTGFuZy50cmFucygneGU6OnVzZXJSYXRpbmdNYW5hZ2VyJykgfSxcbiAgICAgIHsgdmFsdWU6ICd1c2VyJywgbmFtZTogWEUuTGFuZy50cmFucygneGU6OnVzZXInKSB9LFxuICAgICAgeyB2YWx1ZTogJ2d1ZXN0JywgbmFtZTogWEUuTGFuZy50cmFucygneGU6Omd1ZXN0JykgfVxuICAgIF1cblxuICAgIHZhciBkaXNhYmxlZCA9IGZhbHNlXG5cbiAgICBpZiAobW9kZSA9PT0gJ21hbnVhbCcgfHwgbW9kZSA9PT0gJ2luaGVyaXQnKSB7XG4gICAgICBtb2RlRW5hYmxlID0gdHJ1ZVxuICAgICAgaWYgKG1vZGUgIT09ICdtYW51YWwnKSB7XG4gICAgICAgIGRpc2FibGVkID0gdHJ1ZVxuICAgICAgfVxuICAgIH1cblxuICAgIHZhciBpbmNsdWRlR3JvdXBzID0gdGhpcy5wZXJtaXNzaW9uLmdyb3VwLm1hcChmdW5jdGlvbiAoZ3JvdXApIHtcbiAgICAgIHJldHVybiBncm91cC5pZFxuICAgIH0pXG5cbiAgICB2YXIgaW5jbHVkZVVzZXJzID0gdGhpcy5wZXJtaXNzaW9uLnVzZXIubWFwKGZ1bmN0aW9uICh1c2VyKSB7XG4gICAgICByZXR1cm4gdXNlci5pZFxuICAgIH0pXG5cbiAgICB2YXIgZXhjbHVkZVVzZXJzID0gdGhpcy5wZXJtaXNzaW9uLmV4Y2VwdC5tYXAoZnVuY3Rpb24gKHVzZXIpIHtcbiAgICAgIHJldHVybiB1c2VyLmlkXG4gICAgfSlcblxuICAgIHZhciB0ZW1wID0gJydcbiAgICB0ZW1wICs9IGA8ZGl2PmBcblxuICAgIGlmIChtb2RlRW5hYmxlKSB7XG4gICAgICB2YXIgY2hlY2tlZCA9IChtb2RlID09PSAnaW5oZXJpdCcpID8gJ2NoZWNrZWQ9XCJjaGVja2VkXCInIDogJydcblxuICAgICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiY2hlY2tib3hcIj5gXG4gICAgICB0ZW1wICs9IGA8bGFiZWw+PGlucHV0IHR5cGU9XCJjaGVja2JveFwiIG5hbWU9XCIke3RoaXMudHlwZSArICdNb2RlJ31cIiBjbGFzcz1cImNoa01vZGVBYmxlXCIgdmFsdWU9XCJpbmhlcml0XCIgJHtjaGVja2VkfSAvPiAke1hFLkxhbmcudHJhbnMoJ3hlOjppbmhlcml0TW9kZScpfTwvbGFiZWw+YFxuICAgICAgdGVtcCArPSBgPC9kaXY+YFxuICAgICAgdGVtcCArPSBgPC9kaXY+YFxuICAgIH1cblxuICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+YFxuICAgIHRlbXAgKz0gYDxsYWJlbD7tmozsm5Ag65Ox6riJPC9sYWJlbD5gXG4gICAgdGVtcCArPSAnPGRpdiBjbGFzcz1cInJhZGlvXCI+J1xuICAgIHBlcm1pc3Npb25UeXBlcy5mb3JFYWNoKGZ1bmN0aW9uIChwZXJtaXNzaW9uVHlwZSkge1xuICAgICAgdmFyIGNoZWNrZWQgPSAocGVybWlzc2lvblR5cGUudmFsdWUgPT0gcmF0aW5nKSA/ICdjaGVja2VkJyA6ICcnXG5cbiAgICAgIHRlbXAgKz0gYDxsYWJlbD48aW5wdXQgdHlwZT1cInJhZGlvXCIgJHsoZGlzYWJsZWQpID8gJ2Rpc2FibGVkPVwiZGlzYWJsZWRcIicgOiAnJ30gbmFtZT1cIiR7X3RoaXMudHlwZSArICdSYXRpbmcnfVwiIHZhbHVlPVwiJHtwZXJtaXNzaW9uVHlwZS52YWx1ZX1cIiAkeyhjaGVja2VkKSA/ICdjaGVja2VkPVwiY2hlY2tlZFwiJyA6ICcnfSAvPiAke3Blcm1pc3Npb25UeXBlLm5hbWV9ICZuYnNwOzwvbGFiZWw+YFxuICAgIH0pXG4gICAgdGVtcCArPSBgPC9kaXY+YFxuICAgIHRlbXAgKz0gYDwvZGl2PmBcbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiPmBcbiAgICB0ZW1wICs9IGA8bGFiZWw+JHtYRS5MYW5nLnRyYW5zKCd4ZTo6aW5jbHVkZVVzZXJPckdyb3VwJyl9PC9sYWJlbD5gXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnc1wiPmBcblxuICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3NlbGVjdGVkIGdyb3VwV3JhcFwiIGRhdGEtcHR5cGU9XCJncm91cFwiPmBcbiAgICB0aGlzLnBlcm1pc3Npb24uZ3JvdXAuZm9yRWFjaChmdW5jdGlvbiAoZykge1xuICAgICAgdmFyIHRhZyA9IGdcbiAgICAgIHZhciBsYWJlbCA9ICclJyArICh0YWcuZGlzcGxheV9uYW1lIHx8IHRhZy5uYW1lKVxuXG4gICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtsYWJlbH08YSBocmVmPVwiI1wiIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfVwiPng8L2E+PC9zcGFuPmBcbiAgICB9KVxuICAgIHRlbXAgKz0gJzwvZGl2PidcblxuICAgIHRlbXAgKz0gJzxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3NlbGVjdGVkIHVzZXJXcmFwXCIgZGF0YS1wdHlwZT1cInVzZXJcIj4nXG4gICAgdGhpcy5wZXJtaXNzaW9uLnVzZXIuZm9yRWFjaChmdW5jdGlvbiAodGFnKSB7XG4gICAgICB2YXIgbGFiZWwgPSAnQCcgKyAodGFnLmRpc3BsYXlfbmFtZSB8fCB0YWcubmFtZSlcblxuICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7bGFiZWx9PGEgaHJlZj1cIiNcIiBjbGFzcz1cIlJlYWN0VGFnc19fcmVtb3ZlIGJ0blJlbW92ZVRhZ1wiIGRhdGEtaWQ9XCIke3RhZy5pZH18XCI+eDwvYT48L3NwYW4+YFxuICAgIH0pXG4gICAgdGVtcCArPSBgPC9kaXY+YFxuXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnSW5wdXRcIj5gXG4gICAgdGVtcCArPSBgPGlucHV0IHR5cGU9XCJ0ZXh0XCIgcGxhY2Vob2xkZXI9XCIke3RoaXMucGxhY2Vob2xkZXJ9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgaW5wdXRVc2VyR3JvdXBcIiBkYXRhLWlucHV0PVwiaW5jbHVkZVwiICR7KGRpc2FibGVkKSA/ICdkaXNhYmxlZD1cImRpc2FibGVkXCInIDogJyd9IHZhbHVlPVwiJHt0aGlzLnF1ZXJ5fVwiIGRhdGEtaW5kZXg9XCItMVwiIC8+YCAvLyBUT0RPOjogUGVybWlzc2lvbkluY2x1ZGUgaGFuZGxlS2V5RG93blxuICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zXCIgZGF0YS1pbnB1dD1cImluY2x1ZGVcIj48L2Rpdj5gXG4gICAgdGVtcCArPSBgPC9kaXY+YCAvLyBSZWFjdFRhZ3NfX3RhZ0lucHV0XG4gICAgdGVtcCArPSBgPGlucHV0IHR5cGU9XCJoaWRkZW5cIiBuYW1lPVwiJHt0aGlzLnR5cGUgKyAnR3JvdXAnfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGluY2x1ZGVHcm91cHNcIiB2YWx1ZT1cIiR7aW5jbHVkZUdyb3Vwcy5qb2luKCkudHJpbSgpfVwiIC8+YFxuICAgIHRlbXAgKz0gYDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cIiR7dGhpcy50eXBlICsgJ1VzZXInfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGluY2x1ZGVVc2Vyc1wiIHZhbHVlPVwiJHtpbmNsdWRlVXNlcnMuam9pbigpLnRyaW0oKX1cIiAvPmBcbiAgICB0ZW1wICs9IGA8L2Rpdj5gIC8vIFJlYWN0VGFnc19fdGFnc1xuICAgIHRlbXAgKz0gYDwvZGl2PmAvLyBmb3JtLWdyb3VwXG5cbiAgICBpZiAodGhpcy52Z3JvdXBBbGwubGVuZ3RoID49IDEpIHtcbiAgICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+YFxuICAgICAgdGVtcCArPSBgPGxhYmVsPiR7WEUuTGFuZy50cmFucygneGU6OmluY2x1ZGVWR3JvdXAnKX08L2xhYmVsPmBcblxuICAgICAgdGVtcCArPSBfdGhpcy52Z3JvdXBBbGwubWFwKGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgIHZhciBjaGVja2VkID0gZmFsc2VcblxuICAgICAgICB2YXIgaW5BcnJheSA9IGZ1bmN0aW9uICh2YWwsIGFycikge1xuICAgICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgYXJyLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICBpZiAoYXJyW2ldID09IHZhbCkge1xuICAgICAgICAgICAgICByZXR1cm4gaVxuICAgICAgICAgICAgfVxuICAgICAgICAgIH1cblxuICAgICAgICAgIHJldHVybiAtMVxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKGluQXJyYXkoZGF0YS5pZCwgdGhpcy5wZXJtaXNzaW9uLnZncm91cCkgIT0gLTEpIHtcbiAgICAgICAgICBjaGVja2VkID0gdHJ1ZVxuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIGA8bGFiZWw+PGlucHV0IHR5cGU9XCJjaGVja2JveFwiICR7KGRpc2FibGVkKSA/ICdkaXNhYmxlZD1cImRpc2FibGVkXCInIDogJyd9IG5hbWU9XCIke190aGlzLnR5cGUgKyAnVkdyb3VwW10nfVwiIHZhbHVlPVwiJHtkYXRhLmlkfVwiICR7KGNoZWNrZWQpID8gJ2NoZWNrZWQ9XCJjaGVja2VkXCInIDogJyd9IC8+ICR7ZGF0YS50aXRsZX0gJm5ic3A7PC9sYWJlbD5gXG4gICAgICB9KVxuXG4gICAgICB0ZW1wICs9ICc8L2Rpdj4nXG4gICAgfVxuXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgdGVtcCArPSBgPGxhYmVsPiR7WEUuTGFuZy50cmFucygneGU6OmV4Y2x1ZGVVc2VyJyl9PC9sYWJlbD5gXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnc1wiPmBcbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX19zZWxlY3RlZCBleGNlcHRXcmFwXCIgZGF0YS1wdHlwZT1cImV4Y2VwdFwiPmBcblxuICAgIHRoaXMucGVybWlzc2lvbi5leGNlcHQuZm9yRWFjaChmdW5jdGlvbiAodGFnKSB7XG4gICAgICB2YXIgbGFiZWwgPSB0YWcuZGlzcGxheV9uYW1lIHx8IHRhZy5uYW1lXG4gICAgICBsYWJlbCA9ICdAJyArIGxhYmVsXG5cbiAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiUmVhY3RUYWdzX190YWdcIj4ke2xhYmVsfTxhIGhyZWY9XCIjXCIgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9XCI+eDwvYT48L3NwYW4+YFxuICAgIH0pXG5cbiAgICB0ZW1wICs9IGA8L2Rpdj5gXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnSW5wdXRcIj5gXG4gICAgdGVtcCArPSBgPGlucHV0IHR5cGU9XCJ0ZXh0XCIgcGxhY2Vob2xkZXI9XCIke1hFLkxhbmcudHJhbnMoJ3hlOjpleHBsYWluRXhjbHVkZVVzZXInKX1cIiBjbGFzcz1cImZvcm0tY29udHJvbCBpbnB1dFVzZXJHcm91cFwiIGRhdGEtaW5wdXQ9XCJleGNsdWRlXCIgJHsoZGlzYWJsZWQpID8gJ2Rpc2FibGVkPVwiZGlzYWJsZWRcIicgOiAnJ30gZGF0YS1pbmRleD1cIi0xXCIgLz5gIC8vIFRPRE86OiBQZXJtaXNzaW9uRXhjbHVkZSBoYW5kbGVLZXlEb3duXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc3VnZ2VzdGlvbnNcIiBkYXRhLWlucHV0PVwiZXhjbHVkZVwiPjwvZGl2PmBcbiAgICB0ZW1wICs9IGA8L2Rpdj5gIC8vIFJlYWN0VGFnc19fdGFnSW5wdXRcbiAgICB0ZW1wICs9IGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3RoaXMudHlwZSArICdFeGNlcHQnfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGV4Y2x1ZGVVc2Vyc1wiIHZhbHVlPVwiJHtleGNsdWRlVXNlcnN9XCIgLz5gXG4gICAgdGVtcCArPSBgPC9kaXY+YCAvLyBSZWFjdFRhZ3NfX3RhZ3NcbiAgICB0ZW1wICs9IGA8L2Rpdj5gLy8gZm9ybS1ncm91cFxuXG4gICAgdGVtcCArPSBgPC9kaXY+YFxuXG4gICAgdGhpcy4kd3JhcHBlci5odG1sKHRlbXApXG4gIH1cbn1cblxuJCgnLl9feGVfX3Vpb2JqZWN0X3Blcm1pc3Npb24nKS5lYWNoKGZ1bmN0aW9uIChpKSB7XG4gIHZhciAkdGhpcyA9ICQodGhpcylcbiAgdmFyIHBlcm1pc3Npb24gPSAkdGhpcy5kYXRhKCdkYXRhJylcblxuICB2YXIga2V5ID0gJHRoaXMuZGF0YSgna2V5JylcbiAgdmFyIHR5cGUgPSAkdGhpcy5kYXRhKCd0eXBlJylcbiAgdmFyIHVzZXJTZWFyY2hVcmwgPSAkdGhpcy5kYXRhKCd1c2VyVXJsJylcbiAgdmFyIGdyb3VwU2VhcmNoVXJsID0gJHRoaXMuZGF0YSgnZ3JvdXBVcmwnKVxuICB2YXIgdmdyb3VwQWxsID0gJHRoaXMuZGF0YSgndmdyb3VwQWxsJylcblxuICB2YXIgcCA9IG5ldyBQZXJtaXNzaW9uKHsgJHdyYXBwZXI6ICR0aGlzLCBrZXksIHVzZXJTZWFyY2hVcmwsIGdyb3VwU2VhcmNoVXJsLCBwZXJtaXNzaW9uLCB0eXBlLCB2Z3JvdXBBbGwgfSlcbiAgcC5yZW5kZXIoKVxuICBwLmJpbmRFdmVudHMoKVxufSlcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxMzUpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg1KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNDAyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNjkpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg4OCk7IiwibW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKFwiY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeVwiKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDgpOyIsInJlcXVpcmUoJy4uLy4uL21vZHVsZXMvZXMuanNvbi5zdHJpbmdpZnknKTtcbnZhciBjb3JlID0gcmVxdWlyZSgnLi4vLi4vaW50ZXJuYWxzL3BhdGgnKTtcblxuLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIGVzL25vLWpzb24gLS0gc2FmZVxuaWYgKCFjb3JlLkpTT04pIGNvcmUuSlNPTiA9IHsgc3RyaW5naWZ5OiBKU09OLnN0cmluZ2lmeSB9O1xuXG4vLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgbm8tdW51c2VkLXZhcnMgLS0gcmVxdWlyZWQgZm9yIGAubGVuZ3RoYFxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiBzdHJpbmdpZnkoaXQsIHJlcGxhY2VyLCBzcGFjZSkge1xuICByZXR1cm4gY29yZS5KU09OLnN0cmluZ2lmeS5hcHBseShudWxsLCBhcmd1bWVudHMpO1xufTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxMCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDIwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNTApOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxOCk7IiwidmFyICQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZXhwb3J0Jyk7XG52YXIgZ2V0QnVpbHRJbiA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9nZXQtYnVpbHQtaW4nKTtcbnZhciBmYWlscyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9mYWlscycpO1xuXG52YXIgJHN0cmluZ2lmeSA9IGdldEJ1aWx0SW4oJ0pTT04nLCAnc3RyaW5naWZ5Jyk7XG52YXIgcmUgPSAvW1xcdUQ4MDAtXFx1REZGRl0vZztcbnZhciBsb3cgPSAvXltcXHVEODAwLVxcdURCRkZdJC87XG52YXIgaGkgPSAvXltcXHVEQzAwLVxcdURGRkZdJC87XG5cbnZhciBmaXggPSBmdW5jdGlvbiAobWF0Y2gsIG9mZnNldCwgc3RyaW5nKSB7XG4gIHZhciBwcmV2ID0gc3RyaW5nLmNoYXJBdChvZmZzZXQgLSAxKTtcbiAgdmFyIG5leHQgPSBzdHJpbmcuY2hhckF0KG9mZnNldCArIDEpO1xuICBpZiAoKGxvdy50ZXN0KG1hdGNoKSAmJiAhaGkudGVzdChuZXh0KSkgfHwgKGhpLnRlc3QobWF0Y2gpICYmICFsb3cudGVzdChwcmV2KSkpIHtcbiAgICByZXR1cm4gJ1xcXFx1JyArIG1hdGNoLmNoYXJDb2RlQXQoMCkudG9TdHJpbmcoMTYpO1xuICB9IHJldHVybiBtYXRjaDtcbn07XG5cbnZhciBGT1JDRUQgPSBmYWlscyhmdW5jdGlvbiAoKSB7XG4gIHJldHVybiAkc3RyaW5naWZ5KCdcXHVERjA2XFx1RDgzNCcpICE9PSAnXCJcXFxcdWRmMDZcXFxcdWQ4MzRcIidcbiAgICB8fCAkc3RyaW5naWZ5KCdcXHVERUFEJykgIT09ICdcIlxcXFx1ZGVhZFwiJztcbn0pO1xuXG5pZiAoJHN0cmluZ2lmeSkge1xuICAvLyBgSlNPTi5zdHJpbmdpZnlgIG1ldGhvZFxuICAvLyBodHRwczovL3RjMzkuZXMvZWNtYTI2Mi8jc2VjLWpzb24uc3RyaW5naWZ5XG4gIC8vIGh0dHBzOi8vZ2l0aHViLmNvbS90YzM5L3Byb3Bvc2FsLXdlbGwtZm9ybWVkLXN0cmluZ2lmeVxuICAkKHsgdGFyZ2V0OiAnSlNPTicsIHN0YXQ6IHRydWUsIGZvcmNlZDogRk9SQ0VEIH0sIHtcbiAgICAvLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgbm8tdW51c2VkLXZhcnMgLS0gcmVxdWlyZWQgZm9yIGAubGVuZ3RoYFxuICAgIHN0cmluZ2lmeTogZnVuY3Rpb24gc3RyaW5naWZ5KGl0LCByZXBsYWNlciwgc3BhY2UpIHtcbiAgICAgIHZhciByZXN1bHQgPSAkc3RyaW5naWZ5LmFwcGx5KG51bGwsIGFyZ3VtZW50cyk7XG4gICAgICByZXR1cm4gdHlwZW9mIHJlc3VsdCA9PSAnc3RyaW5nJyA/IHJlc3VsdC5yZXBsYWNlKHJlLCBmaXgpIDogcmVzdWx0O1xuICAgIH1cbiAgfSk7XG59XG4iLCJ2YXIgcGFyZW50ID0gcmVxdWlyZSgnLi4vLi4vZXMvanNvbi9zdHJpbmdpZnknKTtcblxubW9kdWxlLmV4cG9ydHMgPSBwYXJlbnQ7XG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTMxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNjgpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyNjApOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgzNSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE2NSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDc1KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNTgpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IF94ZV9kbGxfY29tbW9uOyJdLCJzb3VyY2VSb290IjoiIn0=