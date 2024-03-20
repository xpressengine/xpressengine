/* ES5 */
/* global $,XE */

$(function () {
  $('.container-fluid .container-fluid').parent('.container-fluid').removeClass('container-fluid')

  $('.sort-list').sortable({
    handle: '.__handler',
    cancel: ''
  }).disableSelection()

  // --disabled 체크박스의 해제 제한
  $('.admin-table__signup').on('click change', '.xu-label-checkradio--disabled input:checkbox', function () {
    return false
  })

  // 이름, 패스워드 정책 수정 영역
  var $areaSettingDisplayName = $('.__area-setting-display-name')
  var $areaSettingPassword = $('.__area-setting-password')

  $('.__btn-setting-password').on('click', function () {
    $areaSettingPassword.toggle()
  })

  // start:login_id
  // wrap
  var $wrapLoginId = $('.__regsetting-loginid-wrap');

  $wrapLoginId.find('[name=use_login_id]').on('change', function () {
    $('[name=require_login_id]').prop('checked', $(this).prop('checked'))
  })
  // end:login_id

  // start:display_name
  // wrap
  var $wrapDisplayname = $('.__regsetting-displayname-wrap')
  $wrapDisplayname.find('.__btn-setting-display-name').on('click', function () {
    $areaSettingDisplayName.toggle()
  })
  $wrapDisplayname.on('toggle', function () {
    $wrapDisplayname.find('.__regsetting-displayname,.__regsetting-displayname-editform').toggle()
  })
  $wrapDisplayname.find('[name=use_display_name]').on('change', function () {
    $('[name=require_display_name]').prop('checked', $(this).prop('checked'))
  })
  $wrapDisplayname.find('.__regsetting-displayname-reset').on('click', function () {
    $('.__area-setting-display-name').trigger('reset')
  })
  // open
  $wrapDisplayname.find('.__regsetting-displayname-editbtn').on('click', function () {
    $wrapDisplayname.trigger('toggle')
  })
  $wrapDisplayname.find('.__regsetting-displayname-midify').on('click', function () {
    var replaced = false
    $wrapDisplayname.find('[name^=xe_lang_preprocessor]').each(function () {
      var $field = $(this)
      var origin = $field.data('origin-value')
      if (!replaced && origin) {
        replaced = true
        $('.__regsetting-display-caption').text($field.val())
      }
    })
    $wrapDisplayname.trigger('toggle')
  })
  // reset
  $wrapDisplayname.find('.__area-setting-display-name').on('reset', function () {
    var $this = $(this)
    var replaced = false
    $this.find('[name^=xe_lang_preprocessor]').each(function () {
      var $field = $(this)
      var origin = $field.data('origin-value')
      if (origin) {
        $field.val(origin)
        if (!replaced) {
          $('.__regsetting-display-caption').text(origin)
          replaced = true
        }
      }
    })
    var $checked = $('[name=display_name_unique]')
    var checked = $checked.data('origin-checked') || $checked.prop('checked')
    $checked.prop('checked', checked)
    $wrapDisplayname.trigger('toggle')
  })
  // end:display_name

  var $wrapPasswordConfirm = $('.__regsetting-passwordconfirm-wrap');

  $wrapPasswordConfirm.find('[name=use_password_confirm]').on('change', function () {
    $('[name=require_password_confirm]').prop('checked', $(this).prop('checked'))
  })
})

