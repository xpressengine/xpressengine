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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(514);

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
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.array.join.js */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.regexp.constructor.js */ "./node_modules/core-js/modules/es.regexp.constructor.js");
/* harmony import */ var core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_constructor_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! core-js/modules/es.regexp.to-string.js */ "./node_modules/core-js/modules/es.regexp.to-string.js");
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/trim */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/map */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/concat */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/splice */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/json/stringify */ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_15__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_16__);
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! xe */ "./core/index.js");

















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
    this.placeholder = xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::explainIncludeUserOrGroup');
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
        var $target = jquery__WEBPACK_IMPORTED_MODULE_16___default()(e.target);
        var checked = $target.is(':checked');

        if (checked) {
          var _context;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context = _this.$wrapper).call(_context, 'input:not(.chkModeAble)').prop('disabled', true);
        } else {
          var _context2;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context2 = _this.$wrapper).call(_context2, 'input:not(.chkModeAble)').prop('disabled', false);
        }
      });
      this.$wrapper.on('keydown', '.inputUserGroup', function (e) {
        var _context3, _context4;

        var query = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default()(_context3 = e.target.value).call(_context3);

        var $this = jquery__WEBPACK_IMPORTED_MODULE_16___default()(this);
        var keyCode = e.keyCode;

        var $ul = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context4 = $this.parent()).call(_context4, '.ReactTags__suggestions ul');

        var dataInput = $this.data('input'); // include, exclude

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          if ($ul.length > 0) {
            var index = parseInt($this.data('index'), 10);
            var focusedIndex = 0;

            switch (keyCode) {
              case Keys.UP_ARROW:
                if (index == 0) {
                  focusedIndex = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()($ul).call($ul, 'li').length - 1;
                } else {
                  focusedIndex = index - 1;
                }

                $this.data('index', focusedIndex);

                _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()($ul).call($ul, 'li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;

              case Keys.DOWN_ARROW:
                if (index == _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()($ul).call($ul, 'li').length - 1) {
                  focusedIndex = 0;
                } else {
                  focusedIndex = index + 1;
                }

                $this.data('index', focusedIndex);

                _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()($ul).call($ul, 'li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;

              case Keys.ENTER:
              case Keys.TAB:
                e.preventDefault();

                if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()($ul).call($ul, 'li.active').length > 0) {
                  var _context5;

                  var tag = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()($ul).call($ul, 'li.active').data('tag');

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

                  var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12___default()(_context5 = _this.permission[pType]).call(_context5, function (tag) {
                    return tag.id;
                  });

                  if (!bSameWord) {
                    var _context6, _context7, _context8, _context9;

                    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context6 = $ul.closest('.ReactTags__tags')).call(_context6, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default()(_context7 = ids.join()).call(_context7));

                    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context8 = $ul.closest('.ReactTags__tags')).call(_context8, '.' + pType + 'Wrap').append(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context9 = "<span class=\"ReactTags__tag\">".concat(prefix + (tag.display_name || tag.name), "<a class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context9, tag.id, "\">x</a></span>"));
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

            var $tag = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context10 = $this.closest('.ReactTags__tags')).call(_context10, '.ReactTags__selected span');

            if (!query && $tag.length > 0) {
              _this.removeTag($tag.eq($tag.length - 1));
            }
          }
        }
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context11 = this.$wrapper).call(_context11, '.ReactTags__suggestions').on('mouseenter', 'li', function () {
        var $this = jquery__WEBPACK_IMPORTED_MODULE_16___default()(this);
        $this.addClass('active').siblings().removeClass('active');
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context12 = this.$wrapper).call(_context12, '.ReactTags__suggestions').on('click', 'li', function () {
        var _context13, _context14;

        var $this = jquery__WEBPACK_IMPORTED_MODULE_16___default()(this);
        var tag = $this.data('tag');
        var $ul = $this.closest('ul');

        var $input = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context13 = $this.closest('.ReactTags__tagInput')).call(_context13, 'input:text');

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

        var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12___default()(_context14 = _this.permission[pType]).call(_context14, function (tag) {
          return tag.id;
        });

        if (!bSameWord) {
          var _context15, _context16, _context17, _context18;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context15 = $ul.closest('.ReactTags__tags')).call(_context15, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default()(_context16 = ids.join()).call(_context16));

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context17 = $ul.closest('.ReactTags__tags')).call(_context17, '.' + pType + 'Wrap').append(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context18 = "<span class=\"ReactTags__tag\">".concat(prefix + (tag.display_name || tag.name), "<a class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context18, tag.id, "\">x</a></span>"));
        }

        $ul.remove();
        $input.val('').data('index', -1).focus();
      });

      this.$wrapper.on('keyup', '.inputUserGroup', function (e) {
        var _context19;

        var query = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default()(_context19 = e.target.value).call(_context19);

        var $this = jquery__WEBPACK_IMPORTED_MODULE_16___default()(this);
        var keyCode = e.keyCode;

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          if ([Keys.ENTER, Keys.TAB, Keys.UP_ARROW, Keys.DOWN_ARROW, Keys.ESCAPE, 37, 39].indexOf(keyCode) == -1) {
            var _context20;

            var temp = '';
            temp += "<ul>";
            temp += "<li>Searching ... <span class=\"spinner\" role=\"spinner\"><span class=\"spinner-icon\"></span></span></li>";
            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context20 = $this.parent()).call(_context20, '.ReactTags__suggestions').html(temp);

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

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context21 = $this.parent()).call(_context21, '.ReactTags__suggestions').empty();
        }
      });
      this.$wrapper.on('click', '.btnRemoveTag', function (e) {
        e.preventDefault();

        _this.removeTag(jquery__WEBPACK_IMPORTED_MODULE_16___default()(this).closest('span'));
      });
    }
  }, {
    key: "makeIt",
    value: function makeIt(item, query) {
      var escapedRegex = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default()(query).call(query).replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');

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

          _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_14___default()(_context22 = _this.permission[pType]).call(_context22, i, 1); // .push(tag);

        }
      });

      var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12___default()(_context23 = _this.permission[pType]).call(_context23, function (tag) {
        return tag.id;
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context24 = $target.closest('.ReactTags__tags')).call(_context24, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default()(_context25 = ids.join()).call(_context25));

      $target.remove();
    }
  }, {
    key: "searchUser",
    value: function searchUser($input, keyword) {
      var _this = this;

      var searchUserUrl = _this.userSearchUrl;
      xe__WEBPACK_IMPORTED_MODULE_17__["default"].ajax({
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
              temp += "<li class=\"\" data-tag='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_15___default()(item), "'>");
              temp += "<span>".concat(_this.makeIt(item, keyword), "</span>");
              temp += "</li>";
            });
            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context26 = $input.parent()).call(_context26, '.ReactTags__suggestions').html(temp);
          } else {
            var _context27;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context27 = $input.parent()).call(_context27, '.ReactTags__suggestions').empty();
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
      xe__WEBPACK_IMPORTED_MODULE_17__["default"].ajax({
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
              temp += "<li data-tag='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_15___default()(item), "'>");
              temp += "<span>".concat(_this.makeIt(item, keyword), "</span>");
              temp += "</li>";
            });
            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context28 = $input.parent()).call(_context28, '.ReactTags__suggestions').html(temp);
          } else {
            var _context29;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_10___default()(_context29 = $input.parent()).call(_context29, '.ReactTags__suggestions').empty();
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
        name: xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::userRatingAdministrator')
      }, {
        value: 'manager',
        name: xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::userRatingManager')
      }, {
        value: 'user',
        name: xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::user')
      }, {
        value: 'guest',
        name: xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::guest')
      }];
      var disabled = false;

      if (mode === 'manual' || mode === 'inherit') {
        modeEnable = true;

        if (mode !== 'manual') {
          disabled = true;
        }
      }

      var includeGroups = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12___default()(_context30 = this.permission.group).call(_context30, function (group) {
        return group.id;
      });

      var includeUsers = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12___default()(_context31 = this.permission.user).call(_context31, function (user) {
        return user.id;
      });

      var excludeUsers = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12___default()(_context32 = this.permission.except).call(_context32, function (user) {
        return user.id;
      });

      var temp = '';
      temp += "<div>";

      if (modeEnable) {
        var _context33, _context34;

        var checked = mode === 'inherit' ? 'checked="checked"' : '';
        temp += "<div class=\"form-group\">";
        temp += "<div class=\"checkbox\">";
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context33 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context34 = "<label><input type=\"checkbox\" name=\"".concat(this.type + 'Mode', "\" class=\"chkModeAble\" value=\"inherit\" ")).call(_context34, checked, " /> ")).call(_context33, xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::inheritMode'), "</label>");
        temp += "</div>";
        temp += "</div>";
      }

      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::userRating'), "</label>");
      temp += '<div class="radio">';
      permissionTypes.forEach(function (permissionType) {
        var _context35, _context36, _context37, _context38;

        var checked = permissionType.value == rating ? 'checked' : '';
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context35 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context36 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context37 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context38 = "<label><input type=\"radio\" ".concat(disabled ? 'disabled="disabled"' : '', " name=\"")).call(_context38, _this.type + 'Rating', "\" value=\"")).call(_context37, permissionType.value, "\" ")).call(_context36, checked ? 'checked="checked"' : '', " /> ")).call(_context35, permissionType.name, " &nbsp;</label>");
      });
      temp += "</div>";
      temp += "</div>";
      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::includeUserOrGroup'), "</label>");
      temp += "<div class=\"ReactTags__tags\">";
      temp += "<div class=\"ReactTags__selected groupWrap\" data-ptype=\"group\">";
      this.permission.group.forEach(function (g) {
        var _context39;

        var tag = g;
        var label = '%' + (tag.display_name || tag.name);
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context39 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context39, tag.id, "\">x</a></span>");
      });
      temp += '</div>';
      temp += '<div class="ReactTags__selected userWrap" data-ptype="user">';
      this.permission.user.forEach(function (tag) {
        var _context40;

        var label = '@' + (tag.display_name || tag.name);
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context40 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context40, tag.id, "|\">x</a></span>");
      });
      temp += "</div>";
      temp += "<div class=\"ReactTags__tagInput\">";
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context41 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context42 = "<input type=\"text\" placeholder=\"".concat(this.placeholder, "\" class=\"form-control inputUserGroup\" data-input=\"include\" ")).call(_context42, disabled ? 'disabled="disabled"' : '', " value=\"")).call(_context41, this.query, "\" data-index=\"-1\" />"); // TODO:: PermissionInclude handleKeyDown

      temp += "<div class=\"ReactTags__suggestions\" data-input=\"include\"></div>";
      temp += "</div>"; // ReactTags__tagInput

      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context43 = "<input type=\"hidden\" name=\"".concat(this.type + 'Group', "\" class=\"form-control includeGroups\" value=\"")).call(_context43, _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default()(_context44 = includeGroups.join()).call(_context44), "\" />");
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context45 = "<input type=\"hidden\" name=\"".concat(this.type + 'User', "\" class=\"form-control includeUsers\" value=\"")).call(_context45, _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_11___default()(_context46 = includeUsers.join()).call(_context46), "\" />");
      temp += "</div>"; // ReactTags__tags

      temp += "</div>"; // form-group

      if (this.vgroupAll.length >= 1) {
        var _context47;

        temp += "<div class=\"form-group\">";
        temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::includeVGroup'), "</label>");
        temp += _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_12___default()(_context47 = _this.vgroupAll).call(_context47, function (data) {
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

          return _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context48 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context49 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context50 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context51 = "<label><input type=\"checkbox\" ".concat(disabled ? 'disabled="disabled"' : '', " name=\"")).call(_context51, _this.type + 'VGroup[]', "\" value=\"")).call(_context50, data.id, "\" ")).call(_context49, checked ? 'checked="checked"' : '', " /> ")).call(_context48, data.title, " &nbsp;</label>");
        });
        temp += '</div>';
      }

      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::excludeUser'), "</label>");
      temp += "<div class=\"ReactTags__tags\">";
      temp += "<div class=\"ReactTags__selected exceptWrap\" data-ptype=\"except\">";
      this.permission.except.forEach(function (tag) {
        var _context52;

        var label = tag.display_name || tag.name;
        label = '@' + label;
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context52 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context52, tag.id, "\">x</a></span>");
      });
      temp += "</div>";
      temp += "<div class=\"ReactTags__tagInput\">";
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context53 = "<input type=\"text\" placeholder=\"".concat(xe__WEBPACK_IMPORTED_MODULE_17__["default"].Lang.trans('xe::explainExcludeUser'), "\" class=\"form-control inputUserGroup\" data-input=\"exclude\" ")).call(_context53, disabled ? 'disabled="disabled"' : '', " data-index=\"-1\" />"); // TODO:: PermissionExclude handleKeyDown

      temp += "<div class=\"ReactTags__suggestions\" data-input=\"exclude\"></div>";
      temp += "</div>"; // ReactTags__tagInput

      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_13___default()(_context54 = "<input type=\"hidden\" name=\"".concat(this.type + 'Except', "\" class=\"form-control excludeUsers\" value=\"")).call(_context54, excludeUsers, "\" />");
      temp += "</div>"; // ReactTags__tags

      temp += "</div>"; // form-group

      temp += "</div>";
      this.$wrapper.html(temp);
    }
  }]);

  return Permission;
}();

