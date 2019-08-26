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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(325);

/***/ }),

/***/ "./core/permission/permission.js":
/*!***************************************!*\
  !*** ./core/permission/permission.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/json/stringify */ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/splice */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/index-of */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/concat */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/map */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/for-each */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_parse_int__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/parse-int */ "./node_modules/@babel/runtime-corejs3/core-js-stable/parse-int.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_parse_int__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_parse_int__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/trim */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! xe */ "./core/index.js");












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

    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_9___default()(this, Permission);

    this.$wrapper = $wrapper;
    this.key = key;
    this.userSearchUrl = userSearchUrl;
    this.groupSearchUrl = groupSearchUrl;
    this.permission = permission;
    this.type = type;
    this.vgroupAll = vgroupAll;
    this.query = '';
    this.suggestion = [];
    this.placeholder = xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::explainIncludeUserOrGroup');
    this.selectedIndex = '';
    this.includeSelectedIndex = -1;
    this.excludeSelectedIndex = -1;
    this.MIN_QUERY_LENGTH = 2;
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_10___default()(Permission, [{
    key: "bindEvents",
    value: function bindEvents() {
      var _context11, _context12;

      var _this = this;

      this.$wrapper.on('change', '.chkModeAble', function (e) {
        var $target = jquery__WEBPACK_IMPORTED_MODULE_11___default()(e.target);
        var checked = $target.is(':checked');

        if (checked) {
          var _context;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context = _this.$wrapper).call(_context, 'input:not(.chkModeAble)').prop('disabled', true);
        } else {
          var _context2;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context2 = _this.$wrapper).call(_context2, 'input:not(.chkModeAble)').prop('disabled', false);
        }
      });
      this.$wrapper.on('keydown', '.inputUserGroup', function (e) {
        var _context3, _context4;

        var query = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default()(_context3 = e.target.value).call(_context3);

        var $this = jquery__WEBPACK_IMPORTED_MODULE_11___default()(this);
        var keyCode = e.keyCode;

        var $ul = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context4 = $this.parent()).call(_context4, '.ReactTags__suggestions ul');

        var dataInput = $this.data('input'); // include, exclude

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          if ($ul.length > 0) {
            var index = _babel_runtime_corejs3_core_js_stable_parse_int__WEBPACK_IMPORTED_MODULE_6___default()($this.data('index'), 10);

            var focusedIndex = 0;

            switch (keyCode) {
              case Keys.UP_ARROW:
                if (index == 0) {
                  focusedIndex = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()($ul).call($ul, 'li').length - 1;
                } else {
                  focusedIndex = index - 1;
                }

                $this.data('index', focusedIndex);

                _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()($ul).call($ul, 'li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;

              case Keys.DOWN_ARROW:
                if (index == _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()($ul).call($ul, 'li').length - 1) {
                  focusedIndex = 0;
                } else {
                  focusedIndex = index + 1;
                }

                $this.data('index', focusedIndex);

                _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()($ul).call($ul, 'li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;

              case Keys.ENTER:
              case Keys.TAB:
                e.preventDefault();

                if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()($ul).call($ul, 'li.active').length > 0) {
                  var _context5;

                  var tag = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()($ul).call($ul, 'li.active').data('tag');

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
                    _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(pTypes).call(pTypes, function (type, i) {
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

                  var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default()(_context5 = _this.permission[pType]).call(_context5, function (tag) {
                    return tag.id;
                  });

                  if (!bSameWord) {
                    var _context6, _context7, _context8, _context9;

                    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context6 = $ul.closest('.ReactTags__tags')).call(_context6, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default()(_context7 = ids.join()).call(_context7));

                    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context8 = $ul.closest('.ReactTags__tags')).call(_context8, '.' + pType + 'Wrap').append(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context9 = "<span class=\"ReactTags__tag\">".concat(prefix + (tag.display_name || tag.name), "<a class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context9, tag.id, "\">x</a></span>"));
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

            var $tag = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context10 = $this.closest('.ReactTags__tags')).call(_context10, '.ReactTags__selected span');

            if (!query && $tag.length > 0) {
              _this.removeTag($tag.eq($tag.length - 1));
            }
          }
        }
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context11 = this.$wrapper).call(_context11, '.ReactTags__suggestions').on('mouseenter', 'li', function () {
        var $this = jquery__WEBPACK_IMPORTED_MODULE_11___default()(this);
        var $ul = $this.closest('ul');
        $this.addClass('active').siblings().removeClass('active');
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context12 = this.$wrapper).call(_context12, '.ReactTags__suggestions').on('click', 'li', function () {
        var _context13, _context14;

        var $this = jquery__WEBPACK_IMPORTED_MODULE_11___default()(this);
        var tag = $this.data('tag');
        var $ul = $this.closest('ul');

        var $input = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context13 = $this.closest('.ReactTags__tagInput')).call(_context13, 'input:text');

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
          _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(pTypes).call(pTypes, function (type, i) {
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

        var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default()(_context14 = _this.permission[pType]).call(_context14, function (tag) {
          return tag.id;
        });

        if (!bSameWord) {
          var _context15, _context16, _context17, _context18;

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context15 = $ul.closest('.ReactTags__tags')).call(_context15, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default()(_context16 = ids.join()).call(_context16));

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context17 = $ul.closest('.ReactTags__tags')).call(_context17, '.' + pType + 'Wrap').append(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context18 = "<span class=\"ReactTags__tag\">".concat(prefix + (tag.display_name || tag.name), "<a class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context18, tag.id, "\">x</a></span>"));
        }

        $ul.remove();
        $input.val('').data('index', -1).focus();
      });

      this.$wrapper.on('keyup', '.inputUserGroup', function (e) {
        var _context19;

        var query = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default()(_context19 = e.target.value).call(_context19);

        var $this = jquery__WEBPACK_IMPORTED_MODULE_11___default()(this);
        var keyCode = e.keyCode;

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          var _context20;

          if (_babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2___default()(_context20 = [Keys.ENTER, Keys.TAB, Keys.UP_ARROW, Keys.DOWN_ARROW, Keys.ESCAPE, 37, 39]).call(_context20, keyCode) == -1) {
            var _context21;

            var temp = '';
            temp += "<ul>";
            temp += "<li>Searching ... <span class=\"spinner\" role=\"spinner\"><span class=\"spinner-icon\"></span></span></li>";
            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context21 = $this.parent()).call(_context21, '.ReactTags__suggestions').html(temp);

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

          _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context22 = $this.parent()).call(_context22, '.ReactTags__suggestions').empty();
        }
      });
      this.$wrapper.on('click', '.btnRemoveTag', function (e) {
        e.preventDefault();

        _this.removeTag(jquery__WEBPACK_IMPORTED_MODULE_11___default()(this).closest('span'));
      });
    }
  }, {
    key: "makeIt",
    value: function makeIt(item, query) {
      var escapedRegex = _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default()(query).call(query).replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');

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

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(pTypes).call(pTypes, function (type, i) {
        if (type.id !== id) {
          var _context23;

          _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1___default()(_context23 = _this.permission[pType]).call(_context23, i, 1); // .push(tag);

        }
      });

      var ids = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default()(_context24 = _this.permission[pType]).call(_context24, function (tag) {
        return tag.id;
      });

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context25 = $target.closest('.ReactTags__tags')).call(_context25, '[name=' + name + ']').val(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default()(_context26 = ids.join()).call(_context26));

      $target.remove();
    }
  }, {
    key: "searchUser",
    value: function searchUser($input, keyword) {
      var _this = this;

      var searchUserUrl = _this.userSearchUrl;
      xe__WEBPACK_IMPORTED_MODULE_12__["default"].ajax({
        url: searchUserUrl + '/' + keyword,
        method: 'get',
        dataType: 'json',
        cache: false,
        success: function success(data) {
          if (data.length > 0) {
            var _context27;

            var temp = '';
            temp += "<ul data-target=\"user\">";

            _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(data).call(data, function (item, i) {
              temp += "<li class=\"\" data-tag='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0___default()(item), "'>");
              temp += "<span>".concat(_this.makeIt(item, keyword), "</span>");
              temp += "</li>";
            });

            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context27 = $input.parent()).call(_context27, '.ReactTags__suggestions').html(temp);
          } else {
            var _context28;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context28 = $input.parent()).call(_context28, '.ReactTags__suggestions').empty();
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
      xe__WEBPACK_IMPORTED_MODULE_12__["default"].ajax({
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

            _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(data).call(data, function (item, i) {
              temp += "<li data-tag='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0___default()(item), "'>");
              temp += "<span>".concat(_this.makeIt(item, keyword), "</span>");
              temp += "</li>";
            });

            temp += "</ul>";

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context29 = $input.parent()).call(_context29, '.ReactTags__suggestions').html(temp);
          } else {
            var _context30;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_8___default()(_context30 = $input.parent()).call(_context30, '.ReactTags__suggestions').empty();
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
        name: xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::userRatingAdministrator')
      }, {
        value: 'manager',
        name: xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::userRatingManager')
      }, {
        value: 'user',
        name: xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::user')
      }, {
        value: 'guest',
        name: xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::guest')
      }];
      var disabled = false;

      if (mode === 'manual' || mode === 'inherit') {
        modeEnable = true;

        if (mode !== 'manual') {
          disabled = true;
        }
      }

      var includeGroups = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default()(_context31 = this.permission.group).call(_context31, function (group) {
        return group.id;
      });

      var includeUsers = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default()(_context32 = this.permission.user).call(_context32, function (user) {
        return user.id;
      });

      var excludeUsers = _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default()(_context33 = this.permission.except).call(_context33, function (user) {
        return user.id;
      });

      var temp = '';
      temp += "<div>";

      if (modeEnable) {
        var _context34, _context35;

        var checked = mode === 'inherit' ? 'checked="checked"' : '';
        temp += "<div class=\"form-group\">";
        temp += "<div class=\"checkbox\">";
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context34 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context35 = "<label><input type=\"checkbox\" name=\"".concat(this.type + 'Mode', "\" class=\"chkModeAble\" value=\"inherit\" ")).call(_context35, checked, " /> ")).call(_context34, xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::inheritMode'), "</label>");
        temp += "</div>";
        temp += "</div>";
      }

      temp += "<div class=\"form-group\">";
      temp += "<label>\uD68C\uC6D0 \uB4F1\uAE09</label>";
      temp += '<div class="radio">';

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(permissionTypes).call(permissionTypes, function (permissionType) {
        var _context36, _context37, _context38, _context39;

        var checked = permissionType.value == rating ? 'checked' : '';
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context36 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context37 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context38 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context39 = "<label><input type=\"radio\" ".concat(disabled ? 'disabled="disabled"' : '', " name=\"")).call(_context39, _this.type + 'Rating', "\" value=\"")).call(_context38, permissionType.value, "\" ")).call(_context37, checked ? 'checked="checked"' : '', " /> ")).call(_context36, permissionType.name, " &nbsp;</label>");
      });

      temp += "</div>";
      temp += "</div>";
      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::includeUserOrGroup'), "</label>");
      temp += "<div class=\"ReactTags__tags\">";
      temp += "<div class=\"ReactTags__selected groupWrap\" data-ptype=\"group\">";

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(_context40 = this.permission.group).call(_context40, function (g) {
        var _context41;

        var tag = g;
        var label = '%' + (tag.display_name || tag.name);
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context41 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context41, tag.id, "\">x</a></span>");
      });

      temp += '</div>';
      temp += '<div class="ReactTags__selected userWrap" data-ptype="user">';

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(_context42 = this.permission.user).call(_context42, function (tag) {
        var _context43;

        var label = '@' + (tag.display_name || tag.name);
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context43 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context43, tag.id, "|\">x</a></span>");
      });

      temp += "</div>";
      temp += "<div class=\"ReactTags__tagInput\">";
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context44 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context45 = "<input type=\"text\" placeholder=\"".concat(this.placeholder, "\" class=\"form-control inputUserGroup\" data-input=\"include\" ")).call(_context45, disabled ? 'disabled="disabled"' : '', " value=\"")).call(_context44, this.query, "\" data-index=\"-1\" />"); // TODO:: PermissionInclude handleKeyDown

      temp += "<div class=\"ReactTags__suggestions\" data-input=\"include\"></div>";
      temp += "</div>"; // ReactTags__tagInput

      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context46 = "<input type=\"hidden\" name=\"".concat(this.type + 'Group', "\" class=\"form-control includeGroups\" value=\"")).call(_context46, _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default()(_context47 = includeGroups.join()).call(_context47), "\" />");
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context48 = "<input type=\"hidden\" name=\"".concat(this.type + 'User', "\" class=\"form-control includeUsers\" value=\"")).call(_context48, _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_7___default()(_context49 = includeUsers.join()).call(_context49), "\" />");
      temp += "</div>"; // ReactTags__tags

      temp += "</div>"; // form-group

      if (this.vgroupAll.length >= 1) {
        var _context50;

        temp += "<div class=\"form-group\">";
        temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::includeVGroup'), "</label>");
        temp += _babel_runtime_corejs3_core_js_stable_instance_map__WEBPACK_IMPORTED_MODULE_4___default()(_context50 = _this.vgroupAll).call(_context50, function (data) {
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

          return _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context51 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context52 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context53 = _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context54 = "<label><input type=\"checkbox\" ".concat(disabled ? 'disabled="disabled"' : '', " name=\"")).call(_context54, _this.type + 'VGroup[]', "\" value=\"")).call(_context53, data.id, "\" ")).call(_context52, checked ? 'checked="checked"' : '', " /> ")).call(_context51, data.title, " &nbsp;</label>");
        });
        temp += '</div>';
      }

      temp += "<div class=\"form-group\">";
      temp += "<label>".concat(xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::excludeUser'), "</label>");
      temp += "<div class=\"ReactTags__tags\">";
      temp += "<div class=\"ReactTags__selected exceptWrap\" data-ptype=\"except\">";

      _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(_context55 = this.permission.except).call(_context55, function (tag) {
        var _context56;

        var label = tag.display_name || tag.name;
        label = '@' + label;
        temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context56 = "<span class=\"ReactTags__tag\">".concat(label, "<a href=\"#\" class=\"ReactTags__remove btnRemoveTag\" data-id=\"")).call(_context56, tag.id, "\">x</a></span>");
      });

      temp += "</div>";
      temp += "<div class=\"ReactTags__tagInput\">";
      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context57 = "<input type=\"text\" placeholder=\"".concat(xe__WEBPACK_IMPORTED_MODULE_12__["default"].Lang.trans('xe::explainExcludeUser'), "\" class=\"form-control inputUserGroup\" data-input=\"exclude\" ")).call(_context57, disabled ? 'disabled="disabled"' : '', " data-index=\"-1\" />"); // TODO:: PermissionExclude handleKeyDown

      temp += "<div class=\"ReactTags__suggestions\" data-input=\"exclude\"></div>";
      temp += "</div>"; // ReactTags__tagInput

      temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_3___default()(_context58 = "<input type=\"hidden\" name=\"".concat(this.type + 'Except', "\" class=\"form-control excludeUsers\" value=\"")).call(_context58, excludeUsers, "\" />");
      temp += "</div>"; // ReactTags__tags

      temp += "</div>"; // form-group

      temp += "</div>";
      this.$wrapper.html(temp);
    }
  }]);

  return Permission;
}();

