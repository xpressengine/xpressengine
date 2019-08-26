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
/******/ 	return __webpack_require__(__webpack_require__.s = "./core/common/js/dynamicField.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./core/common/js/dynamicField.js":
/*!****************************************!*\
  !*** ./core/common/js/dynamicField.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/for-each */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/for-each.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var xe_validator__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! xe/validator */ "./core/validator/index.js");



 // @FIXME https://github.com/xpressengine/xpressengine/issues/765

/**
 * @class
 */

var DynamicField = function DynamicField() {
  this.group = '';
  this.databaseName = '';
  this.containerName = '';
  this.$container = '';
  /**
   * DynamicField를 초기화 한다.
   * @param {string} group
   * @param {string} databaseName
   */

  this.init = function (group, databaseName) {
    var _context, _context2, _context3;

    this.group = group;
    this.databaseName = databaseName;
    this.containerName = '__xe_container_DF_setting_' + group;
    this.$container = jquery__WEBPACK_IMPORTED_MODULE_2___default()('#' + this.containerName);
    this.$container.$form = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context = this.$container).call(_context, '.__xe_add_form');
    this.$container.$modal = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context2 = this.$container).call(_context2, '.__xe_df_modal');
    this.$container.$modal.$body = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context3 = this.$container.$modal).call(_context3, '.modal-body');
    this.validator = new xe_validator__WEBPACK_IMPORTED_MODULE_3__["default"]();
    this.attachEvent();

    this.closeAll = function () {
      this.$container.$modal.xeModal('hide');
    };
  };
  /**
   * 이벤트 핸들러를 등록한다.
   */


  this.attachEvent = function () {
    var that = this;
    this.$container.on('click', '.__xe_btn_add', function () {
      var _context4;

      that.$container.$modal.$body.html(that.formClone());
      that.$container.$modal.xeModal('show');

      var $langBox = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context4 = that.$container.$modal).call(_context4, '.dynamic-lang-editor-box');

      $langBox.addClass('lang-editor-box');
      $langBox.each(function (idx, element) {
        window.langEditorBoxRender(jquery__WEBPACK_IMPORTED_MODULE_2___default()(element)); // FIXME
      });
    });
    this.$container.on('click', '.__xe_btn_submit', function () {
      that.store(this);
    });
    this.$container.on('click', '.__xe_btn_close', function () {
      that.close(this);
    });
    this.$container.on('click', '.__xe_btn_edit', function (e) {
      e.preventDefault();
      that.closeAll();
      that.edit(this);
    });
    this.$container.on('click', '.__xe_btn_delete', function (e) {
      e.preventDefault();
      that.destroy(this);
      that.closeAll();
    });
    this.$container.on('change', '.__xe_type_id', function (e) {
      var form = jquery__WEBPACK_IMPORTED_MODULE_2___default()(this).closest('form');

      var select = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="skinId"]');

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(select).call(select, 'option').remove();

      select.prop('disabled', true);
      that.getSkinOption(form);
    });
    this.$container.on('change', '.__xe_skin_id', function (e) {
      var form = jquery__WEBPACK_IMPORTED_MODULE_2___default()(this).closest('form');
      that.getAdditionalConfigure(form);
    });
    this.$container.on('click', '.__xe_checkbox-config', function (e) {
      var $target = jquery__WEBPACK_IMPORTED_MODULE_2___default()(e.target);
      var form = jquery__WEBPACK_IMPORTED_MODULE_2___default()(this).closest('form');

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="' + $target.data('name') + '"]').val($target.prop('checked') == true ? 'true' : 'false');
    });
  };
  /**
   * container를 리턴한다.
   * @param {jQuery} form
   * @return {jQuery}
   */


  this.getFormContainer = function (form) {
    return form.closest('.__xe_form_container');
  };
  /**
   * modal을 close한다.
   * @param {jQuery} target
   */


  this.close = function (target) {
    var form = jquery__WEBPACK_IMPORTED_MODULE_2___default()(target).closest('form');
    form.remove();
    this.$container.$modal.xeModal('hide');
  };
  /**
   * group 리스트를 요청한다.
   */


  this.getList = function () {
    var params = {
      group: this.group
    };
    var that = this;
    var jqxhr = window.XE.ajax({
      context: this.$container[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.index')
    });
    jqxhr.done(function (data, textStatus, jqxhr) {
      var _context5;

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context5 = that.$container).call(_context5, '#df-tbody tr').remove();

      for (var i in data.list) {
        that.addrow(data.list[i]);
      }
    });
  };
  /**
   * form을 복사하여 리턴한다.
   * @return {jQuery} $form
   */


  this.formClone = function () {
    var $form = this.$container.$form.clone().removeClass('__xe_add_form');
    $form.show();
    return $form;
  };
  /**
   * 리스트 테이블에 row를 추가한다.
   * @param {object} data
   */


  this.addrow = function (data) {
    var _context6, _context7, _context8;

    var row = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context6 = this.$container).call(_context6, '.__xe_row').clone();

    row.removeClass('__xe_row');
    row.addClass('__xe_row_' + data.id);
    row.data('id', data.id);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(row).call(row, 'td.__xe_column_id').html(data.id);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(row).call(row, 'td.__xe_column_label').html(data.label);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(row).call(row, 'td.__xe_column_typeName').html(data.typeName);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(row).call(row, 'td.__xe_column_skinName').html(data.skinName);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(row).call(row, 'td.__xe_column_use').html(data.use == true ? 'True' : 'False');

    if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context7 = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context8 = this.$container).call(_context8, '.__xe_tbody')).call(_context7, '.__xe_row_' + data.id).length != 0) {
      var _context9, _context10;

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context9 = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context10 = this.$container).call(_context10, '.__xe_tbody')).call(_context9, '.__xe_row_' + data.id).replaceWith(row.show());
    } else {
      var _context11;

      this.removeRow(data.id);

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context11 = this.$container).call(_context11, '.__xe_tbody').append(row.show());
    }
  };
  /**
   * row를 삭제한다.
   * @param {string} id
   */


  this.removeRow = function (id) {
    var _context12, _context13;

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context12 = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context13 = this.$container).call(_context13, '.__xe_tbody')).call(_context12, '.__xe_row_' + id).remove();
  };
  /**
   * row를 수정한다.
   * @param {jQuery} o
   */


  this.edit = function (o) {
    var tr = jquery__WEBPACK_IMPORTED_MODULE_2___default()(o).closest('tr');
    var id = tr.data('id');
    var form = this.formClone();
    form.data('isEdit', '1');
    form.attr('action', window.XE.route('manage.dynamicField.update'));
    this.$container.$modal.$body.html(form);
    this.$container.$modal.xeModal('show');
    var params = {
      group: this.group,
      id: id
    };
    var that = this;
    window.XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.getEditInfo'),
      success: function success(response) {
        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="id"]').val(response.config.id).prop('readonly', true);

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="typeId"] option').each(function () {
          var $option = jquery__WEBPACK_IMPORTED_MODULE_2___default()(this);

          if ($option.val() != response.config.typeId) {
            $option.remove();
          }
        });

        var $langBox = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '.dynamic-lang-editor-box');

        $langBox.addClass('lang-editor-box');
        $langBox.each(function (idx, element) {
          jquery__WEBPACK_IMPORTED_MODULE_2___default()(element).data('lang-key', response.config[jquery__WEBPACK_IMPORTED_MODULE_2___default()(element).data('name')]);
          window.langEditorBoxRender(jquery__WEBPACK_IMPORTED_MODULE_2___default()(element)); // FIXME
        }); // @FIXME

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="use"]').val(that.checkBox(response.config.use) ? 'true' : 'false');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="required"]').val(that.checkBox(response.config.required) ? 'true' : 'false');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="sortable"]').val(that.checkBox(response.config.sortable) ? 'true' : 'false');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="searchable"]').val(that.checkBox(response.config.searchable) ? 'true' : 'false');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[data-name="use"]').prop('checked', that.checkBox(response.config.use));

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[data-name="required"]').prop('checked', that.checkBox(response.config.required));

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[data-name="searchable"]').prop('checked', that.checkBox(response.config.searchable));

        that.getSkinOption(form);
      }
    });
  };
  /**
   * 파라미터 boolean값이 true일 경우 true, false일 경우 false를 리턴한다
   * @param {string|boolean} data
   */


  this.checkBox = function (data) {
    // @FIXME
    var checked = false;

    if (data == undefined) {
      checked = false;
    } else if (data == 'false') {
      checked = false;
    } else if (data == 'true') {
      checked = true;
    } else if (data == true) {
      checked = true;
    }

    return checked;
  };
  /**
   * row 삭제 요청을 한다.
   * @param {jQuery} target
   */


  this.destroy = function (target) {
    if (confirm('이동작은 되돌릴 수 없습니다. 계속하시겠습니까?') === false) {
      // @FIXME
      return;
    }

    var tr = jquery__WEBPACK_IMPORTED_MODULE_2___default()(target).closest('tr');
    var id = tr.data('id');
    var params = {
      group: this.group,
      databaseName: this.databaseName,
      id: id
    };
    var that = this;
    window.XE.ajax({
      context: this.$container[0],
      type: 'post',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.destroy'),
      success: function success(response) {
        var id = response.id;

        if (response.id == response.updateid) {
          that.openStep('close');
        }

        that.removeRow(id);
      }
    });
  };
  /**
   * 스킨 옵션을 요청한다.
   * @param {jQuery} form
   */


  this.getSkinOption = function (form) {
    var params = form.serialize();
    var that = this;

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '.__xe_additional_configure').html('');

    if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="typeId"]').val() == '') {
      return;
    }

    window.XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.getSkinOption'),
      success: function success(response) {
        that.skinOptions(form, response.skins, response.skinId);
      }
    });
  };
  /**
   * 스킨옵션 selectbox를 구성한다.
   * @param {jQuery} form
   * @param {object} skins
   * @param {string} selected
   */


  this.skinOptions = function (form, skins, selected) {
    var select = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(form).call(form, '[name="skinId"]');

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(select).call(select, 'option').remove();

    for (var key in skins) {
      var option = jquery__WEBPACK_IMPORTED_MODULE_2___default()('<option>').attr('value', key).text(skins[key]);
      select.append(option);
    }

    if (selected != undefined && selected != '') {
      select.val(selected);
    }

    select.prop('disabled', false);
    this.getAdditionalConfigure(form);
  };
  /**
   * 필드마다 추가설정을 로드한다.
   * @param {jQuery} $form
   */


  this.getAdditionalConfigure = function ($form) {
    var _context14;

    var params = {};

    _babel_runtime_corejs3_core_js_stable_instance_for_each__WEBPACK_IMPORTED_MODULE_0___default()(_context14 = $form.serializeArray()).call(_context14, function (item) {
      params[item.name] = item.value;
    });

    window.XE.get('manage.dynamicField.getAdditionalConfigure', params, {
      headers: {
        'X-XE-Async-Expose': true
      }
    }).then(function (response) {
      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()($form).call($form, '.__xe_additional_configure').html(response.data.result);
    });
  };
  /**
   * 확장필드를 등록한다.
   * @param {jQuery} target
   */


  this.store = function (target) {
    var _context15;

    var $form = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_1___default()(_context15 = this.$container.$modal.$body).call(_context15, 'form');

    var that = this;

    try {
      this.validateCheck($form);
    } catch (e) {
      return;
    }

    var params = $form.serialize();
    window.XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'post',
      dataType: 'json',
      data: params,
      url: $form.attr('action'),
      success: function success(response) {
        that.addrow(response);
        that.close(target);
      }
    });
  };
  /**
   * 폼 요소에 validation rule을 등록한다.
   * @param {jQuery} $form
   * @param {object} addRules
   */


  this.setValidateRule = function ($form, addRules) {
    var ruleName = this.validator.getRuleName($form);

    if (addRules != undefined && ruleName != undefined) {
      this.validator.setRules(ruleName, addRules);
    }
  };
  /**
   * 폼 요소에 validation을 체크한다.
   * @param {jQuery} $form
   */


  this.validateCheck = function ($form) {
    this.validator.check($form);
  };
};