jquery__WEBPACK_IMPORTED_MODULE_16___default()('.__xe__uiobject_permission').each(function (i) {
  var $this = jquery__WEBPACK_IMPORTED_MODULE_16___default()(this);
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

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(91);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(115);

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

/***/ "./node_modules/core-js-pure/es/json/stringify.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js-pure/es/json/stringify.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../../modules/es.json.stringify */ "./node_modules/core-js-pure/modules/es.json.stringify.js");
var path = __webpack_require__(/*! ../../internals/path */ "./node_modules/core-js-pure/internals/path.js");
var apply = __webpack_require__(/*! ../../internals/function-apply */ "./node_modules/core-js-pure/internals/function-apply.js");

// eslint-disable-next-line es-x/no-json -- safe
if (!path.JSON) path.JSON = { stringify: JSON.stringify };

// eslint-disable-next-line no-unused-vars -- required for `.length`
module.exports = function stringify(it, replacer, space) {
  return apply(path.JSON.stringify, null, arguments);
};


/***/ }),

/***/ "./node_modules/core-js-pure/internals/function-apply.js":
/*!***********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/function-apply.js from dll-reference _xe_dll_common ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(117);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/path.js":
/*!*************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/path.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(22);

/***/ }),

/***/ "./node_modules/core-js-pure/modules/es.json.stringify.js":
/*!************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/modules/es.json.stringify.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(529);

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

/***/ "./node_modules/core-js/modules/es.regexp.constructor.js":
/*!***********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.constructor.js from dll-reference _xe_dll_common ***!
  \***********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(304);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.exec.js":
/*!****************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.exec.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(46);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(212);

/***/ }),

