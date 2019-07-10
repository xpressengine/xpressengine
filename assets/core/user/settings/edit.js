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
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/for-each */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/splice */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/index-of */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3__);





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

      var email = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()(_context = $this.closest('li.list-group-item')).call(_context, '[name=email]').val();

      _this.delete(email);
    });

    _$wrapper.on('click', '.btnDeleteEmailCancle', function (e) {
      var _context2;

      e.preventDefault();
      var $this = $(this);
      $this.siblings().addBack().hide();

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()(_context2 = $this.parent()).call(_context2, '.btnDeleteEmail').show();
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

        if (!_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()($li).call($li, '> span.pull-right').length) {
          var temp = '<span class="pull-right">';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmail" style="display: inline-block;">삭제</a>';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailConfirm" style="display: none;">삭제확인</a>';
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailCancle" style="display: none;">취소</a>';
          temp += '</span>';
          $li.append(temp);
        }
      });

      if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()($liWrapper).call($liWrapper, '> span.pull-right').length > 0) {
        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()($liWrapper).call($liWrapper, '> span.pull-right').remove();
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
        var i = _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2___default()(_mails).call(_mails, email);

        _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1___default()(_mails).call(_mails, i, 1);

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

        _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0___default()(emails).call(emails, function (email, i) {
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

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(18);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(13);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(54);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS91c2VyL3NldHRpbmdzL2VkaXQuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9mb3ItZWFjaC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2luZGV4LW9mLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2Uvc3BsaWNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZXh0ZXJuYWwgXCJfeGVfZGxsX2NvbW1vblwiIl0sIm5hbWVzIjpbIkVtYWlsQm94IiwiWEUiLCIkIiwiX3RoaXMiLCJfJHdyYXBwZXIiLCJfbWFpbHMiLCJfZW1haWwiLCJfdXNlcklkIiwiX2JpbmRFdmVudHMiLCJvbiIsImUiLCJwcmV2ZW50RGVmYXVsdCIsIiR0aGlzIiwiY3NzIiwiZGlzcGxheSIsInNpYmxpbmdzIiwiZW1haWwiLCJjbG9zZXN0IiwidmFsIiwiZGVsZXRlIiwiYWRkQmFjayIsImhpZGUiLCJwYXJlbnQiLCJzaG93IiwiJGlucHV0IiwiYWRkIiwiJGxpV3JhcHBlciIsIiR1bCIsImVhY2giLCIkbGkiLCJsZW5ndGgiLCJ0ZW1wIiwiYXBwZW5kIiwicmVtb3ZlIiwicHJlcGVuZCIsImRldGFjaCIsImluaXQiLCJvcHQiLCIkd3JhcHBlciIsInVzZXJJZCIsImdldEVtYWlsTGlzdCIsImdldCIsInRoZW4iLCJyZXNwb25zZSIsImRhdGEiLCJtYWlscyIsInJlbmRlciIsImNhdGNoIiwiZXJyb3IiLCJ0b2FzdCIsInBvc3QiLCJhZGRyZXNzIiwiaSIsIm1haWwiLCJwdXNoIiwiZW1haWxzIiwiY2hlY2tlZCIsImh0bWwiLCJ3aW5kb3ciLCJqUXVlcnkiLCJjbGljayIsInNsaWRlVG9nZ2xlIl0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7OztBQUdBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxrREFBMEMsZ0NBQWdDO0FBQzFFO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsZ0VBQXdELGtCQUFrQjtBQUMxRTtBQUNBLHlEQUFpRCxjQUFjO0FBQy9EOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpREFBeUMsaUNBQWlDO0FBQzFFLHdIQUFnSCxtQkFBbUIsRUFBRTtBQUNySTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLG1DQUEyQiwwQkFBMEIsRUFBRTtBQUN2RCx5Q0FBaUMsZUFBZTtBQUNoRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQSw4REFBc0QsK0RBQStEOztBQUVySDtBQUNBOzs7QUFHQTtBQUNBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNsRkEsSUFBSUEsUUFBUSxHQUFJLFVBQVVDLEVBQVYsRUFBY0MsQ0FBZCxFQUFpQjtBQUMvQixNQUFJQyxLQUFKOztBQUNBLE1BQUlDLFNBQVMsR0FB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QUQsQ0FBd0IwRCxLQUF4QixDQUE4QixZQUFZO0FBQ3hDMUQsS0FBQyxDQUFDLGlCQUFELENBQUQsQ0FBcUIyRCxXQUFyQjtBQUNBM0QsS0FBQyxDQUFDLG9CQUFELENBQUQsQ0FBd0IyRCxXQUF4QjtBQUNELEdBSEQ7QUFLQTdELFVBQVEsQ0FBQ29DLElBQVQsQ0FBYztBQUNaRSxZQUFRLEVBQUVwQyxDQUFDLENBQUMsb0JBQUQsQ0FEQztBQUVacUMsVUFBTSxFQUFFckMsQ0FBQyxDQUFDLG9CQUFELENBQUQsQ0FBd0IwQyxJQUF4QixDQUE2QixTQUE3QixDQUZJO0FBR1o1QixTQUFLLEVBQUVkLENBQUMsQ0FBQyxvQkFBRCxDQUFELENBQXdCMEMsSUFBeEIsQ0FBNkIsT0FBN0I7QUFISyxHQUFkO0FBS0QsQ0FYRCxFOzs7Ozs7Ozs7OztBQ3BLQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS91c2VyL3NldHRpbmdzL2VkaXQuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIlwiO1xuXG5cbiBcdC8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuIFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oX193ZWJwYWNrX3JlcXVpcmVfXy5zID0gXCIuL2NvcmUvdXNlci9zZXR0aW5ncy9lZGl0LmpzXCIpO1xuIiwidmFyIEVtYWlsQm94ID0gKGZ1bmN0aW9uIChYRSwgJCkge1xuICB2YXIgX3RoaXNcbiAgdmFyIF8kd3JhcHBlciA9ICQoKVxuICB2YXIgX21haWxzID0gW11cbiAgdmFyIF9lbWFpbCA9ICcnXG4gIHZhciBfdXNlcklkID0gJydcblxuICB2YXIgX2JpbmRFdmVudHMgPSBmdW5jdGlvbiAoKSB7XG4gICAgXyR3cmFwcGVyLm9uKCdjbGljaycsICcuYnRuRGVsZXRlRW1haWwnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcblxuICAgICAgJHRoaXMuY3NzKHsgZGlzcGxheTogJ25vbmUnIH0pLnNpYmxpbmdzKCkuY3NzKHsgZGlzcGxheTogJ2lubGluZS1ibG9jaycgfSlcbiAgICB9KVxuXG4gICAgXyR3cmFwcGVyLm9uKCdjbGljaycsICcuYnRuRGVsZXRlRW1haWxDb25maXJtJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIgZW1haWwgPSAkdGhpcy5jbG9zZXN0KCdsaS5saXN0LWdyb3VwLWl0ZW0nKS5maW5kKCdbbmFtZT1lbWFpbF0nKS52YWwoKVxuXG4gICAgICBfdGhpcy5kZWxldGUoZW1haWwpXG4gICAgfSlcblxuICAgIF8kd3JhcHBlci5vbignY2xpY2snLCAnLmJ0bkRlbGV0ZUVtYWlsQ2FuY2xlJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG5cbiAgICAgICR0aGlzLnNpYmxpbmdzKCkuYWRkQmFjaygpLmhpZGUoKVxuICAgICAgJHRoaXMucGFyZW50KCkuZmluZCgnLmJ0bkRlbGV0ZUVtYWlsJykuc2hvdygpXG4gICAgfSlcblxuICAgIF8kd3JhcHBlci5vbignY2xpY2snLCAnI19feGVfZW1haWxBZGRCdG4nLCBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJGlucHV0ID0gJCgnI19feGVfYWRkZWRFbWFpbElucHV0JylcbiAgICAgIHZhciBlbWFpbCA9ICRpbnB1dC52YWwoKVxuICAgICAgaWYgKCFlbWFpbCkge1xuICAgICAgICByZXR1cm5cbiAgICAgIH1cblxuICAgICAgJGlucHV0LnZhbCgnJylcblxuICAgICAgX3RoaXMuYWRkKGVtYWlsKVxuICAgIH0pXG5cbiAgICBfJHdyYXBwZXIub24oJ2NoYW5nZScsICdbbmFtZT1lbWFpbF0nLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyICRsaVdyYXBwZXIgPSAkdGhpcy5jbG9zZXN0KCdsaS5saXN0LWdyb3VwLWl0ZW0nKVxuICAgICAgdmFyICR1bCA9ICRsaVdyYXBwZXIuY2xvc2VzdCgndWwnKVxuXG4gICAgICAkbGlXcmFwcGVyLnNpYmxpbmdzKCkuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciAkbGkgPSAkKHRoaXMpXG5cbiAgICAgICAgaWYgKCEkbGkuZmluZCgnPiBzcGFuLnB1bGwtcmlnaHQnKS5sZW5ndGgpIHtcbiAgICAgICAgICB2YXIgdGVtcCA9ICc8c3BhbiBjbGFzcz1cInB1bGwtcmlnaHRcIj4nXG4gICAgICAgICAgdGVtcCArPSAnPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0biBidG4tc20gYnRuLWxpbmsgYnRuRGVsZXRlRW1haWxcIiBzdHlsZT1cImRpc3BsYXk6IGlubGluZS1ibG9jaztcIj7sgq3soJw8L2E+J1xuICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsQ29uZmlybVwiIHN0eWxlPVwiZGlzcGxheTogbm9uZTtcIj7sgq3soJztmZXsnbg8L2E+J1xuICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsQ2FuY2xlXCIgc3R5bGU9XCJkaXNwbGF5OiBub25lO1wiPuy3qOyGjDwvYT4nXG4gICAgICAgICAgdGVtcCArPSAnPC9zcGFuPidcblxuICAgICAgICAgICRsaS5hcHBlbmQodGVtcClcbiAgICAgICAgfVxuICAgICAgfSlcblxuICAgICAgaWYgKCRsaVdyYXBwZXIuZmluZCgnPiBzcGFuLnB1bGwtcmlnaHQnKS5sZW5ndGggPiAwKSB7XG4gICAgICAgICRsaVdyYXBwZXIuZmluZCgnPiBzcGFuLnB1bGwtcmlnaHQnKS5yZW1vdmUoKVxuICAgICAgfVxuXG4gICAgICAkdWwucHJlcGVuZCgkbGlXcmFwcGVyLmRldGFjaCgpKVxuICAgIH0pXG4gIH1cblxuICByZXR1cm4ge1xuICAgIGluaXQ6IGZ1bmN0aW9uIChvcHQpIHtcbiAgICAgIF90aGlzID0gdGhpc1xuICAgICAgXyR3cmFwcGVyID0gb3B0LiR3cmFwcGVyXG4gICAgICBfZW1haWwgPSBvcHQuZW1haWxcbiAgICAgIF91c2VySWQgPSBvcHQudXNlcklkXG5cbiAgICAgIF9iaW5kRXZlbnRzKClcblxuICAgICAgX3RoaXMuZ2V0RW1haWxMaXN0KClcblxuICAgICAgcmV0dXJuIHRoaXNcbiAgICB9LFxuXG4gICAgZ2V0RW1haWxMaXN0OiBmdW5jdGlvbiAoKSB7XG4gICAgICBYRS5nZXQoJ3NldHRpbmdzLnVzZXIubWFpbC5saXN0JywgeyB1c2VySWQ6IF91c2VySWQgfSkudGhlbigocmVzcG9uc2UpID0+IHtcbiAgICAgICAgX21haWxzID0gcmVzcG9uc2UuZGF0YS5tYWlsc1xuICAgICAgICBfdGhpcy5yZW5kZXIocmVzcG9uc2UuZGF0YS5tYWlscylcbiAgICAgIH0pLmNhdGNoKChlcnJvcikgPT4ge1xuICAgICAgICBYRS50b2FzdCgnZGFuZ2VyJywgZXJyb3IsICcuX194ZV9hbGVydEVtYWlsTW9kYWwnKVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgZGVsZXRlOiBmdW5jdGlvbiAoZW1haWwpIHtcbiAgICAgIFhFLnBvc3QoJ3NldHRpbmdzLnVzZXIubWFpbC5kZWxldGUnLCB7IHVzZXJJZDogX3VzZXJJZCwgYWRkcmVzczogZW1haWwgfSlcbiAgICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xuICAgICAgICAgIHZhciBpID0gX21haWxzLmluZGV4T2YoZW1haWwpXG4gICAgICAgICAgX21haWxzLnNwbGljZShpLCAxKVxuICAgICAgICAgIF90aGlzLnJlbmRlcihfbWFpbHMpXG4gICAgICAgICAgWEUudG9hc3QoJ3N1Y2Nlc3MnLCAn7IKt7KCc7ZWY7JiA7Iq164uI64ukLicsICcuX194ZV9hbGVydEVtYWlsTW9kYWwnKVxuICAgICAgICB9KVxuICAgICAgICAuY2F0Y2goZXJyb3IgPT4ge1xuICAgICAgICAgIFhFLnRvYXN0KCdkYW5nZXInLCBlcnJvciwgJy5fX3hlX2FsZXJ0RW1haWxNb2RhbCcpXG4gICAgICAgIH0pXG4gICAgfSxcblxuICAgIGFkZDogZnVuY3Rpb24gKGVtYWlsKSB7XG4gICAgICBYRS5wb3N0KCdzZXR0aW5ncy51c2VyLm1haWwuYWRkJywgeyB1c2VySWQ6IF91c2VySWQsIGFkZHJlc3M6IGVtYWlsIH0pXG4gICAgICAgIC50aGVuKHJlc3BvbnNlID0+IHtcbiAgICAgICAgICB2YXIgZW1haWwgPSByZXNwb25zZS5kYXRhLm1haWxcblxuICAgICAgICAgIF9tYWlscy5wdXNoKGVtYWlsKVxuXG4gICAgICAgICAgX3RoaXMucmVuZGVyKF9tYWlscylcblxuICAgICAgICAgIFhFLnRvYXN0KCdzdWNjZXNzJywgJ+y2lOqwgOuQmOyXiOyKteuLiOuLpC4nLCAnLl9feGVfYWxlcnRFbWFpbE1vZGFsJylcbiAgICAgICAgfSlcbiAgICAgICAgLmNhdGNoKGVycm9yID0+IHtcbiAgICAgICAgICBYRS50b2FzdCgnZGFuZ2VyJywgZXJyb3IsICcuX194ZV9hbGVydEVtYWlsTW9kYWwnKVxuICAgICAgICB9KVxuICAgIH0sXG5cbiAgICByZW5kZXI6IGZ1bmN0aW9uIChlbWFpbHMpIHtcbiAgICAgIHZhciB0ZW1wID0gJydcblxuICAgICAgdGVtcCArPSAnPGRpdj4nXG5cbiAgICAgIGlmIChlbWFpbHMubGVuZ3RoID4gMCkge1xuICAgICAgICB0ZW1wICs9ICc8dWwgY2xhc3M9XCJsaXN0LWdyb3VwXCI+J1xuXG4gICAgICAgIGVtYWlscy5mb3JFYWNoKGZ1bmN0aW9uIChlbWFpbCwgaSkge1xuICAgICAgICAgIHZhciBhZGRyZXNzID0gZW1haWwuYWRkcmVzc1xuICAgICAgICAgIHZhciBjaGVja2VkID0gKGFkZHJlc3MgPT09IF9lbWFpbCkgPyAnY2hlY2tlZD1cImNoZWNrZWRcIicgOiAnJ1xuXG4gICAgICAgICAgdGVtcCArPSAnPGxpIGNsYXNzPVwibGlzdC1ncm91cC1pdGVtIGNsZWFyZml4XCI+J1xuICAgICAgICAgIHRlbXAgKz0gJzxsYWJlbD48aW5wdXQgdHlwZT1cInJhZGlvXCIgbmFtZT1cImVtYWlsXCIgdmFsdWU9XCInICsgYWRkcmVzcyArICdcIiAnICsgY2hlY2tlZCArICcvPiAnICsgYWRkcmVzcyArICc8L2xhYmVsPidcblxuICAgICAgICAgIGlmIChlbWFpbC5hZGRyZXNzICE9PSBfZW1haWwpIHtcbiAgICAgICAgICAgIHRlbXAgKz0gJzxzcGFuIGNsYXNzPVwicHVsbC1yaWdodFwiPidcbiAgICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsXCIgc3R5bGU9XCJkaXNwbGF5OiBpbmxpbmUtYmxvY2s7XCI+7IKt7KCcPC9hPidcbiAgICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsQ29uZmlybVwiIHN0eWxlPVwiZGlzcGxheTogbm9uZTtcIj7sgq3soJztmZXsnbg8L2E+J1xuICAgICAgICAgICAgdGVtcCArPSAnPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0biBidG4tc20gYnRuLWxpbmsgYnRuRGVsZXRlRW1haWxDYW5jbGVcIiBzdHlsZT1cImRpc3BsYXk6IG5vbmU7XCI+7Leo7IaMPC9hPidcbiAgICAgICAgICAgIHRlbXAgKz0gJzwvc3Bhbj4nXG4gICAgICAgICAgfVxuXG4gICAgICAgICAgdGVtcCArPSAnPC9saT4nXG4gICAgICAgIH0pXG5cbiAgICAgICAgdGVtcCArPSAnPC91bD4nXG4gICAgICB9XG5cbiAgICAgIHRlbXAgKz0gJzxkaXYgY2xhc3M9XCJpbnB1dC1ncm91cCBpbnB1dC1ncm91cC1zbVwiIHN0eWxlPVwibWFyZ2luLWJvdHRvbTogMjBweDtcIj4nXG4gICAgICB0ZW1wICs9ICc8aW5wdXQgdHlwZT1cInRleHRcIiBjbGFzcz1cImZvcm0tY29udHJvbFwiIGlkPVwiX194ZV9hZGRlZEVtYWlsSW5wdXRcIiBwbGFjZWhvbGRlcj1cIuydtOuplOydvOydhCDsnoXroKXtlZjshLjsmpRcIj4nXG4gICAgICB0ZW1wICs9ICc8c3BhbiBjbGFzcz1cImlucHV0LWdyb3VwLWJ0blwiPjxidXR0aW9uIGlkPVwiX194ZV9lbWFpbEFkZEJ0blwiIGNsYXNzPVwiYnRuIGJ0bi1kZWZhdWx0XCIgdHlwZT1cImJ1dHRvblwiPuy2lOqwgDwvYnV0dGlvbj48L3NwYW4+J1xuICAgICAgdGVtcCArPSAnPC9kaXY+J1xuXG4gICAgICBfJHdyYXBwZXIuaHRtbCh0ZW1wKVxuICAgIH1cbiAgfVxufSkod2luZG93LlhFLCB3aW5kb3cualF1ZXJ5KVxuXG53aW5kb3cualF1ZXJ5KGZ1bmN0aW9uICgkKSB7XG4gICQoJy5fX3hlX3NldHRpbmdFbWFpbCcpLmNsaWNrKGZ1bmN0aW9uICgpIHtcbiAgICAkKCcuX194ZV9lbWFpbFZpZXcnKS5zbGlkZVRvZ2dsZSgpXG4gICAgJCgnI19feGVfZW1haWxTZXR0aW5nJykuc2xpZGVUb2dnbGUoKVxuICB9KVxuXG4gIEVtYWlsQm94LmluaXQoe1xuICAgICR3cmFwcGVyOiAkKCcjX194ZV9lbWFpbFNldHRpbmcnKSxcbiAgICB1c2VySWQ6ICQoJyNfX3hlX2VtYWlsU2V0dGluZycpLmRhdGEoJ3VzZXItaWQnKSxcbiAgICBlbWFpbDogJCgnI19feGVfZW1haWxTZXR0aW5nJykuZGF0YSgnZW1haWwnKVxuICB9KVxufSlcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTgpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxMyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDU0KTsiLCJtb2R1bGUuZXhwb3J0cyA9IF94ZV9kbGxfY29tbW9uOyJdLCJzb3VyY2VSb290IjoiIn0=