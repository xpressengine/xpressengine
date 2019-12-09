import $ from 'jquery'
import Validator from 'xe/validator' // @FIXME https://github.com/xpressengine/xpressengine/issues/765

/**
 * @class
 */
var DynamicField = function () {
  this.group = ''
  this.databaseName = ''
  this.containerName = ''
  this.$container = ''

  /**
   * DynamicField를 초기화 한다.
   * @param {string} group
   * @param {string} databaseName
   */
  this.init = function (group, databaseName) {
    if (!group || !databaseName) {
      return
    }

    this.group = group
    this.databaseName = databaseName
    this.containerName = '__xe_container_DF_setting_' + group
    this.$container = $('#' + this.containerName)
    this.$container.$form = this.$container.find('.__xe_add_form') || $(this.$container.data('form'))
    this.$container.$modal = this.$container.find('.__xe_df_modal')
    this.$container.$modal.$body = this.$container.$modal.find('.modal-body')
    this.validator = new Validator()

    this.attachEvent()

    this.closeAll = function () {
      this.$container.$modal.xeModal('hide')
    }
  }

  /**
   * 이벤트 핸들러를 등록한다.
   */
  this.attachEvent = function () {
    var that = this

    this.$container.on('click', '.__xe_btn_add', function () {
      that.$container.$modal.$body.html(that.formClone())
      that.$container.$modal.xeModal('show')

      var $langBox = that.$container.$modal.find('.dynamic-lang-editor-box')
      $langBox.addClass('lang-editor-box')

      $langBox.each(function (idx, element) {
        window.langEditorBoxRender($(element)) // FIXME
      })
    })

    this.$container.on('click', '.__xe_btn_submit', function () {
      that.store(this)
    })

    this.$container.on('click', '.__xe_btn_close', function () {
      that.close(this)
    })

    this.$container.on('click', '.__xe_btn_edit', function (e) {
      e.preventDefault()
      that.closeAll()
      that.edit(this)
    })

    this.$container.on('click', '.__xe_btn_delete', function (e) {
      e.preventDefault()
      that.destroy(this)
      that.closeAll()
    })

    this.$container.on('change', '.__xe_type_id', function (e) {
      var form = $(this).closest('form')

      var select = form.find('[name="skinId"]')
      select.find('option').remove()
      select.prop('disabled', true)

      that.getSkinOption(form)
    })

    this.$container.on('change', '.__xe_skin_id', function (e) {
      var form = $(this).closest('form')
      that.getAdditionalConfigure(form)
    })

    this.$container.on('click', '.__xe_checkbox-config', function (e) {
      var $target = $(e.target)
      var form = $(this).closest('form')
      form.find('[name="' + $target.data('name') + '"]').val($target.prop('checked') == true ? 'true' : 'false')
    })
  }

  /**
   * container를 리턴한다.
   * @param {jQuery} form
   * @return {jQuery}
   */
  this.getFormContainer = function (form) {
    return form.closest('.__xe_form_container')
  }

  /**
   * modal을 close한다.
   * @param {jQuery} target
   */
  this.close = function (target) {
    var form = $(target).closest('form')

    form.remove()

    this.$container.$modal.xeModal('hide')
  }

  /**
   * group 리스트를 요청한다.
   */
  this.getList = function () {
    if (!this.group) {
      return
    }
    var params = { group: this.group }
    var that = this

    var jqxhr = window.XE.ajax({
      context: this.$container[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.index')
    })

    jqxhr.done(function (data, textStatus, jqxhr) {
      that.$container.find('#df-tbody tr').remove()

      for (var i in data.list) {
        that.addrow(data.list[i])
      }
    })
  }

  /**
   * form을 복사하여 리턴한다.
   * @return {jQuery} $form
   */
  this.formClone = function () {
    var $form = this.$container.$form.clone().removeClass('__xe_add_form')
    $form.show()
    return $form
  }

  /**
   * 리스트 테이블에 row를 추가한다.
   * @param {object} data
   */
  this.addrow = function (data) {
    var row = this.$container.find('.__xe_row').clone()
    row.removeClass('__xe_row')

    row.addClass('__xe_row_' + data.id)
    row.data('id', data.id)
    row.find('td.__xe_column_id').html(data.id)
    row.find('td.__xe_column_label').html(data.label)
    row.find('td.__xe_column_typeName').html(data.typeName)
    row.find('td.__xe_column_skinName').html(data.skinName)
    row.find('td.__xe_column_use').html(data.use == true ? 'True' : 'False')

    if (this.$container.find('.__xe_tbody').find('.__xe_row_' + data.id).length != 0) {
      this.$container.find('.__xe_tbody').find('.__xe_row_' + data.id).replaceWith(row.show())
    } else {
      this.removeRow(data.id)
      this.$container.find('.__xe_tbody').append(row.show())
    }
  }

  /**
   * row를 삭제한다.
   * @param {string} id
   */
  this.removeRow = function (id) {
    this.$container.find('.__xe_tbody').find('.__xe_row_' + id).remove()
  }

  /**
   * row를 수정한다.
   * @param {jQuery} o
   */
  this.edit = function (o) {
    var row = $(o).closest('tr, .__dynamic-field-row')
    var id = row.data('id')
    var form = this.formClone()

    form.data('isEdit', '1')
    form.attr('action', window.XE.route('manage.dynamicField.update'))
    this.$container.$modal.$body.html(form)
    this.$container.$modal.xeModal('show')

    var params = { group: this.group, id: id }
    var that = this

    window.XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.getEditInfo'),
      success: function (response) {
        console.debug('form', form)
        form.find('[name="id"]').val(response.config.id).prop('readonly', true)
        form.find('[name="typeId"] option').each(function () {
          var $option = $(this)
          if ($option.val() != response.config.typeId) {
            $option.remove()
          }
        })

        var $langBox = form.find('.dynamic-lang-editor-box')
        $langBox.addClass('lang-editor-box')

        $langBox.each(function (idx, element) {
          $(element).data('lang-key', response.config[$(element).data('name')])
          window.langEditorBoxRender($(element)) // FIXME
        })

        // @FIXME
        form.find('[name="use"]').val(that.checkBox(response.config.use) ? 'true' : 'false')
        form.find('[name="required"]').val(that.checkBox(response.config.required) ? 'true' : 'false')
        form.find('[name="sortable"]').val(that.checkBox(response.config.sortable) ? 'true' : 'false')
        form.find('[name="searchable"]').val(that.checkBox(response.config.searchable) ? 'true' : 'false')

        form.find('[data-name="use"]').prop('checked', that.checkBox(response.config.use))
        form.find('[data-name="required"]').prop('checked', that.checkBox(response.config.required))
        form.find('[data-name="searchable"]').prop('checked', that.checkBox(response.config.searchable))

        that.getSkinOption(form)
      }
    })
  }

  /**
   * 파라미터 boolean값이 true일 경우 true, false일 경우 false를 리턴한다
   * @param {string|boolean} data
   */
  this.checkBox = function (data) {
    // @FIXME
    var checked = false
    if (data == undefined) {
      checked = false
    } else if (data == 'false') {
      checked = false
    } else if (data == 'true') {
      checked = true
    } else if (data == true) {
      checked = true
    }

    return checked
  }

  /**
   * row 삭제 요청을 한다.
   * @param {jQuery} target
   */
  this.destroy = function (target) {
    if (confirm('이동작은 되돌릴 수 없습니다. 계속하시겠습니까?') === false) { // @FIXME
      return
    }

    var tr = $(target).closest('tr')
    var id = tr.data('id')
    var params = { group: this.group, databaseName: this.databaseName, id: id }
    var that = this

    window.XE.ajax({
      context: this.$container[0],
      type: 'post',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.destroy'),
      success: function (response) {
        var id = response.id

        if (response.id == response.updateid) {
          that.openStep('close')
        }

        that.removeRow(id)
      }
    })
  }

  /**
   * 스킨 옵션을 요청한다.
   * @param {jQuery} form
   */
  this.getSkinOption = function (form) {
    var params = form.serialize()
    var that = this

    form.find('.__xe_additional_configure').html('')
    if (form.find('[name="typeId"]').val() == '') {
      return
    }

    window.XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.getSkinOption'),
      success: function (response) {
        that.skinOptions(form, response.skins, response.skinId)
      }
    })
  }

  /**
   * 스킨옵션 selectbox를 구성한다.
   * @param {jQuery} form
   * @param {object} skins
   * @param {string} selected
   */
  this.skinOptions = function (form, skins, selected) {
    var select = form.find('[name="skinId"]')
    select.find('option').remove()

    for (var key in skins) {
      var option = $('<option>').attr('value', key).text(skins[key])
      select.append(option)
    }

    if (selected != undefined && selected != '') {
      select.val(selected)
    }

    select.prop('disabled', false)

    this.getAdditionalConfigure(form)
  }

  /**
   * 필드마다 추가설정을 로드한다.
   * @param {jQuery} $form
   */
  this.getAdditionalConfigure = function ($form) {
    const params = {}
    $form.serializeArray().forEach((item) => {
      params[item.name] = item.value
    })

    window.XE.get('manage.dynamicField.getAdditionalConfigure', params, { headers: { 'X-XE-Async-Expose': true } })
      .then(response => {
        $form.find('.__xe_additional_configure').html(response.data.result)
      })
  }

  /**
   * 확장필드를 등록한다.
   * @param {jQuery} target
   */
  this.store = function (target) {
    var $form = this.$container.$modal.$body.find('form')
    var that = this

    try {
      this.validateCheck($form)
    } catch (e) {
      return
    }

    var params = $form.serialize()

    window.XE.ajax({
      context: this.$container.$modal.$body[0],
      type: 'post',
      dataType: 'json',
      data: params,
      url: $form.attr('action'),
      success: function (response) {
        that.addrow(response)
        that.close(target)
      }
    })
  }

  /**
   * 폼 요소에 validation rule을 등록한다.
   * @param {jQuery} $form
   * @param {object} addRules
   */
  this.setValidateRule = function ($form, addRules) {
    var ruleName = this.validator.getRuleName($form)
    if (addRules != undefined && ruleName != undefined) {
      this.validator.setRules(ruleName, addRules)
    }
  }

  /**
   * 폼 요소에 validation을 체크한다.
   * @param {jQuery} $form
   */
  this.validateCheck = function ($form) {
    this.validator.check($form)
  }
}

export default DynamicField

// @FIXME
var instance = new DynamicField()
if (typeof window.dynamicFieldData !== 'undefined' && typeof window.dynamicFieldData.group !== 'undefined' && typeof window.dynamicFieldData.databaseName !== 'undefined') {
  instance.init(window.dynamicFieldData.group, window.dynamicFieldData.databaseName)
  instance.getList()
}
