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
/* harmony import */ var core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.array.iterator.js */ "./node_modules/core-js/modules/es.array.iterator.js");
/* harmony import */ var core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! core-js/modules/es.string.iterator.js */ "./node_modules/core-js/modules/es.string.iterator.js");
/* harmony import */ var core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! core-js/modules/web.dom-collections.iterator.js */ "./node_modules/core-js/modules/web.dom-collections.iterator.js");
/* harmony import */ var core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! core-js/modules/es.regexp.to-string.js */ "./node_modules/core-js/modules/es.regexp.to-string.js");
/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
/* harmony import */ var core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace_js__WEBPACK_IMPORTED_MODULE_14__);
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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(170);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(115);

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

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(80);

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

/***/ "./node_modules/core-js/modules/es.array.iterator.js":
/*!*******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.array.iterator.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(131);

/***/ }),

/***/ "./node_modules/core-js/modules/es.array.join.js":
/*!***************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.array.join.js from dll-reference _xe_dll_common ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(166);

/***/ }),

/***/ "./node_modules/core-js/modules/es.object.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.object.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(26);

/***/ }),

/***/ "./node_modules/core-js/modules/es.promise.js":
/*!************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.promise.js from dll-reference _xe_dll_common ***!
  \************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(292);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.exec.js":
/*!****************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.exec.js from dll-reference _xe_dll_common ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(46);

/***/ }),

/***/ "./node_modules/core-js/modules/es.regexp.to-string.js":
/*!*********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.regexp.to-string.js from dll-reference _xe_dll_common ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(212);

/***/ }),

/***/ "./node_modules/core-js/modules/es.string.iterator.js":
/*!********************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.string.iterator.js from dll-reference _xe_dll_common ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(296);

/***/ }),

/***/ "./node_modules/core-js/modules/es.string.replace.js":
/*!*******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.string.replace.js from dll-reference _xe_dll_common ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(101);

/***/ }),

/***/ "./node_modules/core-js/modules/web.dom-collections.for-each.js":
/*!******************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/web.dom-collections.for-each.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(73);

/***/ }),

