/* global $, XE */
$(function () {
  var $container = $('.user-signup')
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
      var filedName = $this.attr('name')
      XE.Validator.validate($form, filedName, XE.Validator.rules[$form.data('rule')][filedName])
        .then(function () {
          if (!$this.is('[name=email]') && !$this.is('[name=display_name]') && !$this.is('[name=password]')) {
            $this.closest('.xu-form-group').find('.xu-form-group__validation').remove()
          }
        }, function () { })
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
              }, function (e) {})
          }
        }, function () {})
    })

    $('[name=display_name]').on('focus change', function () {
      var that = this
      var $this = $(this)
      var $form = $this.closest('form')

      XE.Validator.validate($form, 'display_name', 'required')
        .then(function () {
          $this.closest('.xu-form-group').find('.xu-form-group__validation').remove()

          if ($this.val().length) {
            checkDuplicate('name', 'display_name', $this.val())
              .then(function (result) {
                XE.Griper.form.fn.message($this, result.data.message, (result.data.valid) ? 'success' : 'error')
              }, function (e) {})
          }
        }, function () {})
    })

    $('[name=password]').on('focusin focusout keyup change', function (e) {
      var $this = $(this)

      // 메시지 제거
      $this.closest('.xu-form-group').find('.xu-form-group__validation').remove()

      var result = validatePassword(String($this.val()))

      XE.Griper.form.fn.message($this, '6글자 이상 입력', result.len, false)
      XE.Griper.form.fn.message($this, '비밀번호에 숫자 포함', result.number, false)
      XE.Griper.form.fn.message($this, '비밀번호에 대문자 포함', result.upper, false)
      XE.Griper.form.fn.message($this, '비밀번호에 특수문자 포함', result.symbol, false)
    })
  }

  function validatePassword (val) {
    var result = {
      len: null,
      number: null,
      upper: null,
      symbol: null
    }

    if (val.length !== 0) {
      result.len = (val.length >= 6) ? 'success' : 'error'
      result.number = (val.search(patternNumber) !== -1) ? 'success' : 'error'
      result.upper = (val.search(patternUppercase) !== -1) ? 'success' : 'error'
      result.symbol = (val.search(patternSymbol) !== -1) ? 'success' : 'error'
    }

    return result
  }

  function checkDuplicate (column, fieldName, val) {
    var data = {}
    data[fieldName] = val

    return window.XE.post('auth/register/check/' + column, data)
  }
})
