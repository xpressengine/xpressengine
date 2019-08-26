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
/******/ 	return __webpack_require__(__webpack_require__.s = "./core/common/js/draft.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./core/common/js/draft.js":
/*!*********************************!*\
  !*** ./core/common/js/draft.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/bind */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/bind.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/trim */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_set_timeout__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/set-timeout */ "./node_modules/@babel/runtime-corejs3/core-js-stable/set-timeout.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_set_timeout__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_set_timeout__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/json/stringify */ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/concat */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/for-each */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/promise */ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_7__);









// @TODO 재작성. 사용되지 않음
(function (XE, $) {
  'use strict';
  /**
  * @class
  */

  function Draft(elem, key, callback, withForm, container, apiUrl) {
    this.key = key;
    this.elem = elem;
    this.callback = callback;
    this.withForm = withForm;
    this.container = container;
    this.apiUrl = apiUrl;
    this.interval = null;
    this.draftId = null;
    this.component = null;
    this.$component = $();
    this.componentName = '';
    this.uid = null;

    if (!$(this.elem).attr('name') || $(this.elem).attr('name') == '') {
      console.error("Must set 'name' attribute ");
      return;
    }

    this.init();
    this.bindEvents();
    return this;
  }
  /**
  * @lends Draft
  */


  Draft.prototype = {
    /**
    * 초기화한다.
    * @function
    */
    init: function init() {
      this.uid = this._getUid();
      this.appendComponent();

      _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_7___default.a.all([XE.app('Lang'), XE.app('Request')]).then(function (app) {
        app[0].requestTransAll(['xe::draftSave', 'xe::draftSaved', 'xe::autoSave', 'xe::draftLoad']);
      });
    },
    _getUid: function _getUid() {
      return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    },
    bindEvents: function bindEvents() {
      var _this = this;

      $(this.elem).on('input.draft', function () {
        _this.saveEventHandler();
      });

      _this.$component.on('click', '.draft_title', function (e) {
        var _context;

        e.preventDefault();
        var $this = $(this);
        var type = $this.data('type');
        var item = $(this).data('item');

        _this.onApply(item);

        switch (type) {
          case 'modal':
            _this.$component.xeModal('hide');

            break;

          case 'collapse':
            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_6___default()(_context = _this.$component.show()).call(_context, '.panel-body').empty();

            break;
        }
      });

      _this.$component.on('click', '.xe-draftBtnCloseModal', function () {
        _this.$component.xeModal('hide');
      });

      _this.$component.on('click', '.btn_draft_delete', function (e) {
        e.preventDefault();
        var $this = $(this);
        var id = $this.data('id');

        _this.reqDelete(id, function () {
          $this.closest('li').remove();
        });
      });

      XE.app('Form').then(function (appForm) {
        appForm.get(_this.elem).$$on('submit', function () {
          return _this.deleteAuto(_this.key); // Promise
        }, {
          name: 'xe.draft'
        });
      });
    },
    toggle: function toggle(show) {
      var _this = this;

      switch (this.componentName) {
        case 'modal':
          if (!show && _this.$component.hasClass('in')) {
            _this.$component.xeModal('hide');
          } else {
            _this.load({
              key: _this.key
            }, function (data) {
              var _context3;

              var temp = "<div class=\"draft_save_list\">";
              temp += "<ul>";

              _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(data).call(data, function (item, i) {
                var _context2;

                temp += "<li>";
                temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_4___default()(_context2 = "<a href='#' class='draft_title' data-item='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3___default()(item), "' data-type=\"modal\">")).call(_context2, $($.parseHTML(item.val)).text(), "</a>");
                temp += "<div class=\"draft_info\">";

                if (item.is_auto == 1) {
                  temp += "<span class=\"draft_state\">".concat(window.XE.Lang.trans('xe::autoSave'), "</span>");
                } else {
                  temp += "<span class=\"draft_state v2\">".concat(window.XE.Lang.trans('xe::draftSave'), "</span>");
                }

                temp += "<span class=\"draft_date\">".concat(item.created_at.substr(0, 16).replace(/-/g, ' '), "</span>");
                temp += "<a href=\"#\" class=\"btn_draft_delete\" data-id=\"".concat(item.id, "\"><i class=\"xi-close\"></i></a>");
                temp += "</div>";
                temp += "</li>";
              });

              temp += "</ul>";
              temp += "</div>";

              _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_6___default()(_context3 = _this.$component).call(_context3, '.xe-modal-body').html(temp);

              _this.$component.xeModal('show');
            });
          }

          break;

        case 'collapse':
          if (!show && _this.$component.hasClass('in')) {
            _this.$component.hide();
          } else {
            _this.load({
              key: _this.key
            }, function (data) {
              var _context5;

              var temp = "<div class=\"draft_save_list\">";
              temp += "<ul>";

              _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(data).call(data, function (item, i) {
                var _context4;

                temp += "<li>";
                temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_4___default()(_context4 = "<a href='#' class='draft_title' data-item='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3___default()(item), "' data-type=\"collapse\">")).call(_context4, $($.parseHTML(item.val)).text(), "</a>");
                temp += "<div class=\"draft_info\">";

                if (item.is_auto == 1) {
                  temp += "<span class=\"draft_state\">".concat(window.XE.Lang.trans('xe::autoSave'), "</span>");
                } else {
                  temp += "<span class=\"draft_state v2\">".concat(window.XE.Lang.trans('xe::draftSave'), "</span>");
                }

                temp += "<span class=\"draft_date\">".concat(item.created_at.substr(0, 16).replace(/-/g, ' '), "</span>");
                temp += "<a href=\"#\" class=\"btn_draft_delete\" data-id=\"".concat(item.id, "\"><i class=\"xi-close\"></i></a>");
                temp += "</div>";
                temp += "</li>";
              });

              temp += "</ul>";
              temp += "</div>";

              _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_6___default()(_context5 = _this.$component).call(_context5, '.panel-body').html(temp);

              _this.$component.show();
            });
          }

          break;
      }
    },
    getModalTemplate: function getModalTemplate() {
      return ['<div class="xe-modal fade" id="xe-draftModal">', '<div class="xe-modal-dialog">', '<div class="xe-modal-content">', '<div class="xe-modal-header">', '<button type="button" class="btn-close xe-draftBtnClose" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>', '<strong class="xe-modal-title"></strong>', '</div>', '<div class="xe-modal-body"></div>', '<div class="xe-modal-footer">', '<button type="button" class="xe-btn xe-btn-default" data-dismiss="xe-modal">Close</button>', '</div>', '</div>', '</div>', '</div>'].join('\n');
    },
    getCollapseTemplate: function getCollapseTemplate() {
      return ['<div class="panel panel-default">', '<div class="panel-body"></div>', '</div>'].join('\n');
    },
    appendComponent: function appendComponent() {
      var _this = this;

      var $container = $('<div>');

      if ($(this.container).length < 1) {
        $(this.elem).closest('form').after($container.html(this.getModalTemplate()));
        this.componentName = 'modal';
        this.$component = $('#xe-draftModal');
      } else {
        this.componentName = 'collapse';
        this.$component = $(this.container);

        var collapseClass = this._collapseClass();

        this.$component.addClass([collapseClass, 'collapse'].join(' ')).html($container.html(_this.getCollapseTemplate()));
      }
    },
    onApply: function onApply(data) {
      var _this = this;

      this.setId(data.id);
      var values = data.etc;
      values[$(_this.elem).attr('name')] = data.val;
      dataSetter.init($(_this.elem).closest('form')[0], values);
      this.callback(values);
    },
    _collapseClass: function _collapseClass() {
      return '__xe_draft_collapse_' + this.uid;
    },
    saveEventHandler: function saveEventHandler() {
      var _this = this;

      this.intervalClear();
      this.interval = _babel_runtime_corejs3_core_js_stable_set_timeout__WEBPACK_IMPORTED_MODULE_2___default()(function () {
        _this.setAuto();

        _this.intervalClear();
      }, 3000);
    },
    intervalClear: function intervalClear() {
      if (this.interval) {
        clearTimeout(this.interval);
      }
    },
    draftSet: function draftSet() {
      if (_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_1___default()($).call($, $(this.elem).val()) == '') {
        return;
      }

      if (this.draftId == null) {
        this.reqPost();
      } else {
        this.reqPut();
      }

      window.XE.toast('success', window.XE.Lang.trans('xe::draftSaved'));
    },
    reqPost: function reqPost() {
      var _context6;

      window.XE.ajax({
        url: this.apiUrl.draft.add,
        type: 'post',
        dataType: 'json',
        data: this.getReqSerialize() + '&key=' + this.key,
        success: _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0___default()(_context6 = function _context6(json) {
          if (json.draftId === null) {
            this.unsetId();
          } else {
            this.setId(json.draftId);
          }
        }).call(_context6, this)
      });
    },
    reqPut: function reqPut() {
      var _context7;

      window.XE.ajax({
        url: this.apiUrl.draft.update + '/' + this.draftId,
        type: 'post',
        dataType: 'json',
        data: this.getReqSerialize(),
        success: _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0___default()(_context7 = function _context7(json) {
          var _this = this;

          if (json.draftId === null) {
            var _context8;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_6___default()(_context8 = this.$component).call(_context8, 'li > a').each(function () {
              var $this = $(this);
              var item = $this.data('item');

              if (item.id === _this.draftId) {
                var value = $(_this.elem).val();
                item.val = value;
                item.etc.content = value;
                $this.data('item', item).text($($.parseHTML(value)).text());
              }
            });

            this.unsetId();
          }
        }).call(_context7, this)
      });
    },
    setAuto: function setAuto() {
      window.XE.ajax({
        url: this.apiUrl.auto.set,
        type: 'post',
        data: this.getReqSerialize() + '&key=' + this.key
      });
    },
    deleteAuto: function deleteAuto(key) {
      var _this2 = this;

      key = key || this.key;
      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_7___default.a(function (resolve, reject) {
        if (key) {
          window.XE.ajax({
            url: _this2.apiUrl.auto.unset,
            type: 'post',
            data: 'key=' + key,
            success: function success() {
              resolve();
            },
            error: function error(e) {
              reject(e);
            }
          });
        }
      });
    },
    load: function load(param, callback) {
      var _this = this;

      window.XE.ajax({
        url: _this.apiUrl.draft.list,
        type: 'get',
        dataType: 'json',
        data: param,
        success: function success(data) {
          _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_5___default()(data).call(data, function (obj, i) {
            if (obj.is_auto === 1) {
              _this.key = obj.id;
            }
          });

          if (callback) {
            callback(data);
          }
        }
      });
    },
    getReqSerialize: function getReqSerialize() {
      var data;

      if (this.withForm === true) {
        data = $(this.elem).closest('form').serialize();
      } else {
        data = [$(this.elem).attr('name'), $(this.elem).val()].join('=');
      }

      return data + '&rep=' + $(this.elem).attr('name');
    },
    reqDelete: function reqDelete(id, callback) {
      var _this = this;

      id = id || this.draftId;

      if (!id) {
        return;
      }

      if (id == this.draftId) {
        this.draftId = null;
      }

      window.XE.ajax({
        url: _this.apiUrl.draft.delete + '/' + id,
        type: 'post',
        dataType: 'json',
        success: function success() {
          if (callback) {
            callback();
          }
        }
      });
    },
    setId: function setId(id) {
      this.draftId = id;
    },
    unsetId: function unsetId() {
      this.draftId = null;
    }
  };
  var dataSetter = {
    init: function init(form, data) {
      for (var i in data) {
        var name = i;

        if (data[i] instanceof Array) {
          name = name + '[]';
          this.multiple(form[name], data[i]);
        } else {
          this.single(form[name], data[i]);
        }
      }
    },
    multiple: function multiple(selector, values) {
      if ($(selector).is(':checkbox')) {
        var _context9;

        $.each(values, _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0___default()(_context9 = function _context9(i, val) {
          this.toCheckbox(selector, val);
        }).call(_context9, this));
      } else {
        var _context10;

        $.each(values, _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0___default()(_context10 = function _context10(i, val) {
          this.toInput($(selector).eq(i)[0], val);
        }).call(_context10, this));
      }
    },
    single: function single(selector, value) {
      if ($(selector).is(':checkbox')) {
        this.toCheckbox(selector, value);
      } else if ($(selector).is(':radio')) {
        this.toRadio(selector, value);
      } else if ($(selector).is('select')) {
        this.toSelect(selector, value);
      } else {
        this.toInput(selector, value);
      }
    },
    toCheckbox: function toCheckbox(elem, val) {
      $(elem).each(function () {
        if ($(this).attr('value') == val) {
          $(this).prop('checked', true);
          return false;
        }
      });
    },
    toRadio: function toRadio(elem, val) {
      $(elem).each(function () {
        if ($(this).attr('value') == val) {
          $(this).prop('checked', true);
          return false;
        }
      });
    },
    toSelect: function toSelect(elem, val) {
      $(elem).children().each(function () {
        if ($(this).attr('value') == val) {
          $(this).prop('selected', true);
          return false;
        }
      });
    },
    toInput: function toInput(elem, val) {
      if (!$(elem).is('input[type=hidden]')) {
        $(elem).val(val);
      }
    } // jQuery 플러그인

  };

  $.fn.draft = function (args) {
    var _context11, _context12;

    /**
     * 옵션
     * @type {object}
     * @prop {?jQuery} container 임시 저장 목록이 표시될 영역
     * @prop {boolean} withForm form의 전체 fields 데이터 저장 여부
     * @prop {?function} callback
     */
    var defaultArgs = {
      container: null,
      withForm: false,
      callback: null
    };
    args = $.extend({}, defaultArgs, args);

    if (!args.key || !args.btnLoad || !args.btnSave) {
      console.error('must need key, btnLoad and btnSave');
      return false;
    }

    var draft = new Draft(this, args.key, args.callback, args.withForm, args.container, args.apiUrl);

    _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0___default()(_context11 = $(args.btnLoad).unbind('click.draft')).call(_context11, 'click.draft', function (e) {
      e.preventDefault();
      draft.toggle(true);
    });

    _babel_runtime_corejs3_core_js_stable_instance_bind__WEBPACK_IMPORTED_MODULE_0___default()(_context12 = $(args.btnSave).unbind('click.draft')).call(_context12, 'click.draft', function (e) {
      e.preventDefault();
      draft.draftSet();
    });

    return draft;
  };
})(window.XE, window.jQuery);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/bind.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/bind.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(61);

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

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js":
/*!*******************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(1);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/set-timeout.js":
/*!***********************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/set-timeout.js from dll-reference _xe_dll_common ***!
  \***********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(44);

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

/***/ "dll-reference _xe_dll_common":
/*!*********************************!*\
  !*** external "_xe_dll_common" ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = _xe_dll_common;

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS9jb21tb24vanMvZHJhZnQuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2JpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9jb25jYXQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9maW5kLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvaW5zdGFuY2UvZm9yLWVhY2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS90cmltLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvcHJvbWlzZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL3NldC10aW1lb3V0LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2VzL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9wYXRoLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZXh0ZXJuYWwgXCJfeGVfZGxsX2NvbW1vblwiIl0sIm5hbWVzIjpbIlhFIiwiJCIsIkRyYWZ0IiwiZWxlbSIsImtleSIsImNhbGxiYWNrIiwid2l0aEZvcm0iLCJjb250YWluZXIiLCJhcGlVcmwiLCJpbnRlcnZhbCIsImRyYWZ0SWQiLCJjb21wb25lbnQiLCIkY29tcG9uZW50IiwiY29tcG9uZW50TmFtZSIsInVpZCIsImF0dHIiLCJjb25zb2xlIiwiZXJyb3IiLCJpbml0IiwiYmluZEV2ZW50cyIsInByb3RvdHlwZSIsIl9nZXRVaWQiLCJhcHBlbmRDb21wb25lbnQiLCJhbGwiLCJhcHAiLCJ0aGVuIiwicmVxdWVzdFRyYW5zQWxsIiwiTWF0aCIsInJhbmRvbSIsInRvU3RyaW5nIiwic3Vic3RyaW5nIiwiX3RoaXMiLCJvbiIsInNhdmVFdmVudEhhbmRsZXIiLCJlIiwicHJldmVudERlZmF1bHQiLCIkdGhpcyIsInR5cGUiLCJkYXRhIiwiaXRlbSIsIm9uQXBwbHkiLCJ4ZU1vZGFsIiwic2hvdyIsImVtcHR5IiwiaWQiLCJyZXFEZWxldGUiLCJjbG9zZXN0IiwicmVtb3ZlIiwiYXBwRm9ybSIsImdldCIsIiQkb24iLCJkZWxldGVBdXRvIiwibmFtZSIsInRvZ2dsZSIsImhhc0NsYXNzIiwibG9hZCIsInRlbXAiLCJpIiwicGFyc2VIVE1MIiwidmFsIiwidGV4dCIsImlzX2F1dG8iLCJ3aW5kb3ciLCJMYW5nIiwidHJhbnMiLCJjcmVhdGVkX2F0Iiwic3Vic3RyIiwicmVwbGFjZSIsImh0bWwiLCJoaWRlIiwiZ2V0TW9kYWxUZW1wbGF0ZSIsImpvaW4iLCJnZXRDb2xsYXBzZVRlbXBsYXRlIiwiJGNvbnRhaW5lciIsImxlbmd0aCIsImFmdGVyIiwiY29sbGFwc2VDbGFzcyIsIl9jb2xsYXBzZUNsYXNzIiwiYWRkQ2xhc3MiLCJzZXRJZCIsInZhbHVlcyIsImV0YyIsImRhdGFTZXR0ZXIiLCJpbnRlcnZhbENsZWFyIiwic2V0QXV0byIsImNsZWFyVGltZW91dCIsImRyYWZ0U2V0IiwicmVxUG9zdCIsInJlcVB1dCIsInRvYXN0IiwiYWpheCIsInVybCIsImRyYWZ0IiwiYWRkIiwiZGF0YVR5cGUiLCJnZXRSZXFTZXJpYWxpemUiLCJzdWNjZXNzIiwianNvbiIsInVuc2V0SWQiLCJ1cGRhdGUiLCJlYWNoIiwidmFsdWUiLCJjb250ZW50IiwiYXV0byIsInNldCIsInJlc29sdmUiLCJyZWplY3QiLCJ1bnNldCIsInBhcmFtIiwibGlzdCIsIm9iaiIsInNlcmlhbGl6ZSIsImRlbGV0ZSIsImZvcm0iLCJBcnJheSIsIm11bHRpcGxlIiwic2luZ2xlIiwic2VsZWN0b3IiLCJpcyIsInRvQ2hlY2tib3giLCJ0b0lucHV0IiwiZXEiLCJ0b1JhZGlvIiwidG9TZWxlY3QiLCJwcm9wIiwiY2hpbGRyZW4iLCJmbiIsImFyZ3MiLCJkZWZhdWx0QXJncyIsImV4dGVuZCIsImJ0bkxvYWQiLCJidG5TYXZlIiwidW5iaW5kIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7OztBQUdBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxrREFBMEMsZ0NBQWdDO0FBQzFFO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsZ0VBQXdELGtCQUFrQjtBQUMxRTtBQUNBLHlEQUFpRCxjQUFjO0FBQy9EOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpREFBeUMsaUNBQWlDO0FBQzFFLHdIQUFnSCxtQkFBbUIsRUFBRTtBQUNySTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLG1DQUEyQiwwQkFBMEIsRUFBRTtBQUN2RCx5Q0FBaUMsZUFBZTtBQUNoRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQSw4REFBc0QsK0RBQStEOztBQUVySDtBQUNBOzs7QUFHQTtBQUNBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNsRkE7QUFDQSxDQUFDLFVBQVVBLEVBQVYsRUFBY0MsQ0FBZCxFQUFpQjtBQUNoQjtBQUNBOzs7O0FBR0EsV0FBU0MsS0FBVCxDQUFnQkMsSUFBaEIsRUFBc0JDLEdBQXRCLEVBQTJCQyxRQUEzQixFQUFxQ0MsUUFBckMsRUFBK0NDLFNBQS9DLEVBQTBEQyxNQUExRCxFQUFrRTtBQUNoRSxTQUFLSixHQUFMLEdBQVdBLEdBQVg7QUFDQSxTQUFLRCxJQUFMLEdBQVlBLElBQVo7QUFDQSxTQUFLRSxRQUFMLEdBQWdCQSxRQUFoQjtBQUNBLFNBQUtDLFFBQUwsR0FBZ0JBLFFBQWhCO0FBQ0EsU0FBS0MsU0FBTCxHQUFpQkEsU0FBakI7QUFDQSxTQUFLQyxNQUFMLEdBQWNBLE1BQWQ7QUFFQSxTQUFLQyxRQUFMLEdBQWdCLElBQWhCO0FBRUEsU0FBS0MsT0FBTCxHQUFlLElBQWY7QUFDQSxTQUFLQyxTQUFMLEdBQWlCLElBQWpCO0FBQ0EsU0FBS0MsVUFBTCxHQUFrQlgsQ0FBQyxFQUFuQjtBQUNBLFNBQUtZLGFBQUwsR0FBcUIsRUFBckI7QUFDQSxTQUFLQyxHQUFMLEdBQVcsSUFBWDs7QUFFQSxRQUFJLENBQUNiLENBQUMsQ0FBQyxLQUFLRSxJQUFOLENBQUQsQ0FBYVksSUFBYixDQUFrQixNQUFsQixDQUFELElBQThCZCxDQUFDLENBQUMsS0FBS0UsSUFBTixDQUFELENBQWFZLElBQWIsQ0FBa0IsTUFBbEIsS0FBNkIsRUFBL0QsRUFBbUU7QUFDakVDLGFBQU8sQ0FBQ0MsS0FBUixDQUFjLDRCQUFkO0FBQ0E7QUFDRDs7QUFFRCxTQUFLQyxJQUFMO0FBQ0EsU0FBS0MsVUFBTDtBQUVBLFdBQU8sSUFBUDtBQUNEO0FBRUQ7Ozs7O0FBR0FqQixPQUFLLENBQUNrQixTQUFOLEdBQWtCO0FBQ2hCOzs7O0FBSUFGLFFBQUksRUFBRSxnQkFBWTtBQUNoQixXQUFLSixHQUFMLEdBQVcsS0FBS08sT0FBTCxFQUFYO0FBQ0EsV0FBS0MsZUFBTDs7QUFFQSwyRkFBUUMsR0FBUixDQUFZLENBQUN2QixFQUFFLENBQUN3QixHQUFILENBQU8sTUFBUCxDQUFELEVBQWlCeEIsRUFBRSxDQUFDd0IsR0FBSCxDQUFPLFNBQVAsQ0FBakIsQ0FBWixFQUFpREMsSUFBakQsQ0FBc0QsVUFBVUQsR0FBVixFQUFlO0FBQ25FQSxXQUFHLENBQUMsQ0FBRCxDQUFILENBQU9FLGVBQVAsQ0FBdUIsQ0FBQyxlQUFELEVBQWtCLGdCQUFsQixFQUFvQyxjQUFwQyxFQUFvRCxlQUFwRCxDQUF2QjtBQUNELE9BRkQ7QUFHRCxLQVplO0FBY2hCTCxXQUFPLEVBQUUsbUJBQVk7QUFDbkIsYUFBT00sSUFBSSxDQUFDQyxNQUFMLEdBQWNDLFFBQWQsQ0FBdUIsRUFBdkIsRUFBMkJDLFNBQTNCLENBQXFDLENBQXJDLEVBQXdDLEVBQXhDLElBQ1BILElBQUksQ0FBQ0MsTUFBTCxHQUFjQyxRQUFkLENBQXVCLEVBQXZCLEVBQTJCQyxTQUEzQixDQUFxQyxDQUFyQyxFQUF3QyxFQUF4QyxDQURBO0FBRUQsS0FqQmU7QUFtQmhCWCxjQUFVLEVBQUUsc0JBQVk7QUFDdEIsVUFBSVksS0FBSyxHQUFHLElBQVo7O0FBRUE5QixPQUFDLENBQUMsS0FBS0UsSUFBTixDQUFELENBQWE2QixFQUFiLENBQWdCLGFBQWhCLEVBQStCLFlBQVk7QUFDekNELGFBQUssQ0FBQ0UsZ0JBQU47QUFDRCxPQUZEOztBQUlBRixXQUFLLENBQUNuQixVQUFOLENBQWlCb0IsRUFBakIsQ0FBb0IsT0FBcEIsRUFBNkIsY0FBN0IsRUFBNkMsVUFBVUUsQ0FBVixFQUFhO0FBQUE7O0FBQ3hEQSxTQUFDLENBQUNDLGNBQUY7QUFDQSxZQUFJQyxLQUFLLEdBQUduQyxDQUFDLENBQUMsSUFBRCxDQUFiO0FBQ0EsWUFBSW9DLElBQUksR0FBR0QsS0FBSyxDQUFDRSxJQUFOLENBQVcsTUFBWCxDQUFYO0FBQ0EsWUFBSUMsSUFBSSxHQUFHdEMsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRcUMsSUFBUixDQUFhLE1BQWIsQ0FBWDs7QUFFQVAsYUFBSyxDQUFDUyxPQUFOLENBQWNELElBQWQ7O0FBRUEsZ0JBQVFGLElBQVI7QUFDRSxlQUFLLE9BQUw7QUFDRU4saUJBQUssQ0FBQ25CLFVBQU4sQ0FBaUI2QixPQUFqQixDQUF5QixNQUF6Qjs7QUFDQTs7QUFDRixlQUFLLFVBQUw7QUFDRSxrSEFBQVYsS0FBSyxDQUFDbkIsVUFBTixDQUFpQjhCLElBQWpCLG1CQUE2QixhQUE3QixFQUE0Q0MsS0FBNUM7O0FBQ0E7QUFOSjtBQVFELE9BaEJEOztBQWtCQVosV0FBSyxDQUFDbkIsVUFBTixDQUFpQm9CLEVBQWpCLENBQW9CLE9BQXBCLEVBQTZCLHdCQUE3QixFQUF1RCxZQUFZO0FBQ2pFRCxhQUFLLENBQUNuQixVQUFOLENBQWlCNkIsT0FBakIsQ0FBeUIsTUFBekI7QUFDRCxPQUZEOztBQUlBVixXQUFLLENBQUNuQixVQUFOLENBQWlCb0IsRUFBakIsQ0FBb0IsT0FBcEIsRUFBNkIsbUJBQTdCLEVBQWtELFVBQVVFLENBQVYsRUFBYTtBQUM3REEsU0FBQyxDQUFDQyxjQUFGO0FBRUEsWUFBSUMsS0FBSyxHQUFHbkMsQ0FBQyxDQUFDLElBQUQsQ0FBYjtBQUNBLFlBQUkyQyxFQUFFLEdBQUdSLEtBQUssQ0FBQ0UsSUFBTixDQUFXLElBQVgsQ0FBVDs7QUFFQVAsYUFBSyxDQUFDYyxTQUFOLENBQWdCRCxFQUFoQixFQUFvQixZQUFZO0FBQzlCUixlQUFLLENBQUNVLE9BQU4sQ0FBYyxJQUFkLEVBQW9CQyxNQUFwQjtBQUNELFNBRkQ7QUFHRCxPQVREOztBQVdBL0MsUUFBRSxDQUFDd0IsR0FBSCxDQUFPLE1BQVAsRUFBZUMsSUFBZixDQUFvQixVQUFBdUIsT0FBTyxFQUFJO0FBQzdCQSxlQUFPLENBQUNDLEdBQVIsQ0FBWWxCLEtBQUssQ0FBQzVCLElBQWxCLEVBQXdCK0MsSUFBeEIsQ0FBNkIsUUFBN0IsRUFBdUMsWUFBWTtBQUNqRCxpQkFBT25CLEtBQUssQ0FBQ29CLFVBQU4sQ0FBaUJwQixLQUFLLENBQUMzQixHQUF2QixDQUFQLENBRGlELENBQ2Q7QUFDcEMsU0FGRCxFQUVHO0FBQUVnRCxjQUFJLEVBQUU7QUFBUixTQUZIO0FBR0QsT0FKRDtBQUtELEtBaEVlO0FBa0VoQkMsVUFBTSxFQUFFLGdCQUFVWCxJQUFWLEVBQWdCO0FBQ3RCLFVBQUlYLEtBQUssR0FBRyxJQUFaOztBQUVBLGNBQVEsS0FBS2xCLGFBQWI7QUFDRSxhQUFLLE9BQUw7QUFDRSxjQUFJLENBQUM2QixJQUFELElBQVNYLEtBQUssQ0FBQ25CLFVBQU4sQ0FBaUIwQyxRQUFqQixDQUEwQixJQUExQixDQUFiLEVBQThDO0FBQzVDdkIsaUJBQUssQ0FBQ25CLFVBQU4sQ0FBaUI2QixPQUFqQixDQUF5QixNQUF6QjtBQUNELFdBRkQsTUFFTztBQUNMVixpQkFBSyxDQUFDd0IsSUFBTixDQUFXO0FBQUVuRCxpQkFBRyxFQUFFMkIsS0FBSyxDQUFDM0I7QUFBYixhQUFYLEVBQStCLFVBQVVrQyxJQUFWLEVBQWdCO0FBQUE7O0FBQzdDLGtCQUFJa0IsSUFBSSxvQ0FBUjtBQUNBQSxrQkFBSSxVQUFKOztBQUVBLDZHQUFBbEIsSUFBSSxNQUFKLENBQUFBLElBQUksRUFBUyxVQUFVQyxJQUFWLEVBQWdCa0IsQ0FBaEIsRUFBbUI7QUFBQTs7QUFDOUJELG9CQUFJLFVBQUo7QUFDQUEsb0JBQUksSUFBSSw4SkFBOEMsNEZBQWVqQixJQUFmLENBQWxELDZDQUE2RnRDLENBQUMsQ0FBQ0EsQ0FBQyxDQUFDeUQsU0FBRixDQUFZbkIsSUFBSSxDQUFDb0IsR0FBakIsQ0FBRCxDQUFELENBQXlCQyxJQUF6QixFQUE3RixTQUFKO0FBQ0FKLG9CQUFJLGdDQUFKOztBQUVBLG9CQUFJakIsSUFBSSxDQUFDc0IsT0FBTCxJQUFnQixDQUFwQixFQUF1QjtBQUNyQkwsc0JBQUksMENBQWlDTSxNQUFNLENBQUM5RCxFQUFQLENBQVUrRCxJQUFWLENBQWVDLEtBQWYsQ0FBcUIsY0FBckIsQ0FBakMsWUFBSjtBQUNELGlCQUZELE1BRU87QUFDTFIsc0JBQUksNkNBQW9DTSxNQUFNLENBQUM5RCxFQUFQLENBQVUrRCxJQUFWLENBQWVDLEtBQWYsQ0FBcUIsZUFBckIsQ0FBcEMsWUFBSjtBQUNEOztBQUVEUixvQkFBSSx5Q0FBZ0NqQixJQUFJLENBQUMwQixVQUFMLENBQWdCQyxNQUFoQixDQUF1QixDQUF2QixFQUEwQixFQUExQixFQUE4QkMsT0FBOUIsQ0FBc0MsSUFBdEMsRUFBNEMsR0FBNUMsQ0FBaEMsWUFBSjtBQUNBWCxvQkFBSSxpRUFBcURqQixJQUFJLENBQUNLLEVBQTFELHNDQUFKO0FBQ0FZLG9CQUFJLFlBQUo7QUFDQUEsb0JBQUksV0FBSjtBQUNELGVBZkcsQ0FBSjs7QUFpQkFBLGtCQUFJLFdBQUo7QUFDQUEsa0JBQUksWUFBSjs7QUFFQSxxSEFBQXpCLEtBQUssQ0FBQ25CLFVBQU4sa0JBQXNCLGdCQUF0QixFQUF3Q3dELElBQXhDLENBQTZDWixJQUE3Qzs7QUFDQXpCLG1CQUFLLENBQUNuQixVQUFOLENBQWlCNkIsT0FBakIsQ0FBeUIsTUFBekI7QUFDRCxhQTFCRDtBQTJCRDs7QUFFRDs7QUFDRixhQUFLLFVBQUw7QUFFRSxjQUFJLENBQUNDLElBQUQsSUFBU1gsS0FBSyxDQUFDbkIsVUFBTixDQUFpQjBDLFFBQWpCLENBQTBCLElBQTFCLENBQWIsRUFBOEM7QUFDNUN2QixpQkFBSyxDQUFDbkIsVUFBTixDQUFpQnlELElBQWpCO0FBQ0QsV0FGRCxNQUVPO0FBQ0x0QyxpQkFBSyxDQUFDd0IsSUFBTixDQUFXO0FBQUVuRCxpQkFBRyxFQUFFMkIsS0FBSyxDQUFDM0I7QUFBYixhQUFYLEVBQStCLFVBQVVrQyxJQUFWLEVBQWdCO0FBQUE7O0FBQzdDLGtCQUFJa0IsSUFBSSxvQ0FBUjtBQUNBQSxrQkFBSSxVQUFKOztBQUVBLDZHQUFBbEIsSUFBSSxNQUFKLENBQUFBLElBQUksRUFBUyxVQUFVQyxJQUFWLEVBQWdCa0IsQ0FBaEIsRUFBbUI7QUFBQTs7QUFDOUJELG9CQUFJLFVBQUo7QUFDQUEsb0JBQUksSUFBSSw4SkFBOEMsNEZBQWVqQixJQUFmLENBQWxELGdEQUFnR3RDLENBQUMsQ0FBQ0EsQ0FBQyxDQUFDeUQsU0FBRixDQUFZbkIsSUFBSSxDQUFDb0IsR0FBakIsQ0FBRCxDQUFELENBQXlCQyxJQUF6QixFQUFoRyxTQUFKO0FBQ0FKLG9CQUFJLGdDQUFKOztBQUVBLG9CQUFJakIsSUFBSSxDQUFDc0IsT0FBTCxJQUFnQixDQUFwQixFQUF1QjtBQUNyQkwsc0JBQUksMENBQWlDTSxNQUFNLENBQUM5RCxFQUFQLENBQVUrRCxJQUFWLENBQWVDLEtBQWYsQ0FBcUIsY0FBckIsQ0FBakMsWUFBSjtBQUNELGlCQUZELE1BRU87QUFDTFIsc0JBQUksNkNBQW9DTSxNQUFNLENBQUM5RCxFQUFQLENBQVUrRCxJQUFWLENBQWVDLEtBQWYsQ0FBcUIsZUFBckIsQ0FBcEMsWUFBSjtBQUNEOztBQUVEUixvQkFBSSx5Q0FBZ0NqQixJQUFJLENBQUMwQixVQUFMLENBQWdCQyxNQUFoQixDQUF1QixDQUF2QixFQUEwQixFQUExQixFQUE4QkMsT0FBOUIsQ0FBc0MsSUFBdEMsRUFBNEMsR0FBNUMsQ0FBaEMsWUFBSjtBQUNBWCxvQkFBSSxpRUFBcURqQixJQUFJLENBQUNLLEVBQTFELHNDQUFKO0FBQ0FZLG9CQUFJLFlBQUo7QUFDQUEsb0JBQUksV0FBSjtBQUNELGVBZkcsQ0FBSjs7QUFpQkFBLGtCQUFJLFdBQUo7QUFDQUEsa0JBQUksWUFBSjs7QUFFQSxxSEFBQXpCLEtBQUssQ0FBQ25CLFVBQU4sa0JBQXNCLGFBQXRCLEVBQXFDd0QsSUFBckMsQ0FBMENaLElBQTFDOztBQUNBekIsbUJBQUssQ0FBQ25CLFVBQU4sQ0FBaUI4QixJQUFqQjtBQUNELGFBMUJEO0FBMkJEOztBQUVEO0FBckVKO0FBdUVELEtBNUllO0FBOEloQjRCLG9CQUFnQixFQUFFLDRCQUFZO0FBQzVCLGFBQU8sQ0FDTCxnREFESyxFQUVMLCtCQUZLLEVBR0wsZ0NBSEssRUFJTCwrQkFKSyxFQUtMLHVJQUxLLEVBTUwsMENBTkssRUFPTCxRQVBLLEVBUUwsbUNBUkssRUFTTCwrQkFUSyxFQVVMLDRGQVZLLEVBV0wsUUFYSyxFQVlMLFFBWkssRUFhTCxRQWJLLEVBY0wsUUFkSyxFQWVMQyxJQWZLLENBZUEsSUFmQSxDQUFQO0FBZ0JELEtBL0plO0FBaUtoQkMsdUJBQW1CLEVBQUUsK0JBQVk7QUFDL0IsYUFBTyxDQUNMLG1DQURLLEVBRUwsZ0NBRkssRUFHTCxRQUhLLEVBSUxELElBSkssQ0FJQSxJQUpBLENBQVA7QUFLRCxLQXZLZTtBQXlLaEJqRCxtQkFBZSxFQUFFLDJCQUFZO0FBQzNCLFVBQUlTLEtBQUssR0FBRyxJQUFaOztBQUNBLFVBQUkwQyxVQUFVLEdBQUd4RSxDQUFDLENBQUMsT0FBRCxDQUFsQjs7QUFFQSxVQUFJQSxDQUFDLENBQUMsS0FBS00sU0FBTixDQUFELENBQWtCbUUsTUFBbEIsR0FBMkIsQ0FBL0IsRUFBa0M7QUFDaEN6RSxTQUFDLENBQUMsS0FBS0UsSUFBTixDQUFELENBQWEyQyxPQUFiLENBQXFCLE1BQXJCLEVBQTZCNkIsS0FBN0IsQ0FBbUNGLFVBQVUsQ0FBQ0wsSUFBWCxDQUFnQixLQUFLRSxnQkFBTCxFQUFoQixDQUFuQztBQUNBLGFBQUt6RCxhQUFMLEdBQXFCLE9BQXJCO0FBQ0EsYUFBS0QsVUFBTCxHQUFrQlgsQ0FBQyxDQUFDLGdCQUFELENBQW5CO0FBQ0QsT0FKRCxNQUlPO0FBQ0wsYUFBS1ksYUFBTCxHQUFxQixVQUFyQjtBQUNBLGFBQUtELFVBQUwsR0FBa0JYLENBQUMsQ0FBQyxLQUFLTSxTQUFOLENBQW5COztBQUVBLFlBQUlxRSxhQUFhLEdBQUcsS0FBS0MsY0FBTCxFQUFwQjs7QUFFQSxhQUFLakUsVUFBTCxDQUFnQmtFLFFBQWhCLENBQXlCLENBQUNGLGFBQUQsRUFBZ0IsVUFBaEIsRUFBNEJMLElBQTVCLENBQWlDLEdBQWpDLENBQXpCLEVBQWdFSCxJQUFoRSxDQUFxRUssVUFBVSxDQUFDTCxJQUFYLENBQWdCckMsS0FBSyxDQUFDeUMsbUJBQU4sRUFBaEIsQ0FBckU7QUFDRDtBQUNGLEtBekxlO0FBMkxoQmhDLFdBQU8sRUFBRSxpQkFBVUYsSUFBVixFQUFnQjtBQUN2QixVQUFJUCxLQUFLLEdBQUcsSUFBWjs7QUFDQSxXQUFLZ0QsS0FBTCxDQUFXekMsSUFBSSxDQUFDTSxFQUFoQjtBQUVBLFVBQUlvQyxNQUFNLEdBQUcxQyxJQUFJLENBQUMyQyxHQUFsQjtBQUNBRCxZQUFNLENBQUMvRSxDQUFDLENBQUM4QixLQUFLLENBQUM1QixJQUFQLENBQUQsQ0FBY1ksSUFBZCxDQUFtQixNQUFuQixDQUFELENBQU4sR0FBcUN1QixJQUFJLENBQUNxQixHQUExQztBQUVBdUIsZ0JBQVUsQ0FBQ2hFLElBQVgsQ0FBZ0JqQixDQUFDLENBQUM4QixLQUFLLENBQUM1QixJQUFQLENBQUQsQ0FBYzJDLE9BQWQsQ0FBc0IsTUFBdEIsRUFBOEIsQ0FBOUIsQ0FBaEIsRUFBa0RrQyxNQUFsRDtBQUNBLFdBQUszRSxRQUFMLENBQWMyRSxNQUFkO0FBQ0QsS0FwTWU7QUFzTWhCSCxrQkFBYyxFQUFFLDBCQUFZO0FBQzFCLGFBQU8seUJBQXlCLEtBQUsvRCxHQUFyQztBQUNELEtBeE1lO0FBME1oQm1CLG9CQUFnQixFQUFFLDRCQUFZO0FBQzVCLFVBQUlGLEtBQUssR0FBRyxJQUFaOztBQUNBLFdBQUtvRCxhQUFMO0FBRUEsV0FBSzFFLFFBQUwsR0FBZ0IseUZBQVcsWUFBWTtBQUNyQ3NCLGFBQUssQ0FBQ3FELE9BQU47O0FBQ0FyRCxhQUFLLENBQUNvRCxhQUFOO0FBQ0QsT0FIZSxFQUdiLElBSGEsQ0FBaEI7QUFJRCxLQWxOZTtBQW9OaEJBLGlCQUFhLEVBQUUseUJBQVk7QUFDekIsVUFBSSxLQUFLMUUsUUFBVCxFQUFtQjtBQUNqQjRFLG9CQUFZLENBQUMsS0FBSzVFLFFBQU4sQ0FBWjtBQUNEO0FBQ0YsS0F4TmU7QUEwTmhCNkUsWUFBUSxFQUFFLG9CQUFZO0FBQ3BCLFVBQUksMkZBQUFyRixDQUFDLE1BQUQsQ0FBQUEsQ0FBQyxFQUFNQSxDQUFDLENBQUMsS0FBS0UsSUFBTixDQUFELENBQWF3RCxHQUFiLEVBQU4sQ0FBRCxJQUE4QixFQUFsQyxFQUFzQztBQUNwQztBQUNEOztBQUVELFVBQUksS0FBS2pELE9BQUwsSUFBZ0IsSUFBcEIsRUFBMEI7QUFDeEIsYUFBSzZFLE9BQUw7QUFDRCxPQUZELE1BRU87QUFDTCxhQUFLQyxNQUFMO0FBQ0Q7O0FBRUQxQixZQUFNLENBQUM5RCxFQUFQLENBQVV5RixLQUFWLENBQWdCLFNBQWhCLEVBQTJCM0IsTUFBTSxDQUFDOUQsRUFBUCxDQUFVK0QsSUFBVixDQUFlQyxLQUFmLENBQXFCLGdCQUFyQixDQUEzQjtBQUNELEtBdE9lO0FBd09oQnVCLFdBQU8sRUFBRSxtQkFBWTtBQUFBOztBQUNuQnpCLFlBQU0sQ0FBQzlELEVBQVAsQ0FBVTBGLElBQVYsQ0FBZTtBQUNiQyxXQUFHLEVBQUUsS0FBS25GLE1BQUwsQ0FBWW9GLEtBQVosQ0FBa0JDLEdBRFY7QUFFYnhELFlBQUksRUFBRSxNQUZPO0FBR2J5RCxnQkFBUSxFQUFFLE1BSEc7QUFJYnhELFlBQUksRUFBRSxLQUFLeUQsZUFBTCxLQUF5QixPQUF6QixHQUFtQyxLQUFLM0YsR0FKakM7QUFLYjRGLGVBQU8sRUFBRSwwSEFBVUMsSUFBVixFQUFnQjtBQUN2QixjQUFJQSxJQUFJLENBQUN2RixPQUFMLEtBQWlCLElBQXJCLEVBQTJCO0FBQ3pCLGlCQUFLd0YsT0FBTDtBQUNELFdBRkQsTUFFTztBQUNMLGlCQUFLbkIsS0FBTCxDQUFXa0IsSUFBSSxDQUFDdkYsT0FBaEI7QUFDRDtBQUNGLFNBTlEsa0JBTUYsSUFORTtBQUxJLE9BQWY7QUFhRCxLQXRQZTtBQXdQaEI4RSxVQUFNLEVBQUUsa0JBQVk7QUFBQTs7QUFDbEIxQixZQUFNLENBQUM5RCxFQUFQLENBQVUwRixJQUFWLENBQWU7QUFDYkMsV0FBRyxFQUFFLEtBQUtuRixNQUFMLENBQVlvRixLQUFaLENBQWtCTyxNQUFsQixHQUEyQixHQUEzQixHQUFpQyxLQUFLekYsT0FEOUI7QUFFYjJCLFlBQUksRUFBRSxNQUZPO0FBR2J5RCxnQkFBUSxFQUFFLE1BSEc7QUFJYnhELFlBQUksRUFBRSxLQUFLeUQsZUFBTCxFQUpPO0FBS2JDLGVBQU8sRUFBRSwwSEFBVUMsSUFBVixFQUFnQjtBQUN2QixjQUFJbEUsS0FBSyxHQUFHLElBQVo7O0FBRUEsY0FBSWtFLElBQUksQ0FBQ3ZGLE9BQUwsS0FBaUIsSUFBckIsRUFBMkI7QUFBQTs7QUFDekIsd0hBQUtFLFVBQUwsa0JBQXFCLFFBQXJCLEVBQStCd0YsSUFBL0IsQ0FBb0MsWUFBWTtBQUM5QyxrQkFBSWhFLEtBQUssR0FBR25DLENBQUMsQ0FBQyxJQUFELENBQWI7QUFDQSxrQkFBSXNDLElBQUksR0FBR0gsS0FBSyxDQUFDRSxJQUFOLENBQVcsTUFBWCxDQUFYOztBQUVBLGtCQUFJQyxJQUFJLENBQUNLLEVBQUwsS0FBWWIsS0FBSyxDQUFDckIsT0FBdEIsRUFBK0I7QUFDN0Isb0JBQUkyRixLQUFLLEdBQUdwRyxDQUFDLENBQUM4QixLQUFLLENBQUM1QixJQUFQLENBQUQsQ0FBY3dELEdBQWQsRUFBWjtBQUVBcEIsb0JBQUksQ0FBQ29CLEdBQUwsR0FBVzBDLEtBQVg7QUFDQTlELG9CQUFJLENBQUMwQyxHQUFMLENBQVNxQixPQUFULEdBQW1CRCxLQUFuQjtBQUVBakUscUJBQUssQ0FBQ0UsSUFBTixDQUFXLE1BQVgsRUFBbUJDLElBQW5CLEVBQXlCcUIsSUFBekIsQ0FBOEIzRCxDQUFDLENBQUNBLENBQUMsQ0FBQ3lELFNBQUYsQ0FBWTJDLEtBQVosQ0FBRCxDQUFELENBQXNCekMsSUFBdEIsRUFBOUI7QUFDRDtBQUNGLGFBWkQ7O0FBY0EsaUJBQUtzQyxPQUFMO0FBQ0Q7QUFDRixTQXBCUSxrQkFvQkYsSUFwQkU7QUFMSSxPQUFmO0FBMkJELEtBcFJlO0FBc1JoQmQsV0FBTyxFQUFFLG1CQUFZO0FBQ25CdEIsWUFBTSxDQUFDOUQsRUFBUCxDQUFVMEYsSUFBVixDQUFlO0FBQ2JDLFdBQUcsRUFBRSxLQUFLbkYsTUFBTCxDQUFZK0YsSUFBWixDQUFpQkMsR0FEVDtBQUVibkUsWUFBSSxFQUFFLE1BRk87QUFHYkMsWUFBSSxFQUFFLEtBQUt5RCxlQUFMLEtBQXlCLE9BQXpCLEdBQW1DLEtBQUszRjtBQUhqQyxPQUFmO0FBS0QsS0E1UmU7QUE4UmhCK0MsY0FBVSxFQUFFLG9CQUFVL0MsR0FBVixFQUFlO0FBQUE7O0FBQ3pCQSxTQUFHLEdBQUdBLEdBQUcsSUFBSSxLQUFLQSxHQUFsQjtBQUVBLGFBQU8sSUFBSSxxRkFBUSxVQUFDcUcsT0FBRCxFQUFVQyxNQUFWLEVBQXFCO0FBQ3RDLFlBQUl0RyxHQUFKLEVBQVM7QUFDUDBELGdCQUFNLENBQUM5RCxFQUFQLENBQVUwRixJQUFWLENBQWU7QUFDYkMsZUFBRyxFQUFFLE1BQUksQ0FBQ25GLE1BQUwsQ0FBWStGLElBQVosQ0FBaUJJLEtBRFQ7QUFFYnRFLGdCQUFJLEVBQUUsTUFGTztBQUdiQyxnQkFBSSxFQUFFLFNBQVNsQyxHQUhGO0FBSWI0RixtQkFBTyxFQUFFLG1CQUFNO0FBQ2JTLHFCQUFPO0FBQ1IsYUFOWTtBQU9ieEYsaUJBQUssRUFBRSxlQUFDaUIsQ0FBRCxFQUFPO0FBQ1p3RSxvQkFBTSxDQUFDeEUsQ0FBRCxDQUFOO0FBQ0Q7QUFUWSxXQUFmO0FBV0Q7QUFDRixPQWRNLENBQVA7QUFlRCxLQWhUZTtBQWtUaEJxQixRQUFJLEVBQUUsY0FBVXFELEtBQVYsRUFBaUJ2RyxRQUFqQixFQUEyQjtBQUMvQixVQUFJMEIsS0FBSyxHQUFHLElBQVo7O0FBRUErQixZQUFNLENBQUM5RCxFQUFQLENBQVUwRixJQUFWLENBQWU7QUFDYkMsV0FBRyxFQUFFNUQsS0FBSyxDQUFDdkIsTUFBTixDQUFhb0YsS0FBYixDQUFtQmlCLElBRFg7QUFFYnhFLFlBQUksRUFBRSxLQUZPO0FBR2J5RCxnQkFBUSxFQUFFLE1BSEc7QUFJYnhELFlBQUksRUFBRXNFLEtBSk87QUFLYlosZUFBTyxFQUFFLGlCQUFVMUQsSUFBVixFQUFnQjtBQUN2Qix5R0FBQUEsSUFBSSxNQUFKLENBQUFBLElBQUksRUFBUyxVQUFVd0UsR0FBVixFQUFlckQsQ0FBZixFQUFrQjtBQUM3QixnQkFBSXFELEdBQUcsQ0FBQ2pELE9BQUosS0FBZ0IsQ0FBcEIsRUFBdUI7QUFDckI5QixtQkFBSyxDQUFDM0IsR0FBTixHQUFZMEcsR0FBRyxDQUFDbEUsRUFBaEI7QUFDRDtBQUNGLFdBSkcsQ0FBSjs7QUFNQSxjQUFJdkMsUUFBSixFQUFjO0FBQ1pBLG9CQUFRLENBQUNpQyxJQUFELENBQVI7QUFDRDtBQUNGO0FBZlksT0FBZjtBQWlCRCxLQXRVZTtBQXdVaEJ5RCxtQkFBZSxFQUFFLDJCQUFZO0FBQzNCLFVBQUl6RCxJQUFKOztBQUNBLFVBQUksS0FBS2hDLFFBQUwsS0FBa0IsSUFBdEIsRUFBNEI7QUFDMUJnQyxZQUFJLEdBQUdyQyxDQUFDLENBQUMsS0FBS0UsSUFBTixDQUFELENBQWEyQyxPQUFiLENBQXFCLE1BQXJCLEVBQTZCaUUsU0FBN0IsRUFBUDtBQUNELE9BRkQsTUFFTztBQUNMekUsWUFBSSxHQUFHLENBQUNyQyxDQUFDLENBQUMsS0FBS0UsSUFBTixDQUFELENBQWFZLElBQWIsQ0FBa0IsTUFBbEIsQ0FBRCxFQUE0QmQsQ0FBQyxDQUFDLEtBQUtFLElBQU4sQ0FBRCxDQUFhd0QsR0FBYixFQUE1QixFQUFnRFksSUFBaEQsQ0FBcUQsR0FBckQsQ0FBUDtBQUNEOztBQUVELGFBQU9qQyxJQUFJLEdBQUcsT0FBUCxHQUFpQnJDLENBQUMsQ0FBQyxLQUFLRSxJQUFOLENBQUQsQ0FBYVksSUFBYixDQUFrQixNQUFsQixDQUF4QjtBQUNELEtBalZlO0FBbVZoQjhCLGFBQVMsRUFBRSxtQkFBVUQsRUFBVixFQUFjdkMsUUFBZCxFQUF3QjtBQUNqQyxVQUFJMEIsS0FBSyxHQUFHLElBQVo7O0FBQ0FhLFFBQUUsR0FBR0EsRUFBRSxJQUFJLEtBQUtsQyxPQUFoQjs7QUFFQSxVQUFJLENBQUNrQyxFQUFMLEVBQVM7QUFDUDtBQUNEOztBQUVELFVBQUlBLEVBQUUsSUFBSSxLQUFLbEMsT0FBZixFQUF3QjtBQUN0QixhQUFLQSxPQUFMLEdBQWUsSUFBZjtBQUNEOztBQUVEb0QsWUFBTSxDQUFDOUQsRUFBUCxDQUFVMEYsSUFBVixDQUFlO0FBQ2JDLFdBQUcsRUFBRTVELEtBQUssQ0FBQ3ZCLE1BQU4sQ0FBYW9GLEtBQWIsQ0FBbUJvQixNQUFuQixHQUE0QixHQUE1QixHQUFrQ3BFLEVBRDFCO0FBRWJQLFlBQUksRUFBRSxNQUZPO0FBR2J5RCxnQkFBUSxFQUFFLE1BSEc7QUFJYkUsZUFBTyxFQUFFLG1CQUFZO0FBQ25CLGNBQUkzRixRQUFKLEVBQWM7QUFDWkEsb0JBQVE7QUFDVDtBQUNGO0FBUlksT0FBZjtBQVVELEtBeldlO0FBMldoQjBFLFNBQUssRUFBRSxlQUFVbkMsRUFBVixFQUFjO0FBQ25CLFdBQUtsQyxPQUFMLEdBQWVrQyxFQUFmO0FBQ0QsS0E3V2U7QUErV2hCc0QsV0FBTyxFQUFFLG1CQUFZO0FBQ25CLFdBQUt4RixPQUFMLEdBQWUsSUFBZjtBQUNEO0FBalhlLEdBQWxCO0FBb1hBLE1BQUl3RSxVQUFVLEdBQUc7QUFDZmhFLFFBQUksRUFBRSxjQUFVK0YsSUFBVixFQUFnQjNFLElBQWhCLEVBQXNCO0FBQzFCLFdBQUssSUFBSW1CLENBQVQsSUFBY25CLElBQWQsRUFBb0I7QUFDbEIsWUFBSWMsSUFBSSxHQUFHSyxDQUFYOztBQUNBLFlBQUluQixJQUFJLENBQUNtQixDQUFELENBQUosWUFBbUJ5RCxLQUF2QixFQUE4QjtBQUM1QjlELGNBQUksR0FBR0EsSUFBSSxHQUFHLElBQWQ7QUFDQSxlQUFLK0QsUUFBTCxDQUFjRixJQUFJLENBQUM3RCxJQUFELENBQWxCLEVBQTBCZCxJQUFJLENBQUNtQixDQUFELENBQTlCO0FBQ0QsU0FIRCxNQUdPO0FBQ0wsZUFBSzJELE1BQUwsQ0FBWUgsSUFBSSxDQUFDN0QsSUFBRCxDQUFoQixFQUF3QmQsSUFBSSxDQUFDbUIsQ0FBRCxDQUE1QjtBQUNEO0FBQ0Y7QUFDRixLQVhjO0FBYWYwRCxZQUFRLEVBQUUsa0JBQVVFLFFBQVYsRUFBb0JyQyxNQUFwQixFQUE0QjtBQUNwQyxVQUFJL0UsQ0FBQyxDQUFDb0gsUUFBRCxDQUFELENBQVlDLEVBQVosQ0FBZSxXQUFmLENBQUosRUFBaUM7QUFBQTs7QUFDL0JySCxTQUFDLENBQUNtRyxJQUFGLENBQU9wQixNQUFQLEVBQWUsMEhBQVV2QixDQUFWLEVBQWFFLEdBQWIsRUFBa0I7QUFDL0IsZUFBSzRELFVBQUwsQ0FBZ0JGLFFBQWhCLEVBQTBCMUQsR0FBMUI7QUFDRCxTQUZjLGtCQUVSLElBRlEsQ0FBZjtBQUdELE9BSkQsTUFJTztBQUFBOztBQUNMMUQsU0FBQyxDQUFDbUcsSUFBRixDQUFPcEIsTUFBUCxFQUFlLDRIQUFVdkIsQ0FBVixFQUFhRSxHQUFiLEVBQWtCO0FBQy9CLGVBQUs2RCxPQUFMLENBQWF2SCxDQUFDLENBQUNvSCxRQUFELENBQUQsQ0FBWUksRUFBWixDQUFlaEUsQ0FBZixFQUFrQixDQUFsQixDQUFiLEVBQW1DRSxHQUFuQztBQUNELFNBRmMsbUJBRVIsSUFGUSxDQUFmO0FBR0Q7QUFDRixLQXZCYztBQXlCZnlELFVBQU0sRUFBRSxnQkFBVUMsUUFBVixFQUFvQmhCLEtBQXBCLEVBQTJCO0FBQ2pDLFVBQUlwRyxDQUFDLENBQUNvSCxRQUFELENBQUQsQ0FBWUMsRUFBWixDQUFlLFdBQWYsQ0FBSixFQUFpQztBQUMvQixhQUFLQyxVQUFMLENBQWdCRixRQUFoQixFQUEwQmhCLEtBQTFCO0FBQ0QsT0FGRCxNQUVPLElBQUlwRyxDQUFDLENBQUNvSCxRQUFELENBQUQsQ0FBWUMsRUFBWixDQUFlLFFBQWYsQ0FBSixFQUE4QjtBQUNuQyxhQUFLSSxPQUFMLENBQWFMLFFBQWIsRUFBdUJoQixLQUF2QjtBQUNELE9BRk0sTUFFQSxJQUFJcEcsQ0FBQyxDQUFDb0gsUUFBRCxDQUFELENBQVlDLEVBQVosQ0FBZSxRQUFmLENBQUosRUFBOEI7QUFDbkMsYUFBS0ssUUFBTCxDQUFjTixRQUFkLEVBQXdCaEIsS0FBeEI7QUFDRCxPQUZNLE1BRUE7QUFDTCxhQUFLbUIsT0FBTCxDQUFhSCxRQUFiLEVBQXVCaEIsS0FBdkI7QUFDRDtBQUNGLEtBbkNjO0FBcUNma0IsY0FBVSxFQUFFLG9CQUFVcEgsSUFBVixFQUFnQndELEdBQWhCLEVBQXFCO0FBQy9CMUQsT0FBQyxDQUFDRSxJQUFELENBQUQsQ0FBUWlHLElBQVIsQ0FBYSxZQUFZO0FBQ3ZCLFlBQUluRyxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFjLElBQVIsQ0FBYSxPQUFiLEtBQXlCNEMsR0FBN0IsRUFBa0M7QUFDaEMxRCxXQUFDLENBQUMsSUFBRCxDQUFELENBQVEySCxJQUFSLENBQWEsU0FBYixFQUF3QixJQUF4QjtBQUNBLGlCQUFPLEtBQVA7QUFDRDtBQUNGLE9BTEQ7QUFNRCxLQTVDYztBQThDZkYsV0FBTyxFQUFFLGlCQUFVdkgsSUFBVixFQUFnQndELEdBQWhCLEVBQXFCO0FBQzVCMUQsT0FBQyxDQUFDRSxJQUFELENBQUQsQ0FBUWlHLElBQVIsQ0FBYSxZQUFZO0FBQ3ZCLFlBQUluRyxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFjLElBQVIsQ0FBYSxPQUFiLEtBQXlCNEMsR0FBN0IsRUFBa0M7QUFDaEMxRCxXQUFDLENBQUMsSUFBRCxDQUFELENBQVEySCxJQUFSLENBQWEsU0FBYixFQUF3QixJQUF4QjtBQUNBLGlCQUFPLEtBQVA7QUFDRDtBQUNGLE9BTEQ7QUFNRCxLQXJEYztBQXVEZkQsWUFBUSxFQUFFLGtCQUFVeEgsSUFBVixFQUFnQndELEdBQWhCLEVBQXFCO0FBQzdCMUQsT0FBQyxDQUFDRSxJQUFELENBQUQsQ0FBUTBILFFBQVIsR0FBbUJ6QixJQUFuQixDQUF3QixZQUFZO0FBQ2xDLFlBQUluRyxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFjLElBQVIsQ0FBYSxPQUFiLEtBQXlCNEMsR0FBN0IsRUFBa0M7QUFDaEMxRCxXQUFDLENBQUMsSUFBRCxDQUFELENBQVEySCxJQUFSLENBQWEsVUFBYixFQUF5QixJQUF6QjtBQUNBLGlCQUFPLEtBQVA7QUFDRDtBQUNGLE9BTEQ7QUFNRCxLQTlEYztBQWdFZkosV0FBTyxFQUFFLGlCQUFVckgsSUFBVixFQUFnQndELEdBQWhCLEVBQXFCO0FBQzVCLFVBQUksQ0FBQzFELENBQUMsQ0FBQ0UsSUFBRCxDQUFELENBQVFtSCxFQUFSLENBQVcsb0JBQVgsQ0FBTCxFQUF1QztBQUNyQ3JILFNBQUMsQ0FBQ0UsSUFBRCxDQUFELENBQVF3RCxHQUFSLENBQVlBLEdBQVo7QUFDRDtBQUNGLEtBcEVjLENBdUVqQjs7QUF2RWlCLEdBQWpCOztBQXdFQTFELEdBQUMsQ0FBQzZILEVBQUYsQ0FBS2xDLEtBQUwsR0FBYSxVQUFVbUMsSUFBVixFQUFnQjtBQUFBOztBQUMzQjs7Ozs7OztBQU9BLFFBQUlDLFdBQVcsR0FBRztBQUNoQnpILGVBQVMsRUFBRSxJQURLO0FBRWhCRCxjQUFRLEVBQUUsS0FGTTtBQUdoQkQsY0FBUSxFQUFFO0FBSE0sS0FBbEI7QUFNQTBILFFBQUksR0FBRzlILENBQUMsQ0FBQ2dJLE1BQUYsQ0FBUyxFQUFULEVBQWFELFdBQWIsRUFBMEJELElBQTFCLENBQVA7O0FBRUEsUUFBSSxDQUFDQSxJQUFJLENBQUMzSCxHQUFOLElBQWEsQ0FBQzJILElBQUksQ0FBQ0csT0FBbkIsSUFBOEIsQ0FBQ0gsSUFBSSxDQUFDSSxPQUF4QyxFQUFpRDtBQUMvQ25ILGFBQU8sQ0FBQ0MsS0FBUixDQUFjLG9DQUFkO0FBQ0EsYUFBTyxLQUFQO0FBQ0Q7O0FBRUQsUUFBSTJFLEtBQUssR0FBRyxJQUFJMUYsS0FBSixDQUFVLElBQVYsRUFBZ0I2SCxJQUFJLENBQUMzSCxHQUFyQixFQUEwQjJILElBQUksQ0FBQzFILFFBQS9CLEVBQXlDMEgsSUFBSSxDQUFDekgsUUFBOUMsRUFBd0R5SCxJQUFJLENBQUN4SCxTQUE3RCxFQUF3RXdILElBQUksQ0FBQ3ZILE1BQTdFLENBQVo7O0FBRUEsNEdBQUFQLENBQUMsQ0FBQzhILElBQUksQ0FBQ0csT0FBTixDQUFELENBQWdCRSxNQUFoQixDQUF1QixhQUF2QixvQkFBMkMsYUFBM0MsRUFBMEQsVUFBVWxHLENBQVYsRUFBYTtBQUNyRUEsT0FBQyxDQUFDQyxjQUFGO0FBQ0F5RCxXQUFLLENBQUN2QyxNQUFOLENBQWEsSUFBYjtBQUNELEtBSEQ7O0FBS0EsNEdBQUFwRCxDQUFDLENBQUM4SCxJQUFJLENBQUNJLE9BQU4sQ0FBRCxDQUFnQkMsTUFBaEIsQ0FBdUIsYUFBdkIsb0JBQTJDLGFBQTNDLEVBQTBELFVBQVVsRyxDQUFWLEVBQWE7QUFDckVBLE9BQUMsQ0FBQ0MsY0FBRjtBQUNBeUQsV0FBSyxDQUFDTixRQUFOO0FBQ0QsS0FIRDs7QUFLQSxXQUFPTSxLQUFQO0FBQ0QsR0FsQ0Q7QUFtQ0QsQ0FsZ0JELEVBa2dCRzlCLE1BQU0sQ0FBQzlELEVBbGdCVixFQWtnQmM4RCxNQUFNLENBQUN1RSxNQWxnQnJCLEU7Ozs7Ozs7Ozs7O0FDREEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsaUJBQWlCLG1CQUFPLENBQUMsZ0dBQW9DLEU7Ozs7Ozs7Ozs7O0FDQTdELDhHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLFdBQVcsbUJBQU8sQ0FBQywyRUFBc0I7QUFDekMsdUNBQXVDLDRCQUE0Qjs7QUFFbkUseUNBQXlDO0FBQ3pDO0FBQ0E7Ozs7Ozs7Ozs7OztBQ0xBLCtHOzs7Ozs7Ozs7OztBQ0FBLGlCQUFpQixtQkFBTyxDQUFDLGlGQUF5Qjs7Ozs7Ozs7Ozs7O0FDQWxELGdDIiwiZmlsZSI6ImFzc2V0cy9jb3JlL2NvbW1vbi9qcy9kcmFmdC5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vY29yZS9jb21tb24vanMvZHJhZnQuanNcIik7XG4iLCIvLyBAVE9ETyDsnqzsnpHshLEuIOyCrOyaqeuQmOyngCDslYrsnYxcbihmdW5jdGlvbiAoWEUsICQpIHtcbiAgJ3VzZSBzdHJpY3QnXG4gIC8qKlxuICAqIEBjbGFzc1xuICAqL1xuICBmdW5jdGlvbiBEcmFmdCAoZWxlbSwga2V5LCBjYWxsYmFjaywgd2l0aEZvcm0sIGNvbnRhaW5lciwgYXBpVXJsKSB7XG4gICAgdGhpcy5rZXkgPSBrZXlcbiAgICB0aGlzLmVsZW0gPSBlbGVtXG4gICAgdGhpcy5jYWxsYmFjayA9IGNhbGxiYWNrXG4gICAgdGhpcy53aXRoRm9ybSA9IHdpdGhGb3JtXG4gICAgdGhpcy5jb250YWluZXIgPSBjb250YWluZXJcbiAgICB0aGlzLmFwaVVybCA9IGFwaVVybFxuXG4gICAgdGhpcy5pbnRlcnZhbCA9IG51bGxcblxuICAgIHRoaXMuZHJhZnRJZCA9IG51bGxcbiAgICB0aGlzLmNvbXBvbmVudCA9IG51bGxcbiAgICB0aGlzLiRjb21wb25lbnQgPSAkKClcbiAgICB0aGlzLmNvbXBvbmVudE5hbWUgPSAnJ1xuICAgIHRoaXMudWlkID0gbnVsbFxuXG4gICAgaWYgKCEkKHRoaXMuZWxlbSkuYXR0cignbmFtZScpIHx8ICQodGhpcy5lbGVtKS5hdHRyKCduYW1lJykgPT0gJycpIHtcbiAgICAgIGNvbnNvbGUuZXJyb3IoXCJNdXN0IHNldCAnbmFtZScgYXR0cmlidXRlIFwiKVxuICAgICAgcmV0dXJuXG4gICAgfVxuXG4gICAgdGhpcy5pbml0KClcbiAgICB0aGlzLmJpbmRFdmVudHMoKVxuXG4gICAgcmV0dXJuIHRoaXNcbiAgfVxuXG4gIC8qKlxuICAqIEBsZW5kcyBEcmFmdFxuICAqL1xuICBEcmFmdC5wcm90b3R5cGUgPSB7XG4gICAgLyoqXG4gICAgKiDstIjquLDtmZTtlZzri6QuXG4gICAgKiBAZnVuY3Rpb25cbiAgICAqL1xuICAgIGluaXQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHRoaXMudWlkID0gdGhpcy5fZ2V0VWlkKClcbiAgICAgIHRoaXMuYXBwZW5kQ29tcG9uZW50KClcblxuICAgICAgUHJvbWlzZS5hbGwoW1hFLmFwcCgnTGFuZycpLCBYRS5hcHAoJ1JlcXVlc3QnKV0pLnRoZW4oZnVuY3Rpb24gKGFwcCkge1xuICAgICAgICBhcHBbMF0ucmVxdWVzdFRyYW5zQWxsKFsneGU6OmRyYWZ0U2F2ZScsICd4ZTo6ZHJhZnRTYXZlZCcsICd4ZTo6YXV0b1NhdmUnLCAneGU6OmRyYWZ0TG9hZCddKVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgX2dldFVpZDogZnVuY3Rpb24gKCkge1xuICAgICAgcmV0dXJuIE1hdGgucmFuZG9tKCkudG9TdHJpbmcoMzYpLnN1YnN0cmluZygyLCAxNSkgK1xuICAgICAgTWF0aC5yYW5kb20oKS50b1N0cmluZygzNikuc3Vic3RyaW5nKDIsIDE1KVxuICAgIH0sXG5cbiAgICBiaW5kRXZlbnRzOiBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgX3RoaXMgPSB0aGlzXG5cbiAgICAgICQodGhpcy5lbGVtKS5vbignaW5wdXQuZHJhZnQnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIF90aGlzLnNhdmVFdmVudEhhbmRsZXIoKVxuICAgICAgfSlcblxuICAgICAgX3RoaXMuJGNvbXBvbmVudC5vbignY2xpY2snLCAnLmRyYWZ0X3RpdGxlJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG4gICAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgICAgdmFyIHR5cGUgPSAkdGhpcy5kYXRhKCd0eXBlJylcbiAgICAgICAgdmFyIGl0ZW0gPSAkKHRoaXMpLmRhdGEoJ2l0ZW0nKVxuXG4gICAgICAgIF90aGlzLm9uQXBwbHkoaXRlbSlcblxuICAgICAgICBzd2l0Y2ggKHR5cGUpIHtcbiAgICAgICAgICBjYXNlICdtb2RhbCc6XG4gICAgICAgICAgICBfdGhpcy4kY29tcG9uZW50LnhlTW9kYWwoJ2hpZGUnKVxuICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgICBjYXNlICdjb2xsYXBzZSc6XG4gICAgICAgICAgICBfdGhpcy4kY29tcG9uZW50LnNob3coKS5maW5kKCcucGFuZWwtYm9keScpLmVtcHR5KClcbiAgICAgICAgICAgIGJyZWFrXG4gICAgICAgIH1cbiAgICAgIH0pXG5cbiAgICAgIF90aGlzLiRjb21wb25lbnQub24oJ2NsaWNrJywgJy54ZS1kcmFmdEJ0bkNsb3NlTW9kYWwnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIF90aGlzLiRjb21wb25lbnQueGVNb2RhbCgnaGlkZScpXG4gICAgICB9KVxuXG4gICAgICBfdGhpcy4kY29tcG9uZW50Lm9uKCdjbGljaycsICcuYnRuX2RyYWZ0X2RlbGV0ZScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKVxuXG4gICAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgICAgdmFyIGlkID0gJHRoaXMuZGF0YSgnaWQnKVxuXG4gICAgICAgIF90aGlzLnJlcURlbGV0ZShpZCwgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICR0aGlzLmNsb3Nlc3QoJ2xpJykucmVtb3ZlKClcbiAgICAgICAgfSlcbiAgICAgIH0pXG5cbiAgICAgIFhFLmFwcCgnRm9ybScpLnRoZW4oYXBwRm9ybSA9PiB7XG4gICAgICAgIGFwcEZvcm0uZ2V0KF90aGlzLmVsZW0pLiQkb24oJ3N1Ym1pdCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICByZXR1cm4gX3RoaXMuZGVsZXRlQXV0byhfdGhpcy5rZXkpIC8vIFByb21pc2VcbiAgICAgICAgfSwgeyBuYW1lOiAneGUuZHJhZnQnIH0pXG4gICAgICB9KVxuICAgIH0sXG5cbiAgICB0b2dnbGU6IGZ1bmN0aW9uIChzaG93KSB7XG4gICAgICB2YXIgX3RoaXMgPSB0aGlzXG5cbiAgICAgIHN3aXRjaCAodGhpcy5jb21wb25lbnROYW1lKSB7XG4gICAgICAgIGNhc2UgJ21vZGFsJzpcbiAgICAgICAgICBpZiAoIXNob3cgJiYgX3RoaXMuJGNvbXBvbmVudC5oYXNDbGFzcygnaW4nKSkge1xuICAgICAgICAgICAgX3RoaXMuJGNvbXBvbmVudC54ZU1vZGFsKCdoaWRlJylcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgX3RoaXMubG9hZCh7IGtleTogX3RoaXMua2V5IH0sIGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgICAgICAgIHZhciB0ZW1wID0gYDxkaXYgY2xhc3M9XCJkcmFmdF9zYXZlX2xpc3RcIj5gXG4gICAgICAgICAgICAgIHRlbXAgKz0gYDx1bD5gXG5cbiAgICAgICAgICAgICAgZGF0YS5mb3JFYWNoKGZ1bmN0aW9uIChpdGVtLCBpKSB7XG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPGxpPmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8YSBocmVmPScjJyBjbGFzcz0nZHJhZnRfdGl0bGUnIGRhdGEtaXRlbT0nJHtKU09OLnN0cmluZ2lmeShpdGVtKX0nIGRhdGEtdHlwZT1cIm1vZGFsXCI+JHskKCQucGFyc2VIVE1MKGl0ZW0udmFsKSkudGV4dCgpfTwvYT5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImRyYWZ0X2luZm9cIj5gXG5cbiAgICAgICAgICAgICAgICBpZiAoaXRlbS5pc19hdXRvID09IDEpIHtcbiAgICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiZHJhZnRfc3RhdGVcIj4ke3dpbmRvdy5YRS5MYW5nLnRyYW5zKCd4ZTo6YXV0b1NhdmUnKX08L3NwYW4+YFxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cImRyYWZ0X3N0YXRlIHYyXCI+JHt3aW5kb3cuWEUuTGFuZy50cmFucygneGU6OmRyYWZ0U2F2ZScpfTwvc3Bhbj5gXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJkcmFmdF9kYXRlXCI+JHtpdGVtLmNyZWF0ZWRfYXQuc3Vic3RyKDAsIDE2KS5yZXBsYWNlKC8tL2csICcgJyl9PC9zcGFuPmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuX2RyYWZ0X2RlbGV0ZVwiIGRhdGEtaWQ9XCIke2l0ZW0uaWR9XCI+PGkgY2xhc3M9XCJ4aS1jbG9zZVwiPjwvaT48L2E+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDwvZGl2PmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8L2xpPmBcbiAgICAgICAgICAgICAgfSlcblxuICAgICAgICAgICAgICB0ZW1wICs9IGA8L3VsPmBcbiAgICAgICAgICAgICAgdGVtcCArPSBgPC9kaXY+YFxuXG4gICAgICAgICAgICAgIF90aGlzLiRjb21wb25lbnQuZmluZCgnLnhlLW1vZGFsLWJvZHknKS5odG1sKHRlbXApXG4gICAgICAgICAgICAgIF90aGlzLiRjb21wb25lbnQueGVNb2RhbCgnc2hvdycpXG4gICAgICAgICAgICB9KVxuICAgICAgICAgIH1cblxuICAgICAgICAgIGJyZWFrXG4gICAgICAgIGNhc2UgJ2NvbGxhcHNlJzpcblxuICAgICAgICAgIGlmICghc2hvdyAmJiBfdGhpcy4kY29tcG9uZW50Lmhhc0NsYXNzKCdpbicpKSB7XG4gICAgICAgICAgICBfdGhpcy4kY29tcG9uZW50LmhpZGUoKVxuICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBfdGhpcy5sb2FkKHsga2V5OiBfdGhpcy5rZXkgfSwgZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgICAgICAgdmFyIHRlbXAgPSBgPGRpdiBjbGFzcz1cImRyYWZ0X3NhdmVfbGlzdFwiPmBcbiAgICAgICAgICAgICAgdGVtcCArPSBgPHVsPmBcblxuICAgICAgICAgICAgICBkYXRhLmZvckVhY2goZnVuY3Rpb24gKGl0ZW0sIGkpIHtcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8bGk+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxhIGhyZWY9JyMnIGNsYXNzPSdkcmFmdF90aXRsZScgZGF0YS1pdGVtPScke0pTT04uc3RyaW5naWZ5KGl0ZW0pfScgZGF0YS10eXBlPVwiY29sbGFwc2VcIj4keyQoJC5wYXJzZUhUTUwoaXRlbS52YWwpKS50ZXh0KCl9PC9hPmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiZHJhZnRfaW5mb1wiPmBcblxuICAgICAgICAgICAgICAgIGlmIChpdGVtLmlzX2F1dG8gPT0gMSkge1xuICAgICAgICAgICAgICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJkcmFmdF9zdGF0ZVwiPiR7d2luZG93LlhFLkxhbmcudHJhbnMoJ3hlOjphdXRvU2F2ZScpfTwvc3Bhbj5gXG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiZHJhZnRfc3RhdGUgdjJcIj4ke3dpbmRvdy5YRS5MYW5nLnRyYW5zKCd4ZTo6ZHJhZnRTYXZlJyl9PC9zcGFuPmBcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cImRyYWZ0X2RhdGVcIj4ke2l0ZW0uY3JlYXRlZF9hdC5zdWJzdHIoMCwgMTYpLnJlcGxhY2UoLy0vZywgJyAnKX08L3NwYW4+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG5fZHJhZnRfZGVsZXRlXCIgZGF0YS1pZD1cIiR7aXRlbS5pZH1cIj48aSBjbGFzcz1cInhpLWNsb3NlXCI+PC9pPjwvYT5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPC9kaXY+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDwvbGk+YFxuICAgICAgICAgICAgICB9KVxuXG4gICAgICAgICAgICAgIHRlbXAgKz0gYDwvdWw+YFxuICAgICAgICAgICAgICB0ZW1wICs9IGA8L2Rpdj5gXG5cbiAgICAgICAgICAgICAgX3RoaXMuJGNvbXBvbmVudC5maW5kKCcucGFuZWwtYm9keScpLmh0bWwodGVtcClcbiAgICAgICAgICAgICAgX3RoaXMuJGNvbXBvbmVudC5zaG93KClcbiAgICAgICAgICAgIH0pXG4gICAgICAgICAgfVxuXG4gICAgICAgICAgYnJlYWtcbiAgICAgIH1cbiAgICB9LFxuXG4gICAgZ2V0TW9kYWxUZW1wbGF0ZTogZnVuY3Rpb24gKCkge1xuICAgICAgcmV0dXJuIFtcbiAgICAgICAgJzxkaXYgY2xhc3M9XCJ4ZS1tb2RhbCBmYWRlXCIgaWQ9XCJ4ZS1kcmFmdE1vZGFsXCI+JyxcbiAgICAgICAgJzxkaXYgY2xhc3M9XCJ4ZS1tb2RhbC1kaWFsb2dcIj4nLFxuICAgICAgICAnPGRpdiBjbGFzcz1cInhlLW1vZGFsLWNvbnRlbnRcIj4nLFxuICAgICAgICAnPGRpdiBjbGFzcz1cInhlLW1vZGFsLWhlYWRlclwiPicsXG4gICAgICAgICc8YnV0dG9uIHR5cGU9XCJidXR0b25cIiBjbGFzcz1cImJ0bi1jbG9zZSB4ZS1kcmFmdEJ0bkNsb3NlXCIgZGF0YS1kaXNtaXNzPVwieGUtbW9kYWxcIiBhcmlhLWxhYmVsPVwiQ2xvc2VcIj48aSBjbGFzcz1cInhpLWNsb3NlXCI+PC9pPjwvYnV0dG9uPicsXG4gICAgICAgICc8c3Ryb25nIGNsYXNzPVwieGUtbW9kYWwtdGl0bGVcIj48L3N0cm9uZz4nLFxuICAgICAgICAnPC9kaXY+JyxcbiAgICAgICAgJzxkaXYgY2xhc3M9XCJ4ZS1tb2RhbC1ib2R5XCI+PC9kaXY+JyxcbiAgICAgICAgJzxkaXYgY2xhc3M9XCJ4ZS1tb2RhbC1mb290ZXJcIj4nLFxuICAgICAgICAnPGJ1dHRvbiB0eXBlPVwiYnV0dG9uXCIgY2xhc3M9XCJ4ZS1idG4geGUtYnRuLWRlZmF1bHRcIiBkYXRhLWRpc21pc3M9XCJ4ZS1tb2RhbFwiPkNsb3NlPC9idXR0b24+JyxcbiAgICAgICAgJzwvZGl2PicsXG4gICAgICAgICc8L2Rpdj4nLFxuICAgICAgICAnPC9kaXY+JyxcbiAgICAgICAgJzwvZGl2PidcbiAgICAgIF0uam9pbignXFxuJylcbiAgICB9LFxuXG4gICAgZ2V0Q29sbGFwc2VUZW1wbGF0ZTogZnVuY3Rpb24gKCkge1xuICAgICAgcmV0dXJuIFtcbiAgICAgICAgJzxkaXYgY2xhc3M9XCJwYW5lbCBwYW5lbC1kZWZhdWx0XCI+JyxcbiAgICAgICAgJzxkaXYgY2xhc3M9XCJwYW5lbC1ib2R5XCI+PC9kaXY+JyxcbiAgICAgICAgJzwvZGl2PidcbiAgICAgIF0uam9pbignXFxuJylcbiAgICB9LFxuXG4gICAgYXBwZW5kQ29tcG9uZW50OiBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgICB2YXIgJGNvbnRhaW5lciA9ICQoJzxkaXY+JylcblxuICAgICAgaWYgKCQodGhpcy5jb250YWluZXIpLmxlbmd0aCA8IDEpIHtcbiAgICAgICAgJCh0aGlzLmVsZW0pLmNsb3Nlc3QoJ2Zvcm0nKS5hZnRlcigkY29udGFpbmVyLmh0bWwodGhpcy5nZXRNb2RhbFRlbXBsYXRlKCkpKVxuICAgICAgICB0aGlzLmNvbXBvbmVudE5hbWUgPSAnbW9kYWwnXG4gICAgICAgIHRoaXMuJGNvbXBvbmVudCA9ICQoJyN4ZS1kcmFmdE1vZGFsJylcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHRoaXMuY29tcG9uZW50TmFtZSA9ICdjb2xsYXBzZSdcbiAgICAgICAgdGhpcy4kY29tcG9uZW50ID0gJCh0aGlzLmNvbnRhaW5lcilcblxuICAgICAgICB2YXIgY29sbGFwc2VDbGFzcyA9IHRoaXMuX2NvbGxhcHNlQ2xhc3MoKVxuXG4gICAgICAgIHRoaXMuJGNvbXBvbmVudC5hZGRDbGFzcyhbY29sbGFwc2VDbGFzcywgJ2NvbGxhcHNlJ10uam9pbignICcpKS5odG1sKCRjb250YWluZXIuaHRtbChfdGhpcy5nZXRDb2xsYXBzZVRlbXBsYXRlKCkpKVxuICAgICAgfVxuICAgIH0sXG5cbiAgICBvbkFwcGx5OiBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgdmFyIF90aGlzID0gdGhpc1xuICAgICAgdGhpcy5zZXRJZChkYXRhLmlkKVxuXG4gICAgICB2YXIgdmFsdWVzID0gZGF0YS5ldGNcbiAgICAgIHZhbHVlc1skKF90aGlzLmVsZW0pLmF0dHIoJ25hbWUnKV0gPSBkYXRhLnZhbFxuXG4gICAgICBkYXRhU2V0dGVyLmluaXQoJChfdGhpcy5lbGVtKS5jbG9zZXN0KCdmb3JtJylbMF0sIHZhbHVlcylcbiAgICAgIHRoaXMuY2FsbGJhY2sodmFsdWVzKVxuICAgIH0sXG5cbiAgICBfY29sbGFwc2VDbGFzczogZnVuY3Rpb24gKCkge1xuICAgICAgcmV0dXJuICdfX3hlX2RyYWZ0X2NvbGxhcHNlXycgKyB0aGlzLnVpZFxuICAgIH0sXG5cbiAgICBzYXZlRXZlbnRIYW5kbGVyOiBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgICB0aGlzLmludGVydmFsQ2xlYXIoKVxuXG4gICAgICB0aGlzLmludGVydmFsID0gc2V0VGltZW91dChmdW5jdGlvbiAoKSB7XG4gICAgICAgIF90aGlzLnNldEF1dG8oKVxuICAgICAgICBfdGhpcy5pbnRlcnZhbENsZWFyKClcbiAgICAgIH0sIDMwMDApXG4gICAgfSxcblxuICAgIGludGVydmFsQ2xlYXI6IGZ1bmN0aW9uICgpIHtcbiAgICAgIGlmICh0aGlzLmludGVydmFsKSB7XG4gICAgICAgIGNsZWFyVGltZW91dCh0aGlzLmludGVydmFsKVxuICAgICAgfVxuICAgIH0sXG5cbiAgICBkcmFmdFNldDogZnVuY3Rpb24gKCkge1xuICAgICAgaWYgKCQudHJpbSgkKHRoaXMuZWxlbSkudmFsKCkpID09ICcnKSB7XG4gICAgICAgIHJldHVyblxuICAgICAgfVxuXG4gICAgICBpZiAodGhpcy5kcmFmdElkID09IG51bGwpIHtcbiAgICAgICAgdGhpcy5yZXFQb3N0KClcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHRoaXMucmVxUHV0KClcbiAgICAgIH1cblxuICAgICAgd2luZG93LlhFLnRvYXN0KCdzdWNjZXNzJywgd2luZG93LlhFLkxhbmcudHJhbnMoJ3hlOjpkcmFmdFNhdmVkJykpXG4gICAgfSxcblxuICAgIHJlcVBvc3Q6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHdpbmRvdy5YRS5hamF4KHtcbiAgICAgICAgdXJsOiB0aGlzLmFwaVVybC5kcmFmdC5hZGQsXG4gICAgICAgIHR5cGU6ICdwb3N0JyxcbiAgICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgICAgZGF0YTogdGhpcy5nZXRSZXFTZXJpYWxpemUoKSArICcma2V5PScgKyB0aGlzLmtleSxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGpzb24pIHtcbiAgICAgICAgICBpZiAoanNvbi5kcmFmdElkID09PSBudWxsKSB7XG4gICAgICAgICAgICB0aGlzLnVuc2V0SWQoKVxuICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICB0aGlzLnNldElkKGpzb24uZHJhZnRJZClcbiAgICAgICAgICB9XG4gICAgICAgIH0uYmluZCh0aGlzKVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgcmVxUHV0OiBmdW5jdGlvbiAoKSB7XG4gICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgIHVybDogdGhpcy5hcGlVcmwuZHJhZnQudXBkYXRlICsgJy8nICsgdGhpcy5kcmFmdElkLFxuICAgICAgICB0eXBlOiAncG9zdCcsXG4gICAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICAgIGRhdGE6IHRoaXMuZ2V0UmVxU2VyaWFsaXplKCksXG4gICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChqc29uKSB7XG4gICAgICAgICAgdmFyIF90aGlzID0gdGhpc1xuXG4gICAgICAgICAgaWYgKGpzb24uZHJhZnRJZCA9PT0gbnVsbCkge1xuICAgICAgICAgICAgdGhpcy4kY29tcG9uZW50LmZpbmQoJ2xpID4gYScpLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICAgICAgICAgIHZhciBpdGVtID0gJHRoaXMuZGF0YSgnaXRlbScpXG5cbiAgICAgICAgICAgICAgaWYgKGl0ZW0uaWQgPT09IF90aGlzLmRyYWZ0SWQpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmFsdWUgPSAkKF90aGlzLmVsZW0pLnZhbCgpXG5cbiAgICAgICAgICAgICAgICBpdGVtLnZhbCA9IHZhbHVlXG4gICAgICAgICAgICAgICAgaXRlbS5ldGMuY29udGVudCA9IHZhbHVlXG5cbiAgICAgICAgICAgICAgICAkdGhpcy5kYXRhKCdpdGVtJywgaXRlbSkudGV4dCgkKCQucGFyc2VIVE1MKHZhbHVlKSkudGV4dCgpKVxuICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KVxuXG4gICAgICAgICAgICB0aGlzLnVuc2V0SWQoKVxuICAgICAgICAgIH1cbiAgICAgICAgfS5iaW5kKHRoaXMpXG4gICAgICB9KVxuICAgIH0sXG5cbiAgICBzZXRBdXRvOiBmdW5jdGlvbiAoKSB7XG4gICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgIHVybDogdGhpcy5hcGlVcmwuYXV0by5zZXQsXG4gICAgICAgIHR5cGU6ICdwb3N0JyxcbiAgICAgICAgZGF0YTogdGhpcy5nZXRSZXFTZXJpYWxpemUoKSArICcma2V5PScgKyB0aGlzLmtleVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgZGVsZXRlQXV0bzogZnVuY3Rpb24gKGtleSkge1xuICAgICAga2V5ID0ga2V5IHx8IHRoaXMua2V5XG5cbiAgICAgIHJldHVybiBuZXcgUHJvbWlzZSgocmVzb2x2ZSwgcmVqZWN0KSA9PiB7XG4gICAgICAgIGlmIChrZXkpIHtcbiAgICAgICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgICAgICB1cmw6IHRoaXMuYXBpVXJsLmF1dG8udW5zZXQsXG4gICAgICAgICAgICB0eXBlOiAncG9zdCcsXG4gICAgICAgICAgICBkYXRhOiAna2V5PScgKyBrZXksXG4gICAgICAgICAgICBzdWNjZXNzOiAoKSA9PiB7XG4gICAgICAgICAgICAgIHJlc29sdmUoKVxuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGVycm9yOiAoZSkgPT4ge1xuICAgICAgICAgICAgICByZWplY3QoZSlcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9KVxuICAgICAgICB9XG4gICAgICB9KVxuICAgIH0sXG5cbiAgICBsb2FkOiBmdW5jdGlvbiAocGFyYW0sIGNhbGxiYWNrKSB7XG4gICAgICB2YXIgX3RoaXMgPSB0aGlzXG5cbiAgICAgIHdpbmRvdy5YRS5hamF4KHtcbiAgICAgICAgdXJsOiBfdGhpcy5hcGlVcmwuZHJhZnQubGlzdCxcbiAgICAgICAgdHlwZTogJ2dldCcsXG4gICAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICAgIGRhdGE6IHBhcmFtLFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICAgIGRhdGEuZm9yRWFjaChmdW5jdGlvbiAob2JqLCBpKSB7XG4gICAgICAgICAgICBpZiAob2JqLmlzX2F1dG8gPT09IDEpIHtcbiAgICAgICAgICAgICAgX3RoaXMua2V5ID0gb2JqLmlkXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfSlcblxuICAgICAgICAgIGlmIChjYWxsYmFjaykge1xuICAgICAgICAgICAgY2FsbGJhY2soZGF0YSlcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0pXG4gICAgfSxcblxuICAgIGdldFJlcVNlcmlhbGl6ZTogZnVuY3Rpb24gKCkge1xuICAgICAgdmFyIGRhdGFcbiAgICAgIGlmICh0aGlzLndpdGhGb3JtID09PSB0cnVlKSB7XG4gICAgICAgIGRhdGEgPSAkKHRoaXMuZWxlbSkuY2xvc2VzdCgnZm9ybScpLnNlcmlhbGl6ZSgpXG4gICAgICB9IGVsc2Uge1xuICAgICAgICBkYXRhID0gWyQodGhpcy5lbGVtKS5hdHRyKCduYW1lJyksICQodGhpcy5lbGVtKS52YWwoKV0uam9pbignPScpXG4gICAgICB9XG5cbiAgICAgIHJldHVybiBkYXRhICsgJyZyZXA9JyArICQodGhpcy5lbGVtKS5hdHRyKCduYW1lJylcbiAgICB9LFxuXG4gICAgcmVxRGVsZXRlOiBmdW5jdGlvbiAoaWQsIGNhbGxiYWNrKSB7XG4gICAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgICBpZCA9IGlkIHx8IHRoaXMuZHJhZnRJZFxuXG4gICAgICBpZiAoIWlkKSB7XG4gICAgICAgIHJldHVyblxuICAgICAgfVxuXG4gICAgICBpZiAoaWQgPT0gdGhpcy5kcmFmdElkKSB7XG4gICAgICAgIHRoaXMuZHJhZnRJZCA9IG51bGxcbiAgICAgIH1cblxuICAgICAgd2luZG93LlhFLmFqYXgoe1xuICAgICAgICB1cmw6IF90aGlzLmFwaVVybC5kcmFmdC5kZWxldGUgKyAnLycgKyBpZCxcbiAgICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgaWYgKGNhbGxiYWNrKSB7XG4gICAgICAgICAgICBjYWxsYmFjaygpXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9KVxuICAgIH0sXG5cbiAgICBzZXRJZDogZnVuY3Rpb24gKGlkKSB7XG4gICAgICB0aGlzLmRyYWZ0SWQgPSBpZFxuICAgIH0sXG5cbiAgICB1bnNldElkOiBmdW5jdGlvbiAoKSB7XG4gICAgICB0aGlzLmRyYWZ0SWQgPSBudWxsXG4gICAgfVxuICB9XG5cbiAgdmFyIGRhdGFTZXR0ZXIgPSB7XG4gICAgaW5pdDogZnVuY3Rpb24gKGZvcm0sIGRhdGEpIHtcbiAgICAgIGZvciAodmFyIGkgaW4gZGF0YSkge1xuICAgICAgICB2YXIgbmFtZSA9IGlcbiAgICAgICAgaWYgKGRhdGFbaV0gaW5zdGFuY2VvZiBBcnJheSkge1xuICAgICAgICAgIG5hbWUgPSBuYW1lICsgJ1tdJ1xuICAgICAgICAgIHRoaXMubXVsdGlwbGUoZm9ybVtuYW1lXSwgZGF0YVtpXSlcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICB0aGlzLnNpbmdsZShmb3JtW25hbWVdLCBkYXRhW2ldKVxuICAgICAgICB9XG4gICAgICB9XG4gICAgfSxcblxuICAgIG11bHRpcGxlOiBmdW5jdGlvbiAoc2VsZWN0b3IsIHZhbHVlcykge1xuICAgICAgaWYgKCQoc2VsZWN0b3IpLmlzKCc6Y2hlY2tib3gnKSkge1xuICAgICAgICAkLmVhY2godmFsdWVzLCBmdW5jdGlvbiAoaSwgdmFsKSB7XG4gICAgICAgICAgdGhpcy50b0NoZWNrYm94KHNlbGVjdG9yLCB2YWwpXG4gICAgICAgIH0uYmluZCh0aGlzKSlcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgICQuZWFjaCh2YWx1ZXMsIGZ1bmN0aW9uIChpLCB2YWwpIHtcbiAgICAgICAgICB0aGlzLnRvSW5wdXQoJChzZWxlY3RvcikuZXEoaSlbMF0sIHZhbClcbiAgICAgICAgfS5iaW5kKHRoaXMpKVxuICAgICAgfVxuICAgIH0sXG5cbiAgICBzaW5nbGU6IGZ1bmN0aW9uIChzZWxlY3RvciwgdmFsdWUpIHtcbiAgICAgIGlmICgkKHNlbGVjdG9yKS5pcygnOmNoZWNrYm94JykpIHtcbiAgICAgICAgdGhpcy50b0NoZWNrYm94KHNlbGVjdG9yLCB2YWx1ZSlcbiAgICAgIH0gZWxzZSBpZiAoJChzZWxlY3RvcikuaXMoJzpyYWRpbycpKSB7XG4gICAgICAgIHRoaXMudG9SYWRpbyhzZWxlY3RvciwgdmFsdWUpXG4gICAgICB9IGVsc2UgaWYgKCQoc2VsZWN0b3IpLmlzKCdzZWxlY3QnKSkge1xuICAgICAgICB0aGlzLnRvU2VsZWN0KHNlbGVjdG9yLCB2YWx1ZSlcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHRoaXMudG9JbnB1dChzZWxlY3RvciwgdmFsdWUpXG4gICAgICB9XG4gICAgfSxcblxuICAgIHRvQ2hlY2tib3g6IGZ1bmN0aW9uIChlbGVtLCB2YWwpIHtcbiAgICAgICQoZWxlbSkuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgIGlmICgkKHRoaXMpLmF0dHIoJ3ZhbHVlJykgPT0gdmFsKSB7XG4gICAgICAgICAgJCh0aGlzKS5wcm9wKCdjaGVja2VkJywgdHJ1ZSlcbiAgICAgICAgICByZXR1cm4gZmFsc2VcbiAgICAgICAgfVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgdG9SYWRpbzogZnVuY3Rpb24gKGVsZW0sIHZhbCkge1xuICAgICAgJChlbGVtKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgaWYgKCQodGhpcykuYXR0cigndmFsdWUnKSA9PSB2YWwpIHtcbiAgICAgICAgICAkKHRoaXMpLnByb3AoJ2NoZWNrZWQnLCB0cnVlKVxuICAgICAgICAgIHJldHVybiBmYWxzZVxuICAgICAgICB9XG4gICAgICB9KVxuICAgIH0sXG5cbiAgICB0b1NlbGVjdDogZnVuY3Rpb24gKGVsZW0sIHZhbCkge1xuICAgICAgJChlbGVtKS5jaGlsZHJlbigpLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICBpZiAoJCh0aGlzKS5hdHRyKCd2YWx1ZScpID09IHZhbCkge1xuICAgICAgICAgICQodGhpcykucHJvcCgnc2VsZWN0ZWQnLCB0cnVlKVxuICAgICAgICAgIHJldHVybiBmYWxzZVxuICAgICAgICB9XG4gICAgICB9KVxuICAgIH0sXG5cbiAgICB0b0lucHV0OiBmdW5jdGlvbiAoZWxlbSwgdmFsKSB7XG4gICAgICBpZiAoISQoZWxlbSkuaXMoJ2lucHV0W3R5cGU9aGlkZGVuXScpKSB7XG4gICAgICAgICQoZWxlbSkudmFsKHZhbClcbiAgICAgIH1cbiAgICB9XG4gIH1cblxuICAvLyBqUXVlcnkg7ZSM65+s6re47J24XG4gICQuZm4uZHJhZnQgPSBmdW5jdGlvbiAoYXJncykge1xuICAgIC8qKlxuICAgICAqIOyYteyFmFxuICAgICAqIEB0eXBlIHtvYmplY3R9XG4gICAgICogQHByb3Agez9qUXVlcnl9IGNvbnRhaW5lciDsnoTsi5wg7KCA7J6lIOuqqeuhneydtCDtkZzsi5zrkKAg7JiB7JetXG4gICAgICogQHByb3Age2Jvb2xlYW59IHdpdGhGb3JtIGZvcm3snZgg7KCE7LK0IGZpZWxkcyDrjbDsnbTthLAg7KCA7J6lIOyXrOu2gFxuICAgICAqIEBwcm9wIHs/ZnVuY3Rpb259IGNhbGxiYWNrXG4gICAgICovXG4gICAgdmFyIGRlZmF1bHRBcmdzID0ge1xuICAgICAgY29udGFpbmVyOiBudWxsLFxuICAgICAgd2l0aEZvcm06IGZhbHNlLFxuICAgICAgY2FsbGJhY2s6IG51bGxcbiAgICB9XG5cbiAgICBhcmdzID0gJC5leHRlbmQoe30sIGRlZmF1bHRBcmdzLCBhcmdzKVxuXG4gICAgaWYgKCFhcmdzLmtleSB8fCAhYXJncy5idG5Mb2FkIHx8ICFhcmdzLmJ0blNhdmUpIHtcbiAgICAgIGNvbnNvbGUuZXJyb3IoJ211c3QgbmVlZCBrZXksIGJ0bkxvYWQgYW5kIGJ0blNhdmUnKVxuICAgICAgcmV0dXJuIGZhbHNlXG4gICAgfVxuXG4gICAgdmFyIGRyYWZ0ID0gbmV3IERyYWZ0KHRoaXMsIGFyZ3Mua2V5LCBhcmdzLmNhbGxiYWNrLCBhcmdzLndpdGhGb3JtLCBhcmdzLmNvbnRhaW5lciwgYXJncy5hcGlVcmwpXG5cbiAgICAkKGFyZ3MuYnRuTG9hZCkudW5iaW5kKCdjbGljay5kcmFmdCcpLmJpbmQoJ2NsaWNrLmRyYWZ0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuICAgICAgZHJhZnQudG9nZ2xlKHRydWUpXG4gICAgfSlcblxuICAgICQoYXJncy5idG5TYXZlKS51bmJpbmQoJ2NsaWNrLmRyYWZ0JykuYmluZCgnY2xpY2suZHJhZnQnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG4gICAgICBkcmFmdC5kcmFmdFNldCgpXG4gICAgfSlcblxuICAgIHJldHVybiBkcmFmdFxuICB9XG59KSh3aW5kb3cuWEUsIHdpbmRvdy5qUXVlcnkpXG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNjEpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg5MCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDg4KTsiLCJtb2R1bGUuZXhwb3J0cyA9IHJlcXVpcmUoXCJjb3JlLWpzLXB1cmUvc3RhYmxlL2pzb24vc3RyaW5naWZ5XCIpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNDQpOyIsInZhciBjb3JlID0gcmVxdWlyZSgnLi4vLi4vaW50ZXJuYWxzL3BhdGgnKTtcbnZhciAkSlNPTiA9IGNvcmUuSlNPTiB8fCAoY29yZS5KU09OID0geyBzdHJpbmdpZnk6IEpTT04uc3RyaW5naWZ5IH0pO1xuXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uIHN0cmluZ2lmeShpdCkgeyAvLyBlc2xpbnQtZGlzYWJsZS1saW5lIG5vLXVudXNlZC12YXJzXG4gIHJldHVybiAkSlNPTi5zdHJpbmdpZnkuYXBwbHkoJEpTT04sIGFyZ3VtZW50cyk7XG59O1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE1KTsiLCJtb2R1bGUuZXhwb3J0cyA9IHJlcXVpcmUoJy4uLy4uL2VzL2pzb24vc3RyaW5naWZ5Jyk7XG4iLCJtb2R1bGUuZXhwb3J0cyA9IF94ZV9kbGxfY29tbW9uOyJdLCJzb3VyY2VSb290IjoiIn0=