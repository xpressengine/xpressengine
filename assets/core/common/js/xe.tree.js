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
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/json/stringify */ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_2__);




/** @private */
var _nodeTemplate;

var Item = /*#__PURE__*/function () {
  function Item() {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, Item);
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(Item, [{
    key: "getTemplate",
    value:
    /**
     * item 템플릿을 리턴한다.
     * @memberof Item
     * @param {object} obj
     **/
    function getTemplate(obj) {
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
        itemNode += "<div class='item-content' data-item='" + _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_2___default()(item) + "'>";
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
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/classCallCheck */ "./node_modules/@babel/runtime-corejs3/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/helpers/createClass */ "./node_modules/@babel/runtime-corejs3/helpers/createClass.js");
/* harmony import */ var _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2__);
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

var Tree = /*#__PURE__*/function () {
  function Tree() {
    _babel_runtime_corejs3_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, Tree);
  }

  _babel_runtime_corejs3_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(Tree, [{
    key: "getItemsTemplate",
    value:
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
    function getItemsTemplate(obj) {
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

          var itemData = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($item).call($item, '> .item-content').data('item');

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
          var moveParentId = $parentItem.length > 0 ? _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($parentItem).call($parentItem, '> .item-content').data('item').id : $item.parents('.item-container').data('parent');

          var moveOrdering = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context = $item.closest('ul').addClass('item-container')).call(_context, '> li.item').index($item);

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

      if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($target).call($target, '.item-container').length > 0) {
        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($target).call($target, '.item-container').nestedSortable(options);
      } else {
        $target.append('<ul class="item-container"></ul>');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($target).call($target, '.item-container').nestedSortable(options);
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(6);

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

/***/ "./node_modules/jquery-ui/ui/data.js":
/*!*******************************************!*\
  !*** ./node_modules/jquery-ui/ui/data.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI :data 1.13.2
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
	"use strict";

	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} )( function( $ ) {
"use strict";

return $.extend( $.expr.pseudos, {
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
} );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/ie.js":
/*!*****************************************!*\
  !*** ./node_modules/jquery-ui/ui/ie.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;( function( factory ) {
	"use strict";

	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} )( function( $ ) {
"use strict";

// This file is deprecated
return $.ui.ie = !!/msie [\w.]+/.exec( navigator.userAgent.toLowerCase() );
} );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/scroll-parent.js":
/*!****************************************************!*\
  !*** ./node_modules/jquery-ui/ui/scroll-parent.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Scroll Parent 1.13.2
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
	"use strict";

	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} )( function( $ ) {
"use strict";

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

} );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/version.js":
/*!**********************************************!*\
  !*** ./node_modules/jquery-ui/ui/version.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;( function( factory ) {
	"use strict";

	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} )( function( $ ) {
"use strict";

$.ui = $.ui || {};

return $.ui.version = "1.13.2";

} );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/widget.js":
/*!*********************************************!*\
  !*** ./node_modules/jquery-ui/ui/widget.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Widget 1.13.2
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
	"use strict";

	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} )( function( $ ) {
"use strict";

var widgetUuid = 0;
var widgetHasOwnProperty = Array.prototype.hasOwnProperty;
var widgetSlice = Array.prototype.slice;

$.cleanData = ( function( orig ) {
	return function( elems ) {
		var events, elem, i;
		for ( i = 0; ( elem = elems[ i ] ) != null; i++ ) {

			// Only trigger remove when necessary to save time
			events = $._data( elem, "events" );
			if ( events && events.remove ) {
				$( elem ).triggerHandler( "remove" );
			}
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

	if ( Array.isArray( prototype ) ) {
		prototype = $.extend.apply( null, [ {} ].concat( prototype ) );
	}

	// Create selector for plugin
	$.expr.pseudos[ fullName.toLowerCase() ] = function( elem ) {
		return !!$.data( elem, fullName );
	};

	$[ namespace ] = $[ namespace ] || {};
	existingConstructor = $[ namespace ][ name ];
	constructor = $[ namespace ][ name ] = function( options, element ) {

		// Allow instantiation without "new" keyword
		if ( !this || !this._createWidget ) {
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
		if ( typeof value !== "function" ) {
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
			if ( widgetHasOwnProperty.call( input[ inputIndex ], key ) && value !== undefined ) {

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

					if ( typeof instance[ options ] !== "function" ||
						options.charAt( 0 ) === "_" ) {
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

		function bindRemoveEvent() {
			var nodesToBind = [];

			options.element.each( function( _, element ) {
				var isTracked = $.map( that.classesElementLookup, function( elements ) {
					return elements;
				} )
					.some( function( elements ) {
						return elements.is( element );
					} );

				if ( !isTracked ) {
					nodesToBind.push( element );
				}
			} );

			that._on( $( nodesToBind ), {
				remove: "_untrackClassesElement"
			} );
		}

		function processClassString( classes, checkOption ) {
			var current, i;
			for ( i = 0; i < classes.length; i++ ) {
				current = that.classesElementLookup[ classes[ i ] ] || $();
				if ( options.add ) {
					bindRemoveEvent();
					current = $( $.uniqueSort( current.get().concat( options.element.get() ) ) );
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

		this._off( $( event.target ) );
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
		element.off( eventName );

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
		return !( typeof callback === "function" &&
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
		} else if ( options === true ) {
			options = {};
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

} );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/widgets/mouse.js":
/*!****************************************************!*\
  !*** ./node_modules/jquery-ui/ui/widgets/mouse.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Mouse 1.13.2
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
	"use strict";

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
} )( function( $ ) {
"use strict";

var mouseHandled = false;
$( document ).on( "mouseup", function() {
	mouseHandled = false;
} );

return $.widget( "ui.mouse", {
	version: "1.13.2",
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
		if ( this._mouseStarted ) {
			this._mouseUp( event );
		}

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
			if ( this._mouseStarted ) {
				this._mouseDrag( event );
			} else {
				this._mouseUp( event );
			}
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
	_mouseCapture: function( /* event */ ) {
		return true;
	}
} );

} );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/widgets/sortable.js":
/*!*******************************************************!*\
  !*** ./node_modules/jquery-ui/ui/widgets/sortable.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Sortable 1.13.2
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
	"use strict";

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
} )( function( $ ) {
"use strict";

return $.widget( "ui.sortable", $.ui.mouse, {
	version: "1.13.2",
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

		//Prepare the dragged items parent
		this.appendTo = $( o.appendTo !== "parent" ?
				o.appendTo :
				this.currentItem.parent() );

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

			// This is a relative to absolute position minus the actual position calculation -
			// only used for relative positioned helper
			relative: this._getRelativeOffset()
		} );

		// After we get the helper offset, but before we get the parent offset we can
		// change the helper's position to absolute
		// TODO: Still need to figure out a way to make relative sorting possible
		this.helper.css( "position", "absolute" );
		this.cssPosition = this.helper.css( "position" );

		//Adjust the mouse offset relative to the helper if "cursorAt" is supplied
		if ( o.cursorAt ) {
			this._adjustOffsetFromHelper( o.cursorAt );
		}

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

		//Get the next scrolling parent
		this.scrollParent = this.placeholder.scrollParent();

		$.extend( this.offset, {
			parent: this._getParentOffset()
		} );

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

		// We need to make sure to grab the zIndex before setting the
		// opacity, because setting the opacity to anything lower than 1
		// causes the zIndex to change from "auto" to 0.
		if ( o.zIndex ) { // zIndex option
			if ( this.helper.css( "zIndex" ) ) {
				this._storedZIndex = this.helper.css( "zIndex" );
			}
			this.helper.css( "zIndex", o.zIndex );
		}

		if ( o.opacity ) { // opacity option
			if ( this.helper.css( "opacity" ) ) {
				this._storedOpacity = this.helper.css( "opacity" );
			}
			this.helper.css( "opacity", o.opacity );
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

		//Move the helper, if needed
		if ( !this.helper.parent().is( this.appendTo ) ) {
			this.helper.detach().appendTo( this.appendTo );

			//Update position
			this.offset.parent = this._getParentOffset();
		}

		//Generate the original position
		this.position = this.originalPosition = this._generatePosition( event );
		this.originalPageX = event.pageX;
		this.originalPageY = event.pageY;
		this.lastPositionAbs = this.positionAbs = this._convertPositionTo( "absolute" );

		this._mouseDrag( event );

		return true;

	},

	_scroll: function( event ) {
		var o = this.options,
			scrolled = false;

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

		return scrolled;
	},

	_mouseDrag: function( event ) {
		var i, item, itemElement, intersection,
			o = this.options;

		//Compute the helpers position
		this.position = this._generatePosition( event );
		this.positionAbs = this._convertPositionTo( "absolute" );

		//Set the helper position
		if ( !this.options.axis || this.options.axis !== "y" ) {
			this.helper[ 0 ].style.left = this.position.left + "px";
		}
		if ( !this.options.axis || this.options.axis !== "x" ) {
			this.helper[ 0 ].style.top = this.position.top + "px";
		}

		//Do scrolling
		if ( o.scroll ) {
			if ( this._scroll( event ) !== false ) {

				//Update item positions used in position checks
				this._refreshItemPositions( true );

				if ( $.ui.ddmanager && !o.dropBehaviour ) {
					$.ui.ddmanager.prepareOffsets( this, event );
				}
			}
		}

		this.dragDirection = {
			vertical: this._getDragVerticalDirection(),
			horizontal: this._getDragHorizontalDirection()
		};

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
				this.placeholder[ intersection === 1 ?
				"next" : "prev" ]()[ 0 ] !== itemElement &&
				!$.contains( this.placeholder[ 0 ], itemElement ) &&
				( this.options.type === "semi-dynamic" ?
					!$.contains( this.element[ 0 ], itemElement ) :
					true
				)
			) {

				this.direction = intersection === 1 ? "down" : "up";

				if ( this.options.tolerance === "pointer" ||
						this._intersectsWithSides( item ) ) {
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

		verticalDirection = this.dragDirection.vertical;
		horizontalDirection = this.dragDirection.horizontal;

		return this.floating ?
			( ( horizontalDirection === "right" || verticalDirection === "down" ) ? 2 : 1 ) :
			( verticalDirection && ( verticalDirection === "down" ? 2 : 1 ) );

	},

	_intersectsWithSides: function( item ) {

		var isOverBottomHalf = this._isOverAxis( this.positionAbs.top +
				this.offset.click.top, item.top + ( item.height / 2 ), item.height ),
			isOverRightHalf = this._isOverAxis( this.positionAbs.left +
				this.offset.click.left, item.left + ( item.width / 2 ), item.width ),
			verticalDirection = this.dragDirection.vertical,
			horizontalDirection = this.dragDirection.horizontal;

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
						queries.push( [ typeof inst.options.items === "function" ?
							inst.options.items.call( inst.element ) :
							$( inst.options.items, inst.element )
								.not( ".ui-sortable-helper" )
								.not( ".ui-sortable-placeholder" ), inst ] );
					}
				}
			}
		}

		queries.push( [ typeof this.options.items === "function" ?
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
			queries = [ [ typeof this.options.items === "function" ?
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
						queries.push( [ typeof inst.options.items === "function" ?
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

	_refreshItemPositions: function( fast ) {
		var i, item, t, p;

		for ( i = this.items.length - 1; i >= 0; i-- ) {
			item = this.items[ i ];

			//We ignore calculating positions of all connected containers when we're not over them
			if ( this.currentContainer && item.instance !== this.currentContainer &&
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
	},

	refreshPositions: function( fast ) {

		// Determine whether items are being displayed horizontally
		this.floating = this.items.length ?
			this.options.axis === "x" || this._isFloating( this.items[ 0 ].item ) :
			false;

		// This has to be redone because due to the item being moved out/into the offsetParent,
		// the offsetParent's position will change
		if ( this.offsetParent && this.helper ) {
			this.offset.parent = this._getParentOffset();
		}

		this._refreshItemPositions( fast );

		var i, p;

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
		var className, nodeName,
			o = that.options;

		if ( !o.placeholder || o.placeholder.constructor === String ) {
			className = o.placeholder;
			nodeName = that.currentItem[ 0 ].nodeName.toLowerCase();
			o.placeholder = {
				element: function() {

					var element = $( "<" + nodeName + ">", that.document[ 0 ] );

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

					// If the element doesn't have a actual height or width by itself (without
					// styles coming from a stylesheet), it receives the inline height and width
					// from the dragged item. Or, if it's a tbody or tr, it's going to have a height
					// anyway since we're populating them with <td>s above, but they're unlikely to
					// be the correct height on their own if the row heights are dynamic, so we'll
					// always assign the height of the dragged item given forcePlaceholderSize
					// is true.
					if ( !p.height() || ( o.forcePlaceholderSize &&
							( nodeName === "tbody" || nodeName === "tr" ) ) ) {
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

			if ( itemWithLeastDistance ) {
				this._rearrange( event, itemWithLeastDistance, null, true );
			} else {
				this._rearrange( event, null, this.containers[ innermostIndex ].element, true );
			}
			this._trigger( "change", event, this._uiHash() );
			this.containers[ innermostIndex ]._trigger( "change", event, this._uiHash( this ) );
			this.currentContainer = this.containers[ innermostIndex ];

			//Update the placeholder
			this.options.placeholder.update( this.currentContainer, this.placeholder );

			//Update scrollParent
			this.scrollParent = this.placeholder.scrollParent();

			//Update overflowOffset
			if ( this.scrollParent[ 0 ] !== this.document[ 0 ] &&
					this.scrollParent[ 0 ].tagName !== "HTML" ) {
				this.overflowOffset = this.scrollParent.offset();
			}

			this.containers[ innermostIndex ]._trigger( "over", event, this._uiHash( this ) );
			this.containers[ innermostIndex ].containerCache.over = 1;
		}

	},

	_createHelper: function( event ) {

		var o = this.options,
			helper = typeof o.helper === "function" ?
				$( o.helper.apply( this.element[ 0 ], [ event, this.currentItem ] ) ) :
				( o.helper === "clone" ? this.currentItem.clone() : this.currentItem );

		//Add the helper to the DOM if that didn't happen already
		if ( !helper.parents( "body" ).length ) {
			this.appendTo[ 0 ].appendChild( helper[ 0 ] );
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
		if ( Array.isArray( obj ) ) {
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

		if ( a ) {
			a[ 0 ].appendChild( this.placeholder[ 0 ] );
		} else {
			i.item[ 0 ].parentNode.insertBefore( this.placeholder[ 0 ],
				( this.direction === "down" ? i.item[ 0 ] : i.item[ 0 ].nextSibling ) );
		}

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

} );


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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS90cmVlL0l0ZW0uanMiLCJ3ZWJwYWNrOi8vLy4vY29yZS90cmVlL1RyZWUuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9oZWxwZXJzL2NsYXNzQ2FsbENoZWNrLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvaGVscGVycy9jcmVhdGVDbGFzcy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9lcy9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9pbnRlcm5hbHMvZnVuY3Rpb24tYXBwbHkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9wYXRoLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMtcHVyZS9tb2R1bGVzL2VzLmpzb24uc3RyaW5naWZ5LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LXVpL3VpL2RhdGEuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS9pZS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LXVpL3VpL3Njcm9sbC1wYXJlbnQuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS92ZXJzaW9uLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9qcXVlcnktdWkvdWkvd2lkZ2V0LmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9qcXVlcnktdWkvdWkvd2lkZ2V0cy9tb3VzZS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LXVpL3VpL3dpZGdldHMvc29ydGFibGUuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9qcXVlcnkvc3JjL2pxdWVyeS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9sb2Rhc2gvbG9kYXNoLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbmVzdGVkU29ydGFibGUvanF1ZXJ5Lm1qcy5uZXN0ZWRTb3J0YWJsZS5qcyIsIndlYnBhY2s6Ly8vZXh0ZXJuYWwgXCJfeGVfZGxsX2NvbW1vblwiIl0sIm5hbWVzIjpbIl9ub2RlVGVtcGxhdGUiLCJJdGVtIiwib2JqIiwibm9kZVRlbXBsYXRlIiwiZ2V0SXRlbXNUZW1wbGF0ZSIsIml0ZW1zIiwicm9vdElkIiwiaXNSb290IiwidGVtcCIsImxlbmd0aCIsIm1ha2VJdGVtIiwiaXRlbU5vZGUiLCJwcm9wIiwiaXRlbSIsIm1vdmUiLCJpZCIsIk9iamVjdCIsIl9wcmV2ZW50IiwiZGVmYXVsdE9wdGlvbnMiLCJjb25uZWN0V2l0aCIsImZvcmNlUGxhY2Vob2xkZXJTaXplIiwiaGVscGVyIiwiaGFuZGxlIiwibGlzdFR5cGUiLCJvcGFjaXR5IiwiaXNUcmVlIiwiY2FuY2VsIiwidG9sZXJhbmNlIiwidG9sZXJhbmNlRWxlbWVudCIsIlRyZWUiLCJnZXRUZW1wbGF0ZSIsImZsYWciLCIkdGFyZ2V0IiwiY29uZmlnIiwidHJlZU9wdGlvbnMiLCJwYXJlbnRJZCIsIm9yZGVyaW5nIiwiaXRlbUlkIiwib3B0aW9ucyIsIiQiLCJleHRlbmQiLCJfIiwiaXNPYmplY3QiLCJpc0Z1bmN0aW9uIiwic3RhcnQiLCJlIiwidWkiLCIkaXRlbSIsIml0ZW1EYXRhIiwiZGF0YSIsImRyYWdTdGFydCIsInN0b3AiLCIkcGFyZW50SXRlbSIsInBhcmVudHMiLCJlcSIsIm1vdmVQYXJlbnRJZCIsIm1vdmVPcmRlcmluZyIsImNsb3Nlc3QiLCJhZGRDbGFzcyIsImluZGV4IiwiZHJhZ1N0b3AiLCJ1cGRhdGUiLCJyZWxvY2F0ZSIsInJlY2VpdmUiLCJwbGFjZWhvbGRlciIsImVsZW1lbnQiLCJjbG9uZSIsInNob3ciLCJ3cmFwQWxsIiwicGFyZW50IiwiaHRtbCIsImlzQWxsb3dlZCIsInBsYWNlaG9sZGVyUGFyZW50IiwiY3VycmVudEl0ZW0iLCJuZXN0ZWRTb3J0YWJsZSIsImFwcGVuZCIsIiRjb250YWluZXIiLCJmbiIsIm5lc3RlZCIsIndpbmRvdyJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7UUFDdkQsaUNBQWlDLGVBQWU7UUFDaEQ7UUFDQTtRQUNBOztRQUVBO1FBQ0Esc0RBQXNELCtEQUErRDs7UUFFckg7UUFDQTs7O1FBR0E7UUFDQTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDbEZBO0FBQ0EsSUFBSUEsYUFBSjs7SUFFTUMsSTs7Ozs7Ozs7SUFDSjtBQUNGO0FBQ0E7QUFDQTtBQUNBO0lBQ0UscUJBQWFDLEdBQWIsRUFBa0I7TUFDaEJGLGFBQWEsR0FBR0UsR0FBRyxDQUFDQyxZQUFwQjtNQUVBLE9BQU8sS0FBS0MsZ0JBQUwsQ0FBc0JGLEdBQUcsQ0FBQ0csS0FBMUIsRUFBaUNILEdBQUcsQ0FBQ0ksTUFBckMsRUFBNkMsSUFBN0MsQ0FBUDtJQUNEO0lBRUQ7QUFDRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7OztXQUNFLDBCQUFrQkQsS0FBbEIsRUFBeUJDLE1BQXpCLEVBQWlDQyxNQUFqQyxFQUF5QztNQUN2QyxJQUFJQyxJQUFJLEdBQUcsRUFBWDs7TUFFQSxJQUFJSCxLQUFLLElBQUlBLEtBQUssQ0FBQ0ksTUFBTixJQUFnQixDQUF6QixJQUE4QkYsTUFBbEMsRUFBMEM7UUFDeEMsSUFBSUEsTUFBTSxJQUFJRCxNQUFkLEVBQXNCO1VBQ3BCRSxJQUFJLElBQUksNkNBQTZDRixNQUE3QyxHQUFzRCxJQUE5RDtRQUNELENBRkQsTUFFTztVQUNMRSxJQUFJLElBQUksNkJBQVI7UUFDRDtNQUNGOztNQUVEQSxJQUFJLElBQUksS0FBS0UsUUFBTCxDQUFjTCxLQUFkLEVBQXFCTCxhQUFyQixDQUFSOztNQUVBLElBQUlLLEtBQUssSUFBSUEsS0FBSyxDQUFDSSxNQUFOLElBQWdCLENBQXpCLElBQThCRixNQUFsQyxFQUEwQztRQUN4Q0MsSUFBSSxJQUFJLE9BQVI7TUFDRDs7TUFFRCxPQUFPQSxJQUFQO0lBQ0Q7SUFFRDtBQUNGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7O1dBQ0Usa0JBQVVILEtBQVYsRUFBaUJGLFlBQWpCLEVBQStCO01BQzdCLElBQUlRLFFBQVEsR0FBRyxFQUFmOztNQUVBLEtBQUssSUFBTUMsSUFBWCxJQUFtQlAsS0FBbkIsRUFBMEI7UUFDeEIsSUFBTVEsSUFBSSxHQUFHUixLQUFLLENBQUNPLElBQUQsQ0FBbEI7UUFDQSxJQUFNRSxJQUFJLEdBQUlELElBQUksQ0FBQ1IsS0FBTCxJQUFjUSxJQUFJLENBQUNSLEtBQUwsQ0FBV0ksTUFBMUIsR0FBb0MsTUFBcEMsR0FBNkMsRUFBMUQ7UUFFQUUsUUFBUSxJQUFJLHFCQUFxQkcsSUFBckIsR0FBNEIsYUFBNUIsR0FBNENELElBQUksQ0FBQ0UsRUFBakQsR0FBc0QsSUFBbEU7UUFDQUosUUFBUSxJQUFJLDBDQUEwQyw0RkFBZUUsSUFBZixDQUExQyxHQUFpRSxJQUE3RTtRQUNBRixRQUFRLElBQUksdUVBQVo7UUFDQUEsUUFBUSxJQUFJUixZQUFZLENBQUNVLElBQUQsQ0FBeEI7UUFDQUYsUUFBUSxJQUFJLFFBQVo7O1FBRUEsSUFBSUUsSUFBSSxDQUFDUixLQUFMLElBQWNRLElBQUksQ0FBQ1IsS0FBTCxZQUFzQlcsTUFBeEMsRUFBZ0Q7VUFDOUNMLFFBQVEsSUFBSSxLQUFLUCxnQkFBTCxDQUFzQlMsSUFBSSxDQUFDUixLQUEzQixDQUFaO1FBQ0Q7O1FBRURNLFFBQVEsSUFBSSxPQUFaO01BQ0Q7O01BRUQsT0FBT0EsUUFBUDtJQUNEOzs7Ozs7QUFHWSxtRUFBSVYsSUFBSixFQUFmLEU7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDOUVBO0FBQ0E7QUFDQTtBQUNBO0FBRUEsSUFBSWdCLFFBQVEsR0FBRyxLQUFmO0FBRUEsSUFBTUMsY0FBYyxHQUFHO0VBQ3JCQyxXQUFXLEVBQUUsaUJBRFE7RUFFckJDLG9CQUFvQixFQUFFLElBRkQ7RUFHckJDLE1BQU0sRUFBRSxPQUhhO0VBSXJCQyxNQUFNLEVBQUUsd0JBSmE7RUFLckJDLFFBQVEsRUFBRSxJQUxXO0VBTXJCbEIsS0FBSyxFQUFFLElBTmM7RUFPckJtQixPQUFPLEVBQUUsR0FQWTtFQVFyQkMsTUFBTSxFQUFFLElBUmE7RUFTckJDLE1BQU0sRUFBRSxFQVRhO0VBVXJCQyxTQUFTLEVBQUUsU0FWVTtFQVdyQkMsZ0JBQWdCLEVBQUU7QUFYRyxDQUF2Qjs7SUFjTUMsSTs7Ozs7Ozs7SUFDSjtBQUNGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0lBQ0UsMEJBQWtCM0IsR0FBbEIsRUFBdUI7TUFDckIsT0FBT0QsNkNBQUksQ0FBQzZCLFdBQUwsQ0FBaUI1QixHQUFqQixDQUFQO0lBQ0Q7SUFFRDtBQUNGO0FBQ0E7QUFDQTtBQUNBOzs7O1dBQ0Usb0JBQVk2QixJQUFaLEVBQWtCO01BQ2hCZCxRQUFRLEdBQUdjLElBQVg7SUFDRDtJQUVEO0FBQ0Y7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7O1dBQ0UsYUFBS0MsT0FBTCxFQUFjQyxNQUFkLEVBQXNCQyxXQUF0QixFQUFtQztNQUNqQyxJQUFJQyxRQUFKO01BQ0EsSUFBSUMsUUFBSjtNQUNBLElBQUlDLE1BQUo7TUFDQSxJQUFJQyxPQUFPLEdBQUdDLDZDQUFDLENBQUNDLE1BQUYsQ0FBUyxFQUFULEVBQWF0QixjQUFiLENBQWQsQ0FKaUMsQ0FNakM7O01BQ0EsSUFBSXVCLDZDQUFDLENBQUNDLFFBQUYsQ0FBV1IsV0FBWCxDQUFKLEVBQTZCO1FBQzNCSyw2Q0FBQyxDQUFDQyxNQUFGLENBQVNGLE9BQVQsRUFBa0JKLFdBQWxCO01BQ0QsQ0FUZ0MsQ0FXakM7OztNQUNBLElBQUlPLDZDQUFDLENBQUNDLFFBQUYsQ0FBV1IsV0FBWCxLQUEyQk8sNkNBQUMsQ0FBQ0UsVUFBRixDQUFhVCxXQUFXLENBQUNVLEtBQXpCLENBQS9CLEVBQWdFO1FBQzlETixPQUFPLENBQUNNLEtBQVIsR0FBZ0JWLFdBQVcsQ0FBQ1UsS0FBNUI7TUFDRCxDQUZELE1BRU87UUFDTE4sT0FBTyxDQUFDTSxLQUFSLEdBQWdCLFVBQVVDLENBQVYsRUFBYUMsRUFBYixFQUFpQjtVQUMvQixJQUFNQyxLQUFLLEdBQUdSLDZDQUFDLENBQUNPLEVBQUUsQ0FBQ2pDLElBQUosQ0FBZjs7VUFDQSxJQUFNbUMsUUFBUSxHQUFHLDJGQUFBRCxLQUFLLE1BQUwsQ0FBQUEsS0FBSyxFQUFNLGlCQUFOLENBQUwsQ0FBOEJFLElBQTlCLENBQW1DLE1BQW5DLENBQWpCOztVQUVBZCxRQUFRLEdBQUdhLFFBQVEsQ0FBQ2IsUUFBcEI7VUFDQUMsUUFBUSxHQUFHWSxRQUFRLENBQUNaLFFBQXBCO1VBQ0FDLE1BQU0sR0FBR1csUUFBUSxDQUFDakMsRUFBbEI7O1VBRUEsSUFBSTBCLDZDQUFDLENBQUNDLFFBQUYsQ0FBV1QsTUFBWCxLQUFzQlEsNkNBQUMsQ0FBQ0UsVUFBRixDQUFhVixNQUFNLENBQUNpQixTQUFwQixDQUExQixFQUEwRDtZQUN4RGpCLE1BQU0sQ0FBQ2lCLFNBQVA7VUFDRDtRQUNGLENBWEQ7TUFZRCxDQTNCZ0MsQ0E2QmpDOzs7TUFDQSxJQUFJVCw2Q0FBQyxDQUFDQyxRQUFGLENBQVdSLFdBQVgsS0FBMkJPLDZDQUFDLENBQUNFLFVBQUYsQ0FBYVQsV0FBVyxDQUFDaUIsSUFBekIsQ0FBL0IsRUFBK0Q7UUFDN0RiLE9BQU8sQ0FBQ2EsSUFBUixHQUFlakIsV0FBVyxDQUFDaUIsSUFBM0I7TUFDRCxDQUZELE1BRU87UUFDTGIsT0FBTyxDQUFDYSxJQUFSLEdBQWUsVUFBVU4sQ0FBVixFQUFhQyxFQUFiLEVBQWlCO1VBQUE7O1VBQzlCLElBQU1DLEtBQUssR0FBR1IsNkNBQUMsQ0FBQ08sRUFBRSxDQUFDakMsSUFBSixDQUFmO1VBQ0EsSUFBTXVDLFdBQVcsR0FBR0wsS0FBSyxDQUFDTSxPQUFOLENBQWMsU0FBZCxFQUF5QkMsRUFBekIsQ0FBNEIsQ0FBNUIsQ0FBcEI7VUFDQSxJQUFNQyxZQUFZLEdBQUlILFdBQVcsQ0FBQzNDLE1BQVosR0FBcUIsQ0FBdEIsR0FBMkIsMkZBQUEyQyxXQUFXLE1BQVgsQ0FBQUEsV0FBVyxFQUFNLGlCQUFOLENBQVgsQ0FBb0NILElBQXBDLENBQXlDLE1BQXpDLEVBQWlEbEMsRUFBNUUsR0FBaUZnQyxLQUFLLENBQUNNLE9BQU4sQ0FBYyxpQkFBZCxFQUFpQ0osSUFBakMsQ0FBc0MsUUFBdEMsQ0FBdEc7O1VBQ0EsSUFBTU8sWUFBWSxHQUFHLHNHQUFBVCxLQUFLLENBQUNVLE9BQU4sQ0FBYyxJQUFkLEVBQW9CQyxRQUFwQixDQUE2QixnQkFBN0Isa0JBQW9ELFdBQXBELEVBQWlFQyxLQUFqRSxDQUF1RVosS0FBdkUsQ0FBckI7O1VBRUEsSUFBSU4sNkNBQUMsQ0FBQ0MsUUFBRixDQUFXVCxNQUFYLEtBQXNCUSw2Q0FBQyxDQUFDRSxVQUFGLENBQWFWLE1BQU0sQ0FBQzJCLFFBQXBCLENBQTFCLEVBQXlEO1lBQ3ZEM0IsTUFBTSxDQUFDMkIsUUFBUDtVQUNEOztVQUVELElBQUt6QixRQUFRLEtBQUtvQixZQUFiLElBQTZCLENBQUN0QyxRQUEvQixJQUE2Q21CLFFBQVEsS0FBS29CLFlBQWIsSUFBNkIsQ0FBQ3ZDLFFBQS9FLEVBQTBGO1lBQ3hGLElBQUl3Qiw2Q0FBQyxDQUFDQyxRQUFGLENBQVdULE1BQVgsS0FBc0JRLDZDQUFDLENBQUNFLFVBQUYsQ0FBYVYsTUFBTSxDQUFDNEIsTUFBcEIsQ0FBMUIsRUFBdUQ7Y0FDckQ1QixNQUFNLENBQUM0QixNQUFQLENBQWM7Z0JBQ1poRCxJQUFJLEVBQUVrQyxLQURNO2dCQUVaVixNQUFNLEVBQUVBLE1BRkk7Z0JBR1pGLFFBQVEsRUFBRW9CLFlBSEU7Z0JBSVpuQixRQUFRLEVBQUVvQjtjQUpFLENBQWQ7WUFNRDtVQUNGO1FBQ0YsQ0FwQkQ7TUFxQkQsQ0F0RGdDLENBd0RqQzs7O01BQ0EsSUFBSWYsNkNBQUMsQ0FBQ0MsUUFBRixDQUFXUixXQUFYLEtBQTJCTyw2Q0FBQyxDQUFDRSxVQUFGLENBQWFULFdBQVcsQ0FBQzRCLFFBQXpCLENBQS9CLEVBQW1FO1FBQ2pFeEIsT0FBTyxDQUFDd0IsUUFBUixHQUFtQjVCLFdBQVcsQ0FBQzRCLFFBQS9CO01BQ0QsQ0EzRGdDLENBNkRqQzs7O01BQ0EsSUFBSXJCLDZDQUFDLENBQUNDLFFBQUYsQ0FBV1IsV0FBWCxLQUEyQk8sNkNBQUMsQ0FBQ0UsVUFBRixDQUFhVCxXQUFXLENBQUM2QixPQUF6QixDQUEvQixFQUFrRTtRQUNoRXpCLE9BQU8sQ0FBQ3lCLE9BQVIsR0FBa0I3QixXQUFXLENBQUM2QixPQUE5QjtNQUNELENBaEVnQyxDQWtFakM7OztNQUNBLElBQUl0Qiw2Q0FBQyxDQUFDQyxRQUFGLENBQVdSLFdBQVgsS0FBMkJBLFdBQVcsQ0FBQzhCLFdBQTNDLEVBQXdEO1FBQ3REMUIsT0FBTyxDQUFDMEIsV0FBUixHQUFzQjlCLFdBQVcsQ0FBQzhCLFdBQWxDO01BQ0QsQ0FGRCxNQUVPO1FBQ0wxQixPQUFPLENBQUMwQixXQUFSLEdBQXNCO1VBQ3BCQyxPQUFPLEVBQUUsaUJBQVVqQyxPQUFWLEVBQW1CO1lBQzFCLE9BQU9BLE9BQU8sQ0FBQ2tDLEtBQVIsR0FBZ0JSLFFBQWhCLENBQXlCLE1BQXpCLEVBQWlDUyxJQUFqQyxHQUF3Q0MsT0FBeEMsQ0FBZ0QsU0FBaEQsRUFBMkRDLE1BQTNELEdBQW9FQyxJQUFwRSxFQUFQO1VBQ0QsQ0FIbUI7VUFJcEJULE1BQU0sRUFBRSxrQkFBWSxDQUFFO1FBSkYsQ0FBdEI7TUFNRDs7TUFFRCxJQUFJcEIsNkNBQUMsQ0FBQ0MsUUFBRixDQUFXUixXQUFYLEtBQTJCTyw2Q0FBQyxDQUFDRSxVQUFGLENBQWFULFdBQVcsQ0FBQ3FDLFNBQXpCLENBQS9CLEVBQW9FO1FBQ2xFakMsT0FBTyxDQUFDaUMsU0FBUixHQUFvQnJDLFdBQVcsQ0FBQ3FDLFNBQWhDO01BQ0QsQ0FGRCxNQUVPO1FBQ0xqQyxPQUFPLENBQUNpQyxTQUFSLEdBQW9CLFVBQVVQLFdBQVYsRUFBdUJRLGlCQUF2QixFQUEwQ0MsV0FBMUMsRUFBdUQ7VUFDekUsT0FBTyxDQUFDeEQsUUFBUjtRQUNELENBRkQ7TUFHRDs7TUFFRCxJQUFJLDJGQUFBZSxPQUFPLE1BQVAsQ0FBQUEsT0FBTyxFQUFNLGlCQUFOLENBQVAsQ0FBZ0N2QixNQUFoQyxHQUF5QyxDQUE3QyxFQUFnRDtRQUM5QywyRkFBQXVCLE9BQU8sTUFBUCxDQUFBQSxPQUFPLEVBQU0saUJBQU4sQ0FBUCxDQUFnQzBDLGNBQWhDLENBQStDcEMsT0FBL0M7TUFDRCxDQUZELE1BRU87UUFDTE4sT0FBTyxDQUFDMkMsTUFBUixDQUFlLGtDQUFmOztRQUNBLDJGQUFBM0MsT0FBTyxNQUFQLENBQUFBLE9BQU8sRUFBTSxpQkFBTixDQUFQLENBQWdDMEMsY0FBaEMsQ0FBK0NwQyxPQUEvQztNQUNEO0lBQ0Y7SUFFRDtBQUNGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7O1dBQ0UsYUFBS3NDLFVBQUwsRUFBaUIxRSxHQUFqQixFQUFzQjJFLEVBQXRCLEVBQTBCO01BQ3hCLElBQUkzRSxHQUFHLENBQUM0RSxNQUFSLEVBQWdCO1FBQ2RGLFVBQVUsQ0FBQ0QsTUFBWCxDQUFrQjFFLDZDQUFJLENBQUM2QixXQUFMLENBQWlCNUIsR0FBakIsQ0FBbEI7TUFDRCxDQUZELE1BRU87UUFDTDBFLFVBQVUsQ0FBQ0QsTUFBWCxDQUFrQjFFLDZDQUFJLENBQUNTLFFBQUwsQ0FBY1IsR0FBRyxDQUFDRyxLQUFsQixFQUF5QkgsR0FBRyxDQUFDQyxZQUE3QixDQUFsQjtNQUNEOztNQUVELElBQUkwRSxFQUFFLElBQUksT0FBT0EsRUFBUCxLQUFjLFVBQXhCLEVBQW9DO1FBQ2xDQSxFQUFFO01BQ0g7SUFDRjs7Ozs7O0FBR0hFLE1BQU0sQ0FBQ2xELElBQVAsR0FBYyxJQUFJQSxJQUFKLEVBQWQ7QUFFZWtELHFFQUFNLENBQUNsRCxJQUF0QixFOzs7Ozs7Ozs7OztBQ25MQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSxpQkFBaUIsbUJBQU8sQ0FBQyxnR0FBb0MsRTs7Ozs7Ozs7Ozs7QUNBN0QsOEc7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsbUJBQU8sQ0FBQyxpR0FBaUM7QUFDekMsV0FBVyxtQkFBTyxDQUFDLDJFQUFzQjtBQUN6QyxZQUFZLG1CQUFPLENBQUMsK0ZBQWdDOztBQUVwRDtBQUNBLDZCQUE2Qjs7QUFFN0I7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQ1ZBLGdIOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLGdIOzs7Ozs7Ozs7OztBQ0FBLGFBQWEsbUJBQU8sQ0FBQyxpRkFBeUI7O0FBRTlDOzs7Ozs7Ozs7Ozs7QUNGQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsTUFBTSxJQUEwQzs7QUFFaEQ7QUFDQSxFQUFFLGlDQUFRLEVBQUUsd0VBQVEsRUFBRSw4RUFBVyxFQUFFLG9DQUFFLE9BQU87QUFBQTtBQUFBO0FBQUEsb0dBQUU7QUFDOUMsRUFBRSxNQUFNLEVBSU47QUFDRixDQUFDO0FBQ0Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBLENBQUM7QUFDRCxDQUFDOzs7Ozs7Ozs7Ozs7QUMxQ0Q7QUFDQTs7QUFFQSxNQUFNLElBQTBDOztBQUVoRDtBQUNBLEVBQUUsaUNBQVEsRUFBRSx3RUFBUSxFQUFFLDhFQUFXLEVBQUUsb0NBQUUsT0FBTztBQUFBO0FBQUE7QUFBQSxvR0FBRTtBQUM5QyxFQUFFLE1BQU0sRUFJTjtBQUNGLENBQUM7QUFDRDs7QUFFQTtBQUNBO0FBQ0EsQ0FBQzs7Ozs7Ozs7Ozs7O0FDakJEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQSxNQUFNLElBQTBDOztBQUVoRDtBQUNBLEVBQUUsaUNBQVEsRUFBRSx3RUFBUSxFQUFFLDhFQUFXLEVBQUUsb0NBQUUsT0FBTztBQUFBO0FBQUE7QUFBQSxvR0FBRTtBQUM5QyxFQUFFLE1BQU0sRUFJTjtBQUNGLENBQUM7QUFDRDs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxDQUFDOzs7Ozs7Ozs7Ozs7QUMvQ0Q7QUFDQTs7QUFFQSxNQUFNLElBQTBDOztBQUVoRDtBQUNBLEVBQUUsaUNBQVEsRUFBRSx3RUFBUSxFQUFFLG9DQUFFLE9BQU87QUFBQTtBQUFBO0FBQUEsb0dBQUU7QUFDakMsRUFBRSxNQUFNLEVBSU47QUFDRixDQUFDO0FBQ0Q7O0FBRUE7O0FBRUE7O0FBRUEsQ0FBQzs7Ozs7Ozs7Ozs7O0FDbkJEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBLE1BQU0sSUFBMEM7O0FBRWhEO0FBQ0EsRUFBRSxpQ0FBUSxFQUFFLHdFQUFRLEVBQUUsOEVBQVcsRUFBRSxvQ0FBRSxPQUFPO0FBQUE7QUFBQTtBQUFBLG9HQUFFO0FBQzlDLEVBQUUsTUFBTSxFQUlOO0FBQ0YsQ0FBQztBQUNEOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxjQUFjLCtCQUErQjs7QUFFN0M7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esd0NBQXdDO0FBQ3hDOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxzQkFBc0I7O0FBRXRCO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsNENBQTRDO0FBQzVDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsRUFBRTtBQUNGOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsRUFBRTtBQUNGO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7O0FBRUg7QUFDQTtBQUNBO0FBQ0EsRUFBRTtBQUNGO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsUUFBUSwwQkFBMEI7QUFDbEM7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLHlCQUF5Qjs7QUFFekI7QUFDQSx5QkFBeUI7O0FBRXpCO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLGlDQUFpQztBQUNqQztBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFD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QUFBO0FBQUE7QUFBQSxvR0FBRTtBQUNkLEVBQUUsTUFBTSxFQUlOO0FBQ0YsQ0FBQztBQUNEOztBQUVBO0FBQ0E7QUFDQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsRUFBRTtBQUNGO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLElBQUk7O0FBRUo7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLElBQUk7O0FBRUo7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7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O0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBOztBQUVBLEVBQUU7O0FBRUY7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTs7QUFFQSxHQUFHOztBQUVIO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLGtDQUFrQyxRQUFROztBQUUxQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSDtBQUNBOztBQUVBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7O0FBRUEsMkNBQTJDLGVBQWU7O0FBRTFEO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBOztBQUVBO0FBQ0EsNENBQTRDLFFBQVE7QUFDcEQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBOztBQUVBLHFDQUFxQztBQUNyQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJOztBQUVKO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBOztBQUVBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEdBQUc7QUFDSDs7QUFFQSxFQUFFOztBQUVGO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQSxxREFBcUQ7O0FBRXJEO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSDtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxvQ0FBb0MsUUFBUTtBQUM1QztBQUNBLDZCQUE2QixRQUFRO0FBQ3JDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLGdDQUFnQyxnREFBZ0Q7QUFDaEY7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLCtCQUErQixRQUFRO0FBQ3ZDO0FBQ0E7O0FBRUE7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTs7QUFFQTtBQUNBLG1CQUFtQixpQkFBaUI7QUFDcEM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7O0FBRUgsRUFBRTs7QUFFRjs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLHdEQUF3RCx5QkFBeUI7QUFDakY7QUFDQTs7QUFFQTtBQUNBO0FBQ0Esb0NBQW9DLFFBQVE7QUFDNUM7QUFDQSw2QkFBNkIsUUFBUTtBQUNyQztBQUNBO0FBQ0E7QUFDQTtBQUNBLDBDQUEwQyx5QkFBeUI7QUFDbkU7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLCtCQUErQixRQUFRO0FBQ3ZDO0FBQ0E7O0FBRUEsZ0RBQWdELG1CQUFtQjtBQUNuRTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTs7QUFFQSxFQUFFOztBQUVGO0FBQ0E7O0FBRUEsa0NBQWtDLFFBQVE7QUFDMUM7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEdBQUc7QUFDSCx3Q0FBd0MsUUFBUTtBQUNoRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxNQUFNO0FBQ047QUFDQSxNQUFNO0FBQ047QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQSxFQUFFOztBQUVGO0FBQ0E7O0FBRUE7QUFDQSxpQkFBaUI7QUFDakI7QUFDQTtBQUNBLEdBQUc7QUFDSCxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSx1Q0FBdUMsUUFBUTs7QUFFL0M7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQSxJQUFJOztBQUVKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsbUNBQW1DLFFBQVE7QUFDM0M7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxVQUFVO0FBQ1Y7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFNBQVM7QUFDVDs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsV0FBVztBQUNYOztBQUVBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxFQUFFOztBQUVGOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsZ0NBQWdDOztBQUVoQztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsRUFBRTs7QUFFRjs7QUFFQTtBQUNBO0FBQ0EsR0FBRztBQUNIO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSCxFQUFFOztBQUVGOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsdUNBQXVDLFFBQVE7QUFDL0M7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQSxvQ0FBb0M7QUFDcEM7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxlQUFlLDRCQUE0Qjs7QUFFM0M7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxDQUFDOztBQUVELENBQUM7Ozs7Ozs7Ozs7OztBQzlrREQsOEc7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSxNQUFNLElBQTBDOztBQUVoRDtBQUNBLEVBQUUsaUNBQU87QUFDVCxHQUFHLHdFQUFRO0FBQ1gsR0FBRyxnR0FBb0I7QUFDdkIsR0FBRyxvQ0FBRSxPQUFPO0FBQUE7QUFBQTtBQUFBLG9HQUFFO0FBQ2QsRUFBRSxNQUFNLEVBSU47QUFDRixDQUFDO0FBQ0Q7O0FBRUE7QUFDQTtBQUNBOztBQUVBLDJDQUEyQzs7QUFFM0M7QUFDQTtBQUNBO0FBQ0E7QUFDQSwwQkFBMEIsYUFBYSxFQUFFO0FBQ3pDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7O0FBRUg7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsUUFBUTtBQUNSO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxNQUFNO0FBQ047QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxNQUFNO0FBQ047QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLElBQUk7O0FBRUo7QUFDQTtBQUNBOztBQUVBO0FBQ0Esa0NBQWtDLFFBQVE7O0FBRTFDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsTUFBTTtBQUNOO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxRQUFRO0FBQ1I7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEsUUFBUTtBQUNSO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQSxJQUFJOztBQUVKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0EsSUFBSTs7QUFFSjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxNQUFNO0FBQ047QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBOztBQUVBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsNkRBQTZEO0FBQzdELEdBQUc7O0FBRUg7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsR0FBRzs7QUFFSDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUEsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLGtDQUFrQyxRQUFRO0FBQzFDO0FBQ0E7QUFDQTs7QUFFQSxHQUFHOztBQUVIOztBQUVBLHNCQUFzQjtBQUN0QjtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTs7QUFFSjtBQUNBO0FBQ0E7O0FBRUE7O0FBRUEsR0FBRzs7QUFFSDs7QUFFQSxzQkFBc0I7QUFDdEI7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsSUFBSTs7QUFFSjs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLG9DQUFvQztBQUNwQzs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQSw4QkFBOEIscUJBQXFCOztBQUVuRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDs7QUFFQSxzQkFBc0I7QUFDdEI7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLElBQUk7O0FBRUosa0NBQWtDLDBCQUEwQixFQUFFOztBQUU5RDs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxJQUFJOztBQUVKO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLEVBQUU7O0FBRUY7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBO0FBQ0EsQ0FBQzs7Ozs7Ozs7Ozs7O0FDNzRCRCxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9jb21tb24vanMveGUudHJlZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vY29yZS90cmVlL1RyZWUuanNcIik7XG4iLCIvKiogQHByaXZhdGUgKi9cbmxldCBfbm9kZVRlbXBsYXRlXG5cbmNsYXNzIEl0ZW0ge1xuICAvKipcbiAgICogaXRlbSDthZztlIzrpr/snYQg66as7YS07ZWc64ukLlxuICAgKiBAbWVtYmVyb2YgSXRlbVxuICAgKiBAcGFyYW0ge29iamVjdH0gb2JqXG4gICAqKi9cbiAgZ2V0VGVtcGxhdGUgKG9iaikge1xuICAgIF9ub2RlVGVtcGxhdGUgPSBvYmoubm9kZVRlbXBsYXRlXG5cbiAgICByZXR1cm4gdGhpcy5nZXRJdGVtc1RlbXBsYXRlKG9iai5pdGVtcywgb2JqLnJvb3RJZCwgdHJ1ZSlcbiAgfVxuXG4gIC8qKlxuICAgKiBpdGVtIO2FnO2UjOumv+ydhCDrpqzthLTtlZzri6QuXG4gICAqIEBtZW1iZXJvZiBJdGVtXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBpdGVtc1xuICAgKiBAcGFyYW0ge3N0cmluZ30gcm9vdElkXG4gICAqIEBwYXJhbSB7Ym9vbGVhbn0gaXNSb290XG4gICAqIEByZXR1cm4ge3N0cmluZ31cbiAgICoqL1xuICBnZXRJdGVtc1RlbXBsYXRlIChpdGVtcywgcm9vdElkLCBpc1Jvb3QpIHtcbiAgICBsZXQgdGVtcCA9ICcnXG5cbiAgICBpZiAoaXRlbXMgJiYgaXRlbXMubGVuZ3RoICE9IDAgfHwgaXNSb290KSB7XG4gICAgICBpZiAoaXNSb290ICYmIHJvb3RJZCkge1xuICAgICAgICB0ZW1wICs9ICc8dWwgY2xhc3M9XCJpdGVtLWNvbnRhaW5lclwiIGRhdGEtcGFyZW50PVwiJyArIHJvb3RJZCArICdcIj4nXG4gICAgICB9IGVsc2Uge1xuICAgICAgICB0ZW1wICs9ICc8dWwgY2xhc3M9XCJpdGVtLWNvbnRhaW5lclwiPidcbiAgICAgIH1cbiAgICB9XG5cbiAgICB0ZW1wICs9IHRoaXMubWFrZUl0ZW0oaXRlbXMsIF9ub2RlVGVtcGxhdGUpXG5cbiAgICBpZiAoaXRlbXMgJiYgaXRlbXMubGVuZ3RoICE9IDAgfHwgaXNSb290KSB7XG4gICAgICB0ZW1wICs9ICc8L3VsPidcbiAgICB9XG5cbiAgICByZXR1cm4gdGVtcFxuICB9XG5cbiAgLyoqXG4gICAgICogaXRlbSDthZztlIzrpr/snYQg66eM65Og64ukLlxuICAgICAqIEBtZW1iZXJvZiBJdGVtXG4gICAgICogQHBhcmFtIHtvYmplY3R9IG9ialxuICAgICAqIDxwcmU+XG4gICAgICogICBpdGVtc1xuICAgICAqICAgbm9kZVRlbXBsYXRlXG4gICAgICogPC9wcmU+XG4gICAgICogQHBhcmFtIHtmdW5jdGlvbn0gbm9kZVRlbXBsYXRlXG4gICAgICogQHJldHVybiB7c3RyaW5nfVxuICAgICAqKi9cbiAgbWFrZUl0ZW0gKGl0ZW1zLCBub2RlVGVtcGxhdGUpIHtcbiAgICBsZXQgaXRlbU5vZGUgPSAnJ1xuXG4gICAgZm9yIChjb25zdCBwcm9wIGluIGl0ZW1zKSB7XG4gICAgICBjb25zdCBpdGVtID0gaXRlbXNbcHJvcF1cbiAgICAgIGNvbnN0IG1vdmUgPSAoaXRlbS5pdGVtcyAmJiBpdGVtLml0ZW1zLmxlbmd0aCkgPyAnbW92ZScgOiAnJ1xuXG4gICAgICBpdGVtTm9kZSArPSBcIjxsaSBjbGFzcz0naXRlbSBcIiArIG1vdmUgKyBcIicgaWQ9J2l0ZW1fXCIgKyBpdGVtLmlkICsgXCInPlwiXG4gICAgICBpdGVtTm9kZSArPSBcIjxkaXYgY2xhc3M9J2l0ZW0tY29udGVudCcgZGF0YS1pdGVtPSdcIiArIEpTT04uc3RyaW5naWZ5KGl0ZW0pICsgXCInPlwiXG4gICAgICBpdGVtTm9kZSArPSBcIjxidXR0b24gY2xhc3M9J2J0biBoYW5kbGVyJz48aSBjbGFzcz0neGktZHJhZy12ZXJ0aWNhbCc+PC9pPjwvYnV0dG9uPlwiXG4gICAgICBpdGVtTm9kZSArPSBub2RlVGVtcGxhdGUoaXRlbSlcbiAgICAgIGl0ZW1Ob2RlICs9ICc8L2Rpdj4nXG5cbiAgICAgIGlmIChpdGVtLml0ZW1zICYmIGl0ZW0uaXRlbXMgaW5zdGFuY2VvZiBPYmplY3QpIHtcbiAgICAgICAgaXRlbU5vZGUgKz0gdGhpcy5nZXRJdGVtc1RlbXBsYXRlKGl0ZW0uaXRlbXMpXG4gICAgICB9XG5cbiAgICAgIGl0ZW1Ob2RlICs9ICc8L2xpPidcbiAgICB9XG5cbiAgICByZXR1cm4gaXRlbU5vZGVcbiAgfVxufVxuXG5leHBvcnQgZGVmYXVsdCBuZXcgSXRlbSgpXG4iLCJpbXBvcnQgJ25lc3RlZFNvcnRhYmxlJ1xuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IF8gZnJvbSAnbG9kYXNoJ1xuaW1wb3J0IEl0ZW0gZnJvbSAnLi9JdGVtJ1xuXG5sZXQgX3ByZXZlbnQgPSBmYWxzZVxuXG5jb25zdCBkZWZhdWx0T3B0aW9ucyA9IHtcbiAgY29ubmVjdFdpdGg6ICcuaXRlbS1jb250YWluZXInLFxuICBmb3JjZVBsYWNlaG9sZGVyU2l6ZTogdHJ1ZSxcbiAgaGVscGVyOiAnY2xvbmUnLFxuICBoYW5kbGU6ICcuaXRlbS1jb250ZW50IC5oYW5kbGVyJyxcbiAgbGlzdFR5cGU6ICd1bCcsXG4gIGl0ZW1zOiAnbGknLFxuICBvcGFjaXR5OiAwLjYsXG4gIGlzVHJlZTogdHJ1ZSxcbiAgY2FuY2VsOiAnJyxcbiAgdG9sZXJhbmNlOiAncG9pbnRlcicsXG4gIHRvbGVyYW5jZUVsZW1lbnQ6ICc+IGRpdidcbn1cblxuY2xhc3MgVHJlZSB7XG4gIC8qKlxuICAgKlxuICAgKiBAbWVtYmVyb2YgVHJlZVxuICAgKiBAcGFyYW0ge29iamVjdH0gb2JqXG4gICAqIDxwcmU+XG4gICAqICAgcm9vdElkOiB0cmVlIHJvb3QgaWRcbiAgICogICBub2RlVGVtcGxhdGU6IGl0ZW3slYjsl5Ag7IOd7ISx7ZWgIGh0bWxcbiAgICogICBpdGVtczogVHJlZSDqtazshLEg642w7J207YSwXG4gICAqIDwvcHJlPlxuICAgKiBAcmV0dXJuIHtzdHJpbmd9IGl0ZW1zIGh0bWxcbiAgICoqL1xuICBnZXRJdGVtc1RlbXBsYXRlIChvYmopIHtcbiAgICByZXR1cm4gSXRlbS5nZXRUZW1wbGF0ZShvYmopXG4gIH1cblxuICAvKipcbiAgICAgKiBAbWVtYmVyb2YgVHJlZVxuICAgICAqIEBwYXJhbSB7Ym9vbGVhbn0gZmxhZ1xuICAgICAqIEBkZXNjcmlwdGlvbiBUcmVlIOydtOuPmSDrsKnsp4BcbiAgICAgKiAqL1xuICBzZXRQcmV2ZW50IChmbGFnKSB7XG4gICAgX3ByZXZlbnQgPSBmbGFnXG4gIH1cblxuICAvKipcbiAgICogQG1lbWJlcm9mIFRyZWVcbiAgICogQHBhcmFtIHtvYmplY3R9ICR0YXJnZXQgdHJlZeq1rOyEseydmCB3cmFwcGVyXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBjb25maWdcbiAgICogPHByZT5cbiAgICogICDstpTqsIDsmLXshZhcbiAgICogICBkcmFnU3RhcnQgOiBkcmFnIOyLnOyekeyLnCDtmLjstpwgdHJlZU9wdGlvbuydmCBzdGFydOulvCDsmKTrsoTrnbzsnbTrk5wg6rCA64ql7ZWoLlxuICAgKiAgIGRyYWdTdG9wIDogZHJvcOyLnCDtmLjstpwgdHJlZU9wdGlvbuydmCBlbmTrpbwg7Jik67KE65287J2065OcIOqwgOuKpe2VqC5cbiAgICogICB1cGRhdGUgOiBkcmFn66W8IO2Gte2VnCB0cmVl7J2YIOuzgOuPmeyCrO2VreydtCDsnojsnYQg6rK97JqwIO2YuOy2nCBpdGVtLCBwYXJlbnQsIHRhcmdldCwgb3JkZXJpbmfrk7HsnZgg7KCV67O066W8IOyduOyekOuhnCDrs7TrgrTspIDri6RcbiAgICogPC9wcmU+XG4gICAqIEBwYXJhbSB7b2JqZWN0fSB0cmVlT3B0aW9ucyBuZXN0ZWRTb3J0YWJsZSBUcmVlIE9wdGlvbnNcbiAgICogQGRlc2NyaXB0aW9uIO2KuOumrCDqtazshLFcbiAgICoqL1xuICBydW4gKCR0YXJnZXQsIGNvbmZpZywgdHJlZU9wdGlvbnMpIHtcbiAgICBsZXQgcGFyZW50SWRcbiAgICBsZXQgb3JkZXJpbmdcbiAgICBsZXQgaXRlbUlkXG4gICAgbGV0IG9wdGlvbnMgPSAkLmV4dGVuZCh7fSwgZGVmYXVsdE9wdGlvbnMpXG5cbiAgICAvLyBjdXN0b20gb3B0aW9uIOy2lOqwgFxuICAgIGlmIChfLmlzT2JqZWN0KHRyZWVPcHRpb25zKSkge1xuICAgICAgJC5leHRlbmQob3B0aW9ucywgdHJlZU9wdGlvbnMpXG4gICAgfVxuXG4gICAgLy8gc3RhcnQgZnVuY3Rpb24g7LaU6rCAXG4gICAgaWYgKF8uaXNPYmplY3QodHJlZU9wdGlvbnMpICYmIF8uaXNGdW5jdGlvbih0cmVlT3B0aW9ucy5zdGFydCkpIHtcbiAgICAgIG9wdGlvbnMuc3RhcnQgPSB0cmVlT3B0aW9ucy5zdGFydFxuICAgIH0gZWxzZSB7XG4gICAgICBvcHRpb25zLnN0YXJ0ID0gZnVuY3Rpb24gKGUsIHVpKSB7XG4gICAgICAgIGNvbnN0ICRpdGVtID0gJCh1aS5pdGVtKVxuICAgICAgICBjb25zdCBpdGVtRGF0YSA9ICRpdGVtLmZpbmQoJz4gLml0ZW0tY29udGVudCcpLmRhdGEoJ2l0ZW0nKVxuXG4gICAgICAgIHBhcmVudElkID0gaXRlbURhdGEucGFyZW50SWRcbiAgICAgICAgb3JkZXJpbmcgPSBpdGVtRGF0YS5vcmRlcmluZ1xuICAgICAgICBpdGVtSWQgPSBpdGVtRGF0YS5pZFxuXG4gICAgICAgIGlmIChfLmlzT2JqZWN0KGNvbmZpZykgJiYgXy5pc0Z1bmN0aW9uKGNvbmZpZy5kcmFnU3RhcnQpKSB7XG4gICAgICAgICAgY29uZmlnLmRyYWdTdGFydCgpXG4gICAgICAgIH1cbiAgICAgIH1cbiAgICB9XG5cbiAgICAvLyBzdG9wIGZ1bmN0aW9uIOy2lOqwgFxuICAgIGlmIChfLmlzT2JqZWN0KHRyZWVPcHRpb25zKSAmJiBfLmlzRnVuY3Rpb24odHJlZU9wdGlvbnMuc3RvcCkpIHtcbiAgICAgIG9wdGlvbnMuc3RvcCA9IHRyZWVPcHRpb25zLnN0b3BcbiAgICB9IGVsc2Uge1xuICAgICAgb3B0aW9ucy5zdG9wID0gZnVuY3Rpb24gKGUsIHVpKSB7XG4gICAgICAgIGNvbnN0ICRpdGVtID0gJCh1aS5pdGVtKVxuICAgICAgICBjb25zdCAkcGFyZW50SXRlbSA9ICRpdGVtLnBhcmVudHMoJ2xpLml0ZW0nKS5lcSgwKVxuICAgICAgICBjb25zdCBtb3ZlUGFyZW50SWQgPSAoJHBhcmVudEl0ZW0ubGVuZ3RoID4gMCkgPyAkcGFyZW50SXRlbS5maW5kKCc+IC5pdGVtLWNvbnRlbnQnKS5kYXRhKCdpdGVtJykuaWQgOiAkaXRlbS5wYXJlbnRzKCcuaXRlbS1jb250YWluZXInKS5kYXRhKCdwYXJlbnQnKVxuICAgICAgICBjb25zdCBtb3ZlT3JkZXJpbmcgPSAkaXRlbS5jbG9zZXN0KCd1bCcpLmFkZENsYXNzKCdpdGVtLWNvbnRhaW5lcicpLmZpbmQoJz4gbGkuaXRlbScpLmluZGV4KCRpdGVtKVxuXG4gICAgICAgIGlmIChfLmlzT2JqZWN0KGNvbmZpZykgJiYgXy5pc0Z1bmN0aW9uKGNvbmZpZy5kcmFnU3RvcCkpIHtcbiAgICAgICAgICBjb25maWcuZHJhZ1N0b3AoKVxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKChwYXJlbnRJZCAhPT0gbW92ZVBhcmVudElkICYmICFfcHJldmVudCkgfHwgKG9yZGVyaW5nICE9PSBtb3ZlT3JkZXJpbmcgJiYgIV9wcmV2ZW50KSkge1xuICAgICAgICAgIGlmIChfLmlzT2JqZWN0KGNvbmZpZykgJiYgXy5pc0Z1bmN0aW9uKGNvbmZpZy51cGRhdGUpKSB7XG4gICAgICAgICAgICBjb25maWcudXBkYXRlKHtcbiAgICAgICAgICAgICAgaXRlbTogJGl0ZW0sXG4gICAgICAgICAgICAgIGl0ZW1JZDogaXRlbUlkLFxuICAgICAgICAgICAgICBwYXJlbnRJZDogbW92ZVBhcmVudElkLFxuICAgICAgICAgICAgICBvcmRlcmluZzogbW92ZU9yZGVyaW5nXG4gICAgICAgICAgICB9KVxuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfVxuICAgIH1cblxuICAgIC8vIHJlbG9jYXRlIGZ1bmN0aW9uIOy2lOqwgCBkZWZhdWx0IOyCrOyaqeyViO2VqC5cbiAgICBpZiAoXy5pc09iamVjdCh0cmVlT3B0aW9ucykgJiYgXy5pc0Z1bmN0aW9uKHRyZWVPcHRpb25zLnJlbG9jYXRlKSkge1xuICAgICAgb3B0aW9ucy5yZWxvY2F0ZSA9IHRyZWVPcHRpb25zLnJlbG9jYXRlXG4gICAgfVxuXG4gICAgLy8gcmVjZWl2ZSBmdW5jdGlvbiDstpTqsIAgZGVmYXVsdCDsgqzsmqnslYjtlaguXG4gICAgaWYgKF8uaXNPYmplY3QodHJlZU9wdGlvbnMpICYmIF8uaXNGdW5jdGlvbih0cmVlT3B0aW9ucy5yZWNlaXZlKSkge1xuICAgICAgb3B0aW9ucy5yZWNlaXZlID0gdHJlZU9wdGlvbnMucmVjZWl2ZVxuICAgIH1cblxuICAgIC8vIHBsYWNlaG9sZGVyIOy2lOqwgFxuICAgIGlmIChfLmlzT2JqZWN0KHRyZWVPcHRpb25zKSAmJiB0cmVlT3B0aW9ucy5wbGFjZWhvbGRlcikge1xuICAgICAgb3B0aW9ucy5wbGFjZWhvbGRlciA9IHRyZWVPcHRpb25zLnBsYWNlaG9sZGVyXG4gICAgfSBlbHNlIHtcbiAgICAgIG9wdGlvbnMucGxhY2Vob2xkZXIgPSB7XG4gICAgICAgIGVsZW1lbnQ6IGZ1bmN0aW9uICgkdGFyZ2V0KSB7XG4gICAgICAgICAgcmV0dXJuICR0YXJnZXQuY2xvbmUoKS5hZGRDbGFzcygnY29weScpLnNob3coKS53cmFwQWxsKCc8ZGl2IC8+JykucGFyZW50KCkuaHRtbCgpXG4gICAgICAgIH0sXG4gICAgICAgIHVwZGF0ZTogZnVuY3Rpb24gKCkge31cbiAgICAgIH1cbiAgICB9XG5cbiAgICBpZiAoXy5pc09iamVjdCh0cmVlT3B0aW9ucykgJiYgXy5pc0Z1bmN0aW9uKHRyZWVPcHRpb25zLmlzQWxsb3dlZCkpIHtcbiAgICAgIG9wdGlvbnMuaXNBbGxvd2VkID0gdHJlZU9wdGlvbnMuaXNBbGxvd2VkXG4gICAgfSBlbHNlIHtcbiAgICAgIG9wdGlvbnMuaXNBbGxvd2VkID0gZnVuY3Rpb24gKHBsYWNlaG9sZGVyLCBwbGFjZWhvbGRlclBhcmVudCwgY3VycmVudEl0ZW0pIHtcbiAgICAgICAgcmV0dXJuICFfcHJldmVudFxuICAgICAgfVxuICAgIH1cblxuICAgIGlmICgkdGFyZ2V0LmZpbmQoJy5pdGVtLWNvbnRhaW5lcicpLmxlbmd0aCA+IDApIHtcbiAgICAgICR0YXJnZXQuZmluZCgnLml0ZW0tY29udGFpbmVyJykubmVzdGVkU29ydGFibGUob3B0aW9ucylcbiAgICB9IGVsc2Uge1xuICAgICAgJHRhcmdldC5hcHBlbmQoJzx1bCBjbGFzcz1cIml0ZW0tY29udGFpbmVyXCI+PC91bD4nKVxuICAgICAgJHRhcmdldC5maW5kKCcuaXRlbS1jb250YWluZXInKS5uZXN0ZWRTb3J0YWJsZShvcHRpb25zKVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiBAbWVtYmVyb2YgVHJlZVxuICAgKiBAcGFyYW0ge29iamVjdH0gJGNvbnRhaW5lclxuICAgKiBAb2FyYW0ge29iamVjdH0gb2JqXG4gICAqIDxwcmU+XG4gICAqICAgbm9kZVRlbXBsYXRlOiBpdGVt7JWI7JeQIOyDneyEse2VoCBodG1sXG4gICAqICAgaXRlbVxuICAgKiAgIG5lc3RlZCAtIO2VmOychCBkZXB0aCDrhbjrk5zsnbwg6rK97JqwIHVsLml0ZW0tY29udGFpbmVy66W8IO2PrO2VqO2VmOyXrCBhcHBlbmQuIOyVhOuLkCDqsr3smrAgbGkuaXRlbeunjCBhcHBlbmRcbiAgICogPC9wcmU+XG4gICAqIEBwYXJhbSB7ZnVuY3Rpb259IGZuIGNhbGxiYWNrXG4gICAqKi9cbiAgYWRkICgkY29udGFpbmVyLCBvYmosIGZuKSB7XG4gICAgaWYgKG9iai5uZXN0ZWQpIHtcbiAgICAgICRjb250YWluZXIuYXBwZW5kKEl0ZW0uZ2V0VGVtcGxhdGUob2JqKSlcbiAgICB9IGVsc2Uge1xuICAgICAgJGNvbnRhaW5lci5hcHBlbmQoSXRlbS5tYWtlSXRlbShvYmouaXRlbXMsIG9iai5ub2RlVGVtcGxhdGUpKVxuICAgIH1cblxuICAgIGlmIChmbiAmJiB0eXBlb2YgZm4gPT09ICdmdW5jdGlvbicpIHtcbiAgICAgIGZuKClcbiAgICB9XG4gIH1cbn1cblxud2luZG93LlRyZWUgPSBuZXcgVHJlZSgpXG5cbmV4cG9ydCBkZWZhdWx0IHdpbmRvdy5UcmVlXG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNik7IiwibW9kdWxlLmV4cG9ydHMgPSByZXF1aXJlKFwiY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeVwiKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDgpOyIsInJlcXVpcmUoJy4uLy4uL21vZHVsZXMvZXMuanNvbi5zdHJpbmdpZnknKTtcbnZhciBwYXRoID0gcmVxdWlyZSgnLi4vLi4vaW50ZXJuYWxzL3BhdGgnKTtcbnZhciBhcHBseSA9IHJlcXVpcmUoJy4uLy4uL2ludGVybmFscy9mdW5jdGlvbi1hcHBseScpO1xuXG4vLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgZXMteC9uby1qc29uIC0tIHNhZmVcbmlmICghcGF0aC5KU09OKSBwYXRoLkpTT04gPSB7IHN0cmluZ2lmeTogSlNPTi5zdHJpbmdpZnkgfTtcblxuLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG5vLXVudXNlZC12YXJzIC0tIHJlcXVpcmVkIGZvciBgLmxlbmd0aGBcbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gc3RyaW5naWZ5KGl0LCByZXBsYWNlciwgc3BhY2UpIHtcbiAgcmV0dXJuIGFwcGx5KHBhdGguSlNPTi5zdHJpbmdpZnksIG51bGwsIGFyZ3VtZW50cyk7XG59O1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDExNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDIyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNTI5KTsiLCJ2YXIgcGFyZW50ID0gcmVxdWlyZSgnLi4vLi4vZXMvanNvbi9zdHJpbmdpZnknKTtcblxubW9kdWxlLmV4cG9ydHMgPSBwYXJlbnQ7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSA6ZGF0YSAxLjEzLjJcbiAqIGh0dHA6Ly9qcXVlcnl1aS5jb21cbiAqXG4gKiBDb3B5cmlnaHQgalF1ZXJ5IEZvdW5kYXRpb24gYW5kIG90aGVyIGNvbnRyaWJ1dG9yc1xuICogUmVsZWFzZWQgdW5kZXIgdGhlIE1JVCBsaWNlbnNlLlxuICogaHR0cDovL2pxdWVyeS5vcmcvbGljZW5zZVxuICovXG5cbi8vPj5sYWJlbDogOmRhdGEgU2VsZWN0b3Jcbi8vPj5ncm91cDogQ29yZVxuLy8+PmRlc2NyaXB0aW9uOiBTZWxlY3RzIGVsZW1lbnRzIHdoaWNoIGhhdmUgZGF0YSBzdG9yZWQgdW5kZXIgdGhlIHNwZWNpZmllZCBrZXkuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20vZGF0YS1zZWxlY3Rvci9cblxuKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0XCJ1c2Ugc3RyaWN0XCI7XG5cblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFsgXCJqcXVlcnlcIiwgXCIuL3ZlcnNpb25cIiBdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSApKCBmdW5jdGlvbiggJCApIHtcblwidXNlIHN0cmljdFwiO1xuXG5yZXR1cm4gJC5leHRlbmQoICQuZXhwci5wc2V1ZG9zLCB7XG5cdGRhdGE6ICQuZXhwci5jcmVhdGVQc2V1ZG8gP1xuXHRcdCQuZXhwci5jcmVhdGVQc2V1ZG8oIGZ1bmN0aW9uKCBkYXRhTmFtZSApIHtcblx0XHRcdHJldHVybiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdFx0cmV0dXJuICEhJC5kYXRhKCBlbGVtLCBkYXRhTmFtZSApO1xuXHRcdFx0fTtcblx0XHR9ICkgOlxuXG5cdFx0Ly8gU3VwcG9ydDogalF1ZXJ5IDwxLjhcblx0XHRmdW5jdGlvbiggZWxlbSwgaSwgbWF0Y2ggKSB7XG5cdFx0XHRyZXR1cm4gISEkLmRhdGEoIGVsZW0sIG1hdGNoWyAzIF0gKTtcblx0XHR9XG59ICk7XG59ICk7XG4iLCIoIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRcInVzZSBzdHJpY3RcIjtcblxuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggWyBcImpxdWVyeVwiLCBcIi4vdmVyc2lvblwiIF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59ICkoIGZ1bmN0aW9uKCAkICkge1xuXCJ1c2Ugc3RyaWN0XCI7XG5cbi8vIFRoaXMgZmlsZSBpcyBkZXByZWNhdGVkXG5yZXR1cm4gJC51aS5pZSA9ICEhL21zaWUgW1xcdy5dKy8uZXhlYyggbmF2aWdhdG9yLnVzZXJBZ2VudC50b0xvd2VyQ2FzZSgpICk7XG59ICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBTY3JvbGwgUGFyZW50IDEuMTMuMlxuICogaHR0cDovL2pxdWVyeXVpLmNvbVxuICpcbiAqIENvcHlyaWdodCBqUXVlcnkgRm91bmRhdGlvbiBhbmQgb3RoZXIgY29udHJpYnV0b3JzXG4gKiBSZWxlYXNlZCB1bmRlciB0aGUgTUlUIGxpY2Vuc2UuXG4gKiBodHRwOi8vanF1ZXJ5Lm9yZy9saWNlbnNlXG4gKi9cblxuLy8+PmxhYmVsOiBzY3JvbGxQYXJlbnRcbi8vPj5ncm91cDogQ29yZVxuLy8+PmRlc2NyaXB0aW9uOiBHZXQgdGhlIGNsb3Nlc3QgYW5jZXN0b3IgZWxlbWVudCB0aGF0IGlzIHNjcm9sbGFibGUuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20vc2Nyb2xsUGFyZW50L1xuXG4oIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRcInVzZSBzdHJpY3RcIjtcblxuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggWyBcImpxdWVyeVwiLCBcIi4vdmVyc2lvblwiIF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59ICkoIGZ1bmN0aW9uKCAkICkge1xuXCJ1c2Ugc3RyaWN0XCI7XG5cbnJldHVybiAkLmZuLnNjcm9sbFBhcmVudCA9IGZ1bmN0aW9uKCBpbmNsdWRlSGlkZGVuICkge1xuXHR2YXIgcG9zaXRpb24gPSB0aGlzLmNzcyggXCJwb3NpdGlvblwiICksXG5cdFx0ZXhjbHVkZVN0YXRpY1BhcmVudCA9IHBvc2l0aW9uID09PSBcImFic29sdXRlXCIsXG5cdFx0b3ZlcmZsb3dSZWdleCA9IGluY2x1ZGVIaWRkZW4gPyAvKGF1dG98c2Nyb2xsfGhpZGRlbikvIDogLyhhdXRvfHNjcm9sbCkvLFxuXHRcdHNjcm9sbFBhcmVudCA9IHRoaXMucGFyZW50cygpLmZpbHRlciggZnVuY3Rpb24oKSB7XG5cdFx0XHR2YXIgcGFyZW50ID0gJCggdGhpcyApO1xuXHRcdFx0aWYgKCBleGNsdWRlU3RhdGljUGFyZW50ICYmIHBhcmVudC5jc3MoIFwicG9zaXRpb25cIiApID09PSBcInN0YXRpY1wiICkge1xuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHR9XG5cdFx0XHRyZXR1cm4gb3ZlcmZsb3dSZWdleC50ZXN0KCBwYXJlbnQuY3NzKCBcIm92ZXJmbG93XCIgKSArIHBhcmVudC5jc3MoIFwib3ZlcmZsb3cteVwiICkgK1xuXHRcdFx0XHRwYXJlbnQuY3NzKCBcIm92ZXJmbG93LXhcIiApICk7XG5cdFx0fSApLmVxKCAwICk7XG5cblx0cmV0dXJuIHBvc2l0aW9uID09PSBcImZpeGVkXCIgfHwgIXNjcm9sbFBhcmVudC5sZW5ndGggP1xuXHRcdCQoIHRoaXNbIDAgXS5vd25lckRvY3VtZW50IHx8IGRvY3VtZW50ICkgOlxuXHRcdHNjcm9sbFBhcmVudDtcbn07XG5cbn0gKTtcbiIsIiggZnVuY3Rpb24oIGZhY3RvcnkgKSB7XG5cdFwidXNlIHN0cmljdFwiO1xuXG5cdGlmICggdHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQgKSB7XG5cblx0XHQvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG5cdFx0ZGVmaW5lKCBbIFwianF1ZXJ5XCIgXSwgZmFjdG9yeSApO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gQnJvd3NlciBnbG9iYWxzXG5cdFx0ZmFjdG9yeSggalF1ZXJ5ICk7XG5cdH1cbn0gKSggZnVuY3Rpb24oICQgKSB7XG5cInVzZSBzdHJpY3RcIjtcblxuJC51aSA9ICQudWkgfHwge307XG5cbnJldHVybiAkLnVpLnZlcnNpb24gPSBcIjEuMTMuMlwiO1xuXG59ICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBXaWRnZXQgMS4xMy4yXG4gKiBodHRwOi8vanF1ZXJ5dWkuY29tXG4gKlxuICogQ29weXJpZ2h0IGpRdWVyeSBGb3VuZGF0aW9uIGFuZCBvdGhlciBjb250cmlidXRvcnNcbiAqIFJlbGVhc2VkIHVuZGVyIHRoZSBNSVQgbGljZW5zZS5cbiAqIGh0dHA6Ly9qcXVlcnkub3JnL2xpY2Vuc2VcbiAqL1xuXG4vLz4+bGFiZWw6IFdpZGdldFxuLy8+Pmdyb3VwOiBDb3JlXG4vLz4+ZGVzY3JpcHRpb246IFByb3ZpZGVzIGEgZmFjdG9yeSBmb3IgY3JlYXRpbmcgc3RhdGVmdWwgd2lkZ2V0cyB3aXRoIGEgY29tbW9uIEFQSS5cbi8vPj5kb2NzOiBodHRwOi8vYXBpLmpxdWVyeXVpLmNvbS9qUXVlcnkud2lkZ2V0L1xuLy8+PmRlbW9zOiBodHRwOi8vanF1ZXJ5dWkuY29tL3dpZGdldC9cblxuKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0XCJ1c2Ugc3RyaWN0XCI7XG5cblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFsgXCJqcXVlcnlcIiwgXCIuL3ZlcnNpb25cIiBdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSApKCBmdW5jdGlvbiggJCApIHtcblwidXNlIHN0cmljdFwiO1xuXG52YXIgd2lkZ2V0VXVpZCA9IDA7XG52YXIgd2lkZ2V0SGFzT3duUHJvcGVydHkgPSBBcnJheS5wcm90b3R5cGUuaGFzT3duUHJvcGVydHk7XG52YXIgd2lkZ2V0U2xpY2UgPSBBcnJheS5wcm90b3R5cGUuc2xpY2U7XG5cbiQuY2xlYW5EYXRhID0gKCBmdW5jdGlvbiggb3JpZyApIHtcblx0cmV0dXJuIGZ1bmN0aW9uKCBlbGVtcyApIHtcblx0XHR2YXIgZXZlbnRzLCBlbGVtLCBpO1xuXHRcdGZvciAoIGkgPSAwOyAoIGVsZW0gPSBlbGVtc1sgaSBdICkgIT0gbnVsbDsgaSsrICkge1xuXG5cdFx0XHQvLyBPbmx5IHRyaWdnZXIgcmVtb3ZlIHdoZW4gbmVjZXNzYXJ5IHRvIHNhdmUgdGltZVxuXHRcdFx0ZXZlbnRzID0gJC5fZGF0YSggZWxlbSwgXCJldmVudHNcIiApO1xuXHRcdFx0aWYgKCBldmVudHMgJiYgZXZlbnRzLnJlbW92ZSApIHtcblx0XHRcdFx0JCggZWxlbSApLnRyaWdnZXJIYW5kbGVyKCBcInJlbW92ZVwiICk7XG5cdFx0XHR9XG5cdFx0fVxuXHRcdG9yaWcoIGVsZW1zICk7XG5cdH07XG59ICkoICQuY2xlYW5EYXRhICk7XG5cbiQud2lkZ2V0ID0gZnVuY3Rpb24oIG5hbWUsIGJhc2UsIHByb3RvdHlwZSApIHtcblx0dmFyIGV4aXN0aW5nQ29uc3RydWN0b3IsIGNvbnN0cnVjdG9yLCBiYXNlUHJvdG90eXBlO1xuXG5cdC8vIFByb3hpZWRQcm90b3R5cGUgYWxsb3dzIHRoZSBwcm92aWRlZCBwcm90b3R5cGUgdG8gcmVtYWluIHVubW9kaWZpZWRcblx0Ly8gc28gdGhhdCBpdCBjYW4gYmUgdXNlZCBhcyBhIG1peGluIGZvciBtdWx0aXBsZSB3aWRnZXRzICgjODg3Nilcblx0dmFyIHByb3hpZWRQcm90b3R5cGUgPSB7fTtcblxuXHR2YXIgbmFtZXNwYWNlID0gbmFtZS5zcGxpdCggXCIuXCIgKVsgMCBdO1xuXHRuYW1lID0gbmFtZS5zcGxpdCggXCIuXCIgKVsgMSBdO1xuXHR2YXIgZnVsbE5hbWUgPSBuYW1lc3BhY2UgKyBcIi1cIiArIG5hbWU7XG5cblx0aWYgKCAhcHJvdG90eXBlICkge1xuXHRcdHByb3RvdHlwZSA9IGJhc2U7XG5cdFx0YmFzZSA9ICQuV2lkZ2V0O1xuXHR9XG5cblx0aWYgKCBBcnJheS5pc0FycmF5KCBwcm90b3R5cGUgKSApIHtcblx0XHRwcm90b3R5cGUgPSAkLmV4dGVuZC5hcHBseSggbnVsbCwgWyB7fSBdLmNvbmNhdCggcHJvdG90eXBlICkgKTtcblx0fVxuXG5cdC8vIENyZWF0ZSBzZWxlY3RvciBmb3IgcGx1Z2luXG5cdCQuZXhwci5wc2V1ZG9zWyBmdWxsTmFtZS50b0xvd2VyQ2FzZSgpIF0gPSBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRyZXR1cm4gISEkLmRhdGEoIGVsZW0sIGZ1bGxOYW1lICk7XG5cdH07XG5cblx0JFsgbmFtZXNwYWNlIF0gPSAkWyBuYW1lc3BhY2UgXSB8fCB7fTtcblx0ZXhpc3RpbmdDb25zdHJ1Y3RvciA9ICRbIG5hbWVzcGFjZSBdWyBuYW1lIF07XG5cdGNvbnN0cnVjdG9yID0gJFsgbmFtZXNwYWNlIF1bIG5hbWUgXSA9IGZ1bmN0aW9uKCBvcHRpb25zLCBlbGVtZW50ICkge1xuXG5cdFx0Ly8gQWxsb3cgaW5zdGFudGlhdGlvbiB3aXRob3V0IFwibmV3XCIga2V5d29yZFxuXHRcdGlmICggIXRoaXMgfHwgIXRoaXMuX2NyZWF0ZVdpZGdldCApIHtcblx0XHRcdHJldHVybiBuZXcgY29uc3RydWN0b3IoIG9wdGlvbnMsIGVsZW1lbnQgKTtcblx0XHR9XG5cblx0XHQvLyBBbGxvdyBpbnN0YW50aWF0aW9uIHdpdGhvdXQgaW5pdGlhbGl6aW5nIGZvciBzaW1wbGUgaW5oZXJpdGFuY2Vcblx0XHQvLyBtdXN0IHVzZSBcIm5ld1wiIGtleXdvcmQgKHRoZSBjb2RlIGFib3ZlIGFsd2F5cyBwYXNzZXMgYXJncylcblx0XHRpZiAoIGFyZ3VtZW50cy5sZW5ndGggKSB7XG5cdFx0XHR0aGlzLl9jcmVhdGVXaWRnZXQoIG9wdGlvbnMsIGVsZW1lbnQgKTtcblx0XHR9XG5cdH07XG5cblx0Ly8gRXh0ZW5kIHdpdGggdGhlIGV4aXN0aW5nIGNvbnN0cnVjdG9yIHRvIGNhcnJ5IG92ZXIgYW55IHN0YXRpYyBwcm9wZXJ0aWVzXG5cdCQuZXh0ZW5kKCBjb25zdHJ1Y3RvciwgZXhpc3RpbmdDb25zdHJ1Y3Rvciwge1xuXHRcdHZlcnNpb246IHByb3RvdHlwZS52ZXJzaW9uLFxuXG5cdFx0Ly8gQ29weSB0aGUgb2JqZWN0IHVzZWQgdG8gY3JlYXRlIHRoZSBwcm90b3R5cGUgaW4gY2FzZSB3ZSBuZWVkIHRvXG5cdFx0Ly8gcmVkZWZpbmUgdGhlIHdpZGdldCBsYXRlclxuXHRcdF9wcm90bzogJC5leHRlbmQoIHt9LCBwcm90b3R5cGUgKSxcblxuXHRcdC8vIFRyYWNrIHdpZGdldHMgdGhhdCBpbmhlcml0IGZyb20gdGhpcyB3aWRnZXQgaW4gY2FzZSB0aGlzIHdpZGdldCBpc1xuXHRcdC8vIHJlZGVmaW5lZCBhZnRlciBhIHdpZGdldCBpbmhlcml0cyBmcm9tIGl0XG5cdFx0X2NoaWxkQ29uc3RydWN0b3JzOiBbXVxuXHR9ICk7XG5cblx0YmFzZVByb3RvdHlwZSA9IG5ldyBiYXNlKCk7XG5cblx0Ly8gV2UgbmVlZCB0byBtYWtlIHRoZSBvcHRpb25zIGhhc2ggYSBwcm9wZXJ0eSBkaXJlY3RseSBvbiB0aGUgbmV3IGluc3RhbmNlXG5cdC8vIG90aGVyd2lzZSB3ZSdsbCBtb2RpZnkgdGhlIG9wdGlvbnMgaGFzaCBvbiB0aGUgcHJvdG90eXBlIHRoYXQgd2UncmVcblx0Ly8gaW5oZXJpdGluZyBmcm9tXG5cdGJhc2VQcm90b3R5cGUub3B0aW9ucyA9ICQud2lkZ2V0LmV4dGVuZCgge30sIGJhc2VQcm90b3R5cGUub3B0aW9ucyApO1xuXHQkLmVhY2goIHByb3RvdHlwZSwgZnVuY3Rpb24oIHByb3AsIHZhbHVlICkge1xuXHRcdGlmICggdHlwZW9mIHZhbHVlICE9PSBcImZ1bmN0aW9uXCIgKSB7XG5cdFx0XHRwcm94aWVkUHJvdG90eXBlWyBwcm9wIF0gPSB2YWx1ZTtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cdFx0cHJveGllZFByb3RvdHlwZVsgcHJvcCBdID0gKCBmdW5jdGlvbigpIHtcblx0XHRcdGZ1bmN0aW9uIF9zdXBlcigpIHtcblx0XHRcdFx0cmV0dXJuIGJhc2UucHJvdG90eXBlWyBwcm9wIF0uYXBwbHkoIHRoaXMsIGFyZ3VtZW50cyApO1xuXHRcdFx0fVxuXG5cdFx0XHRmdW5jdGlvbiBfc3VwZXJBcHBseSggYXJncyApIHtcblx0XHRcdFx0cmV0dXJuIGJhc2UucHJvdG90eXBlWyBwcm9wIF0uYXBwbHkoIHRoaXMsIGFyZ3MgKTtcblx0XHRcdH1cblxuXHRcdFx0cmV0dXJuIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgX19zdXBlciA9IHRoaXMuX3N1cGVyO1xuXHRcdFx0XHR2YXIgX19zdXBlckFwcGx5ID0gdGhpcy5fc3VwZXJBcHBseTtcblx0XHRcdFx0dmFyIHJldHVyblZhbHVlO1xuXG5cdFx0XHRcdHRoaXMuX3N1cGVyID0gX3N1cGVyO1xuXHRcdFx0XHR0aGlzLl9zdXBlckFwcGx5ID0gX3N1cGVyQXBwbHk7XG5cblx0XHRcdFx0cmV0dXJuVmFsdWUgPSB2YWx1ZS5hcHBseSggdGhpcywgYXJndW1lbnRzICk7XG5cblx0XHRcdFx0dGhpcy5fc3VwZXIgPSBfX3N1cGVyO1xuXHRcdFx0XHR0aGlzLl9zdXBlckFwcGx5ID0gX19zdXBlckFwcGx5O1xuXG5cdFx0XHRcdHJldHVybiByZXR1cm5WYWx1ZTtcblx0XHRcdH07XG5cdFx0fSApKCk7XG5cdH0gKTtcblx0Y29uc3RydWN0b3IucHJvdG90eXBlID0gJC53aWRnZXQuZXh0ZW5kKCBiYXNlUHJvdG90eXBlLCB7XG5cblx0XHQvLyBUT0RPOiByZW1vdmUgc3VwcG9ydCBmb3Igd2lkZ2V0RXZlbnRQcmVmaXhcblx0XHQvLyBhbHdheXMgdXNlIHRoZSBuYW1lICsgYSBjb2xvbiBhcyB0aGUgcHJlZml4LCBlLmcuLCBkcmFnZ2FibGU6c3RhcnRcblx0XHQvLyBkb24ndCBwcmVmaXggZm9yIHdpZGdldHMgdGhhdCBhcmVuJ3QgRE9NLWJhc2VkXG5cdFx0d2lkZ2V0RXZlbnRQcmVmaXg6IGV4aXN0aW5nQ29uc3RydWN0b3IgPyAoIGJhc2VQcm90b3R5cGUud2lkZ2V0RXZlbnRQcmVmaXggfHwgbmFtZSApIDogbmFtZVxuXHR9LCBwcm94aWVkUHJvdG90eXBlLCB7XG5cdFx0Y29uc3RydWN0b3I6IGNvbnN0cnVjdG9yLFxuXHRcdG5hbWVzcGFjZTogbmFtZXNwYWNlLFxuXHRcdHdpZGdldE5hbWU6IG5hbWUsXG5cdFx0d2lkZ2V0RnVsbE5hbWU6IGZ1bGxOYW1lXG5cdH0gKTtcblxuXHQvLyBJZiB0aGlzIHdpZGdldCBpcyBiZWluZyByZWRlZmluZWQgdGhlbiB3ZSBuZWVkIHRvIGZpbmQgYWxsIHdpZGdldHMgdGhhdFxuXHQvLyBhcmUgaW5oZXJpdGluZyBmcm9tIGl0IGFuZCByZWRlZmluZSBhbGwgb2YgdGhlbSBzbyB0aGF0IHRoZXkgaW5oZXJpdCBmcm9tXG5cdC8vIHRoZSBuZXcgdmVyc2lvbiBvZiB0aGlzIHdpZGdldC4gV2UncmUgZXNzZW50aWFsbHkgdHJ5aW5nIHRvIHJlcGxhY2Ugb25lXG5cdC8vIGxldmVsIGluIHRoZSBwcm90b3R5cGUgY2hhaW4uXG5cdGlmICggZXhpc3RpbmdDb25zdHJ1Y3RvciApIHtcblx0XHQkLmVhY2goIGV4aXN0aW5nQ29uc3RydWN0b3IuX2NoaWxkQ29uc3RydWN0b3JzLCBmdW5jdGlvbiggaSwgY2hpbGQgKSB7XG5cdFx0XHR2YXIgY2hpbGRQcm90b3R5cGUgPSBjaGlsZC5wcm90b3R5cGU7XG5cblx0XHRcdC8vIFJlZGVmaW5lIHRoZSBjaGlsZCB3aWRnZXQgdXNpbmcgdGhlIHNhbWUgcHJvdG90eXBlIHRoYXQgd2FzXG5cdFx0XHQvLyBvcmlnaW5hbGx5IHVzZWQsIGJ1dCBpbmhlcml0IGZyb20gdGhlIG5ldyB2ZXJzaW9uIG9mIHRoZSBiYXNlXG5cdFx0XHQkLndpZGdldCggY2hpbGRQcm90b3R5cGUubmFtZXNwYWNlICsgXCIuXCIgKyBjaGlsZFByb3RvdHlwZS53aWRnZXROYW1lLCBjb25zdHJ1Y3Rvcixcblx0XHRcdFx0Y2hpbGQuX3Byb3RvICk7XG5cdFx0fSApO1xuXG5cdFx0Ly8gUmVtb3ZlIHRoZSBsaXN0IG9mIGV4aXN0aW5nIGNoaWxkIGNvbnN0cnVjdG9ycyBmcm9tIHRoZSBvbGQgY29uc3RydWN0b3Jcblx0XHQvLyBzbyB0aGUgb2xkIGNoaWxkIGNvbnN0cnVjdG9ycyBjYW4gYmUgZ2FyYmFnZSBjb2xsZWN0ZWRcblx0XHRkZWxldGUgZXhpc3RpbmdDb25zdHJ1Y3Rvci5fY2hpbGRDb25zdHJ1Y3RvcnM7XG5cdH0gZWxzZSB7XG5cdFx0YmFzZS5fY2hpbGRDb25zdHJ1Y3RvcnMucHVzaCggY29uc3RydWN0b3IgKTtcblx0fVxuXG5cdCQud2lkZ2V0LmJyaWRnZSggbmFtZSwgY29uc3RydWN0b3IgKTtcblxuXHRyZXR1cm4gY29uc3RydWN0b3I7XG59O1xuXG4kLndpZGdldC5leHRlbmQgPSBmdW5jdGlvbiggdGFyZ2V0ICkge1xuXHR2YXIgaW5wdXQgPSB3aWRnZXRTbGljZS5jYWxsKCBhcmd1bWVudHMsIDEgKTtcblx0dmFyIGlucHV0SW5kZXggPSAwO1xuXHR2YXIgaW5wdXRMZW5ndGggPSBpbnB1dC5sZW5ndGg7XG5cdHZhciBrZXk7XG5cdHZhciB2YWx1ZTtcblxuXHRmb3IgKCA7IGlucHV0SW5kZXggPCBpbnB1dExlbmd0aDsgaW5wdXRJbmRleCsrICkge1xuXHRcdGZvciAoIGtleSBpbiBpbnB1dFsgaW5wdXRJbmRleCBdICkge1xuXHRcdFx0dmFsdWUgPSBpbnB1dFsgaW5wdXRJbmRleCBdWyBrZXkgXTtcblx0XHRcdGlmICggd2lkZ2V0SGFzT3duUHJvcGVydHkuY2FsbCggaW5wdXRbIGlucHV0SW5kZXggXSwga2V5ICkgJiYgdmFsdWUgIT09IHVuZGVmaW5lZCApIHtcblxuXHRcdFx0XHQvLyBDbG9uZSBvYmplY3RzXG5cdFx0XHRcdGlmICggJC5pc1BsYWluT2JqZWN0KCB2YWx1ZSApICkge1xuXHRcdFx0XHRcdHRhcmdldFsga2V5IF0gPSAkLmlzUGxhaW5PYmplY3QoIHRhcmdldFsga2V5IF0gKSA/XG5cdFx0XHRcdFx0XHQkLndpZGdldC5leHRlbmQoIHt9LCB0YXJnZXRbIGtleSBdLCB2YWx1ZSApIDpcblxuXHRcdFx0XHRcdFx0Ly8gRG9uJ3QgZXh0ZW5kIHN0cmluZ3MsIGFycmF5cywgZXRjLiB3aXRoIG9iamVjdHNcblx0XHRcdFx0XHRcdCQud2lkZ2V0LmV4dGVuZCgge30sIHZhbHVlICk7XG5cblx0XHRcdFx0Ly8gQ29weSBldmVyeXRoaW5nIGVsc2UgYnkgcmVmZXJlbmNlXG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0dGFyZ2V0WyBrZXkgXSA9IHZhbHVlO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXHR9XG5cdHJldHVybiB0YXJnZXQ7XG59O1xuXG4kLndpZGdldC5icmlkZ2UgPSBmdW5jdGlvbiggbmFtZSwgb2JqZWN0ICkge1xuXHR2YXIgZnVsbE5hbWUgPSBvYmplY3QucHJvdG90eXBlLndpZGdldEZ1bGxOYW1lIHx8IG5hbWU7XG5cdCQuZm5bIG5hbWUgXSA9IGZ1bmN0aW9uKCBvcHRpb25zICkge1xuXHRcdHZhciBpc01ldGhvZENhbGwgPSB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJzdHJpbmdcIjtcblx0XHR2YXIgYXJncyA9IHdpZGdldFNsaWNlLmNhbGwoIGFyZ3VtZW50cywgMSApO1xuXHRcdHZhciByZXR1cm5WYWx1ZSA9IHRoaXM7XG5cblx0XHRpZiAoIGlzTWV0aG9kQ2FsbCApIHtcblxuXHRcdFx0Ly8gSWYgdGhpcyBpcyBhbiBlbXB0eSBjb2xsZWN0aW9uLCB3ZSBuZWVkIHRvIGhhdmUgdGhlIGluc3RhbmNlIG1ldGhvZFxuXHRcdFx0Ly8gcmV0dXJuIHVuZGVmaW5lZCBpbnN0ZWFkIG9mIHRoZSBqUXVlcnkgaW5zdGFuY2Vcblx0XHRcdGlmICggIXRoaXMubGVuZ3RoICYmIG9wdGlvbnMgPT09IFwiaW5zdGFuY2VcIiApIHtcblx0XHRcdFx0cmV0dXJuVmFsdWUgPSB1bmRlZmluZWQ7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHR0aGlzLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdHZhciBtZXRob2RWYWx1ZTtcblx0XHRcdFx0XHR2YXIgaW5zdGFuY2UgPSAkLmRhdGEoIHRoaXMsIGZ1bGxOYW1lICk7XG5cblx0XHRcdFx0XHRpZiAoIG9wdGlvbnMgPT09IFwiaW5zdGFuY2VcIiApIHtcblx0XHRcdFx0XHRcdHJldHVyblZhbHVlID0gaW5zdGFuY2U7XG5cdFx0XHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0aWYgKCAhaW5zdGFuY2UgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm4gJC5lcnJvciggXCJjYW5ub3QgY2FsbCBtZXRob2RzIG9uIFwiICsgbmFtZSArXG5cdFx0XHRcdFx0XHRcdFwiIHByaW9yIHRvIGluaXRpYWxpemF0aW9uOyBcIiArXG5cdFx0XHRcdFx0XHRcdFwiYXR0ZW1wdGVkIHRvIGNhbGwgbWV0aG9kICdcIiArIG9wdGlvbnMgKyBcIidcIiApO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdGlmICggdHlwZW9mIGluc3RhbmNlWyBvcHRpb25zIF0gIT09IFwiZnVuY3Rpb25cIiB8fFxuXHRcdFx0XHRcdFx0b3B0aW9ucy5jaGFyQXQoIDAgKSA9PT0gXCJfXCIgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm4gJC5lcnJvciggXCJubyBzdWNoIG1ldGhvZCAnXCIgKyBvcHRpb25zICsgXCInIGZvciBcIiArIG5hbWUgK1xuXHRcdFx0XHRcdFx0XHRcIiB3aWRnZXQgaW5zdGFuY2VcIiApO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdG1ldGhvZFZhbHVlID0gaW5zdGFuY2VbIG9wdGlvbnMgXS5hcHBseSggaW5zdGFuY2UsIGFyZ3MgKTtcblxuXHRcdFx0XHRcdGlmICggbWV0aG9kVmFsdWUgIT09IGluc3RhbmNlICYmIG1ldGhvZFZhbHVlICE9PSB1bmRlZmluZWQgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm5WYWx1ZSA9IG1ldGhvZFZhbHVlICYmIG1ldGhvZFZhbHVlLmpxdWVyeSA/XG5cdFx0XHRcdFx0XHRcdHJldHVyblZhbHVlLnB1c2hTdGFjayggbWV0aG9kVmFsdWUuZ2V0KCkgKSA6XG5cdFx0XHRcdFx0XHRcdG1ldGhvZFZhbHVlO1xuXHRcdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSApO1xuXHRcdFx0fVxuXHRcdH0gZWxzZSB7XG5cblx0XHRcdC8vIEFsbG93IG11bHRpcGxlIGhhc2hlcyB0byBiZSBwYXNzZWQgb24gaW5pdFxuXHRcdFx0aWYgKCBhcmdzLmxlbmd0aCApIHtcblx0XHRcdFx0b3B0aW9ucyA9ICQud2lkZ2V0LmV4dGVuZC5hcHBseSggbnVsbCwgWyBvcHRpb25zIF0uY29uY2F0KCBhcmdzICkgKTtcblx0XHRcdH1cblxuXHRcdFx0dGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdFx0dmFyIGluc3RhbmNlID0gJC5kYXRhKCB0aGlzLCBmdWxsTmFtZSApO1xuXHRcdFx0XHRpZiAoIGluc3RhbmNlICkge1xuXHRcdFx0XHRcdGluc3RhbmNlLm9wdGlvbiggb3B0aW9ucyB8fCB7fSApO1xuXHRcdFx0XHRcdGlmICggaW5zdGFuY2UuX2luaXQgKSB7XG5cdFx0XHRcdFx0XHRpbnN0YW5jZS5faW5pdCgpO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHQkLmRhdGEoIHRoaXMsIGZ1bGxOYW1lLCBuZXcgb2JqZWN0KCBvcHRpb25zLCB0aGlzICkgKTtcblx0XHRcdFx0fVxuXHRcdFx0fSApO1xuXHRcdH1cblxuXHRcdHJldHVybiByZXR1cm5WYWx1ZTtcblx0fTtcbn07XG5cbiQuV2lkZ2V0ID0gZnVuY3Rpb24oIC8qIG9wdGlvbnMsIGVsZW1lbnQgKi8gKSB7fTtcbiQuV2lkZ2V0Ll9jaGlsZENvbnN0cnVjdG9ycyA9IFtdO1xuXG4kLldpZGdldC5wcm90b3R5cGUgPSB7XG5cdHdpZGdldE5hbWU6IFwid2lkZ2V0XCIsXG5cdHdpZGdldEV2ZW50UHJlZml4OiBcIlwiLFxuXHRkZWZhdWx0RWxlbWVudDogXCI8ZGl2PlwiLFxuXG5cdG9wdGlvbnM6IHtcblx0XHRjbGFzc2VzOiB7fSxcblx0XHRkaXNhYmxlZDogZmFsc2UsXG5cblx0XHQvLyBDYWxsYmFja3Ncblx0XHRjcmVhdGU6IG51bGxcblx0fSxcblxuXHRfY3JlYXRlV2lkZ2V0OiBmdW5jdGlvbiggb3B0aW9ucywgZWxlbWVudCApIHtcblx0XHRlbGVtZW50ID0gJCggZWxlbWVudCB8fCB0aGlzLmRlZmF1bHRFbGVtZW50IHx8IHRoaXMgKVsgMCBdO1xuXHRcdHRoaXMuZWxlbWVudCA9ICQoIGVsZW1lbnQgKTtcblx0XHR0aGlzLnV1aWQgPSB3aWRnZXRVdWlkKys7XG5cdFx0dGhpcy5ldmVudE5hbWVzcGFjZSA9IFwiLlwiICsgdGhpcy53aWRnZXROYW1lICsgdGhpcy51dWlkO1xuXG5cdFx0dGhpcy5iaW5kaW5ncyA9ICQoKTtcblx0XHR0aGlzLmhvdmVyYWJsZSA9ICQoKTtcblx0XHR0aGlzLmZvY3VzYWJsZSA9ICQoKTtcblx0XHR0aGlzLmNsYXNzZXNFbGVtZW50TG9va3VwID0ge307XG5cblx0XHRpZiAoIGVsZW1lbnQgIT09IHRoaXMgKSB7XG5cdFx0XHQkLmRhdGEoIGVsZW1lbnQsIHRoaXMud2lkZ2V0RnVsbE5hbWUsIHRoaXMgKTtcblx0XHRcdHRoaXMuX29uKCB0cnVlLCB0aGlzLmVsZW1lbnQsIHtcblx0XHRcdFx0cmVtb3ZlOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdFx0aWYgKCBldmVudC50YXJnZXQgPT09IGVsZW1lbnQgKSB7XG5cdFx0XHRcdFx0XHR0aGlzLmRlc3Ryb3koKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH0gKTtcblx0XHRcdHRoaXMuZG9jdW1lbnQgPSAkKCBlbGVtZW50LnN0eWxlID9cblxuXHRcdFx0XHQvLyBFbGVtZW50IHdpdGhpbiB0aGUgZG9jdW1lbnRcblx0XHRcdFx0ZWxlbWVudC5vd25lckRvY3VtZW50IDpcblxuXHRcdFx0XHQvLyBFbGVtZW50IGlzIHdpbmRvdyBvciBkb2N1bWVudFxuXHRcdFx0XHRlbGVtZW50LmRvY3VtZW50IHx8IGVsZW1lbnQgKTtcblx0XHRcdHRoaXMud2luZG93ID0gJCggdGhpcy5kb2N1bWVudFsgMCBdLmRlZmF1bHRWaWV3IHx8IHRoaXMuZG9jdW1lbnRbIDAgXS5wYXJlbnRXaW5kb3cgKTtcblx0XHR9XG5cblx0XHR0aGlzLm9wdGlvbnMgPSAkLndpZGdldC5leHRlbmQoIHt9LFxuXHRcdFx0dGhpcy5vcHRpb25zLFxuXHRcdFx0dGhpcy5fZ2V0Q3JlYXRlT3B0aW9ucygpLFxuXHRcdFx0b3B0aW9ucyApO1xuXG5cdFx0dGhpcy5fY3JlYXRlKCk7XG5cblx0XHRpZiAoIHRoaXMub3B0aW9ucy5kaXNhYmxlZCApIHtcblx0XHRcdHRoaXMuX3NldE9wdGlvbkRpc2FibGVkKCB0aGlzLm9wdGlvbnMuZGlzYWJsZWQgKTtcblx0XHR9XG5cblx0XHR0aGlzLl90cmlnZ2VyKCBcImNyZWF0ZVwiLCBudWxsLCB0aGlzLl9nZXRDcmVhdGVFdmVudERhdGEoKSApO1xuXHRcdHRoaXMuX2luaXQoKTtcblx0fSxcblxuXHRfZ2V0Q3JlYXRlT3B0aW9uczogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHt9O1xuXHR9LFxuXG5cdF9nZXRDcmVhdGVFdmVudERhdGE6ICQubm9vcCxcblxuXHRfY3JlYXRlOiAkLm5vb3AsXG5cblx0X2luaXQ6ICQubm9vcCxcblxuXHRkZXN0cm95OiBmdW5jdGlvbigpIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0XHR0aGlzLl9kZXN0cm95KCk7XG5cdFx0JC5lYWNoKCB0aGlzLmNsYXNzZXNFbGVtZW50TG9va3VwLCBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRcdHRoYXQuX3JlbW92ZUNsYXNzKCB2YWx1ZSwga2V5ICk7XG5cdFx0fSApO1xuXG5cdFx0Ly8gV2UgY2FuIHByb2JhYmx5IHJlbW92ZSB0aGUgdW5iaW5kIGNhbGxzIGluIDIuMFxuXHRcdC8vIGFsbCBldmVudCBiaW5kaW5ncyBzaG91bGQgZ28gdGhyb3VnaCB0aGlzLl9vbigpXG5cdFx0dGhpcy5lbGVtZW50XG5cdFx0XHQub2ZmKCB0aGlzLmV2ZW50TmFtZXNwYWNlIClcblx0XHRcdC5yZW1vdmVEYXRhKCB0aGlzLndpZGdldEZ1bGxOYW1lICk7XG5cdFx0dGhpcy53aWRnZXQoKVxuXHRcdFx0Lm9mZiggdGhpcy5ldmVudE5hbWVzcGFjZSApXG5cdFx0XHQucmVtb3ZlQXR0ciggXCJhcmlhLWRpc2FibGVkXCIgKTtcblxuXHRcdC8vIENsZWFuIHVwIGV2ZW50cyBhbmQgc3RhdGVzXG5cdFx0dGhpcy5iaW5kaW5ncy5vZmYoIHRoaXMuZXZlbnROYW1lc3BhY2UgKTtcblx0fSxcblxuXHRfZGVzdHJveTogJC5ub29wLFxuXG5cdHdpZGdldDogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMuZWxlbWVudDtcblx0fSxcblxuXHRvcHRpb246IGZ1bmN0aW9uKCBrZXksIHZhbHVlICkge1xuXHRcdHZhciBvcHRpb25zID0ga2V5O1xuXHRcdHZhciBwYXJ0cztcblx0XHR2YXIgY3VyT3B0aW9uO1xuXHRcdHZhciBpO1xuXG5cdFx0aWYgKCBhcmd1bWVudHMubGVuZ3RoID09PSAwICkge1xuXG5cdFx0XHQvLyBEb24ndCByZXR1cm4gYSByZWZlcmVuY2UgdG8gdGhlIGludGVybmFsIGhhc2hcblx0XHRcdHJldHVybiAkLndpZGdldC5leHRlbmQoIHt9LCB0aGlzLm9wdGlvbnMgKTtcblx0XHR9XG5cblx0XHRpZiAoIHR5cGVvZiBrZXkgPT09IFwic3RyaW5nXCIgKSB7XG5cblx0XHRcdC8vIEhhbmRsZSBuZXN0ZWQga2V5cywgZS5nLiwgXCJmb28uYmFyXCIgPT4geyBmb286IHsgYmFyOiBfX18gfSB9XG5cdFx0XHRvcHRpb25zID0ge307XG5cdFx0XHRwYXJ0cyA9IGtleS5zcGxpdCggXCIuXCIgKTtcblx0XHRcdGtleSA9IHBhcnRzLnNoaWZ0KCk7XG5cdFx0XHRpZiAoIHBhcnRzLmxlbmd0aCApIHtcblx0XHRcdFx0Y3VyT3B0aW9uID0gb3B0aW9uc1sga2V5IF0gPSAkLndpZGdldC5leHRlbmQoIHt9LCB0aGlzLm9wdGlvbnNbIGtleSBdICk7XG5cdFx0XHRcdGZvciAoIGkgPSAwOyBpIDwgcGFydHMubGVuZ3RoIC0gMTsgaSsrICkge1xuXHRcdFx0XHRcdGN1ck9wdGlvblsgcGFydHNbIGkgXSBdID0gY3VyT3B0aW9uWyBwYXJ0c1sgaSBdIF0gfHwge307XG5cdFx0XHRcdFx0Y3VyT3B0aW9uID0gY3VyT3B0aW9uWyBwYXJ0c1sgaSBdIF07XG5cdFx0XHRcdH1cblx0XHRcdFx0a2V5ID0gcGFydHMucG9wKCk7XG5cdFx0XHRcdGlmICggYXJndW1lbnRzLmxlbmd0aCA9PT0gMSApIHtcblx0XHRcdFx0XHRyZXR1cm4gY3VyT3B0aW9uWyBrZXkgXSA9PT0gdW5kZWZpbmVkID8gbnVsbCA6IGN1ck9wdGlvblsga2V5IF07XG5cdFx0XHRcdH1cblx0XHRcdFx0Y3VyT3B0aW9uWyBrZXkgXSA9IHZhbHVlO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0aWYgKCBhcmd1bWVudHMubGVuZ3RoID09PSAxICkge1xuXHRcdFx0XHRcdHJldHVybiB0aGlzLm9wdGlvbnNbIGtleSBdID09PSB1bmRlZmluZWQgPyBudWxsIDogdGhpcy5vcHRpb25zWyBrZXkgXTtcblx0XHRcdFx0fVxuXHRcdFx0XHRvcHRpb25zWyBrZXkgXSA9IHZhbHVlO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHRoaXMuX3NldE9wdGlvbnMoIG9wdGlvbnMgKTtcblxuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdF9zZXRPcHRpb25zOiBmdW5jdGlvbiggb3B0aW9ucyApIHtcblx0XHR2YXIga2V5O1xuXG5cdFx0Zm9yICgga2V5IGluIG9wdGlvbnMgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb24oIGtleSwgb3B0aW9uc1sga2V5IF0gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfc2V0T3B0aW9uOiBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRpZiAoIGtleSA9PT0gXCJjbGFzc2VzXCIgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb25DbGFzc2VzKCB2YWx1ZSApO1xuXHRcdH1cblxuXHRcdHRoaXMub3B0aW9uc1sga2V5IF0gPSB2YWx1ZTtcblxuXHRcdGlmICgga2V5ID09PSBcImRpc2FibGVkXCIgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb25EaXNhYmxlZCggdmFsdWUgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfc2V0T3B0aW9uQ2xhc3NlczogZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdHZhciBjbGFzc0tleSwgZWxlbWVudHMsIGN1cnJlbnRFbGVtZW50cztcblxuXHRcdGZvciAoIGNsYXNzS2V5IGluIHZhbHVlICkge1xuXHRcdFx0Y3VycmVudEVsZW1lbnRzID0gdGhpcy5jbGFzc2VzRWxlbWVudExvb2t1cFsgY2xhc3NLZXkgXTtcblx0XHRcdGlmICggdmFsdWVbIGNsYXNzS2V5IF0gPT09IHRoaXMub3B0aW9ucy5jbGFzc2VzWyBjbGFzc0tleSBdIHx8XG5cdFx0XHRcdFx0IWN1cnJlbnRFbGVtZW50cyB8fFxuXHRcdFx0XHRcdCFjdXJyZW50RWxlbWVudHMubGVuZ3RoICkge1xuXHRcdFx0XHRjb250aW51ZTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gV2UgYXJlIGRvaW5nIHRoaXMgdG8gY3JlYXRlIGEgbmV3IGpRdWVyeSBvYmplY3QgYmVjYXVzZSB0aGUgX3JlbW92ZUNsYXNzKCkgY2FsbFxuXHRcdFx0Ly8gb24gdGhlIG5leHQgbGluZSBpcyBnb2luZyB0byBkZXN0cm95IHRoZSByZWZlcmVuY2UgdG8gdGhlIGN1cnJlbnQgZWxlbWVudHMgYmVpbmdcblx0XHRcdC8vIHRyYWNrZWQuIFdlIG5lZWQgdG8gc2F2ZSBhIGNvcHkgb2YgdGhpcyBjb2xsZWN0aW9uIHNvIHRoYXQgd2UgY2FuIGFkZCB0aGUgbmV3IGNsYXNzZXNcblx0XHRcdC8vIGJlbG93LlxuXHRcdFx0ZWxlbWVudHMgPSAkKCBjdXJyZW50RWxlbWVudHMuZ2V0KCkgKTtcblx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCBjdXJyZW50RWxlbWVudHMsIGNsYXNzS2V5ICk7XG5cblx0XHRcdC8vIFdlIGRvbid0IHVzZSBfYWRkQ2xhc3MoKSBoZXJlLCBiZWNhdXNlIHRoYXQgdXNlcyB0aGlzLm9wdGlvbnMuY2xhc3Nlc1xuXHRcdFx0Ly8gZm9yIGdlbmVyYXRpbmcgdGhlIHN0cmluZyBvZiBjbGFzc2VzLiBXZSB3YW50IHRvIHVzZSB0aGUgdmFsdWUgcGFzc2VkIGluIGZyb21cblx0XHRcdC8vIF9zZXRPcHRpb24oKSwgdGhpcyBpcyB0aGUgbmV3IHZhbHVlIG9mIHRoZSBjbGFzc2VzIG9wdGlvbiB3aGljaCB3YXMgcGFzc2VkIHRvXG5cdFx0XHQvLyBfc2V0T3B0aW9uKCkuIFdlIHBhc3MgdGhpcyB2YWx1ZSBkaXJlY3RseSB0byBfY2xhc3NlcygpLlxuXHRcdFx0ZWxlbWVudHMuYWRkQ2xhc3MoIHRoaXMuX2NsYXNzZXMoIHtcblx0XHRcdFx0ZWxlbWVudDogZWxlbWVudHMsXG5cdFx0XHRcdGtleXM6IGNsYXNzS2V5LFxuXHRcdFx0XHRjbGFzc2VzOiB2YWx1ZSxcblx0XHRcdFx0YWRkOiB0cnVlXG5cdFx0XHR9ICkgKTtcblx0XHR9XG5cdH0sXG5cblx0X3NldE9wdGlvbkRpc2FibGVkOiBmdW5jdGlvbiggdmFsdWUgKSB7XG5cdFx0dGhpcy5fdG9nZ2xlQ2xhc3MoIHRoaXMud2lkZ2V0KCksIHRoaXMud2lkZ2V0RnVsbE5hbWUgKyBcIi1kaXNhYmxlZFwiLCBudWxsLCAhIXZhbHVlICk7XG5cblx0XHQvLyBJZiB0aGUgd2lkZ2V0IGlzIGJlY29taW5nIGRpc2FibGVkLCB0aGVuIG5vdGhpbmcgaXMgaW50ZXJhY3RpdmVcblx0XHRpZiAoIHZhbHVlICkge1xuXHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoIHRoaXMuaG92ZXJhYmxlLCBudWxsLCBcInVpLXN0YXRlLWhvdmVyXCIgKTtcblx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCB0aGlzLmZvY3VzYWJsZSwgbnVsbCwgXCJ1aS1zdGF0ZS1mb2N1c1wiICk7XG5cdFx0fVxuXHR9LFxuXG5cdGVuYWJsZTogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMuX3NldE9wdGlvbnMoIHsgZGlzYWJsZWQ6IGZhbHNlIH0gKTtcblx0fSxcblxuXHRkaXNhYmxlOiBmdW5jdGlvbigpIHtcblx0XHRyZXR1cm4gdGhpcy5fc2V0T3B0aW9ucyggeyBkaXNhYmxlZDogdHJ1ZSB9ICk7XG5cdH0sXG5cblx0X2NsYXNzZXM6IGZ1bmN0aW9uKCBvcHRpb25zICkge1xuXHRcdHZhciBmdWxsID0gW107XG5cdFx0dmFyIHRoYXQgPSB0aGlzO1xuXG5cdFx0b3B0aW9ucyA9ICQuZXh0ZW5kKCB7XG5cdFx0XHRlbGVtZW50OiB0aGlzLmVsZW1lbnQsXG5cdFx0XHRjbGFzc2VzOiB0aGlzLm9wdGlvbnMuY2xhc3NlcyB8fCB7fVxuXHRcdH0sIG9wdGlvbnMgKTtcblxuXHRcdGZ1bmN0aW9uIGJpbmRSZW1vdmVFdmVudCgpIHtcblx0XHRcdHZhciBub2Rlc1RvQmluZCA9IFtdO1xuXG5cdFx0XHRvcHRpb25zLmVsZW1lbnQuZWFjaCggZnVuY3Rpb24oIF8sIGVsZW1lbnQgKSB7XG5cdFx0XHRcdHZhciBpc1RyYWNrZWQgPSAkLm1hcCggdGhhdC5jbGFzc2VzRWxlbWVudExvb2t1cCwgZnVuY3Rpb24oIGVsZW1lbnRzICkge1xuXHRcdFx0XHRcdHJldHVybiBlbGVtZW50cztcblx0XHRcdFx0fSApXG5cdFx0XHRcdFx0LnNvbWUoIGZ1bmN0aW9uKCBlbGVtZW50cyApIHtcblx0XHRcdFx0XHRcdHJldHVybiBlbGVtZW50cy5pcyggZWxlbWVudCApO1xuXHRcdFx0XHRcdH0gKTtcblxuXHRcdFx0XHRpZiAoICFpc1RyYWNrZWQgKSB7XG5cdFx0XHRcdFx0bm9kZXNUb0JpbmQucHVzaCggZWxlbWVudCApO1xuXHRcdFx0XHR9XG5cdFx0XHR9ICk7XG5cblx0XHRcdHRoYXQuX29uKCAkKCBub2Rlc1RvQmluZCApLCB7XG5cdFx0XHRcdHJlbW92ZTogXCJfdW50cmFja0NsYXNzZXNFbGVtZW50XCJcblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHRmdW5jdGlvbiBwcm9jZXNzQ2xhc3NTdHJpbmcoIGNsYXNzZXMsIGNoZWNrT3B0aW9uICkge1xuXHRcdFx0dmFyIGN1cnJlbnQsIGk7XG5cdFx0XHRmb3IgKCBpID0gMDsgaSA8IGNsYXNzZXMubGVuZ3RoOyBpKysgKSB7XG5cdFx0XHRcdGN1cnJlbnQgPSB0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwWyBjbGFzc2VzWyBpIF0gXSB8fCAkKCk7XG5cdFx0XHRcdGlmICggb3B0aW9ucy5hZGQgKSB7XG5cdFx0XHRcdFx0YmluZFJlbW92ZUV2ZW50KCk7XG5cdFx0XHRcdFx0Y3VycmVudCA9ICQoICQudW5pcXVlU29ydCggY3VycmVudC5nZXQoKS5jb25jYXQoIG9wdGlvbnMuZWxlbWVudC5nZXQoKSApICkgKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRjdXJyZW50ID0gJCggY3VycmVudC5ub3QoIG9wdGlvbnMuZWxlbWVudCApLmdldCgpICk7XG5cdFx0XHRcdH1cblx0XHRcdFx0dGhhdC5jbGFzc2VzRWxlbWVudExvb2t1cFsgY2xhc3Nlc1sgaSBdIF0gPSBjdXJyZW50O1xuXHRcdFx0XHRmdWxsLnB1c2goIGNsYXNzZXNbIGkgXSApO1xuXHRcdFx0XHRpZiAoIGNoZWNrT3B0aW9uICYmIG9wdGlvbnMuY2xhc3Nlc1sgY2xhc3Nlc1sgaSBdIF0gKSB7XG5cdFx0XHRcdFx0ZnVsbC5wdXNoKCBvcHRpb25zLmNsYXNzZXNbIGNsYXNzZXNbIGkgXSBdICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHRpZiAoIG9wdGlvbnMua2V5cyApIHtcblx0XHRcdHByb2Nlc3NDbGFzc1N0cmluZyggb3B0aW9ucy5rZXlzLm1hdGNoKCAvXFxTKy9nICkgfHwgW10sIHRydWUgKTtcblx0XHR9XG5cdFx0aWYgKCBvcHRpb25zLmV4dHJhICkge1xuXHRcdFx0cHJvY2Vzc0NsYXNzU3RyaW5nKCBvcHRpb25zLmV4dHJhLm1hdGNoKCAvXFxTKy9nICkgfHwgW10gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gZnVsbC5qb2luKCBcIiBcIiApO1xuXHR9LFxuXG5cdF91bnRyYWNrQ2xhc3Nlc0VsZW1lbnQ6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cdFx0JC5lYWNoKCB0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwLCBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRcdGlmICggJC5pbkFycmF5KCBldmVudC50YXJnZXQsIHZhbHVlICkgIT09IC0xICkge1xuXHRcdFx0XHR0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwWyBrZXkgXSA9ICQoIHZhbHVlLm5vdCggZXZlbnQudGFyZ2V0ICkuZ2V0KCkgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cblx0XHR0aGlzLl9vZmYoICQoIGV2ZW50LnRhcmdldCApICk7XG5cdH0sXG5cblx0X3JlbW92ZUNsYXNzOiBmdW5jdGlvbiggZWxlbWVudCwga2V5cywgZXh0cmEgKSB7XG5cdFx0cmV0dXJuIHRoaXMuX3RvZ2dsZUNsYXNzKCBlbGVtZW50LCBrZXlzLCBleHRyYSwgZmFsc2UgKTtcblx0fSxcblxuXHRfYWRkQ2xhc3M6IGZ1bmN0aW9uKCBlbGVtZW50LCBrZXlzLCBleHRyYSApIHtcblx0XHRyZXR1cm4gdGhpcy5fdG9nZ2xlQ2xhc3MoIGVsZW1lbnQsIGtleXMsIGV4dHJhLCB0cnVlICk7XG5cdH0sXG5cblx0X3RvZ2dsZUNsYXNzOiBmdW5jdGlvbiggZWxlbWVudCwga2V5cywgZXh0cmEsIGFkZCApIHtcblx0XHRhZGQgPSAoIHR5cGVvZiBhZGQgPT09IFwiYm9vbGVhblwiICkgPyBhZGQgOiBleHRyYTtcblx0XHR2YXIgc2hpZnQgPSAoIHR5cGVvZiBlbGVtZW50ID09PSBcInN0cmluZ1wiIHx8IGVsZW1lbnQgPT09IG51bGwgKSxcblx0XHRcdG9wdGlvbnMgPSB7XG5cdFx0XHRcdGV4dHJhOiBzaGlmdCA/IGtleXMgOiBleHRyYSxcblx0XHRcdFx0a2V5czogc2hpZnQgPyBlbGVtZW50IDoga2V5cyxcblx0XHRcdFx0ZWxlbWVudDogc2hpZnQgPyB0aGlzLmVsZW1lbnQgOiBlbGVtZW50LFxuXHRcdFx0XHRhZGQ6IGFkZFxuXHRcdFx0fTtcblx0XHRvcHRpb25zLmVsZW1lbnQudG9nZ2xlQ2xhc3MoIHRoaXMuX2NsYXNzZXMoIG9wdGlvbnMgKSwgYWRkICk7XG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0X29uOiBmdW5jdGlvbiggc3VwcHJlc3NEaXNhYmxlZENoZWNrLCBlbGVtZW50LCBoYW5kbGVycyApIHtcblx0XHR2YXIgZGVsZWdhdGVFbGVtZW50O1xuXHRcdHZhciBpbnN0YW5jZSA9IHRoaXM7XG5cblx0XHQvLyBObyBzdXBwcmVzc0Rpc2FibGVkQ2hlY2sgZmxhZywgc2h1ZmZsZSBhcmd1bWVudHNcblx0XHRpZiAoIHR5cGVvZiBzdXBwcmVzc0Rpc2FibGVkQ2hlY2sgIT09IFwiYm9vbGVhblwiICkge1xuXHRcdFx0aGFuZGxlcnMgPSBlbGVtZW50O1xuXHRcdFx0ZWxlbWVudCA9IHN1cHByZXNzRGlzYWJsZWRDaGVjaztcblx0XHRcdHN1cHByZXNzRGlzYWJsZWRDaGVjayA9IGZhbHNlO1xuXHRcdH1cblxuXHRcdC8vIE5vIGVsZW1lbnQgYXJndW1lbnQsIHNodWZmbGUgYW5kIHVzZSB0aGlzLmVsZW1lbnRcblx0XHRpZiAoICFoYW5kbGVycyApIHtcblx0XHRcdGhhbmRsZXJzID0gZWxlbWVudDtcblx0XHRcdGVsZW1lbnQgPSB0aGlzLmVsZW1lbnQ7XG5cdFx0XHRkZWxlZ2F0ZUVsZW1lbnQgPSB0aGlzLndpZGdldCgpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbGVtZW50ID0gZGVsZWdhdGVFbGVtZW50ID0gJCggZWxlbWVudCApO1xuXHRcdFx0dGhpcy5iaW5kaW5ncyA9IHRoaXMuYmluZGluZ3MuYWRkKCBlbGVtZW50ICk7XG5cdFx0fVxuXG5cdFx0JC5lYWNoKCBoYW5kbGVycywgZnVuY3Rpb24oIGV2ZW50LCBoYW5kbGVyICkge1xuXHRcdFx0ZnVuY3Rpb24gaGFuZGxlclByb3h5KCkge1xuXG5cdFx0XHRcdC8vIEFsbG93IHdpZGdldHMgdG8gY3VzdG9taXplIHRoZSBkaXNhYmxlZCBoYW5kbGluZ1xuXHRcdFx0XHQvLyAtIGRpc2FibGVkIGFzIGFuIGFycmF5IGluc3RlYWQgb2YgYm9vbGVhblxuXHRcdFx0XHQvLyAtIGRpc2FibGVkIGNsYXNzIGFzIG1ldGhvZCBmb3IgZGlzYWJsaW5nIGluZGl2aWR1YWwgcGFydHNcblx0XHRcdFx0aWYgKCAhc3VwcHJlc3NEaXNhYmxlZENoZWNrICYmXG5cdFx0XHRcdFx0XHQoIGluc3RhbmNlLm9wdGlvbnMuZGlzYWJsZWQgPT09IHRydWUgfHxcblx0XHRcdFx0XHRcdCQoIHRoaXMgKS5oYXNDbGFzcyggXCJ1aS1zdGF0ZS1kaXNhYmxlZFwiICkgKSApIHtcblx0XHRcdFx0XHRyZXR1cm47XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuICggdHlwZW9mIGhhbmRsZXIgPT09IFwic3RyaW5nXCIgPyBpbnN0YW5jZVsgaGFuZGxlciBdIDogaGFuZGxlciApXG5cdFx0XHRcdFx0LmFwcGx5KCBpbnN0YW5jZSwgYXJndW1lbnRzICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIENvcHkgdGhlIGd1aWQgc28gZGlyZWN0IHVuYmluZGluZyB3b3Jrc1xuXHRcdFx0aWYgKCB0eXBlb2YgaGFuZGxlciAhPT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdFx0aGFuZGxlclByb3h5Lmd1aWQgPSBoYW5kbGVyLmd1aWQgPVxuXHRcdFx0XHRcdGhhbmRsZXIuZ3VpZCB8fCBoYW5kbGVyUHJveHkuZ3VpZCB8fCAkLmd1aWQrKztcblx0XHRcdH1cblxuXHRcdFx0dmFyIG1hdGNoID0gZXZlbnQubWF0Y2goIC9eKFtcXHc6LV0qKVxccyooLiopJC8gKTtcblx0XHRcdHZhciBldmVudE5hbWUgPSBtYXRjaFsgMSBdICsgaW5zdGFuY2UuZXZlbnROYW1lc3BhY2U7XG5cdFx0XHR2YXIgc2VsZWN0b3IgPSBtYXRjaFsgMiBdO1xuXG5cdFx0XHRpZiAoIHNlbGVjdG9yICkge1xuXHRcdFx0XHRkZWxlZ2F0ZUVsZW1lbnQub24oIGV2ZW50TmFtZSwgc2VsZWN0b3IsIGhhbmRsZXJQcm94eSApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0ZWxlbWVudC5vbiggZXZlbnROYW1lLCBoYW5kbGVyUHJveHkgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0sXG5cblx0X29mZjogZnVuY3Rpb24oIGVsZW1lbnQsIGV2ZW50TmFtZSApIHtcblx0XHRldmVudE5hbWUgPSAoIGV2ZW50TmFtZSB8fCBcIlwiICkuc3BsaXQoIFwiIFwiICkuam9pbiggdGhpcy5ldmVudE5hbWVzcGFjZSArIFwiIFwiICkgK1xuXHRcdFx0dGhpcy5ldmVudE5hbWVzcGFjZTtcblx0XHRlbGVtZW50Lm9mZiggZXZlbnROYW1lICk7XG5cblx0XHQvLyBDbGVhciB0aGUgc3RhY2sgdG8gYXZvaWQgbWVtb3J5IGxlYWtzICgjMTAwNTYpXG5cdFx0dGhpcy5iaW5kaW5ncyA9ICQoIHRoaXMuYmluZGluZ3Mubm90KCBlbGVtZW50ICkuZ2V0KCkgKTtcblx0XHR0aGlzLmZvY3VzYWJsZSA9ICQoIHRoaXMuZm9jdXNhYmxlLm5vdCggZWxlbWVudCApLmdldCgpICk7XG5cdFx0dGhpcy5ob3ZlcmFibGUgPSAkKCB0aGlzLmhvdmVyYWJsZS5ub3QoIGVsZW1lbnQgKS5nZXQoKSApO1xuXHR9LFxuXG5cdF9kZWxheTogZnVuY3Rpb24oIGhhbmRsZXIsIGRlbGF5ICkge1xuXHRcdGZ1bmN0aW9uIGhhbmRsZXJQcm94eSgpIHtcblx0XHRcdHJldHVybiAoIHR5cGVvZiBoYW5kbGVyID09PSBcInN0cmluZ1wiID8gaW5zdGFuY2VbIGhhbmRsZXIgXSA6IGhhbmRsZXIgKVxuXHRcdFx0XHQuYXBwbHkoIGluc3RhbmNlLCBhcmd1bWVudHMgKTtcblx0XHR9XG5cdFx0dmFyIGluc3RhbmNlID0gdGhpcztcblx0XHRyZXR1cm4gc2V0VGltZW91dCggaGFuZGxlclByb3h5LCBkZWxheSB8fCAwICk7XG5cdH0sXG5cblx0X2hvdmVyYWJsZTogZnVuY3Rpb24oIGVsZW1lbnQgKSB7XG5cdFx0dGhpcy5ob3ZlcmFibGUgPSB0aGlzLmhvdmVyYWJsZS5hZGQoIGVsZW1lbnQgKTtcblx0XHR0aGlzLl9vbiggZWxlbWVudCwge1xuXHRcdFx0bW91c2VlbnRlcjogZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHR0aGlzLl9hZGRDbGFzcyggJCggZXZlbnQuY3VycmVudFRhcmdldCApLCBudWxsLCBcInVpLXN0YXRlLWhvdmVyXCIgKTtcblx0XHRcdH0sXG5cdFx0XHRtb3VzZWxlYXZlOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCAkKCBldmVudC5jdXJyZW50VGFyZ2V0ICksIG51bGwsIFwidWktc3RhdGUtaG92ZXJcIiApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSxcblxuXHRfZm9jdXNhYmxlOiBmdW5jdGlvbiggZWxlbWVudCApIHtcblx0XHR0aGlzLmZvY3VzYWJsZSA9IHRoaXMuZm9jdXNhYmxlLmFkZCggZWxlbWVudCApO1xuXHRcdHRoaXMuX29uKCBlbGVtZW50LCB7XG5cdFx0XHRmb2N1c2luOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHRoaXMuX2FkZENsYXNzKCAkKCBldmVudC5jdXJyZW50VGFyZ2V0ICksIG51bGwsIFwidWktc3RhdGUtZm9jdXNcIiApO1xuXHRcdFx0fSxcblx0XHRcdGZvY3Vzb3V0OiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCAkKCBldmVudC5jdXJyZW50VGFyZ2V0ICksIG51bGwsIFwidWktc3RhdGUtZm9jdXNcIiApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSxcblxuXHRfdHJpZ2dlcjogZnVuY3Rpb24oIHR5cGUsIGV2ZW50LCBkYXRhICkge1xuXHRcdHZhciBwcm9wLCBvcmlnO1xuXHRcdHZhciBjYWxsYmFjayA9IHRoaXMub3B0aW9uc1sgdHlwZSBdO1xuXG5cdFx0ZGF0YSA9IGRhdGEgfHwge307XG5cdFx0ZXZlbnQgPSAkLkV2ZW50KCBldmVudCApO1xuXHRcdGV2ZW50LnR5cGUgPSAoIHR5cGUgPT09IHRoaXMud2lkZ2V0RXZlbnRQcmVmaXggP1xuXHRcdFx0dHlwZSA6XG5cdFx0XHR0aGlzLndpZGdldEV2ZW50UHJlZml4ICsgdHlwZSApLnRvTG93ZXJDYXNlKCk7XG5cblx0XHQvLyBUaGUgb3JpZ2luYWwgZXZlbnQgbWF5IGNvbWUgZnJvbSBhbnkgZWxlbWVudFxuXHRcdC8vIHNvIHdlIG5lZWQgdG8gcmVzZXQgdGhlIHRhcmdldCBvbiB0aGUgbmV3IGV2ZW50XG5cdFx0ZXZlbnQudGFyZ2V0ID0gdGhpcy5lbGVtZW50WyAwIF07XG5cblx0XHQvLyBDb3B5IG9yaWdpbmFsIGV2ZW50IHByb3BlcnRpZXMgb3ZlciB0byB0aGUgbmV3IGV2ZW50XG5cdFx0b3JpZyA9IGV2ZW50Lm9yaWdpbmFsRXZlbnQ7XG5cdFx0aWYgKCBvcmlnICkge1xuXHRcdFx0Zm9yICggcHJvcCBpbiBvcmlnICkge1xuXHRcdFx0XHRpZiAoICEoIHByb3AgaW4gZXZlbnQgKSApIHtcblx0XHRcdFx0XHRldmVudFsgcHJvcCBdID0gb3JpZ1sgcHJvcCBdO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0dGhpcy5lbGVtZW50LnRyaWdnZXIoIGV2ZW50LCBkYXRhICk7XG5cdFx0cmV0dXJuICEoIHR5cGVvZiBjYWxsYmFjayA9PT0gXCJmdW5jdGlvblwiICYmXG5cdFx0XHRjYWxsYmFjay5hcHBseSggdGhpcy5lbGVtZW50WyAwIF0sIFsgZXZlbnQgXS5jb25jYXQoIGRhdGEgKSApID09PSBmYWxzZSB8fFxuXHRcdFx0ZXZlbnQuaXNEZWZhdWx0UHJldmVudGVkKCkgKTtcblx0fVxufTtcblxuJC5lYWNoKCB7IHNob3c6IFwiZmFkZUluXCIsIGhpZGU6IFwiZmFkZU91dFwiIH0sIGZ1bmN0aW9uKCBtZXRob2QsIGRlZmF1bHRFZmZlY3QgKSB7XG5cdCQuV2lkZ2V0LnByb3RvdHlwZVsgXCJfXCIgKyBtZXRob2QgXSA9IGZ1bmN0aW9uKCBlbGVtZW50LCBvcHRpb25zLCBjYWxsYmFjayApIHtcblx0XHRpZiAoIHR5cGVvZiBvcHRpb25zID09PSBcInN0cmluZ1wiICkge1xuXHRcdFx0b3B0aW9ucyA9IHsgZWZmZWN0OiBvcHRpb25zIH07XG5cdFx0fVxuXG5cdFx0dmFyIGhhc09wdGlvbnM7XG5cdFx0dmFyIGVmZmVjdE5hbWUgPSAhb3B0aW9ucyA/XG5cdFx0XHRtZXRob2QgOlxuXHRcdFx0b3B0aW9ucyA9PT0gdHJ1ZSB8fCB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJudW1iZXJcIiA/XG5cdFx0XHRcdGRlZmF1bHRFZmZlY3QgOlxuXHRcdFx0XHRvcHRpb25zLmVmZmVjdCB8fCBkZWZhdWx0RWZmZWN0O1xuXG5cdFx0b3B0aW9ucyA9IG9wdGlvbnMgfHwge307XG5cdFx0aWYgKCB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJudW1iZXJcIiApIHtcblx0XHRcdG9wdGlvbnMgPSB7IGR1cmF0aW9uOiBvcHRpb25zIH07XG5cdFx0fSBlbHNlIGlmICggb3B0aW9ucyA9PT0gdHJ1ZSApIHtcblx0XHRcdG9wdGlvbnMgPSB7fTtcblx0XHR9XG5cblx0XHRoYXNPcHRpb25zID0gISQuaXNFbXB0eU9iamVjdCggb3B0aW9ucyApO1xuXHRcdG9wdGlvbnMuY29tcGxldGUgPSBjYWxsYmFjaztcblxuXHRcdGlmICggb3B0aW9ucy5kZWxheSApIHtcblx0XHRcdGVsZW1lbnQuZGVsYXkoIG9wdGlvbnMuZGVsYXkgKTtcblx0XHR9XG5cblx0XHRpZiAoIGhhc09wdGlvbnMgJiYgJC5lZmZlY3RzICYmICQuZWZmZWN0cy5lZmZlY3RbIGVmZmVjdE5hbWUgXSApIHtcblx0XHRcdGVsZW1lbnRbIG1ldGhvZCBdKCBvcHRpb25zICk7XG5cdFx0fSBlbHNlIGlmICggZWZmZWN0TmFtZSAhPT0gbWV0aG9kICYmIGVsZW1lbnRbIGVmZmVjdE5hbWUgXSApIHtcblx0XHRcdGVsZW1lbnRbIGVmZmVjdE5hbWUgXSggb3B0aW9ucy5kdXJhdGlvbiwgb3B0aW9ucy5lYXNpbmcsIGNhbGxiYWNrICk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdGVsZW1lbnQucXVldWUoIGZ1bmN0aW9uKCBuZXh0ICkge1xuXHRcdFx0XHQkKCB0aGlzIClbIG1ldGhvZCBdKCk7XG5cdFx0XHRcdGlmICggY2FsbGJhY2sgKSB7XG5cdFx0XHRcdFx0Y2FsbGJhY2suY2FsbCggZWxlbWVudFsgMCBdICk7XG5cdFx0XHRcdH1cblx0XHRcdFx0bmV4dCgpO1xuXHRcdFx0fSApO1xuXHRcdH1cblx0fTtcbn0gKTtcblxucmV0dXJuICQud2lkZ2V0O1xuXG59ICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBNb3VzZSAxLjEzLjJcbiAqIGh0dHA6Ly9qcXVlcnl1aS5jb21cbiAqXG4gKiBDb3B5cmlnaHQgalF1ZXJ5IEZvdW5kYXRpb24gYW5kIG90aGVyIGNvbnRyaWJ1dG9yc1xuICogUmVsZWFzZWQgdW5kZXIgdGhlIE1JVCBsaWNlbnNlLlxuICogaHR0cDovL2pxdWVyeS5vcmcvbGljZW5zZVxuICovXG5cbi8vPj5sYWJlbDogTW91c2Vcbi8vPj5ncm91cDogV2lkZ2V0c1xuLy8+PmRlc2NyaXB0aW9uOiBBYnN0cmFjdHMgbW91c2UtYmFzZWQgaW50ZXJhY3Rpb25zIHRvIGFzc2lzdCBpbiBjcmVhdGluZyBjZXJ0YWluIHdpZGdldHMuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20vbW91c2UvXG5cbiggZnVuY3Rpb24oIGZhY3RvcnkgKSB7XG5cdFwidXNlIHN0cmljdFwiO1xuXG5cdGlmICggdHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQgKSB7XG5cblx0XHQvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG5cdFx0ZGVmaW5lKCBbXG5cdFx0XHRcImpxdWVyeVwiLFxuXHRcdFx0XCIuLi9pZVwiLFxuXHRcdFx0XCIuLi92ZXJzaW9uXCIsXG5cdFx0XHRcIi4uL3dpZGdldFwiXG5cdFx0XSwgZmFjdG9yeSApO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gQnJvd3NlciBnbG9iYWxzXG5cdFx0ZmFjdG9yeSggalF1ZXJ5ICk7XG5cdH1cbn0gKSggZnVuY3Rpb24oICQgKSB7XG5cInVzZSBzdHJpY3RcIjtcblxudmFyIG1vdXNlSGFuZGxlZCA9IGZhbHNlO1xuJCggZG9jdW1lbnQgKS5vbiggXCJtb3VzZXVwXCIsIGZ1bmN0aW9uKCkge1xuXHRtb3VzZUhhbmRsZWQgPSBmYWxzZTtcbn0gKTtcblxucmV0dXJuICQud2lkZ2V0KCBcInVpLm1vdXNlXCIsIHtcblx0dmVyc2lvbjogXCIxLjEzLjJcIixcblx0b3B0aW9uczoge1xuXHRcdGNhbmNlbDogXCJpbnB1dCwgdGV4dGFyZWEsIGJ1dHRvbiwgc2VsZWN0LCBvcHRpb25cIixcblx0XHRkaXN0YW5jZTogMSxcblx0XHRkZWxheTogMFxuXHR9LFxuXHRfbW91c2VJbml0OiBmdW5jdGlvbigpIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0XHR0aGlzLmVsZW1lbnRcblx0XHRcdC5vbiggXCJtb3VzZWRvd24uXCIgKyB0aGlzLndpZGdldE5hbWUsIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0cmV0dXJuIHRoYXQuX21vdXNlRG93biggZXZlbnQgKTtcblx0XHRcdH0gKVxuXHRcdFx0Lm9uKCBcImNsaWNrLlwiICsgdGhpcy53aWRnZXROYW1lLCBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdGlmICggdHJ1ZSA9PT0gJC5kYXRhKCBldmVudC50YXJnZXQsIHRoYXQud2lkZ2V0TmFtZSArIFwiLnByZXZlbnRDbGlja0V2ZW50XCIgKSApIHtcblx0XHRcdFx0XHQkLnJlbW92ZURhdGEoIGV2ZW50LnRhcmdldCwgdGhhdC53aWRnZXROYW1lICsgXCIucHJldmVudENsaWNrRXZlbnRcIiApO1xuXHRcdFx0XHRcdGV2ZW50LnN0b3BJbW1lZGlhdGVQcm9wYWdhdGlvbigpO1xuXHRcdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdFx0fVxuXHRcdFx0fSApO1xuXG5cdFx0dGhpcy5zdGFydGVkID0gZmFsc2U7XG5cdH0sXG5cblx0Ly8gVE9ETzogbWFrZSBzdXJlIGRlc3Ryb3lpbmcgb25lIGluc3RhbmNlIG9mIG1vdXNlIGRvZXNuJ3QgbWVzcyB3aXRoXG5cdC8vIG90aGVyIGluc3RhbmNlcyBvZiBtb3VzZVxuXHRfbW91c2VEZXN0cm95OiBmdW5jdGlvbigpIHtcblx0XHR0aGlzLmVsZW1lbnQub2ZmKCBcIi5cIiArIHRoaXMud2lkZ2V0TmFtZSApO1xuXHRcdGlmICggdGhpcy5fbW91c2VNb3ZlRGVsZWdhdGUgKSB7XG5cdFx0XHR0aGlzLmRvY3VtZW50XG5cdFx0XHRcdC5vZmYoIFwibW91c2Vtb3ZlLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSApXG5cdFx0XHRcdC5vZmYoIFwibW91c2V1cC5cIiArIHRoaXMud2lkZ2V0TmFtZSwgdGhpcy5fbW91c2VVcERlbGVnYXRlICk7XG5cdFx0fVxuXHR9LFxuXG5cdF9tb3VzZURvd246IGZ1bmN0aW9uKCBldmVudCApIHtcblxuXHRcdC8vIGRvbid0IGxldCBtb3JlIHRoYW4gb25lIHdpZGdldCBoYW5kbGUgbW91c2VTdGFydFxuXHRcdGlmICggbW91c2VIYW5kbGVkICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdHRoaXMuX21vdXNlTW92ZWQgPSBmYWxzZTtcblxuXHRcdC8vIFdlIG1heSBoYXZlIG1pc3NlZCBtb3VzZXVwIChvdXQgb2Ygd2luZG93KVxuXHRcdGlmICggdGhpcy5fbW91c2VTdGFydGVkICkge1xuXHRcdFx0dGhpcy5fbW91c2VVcCggZXZlbnQgKTtcblx0XHR9XG5cblx0XHR0aGlzLl9tb3VzZURvd25FdmVudCA9IGV2ZW50O1xuXG5cdFx0dmFyIHRoYXQgPSB0aGlzLFxuXHRcdFx0YnRuSXNMZWZ0ID0gKCBldmVudC53aGljaCA9PT0gMSApLFxuXG5cdFx0XHQvLyBldmVudC50YXJnZXQubm9kZU5hbWUgd29ya3MgYXJvdW5kIGEgYnVnIGluIElFIDggd2l0aFxuXHRcdFx0Ly8gZGlzYWJsZWQgaW5wdXRzICgjNzYyMClcblx0XHRcdGVsSXNDYW5jZWwgPSAoIHR5cGVvZiB0aGlzLm9wdGlvbnMuY2FuY2VsID09PSBcInN0cmluZ1wiICYmIGV2ZW50LnRhcmdldC5ub2RlTmFtZSA/XG5cdFx0XHRcdCQoIGV2ZW50LnRhcmdldCApLmNsb3Nlc3QoIHRoaXMub3B0aW9ucy5jYW5jZWwgKS5sZW5ndGggOiBmYWxzZSApO1xuXHRcdGlmICggIWJ0bklzTGVmdCB8fCBlbElzQ2FuY2VsIHx8ICF0aGlzLl9tb3VzZUNhcHR1cmUoIGV2ZW50ICkgKSB7XG5cdFx0XHRyZXR1cm4gdHJ1ZTtcblx0XHR9XG5cblx0XHR0aGlzLm1vdXNlRGVsYXlNZXQgPSAhdGhpcy5vcHRpb25zLmRlbGF5O1xuXHRcdGlmICggIXRoaXMubW91c2VEZWxheU1ldCApIHtcblx0XHRcdHRoaXMuX21vdXNlRGVsYXlUaW1lciA9IHNldFRpbWVvdXQoIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR0aGF0Lm1vdXNlRGVsYXlNZXQgPSB0cnVlO1xuXHRcdFx0fSwgdGhpcy5vcHRpb25zLmRlbGF5ICk7XG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLl9tb3VzZURpc3RhbmNlTWV0KCBldmVudCApICYmIHRoaXMuX21vdXNlRGVsYXlNZXQoIGV2ZW50ICkgKSB7XG5cdFx0XHR0aGlzLl9tb3VzZVN0YXJ0ZWQgPSAoIHRoaXMuX21vdXNlU3RhcnQoIGV2ZW50ICkgIT09IGZhbHNlICk7XG5cdFx0XHRpZiAoICF0aGlzLl9tb3VzZVN0YXJ0ZWQgKSB7XG5cdFx0XHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdFx0XHRcdHJldHVybiB0cnVlO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIENsaWNrIGV2ZW50IG1heSBuZXZlciBoYXZlIGZpcmVkIChHZWNrbyAmIE9wZXJhKVxuXHRcdGlmICggdHJ1ZSA9PT0gJC5kYXRhKCBldmVudC50YXJnZXQsIHRoaXMud2lkZ2V0TmFtZSArIFwiLnByZXZlbnRDbGlja0V2ZW50XCIgKSApIHtcblx0XHRcdCQucmVtb3ZlRGF0YSggZXZlbnQudGFyZ2V0LCB0aGlzLndpZGdldE5hbWUgKyBcIi5wcmV2ZW50Q2xpY2tFdmVudFwiICk7XG5cdFx0fVxuXG5cdFx0Ly8gVGhlc2UgZGVsZWdhdGVzIGFyZSByZXF1aXJlZCB0byBrZWVwIGNvbnRleHRcblx0XHR0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSA9IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdHJldHVybiB0aGF0Ll9tb3VzZU1vdmUoIGV2ZW50ICk7XG5cdFx0fTtcblx0XHR0aGlzLl9tb3VzZVVwRGVsZWdhdGUgPSBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRyZXR1cm4gdGhhdC5fbW91c2VVcCggZXZlbnQgKTtcblx0XHR9O1xuXG5cdFx0dGhpcy5kb2N1bWVudFxuXHRcdFx0Lm9uKCBcIm1vdXNlbW92ZS5cIiArIHRoaXMud2lkZ2V0TmFtZSwgdGhpcy5fbW91c2VNb3ZlRGVsZWdhdGUgKVxuXHRcdFx0Lm9uKCBcIm1vdXNldXAuXCIgKyB0aGlzLndpZGdldE5hbWUsIHRoaXMuX21vdXNlVXBEZWxlZ2F0ZSApO1xuXG5cdFx0ZXZlbnQucHJldmVudERlZmF1bHQoKTtcblxuXHRcdG1vdXNlSGFuZGxlZCA9IHRydWU7XG5cdFx0cmV0dXJuIHRydWU7XG5cdH0sXG5cblx0X21vdXNlTW92ZTogZnVuY3Rpb24oIGV2ZW50ICkge1xuXG5cdFx0Ly8gT25seSBjaGVjayBmb3IgbW91c2V1cHMgb3V0c2lkZSB0aGUgZG9jdW1lbnQgaWYgeW91J3ZlIG1vdmVkIGluc2lkZSB0aGUgZG9jdW1lbnRcblx0XHQvLyBhdCBsZWFzdCBvbmNlLiBUaGlzIHByZXZlbnRzIHRoZSBmaXJpbmcgb2YgbW91c2V1cCBpbiB0aGUgY2FzZSBvZiBJRTw5LCB3aGljaCB3aWxsXG5cdFx0Ly8gZmlyZSBhIG1vdXNlbW92ZSBldmVudCBpZiBjb250ZW50IGlzIHBsYWNlZCB1bmRlciB0aGUgY3Vyc29yLiBTZWUgIzc3Nzhcblx0XHQvLyBTdXBwb3J0OiBJRSA8OVxuXHRcdGlmICggdGhpcy5fbW91c2VNb3ZlZCApIHtcblxuXHRcdFx0Ly8gSUUgbW91c2V1cCBjaGVjayAtIG1vdXNldXAgaGFwcGVuZWQgd2hlbiBtb3VzZSB3YXMgb3V0IG9mIHdpbmRvd1xuXHRcdFx0aWYgKCAkLnVpLmllICYmICggIWRvY3VtZW50LmRvY3VtZW50TW9kZSB8fCBkb2N1bWVudC5kb2N1bWVudE1vZGUgPCA5ICkgJiZcblx0XHRcdFx0XHQhZXZlbnQuYnV0dG9uICkge1xuXHRcdFx0XHRyZXR1cm4gdGhpcy5fbW91c2VVcCggZXZlbnQgKTtcblxuXHRcdFx0Ly8gSWZyYW1lIG1vdXNldXAgY2hlY2sgLSBtb3VzZXVwIG9jY3VycmVkIGluIGFub3RoZXIgZG9jdW1lbnRcblx0XHRcdH0gZWxzZSBpZiAoICFldmVudC53aGljaCApIHtcblxuXHRcdFx0XHQvLyBTdXBwb3J0OiBTYWZhcmkgPD04IC0gOVxuXHRcdFx0XHQvLyBTYWZhcmkgc2V0cyB3aGljaCB0byAwIGlmIHlvdSBwcmVzcyBhbnkgb2YgdGhlIGZvbGxvd2luZyBrZXlzXG5cdFx0XHRcdC8vIGR1cmluZyBhIGRyYWcgKCMxNDQ2MSlcblx0XHRcdFx0aWYgKCBldmVudC5vcmlnaW5hbEV2ZW50LmFsdEtleSB8fCBldmVudC5vcmlnaW5hbEV2ZW50LmN0cmxLZXkgfHxcblx0XHRcdFx0XHRcdGV2ZW50Lm9yaWdpbmFsRXZlbnQubWV0YUtleSB8fCBldmVudC5vcmlnaW5hbEV2ZW50LnNoaWZ0S2V5ICkge1xuXHRcdFx0XHRcdHRoaXMuaWdub3JlTWlzc2luZ1doaWNoID0gdHJ1ZTtcblx0XHRcdFx0fSBlbHNlIGlmICggIXRoaXMuaWdub3JlTWlzc2luZ1doaWNoICkge1xuXHRcdFx0XHRcdHJldHVybiB0aGlzLl9tb3VzZVVwKCBldmVudCApO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0aWYgKCBldmVudC53aGljaCB8fCBldmVudC5idXR0b24gKSB7XG5cdFx0XHR0aGlzLl9tb3VzZU1vdmVkID0gdHJ1ZTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMuX21vdXNlU3RhcnRlZCApIHtcblx0XHRcdHRoaXMuX21vdXNlRHJhZyggZXZlbnQgKTtcblx0XHRcdHJldHVybiBldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5fbW91c2VEaXN0YW5jZU1ldCggZXZlbnQgKSAmJiB0aGlzLl9tb3VzZURlbGF5TWV0KCBldmVudCApICkge1xuXHRcdFx0dGhpcy5fbW91c2VTdGFydGVkID1cblx0XHRcdFx0KCB0aGlzLl9tb3VzZVN0YXJ0KCB0aGlzLl9tb3VzZURvd25FdmVudCwgZXZlbnQgKSAhPT0gZmFsc2UgKTtcblx0XHRcdGlmICggdGhpcy5fbW91c2VTdGFydGVkICkge1xuXHRcdFx0XHR0aGlzLl9tb3VzZURyYWcoIGV2ZW50ICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHR0aGlzLl9tb3VzZVVwKCBldmVudCApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHJldHVybiAhdGhpcy5fbW91c2VTdGFydGVkO1xuXHR9LFxuXG5cdF9tb3VzZVVwOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0dGhpcy5kb2N1bWVudFxuXHRcdFx0Lm9mZiggXCJtb3VzZW1vdmUuXCIgKyB0aGlzLndpZGdldE5hbWUsIHRoaXMuX21vdXNlTW92ZURlbGVnYXRlIClcblx0XHRcdC5vZmYoIFwibW91c2V1cC5cIiArIHRoaXMud2lkZ2V0TmFtZSwgdGhpcy5fbW91c2VVcERlbGVnYXRlICk7XG5cblx0XHRpZiAoIHRoaXMuX21vdXNlU3RhcnRlZCApIHtcblx0XHRcdHRoaXMuX21vdXNlU3RhcnRlZCA9IGZhbHNlO1xuXG5cdFx0XHRpZiAoIGV2ZW50LnRhcmdldCA9PT0gdGhpcy5fbW91c2VEb3duRXZlbnQudGFyZ2V0ICkge1xuXHRcdFx0XHQkLmRhdGEoIGV2ZW50LnRhcmdldCwgdGhpcy53aWRnZXROYW1lICsgXCIucHJldmVudENsaWNrRXZlbnRcIiwgdHJ1ZSApO1xuXHRcdFx0fVxuXG5cdFx0XHR0aGlzLl9tb3VzZVN0b3AoIGV2ZW50ICk7XG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLl9tb3VzZURlbGF5VGltZXIgKSB7XG5cdFx0XHRjbGVhclRpbWVvdXQoIHRoaXMuX21vdXNlRGVsYXlUaW1lciApO1xuXHRcdFx0ZGVsZXRlIHRoaXMuX21vdXNlRGVsYXlUaW1lcjtcblx0XHR9XG5cblx0XHR0aGlzLmlnbm9yZU1pc3NpbmdXaGljaCA9IGZhbHNlO1xuXHRcdG1vdXNlSGFuZGxlZCA9IGZhbHNlO1xuXHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdH0sXG5cblx0X21vdXNlRGlzdGFuY2VNZXQ6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRyZXR1cm4gKCBNYXRoLm1heChcblx0XHRcdFx0TWF0aC5hYnMoIHRoaXMuX21vdXNlRG93bkV2ZW50LnBhZ2VYIC0gZXZlbnQucGFnZVggKSxcblx0XHRcdFx0TWF0aC5hYnMoIHRoaXMuX21vdXNlRG93bkV2ZW50LnBhZ2VZIC0gZXZlbnQucGFnZVkgKVxuXHRcdFx0KSA+PSB0aGlzLm9wdGlvbnMuZGlzdGFuY2Vcblx0XHQpO1xuXHR9LFxuXG5cdF9tb3VzZURlbGF5TWV0OiBmdW5jdGlvbiggLyogZXZlbnQgKi8gKSB7XG5cdFx0cmV0dXJuIHRoaXMubW91c2VEZWxheU1ldDtcblx0fSxcblxuXHQvLyBUaGVzZSBhcmUgcGxhY2Vob2xkZXIgbWV0aG9kcywgdG8gYmUgb3ZlcnJpZGVuIGJ5IGV4dGVuZGluZyBwbHVnaW5cblx0X21vdXNlU3RhcnQ6IGZ1bmN0aW9uKCAvKiBldmVudCAqLyApIHt9LFxuXHRfbW91c2VEcmFnOiBmdW5jdGlvbiggLyogZXZlbnQgKi8gKSB7fSxcblx0X21vdXNlU3RvcDogZnVuY3Rpb24oIC8qIGV2ZW50ICovICkge30sXG5cdF9tb3VzZUNhcHR1cmU6IGZ1bmN0aW9uKCAvKiBldmVudCAqLyApIHtcblx0XHRyZXR1cm4gdHJ1ZTtcblx0fVxufSApO1xuXG59ICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBTb3J0YWJsZSAxLjEzLjJcbiAqIGh0dHA6Ly9qcXVlcnl1aS5jb21cbiAqXG4gKiBDb3B5cmlnaHQgalF1ZXJ5IEZvdW5kYXRpb24gYW5kIG90aGVyIGNvbnRyaWJ1dG9yc1xuICogUmVsZWFzZWQgdW5kZXIgdGhlIE1JVCBsaWNlbnNlLlxuICogaHR0cDovL2pxdWVyeS5vcmcvbGljZW5zZVxuICovXG5cbi8vPj5sYWJlbDogU29ydGFibGVcbi8vPj5ncm91cDogSW50ZXJhY3Rpb25zXG4vLz4+ZGVzY3JpcHRpb246IEVuYWJsZXMgaXRlbXMgaW4gYSBsaXN0IHRvIGJlIHNvcnRlZCB1c2luZyB0aGUgbW91c2UuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20vc29ydGFibGUvXG4vLz4+ZGVtb3M6IGh0dHA6Ly9qcXVlcnl1aS5jb20vc29ydGFibGUvXG4vLz4+Y3NzLnN0cnVjdHVyZTogLi4vLi4vdGhlbWVzL2Jhc2Uvc29ydGFibGUuY3NzXG5cbiggZnVuY3Rpb24oIGZhY3RvcnkgKSB7XG5cdFwidXNlIHN0cmljdFwiO1xuXG5cdGlmICggdHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQgKSB7XG5cblx0XHQvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG5cdFx0ZGVmaW5lKCBbXG5cdFx0XHRcImpxdWVyeVwiLFxuXHRcdFx0XCIuL21vdXNlXCIsXG5cdFx0XHRcIi4uL2RhdGFcIixcblx0XHRcdFwiLi4vaWVcIixcblx0XHRcdFwiLi4vc2Nyb2xsLXBhcmVudFwiLFxuXHRcdFx0XCIuLi92ZXJzaW9uXCIsXG5cdFx0XHRcIi4uL3dpZGdldFwiXG5cdFx0XSwgZmFjdG9yeSApO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gQnJvd3NlciBnbG9iYWxzXG5cdFx0ZmFjdG9yeSggalF1ZXJ5ICk7XG5cdH1cbn0gKSggZnVuY3Rpb24oICQgKSB7XG5cInVzZSBzdHJpY3RcIjtcblxucmV0dXJuICQud2lkZ2V0KCBcInVpLnNvcnRhYmxlXCIsICQudWkubW91c2UsIHtcblx0dmVyc2lvbjogXCIxLjEzLjJcIixcblx0d2lkZ2V0RXZlbnRQcmVmaXg6IFwic29ydFwiLFxuXHRyZWFkeTogZmFsc2UsXG5cdG9wdGlvbnM6IHtcblx0XHRhcHBlbmRUbzogXCJwYXJlbnRcIixcblx0XHRheGlzOiBmYWxzZSxcblx0XHRjb25uZWN0V2l0aDogZmFsc2UsXG5cdFx0Y29udGFpbm1lbnQ6IGZhbHNlLFxuXHRcdGN1cnNvcjogXCJhdXRvXCIsXG5cdFx0Y3Vyc29yQXQ6IGZhbHNlLFxuXHRcdGRyb3BPbkVtcHR5OiB0cnVlLFxuXHRcdGZvcmNlUGxhY2Vob2xkZXJTaXplOiBmYWxzZSxcblx0XHRmb3JjZUhlbHBlclNpemU6IGZhbHNlLFxuXHRcdGdyaWQ6IGZhbHNlLFxuXHRcdGhhbmRsZTogZmFsc2UsXG5cdFx0aGVscGVyOiBcIm9yaWdpbmFsXCIsXG5cdFx0aXRlbXM6IFwiPiAqXCIsXG5cdFx0b3BhY2l0eTogZmFsc2UsXG5cdFx0cGxhY2Vob2xkZXI6IGZhbHNlLFxuXHRcdHJldmVydDogZmFsc2UsXG5cdFx0c2Nyb2xsOiB0cnVlLFxuXHRcdHNjcm9sbFNlbnNpdGl2aXR5OiAyMCxcblx0XHRzY3JvbGxTcGVlZDogMjAsXG5cdFx0c2NvcGU6IFwiZGVmYXVsdFwiLFxuXHRcdHRvbGVyYW5jZTogXCJpbnRlcnNlY3RcIixcblx0XHR6SW5kZXg6IDEwMDAsXG5cblx0XHQvLyBDYWxsYmFja3Ncblx0XHRhY3RpdmF0ZTogbnVsbCxcblx0XHRiZWZvcmVTdG9wOiBudWxsLFxuXHRcdGNoYW5nZTogbnVsbCxcblx0XHRkZWFjdGl2YXRlOiBudWxsLFxuXHRcdG91dDogbnVsbCxcblx0XHRvdmVyOiBudWxsLFxuXHRcdHJlY2VpdmU6IG51bGwsXG5cdFx0cmVtb3ZlOiBudWxsLFxuXHRcdHNvcnQ6IG51bGwsXG5cdFx0c3RhcnQ6IG51bGwsXG5cdFx0c3RvcDogbnVsbCxcblx0XHR1cGRhdGU6IG51bGxcblx0fSxcblxuXHRfaXNPdmVyQXhpczogZnVuY3Rpb24oIHgsIHJlZmVyZW5jZSwgc2l6ZSApIHtcblx0XHRyZXR1cm4gKCB4ID49IHJlZmVyZW5jZSApICYmICggeCA8ICggcmVmZXJlbmNlICsgc2l6ZSApICk7XG5cdH0sXG5cblx0X2lzRmxvYXRpbmc6IGZ1bmN0aW9uKCBpdGVtICkge1xuXHRcdHJldHVybiAoIC9sZWZ0fHJpZ2h0LyApLnRlc3QoIGl0ZW0uY3NzKCBcImZsb2F0XCIgKSApIHx8XG5cdFx0XHQoIC9pbmxpbmV8dGFibGUtY2VsbC8gKS50ZXN0KCBpdGVtLmNzcyggXCJkaXNwbGF5XCIgKSApO1xuXHR9LFxuXG5cdF9jcmVhdGU6IGZ1bmN0aW9uKCkge1xuXHRcdHRoaXMuY29udGFpbmVyQ2FjaGUgPSB7fTtcblx0XHR0aGlzLl9hZGRDbGFzcyggXCJ1aS1zb3J0YWJsZVwiICk7XG5cblx0XHQvL0dldCB0aGUgaXRlbXNcblx0XHR0aGlzLnJlZnJlc2goKTtcblxuXHRcdC8vTGV0J3MgZGV0ZXJtaW5lIHRoZSBwYXJlbnQncyBvZmZzZXRcblx0XHR0aGlzLm9mZnNldCA9IHRoaXMuZWxlbWVudC5vZmZzZXQoKTtcblxuXHRcdC8vSW5pdGlhbGl6ZSBtb3VzZSBldmVudHMgZm9yIGludGVyYWN0aW9uXG5cdFx0dGhpcy5fbW91c2VJbml0KCk7XG5cblx0XHR0aGlzLl9zZXRIYW5kbGVDbGFzc05hbWUoKTtcblxuXHRcdC8vV2UncmUgcmVhZHkgdG8gZ29cblx0XHR0aGlzLnJlYWR5ID0gdHJ1ZTtcblxuXHR9LFxuXG5cdF9zZXRPcHRpb246IGZ1bmN0aW9uKCBrZXksIHZhbHVlICkge1xuXHRcdHRoaXMuX3N1cGVyKCBrZXksIHZhbHVlICk7XG5cblx0XHRpZiAoIGtleSA9PT0gXCJoYW5kbGVcIiApIHtcblx0XHRcdHRoaXMuX3NldEhhbmRsZUNsYXNzTmFtZSgpO1xuXHRcdH1cblx0fSxcblxuXHRfc2V0SGFuZGxlQ2xhc3NOYW1lOiBmdW5jdGlvbigpIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoIHRoaXMuZWxlbWVudC5maW5kKCBcIi51aS1zb3J0YWJsZS1oYW5kbGVcIiApLCBcInVpLXNvcnRhYmxlLWhhbmRsZVwiICk7XG5cdFx0JC5lYWNoKCB0aGlzLml0ZW1zLCBmdW5jdGlvbigpIHtcblx0XHRcdHRoYXQuX2FkZENsYXNzKFxuXHRcdFx0XHR0aGlzLmluc3RhbmNlLm9wdGlvbnMuaGFuZGxlID9cblx0XHRcdFx0XHR0aGlzLml0ZW0uZmluZCggdGhpcy5pbnN0YW5jZS5vcHRpb25zLmhhbmRsZSApIDpcblx0XHRcdFx0XHR0aGlzLml0ZW0sXG5cdFx0XHRcdFwidWktc29ydGFibGUtaGFuZGxlXCJcblx0XHRcdCk7XG5cdFx0fSApO1xuXHR9LFxuXG5cdF9kZXN0cm95OiBmdW5jdGlvbigpIHtcblx0XHR0aGlzLl9tb3VzZURlc3Ryb3koKTtcblxuXHRcdGZvciAoIHZhciBpID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdHRoaXMuaXRlbXNbIGkgXS5pdGVtLnJlbW92ZURhdGEoIHRoaXMud2lkZ2V0TmFtZSArIFwiLWl0ZW1cIiApO1xuXHRcdH1cblxuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdF9tb3VzZUNhcHR1cmU6IGZ1bmN0aW9uKCBldmVudCwgb3ZlcnJpZGVIYW5kbGUgKSB7XG5cdFx0dmFyIGN1cnJlbnRJdGVtID0gbnVsbCxcblx0XHRcdHZhbGlkSGFuZGxlID0gZmFsc2UsXG5cdFx0XHR0aGF0ID0gdGhpcztcblxuXHRcdGlmICggdGhpcy5yZXZlcnRpbmcgKSB7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLm9wdGlvbnMuZGlzYWJsZWQgfHwgdGhpcy5vcHRpb25zLnR5cGUgPT09IFwic3RhdGljXCIgKSB7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fVxuXG5cdFx0Ly9XZSBoYXZlIHRvIHJlZnJlc2ggdGhlIGl0ZW1zIGRhdGEgb25jZSBmaXJzdFxuXHRcdHRoaXMuX3JlZnJlc2hJdGVtcyggZXZlbnQgKTtcblxuXHRcdC8vRmluZCBvdXQgaWYgdGhlIGNsaWNrZWQgbm9kZSAob3Igb25lIG9mIGl0cyBwYXJlbnRzKSBpcyBhIGFjdHVhbCBpdGVtIGluIHRoaXMuaXRlbXNcblx0XHQkKCBldmVudC50YXJnZXQgKS5wYXJlbnRzKCkuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRpZiAoICQuZGF0YSggdGhpcywgdGhhdC53aWRnZXROYW1lICsgXCItaXRlbVwiICkgPT09IHRoYXQgKSB7XG5cdFx0XHRcdGN1cnJlbnRJdGVtID0gJCggdGhpcyApO1xuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHRcdGlmICggJC5kYXRhKCBldmVudC50YXJnZXQsIHRoYXQud2lkZ2V0TmFtZSArIFwiLWl0ZW1cIiApID09PSB0aGF0ICkge1xuXHRcdFx0Y3VycmVudEl0ZW0gPSAkKCBldmVudC50YXJnZXQgKTtcblx0XHR9XG5cblx0XHRpZiAoICFjdXJyZW50SXRlbSApIHtcblx0XHRcdHJldHVybiBmYWxzZTtcblx0XHR9XG5cdFx0aWYgKCB0aGlzLm9wdGlvbnMuaGFuZGxlICYmICFvdmVycmlkZUhhbmRsZSApIHtcblx0XHRcdCQoIHRoaXMub3B0aW9ucy5oYW5kbGUsIGN1cnJlbnRJdGVtICkuZmluZCggXCIqXCIgKS5hZGRCYWNrKCkuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGlmICggdGhpcyA9PT0gZXZlbnQudGFyZ2V0ICkge1xuXHRcdFx0XHRcdHZhbGlkSGFuZGxlID0gdHJ1ZTtcblx0XHRcdFx0fVxuXHRcdFx0fSApO1xuXHRcdFx0aWYgKCAhdmFsaWRIYW5kbGUgKSB7XG5cdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHR0aGlzLmN1cnJlbnRJdGVtID0gY3VycmVudEl0ZW07XG5cdFx0dGhpcy5fcmVtb3ZlQ3VycmVudHNGcm9tSXRlbXMoKTtcblx0XHRyZXR1cm4gdHJ1ZTtcblxuXHR9LFxuXG5cdF9tb3VzZVN0YXJ0OiBmdW5jdGlvbiggZXZlbnQsIG92ZXJyaWRlSGFuZGxlLCBub0FjdGl2YXRpb24gKSB7XG5cblx0XHR2YXIgaSwgYm9keSxcblx0XHRcdG8gPSB0aGlzLm9wdGlvbnM7XG5cblx0XHR0aGlzLmN1cnJlbnRDb250YWluZXIgPSB0aGlzO1xuXG5cdFx0Ly9XZSBvbmx5IG5lZWQgdG8gY2FsbCByZWZyZXNoUG9zaXRpb25zLCBiZWNhdXNlIHRoZSByZWZyZXNoSXRlbXMgY2FsbCBoYXMgYmVlbiBtb3ZlZCB0b1xuXHRcdC8vIG1vdXNlQ2FwdHVyZVxuXHRcdHRoaXMucmVmcmVzaFBvc2l0aW9ucygpO1xuXG5cdFx0Ly9QcmVwYXJlIHRoZSBkcmFnZ2VkIGl0ZW1zIHBhcmVudFxuXHRcdHRoaXMuYXBwZW5kVG8gPSAkKCBvLmFwcGVuZFRvICE9PSBcInBhcmVudFwiID9cblx0XHRcdFx0by5hcHBlbmRUbyA6XG5cdFx0XHRcdHRoaXMuY3VycmVudEl0ZW0ucGFyZW50KCkgKTtcblxuXHRcdC8vQ3JlYXRlIGFuZCBhcHBlbmQgdGhlIHZpc2libGUgaGVscGVyXG5cdFx0dGhpcy5oZWxwZXIgPSB0aGlzLl9jcmVhdGVIZWxwZXIoIGV2ZW50ICk7XG5cblx0XHQvL0NhY2hlIHRoZSBoZWxwZXIgc2l6ZVxuXHRcdHRoaXMuX2NhY2hlSGVscGVyUHJvcG9ydGlvbnMoKTtcblxuXHRcdC8qXG5cdFx0ICogLSBQb3NpdGlvbiBnZW5lcmF0aW9uIC1cblx0XHQgKiBUaGlzIGJsb2NrIGdlbmVyYXRlcyBldmVyeXRoaW5nIHBvc2l0aW9uIHJlbGF0ZWQgLSBpdCdzIHRoZSBjb3JlIG9mIGRyYWdnYWJsZXMuXG5cdFx0ICovXG5cblx0XHQvL0NhY2hlIHRoZSBtYXJnaW5zIG9mIHRoZSBvcmlnaW5hbCBlbGVtZW50XG5cdFx0dGhpcy5fY2FjaGVNYXJnaW5zKCk7XG5cblx0XHQvL1RoZSBlbGVtZW50J3MgYWJzb2x1dGUgcG9zaXRpb24gb24gdGhlIHBhZ2UgbWludXMgbWFyZ2luc1xuXHRcdHRoaXMub2Zmc2V0ID0gdGhpcy5jdXJyZW50SXRlbS5vZmZzZXQoKTtcblx0XHR0aGlzLm9mZnNldCA9IHtcblx0XHRcdHRvcDogdGhpcy5vZmZzZXQudG9wIC0gdGhpcy5tYXJnaW5zLnRvcCxcblx0XHRcdGxlZnQ6IHRoaXMub2Zmc2V0LmxlZnQgLSB0aGlzLm1hcmdpbnMubGVmdFxuXHRcdH07XG5cblx0XHQkLmV4dGVuZCggdGhpcy5vZmZzZXQsIHtcblx0XHRcdGNsaWNrOiB7IC8vV2hlcmUgdGhlIGNsaWNrIGhhcHBlbmVkLCByZWxhdGl2ZSB0byB0aGUgZWxlbWVudFxuXHRcdFx0XHRsZWZ0OiBldmVudC5wYWdlWCAtIHRoaXMub2Zmc2V0LmxlZnQsXG5cdFx0XHRcdHRvcDogZXZlbnQucGFnZVkgLSB0aGlzLm9mZnNldC50b3Bcblx0XHRcdH0sXG5cblx0XHRcdC8vIFRoaXMgaXMgYSByZWxhdGl2ZSB0byBhYnNvbHV0ZSBwb3NpdGlvbiBtaW51cyB0aGUgYWN0dWFsIHBvc2l0aW9uIGNhbGN1bGF0aW9uIC1cblx0XHRcdC8vIG9ubHkgdXNlZCBmb3IgcmVsYXRpdmUgcG9zaXRpb25lZCBoZWxwZXJcblx0XHRcdHJlbGF0aXZlOiB0aGlzLl9nZXRSZWxhdGl2ZU9mZnNldCgpXG5cdFx0fSApO1xuXG5cdFx0Ly8gQWZ0ZXIgd2UgZ2V0IHRoZSBoZWxwZXIgb2Zmc2V0LCBidXQgYmVmb3JlIHdlIGdldCB0aGUgcGFyZW50IG9mZnNldCB3ZSBjYW5cblx0XHQvLyBjaGFuZ2UgdGhlIGhlbHBlcidzIHBvc2l0aW9uIHRvIGFic29sdXRlXG5cdFx0Ly8gVE9ETzogU3RpbGwgbmVlZCB0byBmaWd1cmUgb3V0IGEgd2F5IHRvIG1ha2UgcmVsYXRpdmUgc29ydGluZyBwb3NzaWJsZVxuXHRcdHRoaXMuaGVscGVyLmNzcyggXCJwb3NpdGlvblwiLCBcImFic29sdXRlXCIgKTtcblx0XHR0aGlzLmNzc1Bvc2l0aW9uID0gdGhpcy5oZWxwZXIuY3NzKCBcInBvc2l0aW9uXCIgKTtcblxuXHRcdC8vQWRqdXN0IHRoZSBtb3VzZSBvZmZzZXQgcmVsYXRpdmUgdG8gdGhlIGhlbHBlciBpZiBcImN1cnNvckF0XCIgaXMgc3VwcGxpZWRcblx0XHRpZiAoIG8uY3Vyc29yQXQgKSB7XG5cdFx0XHR0aGlzLl9hZGp1c3RPZmZzZXRGcm9tSGVscGVyKCBvLmN1cnNvckF0ICk7XG5cdFx0fVxuXG5cdFx0Ly9DYWNoZSB0aGUgZm9ybWVyIERPTSBwb3NpdGlvblxuXHRcdHRoaXMuZG9tUG9zaXRpb24gPSB7XG5cdFx0XHRwcmV2OiB0aGlzLmN1cnJlbnRJdGVtLnByZXYoKVsgMCBdLFxuXHRcdFx0cGFyZW50OiB0aGlzLmN1cnJlbnRJdGVtLnBhcmVudCgpWyAwIF1cblx0XHR9O1xuXG5cdFx0Ly8gSWYgdGhlIGhlbHBlciBpcyBub3QgdGhlIG9yaWdpbmFsLCBoaWRlIHRoZSBvcmlnaW5hbCBzbyBpdCdzIG5vdCBwbGF5aW5nIGFueSByb2xlIGR1cmluZ1xuXHRcdC8vIHRoZSBkcmFnLCB3b24ndCBjYXVzZSBhbnl0aGluZyBiYWQgdGhpcyB3YXlcblx0XHRpZiAoIHRoaXMuaGVscGVyWyAwIF0gIT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdHRoaXMuY3VycmVudEl0ZW0uaGlkZSgpO1xuXHRcdH1cblxuXHRcdC8vQ3JlYXRlIHRoZSBwbGFjZWhvbGRlclxuXHRcdHRoaXMuX2NyZWF0ZVBsYWNlaG9sZGVyKCk7XG5cblx0XHQvL0dldCB0aGUgbmV4dCBzY3JvbGxpbmcgcGFyZW50XG5cdFx0dGhpcy5zY3JvbGxQYXJlbnQgPSB0aGlzLnBsYWNlaG9sZGVyLnNjcm9sbFBhcmVudCgpO1xuXG5cdFx0JC5leHRlbmQoIHRoaXMub2Zmc2V0LCB7XG5cdFx0XHRwYXJlbnQ6IHRoaXMuX2dldFBhcmVudE9mZnNldCgpXG5cdFx0fSApO1xuXG5cdFx0Ly9TZXQgYSBjb250YWlubWVudCBpZiBnaXZlbiBpbiB0aGUgb3B0aW9uc1xuXHRcdGlmICggby5jb250YWlubWVudCApIHtcblx0XHRcdHRoaXMuX3NldENvbnRhaW5tZW50KCk7XG5cdFx0fVxuXG5cdFx0aWYgKCBvLmN1cnNvciAmJiBvLmN1cnNvciAhPT0gXCJhdXRvXCIgKSB7IC8vIGN1cnNvciBvcHRpb25cblx0XHRcdGJvZHkgPSB0aGlzLmRvY3VtZW50LmZpbmQoIFwiYm9keVwiICk7XG5cblx0XHRcdC8vIFN1cHBvcnQ6IElFXG5cdFx0XHR0aGlzLnN0b3JlZEN1cnNvciA9IGJvZHkuY3NzKCBcImN1cnNvclwiICk7XG5cdFx0XHRib2R5LmNzcyggXCJjdXJzb3JcIiwgby5jdXJzb3IgKTtcblxuXHRcdFx0dGhpcy5zdG9yZWRTdHlsZXNoZWV0ID1cblx0XHRcdFx0JCggXCI8c3R5bGU+KnsgY3Vyc29yOiBcIiArIG8uY3Vyc29yICsgXCIgIWltcG9ydGFudDsgfTwvc3R5bGU+XCIgKS5hcHBlbmRUbyggYm9keSApO1xuXHRcdH1cblxuXHRcdC8vIFdlIG5lZWQgdG8gbWFrZSBzdXJlIHRvIGdyYWIgdGhlIHpJbmRleCBiZWZvcmUgc2V0dGluZyB0aGVcblx0XHQvLyBvcGFjaXR5LCBiZWNhdXNlIHNldHRpbmcgdGhlIG9wYWNpdHkgdG8gYW55dGhpbmcgbG93ZXIgdGhhbiAxXG5cdFx0Ly8gY2F1c2VzIHRoZSB6SW5kZXggdG8gY2hhbmdlIGZyb20gXCJhdXRvXCIgdG8gMC5cblx0XHRpZiAoIG8uekluZGV4ICkgeyAvLyB6SW5kZXggb3B0aW9uXG5cdFx0XHRpZiAoIHRoaXMuaGVscGVyLmNzcyggXCJ6SW5kZXhcIiApICkge1xuXHRcdFx0XHR0aGlzLl9zdG9yZWRaSW5kZXggPSB0aGlzLmhlbHBlci5jc3MoIFwiekluZGV4XCIgKTtcblx0XHRcdH1cblx0XHRcdHRoaXMuaGVscGVyLmNzcyggXCJ6SW5kZXhcIiwgby56SW5kZXggKTtcblx0XHR9XG5cblx0XHRpZiAoIG8ub3BhY2l0eSApIHsgLy8gb3BhY2l0eSBvcHRpb25cblx0XHRcdGlmICggdGhpcy5oZWxwZXIuY3NzKCBcIm9wYWNpdHlcIiApICkge1xuXHRcdFx0XHR0aGlzLl9zdG9yZWRPcGFjaXR5ID0gdGhpcy5oZWxwZXIuY3NzKCBcIm9wYWNpdHlcIiApO1xuXHRcdFx0fVxuXHRcdFx0dGhpcy5oZWxwZXIuY3NzKCBcIm9wYWNpdHlcIiwgby5vcGFjaXR5ICk7XG5cdFx0fVxuXG5cdFx0Ly9QcmVwYXJlIHNjcm9sbGluZ1xuXHRcdGlmICggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSAhPT0gdGhpcy5kb2N1bWVudFsgMCBdICYmXG5cdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0udGFnTmFtZSAhPT0gXCJIVE1MXCIgKSB7XG5cdFx0XHR0aGlzLm92ZXJmbG93T2Zmc2V0ID0gdGhpcy5zY3JvbGxQYXJlbnQub2Zmc2V0KCk7XG5cdFx0fVxuXG5cdFx0Ly9DYWxsIGNhbGxiYWNrc1xuXHRcdHRoaXMuX3RyaWdnZXIoIFwic3RhcnRcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cblx0XHQvL1JlY2FjaGUgdGhlIGhlbHBlciBzaXplXG5cdFx0aWYgKCAhdGhpcy5fcHJlc2VydmVIZWxwZXJQcm9wb3J0aW9ucyApIHtcblx0XHRcdHRoaXMuX2NhY2hlSGVscGVyUHJvcG9ydGlvbnMoKTtcblx0XHR9XG5cblx0XHQvL1Bvc3QgXCJhY3RpdmF0ZVwiIGV2ZW50cyB0byBwb3NzaWJsZSBjb250YWluZXJzXG5cdFx0aWYgKCAhbm9BY3RpdmF0aW9uICkge1xuXHRcdFx0Zm9yICggaSA9IHRoaXMuY29udGFpbmVycy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uX3RyaWdnZXIoIFwiYWN0aXZhdGVcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly9QcmVwYXJlIHBvc3NpYmxlIGRyb3BwYWJsZXNcblx0XHRpZiAoICQudWkuZGRtYW5hZ2VyICkge1xuXHRcdFx0JC51aS5kZG1hbmFnZXIuY3VycmVudCA9IHRoaXM7XG5cdFx0fVxuXG5cdFx0aWYgKCAkLnVpLmRkbWFuYWdlciAmJiAhby5kcm9wQmVoYXZpb3VyICkge1xuXHRcdFx0JC51aS5kZG1hbmFnZXIucHJlcGFyZU9mZnNldHMoIHRoaXMsIGV2ZW50ICk7XG5cdFx0fVxuXG5cdFx0dGhpcy5kcmFnZ2luZyA9IHRydWU7XG5cblx0XHR0aGlzLl9hZGRDbGFzcyggdGhpcy5oZWxwZXIsIFwidWktc29ydGFibGUtaGVscGVyXCIgKTtcblxuXHRcdC8vTW92ZSB0aGUgaGVscGVyLCBpZiBuZWVkZWRcblx0XHRpZiAoICF0aGlzLmhlbHBlci5wYXJlbnQoKS5pcyggdGhpcy5hcHBlbmRUbyApICkge1xuXHRcdFx0dGhpcy5oZWxwZXIuZGV0YWNoKCkuYXBwZW5kVG8oIHRoaXMuYXBwZW5kVG8gKTtcblxuXHRcdFx0Ly9VcGRhdGUgcG9zaXRpb25cblx0XHRcdHRoaXMub2Zmc2V0LnBhcmVudCA9IHRoaXMuX2dldFBhcmVudE9mZnNldCgpO1xuXHRcdH1cblxuXHRcdC8vR2VuZXJhdGUgdGhlIG9yaWdpbmFsIHBvc2l0aW9uXG5cdFx0dGhpcy5wb3NpdGlvbiA9IHRoaXMub3JpZ2luYWxQb3NpdGlvbiA9IHRoaXMuX2dlbmVyYXRlUG9zaXRpb24oIGV2ZW50ICk7XG5cdFx0dGhpcy5vcmlnaW5hbFBhZ2VYID0gZXZlbnQucGFnZVg7XG5cdFx0dGhpcy5vcmlnaW5hbFBhZ2VZID0gZXZlbnQucGFnZVk7XG5cdFx0dGhpcy5sYXN0UG9zaXRpb25BYnMgPSB0aGlzLnBvc2l0aW9uQWJzID0gdGhpcy5fY29udmVydFBvc2l0aW9uVG8oIFwiYWJzb2x1dGVcIiApO1xuXG5cdFx0dGhpcy5fbW91c2VEcmFnKCBldmVudCApO1xuXG5cdFx0cmV0dXJuIHRydWU7XG5cblx0fSxcblxuXHRfc2Nyb2xsOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0dmFyIG8gPSB0aGlzLm9wdGlvbnMsXG5cdFx0XHRzY3JvbGxlZCA9IGZhbHNlO1xuXG5cdFx0aWYgKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdICE9PSB0aGlzLmRvY3VtZW50WyAwIF0gJiZcblx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS50YWdOYW1lICE9PSBcIkhUTUxcIiApIHtcblxuXHRcdFx0aWYgKCAoIHRoaXMub3ZlcmZsb3dPZmZzZXQudG9wICsgdGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5vZmZzZXRIZWlnaHQgKSAtXG5cdFx0XHRcdFx0ZXZlbnQucGFnZVkgPCBvLnNjcm9sbFNlbnNpdGl2aXR5ICkge1xuXHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbFRvcCA9XG5cdFx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbFRvcCArIG8uc2Nyb2xsU3BlZWQ7XG5cdFx0XHR9IGVsc2UgaWYgKCBldmVudC5wYWdlWSAtIHRoaXMub3ZlcmZsb3dPZmZzZXQudG9wIDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5zY3JvbGxUb3AgPVxuXHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5zY3JvbGxUb3AgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0fVxuXG5cdFx0XHRpZiAoICggdGhpcy5vdmVyZmxvd09mZnNldC5sZWZ0ICsgdGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5vZmZzZXRXaWR0aCApIC1cblx0XHRcdFx0XHRldmVudC5wYWdlWCA8IG8uc2Nyb2xsU2Vuc2l0aXZpdHkgKSB7XG5cdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0uc2Nyb2xsTGVmdCA9IHNjcm9sbGVkID1cblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbExlZnQgKyBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0fSBlbHNlIGlmICggZXZlbnQucGFnZVggLSB0aGlzLm92ZXJmbG93T2Zmc2V0LmxlZnQgPCBvLnNjcm9sbFNlbnNpdGl2aXR5ICkge1xuXHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdLnNjcm9sbExlZnQgPSBzY3JvbGxlZCA9XG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS5zY3JvbGxMZWZ0IC0gby5zY3JvbGxTcGVlZDtcblx0XHRcdH1cblxuXHRcdH0gZWxzZSB7XG5cblx0XHRcdGlmICggZXZlbnQucGFnZVkgLSB0aGlzLmRvY3VtZW50LnNjcm9sbFRvcCgpIDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLmRvY3VtZW50LnNjcm9sbFRvcCggdGhpcy5kb2N1bWVudC5zY3JvbGxUb3AoKSAtIG8uc2Nyb2xsU3BlZWQgKTtcblx0XHRcdH0gZWxzZSBpZiAoIHRoaXMud2luZG93LmhlaWdodCgpIC0gKCBldmVudC5wYWdlWSAtIHRoaXMuZG9jdW1lbnQuc2Nyb2xsVG9wKCkgKSA8XG5cdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLmRvY3VtZW50LnNjcm9sbFRvcCggdGhpcy5kb2N1bWVudC5zY3JvbGxUb3AoKSArIG8uc2Nyb2xsU3BlZWQgKTtcblx0XHRcdH1cblxuXHRcdFx0aWYgKCBldmVudC5wYWdlWCAtIHRoaXMuZG9jdW1lbnQuc2Nyb2xsTGVmdCgpIDwgby5zY3JvbGxTZW5zaXRpdml0eSApIHtcblx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLmRvY3VtZW50LnNjcm9sbExlZnQoXG5cdFx0XHRcdFx0dGhpcy5kb2N1bWVudC5zY3JvbGxMZWZ0KCkgLSBvLnNjcm9sbFNwZWVkXG5cdFx0XHRcdCk7XG5cdFx0XHR9IGVsc2UgaWYgKCB0aGlzLndpbmRvdy53aWR0aCgpIC0gKCBldmVudC5wYWdlWCAtIHRoaXMuZG9jdW1lbnQuc2Nyb2xsTGVmdCgpICkgPFxuXHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHkgKSB7XG5cdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5kb2N1bWVudC5zY3JvbGxMZWZ0KFxuXHRcdFx0XHRcdHRoaXMuZG9jdW1lbnQuc2Nyb2xsTGVmdCgpICsgby5zY3JvbGxTcGVlZFxuXHRcdFx0XHQpO1xuXHRcdFx0fVxuXG5cdFx0fVxuXG5cdFx0cmV0dXJuIHNjcm9sbGVkO1xuXHR9LFxuXG5cdF9tb3VzZURyYWc6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR2YXIgaSwgaXRlbSwgaXRlbUVsZW1lbnQsIGludGVyc2VjdGlvbixcblx0XHRcdG8gPSB0aGlzLm9wdGlvbnM7XG5cblx0XHQvL0NvbXB1dGUgdGhlIGhlbHBlcnMgcG9zaXRpb25cblx0XHR0aGlzLnBvc2l0aW9uID0gdGhpcy5fZ2VuZXJhdGVQb3NpdGlvbiggZXZlbnQgKTtcblx0XHR0aGlzLnBvc2l0aW9uQWJzID0gdGhpcy5fY29udmVydFBvc2l0aW9uVG8oIFwiYWJzb2x1dGVcIiApO1xuXG5cdFx0Ly9TZXQgdGhlIGhlbHBlciBwb3NpdGlvblxuXHRcdGlmICggIXRoaXMub3B0aW9ucy5heGlzIHx8IHRoaXMub3B0aW9ucy5heGlzICE9PSBcInlcIiApIHtcblx0XHRcdHRoaXMuaGVscGVyWyAwIF0uc3R5bGUubGVmdCA9IHRoaXMucG9zaXRpb24ubGVmdCArIFwicHhcIjtcblx0XHR9XG5cdFx0aWYgKCAhdGhpcy5vcHRpb25zLmF4aXMgfHwgdGhpcy5vcHRpb25zLmF4aXMgIT09IFwieFwiICkge1xuXHRcdFx0dGhpcy5oZWxwZXJbIDAgXS5zdHlsZS50b3AgPSB0aGlzLnBvc2l0aW9uLnRvcCArIFwicHhcIjtcblx0XHR9XG5cblx0XHQvL0RvIHNjcm9sbGluZ1xuXHRcdGlmICggby5zY3JvbGwgKSB7XG5cdFx0XHRpZiAoIHRoaXMuX3Njcm9sbCggZXZlbnQgKSAhPT0gZmFsc2UgKSB7XG5cblx0XHRcdFx0Ly9VcGRhdGUgaXRlbSBwb3NpdGlvbnMgdXNlZCBpbiBwb3NpdGlvbiBjaGVja3Ncblx0XHRcdFx0dGhpcy5fcmVmcmVzaEl0ZW1Qb3NpdGlvbnMoIHRydWUgKTtcblxuXHRcdFx0XHRpZiAoICQudWkuZGRtYW5hZ2VyICYmICFvLmRyb3BCZWhhdmlvdXIgKSB7XG5cdFx0XHRcdFx0JC51aS5kZG1hbmFnZXIucHJlcGFyZU9mZnNldHMoIHRoaXMsIGV2ZW50ICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHR0aGlzLmRyYWdEaXJlY3Rpb24gPSB7XG5cdFx0XHR2ZXJ0aWNhbDogdGhpcy5fZ2V0RHJhZ1ZlcnRpY2FsRGlyZWN0aW9uKCksXG5cdFx0XHRob3Jpem9udGFsOiB0aGlzLl9nZXREcmFnSG9yaXpvbnRhbERpcmVjdGlvbigpXG5cdFx0fTtcblxuXHRcdC8vUmVhcnJhbmdlXG5cdFx0Zm9yICggaSA9IHRoaXMuaXRlbXMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cblx0XHRcdC8vQ2FjaGUgdmFyaWFibGVzIGFuZCBpbnRlcnNlY3Rpb24sIGNvbnRpbnVlIGlmIG5vIGludGVyc2VjdGlvblxuXHRcdFx0aXRlbSA9IHRoaXMuaXRlbXNbIGkgXTtcblx0XHRcdGl0ZW1FbGVtZW50ID0gaXRlbS5pdGVtWyAwIF07XG5cdFx0XHRpbnRlcnNlY3Rpb24gPSB0aGlzLl9pbnRlcnNlY3RzV2l0aFBvaW50ZXIoIGl0ZW0gKTtcblx0XHRcdGlmICggIWludGVyc2VjdGlvbiApIHtcblx0XHRcdFx0Y29udGludWU7XG5cdFx0XHR9XG5cblx0XHRcdC8vIE9ubHkgcHV0IHRoZSBwbGFjZWhvbGRlciBpbnNpZGUgdGhlIGN1cnJlbnQgQ29udGFpbmVyLCBza2lwIGFsbFxuXHRcdFx0Ly8gaXRlbXMgZnJvbSBvdGhlciBjb250YWluZXJzLiBUaGlzIHdvcmtzIGJlY2F1c2Ugd2hlbiBtb3Zpbmdcblx0XHRcdC8vIGFuIGl0ZW0gZnJvbSBvbmUgY29udGFpbmVyIHRvIGFub3RoZXIgdGhlXG5cdFx0XHQvLyBjdXJyZW50Q29udGFpbmVyIGlzIHN3aXRjaGVkIGJlZm9yZSB0aGUgcGxhY2Vob2xkZXIgaXMgbW92ZWQuXG5cdFx0XHQvL1xuXHRcdFx0Ly8gV2l0aG91dCB0aGlzLCBtb3ZpbmcgaXRlbXMgaW4gXCJzdWItc29ydGFibGVzXCIgY2FuIGNhdXNlXG5cdFx0XHQvLyB0aGUgcGxhY2Vob2xkZXIgdG8gaml0dGVyIGJldHdlZW4gdGhlIG91dGVyIGFuZCBpbm5lciBjb250YWluZXIuXG5cdFx0XHRpZiAoIGl0ZW0uaW5zdGFuY2UgIT09IHRoaXMuY3VycmVudENvbnRhaW5lciApIHtcblx0XHRcdFx0Y29udGludWU7XG5cdFx0XHR9XG5cblx0XHRcdC8vIENhbm5vdCBpbnRlcnNlY3Qgd2l0aCBpdHNlbGZcblx0XHRcdC8vIG5vIHVzZWxlc3MgYWN0aW9ucyB0aGF0IGhhdmUgYmVlbiBkb25lIGJlZm9yZVxuXHRcdFx0Ly8gbm8gYWN0aW9uIGlmIHRoZSBpdGVtIG1vdmVkIGlzIHRoZSBwYXJlbnQgb2YgdGhlIGl0ZW0gY2hlY2tlZFxuXHRcdFx0aWYgKCBpdGVtRWxlbWVudCAhPT0gdGhpcy5jdXJyZW50SXRlbVsgMCBdICYmXG5cdFx0XHRcdHRoaXMucGxhY2Vob2xkZXJbIGludGVyc2VjdGlvbiA9PT0gMSA/XG5cdFx0XHRcdFwibmV4dFwiIDogXCJwcmV2XCIgXSgpWyAwIF0gIT09IGl0ZW1FbGVtZW50ICYmXG5cdFx0XHRcdCEkLmNvbnRhaW5zKCB0aGlzLnBsYWNlaG9sZGVyWyAwIF0sIGl0ZW1FbGVtZW50ICkgJiZcblx0XHRcdFx0KCB0aGlzLm9wdGlvbnMudHlwZSA9PT0gXCJzZW1pLWR5bmFtaWNcIiA/XG5cdFx0XHRcdFx0ISQuY29udGFpbnMoIHRoaXMuZWxlbWVudFsgMCBdLCBpdGVtRWxlbWVudCApIDpcblx0XHRcdFx0XHR0cnVlXG5cdFx0XHRcdClcblx0XHRcdCkge1xuXG5cdFx0XHRcdHRoaXMuZGlyZWN0aW9uID0gaW50ZXJzZWN0aW9uID09PSAxID8gXCJkb3duXCIgOiBcInVwXCI7XG5cblx0XHRcdFx0aWYgKCB0aGlzLm9wdGlvbnMudG9sZXJhbmNlID09PSBcInBvaW50ZXJcIiB8fFxuXHRcdFx0XHRcdFx0dGhpcy5faW50ZXJzZWN0c1dpdGhTaWRlcyggaXRlbSApICkge1xuXHRcdFx0XHRcdHRoaXMuX3JlYXJyYW5nZSggZXZlbnQsIGl0ZW0gKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHRoaXMuX3RyaWdnZXIoIFwiY2hhbmdlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSApO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvL1Bvc3QgZXZlbnRzIHRvIGNvbnRhaW5lcnNcblx0XHR0aGlzLl9jb250YWN0Q29udGFpbmVycyggZXZlbnQgKTtcblxuXHRcdC8vSW50ZXJjb25uZWN0IHdpdGggZHJvcHBhYmxlc1xuXHRcdGlmICggJC51aS5kZG1hbmFnZXIgKSB7XG5cdFx0XHQkLnVpLmRkbWFuYWdlci5kcmFnKCB0aGlzLCBldmVudCApO1xuXHRcdH1cblxuXHRcdC8vQ2FsbCBjYWxsYmFja3Ncblx0XHR0aGlzLl90cmlnZ2VyKCBcInNvcnRcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cblx0XHR0aGlzLmxhc3RQb3NpdGlvbkFicyA9IHRoaXMucG9zaXRpb25BYnM7XG5cdFx0cmV0dXJuIGZhbHNlO1xuXG5cdH0sXG5cblx0X21vdXNlU3RvcDogZnVuY3Rpb24oIGV2ZW50LCBub1Byb3BhZ2F0aW9uICkge1xuXG5cdFx0aWYgKCAhZXZlbnQgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0Ly9JZiB3ZSBhcmUgdXNpbmcgZHJvcHBhYmxlcywgaW5mb3JtIHRoZSBtYW5hZ2VyIGFib3V0IHRoZSBkcm9wXG5cdFx0aWYgKCAkLnVpLmRkbWFuYWdlciAmJiAhdGhpcy5vcHRpb25zLmRyb3BCZWhhdmlvdXIgKSB7XG5cdFx0XHQkLnVpLmRkbWFuYWdlci5kcm9wKCB0aGlzLCBldmVudCApO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5vcHRpb25zLnJldmVydCApIHtcblx0XHRcdHZhciB0aGF0ID0gdGhpcyxcblx0XHRcdFx0Y3VyID0gdGhpcy5wbGFjZWhvbGRlci5vZmZzZXQoKSxcblx0XHRcdFx0YXhpcyA9IHRoaXMub3B0aW9ucy5heGlzLFxuXHRcdFx0XHRhbmltYXRpb24gPSB7fTtcblxuXHRcdFx0aWYgKCAhYXhpcyB8fCBheGlzID09PSBcInhcIiApIHtcblx0XHRcdFx0YW5pbWF0aW9uLmxlZnQgPSBjdXIubGVmdCAtIHRoaXMub2Zmc2V0LnBhcmVudC5sZWZ0IC0gdGhpcy5tYXJnaW5zLmxlZnQgK1xuXHRcdFx0XHRcdCggdGhpcy5vZmZzZXRQYXJlbnRbIDAgXSA9PT0gdGhpcy5kb2N1bWVudFsgMCBdLmJvZHkgP1xuXHRcdFx0XHRcdFx0MCA6XG5cdFx0XHRcdFx0XHR0aGlzLm9mZnNldFBhcmVudFsgMCBdLnNjcm9sbExlZnRcblx0XHRcdFx0XHQpO1xuXHRcdFx0fVxuXHRcdFx0aWYgKCAhYXhpcyB8fCBheGlzID09PSBcInlcIiApIHtcblx0XHRcdFx0YW5pbWF0aW9uLnRvcCA9IGN1ci50b3AgLSB0aGlzLm9mZnNldC5wYXJlbnQudG9wIC0gdGhpcy5tYXJnaW5zLnRvcCArXG5cdFx0XHRcdFx0KCB0aGlzLm9mZnNldFBhcmVudFsgMCBdID09PSB0aGlzLmRvY3VtZW50WyAwIF0uYm9keSA/XG5cdFx0XHRcdFx0XHQwIDpcblx0XHRcdFx0XHRcdHRoaXMub2Zmc2V0UGFyZW50WyAwIF0uc2Nyb2xsVG9wXG5cdFx0XHRcdFx0KTtcblx0XHRcdH1cblx0XHRcdHRoaXMucmV2ZXJ0aW5nID0gdHJ1ZTtcblx0XHRcdCQoIHRoaXMuaGVscGVyICkuYW5pbWF0ZShcblx0XHRcdFx0YW5pbWF0aW9uLFxuXHRcdFx0XHRwYXJzZUludCggdGhpcy5vcHRpb25zLnJldmVydCwgMTAgKSB8fCA1MDAsXG5cdFx0XHRcdGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdHRoYXQuX2NsZWFyKCBldmVudCApO1xuXHRcdFx0XHR9XG5cdFx0XHQpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHR0aGlzLl9jbGVhciggZXZlbnQsIG5vUHJvcGFnYXRpb24gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gZmFsc2U7XG5cblx0fSxcblxuXHRjYW5jZWw6IGZ1bmN0aW9uKCkge1xuXG5cdFx0aWYgKCB0aGlzLmRyYWdnaW5nICkge1xuXG5cdFx0XHR0aGlzLl9tb3VzZVVwKCBuZXcgJC5FdmVudCggXCJtb3VzZXVwXCIsIHsgdGFyZ2V0OiBudWxsIH0gKSApO1xuXG5cdFx0XHRpZiAoIHRoaXMub3B0aW9ucy5oZWxwZXIgPT09IFwib3JpZ2luYWxcIiApIHtcblx0XHRcdFx0dGhpcy5jdXJyZW50SXRlbS5jc3MoIHRoaXMuX3N0b3JlZENTUyApO1xuXHRcdFx0XHR0aGlzLl9yZW1vdmVDbGFzcyggdGhpcy5jdXJyZW50SXRlbSwgXCJ1aS1zb3J0YWJsZS1oZWxwZXJcIiApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0dGhpcy5jdXJyZW50SXRlbS5zaG93KCk7XG5cdFx0XHR9XG5cblx0XHRcdC8vUG9zdCBkZWFjdGl2YXRpbmcgZXZlbnRzIHRvIGNvbnRhaW5lcnNcblx0XHRcdGZvciAoIHZhciBpID0gdGhpcy5jb250YWluZXJzLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5fdHJpZ2dlciggXCJkZWFjdGl2YXRlXCIsIG51bGwsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHRcdGlmICggdGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUub3ZlciApIHtcblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5fdHJpZ2dlciggXCJvdXRcIiwgbnVsbCwgdGhpcy5fdWlIYXNoKCB0aGlzICkgKTtcblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5jb250YWluZXJDYWNoZS5vdmVyID0gMDtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLnBsYWNlaG9sZGVyICkge1xuXG5cdFx0XHQvLyQodGhpcy5wbGFjZWhvbGRlclswXSkucmVtb3ZlKCk7IHdvdWxkIGhhdmUgYmVlbiB0aGUgalF1ZXJ5IHdheSAtIHVuZm9ydHVuYXRlbHksXG5cdFx0XHQvLyBpdCB1bmJpbmRzIEFMTCBldmVudHMgZnJvbSB0aGUgb3JpZ2luYWwgbm9kZSFcblx0XHRcdGlmICggdGhpcy5wbGFjZWhvbGRlclsgMCBdLnBhcmVudE5vZGUgKSB7XG5cdFx0XHRcdHRoaXMucGxhY2Vob2xkZXJbIDAgXS5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKCB0aGlzLnBsYWNlaG9sZGVyWyAwIF0gKTtcblx0XHRcdH1cblx0XHRcdGlmICggdGhpcy5vcHRpb25zLmhlbHBlciAhPT0gXCJvcmlnaW5hbFwiICYmIHRoaXMuaGVscGVyICYmXG5cdFx0XHRcdFx0dGhpcy5oZWxwZXJbIDAgXS5wYXJlbnROb2RlICkge1xuXHRcdFx0XHR0aGlzLmhlbHBlci5yZW1vdmUoKTtcblx0XHRcdH1cblxuXHRcdFx0JC5leHRlbmQoIHRoaXMsIHtcblx0XHRcdFx0aGVscGVyOiBudWxsLFxuXHRcdFx0XHRkcmFnZ2luZzogZmFsc2UsXG5cdFx0XHRcdHJldmVydGluZzogZmFsc2UsXG5cdFx0XHRcdF9ub0ZpbmFsU29ydDogbnVsbFxuXHRcdFx0fSApO1xuXG5cdFx0XHRpZiAoIHRoaXMuZG9tUG9zaXRpb24ucHJldiApIHtcblx0XHRcdFx0JCggdGhpcy5kb21Qb3NpdGlvbi5wcmV2ICkuYWZ0ZXIoIHRoaXMuY3VycmVudEl0ZW0gKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdCQoIHRoaXMuZG9tUG9zaXRpb24ucGFyZW50ICkucHJlcGVuZCggdGhpcy5jdXJyZW50SXRlbSApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHJldHVybiB0aGlzO1xuXG5cdH0sXG5cblx0c2VyaWFsaXplOiBmdW5jdGlvbiggbyApIHtcblxuXHRcdHZhciBpdGVtcyA9IHRoaXMuX2dldEl0ZW1zQXNqUXVlcnkoIG8gJiYgby5jb25uZWN0ZWQgKSxcblx0XHRcdHN0ciA9IFtdO1xuXHRcdG8gPSBvIHx8IHt9O1xuXG5cdFx0JCggaXRlbXMgKS5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdHZhciByZXMgPSAoICQoIG8uaXRlbSB8fCB0aGlzICkuYXR0ciggby5hdHRyaWJ1dGUgfHwgXCJpZFwiICkgfHwgXCJcIiApXG5cdFx0XHRcdC5tYXRjaCggby5leHByZXNzaW9uIHx8ICggLyguKylbXFwtPV9dKC4rKS8gKSApO1xuXHRcdFx0aWYgKCByZXMgKSB7XG5cdFx0XHRcdHN0ci5wdXNoKFxuXHRcdFx0XHRcdCggby5rZXkgfHwgcmVzWyAxIF0gKyBcIltdXCIgKSArXG5cdFx0XHRcdFx0XCI9XCIgKyAoIG8ua2V5ICYmIG8uZXhwcmVzc2lvbiA/IHJlc1sgMSBdIDogcmVzWyAyIF0gKSApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblxuXHRcdGlmICggIXN0ci5sZW5ndGggJiYgby5rZXkgKSB7XG5cdFx0XHRzdHIucHVzaCggby5rZXkgKyBcIj1cIiApO1xuXHRcdH1cblxuXHRcdHJldHVybiBzdHIuam9pbiggXCImXCIgKTtcblxuXHR9LFxuXG5cdHRvQXJyYXk6IGZ1bmN0aW9uKCBvICkge1xuXG5cdFx0dmFyIGl0ZW1zID0gdGhpcy5fZ2V0SXRlbXNBc2pRdWVyeSggbyAmJiBvLmNvbm5lY3RlZCApLFxuXHRcdFx0cmV0ID0gW107XG5cblx0XHRvID0gbyB8fCB7fTtcblxuXHRcdGl0ZW1zLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0cmV0LnB1c2goICQoIG8uaXRlbSB8fCB0aGlzICkuYXR0ciggby5hdHRyaWJ1dGUgfHwgXCJpZFwiICkgfHwgXCJcIiApO1xuXHRcdH0gKTtcblx0XHRyZXR1cm4gcmV0O1xuXG5cdH0sXG5cblx0LyogQmUgY2FyZWZ1bCB3aXRoIHRoZSBmb2xsb3dpbmcgY29yZSBmdW5jdGlvbnMgKi9cblx0X2ludGVyc2VjdHNXaXRoOiBmdW5jdGlvbiggaXRlbSApIHtcblxuXHRcdHZhciB4MSA9IHRoaXMucG9zaXRpb25BYnMubGVmdCxcblx0XHRcdHgyID0geDEgKyB0aGlzLmhlbHBlclByb3BvcnRpb25zLndpZHRoLFxuXHRcdFx0eTEgPSB0aGlzLnBvc2l0aW9uQWJzLnRvcCxcblx0XHRcdHkyID0geTEgKyB0aGlzLmhlbHBlclByb3BvcnRpb25zLmhlaWdodCxcblx0XHRcdGwgPSBpdGVtLmxlZnQsXG5cdFx0XHRyID0gbCArIGl0ZW0ud2lkdGgsXG5cdFx0XHR0ID0gaXRlbS50b3AsXG5cdFx0XHRiID0gdCArIGl0ZW0uaGVpZ2h0LFxuXHRcdFx0ZHlDbGljayA9IHRoaXMub2Zmc2V0LmNsaWNrLnRvcCxcblx0XHRcdGR4Q2xpY2sgPSB0aGlzLm9mZnNldC5jbGljay5sZWZ0LFxuXHRcdFx0aXNPdmVyRWxlbWVudEhlaWdodCA9ICggdGhpcy5vcHRpb25zLmF4aXMgPT09IFwieFwiICkgfHwgKCAoIHkxICsgZHlDbGljayApID4gdCAmJlxuXHRcdFx0XHQoIHkxICsgZHlDbGljayApIDwgYiApLFxuXHRcdFx0aXNPdmVyRWxlbWVudFdpZHRoID0gKCB0aGlzLm9wdGlvbnMuYXhpcyA9PT0gXCJ5XCIgKSB8fCAoICggeDEgKyBkeENsaWNrICkgPiBsICYmXG5cdFx0XHRcdCggeDEgKyBkeENsaWNrICkgPCByICksXG5cdFx0XHRpc092ZXJFbGVtZW50ID0gaXNPdmVyRWxlbWVudEhlaWdodCAmJiBpc092ZXJFbGVtZW50V2lkdGg7XG5cblx0XHRpZiAoIHRoaXMub3B0aW9ucy50b2xlcmFuY2UgPT09IFwicG9pbnRlclwiIHx8XG5cdFx0XHR0aGlzLm9wdGlvbnMuZm9yY2VQb2ludGVyRm9yQ29udGFpbmVycyB8fFxuXHRcdFx0KCB0aGlzLm9wdGlvbnMudG9sZXJhbmNlICE9PSBcInBvaW50ZXJcIiAmJlxuXHRcdFx0XHR0aGlzLmhlbHBlclByb3BvcnRpb25zWyB0aGlzLmZsb2F0aW5nID8gXCJ3aWR0aFwiIDogXCJoZWlnaHRcIiBdID5cblx0XHRcdFx0aXRlbVsgdGhpcy5mbG9hdGluZyA/IFwid2lkdGhcIiA6IFwiaGVpZ2h0XCIgXSApXG5cdFx0KSB7XG5cdFx0XHRyZXR1cm4gaXNPdmVyRWxlbWVudDtcblx0XHR9IGVsc2Uge1xuXG5cdFx0XHRyZXR1cm4gKCBsIDwgeDEgKyAoIHRoaXMuaGVscGVyUHJvcG9ydGlvbnMud2lkdGggLyAyICkgJiYgLy8gUmlnaHQgSGFsZlxuXHRcdFx0XHR4MiAtICggdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy53aWR0aCAvIDIgKSA8IHIgJiYgLy8gTGVmdCBIYWxmXG5cdFx0XHRcdHQgPCB5MSArICggdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy5oZWlnaHQgLyAyICkgJiYgLy8gQm90dG9tIEhhbGZcblx0XHRcdFx0eTIgLSAoIHRoaXMuaGVscGVyUHJvcG9ydGlvbnMuaGVpZ2h0IC8gMiApIDwgYiApOyAvLyBUb3AgSGFsZlxuXG5cdFx0fVxuXHR9LFxuXG5cdF9pbnRlcnNlY3RzV2l0aFBvaW50ZXI6IGZ1bmN0aW9uKCBpdGVtICkge1xuXHRcdHZhciB2ZXJ0aWNhbERpcmVjdGlvbiwgaG9yaXpvbnRhbERpcmVjdGlvbixcblx0XHRcdGlzT3ZlckVsZW1lbnRIZWlnaHQgPSAoIHRoaXMub3B0aW9ucy5heGlzID09PSBcInhcIiApIHx8XG5cdFx0XHRcdHRoaXMuX2lzT3ZlckF4aXMoXG5cdFx0XHRcdFx0dGhpcy5wb3NpdGlvbkFicy50b3AgKyB0aGlzLm9mZnNldC5jbGljay50b3AsIGl0ZW0udG9wLCBpdGVtLmhlaWdodCApLFxuXHRcdFx0aXNPdmVyRWxlbWVudFdpZHRoID0gKCB0aGlzLm9wdGlvbnMuYXhpcyA9PT0gXCJ5XCIgKSB8fFxuXHRcdFx0XHR0aGlzLl9pc092ZXJBeGlzKFxuXHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMubGVmdCArIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQsIGl0ZW0ubGVmdCwgaXRlbS53aWR0aCApLFxuXHRcdFx0aXNPdmVyRWxlbWVudCA9IGlzT3ZlckVsZW1lbnRIZWlnaHQgJiYgaXNPdmVyRWxlbWVudFdpZHRoO1xuXG5cdFx0aWYgKCAhaXNPdmVyRWxlbWVudCApIHtcblx0XHRcdHJldHVybiBmYWxzZTtcblx0XHR9XG5cblx0XHR2ZXJ0aWNhbERpcmVjdGlvbiA9IHRoaXMuZHJhZ0RpcmVjdGlvbi52ZXJ0aWNhbDtcblx0XHRob3Jpem9udGFsRGlyZWN0aW9uID0gdGhpcy5kcmFnRGlyZWN0aW9uLmhvcml6b250YWw7XG5cblx0XHRyZXR1cm4gdGhpcy5mbG9hdGluZyA/XG5cdFx0XHQoICggaG9yaXpvbnRhbERpcmVjdGlvbiA9PT0gXCJyaWdodFwiIHx8IHZlcnRpY2FsRGlyZWN0aW9uID09PSBcImRvd25cIiApID8gMiA6IDEgKSA6XG5cdFx0XHQoIHZlcnRpY2FsRGlyZWN0aW9uICYmICggdmVydGljYWxEaXJlY3Rpb24gPT09IFwiZG93blwiID8gMiA6IDEgKSApO1xuXG5cdH0sXG5cblx0X2ludGVyc2VjdHNXaXRoU2lkZXM6IGZ1bmN0aW9uKCBpdGVtICkge1xuXG5cdFx0dmFyIGlzT3ZlckJvdHRvbUhhbGYgPSB0aGlzLl9pc092ZXJBeGlzKCB0aGlzLnBvc2l0aW9uQWJzLnRvcCArXG5cdFx0XHRcdHRoaXMub2Zmc2V0LmNsaWNrLnRvcCwgaXRlbS50b3AgKyAoIGl0ZW0uaGVpZ2h0IC8gMiApLCBpdGVtLmhlaWdodCApLFxuXHRcdFx0aXNPdmVyUmlnaHRIYWxmID0gdGhpcy5faXNPdmVyQXhpcyggdGhpcy5wb3NpdGlvbkFicy5sZWZ0ICtcblx0XHRcdFx0dGhpcy5vZmZzZXQuY2xpY2subGVmdCwgaXRlbS5sZWZ0ICsgKCBpdGVtLndpZHRoIC8gMiApLCBpdGVtLndpZHRoICksXG5cdFx0XHR2ZXJ0aWNhbERpcmVjdGlvbiA9IHRoaXMuZHJhZ0RpcmVjdGlvbi52ZXJ0aWNhbCxcblx0XHRcdGhvcml6b250YWxEaXJlY3Rpb24gPSB0aGlzLmRyYWdEaXJlY3Rpb24uaG9yaXpvbnRhbDtcblxuXHRcdGlmICggdGhpcy5mbG9hdGluZyAmJiBob3Jpem9udGFsRGlyZWN0aW9uICkge1xuXHRcdFx0cmV0dXJuICggKCBob3Jpem9udGFsRGlyZWN0aW9uID09PSBcInJpZ2h0XCIgJiYgaXNPdmVyUmlnaHRIYWxmICkgfHxcblx0XHRcdFx0KCBob3Jpem9udGFsRGlyZWN0aW9uID09PSBcImxlZnRcIiAmJiAhaXNPdmVyUmlnaHRIYWxmICkgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0cmV0dXJuIHZlcnRpY2FsRGlyZWN0aW9uICYmICggKCB2ZXJ0aWNhbERpcmVjdGlvbiA9PT0gXCJkb3duXCIgJiYgaXNPdmVyQm90dG9tSGFsZiApIHx8XG5cdFx0XHRcdCggdmVydGljYWxEaXJlY3Rpb24gPT09IFwidXBcIiAmJiAhaXNPdmVyQm90dG9tSGFsZiApICk7XG5cdFx0fVxuXG5cdH0sXG5cblx0X2dldERyYWdWZXJ0aWNhbERpcmVjdGlvbjogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIGRlbHRhID0gdGhpcy5wb3NpdGlvbkFicy50b3AgLSB0aGlzLmxhc3RQb3NpdGlvbkFicy50b3A7XG5cdFx0cmV0dXJuIGRlbHRhICE9PSAwICYmICggZGVsdGEgPiAwID8gXCJkb3duXCIgOiBcInVwXCIgKTtcblx0fSxcblxuXHRfZ2V0RHJhZ0hvcml6b250YWxEaXJlY3Rpb246IGZ1bmN0aW9uKCkge1xuXHRcdHZhciBkZWx0YSA9IHRoaXMucG9zaXRpb25BYnMubGVmdCAtIHRoaXMubGFzdFBvc2l0aW9uQWJzLmxlZnQ7XG5cdFx0cmV0dXJuIGRlbHRhICE9PSAwICYmICggZGVsdGEgPiAwID8gXCJyaWdodFwiIDogXCJsZWZ0XCIgKTtcblx0fSxcblxuXHRyZWZyZXNoOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0dGhpcy5fcmVmcmVzaEl0ZW1zKCBldmVudCApO1xuXHRcdHRoaXMuX3NldEhhbmRsZUNsYXNzTmFtZSgpO1xuXHRcdHRoaXMucmVmcmVzaFBvc2l0aW9ucygpO1xuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdF9jb25uZWN0V2l0aDogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIG9wdGlvbnMgPSB0aGlzLm9wdGlvbnM7XG5cdFx0cmV0dXJuIG9wdGlvbnMuY29ubmVjdFdpdGguY29uc3RydWN0b3IgPT09IFN0cmluZyA/XG5cdFx0XHRbIG9wdGlvbnMuY29ubmVjdFdpdGggXSA6XG5cdFx0XHRvcHRpb25zLmNvbm5lY3RXaXRoO1xuXHR9LFxuXG5cdF9nZXRJdGVtc0FzalF1ZXJ5OiBmdW5jdGlvbiggY29ubmVjdGVkICkge1xuXG5cdFx0dmFyIGksIGosIGN1ciwgaW5zdCxcblx0XHRcdGl0ZW1zID0gW10sXG5cdFx0XHRxdWVyaWVzID0gW10sXG5cdFx0XHRjb25uZWN0V2l0aCA9IHRoaXMuX2Nvbm5lY3RXaXRoKCk7XG5cblx0XHRpZiAoIGNvbm5lY3RXaXRoICYmIGNvbm5lY3RlZCApIHtcblx0XHRcdGZvciAoIGkgPSBjb25uZWN0V2l0aC5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdFx0Y3VyID0gJCggY29ubmVjdFdpdGhbIGkgXSwgdGhpcy5kb2N1bWVudFsgMCBdICk7XG5cdFx0XHRcdGZvciAoIGogPSBjdXIubGVuZ3RoIC0gMTsgaiA+PSAwOyBqLS0gKSB7XG5cdFx0XHRcdFx0aW5zdCA9ICQuZGF0YSggY3VyWyBqIF0sIHRoaXMud2lkZ2V0RnVsbE5hbWUgKTtcblx0XHRcdFx0XHRpZiAoIGluc3QgJiYgaW5zdCAhPT0gdGhpcyAmJiAhaW5zdC5vcHRpb25zLmRpc2FibGVkICkge1xuXHRcdFx0XHRcdFx0cXVlcmllcy5wdXNoKCBbIHR5cGVvZiBpbnN0Lm9wdGlvbnMuaXRlbXMgPT09IFwiZnVuY3Rpb25cIiA/XG5cdFx0XHRcdFx0XHRcdGluc3Qub3B0aW9ucy5pdGVtcy5jYWxsKCBpbnN0LmVsZW1lbnQgKSA6XG5cdFx0XHRcdFx0XHRcdCQoIGluc3Qub3B0aW9ucy5pdGVtcywgaW5zdC5lbGVtZW50IClcblx0XHRcdFx0XHRcdFx0XHQubm90KCBcIi51aS1zb3J0YWJsZS1oZWxwZXJcIiApXG5cdFx0XHRcdFx0XHRcdFx0Lm5vdCggXCIudWktc29ydGFibGUtcGxhY2Vob2xkZXJcIiApLCBpbnN0IF0gKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHRxdWVyaWVzLnB1c2goIFsgdHlwZW9mIHRoaXMub3B0aW9ucy5pdGVtcyA9PT0gXCJmdW5jdGlvblwiID9cblx0XHRcdHRoaXMub3B0aW9ucy5pdGVtc1xuXHRcdFx0XHQuY2FsbCggdGhpcy5lbGVtZW50LCBudWxsLCB7IG9wdGlvbnM6IHRoaXMub3B0aW9ucywgaXRlbTogdGhpcy5jdXJyZW50SXRlbSB9ICkgOlxuXHRcdFx0JCggdGhpcy5vcHRpb25zLml0ZW1zLCB0aGlzLmVsZW1lbnQgKVxuXHRcdFx0XHQubm90KCBcIi51aS1zb3J0YWJsZS1oZWxwZXJcIiApXG5cdFx0XHRcdC5ub3QoIFwiLnVpLXNvcnRhYmxlLXBsYWNlaG9sZGVyXCIgKSwgdGhpcyBdICk7XG5cblx0XHRmdW5jdGlvbiBhZGRJdGVtcygpIHtcblx0XHRcdGl0ZW1zLnB1c2goIHRoaXMgKTtcblx0XHR9XG5cdFx0Zm9yICggaSA9IHF1ZXJpZXMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHRxdWVyaWVzWyBpIF1bIDAgXS5lYWNoKCBhZGRJdGVtcyApO1xuXHRcdH1cblxuXHRcdHJldHVybiAkKCBpdGVtcyApO1xuXG5cdH0sXG5cblx0X3JlbW92ZUN1cnJlbnRzRnJvbUl0ZW1zOiBmdW5jdGlvbigpIHtcblxuXHRcdHZhciBsaXN0ID0gdGhpcy5jdXJyZW50SXRlbS5maW5kKCBcIjpkYXRhKFwiICsgdGhpcy53aWRnZXROYW1lICsgXCItaXRlbSlcIiApO1xuXG5cdFx0dGhpcy5pdGVtcyA9ICQuZ3JlcCggdGhpcy5pdGVtcywgZnVuY3Rpb24oIGl0ZW0gKSB7XG5cdFx0XHRmb3IgKCB2YXIgaiA9IDA7IGogPCBsaXN0Lmxlbmd0aDsgaisrICkge1xuXHRcdFx0XHRpZiAoIGxpc3RbIGogXSA9PT0gaXRlbS5pdGVtWyAwIF0gKSB7XG5cdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XHRyZXR1cm4gdHJ1ZTtcblx0XHR9ICk7XG5cblx0fSxcblxuXHRfcmVmcmVzaEl0ZW1zOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cblx0XHR0aGlzLml0ZW1zID0gW107XG5cdFx0dGhpcy5jb250YWluZXJzID0gWyB0aGlzIF07XG5cblx0XHR2YXIgaSwgaiwgY3VyLCBpbnN0LCB0YXJnZXREYXRhLCBfcXVlcmllcywgaXRlbSwgcXVlcmllc0xlbmd0aCxcblx0XHRcdGl0ZW1zID0gdGhpcy5pdGVtcyxcblx0XHRcdHF1ZXJpZXMgPSBbIFsgdHlwZW9mIHRoaXMub3B0aW9ucy5pdGVtcyA9PT0gXCJmdW5jdGlvblwiID9cblx0XHRcdFx0dGhpcy5vcHRpb25zLml0ZW1zLmNhbGwoIHRoaXMuZWxlbWVudFsgMCBdLCBldmVudCwgeyBpdGVtOiB0aGlzLmN1cnJlbnRJdGVtIH0gKSA6XG5cdFx0XHRcdCQoIHRoaXMub3B0aW9ucy5pdGVtcywgdGhpcy5lbGVtZW50ICksIHRoaXMgXSBdLFxuXHRcdFx0Y29ubmVjdFdpdGggPSB0aGlzLl9jb25uZWN0V2l0aCgpO1xuXG5cdFx0Ly9TaG91bGRuJ3QgYmUgcnVuIHRoZSBmaXJzdCB0aW1lIHRocm91Z2ggZHVlIHRvIG1hc3NpdmUgc2xvdy1kb3duXG5cdFx0aWYgKCBjb25uZWN0V2l0aCAmJiB0aGlzLnJlYWR5ICkge1xuXHRcdFx0Zm9yICggaSA9IGNvbm5lY3RXaXRoLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0XHRjdXIgPSAkKCBjb25uZWN0V2l0aFsgaSBdLCB0aGlzLmRvY3VtZW50WyAwIF0gKTtcblx0XHRcdFx0Zm9yICggaiA9IGN1ci5sZW5ndGggLSAxOyBqID49IDA7IGotLSApIHtcblx0XHRcdFx0XHRpbnN0ID0gJC5kYXRhKCBjdXJbIGogXSwgdGhpcy53aWRnZXRGdWxsTmFtZSApO1xuXHRcdFx0XHRcdGlmICggaW5zdCAmJiBpbnN0ICE9PSB0aGlzICYmICFpbnN0Lm9wdGlvbnMuZGlzYWJsZWQgKSB7XG5cdFx0XHRcdFx0XHRxdWVyaWVzLnB1c2goIFsgdHlwZW9mIGluc3Qub3B0aW9ucy5pdGVtcyA9PT0gXCJmdW5jdGlvblwiID9cblx0XHRcdFx0XHRcdFx0aW5zdC5vcHRpb25zLml0ZW1zXG5cdFx0XHRcdFx0XHRcdFx0LmNhbGwoIGluc3QuZWxlbWVudFsgMCBdLCBldmVudCwgeyBpdGVtOiB0aGlzLmN1cnJlbnRJdGVtIH0gKSA6XG5cdFx0XHRcdFx0XHRcdCQoIGluc3Qub3B0aW9ucy5pdGVtcywgaW5zdC5lbGVtZW50ICksIGluc3QgXSApO1xuXHRcdFx0XHRcdFx0dGhpcy5jb250YWluZXJzLnB1c2goIGluc3QgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHRmb3IgKCBpID0gcXVlcmllcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblx0XHRcdHRhcmdldERhdGEgPSBxdWVyaWVzWyBpIF1bIDEgXTtcblx0XHRcdF9xdWVyaWVzID0gcXVlcmllc1sgaSBdWyAwIF07XG5cblx0XHRcdGZvciAoIGogPSAwLCBxdWVyaWVzTGVuZ3RoID0gX3F1ZXJpZXMubGVuZ3RoOyBqIDwgcXVlcmllc0xlbmd0aDsgaisrICkge1xuXHRcdFx0XHRpdGVtID0gJCggX3F1ZXJpZXNbIGogXSApO1xuXG5cdFx0XHRcdC8vIERhdGEgZm9yIHRhcmdldCBjaGVja2luZyAobW91c2UgbWFuYWdlcilcblx0XHRcdFx0aXRlbS5kYXRhKCB0aGlzLndpZGdldE5hbWUgKyBcIi1pdGVtXCIsIHRhcmdldERhdGEgKTtcblxuXHRcdFx0XHRpdGVtcy5wdXNoKCB7XG5cdFx0XHRcdFx0aXRlbTogaXRlbSxcblx0XHRcdFx0XHRpbnN0YW5jZTogdGFyZ2V0RGF0YSxcblx0XHRcdFx0XHR3aWR0aDogMCwgaGVpZ2h0OiAwLFxuXHRcdFx0XHRcdGxlZnQ6IDAsIHRvcDogMFxuXHRcdFx0XHR9ICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdH0sXG5cblx0X3JlZnJlc2hJdGVtUG9zaXRpb25zOiBmdW5jdGlvbiggZmFzdCApIHtcblx0XHR2YXIgaSwgaXRlbSwgdCwgcDtcblxuXHRcdGZvciAoIGkgPSB0aGlzLml0ZW1zLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0aXRlbSA9IHRoaXMuaXRlbXNbIGkgXTtcblxuXHRcdFx0Ly9XZSBpZ25vcmUgY2FsY3VsYXRpbmcgcG9zaXRpb25zIG9mIGFsbCBjb25uZWN0ZWQgY29udGFpbmVycyB3aGVuIHdlJ3JlIG5vdCBvdmVyIHRoZW1cblx0XHRcdGlmICggdGhpcy5jdXJyZW50Q29udGFpbmVyICYmIGl0ZW0uaW5zdGFuY2UgIT09IHRoaXMuY3VycmVudENvbnRhaW5lciAmJlxuXHRcdFx0XHRcdGl0ZW0uaXRlbVsgMCBdICE9PSB0aGlzLmN1cnJlbnRJdGVtWyAwIF0gKSB7XG5cdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0fVxuXG5cdFx0XHR0ID0gdGhpcy5vcHRpb25zLnRvbGVyYW5jZUVsZW1lbnQgP1xuXHRcdFx0XHQkKCB0aGlzLm9wdGlvbnMudG9sZXJhbmNlRWxlbWVudCwgaXRlbS5pdGVtICkgOlxuXHRcdFx0XHRpdGVtLml0ZW07XG5cblx0XHRcdGlmICggIWZhc3QgKSB7XG5cdFx0XHRcdGl0ZW0ud2lkdGggPSB0Lm91dGVyV2lkdGgoKTtcblx0XHRcdFx0aXRlbS5oZWlnaHQgPSB0Lm91dGVySGVpZ2h0KCk7XG5cdFx0XHR9XG5cblx0XHRcdHAgPSB0Lm9mZnNldCgpO1xuXHRcdFx0aXRlbS5sZWZ0ID0gcC5sZWZ0O1xuXHRcdFx0aXRlbS50b3AgPSBwLnRvcDtcblx0XHR9XG5cdH0sXG5cblx0cmVmcmVzaFBvc2l0aW9uczogZnVuY3Rpb24oIGZhc3QgKSB7XG5cblx0XHQvLyBEZXRlcm1pbmUgd2hldGhlciBpdGVtcyBhcmUgYmVpbmcgZGlzcGxheWVkIGhvcml6b250YWxseVxuXHRcdHRoaXMuZmxvYXRpbmcgPSB0aGlzLml0ZW1zLmxlbmd0aCA/XG5cdFx0XHR0aGlzLm9wdGlvbnMuYXhpcyA9PT0gXCJ4XCIgfHwgdGhpcy5faXNGbG9hdGluZyggdGhpcy5pdGVtc1sgMCBdLml0ZW0gKSA6XG5cdFx0XHRmYWxzZTtcblxuXHRcdC8vIFRoaXMgaGFzIHRvIGJlIHJlZG9uZSBiZWNhdXNlIGR1ZSB0byB0aGUgaXRlbSBiZWluZyBtb3ZlZCBvdXQvaW50byB0aGUgb2Zmc2V0UGFyZW50LFxuXHRcdC8vIHRoZSBvZmZzZXRQYXJlbnQncyBwb3NpdGlvbiB3aWxsIGNoYW5nZVxuXHRcdGlmICggdGhpcy5vZmZzZXRQYXJlbnQgJiYgdGhpcy5oZWxwZXIgKSB7XG5cdFx0XHR0aGlzLm9mZnNldC5wYXJlbnQgPSB0aGlzLl9nZXRQYXJlbnRPZmZzZXQoKTtcblx0XHR9XG5cblx0XHR0aGlzLl9yZWZyZXNoSXRlbVBvc2l0aW9ucyggZmFzdCApO1xuXG5cdFx0dmFyIGksIHA7XG5cblx0XHRpZiAoIHRoaXMub3B0aW9ucy5jdXN0b20gJiYgdGhpcy5vcHRpb25zLmN1c3RvbS5yZWZyZXNoQ29udGFpbmVycyApIHtcblx0XHRcdHRoaXMub3B0aW9ucy5jdXN0b20ucmVmcmVzaENvbnRhaW5lcnMuY2FsbCggdGhpcyApO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRmb3IgKCBpID0gdGhpcy5jb250YWluZXJzLmxlbmd0aCAtIDE7IGkgPj0gMDsgaS0tICkge1xuXHRcdFx0XHRwID0gdGhpcy5jb250YWluZXJzWyBpIF0uZWxlbWVudC5vZmZzZXQoKTtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUubGVmdCA9IHAubGVmdDtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUudG9wID0gcC50b3A7XG5cdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLndpZHRoID1cblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5lbGVtZW50Lm91dGVyV2lkdGgoKTtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUuaGVpZ2h0ID1cblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGkgXS5lbGVtZW50Lm91dGVySGVpZ2h0KCk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0X2NyZWF0ZVBsYWNlaG9sZGVyOiBmdW5jdGlvbiggdGhhdCApIHtcblx0XHR0aGF0ID0gdGhhdCB8fCB0aGlzO1xuXHRcdHZhciBjbGFzc05hbWUsIG5vZGVOYW1lLFxuXHRcdFx0byA9IHRoYXQub3B0aW9ucztcblxuXHRcdGlmICggIW8ucGxhY2Vob2xkZXIgfHwgby5wbGFjZWhvbGRlci5jb25zdHJ1Y3RvciA9PT0gU3RyaW5nICkge1xuXHRcdFx0Y2xhc3NOYW1lID0gby5wbGFjZWhvbGRlcjtcblx0XHRcdG5vZGVOYW1lID0gdGhhdC5jdXJyZW50SXRlbVsgMCBdLm5vZGVOYW1lLnRvTG93ZXJDYXNlKCk7XG5cdFx0XHRvLnBsYWNlaG9sZGVyID0ge1xuXHRcdFx0XHRlbGVtZW50OiBmdW5jdGlvbigpIHtcblxuXHRcdFx0XHRcdHZhciBlbGVtZW50ID0gJCggXCI8XCIgKyBub2RlTmFtZSArIFwiPlwiLCB0aGF0LmRvY3VtZW50WyAwIF0gKTtcblxuXHRcdFx0XHRcdHRoYXQuX2FkZENsYXNzKCBlbGVtZW50LCBcInVpLXNvcnRhYmxlLXBsYWNlaG9sZGVyXCIsXG5cdFx0XHRcdFx0XHRcdGNsYXNzTmFtZSB8fCB0aGF0LmN1cnJlbnRJdGVtWyAwIF0uY2xhc3NOYW1lIClcblx0XHRcdFx0XHRcdC5fcmVtb3ZlQ2xhc3MoIGVsZW1lbnQsIFwidWktc29ydGFibGUtaGVscGVyXCIgKTtcblxuXHRcdFx0XHRcdGlmICggbm9kZU5hbWUgPT09IFwidGJvZHlcIiApIHtcblx0XHRcdFx0XHRcdHRoYXQuX2NyZWF0ZVRyUGxhY2Vob2xkZXIoXG5cdFx0XHRcdFx0XHRcdHRoYXQuY3VycmVudEl0ZW0uZmluZCggXCJ0clwiICkuZXEoIDAgKSxcblx0XHRcdFx0XHRcdFx0JCggXCI8dHI+XCIsIHRoYXQuZG9jdW1lbnRbIDAgXSApLmFwcGVuZFRvKCBlbGVtZW50IClcblx0XHRcdFx0XHRcdCk7XG5cdFx0XHRcdFx0fSBlbHNlIGlmICggbm9kZU5hbWUgPT09IFwidHJcIiApIHtcblx0XHRcdFx0XHRcdHRoYXQuX2NyZWF0ZVRyUGxhY2Vob2xkZXIoIHRoYXQuY3VycmVudEl0ZW0sIGVsZW1lbnQgKTtcblx0XHRcdFx0XHR9IGVsc2UgaWYgKCBub2RlTmFtZSA9PT0gXCJpbWdcIiApIHtcblx0XHRcdFx0XHRcdGVsZW1lbnQuYXR0ciggXCJzcmNcIiwgdGhhdC5jdXJyZW50SXRlbS5hdHRyKCBcInNyY1wiICkgKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRpZiAoICFjbGFzc05hbWUgKSB7XG5cdFx0XHRcdFx0XHRlbGVtZW50LmNzcyggXCJ2aXNpYmlsaXR5XCIsIFwiaGlkZGVuXCIgKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRyZXR1cm4gZWxlbWVudDtcblx0XHRcdFx0fSxcblx0XHRcdFx0dXBkYXRlOiBmdW5jdGlvbiggY29udGFpbmVyLCBwICkge1xuXG5cdFx0XHRcdFx0Ly8gMS4gSWYgYSBjbGFzc05hbWUgaXMgc2V0IGFzICdwbGFjZWhvbGRlciBvcHRpb24sIHdlIGRvbid0IGZvcmNlIHNpemVzIC1cblx0XHRcdFx0XHQvLyB0aGUgY2xhc3MgaXMgcmVzcG9uc2libGUgZm9yIHRoYXRcblx0XHRcdFx0XHQvLyAyLiBUaGUgb3B0aW9uICdmb3JjZVBsYWNlaG9sZGVyU2l6ZSBjYW4gYmUgZW5hYmxlZCB0byBmb3JjZSBpdCBldmVuIGlmIGFcblx0XHRcdFx0XHQvLyBjbGFzcyBuYW1lIGlzIHNwZWNpZmllZFxuXHRcdFx0XHRcdGlmICggY2xhc3NOYW1lICYmICFvLmZvcmNlUGxhY2Vob2xkZXJTaXplICkge1xuXHRcdFx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIElmIHRoZSBlbGVtZW50IGRvZXNuJ3QgaGF2ZSBhIGFjdHVhbCBoZWlnaHQgb3Igd2lkdGggYnkgaXRzZWxmICh3aXRob3V0XG5cdFx0XHRcdFx0Ly8gc3R5bGVzIGNvbWluZyBmcm9tIGEgc3R5bGVzaGVldCksIGl0IHJlY2VpdmVzIHRoZSBpbmxpbmUgaGVpZ2h0IGFuZCB3aWR0aFxuXHRcdFx0XHRcdC8vIGZyb20gdGhlIGRyYWdnZWQgaXRlbS4gT3IsIGlmIGl0J3MgYSB0Ym9keSBvciB0ciwgaXQncyBnb2luZyB0byBoYXZlIGEgaGVpZ2h0XG5cdFx0XHRcdFx0Ly8gYW55d2F5IHNpbmNlIHdlJ3JlIHBvcHVsYXRpbmcgdGhlbSB3aXRoIDx0ZD5zIGFib3ZlLCBidXQgdGhleSdyZSB1bmxpa2VseSB0b1xuXHRcdFx0XHRcdC8vIGJlIHRoZSBjb3JyZWN0IGhlaWdodCBvbiB0aGVpciBvd24gaWYgdGhlIHJvdyBoZWlnaHRzIGFyZSBkeW5hbWljLCBzbyB3ZSdsbFxuXHRcdFx0XHRcdC8vIGFsd2F5cyBhc3NpZ24gdGhlIGhlaWdodCBvZiB0aGUgZHJhZ2dlZCBpdGVtIGdpdmVuIGZvcmNlUGxhY2Vob2xkZXJTaXplXG5cdFx0XHRcdFx0Ly8gaXMgdHJ1ZS5cblx0XHRcdFx0XHRpZiAoICFwLmhlaWdodCgpIHx8ICggby5mb3JjZVBsYWNlaG9sZGVyU2l6ZSAmJlxuXHRcdFx0XHRcdFx0XHQoIG5vZGVOYW1lID09PSBcInRib2R5XCIgfHwgbm9kZU5hbWUgPT09IFwidHJcIiApICkgKSB7XG5cdFx0XHRcdFx0XHRwLmhlaWdodChcblx0XHRcdFx0XHRcdFx0dGhhdC5jdXJyZW50SXRlbS5pbm5lckhlaWdodCgpIC1cblx0XHRcdFx0XHRcdFx0cGFyc2VJbnQoIHRoYXQuY3VycmVudEl0ZW0uY3NzKCBcInBhZGRpbmdUb3BcIiApIHx8IDAsIDEwICkgLVxuXHRcdFx0XHRcdFx0XHRwYXJzZUludCggdGhhdC5jdXJyZW50SXRlbS5jc3MoIFwicGFkZGluZ0JvdHRvbVwiICkgfHwgMCwgMTAgKSApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRpZiAoICFwLndpZHRoKCkgKSB7XG5cdFx0XHRcdFx0XHRwLndpZHRoKFxuXHRcdFx0XHRcdFx0XHR0aGF0LmN1cnJlbnRJdGVtLmlubmVyV2lkdGgoKSAtXG5cdFx0XHRcdFx0XHRcdHBhcnNlSW50KCB0aGF0LmN1cnJlbnRJdGVtLmNzcyggXCJwYWRkaW5nTGVmdFwiICkgfHwgMCwgMTAgKSAtXG5cdFx0XHRcdFx0XHRcdHBhcnNlSW50KCB0aGF0LmN1cnJlbnRJdGVtLmNzcyggXCJwYWRkaW5nUmlnaHRcIiApIHx8IDAsIDEwICkgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH07XG5cdFx0fVxuXG5cdFx0Ly9DcmVhdGUgdGhlIHBsYWNlaG9sZGVyXG5cdFx0dGhhdC5wbGFjZWhvbGRlciA9ICQoIG8ucGxhY2Vob2xkZXIuZWxlbWVudC5jYWxsKCB0aGF0LmVsZW1lbnQsIHRoYXQuY3VycmVudEl0ZW0gKSApO1xuXG5cdFx0Ly9BcHBlbmQgaXQgYWZ0ZXIgdGhlIGFjdHVhbCBjdXJyZW50IGl0ZW1cblx0XHR0aGF0LmN1cnJlbnRJdGVtLmFmdGVyKCB0aGF0LnBsYWNlaG9sZGVyICk7XG5cblx0XHQvL1VwZGF0ZSB0aGUgc2l6ZSBvZiB0aGUgcGxhY2Vob2xkZXIgKFRPRE86IExvZ2ljIHRvIGZ1enp5LCBzZWUgbGluZSAzMTYvMzE3KVxuXHRcdG8ucGxhY2Vob2xkZXIudXBkYXRlKCB0aGF0LCB0aGF0LnBsYWNlaG9sZGVyICk7XG5cblx0fSxcblxuXHRfY3JlYXRlVHJQbGFjZWhvbGRlcjogZnVuY3Rpb24oIHNvdXJjZVRyLCB0YXJnZXRUciApIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0XHRzb3VyY2VUci5jaGlsZHJlbigpLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0JCggXCI8dGQ+JiMxNjA7PC90ZD5cIiwgdGhhdC5kb2N1bWVudFsgMCBdIClcblx0XHRcdFx0LmF0dHIoIFwiY29sc3BhblwiLCAkKCB0aGlzICkuYXR0ciggXCJjb2xzcGFuXCIgKSB8fCAxIClcblx0XHRcdFx0LmFwcGVuZFRvKCB0YXJnZXRUciApO1xuXHRcdH0gKTtcblx0fSxcblxuXHRfY29udGFjdENvbnRhaW5lcnM6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR2YXIgaSwgaiwgZGlzdCwgaXRlbVdpdGhMZWFzdERpc3RhbmNlLCBwb3NQcm9wZXJ0eSwgc2l6ZVByb3BlcnR5LCBjdXIsIG5lYXJCb3R0b20sXG5cdFx0XHRmbG9hdGluZywgYXhpcyxcblx0XHRcdGlubmVybW9zdENvbnRhaW5lciA9IG51bGwsXG5cdFx0XHRpbm5lcm1vc3RJbmRleCA9IG51bGw7XG5cblx0XHQvLyBHZXQgaW5uZXJtb3N0IGNvbnRhaW5lciB0aGF0IGludGVyc2VjdHMgd2l0aCBpdGVtXG5cdFx0Zm9yICggaSA9IHRoaXMuY29udGFpbmVycy5sZW5ndGggLSAxOyBpID49IDA7IGktLSApIHtcblxuXHRcdFx0Ly8gTmV2ZXIgY29uc2lkZXIgYSBjb250YWluZXIgdGhhdCdzIGxvY2F0ZWQgd2l0aGluIHRoZSBpdGVtIGl0c2VsZlxuXHRcdFx0aWYgKCAkLmNvbnRhaW5zKCB0aGlzLmN1cnJlbnRJdGVtWyAwIF0sIHRoaXMuY29udGFpbmVyc1sgaSBdLmVsZW1lbnRbIDAgXSApICkge1xuXHRcdFx0XHRjb250aW51ZTtcblx0XHRcdH1cblxuXHRcdFx0aWYgKCB0aGlzLl9pbnRlcnNlY3RzV2l0aCggdGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUgKSApIHtcblxuXHRcdFx0XHQvLyBJZiB3ZSd2ZSBhbHJlYWR5IGZvdW5kIGEgY29udGFpbmVyIGFuZCBpdCdzIG1vcmUgXCJpbm5lclwiIHRoYW4gdGhpcywgdGhlbiBjb250aW51ZVxuXHRcdFx0XHRpZiAoIGlubmVybW9zdENvbnRhaW5lciAmJlxuXHRcdFx0XHRcdFx0JC5jb250YWlucyhcblx0XHRcdFx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uZWxlbWVudFsgMCBdLFxuXHRcdFx0XHRcdFx0XHRpbm5lcm1vc3RDb250YWluZXIuZWxlbWVudFsgMCBdICkgKSB7XG5cdFx0XHRcdFx0Y29udGludWU7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRpbm5lcm1vc3RDb250YWluZXIgPSB0aGlzLmNvbnRhaW5lcnNbIGkgXTtcblx0XHRcdFx0aW5uZXJtb3N0SW5kZXggPSBpO1xuXG5cdFx0XHR9IGVsc2Uge1xuXG5cdFx0XHRcdC8vIGNvbnRhaW5lciBkb2Vzbid0IGludGVyc2VjdC4gdHJpZ2dlciBcIm91dFwiIGV2ZW50IGlmIG5lY2Vzc2FyeVxuXHRcdFx0XHRpZiAoIHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLm92ZXIgKSB7XG5cdFx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uX3RyaWdnZXIoIFwib3V0XCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaSBdLmNvbnRhaW5lckNhY2hlLm92ZXIgPSAwO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHR9XG5cblx0XHQvLyBJZiBubyBpbnRlcnNlY3RpbmcgY29udGFpbmVycyBmb3VuZCwgcmV0dXJuXG5cdFx0aWYgKCAhaW5uZXJtb3N0Q29udGFpbmVyICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdC8vIE1vdmUgdGhlIGl0ZW0gaW50byB0aGUgY29udGFpbmVyIGlmIGl0J3Mgbm90IHRoZXJlIGFscmVhZHlcblx0XHRpZiAoIHRoaXMuY29udGFpbmVycy5sZW5ndGggPT09IDEgKSB7XG5cdFx0XHRpZiAoICF0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uY29udGFpbmVyQ2FjaGUub3ZlciApIHtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdLl90cmlnZ2VyKCBcIm92ZXJcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5jb250YWluZXJDYWNoZS5vdmVyID0gMTtcblx0XHRcdH1cblx0XHR9IGVsc2Uge1xuXG5cdFx0XHQvLyBXaGVuIGVudGVyaW5nIGEgbmV3IGNvbnRhaW5lciwgd2Ugd2lsbCBmaW5kIHRoZSBpdGVtIHdpdGggdGhlIGxlYXN0IGRpc3RhbmNlIGFuZFxuXHRcdFx0Ly8gYXBwZW5kIG91ciBpdGVtIG5lYXIgaXRcblx0XHRcdGRpc3QgPSAxMDAwMDtcblx0XHRcdGl0ZW1XaXRoTGVhc3REaXN0YW5jZSA9IG51bGw7XG5cdFx0XHRmbG9hdGluZyA9IGlubmVybW9zdENvbnRhaW5lci5mbG9hdGluZyB8fCB0aGlzLl9pc0Zsb2F0aW5nKCB0aGlzLmN1cnJlbnRJdGVtICk7XG5cdFx0XHRwb3NQcm9wZXJ0eSA9IGZsb2F0aW5nID8gXCJsZWZ0XCIgOiBcInRvcFwiO1xuXHRcdFx0c2l6ZVByb3BlcnR5ID0gZmxvYXRpbmcgPyBcIndpZHRoXCIgOiBcImhlaWdodFwiO1xuXHRcdFx0YXhpcyA9IGZsb2F0aW5nID8gXCJwYWdlWFwiIDogXCJwYWdlWVwiO1xuXG5cdFx0XHRmb3IgKCBqID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBqID49IDA7IGotLSApIHtcblx0XHRcdFx0aWYgKCAhJC5jb250YWlucyhcblx0XHRcdFx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5lbGVtZW50WyAwIF0sIHRoaXMuaXRlbXNbIGogXS5pdGVtWyAwIF0gKVxuXHRcdFx0XHQpIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoIHRoaXMuaXRlbXNbIGogXS5pdGVtWyAwIF0gPT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdGN1ciA9IHRoaXMuaXRlbXNbIGogXS5pdGVtLm9mZnNldCgpWyBwb3NQcm9wZXJ0eSBdO1xuXHRcdFx0XHRuZWFyQm90dG9tID0gZmFsc2U7XG5cdFx0XHRcdGlmICggZXZlbnRbIGF4aXMgXSAtIGN1ciA+IHRoaXMuaXRlbXNbIGogXVsgc2l6ZVByb3BlcnR5IF0gLyAyICkge1xuXHRcdFx0XHRcdG5lYXJCb3R0b20gPSB0cnVlO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWYgKCBNYXRoLmFicyggZXZlbnRbIGF4aXMgXSAtIGN1ciApIDwgZGlzdCApIHtcblx0XHRcdFx0XHRkaXN0ID0gTWF0aC5hYnMoIGV2ZW50WyBheGlzIF0gLSBjdXIgKTtcblx0XHRcdFx0XHRpdGVtV2l0aExlYXN0RGlzdGFuY2UgPSB0aGlzLml0ZW1zWyBqIF07XG5cdFx0XHRcdFx0dGhpcy5kaXJlY3Rpb24gPSBuZWFyQm90dG9tID8gXCJ1cFwiIDogXCJkb3duXCI7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly9DaGVjayBpZiBkcm9wT25FbXB0eSBpcyBlbmFibGVkXG5cdFx0XHRpZiAoICFpdGVtV2l0aExlYXN0RGlzdGFuY2UgJiYgIXRoaXMub3B0aW9ucy5kcm9wT25FbXB0eSApIHtcblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIHRoaXMuY3VycmVudENvbnRhaW5lciA9PT0gdGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdICkge1xuXHRcdFx0XHRpZiAoICF0aGlzLmN1cnJlbnRDb250YWluZXIuY29udGFpbmVyQ2FjaGUub3ZlciApIHtcblx0XHRcdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uX3RyaWdnZXIoIFwib3ZlclwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHRcdFx0XHR0aGlzLmN1cnJlbnRDb250YWluZXIuY29udGFpbmVyQ2FjaGUub3ZlciA9IDE7XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIGl0ZW1XaXRoTGVhc3REaXN0YW5jZSApIHtcblx0XHRcdFx0dGhpcy5fcmVhcnJhbmdlKCBldmVudCwgaXRlbVdpdGhMZWFzdERpc3RhbmNlLCBudWxsLCB0cnVlICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHR0aGlzLl9yZWFycmFuZ2UoIGV2ZW50LCBudWxsLCB0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uZWxlbWVudCwgdHJ1ZSApO1xuXHRcdFx0fVxuXHRcdFx0dGhpcy5fdHJpZ2dlciggXCJjaGFuZ2VcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uX3RyaWdnZXIoIFwiY2hhbmdlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0dGhpcy5jdXJyZW50Q29udGFpbmVyID0gdGhpcy5jb250YWluZXJzWyBpbm5lcm1vc3RJbmRleCBdO1xuXG5cdFx0XHQvL1VwZGF0ZSB0aGUgcGxhY2Vob2xkZXJcblx0XHRcdHRoaXMub3B0aW9ucy5wbGFjZWhvbGRlci51cGRhdGUoIHRoaXMuY3VycmVudENvbnRhaW5lciwgdGhpcy5wbGFjZWhvbGRlciApO1xuXG5cdFx0XHQvL1VwZGF0ZSBzY3JvbGxQYXJlbnRcblx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50ID0gdGhpcy5wbGFjZWhvbGRlci5zY3JvbGxQYXJlbnQoKTtcblxuXHRcdFx0Ly9VcGRhdGUgb3ZlcmZsb3dPZmZzZXRcblx0XHRcdGlmICggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSAhPT0gdGhpcy5kb2N1bWVudFsgMCBdICYmXG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnRbIDAgXS50YWdOYW1lICE9PSBcIkhUTUxcIiApIHtcblx0XHRcdFx0dGhpcy5vdmVyZmxvd09mZnNldCA9IHRoaXMuc2Nyb2xsUGFyZW50Lm9mZnNldCgpO1xuXHRcdFx0fVxuXG5cdFx0XHR0aGlzLmNvbnRhaW5lcnNbIGlubmVybW9zdEluZGV4IF0uX3RyaWdnZXIoIFwib3ZlclwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCB0aGlzICkgKTtcblx0XHRcdHRoaXMuY29udGFpbmVyc1sgaW5uZXJtb3N0SW5kZXggXS5jb250YWluZXJDYWNoZS5vdmVyID0gMTtcblx0XHR9XG5cblx0fSxcblxuXHRfY3JlYXRlSGVscGVyOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cblx0XHR2YXIgbyA9IHRoaXMub3B0aW9ucyxcblx0XHRcdGhlbHBlciA9IHR5cGVvZiBvLmhlbHBlciA9PT0gXCJmdW5jdGlvblwiID9cblx0XHRcdFx0JCggby5oZWxwZXIuYXBwbHkoIHRoaXMuZWxlbWVudFsgMCBdLCBbIGV2ZW50LCB0aGlzLmN1cnJlbnRJdGVtIF0gKSApIDpcblx0XHRcdFx0KCBvLmhlbHBlciA9PT0gXCJjbG9uZVwiID8gdGhpcy5jdXJyZW50SXRlbS5jbG9uZSgpIDogdGhpcy5jdXJyZW50SXRlbSApO1xuXG5cdFx0Ly9BZGQgdGhlIGhlbHBlciB0byB0aGUgRE9NIGlmIHRoYXQgZGlkbid0IGhhcHBlbiBhbHJlYWR5XG5cdFx0aWYgKCAhaGVscGVyLnBhcmVudHMoIFwiYm9keVwiICkubGVuZ3RoICkge1xuXHRcdFx0dGhpcy5hcHBlbmRUb1sgMCBdLmFwcGVuZENoaWxkKCBoZWxwZXJbIDAgXSApO1xuXHRcdH1cblxuXHRcdGlmICggaGVscGVyWyAwIF0gPT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdHRoaXMuX3N0b3JlZENTUyA9IHtcblx0XHRcdFx0d2lkdGg6IHRoaXMuY3VycmVudEl0ZW1bIDAgXS5zdHlsZS53aWR0aCxcblx0XHRcdFx0aGVpZ2h0OiB0aGlzLmN1cnJlbnRJdGVtWyAwIF0uc3R5bGUuaGVpZ2h0LFxuXHRcdFx0XHRwb3NpdGlvbjogdGhpcy5jdXJyZW50SXRlbS5jc3MoIFwicG9zaXRpb25cIiApLFxuXHRcdFx0XHR0b3A6IHRoaXMuY3VycmVudEl0ZW0uY3NzKCBcInRvcFwiICksXG5cdFx0XHRcdGxlZnQ6IHRoaXMuY3VycmVudEl0ZW0uY3NzKCBcImxlZnRcIiApXG5cdFx0XHR9O1xuXHRcdH1cblxuXHRcdGlmICggIWhlbHBlclsgMCBdLnN0eWxlLndpZHRoIHx8IG8uZm9yY2VIZWxwZXJTaXplICkge1xuXHRcdFx0aGVscGVyLndpZHRoKCB0aGlzLmN1cnJlbnRJdGVtLndpZHRoKCkgKTtcblx0XHR9XG5cdFx0aWYgKCAhaGVscGVyWyAwIF0uc3R5bGUuaGVpZ2h0IHx8IG8uZm9yY2VIZWxwZXJTaXplICkge1xuXHRcdFx0aGVscGVyLmhlaWdodCggdGhpcy5jdXJyZW50SXRlbS5oZWlnaHQoKSApO1xuXHRcdH1cblxuXHRcdHJldHVybiBoZWxwZXI7XG5cblx0fSxcblxuXHRfYWRqdXN0T2Zmc2V0RnJvbUhlbHBlcjogZnVuY3Rpb24oIG9iaiApIHtcblx0XHRpZiAoIHR5cGVvZiBvYmogPT09IFwic3RyaW5nXCIgKSB7XG5cdFx0XHRvYmogPSBvYmouc3BsaXQoIFwiIFwiICk7XG5cdFx0fVxuXHRcdGlmICggQXJyYXkuaXNBcnJheSggb2JqICkgKSB7XG5cdFx0XHRvYmogPSB7IGxlZnQ6ICtvYmpbIDAgXSwgdG9wOiArb2JqWyAxIF0gfHwgMCB9O1xuXHRcdH1cblx0XHRpZiAoIFwibGVmdFwiIGluIG9iaiApIHtcblx0XHRcdHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQgPSBvYmoubGVmdCArIHRoaXMubWFyZ2lucy5sZWZ0O1xuXHRcdH1cblx0XHRpZiAoIFwicmlnaHRcIiBpbiBvYmogKSB7XG5cdFx0XHR0aGlzLm9mZnNldC5jbGljay5sZWZ0ID0gdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy53aWR0aCAtIG9iai5yaWdodCArIHRoaXMubWFyZ2lucy5sZWZ0O1xuXHRcdH1cblx0XHRpZiAoIFwidG9wXCIgaW4gb2JqICkge1xuXHRcdFx0dGhpcy5vZmZzZXQuY2xpY2sudG9wID0gb2JqLnRvcCArIHRoaXMubWFyZ2lucy50b3A7XG5cdFx0fVxuXHRcdGlmICggXCJib3R0b21cIiBpbiBvYmogKSB7XG5cdFx0XHR0aGlzLm9mZnNldC5jbGljay50b3AgPSB0aGlzLmhlbHBlclByb3BvcnRpb25zLmhlaWdodCAtIG9iai5ib3R0b20gKyB0aGlzLm1hcmdpbnMudG9wO1xuXHRcdH1cblx0fSxcblxuXHRfZ2V0UGFyZW50T2Zmc2V0OiBmdW5jdGlvbigpIHtcblxuXHRcdC8vR2V0IHRoZSBvZmZzZXRQYXJlbnQgYW5kIGNhY2hlIGl0cyBwb3NpdGlvblxuXHRcdHRoaXMub2Zmc2V0UGFyZW50ID0gdGhpcy5oZWxwZXIub2Zmc2V0UGFyZW50KCk7XG5cdFx0dmFyIHBvID0gdGhpcy5vZmZzZXRQYXJlbnQub2Zmc2V0KCk7XG5cblx0XHQvLyBUaGlzIGlzIGEgc3BlY2lhbCBjYXNlIHdoZXJlIHdlIG5lZWQgdG8gbW9kaWZ5IGEgb2Zmc2V0IGNhbGN1bGF0ZWQgb24gc3RhcnQsIHNpbmNlIHRoZVxuXHRcdC8vIGZvbGxvd2luZyBoYXBwZW5lZDpcblx0XHQvLyAxLiBUaGUgcG9zaXRpb24gb2YgdGhlIGhlbHBlciBpcyBhYnNvbHV0ZSwgc28gaXQncyBwb3NpdGlvbiBpcyBjYWxjdWxhdGVkIGJhc2VkIG9uIHRoZVxuXHRcdC8vIG5leHQgcG9zaXRpb25lZCBwYXJlbnRcblx0XHQvLyAyLiBUaGUgYWN0dWFsIG9mZnNldCBwYXJlbnQgaXMgYSBjaGlsZCBvZiB0aGUgc2Nyb2xsIHBhcmVudCwgYW5kIHRoZSBzY3JvbGwgcGFyZW50IGlzbid0XG5cdFx0Ly8gdGhlIGRvY3VtZW50LCB3aGljaCBtZWFucyB0aGF0IHRoZSBzY3JvbGwgaXMgaW5jbHVkZWQgaW4gdGhlIGluaXRpYWwgY2FsY3VsYXRpb24gb2YgdGhlXG5cdFx0Ly8gb2Zmc2V0IG9mIHRoZSBwYXJlbnQsIGFuZCBuZXZlciByZWNhbGN1bGF0ZWQgdXBvbiBkcmFnXG5cdFx0aWYgKCB0aGlzLmNzc1Bvc2l0aW9uID09PSBcImFic29sdXRlXCIgJiYgdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSAhPT0gdGhpcy5kb2N1bWVudFsgMCBdICYmXG5cdFx0XHRcdCQuY29udGFpbnMoIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0sIHRoaXMub2Zmc2V0UGFyZW50WyAwIF0gKSApIHtcblx0XHRcdHBvLmxlZnQgKz0gdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdCgpO1xuXHRcdFx0cG8udG9wICs9IHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbFRvcCgpO1xuXHRcdH1cblxuXHRcdC8vIFRoaXMgbmVlZHMgdG8gYmUgYWN0dWFsbHkgZG9uZSBmb3IgYWxsIGJyb3dzZXJzLCBzaW5jZSBwYWdlWC9wYWdlWSBpbmNsdWRlcyB0aGlzXG5cdFx0Ly8gaW5mb3JtYXRpb24gd2l0aCBhbiB1Z2x5IElFIGZpeFxuXHRcdGlmICggdGhpcy5vZmZzZXRQYXJlbnRbIDAgXSA9PT0gdGhpcy5kb2N1bWVudFsgMCBdLmJvZHkgfHxcblx0XHRcdFx0KCB0aGlzLm9mZnNldFBhcmVudFsgMCBdLnRhZ05hbWUgJiZcblx0XHRcdFx0dGhpcy5vZmZzZXRQYXJlbnRbIDAgXS50YWdOYW1lLnRvTG93ZXJDYXNlKCkgPT09IFwiaHRtbFwiICYmICQudWkuaWUgKSApIHtcblx0XHRcdHBvID0geyB0b3A6IDAsIGxlZnQ6IDAgfTtcblx0XHR9XG5cblx0XHRyZXR1cm4ge1xuXHRcdFx0dG9wOiBwby50b3AgKyAoIHBhcnNlSW50KCB0aGlzLm9mZnNldFBhcmVudC5jc3MoIFwiYm9yZGVyVG9wV2lkdGhcIiApLCAxMCApIHx8IDAgKSxcblx0XHRcdGxlZnQ6IHBvLmxlZnQgKyAoIHBhcnNlSW50KCB0aGlzLm9mZnNldFBhcmVudC5jc3MoIFwiYm9yZGVyTGVmdFdpZHRoXCIgKSwgMTAgKSB8fCAwIClcblx0XHR9O1xuXG5cdH0sXG5cblx0X2dldFJlbGF0aXZlT2Zmc2V0OiBmdW5jdGlvbigpIHtcblxuXHRcdGlmICggdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJyZWxhdGl2ZVwiICkge1xuXHRcdFx0dmFyIHAgPSB0aGlzLmN1cnJlbnRJdGVtLnBvc2l0aW9uKCk7XG5cdFx0XHRyZXR1cm4ge1xuXHRcdFx0XHR0b3A6IHAudG9wIC0gKCBwYXJzZUludCggdGhpcy5oZWxwZXIuY3NzKCBcInRvcFwiICksIDEwICkgfHwgMCApICtcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxUb3AoKSxcblx0XHRcdFx0bGVmdDogcC5sZWZ0IC0gKCBwYXJzZUludCggdGhpcy5oZWxwZXIuY3NzKCBcImxlZnRcIiApLCAxMCApIHx8IDAgKSArXG5cdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdCgpXG5cdFx0XHR9O1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRyZXR1cm4geyB0b3A6IDAsIGxlZnQ6IDAgfTtcblx0XHR9XG5cblx0fSxcblxuXHRfY2FjaGVNYXJnaW5zOiBmdW5jdGlvbigpIHtcblx0XHR0aGlzLm1hcmdpbnMgPSB7XG5cdFx0XHRsZWZ0OiAoIHBhcnNlSW50KCB0aGlzLmN1cnJlbnRJdGVtLmNzcyggXCJtYXJnaW5MZWZ0XCIgKSwgMTAgKSB8fCAwICksXG5cdFx0XHR0b3A6ICggcGFyc2VJbnQoIHRoaXMuY3VycmVudEl0ZW0uY3NzKCBcIm1hcmdpblRvcFwiICksIDEwICkgfHwgMCApXG5cdFx0fTtcblx0fSxcblxuXHRfY2FjaGVIZWxwZXJQcm9wb3J0aW9uczogZnVuY3Rpb24oKSB7XG5cdFx0dGhpcy5oZWxwZXJQcm9wb3J0aW9ucyA9IHtcblx0XHRcdHdpZHRoOiB0aGlzLmhlbHBlci5vdXRlcldpZHRoKCksXG5cdFx0XHRoZWlnaHQ6IHRoaXMuaGVscGVyLm91dGVySGVpZ2h0KClcblx0XHR9O1xuXHR9LFxuXG5cdF9zZXRDb250YWlubWVudDogZnVuY3Rpb24oKSB7XG5cblx0XHR2YXIgY2UsIGNvLCBvdmVyLFxuXHRcdFx0byA9IHRoaXMub3B0aW9ucztcblx0XHRpZiAoIG8uY29udGFpbm1lbnQgPT09IFwicGFyZW50XCIgKSB7XG5cdFx0XHRvLmNvbnRhaW5tZW50ID0gdGhpcy5oZWxwZXJbIDAgXS5wYXJlbnROb2RlO1xuXHRcdH1cblx0XHRpZiAoIG8uY29udGFpbm1lbnQgPT09IFwiZG9jdW1lbnRcIiB8fCBvLmNvbnRhaW5tZW50ID09PSBcIndpbmRvd1wiICkge1xuXHRcdFx0dGhpcy5jb250YWlubWVudCA9IFtcblx0XHRcdFx0MCAtIHRoaXMub2Zmc2V0LnJlbGF0aXZlLmxlZnQgLSB0aGlzLm9mZnNldC5wYXJlbnQubGVmdCxcblx0XHRcdFx0MCAtIHRoaXMub2Zmc2V0LnJlbGF0aXZlLnRvcCAtIHRoaXMub2Zmc2V0LnBhcmVudC50b3AsXG5cdFx0XHRcdG8uY29udGFpbm1lbnQgPT09IFwiZG9jdW1lbnRcIiA/XG5cdFx0XHRcdFx0dGhpcy5kb2N1bWVudC53aWR0aCgpIDpcblx0XHRcdFx0XHR0aGlzLndpbmRvdy53aWR0aCgpIC0gdGhpcy5oZWxwZXJQcm9wb3J0aW9ucy53aWR0aCAtIHRoaXMubWFyZ2lucy5sZWZ0LFxuXHRcdFx0XHQoIG8uY29udGFpbm1lbnQgPT09IFwiZG9jdW1lbnRcIiA/XG5cdFx0XHRcdFx0KCB0aGlzLmRvY3VtZW50LmhlaWdodCgpIHx8IGRvY3VtZW50LmJvZHkucGFyZW50Tm9kZS5zY3JvbGxIZWlnaHQgKSA6XG5cdFx0XHRcdFx0dGhpcy53aW5kb3cuaGVpZ2h0KCkgfHwgdGhpcy5kb2N1bWVudFsgMCBdLmJvZHkucGFyZW50Tm9kZS5zY3JvbGxIZWlnaHRcblx0XHRcdFx0KSAtIHRoaXMuaGVscGVyUHJvcG9ydGlvbnMuaGVpZ2h0IC0gdGhpcy5tYXJnaW5zLnRvcFxuXHRcdFx0XTtcblx0XHR9XG5cblx0XHRpZiAoICEoIC9eKGRvY3VtZW50fHdpbmRvd3xwYXJlbnQpJC8gKS50ZXN0KCBvLmNvbnRhaW5tZW50ICkgKSB7XG5cdFx0XHRjZSA9ICQoIG8uY29udGFpbm1lbnQgKVsgMCBdO1xuXHRcdFx0Y28gPSAkKCBvLmNvbnRhaW5tZW50ICkub2Zmc2V0KCk7XG5cdFx0XHRvdmVyID0gKCAkKCBjZSApLmNzcyggXCJvdmVyZmxvd1wiICkgIT09IFwiaGlkZGVuXCIgKTtcblxuXHRcdFx0dGhpcy5jb250YWlubWVudCA9IFtcblx0XHRcdFx0Y28ubGVmdCArICggcGFyc2VJbnQoICQoIGNlICkuY3NzKCBcImJvcmRlckxlZnRXaWR0aFwiICksIDEwICkgfHwgMCApICtcblx0XHRcdFx0XHQoIHBhcnNlSW50KCAkKCBjZSApLmNzcyggXCJwYWRkaW5nTGVmdFwiICksIDEwICkgfHwgMCApIC0gdGhpcy5tYXJnaW5zLmxlZnQsXG5cdFx0XHRcdGNvLnRvcCArICggcGFyc2VJbnQoICQoIGNlICkuY3NzKCBcImJvcmRlclRvcFdpZHRoXCIgKSwgMTAgKSB8fCAwICkgK1xuXHRcdFx0XHRcdCggcGFyc2VJbnQoICQoIGNlICkuY3NzKCBcInBhZGRpbmdUb3BcIiApLCAxMCApIHx8IDAgKSAtIHRoaXMubWFyZ2lucy50b3AsXG5cdFx0XHRcdGNvLmxlZnQgKyAoIG92ZXIgPyBNYXRoLm1heCggY2Uuc2Nyb2xsV2lkdGgsIGNlLm9mZnNldFdpZHRoICkgOiBjZS5vZmZzZXRXaWR0aCApIC1cblx0XHRcdFx0XHQoIHBhcnNlSW50KCAkKCBjZSApLmNzcyggXCJib3JkZXJMZWZ0V2lkdGhcIiApLCAxMCApIHx8IDAgKSAtXG5cdFx0XHRcdFx0KCBwYXJzZUludCggJCggY2UgKS5jc3MoIFwicGFkZGluZ1JpZ2h0XCIgKSwgMTAgKSB8fCAwICkgLVxuXHRcdFx0XHRcdHRoaXMuaGVscGVyUHJvcG9ydGlvbnMud2lkdGggLSB0aGlzLm1hcmdpbnMubGVmdCxcblx0XHRcdFx0Y28udG9wICsgKCBvdmVyID8gTWF0aC5tYXgoIGNlLnNjcm9sbEhlaWdodCwgY2Uub2Zmc2V0SGVpZ2h0ICkgOiBjZS5vZmZzZXRIZWlnaHQgKSAtXG5cdFx0XHRcdFx0KCBwYXJzZUludCggJCggY2UgKS5jc3MoIFwiYm9yZGVyVG9wV2lkdGhcIiApLCAxMCApIHx8IDAgKSAtXG5cdFx0XHRcdFx0KCBwYXJzZUludCggJCggY2UgKS5jc3MoIFwicGFkZGluZ0JvdHRvbVwiICksIDEwICkgfHwgMCApIC1cblx0XHRcdFx0XHR0aGlzLmhlbHBlclByb3BvcnRpb25zLmhlaWdodCAtIHRoaXMubWFyZ2lucy50b3Bcblx0XHRcdF07XG5cdFx0fVxuXG5cdH0sXG5cblx0X2NvbnZlcnRQb3NpdGlvblRvOiBmdW5jdGlvbiggZCwgcG9zICkge1xuXG5cdFx0aWYgKCAhcG9zICkge1xuXHRcdFx0cG9zID0gdGhpcy5wb3NpdGlvbjtcblx0XHR9XG5cdFx0dmFyIG1vZCA9IGQgPT09IFwiYWJzb2x1dGVcIiA/IDEgOiAtMSxcblx0XHRcdHNjcm9sbCA9IHRoaXMuY3NzUG9zaXRpb24gPT09IFwiYWJzb2x1dGVcIiAmJlxuXHRcdFx0XHQhKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdICE9PSB0aGlzLmRvY3VtZW50WyAwIF0gJiZcblx0XHRcdFx0JC5jb250YWlucyggdGhpcy5zY3JvbGxQYXJlbnRbIDAgXSwgdGhpcy5vZmZzZXRQYXJlbnRbIDAgXSApICkgP1xuXHRcdFx0XHRcdHRoaXMub2Zmc2V0UGFyZW50IDpcblx0XHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudCxcblx0XHRcdHNjcm9sbElzUm9vdE5vZGUgPSAoIC8oaHRtbHxib2R5KS9pICkudGVzdCggc2Nyb2xsWyAwIF0udGFnTmFtZSApO1xuXG5cdFx0cmV0dXJuIHtcblx0XHRcdHRvcDogKFxuXG5cdFx0XHRcdC8vIFRoZSBhYnNvbHV0ZSBtb3VzZSBwb3NpdGlvblxuXHRcdFx0XHRwb3MudG9wXHQrXG5cblx0XHRcdFx0Ly8gT25seSBmb3IgcmVsYXRpdmUgcG9zaXRpb25lZCBub2RlczogUmVsYXRpdmUgb2Zmc2V0IGZyb20gZWxlbWVudCB0byBvZmZzZXQgcGFyZW50XG5cdFx0XHRcdHRoaXMub2Zmc2V0LnJlbGF0aXZlLnRvcCAqIG1vZCArXG5cblx0XHRcdFx0Ly8gVGhlIG9mZnNldFBhcmVudCdzIG9mZnNldCB3aXRob3V0IGJvcmRlcnMgKG9mZnNldCArIGJvcmRlcilcblx0XHRcdFx0dGhpcy5vZmZzZXQucGFyZW50LnRvcCAqIG1vZCAtXG5cdFx0XHRcdCggKCB0aGlzLmNzc1Bvc2l0aW9uID09PSBcImZpeGVkXCIgP1xuXHRcdFx0XHRcdC10aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxUb3AoKSA6XG5cdFx0XHRcdFx0KCBzY3JvbGxJc1Jvb3ROb2RlID8gMCA6IHNjcm9sbC5zY3JvbGxUb3AoKSApICkgKiBtb2QgKVxuXHRcdFx0KSxcblx0XHRcdGxlZnQ6IChcblxuXHRcdFx0XHQvLyBUaGUgYWJzb2x1dGUgbW91c2UgcG9zaXRpb25cblx0XHRcdFx0cG9zLmxlZnQgK1xuXG5cdFx0XHRcdC8vIE9ubHkgZm9yIHJlbGF0aXZlIHBvc2l0aW9uZWQgbm9kZXM6IFJlbGF0aXZlIG9mZnNldCBmcm9tIGVsZW1lbnQgdG8gb2Zmc2V0IHBhcmVudFxuXHRcdFx0XHR0aGlzLm9mZnNldC5yZWxhdGl2ZS5sZWZ0ICogbW9kICtcblxuXHRcdFx0XHQvLyBUaGUgb2Zmc2V0UGFyZW50J3Mgb2Zmc2V0IHdpdGhvdXQgYm9yZGVycyAob2Zmc2V0ICsgYm9yZGVyKVxuXHRcdFx0XHR0aGlzLm9mZnNldC5wYXJlbnQubGVmdCAqIG1vZFx0LVxuXHRcdFx0XHQoICggdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJmaXhlZFwiID9cblx0XHRcdFx0XHQtdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdCgpIDogc2Nyb2xsSXNSb290Tm9kZSA/IDAgOlxuXHRcdFx0XHRcdHNjcm9sbC5zY3JvbGxMZWZ0KCkgKSAqIG1vZCApXG5cdFx0XHQpXG5cdFx0fTtcblxuXHR9LFxuXG5cdF9nZW5lcmF0ZVBvc2l0aW9uOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cblx0XHR2YXIgdG9wLCBsZWZ0LFxuXHRcdFx0byA9IHRoaXMub3B0aW9ucyxcblx0XHRcdHBhZ2VYID0gZXZlbnQucGFnZVgsXG5cdFx0XHRwYWdlWSA9IGV2ZW50LnBhZ2VZLFxuXHRcdFx0c2Nyb2xsID0gdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJhYnNvbHV0ZVwiICYmXG5cdFx0XHRcdCEoIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0gIT09IHRoaXMuZG9jdW1lbnRbIDAgXSAmJlxuXHRcdFx0XHQkLmNvbnRhaW5zKCB0aGlzLnNjcm9sbFBhcmVudFsgMCBdLCB0aGlzLm9mZnNldFBhcmVudFsgMCBdICkgKSA/XG5cdFx0XHRcdFx0dGhpcy5vZmZzZXRQYXJlbnQgOlxuXHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50LFxuXHRcdFx0XHRzY3JvbGxJc1Jvb3ROb2RlID0gKCAvKGh0bWx8Ym9keSkvaSApLnRlc3QoIHNjcm9sbFsgMCBdLnRhZ05hbWUgKTtcblxuXHRcdC8vIFRoaXMgaXMgYW5vdGhlciB2ZXJ5IHdlaXJkIHNwZWNpYWwgY2FzZSB0aGF0IG9ubHkgaGFwcGVucyBmb3IgcmVsYXRpdmUgZWxlbWVudHM6XG5cdFx0Ly8gMS4gSWYgdGhlIGNzcyBwb3NpdGlvbiBpcyByZWxhdGl2ZVxuXHRcdC8vIDIuIGFuZCB0aGUgc2Nyb2xsIHBhcmVudCBpcyB0aGUgZG9jdW1lbnQgb3Igc2ltaWxhciB0byB0aGUgb2Zmc2V0IHBhcmVudFxuXHRcdC8vIHdlIGhhdmUgdG8gcmVmcmVzaCB0aGUgcmVsYXRpdmUgb2Zmc2V0IGR1cmluZyB0aGUgc2Nyb2xsIHNvIHRoZXJlIGFyZSBubyBqdW1wc1xuXHRcdGlmICggdGhpcy5jc3NQb3NpdGlvbiA9PT0gXCJyZWxhdGl2ZVwiICYmICEoIHRoaXMuc2Nyb2xsUGFyZW50WyAwIF0gIT09IHRoaXMuZG9jdW1lbnRbIDAgXSAmJlxuXHRcdFx0XHR0aGlzLnNjcm9sbFBhcmVudFsgMCBdICE9PSB0aGlzLm9mZnNldFBhcmVudFsgMCBdICkgKSB7XG5cdFx0XHR0aGlzLm9mZnNldC5yZWxhdGl2ZSA9IHRoaXMuX2dldFJlbGF0aXZlT2Zmc2V0KCk7XG5cdFx0fVxuXG5cdFx0Lypcblx0XHQgKiAtIFBvc2l0aW9uIGNvbnN0cmFpbmluZyAtXG5cdFx0ICogQ29uc3RyYWluIHRoZSBwb3NpdGlvbiB0byBhIG1peCBvZiBncmlkLCBjb250YWlubWVudC5cblx0XHQgKi9cblxuXHRcdGlmICggdGhpcy5vcmlnaW5hbFBvc2l0aW9uICkgeyAvL0lmIHdlIGFyZSBub3QgZHJhZ2dpbmcgeWV0LCB3ZSB3b24ndCBjaGVjayBmb3Igb3B0aW9uc1xuXG5cdFx0XHRpZiAoIHRoaXMuY29udGFpbm1lbnQgKSB7XG5cdFx0XHRcdGlmICggZXZlbnQucGFnZVggLSB0aGlzLm9mZnNldC5jbGljay5sZWZ0IDwgdGhpcy5jb250YWlubWVudFsgMCBdICkge1xuXHRcdFx0XHRcdHBhZ2VYID0gdGhpcy5jb250YWlubWVudFsgMCBdICsgdGhpcy5vZmZzZXQuY2xpY2subGVmdDtcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoIGV2ZW50LnBhZ2VZIC0gdGhpcy5vZmZzZXQuY2xpY2sudG9wIDwgdGhpcy5jb250YWlubWVudFsgMSBdICkge1xuXHRcdFx0XHRcdHBhZ2VZID0gdGhpcy5jb250YWlubWVudFsgMSBdICsgdGhpcy5vZmZzZXQuY2xpY2sudG9wO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGlmICggZXZlbnQucGFnZVggLSB0aGlzLm9mZnNldC5jbGljay5sZWZ0ID4gdGhpcy5jb250YWlubWVudFsgMiBdICkge1xuXHRcdFx0XHRcdHBhZ2VYID0gdGhpcy5jb250YWlubWVudFsgMiBdICsgdGhpcy5vZmZzZXQuY2xpY2subGVmdDtcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoIGV2ZW50LnBhZ2VZIC0gdGhpcy5vZmZzZXQuY2xpY2sudG9wID4gdGhpcy5jb250YWlubWVudFsgMyBdICkge1xuXHRcdFx0XHRcdHBhZ2VZID0gdGhpcy5jb250YWlubWVudFsgMyBdICsgdGhpcy5vZmZzZXQuY2xpY2sudG9wO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdGlmICggby5ncmlkICkge1xuXHRcdFx0XHR0b3AgPSB0aGlzLm9yaWdpbmFsUGFnZVkgKyBNYXRoLnJvdW5kKCAoIHBhZ2VZIC0gdGhpcy5vcmlnaW5hbFBhZ2VZICkgL1xuXHRcdFx0XHRcdG8uZ3JpZFsgMSBdICkgKiBvLmdyaWRbIDEgXTtcblx0XHRcdFx0cGFnZVkgPSB0aGlzLmNvbnRhaW5tZW50ID9cblx0XHRcdFx0XHQoICggdG9wIC0gdGhpcy5vZmZzZXQuY2xpY2sudG9wID49IHRoaXMuY29udGFpbm1lbnRbIDEgXSAmJlxuXHRcdFx0XHRcdFx0dG9wIC0gdGhpcy5vZmZzZXQuY2xpY2sudG9wIDw9IHRoaXMuY29udGFpbm1lbnRbIDMgXSApID9cblx0XHRcdFx0XHRcdFx0dG9wIDpcblx0XHRcdFx0XHRcdFx0KCAoIHRvcCAtIHRoaXMub2Zmc2V0LmNsaWNrLnRvcCA+PSB0aGlzLmNvbnRhaW5tZW50WyAxIF0gKSA/XG5cdFx0XHRcdFx0XHRcdFx0dG9wIC0gby5ncmlkWyAxIF0gOiB0b3AgKyBvLmdyaWRbIDEgXSApICkgOlxuXHRcdFx0XHRcdFx0XHRcdHRvcDtcblxuXHRcdFx0XHRsZWZ0ID0gdGhpcy5vcmlnaW5hbFBhZ2VYICsgTWF0aC5yb3VuZCggKCBwYWdlWCAtIHRoaXMub3JpZ2luYWxQYWdlWCApIC9cblx0XHRcdFx0XHRvLmdyaWRbIDAgXSApICogby5ncmlkWyAwIF07XG5cdFx0XHRcdHBhZ2VYID0gdGhpcy5jb250YWlubWVudCA/XG5cdFx0XHRcdFx0KCAoIGxlZnQgLSB0aGlzLm9mZnNldC5jbGljay5sZWZ0ID49IHRoaXMuY29udGFpbm1lbnRbIDAgXSAmJlxuXHRcdFx0XHRcdFx0bGVmdCAtIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQgPD0gdGhpcy5jb250YWlubWVudFsgMiBdICkgP1xuXHRcdFx0XHRcdFx0XHRsZWZ0IDpcblx0XHRcdFx0XHRcdFx0KCAoIGxlZnQgLSB0aGlzLm9mZnNldC5jbGljay5sZWZ0ID49IHRoaXMuY29udGFpbm1lbnRbIDAgXSApID9cblx0XHRcdFx0XHRcdFx0XHRsZWZ0IC0gby5ncmlkWyAwIF0gOiBsZWZ0ICsgby5ncmlkWyAwIF0gKSApIDpcblx0XHRcdFx0XHRcdFx0XHRsZWZ0O1xuXHRcdFx0fVxuXG5cdFx0fVxuXG5cdFx0cmV0dXJuIHtcblx0XHRcdHRvcDogKFxuXG5cdFx0XHRcdC8vIFRoZSBhYnNvbHV0ZSBtb3VzZSBwb3NpdGlvblxuXHRcdFx0XHRwYWdlWSAtXG5cblx0XHRcdFx0Ly8gQ2xpY2sgb2Zmc2V0IChyZWxhdGl2ZSB0byB0aGUgZWxlbWVudClcblx0XHRcdFx0dGhpcy5vZmZzZXQuY2xpY2sudG9wIC1cblxuXHRcdFx0XHQvLyBPbmx5IGZvciByZWxhdGl2ZSBwb3NpdGlvbmVkIG5vZGVzOiBSZWxhdGl2ZSBvZmZzZXQgZnJvbSBlbGVtZW50IHRvIG9mZnNldCBwYXJlbnRcblx0XHRcdFx0dGhpcy5vZmZzZXQucmVsYXRpdmUudG9wIC1cblxuXHRcdFx0XHQvLyBUaGUgb2Zmc2V0UGFyZW50J3Mgb2Zmc2V0IHdpdGhvdXQgYm9yZGVycyAob2Zmc2V0ICsgYm9yZGVyKVxuXHRcdFx0XHR0aGlzLm9mZnNldC5wYXJlbnQudG9wICtcblx0XHRcdFx0KCAoIHRoaXMuY3NzUG9zaXRpb24gPT09IFwiZml4ZWRcIiA/XG5cdFx0XHRcdFx0LXRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbFRvcCgpIDpcblx0XHRcdFx0XHQoIHNjcm9sbElzUm9vdE5vZGUgPyAwIDogc2Nyb2xsLnNjcm9sbFRvcCgpICkgKSApXG5cdFx0XHQpLFxuXHRcdFx0bGVmdDogKFxuXG5cdFx0XHRcdC8vIFRoZSBhYnNvbHV0ZSBtb3VzZSBwb3NpdGlvblxuXHRcdFx0XHRwYWdlWCAtXG5cblx0XHRcdFx0Ly8gQ2xpY2sgb2Zmc2V0IChyZWxhdGl2ZSB0byB0aGUgZWxlbWVudClcblx0XHRcdFx0dGhpcy5vZmZzZXQuY2xpY2subGVmdCAtXG5cblx0XHRcdFx0Ly8gT25seSBmb3IgcmVsYXRpdmUgcG9zaXRpb25lZCBub2RlczogUmVsYXRpdmUgb2Zmc2V0IGZyb20gZWxlbWVudCB0byBvZmZzZXQgcGFyZW50XG5cdFx0XHRcdHRoaXMub2Zmc2V0LnJlbGF0aXZlLmxlZnQgLVxuXG5cdFx0XHRcdC8vIFRoZSBvZmZzZXRQYXJlbnQncyBvZmZzZXQgd2l0aG91dCBib3JkZXJzIChvZmZzZXQgKyBib3JkZXIpXG5cdFx0XHRcdHRoaXMub2Zmc2V0LnBhcmVudC5sZWZ0ICtcblx0XHRcdFx0KCAoIHRoaXMuY3NzUG9zaXRpb24gPT09IFwiZml4ZWRcIiA/XG5cdFx0XHRcdFx0LXRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbExlZnQoKSA6XG5cdFx0XHRcdFx0c2Nyb2xsSXNSb290Tm9kZSA/IDAgOiBzY3JvbGwuc2Nyb2xsTGVmdCgpICkgKVxuXHRcdFx0KVxuXHRcdH07XG5cblx0fSxcblxuXHRfcmVhcnJhbmdlOiBmdW5jdGlvbiggZXZlbnQsIGksIGEsIGhhcmRSZWZyZXNoICkge1xuXG5cdFx0aWYgKCBhICkge1xuXHRcdFx0YVsgMCBdLmFwcGVuZENoaWxkKCB0aGlzLnBsYWNlaG9sZGVyWyAwIF0gKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0aS5pdGVtWyAwIF0ucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUoIHRoaXMucGxhY2Vob2xkZXJbIDAgXSxcblx0XHRcdFx0KCB0aGlzLmRpcmVjdGlvbiA9PT0gXCJkb3duXCIgPyBpLml0ZW1bIDAgXSA6IGkuaXRlbVsgMCBdLm5leHRTaWJsaW5nICkgKTtcblx0XHR9XG5cblx0XHQvL1ZhcmlvdXMgdGhpbmdzIGRvbmUgaGVyZSB0byBpbXByb3ZlIHRoZSBwZXJmb3JtYW5jZTpcblx0XHQvLyAxLiB3ZSBjcmVhdGUgYSBzZXRUaW1lb3V0LCB0aGF0IGNhbGxzIHJlZnJlc2hQb3NpdGlvbnNcblx0XHQvLyAyLiBvbiB0aGUgaW5zdGFuY2UsIHdlIGhhdmUgYSBjb3VudGVyIHZhcmlhYmxlLCB0aGF0IGdldCdzIGhpZ2hlciBhZnRlciBldmVyeSBhcHBlbmRcblx0XHQvLyAzLiBvbiB0aGUgbG9jYWwgc2NvcGUsIHdlIGNvcHkgdGhlIGNvdW50ZXIgdmFyaWFibGUsIGFuZCBjaGVjayBpbiB0aGUgdGltZW91dCxcblx0XHQvLyBpZiBpdCdzIHN0aWxsIHRoZSBzYW1lXG5cdFx0Ly8gNC4gdGhpcyBsZXRzIG9ubHkgdGhlIGxhc3QgYWRkaXRpb24gdG8gdGhlIHRpbWVvdXQgc3RhY2sgdGhyb3VnaFxuXHRcdHRoaXMuY291bnRlciA9IHRoaXMuY291bnRlciA/ICsrdGhpcy5jb3VudGVyIDogMTtcblx0XHR2YXIgY291bnRlciA9IHRoaXMuY291bnRlcjtcblxuXHRcdHRoaXMuX2RlbGF5KCBmdW5jdGlvbigpIHtcblx0XHRcdGlmICggY291bnRlciA9PT0gdGhpcy5jb3VudGVyICkge1xuXG5cdFx0XHRcdC8vUHJlY29tcHV0ZSBhZnRlciBlYWNoIERPTSBpbnNlcnRpb24sIE5PVCBvbiBtb3VzZW1vdmVcblx0XHRcdFx0dGhpcy5yZWZyZXNoUG9zaXRpb25zKCAhaGFyZFJlZnJlc2ggKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cblx0fSxcblxuXHRfY2xlYXI6IGZ1bmN0aW9uKCBldmVudCwgbm9Qcm9wYWdhdGlvbiApIHtcblxuXHRcdHRoaXMucmV2ZXJ0aW5nID0gZmFsc2U7XG5cblx0XHQvLyBXZSBkZWxheSBhbGwgZXZlbnRzIHRoYXQgaGF2ZSB0byBiZSB0cmlnZ2VyZWQgdG8gYWZ0ZXIgdGhlIHBvaW50IHdoZXJlIHRoZSBwbGFjZWhvbGRlclxuXHRcdC8vIGhhcyBiZWVuIHJlbW92ZWQgYW5kIGV2ZXJ5dGhpbmcgZWxzZSBub3JtYWxpemVkIGFnYWluXG5cdFx0dmFyIGksXG5cdFx0XHRkZWxheWVkVHJpZ2dlcnMgPSBbXTtcblxuXHRcdC8vIFdlIGZpcnN0IGhhdmUgdG8gdXBkYXRlIHRoZSBkb20gcG9zaXRpb24gb2YgdGhlIGFjdHVhbCBjdXJyZW50SXRlbVxuXHRcdC8vIE5vdGU6IGRvbid0IGRvIGl0IGlmIHRoZSBjdXJyZW50IGl0ZW0gaXMgYWxyZWFkeSByZW1vdmVkIChieSBhIHVzZXIpLCBvciBpdCBnZXRzXG5cdFx0Ly8gcmVhcHBlbmRlZCAoc2VlICM0MDg4KVxuXHRcdGlmICggIXRoaXMuX25vRmluYWxTb3J0ICYmIHRoaXMuY3VycmVudEl0ZW0ucGFyZW50KCkubGVuZ3RoICkge1xuXHRcdFx0dGhpcy5wbGFjZWhvbGRlci5iZWZvcmUoIHRoaXMuY3VycmVudEl0ZW0gKTtcblx0XHR9XG5cdFx0dGhpcy5fbm9GaW5hbFNvcnQgPSBudWxsO1xuXG5cdFx0aWYgKCB0aGlzLmhlbHBlclsgMCBdID09PSB0aGlzLmN1cnJlbnRJdGVtWyAwIF0gKSB7XG5cdFx0XHRmb3IgKCBpIGluIHRoaXMuX3N0b3JlZENTUyApIHtcblx0XHRcdFx0aWYgKCB0aGlzLl9zdG9yZWRDU1NbIGkgXSA9PT0gXCJhdXRvXCIgfHwgdGhpcy5fc3RvcmVkQ1NTWyBpIF0gPT09IFwic3RhdGljXCIgKSB7XG5cdFx0XHRcdFx0dGhpcy5fc3RvcmVkQ1NTWyBpIF0gPSBcIlwiO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XHR0aGlzLmN1cnJlbnRJdGVtLmNzcyggdGhpcy5fc3RvcmVkQ1NTICk7XG5cdFx0XHR0aGlzLl9yZW1vdmVDbGFzcyggdGhpcy5jdXJyZW50SXRlbSwgXCJ1aS1zb3J0YWJsZS1oZWxwZXJcIiApO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHR0aGlzLmN1cnJlbnRJdGVtLnNob3coKTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMuZnJvbU91dHNpZGUgJiYgIW5vUHJvcGFnYXRpb24gKSB7XG5cdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKCBcInJlY2VpdmVcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCggdGhpcy5mcm9tT3V0c2lkZSApICk7XG5cdFx0XHR9ICk7XG5cdFx0fVxuXHRcdGlmICggKCB0aGlzLmZyb21PdXRzaWRlIHx8XG5cdFx0XHRcdHRoaXMuZG9tUG9zaXRpb24ucHJldiAhPT1cblx0XHRcdFx0dGhpcy5jdXJyZW50SXRlbS5wcmV2KCkubm90KCBcIi51aS1zb3J0YWJsZS1oZWxwZXJcIiApWyAwIF0gfHxcblx0XHRcdFx0dGhpcy5kb21Qb3NpdGlvbi5wYXJlbnQgIT09IHRoaXMuY3VycmVudEl0ZW0ucGFyZW50KClbIDAgXSApICYmICFub1Byb3BhZ2F0aW9uICkge1xuXG5cdFx0XHQvLyBUcmlnZ2VyIHVwZGF0ZSBjYWxsYmFjayBpZiB0aGUgRE9NIHBvc2l0aW9uIGhhcyBjaGFuZ2VkXG5cdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKCBcInVwZGF0ZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHQvLyBDaGVjayBpZiB0aGUgaXRlbXMgQ29udGFpbmVyIGhhcyBDaGFuZ2VkIGFuZCB0cmlnZ2VyIGFwcHJvcHJpYXRlXG5cdFx0Ly8gZXZlbnRzLlxuXHRcdGlmICggdGhpcyAhPT0gdGhpcy5jdXJyZW50Q29udGFpbmVyICkge1xuXHRcdFx0aWYgKCAhbm9Qcm9wYWdhdGlvbiApIHtcblx0XHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0XHR0aGlzLl90cmlnZ2VyKCBcInJlbW92ZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkgKTtcblx0XHRcdFx0fSApO1xuXHRcdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggKCBmdW5jdGlvbiggYyApIHtcblx0XHRcdFx0XHRyZXR1cm4gZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHRcdFx0Yy5fdHJpZ2dlciggXCJyZWNlaXZlXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goIHRoaXMgKSApO1xuXHRcdFx0XHRcdH07XG5cdFx0XHRcdH0gKS5jYWxsKCB0aGlzLCB0aGlzLmN1cnJlbnRDb250YWluZXIgKSApO1xuXHRcdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggKCBmdW5jdGlvbiggYyApIHtcblx0XHRcdFx0XHRyZXR1cm4gZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHRcdFx0Yy5fdHJpZ2dlciggXCJ1cGRhdGVcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCggdGhpcyApICk7XG5cdFx0XHRcdFx0fTtcblx0XHRcdFx0fSApLmNhbGwoIHRoaXMsIHRoaXMuY3VycmVudENvbnRhaW5lciApICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly9Qb3N0IGV2ZW50cyB0byBjb250YWluZXJzXG5cdFx0ZnVuY3Rpb24gZGVsYXlFdmVudCggdHlwZSwgaW5zdGFuY2UsIGNvbnRhaW5lciApIHtcblx0XHRcdHJldHVybiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdGNvbnRhaW5lci5fdHJpZ2dlciggdHlwZSwgZXZlbnQsIGluc3RhbmNlLl91aUhhc2goIGluc3RhbmNlICkgKTtcblx0XHRcdH07XG5cdFx0fVxuXHRcdGZvciAoIGkgPSB0aGlzLmNvbnRhaW5lcnMubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0gKSB7XG5cdFx0XHRpZiAoICFub1Byb3BhZ2F0aW9uICkge1xuXHRcdFx0XHRkZWxheWVkVHJpZ2dlcnMucHVzaCggZGVsYXlFdmVudCggXCJkZWFjdGl2YXRlXCIsIHRoaXMsIHRoaXMuY29udGFpbmVyc1sgaSBdICkgKTtcblx0XHRcdH1cblx0XHRcdGlmICggdGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUub3ZlciApIHtcblx0XHRcdFx0ZGVsYXllZFRyaWdnZXJzLnB1c2goIGRlbGF5RXZlbnQoIFwib3V0XCIsIHRoaXMsIHRoaXMuY29udGFpbmVyc1sgaSBdICkgKTtcblx0XHRcdFx0dGhpcy5jb250YWluZXJzWyBpIF0uY29udGFpbmVyQ2FjaGUub3ZlciA9IDA7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly9EbyB3aGF0IHdhcyBvcmlnaW5hbGx5IGluIHBsdWdpbnNcblx0XHRpZiAoIHRoaXMuc3RvcmVkQ3Vyc29yICkge1xuXHRcdFx0dGhpcy5kb2N1bWVudC5maW5kKCBcImJvZHlcIiApLmNzcyggXCJjdXJzb3JcIiwgdGhpcy5zdG9yZWRDdXJzb3IgKTtcblx0XHRcdHRoaXMuc3RvcmVkU3R5bGVzaGVldC5yZW1vdmUoKTtcblx0XHR9XG5cdFx0aWYgKCB0aGlzLl9zdG9yZWRPcGFjaXR5ICkge1xuXHRcdFx0dGhpcy5oZWxwZXIuY3NzKCBcIm9wYWNpdHlcIiwgdGhpcy5fc3RvcmVkT3BhY2l0eSApO1xuXHRcdH1cblx0XHRpZiAoIHRoaXMuX3N0b3JlZFpJbmRleCApIHtcblx0XHRcdHRoaXMuaGVscGVyLmNzcyggXCJ6SW5kZXhcIiwgdGhpcy5fc3RvcmVkWkluZGV4ID09PSBcImF1dG9cIiA/IFwiXCIgOiB0aGlzLl9zdG9yZWRaSW5kZXggKTtcblx0XHR9XG5cblx0XHR0aGlzLmRyYWdnaW5nID0gZmFsc2U7XG5cblx0XHRpZiAoICFub1Byb3BhZ2F0aW9uICkge1xuXHRcdFx0dGhpcy5fdHJpZ2dlciggXCJiZWZvcmVTdG9wXCIsIGV2ZW50LCB0aGlzLl91aUhhc2goKSApO1xuXHRcdH1cblxuXHRcdC8vJCh0aGlzLnBsYWNlaG9sZGVyWzBdKS5yZW1vdmUoKTsgd291bGQgaGF2ZSBiZWVuIHRoZSBqUXVlcnkgd2F5IC0gdW5mb3J0dW5hdGVseSxcblx0XHQvLyBpdCB1bmJpbmRzIEFMTCBldmVudHMgZnJvbSB0aGUgb3JpZ2luYWwgbm9kZSFcblx0XHR0aGlzLnBsYWNlaG9sZGVyWyAwIF0ucGFyZW50Tm9kZS5yZW1vdmVDaGlsZCggdGhpcy5wbGFjZWhvbGRlclsgMCBdICk7XG5cblx0XHRpZiAoICF0aGlzLmNhbmNlbEhlbHBlclJlbW92YWwgKSB7XG5cdFx0XHRpZiAoIHRoaXMuaGVscGVyWyAwIF0gIT09IHRoaXMuY3VycmVudEl0ZW1bIDAgXSApIHtcblx0XHRcdFx0dGhpcy5oZWxwZXIucmVtb3ZlKCk7XG5cdFx0XHR9XG5cdFx0XHR0aGlzLmhlbHBlciA9IG51bGw7XG5cdFx0fVxuXG5cdFx0aWYgKCAhbm9Qcm9wYWdhdGlvbiApIHtcblx0XHRcdGZvciAoIGkgPSAwOyBpIDwgZGVsYXllZFRyaWdnZXJzLmxlbmd0aDsgaSsrICkge1xuXG5cdFx0XHRcdC8vIFRyaWdnZXIgYWxsIGRlbGF5ZWQgZXZlbnRzXG5cdFx0XHRcdGRlbGF5ZWRUcmlnZ2Vyc1sgaSBdLmNhbGwoIHRoaXMsIGV2ZW50ICk7XG5cdFx0XHR9XG5cdFx0XHR0aGlzLl90cmlnZ2VyKCBcInN0b3BcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpICk7XG5cdFx0fVxuXG5cdFx0dGhpcy5mcm9tT3V0c2lkZSA9IGZhbHNlO1xuXHRcdHJldHVybiAhdGhpcy5jYW5jZWxIZWxwZXJSZW1vdmFsO1xuXG5cdH0sXG5cblx0X3RyaWdnZXI6IGZ1bmN0aW9uKCkge1xuXHRcdGlmICggJC5XaWRnZXQucHJvdG90eXBlLl90cmlnZ2VyLmFwcGx5KCB0aGlzLCBhcmd1bWVudHMgKSA9PT0gZmFsc2UgKSB7XG5cdFx0XHR0aGlzLmNhbmNlbCgpO1xuXHRcdH1cblx0fSxcblxuXHRfdWlIYXNoOiBmdW5jdGlvbiggX2luc3QgKSB7XG5cdFx0dmFyIGluc3QgPSBfaW5zdCB8fCB0aGlzO1xuXHRcdHJldHVybiB7XG5cdFx0XHRoZWxwZXI6IGluc3QuaGVscGVyLFxuXHRcdFx0cGxhY2Vob2xkZXI6IGluc3QucGxhY2Vob2xkZXIgfHwgJCggW10gKSxcblx0XHRcdHBvc2l0aW9uOiBpbnN0LnBvc2l0aW9uLFxuXHRcdFx0b3JpZ2luYWxQb3NpdGlvbjogaW5zdC5vcmlnaW5hbFBvc2l0aW9uLFxuXHRcdFx0b2Zmc2V0OiBpbnN0LnBvc2l0aW9uQWJzLFxuXHRcdFx0aXRlbTogaW5zdC5jdXJyZW50SXRlbSxcblx0XHRcdHNlbmRlcjogX2luc3QgPyBfaW5zdC5lbGVtZW50IDogbnVsbFxuXHRcdH07XG5cdH1cblxufSApO1xuXG59ICk7XG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE5KTsiLCIvKlxuICogalF1ZXJ5IFVJIE5lc3RlZCBTb3J0YWJsZVxuICogdiAyLjFhIC8gMjAxNi0wMi0wNFxuICogaHR0cHM6Ly9naXRodWIuY29tL2lsaWtlbndmL25lc3RlZFNvcnRhYmxlXG4gKlxuICogRGVwZW5kcyBvbjpcbiAqXHQganF1ZXJ5LnVpLnNvcnRhYmxlLmpzIDEuMTArXG4gKlxuICogQ29weXJpZ2h0IChjKSAyMDEwLTIwMTYgTWFudWVsZSBKIFNhcmZhdHRpIGFuZCBjb250cmlidXRvcnNcbiAqIExpY2Vuc2VkIHVuZGVyIHRoZSBNSVQgTGljZW5zZVxuICogaHR0cDovL3d3dy5vcGVuc291cmNlLm9yZy9saWNlbnNlcy9taXQtbGljZW5zZS5waHBcbiAqL1xuKGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRcInVzZSBzdHJpY3RcIjtcblxuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZShbXG5cdFx0XHRcImpxdWVyeVwiLFxuXHRcdFx0XCJqcXVlcnktdWkvc29ydGFibGVcIlxuXHRcdF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIHdpbmRvdy5qUXVlcnkgKTtcblx0fVxufShmdW5jdGlvbigkKSB7XG5cdFwidXNlIHN0cmljdFwiO1xuXG5cdGZ1bmN0aW9uIGlzT3ZlckF4aXMoIHgsIHJlZmVyZW5jZSwgc2l6ZSApIHtcblx0XHRyZXR1cm4gKCB4ID4gcmVmZXJlbmNlICkgJiYgKCB4IDwgKCByZWZlcmVuY2UgKyBzaXplICkgKTtcblx0fVxuXG5cdCQud2lkZ2V0KFwibWpzLm5lc3RlZFNvcnRhYmxlXCIsICQuZXh0ZW5kKHt9LCAkLnVpLnNvcnRhYmxlLnByb3RvdHlwZSwge1xuXG5cdFx0b3B0aW9uczoge1xuXHRcdFx0ZGlzYWJsZVBhcmVudENoYW5nZTogZmFsc2UsXG5cdFx0XHRkb05vdENsZWFyOiBmYWxzZSxcblx0XHRcdGV4cGFuZE9uSG92ZXI6IDcwMCxcblx0XHRcdGlzQWxsb3dlZDogZnVuY3Rpb24oKSB7IHJldHVybiB0cnVlOyB9LFxuXHRcdFx0aXNUcmVlOiBmYWxzZSxcblx0XHRcdGxpc3RUeXBlOiBcIm9sXCIsXG5cdFx0XHRtYXhMZXZlbHM6IDAsXG5cdFx0XHRwcm90ZWN0Um9vdDogZmFsc2UsXG5cdFx0XHRyb290SUQ6IG51bGwsXG5cdFx0XHRydGw6IGZhbHNlLFxuXHRcdFx0c3RhcnRDb2xsYXBzZWQ6IGZhbHNlLFxuXHRcdFx0dGFiU2l6ZTogMjAsXG5cblx0XHRcdGJyYW5jaENsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1icmFuY2hcIixcblx0XHRcdGNvbGxhcHNlZENsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1jb2xsYXBzZWRcIixcblx0XHRcdGRpc2FibGVOZXN0aW5nQ2xhc3M6IFwibWpzLW5lc3RlZFNvcnRhYmxlLW5vLW5lc3RpbmdcIixcblx0XHRcdGVycm9yQ2xhc3M6IFwibWpzLW5lc3RlZFNvcnRhYmxlLWVycm9yXCIsXG5cdFx0XHRleHBhbmRlZENsYXNzOiBcIm1qcy1uZXN0ZWRTb3J0YWJsZS1leHBhbmRlZFwiLFxuXHRcdFx0aG92ZXJpbmdDbGFzczogXCJtanMtbmVzdGVkU29ydGFibGUtaG92ZXJpbmdcIixcblx0XHRcdGxlYWZDbGFzczogXCJtanMtbmVzdGVkU29ydGFibGUtbGVhZlwiLFxuXHRcdFx0ZGlzYWJsZWRDbGFzczogXCJtanMtbmVzdGVkU29ydGFibGUtZGlzYWJsZWRcIlxuXHRcdH0sXG5cblx0XHRfY3JlYXRlOiBmdW5jdGlvbigpIHtcblx0XHRcdHZhciBzZWxmID0gdGhpcyxcblx0XHRcdFx0ZXJyO1xuXG5cdFx0XHR0aGlzLmVsZW1lbnQuZGF0YShcInVpLXNvcnRhYmxlXCIsIHRoaXMuZWxlbWVudC5kYXRhKFwibWpzLW5lc3RlZFNvcnRhYmxlXCIpKTtcblxuXHRcdFx0Ly8gbWpzIC0gcHJldmVudCBicm93c2VyIGZyb20gZnJlZXppbmcgaWYgdGhlIEhUTUwgaXMgbm90IGNvcnJlY3Rcblx0XHRcdGlmICghdGhpcy5lbGVtZW50LmlzKHRoaXMub3B0aW9ucy5saXN0VHlwZSkpIHtcblx0XHRcdFx0ZXJyID0gXCJuZXN0ZWRTb3J0YWJsZTogXCIgK1xuXHRcdFx0XHRcdFwiUGxlYXNlIGNoZWNrIHRoYXQgdGhlIGxpc3RUeXBlIG9wdGlvbiBpcyBzZXQgdG8geW91ciBhY3R1YWwgbGlzdCB0eXBlXCI7XG5cblx0XHRcdFx0dGhyb3cgbmV3IEVycm9yKGVycik7XG5cdFx0XHR9XG5cblx0XHRcdC8vIGlmIHdlIGhhdmUgYSB0cmVlIHdpdGggZXhwYW5kaW5nL2NvbGxhcHNpbmcgZnVuY3Rpb25hbGl0eSxcblx0XHRcdC8vIGZvcmNlICdpbnRlcnNlY3QnIHRvbGVyYW5jZSBtZXRob2Rcblx0XHRcdGlmICh0aGlzLm9wdGlvbnMuaXNUcmVlICYmIHRoaXMub3B0aW9ucy5leHBhbmRPbkhvdmVyKSB7XG5cdFx0XHRcdHRoaXMub3B0aW9ucy50b2xlcmFuY2UgPSBcImludGVyc2VjdFwiO1xuXHRcdFx0fVxuXG5cdFx0XHQkLnVpLnNvcnRhYmxlLnByb3RvdHlwZS5fY3JlYXRlLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG5cblx0XHRcdC8vIHByZXBhcmUgdGhlIHRyZWUgYnkgYXBwbHlpbmcgdGhlIHJpZ2h0IGNsYXNzZXNcblx0XHRcdC8vICh0aGUgQ1NTIGlzIHJlc3BvbnNpYmxlIGZvciBhY3R1YWwgaGlkZS9zaG93IGZ1bmN0aW9uYWxpdHkpXG5cdFx0XHRpZiAodGhpcy5vcHRpb25zLmlzVHJlZSkge1xuXHRcdFx0XHQkKHRoaXMuaXRlbXMpLmVhY2goZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0dmFyICRsaSA9IHRoaXMuaXRlbSxcblx0XHRcdFx0XHRcdGhhc0NvbGxhcHNlZENsYXNzID0gJGxpLmhhc0NsYXNzKHNlbGYub3B0aW9ucy5jb2xsYXBzZWRDbGFzcyksXG5cdFx0XHRcdFx0XHRoYXNFeHBhbmRlZENsYXNzID0gJGxpLmhhc0NsYXNzKHNlbGYub3B0aW9ucy5leHBhbmRlZENsYXNzKTtcblxuXHRcdFx0XHRcdGlmICgkbGkuY2hpbGRyZW4oc2VsZi5vcHRpb25zLmxpc3RUeXBlKS5sZW5ndGgpIHtcblx0XHRcdFx0XHRcdCRsaS5hZGRDbGFzcyhzZWxmLm9wdGlvbnMuYnJhbmNoQ2xhc3MpO1xuXHRcdFx0XHRcdFx0Ly8gZXhwYW5kL2NvbGxhcHNlIGNsYXNzIG9ubHkgaWYgdGhleSBoYXZlIGNoaWxkcmVuXG5cblx0XHRcdFx0XHRcdGlmICggIWhhc0NvbGxhcHNlZENsYXNzICYmICFoYXNFeHBhbmRlZENsYXNzICkge1xuXHRcdFx0XHRcdFx0XHRpZiAoc2VsZi5vcHRpb25zLnN0YXJ0Q29sbGFwc2VkKSB7XG5cdFx0XHRcdFx0XHRcdFx0JGxpLmFkZENsYXNzKHNlbGYub3B0aW9ucy5jb2xsYXBzZWRDbGFzcyk7XG5cdFx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdFx0JGxpLmFkZENsYXNzKHNlbGYub3B0aW9ucy5leHBhbmRlZENsYXNzKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHQkbGkuYWRkQ2xhc3Moc2VsZi5vcHRpb25zLmxlYWZDbGFzcyk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9KTtcblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0X2Rlc3Ryb3k6IGZ1bmN0aW9uKCkge1xuXHRcdFx0dGhpcy5lbGVtZW50XG5cdFx0XHRcdC5yZW1vdmVEYXRhKFwibWpzLW5lc3RlZFNvcnRhYmxlXCIpXG5cdFx0XHRcdC5yZW1vdmVEYXRhKFwidWktc29ydGFibGVcIik7XG5cdFx0XHRyZXR1cm4gJC51aS5zb3J0YWJsZS5wcm90b3R5cGUuX2Rlc3Ryb3kuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcblx0XHR9LFxuXG5cdFx0X21vdXNlRHJhZzogZnVuY3Rpb24oZXZlbnQpIHtcblx0XHRcdHZhciBpLFxuXHRcdFx0XHRpdGVtLFxuXHRcdFx0XHRpdGVtRWxlbWVudCxcblx0XHRcdFx0aW50ZXJzZWN0aW9uLFxuXHRcdFx0XHRzZWxmID0gdGhpcyxcblx0XHRcdFx0byA9IHRoaXMub3B0aW9ucyxcblx0XHRcdFx0c2Nyb2xsZWQgPSBmYWxzZSxcblx0XHRcdFx0JGRvY3VtZW50ID0gJChkb2N1bWVudCksXG5cdFx0XHRcdHByZXZpb3VzVG9wT2Zmc2V0LFxuXHRcdFx0XHRwYXJlbnRJdGVtLFxuXHRcdFx0XHRsZXZlbCxcblx0XHRcdFx0Y2hpbGRMZXZlbHMsXG5cdFx0XHRcdGl0ZW1BZnRlcixcblx0XHRcdFx0aXRlbUJlZm9yZSxcblx0XHRcdFx0bmV3TGlzdCxcblx0XHRcdFx0bWV0aG9kLFxuXHRcdFx0XHRhLFxuXHRcdFx0XHRwcmV2aW91c0l0ZW0sXG5cdFx0XHRcdG5leHRJdGVtLFxuXHRcdFx0XHRoZWxwZXJJc05vdFNpYmxpbmc7XG5cblx0XHRcdC8vQ29tcHV0ZSB0aGUgaGVscGVycyBwb3NpdGlvblxuXHRcdFx0dGhpcy5wb3NpdGlvbiA9IHRoaXMuX2dlbmVyYXRlUG9zaXRpb24oZXZlbnQpO1xuXHRcdFx0dGhpcy5wb3NpdGlvbkFicyA9IHRoaXMuX2NvbnZlcnRQb3NpdGlvblRvKFwiYWJzb2x1dGVcIik7XG5cblx0XHRcdGlmICghdGhpcy5sYXN0UG9zaXRpb25BYnMpIHtcblx0XHRcdFx0dGhpcy5sYXN0UG9zaXRpb25BYnMgPSB0aGlzLnBvc2l0aW9uQWJzO1xuXHRcdFx0fVxuXG5cdFx0XHQvL0RvIHNjcm9sbGluZ1xuXHRcdFx0aWYgKHRoaXMub3B0aW9ucy5zY3JvbGwpIHtcblx0XHRcdFx0aWYgKHRoaXMuc2Nyb2xsUGFyZW50WzBdICE9PSBkb2N1bWVudCAmJiB0aGlzLnNjcm9sbFBhcmVudFswXS50YWdOYW1lICE9PSBcIkhUTUxcIikge1xuXG5cdFx0XHRcdFx0aWYgKFxuXHRcdFx0XHRcdFx0KFxuXHRcdFx0XHRcdFx0XHR0aGlzLm92ZXJmbG93T2Zmc2V0LnRvcCArXG5cdFx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WzBdLm9mZnNldEhlaWdodFxuXHRcdFx0XHRcdFx0KSAtXG5cdFx0XHRcdFx0XHRldmVudC5wYWdlWSA8XG5cdFx0XHRcdFx0XHRvLnNjcm9sbFNlbnNpdGl2aXR5XG5cdFx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0XHRzY3JvbGxlZCA9IHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbFRvcCgpICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbFRvcChzY3JvbGxlZCk7XG5cdFx0XHRcdFx0fSBlbHNlIGlmIChcblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VZIC1cblx0XHRcdFx0XHRcdHRoaXMub3ZlcmZsb3dPZmZzZXQudG9wIDxcblx0XHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHlcblx0XHRcdFx0XHQpIHtcblx0XHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKCkgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsVG9wKHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRpZiAoXG5cdFx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHRcdHRoaXMub3ZlcmZsb3dPZmZzZXQubGVmdCArXG5cdFx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50WzBdLm9mZnNldFdpZHRoXG5cdFx0XHRcdFx0XHQpIC1cblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VYIDxcblx0XHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHlcblx0XHRcdFx0XHQpIHtcblx0XHRcdFx0XHRcdHNjcm9sbGVkID0gdGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdCgpICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdHRoaXMuc2Nyb2xsUGFyZW50LnNjcm9sbExlZnQoc2Nyb2xsZWQpO1xuXHRcdFx0XHRcdH0gZWxzZSBpZiAoXG5cdFx0XHRcdFx0XHRldmVudC5wYWdlWCAtXG5cdFx0XHRcdFx0XHR0aGlzLm92ZXJmbG93T2Zmc2V0LmxlZnQgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSB0aGlzLnNjcm9sbFBhcmVudC5zY3JvbGxMZWZ0KCkgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0dGhpcy5zY3JvbGxQYXJlbnQuc2Nyb2xsTGVmdChzY3JvbGxlZCk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdH0gZWxzZSB7XG5cblx0XHRcdFx0XHRpZiAoXG5cdFx0XHRcdFx0XHRldmVudC5wYWdlWSAtXG5cdFx0XHRcdFx0XHQkZG9jdW1lbnQuc2Nyb2xsVG9wKCkgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSAkZG9jdW1lbnQuc2Nyb2xsVG9wKCkgLSBvLnNjcm9sbFNwZWVkO1xuXHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbFRvcChzY3JvbGxlZCk7XG5cdFx0XHRcdFx0fSBlbHNlIGlmIChcblx0XHRcdFx0XHRcdCQod2luZG93KS5oZWlnaHQoKSAtXG5cdFx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VZIC1cblx0XHRcdFx0XHRcdFx0JGRvY3VtZW50LnNjcm9sbFRvcCgpXG5cdFx0XHRcdFx0XHQpIDxcblx0XHRcdFx0XHRcdG8uc2Nyb2xsU2Vuc2l0aXZpdHlcblx0XHRcdFx0XHQpIHtcblx0XHRcdFx0XHRcdHNjcm9sbGVkID0gJGRvY3VtZW50LnNjcm9sbFRvcCgpICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxUb3Aoc2Nyb2xsZWQpO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdGlmIChcblx0XHRcdFx0XHRcdGV2ZW50LnBhZ2VYIC1cblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxMZWZ0KCkgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSAkZG9jdW1lbnQuc2Nyb2xsTGVmdCgpIC0gby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxMZWZ0KHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9IGVsc2UgaWYgKFxuXHRcdFx0XHRcdFx0JCh3aW5kb3cpLndpZHRoKCkgLVxuXHRcdFx0XHRcdFx0KFxuXHRcdFx0XHRcdFx0XHRldmVudC5wYWdlWCAtXG5cdFx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxMZWZ0KClcblx0XHRcdFx0XHRcdCkgPFxuXHRcdFx0XHRcdFx0by5zY3JvbGxTZW5zaXRpdml0eVxuXHRcdFx0XHRcdCkge1xuXHRcdFx0XHRcdFx0c2Nyb2xsZWQgPSAkZG9jdW1lbnQuc2Nyb2xsTGVmdCgpICsgby5zY3JvbGxTcGVlZDtcblx0XHRcdFx0XHRcdCRkb2N1bWVudC5zY3JvbGxMZWZ0KHNjcm9sbGVkKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0fVxuXG5cdFx0XHRcdGlmIChzY3JvbGxlZCAhPT0gZmFsc2UgJiYgJC51aS5kZG1hbmFnZXIgJiYgIW8uZHJvcEJlaGF2aW91cikge1xuXHRcdFx0XHRcdCQudWkuZGRtYW5hZ2VyLnByZXBhcmVPZmZzZXRzKHRoaXMsIGV2ZW50KTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvL1JlZ2VuZXJhdGUgdGhlIGFic29sdXRlIHBvc2l0aW9uIHVzZWQgZm9yIHBvc2l0aW9uIGNoZWNrc1xuXHRcdFx0dGhpcy5wb3NpdGlvbkFicyA9IHRoaXMuX2NvbnZlcnRQb3NpdGlvblRvKFwiYWJzb2x1dGVcIik7XG5cblx0XHRcdC8vIG1qcyAtIGZpbmQgdGhlIHRvcCBvZmZzZXQgYmVmb3JlIHJlYXJyYW5nZW1lbnQsXG5cdFx0XHRwcmV2aW91c1RvcE9mZnNldCA9IHRoaXMucGxhY2Vob2xkZXIub2Zmc2V0KCkudG9wO1xuXG5cdFx0XHQvL1NldCB0aGUgaGVscGVyIHBvc2l0aW9uXG5cdFx0XHRpZiAoIXRoaXMub3B0aW9ucy5heGlzIHx8IHRoaXMub3B0aW9ucy5heGlzICE9PSBcInlcIikge1xuXHRcdFx0XHR0aGlzLmhlbHBlclswXS5zdHlsZS5sZWZ0ID0gdGhpcy5wb3NpdGlvbi5sZWZ0ICsgXCJweFwiO1xuXHRcdFx0fVxuXHRcdFx0aWYgKCF0aGlzLm9wdGlvbnMuYXhpcyB8fCB0aGlzLm9wdGlvbnMuYXhpcyAhPT0gXCJ4XCIpIHtcblx0XHRcdFx0dGhpcy5oZWxwZXJbMF0uc3R5bGUudG9wID0gKHRoaXMucG9zaXRpb24udG9wKSArIFwicHhcIjtcblx0XHRcdH1cblxuXHRcdFx0Ly8gbWpzIC0gY2hlY2sgYW5kIHJlc2V0IGhvdmVyaW5nIHN0YXRlIGF0IGVhY2ggY3ljbGVcblx0XHRcdHRoaXMuaG92ZXJpbmcgPSB0aGlzLmhvdmVyaW5nID8gdGhpcy5ob3ZlcmluZyA6IG51bGw7XG5cdFx0XHR0aGlzLm1vdXNlZW50ZXJlZCA9IHRoaXMubW91c2VlbnRlcmVkID8gdGhpcy5tb3VzZWVudGVyZWQgOiBmYWxzZTtcblxuXHRcdFx0Ly8gbWpzIC0gbGV0J3Mgc3RhcnQgY2FjaGluZyBzb21lIHZhcmlhYmxlc1xuXHRcdFx0KGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgX3BhcmVudEl0ZW0gPSB0aGlzLnBsYWNlaG9sZGVyLnBhcmVudCgpLnBhcmVudCgpO1xuXHRcdFx0XHRpZiAoX3BhcmVudEl0ZW0gJiYgX3BhcmVudEl0ZW0uY2xvc2VzdChcIi51aS1zb3J0YWJsZVwiKS5sZW5ndGgpIHtcblx0XHRcdFx0XHRwYXJlbnRJdGVtID0gX3BhcmVudEl0ZW07XG5cdFx0XHRcdH1cblx0XHRcdH0uY2FsbCh0aGlzKSk7XG5cblx0XHRcdGxldmVsID0gdGhpcy5fZ2V0TGV2ZWwodGhpcy5wbGFjZWhvbGRlcik7XG5cdFx0XHRjaGlsZExldmVscyA9IHRoaXMuX2dldENoaWxkTGV2ZWxzKHRoaXMuaGVscGVyKTtcblx0XHRcdG5ld0xpc3QgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KG8ubGlzdFR5cGUpO1xuXG5cdFx0XHQvL1JlYXJyYW5nZVxuXHRcdFx0Zm9yIChpID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSkge1xuXG5cdFx0XHRcdC8vQ2FjaGUgdmFyaWFibGVzIGFuZCBpbnRlcnNlY3Rpb24sIGNvbnRpbnVlIGlmIG5vIGludGVyc2VjdGlvblxuXHRcdFx0XHRpdGVtID0gdGhpcy5pdGVtc1tpXTtcblx0XHRcdFx0aXRlbUVsZW1lbnQgPSBpdGVtLml0ZW1bMF07XG5cdFx0XHRcdGludGVyc2VjdGlvbiA9IHRoaXMuX2ludGVyc2VjdHNXaXRoUG9pbnRlcihpdGVtKTtcblx0XHRcdFx0aWYgKCFpbnRlcnNlY3Rpb24pIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIE9ubHkgcHV0IHRoZSBwbGFjZWhvbGRlciBpbnNpZGUgdGhlIGN1cnJlbnQgQ29udGFpbmVyLCBza2lwIGFsbFxuXHRcdFx0XHQvLyBpdGVtcyBmb3JtIG90aGVyIGNvbnRhaW5lcnMuIFRoaXMgd29ya3MgYmVjYXVzZSB3aGVuIG1vdmluZ1xuXHRcdFx0XHQvLyBhbiBpdGVtIGZyb20gb25lIGNvbnRhaW5lciB0byBhbm90aGVyIHRoZVxuXHRcdFx0XHQvLyBjdXJyZW50Q29udGFpbmVyIGlzIHN3aXRjaGVkIGJlZm9yZSB0aGUgcGxhY2Vob2xkZXIgaXMgbW92ZWQuXG5cdFx0XHRcdC8vXG5cdFx0XHRcdC8vIFdpdGhvdXQgdGhpcyBtb3ZpbmcgaXRlbXMgaW4gXCJzdWItc29ydGFibGVzXCIgY2FuIGNhdXNlIHRoZSBwbGFjZWhvbGRlciB0byBqaXR0ZXJcblx0XHRcdFx0Ly8gYmVldHdlZW4gdGhlIG91dGVyIGFuZCBpbm5lciBjb250YWluZXIuXG5cdFx0XHRcdGlmIChpdGVtLmluc3RhbmNlICE9PSB0aGlzLmN1cnJlbnRDb250YWluZXIpIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIE5vIGFjdGlvbiBpZiBpbnRlcnNlY3RlZCBpdGVtIGlzIGRpc2FibGVkXG5cdFx0XHRcdC8vIGFuZCB0aGUgZWxlbWVudCBhYm92ZSBvciBiZWxvdyBpbiB0aGUgZGlyZWN0aW9uIHdlJ3JlIGdvaW5nIGlzIGFsc28gZGlzYWJsZWRcblx0XHRcdFx0aWYgKGl0ZW1FbGVtZW50LmNsYXNzTmFtZS5pbmRleE9mKG8uZGlzYWJsZWRDbGFzcykgIT09IC0xKSB7XG5cdFx0XHRcdFx0Ly8gTm90ZTogaW50ZXJzZWN0aW9uIGhhcmRjb2RlZCBkaXJlY3Rpb24gdmFsdWVzIGZyb21cblx0XHRcdFx0XHQvLyBqcXVlcnkudWkuc29ydGFibGUuanM6X2ludGVyc2VjdHNXaXRoUG9pbnRlclxuXHRcdFx0XHRcdGlmIChpbnRlcnNlY3Rpb24gPT09IDIpIHtcblx0XHRcdFx0XHRcdC8vIEdvaW5nIGRvd25cblx0XHRcdFx0XHRcdGl0ZW1BZnRlciA9IHRoaXMuaXRlbXNbaSArIDFdO1xuXHRcdFx0XHRcdFx0aWYgKGl0ZW1BZnRlciAmJiBpdGVtQWZ0ZXIuaXRlbS5oYXNDbGFzcyhvLmRpc2FibGVkQ2xhc3MpKSB7XG5cdFx0XHRcdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0fSBlbHNlIGlmIChpbnRlcnNlY3Rpb24gPT09IDEpIHtcblx0XHRcdFx0XHRcdC8vIEdvaW5nIHVwXG5cdFx0XHRcdFx0XHRpdGVtQmVmb3JlID0gdGhpcy5pdGVtc1tpIC0gMV07XG5cdFx0XHRcdFx0XHRpZiAoaXRlbUJlZm9yZSAmJiBpdGVtQmVmb3JlLml0ZW0uaGFzQ2xhc3Moby5kaXNhYmxlZENsYXNzKSkge1xuXHRcdFx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRtZXRob2QgPSBpbnRlcnNlY3Rpb24gPT09IDEgPyBcIm5leHRcIiA6IFwicHJldlwiO1xuXG5cdFx0XHRcdC8vIGNhbm5vdCBpbnRlcnNlY3Qgd2l0aCBpdHNlbGZcblx0XHRcdFx0Ly8gbm8gdXNlbGVzcyBhY3Rpb25zIHRoYXQgaGF2ZSBiZWVuIGRvbmUgYmVmb3JlXG5cdFx0XHRcdC8vIG5vIGFjdGlvbiBpZiB0aGUgaXRlbSBtb3ZlZCBpcyB0aGUgcGFyZW50IG9mIHRoZSBpdGVtIGNoZWNrZWRcblx0XHRcdFx0aWYgKGl0ZW1FbGVtZW50ICE9PSB0aGlzLmN1cnJlbnRJdGVtWzBdICYmXG5cdFx0XHRcdFx0dGhpcy5wbGFjZWhvbGRlclttZXRob2RdKClbMF0gIT09IGl0ZW1FbGVtZW50ICYmXG5cdFx0XHRcdFx0ISQuY29udGFpbnModGhpcy5wbGFjZWhvbGRlclswXSwgaXRlbUVsZW1lbnQpICYmXG5cdFx0XHRcdFx0KFxuXHRcdFx0XHRcdFx0dGhpcy5vcHRpb25zLnR5cGUgPT09IFwic2VtaS1keW5hbWljXCIgP1xuXHRcdFx0XHRcdFx0XHQhJC5jb250YWlucyh0aGlzLmVsZW1lbnRbMF0sIGl0ZW1FbGVtZW50KSA6XG5cdFx0XHRcdFx0XHRcdHRydWVcblx0XHRcdFx0XHQpXG5cdFx0XHRcdCkge1xuXG5cdFx0XHRcdFx0Ly8gbWpzIC0gd2UgYXJlIGludGVyc2VjdGluZyBhbiBlbGVtZW50OlxuXHRcdFx0XHRcdC8vIHRyaWdnZXIgdGhlIG1vdXNlZW50ZXIgZXZlbnQgYW5kIHN0b3JlIHRoaXMgc3RhdGVcblx0XHRcdFx0XHRpZiAoIXRoaXMubW91c2VlbnRlcmVkKSB7XG5cdFx0XHRcdFx0XHQkKGl0ZW1FbGVtZW50KS5tb3VzZWVudGVyKCk7XG5cdFx0XHRcdFx0XHR0aGlzLm1vdXNlZW50ZXJlZCA9IHRydWU7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0Ly8gbWpzIC0gaWYgdGhlIGVsZW1lbnQgaGFzIGNoaWxkcmVuIGFuZCB0aGV5IGFyZSBoaWRkZW4sXG5cdFx0XHRcdFx0Ly8gc2hvdyB0aGVtIGFmdGVyIGEgZGVsYXkgKENTUyByZXNwb25zaWJsZSlcblx0XHRcdFx0XHRpZiAoby5pc1RyZWUgJiYgJChpdGVtRWxlbWVudCkuaGFzQ2xhc3Moby5jb2xsYXBzZWRDbGFzcykgJiYgby5leHBhbmRPbkhvdmVyKSB7XG5cdFx0XHRcdFx0XHRpZiAoIXRoaXMuaG92ZXJpbmcpIHtcblx0XHRcdFx0XHRcdFx0JChpdGVtRWxlbWVudCkuYWRkQ2xhc3Moby5ob3ZlcmluZ0NsYXNzKTtcblx0XHRcdFx0XHRcdFx0dGhpcy5ob3ZlcmluZyA9IHdpbmRvdy5zZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdFx0XHRcdCQoaXRlbUVsZW1lbnQpXG5cdFx0XHRcdFx0XHRcdFx0XHQucmVtb3ZlQ2xhc3Moby5jb2xsYXBzZWRDbGFzcylcblx0XHRcdFx0XHRcdFx0XHRcdC5hZGRDbGFzcyhvLmV4cGFuZGVkQ2xhc3MpO1xuXG5cdFx0XHRcdFx0XHRcdFx0c2VsZi5yZWZyZXNoUG9zaXRpb25zKCk7XG5cdFx0XHRcdFx0XHRcdFx0c2VsZi5fdHJpZ2dlcihcImV4cGFuZFwiLCBldmVudCwgc2VsZi5fdWlIYXNoKCkpO1xuXHRcdFx0XHRcdFx0XHR9LCBvLmV4cGFuZE9uSG92ZXIpO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdHRoaXMuZGlyZWN0aW9uID0gaW50ZXJzZWN0aW9uID09PSAxID8gXCJkb3duXCIgOiBcInVwXCI7XG5cblx0XHRcdFx0XHQvLyBtanMgLSByZWFycmFuZ2UgdGhlIGVsZW1lbnRzIGFuZCByZXNldCB0aW1lb3V0cyBhbmQgaG92ZXJpbmcgc3RhdGVcblx0XHRcdFx0XHRpZiAodGhpcy5vcHRpb25zLnRvbGVyYW5jZSA9PT0gXCJwb2ludGVyXCIgfHwgdGhpcy5faW50ZXJzZWN0c1dpdGhTaWRlcyhpdGVtKSkge1xuXHRcdFx0XHRcdFx0JChpdGVtRWxlbWVudCkubW91c2VsZWF2ZSgpO1xuXHRcdFx0XHRcdFx0dGhpcy5tb3VzZWVudGVyZWQgPSBmYWxzZTtcblx0XHRcdFx0XHRcdCQoaXRlbUVsZW1lbnQpLnJlbW92ZUNsYXNzKG8uaG92ZXJpbmdDbGFzcyk7XG5cdFx0XHRcdFx0XHRpZiAodGhpcy5ob3ZlcmluZykge1xuXHRcdFx0XHRcdFx0XHR3aW5kb3cuY2xlYXJUaW1lb3V0KHRoaXMuaG92ZXJpbmcpO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0dGhpcy5ob3ZlcmluZyA9IG51bGw7XG5cblx0XHRcdFx0XHRcdC8vIG1qcyAtIGRvIG5vdCBzd2l0Y2ggY29udGFpbmVyIGlmXG5cdFx0XHRcdFx0XHQvLyBpdCdzIGEgcm9vdCBpdGVtIGFuZCAncHJvdGVjdFJvb3QnIGlzIHRydWVcblx0XHRcdFx0XHRcdC8vIG9yIGlmIGl0J3Mgbm90IGEgcm9vdCBpdGVtIGJ1dCB3ZSBhcmUgdHJ5aW5nIHRvIG1ha2UgaXQgcm9vdFxuXHRcdFx0XHRcdFx0aWYgKG8ucHJvdGVjdFJvb3QgJiZcblx0XHRcdFx0XHRcdFx0IShcblx0XHRcdFx0XHRcdFx0XHR0aGlzLmN1cnJlbnRJdGVtWzBdLnBhcmVudE5vZGUgPT09IHRoaXMuZWxlbWVudFswXSAmJlxuXHRcdFx0XHRcdFx0XHRcdC8vIGl0J3MgYSByb290IGl0ZW1cblx0XHRcdFx0XHRcdFx0XHRpdGVtRWxlbWVudC5wYXJlbnROb2RlICE9PSB0aGlzLmVsZW1lbnRbMF1cblx0XHRcdFx0XHRcdFx0XHQvLyBpdCdzIGludGVyc2VjdGluZyBhIG5vbi1yb290IGl0ZW1cblx0XHRcdFx0XHRcdFx0KVxuXHRcdFx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0XHRcdGlmICh0aGlzLmN1cnJlbnRJdGVtWzBdLnBhcmVudE5vZGUgIT09IHRoaXMuZWxlbWVudFswXSAmJlxuXHRcdFx0XHRcdFx0XHRcdGl0ZW1FbGVtZW50LnBhcmVudE5vZGUgPT09IHRoaXMuZWxlbWVudFswXVxuXHRcdFx0XHRcdFx0XHQpIHtcblxuXHRcdFx0XHRcdFx0XHRcdGlmICggISQoaXRlbUVsZW1lbnQpLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmxlbmd0aCkge1xuXHRcdFx0XHRcdFx0XHRcdFx0aXRlbUVsZW1lbnQuYXBwZW5kQ2hpbGQobmV3TGlzdCk7XG5cdFx0XHRcdFx0XHRcdFx0XHRpZiAoby5pc1RyZWUpIHtcblx0XHRcdFx0XHRcdFx0XHRcdFx0JChpdGVtRWxlbWVudClcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQucmVtb3ZlQ2xhc3Moby5sZWFmQ2xhc3MpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0LmFkZENsYXNzKG8uYnJhbmNoQ2xhc3MgKyBcIiBcIiArIG8uZXhwYW5kZWRDbGFzcyk7XG5cdFx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdFx0aWYgKHRoaXMuZGlyZWN0aW9uID09PSBcImRvd25cIikge1xuXHRcdFx0XHRcdFx0XHRcdFx0YSA9ICQoaXRlbUVsZW1lbnQpLnByZXYoKS5jaGlsZHJlbihvLmxpc3RUeXBlKTtcblx0XHRcdFx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0XHRcdFx0YSA9ICQoaXRlbUVsZW1lbnQpLmNoaWxkcmVuKG8ubGlzdFR5cGUpO1xuXHRcdFx0XHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdFx0XHRcdGlmIChhWzBdICE9PSB1bmRlZmluZWQpIHtcblx0XHRcdFx0XHRcdFx0XHRcdHRoaXMuX3JlYXJyYW5nZShldmVudCwgbnVsbCwgYSk7XG5cdFx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdFx0dGhpcy5fcmVhcnJhbmdlKGV2ZW50LCBpdGVtKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fSBlbHNlIGlmICghby5wcm90ZWN0Um9vdCkge1xuXHRcdFx0XHRcdFx0XHR0aGlzLl9yZWFycmFuZ2UoZXZlbnQsIGl0ZW0pO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHQvLyBDbGVhciBlbXRweSB1bCdzL29sJ3Ncblx0XHRcdFx0XHR0aGlzLl9jbGVhckVtcHR5KGl0ZW1FbGVtZW50KTtcblxuXHRcdFx0XHRcdHRoaXMuX3RyaWdnZXIoXCJjaGFuZ2VcIiwgZXZlbnQsIHRoaXMuX3VpSGFzaCgpKTtcblx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvLyBtanMgLSB0byBmaW5kIHRoZSBwcmV2aW91cyBzaWJsaW5nIGluIHRoZSBsaXN0LFxuXHRcdFx0Ly8ga2VlcCBiYWNrdHJhY2tpbmcgdW50aWwgd2UgaGl0IGEgdmFsaWQgbGlzdCBpdGVtLlxuXHRcdFx0KGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgX3ByZXZpb3VzSXRlbSA9IHRoaXMucGxhY2Vob2xkZXIucHJldigpO1xuXHRcdFx0XHRpZiAoX3ByZXZpb3VzSXRlbS5sZW5ndGgpIHtcblx0XHRcdFx0XHRwcmV2aW91c0l0ZW0gPSBfcHJldmlvdXNJdGVtO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdHByZXZpb3VzSXRlbSA9IG51bGw7XG5cdFx0XHRcdH1cblx0XHRcdH0uY2FsbCh0aGlzKSk7XG5cblx0XHRcdGlmIChwcmV2aW91c0l0ZW0gIT0gbnVsbCkge1xuXHRcdFx0XHR3aGlsZSAoXG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtWzBdLm5vZGVOYW1lLnRvTG93ZXJDYXNlKCkgIT09IFwibGlcIiB8fFxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbVswXS5jbGFzc05hbWUuaW5kZXhPZihvLmRpc2FibGVkQ2xhc3MpICE9PSAtMSB8fFxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbVswXSA9PT0gdGhpcy5jdXJyZW50SXRlbVswXSB8fFxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbVswXSA9PT0gdGhpcy5oZWxwZXJbMF1cblx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0aWYgKHByZXZpb3VzSXRlbVswXS5wcmV2aW91c1NpYmxpbmcpIHtcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbSA9ICQocHJldmlvdXNJdGVtWzBdLnByZXZpb3VzU2libGluZyk7XG5cdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbSA9IG51bGw7XG5cdFx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly8gbWpzIC0gdG8gZmluZCB0aGUgbmV4dCBzaWJsaW5nIGluIHRoZSBsaXN0LFxuXHRcdFx0Ly8ga2VlcCBzdGVwcGluZyBmb3J3YXJkIHVudGlsIHdlIGhpdCBhIHZhbGlkIGxpc3QgaXRlbS5cblx0XHRcdChmdW5jdGlvbigpIHtcblx0XHRcdFx0dmFyIF9uZXh0SXRlbSA9IHRoaXMucGxhY2Vob2xkZXIubmV4dCgpO1xuXHRcdFx0XHRpZiAoX25leHRJdGVtLmxlbmd0aCkge1xuXHRcdFx0XHRcdG5leHRJdGVtID0gX25leHRJdGVtO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdG5leHRJdGVtID0gbnVsbDtcblx0XHRcdFx0fVxuXHRcdFx0fS5jYWxsKHRoaXMpKTtcblxuXHRcdFx0aWYgKG5leHRJdGVtICE9IG51bGwpIHtcblx0XHRcdFx0d2hpbGUgKFxuXHRcdFx0XHRcdG5leHRJdGVtWzBdLm5vZGVOYW1lLnRvTG93ZXJDYXNlKCkgIT09IFwibGlcIiB8fFxuXHRcdFx0XHRcdG5leHRJdGVtWzBdLmNsYXNzTmFtZS5pbmRleE9mKG8uZGlzYWJsZWRDbGFzcykgIT09IC0xIHx8XG5cdFx0XHRcdFx0bmV4dEl0ZW1bMF0gPT09IHRoaXMuY3VycmVudEl0ZW1bMF0gfHxcblx0XHRcdFx0XHRuZXh0SXRlbVswXSA9PT0gdGhpcy5oZWxwZXJbMF1cblx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0aWYgKG5leHRJdGVtWzBdLm5leHRTaWJsaW5nKSB7XG5cdFx0XHRcdFx0XHRuZXh0SXRlbSA9ICQobmV4dEl0ZW1bMF0ubmV4dFNpYmxpbmcpO1xuXHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRuZXh0SXRlbSA9IG51bGw7XG5cdFx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0dGhpcy5iZXlvbmRNYXhMZXZlbHMgPSAwO1xuXG5cdFx0XHQvLyBtanMgLSBpZiB0aGUgaXRlbSBpcyBtb3ZlZCB0byB0aGUgbGVmdCwgc2VuZCBpdCBvbmUgbGV2ZWwgdXBcblx0XHRcdC8vIGJ1dCBvbmx5IGlmIGl0J3MgYXQgdGhlIGJvdHRvbSBvZiB0aGUgbGlzdFxuXHRcdFx0aWYgKHBhcmVudEl0ZW0gIT0gbnVsbCAmJlxuXHRcdFx0XHRuZXh0SXRlbSA9PSBudWxsICYmXG5cdFx0XHRcdCEoby5wcm90ZWN0Um9vdCAmJiBwYXJlbnRJdGVtWzBdLnBhcmVudE5vZGUgPT0gdGhpcy5lbGVtZW50WzBdKSAmJlxuXHRcdFx0XHQoXG5cdFx0XHRcdFx0by5ydGwgJiZcblx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHR0aGlzLnBvc2l0aW9uQWJzLmxlZnQgK1xuXHRcdFx0XHRcdFx0dGhpcy5oZWxwZXIub3V0ZXJXaWR0aCgpID4gcGFyZW50SXRlbS5vZmZzZXQoKS5sZWZ0ICtcblx0XHRcdFx0XHRcdHBhcmVudEl0ZW0ub3V0ZXJXaWR0aCgpXG5cdFx0XHRcdFx0KSB8fFxuXHRcdFx0XHRcdCFvLnJ0bCAmJiAodGhpcy5wb3NpdGlvbkFicy5sZWZ0IDwgcGFyZW50SXRlbS5vZmZzZXQoKS5sZWZ0KVxuXHRcdFx0XHQpXG5cdFx0XHQpIHtcblxuXHRcdFx0XHRwYXJlbnRJdGVtLmFmdGVyKHRoaXMucGxhY2Vob2xkZXJbMF0pO1xuXHRcdFx0XHRoZWxwZXJJc05vdFNpYmxpbmcgPSAhcGFyZW50SXRlbVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdC5jaGlsZHJlbihvLmxpc3RJdGVtKVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdC5jaGlsZHJlbihcImxpOnZpc2libGU6bm90KC51aS1zb3J0YWJsZS1oZWxwZXIpXCIpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0Lmxlbmd0aDtcblx0XHRcdFx0aWYgKG8uaXNUcmVlICYmIGhlbHBlcklzTm90U2libGluZykge1xuXHRcdFx0XHRcdHBhcmVudEl0ZW1cblx0XHRcdFx0XHRcdC5yZW1vdmVDbGFzcyh0aGlzLm9wdGlvbnMuYnJhbmNoQ2xhc3MgKyBcIiBcIiArIHRoaXMub3B0aW9ucy5leHBhbmRlZENsYXNzKVxuXHRcdFx0XHRcdFx0LmFkZENsYXNzKHRoaXMub3B0aW9ucy5sZWFmQ2xhc3MpO1xuXHRcdFx0XHR9XG4gICAgICAgICAgICAgICAgaWYodHlwZW9mIHBhcmVudEl0ZW0gIT09ICd1bmRlZmluZWQnKVxuXHRcdFx0XHQgICAgdGhpcy5fY2xlYXJFbXB0eShwYXJlbnRJdGVtWzBdKTtcblx0XHRcdFx0dGhpcy5fdHJpZ2dlcihcImNoYW5nZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXHRcdFx0XHQvLyBtanMgLSBpZiB0aGUgaXRlbSBpcyBiZWxvdyBhIHNpYmxpbmcgYW5kIGlzIG1vdmVkIHRvIHRoZSByaWdodCxcblx0XHRcdFx0Ly8gbWFrZSBpdCBhIGNoaWxkIG9mIHRoYXQgc2libGluZ1xuXHRcdFx0fSBlbHNlIGlmIChwcmV2aW91c0l0ZW0gIT0gbnVsbCAmJlxuXHRcdFx0XHQhcHJldmlvdXNJdGVtLmhhc0NsYXNzKG8uZGlzYWJsZU5lc3RpbmdDbGFzcykgJiZcblx0XHRcdFx0KFxuXHRcdFx0XHRcdHByZXZpb3VzSXRlbS5jaGlsZHJlbihvLmxpc3RUeXBlKS5sZW5ndGggJiZcblx0XHRcdFx0XHRwcmV2aW91c0l0ZW0uY2hpbGRyZW4oby5saXN0VHlwZSkuaXMoXCI6dmlzaWJsZVwiKSB8fFxuXHRcdFx0XHRcdCFwcmV2aW91c0l0ZW0uY2hpbGRyZW4oby5saXN0VHlwZSkubGVuZ3RoXG5cdFx0XHRcdCkgJiZcblx0XHRcdFx0IShvLnByb3RlY3RSb290ICYmIHRoaXMuY3VycmVudEl0ZW1bMF0ucGFyZW50Tm9kZSA9PT0gdGhpcy5lbGVtZW50WzBdKSAmJlxuXHRcdFx0XHQoXG5cdFx0XHRcdFx0by5ydGwgJiZcblx0XHRcdFx0XHQoXG5cdFx0XHRcdFx0XHR0aGlzLnBvc2l0aW9uQWJzLmxlZnQgK1xuXHRcdFx0XHRcdFx0dGhpcy5oZWxwZXIub3V0ZXJXaWR0aCgpIDxcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbS5vZmZzZXQoKS5sZWZ0ICtcblx0XHRcdFx0XHRcdHByZXZpb3VzSXRlbS5vdXRlcldpZHRoKCkgLVxuXHRcdFx0XHRcdFx0by50YWJTaXplXG5cdFx0XHRcdFx0KSB8fFxuXHRcdFx0XHRcdCFvLnJ0bCAmJlxuXHRcdFx0XHRcdCh0aGlzLnBvc2l0aW9uQWJzLmxlZnQgPiBwcmV2aW91c0l0ZW0ub2Zmc2V0KCkubGVmdCArIG8udGFiU2l6ZSlcblx0XHRcdFx0KVxuXHRcdFx0KSB7XG5cblx0XHRcdFx0dGhpcy5faXNBbGxvd2VkKHByZXZpb3VzSXRlbSwgbGV2ZWwsIGxldmVsICsgY2hpbGRMZXZlbHMgKyAxKTtcblxuXHRcdFx0XHRpZiAoIXByZXZpb3VzSXRlbS5jaGlsZHJlbihvLmxpc3RUeXBlKS5sZW5ndGgpIHtcblx0XHRcdFx0XHRwcmV2aW91c0l0ZW1bMF0uYXBwZW5kQ2hpbGQobmV3TGlzdCk7XG5cdFx0XHRcdFx0aWYgKG8uaXNUcmVlKSB7XG5cdFx0XHRcdFx0XHRwcmV2aW91c0l0ZW1cblx0XHRcdFx0XHRcdFx0LnJlbW92ZUNsYXNzKG8ubGVhZkNsYXNzKVxuXHRcdFx0XHRcdFx0XHQuYWRkQ2xhc3Moby5icmFuY2hDbGFzcyArIFwiIFwiICsgby5leHBhbmRlZENsYXNzKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblxuXHRcdFx0XHQvLyBtanMgLSBpZiB0aGlzIGl0ZW0gaXMgYmVpbmcgbW92ZWQgZnJvbSB0aGUgdG9wLCBhZGQgaXQgdG8gdGhlIHRvcCBvZiB0aGUgbGlzdC5cblx0XHRcdFx0aWYgKHByZXZpb3VzVG9wT2Zmc2V0ICYmIChwcmV2aW91c1RvcE9mZnNldCA8PSBwcmV2aW91c0l0ZW0ub2Zmc2V0KCkudG9wKSkge1xuXHRcdFx0XHRcdHByZXZpb3VzSXRlbS5jaGlsZHJlbihvLmxpc3RUeXBlKS5wcmVwZW5kKHRoaXMucGxhY2Vob2xkZXIpO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdC8vIG1qcyAtIG90aGVyd2lzZSwgYWRkIGl0IHRvIHRoZSBib3R0b20gb2YgdGhlIGxpc3QuXG5cdFx0XHRcdFx0cHJldmlvdXNJdGVtLmNoaWxkcmVuKG8ubGlzdFR5cGUpWzBdLmFwcGVuZENoaWxkKHRoaXMucGxhY2Vob2xkZXJbMF0pO1xuXHRcdFx0XHR9XG4gICAgICAgICAgICAgICAgaWYodHlwZW9mIHBhcmVudEl0ZW0gIT09ICd1bmRlZmluZWQnKVxuXHRcdFx0XHQgICAgdGhpcy5fY2xlYXJFbXB0eShwYXJlbnRJdGVtWzBdKTtcblx0XHRcdFx0dGhpcy5fdHJpZ2dlcihcImNoYW5nZVwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0dGhpcy5faXNBbGxvd2VkKHBhcmVudEl0ZW0sIGxldmVsLCBsZXZlbCArIGNoaWxkTGV2ZWxzKTtcblx0XHRcdH1cblxuXHRcdFx0Ly9Qb3N0IGV2ZW50cyB0byBjb250YWluZXJzXG5cdFx0XHR0aGlzLl9jb250YWN0Q29udGFpbmVycyhldmVudCk7XG5cblx0XHRcdC8vSW50ZXJjb25uZWN0IHdpdGggZHJvcHBhYmxlc1xuXHRcdFx0aWYgKCQudWkuZGRtYW5hZ2VyKSB7XG5cdFx0XHRcdCQudWkuZGRtYW5hZ2VyLmRyYWcodGhpcywgZXZlbnQpO1xuXHRcdFx0fVxuXG5cdFx0XHQvL0NhbGwgY2FsbGJhY2tzXG5cdFx0XHR0aGlzLl90cmlnZ2VyKFwic29ydFwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXG5cdFx0XHR0aGlzLmxhc3RQb3NpdGlvbkFicyA9IHRoaXMucG9zaXRpb25BYnM7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cblx0XHR9LFxuXG5cdFx0X21vdXNlU3RvcDogZnVuY3Rpb24oZXZlbnQpIHtcblx0XHRcdC8vIG1qcyAtIGlmIHRoZSBpdGVtIGlzIGluIGEgcG9zaXRpb24gbm90IGFsbG93ZWQsIHNlbmQgaXQgYmFja1xuXHRcdFx0aWYgKHRoaXMuYmV5b25kTWF4TGV2ZWxzKSB7XG5cblx0XHRcdFx0dGhpcy5wbGFjZWhvbGRlci5yZW1vdmVDbGFzcyh0aGlzLm9wdGlvbnMuZXJyb3JDbGFzcyk7XG5cblx0XHRcdFx0aWYgKHRoaXMuZG9tUG9zaXRpb24ucHJldikge1xuXHRcdFx0XHRcdCQodGhpcy5kb21Qb3NpdGlvbi5wcmV2KS5hZnRlcih0aGlzLnBsYWNlaG9sZGVyKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHQkKHRoaXMuZG9tUG9zaXRpb24ucGFyZW50KS5wcmVwZW5kKHRoaXMucGxhY2Vob2xkZXIpO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0dGhpcy5fdHJpZ2dlcihcInJldmVydFwiLCBldmVudCwgdGhpcy5fdWlIYXNoKCkpO1xuXG5cdFx0XHR9XG5cblx0XHRcdC8vIG1qcyAtIGNsZWFyIHRoZSBob3ZlcmluZyB0aW1lb3V0LCBqdXN0IHRvIGJlIHN1cmVcblx0XHRcdCQoXCIuXCIgKyB0aGlzLm9wdGlvbnMuaG92ZXJpbmdDbGFzcylcblx0XHRcdFx0Lm1vdXNlbGVhdmUoKVxuXHRcdFx0XHQucmVtb3ZlQ2xhc3ModGhpcy5vcHRpb25zLmhvdmVyaW5nQ2xhc3MpO1xuXG5cdFx0XHR0aGlzLm1vdXNlZW50ZXJlZCA9IGZhbHNlO1xuXHRcdFx0aWYgKHRoaXMuaG92ZXJpbmcpIHtcblx0XHRcdFx0d2luZG93LmNsZWFyVGltZW91dCh0aGlzLmhvdmVyaW5nKTtcblx0XHRcdH1cblx0XHRcdHRoaXMuaG92ZXJpbmcgPSBudWxsO1xuXG5cdFx0XHR0aGlzLl9yZWxvY2F0ZV9ldmVudCA9IGV2ZW50O1xuXHRcdFx0dGhpcy5fcGlkX2N1cnJlbnQgPSAkKHRoaXMuZG9tUG9zaXRpb24ucGFyZW50KS5wYXJlbnQoKS5hdHRyKFwiaWRcIik7XG5cdFx0XHR0aGlzLl9zb3J0X2N1cnJlbnQgPSB0aGlzLmRvbVBvc2l0aW9uLnByZXYgPyAkKHRoaXMuZG9tUG9zaXRpb24ucHJldikubmV4dCgpLmluZGV4KCkgOiAwO1xuXHRcdFx0JC51aS5zb3J0YWJsZS5wcm90b3R5cGUuX21vdXNlU3RvcC5hcHBseSh0aGlzLCBhcmd1bWVudHMpOyAvL2FzeWJuY2hyb25vdXMgZXhlY3V0aW9uLCBAc2VlIF9jbGVhciBmb3IgdGhlIHJlbG9jYXRlIGV2ZW50LlxuXHRcdH0sXG5cblx0XHQvLyBtanMgLSB0aGlzIGZ1bmN0aW9uIGlzIHNsaWdodGx5IG1vZGlmaWVkXG5cdFx0Ly8gdG8gbWFrZSBpdCBlYXNpZXIgdG8gaG92ZXIgb3ZlciBhIGNvbGxhcHNlZCBlbGVtZW50IGFuZCBoYXZlIGl0IGV4cGFuZFxuXHRcdF9pbnRlcnNlY3RzV2l0aFNpZGVzOiBmdW5jdGlvbihpdGVtKSB7XG5cblx0XHRcdHZhciBoYWxmID0gdGhpcy5vcHRpb25zLmlzVHJlZSA/IC44IDogLjUsXG5cdFx0XHRcdGlzT3ZlckJvdHRvbUhhbGYgPSBpc092ZXJBeGlzKFxuXHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMudG9wICsgdGhpcy5vZmZzZXQuY2xpY2sudG9wLFxuXHRcdFx0XHRcdGl0ZW0udG9wICsgKGl0ZW0uaGVpZ2h0ICogaGFsZiksXG5cdFx0XHRcdFx0aXRlbS5oZWlnaHRcblx0XHRcdFx0KSxcblx0XHRcdFx0aXNPdmVyVG9wSGFsZiA9IGlzT3ZlckF4aXMoXG5cdFx0XHRcdFx0dGhpcy5wb3NpdGlvbkFicy50b3AgKyB0aGlzLm9mZnNldC5jbGljay50b3AsXG5cdFx0XHRcdFx0aXRlbS50b3AgLSAoaXRlbS5oZWlnaHQgKiBoYWxmKSxcblx0XHRcdFx0XHRpdGVtLmhlaWdodFxuXHRcdFx0XHQpLFxuXHRcdFx0XHRpc092ZXJSaWdodEhhbGYgPSBpc092ZXJBeGlzKFxuXHRcdFx0XHRcdHRoaXMucG9zaXRpb25BYnMubGVmdCArIHRoaXMub2Zmc2V0LmNsaWNrLmxlZnQsXG5cdFx0XHRcdFx0aXRlbS5sZWZ0ICsgKGl0ZW0ud2lkdGggLyAyKSxcblx0XHRcdFx0XHRpdGVtLndpZHRoXG5cdFx0XHRcdCksXG5cdFx0XHRcdHZlcnRpY2FsRGlyZWN0aW9uID0gdGhpcy5fZ2V0RHJhZ1ZlcnRpY2FsRGlyZWN0aW9uKCksXG5cdFx0XHRcdGhvcml6b250YWxEaXJlY3Rpb24gPSB0aGlzLl9nZXREcmFnSG9yaXpvbnRhbERpcmVjdGlvbigpO1xuXG5cdFx0XHRpZiAodGhpcy5mbG9hdGluZyAmJiBob3Jpem9udGFsRGlyZWN0aW9uKSB7XG5cdFx0XHRcdHJldHVybiAoXG5cdFx0XHRcdFx0KGhvcml6b250YWxEaXJlY3Rpb24gPT09IFwicmlnaHRcIiAmJiBpc092ZXJSaWdodEhhbGYpIHx8XG5cdFx0XHRcdFx0KGhvcml6b250YWxEaXJlY3Rpb24gPT09IFwibGVmdFwiICYmICFpc092ZXJSaWdodEhhbGYpXG5cdFx0XHRcdCk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRyZXR1cm4gdmVydGljYWxEaXJlY3Rpb24gJiYgKFxuXHRcdFx0XHRcdCh2ZXJ0aWNhbERpcmVjdGlvbiA9PT0gXCJkb3duXCIgJiYgaXNPdmVyQm90dG9tSGFsZikgfHxcblx0XHRcdFx0XHQodmVydGljYWxEaXJlY3Rpb24gPT09IFwidXBcIiAmJiBpc092ZXJUb3BIYWxmKVxuXHRcdFx0XHQpO1xuXHRcdFx0fVxuXG5cdFx0fSxcblxuXHRcdF9jb250YWN0Q29udGFpbmVyczogZnVuY3Rpb24oKSB7XG5cblx0XHRcdGlmICh0aGlzLm9wdGlvbnMucHJvdGVjdFJvb3QgJiYgdGhpcy5jdXJyZW50SXRlbVswXS5wYXJlbnROb2RlID09PSB0aGlzLmVsZW1lbnRbMF0gKSB7XG5cdFx0XHRcdHJldHVybjtcblx0XHRcdH1cblxuXHRcdFx0JC51aS5zb3J0YWJsZS5wcm90b3R5cGUuX2NvbnRhY3RDb250YWluZXJzLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG5cblx0XHR9LFxuXG5cdFx0X2NsZWFyOiBmdW5jdGlvbigpIHtcblx0XHRcdHZhciBpLFxuXHRcdFx0XHRpdGVtO1xuXG5cdFx0XHQkLnVpLnNvcnRhYmxlLnByb3RvdHlwZS5fY2xlYXIuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcblxuXHRcdFx0Ly9yZWxvY2F0ZSBldmVudFxuXHRcdFx0aWYgKCEodGhpcy5fcGlkX2N1cnJlbnQgPT09IHRoaXMuX3VpSGFzaCgpLml0ZW0ucGFyZW50KCkucGFyZW50KCkuYXR0cihcImlkXCIpICYmXG5cdFx0XHRcdHRoaXMuX3NvcnRfY3VycmVudCA9PT0gdGhpcy5fdWlIYXNoKCkuaXRlbS5pbmRleCgpKSkge1xuXHRcdFx0XHR0aGlzLl90cmlnZ2VyKFwicmVsb2NhdGVcIiwgdGhpcy5fcmVsb2NhdGVfZXZlbnQsIHRoaXMuX3VpSGFzaCgpKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gbWpzIC0gY2xlYW4gbGFzdCBlbXB0eSB1bC9vbFxuXHRcdFx0Zm9yIChpID0gdGhpcy5pdGVtcy5sZW5ndGggLSAxOyBpID49IDA7IGktLSkge1xuXHRcdFx0XHRpdGVtID0gdGhpcy5pdGVtc1tpXS5pdGVtWzBdO1xuXHRcdFx0XHR0aGlzLl9jbGVhckVtcHR5KGl0ZW0pO1xuXHRcdFx0fVxuXG5cdFx0fSxcblxuXHRcdHNlcmlhbGl6ZTogZnVuY3Rpb24ob3B0aW9ucykge1xuXG5cdFx0XHR2YXIgbyA9ICQuZXh0ZW5kKHt9LCB0aGlzLm9wdGlvbnMsIG9wdGlvbnMpLFxuXHRcdFx0XHRpdGVtcyA9IHRoaXMuX2dldEl0ZW1zQXNqUXVlcnkobyAmJiBvLmNvbm5lY3RlZCksXG5cdFx0XHRcdHN0ciA9IFtdO1xuXG5cdFx0XHQkKGl0ZW1zKS5lYWNoKGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgcmVzID0gKCQoby5pdGVtIHx8IHRoaXMpLmF0dHIoby5hdHRyaWJ1dGUgfHwgXCJpZFwiKSB8fCBcIlwiKVxuXHRcdFx0XHRcdFx0Lm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSksXG5cdFx0XHRcdFx0cGlkID0gKCQoby5pdGVtIHx8IHRoaXMpLnBhcmVudChvLmxpc3RUeXBlKVxuXHRcdFx0XHRcdFx0LnBhcmVudChvLml0ZW1zKVxuXHRcdFx0XHRcdFx0LmF0dHIoby5hdHRyaWJ1dGUgfHwgXCJpZFwiKSB8fCBcIlwiKVxuXHRcdFx0XHRcdFx0Lm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSk7XG5cblx0XHRcdFx0aWYgKHJlcykge1xuXHRcdFx0XHRcdHN0ci5wdXNoKFxuXHRcdFx0XHRcdFx0KFxuXHRcdFx0XHRcdFx0XHQoby5rZXkgfHwgcmVzWzFdKSArXG5cdFx0XHRcdFx0XHRcdFwiW1wiICtcblx0XHRcdFx0XHRcdFx0KG8ua2V5ICYmIG8uZXhwcmVzc2lvbiA/IHJlc1sxXSA6IHJlc1syXSkgKyBcIl1cIlxuXHRcdFx0XHRcdFx0KSArXG5cdFx0XHRcdFx0XHRcIj1cIiArXG5cdFx0XHRcdFx0XHQocGlkID8gKG8ua2V5ICYmIG8uZXhwcmVzc2lvbiA/IHBpZFsxXSA6IHBpZFsyXSkgOiBvLnJvb3RJRCkpO1xuXHRcdFx0XHR9XG5cdFx0XHR9KTtcblxuXHRcdFx0aWYgKCFzdHIubGVuZ3RoICYmIG8ua2V5KSB7XG5cdFx0XHRcdHN0ci5wdXNoKG8ua2V5ICsgXCI9XCIpO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gc3RyLmpvaW4oXCImXCIpO1xuXG5cdFx0fSxcblxuXHRcdHRvSGllcmFyY2h5OiBmdW5jdGlvbihvcHRpb25zKSB7XG5cblx0XHRcdHZhciBvID0gJC5leHRlbmQoe30sIHRoaXMub3B0aW9ucywgb3B0aW9ucyksXG5cdFx0XHRcdHJldCA9IFtdO1xuXG5cdFx0XHQkKHRoaXMuZWxlbWVudCkuY2hpbGRyZW4oby5pdGVtcykuZWFjaChmdW5jdGlvbigpIHtcblx0XHRcdFx0dmFyIGxldmVsID0gX3JlY3Vyc2l2ZUl0ZW1zKHRoaXMpO1xuXHRcdFx0XHRyZXQucHVzaChsZXZlbCk7XG5cdFx0XHR9KTtcblxuXHRcdFx0cmV0dXJuIHJldDtcblxuXHRcdFx0ZnVuY3Rpb24gX3JlY3Vyc2l2ZUl0ZW1zKGl0ZW0pIHtcblx0XHRcdFx0dmFyIGlkID0gKCQoaXRlbSkuYXR0cihvLmF0dHJpYnV0ZSB8fCBcImlkXCIpIHx8IFwiXCIpLm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSksXG5cdFx0XHRcdFx0Y3VycmVudEl0ZW07XG5cblx0XHRcdFx0dmFyIGRhdGEgPSAkKGl0ZW0pLmRhdGEoKTtcblx0XHRcdFx0aWYgKGRhdGEubmVzdGVkU29ydGFibGVJdGVtKSB7XG5cdFx0XHRcdFx0ZGVsZXRlIGRhdGEubmVzdGVkU29ydGFibGVJdGVtOyAvLyBSZW1vdmUgdGhlIG5lc3RlZFNvcnRhYmxlSXRlbSBvYmplY3QgZnJvbSB0aGUgZGF0YVxuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWYgKGlkKSB7XG5cdFx0XHRcdFx0Y3VycmVudEl0ZW0gPSB7XG5cdFx0XHRcdFx0XHRcImlkXCI6IGlkWzJdXG5cdFx0XHRcdFx0fTtcblxuXHRcdFx0XHRcdGN1cnJlbnRJdGVtID0gJC5leHRlbmQoe30sIGN1cnJlbnRJdGVtLCBkYXRhKTsgLy8gQ29tYmluZSB0aGUgdHdvIG9iamVjdHNcblxuXHRcdFx0XHRcdGlmICgkKGl0ZW0pLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmNoaWxkcmVuKG8uaXRlbXMpLmxlbmd0aCA+IDApIHtcblx0XHRcdFx0XHRcdGN1cnJlbnRJdGVtLmNoaWxkcmVuID0gW107XG5cdFx0XHRcdFx0XHQkKGl0ZW0pLmNoaWxkcmVuKG8ubGlzdFR5cGUpLmNoaWxkcmVuKG8uaXRlbXMpLmVhY2goZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRcdHZhciBsZXZlbCA9IF9yZWN1cnNpdmVJdGVtcyh0aGlzKTtcblx0XHRcdFx0XHRcdFx0Y3VycmVudEl0ZW0uY2hpbGRyZW4ucHVzaChsZXZlbCk7XG5cdFx0XHRcdFx0XHR9KTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0cmV0dXJuIGN1cnJlbnRJdGVtO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fSxcblxuXHRcdHRvQXJyYXk6IGZ1bmN0aW9uKG9wdGlvbnMpIHtcblxuXHRcdFx0dmFyIG8gPSAkLmV4dGVuZCh7fSwgdGhpcy5vcHRpb25zLCBvcHRpb25zKSxcblx0XHRcdFx0c0RlcHRoID0gby5zdGFydERlcHRoQ291bnQgfHwgMCxcblx0XHRcdFx0cmV0ID0gW10sXG5cdFx0XHRcdGxlZnQgPSAxO1xuXG5cdFx0XHRpZiAoIW8uZXhjbHVkZVJvb3QpIHtcblx0XHRcdFx0cmV0LnB1c2goe1xuXHRcdFx0XHRcdFwiaXRlbV9pZFwiOiBvLnJvb3RJRCxcblx0XHRcdFx0XHRcInBhcmVudF9pZFwiOiBudWxsLFxuXHRcdFx0XHRcdFwiZGVwdGhcIjogc0RlcHRoLFxuXHRcdFx0XHRcdFwibGVmdFwiOiBsZWZ0LFxuXHRcdFx0XHRcdFwicmlnaHRcIjogKCQoby5pdGVtcywgdGhpcy5lbGVtZW50KS5sZW5ndGggKyAxKSAqIDJcblx0XHRcdFx0fSk7XG5cdFx0XHRcdGxlZnQrKztcblx0XHRcdH1cblxuXHRcdFx0JCh0aGlzLmVsZW1lbnQpLmNoaWxkcmVuKG8uaXRlbXMpLmVhY2goZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGxlZnQgPSBfcmVjdXJzaXZlQXJyYXkodGhpcywgc0RlcHRoLCBsZWZ0KTtcblx0XHRcdH0pO1xuXG5cdFx0XHRyZXQgPSByZXQuc29ydChmdW5jdGlvbihhLCBiKSB7IHJldHVybiAoYS5sZWZ0IC0gYi5sZWZ0KTsgfSk7XG5cblx0XHRcdHJldHVybiByZXQ7XG5cblx0XHRcdGZ1bmN0aW9uIF9yZWN1cnNpdmVBcnJheShpdGVtLCBkZXB0aCwgX2xlZnQpIHtcblxuXHRcdFx0XHR2YXIgcmlnaHQgPSBfbGVmdCArIDEsXG5cdFx0XHRcdFx0aWQsXG5cdFx0XHRcdFx0cGlkLFxuXHRcdFx0XHRcdHBhcmVudEl0ZW07XG5cblx0XHRcdFx0aWYgKCQoaXRlbSkuY2hpbGRyZW4oby5saXN0VHlwZSkuY2hpbGRyZW4oby5pdGVtcykubGVuZ3RoID4gMCkge1xuXHRcdFx0XHRcdGRlcHRoKys7XG5cdFx0XHRcdFx0JChpdGVtKS5jaGlsZHJlbihvLmxpc3RUeXBlKS5jaGlsZHJlbihvLml0ZW1zKS5lYWNoKGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdFx0cmlnaHQgPSBfcmVjdXJzaXZlQXJyYXkoJCh0aGlzKSwgZGVwdGgsIHJpZ2h0KTtcblx0XHRcdFx0XHR9KTtcblx0XHRcdFx0XHRkZXB0aC0tO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0aWQgPSAoJChpdGVtKS5hdHRyKG8uYXR0cmlidXRlIHx8IFwiaWRcIikpLm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSk7XG5cblx0XHRcdFx0aWYgKGRlcHRoID09PSBzRGVwdGgpIHtcblx0XHRcdFx0XHRwaWQgPSBvLnJvb3RJRDtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRwYXJlbnRJdGVtID0gKCQoaXRlbSkucGFyZW50KG8ubGlzdFR5cGUpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0LnBhcmVudChvLml0ZW1zKVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdC5hdHRyKG8uYXR0cmlidXRlIHx8IFwiaWRcIikpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0Lm1hdGNoKG8uZXhwcmVzc2lvbiB8fCAoLyguKylbLT1fXSguKykvKSk7XG5cdFx0XHRcdFx0cGlkID0gcGFyZW50SXRlbVsyXTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdGlmIChpZCkge1xuXHRcdFx0XHRcdCAgICAgICAgdmFyIG5hbWUgPSAkKGl0ZW0pLmRhdGEoXCJuYW1lXCIpO1xuXHRcdFx0XHRcdFx0cmV0LnB1c2goe1xuXHRcdFx0XHRcdFx0XHRcImlkXCI6IGlkWzJdLFxuXHRcdFx0XHRcdFx0XHRcInBhcmVudF9pZFwiOiBwaWQsXG5cdFx0XHRcdFx0XHRcdFwiZGVwdGhcIjogZGVwdGgsXG5cdFx0XHRcdFx0XHRcdFwibGVmdFwiOiBfbGVmdCxcblx0XHRcdFx0XHRcdFx0XCJyaWdodFwiOiByaWdodCxcblx0XHRcdFx0XHRcdFx0XCJuYW1lXCI6bmFtZVxuXHRcdFx0XHRcdFx0fSk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRfbGVmdCA9IHJpZ2h0ICsgMTtcblx0XHRcdFx0cmV0dXJuIF9sZWZ0O1xuXHRcdFx0fVxuXG5cdFx0fSxcblxuXHRcdF9jbGVhckVtcHR5OiBmdW5jdGlvbiAoaXRlbSkge1xuXHRcdFx0ZnVuY3Rpb24gcmVwbGFjZUNsYXNzKGVsZW0sIHNlYXJjaCwgcmVwbGFjZSwgc3dhcCkge1xuXHRcdFx0XHRpZiAoc3dhcCkge1xuXHRcdFx0XHRcdHNlYXJjaCA9IFtyZXBsYWNlLCByZXBsYWNlID0gc2VhcmNoXVswXTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdCQoZWxlbSkucmVtb3ZlQ2xhc3Moc2VhcmNoKS5hZGRDbGFzcyhyZXBsYWNlKTtcblx0XHRcdH1cblxuXHRcdFx0dmFyIG8gPSB0aGlzLm9wdGlvbnMsXG5cdFx0XHRcdGNoaWxkcmVuTGlzdCA9ICQoaXRlbSkuY2hpbGRyZW4oby5saXN0VHlwZSksXG5cdFx0XHRcdGhhc0NoaWxkcmVuID0gY2hpbGRyZW5MaXN0LmlzKCc6bm90KDplbXB0eSknKTtcblxuXHRcdFx0dmFyIGRvTm90Q2xlYXIgPVxuXHRcdFx0XHRvLmRvTm90Q2xlYXIgfHxcblx0XHRcdFx0aGFzQ2hpbGRyZW4gfHxcblx0XHRcdFx0by5wcm90ZWN0Um9vdCAmJiAkKGl0ZW0pWzBdID09PSB0aGlzLmVsZW1lbnRbMF07XG5cblx0XHRcdGlmIChvLmlzVHJlZSkge1xuXHRcdFx0XHRyZXBsYWNlQ2xhc3MoaXRlbSwgby5icmFuY2hDbGFzcywgby5sZWFmQ2xhc3MsIGRvTm90Q2xlYXIpO1xuXG5cdFx0XHRcdGlmIChkb05vdENsZWFyICYmIGhhc0NoaWxkcmVuKSB7XG5cdFx0XHRcdFx0cmVwbGFjZUNsYXNzKGl0ZW0sIG8uY29sbGFwc2VkQ2xhc3MsIG8uZXhwYW5kZWRDbGFzcyk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0aWYgKCFkb05vdENsZWFyKSB7XG5cdFx0XHRcdGNoaWxkcmVuTGlzdC5yZW1vdmUoKTtcblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0X2dldExldmVsOiBmdW5jdGlvbihpdGVtKSB7XG5cblx0XHRcdHZhciBsZXZlbCA9IDEsXG5cdFx0XHRcdGxpc3Q7XG5cblx0XHRcdGlmICh0aGlzLm9wdGlvbnMubGlzdFR5cGUpIHtcblx0XHRcdFx0bGlzdCA9IGl0ZW0uY2xvc2VzdCh0aGlzLm9wdGlvbnMubGlzdFR5cGUpO1xuXHRcdFx0XHR3aGlsZSAobGlzdCAmJiBsaXN0Lmxlbmd0aCA+IDAgJiYgIWxpc3QuaXMoXCIudWktc29ydGFibGVcIikpIHtcblx0XHRcdFx0XHRsZXZlbCsrO1xuXHRcdFx0XHRcdGxpc3QgPSBsaXN0LnBhcmVudCgpLmNsb3Nlc3QodGhpcy5vcHRpb25zLmxpc3RUeXBlKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gbGV2ZWw7XG5cdFx0fSxcblxuXHRcdF9nZXRDaGlsZExldmVsczogZnVuY3Rpb24ocGFyZW50LCBkZXB0aCkge1xuXHRcdFx0dmFyIHNlbGYgPSB0aGlzLFxuXHRcdFx0XHRvID0gdGhpcy5vcHRpb25zLFxuXHRcdFx0XHRyZXN1bHQgPSAwO1xuXHRcdFx0ZGVwdGggPSBkZXB0aCB8fCAwO1xuXG5cdFx0XHQkKHBhcmVudCkuY2hpbGRyZW4oby5saXN0VHlwZSkuY2hpbGRyZW4oby5pdGVtcykuZWFjaChmdW5jdGlvbihpbmRleCwgY2hpbGQpIHtcblx0XHRcdFx0cmVzdWx0ID0gTWF0aC5tYXgoc2VsZi5fZ2V0Q2hpbGRMZXZlbHMoY2hpbGQsIGRlcHRoICsgMSksIHJlc3VsdCk7XG5cdFx0XHR9KTtcblxuXHRcdFx0cmV0dXJuIGRlcHRoID8gcmVzdWx0ICsgMSA6IHJlc3VsdDtcblx0XHR9LFxuXG5cdFx0X2lzQWxsb3dlZDogZnVuY3Rpb24ocGFyZW50SXRlbSwgbGV2ZWwsIGxldmVscykge1xuXHRcdFx0dmFyIG8gPSB0aGlzLm9wdGlvbnMsXG5cdFx0XHRcdC8vIHRoaXMgdGFrZXMgaW50byBhY2NvdW50IHRoZSBtYXhMZXZlbHMgc2V0IHRvIHRoZSByZWNpcGllbnQgbGlzdFxuXHRcdFx0XHRtYXhMZXZlbHMgPSB0aGlzXG5cdFx0XHRcdFx0LnBsYWNlaG9sZGVyXG5cdFx0XHRcdFx0LmNsb3Nlc3QoXCIudWktc29ydGFibGVcIilcblx0XHRcdFx0XHQubmVzdGVkU29ydGFibGUoXCJvcHRpb25cIiwgXCJtYXhMZXZlbHNcIiksXG5cblx0XHRcdFx0Ly8gQ2hlY2sgaWYgdGhlIHBhcmVudCBoYXMgY2hhbmdlZCB0byBwcmV2ZW50IGl0LCB3aGVuIG8uZGlzYWJsZVBhcmVudENoYW5nZSBpcyB0cnVlXG5cdFx0XHRcdG9sZFBhcmVudCA9IHRoaXMuY3VycmVudEl0ZW0ucGFyZW50KCkucGFyZW50KCksXG5cdFx0XHRcdGRpc2FibGVkQnlQYXJlbnRjaGFuZ2UgPSBvLmRpc2FibGVQYXJlbnRDaGFuZ2UgJiYgKFxuXHRcdFx0XHRcdC8vRnJvbSBzb21ld2hlcmUgdG8gc29tZXdoZXJlIGVsc2UsIGV4Y2VwdCB0aGUgcm9vdFxuXHRcdFx0XHRcdHR5cGVvZiBwYXJlbnRJdGVtICE9PSAndW5kZWZpbmVkJyAmJiAhb2xkUGFyZW50LmlzKHBhcmVudEl0ZW0pIHx8XG5cdFx0XHRcdFx0dHlwZW9mIHBhcmVudEl0ZW0gPT09ICd1bmRlZmluZWQnICYmIG9sZFBhcmVudC5pcyhcImxpXCIpXHQvL0Zyb20gc29tZXdoZXJlIHRvIHRoZSByb290XG5cdFx0XHRcdCk7XG5cdFx0XHQvLyBtanMgLSBpcyB0aGUgcm9vdCBwcm90ZWN0ZWQ/XG5cdFx0XHQvLyBtanMgLSBhcmUgd2UgbmVzdGluZyB0b28gZGVlcD9cblx0XHRcdGlmIChcblx0XHRcdFx0ZGlzYWJsZWRCeVBhcmVudGNoYW5nZSB8fFxuXHRcdFx0XHQhby5pc0FsbG93ZWQodGhpcy5wbGFjZWhvbGRlciwgcGFyZW50SXRlbSwgdGhpcy5jdXJyZW50SXRlbSlcblx0XHRcdCkge1xuXHRcdFx0XHR0aGlzLnBsYWNlaG9sZGVyLmFkZENsYXNzKG8uZXJyb3JDbGFzcyk7XG5cdFx0XHRcdGlmIChtYXhMZXZlbHMgPCBsZXZlbHMgJiYgbWF4TGV2ZWxzICE9PSAwKSB7XG5cdFx0XHRcdFx0dGhpcy5iZXlvbmRNYXhMZXZlbHMgPSBsZXZlbHMgLSBtYXhMZXZlbHM7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0dGhpcy5iZXlvbmRNYXhMZXZlbHMgPSAxO1xuXHRcdFx0XHR9XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRpZiAobWF4TGV2ZWxzIDwgbGV2ZWxzICYmIG1heExldmVscyAhPT0gMCkge1xuXHRcdFx0XHRcdHRoaXMucGxhY2Vob2xkZXIuYWRkQ2xhc3Moby5lcnJvckNsYXNzKTtcblx0XHRcdFx0XHR0aGlzLmJleW9uZE1heExldmVscyA9IGxldmVscyAtIG1heExldmVscztcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHR0aGlzLnBsYWNlaG9sZGVyLnJlbW92ZUNsYXNzKG8uZXJyb3JDbGFzcyk7XG5cdFx0XHRcdFx0dGhpcy5iZXlvbmRNYXhMZXZlbHMgPSAwO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdH0pKTtcblxuXHQkLm1qcy5uZXN0ZWRTb3J0YWJsZS5wcm90b3R5cGUub3B0aW9ucyA9ICQuZXh0ZW5kKFxuXHRcdHt9LFxuXHRcdCQudWkuc29ydGFibGUucHJvdG90eXBlLm9wdGlvbnMsXG5cdFx0JC5tanMubmVzdGVkU29ydGFibGUucHJvdG90eXBlLm9wdGlvbnNcblx0KTtcbn0pKTtcbiIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==