/* harmony default export */ __webpack_exports__["default"] = (DynamicField); // @FIXME

var instance = new DynamicField();
instance.init(window.dynamicFieldData.group, window.dynamicFieldData.databaseName);
instance.getList();

/***/ }),

/***/ "./core/validator/index.js":
/*!*****************************************************************************!*\
  !*** delegated ./core/validator/index.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(317);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS9jb21tb24vanMvZHluYW1pY0ZpZWxkLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9jb3JlL3ZhbGlkYXRvci9pbmRleC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvQGJhYmVsL3J1bnRpbWUtY29yZWpzMy9jb3JlLWpzLXN0YWJsZS9pbnN0YW5jZS9mb3ItZWFjaC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9qcXVlcnkvc3JjL2pxdWVyeS5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2V4dGVybmFsIFwiX3hlX2RsbF9jb21tb25cIiJdLCJuYW1lcyI6WyJEeW5hbWljRmllbGQiLCJncm91cCIsImRhdGFiYXNlTmFtZSIsImNvbnRhaW5lck5hbWUiLCIkY29udGFpbmVyIiwiaW5pdCIsIiQiLCIkZm9ybSIsIiRtb2RhbCIsIiRib2R5IiwidmFsaWRhdG9yIiwiVmFsaWRhdG9yIiwiYXR0YWNoRXZlbnQiLCJjbG9zZUFsbCIsInhlTW9kYWwiLCJ0aGF0Iiwib24iLCJodG1sIiwiZm9ybUNsb25lIiwiJGxhbmdCb3giLCJhZGRDbGFzcyIsImVhY2giLCJpZHgiLCJlbGVtZW50Iiwid2luZG93IiwibGFuZ0VkaXRvckJveFJlbmRlciIsInN0b3JlIiwiY2xvc2UiLCJlIiwicHJldmVudERlZmF1bHQiLCJlZGl0IiwiZGVzdHJveSIsImZvcm0iLCJjbG9zZXN0Iiwic2VsZWN0IiwicmVtb3ZlIiwicHJvcCIsImdldFNraW5PcHRpb24iLCJnZXRBZGRpdGlvbmFsQ29uZmlndXJlIiwiJHRhcmdldCIsInRhcmdldCIsImRhdGEiLCJ2YWwiLCJnZXRGb3JtQ29udGFpbmVyIiwiZ2V0TGlzdCIsInBhcmFtcyIsImpxeGhyIiwiWEUiLCJhamF4IiwiY29udGV4dCIsInR5cGUiLCJkYXRhVHlwZSIsInVybCIsInJvdXRlIiwiZG9uZSIsInRleHRTdGF0dXMiLCJpIiwibGlzdCIsImFkZHJvdyIsImNsb25lIiwicmVtb3ZlQ2xhc3MiLCJzaG93Iiwicm93IiwiaWQiLCJsYWJlbCIsInR5cGVOYW1lIiwic2tpbk5hbWUiLCJ1c2UiLCJsZW5ndGgiLCJyZXBsYWNlV2l0aCIsInJlbW92ZVJvdyIsImFwcGVuZCIsIm8iLCJ0ciIsImF0dHIiLCJzdWNjZXNzIiwicmVzcG9uc2UiLCJjb25maWciLCIkb3B0aW9uIiwidHlwZUlkIiwiY2hlY2tCb3giLCJyZXF1aXJlZCIsInNvcnRhYmxlIiwic2VhcmNoYWJsZSIsImNoZWNrZWQiLCJ1bmRlZmluZWQiLCJjb25maXJtIiwidXBkYXRlaWQiLCJvcGVuU3RlcCIsInNlcmlhbGl6ZSIsInNraW5PcHRpb25zIiwic2tpbnMiLCJza2luSWQiLCJzZWxlY3RlZCIsImtleSIsIm9wdGlvbiIsInRleHQiLCJzZXJpYWxpemVBcnJheSIsIml0ZW0iLCJuYW1lIiwidmFsdWUiLCJnZXQiLCJoZWFkZXJzIiwidGhlbiIsInJlc3VsdCIsInZhbGlkYXRlQ2hlY2siLCJzZXRWYWxpZGF0ZVJ1bGUiLCJhZGRSdWxlcyIsInJ1bGVOYW1lIiwiZ2V0UnVsZU5hbWUiLCJzZXRSdWxlcyIsImNoZWNrIiwiaW5zdGFuY2UiLCJkeW5hbWljRmllbGREYXRhIl0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNB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QUNBQSwrRzs7Ozs7Ozs7Ozs7QUNBQSw4Rzs7Ozs7Ozs7Ozs7QUNBQSxnQyIsImZpbGUiOiJhc3NldHMvY29yZS9jb21tb24vanMvZHluYW1pY0ZpZWxkLmpzIiwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi9jb3JlL2NvbW1vbi9qcy9keW5hbWljRmllbGQuanNcIik7XG4iLCJpbXBvcnQgJCBmcm9tICdqcXVlcnknXG5pbXBvcnQgVmFsaWRhdG9yIGZyb20gJ3hlL3ZhbGlkYXRvcicgLy8gQEZJWE1FIGh0dHBzOi8vZ2l0aHViLmNvbS94cHJlc3NlbmdpbmUveHByZXNzZW5naW5lL2lzc3Vlcy83NjVcblxuLyoqXG4gKiBAY2xhc3NcbiAqL1xudmFyIER5bmFtaWNGaWVsZCA9IGZ1bmN0aW9uICgpIHtcbiAgdGhpcy5ncm91cCA9ICcnXG4gIHRoaXMuZGF0YWJhc2VOYW1lID0gJydcbiAgdGhpcy5jb250YWluZXJOYW1lID0gJydcbiAgdGhpcy4kY29udGFpbmVyID0gJydcblxuICAvKipcbiAgICogRHluYW1pY0ZpZWxk66W8IOy0iOq4sO2ZlCDtlZzri6QuXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBncm91cFxuICAgKiBAcGFyYW0ge3N0cmluZ30gZGF0YWJhc2VOYW1lXG4gICAqL1xuICB0aGlzLmluaXQgPSBmdW5jdGlvbiAoZ3JvdXAsIGRhdGFiYXNlTmFtZSkge1xuICAgIHRoaXMuZ3JvdXAgPSBncm91cFxuICAgIHRoaXMuZGF0YWJhc2VOYW1lID0gZGF0YWJhc2VOYW1lXG4gICAgdGhpcy5jb250YWluZXJOYW1lID0gJ19feGVfY29udGFpbmVyX0RGX3NldHRpbmdfJyArIGdyb3VwXG4gICAgdGhpcy4kY29udGFpbmVyID0gJCgnIycgKyB0aGlzLmNvbnRhaW5lck5hbWUpXG4gICAgdGhpcy4kY29udGFpbmVyLiRmb3JtID0gdGhpcy4kY29udGFpbmVyLmZpbmQoJy5fX3hlX2FkZF9mb3JtJylcbiAgICB0aGlzLiRjb250YWluZXIuJG1vZGFsID0gdGhpcy4kY29udGFpbmVyLmZpbmQoJy5fX3hlX2RmX21vZGFsJylcbiAgICB0aGlzLiRjb250YWluZXIuJG1vZGFsLiRib2R5ID0gdGhpcy4kY29udGFpbmVyLiRtb2RhbC5maW5kKCcubW9kYWwtYm9keScpXG4gICAgdGhpcy52YWxpZGF0b3IgPSBuZXcgVmFsaWRhdG9yKClcblxuICAgIHRoaXMuYXR0YWNoRXZlbnQoKVxuXG4gICAgdGhpcy5jbG9zZUFsbCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgIHRoaXMuJGNvbnRhaW5lci4kbW9kYWwueGVNb2RhbCgnaGlkZScpXG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIOydtOuypO2KuCDtlbjrk6Trn6zrpbwg65Ox66Gd7ZWc64ukLlxuICAgKi9cbiAgdGhpcy5hdHRhY2hFdmVudCA9IGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgdGhhdCA9IHRoaXNcblxuICAgIHRoaXMuJGNvbnRhaW5lci5vbignY2xpY2snLCAnLl9feGVfYnRuX2FkZCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHRoYXQuJGNvbnRhaW5lci4kbW9kYWwuJGJvZHkuaHRtbCh0aGF0LmZvcm1DbG9uZSgpKVxuICAgICAgdGhhdC4kY29udGFpbmVyLiRtb2RhbC54ZU1vZGFsKCdzaG93JylcblxuICAgICAgdmFyICRsYW5nQm94ID0gdGhhdC4kY29udGFpbmVyLiRtb2RhbC5maW5kKCcuZHluYW1pYy1sYW5nLWVkaXRvci1ib3gnKVxuICAgICAgJGxhbmdCb3guYWRkQ2xhc3MoJ2xhbmctZWRpdG9yLWJveCcpXG5cbiAgICAgICRsYW5nQm94LmVhY2goZnVuY3Rpb24gKGlkeCwgZWxlbWVudCkge1xuICAgICAgICB3aW5kb3cubGFuZ0VkaXRvckJveFJlbmRlcigkKGVsZW1lbnQpKSAvLyBGSVhNRVxuICAgICAgfSlcbiAgICB9KVxuXG4gICAgdGhpcy4kY29udGFpbmVyLm9uKCdjbGljaycsICcuX194ZV9idG5fc3VibWl0JywgZnVuY3Rpb24gKCkge1xuICAgICAgdGhhdC5zdG9yZSh0aGlzKVxuICAgIH0pXG5cbiAgICB0aGlzLiRjb250YWluZXIub24oJ2NsaWNrJywgJy5fX3hlX2J0bl9jbG9zZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHRoYXQuY2xvc2UodGhpcylcbiAgICB9KVxuXG4gICAgdGhpcy4kY29udGFpbmVyLm9uKCdjbGljaycsICcuX194ZV9idG5fZWRpdCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KClcbiAgICAgIHRoYXQuY2xvc2VBbGwoKVxuICAgICAgdGhhdC5lZGl0KHRoaXMpXG4gICAgfSlcblxuICAgIHRoaXMuJGNvbnRhaW5lci5vbignY2xpY2snLCAnLl9feGVfYnRuX2RlbGV0ZScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KClcbiAgICAgIHRoYXQuZGVzdHJveSh0aGlzKVxuICAgICAgdGhhdC5jbG9zZUFsbCgpXG4gICAgfSlcblxuICAgIHRoaXMuJGNvbnRhaW5lci5vbignY2hhbmdlJywgJy5fX3hlX3R5cGVfaWQnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyIGZvcm0gPSAkKHRoaXMpLmNsb3Nlc3QoJ2Zvcm0nKVxuXG4gICAgICB2YXIgc2VsZWN0ID0gZm9ybS5maW5kKCdbbmFtZT1cInNraW5JZFwiXScpXG4gICAgICBzZWxlY3QuZmluZCgnb3B0aW9uJykucmVtb3ZlKClcbiAgICAgIHNlbGVjdC5wcm9wKCdkaXNhYmxlZCcsIHRydWUpXG5cbiAgICAgIHRoYXQuZ2V0U2tpbk9wdGlvbihmb3JtKVxuICAgIH0pXG5cbiAgICB0aGlzLiRjb250YWluZXIub24oJ2NoYW5nZScsICcuX194ZV9za2luX2lkJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIHZhciBmb3JtID0gJCh0aGlzKS5jbG9zZXN0KCdmb3JtJylcbiAgICAgIHRoYXQuZ2V0QWRkaXRpb25hbENvbmZpZ3VyZShmb3JtKVxuICAgIH0pXG5cbiAgICB0aGlzLiRjb250YWluZXIub24oJ2NsaWNrJywgJy5fX3hlX2NoZWNrYm94LWNvbmZpZycsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgJHRhcmdldCA9ICQoZS50YXJnZXQpXG4gICAgICB2YXIgZm9ybSA9ICQodGhpcykuY2xvc2VzdCgnZm9ybScpXG4gICAgICBmb3JtLmZpbmQoJ1tuYW1lPVwiJyArICR0YXJnZXQuZGF0YSgnbmFtZScpICsgJ1wiXScpLnZhbCgkdGFyZ2V0LnByb3AoJ2NoZWNrZWQnKSA9PSB0cnVlID8gJ3RydWUnIDogJ2ZhbHNlJylcbiAgICB9KVxuICB9XG5cbiAgLyoqXG4gICAqIGNvbnRhaW5lcuulvCDrpqzthLTtlZzri6QuXG4gICAqIEBwYXJhbSB7alF1ZXJ5fSBmb3JtXG4gICAqIEByZXR1cm4ge2pRdWVyeX1cbiAgICovXG4gIHRoaXMuZ2V0Rm9ybUNvbnRhaW5lciA9IGZ1bmN0aW9uIChmb3JtKSB7XG4gICAgcmV0dXJuIGZvcm0uY2xvc2VzdCgnLl9feGVfZm9ybV9jb250YWluZXInKVxuICB9XG5cbiAgLyoqXG4gICAqIG1vZGFs7J2EIGNsb3Nl7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gdGFyZ2V0XG4gICAqL1xuICB0aGlzLmNsb3NlID0gZnVuY3Rpb24gKHRhcmdldCkge1xuICAgIHZhciBmb3JtID0gJCh0YXJnZXQpLmNsb3Nlc3QoJ2Zvcm0nKVxuXG4gICAgZm9ybS5yZW1vdmUoKVxuXG4gICAgdGhpcy4kY29udGFpbmVyLiRtb2RhbC54ZU1vZGFsKCdoaWRlJylcbiAgfVxuXG4gIC8qKlxuICAgKiBncm91cCDrpqzsiqTtirjrpbwg7JqU7LKt7ZWc64ukLlxuICAgKi9cbiAgdGhpcy5nZXRMaXN0ID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciBwYXJhbXMgPSB7IGdyb3VwOiB0aGlzLmdyb3VwIH1cbiAgICB2YXIgdGhhdCA9IHRoaXNcblxuICAgIHZhciBqcXhociA9IHdpbmRvdy5YRS5hamF4KHtcbiAgICAgIGNvbnRleHQ6IHRoaXMuJGNvbnRhaW5lclswXSxcbiAgICAgIHR5cGU6ICdnZXQnLFxuICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgIGRhdGE6IHBhcmFtcyxcbiAgICAgIHVybDogd2luZG93LlhFLnJvdXRlKCdtYW5hZ2UuZHluYW1pY0ZpZWxkLmluZGV4JylcbiAgICB9KVxuXG4gICAganF4aHIuZG9uZShmdW5jdGlvbiAoZGF0YSwgdGV4dFN0YXR1cywganF4aHIpIHtcbiAgICAgIHRoYXQuJGNvbnRhaW5lci5maW5kKCcjZGYtdGJvZHkgdHInKS5yZW1vdmUoKVxuXG4gICAgICBmb3IgKHZhciBpIGluIGRhdGEubGlzdCkge1xuICAgICAgICB0aGF0LmFkZHJvdyhkYXRhLmxpc3RbaV0pXG4gICAgICB9XG4gICAgfSlcbiAgfVxuXG4gIC8qKlxuICAgKiBmb3Jt7J2EIOuzteyCrO2VmOyXrCDrpqzthLTtlZzri6QuXG4gICAqIEByZXR1cm4ge2pRdWVyeX0gJGZvcm1cbiAgICovXG4gIHRoaXMuZm9ybUNsb25lID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciAkZm9ybSA9IHRoaXMuJGNvbnRhaW5lci4kZm9ybS5jbG9uZSgpLnJlbW92ZUNsYXNzKCdfX3hlX2FkZF9mb3JtJylcbiAgICAkZm9ybS5zaG93KClcbiAgICByZXR1cm4gJGZvcm1cbiAgfVxuXG4gIC8qKlxuICAgKiDrpqzsiqTtirgg7YWM7J2067iU7JeQIHJvd+ulvCDstpTqsIDtlZzri6QuXG4gICAqIEBwYXJhbSB7b2JqZWN0fSBkYXRhXG4gICAqL1xuICB0aGlzLmFkZHJvdyA9IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgdmFyIHJvdyA9IHRoaXMuJGNvbnRhaW5lci5maW5kKCcuX194ZV9yb3cnKS5jbG9uZSgpXG4gICAgcm93LnJlbW92ZUNsYXNzKCdfX3hlX3JvdycpXG5cbiAgICByb3cuYWRkQ2xhc3MoJ19feGVfcm93XycgKyBkYXRhLmlkKVxuICAgIHJvdy5kYXRhKCdpZCcsIGRhdGEuaWQpXG4gICAgcm93LmZpbmQoJ3RkLl9feGVfY29sdW1uX2lkJykuaHRtbChkYXRhLmlkKVxuICAgIHJvdy5maW5kKCd0ZC5fX3hlX2NvbHVtbl9sYWJlbCcpLmh0bWwoZGF0YS5sYWJlbClcbiAgICByb3cuZmluZCgndGQuX194ZV9jb2x1bW5fdHlwZU5hbWUnKS5odG1sKGRhdGEudHlwZU5hbWUpXG4gICAgcm93LmZpbmQoJ3RkLl9feGVfY29sdW1uX3NraW5OYW1lJykuaHRtbChkYXRhLnNraW5OYW1lKVxuICAgIHJvdy5maW5kKCd0ZC5fX3hlX2NvbHVtbl91c2UnKS5odG1sKGRhdGEudXNlID09IHRydWUgPyAnVHJ1ZScgOiAnRmFsc2UnKVxuXG4gICAgaWYgKHRoaXMuJGNvbnRhaW5lci5maW5kKCcuX194ZV90Ym9keScpLmZpbmQoJy5fX3hlX3Jvd18nICsgZGF0YS5pZCkubGVuZ3RoICE9IDApIHtcbiAgICAgIHRoaXMuJGNvbnRhaW5lci5maW5kKCcuX194ZV90Ym9keScpLmZpbmQoJy5fX3hlX3Jvd18nICsgZGF0YS5pZCkucmVwbGFjZVdpdGgocm93LnNob3coKSlcbiAgICB9IGVsc2Uge1xuICAgICAgdGhpcy5yZW1vdmVSb3coZGF0YS5pZClcbiAgICAgIHRoaXMuJGNvbnRhaW5lci5maW5kKCcuX194ZV90Ym9keScpLmFwcGVuZChyb3cuc2hvdygpKVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiByb3frpbwg7IKt7KCc7ZWc64ukLlxuICAgKiBAcGFyYW0ge3N0cmluZ30gaWRcbiAgICovXG4gIHRoaXMucmVtb3ZlUm93ID0gZnVuY3Rpb24gKGlkKSB7XG4gICAgdGhpcy4kY29udGFpbmVyLmZpbmQoJy5fX3hlX3Rib2R5JykuZmluZCgnLl9feGVfcm93XycgKyBpZCkucmVtb3ZlKClcbiAgfVxuXG4gIC8qKlxuICAgKiByb3frpbwg7IiY7KCV7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gb1xuICAgKi9cbiAgdGhpcy5lZGl0ID0gZnVuY3Rpb24gKG8pIHtcbiAgICB2YXIgdHIgPSAkKG8pLmNsb3Nlc3QoJ3RyJylcbiAgICB2YXIgaWQgPSB0ci5kYXRhKCdpZCcpXG4gICAgdmFyIGZvcm0gPSB0aGlzLmZvcm1DbG9uZSgpXG5cbiAgICBmb3JtLmRhdGEoJ2lzRWRpdCcsICcxJylcbiAgICBmb3JtLmF0dHIoJ2FjdGlvbicsIHdpbmRvdy5YRS5yb3V0ZSgnbWFuYWdlLmR5bmFtaWNGaWVsZC51cGRhdGUnKSlcbiAgICB0aGlzLiRjb250YWluZXIuJG1vZGFsLiRib2R5Lmh0bWwoZm9ybSlcbiAgICB0aGlzLiRjb250YWluZXIuJG1vZGFsLnhlTW9kYWwoJ3Nob3cnKVxuXG4gICAgdmFyIHBhcmFtcyA9IHsgZ3JvdXA6IHRoaXMuZ3JvdXAsIGlkOiBpZCB9XG4gICAgdmFyIHRoYXQgPSB0aGlzXG5cbiAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICBjb250ZXh0OiB0aGlzLiRjb250YWluZXIuJG1vZGFsLiRib2R5WzBdLFxuICAgICAgdHlwZTogJ2dldCcsXG4gICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgZGF0YTogcGFyYW1zLFxuICAgICAgdXJsOiB3aW5kb3cuWEUucm91dGUoJ21hbmFnZS5keW5hbWljRmllbGQuZ2V0RWRpdEluZm8nKSxcbiAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICBmb3JtLmZpbmQoJ1tuYW1lPVwiaWRcIl0nKS52YWwocmVzcG9uc2UuY29uZmlnLmlkKS5wcm9wKCdyZWFkb25seScsIHRydWUpXG4gICAgICAgIGZvcm0uZmluZCgnW25hbWU9XCJ0eXBlSWRcIl0gb3B0aW9uJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgdmFyICRvcHRpb24gPSAkKHRoaXMpXG4gICAgICAgICAgaWYgKCRvcHRpb24udmFsKCkgIT0gcmVzcG9uc2UuY29uZmlnLnR5cGVJZCkge1xuICAgICAgICAgICAgJG9wdGlvbi5yZW1vdmUoKVxuICAgICAgICAgIH1cbiAgICAgICAgfSlcblxuICAgICAgICB2YXIgJGxhbmdCb3ggPSBmb3JtLmZpbmQoJy5keW5hbWljLWxhbmctZWRpdG9yLWJveCcpXG4gICAgICAgICRsYW5nQm94LmFkZENsYXNzKCdsYW5nLWVkaXRvci1ib3gnKVxuXG4gICAgICAgICRsYW5nQm94LmVhY2goZnVuY3Rpb24gKGlkeCwgZWxlbWVudCkge1xuICAgICAgICAgICQoZWxlbWVudCkuZGF0YSgnbGFuZy1rZXknLCByZXNwb25zZS5jb25maWdbJChlbGVtZW50KS5kYXRhKCduYW1lJyldKVxuICAgICAgICAgIHdpbmRvdy5sYW5nRWRpdG9yQm94UmVuZGVyKCQoZWxlbWVudCkpIC8vIEZJWE1FXG4gICAgICAgIH0pXG5cbiAgICAgICAgLy8gQEZJWE1FXG4gICAgICAgIGZvcm0uZmluZCgnW25hbWU9XCJ1c2VcIl0nKS52YWwodGhhdC5jaGVja0JveChyZXNwb25zZS5jb25maWcudXNlKSA/ICd0cnVlJyA6ICdmYWxzZScpXG4gICAgICAgIGZvcm0uZmluZCgnW25hbWU9XCJyZXF1aXJlZFwiXScpLnZhbCh0aGF0LmNoZWNrQm94KHJlc3BvbnNlLmNvbmZpZy5yZXF1aXJlZCkgPyAndHJ1ZScgOiAnZmFsc2UnKVxuICAgICAgICBmb3JtLmZpbmQoJ1tuYW1lPVwic29ydGFibGVcIl0nKS52YWwodGhhdC5jaGVja0JveChyZXNwb25zZS5jb25maWcuc29ydGFibGUpID8gJ3RydWUnIDogJ2ZhbHNlJylcbiAgICAgICAgZm9ybS5maW5kKCdbbmFtZT1cInNlYXJjaGFibGVcIl0nKS52YWwodGhhdC5jaGVja0JveChyZXNwb25zZS5jb25maWcuc2VhcmNoYWJsZSkgPyAndHJ1ZScgOiAnZmFsc2UnKVxuXG4gICAgICAgIGZvcm0uZmluZCgnW2RhdGEtbmFtZT1cInVzZVwiXScpLnByb3AoJ2NoZWNrZWQnLCB0aGF0LmNoZWNrQm94KHJlc3BvbnNlLmNvbmZpZy51c2UpKVxuICAgICAgICBmb3JtLmZpbmQoJ1tkYXRhLW5hbWU9XCJyZXF1aXJlZFwiXScpLnByb3AoJ2NoZWNrZWQnLCB0aGF0LmNoZWNrQm94KHJlc3BvbnNlLmNvbmZpZy5yZXF1aXJlZCkpXG4gICAgICAgIGZvcm0uZmluZCgnW2RhdGEtbmFtZT1cInNlYXJjaGFibGVcIl0nKS5wcm9wKCdjaGVja2VkJywgdGhhdC5jaGVja0JveChyZXNwb25zZS5jb25maWcuc2VhcmNoYWJsZSkpXG5cbiAgICAgICAgdGhhdC5nZXRTa2luT3B0aW9uKGZvcm0pXG4gICAgICB9XG4gICAgfSlcbiAgfVxuXG4gIC8qKlxuICAgKiDtjIzrnbzrr7jthLAgYm9vbGVhbuqwkuydtCB0cnVl7J28IOqyveyasCB0cnVlLCBmYWxzZeydvCDqsr3smrAgZmFsc2Xrpbwg66as7YS07ZWc64ukXG4gICAqIEBwYXJhbSB7c3RyaW5nfGJvb2xlYW59IGRhdGFcbiAgICovXG4gIHRoaXMuY2hlY2tCb3ggPSBmdW5jdGlvbiAoZGF0YSkge1xuICAgIC8vIEBGSVhNRVxuICAgIHZhciBjaGVja2VkID0gZmFsc2VcbiAgICBpZiAoZGF0YSA9PSB1bmRlZmluZWQpIHtcbiAgICAgIGNoZWNrZWQgPSBmYWxzZVxuICAgIH0gZWxzZSBpZiAoZGF0YSA9PSAnZmFsc2UnKSB7XG4gICAgICBjaGVja2VkID0gZmFsc2VcbiAgICB9IGVsc2UgaWYgKGRhdGEgPT0gJ3RydWUnKSB7XG4gICAgICBjaGVja2VkID0gdHJ1ZVxuICAgIH0gZWxzZSBpZiAoZGF0YSA9PSB0cnVlKSB7XG4gICAgICBjaGVja2VkID0gdHJ1ZVxuICAgIH1cblxuICAgIHJldHVybiBjaGVja2VkXG4gIH1cblxuICAvKipcbiAgICogcm93IOyCreygnCDsmpTssq3snYQg7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gdGFyZ2V0XG4gICAqL1xuICB0aGlzLmRlc3Ryb3kgPSBmdW5jdGlvbiAodGFyZ2V0KSB7XG4gICAgaWYgKGNvbmZpcm0oJ+ydtOuPmeyekeydgCDrkJjrj4zrprQg7IiYIOyXhuyKteuLiOuLpC4g6rOE7IaN7ZWY7Iuc6rKg7Iq164uI6rmMPycpID09PSBmYWxzZSkgeyAvLyBARklYTUVcbiAgICAgIHJldHVyblxuICAgIH1cblxuICAgIHZhciB0ciA9ICQodGFyZ2V0KS5jbG9zZXN0KCd0cicpXG4gICAgdmFyIGlkID0gdHIuZGF0YSgnaWQnKVxuICAgIHZhciBwYXJhbXMgPSB7IGdyb3VwOiB0aGlzLmdyb3VwLCBkYXRhYmFzZU5hbWU6IHRoaXMuZGF0YWJhc2VOYW1lLCBpZDogaWQgfVxuICAgIHZhciB0aGF0ID0gdGhpc1xuXG4gICAgd2luZG93LlhFLmFqYXgoe1xuICAgICAgY29udGV4dDogdGhpcy4kY29udGFpbmVyWzBdLFxuICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgIGRhdGE6IHBhcmFtcyxcbiAgICAgIHVybDogd2luZG93LlhFLnJvdXRlKCdtYW5hZ2UuZHluYW1pY0ZpZWxkLmRlc3Ryb3knKSxcbiAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICB2YXIgaWQgPSByZXNwb25zZS5pZFxuXG4gICAgICAgIGlmIChyZXNwb25zZS5pZCA9PSByZXNwb25zZS51cGRhdGVpZCkge1xuICAgICAgICAgIHRoYXQub3BlblN0ZXAoJ2Nsb3NlJylcbiAgICAgICAgfVxuXG4gICAgICAgIHRoYXQucmVtb3ZlUm93KGlkKVxuICAgICAgfVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICog7Iqk7YKoIOyYteyFmOydhCDsmpTssq3tlZzri6QuXG4gICAqIEBwYXJhbSB7alF1ZXJ5fSBmb3JtXG4gICAqL1xuICB0aGlzLmdldFNraW5PcHRpb24gPSBmdW5jdGlvbiAoZm9ybSkge1xuICAgIHZhciBwYXJhbXMgPSBmb3JtLnNlcmlhbGl6ZSgpXG4gICAgdmFyIHRoYXQgPSB0aGlzXG5cbiAgICBmb3JtLmZpbmQoJy5fX3hlX2FkZGl0aW9uYWxfY29uZmlndXJlJykuaHRtbCgnJylcbiAgICBpZiAoZm9ybS5maW5kKCdbbmFtZT1cInR5cGVJZFwiXScpLnZhbCgpID09ICcnKSB7XG4gICAgICByZXR1cm5cbiAgICB9XG5cbiAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICBjb250ZXh0OiB0aGlzLiRjb250YWluZXIuJG1vZGFsLiRib2R5WzBdLFxuICAgICAgdHlwZTogJ2dldCcsXG4gICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgZGF0YTogcGFyYW1zLFxuICAgICAgdXJsOiB3aW5kb3cuWEUucm91dGUoJ21hbmFnZS5keW5hbWljRmllbGQuZ2V0U2tpbk9wdGlvbicpLFxuICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgIHRoYXQuc2tpbk9wdGlvbnMoZm9ybSwgcmVzcG9uc2Uuc2tpbnMsIHJlc3BvbnNlLnNraW5JZClcbiAgICAgIH1cbiAgICB9KVxuICB9XG5cbiAgLyoqXG4gICAqIOyKpO2CqOyYteyFmCBzZWxlY3Rib3jrpbwg6rWs7ISx7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gZm9ybVxuICAgKiBAcGFyYW0ge29iamVjdH0gc2tpbnNcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbGVjdGVkXG4gICAqL1xuICB0aGlzLnNraW5PcHRpb25zID0gZnVuY3Rpb24gKGZvcm0sIHNraW5zLCBzZWxlY3RlZCkge1xuICAgIHZhciBzZWxlY3QgPSBmb3JtLmZpbmQoJ1tuYW1lPVwic2tpbklkXCJdJylcbiAgICBzZWxlY3QuZmluZCgnb3B0aW9uJykucmVtb3ZlKClcblxuICAgIGZvciAodmFyIGtleSBpbiBza2lucykge1xuICAgICAgdmFyIG9wdGlvbiA9ICQoJzxvcHRpb24+JykuYXR0cigndmFsdWUnLCBrZXkpLnRleHQoc2tpbnNba2V5XSlcbiAgICAgIHNlbGVjdC5hcHBlbmQob3B0aW9uKVxuICAgIH1cblxuICAgIGlmIChzZWxlY3RlZCAhPSB1bmRlZmluZWQgJiYgc2VsZWN0ZWQgIT0gJycpIHtcbiAgICAgIHNlbGVjdC52YWwoc2VsZWN0ZWQpXG4gICAgfVxuXG4gICAgc2VsZWN0LnByb3AoJ2Rpc2FibGVkJywgZmFsc2UpXG5cbiAgICB0aGlzLmdldEFkZGl0aW9uYWxDb25maWd1cmUoZm9ybSlcbiAgfVxuXG4gIC8qKlxuICAgKiDtlYTrk5zrp4jri6Qg7LaU6rCA7ISk7KCV7J2EIOuhnOuTnO2VnOuLpC5cbiAgICogQHBhcmFtIHtqUXVlcnl9ICRmb3JtXG4gICAqL1xuICB0aGlzLmdldEFkZGl0aW9uYWxDb25maWd1cmUgPSBmdW5jdGlvbiAoJGZvcm0pIHtcbiAgICBjb25zdCBwYXJhbXMgPSB7fVxuICAgICRmb3JtLnNlcmlhbGl6ZUFycmF5KCkuZm9yRWFjaCgoaXRlbSkgPT4ge1xuICAgICAgcGFyYW1zW2l0ZW0ubmFtZV0gPSBpdGVtLnZhbHVlXG4gICAgfSlcblxuICAgIHdpbmRvdy5YRS5nZXQoJ21hbmFnZS5keW5hbWljRmllbGQuZ2V0QWRkaXRpb25hbENvbmZpZ3VyZScsIHBhcmFtcywgeyBoZWFkZXJzOiB7ICdYLVhFLUFzeW5jLUV4cG9zZSc6IHRydWUgfSB9KVxuICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xuICAgICAgICAkZm9ybS5maW5kKCcuX194ZV9hZGRpdGlvbmFsX2NvbmZpZ3VyZScpLmh0bWwocmVzcG9uc2UuZGF0YS5yZXN1bHQpXG4gICAgICB9KVxuICB9XG5cbiAgLyoqXG4gICAqIO2Zleyepe2VhOuTnOulvCDrk7HroZ3tlZzri6QuXG4gICAqIEBwYXJhbSB7alF1ZXJ5fSB0YXJnZXRcbiAgICovXG4gIHRoaXMuc3RvcmUgPSBmdW5jdGlvbiAodGFyZ2V0KSB7XG4gICAgdmFyICRmb3JtID0gdGhpcy4kY29udGFpbmVyLiRtb2RhbC4kYm9keS5maW5kKCdmb3JtJylcbiAgICB2YXIgdGhhdCA9IHRoaXNcblxuICAgIHRyeSB7XG4gICAgICB0aGlzLnZhbGlkYXRlQ2hlY2soJGZvcm0pXG4gICAgfSBjYXRjaCAoZSkge1xuICAgICAgcmV0dXJuXG4gICAgfVxuXG4gICAgdmFyIHBhcmFtcyA9ICRmb3JtLnNlcmlhbGl6ZSgpXG5cbiAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICBjb250ZXh0OiB0aGlzLiRjb250YWluZXIuJG1vZGFsLiRib2R5WzBdLFxuICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgIGRhdGE6IHBhcmFtcyxcbiAgICAgIHVybDogJGZvcm0uYXR0cignYWN0aW9uJyksXG4gICAgICBzdWNjZXNzOiBmdW5jdGlvbiAocmVzcG9uc2UpIHtcbiAgICAgICAgdGhhdC5hZGRyb3cocmVzcG9uc2UpXG4gICAgICAgIHRoYXQuY2xvc2UodGFyZ2V0KVxuICAgICAgfVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICog7Y+8IOyalOyGjOyXkCB2YWxpZGF0aW9uIHJ1bGXsnYQg65Ox66Gd7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gJGZvcm1cbiAgICogQHBhcmFtIHtvYmplY3R9IGFkZFJ1bGVzXG4gICAqL1xuICB0aGlzLnNldFZhbGlkYXRlUnVsZSA9IGZ1bmN0aW9uICgkZm9ybSwgYWRkUnVsZXMpIHtcbiAgICB2YXIgcnVsZU5hbWUgPSB0aGlzLnZhbGlkYXRvci5nZXRSdWxlTmFtZSgkZm9ybSlcbiAgICBpZiAoYWRkUnVsZXMgIT0gdW5kZWZpbmVkICYmIHJ1bGVOYW1lICE9IHVuZGVmaW5lZCkge1xuICAgICAgdGhpcy52YWxpZGF0b3Iuc2V0UnVsZXMocnVsZU5hbWUsIGFkZFJ1bGVzKVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDtj7wg7JqU7IaM7JeQIHZhbGlkYXRpb27snYQg7LK07YGs7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gJGZvcm1cbiAgICovXG4gIHRoaXMudmFsaWRhdGVDaGVjayA9IGZ1bmN0aW9uICgkZm9ybSkge1xuICAgIHRoaXMudmFsaWRhdG9yLmNoZWNrKCRmb3JtKVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IER5bmFtaWNGaWVsZFxuXG4vLyBARklYTUVcbnZhciBpbnN0YW5jZSA9IG5ldyBEeW5hbWljRmllbGQoKVxuaW5zdGFuY2UuaW5pdCh3aW5kb3cuZHluYW1pY0ZpZWxkRGF0YS5ncm91cCwgd2luZG93LmR5bmFtaWNGaWVsZERhdGEuZGF0YWJhc2VOYW1lKVxuaW5zdGFuY2UuZ2V0TGlzdCgpXG4iLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMzE3KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoNCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDE3KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMCk7IiwibW9kdWxlLmV4cG9ydHMgPSBfeGVfZGxsX2NvbW1vbjsiXSwic291cmNlUm9vdCI6IiJ9