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
/******/ 	return __webpack_require__(__webpack_require__.s = "./core/common/js/storeCategory.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./core/common/js/storeCategory.js":
/*!*****************************************!*\
  !*** ./core/common/js/storeCategory.js ***!
  \*****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var xe__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! xe */ "./core/index.js");

// @FIXME 적당한 곳으로 이동


window.jQuery('#btnCreateCategory').on('click', function (e) {
  var _context;

  var _this = e.target;

  var id = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()(_context = jquery__WEBPACK_IMPORTED_MODULE_1___default()(_this).closest('form')).call(_context, '[name="id"]').val();

  var params = {};
  xe__WEBPACK_IMPORTED_MODULE_2__["default"].app('Griper').then(function (appGriper) {
    if (!id) {
      appGriper.form(jquery__WEBPACK_IMPORTED_MODULE_1___default()(_this), 'You must first create a category ID.'); // @FIXME
    } else {
      appGriper.form.fn.clear(jquery__WEBPACK_IMPORTED_MODULE_1___default()(_this).closest('form'));
    }
  });
  params.categoryName = id;
  xe__WEBPACK_IMPORTED_MODULE_2__["default"].post('fieldType.storeCategory', params).then(function success(response) {
    var section = jquery__WEBPACK_IMPORTED_MODULE_1___default()(_this).closest('.__xe_df_category');

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()(section).call(section, '[name="category_id"]').val(response.data.id);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_0___default()(section).call(section, 'button').hide();

    section.append(jquery__WEBPACK_IMPORTED_MODULE_1___default()('<a>').text(xe__WEBPACK_IMPORTED_MODULE_2__["default"].Lang.trans('xe::categoryManagement')).prop('target', '_blank').prop('href', '/settings/category/' + response.data.id));
  });
});

/***/ }),

