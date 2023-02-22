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
/******/ 	return __webpack_require__(__webpack_require__.s = "./core/user/settings/edit.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./core/user/settings/edit.js":
/*!************************************!*\
  !*** ./core/user/settings/edit.js ***!
  \************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/splice */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_3__);





var EmailBox = function (XE, $) {
  var _this;

  var _$wrapper = $();

  var _mails = [];
  var _email = '';
  var _userId = '';

  var _bindEvents = function _bindEvents() {
    _$wrapper.on('click', '.btnDeleteEmail', function (e) {
      e.preventDefault();
      var $this = $(this);
      $this.css({
        display: 'none'
      }).siblings().css({
        display: 'inline-block'
      });
    });

    _$wrapper.on('click', '.btnDeleteEmailConfirm', function (e) {
      var _context;

      e.preventDefault();
      var $this = $(this);

      var email = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context = $this.closest('li.list-group-item')).call(_context, '[name=email]').val();

      _this.delete(email);
    });

    _$wrapper.on('click', '.btnDeleteEmailCancle', function (e) {
      var _context2;

      e.preventDefault();
      var $this = $(this);
      $this.siblings().addBack().hide();

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context2 = $this.parent()).call(_context2, '.btnDeleteEmail').show();
    });

    _$wrapper.on('click', '#__xe_emailAddBtn', function () {
      var $input = $('#__xe_addedEmailInput');
      var email = $input.val();

      if (!email) {
        return;
      }

      $input.val('');

      _this.add(email);
    });

    _$wrapper.on('change', '[name=email]', function (e) {
      var $this = $(this);
      var $liWrapper = $this.closest('li.list-group-item');
      var $ul = $liWrapper.closest('ul');
      $liWrapper.siblings().each(function () {
        var $li = $(this);

        if (!_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($li).call($li, '> span.pull-right').length) {
          var temp = '<span class="pull-right">';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmail" style="display: inline-block;">삭제</a>';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailConfirm" style="display: none;">삭제확인</a>';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailCancle" style="display: none;">취소</a>';
          temp += '</span>';
          $li.append(temp);
        }
      });

      if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($liWrapper).call($liWrapper, '> span.pull-right').length > 0) {
        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($liWrapper).call($liWrapper, '> span.pull-right').remove();
      }

      $ul.prepend($liWrapper.detach());
    });
  };

  return {
    init: function init(opt) {
      _this = this;
      _$wrapper = opt.$wrapper;
      _email = opt.email;
      _userId = opt.userId;

      _bindEvents();

      _this.getEmailList();

      return this;
    },
    getEmailList: function getEmailList() {
      XE.get('settings.user.mail.list', {
        userId: _userId
      }).then(function (response) {
        _mails = response.data.mails;

        _this.render(response.data.mails);
      }).catch(function (error) {
        XE.toast('danger', error, '.__xe_alertEmailModal');
      });
    },
    delete: function _delete(email) {
      XE.post('settings.user.mail.delete', {
        userId: _userId,
        address: email
      }).then(function (response) {
        var i = _mails.indexOf(email);

        _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_3___default()(_mails).call(_mails, i, 1);

        _this.render(_mails);

        XE.toast('success', '삭제하였습니다.', '.__xe_alertEmailModal');
      }).catch(function (error) {
        XE.toast('danger', error, '.__xe_alertEmailModal');
      });
    },
    add: function add(email) {
      XE.post('settings.user.mail.add', {
        userId: _userId,
        address: email
      }).then(function (response) {
        var email = response.data.mail;

        _mails.push(email);

        _this.render(_mails);

        XE.toast('success', '추가되었습니다.', '.__xe_alertEmailModal');
      }).catch(function (error) {
        XE.toast('danger', error, '.__xe_alertEmailModal');
      });
    },
    render: function render(emails) {
      var temp = '';
      temp += '<div>';

      if (emails.length > 0) {
        temp += '<ul class="list-group">';
        emails.forEach(function (email, i) {
          var address = email.address;
          var checked = address === _email ? 'checked="checked"' : '';
          temp += '<li class="list-group-item clearfix">';
          temp += '<label><input type="radio" name="email" value="' + address + '" ' + checked + '/> ' + address + '</label>';

          if (email.address !== _email) {
            temp += '<span class="pull-right">';
            temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmail" style="display: inline-block;">삭제</a>';
            temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailConfirm" style="display: none;">삭제확인</a>';
            temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailCancle" style="display: none;">취소</a>';
            temp += '</span>';
          }

          temp += '</li>';
        });
        temp += '</ul>';
      }

      temp += '<div class="input-group input-group-sm" style="margin-bottom: 20px;">';
      temp += '<input type="text" class="form-control" id="__xe_addedEmailInput" placeholder="이메일을 입력하세요">';
      temp += '<span class="input-group-btn"><buttion id="__xe_emailAddBtn" class="btn btn-default" type="button">추가</buttion></span>';
      temp += '</div>';

      _$wrapper.html(temp);
    }
  };
}(window.XE, window.jQuery);

