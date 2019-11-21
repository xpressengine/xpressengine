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
/******/ 	return __webpack_require__(__webpack_require__.s = "./core/tree/Tree.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./core/tree/Item.js":
/*!***************************!*\
  !*** ./core/tree/Item.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/json/stringify */ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);




/** @private */
var _nodeTemplate;

var Item =
/*#__PURE__*/
function () {
  function Item() {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, Item);
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(Item, [{
    key: "getTemplate",

    /**
     * item 템플릿을 리턴한다.
     * @memberof Item
     * @param {object} obj
     **/
    value: function getTemplate(obj) {
      _nodeTemplate = obj.nodeTemplate;
      return this.getItemsTemplate(obj.items, obj.rootId, true);
    }
    /**
     * item 템플릿을 리턴한다.
     * @memberof Item
     * @param {object} items
     * @param {string} rootId
     * @param {boolean} isRoot
     * @return {string}
     **/

  }, {
    key: "getItemsTemplate",
    value: function getItemsTemplate(items, rootId, isRoot) {
      var temp = '';

      if (items && items.length != 0 || isRoot) {
        if (isRoot && rootId) {
          temp += '<ul class="item-container" data-parent="' + rootId + '">';
        } else {
          temp += '<ul class="item-container">';
        }
      }

      temp += this.makeItem(items, _nodeTemplate);

      if (items && items.length != 0 || isRoot) {
        temp += '</ul>';
      }

      return temp;
    }
    /**
       * item 템플릿을 만든다.
       * @memberof Item
       * @param {object} obj
       * <pre>
       *   items
       *   nodeTemplate
       * </pre>
       * @param {function} nodeTemplate
       * @return {string}
       **/

  }, {
    key: "makeItem",
    value: function makeItem(items, nodeTemplate) {
      var itemNode = '';

      for (var prop in items) {
        var item = items[prop];
        var move = item.items && item.items.length ? 'move' : '';
        itemNode += "<li class='item " + move + "' id='item_" + item.id + "'>";
        itemNode += "<div class='item-content' data-item='" + _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_0___default()(item) + "'>";
        itemNode += "<button class='btn handler'><i class='xi-drag-vertical'></i></button>";
        itemNode += nodeTemplate(item);
        itemNode += '</div>';

        if (item.items && item.items instanceof Object) {
          itemNode += this.getItemsTemplate(item.items);
        }

        itemNode += '</li>';
      }

      return itemNode;
    }
  }]);

  return Item;
}();

/* harmony default export */ __webpack_exports__["default"] = (new Item());

/***/ }),

/***/ "./core/tree/Tree.js":
/*!***************************!*\
  !*** ./core/tree/Tree.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var nestedSortable__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! nestedSortable */ "./node_modules/nestedSortable/jquery.mjs.nestedSortable.js");
/* harmony import */ var nestedSortable__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(nestedSortable__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _Item__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./Item */ "./core/tree/Item.js");







var _prevent = false;
var defaultOptions = {
  connectWith: '.item-container',
  forcePlaceholderSize: true,
  helper: 'clone',
  handle: '.item-content .handler',
  listType: 'ul',
  items: 'li',
  opacity: 0.6,
  isTree: true,
  cancel: '',
  tolerance: 'pointer',
  toleranceElement: '> div'
};

var Tree =
/*#__PURE__*/
function () {
  function Tree() {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, Tree);
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(Tree, [{
    key: "getItemsTemplate",

    /**
     *
     * @memberof Tree
     * @param {object} obj
     * <pre>
     *   rootId: tree root id
     *   nodeTemplate: item안에 생성할 html
     *   items: Tree 구성 데이터
     * </pre>
     * @return {string} items html
     **/
    value: function getItemsTemplate(obj) {
      return _Item__WEBPACK_IMPORTED_MODULE_6__["default"].getTemplate(obj);
    }
    /**
       * @memberof Tree
       * @param {boolean} flag
       * @description Tree 이동 방지
       * */

  }, {
    key: "setPrevent",
    value: function setPrevent(flag) {
      _prevent = flag;
    }
    /**
     * @memberof Tree
     * @param {object} $target tree구성의 wrapper
     * @param {object} config
     * <pre>
     *   추가옵션
     *   dragStart : drag 시작시 호출 treeOption의 start를 오버라이드 가능함.
     *   dragStop : drop시 호출 treeOption의 end를 오버라이드 가능함.
     *   update : drag를 통한 tree의 변동사항이 있을 경우 호출 item, parent, target, ordering등의 정보를 인자로 보내준다
     * </pre>
     * @param {object} treeOptions nestedSortable Tree Options
     * @description 트리 구성
     **/

  }, {
    key: "run",
    value: function run($target, config, treeOptions) {
      var parentId;
      var ordering;
      var itemId;
      var options = jquery__WEBPACK_IMPORTED_MODULE_4___default.a.extend({}, defaultOptions); // custom option 추가

      if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(treeOptions)) {
        jquery__WEBPACK_IMPORTED_MODULE_4___default.a.extend(options, treeOptions);
      } // start function 추가


      if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(treeOptions) && lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isFunction(treeOptions.start)) {
        options.start = treeOptions.start;
      } else {
        options.start = function (e, ui) {
          var $item = jquery__WEBPACK_IMPORTED_MODULE_4___default()(ui.item);

          var itemData = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()($item).call($item, '> .item-content').data('item');

          parentId = itemData.parentId;
          ordering = itemData.ordering;
          itemId = itemData.id;

          if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(config) && lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isFunction(config.dragStart)) {
            config.dragStart();
          }
        };
      } // stop function 추가


      if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(treeOptions) && lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isFunction(treeOptions.stop)) {
        options.stop = treeOptions.stop;
      } else {
        options.stop = function (e, ui) {
          var _context;

          var $item = jquery__WEBPACK_IMPORTED_MODULE_4___default()(ui.item);
          var $parentItem = $item.parents('li.item').eq(0);
          var moveParentId = $parentItem.length > 0 ? _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()($parentItem).call($parentItem, '> .item-content').data('item').id : $item.parents('.item-container').data('parent');

          var moveOrdering = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()(_context = $item.closest('ul').addClass('item-container')).call(_context, '> li.item').index($item);

          if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(config) && lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isFunction(config.dragStop)) {
            config.dragStop();
          }

          if (parentId !== moveParentId && !_prevent || ordering !== moveOrdering && !_prevent) {
            if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(config) && lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isFunction(config.update)) {
              config.update({
                item: $item,
                itemId: itemId,
                parentId: moveParentId,
                ordering: moveOrdering
              });
            }
          }
        };
      } // relocate function 추가 default 사용안함.


      if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(treeOptions) && lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isFunction(treeOptions.relocate)) {
        options.relocate = treeOptions.relocate;
      } // receive function 추가 default 사용안함.


      if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(treeOptions) && lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isFunction(treeOptions.receive)) {
        options.receive = treeOptions.receive;
      } // placeholder 추가


      if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(treeOptions) && treeOptions.placeholder) {
        options.placeholder = treeOptions.placeholder;
      } else {
        options.placeholder = {
          element: function element($target) {
            return $target.clone().addClass('copy').show().wrapAll('<div />').parent().html();
          },
          update: function update() {}
        };
      }

      if (lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isObject(treeOptions) && lodash__WEBPACK_IMPORTED_MODULE_5___default.a.isFunction(treeOptions.isAllowed)) {
        options.isAllowed = treeOptions.isAllowed;
      } else {
        options.isAllowed = function (placeholder, placeholderParent, currentItem) {
          return !_prevent;
        };
      }

      if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()($target).call($target, '.item-container').length > 0) {
        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()($target).call($target, '.item-container').nestedSortable(options);
      } else {
        $target.append('<ul class="item-container"></ul>');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()($target).call($target, '.item-container').nestedSortable(options);
      }
    }
    /**
     * @memberof Tree
     * @param {object} $container
     * @oaram {object} obj
     * <pre>
     *   nodeTemplate: item안에 생성할 html
     *   item
     *   nested - 하위 depth 노드일 경우 ul.item-container를 포함하여 append. 아닐 경우 li.item만 append
     * </pre>
     * @param {function} fn callback
     **/

  }, {
    key: "add",
    value: function add($container, obj, fn) {
      if (obj.nested) {
        $container.append(_Item__WEBPACK_IMPORTED_MODULE_6__["default"].getTemplate(obj));
      } else {
        $container.append(_Item__WEBPACK_IMPORTED_MODULE_6__["default"].makeItem(obj.items, obj.nodeTemplate));
      }

      if (fn && typeof fn === 'function') {
        fn();
      }
    }
  }]);

  return Tree;
}();

window.Tree = new Tree();
/* harmony default export */ __webpack_exports__["default"] = (window.Tree);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(4);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(3);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js":
/*!****************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/helpers/createClass.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(10);

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

/***/ "./node_modules/jquery-ui/ui/data.js":
/*!*******************************************!*\
  !*** ./node_modules/jquery-ui/ui/data.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI :data 1.12.1
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */

//>>label: :data Selector
//>>group: Core
//>>description: Selects elements which have data stored under the specified key.
//>>docs: http://api.jqueryui.com/data-selector/

( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} ( function( $ ) {
return $.extend( $.expr[ ":" ], {
	data: $.expr.createPseudo ?
		$.expr.createPseudo( function( dataName ) {
			return function( elem ) {
				return !!$.data( elem, dataName );
			};
		} ) :

		// Support: jQuery <1.8
		function( elem, i, match ) {
			return !!$.data( elem, match[ 3 ] );
		}
} );
} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/ie.js":
/*!*****************************************!*\
  !*** ./node_modules/jquery-ui/ui/ie.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} ( function( $ ) {

// This file is deprecated
return $.ui.ie = !!/msie [\w.]+/.exec( navigator.userAgent.toLowerCase() );
} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/scroll-parent.js":
/*!****************************************************!*\
  !*** ./node_modules/jquery-ui/ui/scroll-parent.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Scroll Parent 1.12.1
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */

//>>label: scrollParent
//>>group: Core
//>>description: Get the closest ancestor element that is scrollable.
//>>docs: http://api.jqueryui.com/scrollParent/

( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} ( function( $ ) {

return $.fn.scrollParent = function( includeHidden ) {
	var position = this.css( "position" ),
		excludeStaticParent = position === "absolute",
		overflowRegex = includeHidden ? /(auto|scroll|hidden)/ : /(auto|scroll)/,
		scrollParent = this.parents().filter( function() {
			var parent = $( this );
			if ( excludeStaticParent && parent.css( "position" ) === "static" ) {
				return false;
			}
			return overflowRegex.test( parent.css( "overflow" ) + parent.css( "overflow-y" ) +
				parent.css( "overflow-x" ) );
		} ).eq( 0 );

	return position === "fixed" || !scrollParent.length ?
		$( this[ 0 ].ownerDocument || document ) :
		scrollParent;
};

} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/version.js":
/*!**********************************************!*\
  !*** ./node_modules/jquery-ui/ui/version.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} ( function( $ ) {

$.ui = $.ui || {};

return $.ui.version = "1.12.1";

} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/widget.js":
/*!*********************************************!*\
  !*** ./node_modules/jquery-ui/ui/widget.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Widget 1.12.1
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */

//>>label: Widget
//>>group: Core
//>>description: Provides a factory for creating stateful widgets with a common API.
//>>docs: http://api.jqueryui.com/jQuery.widget/
//>>demos: http://jqueryui.com/widget/

( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}( function( $ ) {

var widgetUuid = 0;
var widgetSlice = Array.prototype.slice;

$.cleanData = ( function( orig ) {
	return function( elems ) {
		var events, elem, i;
		for ( i = 0; ( elem = elems[ i ] ) != null; i++ ) {
			try {

				// Only trigger remove when necessary to save time
				events = $._data( elem, "events" );
				if ( events && events.remove ) {
					$( elem ).triggerHandler( "remove" );
				}

			// Http://bugs.jquery.com/ticket/8235
			} catch ( e ) {}
		}
		orig( elems );
	};
} )( $.cleanData );

$.widget = function( name, base, prototype ) {
	var existingConstructor, constructor, basePrototype;

	// ProxiedPrototype allows the provided prototype to remain unmodified
	// so that it can be used as a mixin for multiple widgets (#8876)
	var proxiedPrototype = {};

	var namespace = name.split( "." )[ 0 ];
	name = name.split( "." )[ 1 ];
	var fullName = namespace + "-" + name;

	if ( !prototype ) {
		prototype = base;
		base = $.Widget;
	}

	if ( $.isArray( prototype ) ) {
		prototype = $.extend.apply( null, [ {} ].concat( prototype ) );
	}

	// Create selector for plugin
	$.expr[ ":" ][ fullName.toLowerCase() ] = function( elem ) {
		return !!$.data( elem, fullName );
	};

	$[ namespace ] = $[ namespace ] || {};
	existingConstructor = $[ namespace ][ name ];
	constructor = $[ namespace ][ name ] = function( options, element ) {

		// Allow instantiation without "new" keyword
		if ( !this._createWidget ) {
			return new constructor( options, element );
		}

		// Allow instantiation without initializing for simple inheritance
		// must use "new" keyword (the code above always passes args)
		if ( arguments.length ) {
			this._createWidget( options, element );
		}
	};

	// Extend with the existing constructor to carry over any static properties
	$.extend( constructor, existingConstructor, {
		version: prototype.version,

		// Copy the object used to create the prototype in case we need to
		// redefine the widget later
		_proto: $.extend( {}, prototype ),

		// Track widgets that inherit from this widget in case this widget is
		// redefined after a widget inherits from it
		_childConstructors: []
	} );

	basePrototype = new base();

	// We need to make the options hash a property directly on the new instance
	// otherwise we'll modify the options hash on the prototype that we're
	// inheriting from
	basePrototype.options = $.widget.extend( {}, basePrototype.options );
	$.each( prototype, function( prop, value ) {
		if ( !$.isFunction( value ) ) {
			proxiedPrototype[ prop ] = value;
			return;
		}
		proxiedPrototype[ prop ] = ( function() {
			function _super() {
				return base.prototype[ prop ].apply( this, arguments );
			}

			function _superApply( args ) {
				return base.prototype[ prop ].apply( this, args );
			}

			return function() {
				var __super = this._super;
				var __superApply = this._superApply;
				var returnValue;

				this._super = _super;
				this._superApply = _superApply;

				returnValue = value.apply( this, arguments );

				this._super = __super;
				this._superApply = __superApply;

				return returnValue;
			};
		} )();
	} );
	constructor.prototype = $.widget.extend( basePrototype, {

		// TODO: remove support for widgetEventPrefix
		// always use the name + a colon as the prefix, e.g., draggable:start
		// don't prefix for widgets that aren't DOM-based
		widgetEventPrefix: existingConstructor ? ( basePrototype.widgetEventPrefix || name ) : name
	}, proxiedPrototype, {
		constructor: constructor,
		namespace: namespace,
		widgetName: name,
		widgetFullName: fullName
	} );

	// If this widget is being redefined then we need to find all widgets that
	// are inheriting from it and redefine all of them so that they inherit from
	// the new version of this widget. We're essentially trying to replace one
	// level in the prototype chain.
	if ( existingConstructor ) {
		$.each( existingConstructor._childConstructors, function( i, child ) {
			var childPrototype = child.prototype;

			// Redefine the child widget using the same prototype that was
			// originally used, but inherit from the new version of the base
			$.widget( childPrototype.namespace + "." + childPrototype.widgetName, constructor,
				child._proto );
		} );

		// Remove the list of existing child constructors from the old constructor
		// so the old child constructors can be garbage collected
		delete existingConstructor._childConstructors;
	} else {
		base._childConstructors.push( constructor );
	}

	$.widget.bridge( name, constructor );

	return constructor;
};

$.widget.extend = function( target ) {
	var input = widgetSlice.call( arguments, 1 );
	var inputIndex = 0;
	var inputLength = input.length;
	var key;
	var value;

	for ( ; inputIndex < inputLength; inputIndex++ ) {
		for ( key in input[ inputIndex ] ) {
			value = input[ inputIndex ][ key ];
			if ( input[ inputIndex ].hasOwnProperty( key ) && value !== undefined ) {

				// Clone objects
				if ( $.isPlainObject( value ) ) {
					target[ key ] = $.isPlainObject( target[ key ] ) ?
						$.widget.extend( {}, target[ key ], value ) :

						// Don't extend strings, arrays, etc. with objects
						$.widget.extend( {}, value );

				// Copy everything else by reference
				} else {
					target[ key ] = value;
				}
			}
		}
	}
	return target;
};

$.widget.bridge = function( name, object ) {
	var fullName = object.prototype.widgetFullName || name;
	$.fn[ name ] = function( options ) {
		var isMethodCall = typeof options === "string";
		var args = widgetSlice.call( arguments, 1 );
		var returnValue = this;

		if ( isMethodCall ) {

			// If this is an empty collection, we need to have the instance method
			// return undefined instead of the jQuery instance
			if ( !this.length && options === "instance" ) {
				returnValue = undefined;
			} else {
				this.each( function() {
					var methodValue;
					var instance = $.data( this, fullName );

					if ( options === "instance" ) {
						returnValue = instance;
						return false;
					}

					if ( !instance ) {
						return $.error( "cannot call methods on " + name +
							" prior to initialization; " +
							"attempted to call method '" + options + "'" );
					}

					if ( !$.isFunction( instance[ options ] ) || options.charAt( 0 ) === "_" ) {
						return $.error( "no such method '" + options + "' for " + name +
							" widget instance" );
					}

					methodValue = instance[ options ].apply( instance, args );

					if ( methodValue !== instance && methodValue !== undefined ) {
						returnValue = methodValue && methodValue.jquery ?
							returnValue.pushStack( methodValue.get() ) :
							methodValue;
						return false;
					}
				} );
			}
		} else {

			// Allow multiple hashes to be passed on init
			if ( args.length ) {
				options = $.widget.extend.apply( null, [ options ].concat( args ) );
			}

			this.each( function() {
				var instance = $.data( this, fullName );
				if ( instance ) {
					instance.option( options || {} );
					if ( instance._init ) {
						instance._init();
					}
				} else {
					$.data( this, fullName, new object( options, this ) );
				}
			} );
		}

		return returnValue;
	};
};

$.Widget = function( /* options, element */ ) {};
$.Widget._childConstructors = [];

$.Widget.prototype = {
	widgetName: "widget",
	widgetEventPrefix: "",
	defaultElement: "<div>",

	options: {
		classes: {},
		disabled: false,

		// Callbacks
		create: null
	},

	_createWidget: function( options, element ) {
		element = $( element || this.defaultElement || this )[ 0 ];
		this.element = $( element );
		this.uuid = widgetUuid++;
		this.eventNamespace = "." + this.widgetName + this.uuid;

		this.bindings = $();
		this.hoverable = $();
		this.focusable = $();
		this.classesElementLookup = {};

		if ( element !== this ) {
			$.data( element, this.widgetFullName, this );
			this._on( true, this.element, {
				remove: function( event ) {
					if ( event.target === element ) {
						this.destroy();
					}
				}
			} );
			this.document = $( element.style ?

				// Element within the document
				element.ownerDocument :

				// Element is window or document
				element.document || element );
			this.window = $( this.document[ 0 ].defaultView || this.document[ 0 ].parentWindow );
		}

		this.options = $.widget.extend( {},
			this.options,
			this._getCreateOptions(),
			options );

		this._create();

		if ( this.options.disabled ) {
			this._setOptionDisabled( this.options.disabled );
		}

		this._trigger( "create", null, this._getCreateEventData() );
		this._init();
	},

	_getCreateOptions: function() {
		return {};
	},

	_getCreateEventData: $.noop,

	_create: $.noop,

	_init: $.noop,

	destroy: function() {
		var that = this;

		this._destroy();
		$.each( this.classesElementLookup, function( key, value ) {
			that._removeClass( value, key );
		} );

		// We can probably remove the unbind calls in 2.0
		// all event bindings should go through this._on()
		this.element
			.off( this.eventNamespace )
			.removeData( this.widgetFullName );
		this.widget()
			.off( this.eventNamespace )
			.removeAttr( "aria-disabled" );

		// Clean up events and states
		this.bindings.off( this.eventNamespace );
	},

	_destroy: $.noop,

	widget: function() {
		return this.element;
	},

	option: function( key, value ) {
		var options = key;
		var parts;
		var curOption;
		var i;

		if ( arguments.length === 0 ) {

			// Don't return a reference to the internal hash
			return $.widget.extend( {}, this.options );
		}

		if ( typeof key === "string" ) {

			// Handle nested keys, e.g., "foo.bar" => { foo: { bar: ___ } }
			options = {};
			parts = key.split( "." );
			key = parts.shift();
			if ( parts.length ) {
				curOption = options[ key ] = $.widget.extend( {}, this.options[ key ] );
				for ( i = 0; i < parts.length - 1; i++ ) {
					curOption[ parts[ i ] ] = curOption[ parts[ i ] ] || {};
					curOption = curOption[ parts[ i ] ];
				}
				key = parts.pop();
				if ( arguments.length === 1 ) {
					return curOption[ key ] === undefined ? null : curOption[ key ];
				}
				curOption[ key ] = value;
			} else {
				if ( arguments.length === 1 ) {
					return this.options[ key ] === undefined ? null : this.options[ key ];
				}
				options[ key ] = value;
			}
		}

		this._setOptions( options );

		return this;
	},

	_setOptions: function( options ) {
		var key;

		for ( key in options ) {
			this._setOption( key, options[ key ] );
		}

		return this;
	},

	_setOption: function( key, value ) {
		if ( key === "classes" ) {
			this._setOptionClasses( value );
		}

		this.options[ key ] = value;

		if ( key === "disabled" ) {
			this._setOptionDisabled( value );
		}

		return this;
	},

	_setOptionClasses: function( value ) {
		var classKey, elements, currentElements;

		for ( classKey in value ) {
			currentElements = this.classesElementLookup[ classKey ];
			if ( value[ classKey ] === this.options.classes[ classKey ] ||
					!currentElements ||
					!currentElements.length ) {
				continue;
			}

			// We are doing this to create a new jQuery object because the _removeClass() call
			// on the next line is going to destroy the reference to the current elements being
			// tracked. We need to save a copy of this collection so that we can add the new classes
			// below.
			elements = $( currentElements.get() );
			this._removeClass( currentElements, classKey );

			// We don't use _addClass() here, because that uses this.options.classes
			// for generating the string of classes. We want to use the value passed in from
			// _setOption(), this is the new value of the classes option which was passed to
			// _setOption(). We pass this value directly to _classes().
			elements.addClass( this._classes( {
				element: elements,
				keys: classKey,
				classes: value,
				add: true
			} ) );
		}
	},

	_setOptionDisabled: function( value ) {
		this._toggleClass( this.widget(), this.widgetFullName + "-disabled", null, !!value );

		// If the widget is becoming disabled, then nothing is interactive
		if ( value ) {
			this._removeClass( this.hoverable, null, "ui-state-hover" );
			this._removeClass( this.focusable, null, "ui-state-focus" );
		}
	},

	enable: function() {
		return this._setOptions( { disabled: false } );
	},

	disable: function() {
		return this._setOptions( { disabled: true } );
	},

	_classes: function( options ) {
		var full = [];
		var that = this;

		options = $.extend( {
			element: this.element,
			classes: this.options.classes || {}
		}, options );

		function processClassString( classes, checkOption ) {
			var current, i;
			for ( i = 0; i < classes.length; i++ ) {
				current = that.classesElementLookup[ classes[ i ] ] || $();
				if ( options.add ) {
					current = $( $.unique( current.get().concat( options.element.get() ) ) );
				} else {
					current = $( current.not( options.element ).get() );
				}
				that.classesElementLookup[ classes[ i ] ] = current;
				full.push( classes[ i ] );
				if ( checkOption && options.classes[ classes[ i ] ] ) {
					full.push( options.classes[ classes[ i ] ] );
				}
			}
		}

		this._on( options.element, {
			"remove": "_untrackClassesElement"
		} );

		if ( options.keys ) {
			processClassString( options.keys.match( /\S+/g ) || [], true );
		}
		if ( options.extra ) {
			processClassString( options.extra.match( /\S+/g ) || [] );
		}

		return full.join( " " );
	},

	_untrackClassesElement: function( event ) {
		var that = this;
		$.each( that.classesElementLookup, function( key, value ) {
			if ( $.inArray( event.target, value ) !== -1 ) {
				that.classesElementLookup[ key ] = $( value.not( event.target ).get() );
			}
		} );
	},

	_removeClass: function( element, keys, extra ) {
		return this._toggleClass( element, keys, extra, false );
	},

	_addClass: function( element, keys, extra ) {
		return this._toggleClass( element, keys, extra, true );
	},

	_toggleClass: function( element, keys, extra, add ) {
		add = ( typeof add === "boolean" ) ? add : extra;
		var shift = ( typeof element === "string" || element === null ),
			options = {
				extra: shift ? keys : extra,
				keys: shift ? element : keys,
				element: shift ? this.element : element,
				add: add
			};
		options.element.toggleClass( this._classes( options ), add );
		return this;
	},

	_on: function( suppressDisabledCheck, element, handlers ) {
		var delegateElement;
		var instance = this;

		// No suppressDisabledCheck flag, shuffle arguments
		if ( typeof suppressDisabledCheck !== "boolean" ) {
			handlers = element;
			element = suppressDisabledCheck;
			suppressDisabledCheck = false;
		}

		// No element argument, shuffle and use this.element
		if ( !handlers ) {
			handlers = element;
			element = this.element;
			delegateElement = this.widget();
		} else {
			element = delegateElement = $( element );
			this.bindings = this.bindings.add( element );
		}

		$.each( handlers, function( event, handler ) {
			function handlerProxy() {

				// Allow widgets to customize the disabled handling
				// - disabled as an array instead of boolean
				// - disabled class as method for disabling individual parts
				if ( !suppressDisabledCheck &&
						( instance.options.disabled === true ||
						$( this ).hasClass( "ui-state-disabled" ) ) ) {
					return;
				}
				return ( typeof handler === "string" ? instance[ handler ] : handler )
					.apply( instance, arguments );
			}

			// Copy the guid so direct unbinding works
			if ( typeof handler !== "string" ) {
				handlerProxy.guid = handler.guid =
					handler.guid || handlerProxy.guid || $.guid++;
			}

			var match = event.match( /^([\w:-]*)\s*(.*)$/ );
			var eventName = match[ 1 ] + instance.eventNamespace;
			var selector = match[ 2 ];

			if ( selector ) {
				delegateElement.on( eventName, selector, handlerProxy );
			} else {
				element.on( eventName, handlerProxy );
			}
		} );
	},

	_off: function( element, eventName ) {
		eventName = ( eventName || "" ).split( " " ).join( this.eventNamespace + " " ) +
			this.eventNamespace;
		element.off( eventName ).off( eventName );

		// Clear the stack to avoid memory leaks (#10056)
		this.bindings = $( this.bindings.not( element ).get() );
		this.focusable = $( this.focusable.not( element ).get() );
		this.hoverable = $( this.hoverable.not( element ).get() );
	},

	_delay: function( handler, delay ) {
		function handlerProxy() {
			return ( typeof handler === "string" ? instance[ handler ] : handler )
				.apply( instance, arguments );
		}
		var instance = this;
		return setTimeout( handlerProxy, delay || 0 );
	},

	_hoverable: function( element ) {
		this.hoverable = this.hoverable.add( element );
		this._on( element, {
			mouseenter: function( event ) {
				this._addClass( $( event.currentTarget ), null, "ui-state-hover" );
			},
			mouseleave: function( event ) {
				this._removeClass( $( event.currentTarget ), null, "ui-state-hover" );
			}
		} );
	},

	_focusable: function( element ) {
		this.focusable = this.focusable.add( element );
		this._on( element, {
			focusin: function( event ) {
				this._addClass( $( event.currentTarget ), null, "ui-state-focus" );
			},
			focusout: function( event ) {
				this._removeClass( $( event.currentTarget ), null, "ui-state-focus" );
			}
		} );
	},

	_trigger: function( type, event, data ) {
		var prop, orig;
		var callback = this.options[ type ];

		data = data || {};
		event = $.Event( event );
		event.type = ( type === this.widgetEventPrefix ?
			type :
			this.widgetEventPrefix + type ).toLowerCase();

		// The original event may come from any element
		// so we need to reset the target on the new event
		event.target = this.element[ 0 ];

		// Copy original event properties over to the new event
		orig = event.originalEvent;
		if ( orig ) {
			for ( prop in orig ) {
				if ( !( prop in event ) ) {
					event[ prop ] = orig[ prop ];
				}
			}
		}

		this.element.trigger( event, data );
		return !( $.isFunction( callback ) &&
			callback.apply( this.element[ 0 ], [ event ].concat( data ) ) === false ||
			event.isDefaultPrevented() );
	}
};

$.each( { show: "fadeIn", hide: "fadeOut" }, function( method, defaultEffect ) {
	$.Widget.prototype[ "_" + method ] = function( element, options, callback ) {
		if ( typeof options === "string" ) {
			options = { effect: options };
		}

		var hasOptions;
		var effectName = !options ?
			method :
			options === true || typeof options === "number" ?
				defaultEffect :
				options.effect || defaultEffect;

		options = options || {};
		if ( typeof options === "number" ) {
			options = { duration: options };
		}

		hasOptions = !$.isEmptyObject( options );
		options.complete = callback;

		if ( options.delay ) {
			element.delay( options.delay );
		}

		if ( hasOptions && $.effects && $.effects.effect[ effectName ] ) {
			element[ method ]( options );
		} else if ( effectName !== method && element[ effectName ] ) {
			element[ effectName ]( options.duration, options.easing, callback );
		} else {
			element.queue( function( next ) {
				$( this )[ method ]();
				if ( callback ) {
					callback.call( element[ 0 ] );
				}
				next();
			} );
		}
	};
} );

return $.widget;

} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/widgets/mouse.js":
/*!****************************************************!*\
  !*** ./node_modules/jquery-ui/ui/widgets/mouse.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Mouse 1.12.1
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */

//>>label: Mouse
//>>group: Widgets
//>>description: Abstracts mouse-based interactions to assist in creating certain widgets.
//>>docs: http://api.jqueryui.com/mouse/

( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [
			__webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"),
			__webpack_require__(/*! ../ie */ "./node_modules/jquery-ui/ui/ie.js"),
			__webpack_require__(/*! ../version */ "./node_modules/jquery-ui/ui/version.js"),
			__webpack_require__(/*! ../widget */ "./node_modules/jquery-ui/ui/widget.js")
		], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}( function( $ ) {

var mouseHandled = false;
$( document ).on( "mouseup", function() {
	mouseHandled = false;
} );

return $.widget( "ui.mouse", {
	version: "1.12.1",
	options: {
		cancel: "input, textarea, button, select, option",
		distance: 1,
		delay: 0
	},
	_mouseInit: function() {
		var that = this;

		this.element
			.on( "mousedown." + this.widgetName, function( event ) {
				return that._mouseDown( event );
			} )
			.on( "click." + this.widgetName, function( event ) {
				if ( true === $.data( event.target, that.widgetName + ".preventClickEvent" ) ) {
					$.removeData( event.target, that.widgetName + ".preventClickEvent" );
					event.stopImmediatePropagation();
					return false;
				}
			} );

		this.started = false;
	},

	// TODO: make sure destroying one instance of mouse doesn't mess with
	// other instances of mouse
	_mouseDestroy: function() {
		this.element.off( "." + this.widgetName );
		if ( this._mouseMoveDelegate ) {
			this.document
				.off( "mousemove." + this.widgetName, this._mouseMoveDelegate )
				.off( "mouseup." + this.widgetName, this._mouseUpDelegate );
		}
	},

	_mouseDown: function( event ) {

		// don't let more than one widget handle mouseStart
		if ( mouseHandled ) {
			return;
		}

		this._mouseMoved = false;

		// We may have missed mouseup (out of window)
		( this._mouseStarted && this._mouseUp( event ) );

		this._mouseDownEvent = event;

		var that = this,
			btnIsLeft = ( event.which === 1 ),

			// event.target.nodeName works around a bug in IE 8 with
			// disabled inputs (#7620)
			elIsCancel = ( typeof this.options.cancel === "string" && event.target.nodeName ?
				$( event.target ).closest( this.options.cancel ).length : false );
		if ( !btnIsLeft || elIsCancel || !this._mouseCapture( event ) ) {
			return true;
		}

		this.mouseDelayMet = !this.options.delay;
		if ( !this.mouseDelayMet ) {
			this._mouseDelayTimer = setTimeout( function() {
				that.mouseDelayMet = true;
			}, this.options.delay );
		}

		if ( this._mouseDistanceMet( event ) && this._mouseDelayMet( event ) ) {
			this._mouseStarted = ( this._mouseStart( event ) !== false );
			if ( !this._mouseStarted ) {
				event.preventDefault();
				return true;
			}
		}

		// Click event may never have fired (Gecko & Opera)
		if ( true === $.data( event.target, this.widgetName + ".preventClickEvent" ) ) {
			$.removeData( event.target, this.widgetName + ".preventClickEvent" );
		}

		// These delegates are required to keep context
		this._mouseMoveDelegate = function( event ) {
			return that._mouseMove( event );
		};
		this._mouseUpDelegate = function( event ) {
			return that._mouseUp( event );
		};

		this.document
			.on( "mousemove." + this.widgetName, this._mouseMoveDelegate )
			.on( "mouseup." + this.widgetName, this._mouseUpDelegate );

		event.preventDefault();

		mouseHandled = true;
		return true;
	},

	_mouseMove: function( event ) {

		// Only check for mouseups outside the document if you've moved inside the document
		// at least once. This prevents the firing of mouseup in the case of IE<9, which will
		// fire a mousemove event if content is placed under the cursor. See #7778
		// Support: IE <9
		if ( this._mouseMoved ) {

			// IE mouseup check - mouseup happened when mouse was out of window
			if ( $.ui.ie && ( !document.documentMode || document.documentMode < 9 ) &&
					!event.button ) {
				return this._mouseUp( event );

			// Iframe mouseup check - mouseup occurred in another document
			} else if ( !event.which ) {

				// Support: Safari <=8 - 9
				// Safari sets which to 0 if you press any of the following keys
				// during a drag (#14461)
				if ( event.originalEvent.altKey || event.originalEvent.ctrlKey ||
						event.originalEvent.metaKey || event.originalEvent.shiftKey ) {
					this.ignoreMissingWhich = true;
				} else if ( !this.ignoreMissingWhich ) {
					return this._mouseUp( event );
				}
			}
		}

		if ( event.which || event.button ) {
			this._mouseMoved = true;
		}

		if ( this._mouseStarted ) {
			this._mouseDrag( event );
			return event.preventDefault();
		}

		if ( this._mouseDistanceMet( event ) && this._mouseDelayMet( event ) ) {
			this._mouseStarted =
				( this._mouseStart( this._mouseDownEvent, event ) !== false );
			( this._mouseStarted ? this._mouseDrag( event ) : this._mouseUp( event ) );
		}

		return !this._mouseStarted;
	},

	_mouseUp: function( event ) {
		this.document
			.off( "mousemove." + this.widgetName, this._mouseMoveDelegate )
			.off( "mouseup." + this.widgetName, this._mouseUpDelegate );

		if ( this._mouseStarted ) {
			this._mouseStarted = false;

			if ( event.target === this._mouseDownEvent.target ) {
				$.data( event.target, this.widgetName + ".preventClickEvent", true );
			}

			this._mouseStop( event );
		}

		if ( this._mouseDelayTimer ) {
			clearTimeout( this._mouseDelayTimer );
			delete this._mouseDelayTimer;
		}

		this.ignoreMissingWhich = false;
		mouseHandled = false;
		event.preventDefault();
	},

	_mouseDistanceMet: function( event ) {
		return ( Math.max(
				Math.abs( this._mouseDownEvent.pageX - event.pageX ),
				Math.abs( this._mouseDownEvent.pageY - event.pageY )
			) >= this.options.distance
		);
	},

	_mouseDelayMet: function( /* event */ ) {
		return this.mouseDelayMet;
	},

	// These are placeholder methods, to be overriden by extending plugin
	_mouseStart: function( /* event */ ) {},
	_mouseDrag: function( /* event */ ) {},
	_mouseStop: function( /* event */ ) {},
	_mouseCapture: function( /* event */ ) { return true; }
} );

} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/widgets/sortable.js":
/*!*******************************************************!*\
  !*** ./node_modules/jquery-ui/ui/widgets/sortable.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Sortable 1.12.1
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */

//>>label: Sortable
//>>group: Interactions
//>>description: Enables items in a list to be sorted using the mouse.
//>>docs: http://api.jqueryui.com/sortable/
//>>demos: http://jqueryui.com/sortable/
//>>css.structure: ../../themes/base/sortable.css

( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [
			__webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"),
			__webpack_require__(/*! ./mouse */ "./node_modules/jquery-ui/ui/widgets/mouse.js"),
			__webpack_require__(/*! ../data */ "./node_modules/jquery-ui/ui/data.js"),
			__webpack_require__(/*! ../ie */ "./node_modules/jquery-ui/ui/ie.js"),
			__webpack_require__(/*! ../scroll-parent */ "./node_modules/jquery-ui/ui/scroll-parent.js"),
			__webpack_require__(/*! ../version */ "./node_modules/jquery-ui/ui/version.js"),
			__webpack_require__(/*! ../widget */ "./node_modules/jquery-ui/ui/widget.js")
		], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}( function( $ ) {

return $.widget( "ui.sortable", $.ui.mouse, {
	version: "1.12.1",
	widgetEventPrefix: "sort",
	ready: false,
	options: {
		appendTo: "parent",
		axis: false,
		connectWith: false,
		containment: false,
		cursor: "auto",
		cursorAt: false,
		dropOnEmpty: true,
		forcePlaceholderSize: false,
		forceHelperSize: false,
		grid: false,
		handle: false,
		helper: "original",
		items: "> *",
		opacity: false,
		placeholder: false,
		revert: false,
		scroll: true,
		scrollSensitivity: 20,
		scrollSpeed: 20,
		scope: "default",
		tolerance: "intersect",
		zIndex: 1000,

		// Callbacks
		activate: null,
		beforeStop: null,
		change: null,
		deactivate: null,
		out: null,
		over: null,
		receive: null,
		remove: null,
		sort: null,
		start: null,
		stop: null,
		update: null
	},

	_isOverAxis: function( x, reference, size ) {
		return ( x >= reference ) && ( x < ( reference + size ) );
	},

	_isFloating: function( item ) {
		return ( /left|right/ ).test( item.css( "float" ) ) ||
			( /inline|table-cell/ ).test( item.css( "display" ) );
	},

	_create: function() {
		this.containerCache = {};
		this._addClass( "ui-sortable" );

		//Get the items
		this.refresh();

		//Let's determine the parent's offset
		this.offset = this.element.offset();

		//Initialize mouse events for interaction
		this._mouseInit();

		this._setHandleClassName();

		//We're ready to go
		this.ready = true;

	},

	_setOption: function( key, value ) {
		this._super( key, value );

		if ( key === "handle" ) {
			this._setHandleClassName();
		}
	},

	_setHandleClassName: function() {
		var that = this;
		this._removeClass( this.element.find( ".ui-sortable-handle" ), "ui-sortable-handle" );
		$.each( this.items, function() {
			that._addClass(
				this.instance.options.handle ?
					this.item.find( this.instance.options.handle ) :
					this.item,
				"ui-sortable-handle"
			);
		} );
	},

	_destroy: function() {
		this._mouseDestroy();

		for ( var i = this.items.length - 1; i >= 0; i-- ) {
			this.items[ i ].item.removeData( this.widgetName + "-item" );
		}

		return this;
	},

	_mouseCapture: function( event, overrideHandle ) {
		var currentItem = null,
			validHandle = false,
			that = this;

		if ( this.reverting ) {
			return false;
		}

		if ( this.options.disabled || this.options.type === "static" ) {
			return false;
		}

		//We have to refresh the items data once first
		this._refreshItems( event );

		//Find out if the clicked node (or one of its parents) is a actual item in this.items
		$( event.target ).parents().each( function() {
			if ( $.data( this, that.widgetName + "-item" ) === that ) {
				currentItem = $( this );
				return false;
			}
		} );
		if ( $.data( event.target, that.widgetName + "-item" ) === that ) {
			currentItem = $( event.target );
		}

		if ( !currentItem ) {
			return false;
		}
		if ( this.options.handle && !overrideHandle ) {
			$( this.options.handle, currentItem ).find( "*" ).addBack().each( function() {
				if ( this === event.target ) {
					validHandle = true;
				}
			} );
			if ( !validHandle ) {
				return false;
			}
		}

		this.currentItem = currentItem;
		this._removeCurrentsFromItems();
		return true;

	},

	_mouseStart: function( event, overrideHandle, noActivation ) {

		var i, body,
			o = this.options;

		this.currentContainer = this;

		//We only need to call refreshPositions, because the refreshItems call has been moved to
		// mouseCapture
		this.refreshPositions();

		//Create and append the visible helper
		this.helper = this._createHelper( event );

		//Cache the helper size
		this._cacheHelperProportions();

		/*
		 * - Position generation -
		 * This block generates everything position related - it's the core of draggables.
		 */

		//Cache the margins of the original element
		this._cacheMargins();

		//Get the next scrolling parent
		this.scrollParent = this.helper.scrollParent();

		//The element's absolute position on the page minus margins
		this.offset = this.currentItem.offset();
		this.offset = {
			top: this.offset.top - this.margins.top,
			left: this.offset.left - this.margins.left
		};

		$.extend( this.offset, {
			click: { //Where the click happened, relative to the element
				left: event.pageX - this.offset.left,
				top: event.pageY - this.offset.top
			},
			parent: this._getParentOffset(),

			// This is a relative to absolute position minus the actual position calculation -
			// only used for relative positioned helper
			relative: this._getRelativeOffset()
		} );

		// Only after we got the offset, we can change the helper's position to absolute
		// TODO: Still need to figure out a way to make relative sorting possible
		this.helper.css( "position", "absolute" );
		this.cssPosition = this.helper.css( "position" );

		//Generate the original position
		this.originalPosition = this._generatePosition( event );
		this.originalPageX = event.pageX;
		this.originalPageY = event.pageY;

		//Adjust the mouse offset relative to the helper if "cursorAt" is supplied
		( o.cursorAt && this._adjustOffsetFromHelper( o.cursorAt ) );

		//Cache the former DOM position
		this.domPosition = {
			prev: this.currentItem.prev()[ 0 ],
			parent: this.currentItem.parent()[ 0 ]
		};

		// If the helper is not the original, hide the original so it's not playing any role during
		// the drag, won't cause anything bad this way
		if ( this.helper[ 0 ] !== this.currentItem[ 0 ] ) {
			this.currentItem.hide();
		}

		//Create the placeholder
		this._createPlaceholder();

		//Set a containment if given in the options
		if ( o.containment ) {
			this._setContainment();
		}

		if ( o.cursor && o.cursor !== "auto" ) { // cursor option
			body = this.document.find( "body" );

			// Support: IE
			this.storedCursor = body.css( "cursor" );
			body.css( "cursor", o.cursor );

			this.storedStylesheet =
				$( "<style>*{ cursor: " + o.cursor + " !important; }</style>" ).appendTo( body );
		}

		if ( o.opacity ) { // opacity option
			if ( this.helper.css( "opacity" ) ) {
				this._storedOpacity = this.helper.css( "opacity" );
			}
			this.helper.css( "opacity", o.opacity );
		}

		if ( o.zIndex ) { // zIndex option
			if ( this.helper.css( "zIndex" ) ) {
				this._storedZIndex = this.helper.css( "zIndex" );
			}
			this.helper.css( "zIndex", o.zIndex );
		}

		//Prepare scrolling
		if ( this.scrollParent[ 0 ] !== this.document[ 0 ] &&
				this.scrollParent[ 0 ].tagName !== "HTML" ) {
			this.overflowOffset = this.scrollParent.offset();
		}

		//Call callbacks
		this._trigger( "start", event, this._uiHash() );

		//Recache the helper size
		if ( !this._preserveHelperProportions ) {
			this._cacheHelperProportions();
		}

		//Post "activate" events to possible containers
		if ( !noActivation ) {
			for ( i = this.containers.length - 1; i >= 0; i-- ) {
				this.containers[ i ]._trigger( "activate", event, this._uiHash( this ) );
			}
		}

		//Prepare possible droppables
		if ( $.ui.ddmanager ) {
			$.ui.ddmanager.current = this;
		}

		if ( $.ui.ddmanager && !o.dropBehaviour ) {
			$.ui.ddmanager.prepareOffsets( this, event );
		}

		this.dragging = true;

		this._addClass( this.helper, "ui-sortable-helper" );

		// Execute the drag once - this causes the helper not to be visiblebefore getting its
		// correct position
		this._mouseDrag( event );
		return true;

	},

	_mouseDrag: function( event ) {
		var i, item, itemElement, intersection,
			o = this.options,
			scrolled = false;

		//Compute the helpers position
		this.position = this._generatePosition( event );
		this.positionAbs = this._convertPositionTo( "absolute" );

		if ( !this.lastPositionAbs ) {
			this.lastPositionAbs = this.positionAbs;
		}

		//Do scrolling
		if ( this.options.scroll ) {
			if ( this.scrollParent[ 0 ] !== this.document[ 0 ] &&
					this.scrollParent[ 0 ].tagName !== "HTML" ) {

				if ( ( this.overflowOffset.top + this.scrollParent[ 0 ].offsetHeight ) -
						event.pageY < o.scrollSensitivity ) {
					this.scrollParent[ 0 ].scrollTop =
						scrolled = this.scrollParent[ 0 ].scrollTop + o.scrollSpeed;
				} else if ( event.pageY - this.overflowOffset.top < o.scrollSensitivity ) {
					this.scrollParent[ 0 ].scrollTop =
						scrolled = this.scrollParent[ 0 ].scrollTop - o.scrollSpeed;
				}

				if ( ( this.overflowOffset.left + this.scrollParent[ 0 ].offsetWidth ) -
						event.pageX < o.scrollSensitivity ) {
					this.scrollParent[ 0 ].scrollLeft = scrolled =
						this.scrollParent[ 0 ].scrollLeft + o.scrollSpeed;
				} else if ( event.pageX - this.overflowOffset.left < o.scrollSensitivity ) {
					this.scrollParent[ 0 ].scrollLeft = scrolled =
						this.scrollParent[ 0 ].scrollLeft - o.scrollSpeed;
				}

			} else {

				if ( event.pageY - this.document.scrollTop() < o.scrollSensitivity ) {
					scrolled = this.document.scrollTop( this.document.scrollTop() - o.scrollSpeed );
				} else if ( this.window.height() - ( event.pageY - this.document.scrollTop() ) <
						o.scrollSensitivity ) {
					scrolled = this.document.scrollTop( this.document.scrollTop() + o.scrollSpeed );
				}

				if ( event.pageX - this.document.scrollLeft() < o.scrollSensitivity ) {
					scrolled = this.document.scrollLeft(
						this.document.scrollLeft() - o.scrollSpeed
					);
				} else if ( this.window.width() - ( event.pageX - this.document.scrollLeft() ) <
						o.scrollSensitivity ) {
					scrolled = this.document.scrollLeft(
						this.document.scrollLeft() + o.scrollSpeed
					);
				}

			}

			if ( scrolled !== false && $.ui.ddmanager && !o.dropBehaviour ) {
				$.ui.ddmanager.prepareOffsets( this, event );
			}
		}

		//Regenerate the absolute position used for position checks
		this.positionAbs = this._convertPositionTo( "absolute" );

		//Set the helper position
		if ( !this.options.axis || this.options.axis !== "y" ) {
			this.helper[ 0 ].style.left = this.position.left + "px";
		}
		if ( !this.options.axis || this.options.axis !== "x" ) {
			this.helper[ 0 ].style.top = this.position.top + "px";
		}

		//Rearrange
		for ( i = this.items.length - 1; i >= 0; i-- ) {

			//Cache variables and intersection, continue if no intersection
			item = this.items[ i ];
			itemElement = item.item[ 0 ];
			intersection = this._intersectsWithPointer( item );
			if ( !intersection ) {
				continue;
			}

			// Only put the placeholder inside the current Container, skip all
			// items from other containers. This works because when moving
			// an item from one container to another the
			// currentContainer is switched before the placeholder is moved.
			//
			// Without this, moving items in "sub-sortables" can cause
			// the placeholder to jitter between the outer and inner container.
			if ( item.instance !== this.currentContainer ) {
				continue;
			}

			// Cannot intersect with itself
			// no useless actions that have been done before
			// no action if the item moved is the parent of the item checked
			if ( itemElement !== this.currentItem[ 0 ] &&
				this.placeholder[ intersection === 1 ? "next" : "prev" ]()[ 0 ] !== itemElement &&
				!$.contains( this.placeholder[ 0 ], itemElement ) &&
				( this.options.type === "semi-dynamic" ?
					!$.contains( this.element[ 0 ], itemElement ) :
					true
				)
			) {

				this.direction = intersection === 1 ? "down" : "up";

				if ( this.options.tolerance === "pointer" || this._intersectsWithSides( item ) ) {
					this._rearrange( event, item );
				} else {
					break;
				}

				this._trigger( "change", event, this._uiHash() );
				break;
			}
		}

		//Post events to containers
		this._contactContainers( event );

		//Interconnect with droppables
		if ( $.ui.ddmanager ) {
			$.ui.ddmanager.drag( this, event );
		}

		//Call callbacks
		this._trigger( "sort", event, this._uiHash() );

		this.lastPositionAbs = this.positionAbs;
		return false;

	},

	_mouseStop: function( event, noPropagation ) {

		if ( !event ) {
			return;
		}

		//If we are using droppables, inform the manager about the drop
		if ( $.ui.ddmanager && !this.options.dropBehaviour ) {
			$.ui.ddmanager.drop( this, event );
		}

		if ( this.options.revert ) {
			var that = this,
				cur = this.placeholder.offset(),
				axis = this.options.axis,
				animation = {};

			if ( !axis || axis === "x" ) {
				animation.left = cur.left - this.offset.parent.left - this.margins.left +
					( this.offsetParent[ 0 ] === this.document[ 0 ].body ?
						0 :
						this.offsetParent[ 0 ].scrollLeft
					);
			}
			if ( !axis || axis === "y" ) {
				animation.top = cur.top - this.offset.parent.top - this.margins.top +
					( this.offsetParent[ 0 ] === this.document[ 0 ].body ?
						0 :
						this.offsetParent[ 0 ].scrollTop
					);
			}
			this.reverting = true;
			$( this.helper ).animate(
				animation,
				parseInt( this.options.revert, 10 ) || 500,
				function() {
					that._clear( event );
				}
			);
		} else {
			this._clear( event, noPropagation );
		}

		return false;

	},

	cancel: function() {

		if ( this.dragging ) {

			this._mouseUp( new $.Event( "mouseup", { target: null } ) );

			if ( this.options.helper === "original" ) {
				this.currentItem.css( this._storedCSS );
				this._removeClass( this.currentItem, "ui-sortable-helper" );
			} else {
				this.currentItem.show();
			}

			//Post deactivating events to containers
			for ( var i = this.containers.length - 1; i >= 0; i-- ) {
				this.containers[ i ]._trigger( "deactivate", null, this._uiHash( this ) );
				if ( this.containers[ i ].containerCache.over ) {
					this.containers[ i ]._trigger( "out", null, this._uiHash( this ) );
					this.containers[ i ].containerCache.over = 0;
				}
			}

		}

		if ( this.placeholder ) {

			//$(this.placeholder[0]).remove(); would have been the jQuery way - unfortunately,
			// it unbinds ALL events from the original node!
			if ( this.placeholder[ 0 ].parentNode ) {
				this.placeholder[ 0 ].parentNode.removeChild( this.placeholder[ 0 ] );
			}
			if ( this.options.helper !== "original" && this.helper &&
					this.helper[ 0 ].parentNode ) {
				this.helper.remove();
			}

			$.extend( this, {
				helper: null,
				dragging: false,
				reverting: false,
				_noFinalSort: null
			} );

			if ( this.domPosition.prev ) {
				$( this.domPosition.prev ).after( this.currentItem );
			} else {
				$( this.domPosition.parent ).prepend( this.currentItem );
			}
		}

		return this;

	},

	serialize: function( o ) {

		var items = this._getItemsAsjQuery( o && o.connected ),
			str = [];
		o = o || {};

		$( items ).each( function() {
			var res = ( $( o.item || this ).attr( o.attribute || "id" ) || "" )
				.match( o.expression || ( /(.+)[\-=_](.+)/ ) );
			if ( res ) {
				str.push(
					( o.key || res[ 1 ] + "[]" ) +
					"=" + ( o.key && o.expression ? res[ 1 ] : res[ 2 ] ) );
			}
		} );

		if ( !str.length && o.key ) {
			str.push( o.key + "=" );
		}

		return str.join( "&" );

	},

	toArray: function( o ) {

		var items = this._getItemsAsjQuery( o && o.connected ),
			ret = [];

		o = o || {};

		items.each( function() {
			ret.push( $( o.item || this ).attr( o.attribute || "id" ) || "" );
		} );
		return ret;

	},

	/* Be careful with the following core functions */
	_intersectsWith: function( item ) {

		var x1 = this.positionAbs.left,
			x2 = x1 + this.helperProportions.width,
			y1 = this.positionAbs.top,
			y2 = y1 + this.helperProportions.height,
			l = item.left,
			r = l + item.width,
			t = item.top,
			b = t + item.height,
			dyClick = this.offset.click.top,
			dxClick = this.offset.click.left,
			isOverElementHeight = ( this.options.axis === "x" ) || ( ( y1 + dyClick ) > t &&
				( y1 + dyClick ) < b ),
			isOverElementWidth = ( this.options.axis === "y" ) || ( ( x1 + dxClick ) > l &&
				( x1 + dxClick ) < r ),
			isOverElement = isOverElementHeight && isOverElementWidth;

		if ( this.options.tolerance === "pointer" ||
			this.options.forcePointerForContainers ||
			( this.options.tolerance !== "pointer" &&
				this.helperProportions[ this.floating ? "width" : "height" ] >
				item[ this.floating ? "width" : "height" ] )
		) {
			return isOverElement;
		} else {

			return ( l < x1 + ( this.helperProportions.width / 2 ) && // Right Half
				x2 - ( this.helperProportions.width / 2 ) < r && // Left Half
				t < y1 + ( this.helperProportions.height / 2 ) && // Bottom Half
				y2 - ( this.helperProportions.height / 2 ) < b ); // Top Half

		}
	},

	_intersectsWithPointer: function( item ) {
		var verticalDirection, horizontalDirection,
			isOverElementHeight = ( this.options.axis === "x" ) ||
				this._isOverAxis(
					this.positionAbs.top + this.offset.click.top, item.top, item.height ),
			isOverElementWidth = ( this.options.axis === "y" ) ||
				this._isOverAxis(
					this.positionAbs.left + this.offset.click.left, item.left, item.width ),
			isOverElement = isOverElementHeight && isOverElementWidth;

		if ( !isOverElement ) {
			return false;
		}

		verticalDirection = this._getDragVerticalDirection();
		horizontalDirection = this._getDragHorizontalDirection();

		return this.floating ?
			( ( horizontalDirection === "right" || verticalDirection === "down" ) ? 2 : 1 )
			: ( verticalDirection && ( verticalDirection === "down" ? 2 : 1 ) );

	},

	_intersectsWithSides: function( item ) {

		var isOverBottomHalf = this._isOverAxis( this.positionAbs.top +
				this.offset.click.top, item.top + ( item.height / 2 ), item.height ),
			isOverRightHalf = this._isOverAxis( this.positionAbs.left +
				this.offset.click.left, item.left + ( item.width / 2 ), item.width ),
			verticalDirection = this._getDragVerticalDirection(),
			horizontalDirection = this._getDragHorizontalDirection();

		if ( this.floating && horizontalDirection ) {
			return ( ( horizontalDirection === "right" && isOverRightHalf ) ||
				( horizontalDirection === "left" && !isOverRightHalf ) );
		} else {
			return verticalDirection && ( ( verticalDirection === "down" && isOverBottomHalf ) ||
				( verticalDirection === "up" && !isOverBottomHalf ) );
		}

	},

	_getDragVerticalDirection: function() {
		var delta = this.positionAbs.top - this.lastPositionAbs.top;
		return delta !== 0 && ( delta > 0 ? "down" : "up" );
	},

	_getDragHorizontalDirection: function() {
		var delta = this.positionAbs.left - this.lastPositionAbs.left;
		return delta !== 0 && ( delta > 0 ? "right" : "left" );
	},

	refresh: function( event ) {
		this._refreshItems( event );
		this._setHandleClassName();
		this.refreshPositions();
		return this;
	},

	_connectWith: function() {
		var options = this.options;
		return options.connectWith.constructor === String ?
			[ options.connectWith ] :
			options.connectWith;
	},

	_getItemsAsjQuery: function( connected ) {

		var i, j, cur, inst,
			items = [],
			queries = [],
			connectWith = this._connectWith();

		if ( connectWith && connected ) {
			for ( i = connectWith.length - 1; i >= 0; i-- ) {
				cur = $( connectWith[ i ], this.document[ 0 ] );
				for ( j = cur.length - 1; j >= 0; j-- ) {
					inst = $.data( cur[ j ], this.widgetFullName );
					if ( inst && inst !== this && !inst.options.disabled ) {
						queries.push( [ $.isFunction( inst.options.items ) ?
							inst.options.items.call( inst.element ) :
							$( inst.options.items, inst.element )
								.not( ".ui-sortable-helper" )
								.not( ".ui-sortable-placeholder" ), inst ] );
					}
				}
			}
		}

		queries.push( [ $.isFunction( this.options.items ) ?
			this.options.items
				.call( this.element, null, { options: this.options, item: this.currentItem } ) :
			$( this.options.items, this.element )
				.not( ".ui-sortable-helper" )
				.not( ".ui-sortable-placeholder" ), this ] );

		function addItems() {
			items.push( this );
		}
		for ( i = queries.length - 1; i >= 0; i-- ) {
			queries[ i ][ 0 ].each( addItems );
		}

		return $( items );

	},

	_removeCurrentsFromItems: function() {

		var list = this.currentItem.find( ":data(" + this.widgetName + "-item)" );

		this.items = $.grep( this.items, function( item ) {
			for ( var j = 0; j < list.length; j++ ) {
				if ( list[ j ] === item.item[ 0 ] ) {
					return false;
				}
			}
			return true;
		} );

	},

	_refreshItems: function( event ) {

		this.items = [];
		this.containers = [ this ];

		var i, j, cur, inst, targetData, _queries, item, queriesLength,
			items = this.items,
			queries = [ [ $.isFunction( this.options.items ) ?
				this.options.items.call( this.element[ 0 ], event, { item: this.currentItem } ) :
				$( this.options.items, this.element ), this ] ],
			connectWith = this._connectWith();

		//Shouldn't be run the first time through due to massive slow-down
		if ( connectWith && this.ready ) {
			for ( i = connectWith.length - 1; i >= 0; i-- ) {
				cur = $( connectWith[ i ], this.document[ 0 ] );
				for ( j = cur.length - 1; j >= 0; j-- ) {
					inst = $.data( cur[ j ], this.widgetFullName );
					if ( inst && inst !== this && !inst.options.disabled ) {
						queries.push( [ $.isFunction( inst.options.items ) ?
							inst.options.items
								.call( inst.element[ 0 ], event, { item: this.currentItem } ) :
							$( inst.options.items, inst.element ), inst ] );
						this.containers.push( inst );
					}
				}
			}
		}

		for ( i = queries.length - 1; i >= 0; i-- ) {
			targetData = queries[ i ][ 1 ];
			_queries = queries[ i ][ 0 ];

			for ( j = 0, queriesLength = _queries.length; j < queriesLength; j++ ) {
				item = $( _queries[ j ] );

				// Data for target checking (mouse manager)
				item.data( this.widgetName + "-item", targetData );

				items.push( {
					item: item,
					instance: targetData,
					width: 0, height: 0,
					left: 0, top: 0
				} );
			}
		}

	},

	refreshPositions: function( fast ) {

		// Determine whether items are being displayed horizontally
		this.floating = this.items.length ?
			this.options.axis === "x" || this._isFloating( this.items[ 0 ].item ) :
			false;

		//This has to be redone because due to the item being moved out/into the offsetParent,
		// the offsetParent's position will change
		if ( this.offsetParent && this.helper ) {
			this.offset.parent = this._getParentOffset();
		}

		var i, item, t, p;

		for ( i = this.items.length - 1; i >= 0; i-- ) {
			item = this.items[ i ];

			//We ignore calculating positions of all connected containers when we're not over them
			if ( item.instance !== this.currentContainer && this.currentContainer &&
					item.item[ 0 ] !== this.currentItem[ 0 ] ) {
				continue;
			}

			t = this.options.toleranceElement ?
				$( this.options.toleranceElement, item.item ) :
				item.item;

			if ( !fast ) {
				item.width = t.outerWidth();
				item.height = t.outerHeight();
			}

			p = t.offset();
			item.left = p.left;
			item.top = p.top;
		}

		if ( this.options.custom && this.options.custom.refreshContainers ) {
			this.options.custom.refreshContainers.call( this );
		} else {
			for ( i = this.containers.length - 1; i >= 0; i-- ) {
				p = this.containers[ i ].element.offset();
				this.containers[ i ].containerCache.left = p.left;
				this.containers[ i ].containerCache.top = p.top;
				this.containers[ i ].containerCache.width =
					this.containers[ i ].element.outerWidth();
				this.containers[ i ].containerCache.height =
					this.containers[ i ].element.outerHeight();
			}
		}

		return this;
	},

	_createPlaceholder: function( that ) {
		that = that || this;
		var className,
			o = that.options;

		if ( !o.placeholder || o.placeholder.constructor === String ) {
			className = o.placeholder;
			o.placeholder = {
				element: function() {

					var nodeName = that.currentItem[ 0 ].nodeName.toLowerCase(),
						element = $( "<" + nodeName + ">", that.document[ 0 ] );

						that._addClass( element, "ui-sortable-placeholder",
								className || that.currentItem[ 0 ].className )
							._removeClass( element, "ui-sortable-helper" );

					if ( nodeName === "tbody" ) {
						that._createTrPlaceholder(
							that.currentItem.find( "tr" ).eq( 0 ),
							$( "<tr>", that.document[ 0 ] ).appendTo( element )
						);
					} else if ( nodeName === "tr" ) {
						that._createTrPlaceholder( that.currentItem, element );
					} else if ( nodeName === "img" ) {
						element.attr( "src", that.currentItem.attr( "src" ) );
					}

					if ( !className ) {
						element.css( "visibility", "hidden" );
					}

					return element;
				},
				update: function( container, p ) {

					// 1. If a className is set as 'placeholder option, we don't force sizes -
					// the class is responsible for that
					// 2. The option 'forcePlaceholderSize can be enabled to force it even if a
					// class name is specified
					if ( className && !o.forcePlaceholderSize ) {
						return;
					}

					//If the element doesn't have a actual height by itself (without styles coming
					// from a stylesheet), it receives the inline height from the dragged item
					if ( !p.height() ) {
						p.height(
							that.currentItem.innerHeight() -
							parseInt( that.currentItem.css( "paddingTop" ) || 0, 10 ) -
							parseInt( that.currentItem.css( "paddingBottom" ) || 0, 10 ) );
					}
					if ( !p.width() ) {
						p.width(
							that.currentItem.innerWidth() -
							parseInt( that.currentItem.css( "paddingLeft" ) || 0, 10 ) -
							parseInt( that.currentItem.css( "paddingRight" ) || 0, 10 ) );
					}
				}
			};
		}

		//Create the placeholder
		that.placeholder = $( o.placeholder.element.call( that.element, that.currentItem ) );

		//Append it after the actual current item
		that.currentItem.after( that.placeholder );

		//Update the size of the placeholder (TODO: Logic to fuzzy, see line 316/317)
		o.placeholder.update( that, that.placeholder );

	},

	_createTrPlaceholder: function( sourceTr, targetTr ) {
		var that = this;

		sourceTr.children().each( function() {
			$( "<td>&#160;</td>", that.document[ 0 ] )
				.attr( "colspan", $( this ).attr( "colspan" ) || 1 )
				.appendTo( targetTr );
		} );
	},

	_contactContainers: function( event ) {
		var i, j, dist, itemWithLeastDistance, posProperty, sizeProperty, cur, nearBottom,
			floating, axis,
			innermostContainer = null,
			innermostIndex = null;

		// Get innermost container that intersects with item
		for ( i = this.containers.length - 1; i >= 0; i-- ) {

			// Never consider a container that's located within the item itself
			if ( $.contains( this.currentItem[ 0 ], this.containers[ i ].element[ 0 ] ) ) {
				continue;
			}

			if ( this._intersectsWith( this.containers[ i ].containerCache ) ) {

				// If we've already found a container and it's more "inner" than this, then continue
				if ( innermostContainer &&
						$.contains(
							this.containers[ i ].element[ 0 ],
							innermostContainer.element[ 0 ] ) ) {
					continue;
				}

				innermostContainer = this.containers[ i ];
				innermostIndex = i;

			} else {

				// container doesn't intersect. trigger "out" event if necessary
				if ( this.containers[ i ].containerCache.over ) {
					this.containers[ i ]._trigger( "out", event, this._uiHash( this ) );
					this.containers[ i ].containerCache.over = 0;
				}
			}

		}

		// If no intersecting containers found, return
		if ( !innermostContainer ) {
			return;
		}

		// Move the item into the container if it's not there already
		if ( this.containers.length === 1 ) {
			if ( !this.containers[ innermostIndex ].containerCache.over ) {
				this.containers[ innermostIndex ]._trigger( "over", event, this._uiHash( this ) );
				this.containers[ innermostIndex ].containerCache.over = 1;
			}
		} else {

			// When entering a new container, we will find the item with the least distance and
			// append our item near it
			dist = 10000;
			itemWithLeastDistance = null;
			floating = innermostContainer.floating || this._isFloating( this.currentItem );
			posProperty = floating ? "left" : "top";
			sizeProperty = floating ? "width" : "height";
			axis = floating ? "pageX" : "pageY";

			for ( j = this.items.length - 1; j >= 0; j-- ) {
				if ( !$.contains(
						this.containers[ innermostIndex ].element[ 0 ], this.items[ j ].item[ 0 ] )
				) {
					continue;
				}
				if ( this.items[ j ].item[ 0 ] === this.currentItem[ 0 ] ) {
					continue;
				}

				cur = this.items[ j ].item.offset()[ posProperty ];
				nearBottom = false;
				if ( event[ axis ] - cur > this.items[ j ][ sizeProperty ] / 2 ) {
					nearBottom = true;
				}

				if ( Math.abs( event[ axis ] - cur ) < dist ) {
					dist = Math.abs( event[ axis ] - cur );
					itemWithLeastDistance = this.items[ j ];
					this.direction = nearBottom ? "up" : "down";
				}
			}

			//Check if dropOnEmpty is enabled
			if ( !itemWithLeastDistance && !this.options.dropOnEmpty ) {
				return;
			}

			if ( this.currentContainer === this.containers[ innermostIndex ] ) {
				if ( !this.currentContainer.containerCache.over ) {
					this.containers[ innermostIndex ]._trigger( "over", event, this._uiHash() );
					this.currentContainer.containerCache.over = 1;
				}
				return;
			}

			itemWithLeastDistance ?
				this._rearrange( event, itemWithLeastDistance, null, true ) :
				this._rearrange( event, null, this.containers[ innermostIndex ].element, true );
			this._trigger( "change", event, this._uiHash() );
			this.containers[ innermostIndex ]._trigger( "change", event, this._uiHash( this ) );
			this.currentContainer = this.containers[ innermostIndex ];

			//Update the placeholder
			this.options.placeholder.update( this.currentContainer, this.placeholder );

			this.containers[ innermostIndex ]._trigger( "over", event, this._uiHash( this ) );
			this.containers[ innermostIndex ].containerCache.over = 1;
		}

	},

	_createHelper: function( event ) {

		var o = this.options,
			helper = $.isFunction( o.helper ) ?
				$( o.helper.apply( this.element[ 0 ], [ event, this.currentItem ] ) ) :
				( o.helper === "clone" ? this.currentItem.clone() : this.currentItem );

		//Add the helper to the DOM if that didn't happen already
		if ( !helper.parents( "body" ).length ) {
			$( o.appendTo !== "parent" ?
				o.appendTo :
				this.currentItem[ 0 ].parentNode )[ 0 ].appendChild( helper[ 0 ] );
		}

		if ( helper[ 0 ] === this.currentItem[ 0 ] ) {
			this._storedCSS = {
				width: this.currentItem[ 0 ].style.width,
				height: this.currentItem[ 0 ].style.height,
				position: this.currentItem.css( "position" ),
				top: this.currentItem.css( "top" ),
				left: this.currentItem.css( "left" )
			};
		}

		if ( !helper[ 0 ].style.width || o.forceHelperSize ) {
			helper.width( this.currentItem.width() );
		}
		if ( !helper[ 0 ].style.height || o.forceHelperSize ) {
			helper.height( this.currentItem.height() );
		}

		return helper;

	},

	_adjustOffsetFromHelper: function( obj ) {
		if ( typeof obj === "string" ) {
			obj = obj.split( " " );
		}
		if ( $.isArray( obj ) ) {
			obj = { left: +obj[ 0 ], top: +obj[ 1 ] || 0 };
		}
		if ( "left" in obj ) {
			this.offset.click.left = obj.left + this.margins.left;
		}
		if ( "right" in obj ) {
			this.offset.click.left = this.helperProportions.width - obj.right + this.margins.left;
		}
		if ( "top" in obj ) {
			this.offset.click.top = obj.top + this.margins.top;
		}
		if ( "bottom" in obj ) {
			this.offset.click.top = this.helperProportions.height - obj.bottom + this.margins.top;
		}
	},

	_getParentOffset: function() {

		//Get the offsetParent and cache its position
		this.offsetParent = this.helper.offsetParent();
		var po = this.offsetParent.offset();

		// This is a special case where we need to modify a offset calculated on start, since the
		// following happened:
		// 1. The position of the helper is absolute, so it's position is calculated based on the
		// next positioned parent
		// 2. The actual offset parent is a child of the scroll parent, and the scroll parent isn't
		// the document, which means that the scroll is included in the initial calculation of the
		// offset of the parent, and never recalculated upon drag
		if ( this.cssPosition === "absolute" && this.scrollParent[ 0 ] !== this.document[ 0 ] &&
				$.contains( this.scrollParent[ 0 ], this.offsetParent[ 0 ] ) ) {
			po.left += this.scrollParent.scrollLeft();
			po.top += this.scrollParent.scrollTop();
		}

		// This needs to be actually done for all browsers, since pageX/pageY includes this
		// information with an ugly IE fix
		if ( this.offsetParent[ 0 ] === this.document[ 0 ].body ||
				( this.offsetParent[ 0 ].tagName &&
				this.offsetParent[ 0 ].tagName.toLowerCase() === "html" && $.ui.ie ) ) {
			po = { top: 0, left: 0 };
		}

		return {
			top: po.top + ( parseInt( this.offsetParent.css( "borderTopWidth" ), 10 ) || 0 ),
			left: po.left + ( parseInt( this.offsetParent.css( "borderLeftWidth" ), 10 ) || 0 )
		};

	},

	_getRelativeOffset: function() {

		if ( this.cssPosition === "relative" ) {
			var p = this.currentItem.position();
			return {
				top: p.top - ( parseInt( this.helper.css( "top" ), 10 ) || 0 ) +
					this.scrollParent.scrollTop(),
				left: p.left - ( parseInt( this.helper.css( "left" ), 10 ) || 0 ) +
					this.scrollParent.scrollLeft()
			};
		} else {
			return { top: 0, left: 0 };
		}

	},

	_cacheMargins: function() {
		this.margins = {
			left: ( parseInt( this.currentItem.css( "marginLeft" ), 10 ) || 0 ),
			top: ( parseInt( this.currentItem.css( "marginTop" ), 10 ) || 0 )
		};
	},

	_cacheHelperProportions: function() {
		this.helperProportions = {
			width: this.helper.outerWidth(),
			height: this.helper.outerHeight()
		};
	},

	_setContainment: function() {

		var ce, co, over,
			o = this.options;
		if ( o.containment === "parent" ) {
			o.containment = this.helper[ 0 ].parentNode;
		}
		if ( o.containment === "document" || o.containment === "window" ) {
			this.containment = [
				0 - this.offset.relative.left - this.offset.parent.left,
				0 - this.offset.relative.top - this.offset.parent.top,
				o.containment === "document" ?
					this.document.width() :
					this.window.width() - this.helperProportions.width - this.margins.left,
				( o.containment === "document" ?
					( this.document.height() || document.body.parentNode.scrollHeight ) :
					this.window.height() || this.document[ 0 ].body.parentNode.scrollHeight
				) - this.helperProportions.height - this.margins.top
			];
		}

		if ( !( /^(document|window|parent)$/ ).test( o.containment ) ) {
			ce = $( o.containment )[ 0 ];
			co = $( o.containment ).offset();
			over = ( $( ce ).css( "overflow" ) !== "hidden" );

			this.containment = [
				co.left + ( parseInt( $( ce ).css( "borderLeftWidth" ), 10 ) || 0 ) +
					( parseInt( $( ce ).css( "paddingLeft" ), 10 ) || 0 ) - this.margins.left,
				co.top + ( parseInt( $( ce ).css( "borderTopWidth" ), 10 ) || 0 ) +
					( parseInt( $( ce ).css( "paddingTop" ), 10 ) || 0 ) - this.margins.top,
				co.left + ( over ? Math.max( ce.scrollWidth, ce.offsetWidth ) : ce.offsetWidth ) -
					( parseInt( $( ce ).css( "borderLeftWidth" ), 10 ) || 0 ) -
					( parseInt( $( ce ).css( "paddingRight" ), 10 ) || 0 ) -
					this.helperProportions.width - this.margins.left,
				co.top + ( over ? Math.max( ce.scrollHeight, ce.offsetHeight ) : ce.offsetHeight ) -
					( parseInt( $( ce ).css( "borderTopWidth" ), 10 ) || 0 ) -
					( parseInt( $( ce ).css( "paddingBottom" ), 10 ) || 0 ) -
					this.helperProportions.height - this.margins.top
			];
		}

	},

	_convertPositionTo: function( d, pos ) {

		if ( !pos ) {
			pos = this.position;
		}
		var mod = d === "absolute" ? 1 : -1,
			scroll = this.cssPosition === "absolute" &&
				!( this.scrollParent[ 0 ] !== this.document[ 0 ] &&
				$.contains( this.scrollParent[ 0 ], this.offsetParent[ 0 ] ) ) ?
					this.offsetParent :
					this.scrollParent,
			scrollIsRootNode = ( /(html|body)/i ).test( scroll[ 0 ].tagName );

		return {
			top: (

				// The absolute mouse position
				pos.top	+

				// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.relative.top * mod +

				// The offsetParent's offset without borders (offset + border)
				this.offset.parent.top * mod -
				( ( this.cssPosition === "fixed" ?
					-this.scrollParent.scrollTop() :
					( scrollIsRootNode ? 0 : scroll.scrollTop() ) ) * mod )
			),
			left: (

				// The absolute mouse position
				pos.left +

				// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.relative.left * mod +

				// The offsetParent's offset without borders (offset + border)
				this.offset.parent.left * mod	-
				( ( this.cssPosition === "fixed" ?
					-this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 :
					scroll.scrollLeft() ) * mod )
			)
		};

	},

	_generatePosition: function( event ) {

		var top, left,
			o = this.options,
			pageX = event.pageX,
			pageY = event.pageY,
			scroll = this.cssPosition === "absolute" &&
				!( this.scrollParent[ 0 ] !== this.document[ 0 ] &&
				$.contains( this.scrollParent[ 0 ], this.offsetParent[ 0 ] ) ) ?
					this.offsetParent :
					this.scrollParent,
				scrollIsRootNode = ( /(html|body)/i ).test( scroll[ 0 ].tagName );

		// This is another very weird special case that only happens for relative elements:
		// 1. If the css position is relative
		// 2. and the scroll parent is the document or similar to the offset parent
		// we have to refresh the relative offset during the scroll so there are no jumps
		if ( this.cssPosition === "relative" && !( this.scrollParent[ 0 ] !== this.document[ 0 ] &&
				this.scrollParent[ 0 ] !== this.offsetParent[ 0 ] ) ) {
			this.offset.relative = this._getRelativeOffset();
		}

		/*
		 * - Position constraining -
		 * Constrain the position to a mix of grid, containment.
		 */

		if ( this.originalPosition ) { //If we are not dragging yet, we won't check for options

			if ( this.containment ) {
				if ( event.pageX - this.offset.click.left < this.containment[ 0 ] ) {
					pageX = this.containment[ 0 ] + this.offset.click.left;
				}
				if ( event.pageY - this.offset.click.top < this.containment[ 1 ] ) {
					pageY = this.containment[ 1 ] + this.offset.click.top;
				}
				if ( event.pageX - this.offset.click.left > this.containment[ 2 ] ) {
					pageX = this.containment[ 2 ] + this.offset.click.left;
				}
				if ( event.pageY - this.offset.click.top > this.containment[ 3 ] ) {
					pageY = this.containment[ 3 ] + this.offset.click.top;
				}
			}

			if ( o.grid ) {
				top = this.originalPageY + Math.round( ( pageY - this.originalPageY ) /
					o.grid[ 1 ] ) * o.grid[ 1 ];
				pageY = this.containment ?
					( ( top - this.offset.click.top >= this.containment[ 1 ] &&
						top - this.offset.click.top <= this.containment[ 3 ] ) ?
							top :
							( ( top - this.offset.click.top >= this.containment[ 1 ] ) ?
								top - o.grid[ 1 ] : top + o.grid[ 1 ] ) ) :
								top;

				left = this.originalPageX + Math.round( ( pageX - this.originalPageX ) /
					o.grid[ 0 ] ) * o.grid[ 0 ];
				pageX = this.containment ?
					( ( left - this.offset.click.left >= this.containment[ 0 ] &&
						left - this.offset.click.left <= this.containment[ 2 ] ) ?
							left :
							( ( left - this.offset.click.left >= this.containment[ 0 ] ) ?
								left - o.grid[ 0 ] : left + o.grid[ 0 ] ) ) :
								left;
			}

		}

		return {
			top: (

				// The absolute mouse position
				pageY -

				// Click offset (relative to the element)
				this.offset.click.top -

				// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.relative.top -

				// The offsetParent's offset without borders (offset + border)
				this.offset.parent.top +
				( ( this.cssPosition === "fixed" ?
					-this.scrollParent.scrollTop() :
					( scrollIsRootNode ? 0 : scroll.scrollTop() ) ) )
			),
			left: (

				// The absolute mouse position
				pageX -

				// Click offset (relative to the element)
				this.offset.click.left -

				// Only for relative positioned nodes: Relative offset from element to offset parent
				this.offset.relative.left -

				// The offsetParent's offset without borders (offset + border)
				this.offset.parent.left +
				( ( this.cssPosition === "fixed" ?
					-this.scrollParent.scrollLeft() :
					scrollIsRootNode ? 0 : scroll.scrollLeft() ) )
			)
		};

	},

	_rearrange: function( event, i, a, hardRefresh ) {

		a ? a[ 0 ].appendChild( this.placeholder[ 0 ] ) :
			i.item[ 0 ].parentNode.insertBefore( this.placeholder[ 0 ],
				( this.direction === "down" ? i.item[ 0 ] : i.item[ 0 ].nextSibling ) );

		//Various things done here to improve the performance:
		// 1. we create a setTimeout, that calls refreshPositions
		// 2. on the instance, we have a counter variable, that get's higher after every append
		// 3. on the local scope, we copy the counter variable, and check in the timeout,
		// if it's still the same
		// 4. this lets only the last addition to the timeout stack through
		this.counter = this.counter ? ++this.counter : 1;
		var counter = this.counter;

		this._delay( function() {
			if ( counter === this.counter ) {

				//Precompute after each DOM insertion, NOT on mousemove
				this.refreshPositions( !hardRefresh );
			}
		} );

	},

	_clear: function( event, noPropagation ) {

		this.reverting = false;

		// We delay all events that have to be triggered to after the point where the placeholder
		// has been removed and everything else normalized again
		var i,
			delayedTriggers = [];

		// We first have to update the dom position of the actual currentItem
		// Note: don't do it if the current item is already removed (by a user), or it gets
		// reappended (see #4088)
		if ( !this._noFinalSort && this.currentItem.parent().length ) {
			this.placeholder.before( this.currentItem );
		}
		this._noFinalSort = null;

		if ( this.helper[ 0 ] === this.currentItem[ 0 ] ) {
			for ( i in this._storedCSS ) {
				if ( this._storedCSS[ i ] === "auto" || this._storedCSS[ i ] === "static" ) {
					this._storedCSS[ i ] = "";
				}
			}
			this.currentItem.css( this._storedCSS );
			this._removeClass( this.currentItem, "ui-sortable-helper" );
		} else {
			this.currentItem.show();
		}

		if ( this.fromOutside && !noPropagation ) {
			delayedTriggers.push( function( event ) {
				this._trigger( "receive", event, this._uiHash( this.fromOutside ) );
			} );
		}
		if ( ( this.fromOutside ||
				this.domPosition.prev !==
				this.currentItem.prev().not( ".ui-sortable-helper" )[ 0 ] ||
				this.domPosition.parent !== this.currentItem.parent()[ 0 ] ) && !noPropagation ) {

			// Trigger update callback if the DOM position has changed
			delayedTriggers.push( function( event ) {
				this._trigger( "update", event, this._uiHash() );
			} );
		}

		// Check if the items Container has Changed and trigger appropriate
		// events.
		if ( this !== this.currentContainer ) {
			if ( !noPropagation ) {
				delayedTriggers.push( function( event ) {
					this._trigger( "remove", event, this._uiHash() );
				} );
				delayedTriggers.push( ( function( c ) {
					return function( event ) {
						c._trigger( "receive", event, this._uiHash( this ) );
					};
				} ).call( this, this.currentContainer ) );
				delayedTriggers.push( ( function( c ) {
					return function( event ) {
						c._trigger( "update", event, this._uiHash( this ) );
					};
				} ).call( this, this.currentContainer ) );
			}
		}

		//Post events to containers
		function delayEvent( type, instance, container ) {
			return function( event ) {
				container._trigger( type, event, instance._uiHash( instance ) );
			};
		}
		for ( i = this.containers.length - 1; i >= 0; i-- ) {
			if ( !noPropagation ) {
				delayedTriggers.push( delayEvent( "deactivate", this, this.containers[ i ] ) );
			}
			if ( this.containers[ i ].containerCache.over ) {
				delayedTriggers.push( delayEvent( "out", this, this.containers[ i ] ) );
				this.containers[ i ].containerCache.over = 0;
			}
		}

		//Do what was originally in plugins
		if ( this.storedCursor ) {
			this.document.find( "body" ).css( "cursor", this.storedCursor );
			this.storedStylesheet.remove();
		}
		if ( this._storedOpacity ) {
			this.helper.css( "opacity", this._storedOpacity );
		}
		if ( this._storedZIndex ) {
			this.helper.css( "zIndex", this._storedZIndex === "auto" ? "" : this._storedZIndex );
		}

		this.dragging = false;

		if ( !noPropagation ) {
			this._trigger( "beforeStop", event, this._uiHash() );
		}

		//$(this.placeholder[0]).remove(); would have been the jQuery way - unfortunately,
		// it unbinds ALL events from the original node!
		this.placeholder[ 0 ].parentNode.removeChild( this.placeholder[ 0 ] );

		if ( !this.cancelHelperRemoval ) {
			if ( this.helper[ 0 ] !== this.currentItem[ 0 ] ) {
				this.helper.remove();
			}
			this.helper = null;
		}

		if ( !noPropagation ) {
			for ( i = 0; i < delayedTriggers.length; i++ ) {

				// Trigger all delayed events
				delayedTriggers[ i ].call( this, event );
			}
			this._trigger( "stop", event, this._uiHash() );
		}

		this.fromOutside = false;
		return !this.cancelHelperRemoval;

	},

	_trigger: function() {
		if ( $.Widget.prototype._trigger.apply( this, arguments ) === false ) {
			this.cancel();
		}
	},

	_uiHash: function( _inst ) {
		var inst = _inst || this;
		return {
			helper: inst.helper,
			placeholder: inst.placeholder || $( [] ),
			position: inst.position,
			originalPosition: inst.originalPosition,
			offset: inst.positionAbs,
			item: inst.currentItem,
			sender: _inst ? _inst.element : null
		};
	}

} );

} ) );


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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(20);

/***/ }),

/***/ "./node_modules/nestedSortable/jquery.mjs.nestedSortable.js":
/*!******************************************************************!*\
  !*** ./node_modules/nestedSortable/jquery.mjs.nestedSortable.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*
 * jQuery UI Nested Sortable
 * v 2.1a / 2016-02-04
 * https://github.com/ilikenwf/nestedSortable
 *
 * Depends on:
 *	 jquery.ui.sortable.js 1.10+
 *
 * Copyright (c) 2010-2016 Manuele J Sarfatti and contributors
 * Licensed under the MIT License
 * http://www.opensource.org/licenses/mit-license.php
 */
(function( factory ) {
	"use strict";

	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [
			__webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"),
			__webpack_require__(/*! jquery-ui/sortable */ "./node_modules/jquery-ui/ui/widgets/sortable.js")
		], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}(function($) {
	"use strict";

	function isOverAxis( x, reference, size ) {
		return ( x > reference ) && ( x < ( reference + size ) );
	}

	$.widget("mjs.nestedSortable", $.extend({}, $.ui.sortable.prototype, {

		options: {
			disableParentChange: false,
			doNotClear: false,
			expandOnHover: 700,
			isAllowed: function() { return true; },
			isTree: false,
			listType: "ol",
			maxLevels: 0,
			protectRoot: false,
			rootID: null,
			rtl: false,
			startCollapsed: false,
			tabSize: 20,

			branchClass: "mjs-nestedSortable-branch",
			collapsedClass: "mjs-nestedSortable-collapsed",
			disableNestingClass: "mjs-nestedSortable-no-nesting",
			errorClass: "mjs-nestedSortable-error",
			expandedClass: "mjs-nestedSortable-expanded",
			hoveringClass: "mjs-nestedSortable-hovering",
			leafClass: "mjs-nestedSortable-leaf",
			disabledClass: "mjs-nestedSortable-disabled"
		},

		_create: function() {
			var self = this,
				err;

			this.element.data("ui-sortable", this.element.data("mjs-nestedSortable"));

			// mjs - prevent browser from freezing if the HTML is not correct
			if (!this.element.is(this.options.listType)) {
				err = "nestedSortable: " +
					"Please check that the listType option is set to your actual list type";

				throw new Error(err);
			}

			// if we have a tree with expanding/collapsing functionality,
			// force 'intersect' tolerance method
			if (this.options.isTree && this.options.expandOnHover) {
				this.options.tolerance = "intersect";
			}

			$.ui.sortable.prototype._create.apply(this, arguments);

			// prepare the tree by applying the right classes
			// (the CSS is responsible for actual hide/show functionality)
			if (this.options.isTree) {
				$(this.items).each(function() {
					var $li = this.item,
						hasCollapsedClass = $li.hasClass(self.options.collapsedClass),
						hasExpandedClass = $li.hasClass(self.options.expandedClass);

					if ($li.children(self.options.listType).length) {
						$li.addClass(self.options.branchClass);
						// expand/collapse class only if they have children

						if ( !hasCollapsedClass && !hasExpandedClass ) {
							if (self.options.startCollapsed) {
								$li.addClass(self.options.collapsedClass);
							} else {
								$li.addClass(self.options.expandedClass);
							}
						}
					} else {
						$li.addClass(self.options.leafClass);
					}
				});
			}
		},

		_destroy: function() {
			this.element
				.removeData("mjs-nestedSortable")
				.removeData("ui-sortable");
			return $.ui.sortable.prototype._destroy.apply(this, arguments);
		},

		_mouseDrag: function(event) {
			var i,
				item,
				itemElement,
				intersection,
				self = this,
				o = this.options,
				scrolled = false,
				$document = $(document),
				previousTopOffset,
				parentItem,
				level,
				childLevels,
				itemAfter,
				itemBefore,
				newList,
				method,
				a,
				previousItem,
				nextItem,
				helperIsNotSibling;

			//Compute the helpers position
			this.position = this._generatePosition(event);
			this.positionAbs = this._convertPositionTo("absolute");

			if (!this.lastPositionAbs) {
				this.lastPositionAbs = this.positionAbs;
			}

			//Do scrolling
			if (this.options.scroll) {
				if (this.scrollParent[0] !== document && this.scrollParent[0].tagName !== "HTML") {

					if (
						(
							this.overflowOffset.top +
							this.scrollParent[0].offsetHeight
						) -
						event.pageY <
						o.scrollSensitivity
					) {
						scrolled = this.scrollParent.scrollTop() + o.scrollSpeed;
						this.scrollParent.scrollTop(scrolled);
					} else if (
						event.pageY -
						this.overflowOffset.top <
						o.scrollSensitivity
					) {
						scrolled = this.scrollParent.scrollTop() - o.scrollSpeed;
						this.scrollParent.scrollTop(scrolled);
					}

					if (
						(
							this.overflowOffset.left +
							this.scrollParent[0].offsetWidth
						) -
						event.pageX <
						o.scrollSensitivity
					) {
						scrolled = this.scrollParent.scrollLeft() + o.scrollSpeed;
						this.scrollParent.scrollLeft(scrolled);
					} else if (
						event.pageX -
						this.overflowOffset.left <
						o.scrollSensitivity
					) {
						scrolled = this.scrollParent.scrollLeft() - o.scrollSpeed;
						this.scrollParent.scrollLeft(scrolled);
					}

				} else {

					if (
						event.pageY -
						$document.scrollTop() <
						o.scrollSensitivity
					) {
						scrolled = $document.scrollTop() - o.scrollSpeed;
						$document.scrollTop(scrolled);
					} else if (
						$(window).height() -
						(
							event.pageY -
							$document.scrollTop()
						) <
						o.scrollSensitivity
					) {
						scrolled = $document.scrollTop() + o.scrollSpeed;
						$document.scrollTop(scrolled);
					}

					if (
						event.pageX -
						$document.scrollLeft() <
						o.scrollSensitivity
					) {
						scrolled = $document.scrollLeft() - o.scrollSpeed;
						$document.scrollLeft(scrolled);
					} else if (
						$(window).width() -
						(
							event.pageX -
							$document.scrollLeft()
						) <
						o.scrollSensitivity
					) {
						scrolled = $document.scrollLeft() + o.scrollSpeed;
						$document.scrollLeft(scrolled);
					}

				}

				if (scrolled !== false && $.ui.ddmanager && !o.dropBehaviour) {
					$.ui.ddmanager.prepareOffsets(this, event);
				}
			}

			//Regenerate the absolute position used for position checks
			this.positionAbs = this._convertPositionTo("absolute");

			// mjs - find the top offset before rearrangement,
			previousTopOffset = this.placeholder.offset().top;

			//Set the helper position
			if (!this.options.axis || this.options.axis !== "y") {
				this.helper[0].style.left = this.position.left + "px";
			}
			if (!this.options.axis || this.options.axis !== "x") {
				this.helper[0].style.top = (this.position.top) + "px";
			}

			// mjs - check and reset hovering state at each cycle
			this.hovering = this.hovering ? this.hovering : null;
			this.mouseentered = this.mouseentered ? this.mouseentered : false;

			// mjs - let's start caching some variables
			(function() {
				var _parentItem = this.placeholder.parent().parent();
				if (_parentItem && _parentItem.closest(".ui-sortable").length) {
					parentItem = _parentItem;
				}
			}.call(this));

			level = this._getLevel(this.placeholder);
			childLevels = this._getChildLevels(this.helper);
			newList = document.createElement(o.listType);

			//Rearrange
			for (i = this.items.length - 1; i >= 0; i--) {

				//Cache variables and intersection, continue if no intersection
				item = this.items[i];
				itemElement = item.item[0];
				intersection = this._intersectsWithPointer(item);
				if (!intersection) {
					continue;
				}

				// Only put the placeholder inside the current Container, skip all
				// items form other containers. This works because when moving
				// an item from one container to another the
				// currentContainer is switched before the placeholder is moved.
				//
				// Without this moving items in "sub-sortables" can cause the placeholder to jitter
				// beetween the outer and inner container.
				if (item.instance !== this.currentContainer) {
					continue;
				}

				// No action if intersected item is disabled
				// and the element above or below in the direction we're going is also disabled
				if (itemElement.className.indexOf(o.disabledClass) !== -1) {
					// Note: intersection hardcoded direction values from
					// jquery.ui.sortable.js:_intersectsWithPointer
					if (intersection === 2) {
						// Going down
						itemAfter = this.items[i + 1];
						if (itemAfter && itemAfter.item.hasClass(o.disabledClass)) {
							continue;
						}

					} else if (intersection === 1) {
						// Going up
						itemBefore = this.items[i - 1];
						if (itemBefore && itemBefore.item.hasClass(o.disabledClass)) {
							continue;
						}
					}
				}

				method = intersection === 1 ? "next" : "prev";

				// cannot intersect with itself
				// no useless actions that have been done before
				// no action if the item moved is the parent of the item checked
				if (itemElement !== this.currentItem[0] &&
					this.placeholder[method]()[0] !== itemElement &&
					!$.contains(this.placeholder[0], itemElement) &&
					(
						this.options.type === "semi-dynamic" ?
							!$.contains(this.element[0], itemElement) :
							true
					)
				) {

					// mjs - we are intersecting an element:
					// trigger the mouseenter event and store this state
					if (!this.mouseentered) {
						$(itemElement).mouseenter();
						this.mouseentered = true;
					}

					// mjs - if the element has children and they are hidden,
					// show them after a delay (CSS responsible)
					if (o.isTree && $(itemElement).hasClass(o.collapsedClass) && o.expandOnHover) {
						if (!this.hovering) {
							$(itemElement).addClass(o.hoveringClass);
							this.hovering = window.setTimeout(function() {
								$(itemElement)
									.removeClass(o.collapsedClass)
									.addClass(o.expandedClass);

								self.refreshPositions();
								self._trigger("expand", event, self._uiHash());
							}, o.expandOnHover);
						}
					}

					this.direction = intersection === 1 ? "down" : "up";

					// mjs - rearrange the elements and reset timeouts and hovering state
					if (this.options.tolerance === "pointer" || this._intersectsWithSides(item)) {
						$(itemElement).mouseleave();
						this.mouseentered = false;
						$(itemElement).removeClass(o.hoveringClass);
						if (this.hovering) {
							window.clearTimeout(this.hovering);
						}
						this.hovering = null;

						// mjs - do not switch container if
						// it's a root item and 'protectRoot' is true
						// or if it's not a root item but we are trying to make it root
						if (o.protectRoot &&
							!(
								this.currentItem[0].parentNode === this.element[0] &&
								// it's a root item
								itemElement.parentNode !== this.element[0]
								// it's intersecting a non-root item
							)
						) {
							if (this.currentItem[0].parentNode !== this.element[0] &&
								itemElement.parentNode === this.element[0]
							) {

								if ( !$(itemElement).children(o.listType).length) {
									itemElement.appendChild(newList);
									if (o.isTree) {
										$(itemElement)
											.removeClass(o.leafClass)
											.addClass(o.branchClass + " " + o.expandedClass);
									}
								}

								if (this.direction === "down") {
									a = $(itemElement).prev().children(o.listType);
								} else {
									a = $(itemElement).children(o.listType);
								}

								if (a[0] !== undefined) {
									this._rearrange(event, null, a);
								}

							} else {
								this._rearrange(event, item);
							}
						} else if (!o.protectRoot) {
							this._rearrange(event, item);
						}
					} else {
						break;
					}

					// Clear emtpy ul's/ol's
					this._clearEmpty(itemElement);

					this._trigger("change", event, this._uiHash());
					break;
				}
			}

			// mjs - to find the previous sibling in the list,
			// keep backtracking until we hit a valid list item.
			(function() {
				var _previousItem = this.placeholder.prev();
				if (_previousItem.length) {
					previousItem = _previousItem;
				} else {
					previousItem = null;
				}
			}.call(this));

			if (previousItem != null) {
				while (
					previousItem[0].nodeName.toLowerCase() !== "li" ||
					previousItem[0].className.indexOf(o.disabledClass) !== -1 ||
					previousItem[0] === this.currentItem[0] ||
					previousItem[0] === this.helper[0]
				) {
					if (previousItem[0].previousSibling) {
						previousItem = $(previousItem[0].previousSibling);
					} else {
						previousItem = null;
						break;
					}
				}
			}

			// mjs - to find the next sibling in the list,
			// keep stepping forward until we hit a valid list item.
			(function() {
				var _nextItem = this.placeholder.next();
				if (_nextItem.length) {
					nextItem = _nextItem;
				} else {
					nextItem = null;
				}
			}.call(this));

			if (nextItem != null) {
				while (
					nextItem[0].nodeName.toLowerCase() !== "li" ||
					nextItem[0].className.indexOf(o.disabledClass) !== -1 ||
					nextItem[0] === this.currentItem[0] ||
					nextItem[0] === this.helper[0]
				) {
					if (nextItem[0].nextSibling) {
						nextItem = $(nextItem[0].nextSibling);
					} else {
						nextItem = null;
						break;
					}
				}
			}

			this.beyondMaxLevels = 0;

			// mjs - if the item is moved to the left, send it one level up
			// but only if it's at the bottom of the list
			if (parentItem != null &&
				nextItem == null &&
				!(o.protectRoot && parentItem[0].parentNode == this.element[0]) &&
				(
					o.rtl &&
					(
						this.positionAbs.left +
						this.helper.outerWidth() > parentItem.offset().left +
						parentItem.outerWidth()
					) ||
					!o.rtl && (this.positionAbs.left < parentItem.offset().left)
				)
			) {

				parentItem.after(this.placeholder[0]);
				helperIsNotSibling = !parentItem
											.children(o.listItem)
											.children("li:visible:not(.ui-sortable-helper)")
											.length;
				if (o.isTree && helperIsNotSibling) {
					parentItem
						.removeClass(this.options.branchClass + " " + this.options.expandedClass)
						.addClass(this.options.leafClass);
				}
                if(typeof parentItem !== 'undefined')
				    this._clearEmpty(parentItem[0]);
				this._trigger("change", event, this._uiHash());
				// mjs - if the item is below a sibling and is moved to the right,
				// make it a child of that sibling
			} else if (previousItem != null &&
				!previousItem.hasClass(o.disableNestingClass) &&
				(
					previousItem.children(o.listType).length &&
					previousItem.children(o.listType).is(":visible") ||
					!previousItem.children(o.listType).length
				) &&
				!(o.protectRoot && this.currentItem[0].parentNode === this.element[0]) &&
				(
					o.rtl &&
					(
						this.positionAbs.left +
						this.helper.outerWidth() <
						previousItem.offset().left +
						previousItem.outerWidth() -
						o.tabSize
					) ||
					!o.rtl &&
					(this.positionAbs.left > previousItem.offset().left + o.tabSize)
				)
			) {

				this._isAllowed(previousItem, level, level + childLevels + 1);

				if (!previousItem.children(o.listType).length) {
					previousItem[0].appendChild(newList);
					if (o.isTree) {
						previousItem
							.removeClass(o.leafClass)
							.addClass(o.branchClass + " " + o.expandedClass);
					}
				}

				// mjs - if this item is being moved from the top, add it to the top of the list.
				if (previousTopOffset && (previousTopOffset <= previousItem.offset().top)) {
					previousItem.children(o.listType).prepend(this.placeholder);
				} else {
					// mjs - otherwise, add it to the bottom of the list.
					previousItem.children(o.listType)[0].appendChild(this.placeholder[0]);
				}
                if(typeof parentItem !== 'undefined')
				    this._clearEmpty(parentItem[0]);
				this._trigger("change", event, this._uiHash());
			} else {
				this._isAllowed(parentItem, level, level + childLevels);
			}

			//Post events to containers
			this._contactContainers(event);

			//Interconnect with droppables
			if ($.ui.ddmanager) {
				$.ui.ddmanager.drag(this, event);
			}

			//Call callbacks
			this._trigger("sort", event, this._uiHash());

			this.lastPositionAbs = this.positionAbs;
			return false;

		},

		_mouseStop: function(event) {
			// mjs - if the item is in a position not allowed, send it back
			if (this.beyondMaxLevels) {

				this.placeholder.removeClass(this.options.errorClass);

				if (this.domPosition.prev) {
					$(this.domPosition.prev).after(this.placeholder);
				} else {
					$(this.domPosition.parent).prepend(this.placeholder);
				}

				this._trigger("revert", event, this._uiHash());

			}

			// mjs - clear the hovering timeout, just to be sure
			$("." + this.options.hoveringClass)
				.mouseleave()
				.removeClass(this.options.hoveringClass);

			this.mouseentered = false;
			if (this.hovering) {
				window.clearTimeout(this.hovering);
			}
			this.hovering = null;

			this._relocate_event = event;
			this._pid_current = $(this.domPosition.parent).parent().attr("id");
			this._sort_current = this.domPosition.prev ? $(this.domPosition.prev).next().index() : 0;
			$.ui.sortable.prototype._mouseStop.apply(this, arguments); //asybnchronous execution, @see _clear for the relocate event.
		},

		// mjs - this function is slightly modified
		// to make it easier to hover over a collapsed element and have it expand
		_intersectsWithSides: function(item) {

			var half = this.options.isTree ? .8 : .5,
				isOverBottomHalf = isOverAxis(
					this.positionAbs.top + this.offset.click.top,
					item.top + (item.height * half),
					item.height
				),
				isOverTopHalf = isOverAxis(
					this.positionAbs.top + this.offset.click.top,
					item.top - (item.height * half),
					item.height
				),
				isOverRightHalf = isOverAxis(
					this.positionAbs.left + this.offset.click.left,
					item.left + (item.width / 2),
					item.width
				),
				verticalDirection = this._getDragVerticalDirection(),
				horizontalDirection = this._getDragHorizontalDirection();

			if (this.floating && horizontalDirection) {
				return (
					(horizontalDirection === "right" && isOverRightHalf) ||
					(horizontalDirection === "left" && !isOverRightHalf)
				);
			} else {
				return verticalDirection && (
					(verticalDirection === "down" && isOverBottomHalf) ||
					(verticalDirection === "up" && isOverTopHalf)
				);
			}

		},

		_contactContainers: function() {

			if (this.options.protectRoot && this.currentItem[0].parentNode === this.element[0] ) {
				return;
			}

			$.ui.sortable.prototype._contactContainers.apply(this, arguments);

		},

		_clear: function() {
			var i,
				item;

			$.ui.sortable.prototype._clear.apply(this, arguments);

			//relocate event
			if (!(this._pid_current === this._uiHash().item.parent().parent().attr("id") &&
				this._sort_current === this._uiHash().item.index())) {
				this._trigger("relocate", this._relocate_event, this._uiHash());
			}

			// mjs - clean last empty ul/ol
			for (i = this.items.length - 1; i >= 0; i--) {
				item = this.items[i].item[0];
				this._clearEmpty(item);
			}

		},

		serialize: function(options) {

			var o = $.extend({}, this.options, options),
				items = this._getItemsAsjQuery(o && o.connected),
				str = [];

			$(items).each(function() {
				var res = ($(o.item || this).attr(o.attribute || "id") || "")
						.match(o.expression || (/(.+)[-=_](.+)/)),
					pid = ($(o.item || this).parent(o.listType)
						.parent(o.items)
						.attr(o.attribute || "id") || "")
						.match(o.expression || (/(.+)[-=_](.+)/));

				if (res) {
					str.push(
						(
							(o.key || res[1]) +
							"[" +
							(o.key && o.expression ? res[1] : res[2]) + "]"
						) +
						"=" +
						(pid ? (o.key && o.expression ? pid[1] : pid[2]) : o.rootID));
				}
			});

			if (!str.length && o.key) {
				str.push(o.key + "=");
			}

			return str.join("&");

		},

		toHierarchy: function(options) {

			var o = $.extend({}, this.options, options),
				ret = [];

			$(this.element).children(o.items).each(function() {
				var level = _recursiveItems(this);
				ret.push(level);
			});

			return ret;

			function _recursiveItems(item) {
				var id = ($(item).attr(o.attribute || "id") || "").match(o.expression || (/(.+)[-=_](.+)/)),
					currentItem;

				var data = $(item).data();
				if (data.nestedSortableItem) {
					delete data.nestedSortableItem; // Remove the nestedSortableItem object from the data
				}

				if (id) {
					currentItem = {
						"id": id[2]
					};

					currentItem = $.extend({}, currentItem, data); // Combine the two objects

					if ($(item).children(o.listType).children(o.items).length > 0) {
						currentItem.children = [];
						$(item).children(o.listType).children(o.items).each(function() {
							var level = _recursiveItems(this);
							currentItem.children.push(level);
						});
					}
					return currentItem;
				}
			}
		},

		toArray: function(options) {

			var o = $.extend({}, this.options, options),
				sDepth = o.startDepthCount || 0,
				ret = [],
				left = 1;

			if (!o.excludeRoot) {
				ret.push({
					"item_id": o.rootID,
					"parent_id": null,
					"depth": sDepth,
					"left": left,
					"right": ($(o.items, this.element).length + 1) * 2
				});
				left++;
			}

			$(this.element).children(o.items).each(function() {
				left = _recursiveArray(this, sDepth, left);
			});

			ret = ret.sort(function(a, b) { return (a.left - b.left); });

			return ret;

			function _recursiveArray(item, depth, _left) {

				var right = _left + 1,
					id,
					pid,
					parentItem;

				if ($(item).children(o.listType).children(o.items).length > 0) {
					depth++;
					$(item).children(o.listType).children(o.items).each(function() {
						right = _recursiveArray($(this), depth, right);
					});
					depth--;
				}

				id = ($(item).attr(o.attribute || "id")).match(o.expression || (/(.+)[-=_](.+)/));

				if (depth === sDepth) {
					pid = o.rootID;
				} else {
					parentItem = ($(item).parent(o.listType)
											.parent(o.items)
											.attr(o.attribute || "id"))
											.match(o.expression || (/(.+)[-=_](.+)/));
					pid = parentItem[2];
				}

				if (id) {
					        var name = $(item).data("name");
						ret.push({
							"id": id[2],
							"parent_id": pid,
							"depth": depth,
							"left": _left,
							"right": right,
							"name":name
						});
				}

				_left = right + 1;
				return _left;
			}

		},

		_clearEmpty: function (item) {
			function replaceClass(elem, search, replace, swap) {
				if (swap) {
					search = [replace, replace = search][0];
				}

				$(elem).removeClass(search).addClass(replace);
			}

			var o = this.options,
				childrenList = $(item).children(o.listType),
				hasChildren = childrenList.is(':not(:empty)');

			var doNotClear =
				o.doNotClear ||
				hasChildren ||
				o.protectRoot && $(item)[0] === this.element[0];

			if (o.isTree) {
				replaceClass(item, o.branchClass, o.leafClass, doNotClear);

				if (doNotClear && hasChildren) {
					replaceClass(item, o.collapsedClass, o.expandedClass);
				}
			}

			if (!doNotClear) {
				childrenList.remove();
			}
		},

		_getLevel: function(item) {

			var level = 1,
				list;

			if (this.options.listType) {
				list = item.closest(this.options.listType);
				while (list && list.length > 0 && !list.is(".ui-sortable")) {
					level++;
					list = list.parent().closest(this.options.listType);
				}
			}

			return level;
		},

		_getChildLevels: function(parent, depth) {
			var self = this,
				o = this.options,
				result = 0;
			depth = depth || 0;

			$(parent).children(o.listType).children(o.items).each(function(index, child) {
				result = Math.max(self._getChildLevels(child, depth + 1), result);
			});

			return depth ? result + 1 : result;
		},

		_isAllowed: function(parentItem, level, levels) {
			var o = this.options,
				// this takes into account the maxLevels set to the recipient list
				maxLevels = this
					.placeholder
					.closest(".ui-sortable")
					.nestedSortable("option", "maxLevels"),

				// Check if the parent has changed to prevent it, when o.disableParentChange is true
				oldParent = this.currentItem.parent().parent(),
				disabledByParentchange = o.disableParentChange && (
					//From somewhere to somewhere else, except the root
					typeof parentItem !== 'undefined' && !oldParent.is(parentItem) ||
					typeof parentItem === 'undefined' && oldParent.is("li")	//From somewhere to the root
				);
			// mjs - is the root protected?
			// mjs - are we nesting too deep?
			if (
				disabledByParentchange ||
				!o.isAllowed(this.placeholder, parentItem, this.currentItem)
			) {
				this.placeholder.addClass(o.errorClass);
				if (maxLevels < levels && maxLevels !== 0) {
					this.beyondMaxLevels = levels - maxLevels;
				} else {
					this.beyondMaxLevels = 1;
				}
			} else {
				if (maxLevels < levels && maxLevels !== 0) {
					this.placeholder.addClass(o.errorClass);
					this.beyondMaxLevels = levels - maxLevels;
				} else {
					this.placeholder.removeClass(o.errorClass);
					this.beyondMaxLevels = 0;
				}
			}
		}

	}));

	$.mjs.nestedSortable.prototype.options = $.extend(
		{},
		$.ui.sortable.prototype.options,
		$.mjs.nestedSortable.prototype.options
	);
}));


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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS90cmVlL0l0ZW0uanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS90cmVlL1RyZWUuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NsYXNzQ2FsbENoZWNrLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jcmVhdGVDbGFzcy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9lcy9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9pbnRlcm5hbHMvcGF0aC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9zdGFibGUvanNvbi9zdHJpbmdpZnkuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS9kYXRhLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9qcXVlcnktdWkvdWkvaWUuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS9zY3JvbGwtcGFyZW50LmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9qcXVlcnktdWkvdWkvdmVyc2lvbi5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LXVpL3VpL3dpZGdldC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LXVpL3VpL3dpZGdldHMvbW91c2UuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS93aWRnZXRzL3NvcnRhYmxlLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvanF1ZXJ5L3NyYy9qcXVlcnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvbG9kYXNoL2xvZGFzaC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL25lc3RlZFNvcnRhYmxlL2pxdWVyeS5tanMubmVzdGVkU29ydGFibGUuanMiLCJ3ZWJwYWNrOi8vL2V4dGVybmFsIFwiX3hlX2RsbF9jb21tb25cIiJdLCJuYW1lcyI6WyJfbm9kZVRlbXBsYXRlIiwiSXRlbSIsIm9iaiIsIm5vZGVUZW1wbGF0ZSIsImdldEl0ZW1zVGVtcGxhdGUiLCJpdGVtcyIsInJvb3RJZCIsImlzUm9vdCIsInRlbXAiLCJsZW5ndGgiLCJtYWtlSXRlbSIsIml0ZW1Ob2RlIiwicHJvcCIsIml0ZW0iLCJtb3ZlIiwiaWQiLCJPYmplY3QiLCJfcHJldmVudCIsImRlZmF1bHRPcHRpb25zIiwiY29ubmVjdFdpdGgiLCJmb3JjZVBsYWNlaG9sZGVyU2l6ZSIsImhlbHBlciIsImhhbmRsZSIsImxpc3RUeXBlIiwib3BhY2l0eSIsImlzVHJlZSIsImNhbmNlbCIsInRvbGVyYW5jZSIsInRvbGVyYW5jZUVsZW1lbnQiLCJUcmVlIiwiZ2V0VGVtcGxhdGUiLCJmbGFnIiwiJHRhcmdldCIsImNvbmZpZyIsInRyZWVPcHRpb25zIiwicGFyZW50SWQiLCJvcmRlcmluZyIsIml0ZW1JZCIsIm9wdGlvbnMiLCIkIiwiZXh0ZW5kIiwiXyIsImlzT2JqZWN0IiwiaXNGdW5jdGlvbiIsInN0YXJ0IiwiZSIsInVpIiwiJGl0ZW0iLCJpdGVtRGF0YSIsImRhdGEiLCJkcmFnU3RhcnQiLCJzdG9wIiwiJHBhcmVudEl0ZW0iLCJwYXJlbnRzIiwiZXEiLCJtb3ZlUGFyZW50SWQiLCJtb3ZlT3JkZXJpbmciLCJjbG9zZXN0IiwiYWRkQ2xhc3MiLCJpbmRleCIsImRyYWdTdG9wIiwidXBkYXRlIiwicmVsb2NhdGUiLCJyZWNlaXZlIiwicGxhY2Vob2xkZXIiLCJlbGVtZW50IiwiY2xvbmUiLCJzaG93Iiwid3JhcEFsbCIsInBhcmVudCIsImh0bWwiLCJpc0FsbG93ZWQiLCJwbGFjZWhvbGRlclBhcmVudCIsImN1cnJlbnRJdGVtIiwibmVzdGVkU29ydGFibGUiLCJhcHBlbmQiLCIkY29udGFpbmVyIiwiZm4iLCJuZXN0ZWQiLCJ3aW5kb3ciXSwibWFwcGluZ3MiOiI7QUFBQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7O0FBR0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLGtEQUEwQyxnQ0FBZ0M7QUFDMUU7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxnRUFBd0Qsa0JBQWtCO0FBQzFFO0FBQ0EseURBQWlELGNBQWM7QUFDL0Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlEQUF5QyxpQ0FBaUM7QUFDMUUsd0hBQWdILG1CQUFtQixFQUFFO0FBQ3JJO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsbUNBQTJC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QUN0QztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0EsRUFBRTs7QUFFRjtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0EsNEJBQTRCLGtCQUFrQjtBQUM5QyxFQUFFOztBQUVGO0FBQ0EsNEJBQTRCLGlCQUFpQjtBQUM3QyxFQUFFOztBQUVGO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQSxlQUFlLG9CQUFvQjtBQUNuQztBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNILEVBQUU7O0FBRUY7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNIO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0EsR0FBRztBQUNILEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSCxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNILEVBQUU7O0FBRUY7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsU0FBUyxrQ0FBa0M7QUFDM0M7QUFDQTtBQUNBLGNBQWM7QUFDZDs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLGNBQWM7QUFDZDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsR0FBRztBQUNIO0FBQ0EsR0FBRztBQUNIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0EsQ0FBQzs7QUFFRDs7QUFFQSxDQUFDOzs7Ozs7Ozs7Ozs7QUM1dEJEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxN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Q0E7QUFDQSx3Q0FBd0MsUUFBUTtBQUNoRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBOztBQUVBLElBQUk7O0FBRUo7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esa0NBQWtDLFFBQVE7O0FBRTFDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7QUFDQTs7QUFFQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBOztBQUVBLDJDQUEyQyxlQUFlOztBQUUxRDtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTs7QUFFQTtBQUNBLDRDQUE0QyxRQUFRO0FBQ3BEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQSxxQ0FBcUM7QUFDckM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTs7QUFFSjtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7O0FBRUEsRUFBRTs7QUFFRjtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7O0FBRUg7QUFDQTtBQUNBO0FBQ0EscURBQXFEOztBQUVyRDtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esb0NBQW9DLFFBQVE7QUFDNUM7QUFDQSw2QkFBNkIsUUFBUTtBQUNyQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxnQ0FBZ0MsZ0RBQWdEO0FBQ2hGO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSwrQkFBK0IsUUFBUTtBQUN2QztBQUNBOztBQUVBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7O0FBRUE7QUFDQSxtQkFBbUIsaUJBQWlCO0FBQ3BDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVILEVBQUU7O0FBRUY7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSx3REFBd0QseUJBQXlCO0FBQ2pGO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLG9DQUFvQyxRQUFRO0FBQzVDO0FBQ0EsNkJBQTZCLFFBQVE7QUFDckM7QUFDQTtBQUNBO0FBQ0E7QUFDQSwwQ0FBMEMseUJBQXlCO0FBQ25FO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSwrQkFBK0IsUUFBUTtBQUN2QztBQUNBOztBQUVBLGdEQUFnRCxtQkFBbUI7QUFDbkU7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBLGtDQUFrQyxRQUFRO0FBQzFDOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsd0NBQXdDLFFBQVE7QUFDaEQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjtBQUNBOztBQUVBO0FBQ0EsaUJBQWlCO0FBQ2pCO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsdUNBQXVDLFFBQVE7O0FBRS9DO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsSUFBSTs7QUFFSjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLG1DQUFtQyxRQUFRO0FBQzNDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUEsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsVUFBVTtBQUNWO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNILFdBQVc7QUFDWDs7QUFFQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLGdDQUFnQzs7QUFFaEM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVILEVBQUU7O0FBRUY7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSDtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx1Q0FBdUMsUUFBUTtBQUMvQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBLG9DQUFvQztBQUNwQztBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLGVBQWUsNEJBQTRCOztBQUUzQztBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLENBQUM7O0FBRUQsQ0FBQzs7Ozs7Ozs7Ozs7O0FDamhERCw4Rzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLE1BQU0sSUFBMEM7O0FBRWhEO0FBQ0EsRUFBRSxpQ0FBTztBQUNULEdBQUcsd0VBQVE7QUFDWCxHQUFHLGdHQUFvQjtBQUN2QixHQUFHLG9DQUFFLE9BQU87QUFBQTtBQUFBO0FBQUEsb0dBQUU7QUFDZCxFQUFFLE1BQU0sRUFJTjtBQUNGLENBQUM7QUFDRDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEsMkNBQTJDOztBQUUzQztBQUNBO0FBQ0E7QUFDQTtBQUNBLDBCQUEwQixhQUFhLEVBQUU7QUFDekM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxRQUFRO0FBQ1I7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTs7QUFFSjtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxrQ0FBa0MsUUFBUTs7QUFFMUM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxNQUFNO0FBQ047QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLFFBQVE7QUFDUjtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLFNBQVM7QUFDVDtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQSxRQUFRO0FBQ1I7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBLElBQUk7O0FBRUo7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQSxJQUFJOztBQUVKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSw2REFBNkQ7QUFDN0QsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxHQUFHOztBQUVIOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esa0NBQWtDLFFBQVE7QUFDMUM7QUFDQTtBQUNBOztBQUVBLEdBQUc7O0FBRUg7O0FBRUEsc0JBQXNCO0FBQ3RCO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJOztBQUVKO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxHQUFHOztBQUVIOztBQUVBLHNCQUFzQjtBQUN0Qjs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxJQUFJOztBQUVKOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0Esb0NBQW9DO0FBQ3BDOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLDhCQUE4QixxQkFBcUI7O0FBRW5EO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIOztBQUVBLHNCQUFzQjtBQUN0QjtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsSUFBSTs7QUFFSixrQ0FBa0MsMEJBQTBCLEVBQUU7O0FBRTlEOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQOztBQUVBO0FBQ0E7QUFDQTs7QUFFQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLElBQUk7O0FBRUo7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0E7QUFDQSxDQUFDOzs7Ozs7Ozs7Ozs7QUM3NEJELGdDIiwiZmlsZSI6ImFzc2V0cy9jb3JlL2NvbW1vbi9qcy94ZS50cmVlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL3RyZWUvVHJlZS5qc1wiKTtcbiIsIi8qKiBAcHJpdmF0ZSAqL1xubGV0IF9ub2RlVGVtcGxhdGVcblxuY2xhc3MgSXRlbSB7XG4gIC8qKlxuICAgKiBpdGVtIO2FnO2UjOumv+ydhCDrpqzthLTtlZzri6QuXG4gICAqIEBtZW1iZXJvZiBJdGVtXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBvYmpcbiAgICoqL1xuICBnZXRUZW1wbGF0ZSAob2JqKSB7XG4gICAgX25vZGVUZW1wbGF0ZSA9IG9iai5ub2RlVGVtcGxhdGVcblxuICAgIHJldHVybiB0aGlzLmdldEl0ZW1zVGVtcGxhdGUob2JqLml0ZW1zLCBvYmoucm9vdElkLCB0cnVlKVxuICB9XG5cbiAgLyoqXG4gICAqIGl0ZW0g7YWc7ZSM66a/7J2EIOumrO2EtO2VnOuLpC5cbiAgICogQG1lbWJlcm9mIEl0ZW1cbiAgICogQHBhcmFtIHtvYmplY3R9IGl0ZW1zXG4gICAqIEBwYXJhbSB7c3RyaW5nfSByb290SWRcbiAgICogQHBhcmFtIHtib29sZWFufSBpc1Jvb3RcbiAgICogQHJldHVybiB7c3RyaW5nfVxuICAgKiovXG4gIGdldEl0ZW1zVGVtcGxhdGUgKGl0ZW1zLCByb290SWQsIGlzUm9vdCkge1xuICAgIGxldCB0ZW1wID0gJydcblxuICAgIGlmIChpdGVtcyAmJiBpdGVtcy5sZW5ndGggIT0gMCB8fCBpc1Jvb3QpIHtcbiAgICAgIGlmIChpc1Jvb3QgJiYgcm9vdElkKSB7XG4gICAgICAgIHRlbXAgKz0gJzx1bCBjbGFzcz1cIml0ZW0tY29udGFpbmVyXCIgZGF0YS1wYXJlbnQ9XCInICsgcm9vdElkICsgJ1wiPidcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHRlbXAgKz0gJzx1bCBjbGFzcz1cIml0ZW0tY29udGFpbmVyXCI+J1xuICAgICAgfVxuICAgIH1cblxuICAgIHRlbXAgKz0gdGhpcy5tYWtlSXRlbShpdGVtcywgX25vZGVUZW1wbGF0ZSlcblxuICAgIGlmIChpdGVtcyAmJiBpdGVtcy5sZW5ndGggIT0gMCB8fCBpc1Jvb3QpIHtcbiAgICAgIHRlbXAgKz0gJzwvdWw+J1xuICAgIH1cblxuICAgIHJldHVybiB0ZW1wXG4gIH1cblxuICAvKipcbiAgICAgKiBpdGVtIO2FnO2UjOumv+ydhCDrp4zrk6Dri6QuXG4gICAgICogQG1lbWJlcm9mIEl0ZW1cbiAgICAgKiBAcGFyYW0ge29iamVjdH0gb2JqXG4gICAgICogPHByZT5cbiAgICAgKiAgIGl0ZW1zXG4gICAgICogICBub2RlVGVtcGxhdGVcbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcGFyYW0ge2Z1bmN0aW9ufSBub2RlVGVtcGxhdGVcbiAgICAgKiBAcmV0dXJuIHtzdHJpbmd9XG4gICAgICoqL1xuICBtYWtlSXRlbSAoaXRlbXMsIG5vZGVUZW1wbGF0ZSkge1xuICAgIGxldCBpdGVtTm9kZSA9ICcnXG5cbiAgICBmb3IgKGNvbnN0IHByb3AgaW4gaXRlbXMpIHtcbiAgICAgIGNvbnN0IGl0ZW0gPSBpdGVtc1twcm9wXVxuICAgICAgY29uc3QgbW92ZSA9IChpdGVtLml0ZW1zICYmIGl0ZW0uaXRlbXMubGVuZ3RoKSA/ICdtb3ZlJyA6ICcnXG5cbiAgICAgIGl0ZW1Ob2RlICs9IFwiPGxpIGNsYXNzPSdpdGVtIFwiICsgbW92ZSArIFwiJyBpZD0naXRlbV9cIiArIGl0ZW0uaWQgKyBcIic+XCJcbiAgICAgIGl0ZW1Ob2RlICs9IFwiPGRpdiBjbGFzcz0naXRlbS1jb250ZW50JyBkYXRhLWl0ZW09J1wiICsgSlNPTi5zdHJpbmdpZnkoaXRlbSkgKyBcIic+XCJcbiAgICAgIGl0ZW1Ob2RlICs9IFwiPGJ1dHRvbiBjbGFzcz0nYnRuIGhhbmRsZXInPjxpIGNsYXNzPSd4aS1kcmFnLXZlcnRpY2FsJz48L2k+PC9idXR0b24+XCJcbiAgICAgIGl0ZW1Ob2RlICs9IG5vZGVUZW1wbGF0ZShpdGVtKVxuICAgICAgaXRlbU5vZGUgKz0gJzwvZGl2PidcblxuICAgICAgaWYgKGl0ZW0uaXRlbXMgJiYgaXRlbS5pdGVtcyBpbnN0YW5jZW9mIE9iamVjdCkge1xuICAgICAgICBpdGVtTm9kZSArPSB0aGlzLmdldEl0ZW1zVGVtcGxhdGUoaXRlbS5pdGVtcylcbiAgICAgIH1cblxuICAgICAgaXRlbU5vZGUgKz0gJzwvbGk+J1xuICAgIH1cblxuICAgIHJldHVybiBpdGVtTm9kZVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IG5ldyBJdGVtKClcbiIsImltcG9ydCAnbmVzdGVkU29ydGFibGUnXG5pbXBvcnQgJCBmcm9tICdqcXVlcnknXG5pbXBvcnQgXyBmcm9tICdsb2Rhc2gnXG5pbXBvcnQgSXRlbSBmcm9tICcuL0l0ZW0nXG5cbmxldCBfcHJldmVudCA9IGZhbHNlXG5cbmNvbnN0IGRlZmF1bHRPcHRpb25zID0ge1xuICBjb25uZWN0V2l0aDogJy5pdGVtLWNvbnRhaW5lcicsXG4gIGZvcmNlUGxhY2Vob2xkZXJTaXplOiB0cnVlLFxuICBoZWxwZXI6ICdjbG9uZScsXG4gIGhhbmRsZTogJy5pdGVtLWNvbnRlbnQgLmhhbmRsZXInLFxuICBsaXN0VHlwZTogJ3VsJyxcbiAgaXRlbXM6ICdsaScsXG4gIG9wYWNpdHk6IDAuNixcbiAgaXNUcmVlOiB0cnVlLFxuICBjYW5jZWw6ICcnLFxuICB0b2xlcmFuY2U6ICdwb2ludGVyJyxcbiAgdG9sZXJhbmNlRWxlbWVudDogJz4gZGl2J1xufVxuXG5jbGFzcyBUcmVlIHtcbiAgLyoqXG4gICAqXG4gICAqIEBtZW1iZXJvZiBUcmVlXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBvYmpcbiAgICogPHByZT5cbiAgICogICByb290SWQ6IHRyZWUgcm9vdCBpZFxuICAgKiAgIG5vZGVUZW1wbGF0ZTogaXRlbeyViOyXkCDsg53shLHtlaAgaHRtbFxuICAgKiAgIGl0ZW1zOiBUcmVlIOq1rOyEsSDrjbDsnbTthLBcbiAgICogPC9wcmU+XG4gICAqIEByZXR1cm4ge3N0cmluZ30gaXRlbXMgaHRtbFxuICAgKiovXG4gIGdldEl0ZW1zVGVtcGxhdGUgKG9iaikge1xuICAgIHJldHVybiBJdGVtLmdldFRlbXBsYXRlKG9iailcbiAgfVxuXG4gIC8qKlxuICAgICAqIEBtZW1iZXJvZiBUcmVlXG4gICAgICogQHBhcmFtIHtib29sZWFufSBmbGFnXG4gICAgICogQGRlc2NyaXB0aW9uIFRyZWUg7J2064+ZIOuwqeyngFxuICAgICAqICovXG4gIHNldFByZXZlbnQgKGZsYWcpIHtcbiAgICBfcHJldmVudCA9IGZsYWdcbiAgfVxuXG4gIC8qKlxuICAgKiBAbWVtYmVyb2YgVHJlZVxuICAgKiBAcGFyYW0ge29iamVjdH0gJHRhcmdldCB0cmVl6rWs7ISx7J2YIHdyYXBwZXJcbiAgICogQHBhcmFtIHtvYmplY3R9IGNvbmZpZ1xuICAgKiA8cHJlPlxuICAgKiAgIOy2lOqwgOyYteyFmFxuICAgKiAgIGRyYWdTdGFydCA6IGRyYWcg7Iuc7J6R7IucIO2YuOy2nCB0cmVlT3B0aW9u7J2YIHN0YXJ066W8IOyYpOuyhOudvOydtOuTnCDqsIDriqXtlaguXG4gICAqICAgZHJhZ1N0b3AgOiBkcm9w7IucIO2YuOy2nCB0cmVlT3B0aW9u7J2YIGVuZOulvCDsmKTrsoTrnbzsnbTrk5wg6rCA64ql7ZWoLlxuICAgKiAgIHVwZGF0ZSA6IGRyYWfrpbwg7Ya17ZWcIHRyZWXsnZgg67OA64+Z7IKs7ZWt7J20IOyeiOydhCDqsr3smrAg7Zi47LacIGl0ZW0sIHBhcmVudCwgdGFyZ2V0LCBvcmRlcmluZ+uTseydmCDsoJXrs7Trpbwg7J247J6Q66GcIOuztOuCtOykgOuLpFxuICAgKiA8L3ByZT5cbiAgICogQHBhcmFtIHtvYmplY3R9IHRyZWVPcHRpb25zIG5lc3RlZFNvcnRhYmxlIFRyZWUgT3B0aW9uc1xuICAgKiBAZGVzY3JpcHRpb24g7Yq466asIOq1rOyEsVxuICAgKiovXG4gIHJ1biAoJHRhcmdldCwgY29uZmlnLCB0cmVlT3B0aW9ucykge1xuICAgIGxldCBwYXJlbnRJZFxuICAgIGxldCBvcmRlcmluZ1xuICAgIGxldCBpdGVtSWRcbiAgICBsZXQgb3B0aW9ucyA9ICQuZXh0ZW5kKHt9LCBkZWZhdWx0T3B0aW9ucylcblxuICAgIC8vIGN1c3RvbSBvcHRpb24g7LaU6rCAXG4gICAgaWYgKF8uaXNPYmplY3QodHJlZU9wdGlvbnMpKSB7XG4gICAgICAkLmV4dGVuZChvcHRpb25zLCB0cmVlT3B0aW9ucylcbiAgICB9XG5cbiAgICAvLyBzdGFydCBmdW5jdGlvbiDstpTqsIBcbiAgICBpZiAoXy5pc09iamVjdCh0cmVlT3B0aW9ucykgJiYgXy5pc0Z1bmN0aW9uKHRyZWVPcHRpb25zLnN0YXJ0KSkge1xuICAgICAgb3B0aW9ucy5zdGFydCA9IHRyZWVPcHRpb25zLnN0YXJ0XG4gICAgfSBlbHNlIHtcbiAgICAgIG9wdGlvbnMuc3RhcnQgPSBmdW5jdGlvbiAoZSwgdWkpIHtcbiAgICAgICAgY29uc3QgJGl0ZW0gPSAkKHVpLml0ZW0pXG4gICAgICAgIGNvbnN0IGl0ZW1EYXRhID0gJGl0ZW0uZmluZCgnPiAuaXRlbS1jb250ZW50JykuZGF0YSgnaXRlbScpXG5cbiAgICAgICAgcGFyZW50SWQgPSBpdGVtRGF0YS5wYXJlbnRJZFxuICAgICAgICBvcmRlcmluZyA9IGl0ZW1EYXRhLm9yZGVyaW5nXG4gICAgICAgIGl0ZW1JZCA9IGl0ZW1EYXRhLmlkXG5cbiAgICAgICAgaWYgKF8uaXNPYmplY3QoY29uZmlnKSAmJiBfLmlzRnVuY3Rpb24oY29uZmlnLmRyYWdTdGFydCkpIHtcbiAgICAgICAgICBjb25maWcuZHJhZ1N0YXJ0KClcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH1cblxuICAgIC8vIHN0b3AgZnVuY3Rpb24g7LaU6rCAXG4gICAgaWYgKF8uaXNPYmplY3QodHJlZU9wdGlvbnMpICYmIF8uaXNGdW5jdGlvbih0cmVlT3B0aW9ucy5zdG9wKSkge1xuICAgICAgb3B0aW9ucy5zdG9wID0gdHJlZU9wdGlvbnMuc3RvcFxuICAgIH0gZWxzZSB7XG4gICAgICBvcHRpb25zLnN0b3AgPSBmdW5jdGlvbiAoZSwgdWkpIHtcbiAgICAgICAgY29uc3QgJGl0ZW0gPSAkKHVpLml0ZW0pXG4gICAgICAgIGNvbnN0ICRwYXJlbnRJdGVtID0gJGl0ZW0ucGFyZW50cygnbGkuaXRlbScpLmVxKDApXG4gICAgICAgIGNvbnN0IG1vdmVQYXJlbnRJZCA9ICgkcGFyZW50SXRlbS5sZW5ndGggPiAwKSA/ICRwYXJlbnRJdGVtLmZpbmQoJz4gLml0ZW0tY29udGVudCcpLmRhdGEoJ2l0ZW0nKS5pZCA6ICRpdGVtLnBhcmVudHMoJy5pdGVtLWNvbnRhaW5lcicpLmRhdGEoJ3BhcmVudCcpXG4gICAgICAgIGNvbnN0IG1vdmVPcmRlcmluZyA9ICRpdGVtLmNsb3Nlc3QoJ3VsJykuYWRkQ2xhc3MoJ2l0ZW0tY29udGFpbmVyJykuZmluZCgnPiBsaS5pdGVtJykuaW5kZXgoJGl0ZW0pXG5cbiAgICAgICAgaWYgKF8uaXNPYmplY3QoY29uZmlnKSAmJiBfLmlzRnVuY3Rpb24oY29uZmlnLmRyYWdTdG9wKSkge1xuICAgICAgICAgIGNvbmZpZy5kcmFnU3RvcCgpXG4gICAgICAgIH1cblxuICAgICAgICBpZiAoKHBhcmVudElkICE9PSBtb3ZlUGFyZW50SWQgJiYgIV9wcmV2ZW50KSB8fCAob3JkZXJpbmcgIT09IG1vdmVPcmRlcmluZyAmJiAhX3ByZXZlbnQpKSB7XG4gICAgICAgICAgaWYgKF8uaXNPYmplY3QoY29uZmlnKSAmJiBfLmlzRnVuY3Rpb24oY29uZmlnLnVwZGF0ZSkpIHtcbiAgICAgICAgICAgIGNvbmZpZy51cGRhdGUoe1xuICAgICAgICAgICAgICBpdGVtOiAkaXRlbSxcbiAgICAgICAgICAgICAgaXRlbUlkOiBpdGVtSWQsXG4gICAgICAgICAgICAgIHBhcmVudElkOiBtb3ZlUGFyZW50SWQsXG4gICAgICAgICAgICAgIG9yZGVyaW5nOiBtb3ZlT3JkZXJpbmdcbiAgICAgICAgICAgIH0pXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9XG4gICAgfVxuXG4gICAgLy8gcmVsb2NhdGUgZnVuY3Rpb24g7LaU6rCAIGRlZmF1bHQg7IKs7Jqp7JWI7ZWoLlxuICAgIGlmIChfLmlzT2JqZWN0KHRyZWVPcHRpb25zKSAmJiBfLmlzRnVuY3Rpb24odHJlZU9wdGlvbnMucmVsb2NhdGUpKSB7XG4gICAgICBvcHRpb25zLnJlbG9jYXRlID0gdHJlZU9wdGlvbnMucmVsb2NhdGVcbiAgICB9XG5cbiAgICAvLyByZWNlaXZlIGZ1bmN0aW9uIOy2lOqwgCBkZWZhdWx0IOyCrOyaqeyViO2VqC5cbiAgICBpZiAoXy5pc09iamVjdCh0cmVlT3B0aW9ucykgJiYgXy5pc0Z1bmN0aW9uKHRyZWVPcHRpb25zLnJlY2VpdmUpKSB7XG4gICAgICBvcHRpb25zLnJlY2VpdmUgPSB0cmVlT3B0aW9ucy5yZWNlaXZlXG4gICAgfVxuXG4gICAgLy8gcGxhY2Vob2xkZXIg7LaU6rCAXG4gICAgaWYgKF8uaXNPYmplY3QodHJlZU9wdGlvbnMpICYmIHRyZWVPcHRpb25zLnBsYWNlaG9sZGVyKSB7XG4gICAgICBvcHRpb25zLnBsYWNlaG9sZGVyID0gdHJlZU9wdGlvbnMucGxhY2Vob2xkZXJcbiAgICB9IGVsc2Uge1xuICAgICAgb3B0aW9ucy5wbGFjZWhvbGRlciA9IHtcbiAgICAgICAgZWxlbWVudDogZnVuY3Rpb24gKCR0YXJnZXQpIHtcbiAgICAgICAgICByZXR1cm4gJHRhcmdldC5jbG9uZSgpLmFkZENsYXNzKCdjb3B5Jykuc2hvdygpLndyYXBBbGwoJzxkaXYgLz4nKS5wYXJlbnQoKS5odG1sKClcbiAgICAgICAgfSxcbiAgICAgICAgdXBkYXRlOiBmdW5jdGlvbiAoKSB7fVxuICAgICAgfVxuICAgIH1cblxuICAgIGlmIChfLmlzT2JqZWN0KHRyZWVPcHRpb25zKSAmJiBfLmlzRnVuY3Rpb24odHJlZU9wdGlvbnMuaXNBbGxvd2VkKSkge1xuICAgICAgb3B0aW9ucy5pc0FsbG93ZWQgPSB0cmVlT3B0aW9ucy5pc0FsbG93ZWRcbiAgICB9IGVsc2Uge1xuICAgICAgb3B0aW9ucy5pc0FsbG93ZWQgPSBmdW5jdGlvbiAocGxhY2Vob2xkZXIsIHBsYWNlaG9sZGVyUGFyZW50LCBjdXJyZW50SXRlbSkge1xuICAgICAgICByZXR1cm4gIV9wcmV2ZW50XG4gICAgICB9XG4gICAgfVxuXG4gICAgaWYgKCR0YXJnZXQuZmluZCgnLml0ZW0tY29udGFpbmVyJykubGVuZ3RoID4gMCkge1xuICAgICAgJHRhcmdldC5maW5kKCcuaXRlbS1jb250YWluZXInKS5uZXN0ZWRTb3J0YWJsZShvcHRpb25zKVxuICAgIH0gZWxzZSB7XG4gICAgICAkdGFyZ2V0LmFwcGVuZCgnPHVsIGNsYXNzPVwiaXRlbS1jb250YWluZXJcIj48L3VsPicpXG4gICAgICAkdGFyZ2V0LmZpbmQoJy5pdGVtLWNvbnRhaW5lcicpLm5lc3RlZFNvcnRhYmxlKG9wdGlvbnMpXG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEBtZW1iZXJvZiBUcmVlXG4gICAqIEBwYXJhbSB7b2JqZWN0fSAkY29udGFpbmVyXG4gICAqIEBvYXJhbSB7b2JqZWN0fSBvYmpcbiAgICogPHByZT5cbiAgICogICBub2RlVGVtcGxhdGU6IGl0ZW3slYjsl5Ag7IOd7ISx7ZWgIGh0bWxcbiAgICogICBpdGVtXG4gICAqICAgbmVzdGVkIC0g7ZWY7JyEIGRlcHRoIOuFuOuTnOydvCDqsr3smrAgdWwuaXRlbS1jb250YWluZXLrpbwg7Y+s7ZWo7ZWY7JesIGFwcGVuZC4g7JWE64uQIOqyveyasCBsaS5pdGVt66eMIGFwcGVuZFxuICAgKiA8L3ByZT5cbiAgICogQHBhcmFtIHtmdW5jdGlvbn0gZm4gY2FsbGJhY2tcbiAgICoqL1xuICBhZGQgKCRjb250YWluZXIsIG9iaiwgZm4pIHtcbiAgICBpZiAob2JqLm5lc3RlZCkge1xuICAgICAgJGNvbnRhaW5lci5hcHBlbmQoSXRlbS5nZXRUZW1wbGF0ZShvYmopKVxuICAgIH0gZWxzZSB7XG4gICAgICAkY29udGFpbmVyLmFwcGVuZChJdGVtLm1ha2VJdGVtKG9iai5pdGVtcywgb2JqLm5vZGVUZW1wbGF0ZSkpXG4gICAgfVxuXG4gICAgaWYgKGZuICYmIHR5cGVvZiBmbiA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgZm4oKVxuICAgIH1cbiAgfVxufVxuXG53aW5kb3cuVHJlZSA9IG5ldyBUcmVlKClcblxuZXhwb3J0IGRlZmF1bHQgd2luZG93LlRyZWVcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0KTsiLCJtb2R1bGUuZXhwb3J0cyA9IHJlcXVpcmUoXCJjb3JlLWpzLXB1cmUvc3RhYmxlL2pzb24vc3RyaW5naWZ5XCIpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgzKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTApOyIsInZhciBjb3JlID0gcmVxdWlyZSgnLi4vLi4vaW50ZXJuYWxzL3BhdGgnKTtcbnZhciAkSlNPTiA9IGNvcmUuSlNPTiB8fCAoY29yZS5KU09OID0geyBzdHJpbmdpZnk6IEpTT04uc3RyaW5naWZ5IH0pO1xuXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uIHN0cmluZ2lmeShpdCkgeyAvLyBlc2xpbnQtZGlzYWJsZS1saW5lIG5vLXVudXNlZC12YXJzXG4gIHJldHVybiAkSlNPTi5zdHJpbmdpZnkuYXBwbHkoJEpTT04sIGFyZ3VtZW50cyk7XG59O1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE1KTsiLCJtb2R1bGUuZXhwb3J0cyA9IHJlcXVpcmUoJy4uLy4uL2VzL2pzb24vc3RyaW5naWZ5Jyk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSA6ZGF0YSAxLjEyLjFcbiAqIGh0dHA6Ly9qcXVlcnl1aS5jb21cbiAqXG4gKiBDb3B5cmlnaHQgalF1ZXJ5IEZvdW5kYXRpb24gYW5kIG90aGVyIGNvbnRyaWJ1dG9yc1xuICogUmVsZWFzZWQgdW5kZXIgdGhlIE1JVCBsaWNlbnNlLlxuICogaHR0cDovL2pxdWVyeS5vcmcvbGljZW5zZVxuICovXG5cbi8vPj5sYWJlbDogOmRhdGEgU2VsZWN0b3Jcbi8vPj5ncm91cDogQ29yZVxuLy8+PmRlc2NyaXB0aW9uOiBTZWxlY3RzIGVsZW1lbnRzIHdoaWNoIGhhdmUgZGF0YSBzdG9yZWQgdW5kZXIgdGhlIHNwZWNpZmllZCBrZXkuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20vZGF0YS1zZWxlY3Rvci9cblxuKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFsgXCJqcXVlcnlcIiwgXCIuL3ZlcnNpb25cIiBdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSAoIGZ1bmN0aW9uKCAkICkge1xucmV0dXJuICQuZXh0ZW5kKCAkLmV4cHJbIFwiOlwiIF0sIHtcblx0ZGF0YTogJC5leHByLmNyZWF0ZVBzZXVkbyA/XG5cdFx0JC5leHByLmNyZWF0ZVBzZXVkbyggZnVuY3Rpb24oIGRhdGFOYW1lICkge1xuXHRcdFx0cmV0dXJuIGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0XHRyZXR1cm4gISEkLmRhdGEoIGVsZW0sIGRhdGFOYW1lICk7XG5cdFx0XHR9O1xuXHRcdH0gKSA6XG5cblx0XHQvLyBTdXBwb3J0OiBqUXVlcnkgPDEuOFxuXHRcdGZ1bmN0aW9uKCBlbGVtLCBpLCBtYXRjaCApIHtcblx0XHRcdHJldHVybiAhISQuZGF0YSggZWxlbSwgbWF0Y2hbIDMgXSApO1xuXHRcdH1cbn0gKTtcbn0gKSApO1xuIiwiKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFsgXCJqcXVlcnlcIiwgXCIuL3ZlcnNpb25cIiBdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSAoIGZ1bmN0aW9uKCAkICkge1xuXG4vLyBUaGlzIGZpbGUgaXMgZGVwcmVjYXRlZFxucmV0dXJuICQudWkuaWUgPSAhIS9tc2llIFtcXHcuXSsvLmV4ZWMoIG5hdmlnYXRvci51c2VyQWdlbnQudG9Mb3dlckNhc2UoKSApO1xufSApICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBTY3JvbGwgUGFyZW50IDEuMTIuMVxuICogaHR0cDovL2pxdWVyeXVpLmNvbVxuICpcbiAqIENvcHlyaWdodCBqUXVlcnkgRm91bmRhdGlvbiBhbmQgb3RoZXIgY29udHJpYnV0b3JzXG4gKiBSZWxlYXNlZCB1bmRlciB0aGUgTUlUIGxpY2Vuc2UuXG4gKiBodHRwOi8vanF1ZXJ5Lm9yZy9saWNlbnNlXG4gKi9cblxuLy8+PmxhYmVsOiBzY3JvbGxQYXJlbnRcbi8vPj5ncm91cDogQ29yZVxuLy8+PmRlc2NyaXB0aW9uOiBHZXQgdGhlIGNsb3Nlc3QgYW5jZXN0b3IgZWxlbWVudCB0aGF0IGlzIHNjcm9sbGFibGUuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20vc2Nyb2xsUGFyZW50L1xuXG4oIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggWyBcImpxdWVyeVwiLCBcIi4vdmVyc2lvblwiIF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59ICggZnVuY3Rpb24oICQgKSB7XG5cbnJldHVybiAkLmZuLnNjcm9sbFBhcmVudCA9IGZ1bmN0aW9uKCBpbmNsdWRlSGlkZGVuICkge1xuXHR2YXIgcG9zaXRpb24gPSB0aGlzLmNzcyggXCJwb3NpdGlvblwiICksXG5cdFx0ZXhjbHVkZVN0YXRpY1BhcmVudCA9IHBvc2l0aW9uID09PSBcImFic29sdXRlXCIsXG5cdFx0b3ZlcmZsb3dSZWdleCA9IGluY2x1ZGVIaWRkZW4gPyAvKGF1dG98c2Nyb2xsfGhpZGRlbikvIDogLyhhdXRvfHNjcm9sbCkvLFxuXHRcdHNjcm9sbFBhcmVudCA9IHRoaXMucGFyZW50cygpLmZpbHRlciggZnVuY3Rpb24oKSB7XG5cdFx0XHR2YXIgcGFyZW50ID0gJCggdGhpcyApO1xuXHRcdFx0aWYgKCBleGNsdWRlU3RhdGljUGFyZW50ICYmIHBhcmVudC5jc3MoIFwicG9zaXRpb25cIiApID09PSBcInN0YXRpY1wiICkge1xuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHR9XG5cdFx0XHRyZXR1cm4gb3ZlcmZsb3dSZWdleC50ZXN0KCBwYXJlbnQuY3NzKCBcIm92ZXJmbG93XCIgKSArIHBhcmVudC5jc3MoIFwib3ZlcmZsb3cteVwiICkgK1xuXHRcdFx0XHRwYXJlbnQuY3NzKCBcIm92ZXJmbG93LXhcIiApICk7XG5cdFx0fSApLmVxKCAwICk7XG5cblx0cmV0dXJuIHBvc2l0aW9uID09PSBcImZpeGVkXCIgfHwgIXNjcm9sbFBhcmVudC5sZW5ndGggP1xuXHRcdCQoIHRoaXNbIDAgXS5vd25lckRvY3VtZW50IHx8IGRvY3VtZW50ICkgOlxuXHRcdHNjcm9sbFBhcmVudDtcbn07XG5cbn0gKSApO1xuIiwiKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFsgXCJqcXVlcnlcIiBdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSAoIGZ1bmN0aW9uKCAkICkge1xuXG4kLnVpID0gJC51aSB8fCB7fTtcblxucmV0dXJuICQudWkudmVyc2lvbiA9IFwiMS4xMi4xXCI7XG5cbn0gKSApO1xuIiwiLyohXG4gKiBqUXVlcnkgVUkgV2lkZ2V0IDEuMTIuMVxuICogaHR0cDovL2pxdWVyeXVpLmNvbVxuICpcbiAqIENvcHlyaWdodCBqUXVlcnkgRm91bmRhdGlvbiBhbmQgb3RoZXIgY29udHJpYnV0b3JzXG4gKiBSZWxlYXNlZCB1bmRlciB0aGUgTUlUIGxpY2Vuc2UuXG4gKiBodHRwOi8vanF1ZXJ5Lm9yZy9saWNlbnNlXG4gKi9cblxuLy8+PmxhYmVsOiBXaWRnZXRcbi8vPj5ncm91cDogQ29yZVxuLy8+PmRlc2NyaXB0aW9uOiBQcm92aWRlcyBhIGZhY3RvcnkgZm9yIGNyZWF0aW5nIHN0YXRlZnVsIHdpZGdldHMgd2l0aCBhIGNvbW1vbiBBUEkuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20valF1ZXJ5LndpZGdldC9cbi8vPj5kZW1vczogaHR0cDovL2pxdWVyeXVpLmNvbS93aWRnZXQvXG5cbiggZnVuY3Rpb24oIGZhY3RvcnkgKSB7XG5cdGlmICggdHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQgKSB7XG5cblx0XHQvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG5cdFx0ZGVmaW5lKCBbIFwianF1ZXJ5XCIsIFwiLi92ZXJzaW9uXCIgXSwgZmFjdG9yeSApO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gQnJvd3NlciBnbG9iYWxzXG5cdFx0ZmFjdG9yeSggalF1ZXJ5ICk7XG5cdH1cbn0oIGZ1bmN0aW9uKCAkICkge1xuXG52YXIgd2lkZ2V0VXVpZCA9IDA7XG52YXIgd2lkZ2V0U2xpY2UgPSBBcnJheS5wcm90b3R5cGUuc2xpY2U7XG5cbiQuY2xlYW5EYXRhID0gKCBmdW5jdGlvbiggb3JpZyApIHtcblx0cmV0dXJuIGZ1bmN0aW9uKCBlbGVtcyApIHtcblx0XHR2YXIgZXZlbnRzLCBlbGVtLCBpO1xuXHRcdGZvciAoIGkgPSAwOyAoIGVsZW0gPSBlbGVtc1sgaSBdICkgIT0gbnVsbDsgaSsrICkge1xuXHRcdFx0dHJ5IHtcblxuXHRcdFx0XHQvLyBPbmx5IHRyaWdnZXIgcmVtb3ZlIHdoZW4gbmVjZXNzYXJ5IHRvIHNhdmUgdGltZVxuXHRcdFx0XHRldmVudHMgPSAkLl9kYXRhKCBlbGVtLCBcImV2ZW50c1wiICk7XG5cdFx0XHRcdGlmICggZXZlbnRzICYmIGV2ZW50cy5yZW1vdmUgKSB7XG5cdFx0XHRcdFx0JCggZWxlbSApLnRyaWdnZXJIYW5kbGVyKCBcInJlbW92ZVwiICk7XG5cdFx0XHRcdH1cblxuXHRcdFx0Ly8gSHR0cDovL2J1Z3MuanF1ZXJ5LmNvbS90aWNrZXQvODIzNVxuXHRcdFx0fSBjYXRjaCAoIGUgKSB7fVxuXHRcdH1cblx0XHRvcmlnKCBlbGVtcyApO1xuXHR9O1xufSApKCAkLmNsZWFuRGF0YSApO1xuXG4kLndpZGdldCA9IGZ1bmN0aW9uKCBuYW1lLCBiYXNlLCBwcm90b3R5cGUgKSB7XG5cdHZhciBleGlzdGluZ0NvbnN0cnVjdG9yLCBjb25zdHJ1Y3RvciwgYmFzZVByb3RvdHlwZTtcblxuXHQvLyBQcm94aWVkUHJvdG90eXBlIGFsbG93cyB0aGUgcHJvdmlkZWQgcHJvdG90eXBlIHRvIHJlbWFpbiB1bm1vZGlmaWVkXG5cdC8vIHNvIHRoYXQgaXQgY2FuIGJlIHVzZWQgYXMgYSBtaXhpbiBmb3IgbXVsdGlwbGUgd2lkZ2V0cyAoIzg4NzYpXG5cdHZhciBwcm94aWVkUHJvdG90eXBlID0ge307XG5cblx0dmFyIG5hbWVzcGFjZSA9IG5hbWUuc3BsaXQoIFwiLlwiIClbIDAgXTtcblx0bmFtZSA9IG5hbWUuc3BsaXQoIFwiLlwiIClbIDEgXTtcblx0dmFyIGZ1bGxOYW1lID0gbmFtZXNwYWNlICsgXCItXCIgKyBuYW1lO1xuXG5cdGlmICggIXByb3RvdHlwZSApIHtcblx0XHRwcm90b3R5cGUgPSBiYXNlO1xuXHRcdGJhc2UgPSAkLldpZGdldDtcblx0fVxuXG5cdGlmICggJC5pc0FycmF5KCBwcm90b3R5cGUgKSApIHtcblx0XHRwcm90b3R5cGUgPSAkLmV4dGVuZC5hcHBseSggbnVsbCwgWyB7fSBdLmNvbmNhdCggcHJvdG90eXBlICkgKTtcblx0fVxuXG5cdC8vIENyZWF0ZSBzZWxlY3RvciBmb3IgcGx1Z2luXG5cdCQuZXhwclsgXCI6XCIgXVsgZnVsbE5hbWUudG9Mb3dlckNhc2UoKSBdID0gZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0cmV0dXJuICEhJC5kYXRhKCBlbGVtLCBmdWxsTmFtZSApO1xuXHR9O1xuXG5cdCRbIG5hbWVzcGFjZSBdID0gJFsgbmFtZXNwYWNlIF0gfHwge307XG5cdGV4aXN0aW5nQ29uc3RydWN0b3IgPSAkWyBuYW1lc3BhY2UgXVsgbmFtZSBdO1xuXHRjb25zdHJ1Y3RvciA9ICRbIG5hbWVzcGFjZSBdWyBuYW1lIF0gPSBmdW5jdGlvbiggb3B0aW9ucywgZWxlbWVudCApIHtcblxuXHRcdC8vIEFsbG93IGluc3RhbnRpYXRpb24gd2l0aG91dCBcIm5ld1wiIGtleXdvcmRcblx0XHRpZiAoICF0aGlzLl9jcmVhdGVXaWRnZXQgKSB7XG5cdFx0XHRyZXR1cm4gbmV3IGNvbnN0cnVjdG9yKCBvcHRpb25zLCBlbGVtZW50ICk7XG5cdFx0fVxuXG5cdFx0Ly8gQWxsb3cgaW5zdGFudGlhdGlvbiB3aXRob3V0IGluaXRpYWxpemluZyBmb3Igc2ltcGxlIGluaGVyaXRhbmNlXG5cdFx0Ly8gbXVzdCB1c2UgXCJuZXdcIiBrZXl3b3JkICh0aGUgY29kZSBhYm92ZSBhbHdheXMgcGFzc2VzIGFyZ3MpXG5cdFx0aWYgKCBhcmd1bWVudHMubGVuZ3RoICkge1xuXHRcdFx0dGhpcy5fY3JlYXRlV2lkZ2V0KCBvcHRpb25zLCBlbGVtZW50ICk7XG5cdFx0fVxuXHR9O1xuXG5cdC8vIEV4dGVuZCB3aXRoIHRoZSBleGlzdGluZyBjb25zdHJ1Y3RvciB0byBjYXJyeSBvdmVyIGFueSBzdGF0aWMgcHJvcGVydGllc1xuXHQkLmV4dGVuZCggY29uc3RydWN0b3IsIGV4aXN0aW5nQ29uc3RydWN0b3IsIHtcblx0XHR2ZXJzaW9uOiBwcm90b3R5cGUudmVyc2lvbixcblxuXHRcdC8vIENvcHkgdGhlIG9iamVjdCB1c2VkIHRvIGNyZWF0ZSB0aGUgcHJvdG90eXBlIGluIGNhc2Ugd2UgbmVlZCB0b1xuXHRcdC8vIHJlZGVmaW5lIHRoZSB3aWRnZXQgbGF0ZXJcblx0XHRfcHJvdG86ICQuZXh0ZW5kKCB7fSwgcHJvdG90eXBlICksXG5cblx0XHQvLyBUcmFjayB3aWRnZXRzIHRoYXQgaW5oZXJpdCBmcm9tIHRoaXMgd2lkZ2V0IGluIGNhc2UgdGhpcyB3aWRnZXQgaXNcblx0XHQvLyByZWRlZmluZWQgYWZ0ZXIgYSB3aWRnZXQgaW5oZXJpdHMgZnJvbSBpdFxuXHRcdF9jaGlsZENvbnN0cnVjdG9yczogW11cblx0fSApO1xuXG5cdGJhc2VQcm90b3R5cGUgPSBuZXcgYmFzZSgpO1xuXG5cdC8vIFdlIG5lZWQgdG8gbWFrZSB0aGUgb3B0aW9ucyBoYXNoIGEgcHJvcGVydHkgZGlyZWN0bHkgb24gdGhlIG5ldyBpbnN0YW5jZVxuXHQvLyBvdGhlcndpc2Ugd2UnbGwgbW9kaWZ5IHRoZSBvcHRpb25zIGhhc2ggb24gdGhlIHByb3RvdHlwZSB0aGF0IHdlJ3JlXG5cdC8vIGluaGVyaXRpbmcgZnJvbVxuXHRiYXNlUHJvdG90eXBlLm9wdGlvbnMgPSAkLndpZGdldC5leHRlbmQoIHt9LCBiYXNlUHJvdG90eXBlLm9wdGlvbnMgKTtcblx0JC5lYWNoKCBwcm90b3R5cGUsIGZ1bmN0aW9uKCBwcm9wLCB2YWx1ZSApIHtcblx0XHRpZiAoICEkLmlzRnVuY3Rpb24oIHZhbHVlICkgKSB7XG5cdFx0XHRwcm94aWVkUHJvdG90eXBlWyBwcm9wIF0gPSB2YWx1ZTtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cdFx0cHJveGllZFByb3RvdHlwZVsgcHJvcCBdID0gKCBmdW5jdGlvbigpIHtcblx0XHRcdGZ1bmN0aW9uIF9zdXBlcigpIHtcblx0XHRcdFx0cmV0dXJuIGJhc2UucHJvdG90eXBlWyBwcm9wIF0uYXBwbHkoIHRoaXMsIGFyZ3VtZW50cyApO1xuXHRcdFx0fVxuXG5cdFx0XHRmdW5jdGlvbiBfc3VwZXJBcHBseSggYXJncyApIHtcblx0XHRcdFx0cmV0dXJuIGJhc2UucHJvdG90eXBlWyBwcm9wIF0uYXBwbHkoIHRoaXMsIGFyZ3MgKTtcblx0XHRcdH1cblxuXHRcdFx0cmV0dXJuIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgX19zdXBlciA9IHRoaXMuX3N1cGVyO1xuXHRcdFx0XHR2YXIgX19zdXBlckFwcGx5ID0gdGhpcy5fc3VwZXJBcHBseTtcblx0XHRcdFx0dmFyIHJldHVyblZhbHVlO1xuXG5cdFx0XHRcdHRoaXMuX3N1cGVyID0gX3N1cGVyO1xuXHRcdFx0XHR0aGlzLl9zdXBlckFwcGx5ID0gX3N1cGVyQXBwbHk7XG5cblx0XHRcdFx0cmV0dXJuVmFsdWUgPSB2YWx1ZS5hcHBseSggdGhpcywgYXJndW1lbnRzICk7XG5cblx0XHRcdFx0dGhpcy5fc3VwZXIgPSBfX3N1cGVyO1xuXHRcdFx0XHR0aGlzLl9zdXBlckFwcGx5ID0gX19zdXBlckFwcGx5O1xuXG5cdFx0XHRcdHJldHVybiByZXR1cm5WYWx1ZTtcblx0XHRcdH07XG5cdFx0fSApKCk7XG5cdH0gKTtcblx0Y29uc3RydWN0b3IucHJvdG90eXBlID0gJC53aWRnZXQuZXh0ZW5kKCBiYXNlUHJvdG90eXBlLCB7XG5cblx0XHQvLyBUT0RPOiByZW1vdmUgc3VwcG9ydCBmb3Igd2lkZ2V0RXZlbnRQcmVmaXhcblx0XHQvLyBhbHdheXMgdXNlIHRoZSBuYW1lICsgYSBjb2xvbiBhcyB0aGUgcHJlZml4LCBlLmcuLCBkcmFnZ2FibGU6c3RhcnRcblx0XHQvLyBkb24ndCBwcmVmaXggZm9yIHdpZGdldHMgdGhhdCBhcmVuJ3QgRE9NLWJhc2VkXG5cdFx0d2lkZ2V0RXZlbnRQcmVmaXg6IGV4aXN0aW5nQ29uc3RydWN0b3IgPyAoIGJhc2VQcm90b3R5cGUud2lkZ2V0RXZlbnRQcmVmaXggfHwgbmFtZSApIDogbmFtZVxuXHR9LCBwcm94aWVkUHJvdG90eXBlLCB7XG5cdFx0Y29uc3RydWN0b3I6IGNvbnN0cnVjdG9yLFxuXHRcdG5hbWVzcGFjZTogbmFtZXNwYWNlLFxuXHRcdHdpZGdldE5hbWU6IG5hbWUsXG5cdFx0d2lkZ2V0RnVsbE5hbWU6IGZ1bGxOYW1lXG5cdH0gKTtcblxuXHQvLyBJZiB0aGlzIHdpZGdldCBpcyBiZWluZyByZWRlZmluZWQgdGhlbiB3ZSBuZWVkIHRvIGZpbmQgYWxsIHdpZGdldHMgdGhhdFxuXHQvLyBhcmUgaW5oZXJpdGluZyBmcm9tIGl0IGFuZCByZWRlZmluZSBhbGwgb2YgdGhlbSBzbyB0aGF0IHRoZXkgaW5oZXJpdCBmcm9tXG5cdC8vIHRoZSBuZXcgdmVyc2lvbiBvZiB0aGlzIHdpZGdldC4gV2UncmUgZXNzZW50aWFsbHkgdHJ5aW5nIHRvIHJlcGxhY2Ugb25lXG5cdC8vIGxldmVsIGluIHRoZSBwcm90b3R5cGUgY2hhaW4uXG5cdGlmICggZXhpc3RpbmdDb25zdHJ1Y3RvciApIHtcblx0XHQkLmVhY2goIGV4aXN0aW5nQ29uc3RydWN0b3IuX2NoaWxkQ29uc3RydWN0b3JzLCBmdW5jdGlvbiggaSwgY2hpbGQgKSB7XG5cdFx0XHR2YXIgY2hpbGRQcm90b3R5cGUgPSBjaGlsZC5wcm90b3R5cGU7XG5cblx0XHRcdC8vIFJlZGVmaW5lIHRoZSBjaGlsZCB3aWRnZXQgdXNpbmcgdGhlIHNhbWUgcHJvdG90eXBlIHRoYXQgd2FzXG5cdFx0XHQvLyBvcmlnaW5hbGx5IHVzZWQsIGJ1dCBpbmhlcml0IGZyb20gdGhlIG5ldyB2ZXJzaW9uIG9mIHRoZSBiYXNlXG5cdFx0XHQkLndpZGdldCggY2hpbGRQcm90b3R5cGUubmFtZXNwYWNlICsgXCIuXCIgKyBjaGlsZFByb3RvdHlwZS53aWRnZXROYW1lLCBjb25zdHJ1Y3Rvcixcblx0XHRcdFx0Y2hpbGQuX3Byb3RvICk7XG5cdFx0fSApO1xuXG5cdFx0Ly8gUmVtb3ZlIHRoZSBsaXN0IG9mIGV4aXN0aW5nIGNoaWxkIGNvbnN0cnVjdG9ycyBmcm9tIHRoZSBvbGQgY29uc3RydWN0b3Jcblx0XHQvLyBzbyB0aGUgb2xkIGNoaWxkIGNvbnN0cnVjdG9ycyBjYW4gYmUgZ2FyYmFnZSBjb2xsZWN0ZWRcblx0XHRkZWxldGUgZXhpc3RpbmdDb25zdHJ1Y3Rvci5fY2hpbGRDb25zdHJ1Y3RvcnM7XG5cdH0gZWxzZSB7XG5cdFx0YmFzZS5fY2hpbGRDb25zdHJ1Y3RvcnMucHVzaCggY29uc3RydWN0b3IgKTtcblx0fVxuXG5cdCQud2lkZ2V0LmJyaWRnZSggbmFtZSwgY29uc3RydWN0b3IgKTtcblxuXHRyZXR1cm4gY29uc3RydWN0b3I7XG59O1xuXG4kLndpZGdldC5leHRlbmQgPSBmdW5jdGlvbiggdGFyZ2V0ICkge1xuXHR2YXIgaW5wdXQgPSB3aWRnZXRTbGljZS5jYWxsKCBhcmd1bWVudHMsIDEgKTtcblx0dmFyIGlucHV0SW5kZXggPSAwO1xuXHR2YXIgaW5wdXRMZW5ndGggPSBpbnB1dC5sZW5ndGg7XG5cdHZhciBrZXk7XG5cdHZhciB2YWx1ZTtcblxuXHRmb3IgKCA7IGlucHV0SW5kZXggPCBpbnB1dExlbmd0aDsgaW5wdXRJbmRleCsrICkge1xuXHRcdGZvciAoIGtleSBpbiBpbnB1dFsgaW5wdXRJbmRleCBdICkge1xuXHRcdFx0dmFsdWUgPSBpbnB1dFsgaW5wdXRJbmRleCBdWyBrZXkgXTtcblx0XHRcdGlmICggaW5wdXRbIGlucHV0SW5kZXggXS5oYXNPd25Qcm9wZXJ0eSgga2V5ICkgJiYgdmFsdWUgIT09IHVuZGVmaW5lZCApIHtcblxuXHRcdFx0XHQvLyBDbG9uZSBvYmplY3RzXG5cdFx0XHRcdGlmICggJC5pc1BsYWluT2JqZWN0KCB2YWx1ZSApICkge1xuXHRcdFx0XHRcdHRhcmdldFsga2V5IF0gPSAkLmlzUGxhaW5PYmplY3QoIHRhcmdldFsga2V5IF0gKSA/XG5cdFx0XHRcdFx0XHQkLndpZGdldC5leHRlbmQoIHt9LCB0YXJnZXRbIGtleSBdLCB2YWx1ZSApIDpcblxuXHRcdFx0XHRcdFx0Ly8gRG9uJ3QgZXh0ZW5kIHN0cmluZ3MsIGFycmF5cywgZXRjLiB3aXRoIG9iamVjdHNcblx0XHRcdFx0XHRcdCQud2lkZ2V0LmV4dGVuZCgge30sIHZhbHVlICk7XG5cblx0XHRcdFx0Ly8gQ29weSBldmVyeXRoaW5nIGVsc2UgYnkgcmVmZXJlbmNlXG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0dGFyZ2V0WyBrZXkgXSA9IHZhbHVlO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXHR9XG5cdHJldHVybiB0YXJnZXQ7XG59O1xuXG4kLndpZGdldC5icmlkZ2UgPSBmdW5jdGlvbiggbmFtZSwgb2JqZWN0ICkge1xuXHR2YXIgZnVsbE5hbWUgPSBvYmplY3QucHJvdG90eXBlLndpZGdldEZ1bGxOYW1lIHx8IG5hbWU7XG5cdCQuZm5bIG5hbWUgXSA9IGZ1bmN0aW9uKCBvcHRpb25zICkge1xuXHRcdHZhciBpc01ldGhvZENhbGwgPSB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJzdHJpbmdcIjtcblx0XHR2YXIgYXJncyA9IHdpZGdldFNsaWNlLmNhbGwoIGFyZ3VtZW50cywgMSApO1xuXHRcdHZhciByZXR1cm5WYWx1ZSA9IHRoaXM7XG5cblx0XHRpZiAoIGlzTWV0aG9kQ2FsbCApIHtcblxuXHRcdFx0Ly8gSWYgdGhpcyBpcyBhbiBlbXB0eSBjb2xsZWN0aW9uLCB3ZSBuZWVkIHRvIGhhdmUgdGhlIGluc3RhbmNlIG1ldGhvZFxuXHRcdFx0Ly8gcmV0dXJuIHVuZGVmaW5lZCBpbnN0ZWFkIG9mIHRoZSBqUXVlcnkgaW5zdGFuY2Vcblx0XHRcdGlmICggIXRoaXMubGVuZ3RoICYmIG9wdGlvbnMgPT09IFwiaW5zdGFuY2VcIiApIHtcblx0XHRcdFx0cmV0dXJuVmFsdWUgPSB1bmRlZmluZWQ7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHR0aGlzLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdHZhciBtZXRob2RWYWx1ZTtcblx0XHRcdFx0XHR2YXIgaW5zdGFuY2UgPSAkLmRhdGEoIHRoaXMsIGZ1bGxOYW1lICk7XG5cblx0XHRcdFx0XHRpZiAoIG9wdGlvbnMgPT09IFwiaW5zdGFuY2VcIiApIHtcblx0XHRcdFx0XHRcdHJldHVyblZhbHVlID0gaW5zdGFuY2U7XG5cdFx0XHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0aWYgKCAhaW5zdGFuY2UgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm4gJC5lcnJvciggXCJjYW5ub3QgY2FsbCBtZXRob2RzIG9uIFwiICsgbmFtZSArXG5cdFx0XHRcdFx0XHRcdFwiIHByaW9yIHRvIGluaXRpYWxpemF0aW9uOyBcIiArXG5cdFx0XHRcdFx0XHRcdFwiYXR0ZW1wdGVkIHRvIGNhbGwgbWV0aG9kICdcIiArIG9wdGlvbnMgKyBcIidcIiApO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdGlmICggISQuaXNGdW5jdGlvbiggaW5zdGFuY2VbIG9wdGlvbnMgXSApIHx8IG9wdGlvbnMuY2hhckF0KCAwICkgPT09IFwiX1wiICkge1xuXHRcdFx0XHRcdFx0cmV0dXJuICQuZXJyb3IoIFwibm8gc3VjaCBtZXRob2QgJ1wiICsgb3B0aW9ucyArIFwiJyBmb3IgXCIgKyBuYW1lICtcblx0XHRcdFx0XHRcdFx0XCIgd2lkZ2V0IGluc3RhbmNlXCIgKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRtZXRob2RWYWx1ZSA9IGluc3RhbmNlWyBvcHRpb25zIF0uYXBwbHkoIGluc3RhbmNlLCBhcmdzICk7XG5cblx0XHRcdFx0XHRpZiAoIG1ldGhvZFZhbHVlICE9PSBpbnN0YW5jZSAmJiBtZXRob2RWYWx1ZSAhPT0gdW5kZWZpbmVkICkge1xuXHRcdFx0XHRcdFx0cmV0dXJuVmFsdWUgPSBtZXRob2RWYWx1ZSAmJiBtZXRob2RWYWx1ZS5qcXVlcnkgP1xuXHRcdFx0XHRcdFx0XHRyZXR1cm5WYWx1ZS5wdXNoU3RhY2soIG1ldGhvZFZhbHVlLmdldCgpICkgOlxuXHRcdFx0XHRcdFx0XHRtZXRob2RWYWx1ZTtcblx0XHRcdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0gKTtcblx0XHRcdH1cblx0XHR9IGVsc2Uge1xuXG5cdFx0XHQvLyBBbGxvdyBtdWx0aXBsZSBoYXNoZXMgdG8gYmUgcGFzc2VkIG9uIGluaXRcblx0XHRcdGlmICggYXJncy5sZW5ndGggKSB7XG5cdFx0XHRcdG9wdGlvbnMgPSAkLndpZGdldC5leHRlbmQuYXBwbHkoIG51bGwsIFsgb3B0aW9ucyBdLmNvbmNhdCggYXJncyApICk7XG5cdFx0XHR9XG5cblx0XHRcdHRoaXMuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHZhciBpbnN0YW5jZSA9ICQuZGF0YSggdGhpcywgZnVsbE5hbWUgKTtcblx0XHRcdFx0aWYgKCBpbnN0YW5jZSApIHtcblx0XHRcdFx0XHRpbnN0YW5jZS5vcHRpb24oIG9wdGlvbnMgfHwge30gKTtcblx0XHRcdFx0XHRpZiAoIGluc3RhbmNlLl9pbml0ICkge1xuXHRcdFx0XHRcdFx0aW5zdGFuY2UuX2luaXQoKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0JC5kYXRhKCB0aGlzLCBmdWxsTmFtZSwgbmV3IG9iamVjdCggb3B0aW9ucywgdGhpcyApICk7XG5cdFx0XHRcdH1cblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gcmV0dXJuVmFsdWU7XG5cdH07XG59O1xuXG4kLldpZGdldCA9IGZ1bmN0aW9uKCAvKiBvcHRpb25zLCBlbGVtZW50ICovICkge307XG4kLldpZGdldC5fY2hpbGRDb25zdHJ1Y3RvcnMgPSBbXTtcblxuJC5XaWRnZXQucHJvdG90eXBlID0ge1xuXHR3aWRnZXROYW1lOiBcIndpZGdldFwiLFxuXHR3aWRnZXRFdmVudFByZWZpeDogXCJcIixcblx0ZGVmYXVsdEVsZW1lbnQ6IFwiPGRpdj5cIixcblxuXHRvcHRpb25zOiB7XG5cdFx0Y2xhc3Nlczoge30sXG5cdFx0ZGlzYWJsZWQ6IGZhbHNlLFxuXG5cdFx0Ly8gQ2FsbGJhY2tzXG5cdFx0Y3JlYXRlOiBudWxsXG5cdH0sXG5cblx0X2NyZWF0ZVdpZGdldDogZnVuY3Rpb24oIG9wdGlvbnMsIGVsZW1lbnQgKSB7XG5cdFx0ZWxlbWVudCA9ICQoIGVsZW1lbnQgfHwgdGhpcy5kZWZhdWx0RWxlbWVudCB8fCB0aGlzIClbIDAgXTtcblx0XHR0aGlzLmVsZW1lbnQgPSAkKCBlbGVtZW50ICk7XG5cdFx0dGhpcy51dWlkID0gd2lkZ2V0VXVpZCsrO1xuXHRcdHRoaXMuZXZlbnROYW1lc3BhY2UgPSBcIi5cIiArIHRoaXMud2lkZ2V0TmFtZSArIHRoaXMudXVpZDtcblxuXHRcdHRoaXMuYmluZGluZ3MgPSAkKCk7XG5cdFx0dGhpcy5ob3ZlcmFibGUgPSAkKCk7XG5cdFx0dGhpcy5mb2N1c2FibGUgPSAkKCk7XG5cdFx0dGhpcy5jbGFzc2VzRWxlbWVudExvb2t1cCA9IHt9O1xuXG5cdFx0aWYgKCBlbGVtZW50ICE9PSB0aGlzICkge1xuXHRcdFx0JC5kYXRhKCBlbGVtZW50LCB0aGlzLndpZGdldEZ1bGxOYW1lLCB0aGlzICk7XG5cdFx0XHR0aGlzLl9vbiggdHJ1ZSwgdGhpcy5lbGVtZW50LCB7XG5cdFx0XHRcdHJlbW92ZTogZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHRcdGlmICggZXZlbnQudGFyZ2V0ID09PSBlbGVtZW50ICkge1xuXHRcdFx0XHRcdFx0dGhpcy5kZXN0cm95KCk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9ICk7XG5cdFx0XHR0aGlzLmRvY3VtZW50ID0gJCggZWxlbWVudC5zdHlsZSA/XG5cblx0XHRcdFx0Ly8gRWxlbWVudCB3aXRoaW4gdGhlIGRvY3VtZW50XG5cdFx0XHRcdGVsZW1lbnQub3duZXJEb2N1bWVudCA6XG5cblx0XHRcdFx0Ly8gRWxlbWVudCBpcyB3aW5kb3cgb3IgZG9jdW1lbnRcblx0XHRcdFx0ZWxlbWVudC5kb2N1bWVudCB8fCBlbGVtZW50ICk7XG5cdFx0XHR0aGlzLndpbmRvdyA9ICQoIHRoaXMuZG9jdW1lbnRbIDAgXS5kZWZhdWx0VmlldyB8fCB0aGlzLmRvY3VtZW50WyAwIF0ucGFyZW50V2luZG93ICk7XG5cdFx0fVxuXG5cdFx0dGhpcy5vcHRpb25zID0gJC53aWRnZXQuZXh0ZW5kKCB7fSxcblx0XHRcdHRoaXMub3B0aW9ucyxcblx0XHRcdHRoaXMuX2dldENyZWF0ZU9wdGlvbnMoKSxcblx0XHRcdG9wdGlvbnMgKTtcblxuXHRcdHRoaXMuX2NyZWF0ZSgpO1xuXG5cdFx0aWYgKCB0aGlzLm9wdGlvbnMuZGlzYWJsZWQgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb25EaXNhYmxlZCggdGhpcy5vcHRpb25zLmRpc2FibGVkICk7XG5cdFx0fVxuXG5cdFx0dGhpcy5fdHJpZ2dlciggXCJjcmVhdGVcIiwgbnVsbCwgdGhpcy5fZ2V0Q3JlYXRlRXZlbnREYXRhKCkgKTtcblx0XHR0aGlzLl9pbml0KCk7XG5cdH0sXG5cblx0X2dldENyZWF0ZU9wdGlvbnM6IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiB7fTtcblx0fSxcblxuXHRfZ2V0Q3JlYXRlRXZlbnREYXRhOiAkLm5vb3AsXG5cblx0X2NyZWF0ZTogJC5ub29wLFxuXG5cdF9pbml0OiAkLm5vb3AsXG5cblx0ZGVzdHJveTogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIHRoYXQgPSB0aGlzO1xuXG5cdFx0dGhpcy5fZGVzdHJveSgpO1xuXHRcdCQuZWFjaCggdGhpcy5jbGFzc2VzRWxlbWVudExvb2t1cCwgZnVuY3Rpb24oIGtleSwgdmFsdWUgKSB7XG5cdFx0XHR0aGF0Ll9yZW1vdmVDbGFzcyggdmFsdWUsIGtleSApO1xuXHRcdH0gKTtcblxuXHRcdC8vIFdlIGNhbiBwcm9iYWJseSByZW1vdmUgdGhlIHVuYmluZCBjYWxscyBpbiAyLjBcblx0XHQvLyBhbGwgZXZlbnQgYmluZGluZ3Mgc2hvdWxkIGdvIHRocm91Z2ggdGhpcy5fb24oKVxuXHRcdHRoaXMuZWxlbWVudFxuXHRcdFx0Lm9mZiggdGhpcy5ldmVudE5hbWVzcGFjZSApXG5cdFx0XHQucmVtb3ZlRGF0YSggdGhpcy53aWRnZXRGdWxsTmFtZSApO1xuXHRcdHRoaXMud2lkZ2V0KClcblx0XHRcdC5vZmYoIHRoaXMuZXZlbnROYW1lc3BhY2UgKVxuXHRcdFx0LnJlbW92ZUF0dHIoIFwiYXJpYS1kaXNhYmxlZFwiICk7XG5cblx0XHQvLyBDbGVhbiB1cCBldmVudHMgYW5kIHN0YXRlc1xuXHRcdHRoaXMuYmluZGluZ3Mub2ZmKCB0aGlzLmV2ZW50TmFtZXNwYWNlICk7XG5cdH0sXG5cblx0X2Rlc3Ryb3k6ICQubm9vcCxcblxuXHR3aWRnZXQ6IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiB0aGlzLmVsZW1lbnQ7XG5cdH0sXG5cblx0b3B0aW9uOiBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHR2YXIgb3B0aW9ucyA9IGtleTtcblx0XHR2YXIgcGFydHM7XG5cdFx0dmFyIGN1ck9wdGlvbjtcblx0XHR2YXIgaTtcblxuXHRcdGlmICggYXJndW1lbnRzLmxlbmd0aCA9PT0gMCApIHtcblxuXHRcdFx0Ly8gRG9uJ3QgcmV0dXJuIGEgcmVmZXJlbmNlIHRvIHRoZSBpbnRlcm5hbCBoYXNoXG5cdFx0XHRyZXR1cm4gJC53aWRnZXQuZXh0ZW5kKCB7fSwgdGhpcy5vcHRpb25zICk7XG5cdFx0fVxuXG5cdFx0aWYgKCB0eXBlb2Yga2V5ID09PSBcInN0cmluZ1wiICkge1xuXG5cdFx0XHQvLyBIYW5kbGUgbmVzdGVkIGtleXMsIGUuZy4sIFwiZm9vLmJhclwiID0+IHsgZm9vOiB7IGJhcjogX19fIH0gfVxuXHRcdFx0b3B0aW9ucyA9IHt9O1xuXHRcdFx0cGFydHMgPSBrZXkuc3BsaXQoIFwiLlwiICk7XG5cdFx0XHRrZXkgPSBwYXJ0cy5zaGlmdCgpO1xuXHRcdFx0aWYgKCBwYXJ0cy5sZW5ndGggKSB7XG5cdFx0XHRcdGN1ck9wdGlvbiA9IG9wdGlvbnNbIGtleSBdID0gJC53aWRnZXQuZXh0ZW5kKCB7fSwgdGhpcy5vcHRpb25zWyBrZXkgXSApO1xuXHRcdFx0XHRmb3IgKCBpID0gMDsgaSA8IHBhcnRzLmxlbmd0aCAtIDE7IGkrKyApIHtcblx0XHRcdFx0XHRjdXJPcHRpb25bIHBhcnRzWyBpIF0gXSA9IGN1ck9wdGlvblsgcGFydHNbIGkgXSBdIHx8IHt9O1xuXHRcdFx0XHRcdGN1ck9wdGlvbiA9IGN1ck9wdGlvblsgcGFydHNbIGkgXSBdO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGtleSA9IHBhcnRzLnBvcCgpO1xuXHRcdFx0XHRpZiAoIGFyZ3VtZW50cy5sZW5ndGggPT09IDEgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIGN1ck9wdGlvblsga2V5IF0gPT09IHVuZGVmaW5lZCA/IG51bGwgOiBjdXJPcHRpb25bIGtleSBdO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGN1ck9wdGlvblsga2V5IF0gPSB2YWx1ZTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdGlmICggYXJndW1lbnRzLmxlbmd0aCA9PT0gMSApIHtcblx0XHRcdFx0XHRyZXR1cm4gdGhpcy5vcHRpb25zWyBrZXkgXSA9PT0gdW5kZWZpbmVkID8gbnVsbCA6IHRoaXMub3B0aW9uc1sga2V5IF07XG5cdFx0XHRcdH1cblx0XHRcdFx0b3B0aW9uc1sga2V5IF0gPSB2YWx1ZTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHR0aGlzLl9zZXRPcHRpb25zKCBvcHRpb25zICk7XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfc2V0T3B0aW9uczogZnVuY3Rpb24oIG9wdGlvbnMgKSB7XG5cdFx0dmFyIGtleTtcblxuXHRcdGZvciAoIGtleSBpbiBvcHRpb25zICkge1xuXHRcdFx0dGhpcy5fc2V0T3B0aW9uKCBrZXksIG9wdGlvbnNbIGtleSBdICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0X3NldE9wdGlvbjogZnVuY3Rpb24oIGtleSwgdmFsdWUgKSB7XG5cdFx0aWYgKCBrZXkgPT09IFwiY2xhc3Nlc1wiICkge1xuXHRcdFx0dGhpcy5fc2V0T3B0aW9uQ2xhc3NlcyggdmFsdWUgKTtcblx0XHR9XG5cblx0XHR0aGlzLm9wdGlvbnNbIGtleSBdID0gdmFsdWU7XG5cblx0XHRpZiAoIGtleSA9PT0gXCJkaXNhYmxlZFwiICkge1xuXHRcdFx0dGhpcy5fc2V0T3B0aW9uRGlzYWJsZWQoIHZhbHVlICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0X3NldE9wdGlvbkNsYXNzZXM6IGZ1bmN0aW9uKCB2YWx1ZSApIHtcblx0XHR2YXIgY2xhc3NLZXksIGVsZW1lbnRzLCBjdXJyZW50RWxlbWVudHM7XG5cblx0XHRmb3IgKCBjbGFzc0tleSBpbiB2YWx1ZSApIHtcblx0XHRcdGN1cnJlbnRFbGVtZW50cyA9IHRoaXMuY2xhc3Nlc0VsZW1lbnRMb29rdXBbIGNsYXNzS2V5IF07XG5cdFx0XHRpZiAoIHZhbHVlWyBjbGFzc0tleSBdID09PSB0aGlzLm9wdGlvbnMuY2xhc3Nlc1sgY2xhc3NLZXkgXSB8fFxuXHRcdFx0XHRcdCFjdXJyZW50RWxlbWVudHMgfHxcblx0XHRcdFx0XHQhY3VycmVudEVsZW1lbnRzLmxlbmd0aCApIHtcblx0XHRcdFx0Y29udGludWU7XG5cdFx0XHR9XG5cblx0XHRcdC8vIFdlIGFyZSBkb2luZyB0aGlzIHRvIGNyZWF0ZSBhIG5ldyBqUXVlcnkgb2JqZWN0IGJlY2F1c2UgdGhlIF9yZW1vdmVDbGFzcygpIGNhbGxcblx0XHRcdC8vIG9uIHRoZSBuZXh0IGxpbmUgaXMgZ29pbmcgdG8gZGVzdHJveSB0aGUgcmVmZXJlbmNlIHRvIHRoZSBjdXJyZW50IGVsZW1lbnRzIGJlaW5nXG5cdFx0XHQvLyB0cmFja2VkLiBXZSBuZWVkIHRvIHNhdmUgYSBjb3B5IG9mIHRoaXMgY29sbGVjdGlvbiBzbyB0aGF0IHdlIGNhbiBhZGQgdGhlIG5ldyBjbGFzc2VzXG5cdFx0XHQvLyBiZWxvdy5cblx0XHRcdGVsZW1lbnRzID0gJCggY3VycmVudEVsZW1lbnRzLmdldCgpICk7XG5cdFx0XHR0aGlzLl9yZW1vdmVDbGFzcyggY3VycmVudEVsZW1lbnRzLCBjbGFzc0tleSApO1xuXG5cdFx0XHQvLyBXZSBkb24ndCB1c2UgX2FkZENsYXNzKCkgaGVyZSwgYmVjYXVzZSB0aGF0IHVzZXMgdGhpcy5vcHRpb25zLmNsYXNzZXNcblx0XHRcdC8vIGZvciBnZW5lcmF0aW5nIHRoZSBzdHJpbmcgb2YgY2xhc3Nlcy4gV2Ugd2FudCB0byB1c2UgdGhlIHZhbHVlIHBhc3NlZCBpbiBmcm9tXG5cdFx0XHQvLyBfc2V0T3B0aW9uKCksIHRoaXMgaXMgdGhlIG5ldyB2YWx1ZSBvZiB0aGUgY2xhc3NlcyBvcHRpb24gd2hpY2ggd2FzIHBhc3NlZCB0b1xuXHRcdFx0Ly8gX3NldE9wdGlvbigpLiBXZSBwYXNzIHRoaXMgdmFsdWUgZGlyZWN0bHkgdG8gX2NsYXNzZXMoKS5cblx0XHRcdGVsZW1lbnRzLmFkZENsYXNzKCB0aGlzLl9jbGFzc2VzKCB7XG5cdFx0XHRcdGVsZW1lbnQ6IGVsZW1lbnRzLFxuXHRcdFx0XHRrZXlzOiBjbGFzc0tleSxcblx0XHRcdFx0Y2xhc3NlczogdmFsdWUsXG5cdFx0XHRcdGFkZDogdHJ1ZVxuXHRcdFx0fSApICk7XG5cdFx0fVxuXHR9LFxuXG5cdF9zZXRPcHRpb25EaXNhYmxlZDogZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdHRoaXMuX3RvZ2dsZUNsYXNzKCB0aGlzLndpZGdldCgpLCB0aGlzLndpZGdldEZ1bGxOYW1lICsgXCItZGlzYWJsZWRcIiwgbnVsbCwgISF2YWx1ZSApO1xuXG5cdFx0Ly8gSWYgdGhlIHdpZGdldCBpcyBiZWNvbWluZyBkaXNhYmxlZCwgdGhlbiBub3RoaW5nIGlzIGludGVyYWN0aXZlXG5cdFx0aWYgKCB2YWx1ZSApIHtcblx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCB0aGlzLmhvdmVyYWJsZSwgbnVsbCwgXCJ1aS1zdGF0ZS1ob3ZlclwiICk7XG5cdFx0XHR0aGlzLl9yZW1vdmVDbGFzcyggdGhpcy5mb2N1c2FibGUsIG51bGwsIFwidWktc3RhdGUtZm9jdXNcIiApO1xuXHRcdH1cblx0fSxcblxuXHRlbmFibGU6IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiB0aGlzLl9zZXRPcHRpb25zKCB7IGRpc2FibGVkOiBmYWxzZSB9ICk7XG5cdH0sXG5cblx0ZGlzYWJsZTogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMuX3NldE9wdGlvbnMoIHsgZGlzYWJsZWQ6IHRydWUgfSApO1xuXHR9LFxuXG5cdF9jbGFzc2VzOiBmdW5jdGlvbiggb3B0aW9ucyApIHtcblx0XHR2YXIgZnVsbCA9IFtdO1xuXHRcdHZhciB0aGF0ID0gdGhpcztcblxuXHRcdG9wdGlvbnMgPSAkLmV4dGVuZCgge1xuXHRcdFx0ZWxlbWVudDogdGhpcy5lbGVtZW50LFxuXHRcdFx0Y2xhc3NlczogdGhpcy5vcHRpb25zLmNsYXNzZXMgfHwge31cblx0XHR9LCBvcHRpb25zICk7XG5cblx0XHRmdW5jdGlvbiBwcm9jZXNzQ2xhc3NTdHJpbmcoIGNsYXNzZXMsIGNoZWNrT3B0aW9uICkge1xuXHRcdFx0dmFyIGN1cnJlbnQsIGk7XG5cdFx0XHRmb3IgKCBpID0gMDsgaSA8IGNsYXNzZXMubGVuZ3RoOyBpKysgKSB7XG5cdFx0XHRcdGN1cnJlbnQgPSB0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwWyBjbGFzc2VzWyBpIF0gXSB8fCAkKCk7XG5cdFx0XHRcdGlmICggb3B0aW9ucy5hZGQgKSB7XG5cdFx0XHRcdFx0Y3VycmVudCA9ICQoICQudW5pcXVlKCBjdXJyZW50LmdldCgpLmNvbmNhdCggb3B0aW9ucy5lbGVtZW50LmdldCgpICkgKSApO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdGN1cnJlbnQgPSAkKCBjdXJyZW50Lm5vdCggb3B0aW9ucy5lbGVtZW50ICkuZ2V0KCkgKTtcblx0XHRcdFx0fVxuXHRcdFx0XHR0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwWyBjbGFzc2VzWyBpIF0gXSA9IGN1cnJlbnQ7XG5cdFx0XHRcdGZ1bGwucHVzaCggY2xhc3Nlc1sgaSBdICk7XG5cdFx0XHRcdGlmICggY2hlY2tPcHRpb24gJiYgb3B0aW9ucy5jbGFzc2VzWyBjbGFzc2VzWyBpIF0gXSApIHtcblx0XHRcdFx0XHRmdWxsLnB1c2goIG9wdGlvbnMuY2xhc3Nlc1sgY2xhc3Nlc1sgaSBdIF0gKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHRoaXMuX29uKCBvcHRpb25zLmVsZW1lbnQsIHtcblx0XHRcdFwicmVtb3ZlXCI6IFwiX3VudHJhY2tDbGFzc2VzRWxlbWVudFwiXG5cdFx0fSApO1xuXG5cdFx0aWYgKCBvcHRpb25zLmtleXMgKSB7XG5cdFx0XHRwcm9jZXNzQ2xhc3NTdHJpbmcoIG9wdGlvbnMua2V5cy5tYXRjaCggL1xcUysvZyApIHx8IFtdLCB0cnVlICk7XG5cdFx0fVxuXHRcdGlmICggb3B0aW9ucy5leHRyYSApIHtcblx0XHRcdHByb2Nlc3NDbGFzc1N0cmluZyggb3B0aW9ucy5leHRyYS5tYXRjaCggL1xcUysvZyApIHx8IFtdICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIGZ1bGwuam9pbiggXCIgXCIgKTtcblx0fSxcblxuXHRfdW50cmFja0NsYXNzZXNFbGVtZW50OiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0dmFyIHRoYXQgPSB0aGlzO1xuXHRcdCQuZWFjaCggdGhhdC5jbGFzc2VzRWxlbWVudExvb2t1cCwgZnVuY3Rpb24oIGtleSwgdmFsdWUgKSB7XG5cdFx0XHRpZiAoICQuaW5BcnJheSggZXZlbnQudGFyZ2V0LCB2YWx1ZSApICE9PSAtMSApIHtcblx0XHRcdFx0dGhhdC5jbGFzc2VzRWxlbWVudExvb2t1cFsga2V5IF0gPSAkKCB2YWx1ZS5ub3QoIGV2ZW50LnRhcmdldCApLmdldCgpICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdF9yZW1vdmVDbGFzczogZnVuY3Rpb24oIGVsZW1lbnQsIGtleXMsIGV4dHJhICkge1xuXHRcdHJldHVybiB0aGlzLl90b2dnbGVDbGFzcyggZWxlbWVudCwga2V5cywgZXh0cmEsIGZhbHNlICk7XG5cdH0sXG5cblx0X2FkZENsYXNzOiBmdW5jdGlvbiggZWxlbWVudCwga2V5cywgZXh0cmEgKSB7XG5cdFx0cmV0dXJuIHRoaXMuX3RvZ2dsZUNsYXNzKCBlbGVtZW50LCBrZXlzLCBleHRyYSwgdHJ1ZSApO1xuXHR9LFxuXG5cdF90b2dnbGVDbGFzczogZnVuY3Rpb24oIGVsZW1lbnQsIGtleXMsIGV4dHJhLCBhZGQgKSB7XG5cdFx0YWRkID0gKCB0eXBlb2YgYWRkID09PSBcImJvb2xlYW5cIiApID8gYWRkIDogZXh0cmE7XG5cdFx0dmFyIHNoaWZ0ID0gKCB0eXBlb2YgZWxlbWVudCA9PT0gXCJzdHJpbmdcIiB8fCBlbGVtZW50ID09PSBudWxsICksXG5cdFx0XHRvcHRpb25zID0ge1xuXHRcdFx0XHRleHRyYTogc2hpZnQgPyBrZXlzIDogZXh0cmEsXG5cdFx0XHRcdGtleXM6IHNoaWZ0ID8gZWxlbWVudCA6IGtleXMsXG5cdFx0XHRcdGVsZW1lbnQ6IHNoaWZ0ID8gdGhpcy5lbGVtZW50IDogZWxlbWVudCxcblx0XHRcdFx0YWRkOiBhZGRcblx0XHRcdH07XG5cdFx0b3B0aW9ucy5lbGVtZW50LnRvZ2dsZUNsYXNzKCB0aGlzLl9jbGFzc2VzKCBvcHRpb25zICksIGFkZCApO1xuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdF9vbjogZnVuY3Rpb24oIHN1cHByZXNzRGlzYWJsZWRDaGVjaywgZWxlbWVudCwgaGFuZGxlcnMgKSB7XG5cdFx0dmFyIGRlbGVnYXRlRWxlbWVudDtcblx0XHR2YXIgaW5zdGFuY2UgPSB0aGlzO1xuXG5cdFx0Ly8gTm8gc3VwcHJlc3NEaXNhYmxlZENoZWNrIGZsYWcsIHNodWZmbGUgYXJndW1lbnRzXG5cdFx0aWYgKCB0eXBlb2Ygc3VwcHJlc3NEaXNhYmxlZENoZWNrICE9PSBcImJvb2xlYW5cIiApIHtcblx0XHRcdGhhbmRsZXJzID0gZWxlbWVudDtcblx0XHRcdGVsZW1lbnQgPSBzdXBwcmVzc0Rpc2FibGVkQ2hlY2s7XG5cdFx0XHRzdXBwcmVzc0Rpc2FibGVkQ2hlY2sgPSBmYWxzZTtcblx0XHR9XG5cblx0XHQvLyBObyBlbGVtZW50IGFyZ3VtZW50LCBzaHVmZmxlIGFuZCB1c2UgdGhpcy5lbGVtZW50XG5cdFx0aWYgKCAhaGFuZGxlcnMgKSB7XG5cdFx0XHRoYW5kbGVycyA9IGVsZW1lbnQ7XG5cdFx0XHRlbGVtZW50ID0gdGhpcy5lbGVtZW50O1xuXHRcdFx0ZGVsZWdhdGVFbGVtZW50ID0gdGhpcy53aWRnZXQoKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZWxlbWVudCA9IGRlbGVnYXRlRWxlbWVudCA9ICQoIGVsZW1lbnQgKTtcblx0XHRcdHRoaXMuYmluZGluZ3MgPSB0aGlzLmJpbmRpbmdzLmFkZCggZWxlbWVudCApO1xuXHRcdH1cblxuXHRcdCQuZWFjaCggaGFuZGxlcnMsIGZ1bmN0aW9uKCBldmVudCwgaGFuZGxlciApIHtcblx0XHRcdGZ1bmN0aW9uIGhhbmRsZXJQcm94eSgpIHtcblxuXHRcdFx0XHQvLyBBbGxvdyB3aWRnZXRzIHRvIGN1c3RvbWl6ZSB0aGUgZGlzYWJsZWQgaGFuZGxpbmdcblx0XHRcdFx0Ly8gLSBkaXNhYmxlZCBhcyBhbiBhcnJheSBpbnN0ZWFkIG9mIGJvb2xlYW5cblx0XHRcdFx0Ly8gLSBkaXNhYmxlZCBjbGFzcyBhcyBtZXRob2QgZm9yIGRpc2FibGluZyBpbmRpdmlkdWFsIHBhcnRzXG5cdFx0XHRcdGlmICggIXN1cHByZXNzRGlzYWJsZWRDaGVjayAmJlxuXHRcdFx0XHRcdFx0KCBpbnN0YW5jZS5vcHRpb25zLmRpc2FibGVkID09PSB0cnVlIHx8XG5cdFx0XHRcdFx0XHQkKCB0aGlzICkuaGFzQ2xhc3MoIFwidWktc3RhdGUtZGlzYWJsZWRcIiApICkgKSB7XG5cdFx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0XHR9XG5cdFx0XHRcdHJldHVybiAoIHR5cGVvZiBoYW5kbGVyID09PSBcInN0cmluZ1wiID8gaW5zdGFuY2VbIGhhbmRsZXIgXSA6IGhhbmRsZXIgKVxuXHRcdFx0XHRcdC5hcHBseSggaW5zdGFuY2UsIGFyZ3VtZW50cyApO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBDb3B5IHRoZSBndWlkIHNvIGRpcmVjdCB1bmJpbmRpbmcgd29ya3Ncblx0XHRcdGlmICggdHlwZW9mIGhhbmRsZXIgIT09IFwic3RyaW5nXCIgKSB7XG5cdFx0XHRcdGhhbmRsZXJQcm94eS5ndWlkID0gaGFuZGxlci5ndWlkID1cblx0XHRcdFx0XHRoYW5kbGVyLmd1aWQgfHwgaGFuZGxlclByb3h5Lmd1aWQgfHwgJC5ndWlkKys7XG5cdFx0XHR9XG5cblx0XHRcdHZhciBtYXRjaCA9IGV2ZW50Lm1hdGNoKCAvXihbXFx3Oi1dKilcXHMqKC4qKSQvICk7XG5cdFx0XHR2YXIgZXZlbnROYW1lID0gbWF0Y2hbIDEgXSArIGluc3RhbmNlLmV2ZW50TmFtZXNwYWNlO1xuXHRcdFx0dmFyIHNlbGVjdG9yID0gbWF0Y2hbIDIgXTtcblxuXHRcdFx0aWYgKCBzZWxlY3RvciApIHtcblx0XHRcdFx0ZGVsZWdhdGVFbGVtZW50Lm9uKCBldmVudE5hbWUsIHNlbGVjdG9yLCBoYW5kbGVyUHJveHkgKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdGVsZW1lbnQub24oIGV2ZW50TmFtZSwgaGFuZGxlclByb3h5ICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdF9vZmY6IGZ1bmN0aW9uKCBlbGVtZW50LCBldmVudE5hbWUgKSB7XG5cdFx0ZXZlbnROYW1lID0gKCBldmVudE5hbWUgfHwgXCJcIiApLnNwbGl0KCBcIiBcIiApLmpvaW4oIHRoaXMuZXZlbnROYW1lc3BhY2UgKyBcIiBcIiApICtcblx0XHRcdHRoaXMuZXZlbnROYW1lc3BhY2U7XG5cdFx0ZWxlbWVudC5vZmYoIGV2ZW50TmFtZSApLm9mZiggZXZlbnROYW1lICk7XG5cblx0XHQvLyBDbGVhciB0aGUgc3RhY2sgdG8gYXZvaWQgbWVtb3J5IGxlYWtzICgjMTAwNTYpXG5cdFx0dGhpcy5iaW5kaW5ncyA9ICQoIHRoaXMuYmluZGluZ3Mubm90KCBlbGVtZW50ICkuZ2V0KCkgKTtcblx0XHR0aGlzLmZvY3VzYWJsZSA9ICQoIHRoaXMuZm9jdXNhYmxlLm5vdCggZWxlbWVudCApLmdldCgpICk7XG5cdFx0dGhpcy5ob3ZlcmFibGUgPSAkKCB0aGlzLmhvdmVyYWJsZS5ub3QoIGVsZW1lbnQgKS5nZXQoKSApO1xuXHR9LFxuXG5cdF9kZWxheTogZnVuY3Rpb24oIGhhbmRsZXIsIGRlbGF5ICkge1xuXHRcdGZ1bmN0aW9uIGhhbmRsZXJQcm94eSgpIHtcblx0XHRcdHJldHVybiAoIHR5cGVvZiBoYW5kbGVyID09PSBcInN0cmluZ1wiID8gaW5zdGFuY2VbIGhhbmRsZXIgXSA6IGhhbmRsZXIgKVxuXHRcdFx0XHQuYXBwbHkoIGluc3RhbmNlLCBhcmd1bWVudHMgKTtcblx0XHR9XG5cdFx0dmFyIGluc3RhbmNlID0gdGhpcztcblx0XHRyZXR1cm4gc2V0VGltZW91dCggaGFuZGxlclByb3h5LCBkZWxheSB8fCAwICk7XG5cdH0sXG5cblx0X2hvdmVyYWJsZTogZnVuY3Rpb24oIGVsZW1lbnQgKSB7XG5cdFx0dGhpcy5ob3ZlcmFibGUgPSB0aGlzLmhvdmVyYWJsZS5hZGQoIGVsZW1lbnQgKTtcblx0XHR0aGlzLl9vbiggZWxlbWVudCwge1xuXHRcdFx0bW91c2VlbnRlcjogZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHR0aGlzLl9hZGRDbGFzcyggJCggZXZlbnQuY3VycmVudFRhcmdldCApLCBudWxsLCBcInVpLXN0YXRlLWhvdmVyXCIgKTtcblx0XHRcdH0sXG5cdFx0XHRtb3VzZWxlYXZlOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCAkKCBldmVudC5jdXJyZW50VGFyZ2V0ICksIG51bGwsIFwidWktc3RhdGUtaG92ZXJcIiApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSxcblxuXHRfZm9jdXNhYmxlOiBmdW5jdGlvbiggZWxlbWVudCApIHtcblx0XHR0aGlzLmZvY3VzYWJsZSA9IHRoaXMuZm9jdXNhYmxlLmFkZCggZWxlbWVudCApO1xuXHRcdHRoaXMuX29uKCBlbGVtZW50LCB7XG5cdFx0XHRmb2N1c2luOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHRoaXMuX2FkZENsYXNzKCAkKCBldmVudC5jdXJyZW50VGFyZ2V0ICksIG51bGwsIFwidWktc3RhdGUtZm9jdXNcIiApO1xuXHRcdFx0fSxcblx0XHRcdGZvY3Vzb3V0OiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCAkKCBldmVudC5jdXJyZW50VGFyZ2V0ICksIG51bGwsIFwidWktc3RhdGUtZm9jdXNcIiApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSxcblxuXHRfdHJpZ2dlcjogZnVuY3Rpb24oIHR5cGUsIGV2ZW50LCBkYXRhICkge1xuXHRcdHZhciBwcm9wLCBvcmlnO1xuXHRcdHZhciBjYWxsYmFjayA9IHRoaXMub3B0aW9uc1sgdHlwZSBdO1xuXG5cdFx0ZGF0YSA9IGRhdGEgfHwge307XG5cdFx0ZXZlbnQgPSAkLkV2ZW50KCBldmVudCApO1xuXHRcdGV2ZW50LnR5cGUgPSAoIHR5cGUgPT09IHRoaXMud2lkZ2V0RXZlbnRQcmVmaXggP1xuXHRcdFx0dHlwZSA6XG5cdFx0XHR0aGlzLndpZGdldEV2ZW50UHJlZml4ICsgdHlwZSApLnRvTG93ZXJDYXNlKCk7XG5cblx0XHQvLyBUaGUgb3JpZ2luYWwgZXZlbnQgbWF5IGNvbWUgZnJvbSBhbnkgZWxlbWVudFxuXHRcdC8vIHNvIHdlIG5lZWQgdG8gcmVzZXQgdGhlIHRhcmdldCBvbiB0aGUgbmV3IGV2ZW50XG5cdFx0ZXZlbnQudGFyZ2V0ID0gdGhpcy5lbGVtZW50WyAwIF07XG5cblx0XHQvLyBDb3B5IG9yaWdpbmFsIGV2ZW50IHByb3BlcnRpZXMgb3ZlciB0byB0aGUgbmV3IGV2ZW50XG5cdFx0b3JpZyA9IGV2ZW50Lm9yaWdpbmFsRXZlbnQ7XG5cdFx0aWYgKCBvcmlnICkge1xuXHRcdFx0Zm9yICggcHJvcCBpbiBvcmlnICkge1xuXHRcdFx0XHRpZiAoICEoIHByb3AgaW4gZXZlbnQgKSApIHtcblx0XHRcdFx0XHRldmVudFsgcHJvcCBdID0gb3JpZ1sgcHJvcCBdO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0dGhpcy5lbGVtZW50LnRyaWdnZXIoIGV2ZW50LCBkYXRhICk7XG5cdFx0cmV0dXJuICEoICQuaXNGdW5jdGlvbiggY2FsbGJhY2sgKSAmJlxuXHRcdFx0Y2FsbGJhY2suYXBwbHkoIHRoaXMuZWxlbWVudFsgMCBdLCBbIGV2ZW50IF0uY29uY2F0KCBkYXRhICkgKSA9PT0gZmFsc2UgfHxcblx0XHRcdGV2ZW50LmlzRGVmYXVsdFByZXZlbnRlZCgpICk7XG5cdH1cbn07XG5cbiQuZWFjaCggeyBzaG93OiBcImZhZGVJblwiLCBoaWRlOiBcImZhZGVPdXRcIiB9LCBmdW5jdGlvbiggbWV0aG9kLCBkZWZhdWx0RWZmZWN0ICkge1xuXHQkLldpZGdldC5wcm90b3R5cGVbIFwiX1wiICsgbWV0aG9kIF0gPSBmdW5jdGlvbiggZWxlbWVudCwgb3B0aW9ucywgY2FsbGJhY2sgKSB7XG5cdFx0aWYgKCB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdG9wdGlvbnMgPSB7IGVmZmVjdDogb3B0aW9ucyB9O1xuXHRcdH1cblxuXHRcdHZhciBoYXNPcHRpb25zO1xuXHRcdHZhciBlZmZlY3ROYW1lID0gIW9wdGlvbnMgP1xuXHRcdFx0bWV0aG9kIDpcblx0XHRcdG9wdGlvbnMgPT09IHRydWUgfHwgdHlwZW9mIG9wdGlvbnMgPT09IFwibnVtYmVyXCIgP1xuXHRcdFx0XHRkZWZhdWx0RWZmZWN0IDpcblx0XHRcdFx0b3B0aW9ucy5lZmZlY3QgfHwgZGVmYXVsdEVmZmVjdDtcblxuXHRcdG9wdGlvbnMgPSBvcHRpb25zIHx8IHt9O1xuXHRcdGlmICggdHlwZW9mIG9wdGlvbnMgPT09IFwibnVtYmVyXCIgKSB7XG5cdFx0XHRvcHRpb25zID0geyBkdXJhdGlvbjogb3B0aW9ucyB9O1xuXHRcdH1cblxuXHRcdGhhc09wdGlvbnMgPSAhJC5pc0VtcHR5T2JqZWN0KCBvcHRpb25zICk7XG5cdFx0b3B0aW9ucy5jb21wbGV0ZSA9IGNhbGxiYWNrO1xuXG5cdFx0aWYgKCBvcHRpb25zLmRlbGF5ICkge1xuXHRcdFx0ZWxlbWVudC5kZWxheSggb3B0aW9ucy5kZWxheSApO1xuXHRcdH1cblxuXHRcdGlmICggaGFzT3B0aW9ucyAmJiAkLmVmZmVjdHMgJiYgJC5lZmZlY3RzLmVmZmVjdFsgZWZmZWN0TmFtZSBdICkge1xuXHRcdFx0ZWxlbWVudFsgbWV0aG9kIF0oIG9wdGlvbnMgKTtcblx0XHR9IGVsc2UgaWYgKCBlZmZlY3ROYW1lICE9PSBtZXRob2QgJiYgZWxlbWVudFsgZWZmZWN0TmFtZSBdICkge1xuXHRcdFx0ZWxlbWVudFsgZWZmZWN0TmFtZSBdKCBvcHRpb25zLmR1cmF0aW9uLCBvcHRpb25zLmVhc2luZywgY2FsbGJhY2sgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZWxlbWVudC5xdWV1ZSggZnVuY3Rpb24oIG5leHQgKSB7XG5cdFx0XHRcdCQoIHRoaXMgKVsgbWV0aG9kIF0oKTtcblx0XHRcdFx0aWYgKCBjYWxsYmFjayApIHtcblx0XHRcdFx0XHRjYWxsYmFjay5jYWxsKCBlbGVtZW50WyAwIF0gKTtcblx0XHRcdFx0fVxuXHRcdFx0XHRuZXh0KCk7XG5cdFx0XHR9ICk7XG5cdFx0fVxuXHR9O1xufSApO1xuXG5yZXR1cm4gJC53aWRnZXQ7XG5cbn0gKSApO1xuIiwiLyohXG4gKiBqUXVlcnkgVUkgTW91c2UgMS4xMi4xXG4gKiBodHRwOi8vanF1ZXJ5dWkuY29tXG4gKlxuICogQ29weXJpZ2h0IGpRdWVyeSBGb3VuZGF0aW9uIGFuZCBvdGhlciBjb250cmlidXRvcnNcbiAqIFJlbGVhc2VkIHVuZGVyIHRoZSBNSVQgbGljZW5zZS5cbiAqIGh0dHA6Ly9qcXVlcnkub3JnL2xpY2Vuc2VcbiAqL1xuXG4vLz4+bGFiZWw6IE1vdXNlXG4vLz4+Z3JvdXA6IFdpZGdldHNcbi8vPj5kZXNjcmlwdGlvbjogQWJzdHJhY3RzIG1vdXNlLWJhc2VkIGludGVyYWN0aW9ucyB0byBhc3Npc3QgaW4gY3JlYXRpbmcgY2VydGFpbiB3aWRnZXRzLlxuLy8+PmRvY3M6IGh0dHA6Ly9hcGkuanF1ZXJ5dWkuY29tL21vdXNlL1xuXG4oIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggW1xuXHRcdFx0XCJqcXVlcnlcIixcblx0XHRcdFwiLi4vaWVcIixcblx0XHRcdFwiLi4vdmVyc2lvblwiLFxuXHRcdFx0XCIuLi93aWRnZXRcIlxuXHRcdF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59KCBmdW5jdGlvbiggJCApIHtcblxudmFyIG1vdXNlSGFuZGxlZCA9IGZhbHNlO1xuJCggZG9jdW1lbnQgKS5vbiggXCJtb3VzZXVwXCIsIGZ1bmN0aW9uKCkge1xuXHRtb3VzZUhhbmRsZWQgPSBmYWxzZTtcbn0gKTtcblxucmV0dXJuICQud2lkZ2V0KCBcInVpLm1vdXNlXCIsIHtcblx0dmVyc2lvbjogXCIxLjEyLjFcIixcblx0b3B0aW9uczoge1xuXHRcdGNhbmNlbDogXCJpbnB1dCwgdGV4dGFyZWEsIGJ1dHRvbiwgc2VsZWN0LCBvcHRpb25cIixcblx0XHRkaXN0YW5jZTogMSxcblx0XHRkZWxheTogMFxuXHR9LFxuXHRfbW91c2VJbml0OiBmdW5jdGlvbigpIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0XHR0aGlzLmVsZW1lbnRcblx0XHRcdC5vbiggXCJtb3VzZWRvd24uXCIgKyB0aGlzLndpZGdldE5hbWUsIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0cmV0dXJuIHRoYXQuX21vdXNlRG93biggZXZlbnQgKTtcblx0XHRcdH0gKVxuXHRcdFx0Lm9uKCBcImNsaWNrLlwiICsgdGhpcy53aWRnZXROYW1lLCBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdGlmICggdHJ1ZSA9PT0gJC5kYXRhKCBldmVudC50YXJnZXQsIHRoYXQud2lkZ2V0TmFtZSArIFwiLnByZXZlbnRDbGlja0V2ZW50XCIgKSApIHtcblx0XHRcdFx0XHQkLnJlbW92ZURhdGEoIGV2ZW50LnRhcmdldCwgdGhhdC53aWRnZXROYW1lICsgXCIucHJldmVudENsaWNrRXZlbnRcIiApO1xuXHRcdFx0XHRcdGV2ZW50LnN0b3BJbW1lZGlhdGVQcm9wYWdhdGlvbigpO1xuXHRcdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdFx0fVxuXHRcdFx0fSApO1xuXG5cdFx0dGhpcy5zdGFydGVkID0gZmFsc2U7XG5cdH0sXG5cblx0Ly8gVE9ETzogbWFrZSBzdXJlIGRlc3Ryb3lpbmcgb25lIGluc3RhbmNlIG9mIG1vdXNlIGRvZXNuJ3QgbWVzcyB3aXRoXG5cdC8vIG90aGVyIGluc3RhbmNlcyBvZiBtb3VzZVxuXHRfbW91c2VEZXN0cm95OiBmdW5jdGlvbigpIHtcblx0XHR0aGlzLmVsZW1lbnQub2ZmKCBcIi5cIiArIHRoaXMud2lkZ2V0TmFtZSApO1xuXHRcdGlmICggdGhpcy5fbW91c2VNb3ZlRGVsZWdhdGUgKSB7XG5cdFx0XHR0aGlzLmRvY3VtZW50XG5cdFx0XHRcdC5vZmYoIFwibW91c2Vtb3ZlLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSApXG5cdFx0XHRcdC5vZmYoIFwibW91c2V1cC5cIiArIHRoaXMud2lkZ2V0TmFtZSwgdGhpcy5fbW91c2VVcERlbGVnYXRlICk7XG5cdFx0fVxuXHR9LFxuXG5cdF9tb3VzZURvd246IGZ1bmN0aW9uKCBldmVudCApIHtcblxuXHRcdC8vIGRvbid0IGxldCBtb3JlIHRoYW4gb25lIHdpZGdldCBoYW5kbGUgbW91c2VTdGFydFxuXHRcdGlmICggbW91c2VIYW5kbGVkICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdHRoaXMuX21vdXNlTW92ZWQgPSBmYWxzZTtcblxuXHRcdC8vIFdlIG1heSBoYXZlIG1pc3NlZCBtb3VzZXVwIChvdXQgb2Ygd2luZG93KVxuXHRcdCggdGhpcy5fbW91c2VTdGFydGVkICYmIHRoaXMuX21vdXNlVXAoIGV2ZW50ICkgKTtcblxuXHRcdHRoaXMuX21vdXNlRG93bkV2ZW50ID0gZXZlbnQ7XG5cblx0XHR2YXIgdGhhdCA9IHRoaXMsXG5cdFx0XHRidG5Jc0xlZnQgPSAoIGV2ZW50LndoaWNoID09PSAxICksXG5cblx0XHRcdC8vIGV2ZW50LnRhcmdldC5ub2RlTmFtZSB3b3JrcyBhcm91bmQgYSBidWcgaW4gSUUgOCB3aXRoXG5cdFx0XHQvLyBkaXNhYmxlZCBpbnB1dHMgKCM3NjIwKVxuXHRcdFx0ZWxJc0NhbmNlbCA9ICggdHlwZW9mIHRoaXMub3B0aW9ucy5jYW5jZWwgPT09IFwic3RyaW5nXCIgJiYgZXZlbnQudGFyZ2V0Lm5vZGVOYW1lID9cblx0XHRcdFx0JCggZXZlbnQudGFyZ2V0ICkuY2xvc2VzdCggdGhpcy5vcHRpb25zLmNhbmNlbCApLmxlbmd0aCA6IGZhbHNlICk7XG5cdFx0aWYgKCAhYnRuSXNMZWZ0IHx8IGVsSXNDYW5jZWwgfHwgIXRoaXMuX21vdXNlQ2FwdHVyZSggZXZlbnQgKSApIHtcblx0XHRcdHJldHVybiB0cnVlO1xuXHRcdH1cblxuXHRcdHRoaXMubW91c2VEZWxheU1ldCA9ICF0aGlzLm9wdGlvbnMuZGVsYXk7XG5cdFx0aWYgKCAhdGhpcy5tb3VzZURlbGF5TWV0ICkge1xuXHRcdFx0dGhpcy5fbW91c2VEZWxheVRpbWVyID0gc2V0VGltZW91dCggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHRoYXQubW91c2VEZWxheU1ldCA9IHRydWU7XG5cdFx0XHR9LCB0aGlzLm9wdGlvbnMuZGVsYXkgKTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMuX21vdXNlRGlzdGFuY2VNZXQoIGV2ZW50ICkgJiYgdGhpcy5fbW91c2VEZWxheU1ldCggZXZlbnQgKSApIHtcblx0XHRcdHRoaXMuX21vdXNlU3RhcnRlZCA9ICggdGhpcy5fbW91c2VTdGFydCggZXZlbnQgKSAhPT0gZmFsc2UgKTtcblx0XHRcdGlmICggIXRoaXMuX21vdXNlU3RhcnRlZCApIHtcblx0XHRcdFx0ZXZlbnQucHJldmVudERlZmF1bHQoKTtcblx0XHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly8gQ2xpY2sgZXZlbnQgbWF5IG5ldmVyIGhhdmUgZmlyZWQgKEdlY2tvICYgT3BlcmEpXG5cdFx0aWYgKCB0cnVlID09PSAkLmRhdGEoIGV2ZW50LnRhcmdldCwgdGhpcy53aWRnZXROYW1lICsgXCIucHJldmVudENsaWNrRXZlbnRcIiApICkge1xuXHRcdFx0JC5yZW1vdmVEYXRhKCBldmVudC50YXJnZXQsIHRoaXMud2lkZ2V0TmFtZSArIFwiLnByZXZlbnRDbGlja0V2ZW50XCIgKTtcblx0XHR9XG5cblx0XHQvLyBUaGVzZSBkZWxlZ2F0ZXMgYXJlIHJlcXVpcmVkIHRvIGtlZXAgY29udGV4dFxuXHRcdHRoaXMuX21vdXNlTW92ZURlbGVnYXRlID0gZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0cmV0dXJuIHRoYXQuX21vdXNlTW92ZSggZXZlbnQgKTtcblx0XHR9O1xuXHRcdHRoaXMuX21vdXNlVXBEZWxlZ2F0ZSA9IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdHJldHVybiB0aGF0Ll9tb3VzZVVwKCBldmVudCApO1xuXHRcdH07XG5cblx0XHR0aGlzLmRvY3VtZW50XG5cdFx0XHQub24oIFwibW91c2Vtb3ZlLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSApXG5cdFx0XHQub24oIFwibW91c2V1cC5cIiArIHRoaXMud2lkZ2V0TmFtZSwgdGhpcy5fbW91c2VVcERlbGVnYXRlICk7XG5cblx0XHRldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXG5cdFx0bW91c2VIYW5kbGVkID0gdHJ1ZTtcblx0XHRyZXR1cm4gdHJ1ZTtcblx0fSxcblxuXHRfbW91c2VNb3ZlOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cblx0XHQvLyBPbmx5IGNoZWNrIGZvciBtb3VzZXVwcyBvdXRzaWRlIHRoZSBkb2N1bWVudCBpZiB5b3UndmUgbW92ZWQgaW5zaWRlIHRoZSBkb2N1bWVudFxuXHRcdC8vIGF0IGxlYXN0IG9uY2UuIFRoaXMgcHJldmVudHMgdGhlIGZpcmluZyBvZiBtb3VzZXVwIGluIHRoZSBjYXNlIG9mIElFPDksIHdoaWNoIHdpbGxcblx0XHQvLyBmaXJlIGEgbW91c2Vtb3ZlIGV2ZW50IGlmIGNvbnRlbnQgaXMgcGxhY2VkIHVuZGVyIHRoZSBjdXJzb3IuIFNlZSAjNzc3OFxuXHRcdC8vIFN1cHBvcnQ6IElFIDw5XG5cdFx0aWYgKCB0aGlzLl9tb3VzZU1vdmVkICkge1xuXG5cdFx0XHQvLyBJRSBtb3VzZXVwIGNoZWNrIC0gbW91c2V1cCBoYXBwZW5lZCB3aGVuIG1vdXNlIHdhcyBvdXQgb2Ygd2luZG93XG5cdFx0XHRpZiAoICQudWkuaWUgJiYgKCAhZG9jdW1lbnQuZG9jdW1lbnRNb2RlIHx8IGRvY3VtZW50LmRvY3VtZW50TW9kZSA8IDkgKSAmJlxuXHRcdFx0XHRcdCFldmVudC5idXR0b24gKSB7XG5cdFx0XHRcdHJldHVybiB0aGlzLl9tb3VzZVVwKCBldmVudCApO1xuXG5cdFx0XHQvLyBJZnJhbWUgbW91c2V1cCBjaGVjayAtIG1vdXNldXAgb2NjdXJyZWQgaW4gYW5vdGhlciBkb2N1bWVudFxuXHRcdFx0fSBlbHNlIGlmICggIWV2ZW50LndoaWNoICkge1xuXG5cdFx0XHRcdC8vIFN1cHBvcnQ6IFNhZmFyaSA8PTggLSA5XG5cdFx0XHRcdC8vIFNhZmFyaSBzZXRzIHdoaWNoIHRvIDAgaWYgeW91IHByZXNzIGFueSBvZiB0aGUgZm9sbG93aW5nIGtleXNcblx0XHRcdFx0Ly8gZHVyaW5nIGEgZHJhZyAoIzE0NDYxKVxuXHRcdFx0XHRpZiAoIGV2ZW50Lm9yaWdpbmFsRXZlbnQuYWx0S2V5IHx8IGV2ZW50Lm9yaWdpbmFsRXZlbnQuY3RybEtleSB8fFxuXHRcdFx0XHRcdFx0ZXZlbnQub3JpZ2luYWxFdmVudC5tZXRhS2V5IHx8IGV2ZW50Lm9yaWdpbmFsRXZlbnQuc2hpZnRLZXkgKSB7XG5cdFx0XHRcdFx0dGhpcy5pZ25vcmVNaXNzaW5nV2hpY2ggPSB0cnVlO1xuXHRcdFx0XHR9IGVsc2UgaWYgKCAhdGhpcy5pZ25vcmVNaXNzaW5nV2hpY2ggKSB7XG5cdFx0XHRcdFx0cmV0dXJuIHRoaXMuX21vdXNlVXAoIGV2ZW50ICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHRpZiAoIGV2ZW50LndoaWNoIHx8IGV2ZW50LmJ1dHRvbiApIHtcblx0XHRcdHRoaXMuX21vdXNlTW92ZWQgPSB0cnVlO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5fbW91c2VTdGFydGVkICkge1xuXHRcdFx0dGhpcy5fbW91c2VEcmFnKCBldmVudCApO1xuXHRcdFx0cmV0dXJuIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLl9tb3VzZURpc3RhbmNlTWV0KCBldmVudCApICYmIHRoaXMuX21vdXNlRGVsYXlNZXQoIGV2ZW50ICkgKSB7XG5cdFx0XHR0aGlzLl9tb3VzZVN0YXJ0ZWQgPVxuXHRcdFx0XHQoIHRoaXMuX21vdXNlU3RhcnQoIHRoaXMuX21vdXNlRG93bkV2ZW50LCBldmVudCApICE9PSBmYWxzZSApO1xuXHRcdFx0KCB0aGlzLl9tb3VzZVN0YXJ0ZWQgPyB0aGlzLl9tb3VzZURyYWcoIGV2ZW50ICkgOiB0aGlzLl9tb3VzZVVwKCBldmVudCApICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuICF0aGlzLl9tb3VzZVN0YXJ0ZWQ7XG5cdH0sXG5cblx0X21vdXNlVXA6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR0aGlzLmRvY3VtZW50XG5cdFx0XHQub2ZmKCBcIm1vdXNlbW92ZS5cIiArIHRoaXMud2lkZ2V0TmFtZSwgdGhpcy5fbW91c2VNb3ZlRGVsZWdhdGUgKVxuXHRcdFx0Lm9mZiggXCJtb3VzZXVwLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZVVwRGVsZWdhdGUgKTtcblxuXHRcdGlmICggdGhpcy5fbW91c2VTdGFydGVkICkge1xuXHRcdFx0dGhpcy5fbW91c2VTdGFydGVkID0gZmFsc2U7XG5cblx0XHRcdGlmICggZXZlbnQudGFyZ2V0ID09PSB0aGlzLl9tb3VzZURvd25FdmVudC50YXJnZXQgKSB7XG5cdFx0XHRcdCQuZGF0YSggZXZlbnQudGFyZ2V0LCB0aGlzLndpZGdldE5hbWUgKyBcIi5wcmV2ZW50Q2xpY2tFdmVudFwiLCB0cnVlICk7XG5cdFx0XHR9XG5cblx0XHRcdHRoaXMuX21vdXNlU3RvcCggZXZlbnQgKTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMuX21vdXNlRGVsYXlUaW1lciApIHtcblx0XHRcdGNsZWFyVGltZW91dCggdGhpcy5fbW91c2VEZWxheVRpbWVyICk7XG5cdFx0XHRkZWxldGUgdGhpcy5fbW91c2VEZWxheVRpbWVyO1xuXHRcdH1cblxuXHRcdHRoaXMuaWdub3JlTWlzc2luZ1doaWNoID0gZmFsc2U7XG5cdFx0bW91c2VIYW5kbGVkID0gZmFsc2U7XG5cdFx0ZXZlbnQucHJldmVudERlZmF1bHQoKTtcblx0fSxcblxuXHRfbW91c2VEaXN0YW5jZU1ldDogZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdHJldHVybiAoIE1hdGgubWF4KFxuXHRcdFx0XHRNYXRoLmFicyggdGhpcy5fbW91c2VEb3duRXZlbnQucGFnZVggLSBldmVudC5wYWdlWCApLFxuXHRcdFx0XHRNYXRoLmFicyggdGhpcy5fbW91c2VEb3duRXZlbnQucGFnZVkgLSBldmVudC5wYWdlWSApXG5cdFx0XHQpID49IHRoaXMub3B0aW9ucy5kaXN0YW5jZVxuXHRcdCk7XG5cdH0sXG5cblx0X21vdXNlRGVsYXlNZXQ6IGZ1bmN0aW9uKCAvKiBldmVudCAqLyApIHtcblx0XHRyZXR1cm4gdGhpcy5tb3VzZURlbGF5TWV0O1xuXHR9LFxuXG5cdC8vIFRoZXNlIGFyZSBwbGFjZWhvbGRlciBtZXRob2RzLCB0byBiZSBvdmVycmlkZW4gYnkgZXh0ZW5kaW5nIHBsdWdpblxuXHRfbW91c2VTdGFydDogZnVuY3Rpb24oIC8qIGV2ZW50ICovICkge30sXG5cdF9tb3VzZURyYWc6IGZ1bmN0aW9uKCAvKiBldmVudCAqLyApIHt9LFxuXHRfbW91c2VTdG9wOiBmdW5jdGlvbiggLyogZXZlbnQgKi8gKSB7fSxcblx0X21vdXNlQ2FwdHVyZTogZnVuY3Rpb24oIC8qIGV2ZW50ICovICkgeyByZXR1cm4gdHJ1ZTsgfVxufSApO1xuXG59ICkgKTtcbiIsIi8qIVxuICogalF1ZXJ5IFVJIFNvcnRhYmxlIDEuMTIuMVxuICogaHR0cDovL2pxdWVyeXVpLmNvbVxuICpcbiAqIENvcHlyaWdodCBqUXVlcnkgRm91bmRhdGlvbiBhbmQgb3RoZXIgY29udHJpYnV0b3JzXG4gKiBSZWxlYXNlZCB1bmRlciB0aGUgTUlUIGxpY2Vuc2UuXG4gKiBodHRwOi8vanF1ZXJ5Lm9yZy9saWNlbnNlXG4gKi9cblxuLy8+PmxhYmVsOiBTb3J0YWJsZVxuLy8+Pmdyb3VwOiBJbnRlcmFjdGlvbnNcbi8vPj5kZXNjcmlwdGlvbjogRW5hYmxlcyBpdGVtcyBpbiBhIGxpc3QgdG8gYmUgc29ydGVkIHVzaW5nIHRoZSBtb3VzZS5cbi8vPj5kb2NzOiBodHRwOi8vYXBpLmpxdWVyeXVpLmNvbS9zb3J0YWJsZS9cbi8vPj5kZW1vczogaHR0cDovL2pxdWVyeXVpLmNvbS9zb3J0YWJsZS9cbi8vPj5jc3Muc3RydWN0dXJlOiAuLi8uLi90aGVtZXMvYmFzZS9zb3J0YWJsZS5jc3NcblxuKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFtcblx0XHRcdFwianF1ZXJ5XCIsXG5cdFx0XHRcIi4vbW91c2VcIixcblx0XHRcdFwiLi4vZGF0YVwiLFxuXHRcdFx0XCIuLi9pZVwiLFxuXHRcdFx0XCIuLi9zY3JvbGwtcGFyZW50XCIsXG5cdFx0XHRcIi4uL3ZlcnNpb25cIixcblx0XHRcdFwiLi4vd2lkZ2V0XCJcblx0XHRdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSggZnVuY3Rpb24oICQgKSB7XG5cbnJldHVybiAkLndpZGdldCggXCJ1aS5zb3J0YWJsZVwiLCAkLnVpLm1vdXNlLCB7XG5cdHZlcnNpb246IFwiMS4xMi4xXCIsXG5cdHdpZGdldEV2ZW50UHJlZml4OiBcInNvcnRcIixcblx0cmVhZHk6IGZhbHNlLFxuXHRvcHRpb25zOiB7XG5cdFx0YXBwZW5kVG86IFwicGFyZW50XCIsXG5cdFx0YXhpczogZmFsc2UsXG5cdFx0Y29ubmVjdFdpdGg6IGZhbHNlLFxuXHRcdGNvbnRhaW5tZW50OiBmYWxzZSxcblx0XHRjdXJzb3I6IFwiYXV0b1wiLFxuXHRcdGN1cnNvckF0OiBmYWxzZSxcblx0XHRkcm9wT25FbXB0eTogdHJ1ZSxcblx0XHRmb3JjZVBsYWNlaG9sZGVyU2l6ZTogZmFsc2UsXG5cdFx0Zm9yY2VIZWxwZXJTaXplOiBmYWxzZSxcblx0XHRncmlkOiBmYWxzZSxcblx0XHRoYW5kbGU6IGZhbHNlLFxuXHRcdGhlbHBlcjogXCJvcmlnaW5hbFwiLFxuXHRcdGl0ZW1zOiBcIj4gKlwiLFxuXHRcdG9wYWNpdHk6IGZhbHNlLFxuXHRcdHBsYWNlaG9sZGVyOiBmYWxzZSxcblx0XHRyZXZlcnQ6IGZhbHNlLFxuXHRcdHNjcm9sbDogdHJ1ZSxcblx0XHRzY3JvbGxTZW5zaXRpdml0eTogMjAsXG5cdFx0c2Nyb2xsU3BlZWQ6IDIwLFxuXHRcdHNjb3BlOiBcImRlZmF1bHRcIixcblx0XHR0b2xlcmFuY2U6IFwiaW50ZXJzZWN0XCIsXG5cdFx0ekluZGV4OiAxMDAwLFxuXG5cdFx0Ly8gQ2FsbGJhY2tzXG5cdFx0YWN0aXZhdGU6IG51bGwsXG5cdFx0YmVmb3JlU3RvcDogbnVsbCxcblx0XHRjaGFuZ2U6IG51bGwsXG5cdFx0ZGVhY3RpdmF0ZTogbnVsbCxcblx0XHRvdXQ6IG51bGwsXG5cdFx0b3ZlcjogbnVsbCxcblx0XHRyZWNlaXZlOiBudWxsLFxuXHRcdHJlbW92ZTogbnVsbCxcblx0XHRzb3J0OiBudWxsLFxuXHRcdHN0YXJ0OiBudWxsLFxuXHRcdHN0b3A6IG51bGwsXG5cdFx0dXBkYXRlOiBudWxsXG5cdH0sXG5cblx0X2lzT3ZlckF4aXM6IGZ1bmN0aW9uKCB4LCByZWZlcmVuY2UsIHNpemUgKSB7XG5cdFx0cmV0dXJuICggeCA+PSByZWZlcmVuY2UgKSAmJiAoIHggPCAoIHJlZmVyZW5jZSArIHNpemUgKSApO1xuXHR9LFxuXG5cdF9pc0Zsb2F0aW5nOiBmdW5jdGlvbiggaXRlbSApIHtcblx0XHRyZXR1cm4gKCAvbGVmdHxyaWdodC8gKS50ZXN0KCBpdGVtLmNzcyggXCJmbG9hdFwiICkgKSB8fFxuXHRcdFx0KCAvaW5saW5lfHRhYmxlLWNlbGwvICkudGVzdCggaXRlbS5jc3MoIFwiZGlzcGxheVwiICkgKTtcblx0fSxcblxuXHRfY3JlYXRlOiBmdW5jdGlvbigpIHtcblx0XHR0aGlzLmNvbnRhaW5lckNhY2hlID0ge307XG5cdFx0dGhpcy5fYWRkQ2xhc3MoIFwidWktc29ydGFibGVcIiApO1xuXG5cdFx0Ly9HZXQgdGhlIGl0ZW1zXG5cdFx0dGhpcy5yZWZyZXNoKCk7XG5cblx0XHQvL0xldCdzIGRldGVybWluZSB0aGUgcGFyZW50J3Mgb2Zmc2V0XG5cdFx0dGhpcy5vZmZzZXQgPSB0aGlzLmVsZW1lbnQub2Zmc2V0KCk7XG5cblx0XHQvL0luaXRpYWxpemUgbW91c2UgZXZlbnRzIGZvciBpbnRlcmFjdGlvblxuXHRcdHRoaXMuX21vdXNlSW5pdCgpO1xuXG5cdFx0dGhpcy5fc2V0SGFuZGxlQ2xhc3NOYW1lKCk7XG5cblx0XHQvL1dlJ3JlIHJlYWR5IHRvIGdvXG5cdFx0dGhpcy5yZWFkeSA9IHRydWU7XG5cblx0fSxcblxuXHRfc2V0T3B0aW9uOiBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHR0aGlzLl9zdXBlcigga2V5LCB2YWx1ZSApO1xuXG5cdFx0aWYgKCBrZXkgPT09IFwiaGFuZGxlXCIgKSB7XG5cdFx0XHR0aGlzLl9zZXRIYW5kbGVDbGFzc05hbWUoKTtcblx0XHR9XG5cdH0sXG5cblx0X3NldEhhbmRsZUNsYXNzTmFtZTogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIHRoYXQgPSB0aGlzO1xuXHRcdHRoaXMuX3JlbW92ZUNsYXNzKCB0aGlzLmVsZW1lbnQuZmluZCggXCIudWktc29ydGFibGUtaGFuZGxlXCIgKSwgXCJ1aS1zb3J0YWJsZS1oYW5kbGVcIiApO1xuXHRcdCQuZWFjaCggdGhpcy5pdGVtcywgZnVuY3Rpb24oKSB7XG5cdFx0XHR0aGF0Ll9hZGRDbGFzcyhcblx0XHRcdFx0dGhpcy5pbnN0YW5jZS5vcHRpb25zLmhhbmRsZSA/XG5cdFx0XHRcdFx0dGhpcy5pdGVtLmZpbmQoIHRoaXMuaW5zdGFuY2Uub3B0aW9ucy5oYW5kbGUgKSA6XG5cdFx0XHRcdFx0dGhpcy5pdGVtLFxuXHRcdFx0XHRcInVpLXNvcnRhYmxlLWhhbmRsZVwiXG5cdFx0XHQpO1xuXHRcdH0gKTtcblx0fSxcblxuXHRfZGVzdHJveTogZnVuY3Rpb24oKSB7XG5cdFx0dGhpcy5fbW91c2VEZXN0cm95KCk7XG5cblx0XHRmb3IgKCB2YXIgaSA9IHRoaXMuaXRlbXMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHR0aGlzLml0ZW1zWyBpIF0uaXRlbS5yZW1vdmVEYXRhKCB0aGlzLndpZGdldE5hbWUgKyBcIi1pdGVtXCIgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfbW91c2VDYXB0dXJlOiBmdW5jdGlvbiggZXZlbnQsIG92ZXJyaWRlSGFuZGxlICkge1xuXHRcdHZhciBjdXJyZW50SXRlbSA9IG51bGwsXG5cdFx0XHR2YWxpZEhhbmRsZSA9IGZhbHNlLFxuXHRcdFx0dGhhdCA9IHRoaXM7XG5cblx0XHRpZiAoIHRoaXMucmV2ZXJ0aW5nICkge1xuXHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5vcHRpb25zLmRpc2FibGVkIHx8IHRoaXMub3B0aW9ucy50eXBlID09PSBcInN0YXRpY1wiICkge1xuXHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdH1cblxuXHRcdC8vV2UgaGF2ZSB0byByZWZyZXNoIHRoZSBpdGVtcyBkYXRhIG9uY2UgZmlyc3Rcblx0XHR0aGlzLl9yZWZyZXNoSXRlbXMoIGV2ZW50ICk7XG5cblx0XHQvL0ZpbmQgb3V0IGlmIHRoZSBjbGlja2VkIG5vZGUgKG9yIG9uZSBvZiBpdHMgcGFyZW50cykgaXMgYSBhY3R1YWwgaXRlbSBpbiB0aGlzLml0ZW1zXG5cdFx0JCggZXZlbnQudGFyZ2V0ICkucGFyZW50cygpLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0aWYgKCAkLmRhdGEoIHRoaXMsIHRoYXQud2lkZ2V0TmFtZSArIFwiLWl0ZW1cIiApID09PSB0aGF0ICkge1xuXHRcdFx0XHRjdXJyZW50SXRlbSA9ICQoIHRoaXMgKTtcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0XHRpZiAoICQuZGF0YSggZXZlbnQudGFyZ2V0LCB0aGF0LndpZGdldE5hbWUgKyBcIi1pdGVtXCIgKSA9PT0gdGhhdCApIHtcblx0XHRcdGN1cnJlbnRJdGVtID0gJCggZXZlbnQudGFyZ2V0ICk7XG5cdFx0fVxuXG5cdFx0aWYgKCAhY3VycmVudEl0ZW0gKSB7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fVxuXHRcdGlmICggdGhpcy5vcHRpb25zLmhhbmRsZSAmJiAhb3ZlcnJpZGVIYW5kbGUgKSB7XG5cdFx0XHQkKCB0aGlzLm9wdGlvbnMuaGFuZGxlLCBjdXJyZW50SXRlbSApLmZpbmQoIFwiKlwiICkuYWRkQmFjaygpLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRpZiAoIHRoaXMgPT09IGV2ZW50LnRhcmdldCApIHtcblx0XHRcdFx0XHR2YWxpZEhhbmRsZSA9IHRydWU7XG5cdFx0XHRcdH1cblx0XHRcdH0gKTtcblx0XHRcdGlmICggIXZhbGlkSGFuZGxlICkge1xuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0dGhpcy5jdXJyZW50SXRlbSA9IGN1cnJlbnRJdGVtO1xuXHRcdHRoaXMuX3JlbW92ZUN1cnJlbnRzRnJvbUl0ZW1zKCk7XG5cdFx0cmV0dXJuIHRydWU7XG5cblx0fSxcblxuXHRfbW91c2VTdGFydDogZnVuY3Rpb24oIGV2ZW50LCBvdmVycmlkZUhhbmRsZSwgbm9BY3RpdmF0aW9uICkge1xuXG5cdFx0dmFyIGksIGJvZHksXG5cdFx0XHRvID0gdGhpcy5vcHRpb25zO1xuXG5cdFx0dGhpcy5jdXJyZW50Q29udGFpbmVyID0gdGhpcztcblxuXHRcdC8vV2Ugb25seSBuZWVkIHRvIGNhbGwgcmVmcmVzaFBvc2l0aW9ucywgYmVjYXVzZSB0aGUgcmVmcmVzaEl0ZW1zIGNhbGwgaGFzIGJlZW4gbW92ZWQgdG9cblx0XHQvLyBtb3VzZUNhcHR1cmVcblx0XHR0aGlzLnJlZnJlc2hQb3NpdGlvbnMoKTtcblxuXHRcdC8vQ3JlYXRlIGFuZCBhcHBlbmQgdGhlIHZpc2libGUgaGVscGVyXG5cdFx0dGhpcy5oZWxwZXIgPSB0aGlzLl9jcmVhdGVIZWxwZXIoIGV2ZW50ICk7XG5cblx0XHQvL0NhY2hlIHRoZSBoZWxwZXIgc2l6ZVxuXHRcdHRoaXMuX2NhY2hlSGVscGVyUHJvcG9ydGlvbnMoKTtcblxuXHRcdC8qXG5cdFx0ICogLSBQb3NpdGlvbiBnZW5lcmF0aW9uIC1cblx0XHQgKiBUaGlzIGJsb2NrIGdlbmVyYXRlcyBldmVyeXRoaW5nIHBvc2l0aW9uIHJlbGF0ZWQgLSBpdCdzIHRoZSBjb3JlIG9mIGRyYWdnYWJsZXMuXG5cdFx0ICovXG5cblx0XHQvL0NhY2hlIHRoZSBtYXJnaW5zIG9mIHRoZSBvcmlnaW5hbCBlbGVtZW50XG5cdFx0dGhpcy5fY2FjaGVNYXJnaW5zKCk7XG5cblx0XHQvL0dldCB0aGUgbmV4dCBzY3JvbGxpbmcgcGFyZW50XG5cdFx0dGhpcy5zY3JvbGxQYXJlbnQgPSB0aGlzLmhlbHBlci5zY3JvbGxQYXJlbnQoKTtcblxuXHRcdC8vVGhlIGVsZW1lbnQncyBhYnNvbHV0ZSBwb3NpdGlvbiBvbiB0aGUgcGFnZSBtaW51cyBtYXJnaW5zXG5cdFx0dGhpcy5vZmZzZXQgPSB0aGlzLmN1cnJlbnRJdGVtLm9mZnNldCgpO1xuXHRcdHRoaXMub2Zmc2V0ID0ge1xuXHRcdFx0dG9wOiB0aGlzLm9mZnNldC50b3AgLSB0aGlzLm1hcmdpbnMudG9wLFxuXHRcdFx0bGVmdDogdGhpcy5vZmZzZXQubGVmdCAtIHRoaXMubWFyZ2lucy5sZWZ0XG5cdFx0fTtcblxuXHRcdCQuZXh0ZW5kKCB0aGlzLm9mZnNldCwge1xuXHRcdFx0Y2xpY2s6IHsgLy9XaGVyZSB0aGUgY2xpY2sgaGFwcGVuZWQsIHJlbGF0aXZlIHRvIHRoZSBlbGVtZW50XG5cdFx0XHRcdGxlZnQ6IGV2ZW50LnBhZ2VYIC0gdGhpcy5vZmZzZXQubGVmdCxcblx0XHRcdFx0dG9wOiBldmVudC5wYWdlWSAtIHRoaXMub2Zmc2V0LnRvcFxuXHRcdFx0fSxcblx0XHRcdHBhcmVudDogdGhpcy5fZ2V0UGFyZW50T2Zmc2V0KCksXG5cblx0XHRcdC8vIFRoaXMgaXMgYSByZWxhdGl2ZSB0byBhYnNvbHV0ZSBwb3NpdGlvbiBtaW51cyB0aGUgYWN0dWFsIHBvc2l0aW9uIGNhbGN1bGF0aW9uIC1cblx0XHRcdC8vIG9ubHkgdXNlZCBmb3IgcmVsYXRpdmUgcG9zaXRpb25lZCBoZWxwZXJcblx0XHRcdHJlbGF0aXZlOiB0aGlzLl9nZXRSZWxhdGl2ZU9mZnNldCgpXG5cdFx0fSApO1xuXG5cdFx0Ly8gT25seSBhZnRlciB3ZSBnb3QgdGhlIG9mZnNldCwgd2UgY2FuIGNoYW5nZSB0aGUgaGVscGVyJ3MgcG9zaXRpb24gdG8gYWJzb2x1dGVcblx0XHQvLyBUT0RPOiBTdGlsbCBuZWVkIHRvIGZpZ3VyZSBvdXQgYSB3YXkgdG8gbWFrZSByZWxhdGl2ZSBzb3J0aW5nIHBvc3NpYmxlXG5cdFx0dGhpcy5oZWxwZXIuY3NzKCBcInBvc2l0aW9uXCIsIFwiYWJzb2x1dGVcIiApO1xuXHRcdHRoaXMuY3NzUG9zaXRpb24gPSB0aGlzLmhlbHBlci5jc3MoIFwicG9zaXRpb25cIiApO1xuXG5cdFx0Ly9HZW5lcmF0ZSB0aGUgb3JpZ2luYWwgcG9zaXRpb25cblx0XHR0aGlzLm9yaWdpbmFsUG9zaXRpb24gPSB0aGlzLl9nZW5lcmF0ZVBvc2l0aW9uKCBldmVudCApO1xuXHRcdHRoaXMub3JpZ2luYWxQYWdlWCA9IGV2ZW50LnBhZ2VYO1xuXHRcdHRoaXMub3JpZ2luYWxQYWdlWSA9IGV2ZW50LnBhZ2VZO1xuXG5cdFx0Ly9BZGp1c3QgdGhlIG1vdXNlIG9mZnNldCByZWxhdGl2ZSB0byB0aGUgaGVscGVyIGlmIFwiY3Vyc29yQXRcIiBpcyBzdXBwbGllZFxuXHRcdCggby5jdXJzb3JBdCAmJiB0aGlzLl9hZGp1c3RPZmZzZXRGcm9tSGVscGVyKCBvLmN1cnNvckF0ICkgKTtcblxuXHRcdC8vQ2FjaGUgdGhlIGZvcm1lciBET00gcG9zaXRpb25cblx0XHR0aGlzLmRvbVBvc2l0aW9uID0ge1xuXHRcdFx0cHJldjogdGhpcy5jdXJyZW50SXRlbS5wcmV2KClbIDAgXSxcblx0XHRcdHBhcmVudDogdGhpcy5jdXJyZW50SXRlbS5wYXJlbnQoKVsgMCBdXG5cdFx0fTtcblxuXHRcdC8vIElmIHRoZSBoZWxwZXIgaXMgbm90IHRoZSBvcmlnaW5hbCwgaGlkZSB0aGUgb3JpZ2luYWwgc28gaXQncyBub3QgcGxheWluZyBhbnkgcm9sZSBkdXJpbmdcblx0XHQvLyB0aGUgZHJhZywgd29uJ3QgY2F1c2UgYW55dGhpbmcgYmFkIHRoaXMgd2F5XG5cdFx0aWYgKCB0aGlzLmhlbHBlclsgMCBdICE9PSB0aGlzLmN1cnJlbnRJdGVtWyAwIF0gKSB7XG5cdFx0XHR0aGlzLmN1cnJlbnRJdGVtLmhpZGUoKTtcblx0XHR9XG5cblx0XHQvL0NyZWF0ZSB0aGUgcGxhY2Vob2xkZXJcblx0XHR0aGlzLl9jcmVhdGVQbGFjZWhvbGRlcigpO1xuXG5cdFx0Ly9TZXQgYSBjb250YWlubWVudCBpZiBnaXZlbiBpbiB0aGUgb3B0aW9uc1xuXHRcdGlmICggby5jb250YWlubWVudCApIHtcblx0XHRcdHRoaXMuX3NldENvbnRhaW5tZW50KCk7XG5cdFx0fVxuXG5cdFx0aWYgKCBvLmN1cnNvciAmJiBvLmN1cnNvciAhPT0gXCJhdXRvXCIgKSB7IC8vIGN1cnNvciBvcHRpb25cblx0XHRcdGJvZHkgPSB0aGlzLmRvY3VtZW50LmZpbmQoIFwiYm9keVwiICk7XG5cblx0XHRcdC8vIFN1cHBvcnQ6IElFXG5cdFx0XHR0aGlzLnN0b3JlZEN1cnNvciA9IGJvZHkuY3NzKCBcImN1cnNvclwiICk7XG5cdFx0XHRib2R5LmNzcyggXCJjdXJzb3JcIiwgby5jdXJzb3IgKTtcblxuXHRcdFx0dGhpcy5zdG9yZWRTdHlsZXNoZWV0ID1cblx0XHRcdFx0JCggXCI8c3R5bGU+KnsgY3Vyc29yOiBcIiArIG8uY3Vyc29yICsgXCIgIWltcG9ydGFudDsgfTwvc3R5bGU+XCIgKS5hcHBlbmRUbyggYm9keSApO1xuXHRcdH1cblxuXHRcdGlmICggby5vcGFjaXR5ICkgeyAvLyBvcGFjaXR5IG9wdGlvblxuXHRcdFx0aWYgKCB0aGlzLmhlbHBlci5jc3MoIFwib3BhY2l0eVwiICkgKSB7XG5cdFx0XHRcdHRoaXMuX3N0b3JlZE9wYWNpdHkgPSB0aGlzLmhlbHBlci5jc3MoIFwib3BhY2l0eVwiICk7XG5cdFx0XHR9XG5cdFx0XHR0aGlzLmhlbHBlci5jc3MoIFwib3BhY2l0eVwiLCBvLm9wYWNpdHkgKTtcblx0XHR9XG5cblx0XHRpZiAoIG8uekluZGV4ICkgeyAvLyB6SW5kZXggb3B0aW9uXG5cdFx0XHRpZiAoIHRoaXMuaGVscGVyLmNzcyggXCJ6SW5kZXhcIiApICkge1xuXHRcdFx0XHR0aGlzLl9zdG9yZWRaSW5kZXggPSB0aGlzLmhlbHBlci5jc3MoIFwiekluZGV4XCIgKTtcblx0XHRcdH1cblx0XHRcdHRoaXMuaGVscGVyLmNzcyggXCJ6SW5kZXhcIiwgby56SW5kZXggKTtcblx0XHR9XG5cblx0XHQvL1ByZXBhcmUgc2Nyb2xsaW5nXG5cdFx0aWYgKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdICE9PSB0aGlzLmRvY3VtZW50WyAwIF0gJiZcblx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS50YWdOYW1lICE9PSBcIkhUTUxcIiApIHtcblx0XHRcdHRoaXMub3ZlcmZsb3dPZmZzZXQgPSB0aGlzLnNjcm9sbFBhcmVudC5vZmZzZXQoKTtcblx0XHR9XG5cblx0XHQvL0NhbGwgY2FsbGJhY2tzXG5cdFx0dGhpcy5fdHJpZ2dlciggXCJzdGFydFwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblxuXHRcdC8vUmVjYWNoZSB0aGUgaGVscGVyIHNpemVcblx0XHRpZiAoICF0aGlzLl9wcmVzZXJ2ZUhlbHBlclByb3BvcnRpb25zICkge1xuXHRcdFx0dGhpcy5fY2FjaGVIZWxwZXJQcm9wb3J0aW9ucygpO1xuXHRcdH1cblxuXHRcdC8vUG9zdCBcImFjdGl2YXRlXCIgZXZlbnRzIHRvIHBvc3NpYmxlIGNvbnRhaW5lcnNcblx0XHRpZiAoICFub0FjdGl2YXRpb24gKSB7XG5cdFx0XHRmb3IgKCBpID0gdGhpcy5jb250YWluZXJzLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5fdHJpZ2dlciggXCJhY3RpdmF0ZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCB0aGlzICkgKTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvL1ByZXBhcmUgcG9zc2libGUgZHJvcHBhYmxlc1xuXHRcdGlmICggJC51aS5kZG1hbmFnZXIgKSB7XG5cdFx0XHQkLnVpLmRkbWFuYWdlci5jdXJyZW50ID0gdGhpcztcblx0XHR9XG5cblx0XHRpZiAoICQudWkuZGRtYW5hZ2VyICYmICFvLmRyb3BCZWhhdmlvdXIgKSB7XG5cdFx0XHQkLnVpLmRkbWFuYWdlci5wcmVwYXJlT2Zmc2V0cyggdGhpcywgZXZlbnQgKTtcblx0XHR9XG5cblx0XHR0aGlzLmRyYWdnaW5nID0gdHJ1ZTtcblxuXHRcdHRoaXMuX2FkZENsYXNzKCB0aGlzLmhlbHBlciwgXCJ1aS1zb3J0YWJsZS1oZWxwZXJcIiApO1xuXG5cdFx0Ly8gRXhlY3V0ZSB0aGUgZHJhZyBvbmNlIC0gdGhpcyBjYXVzZXMgdGhlIGhlbHBlciBub3QgdG8gYmUgdmlzaWJsZWJlZm9yZSBnZXR0aW5nIGl0c1xuXHRcdC8vIGNvcnJlY3QgcG9zaXRpb25cblx0XHR0aGlzLl9tb3VzZURyYWcoIGV2ZW50ICk7XG5cdFx0cmV0dXJuIHRydWU7XG5cblx0fSxcblxuXHRfbW91c2VEcmFnOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0dmFyIGksIGl0ZW0sIGl0ZW1FbGVtZW50LCBpbnRlcnNlY3Rpb24sXG5cdFx0XHRvID0gdGhpcy5vcHRpb25zLFxuXHRcdFx0c2Nyb2xsZWQgPSBmYWxzZTtcblxuXHRcdC8vQ29tcHV0ZSB0aGUgaGVscGVycyBwb3NpdGlvblxuXHRcdHRoaXMucG9zaXRpb24gPSB0aGlzLl9nZW5lcmF0ZVBvc2l0aW9uKCBldmVudCApO1xuXHRcdHRoaXMucG9zaXRpb25BYnMgPSB0aGlzLl9jb252ZXJ0UG9zaXRpb25UbyggXCJhYnNvbHV0ZVwiICk7XG5cblx0XHRpZiAoICF0aGlzLmxhc3RQb3NpdGlvbkFicyApIHtcblx0XHRcdHRoaXMubGFzdFBvc2l0aW9uQWJzID0gdGhpcy5wb3NpdGlvbkFicztcblx0XHR9XG5cblx0XHQvL0RvIHNjcm9sbGluZ1xuXHRcdGlmICggdGhpcy5vcHRpb25zLnNjcm9sbCApIHtcblx0XHRcdGlmICggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSAhPT0gdGhpcy5kb2N1bWVudFsgMCBdICYmXG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS50YWdOYW1lICE9PSBcIkhUTUxcIiApIHtcblxuXHRcdFx0XHRpZiAoICggdGhpcy5vdmVyZmxvd09mZnNldC50b3AgKyB0aGlzLnNjcm9sbFBhcmVudFsgMCBdLm9mZnNldEhlaWdodCApIC1cblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VZIDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbFRvcCA9XG5cdFx0XHRcdFx0XHRzY3JvbGxlZCA9IHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0uc2Nyb2xsVG9wICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0fSBlbHNlIGlmICggZXZlbnQucGFnZVkgLSB0aGlzLm92ZXJmbG93T2Zmc2V0LnRvcCA8IG8uc2Nyb2xsU2Vuc2l0aXZpdHkgKSB7XG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5zY3JvbGxUb3AgPVxuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbFRvcCAtIG8uc2Nyb2xsU3BlZWQ7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRpZiAoICggdGhpcy5vdmVyZmxvd09mZnNldC5sZWZ0ICsgdGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5vZmZzZXRXaWR0aCApIC1cblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VYIDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbExlZnQgPSBzY3JvbGxlZCA9XG5cdFx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbExlZnQgKyBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHR9IGVsc2UgaWYgKCBldmVudC5wYWdlWCAtIHRoaXMub3ZlcmZsb3dPZmZzZXQubGVmdCA8IG8uc2Nyb2xsU2Vuc2l0aXZpdHkgKSB7XG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5zY3JvbGxMZWZ0ID0gc2Nyb2xsZWQgPVxuXHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5zY3JvbGxMZWZ0IC0gby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0fVxuXG5cdFx0XHR9IGVsc2Uge1xuXG5cdFx0XHRcdGlmICggZXZlbnQucGFnZVkgLSB0aGlzLmRvY3VtZW50LnNjcm9sbFRvcCgpIDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0XHRzY3JvbGxlZCA9IHRoaXMuZG9jdW1lbnQuc2Nyb2xsVG9wKCB0aGlzLmRvY3VtZW50LnNjcm9sbFRvcCgpIC0gby5zY3JvbGxTcGVlZCApO1xuXHRcdFx0XHR9IGVsc2UgaWYgKCB0aGlzLndpbmRvdy5oZWlnaHQoKSAtICggZXZlbnQucGFnZVkgLSB0aGlzLmRvY3VtZW50LnNjcm9sbFRvcCgpICkgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0XHRzY3JvbGxlZCA9IHRoaXMuZG9jdW1lbnQuc2Nyb2xsVG9wKCB0aGlzLmRvY3VtZW50LnNjcm9sbFRvcCgpICsgby5zY3JvbGxTcGVlZCApO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWYgKCBldmVudC5wYWdlWCAtIHRoaXMuZG9jdW1lbnQuc2Nyb2xsTGVmdCgpIDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0XHRzY3JvbGxlZCA9IHRoaXMuZG9jdW1lbnQuc2Nyb2xsTGVmdChcblx0XHRcdFx0XHRcdHRoaXMuZG9jdW1lbnQuc2Nyb2xsTGVmdCgpIC0gby5zY3JvbGxTcGVlZFxuXHRcdFx0XHRcdCk7XG5cdFx0XHRcdH0gZWxzZSBpZiAoIHRoaXMud2luZG93LndpZHRoKCkgLSAoIGV2ZW50LnBhZ2VYIC0gdGhpcy5kb2N1bWVudC5zY3JvbGxMZWZ0KCkgKSA8XG5cdFx0XHRcdFx0XHRvLnNjcm9sbFNlbnNpdGl2aXR5ICkge1xuXHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5kb2N1bWVudC5zY3JvbGxMZWZ0KFxuXHRcdFx0XHRcdFx0dGhpcy5kb2N1bWVudC5zY3JvbGxMZWZ0KCkgKyBvLnNjcm9sbFNwZWVkXG5cdFx0XHRcdFx0KTtcblx0XHRcdFx0fVxuXG5cdFx0XHR9XG5cblx0XHRcdGlmICggc2Nyb2xsZWQgIT09IGZhbHNlICYmICQudWkuZGRtYW5hZ2VyICYmICFvLmRyb3BCZWhhdmlvdXIgKSB7XG5cdFx0XHRcdCQudWkuZGRtYW5hZ2VyLnByZXBhcmVPZmZzZXRzKCB0aGlzLCBldmVudCApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vUmVnZW5lcmF0ZSB0aGUgYWJzb2x1dGUgcG9zaXRpb24gdXNlZCBmb3IgcG9zaXRpb24gY2hlY2tzXG5cdFx0dGhpcy5wb3NpdGlvbkFicyA9IHRoaXMuX2NvbnZlcnRQb3NpdGlvblRvKCBcImFic29sdXRlXCIgKTtcblxuXHRcdC8vU2V0IHRoZSBoZWxwZXIgcG9zaXRpb25cblx0XHRpZiAoICF0aGlzLm9wdGlvbnMuYXhpcyB8fCB0aGlzLm9wdGlvbnMuYXhpcyAhPT0gXCJ5XCIgKSB7XG5cdFx0XHR0aGlzLmhlbHBlclsgMCBdLnN0eWxlLmxlZnQgPSB0aGlzLnBvc2l0aW9uLmxlZnQgKyBcInB4XCI7XG5cdFx0fVxuXHRcdGlmICggIXRoaXMub3B0aW9ucy5heGlzIHx8IHRoaXMub3B0aW9ucy5heGlzICE9PSBcInhcIiApIHtcblx0XHRcdHRoaXMuaGVscGVyWyAwIF0uc3R5bGUudG9wID0gdGhpcy5wb3NpdGlvbi50b3AgKyBcInB4XCI7XG5cdFx0fVxuXG5cdFx0Ly9SZWFycmFuZ2Vcblx0XHRmb3IgKCBpID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblxuXHRcdFx0Ly9DYWNoZSB2YXJpYWJsZXMgYW5kIGludGVyc2VjdGlvbiwgY29udGludWUgaWYgbm8gaW50ZXJzZWN0aW9uXG5cdFx0XHRpdGVtID0gdGhpcy5pdGVtc1sgaSBdO1xuXHRcdFx0aXRlbUVsZW1lbnQgPSBpdGVtLml0ZW1bIDAgXTtcblx0XHRcdGludGVyc2VjdGlvbiA9IHRoaXMuX2ludGVyc2VjdHNXaXRoUG9pbnRlciggaXRlbSApO1xuXHRcdFx0aWYgKCAhaW50ZXJzZWN0aW9uICkge1xuXHRcdFx0XHRjb250aW51ZTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gT25seSBwdXQgdGhlIHBsYWNlaG9sZGVyIGluc2lkZSB0aGUgY3VycmVudCBDb250YWluZXIsIHNraXAgYWxsXG5cdFx0XHQvLyBpdGVtcyBmcm9tIG90aGVyIGNvbnRhaW5lcnMuIFRoaXMgd29ya3MgYmVjYXVzZSB3aGVuIG1vdmluZ1xuXHRcdFx0Ly8gYW4gaXRlbSBmcm9tIG9uZSBjb250YWluZXIgdG8gYW5vdGhlciB0aGVcblx0XHRcdC8vIGN1cnJlbnRDb250YWluZXIgaXMgc3dpdGNoZWQgYmVmb3JlIHRoZSBwbGFjZWhvbGRlciBpcyBtb3ZlZC5cblx0XHRcdC8vXG5cdFx0XHQvLyBXaXRob3V0IHRoaXMsIG1vdmluZyBpdGVtcyBpbiBcInN1Yi1zb3J0YWJsZXNcIiBjYW4gY2F1c2Vcblx0XHRcdC8vIHRoZSBwbGFjZWhvbGRlciB0byBqaXR0ZXIgYmV0d2VlbiB0aGUgb3V0ZXIgYW5kIGlubmVyIGNvbnRhaW5lci5cblx0XHRcdGlmICggaXRlbS5pbnN0YW5jZSAhPT0gdGhpcy5jdXJyZW50Q29udGFpbmVyICkge1xuXHRcdFx0XHRjb250aW51ZTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gQ2Fubm90IGludGVyc2VjdCB3aXRoIGl0c2VsZlxuXHRcdFx0Ly8gbm8gdXNlbGVzcyBhY3Rpb25zIHRoYXQgaGF2ZSBiZWVuIGRvbmUgYmVmb3JlXG5cdFx0XHQvLyBubyBhY3Rpb24gaWYgdGhlIGl0ZW0gbW92ZWQgaXMgdGhlIHBhcmVudCBvZiB0aGUgaXRlbSBjaGVja2VkXG5cdFx0XHRpZiAoIGl0ZW1FbGVtZW50ICE9PSB0aGlzLmN1cnJlbnRJdGVtWyAwIF0gJiZcblx0XHRcdFx0dGhpcy5wbGFjZWhvbGRlclsgaW50ZXJzZWN0aW9uID09PSAxID8gXCJuZXh0XCIgOiBcInByZXZcIiBdKClbIDAgXSAhPT0gaXRlbUVsZW1lbnQgJiZcblx0XHRcdFx0ISQuY29udGFpbnMoIHRoaXMucGxhY2Vob2xkZXJbIDAgXSwgaXRlbUVsZW1lbnQgKSAmJlxuXHRcdFx0XHQoIHRoaXMub3B0aW9ucy50eXBlID09PSBcInNlbWktZHluYW1pY1wiID9cblx0XHRcdFx0XHQhJC5jb250YWlucyggdGhpcy5lbGVtZW50WyAwIF0sIGl0ZW1FbGVtZW50ICkgOlxuXHRcdFx0XHRcdHRydWVcblx0XHRcdFx0KVxuXHRcdFx0KSB7XG5cblx0XHRcdFx0dGhpcy5kaXJlY3Rpb24gPSBpbnRlcnNlY3Rpb24gPT09IDEgPyBcImRvd25cIiA6IFwidXBcIjtcblxuXHRcdFx0XHRpZiAoIHRoaXMub3B0aW9ucy50b2xlcmFuY2UgPT09IFwicG9pbnRlclwiIHx8IHRoaXMuX2ludGVyc2VjdHNXaXRoU2lkZXMoIGl0ZW0gKSApIHtcblx0XHRcdFx0XHR0aGlzLl9yZWFycmFuZ2UoIGV2ZW50LCBpdGVtICk7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0YnJlYWs7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKCBcImNoYW5nZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly9Qb3N0IGV2ZW50cyB0byBjb250YWluZXJzXG5cdFx0dGhpcy5fY29udGFjdENvbnRhaW5lcnMoIGV2ZW50ICk7XG5cblx0XHQvL0ludGVyY29ubmVjdCB3aXRoIGRyb3BwYWJsZXNcblx0XHRpZiAoICQudWkuZGRtYW5hZ2VyICkge1xuXHRcdFx0JC51aS5kZG1hbmFnZXIuZHJhZyggdGhpcywgZXZlbnQgKTtcblx0XHR9XG5cblx0XHQvL0NhbGwgY2FsbGJhY2tzXG5cdFx0dGhpcy5fdHJpZ2dlciggXCJzb3J0XCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSApO1xuXG5cdFx0dGhpcy5sYXN0UG9zaXRpb25BYnMgPSB0aGlzLnBvc2l0aW9uQWJzO1xuXHRcdHJldHVybiBmYWxzZTtcblxuXHR9LFxuXG5cdF9tb3VzZVN0b3A6IGZ1bmN0aW9uKCBldmVudCwgbm9Qcm9wYWdhdGlvbiApIHtcblxuXHRcdGlmICggIWV2ZW50ICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdC8vSWYgd2UgYXJlIHVzaW5nIGRyb3BwYWJsZXMsIGluZm9ybSB0aGUgbWFuYWdlciBhYm91dCB0aGUgZHJvcFxuXHRcdGlmICggJC51aS5kZG1hbmFnZXIgJiYgIXRoaXMub3B0aW9ucy5kcm9wQmVoYXZpb3VyICkge1xuXHRcdFx0JC51aS5kZG1hbmFnZXIuZHJvcCggdGhpcywgZXZlbnQgKTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMub3B0aW9ucy5yZXZlcnQgKSB7XG5cdFx0XHR2YXIgdGhhdCA9IHRoaXMsXG5cdFx0XHRcdGN1ciA9IHRoaXMucGxhY2Vob2xkZXIub2Zmc2V0KCksXG5cdFx0XHRcdGF4aXMgPSB0aGlzLm9wdGlvbnMuYXhpcyxcblx0XHRcdFx0YW5pbWF0aW9uID0ge307XG5cblx0XHRcdGlmICggIWF4aXMgfHwgYXhpcyA9PT0gXCJ4XCIgKSB7XG5cdFx0XHRcdGFuaW1hdGlvbi5sZWZ0ID0gY3VyLmxlZnQgLSB0aGlzLm9mZnNldC5wYXJlbnQubGVmdCAtIHRoaXMubWFyZ2lucy5sZWZ0ICtcblx0XHRcdFx0XHQoIHRoaXMub2Zmc2V0UGFyZW50WyAwIF0gPT09IHRoaXMuZG9jdW1lbnRbIDAgXS5ib2R5ID9cblx0XHRcdFx0XHRcdDAgOlxuXHRcdFx0XHRcdFx0dGhpcy5vZmZzZXRQYXJlbnRbIDAgXS5zY3JvbGxMZWZ0XG5cdFx0XHRcdFx0KTtcblx0XHRcdH1cblx0XHRcdGlmICggIWF4aXMgfHwgYXhpcyA9PT0gXCJ5XCIgKSB7XG5cdFx0XHRcdGFuaW1hdGlvbi50b3AgPSBjdXIudG9wIC0gdGhpcy5vZmZzZXQucGFyZW50LnRvcCAtIHRoaXMubWFyZ2lucy50b3AgK1xuXHRcdFx0XHRcdCggdGhpcy5vZmZzZXRQYXJlbnRbIDAgXSA9PT0gdGhpcy5kb2N1bWVudFsgMCBdLmJvZHkgP1xuXHRcdFx0XHRcdFx0MCA6XG5cdFx0XHRcdFx0XHR0aGlzLm9mZnNldFBhcmVudFsgMCBdLnNjcm9sbFRvcFxuXHRcdFx0XHRcdCk7XG5cdFx0XHR9XG5cdFx0XHR0aGlzLnJldmVydGluZyA9IHRydWU7XG5cdFx0XHQkKCB0aGlzLmhlbHBlciApLmFuaW1hdGUoXG5cdFx0XHRcdGFuaW1hdGlvbixcblx0XHRcdFx0cGFyc2VJbnQoIHRoaXMub3B0aW9ucy5yZXZlcnQsIDEwICkgfHwgNTAwLFxuXHRcdFx0XHRmdW5jdGlvbigpIHtcblx0XHRcdFx0XHR0aGF0Ll9jbGVhciggZXZlbnQgKTtcblx0XHRcdFx0fVxuXHRcdFx0KTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0dGhpcy5fY2xlYXIoIGV2ZW50LCBub1Byb3BhZ2F0aW9uICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIGZhbHNlO1xuXG5cdH0sXG5cblx0Y2FuY2VsOiBmdW5jdGlvbigpIHtcblxuXHRcdGlmICggdGhpcy5kcmFnZ2luZyApIHtcblxuXHRcdFx0dGhpcy5fbW91c2VVcCggbmV3ICQuRXZlbnQoIFwibW91c2V1cFwiLCB7IHRhcmdldDogbnVsbCB9ICkgKTtcblxuXHRcdFx0aWYgKCB0aGlzLm9wdGlvbnMuaGVscGVyID09PSBcIm9yaWdpbmFsXCIgKSB7XG5cdFx0XHRcdHRoaXMuY3VycmVudEl0ZW0uY3NzKCB0aGlzLl9zdG9yZWRDU1MgKTtcblx0XHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoIHRoaXMuY3VycmVudEl0ZW0sIFwidWktc29ydGFibGUtaGVscGVyXCIgKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdHRoaXMuY3VycmVudEl0ZW0uc2hvdygpO1xuXHRcdFx0fVxuXG5cdFx0XHQvL1Bvc3QgZGVhY3RpdmF0aW5nIGV2ZW50cyB0byBjb250YWluZXJzXG5cdFx0XHRmb3IgKCB2YXIgaSA9IHRoaXMuY29udGFpbmVycy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uX3RyaWdnZXIoIFwiZGVhY3RpdmF0ZVwiLCBudWxsLCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0XHRpZiAoIHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLm92ZXIgKSB7XG5cdFx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uX3RyaWdnZXIoIFwib3V0XCIsIG51bGwsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUub3ZlciA9IDA7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdH1cblxuXHRcdGlmICggdGhpcy5wbGFjZWhvbGRlciApIHtcblxuXHRcdFx0Ly8kKHRoaXMucGxhY2Vob2xkZXJbMF0pLnJlbW92ZSgpOyB3b3VsZCBoYXZlIGJlZW4gdGhlIGpRdWVyeSB3YXkgLSB1bmZvcnR1bmF0ZWx5LFxuXHRcdFx0Ly8gaXQgdW5iaW5kcyBBTEwgZXZlbnRzIGZyb20gdGhlIG9yaWdpbmFsIG5vZGUhXG5cdFx0XHRpZiAoIHRoaXMucGxhY2Vob2xkZXJbIDAgXS5wYXJlbnROb2RlICkge1xuXHRcdFx0XHR0aGlzLnBsYWNlaG9sZGVyWyAwIF0ucGFyZW50Tm9kZS5yZW1vdmVDaGlsZCggdGhpcy5wbGFjZWhvbGRlclsgMCBdICk7XG5cdFx0XHR9XG5cdFx0XHRpZiAoIHRoaXMub3B0aW9ucy5oZWxwZXIgIT09IFwib3JpZ2luYWxcIiAmJiB0aGlzLmhlbHBlciAmJlxuXHRcdFx0XHRcdHRoaXMuaGVscGVyWyAwIF0ucGFyZW50Tm9kZSApIHtcblx0XHRcdFx0dGhpcy5oZWxwZXIucmVtb3ZlKCk7XG5cdFx0XHR9XG5cblx0XHRcdCQuZXh0ZW5kKCB0aGlzLCB7XG5cdFx0XHRcdGhlbHBlcjogbnVsbCxcblx0XHRcdFx0ZHJhZ2dpbmc6IGZhbHNlLFxuXHRcdFx0XHRyZXZlcnRpbmc6IGZhbHNlLFxuXHRcdFx0XHRfbm9GaW5hbFNvcnQ6IG51bGxcblx0XHRcdH0gKTtcblxuXHRcdFx0aWYgKCB0aGlzLmRvbVBvc2l0aW9uLnByZXYgKSB7XG5cdFx0XHRcdCQoIHRoaXMuZG9tUG9zaXRpb24ucHJldiApLmFmdGVyKCB0aGlzLmN1cnJlbnRJdGVtICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHQkKCB0aGlzLmRvbVBvc2l0aW9uLnBhcmVudCApLnByZXBlbmQoIHRoaXMuY3VycmVudEl0ZW0gKTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblxuXHR9LFxuXG5cdHNlcmlhbGl6ZTogZnVuY3Rpb24oIG8gKSB7XG5cblx0XHR2YXIgaXRlbXMgPSB0aGlzLl9nZXRJdGVtc0FzalF1ZXJ5KCBvICYmIG8uY29ubmVjdGVkICksXG5cdFx0XHRzdHIgPSBbXTtcblx0XHRvID0gbyB8fCB7fTtcblxuXHRcdCQoIGl0ZW1zICkuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHR2YXIgcmVzID0gKCAkKCBvLml0ZW0gfHwgdGhpcyApLmF0dHIoIG8uYXR0cmlidXRlIHx8IFwiaWRcIiApIHx8IFwiXCIgKVxuXHRcdFx0XHQubWF0Y2goIG8uZXhwcmVzc2lvbiB8fCAoIC8oLispW1xcLT1fXSguKykvICkgKTtcblx0XHRcdGlmICggcmVzICkge1xuXHRcdFx0XHRzdHIucHVzaChcblx0XHRcdFx0XHQoIG8ua2V5IHx8IHJlc1sgMSBdICsgXCJbXVwiICkgK1xuXHRcdFx0XHRcdFwiPVwiICsgKCBvLmtleSAmJiBvLmV4cHJlc3Npb24gPyByZXNbIDEgXSA6IHJlc1sgMiBdICkgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cblx0XHRpZiAoICFzdHIubGVuZ3RoICYmIG8ua2V5ICkge1xuXHRcdFx0c3RyLnB1c2goIG8ua2V5ICsgXCI9XCIgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gc3RyLmpvaW4oIFwiJlwiICk7XG5cblx0fSxcblxuXHR0b0FycmF5OiBmdW5jdGlvbiggbyApIHtcblxuXHRcdHZhciBpdGVtcyA9IHRoaXMuX2dldEl0ZW1zQXNqUXVlcnkoIG8gJiYgby5jb25uZWN0ZWQgKSxcblx0XHRcdHJldCA9IFtdO1xuXG5cdFx0byA9IG8gfHwge307XG5cblx0XHRpdGVtcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdHJldC5wdXNoKCAkKCBvLml0ZW0gfHwgdGhpcyApLmF0dHIoIG8uYXR0cmlidXRlIHx8IFwiaWRcIiApIHx8IFwiXCIgKTtcblx0XHR9ICk7XG5cdFx0cmV0dXJuIHJldDtcblxuXHR9LFxuXG5cdC8qIEJlIGNhcmVmdWwgd2l0aCB0aGUgZm9sbG93aW5nIGNvcmUgZnVuY3Rpb25zICovXG5cdF9pbnRlcnNlY3RzV2l0aDogZnVuY3Rpb24oIGl0ZW0gKSB7XG5cblx0XHR2YXIgeDEgPSB0aGlzLnBvc2l0aW9uQWJzLmxlZnQsXG5cdFx0XHR4MiA9IHgxICsgdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy53aWR0aCxcblx0XHRcdHkxID0gdGhpcy5wb3NpdGlvbkFicy50b3AsXG5cdFx0XHR5MiA9IHkxICsgdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy5oZWlnaHQsXG5cdFx0XHRsID0gaXRlbS5sZWZ0LFxuXHRcdFx0ciA9IGwgKyBpdGVtLndpZHRoLFxuXHRcdFx0dCA9IGl0ZW0udG9wLFxuXHRcdFx0YiA9IHQgKyBpdGVtLmhlaWdodCxcblx0XHRcdGR5Q2xpY2sgPSB0aGlzLm9mZnNldC5jbGljay50b3AsXG5cdFx0XHRkeENsaWNrID0gdGhpcy5vZmZzZXQuY2xpY2subGVmdCxcblx0XHRcdGlzT3ZlckVsZW1lbnRIZWlnaHQgPSAoIHRoaXMub3B0aW9ucy5heGlzID09PSBcInhcIiApIHx8ICggKCB5MSArIGR5Q2xpY2sgKSA+IHQgJiZcblx0XHRcdFx0KCB5MSArIGR5Q2xpY2sgKSA8IGIgKSxcblx0XHRcdGlzT3ZlckVsZW1lbnRXaWR0aCA9ICggdGhpcy5vcHRpb25zLmF4aXMgPT09IFwieVwiICkgfHwgKCAoIHgxICsgZHhDbGljayApID4gbCAmJlxuXHRcdFx0XHQoIHgxICsgZHhDbGljayApIDwgciApLFxuXHRcdFx0aXNPdmVyRWxlbWVudCA9IGlzT3ZlckVsZW1lbnRIZWlnaHQgJiYgaXNPdmVyRWxlbWVudFdpZHRoO1xuXG5cdFx0aWYgKCB0aGlzLm9wdGlvbnMudG9sZXJhbmNlID09PSBcInBvaW50ZXJcIiB8fFxuXHRcdFx0dGhpcy5vcHRpb25zLmZvcmNlUG9pbnRlckZvckNvbnRhaW5lcnMgfHxcblx0XHRcdCggdGhpcy5vcHRpb25zLnRvbGVyYW5jZSAhPT0gXCJwb2ludGVyXCIgJiZcblx0XHRcdFx0dGhpcy5oZWxwZXJQcm9wb3J0aW9uc1sgdGhpcy5mbG9hdGluZyA/IFwid2lkdGhcIiA6IFwiaGVpZ2h0XCIgXSA+XG5cdFx0XHRcdGl0ZW1bIHRoaXMuZmxvYXRpbmcgPyBcIndpZHRoXCIgOiBcImhlaWdodFwiIF0gKVxuXHRcdCkge1xuXHRcdFx0cmV0dXJuIGlzT3ZlckVsZW1lbnQ7XG5cdFx0fSBlbHNlIHtcblxuXHRcdFx0cmV0dXJuICggbCA8IHgxICsgKCB0aGlzLmhlbHBlclByb3BvcnRpb25zLndpZHRoIC8gMiApICYmIC8vIFJpZ2h0IEhhbGZcblx0XHRcdFx0eDIgLSAoIHRoaXMuaGVscGVyUHJvcG9ydGlvbnMud2lkdGggLyAyICkgPCByICYmIC8vIExlZnQgSGFsZlxuXHRcdFx0XHR0IDwgeTEgKyAoIHRoaXMuaGVscGVyUHJvcG9ydGlvbnMuaGVpZ2h0IC8gMiApICYmIC8vIEJvdHRvbSBIYWxmXG5cdFx0XHRcdHkyIC0gKCB0aGlzLmhlbHBlclByb3BvcnRpb25zLmhlaWdodCAvIDIgKSA8IGIgKTsgLy8gVG9wIEhhbGZcblxuXHRcdH1cblx0fSxcblxuXHRfaW50ZXJzZWN0c1dpdGhQb2ludGVyOiBmdW5jdGlvbiggaXRlbSApIHtcblx0XHR2YXIgdmVydGljYWxEaXJlY3Rpb24sIGhvcml6b250YWxEaXJlY3Rpb24sXG5cdFx0XHRpc092ZXJFbGVtZW50SGVpZ2h0ID0gKCB0aGlzLm9wdGlvbnMuYXhpcyA9PT0gXCJ4XCIgKSB8fFxuXHRcdFx0XHR0aGlzLl9pc092ZXJBeGlzKFxuXHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMudG9wICsgdGhpcy5vZmZzZXQuY2xpY2sudG9wLCBpdGVtLnRvcCwgaXRlbS5oZWlnaHQgKSxcblx0XHRcdGlzT3ZlckVsZW1lbnRXaWR0aCA9ICggdGhpcy5vcHRpb25zLmF4aXMgPT09IFwieVwiICkgfHxcblx0XHRcdFx0dGhpcy5faXNPdmVyQXhpcyhcblx0XHRcdFx0XHR0aGlzLnBvc2l0aW9uQWJzLmxlZnQgKyB0aGlzLm9mZnNldC5jbGljay5sZWZ0LCBpdGVtLmxlZnQsIGl0ZW0ud2lkdGggKSxcblx0XHRcdGlzT3ZlckVsZW1lbnQgPSBpc092ZXJFbGVtZW50SGVpZ2h0ICYmIGlzT3ZlckVsZW1lbnRXaWR0aDtcblxuXHRcdGlmICggIWlzT3ZlckVsZW1lbnQgKSB7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fVxuXG5cdFx0dmVydGljYWxEaXJlY3Rpb24gPSB0aGlzLl9nZXREcmFnVmVydGljYWxEaXJlY3Rpb24oKTtcblx0XHRob3Jpem9udGFsRGlyZWN0aW9uID0gdGhpcy5fZ2V0RHJhZ0hvcml6b250YWxEaXJlY3Rpb24oKTtcblxuXHRcdHJldHVybiB0aGlzLmZsb2F0aW5nID9cblx0XHRcdCggKCBob3Jpem9udGFsRGlyZWN0aW9uID09PSBcInJpZ2h0XCIgfHwgdmVydGljYWxEaXJlY3Rpb24gPT09IFwiZG93blwiICkgPyAyIDogMSApXG5cdFx0XHQ6ICggdmVydGljYWxEaXJlY3Rpb24gJiYgKCB2ZXJ0aWNhbERpcmVjdGlvbiA9PT0gXCJkb3duXCIgPyAyIDogMSApICk7XG5cblx0fSxcblxuXHRfaW50ZXJzZWN0c1dpdGhTaWRlczogZnVuY3Rpb24oIGl0ZW0gKSB7XG5cblx0XHR2YXIgaXNPdmVyQm90dG9tSGFsZiA9IHRoaXMuX2lzT3ZlckF4aXMoIHRoaXMucG9zaXRpb25BYnMudG9wICtcblx0XHRcdFx0dGhpcy5vZmZzZXQuY2xpY2sudG9wLCBpdGVtLnRvcCArICggaXRlbS5oZWlnaHQgLyAyICksIGl0ZW0uaGVpZ2h0ICksXG5cdFx0XHRpc092ZXJSaWdodEhhbGYgPSB0aGlzLl9pc092ZXJBeGlzKCB0aGlzLnBvc2l0aW9uQWJzLmxlZnQgK1xuXHRcdFx0XHR0aGlzLm9mZnNldC5jbGljay5sZWZ0LCBpdGVtLmxlZnQgKyAoIGl0ZW0ud2lkdGggLyAyICksIGl0ZW0ud2lkdGggKSxcblx0XHRcdHZlcnRpY2FsRGlyZWN0aW9uID0gdGhpcy5fZ2V0RHJhZ1ZlcnRpY2FsRGlyZWN0aW9uKCksXG5cdFx0XHRob3Jpem9udGFsRGlyZWN0aW9uID0gdGhpcy5fZ2V0RHJhZ0hvcml6b250YWxEaXJlY3Rpb24oKTtcblxuXHRcdGlmICggdGhpcy5mbG9hdGluZyAmJiBob3Jpem9udGFsRGlyZWN0aW9uICkge1xuXHRcdFx0cmV0dXJuICggKCBob3Jpem9udGFsRGlyZWN0aW9uID09PSBcInJpZ2h0XCIgJiYgaXNPdmVyUmlnaHRIYWxmICkgfHxcblx0XHRcdFx0KCBob3Jpem9udGFsRGlyZWN0aW9uID09PSBcImxlZnRcIiAmJiAhaXNPdmVyUmlnaHRIYWxmICkgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0cmV0dXJuIHZlcnRpY2FsRGlyZWN0aW9uICYmICggKCB2ZXJ0aWNhbERpcmVjdGlvbiA9PT0gXCJkb3duXCIgJiYgaXNPdmVyQm90dG9tSGFsZiApIHx8XG5cdFx0XHRcdCggdmVydGljYWxEaXJlY3Rpb24gPT09IFwidXBcIiAmJiAhaXNPdmVyQm90dG9tSGFsZiApICk7XG5cdFx0fVxuXG5cdH0sXG5cblx0X2dldERyYWdWZXJ0aWNhbERpcmVjdGlvbjogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIGRlbHRhID0gdGhpcy5wb3NpdGlvbkFicy50b3AgLSB0aGlzLmxhc3RQb3NpdGlvbkFicy50b3A7XG5cdFx0cmV0dXJuIGRlbHRhICE9PSAwICYmICggZGVsdGEgPiAwID8gXCJkb3duXCIgOiBcInVwXCIgKTtcblx0fSxcblxuXHRfZ2V0RHJhZ0hvcml6b250YWxEaXJlY3Rpb246IGZ1bmN0aW9uKCkge1xuXHRcdHZhciBkZWx0YSA9IHRoaXMucG9zaXRpb25BYnMubGVmdCAtIHRoaXMubGFzdFBvc2l0aW9uQWJzLmxlZnQ7XG5cdFx0cmV0dXJuIGRlbHRhICE9PSAwICYmICggZGVsdGEgPiAwID8gXCJyaWdodFwiIDogXCJsZWZ0XCIgKTtcblx0fSxcblxuXHRyZWZyZXNoOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0dGhpcy5fcmVmcmVzaEl0ZW1zKCBldmVudCApO1xuXHRcdHRoaXMuX3NldEhhbmRsZUNsYXNzTmFtZSgpO1xuXHRcdHRoaXMucmVmcmVzaFBvc2l0aW9ucygpO1xuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdF9jb25uZWN0V2l0aDogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIG9wdGlvbnMgPSB0aGlzLm9wdGlvbnM7XG5cdFx0cmV0dXJuIG9wdGlvbnMuY29ubmVjdFdpdGguY29uc3RydWN0b3IgPT09IFN0cmluZyA/XG5cdFx0XHRbIG9wdGlvbnMuY29ubmVjdFdpdGggXSA6XG5cdFx0XHRvcHRpb25zLmNvbm5lY3RXaXRoO1xuXHR9LFxuXG5cdF9nZXRJdGVtc0FzalF1ZXJ5OiBmdW5jdGlvbiggY29ubmVjdGVkICkge1xuXG5cdFx0dmFyIGksIGosIGN1ciwgaW5zdCxcblx0XHRcdGl0ZW1zID0gW10sXG5cdFx0XHRxdWVyaWVzID0gW10sXG5cdFx0XHRjb25uZWN0V2l0aCA9IHRoaXMuX2Nvbm5lY3RXaXRoKCk7XG5cblx0XHRpZiAoIGNvbm5lY3RXaXRoICYmIGNvbm5lY3RlZCApIHtcblx0XHRcdGZvciAoIGkgPSBjb25uZWN0V2l0aC5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdFx0Y3VyID0gJCggY29ubmVjdFdpdGhbIGkgXSwgdGhpcy5kb2N1bWVudFsgMCBdICk7XG5cdFx0XHRcdGZvciAoIGogPSBjdXIubGVuZ3RoIC0gMTsgaiA+PSAwOyBqLS0gKSB7XG5cdFx0XHRcdFx0aW5zdCA9ICQuZGF0YSggY3VyWyBqIF0sIHRoaXMud2lkZ2V0RnVsbE5hbWUgKTtcblx0XHRcdFx0XHRpZiAoIGluc3QgJiYgaW5zdCAhPT0gdGhpcyAmJiAhaW5zdC5vcHRpb25zLmRpc2FibGVkICkge1xuXHRcdFx0XHRcdFx0cXVlcmllcy5wdXNoKCBbICQuaXNGdW5jdGlvbiggaW5zdC5vcHRpb25zLml0ZW1zICkgP1xuXHRcdFx0XHRcdFx0XHRpbnN0Lm9wdGlvbnMuaXRlbXMuY2FsbCggaW5zdC5lbGVtZW50ICkgOlxuXHRcdFx0XHRcdFx0XHQkKCBpbnN0Lm9wdGlvbnMuaXRlbXMsIGluc3QuZWxlbWVudCApXG5cdFx0XHRcdFx0XHRcdFx0Lm5vdCggXCIudWktc29ydGFibGUtaGVscGVyXCIgKVxuXHRcdFx0XHRcdFx0XHRcdC5ub3QoIFwiLnVpLXNvcnRhYmxlLXBsYWNlaG9sZGVyXCIgKSwgaW5zdCBdICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cXVlcmllcy5wdXNoKCBbICQuaXNGdW5jdGlvbiggdGhpcy5vcHRpb25zLml0ZW1zICkgP1xuXHRcdFx0dGhpcy5vcHRpb25zLml0ZW1zXG5cdFx0XHRcdC5jYWxsKCB0aGlzLmVsZW1lbnQsIG51bGwsIHsgb3B0aW9uczogdGhpcy5vcHRpb25zLCBpdGVtOiB0aGlzLmN1cnJlbnRJdGVtIH0gKSA6XG5cdFx0XHQkKCB0aGlzLm9wdGlvbnMuaXRlbXMsIHRoaXMuZWxlbWVudCApXG5cdFx0XHRcdC5ub3QoIFwiLnVpLXNvcnRhYmxlLWhlbHBlclwiIClcblx0XHRcdFx0Lm5vdCggXCIudWktc29ydGFibGUtcGxhY2Vob2xkZXJcIiApLCB0aGlzIF0gKTtcblxuXHRcdGZ1bmN0aW9uIGFkZEl0ZW1zKCkge1xuXHRcdFx0aXRlbXMucHVzaCggdGhpcyApO1xuXHRcdH1cblx0XHRmb3IgKCBpID0gcXVlcmllcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdHF1ZXJpZXNbIGkgXVsgMCBdLmVhY2goIGFkZEl0ZW1zICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuICQoIGl0ZW1zICk7XG5cblx0fSxcblxuXHRfcmVtb3ZlQ3VycmVudHNGcm9tSXRlbXM6IGZ1bmN0aW9uKCkge1xuXG5cdFx0dmFyIGxpc3QgPSB0aGlzLmN1cnJlbnRJdGVtLmZpbmQoIFwiOmRhdGEoXCIgKyB0aGlzLndpZGdldE5hbWUgKyBcIi1pdGVtKVwiICk7XG5cblx0XHR0aGlzLml0ZW1zID0gJC5ncmVwKCB0aGlzLml0ZW1zLCBmdW5jdGlvbiggaXRlbSApIHtcblx0XHRcdGZvciAoIHZhciBqID0gMDsgaiA8IGxpc3QubGVuZ3RoOyBqKysgKSB7XG5cdFx0XHRcdGlmICggbGlzdFsgaiBdID09PSBpdGVtLml0ZW1bIDAgXSApIHtcblx0XHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHRcdHJldHVybiB0cnVlO1xuXHRcdH0gKTtcblxuXHR9LFxuXG5cdF9yZWZyZXNoSXRlbXM6IGZ1bmN0aW9uKCBldmVudCApIHtcblxuXHRcdHRoaXMuaXRlbXMgPSBbXTtcblx0XHR0aGlzLmNvbnRhaW5lcnMgPSBbIHRoaXMgXTtcblxuXHRcdHZhciBpLCBqLCBjdXIsIGluc3QsIHRhcmdldERhdGEsIF9xdWVyaWVzLCBpdGVtLCBxdWVyaWVzTGVuZ3RoLFxuXHRcdFx0aXRlbXMgPSB0aGlzLml0ZW1zLFxuXHRcdFx0cXVlcmllcyA9IFsgWyAkLmlzRnVuY3Rpb24oIHRoaXMub3B0aW9ucy5pdGVtcyApID9cblx0XHRcdFx0dGhpcy5vcHRpb25zLml0ZW1zLmNhbGwoIHRoaXMuZWxlbWVudFsgMCBdLCBldmVudCwgeyBpdGVtOiB0aGlzLmN1cnJlbnRJdGVtIH0gKSA6XG5cdFx0XHRcdCQoIHRoaXMub3B0aW9ucy5pdGVtcywgdGhpcy5lbGVtZW50ICksIHRoaXMgXSBdLFxuXHRcdFx0Y29ubmVjdFdpdGggPSB0aGlzLl9jb25uZWN0V2l0aCgpO1xuXG5cdFx0Ly9TaG91bGRuJ3QgYmUgcnVuIHRoZSBmaXJzdCB0aW1lIHRocm91Z2ggZHVlIHRvIG1hc3NpdmUgc2xvdy1kb3duXG5cdFx0aWYgKCBjb25uZWN0V2l0aCAmJiB0aGlzLnJlYWR5ICkge1xuXHRcdFx0Zm9yICggaSA9IGNvbm5lY3RXaXRoLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0XHRjdXIgPSAkKCBjb25uZWN0V2l0aFsgaSBdLCB0aGlzLmRvY3VtZW50WyAwIF0gKTtcblx0XHRcdFx0Zm9yICggaiA9IGN1ci5sZW5ndGggLSAxOyBqID49IDA7IGotLSApIHtcblx0XHRcdFx0XHRpbnN0ID0gJC5kYXRhKCBjdXJbIGogXSwgdGhpcy53aWRnZXRGdWxsTmFtZSApO1xuXHRcdFx0XHRcdGlmICggaW5zdCAmJiBpbnN0ICE9PSB0aGlzICYmICFpbnN0Lm9wdGlvbnMuZGlzYWJsZWQgKSB7XG5cdFx0XHRcdFx0XHRxdWVyaWVzLnB1c2goIFsgJC5pc0Z1bmN0aW9uKCBpbnN0Lm9wdGlvbnMuaXRlbXMgKSA/XG5cdFx0XHRcdFx0XHRcdGluc3Qub3B0aW9ucy5pdGVtc1xuXHRcdFx0XHRcdFx0XHRcdC5jYWxsKCBpbnN0LmVsZW1lbnRbIDAgXSwgZXZlbnQsIHsgaXRlbTogdGhpcy5jdXJyZW50SXRlbSB9ICkgOlxuXHRcdFx0XHRcdFx0XHQkKCBpbnN0Lm9wdGlvbnMuaXRlbXMsIGluc3QuZWxlbWVudCApLCBpbnN0IF0gKTtcblx0XHRcdFx0XHRcdHRoaXMuY29udGFpbmVycy5wdXNoKCBpbnN0ICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Zm9yICggaSA9IHF1ZXJpZXMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHR0YXJnZXREYXRhID0gcXVlcmllc1sgaSBdWyAxIF07XG5cdFx0XHRfcXVlcmllcyA9IHF1ZXJpZXNbIGkgXVsgMCBdO1xuXG5cdFx0XHRmb3IgKCBqID0gMCwgcXVlcmllc0xlbmd0aCA9IF9xdWVyaWVzLmxlbmd0aDsgaiA8IHF1ZXJpZXNMZW5ndGg7IGorKyApIHtcblx0XHRcdFx0aXRlbSA9ICQoIF9xdWVyaWVzWyBqIF0gKTtcblxuXHRcdFx0XHQvLyBEYXRhIGZvciB0YXJnZXQgY2hlY2tpbmcgKG1vdXNlIG1hbmFnZXIpXG5cdFx0XHRcdGl0ZW0uZGF0YSggdGhpcy53aWRnZXROYW1lICsgXCItaXRlbVwiLCB0YXJnZXREYXRhICk7XG5cblx0XHRcdFx0aXRlbXMucHVzaCgge1xuXHRcdFx0XHRcdGl0ZW06IGl0ZW0sXG5cdFx0XHRcdFx0aW5zdGFuY2U6IHRhcmdldERhdGEsXG5cdFx0XHRcdFx0d2lkdGg6IDAsIGhlaWdodDogMCxcblx0XHRcdFx0XHRsZWZ0OiAwLCB0b3A6IDBcblx0XHRcdFx0fSApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHR9LFxuXG5cdHJlZnJlc2hQb3NpdGlvbnM6IGZ1bmN0aW9uKCBmYXN0ICkge1xuXG5cdFx0Ly8gRGV0ZXJtaW5lIHdoZXRoZXIgaXRlbXMgYXJlIGJlaW5nIGRpc3BsYXllZCBob3Jpem9udGFsbHlcblx0XHR0aGlzLmZsb2F0aW5nID0gdGhpcy5pdGVtcy5sZW5ndGggP1xuXHRcdFx0dGhpcy5vcHRpb25zLmF4aXMgPT09IFwieFwiIHx8IHRoaXMuX2lzRmxvYXRpbmcoIHRoaXMuaXRlbXNbIDAgXS5pdGVtICkgOlxuXHRcdFx0ZmFsc2U7XG5cblx0XHQvL1RoaXMgaGFzIHRvIGJlIHJlZG9uZSBiZWNhdXNlIGR1ZSB0byB0aGUgaXRlbSBiZWluZyBtb3ZlZCBvdXQvaW50byB0aGUgb2Zmc2V0UGFyZW50LFxuXHRcdC8vIHRoZSBvZmZzZXRQYXJlbnQncyBwb3NpdGlvbiB3aWxsIGNoYW5nZVxuXHRcdGlmICggdGhpcy5vZmZzZXRQYXJlbnQgJiYgdGhpcy5oZWxwZXIgKSB7XG5cdFx0XHR0aGlzLm9mZnNldC5wYXJlbnQgPSB0aGlzLl9nZXRQYXJlbnRPZmZzZXQoKTtcblx0XHR9XG5cblx0XHR2YXIgaSwgaXRlbSwgdCwgcDtcblxuXHRcdGZvciAoIGkgPSB0aGlzLml0ZW1zLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0aXRlbSA9IHRoaXMuaXRlbXNbIGkgXTtcblxuXHRcdFx0Ly9XZSBpZ25vcmUgY2FsY3VsYXRpbmcgcG9zaXRpb25zIG9mIGFsbCBjb25uZWN0ZWQgY29udGFpbmVycyB3aGVuIHdlJ3JlIG5vdCBvdmVyIHRoZW1cblx0XHRcdGlmICggaXRlbS5pbnN0YW5jZSAhPT0gdGhpcy5jdXJyZW50Q29udGFpbmVyICYmIHRoaXMuY3VycmVudENvbnRhaW5lciAmJlxuXHRcdFx0XHRcdGl0ZW0uaXRlbVsgMCBdICE9PSB0aGlzLmN1cnJlbnRJdGVtWyAwIF0gKSB7XG5cdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0fVxuXG5cdFx0XHR0ID0gdGhpcy5vcHRpb25zLnRvbGVyYW5jZUVsZW1lbnQgP1xuXHRcdFx0XHQkKCB0aGlzLm9wdGlvbnMudG9sZXJhbmNlRWxlbWVudCwgaXRlbS5pdGVtICkgOlxuXHRcdFx0XHRpdGVtLml0ZW07XG5cblx0XHRcdGlmICggIWZhc3QgKSB7XG5cdFx0XHRcdGl0ZW0ud2lkdGggPSB0Lm91dGVyV2lkdGgoKTtcblx0XHRcdFx0aXRlbS5oZWlnaHQgPSB0Lm91dGVySGVpZ2h0KCk7XG5cdFx0XHR9XG5cblx0XHRcdHAgPSB0Lm9mZnNldCgpO1xuXHRcdFx0aXRlbS5sZWZ0ID0gcC5sZWZ0O1xuXHRcdFx0aXRlbS50b3AgPSBwLnRvcDtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMub3B0aW9ucy5jdXN0b20gJiYgdGhpcy5vcHRpb25zLmN1c3RvbS5yZWZyZXNoQ29udGFpbmVycyApIHtcblx0XHRcdHRoaXMub3B0aW9ucy5jdXN0b20ucmVmcmVzaENvbnRhaW5lcnMuY2FsbCggdGhpcyApO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRmb3IgKCBpID0gdGhpcy5jb250YWluZXJzLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0XHRwID0gdGhpcy5jb250YWluZXJzWyBpIF0uZWxlbWVudC5vZmZzZXQoKTtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUubGVmdCA9IHAubGVmdDtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUudG9wID0gcC50b3A7XG5cdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLndpZHRoID1cblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5lbGVtZW50Lm91dGVyV2lkdGgoKTtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUuaGVpZ2h0ID1cblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5lbGVtZW50Lm91dGVySGVpZ2h0KCk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0X2NyZWF0ZVBsYWNlaG9sZGVyOiBmdW5jdGlvbiggdGhhdCApIHtcblx0XHR0aGF0ID0gdGhhdCB8fCB0aGlzO1xuXHRcdHZhciBjbGFzc05hbWUsXG5cdFx0XHRvID0gdGhhdC5vcHRpb25zO1xuXG5cdFx0aWYgKCAhby5wbGFjZWhvbGRlciB8fCBvLnBsYWNlaG9sZGVyLmNvbnN0cnVjdG9yID09PSBTdHJpbmcgKSB7XG5cdFx0XHRjbGFzc05hbWUgPSBvLnBsYWNlaG9sZGVyO1xuXHRcdFx0by5wbGFjZWhvbGRlciA9IHtcblx0XHRcdFx0ZWxlbWVudDogZnVuY3Rpb24oKSB7XG5cblx0XHRcdFx0XHR2YXIgbm9kZU5hbWUgPSB0aGF0LmN1cnJlbnRJdGVtWyAwIF0ubm9kZU5hbWUudG9Mb3dlckNhc2UoKSxcblx0XHRcdFx0XHRcdGVsZW1lbnQgPSAkKCBcIjxcIiArIG5vZGVOYW1lICsgXCI+XCIsIHRoYXQuZG9jdW1lbnRbIDAgXSApO1xuXG5cdFx0XHRcdFx0XHR0aGF0Ll9hZGRDbGFzcyggZWxlbWVudCwgXCJ1aS1zb3J0YWJsZS1wbGFjZWhvbGRlclwiLFxuXHRcdFx0XHRcdFx0XHRcdGNsYXNzTmFtZSB8fCB0aGF0LmN1cnJlbnRJdGVtWyAwIF0uY2xhc3NOYW1lIClcblx0XHRcdFx0XHRcdFx0Ll9yZW1vdmVDbGFzcyggZWxlbWVudCwgXCJ1aS1zb3J0YWJsZS1oZWxwZXJcIiApO1xuXG5cdFx0XHRcdFx0aWYgKCBub2RlTmFtZSA9PT0gXCJ0Ym9keVwiICkge1xuXHRcdFx0XHRcdFx0dGhhdC5fY3JlYXRlVHJQbGFjZWhvbGRlcihcblx0XHRcdFx0XHRcdFx0dGhhdC5jdXJyZW50SXRlbS5maW5kKCBcInRyXCIgKS5lcSggMCApLFxuXHRcdFx0XHRcdFx0XHQkKCBcIjx0cj5cIiwgdGhhdC5kb2N1bWVudFsgMCBdICkuYXBwZW5kVG8oIGVsZW1lbnQgKVxuXHRcdFx0XHRcdFx0KTtcblx0XHRcdFx0XHR9IGVsc2UgaWYgKCBub2RlTmFtZSA9PT0gXCJ0clwiICkge1xuXHRcdFx0XHRcdFx0dGhhdC5fY3JlYXRlVHJQbGFjZWhvbGRlciggdGhhdC5jdXJyZW50SXRlbSwgZWxlbWVudCApO1xuXHRcdFx0XHRcdH0gZWxzZSBpZiAoIG5vZGVOYW1lID09PSBcImltZ1wiICkge1xuXHRcdFx0XHRcdFx0ZWxlbWVudC5hdHRyKCBcInNyY1wiLCB0aGF0LmN1cnJlbnRJdGVtLmF0dHIoIFwic3JjXCIgKSApO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdGlmICggIWNsYXNzTmFtZSApIHtcblx0XHRcdFx0XHRcdGVsZW1lbnQuY3NzKCBcInZpc2liaWxpdHlcIiwgXCJoaWRkZW5cIiApO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdHJldHVybiBlbGVtZW50O1xuXHRcdFx0XHR9LFxuXHRcdFx0XHR1cGRhdGU6IGZ1bmN0aW9uKCBjb250YWluZXIsIHAgKSB7XG5cblx0XHRcdFx0XHQvLyAxLiBJZiBhIGNsYXNzTmFtZSBpcyBzZXQgYXMgJ3BsYWNlaG9sZGVyIG9wdGlvbiwgd2UgZG9uJ3QgZm9yY2Ugc2l6ZXMgLVxuXHRcdFx0XHRcdC8vIHRoZSBjbGFzcyBpcyByZXNwb25zaWJsZSBmb3IgdGhhdFxuXHRcdFx0XHRcdC8vIDIuIFRoZSBvcHRpb24gJ2ZvcmNlUGxhY2Vob2xkZXJTaXplIGNhbiBiZSBlbmFibGVkIHRvIGZvcmNlIGl0IGV2ZW4gaWYgYVxuXHRcdFx0XHRcdC8vIGNsYXNzIG5hbWUgaXMgc3BlY2lmaWVkXG5cdFx0XHRcdFx0aWYgKCBjbGFzc05hbWUgJiYgIW8uZm9yY2VQbGFjZWhvbGRlclNpemUgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm47XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0Ly9JZiB0aGUgZWxlbWVudCBkb2Vzbid0IGhhdmUgYSBhY3R1YWwgaGVpZ2h0IGJ5IGl0c2VsZiAod2l0aG91dCBzdHlsZXMgY29taW5nXG5cdFx0XHRcdFx0Ly8gZnJvbSBhIHN0eWxlc2hlZXQpLCBpdCByZWNlaXZlcyB0aGUgaW5saW5lIGhlaWdodCBmcm9tIHRoZSBkcmFnZ2VkIGl0ZW1cblx0XHRcdFx0XHRpZiAoICFwLmhlaWdodCgpICkge1xuXHRcdFx0XHRcdFx0cC5oZWlnaHQoXG5cdFx0XHRcdFx0XHRcdHRoYXQuY3VycmVudEl0ZW0uaW5uZXJIZWlnaHQoKSAtXG5cdFx0XHRcdFx0XHRcdHBhcnNlSW50KCB0aGF0LmN1cnJlbnRJdGVtLmNzcyggXCJwYWRkaW5nVG9wXCIgKSB8fCAwLCAxMCApIC1cblx0XHRcdFx0XHRcdFx0cGFyc2VJbnQoIHRoYXQuY3VycmVudEl0ZW0uY3NzKCBcInBhZGRpbmdCb3R0b21cIiApIHx8IDAsIDEwICkgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0aWYgKCAhcC53aWR0aCgpICkge1xuXHRcdFx0XHRcdFx0cC53aWR0aChcblx0XHRcdFx0XHRcdFx0dGhhdC5jdXJyZW50SXRlbS5pbm5lcldpZHRoKCkgLVxuXHRcdFx0XHRcdFx0XHRwYXJzZUludCggdGhhdC5jdXJyZW50SXRlbS5jc3MoIFwicGFkZGluZ0xlZnRcIiApIHx8IDAsIDEwICkgLVxuXHRcdFx0XHRcdFx0XHRwYXJzZUludCggdGhhdC5jdXJyZW50SXRlbS5jc3MoIFwicGFkZGluZ1JpZ2h0XCIgKSB8fCAwLCAxMCApICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9O1xuXHRcdH1cblxuXHRcdC8vQ3JlYXRlIHRoZSBwbGFjZWhvbGRlclxuXHRcdHRoYXQucGxhY2Vob2xkZXIgPSAkKCBvLnBsYWNlaG9sZGVyLmVsZW1lbnQuY2FsbCggdGhhdC5lbGVtZW50LCB0aGF0LmN1cnJlbnRJdGVtICkgKTtcblxuXHRcdC8vQXBwZW5kIGl0IGFmdGVyIHRoZSBhY3R1YWwgY3VycmVudCBpdGVtXG5cdFx0dGhhdC5jdXJyZW50SXRlbS5hZnRlciggdGhhdC5wbGFjZWhvbGRlciApO1xuXG5cdFx0Ly9VcGRhdGUgdGhlIHNpemUgb2YgdGhlIHBsYWNlaG9sZGVyIChUT0RPOiBMb2dpYyB0byBmdXp6eSwgc2VlIGxpbmUgMzE2LzMxNylcblx0XHRvLnBsYWNlaG9sZGVyLnVwZGF0ZSggdGhhdCwgdGhhdC5wbGFjZWhvbGRlciApO1xuXG5cdH0sXG5cblx0X2NyZWF0ZVRyUGxhY2Vob2xkZXI6IGZ1bmN0aW9uKCBzb3VyY2VUciwgdGFyZ2V0VHIgKSB7XG5cdFx0dmFyIHRoYXQgPSB0aGlzO1xuXG5cdFx0c291cmNlVHIuY2hpbGRyZW4oKS5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdCQoIFwiPHRkPiYjMTYwOzwvdGQ+XCIsIHRoYXQuZG9jdW1lbnRbIDAgXSApXG5cdFx0XHRcdC5hdHRyKCBcImNvbHNwYW5cIiwgJCggdGhpcyApLmF0dHIoIFwiY29sc3BhblwiICkgfHwgMSApXG5cdFx0XHRcdC5hcHBlbmRUbyggdGFyZ2V0VHIgKTtcblx0XHR9ICk7XG5cdH0sXG5cblx0X2NvbnRhY3RDb250YWluZXJzOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0dmFyIGksIGosIGRpc3QsIGl0ZW1XaXRoTGVhc3REaXN0YW5jZSwgcG9zUHJvcGVydHksIHNpemVQcm9wZXJ0eSwgY3VyLCBuZWFyQm90dG9tLFxuXHRcdFx0ZmxvYXRpbmcsIGF4aXMsXG5cdFx0XHRpbm5lcm1vc3RDb250YWluZXIgPSBudWxsLFxuXHRcdFx0aW5uZXJtb3N0SW5kZXggPSBudWxsO1xuXG5cdFx0Ly8gR2V0IGlubmVybW9zdCBjb250YWluZXIgdGhhdCBpbnRlcnNlY3RzIHdpdGggaXRlbVxuXHRcdGZvciAoIGkgPSB0aGlzLmNvbnRhaW5lcnMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cblx0XHRcdC8vIE5ldmVyIGNvbnNpZGVyIGEgY29udGFpbmVyIHRoYXQncyBsb2NhdGVkIHdpdGhpbiB0aGUgaXRlbSBpdHNlbGZcblx0XHRcdGlmICggJC5jb250YWlucyggdGhpcy5jdXJyZW50SXRlbVsgMCBdLCB0aGlzLmNvbnRhaW5lcnNbIGkgXS5lbGVtZW50WyAwIF0gKSApIHtcblx0XHRcdFx0Y29udGludWU7XG5cdFx0XHR9XG5cblx0XHRcdGlmICggdGhpcy5faW50ZXJzZWN0c1dpdGgoIHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlICkgKSB7XG5cblx0XHRcdFx0Ly8gSWYgd2UndmUgYWxyZWFkeSBmb3VuZCBhIGNvbnRhaW5lciBhbmQgaXQncyBtb3JlIFwiaW5uZXJcIiB0aGFuIHRoaXMsIHRoZW4gY29udGludWVcblx0XHRcdFx0aWYgKCBpbm5lcm1vc3RDb250YWluZXIgJiZcblx0XHRcdFx0XHRcdCQuY29udGFpbnMoXG5cdFx0XHRcdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLmVsZW1lbnRbIDAgXSxcblx0XHRcdFx0XHRcdFx0aW5uZXJtb3N0Q29udGFpbmVyLmVsZW1lbnRbIDAgXSApICkge1xuXHRcdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0aW5uZXJtb3N0Q29udGFpbmVyID0gdGhpcy5jb250YWluZXJzWyBpIF07XG5cdFx0XHRcdGlubmVybW9zdEluZGV4ID0gaTtcblxuXHRcdFx0fSBlbHNlIHtcblxuXHRcdFx0XHQvLyBjb250YWluZXIgZG9lc24ndCBpbnRlcnNlY3QuIHRyaWdnZXIgXCJvdXRcIiBldmVudCBpZiBuZWNlc3Nhcnlcblx0XHRcdFx0aWYgKCB0aGlzLmNvbnRhaW5lcnNbIGkgXS5jb250YWluZXJDYWNoZS5vdmVyICkge1xuXHRcdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLl90cmlnZ2VyKCBcIm91dFwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCB0aGlzICkgKTtcblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5jb250YWluZXJDYWNoZS5vdmVyID0gMDtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0fVxuXG5cdFx0Ly8gSWYgbm8gaW50ZXJzZWN0aW5nIGNvbnRhaW5lcnMgZm91bmQsIHJldHVyblxuXHRcdGlmICggIWlubmVybW9zdENvbnRhaW5lciApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHQvLyBNb3ZlIHRoZSBpdGVtIGludG8gdGhlIGNvbnRhaW5lciBpZiBpdCdzIG5vdCB0aGVyZSBhbHJlYWR5XG5cdFx0aWYgKCB0aGlzLmNvbnRhaW5lcnMubGVuZ3RoID09PSAxICkge1xuXHRcdFx0aWYgKCAhdGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdLmNvbnRhaW5lckNhY2hlLm92ZXIgKSB7XG5cdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5fdHJpZ2dlciggXCJvdmVyXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uY29udGFpbmVyQ2FjaGUub3ZlciA9IDE7XG5cdFx0XHR9XG5cdFx0fSBlbHNlIHtcblxuXHRcdFx0Ly8gV2hlbiBlbnRlcmluZyBhIG5ldyBjb250YWluZXIsIHdlIHdpbGwgZmluZCB0aGUgaXRlbSB3aXRoIHRoZSBsZWFzdCBkaXN0YW5jZSBhbmRcblx0XHRcdC8vIGFwcGVuZCBvdXIgaXRlbSBuZWFyIGl0XG5cdFx0XHRkaXN0ID0gMTAwMDA7XG5cdFx0XHRpdGVtV2l0aExlYXN0RGlzdGFuY2UgPSBudWxsO1xuXHRcdFx0ZmxvYXRpbmcgPSBpbm5lcm1vc3RDb250YWluZXIuZmxvYXRpbmcgfHwgdGhpcy5faXNGbG9hdGluZyggdGhpcy5jdXJyZW50SXRlbSApO1xuXHRcdFx0cG9zUHJvcGVydHkgPSBmbG9hdGluZyA/IFwibGVmdFwiIDogXCJ0b3BcIjtcblx0XHRcdHNpemVQcm9wZXJ0eSA9IGZsb2F0aW5nID8gXCJ3aWR0aFwiIDogXCJoZWlnaHRcIjtcblx0XHRcdGF4aXMgPSBmbG9hdGluZyA/IFwicGFnZVhcIiA6IFwicGFnZVlcIjtcblxuXHRcdFx0Zm9yICggaiA9IHRoaXMuaXRlbXMubGVuZ3RoIC0gMTsgaiA+PSAwOyBqLS0gKSB7XG5cdFx0XHRcdGlmICggISQuY29udGFpbnMoXG5cdFx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uZWxlbWVudFsgMCBdLCB0aGlzLml0ZW1zWyBqIF0uaXRlbVsgMCBdIClcblx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0Y29udGludWU7XG5cdFx0XHRcdH1cblx0XHRcdFx0aWYgKCB0aGlzLml0ZW1zWyBqIF0uaXRlbVsgMCBdID09PSB0aGlzLmN1cnJlbnRJdGVtWyAwIF0gKSB7XG5cdFx0XHRcdFx0Y29udGludWU7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRjdXIgPSB0aGlzLml0ZW1zWyBqIF0uaXRlbS5vZmZzZXQoKVsgcG9zUHJvcGVydHkgXTtcblx0XHRcdFx0bmVhckJvdHRvbSA9IGZhbHNlO1xuXHRcdFx0XHRpZiAoIGV2ZW50WyBheGlzIF0gLSBjdXIgPiB0aGlzLml0ZW1zWyBqIF1bIHNpemVQcm9wZXJ0eSBdIC8gMiApIHtcblx0XHRcdFx0XHRuZWFyQm90dG9tID0gdHJ1ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdGlmICggTWF0aC5hYnMoIGV2ZW50WyBheGlzIF0gLSBjdXIgKSA8IGRpc3QgKSB7XG5cdFx0XHRcdFx0ZGlzdCA9IE1hdGguYWJzKCBldmVudFsgYXhpcyBdIC0gY3VyICk7XG5cdFx0XHRcdFx0aXRlbVdpdGhMZWFzdERpc3RhbmNlID0gdGhpcy5pdGVtc1sgaiBdO1xuXHRcdFx0XHRcdHRoaXMuZGlyZWN0aW9uID0gbmVhckJvdHRvbSA/IFwidXBcIiA6IFwiZG93blwiO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdC8vQ2hlY2sgaWYgZHJvcE9uRW1wdHkgaXMgZW5hYmxlZFxuXHRcdFx0aWYgKCAhaXRlbVdpdGhMZWFzdERpc3RhbmNlICYmICF0aGlzLm9wdGlvbnMuZHJvcE9uRW1wdHkgKSB7XG5cdFx0XHRcdHJldHVybjtcblx0XHRcdH1cblxuXHRcdFx0aWYgKCB0aGlzLmN1cnJlbnRDb250YWluZXIgPT09IHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXSApIHtcblx0XHRcdFx0aWYgKCAhdGhpcy5jdXJyZW50Q29udGFpbmVyLmNvbnRhaW5lckNhY2hlLm92ZXIgKSB7XG5cdFx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdLl90cmlnZ2VyKCBcIm92ZXJcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cdFx0XHRcdFx0dGhpcy5jdXJyZW50Q29udGFpbmVyLmNvbnRhaW5lckNhY2hlLm92ZXIgPSAxO1xuXHRcdFx0XHR9XG5cdFx0XHRcdHJldHVybjtcblx0XHRcdH1cblxuXHRcdFx0aXRlbVdpdGhMZWFzdERpc3RhbmNlID9cblx0XHRcdFx0dGhpcy5fcmVhcnJhbmdlKCBldmVudCwgaXRlbVdpdGhMZWFzdERpc3RhbmNlLCBudWxsLCB0cnVlICkgOlxuXHRcdFx0XHR0aGlzLl9yZWFycmFuZ2UoIGV2ZW50LCBudWxsLCB0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uZWxlbWVudCwgdHJ1ZSApO1xuXHRcdFx0dGhpcy5fdHJpZ2dlciggXCJjaGFuZ2VcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uX3RyaWdnZXIoIFwiY2hhbmdlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0dGhpcy5jdXJyZW50Q29udGFpbmVyID0gdGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdO1xuXG5cdFx0XHQvL1VwZGF0ZSB0aGUgcGxhY2Vob2xkZXJcblx0XHRcdHRoaXMub3B0aW9ucy5wbGFjZWhvbGRlci51cGRhdGUoIHRoaXMuY3VycmVudENvbnRhaW5lciwgdGhpcy5wbGFjZWhvbGRlciApO1xuXG5cdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uX3RyaWdnZXIoIFwib3ZlclwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCB0aGlzICkgKTtcblx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5jb250YWluZXJDYWNoZS5vdmVyID0gMTtcblx0XHR9XG5cblx0fSxcblxuXHRfY3JlYXRlSGVscGVyOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cblx0XHR2YXIgbyA9IHRoaXMub3B0aW9ucyxcblx0XHRcdGhlbHBlciA9ICQuaXNGdW5jdGlvbiggby5oZWxwZXIgKSA/XG5cdFx0XHRcdCQoIG8uaGVscGVyLmFwcGx5KCB0aGlzLmVsZW1lbnRbIDAgXSwgWyBldmVudCwgdGhpcy5jdXJyZW50SXRlbSBdICkgKSA6XG5cdFx0XHRcdCggby5oZWxwZXIgPT09IFwiY2xvbmVcIiA/IHRoaXMuY3VycmVudEl0ZW0uY2xvbmUoKSA6IHRoaXMuY3VycmVudEl0ZW0gKTtcblxuXHRcdC8vQWRkIHRoZSBoZWxwZXIgdG8gdGhlIERPTSBpZiB0aGF0IGRpZG4ndCBoYXBwZW4gYWxyZWFkeVxuXHRcdGlmICggIWhlbHBlci5wYXJlbnRzKCBcImJvZHlcIiApLmxlbmd0aCApIHtcblx0XHRcdCQoIG8uYXBwZW5kVG8gIT09IFwicGFyZW50XCIgP1xuXHRcdFx0XHRvLmFwcGVuZFRvIDpcblx0XHRcdFx0dGhpcy5jdXJyZW50SXRlbVsgMCBdLnBhcmVudE5vZGUgKVsgMCBdLmFwcGVuZENoaWxkKCBoZWxwZXJbIDAgXSApO1xuXHRcdH1cblxuXHRcdGlmICggaGVscGVyWyAwIF0gPT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdHRoaXMuX3N0b3JlZENTUyA9IHtcblx0XHRcdFx0d2lkdGg6IHRoaXMuY3VycmVudEl0ZW1bIDAgXS5zdHlsZS53aWR0aCxcblx0XHRcdFx0aGVpZ2h0OiB0aGlzLmN1cnJlbnRJdGVtWyAwIF0uc3R5bGUuaGVpZ2h0LFxuXHRcdFx0XHRwb3NpdGlvbjogdGhpcy5jdXJyZW50SXRlbS5jc3MoIFwicG9zaXRpb25cIiApLFxuXHRcdFx0XHR0b3A6IHRoaXMuY3VycmVudEl0ZW0uY3NzKCBcInRvcFwiICksXG5cdFx0XHRcdGxlZnQ6IHRoaXMuY3VycmVudEl0ZW0uY3NzKCBcImxlZnRcIiApXG5cdFx0XHR9O1xuXHRcdH1cblxuXHRcdGlmICggIWhlbHBlclsgMCBdLnN0eWxlLndpZHRoIHx8IG8uZm9yY2VIZWxwZXJTaXplICkge1xuXHRcdFx0aGVscGVyLndpZHRoKCB0aGlzLmN1cnJlbnRJdGVtLndpZHRoKCkgKTtcblx0XHR9XG5cdFx0aWYgKCAhaGVscGVyWyAwIF0uc3R5bGUuaGVpZ2h0IHx8IG8uZm9yY2VIZWxwZXJTaXplICkge1xuXHRcdFx0aGVscGVyLmhlaWdodCggdGhpcy5jdXJyZW50SXRlbS5oZWlnaHQoKSApO1xuXHRcdH1cblxuXHRcdHJldHVybiBoZWxwZXI7XG5cblx0fSxcblxuXHRfYWRqdXN0T2Zmc2V0RnJvbUhlbHBlcjogZnVuY3Rpb24oIG9iaiApIHtcblx0XHRpZiAoIHR5cGVvZiBvYmogPT09IFwic3RyaW5nXCIgKSB7XG5cdFx0XHRvYmogPSBvYmouc3BsaXQoIFwiIFwiICk7XG5cdFx0fVxuXHRcdGlmICggJC5pc0FycmF5KCBvYmogKSApIHtcblx0XHRcdG9iaiA9IHsgbGVmdDogK29ialsgMCBdLCB0b3A6ICtvYmpbIDEgXSB8fCAwIH07XG5cdFx0fVxuXHRcdGlmICggXCJsZWZ0XCIgaW4gb2JqICkge1xuXHRcdFx0dGhpcy5vZmZzZXQuY2xpY2subGVmdCA9IG9iai5sZWZ0ICsgdGhpcy5tYXJnaW5zLmxlZnQ7XG5cdFx0fVxuXHRcdGlmICggXCJyaWdodFwiIGluIG9iaiApIHtcblx0XHRcdHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQgPSB0aGlzLmhlbHBlclByb3BvcnRpb25zLndpZHRoIC0gb2JqLnJpZ2h0ICsgdGhpcy5tYXJnaW5zLmxlZnQ7XG5cdFx0fVxuXHRcdGlmICggXCJ0b3BcIiBpbiBvYmogKSB7XG5cdFx0XHR0aGlzLm9mZnNldC5jbGljay50b3AgPSBvYmoudG9wICsgdGhpcy5tYXJnaW5zLnRvcDtcblx0XHR9XG5cdFx0aWYgKCBcImJvdHRvbVwiIGluIG9iaiApIHtcblx0XHRcdHRoaXMub2Zmc2V0LmNsaWNrLnRvcCA9IHRoaXMuaGVscGVyUHJvcG9ydGlvbnMuaGVpZ2h0IC0gb2JqLmJvdHRvbSArIHRoaXMubWFyZ2lucy50b3A7XG5cdFx0fVxuXHR9LFxuXG5cdF9nZXRQYXJlbnRPZmZzZXQ6IGZ1bmN0aW9uKCkge1xuXG5cdFx0Ly9HZXQgdGhlIG9mZnNldFBhcmVudCBhbmQgY2FjaGUgaXRzIHBvc2l0aW9uXG5cdFx0dGhpcy5vZmZzZXRQYXJlbnQgPSB0aGlzLmhlbHBlci5vZmZzZXRQYXJlbnQoKTtcblx0XHR2YXIgcG8gPSB0aGlzLm9mZnNldFBhcmVudC5vZmZzZXQoKTtcblxuXHRcdC8vIFRoaXMgaXMgYSBzcGVjaWFsIGNhc2Ugd2hlcmUgd2UgbmVlZCB0byBtb2RpZnkgYSBvZmZzZXQgY2FsY3VsYXRlZCBvbiBzdGFydCwgc2luY2UgdGhlXG5cdFx0Ly8gZm9sbG93aW5nIGhhcHBlbmVkOlxuXHRcdC8vIDEuIFRoZSBwb3NpdGlvbiBvZiB0aGUgaGVscGVyIGlzIGFic29sdXRlLCBzbyBpdCdzIHBvc2l0aW9uIGlzIGNhbGN1bGF0ZWQgYmFzZWQgb24gdGhlXG5cdFx0Ly8gbmV4dCBwb3NpdGlvbmVkIHBhcmVudFxuXHRcdC8vIDIuIFRoZSBhY3R1YWwgb2Zmc2V0IHBhcmVudCBpcyBhIGNoaWxkIG9mIHRoZSBzY3JvbGwgcGFyZW50LCBhbmQgdGhlIHNjcm9sbCBwYXJlbnQgaXNuJ3Rcblx0XHQvLyB0aGUgZG9jdW1lbnQsIHdoaWNoIG1lYW5zIHRoYXQgdGhlIHNjcm9sbCBpcyBpbmNsdWRlZCBpbiB0aGUgaW5pdGlhbCBjYWxjdWxhdGlvbiBvZiB0aGVcblx0XHQvLyBvZmZzZXQgb2YgdGhlIHBhcmVudCwgYW5kIG5ldmVyIHJlY2FsY3VsYXRlZCB1cG9uIGRyYWdcblx0XHRpZiAoIHRoaXMuY3NzUG9zaXRpb24gPT09IFwiYWJzb2x1dGVcIiAmJiB0aGlzLnNjcm9sbFBhcmVudFsgMCBdICE9PSB0aGlzLmRvY3VtZW50WyAwIF0gJiZcblx0XHRcdFx0JC5jb250YWlucyggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSwgdGhpcy5vZmZzZXRQYXJlbnRbIDAgXSApICkge1xuXHRcdFx0cG8ubGVmdCArPSB0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxMZWZ0KCk7XG5cdFx0XHRwby50b3AgKz0gdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKCk7XG5cdFx0fVxuXG5cdFx0Ly8gVGhpcyBuZWVkcyB0byBiZSBhY3R1YWxseSBkb25lIGZvciBhbGwgYnJvd3NlcnMsIHNpbmNlIHBhZ2VYL3BhZ2VZIGluY2x1ZGVzIHRoaXNcblx0XHQvLyBpbmZvcm1hdGlvbiB3aXRoIGFuIHVnbHkgSUUgZml4XG5cdFx0aWYgKCB0aGlzLm9mZnNldFBhcmVudFsgMCBdID09PSB0aGlzLmRvY3VtZW50WyAwIF0uYm9keSB8fFxuXHRcdFx0XHQoIHRoaXMub2Zmc2V0UGFyZW50WyAwIF0udGFnTmFtZSAmJlxuXHRcdFx0XHR0aGlzLm9mZnNldFBhcmVudFsgMCBdLnRhZ05hbWUudG9Mb3dlckNhc2UoKSA9PT0gXCJodG1sXCIgJiYgJC51aS5pZSApICkge1xuXHRcdFx0cG8gPSB7IHRvcDogMCwgbGVmdDogMCB9O1xuXHRcdH1cblxuXHRcdHJldHVybiB7XG5cdFx0XHR0b3A6IHBvLnRvcCArICggcGFyc2VJbnQoIHRoaXMub2Zmc2V0UGFyZW50LmNzcyggXCJib3JkZXJUb3BXaWR0aFwiICksIDEwICkgfHwgMCApLFxuXHRcdFx0bGVmdDogcG8ubGVmdCArICggcGFyc2VJbnQoIHRoaXMub2Zmc2V0UGFyZW50LmNzcyggXCJib3JkZXJMZWZ0V2lkdGhcIiApLCAxMCApIHx8IDAgKVxuXHRcdH07XG5cblx0fSxcblxuXHRfZ2V0UmVsYXRpdmVPZmZzZXQ6IGZ1bmN0aW9uKCkge1xuXG5cdFx0aWYgKCB0aGlzLmNzc1Bvc2l0aW9uID09PSBcInJlbGF0aXZlXCIgKSB7XG5cdFx0XHR2YXIgcCA9IHRoaXMuY3VycmVudEl0ZW0ucG9zaXRpb24oKTtcblx0XHRcdHJldHVybiB7XG5cdFx0XHRcdHRvcDogcC50b3AgLSAoIHBhcnNlSW50KCB0aGlzLmhlbHBlci5jc3MoIFwidG9wXCIgKSwgMTAgKSB8fCAwICkgK1xuXHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbFRvcCgpLFxuXHRcdFx0XHRsZWZ0OiBwLmxlZnQgLSAoIHBhcnNlSW50KCB0aGlzLmhlbHBlci5jc3MoIFwibGVmdFwiICksIDEwICkgfHwgMCApICtcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxMZWZ0KClcblx0XHRcdH07XG5cdFx0fSBlbHNlIHtcblx0XHRcdHJldHVybiB7IHRvcDogMCwgbGVmdDogMCB9O1xuXHRcdH1cblxuXHR9LFxuXG5cdF9jYWNoZU1hcmdpbnM6IGZ1bmN0aW9uKCkge1xuXHRcdHRoaXMubWFyZ2lucyA9IHtcblx0XHRcdGxlZnQ6ICggcGFyc2VJbnQoIHRoaXMuY3VycmVudEl0ZW0uY3NzKCBcIm1hcmdpbkxlZnRcIiApLCAxMCApIHx8IDAgKSxcblx0XHRcdHRvcDogKCBwYXJzZUludCggdGhpcy5jdXJyZW50SXRlbS5jc3MoIFwibWFyZ2luVG9wXCIgKSwgMTAgKSB8fCAwIClcblx0XHR9O1xuXHR9LFxuXG5cdF9jYWNoZUhlbHBlclByb3BvcnRpb25zOiBmdW5jdGlvbigpIHtcblx0XHR0aGlzLmhlbHBlclByb3BvcnRpb25zID0ge1xuXHRcdFx0d2lkdGg6IHRoaXMuaGVscGVyLm91dGVyV2lkdGgoKSxcblx0XHRcdGhlaWdodDogdGhpcy5oZWxwZXIub3V0ZXJIZWlnaHQoKVxuXHRcdH07XG5cdH0sXG5cblx0X3NldENvbnRhaW5tZW50OiBmdW5jdGlvbigpIHtcblxuXHRcdHZhciBjZSwgY28sIG92ZXIsXG5cdFx0XHRvID0gdGhpcy5vcHRpb25zO1xuXHRcdGlmICggby5jb250YWlubWVudCA9PT0gXCJwYXJlbnRcIiApIHtcblx0XHRcdG8uY29udGFpbm1lbnQgPSB0aGlzLmhlbHBlclsgMCBdLnBhcmVudE5vZGU7XG5cdFx0fVxuXHRcdGlmICggby5jb250YWlubWVudCA9PT0gXCJkb2N1bWVudFwiIHx8IG8uY29udGFpbm1lbnQgPT09IFwid2luZG93XCIgKSB7XG5cdFx0XHR0aGlzLmNvbnRhaW5tZW50ID0gW1xuXHRcdFx0XHQwIC0gdGhpcy5vZmZzZXQucmVsYXRpdmUubGVmdCAtIHRoaXMub2Zmc2V0LnBhcmVudC5sZWZ0LFxuXHRcdFx0XHQwIC0gdGhpcy5vZmZzZXQucmVsYXRpdmUudG9wIC0gdGhpcy5vZmZzZXQucGFyZW50LnRvcCxcblx0XHRcdFx0by5jb250YWlubWVudCA9PT0gXCJkb2N1bWVudFwiID9cblx0XHRcdFx0XHR0aGlzLmRvY3VtZW50LndpZHRoKCkgOlxuXHRcdFx0XHRcdHRoaXMud2luZG93LndpZHRoKCkgLSB0aGlzLmhlbHBlclByb3BvcnRpb25zLndpZHRoIC0gdGhpcy5tYXJnaW5zLmxlZnQsXG5cdFx0XHRcdCggby5jb250YWlubWVudCA9PT0gXCJkb2N1bWVudFwiID9cblx0XHRcdFx0XHQoIHRoaXMuZG9jdW1lbnQuaGVpZ2h0KCkgfHwgZG9jdW1lbnQuYm9keS5wYXJlbnROb2RlLnNjcm9sbEhlaWdodCApIDpcblx0XHRcdFx0XHR0aGlzLndpbmRvdy5oZWlnaHQoKSB8fCB0aGlzLmRvY3VtZW50WyAwIF0uYm9keS5wYXJlbnROb2RlLnNjcm9sbEhlaWdodFxuXHRcdFx0XHQpIC0gdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy5oZWlnaHQgLSB0aGlzLm1hcmdpbnMudG9wXG5cdFx0XHRdO1xuXHRcdH1cblxuXHRcdGlmICggISggL14oZG9jdW1lbnR8d2luZG93fHBhcmVudCkkLyApLnRlc3QoIG8uY29udGFpbm1lbnQgKSApIHtcblx0XHRcdGNlID0gJCggby5jb250YWlubWVudCApWyAwIF07XG5cdFx0XHRjbyA9ICQoIG8uY29udGFpbm1lbnQgKS5vZmZzZXQoKTtcblx0XHRcdG92ZXIgPSAoICQoIGNlICkuY3NzKCBcIm92ZXJmbG93XCIgKSAhPT0gXCJoaWRkZW5cIiApO1xuXG5cdFx0XHR0aGlzLmNvbnRhaW5tZW50ID0gW1xuXHRcdFx0XHRjby5sZWZ0ICsgKCBwYXJzZUludCggJCggY2UgKS5jc3MoIFwiYm9yZGVyTGVmdFdpZHRoXCIgKSwgMTAgKSB8fCAwICkgK1xuXHRcdFx0XHRcdCggcGFyc2VJbnQoICQoIGNlICkuY3NzKCBcInBhZGRpbmdMZWZ0XCIgKSwgMTAgKSB8fCAwICkgLSB0aGlzLm1hcmdpbnMubGVmdCxcblx0XHRcdFx0Y28udG9wICsgKCBwYXJzZUludCggJCggY2UgKS5jc3MoIFwiYm9yZGVyVG9wV2lkdGhcIiApLCAxMCApIHx8IDAgKSArXG5cdFx0XHRcdFx0KCBwYXJzZUludCggJCggY2UgKS5jc3MoIFwicGFkZGluZ1RvcFwiICksIDEwICkgfHwgMCApIC0gdGhpcy5tYXJnaW5zLnRvcCxcblx0XHRcdFx0Y28ubGVmdCArICggb3ZlciA/IE1hdGgubWF4KCBjZS5zY3JvbGxXaWR0aCwgY2Uub2Zmc2V0V2lkdGggKSA6IGNlLm9mZnNldFdpZHRoICkgLVxuXHRcdFx0XHRcdCggcGFyc2VJbnQoICQoIGNlICkuY3NzKCBcImJvcmRlckxlZnRXaWR0aFwiICksIDEwICkgfHwgMCApIC1cblx0XHRcdFx0XHQoIHBhcnNlSW50KCAkKCBjZSApLmNzcyggXCJwYWRkaW5nUmlnaHRcIiApLCAxMCApIHx8IDAgKSAtXG5cdFx0XHRcdFx0dGhpcy5oZWxwZXJQcm9wb3J0aW9ucy53aWR0aCAtIHRoaXMubWFyZ2lucy5sZWZ0LFxuXHRcdFx0XHRjby50b3AgKyAoIG92ZXIgPyBNYXRoLm1heCggY2Uuc2Nyb2xsSGVpZ2h0LCBjZS5vZmZzZXRIZWlnaHQgKSA6IGNlLm9mZnNldEhlaWdodCApIC1cblx0XHRcdFx0XHQoIHBhcnNlSW50KCAkKCBjZSApLmNzcyggXCJib3JkZXJUb3BXaWR0aFwiICksIDEwICkgfHwgMCApIC1cblx0XHRcdFx0XHQoIHBhcnNlSW50KCAkKCBjZSApLmNzcyggXCJwYWRkaW5nQm90dG9tXCIgKSwgMTAgKSB8fCAwICkgLVxuXHRcdFx0XHRcdHRoaXMuaGVscGVyUHJvcG9ydGlvbnMuaGVpZ2h0IC0gdGhpcy5tYXJnaW5zLnRvcFxuXHRcdFx0XTtcblx0XHR9XG5cblx0fSxcblxuXHRfY29udmVydFBvc2l0aW9uVG86IGZ1bmN0aW9uKCBkLCBwb3MgKSB7XG5cblx0XHRpZiAoICFwb3MgKSB7XG5cdFx0XHRwb3MgPSB0aGlzLnBvc2l0aW9uO1xuXHRcdH1cblx0XHR2YXIgbW9kID0gZCA9PT0gXCJhYnNvbHV0ZVwiID8gMSA6IC0xLFxuXHRcdFx0c2Nyb2xsID0gdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJhYnNvbHV0ZVwiICYmXG5cdFx0XHRcdCEoIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0gIT09IHRoaXMuZG9jdW1lbnRbIDAgXSAmJlxuXHRcdFx0XHQkLmNvbnRhaW5zKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdLCB0aGlzLm9mZnNldFBhcmVudFsgMCBdICkgKSA/XG5cdFx0XHRcdFx0dGhpcy5vZmZzZXRQYXJlbnQgOlxuXHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50LFxuXHRcdFx0c2Nyb2xsSXNSb290Tm9kZSA9ICggLyhodG1sfGJvZHkpL2kgKS50ZXN0KCBzY3JvbGxbIDAgXS50YWdOYW1lICk7XG5cblx0XHRyZXR1cm4ge1xuXHRcdFx0dG9wOiAoXG5cblx0XHRcdFx0Ly8gVGhlIGFic29sdXRlIG1vdXNlIHBvc2l0aW9uXG5cdFx0XHRcdHBvcy50b3BcdCtcblxuXHRcdFx0XHQvLyBPbmx5IGZvciByZWxhdGl2ZSBwb3NpdGlvbmVkIG5vZGVzOiBSZWxhdGl2ZSBvZmZzZXQgZnJvbSBlbGVtZW50IHRvIG9mZnNldCBwYXJlbnRcblx0XHRcdFx0dGhpcy5vZmZzZXQucmVsYXRpdmUudG9wICogbW9kICtcblxuXHRcdFx0XHQvLyBUaGUgb2Zmc2V0UGFyZW50J3Mgb2Zmc2V0IHdpdGhvdXQgYm9yZGVycyAob2Zmc2V0ICsgYm9yZGVyKVxuXHRcdFx0XHR0aGlzLm9mZnNldC5wYXJlbnQudG9wICogbW9kIC1cblx0XHRcdFx0KCAoIHRoaXMuY3NzUG9zaXRpb24gPT09IFwiZml4ZWRcIiA/XG5cdFx0XHRcdFx0LXRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbFRvcCgpIDpcblx0XHRcdFx0XHQoIHNjcm9sbElzUm9vdE5vZGUgPyAwIDogc2Nyb2xsLnNjcm9sbFRvcCgpICkgKSAqIG1vZCApXG5cdFx0XHQpLFxuXHRcdFx0bGVmdDogKFxuXG5cdFx0XHRcdC8vIFRoZSBhYnNvbHV0ZSBtb3VzZSBwb3NpdGlvblxuXHRcdFx0XHRwb3MubGVmdCArXG5cblx0XHRcdFx0Ly8gT25seSBmb3IgcmVsYXRpdmUgcG9zaXRpb25lZCBub2RlczogUmVsYXRpdmUgb2Zmc2V0IGZyb20gZWxlbWVudCB0byBvZmZzZXQgcGFyZW50XG5cdFx0XHRcdHRoaXMub2Zmc2V0LnJlbGF0aXZlLmxlZnQgKiBtb2QgK1xuXG5cdFx0XHRcdC8vIFRoZSBvZmZzZXRQYXJlbnQncyBvZmZzZXQgd2l0aG91dCBib3JkZXJzIChvZmZzZXQgKyBib3JkZXIpXG5cdFx0XHRcdHRoaXMub2Zmc2V0LnBhcmVudC5sZWZ0ICogbW9kXHQtXG5cdFx0XHRcdCggKCB0aGlzLmNzc1Bvc2l0aW9uID09PSBcImZpeGVkXCIgP1xuXHRcdFx0XHRcdC10aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxMZWZ0KCkgOiBzY3JvbGxJc1Jvb3ROb2RlID8gMCA6XG5cdFx0XHRcdFx0c2Nyb2xsLnNjcm9sbExlZnQoKSApICogbW9kIClcblx0XHRcdClcblx0XHR9O1xuXG5cdH0sXG5cblx0X2dlbmVyYXRlUG9zaXRpb246IGZ1bmN0aW9uKCBldmVudCApIHtcblxuXHRcdHZhciB0b3AsIGxlZnQsXG5cdFx0XHRvID0gdGhpcy5vcHRpb25zLFxuXHRcdFx0cGFnZVggPSBldmVudC5wYWdlWCxcblx0XHRcdHBhZ2VZID0gZXZlbnQucGFnZVksXG5cdFx0XHRzY3JvbGwgPSB0aGlzLmNzc1Bvc2l0aW9uID09PSBcImFic29sdXRlXCIgJiZcblx0XHRcdFx0ISggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSAhPT0gdGhpcy5kb2N1bWVudFsgMCBdICYmXG5cdFx0XHRcdCQuY29udGFpbnMoIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0sIHRoaXMub2Zmc2V0UGFyZW50WyAwIF0gKSApID9cblx0XHRcdFx0XHR0aGlzLm9mZnNldFBhcmVudCA6XG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQsXG5cdFx0XHRcdHNjcm9sbElzUm9vdE5vZGUgPSAoIC8oaHRtbHxib2R5KS9pICkudGVzdCggc2Nyb2xsWyAwIF0udGFnTmFtZSApO1xuXG5cdFx0Ly8gVGhpcyBpcyBhbm90aGVyIHZlcnkgd2VpcmQgc3BlY2lhbCBjYXNlIHRoYXQgb25seSBoYXBwZW5zIGZvciByZWxhdGl2ZSBlbGVtZW50czpcblx0XHQvLyAxLiBJZiB0aGUgY3NzIHBvc2l0aW9uIGlzIHJlbGF0aXZlXG5cdFx0Ly8gMi4gYW5kIHRoZSBzY3JvbGwgcGFyZW50IGlzIHRoZSBkb2N1bWVudCBvciBzaW1pbGFyIHRvIHRoZSBvZmZzZXQgcGFyZW50XG5cdFx0Ly8gd2UgaGF2ZSB0byByZWZyZXNoIHRoZSByZWxhdGl2ZSBvZmZzZXQgZHVyaW5nIHRoZSBzY3JvbGwgc28gdGhlcmUgYXJlIG5vIGp1bXBzXG5cdFx0aWYgKCB0aGlzLmNzc1Bvc2l0aW9uID09PSBcInJlbGF0aXZlXCIgJiYgISggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSAhPT0gdGhpcy5kb2N1bWVudFsgMCBdICYmXG5cdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0gIT09IHRoaXMub2Zmc2V0UGFyZW50WyAwIF0gKSApIHtcblx0XHRcdHRoaXMub2Zmc2V0LnJlbGF0aXZlID0gdGhpcy5fZ2V0UmVsYXRpdmVPZmZzZXQoKTtcblx0XHR9XG5cblx0XHQvKlxuXHRcdCAqIC0gUG9zaXRpb24gY29uc3RyYWluaW5nIC1cblx0XHQgKiBDb25zdHJhaW4gdGhlIHBvc2l0aW9uIHRvIGEgbWl4IG9mIGdyaWQsIGNvbnRhaW5tZW50LlxuXHRcdCAqL1xuXG5cdFx0aWYgKCB0aGlzLm9yaWdpbmFsUG9zaXRpb24gKSB7IC8vSWYgd2UgYXJlIG5vdCBkcmFnZ2luZyB5ZXQsIHdlIHdvbid0IGNoZWNrIGZvciBvcHRpb25zXG5cblx0XHRcdGlmICggdGhpcy5jb250YWlubWVudCApIHtcblx0XHRcdFx0aWYgKCBldmVudC5wYWdlWCAtIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQgPCB0aGlzLmNvbnRhaW5tZW50WyAwIF0gKSB7XG5cdFx0XHRcdFx0cGFnZVggPSB0aGlzLmNvbnRhaW5tZW50WyAwIF0gKyB0aGlzLm9mZnNldC5jbGljay5sZWZ0O1xuXHRcdFx0XHR9XG5cdFx0XHRcdGlmICggZXZlbnQucGFnZVkgLSB0aGlzLm9mZnNldC5jbGljay50b3AgPCB0aGlzLmNvbnRhaW5tZW50WyAxIF0gKSB7XG5cdFx0XHRcdFx0cGFnZVkgPSB0aGlzLmNvbnRhaW5tZW50WyAxIF0gKyB0aGlzLm9mZnNldC5jbGljay50b3A7XG5cdFx0XHRcdH1cblx0XHRcdFx0aWYgKCBldmVudC5wYWdlWCAtIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQgPiB0aGlzLmNvbnRhaW5tZW50WyAyIF0gKSB7XG5cdFx0XHRcdFx0cGFnZVggPSB0aGlzLmNvbnRhaW5tZW50WyAyIF0gKyB0aGlzLm9mZnNldC5jbGljay5sZWZ0O1xuXHRcdFx0XHR9XG5cdFx0XHRcdGlmICggZXZlbnQucGFnZVkgLSB0aGlzLm9mZnNldC5jbGljay50b3AgPiB0aGlzLmNvbnRhaW5tZW50WyAzIF0gKSB7XG5cdFx0XHRcdFx0cGFnZVkgPSB0aGlzLmNvbnRhaW5tZW50WyAzIF0gKyB0aGlzLm9mZnNldC5jbGljay50b3A7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0aWYgKCBvLmdyaWQgKSB7XG5cdFx0XHRcdHRvcCA9IHRoaXMub3JpZ2luYWxQYWdlWSArIE1hdGgucm91bmQoICggcGFnZVkgLSB0aGlzLm9yaWdpbmFsUGFnZVkgKSAvXG5cdFx0XHRcdFx0by5ncmlkWyAxIF0gKSAqIG8uZ3JpZFsgMSBdO1xuXHRcdFx0XHRwYWdlWSA9IHRoaXMuY29udGFpbm1lbnQgP1xuXHRcdFx0XHRcdCggKCB0b3AgLSB0aGlzLm9mZnNldC5jbGljay50b3AgPj0gdGhpcy5jb250YWlubWVudFsgMSBdICYmXG5cdFx0XHRcdFx0XHR0b3AgLSB0aGlzLm9mZnNldC5jbGljay50b3AgPD0gdGhpcy5jb250YWlubWVudFsgMyBdICkgP1xuXHRcdFx0XHRcdFx0XHR0b3AgOlxuXHRcdFx0XHRcdFx0XHQoICggdG9wIC0gdGhpcy5vZmZzZXQuY2xpY2sudG9wID49IHRoaXMuY29udGFpbm1lbnRbIDEgXSApID9cblx0XHRcdFx0XHRcdFx0XHR0b3AgLSBvLmdyaWRbIDEgXSA6IHRvcCArIG8uZ3JpZFsgMSBdICkgKSA6XG5cdFx0XHRcdFx0XHRcdFx0dG9wO1xuXG5cdFx0XHRcdGxlZnQgPSB0aGlzLm9yaWdpbmFsUGFnZVggKyBNYXRoLnJvdW5kKCAoIHBhZ2VYIC0gdGhpcy5vcmlnaW5hbFBhZ2VYICkgL1xuXHRcdFx0XHRcdG8uZ3JpZFsgMCBdICkgKiBvLmdyaWRbIDAgXTtcblx0XHRcdFx0cGFnZVggPSB0aGlzLmNvbnRhaW5tZW50ID9cblx0XHRcdFx0XHQoICggbGVmdCAtIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQgPj0gdGhpcy5jb250YWlubWVudFsgMCBdICYmXG5cdFx0XHRcdFx0XHRsZWZ0IC0gdGhpcy5vZmZzZXQuY2xpY2subGVmdCA8PSB0aGlzLmNvbnRhaW5tZW50WyAyIF0gKSA/XG5cdFx0XHRcdFx0XHRcdGxlZnQgOlxuXHRcdFx0XHRcdFx0XHQoICggbGVmdCAtIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQgPj0gdGhpcy5jb250YWlubWVudFsgMCBdICkgP1xuXHRcdFx0XHRcdFx0XHRcdGxlZnQgLSBvLmdyaWRbIDAgXSA6IGxlZnQgKyBvLmdyaWRbIDAgXSApICkgOlxuXHRcdFx0XHRcdFx0XHRcdGxlZnQ7XG5cdFx0XHR9XG5cblx0XHR9XG5cblx0XHRyZXR1cm4ge1xuXHRcdFx0dG9wOiAoXG5cblx0XHRcdFx0Ly8gVGhlIGFic29sdXRlIG1vdXNlIHBvc2l0aW9uXG5cdFx0XHRcdHBhZ2VZIC1cblxuXHRcdFx0XHQvLyBDbGljayBvZmZzZXQgKHJlbGF0aXZlIHRvIHRoZSBlbGVtZW50KVxuXHRcdFx0XHR0aGlzLm9mZnNldC5jbGljay50b3AgLVxuXG5cdFx0XHRcdC8vIE9ubHkgZm9yIHJlbGF0aXZlIHBvc2l0aW9uZWQgbm9kZXM6IFJlbGF0aXZlIG9mZnNldCBmcm9tIGVsZW1lbnQgdG8gb2Zmc2V0IHBhcmVudFxuXHRcdFx0XHR0aGlzLm9mZnNldC5yZWxhdGl2ZS50b3AgLVxuXG5cdFx0XHRcdC8vIFRoZSBvZmZzZXRQYXJlbnQncyBvZmZzZXQgd2l0aG91dCBib3JkZXJzIChvZmZzZXQgKyBib3JkZXIpXG5cdFx0XHRcdHRoaXMub2Zmc2V0LnBhcmVudC50b3AgK1xuXHRcdFx0XHQoICggdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJmaXhlZFwiID9cblx0XHRcdFx0XHQtdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKCkgOlxuXHRcdFx0XHRcdCggc2Nyb2xsSXNSb290Tm9kZSA/IDAgOiBzY3JvbGwuc2Nyb2xsVG9wKCkgKSApIClcblx0XHRcdCksXG5cdFx0XHRsZWZ0OiAoXG5cblx0XHRcdFx0Ly8gVGhlIGFic29sdXRlIG1vdXNlIHBvc2l0aW9uXG5cdFx0XHRcdHBhZ2VYIC1cblxuXHRcdFx0XHQvLyBDbGljayBvZmZzZXQgKHJlbGF0aXZlIHRvIHRoZSBlbGVtZW50KVxuXHRcdFx0XHR0aGlzLm9mZnNldC5jbGljay5sZWZ0IC1cblxuXHRcdFx0XHQvLyBPbmx5IGZvciByZWxhdGl2ZSBwb3NpdGlvbmVkIG5vZGVzOiBSZWxhdGl2ZSBvZmZzZXQgZnJvbSBlbGVtZW50IHRvIG9mZnNldCBwYXJlbnRcblx0XHRcdFx0dGhpcy5vZmZzZXQucmVsYXRpdmUubGVmdCAtXG5cblx0XHRcdFx0Ly8gVGhlIG9mZnNldFBhcmVudCdzIG9mZnNldCB3aXRob3V0IGJvcmRlcnMgKG9mZnNldCArIGJvcmRlcilcblx0XHRcdFx0dGhpcy5vZmZzZXQucGFyZW50LmxlZnQgK1xuXHRcdFx0XHQoICggdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJmaXhlZFwiID9cblx0XHRcdFx0XHQtdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdCgpIDpcblx0XHRcdFx0XHRzY3JvbGxJc1Jvb3ROb2RlID8gMCA6IHNjcm9sbC5zY3JvbGxMZWZ0KCkgKSApXG5cdFx0XHQpXG5cdFx0fTtcblxuXHR9LFxuXG5cdF9yZWFycmFuZ2U6IGZ1bmN0aW9uKCBldmVudCwgaSwgYSwgaGFyZFJlZnJlc2ggKSB7XG5cblx0XHRhID8gYVsgMCBdLmFwcGVuZENoaWxkKCB0aGlzLnBsYWNlaG9sZGVyWyAwIF0gKSA6XG5cdFx0XHRpLml0ZW1bIDAgXS5wYXJlbnROb2RlLmluc2VydEJlZm9yZSggdGhpcy5wbGFjZWhvbGRlclsgMCBdLFxuXHRcdFx0XHQoIHRoaXMuZGlyZWN0aW9uID09PSBcImRvd25cIiA/IGkuaXRlbVsgMCBdIDogaS5pdGVtWyAwIF0ubmV4dFNpYmxpbmcgKSApO1xuXG5cdFx0Ly9WYXJpb3VzIHRoaW5ncyBkb25lIGhlcmUgdG8gaW1wcm92ZSB0aGUgcGVyZm9ybWFuY2U6XG5cdFx0Ly8gMS4gd2UgY3JlYXRlIGEgc2V0VGltZW91dCwgdGhhdCBjYWxscyByZWZyZXNoUG9zaXRpb25zXG5cdFx0Ly8gMi4gb24gdGhlIGluc3RhbmNlLCB3ZSBoYXZlIGEgY291bnRlciB2YXJpYWJsZSwgdGhhdCBnZXQncyBoaWdoZXIgYWZ0ZXIgZXZlcnkgYXBwZW5kXG5cdFx0Ly8gMy4gb24gdGhlIGxvY2FsIHNjb3BlLCB3ZSBjb3B5IHRoZSBjb3VudGVyIHZhcmlhYmxlLCBhbmQgY2hlY2sgaW4gdGhlIHRpbWVvdXQsXG5cdFx0Ly8gaWYgaXQncyBzdGlsbCB0aGUgc2FtZVxuXHRcdC8vIDQuIHRoaXMgbGV0cyBvbmx5IHRoZSBsYXN0IGFkZGl0aW9uIHRvIHRoZSB0aW1lb3V0IHN0YWNrIHRocm91Z2hcblx0XHR0aGlzLmNvdW50ZXIgPSB0aGlzLmNvdW50ZXIgPyArK3RoaXMuY291bnRlciA6IDE7XG5cdFx0dmFyIGNvdW50ZXIgPSB0aGlzLmNvdW50ZXI7XG5cblx0XHR0aGlzLl9kZWxheSggZnVuY3Rpb24oKSB7XG5cdFx0XHRpZiAoIGNvdW50ZXIgPT09IHRoaXMuY291bnRlciApIHtcblxuXHRcdFx0XHQvL1ByZWNvbXB1dGUgYWZ0ZXIgZWFjaCBET00gaW5zZXJ0aW9uLCBOT1Qgb24gbW91c2Vtb3ZlXG5cdFx0XHRcdHRoaXMucmVmcmVzaFBvc2l0aW9ucyggIWhhcmRSZWZyZXNoICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXG5cdH0sXG5cblx0X2NsZWFyOiBmdW5jdGlvbiggZXZlbnQsIG5vUHJvcGFnYXRpb24gKSB7XG5cblx0XHR0aGlzLnJldmVydGluZyA9IGZhbHNlO1xuXG5cdFx0Ly8gV2UgZGVsYXkgYWxsIGV2ZW50cyB0aGF0IGhhdmUgdG8gYmUgdHJpZ2dlcmVkIHRvIGFmdGVyIHRoZSBwb2ludCB3aGVyZSB0aGUgcGxhY2Vob2xkZXJcblx0XHQvLyBoYXMgYmVlbiByZW1vdmVkIGFuZCBldmVyeXRoaW5nIGVsc2Ugbm9ybWFsaXplZCBhZ2FpblxuXHRcdHZhciBpLFxuXHRcdFx0ZGVsYXllZFRyaWdnZXJzID0gW107XG5cblx0XHQvLyBXZSBmaXJzdCBoYXZlIHRvIHVwZGF0ZSB0aGUgZG9tIHBvc2l0aW9uIG9mIHRoZSBhY3R1YWwgY3VycmVudEl0ZW1cblx0XHQvLyBOb3RlOiBkb24ndCBkbyBpdCBpZiB0aGUgY3VycmVudCBpdGVtIGlzIGFscmVhZHkgcmVtb3ZlZCAoYnkgYSB1c2VyKSwgb3IgaXQgZ2V0c1xuXHRcdC8vIHJlYXBwZW5kZWQgKHNlZSAjNDA4OClcblx0XHRpZiAoICF0aGlzLl9ub0ZpbmFsU29ydCAmJiB0aGlzLmN1cnJlbnRJdGVtLnBhcmVudCgpLmxlbmd0aCApIHtcblx0XHRcdHRoaXMucGxhY2Vob2xkZXIuYmVmb3JlKCB0aGlzLmN1cnJlbnRJdGVtICk7XG5cdFx0fVxuXHRcdHRoaXMuX25vRmluYWxTb3J0ID0gbnVsbDtcblxuXHRcdGlmICggdGhpcy5oZWxwZXJbIDAgXSA9PT0gdGhpcy5jdXJyZW50SXRlbVsgMCBdICkge1xuXHRcdFx0Zm9yICggaSBpbiB0aGlzLl9zdG9yZWRDU1MgKSB7XG5cdFx0XHRcdGlmICggdGhpcy5fc3RvcmVkQ1NTWyBpIF0gPT09IFwiYXV0b1wiIHx8IHRoaXMuX3N0b3JlZENTU1sgaSBdID09PSBcInN0YXRpY1wiICkge1xuXHRcdFx0XHRcdHRoaXMuX3N0b3JlZENTU1sgaSBdID0gXCJcIjtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdFx0dGhpcy5jdXJyZW50SXRlbS5jc3MoIHRoaXMuX3N0b3JlZENTUyApO1xuXHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoIHRoaXMuY3VycmVudEl0ZW0sIFwidWktc29ydGFibGUtaGVscGVyXCIgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0dGhpcy5jdXJyZW50SXRlbS5zaG93KCk7XG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLmZyb21PdXRzaWRlICYmICFub1Byb3BhZ2F0aW9uICkge1xuXHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0dGhpcy5fdHJpZ2dlciggXCJyZWNlaXZlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMuZnJvbU91dHNpZGUgKSApO1xuXHRcdFx0fSApO1xuXHRcdH1cblx0XHRpZiAoICggdGhpcy5mcm9tT3V0c2lkZSB8fFxuXHRcdFx0XHR0aGlzLmRvbVBvc2l0aW9uLnByZXYgIT09XG5cdFx0XHRcdHRoaXMuY3VycmVudEl0ZW0ucHJldigpLm5vdCggXCIudWktc29ydGFibGUtaGVscGVyXCIgKVsgMCBdIHx8XG5cdFx0XHRcdHRoaXMuZG9tUG9zaXRpb24ucGFyZW50ICE9PSB0aGlzLmN1cnJlbnRJdGVtLnBhcmVudCgpWyAwIF0gKSAmJiAhbm9Qcm9wYWdhdGlvbiApIHtcblxuXHRcdFx0Ly8gVHJpZ2dlciB1cGRhdGUgY2FsbGJhY2sgaWYgdGhlIERPTSBwb3NpdGlvbiBoYXMgY2hhbmdlZFxuXHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0dGhpcy5fdHJpZ2dlciggXCJ1cGRhdGVcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cdFx0XHR9ICk7XG5cdFx0fVxuXG5cdFx0Ly8gQ2hlY2sgaWYgdGhlIGl0ZW1zIENvbnRhaW5lciBoYXMgQ2hhbmdlZCBhbmQgdHJpZ2dlciBhcHByb3ByaWF0ZVxuXHRcdC8vIGV2ZW50cy5cblx0XHRpZiAoIHRoaXMgIT09IHRoaXMuY3VycmVudENvbnRhaW5lciApIHtcblx0XHRcdGlmICggIW5vUHJvcGFnYXRpb24gKSB7XG5cdFx0XHRcdGRlbGF5ZWRUcmlnZ2Vycy5wdXNoKCBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdFx0dGhpcy5fdHJpZ2dlciggXCJyZW1vdmVcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cdFx0XHRcdH0gKTtcblx0XHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goICggZnVuY3Rpb24oIGMgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0XHRcdGMuX3RyaWdnZXIoIFwicmVjZWl2ZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCB0aGlzICkgKTtcblx0XHRcdFx0XHR9O1xuXHRcdFx0XHR9ICkuY2FsbCggdGhpcywgdGhpcy5jdXJyZW50Q29udGFpbmVyICkgKTtcblx0XHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goICggZnVuY3Rpb24oIGMgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0XHRcdGMuX3RyaWdnZXIoIFwidXBkYXRlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0XHRcdH07XG5cdFx0XHRcdH0gKS5jYWxsKCB0aGlzLCB0aGlzLmN1cnJlbnRDb250YWluZXIgKSApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vUG9zdCBldmVudHMgdG8gY29udGFpbmVyc1xuXHRcdGZ1bmN0aW9uIGRlbGF5RXZlbnQoIHR5cGUsIGluc3RhbmNlLCBjb250YWluZXIgKSB7XG5cdFx0XHRyZXR1cm4gZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHRjb250YWluZXIuX3RyaWdnZXIoIHR5cGUsIGV2ZW50LCBpbnN0YW5jZS5fdWlIYXNoKCBpbnN0YW5jZSApICk7XG5cdFx0XHR9O1xuXHRcdH1cblx0XHRmb3IgKCBpID0gdGhpcy5jb250YWluZXJzLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0aWYgKCAhbm9Qcm9wYWdhdGlvbiApIHtcblx0XHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goIGRlbGF5RXZlbnQoIFwiZGVhY3RpdmF0ZVwiLCB0aGlzLCB0aGlzLmNvbnRhaW5lcnNbIGkgXSApICk7XG5cdFx0XHR9XG5cdFx0XHRpZiAoIHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLm92ZXIgKSB7XG5cdFx0XHRcdGRlbGF5ZWRUcmlnZ2Vycy5wdXNoKCBkZWxheUV2ZW50KCBcIm91dFwiLCB0aGlzLCB0aGlzLmNvbnRhaW5lcnNbIGkgXSApICk7XG5cdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLm92ZXIgPSAwO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vRG8gd2hhdCB3YXMgb3JpZ2luYWxseSBpbiBwbHVnaW5zXG5cdFx0aWYgKCB0aGlzLnN0b3JlZEN1cnNvciApIHtcblx0XHRcdHRoaXMuZG9jdW1lbnQuZmluZCggXCJib2R5XCIgKS5jc3MoIFwiY3Vyc29yXCIsIHRoaXMuc3RvcmVkQ3Vyc29yICk7XG5cdFx0XHR0aGlzLnN0b3JlZFN0eWxlc2hlZXQucmVtb3ZlKCk7XG5cdFx0fVxuXHRcdGlmICggdGhpcy5fc3RvcmVkT3BhY2l0eSApIHtcblx0XHRcdHRoaXMuaGVscGVyLmNzcyggXCJvcGFjaXR5XCIsIHRoaXMuX3N0b3JlZE9wYWNpdHkgKTtcblx0XHR9XG5cdFx0aWYgKCB0aGlzLl9zdG9yZWRaSW5kZXggKSB7XG5cdFx0XHR0aGlzLmhlbHBlci5jc3MoIFwiekluZGV4XCIsIHRoaXMuX3N0b3JlZFpJbmRleCA9PT0gXCJhdXRvXCIgPyBcIlwiIDogdGhpcy5fc3RvcmVkWkluZGV4ICk7XG5cdFx0fVxuXG5cdFx0dGhpcy5kcmFnZ2luZyA9IGZhbHNlO1xuXG5cdFx0aWYgKCAhbm9Qcm9wYWdhdGlvbiApIHtcblx0XHRcdHRoaXMuX3RyaWdnZXIoIFwiYmVmb3JlU3RvcFwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHR9XG5cblx0XHQvLyQodGhpcy5wbGFjZWhvbGRlclswXSkucmVtb3ZlKCk7IHdvdWxkIGhhdmUgYmVlbiB0aGUgalF1ZXJ5IHdheSAtIHVuZm9ydHVuYXRlbHksXG5cdFx0Ly8gaXQgdW5iaW5kcyBBTEwgZXZlbnRzIGZyb20gdGhlIG9yaWdpbmFsIG5vZGUhXG5cdFx0dGhpcy5wbGFjZWhvbGRlclsgMCBdLnBhcmVudE5vZGUucmVtb3ZlQ2hpbGQoIHRoaXMucGxhY2Vob2xkZXJbIDAgXSApO1xuXG5cdFx0aWYgKCAhdGhpcy5jYW5jZWxIZWxwZXJSZW1vdmFsICkge1xuXHRcdFx0aWYgKCB0aGlzLmhlbHBlclsgMCBdICE9PSB0aGlzLmN1cnJlbnRJdGVtWyAwIF0gKSB7XG5cdFx0XHRcdHRoaXMuaGVscGVyLnJlbW92ZSgpO1xuXHRcdFx0fVxuXHRcdFx0dGhpcy5oZWxwZXIgPSBudWxsO1xuXHRcdH1cblxuXHRcdGlmICggIW5vUHJvcGFnYXRpb24gKSB7XG5cdFx0XHRmb3IgKCBpID0gMDsgaSA8IGRlbGF5ZWRUcmlnZ2Vycy5sZW5ndGg7IGkrKyApIHtcblxuXHRcdFx0XHQvLyBUcmlnZ2VyIGFsbCBkZWxheWVkIGV2ZW50c1xuXHRcdFx0XHRkZWxheWVkVHJpZ2dlcnNbIGkgXS5jYWxsKCB0aGlzLCBldmVudCApO1xuXHRcdFx0fVxuXHRcdFx0dGhpcy5fdHJpZ2dlciggXCJzdG9wXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSApO1xuXHRcdH1cblxuXHRcdHRoaXMuZnJvbU91dHNpZGUgPSBmYWxzZTtcblx0XHRyZXR1cm4gIXRoaXMuY2FuY2VsSGVscGVyUmVtb3ZhbDtcblxuXHR9LFxuXG5cdF90cmlnZ2VyOiBmdW5jdGlvbigpIHtcblx0XHRpZiAoICQuV2lkZ2V0LnByb3RvdHlwZS5fdHJpZ2dlci5hcHBseSggdGhpcywgYXJndW1lbnRzICkgPT09IGZhbHNlICkge1xuXHRcdFx0dGhpcy5jYW5jZWwoKTtcblx0XHR9XG5cdH0sXG5cblx0X3VpSGFzaDogZnVuY3Rpb24oIF9pbnN0ICkge1xuXHRcdHZhciBpbnN0ID0gX2luc3QgfHwgdGhpcztcblx0XHRyZXR1cm4ge1xuXHRcdFx0aGVscGVyOiBpbnN0LmhlbHBlcixcblx0XHRcdHBsYWNlaG9sZGVyOiBpbnN0LnBsYWNlaG9sZGVyIHx8ICQoIFtdICksXG5cdFx0XHRwb3NpdGlvbjogaW5zdC5wb3NpdGlvbixcblx0XHRcdG9yaWdpbmFsUG9zaXRpb246IGluc3Qub3JpZ2luYWxQb3NpdGlvbixcblx0XHRcdG9mZnNldDogaW5zdC5wb3NpdGlvbkFicyxcblx0XHRcdGl0ZW06IGluc3QuY3VycmVudEl0ZW0sXG5cdFx0XHRzZW5kZXI6IF9pbnN0ID8gX2luc3QuZWxlbWVudCA6IG51bGxcblx0XHR9O1xuXHR9XG5cbn0gKTtcblxufSApICk7XG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDIwKTsiLCIvKlxuICogalF1ZXJ5IFVJIE5lc3RlZCBTb3J0YWJsZVxuICogdiAyLjFhIC8gMjAxNi0wMi0wNFxuICogaHR0cHM6Ly9naXRodWIuY29tL2lsaWtlbndmL25lc3RlZFNvcnRhYmxlXG4gKlxuICogRGVwZW5kcyBvbjpcbiAqXHQganF1ZXJ5LnVpLnNvcnRhYmxlLmpzIDEuMTArXG4gKlxuICogQ29weXJpZ2h0IChjKSAyMDEwLTIwMTYgTWFudWVsZSBKIFNhcmZhdHRpIGFuZCBjb250cmlidXRvcnNcbiAqIExpY2Vuc2VkIHVuZGVyIHRoZSBNSVQgTGljZW5zZVxuICogaHR0cDovL3d3dy5vcGVuc291cmNlLm9yZy9saWNlbnNlcy9taXQtbGljZW5zZS5waHBcbiAqL1xuKGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRcInVzZSBzdHJpY3RcIjtcblxuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZShbXG5cdFx0XHRcImpxdWVyeVwiLFxuXHRcdFx0XCJqcXVlcnktdWkvc29ydGFibGVcIlxuXHRcdF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIHdpbmRvdy5qUXVlcnkgKTtcblx0fVxufShmdW5jdGlvbigkKSB7XG5cdFwidXNlIHN0cmljdFwiO1xuXG5cdGZ1bmN0aW9uIGlzT3ZlckF4aXMoIHgsIHJlZmVyZW5jZSwgc2l6ZSApIHtcblx0XHRyZXR1cm4gKCB4ID4gcmVmZXJlbmNlICkgJiYgKCB4IDwgKCByZWZlcmVuY2UgKyBzaXplICkgKTtcblx0fVxuXG5cdCQud2lkZ2V0KFwibWpzLm5lc3RlZFNvcnRhYmxlXCIsICQuZXh0ZW5kKHt9LCAkLnVpLnNvcnRhYmxlLnByb3RvdHlwZSwge1xuXG5cdFx0b3B0aW9uczoge1xuXHRcdFx0ZGlzYWJsZVBhcmVudENoYW5nZTogZmFsc2UsXG5cdFx0XHRkb05vdENsZWFyOiBmYWxzZSxcblx0XHRcdGV4cGFuZE9uSG92ZXI6IDcwMCxcblx0XHRcdGlzQWxsb3dlZDogZnVuY3Rpb24oKSB7IHJldHVybiB0cnVlOyB9LFxuXHRcdFx0aXNUcmVlOiBmYWxzZSxcblx0XHRcdGxpc3RUeXBlOiBcIm9sXCIsXG5cdFx0XHRtYXhMZXZlbHM6IDAsXG5cdFx0XHRwcm90ZWN0Um9vdDogZmFsc2UsXG5cdFx0XHRyb290SUQ6IG51bGwsXG5cdFx0XHRydGw6IGZhbHNlLFxuXHRcdFx0c3RhcnRDb2xsYXBzZWQ6IGZhbHNlLFxuXHRcdFx0dGFiU2l6ZTogMjAsXG5cblx0XHRcdGJyYW5jaENsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1icmFuY2hcIixcblx0XHRcdGNvbGxhcHNlZENsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1jb2xsYXBzZWRcIixcblx0XHRcdGRpc2FibGVOZXN0aW5nQ2xhc3M6IFwibWpzLW5lc3RlZFNvcnRhYmxlLW5vLW5lc3RpbmdcIixcblx0XHRcdGVycm9yQ2xhc3M6IFwibWpzLW5lc3RlZFNvcnRhYmxlLWVycm9yXCIsXG5cdFx0XHRleHBhbmRlZENsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1leHBhbmRlZFwiLFxuXHRcdFx0aG92ZXJpbmdDbGFzczogXCJtanMtbmVzdGVkU29ydGFibGUtaG92ZXJpbmdcIixcblx0XHRcdGxlYWZDbGFzczogXCJtanMtbmVzdGVkU29ydGFibGUtbGVhZlwiLFxuXHRcdFx0ZGlzYWJsZWRDbGFzczogXCJtanMtbmVzdGVkU29ydGFibGUtZGlzYWJsZWRcIlxuXHRcdH0sXG5cblx0XHRfY3JlYXRlOiBmdW5jdGlvbigpIHtcblx0XHRcdHZhciBzZWxmID0gdGhpcyxcblx0XHRcdFx0ZXJyO1xuXG5cdFx0XHR0aGlzLmVsZW1lbnQuZGF0YShcInVpLXNvcnRhYmxlXCIsIHRoaXMuZWxlbWVudC5kYXRhKFwibWpzLW5lc3RlZFNvcnRhYmxlXCIpKTtcblxuXHRcdFx0Ly8gbWpzIC0gcHJldmVudCBicm93c2VyIGZyb20gZnJlZXppbmcgaWYgdGhlIEhUTUwgaXMgbm90IGNvcnJlY3Rcblx0XHRcdGlmICghdGhpcy5lbGVtZW50LmlzKHRoaXMub3B0aW9ucy5saXN0VHlwZSkpIHtcblx0XHRcdFx0ZXJyID0gXCJuZXN0ZWRTb3J0YWJsZTogXCIgK1xuXHRcdFx0XHRcdFwiUGxlYXNlIGNoZWNrIHRoYXQgdGhlIGxpc3RUeXBlIG9wdGlvbiBpcyBzZXQgdG8geW91ciBhY3R1YWwgbGlzdCB0eXBlXCI7XG5cblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKGVycik7XG5cdFx0XHR9XG5cblx0XHRcdC8vIGlmIHdlIGhhdmUgYSB0cmVlIHdpdGggZXhwYW5kaW5nL2NvbGxhcHNpbmcgZnVuY3Rpb25hbGl0eSxcblx0XHRcdC8vIGZvcmNlICdpbnRlcnNlY3QnIHRvbGVyYW5jZSBtZXRob2Rcblx0XHRcdGlmICh0aGlzLm9wdGlvbnMuaXNUcmVlICYmIHRoaXMub3B0aW9ucy5leHBhbmRPbkhvdmVyKSB7XG5cdFx0XHRcdHRoaXMub3B0aW9ucy50b2xlcmFuY2UgPSBcImludGVyc2VjdFwiO1xuXHRcdFx0fVxuXG5cdFx0XHQkLnVpLnNvcnRhYmxlLnByb3RvdHlwZS5fY3JlYXRlLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG5cblx0XHRcdC8vIHByZXBhcmUgdGhlIHRyZWUgYnkgYXBwbHlpbmcgdGhlIHJpZ2h0IGNsYXNzZXNcblx0XHRcdC8vICh0aGUgQ1NTIGlzIHJlc3BvbnNpYmxlIGZvciBhY3R1YWwgaGlkZS9zaG93IGZ1bmN0aW9uYWxpdHkpXG5cdFx0XHRpZiAodGhpcy5vcHRpb25zLmlzVHJlZSkge1xuXHRcdFx0XHQkKHRoaXMuaXRlbXMpLmVhY2goZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0dmFyICRsaSA9IHRoaXMuaXRlbSxcblx0XHRcdFx0XHRcdGhhc0NvbGxhcHNlZENsYXNzID0gJGxpLmhhc0NsYXNzKHNlbGYub3B0aW9ucy5jb2xsYXBzZWRDbGFzcyksXG5cdFx0XHRcdFx0XHRoYXNFeHBhbmRlZENsYXNzID0gJGxpLmhhc0NsYXNzKHNlbGYub3B0aW9ucy5leHBhbmRlZENsYXNzKTtcblxuXHRcdFx0XHRcdGlmICgkbGkuY2hpbGRyZW4oc2VsZi5vcHRpb25zLmxpc3RUeXBlKS5sZW5ndGgpIHtcblx0XHRcdFx0XHRcdCRsaS5hZGRDbGFzcyhzZWxmLm9wdGlvbnMuYnJhbmNoQ2xhc3MpO1xuXHRcdFx0XHRcdFx0Ly8gZXhwYW5kL2NvbGxhcHNlIGNsYXNzIG9ubHkgaWYgdGhleSBoYXZlIGNoaWxkcmVuXG5cblx0XHRcdFx0XHRcdGlmICggIWhhc0NvbGxhcHNlZENsYXNzICYmICFoYXNFeHBhbmRlZENsYXNzICkge1xuXHRcdFx0XHRcdFx0XHRpZiAoc2VsZi5vcHRpb25zLnN0YXJ0Q29sbGFwc2VkKSB7XG5cdFx0XHRcdFx0XHRcdFx0JGxpLmFkZENsYXNzKHNlbGYub3B0aW9ucy5jb2xsYXBzZWRDbGFzcyk7XG5cdFx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdFx0JGxpLmFkZENsYXNzKHNlbGYub3B0aW9ucy5leHBhbmRlZENsYXNzKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHQkbGkuYWRkQ2xhc3Moc2VsZi5vcHRpb25zLmxlYWZDbGFzcyk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9KTtcblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0X2Rlc3Ryb3k6IGZ1bmN0aW9uKCkge1xuXHRcdFx0dGhpcy5lbGVtZW50XG5cdFx0XHRcdC5yZW1vdmVEYXRhKFwibWpzLW5lc3RlZFNvcnRhYmxlXCIpXG5cdFx0XHRcdC5yZW1vdmVEYXRhKFwidWktc29ydGFibGVcIik7XG5cdFx0XHRyZXR1cm4gJC51aS5zb3J0YWJsZS5wcm90b3R5cGUuX2Rlc3Ryb3kuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcblx0XHR9LFxuXG5cdFx0X21vdXNlRHJhZzogZnVuY3Rpb24oZXZlbnQpIHtcblx0XHRcdHZhciBpLFxuXHRcdFx0XHRpdGVtLFxuXHRcdFx0XHRpdGVtRWxlbWVudCxcblx0XHRcdFx0aW50ZXJzZWN0aW9uLFxuXHRcdFx0XHRzZWxmID0gdGhpcyxcblx0XHRcdFx0byA9IHRoaXMub3B0aW9ucyxcblx0XHRcdFx0c2Nyb2xsZWQgPSBmYWxzZSxcblx0XHRcdFx0JGRvY3VtZW50ID0gJChkb2N1bWVudCksXG5cdFx0XHRcdHByZXZpb3VzVG9wT2Zmc2V0LFxuXHRcdFx0XHRwYXJlbnRJdGVtLFxuXHRcdFx0XHRsZXZlbCxcblx0XHRcdFx0Y2hpbGRMZXZlbHMsXG5cdFx0XHRcdGl0ZW1BZnRlcixcblx0XHRcdFx0aXRlbUJlZm9yZSxcblx0XHRcdFx0bmV3TGlzdCxcblx0XHRcdFx0bWV0aG9kLFxuXHRcdFx0XHRhLFxuXHRcdFx0XHRwcmV2aW91c0l0ZW0sXG5cdFx0XHRcdG5leHRJdGVtLFxuXHRcdFx0XHRoZWxwZXJJc05vdFNpYmxpbmc7XG5cblx0XHRcdC8vQ29tcHV0ZSB0aGUgaGVscGVycyBwb3NpdGlvblxuXHRcdFx0dGhpcy5wb3NpdGlvbiA9IHRoaXMuX2dlbmVyYXRlUG9zaXRpb24oZXZlbnQpO1xuXHRcdFx0dGhpcy5wb3NpdGlvbkFicyA9IHRoaXMuX2NvbnZlcnRQb3NpdGlvblRvKFwiYWJzb2x1dGVcIik7XG5cblx0XHRcdGlmICghdGhpcy5sYXN0UG9zaXRpb25BYnMpIHtcblx0XHRcdFx0dGhpcy5sYXN0UG9zaXRpb25BYnMgPSB0aGlzLnBvc2l0aW9uQWJzO1xuXHRcdFx0fVxuXG5cdFx0XHQvL0RvIHNjcm9sbGluZ1xuXHRcdFx0aWYgKHRoaXMub3B0aW9ucy5zY3JvbGwpIHtcblx0XHRcdFx0aWYgKHRoaXMuc2Nyb2xsUGFyZW50WzBdICE9PSBkb2N1bWVudCAmJiB0aGlzLnNjcm9sbFBhcmVudFswXS50YWdOYW1lICE9PSBcIkhUTUxcIikge1xuXG5cdFx0XHRcdFx0aWYgKFxuXHRcdFx0XHRcdFx0KFxuXHRcdFx0XHRcdFx0XHR0aGlzLm92ZXJmbG93T2Zmc2V0LnRvcCArXG5cdFx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WzBdLm9mZnNldEhlaWdodFxuXHRcdFx0XHRcdFx0KSAtXG5cdFx0XHRcdFx0XHRldmVudC5wYWdlWSA8XG5cdFx0XHRcdFx0XHRvLnNjcm9sbFNlbnNpdGl2aXR5XG5cdFx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0XHRzY3JvbGxlZCA9IHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbFRvcCgpICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbFRvcChzY3JvbGxlZCk7XG5cdFx0XHRcdFx0fSBlbHNlIGlmIChcblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VZIC1cblx0XHRcdFx0XHRcdHRoaXMub3ZlcmZsb3dPZmZzZXQudG9wIDxcblx0XHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHlcblx0XHRcdFx0XHQpIHtcblx0XHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKCkgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRpZiAoXG5cdFx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHRcdHRoaXMub3ZlcmZsb3dPZmZzZXQubGVmdCArXG5cdFx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WzBdLm9mZnNldFdpZHRoXG5cdFx0XHRcdFx0XHQpIC1cblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VYIDxcblx0XHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHlcblx0XHRcdFx0XHQpIHtcblx0XHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdCgpICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbExlZnQoc2Nyb2xsZWQpO1xuXHRcdFx0XHRcdH0gZWxzZSBpZiAoXG5cdFx0XHRcdFx0XHRldmVudC5wYWdlWCAtXG5cdFx0XHRcdFx0XHR0aGlzLm92ZXJmbG93T2Zmc2V0LmxlZnQgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxMZWZ0KCkgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdChzY3JvbGxlZCk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdH0gZWxzZSB7XG5cblx0XHRcdFx0XHRpZiAoXG5cdFx0XHRcdFx0XHRldmVudC5wYWdlWSAtXG5cdFx0XHRcdFx0XHQkZG9jdW1lbnQuc2Nyb2xsVG9wKCkgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSAkZG9jdW1lbnQuc2Nyb2xsVG9wKCkgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbFRvcChzY3JvbGxlZCk7XG5cdFx0XHRcdFx0fSBlbHNlIGlmIChcblx0XHRcdFx0XHRcdCQod2luZG93KS5oZWlnaHQoKSAtXG5cdFx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VZIC1cblx0XHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbFRvcCgpXG5cdFx0XHRcdFx0XHQpIDxcblx0XHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHlcblx0XHRcdFx0XHQpIHtcblx0XHRcdFx0XHRcdHNjcm9sbGVkID0gJGRvY3VtZW50LnNjcm9sbFRvcCgpICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxUb3Aoc2Nyb2xsZWQpO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdGlmIChcblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VYIC1cblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxMZWZ0KCkgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSAkZG9jdW1lbnQuc2Nyb2xsTGVmdCgpIC0gby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxMZWZ0KHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9IGVsc2UgaWYgKFxuXHRcdFx0XHRcdFx0JCh3aW5kb3cpLndpZHRoKCkgLVxuXHRcdFx0XHRcdFx0KFxuXHRcdFx0XHRcdFx0XHRldmVudC5wYWdlWCAtXG5cdFx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxMZWZ0KClcblx0XHRcdFx0XHRcdCkgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSAkZG9jdW1lbnQuc2Nyb2xsTGVmdCgpICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxMZWZ0KHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0fVxuXG5cdFx0XHRcdGlmIChzY3JvbGxlZCAhPT0gZmFsc2UgJiYgJC51aS5kZG1hbmFnZXIgJiYgIW8uZHJvcEJlaGF2aW91cikge1xuXHRcdFx0XHRcdCQudWkuZGRtYW5hZ2VyLnByZXBhcmVPZmZzZXRzKHRoaXMsIGV2ZW50KTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvL1JlZ2VuZXJhdGUgdGhlIGFic29sdXRlIHBvc2l0aW9uIHVzZWQgZm9yIHBvc2l0aW9uIGNoZWNrc1xuXHRcdFx0dGhpcy5wb3NpdGlvbkFicyA9IHRoaXMuX2NvbnZlcnRQb3NpdGlvblRvKFwiYWJzb2x1dGVcIik7XG5cblx0XHRcdC8vIG1qcyAtIGZpbmQgdGhlIHRvcCBvZmZzZXQgYmVmb3JlIHJlYXJyYW5nZW1lbnQsXG5cdFx0XHRwcmV2aW91c1RvcE9mZnNldCA9IHRoaXMucGxhY2Vob2xkZXIub2Zmc2V0KCkudG9wO1xuXG5cdFx0XHQvL1NldCB0aGUgaGVscGVyIHBvc2l0aW9uXG5cdFx0XHRpZiAoIXRoaXMub3B0aW9ucy5heGlzIHx8IHRoaXMub3B0aW9ucy5heGlzICE9PSBcInlcIikge1xuXHRcdFx0XHR0aGlzLmhlbHBlclswXS5zdHlsZS5sZWZ0ID0gdGhpcy5wb3NpdGlvbi5sZWZ0ICsgXCJweFwiO1xuXHRcdFx0fVxuXHRcdFx0aWYgKCF0aGlzLm9wdGlvbnMuYXhpcyB8fCB0aGlzLm9wdGlvbnMuYXhpcyAhPT0gXCJ4XCIpIHtcblx0XHRcdFx0dGhpcy5oZWxwZXJbMF0uc3R5bGUudG9wID0gKHRoaXMucG9zaXRpb24udG9wKSArIFwicHhcIjtcblx0XHRcdH1cblxuXHRcdFx0Ly8gbWpzIC0gY2hlY2sgYW5kIHJlc2V0IGhvdmVyaW5nIHN0YXRlIGF0IGVhY2ggY3ljbGVcblx0XHRcdHRoaXMuaG92ZXJpbmcgPSB0aGlzLmhvdmVyaW5nID8gdGhpcy5ob3ZlcmluZyA6IG51bGw7XG5cdFx0XHR0aGlzLm1vdXNlZW50ZXJlZCA9IHRoaXMubW91c2VlbnRlcmVkID8gdGhpcy5tb3VzZWVudGVyZWQgOiBmYWxzZTtcblxuXHRcdFx0Ly8gbWpzIC0gbGV0J3Mgc3RhcnQgY2FjaGluZyBzb21lIHZhcmlhYmxlc1xuXHRcdFx0KGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgX3BhcmVudEl0ZW0gPSB0aGlzLnBsYWNlaG9sZGVyLnBhcmVudCgpLnBhcmVudCgpO1xuXHRcdFx0XHRpZiAoX3BhcmVudEl0ZW0gJiYgX3BhcmVudEl0ZW0uY2xvc2VzdChcIi51aS1zb3J0YWJsZVwiKS5sZW5ndGgpIHtcblx0XHRcdFx0XHRwYXJlbnRJdGVtID0gX3BhcmVudEl0ZW07XG5cdFx0XHRcdH1cblx0XHRcdH0uY2FsbCh0aGlzKSk7XG5cblx0XHRcdGxldmVsID0gdGhpcy5fZ2V0TGV2ZWwodGhpcy5wbGFjZWhvbGRlcik7XG5cdFx0XHRjaGlsZExldmVscyA9IHRoaXMuX2dldENoaWxkTGV2ZWxzKHRoaXMuaGVscGVyKTtcblx0XHRcdG5ld0xpc3QgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KG8ubGlzdFR5cGUpO1xuXG5cdFx0XHQvL1JlYXJyYW5nZVxuXHRcdFx0Zm9yIChpID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSkge1xuXG5cdFx0XHRcdC8vQ2FjaGUgdmFyaWFibGVzIGFuZCBpbnRlcnNlY3Rpb24sIGNvbnRpbnVlIGlmIG5vIGludGVyc2VjdGlvblxuXHRcdFx0XHRpdGVtID0gdGhpcy5pdGVtc1tpXTtcblx0XHRcdFx0aXRlbUVsZW1lbnQgPSBpdGVtLml0ZW1bMF07XG5cdFx0XHRcdGludGVyc2VjdGlvbiA9IHRoaXMuX2ludGVyc2VjdHNXaXRoUG9pbnRlcihpdGVtKTtcblx0XHRcdFx0aWYgKCFpbnRlcnNlY3Rpb24pIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIE9ubHkgcHV0IHRoZSBwbGFjZWhvbGRlciBpbnNpZGUgdGhlIGN1cnJlbnQgQ29udGFpbmVyLCBza2lwIGFsbFxuXHRcdFx0XHQvLyBpdGVtcyBmb3JtIG90aGVyIGNvbnRhaW5lcnMuIFRoaXMgd29ya3MgYmVjYXVzZSB3aGVuIG1vdmluZ1xuXHRcdFx0XHQvLyBhbiBpdGVtIGZyb20gb25lIGNvbnRhaW5lciB0byBhbm90aGVyIHRoZVxuXHRcdFx0XHQvLyBjdXJyZW50Q29udGFpbmVyIGlzIHN3aXRjaGVkIGJlZm9yZSB0aGUgcGxhY2Vob2xkZXIgaXMgbW92ZWQuXG5cdFx0XHRcdC8vXG5cdFx0XHRcdC8vIFdpdGhvdXQgdGhpcyBtb3ZpbmcgaXRlbXMgaW4gXCJzdWItc29ydGFibGVzXCIgY2FuIGNhdXNlIHRoZSBwbGFjZWhvbGRlciB0byBqaXR0ZXJcblx0XHRcdFx0Ly8gYmVldHdlZW4gdGhlIG91dGVyIGFuZCBpbm5lciBjb250YWluZXIuXG5cdFx0XHRcdGlmIChpdGVtLmluc3RhbmNlICE9PSB0aGlzLmN1cnJlbnRDb250YWluZXIpIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIE5vIGFjdGlvbiBpZiBpbnRlcnNlY3RlZCBpdGVtIGlzIGRpc2FibGVkXG5cdFx0XHRcdC8vIGFuZCB0aGUgZWxlbWVudCBhYm92ZSBvciBiZWxvdyBpbiB0aGUgZGlyZWN0aW9uIHdlJ3JlIGdvaW5nIGlzIGFsc28gZGlzYWJsZWRcblx0XHRcdFx0aWYgKGl0ZW1FbGVtZW50LmNsYXNzTmFtZS5pbmRleE9mKG8uZGlzYWJsZWRDbGFzcykgIT09IC0xKSB7XG5cdFx0XHRcdFx0Ly8gTm90ZTogaW50ZXJzZWN0aW9uIGhhcmRjb2RlZCBkaXJlY3Rpb24gdmFsdWVzIGZyb21cblx0XHRcdFx0XHQvLyBqcXVlcnkudWkuc29ydGFibGUuanM6X2ludGVyc2VjdHNXaXRoUG9pbnRlclxuXHRcdFx0XHRcdGlmIChpbnRlcnNlY3Rpb24gPT09IDIpIHtcblx0XHRcdFx0XHRcdC8vIEdvaW5nIGRvd25cblx0XHRcdFx0XHRcdGl0ZW1BZnRlciA9IHRoaXMuaXRlbXNbaSArIDFdO1xuXHRcdFx0XHRcdFx0aWYgKGl0ZW1BZnRlciAmJiBpdGVtQWZ0ZXIuaXRlbS5oYXNDbGFzcyhvLmRpc2FibGVkQ2xhc3MpKSB7XG5cdFx0XHRcdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0fSBlbHNlIGlmIChpbnRlcnNlY3Rpb24gPT09IDEpIHtcblx0XHRcdFx0XHRcdC8vIEdvaW5nIHVwXG5cdFx0XHRcdFx0XHRpdGVtQmVmb3JlID0gdGhpcy5pdGVtc1tpIC0gMV07XG5cdFx0XHRcdFx0XHRpZiAoaXRlbUJlZm9yZSAmJiBpdGVtQmVmb3JlLml0ZW0uaGFzQ2xhc3Moby5kaXNhYmxlZENsYXNzKSkge1xuXHRcdFx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRtZXRob2QgPSBpbnRlcnNlY3Rpb24gPT09IDEgPyBcIm5leHRcIiA6IFwicHJldlwiO1xuXG5cdFx0XHRcdC8vIGNhbm5vdCBpbnRlcnNlY3Qgd2l0aCBpdHNlbGZcblx0XHRcdFx0Ly8gbm8gdXNlbGVzcyBhY3Rpb25zIHRoYXQgaGF2ZSBiZWVuIGRvbmUgYmVmb3JlXG5cdFx0XHRcdC8vIG5vIGFjdGlvbiBpZiB0aGUgaXRlbSBtb3ZlZCBpcyB0aGUgcGFyZW50IG9mIHRoZSBpdGVtIGNoZWNrZWRcblx0XHRcdFx0aWYgKGl0ZW1FbGVtZW50ICE9PSB0aGlzLmN1cnJlbnRJdGVtWzBdICYmXG5cdFx0XHRcdFx0dGhpcy5wbGFjZWhvbGRlclttZXRob2RdKClbMF0gIT09IGl0ZW1FbGVtZW50ICYmXG5cdFx0XHRcdFx0ISQuY29udGFpbnModGhpcy5wbGFjZWhvbGRlclswXSwgaXRlbUVsZW1lbnQpICYmXG5cdFx0XHRcdFx0KFxuXHRcdFx0XHRcdFx0dGhpcy5vcHRpb25zLnR5cGUgPT09IFwic2VtaS1keW5hbWljXCIgP1xuXHRcdFx0XHRcdFx0XHQhJC5jb250YWlucyh0aGlzLmVsZW1lbnRbMF0sIGl0ZW1FbGVtZW50KSA6XG5cdFx0XHRcdFx0XHRcdHRydWVcblx0XHRcdFx0XHQpXG5cdFx0XHRcdCkge1xuXG5cdFx0XHRcdFx0Ly8gbWpzIC0gd2UgYXJlIGludGVyc2VjdGluZyBhbiBlbGVtZW50OlxuXHRcdFx0XHRcdC8vIHRyaWdnZXIgdGhlIG1vdXNlZW50ZXIgZXZlbnQgYW5kIHN0b3JlIHRoaXMgc3RhdGVcblx0XHRcdFx0XHRpZiAoIXRoaXMubW91c2VlbnRlcmVkKSB7XG5cdFx0XHRcdFx0XHQkKGl0ZW1FbGVtZW50KS5tb3VzZWVudGVyKCk7XG5cdFx0XHRcdFx0XHR0aGlzLm1vdXNlZW50ZXJlZCA9IHRydWU7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0Ly8gbWpzIC0gaWYgdGhlIGVsZW1lbnQgaGFzIGNoaWxkcmVuIGFuZCB0aGV5IGFyZSBoaWRkZW4sXG5cdFx0XHRcdFx0Ly8gc2hvdyB0aGVtIGFmdGVyIGEgZGVsYXkgKENTUyByZXNwb25zaWJsZSlcblx0XHRcdFx0XHRpZiAoby5pc1RyZWUgJiYgJChpdGVtRWxlbWVudCkuaGFzQ2xhc3Moby5jb2xsYXBzZWRDbGFzcykgJiYgby5leHBhbmRPbkhvdmVyKSB7XG5cdFx0XHRcdFx0XHRpZiAoIXRoaXMuaG92ZXJpbmcpIHtcblx0XHRcdFx0XHRcdFx0JChpdGVtRWxlbWVudCkuYWRkQ2xhc3Moby5ob3ZlcmluZ0NsYXNzKTtcblx0XHRcdFx0XHRcdFx0dGhpcy5ob3ZlcmluZyA9IHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdFx0XHRcdCQoaXRlbUVsZW1lbnQpXG5cdFx0XHRcdFx0XHRcdFx0XHQucmVtb3ZlQ2xhc3Moby5jb2xsYXBzZWRDbGFzcylcblx0XHRcdFx0XHRcdFx0XHRcdC5hZGRDbGFzcyhvLmV4cGFuZGVkQ2xhc3MpO1xuXG5cdFx0XHRcdFx0XHRcdFx0c2VsZi5yZWZyZXNoUG9zaXRpb25zKCk7XG5cdFx0XHRcdFx0XHRcdFx0c2VsZi5fdHJpZ2dlcihcImV4cGFuZFwiLCBldmVudCwgc2VsZi5fdWlIYXNoKCkpO1xuXHRcdFx0XHRcdFx0XHR9LCBvLmV4cGFuZE9uSG92ZXIpO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdHRoaXMuZGlyZWN0aW9uID0gaW50ZXJzZWN0aW9uID09PSAxID8gXCJkb3duXCIgOiBcInVwXCI7XG5cblx0XHRcdFx0XHQvLyBtanMgLSByZWFycmFuZ2UgdGhlIGVsZW1lbnRzIGFuZCByZXNldCB0aW1lb3V0cyBhbmQgaG92ZXJpbmcgc3RhdGVcblx0XHRcdFx0XHRpZiAodGhpcy5vcHRpb25zLnRvbGVyYW5jZSA9PT0gXCJwb2ludGVyXCIgfHwgdGhpcy5faW50ZXJzZWN0c1dpdGhTaWRlcyhpdGVtKSkge1xuXHRcdFx0XHRcdFx0JChpdGVtRWxlbWVudCkubW91c2VsZWF2ZSgpO1xuXHRcdFx0XHRcdFx0dGhpcy5tb3VzZWVudGVyZWQgPSBmYWxzZTtcblx0XHRcdFx0XHRcdCQoaXRlbUVsZW1lbnQpLnJlbW92ZUNsYXNzKG8uaG92ZXJpbmdDbGFzcyk7XG5cdFx0XHRcdFx0XHRpZiAodGhpcy5ob3ZlcmluZykge1xuXHRcdFx0XHRcdFx0XHR3aW5kb3cuY2xlYXJUaW1lb3V0KHRoaXMuaG92ZXJpbmcpO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0dGhpcy5ob3ZlcmluZyA9IG51bGw7XG5cblx0XHRcdFx0XHRcdC8vIG1qcyAtIGRvIG5vdCBzd2l0Y2ggY29udGFpbmVyIGlmXG5cdFx0XHRcdFx0XHQvLyBpdCdzIGEgcm9vdCBpdGVtIGFuZCAncHJvdGVjdFJvb3QnIGlzIHRydWVcblx0XHRcdFx0XHRcdC8vIG9yIGlmIGl0J3Mgbm90IGEgcm9vdCBpdGVtIGJ1dCB3ZSBhcmUgdHJ5aW5nIHRvIG1ha2UgaXQgcm9vdFxuXHRcdFx0XHRcdFx0aWYgKG8ucHJvdGVjdFJvb3QgJiZcblx0XHRcdFx0XHRcdFx0IShcblx0XHRcdFx0XHRcdFx0XHR0aGlzLmN1cnJlbnRJdGVtWzBdLnBhcmVudE5vZGUgPT09IHRoaXMuZWxlbWVudFswXSAmJlxuXHRcdFx0XHRcdFx0XHRcdC8vIGl0J3MgYSByb290IGl0ZW1cblx0XHRcdFx0XHRcdFx0XHRpdGVtRWxlbWVudC5wYXJlbnROb2RlICE9PSB0aGlzLmVsZW1lbnRbMF1cblx0XHRcdFx0XHRcdFx0XHQvLyBpdCdzIGludGVyc2VjdGluZyBhIG5vbi1yb290IGl0ZW1cblx0XHRcdFx0XHRcdFx0KVxuXHRcdFx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0XHRcdGlmICh0aGlzLmN1cnJlbnRJdGVtWzBdLnBhcmVudE5vZGUgIT09IHRoaXMuZWxlbWVudFswXSAmJlxuXHRcdFx0XHRcdFx0XHRcdGl0ZW1FbGVtZW50LnBhcmVudE5vZGUgPT09IHRoaXMuZWxlbWVudFswXVxuXHRcdFx0XHRcdFx0XHQpIHtcblxuXHRcdFx0XHRcdFx0XHRcdGlmICggISQoaXRlbUVsZW1lbnQpLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmxlbmd0aCkge1xuXHRcdFx0XHRcdFx0XHRcdFx0aXRlbUVsZW1lbnQuYXBwZW5kQ2hpbGQobmV3TGlzdCk7XG5cdFx0XHRcdFx0XHRcdFx0XHRpZiAoby5pc1RyZWUpIHtcblx0XHRcdFx0XHRcdFx0XHRcdFx0JChpdGVtRWxlbWVudClcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQucmVtb3ZlQ2xhc3Moby5sZWFmQ2xhc3MpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0LmFkZENsYXNzKG8uYnJhbmNoQ2xhc3MgKyBcIiBcIiArIG8uZXhwYW5kZWRDbGFzcyk7XG5cdFx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdFx0aWYgKHRoaXMuZGlyZWN0aW9uID09PSBcImRvd25cIikge1xuXHRcdFx0XHRcdFx0XHRcdFx0YSA9ICQoaXRlbUVsZW1lbnQpLnByZXYoKS5jaGlsZHJlbihvLmxpc3RUeXBlKTtcblx0XHRcdFx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0XHRcdFx0YSA9ICQoaXRlbUVsZW1lbnQpLmNoaWxkcmVuKG8ubGlzdFR5cGUpO1xuXHRcdFx0XHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdFx0XHRcdGlmIChhWzBdICE9PSB1bmRlZmluZWQpIHtcblx0XHRcdFx0XHRcdFx0XHRcdHRoaXMuX3JlYXJyYW5nZShldmVudCwgbnVsbCwgYSk7XG5cdFx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdFx0dGhpcy5fcmVhcnJhbmdlKGV2ZW50LCBpdGVtKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fSBlbHNlIGlmICghby5wcm90ZWN0Um9vdCkge1xuXHRcdFx0XHRcdFx0XHR0aGlzLl9yZWFycmFuZ2UoZXZlbnQsIGl0ZW0pO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHQvLyBDbGVhciBlbXRweSB1bCdzL29sJ3Ncblx0XHRcdFx0XHR0aGlzLl9jbGVhckVtcHR5KGl0ZW1FbGVtZW50KTtcblxuXHRcdFx0XHRcdHRoaXMuX3RyaWdnZXIoXCJjaGFuZ2VcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpKTtcblx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvLyBtanMgLSB0byBmaW5kIHRoZSBwcmV2aW91cyBzaWJsaW5nIGluIHRoZSBsaXN0LFxuXHRcdFx0Ly8ga2VlcCBiYWNrdHJhY2tpbmcgdW50aWwgd2UgaGl0IGEgdmFsaWQgbGlzdCBpdGVtLlxuXHRcdFx0KGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgX3ByZXZpb3VzSXRlbSA9IHRoaXMucGxhY2Vob2xkZXIucHJldigpO1xuXHRcdFx0XHRpZiAoX3ByZXZpb3VzSXRlbS5sZW5ndGgpIHtcblx0XHRcdFx0XHRwcmV2aW91c0l0ZW0gPSBfcHJldmlvdXNJdGVtO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdHByZXZpb3VzSXRlbSA9IG51bGw7XG5cdFx0XHRcdH1cblx0XHRcdH0uY2FsbCh0aGlzKSk7XG5cblx0XHRcdGlmIChwcmV2aW91c0l0ZW0gIT0gbnVsbCkge1xuXHRcdFx0XHR3aGlsZSAoXG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtWzBdLm5vZGVOYW1lLnRvTG93ZXJDYXNlKCkgIT09IFwibGlcIiB8fFxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbVswXS5jbGFzc05hbWUuaW5kZXhPZihvLmRpc2FibGVkQ2xhc3MpICE9PSAtMSB8fFxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbVswXSA9PT0gdGhpcy5jdXJyZW50SXRlbVswXSB8fFxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbVswXSA9PT0gdGhpcy5oZWxwZXJbMF1cblx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0aWYgKHByZXZpb3VzSXRlbVswXS5wcmV2aW91c1NpYmxpbmcpIHtcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbSA9ICQocHJldmlvdXNJdGVtWzBdLnByZXZpb3VzU2libGluZyk7XG5cdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbSA9IG51bGw7XG5cdFx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly8gbWpzIC0gdG8gZmluZCB0aGUgbmV4dCBzaWJsaW5nIGluIHRoZSBsaXN0LFxuXHRcdFx0Ly8ga2VlcCBzdGVwcGluZyBmb3J3YXJkIHVudGlsIHdlIGhpdCBhIHZhbGlkIGxpc3QgaXRlbS5cblx0XHRcdChmdW5jdGlvbigpIHtcblx0XHRcdFx0dmFyIF9uZXh0SXRlbSA9IHRoaXMucGxhY2Vob2xkZXIubmV4dCgpO1xuXHRcdFx0XHRpZiAoX25leHRJdGVtLmxlbmd0aCkge1xuXHRcdFx0XHRcdG5leHRJdGVtID0gX25leHRJdGVtO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdG5leHRJdGVtID0gbnVsbDtcblx0XHRcdFx0fVxuXHRcdFx0fS5jYWxsKHRoaXMpKTtcblxuXHRcdFx0aWYgKG5leHRJdGVtICE9IG51bGwpIHtcblx0XHRcdFx0d2hpbGUgKFxuXHRcdFx0XHRcdG5leHRJdGVtWzBdLm5vZGVOYW1lLnRvTG93ZXJDYXNlKCkgIT09IFwibGlcIiB8fFxuXHRcdFx0XHRcdG5leHRJdGVtWzBdLmNsYXNzTmFtZS5pbmRleE9mKG8uZGlzYWJsZWRDbGFzcykgIT09IC0xIHx8XG5cdFx0XHRcdFx0bmV4dEl0ZW1bMF0gPT09IHRoaXMuY3VycmVudEl0ZW1bMF0gfHxcblx0XHRcdFx0XHRuZXh0SXRlbVswXSA9PT0gdGhpcy5oZWxwZXJbMF1cblx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0aWYgKG5leHRJdGVtWzBdLm5leHRTaWJsaW5nKSB7XG5cdFx0XHRcdFx0XHRuZXh0SXRlbSA9ICQobmV4dEl0ZW1bMF0ubmV4dFNpYmxpbmcpO1xuXHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRuZXh0SXRlbSA9IG51bGw7XG5cdFx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0dGhpcy5iZXlvbmRNYXhMZXZlbHMgPSAwO1xuXG5cdFx0XHQvLyBtanMgLSBpZiB0aGUgaXRlbSBpcyBtb3ZlZCB0byB0aGUgbGVmdCwgc2VuZCBpdCBvbmUgbGV2ZWwgdXBcblx0XHRcdC8vIGJ1dCBvbmx5IGlmIGl0J3MgYXQgdGhlIGJvdHRvbSBvZiB0aGUgbGlzdFxuXHRcdFx0aWYgKHBhcmVudEl0ZW0gIT0gbnVsbCAmJlxuXHRcdFx0XHRuZXh0SXRlbSA9PSBudWxsICYmXG5cdFx0XHRcdCEoby5wcm90ZWN0Um9vdCAmJiBwYXJlbnRJdGVtWzBdLnBhcmVudE5vZGUgPT0gdGhpcy5lbGVtZW50WzBdKSAmJlxuXHRcdFx0XHQoXG5cdFx0XHRcdFx0by5ydGwgJiZcblx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHR0aGlzLnBvc2l0aW9uQWJzLmxlZnQgK1xuXHRcdFx0XHRcdFx0dGhpcy5oZWxwZXIub3V0ZXJXaWR0aCgpID4gcGFyZW50SXRlbS5vZmZzZXQoKS5sZWZ0ICtcblx0XHRcdFx0XHRcdHBhcmVudEl0ZW0ub3V0ZXJXaWR0aCgpXG5cdFx0XHRcdFx0KSB8fFxuXHRcdFx0XHRcdCFvLnJ0bCAmJiAodGhpcy5wb3NpdGlvbkFicy5sZWZ0IDwgcGFyZW50SXRlbS5vZmZzZXQoKS5sZWZ0KVxuXHRcdFx0XHQpXG5cdFx0XHQpIHtcblxuXHRcdFx0XHRwYXJlbnRJdGVtLmFmdGVyKHRoaXMucGxhY2Vob2xkZXJbMF0pO1xuXHRcdFx0XHRoZWxwZXJJc05vdFNpYmxpbmcgPSAhcGFyZW50SXRlbVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdC5jaGlsZHJlbihvLmxpc3RJdGVtKVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdC5jaGlsZHJlbihcImxpOnZpc2libGU6bm90KC51aS1zb3J0YWJsZS1oZWxwZXIpXCIpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0Lmxlbmd0aDtcblx0XHRcdFx0aWYgKG8uaXNUcmVlICYmIGhlbHBlcklzTm90U2libGluZykge1xuXHRcdFx0XHRcdHBhcmVudEl0ZW1cblx0XHRcdFx0XHRcdC5yZW1vdmVDbGFzcyh0aGlzLm9wdGlvbnMuYnJhbmNoQ2xhc3MgKyBcIiBcIiArIHRoaXMub3B0aW9ucy5leHBhbmRlZENsYXNzKVxuXHRcdFx0XHRcdFx0LmFkZENsYXNzKHRoaXMub3B0aW9ucy5sZWFmQ2xhc3MpO1xuXHRcdFx0XHR9XG4gICAgICAgICAgICAgICAgaWYodHlwZW9mIHBhcmVudEl0ZW0gIT09ICd1bmRlZmluZWQnKVxuXHRcdFx0XHQgICAgdGhpcy5fY2xlYXJFbXB0eShwYXJlbnRJdGVtWzBdKTtcblx0XHRcdFx0dGhpcy5fdHJpZ2dlcihcImNoYW5nZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXHRcdFx0XHQvLyBtanMgLSBpZiB0aGUgaXRlbSBpcyBiZWxvdyBhIHNpYmxpbmcgYW5kIGlzIG1vdmVkIHRvIHRoZSByaWdodCxcblx0XHRcdFx0Ly8gbWFrZSBpdCBhIGNoaWxkIG9mIHRoYXQgc2libGluZ1xuXHRcdFx0fSBlbHNlIGlmIChwcmV2aW91c0l0ZW0gIT0gbnVsbCAmJlxuXHRcdFx0XHQhcHJldmlvdXNJdGVtLmhhc0NsYXNzKG8uZGlzYWJsZU5lc3RpbmdDbGFzcykgJiZcblx0XHRcdFx0KFxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbS5jaGlsZHJlbihvLmxpc3RUeXBlKS5sZW5ndGggJiZcblx0XHRcdFx0XHRwcmV2aW91c0l0ZW0uY2hpbGRyZW4oby5saXN0VHlwZSkuaXMoXCI6dmlzaWJsZVwiKSB8fFxuXHRcdFx0XHRcdCFwcmV2aW91c0l0ZW0uY2hpbGRyZW4oby5saXN0VHlwZSkubGVuZ3RoXG5cdFx0XHRcdCkgJiZcblx0XHRcdFx0IShvLnByb3RlY3RSb290ICYmIHRoaXMuY3VycmVudEl0ZW1bMF0ucGFyZW50Tm9kZSA9PT0gdGhpcy5lbGVtZW50WzBdKSAmJlxuXHRcdFx0XHQoXG5cdFx0XHRcdFx0by5ydGwgJiZcblx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHR0aGlzLnBvc2l0aW9uQWJzLmxlZnQgK1xuXHRcdFx0XHRcdFx0dGhpcy5oZWxwZXIub3V0ZXJXaWR0aCgpIDxcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbS5vZmZzZXQoKS5sZWZ0ICtcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbS5vdXRlcldpZHRoKCkgLVxuXHRcdFx0XHRcdFx0by50YWJTaXplXG5cdFx0XHRcdFx0KSB8fFxuXHRcdFx0XHRcdCFvLnJ0bCAmJlxuXHRcdFx0XHRcdCh0aGlzLnBvc2l0aW9uQWJzLmxlZnQgPiBwcmV2aW91c0l0ZW0ub2Zmc2V0KCkubGVmdCArIG8udGFiU2l6ZSlcblx0XHRcdFx0KVxuXHRcdFx0KSB7XG5cblx0XHRcdFx0dGhpcy5faXNBbGxvd2VkKHByZXZpb3VzSXRlbSwgbGV2ZWwsIGxldmVsICsgY2hpbGRMZXZlbHMgKyAxKTtcblxuXHRcdFx0XHRpZiAoIXByZXZpb3VzSXRlbS5jaGlsZHJlbihvLmxpc3RUeXBlKS5sZW5ndGgpIHtcblx0XHRcdFx0XHRwcmV2aW91c0l0ZW1bMF0uYXBwZW5kQ2hpbGQobmV3TGlzdCk7XG5cdFx0XHRcdFx0aWYgKG8uaXNUcmVlKSB7XG5cdFx0XHRcdFx0XHRwcmV2aW91c0l0ZW1cblx0XHRcdFx0XHRcdFx0LnJlbW92ZUNsYXNzKG8ubGVhZkNsYXNzKVxuXHRcdFx0XHRcdFx0XHQuYWRkQ2xhc3Moby5icmFuY2hDbGFzcyArIFwiIFwiICsgby5leHBhbmRlZENsYXNzKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblxuXHRcdFx0XHQvLyBtanMgLSBpZiB0aGlzIGl0ZW0gaXMgYmVpbmcgbW92ZWQgZnJvbSB0aGUgdG9wLCBhZGQgaXQgdG8gdGhlIHRvcCBvZiB0aGUgbGlzdC5cblx0XHRcdFx0aWYgKHByZXZpb3VzVG9wT2Zmc2V0ICYmIChwcmV2aW91c1RvcE9mZnNldCA8PSBwcmV2aW91c0l0ZW0ub2Zmc2V0KCkudG9wKSkge1xuXHRcdFx0XHRcdHByZXZpb3VzSXRlbS5jaGlsZHJlbihvLmxpc3RUeXBlKS5wcmVwZW5kKHRoaXMucGxhY2Vob2xkZXIpO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdC8vIG1qcyAtIG90aGVyd2lzZSwgYWRkIGl0IHRvIHRoZSBib3R0b20gb2YgdGhlIGxpc3QuXG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtLmNoaWxkcmVuKG8ubGlzdFR5cGUpWzBdLmFwcGVuZENoaWxkKHRoaXMucGxhY2Vob2xkZXJbMF0pO1xuXHRcdFx0XHR9XG4gICAgICAgICAgICAgICAgaWYodHlwZW9mIHBhcmVudEl0ZW0gIT09ICd1bmRlZmluZWQnKVxuXHRcdFx0XHQgICAgdGhpcy5fY2xlYXJFbXB0eShwYXJlbnRJdGVtWzBdKTtcblx0XHRcdFx0dGhpcy5fdHJpZ2dlcihcImNoYW5nZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0dGhpcy5faXNBbGxvd2VkKHBhcmVudEl0ZW0sIGxldmVsLCBsZXZlbCArIGNoaWxkTGV2ZWxzKTtcblx0XHRcdH1cblxuXHRcdFx0Ly9Qb3N0IGV2ZW50cyB0byBjb250YWluZXJzXG5cdFx0XHR0aGlzLl9jb250YWN0Q29udGFpbmVycyhldmVudCk7XG5cblx0XHRcdC8vSW50ZXJjb25uZWN0IHdpdGggZHJvcHBhYmxlc1xuXHRcdFx0aWYgKCQudWkuZGRtYW5hZ2VyKSB7XG5cdFx0XHRcdCQudWkuZGRtYW5hZ2VyLmRyYWcodGhpcywgZXZlbnQpO1xuXHRcdFx0fVxuXG5cdFx0XHQvL0NhbGwgY2FsbGJhY2tzXG5cdFx0XHR0aGlzLl90cmlnZ2VyKFwic29ydFwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXG5cdFx0XHR0aGlzLmxhc3RQb3NpdGlvbkFicyA9IHRoaXMucG9zaXRpb25BYnM7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cblx0XHR9LFxuXG5cdFx0X21vdXNlU3RvcDogZnVuY3Rpb24oZXZlbnQpIHtcblx0XHRcdC8vIG1qcyAtIGlmIHRoZSBpdGVtIGlzIGluIGEgcG9zaXRpb24gbm90IGFsbG93ZWQsIHNlbmQgaXQgYmFja1xuXHRcdFx0aWYgKHRoaXMuYmV5b25kTWF4TGV2ZWxzKSB7XG5cblx0XHRcdFx0dGhpcy5wbGFjZWhvbGRlci5yZW1vdmVDbGFzcyh0aGlzLm9wdGlvbnMuZXJyb3JDbGFzcyk7XG5cblx0XHRcdFx0aWYgKHRoaXMuZG9tUG9zaXRpb24ucHJldikge1xuXHRcdFx0XHRcdCQodGhpcy5kb21Qb3NpdGlvbi5wcmV2KS5hZnRlcih0aGlzLnBsYWNlaG9sZGVyKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHQkKHRoaXMuZG9tUG9zaXRpb24ucGFyZW50KS5wcmVwZW5kKHRoaXMucGxhY2Vob2xkZXIpO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0dGhpcy5fdHJpZ2dlcihcInJldmVydFwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXG5cdFx0XHR9XG5cblx0XHRcdC8vIG1qcyAtIGNsZWFyIHRoZSBob3ZlcmluZyB0aW1lb3V0LCBqdXN0IHRvIGJlIHN1cmVcblx0XHRcdCQoXCIuXCIgKyB0aGlzLm9wdGlvbnMuaG92ZXJpbmdDbGFzcylcblx0XHRcdFx0Lm1vdXNlbGVhdmUoKVxuXHRcdFx0XHQucmVtb3ZlQ2xhc3ModGhpcy5vcHRpb25zLmhvdmVyaW5nQ2xhc3MpO1xuXG5cdFx0XHR0aGlzLm1vdXNlZW50ZXJlZCA9IGZhbHNlO1xuXHRcdFx0aWYgKHRoaXMuaG92ZXJpbmcpIHtcblx0XHRcdFx0d2luZG93LmNsZWFyVGltZW91dCh0aGlzLmhvdmVyaW5nKTtcblx0XHRcdH1cblx0XHRcdHRoaXMuaG92ZXJpbmcgPSBudWxsO1xuXG5cdFx0XHR0aGlzLl9yZWxvY2F0ZV9ldmVudCA9IGV2ZW50O1xuXHRcdFx0dGhpcy5fcGlkX2N1cnJlbnQgPSAkKHRoaXMuZG9tUG9zaXRpb24ucGFyZW50KS5wYXJlbnQoKS5hdHRyKFwiaWRcIik7XG5cdFx0XHR0aGlzLl9zb3J0X2N1cnJlbnQgPSB0aGlzLmRvbVBvc2l0aW9uLnByZXYgPyAkKHRoaXMuZG9tUG9zaXRpb24ucHJldikubmV4dCgpLmluZGV4KCkgOiAwO1xuXHRcdFx0JC51aS5zb3J0YWJsZS5wcm90b3R5cGUuX21vdXNlU3RvcC5hcHBseSh0aGlzLCBhcmd1bWVudHMpOyAvL2FzeWJuY2hyb25vdXMgZXhlY3V0aW9uLCBAc2VlIF9jbGVhciBmb3IgdGhlIHJlbG9jYXRlIGV2ZW50LlxuXHRcdH0sXG5cblx0XHQvLyBtanMgLSB0aGlzIGZ1bmN0aW9uIGlzIHNsaWdodGx5IG1vZGlmaWVkXG5cdFx0Ly8gdG8gbWFrZSBpdCBlYXNpZXIgdG8gaG92ZXIgb3ZlciBhIGNvbGxhcHNlZCBlbGVtZW50IGFuZCBoYXZlIGl0IGV4cGFuZFxuXHRcdF9pbnRlcnNlY3RzV2l0aFNpZGVzOiBmdW5jdGlvbihpdGVtKSB7XG5cblx0XHRcdHZhciBoYWxmID0gdGhpcy5vcHRpb25zLmlzVHJlZSA/IC44IDogLjUsXG5cdFx0XHRcdGlzT3ZlckJvdHRvbUhhbGYgPSBpc092ZXJBeGlzKFxuXHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMudG9wICsgdGhpcy5vZmZzZXQuY2xpY2sudG9wLFxuXHRcdFx0XHRcdGl0ZW0udG9wICsgKGl0ZW0uaGVpZ2h0ICogaGFsZiksXG5cdFx0XHRcdFx0aXRlbS5oZWlnaHRcblx0XHRcdFx0KSxcblx0XHRcdFx0aXNPdmVyVG9wSGFsZiA9IGlzT3ZlckF4aXMoXG5cdFx0XHRcdFx0dGhpcy5wb3NpdGlvbkFicy50b3AgKyB0aGlzLm9mZnNldC5jbGljay50b3AsXG5cdFx0XHRcdFx0aXRlbS50b3AgLSAoaXRlbS5oZWlnaHQgKiBoYWxmKSxcblx0XHRcdFx0XHRpdGVtLmhlaWdodFxuXHRcdFx0XHQpLFxuXHRcdFx0XHRpc092ZXJSaWdodEhhbGYgPSBpc092ZXJBeGlzKFxuXHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMubGVmdCArIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQsXG5cdFx0XHRcdFx0aXRlbS5sZWZ0ICsgKGl0ZW0ud2lkdGggLyAyKSxcblx0XHRcdFx0XHRpdGVtLndpZHRoXG5cdFx0XHRcdCksXG5cdFx0XHRcdHZlcnRpY2FsRGlyZWN0aW9uID0gdGhpcy5fZ2V0RHJhZ1ZlcnRpY2FsRGlyZWN0aW9uKCksXG5cdFx0XHRcdGhvcml6b250YWxEaXJlY3Rpb24gPSB0aGlzLl9nZXREcmFnSG9yaXpvbnRhbERpcmVjdGlvbigpO1xuXG5cdFx0XHRpZiAodGhpcy5mbG9hdGluZyAmJiBob3Jpem9udGFsRGlyZWN0aW9uKSB7XG5cdFx0XHRcdHJldHVybiAoXG5cdFx0XHRcdFx0KGhvcml6b250YWxEaXJlY3Rpb24gPT09IFwicmlnaHRcIiAmJiBpc092ZXJSaWdodEhhbGYpIHx8XG5cdFx0XHRcdFx0KGhvcml6b250YWxEaXJlY3Rpb24gPT09IFwibGVmdFwiICYmICFpc092ZXJSaWdodEhhbGYpXG5cdFx0XHRcdCk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRyZXR1cm4gdmVydGljYWxEaXJlY3Rpb24gJiYgKFxuXHRcdFx0XHRcdCh2ZXJ0aWNhbERpcmVjdGlvbiA9PT0gXCJkb3duXCIgJiYgaXNPdmVyQm90dG9tSGFsZikgfHxcblx0XHRcdFx0XHQodmVydGljYWxEaXJlY3Rpb24gPT09IFwidXBcIiAmJiBpc092ZXJUb3BIYWxmKVxuXHRcdFx0XHQpO1xuXHRcdFx0fVxuXG5cdFx0fSxcblxuXHRcdF9jb250YWN0Q29udGFpbmVyczogZnVuY3Rpb24oKSB7XG5cblx0XHRcdGlmICh0aGlzLm9wdGlvbnMucHJvdGVjdFJvb3QgJiYgdGhpcy5jdXJyZW50SXRlbVswXS5wYXJlbnROb2RlID09PSB0aGlzLmVsZW1lbnRbMF0gKSB7XG5cdFx0XHRcdHJldHVybjtcblx0XHRcdH1cblxuXHRcdFx0JC51aS5zb3J0YWJsZS5wcm90b3R5cGUuX2NvbnRhY3RDb250YWluZXJzLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG5cblx0XHR9LFxuXG5cdFx0X2NsZWFyOiBmdW5jdGlvbigpIHtcblx0XHRcdHZhciBpLFxuXHRcdFx0XHRpdGVtO1xuXG5cdFx0XHQkLnVpLnNvcnRhYmxlLnByb3RvdHlwZS5fY2xlYXIuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcblxuXHRcdFx0Ly9yZWxvY2F0ZSBldmVudFxuXHRcdFx0aWYgKCEodGhpcy5fcGlkX2N1cnJlbnQgPT09IHRoaXMuX3VpSGFzaCgpLml0ZW0ucGFyZW50KCkucGFyZW50KCkuYXR0cihcImlkXCIpICYmXG5cdFx0XHRcdHRoaXMuX3NvcnRfY3VycmVudCA9PT0gdGhpcy5fdWlIYXNoKCkuaXRlbS5pbmRleCgpKSkge1xuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKFwicmVsb2NhdGVcIiwgdGhpcy5fcmVsb2NhdGVfZXZlbnQsIHRoaXMuX3VpSGFzaCgpKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gbWpzIC0gY2xlYW4gbGFzdCBlbXB0eSB1bC9vbFxuXHRcdFx0Zm9yIChpID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSkge1xuXHRcdFx0XHRpdGVtID0gdGhpcy5pdGVtc1tpXS5pdGVtWzBdO1xuXHRcdFx0XHR0aGlzLl9jbGVhckVtcHR5KGl0ZW0pO1xuXHRcdFx0fVxuXG5cdFx0fSxcblxuXHRcdHNlcmlhbGl6ZTogZnVuY3Rpb24ob3B0aW9ucykge1xuXG5cdFx0XHR2YXIgbyA9ICQuZXh0ZW5kKHt9LCB0aGlzLm9wdGlvbnMsIG9wdGlvbnMpLFxuXHRcdFx0XHRpdGVtcyA9IHRoaXMuX2dldEl0ZW1zQXNqUXVlcnkobyAmJiBvLmNvbm5lY3RlZCksXG5cdFx0XHRcdHN0ciA9IFtdO1xuXG5cdFx0XHQkKGl0ZW1zKS5lYWNoKGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgcmVzID0gKCQoby5pdGVtIHx8IHRoaXMpLmF0dHIoby5hdHRyaWJ1dGUgfHwgXCJpZFwiKSB8fCBcIlwiKVxuXHRcdFx0XHRcdFx0Lm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSksXG5cdFx0XHRcdFx0cGlkID0gKCQoby5pdGVtIHx8IHRoaXMpLnBhcmVudChvLmxpc3RUeXBlKVxuXHRcdFx0XHRcdFx0LnBhcmVudChvLml0ZW1zKVxuXHRcdFx0XHRcdFx0LmF0dHIoby5hdHRyaWJ1dGUgfHwgXCJpZFwiKSB8fCBcIlwiKVxuXHRcdFx0XHRcdFx0Lm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSk7XG5cblx0XHRcdFx0aWYgKHJlcykge1xuXHRcdFx0XHRcdHN0ci5wdXNoKFxuXHRcdFx0XHRcdFx0KFxuXHRcdFx0XHRcdFx0XHQoby5rZXkgfHwgcmVzWzFdKSArXG5cdFx0XHRcdFx0XHRcdFwiW1wiICtcblx0XHRcdFx0XHRcdFx0KG8ua2V5ICYmIG8uZXhwcmVzc2lvbiA/IHJlc1sxXSA6IHJlc1syXSkgKyBcIl1cIlxuXHRcdFx0XHRcdFx0KSArXG5cdFx0XHRcdFx0XHRcIj1cIiArXG5cdFx0XHRcdFx0XHQocGlkID8gKG8ua2V5ICYmIG8uZXhwcmVzc2lvbiA/IHBpZFsxXSA6IHBpZFsyXSkgOiBvLnJvb3RJRCkpO1xuXHRcdFx0XHR9XG5cdFx0XHR9KTtcblxuXHRcdFx0aWYgKCFzdHIubGVuZ3RoICYmIG8ua2V5KSB7XG5cdFx0XHRcdHN0ci5wdXNoKG8ua2V5ICsgXCI9XCIpO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gc3RyLmpvaW4oXCImXCIpO1xuXG5cdFx0fSxcblxuXHRcdHRvSGllcmFyY2h5OiBmdW5jdGlvbihvcHRpb25zKSB7XG5cblx0XHRcdHZhciBvID0gJC5leHRlbmQoe30sIHRoaXMub3B0aW9ucywgb3B0aW9ucyksXG5cdFx0XHRcdHJldCA9IFtdO1xuXG5cdFx0XHQkKHRoaXMuZWxlbWVudCkuY2hpbGRyZW4oby5pdGVtcykuZWFjaChmdW5jdGlvbigpIHtcblx0XHRcdFx0dmFyIGxldmVsID0gX3JlY3Vyc2l2ZUl0ZW1zKHRoaXMpO1xuXHRcdFx0XHRyZXQucHVzaChsZXZlbCk7XG5cdFx0XHR9KTtcblxuXHRcdFx0cmV0dXJuIHJldDtcblxuXHRcdFx0ZnVuY3Rpb24gX3JlY3Vyc2l2ZUl0ZW1zKGl0ZW0pIHtcblx0XHRcdFx0dmFyIGlkID0gKCQoaXRlbSkuYXR0cihvLmF0dHJpYnV0ZSB8fCBcImlkXCIpIHx8IFwiXCIpLm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSksXG5cdFx0XHRcdFx0Y3VycmVudEl0ZW07XG5cblx0XHRcdFx0dmFyIGRhdGEgPSAkKGl0ZW0pLmRhdGEoKTtcblx0XHRcdFx0aWYgKGRhdGEubmVzdGVkU29ydGFibGVJdGVtKSB7XG5cdFx0XHRcdFx0ZGVsZXRlIGRhdGEubmVzdGVkU29ydGFibGVJdGVtOyAvLyBSZW1vdmUgdGhlIG5lc3RlZFNvcnRhYmxlSXRlbSBvYmplY3QgZnJvbSB0aGUgZGF0YVxuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWYgKGlkKSB7XG5cdFx0XHRcdFx0Y3VycmVudEl0ZW0gPSB7XG5cdFx0XHRcdFx0XHRcImlkXCI6IGlkWzJdXG5cdFx0XHRcdFx0fTtcblxuXHRcdFx0XHRcdGN1cnJlbnRJdGVtID0gJC5leHRlbmQoe30sIGN1cnJlbnRJdGVtLCBkYXRhKTsgLy8gQ29tYmluZSB0aGUgdHdvIG9iamVjdHNcblxuXHRcdFx0XHRcdGlmICgkKGl0ZW0pLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmNoaWxkcmVuKG8uaXRlbXMpLmxlbmd0aCA+IDApIHtcblx0XHRcdFx0XHRcdGN1cnJlbnRJdGVtLmNoaWxkcmVuID0gW107XG5cdFx0XHRcdFx0XHQkKGl0ZW0pLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmNoaWxkcmVuKG8uaXRlbXMpLmVhY2goZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRcdHZhciBsZXZlbCA9IF9yZWN1cnNpdmVJdGVtcyh0aGlzKTtcblx0XHRcdFx0XHRcdFx0Y3VycmVudEl0ZW0uY2hpbGRyZW4ucHVzaChsZXZlbCk7XG5cdFx0XHRcdFx0XHR9KTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0cmV0dXJuIGN1cnJlbnRJdGVtO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fSxcblxuXHRcdHRvQXJyYXk6IGZ1bmN0aW9uKG9wdGlvbnMpIHtcblxuXHRcdFx0dmFyIG8gPSAkLmV4dGVuZCh7fSwgdGhpcy5vcHRpb25zLCBvcHRpb25zKSxcblx0XHRcdFx0c0RlcHRoID0gby5zdGFydERlcHRoQ291bnQgfHwgMCxcblx0XHRcdFx0cmV0ID0gW10sXG5cdFx0XHRcdGxlZnQgPSAxO1xuXG5cdFx0XHRpZiAoIW8uZXhjbHVkZVJvb3QpIHtcblx0XHRcdFx0cmV0LnB1c2goe1xuXHRcdFx0XHRcdFwiaXRlbV9pZFwiOiBvLnJvb3RJRCxcblx0XHRcdFx0XHRcInBhcmVudF9pZFwiOiBudWxsLFxuXHRcdFx0XHRcdFwiZGVwdGhcIjogc0RlcHRoLFxuXHRcdFx0XHRcdFwibGVmdFwiOiBsZWZ0LFxuXHRcdFx0XHRcdFwicmlnaHRcIjogKCQoby5pdGVtcywgdGhpcy5lbGVtZW50KS5sZW5ndGggKyAxKSAqIDJcblx0XHRcdFx0fSk7XG5cdFx0XHRcdGxlZnQrKztcblx0XHRcdH1cblxuXHRcdFx0JCh0aGlzLmVsZW1lbnQpLmNoaWxkcmVuKG8uaXRlbXMpLmVhY2goZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGxlZnQgPSBfcmVjdXJzaXZlQXJyYXkodGhpcywgc0RlcHRoLCBsZWZ0KTtcblx0XHRcdH0pO1xuXG5cdFx0XHRyZXQgPSByZXQuc29ydChmdW5jdGlvbihhLCBiKSB7IHJldHVybiAoYS5sZWZ0IC0gYi5sZWZ0KTsgfSk7XG5cblx0XHRcdHJldHVybiByZXQ7XG5cblx0XHRcdGZ1bmN0aW9uIF9yZWN1cnNpdmVBcnJheShpdGVtLCBkZXB0aCwgX2xlZnQpIHtcblxuXHRcdFx0XHR2YXIgcmlnaHQgPSBfbGVmdCArIDEsXG5cdFx0XHRcdFx0aWQsXG5cdFx0XHRcdFx0cGlkLFxuXHRcdFx0XHRcdHBhcmVudEl0ZW07XG5cblx0XHRcdFx0aWYgKCQoaXRlbSkuY2hpbGRyZW4oby5saXN0VHlwZSkuY2hpbGRyZW4oby5pdGVtcykubGVuZ3RoID4gMCkge1xuXHRcdFx0XHRcdGRlcHRoKys7XG5cdFx0XHRcdFx0JChpdGVtKS5jaGlsZHJlbihvLmxpc3RUeXBlKS5jaGlsZHJlbihvLml0ZW1zKS5lYWNoKGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdFx0cmlnaHQgPSBfcmVjdXJzaXZlQXJyYXkoJCh0aGlzKSwgZGVwdGgsIHJpZ2h0KTtcblx0XHRcdFx0XHR9KTtcblx0XHRcdFx0XHRkZXB0aC0tO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWQgPSAoJChpdGVtKS5hdHRyKG8uYXR0cmlidXRlIHx8IFwiaWRcIikpLm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSk7XG5cblx0XHRcdFx0aWYgKGRlcHRoID09PSBzRGVwdGgpIHtcblx0XHRcdFx0XHRwaWQgPSBvLnJvb3RJRDtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRwYXJlbnRJdGVtID0gKCQoaXRlbSkucGFyZW50KG8ubGlzdFR5cGUpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0LnBhcmVudChvLml0ZW1zKVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdC5hdHRyKG8uYXR0cmlidXRlIHx8IFwiaWRcIikpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0Lm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSk7XG5cdFx0XHRcdFx0cGlkID0gcGFyZW50SXRlbVsyXTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdGlmIChpZCkge1xuXHRcdFx0XHRcdCAgICAgICAgdmFyIG5hbWUgPSAkKGl0ZW0pLmRhdGEoXCJuYW1lXCIpO1xuXHRcdFx0XHRcdFx0cmV0LnB1c2goe1xuXHRcdFx0XHRcdFx0XHRcImlkXCI6IGlkWzJdLFxuXHRcdFx0XHRcdFx0XHRcInBhcmVudF9pZFwiOiBwaWQsXG5cdFx0XHRcdFx0XHRcdFwiZGVwdGhcIjogZGVwdGgsXG5cdFx0XHRcdFx0XHRcdFwibGVmdFwiOiBfbGVmdCxcblx0XHRcdFx0XHRcdFx0XCJyaWdodFwiOiByaWdodCxcblx0XHRcdFx0XHRcdFx0XCJuYW1lXCI6bmFtZVxuXHRcdFx0XHRcdFx0fSk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRfbGVmdCA9IHJpZ2h0ICsgMTtcblx0XHRcdFx0cmV0dXJuIF9sZWZ0O1xuXHRcdFx0fVxuXG5cdFx0fSxcblxuXHRcdF9jbGVhckVtcHR5OiBmdW5jdGlvbiAoaXRlbSkge1xuXHRcdFx0ZnVuY3Rpb24gcmVwbGFjZUNsYXNzKGVsZW0sIHNlYXJjaCwgcmVwbGFjZSwgc3dhcCkge1xuXHRcdFx0XHRpZiAoc3dhcCkge1xuXHRcdFx0XHRcdHNlYXJjaCA9IFtyZXBsYWNlLCByZXBsYWNlID0gc2VhcmNoXVswXTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdCQoZWxlbSkucmVtb3ZlQ2xhc3Moc2VhcmNoKS5hZGRDbGFzcyhyZXBsYWNlKTtcblx0XHRcdH1cblxuXHRcdFx0dmFyIG8gPSB0aGlzLm9wdGlvbnMsXG5cdFx0XHRcdGNoaWxkcmVuTGlzdCA9ICQoaXRlbSkuY2hpbGRyZW4oby5saXN0VHlwZSksXG5cdFx0XHRcdGhhc0NoaWxkcmVuID0gY2hpbGRyZW5MaXN0LmlzKCc6bm90KDplbXB0eSknKTtcblxuXHRcdFx0dmFyIGRvTm90Q2xlYXIgPVxuXHRcdFx0XHRvLmRvTm90Q2xlYXIgfHxcblx0XHRcdFx0aGFzQ2hpbGRyZW4gfHxcblx0XHRcdFx0by5wcm90ZWN0Um9vdCAmJiAkKGl0ZW0pWzBdID09PSB0aGlzLmVsZW1lbnRbMF07XG5cblx0XHRcdGlmIChvLmlzVHJlZSkge1xuXHRcdFx0XHRyZXBsYWNlQ2xhc3MoaXRlbSwgby5icmFuY2hDbGFzcywgby5sZWFmQ2xhc3MsIGRvTm90Q2xlYXIpO1xuXG5cdFx0XHRcdGlmIChkb05vdENsZWFyICYmIGhhc0NoaWxkcmVuKSB7XG5cdFx0XHRcdFx0cmVwbGFjZUNsYXNzKGl0ZW0sIG8uY29sbGFwc2VkQ2xhc3MsIG8uZXhwYW5kZWRDbGFzcyk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0aWYgKCFkb05vdENsZWFyKSB7XG5cdFx0XHRcdGNoaWxkcmVuTGlzdC5yZW1vdmUoKTtcblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0X2dldExldmVsOiBmdW5jdGlvbihpdGVtKSB7XG5cblx0XHRcdHZhciBsZXZlbCA9IDEsXG5cdFx0XHRcdGxpc3Q7XG5cblx0XHRcdGlmICh0aGlzLm9wdGlvbnMubGlzdFR5cGUpIHtcblx0XHRcdFx0bGlzdCA9IGl0ZW0uY2xvc2VzdCh0aGlzLm9wdGlvbnMubGlzdFR5cGUpO1xuXHRcdFx0XHR3aGlsZSAobGlzdCAmJiBsaXN0Lmxlbmd0aCA+IDAgJiYgIWxpc3QuaXMoXCIudWktc29ydGFibGVcIikpIHtcblx0XHRcdFx0XHRsZXZlbCsrO1xuXHRcdFx0XHRcdGxpc3QgPSBsaXN0LnBhcmVudCgpLmNsb3Nlc3QodGhpcy5vcHRpb25zLmxpc3RUeXBlKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gbGV2ZWw7XG5cdFx0fSxcblxuXHRcdF9nZXRDaGlsZExldmVsczogZnVuY3Rpb24ocGFyZW50LCBkZXB0aCkge1xuXHRcdFx0dmFyIHNlbGYgPSB0aGlzLFxuXHRcdFx0XHRvID0gdGhpcy5vcHRpb25zLFxuXHRcdFx0XHRyZXN1bHQgPSAwO1xuXHRcdFx0ZGVwdGggPSBkZXB0aCB8fCAwO1xuXG5cdFx0XHQkKHBhcmVudCkuY2hpbGRyZW4oby5saXN0VHlwZSkuY2hpbGRyZW4oby5pdGVtcykuZWFjaChmdW5jdGlvbihpbmRleCwgY2hpbGQpIHtcblx0XHRcdFx0cmVzdWx0ID0gTWF0aC5tYXgoc2VsZi5fZ2V0Q2hpbGRMZXZlbHMoY2hpbGQsIGRlcHRoICsgMSksIHJlc3VsdCk7XG5cdFx0XHR9KTtcblxuXHRcdFx0cmV0dXJuIGRlcHRoID8gcmVzdWx0ICsgMSA6IHJlc3VsdDtcblx0XHR9LFxuXG5cdFx0X2lzQWxsb3dlZDogZnVuY3Rpb24ocGFyZW50SXRlbSwgbGV2ZWwsIGxldmVscykge1xuXHRcdFx0dmFyIG8gPSB0aGlzLm9wdGlvbnMsXG5cdFx0XHRcdC8vIHRoaXMgdGFrZXMgaW50byBhY2NvdW50IHRoZSBtYXhMZXZlbHMgc2V0IHRvIHRoZSByZWNpcGllbnQgbGlzdFxuXHRcdFx0XHRtYXhMZXZlbHMgPSB0aGlzXG5cdFx0XHRcdFx0LnBsYWNlaG9sZGVyXG5cdFx0XHRcdFx0LmNsb3Nlc3QoXCIudWktc29ydGFibGVcIilcblx0XHRcdFx0XHQubmVzdGVkU29ydGFibGUoXCJvcHRpb25cIiwgXCJtYXhMZXZlbHNcIiksXG5cblx0XHRcdFx0Ly8gQ2hlY2sgaWYgdGhlIHBhcmVudCBoYXMgY2hhbmdlZCB0byBwcmV2ZW50IGl0LCB3aGVuIG8uZGlzYWJsZVBhcmVudENoYW5nZSBpcyB0cnVlXG5cdFx0XHRcdG9sZFBhcmVudCA9IHRoaXMuY3VycmVudEl0ZW0ucGFyZW50KCkucGFyZW50KCksXG5cdFx0XHRcdGRpc2FibGVkQnlQYXJlbnRjaGFuZ2UgPSBvLmRpc2FibGVQYXJlbnRDaGFuZ2UgJiYgKFxuXHRcdFx0XHRcdC8vRnJvbSBzb21ld2hlcmUgdG8gc29tZXdoZXJlIGVsc2UsIGV4Y2VwdCB0aGUgcm9vdFxuXHRcdFx0XHRcdHR5cGVvZiBwYXJlbnRJdGVtICE9PSAndW5kZWZpbmVkJyAmJiAhb2xkUGFyZW50LmlzKHBhcmVudEl0ZW0pIHx8XG5cdFx0XHRcdFx0dHlwZW9mIHBhcmVudEl0ZW0gPT09ICd1bmRlZmluZWQnICYmIG9sZFBhcmVudC5pcyhcImxpXCIpXHQvL0Zyb20gc29tZXdoZXJlIHRvIHRoZSByb290XG5cdFx0XHRcdCk7XG5cdFx0XHQvLyBtanMgLSBpcyB0aGUgcm9vdCBwcm90ZWN0ZWQ/XG5cdFx0XHQvLyBtanMgLSBhcmUgd2UgbmVzdGluZyB0b28gZGVlcD9cblx0XHRcdGlmIChcblx0XHRcdFx0ZGlzYWJsZWRCeVBhcmVudGNoYW5nZSB8fFxuXHRcdFx0XHQhby5pc0FsbG93ZWQodGhpcy5wbGFjZWhvbGRlciwgcGFyZW50SXRlbSwgdGhpcy5jdXJyZW50SXRlbSlcblx0XHRcdCkge1xuXHRcdFx0XHR0aGlzLnBsYWNlaG9sZGVyLmFkZENsYXNzKG8uZXJyb3JDbGFzcyk7XG5cdFx0XHRcdGlmIChtYXhMZXZlbHMgPCBsZXZlbHMgJiYgbWF4TGV2ZWxzICE9PSAwKSB7XG5cdFx0XHRcdFx0dGhpcy5iZXlvbmRNYXhMZXZlbHMgPSBsZXZlbHMgLSBtYXhMZXZlbHM7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0dGhpcy5iZXlvbmRNYXhMZXZlbHMgPSAxO1xuXHRcdFx0XHR9XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRpZiAobWF4TGV2ZWxzIDwgbGV2ZWxzICYmIG1heExldmVscyAhPT0gMCkge1xuXHRcdFx0XHRcdHRoaXMucGxhY2Vob2xkZXIuYWRkQ2xhc3Moby5lcnJvckNsYXNzKTtcblx0XHRcdFx0XHR0aGlzLmJleW9uZE1heExldmVscyA9IGxldmVscyAtIG1heExldmVscztcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHR0aGlzLnBsYWNlaG9sZGVyLnJlbW92ZUNsYXNzKG8uZXJyb3JDbGFzcyk7XG5cdFx0XHRcdFx0dGhpcy5iZXlvbmRNYXhMZXZlbHMgPSAwO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdH0pKTtcblxuXHQkLm1qcy5uZXN0ZWRTb3J0YWJsZS5wcm90b3R5cGUub3B0aW9ucyA9ICQuZXh0ZW5kKFxuXHRcdHt9LFxuXHRcdCQudWkuc29ydGFibGUucHJvdG90eXBlLm9wdGlvbnMsXG5cdFx0JC5tanMubmVzdGVkU29ydGFibGUucHJvdG90eXBlLm9wdGlvbnNcblx0KTtcbn0pKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==