/***/ "./node_modules/core-js/modules/es.string.replace.js":
/*!*******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.string.replace.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(101);

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

/***/ "dll-reference _xe_dll_common":
/*!*********************************!*\
  !*** external "_xe_dll_common" ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = _xe_dll_common;

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL2NvcmUvcGVybWlzc2lvbi9wZXJtaXNzaW9uLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9jb25jYXQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9maW5kLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvbWFwLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2Uvc3BsaWNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvdHJpbS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvanNvbi9zdHJpbmdpZnkuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2hlbHBlcnMvY2xhc3NDYWxsQ2hlY2suanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NyZWF0ZUNsYXNzLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2VzL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9mdW5jdGlvbi1hcHBseS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvaW50ZXJuYWxzL3BhdGguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL21vZHVsZXMvZXMuanNvbi5zdHJpbmdpZnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvc3RhYmxlL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLmFycmF5LmpvaW4uanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLmZ1bmN0aW9uLm5hbWUuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLm9iamVjdC50by1zdHJpbmcuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLnJlZ2V4cC5jb25zdHJ1Y3Rvci5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMucmVnZXhwLmV4ZWMuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLnJlZ2V4cC50by1zdHJpbmcuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLnN0cmluZy5yZXBsYWNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy93ZWIuZG9tLWNvbGxlY3Rpb25zLmZvci1lYWNoLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2pxdWVyeS9zcmMvanF1ZXJ5LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZXh0ZXJuYWwgXCJfeGVfZGxsX2NvbW1vblwiIl0sIm5hbWVzIjpbIktleXMiLCJFTlRFUiIsIlRBQiIsIkJBQ0tTUEFDRSIsIlVQX0FSUk9XIiwiRE9XTl9BUlJPVyIsIkVTQ0FQRSIsIlBlcm1pc3Npb24iLCIkd3JhcHBlciIsImtleSIsInVzZXJTZWFyY2hVcmwiLCJncm91cFNlYXJjaFVybCIsInBlcm1pc3Npb24iLCJ0eXBlIiwidmdyb3VwQWxsIiwicXVlcnkiLCJzdWdnZXN0aW9uIiwicGxhY2Vob2xkZXIiLCJYRSIsIkxhbmciLCJ0cmFucyIsInNlbGVjdGVkSW5kZXgiLCJpbmNsdWRlU2VsZWN0ZWRJbmRleCIsImV4Y2x1ZGVTZWxlY3RlZEluZGV4IiwiTUlOX1FVRVJZX0xFTkdUSCIsIl90aGlzIiwib24iLCJlIiwiJHRhcmdldCIsIiQiLCJ0YXJnZXQiLCJjaGVja2VkIiwiaXMiLCJwcm9wIiwidmFsdWUiLCIkdGhpcyIsImtleUNvZGUiLCIkdWwiLCJwYXJlbnQiLCJkYXRhSW5wdXQiLCJkYXRhIiwibGVuZ3RoIiwiaW5kZXgiLCJwYXJzZUludCIsImZvY3VzZWRJbmRleCIsImVxIiwiYWRkQ2xhc3MiLCJzaWJsaW5ncyIsInJlbW92ZUNsYXNzIiwicHJldmVudERlZmF1bHQiLCJ0YWciLCJuYW1lIiwicFR5cGUiLCJwcmVmaXgiLCJwVHlwZXMiLCJiU2FtZVdvcmQiLCJmb3JFYWNoIiwiaSIsImlkIiwicHVzaCIsImlkcyIsImNsb3Nlc3QiLCJ2YWwiLCJqb2luIiwiYXBwZW5kIiwiZGlzcGxheV9uYW1lIiwicmVtb3ZlIiwiZm9jdXMiLCJlbXB0eSIsIiR0YWciLCJyZW1vdmVUYWciLCIkaW5wdXQiLCJpbmRleE9mIiwidGVtcCIsImh0bWwiLCJpZGVudGlmaWVyIiwic3Vic3RyIiwic2VhcmNoVXNlciIsInNlYXJjaEdyb3VwIiwiaXRlbSIsImVzY2FwZWRSZWdleCIsInJlcGxhY2UiLCJyIiwiUmVnRXhwIiwiaXRlbU5hbWUiLCJrZXl3b3JkIiwic2VhcmNoVXNlclVybCIsImFqYXgiLCJ1cmwiLCJtZXRob2QiLCJkYXRhVHlwZSIsImNhY2hlIiwic3VjY2VzcyIsIm1ha2VJdCIsImVycm9yIiwieGhyIiwic3RhdHVzIiwiZXJyIiwic2VhcmNoR3JvdXBVcmwiLCJtb2RlIiwicmF0aW5nIiwibW9kZUVuYWJsZSIsInBlcm1pc3Npb25UeXBlcyIsImRpc2FibGVkIiwiaW5jbHVkZUdyb3VwcyIsImdyb3VwIiwiaW5jbHVkZVVzZXJzIiwidXNlciIsImV4Y2x1ZGVVc2VycyIsImV4Y2VwdCIsInBlcm1pc3Npb25UeXBlIiwiZyIsImxhYmVsIiwiaW5BcnJheSIsImFyciIsInZncm91cCIsInRpdGxlIiwiZWFjaCIsInAiLCJyZW5kZXIiLCJiaW5kRXZlbnRzIl0sIm1hcHBpbmdzIjoiO1FBQUE7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7OztRQUdBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwwQ0FBMEMsZ0NBQWdDO1FBQzFFO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0Esd0RBQXdELGtCQUFrQjtRQUMxRTtRQUNBLGlEQUFpRCxjQUFjO1FBQy9EOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQSx5Q0FBeUMsaUNBQWlDO1FBQzFFLGdIQUFnSCxtQkFBbUIsRUFBRTtRQUNySTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLDJCQUEyQiwwQkFBMEIsRUFBRTtRQUN2RCxpQ0FBaUMsZUFBZTtRQUNoRDtRQUNBO1FBQ0E7O1FBRUE7UUFDQSxzREFBc0QsK0RBQStEOztRQUVySDtRQUNBOzs7UUFHQTtRQUNBOzs7Ozs7Ozs7Ozs7QUNsRkEsZ0g7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNBQTtDQUdBOztBQUVBLElBQU1BLElBQUksR0FBRztFQUNYQyxLQUFLLEVBQUUsRUFESTtFQUVYQyxHQUFHLEVBQUUsQ0FGTTtFQUdYQyxTQUFTLEVBQUUsQ0FIQTtFQUlYQyxRQUFRLEVBQUUsRUFKQztFQUtY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QUFDQTs7Ozs7Ozs7Ozs7O0FDVkEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsYUFBYSxtQkFBTyxDQUFDLGlGQUF5Qjs7QUFFOUM7Ozs7Ozs7Ozs7OztBQ0ZBLGdIOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLGdIOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLGdIOzs7Ozs7Ozs7OztBQ0FBLGdIOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7OztBQ0FBLGdDIiwiZmlsZSI6ImFzc2V0cy9jb3JlL3Blcm1pc3Npb24vcGVybWlzc2lvbi5idW5kbGUuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIlwiO1xuXG5cbiBcdC8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuIFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oX193ZWJwYWNrX3JlcXVpcmVfXy5zID0gXCIuL2NvcmUvcGVybWlzc2lvbi9wZXJtaXNzaW9uLmpzXCIpO1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDUxNCk7IiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IFhFIGZyb20gJ3hlJ1xuXG4vLyBUT0RPOjogbW91c2VvdmVyLFxuXG5jb25zdCBLZXlzID0ge1xuICBFTlRFUjogMTMsXG4gIFRBQjogOSxcbiAgQkFDS1NQQUNFOiA4LFxuICBVUF9BUlJPVzogMzgsXG4gIERPV05fQVJST1c6IDQwLFxuICBFU0NBUEU6IDI3XG59XG5cbmNsYXNzIFBlcm1pc3Npb24ge1xuICBjb25zdHJ1Y3RvciAoeyAkd3JhcHBlciwga2V5LCB1c2VyU2VhcmNoVXJsLCBncm91cFNlYXJjaFVybCwgcGVybWlzc2lvbiwgdHlwZSwgdmdyb3VwQWxsIH0pIHtcbiAgICB0aGlzLiR3cmFwcGVyID0gJHdyYXBwZXJcbiAgICB0aGlzLmtleSA9IGtleVxuICAgIHRoaXMudXNlclNlYXJjaFVybCA9IHVzZXJTZWFyY2hVcmxcbiAgICB0aGlzLmdyb3VwU2VhcmNoVXJsID0gZ3JvdXBTZWFyY2hVcmxcbiAgICB0aGlzLnBlcm1pc3Npb24gPSBwZXJtaXNzaW9uXG4gICAgdGhpcy50eXBlID0gdHlwZVxuICAgIHRoaXMudmdyb3VwQWxsID0gdmdyb3VwQWxsXG4gICAgdGhpcy5xdWVyeSA9ICcnXG4gICAgdGhpcy5zdWdnZXN0aW9uID0gW11cbiAgICB0aGlzLnBsYWNlaG9sZGVyID0gWEUuTGFuZy50cmFucygneGU6OmV4cGxhaW5JbmNsdWRlVXNlck9yR3JvdXAnKVxuICAgIHRoaXMuc2VsZWN0ZWRJbmRleCA9ICcnXG4gICAgdGhpcy5pbmNsdWRlU2VsZWN0ZWRJbmRleCA9IC0xXG4gICAgdGhpcy5leGNsdWRlU2VsZWN0ZWRJbmRleCA9IC0xXG4gICAgdGhpcy5NSU5fUVVFUllfTEVOR1RIID0gMlxuICB9XG5cbiAgYmluZEV2ZW50cyAoKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuXG4gICAgdGhpcy4kd3JhcHBlci5vbignY2hhbmdlJywgJy5jaGtNb2RlQWJsZScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgJHRhcmdldCA9ICQoZS50YXJnZXQpXG4gICAgICB2YXIgY2hlY2tlZCA9ICR0YXJnZXQuaXMoJzpjaGVja2VkJylcblxuICAgICAgaWYgKGNoZWNrZWQpIHtcbiAgICAgICAgX3RoaXMuJHdyYXBwZXIuZmluZCgnaW5wdXQ6bm90KC5jaGtNb2RlQWJsZSknKS5wcm9wKCdkaXNhYmxlZCcsIHRydWUpXG4gICAgICB9IGVsc2Uge1xuICAgICAgICBfdGhpcy4kd3JhcHBlci5maW5kKCdpbnB1dDpub3QoLmNoa01vZGVBYmxlKScpLnByb3AoJ2Rpc2FibGVkJywgZmFsc2UpXG4gICAgICB9XG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIub24oJ2tleWRvd24nLCAnLmlucHV0VXNlckdyb3VwJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIHZhciBxdWVyeSA9IGUudGFyZ2V0LnZhbHVlLnRyaW0oKVxuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyIGtleUNvZGUgPSBlLmtleUNvZGVcbiAgICAgIHZhciAkdWwgPSAkdGhpcy5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucyB1bCcpXG4gICAgICB2YXIgZGF0YUlucHV0ID0gJHRoaXMuZGF0YSgnaW5wdXQnKSAvLyBpbmNsdWRlLCBleGNsdWRlXG5cbiAgICAgIGlmIChxdWVyeS5sZW5ndGggPj0gX3RoaXMuTUlOX1FVRVJZX0xFTkdUSCkge1xuICAgICAgICBpZiAoJHVsLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICB2YXIgaW5kZXggPSBwYXJzZUludCgkdGhpcy5kYXRhKCdpbmRleCcpLCAxMClcbiAgICAgICAgICB2YXIgZm9jdXNlZEluZGV4ID0gMFxuXG4gICAgICAgICAgc3dpdGNoIChrZXlDb2RlKSB7XG4gICAgICAgICAgICBjYXNlIEtleXMuVVBfQVJST1cgOlxuICAgICAgICAgICAgICBpZiAoaW5kZXggPT0gMCkge1xuICAgICAgICAgICAgICAgIGZvY3VzZWRJbmRleCA9ICR1bC5maW5kKCdsaScpLmxlbmd0aCAtIDFcbiAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBmb2N1c2VkSW5kZXggPSAoaW5kZXggLSAxKVxuICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgJHRoaXMuZGF0YSgnaW5kZXgnLCBmb2N1c2VkSW5kZXgpXG4gICAgICAgICAgICAgICR1bC5maW5kKCdsaScpLmVxKGZvY3VzZWRJbmRleCkuYWRkQ2xhc3MoJ2FjdGl2ZScpLnNpYmxpbmdzKCkucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpXG5cbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICAgIGNhc2UgS2V5cy5ET1dOX0FSUk9XIDpcbiAgICAgICAgICAgICAgaWYgKGluZGV4ID09ICR1bC5maW5kKCdsaScpLmxlbmd0aCAtIDEpIHtcbiAgICAgICAgICAgICAgICBmb2N1c2VkSW5kZXggPSAwXG4gICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgZm9jdXNlZEluZGV4ID0gaW5kZXggKyAxXG4gICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAkdGhpcy5kYXRhKCdpbmRleCcsIGZvY3VzZWRJbmRleClcbiAgICAgICAgICAgICAgJHVsLmZpbmQoJ2xpJykuZXEoZm9jdXNlZEluZGV4KS5hZGRDbGFzcygnYWN0aXZlJykuc2libGluZ3MoKS5yZW1vdmVDbGFzcygnYWN0aXZlJylcblxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgICAgY2FzZSBLZXlzLkVOVEVSIDpcbiAgICAgICAgICAgIGNhc2UgS2V5cy5UQUIgOlxuICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KClcblxuICAgICAgICAgICAgICBpZiAoJHVsLmZpbmQoJ2xpLmFjdGl2ZScpLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFnID0gJHVsLmZpbmQoJ2xpLmFjdGl2ZScpLmRhdGEoJ3RhZycpXG4gICAgICAgICAgICAgICAgdmFyIG5hbWUgPSAnJ1xuICAgICAgICAgICAgICAgIHZhciBwVHlwZSA9ICcnXG4gICAgICAgICAgICAgICAgdmFyIHByZWZpeCA9ICcnXG5cbiAgICAgICAgICAgICAgICAvLyB1c2VyXG4gICAgICAgICAgICAgICAgaWYgKCR1bC5kYXRhKCd0YXJnZXQnKSA9PT0gJ3VzZXInKSB7XG4gICAgICAgICAgICAgICAgICAvLyBpbmNsdWRlXG4gICAgICAgICAgICAgICAgICBpZiAoZGF0YUlucHV0ID09PSAnaW5jbHVkZScpIHtcbiAgICAgICAgICAgICAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnVXNlcidcbiAgICAgICAgICAgICAgICAgICAgcFR5cGUgPSAndXNlcidcbiAgICAgICAgICAgICAgICAgICAgcHJlZml4ID0gJ0AnXG4gICAgICAgICAgICAgICAgICAgIC8vIGV4Y2x1ZGVcbiAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0V4Y2VwdCdcbiAgICAgICAgICAgICAgICAgICAgcFR5cGUgPSAnZXhjZXB0J1xuICAgICAgICAgICAgICAgICAgICBwcmVmaXggPSAnQCdcbiAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgIC8vIGdyb3VwXG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0dyb3VwJ1xuICAgICAgICAgICAgICAgICAgcFR5cGUgPSAnZ3JvdXAnXG4gICAgICAgICAgICAgICAgICBwcmVmaXggPSAnJSdcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB2YXIgcFR5cGVzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV1cbiAgICAgICAgICAgICAgICB2YXIgYlNhbWVXb3JkID0gZmFsc2VcblxuICAgICAgICAgICAgICAgIGlmIChwVHlwZXMubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgICAgICAgcFR5cGVzLmZvckVhY2goZnVuY3Rpb24gKHR5cGUsIGkpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHR5cGUuaWQgPT09IHRhZy5pZCkge1xuICAgICAgICAgICAgICAgICAgICAgIGJTYW1lV29yZCA9IHRydWVcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgfSlcblxuICAgICAgICAgICAgICAgICAgaWYgKCFiU2FtZVdvcmQpIHtcbiAgICAgICAgICAgICAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0ucHVzaCh0YWcpXG4gICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnB1c2godGFnKVxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHZhciBpZHMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5tYXAoZnVuY3Rpb24gKHRhZykge1xuICAgICAgICAgICAgICAgICAgcmV0dXJuIHRhZy5pZFxuICAgICAgICAgICAgICAgIH0pXG5cbiAgICAgICAgICAgICAgICBpZiAoIWJTYW1lV29yZCkge1xuICAgICAgICAgICAgICAgICAgJHVsLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCdbbmFtZT0nICsgbmFtZSArICddJykudmFsKGlkcy5qb2luKCkudHJpbSgpKVxuICAgICAgICAgICAgICAgICAgJHVsLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCcuJyArIHBUeXBlICsgJ1dyYXAnKVxuICAgICAgICAgICAgICAgICAgICAuYXBwZW5kKGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtwcmVmaXggKyAodGFnLmRpc3BsYXlfbmFtZSB8fCB0YWcubmFtZSl9PGEgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9XCI+eDwvYT48L3NwYW4+YClcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICAkdWwucmVtb3ZlKClcbiAgICAgICAgICAgICAgICAkdGhpcy52YWwoJycpLmRhdGEoJ2luZGV4JywgLTEpLmZvY3VzKClcbiAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKSAvLyBwcmV2ZW50IHRhYlxuXG4gICAgICAgICAgICAgIGJyZWFrXG4gICAgICAgICAgICBjYXNlIEtleXMuRVNDQVBFIDpcbiAgICAgICAgICAgICAgX3RoaXNbZGF0YUlucHV0ICsgJ1NlbGVjdGVkSW5kZXgnXSA9IDBcbiAgICAgICAgICAgICAgJHVsLnBhcmVudCgpLmVtcHR5KClcbiAgICAgICAgICAgICAgJHRoaXMuZm9jdXMoKVxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgaWYgKEtleXMuQkFDS1NQQUNFID09PSBrZXlDb2RlKSB7XG4gICAgICAgICAgdmFyICR0YWcgPSAkdGhpcy5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnLlJlYWN0VGFnc19fc2VsZWN0ZWQgc3BhbicpXG4gICAgICAgICAgaWYgKCFxdWVyeSAmJiAkdGFnLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgIF90aGlzLnJlbW92ZVRhZygkdGFnLmVxKCR0YWcubGVuZ3RoIC0gMSkpXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9XG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5vbignbW91c2VlbnRlcicsICdsaScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcblxuICAgICAgJHRoaXMuYWRkQ2xhc3MoJ2FjdGl2ZScpLnNpYmxpbmdzKCkucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpXG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5vbignY2xpY2snLCAnbGknLCBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIgdGFnID0gJHRoaXMuZGF0YSgndGFnJylcbiAgICAgIHZhciAkdWwgPSAkdGhpcy5jbG9zZXN0KCd1bCcpXG4gICAgICB2YXIgJGlucHV0ID0gJHRoaXMuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFnSW5wdXQnKS5maW5kKCdpbnB1dDp0ZXh0JylcbiAgICAgIHZhciBkYXRhSW5wdXQgPSAkaW5wdXQuZGF0YSgnaW5wdXQnKVxuICAgICAgdmFyIG5hbWUgPSAnJ1xuICAgICAgdmFyIHBUeXBlID0gJydcbiAgICAgIHZhciBwcmVmaXggPSAnJ1xuXG4gICAgICBpZiAoJHVsLmRhdGEoJ3RhcmdldCcpID09PSAndXNlcicpIHtcbiAgICAgICAgLy8gaW5jbHVkZVxuICAgICAgICBpZiAoZGF0YUlucHV0ID09PSAnaW5jbHVkZScpIHtcbiAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdVc2VyJ1xuICAgICAgICAgIHBUeXBlID0gJ3VzZXInXG4gICAgICAgICAgcHJlZml4ID0gJ0AnXG4gICAgICAgICAgLy8gZXhjbHVkZVxuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0V4Y2VwdCdcbiAgICAgICAgICBwVHlwZSA9ICdleGNlcHQnXG4gICAgICAgICAgcHJlZml4ID0gJ0AnXG4gICAgICAgIH1cbiAgICAgICAgLy8gZ3JvdXBcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0dyb3VwJ1xuICAgICAgICBwVHlwZSA9ICdncm91cCdcbiAgICAgICAgcHJlZml4ID0gJyUnXG4gICAgICB9XG5cbiAgICAgIHZhciBwVHlwZXMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXVxuICAgICAgdmFyIGJTYW1lV29yZCA9IGZhbHNlXG5cbiAgICAgIGlmIChwVHlwZXMubGVuZ3RoID4gMCkge1xuICAgICAgICBwVHlwZXMuZm9yRWFjaChmdW5jdGlvbiAodHlwZSwgaSkge1xuICAgICAgICAgIGlmICh0eXBlLmlkID09PSB0YWcuaWQpIHtcbiAgICAgICAgICAgIGJTYW1lV29yZCA9IHRydWVcbiAgICAgICAgICB9XG4gICAgICAgIH0pXG5cbiAgICAgICAgaWYgKCFiU2FtZVdvcmQpIHtcbiAgICAgICAgICBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5wdXNoKHRhZylcbiAgICAgICAgfVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0ucHVzaCh0YWcpXG4gICAgICB9XG5cbiAgICAgIHZhciBpZHMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5tYXAoZnVuY3Rpb24gKHRhZykge1xuICAgICAgICByZXR1cm4gdGFnLmlkXG4gICAgICB9KVxuXG4gICAgICBpZiAoIWJTYW1lV29yZCkge1xuICAgICAgICAkdWwuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJ1tuYW1lPScgKyBuYW1lICsgJ10nKS52YWwoaWRzLmpvaW4oKS50cmltKCkpXG4gICAgICAgICR1bC5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnLicgKyBwVHlwZSArICdXcmFwJylcbiAgICAgICAgICAuYXBwZW5kKGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtwcmVmaXggKyAodGFnLmRpc3BsYXlfbmFtZSB8fCB0YWcubmFtZSl9PGEgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9XCI+eDwvYT48L3NwYW4+YClcbiAgICAgIH1cblxuICAgICAgJHVsLnJlbW92ZSgpXG4gICAgICAkaW5wdXQudmFsKCcnKS5kYXRhKCdpbmRleCcsIC0xKS5mb2N1cygpXG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIub24oJ2tleXVwJywgJy5pbnB1dFVzZXJHcm91cCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgcXVlcnkgPSBlLnRhcmdldC52YWx1ZS50cmltKClcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgIHZhciBrZXlDb2RlID0gZS5rZXlDb2RlXG5cbiAgICAgIGlmIChxdWVyeS5sZW5ndGggPj0gX3RoaXMuTUlOX1FVRVJZX0xFTkdUSCkge1xuICAgICAgICBpZiAoW0tleXMuRU5URVIsIEtleXMuVEFCLCBLZXlzLlVQX0FSUk9XLCBLZXlzLkRPV05fQVJST1csIEtleXMuRVNDQVBFLCAzNywgMzldLmluZGV4T2Yoa2V5Q29kZSkgPT0gLTEpIHtcbiAgICAgICAgICB2YXIgdGVtcCA9ICcnXG4gICAgICAgICAgdGVtcCArPSBgPHVsPmBcbiAgICAgICAgICB0ZW1wICs9IGA8bGk+U2VhcmNoaW5nIC4uLiA8c3BhbiBjbGFzcz1cInNwaW5uZXJcIiByb2xlPVwic3Bpbm5lclwiPjxzcGFuIGNsYXNzPVwic3Bpbm5lci1pY29uXCI+PC9zcGFuPjwvc3Bhbj48L2xpPmBcbiAgICAgICAgICB0ZW1wICs9IGA8L3VsPmBcblxuICAgICAgICAgICR0aGlzLnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuaHRtbCh0ZW1wKVxuXG4gICAgICAgICAgdmFyIGlkZW50aWZpZXIgPSBxdWVyeS5zdWJzdHIoMCwgMSlcbiAgICAgICAgICBzd2l0Y2ggKGlkZW50aWZpZXIpIHtcbiAgICAgICAgICAgIGNhc2UgJ0AnOlxuICAgICAgICAgICAgICBxdWVyeSA9IHF1ZXJ5LnN1YnN0cigxLCBxdWVyeS5sZW5ndGgpXG4gICAgICAgICAgICAgIF90aGlzLnNlYXJjaFVzZXIoJHRoaXMsIHF1ZXJ5KVxuICAgICAgICAgICAgICBicmVha1xuXG4gICAgICAgICAgICBjYXNlICclJzpcbiAgICAgICAgICAgICAgcXVlcnkgPSBxdWVyeS5zdWJzdHIoMSwgcXVlcnkubGVuZ3RoKVxuICAgICAgICAgICAgICBfdGhpcy5zZWFyY2hHcm91cCgkdGhpcywgcXVlcnkpXG4gICAgICAgICAgICAgIGJyZWFrXG5cbiAgICAgICAgICAgIGRlZmF1bHQgOlxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgJHRoaXMucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5lbXB0eSgpXG4gICAgICB9XG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIub24oJ2NsaWNrJywgJy5idG5SZW1vdmVUYWcnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgIF90aGlzLnJlbW92ZVRhZygkKHRoaXMpLmNsb3Nlc3QoJ3NwYW4nKSlcbiAgICB9KVxuICB9XG5cbiAgbWFrZUl0IChpdGVtLCBxdWVyeSkge1xuICAgIHZhciBlc2NhcGVkUmVnZXggPSBxdWVyeS50cmltKCkucmVwbGFjZSgvWy1cXFxcXiQqKz8uKCl8W1xcXXt9XS9nLCAnXFxcXCQmJylcbiAgICB2YXIgciA9IFJlZ0V4cChlc2NhcGVkUmVnZXgsICdnaScpXG4gICAgdmFyIGl0ZW1OYW1lID0gaXRlbS5kaXNwbGF5X25hbWUgfHwgaXRlbS5uYW1lXG5cbiAgICByZXR1cm4gaXRlbU5hbWUucmVwbGFjZShyLCAnPG1hcms+JCY8L21hcms+JylcbiAgfVxuXG4gIHJlbW92ZVRhZyAoJHRhcmdldCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICB2YXIgcFR5cGUgPSAkdGFyZ2V0LmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3NlbGVjdGVkJykuZGF0YSgncHR5cGUnKVxuICAgIHZhciBpZCA9ICR0YXJnZXQuZGF0YSgnaWQnKVxuICAgIHZhciBuYW1lID0gJydcblxuICAgIHN3aXRjaCAocFR5cGUpIHtcbiAgICAgIGNhc2UgJ3VzZXInIDpcbiAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnVXNlcidcbiAgICAgICAgYnJlYWtcbiAgICAgIGNhc2UgJ2V4Y2VwdCcgOlxuICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdFeGNlcHQnXG4gICAgICAgIGJyZWFrXG4gICAgICBjYXNlICdncm91cCcgOlxuICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdHcm91cCdcbiAgICAgICAgYnJlYWtcbiAgICB9XG5cbiAgICB2YXIgcFR5cGVzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV1cblxuICAgIHBUeXBlcy5mb3JFYWNoKGZ1bmN0aW9uICh0eXBlLCBpKSB7XG4gICAgICBpZiAodHlwZS5pZCAhPT0gaWQpIHtcbiAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0uc3BsaWNlKGksIDEpLy8gLnB1c2godGFnKTtcbiAgICAgIH1cbiAgICB9KVxuXG4gICAgdmFyIGlkcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLm1hcChmdW5jdGlvbiAodGFnKSB7XG4gICAgICByZXR1cm4gdGFnLmlkXG4gICAgfSlcblxuICAgICR0YXJnZXQuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJ1tuYW1lPScgKyBuYW1lICsgJ10nKS52YWwoaWRzLmpvaW4oKS50cmltKCkpXG4gICAgJHRhcmdldC5yZW1vdmUoKVxuICB9XG5cbiAgc2VhcmNoVXNlciAoJGlucHV0LCBrZXl3b3JkKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHZhciBzZWFyY2hVc2VyVXJsID0gX3RoaXMudXNlclNlYXJjaFVybFxuXG4gICAgWEUuYWpheCh7XG4gICAgICB1cmw6IHNlYXJjaFVzZXJVcmwgKyAnLycgKyBrZXl3b3JkLFxuICAgICAgbWV0aG9kOiAnZ2V0JyxcbiAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICBjYWNoZTogZmFsc2UsXG4gICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICBpZiAoZGF0YS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgdmFyIHRlbXAgPSAnJ1xuICAgICAgICAgIHRlbXAgKz0gYDx1bCBkYXRhLXRhcmdldD1cInVzZXJcIj5gXG5cbiAgICAgICAgICBkYXRhLmZvckVhY2goZnVuY3Rpb24gKGl0ZW0sIGkpIHtcbiAgICAgICAgICAgIHRlbXAgKz0gYDxsaSBjbGFzcz1cIlwiIGRhdGEtdGFnPScke0pTT04uc3RyaW5naWZ5KGl0ZW0pfSc+YFxuICAgICAgICAgICAgdGVtcCArPSBgPHNwYW4+JHtfdGhpcy5tYWtlSXQoaXRlbSwga2V5d29yZCl9PC9zcGFuPmBcbiAgICAgICAgICAgIHRlbXAgKz0gYDwvbGk+YFxuICAgICAgICAgIH0pXG5cbiAgICAgICAgICB0ZW1wICs9IGA8L3VsPmBcblxuICAgICAgICAgICRpbnB1dC5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmh0bWwodGVtcClcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAkaW5wdXQucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5lbXB0eSgpXG4gICAgICAgIH1cbiAgICAgIH0sXG4gICAgICBlcnJvcjogZnVuY3Rpb24gKHhociwgc3RhdHVzLCBlcnIpIHtcblxuICAgICAgfVxuICAgIH0pXG4gIH1cblxuICBzZWFyY2hHcm91cCAoJGlucHV0LCBrZXl3b3JkKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHZhciBzZWFyY2hHcm91cFVybCA9IF90aGlzLmdyb3VwU2VhcmNoVXJsXG5cbiAgICBYRS5hamF4KHtcbiAgICAgIHVybDogc2VhcmNoR3JvdXBVcmwgKyAnLycgKyBrZXl3b3JkLFxuICAgICAgbWV0aG9kOiAnZ2V0JyxcbiAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICBjYWNoZTogZmFsc2UsXG4gICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICAvLyBUT0RPOjogdmlldyByZW5kZXJpblxuICAgICAgICBpZiAoZGF0YS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgdmFyIHRlbXAgPSAnJ1xuICAgICAgICAgIHRlbXAgKz0gYDx1bCBkYXRhLXRhcmdldD1cImdyb3VwXCI+YFxuXG4gICAgICAgICAgZGF0YS5mb3JFYWNoKGZ1bmN0aW9uIChpdGVtLCBpKSB7XG4gICAgICAgICAgICB0ZW1wICs9IGA8bGkgZGF0YS10YWc9JyR7SlNPTi5zdHJpbmdpZnkoaXRlbSl9Jz5gXG4gICAgICAgICAgICB0ZW1wICs9IGA8c3Bhbj4ke190aGlzLm1ha2VJdChpdGVtLCBrZXl3b3JkKX08L3NwYW4+YFxuICAgICAgICAgICAgdGVtcCArPSBgPC9saT5gXG4gICAgICAgICAgfSlcblxuICAgICAgICAgIHRlbXAgKz0gYDwvdWw+YFxuXG4gICAgICAgICAgJGlucHV0LnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuaHRtbCh0ZW1wKVxuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICRpbnB1dC5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmVtcHR5KClcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICAgIGVycm9yOiBmdW5jdGlvbiAoeGhyLCBzdGF0dXMsIGVycikge31cbiAgICB9KVxuICB9XG5cbiAgcmVuZGVyICgpIHtcbiAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgdmFyIG1vZGUgPSB0aGlzLnBlcm1pc3Npb24ubW9kZVxuICAgIHZhciByYXRpbmcgPSB0aGlzLnBlcm1pc3Npb24ucmF0aW5nXG4gICAgdmFyIG1vZGVFbmFibGUgPSBmYWxzZVxuICAgIHZhciBwZXJtaXNzaW9uVHlwZXMgPSBbXG4gICAgICB7IHZhbHVlOiAnc3VwZXInLCBuYW1lOiBYRS5MYW5nLnRyYW5zKCd4ZTo6dXNlclJhdGluZ0FkbWluaXN0cmF0b3InKSB9LFxuICAgICAgeyB2YWx1ZTogJ21hbmFnZXInLCBuYW1lOiBYRS5MYW5nLnRyYW5zKCd4ZTo6dXNlclJhdGluZ01hbmFnZXInKSB9LFxuICAgICAgeyB2YWx1ZTogJ3VzZXInLCBuYW1lOiBYRS5MYW5nLnRyYW5zKCd4ZTo6dXNlcicpIH0sXG4gICAgICB7IHZhbHVlOiAnZ3Vlc3QnLCBuYW1lOiBYRS5MYW5nLnRyYW5zKCd4ZTo6Z3Vlc3QnKSB9XG4gICAgXVxuXG4gICAgdmFyIGRpc2FibGVkID0gZmFsc2VcblxuICAgIGlmIChtb2RlID09PSAnbWFudWFsJyB8fCBtb2RlID09PSAnaW5oZXJpdCcpIHtcbiAgICAgIG1vZGVFbmFibGUgPSB0cnVlXG4gICAgICBpZiAobW9kZSAhPT0gJ21hbnVhbCcpIHtcbiAgICAgICAgZGlzYWJsZWQgPSB0cnVlXG4gICAgICB9XG4gICAgfVxuXG4gICAgdmFyIGluY2x1ZGVHcm91cHMgPSB0aGlzLnBlcm1pc3Npb24uZ3JvdXAubWFwKGZ1bmN0aW9uIChncm91cCkge1xuICAgICAgcmV0dXJuIGdyb3VwLmlkXG4gICAgfSlcblxuICAgIHZhciBpbmNsdWRlVXNlcnMgPSB0aGlzLnBlcm1pc3Npb24udXNlci5tYXAoZnVuY3Rpb24gKHVzZXIpIHtcbiAgICAgIHJldHVybiB1c2VyLmlkXG4gICAgfSlcblxuICAgIHZhciBleGNsdWRlVXNlcnMgPSB0aGlzLnBlcm1pc3Npb24uZXhjZXB0Lm1hcChmdW5jdGlvbiAodXNlcikge1xuICAgICAgcmV0dXJuIHVzZXIuaWRcbiAgICB9KVxuXG4gICAgdmFyIHRlbXAgPSAnJ1xuICAgIHRlbXAgKz0gYDxkaXY+YFxuXG4gICAgaWYgKG1vZGVFbmFibGUpIHtcbiAgICAgIHZhciBjaGVja2VkID0gKG1vZGUgPT09ICdpbmhlcml0JykgPyAnY2hlY2tlZD1cImNoZWNrZWRcIicgOiAnJ1xuXG4gICAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiPmBcbiAgICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJjaGVja2JveFwiPmBcbiAgICAgIHRlbXAgKz0gYDxsYWJlbD48aW5wdXQgdHlwZT1cImNoZWNrYm94XCIgbmFtZT1cIiR7dGhpcy50eXBlICsgJ01vZGUnfVwiIGNsYXNzPVwiY2hrTW9kZUFibGVcIiB2YWx1ZT1cImluaGVyaXRcIiAke2NoZWNrZWR9IC8+ICR7WEUuTGFuZy50cmFucygneGU6OmluaGVyaXRNb2RlJyl9PC9sYWJlbD5gXG4gICAgICB0ZW1wICs9IGA8L2Rpdj5gXG4gICAgICB0ZW1wICs9IGA8L2Rpdj5gXG4gICAgfVxuXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgdGVtcCArPSBgPGxhYmVsPiR7WEUuTGFuZy50cmFucygneGU6OnVzZXJSYXRpbmcnKX08L2xhYmVsPmBcbiAgICB0ZW1wICs9ICc8ZGl2IGNsYXNzPVwicmFkaW9cIj4nXG4gICAgcGVybWlzc2lvblR5cGVzLmZvckVhY2goZnVuY3Rpb24gKHBlcm1pc3Npb25UeXBlKSB7XG4gICAgICB2YXIgY2hlY2tlZCA9IChwZXJtaXNzaW9uVHlwZS52YWx1ZSA9PSByYXRpbmcpID8gJ2NoZWNrZWQnIDogJydcblxuICAgICAgdGVtcCArPSBgPGxhYmVsPjxpbnB1dCB0eXBlPVwicmFkaW9cIiAkeyhkaXNhYmxlZCkgPyAnZGlzYWJsZWQ9XCJkaXNhYmxlZFwiJyA6ICcnfSBuYW1lPVwiJHtfdGhpcy50eXBlICsgJ1JhdGluZyd9XCIgdmFsdWU9XCIke3Blcm1pc3Npb25UeXBlLnZhbHVlfVwiICR7KGNoZWNrZWQpID8gJ2NoZWNrZWQ9XCJjaGVja2VkXCInIDogJyd9IC8+ICR7cGVybWlzc2lvblR5cGUubmFtZX0gJm5ic3A7PC9sYWJlbD5gXG4gICAgfSlcbiAgICB0ZW1wICs9IGA8L2Rpdj5gXG4gICAgdGVtcCArPSBgPC9kaXY+YFxuICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+YFxuICAgIHRlbXAgKz0gYDxsYWJlbD4ke1hFLkxhbmcudHJhbnMoJ3hlOjppbmNsdWRlVXNlck9yR3JvdXAnKX08L2xhYmVsPmBcbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX190YWdzXCI+YFxuXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc2VsZWN0ZWQgZ3JvdXBXcmFwXCIgZGF0YS1wdHlwZT1cImdyb3VwXCI+YFxuICAgIHRoaXMucGVybWlzc2lvbi5ncm91cC5mb3JFYWNoKGZ1bmN0aW9uIChnKSB7XG4gICAgICB2YXIgdGFnID0gZ1xuICAgICAgdmFyIGxhYmVsID0gJyUnICsgKHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWUpXG5cbiAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiUmVhY3RUYWdzX190YWdcIj4ke2xhYmVsfTxhIGhyZWY9XCIjXCIgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9XCI+eDwvYT48L3NwYW4+YFxuICAgIH0pXG4gICAgdGVtcCArPSAnPC9kaXY+J1xuXG4gICAgdGVtcCArPSAnPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc2VsZWN0ZWQgdXNlcldyYXBcIiBkYXRhLXB0eXBlPVwidXNlclwiPidcbiAgICB0aGlzLnBlcm1pc3Npb24udXNlci5mb3JFYWNoKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgIHZhciBsYWJlbCA9ICdAJyArICh0YWcuZGlzcGxheV9uYW1lIHx8IHRhZy5uYW1lKVxuXG4gICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtsYWJlbH08YSBocmVmPVwiI1wiIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfXxcIj54PC9hPjwvc3Bhbj5gXG4gICAgfSlcbiAgICB0ZW1wICs9IGA8L2Rpdj5gXG5cbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX190YWdJbnB1dFwiPmBcbiAgICB0ZW1wICs9IGA8aW5wdXQgdHlwZT1cInRleHRcIiBwbGFjZWhvbGRlcj1cIiR7dGhpcy5wbGFjZWhvbGRlcn1cIiBjbGFzcz1cImZvcm0tY29udHJvbCBpbnB1dFVzZXJHcm91cFwiIGRhdGEtaW5wdXQ9XCJpbmNsdWRlXCIgJHsoZGlzYWJsZWQpID8gJ2Rpc2FibGVkPVwiZGlzYWJsZWRcIicgOiAnJ30gdmFsdWU9XCIke3RoaXMucXVlcnl9XCIgZGF0YS1pbmRleD1cIi0xXCIgLz5gIC8vIFRPRE86OiBQZXJtaXNzaW9uSW5jbHVkZSBoYW5kbGVLZXlEb3duXG4gICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc3VnZ2VzdGlvbnNcIiBkYXRhLWlucHV0PVwiaW5jbHVkZVwiPjwvZGl2PmBcbiAgICB0ZW1wICs9IGA8L2Rpdj5gIC8vIFJlYWN0VGFnc19fdGFnSW5wdXRcbiAgICB0ZW1wICs9IGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3RoaXMudHlwZSArICdHcm91cCd9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgaW5jbHVkZUdyb3Vwc1wiIHZhbHVlPVwiJHtpbmNsdWRlR3JvdXBzLmpvaW4oKS50cmltKCl9XCIgLz5gXG4gICAgdGVtcCArPSBgPGlucHV0IHR5cGU9XCJoaWRkZW5cIiBuYW1lPVwiJHt0aGlzLnR5cGUgKyAnVXNlcid9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgaW5jbHVkZVVzZXJzXCIgdmFsdWU9XCIke2luY2x1ZGVVc2Vycy5qb2luKCkudHJpbSgpfVwiIC8+YFxuICAgIHRlbXAgKz0gYDwvZGl2PmAgLy8gUmVhY3RUYWdzX190YWdzXG4gICAgdGVtcCArPSBgPC9kaXY+YC8vIGZvcm0tZ3JvdXBcblxuICAgIGlmICh0aGlzLnZncm91cEFsbC5sZW5ndGggPj0gMSkge1xuICAgICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgICB0ZW1wICs9IGA8bGFiZWw+JHtYRS5MYW5nLnRyYW5zKCd4ZTo6aW5jbHVkZVZHcm91cCcpfTwvbGFiZWw+YFxuXG4gICAgICB0ZW1wICs9IF90aGlzLnZncm91cEFsbC5tYXAoZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgdmFyIGNoZWNrZWQgPSBmYWxzZVxuXG4gICAgICAgIHZhciBpbkFycmF5ID0gZnVuY3Rpb24gKHZhbCwgYXJyKSB7XG4gICAgICAgICAgZm9yICh2YXIgaSA9IDA7IGkgPCBhcnIubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIGlmIChhcnJbaV0gPT0gdmFsKSB7XG4gICAgICAgICAgICAgIHJldHVybiBpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfVxuXG4gICAgICAgICAgcmV0dXJuIC0xXG4gICAgICAgIH1cblxuICAgICAgICBpZiAoaW5BcnJheShkYXRhLmlkLCB0aGlzLnBlcm1pc3Npb24udmdyb3VwKSAhPSAtMSkge1xuICAgICAgICAgIGNoZWNrZWQgPSB0cnVlXG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gYDxsYWJlbD48aW5wdXQgdHlwZT1cImNoZWNrYm94XCIgJHsoZGlzYWJsZWQpID8gJ2Rpc2FibGVkPVwiZGlzYWJsZWRcIicgOiAnJ30gbmFtZT1cIiR7X3RoaXMudHlwZSArICdWR3JvdXBbXSd9XCIgdmFsdWU9XCIke2RhdGEuaWR9XCIgJHsoY2hlY2tlZCkgPyAnY2hlY2tlZD1cImNoZWNrZWRcIicgOiAnJ30gLz4gJHtkYXRhLnRpdGxlfSAmbmJzcDs8L2xhYmVsPmBcbiAgICAgIH0pXG5cbiAgICAgIHRlbXAgKz0gJzwvZGl2PidcbiAgICB9XG5cbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiPmBcbiAgICB0ZW1wICs9IGA8bGFiZWw+JHtYRS5MYW5nLnRyYW5zKCd4ZTo6ZXhjbHVkZVVzZXInKX08L2xhYmVsPmBcbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX190YWdzXCI+YFxuICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3NlbGVjdGVkIGV4Y2VwdFdyYXBcIiBkYXRhLXB0eXBlPVwiZXhjZXB0XCI+YFxuXG4gICAgdGhpcy5wZXJtaXNzaW9uLmV4Y2VwdC5mb3JFYWNoKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgIHZhciBsYWJlbCA9IHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWVcbiAgICAgIGxhYmVsID0gJ0AnICsgbGFiZWxcblxuICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7bGFiZWx9PGEgaHJlZj1cIiNcIiBjbGFzcz1cIlJlYWN0VGFnc19fcmVtb3ZlIGJ0blJlbW92ZVRhZ1wiIGRhdGEtaWQ9XCIke3RhZy5pZH1cIj54PC9hPjwvc3Bhbj5gXG4gICAgfSlcblxuICAgIHRlbXAgKz0gYDwvZGl2PmBcbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX190YWdJbnB1dFwiPmBcbiAgICB0ZW1wICs9IGA8aW5wdXQgdHlwZT1cInRleHRcIiBwbGFjZWhvbGRlcj1cIiR7WEUuTGFuZy50cmFucygneGU6OmV4cGxhaW5FeGNsdWRlVXNlcicpfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGlucHV0VXNlckdyb3VwXCIgZGF0YS1pbnB1dD1cImV4Y2x1ZGVcIiAkeyhkaXNhYmxlZCkgPyAnZGlzYWJsZWQ9XCJkaXNhYmxlZFwiJyA6ICcnfSBkYXRhLWluZGV4PVwiLTFcIiAvPmAgLy8gVE9ETzo6IFBlcm1pc3Npb25FeGNsdWRlIGhhbmRsZUtleURvd25cbiAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX19zdWdnZXN0aW9uc1wiIGRhdGEtaW5wdXQ9XCJleGNsdWRlXCI+PC9kaXY+YFxuICAgIHRlbXAgKz0gYDwvZGl2PmAgLy8gUmVhY3RUYWdzX190YWdJbnB1dFxuICAgIHRlbXAgKz0gYDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cIiR7dGhpcy50eXBlICsgJ0V4Y2VwdCd9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgZXhjbHVkZVVzZXJzXCIgdmFsdWU9XCIke2V4Y2x1ZGVVc2Vyc31cIiAvPmBcbiAgICB0ZW1wICs9IGA8L2Rpdj5gIC8vIFJlYWN0VGFnc19fdGFnc1xuICAgIHRlbXAgKz0gYDwvZGl2PmAvLyBmb3JtLWdyb3VwXG5cbiAgICB0ZW1wICs9IGA8L2Rpdj5gXG5cbiAgICB0aGlzLiR3cmFwcGVyLmh0bWwodGVtcClcbiAgfVxufVxuXG4kKCcuX194ZV9fdWlvYmplY3RfcGVybWlzc2lvbicpLmVhY2goZnVuY3Rpb24gKGkpIHtcbiAgdmFyICR0aGlzID0gJCh0aGlzKVxuICB2YXIgcGVybWlzc2lvbiA9ICR0aGlzLmRhdGEoJ2RhdGEnKVxuXG4gIHZhciBrZXkgPSAkdGhpcy5kYXRhKCdrZXknKVxuICB2YXIgdHlwZSA9ICR0aGlzLmRhdGEoJ3R5cGUnKVxuICB2YXIgdXNlclNlYXJjaFVybCA9ICR0aGlzLmRhdGEoJ3VzZXJVcmwnKVxuICB2YXIgZ3JvdXBTZWFyY2hVcmwgPSAkdGhpcy5kYXRhKCdncm91cFVybCcpXG4gIHZhciB2Z3JvdXBBbGwgPSAkdGhpcy5kYXRhKCd2Z3JvdXBBbGwnKVxuXG4gIHZhciBwID0gbmV3IFBlcm1pc3Npb24oeyAkd3JhcHBlcjogJHRoaXMsIGtleSwgdXNlclNlYXJjaFVybCwgZ3JvdXBTZWFyY2hVcmwsIHBlcm1pc3Npb24sIHR5cGUsIHZncm91cEFsbCB9KVxuICBwLnJlbmRlcigpXG4gIHAuYmluZEV2ZW50cygpXG59KVxuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE3MCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0NzIpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg5MSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDExNSk7IiwibW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKFwiY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeVwiKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDgpOyIsInJlcXVpcmUoJy4uLy4uL21vZHVsZXMvZXMuanNvbi5zdHJpbmdpZnknKTtcbnZhciBwYXRoID0gcmVxdWlyZSgnLi4vLi4vaW50ZXJuYWxzL3BhdGgnKTtcbnZhciBhcHBseSA9IHJlcXVpcmUoJy4uLy4uL2ludGVybmFscy9mdW5jdGlvbi1hcHBseScpO1xuXG4vLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgZXMteC9uby1qc29uIC0tIHNhZmVcbmlmICghcGF0aC5KU09OKSBwYXRoLkpTT04gPSB7IHN0cmluZ2lmeTogSlNPTi5zdHJpbmdpZnkgfTtcblxuLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG5vLXVudXNlZC12YXJzIC0tIHJlcXVpcmVkIGZvciBgLmxlbmd0aGBcbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gc3RyaW5naWZ5KGl0LCByZXBsYWNlciwgc3BhY2UpIHtcbiAgcmV0dXJuIGFwcGx5KHBhdGguSlNPTi5zdHJpbmdpZnksIG51bGwsIGFyZ3VtZW50cyk7XG59O1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDExNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDIyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNTI5KTsiLCJ2YXIgcGFyZW50ID0gcmVxdWlyZSgnLi4vLi4vZXMvanNvbi9zdHJpbmdpZnknKTtcblxubW9kdWxlLmV4cG9ydHMgPSBwYXJlbnQ7XG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTY2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNzYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyNik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDMwNCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQ2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjEyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTAxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNzMpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IF94ZV9kbGxfY29tbW9uOyJdLCJzb3VyY2VSb290IjoiIn0=