jquery__WEBPACK_IMPORTED_MODULE_11___default()('.__xe__uiobject_permission').each(function (i) {
  var $this = jquery__WEBPACK_IMPORTED_MODULE_11___default()(this);
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(90);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(16);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js":
/*!************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/map.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(284);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(52);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(15);

/***/ }),

/***/ "./node_modules/core-js-pure/stable/json/stringify.js":
/*!************************************************************!*\
  !*** ./node_modules/core-js-pure/stable/json/stringify.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ../../es/json/stringify */ "./node_modules/core-js-pure/es/json/stringify.js");


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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL2NvcmUvaW5kZXguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL2NvcmUvcGVybWlzc2lvbi9wZXJtaXNzaW9uLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9jb25jYXQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9maW5kLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvZm9yLWVhY2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9pbmRleC1vZi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL21hcC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL3NwbGljZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL3RyaW0uanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9wYXJzZS1pbnQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NsYXNzQ2FsbENoZWNrLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jcmVhdGVDbGFzcy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9lcy9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9pbnRlcm5hbHMvcGF0aC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9zdGFibGUvanNvbi9zdHJpbmdpZnkuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9qcXVlcnkvc3JjL2pxdWVyeS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2V4dGVybmFsIFwiX3hlX2RsbF9jb21tb25cIiJdLCJuYW1lcyI6WyJLZXlzIiwiRU5URVIiLCJUQUIiLCJCQUNLU1BBQ0UiLCJVUF9BUlJPVyIsIkRPV05fQVJST1ciLCJFU0NBUEUiLCJQZXJtaXNzaW9uIiwiJHdyYXBwZXIiLCJrZXkiLCJ1c2VyU2VhcmNoVXJsIiwiZ3JvdXBTZWFyY2hVcmwiLCJwZXJtaXNzaW9uIiwidHlwZSIsInZncm91cEFsbCIsInF1ZXJ5Iiwic3VnZ2VzdGlvbiIsInBsYWNlaG9sZGVyIiwiWEUiLCJMYW5nIiwidHJhbnMiLCJzZWxlY3RlZEluZGV4IiwiaW5jbHVkZVNlbGVjdGVkSW5kZXgiLCJleGNsdWRlU2VsZWN0ZWRJbmRleCIsIk1JTl9RVUVSWV9MRU5HVEgiLCJfdGhpcyIsIm9uIiwiZSIsIiR0YXJnZXQiLCIkIiwidGFyZ2V0IiwiY2hlY2tlZCIsImlzIiwicHJvcCIsInZhbHVlIiwiJHRoaXMiLCJrZXlDb2RlIiwiJHVsIiwicGFyZW50IiwiZGF0YUlucHV0IiwiZGF0YSIsImxlbmd0aCIsImluZGV4IiwiZm9jdXNlZEluZGV4IiwiZXEiLCJhZGRDbGFzcyIsInNpYmxpbmdzIiwicmVtb3ZlQ2xhc3MiLCJwcmV2ZW50RGVmYXVsdCIsInRhZyIsIm5hbWUiLCJwVHlwZSIsInByZWZpeCIsInBUeXBlcyIsImJTYW1lV29yZCIsImkiLCJpZCIsInB1c2giLCJpZHMiLCJjbG9zZXN0IiwidmFsIiwiam9pbiIsImFwcGVuZCIsImRpc3BsYXlfbmFtZSIsInJlbW92ZSIsImZvY3VzIiwiZW1wdHkiLCIkdGFnIiwicmVtb3ZlVGFnIiwiJGlucHV0IiwidGVtcCIsImh0bWwiLCJpZGVudGlmaWVyIiwic3Vic3RyIiwic2VhcmNoVXNlciIsInNlYXJjaEdyb3VwIiwiaXRlbSIsImVzY2FwZWRSZWdleCIsInJlcGxhY2UiLCJyIiwiUmVnRXhwIiwiaXRlbU5hbWUiLCJrZXl3b3JkIiwic2VhcmNoVXNlclVybCIsImFqYXgiLCJ1cmwiLCJtZXRob2QiLCJkYXRhVHlwZSIsImNhY2hlIiwic3VjY2VzcyIsIm1ha2VJdCIsImVycm9yIiwieGhyIiwic3RhdHVzIiwiZXJyIiwic2VhcmNoR3JvdXBVcmwiLCJtb2RlIiwicmF0aW5nIiwibW9kZUVuYWJsZSIsInBlcm1pc3Npb25UeXBlcyIsImRpc2FibGVkIiwiaW5jbHVkZUdyb3VwcyIsImdyb3VwIiwiaW5jbHVkZVVzZXJzIiwidXNlciIsImV4Y2x1ZGVVc2VycyIsImV4Y2VwdCIsInBlcm1pc3Npb25UeXBlIiwiZyIsImxhYmVsIiwiaW5BcnJheSIsImFyciIsInZncm91cCIsInRpdGxlIiwiZWFjaCIsInAiLCJyZW5kZXIiLCJiaW5kRXZlbnRzIl0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7OztBQUdBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxrREFBMEMsZ0NBQWdDO0FBQzFFO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsZ0VBQXdELGtCQUFrQjtBQUMxRTtBQUNBLHlEQUFpRCxjQUFjO0FBQy9EOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpREFBeUMsaUNBQWlDO0FBQzFFLHdIQUFnSCxtQkFBbUIsRUFBRTtBQUNySTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLG1DQUEyQiwwQkFBMEIsRUFBRTtBQUN2RCx5Q0FBaUMsZUFBZTtBQUNoRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQSw4REFBc0QsK0RBQStEOztBQUVySDtBQUNBOzs7QUFHQTtBQUNBOzs7Ozs7Ozs7Ozs7QUNsRkEsZ0g7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7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QUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsaUJBQWlCLG1CQUFPLENBQUMsZ0dBQW9DLEU7Ozs7Ozs7Ozs7O0FDQTdELDhHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7OztBQ0FBLDhHOzs7Ozs7Ozs7OztBQ0FBLFdBQVcsbUJBQU8sQ0FBQywyRUFBc0I7QUFDekMsdUNBQXVDLDRCQUE0Qjs7QUFFbkUseUNBQXlDO0FBQ3pDO0FBQ0E7Ozs7Ozs7Ozs7OztBQ0xBLCtHOzs7Ozs7Ozs7OztBQ0FBLGlCQUFpQixtQkFBTyxDQUFDLGlGQUF5Qjs7Ozs7Ozs7Ozs7O0FDQWxELDhHOzs7Ozs7Ozs7OztBQ0FBLGdDIiwiZmlsZSI6ImFzc2V0cy9jb3JlL3Blcm1pc3Npb24vcGVybWlzc2lvbi5idW5kbGUuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIlwiO1xuXG5cbiBcdC8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuIFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oX193ZWJwYWNrX3JlcXVpcmVfXy5zID0gXCIuL2NvcmUvcGVybWlzc2lvbi9wZXJtaXNzaW9uLmpzXCIpO1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDMyNSk7IiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IFhFIGZyb20gJ3hlJ1xuXG4vLyBUT0RPOjogbW91c2VvdmVyLFxuXG5jb25zdCBLZXlzID0ge1xuICBFTlRFUjogMTMsXG4gIFRBQjogOSxcbiAgQkFDS1NQQUNFOiA4LFxuICBVUF9BUlJPVzogMzgsXG4gIERPV05fQVJST1c6IDQwLFxuICBFU0NBUEU6IDI3XG59XG5cbmNsYXNzIFBlcm1pc3Npb24ge1xuICBjb25zdHJ1Y3RvciAoeyAkd3JhcHBlciwga2V5LCB1c2VyU2VhcmNoVXJsLCBncm91cFNlYXJjaFVybCwgcGVybWlzc2lvbiwgdHlwZSwgdmdyb3VwQWxsIH0pIHtcbiAgICB0aGlzLiR3cmFwcGVyID0gJHdyYXBwZXJcbiAgICB0aGlzLmtleSA9IGtleVxuICAgIHRoaXMudXNlclNlYXJjaFVybCA9IHVzZXJTZWFyY2hVcmxcbiAgICB0aGlzLmdyb3VwU2VhcmNoVXJsID0gZ3JvdXBTZWFyY2hVcmxcbiAgICB0aGlzLnBlcm1pc3Npb24gPSBwZXJtaXNzaW9uXG4gICAgdGhpcy50eXBlID0gdHlwZVxuICAgIHRoaXMudmdyb3VwQWxsID0gdmdyb3VwQWxsXG4gICAgdGhpcy5xdWVyeSA9ICcnXG4gICAgdGhpcy5zdWdnZXN0aW9uID0gW11cbiAgICB0aGlzLnBsYWNlaG9sZGVyID0gWEUuTGFuZy50cmFucygneGU6OmV4cGxhaW5JbmNsdWRlVXNlck9yR3JvdXAnKVxuICAgIHRoaXMuc2VsZWN0ZWRJbmRleCA9ICcnXG4gICAgdGhpcy5pbmNsdWRlU2VsZWN0ZWRJbmRleCA9IC0xXG4gICAgdGhpcy5leGNsdWRlU2VsZWN0ZWRJbmRleCA9IC0xXG4gICAgdGhpcy5NSU5fUVVFUllfTEVOR1RIID0gMlxuICB9XG5cbiAgYmluZEV2ZW50cyAoKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuXG4gICAgdGhpcy4kd3JhcHBlci5vbignY2hhbmdlJywgJy5jaGtNb2RlQWJsZScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgJHRhcmdldCA9ICQoZS50YXJnZXQpXG4gICAgICB2YXIgY2hlY2tlZCA9ICR0YXJnZXQuaXMoJzpjaGVja2VkJylcblxuICAgICAgaWYgKGNoZWNrZWQpIHtcbiAgICAgICAgX3RoaXMuJHdyYXBwZXIuZmluZCgnaW5wdXQ6bm90KC5jaGtNb2RlQWJsZSknKS5wcm9wKCdkaXNhYmxlZCcsIHRydWUpXG4gICAgICB9IGVsc2Uge1xuICAgICAgICBfdGhpcy4kd3JhcHBlci5maW5kKCdpbnB1dDpub3QoLmNoa01vZGVBYmxlKScpLnByb3AoJ2Rpc2FibGVkJywgZmFsc2UpXG4gICAgICB9XG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIub24oJ2tleWRvd24nLCAnLmlucHV0VXNlckdyb3VwJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIHZhciBxdWVyeSA9IGUudGFyZ2V0LnZhbHVlLnRyaW0oKVxuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyIGtleUNvZGUgPSBlLmtleUNvZGVcbiAgICAgIHZhciAkdWwgPSAkdGhpcy5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucyB1bCcpXG4gICAgICB2YXIgZGF0YUlucHV0ID0gJHRoaXMuZGF0YSgnaW5wdXQnKSAvLyBpbmNsdWRlLCBleGNsdWRlXG5cbiAgICAgIGlmIChxdWVyeS5sZW5ndGggPj0gX3RoaXMuTUlOX1FVRVJZX0xFTkdUSCkge1xuICAgICAgICBpZiAoJHVsLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICB2YXIgaW5kZXggPSBwYXJzZUludCgkdGhpcy5kYXRhKCdpbmRleCcpLCAxMClcbiAgICAgICAgICB2YXIgZm9jdXNlZEluZGV4ID0gMFxuXG4gICAgICAgICAgc3dpdGNoIChrZXlDb2RlKSB7XG4gICAgICAgICAgICBjYXNlIEtleXMuVVBfQVJST1cgOlxuICAgICAgICAgICAgICBpZiAoaW5kZXggPT0gMCkge1xuICAgICAgICAgICAgICAgIGZvY3VzZWRJbmRleCA9ICR1bC5maW5kKCdsaScpLmxlbmd0aCAtIDFcbiAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBmb2N1c2VkSW5kZXggPSAoaW5kZXggLSAxKVxuICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgJHRoaXMuZGF0YSgnaW5kZXgnLCBmb2N1c2VkSW5kZXgpXG4gICAgICAgICAgICAgICR1bC5maW5kKCdsaScpLmVxKGZvY3VzZWRJbmRleCkuYWRkQ2xhc3MoJ2FjdGl2ZScpLnNpYmxpbmdzKCkucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpXG5cbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICAgIGNhc2UgS2V5cy5ET1dOX0FSUk9XIDpcbiAgICAgICAgICAgICAgaWYgKGluZGV4ID09ICR1bC5maW5kKCdsaScpLmxlbmd0aCAtIDEpIHtcbiAgICAgICAgICAgICAgICBmb2N1c2VkSW5kZXggPSAwXG4gICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgZm9jdXNlZEluZGV4ID0gaW5kZXggKyAxXG4gICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAkdGhpcy5kYXRhKCdpbmRleCcsIGZvY3VzZWRJbmRleClcbiAgICAgICAgICAgICAgJHVsLmZpbmQoJ2xpJykuZXEoZm9jdXNlZEluZGV4KS5hZGRDbGFzcygnYWN0aXZlJykuc2libGluZ3MoKS5yZW1vdmVDbGFzcygnYWN0aXZlJylcblxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgICAgY2FzZSBLZXlzLkVOVEVSIDpcbiAgICAgICAgICAgIGNhc2UgS2V5cy5UQUIgOlxuICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KClcblxuICAgICAgICAgICAgICBpZiAoJHVsLmZpbmQoJ2xpLmFjdGl2ZScpLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFnID0gJHVsLmZpbmQoJ2xpLmFjdGl2ZScpLmRhdGEoJ3RhZycpXG4gICAgICAgICAgICAgICAgdmFyIG5hbWUgPSAnJ1xuICAgICAgICAgICAgICAgIHZhciBwVHlwZSA9ICcnXG4gICAgICAgICAgICAgICAgdmFyIHByZWZpeCA9ICcnXG5cbiAgICAgICAgICAgICAgICAvLyB1c2VyXG4gICAgICAgICAgICAgICAgaWYgKCR1bC5kYXRhKCd0YXJnZXQnKSA9PSAndXNlcicpIHtcbiAgICAgICAgICAgICAgICAgIC8vIGluY2x1ZGVcbiAgICAgICAgICAgICAgICAgIGlmIChkYXRhSW5wdXQgPT0gJ2luY2x1ZGUnKSB7XG4gICAgICAgICAgICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ1VzZXInXG4gICAgICAgICAgICAgICAgICAgIHBUeXBlID0gJ3VzZXInXG4gICAgICAgICAgICAgICAgICAgIHByZWZpeCA9ICdAJ1xuICAgICAgICAgICAgICAgICAgICAvLyBleGNsdWRlXG4gICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdFeGNlcHQnXG4gICAgICAgICAgICAgICAgICAgIHBUeXBlID0gJ2V4Y2VwdCdcbiAgICAgICAgICAgICAgICAgICAgcHJlZml4ID0gJ0AnXG4gICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAvLyBncm91cFxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdHcm91cCdcbiAgICAgICAgICAgICAgICAgIHBUeXBlID0gJ2dyb3VwJ1xuICAgICAgICAgICAgICAgICAgcHJlZml4ID0gJyUnXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgdmFyIHBUeXBlcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdXG4gICAgICAgICAgICAgICAgdmFyIGJTYW1lV29yZCA9IGZhbHNlXG5cbiAgICAgICAgICAgICAgICBpZiAocFR5cGVzLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICAgICAgIHBUeXBlcy5mb3JFYWNoKGZ1bmN0aW9uICh0eXBlLCBpKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmICh0eXBlLmlkID09PSB0YWcuaWQpIHtcbiAgICAgICAgICAgICAgICAgICAgICBiU2FtZVdvcmQgPSB0cnVlXG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgIH0pXG5cbiAgICAgICAgICAgICAgICAgIGlmICghYlNhbWVXb3JkKSB7XG4gICAgICAgICAgICAgICAgICAgIF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLnB1c2godGFnKVxuICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5wdXNoKHRhZylcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB2YXIgaWRzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV0ubWFwKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgICAgICAgICAgICAgIHJldHVybiB0YWcuaWRcbiAgICAgICAgICAgICAgICB9KVxuXG4gICAgICAgICAgICAgICAgaWYgKCFiU2FtZVdvcmQpIHtcbiAgICAgICAgICAgICAgICAgICR1bC5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnW25hbWU9JyArIG5hbWUgKyAnXScpLnZhbChpZHMuam9pbigpLnRyaW0oKSlcbiAgICAgICAgICAgICAgICAgICR1bC5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnLicgKyBwVHlwZSArICdXcmFwJylcbiAgICAgICAgICAgICAgICAgICAgLmFwcGVuZChgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7cHJlZml4ICsgKHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWUpfTxhIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfVwiPng8L2E+PC9zcGFuPmApXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgJHVsLnJlbW92ZSgpXG4gICAgICAgICAgICAgICAgJHRoaXMudmFsKCcnKS5kYXRhKCdpbmRleCcsIC0xKS5mb2N1cygpXG4gICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KClcdC8vIHByZXZlbnQgdGFiXG5cbiAgICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICAgIGNhc2UgS2V5cy5FU0NBUEUgOlxuICAgICAgICAgICAgICBfdGhpc1tkYXRhSW5wdXQgKyAnU2VsZWN0ZWRJbmRleCddID0gMFxuICAgICAgICAgICAgICAkdWwucGFyZW50KCkuZW1wdHkoKVxuICAgICAgICAgICAgICAkdGhpcy5mb2N1cygpXG4gICAgICAgICAgICAgIGJyZWFrXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9IGVsc2Uge1xuICAgICAgICBpZiAoS2V5cy5CQUNLU1BBQ0UgPT09IGtleUNvZGUpIHtcbiAgICAgICAgICB2YXIgJHRhZyA9ICR0aGlzLmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3RhZ3MnKS5maW5kKCcuUmVhY3RUYWdzX19zZWxlY3RlZCBzcGFuJylcbiAgICAgICAgICBpZiAoIXF1ZXJ5ICYmICR0YWcubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgX3RoaXMucmVtb3ZlVGFnKCR0YWcuZXEoJHRhZy5sZW5ndGggLSAxKSlcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH1cbiAgICB9KVxuXG4gICAgdGhpcy4kd3JhcHBlci5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLm9uKCdtb3VzZWVudGVyJywgJ2xpJywgZnVuY3Rpb24gKCkge1xuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyICR1bCA9ICR0aGlzLmNsb3Nlc3QoJ3VsJylcblxuICAgICAgJHRoaXMuYWRkQ2xhc3MoJ2FjdGl2ZScpLnNpYmxpbmdzKCkucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpXG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5vbignY2xpY2snLCAnbGknLCBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIgdGFnID0gJHRoaXMuZGF0YSgndGFnJylcbiAgICAgIHZhciAkdWwgPSAkdGhpcy5jbG9zZXN0KCd1bCcpXG4gICAgICB2YXIgJGlucHV0ID0gJHRoaXMuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFnSW5wdXQnKS5maW5kKCdpbnB1dDp0ZXh0JylcbiAgICAgIHZhciBkYXRhSW5wdXQgPSAkaW5wdXQuZGF0YSgnaW5wdXQnKVxuICAgICAgdmFyIGlkID0gdGFnLmlkXG4gICAgICB2YXIgbmFtZSA9ICcnXG4gICAgICB2YXIgcFR5cGUgPSAnJ1xuICAgICAgdmFyIHByZWZpeCA9ICcnXG5cbiAgICAgIGlmICgkdWwuZGF0YSgndGFyZ2V0JykgPT0gJ3VzZXInKSB7XG4gICAgICAgIC8vIGluY2x1ZGVcbiAgICAgICAgaWYgKGRhdGFJbnB1dCA9PSAnaW5jbHVkZScpIHtcbiAgICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdVc2VyJ1xuICAgICAgICAgIHBUeXBlID0gJ3VzZXInXG4gICAgICAgICAgcHJlZml4ID0gJ0AnXG4gICAgICAgICAgLy8gZXhjbHVkZVxuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0V4Y2VwdCdcbiAgICAgICAgICBwVHlwZSA9ICdleGNlcHQnXG4gICAgICAgICAgcHJlZml4ID0gJ0AnXG4gICAgICAgIH1cbiAgICAgICAgLy8gZ3JvdXBcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIG5hbWUgPSBfdGhpcy50eXBlICsgJ0dyb3VwJ1xuICAgICAgICBwVHlwZSA9ICdncm91cCdcbiAgICAgICAgcHJlZml4ID0gJyUnXG4gICAgICB9XG5cbiAgICAgIHZhciBwVHlwZXMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXVxuICAgICAgdmFyIGJTYW1lV29yZCA9IGZhbHNlXG5cbiAgICAgIGlmIChwVHlwZXMubGVuZ3RoID4gMCkge1xuICAgICAgICBwVHlwZXMuZm9yRWFjaChmdW5jdGlvbiAodHlwZSwgaSkge1xuICAgICAgICAgIGlmICh0eXBlLmlkID09PSB0YWcuaWQpIHtcbiAgICAgICAgICAgIGJTYW1lV29yZCA9IHRydWVcbiAgICAgICAgICB9XG4gICAgICAgIH0pXG5cbiAgICAgICAgaWYgKCFiU2FtZVdvcmQpIHtcbiAgICAgICAgICBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5wdXNoKHRhZylcbiAgICAgICAgfVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0ucHVzaCh0YWcpXG4gICAgICB9XG5cbiAgICAgIHZhciBpZHMgPSBfdGhpcy5wZXJtaXNzaW9uW3BUeXBlXS5tYXAoZnVuY3Rpb24gKHRhZykge1xuICAgICAgICByZXR1cm4gdGFnLmlkXG4gICAgICB9KVxuXG4gICAgICBpZiAoIWJTYW1lV29yZCkge1xuICAgICAgICAkdWwuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJ1tuYW1lPScgKyBuYW1lICsgJ10nKS52YWwoaWRzLmpvaW4oKS50cmltKCkpXG4gICAgICAgICR1bC5jbG9zZXN0KCcuUmVhY3RUYWdzX190YWdzJykuZmluZCgnLicgKyBwVHlwZSArICdXcmFwJylcbiAgICAgICAgICAuYXBwZW5kKGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtwcmVmaXggKyAodGFnLmRpc3BsYXlfbmFtZSB8fCB0YWcubmFtZSl9PGEgY2xhc3M9XCJSZWFjdFRhZ3NfX3JlbW92ZSBidG5SZW1vdmVUYWdcIiBkYXRhLWlkPVwiJHt0YWcuaWR9XCI+eDwvYT48L3NwYW4+YClcbiAgICAgIH1cblxuICAgICAgJHVsLnJlbW92ZSgpXG4gICAgICAkaW5wdXQudmFsKCcnKS5kYXRhKCdpbmRleCcsIC0xKS5mb2N1cygpXG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIub24oJ2tleXVwJywgJy5pbnB1dFVzZXJHcm91cCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgcXVlcnkgPSBlLnRhcmdldC52YWx1ZS50cmltKClcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgIHZhciBrZXlDb2RlID0gZS5rZXlDb2RlXG5cbiAgICAgIGlmIChxdWVyeS5sZW5ndGggPj0gX3RoaXMuTUlOX1FVRVJZX0xFTkdUSCkge1xuICAgICAgICBpZiAoW0tleXMuRU5URVIsIEtleXMuVEFCLCBLZXlzLlVQX0FSUk9XLCBLZXlzLkRPV05fQVJST1csIEtleXMuRVNDQVBFLCAzNywgMzldLmluZGV4T2Yoa2V5Q29kZSkgPT0gLTEpIHtcbiAgICAgICAgICB2YXIgdGVtcCA9ICcnXG4gICAgICAgICAgdGVtcCArPSBcdGA8dWw+YFxuICAgICAgICAgIHRlbXAgKz1cdFx0XHRgPGxpPlNlYXJjaGluZyAuLi4gPHNwYW4gY2xhc3M9XCJzcGlubmVyXCIgcm9sZT1cInNwaW5uZXJcIj48c3BhbiBjbGFzcz1cInNwaW5uZXItaWNvblwiPjwvc3Bhbj48L3NwYW4+PC9saT5gXG4gICAgICAgICAgdGVtcCArPSBcdGA8L3VsPmBcblxuICAgICAgICAgICR0aGlzLnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuaHRtbCh0ZW1wKVxuXG4gICAgICAgICAgdmFyIGlkZW50aWZpZXIgPSBxdWVyeS5zdWJzdHIoMCwgMSlcbiAgICAgICAgICBzd2l0Y2ggKGlkZW50aWZpZXIpIHtcbiAgICAgICAgICAgIGNhc2UgJ0AnOlxuICAgICAgICAgICAgICBxdWVyeSA9IHF1ZXJ5LnN1YnN0cigxLCBxdWVyeS5sZW5ndGgpXG4gICAgICAgICAgICAgIF90aGlzLnNlYXJjaFVzZXIoJHRoaXMsIHF1ZXJ5KVxuICAgICAgICAgICAgICBicmVha1xuXG4gICAgICAgICAgICBjYXNlICclJzpcbiAgICAgICAgICAgICAgcXVlcnkgPSBxdWVyeS5zdWJzdHIoMSwgcXVlcnkubGVuZ3RoKVxuICAgICAgICAgICAgICBfdGhpcy5zZWFyY2hHcm91cCgkdGhpcywgcXVlcnkpXG4gICAgICAgICAgICAgIGJyZWFrXG5cbiAgICAgICAgICAgIGRlZmF1bHQgOlxuICAgICAgICAgICAgICBicmVha1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgJHRoaXMucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5lbXB0eSgpXG4gICAgICB9XG4gICAgfSlcblxuICAgIHRoaXMuJHdyYXBwZXIub24oJ2NsaWNrJywgJy5idG5SZW1vdmVUYWcnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgIF90aGlzLnJlbW92ZVRhZygkKHRoaXMpLmNsb3Nlc3QoJ3NwYW4nKSlcbiAgICB9KVxuICB9XG5cbiAgbWFrZUl0IChpdGVtLCBxdWVyeSkge1xuICAgIHZhciBlc2NhcGVkUmVnZXggPSBxdWVyeS50cmltKCkucmVwbGFjZSgvWy1cXFxcXiQqKz8uKCl8W1xcXXt9XS9nLCAnXFxcXCQmJylcbiAgICB2YXIgciA9IFJlZ0V4cChlc2NhcGVkUmVnZXgsICdnaScpXG4gICAgdmFyIGl0ZW1OYW1lID0gaXRlbS5kaXNwbGF5X25hbWUgfHwgaXRlbS5uYW1lXG5cbiAgICByZXR1cm4gaXRlbU5hbWUucmVwbGFjZShyLCAnPG1hcms+JCY8L21hcms+JylcbiAgfVxuXG4gIHJlbW92ZVRhZyAoJHRhcmdldCkge1xuICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICB2YXIgcFR5cGUgPSAkdGFyZ2V0LmNsb3Nlc3QoJy5SZWFjdFRhZ3NfX3NlbGVjdGVkJykuZGF0YSgncHR5cGUnKVxuICAgIHZhciBpZCA9ICR0YXJnZXQuZGF0YSgnaWQnKVxuICAgIHZhciBuYW1lID0gJydcblxuICAgIHN3aXRjaCAocFR5cGUpIHtcbiAgICAgIGNhc2UgJ3VzZXInIDpcbiAgICAgICAgbmFtZSA9IF90aGlzLnR5cGUgKyAnVXNlcidcbiAgICAgICAgYnJlYWtcbiAgICAgIGNhc2UgJ2V4Y2VwdCcgOlxuICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdFeGNlcHQnXG4gICAgICAgIGJyZWFrXG4gICAgICBjYXNlICdncm91cCcgOlxuICAgICAgICBuYW1lID0gX3RoaXMudHlwZSArICdHcm91cCdcbiAgICAgICAgYnJlYWtcbiAgICB9XG5cbiAgICB2YXIgcFR5cGVzID0gX3RoaXMucGVybWlzc2lvbltwVHlwZV1cblxuICAgIHBUeXBlcy5mb3JFYWNoKGZ1bmN0aW9uICh0eXBlLCBpKSB7XG4gICAgICBpZiAodHlwZS5pZCAhPT0gaWQpIHtcbiAgICAgICAgX3RoaXMucGVybWlzc2lvbltwVHlwZV0uc3BsaWNlKGksIDEpLy8gLnB1c2godGFnKTtcbiAgICAgIH1cbiAgICB9KVxuXG4gICAgdmFyIGlkcyA9IF90aGlzLnBlcm1pc3Npb25bcFR5cGVdLm1hcChmdW5jdGlvbiAodGFnKSB7XG4gICAgICByZXR1cm4gdGFnLmlkXG4gICAgfSlcblxuICAgICR0YXJnZXQuY2xvc2VzdCgnLlJlYWN0VGFnc19fdGFncycpLmZpbmQoJ1tuYW1lPScgKyBuYW1lICsgJ10nKS52YWwoaWRzLmpvaW4oKS50cmltKCkpXG4gICAgJHRhcmdldC5yZW1vdmUoKVxuICB9XG5cbiAgc2VhcmNoVXNlciAoJGlucHV0LCBrZXl3b3JkKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHZhciBzZWFyY2hVc2VyVXJsID0gX3RoaXMudXNlclNlYXJjaFVybFxuXG4gICAgWEUuYWpheCh7XG4gICAgICB1cmw6IHNlYXJjaFVzZXJVcmwgKyAnLycgKyBrZXl3b3JkLFxuICAgICAgbWV0aG9kOiAnZ2V0JyxcbiAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICBjYWNoZTogZmFsc2UsXG4gICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICBpZiAoZGF0YS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgdmFyIHRlbXAgPSAnJ1xuICAgICAgICAgIHRlbXAgKz0gXHRgPHVsIGRhdGEtdGFyZ2V0PVwidXNlclwiPmBcblxuICAgICAgICAgIGRhdGEuZm9yRWFjaChmdW5jdGlvbiAoaXRlbSwgaSkge1xuICAgICAgICAgICAgdGVtcCArPSBcdFx0YDxsaSBjbGFzcz1cIlwiIGRhdGEtdGFnPScke0pTT04uc3RyaW5naWZ5KGl0ZW0pfSc+YFxuICAgICAgICAgICAgdGVtcCArPSBcdFx0XHRgPHNwYW4+JHtfdGhpcy5tYWtlSXQoaXRlbSwga2V5d29yZCl9PC9zcGFuPmBcbiAgICAgICAgICAgIHRlbXAgKz0gXHRcdGA8L2xpPmBcbiAgICAgICAgICB9KVxuXG4gICAgICAgICAgdGVtcCArPSBcdGA8L3VsPmBcblxuICAgICAgICAgICRpbnB1dC5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmh0bWwodGVtcClcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAkaW5wdXQucGFyZW50KCkuZmluZCgnLlJlYWN0VGFnc19fc3VnZ2VzdGlvbnMnKS5lbXB0eSgpXG4gICAgICAgIH1cbiAgICAgIH0sXG4gICAgICBlcnJvcjogZnVuY3Rpb24gKHhociwgc3RhdHVzLCBlcnIpIHtcblxuICAgICAgfVxuICAgIH0pXG4gIH1cblxuICBzZWFyY2hHcm91cCAoJGlucHV0LCBrZXl3b3JkKSB7XG4gICAgdmFyIF90aGlzID0gdGhpc1xuICAgIHZhciBzZWFyY2hHcm91cFVybCA9IF90aGlzLmdyb3VwU2VhcmNoVXJsXG5cbiAgICBYRS5hamF4KHtcbiAgICAgIHVybDogc2VhcmNoR3JvdXBVcmwgKyAnLycgKyBrZXl3b3JkLFxuICAgICAgbWV0aG9kOiAnZ2V0JyxcbiAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICBjYWNoZTogZmFsc2UsXG4gICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICAvLyBUT0RPOjogdmlldyByZW5kZXJpblxuICAgICAgICBpZiAoZGF0YS5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgdmFyIHRlbXAgPSAnJ1xuICAgICAgICAgIHRlbXAgKz0gXHRgPHVsIGRhdGEtdGFyZ2V0PVwiZ3JvdXBcIj5gXG5cbiAgICAgICAgICBkYXRhLmZvckVhY2goZnVuY3Rpb24gKGl0ZW0sIGkpIHtcbiAgICAgICAgICAgIHRlbXAgKz0gXHRcdGA8bGkgZGF0YS10YWc9JyR7SlNPTi5zdHJpbmdpZnkoaXRlbSl9Jz5gXG4gICAgICAgICAgICB0ZW1wICs9IFx0XHRcdGA8c3Bhbj4ke190aGlzLm1ha2VJdChpdGVtLCBrZXl3b3JkKX08L3NwYW4+YFxuICAgICAgICAgICAgdGVtcCArPSBcdFx0YDwvbGk+YFxuICAgICAgICAgIH0pXG5cbiAgICAgICAgICB0ZW1wICs9IFx0YDwvdWw+YFxuXG4gICAgICAgICAgJGlucHV0LnBhcmVudCgpLmZpbmQoJy5SZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zJykuaHRtbCh0ZW1wKVxuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICRpbnB1dC5wYXJlbnQoKS5maW5kKCcuUmVhY3RUYWdzX19zdWdnZXN0aW9ucycpLmVtcHR5KClcbiAgICAgICAgfVxuICAgICAgfSxcbiAgICAgIGVycm9yOiBmdW5jdGlvbiAoeGhyLCBzdGF0dXMsIGVycikge31cbiAgICB9KVxuICB9XG5cbiAgcmVuZGVyICgpIHtcbiAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgdmFyIG1vZGUgPSB0aGlzLnBlcm1pc3Npb24ubW9kZVxuICAgIHZhciByYXRpbmcgPSB0aGlzLnBlcm1pc3Npb24ucmF0aW5nXG4gICAgdmFyIG1vZGVFbmFibGUgPSBmYWxzZVxuICAgIHZhciBwZXJtaXNzaW9uVHlwZXMgPSBbXG4gICAgICB7IHZhbHVlOiAnc3VwZXInLCBuYW1lOiBYRS5MYW5nLnRyYW5zKCd4ZTo6dXNlclJhdGluZ0FkbWluaXN0cmF0b3InKSB9LFxuICAgICAgeyB2YWx1ZTogJ21hbmFnZXInLCBuYW1lOiBYRS5MYW5nLnRyYW5zKCd4ZTo6dXNlclJhdGluZ01hbmFnZXInKSB9LFxuICAgICAgeyB2YWx1ZTogJ3VzZXInLCBuYW1lOiBYRS5MYW5nLnRyYW5zKCd4ZTo6dXNlcicpIH0sXG4gICAgICB7IHZhbHVlOiAnZ3Vlc3QnLCBuYW1lOiBYRS5MYW5nLnRyYW5zKCd4ZTo6Z3Vlc3QnKSB9XG4gICAgXVxuXG4gICAgdmFyIGRpc2FibGVkID0gZmFsc2VcblxuICAgIGlmIChtb2RlID09PSAnbWFudWFsJyB8fCBtb2RlID09PSAnaW5oZXJpdCcpIHtcbiAgICAgIG1vZGVFbmFibGUgPSB0cnVlXG4gICAgICBpZiAobW9kZSAhPT0gJ21hbnVhbCcpIHtcbiAgICAgICAgZGlzYWJsZWQgPSB0cnVlXG4gICAgICB9XG4gICAgfVxuXG4gICAgdmFyIGluY2x1ZGVHcm91cHMgPSB0aGlzLnBlcm1pc3Npb24uZ3JvdXAubWFwKGZ1bmN0aW9uIChncm91cCkge1xuICAgICAgcmV0dXJuIGdyb3VwLmlkXG4gICAgfSlcblxuICAgIHZhciBpbmNsdWRlVXNlcnMgPSB0aGlzLnBlcm1pc3Npb24udXNlci5tYXAoZnVuY3Rpb24gKHVzZXIpIHtcbiAgICAgIHJldHVybiB1c2VyLmlkXG4gICAgfSlcblxuICAgIHZhciBleGNsdWRlVXNlcnMgPSB0aGlzLnBlcm1pc3Npb24uZXhjZXB0Lm1hcChmdW5jdGlvbiAodXNlcikge1xuICAgICAgcmV0dXJuIHVzZXIuaWRcbiAgICB9KVxuXG4gICAgdmFyIHRlbXAgPSAnJ1xuICAgIHRlbXAgKz0gYDxkaXY+YFxuXG4gICAgaWYgKG1vZGVFbmFibGUpIHtcbiAgICAgIHZhciBjaGVja2VkID0gKG1vZGUgPT09ICdpbmhlcml0JykgPyAnY2hlY2tlZD1cImNoZWNrZWRcIicgOiAnJ1xuXG4gICAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiPmBcbiAgICAgIHRlbXAgKz0gXHRgPGRpdiBjbGFzcz1cImNoZWNrYm94XCI+YFxuICAgICAgdGVtcCArPVx0XHRcdGA8bGFiZWw+PGlucHV0IHR5cGU9XCJjaGVja2JveFwiIG5hbWU9XCIke3RoaXMudHlwZSArICdNb2RlJ31cIiBjbGFzcz1cImNoa01vZGVBYmxlXCIgdmFsdWU9XCJpbmhlcml0XCIgJHtjaGVja2VkfSAvPiAke1hFLkxhbmcudHJhbnMoJ3hlOjppbmhlcml0TW9kZScpfTwvbGFiZWw+YFxuICAgICAgdGVtcCArPSBcdGA8L2Rpdj5gXG4gICAgICB0ZW1wICs9IGA8L2Rpdj5gXG4gICAgfVxuXG4gICAgdGVtcCArPSBcdGA8ZGl2IGNsYXNzPVwiZm9ybS1ncm91cFwiPmBcbiAgICB0ZW1wICs9XHRcdFx0YDxsYWJlbD7tmozsm5Ag65Ox6riJPC9sYWJlbD5gXG4gICAgdGVtcCArPSBcdFx0JzxkaXYgY2xhc3M9XCJyYWRpb1wiPidcbiAgICBwZXJtaXNzaW9uVHlwZXMuZm9yRWFjaChmdW5jdGlvbiAocGVybWlzc2lvblR5cGUpIHtcbiAgICAgIHZhciBjaGVja2VkID0gKHBlcm1pc3Npb25UeXBlLnZhbHVlID09IHJhdGluZykgPyAnY2hlY2tlZCcgOiAnJ1xuXG4gICAgICB0ZW1wICs9IGA8bGFiZWw+PGlucHV0IHR5cGU9XCJyYWRpb1wiICR7KGRpc2FibGVkKSA/ICdkaXNhYmxlZD1cImRpc2FibGVkXCInIDogJyd9IG5hbWU9XCIke190aGlzLnR5cGUgKyAnUmF0aW5nJ31cIiB2YWx1ZT1cIiR7cGVybWlzc2lvblR5cGUudmFsdWV9XCIgJHsoY2hlY2tlZCkgPyAnY2hlY2tlZD1cImNoZWNrZWRcIicgOiAnJ30gLz4gJHtwZXJtaXNzaW9uVHlwZS5uYW1lfSAmbmJzcDs8L2xhYmVsPmBcbiAgICB9KVxuICAgIHRlbXAgKz1cdFx0XHRgPC9kaXY+YFxuICAgIHRlbXAgKz1cdFx0YDwvZGl2PmBcbiAgICB0ZW1wICs9IFx0YDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+YFxuICAgIHRlbXAgKz1cdFx0XHRgPGxhYmVsPiR7WEUuTGFuZy50cmFucygneGU6OmluY2x1ZGVVc2VyT3JHcm91cCcpfTwvbGFiZWw+YFxuICAgIHRlbXAgKz1cdFx0XHRgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnc1wiPmBcblxuICAgIHRlbXAgKz0gXHRcdFx0YDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3NlbGVjdGVkIGdyb3VwV3JhcFwiIGRhdGEtcHR5cGU9XCJncm91cFwiPmBcbiAgICB0aGlzLnBlcm1pc3Npb24uZ3JvdXAuZm9yRWFjaChmdW5jdGlvbiAoZykge1xuICAgICAgdmFyIHRhZyA9IGdcbiAgICAgIHZhciBsYWJlbCA9ICclJyArICh0YWcuZGlzcGxheV9uYW1lIHx8IHRhZy5uYW1lKVxuXG4gICAgICB0ZW1wICs9IFx0XHRcdGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtsYWJlbH08YSBocmVmPVwiI1wiIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfVwiPng8L2E+PC9zcGFuPmBcbiAgICB9KVxuICAgIHRlbXAgKz1cdFx0XHRcdCc8L2Rpdj4nXG5cbiAgICB0ZW1wICs9XHRcdFx0XHQnPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fc2VsZWN0ZWQgdXNlcldyYXBcIiBkYXRhLXB0eXBlPVwidXNlclwiPidcbiAgICB0aGlzLnBlcm1pc3Npb24udXNlci5mb3JFYWNoKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgIHZhciBsYWJlbCA9ICdAJyArICh0YWcuZGlzcGxheV9uYW1lIHx8IHRhZy5uYW1lKVxuXG4gICAgICB0ZW1wICs9IFx0XHRcdGA8c3BhbiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnXCI+JHtsYWJlbH08YSBocmVmPVwiI1wiIGNsYXNzPVwiUmVhY3RUYWdzX19yZW1vdmUgYnRuUmVtb3ZlVGFnXCIgZGF0YS1pZD1cIiR7dGFnLmlkfXxcIj54PC9hPjwvc3Bhbj5gXG4gICAgfSlcbiAgICB0ZW1wICs9XHRcdFx0XHRgPC9kaXY+YFxuXG4gICAgdGVtcCArPVx0XHRcdFx0YDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ0lucHV0XCI+YFxuICAgIHRlbXAgKz0gXHRcdFx0XHRgPGlucHV0IHR5cGU9XCJ0ZXh0XCIgcGxhY2Vob2xkZXI9XCIke3RoaXMucGxhY2Vob2xkZXJ9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgaW5wdXRVc2VyR3JvdXBcIiBkYXRhLWlucHV0PVwiaW5jbHVkZVwiICR7KGRpc2FibGVkKSA/ICdkaXNhYmxlZD1cImRpc2FibGVkXCInIDogJyd9IHZhbHVlPVwiJHt0aGlzLnF1ZXJ5fVwiIGRhdGEtaW5kZXg9XCItMVwiIC8+YFx0Ly8gVE9ETzo6IFBlcm1pc3Npb25JbmNsdWRlIGhhbmRsZUtleURvd25cbiAgICB0ZW1wICs9IFx0XHRcdFx0YDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3N1Z2dlc3Rpb25zXCIgZGF0YS1pbnB1dD1cImluY2x1ZGVcIj48L2Rpdj5gXG4gICAgdGVtcCArPVx0XHRcdFx0YDwvZGl2PmAgLy8gUmVhY3RUYWdzX190YWdJbnB1dFxuICAgIHRlbXAgKz0gXHRcdFx0YDxpbnB1dCB0eXBlPVwiaGlkZGVuXCIgbmFtZT1cIiR7dGhpcy50eXBlICsgJ0dyb3VwJ31cIiBjbGFzcz1cImZvcm0tY29udHJvbCBpbmNsdWRlR3JvdXBzXCIgdmFsdWU9XCIke2luY2x1ZGVHcm91cHMuam9pbigpLnRyaW0oKX1cIiAvPmBcbiAgICB0ZW1wICs9XHRcdFx0XHRgPGlucHV0IHR5cGU9XCJoaWRkZW5cIiBuYW1lPVwiJHt0aGlzLnR5cGUgKyAnVXNlcid9XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2wgaW5jbHVkZVVzZXJzXCIgdmFsdWU9XCIke2luY2x1ZGVVc2Vycy5qb2luKCkudHJpbSgpfVwiIC8+YFxuICAgIHRlbXAgKz1cdFx0XHRgPC9kaXY+YFx0Ly8gUmVhY3RUYWdzX190YWdzXG4gICAgdGVtcCArPVx0XHRgPC9kaXY+YC8vIGZvcm0tZ3JvdXBcblxuICAgIGlmICh0aGlzLnZncm91cEFsbC5sZW5ndGggPj0gMSkge1xuICAgICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXBcIj5gXG4gICAgICB0ZW1wICs9IFx0YDxsYWJlbD4ke1hFLkxhbmcudHJhbnMoJ3hlOjppbmNsdWRlVkdyb3VwJyl9PC9sYWJlbD5gXG5cbiAgICAgIHRlbXAgKz0gX3RoaXMudmdyb3VwQWxsLm1hcChmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICB2YXIgY2hlY2tlZCA9IGZhbHNlXG5cbiAgICAgICAgdmFyIGluQXJyYXkgPSBmdW5jdGlvbiAodmFsLCBhcnIpIHtcbiAgICAgICAgICBmb3IgKHZhciBpID0gMDsgaSA8IGFyci5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgaWYgKGFycltpXSA9PSB2YWwpIHtcbiAgICAgICAgICAgICAgcmV0dXJuIGlcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9XG5cbiAgICAgICAgICByZXR1cm4gLTFcbiAgICAgICAgfVxuXG4gICAgICAgIGlmIChpbkFycmF5KGRhdGEuaWQsIHRoaXMucGVybWlzc2lvbi52Z3JvdXApICE9IC0xKSB7XG4gICAgICAgICAgY2hlY2tlZCA9IHRydWVcbiAgICAgICAgfVxuXG4gICAgICAgIHJldHVybiBgPGxhYmVsPjxpbnB1dCB0eXBlPVwiY2hlY2tib3hcIiAkeyhkaXNhYmxlZCkgPyAnZGlzYWJsZWQ9XCJkaXNhYmxlZFwiJyA6ICcnfSBuYW1lPVwiJHtfdGhpcy50eXBlICsgJ1ZHcm91cFtdJ31cIiB2YWx1ZT1cIiR7ZGF0YS5pZH1cIiAkeyhjaGVja2VkKSA/ICdjaGVja2VkPVwiY2hlY2tlZFwiJyA6ICcnfSAvPiAke2RhdGEudGl0bGV9ICZuYnNwOzwvbGFiZWw+YFxuICAgICAgfSlcblxuICAgICAgdGVtcCArPSAnPC9kaXY+J1xuICAgIH1cblxuICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJmb3JtLWdyb3VwXCI+YFxuICAgIHRlbXAgKz0gXHRgPGxhYmVsPiR7WEUuTGFuZy50cmFucygneGU6OmV4Y2x1ZGVVc2VyJyl9PC9sYWJlbD5gXG4gICAgdGVtcCArPVx0XHRgPGRpdiBjbGFzcz1cIlJlYWN0VGFnc19fdGFnc1wiPmBcbiAgICB0ZW1wICs9XHRcdFx0YDxkaXYgY2xhc3M9XCJSZWFjdFRhZ3NfX3NlbGVjdGVkIGV4Y2VwdFdyYXBcIiBkYXRhLXB0eXBlPVwiZXhjZXB0XCI+YFxuXG4gICAgdGhpcy5wZXJtaXNzaW9uLmV4Y2VwdC5mb3JFYWNoKGZ1bmN0aW9uICh0YWcpIHtcbiAgICAgIHZhciBsYWJlbCA9IHRhZy5kaXNwbGF5X25hbWUgfHwgdGFnLm5hbWVcbiAgICAgIGxhYmVsID0gJ0AnICsgbGFiZWxcblxuICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJSZWFjdFRhZ3NfX3RhZ1wiPiR7bGFiZWx9PGEgaHJlZj1cIiNcIiBjbGFzcz1cIlJlYWN0VGFnc19fcmVtb3ZlIGJ0blJlbW92ZVRhZ1wiIGRhdGEtaWQ9XCIke3RhZy5pZH1cIj54PC9hPjwvc3Bhbj5gXG4gICAgfSlcblxuICAgIHRlbXAgKz1cdFx0XHRgPC9kaXY+YFxuICAgIHRlbXAgKz0gXHRcdGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX190YWdJbnB1dFwiPmBcbiAgICB0ZW1wICs9XHRcdFx0XHRgPGlucHV0IHR5cGU9XCJ0ZXh0XCIgcGxhY2Vob2xkZXI9XCIke1hFLkxhbmcudHJhbnMoJ3hlOjpleHBsYWluRXhjbHVkZVVzZXInKX1cIiBjbGFzcz1cImZvcm0tY29udHJvbCBpbnB1dFVzZXJHcm91cFwiIGRhdGEtaW5wdXQ9XCJleGNsdWRlXCIgJHsoZGlzYWJsZWQpID8gJ2Rpc2FibGVkPVwiZGlzYWJsZWRcIicgOiAnJ30gZGF0YS1pbmRleD1cIi0xXCIgLz5gIFx0Ly8gVE9ETzo6IFBlcm1pc3Npb25FeGNsdWRlIGhhbmRsZUtleURvd25cbiAgICB0ZW1wICs9IFx0XHRcdGA8ZGl2IGNsYXNzPVwiUmVhY3RUYWdzX19zdWdnZXN0aW9uc1wiIGRhdGEtaW5wdXQ9XCJleGNsdWRlXCI+PC9kaXY+YFxuICAgIHRlbXAgKz0gXHRcdGA8L2Rpdj5gIC8vIFJlYWN0VGFnc19fdGFnSW5wdXRcbiAgICB0ZW1wICs9XHRcdGA8aW5wdXQgdHlwZT1cImhpZGRlblwiIG5hbWU9XCIke3RoaXMudHlwZSArICdFeGNlcHQnfVwiIGNsYXNzPVwiZm9ybS1jb250cm9sIGV4Y2x1ZGVVc2Vyc1wiIHZhbHVlPVwiJHtleGNsdWRlVXNlcnN9XCIgLz5gXG4gICAgdGVtcCArPVx0XHRgPC9kaXY+YCAvLyBSZWFjdFRhZ3NfX3RhZ3NcbiAgICB0ZW1wICs9IGA8L2Rpdj5gLy8gZm9ybS1ncm91cFxuXG4gICAgdGVtcCArPSBgPC9kaXY+YFxuXG4gICAgdGhpcy4kd3JhcHBlci5odG1sKHRlbXApXG4gIH1cbn1cblxuJCgnLl9feGVfX3Vpb2JqZWN0X3Blcm1pc3Npb24nKS5lYWNoKGZ1bmN0aW9uIChpKSB7XG4gIHZhciAkdGhpcyA9ICQodGhpcylcbiAgdmFyIHBlcm1pc3Npb24gPSAkdGhpcy5kYXRhKCdkYXRhJylcblxuICB2YXIga2V5ID0gJHRoaXMuZGF0YSgna2V5JylcbiAgdmFyIHR5cGUgPSAkdGhpcy5kYXRhKCd0eXBlJylcbiAgdmFyIHVzZXJTZWFyY2hVcmwgPSAkdGhpcy5kYXRhKCd1c2VyVXJsJylcbiAgdmFyIGdyb3VwU2VhcmNoVXJsID0gJHRoaXMuZGF0YSgnZ3JvdXBVcmwnKVxuICB2YXIgdmdyb3VwQWxsID0gJHRoaXMuZGF0YSgndmdyb3VwQWxsJylcblxuICB2YXIgcCA9IG5ldyBQZXJtaXNzaW9uKHsgJHdyYXBwZXI6ICR0aGlzLCBrZXksIHVzZXJTZWFyY2hVcmwsIGdyb3VwU2VhcmNoVXJsLCBwZXJtaXNzaW9uLCB0eXBlLCB2Z3JvdXBBbGwgfSlcbiAgcC5yZW5kZXIoKVxuICBwLmJpbmRFdmVudHMoKVxufSlcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg5MCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjg0KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNTIpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg4OCk7IiwibW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKFwiY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeVwiKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDMpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg5KTsiLCJ2YXIgY29yZSA9IHJlcXVpcmUoJy4uLy4uL2ludGVybmFscy9wYXRoJyk7XG52YXIgJEpTT04gPSBjb3JlLkpTT04gfHwgKGNvcmUuSlNPTiA9IHsgc3RyaW5naWZ5OiBKU09OLnN0cmluZ2lmeSB9KTtcblxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiBzdHJpbmdpZnkoaXQpIHsgLy8gZXNsaW50LWRpc2FibGUtbGluZSBuby11bnVzZWQtdmFyc1xuICByZXR1cm4gJEpTT04uc3RyaW5naWZ5LmFwcGx5KCRKU09OLCBhcmd1bWVudHMpO1xufTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNSk7IiwibW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKCcuLi8uLi9lcy9qc29uL3N0cmluZ2lmeScpO1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDApOyIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==