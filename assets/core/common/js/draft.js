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
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/promise */ "./node_modules/@babel/runtime-corejs3/core-js-stable/promise.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/concat */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/json/stringify */ "./node_modules/@babel/runtime-corejs3/core-js-stable/json/stringify.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_set_timeout__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/set-timeout */ "./node_modules/@babel/runtime-corejs3/core-js-stable/set-timeout.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_set_timeout__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_set_timeout__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/trim */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.string.iterator.js */ "./node_modules/core-js/modules/es.string.iterator.js");
/* harmony import */ var core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! core-js/modules/es.array.iterator.js */ "./node_modules/core-js/modules/es.array.iterator.js");
/* harmony import */ var core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! core-js/modules/web.dom-collections.iterator.js */ "./node_modules/core-js/modules/web.dom-collections.iterator.js");
/* harmony import */ var core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! core-js/modules/es.regexp.to-string.js */ "./node_modules/core-js/modules/es.regexp.to-string.js");
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! core-js/modules/es.array.join.js */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_15__);

















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

      _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0___default.a.all([XE.app('Lang'), XE.app('Request')]).then(function (app) {
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
            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context = _this.$component.show()).call(_context, '.panel-body').empty();

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
              data.forEach(function (item, i) {
                var _context2;

                temp += "<li>";
                temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_2___default()(_context2 = "<a href='#' class='draft_title' data-item='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3___default()(item), "' data-type=\"modal\">")).call(_context2, $($.parseHTML(item.val)).text(), "</a>");
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

              _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context3 = _this.$component).call(_context3, '.xe-modal-body').html(temp);

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
              data.forEach(function (item, i) {
                var _context4;

                temp += "<li>";
                temp += _babel_runtime_corejs3_core_js_stable_instance_concat__WEBPACK_IMPORTED_MODULE_2___default()(_context4 = "<a href='#' class='draft_title' data-item='".concat(_babel_runtime_corejs3_core_js_stable_json_stringify__WEBPACK_IMPORTED_MODULE_3___default()(item), "' data-type=\"collapse\">")).call(_context4, $($.parseHTML(item.val)).text(), "</a>");
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

              _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context5 = _this.$component).call(_context5, '.panel-body').html(temp);

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
      this.interval = _babel_runtime_corejs3_core_js_stable_set_timeout__WEBPACK_IMPORTED_MODULE_4___default()(function () {
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
      if (_babel_runtime_corejs3_core_js_stable_instance_trim__WEBPACK_IMPORTED_MODULE_5___default()($).call($, $(this.elem).val()) == '') {
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
      window.XE.ajax({
        url: this.apiUrl.draft.add,
        type: 'post',
        dataType: 'json',
        data: this.getReqSerialize() + '&key=' + this.key,
        success: function (json) {
          if (json.draftId === null) {
            this.unsetId();
          } else {
            this.setId(json.draftId);
          }
        }.bind(this)
      });
    },
    reqPut: function reqPut() {
      window.XE.ajax({
        url: this.apiUrl.draft.update + '/' + this.draftId,
        type: 'post',
        dataType: 'json',
        data: this.getReqSerialize(),
        success: function (json) {
          var _this = this;

          if (json.draftId === null) {
            var _context6;

            _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context6 = this.$component).call(_context6, 'li > a').each(function () {
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
        }.bind(this)
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
      return new _babel_runtime_corejs3_core_js_stable_promise__WEBPACK_IMPORTED_MODULE_0___default.a(function (resolve, reject) {
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
          data.forEach(function (obj, i) {
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
        $.each(values, function (i, val) {
          this.toCheckbox(selector, val);
        }.bind(this));
      } else {
        $.each(values, function (i, val) {
          this.toInput($(selector).eq(i)[0], val);
        }.bind(this));
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
    }
  }; // jQuery 플러그인

  $.fn.draft = function (args) {
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
    $(args.btnLoad).unbind('click.draft').bind('click.draft', function (e) {
      e.preventDefault();
      draft.toggle(true);
    });
    $(args.btnSave).unbind('click.draft').bind('click.draft', function (e) {
      e.preventDefault();
      draft.draftSet();
    });
    return draft;
  };
})(window.XE, window.jQuery);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js":
/*!***************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/concat.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(131);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(6);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/trim.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(129);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(2);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/set-timeout.js":
/*!***********************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/set-timeout.js from dll-reference _xe_dll_common ***!
  \***********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(61);

/***/ }),

/***/ "./node_modules/core-js-pure/es/json/stringify.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js-pure/es/json/stringify.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../../modules/es.json.stringify */ "./node_modules/core-js-pure/modules/es.json.stringify.js");
var core = __webpack_require__(/*! ../../internals/path */ "./node_modules/core-js-pure/internals/path.js");

// eslint-disable-next-line es/no-json -- safe
if (!core.JSON) core.JSON = { stringify: JSON.stringify };

// eslint-disable-next-line no-unused-vars -- required for `.length`
module.exports = function stringify(it, replacer, space) {
  return core.JSON.stringify.apply(null, arguments);
};


/***/ }),

/***/ "./node_modules/core-js-pure/internals/export.js":
/*!***************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/export.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(10);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/fails.js":
/*!**************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/fails.js from dll-reference _xe_dll_common ***!
  \**************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(23);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/get-built-in.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/get-built-in.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(49);

/***/ }),

/***/ "./node_modules/core-js-pure/internals/path.js":
/*!*************************************************************************************************!*\
  !*** delegated ./node_modules/core-js-pure/internals/path.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(17);

/***/ }),

/***/ "./node_modules/core-js-pure/modules/es.json.stringify.js":
/*!****************************************************************!*\
  !*** ./node_modules/core-js-pure/modules/es.json.stringify.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js-pure/internals/export.js");
var getBuiltIn = __webpack_require__(/*! ../internals/get-built-in */ "./node_modules/core-js-pure/internals/get-built-in.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js-pure/internals/fails.js");

var $stringify = getBuiltIn('JSON', 'stringify');
var re = /[\uD800-\uDFFF]/g;
var low = /^[\uD800-\uDBFF]$/;
var hi = /^[\uDC00-\uDFFF]$/;

var fix = function (match, offset, string) {
  var prev = string.charAt(offset - 1);
  var next = string.charAt(offset + 1);
  if ((low.test(match) && !hi.test(next)) || (hi.test(match) && !low.test(prev))) {
    return '\\u' + match.charCodeAt(0).toString(16);
  } return match;
};

var FORCED = fails(function () {
  return $stringify('\uDF06\uD834') !== '"\\udf06\\ud834"'
    || $stringify('\uDEAD') !== '"\\udead"';
});

if ($stringify) {
  // `JSON.stringify` method
  // https://tc39.es/ecma262/#sec-json.stringify
  // https://github.com/tc39/proposal-well-formed-stringify
  $({ target: 'JSON', stat: true, forced: FORCED }, {
    // eslint-disable-next-line no-unused-vars -- required for `.length`
    stringify: function stringify(it, replacer, space) {
      var result = $stringify.apply(null, arguments);
      return typeof result == 'string' ? result.replace(re, fix) : result;
    }
  });
}


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

/***/ "./node_modules/core-js/modules/es.array.iterator.js":
/*!*******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.array.iterator.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(93);

/***/ }),