/***/ "./core/index.js":
/*!*******************************************************************!*\
  !*** delegated ./core/index.js from dll-reference _xe_dll_common ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(320);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(4);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS9jb21tb24vanMvc3RvcmVDYXRlZ29yeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vY29yZS9pbmRleC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvanF1ZXJ5L3NyYy9qcXVlcnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsid2luZG93IiwialF1ZXJ5Iiwib24iLCJlIiwiX3RoaXMiLCJ0YXJnZXQiLCJpZCIsIiQiLCJjbG9zZXN0IiwidmFsIiwicGFyYW1zIiwiWEUiLCJhcHAiLCJ0aGVuIiwiYXBwR3JpcGVyIiwiZm9ybSIsImZuIiwiY2xlYXIiLCJjYXRlZ29yeU5hbWUiLCJwb3N0Iiwic3VjY2VzcyIsInJlc3BvbnNlIiwic2VjdGlvbiIsImRhdGEiLCJoaWRlIiwiYXBwZW5kIiwidGV4dCIsIkxhbmciLCJ0cmFucyIsInByb3AiXSwibWFwcGluZ3MiOiI7QUFBQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7O0FBR0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLGtEQUEwQyxnQ0FBZ0M7QUFDMUU7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxnRUFBd0Qsa0JBQWtCO0FBQzFFO0FBQ0EseURBQWlELGNBQWM7QUFDL0Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlEQUF5QyxpQ0FBaUM7QUFDMUUsd0hBQWdILG1CQUFtQixFQUFFO0FBQ3JJO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsbUNBQTJCLDBCQUEwQixFQUFFO0FBQ3ZELHlDQUFpQyxlQUFlO0FBQ2hEO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLDhEQUFzRCwrREFBK0Q7O0FBRXJIO0FBQ0E7OztBQUdBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDbEZBO0FBRUE7QUFDQTtBQUVBQSxNQUFNLENBQUNDLE1BQVAsQ0FBYyxvQkFBZCxFQUFvQ0MsRUFBcEMsQ0FBdUMsT0FBdkMsRUFBZ0QsVUFBQ0MsQ0FBRCxFQUFPO0FBQUE7O0FBQ3JELE1BQUlDLEtBQUssR0FBR0QsQ0FBQyxDQUFDRSxNQUFkOztBQUNBLE1BQUlDLEVBQUUsR0FBRyxzR0FBQUMsNkNBQUMsQ0FBQ0gsS0FBRCxDQUFELENBQVNJLE9BQVQsQ0FBaUIsTUFBakIsa0JBQThCLGFBQTlCLEVBQTZDQyxHQUE3QyxFQUFUOztBQUNBLE1BQUlDLE1BQU0sR0FBRyxFQUFiO0FBRUFDLDRDQUFFLENBQUNDLEdBQUgsQ0FBTyxRQUFQLEVBQWlCQyxJQUFqQixDQUFzQixVQUFBQyxTQUFTLEVBQUk7QUFDakMsUUFBSSxDQUFDUixFQUFMLEVBQVM7QUFDUFEsZUFBUyxDQUFDQyxJQUFWLENBQWVSLDZDQUFDLENBQUNILEtBQUQsQ0FBaEIsRUFBeUIsc0NBQXpCLEVBRE8sQ0FDMEQ7QUFDbEUsS0FGRCxNQUVPO0FBQ0xVLGVBQVMsQ0FBQ0MsSUFBVixDQUFlQyxFQUFmLENBQWtCQyxLQUFsQixDQUF3QlYsNkNBQUMsQ0FBQ0gsS0FBRCxDQUFELENBQVNJLE9BQVQsQ0FBaUIsTUFBakIsQ0FBeEI7QUFDRDtBQUNGLEdBTkQ7QUFRQUUsUUFBTSxDQUFDUSxZQUFQLEdBQXNCWixFQUF0QjtBQUVBSyw0Q0FBRSxDQUFDUSxJQUFILENBQVEseUJBQVIsRUFBbUNULE1BQW5DLEVBQ0dHLElBREgsQ0FDUSxTQUFTTyxPQUFULENBQWtCQyxRQUFsQixFQUE0QjtBQUNoQyxRQUFJQyxPQUFPLEdBQUdmLDZDQUFDLENBQUNILEtBQUQsQ0FBRCxDQUFTSSxPQUFULENBQWlCLG1CQUFqQixDQUFkOztBQUNBLCtGQUFBYyxPQUFPLE1BQVAsQ0FBQUEsT0FBTyxFQUFNLHNCQUFOLENBQVAsQ0FBcUNiLEdBQXJDLENBQXlDWSxRQUFRLENBQUNFLElBQVQsQ0FBY2pCLEVBQXZEOztBQUNBLCtGQUFBZ0IsT0FBTyxNQUFQLENBQUFBLE9BQU8sRUFBTSxRQUFOLENBQVAsQ0FBdUJFLElBQXZCOztBQUNBRixXQUFPLENBQUNHLE1BQVIsQ0FBZWxCLDZDQUFDLENBQUMsS0FBRCxDQUFELENBQ1ptQixJQURZLENBQ1BmLDBDQUFFLENBQUNnQixJQUFILENBQVFDLEtBQVIsQ0FBYyx3QkFBZCxDQURPLEVBRVpDLElBRlksQ0FFUCxRQUZPLEVBRUcsUUFGSCxFQUdaQSxJQUhZLENBR1AsTUFITyxFQUdDLHdCQUF3QlIsUUFBUSxDQUFDRSxJQUFULENBQWNqQixFQUh2QyxDQUFmO0FBSUQsR0FUSDtBQVVELENBekJELEU7Ozs7Ozs7Ozs7O0FDTEEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsZ0MiLCJmaWxlIjoiYXNzZXRzL2NvcmUvY29tbW9uL2pzL3N0b3JlQ2F0ZWdvcnkuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIlwiO1xuXG5cbiBcdC8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuIFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oX193ZWJwYWNrX3JlcXVpcmVfXy5zID0gXCIuL2NvcmUvY29tbW9uL2pzL3N0b3JlQ2F0ZWdvcnkuanNcIik7XG4iLCIvLyBARklYTUUg7KCB64u57ZWcIOqzs+ycvOuhnCDsnbTrj5lcblxuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IFhFIGZyb20gJ3hlJ1xuXG53aW5kb3cualF1ZXJ5KCcjYnRuQ3JlYXRlQ2F0ZWdvcnknKS5vbignY2xpY2snLCAoZSkgPT4ge1xuICB2YXIgX3RoaXMgPSBlLnRhcmdldFxuICB2YXIgaWQgPSAkKF90aGlzKS5jbG9zZXN0KCdmb3JtJykuZmluZCgnW25hbWU9XCJpZFwiXScpLnZhbCgpXG4gIHZhciBwYXJhbXMgPSB7fVxuXG4gIFhFLmFwcCgnR3JpcGVyJykudGhlbihhcHBHcmlwZXIgPT4ge1xuICAgIGlmICghaWQpIHtcbiAgICAgIGFwcEdyaXBlci5mb3JtKCQoX3RoaXMpLCAnWW91IG11c3QgZmlyc3QgY3JlYXRlIGEgY2F0ZWdvcnkgSUQuJykgLy8gQEZJWE1FXG4gICAgfSBlbHNlIHtcbiAgICAgIGFwcEdyaXBlci5mb3JtLmZuLmNsZWFyKCQoX3RoaXMpLmNsb3Nlc3QoJ2Zvcm0nKSlcbiAgICB9XG4gIH0pXG5cbiAgcGFyYW1zLmNhdGVnb3J5TmFtZSA9IGlkXG5cbiAgWEUucG9zdCgnZmllbGRUeXBlLnN0b3JlQ2F0ZWdvcnknLCBwYXJhbXMpXG4gICAgLnRoZW4oZnVuY3Rpb24gc3VjY2VzcyAocmVzcG9uc2UpIHtcbiAgICAgIHZhciBzZWN0aW9uID0gJChfdGhpcykuY2xvc2VzdCgnLl9feGVfZGZfY2F0ZWdvcnknKVxuICAgICAgc2VjdGlvbi5maW5kKCdbbmFtZT1cImNhdGVnb3J5X2lkXCJdJykudmFsKHJlc3BvbnNlLmRhdGEuaWQpXG4gICAgICBzZWN0aW9uLmZpbmQoJ2J1dHRvbicpLmhpZGUoKVxuICAgICAgc2VjdGlvbi5hcHBlbmQoJCgnPGE+JylcbiAgICAgICAgLnRleHQoWEUuTGFuZy50cmFucygneGU6OmNhdGVnb3J5TWFuYWdlbWVudCcpKVxuICAgICAgICAucHJvcCgndGFyZ2V0JywgJ19ibGFuaycpXG4gICAgICAgIC5wcm9wKCdocmVmJywgJy9zZXR0aW5ncy9jYXRlZ29yeS8nICsgcmVzcG9uc2UuZGF0YS5pZCkpXG4gICAgfSlcbn0pXG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMzIwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDApOyIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==