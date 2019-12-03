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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(3);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(17);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS90cmVlL0l0ZW0uanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS90cmVlL1RyZWUuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NsYXNzQ2FsbENoZWNrLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jcmVhdGVDbGFzcy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9lcy9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9pbnRlcm5hbHMvcGF0aC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9zdGFibGUvanNvbi9zdHJpbmdpZnkuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS9kYXRhLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9qcXVlcnktdWkvdWkvaWUuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS9zY3JvbGwtcGFyZW50LmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9qcXVlcnktdWkvdWkvdmVyc2lvbi5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LXVpL3VpL3dpZGdldC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LXVpL3VpL3dpZGdldHMvbW91c2UuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS93aWRnZXRzL3NvcnRhYmxlLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvanF1ZXJ5L3NyYy9qcXVlcnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvbG9kYXNoL2xvZGFzaC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL25lc3RlZFNvcnRhYmxlL2pxdWVyeS5tanMubmVzdGVkU29ydGFibGUuanMiLCJ3ZWJwYWNrOi8vL2V4dGVybmFsIFwiX3hlX2RsbF9jb21tb25cIiJdLCJuYW1lcyI6WyJfbm9kZVRlbXBsYXRlIiwiSXRlbSIsIm9iaiIsIm5vZGVUZW1wbGF0ZSIsImdldEl0ZW1zVGVtcGxhdGUiLCJpdGVtcyIsInJvb3RJZCIsImlzUm9vdCIsInRlbXAiLCJsZW5ndGgiLCJtYWtlSXRlbSIsIml0ZW1Ob2RlIiwicHJvcCIsIml0ZW0iLCJtb3ZlIiwiaWQiLCJPYmplY3QiLCJfcHJldmVudCIsImRlZmF1bHRPcHRpb25zIiwiY29ubmVjdFdpdGgiLCJmb3JjZVBsYWNlaG9sZGVyU2l6ZSIsImhlbHBlciIsImhhbmRsZSIsImxpc3RUeXBlIiwib3BhY2l0eSIsImlzVHJlZSIsImNhbmNlbCIsInRvbGVyYW5jZSIsInRvbGVyYW5jZUVsZW1lbnQiLCJUcmVlIiwiZ2V0VGVtcGxhdGUiLCJmbGFnIiwiJHRhcmdldCIsImNvbmZpZyIsInRyZWVPcHRpb25zIiwicGFyZW50SWQiLCJvcmRlcmluZyIsIml0ZW1JZCIsIm9wdGlvbnMiLCIkIiwiZXh0ZW5kIiwiXyIsImlzT2JqZWN0IiwiaXNGdW5jdGlvbiIsInN0YXJ0IiwiZSIsInVpIiwiJGl0ZW0iLCJpdGVtRGF0YSIsImRhdGEiLCJkcmFnU3RhcnQiLCJzdG9wIiwiJHBhcmVudEl0ZW0iLCJwYXJlbnRzIiwiZXEiLCJtb3ZlUGFyZW50SWQiLCJtb3ZlT3JkZXJpbmciLCJjbG9zZXN0IiwiYWRkQ2xhc3MiLCJpbmRleCIsImRyYWdTdG9wIiwidXBkYXRlIiwicmVsb2NhdGUiLCJyZWNlaXZlIiwicGxhY2Vob2xkZXIiLCJlbGVtZW50IiwiY2xvbmUiLCJzaG93Iiwid3JhcEFsbCIsInBhcmVudCIsImh0bWwiLCJpc0FsbG93ZWQiLCJwbGFjZWhvbGRlclBhcmVudCIsImN1cnJlbnRJdGVtIiwibmVzdGVkU29ydGFibGUiLCJhcHBlbmQiLCIkY29udGFpbmVyIiwiZm4iLCJuZXN0ZWQiLCJ3aW5kb3ciXSwibWFwcGluZ3MiOiI7QUFBQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7O0FBR0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLGtEQUEwQyxnQ0FBZ0M7QUFDMUU7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxnRUFBd0Qsa0JBQWtCO0FBQzFFO0FBQ0EseURBQWlELGNBQWM7QUFDL0Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlEQUF5QyxpQ0FBaUM7QUFDMUUsd0hBQWdILG1CQUFtQixFQUFFO0FBQ3JJO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsbUNBQTJC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QUN0QztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0EsRUFBRTs7QUFFRjtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0EsNEJBQTRCLGtCQUFrQjtBQUM5QyxFQUFFOztBQUVGO0FBQ0EsNEJBQTRCLGlCQUFpQjtBQUM3QyxFQUFFOztBQUVGO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQSxlQUFlLG9CQUFvQjtBQUNuQztBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNILEVBQUU7O0FBRUY7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNIO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0EsR0FBRztBQUNILEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSCxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNILEVBQUU7O0FBRUY7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsU0FBUyxrQ0FBa0M7QUFDM0M7QUFDQTtBQUNBLGNBQWM7QUFDZDs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLGNBQWM7QUFDZDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsR0FBRztBQUNIO0FBQ0EsR0FBRztBQUNIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0EsQ0FBQzs7QUFFRDs7QUFFQSxDQUFDOzs7Ozs7Ozs7Ozs7QUM1dEJEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxN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Q0E7QUFDQSx3Q0FBd0MsUUFBUTtBQUNoRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBOztBQUVBLElBQUk7O0FBRUo7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esa0NBQWtDLFFBQVE7O0FBRTFDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7QUFDQTs7QUFFQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBOztBQUVBLDJDQUEyQyxlQUFlOztBQUUxRDtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTs7QUFFQTtBQUNBLDRDQUE0QyxRQUFRO0FBQ3BEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQSxxQ0FBcUM7QUFDckM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTs7QUFFSjtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7O0FBRUEsRUFBRTs7QUFFRjtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7O0FBRUg7QUFDQTtBQUNBO0FBQ0EscURBQXFEOztBQUVyRDtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esb0NBQW9DLFFBQVE7QUFDNUM7QUFDQSw2QkFBNkIsUUFBUTtBQUNyQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxnQ0FBZ0MsZ0RBQWdEO0FBQ2hGO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSwrQkFBK0IsUUFBUTtBQUN2QztBQUNBOztBQUVBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7O0FBRUE7QUFDQSxtQkFBbUIsaUJBQWlCO0FBQ3BDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVILEVBQUU7O0FBRUY7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSx3REFBd0QseUJBQXlCO0FBQ2pGO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLG9DQUFvQyxRQUFRO0FBQzVDO0FBQ0EsNkJBQTZCLFFBQVE7QUFDckM7QUFDQTtBQUNBO0FBQ0E7QUFDQSwwQ0FBMEMseUJBQXlCO0FBQ25FO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSwrQkFBK0IsUUFBUTtBQUN2QztBQUNBOztBQUVBLGdEQUFnRCxtQkFBbUI7QUFDbkU7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBLGtDQUFrQyxRQUFRO0FBQzFDOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsd0NBQXdDLFFBQVE7QUFDaEQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjtBQUNBOztBQUVBO0FBQ0EsaUJBQWlCO0FBQ2pCO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsdUNBQXVDLFFBQVE7O0FBRS9DO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsSUFBSTs7QUFFSjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLG1DQUFtQyxRQUFRO0FBQzNDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUEsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsVUFBVTtBQUNWO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRztBQUNILFdBQVc7QUFDWDs7QUFFQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLGdDQUFnQzs7QUFFaEM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVILEVBQUU7O0FBRUY7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSDtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx1Q0FBdUMsUUFBUTtBQUMvQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBLG9DQUFvQztBQUNwQztBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLGVBQWUsNEJBQTRCOztBQUUzQztBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLENBQUM7O0FBRUQsQ0FBQzs7Ozs7Ozs7Ozs7O0FDamhERCw4Rzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLE1BQU0sSUFBMEM7O0FBRWhEO0FBQ0EsRUFBRSxpQ0FBTztBQUNULEdBQUcsd0VBQVE7QUFDWCxHQUFHLGdHQUFvQjtBQUN2QixHQUFHLG9DQUFFLE9BQU87QUFBQTtBQUFBO0FBQUEsb0dBQUU7QUFDZCxFQUFFLE1BQU0sRUFJTjtBQUNGLENBQUM7QUFDRDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEsMkNBQTJDOztBQUUzQztBQUNBO0FBQ0E7QUFDQTtBQUNBLDBCQUEwQixhQUFhLEVBQUU7QUFDekM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxRQUFRO0FBQ1I7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTs7QUFFSjtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxrQ0FBa0MsUUFBUTs7QUFFMUM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxNQUFNO0FBQ047QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLFFBQVE7QUFDUjtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLFNBQVM7QUFDVDtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQSxRQUFRO0FBQ1I7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBLElBQUk7O0FBRUo7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQSxJQUFJOztBQUVKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSw2REFBNkQ7QUFDN0QsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxHQUFHOztBQUVIOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esa0NBQWtDLFFBQVE7QUFDMUM7QUFDQTtBQUNBOztBQUVBLEdBQUc7O0FBRUg7O0FBRUEsc0JBQXNCO0FBQ3RCO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJOztBQUVKO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxHQUFHOztBQUVIOztBQUVBLHNCQUFzQjtBQUN0Qjs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxJQUFJOztBQUVKOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0Esb0NBQW9DO0FBQ3BDOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLDhCQUE4QixxQkFBcUI7O0FBRW5EO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIOztBQUVBLHNCQUFzQjtBQUN0QjtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsSUFBSTs7QUFFSixrQ0FBa0MsMEJBQTBCLEVBQUU7O0FBRTlEOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsTUFBTTtBQUNOO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQOztBQUVBO0FBQ0E7QUFDQTs7QUFFQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLElBQUk7O0FBRUo7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0E7QUFDQSxDQUFDOzs7Ozs7Ozs7Ozs7QUM3NEJELGdDIiwiZmlsZSI6ImFzc2V0cy9jb3JlL2NvbW1vbi9qcy94ZS50cmVlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL3RyZWUvVHJlZS5qc1wiKTtcbiIsIi8qKiBAcHJpdmF0ZSAqL1xubGV0IF9ub2RlVGVtcGxhdGVcblxuY2xhc3MgSXRlbSB7XG4gIC8qKlxuICAgKiBpdGVtIO2FnO2UjOumv+ydhCDrpqzthLTtlZzri6QuXG4gICAqIEBtZW1iZXJvZiBJdGVtXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBvYmpcbiAgICoqL1xuICBnZXRUZW1wbGF0ZSAob2JqKSB7XG4gICAgX25vZGVUZW1wbGF0ZSA9IG9iai5ub2RlVGVtcGxhdGVcblxuICAgIHJldHVybiB0aGlzLmdldEl0ZW1zVGVtcGxhdGUob2JqLml0ZW1zLCBvYmoucm9vdElkLCB0cnVlKVxuICB9XG5cbiAgLyoqXG4gICAqIGl0ZW0g7YWc7ZSM66a/7J2EIOumrO2EtO2VnOuLpC5cbiAgICogQG1lbWJlcm9mIEl0ZW1cbiAgICogQHBhcmFtIHtvYmplY3R9IGl0ZW1zXG4gICAqIEBwYXJhbSB7c3RyaW5nfSByb290SWRcbiAgICogQHBhcmFtIHtib29sZWFufSBpc1Jvb3RcbiAgICogQHJldHVybiB7c3RyaW5nfVxuICAgKiovXG4gIGdldEl0ZW1zVGVtcGxhdGUgKGl0ZW1zLCByb290SWQsIGlzUm9vdCkge1xuICAgIGxldCB0ZW1wID0gJydcblxuICAgIGlmIChpdGVtcyAmJiBpdGVtcy5sZW5ndGggIT0gMCB8fCBpc1Jvb3QpIHtcbiAgICAgIGlmIChpc1Jvb3QgJiYgcm9vdElkKSB7XG4gICAgICAgIHRlbXAgKz0gJzx1bCBjbGFzcz1cIml0ZW0tY29udGFpbmVyXCIgZGF0YS1wYXJlbnQ9XCInICsgcm9vdElkICsgJ1wiPidcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHRlbXAgKz0gJzx1bCBjbGFzcz1cIml0ZW0tY29udGFpbmVyXCI+J1xuICAgICAgfVxuICAgIH1cblxuICAgIHRlbXAgKz0gdGhpcy5tYWtlSXRlbShpdGVtcywgX25vZGVUZW1wbGF0ZSlcblxuICAgIGlmIChpdGVtcyAmJiBpdGVtcy5sZW5ndGggIT0gMCB8fCBpc1Jvb3QpIHtcbiAgICAgIHRlbXAgKz0gJzwvdWw+J1xuICAgIH1cblxuICAgIHJldHVybiB0ZW1wXG4gIH1cblxuICAvKipcbiAgICAgKiBpdGVtIO2FnO2UjOumv+ydhCDrp4zrk6Dri6QuXG4gICAgICogQG1lbWJlcm9mIEl0ZW1cbiAgICAgKiBAcGFyYW0ge29iamVjdH0gb2JqXG4gICAgICogPHByZT5cbiAgICAgKiAgIGl0ZW1zXG4gICAgICogICBub2RlVGVtcGxhdGVcbiAgICAgKiA8L3ByZT5cbiAgICAgKiBAcGFyYW0ge2Z1bmN0aW9ufSBub2RlVGVtcGxhdGVcbiAgICAgKiBAcmV0dXJuIHtzdHJpbmd9XG4gICAgICoqL1xuICBtYWtlSXRlbSAoaXRlbXMsIG5vZGVUZW1wbGF0ZSkge1xuICAgIGxldCBpdGVtTm9kZSA9ICcnXG5cbiAgICBmb3IgKGNvbnN0IHByb3AgaW4gaXRlbXMpIHtcbiAgICAgIGNvbnN0IGl0ZW0gPSBpdGVtc1twcm9wXVxuICAgICAgY29uc3QgbW92ZSA9IChpdGVtLml0ZW1zICYmIGl0ZW0uaXRlbXMubGVuZ3RoKSA/ICdtb3ZlJyA6ICcnXG5cbiAgICAgIGl0ZW1Ob2RlICs9IFwiPGxpIGNsYXNzPSdpdGVtIFwiICsgbW92ZSArIFwiJyBpZD0naXRlbV9cIiArIGl0ZW0uaWQgKyBcIic+XCJcbiAgICAgIGl0ZW1Ob2RlICs9IFwiPGRpdiBjbGFzcz0naXRlbS1jb250ZW50JyBkYXRhLWl0ZW09J1wiICsgSlNPTi5zdHJpbmdpZnkoaXRlbSkgKyBcIic+XCJcbiAgICAgIGl0ZW1Ob2RlICs9IFwiPGJ1dHRvbiBjbGFzcz0nYnRuIGhhbmRsZXInPjxpIGNsYXNzPSd4aS1kcmFnLXZlcnRpY2FsJz48L2k+PC9idXR0b24+XCJcbiAgICAgIGl0ZW1Ob2RlICs9IG5vZGVUZW1wbGF0ZShpdGVtKVxuICAgICAgaXRlbU5vZGUgKz0gJzwvZGl2PidcblxuICAgICAgaWYgKGl0ZW0uaXRlbXMgJiYgaXRlbS5pdGVtcyBpbnN0YW5jZW9mIE9iamVjdCkge1xuICAgICAgICBpdGVtTm9kZSArPSB0aGlzLmdldEl0ZW1zVGVtcGxhdGUoaXRlbS5pdGVtcylcbiAgICAgIH1cblxuICAgICAgaXRlbU5vZGUgKz0gJzwvbGk+J1xuICAgIH1cblxuICAgIHJldHVybiBpdGVtTm9kZVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IG5ldyBJdGVtKClcbiIsImltcG9ydCAnbmVzdGVkU29ydGFibGUnXG5pbXBvcnQgJCBmcm9tICdqcXVlcnknXG5pbXBvcnQgXyBmcm9tICdsb2Rhc2gnXG5pbXBvcnQgSXRlbSBmcm9tICcuL0l0ZW0nXG5cbmxldCBfcHJldmVudCA9IGZhbHNlXG5cbmNvbnN0IGRlZmF1bHRPcHRpb25zID0ge1xuICBjb25uZWN0V2l0aDogJy5pdGVtLWNvbnRhaW5lcicsXG4gIGZvcmNlUGxhY2Vob2xkZXJTaXplOiB0cnVlLFxuICBoZWxwZXI6ICdjbG9uZScsXG4gIGhhbmRsZTogJy5pdGVtLWNvbnRlbnQgLmhhbmRsZXInLFxuICBsaXN0VHlwZTogJ3VsJyxcbiAgaXRlbXM6ICdsaScsXG4gIG9wYWNpdHk6IDAuNixcbiAgaXNUcmVlOiB0cnVlLFxuICBjYW5jZWw6ICcnLFxuICB0b2xlcmFuY2U6ICdwb2ludGVyJyxcbiAgdG9sZXJhbmNlRWxlbWVudDogJz4gZGl2J1xufVxuXG5jbGFzcyBUcmVlIHtcbiAgLyoqXG4gICAqXG4gICAqIEBtZW1iZXJvZiBUcmVlXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBvYmpcbiAgICogPHByZT5cbiAgICogICByb290SWQ6IHRyZWUgcm9vdCBpZFxuICAgKiAgIG5vZGVUZW1wbGF0ZTogaXRlbeyViOyXkCDsg53shLHtlaAgaHRtbFxuICAgKiAgIGl0ZW1zOiBUcmVlIOq1rOyEsSDrjbDsnbTthLBcbiAgICogPC9wcmU+XG4gICAqIEByZXR1cm4ge3N0cmluZ30gaXRlbXMgaHRtbFxuICAgKiovXG4gIGdldEl0ZW1zVGVtcGxhdGUgKG9iaikge1xuICAgIHJldHVybiBJdGVtLmdldFRlbXBsYXRlKG9iailcbiAgfVxuXG4gIC8qKlxuICAgICAqIEBtZW1iZXJvZiBUcmVlXG4gICAgICogQHBhcmFtIHtib29sZWFufSBmbGFnXG4gICAgICogQGRlc2NyaXB0aW9uIFRyZWUg7J2064+ZIOuwqeyngFxuICAgICAqICovXG4gIHNldFByZXZlbnQgKGZsYWcpIHtcbiAgICBfcHJldmVudCA9IGZsYWdcbiAgfVxuXG4gIC8qKlxuICAgKiBAbWVtYmVyb2YgVHJlZVxuICAgKiBAcGFyYW0ge29iamVjdH0gJHRhcmdldCB0cmVl6rWs7ISx7J2YIHdyYXBwZXJcbiAgICogQHBhcmFtIHtvYmplY3R9IGNvbmZpZ1xuICAgKiA8cHJlPlxuICAgKiAgIOy2lOqwgOyYteyFmFxuICAgKiAgIGRyYWdTdGFydCA6IGRyYWcg7Iuc7J6R7IucIO2YuOy2nCB0cmVlT3B0aW9u7J2YIHN0YXJ066W8IOyYpOuyhOudvOydtOuTnCDqsIDriqXtlaguXG4gICAqICAgZHJhZ1N0b3AgOiBkcm9w7IucIO2YuOy2nCB0cmVlT3B0aW9u7J2YIGVuZOulvCDsmKTrsoTrnbzsnbTrk5wg6rCA64ql7ZWoLlxuICAgKiAgIHVwZGF0ZSA6IGRyYWfrpbwg7Ya17ZWcIHRyZWXsnZgg67OA64+Z7IKs7ZWt7J20IOyeiOydhCDqsr3smrAg7Zi47LacIGl0ZW0sIHBhcmVudCwgdGFyZ2V0LCBvcmRlcmluZ+uTseydmCDsoJXrs7Trpbwg7J247J6Q66GcIOuztOuCtOykgOuLpFxuICAgKiA8L3ByZT5cbiAgICogQHBhcmFtIHtvYmplY3R9IHRyZWVPcHRpb25zIG5lc3RlZFNvcnRhYmxlIFRyZWUgT3B0aW9uc1xuICAgKiBAZGVzY3JpcHRpb24g7Yq466asIOq1rOyEsVxuICAgKiovXG4gIHJ1biAoJHRhcmdldCwgY29uZmlnLCB0cmVlT3B0aW9ucykge1xuICAgIGxldCBwYXJlbnRJZFxuICAgIGxldCBvcmRlcmluZ1xuICAgIGxldCBpdGVtSWRcbiAgICBsZXQgb3B0aW9ucyA9ICQuZXh0ZW5kKHt9LCBkZWZhdWx0T3B0aW9ucylcblxuICAgIC8vIGN1c3RvbSBvcHRpb24g7LaU6rCAXG4gICAgaWYgKF8uaXNPYmplY3QodHJlZU9wdGlvbnMpKSB7XG4gICAgICAkLmV4dGVuZChvcHRpb25zLCB0cmVlT3B0aW9ucylcbiAgICB9XG5cbiAgICAvLyBzdGFydCBmdW5jdGlvbiDstpTqsIBcbiAgICBpZiAoXy5pc09iamVjdCh0cmVlT3B0aW9ucykgJiYgXy5pc0Z1bmN0aW9uKHRyZWVPcHRpb25zLnN0YXJ0KSkge1xuICAgICAgb3B0aW9ucy5zdGFydCA9IHRyZWVPcHRpb25zLnN0YXJ0XG4gICAgfSBlbHNlIHtcbiAgICAgIG9wdGlvbnMuc3RhcnQgPSBmdW5jdGlvbiAoZSwgdWkpIHtcbiAgICAgICAgY29uc3QgJGl0ZW0gPSAkKHVpLml0ZW0pXG4gICAgICAgIGNvbnN0IGl0ZW1EYXRhID0gJGl0ZW0uZmluZCgnPiAuaXRlbS1jb250ZW50JykuZGF0YSgnaXRlbScpXG5cbiAgICAgICAgcGFyZW50SWQgPSBpdGVtRGF0YS5wYXJlbnRJZFxuICAgICAgICBvcmRlcmluZyA9IGl0ZW1EYXRhLm9yZGVyaW5nXG4gICAgICAgIGl0ZW1JZCA9IGl0ZW1EYXRhLmlkXG5cbiAgICAgICAgaWYgKF8uaXNPYmplY3QoY29uZmlnKSAmJiBfLmlzRnVuY3Rpb24oY29uZmlnLmRyYWdTdGFydCkpIHtcbiAgICAgICAgICBjb25maWcuZHJhZ1N0YXJ0KClcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH1cblxuICAgIC8vIHN0b3AgZnVuY3Rpb24g7LaU6rCAXG4gICAgaWYgKF8uaXNPYmplY3QodHJlZU9wdGlvbnMpICYmIF8uaXNGdW5jdGlvbih0cmVlT3B0aW9ucy5zdG9wKSkge1xuICAgICAgb3B0aW9ucy5zdG9wID0gdHJlZU9wdGlvbnMuc3RvcFxuICAgIH0gZWxzZSB7XG4gICAgICBvcHRpb25zLnN0b3AgPSBmdW5jdGlvbiAoZSwgdWkpIHtcbiAgICAgICAgY29uc3QgJGl0ZW0gPSAkKHVpLml0ZW0pXG4gICAgICAgIGNvbnN0ICRwYXJlbnRJdGVtID0gJGl0ZW0ucGFyZW50cygnbGkuaXRlbScpLmVxKDApXG4gICAgICAgIGNvbnN0IG1vdmVQYXJlbnRJZCA9ICgkcGFyZW50SXRlbS5sZW5ndGggPiAwKSA/ICRwYXJlbnRJdGVtLmZpbmQoJz4gLml0ZW0tY29udGVudCcpLmRhdGEoJ2l0ZW0nKS5pZCA6ICRpdGVtLnBhcmVudHMoJy5pdGVtLWNvbnRhaW5lcicpLmRhdGEoJ3BhcmVudCcpXG4gICAgICAgIGNvbnN0IG1vdmVPcmRlcmluZyA9ICRpdGVtLmNsb3Nlc3QoJ3VsJykuYWRkQ2xhc3MoJ2l0ZW0tY29udGFpbmVyJykuZmluZCgnPiBsaS5pdGVtJykuaW5kZXgoJGl0ZW0pXG5cbiAgICAgICAgaWYgKF8uaXNPYmplY3QoY29uZmlnKSAmJiBfLmlzRnVuY3Rpb24oY29uZmlnLmRyYWdTdG9wKSkge1xuICAgICAgICAgIGNvbmZpZy5kcmFnU3RvcCgpXG4gICAgICAgIH1cblxuICAgICAgICBpZiAoKHBhcmVudElkICE9PSBtb3ZlUGFyZW50SWQgJiYgIV9wcmV2ZW50KSB8fCAob3JkZXJpbmcgIT09IG1vdmVPcmRlcmluZyAmJiAhX3ByZXZlbnQpKSB7XG4gICAgICAgICAgaWYgKF8uaXNPYmplY3QoY29uZmlnKSAmJiBfLmlzRnVuY3Rpb24oY29uZmlnLnVwZGF0ZSkpIHtcbiAgICAgICAgICAgIGNvbmZpZy51cGRhdGUoe1xuICAgICAgICAgICAgICBpdGVtOiAkaXRlbSxcbiAgICAgICAgICAgICAgaXRlbUlkOiBpdGVtSWQsXG4gICAgICAgICAgICAgIHBhcmVudElkOiBtb3ZlUGFyZW50SWQsXG4gICAgICAgICAgICAgIG9yZGVyaW5nOiBtb3ZlT3JkZXJpbmdcbiAgICAgICAgICAgIH0pXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9XG4gICAgfVxuXG4gICAgLy8gcmVsb2NhdGUgZnVuY3Rpb24g7LaU6rCAIGRlZmF1bHQg7IKs7Jqp7JWI7ZWoLlxuICAgIGlmIChfLmlzT2JqZWN0KHRyZWVPcHRpb25zKSAmJiBfLmlzRnVuY3Rpb24odHJlZU9wdGlvbnMucmVsb2NhdGUpKSB7XG4gICAgICBvcHRpb25zLnJlbG9jYXRlID0gdHJlZU9wdGlvbnMucmVsb2NhdGVcbiAgICB9XG5cbiAgICAvLyByZWNlaXZlIGZ1bmN0aW9uIOy2lOqwgCBkZWZhdWx0IOyCrOyaqeyViO2VqC5cbiAgICBpZiAoXy5pc09iamVjdCh0cmVlT3B0aW9ucykgJiYgXy5pc0Z1bmN0aW9uKHRyZWVPcHRpb25zLnJlY2VpdmUpKSB7XG4gICAgICBvcHRpb25zLnJlY2VpdmUgPSB0cmVlT3B0aW9ucy5yZWNlaXZlXG4gICAgfVxuXG4gICAgLy8gcGxhY2Vob2xkZXIg7LaU6rCAXG4gICAgaWYgKF8uaXNPYmplY3QodHJlZU9wdGlvbnMpICYmIHRyZWVPcHRpb25zLnBsYWNlaG9sZGVyKSB7XG4gICAgICBvcHRpb25zLnBsYWNlaG9sZGVyID0gdHJlZU9wdGlvbnMucGxhY2Vob2xkZXJcbiAgICB9IGVsc2Uge1xuICAgICAgb3B0aW9ucy5wbGFjZWhvbGRlciA9IHtcbiAgICAgICAgZWxlbWVudDogZnVuY3Rpb24gKCR0YXJnZXQpIHtcbiAgICAgICAgICByZXR1cm4gJHRhcmdldC5jbG9uZSgpLmFkZENsYXNzKCdjb3B5Jykuc2hvdygpLndyYXBBbGwoJzxkaXYgLz4nKS5wYXJlbnQoKS5odG1sKClcbiAgICAgICAgfSxcbiAgICAgICAgdXBkYXRlOiBmdW5jdGlvbiAoKSB7fVxuICAgICAgfVxuICAgIH1cblxuICAgIGlmIChfLmlzT2JqZWN0KHRyZWVPcHRpb25zKSAmJiBfLmlzRnVuY3Rpb24odHJlZU9wdGlvbnMuaXNBbGxvd2VkKSkge1xuICAgICAgb3B0aW9ucy5pc0FsbG93ZWQgPSB0cmVlT3B0aW9ucy5pc0FsbG93ZWRcbiAgICB9IGVsc2Uge1xuICAgICAgb3B0aW9ucy5pc0FsbG93ZWQgPSBmdW5jdGlvbiAocGxhY2Vob2xkZXIsIHBsYWNlaG9sZGVyUGFyZW50LCBjdXJyZW50SXRlbSkge1xuICAgICAgICByZXR1cm4gIV9wcmV2ZW50XG4gICAgICB9XG4gICAgfVxuXG4gICAgaWYgKCR0YXJnZXQuZmluZCgnLml0ZW0tY29udGFpbmVyJykubGVuZ3RoID4gMCkge1xuICAgICAgJHRhcmdldC5maW5kKCcuaXRlbS1jb250YWluZXInKS5uZXN0ZWRTb3J0YWJsZShvcHRpb25zKVxuICAgIH0gZWxzZSB7XG4gICAgICAkdGFyZ2V0LmFwcGVuZCgnPHVsIGNsYXNzPVwiaXRlbS1jb250YWluZXJcIj48L3VsPicpXG4gICAgICAkdGFyZ2V0LmZpbmQoJy5pdGVtLWNvbnRhaW5lcicpLm5lc3RlZFNvcnRhYmxlKG9wdGlvbnMpXG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIEBtZW1iZXJvZiBUcmVlXG4gICAqIEBwYXJhbSB7b2JqZWN0fSAkY29udGFpbmVyXG4gICAqIEBvYXJhbSB7b2JqZWN0fSBvYmpcbiAgICogPHByZT5cbiAgICogICBub2RlVGVtcGxhdGU6IGl0ZW3slYjsl5Ag7IOd7ISx7ZWgIGh0bWxcbiAgICogICBpdGVtXG4gICAqICAgbmVzdGVkIC0g7ZWY7JyEIGRlcHRoIOuFuOuTnOydvCDqsr3smrAgdWwuaXRlbS1jb250YWluZXLrpbwg7Y+s7ZWo7ZWY7JesIGFwcGVuZC4g7JWE64uQIOqyveyasCBsaS5pdGVt66eMIGFwcGVuZFxuICAgKiA8L3ByZT5cbiAgICogQHBhcmFtIHtmdW5jdGlvbn0gZm4gY2FsbGJhY2tcbiAgICoqL1xuICBhZGQgKCRjb250YWluZXIsIG9iaiwgZm4pIHtcbiAgICBpZiAob2JqLm5lc3RlZCkge1xuICAgICAgJGNvbnRhaW5lci5hcHBlbmQoSXRlbS5nZXRUZW1wbGF0ZShvYmopKVxuICAgIH0gZWxzZSB7XG4gICAgICAkY29udGFpbmVyLmFwcGVuZChJdGVtLm1ha2VJdGVtKG9iai5pdGVtcywgb2JqLm5vZGVUZW1wbGF0ZSkpXG4gICAgfVxuXG4gICAgaWYgKGZuICYmIHR5cGVvZiBmbiA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgZm4oKVxuICAgIH1cbiAgfVxufVxuXG53aW5kb3cuVHJlZSA9IG5ldyBUcmVlKClcblxuZXhwb3J0IGRlZmF1bHQgd2luZG93LlRyZWVcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgzKTsiLCJtb2R1bGUuZXhwb3J0cyA9IHJlcXVpcmUoXCJjb3JlLWpzLXB1cmUvc3RhYmxlL2pzb24vc3RyaW5naWZ5XCIpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoOSk7IiwidmFyIGNvcmUgPSByZXF1aXJlKCcuLi8uLi9pbnRlcm5hbHMvcGF0aCcpO1xudmFyICRKU09OID0gY29yZS5KU09OIHx8IChjb3JlLkpTT04gPSB7IHN0cmluZ2lmeTogSlNPTi5zdHJpbmdpZnkgfSk7XG5cbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gc3RyaW5naWZ5KGl0KSB7IC8vIGVzbGludC1kaXNhYmxlLWxpbmUgbm8tdW51c2VkLXZhcnNcbiAgcmV0dXJuICRKU09OLnN0cmluZ2lmeS5hcHBseSgkSlNPTiwgYXJndW1lbnRzKTtcbn07XG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTYpOyIsIm1vZHVsZS5leHBvcnRzID0gcmVxdWlyZSgnLi4vLi4vZXMvanNvbi9zdHJpbmdpZnknKTtcbiIsIi8qIVxuICogalF1ZXJ5IFVJIDpkYXRhIDEuMTIuMVxuICogaHR0cDovL2pxdWVyeXVpLmNvbVxuICpcbiAqIENvcHlyaWdodCBqUXVlcnkgRm91bmRhdGlvbiBhbmQgb3RoZXIgY29udHJpYnV0b3JzXG4gKiBSZWxlYXNlZCB1bmRlciB0aGUgTUlUIGxpY2Vuc2UuXG4gKiBodHRwOi8vanF1ZXJ5Lm9yZy9saWNlbnNlXG4gKi9cblxuLy8+PmxhYmVsOiA6ZGF0YSBTZWxlY3RvclxuLy8+Pmdyb3VwOiBDb3JlXG4vLz4+ZGVzY3JpcHRpb246IFNlbGVjdHMgZWxlbWVudHMgd2hpY2ggaGF2ZSBkYXRhIHN0b3JlZCB1bmRlciB0aGUgc3BlY2lmaWVkIGtleS5cbi8vPj5kb2NzOiBodHRwOi8vYXBpLmpxdWVyeXVpLmNvbS9kYXRhLXNlbGVjdG9yL1xuXG4oIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggWyBcImpxdWVyeVwiLCBcIi4vdmVyc2lvblwiIF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59ICggZnVuY3Rpb24oICQgKSB7XG5yZXR1cm4gJC5leHRlbmQoICQuZXhwclsgXCI6XCIgXSwge1xuXHRkYXRhOiAkLmV4cHIuY3JlYXRlUHNldWRvID9cblx0XHQkLmV4cHIuY3JlYXRlUHNldWRvKCBmdW5jdGlvbiggZGF0YU5hbWUgKSB7XG5cdFx0XHRyZXR1cm4gZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0XHRcdHJldHVybiAhISQuZGF0YSggZWxlbSwgZGF0YU5hbWUgKTtcblx0XHRcdH07XG5cdFx0fSApIDpcblxuXHRcdC8vIFN1cHBvcnQ6IGpRdWVyeSA8MS44XG5cdFx0ZnVuY3Rpb24oIGVsZW0sIGksIG1hdGNoICkge1xuXHRcdFx0cmV0dXJuICEhJC5kYXRhKCBlbGVtLCBtYXRjaFsgMyBdICk7XG5cdFx0fVxufSApO1xufSApICk7XG4iLCIoIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggWyBcImpxdWVyeVwiLCBcIi4vdmVyc2lvblwiIF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59ICggZnVuY3Rpb24oICQgKSB7XG5cbi8vIFRoaXMgZmlsZSBpcyBkZXByZWNhdGVkXG5yZXR1cm4gJC51aS5pZSA9ICEhL21zaWUgW1xcdy5dKy8uZXhlYyggbmF2aWdhdG9yLnVzZXJBZ2VudC50b0xvd2VyQ2FzZSgpICk7XG59ICkgKTtcbiIsIi8qIVxuICogalF1ZXJ5IFVJIFNjcm9sbCBQYXJlbnQgMS4xMi4xXG4gKiBodHRwOi8vanF1ZXJ5dWkuY29tXG4gKlxuICogQ29weXJpZ2h0IGpRdWVyeSBGb3VuZGF0aW9uIGFuZCBvdGhlciBjb250cmlidXRvcnNcbiAqIFJlbGVhc2VkIHVuZGVyIHRoZSBNSVQgbGljZW5zZS5cbiAqIGh0dHA6Ly9qcXVlcnkub3JnL2xpY2Vuc2VcbiAqL1xuXG4vLz4+bGFiZWw6IHNjcm9sbFBhcmVudFxuLy8+Pmdyb3VwOiBDb3JlXG4vLz4+ZGVzY3JpcHRpb246IEdldCB0aGUgY2xvc2VzdCBhbmNlc3RvciBlbGVtZW50IHRoYXQgaXMgc2Nyb2xsYWJsZS5cbi8vPj5kb2NzOiBodHRwOi8vYXBpLmpxdWVyeXVpLmNvbS9zY3JvbGxQYXJlbnQvXG5cbiggZnVuY3Rpb24oIGZhY3RvcnkgKSB7XG5cdGlmICggdHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQgKSB7XG5cblx0XHQvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG5cdFx0ZGVmaW5lKCBbIFwianF1ZXJ5XCIsIFwiLi92ZXJzaW9uXCIgXSwgZmFjdG9yeSApO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gQnJvd3NlciBnbG9iYWxzXG5cdFx0ZmFjdG9yeSggalF1ZXJ5ICk7XG5cdH1cbn0gKCBmdW5jdGlvbiggJCApIHtcblxucmV0dXJuICQuZm4uc2Nyb2xsUGFyZW50ID0gZnVuY3Rpb24oIGluY2x1ZGVIaWRkZW4gKSB7XG5cdHZhciBwb3NpdGlvbiA9IHRoaXMuY3NzKCBcInBvc2l0aW9uXCIgKSxcblx0XHRleGNsdWRlU3RhdGljUGFyZW50ID0gcG9zaXRpb24gPT09IFwiYWJzb2x1dGVcIixcblx0XHRvdmVyZmxvd1JlZ2V4ID0gaW5jbHVkZUhpZGRlbiA/IC8oYXV0b3xzY3JvbGx8aGlkZGVuKS8gOiAvKGF1dG98c2Nyb2xsKS8sXG5cdFx0c2Nyb2xsUGFyZW50ID0gdGhpcy5wYXJlbnRzKCkuZmlsdGVyKCBmdW5jdGlvbigpIHtcblx0XHRcdHZhciBwYXJlbnQgPSAkKCB0aGlzICk7XG5cdFx0XHRpZiAoIGV4Y2x1ZGVTdGF0aWNQYXJlbnQgJiYgcGFyZW50LmNzcyggXCJwb3NpdGlvblwiICkgPT09IFwic3RhdGljXCIgKSB7XG5cdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdH1cblx0XHRcdHJldHVybiBvdmVyZmxvd1JlZ2V4LnRlc3QoIHBhcmVudC5jc3MoIFwib3ZlcmZsb3dcIiApICsgcGFyZW50LmNzcyggXCJvdmVyZmxvdy15XCIgKSArXG5cdFx0XHRcdHBhcmVudC5jc3MoIFwib3ZlcmZsb3cteFwiICkgKTtcblx0XHR9ICkuZXEoIDAgKTtcblxuXHRyZXR1cm4gcG9zaXRpb24gPT09IFwiZml4ZWRcIiB8fCAhc2Nyb2xsUGFyZW50Lmxlbmd0aCA/XG5cdFx0JCggdGhpc1sgMCBdLm93bmVyRG9jdW1lbnQgfHwgZG9jdW1lbnQgKSA6XG5cdFx0c2Nyb2xsUGFyZW50O1xufTtcblxufSApICk7XG4iLCIoIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggWyBcImpxdWVyeVwiIF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59ICggZnVuY3Rpb24oICQgKSB7XG5cbiQudWkgPSAkLnVpIHx8IHt9O1xuXG5yZXR1cm4gJC51aS52ZXJzaW9uID0gXCIxLjEyLjFcIjtcblxufSApICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBXaWRnZXQgMS4xMi4xXG4gKiBodHRwOi8vanF1ZXJ5dWkuY29tXG4gKlxuICogQ29weXJpZ2h0IGpRdWVyeSBGb3VuZGF0aW9uIGFuZCBvdGhlciBjb250cmlidXRvcnNcbiAqIFJlbGVhc2VkIHVuZGVyIHRoZSBNSVQgbGljZW5zZS5cbiAqIGh0dHA6Ly9qcXVlcnkub3JnL2xpY2Vuc2VcbiAqL1xuXG4vLz4+bGFiZWw6IFdpZGdldFxuLy8+Pmdyb3VwOiBDb3JlXG4vLz4+ZGVzY3JpcHRpb246IFByb3ZpZGVzIGEgZmFjdG9yeSBmb3IgY3JlYXRpbmcgc3RhdGVmdWwgd2lkZ2V0cyB3aXRoIGEgY29tbW9uIEFQSS5cbi8vPj5kb2NzOiBodHRwOi8vYXBpLmpxdWVyeXVpLmNvbS9qUXVlcnkud2lkZ2V0L1xuLy8+PmRlbW9zOiBodHRwOi8vanF1ZXJ5dWkuY29tL3dpZGdldC9cblxuKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFsgXCJqcXVlcnlcIiwgXCIuL3ZlcnNpb25cIiBdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSggZnVuY3Rpb24oICQgKSB7XG5cbnZhciB3aWRnZXRVdWlkID0gMDtcbnZhciB3aWRnZXRTbGljZSA9IEFycmF5LnByb3RvdHlwZS5zbGljZTtcblxuJC5jbGVhbkRhdGEgPSAoIGZ1bmN0aW9uKCBvcmlnICkge1xuXHRyZXR1cm4gZnVuY3Rpb24oIGVsZW1zICkge1xuXHRcdHZhciBldmVudHMsIGVsZW0sIGk7XG5cdFx0Zm9yICggaSA9IDA7ICggZWxlbSA9IGVsZW1zWyBpIF0gKSAhPSBudWxsOyBpKysgKSB7XG5cdFx0XHR0cnkge1xuXG5cdFx0XHRcdC8vIE9ubHkgdHJpZ2dlciByZW1vdmUgd2hlbiBuZWNlc3NhcnkgdG8gc2F2ZSB0aW1lXG5cdFx0XHRcdGV2ZW50cyA9ICQuX2RhdGEoIGVsZW0sIFwiZXZlbnRzXCIgKTtcblx0XHRcdFx0aWYgKCBldmVudHMgJiYgZXZlbnRzLnJlbW92ZSApIHtcblx0XHRcdFx0XHQkKCBlbGVtICkudHJpZ2dlckhhbmRsZXIoIFwicmVtb3ZlXCIgKTtcblx0XHRcdFx0fVxuXG5cdFx0XHQvLyBIdHRwOi8vYnVncy5qcXVlcnkuY29tL3RpY2tldC84MjM1XG5cdFx0XHR9IGNhdGNoICggZSApIHt9XG5cdFx0fVxuXHRcdG9yaWcoIGVsZW1zICk7XG5cdH07XG59ICkoICQuY2xlYW5EYXRhICk7XG5cbiQud2lkZ2V0ID0gZnVuY3Rpb24oIG5hbWUsIGJhc2UsIHByb3RvdHlwZSApIHtcblx0dmFyIGV4aXN0aW5nQ29uc3RydWN0b3IsIGNvbnN0cnVjdG9yLCBiYXNlUHJvdG90eXBlO1xuXG5cdC8vIFByb3hpZWRQcm90b3R5cGUgYWxsb3dzIHRoZSBwcm92aWRlZCBwcm90b3R5cGUgdG8gcmVtYWluIHVubW9kaWZpZWRcblx0Ly8gc28gdGhhdCBpdCBjYW4gYmUgdXNlZCBhcyBhIG1peGluIGZvciBtdWx0aXBsZSB3aWRnZXRzICgjODg3Nilcblx0dmFyIHByb3hpZWRQcm90b3R5cGUgPSB7fTtcblxuXHR2YXIgbmFtZXNwYWNlID0gbmFtZS5zcGxpdCggXCIuXCIgKVsgMCBdO1xuXHRuYW1lID0gbmFtZS5zcGxpdCggXCIuXCIgKVsgMSBdO1xuXHR2YXIgZnVsbE5hbWUgPSBuYW1lc3BhY2UgKyBcIi1cIiArIG5hbWU7XG5cblx0aWYgKCAhcHJvdG90eXBlICkge1xuXHRcdHByb3RvdHlwZSA9IGJhc2U7XG5cdFx0YmFzZSA9ICQuV2lkZ2V0O1xuXHR9XG5cblx0aWYgKCAkLmlzQXJyYXkoIHByb3RvdHlwZSApICkge1xuXHRcdHByb3RvdHlwZSA9ICQuZXh0ZW5kLmFwcGx5KCBudWxsLCBbIHt9IF0uY29uY2F0KCBwcm90b3R5cGUgKSApO1xuXHR9XG5cblx0Ly8gQ3JlYXRlIHNlbGVjdG9yIGZvciBwbHVnaW5cblx0JC5leHByWyBcIjpcIiBdWyBmdWxsTmFtZS50b0xvd2VyQ2FzZSgpIF0gPSBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRyZXR1cm4gISEkLmRhdGEoIGVsZW0sIGZ1bGxOYW1lICk7XG5cdH07XG5cblx0JFsgbmFtZXNwYWNlIF0gPSAkWyBuYW1lc3BhY2UgXSB8fCB7fTtcblx0ZXhpc3RpbmdDb25zdHJ1Y3RvciA9ICRbIG5hbWVzcGFjZSBdWyBuYW1lIF07XG5cdGNvbnN0cnVjdG9yID0gJFsgbmFtZXNwYWNlIF1bIG5hbWUgXSA9IGZ1bmN0aW9uKCBvcHRpb25zLCBlbGVtZW50ICkge1xuXG5cdFx0Ly8gQWxsb3cgaW5zdGFudGlhdGlvbiB3aXRob3V0IFwibmV3XCIga2V5d29yZFxuXHRcdGlmICggIXRoaXMuX2NyZWF0ZVdpZGdldCApIHtcblx0XHRcdHJldHVybiBuZXcgY29uc3RydWN0b3IoIG9wdGlvbnMsIGVsZW1lbnQgKTtcblx0XHR9XG5cblx0XHQvLyBBbGxvdyBpbnN0YW50aWF0aW9uIHdpdGhvdXQgaW5pdGlhbGl6aW5nIGZvciBzaW1wbGUgaW5oZXJpdGFuY2Vcblx0XHQvLyBtdXN0IHVzZSBcIm5ld1wiIGtleXdvcmQgKHRoZSBjb2RlIGFib3ZlIGFsd2F5cyBwYXNzZXMgYXJncylcblx0XHRpZiAoIGFyZ3VtZW50cy5sZW5ndGggKSB7XG5cdFx0XHR0aGlzLl9jcmVhdGVXaWRnZXQoIG9wdGlvbnMsIGVsZW1lbnQgKTtcblx0XHR9XG5cdH07XG5cblx0Ly8gRXh0ZW5kIHdpdGggdGhlIGV4aXN0aW5nIGNvbnN0cnVjdG9yIHRvIGNhcnJ5IG92ZXIgYW55IHN0YXRpYyBwcm9wZXJ0aWVzXG5cdCQuZXh0ZW5kKCBjb25zdHJ1Y3RvciwgZXhpc3RpbmdDb25zdHJ1Y3Rvciwge1xuXHRcdHZlcnNpb246IHByb3RvdHlwZS52ZXJzaW9uLFxuXG5cdFx0Ly8gQ29weSB0aGUgb2JqZWN0IHVzZWQgdG8gY3JlYXRlIHRoZSBwcm90b3R5cGUgaW4gY2FzZSB3ZSBuZWVkIHRvXG5cdFx0Ly8gcmVkZWZpbmUgdGhlIHdpZGdldCBsYXRlclxuXHRcdF9wcm90bzogJC5leHRlbmQoIHt9LCBwcm90b3R5cGUgKSxcblxuXHRcdC8vIFRyYWNrIHdpZGdldHMgdGhhdCBpbmhlcml0IGZyb20gdGhpcyB3aWRnZXQgaW4gY2FzZSB0aGlzIHdpZGdldCBpc1xuXHRcdC8vIHJlZGVmaW5lZCBhZnRlciBhIHdpZGdldCBpbmhlcml0cyBmcm9tIGl0XG5cdFx0X2NoaWxkQ29uc3RydWN0b3JzOiBbXVxuXHR9ICk7XG5cblx0YmFzZVByb3RvdHlwZSA9IG5ldyBiYXNlKCk7XG5cblx0Ly8gV2UgbmVlZCB0byBtYWtlIHRoZSBvcHRpb25zIGhhc2ggYSBwcm9wZXJ0eSBkaXJlY3RseSBvbiB0aGUgbmV3IGluc3RhbmNlXG5cdC8vIG90aGVyd2lzZSB3ZSdsbCBtb2RpZnkgdGhlIG9wdGlvbnMgaGFzaCBvbiB0aGUgcHJvdG90eXBlIHRoYXQgd2UncmVcblx0Ly8gaW5oZXJpdGluZyBmcm9tXG5cdGJhc2VQcm90b3R5cGUub3B0aW9ucyA9ICQud2lkZ2V0LmV4dGVuZCgge30sIGJhc2VQcm90b3R5cGUub3B0aW9ucyApO1xuXHQkLmVhY2goIHByb3RvdHlwZSwgZnVuY3Rpb24oIHByb3AsIHZhbHVlICkge1xuXHRcdGlmICggISQuaXNGdW5jdGlvbiggdmFsdWUgKSApIHtcblx0XHRcdHByb3hpZWRQcm90b3R5cGVbIHByb3AgXSA9IHZhbHVlO1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblx0XHRwcm94aWVkUHJvdG90eXBlWyBwcm9wIF0gPSAoIGZ1bmN0aW9uKCkge1xuXHRcdFx0ZnVuY3Rpb24gX3N1cGVyKCkge1xuXHRcdFx0XHRyZXR1cm4gYmFzZS5wcm90b3R5cGVbIHByb3AgXS5hcHBseSggdGhpcywgYXJndW1lbnRzICk7XG5cdFx0XHR9XG5cblx0XHRcdGZ1bmN0aW9uIF9zdXBlckFwcGx5KCBhcmdzICkge1xuXHRcdFx0XHRyZXR1cm4gYmFzZS5wcm90b3R5cGVbIHByb3AgXS5hcHBseSggdGhpcywgYXJncyApO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHZhciBfX3N1cGVyID0gdGhpcy5fc3VwZXI7XG5cdFx0XHRcdHZhciBfX3N1cGVyQXBwbHkgPSB0aGlzLl9zdXBlckFwcGx5O1xuXHRcdFx0XHR2YXIgcmV0dXJuVmFsdWU7XG5cblx0XHRcdFx0dGhpcy5fc3VwZXIgPSBfc3VwZXI7XG5cdFx0XHRcdHRoaXMuX3N1cGVyQXBwbHkgPSBfc3VwZXJBcHBseTtcblxuXHRcdFx0XHRyZXR1cm5WYWx1ZSA9IHZhbHVlLmFwcGx5KCB0aGlzLCBhcmd1bWVudHMgKTtcblxuXHRcdFx0XHR0aGlzLl9zdXBlciA9IF9fc3VwZXI7XG5cdFx0XHRcdHRoaXMuX3N1cGVyQXBwbHkgPSBfX3N1cGVyQXBwbHk7XG5cblx0XHRcdFx0cmV0dXJuIHJldHVyblZhbHVlO1xuXHRcdFx0fTtcblx0XHR9ICkoKTtcblx0fSApO1xuXHRjb25zdHJ1Y3Rvci5wcm90b3R5cGUgPSAkLndpZGdldC5leHRlbmQoIGJhc2VQcm90b3R5cGUsIHtcblxuXHRcdC8vIFRPRE86IHJlbW92ZSBzdXBwb3J0IGZvciB3aWRnZXRFdmVudFByZWZpeFxuXHRcdC8vIGFsd2F5cyB1c2UgdGhlIG5hbWUgKyBhIGNvbG9uIGFzIHRoZSBwcmVmaXgsIGUuZy4sIGRyYWdnYWJsZTpzdGFydFxuXHRcdC8vIGRvbid0IHByZWZpeCBmb3Igd2lkZ2V0cyB0aGF0IGFyZW4ndCBET00tYmFzZWRcblx0XHR3aWRnZXRFdmVudFByZWZpeDogZXhpc3RpbmdDb25zdHJ1Y3RvciA/ICggYmFzZVByb3RvdHlwZS53aWRnZXRFdmVudFByZWZpeCB8fCBuYW1lICkgOiBuYW1lXG5cdH0sIHByb3hpZWRQcm90b3R5cGUsIHtcblx0XHRjb25zdHJ1Y3RvcjogY29uc3RydWN0b3IsXG5cdFx0bmFtZXNwYWNlOiBuYW1lc3BhY2UsXG5cdFx0d2lkZ2V0TmFtZTogbmFtZSxcblx0XHR3aWRnZXRGdWxsTmFtZTogZnVsbE5hbWVcblx0fSApO1xuXG5cdC8vIElmIHRoaXMgd2lkZ2V0IGlzIGJlaW5nIHJlZGVmaW5lZCB0aGVuIHdlIG5lZWQgdG8gZmluZCBhbGwgd2lkZ2V0cyB0aGF0XG5cdC8vIGFyZSBpbmhlcml0aW5nIGZyb20gaXQgYW5kIHJlZGVmaW5lIGFsbCBvZiB0aGVtIHNvIHRoYXQgdGhleSBpbmhlcml0IGZyb21cblx0Ly8gdGhlIG5ldyB2ZXJzaW9uIG9mIHRoaXMgd2lkZ2V0LiBXZSdyZSBlc3NlbnRpYWxseSB0cnlpbmcgdG8gcmVwbGFjZSBvbmVcblx0Ly8gbGV2ZWwgaW4gdGhlIHByb3RvdHlwZSBjaGFpbi5cblx0aWYgKCBleGlzdGluZ0NvbnN0cnVjdG9yICkge1xuXHRcdCQuZWFjaCggZXhpc3RpbmdDb25zdHJ1Y3Rvci5fY2hpbGRDb25zdHJ1Y3RvcnMsIGZ1bmN0aW9uKCBpLCBjaGlsZCApIHtcblx0XHRcdHZhciBjaGlsZFByb3RvdHlwZSA9IGNoaWxkLnByb3RvdHlwZTtcblxuXHRcdFx0Ly8gUmVkZWZpbmUgdGhlIGNoaWxkIHdpZGdldCB1c2luZyB0aGUgc2FtZSBwcm90b3R5cGUgdGhhdCB3YXNcblx0XHRcdC8vIG9yaWdpbmFsbHkgdXNlZCwgYnV0IGluaGVyaXQgZnJvbSB0aGUgbmV3IHZlcnNpb24gb2YgdGhlIGJhc2Vcblx0XHRcdCQud2lkZ2V0KCBjaGlsZFByb3RvdHlwZS5uYW1lc3BhY2UgKyBcIi5cIiArIGNoaWxkUHJvdG90eXBlLndpZGdldE5hbWUsIGNvbnN0cnVjdG9yLFxuXHRcdFx0XHRjaGlsZC5fcHJvdG8gKTtcblx0XHR9ICk7XG5cblx0XHQvLyBSZW1vdmUgdGhlIGxpc3Qgb2YgZXhpc3RpbmcgY2hpbGQgY29uc3RydWN0b3JzIGZyb20gdGhlIG9sZCBjb25zdHJ1Y3RvclxuXHRcdC8vIHNvIHRoZSBvbGQgY2hpbGQgY29uc3RydWN0b3JzIGNhbiBiZSBnYXJiYWdlIGNvbGxlY3RlZFxuXHRcdGRlbGV0ZSBleGlzdGluZ0NvbnN0cnVjdG9yLl9jaGlsZENvbnN0cnVjdG9ycztcblx0fSBlbHNlIHtcblx0XHRiYXNlLl9jaGlsZENvbnN0cnVjdG9ycy5wdXNoKCBjb25zdHJ1Y3RvciApO1xuXHR9XG5cblx0JC53aWRnZXQuYnJpZGdlKCBuYW1lLCBjb25zdHJ1Y3RvciApO1xuXG5cdHJldHVybiBjb25zdHJ1Y3Rvcjtcbn07XG5cbiQud2lkZ2V0LmV4dGVuZCA9IGZ1bmN0aW9uKCB0YXJnZXQgKSB7XG5cdHZhciBpbnB1dCA9IHdpZGdldFNsaWNlLmNhbGwoIGFyZ3VtZW50cywgMSApO1xuXHR2YXIgaW5wdXRJbmRleCA9IDA7XG5cdHZhciBpbnB1dExlbmd0aCA9IGlucHV0Lmxlbmd0aDtcblx0dmFyIGtleTtcblx0dmFyIHZhbHVlO1xuXG5cdGZvciAoIDsgaW5wdXRJbmRleCA8IGlucHV0TGVuZ3RoOyBpbnB1dEluZGV4KysgKSB7XG5cdFx0Zm9yICgga2V5IGluIGlucHV0WyBpbnB1dEluZGV4IF0gKSB7XG5cdFx0XHR2YWx1ZSA9IGlucHV0WyBpbnB1dEluZGV4IF1bIGtleSBdO1xuXHRcdFx0aWYgKCBpbnB1dFsgaW5wdXRJbmRleCBdLmhhc093blByb3BlcnR5KCBrZXkgKSAmJiB2YWx1ZSAhPT0gdW5kZWZpbmVkICkge1xuXG5cdFx0XHRcdC8vIENsb25lIG9iamVjdHNcblx0XHRcdFx0aWYgKCAkLmlzUGxhaW5PYmplY3QoIHZhbHVlICkgKSB7XG5cdFx0XHRcdFx0dGFyZ2V0WyBrZXkgXSA9ICQuaXNQbGFpbk9iamVjdCggdGFyZ2V0WyBrZXkgXSApID9cblx0XHRcdFx0XHRcdCQud2lkZ2V0LmV4dGVuZCgge30sIHRhcmdldFsga2V5IF0sIHZhbHVlICkgOlxuXG5cdFx0XHRcdFx0XHQvLyBEb24ndCBleHRlbmQgc3RyaW5ncywgYXJyYXlzLCBldGMuIHdpdGggb2JqZWN0c1xuXHRcdFx0XHRcdFx0JC53aWRnZXQuZXh0ZW5kKCB7fSwgdmFsdWUgKTtcblxuXHRcdFx0XHQvLyBDb3B5IGV2ZXJ5dGhpbmcgZWxzZSBieSByZWZlcmVuY2Vcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHR0YXJnZXRbIGtleSBdID0gdmFsdWU7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cdH1cblx0cmV0dXJuIHRhcmdldDtcbn07XG5cbiQud2lkZ2V0LmJyaWRnZSA9IGZ1bmN0aW9uKCBuYW1lLCBvYmplY3QgKSB7XG5cdHZhciBmdWxsTmFtZSA9IG9iamVjdC5wcm90b3R5cGUud2lkZ2V0RnVsbE5hbWUgfHwgbmFtZTtcblx0JC5mblsgbmFtZSBdID0gZnVuY3Rpb24oIG9wdGlvbnMgKSB7XG5cdFx0dmFyIGlzTWV0aG9kQ2FsbCA9IHR5cGVvZiBvcHRpb25zID09PSBcInN0cmluZ1wiO1xuXHRcdHZhciBhcmdzID0gd2lkZ2V0U2xpY2UuY2FsbCggYXJndW1lbnRzLCAxICk7XG5cdFx0dmFyIHJldHVyblZhbHVlID0gdGhpcztcblxuXHRcdGlmICggaXNNZXRob2RDYWxsICkge1xuXG5cdFx0XHQvLyBJZiB0aGlzIGlzIGFuIGVtcHR5IGNvbGxlY3Rpb24sIHdlIG5lZWQgdG8gaGF2ZSB0aGUgaW5zdGFuY2UgbWV0aG9kXG5cdFx0XHQvLyByZXR1cm4gdW5kZWZpbmVkIGluc3RlYWQgb2YgdGhlIGpRdWVyeSBpbnN0YW5jZVxuXHRcdFx0aWYgKCAhdGhpcy5sZW5ndGggJiYgb3B0aW9ucyA9PT0gXCJpbnN0YW5jZVwiICkge1xuXHRcdFx0XHRyZXR1cm5WYWx1ZSA9IHVuZGVmaW5lZDtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdHRoaXMuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0dmFyIG1ldGhvZFZhbHVlO1xuXHRcdFx0XHRcdHZhciBpbnN0YW5jZSA9ICQuZGF0YSggdGhpcywgZnVsbE5hbWUgKTtcblxuXHRcdFx0XHRcdGlmICggb3B0aW9ucyA9PT0gXCJpbnN0YW5jZVwiICkge1xuXHRcdFx0XHRcdFx0cmV0dXJuVmFsdWUgPSBpbnN0YW5jZTtcblx0XHRcdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRpZiAoICFpbnN0YW5jZSApIHtcblx0XHRcdFx0XHRcdHJldHVybiAkLmVycm9yKCBcImNhbm5vdCBjYWxsIG1ldGhvZHMgb24gXCIgKyBuYW1lICtcblx0XHRcdFx0XHRcdFx0XCIgcHJpb3IgdG8gaW5pdGlhbGl6YXRpb247IFwiICtcblx0XHRcdFx0XHRcdFx0XCJhdHRlbXB0ZWQgdG8gY2FsbCBtZXRob2QgJ1wiICsgb3B0aW9ucyArIFwiJ1wiICk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0aWYgKCAhJC5pc0Z1bmN0aW9uKCBpbnN0YW5jZVsgb3B0aW9ucyBdICkgfHwgb3B0aW9ucy5jaGFyQXQoIDAgKSA9PT0gXCJfXCIgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm4gJC5lcnJvciggXCJubyBzdWNoIG1ldGhvZCAnXCIgKyBvcHRpb25zICsgXCInIGZvciBcIiArIG5hbWUgK1xuXHRcdFx0XHRcdFx0XHRcIiB3aWRnZXQgaW5zdGFuY2VcIiApO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdG1ldGhvZFZhbHVlID0gaW5zdGFuY2VbIG9wdGlvbnMgXS5hcHBseSggaW5zdGFuY2UsIGFyZ3MgKTtcblxuXHRcdFx0XHRcdGlmICggbWV0aG9kVmFsdWUgIT09IGluc3RhbmNlICYmIG1ldGhvZFZhbHVlICE9PSB1bmRlZmluZWQgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm5WYWx1ZSA9IG1ldGhvZFZhbHVlICYmIG1ldGhvZFZhbHVlLmpxdWVyeSA/XG5cdFx0XHRcdFx0XHRcdHJldHVyblZhbHVlLnB1c2hTdGFjayggbWV0aG9kVmFsdWUuZ2V0KCkgKSA6XG5cdFx0XHRcdFx0XHRcdG1ldGhvZFZhbHVlO1xuXHRcdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSApO1xuXHRcdFx0fVxuXHRcdH0gZWxzZSB7XG5cblx0XHRcdC8vIEFsbG93IG11bHRpcGxlIGhhc2hlcyB0byBiZSBwYXNzZWQgb24gaW5pdFxuXHRcdFx0aWYgKCBhcmdzLmxlbmd0aCApIHtcblx0XHRcdFx0b3B0aW9ucyA9ICQud2lkZ2V0LmV4dGVuZC5hcHBseSggbnVsbCwgWyBvcHRpb25zIF0uY29uY2F0KCBhcmdzICkgKTtcblx0XHRcdH1cblxuXHRcdFx0dGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdFx0dmFyIGluc3RhbmNlID0gJC5kYXRhKCB0aGlzLCBmdWxsTmFtZSApO1xuXHRcdFx0XHRpZiAoIGluc3RhbmNlICkge1xuXHRcdFx0XHRcdGluc3RhbmNlLm9wdGlvbiggb3B0aW9ucyB8fCB7fSApO1xuXHRcdFx0XHRcdGlmICggaW5zdGFuY2UuX2luaXQgKSB7XG5cdFx0XHRcdFx0XHRpbnN0YW5jZS5faW5pdCgpO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHQkLmRhdGEoIHRoaXMsIGZ1bGxOYW1lLCBuZXcgb2JqZWN0KCBvcHRpb25zLCB0aGlzICkgKTtcblx0XHRcdFx0fVxuXHRcdFx0fSApO1xuXHRcdH1cblxuXHRcdHJldHVybiByZXR1cm5WYWx1ZTtcblx0fTtcbn07XG5cbiQuV2lkZ2V0ID0gZnVuY3Rpb24oIC8qIG9wdGlvbnMsIGVsZW1lbnQgKi8gKSB7fTtcbiQuV2lkZ2V0Ll9jaGlsZENvbnN0cnVjdG9ycyA9IFtdO1xuXG4kLldpZGdldC5wcm90b3R5cGUgPSB7XG5cdHdpZGdldE5hbWU6IFwid2lkZ2V0XCIsXG5cdHdpZGdldEV2ZW50UHJlZml4OiBcIlwiLFxuXHRkZWZhdWx0RWxlbWVudDogXCI8ZGl2PlwiLFxuXG5cdG9wdGlvbnM6IHtcblx0XHRjbGFzc2VzOiB7fSxcblx0XHRkaXNhYmxlZDogZmFsc2UsXG5cblx0XHQvLyBDYWxsYmFja3Ncblx0XHRjcmVhdGU6IG51bGxcblx0fSxcblxuXHRfY3JlYXRlV2lkZ2V0OiBmdW5jdGlvbiggb3B0aW9ucywgZWxlbWVudCApIHtcblx0XHRlbGVtZW50ID0gJCggZWxlbWVudCB8fCB0aGlzLmRlZmF1bHRFbGVtZW50IHx8IHRoaXMgKVsgMCBdO1xuXHRcdHRoaXMuZWxlbWVudCA9ICQoIGVsZW1lbnQgKTtcblx0XHR0aGlzLnV1aWQgPSB3aWRnZXRVdWlkKys7XG5cdFx0dGhpcy5ldmVudE5hbWVzcGFjZSA9IFwiLlwiICsgdGhpcy53aWRnZXROYW1lICsgdGhpcy51dWlkO1xuXG5cdFx0dGhpcy5iaW5kaW5ncyA9ICQoKTtcblx0XHR0aGlzLmhvdmVyYWJsZSA9ICQoKTtcblx0XHR0aGlzLmZvY3VzYWJsZSA9ICQoKTtcblx0XHR0aGlzLmNsYXNzZXNFbGVtZW50TG9va3VwID0ge307XG5cblx0XHRpZiAoIGVsZW1lbnQgIT09IHRoaXMgKSB7XG5cdFx0XHQkLmRhdGEoIGVsZW1lbnQsIHRoaXMud2lkZ2V0RnVsbE5hbWUsIHRoaXMgKTtcblx0XHRcdHRoaXMuX29uKCB0cnVlLCB0aGlzLmVsZW1lbnQsIHtcblx0XHRcdFx0cmVtb3ZlOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdFx0aWYgKCBldmVudC50YXJnZXQgPT09IGVsZW1lbnQgKSB7XG5cdFx0XHRcdFx0XHR0aGlzLmRlc3Ryb3koKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH0gKTtcblx0XHRcdHRoaXMuZG9jdW1lbnQgPSAkKCBlbGVtZW50LnN0eWxlID9cblxuXHRcdFx0XHQvLyBFbGVtZW50IHdpdGhpbiB0aGUgZG9jdW1lbnRcblx0XHRcdFx0ZWxlbWVudC5vd25lckRvY3VtZW50IDpcblxuXHRcdFx0XHQvLyBFbGVtZW50IGlzIHdpbmRvdyBvciBkb2N1bWVudFxuXHRcdFx0XHRlbGVtZW50LmRvY3VtZW50IHx8IGVsZW1lbnQgKTtcblx0XHRcdHRoaXMud2luZG93ID0gJCggdGhpcy5kb2N1bWVudFsgMCBdLmRlZmF1bHRWaWV3IHx8IHRoaXMuZG9jdW1lbnRbIDAgXS5wYXJlbnRXaW5kb3cgKTtcblx0XHR9XG5cblx0XHR0aGlzLm9wdGlvbnMgPSAkLndpZGdldC5leHRlbmQoIHt9LFxuXHRcdFx0dGhpcy5vcHRpb25zLFxuXHRcdFx0dGhpcy5fZ2V0Q3JlYXRlT3B0aW9ucygpLFxuXHRcdFx0b3B0aW9ucyApO1xuXG5cdFx0dGhpcy5fY3JlYXRlKCk7XG5cblx0XHRpZiAoIHRoaXMub3B0aW9ucy5kaXNhYmxlZCApIHtcblx0XHRcdHRoaXMuX3NldE9wdGlvbkRpc2FibGVkKCB0aGlzLm9wdGlvbnMuZGlzYWJsZWQgKTtcblx0XHR9XG5cblx0XHR0aGlzLl90cmlnZ2VyKCBcImNyZWF0ZVwiLCBudWxsLCB0aGlzLl9nZXRDcmVhdGVFdmVudERhdGEoKSApO1xuXHRcdHRoaXMuX2luaXQoKTtcblx0fSxcblxuXHRfZ2V0Q3JlYXRlT3B0aW9uczogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHt9O1xuXHR9LFxuXG5cdF9nZXRDcmVhdGVFdmVudERhdGE6ICQubm9vcCxcblxuXHRfY3JlYXRlOiAkLm5vb3AsXG5cblx0X2luaXQ6ICQubm9vcCxcblxuXHRkZXN0cm95OiBmdW5jdGlvbigpIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0XHR0aGlzLl9kZXN0cm95KCk7XG5cdFx0JC5lYWNoKCB0aGlzLmNsYXNzZXNFbGVtZW50TG9va3VwLCBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRcdHRoYXQuX3JlbW92ZUNsYXNzKCB2YWx1ZSwga2V5ICk7XG5cdFx0fSApO1xuXG5cdFx0Ly8gV2UgY2FuIHByb2JhYmx5IHJlbW92ZSB0aGUgdW5iaW5kIGNhbGxzIGluIDIuMFxuXHRcdC8vIGFsbCBldmVudCBiaW5kaW5ncyBzaG91bGQgZ28gdGhyb3VnaCB0aGlzLl9vbigpXG5cdFx0dGhpcy5lbGVtZW50XG5cdFx0XHQub2ZmKCB0aGlzLmV2ZW50TmFtZXNwYWNlIClcblx0XHRcdC5yZW1vdmVEYXRhKCB0aGlzLndpZGdldEZ1bGxOYW1lICk7XG5cdFx0dGhpcy53aWRnZXQoKVxuXHRcdFx0Lm9mZiggdGhpcy5ldmVudE5hbWVzcGFjZSApXG5cdFx0XHQucmVtb3ZlQXR0ciggXCJhcmlhLWRpc2FibGVkXCIgKTtcblxuXHRcdC8vIENsZWFuIHVwIGV2ZW50cyBhbmQgc3RhdGVzXG5cdFx0dGhpcy5iaW5kaW5ncy5vZmYoIHRoaXMuZXZlbnROYW1lc3BhY2UgKTtcblx0fSxcblxuXHRfZGVzdHJveTogJC5ub29wLFxuXG5cdHdpZGdldDogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMuZWxlbWVudDtcblx0fSxcblxuXHRvcHRpb246IGZ1bmN0aW9uKCBrZXksIHZhbHVlICkge1xuXHRcdHZhciBvcHRpb25zID0ga2V5O1xuXHRcdHZhciBwYXJ0cztcblx0XHR2YXIgY3VyT3B0aW9uO1xuXHRcdHZhciBpO1xuXG5cdFx0aWYgKCBhcmd1bWVudHMubGVuZ3RoID09PSAwICkge1xuXG5cdFx0XHQvLyBEb24ndCByZXR1cm4gYSByZWZlcmVuY2UgdG8gdGhlIGludGVybmFsIGhhc2hcblx0XHRcdHJldHVybiAkLndpZGdldC5leHRlbmQoIHt9LCB0aGlzLm9wdGlvbnMgKTtcblx0XHR9XG5cblx0XHRpZiAoIHR5cGVvZiBrZXkgPT09IFwic3RyaW5nXCIgKSB7XG5cblx0XHRcdC8vIEhhbmRsZSBuZXN0ZWQga2V5cywgZS5nLiwgXCJmb28uYmFyXCIgPT4geyBmb286IHsgYmFyOiBfX18gfSB9XG5cdFx0XHRvcHRpb25zID0ge307XG5cdFx0XHRwYXJ0cyA9IGtleS5zcGxpdCggXCIuXCIgKTtcblx0XHRcdGtleSA9IHBhcnRzLnNoaWZ0KCk7XG5cdFx0XHRpZiAoIHBhcnRzLmxlbmd0aCApIHtcblx0XHRcdFx0Y3VyT3B0aW9uID0gb3B0aW9uc1sga2V5IF0gPSAkLndpZGdldC5leHRlbmQoIHt9LCB0aGlzLm9wdGlvbnNbIGtleSBdICk7XG5cdFx0XHRcdGZvciAoIGkgPSAwOyBpIDwgcGFydHMubGVuZ3RoIC0gMTsgaSsrICkge1xuXHRcdFx0XHRcdGN1ck9wdGlvblsgcGFydHNbIGkgXSBdID0gY3VyT3B0aW9uWyBwYXJ0c1sgaSBdIF0gfHwge307XG5cdFx0XHRcdFx0Y3VyT3B0aW9uID0gY3VyT3B0aW9uWyBwYXJ0c1sgaSBdIF07XG5cdFx0XHRcdH1cblx0XHRcdFx0a2V5ID0gcGFydHMucG9wKCk7XG5cdFx0XHRcdGlmICggYXJndW1lbnRzLmxlbmd0aCA9PT0gMSApIHtcblx0XHRcdFx0XHRyZXR1cm4gY3VyT3B0aW9uWyBrZXkgXSA9PT0gdW5kZWZpbmVkID8gbnVsbCA6IGN1ck9wdGlvblsga2V5IF07XG5cdFx0XHRcdH1cblx0XHRcdFx0Y3VyT3B0aW9uWyBrZXkgXSA9IHZhbHVlO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0aWYgKCBhcmd1bWVudHMubGVuZ3RoID09PSAxICkge1xuXHRcdFx0XHRcdHJldHVybiB0aGlzLm9wdGlvbnNbIGtleSBdID09PSB1bmRlZmluZWQgPyBudWxsIDogdGhpcy5vcHRpb25zWyBrZXkgXTtcblx0XHRcdFx0fVxuXHRcdFx0XHRvcHRpb25zWyBrZXkgXSA9IHZhbHVlO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHRoaXMuX3NldE9wdGlvbnMoIG9wdGlvbnMgKTtcblxuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdF9zZXRPcHRpb25zOiBmdW5jdGlvbiggb3B0aW9ucyApIHtcblx0XHR2YXIga2V5O1xuXG5cdFx0Zm9yICgga2V5IGluIG9wdGlvbnMgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb24oIGtleSwgb3B0aW9uc1sga2V5IF0gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfc2V0T3B0aW9uOiBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRpZiAoIGtleSA9PT0gXCJjbGFzc2VzXCIgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb25DbGFzc2VzKCB2YWx1ZSApO1xuXHRcdH1cblxuXHRcdHRoaXMub3B0aW9uc1sga2V5IF0gPSB2YWx1ZTtcblxuXHRcdGlmICgga2V5ID09PSBcImRpc2FibGVkXCIgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb25EaXNhYmxlZCggdmFsdWUgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfc2V0T3B0aW9uQ2xhc3NlczogZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdHZhciBjbGFzc0tleSwgZWxlbWVudHMsIGN1cnJlbnRFbGVtZW50cztcblxuXHRcdGZvciAoIGNsYXNzS2V5IGluIHZhbHVlICkge1xuXHRcdFx0Y3VycmVudEVsZW1lbnRzID0gdGhpcy5jbGFzc2VzRWxlbWVudExvb2t1cFsgY2xhc3NLZXkgXTtcblx0XHRcdGlmICggdmFsdWVbIGNsYXNzS2V5IF0gPT09IHRoaXMub3B0aW9ucy5jbGFzc2VzWyBjbGFzc0tleSBdIHx8XG5cdFx0XHRcdFx0IWN1cnJlbnRFbGVtZW50cyB8fFxuXHRcdFx0XHRcdCFjdXJyZW50RWxlbWVudHMubGVuZ3RoICkge1xuXHRcdFx0XHRjb250aW51ZTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gV2UgYXJlIGRvaW5nIHRoaXMgdG8gY3JlYXRlIGEgbmV3IGpRdWVyeSBvYmplY3QgYmVjYXVzZSB0aGUgX3JlbW92ZUNsYXNzKCkgY2FsbFxuXHRcdFx0Ly8gb24gdGhlIG5leHQgbGluZSBpcyBnb2luZyB0byBkZXN0cm95IHRoZSByZWZlcmVuY2UgdG8gdGhlIGN1cnJlbnQgZWxlbWVudHMgYmVpbmdcblx0XHRcdC8vIHRyYWNrZWQuIFdlIG5lZWQgdG8gc2F2ZSBhIGNvcHkgb2YgdGhpcyBjb2xsZWN0aW9uIHNvIHRoYXQgd2UgY2FuIGFkZCB0aGUgbmV3IGNsYXNzZXNcblx0XHRcdC8vIGJlbG93LlxuXHRcdFx0ZWxlbWVudHMgPSAkKCBjdXJyZW50RWxlbWVudHMuZ2V0KCkgKTtcblx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCBjdXJyZW50RWxlbWVudHMsIGNsYXNzS2V5ICk7XG5cblx0XHRcdC8vIFdlIGRvbid0IHVzZSBfYWRkQ2xhc3MoKSBoZXJlLCBiZWNhdXNlIHRoYXQgdXNlcyB0aGlzLm9wdGlvbnMuY2xhc3Nlc1xuXHRcdFx0Ly8gZm9yIGdlbmVyYXRpbmcgdGhlIHN0cmluZyBvZiBjbGFzc2VzLiBXZSB3YW50IHRvIHVzZSB0aGUgdmFsdWUgcGFzc2VkIGluIGZyb21cblx0XHRcdC8vIF9zZXRPcHRpb24oKSwgdGhpcyBpcyB0aGUgbmV3IHZhbHVlIG9mIHRoZSBjbGFzc2VzIG9wdGlvbiB3aGljaCB3YXMgcGFzc2VkIHRvXG5cdFx0XHQvLyBfc2V0T3B0aW9uKCkuIFdlIHBhc3MgdGhpcyB2YWx1ZSBkaXJlY3RseSB0byBfY2xhc3NlcygpLlxuXHRcdFx0ZWxlbWVudHMuYWRkQ2xhc3MoIHRoaXMuX2NsYXNzZXMoIHtcblx0XHRcdFx0ZWxlbWVudDogZWxlbWVudHMsXG5cdFx0XHRcdGtleXM6IGNsYXNzS2V5LFxuXHRcdFx0XHRjbGFzc2VzOiB2YWx1ZSxcblx0XHRcdFx0YWRkOiB0cnVlXG5cdFx0XHR9ICkgKTtcblx0XHR9XG5cdH0sXG5cblx0X3NldE9wdGlvbkRpc2FibGVkOiBmdW5jdGlvbiggdmFsdWUgKSB7XG5cdFx0dGhpcy5fdG9nZ2xlQ2xhc3MoIHRoaXMud2lkZ2V0KCksIHRoaXMud2lkZ2V0RnVsbE5hbWUgKyBcIi1kaXNhYmxlZFwiLCBudWxsLCAhIXZhbHVlICk7XG5cblx0XHQvLyBJZiB0aGUgd2lkZ2V0IGlzIGJlY29taW5nIGRpc2FibGVkLCB0aGVuIG5vdGhpbmcgaXMgaW50ZXJhY3RpdmVcblx0XHRpZiAoIHZhbHVlICkge1xuXHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoIHRoaXMuaG92ZXJhYmxlLCBudWxsLCBcInVpLXN0YXRlLWhvdmVyXCIgKTtcblx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCB0aGlzLmZvY3VzYWJsZSwgbnVsbCwgXCJ1aS1zdGF0ZS1mb2N1c1wiICk7XG5cdFx0fVxuXHR9LFxuXG5cdGVuYWJsZTogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMuX3NldE9wdGlvbnMoIHsgZGlzYWJsZWQ6IGZhbHNlIH0gKTtcblx0fSxcblxuXHRkaXNhYmxlOiBmdW5jdGlvbigpIHtcblx0XHRyZXR1cm4gdGhpcy5fc2V0T3B0aW9ucyggeyBkaXNhYmxlZDogdHJ1ZSB9ICk7XG5cdH0sXG5cblx0X2NsYXNzZXM6IGZ1bmN0aW9uKCBvcHRpb25zICkge1xuXHRcdHZhciBmdWxsID0gW107XG5cdFx0dmFyIHRoYXQgPSB0aGlzO1xuXG5cdFx0b3B0aW9ucyA9ICQuZXh0ZW5kKCB7XG5cdFx0XHRlbGVtZW50OiB0aGlzLmVsZW1lbnQsXG5cdFx0XHRjbGFzc2VzOiB0aGlzLm9wdGlvbnMuY2xhc3NlcyB8fCB7fVxuXHRcdH0sIG9wdGlvbnMgKTtcblxuXHRcdGZ1bmN0aW9uIHByb2Nlc3NDbGFzc1N0cmluZyggY2xhc3NlcywgY2hlY2tPcHRpb24gKSB7XG5cdFx0XHR2YXIgY3VycmVudCwgaTtcblx0XHRcdGZvciAoIGkgPSAwOyBpIDwgY2xhc3Nlcy5sZW5ndGg7IGkrKyApIHtcblx0XHRcdFx0Y3VycmVudCA9IHRoYXQuY2xhc3Nlc0VsZW1lbnRMb29rdXBbIGNsYXNzZXNbIGkgXSBdIHx8ICQoKTtcblx0XHRcdFx0aWYgKCBvcHRpb25zLmFkZCApIHtcblx0XHRcdFx0XHRjdXJyZW50ID0gJCggJC51bmlxdWUoIGN1cnJlbnQuZ2V0KCkuY29uY2F0KCBvcHRpb25zLmVsZW1lbnQuZ2V0KCkgKSApICk7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0Y3VycmVudCA9ICQoIGN1cnJlbnQubm90KCBvcHRpb25zLmVsZW1lbnQgKS5nZXQoKSApO1xuXHRcdFx0XHR9XG5cdFx0XHRcdHRoYXQuY2xhc3Nlc0VsZW1lbnRMb29rdXBbIGNsYXNzZXNbIGkgXSBdID0gY3VycmVudDtcblx0XHRcdFx0ZnVsbC5wdXNoKCBjbGFzc2VzWyBpIF0gKTtcblx0XHRcdFx0aWYgKCBjaGVja09wdGlvbiAmJiBvcHRpb25zLmNsYXNzZXNbIGNsYXNzZXNbIGkgXSBdICkge1xuXHRcdFx0XHRcdGZ1bGwucHVzaCggb3B0aW9ucy5jbGFzc2VzWyBjbGFzc2VzWyBpIF0gXSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0dGhpcy5fb24oIG9wdGlvbnMuZWxlbWVudCwge1xuXHRcdFx0XCJyZW1vdmVcIjogXCJfdW50cmFja0NsYXNzZXNFbGVtZW50XCJcblx0XHR9ICk7XG5cblx0XHRpZiAoIG9wdGlvbnMua2V5cyApIHtcblx0XHRcdHByb2Nlc3NDbGFzc1N0cmluZyggb3B0aW9ucy5rZXlzLm1hdGNoKCAvXFxTKy9nICkgfHwgW10sIHRydWUgKTtcblx0XHR9XG5cdFx0aWYgKCBvcHRpb25zLmV4dHJhICkge1xuXHRcdFx0cHJvY2Vzc0NsYXNzU3RyaW5nKCBvcHRpb25zLmV4dHJhLm1hdGNoKCAvXFxTKy9nICkgfHwgW10gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gZnVsbC5qb2luKCBcIiBcIiApO1xuXHR9LFxuXG5cdF91bnRyYWNrQ2xhc3Nlc0VsZW1lbnQ6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cdFx0JC5lYWNoKCB0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwLCBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRcdGlmICggJC5pbkFycmF5KCBldmVudC50YXJnZXQsIHZhbHVlICkgIT09IC0xICkge1xuXHRcdFx0XHR0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwWyBrZXkgXSA9ICQoIHZhbHVlLm5vdCggZXZlbnQudGFyZ2V0ICkuZ2V0KCkgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0sXG5cblx0X3JlbW92ZUNsYXNzOiBmdW5jdGlvbiggZWxlbWVudCwga2V5cywgZXh0cmEgKSB7XG5cdFx0cmV0dXJuIHRoaXMuX3RvZ2dsZUNsYXNzKCBlbGVtZW50LCBrZXlzLCBleHRyYSwgZmFsc2UgKTtcblx0fSxcblxuXHRfYWRkQ2xhc3M6IGZ1bmN0aW9uKCBlbGVtZW50LCBrZXlzLCBleHRyYSApIHtcblx0XHRyZXR1cm4gdGhpcy5fdG9nZ2xlQ2xhc3MoIGVsZW1lbnQsIGtleXMsIGV4dHJhLCB0cnVlICk7XG5cdH0sXG5cblx0X3RvZ2dsZUNsYXNzOiBmdW5jdGlvbiggZWxlbWVudCwga2V5cywgZXh0cmEsIGFkZCApIHtcblx0XHRhZGQgPSAoIHR5cGVvZiBhZGQgPT09IFwiYm9vbGVhblwiICkgPyBhZGQgOiBleHRyYTtcblx0XHR2YXIgc2hpZnQgPSAoIHR5cGVvZiBlbGVtZW50ID09PSBcInN0cmluZ1wiIHx8IGVsZW1lbnQgPT09IG51bGwgKSxcblx0XHRcdG9wdGlvbnMgPSB7XG5cdFx0XHRcdGV4dHJhOiBzaGlmdCA/IGtleXMgOiBleHRyYSxcblx0XHRcdFx0a2V5czogc2hpZnQgPyBlbGVtZW50IDoga2V5cyxcblx0XHRcdFx0ZWxlbWVudDogc2hpZnQgPyB0aGlzLmVsZW1lbnQgOiBlbGVtZW50LFxuXHRcdFx0XHRhZGQ6IGFkZFxuXHRcdFx0fTtcblx0XHRvcHRpb25zLmVsZW1lbnQudG9nZ2xlQ2xhc3MoIHRoaXMuX2NsYXNzZXMoIG9wdGlvbnMgKSwgYWRkICk7XG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0X29uOiBmdW5jdGlvbiggc3VwcHJlc3NEaXNhYmxlZENoZWNrLCBlbGVtZW50LCBoYW5kbGVycyApIHtcblx0XHR2YXIgZGVsZWdhdGVFbGVtZW50O1xuXHRcdHZhciBpbnN0YW5jZSA9IHRoaXM7XG5cblx0XHQvLyBObyBzdXBwcmVzc0Rpc2FibGVkQ2hlY2sgZmxhZywgc2h1ZmZsZSBhcmd1bWVudHNcblx0XHRpZiAoIHR5cGVvZiBzdXBwcmVzc0Rpc2FibGVkQ2hlY2sgIT09IFwiYm9vbGVhblwiICkge1xuXHRcdFx0aGFuZGxlcnMgPSBlbGVtZW50O1xuXHRcdFx0ZWxlbWVudCA9IHN1cHByZXNzRGlzYWJsZWRDaGVjaztcblx0XHRcdHN1cHByZXNzRGlzYWJsZWRDaGVjayA9IGZhbHNlO1xuXHRcdH1cblxuXHRcdC8vIE5vIGVsZW1lbnQgYXJndW1lbnQsIHNodWZmbGUgYW5kIHVzZSB0aGlzLmVsZW1lbnRcblx0XHRpZiAoICFoYW5kbGVycyApIHtcblx0XHRcdGhhbmRsZXJzID0gZWxlbWVudDtcblx0XHRcdGVsZW1lbnQgPSB0aGlzLmVsZW1lbnQ7XG5cdFx0XHRkZWxlZ2F0ZUVsZW1lbnQgPSB0aGlzLndpZGdldCgpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbGVtZW50ID0gZGVsZWdhdGVFbGVtZW50ID0gJCggZWxlbWVudCApO1xuXHRcdFx0dGhpcy5iaW5kaW5ncyA9IHRoaXMuYmluZGluZ3MuYWRkKCBlbGVtZW50ICk7XG5cdFx0fVxuXG5cdFx0JC5lYWNoKCBoYW5kbGVycywgZnVuY3Rpb24oIGV2ZW50LCBoYW5kbGVyICkge1xuXHRcdFx0ZnVuY3Rpb24gaGFuZGxlclByb3h5KCkge1xuXG5cdFx0XHRcdC8vIEFsbG93IHdpZGdldHMgdG8gY3VzdG9taXplIHRoZSBkaXNhYmxlZCBoYW5kbGluZ1xuXHRcdFx0XHQvLyAtIGRpc2FibGVkIGFzIGFuIGFycmF5IGluc3RlYWQgb2YgYm9vbGVhblxuXHRcdFx0XHQvLyAtIGRpc2FibGVkIGNsYXNzIGFzIG1ldGhvZCBmb3IgZGlzYWJsaW5nIGluZGl2aWR1YWwgcGFydHNcblx0XHRcdFx0aWYgKCAhc3VwcHJlc3NEaXNhYmxlZENoZWNrICYmXG5cdFx0XHRcdFx0XHQoIGluc3RhbmNlLm9wdGlvbnMuZGlzYWJsZWQgPT09IHRydWUgfHxcblx0XHRcdFx0XHRcdCQoIHRoaXMgKS5oYXNDbGFzcyggXCJ1aS1zdGF0ZS1kaXNhYmxlZFwiICkgKSApIHtcblx0XHRcdFx0XHRyZXR1cm47XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuICggdHlwZW9mIGhhbmRsZXIgPT09IFwic3RyaW5nXCIgPyBpbnN0YW5jZVsgaGFuZGxlciBdIDogaGFuZGxlciApXG5cdFx0XHRcdFx0LmFwcGx5KCBpbnN0YW5jZSwgYXJndW1lbnRzICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIENvcHkgdGhlIGd1aWQgc28gZGlyZWN0IHVuYmluZGluZyB3b3Jrc1xuXHRcdFx0aWYgKCB0eXBlb2YgaGFuZGxlciAhPT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdFx0aGFuZGxlclByb3h5Lmd1aWQgPSBoYW5kbGVyLmd1aWQgPVxuXHRcdFx0XHRcdGhhbmRsZXIuZ3VpZCB8fCBoYW5kbGVyUHJveHkuZ3VpZCB8fCAkLmd1aWQrKztcblx0XHRcdH1cblxuXHRcdFx0dmFyIG1hdGNoID0gZXZlbnQubWF0Y2goIC9eKFtcXHc6LV0qKVxccyooLiopJC8gKTtcblx0XHRcdHZhciBldmVudE5hbWUgPSBtYXRjaFsgMSBdICsgaW5zdGFuY2UuZXZlbnROYW1lc3BhY2U7XG5cdFx0XHR2YXIgc2VsZWN0b3IgPSBtYXRjaFsgMiBdO1xuXG5cdFx0XHRpZiAoIHNlbGVjdG9yICkge1xuXHRcdFx0XHRkZWxlZ2F0ZUVsZW1lbnQub24oIGV2ZW50TmFtZSwgc2VsZWN0b3IsIGhhbmRsZXJQcm94eSApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0ZWxlbWVudC5vbiggZXZlbnROYW1lLCBoYW5kbGVyUHJveHkgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0sXG5cblx0X29mZjogZnVuY3Rpb24oIGVsZW1lbnQsIGV2ZW50TmFtZSApIHtcblx0XHRldmVudE5hbWUgPSAoIGV2ZW50TmFtZSB8fCBcIlwiICkuc3BsaXQoIFwiIFwiICkuam9pbiggdGhpcy5ldmVudE5hbWVzcGFjZSArIFwiIFwiICkgK1xuXHRcdFx0dGhpcy5ldmVudE5hbWVzcGFjZTtcblx0XHRlbGVtZW50Lm9mZiggZXZlbnROYW1lICkub2ZmKCBldmVudE5hbWUgKTtcblxuXHRcdC8vIENsZWFyIHRoZSBzdGFjayB0byBhdm9pZCBtZW1vcnkgbGVha3MgKCMxMDA1Nilcblx0XHR0aGlzLmJpbmRpbmdzID0gJCggdGhpcy5iaW5kaW5ncy5ub3QoIGVsZW1lbnQgKS5nZXQoKSApO1xuXHRcdHRoaXMuZm9jdXNhYmxlID0gJCggdGhpcy5mb2N1c2FibGUubm90KCBlbGVtZW50ICkuZ2V0KCkgKTtcblx0XHR0aGlzLmhvdmVyYWJsZSA9ICQoIHRoaXMuaG92ZXJhYmxlLm5vdCggZWxlbWVudCApLmdldCgpICk7XG5cdH0sXG5cblx0X2RlbGF5OiBmdW5jdGlvbiggaGFuZGxlciwgZGVsYXkgKSB7XG5cdFx0ZnVuY3Rpb24gaGFuZGxlclByb3h5KCkge1xuXHRcdFx0cmV0dXJuICggdHlwZW9mIGhhbmRsZXIgPT09IFwic3RyaW5nXCIgPyBpbnN0YW5jZVsgaGFuZGxlciBdIDogaGFuZGxlciApXG5cdFx0XHRcdC5hcHBseSggaW5zdGFuY2UsIGFyZ3VtZW50cyApO1xuXHRcdH1cblx0XHR2YXIgaW5zdGFuY2UgPSB0aGlzO1xuXHRcdHJldHVybiBzZXRUaW1lb3V0KCBoYW5kbGVyUHJveHksIGRlbGF5IHx8IDAgKTtcblx0fSxcblxuXHRfaG92ZXJhYmxlOiBmdW5jdGlvbiggZWxlbWVudCApIHtcblx0XHR0aGlzLmhvdmVyYWJsZSA9IHRoaXMuaG92ZXJhYmxlLmFkZCggZWxlbWVudCApO1xuXHRcdHRoaXMuX29uKCBlbGVtZW50LCB7XG5cdFx0XHRtb3VzZWVudGVyOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHRoaXMuX2FkZENsYXNzKCAkKCBldmVudC5jdXJyZW50VGFyZ2V0ICksIG51bGwsIFwidWktc3RhdGUtaG92ZXJcIiApO1xuXHRcdFx0fSxcblx0XHRcdG1vdXNlbGVhdmU6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoICQoIGV2ZW50LmN1cnJlbnRUYXJnZXQgKSwgbnVsbCwgXCJ1aS1zdGF0ZS1ob3ZlclwiICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdF9mb2N1c2FibGU6IGZ1bmN0aW9uKCBlbGVtZW50ICkge1xuXHRcdHRoaXMuZm9jdXNhYmxlID0gdGhpcy5mb2N1c2FibGUuYWRkKCBlbGVtZW50ICk7XG5cdFx0dGhpcy5fb24oIGVsZW1lbnQsIHtcblx0XHRcdGZvY3VzaW46IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0dGhpcy5fYWRkQ2xhc3MoICQoIGV2ZW50LmN1cnJlbnRUYXJnZXQgKSwgbnVsbCwgXCJ1aS1zdGF0ZS1mb2N1c1wiICk7XG5cdFx0XHR9LFxuXHRcdFx0Zm9jdXNvdXQ6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoICQoIGV2ZW50LmN1cnJlbnRUYXJnZXQgKSwgbnVsbCwgXCJ1aS1zdGF0ZS1mb2N1c1wiICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdF90cmlnZ2VyOiBmdW5jdGlvbiggdHlwZSwgZXZlbnQsIGRhdGEgKSB7XG5cdFx0dmFyIHByb3AsIG9yaWc7XG5cdFx0dmFyIGNhbGxiYWNrID0gdGhpcy5vcHRpb25zWyB0eXBlIF07XG5cblx0XHRkYXRhID0gZGF0YSB8fCB7fTtcblx0XHRldmVudCA9ICQuRXZlbnQoIGV2ZW50ICk7XG5cdFx0ZXZlbnQudHlwZSA9ICggdHlwZSA9PT0gdGhpcy53aWRnZXRFdmVudFByZWZpeCA/XG5cdFx0XHR0eXBlIDpcblx0XHRcdHRoaXMud2lkZ2V0RXZlbnRQcmVmaXggKyB0eXBlICkudG9Mb3dlckNhc2UoKTtcblxuXHRcdC8vIFRoZSBvcmlnaW5hbCBldmVudCBtYXkgY29tZSBmcm9tIGFueSBlbGVtZW50XG5cdFx0Ly8gc28gd2UgbmVlZCB0byByZXNldCB0aGUgdGFyZ2V0IG9uIHRoZSBuZXcgZXZlbnRcblx0XHRldmVudC50YXJnZXQgPSB0aGlzLmVsZW1lbnRbIDAgXTtcblxuXHRcdC8vIENvcHkgb3JpZ2luYWwgZXZlbnQgcHJvcGVydGllcyBvdmVyIHRvIHRoZSBuZXcgZXZlbnRcblx0XHRvcmlnID0gZXZlbnQub3JpZ2luYWxFdmVudDtcblx0XHRpZiAoIG9yaWcgKSB7XG5cdFx0XHRmb3IgKCBwcm9wIGluIG9yaWcgKSB7XG5cdFx0XHRcdGlmICggISggcHJvcCBpbiBldmVudCApICkge1xuXHRcdFx0XHRcdGV2ZW50WyBwcm9wIF0gPSBvcmlnWyBwcm9wIF07XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHR0aGlzLmVsZW1lbnQudHJpZ2dlciggZXZlbnQsIGRhdGEgKTtcblx0XHRyZXR1cm4gISggJC5pc0Z1bmN0aW9uKCBjYWxsYmFjayApICYmXG5cdFx0XHRjYWxsYmFjay5hcHBseSggdGhpcy5lbGVtZW50WyAwIF0sIFsgZXZlbnQgXS5jb25jYXQoIGRhdGEgKSApID09PSBmYWxzZSB8fFxuXHRcdFx0ZXZlbnQuaXNEZWZhdWx0UHJldmVudGVkKCkgKTtcblx0fVxufTtcblxuJC5lYWNoKCB7IHNob3c6IFwiZmFkZUluXCIsIGhpZGU6IFwiZmFkZU91dFwiIH0sIGZ1bmN0aW9uKCBtZXRob2QsIGRlZmF1bHRFZmZlY3QgKSB7XG5cdCQuV2lkZ2V0LnByb3RvdHlwZVsgXCJfXCIgKyBtZXRob2QgXSA9IGZ1bmN0aW9uKCBlbGVtZW50LCBvcHRpb25zLCBjYWxsYmFjayApIHtcblx0XHRpZiAoIHR5cGVvZiBvcHRpb25zID09PSBcInN0cmluZ1wiICkge1xuXHRcdFx0b3B0aW9ucyA9IHsgZWZmZWN0OiBvcHRpb25zIH07XG5cdFx0fVxuXG5cdFx0dmFyIGhhc09wdGlvbnM7XG5cdFx0dmFyIGVmZmVjdE5hbWUgPSAhb3B0aW9ucyA/XG5cdFx0XHRtZXRob2QgOlxuXHRcdFx0b3B0aW9ucyA9PT0gdHJ1ZSB8fCB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJudW1iZXJcIiA/XG5cdFx0XHRcdGRlZmF1bHRFZmZlY3QgOlxuXHRcdFx0XHRvcHRpb25zLmVmZmVjdCB8fCBkZWZhdWx0RWZmZWN0O1xuXG5cdFx0b3B0aW9ucyA9IG9wdGlvbnMgfHwge307XG5cdFx0aWYgKCB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJudW1iZXJcIiApIHtcblx0XHRcdG9wdGlvbnMgPSB7IGR1cmF0aW9uOiBvcHRpb25zIH07XG5cdFx0fVxuXG5cdFx0aGFzT3B0aW9ucyA9ICEkLmlzRW1wdHlPYmplY3QoIG9wdGlvbnMgKTtcblx0XHRvcHRpb25zLmNvbXBsZXRlID0gY2FsbGJhY2s7XG5cblx0XHRpZiAoIG9wdGlvbnMuZGVsYXkgKSB7XG5cdFx0XHRlbGVtZW50LmRlbGF5KCBvcHRpb25zLmRlbGF5ICk7XG5cdFx0fVxuXG5cdFx0aWYgKCBoYXNPcHRpb25zICYmICQuZWZmZWN0cyAmJiAkLmVmZmVjdHMuZWZmZWN0WyBlZmZlY3ROYW1lIF0gKSB7XG5cdFx0XHRlbGVtZW50WyBtZXRob2QgXSggb3B0aW9ucyApO1xuXHRcdH0gZWxzZSBpZiAoIGVmZmVjdE5hbWUgIT09IG1ldGhvZCAmJiBlbGVtZW50WyBlZmZlY3ROYW1lIF0gKSB7XG5cdFx0XHRlbGVtZW50WyBlZmZlY3ROYW1lIF0oIG9wdGlvbnMuZHVyYXRpb24sIG9wdGlvbnMuZWFzaW5nLCBjYWxsYmFjayApO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbGVtZW50LnF1ZXVlKCBmdW5jdGlvbiggbmV4dCApIHtcblx0XHRcdFx0JCggdGhpcyApWyBtZXRob2QgXSgpO1xuXHRcdFx0XHRpZiAoIGNhbGxiYWNrICkge1xuXHRcdFx0XHRcdGNhbGxiYWNrLmNhbGwoIGVsZW1lbnRbIDAgXSApO1xuXHRcdFx0XHR9XG5cdFx0XHRcdG5leHQoKTtcblx0XHRcdH0gKTtcblx0XHR9XG5cdH07XG59ICk7XG5cbnJldHVybiAkLndpZGdldDtcblxufSApICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBNb3VzZSAxLjEyLjFcbiAqIGh0dHA6Ly9qcXVlcnl1aS5jb21cbiAqXG4gKiBDb3B5cmlnaHQgalF1ZXJ5IEZvdW5kYXRpb24gYW5kIG90aGVyIGNvbnRyaWJ1dG9yc1xuICogUmVsZWFzZWQgdW5kZXIgdGhlIE1JVCBsaWNlbnNlLlxuICogaHR0cDovL2pxdWVyeS5vcmcvbGljZW5zZVxuICovXG5cbi8vPj5sYWJlbDogTW91c2Vcbi8vPj5ncm91cDogV2lkZ2V0c1xuLy8+PmRlc2NyaXB0aW9uOiBBYnN0cmFjdHMgbW91c2UtYmFzZWQgaW50ZXJhY3Rpb25zIHRvIGFzc2lzdCBpbiBjcmVhdGluZyBjZXJ0YWluIHdpZGdldHMuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20vbW91c2UvXG5cbiggZnVuY3Rpb24oIGZhY3RvcnkgKSB7XG5cdGlmICggdHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQgKSB7XG5cblx0XHQvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG5cdFx0ZGVmaW5lKCBbXG5cdFx0XHRcImpxdWVyeVwiLFxuXHRcdFx0XCIuLi9pZVwiLFxuXHRcdFx0XCIuLi92ZXJzaW9uXCIsXG5cdFx0XHRcIi4uL3dpZGdldFwiXG5cdFx0XSwgZmFjdG9yeSApO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gQnJvd3NlciBnbG9iYWxzXG5cdFx0ZmFjdG9yeSggalF1ZXJ5ICk7XG5cdH1cbn0oIGZ1bmN0aW9uKCAkICkge1xuXG52YXIgbW91c2VIYW5kbGVkID0gZmFsc2U7XG4kKCBkb2N1bWVudCApLm9uKCBcIm1vdXNldXBcIiwgZnVuY3Rpb24oKSB7XG5cdG1vdXNlSGFuZGxlZCA9IGZhbHNlO1xufSApO1xuXG5yZXR1cm4gJC53aWRnZXQoIFwidWkubW91c2VcIiwge1xuXHR2ZXJzaW9uOiBcIjEuMTIuMVwiLFxuXHRvcHRpb25zOiB7XG5cdFx0Y2FuY2VsOiBcImlucHV0LCB0ZXh0YXJlYSwgYnV0dG9uLCBzZWxlY3QsIG9wdGlvblwiLFxuXHRcdGRpc3RhbmNlOiAxLFxuXHRcdGRlbGF5OiAwXG5cdH0sXG5cdF9tb3VzZUluaXQ6IGZ1bmN0aW9uKCkge1xuXHRcdHZhciB0aGF0ID0gdGhpcztcblxuXHRcdHRoaXMuZWxlbWVudFxuXHRcdFx0Lm9uKCBcIm1vdXNlZG93bi5cIiArIHRoaXMud2lkZ2V0TmFtZSwgZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHRyZXR1cm4gdGhhdC5fbW91c2VEb3duKCBldmVudCApO1xuXHRcdFx0fSApXG5cdFx0XHQub24oIFwiY2xpY2suXCIgKyB0aGlzLndpZGdldE5hbWUsIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0aWYgKCB0cnVlID09PSAkLmRhdGEoIGV2ZW50LnRhcmdldCwgdGhhdC53aWRnZXROYW1lICsgXCIucHJldmVudENsaWNrRXZlbnRcIiApICkge1xuXHRcdFx0XHRcdCQucmVtb3ZlRGF0YSggZXZlbnQudGFyZ2V0LCB0aGF0LndpZGdldE5hbWUgKyBcIi5wcmV2ZW50Q2xpY2tFdmVudFwiICk7XG5cdFx0XHRcdFx0ZXZlbnQuc3RvcEltbWVkaWF0ZVByb3BhZ2F0aW9uKCk7XG5cdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0XHR9XG5cdFx0XHR9ICk7XG5cblx0XHR0aGlzLnN0YXJ0ZWQgPSBmYWxzZTtcblx0fSxcblxuXHQvLyBUT0RPOiBtYWtlIHN1cmUgZGVzdHJveWluZyBvbmUgaW5zdGFuY2Ugb2YgbW91c2UgZG9lc24ndCBtZXNzIHdpdGhcblx0Ly8gb3RoZXIgaW5zdGFuY2VzIG9mIG1vdXNlXG5cdF9tb3VzZURlc3Ryb3k6IGZ1bmN0aW9uKCkge1xuXHRcdHRoaXMuZWxlbWVudC5vZmYoIFwiLlwiICsgdGhpcy53aWRnZXROYW1lICk7XG5cdFx0aWYgKCB0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSApIHtcblx0XHRcdHRoaXMuZG9jdW1lbnRcblx0XHRcdFx0Lm9mZiggXCJtb3VzZW1vdmUuXCIgKyB0aGlzLndpZGdldE5hbWUsIHRoaXMuX21vdXNlTW92ZURlbGVnYXRlIClcblx0XHRcdFx0Lm9mZiggXCJtb3VzZXVwLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZVVwRGVsZWdhdGUgKTtcblx0XHR9XG5cdH0sXG5cblx0X21vdXNlRG93bjogZnVuY3Rpb24oIGV2ZW50ICkge1xuXG5cdFx0Ly8gZG9uJ3QgbGV0IG1vcmUgdGhhbiBvbmUgd2lkZ2V0IGhhbmRsZSBtb3VzZVN0YXJ0XG5cdFx0aWYgKCBtb3VzZUhhbmRsZWQgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0dGhpcy5fbW91c2VNb3ZlZCA9IGZhbHNlO1xuXG5cdFx0Ly8gV2UgbWF5IGhhdmUgbWlzc2VkIG1vdXNldXAgKG91dCBvZiB3aW5kb3cpXG5cdFx0KCB0aGlzLl9tb3VzZVN0YXJ0ZWQgJiYgdGhpcy5fbW91c2VVcCggZXZlbnQgKSApO1xuXG5cdFx0dGhpcy5fbW91c2VEb3duRXZlbnQgPSBldmVudDtcblxuXHRcdHZhciB0aGF0ID0gdGhpcyxcblx0XHRcdGJ0bklzTGVmdCA9ICggZXZlbnQud2hpY2ggPT09IDEgKSxcblxuXHRcdFx0Ly8gZXZlbnQudGFyZ2V0Lm5vZGVOYW1lIHdvcmtzIGFyb3VuZCBhIGJ1ZyBpbiBJRSA4IHdpdGhcblx0XHRcdC8vIGRpc2FibGVkIGlucHV0cyAoIzc2MjApXG5cdFx0XHRlbElzQ2FuY2VsID0gKCB0eXBlb2YgdGhpcy5vcHRpb25zLmNhbmNlbCA9PT0gXCJzdHJpbmdcIiAmJiBldmVudC50YXJnZXQubm9kZU5hbWUgP1xuXHRcdFx0XHQkKCBldmVudC50YXJnZXQgKS5jbG9zZXN0KCB0aGlzLm9wdGlvbnMuY2FuY2VsICkubGVuZ3RoIDogZmFsc2UgKTtcblx0XHRpZiAoICFidG5Jc0xlZnQgfHwgZWxJc0NhbmNlbCB8fCAhdGhpcy5fbW91c2VDYXB0dXJlKCBldmVudCApICkge1xuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fVxuXG5cdFx0dGhpcy5tb3VzZURlbGF5TWV0ID0gIXRoaXMub3B0aW9ucy5kZWxheTtcblx0XHRpZiAoICF0aGlzLm1vdXNlRGVsYXlNZXQgKSB7XG5cdFx0XHR0aGlzLl9tb3VzZURlbGF5VGltZXIgPSBzZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHRcdFx0dGhhdC5tb3VzZURlbGF5TWV0ID0gdHJ1ZTtcblx0XHRcdH0sIHRoaXMub3B0aW9ucy5kZWxheSApO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5fbW91c2VEaXN0YW5jZU1ldCggZXZlbnQgKSAmJiB0aGlzLl9tb3VzZURlbGF5TWV0KCBldmVudCApICkge1xuXHRcdFx0dGhpcy5fbW91c2VTdGFydGVkID0gKCB0aGlzLl9tb3VzZVN0YXJ0KCBldmVudCApICE9PSBmYWxzZSApO1xuXHRcdFx0aWYgKCAhdGhpcy5fbW91c2VTdGFydGVkICkge1xuXHRcdFx0XHRldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdFx0XHRyZXR1cm4gdHJ1ZTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvLyBDbGljayBldmVudCBtYXkgbmV2ZXIgaGF2ZSBmaXJlZCAoR2Vja28gJiBPcGVyYSlcblx0XHRpZiAoIHRydWUgPT09ICQuZGF0YSggZXZlbnQudGFyZ2V0LCB0aGlzLndpZGdldE5hbWUgKyBcIi5wcmV2ZW50Q2xpY2tFdmVudFwiICkgKSB7XG5cdFx0XHQkLnJlbW92ZURhdGEoIGV2ZW50LnRhcmdldCwgdGhpcy53aWRnZXROYW1lICsgXCIucHJldmVudENsaWNrRXZlbnRcIiApO1xuXHRcdH1cblxuXHRcdC8vIFRoZXNlIGRlbGVnYXRlcyBhcmUgcmVxdWlyZWQgdG8ga2VlcCBjb250ZXh0XG5cdFx0dGhpcy5fbW91c2VNb3ZlRGVsZWdhdGUgPSBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRyZXR1cm4gdGhhdC5fbW91c2VNb3ZlKCBldmVudCApO1xuXHRcdH07XG5cdFx0dGhpcy5fbW91c2VVcERlbGVnYXRlID0gZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0cmV0dXJuIHRoYXQuX21vdXNlVXAoIGV2ZW50ICk7XG5cdFx0fTtcblxuXHRcdHRoaXMuZG9jdW1lbnRcblx0XHRcdC5vbiggXCJtb3VzZW1vdmUuXCIgKyB0aGlzLndpZGdldE5hbWUsIHRoaXMuX21vdXNlTW92ZURlbGVnYXRlIClcblx0XHRcdC5vbiggXCJtb3VzZXVwLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZVVwRGVsZWdhdGUgKTtcblxuXHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cblx0XHRtb3VzZUhhbmRsZWQgPSB0cnVlO1xuXHRcdHJldHVybiB0cnVlO1xuXHR9LFxuXG5cdF9tb3VzZU1vdmU6IGZ1bmN0aW9uKCBldmVudCApIHtcblxuXHRcdC8vIE9ubHkgY2hlY2sgZm9yIG1vdXNldXBzIG91dHNpZGUgdGhlIGRvY3VtZW50IGlmIHlvdSd2ZSBtb3ZlZCBpbnNpZGUgdGhlIGRvY3VtZW50XG5cdFx0Ly8gYXQgbGVhc3Qgb25jZS4gVGhpcyBwcmV2ZW50cyB0aGUgZmlyaW5nIG9mIG1vdXNldXAgaW4gdGhlIGNhc2Ugb2YgSUU8OSwgd2hpY2ggd2lsbFxuXHRcdC8vIGZpcmUgYSBtb3VzZW1vdmUgZXZlbnQgaWYgY29udGVudCBpcyBwbGFjZWQgdW5kZXIgdGhlIGN1cnNvci4gU2VlICM3Nzc4XG5cdFx0Ly8gU3VwcG9ydDogSUUgPDlcblx0XHRpZiAoIHRoaXMuX21vdXNlTW92ZWQgKSB7XG5cblx0XHRcdC8vIElFIG1vdXNldXAgY2hlY2sgLSBtb3VzZXVwIGhhcHBlbmVkIHdoZW4gbW91c2Ugd2FzIG91dCBvZiB3aW5kb3dcblx0XHRcdGlmICggJC51aS5pZSAmJiAoICFkb2N1bWVudC5kb2N1bWVudE1vZGUgfHwgZG9jdW1lbnQuZG9jdW1lbnRNb2RlIDwgOSApICYmXG5cdFx0XHRcdFx0IWV2ZW50LmJ1dHRvbiApIHtcblx0XHRcdFx0cmV0dXJuIHRoaXMuX21vdXNlVXAoIGV2ZW50ICk7XG5cblx0XHRcdC8vIElmcmFtZSBtb3VzZXVwIGNoZWNrIC0gbW91c2V1cCBvY2N1cnJlZCBpbiBhbm90aGVyIGRvY3VtZW50XG5cdFx0XHR9IGVsc2UgaWYgKCAhZXZlbnQud2hpY2ggKSB7XG5cblx0XHRcdFx0Ly8gU3VwcG9ydDogU2FmYXJpIDw9OCAtIDlcblx0XHRcdFx0Ly8gU2FmYXJpIHNldHMgd2hpY2ggdG8gMCBpZiB5b3UgcHJlc3MgYW55IG9mIHRoZSBmb2xsb3dpbmcga2V5c1xuXHRcdFx0XHQvLyBkdXJpbmcgYSBkcmFnICgjMTQ0NjEpXG5cdFx0XHRcdGlmICggZXZlbnQub3JpZ2luYWxFdmVudC5hbHRLZXkgfHwgZXZlbnQub3JpZ2luYWxFdmVudC5jdHJsS2V5IHx8XG5cdFx0XHRcdFx0XHRldmVudC5vcmlnaW5hbEV2ZW50Lm1ldGFLZXkgfHwgZXZlbnQub3JpZ2luYWxFdmVudC5zaGlmdEtleSApIHtcblx0XHRcdFx0XHR0aGlzLmlnbm9yZU1pc3NpbmdXaGljaCA9IHRydWU7XG5cdFx0XHRcdH0gZWxzZSBpZiAoICF0aGlzLmlnbm9yZU1pc3NpbmdXaGljaCApIHtcblx0XHRcdFx0XHRyZXR1cm4gdGhpcy5fbW91c2VVcCggZXZlbnQgKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblxuXHRcdGlmICggZXZlbnQud2hpY2ggfHwgZXZlbnQuYnV0dG9uICkge1xuXHRcdFx0dGhpcy5fbW91c2VNb3ZlZCA9IHRydWU7XG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLl9tb3VzZVN0YXJ0ZWQgKSB7XG5cdFx0XHR0aGlzLl9tb3VzZURyYWcoIGV2ZW50ICk7XG5cdFx0XHRyZXR1cm4gZXZlbnQucHJldmVudERlZmF1bHQoKTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMuX21vdXNlRGlzdGFuY2VNZXQoIGV2ZW50ICkgJiYgdGhpcy5fbW91c2VEZWxheU1ldCggZXZlbnQgKSApIHtcblx0XHRcdHRoaXMuX21vdXNlU3RhcnRlZCA9XG5cdFx0XHRcdCggdGhpcy5fbW91c2VTdGFydCggdGhpcy5fbW91c2VEb3duRXZlbnQsIGV2ZW50ICkgIT09IGZhbHNlICk7XG5cdFx0XHQoIHRoaXMuX21vdXNlU3RhcnRlZCA/IHRoaXMuX21vdXNlRHJhZyggZXZlbnQgKSA6IHRoaXMuX21vdXNlVXAoIGV2ZW50ICkgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gIXRoaXMuX21vdXNlU3RhcnRlZDtcblx0fSxcblxuXHRfbW91c2VVcDogZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdHRoaXMuZG9jdW1lbnRcblx0XHRcdC5vZmYoIFwibW91c2Vtb3ZlLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSApXG5cdFx0XHQub2ZmKCBcIm1vdXNldXAuXCIgKyB0aGlzLndpZGdldE5hbWUsIHRoaXMuX21vdXNlVXBEZWxlZ2F0ZSApO1xuXG5cdFx0aWYgKCB0aGlzLl9tb3VzZVN0YXJ0ZWQgKSB7XG5cdFx0XHR0aGlzLl9tb3VzZVN0YXJ0ZWQgPSBmYWxzZTtcblxuXHRcdFx0aWYgKCBldmVudC50YXJnZXQgPT09IHRoaXMuX21vdXNlRG93bkV2ZW50LnRhcmdldCApIHtcblx0XHRcdFx0JC5kYXRhKCBldmVudC50YXJnZXQsIHRoaXMud2lkZ2V0TmFtZSArIFwiLnByZXZlbnRDbGlja0V2ZW50XCIsIHRydWUgKTtcblx0XHRcdH1cblxuXHRcdFx0dGhpcy5fbW91c2VTdG9wKCBldmVudCApO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5fbW91c2VEZWxheVRpbWVyICkge1xuXHRcdFx0Y2xlYXJUaW1lb3V0KCB0aGlzLl9tb3VzZURlbGF5VGltZXIgKTtcblx0XHRcdGRlbGV0ZSB0aGlzLl9tb3VzZURlbGF5VGltZXI7XG5cdFx0fVxuXG5cdFx0dGhpcy5pZ25vcmVNaXNzaW5nV2hpY2ggPSBmYWxzZTtcblx0XHRtb3VzZUhhbmRsZWQgPSBmYWxzZTtcblx0XHRldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXHR9LFxuXG5cdF9tb3VzZURpc3RhbmNlTWV0OiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0cmV0dXJuICggTWF0aC5tYXgoXG5cdFx0XHRcdE1hdGguYWJzKCB0aGlzLl9tb3VzZURvd25FdmVudC5wYWdlWCAtIGV2ZW50LnBhZ2VYICksXG5cdFx0XHRcdE1hdGguYWJzKCB0aGlzLl9tb3VzZURvd25FdmVudC5wYWdlWSAtIGV2ZW50LnBhZ2VZIClcblx0XHRcdCkgPj0gdGhpcy5vcHRpb25zLmRpc3RhbmNlXG5cdFx0KTtcblx0fSxcblxuXHRfbW91c2VEZWxheU1ldDogZnVuY3Rpb24oIC8qIGV2ZW50ICovICkge1xuXHRcdHJldHVybiB0aGlzLm1vdXNlRGVsYXlNZXQ7XG5cdH0sXG5cblx0Ly8gVGhlc2UgYXJlIHBsYWNlaG9sZGVyIG1ldGhvZHMsIHRvIGJlIG92ZXJyaWRlbiBieSBleHRlbmRpbmcgcGx1Z2luXG5cdF9tb3VzZVN0YXJ0OiBmdW5jdGlvbiggLyogZXZlbnQgKi8gKSB7fSxcblx0X21vdXNlRHJhZzogZnVuY3Rpb24oIC8qIGV2ZW50ICovICkge30sXG5cdF9tb3VzZVN0b3A6IGZ1bmN0aW9uKCAvKiBldmVudCAqLyApIHt9LFxuXHRfbW91c2VDYXB0dXJlOiBmdW5jdGlvbiggLyogZXZlbnQgKi8gKSB7IHJldHVybiB0cnVlOyB9XG59ICk7XG5cbn0gKSApO1xuIiwiLyohXG4gKiBqUXVlcnkgVUkgU29ydGFibGUgMS4xMi4xXG4gKiBodHRwOi8vanF1ZXJ5dWkuY29tXG4gKlxuICogQ29weXJpZ2h0IGpRdWVyeSBGb3VuZGF0aW9uIGFuZCBvdGhlciBjb250cmlidXRvcnNcbiAqIFJlbGVhc2VkIHVuZGVyIHRoZSBNSVQgbGljZW5zZS5cbiAqIGh0dHA6Ly9qcXVlcnkub3JnL2xpY2Vuc2VcbiAqL1xuXG4vLz4+bGFiZWw6IFNvcnRhYmxlXG4vLz4+Z3JvdXA6IEludGVyYWN0aW9uc1xuLy8+PmRlc2NyaXB0aW9uOiBFbmFibGVzIGl0ZW1zIGluIGEgbGlzdCB0byBiZSBzb3J0ZWQgdXNpbmcgdGhlIG1vdXNlLlxuLy8+PmRvY3M6IGh0dHA6Ly9hcGkuanF1ZXJ5dWkuY29tL3NvcnRhYmxlL1xuLy8+PmRlbW9zOiBodHRwOi8vanF1ZXJ5dWkuY29tL3NvcnRhYmxlL1xuLy8+PmNzcy5zdHJ1Y3R1cmU6IC4uLy4uL3RoZW1lcy9iYXNlL3NvcnRhYmxlLmNzc1xuXG4oIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggW1xuXHRcdFx0XCJqcXVlcnlcIixcblx0XHRcdFwiLi9tb3VzZVwiLFxuXHRcdFx0XCIuLi9kYXRhXCIsXG5cdFx0XHRcIi4uL2llXCIsXG5cdFx0XHRcIi4uL3Njcm9sbC1wYXJlbnRcIixcblx0XHRcdFwiLi4vdmVyc2lvblwiLFxuXHRcdFx0XCIuLi93aWRnZXRcIlxuXHRcdF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59KCBmdW5jdGlvbiggJCApIHtcblxucmV0dXJuICQud2lkZ2V0KCBcInVpLnNvcnRhYmxlXCIsICQudWkubW91c2UsIHtcblx0dmVyc2lvbjogXCIxLjEyLjFcIixcblx0d2lkZ2V0RXZlbnRQcmVmaXg6IFwic29ydFwiLFxuXHRyZWFkeTogZmFsc2UsXG5cdG9wdGlvbnM6IHtcblx0XHRhcHBlbmRUbzogXCJwYXJlbnRcIixcblx0XHRheGlzOiBmYWxzZSxcblx0XHRjb25uZWN0V2l0aDogZmFsc2UsXG5cdFx0Y29udGFpbm1lbnQ6IGZhbHNlLFxuXHRcdGN1cnNvcjogXCJhdXRvXCIsXG5cdFx0Y3Vyc29yQXQ6IGZhbHNlLFxuXHRcdGRyb3BPbkVtcHR5OiB0cnVlLFxuXHRcdGZvcmNlUGxhY2Vob2xkZXJTaXplOiBmYWxzZSxcblx0XHRmb3JjZUhlbHBlclNpemU6IGZhbHNlLFxuXHRcdGdyaWQ6IGZhbHNlLFxuXHRcdGhhbmRsZTogZmFsc2UsXG5cdFx0aGVscGVyOiBcIm9yaWdpbmFsXCIsXG5cdFx0aXRlbXM6IFwiPiAqXCIsXG5cdFx0b3BhY2l0eTogZmFsc2UsXG5cdFx0cGxhY2Vob2xkZXI6IGZhbHNlLFxuXHRcdHJldmVydDogZmFsc2UsXG5cdFx0c2Nyb2xsOiB0cnVlLFxuXHRcdHNjcm9sbFNlbnNpdGl2aXR5OiAyMCxcblx0XHRzY3JvbGxTcGVlZDogMjAsXG5cdFx0c2NvcGU6IFwiZGVmYXVsdFwiLFxuXHRcdHRvbGVyYW5jZTogXCJpbnRlcnNlY3RcIixcblx0XHR6SW5kZXg6IDEwMDAsXG5cblx0XHQvLyBDYWxsYmFja3Ncblx0XHRhY3RpdmF0ZTogbnVsbCxcblx0XHRiZWZvcmVTdG9wOiBudWxsLFxuXHRcdGNoYW5nZTogbnVsbCxcblx0XHRkZWFjdGl2YXRlOiBudWxsLFxuXHRcdG91dDogbnVsbCxcblx0XHRvdmVyOiBudWxsLFxuXHRcdHJlY2VpdmU6IG51bGwsXG5cdFx0cmVtb3ZlOiBudWxsLFxuXHRcdHNvcnQ6IG51bGwsXG5cdFx0c3RhcnQ6IG51bGwsXG5cdFx0c3RvcDogbnVsbCxcblx0XHR1cGRhdGU6IG51bGxcblx0fSxcblxuXHRfaXNPdmVyQXhpczogZnVuY3Rpb24oIHgsIHJlZmVyZW5jZSwgc2l6ZSApIHtcblx0XHRyZXR1cm4gKCB4ID49IHJlZmVyZW5jZSApICYmICggeCA8ICggcmVmZXJlbmNlICsgc2l6ZSApICk7XG5cdH0sXG5cblx0X2lzRmxvYXRpbmc6IGZ1bmN0aW9uKCBpdGVtICkge1xuXHRcdHJldHVybiAoIC9sZWZ0fHJpZ2h0LyApLnRlc3QoIGl0ZW0uY3NzKCBcImZsb2F0XCIgKSApIHx8XG5cdFx0XHQoIC9pbmxpbmV8dGFibGUtY2VsbC8gKS50ZXN0KCBpdGVtLmNzcyggXCJkaXNwbGF5XCIgKSApO1xuXHR9LFxuXG5cdF9jcmVhdGU6IGZ1bmN0aW9uKCkge1xuXHRcdHRoaXMuY29udGFpbmVyQ2FjaGUgPSB7fTtcblx0XHR0aGlzLl9hZGRDbGFzcyggXCJ1aS1zb3J0YWJsZVwiICk7XG5cblx0XHQvL0dldCB0aGUgaXRlbXNcblx0XHR0aGlzLnJlZnJlc2goKTtcblxuXHRcdC8vTGV0J3MgZGV0ZXJtaW5lIHRoZSBwYXJlbnQncyBvZmZzZXRcblx0XHR0aGlzLm9mZnNldCA9IHRoaXMuZWxlbWVudC5vZmZzZXQoKTtcblxuXHRcdC8vSW5pdGlhbGl6ZSBtb3VzZSBldmVudHMgZm9yIGludGVyYWN0aW9uXG5cdFx0dGhpcy5fbW91c2VJbml0KCk7XG5cblx0XHR0aGlzLl9zZXRIYW5kbGVDbGFzc05hbWUoKTtcblxuXHRcdC8vV2UncmUgcmVhZHkgdG8gZ29cblx0XHR0aGlzLnJlYWR5ID0gdHJ1ZTtcblxuXHR9LFxuXG5cdF9zZXRPcHRpb246IGZ1bmN0aW9uKCBrZXksIHZhbHVlICkge1xuXHRcdHRoaXMuX3N1cGVyKCBrZXksIHZhbHVlICk7XG5cblx0XHRpZiAoIGtleSA9PT0gXCJoYW5kbGVcIiApIHtcblx0XHRcdHRoaXMuX3NldEhhbmRsZUNsYXNzTmFtZSgpO1xuXHRcdH1cblx0fSxcblxuXHRfc2V0SGFuZGxlQ2xhc3NOYW1lOiBmdW5jdGlvbigpIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoIHRoaXMuZWxlbWVudC5maW5kKCBcIi51aS1zb3J0YWJsZS1oYW5kbGVcIiApLCBcInVpLXNvcnRhYmxlLWhhbmRsZVwiICk7XG5cdFx0JC5lYWNoKCB0aGlzLml0ZW1zLCBmdW5jdGlvbigpIHtcblx0XHRcdHRoYXQuX2FkZENsYXNzKFxuXHRcdFx0XHR0aGlzLmluc3RhbmNlLm9wdGlvbnMuaGFuZGxlID9cblx0XHRcdFx0XHR0aGlzLml0ZW0uZmluZCggdGhpcy5pbnN0YW5jZS5vcHRpb25zLmhhbmRsZSApIDpcblx0XHRcdFx0XHR0aGlzLml0ZW0sXG5cdFx0XHRcdFwidWktc29ydGFibGUtaGFuZGxlXCJcblx0XHRcdCk7XG5cdFx0fSApO1xuXHR9LFxuXG5cdF9kZXN0cm95OiBmdW5jdGlvbigpIHtcblx0XHR0aGlzLl9tb3VzZURlc3Ryb3koKTtcblxuXHRcdGZvciAoIHZhciBpID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdHRoaXMuaXRlbXNbIGkgXS5pdGVtLnJlbW92ZURhdGEoIHRoaXMud2lkZ2V0TmFtZSArIFwiLWl0ZW1cIiApO1xuXHRcdH1cblxuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdF9tb3VzZUNhcHR1cmU6IGZ1bmN0aW9uKCBldmVudCwgb3ZlcnJpZGVIYW5kbGUgKSB7XG5cdFx0dmFyIGN1cnJlbnRJdGVtID0gbnVsbCxcblx0XHRcdHZhbGlkSGFuZGxlID0gZmFsc2UsXG5cdFx0XHR0aGF0ID0gdGhpcztcblxuXHRcdGlmICggdGhpcy5yZXZlcnRpbmcgKSB7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLm9wdGlvbnMuZGlzYWJsZWQgfHwgdGhpcy5vcHRpb25zLnR5cGUgPT09IFwic3RhdGljXCIgKSB7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fVxuXG5cdFx0Ly9XZSBoYXZlIHRvIHJlZnJlc2ggdGhlIGl0ZW1zIGRhdGEgb25jZSBmaXJzdFxuXHRcdHRoaXMuX3JlZnJlc2hJdGVtcyggZXZlbnQgKTtcblxuXHRcdC8vRmluZCBvdXQgaWYgdGhlIGNsaWNrZWQgbm9kZSAob3Igb25lIG9mIGl0cyBwYXJlbnRzKSBpcyBhIGFjdHVhbCBpdGVtIGluIHRoaXMuaXRlbXNcblx0XHQkKCBldmVudC50YXJnZXQgKS5wYXJlbnRzKCkuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRpZiAoICQuZGF0YSggdGhpcywgdGhhdC53aWRnZXROYW1lICsgXCItaXRlbVwiICkgPT09IHRoYXQgKSB7XG5cdFx0XHRcdGN1cnJlbnRJdGVtID0gJCggdGhpcyApO1xuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHRcdGlmICggJC5kYXRhKCBldmVudC50YXJnZXQsIHRoYXQud2lkZ2V0TmFtZSArIFwiLWl0ZW1cIiApID09PSB0aGF0ICkge1xuXHRcdFx0Y3VycmVudEl0ZW0gPSAkKCBldmVudC50YXJnZXQgKTtcblx0XHR9XG5cblx0XHRpZiAoICFjdXJyZW50SXRlbSApIHtcblx0XHRcdHJldHVybiBmYWxzZTtcblx0XHR9XG5cdFx0aWYgKCB0aGlzLm9wdGlvbnMuaGFuZGxlICYmICFvdmVycmlkZUhhbmRsZSApIHtcblx0XHRcdCQoIHRoaXMub3B0aW9ucy5oYW5kbGUsIGN1cnJlbnRJdGVtICkuZmluZCggXCIqXCIgKS5hZGRCYWNrKCkuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGlmICggdGhpcyA9PT0gZXZlbnQudGFyZ2V0ICkge1xuXHRcdFx0XHRcdHZhbGlkSGFuZGxlID0gdHJ1ZTtcblx0XHRcdFx0fVxuXHRcdFx0fSApO1xuXHRcdFx0aWYgKCAhdmFsaWRIYW5kbGUgKSB7XG5cdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHR0aGlzLmN1cnJlbnRJdGVtID0gY3VycmVudEl0ZW07XG5cdFx0dGhpcy5fcmVtb3ZlQ3VycmVudHNGcm9tSXRlbXMoKTtcblx0XHRyZXR1cm4gdHJ1ZTtcblxuXHR9LFxuXG5cdF9tb3VzZVN0YXJ0OiBmdW5jdGlvbiggZXZlbnQsIG92ZXJyaWRlSGFuZGxlLCBub0FjdGl2YXRpb24gKSB7XG5cblx0XHR2YXIgaSwgYm9keSxcblx0XHRcdG8gPSB0aGlzLm9wdGlvbnM7XG5cblx0XHR0aGlzLmN1cnJlbnRDb250YWluZXIgPSB0aGlzO1xuXG5cdFx0Ly9XZSBvbmx5IG5lZWQgdG8gY2FsbCByZWZyZXNoUG9zaXRpb25zLCBiZWNhdXNlIHRoZSByZWZyZXNoSXRlbXMgY2FsbCBoYXMgYmVlbiBtb3ZlZCB0b1xuXHRcdC8vIG1vdXNlQ2FwdHVyZVxuXHRcdHRoaXMucmVmcmVzaFBvc2l0aW9ucygpO1xuXG5cdFx0Ly9DcmVhdGUgYW5kIGFwcGVuZCB0aGUgdmlzaWJsZSBoZWxwZXJcblx0XHR0aGlzLmhlbHBlciA9IHRoaXMuX2NyZWF0ZUhlbHBlciggZXZlbnQgKTtcblxuXHRcdC8vQ2FjaGUgdGhlIGhlbHBlciBzaXplXG5cdFx0dGhpcy5fY2FjaGVIZWxwZXJQcm9wb3J0aW9ucygpO1xuXG5cdFx0Lypcblx0XHQgKiAtIFBvc2l0aW9uIGdlbmVyYXRpb24gLVxuXHRcdCAqIFRoaXMgYmxvY2sgZ2VuZXJhdGVzIGV2ZXJ5dGhpbmcgcG9zaXRpb24gcmVsYXRlZCAtIGl0J3MgdGhlIGNvcmUgb2YgZHJhZ2dhYmxlcy5cblx0XHQgKi9cblxuXHRcdC8vQ2FjaGUgdGhlIG1hcmdpbnMgb2YgdGhlIG9yaWdpbmFsIGVsZW1lbnRcblx0XHR0aGlzLl9jYWNoZU1hcmdpbnMoKTtcblxuXHRcdC8vR2V0IHRoZSBuZXh0IHNjcm9sbGluZyBwYXJlbnRcblx0XHR0aGlzLnNjcm9sbFBhcmVudCA9IHRoaXMuaGVscGVyLnNjcm9sbFBhcmVudCgpO1xuXG5cdFx0Ly9UaGUgZWxlbWVudCdzIGFic29sdXRlIHBvc2l0aW9uIG9uIHRoZSBwYWdlIG1pbnVzIG1hcmdpbnNcblx0XHR0aGlzLm9mZnNldCA9IHRoaXMuY3VycmVudEl0ZW0ub2Zmc2V0KCk7XG5cdFx0dGhpcy5vZmZzZXQgPSB7XG5cdFx0XHR0b3A6IHRoaXMub2Zmc2V0LnRvcCAtIHRoaXMubWFyZ2lucy50b3AsXG5cdFx0XHRsZWZ0OiB0aGlzLm9mZnNldC5sZWZ0IC0gdGhpcy5tYXJnaW5zLmxlZnRcblx0XHR9O1xuXG5cdFx0JC5leHRlbmQoIHRoaXMub2Zmc2V0LCB7XG5cdFx0XHRjbGljazogeyAvL1doZXJlIHRoZSBjbGljayBoYXBwZW5lZCwgcmVsYXRpdmUgdG8gdGhlIGVsZW1lbnRcblx0XHRcdFx0bGVmdDogZXZlbnQucGFnZVggLSB0aGlzLm9mZnNldC5sZWZ0LFxuXHRcdFx0XHR0b3A6IGV2ZW50LnBhZ2VZIC0gdGhpcy5vZmZzZXQudG9wXG5cdFx0XHR9LFxuXHRcdFx0cGFyZW50OiB0aGlzLl9nZXRQYXJlbnRPZmZzZXQoKSxcblxuXHRcdFx0Ly8gVGhpcyBpcyBhIHJlbGF0aXZlIHRvIGFic29sdXRlIHBvc2l0aW9uIG1pbnVzIHRoZSBhY3R1YWwgcG9zaXRpb24gY2FsY3VsYXRpb24gLVxuXHRcdFx0Ly8gb25seSB1c2VkIGZvciByZWxhdGl2ZSBwb3NpdGlvbmVkIGhlbHBlclxuXHRcdFx0cmVsYXRpdmU6IHRoaXMuX2dldFJlbGF0aXZlT2Zmc2V0KClcblx0XHR9ICk7XG5cblx0XHQvLyBPbmx5IGFmdGVyIHdlIGdvdCB0aGUgb2Zmc2V0LCB3ZSBjYW4gY2hhbmdlIHRoZSBoZWxwZXIncyBwb3NpdGlvbiB0byBhYnNvbHV0ZVxuXHRcdC8vIFRPRE86IFN0aWxsIG5lZWQgdG8gZmlndXJlIG91dCBhIHdheSB0byBtYWtlIHJlbGF0aXZlIHNvcnRpbmcgcG9zc2libGVcblx0XHR0aGlzLmhlbHBlci5jc3MoIFwicG9zaXRpb25cIiwgXCJhYnNvbHV0ZVwiICk7XG5cdFx0dGhpcy5jc3NQb3NpdGlvbiA9IHRoaXMuaGVscGVyLmNzcyggXCJwb3NpdGlvblwiICk7XG5cblx0XHQvL0dlbmVyYXRlIHRoZSBvcmlnaW5hbCBwb3NpdGlvblxuXHRcdHRoaXMub3JpZ2luYWxQb3NpdGlvbiA9IHRoaXMuX2dlbmVyYXRlUG9zaXRpb24oIGV2ZW50ICk7XG5cdFx0dGhpcy5vcmlnaW5hbFBhZ2VYID0gZXZlbnQucGFnZVg7XG5cdFx0dGhpcy5vcmlnaW5hbFBhZ2VZID0gZXZlbnQucGFnZVk7XG5cblx0XHQvL0FkanVzdCB0aGUgbW91c2Ugb2Zmc2V0IHJlbGF0aXZlIHRvIHRoZSBoZWxwZXIgaWYgXCJjdXJzb3JBdFwiIGlzIHN1cHBsaWVkXG5cdFx0KCBvLmN1cnNvckF0ICYmIHRoaXMuX2FkanVzdE9mZnNldEZyb21IZWxwZXIoIG8uY3Vyc29yQXQgKSApO1xuXG5cdFx0Ly9DYWNoZSB0aGUgZm9ybWVyIERPTSBwb3NpdGlvblxuXHRcdHRoaXMuZG9tUG9zaXRpb24gPSB7XG5cdFx0XHRwcmV2OiB0aGlzLmN1cnJlbnRJdGVtLnByZXYoKVsgMCBdLFxuXHRcdFx0cGFyZW50OiB0aGlzLmN1cnJlbnRJdGVtLnBhcmVudCgpWyAwIF1cblx0XHR9O1xuXG5cdFx0Ly8gSWYgdGhlIGhlbHBlciBpcyBub3QgdGhlIG9yaWdpbmFsLCBoaWRlIHRoZSBvcmlnaW5hbCBzbyBpdCdzIG5vdCBwbGF5aW5nIGFueSByb2xlIGR1cmluZ1xuXHRcdC8vIHRoZSBkcmFnLCB3b24ndCBjYXVzZSBhbnl0aGluZyBiYWQgdGhpcyB3YXlcblx0XHRpZiAoIHRoaXMuaGVscGVyWyAwIF0gIT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdHRoaXMuY3VycmVudEl0ZW0uaGlkZSgpO1xuXHRcdH1cblxuXHRcdC8vQ3JlYXRlIHRoZSBwbGFjZWhvbGRlclxuXHRcdHRoaXMuX2NyZWF0ZVBsYWNlaG9sZGVyKCk7XG5cblx0XHQvL1NldCBhIGNvbnRhaW5tZW50IGlmIGdpdmVuIGluIHRoZSBvcHRpb25zXG5cdFx0aWYgKCBvLmNvbnRhaW5tZW50ICkge1xuXHRcdFx0dGhpcy5fc2V0Q29udGFpbm1lbnQoKTtcblx0XHR9XG5cblx0XHRpZiAoIG8uY3Vyc29yICYmIG8uY3Vyc29yICE9PSBcImF1dG9cIiApIHsgLy8gY3Vyc29yIG9wdGlvblxuXHRcdFx0Ym9keSA9IHRoaXMuZG9jdW1lbnQuZmluZCggXCJib2R5XCIgKTtcblxuXHRcdFx0Ly8gU3VwcG9ydDogSUVcblx0XHRcdHRoaXMuc3RvcmVkQ3Vyc29yID0gYm9keS5jc3MoIFwiY3Vyc29yXCIgKTtcblx0XHRcdGJvZHkuY3NzKCBcImN1cnNvclwiLCBvLmN1cnNvciApO1xuXG5cdFx0XHR0aGlzLnN0b3JlZFN0eWxlc2hlZXQgPVxuXHRcdFx0XHQkKCBcIjxzdHlsZT4qeyBjdXJzb3I6IFwiICsgby5jdXJzb3IgKyBcIiAhaW1wb3J0YW50OyB9PC9zdHlsZT5cIiApLmFwcGVuZFRvKCBib2R5ICk7XG5cdFx0fVxuXG5cdFx0aWYgKCBvLm9wYWNpdHkgKSB7IC8vIG9wYWNpdHkgb3B0aW9uXG5cdFx0XHRpZiAoIHRoaXMuaGVscGVyLmNzcyggXCJvcGFjaXR5XCIgKSApIHtcblx0XHRcdFx0dGhpcy5fc3RvcmVkT3BhY2l0eSA9IHRoaXMuaGVscGVyLmNzcyggXCJvcGFjaXR5XCIgKTtcblx0XHRcdH1cblx0XHRcdHRoaXMuaGVscGVyLmNzcyggXCJvcGFjaXR5XCIsIG8ub3BhY2l0eSApO1xuXHRcdH1cblxuXHRcdGlmICggby56SW5kZXggKSB7IC8vIHpJbmRleCBvcHRpb25cblx0XHRcdGlmICggdGhpcy5oZWxwZXIuY3NzKCBcInpJbmRleFwiICkgKSB7XG5cdFx0XHRcdHRoaXMuX3N0b3JlZFpJbmRleCA9IHRoaXMuaGVscGVyLmNzcyggXCJ6SW5kZXhcIiApO1xuXHRcdFx0fVxuXHRcdFx0dGhpcy5oZWxwZXIuY3NzKCBcInpJbmRleFwiLCBvLnpJbmRleCApO1xuXHRcdH1cblxuXHRcdC8vUHJlcGFyZSBzY3JvbGxpbmdcblx0XHRpZiAoIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0gIT09IHRoaXMuZG9jdW1lbnRbIDAgXSAmJlxuXHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnRhZ05hbWUgIT09IFwiSFRNTFwiICkge1xuXHRcdFx0dGhpcy5vdmVyZmxvd09mZnNldCA9IHRoaXMuc2Nyb2xsUGFyZW50Lm9mZnNldCgpO1xuXHRcdH1cblxuXHRcdC8vQ2FsbCBjYWxsYmFja3Ncblx0XHR0aGlzLl90cmlnZ2VyKCBcInN0YXJ0XCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSApO1xuXG5cdFx0Ly9SZWNhY2hlIHRoZSBoZWxwZXIgc2l6ZVxuXHRcdGlmICggIXRoaXMuX3ByZXNlcnZlSGVscGVyUHJvcG9ydGlvbnMgKSB7XG5cdFx0XHR0aGlzLl9jYWNoZUhlbHBlclByb3BvcnRpb25zKCk7XG5cdFx0fVxuXG5cdFx0Ly9Qb3N0IFwiYWN0aXZhdGVcIiBldmVudHMgdG8gcG9zc2libGUgY29udGFpbmVyc1xuXHRcdGlmICggIW5vQWN0aXZhdGlvbiApIHtcblx0XHRcdGZvciAoIGkgPSB0aGlzLmNvbnRhaW5lcnMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLl90cmlnZ2VyKCBcImFjdGl2YXRlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vUHJlcGFyZSBwb3NzaWJsZSBkcm9wcGFibGVzXG5cdFx0aWYgKCAkLnVpLmRkbWFuYWdlciApIHtcblx0XHRcdCQudWkuZGRtYW5hZ2VyLmN1cnJlbnQgPSB0aGlzO1xuXHRcdH1cblxuXHRcdGlmICggJC51aS5kZG1hbmFnZXIgJiYgIW8uZHJvcEJlaGF2aW91ciApIHtcblx0XHRcdCQudWkuZGRtYW5hZ2VyLnByZXBhcmVPZmZzZXRzKCB0aGlzLCBldmVudCApO1xuXHRcdH1cblxuXHRcdHRoaXMuZHJhZ2dpbmcgPSB0cnVlO1xuXG5cdFx0dGhpcy5fYWRkQ2xhc3MoIHRoaXMuaGVscGVyLCBcInVpLXNvcnRhYmxlLWhlbHBlclwiICk7XG5cblx0XHQvLyBFeGVjdXRlIHRoZSBkcmFnIG9uY2UgLSB0aGlzIGNhdXNlcyB0aGUgaGVscGVyIG5vdCB0byBiZSB2aXNpYmxlYmVmb3JlIGdldHRpbmcgaXRzXG5cdFx0Ly8gY29ycmVjdCBwb3NpdGlvblxuXHRcdHRoaXMuX21vdXNlRHJhZyggZXZlbnQgKTtcblx0XHRyZXR1cm4gdHJ1ZTtcblxuXHR9LFxuXG5cdF9tb3VzZURyYWc6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR2YXIgaSwgaXRlbSwgaXRlbUVsZW1lbnQsIGludGVyc2VjdGlvbixcblx0XHRcdG8gPSB0aGlzLm9wdGlvbnMsXG5cdFx0XHRzY3JvbGxlZCA9IGZhbHNlO1xuXG5cdFx0Ly9Db21wdXRlIHRoZSBoZWxwZXJzIHBvc2l0aW9uXG5cdFx0dGhpcy5wb3NpdGlvbiA9IHRoaXMuX2dlbmVyYXRlUG9zaXRpb24oIGV2ZW50ICk7XG5cdFx0dGhpcy5wb3NpdGlvbkFicyA9IHRoaXMuX2NvbnZlcnRQb3NpdGlvblRvKCBcImFic29sdXRlXCIgKTtcblxuXHRcdGlmICggIXRoaXMubGFzdFBvc2l0aW9uQWJzICkge1xuXHRcdFx0dGhpcy5sYXN0UG9zaXRpb25BYnMgPSB0aGlzLnBvc2l0aW9uQWJzO1xuXHRcdH1cblxuXHRcdC8vRG8gc2Nyb2xsaW5nXG5cdFx0aWYgKCB0aGlzLm9wdGlvbnMuc2Nyb2xsICkge1xuXHRcdFx0aWYgKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdICE9PSB0aGlzLmRvY3VtZW50WyAwIF0gJiZcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnRhZ05hbWUgIT09IFwiSFRNTFwiICkge1xuXG5cdFx0XHRcdGlmICggKCB0aGlzLm92ZXJmbG93T2Zmc2V0LnRvcCArIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0ub2Zmc2V0SGVpZ2h0ICkgLVxuXHRcdFx0XHRcdFx0ZXZlbnQucGFnZVkgPCBvLnNjcm9sbFNlbnNpdGl2aXR5ICkge1xuXHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0uc2Nyb2xsVG9wID1cblx0XHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5zY3JvbGxUb3AgKyBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHR9IGVsc2UgaWYgKCBldmVudC5wYWdlWSAtIHRoaXMub3ZlcmZsb3dPZmZzZXQudG9wIDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbFRvcCA9XG5cdFx0XHRcdFx0XHRzY3JvbGxlZCA9IHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0uc2Nyb2xsVG9wIC0gby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdGlmICggKCB0aGlzLm92ZXJmbG93T2Zmc2V0LmxlZnQgKyB0aGlzLnNjcm9sbFBhcmVudFsgMCBdLm9mZnNldFdpZHRoICkgLVxuXHRcdFx0XHRcdFx0ZXZlbnQucGFnZVggPCBvLnNjcm9sbFNlbnNpdGl2aXR5ICkge1xuXHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0uc2Nyb2xsTGVmdCA9IHNjcm9sbGVkID1cblx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0uc2Nyb2xsTGVmdCArIG8uc2Nyb2xsU3BlZWQ7XG5cdFx0XHRcdH0gZWxzZSBpZiAoIGV2ZW50LnBhZ2VYIC0gdGhpcy5vdmVyZmxvd09mZnNldC5sZWZ0IDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbExlZnQgPSBzY3JvbGxlZCA9XG5cdFx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbExlZnQgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHR9XG5cblx0XHRcdH0gZWxzZSB7XG5cblx0XHRcdFx0aWYgKCBldmVudC5wYWdlWSAtIHRoaXMuZG9jdW1lbnQuc2Nyb2xsVG9wKCkgPCBvLnNjcm9sbFNlbnNpdGl2aXR5ICkge1xuXHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5kb2N1bWVudC5zY3JvbGxUb3AoIHRoaXMuZG9jdW1lbnQuc2Nyb2xsVG9wKCkgLSBvLnNjcm9sbFNwZWVkICk7XG5cdFx0XHRcdH0gZWxzZSBpZiAoIHRoaXMud2luZG93LmhlaWdodCgpIC0gKCBldmVudC5wYWdlWSAtIHRoaXMuZG9jdW1lbnQuc2Nyb2xsVG9wKCkgKSA8XG5cdFx0XHRcdFx0XHRvLnNjcm9sbFNlbnNpdGl2aXR5ICkge1xuXHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5kb2N1bWVudC5zY3JvbGxUb3AoIHRoaXMuZG9jdW1lbnQuc2Nyb2xsVG9wKCkgKyBvLnNjcm9sbFNwZWVkICk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRpZiAoIGV2ZW50LnBhZ2VYIC0gdGhpcy5kb2N1bWVudC5zY3JvbGxMZWZ0KCkgPCBvLnNjcm9sbFNlbnNpdGl2aXR5ICkge1xuXHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5kb2N1bWVudC5zY3JvbGxMZWZ0KFxuXHRcdFx0XHRcdFx0dGhpcy5kb2N1bWVudC5zY3JvbGxMZWZ0KCkgLSBvLnNjcm9sbFNwZWVkXG5cdFx0XHRcdFx0KTtcblx0XHRcdFx0fSBlbHNlIGlmICggdGhpcy53aW5kb3cud2lkdGgoKSAtICggZXZlbnQucGFnZVggLSB0aGlzLmRvY3VtZW50LnNjcm9sbExlZnQoKSApIDxcblx0XHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHkgKSB7XG5cdFx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLmRvY3VtZW50LnNjcm9sbExlZnQoXG5cdFx0XHRcdFx0XHR0aGlzLmRvY3VtZW50LnNjcm9sbExlZnQoKSArIG8uc2Nyb2xsU3BlZWRcblx0XHRcdFx0XHQpO1xuXHRcdFx0XHR9XG5cblx0XHRcdH1cblxuXHRcdFx0aWYgKCBzY3JvbGxlZCAhPT0gZmFsc2UgJiYgJC51aS5kZG1hbmFnZXIgJiYgIW8uZHJvcEJlaGF2aW91ciApIHtcblx0XHRcdFx0JC51aS5kZG1hbmFnZXIucHJlcGFyZU9mZnNldHMoIHRoaXMsIGV2ZW50ICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly9SZWdlbmVyYXRlIHRoZSBhYnNvbHV0ZSBwb3NpdGlvbiB1c2VkIGZvciBwb3NpdGlvbiBjaGVja3Ncblx0XHR0aGlzLnBvc2l0aW9uQWJzID0gdGhpcy5fY29udmVydFBvc2l0aW9uVG8oIFwiYWJzb2x1dGVcIiApO1xuXG5cdFx0Ly9TZXQgdGhlIGhlbHBlciBwb3NpdGlvblxuXHRcdGlmICggIXRoaXMub3B0aW9ucy5heGlzIHx8IHRoaXMub3B0aW9ucy5heGlzICE9PSBcInlcIiApIHtcblx0XHRcdHRoaXMuaGVscGVyWyAwIF0uc3R5bGUubGVmdCA9IHRoaXMucG9zaXRpb24ubGVmdCArIFwicHhcIjtcblx0XHR9XG5cdFx0aWYgKCAhdGhpcy5vcHRpb25zLmF4aXMgfHwgdGhpcy5vcHRpb25zLmF4aXMgIT09IFwieFwiICkge1xuXHRcdFx0dGhpcy5oZWxwZXJbIDAgXS5zdHlsZS50b3AgPSB0aGlzLnBvc2l0aW9uLnRvcCArIFwicHhcIjtcblx0XHR9XG5cblx0XHQvL1JlYXJyYW5nZVxuXHRcdGZvciAoIGkgPSB0aGlzLml0ZW1zLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXG5cdFx0XHQvL0NhY2hlIHZhcmlhYmxlcyBhbmQgaW50ZXJzZWN0aW9uLCBjb250aW51ZSBpZiBubyBpbnRlcnNlY3Rpb25cblx0XHRcdGl0ZW0gPSB0aGlzLml0ZW1zWyBpIF07XG5cdFx0XHRpdGVtRWxlbWVudCA9IGl0ZW0uaXRlbVsgMCBdO1xuXHRcdFx0aW50ZXJzZWN0aW9uID0gdGhpcy5faW50ZXJzZWN0c1dpdGhQb2ludGVyKCBpdGVtICk7XG5cdFx0XHRpZiAoICFpbnRlcnNlY3Rpb24gKSB7XG5cdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBPbmx5IHB1dCB0aGUgcGxhY2Vob2xkZXIgaW5zaWRlIHRoZSBjdXJyZW50IENvbnRhaW5lciwgc2tpcCBhbGxcblx0XHRcdC8vIGl0ZW1zIGZyb20gb3RoZXIgY29udGFpbmVycy4gVGhpcyB3b3JrcyBiZWNhdXNlIHdoZW4gbW92aW5nXG5cdFx0XHQvLyBhbiBpdGVtIGZyb20gb25lIGNvbnRhaW5lciB0byBhbm90aGVyIHRoZVxuXHRcdFx0Ly8gY3VycmVudENvbnRhaW5lciBpcyBzd2l0Y2hlZCBiZWZvcmUgdGhlIHBsYWNlaG9sZGVyIGlzIG1vdmVkLlxuXHRcdFx0Ly9cblx0XHRcdC8vIFdpdGhvdXQgdGhpcywgbW92aW5nIGl0ZW1zIGluIFwic3ViLXNvcnRhYmxlc1wiIGNhbiBjYXVzZVxuXHRcdFx0Ly8gdGhlIHBsYWNlaG9sZGVyIHRvIGppdHRlciBiZXR3ZWVuIHRoZSBvdXRlciBhbmQgaW5uZXIgY29udGFpbmVyLlxuXHRcdFx0aWYgKCBpdGVtLmluc3RhbmNlICE9PSB0aGlzLmN1cnJlbnRDb250YWluZXIgKSB7XG5cdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBDYW5ub3QgaW50ZXJzZWN0IHdpdGggaXRzZWxmXG5cdFx0XHQvLyBubyB1c2VsZXNzIGFjdGlvbnMgdGhhdCBoYXZlIGJlZW4gZG9uZSBiZWZvcmVcblx0XHRcdC8vIG5vIGFjdGlvbiBpZiB0aGUgaXRlbSBtb3ZlZCBpcyB0aGUgcGFyZW50IG9mIHRoZSBpdGVtIGNoZWNrZWRcblx0XHRcdGlmICggaXRlbUVsZW1lbnQgIT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSAmJlxuXHRcdFx0XHR0aGlzLnBsYWNlaG9sZGVyWyBpbnRlcnNlY3Rpb24gPT09IDEgPyBcIm5leHRcIiA6IFwicHJldlwiIF0oKVsgMCBdICE9PSBpdGVtRWxlbWVudCAmJlxuXHRcdFx0XHQhJC5jb250YWlucyggdGhpcy5wbGFjZWhvbGRlclsgMCBdLCBpdGVtRWxlbWVudCApICYmXG5cdFx0XHRcdCggdGhpcy5vcHRpb25zLnR5cGUgPT09IFwic2VtaS1keW5hbWljXCIgP1xuXHRcdFx0XHRcdCEkLmNvbnRhaW5zKCB0aGlzLmVsZW1lbnRbIDAgXSwgaXRlbUVsZW1lbnQgKSA6XG5cdFx0XHRcdFx0dHJ1ZVxuXHRcdFx0XHQpXG5cdFx0XHQpIHtcblxuXHRcdFx0XHR0aGlzLmRpcmVjdGlvbiA9IGludGVyc2VjdGlvbiA9PT0gMSA/IFwiZG93blwiIDogXCJ1cFwiO1xuXG5cdFx0XHRcdGlmICggdGhpcy5vcHRpb25zLnRvbGVyYW5jZSA9PT0gXCJwb2ludGVyXCIgfHwgdGhpcy5faW50ZXJzZWN0c1dpdGhTaWRlcyggaXRlbSApICkge1xuXHRcdFx0XHRcdHRoaXMuX3JlYXJyYW5nZSggZXZlbnQsIGl0ZW0gKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHRoaXMuX3RyaWdnZXIoIFwiY2hhbmdlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSApO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvL1Bvc3QgZXZlbnRzIHRvIGNvbnRhaW5lcnNcblx0XHR0aGlzLl9jb250YWN0Q29udGFpbmVycyggZXZlbnQgKTtcblxuXHRcdC8vSW50ZXJjb25uZWN0IHdpdGggZHJvcHBhYmxlc1xuXHRcdGlmICggJC51aS5kZG1hbmFnZXIgKSB7XG5cdFx0XHQkLnVpLmRkbWFuYWdlci5kcmFnKCB0aGlzLCBldmVudCApO1xuXHRcdH1cblxuXHRcdC8vQ2FsbCBjYWxsYmFja3Ncblx0XHR0aGlzLl90cmlnZ2VyKCBcInNvcnRcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cblx0XHR0aGlzLmxhc3RQb3NpdGlvbkFicyA9IHRoaXMucG9zaXRpb25BYnM7XG5cdFx0cmV0dXJuIGZhbHNlO1xuXG5cdH0sXG5cblx0X21vdXNlU3RvcDogZnVuY3Rpb24oIGV2ZW50LCBub1Byb3BhZ2F0aW9uICkge1xuXG5cdFx0aWYgKCAhZXZlbnQgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0Ly9JZiB3ZSBhcmUgdXNpbmcgZHJvcHBhYmxlcywgaW5mb3JtIHRoZSBtYW5hZ2VyIGFib3V0IHRoZSBkcm9wXG5cdFx0aWYgKCAkLnVpLmRkbWFuYWdlciAmJiAhdGhpcy5vcHRpb25zLmRyb3BCZWhhdmlvdXIgKSB7XG5cdFx0XHQkLnVpLmRkbWFuYWdlci5kcm9wKCB0aGlzLCBldmVudCApO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5vcHRpb25zLnJldmVydCApIHtcblx0XHRcdHZhciB0aGF0ID0gdGhpcyxcblx0XHRcdFx0Y3VyID0gdGhpcy5wbGFjZWhvbGRlci5vZmZzZXQoKSxcblx0XHRcdFx0YXhpcyA9IHRoaXMub3B0aW9ucy5heGlzLFxuXHRcdFx0XHRhbmltYXRpb24gPSB7fTtcblxuXHRcdFx0aWYgKCAhYXhpcyB8fCBheGlzID09PSBcInhcIiApIHtcblx0XHRcdFx0YW5pbWF0aW9uLmxlZnQgPSBjdXIubGVmdCAtIHRoaXMub2Zmc2V0LnBhcmVudC5sZWZ0IC0gdGhpcy5tYXJnaW5zLmxlZnQgK1xuXHRcdFx0XHRcdCggdGhpcy5vZmZzZXRQYXJlbnRbIDAgXSA9PT0gdGhpcy5kb2N1bWVudFsgMCBdLmJvZHkgP1xuXHRcdFx0XHRcdFx0MCA6XG5cdFx0XHRcdFx0XHR0aGlzLm9mZnNldFBhcmVudFsgMCBdLnNjcm9sbExlZnRcblx0XHRcdFx0XHQpO1xuXHRcdFx0fVxuXHRcdFx0aWYgKCAhYXhpcyB8fCBheGlzID09PSBcInlcIiApIHtcblx0XHRcdFx0YW5pbWF0aW9uLnRvcCA9IGN1ci50b3AgLSB0aGlzLm9mZnNldC5wYXJlbnQudG9wIC0gdGhpcy5tYXJnaW5zLnRvcCArXG5cdFx0XHRcdFx0KCB0aGlzLm9mZnNldFBhcmVudFsgMCBdID09PSB0aGlzLmRvY3VtZW50WyAwIF0uYm9keSA/XG5cdFx0XHRcdFx0XHQwIDpcblx0XHRcdFx0XHRcdHRoaXMub2Zmc2V0UGFyZW50WyAwIF0uc2Nyb2xsVG9wXG5cdFx0XHRcdFx0KTtcblx0XHRcdH1cblx0XHRcdHRoaXMucmV2ZXJ0aW5nID0gdHJ1ZTtcblx0XHRcdCQoIHRoaXMuaGVscGVyICkuYW5pbWF0ZShcblx0XHRcdFx0YW5pbWF0aW9uLFxuXHRcdFx0XHRwYXJzZUludCggdGhpcy5vcHRpb25zLnJldmVydCwgMTAgKSB8fCA1MDAsXG5cdFx0XHRcdGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdHRoYXQuX2NsZWFyKCBldmVudCApO1xuXHRcdFx0XHR9XG5cdFx0XHQpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHR0aGlzLl9jbGVhciggZXZlbnQsIG5vUHJvcGFnYXRpb24gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gZmFsc2U7XG5cblx0fSxcblxuXHRjYW5jZWw6IGZ1bmN0aW9uKCkge1xuXG5cdFx0aWYgKCB0aGlzLmRyYWdnaW5nICkge1xuXG5cdFx0XHR0aGlzLl9tb3VzZVVwKCBuZXcgJC5FdmVudCggXCJtb3VzZXVwXCIsIHsgdGFyZ2V0OiBudWxsIH0gKSApO1xuXG5cdFx0XHRpZiAoIHRoaXMub3B0aW9ucy5oZWxwZXIgPT09IFwib3JpZ2luYWxcIiApIHtcblx0XHRcdFx0dGhpcy5jdXJyZW50SXRlbS5jc3MoIHRoaXMuX3N0b3JlZENTUyApO1xuXHRcdFx0XHR0aGlzLl9yZW1vdmVDbGFzcyggdGhpcy5jdXJyZW50SXRlbSwgXCJ1aS1zb3J0YWJsZS1oZWxwZXJcIiApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0dGhpcy5jdXJyZW50SXRlbS5zaG93KCk7XG5cdFx0XHR9XG5cblx0XHRcdC8vUG9zdCBkZWFjdGl2YXRpbmcgZXZlbnRzIHRvIGNvbnRhaW5lcnNcblx0XHRcdGZvciAoIHZhciBpID0gdGhpcy5jb250YWluZXJzLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5fdHJpZ2dlciggXCJkZWFjdGl2YXRlXCIsIG51bGwsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHRcdGlmICggdGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUub3ZlciApIHtcblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5fdHJpZ2dlciggXCJvdXRcIiwgbnVsbCwgdGhpcy5fdWlIYXNoKCB0aGlzICkgKTtcblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5jb250YWluZXJDYWNoZS5vdmVyID0gMDtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLnBsYWNlaG9sZGVyICkge1xuXG5cdFx0XHQvLyQodGhpcy5wbGFjZWhvbGRlclswXSkucmVtb3ZlKCk7IHdvdWxkIGhhdmUgYmVlbiB0aGUgalF1ZXJ5IHdheSAtIHVuZm9ydHVuYXRlbHksXG5cdFx0XHQvLyBpdCB1bmJpbmRzIEFMTCBldmVudHMgZnJvbSB0aGUgb3JpZ2luYWwgbm9kZSFcblx0XHRcdGlmICggdGhpcy5wbGFjZWhvbGRlclsgMCBdLnBhcmVudE5vZGUgKSB7XG5cdFx0XHRcdHRoaXMucGxhY2Vob2xkZXJbIDAgXS5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKCB0aGlzLnBsYWNlaG9sZGVyWyAwIF0gKTtcblx0XHRcdH1cblx0XHRcdGlmICggdGhpcy5vcHRpb25zLmhlbHBlciAhPT0gXCJvcmlnaW5hbFwiICYmIHRoaXMuaGVscGVyICYmXG5cdFx0XHRcdFx0dGhpcy5oZWxwZXJbIDAgXS5wYXJlbnROb2RlICkge1xuXHRcdFx0XHR0aGlzLmhlbHBlci5yZW1vdmUoKTtcblx0XHRcdH1cblxuXHRcdFx0JC5leHRlbmQoIHRoaXMsIHtcblx0XHRcdFx0aGVscGVyOiBudWxsLFxuXHRcdFx0XHRkcmFnZ2luZzogZmFsc2UsXG5cdFx0XHRcdHJldmVydGluZzogZmFsc2UsXG5cdFx0XHRcdF9ub0ZpbmFsU29ydDogbnVsbFxuXHRcdFx0fSApO1xuXG5cdFx0XHRpZiAoIHRoaXMuZG9tUG9zaXRpb24ucHJldiApIHtcblx0XHRcdFx0JCggdGhpcy5kb21Qb3NpdGlvbi5wcmV2ICkuYWZ0ZXIoIHRoaXMuY3VycmVudEl0ZW0gKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdCQoIHRoaXMuZG9tUG9zaXRpb24ucGFyZW50ICkucHJlcGVuZCggdGhpcy5jdXJyZW50SXRlbSApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHJldHVybiB0aGlzO1xuXG5cdH0sXG5cblx0c2VyaWFsaXplOiBmdW5jdGlvbiggbyApIHtcblxuXHRcdHZhciBpdGVtcyA9IHRoaXMuX2dldEl0ZW1zQXNqUXVlcnkoIG8gJiYgby5jb25uZWN0ZWQgKSxcblx0XHRcdHN0ciA9IFtdO1xuXHRcdG8gPSBvIHx8IHt9O1xuXG5cdFx0JCggaXRlbXMgKS5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdHZhciByZXMgPSAoICQoIG8uaXRlbSB8fCB0aGlzICkuYXR0ciggby5hdHRyaWJ1dGUgfHwgXCJpZFwiICkgfHwgXCJcIiApXG5cdFx0XHRcdC5tYXRjaCggby5leHByZXNzaW9uIHx8ICggLyguKylbXFwtPV9dKC4rKS8gKSApO1xuXHRcdFx0aWYgKCByZXMgKSB7XG5cdFx0XHRcdHN0ci5wdXNoKFxuXHRcdFx0XHRcdCggby5rZXkgfHwgcmVzWyAxIF0gKyBcIltdXCIgKSArXG5cdFx0XHRcdFx0XCI9XCIgKyAoIG8ua2V5ICYmIG8uZXhwcmVzc2lvbiA/IHJlc1sgMSBdIDogcmVzWyAyIF0gKSApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblxuXHRcdGlmICggIXN0ci5sZW5ndGggJiYgby5rZXkgKSB7XG5cdFx0XHRzdHIucHVzaCggby5rZXkgKyBcIj1cIiApO1xuXHRcdH1cblxuXHRcdHJldHVybiBzdHIuam9pbiggXCImXCIgKTtcblxuXHR9LFxuXG5cdHRvQXJyYXk6IGZ1bmN0aW9uKCBvICkge1xuXG5cdFx0dmFyIGl0ZW1zID0gdGhpcy5fZ2V0SXRlbXNBc2pRdWVyeSggbyAmJiBvLmNvbm5lY3RlZCApLFxuXHRcdFx0cmV0ID0gW107XG5cblx0XHRvID0gbyB8fCB7fTtcblxuXHRcdGl0ZW1zLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0cmV0LnB1c2goICQoIG8uaXRlbSB8fCB0aGlzICkuYXR0ciggby5hdHRyaWJ1dGUgfHwgXCJpZFwiICkgfHwgXCJcIiApO1xuXHRcdH0gKTtcblx0XHRyZXR1cm4gcmV0O1xuXG5cdH0sXG5cblx0LyogQmUgY2FyZWZ1bCB3aXRoIHRoZSBmb2xsb3dpbmcgY29yZSBmdW5jdGlvbnMgKi9cblx0X2ludGVyc2VjdHNXaXRoOiBmdW5jdGlvbiggaXRlbSApIHtcblxuXHRcdHZhciB4MSA9IHRoaXMucG9zaXRpb25BYnMubGVmdCxcblx0XHRcdHgyID0geDEgKyB0aGlzLmhlbHBlclByb3BvcnRpb25zLndpZHRoLFxuXHRcdFx0eTEgPSB0aGlzLnBvc2l0aW9uQWJzLnRvcCxcblx0XHRcdHkyID0geTEgKyB0aGlzLmhlbHBlclByb3BvcnRpb25zLmhlaWdodCxcblx0XHRcdGwgPSBpdGVtLmxlZnQsXG5cdFx0XHRyID0gbCArIGl0ZW0ud2lkdGgsXG5cdFx0XHR0ID0gaXRlbS50b3AsXG5cdFx0XHRiID0gdCArIGl0ZW0uaGVpZ2h0LFxuXHRcdFx0ZHlDbGljayA9IHRoaXMub2Zmc2V0LmNsaWNrLnRvcCxcblx0XHRcdGR4Q2xpY2sgPSB0aGlzLm9mZnNldC5jbGljay5sZWZ0LFxuXHRcdFx0aXNPdmVyRWxlbWVudEhlaWdodCA9ICggdGhpcy5vcHRpb25zLmF4aXMgPT09IFwieFwiICkgfHwgKCAoIHkxICsgZHlDbGljayApID4gdCAmJlxuXHRcdFx0XHQoIHkxICsgZHlDbGljayApIDwgYiApLFxuXHRcdFx0aXNPdmVyRWxlbWVudFdpZHRoID0gKCB0aGlzLm9wdGlvbnMuYXhpcyA9PT0gXCJ5XCIgKSB8fCAoICggeDEgKyBkeENsaWNrICkgPiBsICYmXG5cdFx0XHRcdCggeDEgKyBkeENsaWNrICkgPCByICksXG5cdFx0XHRpc092ZXJFbGVtZW50ID0gaXNPdmVyRWxlbWVudEhlaWdodCAmJiBpc092ZXJFbGVtZW50V2lkdGg7XG5cblx0XHRpZiAoIHRoaXMub3B0aW9ucy50b2xlcmFuY2UgPT09IFwicG9pbnRlclwiIHx8XG5cdFx0XHR0aGlzLm9wdGlvbnMuZm9yY2VQb2ludGVyRm9yQ29udGFpbmVycyB8fFxuXHRcdFx0KCB0aGlzLm9wdGlvbnMudG9sZXJhbmNlICE9PSBcInBvaW50ZXJcIiAmJlxuXHRcdFx0XHR0aGlzLmhlbHBlclByb3BvcnRpb25zWyB0aGlzLmZsb2F0aW5nID8gXCJ3aWR0aFwiIDogXCJoZWlnaHRcIiBdID5cblx0XHRcdFx0aXRlbVsgdGhpcy5mbG9hdGluZyA/IFwid2lkdGhcIiA6IFwiaGVpZ2h0XCIgXSApXG5cdFx0KSB7XG5cdFx0XHRyZXR1cm4gaXNPdmVyRWxlbWVudDtcblx0XHR9IGVsc2Uge1xuXG5cdFx0XHRyZXR1cm4gKCBsIDwgeDEgKyAoIHRoaXMuaGVscGVyUHJvcG9ydGlvbnMud2lkdGggLyAyICkgJiYgLy8gUmlnaHQgSGFsZlxuXHRcdFx0XHR4MiAtICggdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy53aWR0aCAvIDIgKSA8IHIgJiYgLy8gTGVmdCBIYWxmXG5cdFx0XHRcdHQgPCB5MSArICggdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy5oZWlnaHQgLyAyICkgJiYgLy8gQm90dG9tIEhhbGZcblx0XHRcdFx0eTIgLSAoIHRoaXMuaGVscGVyUHJvcG9ydGlvbnMuaGVpZ2h0IC8gMiApIDwgYiApOyAvLyBUb3AgSGFsZlxuXG5cdFx0fVxuXHR9LFxuXG5cdF9pbnRlcnNlY3RzV2l0aFBvaW50ZXI6IGZ1bmN0aW9uKCBpdGVtICkge1xuXHRcdHZhciB2ZXJ0aWNhbERpcmVjdGlvbiwgaG9yaXpvbnRhbERpcmVjdGlvbixcblx0XHRcdGlzT3ZlckVsZW1lbnRIZWlnaHQgPSAoIHRoaXMub3B0aW9ucy5heGlzID09PSBcInhcIiApIHx8XG5cdFx0XHRcdHRoaXMuX2lzT3ZlckF4aXMoXG5cdFx0XHRcdFx0dGhpcy5wb3NpdGlvbkFicy50b3AgKyB0aGlzLm9mZnNldC5jbGljay50b3AsIGl0ZW0udG9wLCBpdGVtLmhlaWdodCApLFxuXHRcdFx0aXNPdmVyRWxlbWVudFdpZHRoID0gKCB0aGlzLm9wdGlvbnMuYXhpcyA9PT0gXCJ5XCIgKSB8fFxuXHRcdFx0XHR0aGlzLl9pc092ZXJBeGlzKFxuXHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMubGVmdCArIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQsIGl0ZW0ubGVmdCwgaXRlbS53aWR0aCApLFxuXHRcdFx0aXNPdmVyRWxlbWVudCA9IGlzT3ZlckVsZW1lbnRIZWlnaHQgJiYgaXNPdmVyRWxlbWVudFdpZHRoO1xuXG5cdFx0aWYgKCAhaXNPdmVyRWxlbWVudCApIHtcblx0XHRcdHJldHVybiBmYWxzZTtcblx0XHR9XG5cblx0XHR2ZXJ0aWNhbERpcmVjdGlvbiA9IHRoaXMuX2dldERyYWdWZXJ0aWNhbERpcmVjdGlvbigpO1xuXHRcdGhvcml6b250YWxEaXJlY3Rpb24gPSB0aGlzLl9nZXREcmFnSG9yaXpvbnRhbERpcmVjdGlvbigpO1xuXG5cdFx0cmV0dXJuIHRoaXMuZmxvYXRpbmcgP1xuXHRcdFx0KCAoIGhvcml6b250YWxEaXJlY3Rpb24gPT09IFwicmlnaHRcIiB8fCB2ZXJ0aWNhbERpcmVjdGlvbiA9PT0gXCJkb3duXCIgKSA/IDIgOiAxIClcblx0XHRcdDogKCB2ZXJ0aWNhbERpcmVjdGlvbiAmJiAoIHZlcnRpY2FsRGlyZWN0aW9uID09PSBcImRvd25cIiA/IDIgOiAxICkgKTtcblxuXHR9LFxuXG5cdF9pbnRlcnNlY3RzV2l0aFNpZGVzOiBmdW5jdGlvbiggaXRlbSApIHtcblxuXHRcdHZhciBpc092ZXJCb3R0b21IYWxmID0gdGhpcy5faXNPdmVyQXhpcyggdGhpcy5wb3NpdGlvbkFicy50b3AgK1xuXHRcdFx0XHR0aGlzLm9mZnNldC5jbGljay50b3AsIGl0ZW0udG9wICsgKCBpdGVtLmhlaWdodCAvIDIgKSwgaXRlbS5oZWlnaHQgKSxcblx0XHRcdGlzT3ZlclJpZ2h0SGFsZiA9IHRoaXMuX2lzT3ZlckF4aXMoIHRoaXMucG9zaXRpb25BYnMubGVmdCArXG5cdFx0XHRcdHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQsIGl0ZW0ubGVmdCArICggaXRlbS53aWR0aCAvIDIgKSwgaXRlbS53aWR0aCApLFxuXHRcdFx0dmVydGljYWxEaXJlY3Rpb24gPSB0aGlzLl9nZXREcmFnVmVydGljYWxEaXJlY3Rpb24oKSxcblx0XHRcdGhvcml6b250YWxEaXJlY3Rpb24gPSB0aGlzLl9nZXREcmFnSG9yaXpvbnRhbERpcmVjdGlvbigpO1xuXG5cdFx0aWYgKCB0aGlzLmZsb2F0aW5nICYmIGhvcml6b250YWxEaXJlY3Rpb24gKSB7XG5cdFx0XHRyZXR1cm4gKCAoIGhvcml6b250YWxEaXJlY3Rpb24gPT09IFwicmlnaHRcIiAmJiBpc092ZXJSaWdodEhhbGYgKSB8fFxuXHRcdFx0XHQoIGhvcml6b250YWxEaXJlY3Rpb24gPT09IFwibGVmdFwiICYmICFpc092ZXJSaWdodEhhbGYgKSApO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRyZXR1cm4gdmVydGljYWxEaXJlY3Rpb24gJiYgKCAoIHZlcnRpY2FsRGlyZWN0aW9uID09PSBcImRvd25cIiAmJiBpc092ZXJCb3R0b21IYWxmICkgfHxcblx0XHRcdFx0KCB2ZXJ0aWNhbERpcmVjdGlvbiA9PT0gXCJ1cFwiICYmICFpc092ZXJCb3R0b21IYWxmICkgKTtcblx0XHR9XG5cblx0fSxcblxuXHRfZ2V0RHJhZ1ZlcnRpY2FsRGlyZWN0aW9uOiBmdW5jdGlvbigpIHtcblx0XHR2YXIgZGVsdGEgPSB0aGlzLnBvc2l0aW9uQWJzLnRvcCAtIHRoaXMubGFzdFBvc2l0aW9uQWJzLnRvcDtcblx0XHRyZXR1cm4gZGVsdGEgIT09IDAgJiYgKCBkZWx0YSA+IDAgPyBcImRvd25cIiA6IFwidXBcIiApO1xuXHR9LFxuXG5cdF9nZXREcmFnSG9yaXpvbnRhbERpcmVjdGlvbjogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIGRlbHRhID0gdGhpcy5wb3NpdGlvbkFicy5sZWZ0IC0gdGhpcy5sYXN0UG9zaXRpb25BYnMubGVmdDtcblx0XHRyZXR1cm4gZGVsdGEgIT09IDAgJiYgKCBkZWx0YSA+IDAgPyBcInJpZ2h0XCIgOiBcImxlZnRcIiApO1xuXHR9LFxuXG5cdHJlZnJlc2g6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR0aGlzLl9yZWZyZXNoSXRlbXMoIGV2ZW50ICk7XG5cdFx0dGhpcy5fc2V0SGFuZGxlQ2xhc3NOYW1lKCk7XG5cdFx0dGhpcy5yZWZyZXNoUG9zaXRpb25zKCk7XG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0X2Nvbm5lY3RXaXRoOiBmdW5jdGlvbigpIHtcblx0XHR2YXIgb3B0aW9ucyA9IHRoaXMub3B0aW9ucztcblx0XHRyZXR1cm4gb3B0aW9ucy5jb25uZWN0V2l0aC5jb25zdHJ1Y3RvciA9PT0gU3RyaW5nID9cblx0XHRcdFsgb3B0aW9ucy5jb25uZWN0V2l0aCBdIDpcblx0XHRcdG9wdGlvbnMuY29ubmVjdFdpdGg7XG5cdH0sXG5cblx0X2dldEl0ZW1zQXNqUXVlcnk6IGZ1bmN0aW9uKCBjb25uZWN0ZWQgKSB7XG5cblx0XHR2YXIgaSwgaiwgY3VyLCBpbnN0LFxuXHRcdFx0aXRlbXMgPSBbXSxcblx0XHRcdHF1ZXJpZXMgPSBbXSxcblx0XHRcdGNvbm5lY3RXaXRoID0gdGhpcy5fY29ubmVjdFdpdGgoKTtcblxuXHRcdGlmICggY29ubmVjdFdpdGggJiYgY29ubmVjdGVkICkge1xuXHRcdFx0Zm9yICggaSA9IGNvbm5lY3RXaXRoLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0XHRjdXIgPSAkKCBjb25uZWN0V2l0aFsgaSBdLCB0aGlzLmRvY3VtZW50WyAwIF0gKTtcblx0XHRcdFx0Zm9yICggaiA9IGN1ci5sZW5ndGggLSAxOyBqID49IDA7IGotLSApIHtcblx0XHRcdFx0XHRpbnN0ID0gJC5kYXRhKCBjdXJbIGogXSwgdGhpcy53aWRnZXRGdWxsTmFtZSApO1xuXHRcdFx0XHRcdGlmICggaW5zdCAmJiBpbnN0ICE9PSB0aGlzICYmICFpbnN0Lm9wdGlvbnMuZGlzYWJsZWQgKSB7XG5cdFx0XHRcdFx0XHRxdWVyaWVzLnB1c2goIFsgJC5pc0Z1bmN0aW9uKCBpbnN0Lm9wdGlvbnMuaXRlbXMgKSA/XG5cdFx0XHRcdFx0XHRcdGluc3Qub3B0aW9ucy5pdGVtcy5jYWxsKCBpbnN0LmVsZW1lbnQgKSA6XG5cdFx0XHRcdFx0XHRcdCQoIGluc3Qub3B0aW9ucy5pdGVtcywgaW5zdC5lbGVtZW50IClcblx0XHRcdFx0XHRcdFx0XHQubm90KCBcIi51aS1zb3J0YWJsZS1oZWxwZXJcIiApXG5cdFx0XHRcdFx0XHRcdFx0Lm5vdCggXCIudWktc29ydGFibGUtcGxhY2Vob2xkZXJcIiApLCBpbnN0IF0gKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHRxdWVyaWVzLnB1c2goIFsgJC5pc0Z1bmN0aW9uKCB0aGlzLm9wdGlvbnMuaXRlbXMgKSA/XG5cdFx0XHR0aGlzLm9wdGlvbnMuaXRlbXNcblx0XHRcdFx0LmNhbGwoIHRoaXMuZWxlbWVudCwgbnVsbCwgeyBvcHRpb25zOiB0aGlzLm9wdGlvbnMsIGl0ZW06IHRoaXMuY3VycmVudEl0ZW0gfSApIDpcblx0XHRcdCQoIHRoaXMub3B0aW9ucy5pdGVtcywgdGhpcy5lbGVtZW50IClcblx0XHRcdFx0Lm5vdCggXCIudWktc29ydGFibGUtaGVscGVyXCIgKVxuXHRcdFx0XHQubm90KCBcIi51aS1zb3J0YWJsZS1wbGFjZWhvbGRlclwiICksIHRoaXMgXSApO1xuXG5cdFx0ZnVuY3Rpb24gYWRkSXRlbXMoKSB7XG5cdFx0XHRpdGVtcy5wdXNoKCB0aGlzICk7XG5cdFx0fVxuXHRcdGZvciAoIGkgPSBxdWVyaWVzLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0cXVlcmllc1sgaSBdWyAwIF0uZWFjaCggYWRkSXRlbXMgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gJCggaXRlbXMgKTtcblxuXHR9LFxuXG5cdF9yZW1vdmVDdXJyZW50c0Zyb21JdGVtczogZnVuY3Rpb24oKSB7XG5cblx0XHR2YXIgbGlzdCA9IHRoaXMuY3VycmVudEl0ZW0uZmluZCggXCI6ZGF0YShcIiArIHRoaXMud2lkZ2V0TmFtZSArIFwiLWl0ZW0pXCIgKTtcblxuXHRcdHRoaXMuaXRlbXMgPSAkLmdyZXAoIHRoaXMuaXRlbXMsIGZ1bmN0aW9uKCBpdGVtICkge1xuXHRcdFx0Zm9yICggdmFyIGogPSAwOyBqIDwgbGlzdC5sZW5ndGg7IGorKyApIHtcblx0XHRcdFx0aWYgKCBsaXN0WyBqIF0gPT09IGl0ZW0uaXRlbVsgMCBdICkge1xuXHRcdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fSApO1xuXG5cdH0sXG5cblx0X3JlZnJlc2hJdGVtczogZnVuY3Rpb24oIGV2ZW50ICkge1xuXG5cdFx0dGhpcy5pdGVtcyA9IFtdO1xuXHRcdHRoaXMuY29udGFpbmVycyA9IFsgdGhpcyBdO1xuXG5cdFx0dmFyIGksIGosIGN1ciwgaW5zdCwgdGFyZ2V0RGF0YSwgX3F1ZXJpZXMsIGl0ZW0sIHF1ZXJpZXNMZW5ndGgsXG5cdFx0XHRpdGVtcyA9IHRoaXMuaXRlbXMsXG5cdFx0XHRxdWVyaWVzID0gWyBbICQuaXNGdW5jdGlvbiggdGhpcy5vcHRpb25zLml0ZW1zICkgP1xuXHRcdFx0XHR0aGlzLm9wdGlvbnMuaXRlbXMuY2FsbCggdGhpcy5lbGVtZW50WyAwIF0sIGV2ZW50LCB7IGl0ZW06IHRoaXMuY3VycmVudEl0ZW0gfSApIDpcblx0XHRcdFx0JCggdGhpcy5vcHRpb25zLml0ZW1zLCB0aGlzLmVsZW1lbnQgKSwgdGhpcyBdIF0sXG5cdFx0XHRjb25uZWN0V2l0aCA9IHRoaXMuX2Nvbm5lY3RXaXRoKCk7XG5cblx0XHQvL1Nob3VsZG4ndCBiZSBydW4gdGhlIGZpcnN0IHRpbWUgdGhyb3VnaCBkdWUgdG8gbWFzc2l2ZSBzbG93LWRvd25cblx0XHRpZiAoIGNvbm5lY3RXaXRoICYmIHRoaXMucmVhZHkgKSB7XG5cdFx0XHRmb3IgKCBpID0gY29ubmVjdFdpdGgubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHRcdGN1ciA9ICQoIGNvbm5lY3RXaXRoWyBpIF0sIHRoaXMuZG9jdW1lbnRbIDAgXSApO1xuXHRcdFx0XHRmb3IgKCBqID0gY3VyLmxlbmd0aCAtIDE7IGogPj0gMDsgai0tICkge1xuXHRcdFx0XHRcdGluc3QgPSAkLmRhdGEoIGN1clsgaiBdLCB0aGlzLndpZGdldEZ1bGxOYW1lICk7XG5cdFx0XHRcdFx0aWYgKCBpbnN0ICYmIGluc3QgIT09IHRoaXMgJiYgIWluc3Qub3B0aW9ucy5kaXNhYmxlZCApIHtcblx0XHRcdFx0XHRcdHF1ZXJpZXMucHVzaCggWyAkLmlzRnVuY3Rpb24oIGluc3Qub3B0aW9ucy5pdGVtcyApID9cblx0XHRcdFx0XHRcdFx0aW5zdC5vcHRpb25zLml0ZW1zXG5cdFx0XHRcdFx0XHRcdFx0LmNhbGwoIGluc3QuZWxlbWVudFsgMCBdLCBldmVudCwgeyBpdGVtOiB0aGlzLmN1cnJlbnRJdGVtIH0gKSA6XG5cdFx0XHRcdFx0XHRcdCQoIGluc3Qub3B0aW9ucy5pdGVtcywgaW5zdC5lbGVtZW50ICksIGluc3QgXSApO1xuXHRcdFx0XHRcdFx0dGhpcy5jb250YWluZXJzLnB1c2goIGluc3QgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHRmb3IgKCBpID0gcXVlcmllcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdHRhcmdldERhdGEgPSBxdWVyaWVzWyBpIF1bIDEgXTtcblx0XHRcdF9xdWVyaWVzID0gcXVlcmllc1sgaSBdWyAwIF07XG5cblx0XHRcdGZvciAoIGogPSAwLCBxdWVyaWVzTGVuZ3RoID0gX3F1ZXJpZXMubGVuZ3RoOyBqIDwgcXVlcmllc0xlbmd0aDsgaisrICkge1xuXHRcdFx0XHRpdGVtID0gJCggX3F1ZXJpZXNbIGogXSApO1xuXG5cdFx0XHRcdC8vIERhdGEgZm9yIHRhcmdldCBjaGVja2luZyAobW91c2UgbWFuYWdlcilcblx0XHRcdFx0aXRlbS5kYXRhKCB0aGlzLndpZGdldE5hbWUgKyBcIi1pdGVtXCIsIHRhcmdldERhdGEgKTtcblxuXHRcdFx0XHRpdGVtcy5wdXNoKCB7XG5cdFx0XHRcdFx0aXRlbTogaXRlbSxcblx0XHRcdFx0XHRpbnN0YW5jZTogdGFyZ2V0RGF0YSxcblx0XHRcdFx0XHR3aWR0aDogMCwgaGVpZ2h0OiAwLFxuXHRcdFx0XHRcdGxlZnQ6IDAsIHRvcDogMFxuXHRcdFx0XHR9ICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdH0sXG5cblx0cmVmcmVzaFBvc2l0aW9uczogZnVuY3Rpb24oIGZhc3QgKSB7XG5cblx0XHQvLyBEZXRlcm1pbmUgd2hldGhlciBpdGVtcyBhcmUgYmVpbmcgZGlzcGxheWVkIGhvcml6b250YWxseVxuXHRcdHRoaXMuZmxvYXRpbmcgPSB0aGlzLml0ZW1zLmxlbmd0aCA/XG5cdFx0XHR0aGlzLm9wdGlvbnMuYXhpcyA9PT0gXCJ4XCIgfHwgdGhpcy5faXNGbG9hdGluZyggdGhpcy5pdGVtc1sgMCBdLml0ZW0gKSA6XG5cdFx0XHRmYWxzZTtcblxuXHRcdC8vVGhpcyBoYXMgdG8gYmUgcmVkb25lIGJlY2F1c2UgZHVlIHRvIHRoZSBpdGVtIGJlaW5nIG1vdmVkIG91dC9pbnRvIHRoZSBvZmZzZXRQYXJlbnQsXG5cdFx0Ly8gdGhlIG9mZnNldFBhcmVudCdzIHBvc2l0aW9uIHdpbGwgY2hhbmdlXG5cdFx0aWYgKCB0aGlzLm9mZnNldFBhcmVudCAmJiB0aGlzLmhlbHBlciApIHtcblx0XHRcdHRoaXMub2Zmc2V0LnBhcmVudCA9IHRoaXMuX2dldFBhcmVudE9mZnNldCgpO1xuXHRcdH1cblxuXHRcdHZhciBpLCBpdGVtLCB0LCBwO1xuXG5cdFx0Zm9yICggaSA9IHRoaXMuaXRlbXMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHRpdGVtID0gdGhpcy5pdGVtc1sgaSBdO1xuXG5cdFx0XHQvL1dlIGlnbm9yZSBjYWxjdWxhdGluZyBwb3NpdGlvbnMgb2YgYWxsIGNvbm5lY3RlZCBjb250YWluZXJzIHdoZW4gd2UncmUgbm90IG92ZXIgdGhlbVxuXHRcdFx0aWYgKCBpdGVtLmluc3RhbmNlICE9PSB0aGlzLmN1cnJlbnRDb250YWluZXIgJiYgdGhpcy5jdXJyZW50Q29udGFpbmVyICYmXG5cdFx0XHRcdFx0aXRlbS5pdGVtWyAwIF0gIT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdFx0Y29udGludWU7XG5cdFx0XHR9XG5cblx0XHRcdHQgPSB0aGlzLm9wdGlvbnMudG9sZXJhbmNlRWxlbWVudCA/XG5cdFx0XHRcdCQoIHRoaXMub3B0aW9ucy50b2xlcmFuY2VFbGVtZW50LCBpdGVtLml0ZW0gKSA6XG5cdFx0XHRcdGl0ZW0uaXRlbTtcblxuXHRcdFx0aWYgKCAhZmFzdCApIHtcblx0XHRcdFx0aXRlbS53aWR0aCA9IHQub3V0ZXJXaWR0aCgpO1xuXHRcdFx0XHRpdGVtLmhlaWdodCA9IHQub3V0ZXJIZWlnaHQoKTtcblx0XHRcdH1cblxuXHRcdFx0cCA9IHQub2Zmc2V0KCk7XG5cdFx0XHRpdGVtLmxlZnQgPSBwLmxlZnQ7XG5cdFx0XHRpdGVtLnRvcCA9IHAudG9wO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5vcHRpb25zLmN1c3RvbSAmJiB0aGlzLm9wdGlvbnMuY3VzdG9tLnJlZnJlc2hDb250YWluZXJzICkge1xuXHRcdFx0dGhpcy5vcHRpb25zLmN1c3RvbS5yZWZyZXNoQ29udGFpbmVycy5jYWxsKCB0aGlzICk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdGZvciAoIGkgPSB0aGlzLmNvbnRhaW5lcnMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHRcdHAgPSB0aGlzLmNvbnRhaW5lcnNbIGkgXS5lbGVtZW50Lm9mZnNldCgpO1xuXHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5jb250YWluZXJDYWNoZS5sZWZ0ID0gcC5sZWZ0O1xuXHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5jb250YWluZXJDYWNoZS50b3AgPSBwLnRvcDtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUud2lkdGggPVxuXHRcdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLmVsZW1lbnQub3V0ZXJXaWR0aCgpO1xuXHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5jb250YWluZXJDYWNoZS5oZWlnaHQgPVxuXHRcdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLmVsZW1lbnQub3V0ZXJIZWlnaHQoKTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfY3JlYXRlUGxhY2Vob2xkZXI6IGZ1bmN0aW9uKCB0aGF0ICkge1xuXHRcdHRoYXQgPSB0aGF0IHx8IHRoaXM7XG5cdFx0dmFyIGNsYXNzTmFtZSxcblx0XHRcdG8gPSB0aGF0Lm9wdGlvbnM7XG5cblx0XHRpZiAoICFvLnBsYWNlaG9sZGVyIHx8IG8ucGxhY2Vob2xkZXIuY29uc3RydWN0b3IgPT09IFN0cmluZyApIHtcblx0XHRcdGNsYXNzTmFtZSA9IG8ucGxhY2Vob2xkZXI7XG5cdFx0XHRvLnBsYWNlaG9sZGVyID0ge1xuXHRcdFx0XHRlbGVtZW50OiBmdW5jdGlvbigpIHtcblxuXHRcdFx0XHRcdHZhciBub2RlTmFtZSA9IHRoYXQuY3VycmVudEl0ZW1bIDAgXS5ub2RlTmFtZS50b0xvd2VyQ2FzZSgpLFxuXHRcdFx0XHRcdFx0ZWxlbWVudCA9ICQoIFwiPFwiICsgbm9kZU5hbWUgKyBcIj5cIiwgdGhhdC5kb2N1bWVudFsgMCBdICk7XG5cblx0XHRcdFx0XHRcdHRoYXQuX2FkZENsYXNzKCBlbGVtZW50LCBcInVpLXNvcnRhYmxlLXBsYWNlaG9sZGVyXCIsXG5cdFx0XHRcdFx0XHRcdFx0Y2xhc3NOYW1lIHx8IHRoYXQuY3VycmVudEl0ZW1bIDAgXS5jbGFzc05hbWUgKVxuXHRcdFx0XHRcdFx0XHQuX3JlbW92ZUNsYXNzKCBlbGVtZW50LCBcInVpLXNvcnRhYmxlLWhlbHBlclwiICk7XG5cblx0XHRcdFx0XHRpZiAoIG5vZGVOYW1lID09PSBcInRib2R5XCIgKSB7XG5cdFx0XHRcdFx0XHR0aGF0Ll9jcmVhdGVUclBsYWNlaG9sZGVyKFxuXHRcdFx0XHRcdFx0XHR0aGF0LmN1cnJlbnRJdGVtLmZpbmQoIFwidHJcIiApLmVxKCAwICksXG5cdFx0XHRcdFx0XHRcdCQoIFwiPHRyPlwiLCB0aGF0LmRvY3VtZW50WyAwIF0gKS5hcHBlbmRUbyggZWxlbWVudCApXG5cdFx0XHRcdFx0XHQpO1xuXHRcdFx0XHRcdH0gZWxzZSBpZiAoIG5vZGVOYW1lID09PSBcInRyXCIgKSB7XG5cdFx0XHRcdFx0XHR0aGF0Ll9jcmVhdGVUclBsYWNlaG9sZGVyKCB0aGF0LmN1cnJlbnRJdGVtLCBlbGVtZW50ICk7XG5cdFx0XHRcdFx0fSBlbHNlIGlmICggbm9kZU5hbWUgPT09IFwiaW1nXCIgKSB7XG5cdFx0XHRcdFx0XHRlbGVtZW50LmF0dHIoIFwic3JjXCIsIHRoYXQuY3VycmVudEl0ZW0uYXR0ciggXCJzcmNcIiApICk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0aWYgKCAhY2xhc3NOYW1lICkge1xuXHRcdFx0XHRcdFx0ZWxlbWVudC5jc3MoIFwidmlzaWJpbGl0eVwiLCBcImhpZGRlblwiICk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0cmV0dXJuIGVsZW1lbnQ7XG5cdFx0XHRcdH0sXG5cdFx0XHRcdHVwZGF0ZTogZnVuY3Rpb24oIGNvbnRhaW5lciwgcCApIHtcblxuXHRcdFx0XHRcdC8vIDEuIElmIGEgY2xhc3NOYW1lIGlzIHNldCBhcyAncGxhY2Vob2xkZXIgb3B0aW9uLCB3ZSBkb24ndCBmb3JjZSBzaXplcyAtXG5cdFx0XHRcdFx0Ly8gdGhlIGNsYXNzIGlzIHJlc3BvbnNpYmxlIGZvciB0aGF0XG5cdFx0XHRcdFx0Ly8gMi4gVGhlIG9wdGlvbiAnZm9yY2VQbGFjZWhvbGRlclNpemUgY2FuIGJlIGVuYWJsZWQgdG8gZm9yY2UgaXQgZXZlbiBpZiBhXG5cdFx0XHRcdFx0Ly8gY2xhc3MgbmFtZSBpcyBzcGVjaWZpZWRcblx0XHRcdFx0XHRpZiAoIGNsYXNzTmFtZSAmJiAhby5mb3JjZVBsYWNlaG9sZGVyU2l6ZSApIHtcblx0XHRcdFx0XHRcdHJldHVybjtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHQvL0lmIHRoZSBlbGVtZW50IGRvZXNuJ3QgaGF2ZSBhIGFjdHVhbCBoZWlnaHQgYnkgaXRzZWxmICh3aXRob3V0IHN0eWxlcyBjb21pbmdcblx0XHRcdFx0XHQvLyBmcm9tIGEgc3R5bGVzaGVldCksIGl0IHJlY2VpdmVzIHRoZSBpbmxpbmUgaGVpZ2h0IGZyb20gdGhlIGRyYWdnZWQgaXRlbVxuXHRcdFx0XHRcdGlmICggIXAuaGVpZ2h0KCkgKSB7XG5cdFx0XHRcdFx0XHRwLmhlaWdodChcblx0XHRcdFx0XHRcdFx0dGhhdC5jdXJyZW50SXRlbS5pbm5lckhlaWdodCgpIC1cblx0XHRcdFx0XHRcdFx0cGFyc2VJbnQoIHRoYXQuY3VycmVudEl0ZW0uY3NzKCBcInBhZGRpbmdUb3BcIiApIHx8IDAsIDEwICkgLVxuXHRcdFx0XHRcdFx0XHRwYXJzZUludCggdGhhdC5jdXJyZW50SXRlbS5jc3MoIFwicGFkZGluZ0JvdHRvbVwiICkgfHwgMCwgMTAgKSApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRpZiAoICFwLndpZHRoKCkgKSB7XG5cdFx0XHRcdFx0XHRwLndpZHRoKFxuXHRcdFx0XHRcdFx0XHR0aGF0LmN1cnJlbnRJdGVtLmlubmVyV2lkdGgoKSAtXG5cdFx0XHRcdFx0XHRcdHBhcnNlSW50KCB0aGF0LmN1cnJlbnRJdGVtLmNzcyggXCJwYWRkaW5nTGVmdFwiICkgfHwgMCwgMTAgKSAtXG5cdFx0XHRcdFx0XHRcdHBhcnNlSW50KCB0aGF0LmN1cnJlbnRJdGVtLmNzcyggXCJwYWRkaW5nUmlnaHRcIiApIHx8IDAsIDEwICkgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH07XG5cdFx0fVxuXG5cdFx0Ly9DcmVhdGUgdGhlIHBsYWNlaG9sZGVyXG5cdFx0dGhhdC5wbGFjZWhvbGRlciA9ICQoIG8ucGxhY2Vob2xkZXIuZWxlbWVudC5jYWxsKCB0aGF0LmVsZW1lbnQsIHRoYXQuY3VycmVudEl0ZW0gKSApO1xuXG5cdFx0Ly9BcHBlbmQgaXQgYWZ0ZXIgdGhlIGFjdHVhbCBjdXJyZW50IGl0ZW1cblx0XHR0aGF0LmN1cnJlbnRJdGVtLmFmdGVyKCB0aGF0LnBsYWNlaG9sZGVyICk7XG5cblx0XHQvL1VwZGF0ZSB0aGUgc2l6ZSBvZiB0aGUgcGxhY2Vob2xkZXIgKFRPRE86IExvZ2ljIHRvIGZ1enp5LCBzZWUgbGluZSAzMTYvMzE3KVxuXHRcdG8ucGxhY2Vob2xkZXIudXBkYXRlKCB0aGF0LCB0aGF0LnBsYWNlaG9sZGVyICk7XG5cblx0fSxcblxuXHRfY3JlYXRlVHJQbGFjZWhvbGRlcjogZnVuY3Rpb24oIHNvdXJjZVRyLCB0YXJnZXRUciApIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0XHRzb3VyY2VUci5jaGlsZHJlbigpLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0JCggXCI8dGQ+JiMxNjA7PC90ZD5cIiwgdGhhdC5kb2N1bWVudFsgMCBdIClcblx0XHRcdFx0LmF0dHIoIFwiY29sc3BhblwiLCAkKCB0aGlzICkuYXR0ciggXCJjb2xzcGFuXCIgKSB8fCAxIClcblx0XHRcdFx0LmFwcGVuZFRvKCB0YXJnZXRUciApO1xuXHRcdH0gKTtcblx0fSxcblxuXHRfY29udGFjdENvbnRhaW5lcnM6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR2YXIgaSwgaiwgZGlzdCwgaXRlbVdpdGhMZWFzdERpc3RhbmNlLCBwb3NQcm9wZXJ0eSwgc2l6ZVByb3BlcnR5LCBjdXIsIG5lYXJCb3R0b20sXG5cdFx0XHRmbG9hdGluZywgYXhpcyxcblx0XHRcdGlubmVybW9zdENvbnRhaW5lciA9IG51bGwsXG5cdFx0XHRpbm5lcm1vc3RJbmRleCA9IG51bGw7XG5cblx0XHQvLyBHZXQgaW5uZXJtb3N0IGNvbnRhaW5lciB0aGF0IGludGVyc2VjdHMgd2l0aCBpdGVtXG5cdFx0Zm9yICggaSA9IHRoaXMuY29udGFpbmVycy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblxuXHRcdFx0Ly8gTmV2ZXIgY29uc2lkZXIgYSBjb250YWluZXIgdGhhdCdzIGxvY2F0ZWQgd2l0aGluIHRoZSBpdGVtIGl0c2VsZlxuXHRcdFx0aWYgKCAkLmNvbnRhaW5zKCB0aGlzLmN1cnJlbnRJdGVtWyAwIF0sIHRoaXMuY29udGFpbmVyc1sgaSBdLmVsZW1lbnRbIDAgXSApICkge1xuXHRcdFx0XHRjb250aW51ZTtcblx0XHRcdH1cblxuXHRcdFx0aWYgKCB0aGlzLl9pbnRlcnNlY3RzV2l0aCggdGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUgKSApIHtcblxuXHRcdFx0XHQvLyBJZiB3ZSd2ZSBhbHJlYWR5IGZvdW5kIGEgY29udGFpbmVyIGFuZCBpdCdzIG1vcmUgXCJpbm5lclwiIHRoYW4gdGhpcywgdGhlbiBjb250aW51ZVxuXHRcdFx0XHRpZiAoIGlubmVybW9zdENvbnRhaW5lciAmJlxuXHRcdFx0XHRcdFx0JC5jb250YWlucyhcblx0XHRcdFx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uZWxlbWVudFsgMCBdLFxuXHRcdFx0XHRcdFx0XHRpbm5lcm1vc3RDb250YWluZXIuZWxlbWVudFsgMCBdICkgKSB7XG5cdFx0XHRcdFx0Y29udGludWU7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRpbm5lcm1vc3RDb250YWluZXIgPSB0aGlzLmNvbnRhaW5lcnNbIGkgXTtcblx0XHRcdFx0aW5uZXJtb3N0SW5kZXggPSBpO1xuXG5cdFx0XHR9IGVsc2Uge1xuXG5cdFx0XHRcdC8vIGNvbnRhaW5lciBkb2Vzbid0IGludGVyc2VjdC4gdHJpZ2dlciBcIm91dFwiIGV2ZW50IGlmIG5lY2Vzc2FyeVxuXHRcdFx0XHRpZiAoIHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLm92ZXIgKSB7XG5cdFx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uX3RyaWdnZXIoIFwib3V0XCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLm92ZXIgPSAwO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHR9XG5cblx0XHQvLyBJZiBubyBpbnRlcnNlY3RpbmcgY29udGFpbmVycyBmb3VuZCwgcmV0dXJuXG5cdFx0aWYgKCAhaW5uZXJtb3N0Q29udGFpbmVyICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdC8vIE1vdmUgdGhlIGl0ZW0gaW50byB0aGUgY29udGFpbmVyIGlmIGl0J3Mgbm90IHRoZXJlIGFscmVhZHlcblx0XHRpZiAoIHRoaXMuY29udGFpbmVycy5sZW5ndGggPT09IDEgKSB7XG5cdFx0XHRpZiAoICF0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uY29udGFpbmVyQ2FjaGUub3ZlciApIHtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdLl90cmlnZ2VyKCBcIm92ZXJcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5jb250YWluZXJDYWNoZS5vdmVyID0gMTtcblx0XHRcdH1cblx0XHR9IGVsc2Uge1xuXG5cdFx0XHQvLyBXaGVuIGVudGVyaW5nIGEgbmV3IGNvbnRhaW5lciwgd2Ugd2lsbCBmaW5kIHRoZSBpdGVtIHdpdGggdGhlIGxlYXN0IGRpc3RhbmNlIGFuZFxuXHRcdFx0Ly8gYXBwZW5kIG91ciBpdGVtIG5lYXIgaXRcblx0XHRcdGRpc3QgPSAxMDAwMDtcblx0XHRcdGl0ZW1XaXRoTGVhc3REaXN0YW5jZSA9IG51bGw7XG5cdFx0XHRmbG9hdGluZyA9IGlubmVybW9zdENvbnRhaW5lci5mbG9hdGluZyB8fCB0aGlzLl9pc0Zsb2F0aW5nKCB0aGlzLmN1cnJlbnRJdGVtICk7XG5cdFx0XHRwb3NQcm9wZXJ0eSA9IGZsb2F0aW5nID8gXCJsZWZ0XCIgOiBcInRvcFwiO1xuXHRcdFx0c2l6ZVByb3BlcnR5ID0gZmxvYXRpbmcgPyBcIndpZHRoXCIgOiBcImhlaWdodFwiO1xuXHRcdFx0YXhpcyA9IGZsb2F0aW5nID8gXCJwYWdlWFwiIDogXCJwYWdlWVwiO1xuXG5cdFx0XHRmb3IgKCBqID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBqID49IDA7IGotLSApIHtcblx0XHRcdFx0aWYgKCAhJC5jb250YWlucyhcblx0XHRcdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5lbGVtZW50WyAwIF0sIHRoaXMuaXRlbXNbIGogXS5pdGVtWyAwIF0gKVxuXHRcdFx0XHQpIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoIHRoaXMuaXRlbXNbIGogXS5pdGVtWyAwIF0gPT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdGN1ciA9IHRoaXMuaXRlbXNbIGogXS5pdGVtLm9mZnNldCgpWyBwb3NQcm9wZXJ0eSBdO1xuXHRcdFx0XHRuZWFyQm90dG9tID0gZmFsc2U7XG5cdFx0XHRcdGlmICggZXZlbnRbIGF4aXMgXSAtIGN1ciA+IHRoaXMuaXRlbXNbIGogXVsgc2l6ZVByb3BlcnR5IF0gLyAyICkge1xuXHRcdFx0XHRcdG5lYXJCb3R0b20gPSB0cnVlO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWYgKCBNYXRoLmFicyggZXZlbnRbIGF4aXMgXSAtIGN1ciApIDwgZGlzdCApIHtcblx0XHRcdFx0XHRkaXN0ID0gTWF0aC5hYnMoIGV2ZW50WyBheGlzIF0gLSBjdXIgKTtcblx0XHRcdFx0XHRpdGVtV2l0aExlYXN0RGlzdGFuY2UgPSB0aGlzLml0ZW1zWyBqIF07XG5cdFx0XHRcdFx0dGhpcy5kaXJlY3Rpb24gPSBuZWFyQm90dG9tID8gXCJ1cFwiIDogXCJkb3duXCI7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly9DaGVjayBpZiBkcm9wT25FbXB0eSBpcyBlbmFibGVkXG5cdFx0XHRpZiAoICFpdGVtV2l0aExlYXN0RGlzdGFuY2UgJiYgIXRoaXMub3B0aW9ucy5kcm9wT25FbXB0eSApIHtcblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIHRoaXMuY3VycmVudENvbnRhaW5lciA9PT0gdGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdICkge1xuXHRcdFx0XHRpZiAoICF0aGlzLmN1cnJlbnRDb250YWluZXIuY29udGFpbmVyQ2FjaGUub3ZlciApIHtcblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uX3RyaWdnZXIoIFwib3ZlclwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHRcdFx0XHR0aGlzLmN1cnJlbnRDb250YWluZXIuY29udGFpbmVyQ2FjaGUub3ZlciA9IDE7XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXG5cdFx0XHRpdGVtV2l0aExlYXN0RGlzdGFuY2UgP1xuXHRcdFx0XHR0aGlzLl9yZWFycmFuZ2UoIGV2ZW50LCBpdGVtV2l0aExlYXN0RGlzdGFuY2UsIG51bGwsIHRydWUgKSA6XG5cdFx0XHRcdHRoaXMuX3JlYXJyYW5nZSggZXZlbnQsIG51bGwsIHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5lbGVtZW50LCB0cnVlICk7XG5cdFx0XHR0aGlzLl90cmlnZ2VyKCBcImNoYW5nZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5fdHJpZ2dlciggXCJjaGFuZ2VcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHR0aGlzLmN1cnJlbnRDb250YWluZXIgPSB0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF07XG5cblx0XHRcdC8vVXBkYXRlIHRoZSBwbGFjZWhvbGRlclxuXHRcdFx0dGhpcy5vcHRpb25zLnBsYWNlaG9sZGVyLnVwZGF0ZSggdGhpcy5jdXJyZW50Q29udGFpbmVyLCB0aGlzLnBsYWNlaG9sZGVyICk7XG5cblx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5fdHJpZ2dlciggXCJvdmVyXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0dGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdLmNvbnRhaW5lckNhY2hlLm92ZXIgPSAxO1xuXHRcdH1cblxuXHR9LFxuXG5cdF9jcmVhdGVIZWxwZXI6IGZ1bmN0aW9uKCBldmVudCApIHtcblxuXHRcdHZhciBvID0gdGhpcy5vcHRpb25zLFxuXHRcdFx0aGVscGVyID0gJC5pc0Z1bmN0aW9uKCBvLmhlbHBlciApID9cblx0XHRcdFx0JCggby5oZWxwZXIuYXBwbHkoIHRoaXMuZWxlbWVudFsgMCBdLCBbIGV2ZW50LCB0aGlzLmN1cnJlbnRJdGVtIF0gKSApIDpcblx0XHRcdFx0KCBvLmhlbHBlciA9PT0gXCJjbG9uZVwiID8gdGhpcy5jdXJyZW50SXRlbS5jbG9uZSgpIDogdGhpcy5jdXJyZW50SXRlbSApO1xuXG5cdFx0Ly9BZGQgdGhlIGhlbHBlciB0byB0aGUgRE9NIGlmIHRoYXQgZGlkbid0IGhhcHBlbiBhbHJlYWR5XG5cdFx0aWYgKCAhaGVscGVyLnBhcmVudHMoIFwiYm9keVwiICkubGVuZ3RoICkge1xuXHRcdFx0JCggby5hcHBlbmRUbyAhPT0gXCJwYXJlbnRcIiA/XG5cdFx0XHRcdG8uYXBwZW5kVG8gOlxuXHRcdFx0XHR0aGlzLmN1cnJlbnRJdGVtWyAwIF0ucGFyZW50Tm9kZSApWyAwIF0uYXBwZW5kQ2hpbGQoIGhlbHBlclsgMCBdICk7XG5cdFx0fVxuXG5cdFx0aWYgKCBoZWxwZXJbIDAgXSA9PT0gdGhpcy5jdXJyZW50SXRlbVsgMCBdICkge1xuXHRcdFx0dGhpcy5fc3RvcmVkQ1NTID0ge1xuXHRcdFx0XHR3aWR0aDogdGhpcy5jdXJyZW50SXRlbVsgMCBdLnN0eWxlLndpZHRoLFxuXHRcdFx0XHRoZWlnaHQ6IHRoaXMuY3VycmVudEl0ZW1bIDAgXS5zdHlsZS5oZWlnaHQsXG5cdFx0XHRcdHBvc2l0aW9uOiB0aGlzLmN1cnJlbnRJdGVtLmNzcyggXCJwb3NpdGlvblwiICksXG5cdFx0XHRcdHRvcDogdGhpcy5jdXJyZW50SXRlbS5jc3MoIFwidG9wXCIgKSxcblx0XHRcdFx0bGVmdDogdGhpcy5jdXJyZW50SXRlbS5jc3MoIFwibGVmdFwiIClcblx0XHRcdH07XG5cdFx0fVxuXG5cdFx0aWYgKCAhaGVscGVyWyAwIF0uc3R5bGUud2lkdGggfHwgby5mb3JjZUhlbHBlclNpemUgKSB7XG5cdFx0XHRoZWxwZXIud2lkdGgoIHRoaXMuY3VycmVudEl0ZW0ud2lkdGgoKSApO1xuXHRcdH1cblx0XHRpZiAoICFoZWxwZXJbIDAgXS5zdHlsZS5oZWlnaHQgfHwgby5mb3JjZUhlbHBlclNpemUgKSB7XG5cdFx0XHRoZWxwZXIuaGVpZ2h0KCB0aGlzLmN1cnJlbnRJdGVtLmhlaWdodCgpICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIGhlbHBlcjtcblxuXHR9LFxuXG5cdF9hZGp1c3RPZmZzZXRGcm9tSGVscGVyOiBmdW5jdGlvbiggb2JqICkge1xuXHRcdGlmICggdHlwZW9mIG9iaiA9PT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdG9iaiA9IG9iai5zcGxpdCggXCIgXCIgKTtcblx0XHR9XG5cdFx0aWYgKCAkLmlzQXJyYXkoIG9iaiApICkge1xuXHRcdFx0b2JqID0geyBsZWZ0OiArb2JqWyAwIF0sIHRvcDogK29ialsgMSBdIHx8IDAgfTtcblx0XHR9XG5cdFx0aWYgKCBcImxlZnRcIiBpbiBvYmogKSB7XG5cdFx0XHR0aGlzLm9mZnNldC5jbGljay5sZWZ0ID0gb2JqLmxlZnQgKyB0aGlzLm1hcmdpbnMubGVmdDtcblx0XHR9XG5cdFx0aWYgKCBcInJpZ2h0XCIgaW4gb2JqICkge1xuXHRcdFx0dGhpcy5vZmZzZXQuY2xpY2subGVmdCA9IHRoaXMuaGVscGVyUHJvcG9ydGlvbnMud2lkdGggLSBvYmoucmlnaHQgKyB0aGlzLm1hcmdpbnMubGVmdDtcblx0XHR9XG5cdFx0aWYgKCBcInRvcFwiIGluIG9iaiApIHtcblx0XHRcdHRoaXMub2Zmc2V0LmNsaWNrLnRvcCA9IG9iai50b3AgKyB0aGlzLm1hcmdpbnMudG9wO1xuXHRcdH1cblx0XHRpZiAoIFwiYm90dG9tXCIgaW4gb2JqICkge1xuXHRcdFx0dGhpcy5vZmZzZXQuY2xpY2sudG9wID0gdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy5oZWlnaHQgLSBvYmouYm90dG9tICsgdGhpcy5tYXJnaW5zLnRvcDtcblx0XHR9XG5cdH0sXG5cblx0X2dldFBhcmVudE9mZnNldDogZnVuY3Rpb24oKSB7XG5cblx0XHQvL0dldCB0aGUgb2Zmc2V0UGFyZW50IGFuZCBjYWNoZSBpdHMgcG9zaXRpb25cblx0XHR0aGlzLm9mZnNldFBhcmVudCA9IHRoaXMuaGVscGVyLm9mZnNldFBhcmVudCgpO1xuXHRcdHZhciBwbyA9IHRoaXMub2Zmc2V0UGFyZW50Lm9mZnNldCgpO1xuXG5cdFx0Ly8gVGhpcyBpcyBhIHNwZWNpYWwgY2FzZSB3aGVyZSB3ZSBuZWVkIHRvIG1vZGlmeSBhIG9mZnNldCBjYWxjdWxhdGVkIG9uIHN0YXJ0LCBzaW5jZSB0aGVcblx0XHQvLyBmb2xsb3dpbmcgaGFwcGVuZWQ6XG5cdFx0Ly8gMS4gVGhlIHBvc2l0aW9uIG9mIHRoZSBoZWxwZXIgaXMgYWJzb2x1dGUsIHNvIGl0J3MgcG9zaXRpb24gaXMgY2FsY3VsYXRlZCBiYXNlZCBvbiB0aGVcblx0XHQvLyBuZXh0IHBvc2l0aW9uZWQgcGFyZW50XG5cdFx0Ly8gMi4gVGhlIGFjdHVhbCBvZmZzZXQgcGFyZW50IGlzIGEgY2hpbGQgb2YgdGhlIHNjcm9sbCBwYXJlbnQsIGFuZCB0aGUgc2Nyb2xsIHBhcmVudCBpc24ndFxuXHRcdC8vIHRoZSBkb2N1bWVudCwgd2hpY2ggbWVhbnMgdGhhdCB0aGUgc2Nyb2xsIGlzIGluY2x1ZGVkIGluIHRoZSBpbml0aWFsIGNhbGN1bGF0aW9uIG9mIHRoZVxuXHRcdC8vIG9mZnNldCBvZiB0aGUgcGFyZW50LCBhbmQgbmV2ZXIgcmVjYWxjdWxhdGVkIHVwb24gZHJhZ1xuXHRcdGlmICggdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJhYnNvbHV0ZVwiICYmIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0gIT09IHRoaXMuZG9jdW1lbnRbIDAgXSAmJlxuXHRcdFx0XHQkLmNvbnRhaW5zKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdLCB0aGlzLm9mZnNldFBhcmVudFsgMCBdICkgKSB7XG5cdFx0XHRwby5sZWZ0ICs9IHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbExlZnQoKTtcblx0XHRcdHBvLnRvcCArPSB0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxUb3AoKTtcblx0XHR9XG5cblx0XHQvLyBUaGlzIG5lZWRzIHRvIGJlIGFjdHVhbGx5IGRvbmUgZm9yIGFsbCBicm93c2Vycywgc2luY2UgcGFnZVgvcGFnZVkgaW5jbHVkZXMgdGhpc1xuXHRcdC8vIGluZm9ybWF0aW9uIHdpdGggYW4gdWdseSBJRSBmaXhcblx0XHRpZiAoIHRoaXMub2Zmc2V0UGFyZW50WyAwIF0gPT09IHRoaXMuZG9jdW1lbnRbIDAgXS5ib2R5IHx8XG5cdFx0XHRcdCggdGhpcy5vZmZzZXRQYXJlbnRbIDAgXS50YWdOYW1lICYmXG5cdFx0XHRcdHRoaXMub2Zmc2V0UGFyZW50WyAwIF0udGFnTmFtZS50b0xvd2VyQ2FzZSgpID09PSBcImh0bWxcIiAmJiAkLnVpLmllICkgKSB7XG5cdFx0XHRwbyA9IHsgdG9wOiAwLCBsZWZ0OiAwIH07XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHtcblx0XHRcdHRvcDogcG8udG9wICsgKCBwYXJzZUludCggdGhpcy5vZmZzZXRQYXJlbnQuY3NzKCBcImJvcmRlclRvcFdpZHRoXCIgKSwgMTAgKSB8fCAwICksXG5cdFx0XHRsZWZ0OiBwby5sZWZ0ICsgKCBwYXJzZUludCggdGhpcy5vZmZzZXRQYXJlbnQuY3NzKCBcImJvcmRlckxlZnRXaWR0aFwiICksIDEwICkgfHwgMCApXG5cdFx0fTtcblxuXHR9LFxuXG5cdF9nZXRSZWxhdGl2ZU9mZnNldDogZnVuY3Rpb24oKSB7XG5cblx0XHRpZiAoIHRoaXMuY3NzUG9zaXRpb24gPT09IFwicmVsYXRpdmVcIiApIHtcblx0XHRcdHZhciBwID0gdGhpcy5jdXJyZW50SXRlbS5wb3NpdGlvbigpO1xuXHRcdFx0cmV0dXJuIHtcblx0XHRcdFx0dG9wOiBwLnRvcCAtICggcGFyc2VJbnQoIHRoaXMuaGVscGVyLmNzcyggXCJ0b3BcIiApLCAxMCApIHx8IDAgKSArXG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKCksXG5cdFx0XHRcdGxlZnQ6IHAubGVmdCAtICggcGFyc2VJbnQoIHRoaXMuaGVscGVyLmNzcyggXCJsZWZ0XCIgKSwgMTAgKSB8fCAwICkgK1xuXHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbExlZnQoKVxuXHRcdFx0fTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0cmV0dXJuIHsgdG9wOiAwLCBsZWZ0OiAwIH07XG5cdFx0fVxuXG5cdH0sXG5cblx0X2NhY2hlTWFyZ2luczogZnVuY3Rpb24oKSB7XG5cdFx0dGhpcy5tYXJnaW5zID0ge1xuXHRcdFx0bGVmdDogKCBwYXJzZUludCggdGhpcy5jdXJyZW50SXRlbS5jc3MoIFwibWFyZ2luTGVmdFwiICksIDEwICkgfHwgMCApLFxuXHRcdFx0dG9wOiAoIHBhcnNlSW50KCB0aGlzLmN1cnJlbnRJdGVtLmNzcyggXCJtYXJnaW5Ub3BcIiApLCAxMCApIHx8IDAgKVxuXHRcdH07XG5cdH0sXG5cblx0X2NhY2hlSGVscGVyUHJvcG9ydGlvbnM6IGZ1bmN0aW9uKCkge1xuXHRcdHRoaXMuaGVscGVyUHJvcG9ydGlvbnMgPSB7XG5cdFx0XHR3aWR0aDogdGhpcy5oZWxwZXIub3V0ZXJXaWR0aCgpLFxuXHRcdFx0aGVpZ2h0OiB0aGlzLmhlbHBlci5vdXRlckhlaWdodCgpXG5cdFx0fTtcblx0fSxcblxuXHRfc2V0Q29udGFpbm1lbnQ6IGZ1bmN0aW9uKCkge1xuXG5cdFx0dmFyIGNlLCBjbywgb3Zlcixcblx0XHRcdG8gPSB0aGlzLm9wdGlvbnM7XG5cdFx0aWYgKCBvLmNvbnRhaW5tZW50ID09PSBcInBhcmVudFwiICkge1xuXHRcdFx0by5jb250YWlubWVudCA9IHRoaXMuaGVscGVyWyAwIF0ucGFyZW50Tm9kZTtcblx0XHR9XG5cdFx0aWYgKCBvLmNvbnRhaW5tZW50ID09PSBcImRvY3VtZW50XCIgfHwgby5jb250YWlubWVudCA9PT0gXCJ3aW5kb3dcIiApIHtcblx0XHRcdHRoaXMuY29udGFpbm1lbnQgPSBbXG5cdFx0XHRcdDAgLSB0aGlzLm9mZnNldC5yZWxhdGl2ZS5sZWZ0IC0gdGhpcy5vZmZzZXQucGFyZW50LmxlZnQsXG5cdFx0XHRcdDAgLSB0aGlzLm9mZnNldC5yZWxhdGl2ZS50b3AgLSB0aGlzLm9mZnNldC5wYXJlbnQudG9wLFxuXHRcdFx0XHRvLmNvbnRhaW5tZW50ID09PSBcImRvY3VtZW50XCIgP1xuXHRcdFx0XHRcdHRoaXMuZG9jdW1lbnQud2lkdGgoKSA6XG5cdFx0XHRcdFx0dGhpcy53aW5kb3cud2lkdGgoKSAtIHRoaXMuaGVscGVyUHJvcG9ydGlvbnMud2lkdGggLSB0aGlzLm1hcmdpbnMubGVmdCxcblx0XHRcdFx0KCBvLmNvbnRhaW5tZW50ID09PSBcImRvY3VtZW50XCIgP1xuXHRcdFx0XHRcdCggdGhpcy5kb2N1bWVudC5oZWlnaHQoKSB8fCBkb2N1bWVudC5ib2R5LnBhcmVudE5vZGUuc2Nyb2xsSGVpZ2h0ICkgOlxuXHRcdFx0XHRcdHRoaXMud2luZG93LmhlaWdodCgpIHx8IHRoaXMuZG9jdW1lbnRbIDAgXS5ib2R5LnBhcmVudE5vZGUuc2Nyb2xsSGVpZ2h0XG5cdFx0XHRcdCkgLSB0aGlzLmhlbHBlclByb3BvcnRpb25zLmhlaWdodCAtIHRoaXMubWFyZ2lucy50b3Bcblx0XHRcdF07XG5cdFx0fVxuXG5cdFx0aWYgKCAhKCAvXihkb2N1bWVudHx3aW5kb3d8cGFyZW50KSQvICkudGVzdCggby5jb250YWlubWVudCApICkge1xuXHRcdFx0Y2UgPSAkKCBvLmNvbnRhaW5tZW50IClbIDAgXTtcblx0XHRcdGNvID0gJCggby5jb250YWlubWVudCApLm9mZnNldCgpO1xuXHRcdFx0b3ZlciA9ICggJCggY2UgKS5jc3MoIFwib3ZlcmZsb3dcIiApICE9PSBcImhpZGRlblwiICk7XG5cblx0XHRcdHRoaXMuY29udGFpbm1lbnQgPSBbXG5cdFx0XHRcdGNvLmxlZnQgKyAoIHBhcnNlSW50KCAkKCBjZSApLmNzcyggXCJib3JkZXJMZWZ0V2lkdGhcIiApLCAxMCApIHx8IDAgKSArXG5cdFx0XHRcdFx0KCBwYXJzZUludCggJCggY2UgKS5jc3MoIFwicGFkZGluZ0xlZnRcIiApLCAxMCApIHx8IDAgKSAtIHRoaXMubWFyZ2lucy5sZWZ0LFxuXHRcdFx0XHRjby50b3AgKyAoIHBhcnNlSW50KCAkKCBjZSApLmNzcyggXCJib3JkZXJUb3BXaWR0aFwiICksIDEwICkgfHwgMCApICtcblx0XHRcdFx0XHQoIHBhcnNlSW50KCAkKCBjZSApLmNzcyggXCJwYWRkaW5nVG9wXCIgKSwgMTAgKSB8fCAwICkgLSB0aGlzLm1hcmdpbnMudG9wLFxuXHRcdFx0XHRjby5sZWZ0ICsgKCBvdmVyID8gTWF0aC5tYXgoIGNlLnNjcm9sbFdpZHRoLCBjZS5vZmZzZXRXaWR0aCApIDogY2Uub2Zmc2V0V2lkdGggKSAtXG5cdFx0XHRcdFx0KCBwYXJzZUludCggJCggY2UgKS5jc3MoIFwiYm9yZGVyTGVmdFdpZHRoXCIgKSwgMTAgKSB8fCAwICkgLVxuXHRcdFx0XHRcdCggcGFyc2VJbnQoICQoIGNlICkuY3NzKCBcInBhZGRpbmdSaWdodFwiICksIDEwICkgfHwgMCApIC1cblx0XHRcdFx0XHR0aGlzLmhlbHBlclByb3BvcnRpb25zLndpZHRoIC0gdGhpcy5tYXJnaW5zLmxlZnQsXG5cdFx0XHRcdGNvLnRvcCArICggb3ZlciA/IE1hdGgubWF4KCBjZS5zY3JvbGxIZWlnaHQsIGNlLm9mZnNldEhlaWdodCApIDogY2Uub2Zmc2V0SGVpZ2h0ICkgLVxuXHRcdFx0XHRcdCggcGFyc2VJbnQoICQoIGNlICkuY3NzKCBcImJvcmRlclRvcFdpZHRoXCIgKSwgMTAgKSB8fCAwICkgLVxuXHRcdFx0XHRcdCggcGFyc2VJbnQoICQoIGNlICkuY3NzKCBcInBhZGRpbmdCb3R0b21cIiApLCAxMCApIHx8IDAgKSAtXG5cdFx0XHRcdFx0dGhpcy5oZWxwZXJQcm9wb3J0aW9ucy5oZWlnaHQgLSB0aGlzLm1hcmdpbnMudG9wXG5cdFx0XHRdO1xuXHRcdH1cblxuXHR9LFxuXG5cdF9jb252ZXJ0UG9zaXRpb25UbzogZnVuY3Rpb24oIGQsIHBvcyApIHtcblxuXHRcdGlmICggIXBvcyApIHtcblx0XHRcdHBvcyA9IHRoaXMucG9zaXRpb247XG5cdFx0fVxuXHRcdHZhciBtb2QgPSBkID09PSBcImFic29sdXRlXCIgPyAxIDogLTEsXG5cdFx0XHRzY3JvbGwgPSB0aGlzLmNzc1Bvc2l0aW9uID09PSBcImFic29sdXRlXCIgJiZcblx0XHRcdFx0ISggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSAhPT0gdGhpcy5kb2N1bWVudFsgMCBdICYmXG5cdFx0XHRcdCQuY29udGFpbnMoIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0sIHRoaXMub2Zmc2V0UGFyZW50WyAwIF0gKSApID9cblx0XHRcdFx0XHR0aGlzLm9mZnNldFBhcmVudCA6XG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQsXG5cdFx0XHRzY3JvbGxJc1Jvb3ROb2RlID0gKCAvKGh0bWx8Ym9keSkvaSApLnRlc3QoIHNjcm9sbFsgMCBdLnRhZ05hbWUgKTtcblxuXHRcdHJldHVybiB7XG5cdFx0XHR0b3A6IChcblxuXHRcdFx0XHQvLyBUaGUgYWJzb2x1dGUgbW91c2UgcG9zaXRpb25cblx0XHRcdFx0cG9zLnRvcFx0K1xuXG5cdFx0XHRcdC8vIE9ubHkgZm9yIHJlbGF0aXZlIHBvc2l0aW9uZWQgbm9kZXM6IFJlbGF0aXZlIG9mZnNldCBmcm9tIGVsZW1lbnQgdG8gb2Zmc2V0IHBhcmVudFxuXHRcdFx0XHR0aGlzLm9mZnNldC5yZWxhdGl2ZS50b3AgKiBtb2QgK1xuXG5cdFx0XHRcdC8vIFRoZSBvZmZzZXRQYXJlbnQncyBvZmZzZXQgd2l0aG91dCBib3JkZXJzIChvZmZzZXQgKyBib3JkZXIpXG5cdFx0XHRcdHRoaXMub2Zmc2V0LnBhcmVudC50b3AgKiBtb2QgLVxuXHRcdFx0XHQoICggdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJmaXhlZFwiID9cblx0XHRcdFx0XHQtdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKCkgOlxuXHRcdFx0XHRcdCggc2Nyb2xsSXNSb290Tm9kZSA/IDAgOiBzY3JvbGwuc2Nyb2xsVG9wKCkgKSApICogbW9kIClcblx0XHRcdCksXG5cdFx0XHRsZWZ0OiAoXG5cblx0XHRcdFx0Ly8gVGhlIGFic29sdXRlIG1vdXNlIHBvc2l0aW9uXG5cdFx0XHRcdHBvcy5sZWZ0ICtcblxuXHRcdFx0XHQvLyBPbmx5IGZvciByZWxhdGl2ZSBwb3NpdGlvbmVkIG5vZGVzOiBSZWxhdGl2ZSBvZmZzZXQgZnJvbSBlbGVtZW50IHRvIG9mZnNldCBwYXJlbnRcblx0XHRcdFx0dGhpcy5vZmZzZXQucmVsYXRpdmUubGVmdCAqIG1vZCArXG5cblx0XHRcdFx0Ly8gVGhlIG9mZnNldFBhcmVudCdzIG9mZnNldCB3aXRob3V0IGJvcmRlcnMgKG9mZnNldCArIGJvcmRlcilcblx0XHRcdFx0dGhpcy5vZmZzZXQucGFyZW50LmxlZnQgKiBtb2RcdC1cblx0XHRcdFx0KCAoIHRoaXMuY3NzUG9zaXRpb24gPT09IFwiZml4ZWRcIiA/XG5cdFx0XHRcdFx0LXRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbExlZnQoKSA6IHNjcm9sbElzUm9vdE5vZGUgPyAwIDpcblx0XHRcdFx0XHRzY3JvbGwuc2Nyb2xsTGVmdCgpICkgKiBtb2QgKVxuXHRcdFx0KVxuXHRcdH07XG5cblx0fSxcblxuXHRfZ2VuZXJhdGVQb3NpdGlvbjogZnVuY3Rpb24oIGV2ZW50ICkge1xuXG5cdFx0dmFyIHRvcCwgbGVmdCxcblx0XHRcdG8gPSB0aGlzLm9wdGlvbnMsXG5cdFx0XHRwYWdlWCA9IGV2ZW50LnBhZ2VYLFxuXHRcdFx0cGFnZVkgPSBldmVudC5wYWdlWSxcblx0XHRcdHNjcm9sbCA9IHRoaXMuY3NzUG9zaXRpb24gPT09IFwiYWJzb2x1dGVcIiAmJlxuXHRcdFx0XHQhKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdICE9PSB0aGlzLmRvY3VtZW50WyAwIF0gJiZcblx0XHRcdFx0JC5jb250YWlucyggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSwgdGhpcy5vZmZzZXRQYXJlbnRbIDAgXSApICkgP1xuXHRcdFx0XHRcdHRoaXMub2Zmc2V0UGFyZW50IDpcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudCxcblx0XHRcdFx0c2Nyb2xsSXNSb290Tm9kZSA9ICggLyhodG1sfGJvZHkpL2kgKS50ZXN0KCBzY3JvbGxbIDAgXS50YWdOYW1lICk7XG5cblx0XHQvLyBUaGlzIGlzIGFub3RoZXIgdmVyeSB3ZWlyZCBzcGVjaWFsIGNhc2UgdGhhdCBvbmx5IGhhcHBlbnMgZm9yIHJlbGF0aXZlIGVsZW1lbnRzOlxuXHRcdC8vIDEuIElmIHRoZSBjc3MgcG9zaXRpb24gaXMgcmVsYXRpdmVcblx0XHQvLyAyLiBhbmQgdGhlIHNjcm9sbCBwYXJlbnQgaXMgdGhlIGRvY3VtZW50IG9yIHNpbWlsYXIgdG8gdGhlIG9mZnNldCBwYXJlbnRcblx0XHQvLyB3ZSBoYXZlIHRvIHJlZnJlc2ggdGhlIHJlbGF0aXZlIG9mZnNldCBkdXJpbmcgdGhlIHNjcm9sbCBzbyB0aGVyZSBhcmUgbm8ganVtcHNcblx0XHRpZiAoIHRoaXMuY3NzUG9zaXRpb24gPT09IFwicmVsYXRpdmVcIiAmJiAhKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdICE9PSB0aGlzLmRvY3VtZW50WyAwIF0gJiZcblx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXSAhPT0gdGhpcy5vZmZzZXRQYXJlbnRbIDAgXSApICkge1xuXHRcdFx0dGhpcy5vZmZzZXQucmVsYXRpdmUgPSB0aGlzLl9nZXRSZWxhdGl2ZU9mZnNldCgpO1xuXHRcdH1cblxuXHRcdC8qXG5cdFx0ICogLSBQb3NpdGlvbiBjb25zdHJhaW5pbmcgLVxuXHRcdCAqIENvbnN0cmFpbiB0aGUgcG9zaXRpb24gdG8gYSBtaXggb2YgZ3JpZCwgY29udGFpbm1lbnQuXG5cdFx0ICovXG5cblx0XHRpZiAoIHRoaXMub3JpZ2luYWxQb3NpdGlvbiApIHsgLy9JZiB3ZSBhcmUgbm90IGRyYWdnaW5nIHlldCwgd2Ugd29uJ3QgY2hlY2sgZm9yIG9wdGlvbnNcblxuXHRcdFx0aWYgKCB0aGlzLmNvbnRhaW5tZW50ICkge1xuXHRcdFx0XHRpZiAoIGV2ZW50LnBhZ2VYIC0gdGhpcy5vZmZzZXQuY2xpY2subGVmdCA8IHRoaXMuY29udGFpbm1lbnRbIDAgXSApIHtcblx0XHRcdFx0XHRwYWdlWCA9IHRoaXMuY29udGFpbm1lbnRbIDAgXSArIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQ7XG5cdFx0XHRcdH1cblx0XHRcdFx0aWYgKCBldmVudC5wYWdlWSAtIHRoaXMub2Zmc2V0LmNsaWNrLnRvcCA8IHRoaXMuY29udGFpbm1lbnRbIDEgXSApIHtcblx0XHRcdFx0XHRwYWdlWSA9IHRoaXMuY29udGFpbm1lbnRbIDEgXSArIHRoaXMub2Zmc2V0LmNsaWNrLnRvcDtcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoIGV2ZW50LnBhZ2VYIC0gdGhpcy5vZmZzZXQuY2xpY2subGVmdCA+IHRoaXMuY29udGFpbm1lbnRbIDIgXSApIHtcblx0XHRcdFx0XHRwYWdlWCA9IHRoaXMuY29udGFpbm1lbnRbIDIgXSArIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQ7XG5cdFx0XHRcdH1cblx0XHRcdFx0aWYgKCBldmVudC5wYWdlWSAtIHRoaXMub2Zmc2V0LmNsaWNrLnRvcCA+IHRoaXMuY29udGFpbm1lbnRbIDMgXSApIHtcblx0XHRcdFx0XHRwYWdlWSA9IHRoaXMuY29udGFpbm1lbnRbIDMgXSArIHRoaXMub2Zmc2V0LmNsaWNrLnRvcDtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIG8uZ3JpZCApIHtcblx0XHRcdFx0dG9wID0gdGhpcy5vcmlnaW5hbFBhZ2VZICsgTWF0aC5yb3VuZCggKCBwYWdlWSAtIHRoaXMub3JpZ2luYWxQYWdlWSApIC9cblx0XHRcdFx0XHRvLmdyaWRbIDEgXSApICogby5ncmlkWyAxIF07XG5cdFx0XHRcdHBhZ2VZID0gdGhpcy5jb250YWlubWVudCA/XG5cdFx0XHRcdFx0KCAoIHRvcCAtIHRoaXMub2Zmc2V0LmNsaWNrLnRvcCA+PSB0aGlzLmNvbnRhaW5tZW50WyAxIF0gJiZcblx0XHRcdFx0XHRcdHRvcCAtIHRoaXMub2Zmc2V0LmNsaWNrLnRvcCA8PSB0aGlzLmNvbnRhaW5tZW50WyAzIF0gKSA/XG5cdFx0XHRcdFx0XHRcdHRvcCA6XG5cdFx0XHRcdFx0XHRcdCggKCB0b3AgLSB0aGlzLm9mZnNldC5jbGljay50b3AgPj0gdGhpcy5jb250YWlubWVudFsgMSBdICkgP1xuXHRcdFx0XHRcdFx0XHRcdHRvcCAtIG8uZ3JpZFsgMSBdIDogdG9wICsgby5ncmlkWyAxIF0gKSApIDpcblx0XHRcdFx0XHRcdFx0XHR0b3A7XG5cblx0XHRcdFx0bGVmdCA9IHRoaXMub3JpZ2luYWxQYWdlWCArIE1hdGgucm91bmQoICggcGFnZVggLSB0aGlzLm9yaWdpbmFsUGFnZVggKSAvXG5cdFx0XHRcdFx0by5ncmlkWyAwIF0gKSAqIG8uZ3JpZFsgMCBdO1xuXHRcdFx0XHRwYWdlWCA9IHRoaXMuY29udGFpbm1lbnQgP1xuXHRcdFx0XHRcdCggKCBsZWZ0IC0gdGhpcy5vZmZzZXQuY2xpY2subGVmdCA+PSB0aGlzLmNvbnRhaW5tZW50WyAwIF0gJiZcblx0XHRcdFx0XHRcdGxlZnQgLSB0aGlzLm9mZnNldC5jbGljay5sZWZ0IDw9IHRoaXMuY29udGFpbm1lbnRbIDIgXSApID9cblx0XHRcdFx0XHRcdFx0bGVmdCA6XG5cdFx0XHRcdFx0XHRcdCggKCBsZWZ0IC0gdGhpcy5vZmZzZXQuY2xpY2subGVmdCA+PSB0aGlzLmNvbnRhaW5tZW50WyAwIF0gKSA/XG5cdFx0XHRcdFx0XHRcdFx0bGVmdCAtIG8uZ3JpZFsgMCBdIDogbGVmdCArIG8uZ3JpZFsgMCBdICkgKSA6XG5cdFx0XHRcdFx0XHRcdFx0bGVmdDtcblx0XHRcdH1cblxuXHRcdH1cblxuXHRcdHJldHVybiB7XG5cdFx0XHR0b3A6IChcblxuXHRcdFx0XHQvLyBUaGUgYWJzb2x1dGUgbW91c2UgcG9zaXRpb25cblx0XHRcdFx0cGFnZVkgLVxuXG5cdFx0XHRcdC8vIENsaWNrIG9mZnNldCAocmVsYXRpdmUgdG8gdGhlIGVsZW1lbnQpXG5cdFx0XHRcdHRoaXMub2Zmc2V0LmNsaWNrLnRvcCAtXG5cblx0XHRcdFx0Ly8gT25seSBmb3IgcmVsYXRpdmUgcG9zaXRpb25lZCBub2RlczogUmVsYXRpdmUgb2Zmc2V0IGZyb20gZWxlbWVudCB0byBvZmZzZXQgcGFyZW50XG5cdFx0XHRcdHRoaXMub2Zmc2V0LnJlbGF0aXZlLnRvcCAtXG5cblx0XHRcdFx0Ly8gVGhlIG9mZnNldFBhcmVudCdzIG9mZnNldCB3aXRob3V0IGJvcmRlcnMgKG9mZnNldCArIGJvcmRlcilcblx0XHRcdFx0dGhpcy5vZmZzZXQucGFyZW50LnRvcCArXG5cdFx0XHRcdCggKCB0aGlzLmNzc1Bvc2l0aW9uID09PSBcImZpeGVkXCIgP1xuXHRcdFx0XHRcdC10aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxUb3AoKSA6XG5cdFx0XHRcdFx0KCBzY3JvbGxJc1Jvb3ROb2RlID8gMCA6IHNjcm9sbC5zY3JvbGxUb3AoKSApICkgKVxuXHRcdFx0KSxcblx0XHRcdGxlZnQ6IChcblxuXHRcdFx0XHQvLyBUaGUgYWJzb2x1dGUgbW91c2UgcG9zaXRpb25cblx0XHRcdFx0cGFnZVggLVxuXG5cdFx0XHRcdC8vIENsaWNrIG9mZnNldCAocmVsYXRpdmUgdG8gdGhlIGVsZW1lbnQpXG5cdFx0XHRcdHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQgLVxuXG5cdFx0XHRcdC8vIE9ubHkgZm9yIHJlbGF0aXZlIHBvc2l0aW9uZWQgbm9kZXM6IFJlbGF0aXZlIG9mZnNldCBmcm9tIGVsZW1lbnQgdG8gb2Zmc2V0IHBhcmVudFxuXHRcdFx0XHR0aGlzLm9mZnNldC5yZWxhdGl2ZS5sZWZ0IC1cblxuXHRcdFx0XHQvLyBUaGUgb2Zmc2V0UGFyZW50J3Mgb2Zmc2V0IHdpdGhvdXQgYm9yZGVycyAob2Zmc2V0ICsgYm9yZGVyKVxuXHRcdFx0XHR0aGlzLm9mZnNldC5wYXJlbnQubGVmdCArXG5cdFx0XHRcdCggKCB0aGlzLmNzc1Bvc2l0aW9uID09PSBcImZpeGVkXCIgP1xuXHRcdFx0XHRcdC10aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxMZWZ0KCkgOlxuXHRcdFx0XHRcdHNjcm9sbElzUm9vdE5vZGUgPyAwIDogc2Nyb2xsLnNjcm9sbExlZnQoKSApIClcblx0XHRcdClcblx0XHR9O1xuXG5cdH0sXG5cblx0X3JlYXJyYW5nZTogZnVuY3Rpb24oIGV2ZW50LCBpLCBhLCBoYXJkUmVmcmVzaCApIHtcblxuXHRcdGEgPyBhWyAwIF0uYXBwZW5kQ2hpbGQoIHRoaXMucGxhY2Vob2xkZXJbIDAgXSApIDpcblx0XHRcdGkuaXRlbVsgMCBdLnBhcmVudE5vZGUuaW5zZXJ0QmVmb3JlKCB0aGlzLnBsYWNlaG9sZGVyWyAwIF0sXG5cdFx0XHRcdCggdGhpcy5kaXJlY3Rpb24gPT09IFwiZG93blwiID8gaS5pdGVtWyAwIF0gOiBpLml0ZW1bIDAgXS5uZXh0U2libGluZyApICk7XG5cblx0XHQvL1ZhcmlvdXMgdGhpbmdzIGRvbmUgaGVyZSB0byBpbXByb3ZlIHRoZSBwZXJmb3JtYW5jZTpcblx0XHQvLyAxLiB3ZSBjcmVhdGUgYSBzZXRUaW1lb3V0LCB0aGF0IGNhbGxzIHJlZnJlc2hQb3NpdGlvbnNcblx0XHQvLyAyLiBvbiB0aGUgaW5zdGFuY2UsIHdlIGhhdmUgYSBjb3VudGVyIHZhcmlhYmxlLCB0aGF0IGdldCdzIGhpZ2hlciBhZnRlciBldmVyeSBhcHBlbmRcblx0XHQvLyAzLiBvbiB0aGUgbG9jYWwgc2NvcGUsIHdlIGNvcHkgdGhlIGNvdW50ZXIgdmFyaWFibGUsIGFuZCBjaGVjayBpbiB0aGUgdGltZW91dCxcblx0XHQvLyBpZiBpdCdzIHN0aWxsIHRoZSBzYW1lXG5cdFx0Ly8gNC4gdGhpcyBsZXRzIG9ubHkgdGhlIGxhc3QgYWRkaXRpb24gdG8gdGhlIHRpbWVvdXQgc3RhY2sgdGhyb3VnaFxuXHRcdHRoaXMuY291bnRlciA9IHRoaXMuY291bnRlciA/ICsrdGhpcy5jb3VudGVyIDogMTtcblx0XHR2YXIgY291bnRlciA9IHRoaXMuY291bnRlcjtcblxuXHRcdHRoaXMuX2RlbGF5KCBmdW5jdGlvbigpIHtcblx0XHRcdGlmICggY291bnRlciA9PT0gdGhpcy5jb3VudGVyICkge1xuXG5cdFx0XHRcdC8vUHJlY29tcHV0ZSBhZnRlciBlYWNoIERPTSBpbnNlcnRpb24sIE5PVCBvbiBtb3VzZW1vdmVcblx0XHRcdFx0dGhpcy5yZWZyZXNoUG9zaXRpb25zKCAhaGFyZFJlZnJlc2ggKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cblx0fSxcblxuXHRfY2xlYXI6IGZ1bmN0aW9uKCBldmVudCwgbm9Qcm9wYWdhdGlvbiApIHtcblxuXHRcdHRoaXMucmV2ZXJ0aW5nID0gZmFsc2U7XG5cblx0XHQvLyBXZSBkZWxheSBhbGwgZXZlbnRzIHRoYXQgaGF2ZSB0byBiZSB0cmlnZ2VyZWQgdG8gYWZ0ZXIgdGhlIHBvaW50IHdoZXJlIHRoZSBwbGFjZWhvbGRlclxuXHRcdC8vIGhhcyBiZWVuIHJlbW92ZWQgYW5kIGV2ZXJ5dGhpbmcgZWxzZSBub3JtYWxpemVkIGFnYWluXG5cdFx0dmFyIGksXG5cdFx0XHRkZWxheWVkVHJpZ2dlcnMgPSBbXTtcblxuXHRcdC8vIFdlIGZpcnN0IGhhdmUgdG8gdXBkYXRlIHRoZSBkb20gcG9zaXRpb24gb2YgdGhlIGFjdHVhbCBjdXJyZW50SXRlbVxuXHRcdC8vIE5vdGU6IGRvbid0IGRvIGl0IGlmIHRoZSBjdXJyZW50IGl0ZW0gaXMgYWxyZWFkeSByZW1vdmVkIChieSBhIHVzZXIpLCBvciBpdCBnZXRzXG5cdFx0Ly8gcmVhcHBlbmRlZCAoc2VlICM0MDg4KVxuXHRcdGlmICggIXRoaXMuX25vRmluYWxTb3J0ICYmIHRoaXMuY3VycmVudEl0ZW0ucGFyZW50KCkubGVuZ3RoICkge1xuXHRcdFx0dGhpcy5wbGFjZWhvbGRlci5iZWZvcmUoIHRoaXMuY3VycmVudEl0ZW0gKTtcblx0XHR9XG5cdFx0dGhpcy5fbm9GaW5hbFNvcnQgPSBudWxsO1xuXG5cdFx0aWYgKCB0aGlzLmhlbHBlclsgMCBdID09PSB0aGlzLmN1cnJlbnRJdGVtWyAwIF0gKSB7XG5cdFx0XHRmb3IgKCBpIGluIHRoaXMuX3N0b3JlZENTUyApIHtcblx0XHRcdFx0aWYgKCB0aGlzLl9zdG9yZWRDU1NbIGkgXSA9PT0gXCJhdXRvXCIgfHwgdGhpcy5fc3RvcmVkQ1NTWyBpIF0gPT09IFwic3RhdGljXCIgKSB7XG5cdFx0XHRcdFx0dGhpcy5fc3RvcmVkQ1NTWyBpIF0gPSBcIlwiO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XHR0aGlzLmN1cnJlbnRJdGVtLmNzcyggdGhpcy5fc3RvcmVkQ1NTICk7XG5cdFx0XHR0aGlzLl9yZW1vdmVDbGFzcyggdGhpcy5jdXJyZW50SXRlbSwgXCJ1aS1zb3J0YWJsZS1oZWxwZXJcIiApO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHR0aGlzLmN1cnJlbnRJdGVtLnNob3coKTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMuZnJvbU91dHNpZGUgJiYgIW5vUHJvcGFnYXRpb24gKSB7XG5cdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKCBcInJlY2VpdmVcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCggdGhpcy5mcm9tT3V0c2lkZSApICk7XG5cdFx0XHR9ICk7XG5cdFx0fVxuXHRcdGlmICggKCB0aGlzLmZyb21PdXRzaWRlIHx8XG5cdFx0XHRcdHRoaXMuZG9tUG9zaXRpb24ucHJldiAhPT1cblx0XHRcdFx0dGhpcy5jdXJyZW50SXRlbS5wcmV2KCkubm90KCBcIi51aS1zb3J0YWJsZS1oZWxwZXJcIiApWyAwIF0gfHxcblx0XHRcdFx0dGhpcy5kb21Qb3NpdGlvbi5wYXJlbnQgIT09IHRoaXMuY3VycmVudEl0ZW0ucGFyZW50KClbIDAgXSApICYmICFub1Byb3BhZ2F0aW9uICkge1xuXG5cdFx0XHQvLyBUcmlnZ2VyIHVwZGF0ZSBjYWxsYmFjayBpZiB0aGUgRE9NIHBvc2l0aW9uIGhhcyBjaGFuZ2VkXG5cdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKCBcInVwZGF0ZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHQvLyBDaGVjayBpZiB0aGUgaXRlbXMgQ29udGFpbmVyIGhhcyBDaGFuZ2VkIGFuZCB0cmlnZ2VyIGFwcHJvcHJpYXRlXG5cdFx0Ly8gZXZlbnRzLlxuXHRcdGlmICggdGhpcyAhPT0gdGhpcy5jdXJyZW50Q29udGFpbmVyICkge1xuXHRcdFx0aWYgKCAhbm9Qcm9wYWdhdGlvbiApIHtcblx0XHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0XHR0aGlzLl90cmlnZ2VyKCBcInJlbW92ZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHRcdFx0fSApO1xuXHRcdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggKCBmdW5jdGlvbiggYyApIHtcblx0XHRcdFx0XHRyZXR1cm4gZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHRcdFx0Yy5fdHJpZ2dlciggXCJyZWNlaXZlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0XHRcdH07XG5cdFx0XHRcdH0gKS5jYWxsKCB0aGlzLCB0aGlzLmN1cnJlbnRDb250YWluZXIgKSApO1xuXHRcdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggKCBmdW5jdGlvbiggYyApIHtcblx0XHRcdFx0XHRyZXR1cm4gZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHRcdFx0Yy5fdHJpZ2dlciggXCJ1cGRhdGVcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHRcdFx0fTtcblx0XHRcdFx0fSApLmNhbGwoIHRoaXMsIHRoaXMuY3VycmVudENvbnRhaW5lciApICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly9Qb3N0IGV2ZW50cyB0byBjb250YWluZXJzXG5cdFx0ZnVuY3Rpb24gZGVsYXlFdmVudCggdHlwZSwgaW5zdGFuY2UsIGNvbnRhaW5lciApIHtcblx0XHRcdHJldHVybiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdGNvbnRhaW5lci5fdHJpZ2dlciggdHlwZSwgZXZlbnQsIGluc3RhbmNlLl91aUhhc2goIGluc3RhbmNlICkgKTtcblx0XHRcdH07XG5cdFx0fVxuXHRcdGZvciAoIGkgPSB0aGlzLmNvbnRhaW5lcnMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHRpZiAoICFub1Byb3BhZ2F0aW9uICkge1xuXHRcdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggZGVsYXlFdmVudCggXCJkZWFjdGl2YXRlXCIsIHRoaXMsIHRoaXMuY29udGFpbmVyc1sgaSBdICkgKTtcblx0XHRcdH1cblx0XHRcdGlmICggdGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUub3ZlciApIHtcblx0XHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goIGRlbGF5RXZlbnQoIFwib3V0XCIsIHRoaXMsIHRoaXMuY29udGFpbmVyc1sgaSBdICkgKTtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUub3ZlciA9IDA7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly9EbyB3aGF0IHdhcyBvcmlnaW5hbGx5IGluIHBsdWdpbnNcblx0XHRpZiAoIHRoaXMuc3RvcmVkQ3Vyc29yICkge1xuXHRcdFx0dGhpcy5kb2N1bWVudC5maW5kKCBcImJvZHlcIiApLmNzcyggXCJjdXJzb3JcIiwgdGhpcy5zdG9yZWRDdXJzb3IgKTtcblx0XHRcdHRoaXMuc3RvcmVkU3R5bGVzaGVldC5yZW1vdmUoKTtcblx0XHR9XG5cdFx0aWYgKCB0aGlzLl9zdG9yZWRPcGFjaXR5ICkge1xuXHRcdFx0dGhpcy5oZWxwZXIuY3NzKCBcIm9wYWNpdHlcIiwgdGhpcy5fc3RvcmVkT3BhY2l0eSApO1xuXHRcdH1cblx0XHRpZiAoIHRoaXMuX3N0b3JlZFpJbmRleCApIHtcblx0XHRcdHRoaXMuaGVscGVyLmNzcyggXCJ6SW5kZXhcIiwgdGhpcy5fc3RvcmVkWkluZGV4ID09PSBcImF1dG9cIiA/IFwiXCIgOiB0aGlzLl9zdG9yZWRaSW5kZXggKTtcblx0XHR9XG5cblx0XHR0aGlzLmRyYWdnaW5nID0gZmFsc2U7XG5cblx0XHRpZiAoICFub1Byb3BhZ2F0aW9uICkge1xuXHRcdFx0dGhpcy5fdHJpZ2dlciggXCJiZWZvcmVTdG9wXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSApO1xuXHRcdH1cblxuXHRcdC8vJCh0aGlzLnBsYWNlaG9sZGVyWzBdKS5yZW1vdmUoKTsgd291bGQgaGF2ZSBiZWVuIHRoZSBqUXVlcnkgd2F5IC0gdW5mb3J0dW5hdGVseSxcblx0XHQvLyBpdCB1bmJpbmRzIEFMTCBldmVudHMgZnJvbSB0aGUgb3JpZ2luYWwgbm9kZSFcblx0XHR0aGlzLnBsYWNlaG9sZGVyWyAwIF0ucGFyZW50Tm9kZS5yZW1vdmVDaGlsZCggdGhpcy5wbGFjZWhvbGRlclsgMCBdICk7XG5cblx0XHRpZiAoICF0aGlzLmNhbmNlbEhlbHBlclJlbW92YWwgKSB7XG5cdFx0XHRpZiAoIHRoaXMuaGVscGVyWyAwIF0gIT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdFx0dGhpcy5oZWxwZXIucmVtb3ZlKCk7XG5cdFx0XHR9XG5cdFx0XHR0aGlzLmhlbHBlciA9IG51bGw7XG5cdFx0fVxuXG5cdFx0aWYgKCAhbm9Qcm9wYWdhdGlvbiApIHtcblx0XHRcdGZvciAoIGkgPSAwOyBpIDwgZGVsYXllZFRyaWdnZXJzLmxlbmd0aDsgaSsrICkge1xuXG5cdFx0XHRcdC8vIFRyaWdnZXIgYWxsIGRlbGF5ZWQgZXZlbnRzXG5cdFx0XHRcdGRlbGF5ZWRUcmlnZ2Vyc1sgaSBdLmNhbGwoIHRoaXMsIGV2ZW50ICk7XG5cdFx0XHR9XG5cdFx0XHR0aGlzLl90cmlnZ2VyKCBcInN0b3BcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cdFx0fVxuXG5cdFx0dGhpcy5mcm9tT3V0c2lkZSA9IGZhbHNlO1xuXHRcdHJldHVybiAhdGhpcy5jYW5jZWxIZWxwZXJSZW1vdmFsO1xuXG5cdH0sXG5cblx0X3RyaWdnZXI6IGZ1bmN0aW9uKCkge1xuXHRcdGlmICggJC5XaWRnZXQucHJvdG90eXBlLl90cmlnZ2VyLmFwcGx5KCB0aGlzLCBhcmd1bWVudHMgKSA9PT0gZmFsc2UgKSB7XG5cdFx0XHR0aGlzLmNhbmNlbCgpO1xuXHRcdH1cblx0fSxcblxuXHRfdWlIYXNoOiBmdW5jdGlvbiggX2luc3QgKSB7XG5cdFx0dmFyIGluc3QgPSBfaW5zdCB8fCB0aGlzO1xuXHRcdHJldHVybiB7XG5cdFx0XHRoZWxwZXI6IGluc3QuaGVscGVyLFxuXHRcdFx0cGxhY2Vob2xkZXI6IGluc3QucGxhY2Vob2xkZXIgfHwgJCggW10gKSxcblx0XHRcdHBvc2l0aW9uOiBpbnN0LnBvc2l0aW9uLFxuXHRcdFx0b3JpZ2luYWxQb3NpdGlvbjogaW5zdC5vcmlnaW5hbFBvc2l0aW9uLFxuXHRcdFx0b2Zmc2V0OiBpbnN0LnBvc2l0aW9uQWJzLFxuXHRcdFx0aXRlbTogaW5zdC5jdXJyZW50SXRlbSxcblx0XHRcdHNlbmRlcjogX2luc3QgPyBfaW5zdC5lbGVtZW50IDogbnVsbFxuXHRcdH07XG5cdH1cblxufSApO1xuXG59ICkgKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTcpOyIsIi8qXG4gKiBqUXVlcnkgVUkgTmVzdGVkIFNvcnRhYmxlXG4gKiB2IDIuMWEgLyAyMDE2LTAyLTA0XG4gKiBodHRwczovL2dpdGh1Yi5jb20vaWxpa2Vud2YvbmVzdGVkU29ydGFibGVcbiAqXG4gKiBEZXBlbmRzIG9uOlxuICpcdCBqcXVlcnkudWkuc29ydGFibGUuanMgMS4xMCtcbiAqXG4gKiBDb3B5cmlnaHQgKGMpIDIwMTAtMjAxNiBNYW51ZWxlIEogU2FyZmF0dGkgYW5kIGNvbnRyaWJ1dG9yc1xuICogTGljZW5zZWQgdW5kZXIgdGhlIE1JVCBMaWNlbnNlXG4gKiBodHRwOi8vd3d3Lm9wZW5zb3VyY2Uub3JnL2xpY2Vuc2VzL21pdC1saWNlbnNlLnBocFxuICovXG4oZnVuY3Rpb24oIGZhY3RvcnkgKSB7XG5cdFwidXNlIHN0cmljdFwiO1xuXG5cdGlmICggdHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQgKSB7XG5cblx0XHQvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG5cdFx0ZGVmaW5lKFtcblx0XHRcdFwianF1ZXJ5XCIsXG5cdFx0XHRcImpxdWVyeS11aS9zb3J0YWJsZVwiXG5cdFx0XSwgZmFjdG9yeSApO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gQnJvd3NlciBnbG9iYWxzXG5cdFx0ZmFjdG9yeSggd2luZG93LmpRdWVyeSApO1xuXHR9XG59KGZ1bmN0aW9uKCQpIHtcblx0XCJ1c2Ugc3RyaWN0XCI7XG5cblx0ZnVuY3Rpb24gaXNPdmVyQXhpcyggeCwgcmVmZXJlbmNlLCBzaXplICkge1xuXHRcdHJldHVybiAoIHggPiByZWZlcmVuY2UgKSAmJiAoIHggPCAoIHJlZmVyZW5jZSArIHNpemUgKSApO1xuXHR9XG5cblx0JC53aWRnZXQoXCJtanMubmVzdGVkU29ydGFibGVcIiwgJC5leHRlbmQoe30sICQudWkuc29ydGFibGUucHJvdG90eXBlLCB7XG5cblx0XHRvcHRpb25zOiB7XG5cdFx0XHRkaXNhYmxlUGFyZW50Q2hhbmdlOiBmYWxzZSxcblx0XHRcdGRvTm90Q2xlYXI6IGZhbHNlLFxuXHRcdFx0ZXhwYW5kT25Ib3ZlcjogNzAwLFxuXHRcdFx0aXNBbGxvd2VkOiBmdW5jdGlvbigpIHsgcmV0dXJuIHRydWU7IH0sXG5cdFx0XHRpc1RyZWU6IGZhbHNlLFxuXHRcdFx0bGlzdFR5cGU6IFwib2xcIixcblx0XHRcdG1heExldmVsczogMCxcblx0XHRcdHByb3RlY3RSb290OiBmYWxzZSxcblx0XHRcdHJvb3RJRDogbnVsbCxcblx0XHRcdHJ0bDogZmFsc2UsXG5cdFx0XHRzdGFydENvbGxhcHNlZDogZmFsc2UsXG5cdFx0XHR0YWJTaXplOiAyMCxcblxuXHRcdFx0YnJhbmNoQ2xhc3M6IFwibWpzLW5lc3RlZFNvcnRhYmxlLWJyYW5jaFwiLFxuXHRcdFx0Y29sbGFwc2VkQ2xhc3M6IFwibWpzLW5lc3RlZFNvcnRhYmxlLWNvbGxhcHNlZFwiLFxuXHRcdFx0ZGlzYWJsZU5lc3RpbmdDbGFzczogXCJtanMtbmVzdGVkU29ydGFibGUtbm8tbmVzdGluZ1wiLFxuXHRcdFx0ZXJyb3JDbGFzczogXCJtanMtbmVzdGVkU29ydGFibGUtZXJyb3JcIixcblx0XHRcdGV4cGFuZGVkQ2xhc3M6IFwibWpzLW5lc3RlZFNvcnRhYmxlLWV4cGFuZGVkXCIsXG5cdFx0XHRob3ZlcmluZ0NsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1ob3ZlcmluZ1wiLFxuXHRcdFx0bGVhZkNsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1sZWFmXCIsXG5cdFx0XHRkaXNhYmxlZENsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1kaXNhYmxlZFwiXG5cdFx0fSxcblxuXHRcdF9jcmVhdGU6IGZ1bmN0aW9uKCkge1xuXHRcdFx0dmFyIHNlbGYgPSB0aGlzLFxuXHRcdFx0XHRlcnI7XG5cblx0XHRcdHRoaXMuZWxlbWVudC5kYXRhKFwidWktc29ydGFibGVcIiwgdGhpcy5lbGVtZW50LmRhdGEoXCJtanMtbmVzdGVkU29ydGFibGVcIikpO1xuXG5cdFx0XHQvLyBtanMgLSBwcmV2ZW50IGJyb3dzZXIgZnJvbSBmcmVlemluZyBpZiB0aGUgSFRNTCBpcyBub3QgY29ycmVjdFxuXHRcdFx0aWYgKCF0aGlzLmVsZW1lbnQuaXModGhpcy5vcHRpb25zLmxpc3RUeXBlKSkge1xuXHRcdFx0XHRlcnIgPSBcIm5lc3RlZFNvcnRhYmxlOiBcIiArXG5cdFx0XHRcdFx0XCJQbGVhc2UgY2hlY2sgdGhhdCB0aGUgbGlzdFR5cGUgb3B0aW9uIGlzIHNldCB0byB5b3VyIGFjdHVhbCBsaXN0IHR5cGVcIjtcblxuXHRcdFx0XHR0aHJvdyBuZXcgRXJyb3IoZXJyKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gaWYgd2UgaGF2ZSBhIHRyZWUgd2l0aCBleHBhbmRpbmcvY29sbGFwc2luZyBmdW5jdGlvbmFsaXR5LFxuXHRcdFx0Ly8gZm9yY2UgJ2ludGVyc2VjdCcgdG9sZXJhbmNlIG1ldGhvZFxuXHRcdFx0aWYgKHRoaXMub3B0aW9ucy5pc1RyZWUgJiYgdGhpcy5vcHRpb25zLmV4cGFuZE9uSG92ZXIpIHtcblx0XHRcdFx0dGhpcy5vcHRpb25zLnRvbGVyYW5jZSA9IFwiaW50ZXJzZWN0XCI7XG5cdFx0XHR9XG5cblx0XHRcdCQudWkuc29ydGFibGUucHJvdG90eXBlLl9jcmVhdGUuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcblxuXHRcdFx0Ly8gcHJlcGFyZSB0aGUgdHJlZSBieSBhcHBseWluZyB0aGUgcmlnaHQgY2xhc3Nlc1xuXHRcdFx0Ly8gKHRoZSBDU1MgaXMgcmVzcG9uc2libGUgZm9yIGFjdHVhbCBoaWRlL3Nob3cgZnVuY3Rpb25hbGl0eSlcblx0XHRcdGlmICh0aGlzLm9wdGlvbnMuaXNUcmVlKSB7XG5cdFx0XHRcdCQodGhpcy5pdGVtcykuZWFjaChmdW5jdGlvbigpIHtcblx0XHRcdFx0XHR2YXIgJGxpID0gdGhpcy5pdGVtLFxuXHRcdFx0XHRcdFx0aGFzQ29sbGFwc2VkQ2xhc3MgPSAkbGkuaGFzQ2xhc3Moc2VsZi5vcHRpb25zLmNvbGxhcHNlZENsYXNzKSxcblx0XHRcdFx0XHRcdGhhc0V4cGFuZGVkQ2xhc3MgPSAkbGkuaGFzQ2xhc3Moc2VsZi5vcHRpb25zLmV4cGFuZGVkQ2xhc3MpO1xuXG5cdFx0XHRcdFx0aWYgKCRsaS5jaGlsZHJlbihzZWxmLm9wdGlvbnMubGlzdFR5cGUpLmxlbmd0aCkge1xuXHRcdFx0XHRcdFx0JGxpLmFkZENsYXNzKHNlbGYub3B0aW9ucy5icmFuY2hDbGFzcyk7XG5cdFx0XHRcdFx0XHQvLyBleHBhbmQvY29sbGFwc2UgY2xhc3Mgb25seSBpZiB0aGV5IGhhdmUgY2hpbGRyZW5cblxuXHRcdFx0XHRcdFx0aWYgKCAhaGFzQ29sbGFwc2VkQ2xhc3MgJiYgIWhhc0V4cGFuZGVkQ2xhc3MgKSB7XG5cdFx0XHRcdFx0XHRcdGlmIChzZWxmLm9wdGlvbnMuc3RhcnRDb2xsYXBzZWQpIHtcblx0XHRcdFx0XHRcdFx0XHQkbGkuYWRkQ2xhc3Moc2VsZi5vcHRpb25zLmNvbGxhcHNlZENsYXNzKTtcblx0XHRcdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdFx0XHQkbGkuYWRkQ2xhc3Moc2VsZi5vcHRpb25zLmV4cGFuZGVkQ2xhc3MpO1xuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdCRsaS5hZGRDbGFzcyhzZWxmLm9wdGlvbnMubGVhZkNsYXNzKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0pO1xuXHRcdFx0fVxuXHRcdH0sXG5cblx0XHRfZGVzdHJveTogZnVuY3Rpb24oKSB7XG5cdFx0XHR0aGlzLmVsZW1lbnRcblx0XHRcdFx0LnJlbW92ZURhdGEoXCJtanMtbmVzdGVkU29ydGFibGVcIilcblx0XHRcdFx0LnJlbW92ZURhdGEoXCJ1aS1zb3J0YWJsZVwiKTtcblx0XHRcdHJldHVybiAkLnVpLnNvcnRhYmxlLnByb3RvdHlwZS5fZGVzdHJveS5hcHBseSh0aGlzLCBhcmd1bWVudHMpO1xuXHRcdH0sXG5cblx0XHRfbW91c2VEcmFnOiBmdW5jdGlvbihldmVudCkge1xuXHRcdFx0dmFyIGksXG5cdFx0XHRcdGl0ZW0sXG5cdFx0XHRcdGl0ZW1FbGVtZW50LFxuXHRcdFx0XHRpbnRlcnNlY3Rpb24sXG5cdFx0XHRcdHNlbGYgPSB0aGlzLFxuXHRcdFx0XHRvID0gdGhpcy5vcHRpb25zLFxuXHRcdFx0XHRzY3JvbGxlZCA9IGZhbHNlLFxuXHRcdFx0XHQkZG9jdW1lbnQgPSAkKGRvY3VtZW50KSxcblx0XHRcdFx0cHJldmlvdXNUb3BPZmZzZXQsXG5cdFx0XHRcdHBhcmVudEl0ZW0sXG5cdFx0XHRcdGxldmVsLFxuXHRcdFx0XHRjaGlsZExldmVscyxcblx0XHRcdFx0aXRlbUFmdGVyLFxuXHRcdFx0XHRpdGVtQmVmb3JlLFxuXHRcdFx0XHRuZXdMaXN0LFxuXHRcdFx0XHRtZXRob2QsXG5cdFx0XHRcdGEsXG5cdFx0XHRcdHByZXZpb3VzSXRlbSxcblx0XHRcdFx0bmV4dEl0ZW0sXG5cdFx0XHRcdGhlbHBlcklzTm90U2libGluZztcblxuXHRcdFx0Ly9Db21wdXRlIHRoZSBoZWxwZXJzIHBvc2l0aW9uXG5cdFx0XHR0aGlzLnBvc2l0aW9uID0gdGhpcy5fZ2VuZXJhdGVQb3NpdGlvbihldmVudCk7XG5cdFx0XHR0aGlzLnBvc2l0aW9uQWJzID0gdGhpcy5fY29udmVydFBvc2l0aW9uVG8oXCJhYnNvbHV0ZVwiKTtcblxuXHRcdFx0aWYgKCF0aGlzLmxhc3RQb3NpdGlvbkFicykge1xuXHRcdFx0XHR0aGlzLmxhc3RQb3NpdGlvbkFicyA9IHRoaXMucG9zaXRpb25BYnM7XG5cdFx0XHR9XG5cblx0XHRcdC8vRG8gc2Nyb2xsaW5nXG5cdFx0XHRpZiAodGhpcy5vcHRpb25zLnNjcm9sbCkge1xuXHRcdFx0XHRpZiAodGhpcy5zY3JvbGxQYXJlbnRbMF0gIT09IGRvY3VtZW50ICYmIHRoaXMuc2Nyb2xsUGFyZW50WzBdLnRhZ05hbWUgIT09IFwiSFRNTFwiKSB7XG5cblx0XHRcdFx0XHRpZiAoXG5cdFx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHRcdHRoaXMub3ZlcmZsb3dPZmZzZXQudG9wICtcblx0XHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbMF0ub2Zmc2V0SGVpZ2h0XG5cdFx0XHRcdFx0XHQpIC1cblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VZIDxcblx0XHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHlcblx0XHRcdFx0XHQpIHtcblx0XHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKCkgKyBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9IGVsc2UgaWYgKFxuXHRcdFx0XHRcdFx0ZXZlbnQucGFnZVkgLVxuXHRcdFx0XHRcdFx0dGhpcy5vdmVyZmxvd09mZnNldC50b3AgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxUb3AoKSAtIG8uc2Nyb2xsU3BlZWQ7XG5cdFx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxUb3Aoc2Nyb2xsZWQpO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdGlmIChcblx0XHRcdFx0XHRcdChcblx0XHRcdFx0XHRcdFx0dGhpcy5vdmVyZmxvd09mZnNldC5sZWZ0ICtcblx0XHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbMF0ub2Zmc2V0V2lkdGhcblx0XHRcdFx0XHRcdCkgLVxuXHRcdFx0XHRcdFx0ZXZlbnQucGFnZVggPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxMZWZ0KCkgKyBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdChzY3JvbGxlZCk7XG5cdFx0XHRcdFx0fSBlbHNlIGlmIChcblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VYIC1cblx0XHRcdFx0XHRcdHRoaXMub3ZlcmZsb3dPZmZzZXQubGVmdCA8XG5cdFx0XHRcdFx0XHRvLnNjcm9sbFNlbnNpdGl2aXR5XG5cdFx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0XHRzY3JvbGxlZCA9IHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbExlZnQoKSAtIG8uc2Nyb2xsU3BlZWQ7XG5cdFx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxMZWZ0KHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0fSBlbHNlIHtcblxuXHRcdFx0XHRcdGlmIChcblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VZIC1cblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxUb3AoKSA8XG5cdFx0XHRcdFx0XHRvLnNjcm9sbFNlbnNpdGl2aXR5XG5cdFx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0XHRzY3JvbGxlZCA9ICRkb2N1bWVudC5zY3JvbGxUb3AoKSAtIG8uc2Nyb2xsU3BlZWQ7XG5cdFx0XHRcdFx0XHQkZG9jdW1lbnQuc2Nyb2xsVG9wKHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9IGVsc2UgaWYgKFxuXHRcdFx0XHRcdFx0JCh3aW5kb3cpLmhlaWdodCgpIC1cblx0XHRcdFx0XHRcdChcblx0XHRcdFx0XHRcdFx0ZXZlbnQucGFnZVkgLVxuXHRcdFx0XHRcdFx0XHQkZG9jdW1lbnQuc2Nyb2xsVG9wKClcblx0XHRcdFx0XHRcdCkgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSAkZG9jdW1lbnQuc2Nyb2xsVG9wKCkgKyBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbFRvcChzY3JvbGxlZCk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0aWYgKFxuXHRcdFx0XHRcdFx0ZXZlbnQucGFnZVggLVxuXHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbExlZnQoKSA8XG5cdFx0XHRcdFx0XHRvLnNjcm9sbFNlbnNpdGl2aXR5XG5cdFx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0XHRzY3JvbGxlZCA9ICRkb2N1bWVudC5zY3JvbGxMZWZ0KCkgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbExlZnQoc2Nyb2xsZWQpO1xuXHRcdFx0XHRcdH0gZWxzZSBpZiAoXG5cdFx0XHRcdFx0XHQkKHdpbmRvdykud2lkdGgoKSAtXG5cdFx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VYIC1cblx0XHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbExlZnQoKVxuXHRcdFx0XHRcdFx0KSA8XG5cdFx0XHRcdFx0XHRvLnNjcm9sbFNlbnNpdGl2aXR5XG5cdFx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0XHRzY3JvbGxlZCA9ICRkb2N1bWVudC5zY3JvbGxMZWZ0KCkgKyBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbExlZnQoc2Nyb2xsZWQpO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWYgKHNjcm9sbGVkICE9PSBmYWxzZSAmJiAkLnVpLmRkbWFuYWdlciAmJiAhby5kcm9wQmVoYXZpb3VyKSB7XG5cdFx0XHRcdFx0JC51aS5kZG1hbmFnZXIucHJlcGFyZU9mZnNldHModGhpcywgZXZlbnQpO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdC8vUmVnZW5lcmF0ZSB0aGUgYWJzb2x1dGUgcG9zaXRpb24gdXNlZCBmb3IgcG9zaXRpb24gY2hlY2tzXG5cdFx0XHR0aGlzLnBvc2l0aW9uQWJzID0gdGhpcy5fY29udmVydFBvc2l0aW9uVG8oXCJhYnNvbHV0ZVwiKTtcblxuXHRcdFx0Ly8gbWpzIC0gZmluZCB0aGUgdG9wIG9mZnNldCBiZWZvcmUgcmVhcnJhbmdlbWVudCxcblx0XHRcdHByZXZpb3VzVG9wT2Zmc2V0ID0gdGhpcy5wbGFjZWhvbGRlci5vZmZzZXQoKS50b3A7XG5cblx0XHRcdC8vU2V0IHRoZSBoZWxwZXIgcG9zaXRpb25cblx0XHRcdGlmICghdGhpcy5vcHRpb25zLmF4aXMgfHwgdGhpcy5vcHRpb25zLmF4aXMgIT09IFwieVwiKSB7XG5cdFx0XHRcdHRoaXMuaGVscGVyWzBdLnN0eWxlLmxlZnQgPSB0aGlzLnBvc2l0aW9uLmxlZnQgKyBcInB4XCI7XG5cdFx0XHR9XG5cdFx0XHRpZiAoIXRoaXMub3B0aW9ucy5heGlzIHx8IHRoaXMub3B0aW9ucy5heGlzICE9PSBcInhcIikge1xuXHRcdFx0XHR0aGlzLmhlbHBlclswXS5zdHlsZS50b3AgPSAodGhpcy5wb3NpdGlvbi50b3ApICsgXCJweFwiO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBtanMgLSBjaGVjayBhbmQgcmVzZXQgaG92ZXJpbmcgc3RhdGUgYXQgZWFjaCBjeWNsZVxuXHRcdFx0dGhpcy5ob3ZlcmluZyA9IHRoaXMuaG92ZXJpbmcgPyB0aGlzLmhvdmVyaW5nIDogbnVsbDtcblx0XHRcdHRoaXMubW91c2VlbnRlcmVkID0gdGhpcy5tb3VzZWVudGVyZWQgPyB0aGlzLm1vdXNlZW50ZXJlZCA6IGZhbHNlO1xuXG5cdFx0XHQvLyBtanMgLSBsZXQncyBzdGFydCBjYWNoaW5nIHNvbWUgdmFyaWFibGVzXG5cdFx0XHQoZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHZhciBfcGFyZW50SXRlbSA9IHRoaXMucGxhY2Vob2xkZXIucGFyZW50KCkucGFyZW50KCk7XG5cdFx0XHRcdGlmIChfcGFyZW50SXRlbSAmJiBfcGFyZW50SXRlbS5jbG9zZXN0KFwiLnVpLXNvcnRhYmxlXCIpLmxlbmd0aCkge1xuXHRcdFx0XHRcdHBhcmVudEl0ZW0gPSBfcGFyZW50SXRlbTtcblx0XHRcdFx0fVxuXHRcdFx0fS5jYWxsKHRoaXMpKTtcblxuXHRcdFx0bGV2ZWwgPSB0aGlzLl9nZXRMZXZlbCh0aGlzLnBsYWNlaG9sZGVyKTtcblx0XHRcdGNoaWxkTGV2ZWxzID0gdGhpcy5fZ2V0Q2hpbGRMZXZlbHModGhpcy5oZWxwZXIpO1xuXHRcdFx0bmV3TGlzdCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoby5saXN0VHlwZSk7XG5cblx0XHRcdC8vUmVhcnJhbmdlXG5cdFx0XHRmb3IgKGkgPSB0aGlzLml0ZW1zLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tKSB7XG5cblx0XHRcdFx0Ly9DYWNoZSB2YXJpYWJsZXMgYW5kIGludGVyc2VjdGlvbiwgY29udGludWUgaWYgbm8gaW50ZXJzZWN0aW9uXG5cdFx0XHRcdGl0ZW0gPSB0aGlzLml0ZW1zW2ldO1xuXHRcdFx0XHRpdGVtRWxlbWVudCA9IGl0ZW0uaXRlbVswXTtcblx0XHRcdFx0aW50ZXJzZWN0aW9uID0gdGhpcy5faW50ZXJzZWN0c1dpdGhQb2ludGVyKGl0ZW0pO1xuXHRcdFx0XHRpZiAoIWludGVyc2VjdGlvbikge1xuXHRcdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gT25seSBwdXQgdGhlIHBsYWNlaG9sZGVyIGluc2lkZSB0aGUgY3VycmVudCBDb250YWluZXIsIHNraXAgYWxsXG5cdFx0XHRcdC8vIGl0ZW1zIGZvcm0gb3RoZXIgY29udGFpbmVycy4gVGhpcyB3b3JrcyBiZWNhdXNlIHdoZW4gbW92aW5nXG5cdFx0XHRcdC8vIGFuIGl0ZW0gZnJvbSBvbmUgY29udGFpbmVyIHRvIGFub3RoZXIgdGhlXG5cdFx0XHRcdC8vIGN1cnJlbnRDb250YWluZXIgaXMgc3dpdGNoZWQgYmVmb3JlIHRoZSBwbGFjZWhvbGRlciBpcyBtb3ZlZC5cblx0XHRcdFx0Ly9cblx0XHRcdFx0Ly8gV2l0aG91dCB0aGlzIG1vdmluZyBpdGVtcyBpbiBcInN1Yi1zb3J0YWJsZXNcIiBjYW4gY2F1c2UgdGhlIHBsYWNlaG9sZGVyIHRvIGppdHRlclxuXHRcdFx0XHQvLyBiZWV0d2VlbiB0aGUgb3V0ZXIgYW5kIGlubmVyIGNvbnRhaW5lci5cblx0XHRcdFx0aWYgKGl0ZW0uaW5zdGFuY2UgIT09IHRoaXMuY3VycmVudENvbnRhaW5lcikge1xuXHRcdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gTm8gYWN0aW9uIGlmIGludGVyc2VjdGVkIGl0ZW0gaXMgZGlzYWJsZWRcblx0XHRcdFx0Ly8gYW5kIHRoZSBlbGVtZW50IGFib3ZlIG9yIGJlbG93IGluIHRoZSBkaXJlY3Rpb24gd2UncmUgZ29pbmcgaXMgYWxzbyBkaXNhYmxlZFxuXHRcdFx0XHRpZiAoaXRlbUVsZW1lbnQuY2xhc3NOYW1lLmluZGV4T2Yoby5kaXNhYmxlZENsYXNzKSAhPT0gLTEpIHtcblx0XHRcdFx0XHQvLyBOb3RlOiBpbnRlcnNlY3Rpb24gaGFyZGNvZGVkIGRpcmVjdGlvbiB2YWx1ZXMgZnJvbVxuXHRcdFx0XHRcdC8vIGpxdWVyeS51aS5zb3J0YWJsZS5qczpfaW50ZXJzZWN0c1dpdGhQb2ludGVyXG5cdFx0XHRcdFx0aWYgKGludGVyc2VjdGlvbiA9PT0gMikge1xuXHRcdFx0XHRcdFx0Ly8gR29pbmcgZG93blxuXHRcdFx0XHRcdFx0aXRlbUFmdGVyID0gdGhpcy5pdGVtc1tpICsgMV07XG5cdFx0XHRcdFx0XHRpZiAoaXRlbUFmdGVyICYmIGl0ZW1BZnRlci5pdGVtLmhhc0NsYXNzKG8uZGlzYWJsZWRDbGFzcykpIHtcblx0XHRcdFx0XHRcdFx0Y29udGludWU7XG5cdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHR9IGVsc2UgaWYgKGludGVyc2VjdGlvbiA9PT0gMSkge1xuXHRcdFx0XHRcdFx0Ly8gR29pbmcgdXBcblx0XHRcdFx0XHRcdGl0ZW1CZWZvcmUgPSB0aGlzLml0ZW1zW2kgLSAxXTtcblx0XHRcdFx0XHRcdGlmIChpdGVtQmVmb3JlICYmIGl0ZW1CZWZvcmUuaXRlbS5oYXNDbGFzcyhvLmRpc2FibGVkQ2xhc3MpKSB7XG5cdFx0XHRcdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXG5cdFx0XHRcdG1ldGhvZCA9IGludGVyc2VjdGlvbiA9PT0gMSA/IFwibmV4dFwiIDogXCJwcmV2XCI7XG5cblx0XHRcdFx0Ly8gY2Fubm90IGludGVyc2VjdCB3aXRoIGl0c2VsZlxuXHRcdFx0XHQvLyBubyB1c2VsZXNzIGFjdGlvbnMgdGhhdCBoYXZlIGJlZW4gZG9uZSBiZWZvcmVcblx0XHRcdFx0Ly8gbm8gYWN0aW9uIGlmIHRoZSBpdGVtIG1vdmVkIGlzIHRoZSBwYXJlbnQgb2YgdGhlIGl0ZW0gY2hlY2tlZFxuXHRcdFx0XHRpZiAoaXRlbUVsZW1lbnQgIT09IHRoaXMuY3VycmVudEl0ZW1bMF0gJiZcblx0XHRcdFx0XHR0aGlzLnBsYWNlaG9sZGVyW21ldGhvZF0oKVswXSAhPT0gaXRlbUVsZW1lbnQgJiZcblx0XHRcdFx0XHQhJC5jb250YWlucyh0aGlzLnBsYWNlaG9sZGVyWzBdLCBpdGVtRWxlbWVudCkgJiZcblx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHR0aGlzLm9wdGlvbnMudHlwZSA9PT0gXCJzZW1pLWR5bmFtaWNcIiA/XG5cdFx0XHRcdFx0XHRcdCEkLmNvbnRhaW5zKHRoaXMuZWxlbWVudFswXSwgaXRlbUVsZW1lbnQpIDpcblx0XHRcdFx0XHRcdFx0dHJ1ZVxuXHRcdFx0XHRcdClcblx0XHRcdFx0KSB7XG5cblx0XHRcdFx0XHQvLyBtanMgLSB3ZSBhcmUgaW50ZXJzZWN0aW5nIGFuIGVsZW1lbnQ6XG5cdFx0XHRcdFx0Ly8gdHJpZ2dlciB0aGUgbW91c2VlbnRlciBldmVudCBhbmQgc3RvcmUgdGhpcyBzdGF0ZVxuXHRcdFx0XHRcdGlmICghdGhpcy5tb3VzZWVudGVyZWQpIHtcblx0XHRcdFx0XHRcdCQoaXRlbUVsZW1lbnQpLm1vdXNlZW50ZXIoKTtcblx0XHRcdFx0XHRcdHRoaXMubW91c2VlbnRlcmVkID0gdHJ1ZTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHQvLyBtanMgLSBpZiB0aGUgZWxlbWVudCBoYXMgY2hpbGRyZW4gYW5kIHRoZXkgYXJlIGhpZGRlbixcblx0XHRcdFx0XHQvLyBzaG93IHRoZW0gYWZ0ZXIgYSBkZWxheSAoQ1NTIHJlc3BvbnNpYmxlKVxuXHRcdFx0XHRcdGlmIChvLmlzVHJlZSAmJiAkKGl0ZW1FbGVtZW50KS5oYXNDbGFzcyhvLmNvbGxhcHNlZENsYXNzKSAmJiBvLmV4cGFuZE9uSG92ZXIpIHtcblx0XHRcdFx0XHRcdGlmICghdGhpcy5ob3ZlcmluZykge1xuXHRcdFx0XHRcdFx0XHQkKGl0ZW1FbGVtZW50KS5hZGRDbGFzcyhvLmhvdmVyaW5nQ2xhc3MpO1xuXHRcdFx0XHRcdFx0XHR0aGlzLmhvdmVyaW5nID0gd2luZG93LnNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRcdFx0JChpdGVtRWxlbWVudClcblx0XHRcdFx0XHRcdFx0XHRcdC5yZW1vdmVDbGFzcyhvLmNvbGxhcHNlZENsYXNzKVxuXHRcdFx0XHRcdFx0XHRcdFx0LmFkZENsYXNzKG8uZXhwYW5kZWRDbGFzcyk7XG5cblx0XHRcdFx0XHRcdFx0XHRzZWxmLnJlZnJlc2hQb3NpdGlvbnMoKTtcblx0XHRcdFx0XHRcdFx0XHRzZWxmLl90cmlnZ2VyKFwiZXhwYW5kXCIsIGV2ZW50LCBzZWxmLl91aUhhc2goKSk7XG5cdFx0XHRcdFx0XHRcdH0sIG8uZXhwYW5kT25Ib3Zlcik7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0dGhpcy5kaXJlY3Rpb24gPSBpbnRlcnNlY3Rpb24gPT09IDEgPyBcImRvd25cIiA6IFwidXBcIjtcblxuXHRcdFx0XHRcdC8vIG1qcyAtIHJlYXJyYW5nZSB0aGUgZWxlbWVudHMgYW5kIHJlc2V0IHRpbWVvdXRzIGFuZCBob3ZlcmluZyBzdGF0ZVxuXHRcdFx0XHRcdGlmICh0aGlzLm9wdGlvbnMudG9sZXJhbmNlID09PSBcInBvaW50ZXJcIiB8fCB0aGlzLl9pbnRlcnNlY3RzV2l0aFNpZGVzKGl0ZW0pKSB7XG5cdFx0XHRcdFx0XHQkKGl0ZW1FbGVtZW50KS5tb3VzZWxlYXZlKCk7XG5cdFx0XHRcdFx0XHR0aGlzLm1vdXNlZW50ZXJlZCA9IGZhbHNlO1xuXHRcdFx0XHRcdFx0JChpdGVtRWxlbWVudCkucmVtb3ZlQ2xhc3Moby5ob3ZlcmluZ0NsYXNzKTtcblx0XHRcdFx0XHRcdGlmICh0aGlzLmhvdmVyaW5nKSB7XG5cdFx0XHRcdFx0XHRcdHdpbmRvdy5jbGVhclRpbWVvdXQodGhpcy5ob3ZlcmluZyk7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHR0aGlzLmhvdmVyaW5nID0gbnVsbDtcblxuXHRcdFx0XHRcdFx0Ly8gbWpzIC0gZG8gbm90IHN3aXRjaCBjb250YWluZXIgaWZcblx0XHRcdFx0XHRcdC8vIGl0J3MgYSByb290IGl0ZW0gYW5kICdwcm90ZWN0Um9vdCcgaXMgdHJ1ZVxuXHRcdFx0XHRcdFx0Ly8gb3IgaWYgaXQncyBub3QgYSByb290IGl0ZW0gYnV0IHdlIGFyZSB0cnlpbmcgdG8gbWFrZSBpdCByb290XG5cdFx0XHRcdFx0XHRpZiAoby5wcm90ZWN0Um9vdCAmJlxuXHRcdFx0XHRcdFx0XHQhKFxuXHRcdFx0XHRcdFx0XHRcdHRoaXMuY3VycmVudEl0ZW1bMF0ucGFyZW50Tm9kZSA9PT0gdGhpcy5lbGVtZW50WzBdICYmXG5cdFx0XHRcdFx0XHRcdFx0Ly8gaXQncyBhIHJvb3QgaXRlbVxuXHRcdFx0XHRcdFx0XHRcdGl0ZW1FbGVtZW50LnBhcmVudE5vZGUgIT09IHRoaXMuZWxlbWVudFswXVxuXHRcdFx0XHRcdFx0XHRcdC8vIGl0J3MgaW50ZXJzZWN0aW5nIGEgbm9uLXJvb3QgaXRlbVxuXHRcdFx0XHRcdFx0XHQpXG5cdFx0XHRcdFx0XHQpIHtcblx0XHRcdFx0XHRcdFx0aWYgKHRoaXMuY3VycmVudEl0ZW1bMF0ucGFyZW50Tm9kZSAhPT0gdGhpcy5lbGVtZW50WzBdICYmXG5cdFx0XHRcdFx0XHRcdFx0aXRlbUVsZW1lbnQucGFyZW50Tm9kZSA9PT0gdGhpcy5lbGVtZW50WzBdXG5cdFx0XHRcdFx0XHRcdCkge1xuXG5cdFx0XHRcdFx0XHRcdFx0aWYgKCAhJChpdGVtRWxlbWVudCkuY2hpbGRyZW4oby5saXN0VHlwZSkubGVuZ3RoKSB7XG5cdFx0XHRcdFx0XHRcdFx0XHRpdGVtRWxlbWVudC5hcHBlbmRDaGlsZChuZXdMaXN0KTtcblx0XHRcdFx0XHRcdFx0XHRcdGlmIChvLmlzVHJlZSkge1xuXHRcdFx0XHRcdFx0XHRcdFx0XHQkKGl0ZW1FbGVtZW50KVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdC5yZW1vdmVDbGFzcyhvLmxlYWZDbGFzcylcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQuYWRkQ2xhc3Moby5icmFuY2hDbGFzcyArIFwiIFwiICsgby5leHBhbmRlZENsYXNzKTtcblx0XHRcdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRcdFx0XHRpZiAodGhpcy5kaXJlY3Rpb24gPT09IFwiZG93blwiKSB7XG5cdFx0XHRcdFx0XHRcdFx0XHRhID0gJChpdGVtRWxlbWVudCkucHJldigpLmNoaWxkcmVuKG8ubGlzdFR5cGUpO1xuXHRcdFx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdFx0XHRhID0gJChpdGVtRWxlbWVudCkuY2hpbGRyZW4oby5saXN0VHlwZSk7XG5cdFx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdFx0aWYgKGFbMF0gIT09IHVuZGVmaW5lZCkge1xuXHRcdFx0XHRcdFx0XHRcdFx0dGhpcy5fcmVhcnJhbmdlKGV2ZW50LCBudWxsLCBhKTtcblx0XHRcdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdFx0XHR0aGlzLl9yZWFycmFuZ2UoZXZlbnQsIGl0ZW0pO1xuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHR9IGVsc2UgaWYgKCFvLnByb3RlY3RSb290KSB7XG5cdFx0XHRcdFx0XHRcdHRoaXMuX3JlYXJyYW5nZShldmVudCwgaXRlbSk7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIENsZWFyIGVtdHB5IHVsJ3Mvb2wnc1xuXHRcdFx0XHRcdHRoaXMuX2NsZWFyRW1wdHkoaXRlbUVsZW1lbnQpO1xuXG5cdFx0XHRcdFx0dGhpcy5fdHJpZ2dlcihcImNoYW5nZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdC8vIG1qcyAtIHRvIGZpbmQgdGhlIHByZXZpb3VzIHNpYmxpbmcgaW4gdGhlIGxpc3QsXG5cdFx0XHQvLyBrZWVwIGJhY2t0cmFja2luZyB1bnRpbCB3ZSBoaXQgYSB2YWxpZCBsaXN0IGl0ZW0uXG5cdFx0XHQoZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHZhciBfcHJldmlvdXNJdGVtID0gdGhpcy5wbGFjZWhvbGRlci5wcmV2KCk7XG5cdFx0XHRcdGlmIChfcHJldmlvdXNJdGVtLmxlbmd0aCkge1xuXHRcdFx0XHRcdHByZXZpb3VzSXRlbSA9IF9wcmV2aW91c0l0ZW07XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtID0gbnVsbDtcblx0XHRcdFx0fVxuXHRcdFx0fS5jYWxsKHRoaXMpKTtcblxuXHRcdFx0aWYgKHByZXZpb3VzSXRlbSAhPSBudWxsKSB7XG5cdFx0XHRcdHdoaWxlIChcblx0XHRcdFx0XHRwcmV2aW91c0l0ZW1bMF0ubm9kZU5hbWUudG9Mb3dlckNhc2UoKSAhPT0gXCJsaVwiIHx8XG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtWzBdLmNsYXNzTmFtZS5pbmRleE9mKG8uZGlzYWJsZWRDbGFzcykgIT09IC0xIHx8XG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtWzBdID09PSB0aGlzLmN1cnJlbnRJdGVtWzBdIHx8XG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtWzBdID09PSB0aGlzLmhlbHBlclswXVxuXHRcdFx0XHQpIHtcblx0XHRcdFx0XHRpZiAocHJldmlvdXNJdGVtWzBdLnByZXZpb3VzU2libGluZykge1xuXHRcdFx0XHRcdFx0cHJldmlvdXNJdGVtID0gJChwcmV2aW91c0l0ZW1bMF0ucHJldmlvdXNTaWJsaW5nKTtcblx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0cHJldmlvdXNJdGVtID0gbnVsbDtcblx0XHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvLyBtanMgLSB0byBmaW5kIHRoZSBuZXh0IHNpYmxpbmcgaW4gdGhlIGxpc3QsXG5cdFx0XHQvLyBrZWVwIHN0ZXBwaW5nIGZvcndhcmQgdW50aWwgd2UgaGl0IGEgdmFsaWQgbGlzdCBpdGVtLlxuXHRcdFx0KGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgX25leHRJdGVtID0gdGhpcy5wbGFjZWhvbGRlci5uZXh0KCk7XG5cdFx0XHRcdGlmIChfbmV4dEl0ZW0ubGVuZ3RoKSB7XG5cdFx0XHRcdFx0bmV4dEl0ZW0gPSBfbmV4dEl0ZW07XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0bmV4dEl0ZW0gPSBudWxsO1xuXHRcdFx0XHR9XG5cdFx0XHR9LmNhbGwodGhpcykpO1xuXG5cdFx0XHRpZiAobmV4dEl0ZW0gIT0gbnVsbCkge1xuXHRcdFx0XHR3aGlsZSAoXG5cdFx0XHRcdFx0bmV4dEl0ZW1bMF0ubm9kZU5hbWUudG9Mb3dlckNhc2UoKSAhPT0gXCJsaVwiIHx8XG5cdFx0XHRcdFx0bmV4dEl0ZW1bMF0uY2xhc3NOYW1lLmluZGV4T2Yoby5kaXNhYmxlZENsYXNzKSAhPT0gLTEgfHxcblx0XHRcdFx0XHRuZXh0SXRlbVswXSA9PT0gdGhpcy5jdXJyZW50SXRlbVswXSB8fFxuXHRcdFx0XHRcdG5leHRJdGVtWzBdID09PSB0aGlzLmhlbHBlclswXVxuXHRcdFx0XHQpIHtcblx0XHRcdFx0XHRpZiAobmV4dEl0ZW1bMF0ubmV4dFNpYmxpbmcpIHtcblx0XHRcdFx0XHRcdG5leHRJdGVtID0gJChuZXh0SXRlbVswXS5uZXh0U2libGluZyk7XG5cdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdG5leHRJdGVtID0gbnVsbDtcblx0XHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHR0aGlzLmJleW9uZE1heExldmVscyA9IDA7XG5cblx0XHRcdC8vIG1qcyAtIGlmIHRoZSBpdGVtIGlzIG1vdmVkIHRvIHRoZSBsZWZ0LCBzZW5kIGl0IG9uZSBsZXZlbCB1cFxuXHRcdFx0Ly8gYnV0IG9ubHkgaWYgaXQncyBhdCB0aGUgYm90dG9tIG9mIHRoZSBsaXN0XG5cdFx0XHRpZiAocGFyZW50SXRlbSAhPSBudWxsICYmXG5cdFx0XHRcdG5leHRJdGVtID09IG51bGwgJiZcblx0XHRcdFx0IShvLnByb3RlY3RSb290ICYmIHBhcmVudEl0ZW1bMF0ucGFyZW50Tm9kZSA9PSB0aGlzLmVsZW1lbnRbMF0pICYmXG5cdFx0XHRcdChcblx0XHRcdFx0XHRvLnJ0bCAmJlxuXHRcdFx0XHRcdChcblx0XHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMubGVmdCArXG5cdFx0XHRcdFx0XHR0aGlzLmhlbHBlci5vdXRlcldpZHRoKCkgPiBwYXJlbnRJdGVtLm9mZnNldCgpLmxlZnQgK1xuXHRcdFx0XHRcdFx0cGFyZW50SXRlbS5vdXRlcldpZHRoKClcblx0XHRcdFx0XHQpIHx8XG5cdFx0XHRcdFx0IW8ucnRsICYmICh0aGlzLnBvc2l0aW9uQWJzLmxlZnQgPCBwYXJlbnRJdGVtLm9mZnNldCgpLmxlZnQpXG5cdFx0XHRcdClcblx0XHRcdCkge1xuXG5cdFx0XHRcdHBhcmVudEl0ZW0uYWZ0ZXIodGhpcy5wbGFjZWhvbGRlclswXSk7XG5cdFx0XHRcdGhlbHBlcklzTm90U2libGluZyA9ICFwYXJlbnRJdGVtXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0LmNoaWxkcmVuKG8ubGlzdEl0ZW0pXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0LmNoaWxkcmVuKFwibGk6dmlzaWJsZTpub3QoLnVpLXNvcnRhYmxlLWhlbHBlcilcIilcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQubGVuZ3RoO1xuXHRcdFx0XHRpZiAoby5pc1RyZWUgJiYgaGVscGVySXNOb3RTaWJsaW5nKSB7XG5cdFx0XHRcdFx0cGFyZW50SXRlbVxuXHRcdFx0XHRcdFx0LnJlbW92ZUNsYXNzKHRoaXMub3B0aW9ucy5icmFuY2hDbGFzcyArIFwiIFwiICsgdGhpcy5vcHRpb25zLmV4cGFuZGVkQ2xhc3MpXG5cdFx0XHRcdFx0XHQuYWRkQ2xhc3ModGhpcy5vcHRpb25zLmxlYWZDbGFzcyk7XG5cdFx0XHRcdH1cbiAgICAgICAgICAgICAgICBpZih0eXBlb2YgcGFyZW50SXRlbSAhPT0gJ3VuZGVmaW5lZCcpXG5cdFx0XHRcdCAgICB0aGlzLl9jbGVhckVtcHR5KHBhcmVudEl0ZW1bMF0pO1xuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKFwiY2hhbmdlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSk7XG5cdFx0XHRcdC8vIG1qcyAtIGlmIHRoZSBpdGVtIGlzIGJlbG93IGEgc2libGluZyBhbmQgaXMgbW92ZWQgdG8gdGhlIHJpZ2h0LFxuXHRcdFx0XHQvLyBtYWtlIGl0IGEgY2hpbGQgb2YgdGhhdCBzaWJsaW5nXG5cdFx0XHR9IGVsc2UgaWYgKHByZXZpb3VzSXRlbSAhPSBudWxsICYmXG5cdFx0XHRcdCFwcmV2aW91c0l0ZW0uaGFzQ2xhc3Moby5kaXNhYmxlTmVzdGluZ0NsYXNzKSAmJlxuXHRcdFx0XHQoXG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmxlbmd0aCAmJlxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbS5jaGlsZHJlbihvLmxpc3RUeXBlKS5pcyhcIjp2aXNpYmxlXCIpIHx8XG5cdFx0XHRcdFx0IXByZXZpb3VzSXRlbS5jaGlsZHJlbihvLmxpc3RUeXBlKS5sZW5ndGhcblx0XHRcdFx0KSAmJlxuXHRcdFx0XHQhKG8ucHJvdGVjdFJvb3QgJiYgdGhpcy5jdXJyZW50SXRlbVswXS5wYXJlbnROb2RlID09PSB0aGlzLmVsZW1lbnRbMF0pICYmXG5cdFx0XHRcdChcblx0XHRcdFx0XHRvLnJ0bCAmJlxuXHRcdFx0XHRcdChcblx0XHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMubGVmdCArXG5cdFx0XHRcdFx0XHR0aGlzLmhlbHBlci5vdXRlcldpZHRoKCkgPFxuXHRcdFx0XHRcdFx0cHJldmlvdXNJdGVtLm9mZnNldCgpLmxlZnQgK1xuXHRcdFx0XHRcdFx0cHJldmlvdXNJdGVtLm91dGVyV2lkdGgoKSAtXG5cdFx0XHRcdFx0XHRvLnRhYlNpemVcblx0XHRcdFx0XHQpIHx8XG5cdFx0XHRcdFx0IW8ucnRsICYmXG5cdFx0XHRcdFx0KHRoaXMucG9zaXRpb25BYnMubGVmdCA+IHByZXZpb3VzSXRlbS5vZmZzZXQoKS5sZWZ0ICsgby50YWJTaXplKVxuXHRcdFx0XHQpXG5cdFx0XHQpIHtcblxuXHRcdFx0XHR0aGlzLl9pc0FsbG93ZWQocHJldmlvdXNJdGVtLCBsZXZlbCwgbGV2ZWwgKyBjaGlsZExldmVscyArIDEpO1xuXG5cdFx0XHRcdGlmICghcHJldmlvdXNJdGVtLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmxlbmd0aCkge1xuXHRcdFx0XHRcdHByZXZpb3VzSXRlbVswXS5hcHBlbmRDaGlsZChuZXdMaXN0KTtcblx0XHRcdFx0XHRpZiAoby5pc1RyZWUpIHtcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbVxuXHRcdFx0XHRcdFx0XHQucmVtb3ZlQ2xhc3Moby5sZWFmQ2xhc3MpXG5cdFx0XHRcdFx0XHRcdC5hZGRDbGFzcyhvLmJyYW5jaENsYXNzICsgXCIgXCIgKyBvLmV4cGFuZGVkQ2xhc3MpO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIG1qcyAtIGlmIHRoaXMgaXRlbSBpcyBiZWluZyBtb3ZlZCBmcm9tIHRoZSB0b3AsIGFkZCBpdCB0byB0aGUgdG9wIG9mIHRoZSBsaXN0LlxuXHRcdFx0XHRpZiAocHJldmlvdXNUb3BPZmZzZXQgJiYgKHByZXZpb3VzVG9wT2Zmc2V0IDw9IHByZXZpb3VzSXRlbS5vZmZzZXQoKS50b3ApKSB7XG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtLmNoaWxkcmVuKG8ubGlzdFR5cGUpLnByZXBlbmQodGhpcy5wbGFjZWhvbGRlcik7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0Ly8gbWpzIC0gb3RoZXJ3aXNlLCBhZGQgaXQgdG8gdGhlIGJvdHRvbSBvZiB0aGUgbGlzdC5cblx0XHRcdFx0XHRwcmV2aW91c0l0ZW0uY2hpbGRyZW4oby5saXN0VHlwZSlbMF0uYXBwZW5kQ2hpbGQodGhpcy5wbGFjZWhvbGRlclswXSk7XG5cdFx0XHRcdH1cbiAgICAgICAgICAgICAgICBpZih0eXBlb2YgcGFyZW50SXRlbSAhPT0gJ3VuZGVmaW5lZCcpXG5cdFx0XHRcdCAgICB0aGlzLl9jbGVhckVtcHR5KHBhcmVudEl0ZW1bMF0pO1xuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKFwiY2hhbmdlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHR0aGlzLl9pc0FsbG93ZWQocGFyZW50SXRlbSwgbGV2ZWwsIGxldmVsICsgY2hpbGRMZXZlbHMpO1xuXHRcdFx0fVxuXG5cdFx0XHQvL1Bvc3QgZXZlbnRzIHRvIGNvbnRhaW5lcnNcblx0XHRcdHRoaXMuX2NvbnRhY3RDb250YWluZXJzKGV2ZW50KTtcblxuXHRcdFx0Ly9JbnRlcmNvbm5lY3Qgd2l0aCBkcm9wcGFibGVzXG5cdFx0XHRpZiAoJC51aS5kZG1hbmFnZXIpIHtcblx0XHRcdFx0JC51aS5kZG1hbmFnZXIuZHJhZyh0aGlzLCBldmVudCk7XG5cdFx0XHR9XG5cblx0XHRcdC8vQ2FsbCBjYWxsYmFja3Ncblx0XHRcdHRoaXMuX3RyaWdnZXIoXCJzb3J0XCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSk7XG5cblx0XHRcdHRoaXMubGFzdFBvc2l0aW9uQWJzID0gdGhpcy5wb3NpdGlvbkFicztcblx0XHRcdHJldHVybiBmYWxzZTtcblxuXHRcdH0sXG5cblx0XHRfbW91c2VTdG9wOiBmdW5jdGlvbihldmVudCkge1xuXHRcdFx0Ly8gbWpzIC0gaWYgdGhlIGl0ZW0gaXMgaW4gYSBwb3NpdGlvbiBub3QgYWxsb3dlZCwgc2VuZCBpdCBiYWNrXG5cdFx0XHRpZiAodGhpcy5iZXlvbmRNYXhMZXZlbHMpIHtcblxuXHRcdFx0XHR0aGlzLnBsYWNlaG9sZGVyLnJlbW92ZUNsYXNzKHRoaXMub3B0aW9ucy5lcnJvckNsYXNzKTtcblxuXHRcdFx0XHRpZiAodGhpcy5kb21Qb3NpdGlvbi5wcmV2KSB7XG5cdFx0XHRcdFx0JCh0aGlzLmRvbVBvc2l0aW9uLnByZXYpLmFmdGVyKHRoaXMucGxhY2Vob2xkZXIpO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdCQodGhpcy5kb21Qb3NpdGlvbi5wYXJlbnQpLnByZXBlbmQodGhpcy5wbGFjZWhvbGRlcik7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKFwicmV2ZXJ0XCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSk7XG5cblx0XHRcdH1cblxuXHRcdFx0Ly8gbWpzIC0gY2xlYXIgdGhlIGhvdmVyaW5nIHRpbWVvdXQsIGp1c3QgdG8gYmUgc3VyZVxuXHRcdFx0JChcIi5cIiArIHRoaXMub3B0aW9ucy5ob3ZlcmluZ0NsYXNzKVxuXHRcdFx0XHQubW91c2VsZWF2ZSgpXG5cdFx0XHRcdC5yZW1vdmVDbGFzcyh0aGlzLm9wdGlvbnMuaG92ZXJpbmdDbGFzcyk7XG5cblx0XHRcdHRoaXMubW91c2VlbnRlcmVkID0gZmFsc2U7XG5cdFx0XHRpZiAodGhpcy5ob3ZlcmluZykge1xuXHRcdFx0XHR3aW5kb3cuY2xlYXJUaW1lb3V0KHRoaXMuaG92ZXJpbmcpO1xuXHRcdFx0fVxuXHRcdFx0dGhpcy5ob3ZlcmluZyA9IG51bGw7XG5cblx0XHRcdHRoaXMuX3JlbG9jYXRlX2V2ZW50ID0gZXZlbnQ7XG5cdFx0XHR0aGlzLl9waWRfY3VycmVudCA9ICQodGhpcy5kb21Qb3NpdGlvbi5wYXJlbnQpLnBhcmVudCgpLmF0dHIoXCJpZFwiKTtcblx0XHRcdHRoaXMuX3NvcnRfY3VycmVudCA9IHRoaXMuZG9tUG9zaXRpb24ucHJldiA/ICQodGhpcy5kb21Qb3NpdGlvbi5wcmV2KS5uZXh0KCkuaW5kZXgoKSA6IDA7XG5cdFx0XHQkLnVpLnNvcnRhYmxlLnByb3RvdHlwZS5fbW91c2VTdG9wLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7IC8vYXN5Ym5jaHJvbm91cyBleGVjdXRpb24sIEBzZWUgX2NsZWFyIGZvciB0aGUgcmVsb2NhdGUgZXZlbnQuXG5cdFx0fSxcblxuXHRcdC8vIG1qcyAtIHRoaXMgZnVuY3Rpb24gaXMgc2xpZ2h0bHkgbW9kaWZpZWRcblx0XHQvLyB0byBtYWtlIGl0IGVhc2llciB0byBob3ZlciBvdmVyIGEgY29sbGFwc2VkIGVsZW1lbnQgYW5kIGhhdmUgaXQgZXhwYW5kXG5cdFx0X2ludGVyc2VjdHNXaXRoU2lkZXM6IGZ1bmN0aW9uKGl0ZW0pIHtcblxuXHRcdFx0dmFyIGhhbGYgPSB0aGlzLm9wdGlvbnMuaXNUcmVlID8gLjggOiAuNSxcblx0XHRcdFx0aXNPdmVyQm90dG9tSGFsZiA9IGlzT3ZlckF4aXMoXG5cdFx0XHRcdFx0dGhpcy5wb3NpdGlvbkFicy50b3AgKyB0aGlzLm9mZnNldC5jbGljay50b3AsXG5cdFx0XHRcdFx0aXRlbS50b3AgKyAoaXRlbS5oZWlnaHQgKiBoYWxmKSxcblx0XHRcdFx0XHRpdGVtLmhlaWdodFxuXHRcdFx0XHQpLFxuXHRcdFx0XHRpc092ZXJUb3BIYWxmID0gaXNPdmVyQXhpcyhcblx0XHRcdFx0XHR0aGlzLnBvc2l0aW9uQWJzLnRvcCArIHRoaXMub2Zmc2V0LmNsaWNrLnRvcCxcblx0XHRcdFx0XHRpdGVtLnRvcCAtIChpdGVtLmhlaWdodCAqIGhhbGYpLFxuXHRcdFx0XHRcdGl0ZW0uaGVpZ2h0XG5cdFx0XHRcdCksXG5cdFx0XHRcdGlzT3ZlclJpZ2h0SGFsZiA9IGlzT3ZlckF4aXMoXG5cdFx0XHRcdFx0dGhpcy5wb3NpdGlvbkFicy5sZWZ0ICsgdGhpcy5vZmZzZXQuY2xpY2subGVmdCxcblx0XHRcdFx0XHRpdGVtLmxlZnQgKyAoaXRlbS53aWR0aCAvIDIpLFxuXHRcdFx0XHRcdGl0ZW0ud2lkdGhcblx0XHRcdFx0KSxcblx0XHRcdFx0dmVydGljYWxEaXJlY3Rpb24gPSB0aGlzLl9nZXREcmFnVmVydGljYWxEaXJlY3Rpb24oKSxcblx0XHRcdFx0aG9yaXpvbnRhbERpcmVjdGlvbiA9IHRoaXMuX2dldERyYWdIb3Jpem9udGFsRGlyZWN0aW9uKCk7XG5cblx0XHRcdGlmICh0aGlzLmZsb2F0aW5nICYmIGhvcml6b250YWxEaXJlY3Rpb24pIHtcblx0XHRcdFx0cmV0dXJuIChcblx0XHRcdFx0XHQoaG9yaXpvbnRhbERpcmVjdGlvbiA9PT0gXCJyaWdodFwiICYmIGlzT3ZlclJpZ2h0SGFsZikgfHxcblx0XHRcdFx0XHQoaG9yaXpvbnRhbERpcmVjdGlvbiA9PT0gXCJsZWZ0XCIgJiYgIWlzT3ZlclJpZ2h0SGFsZilcblx0XHRcdFx0KTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdHJldHVybiB2ZXJ0aWNhbERpcmVjdGlvbiAmJiAoXG5cdFx0XHRcdFx0KHZlcnRpY2FsRGlyZWN0aW9uID09PSBcImRvd25cIiAmJiBpc092ZXJCb3R0b21IYWxmKSB8fFxuXHRcdFx0XHRcdCh2ZXJ0aWNhbERpcmVjdGlvbiA9PT0gXCJ1cFwiICYmIGlzT3ZlclRvcEhhbGYpXG5cdFx0XHRcdCk7XG5cdFx0XHR9XG5cblx0XHR9LFxuXG5cdFx0X2NvbnRhY3RDb250YWluZXJzOiBmdW5jdGlvbigpIHtcblxuXHRcdFx0aWYgKHRoaXMub3B0aW9ucy5wcm90ZWN0Um9vdCAmJiB0aGlzLmN1cnJlbnRJdGVtWzBdLnBhcmVudE5vZGUgPT09IHRoaXMuZWxlbWVudFswXSApIHtcblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXG5cdFx0XHQkLnVpLnNvcnRhYmxlLnByb3RvdHlwZS5fY29udGFjdENvbnRhaW5lcnMuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcblxuXHRcdH0sXG5cblx0XHRfY2xlYXI6IGZ1bmN0aW9uKCkge1xuXHRcdFx0dmFyIGksXG5cdFx0XHRcdGl0ZW07XG5cblx0XHRcdCQudWkuc29ydGFibGUucHJvdG90eXBlLl9jbGVhci5hcHBseSh0aGlzLCBhcmd1bWVudHMpO1xuXG5cdFx0XHQvL3JlbG9jYXRlIGV2ZW50XG5cdFx0XHRpZiAoISh0aGlzLl9waWRfY3VycmVudCA9PT0gdGhpcy5fdWlIYXNoKCkuaXRlbS5wYXJlbnQoKS5wYXJlbnQoKS5hdHRyKFwiaWRcIikgJiZcblx0XHRcdFx0dGhpcy5fc29ydF9jdXJyZW50ID09PSB0aGlzLl91aUhhc2goKS5pdGVtLmluZGV4KCkpKSB7XG5cdFx0XHRcdHRoaXMuX3RyaWdnZXIoXCJyZWxvY2F0ZVwiLCB0aGlzLl9yZWxvY2F0ZV9ldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBtanMgLSBjbGVhbiBsYXN0IGVtcHR5IHVsL29sXG5cdFx0XHRmb3IgKGkgPSB0aGlzLml0ZW1zLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tKSB7XG5cdFx0XHRcdGl0ZW0gPSB0aGlzLml0ZW1zW2ldLml0ZW1bMF07XG5cdFx0XHRcdHRoaXMuX2NsZWFyRW1wdHkoaXRlbSk7XG5cdFx0XHR9XG5cblx0XHR9LFxuXG5cdFx0c2VyaWFsaXplOiBmdW5jdGlvbihvcHRpb25zKSB7XG5cblx0XHRcdHZhciBvID0gJC5leHRlbmQoe30sIHRoaXMub3B0aW9ucywgb3B0aW9ucyksXG5cdFx0XHRcdGl0ZW1zID0gdGhpcy5fZ2V0SXRlbXNBc2pRdWVyeShvICYmIG8uY29ubmVjdGVkKSxcblx0XHRcdFx0c3RyID0gW107XG5cblx0XHRcdCQoaXRlbXMpLmVhY2goZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHZhciByZXMgPSAoJChvLml0ZW0gfHwgdGhpcykuYXR0cihvLmF0dHJpYnV0ZSB8fCBcImlkXCIpIHx8IFwiXCIpXG5cdFx0XHRcdFx0XHQubWF0Y2goby5leHByZXNzaW9uIHx8ICgvKC4rKVstPV9dKC4rKS8pKSxcblx0XHRcdFx0XHRwaWQgPSAoJChvLml0ZW0gfHwgdGhpcykucGFyZW50KG8ubGlzdFR5cGUpXG5cdFx0XHRcdFx0XHQucGFyZW50KG8uaXRlbXMpXG5cdFx0XHRcdFx0XHQuYXR0cihvLmF0dHJpYnV0ZSB8fCBcImlkXCIpIHx8IFwiXCIpXG5cdFx0XHRcdFx0XHQubWF0Y2goby5leHByZXNzaW9uIHx8ICgvKC4rKVstPV9dKC4rKS8pKTtcblxuXHRcdFx0XHRpZiAocmVzKSB7XG5cdFx0XHRcdFx0c3RyLnB1c2goXG5cdFx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHRcdChvLmtleSB8fCByZXNbMV0pICtcblx0XHRcdFx0XHRcdFx0XCJbXCIgK1xuXHRcdFx0XHRcdFx0XHQoby5rZXkgJiYgby5leHByZXNzaW9uID8gcmVzWzFdIDogcmVzWzJdKSArIFwiXVwiXG5cdFx0XHRcdFx0XHQpICtcblx0XHRcdFx0XHRcdFwiPVwiICtcblx0XHRcdFx0XHRcdChwaWQgPyAoby5rZXkgJiYgby5leHByZXNzaW9uID8gcGlkWzFdIDogcGlkWzJdKSA6IG8ucm9vdElEKSk7XG5cdFx0XHRcdH1cblx0XHRcdH0pO1xuXG5cdFx0XHRpZiAoIXN0ci5sZW5ndGggJiYgby5rZXkpIHtcblx0XHRcdFx0c3RyLnB1c2goby5rZXkgKyBcIj1cIik7XG5cdFx0XHR9XG5cblx0XHRcdHJldHVybiBzdHIuam9pbihcIiZcIik7XG5cblx0XHR9LFxuXG5cdFx0dG9IaWVyYXJjaHk6IGZ1bmN0aW9uKG9wdGlvbnMpIHtcblxuXHRcdFx0dmFyIG8gPSAkLmV4dGVuZCh7fSwgdGhpcy5vcHRpb25zLCBvcHRpb25zKSxcblx0XHRcdFx0cmV0ID0gW107XG5cblx0XHRcdCQodGhpcy5lbGVtZW50KS5jaGlsZHJlbihvLml0ZW1zKS5lYWNoKGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgbGV2ZWwgPSBfcmVjdXJzaXZlSXRlbXModGhpcyk7XG5cdFx0XHRcdHJldC5wdXNoKGxldmVsKTtcblx0XHRcdH0pO1xuXG5cdFx0XHRyZXR1cm4gcmV0O1xuXG5cdFx0XHRmdW5jdGlvbiBfcmVjdXJzaXZlSXRlbXMoaXRlbSkge1xuXHRcdFx0XHR2YXIgaWQgPSAoJChpdGVtKS5hdHRyKG8uYXR0cmlidXRlIHx8IFwiaWRcIikgfHwgXCJcIikubWF0Y2goby5leHByZXNzaW9uIHx8ICgvKC4rKVstPV9dKC4rKS8pKSxcblx0XHRcdFx0XHRjdXJyZW50SXRlbTtcblxuXHRcdFx0XHR2YXIgZGF0YSA9ICQoaXRlbSkuZGF0YSgpO1xuXHRcdFx0XHRpZiAoZGF0YS5uZXN0ZWRTb3J0YWJsZUl0ZW0pIHtcblx0XHRcdFx0XHRkZWxldGUgZGF0YS5uZXN0ZWRTb3J0YWJsZUl0ZW07IC8vIFJlbW92ZSB0aGUgbmVzdGVkU29ydGFibGVJdGVtIG9iamVjdCBmcm9tIHRoZSBkYXRhXG5cdFx0XHRcdH1cblxuXHRcdFx0XHRpZiAoaWQpIHtcblx0XHRcdFx0XHRjdXJyZW50SXRlbSA9IHtcblx0XHRcdFx0XHRcdFwiaWRcIjogaWRbMl1cblx0XHRcdFx0XHR9O1xuXG5cdFx0XHRcdFx0Y3VycmVudEl0ZW0gPSAkLmV4dGVuZCh7fSwgY3VycmVudEl0ZW0sIGRhdGEpOyAvLyBDb21iaW5lIHRoZSB0d28gb2JqZWN0c1xuXG5cdFx0XHRcdFx0aWYgKCQoaXRlbSkuY2hpbGRyZW4oby5saXN0VHlwZSkuY2hpbGRyZW4oby5pdGVtcykubGVuZ3RoID4gMCkge1xuXHRcdFx0XHRcdFx0Y3VycmVudEl0ZW0uY2hpbGRyZW4gPSBbXTtcblx0XHRcdFx0XHRcdCQoaXRlbSkuY2hpbGRyZW4oby5saXN0VHlwZSkuY2hpbGRyZW4oby5pdGVtcykuZWFjaChmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRcdFx0dmFyIGxldmVsID0gX3JlY3Vyc2l2ZUl0ZW1zKHRoaXMpO1xuXHRcdFx0XHRcdFx0XHRjdXJyZW50SXRlbS5jaGlsZHJlbi5wdXNoKGxldmVsKTtcblx0XHRcdFx0XHRcdH0pO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRyZXR1cm4gY3VycmVudEl0ZW07XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0dG9BcnJheTogZnVuY3Rpb24ob3B0aW9ucykge1xuXG5cdFx0XHR2YXIgbyA9ICQuZXh0ZW5kKHt9LCB0aGlzLm9wdGlvbnMsIG9wdGlvbnMpLFxuXHRcdFx0XHRzRGVwdGggPSBvLnN0YXJ0RGVwdGhDb3VudCB8fCAwLFxuXHRcdFx0XHRyZXQgPSBbXSxcblx0XHRcdFx0bGVmdCA9IDE7XG5cblx0XHRcdGlmICghby5leGNsdWRlUm9vdCkge1xuXHRcdFx0XHRyZXQucHVzaCh7XG5cdFx0XHRcdFx0XCJpdGVtX2lkXCI6IG8ucm9vdElELFxuXHRcdFx0XHRcdFwicGFyZW50X2lkXCI6IG51bGwsXG5cdFx0XHRcdFx0XCJkZXB0aFwiOiBzRGVwdGgsXG5cdFx0XHRcdFx0XCJsZWZ0XCI6IGxlZnQsXG5cdFx0XHRcdFx0XCJyaWdodFwiOiAoJChvLml0ZW1zLCB0aGlzLmVsZW1lbnQpLmxlbmd0aCArIDEpICogMlxuXHRcdFx0XHR9KTtcblx0XHRcdFx0bGVmdCsrO1xuXHRcdFx0fVxuXG5cdFx0XHQkKHRoaXMuZWxlbWVudCkuY2hpbGRyZW4oby5pdGVtcykuZWFjaChmdW5jdGlvbigpIHtcblx0XHRcdFx0bGVmdCA9IF9yZWN1cnNpdmVBcnJheSh0aGlzLCBzRGVwdGgsIGxlZnQpO1xuXHRcdFx0fSk7XG5cblx0XHRcdHJldCA9IHJldC5zb3J0KGZ1bmN0aW9uKGEsIGIpIHsgcmV0dXJuIChhLmxlZnQgLSBiLmxlZnQpOyB9KTtcblxuXHRcdFx0cmV0dXJuIHJldDtcblxuXHRcdFx0ZnVuY3Rpb24gX3JlY3Vyc2l2ZUFycmF5KGl0ZW0sIGRlcHRoLCBfbGVmdCkge1xuXG5cdFx0XHRcdHZhciByaWdodCA9IF9sZWZ0ICsgMSxcblx0XHRcdFx0XHRpZCxcblx0XHRcdFx0XHRwaWQsXG5cdFx0XHRcdFx0cGFyZW50SXRlbTtcblxuXHRcdFx0XHRpZiAoJChpdGVtKS5jaGlsZHJlbihvLmxpc3RUeXBlKS5jaGlsZHJlbihvLml0ZW1zKS5sZW5ndGggPiAwKSB7XG5cdFx0XHRcdFx0ZGVwdGgrKztcblx0XHRcdFx0XHQkKGl0ZW0pLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmNoaWxkcmVuKG8uaXRlbXMpLmVhY2goZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRyaWdodCA9IF9yZWN1cnNpdmVBcnJheSgkKHRoaXMpLCBkZXB0aCwgcmlnaHQpO1xuXHRcdFx0XHRcdH0pO1xuXHRcdFx0XHRcdGRlcHRoLS07XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRpZCA9ICgkKGl0ZW0pLmF0dHIoby5hdHRyaWJ1dGUgfHwgXCJpZFwiKSkubWF0Y2goby5leHByZXNzaW9uIHx8ICgvKC4rKVstPV9dKC4rKS8pKTtcblxuXHRcdFx0XHRpZiAoZGVwdGggPT09IHNEZXB0aCkge1xuXHRcdFx0XHRcdHBpZCA9IG8ucm9vdElEO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdHBhcmVudEl0ZW0gPSAoJChpdGVtKS5wYXJlbnQoby5saXN0VHlwZSlcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQucGFyZW50KG8uaXRlbXMpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0LmF0dHIoby5hdHRyaWJ1dGUgfHwgXCJpZFwiKSlcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQubWF0Y2goby5leHByZXNzaW9uIHx8ICgvKC4rKVstPV9dKC4rKS8pKTtcblx0XHRcdFx0XHRwaWQgPSBwYXJlbnRJdGVtWzJdO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWYgKGlkKSB7XG5cdFx0XHRcdFx0ICAgICAgICB2YXIgbmFtZSA9ICQoaXRlbSkuZGF0YShcIm5hbWVcIik7XG5cdFx0XHRcdFx0XHRyZXQucHVzaCh7XG5cdFx0XHRcdFx0XHRcdFwiaWRcIjogaWRbMl0sXG5cdFx0XHRcdFx0XHRcdFwicGFyZW50X2lkXCI6IHBpZCxcblx0XHRcdFx0XHRcdFx0XCJkZXB0aFwiOiBkZXB0aCxcblx0XHRcdFx0XHRcdFx0XCJsZWZ0XCI6IF9sZWZ0LFxuXHRcdFx0XHRcdFx0XHRcInJpZ2h0XCI6IHJpZ2h0LFxuXHRcdFx0XHRcdFx0XHRcIm5hbWVcIjpuYW1lXG5cdFx0XHRcdFx0XHR9KTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdF9sZWZ0ID0gcmlnaHQgKyAxO1xuXHRcdFx0XHRyZXR1cm4gX2xlZnQ7XG5cdFx0XHR9XG5cblx0XHR9LFxuXG5cdFx0X2NsZWFyRW1wdHk6IGZ1bmN0aW9uIChpdGVtKSB7XG5cdFx0XHRmdW5jdGlvbiByZXBsYWNlQ2xhc3MoZWxlbSwgc2VhcmNoLCByZXBsYWNlLCBzd2FwKSB7XG5cdFx0XHRcdGlmIChzd2FwKSB7XG5cdFx0XHRcdFx0c2VhcmNoID0gW3JlcGxhY2UsIHJlcGxhY2UgPSBzZWFyY2hdWzBdO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0JChlbGVtKS5yZW1vdmVDbGFzcyhzZWFyY2gpLmFkZENsYXNzKHJlcGxhY2UpO1xuXHRcdFx0fVxuXG5cdFx0XHR2YXIgbyA9IHRoaXMub3B0aW9ucyxcblx0XHRcdFx0Y2hpbGRyZW5MaXN0ID0gJChpdGVtKS5jaGlsZHJlbihvLmxpc3RUeXBlKSxcblx0XHRcdFx0aGFzQ2hpbGRyZW4gPSBjaGlsZHJlbkxpc3QuaXMoJzpub3QoOmVtcHR5KScpO1xuXG5cdFx0XHR2YXIgZG9Ob3RDbGVhciA9XG5cdFx0XHRcdG8uZG9Ob3RDbGVhciB8fFxuXHRcdFx0XHRoYXNDaGlsZHJlbiB8fFxuXHRcdFx0XHRvLnByb3RlY3RSb290ICYmICQoaXRlbSlbMF0gPT09IHRoaXMuZWxlbWVudFswXTtcblxuXHRcdFx0aWYgKG8uaXNUcmVlKSB7XG5cdFx0XHRcdHJlcGxhY2VDbGFzcyhpdGVtLCBvLmJyYW5jaENsYXNzLCBvLmxlYWZDbGFzcywgZG9Ob3RDbGVhcik7XG5cblx0XHRcdFx0aWYgKGRvTm90Q2xlYXIgJiYgaGFzQ2hpbGRyZW4pIHtcblx0XHRcdFx0XHRyZXBsYWNlQ2xhc3MoaXRlbSwgby5jb2xsYXBzZWRDbGFzcywgby5leHBhbmRlZENsYXNzKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIWRvTm90Q2xlYXIpIHtcblx0XHRcdFx0Y2hpbGRyZW5MaXN0LnJlbW92ZSgpO1xuXHRcdFx0fVxuXHRcdH0sXG5cblx0XHRfZ2V0TGV2ZWw6IGZ1bmN0aW9uKGl0ZW0pIHtcblxuXHRcdFx0dmFyIGxldmVsID0gMSxcblx0XHRcdFx0bGlzdDtcblxuXHRcdFx0aWYgKHRoaXMub3B0aW9ucy5saXN0VHlwZSkge1xuXHRcdFx0XHRsaXN0ID0gaXRlbS5jbG9zZXN0KHRoaXMub3B0aW9ucy5saXN0VHlwZSk7XG5cdFx0XHRcdHdoaWxlIChsaXN0ICYmIGxpc3QubGVuZ3RoID4gMCAmJiAhbGlzdC5pcyhcIi51aS1zb3J0YWJsZVwiKSkge1xuXHRcdFx0XHRcdGxldmVsKys7XG5cdFx0XHRcdFx0bGlzdCA9IGxpc3QucGFyZW50KCkuY2xvc2VzdCh0aGlzLm9wdGlvbnMubGlzdFR5cGUpO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdHJldHVybiBsZXZlbDtcblx0XHR9LFxuXG5cdFx0X2dldENoaWxkTGV2ZWxzOiBmdW5jdGlvbihwYXJlbnQsIGRlcHRoKSB7XG5cdFx0XHR2YXIgc2VsZiA9IHRoaXMsXG5cdFx0XHRcdG8gPSB0aGlzLm9wdGlvbnMsXG5cdFx0XHRcdHJlc3VsdCA9IDA7XG5cdFx0XHRkZXB0aCA9IGRlcHRoIHx8IDA7XG5cblx0XHRcdCQocGFyZW50KS5jaGlsZHJlbihvLmxpc3RUeXBlKS5jaGlsZHJlbihvLml0ZW1zKS5lYWNoKGZ1bmN0aW9uKGluZGV4LCBjaGlsZCkge1xuXHRcdFx0XHRyZXN1bHQgPSBNYXRoLm1heChzZWxmLl9nZXRDaGlsZExldmVscyhjaGlsZCwgZGVwdGggKyAxKSwgcmVzdWx0KTtcblx0XHRcdH0pO1xuXG5cdFx0XHRyZXR1cm4gZGVwdGggPyByZXN1bHQgKyAxIDogcmVzdWx0O1xuXHRcdH0sXG5cblx0XHRfaXNBbGxvd2VkOiBmdW5jdGlvbihwYXJlbnRJdGVtLCBsZXZlbCwgbGV2ZWxzKSB7XG5cdFx0XHR2YXIgbyA9IHRoaXMub3B0aW9ucyxcblx0XHRcdFx0Ly8gdGhpcyB0YWtlcyBpbnRvIGFjY291bnQgdGhlIG1heExldmVscyBzZXQgdG8gdGhlIHJlY2lwaWVudCBsaXN0XG5cdFx0XHRcdG1heExldmVscyA9IHRoaXNcblx0XHRcdFx0XHQucGxhY2Vob2xkZXJcblx0XHRcdFx0XHQuY2xvc2VzdChcIi51aS1zb3J0YWJsZVwiKVxuXHRcdFx0XHRcdC5uZXN0ZWRTb3J0YWJsZShcIm9wdGlvblwiLCBcIm1heExldmVsc1wiKSxcblxuXHRcdFx0XHQvLyBDaGVjayBpZiB0aGUgcGFyZW50IGhhcyBjaGFuZ2VkIHRvIHByZXZlbnQgaXQsIHdoZW4gby5kaXNhYmxlUGFyZW50Q2hhbmdlIGlzIHRydWVcblx0XHRcdFx0b2xkUGFyZW50ID0gdGhpcy5jdXJyZW50SXRlbS5wYXJlbnQoKS5wYXJlbnQoKSxcblx0XHRcdFx0ZGlzYWJsZWRCeVBhcmVudGNoYW5nZSA9IG8uZGlzYWJsZVBhcmVudENoYW5nZSAmJiAoXG5cdFx0XHRcdFx0Ly9Gcm9tIHNvbWV3aGVyZSB0byBzb21ld2hlcmUgZWxzZSwgZXhjZXB0IHRoZSByb290XG5cdFx0XHRcdFx0dHlwZW9mIHBhcmVudEl0ZW0gIT09ICd1bmRlZmluZWQnICYmICFvbGRQYXJlbnQuaXMocGFyZW50SXRlbSkgfHxcblx0XHRcdFx0XHR0eXBlb2YgcGFyZW50SXRlbSA9PT0gJ3VuZGVmaW5lZCcgJiYgb2xkUGFyZW50LmlzKFwibGlcIilcdC8vRnJvbSBzb21ld2hlcmUgdG8gdGhlIHJvb3Rcblx0XHRcdFx0KTtcblx0XHRcdC8vIG1qcyAtIGlzIHRoZSByb290IHByb3RlY3RlZD9cblx0XHRcdC8vIG1qcyAtIGFyZSB3ZSBuZXN0aW5nIHRvbyBkZWVwP1xuXHRcdFx0aWYgKFxuXHRcdFx0XHRkaXNhYmxlZEJ5UGFyZW50Y2hhbmdlIHx8XG5cdFx0XHRcdCFvLmlzQWxsb3dlZCh0aGlzLnBsYWNlaG9sZGVyLCBwYXJlbnRJdGVtLCB0aGlzLmN1cnJlbnRJdGVtKVxuXHRcdFx0KSB7XG5cdFx0XHRcdHRoaXMucGxhY2Vob2xkZXIuYWRkQ2xhc3Moby5lcnJvckNsYXNzKTtcblx0XHRcdFx0aWYgKG1heExldmVscyA8IGxldmVscyAmJiBtYXhMZXZlbHMgIT09IDApIHtcblx0XHRcdFx0XHR0aGlzLmJleW9uZE1heExldmVscyA9IGxldmVscyAtIG1heExldmVscztcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHR0aGlzLmJleW9uZE1heExldmVscyA9IDE7XG5cdFx0XHRcdH1cblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdGlmIChtYXhMZXZlbHMgPCBsZXZlbHMgJiYgbWF4TGV2ZWxzICE9PSAwKSB7XG5cdFx0XHRcdFx0dGhpcy5wbGFjZWhvbGRlci5hZGRDbGFzcyhvLmVycm9yQ2xhc3MpO1xuXHRcdFx0XHRcdHRoaXMuYmV5b25kTWF4TGV2ZWxzID0gbGV2ZWxzIC0gbWF4TGV2ZWxzO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdHRoaXMucGxhY2Vob2xkZXIucmVtb3ZlQ2xhc3Moby5lcnJvckNsYXNzKTtcblx0XHRcdFx0XHR0aGlzLmJleW9uZE1heExldmVscyA9IDA7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0fSkpO1xuXG5cdCQubWpzLm5lc3RlZFNvcnRhYmxlLnByb3RvdHlwZS5vcHRpb25zID0gJC5leHRlbmQoXG5cdFx0e30sXG5cdFx0JC51aS5zb3J0YWJsZS5wcm90b3R5cGUub3B0aW9ucyxcblx0XHQkLm1qcy5uZXN0ZWRTb3J0YWJsZS5wcm90b3R5cGUub3B0aW9uc1xuXHQpO1xufSkpO1xuIiwibW9kdWxlLmV4cG9ydHMgPSBfeGVfZGxsX2NvbW1vbjsiXSwic291cmNlUm9vdCI6IiJ9