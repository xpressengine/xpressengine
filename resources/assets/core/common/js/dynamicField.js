
/**
 * @class
 * */
var DynamicField = function () {
  this.group = '';
  this.databaseName = '';
  this.containerName = '';
  this.$container = '';
  this.urls = {
    base: null,
  };

  /**
   * DynamicField를 초기화 한다.
   * @param {string} group
   * @param {string} databaseName
   * @param {object} urls
   * */
  this.init = function (group, databaseName, urls) {
    this.group = group;
    this.databaseName = databaseName;
    $.extend(this.urls, urls);
    this.containerName = '__xe_container_DF_setting_' + group;
    this.$container = $('#' + this.containerName);
    this.$container.$form = this.$container.find('.__xe_add_form');
    this.$container.$modal = this.$container.find('.__xe_df_modal');
    this.$container.$modal.$body = this.$container.$modal.find('.modal-body');

    this.attachEvent();

    this.closeAll = function () {
      this.$container.$modal.xeModal('hide');
    };
  };
  /**
   * 이벤트 핸들러를 등록한다.
   * */
  this.attachEvent = function () {
    var _this = this;

    this.$container.on('click', '.__xe_btn_add', function () {

      _this.$container.$modal.$body.html(_this.formClone());
      _this.$container.$modal.xeModal('show');

      var $langBox = _this.$container.$modal.find('.dynamic-lang-editor-box');

      $langBox.addClass('lang-editor-box');
      langEditorBoxRender($langBox);
    });

    this.$container.on('click', '.__xe_btn_submit', function () {
      _this.store(this);
    });

    this.$container.on('click', '.__xe_btn_close', function () {
      _this.close(this);
    });

    this.$container.on('click', '.__xe_btn_edit', function (e) {
      e.preventDefault();
      _this.closeAll();
      _this.edit(this);
    });

    this.$container.on('click', '.__xe_btn_delete', function (e) {
      e.preventDefault();
      _this.destroy(this);
      _this.closeAll();
    });

    this.$container.on('change', '.__xe_type_id', function (e) {
      var typeId = $(this).val();
      var frm = $(this).closest('form');

      var select = frm.find('[name="skinId"]');
      select.find('option').remove();
      select.prop('disabled', true);

      _this.getSkinOption(frm);
    });

    this.$container.on('change', '.__xe_skin_id', function (e) {
      var frm = $(this).closest('form');
      _this.getAdditionalConfigure(frm);
    });

    this.$container.on('click', '.__xe_checkbox-config', function (e) {
      var $target = $(e.target);
      var frm = $(this).closest('form');
      frm.find('[name="' + $target.data('name') + '"]').val($target.prop('checked') == true ? 'true' : 'false');
    });

  };
  /**
   * container를 리턴한다.
   * @param {jQuery} frm
   * @return {jQuery}
   * */
  this.getFormContainer = function (frm) {
    return frm.closest('.__xe_form_container');
  };
  /**
   * modal을 close한다.
   * @param {jQuery} o
   * */
  this.close = function (o) {
    var frm = $(o).closest('form');

    frm.remove();

    this.$container.$modal.xeModal('hide');
  };
  /**
   * group 리스트를 요청한다.
   * */
  this.getList = function () {
    var params = { group: this.group };
    var _this = this;

    var jqxhr = XE.ajax({
      context: this.$container[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: this.urls.base,
    });

    jqxhr.done(function (data, textStatus, jqxhr) {
      _this.$container.find('#df-tbody tr').remove();

      for (var i in data.list) {
        _this.addrow(data.list[i]);
      }
    });
  };
  /**
   * form을 복사하여 리턴한다.
   * @return {jQuery} $form
   * */
  this.formClone = function () {
    var $form = this.$container.$form.clone().removeClass('__xe_add_form');
    $form.show();
    return $form;
  };
  /**
   * 리스트 테이블에 row를 추가한다.
   * @param {object} data
   * */
  this.addrow = function (data) {
    var row = this.$container.find('.__xe_row').clone();
    row.removeClass('__xe_row');

    row.addClass('__xe_row_' + data.id);
    row.data('id', data.id);
    row.find('td.__xe_column_id').html(data.id);
    row.find('td.__xe_column_label').html(data.label);
    row.find('td.__xe_column_typeName').html(data.typeName);
    row.find('td.__xe_column_skinName').html(data.skinName);
    row.find('td.__xe_column_use').html(data.use == true ? 'True' : 'False');

    if (this.$container.find('.__xe_tbody').find('.__xe_row_' + data.id).length != 0) {
      this.$container.find('.__xe_tbody').find('.__xe_row_' + data.id).replaceWith(row.show());
    } else {
      this.removeRow(data.id);
      this.$container.find('.__xe_tbody').append(row.show());
    }

  };
  /**
   * row를 삭제한다.
   * @param {string} id
   * */
  this.removeRow = function (id) {
    this.$container.find('.__xe_tbody').find('.__xe_row_' + id).remove();
  };
  /**
   * row를 수정한다.
   * @param {jQuery} o
   * */
  this.edit = function (o) {
    var tr = $(o).closest('tr');
    var id = tr.data('id');

    var frm = this.formClone();
    frm.data('isEdit', '1');
    frm.attr('action', this.urls.update);
    this.$container.$modal.$body.html(frm);
    this.$container.$modal.xeModal('show');

    var params = { group: this.group, id: id };
    var _this = this;

    XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: this.urls.getEditInfo,
      success: function (response) {
        frm.find('[name="id"]').val(response.config.id).prop('readonly', true);
        frm.find('[name="typeId"] option').each(function () {
          var $option = $(this);
          if ($option.val() != response.config.typeId) {
            $option.remove();
          }
        });

        var $langBox = frm.find('.dynamic-lang-editor-box');
        $langBox.data('lang-key', response.config.label);
        $langBox.addClass('lang-editor-box');
        langEditorBoxRender($langBox);

        frm.find('[name="use"]').val(_this.checkBox(response.config.use) ? 'true' : 'false');
        frm.find('[name="required"]').val(_this.checkBox(response.config.required) ? 'true' : 'false');
        frm.find('[name="sortable"]').val(_this.checkBox(response.config.sortable) ? 'true' : 'false');
        frm.find('[name="searchable"]').val(_this.checkBox(response.config.searchable) ? 'true' : 'false');

        frm.find('[data-name="use"]').prop('checked', _this.checkBox(response.config.use));
        frm.find('[data-name="required"]').prop('checked', _this.checkBox(response.config.required));

        _this.getSkinOption(frm);
      },
    });
  };
  /**
   * 파라미터 boolean값이 true일 경우 true, false일 경우 false를 리턴한다
   * @param {string|boolean} data
   * */
  this.checkBox = function (data) {
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
   * @param {jQuery} o
   * */
  this.destroy = function (o) {
    if (confirm('이동작은 되돌릴 수 없습니다. 계속하시겠습니까?') === false) {
      return;
    }

    var tr = $(o).closest('tr');
    var id = tr.data('id');
    var params = { group: this.group, databaseName: this.databaseName, id: id };
    var _this = this;

    XE.ajax({
      context: this.$container[0],
      type: 'post',
      dataType: 'json',
      data: params,
      url: this.urls.destroy,
      success: function (response) {
        var id = response.id;

        if (response.id == response.updateid) {
          _this.openStep('close');
        }

        _this.removeRow(id);
      },
    });
  };
  /**
   * 스킨 옵션을 요청한다.
   * @param {jQuery} frm
   * */
  this.getSkinOption = function (frm) {
    var params = frm.serialize();
    var _this = this;

    frm.find('.__xe_additional_configure').html('');
    if (frm.find('[name="typeId"]').val() == '') {
      return;
    }

    XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: this.urls.getSkinOption,
      success: function (response) {
        _this.skinOptions(frm, response.skins, response.skinId);
      },
    });
  };
  /**
   * 스킨옵션 selectbox를 구성한다.
   * @param {jQuery} frm
   * @param {object} skins
   * @param {string} selected
   * */
  this.skinOptions = function (frm, skins, selected) {
    var select = frm.find('[name="skinId"]');
    select.find('option').remove();

    for (var key in skins) {
      var option = $('<option>').attr('value', key).text(skins[key]);
      select.append(option);
    }

    if (selected != undefined && selected != '') {
      select.val(selected);
    }

    select.prop('disabled', false);

    this.getAdditionalConfigure(frm);
  };
  /**
   * 필드마다 추가설정을 로드한다.
   * @param {jQuery} $form
   * */
  this.getAdditionalConfigure = function ($form) {
    var params = $form.serialize();
    var _this = this;

    XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: this.urls.getAdditionalConfigure,
      success: function (response) {
        _this.setValidateRule($form, response.rules);

        $form.find('.__xe_additional_configure').html(response.configure);
      },
    });
  };
  /**
   * 확장필드를 등록한다.
   * @param {jQuery} o
   * */
  this.store = function (o) {
    var $form = this.$container.$modal.$body.find('form');
    var _this = this;

    try {
      this.validateCheck($form);
    } catch (e) {
      return;
    }

    var params = $form.serialize();

    XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'post',
      dataType: 'json',
      data: params,
      url: $form.attr('action'),
      success: function (response) {
        _this.addrow(response);
        _this.close(o);
      },
    });
  };
  /**
   * 폼 요소에 validation rule을 등록한다.
   * @param {jQuery} $form
   * @param {object} addRules
   * */
  this.setValidateRule = function ($form, addRules) {
    var ruleName = XE.validator.getRuleName($form);
    if (addRules != undefined && ruleName != undefined) {
      XE.validator.setRules(ruleName, addRules);
    }
  };
  /**
   * 폼 요소에 validation을 체크한다.
   * @param {jQuery} $form
   * */
  this.validateCheck = function ($form) {
      XE.validator.check($form);
    };
};

export default DynamicField;

var instance = new DynamicField();
instance.init(dynamicFieldData.group, dynamicFieldData.databaseName, dynamicFieldData.routes);
instance.getList();
