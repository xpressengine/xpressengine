var EmailBox = (function (XE, $) {
  var _this
  var _$wrapper = $()
  var _mails = []
  var _email = ''
  var _userId = ''

  var _bindEvents = function () {
    _$wrapper.on('click', '.btnDeleteEmail', function (e) {
      e.preventDefault()

      var $this = $(this)

      $this.css({ display: 'none' }).siblings().css({ display: 'inline-block' })
    })

    _$wrapper.on('click', '.btnDeleteEmailConfirm', function (e) {
      e.preventDefault()

      var $this = $(this)
      var email = $this.closest('li.list-group-item').find('[name=email]').val()

      _this.delete(email)
    })

    _$wrapper.on('click', '.btnDeleteEmailCancle', function (e) {
      e.preventDefault()

      var $this = $(this)

      $this.siblings().addBack().hide()
      $this.parent().find('.btnDeleteEmail').show()
    })

    _$wrapper.on('click', '#__xe_emailAddBtn', function () {
      var $input = $('#__xe_addedEmailInput')
      var email = $input.val()
      if (!email) {
        return
      }

      $input.val('')

      _this.add(email)
    })

    _$wrapper.on('change', '[name=email]', function (e) {
      var $this = $(this)
      var $liWrapper = $this.closest('li.list-group-item')
      var $ul = $liWrapper.closest('ul')

      $liWrapper.siblings().each(function () {
        var $li = $(this)

        if (!$li.find('> span.pull-right').length) {
          var temp = '<span class="pull-right">'
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmail" style="display: inline-block;">삭제</a>'
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailConfirm" style="display: none;">삭제확인</a>'
          temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailCancle" style="display: none;">취소</a>'
          temp += '</span>'

          $li.append(temp)
        }
      })

      if ($liWrapper.find('> span.pull-right').length > 0) {
        $liWrapper.find('> span.pull-right').remove()
      }

      $ul.prepend($liWrapper.detach())
    })
  }

  return {
    init: function (opt) {
      _this = this
      _$wrapper = opt.$wrapper
      _email = opt.email
      _userId = opt.userId

      _bindEvents()

      _this.getEmailList()

      return this
    },

    getEmailList: function () {
      XE.get('settings.user.mail.list', { userId: _userId }).then((response) => {
        _mails = response.data.mails
        _this.render(response.data.mails)
      }).catch((error) => {
        XE.toast('danger', error, '.__xe_alertEmailModal')
      })
    },

    delete: function (email) {
      XE.post('settings.user.mail.delete', { userId: _userId, address: email })
        .then(response => {
          var i = _mails.indexOf(email)
          _mails.splice(i, 1)
          _this.render(_mails)
          XE.toast('success', '삭제하였습니다.', '.__xe_alertEmailModal')
        })
        .catch(error => {
          XE.toast('danger', error, '.__xe_alertEmailModal')
        })
    },

    add: function (email) {
      XE.post('settings.user.mail.add', { userId: _userId, address: email })
        .then(response => {
          var email = response.data.mail

          _mails.push(email)

          _this.render(_mails)

          XE.toast('success', '추가되었습니다.', '.__xe_alertEmailModal')
        })
        .catch(error => {
          XE.toast('danger', error, '.__xe_alertEmailModal')
        })
    },

    render: function (emails) {
      var temp = ''

      temp += '<div>'

      if (emails.length > 0) {
        temp += '<ul class="list-group">'

        emails.forEach(function (email, i) {
          var address = email.address
          var checked = (address === _email) ? 'checked="checked"' : ''

          temp += '<li class="list-group-item clearfix">'
          temp += '<label><input type="radio" name="email" value="' + address + '" ' + checked + '/> ' + address + '</label>'

          if (email.address !== _email) {
            temp += '<span class="pull-right">'
            temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmail" style="display: inline-block;">삭제</a>'
            temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailConfirm" style="display: none;">삭제확인</a>'
            temp += '<a href="#" class="btn btn-sm btn-link btnDeleteEmailCancle" style="display: none;">취소</a>'
            temp += '</span>'
          }

          temp += '</li>'
        })

        temp += '</ul>'
      }

      temp += '<div class="input-group input-group-sm" style="margin-bottom: 20px;">'
      temp += '<input type="text" class="form-control" id="__xe_addedEmailInput" placeholder="이메일을 입력하세요">'
      temp += '<span class="input-group-btn"><buttion id="__xe_emailAddBtn" class="btn btn-default" type="button">추가</buttion></span>'
      temp += '</div>'

      _$wrapper.html(temp)
    }
  }
})(window.XE, window.jQuery)

window.jQuery(function ($) {
  $('.__xe_settingEmail').click(function () {
    $('.__xe_emailView').slideToggle()
    $('#__xe_emailSetting').slideToggle()
  })

  EmailBox.init({
    $wrapper: $('#__xe_emailSetting'),
    userId: $('#__xe_emailSetting').data('user-id'),
    email: $('#__xe_emailSetting').data('email')
  })
})