window.jQuery(function ($) {
  $('.__xe_settingEmail').click(function () {
    $('.__xe_emailView').slideToggle();
    $('#__xe_emailSetting').slideToggle();
  });
  EmailBox.init({
    $wrapper: $('#__xe_emailSetting'),
    userId: $('#__xe_emailSetting').data('user-id'),
    email: $('#__xe_emailSetting').data('email')
  });
});

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(6);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(91);

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

/***/ "dll-reference _xe_dll_common":
/*!*********************************!*\
  !*** external "_xe_dll_common" ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = _xe_dll_common;

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS91c2VyL3NldHRpbmdzL2VkaXQuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9zcGxpY2UuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLm9iamVjdC50by1zdHJpbmcuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL3dlYi5kb20tY29sbGVjdGlvbnMuZm9yLWVhY2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsiRW1haWxCb3giLCJYRSIsIiQiLCJfdGhpcyIsIl8kd3JhcHBlciIsIl9tYWlscyIsIl9lbWFpbCIsIl91c2VySWQiLCJfYmluZEV2ZW50cyIsIm9uIiwiZSIsInByZXZlbnREZWZhdWx0IiwiJHRoaXMiLCJjc3MiLCJkaXNwbGF5Iiwic2libGluZ3MiLCJlbWFpbCIsImNsb3Nlc3QiLCJ2YWwiLCJkZWxldGUiLCJhZGRCYWNrIiwiaGlkZSIsInBhcmVudCIsInNob3ciLCIkaW5wdXQiLCJhZGQiLCIkbGlXcmFwcGVyIiwiJHVsIiwiZWFjaCIsIiRsaSIsImxlbmd0aCIsInRlbXAiLCJhcHBlbmQiLCJyZW1vdmUiLCJwcmVwZW5kIiwiZGV0YWNoIiwiaW5pdCIsIm9wdCIsIiR3cmFwcGVyIiwidXNlcklkIiwiZ2V0RW1haWxMaXN0IiwiZ2V0IiwidGhlbiIsInJlc3BvbnNlIiwiZGF0YSIsIm1haWxzIiwicmVuZGVyIiwiY2F0Y2giLCJlcnJvciIsInRvYXN0IiwicG9zdCIsImFkZHJlc3MiLCJpIiwiaW5kZXhPZiIsIm1haWwiLCJwdXNoIiwiZW1haWxzIiwiZm9yRWFjaCIsImNoZWNrZWQiLCJodG1sIiwid2luZG93IiwialF1ZXJ5IiwiY2xpY2siLCJzbGlkZVRvZ2dsZSJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7UUFDdkQsaUNBQWlDLGVBQWU7UUFDaEQ7UUFDQTtRQUNBOztRQUVBO1FBQ0Esc0RBQXNELCtEQUErRDs7UUFFckg7UUFDQTs7O1FBR0E7UUFDQTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDbEZBLElBQUlBLFFBQVEsR0FBSSxVQUFVQyxFQUFWLEVBQWNDLENBQWQsRUFBaUI7RUFDL0IsSUFBSUMsS0FBSjs7RUFDQSxJQUFJQyxTQUFTLEdBQUdGLENBQUMsRUFB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aUJBQUQsQ0FBRCxDQUFxQjZELFdBQXJCO0lBQ0E3RCxDQUFDLENBQUMsb0JBQUQsQ0FBRCxDQUF3QjZELFdBQXhCO0VBQ0QsQ0FIRDtFQUtBL0QsUUFBUSxDQUFDb0MsSUFBVCxDQUFjO0lBQ1pFLFFBQVEsRUFBRXBDLENBQUMsQ0FBQyxvQkFBRCxDQURDO0lBRVpxQyxNQUFNLEVBQUVyQyxDQUFDLENBQUMsb0JBQUQsQ0FBRCxDQUF3QjBDLElBQXhCLENBQTZCLFNBQTdCLENBRkk7SUFHWjVCLEtBQUssRUFBRWQsQ0FBQyxDQUFDLG9CQUFELENBQUQsQ0FBd0IwQyxJQUF4QixDQUE2QixPQUE3QjtFQUhLLENBQWQ7QUFLRCxDQVhELEU7Ozs7Ozs7Ozs7O0FDcEtBLDhHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLGdDIiwiZmlsZSI6ImFzc2V0cy9jb3JlL3VzZXIvc2V0dGluZ3MvZWRpdC5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vY29yZS91c2VyL3NldHRpbmdzL2VkaXQuanNcIik7XG4iLCJ2YXIgRW1haWxCb3ggPSAoZnVuY3Rpb24gKFhFLCAkKSB7XG4gIHZhciBfdGhpc1xuICB2YXIgXyR3cmFwcGVyID0gJCgpXG4gIHZhciBfbWFpbHMgPSBbXVxuICB2YXIgX2VtYWlsID0gJydcbiAgdmFyIF91c2VySWQgPSAnJ1xuXG4gIHZhciBfYmluZEV2ZW50cyA9IGZ1bmN0aW9uICgpIHtcbiAgICBfJHdyYXBwZXIub24oJ2NsaWNrJywgJy5idG5EZWxldGVFbWFpbCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KClcblxuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuXG4gICAgICAkdGhpcy5jc3MoeyBkaXNwbGF5OiAnbm9uZScgfSkuc2libGluZ3MoKS5jc3MoeyBkaXNwbGF5OiAnaW5saW5lLWJsb2NrJyB9KVxuICAgIH0pXG5cbiAgICBfJHdyYXBwZXIub24oJ2NsaWNrJywgJy5idG5EZWxldGVFbWFpbENvbmZpcm0nLCBmdW5jdGlvbiAoZSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgIHZhciBlbWFpbCA9ICR0aGlzLmNsb3Nlc3QoJ2xpLmxpc3QtZ3JvdXAtaXRlbScpLmZpbmQoJ1tuYW1lPWVtYWlsXScpLnZhbCgpXG5cbiAgICAgIF90aGlzLmRlbGV0ZShlbWFpbClcbiAgICB9KVxuXG4gICAgXyR3cmFwcGVyLm9uKCdjbGljaycsICcuYnRuRGVsZXRlRW1haWxDYW5jbGUnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcblxuICAgICAgJHRoaXMuc2libGluZ3MoKS5hZGRCYWNrKCkuaGlkZSgpXG4gICAgICAkdGhpcy5wYXJlbnQoKS5maW5kKCcuYnRuRGVsZXRlRW1haWwnKS5zaG93KClcbiAgICB9KVxuXG4gICAgXyR3cmFwcGVyLm9uKCdjbGljaycsICcjX194ZV9lbWFpbEFkZEJ0bicsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciAkaW5wdXQgPSAkKCcjX194ZV9hZGRlZEVtYWlsSW5wdXQnKVxuICAgICAgdmFyIGVtYWlsID0gJGlucHV0LnZhbCgpXG4gICAgICBpZiAoIWVtYWlsKSB7XG4gICAgICAgIHJldHVyblxuICAgICAgfVxuXG4gICAgICAkaW5wdXQudmFsKCcnKVxuXG4gICAgICBfdGhpcy5hZGQoZW1haWwpXG4gICAgfSlcblxuICAgIF8kd3JhcHBlci5vbignY2hhbmdlJywgJ1tuYW1lPWVtYWlsXScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIgJGxpV3JhcHBlciA9ICR0aGlzLmNsb3Nlc3QoJ2xpLmxpc3QtZ3JvdXAtaXRlbScpXG4gICAgICB2YXIgJHVsID0gJGxpV3JhcHBlci5jbG9zZXN0KCd1bCcpXG5cbiAgICAgICRsaVdyYXBwZXIuc2libGluZ3MoKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyICRsaSA9ICQodGhpcylcblxuICAgICAgICBpZiAoISRsaS5maW5kKCc+IHNwYW4ucHVsbC1yaWdodCcpLmxlbmd0aCkge1xuICAgICAgICAgIHZhciB0ZW1wID0gJzxzcGFuIGNsYXNzPVwicHVsbC1yaWdodFwiPidcbiAgICAgICAgICB0ZW1wICs9ICc8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuIGJ0bi1zbSBidG4tbGluayBidG5EZWxldGVFbWFpbFwiIHN0eWxlPVwiZGlzcGxheTogaW5saW5lLWJsb2NrO1wiPuyCreygnDwvYT4nXG4gICAgICAgICAgdGVtcCArPSAnPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0biBidG4tc20gYnRuLWxpbmsgYnRuRGVsZXRlRW1haWxDb25maXJtXCIgc3R5bGU9XCJkaXNwbGF5OiBub25lO1wiPuyCreygnO2ZleyduDwvYT4nXG4gICAgICAgICAgdGVtcCArPSAnPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0biBidG4tc20gYnRuLWxpbmsgYnRuRGVsZXRlRW1haWxDYW5jbGVcIiBzdHlsZT1cImRpc3BsYXk6IG5vbmU7XCI+7Leo7IaMPC9hPidcbiAgICAgICAgICB0ZW1wICs9ICc8L3NwYW4+J1xuXG4gICAgICAgICAgJGxpLmFwcGVuZCh0ZW1wKVxuICAgICAgICB9XG4gICAgICB9KVxuXG4gICAgICBpZiAoJGxpV3JhcHBlci5maW5kKCc+IHNwYW4ucHVsbC1yaWdodCcpLmxlbmd0aCA+IDApIHtcbiAgICAgICAgJGxpV3JhcHBlci5maW5kKCc+IHNwYW4ucHVsbC1yaWdodCcpLnJlbW92ZSgpXG4gICAgICB9XG5cbiAgICAgICR1bC5wcmVwZW5kKCRsaVdyYXBwZXIuZGV0YWNoKCkpXG4gICAgfSlcbiAgfVxuXG4gIHJldHVybiB7XG4gICAgaW5pdDogZnVuY3Rpb24gKG9wdCkge1xuICAgICAgX3RoaXMgPSB0aGlzXG4gICAgICBfJHdyYXBwZXIgPSBvcHQuJHdyYXBwZXJcbiAgICAgIF9lbWFpbCA9IG9wdC5lbWFpbFxuICAgICAgX3VzZXJJZCA9IG9wdC51c2VySWRcblxuICAgICAgX2JpbmRFdmVudHMoKVxuXG4gICAgICBfdGhpcy5nZXRFbWFpbExpc3QoKVxuXG4gICAgICByZXR1cm4gdGhpc1xuICAgIH0sXG5cbiAgICBnZXRFbWFpbExpc3Q6IGZ1bmN0aW9uICgpIHtcbiAgICAgIFhFLmdldCgnc2V0dGluZ3MudXNlci5tYWlsLmxpc3QnLCB7IHVzZXJJZDogX3VzZXJJZCB9KS50aGVuKChyZXNwb25zZSkgPT4ge1xuICAgICAgICBfbWFpbHMgPSByZXNwb25zZS5kYXRhLm1haWxzXG4gICAgICAgIF90aGlzLnJlbmRlcihyZXNwb25zZS5kYXRhLm1haWxzKVxuICAgICAgfSkuY2F0Y2goKGVycm9yKSA9PiB7XG4gICAgICAgIFhFLnRvYXN0KCdkYW5nZXInLCBlcnJvciwgJy5fX3hlX2FsZXJ0RW1haWxNb2RhbCcpXG4gICAgICB9KVxuICAgIH0sXG5cbiAgICBkZWxldGU6IGZ1bmN0aW9uIChlbWFpbCkge1xuICAgICAgWEUucG9zdCgnc2V0dGluZ3MudXNlci5tYWlsLmRlbGV0ZScsIHsgdXNlcklkOiBfdXNlcklkLCBhZGRyZXNzOiBlbWFpbCB9KVxuICAgICAgICAudGhlbihyZXNwb25zZSA9PiB7XG4gICAgICAgICAgdmFyIGkgPSBfbWFpbHMuaW5kZXhPZihlbWFpbClcbiAgICAgICAgICBfbWFpbHMuc3BsaWNlKGksIDEpXG4gICAgICAgICAgX3RoaXMucmVuZGVyKF9tYWlscylcbiAgICAgICAgICBYRS50b2FzdCgnc3VjY2VzcycsICfsgq3soJztlZjsmIDsirXri4jri6QuJywgJy5fX3hlX2FsZXJ0RW1haWxNb2RhbCcpXG4gICAgICAgIH0pXG4gICAgICAgIC5jYXRjaChlcnJvciA9PiB7XG4gICAgICAgICAgWEUudG9hc3QoJ2RhbmdlcicsIGVycm9yLCAnLl9feGVfYWxlcnRFbWFpbE1vZGFsJylcbiAgICAgICAgfSlcbiAgICB9LFxuXG4gICAgYWRkOiBmdW5jdGlvbiAoZW1haWwpIHtcbiAgICAgIFhFLnBvc3QoJ3NldHRpbmdzLnVzZXIubWFpbC5hZGQnLCB7IHVzZXJJZDogX3VzZXJJZCwgYWRkcmVzczogZW1haWwgfSlcbiAgICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xuICAgICAgICAgIHZhciBlbWFpbCA9IHJlc3BvbnNlLmRhdGEubWFpbFxuXG4gICAgICAgICAgX21haWxzLnB1c2goZW1haWwpXG5cbiAgICAgICAgICBfdGhpcy5yZW5kZXIoX21haWxzKVxuXG4gICAgICAgICAgWEUudG9hc3QoJ3N1Y2Nlc3MnLCAn7LaU6rCA65CY7JeI7Iq164uI64ukLicsICcuX194ZV9hbGVydEVtYWlsTW9kYWwnKVxuICAgICAgICB9KVxuICAgICAgICAuY2F0Y2goZXJyb3IgPT4ge1xuICAgICAgICAgIFhFLnRvYXN0KCdkYW5nZXInLCBlcnJvciwgJy5fX3hlX2FsZXJ0RW1haWxNb2RhbCcpXG4gICAgICAgIH0pXG4gICAgfSxcblxuICAgIHJlbmRlcjogZnVuY3Rpb24gKGVtYWlscykge1xuICAgICAgdmFyIHRlbXAgPSAnJ1xuXG4gICAgICB0ZW1wICs9ICc8ZGl2PidcblxuICAgICAgaWYgKGVtYWlscy5sZW5ndGggPiAwKSB7XG4gICAgICAgIHRlbXAgKz0gJzx1bCBjbGFzcz1cImxpc3QtZ3JvdXBcIj4nXG5cbiAgICAgICAgZW1haWxzLmZvckVhY2goZnVuY3Rpb24gKGVtYWlsLCBpKSB7XG4gICAgICAgICAgdmFyIGFkZHJlc3MgPSBlbWFpbC5hZGRyZXNzXG4gICAgICAgICAgdmFyIGNoZWNrZWQgPSAoYWRkcmVzcyA9PT0gX2VtYWlsKSA/ICdjaGVja2VkPVwiY2hlY2tlZFwiJyA6ICcnXG5cbiAgICAgICAgICB0ZW1wICs9ICc8bGkgY2xhc3M9XCJsaXN0LWdyb3VwLWl0ZW0gY2xlYXJmaXhcIj4nXG4gICAgICAgICAgdGVtcCArPSAnPGxhYmVsPjxpbnB1dCB0eXBlPVwicmFkaW9cIiBuYW1lPVwiZW1haWxcIiB2YWx1ZT1cIicgKyBhZGRyZXNzICsgJ1wiICcgKyBjaGVja2VkICsgJy8+ICcgKyBhZGRyZXNzICsgJzwvbGFiZWw+J1xuXG4gICAgICAgICAgaWYgKGVtYWlsLmFkZHJlc3MgIT09IF9lbWFpbCkge1xuICAgICAgICAgICAgdGVtcCArPSAnPHNwYW4gY2xhc3M9XCJwdWxsLXJpZ2h0XCI+J1xuICAgICAgICAgICAgdGVtcCArPSAnPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0biBidG4tc20gYnRuLWxpbmsgYnRuRGVsZXRlRW1haWxcIiBzdHlsZT1cImRpc3BsYXk6IGlubGluZS1ibG9jaztcIj7sgq3soJw8L2E+J1xuICAgICAgICAgICAgdGVtcCArPSAnPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0biBidG4tc20gYnRuLWxpbmsgYnRuRGVsZXRlRW1haWxDb25maXJtXCIgc3R5bGU9XCJkaXNwbGF5OiBub25lO1wiPuyCreygnO2ZleyduDwvYT4nXG4gICAgICAgICAgICB0ZW1wICs9ICc8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuIGJ0bi1zbSBidG4tbGluayBidG5EZWxldGVFbWFpbENhbmNsZVwiIHN0eWxlPVwiZGlzcGxheTogbm9uZTtcIj7st6jshow8L2E+J1xuICAgICAgICAgICAgdGVtcCArPSAnPC9zcGFuPidcbiAgICAgICAgICB9XG5cbiAgICAgICAgICB0ZW1wICs9ICc8L2xpPidcbiAgICAgICAgfSlcblxuICAgICAgICB0ZW1wICs9ICc8L3VsPidcbiAgICAgIH1cblxuICAgICAgdGVtcCArPSAnPGRpdiBjbGFzcz1cImlucHV0LWdyb3VwIGlucHV0LWdyb3VwLXNtXCIgc3R5bGU9XCJtYXJnaW4tYm90dG9tOiAyMHB4O1wiPidcbiAgICAgIHRlbXAgKz0gJzxpbnB1dCB0eXBlPVwidGV4dFwiIGNsYXNzPVwiZm9ybS1jb250cm9sXCIgaWQ9XCJfX3hlX2FkZGVkRW1haWxJbnB1dFwiIHBsYWNlaG9sZGVyPVwi7J2066mU7J287J2EIOyeheugpe2VmOyEuOyalFwiPidcbiAgICAgIHRlbXAgKz0gJzxzcGFuIGNsYXNzPVwiaW5wdXQtZ3JvdXAtYnRuXCI+PGJ1dHRpb24gaWQ9XCJfX3hlX2VtYWlsQWRkQnRuXCIgY2xhc3M9XCJidG4gYnRuLWRlZmF1bHRcIiB0eXBlPVwiYnV0dG9uXCI+7LaU6rCAPC9idXR0aW9uPjwvc3Bhbj4nXG4gICAgICB0ZW1wICs9ICc8L2Rpdj4nXG5cbiAgICAgIF8kd3JhcHBlci5odG1sKHRlbXApXG4gICAgfVxuICB9XG59KSh3aW5kb3cuWEUsIHdpbmRvdy5qUXVlcnkpXG5cbndpbmRvdy5qUXVlcnkoZnVuY3Rpb24gKCQpIHtcbiAgJCgnLl9feGVfc2V0dGluZ0VtYWlsJykuY2xpY2soZnVuY3Rpb24gKCkge1xuICAgICQoJy5fX3hlX2VtYWlsVmlldycpLnNsaWRlVG9nZ2xlKClcbiAgICAkKCcjX194ZV9lbWFpbFNldHRpbmcnKS5zbGlkZVRvZ2dsZSgpXG4gIH0pXG5cbiAgRW1haWxCb3guaW5pdCh7XG4gICAgJHdyYXBwZXI6ICQoJyNfX3hlX2VtYWlsU2V0dGluZycpLFxuICAgIHVzZXJJZDogJCgnI19feGVfZW1haWxTZXR0aW5nJykuZGF0YSgndXNlci1pZCcpLFxuICAgIGVtYWlsOiAkKCcjX194ZV9lbWFpbFNldHRpbmcnKS5kYXRhKCdlbWFpbCcpXG4gIH0pXG59KVxuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg5MSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDI2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNzMpOyIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==