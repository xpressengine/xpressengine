/* global $, XE */
$(function () {
  var $container = $('.user--signup')
  var $form = $container.find('form')
  var patternNumber = /[0-9]/
  var patternUppercase = /[A-Z]/
  var patternSymbol = /[-_!@#$%^&*()+=|~`{}\[\]:";'<>?,.\/\\]/

  if ($container.length) {
    bindEvent()
  }

  $('.xu-form-group').addClass('xu-form-group--large')

  function bindEvent () {
    $container.find('input').on('focusin focusout', function () {
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

    $('[name=email]').on('focus change', function () {
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
        XE.Griper.form.fn.message($this, '6글자 이상 입력', result.len, false)
        XE.Griper.form.fn.message($this, '비밀번호에 숫자 포함', result.number, false)
        // XE.Griper.form.fn.message($this, '비밀번호에 대문자 포함', result.upper, false)
        // XE.Griper.form.fn.message($this, '비밀번호에 특수문자 포함', result.symbol, false)
      }
    })
  }

  function validatePassword (val) {
    var result = {
      len: null,
      number: null,
      upper: null,
      symbol: null,
      confirmation: null
    }

    if (val.length !== 0) {
      result.len = (val.length >= 6) ? 'success' : 'error'
      result.number = (val.search(patternNumber) !== -1) ? 'success' : 'error'
      result.upper = (val.search(patternUppercase) !== -1) ? 'success' : 'error'
      result.symbol = (val.search(patternSymbol) !== -1) ? 'success' : 'error'
      result.confirmation = ($('[name=password]').val() === $('[name=password_confirmation]').val()) ? 'success' : 'error'
    }

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
    var requiredAll = true
    $container.find('.__xe-register-aggrement--require').each(function () {
      if (!$(this).prop('checked')) {
        requiredAll = false
      }
    })
    $all.prop('checked', requiredAll)
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
