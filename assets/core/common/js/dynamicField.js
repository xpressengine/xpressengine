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
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime-corejs3/core-js-stable/instance/find */ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js");
/* harmony import */ var _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/src/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var xe_validator__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! xe/validator */ "./core/validator/index.js");




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

    if (!group || !databaseName) {
      return;
    }

    this.group = group;
    this.databaseName = databaseName;
    this.containerName = '__xe_container_DF_setting_' + group;
    this.$container = jquery__WEBPACK_IMPORTED_MODULE_3___default()('#' + this.containerName);
    this.$container.$form = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context = this.$container).call(_context, '.__xe_add_form') || jquery__WEBPACK_IMPORTED_MODULE_3___default()(this.$container.data('form'));
    this.$container.$modal = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context2 = this.$container).call(_context2, '.__xe_df_modal');
    this.$container.$modal.$body = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context3 = this.$container.$modal).call(_context3, '.modal-body');
    this.validator = new xe_validator__WEBPACK_IMPORTED_MODULE_4__["default"]();
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

      var $langBox = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context4 = that.$container.$modal).call(_context4, '.dynamic-lang-editor-box');

      $langBox.addClass('lang-editor-box');
      $langBox.each(function (idx, element) {
        window.langEditorBoxRender(jquery__WEBPACK_IMPORTED_MODULE_3___default()(element)); // FIXME
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
      var form = jquery__WEBPACK_IMPORTED_MODULE_3___default()(this).closest('form');

      var select = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="skinId"]');

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(select).call(select, 'option').remove();

      select.prop('disabled', true);
      that.getSkinOption(form);
    });
    this.$container.on('change', '.__xe_skin_id', function (e) {
      var form = jquery__WEBPACK_IMPORTED_MODULE_3___default()(this).closest('form');
      that.getAdditionalConfigure(form);
    });
    this.$container.on('click', '.__xe_checkbox-config', function (e) {
      var $target = jquery__WEBPACK_IMPORTED_MODULE_3___default()(e.target);
      var form = jquery__WEBPACK_IMPORTED_MODULE_3___default()(this).closest('form');

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="' + $target.data('name') + '"]').val($target.prop('checked') == true ? 'true' : 'false');
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
    var form = jquery__WEBPACK_IMPORTED_MODULE_3___default()(target).closest('form');
    form.remove();
    this.$container.$modal.xeModal('hide');
  };
  /**
   * group 리스트를 요청한다.
   */


  this.getList = function () {
    if (!this.group) {
      return;
    }

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

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context5 = that.$container).call(_context5, '#df-tbody tr').remove();

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

    var row = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context6 = this.$container).call(_context6, '.__xe_row').clone();

    row.removeClass('__xe_row');
    row.addClass('__xe_row_' + data.id);
    row.data('id', data.id);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(row).call(row, 'td.__xe_column_id').html(data.id);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(row).call(row, 'td.__xe_column_label').html(data.label);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(row).call(row, 'td.__xe_column_typeName').html(data.typeName);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(row).call(row, 'td.__xe_column_skinName').html(data.skinName);

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(row).call(row, 'td.__xe_column_use').html(data.use == true ? 'True' : 'False');

    if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context7 = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context8 = this.$container).call(_context8, '.__xe_tbody')).call(_context7, '.__xe_row_' + data.id).length != 0) {
      var _context9, _context10;

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context9 = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context10 = this.$container).call(_context10, '.__xe_tbody')).call(_context9, '.__xe_row_' + data.id).replaceWith(row.show());
    } else {
      var _context11;

      this.removeRow(data.id);

      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context11 = this.$container).call(_context11, '.__xe_tbody').append(row.show());
    }
  };
  /**
   * row를 삭제한다.
   * @param {string} id
   */


  this.removeRow = function (id) {
    var _context12, _context13;

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context12 = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context13 = this.$container).call(_context13, '.__xe_tbody')).call(_context12, '.__xe_row_' + id).remove();
  };
  /**
   * row를 수정한다.
   * @param {jQuery} o
   */


  this.edit = function (o) {
    var row = jquery__WEBPACK_IMPORTED_MODULE_3___default()(o).closest('tr, .__dynamic-field-row');
    var id = row.data('id');
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
        console.debug('form', form);

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="id"]').val(response.config.id).prop('readonly', true);

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="typeId"] option').each(function () {
          var $option = jquery__WEBPACK_IMPORTED_MODULE_3___default()(this);

          if ($option.val() != response.config.typeId) {
            $option.remove();
          }
        });

        var $langBox = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '.dynamic-lang-editor-box');

        $langBox.addClass('lang-editor-box');
        $langBox.each(function (idx, element) {
          jquery__WEBPACK_IMPORTED_MODULE_3___default()(element).data('lang-key', response.config[jquery__WEBPACK_IMPORTED_MODULE_3___default()(element).data('name')]);
          window.langEditorBoxRender(jquery__WEBPACK_IMPORTED_MODULE_3___default()(element)); // FIXME
        }); // @FIXME

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="use"]').val(that.checkBox(response.config.use) ? 'true' : 'false');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="required"]').val(that.checkBox(response.config.required) ? 'true' : 'false');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="sortable"]').val(that.checkBox(response.config.sortable) ? 'true' : 'false');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="searchable"]').val(that.checkBox(response.config.searchable) ? 'true' : 'false');

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[data-name="use"]').prop('checked', that.checkBox(response.config.use));

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[data-name="required"]').prop('checked', that.checkBox(response.config.required));

        _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[data-name="searchable"]').prop('checked', that.checkBox(response.config.searchable));

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

    var tr = jquery__WEBPACK_IMPORTED_MODULE_3___default()(target).closest('tr');
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

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '.__xe_additional_configure').html('');

    if (_babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="typeId"]').val() == '') {
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
    var select = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(form).call(form, '[name="skinId"]');

    _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(select).call(select, 'option').remove();

    for (var key in skins) {
      var option = jquery__WEBPACK_IMPORTED_MODULE_3___default()('<option>').attr('value', key).text(skins[key]);
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
    var params = {};
    $form.serializeArray().forEach(function (item) {
      params[item.name] = item.value;
    });
    window.XE.get('manage.dynamicField.getAdditionalConfigure', params, {
      headers: {
        'X-XE-Async-Expose': true
      }
    }).then(function (response) {
      _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()($form).call($form, '.__xe_additional_configure').html(response.data.result);
    });
  };
  /**
   * 확장필드를 등록한다.
   * @param {jQuery} target
   */


  this.store = function (target) {
    var _context14;

    var $form = _babel_runtime_corejs3_core_js_stable_instance_find__WEBPACK_IMPORTED_MODULE_2___default()(_context14 = this.$container.$modal.$body).call(_context14, 'form');

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

if (typeof window.dynamicFieldData !== 'undefined' && typeof window.dynamicFieldData.group !== 'undefined' && typeof window.dynamicFieldData.databaseName !== 'undefined') {
  instance.init(window.dynamicFieldData.group, window.dynamicFieldData.databaseName);
  instance.getList();
}

/***/ }),

