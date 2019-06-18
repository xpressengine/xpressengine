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
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/for-each */ \"./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js\");\n/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/splice */ \"./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js\");\n/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/index-of */ \"./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js\");\n/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ \"./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js\");\n/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3__);\n\n\n\n\n\nvar EmailBox = function (XE, $) {\n  var _this;\n\n  var _$wrapper = $();\n\n  var _mails = [];\n  var _email = '';\n  var _userId = '';\n\n  var _bindEvents = function _bindEvents() {\n    _$wrapper.on('click', '.btnDeleteEmail', function (e) {\n      e.preventDefault();\n      var $this = $(this);\n      $this.css({\n        display: 'none'\n      }).siblings().css({\n        display: 'inline-block'\n      });\n    });\n\n    _$wrapper.on('click', '.btnDeleteEmailConfirm', function (e) {\n      var _context;\n\n      e.preventDefault();\n      var $this = $(this);\n\n      var email = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()(_context = $this.closest('li.list-group-item')).call(_context, '[name=email]').val();\n\n      _this.delete(email);\n    });\n\n    _$wrapper.on('click', '.btnDeleteEmailCancle', function (e) {\n      var _context2;\n\n      e.preventDefault();\n      var $this = $(this);\n      $this.siblings().addBack().hide();\n\n      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()(_context2 = $this.parent()).call(_context2, '.btnDeleteEmail').show();\n    });\n\n    _$wrapper.on('click', '#__xe_emailAddBtn', function () {\n      var $input = $('#__xe_addedEmailInput');\n      var email = $input.val();\n\n      if (!email) {\n        return;\n      }\n\n      $input.val('');\n\n      _this.add(email);\n    });\n\n    _$wrapper.on('change', '[name=email]', function (e) {\n      var $this = $(this);\n      var $liWrapper = $this.closest('li.list-group-item');\n      var $ul = $liWrapper.closest('ul');\n      $liWrapper.siblings().each(function () {\n        var $li = $(this);\n\n        if (!_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()($li).call($li, '> span.pull-right').length) {\n          var temp = '<span class=\"pull-right\">';\n          temp += '<a href=\"#\" class=\"btn btn-sm btn-link btnDeleteEmail\" style=\"display: inline-block;\">삭제</a>';\n          temp += '<a href=\"#\" class=\"btn btn-sm btn-link btnDeleteEmailConfirm\" style=\"display: none;\">삭제확인</a>';\n          temp += '<a href=\"#\" class=\"btn btn-sm btn-link btnDeleteEmailCancle\" style=\"display: none;\">취소</a>';\n          temp += '</span>';\n          $li.append(temp);\n        }\n      });\n\n      if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()($liWrapper).call($liWrapper, '> span.pull-right').length > 0) {\n        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_3___default()($liWrapper).call($liWrapper, '> span.pull-right').remove();\n      }\n\n      $ul.prepend($liWrapper.detach());\n    });\n  };\n\n  return {\n    init: function init(opt) {\n      _this = this;\n      _$wrapper = opt.$wrapper;\n      _email = opt.email;\n      _userId = opt.userId;\n\n      _bindEvents();\n\n      _this.getEmailList();\n\n      return this;\n    },\n    getEmailList: function getEmailList() {\n      XE.get('settings.user.mail.list', {\n        userId: _userId\n      }).then(function (response) {\n        _mails = response.data.mails;\n\n        _this.render(response.data.mails);\n      }).catch(function (error) {\n        XE.toast('danger', error, '.__xe_alertEmailModal');\n      });\n    },\n    delete: function _delete(email) {\n      XE.post('settings.user.mail.delete', {\n        userId: _userId,\n        address: email\n      }).then(function (response) {\n        var i = _babel_runtime_corejs3_core_js_stable_instance_index_of__WEBPACK_IMPORTED_MODULE_2___default()(_mails).call(_mails, email);\n\n        _babel_runtime_corejs3_core_js_stable_instance_splice__WEBPACK_IMPORTED_MODULE_1___default()(_mails).call(_mails, i, 1);\n\n        _this.render(_mails);\n\n        XE.toast('success', '삭제하였습니다.', '.__xe_alertEmailModal');\n      }).catch(function (error) {\n        XE.toast('danger', error, '.__xe_alertEmailModal');\n      });\n    },\n    add: function add(email) {\n      XE.post('settings.user.mail.add', {\n        userId: _userId,\n        address: email\n      }).then(function (response) {\n        var email = response.data.mail;\n\n        _mails.push(email);\n\n        _this.render(_mails);\n\n        XE.toast('success', '추가되었습니다.', '.__xe_alertEmailModal');\n      }).catch(function (error) {\n        XE.toast('danger', error, '.__xe_alertEmailModal');\n      });\n    },\n    render: function render(emails) {\n      var temp = '';\n      temp += '<div>';\n\n      if (emails.length > 0) {\n        temp += '<ul class=\"list-group\">';\n\n        _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0___default()(emails).call(emails, function (email, i) {\n          var address = email.address;\n          var checked = address === _email ? 'checked=\"checked\"' : '';\n          temp += '<li class=\"list-group-item clearfix\">';\n          temp += '<label><input type=\"radio\" name=\"email\" value=\"' + address + '\" ' + checked + '/> ' + address + '</label>';\n\n          if (email.address !== _email) {\n            temp += '<span class=\"pull-right\">';\n            temp += '<a href=\"#\" class=\"btn btn-sm btn-link btnDeleteEmail\" style=\"display: inline-block;\">삭제</a>';\n            temp += '<a href=\"#\" class=\"btn btn-sm btn-link btnDeleteEmailConfirm\" style=\"display: none;\">삭제확인</a>';\n            temp += '<a href=\"#\" class=\"btn btn-sm btn-link btnDeleteEmailCancle\" style=\"display: none;\">취소</a>';\n            temp += '</span>';\n          }\n\n          temp += '</li>';\n        });\n\n        temp += '</ul>';\n      }\n\n      temp += '<div class=\"input-group input-group-sm\" style=\"margin-bottom: 20px;\">';\n      temp += '<input type=\"text\" class=\"form-control\" id=\"__xe_addedEmailInput\" placeholder=\"이메일을 입력하세요\">';\n      temp += '<span class=\"input-group-btn\"><buttion id=\"__xe_emailAddBtn\" class=\"btn btn-default\" type=\"button\">추가</buttion></span>';\n      temp += '</div>';\n\n      _$wrapper.html(temp);\n    }\n  };\n}(window.XE, window.jQuery);\n\nwindow.jQuery(function ($) {\n  $('.__xe_settingEmail').click(function () {\n    $('.__xe_emailView').slideToggle();\n    $('#__xe_emailSetting').slideToggle();\n  });\n  EmailBox.init({\n    $wrapper: $('#__xe_emailSetting'),\n    userId: $('#__xe_emailSetting').data('user-id'),\n    email: $('#__xe_emailSetting').data('email')\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9jb3JlL3VzZXIvc2V0dGluZ3MvZWRpdC5qcy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL2NvcmUvdXNlci9zZXR0aW5ncy9lZGl0LmpzPzM0MDMiXSwic291cmNlc0NvbnRlbnQiOlsidmFyIEVtYWlsQm94ID0gKGZ1bmN0aW9uIChYRSwgJCkge1xuICB2YXIgX3RoaXNcbiAgdmFyIF8kd3JhcHBlciA9ICQoKVxuICB2YXIgX21haWxzID0gW11cbiAgdmFyIF9lbWFpbCA9ICcnXG4gIHZhciBfdXNlcklkID0gJydcblxuICB2YXIgX2JpbmRFdmVudHMgPSBmdW5jdGlvbiAoKSB7XG4gICAgXyR3cmFwcGVyLm9uKCdjbGljaycsICcuYnRuRGVsZXRlRW1haWwnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcblxuICAgICAgJHRoaXMuY3NzKHsgZGlzcGxheTogJ25vbmUnIH0pLnNpYmxpbmdzKCkuY3NzKHsgZGlzcGxheTogJ2lubGluZS1ibG9jaycgfSlcbiAgICB9KVxuXG4gICAgXyR3cmFwcGVyLm9uKCdjbGljaycsICcuYnRuRGVsZXRlRW1haWxDb25maXJtJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICB2YXIgZW1haWwgPSAkdGhpcy5jbG9zZXN0KCdsaS5saXN0LWdyb3VwLWl0ZW0nKS5maW5kKCdbbmFtZT1lbWFpbF0nKS52YWwoKVxuXG4gICAgICBfdGhpcy5kZWxldGUoZW1haWwpXG4gICAgfSlcblxuICAgIF8kd3JhcHBlci5vbignY2xpY2snLCAnLmJ0bkRlbGV0ZUVtYWlsQ2FuY2xlJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG5cbiAgICAgICR0aGlzLnNpYmxpbmdzKCkuYWRkQmFjaygpLmhpZGUoKVxuICAgICAgJHRoaXMucGFyZW50KCkuZmluZCgnLmJ0bkRlbGV0ZUVtYWlsJykuc2hvdygpXG4gICAgfSlcblxuICAgIF8kd3JhcHBlci5vbignY2xpY2snLCAnI19feGVfZW1haWxBZGRCdG4nLCBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJGlucHV0ID0gJCgnI19feGVfYWRkZWRFbWFpbElucHV0JylcbiAgICAgIHZhciBlbWFpbCA9ICRpbnB1dC52YWwoKVxuICAgICAgaWYgKCFlbWFpbCkge1xuICAgICAgICByZXR1cm5cbiAgICAgIH1cblxuICAgICAgJGlucHV0LnZhbCgnJylcblxuICAgICAgX3RoaXMuYWRkKGVtYWlsKVxuICAgIH0pXG5cbiAgICBfJHdyYXBwZXIub24oJ2NoYW5nZScsICdbbmFtZT1lbWFpbF0nLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgdmFyICRsaVdyYXBwZXIgPSAkdGhpcy5jbG9zZXN0KCdsaS5saXN0LWdyb3VwLWl0ZW0nKVxuICAgICAgdmFyICR1bCA9ICRsaVdyYXBwZXIuY2xvc2VzdCgndWwnKVxuXG4gICAgICAkbGlXcmFwcGVyLnNpYmxpbmdzKCkuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciAkbGkgPSAkKHRoaXMpXG5cbiAgICAgICAgaWYgKCEkbGkuZmluZCgnPiBzcGFuLnB1bGwtcmlnaHQnKS5sZW5ndGgpIHtcbiAgICAgICAgICB2YXIgdGVtcCA9ICc8c3BhbiBjbGFzcz1cInB1bGwtcmlnaHRcIj4nXG4gICAgICAgICAgdGVtcCArPSAnPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0biBidG4tc20gYnRuLWxpbmsgYnRuRGVsZXRlRW1haWxcIiBzdHlsZT1cImRpc3BsYXk6IGlubGluZS1ibG9jaztcIj7sgq3soJw8L2E+J1xuICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsQ29uZmlybVwiIHN0eWxlPVwiZGlzcGxheTogbm9uZTtcIj7sgq3soJztmZXsnbg8L2E+J1xuICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsQ2FuY2xlXCIgc3R5bGU9XCJkaXNwbGF5OiBub25lO1wiPuy3qOyGjDwvYT4nXG4gICAgICAgICAgdGVtcCArPSAnPC9zcGFuPidcblxuICAgICAgICAgICRsaS5hcHBlbmQodGVtcClcbiAgICAgICAgfVxuICAgICAgfSlcblxuICAgICAgaWYgKCRsaVdyYXBwZXIuZmluZCgnPiBzcGFuLnB1bGwtcmlnaHQnKS5sZW5ndGggPiAwKSB7XG4gICAgICAgICRsaVdyYXBwZXIuZmluZCgnPiBzcGFuLnB1bGwtcmlnaHQnKS5yZW1vdmUoKVxuICAgICAgfVxuXG4gICAgICAkdWwucHJlcGVuZCgkbGlXcmFwcGVyLmRldGFjaCgpKVxuICAgIH0pXG4gIH1cblxuICByZXR1cm4ge1xuICAgIGluaXQ6IGZ1bmN0aW9uIChvcHQpIHtcbiAgICAgIF90aGlzID0gdGhpc1xuICAgICAgXyR3cmFwcGVyID0gb3B0LiR3cmFwcGVyXG4gICAgICBfZW1haWwgPSBvcHQuZW1haWxcbiAgICAgIF91c2VySWQgPSBvcHQudXNlcklkXG5cbiAgICAgIF9iaW5kRXZlbnRzKClcblxuICAgICAgX3RoaXMuZ2V0RW1haWxMaXN0KClcblxuICAgICAgcmV0dXJuIHRoaXNcbiAgICB9LFxuXG4gICAgZ2V0RW1haWxMaXN0OiBmdW5jdGlvbiAoKSB7XG4gICAgICBYRS5nZXQoJ3NldHRpbmdzLnVzZXIubWFpbC5saXN0JywgeyB1c2VySWQ6IF91c2VySWQgfSkudGhlbigocmVzcG9uc2UpID0+IHtcbiAgICAgICAgX21haWxzID0gcmVzcG9uc2UuZGF0YS5tYWlsc1xuICAgICAgICBfdGhpcy5yZW5kZXIocmVzcG9uc2UuZGF0YS5tYWlscylcbiAgICAgIH0pLmNhdGNoKChlcnJvcikgPT4ge1xuICAgICAgICBYRS50b2FzdCgnZGFuZ2VyJywgZXJyb3IsICcuX194ZV9hbGVydEVtYWlsTW9kYWwnKVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgZGVsZXRlOiBmdW5jdGlvbiAoZW1haWwpIHtcbiAgICAgIFhFLnBvc3QoJ3NldHRpbmdzLnVzZXIubWFpbC5kZWxldGUnLCB7IHVzZXJJZDogX3VzZXJJZCwgYWRkcmVzczogZW1haWwgfSlcbiAgICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xuICAgICAgICAgIHZhciBpID0gX21haWxzLmluZGV4T2YoZW1haWwpXG4gICAgICAgICAgX21haWxzLnNwbGljZShpLCAxKVxuICAgICAgICAgIF90aGlzLnJlbmRlcihfbWFpbHMpXG4gICAgICAgICAgWEUudG9hc3QoJ3N1Y2Nlc3MnLCAn7IKt7KCc7ZWY7JiA7Iq164uI64ukLicsICcuX194ZV9hbGVydEVtYWlsTW9kYWwnKVxuICAgICAgICB9KVxuICAgICAgICAuY2F0Y2goZXJyb3IgPT4ge1xuICAgICAgICAgIFhFLnRvYXN0KCdkYW5nZXInLCBlcnJvciwgJy5fX3hlX2FsZXJ0RW1haWxNb2RhbCcpXG4gICAgICAgIH0pXG4gICAgfSxcblxuICAgIGFkZDogZnVuY3Rpb24gKGVtYWlsKSB7XG4gICAgICBYRS5wb3N0KCdzZXR0aW5ncy51c2VyLm1haWwuYWRkJywgeyB1c2VySWQ6IF91c2VySWQsIGFkZHJlc3M6IGVtYWlsIH0pXG4gICAgICAgIC50aGVuKHJlc3BvbnNlID0+IHtcbiAgICAgICAgICB2YXIgZW1haWwgPSByZXNwb25zZS5kYXRhLm1haWxcblxuICAgICAgICAgIF9tYWlscy5wdXNoKGVtYWlsKVxuXG4gICAgICAgICAgX3RoaXMucmVuZGVyKF9tYWlscylcblxuICAgICAgICAgIFhFLnRvYXN0KCdzdWNjZXNzJywgJ+y2lOqwgOuQmOyXiOyKteuLiOuLpC4nLCAnLl9feGVfYWxlcnRFbWFpbE1vZGFsJylcbiAgICAgICAgfSlcbiAgICAgICAgLmNhdGNoKGVycm9yID0+IHtcbiAgICAgICAgICBYRS50b2FzdCgnZGFuZ2VyJywgZXJyb3IsICcuX194ZV9hbGVydEVtYWlsTW9kYWwnKVxuICAgICAgICB9KVxuICAgIH0sXG5cbiAgICByZW5kZXI6IGZ1bmN0aW9uIChlbWFpbHMpIHtcbiAgICAgIHZhciB0ZW1wID0gJydcblxuICAgICAgdGVtcCArPSAnPGRpdj4nXG5cbiAgICAgIGlmIChlbWFpbHMubGVuZ3RoID4gMCkge1xuICAgICAgICB0ZW1wICs9ICc8dWwgY2xhc3M9XCJsaXN0LWdyb3VwXCI+J1xuXG4gICAgICAgIGVtYWlscy5mb3JFYWNoKGZ1bmN0aW9uIChlbWFpbCwgaSkge1xuICAgICAgICAgIHZhciBhZGRyZXNzID0gZW1haWwuYWRkcmVzc1xuICAgICAgICAgIHZhciBjaGVja2VkID0gKGFkZHJlc3MgPT09IF9lbWFpbCkgPyAnY2hlY2tlZD1cImNoZWNrZWRcIicgOiAnJ1xuXG4gICAgICAgICAgdGVtcCArPSAnPGxpIGNsYXNzPVwibGlzdC1ncm91cC1pdGVtIGNsZWFyZml4XCI+J1xuICAgICAgICAgIHRlbXAgKz0gJzxsYWJlbD48aW5wdXQgdHlwZT1cInJhZGlvXCIgbmFtZT1cImVtYWlsXCIgdmFsdWU9XCInICsgYWRkcmVzcyArICdcIiAnICsgY2hlY2tlZCArICcvPiAnICsgYWRkcmVzcyArICc8L2xhYmVsPidcblxuICAgICAgICAgIGlmIChlbWFpbC5hZGRyZXNzICE9PSBfZW1haWwpIHtcbiAgICAgICAgICAgIHRlbXAgKz0gJzxzcGFuIGNsYXNzPVwicHVsbC1yaWdodFwiPidcbiAgICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsXCIgc3R5bGU9XCJkaXNwbGF5OiBpbmxpbmUtYmxvY2s7XCI+7IKt7KCcPC9hPidcbiAgICAgICAgICAgIHRlbXAgKz0gJzxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG4gYnRuLXNtIGJ0bi1saW5rIGJ0bkRlbGV0ZUVtYWlsQ29uZmlybVwiIHN0eWxlPVwiZGlzcGxheTogbm9uZTtcIj7sgq3soJztmZXsnbg8L2E+J1xuICAgICAgICAgICAgdGVtcCArPSAnPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0biBidG4tc20gYnRuLWxpbmsgYnRuRGVsZXRlRW1haWxDYW5jbGVcIiBzdHlsZT1cImRpc3BsYXk6IG5vbmU7XCI+7Leo7IaMPC9hPidcbiAgICAgICAgICAgIHRlbXAgKz0gJzwvc3Bhbj4nXG4gICAgICAgICAgfVxuXG4gICAgICAgICAgdGVtcCArPSAnPC9saT4nXG4gICAgICAgIH0pXG5cbiAgICAgICAgdGVtcCArPSAnPC91bD4nXG4gICAgICB9XG5cbiAgICAgIHRlbXAgKz0gJzxkaXYgY2xhc3M9XCJpbnB1dC1ncm91cCBpbnB1dC1ncm91cC1zbVwiIHN0eWxlPVwibWFyZ2luLWJvdHRvbTogMjBweDtcIj4nXG4gICAgICB0ZW1wICs9ICc8aW5wdXQgdHlwZT1cInRleHRcIiBjbGFzcz1cImZvcm0tY29udHJvbFwiIGlkPVwiX194ZV9hZGRlZEVtYWlsSW5wdXRcIiBwbGFjZWhvbGRlcj1cIuydtOuplOydvOydhCDsnoXroKXtlZjshLjsmpRcIj4nXG4gICAgICB0ZW1wICs9ICc8c3BhbiBjbGFzcz1cImlucHV0LWdyb3VwLWJ0blwiPjxidXR0aW9uIGlkPVwiX194ZV9lbWFpbEFkZEJ0blwiIGNsYXNzPVwiYnRuIGJ0bi1kZWZhdWx0XCIgdHlwZT1cImJ1dHRvblwiPuy2lOqwgDwvYnV0dGlvbj48L3NwYW4+J1xuICAgICAgdGVtcCArPSAnPC9kaXY+J1xuXG4gICAgICBfJHdyYXBwZXIuaHRtbCh0ZW1wKVxuICAgIH1cbiAgfVxufSkod2luZG93LlhFLCB3aW5kb3cualF1ZXJ5KVxuXG53aW5kb3cualF1ZXJ5KGZ1bmN0aW9uICgkKSB7XG4gICQoJy5fX3hlX3NldHRpbmdFbWFpbCcpLmNsaWNrKGZ1bmN0aW9uICgpIHtcbiAgICAkKCcuX194ZV9lbWFpbFZpZXcnKS5zbGlkZVRvZ2dsZSgpXG4gICAgJCgnI19feGVfZW1haWxTZXR0aW5nJykuc2xpZGVUb2dnbGUoKVxuICB9KVxuXG4gIEVtYWlsQm94LmluaXQoe1xuICAgICR3cmFwcGVyOiAkKCcjX194ZV9lbWFpbFNldHRpbmcnKSxcbiAgICB1c2VySWQ6ICQoJyNfX3hlX2VtYWlsU2V0dGluZycpLmRhdGEoJ3VzZXItaWQnKSxcbiAgICBlbWFpbDogJCgnI19feGVfZW1haWxTZXR0aW5nJykuZGF0YSgnZW1haWwnKVxuICB9KVxufSlcbiJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7QUFBQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUVBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQUE7QUFFQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUFBO0FBRUE7QUFFQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFBQTtBQUFBO0FBQUE7QUFFQTtBQUNBO0FBQUE7QUFDQTtBQUFBO0FBQ0E7QUFBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUFBO0FBQUE7QUFBQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQXZGQTtBQXlGQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBSEE7QUFLQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./core/user/settings/edit.js\n");

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ \"dll-reference _xe_dll_common\"))(\"./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js\");//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9maW5kLmpzLmpzIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uPzNlN2EiXSwic291cmNlc0NvbnRlbnQiOlsibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKFwiLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9maW5kLmpzXCIpOyJdLCJtYXBwaW5ncyI6IkFBQUEiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js\n");

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ \"dll-reference _xe_dll_common\"))(\"./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js\");//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9mb3ItZWFjaC5qcy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9mb3ItZWFjaC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24/ODM2MCJdLCJzb3VyY2VzQ29udGVudCI6WyJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoXCIuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2Zvci1lYWNoLmpzXCIpOyJdLCJtYXBwaW5ncyI6IkFBQUEiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js\n");

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js":
/*!*****************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ \"dll-reference _xe_dll_common\"))(\"./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js\");//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9pbmRleC1vZi5qcy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9pbmRleC1vZi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24/MzQ1YyJdLCJzb3VyY2VzQ29udGVudCI6WyJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoXCIuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2luZGV4LW9mLmpzXCIpOyJdLCJtYXBwaW5ncyI6IkFBQUEiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/@babel/runtime-corejs3/core-js-stable/instance/index-of.js\n");

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ \"dll-reference _xe_dll_common\"))(\"./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js\");//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9zcGxpY2UuanMuanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2Uvc3BsaWNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbj9iY2VhIl0sInNvdXJjZXNDb250ZW50IjpbIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKShcIi4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2Uvc3BsaWNlLmpzXCIpOyJdLCJtYXBwaW5ncyI6IkFBQUEiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/@babel/runtime-corejs3/core-js-stable/instance/splice.js\n");

/***/ }),

/***/ "dll-reference _xe_dll_common":
/*!*********************************!*\
  !*** external "_xe_dll_common" ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = _xe_dll_common;//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbi5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCI/Y2YyYSJdLCJzb3VyY2VzQ29udGVudCI6WyJtb2R1bGUuZXhwb3J0cyA9IF94ZV9kbGxfY29tbW9uOyJdLCJtYXBwaW5ncyI6IkFBQUEiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///dll-reference _xe_dll_common\n");

/***/ })

/******/ });