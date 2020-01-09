/* global $, XE */
$(function () {
  var $container = $('.user--signup, .user--reset-password, .__xe_settingPassword')
  var langs = {
    'min': function (rule) {
      return XE.Lang.trans('xe::validatorMin', {
        charCount: rule.options[0]
      })
    },
    'numeric': function () {
      return XE.Lang.trans('xe::passwordIncludeNumber')
    },
    'alpha': function () {
      return XE.Lang.trans('xe::passwordIncludeCharacter')
    },
    'special_char': function () {
      return XE.Lang.trans('xe::passwordIncludeSpecialCharacter')
    }
  }
  var evaluator = {
    min: function (val) {
      var item = XE._.find(passwordRules, function (o) { return o.type === 'min' })
      var min = Number(item.options[0])
      return (val.length >= min) ? 'success' : 'error'
    },
    numeric: function (val) {
      return (val.search(/[0-9]/) !== -1) ? 'success' : 'error'
    },
    alpha: function (val) {
      return (val.search(/[a-z]/i) !== -1) ? 'success' : 'error'
    },
    special_char: function (val) {
      return (val.search(/[-_!@#$%^&*()+=|~`{}\[\]:";'<>?,.\/\\]/) !== -1) ? 'success' : 'error'
    }
  }
  var passwordRules = (function () {
    var rules = String(window.XE.options.passwordRules) || 'min:6'
    rules = rules.split('|')

    XE._.forEach(rules, function (rule, key) {
      rule = rule.split(':')
      var type = rule.shift()
      rules[key] = {
        type: type,
        options: rule,
        message: langs[type]({ type: type, options: rule })
      }
    })

    return rules
  })()

  if ($container.length) {
    bindEvent()
  }

  $('.xu-form-group').addClass('xu-form-group--large')

  function bindEvent () {
    $container.find('input').on('focusout', function () {
      var $this = $(this)
      var $form = $this.closest('form')
      var fieldName = $this.attr('name')
      if ($form.data('rule') && typeof XE.Validator.rules[$form.data('rule')][fieldName] !== 'undefined') {
        XE.Validator.validate($form, fieldName, XE.Validator.rules[$form.data('rule')][fieldName])
          .then(function () {
            // if (!$this.is('[name=email]') && !$this.is('[name=display_name]') && !$this.is('[name=password]')) {
            if (!$this.is('[name=password],[name=password_confirmation]')) {
              $this.closest('.xu-form-group').find('.xu-form-group__validation').remove()
            }
          }, function () { })
      }
    })

    $('[name=email]').on('focusout change', function () {
      var that = this
      var $this = $(this)
      var $form = $this.closest('form')

      XE.Validator.validate($form, 'email', XE.Validator.rules[$form.data('rule')].email)
        .then(function (r) {
          // 메시지 제거
          $this.closest('.xu-form-group').find('.xu-form-group__validation').remove()

          if ($this.val().length) {
            checkDuplicate('email', 'email', that.value)
              .then(function (result) {
                XE.Griper.form.fn.message($this, result.data.message, (result.data.valid) ? 'success' : 'error')
              }, function (e) { })
          }
        }, function () { })
    })

    $('[name=password],[name=password_confirmation]').on('focusin focusout keyup change', function (e) {
      var $this = $(this)

      // 메시지 제거
      $this.closest('.xu-form-group').find('.xu-form-group__validation').remove()

      var result = validatePassword(String($this.val()))

      if ($this.is('[name=password_confirmation]')) {
        var confirmation = ($container.find('[name=password_confirmation]').val() && $container.find('[name=password]').val() === $container.find('[name=password_confirmation]').val()) ? 'success' : 'error'
        XE.Griper.form.fn.message($this, XE.Lang.trans('xe::enterPasswordConfirmation'), confirmation)
      } else {
        XE._.forEach(passwordRules, function (rule) {
          XE.Griper.form.fn.message($this, rule.message, result[rule.type], false)
        })
      }
    })
  }

  function validatePassword (val) {
    var result = {
      confirmation: null
    }

    XE._.forEach(passwordRules, function (item) {
      result[item.type] = (val) ? evaluator[item.type](val) : null
    })

    return result
  }

  function checkDuplicate (column, fieldName, val) {
    var data = {}
    data[fieldName] = val

    return window.XE.post('auth/register/check/' + column, data)
  }
})

// 약관
$(function ($) {
  var $container = $('.__xe-register-aggrements')
  var $all = $container.find('.__xe-register-aggrement-all')
  var $items = $container.find('.__xe-register-aggrement--require,.__xe-register-aggrement--optional')

  $container.on('chnaged.register-aggrement', function () {
    var checkedAll = true
    $items.each(function () {
      if (!$(this).prop('checked')) {
        checkedAll = false
      }
    })
    $all.prop('checked', checkedAll)
  })

  $container.on('all.register-aggrement', function () {
    $items.prop('checked', $all.is(':checked'))
  })

  $all.on('change', function () {
    $container.trigger('all.register-aggrement')
  })
  $items.on('change', function () {
    $container.trigger('chnaged.register-aggrement')
  })
})