$.widget('xe.userRegisterDynamicFiled', {
  // default options
  options: {
    group: null,
    databaseDriver: null,
    classess: {
      itemContainer: '__udfield-items',
      item: '__udfield-item',
      btnAdd: '__udfield-add',
      btnEdit: '__udfield-btn-edit',
      btnDelete: '__udfield-btn-delete',
      useToggle: '__udfield-use',
      requireToggle: '__udfield-require',
      protectToggle: '__udfield-protect',
      modal: '__xe-udfield-modal',
      form: '__xe-udfield-form',
      modalClose: '__xe-udfield-modal-close',
      formSubmit: '__xe-udfield-modal-submit'
    }
  },
  _create: function () {
    this.$listContainer = this.element.find('.' + this.options.classess.itemContainer)
    this.group = this.options.group
    this.databaseDriver = this.options.databaseDriver
  },
  _init: function () {
    var that = this

    this.$modal = $('.' + this.options.classess.modal)
    this.$form = $('.' + this.options.classess.form)

    this.itemArrange()

    // add
    this.element.on('click', '.' + this.options.classess.btnAdd, function () {
      that.newField()
    })

    // edit
    this.element.on('click', '.' + this.options.classess.btnEdit, function () {
      that.editField(that.getFieldId(this))
    })

    // store
    this.$modal.on('click', '.' + this.options.classess.formSubmit, function () {
      that.store()
    })

    // delete
    this.element.on('click', '.' + this.options.classess.btnDelete, function () {
      that.deleteField(that.getFieldId(this))
    })

    // toggle use
    this.element.on('change', '.' + this.options.classess.useToggle, function () {
      that.useToggleField(that.getFieldId(this), that.getFieldTypeId(this), that.getFieldSkinId(this), $(this).prop('checked'))
    })

    // require use
    this.element.on('change', '.' + this.options.classess.requireToggle, function () {
      that.requireToggleField(that.getFieldId(this), that.getFieldTypeId(this), that.getFieldSkinId(this), $(this).prop('checked'))
    })

    // protect use
    this.element.on('change', '.' + this.options.classess.protectToggle, function () {
      that.protectToggleField(that.getFieldId(this), that.getFieldTypeId(this), that.getFieldSkinId(this), $(this).prop('checked'))
    })

    this.$modal.on('change', '.__xe_type_id', function (e) {
      var form = $(this).closest('form')

      var select = form.find('[name="skinId"]')
      select.find('option').remove()
      select.prop('disabled', true)

      that.getSkinOption(form)
    })

    this.$modal.on('change', '.__xe_skin_id', function (e) {
      var form = $(this).closest('form')
      that.getAdditionalConfigure(form)
    })

    this.$modal.on('click', '.__xe_checkbox-config', function (e) {
      var $target = $(e.target)
      var form = $(this).closest('form')
      form.find('[name="' + $target.data('name') + '"]').val($target.prop('checked') == true ? 'true' : 'false')
    })
  },
  getFieldId: function ($el) {
    var fieldId = null

    if (!($el instanceof jQuery)) {
      $el = $($el)
    }

    if ($el.is('.' + this.options.classess.item)) {
      fieldId = $el.data('field-id')
    } else {
      fieldId = $el.closest('.' + this.options.classess.item).data('field-id')
    }

    return fieldId
  },
  getFieldTypeId: function ($el) {
    var fieldId = null

    if (!($el instanceof jQuery)) {
      $el = $($el)
    }

    if ($el.is('.' + this.options.classess.item)) {
      fieldId = $el.data('field-typeid')
    } else {
      fieldId = $el.closest('.' + this.options.classess.item).data('field-typeid')
    }

    return fieldId
  },
  getFieldSkinId: function ($el) {
    var fieldId = null

    if (!($el instanceof jQuery)) {
      $el = $($el)
    }

    if ($el.is('.' + this.options.classess.item)) {
      fieldId = $el.data('field-skinid')
    } else {
      fieldId = $el.closest('.' + this.options.classess.item).data('field-skinid')
    }

    return fieldId
  },
  itemArrange: function () {
    this.element.find('.' + this.options.classess.item).each(function () {
      // var $item = $(this)
    })
  },
  editField: function (id) {
    var that = this
    XE.get('manage.dynamicField.getEditInfo', {
      group: this.group,
      id: id
    })
      .then(function (res) {
        var data = res.data
        var $form = that.$form.clone()
        that.$modal.xeModal('show').show()
        that.$modal.find('.modal-body').html($form)
        that.$modal.find('.__xe-udfield-form').show()
        that.$modal.find('form').data('isEdit', '1')
        that.$modal.find('form').attr('action', window.XE.route('manage.dynamicField.update'))

        $form.find('[name="id"]').val(data.config.id).prop('readonly', true)
        $form.find('[name="typeId"] option').each(function () {
          var $option = $(this)
          if ($option.val() == data.config.typeId) {
            $option.prop('selected', true)
          }
        })

        var $langBox = $form.find('.dynamic-lang-editor-box')
        $langBox.addClass('lang-editor-box')

        $langBox.each(function (idx, element) {
          $(element).data('lang-key', data.config[$(element).data('name')])
          window.langEditorBoxRender($(element)) // FIXME
        })

        // @FIXME
        $form.find('[name="use"]').val(that.checkBox(data.config.use) ? 'true' : 'false')
        $form.find('[name="required"]').val(that.checkBox(data.config.required) ? 'true' : 'false')
        $form.find('[name="sortable"]').val(that.checkBox(data.config.sortable) ? 'true' : 'false')
        $form.find('[name="searchable"]').val(that.checkBox(data.config.searchable) ? 'true' : 'false')

        $form.find('[data-name="use"]').prop('checked', that.checkBox(data.config.use))
        $form.find('[data-name="required"]').prop('checked', that.checkBox(data.config.required))
        $form.find('[data-name="searchable"]').prop('checked', that.checkBox(data.config.searchable))

        that.getSkinOption($form)
      })
  },
  newField: function () {
    var $form = this.$form.clone()
    this.$modal.xeModal('show').show()
    this.$modal.find('.modal-body').html($form)
    this.$modal.find('.__xe-udfield-form').show()
    this.$modal.find('form').data('isEdit', '0')
    this.$modal.find('form').attr('action', window.XE.route('manage.dynamicField.store'))

    var $langBox = $form.find('.dynamic-lang-editor-box')
    $langBox.addClass('lang-editor-box')

    $langBox.each(function (idx, element) {
      // $(element).data('lang-key', data.config[$(element).data('name')])
      window.langEditorBoxRender($(element)) // FIXME
    })
  },
  updateAttribute: function (id, typeId, skinId, config) {
    var data = {
      group: this.group,
      id: id,
      typeId: typeId,
      skinId: skinId
    }
    XE._.assign(data, config)

    XE.post('manage.dynamicField.update', data)
      .then(function (res) {
      })
  },
  store: function () {
    var $form = this.$modal.find('form')
    var that = this

    try {
      this.validateCheck($form)
    } catch (e) {
      return
    }

    var params = $form.serialize()

    window.XE.ajax({
      context: this.$modal.find('.modal-body')[0],
      type: 'post',
      dataType: 'json',
      data: params,
      url: $form.attr('action'),
      success: function (res) {
        var $row = $('[data-field-id=' + res.id + ']')
        if ($row.length) {
          $row.find('.__udfield-use').prop('checked', res.use)
          $row.find('.__udfield-require').prop('checked', res.required)
        } else {
          var useAttr = (res.use) ? 'checked' : ''
          var requireAttr = (res.required) ? 'checked' : ''

          var compile = XE._.template('<li class="__udfield-item" data-field-id="<%= id %>" data-field-typeid="<%= typeId %>" data-field-skinid="<%= skinId %>"><div class="sort-list__handler"><button type="button" class="xu-button xu-button--subtle-link xu-button--icon __handler"><span class="xu-button__icon"><i class="xi-drag-vertical"></i></span></button></div><p class="sort-list__text"><%= label %></p><div class="sort-list__button"><button type="button" class="xu-button xu-button--subtle xu-button--icon __udfield-btn-edit"><span class="xu-button__icon"><i class="xi-pen"></i></span></button></div><div class="sort-list__button"><button type="button" class="xu-button xu-button--subtle xu-button--icon __udfield-btn-delete"><span class="xu-button__icon"><i class="xi-trash"></i></span></button></div><div class="sort-list__checkradio"><label class="xu-label-checkradio"><input type="checkbox" class="__udfield-use" name="dynamic_fields[<%= id %>]" <%= useAttr %>><span class="xu-label-checkradio__helper"></span></label></div><div class="sort-list__checkradio"><label class="xu-label-checkradio"><input type="checkbox" class="__udfield-require" name="df_required[<%= id %>]" <%= requireAttr %>><span class="xu-label-checkradio__helper"></span></label></div><div class="sort-list__checkradio"><label class="xu-label-checkradio"><input type="checkbox" class="__udfield-protect" name="df_protect[<%= id %>]"><span class="xu-label-checkradio__helper"></span></label></div></li>')
          var html = compile(XE._.assign(res, { useAttr: useAttr, requireAttr: requireAttr }))
          $('.__udfield-items').append(html)
        }

        that.close()
      }
    })
  },
  close: function () {
    var form = this.$modal.find('form')
    form.remove()
    this.$modal.xeModal('hide')
  },
  deleteField: function (id) {
    if (confirm('이동작은 되돌릴 수 없습니다. 계속하시겠습니까?') === false) { // @FIXME
      return
    }

    var $row = $('[data-field-id=' + id + ']')
    var params = { group: this.group, databaseName: this.options.databaseDriver, id: id }

    window.XE.ajax({
      context: this.$listContainer[0],
      type: 'post',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.destroy'),
      success: function (response) {
        $row.remove()
      }
    })
  },
  useToggleField: function (id, typeId, skinId, value) {
    value = (value === true) ? 'true' : 'false'
    this.updateAttribute(id, typeId, skinId, {
      use: value
    })
  },
  requireToggleField: function (id, typeId, skinId, value) {
    value = (value === true) ? 'true' : 'false'
    this.updateAttribute(id, typeId, skinId, {
      required: value
    })
  },
  protectToggleField: function (id, typeId, skinId, value) {
    value = (value === true) ? 'true' : 'false'
    this.updateAttribute(id, typeId, skinId, {
      protect: value
    })
  },
  checkBox: function (data) {
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
  },
  getSkinOption: function (form) {
    var params = form.serialize()
    var that = this

    form.find('.__xe_additional_configure').html('')
    if (form.find('[name="typeId"]').val() == '') {
      return
    }

    window.XE.ajax({
      context: that.$modal.find('.modal-body')[0],
      type: 'get',
      dataType: 'json',
      data: params,
      url: window.XE.route('manage.dynamicField.getSkinOption'),
      success: function (response) {
        that.skinOptions(form, response.skins, response.skinId)
      }
    })
  },
  skinOptions: function (form, skins, selected) {
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
  },
  getAdditionalConfigure: function ($form) {
    var params = {}
    $form.serializeArray().forEach(function (item) {
      params[item.name] = item.value
    })

    window.XE.get('manage.dynamicField.getAdditionalConfigure', params, { headers: { 'X-XE-Async-Expose': true } })
      .then(function (response) {
        $form.find('.__xe_additional_configure').html(response.data.result)
      })
  },
  validateCheck: function ($form) {
    XE.Validator.check($form)
  },
  _destroy: function () {
  },
  _setOptions: function () {
  },
  _setOption: function (key, value) {
  }
})
