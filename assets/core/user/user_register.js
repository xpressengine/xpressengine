/* global $, XE */
$(function () {
  var $container = $('.user--signup')
  var $form = $container.find('form')
  var langs = {
    'min': XE._.template('<%= options[0] %>글자 이상 입력'),
    'numeric': function () {
      return '비밀번호에 숫자 포함'
    },
    'alpha': function () {
      return '비밀번호에 문자 포함'
    },
    'special_char': function () {
      return '비밀번호에 특수문자 포함'
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
        message: langs[type]({ options: rule })
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
      if (typeof XE.Validator.rules[$form.data('rule')][fieldName] !== 'undefined') {
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

    // $('[name=display_name]').on('focus change', function () {
    //   var that = this
    //   var $this = $(this)
    //   var $form = $this.closest('form')

    //   XE.Validator.validate($form, 'display_name', 'required')
    //     .then(function () {
    //       $this.closest('.xu-form-group').find('.xu-form-group__validation').remove()

    //       if ($this.val().length) {
    //         checkDuplicate('name', 'display_name', $this.val())
    //           .then(function (result) {
    //             XE.Griper.form.fn.message($this, result.data.message, (result.data.valid) ? 'success' : 'error')
    //           }, function (e) {})
    //       }
    //     }, function () {})
    // })

    $('[name=password],[name=password_confirmation]').on('focusin focusout keyup change', function (e) {
      var $this = $(this)

      // 메시지 제거
      $this.closest('.xu-form-group').find('.xu-form-group__validation').remove()

      var result = validatePassword(String($this.val()))

      if ($this.is('[name=password_confirmation]')) {
        XE.Griper.form.fn.message($this, '비밀번호를 한 번 더 입력해주세요', result.confirmation, false)
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