/***/ "./node_modules/core-js/modules/web.dom-collections.iterator.js":
/*!******************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/web.dom-collections.iterator.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(297);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS9jb21tb24vanMvZHJhZnQuanMiLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2NvbmNhdC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS90cmltLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9qc29uL3N0cmluZ2lmeS5qcyIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL0BiYWJlbC9ydW50aW1lLWNvcmVqczMvY29yZS1qcy1zdGFibGUvcHJvbWlzZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL3NldC10aW1lb3V0LmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2VzL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL2ludGVybmFscy9mdW5jdGlvbi1hcHBseS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvaW50ZXJuYWxzL3BhdGguanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy1wdXJlL21vZHVsZXMvZXMuanNvbi5zdHJpbmdpZnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzLXB1cmUvc3RhYmxlL2pzb24vc3RyaW5naWZ5LmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLmFycmF5Lml0ZXJhdG9yLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5hcnJheS5qb2luLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5vYmplY3QudG8tc3RyaW5nLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5wcm9taXNlLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5yZWdleHAuZXhlYy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMucmVnZXhwLnRvLXN0cmluZy5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvZXMuc3RyaW5nLml0ZXJhdG9yLmpzIGZyb20gZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiIsIndlYnBhY2s6Ly8vZGVsZWdhdGVkIC4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5zdHJpbmcucmVwbGFjZS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvd2ViLmRvbS1jb2xsZWN0aW9ucy5mb3ItZWFjaC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9jb3JlLWpzL21vZHVsZXMvd2ViLmRvbS1jb2xsZWN0aW9ucy5pdGVyYXRvci5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2V4dGVybmFsIFwiX3hlX2RsbF9jb21tb25cIiJdLCJuYW1lcyI6WyJYRSIsIiQiLCJEcmFmdCIsImVsZW0iLCJrZXkiLCJjYWxsYmFjayIsIndpdGhGb3JtIiwiY29udGFpbmVyIiwiYXBpVXJsIiwiaW50ZXJ2YWwiLCJkcmFmdElkIiwiY29tcG9uZW50IiwiJGNvbXBvbmVudCIsImNvbXBvbmVudE5hbWUiLCJ1aWQiLCJhdHRyIiwiY29uc29sZSIsImVycm9yIiwiaW5pdCIsImJpbmRFdmVudHMiLCJwcm90b3R5cGUiLCJfZ2V0VWlkIiwiYXBwZW5kQ29tcG9uZW50IiwiYWxsIiwiYXBwIiwidGhlbiIsInJlcXVlc3RUcmFuc0FsbCIsIk1hdGgiLCJyYW5kb20iLCJ0b1N0cmluZyIsInN1YnN0cmluZyIsIl90aGlzIiwib24iLCJzYXZlRXZlbnRIYW5kbGVyIiwiZSIsInByZXZlbnREZWZhdWx0IiwiJHRoaXMiLCJ0eXBlIiwiZGF0YSIsIml0ZW0iLCJvbkFwcGx5IiwieGVNb2RhbCIsInNob3ciLCJlbXB0eSIsImlkIiwicmVxRGVsZXRlIiwiY2xvc2VzdCIsInJlbW92ZSIsImFwcEZvcm0iLCJnZXQiLCIkJG9uIiwiZGVsZXRlQXV0byIsIm5hbWUiLCJ0b2dnbGUiLCJoYXNDbGFzcyIsImxvYWQiLCJ0ZW1wIiwiZm9yRWFjaCIsImkiLCJwYXJzZUhUTUwiLCJ2YWwiLCJ0ZXh0IiwiaXNfYXV0byIsIndpbmRvdyIsIkxhbmciLCJ0cmFucyIsImNyZWF0ZWRfYXQiLCJzdWJzdHIiLCJyZXBsYWNlIiwiaHRtbCIsImhpZGUiLCJnZXRNb2RhbFRlbXBsYXRlIiwiam9pbiIsImdldENvbGxhcHNlVGVtcGxhdGUiLCIkY29udGFpbmVyIiwibGVuZ3RoIiwiYWZ0ZXIiLCJjb2xsYXBzZUNsYXNzIiwiX2NvbGxhcHNlQ2xhc3MiLCJhZGRDbGFzcyIsInNldElkIiwidmFsdWVzIiwiZXRjIiwiZGF0YVNldHRlciIsImludGVydmFsQ2xlYXIiLCJzZXRBdXRvIiwiY2xlYXJUaW1lb3V0IiwiZHJhZnRTZXQiLCJyZXFQb3N0IiwicmVxUHV0IiwidG9hc3QiLCJhamF4IiwidXJsIiwiZHJhZnQiLCJhZGQiLCJkYXRhVHlwZSIsImdldFJlcVNlcmlhbGl6ZSIsInN1Y2Nlc3MiLCJqc29uIiwidW5zZXRJZCIsImJpbmQiLCJ1cGRhdGUiLCJlYWNoIiwidmFsdWUiLCJjb250ZW50IiwiYXV0byIsInNldCIsInJlc29sdmUiLCJyZWplY3QiLCJ1bnNldCIsInBhcmFtIiwibGlzdCIsIm9iaiIsInNlcmlhbGl6ZSIsImRlbGV0ZSIsImZvcm0iLCJBcnJheSIsIm11bHRpcGxlIiwic2luZ2xlIiwic2VsZWN0b3IiLCJpcyIsInRvQ2hlY2tib3giLCJ0b0lucHV0IiwiZXEiLCJ0b1JhZGlvIiwidG9TZWxlY3QiLCJwcm9wIiwiY2hpbGRyZW4iLCJmbiIsImFyZ3MiLCJkZWZhdWx0QXJncyIsImV4dGVuZCIsImJ0bkxvYWQiLCJidG5TYXZlIiwidW5iaW5kIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiO1FBQUE7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7OztRQUdBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwwQ0FBMEMsZ0NBQWdDO1FBQzFFO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0Esd0RBQXdELGtCQUFrQjtRQUMxRTtRQUNBLGlEQUFpRCxjQUFjO1FBQy9EOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQSx5Q0FBeUMsaUNBQWlDO1FBQzFFLGdIQUFnSCxtQkFBbUIsRUFBRTtRQUNySTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLDJCQUEyQiwwQkFBMEIsRUFBRTtRQUN2RCxpQ0FBaUMsZUFBZTtRQUNoRDtRQUNBO1FBQ0E7O1FBRUE7UUFDQSxzREFBc0QsK0RBQStEOztRQUVySDtRQUNBOzs7UUFHQTtRQUNBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNsRkE7QUFDQSxDQUFDLFVBQVVBLEVBQVYsRUFBY0MsQ0FBZCxFQUFpQjtFQUNoQjtFQUNBO0FBQ0Y7QUFDQTs7RUFDRSxTQUFTQyxLQUFULENBQWdCQyxJQUFoQixFQUFzQkMsR0FBdEIsRUFBMkJDLFFBQTNCLEVBQXFDQyxRQUFyQyxFQUErQ0MsU0FBL0MsRUFBMERDLE1BQTFELEVBQWtFO0lBQ2hFLEtBQUtKLEdBQUwsR0FBV0EsR0FBWDtJQUNBLEtBQUtELElBQUwsR0FBWUEsSUFBWjtJQUNBLEtBQUtFLFFBQUwsR0FBZ0JB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QW9DLEU7Ozs7Ozs7Ozs7O0FDQTdELDhHOzs7Ozs7Ozs7OztBQ0FBLCtHOzs7Ozs7Ozs7OztBQ0FBLG1CQUFPLENBQUMsaUdBQWlDO0FBQ3pDLFdBQVcsbUJBQU8sQ0FBQywyRUFBc0I7QUFDekMsWUFBWSxtQkFBTyxDQUFDLCtGQUFnQzs7QUFFcEQ7QUFDQSw2QkFBNkI7O0FBRTdCO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUNWQSxnSDs7Ozs7Ozs7Ozs7QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSxnSDs7Ozs7Ozs7Ozs7QUNBQSxhQUFhLG1CQUFPLENBQUMsaUZBQXlCOztBQUU5Qzs7Ozs7Ozs7Ozs7O0FDRkEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsZ0g7Ozs7Ozs7Ozs7O0FDQUEsZ0MiLCJmaWxlIjoiYXNzZXRzL2NvcmUvY29tbW9uL2pzL2RyYWZ0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL2NvbW1vbi9qcy9kcmFmdC5qc1wiKTtcbiIsIi8vIEBUT0RPIOyerOyekeyEsS4g7IKs7Jqp65CY7KeAIOyViuydjFxuKGZ1bmN0aW9uIChYRSwgJCkge1xuICAndXNlIHN0cmljdCdcbiAgLyoqXG4gICogQGNsYXNzXG4gICovXG4gIGZ1bmN0aW9uIERyYWZ0IChlbGVtLCBrZXksIGNhbGxiYWNrLCB3aXRoRm9ybSwgY29udGFpbmVyLCBhcGlVcmwpIHtcbiAgICB0aGlzLmtleSA9IGtleVxuICAgIHRoaXMuZWxlbSA9IGVsZW1cbiAgICB0aGlzLmNhbGxiYWNrID0gY2FsbGJhY2tcbiAgICB0aGlzLndpdGhGb3JtID0gd2l0aEZvcm1cbiAgICB0aGlzLmNvbnRhaW5lciA9IGNvbnRhaW5lclxuICAgIHRoaXMuYXBpVXJsID0gYXBpVXJsXG5cbiAgICB0aGlzLmludGVydmFsID0gbnVsbFxuXG4gICAgdGhpcy5kcmFmdElkID0gbnVsbFxuICAgIHRoaXMuY29tcG9uZW50ID0gbnVsbFxuICAgIHRoaXMuJGNvbXBvbmVudCA9ICQoKVxuICAgIHRoaXMuY29tcG9uZW50TmFtZSA9ICcnXG4gICAgdGhpcy51aWQgPSBudWxsXG5cbiAgICBpZiAoISQodGhpcy5lbGVtKS5hdHRyKCduYW1lJykgfHwgJCh0aGlzLmVsZW0pLmF0dHIoJ25hbWUnKSA9PSAnJykge1xuICAgICAgY29uc29sZS5lcnJvcihcIk11c3Qgc2V0ICduYW1lJyBhdHRyaWJ1dGUgXCIpXG4gICAgICByZXR1cm5cbiAgICB9XG5cbiAgICB0aGlzLmluaXQoKVxuICAgIHRoaXMuYmluZEV2ZW50cygpXG5cbiAgICByZXR1cm4gdGhpc1xuICB9XG5cbiAgLyoqXG4gICogQGxlbmRzIERyYWZ0XG4gICovXG4gIERyYWZ0LnByb3RvdHlwZSA9IHtcbiAgICAvKipcbiAgICAqIOy0iOq4sO2ZlO2VnOuLpC5cbiAgICAqIEBmdW5jdGlvblxuICAgICovXG4gICAgaW5pdDogZnVuY3Rpb24gKCkge1xuICAgICAgdGhpcy51aWQgPSB0aGlzLl9nZXRVaWQoKVxuICAgICAgdGhpcy5hcHBlbmRDb21wb25lbnQoKVxuXG4gICAgICBQcm9taXNlLmFsbChbWEUuYXBwKCdMYW5nJyksIFhFLmFwcCgnUmVxdWVzdCcpXSkudGhlbihmdW5jdGlvbiAoYXBwKSB7XG4gICAgICAgIGFwcFswXS5yZXF1ZXN0VHJhbnNBbGwoWyd4ZTo6ZHJhZnRTYXZlJywgJ3hlOjpkcmFmdFNhdmVkJywgJ3hlOjphdXRvU2F2ZScsICd4ZTo6ZHJhZnRMb2FkJ10pXG4gICAgICB9KVxuICAgIH0sXG5cbiAgICBfZ2V0VWlkOiBmdW5jdGlvbiAoKSB7XG4gICAgICByZXR1cm4gTWF0aC5yYW5kb20oKS50b1N0cmluZygzNikuc3Vic3RyaW5nKDIsIDE1KSArXG4gICAgICBNYXRoLnJhbmRvbSgpLnRvU3RyaW5nKDM2KS5zdWJzdHJpbmcoMiwgMTUpXG4gICAgfSxcblxuICAgIGJpbmRFdmVudHM6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciBfdGhpcyA9IHRoaXNcblxuICAgICAgJCh0aGlzLmVsZW0pLm9uKCdpbnB1dC5kcmFmdCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgX3RoaXMuc2F2ZUV2ZW50SGFuZGxlcigpXG4gICAgICB9KVxuXG4gICAgICBfdGhpcy4kY29tcG9uZW50Lm9uKCdjbGljaycsICcuZHJhZnRfdGl0bGUnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KClcbiAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgICB2YXIgdHlwZSA9ICR0aGlzLmRhdGEoJ3R5cGUnKVxuICAgICAgICB2YXIgaXRlbSA9ICQodGhpcykuZGF0YSgnaXRlbScpXG5cbiAgICAgICAgX3RoaXMub25BcHBseShpdGVtKVxuXG4gICAgICAgIHN3aXRjaCAodHlwZSkge1xuICAgICAgICAgIGNhc2UgJ21vZGFsJzpcbiAgICAgICAgICAgIF90aGlzLiRjb21wb25lbnQueGVNb2RhbCgnaGlkZScpXG4gICAgICAgICAgICBicmVha1xuICAgICAgICAgIGNhc2UgJ2NvbGxhcHNlJzpcbiAgICAgICAgICAgIF90aGlzLiRjb21wb25lbnQuc2hvdygpLmZpbmQoJy5wYW5lbC1ib2R5JykuZW1wdHkoKVxuICAgICAgICAgICAgYnJlYWtcbiAgICAgICAgfVxuICAgICAgfSlcblxuICAgICAgX3RoaXMuJGNvbXBvbmVudC5vbignY2xpY2snLCAnLnhlLWRyYWZ0QnRuQ2xvc2VNb2RhbCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgX3RoaXMuJGNvbXBvbmVudC54ZU1vZGFsKCdoaWRlJylcbiAgICAgIH0pXG5cbiAgICAgIF90aGlzLiRjb21wb25lbnQub24oJ2NsaWNrJywgJy5idG5fZHJhZnRfZGVsZXRlJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG5cbiAgICAgICAgdmFyICR0aGlzID0gJCh0aGlzKVxuICAgICAgICB2YXIgaWQgPSAkdGhpcy5kYXRhKCdpZCcpXG5cbiAgICAgICAgX3RoaXMucmVxRGVsZXRlKGlkLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgJHRoaXMuY2xvc2VzdCgnbGknKS5yZW1vdmUoKVxuICAgICAgICB9KVxuICAgICAgfSlcblxuICAgICAgWEUuYXBwKCdGb3JtJykudGhlbihhcHBGb3JtID0+IHtcbiAgICAgICAgYXBwRm9ybS5nZXQoX3RoaXMuZWxlbSkuJCRvbignc3VibWl0JywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgIHJldHVybiBfdGhpcy5kZWxldGVBdXRvKF90aGlzLmtleSkgLy8gUHJvbWlzZVxuICAgICAgICB9LCB7IG5hbWU6ICd4ZS5kcmFmdCcgfSlcbiAgICAgIH0pXG4gICAgfSxcblxuICAgIHRvZ2dsZTogZnVuY3Rpb24gKHNob3cpIHtcbiAgICAgIHZhciBfdGhpcyA9IHRoaXNcblxuICAgICAgc3dpdGNoICh0aGlzLmNvbXBvbmVudE5hbWUpIHtcbiAgICAgICAgY2FzZSAnbW9kYWwnOlxuICAgICAgICAgIGlmICghc2hvdyAmJiBfdGhpcy4kY29tcG9uZW50Lmhhc0NsYXNzKCdpbicpKSB7XG4gICAgICAgICAgICBfdGhpcy4kY29tcG9uZW50LnhlTW9kYWwoJ2hpZGUnKVxuICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBfdGhpcy5sb2FkKHsga2V5OiBfdGhpcy5rZXkgfSwgZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgICAgICAgdmFyIHRlbXAgPSBgPGRpdiBjbGFzcz1cImRyYWZ0X3NhdmVfbGlzdFwiPmBcbiAgICAgICAgICAgICAgdGVtcCArPSBgPHVsPmBcblxuICAgICAgICAgICAgICBkYXRhLmZvckVhY2goZnVuY3Rpb24gKGl0ZW0sIGkpIHtcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8bGk+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxhIGhyZWY9JyMnIGNsYXNzPSdkcmFmdF90aXRsZScgZGF0YS1pdGVtPScke0pTT04uc3RyaW5naWZ5KGl0ZW0pfScgZGF0YS10eXBlPVwibW9kYWxcIj4keyQoJC5wYXJzZUhUTUwoaXRlbS52YWwpKS50ZXh0KCl9PC9hPmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8ZGl2IGNsYXNzPVwiZHJhZnRfaW5mb1wiPmBcblxuICAgICAgICAgICAgICAgIGlmIChpdGVtLmlzX2F1dG8gPT0gMSkge1xuICAgICAgICAgICAgICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJkcmFmdF9zdGF0ZVwiPiR7d2luZG93LlhFLkxhbmcudHJhbnMoJ3hlOjphdXRvU2F2ZScpfTwvc3Bhbj5gXG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiZHJhZnRfc3RhdGUgdjJcIj4ke3dpbmRvdy5YRS5MYW5nLnRyYW5zKCd4ZTo6ZHJhZnRTYXZlJyl9PC9zcGFuPmBcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cImRyYWZ0X2RhdGVcIj4ke2l0ZW0uY3JlYXRlZF9hdC5zdWJzdHIoMCwgMTYpLnJlcGxhY2UoLy0vZywgJyAnKX08L3NwYW4+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxhIGhyZWY9XCIjXCIgY2xhc3M9XCJidG5fZHJhZnRfZGVsZXRlXCIgZGF0YS1pZD1cIiR7aXRlbS5pZH1cIj48aSBjbGFzcz1cInhpLWNsb3NlXCI+PC9pPjwvYT5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPC9kaXY+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDwvbGk+YFxuICAgICAgICAgICAgICB9KVxuXG4gICAgICAgICAgICAgIHRlbXAgKz0gYDwvdWw+YFxuICAgICAgICAgICAgICB0ZW1wICs9IGA8L2Rpdj5gXG5cbiAgICAgICAgICAgICAgX3RoaXMuJGNvbXBvbmVudC5maW5kKCcueGUtbW9kYWwtYm9keScpLmh0bWwodGVtcClcbiAgICAgICAgICAgICAgX3RoaXMuJGNvbXBvbmVudC54ZU1vZGFsKCdzaG93JylcbiAgICAgICAgICAgIH0pXG4gICAgICAgICAgfVxuXG4gICAgICAgICAgYnJlYWtcbiAgICAgICAgY2FzZSAnY29sbGFwc2UnOlxuXG4gICAgICAgICAgaWYgKCFzaG93ICYmIF90aGlzLiRjb21wb25lbnQuaGFzQ2xhc3MoJ2luJykpIHtcbiAgICAgICAgICAgIF90aGlzLiRjb21wb25lbnQuaGlkZSgpXG4gICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIF90aGlzLmxvYWQoeyBrZXk6IF90aGlzLmtleSB9LCBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICAgICAgICB2YXIgdGVtcCA9IGA8ZGl2IGNsYXNzPVwiZHJhZnRfc2F2ZV9saXN0XCI+YFxuICAgICAgICAgICAgICB0ZW1wICs9IGA8dWw+YFxuXG4gICAgICAgICAgICAgIGRhdGEuZm9yRWFjaChmdW5jdGlvbiAoaXRlbSwgaSkge1xuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxsaT5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPGEgaHJlZj0nIycgY2xhc3M9J2RyYWZ0X3RpdGxlJyBkYXRhLWl0ZW09JyR7SlNPTi5zdHJpbmdpZnkoaXRlbSl9JyBkYXRhLXR5cGU9XCJjb2xsYXBzZVwiPiR7JCgkLnBhcnNlSFRNTChpdGVtLnZhbCkpLnRleHQoKX08L2E+YFxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxkaXYgY2xhc3M9XCJkcmFmdF9pbmZvXCI+YFxuXG4gICAgICAgICAgICAgICAgaWYgKGl0ZW0uaXNfYXV0byA9PSAxKSB7XG4gICAgICAgICAgICAgICAgICB0ZW1wICs9IGA8c3BhbiBjbGFzcz1cImRyYWZ0X3N0YXRlXCI+JHt3aW5kb3cuWEUuTGFuZy50cmFucygneGU6OmF1dG9TYXZlJyl9PC9zcGFuPmBcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgdGVtcCArPSBgPHNwYW4gY2xhc3M9XCJkcmFmdF9zdGF0ZSB2MlwiPiR7d2luZG93LlhFLkxhbmcudHJhbnMoJ3hlOjpkcmFmdFNhdmUnKX08L3NwYW4+YFxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIHRlbXAgKz0gYDxzcGFuIGNsYXNzPVwiZHJhZnRfZGF0ZVwiPiR7aXRlbS5jcmVhdGVkX2F0LnN1YnN0cigwLCAxNikucmVwbGFjZSgvLS9nLCAnICcpfTwvc3Bhbj5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPGEgaHJlZj1cIiNcIiBjbGFzcz1cImJ0bl9kcmFmdF9kZWxldGVcIiBkYXRhLWlkPVwiJHtpdGVtLmlkfVwiPjxpIGNsYXNzPVwieGktY2xvc2VcIj48L2k+PC9hPmBcbiAgICAgICAgICAgICAgICB0ZW1wICs9IGA8L2Rpdj5gXG4gICAgICAgICAgICAgICAgdGVtcCArPSBgPC9saT5gXG4gICAgICAgICAgICAgIH0pXG5cbiAgICAgICAgICAgICAgdGVtcCArPSBgPC91bD5gXG4gICAgICAgICAgICAgIHRlbXAgKz0gYDwvZGl2PmBcblxuICAgICAgICAgICAgICBfdGhpcy4kY29tcG9uZW50LmZpbmQoJy5wYW5lbC1ib2R5JykuaHRtbCh0ZW1wKVxuICAgICAgICAgICAgICBfdGhpcy4kY29tcG9uZW50LnNob3coKVxuICAgICAgICAgICAgfSlcbiAgICAgICAgICB9XG5cbiAgICAgICAgICBicmVha1xuICAgICAgfVxuICAgIH0sXG5cbiAgICBnZXRNb2RhbFRlbXBsYXRlOiBmdW5jdGlvbiAoKSB7XG4gICAgICByZXR1cm4gW1xuICAgICAgICAnPGRpdiBjbGFzcz1cInhlLW1vZGFsIGZhZGVcIiBpZD1cInhlLWRyYWZ0TW9kYWxcIj4nLFxuICAgICAgICAnPGRpdiBjbGFzcz1cInhlLW1vZGFsLWRpYWxvZ1wiPicsXG4gICAgICAgICc8ZGl2IGNsYXNzPVwieGUtbW9kYWwtY29udGVudFwiPicsXG4gICAgICAgICc8ZGl2IGNsYXNzPVwieGUtbW9kYWwtaGVhZGVyXCI+JyxcbiAgICAgICAgJzxidXR0b24gdHlwZT1cImJ1dHRvblwiIGNsYXNzPVwiYnRuLWNsb3NlIHhlLWRyYWZ0QnRuQ2xvc2VcIiBkYXRhLWRpc21pc3M9XCJ4ZS1tb2RhbFwiIGFyaWEtbGFiZWw9XCJDbG9zZVwiPjxpIGNsYXNzPVwieGktY2xvc2VcIj48L2k+PC9idXR0b24+JyxcbiAgICAgICAgJzxzdHJvbmcgY2xhc3M9XCJ4ZS1tb2RhbC10aXRsZVwiPjwvc3Ryb25nPicsXG4gICAgICAgICc8L2Rpdj4nLFxuICAgICAgICAnPGRpdiBjbGFzcz1cInhlLW1vZGFsLWJvZHlcIj48L2Rpdj4nLFxuICAgICAgICAnPGRpdiBjbGFzcz1cInhlLW1vZGFsLWZvb3RlclwiPicsXG4gICAgICAgICc8YnV0dG9uIHR5cGU9XCJidXR0b25cIiBjbGFzcz1cInhlLWJ0biB4ZS1idG4tZGVmYXVsdFwiIGRhdGEtZGlzbWlzcz1cInhlLW1vZGFsXCI+Q2xvc2U8L2J1dHRvbj4nLFxuICAgICAgICAnPC9kaXY+JyxcbiAgICAgICAgJzwvZGl2PicsXG4gICAgICAgICc8L2Rpdj4nLFxuICAgICAgICAnPC9kaXY+J1xuICAgICAgXS5qb2luKCdcXG4nKVxuICAgIH0sXG5cbiAgICBnZXRDb2xsYXBzZVRlbXBsYXRlOiBmdW5jdGlvbiAoKSB7XG4gICAgICByZXR1cm4gW1xuICAgICAgICAnPGRpdiBjbGFzcz1cInBhbmVsIHBhbmVsLWRlZmF1bHRcIj4nLFxuICAgICAgICAnPGRpdiBjbGFzcz1cInBhbmVsLWJvZHlcIj48L2Rpdj4nLFxuICAgICAgICAnPC9kaXY+J1xuICAgICAgXS5qb2luKCdcXG4nKVxuICAgIH0sXG5cbiAgICBhcHBlbmRDb21wb25lbnQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICAgIHZhciAkY29udGFpbmVyID0gJCgnPGRpdj4nKVxuXG4gICAgICBpZiAoJCh0aGlzLmNvbnRhaW5lcikubGVuZ3RoIDwgMSkge1xuICAgICAgICAkKHRoaXMuZWxlbSkuY2xvc2VzdCgnZm9ybScpLmFmdGVyKCRjb250YWluZXIuaHRtbCh0aGlzLmdldE1vZGFsVGVtcGxhdGUoKSkpXG4gICAgICAgIHRoaXMuY29tcG9uZW50TmFtZSA9ICdtb2RhbCdcbiAgICAgICAgdGhpcy4kY29tcG9uZW50ID0gJCgnI3hlLWRyYWZ0TW9kYWwnKVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdGhpcy5jb21wb25lbnROYW1lID0gJ2NvbGxhcHNlJ1xuICAgICAgICB0aGlzLiRjb21wb25lbnQgPSAkKHRoaXMuY29udGFpbmVyKVxuXG4gICAgICAgIHZhciBjb2xsYXBzZUNsYXNzID0gdGhpcy5fY29sbGFwc2VDbGFzcygpXG5cbiAgICAgICAgdGhpcy4kY29tcG9uZW50LmFkZENsYXNzKFtjb2xsYXBzZUNsYXNzLCAnY29sbGFwc2UnXS5qb2luKCcgJykpLmh0bWwoJGNvbnRhaW5lci5odG1sKF90aGlzLmdldENvbGxhcHNlVGVtcGxhdGUoKSkpXG4gICAgICB9XG4gICAgfSxcblxuICAgIG9uQXBwbHk6IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICB2YXIgX3RoaXMgPSB0aGlzXG4gICAgICB0aGlzLnNldElkKGRhdGEuaWQpXG5cbiAgICAgIHZhciB2YWx1ZXMgPSBkYXRhLmV0Y1xuICAgICAgdmFsdWVzWyQoX3RoaXMuZWxlbSkuYXR0cignbmFtZScpXSA9IGRhdGEudmFsXG5cbiAgICAgIGRhdGFTZXR0ZXIuaW5pdCgkKF90aGlzLmVsZW0pLmNsb3Nlc3QoJ2Zvcm0nKVswXSwgdmFsdWVzKVxuICAgICAgdGhpcy5jYWxsYmFjayh2YWx1ZXMpXG4gICAgfSxcblxuICAgIF9jb2xsYXBzZUNsYXNzOiBmdW5jdGlvbiAoKSB7XG4gICAgICByZXR1cm4gJ19feGVfZHJhZnRfY29sbGFwc2VfJyArIHRoaXMudWlkXG4gICAgfSxcblxuICAgIHNhdmVFdmVudEhhbmRsZXI6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICAgIHRoaXMuaW50ZXJ2YWxDbGVhcigpXG5cbiAgICAgIHRoaXMuaW50ZXJ2YWwgPSBzZXRUaW1lb3V0KGZ1bmN0aW9uICgpIHtcbiAgICAgICAgX3RoaXMuc2V0QXV0bygpXG4gICAgICAgIF90aGlzLmludGVydmFsQ2xlYXIoKVxuICAgICAgfSwgMzAwMClcbiAgICB9LFxuXG4gICAgaW50ZXJ2YWxDbGVhcjogZnVuY3Rpb24gKCkge1xuICAgICAgaWYgKHRoaXMuaW50ZXJ2YWwpIHtcbiAgICAgICAgY2xlYXJUaW1lb3V0KHRoaXMuaW50ZXJ2YWwpXG4gICAgICB9XG4gICAgfSxcblxuICAgIGRyYWZ0U2V0OiBmdW5jdGlvbiAoKSB7XG4gICAgICBpZiAoJC50cmltKCQodGhpcy5lbGVtKS52YWwoKSkgPT0gJycpIHtcbiAgICAgICAgcmV0dXJuXG4gICAgICB9XG5cbiAgICAgIGlmICh0aGlzLmRyYWZ0SWQgPT0gbnVsbCkge1xuICAgICAgICB0aGlzLnJlcVBvc3QoKVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdGhpcy5yZXFQdXQoKVxuICAgICAgfVxuXG4gICAgICB3aW5kb3cuWEUudG9hc3QoJ3N1Y2Nlc3MnLCB3aW5kb3cuWEUuTGFuZy50cmFucygneGU6OmRyYWZ0U2F2ZWQnKSlcbiAgICB9LFxuXG4gICAgcmVxUG9zdDogZnVuY3Rpb24gKCkge1xuICAgICAgd2luZG93LlhFLmFqYXgoe1xuICAgICAgICB1cmw6IHRoaXMuYXBpVXJsLmRyYWZ0LmFkZCxcbiAgICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgICBkYXRhOiB0aGlzLmdldFJlcVNlcmlhbGl6ZSgpICsgJyZrZXk9JyArIHRoaXMua2V5LFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoanNvbikge1xuICAgICAgICAgIGlmIChqc29uLmRyYWZ0SWQgPT09IG51bGwpIHtcbiAgICAgICAgICAgIHRoaXMudW5zZXRJZCgpXG4gICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHRoaXMuc2V0SWQoanNvbi5kcmFmdElkKVxuICAgICAgICAgIH1cbiAgICAgICAgfS5iaW5kKHRoaXMpXG4gICAgICB9KVxuICAgIH0sXG5cbiAgICByZXFQdXQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHdpbmRvdy5YRS5hamF4KHtcbiAgICAgICAgdXJsOiB0aGlzLmFwaVVybC5kcmFmdC51cGRhdGUgKyAnLycgKyB0aGlzLmRyYWZ0SWQsXG4gICAgICAgIHR5cGU6ICdwb3N0JyxcbiAgICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgICAgZGF0YTogdGhpcy5nZXRSZXFTZXJpYWxpemUoKSxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGpzb24pIHtcbiAgICAgICAgICB2YXIgX3RoaXMgPSB0aGlzXG5cbiAgICAgICAgICBpZiAoanNvbi5kcmFmdElkID09PSBudWxsKSB7XG4gICAgICAgICAgICB0aGlzLiRjb21wb25lbnQuZmluZCgnbGkgPiBhJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgIHZhciAkdGhpcyA9ICQodGhpcylcbiAgICAgICAgICAgICAgdmFyIGl0ZW0gPSAkdGhpcy5kYXRhKCdpdGVtJylcblxuICAgICAgICAgICAgICBpZiAoaXRlbS5pZCA9PT0gX3RoaXMuZHJhZnRJZCkge1xuICAgICAgICAgICAgICAgIHZhciB2YWx1ZSA9ICQoX3RoaXMuZWxlbSkudmFsKClcblxuICAgICAgICAgICAgICAgIGl0ZW0udmFsID0gdmFsdWVcbiAgICAgICAgICAgICAgICBpdGVtLmV0Yy5jb250ZW50ID0gdmFsdWVcblxuICAgICAgICAgICAgICAgICR0aGlzLmRhdGEoJ2l0ZW0nLCBpdGVtKS50ZXh0KCQoJC5wYXJzZUhUTUwodmFsdWUpKS50ZXh0KCkpXG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pXG5cbiAgICAgICAgICAgIHRoaXMudW5zZXRJZCgpXG4gICAgICAgICAgfVxuICAgICAgICB9LmJpbmQodGhpcylcbiAgICAgIH0pXG4gICAgfSxcblxuICAgIHNldEF1dG86IGZ1bmN0aW9uICgpIHtcbiAgICAgIHdpbmRvdy5YRS5hamF4KHtcbiAgICAgICAgdXJsOiB0aGlzLmFwaVVybC5hdXRvLnNldCxcbiAgICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgICBkYXRhOiB0aGlzLmdldFJlcVNlcmlhbGl6ZSgpICsgJyZrZXk9JyArIHRoaXMua2V5XG4gICAgICB9KVxuICAgIH0sXG5cbiAgICBkZWxldGVBdXRvOiBmdW5jdGlvbiAoa2V5KSB7XG4gICAgICBrZXkgPSBrZXkgfHwgdGhpcy5rZXlcblxuICAgICAgcmV0dXJuIG5ldyBQcm9taXNlKChyZXNvbHZlLCByZWplY3QpID0+IHtcbiAgICAgICAgaWYgKGtleSkge1xuICAgICAgICAgIHdpbmRvdy5YRS5hamF4KHtcbiAgICAgICAgICAgIHVybDogdGhpcy5hcGlVcmwuYXV0by51bnNldCxcbiAgICAgICAgICAgIHR5cGU6ICdwb3N0JyxcbiAgICAgICAgICAgIGRhdGE6ICdrZXk9JyArIGtleSxcbiAgICAgICAgICAgIHN1Y2Nlc3M6ICgpID0+IHtcbiAgICAgICAgICAgICAgcmVzb2x2ZSgpXG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgZXJyb3I6IChlKSA9PiB7XG4gICAgICAgICAgICAgIHJlamVjdChlKVxuICAgICAgICAgICAgfVxuICAgICAgICAgIH0pXG4gICAgICAgIH1cbiAgICAgIH0pXG4gICAgfSxcblxuICAgIGxvYWQ6IGZ1bmN0aW9uIChwYXJhbSwgY2FsbGJhY2spIHtcbiAgICAgIHZhciBfdGhpcyA9IHRoaXNcblxuICAgICAgd2luZG93LlhFLmFqYXgoe1xuICAgICAgICB1cmw6IF90aGlzLmFwaVVybC5kcmFmdC5saXN0LFxuICAgICAgICB0eXBlOiAnZ2V0JyxcbiAgICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgICAgZGF0YTogcGFyYW0sXG4gICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgICAgZGF0YS5mb3JFYWNoKGZ1bmN0aW9uIChvYmosIGkpIHtcbiAgICAgICAgICAgIGlmIChvYmouaXNfYXV0byA9PT0gMSkge1xuICAgICAgICAgICAgICBfdGhpcy5rZXkgPSBvYmouaWRcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9KVxuXG4gICAgICAgICAgaWYgKGNhbGxiYWNrKSB7XG4gICAgICAgICAgICBjYWxsYmFjayhkYXRhKVxuICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgfSlcbiAgICB9LFxuXG4gICAgZ2V0UmVxU2VyaWFsaXplOiBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgZGF0YVxuICAgICAgaWYgKHRoaXMud2l0aEZvcm0gPT09IHRydWUpIHtcbiAgICAgICAgZGF0YSA9ICQodGhpcy5lbGVtKS5jbG9zZXN0KCdmb3JtJykuc2VyaWFsaXplKClcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIGRhdGEgPSBbJCh0aGlzLmVsZW0pLmF0dHIoJ25hbWUnKSwgJCh0aGlzLmVsZW0pLnZhbCgpXS5qb2luKCc9JylcbiAgICAgIH1cblxuICAgICAgcmV0dXJuIGRhdGEgKyAnJnJlcD0nICsgJCh0aGlzLmVsZW0pLmF0dHIoJ25hbWUnKVxuICAgIH0sXG5cbiAgICByZXFEZWxldGU6IGZ1bmN0aW9uIChpZCwgY2FsbGJhY2spIHtcbiAgICAgIHZhciBfdGhpcyA9IHRoaXNcbiAgICAgIGlkID0gaWQgfHwgdGhpcy5kcmFmdElkXG5cbiAgICAgIGlmICghaWQpIHtcbiAgICAgICAgcmV0dXJuXG4gICAgICB9XG5cbiAgICAgIGlmIChpZCA9PSB0aGlzLmRyYWZ0SWQpIHtcbiAgICAgICAgdGhpcy5kcmFmdElkID0gbnVsbFxuICAgICAgfVxuXG4gICAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICAgIHVybDogX3RoaXMuYXBpVXJsLmRyYWZ0LmRlbGV0ZSArICcvJyArIGlkLFxuICAgICAgICB0eXBlOiAncG9zdCcsXG4gICAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICBpZiAoY2FsbGJhY2spIHtcbiAgICAgICAgICAgIGNhbGxiYWNrKClcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0pXG4gICAgfSxcblxuICAgIHNldElkOiBmdW5jdGlvbiAoaWQpIHtcbiAgICAgIHRoaXMuZHJhZnRJZCA9IGlkXG4gICAgfSxcblxuICAgIHVuc2V0SWQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHRoaXMuZHJhZnRJZCA9IG51bGxcbiAgICB9XG4gIH1cblxuICB2YXIgZGF0YVNldHRlciA9IHtcbiAgICBpbml0OiBmdW5jdGlvbiAoZm9ybSwgZGF0YSkge1xuICAgICAgZm9yICh2YXIgaSBpbiBkYXRhKSB7XG4gICAgICAgIHZhciBuYW1lID0gaVxuICAgICAgICBpZiAoZGF0YVtpXSBpbnN0YW5jZW9mIEFycmF5KSB7XG4gICAgICAgICAgbmFtZSA9IG5hbWUgKyAnW10nXG4gICAgICAgICAgdGhpcy5tdWx0aXBsZShmb3JtW25hbWVdLCBkYXRhW2ldKVxuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgIHRoaXMuc2luZ2xlKGZvcm1bbmFtZV0sIGRhdGFbaV0pXG4gICAgICAgIH1cbiAgICAgIH1cbiAgICB9LFxuXG4gICAgbXVsdGlwbGU6IGZ1bmN0aW9uIChzZWxlY3RvciwgdmFsdWVzKSB7XG4gICAgICBpZiAoJChzZWxlY3RvcikuaXMoJzpjaGVja2JveCcpKSB7XG4gICAgICAgICQuZWFjaCh2YWx1ZXMsIGZ1bmN0aW9uIChpLCB2YWwpIHtcbiAgICAgICAgICB0aGlzLnRvQ2hlY2tib3goc2VsZWN0b3IsIHZhbClcbiAgICAgICAgfS5iaW5kKHRoaXMpKVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgJC5lYWNoKHZhbHVlcywgZnVuY3Rpb24gKGksIHZhbCkge1xuICAgICAgICAgIHRoaXMudG9JbnB1dCgkKHNlbGVjdG9yKS5lcShpKVswXSwgdmFsKVxuICAgICAgICB9LmJpbmQodGhpcykpXG4gICAgICB9XG4gICAgfSxcblxuICAgIHNpbmdsZTogZnVuY3Rpb24gKHNlbGVjdG9yLCB2YWx1ZSkge1xuICAgICAgaWYgKCQoc2VsZWN0b3IpLmlzKCc6Y2hlY2tib3gnKSkge1xuICAgICAgICB0aGlzLnRvQ2hlY2tib3goc2VsZWN0b3IsIHZhbHVlKVxuICAgICAgfSBlbHNlIGlmICgkKHNlbGVjdG9yKS5pcygnOnJhZGlvJykpIHtcbiAgICAgICAgdGhpcy50b1JhZGlvKHNlbGVjdG9yLCB2YWx1ZSlcbiAgICAgIH0gZWxzZSBpZiAoJChzZWxlY3RvcikuaXMoJ3NlbGVjdCcpKSB7XG4gICAgICAgIHRoaXMudG9TZWxlY3Qoc2VsZWN0b3IsIHZhbHVlKVxuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdGhpcy50b0lucHV0KHNlbGVjdG9yLCB2YWx1ZSlcbiAgICAgIH1cbiAgICB9LFxuXG4gICAgdG9DaGVja2JveDogZnVuY3Rpb24gKGVsZW0sIHZhbCkge1xuICAgICAgJChlbGVtKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgaWYgKCQodGhpcykuYXR0cigndmFsdWUnKSA9PSB2YWwpIHtcbiAgICAgICAgICAkKHRoaXMpLnByb3AoJ2NoZWNrZWQnLCB0cnVlKVxuICAgICAgICAgIHJldHVybiBmYWxzZVxuICAgICAgICB9XG4gICAgICB9KVxuICAgIH0sXG5cbiAgICB0b1JhZGlvOiBmdW5jdGlvbiAoZWxlbSwgdmFsKSB7XG4gICAgICAkKGVsZW0pLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICBpZiAoJCh0aGlzKS5hdHRyKCd2YWx1ZScpID09IHZhbCkge1xuICAgICAgICAgICQodGhpcykucHJvcCgnY2hlY2tlZCcsIHRydWUpXG4gICAgICAgICAgcmV0dXJuIGZhbHNlXG4gICAgICAgIH1cbiAgICAgIH0pXG4gICAgfSxcblxuICAgIHRvU2VsZWN0OiBmdW5jdGlvbiAoZWxlbSwgdmFsKSB7XG4gICAgICAkKGVsZW0pLmNoaWxkcmVuKCkuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgIGlmICgkKHRoaXMpLmF0dHIoJ3ZhbHVlJykgPT0gdmFsKSB7XG4gICAgICAgICAgJCh0aGlzKS5wcm9wKCdzZWxlY3RlZCcsIHRydWUpXG4gICAgICAgICAgcmV0dXJuIGZhbHNlXG4gICAgICAgIH1cbiAgICAgIH0pXG4gICAgfSxcblxuICAgIHRvSW5wdXQ6IGZ1bmN0aW9uIChlbGVtLCB2YWwpIHtcbiAgICAgIGlmICghJChlbGVtKS5pcygnaW5wdXRbdHlwZT1oaWRkZW5dJykpIHtcbiAgICAgICAgJChlbGVtKS52YWwodmFsKVxuICAgICAgfVxuICAgIH1cbiAgfVxuXG4gIC8vIGpRdWVyeSDtlIzrn6zqt7jsnbhcbiAgJC5mbi5kcmFmdCA9IGZ1bmN0aW9uIChhcmdzKSB7XG4gICAgLyoqXG4gICAgICog7Ji17IWYXG4gICAgICogQHR5cGUge29iamVjdH1cbiAgICAgKiBAcHJvcCB7P2pRdWVyeX0gY29udGFpbmVyIOyehOyLnCDsoIDsnqUg66qp66Gd7J20IO2RnOyLnOuQoCDsmIHsl61cbiAgICAgKiBAcHJvcCB7Ym9vbGVhbn0gd2l0aEZvcm0gZm9ybeydmCDsoITssrQgZmllbGRzIOuNsOydtO2EsCDsoIDsnqUg7Jes67aAXG4gICAgICogQHByb3Agez9mdW5jdGlvbn0gY2FsbGJhY2tcbiAgICAgKi9cbiAgICB2YXIgZGVmYXVsdEFyZ3MgPSB7XG4gICAgICBjb250YWluZXI6IG51bGwsXG4gICAgICB3aXRoRm9ybTogZmFsc2UsXG4gICAgICBjYWxsYmFjazogbnVsbFxuICAgIH1cblxuICAgIGFyZ3MgPSAkLmV4dGVuZCh7fSwgZGVmYXVsdEFyZ3MsIGFyZ3MpXG5cbiAgICBpZiAoIWFyZ3Mua2V5IHx8ICFhcmdzLmJ0bkxvYWQgfHwgIWFyZ3MuYnRuU2F2ZSkge1xuICAgICAgY29uc29sZS5lcnJvcignbXVzdCBuZWVkIGtleSwgYnRuTG9hZCBhbmQgYnRuU2F2ZScpXG4gICAgICByZXR1cm4gZmFsc2VcbiAgICB9XG5cbiAgICB2YXIgZHJhZnQgPSBuZXcgRHJhZnQodGhpcywgYXJncy5rZXksIGFyZ3MuY2FsbGJhY2ssIGFyZ3Mud2l0aEZvcm0sIGFyZ3MuY29udGFpbmVyLCBhcmdzLmFwaVVybClcblxuICAgICQoYXJncy5idG5Mb2FkKS51bmJpbmQoJ2NsaWNrLmRyYWZ0JykuYmluZCgnY2xpY2suZHJhZnQnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpXG4gICAgICBkcmFmdC50b2dnbGUodHJ1ZSlcbiAgICB9KVxuXG4gICAgJChhcmdzLmJ0blNhdmUpLnVuYmluZCgnY2xpY2suZHJhZnQnKS5iaW5kKCdjbGljay5kcmFmdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KClcbiAgICAgIGRyYWZ0LmRyYWZ0U2V0KClcbiAgICB9KVxuXG4gICAgcmV0dXJuIGRyYWZ0XG4gIH1cbn0pKHdpbmRvdy5YRSwgd2luZG93LmpRdWVyeSlcbiIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgxNzApOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTE1KTsiLCJtb2R1bGUuZXhwb3J0cyA9IHJlcXVpcmUoXCJjb3JlLWpzLXB1cmUvc3RhYmxlL2pzb24vc3RyaW5naWZ5XCIpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoODApOyIsInJlcXVpcmUoJy4uLy4uL21vZHVsZXMvZXMuanNvbi5zdHJpbmdpZnknKTtcbnZhciBwYXRoID0gcmVxdWlyZSgnLi4vLi4vaW50ZXJuYWxzL3BhdGgnKTtcbnZhciBhcHBseSA9IHJlcXVpcmUoJy4uLy4uL2ludGVybmFscy9mdW5jdGlvbi1hcHBseScpO1xuXG4vLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgZXMteC9uby1qc29uIC0tIHNhZmVcbmlmICghcGF0aC5KU09OKSBwYXRoLkpTT04gPSB7IHN0cmluZ2lmeTogSlNPTi5zdHJpbmdpZnkgfTtcblxuLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG5vLXVudXNlZC12YXJzIC0tIHJlcXVpcmVkIGZvciBgLmxlbmd0aGBcbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gc3RyaW5naWZ5KGl0LCByZXBsYWNlciwgc3BhY2UpIHtcbiAgcmV0dXJuIGFwcGx5KHBhdGguSlNPTi5zdHJpbmdpZnksIG51bGwsIGFyZ3VtZW50cyk7XG59O1xuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDExNyk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDIyKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNTI5KTsiLCJ2YXIgcGFyZW50ID0gcmVxdWlyZSgnLi4vLi4vZXMvanNvbi9zdHJpbmdpZnknKTtcblxubW9kdWxlLmV4cG9ydHMgPSBwYXJlbnQ7XG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTMxKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMTY2KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjYpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSgyOTIpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg0Nik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDIxMik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDI5Nik7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDEwMSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDczKTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMjk3KTsiLCJtb2R1bGUuZXhwb3J0cyA9IF94ZV9kbGxfY29tbW9uOyJdLCJzb3VyY2VSb290IjoiIn0=