/***/ "./core/validator/index.js":
/*!*****************************************************************************!*\
  !*** delegated ./core/validator/index.js from dll-reference _xe_dll_common ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(441);

/***/ }),

/***/ "./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js":
/*!*************************************************************************************************************************!*\
  !*** delegated ./node_modules/@babel/runtime-corejs3/core-js-stable/instance/find.js from dll-reference _xe_dll_common ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(5);

/***/ }),

/***/ "./node_modules/core-js/modules/es.function.name.js":
/*!******************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/es.function.name.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(68);

/***/ }),

/***/ "./node_modules/core-js/modules/web.dom-collections.for-each.js":
/*!******************************************************************************************************************!*\
  !*** delegated ./node_modules/core-js/modules/web.dom-collections.for-each.js from dll-reference _xe_dll_common ***!
  \******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(/*! dll-reference _xe_dll_common */ "dll-reference _xe_dll_common"))(58);

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vY29yZS9jb21tb24vanMvZHluYW1pY0ZpZWxkLmpzIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9jb3JlL3ZhbGlkYXRvci9pbmRleC5qcyBmcm9tIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24iLCJ3ZWJwYWNrOi8vL2RlbGVnYXRlZCAuL25vZGVfbW9kdWxlcy9AYmFiZWwvcnVudGltZS1jb3JlanMzL2NvcmUtanMtc3RhYmxlL2luc3RhbmNlL2ZpbmQuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLmZ1bmN0aW9uLm5hbWUuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL3dlYi5kb20tY29sbGVjdGlvbnMuZm9yLWVhY2guanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9kZWxlZ2F0ZWQgLi9ub2RlX21vZHVsZXMvanF1ZXJ5L3NyYy9qcXVlcnkuanMgZnJvbSBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uIiwid2VicGFjazovLy9leHRlcm5hbCBcIl94ZV9kbGxfY29tbW9uXCIiXSwibmFtZXMiOlsiRHluYW1pY0ZpZWxkIiwiZ3JvdXAiLCJkYXRhYmFzZU5hbWUiLCJjb250YWluZXJOYW1lIiwiJGNvbnRhaW5lciIsImluaXQiLCIkIiwiJGZvcm0iLCJkYXRhIiwiJG1vZGFsIiwiJGJvZHkiLCJ2YWxpZGF0b3IiLCJWYWxpZGF0b3IiLCJhdHRhY2hFdmVudCIsImNsb3NlQWxsIiwieGVNb2RhbCIsInRoYXQiLCJvbiIsImh0bWwiLCJmb3JtQ2xvbmUiLCIkbGFuZ0JveCIsImFkZENsYXNzIiwiZWFjaCIsImlkeCIsImVsZW1lbnQiLCJ3aW5kb3ciLCJsYW5nRWRpdG9yQm94UmVuZGVyIiwic3RvcmUiLCJjbG9zZSIsImUiLCJwcmV2ZW50RGVmYXVsdCIsImVkaXQiLCJkZXN0cm95IiwiZm9ybSIsImNsb3Nlc3QiLCJzZWxlY3QiLCJyZW1vdmUiLCJwcm9wIiwiZ2V0U2tpbk9wdGlvbiIsImdldEFkZGl0aW9uYWxDb25maWd1cmUiLCIkdGFyZ2V0IiwidGFyZ2V0IiwidmFsIiwiZ2V0Rm9ybUNvbnRhaW5lciIsImdldExpc3QiLCJwYXJhbXMiLCJqcXhociIsIlhFIiwiYWpheCIsImNvbnRleHQiLCJ0eXBlIiwiZGF0YVR5cGUiLCJ1cmwiLCJyb3V0ZSIsImRvbmUiLCJ0ZXh0U3RhdHVzIiwiaSIsImxpc3QiLCJhZGRyb3ciLCJjbG9uZSIsInJlbW92ZUNsYXNzIiwic2hvdyIsInJvdyIsImlkIiwibGFiZWwiLCJ0eXBlTmFtZSIsInNraW5OYW1lIiwidXNlIiwibGVuZ3RoIiwicmVwbGFjZVdpdGgiLCJyZW1vdmVSb3ciLCJhcHBlbmQiLCJvIiwiYXR0ciIsInN1Y2Nlc3MiLCJyZXNwb25zZSIsImNvbnNvbGUiLCJkZWJ1ZyIsImNvbmZpZyIsIiRvcHRpb24iLCJ0eXBlSWQiLCJjaGVja0JveCIsInJlcXVpcmVkIiwic29ydGFibGUiLCJzZWFyY2hhYmxlIiwiY2hlY2tlZCIsInVuZGVmaW5lZCIsImNvbmZpcm0iLCJ0ciIsInVwZGF0ZWlkIiwib3BlblN0ZXAiLCJzZXJpYWxpemUiLCJza2luT3B0aW9ucyIsInNraW5zIiwic2tpbklkIiwic2VsZWN0ZWQiLCJrZXkiLCJvcHRpb24iLCJ0ZXh0Iiwic2VyaWFsaXplQXJyYXkiLCJmb3JFYWNoIiwiaXRlbSIsIm5hbWUiLCJ2YWx1ZSIsImdldCIsImhlYWRlcnMiLCJ0aGVuIiwicmVzdWx0IiwidmFsaWRhdGVDaGVjayIsInNldFZhbGlkYXRlUnVsZSIsImFkZFJ1bGVzIiwicnVsZU5hbWUiLCJnZXRSdWxlTmFtZSIsInNldFJ1bGVz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QWpCLEVBQTJCO0FBQ2hELFFBQUlDLFFBQVEsR0FBRyxLQUFLcEcsU0FBTCxDQUFlcUcsV0FBZixDQUEyQnpHLEtBQTNCLENBQWY7O0FBQ0EsUUFBSXVHLFFBQVEsSUFBSXhCLFNBQVosSUFBeUJ5QixRQUFRLElBQUl6QixTQUF6QyxFQUFvRDtBQUNsRCxXQUFLM0UsU0FBTCxDQUFlc0csUUFBZixDQUF3QkYsUUFBeEIsRUFBa0NELFFBQWxDO0FBQ0Q7QUFDRixHQUxEO0FBT0E7QUFDRjtBQUNBO0FBQ0E7OztBQUNFLE9BQUtGLGFBQUwsR0FBcUIsVUFBVXJHLEtBQVYsRUFBaUI7QUFDcEMsU0FBS0ksU0FBTCxDQUFldUcsS0FBZixDQUFxQjNHLEtBQXJCO0FBQ0QsR0FGRDtBQUdELENBblpEOztBQXFaZVAsMkVBQWYsRSxDQUVBOztBQUNBLElBQUltSCxRQUFRLEdBQUcsSUFBSW5ILFlBQUosRUFBZjs7QUFDQSxJQUFJLE9BQU95QixNQUFNLENBQUMyRixnQkFBZCxLQUFtQyxXQUFuQyxJQUFrRCxPQUFPM0YsTUFBTSxDQUFDMkYsZ0JBQVAsQ0FBd0JuSCxLQUEvQixLQUF5QyxXQUEzRixJQUEwRyxPQUFPd0IsTUFBTSxDQUFDMkYsZ0JBQVAsQ0FBd0JsSCxZQUEvQixLQUFnRCxXQUE5SixFQUEySztBQUN6S2lILFVBQVEsQ0FBQzlHLElBQVQsQ0FBY29CLE1BQU0sQ0FBQzJGLGdCQUFQLENBQXdCbkgsS0FBdEMsRUFBNkN3QixNQUFNLENBQUMyRixnQkFBUCxDQUF3QmxILFlBQXJFO0FBQ0FpSCxVQUFRLENBQUN2RSxPQUFUO0FBQ0QsQzs7Ozs7Ozs7Ozs7QUNsYUQsZ0g7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsK0c7Ozs7Ozs7Ozs7O0FDQUEsOEc7Ozs7Ozs7Ozs7O0FDQUEsZ0MiLCJmaWxlIjoiYXNzZXRzL2NvcmUvY29tbW9uL2pzL2R5bmFtaWNGaWVsZC5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vY29yZS9jb21tb24vanMvZHluYW1pY0ZpZWxkLmpzXCIpO1xuIiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5J1xuaW1wb3J0IFZhbGlkYXRvciBmcm9tICd4ZS92YWxpZGF0b3InIC8vIEBGSVhNRSBodHRwczovL2dpdGh1Yi5jb20veHByZXNzZW5naW5lL3hwcmVzc2VuZ2luZS9pc3N1ZXMvNzY1XG5cbi8qKlxuICogQGNsYXNzXG4gKi9cbnZhciBEeW5hbWljRmllbGQgPSBmdW5jdGlvbiAoKSB7XG4gIHRoaXMuZ3JvdXAgPSAnJ1xuICB0aGlzLmRhdGFiYXNlTmFtZSA9ICcnXG4gIHRoaXMuY29udGFpbmVyTmFtZSA9ICcnXG4gIHRoaXMuJGNvbnRhaW5lciA9ICcnXG5cbiAgLyoqXG4gICAqIER5bmFtaWNGaWVsZOulvCDstIjquLDtmZQg7ZWc64ukLlxuICAgKiBAcGFyYW0ge3N0cmluZ30gZ3JvdXBcbiAgICogQHBhcmFtIHtzdHJpbmd9IGRhdGFiYXNlTmFtZVxuICAgKi9cbiAgdGhpcy5pbml0ID0gZnVuY3Rpb24gKGdyb3VwLCBkYXRhYmFzZU5hbWUpIHtcbiAgICBpZiAoIWdyb3VwIHx8ICFkYXRhYmFzZU5hbWUpIHtcbiAgICAgIHJldHVyblxuICAgIH1cblxuICAgIHRoaXMuZ3JvdXAgPSBncm91cFxuICAgIHRoaXMuZGF0YWJhc2VOYW1lID0gZGF0YWJhc2VOYW1lXG4gICAgdGhpcy5jb250YWluZXJOYW1lID0gJ19feGVfY29udGFpbmVyX0RGX3NldHRpbmdfJyArIGdyb3VwXG4gICAgdGhpcy4kY29udGFpbmVyID0gJCgnIycgKyB0aGlzLmNvbnRhaW5lck5hbWUpXG4gICAgdGhpcy4kY29udGFpbmVyLiRmb3JtID0gdGhpcy4kY29udGFpbmVyLmZpbmQoJy5fX3hlX2FkZF9mb3JtJykgfHwgJCh0aGlzLiRjb250YWluZXIuZGF0YSgnZm9ybScpKVxuICAgIHRoaXMuJGNvbnRhaW5lci4kbW9kYWwgPSB0aGlzLiRjb250YWluZXIuZmluZCgnLl9feGVfZGZfbW9kYWwnKVxuICAgIHRoaXMuJGNvbnRhaW5lci4kbW9kYWwuJGJvZHkgPSB0aGlzLiRjb250YWluZXIuJG1vZGFsLmZpbmQoJy5tb2RhbC1ib2R5JylcbiAgICB0aGlzLnZhbGlkYXRvciA9IG5ldyBWYWxpZGF0b3IoKVxuXG4gICAgdGhpcy5hdHRhY2hFdmVudCgpXG5cbiAgICB0aGlzLmNsb3NlQWxsID0gZnVuY3Rpb24gKCkge1xuICAgICAgdGhpcy4kY29udGFpbmVyLiRtb2RhbC54ZU1vZGFsKCdoaWRlJylcbiAgICB9XG4gIH1cblxuICAvKipcbiAgICog7J2067Kk7Yq4IO2VuOuTpOufrOulvCDrk7HroZ3tlZzri6QuXG4gICAqL1xuICB0aGlzLmF0dGFjaEV2ZW50ID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciB0aGF0ID0gdGhpc1xuXG4gICAgdGhpcy4kY29udGFpbmVyLm9uKCdjbGljaycsICcuX194ZV9idG5fYWRkJywgZnVuY3Rpb24gKCkge1xuICAgICAgdGhhdC4kY29udGFpbmVyLiRtb2RhbC4kYm9keS5odG1sKHRoYXQuZm9ybUNsb25lKCkpXG4gICAgICB0aGF0LiRjb250YWluZXIuJG1vZGFsLnhlTW9kYWwoJ3Nob3cnKVxuXG4gICAgICB2YXIgJGxhbmdCb3ggPSB0aGF0LiRjb250YWluZXIuJG1vZGFsLmZpbmQoJy5keW5hbWljLWxhbmctZWRpdG9yLWJveCcpXG4gICAgICAkbGFuZ0JveC5hZGRDbGFzcygnbGFuZy1lZGl0b3ItYm94JylcblxuICAgICAgJGxhbmdCb3guZWFjaChmdW5jdGlvbiAoaWR4LCBlbGVtZW50KSB7XG4gICAgICAgIHdpbmRvdy5sYW5nRWRpdG9yQm94UmVuZGVyKCQoZWxlbWVudCkpIC8vIEZJWE1FXG4gICAgICB9KVxuICAgIH0pXG5cbiAgICB0aGlzLiRjb250YWluZXIub24oJ2NsaWNrJywgJy5fX3hlX2J0bl9zdWJtaXQnLCBmdW5jdGlvbiAoKSB7XG4gICAgICB0aGF0LnN0b3JlKHRoaXMpXG4gICAgfSlcblxuICAgIHRoaXMuJGNvbnRhaW5lci5vbignY2xpY2snLCAnLl9feGVfYnRuX2Nsb3NlJywgZnVuY3Rpb24gKCkge1xuICAgICAgdGhhdC5jbG9zZSh0aGlzKVxuICAgIH0pXG5cbiAgICB0aGlzLiRjb250YWluZXIub24oJ2NsaWNrJywgJy5fX3hlX2J0bl9lZGl0JywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuICAgICAgdGhhdC5jbG9zZUFsbCgpXG4gICAgICB0aGF0LmVkaXQodGhpcylcbiAgICB9KVxuXG4gICAgdGhpcy4kY29udGFpbmVyLm9uKCdjbGljaycsICcuX194ZV9idG5fZGVsZXRlJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKVxuICAgICAgdGhhdC5kZXN0cm95KHRoaXMpXG4gICAgICB0aGF0LmNsb3NlQWxsKClcbiAgICB9KVxuXG4gICAgdGhpcy4kY29udGFpbmVyLm9uKCdjaGFuZ2UnLCAnLl9feGVfdHlwZV9pZCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICB2YXIgZm9ybSA9ICQodGhpcykuY2xvc2VzdCgnZm9ybScpXG5cbiAgICAgIHZhciBzZWxlY3QgPSBmb3JtLmZpbmQoJ1tuYW1lPVwic2tpbklkXCJdJylcbiAgICAgIHNlbGVjdC5maW5kKCdvcHRpb24nKS5yZW1vdmUoKVxuICAgICAgc2VsZWN0LnByb3AoJ2Rpc2FibGVkJywgdHJ1ZSlcblxuICAgICAgdGhhdC5nZXRTa2luT3B0aW9uKGZvcm0pXG4gICAgfSlcblxuICAgIHRoaXMuJGNvbnRhaW5lci5vbignY2hhbmdlJywgJy5fX3hlX3NraW5faWQnLCBmdW5jdGlvbiAoZSkge1xuICAgICAgdmFyIGZvcm0gPSAkKHRoaXMpLmNsb3Nlc3QoJ2Zvcm0nKVxuICAgICAgdGhhdC5nZXRBZGRpdGlvbmFsQ29uZmlndXJlKGZvcm0pXG4gICAgfSlcblxuICAgIHRoaXMuJGNvbnRhaW5lci5vbignY2xpY2snLCAnLl9feGVfY2hlY2tib3gtY29uZmlnJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgIHZhciAkdGFyZ2V0ID0gJChlLnRhcmdldClcbiAgICAgIHZhciBmb3JtID0gJCh0aGlzKS5jbG9zZXN0KCdmb3JtJylcbiAgICAgIGZvcm0uZmluZCgnW25hbWU9XCInICsgJHRhcmdldC5kYXRhKCduYW1lJykgKyAnXCJdJykudmFsKCR0YXJnZXQucHJvcCgnY2hlY2tlZCcpID09IHRydWUgPyAndHJ1ZScgOiAnZmFsc2UnKVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICogY29udGFpbmVy66W8IOumrO2EtO2VnOuLpC5cbiAgICogQHBhcmFtIHtqUXVlcnl9IGZvcm1cbiAgICogQHJldHVybiB7alF1ZXJ5fVxuICAgKi9cbiAgdGhpcy5nZXRGb3JtQ29udGFpbmVyID0gZnVuY3Rpb24gKGZvcm0pIHtcbiAgICByZXR1cm4gZm9ybS5jbG9zZXN0KCcuX194ZV9mb3JtX2NvbnRhaW5lcicpXG4gIH1cblxuICAvKipcbiAgICogbW9kYWzsnYQgY2xvc2XtlZzri6QuXG4gICAqIEBwYXJhbSB7alF1ZXJ5fSB0YXJnZXRcbiAgICovXG4gIHRoaXMuY2xvc2UgPSBmdW5jdGlvbiAodGFyZ2V0KSB7XG4gICAgdmFyIGZvcm0gPSAkKHRhcmdldCkuY2xvc2VzdCgnZm9ybScpXG5cbiAgICBmb3JtLnJlbW92ZSgpXG5cbiAgICB0aGlzLiRjb250YWluZXIuJG1vZGFsLnhlTW9kYWwoJ2hpZGUnKVxuICB9XG5cbiAgLyoqXG4gICAqIGdyb3VwIOumrOyKpO2KuOulvCDsmpTssq3tlZzri6QuXG4gICAqL1xuICB0aGlzLmdldExpc3QgPSBmdW5jdGlvbiAoKSB7XG4gICAgaWYgKCF0aGlzLmdyb3VwKSB7XG4gICAgICByZXR1cm5cbiAgICB9XG4gICAgdmFyIHBhcmFtcyA9IHsgZ3JvdXA6IHRoaXMuZ3JvdXAgfVxuICAgIHZhciB0aGF0ID0gdGhpc1xuXG4gICAgdmFyIGpxeGhyID0gd2luZG93LlhFLmFqYXgoe1xuICAgICAgY29udGV4dDogdGhpcy4kY29udGFpbmVyWzBdLFxuICAgICAgdHlwZTogJ2dldCcsXG4gICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgZGF0YTogcGFyYW1zLFxuICAgICAgdXJsOiB3aW5kb3cuWEUucm91dGUoJ21hbmFnZS5keW5hbWljRmllbGQuaW5kZXgnKVxuICAgIH0pXG5cbiAgICBqcXhoci5kb25lKGZ1bmN0aW9uIChkYXRhLCB0ZXh0U3RhdHVzLCBqcXhocikge1xuICAgICAgdGhhdC4kY29udGFpbmVyLmZpbmQoJyNkZi10Ym9keSB0cicpLnJlbW92ZSgpXG5cbiAgICAgIGZvciAodmFyIGkgaW4gZGF0YS5saXN0KSB7XG4gICAgICAgIHRoYXQuYWRkcm93KGRhdGEubGlzdFtpXSlcbiAgICAgIH1cbiAgICB9KVxuICB9XG5cbiAgLyoqXG4gICAqIGZvcm3snYQg67O17IKs7ZWY7JesIOumrO2EtO2VnOuLpC5cbiAgICogQHJldHVybiB7alF1ZXJ5fSAkZm9ybVxuICAgKi9cbiAgdGhpcy5mb3JtQ2xvbmUgPSBmdW5jdGlvbiAoKSB7XG4gICAgdmFyICRmb3JtID0gdGhpcy4kY29udGFpbmVyLiRmb3JtLmNsb25lKCkucmVtb3ZlQ2xhc3MoJ19feGVfYWRkX2Zvcm0nKVxuICAgICRmb3JtLnNob3coKVxuICAgIHJldHVybiAkZm9ybVxuICB9XG5cbiAgLyoqXG4gICAqIOumrOyKpO2KuCDthYzsnbTruJTsl5Agcm9366W8IOy2lOqwgO2VnOuLpC5cbiAgICogQHBhcmFtIHtvYmplY3R9IGRhdGFcbiAgICovXG4gIHRoaXMuYWRkcm93ID0gZnVuY3Rpb24gKGRhdGEpIHtcbiAgICB2YXIgcm93ID0gdGhpcy4kY29udGFpbmVyLmZpbmQoJy5fX3hlX3JvdycpLmNsb25lKClcbiAgICByb3cucmVtb3ZlQ2xhc3MoJ19feGVfcm93JylcblxuICAgIHJvdy5hZGRDbGFzcygnX194ZV9yb3dfJyArIGRhdGEuaWQpXG4gICAgcm93LmRhdGEoJ2lkJywgZGF0YS5pZClcbiAgICByb3cuZmluZCgndGQuX194ZV9jb2x1bW5faWQnKS5odG1sKGRhdGEuaWQpXG4gICAgcm93LmZpbmQoJ3RkLl9feGVfY29sdW1uX2xhYmVsJykuaHRtbChkYXRhLmxhYmVsKVxuICAgIHJvdy5maW5kKCd0ZC5fX3hlX2NvbHVtbl90eXBlTmFtZScpLmh0bWwoZGF0YS50eXBlTmFtZSlcbiAgICByb3cuZmluZCgndGQuX194ZV9jb2x1bW5fc2tpbk5hbWUnKS5odG1sKGRhdGEuc2tpbk5hbWUpXG4gICAgcm93LmZpbmQoJ3RkLl9feGVfY29sdW1uX3VzZScpLmh0bWwoZGF0YS51c2UgPT0gdHJ1ZSA/ICdUcnVlJyA6ICdGYWxzZScpXG5cbiAgICBpZiAodGhpcy4kY29udGFpbmVyLmZpbmQoJy5fX3hlX3Rib2R5JykuZmluZCgnLl9feGVfcm93XycgKyBkYXRhLmlkKS5sZW5ndGggIT0gMCkge1xuICAgICAgdGhpcy4kY29udGFpbmVyLmZpbmQoJy5fX3hlX3Rib2R5JykuZmluZCgnLl9feGVfcm93XycgKyBkYXRhLmlkKS5yZXBsYWNlV2l0aChyb3cuc2hvdygpKVxuICAgIH0gZWxzZSB7XG4gICAgICB0aGlzLnJlbW92ZVJvdyhkYXRhLmlkKVxuICAgICAgdGhpcy4kY29udGFpbmVyLmZpbmQoJy5fX3hlX3Rib2R5JykuYXBwZW5kKHJvdy5zaG93KCkpXG4gICAgfVxuICB9XG5cbiAgLyoqXG4gICAqIHJvd+ulvCDsgq3soJztlZzri6QuXG4gICAqIEBwYXJhbSB7c3RyaW5nfSBpZFxuICAgKi9cbiAgdGhpcy5yZW1vdmVSb3cgPSBmdW5jdGlvbiAoaWQpIHtcbiAgICB0aGlzLiRjb250YWluZXIuZmluZCgnLl9feGVfdGJvZHknKS5maW5kKCcuX194ZV9yb3dfJyArIGlkKS5yZW1vdmUoKVxuICB9XG5cbiAgLyoqXG4gICAqIHJvd+ulvCDsiJjsoJXtlZzri6QuXG4gICAqIEBwYXJhbSB7alF1ZXJ5fSBvXG4gICAqL1xuICB0aGlzLmVkaXQgPSBmdW5jdGlvbiAobykge1xuICAgIHZhciByb3cgPSAkKG8pLmNsb3Nlc3QoJ3RyLCAuX19keW5hbWljLWZpZWxkLXJvdycpXG4gICAgdmFyIGlkID0gcm93LmRhdGEoJ2lkJylcbiAgICB2YXIgZm9ybSA9IHRoaXMuZm9ybUNsb25lKClcblxuICAgIGZvcm0uZGF0YSgnaXNFZGl0JywgJzEnKVxuICAgIGZvcm0uYXR0cignYWN0aW9uJywgd2luZG93LlhFLnJvdXRlKCdtYW5hZ2UuZHluYW1pY0ZpZWxkLnVwZGF0ZScpKVxuICAgIHRoaXMuJGNvbnRhaW5lci4kbW9kYWwuJGJvZHkuaHRtbChmb3JtKVxuICAgIHRoaXMuJGNvbnRhaW5lci4kbW9kYWwueGVNb2RhbCgnc2hvdycpXG5cbiAgICB2YXIgcGFyYW1zID0geyBncm91cDogdGhpcy5ncm91cCwgaWQ6IGlkIH1cbiAgICB2YXIgdGhhdCA9IHRoaXNcblxuICAgIHdpbmRvdy5YRS5hamF4KHtcbiAgICAgIGNvbnRleHQ6IHRoaXMuJGNvbnRhaW5lci4kbW9kYWwuJGJvZHlbMF0sXG4gICAgICB0eXBlOiAnZ2V0JyxcbiAgICAgIGRhdGFUeXBlOiAnanNvbicsXG4gICAgICBkYXRhOiBwYXJhbXMsXG4gICAgICB1cmw6IHdpbmRvdy5YRS5yb3V0ZSgnbWFuYWdlLmR5bmFtaWNGaWVsZC5nZXRFZGl0SW5mbycpLFxuICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgIGNvbnNvbGUuZGVidWcoJ2Zvcm0nLCBmb3JtKVxuICAgICAgICBmb3JtLmZpbmQoJ1tuYW1lPVwiaWRcIl0nKS52YWwocmVzcG9uc2UuY29uZmlnLmlkKS5wcm9wKCdyZWFkb25seScsIHRydWUpXG4gICAgICAgIGZvcm0uZmluZCgnW25hbWU9XCJ0eXBlSWRcIl0gb3B0aW9uJykuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgdmFyICRvcHRpb24gPSAkKHRoaXMpXG4gICAgICAgICAgaWYgKCRvcHRpb24udmFsKCkgIT0gcmVzcG9uc2UuY29uZmlnLnR5cGVJZCkge1xuICAgICAgICAgICAgJG9wdGlvbi5yZW1vdmUoKVxuICAgICAgICAgIH1cbiAgICAgICAgfSlcblxuICAgICAgICB2YXIgJGxhbmdCb3ggPSBmb3JtLmZpbmQoJy5keW5hbWljLWxhbmctZWRpdG9yLWJveCcpXG4gICAgICAgICRsYW5nQm94LmFkZENsYXNzKCdsYW5nLWVkaXRvci1ib3gnKVxuXG4gICAgICAgICRsYW5nQm94LmVhY2goZnVuY3Rpb24gKGlkeCwgZWxlbWVudCkge1xuICAgICAgICAgICQoZWxlbWVudCkuZGF0YSgnbGFuZy1rZXknLCByZXNwb25zZS5jb25maWdbJChlbGVtZW50KS5kYXRhKCduYW1lJyldKVxuICAgICAgICAgIHdpbmRvdy5sYW5nRWRpdG9yQm94UmVuZGVyKCQoZWxlbWVudCkpIC8vIEZJWE1FXG4gICAgICAgIH0pXG5cbiAgICAgICAgLy8gQEZJWE1FXG4gICAgICAgIGZvcm0uZmluZCgnW25hbWU9XCJ1c2VcIl0nKS52YWwodGhhdC5jaGVja0JveChyZXNwb25zZS5jb25maWcudXNlKSA/ICd0cnVlJyA6ICdmYWxzZScpXG4gICAgICAgIGZvcm0uZmluZCgnW25hbWU9XCJyZXF1aXJlZFwiXScpLnZhbCh0aGF0LmNoZWNrQm94KHJlc3BvbnNlLmNvbmZpZy5yZXF1aXJlZCkgPyAndHJ1ZScgOiAnZmFsc2UnKVxuICAgICAgICBmb3JtLmZpbmQoJ1tuYW1lPVwic29ydGFibGVcIl0nKS52YWwodGhhdC5jaGVja0JveChyZXNwb25zZS5jb25maWcuc29ydGFibGUpID8gJ3RydWUnIDogJ2ZhbHNlJylcbiAgICAgICAgZm9ybS5maW5kKCdbbmFtZT1cInNlYXJjaGFibGVcIl0nKS52YWwodGhhdC5jaGVja0JveChyZXNwb25zZS5jb25maWcuc2VhcmNoYWJsZSkgPyAndHJ1ZScgOiAnZmFsc2UnKVxuXG4gICAgICAgIGZvcm0uZmluZCgnW2RhdGEtbmFtZT1cInVzZVwiXScpLnByb3AoJ2NoZWNrZWQnLCB0aGF0LmNoZWNrQm94KHJlc3BvbnNlLmNvbmZpZy51c2UpKVxuICAgICAgICBmb3JtLmZpbmQoJ1tkYXRhLW5hbWU9XCJyZXF1aXJlZFwiXScpLnByb3AoJ2NoZWNrZWQnLCB0aGF0LmNoZWNrQm94KHJlc3BvbnNlLmNvbmZpZy5yZXF1aXJlZCkpXG4gICAgICAgIGZvcm0uZmluZCgnW2RhdGEtbmFtZT1cInNlYXJjaGFibGVcIl0nKS5wcm9wKCdjaGVja2VkJywgdGhhdC5jaGVja0JveChyZXNwb25zZS5jb25maWcuc2VhcmNoYWJsZSkpXG5cbiAgICAgICAgdGhhdC5nZXRTa2luT3B0aW9uKGZvcm0pXG4gICAgICB9XG4gICAgfSlcbiAgfVxuXG4gIC8qKlxuICAgKiDtjIzrnbzrr7jthLAgYm9vbGVhbuqwkuydtCB0cnVl7J28IOqyveyasCB0cnVlLCBmYWxzZeydvCDqsr3smrAgZmFsc2Xrpbwg66as7YS07ZWc64ukXG4gICAqIEBwYXJhbSB7c3RyaW5nfGJvb2xlYW59IGRhdGFcbiAgICovXG4gIHRoaXMuY2hlY2tCb3ggPSBmdW5jdGlvbiAoZGF0YSkge1xuICAgIC8vIEBGSVhNRVxuICAgIHZhciBjaGVja2VkID0gZmFsc2VcbiAgICBpZiAoZGF0YSA9PSB1bmRlZmluZWQpIHtcbiAgICAgIGNoZWNrZWQgPSBmYWxzZVxuICAgIH0gZWxzZSBpZiAoZGF0YSA9PSAnZmFsc2UnKSB7XG4gICAgICBjaGVja2VkID0gZmFsc2VcbiAgICB9IGVsc2UgaWYgKGRhdGEgPT0gJ3RydWUnKSB7XG4gICAgICBjaGVja2VkID0gdHJ1ZVxuICAgIH0gZWxzZSBpZiAoZGF0YSA9PSB0cnVlKSB7XG4gICAgICBjaGVja2VkID0gdHJ1ZVxuICAgIH1cblxuICAgIHJldHVybiBjaGVja2VkXG4gIH1cblxuICAvKipcbiAgICogcm93IOyCreygnCDsmpTssq3snYQg7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gdGFyZ2V0XG4gICAqL1xuICB0aGlzLmRlc3Ryb3kgPSBmdW5jdGlvbiAodGFyZ2V0KSB7XG4gICAgaWYgKGNvbmZpcm0oJ+ydtOuPmeyekeydgCDrkJjrj4zrprQg7IiYIOyXhuyKteuLiOuLpC4g6rOE7IaN7ZWY7Iuc6rKg7Iq164uI6rmMPycpID09PSBmYWxzZSkgeyAvLyBARklYTUVcbiAgICAgIHJldHVyblxuICAgIH1cblxuICAgIHZhciB0ciA9ICQodGFyZ2V0KS5jbG9zZXN0KCd0cicpXG4gICAgdmFyIGlkID0gdHIuZGF0YSgnaWQnKVxuICAgIHZhciBwYXJhbXMgPSB7IGdyb3VwOiB0aGlzLmdyb3VwLCBkYXRhYmFzZU5hbWU6IHRoaXMuZGF0YWJhc2VOYW1lLCBpZDogaWQgfVxuICAgIHZhciB0aGF0ID0gdGhpc1xuXG4gICAgd2luZG93LlhFLmFqYXgoe1xuICAgICAgY29udGV4dDogdGhpcy4kY29udGFpbmVyWzBdLFxuICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgIGRhdGE6IHBhcmFtcyxcbiAgICAgIHVybDogd2luZG93LlhFLnJvdXRlKCdtYW5hZ2UuZHluYW1pY0ZpZWxkLmRlc3Ryb3knKSxcbiAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChyZXNwb25zZSkge1xuICAgICAgICB2YXIgaWQgPSByZXNwb25zZS5pZFxuXG4gICAgICAgIGlmIChyZXNwb25zZS5pZCA9PSByZXNwb25zZS51cGRhdGVpZCkge1xuICAgICAgICAgIHRoYXQub3BlblN0ZXAoJ2Nsb3NlJylcbiAgICAgICAgfVxuXG4gICAgICAgIHRoYXQucmVtb3ZlUm93KGlkKVxuICAgICAgfVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICog7Iqk7YKoIOyYteyFmOydhCDsmpTssq3tlZzri6QuXG4gICAqIEBwYXJhbSB7alF1ZXJ5fSBmb3JtXG4gICAqL1xuICB0aGlzLmdldFNraW5PcHRpb24gPSBmdW5jdGlvbiAoZm9ybSkge1xuICAgIHZhciBwYXJhbXMgPSBmb3JtLnNlcmlhbGl6ZSgpXG4gICAgdmFyIHRoYXQgPSB0aGlzXG5cbiAgICBmb3JtLmZpbmQoJy5fX3hlX2FkZGl0aW9uYWxfY29uZmlndXJlJykuaHRtbCgnJylcbiAgICBpZiAoZm9ybS5maW5kKCdbbmFtZT1cInR5cGVJZFwiXScpLnZhbCgpID09ICcnKSB7XG4gICAgICByZXR1cm5cbiAgICB9XG5cbiAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICBjb250ZXh0OiB0aGlzLiRjb250YWluZXIuJG1vZGFsLiRib2R5WzBdLFxuICAgICAgdHlwZTogJ2dldCcsXG4gICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgZGF0YTogcGFyYW1zLFxuICAgICAgdXJsOiB3aW5kb3cuWEUucm91dGUoJ21hbmFnZS5keW5hbWljRmllbGQuZ2V0U2tpbk9wdGlvbicpLFxuICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgIHRoYXQuc2tpbk9wdGlvbnMoZm9ybSwgcmVzcG9uc2Uuc2tpbnMsIHJlc3BvbnNlLnNraW5JZClcbiAgICAgIH1cbiAgICB9KVxuICB9XG5cbiAgLyoqXG4gICAqIOyKpO2CqOyYteyFmCBzZWxlY3Rib3jrpbwg6rWs7ISx7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gZm9ybVxuICAgKiBAcGFyYW0ge29iamVjdH0gc2tpbnNcbiAgICogQHBhcmFtIHtzdHJpbmd9IHNlbGVjdGVkXG4gICAqL1xuICB0aGlzLnNraW5PcHRpb25zID0gZnVuY3Rpb24gKGZvcm0sIHNraW5zLCBzZWxlY3RlZCkge1xuICAgIHZhciBzZWxlY3QgPSBmb3JtLmZpbmQoJ1tuYW1lPVwic2tpbklkXCJdJylcbiAgICBzZWxlY3QuZmluZCgnb3B0aW9uJykucmVtb3ZlKClcblxuICAgIGZvciAodmFyIGtleSBpbiBza2lucykge1xuICAgICAgdmFyIG9wdGlvbiA9ICQoJzxvcHRpb24+JykuYXR0cigndmFsdWUnLCBrZXkpLnRleHQoc2tpbnNba2V5XSlcbiAgICAgIHNlbGVjdC5hcHBlbmQob3B0aW9uKVxuICAgIH1cblxuICAgIGlmIChzZWxlY3RlZCAhPSB1bmRlZmluZWQgJiYgc2VsZWN0ZWQgIT0gJycpIHtcbiAgICAgIHNlbGVjdC52YWwoc2VsZWN0ZWQpXG4gICAgfVxuXG4gICAgc2VsZWN0LnByb3AoJ2Rpc2FibGVkJywgZmFsc2UpXG5cbiAgICB0aGlzLmdldEFkZGl0aW9uYWxDb25maWd1cmUoZm9ybSlcbiAgfVxuXG4gIC8qKlxuICAgKiDtlYTrk5zrp4jri6Qg7LaU6rCA7ISk7KCV7J2EIOuhnOuTnO2VnOuLpC5cbiAgICogQHBhcmFtIHtqUXVlcnl9ICRmb3JtXG4gICAqL1xuICB0aGlzLmdldEFkZGl0aW9uYWxDb25maWd1cmUgPSBmdW5jdGlvbiAoJGZvcm0pIHtcbiAgICBjb25zdCBwYXJhbXMgPSB7fVxuICAgICRmb3JtLnNlcmlhbGl6ZUFycmF5KCkuZm9yRWFjaCgoaXRlbSkgPT4ge1xuICAgICAgcGFyYW1zW2l0ZW0ubmFtZV0gPSBpdGVtLnZhbHVlXG4gICAgfSlcblxuICAgIHdpbmRvdy5YRS5nZXQoJ21hbmFnZS5keW5hbWljRmllbGQuZ2V0QWRkaXRpb25hbENvbmZpZ3VyZScsIHBhcmFtcywgeyBoZWFkZXJzOiB7ICdYLVhFLUFzeW5jLUV4cG9zZSc6IHRydWUgfSB9KVxuICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xuICAgICAgICAkZm9ybS5maW5kKCcuX194ZV9hZGRpdGlvbmFsX2NvbmZpZ3VyZScpLmh0bWwocmVzcG9uc2UuZGF0YS5yZXN1bHQpXG4gICAgICB9KVxuICB9XG5cbiAgLyoqXG4gICAqIO2Zleyepe2VhOuTnOulvCDrk7HroZ3tlZzri6QuXG4gICAqIEBwYXJhbSB7alF1ZXJ5fSB0YXJnZXRcbiAgICovXG4gIHRoaXMuc3RvcmUgPSBmdW5jdGlvbiAodGFyZ2V0KSB7XG4gICAgdmFyICRmb3JtID0gdGhpcy4kY29udGFpbmVyLiRtb2RhbC4kYm9keS5maW5kKCdmb3JtJylcbiAgICB2YXIgdGhhdCA9IHRoaXNcblxuICAgIHRyeSB7XG4gICAgICB0aGlzLnZhbGlkYXRlQ2hlY2soJGZvcm0pXG4gICAgfSBjYXRjaCAoZSkge1xuICAgICAgcmV0dXJuXG4gICAgfVxuXG4gICAgdmFyIHBhcmFtcyA9ICRmb3JtLnNlcmlhbGl6ZSgpXG5cbiAgICB3aW5kb3cuWEUuYWpheCh7XG4gICAgICBjb250ZXh0OiB0aGlzLiRjb250YWluZXIuJG1vZGFsLiRib2R5WzBdLFxuICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgZGF0YVR5cGU6ICdqc29uJyxcbiAgICAgIGRhdGE6IHBhcmFtcyxcbiAgICAgIHVybDogJGZvcm0uYXR0cignYWN0aW9uJyksXG4gICAgICBzdWNjZXNzOiBmdW5jdGlvbiAocmVzcG9uc2UpIHtcbiAgICAgICAgdGhhdC5hZGRyb3cocmVzcG9uc2UpXG4gICAgICAgIHRoYXQuY2xvc2UodGFyZ2V0KVxuICAgICAgfVxuICAgIH0pXG4gIH1cblxuICAvKipcbiAgICog7Y+8IOyalOyGjOyXkCB2YWxpZGF0aW9uIHJ1bGXsnYQg65Ox66Gd7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gJGZvcm1cbiAgICogQHBhcmFtIHtvYmplY3R9IGFkZFJ1bGVzXG4gICAqL1xuICB0aGlzLnNldFZhbGlkYXRlUnVsZSA9IGZ1bmN0aW9uICgkZm9ybSwgYWRkUnVsZXMpIHtcbiAgICB2YXIgcnVsZU5hbWUgPSB0aGlzLnZhbGlkYXRvci5nZXRSdWxlTmFtZSgkZm9ybSlcbiAgICBpZiAoYWRkUnVsZXMgIT0gdW5kZWZpbmVkICYmIHJ1bGVOYW1lICE9IHVuZGVmaW5lZCkge1xuICAgICAgdGhpcy52YWxpZGF0b3Iuc2V0UnVsZXMocnVsZU5hbWUsIGFkZFJ1bGVzKVxuICAgIH1cbiAgfVxuXG4gIC8qKlxuICAgKiDtj7wg7JqU7IaM7JeQIHZhbGlkYXRpb27snYQg7LK07YGs7ZWc64ukLlxuICAgKiBAcGFyYW0ge2pRdWVyeX0gJGZvcm1cbiAgICovXG4gIHRoaXMudmFsaWRhdGVDaGVjayA9IGZ1bmN0aW9uICgkZm9ybSkge1xuICAgIHRoaXMudmFsaWRhdG9yLmNoZWNrKCRmb3JtKVxuICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IER5bmFtaWNGaWVsZFxuXG4vLyBARklYTUVcbnZhciBpbnN0YW5jZSA9IG5ldyBEeW5hbWljRmllbGQoKVxuaWYgKHR5cGVvZiB3aW5kb3cuZHluYW1pY0ZpZWxkRGF0YSAhPT0gJ3VuZGVmaW5lZCcgJiYgdHlwZW9mIHdpbmRvdy5keW5hbWljRmllbGREYXRhLmdyb3VwICE9PSAndW5kZWZpbmVkJyAmJiB0eXBlb2Ygd2luZG93LmR5bmFtaWNGaWVsZERhdGEuZGF0YWJhc2VOYW1lICE9PSAndW5kZWZpbmVkJykge1xuICBpbnN0YW5jZS5pbml0KHdpbmRvdy5keW5hbWljRmllbGREYXRhLmdyb3VwLCB3aW5kb3cuZHluYW1pY0ZpZWxkRGF0YS5kYXRhYmFzZU5hbWUpXG4gIGluc3RhbmNlLmdldExpc3QoKVxufVxuIiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDQ0MSk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDUpOyIsIm1vZHVsZS5leHBvcnRzID0gKF9fd2VicGFja19yZXF1aXJlX18oLyohIGRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb24gKi8gXCJkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uXCIpKSg2OCk7IiwibW9kdWxlLmV4cG9ydHMgPSAoX193ZWJwYWNrX3JlcXVpcmVfXygvKiEgZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vbiAqLyBcImRsbC1yZWZlcmVuY2UgX3hlX2RsbF9jb21tb25cIikpKDU4KTsiLCJtb2R1bGUuZXhwb3J0cyA9IChfX3dlYnBhY2tfcmVxdWlyZV9fKC8qISBkbGwtcmVmZXJlbmNlIF94ZV9kbGxfY29tbW9uICovIFwiZGxsLXJlZmVyZW5jZSBfeGVfZGxsX2NvbW1vblwiKSkoMCk7IiwibW9kdWxlLmV4cG9ydHMgPSBfeGVfZGxsX2NvbW1vbjsiXSwic291cmNlUm9vdCI6IiJ9