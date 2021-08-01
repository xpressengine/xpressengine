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
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/splice */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_2__);




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

      var email = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context = $this.closest('li.list-group-item')).call(_context, '[name=email]').val();

      _this.delete(email);
    });

    _$wrapper.on('click', '.btnDeleteEmailCancle', function (e) {
      var _context2;

      e.preventDefault();
      var $this = $(this);
      $this.siblings().addBack().hide();

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context2 = $this.parent()).call(_context2, '.btnDeleteEmail').show();
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

        if (!_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()($li).call($li, '> span.pull-right').length) {
          var temp = '<span class="pull-right">';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmail" style="display: inline-block;">삭제</a>';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailConfirm" style="display: none;">삭제확인</a>';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailCancle" style="display: none;">취소</a>';
          temp += '</span>';
          $li.append(temp);
        }
      });

      if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()($liWrapper).call($liWrapper, '> span.pull-right').length > 0) {
        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()($liWrapper).call($liWrapper, '> span.pull-right').remove();
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

        _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_2___default()(_mails).call(_mails, i, 1);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(5);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(69);

/***/ }),

/***/ "./node_modules/core-js/modules/web.dom-collections.for-each.js":
/*!******************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/web.dom-collections.for-each.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(58);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS91c2VyL3NldHRpbmdzL2VkaXQuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9zcGxpY2UuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL3dlYi5kb20tY29sbGVjdGlvbnMuZm9yLWVhY2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsiRW1haWxCb3giLCJYRSIsIiQiLCJfdGhpcyIsIl8kd3JhcHBlciIsIl9tYWlscyIsIl9lbWFpbCIsIl91c2VySWQiLCJfYmluZEV2ZW50cyIsIm9uIiwiZSIsInByZXZlbnREZWZhdWx0IiwiJHRoaXMiLCJjc3MiLCJkaXNwbGF5Iiwic2libGluZ3MiLCJlbWFpbCIsImNsb3Nlc3QiLCJ2YWwiLCJkZWxldGUiLCJhZGRCYWNrIiwiaGlkZSIsInBhcmVudCIsInNob3ciLCIkaW5wdXQiLCJhZGQiLCIkbGlXcmFwcGVyIiwiJHVsIiwiZWFjaCIsIiRsaSIsImxlbmd0aCIsInRlbXAiLCJhcHBlbmQiLCJyZW1vdmUiLCJwcmVwZW5kIiwiZGV0YWNoIiwiaW5pdCIsIm9wdCIsIiR3cmFwcGVyIiwidXNlcklkIiwiZ2V0RW1haWxMaXN0IiwiZ2V0IiwidGhlbiIsInJlc3BvbnNlIiwiZGF0YSIsIm1haWxzIiwicmVuZGVyIiwiY2F0Y2giLCJlcnJvciIsInRvYXN0IiwicG9zdCIsImFkZHJlc3MiLCJpIiwiaW5kZXhPZiIsIm1haWwiLCJwdXNoIiwiZW1haWxzIiwiZm9yRWFjaCIsImNoZWNrZWQiLCJodG1sIiwid2luZG93IiwialF1ZXJ5IiwiY2xpY2siLCJzbGlkZVRvZ2dsZSJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7UUFDdkQsaUNBQWlDLGVBQWU7UUFDaEQ7UUFDQTtRQUNBOztRQUVBO1FBQ0Esc0RBQXNELCtEQUErRDs7UUFFckg7UUFDQTs7O1FBR0E7UUFDQTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDbEZBLElBQUlBLFFBQVEsR0FBSSxVQUFVQyxFQUFWLEVBQWNDLENBQWQsRUFBaUI7QUFDL0IsTUFBSUMsS0FBSjs7QUFDQSxNQUFJQyxTQUFTLEdBQUdGLENBQUMsRUFBakI7O0FBQ0EsTUFBSUcsTUFBTSxHQUFHLEVBQWI7QUFDQSxNQUFJQyxNQUFNLEdBQUcsRUFBYjtBQUNBLE1BQUlDLE9BQU8sR0FBRyxFQUFkOztBQUVBLE1BQUlDLFdBQVcsR0FBRyxTQUFkQSxXQUFj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QUFDWkUsWUFBUSxFQUFFcEMsQ0FBQyxDQUFDLG9CQUFELENBREM7QUFFWnFDLFVBQU0sRUFBRXJDLENBQUMsQ0FBQyxvQkFBRCxDQUFELENBQXdCMEMsSUFBeEIsQ0FBNkIsU0FBN0IsQ0FGSTtBQUdaNUIsU0FBSyxFQUFFZCxDQUFDLENBQUMsb0JBQUQsQ0FBRCxDQUF3QjBDLElBQXhCLENBQTZCLE9BQTdCO0FBSEssR0FBZDtBQUtELENBWEQsRTs7Ozs7Ozs7Ozs7QUNwS0EsOEc7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsZ0MiLCJmaWxlIjoiYXNzZXRzL2NvcmUvdXNlci9zZXR0aW5ncy9lZGl0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL3VzZXIvc2V0dGluZ3MvZWRpdC5qc1wiKTtcbiIsInZhciBFbWFpbEJveCA9IChmdW5jdGlvbiAoWEUsICQpIHtcbiAgdmFyIF90aGlzXG4gIHZhciBfJHdyYXBwZXIgPSAkKClcbiAgdmFyIF9tYWlscyA9IFtdXG4gIHZhciBfZW1haWwgPSAnJ1xuICB2YXIgX3VzZXJJZCA9ICcnXG5cbiAgdmFyIF9iaW5kRXZlbnRzID0gZnVuY3Rpb24gKCkge1xuICAgIF8kd3JhcHBlci5vbignY2xpY2snLCAnLmJ0bkRlbGV0ZUVtYWlsJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG5cbiAgICAgICR0aGlzLmNzcyh7IGRpc3BsYXk6ICdub25lJyB9KS5zaWJsaW5ncygpLmNzcyh7IGRpc3BsYXk6ICdpbmxpbmUtYmxvY2snIH0pXG4gICAgfSlcblxuICAgIF8kd3JhcHBlci5vbignY2xpY2snLCAnLmJ0bkRlbGV0ZUVtYWlsQ29uZmlybScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KClcblxuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyIGVtYWlsID0gJHRoaXMuY2xvc2VzdCgnbGkubGlzdC1ncm91cC1pdGVtJykuZmluZCgnW25hbWU9ZW1haWxdJykudmFsKClcblxuICAgICAgX3RoaXMuZGVsZXRlKGVtYWlsKVxuICAgIH0pXG5cbiAgICBfJHdyYXBwZXIub24oJ2NsaWNrJywgJy5idG5EZWxldGVFbWFpbENhbmNsZScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KClcblxuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuXG4gICAgICAkdGhpcy5zaWJsaW5ncygpLmFkZEJhY2soKS5oaWRlKClcbiAgICAgICR0aGlzLnBhcmVudCgpLmZpbmQoJy5idG5EZWxldGVFbWFpbCcpLnNob3coKVxuICAgIH0pXG5cbiAgICBfJHdyYXBwZXIub24oJ2NsaWNrJywgJyNfX3hlX2VtYWlsQWRkQnRuJywgZnVuY3Rpb24gKCkge1xuICAgICAgdmFyICRpbnB1dCA9ICQoJyNfX3hlX2FkZGVkRW1haWxJbnB1dCcpXG4gICAgICB2YXIgZW1haWwgPSAkaW5wdXQudmFsKClcbiAgICAgIGlmICghZW1haWwpIHtcbiAgICAgICAgcmV0dXJuXG4gICAgICB9XG5cbiAgICAgICRpbnB1dC52YWwoJycpXG5cbiAgICAgIF90aGlzLmFkZChlbWFpbClcbiAgICB9KVxuXG4gICAgXyR3cmFwcGVyLm9uKCdjaGFuZ2UnLCAnW25hbWU9ZW1haWxdJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgIHZhciAkbGlXcmFwcGVyID0gJHRoaXMuY2xvc2VzdCgnbGkubGlzdC1ncm91cC1pdGVtJylcbiAgICAgIHZhciAkdWwgPSAkbGlXcmFwcGVyLmNsb3Nlc3QoJ3VsJylcblxuICAgICAgJGxpV3JhcHBlci5zaWJsaW5ncygpLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgJGxpID0gJCh0aGlzKVxuXG4gICAgICAgIGlmICghJGxpLmZpbmQoJz4gc3Bhbi5wdWxsLXJpZ2h0JykubGVuZ3RoKSB7XG4gICAgICAgICAgdmFyIHRlbXAgPSAnPHNwYW4gY2xhc3M9XCJwdWxsLXJpZ2h0XCI+J1xuICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsXCIgc3R5bGU9XCJkaXNwbGF5OiBpbmxpbmUtYmxvY2s7XCI+7IKt7KCcPC9hPidcbiAgICAgICAgICB0ZW1wICs9ICc8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuIGJ0bi1zbSBidG4tbGluayBidG5EZWxldGVFbWFpbENvbmZpcm1cIiBzdHlsZT1cImRpc3BsYXk6IG5vbmU7XCI+7IKt7KCc7ZmV7J24PC9hPidcbiAgICAgICAgICB0ZW1wICs9ICc8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuIGJ0bi1zbSBidG4tbGluayBidG5EZWxldGVFbWFpbENhbmNsZVwiIHN0eWxlPVwiZGlzcGxheTogbm9uZTtcIj7st6jshow8L2E+J1xuICAgICAgICAgIHRlbXAgKz0gJzwvc3Bhbj4nXG5cbiAgICAgICAgICAkbGkuYXBwZW5kKHRlbXApXG4gICAgICAgIH1cbiAgICAgIH0pXG5cbiAgICAgIGlmICgkbGlXcmFwcGVyLmZpbmQoJz4gc3Bhbi5wdWxsLXJpZ2h0JykubGVuZ3RoID4gMCkge1xuICAgICAgICAkbGlXcmFwcGVyLmZpbmQoJz4gc3Bhbi5wdWxsLXJpZ2h0JykucmVtb3ZlKClcbiAgICAgIH1cblxuICAgICAgJHVsLnByZXBlbmQoJGxpV3JhcHBlci5kZXRhY2goKSlcbiAgICB9KVxuICB9XG5cbiAgcmV0dXJuIHtcbiAgICBpbml0OiBmdW5jdGlvbiAob3B0KSB7XG4gICAgICBfdGhpcyA9IHRoaXNcbiAgICAgIF8kd3JhcHBlciA9IG9wdC4kd3JhcHBlclxuICAgICAgX2VtYWlsID0gb3B0LmVtYWlsXG4gICAgICBfdXNlcklkID0gb3B0LnVzZXJJZFxuXG4gICAgICBfYmluZEV2ZW50cygpXG5cbiAgICAgIF90aGlzLmdldEVtYWlsTGlzdCgpXG5cbiAgICAgIHJldHVybiB0aGlzXG4gICAgfSxcblxuICAgIGdldEVtYWlsTGlzdDogZnVuY3Rpb24gKCkge1xuICAgICAgWEUuZ2V0KCdzZXR0aW5ncy51c2VyLm1haWwubGlzdCcsIHsgdXNlcklkOiBfdXNlcklkIH0pLnRoZW4oKHJlc3BvbnNlKSA9PiB7XG4gICAgICAgIF9tYWlscyA9IHJlc3BvbnNlLmRhdGEubWFpbHNcbiAgICAgICAgX3RoaXMucmVuZGVyKHJlc3BvbnNlLmRhdGEubWFpbHMpXG4gICAgICB9KS5jYXRjaCgoZXJyb3IpID0+IHtcbiAgICAgICAgWEUudG9hc3QoJ2RhbmdlcicsIGVycm9yLCAnLl9feGVfYWxlcnRFbWFpbE1vZGFsJylcbiAgICAgIH0pXG4gICAgfSxcblxuICAgIGRlbGV0ZTogZnVuY3Rpb24gKGVtYWlsKSB7XG4gICAgICBYRS5wb3N0KCdzZXR0aW5ncy51c2VyLm1haWwuZGVsZXRlJywgeyB1c2VySWQ6IF91c2VySWQsIGFkZHJlc3M6IGVtYWlsIH0pXG4gICAgICAgIC50aGVuKHJlc3BvbnNlID0+IHtcbiAgICAgICAgICB2YXIgaSA9IF9tYWlscy5pbmRleE9mKGVtYWlsKVxuICAgICAgICAgIF9tYWlscy5zcGxpY2UoaSwgMSlcbiAgICAgICAgICBfdGhpcy5yZW5kZXIoX21haWxzKVxuICAgICAgICAgIFhFLnRvYXN0KCdzdWNjZXNzJywgJ+yCreygnO2VmOyYgOyKteuLiOuLpC4nLCAnLl9feGVfYWxlcnRFbWFpbE1vZGFsJylcbiAgICAgICAgfSlcbiAgICAgICAgLmNhdGNoKGVycm9yID0+IHtcbiAgICAgICAgICBYRS50b2FzdCgnZGFuZ2VyJywgZXJyb3IsICcuX194ZV9hbGVydEVtYWlsTW9kYWwnKVxuICAgICAgICB9KVxuICAgIH0sXG5cbiAgICBhZGQ6IGZ1bmN0aW9uIChlbWFpbCkge1xuICAgICAgWEUucG9zdCgnc2V0dGluZ3MudXNlci5tYWlsLmFkZCcsIHsgdXNlcklkOiBfdXNlcklkLCBhZGRyZXNzOiBlbWFpbCB9KVxuICAgICAgICAudGhlbihyZXNwb25zZSA9PiB7XG4gICAgICAgICAgdmFyIGVtYWlsID0gcmVzcG9uc2UuZGF0YS5tYWlsXG5cbiAgICAgICAgICBfbWFpbHMucHVzaChlbWFpbClcblxuICAgICAgICAgIF90aGlzLnJlbmRlcihfbWFpbHMpXG5cbiAgICAgICAgICBYRS50b2FzdCgnc3VjY2VzcycsICfstpTqsIDrkJjsl4jsirXri4jri6QuJywgJy5fX3hlX2FsZXJ0RW1haWxNb2RhbCcpXG4gICAgICAgIH0pXG4gICAgICAgIC5jYXRjaChlcnJvciA9PiB7XG4gICAgICAgICAgWEUudG9hc3QoJ2RhbmdlcicsIGVycm9yLCAnLl9feGVfYWxlcnRFbWFpbE1vZGFsJylcbiAgICAgICAgfSlcbiAgICB9LFxuXG4gICAgcmVuZGVyOiBmdW5jdGlvbiAoZW1haWxzKSB7XG4gICAgICB2YXIgdGVtcCA9ICcnXG5cbiAgICAgIHRlbXAgKz0gJzxkaXY+J1xuXG4gICAgICBpZiAoZW1haWxzLmxlbmd0aCA+IDApIHtcbiAgICAgICAgdGVtcCArPSAnPHVsIGNsYXNzPVwibGlzdC1ncm91cFwiPidcblxuICAgICAgICBlbWFpbHMuZm9yRWFjaChmdW5jdGlvbiAoZW1haWwsIGkpIHtcbiAgICAgICAgICB2YXIgYWRkcmVzcyA9IGVtYWlsLmFkZHJlc3NcbiAgICAgICAgICB2YXIgY2hlY2tlZCA9IChhZGRyZXNzID09PSBfZW1haWwpID8gJ2NoZWNrZWQ9XCJjaGVja2VkXCInIDogJydcblxuICAgICAgICAgIHRlbXAgKz0gJzxsaSBjbGFzcz1cImxpc3QtZ3JvdXAtaXRlbSBjbGVhcmZpeFwiPidcbiAgICAgICAgICB0ZW1wICs9ICc8bGFiZWw+PGlucHV0IHR5cGU9XCJyYWRpb1wiIG5hbWU9XCJlbWFpbFwiIHZhbHVlPVwiJyArIGFkZHJlc3MgKyAnXCIgJyArIGNoZWNrZWQgKyAnLz4gJyArIGFkZHJlc3MgKyAnPC9sYWJlbD4nXG5cbiAgICAgICAgICBpZiAoZW1haWwuYWRkcmVzcyAhPT0gX2VtYWlsKSB7XG4gICAgICAgICAgICB0ZW1wICs9ICc8c3BhbiBjbGFzcz1cInB1bGwtcmlnaHRcIj4nXG4gICAgICAgICAgICB0ZW1wICs9ICc8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuIGJ0bi1zbSBidG4tbGluayBidG5EZWxldGVFbWFpbFwiIHN0eWxlPVwiZGlzcGxheTogaW5saW5lLWJsb2NrO1wiPuyCreygnDwvYT4nXG4gICAgICAgICAgICB0ZW1wICs9ICc8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuIGJ0bi1zbSBidG4tbGluayBidG5EZWxldGVFbWFpbENvbmZpcm1cIiBzdHlsZT1cImRpc3BsYXk6IG5vbmU7XCI+7IKt7KCc7ZmV7J24PC9hPidcbiAgICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsQ2FuY2xlXCIgc3R5bGU9XCJkaXNwbGF5OiBub25lO1wiPuy3qOyGjDwvYT4nXG4gICAgICAgICAgICB0ZW1wICs9ICc8L3NwYW4+J1xuICAgICAgICAgIH1cblxuICAgICAgICAgIHRlbXAgKz0gJzwvbGk+J1xuICAgICAgICB9KVxuXG4gICAgICAgIHRlbXAgKz0gJzwvdWw+J1xuICAgICAgfVxuXG4gICAgICB0ZW1wICs9ICc8ZGl2IGNsYXNzPVwiaW5wdXQtZ3JvdXAgaW5wdXQtZ3JvdXAtc21cIiBzdHlsZT1cIm1hcmdpbi1ib3R0b206IDIwcHg7XCI+J1xuICAgICAgdGVtcCArPSAnPGlucHV0IHR5cGU9XCJ0ZXh0XCIgY2xhc3M9XCJmb3JtLWNvbnRyb2xcIiBpZD1cIl9feGVfYWRkZWRFbWFpbElucHV0XCIgcGxhY2Vob2xkZXI9XCLsnbTrqZTsnbzsnYQg7J6F66Cl7ZWY7IS47JqUXCI+J1xuICAgICAgdGVtcCArPSAnPHNwYW4gY2xhc3M9XCJpbnB1dC1ncm91cC1idG5cIj48YnV0dGlvbiBpZD1cIl9feGVfZW1haWxBZGRCdG5cIiBjbGFzcz1cImJ0biBidG4tZGVmYXVsdFwiIHR5cGU9XCJidXR0b25cIj7stpTqsIA8L2J1dHRpb24+PC9zcGFuPidcbiAgICAgIHRlbXAgKz0gJzwvZGl2PidcblxuICAgICAgXyR3cmFwcGVyLmh0bWwodGVtcClcbiAgICB9XG4gIH1cbn0pKHdpbmRvdy5YRSwgd2luZG93LmpRdWVyeSlcblxud2luZG93LmpRdWVyeShmdW5jdGlvbiAoJCkge1xuICAkKCcuX194ZV9zZXR0aW5nRW1haWwnKS5jbGljayhmdW5jdGlvbiAoKSB7XG4gICAgJCgnLl9feGVfZW1haWxWaWV3Jykuc2xpZGVUb2dnbGUoKVxuICAgICQoJyNfX3hlX2VtYWlsU2V0dGluZycpLnNsaWRlVG9nZ2xlKClcbiAgfSlcblxuICBFbWFpbEJveC5pbml0KHtcbiAgICAkd3JhcHBlcjogJCgnI19feGVfZW1haWxTZXR0aW5nJyksXG4gICAgdXNlcklkOiAkKCcjX194ZV9lbWFpbFNldHRpbmcnKS5kYXRhKCd1c2VyLWlkJyksXG4gICAgZW1haWw6ICQoJyNfX3hlX2VtYWlsU2V0dGluZycpLmRhdGEoJ2VtYWlsJylcbiAgfSlcbn0pXG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDY5KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNTgpOyIsIm1vZHVsZS5leHBvcnRzID0gX3hlX2RsbF9jb21tb247Il0sInNvdXJjZVJvb3QiOiIifQ==