/***/ "./node_modules/core-js/modules/es.array.join.js":
/*!***************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.array.join.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(127);

/***/ }),

/***/ "./node_modules/core-js/modules/es.object.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.object.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(158);

/***/ }),

/***/ "./node_modules/core-js/modules/es.promise.js":
/*!************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.promise.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(249);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.exec.js":
/*!****************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.exec.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(34);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(163);

/***/ }),

/***/ "./node_modules/core-js/modules/es.string.iterator.js":
/*!********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.string.iterator.js from dll-reference _xe_dll_common ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(252);

/***/ }),

/***/ "./node_modules/core-js/modules/es.string.replace.js":
/*!*******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.string.replace.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(74);

/***/ }),

/***/ "./node_modules/core-js/modules/web.dom-collections.for-each.js":
/*!******************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/web.dom-collections.for-each.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(56);

/***/ }),

/***/ "./node_modules/core-js/modules/web.dom-collections.iterator.js":
/*!******************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/web.dom-collections.iterator.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(253);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS9jb21tb24vanMvZHJhZnQuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2NvbmNhdC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS90cmltLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvcHJvbWlzZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL3NldC10aW1lb3V0LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2VzL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9leHBvcnQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9mYWlscy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvaW50ZXJuYWxzL2dldC1idWlsdC1pbi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvaW50ZXJuYWxzL3BhdGguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvbW9kdWxlcy9lcy5qc29uLnN0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL3N0YWJsZS9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5hcnJheS5pdGVyYXRvci5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuYXJyYXkuam9pbi5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMub2JqZWN0LnRvLXN0cmluZy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMucHJvbWlzZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMucmVnZXhwLmV4ZWMuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLnJlZ2V4cC50by1zdHJpbmcuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLnN0cmluZy5pdGVyYXRvci5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuc3RyaW5nLnJlcGxhY2UuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL3dlYi5kb20tY29sbGVjdGlvbnMuZm9yLWVhY2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL3dlYi5kb20tY29sbGVjdGlvbnMuaXRlcmF0b3IuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsiWEUiLCIkIiwiRHJhZnQiLCJlbGVtIiwia2V5IiwiY2FsbGJhY2siLCJ3aXRoRm9ybSIsImNvbnRhaW5lciIsImFwaVVybCIsImludGVydmFsIiwiZHJhZnRJZCIsImNvbXBvbmVudCIsIiRjb21wb25lbnQiLCJjb21wb25lbnROYW1lIiwidWlkIiwiYXR0ciIsImNvbnNvbGUiLCJlcnJvciIsImluaXQiLCJiaW5kRXZlbnRzIiwicHJvdG90eXBlIiwiX2dldFVpZCIsImFwcGVuZENvbXBvbmVudCIsImFsbCIsImFwcCIsInRoZW4iLCJyZXF1ZXN0VHJhbnNBbGwiLCJNYXRoIiwicmFuZG9tIiwidG9TdHJpbmciLCJzdWJzdHJpbmciLCJfdGhpcyIsIm9uIiwic2F2ZUV2ZW50SGFuZGxlciIsImUiLCJwcmV2ZW50RGVmYXVsdCIsIiR0aGlzIiwidHlwZSIsImRhdGEiLCJpdGVtIiwib25BcHBseSIsInhlTW9kYWwiLCJzaG93IiwiZW1wdHkiLCJpZCIsInJlcURlbGV0ZSIsImNsb3Nlc3QiLCJyZW1vdmUiLCJhcHBGb3JtIiwiZ2V0IiwiJCRvbiIsImRlbGV0ZUF1dG8iLCJuYW1lIiwidG9nZ2xlIiwiaGFzQ2xhc3MiLCJsb2FkIiwidGVtcCIsImZvckVhY2giLCJpIiwicGFyc2VIVE1MIiwidmFsIiwidGV4dCIsImlzX2F1dG8iLCJ3aW5kb3ciLCJMYW5nIiwidHJhbnMiLCJjcmVhdGVkX2F0Iiwic3Vic3RyIiwicmVwbGFjZSIsImh0bWwiLCJoaWRlIiwiZ2V0TW9kYWxUZW1wbGF0ZSIsImpvaW4iLCJnZXRDb2xsYXBzZVRlbXBsYXRlIiwiJGNvbnRhaW5lciIsImxlbmd0aCIsImFmdGVyIiwiY29sbGFwc2VDbGFzcyIsIl9jb2xsYXBzZUNsYXNzIiwiYWRkQ2xhc3MiLCJzZXRJZCIsInZhbHVlcyIsImV0YyIsImRhdGFTZXR0ZXIiLCJpbnRlcnZhbENsZWFyIiwic2V0QXV0byIsImNsZWFyVGltZW91dCIsImRyYWZ0U2V0IiwicmVxUG9zdCIsInJlcVB1dCIsInRvYXN0IiwiYWpheCIsInVybCIsImRyYWZ0IiwiYWRkIiwiZGF0YVR5cGUiLCJnZXRSZXFTZXJpYWxpemUiLCJzdWNjZXNzIiwianNvbiIsInVuc2V0SWQiLCJiaW5kIiwidXBkYXRlIiwiZWFjaCIsInZhbHVlIiwiY29udGVudCIsImF1dG8iLCJzZXQiLCJyZXNvbHZlIiwicmVqZWN0IiwidW5zZXQiLCJwYXJhbSIsImxpc3QiLCJvYmoiLCJzZXJpYWxpemUiLCJkZWxldGUiLCJmb3JtIiwiQXJyYXkiLCJtdWx0aXBsZSIsInNpbmdsZSIsInNlbGVjdG9yIiwiaXMiLCJ0b0NoZWNrYm94IiwidG9JbnB1dCIsImVxIiwidG9SYWRpbyIsInRvU2VsZWN0IiwicHJvcCIsImNoaWxkcmVuIiwiZm4iLCJhcmdzIiwiZGVmYXVsdEFyZ3MiLCJleHRlbmQiLCJidG5Mb2FkIiwiYnRuU2F2ZSIsInVuYmluZCIsImpRdWVyeSJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7UUFDdkQsaUNBQWlDLGVBQWU7UUFDaEQ7UUFDQTtRQUNBOztRQUVBO1FBQ0Esc0RBQXNELCtEQUErRDs7UUFFckg7UUFDQTs7O1FBR0E7UUFDQTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDbEZBO0FBQ0EsQ0FBQyxVQUFVQSxFQUFWLEVBQWNDLENBQWQsRUFBaUI7QUFDaEI7QUFDQTtBQUNGO0FBQ0E7O0FBQ0UsV0FBU0MsS0FB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QSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9jb21tb24vanMvZHJhZnQuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIlwiO1xuXG5cbiBcdC8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuIFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oX193ZWJwYWNrX3JlcXVpcmVfXy5zID0gXCIuL2NvcmUvY29tbW9uL2pzL2RyYWZ0LmpzXCIpO1xuIiwiLy8gQFRPRE8g7J6s7J6R7ISxLiDsgqzsmqnrkJjsp4Ag7JWK7J2MXG4oZnVuY3Rpb24gKFhFLCAkKSB7XG4gICd1c2Ugc3RyaWN0J1xuICAvKipcbiAgKiBAY2xhc3NcbiAgKi9cbiAgZnVuY3Rpb24gRHJhZnQgKGVsZW0sIGtleSwgY2FsbGJhY2ssIHdpdGhGb3JtLCBjb250YWluZXIsIGFwaVVybCkge1xuICAgIHRoaXMua2V5ID0ga2V5XG4gICAgdGhpcy5lbGVtID0gZWxlbVxuICAgIHRoaXMuY2FsbGJhY2sgPSBjYWxsYmFja1xuICAgIHRoaXMud2l0aEZvcm0gPSB3aXRoRm9ybVxuICAgIHRoaXMuY29udGFpbmVyID0gY29udGFpbmVyXG4gICAgdGhpcy5hcGlVcmwgPSBhcGlVcmxcblxuICAgIHRoaXMuaW50ZXJ2YWwgPSBudWxsXG5cbiAgICB0aGlzLmRyYWZ0SWQgPSBudWxsXG4gICAgdGhpcy5jb21wb25lbnQgPSBudWxsXG4gICAgdGhpcy4kY29tcG9uZW50ID0gJCgpXG4gICAgdGhpcy5jb21wb25lbnROYW1lID0gJydcbiAgICB0aGlzLnVpZCA9IG51bGxcblxuICAgIGlmICghJCh0aGlzLmVsZW0pLmF0dHIoJ25hbWUnKSB8fCAkKHRoaXMuZWxlbSkuYXR0cignbmFtZScpID09ICcnKSB7XG4gICAgICBjb25zb2xlLmVycm9yKFwiTXVzdCBzZXQgJ25hbWUnIGF0dHJpYnV0ZSBcIilcbiAgICAgIHJldHVyblxuICAgIH1cblxuICAgIHRoaXMuaW5pdCgpXG4gICAgdGhpcy5iaW5kRXZlbnRzKClcblxuICAgIHJldHVybiB0aGlzXG4gIH1cblxuICAvKipcbiAgKiBAbGVuZHMgRHJhZnRcbiAgKi9cbiAgRHJhZnQucHJvdG90eXBlID0ge1xuICAgIC8qKlxuICAgICog7LSI6riw7ZmU7ZWc64ukLlxuICAgICogQGZ1bmN0aW9uXG4gICAgKi9cbiAgICBpbml0OiBmdW5jdGlvbiAoKSB7XG4gICAgICB0aGlzLnVpZCA9IHRoaXMuX2dldFVpZCgpXG4gICAgICB0aGlzLmFwcGVuZENvbXBvbmVudCgpXG5cbiAgICAgIFByb21pc2UuYWxsKFtYRS5hcHAoJ0xhbmcnKSwgWEUuYXBwKCdSZXF1ZXN0JyldKS50aGVuKGZ1bmN0aW9uIChhcHApIHtcbiAgICAgICAgYXBwWzBdLnJlcXVlc3RUcmFuc0FsbChbJ3hlOjpkcmFmdFNhdmUnLCAneGU6OmRyYWZ0U2F2ZWQnLCAneGU6OmF1dG9TYXZlJywgJ3hlOjpkcmFmdExvYWQnXSlcbiAgICAgIH0pXG4gICAgfSxcblxuICAgIF9nZXRVaWQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHJldHVybiBNYXRoLnJhbmRvbSgpLnRvU3RyaW5nKDM2KS5zdWJzdHJpbmcoMiwgMTUpICtcbiAgICAgIE1hdGgucmFuZG9tKCkudG9TdHJpbmcoMzYpLnN1YnN0cmluZygyLCAxNSlcbiAgICB9LFxuXG4gICAgYmluZEV2ZW50czogZnVuY3Rpb24gKCkge1xuICAgICAgdmFyIF90aGlzID0gdGhpc1xuXG4gICAgICAkKHRoaXMuZWxlbSkub24oJ2lucHV0LmRyYWZ0JywgZnVuY3Rpb24gKCkge1xuICAgICAgICBfdGhpcy5zYXZlRXZlbnRIYW5kbGVyKClcbiAgICAgIH0pXG5cbiAgICAgIF90aGlzLiRjb21wb25lbnQub24oJ2NsaWNrJywgJy5kcmFmdF90aXRsZScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKVxuICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICAgIHZhciB0eXBlID0gJHRoaXMuZGF0YSgndHlwZScpXG4gICAgICAgIHZhciBpdGVtID0gJCh0aGlzKS5kYXRhKCdpdGVtJylcblxuICAgICAgICBfdGhpcy5vbkFwcGx5KGl0ZW0pXG5cbiAgICAgICAgc3dpdGNoICh0eXBlKSB7XG4gICAgICAgICAgY2FzZSAnbW9kYWwnOlxuICAgICAgICAgICAgX3RoaXMuJGNvbXBvbmVudC54ZU1vZGFsKCdoaWRlJylcbiAgICAgICAgICAgIGJyZWFrXG4gICAgICAgICAgY2FzZSAnY29sbGFwc2UnOlxuICAgICAgICAgICAgX3RoaXMuJGNvbXBvbmVudC5zaG93KCkuZmluZCgnLnBhbmVsLWJvZHknKS5lbXB0eSgpXG4gICAgICAgICAgICBicmVha1xuICAgICAgICB9XG4gICAgICB9KVxuXG4gICAgICBfdGhpcy4kY29tcG9uZW50Lm9uKCdjbGljaycsICcueGUtZHJhZnRCdG5DbG9zZU1vZGFsJywgZnVuY3Rpb24gKCkge1xuICAgICAgICBfdGhpcy4kY29tcG9uZW50LnhlTW9kYWwoJ2hpZGUnKVxuICAgICAgfSlcblxuICAgICAgX3RoaXMuJGNvbXBvbmVudC5vbignY2xpY2snLCAnLmJ0bl9kcmFmdF9kZWxldGUnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KClcblxuICAgICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpXG4gICAgICAgIHZhciBpZCA9ICR0aGlzLmRhdGEoJ2lkJylcblxuICAgICAgICBfdGhpcy5yZXFEZWxldGUoaWQsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAkdGhpcy5jbG9zZXN0KCdsaScpLnJlbW92ZSgpXG4gICAgICAgIH0pXG4gICAgICB9KVxuXG4gICAgICBYRS5hcHAoJ0Zvcm0nKS50aGVuKGFwcEZvcm0gPT4ge1xuICAgICAgICBhcHBGb3JtLmdldChfdGhpcy5lbGVtKS4kJG9uKCdzdWJtaXQnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgcmV0dXJuIF90aGlzLmRlbGV0ZUF1dG8oX3RoaXMua2V5KSAvLyBQcm9taXNlXG4gICAgICAgIH0sIHsgbmFtZTogJ3hlLmRyYWZ0JyB9KVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgdG9nZ2xlOiBmdW5jdGlvbiAoc2hvdykge1xuICAgICAgdmFyIF90aGlzID0gdGhpc1xuXG4gICAgICBzd2l0Y2ggKHRoaXMuY29tcG9uZW50TmFtZSkge1xuICAgICAgICBjYXNlICdtb2RhbCc6XG4gICAgICAgICAgaWYgKCFzaG93ICYmIF90aGlzLiRjb21wb25lbnQuaGFzQ2xhc3MoJ2luJykpIHtcbiAgICAgICAgICAgIF90aGlzLiRjb21wb25lbnQueGVNb2RhbCgnaGlkZScpXG4gICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIF90aGlzLmxvYWQoeyBrZXk6IF90aGlzLmtleSB9LCBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICAgICAgICB2YXIgdGVtcCA9IGA8ZGl2IGNsYXNzPVwiZHJhZnRfc2F2ZV9saXN0XCI+YFxuICAgICAgICAgICAgICB0ZW1wICs9IGA8dWw+YFxuXG4gICAgICAgICAgICAgIGRhdGEuZm9yRWFjaChmdW5jdGlvbiAoaXRlbSwgaSkge1xuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxsaT5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPGEgaHJlZj0nIycgY2xhc3M9J2RyYWZ0X3RpdGxlJyBkYXRhLWl0ZW09JyR7SlNPTi5zdHJpbmdpZnkoaXRlbSl9JyBkYXRhLXR5cGU9XCJtb2RhbFwiPiR7JCgkLnBhcnNlSFRNTChpdGVtLnZhbCkpLnRleHQoKX08L2E+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJkcmFmdF9pbmZvXCI+YFxuXG4gICAgICAgICAgICAgICAgaWYgKGl0ZW0uaXNfYXV0byA9PSAxKSB7XG4gICAgICAgICAgICAgICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cImRyYWZ0X3N0YXRlXCI+JHt3aW5kb3cuWEUuTGFuZy50cmFucygneGU6OmF1dG9TYXZlJyl9PC9zcGFuPmBcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJkcmFmdF9zdGF0ZSB2MlwiPiR7d2luZG93LlhFLkxhbmcudHJhbnMoJ3hlOjpkcmFmdFNhdmUnKX08L3NwYW4+YFxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiZHJhZnRfZGF0ZVwiPiR7aXRlbS5jcmVhdGVkX2F0LnN1YnN0cigwLCAxNikucmVwbGFjZSgvLS9nLCAnICcpfTwvc3Bhbj5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0bl9kcmFmdF9kZWxldGVcIiBkYXRhLWlkPVwiJHtpdGVtLmlkfVwiPjxpIGNsYXNzPVwieGktY2xvc2VcIj48L2k+PC9hPmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8L2Rpdj5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPC9saT5gXG4gICAgICAgICAgICAgIH0pXG5cbiAgICAgICAgICAgICAgdGVtcCArPSBgPC91bD5gXG4gICAgICAgICAgICAgIHRlbXAgKz0gYDwvZGl2PmBcblxuICAgICAgICAgICAgICBfdGhpcy4kY29tcG9uZW50LmZpbmQoJy54ZS1tb2RhbC1ib2R5JykuaHRtbCh0ZW1wKVxuICAgICAgICAgICAgICBfdGhpcy4kY29tcG9uZW50LnhlTW9kYWwoJ3Nob3cnKVxuICAgICAgICAgICAgfSlcbiAgICAgICAgICB9XG5cbiAgICAgICAgICBicmVha1xuICAgICAgICBjYXNlICdjb2xsYXBzZSc6XG5cbiAgICAgICAgICBpZiAoIXNob3cgJiYgX3RoaXMuJGNvbXBvbmVudC5oYXNDbGFzcygnaW4nKSkge1xuICAgICAgICAgICAgX3RoaXMuJGNvbXBvbmVudC5oaWRlKClcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgX3RoaXMubG9hZCh7IGtleTogX3RoaXMua2V5IH0sIGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgICAgICAgIHZhciB0ZW1wID0gYDxkaXYgY2xhc3M9XCJkcmFmdF9zYXZlX2xpc3RcIj5gXG4gICAgICAgICAgICAgIHRlbXAgKz0gYDx1bD5gXG5cbiAgICAgICAgICAgICAgZGF0YS5mb3JFYWNoKGZ1bmN0aW9uIChpdGVtLCBpKSB7XG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPGxpPmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8YSBocmVmPScjJyBjbGFzcz0nZHJhZnRfdGl0bGUnIGRhdGEtaXRlbT0nJHtKU09OLnN0cmluZ2lmeShpdGVtKX0nIGRhdGEtdHlwZT1cImNvbGxhcHNlXCI+JHskKCQucGFyc2VIVE1MKGl0ZW0udmFsKSkudGV4dCgpfTwvYT5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPGRpdiBjbGFzcz1cImRyYWZ0X2luZm9cIj5gXG5cbiAgICAgICAgICAgICAgICBpZiAoaXRlbS5pc19hdXRvID09IDEpIHtcbiAgICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiZHJhZnRfc3RhdGVcIj4ke3dpbmRvdy5YRS5MYW5nLnRyYW5zKCd4ZTo6YXV0b1NhdmUnKX08L3NwYW4+YFxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cImRyYWZ0X3N0YXRlIHYyXCI+JHt3aW5kb3cuWEUuTGFuZy50cmFucygneGU6OmRyYWZ0U2F2ZScpfTwvc3Bhbj5gXG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJkcmFmdF9kYXRlXCI+JHtpdGVtLmNyZWF0ZWRfYXQuc3Vic3RyKDAsIDE2KS5yZXBsYWNlKC8tL2csICcgJyl9PC9zcGFuPmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8YSBocmVmPVwiI1wiIGNsYXNzPVwiYnRuX2RyYWZ0X2RlbGV0ZVwiIGRhdGEtaWQ9XCIke2l0ZW0uaWR9XCI+PGkgY2xhc3M9XCJ4aS1jbG9zZVwiPjwvaT48L2E+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDwvZGl2PmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8L2xpPmBcbiAgICAgICAgICAgICAgfSlcblxuICAgICAgICAgICAgICB0ZW1wICs9IGA8L3VsPmBcbiAgICAgICAgICAgICAgdGVtcCArPSBgPC9kaXY+YFxuXG4gICAgICAgICAgICAgIF90aGlzLiRjb21wb25lbnQuZmluZCgnLnBhbmVsLWJvZHknKS5odG1sKHRlbXApXG4gICAgICAgICAgICAgIF90aGlzLiRjb21wb25lbnQuc2hvdygpXG4gICAgICAgICAgICB9KVxuICAgICAgICAgIH1cblxuICAgICAgICAgIGJyZWFrXG4gICAgICB9XG4gICAgfSxcblxuICAgIGdldE1vZGFsVGVtcGxhdGU6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHJldHVybiBbXG4gICAgICAgICc8ZGl2IGNsYXNzPVwieGUtbW9kYWwgZmFkZVwiIGlkPVwieGUtZHJhZnRNb2RhbFwiPicsXG4gICAgICAgICc8ZGl2IGNsYXNzPVwieGUtbW9kYWwtZGlhbG9nXCI+JyxcbiAgICAgICAgJzxkaXYgY2xhc3M9XCJ4ZS1tb2RhbC1jb250ZW50XCI+JyxcbiAgICAgICAgJzxkaXYgY2xhc3M9XCJ4ZS1tb2RhbC1oZWFkZXJcIj4nLFxuICAgICAgICAnPGJ1dHRvbiB0eXBlPVwiYnV0dG9uXCIgY2xhc3M9XCJidG4tY2xvc2UgeGUtZHJhZnRCdG5DbG9zZVwiIGRhdGEtZGlzbWlzcz1cInhlLW1vZGFsXCIgYXJpYS1sYWJlbD1cIkNsb3NlXCI+PGkgY2xhc3M9XCJ4aS1jbG9zZVwiPjwvaT48L2J1dHRvbj4nLFxuICAgICAgICAnPHN0cm9uZyBjbGFzcz1cInhlLW1vZGFsLXRpdGxlXCI+PC9zdHJvbmc+JyxcbiAgICAgICAgJzwvZGl2PicsXG4gICAgICAgICc8ZGl2IGNsYXNzPVwieGUtbW9kYWwtYm9keVwiPjwvZGl2PicsXG4gICAgICAgICc8ZGl2IGNsYXNzPVwieGUtbW9kYWwtZm9vdGVyXCI+JyxcbiAgICAgICAgJzxidXR0b24gdHlwZT1cImJ1dHRvblwiIGNsYXNzPVwieGUtYnRuIHhlLWJ0bi1kZWZhdWx0XCIgZGF0YS1kaXNtaXNzPVwieGUtbW9kYWxcIj5DbG9zZTwvYnV0dG9uPicsXG4gICAgICAgICc8L2Rpdj4nLFxuICAgICAgICAnPC9kaXY+JyxcbiAgICAgICAgJzwvZGl2PicsXG4gICAgICAgICc8L2Rpdj4nXG4gICAgICBdLmpvaW4oJ1xcbicpXG4gICAgfSxcblxuICAgIGdldENvbGxhcHNlVGVtcGxhdGU6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHJldHVybiBbXG4gICAgICAgICc8ZGl2IGNsYXNzPVwicGFuZWwgcGFuZWwtZGVmYXVsdFwiPicsXG4gICAgICAgICc8ZGl2IGNsYXNzPVwicGFuZWwtYm9keVwiPjwvZGl2PicsXG4gICAgICAgICc8L2Rpdj4nXG4gICAgICBdLmpvaW4oJ1xcbicpXG4gICAgfSxcblxuICAgIGFwcGVuZENvbXBvbmVudDogZnVuY3Rpb24gKCkge1xuICAgICAgdmFyIF90aGlzID0gdGhpc1xuICAgICAgdmFyICRjb250YWluZXIgPSAkKCc8ZGl2PicpXG5cbiAgICAgIGlmICgkKHRoaXMuY29udGFpbmVyKS5sZW5ndGggPCAxKSB7XG4gICAgICAgICQodGhpcy5lbGVtKS5jbG9zZXN0KCdmb3JtJykuYWZ0ZXIoJGNvbnRhaW5lci5odG1sKHRoaXMuZ2V0TW9kYWxUZW1wbGF0ZSgpKSlcbiAgICAgICAgdGhpcy5jb21wb25lbnROYW1lID0gJ21vZGFsJ1xuICAgICAgICB0aGlzLiRjb21wb25lbnQgPSAkKCcjeGUtZHJhZnRNb2RhbCcpXG4gICAgICB9IGVsc2Uge1xuICAgICAgICB0aGlzLmNvbXBvbmVudE5hbWUgPSAnY29sbGFwc2UnXG4gICAgICAgIHRoaXMuJGNvbXBvbmVudCA9ICQodGhpcy5jb250YWluZXIpXG5cbiAgICAgICAgdmFyIGNvbGxhcHNlQ2xhc3MgPSB0aGlzLl9jb2xsYXBzZUNsYXNzKClcblxuICAgICAgICB0aGlzLiRjb21wb25lbnQuYWRkQ2xhc3MoW2NvbGxhcHNlQ2xhc3MsICdjb2xsYXBzZSddLmpvaW4oJyAnKSkuaHRtbCgkY29udGFpbmVyLmh0bWwoX3RoaXMuZ2V0Q29sbGFwc2VUZW1wbGF0ZSgpKSlcbiAgICAgIH1cbiAgICB9LFxuXG4gICAgb25BcHBseTogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICAgIHRoaXMuc2V0SWQoZGF0YS5pZClcblxuICAgICAgdmFyIHZhbHVlcyA9IGRhdGEuZXRjXG4gICAgICB2YWx1ZXNbJChfdGhpcy5lbGVtKS5hdHRyKCduYW1lJyldID0gZGF0YS52YWxcblxuICAgICAgZGF0YVNldHRlci5pbml0KCQoX3RoaXMuZWxlbSkuY2xvc2VzdCgnZm9ybScpWzBdLCB2YWx1ZXMpXG4gICAgICB0aGlzLmNhbGxiYWNrKHZhbHVlcylcbiAgICB9LFxuXG4gICAgX2NvbGxhcHNlQ2xhc3M6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHJldHVybiAnX194ZV9kcmFmdF9jb2xsYXBzZV8nICsgdGhpcy51aWRcbiAgICB9LFxuXG4gICAgc2F2ZUV2ZW50SGFuZGxlcjogZnVuY3Rpb24gKCkge1xuICAgICAgdmFyIF90aGlzID0gdGhpc1xuICAgICAgdGhpcy5pbnRlcnZhbENsZWFyKClcblxuICAgICAgdGhpcy5pbnRlcnZhbCA9IHNldFRpbWVvdXQoZnVuY3Rpb24gKCkge1xuICAgICAgICBfdGhpcy5zZXRBdXRvKClcbiAgICAgICAgX3RoaXMuaW50ZXJ2YWxDbGVhcigpXG4gICAgICB9LCAzMDAwKVxuICAgIH0sXG5cbiAgICBpbnRlcnZhbENsZWFyOiBmdW5jdGlvbiAoKSB7XG4gICAgICBpZiAodGhpcy5pbnRlcnZhbCkge1xuICAgICAgICBjbGVhclRpbWVvdXQodGhpcy5pbnRlcnZhbClcbiAgICAgIH1cbiAgICB9LFxuXG4gICAgZHJhZnRTZXQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgIGlmICgkLnRyaW0oJCh0aGlzLmVsZW0pLnZhbCgpKSA9PSAnJykge1xuICAgICAgICByZXR1cm5cbiAgICAgIH1cblxuICAgICAgaWYgKHRoaXMuZHJhZnRJZCA9PSBudWxsKSB7XG4gICAgICAgIHRoaXMucmVxUG9zdCgpXG4gICAgICB9IGVsc2Uge1xuICAgICAgICB0aGlzLnJlcVB1dCgpXG4gICAgICB9XG5cbiAgICAgIHdpbmRvdy5YRS50b2FzdCgnc3VjY2VzcycsIHdpbmRvdy5YRS5MYW5nLnRyYW5zKCd4ZTo6ZHJhZnRTYXZlZCcpKVxuICAgIH0sXG5cbiAgICByZXFQb3N0OiBmdW5jdGlvbiAoKSB7XG4gICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgIHVybDogdGhpcy5hcGlVcmwuZHJhZnQuYWRkLFxuICAgICAgICB0eXBlOiAncG9zdCcsXG4gICAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICAgIGRhdGE6IHRoaXMuZ2V0UmVxU2VyaWFsaXplKCkgKyAnJmtleT0nICsgdGhpcy5rZXksXG4gICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChqc29uKSB7XG4gICAgICAgICAgaWYgKGpzb24uZHJhZnRJZCA9PT0gbnVsbCkge1xuICAgICAgICAgICAgdGhpcy51bnNldElkKClcbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgdGhpcy5zZXRJZChqc29uLmRyYWZ0SWQpXG4gICAgICAgICAgfVxuICAgICAgICB9LmJpbmQodGhpcylcbiAgICAgIH0pXG4gICAgfSxcblxuICAgIHJlcVB1dDogZnVuY3Rpb24gKCkge1xuICAgICAgd2luZG93LlhFLmFqYXgoe1xuICAgICAgICB1cmw6IHRoaXMuYXBpVXJsLmRyYWZ0LnVwZGF0ZSArICcvJyArIHRoaXMuZHJhZnRJZCxcbiAgICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgICBkYXRhOiB0aGlzLmdldFJlcVNlcmlhbGl6ZSgpLFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoanNvbikge1xuICAgICAgICAgIHZhciBfdGhpcyA9IHRoaXNcblxuICAgICAgICAgIGlmIChqc29uLmRyYWZ0SWQgPT09IG51bGwpIHtcbiAgICAgICAgICAgIHRoaXMuJGNvbXBvbmVudC5maW5kKCdsaSA+IGEnKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgICAgICAgICB2YXIgaXRlbSA9ICR0aGlzLmRhdGEoJ2l0ZW0nKVxuXG4gICAgICAgICAgICAgIGlmIChpdGVtLmlkID09PSBfdGhpcy5kcmFmdElkKSB7XG4gICAgICAgICAgICAgICAgdmFyIHZhbHVlID0gJChfdGhpcy5lbGVtKS52YWwoKVxuXG4gICAgICAgICAgICAgICAgaXRlbS52YWwgPSB2YWx1ZVxuICAgICAgICAgICAgICAgIGl0ZW0uZXRjLmNvbnRlbnQgPSB2YWx1ZVxuXG4gICAgICAgICAgICAgICAgJHRoaXMuZGF0YSgnaXRlbScsIGl0ZW0pLnRleHQoJCgkLnBhcnNlSFRNTCh2YWx1ZSkpLnRleHQoKSlcbiAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSlcblxuICAgICAgICAgICAgdGhpcy51bnNldElkKClcbiAgICAgICAgICB9XG4gICAgICAgIH0uYmluZCh0aGlzKVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgc2V0QXV0bzogZnVuY3Rpb24gKCkge1xuICAgICAgd2luZG93LlhFLmFqYXgoe1xuICAgICAgICB1cmw6IHRoaXMuYXBpVXJsLmF1dG8uc2V0LFxuICAgICAgICB0eXBlOiAncG9zdCcsXG4gICAgICAgIGRhdGE6IHRoaXMuZ2V0UmVxU2VyaWFsaXplKCkgKyAnJmtleT0nICsgdGhpcy5rZXlcbiAgICAgIH0pXG4gICAgfSxcblxuICAgIGRlbGV0ZUF1dG86IGZ1bmN0aW9uIChrZXkpIHtcbiAgICAgIGtleSA9IGtleSB8fCB0aGlzLmtleVxuXG4gICAgICByZXR1cm4gbmV3IFByb21pc2UoKHJlc29sdmUsIHJlamVjdCkgPT4ge1xuICAgICAgICBpZiAoa2V5KSB7XG4gICAgICAgICAgd2luZG93LlhFLmFqYXgoe1xuICAgICAgICAgICAgdXJsOiB0aGlzLmFwaVVybC5hdXRvLnVuc2V0LFxuICAgICAgICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgICAgICAgZGF0YTogJ2tleT0nICsga2V5LFxuICAgICAgICAgICAgc3VjY2VzczogKCkgPT4ge1xuICAgICAgICAgICAgICByZXNvbHZlKClcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBlcnJvcjogKGUpID0+IHtcbiAgICAgICAgICAgICAgcmVqZWN0KGUpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfSlcbiAgICAgICAgfVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgbG9hZDogZnVuY3Rpb24gKHBhcmFtLCBjYWxsYmFjaykge1xuICAgICAgdmFyIF90aGlzID0gdGhpc1xuXG4gICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgIHVybDogX3RoaXMuYXBpVXJsLmRyYWZ0Lmxpc3QsXG4gICAgICAgIHR5cGU6ICdnZXQnLFxuICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgICBkYXRhOiBwYXJhbSxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgICBkYXRhLmZvckVhY2goZnVuY3Rpb24gKG9iaiwgaSkge1xuICAgICAgICAgICAgaWYgKG9iai5pc19hdXRvID09PSAxKSB7XG4gICAgICAgICAgICAgIF90aGlzLmtleSA9IG9iai5pZFxuICAgICAgICAgICAgfVxuICAgICAgICAgIH0pXG5cbiAgICAgICAgICBpZiAoY2FsbGJhY2spIHtcbiAgICAgICAgICAgIGNhbGxiYWNrKGRhdGEpXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9KVxuICAgIH0sXG5cbiAgICBnZXRSZXFTZXJpYWxpemU6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciBkYXRhXG4gICAgICBpZiAodGhpcy53aXRoRm9ybSA9PT0gdHJ1ZSkge1xuICAgICAgICBkYXRhID0gJCh0aGlzLmVsZW0pLmNsb3Nlc3QoJ2Zvcm0nKS5zZXJpYWxpemUoKVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgZGF0YSA9IFskKHRoaXMuZWxlbSkuYXR0cignbmFtZScpLCAkKHRoaXMuZWxlbSkudmFsKCldLmpvaW4oJz0nKVxuICAgICAgfVxuXG4gICAgICByZXR1cm4gZGF0YSArICcmcmVwPScgKyAkKHRoaXMuZWxlbSkuYXR0cignbmFtZScpXG4gICAgfSxcblxuICAgIHJlcURlbGV0ZTogZnVuY3Rpb24gKGlkLCBjYWxsYmFjaykge1xuICAgICAgdmFyIF90aGlzID0gdGhpc1xuICAgICAgaWQgPSBpZCB8fCB0aGlzLmRyYWZ0SWRcblxuICAgICAgaWYgKCFpZCkge1xuICAgICAgICByZXR1cm5cbiAgICAgIH1cblxuICAgICAgaWYgKGlkID09IHRoaXMuZHJhZnRJZCkge1xuICAgICAgICB0aGlzLmRyYWZ0SWQgPSBudWxsXG4gICAgICB9XG5cbiAgICAgIHdpbmRvdy5YRS5hamF4KHtcbiAgICAgICAgdXJsOiBfdGhpcy5hcGlVcmwuZHJhZnQuZGVsZXRlICsgJy8nICsgaWQsXG4gICAgICAgIHR5cGU6ICdwb3N0JyxcbiAgICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKCkge1xuICAgICAgICAgIGlmIChjYWxsYmFjaykge1xuICAgICAgICAgICAgY2FsbGJhY2soKVxuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgc2V0SWQ6IGZ1bmN0aW9uIChpZCkge1xuICAgICAgdGhpcy5kcmFmdElkID0gaWRcbiAgICB9LFxuXG4gICAgdW5zZXRJZDogZnVuY3Rpb24gKCkge1xuICAgICAgdGhpcy5kcmFmdElkID0gbnVsbFxuICAgIH1cbiAgfVxuXG4gIHZhciBkYXRhU2V0dGVyID0ge1xuICAgIGluaXQ6IGZ1bmN0aW9uIChmb3JtLCBkYXRhKSB7XG4gICAgICBmb3IgKHZhciBpIGluIGRhdGEpIHtcbiAgICAgICAgdmFyIG5hbWUgPSBpXG4gICAgICAgIGlmIChkYXRhW2ldIGluc3RhbmNlb2YgQXJyYXkpIHtcbiAgICAgICAgICBuYW1lID0gbmFtZSArICdbXSdcbiAgICAgICAgICB0aGlzLm11bHRpcGxlKGZvcm1bbmFtZV0sIGRhdGFbaV0pXG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgdGhpcy5zaW5nbGUoZm9ybVtuYW1lXSwgZGF0YVtpXSlcbiAgICAgICAgfVxuICAgICAgfVxuICAgIH0sXG5cbiAgICBtdWx0aXBsZTogZnVuY3Rpb24gKHNlbGVjdG9yLCB2YWx1ZXMpIHtcbiAgICAgIGlmICgkKHNlbGVjdG9yKS5pcygnOmNoZWNrYm94JykpIHtcbiAgICAgICAgJC5lYWNoKHZhbHVlcywgZnVuY3Rpb24gKGksIHZhbCkge1xuICAgICAgICAgIHRoaXMudG9DaGVja2JveChzZWxlY3RvciwgdmFsKVxuICAgICAgICB9LmJpbmQodGhpcykpXG4gICAgICB9IGVsc2Uge1xuICAgICAgICAkLmVhY2godmFsdWVzLCBmdW5jdGlvbiAoaSwgdmFsKSB7XG4gICAgICAgICAgdGhpcy50b0lucHV0KCQoc2VsZWN0b3IpLmVxKGkpWzBdLCB2YWwpXG4gICAgICAgIH0uYmluZCh0aGlzKSlcbiAgICAgIH1cbiAgICB9LFxuXG4gICAgc2luZ2xlOiBmdW5jdGlvbiAoc2VsZWN0b3IsIHZhbHVlKSB7XG4gICAgICBpZiAoJChzZWxlY3RvcikuaXMoJzpjaGVja2JveCcpKSB7XG4gICAgICAgIHRoaXMudG9DaGVja2JveChzZWxlY3RvciwgdmFsdWUpXG4gICAgICB9IGVsc2UgaWYgKCQoc2VsZWN0b3IpLmlzKCc6cmFkaW8nKSkge1xuICAgICAgICB0aGlzLnRvUmFkaW8oc2VsZWN0b3IsIHZhbHVlKVxuICAgICAgfSBlbHNlIGlmICgkKHNlbGVjdG9yKS5pcygnc2VsZWN0JykpIHtcbiAgICAgICAgdGhpcy50b1NlbGVjdChzZWxlY3RvciwgdmFsdWUpXG4gICAgICB9IGVsc2Uge1xuICAgICAgICB0aGlzLnRvSW5wdXQoc2VsZWN0b3IsIHZhbHVlKVxuICAgICAgfVxuICAgIH0sXG5cbiAgICB0b0NoZWNrYm94OiBmdW5jdGlvbiAoZWxlbSwgdmFsKSB7XG4gICAgICAkKGVsZW0pLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICBpZiAoJCh0aGlzKS5hdHRyKCd2YWx1ZScpID09IHZhbCkge1xuICAgICAgICAgICQodGhpcykucHJvcCgnY2hlY2tlZCcsIHRydWUpXG4gICAgICAgICAgcmV0dXJuIGZhbHNlXG4gICAgICAgIH1cbiAgICAgIH0pXG4gICAgfSxcblxuICAgIHRvUmFkaW86IGZ1bmN0aW9uIChlbGVtLCB2YWwpIHtcbiAgICAgICQoZWxlbSkuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgIGlmICgkKHRoaXMpLmF0dHIoJ3ZhbHVlJykgPT0gdmFsKSB7XG4gICAgICAgICAgJCh0aGlzKS5wcm9wKCdjaGVja2VkJywgdHJ1ZSlcbiAgICAgICAgICByZXR1cm4gZmFsc2VcbiAgICAgICAgfVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgdG9TZWxlY3Q6IGZ1bmN0aW9uIChlbGVtLCB2YWwpIHtcbiAgICAgICQoZWxlbSkuY2hpbGRyZW4oKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgaWYgKCQodGhpcykuYXR0cigndmFsdWUnKSA9PSB2YWwpIHtcbiAgICAgICAgICAkKHRoaXMpLnByb3AoJ3NlbGVjdGVkJywgdHJ1ZSlcbiAgICAgICAgICByZXR1cm4gZmFsc2VcbiAgICAgICAgfVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgdG9JbnB1dDogZnVuY3Rpb24gKGVsZW0sIHZhbCkge1xuICAgICAgaWYgKCEkKGVsZW0pLmlzKCdpbnB1dFt0eXBlPWhpZGRlbl0nKSkge1xuICAgICAgICAkKGVsZW0pLnZhbCh2YWwpXG4gICAgICB9XG4gICAgfVxuICB9XG5cbiAgLy8galF1ZXJ5IO2UjOufrOq3uOyduFxuICAkLmZuLmRyYWZ0ID0gZnVuY3Rpb24gKGFyZ3MpIHtcbiAgICAvKipcbiAgICAgKiDsmLXshZhcbiAgICAgKiBAdHlwZSB7b2JqZWN0fVxuICAgICAqIEBwcm9wIHs/alF1ZXJ5fSBjb250YWluZXIg7J6E7IucIOyggOyepSDrqqnroZ3snbQg7ZGc7Iuc65CgIOyYgeyXrVxuICAgICAqIEBwcm9wIHtib29sZWFufSB3aXRoRm9ybSBmb3Jt7J2YIOyghOyytCBmaWVsZHMg642w7J207YSwIOyggOyepSDsl6zrtoBcbiAgICAgKiBAcHJvcCB7P2Z1bmN0aW9ufSBjYWxsYmFja1xuICAgICAqL1xuICAgIHZhciBkZWZhdWx0QXJncyA9IHtcbiAgICAgIGNvbnRhaW5lcjogbnVsbCxcbiAgICAgIHdpdGhGb3JtOiBmYWxzZSxcbiAgICAgIGNhbGxiYWNrOiBudWxsXG4gICAgfVxuXG4gICAgYXJncyA9ICQuZXh0ZW5kKHt9LCBkZWZhdWx0QXJncywgYXJncylcblxuICAgIGlmICghYXJncy5rZXkgfHwgIWFyZ3MuYnRuTG9hZCB8fCAhYXJncy5idG5TYXZlKSB7XG4gICAgICBjb25zb2xlLmVycm9yKCdtdXN0IG5lZWQga2V5LCBidG5Mb2FkIGFuZCBidG5TYXZlJylcbiAgICAgIHJldHVybiBmYWxzZVxuICAgIH1cblxuICAgIHZhciBkcmFmdCA9IG5ldyBEcmFmdCh0aGlzLCBhcmdzLmtleSwgYXJncy5jYWxsYmFjaywgYXJncy53aXRoRm9ybSwgYXJncy5jb250YWluZXIsIGFyZ3MuYXBpVXJsKVxuXG4gICAgJChhcmdzLmJ0bkxvYWQpLnVuYmluZCgnY2xpY2suZHJhZnQnKS5iaW5kKCdjbGljay5kcmFmdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KClcbiAgICAgIGRyYWZ0LnRvZ2dsZSh0cnVlKVxuICAgIH0pXG5cbiAgICAkKGFyZ3MuYnRuU2F2ZSkudW5iaW5kKCdjbGljay5kcmFmdCcpLmJpbmQoJ2NsaWNrLmRyYWZ0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuICAgICAgZHJhZnQuZHJhZnRTZXQoKVxuICAgIH0pXG5cbiAgICByZXR1cm4gZHJhZnRcbiAgfVxufSkod2luZG93LlhFLCB3aW5kb3cualF1ZXJ5KVxuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEzMSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxMjkpOyIsIm1vZHVsZS5leHBvcnRzID0gcmVxdWlyZShcImNvcmUtanMtcHVyZS9zdGFibGUvanNvbi9zdHJpbmdpZnlcIik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDIpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2MSk7IiwicmVxdWlyZSgnLi4vLi4vbW9kdWxlcy9lcy5qc29uLnN0cmluZ2lmeScpO1xudmFyIGNvcmUgPSByZXF1aXJlKCcuLi8uLi9pbnRlcm5hbHMvcGF0aCcpO1xuXG4vLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgZXMvbm8tanNvbiAtLSBzYWZlXG5pZiAoIWNvcmUuSlNPTikgY29yZS5KU09OID0geyBzdHJpbmdpZnk6IEpTT04uc3RyaW5naWZ5IH07XG5cbi8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBuby11bnVzZWQtdmFycyAtLSByZXF1aXJlZCBmb3IgYC5sZW5ndGhgXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uIHN0cmluZ2lmeShpdCwgcmVwbGFjZXIsIHNwYWNlKSB7XG4gIHJldHVybiBjb3JlLkpTT04uc3RyaW5naWZ5LmFwcGx5KG51bGwsIGFyZ3VtZW50cyk7XG59O1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEwKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjMpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0OSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE3KTsiLCJ2YXIgJCA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9leHBvcnQnKTtcbnZhciBnZXRCdWlsdEluID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2dldC1idWlsdC1pbicpO1xudmFyIGZhaWxzID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2ZhaWxzJyk7XG5cbnZhciAkc3RyaW5naWZ5ID0gZ2V0QnVpbHRJbignSlNPTicsICdzdHJpbmdpZnknKTtcbnZhciByZSA9IC9bXFx1RDgwMC1cXHVERkZGXS9nO1xudmFyIGxvdyA9IC9eW1xcdUQ4MDAtXFx1REJGRl0kLztcbnZhciBoaSA9IC9eW1xcdURDMDAtXFx1REZGRl0kLztcblxudmFyIGZpeCA9IGZ1bmN0aW9uIChtYXRjaCwgb2Zmc2V0LCBzdHJpbmcpIHtcbiAgdmFyIHByZXYgPSBzdHJpbmcuY2hhckF0KG9mZnNldCAtIDEpO1xuICB2YXIgbmV4dCA9IHN0cmluZy5jaGFyQXQob2Zmc2V0ICsgMSk7XG4gIGlmICgobG93LnRlc3QobWF0Y2gpICYmICFoaS50ZXN0KG5leHQpKSB8fCAoaGkudGVzdChtYXRjaCkgJiYgIWxvdy50ZXN0KHByZXYpKSkge1xuICAgIHJldHVybiAnXFxcXHUnICsgbWF0Y2guY2hhckNvZGVBdCgwKS50b1N0cmluZygxNik7XG4gIH0gcmV0dXJuIG1hdGNoO1xufTtcblxudmFyIEZPUkNFRCA9IGZhaWxzKGZ1bmN0aW9uICgpIHtcbiAgcmV0dXJuICRzdHJpbmdpZnkoJ1xcdURGMDZcXHVEODM0JykgIT09ICdcIlxcXFx1ZGYwNlxcXFx1ZDgzNFwiJ1xuICAgIHx8ICRzdHJpbmdpZnkoJ1xcdURFQUQnKSAhPT0gJ1wiXFxcXHVkZWFkXCInO1xufSk7XG5cbmlmICgkc3RyaW5naWZ5KSB7XG4gIC8vIGBKU09OLnN0cmluZ2lmeWAgbWV0aG9kXG4gIC8vIGh0dHBzOi8vdGMzOS5lcy9lY21hMjYyLyNzZWMtanNvbi5zdHJpbmdpZnlcbiAgLy8gaHR0cHM6Ly9naXRodWIuY29tL3RjMzkvcHJvcG9zYWwtd2VsbC1mb3JtZWQtc3RyaW5naWZ5XG4gICQoeyB0YXJnZXQ6ICdKU09OJywgc3RhdDogdHJ1ZSwgZm9yY2VkOiBGT1JDRUQgfSwge1xuICAgIC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBuby11bnVzZWQtdmFycyAtLSByZXF1aXJlZCBmb3IgYC5sZW5ndGhgXG4gICAgc3RyaW5naWZ5OiBmdW5jdGlvbiBzdHJpbmdpZnkoaXQsIHJlcGxhY2VyLCBzcGFjZSkge1xuICAgICAgdmFyIHJlc3VsdCA9ICRzdHJpbmdpZnkuYXBwbHkobnVsbCwgYXJndW1lbnRzKTtcbiAgICAgIHJldHVybiB0eXBlb2YgcmVzdWx0ID09ICdzdHJpbmcnID8gcmVzdWx0LnJlcGxhY2UocmUsIGZpeCkgOiByZXN1bHQ7XG4gICAgfVxuICB9KTtcbn1cbiIsInZhciBwYXJlbnQgPSByZXF1aXJlKCcuLi8uLi9lcy9qc29uL3N0cmluZ2lmeScpO1xuXG5tb2R1bGUuZXhwb3J0cyA9IHBhcmVudDtcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg5Myk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEyNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE1OCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDI0OSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDM0KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTYzKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjUyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNzQpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg1Nik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDI1Myk7IiwibW9kdWxlLmV4cG9ydHMgPSBfeGVfZGxsX2NvbW1vbjsiXSwic291cmNlUm9vdCI6IiJ9