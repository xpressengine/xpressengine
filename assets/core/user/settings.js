/* ES5 */
// @fixme

window.jQuery(function ($) {
  var Setting = function (element, options) {
    this.options = null
    this.$element = null
    this.init(element, options)
  }

  Setting.DEFAULTS = {
    siblings: '.__xe_setting',
    indicator: '.setting-group',
    editBtn: '.__xe_editBtn',
    editor: '.setting-detail',
    cancelBtn: '.__xe_cancelBtn',
    saveBtn: '.__xe_saveBtn'
  }

  Setting.prototype.init = function (element, options) {
    this.$element = $(element)
    this.options = this.getOptions(options)

    this.$element.find(this.options.indicator).on('click', this.options.editBtn, $.proxy(this.edit, this))
    this.$element.find(this.options.editor).on('click', this.options.cancelBtn, $.proxy(this.cancel, this))
    this.$element.find(this.options.editor).on('click', this.options.saveBtn, $.proxy(this.save, this))

    this.$element.on('xe.setting.cancel', $.proxy(this.cancel, this))
  }

  Setting.prototype.edit = function () {
    this.showEdit()
    $(this.options.siblings).not(this.$element).trigger('xe.setting.cancel')
    return false
  }

  Setting.prototype.cancel = function () {
    this.hideEdit()
    return false
  }

  Setting.prototype.save = function () {
    this.hideEdit()
    return false
  }

  Setting.prototype.showEdit = function () {
    this.$element.find(this.options.indicator).hide()
    this.$element.find(this.options.editor).show()
  }

  Setting.prototype.hideEdit = function () {
    this.$element.find(this.options.indicator).show()
    this.$element.find(this.options.editor).hide()
  }

  Setting.prototype.getDefaults = function () {
    return Setting.DEFAULTS
  }

  Setting.prototype.getOptions = function (options) {
    options = $.extend({}, this.getDefaults(), this.defaults, this.$element.data(), options)
    return options
  }

  Setting.extend = function (sub, prototypes) {
    sub.prototype = $.extend({}, Setting.prototype)
    sub.prototype.constructor = sub
    $.each(prototypes, function (index, value) {
      sub.prototype[index] = value
    }
    )
    return sub
  }

  Setting.generate = function (Sub) {
    function Plugin (option) {
      return this.each(function () {
        var $this = $(this)
        var data = $this.data('xe.setting')
        var options = typeof option === 'object' && option
        if (!data && /destroy|hide/.test(option)) {
          return
        }

        if (!data) {
          data = new Sub(this, options)
          $this.data('xe.setting', data)
        }

        if (typeof option === 'string') data[option]()
      })
    }

    Plugin.Constructor = Sub
    return Plugin
  }

  window.XE.Setting = Setting
})

window.jQuery(function ($) {
  var DisplayNameSetting = window.XE.Setting.extend(
    function (element, options) {
      this.init(element, options)
    }, {

      defaults: {
        checkUrl: false,
        saveUrl: false
      },
      init: function (element, options) {
        window.XE.Setting.prototype.init.call(this, element, options)

        this.validated = false

        var $this = this.$element

        this.ui = {
          nameText: $this.find('.__xe_displayName'),
          settingBox: $this.find('.setting-detail-content'),
          nameInput: $this.find('.__xe_nameInput'),
          messageText: $this.find('.__xe_message')
        }

        this.ui.nameInput.focusout($.proxy(function (e) {
          this.check($.proxy(this.checked, this))
        }, this))
      },

      edit: function () {
        if (this.options.initName != undefined) {
          this.ui.nameInput.val(this.options.initName)
        } else {
          this.ui.nameInput.val(this.options.originName)
        }

        this.check()
        window.XE.Setting.prototype.edit.call(this)
        return false
      },

      save: function () {
        var input = this.ui.nameInput.val()
        this.check($.proxy(this.checked, this))
        var _this = this

        XE.ajax({
          url: this.options.saveUrl,
          type: 'POST',
          dataType: 'json',
          data: { name: input },
          success: function (data, textStatus, jqXHR) {
          // save에 성공하면 새로고침
            window.location.reload()
          },

          error: function (jqXHR, textStatus, errorThrown) {
          // save에 실패하면 오류 출력
            // _this.setStatus(false, jqXHR.responseJSON.message)
          }
        })

        return false
      },

      setStatus: function (pass, message) {
        this.ui.settingBox.toggleClass('wrong-input', !pass)
        this.ui.messageText.text(message)
      },

      beforeCheck: function () {
        var input = this.ui.nameInput.val(),
          caption = this.ui.nameInput.data('caption')

        var isYourCurrentDisplayNameMessage = '현재 회원 이름입니다',
          inputUserDisplayNameMessage = '회원 이름을 입력하세요.'

        if (caption) {
          isYourCurrentDisplayNameMessage = XE.Lang.trans('xe::isYourCurrentDisplayName', {'displayName': caption})
          inputUserDisplayNameMessage = XE.Lang.trans('xe::inputUserDisplayName', {'displayName': caption})
        }

        if (input.length == 0) {
          this.setStatus(false, inputUserDisplayNameMessage)
          return false
        }

        if (input == this.options.originName) {
          this.setStatus(true, isYourCurrentDisplayNameMessage)
          return false
        }

        return true
      },

      check: function (callback) {
        var input = this.ui.nameInput.val()

        if (this.checkedName != input) {
          this.checkedName = input
        } else {
          return false
        }

        if (!this.beforeCheck()) {
          return false
        }

        var _this = this
        XE.ajax(
          {
            url: this.options.checkUrl,
            type: 'POST',
            dataType: 'json',
            data: { name: input },
            success: function (data, textStatus, jqXHR) {
              if (_this.checkedName == input) {
                if (callback != undefined) {
                  if (data.valid) {
                    callback(true, data)
                  } else {
                    callback(false, data)
                  }
                }
              }
            }
          }
        )
      },

      checked: function (result, data) {
        this.validated = result
        this.setStatus(result, data.message)
      }
    }
  )
  $.fn.xeDisplayNameSetting = window.XE.Setting.generate(DisplayNameSetting)
})

window.jQuery(function ($) {
  var PasswordSetting = window.XE.Setting.extend(
    function (element, options) {
      this.init(element, options)
    }, {

      defaults: {
        checkUrl: false,
        saveUrl: false
      },
      init: function (element, options) {
        window.XE.Setting.prototype.init.call(this, element, options)

        var $this = this.$element

        this.validated = false

        this.ui = {
          settingBox: $this.find('.setting-detail-content'),
          form: $this.find('.__xe_form'),

          currentBox: $this.find('.__xe_currentPassword'),
          newBox: $this.find('.__xe_newPassword'),
          confirmBox: $this.find('.__xe_passwordConfirm'),

          inputCurrent: $this.find('[name=current_password]'),
          inputNew: $this.find('[name=password]'),
          inputConfirm: $this.find('[name=password_confirmation]')
        }
        this.ui.inputNew.focusout($.proxy(this.check, this))
        this.ui.inputConfirm.focusout($.proxy(this.checkConfirm, this))
      },

      edit: function () {
        this.ui.inputCurrent.val('')
        this.ui.inputNew.val('')
        this.ui.inputConfirm.val('')
        this.setStatus(this.ui.currentBox, true)
        this.setStatus(this.ui.newBox, true)
        this.setStatus(this.ui.confirmBox, true)
        this.setSecureLevel()

        window.XE.Setting.prototype.edit.call(this)
        return false
      },

      save: function () {
        var currentPassword = this.ui.inputCurrent.val()
        var password = this.ui.inputNew.val()
        var passwordConfirmation = this.ui.inputConfirm.val()
        var validated = (currentPassword && passwordConfirmation && password && password === passwordConfirmation)
        var $this = this.$element
        var _this = this
        if (!validated || !this.beforeCheck()) {
          if ($this.find('[name=current_password]').length && !currentPassword) {
            this.ui.inputCurrent.focus()
          } else if (!password) {
            this.ui.inputNew.focus()
          } else {
            this.ui.inputConfirm.focus()
          }
          return
        }

        window.XE.ajax({
          url: this.options.saveUrl,
          type: 'POST',
          dataType: 'json',
          data: {
            current_password: currentPassword,
            password: password,
            password_confirmation: passwordConfirmation
          },
          success: function (data, textStatus, jqXHR) {
          // save에 성공하면 새로고침
            if (data.result) {
              window.location.reload()
            } else {
              if (data.target == 'password') {
                _this.setStatus(_this.ui.newBox, false, data.message)
              } else if (data.target == 'current_password') {
                _this.setStatus(_this.ui.currentBox, false, data.message)
              } else {
                _this.setStatus(_this.ui.confirmBox, false, data.message)
              }
            }
          }
        })
      },

      setStatus: function (element, status, message) {
        if (message == undefined || message.length == 0) {
          message = ' '
        }

        element.toggleClass('wrong-input', !status)
        element.find('.text-message:not(.__xe_secure)').show().text(message)
      },

      setSecureLevel: function (level) {
        this.ui.newBox.removeClass('wrong-input')
        this.ui.newBox.find('.text-message:not(.__xe_secure)').hide()
        this.ui.newBox.find('.__xe_secure span').hide()
        if (level != undefined) {
          this.ui.newBox.find('.__xe_secure .__xe_' + level).show()
          this.ui.newBox.find('.__xe_secure').show()
        } else {
          this.ui.newBox.find('.__xe_secure').hide()
        }
      },

      beforeCheck: function () {
        var input = this.ui.inputNew.val()
        return input.length != 0;
      },

      check: function () {
        var input = this.ui.inputNew.val()

        if (this.checkedPassword != input) {
          this.checkedPassword = input
        } else {

        }

        // _this = this
        // XE.ajax(
        //   {
        //     url: this.options.checkUrl,
        //     type: 'POST',
        //     dataType: 'json',
        //     data: { password: input },
        //     success: function (data, textStatus, jqXHR) {
        //       if (data.valid) {
        //         _this.setSecureLevel(data.level)
        //         _this.checkConfirm()
        //         _this.validated = true
        //       } else {
        //         _this.setStatus(_this.ui.newBox, false, data.message)
        //         _this.validated = false
        //       }
        //     }
        //   }
        // )
      },

      checkConfirm: function () {
        // var input = this.ui.inputNew.val()
        // var input2 = this.ui.inputConfirm.val()

        // if (input != input2) {
        //   _this.setStatus(_this.ui.confirmBox, false, '확인을 위해 동일한 비밀번호를 입력해주세요')
        // } else {
        //   _this.setStatus(_this.ui.confirmBox, true, '비밀번호 확인')
        // }
      }

    }
  )
  $.fn.xePasswordSetting = XE.Setting.generate(PasswordSetting)
})

window.jQuery(function ($) {
  var EmailSetting = window.XE.Setting.extend(
    function (element, options) {
      this.init(element, options)
    }, {

      defaults: {
        checkUrl: false,
        saveUrl: false
      },
      init: function (element, options) {
        window.XE.Setting.prototype.init.call(this, element, options)

        var $this = this.$element
        var _this = this

        this.ui = {
          mailList: $this.find('.__xe_mailList'),
          addEmailBox: $this.find('.__xe_addEmailBox'),
          addBtn: $this.find('.__xe_addBtn'),
          addMessage: $this.find('.__xe_message'),
          addInput: $this.find('.__xe_addInput'),
          confirmEmailBox: $this.find('.__xe_confirmEmailBox'),
          confirmCodeInput: $this.find('.__xe_confirmCodeInput'),
          confirmCodeBtn: $this.find('.__xe_confirmCodeBtn'),
          deletePendingBtn: $this.find('.__xe_deletePendingBtn'),
          resendConfirmBtn: $this.find('.__xe_resendConfirmBtn')
        }

        // 삭제버튼 클릭
        this.ui.mailList.on('click', '.__xe_wantDeleteBtn', function () {
          $(this).hide().siblings('.__xe_confirmDelete').show()
        })

        // 삭제취소 클릭
        this.ui.mailList.on('click', '.__xe_deleteCancelBtn', function () {
          $(this).parents('.__xe_confirmDelete').hide().siblings('.__xe_wantDeleteBtn').show()
        })

        // 삭제확인 클릭
        this.ui.mailList.on('click', '.__xe_deleteConfirmBtn', function () {
          _this.delete($(this))
        })

        this.ui.addInput.change(function () {
          _this.setStatus(_this.ui.addEmailBox, true)
        })

        // 추가버튼 클릭
        this.ui.addBtn.click($.proxy(this.add, this))

        this.ui.confirmCodeInput.change(function () {
          _this.setStatus(_this.ui.confirmEmailBox, true)
        })

        // 인증버튼 클릭
        this.ui.confirmCodeBtn.click($.proxy(this.confirm, this))

        // 대기 이메일 삭제버튼 클릭
        this.ui.deletePendingBtn.click(function () {
          _this.deletePending($(this))
        })

        // 인증 재전송 버튼 클릭
        this.ui.resendConfirmBtn.click(function () {
          _this.resendPending($(this))
        })
      },

      add: function () {
      // 입력확인
        var input = this.ui.addInput.val()
        if (input.length == 0 || this.checkedEmail == input) {
          return
        } else {
          this.checkedEmail = input
        }

        var _this = this

        // 이메일 추가 요청
        XE.ajax({
          url: this.options.addUrl,
          type: 'POST',
          dataType: 'json',
          data: { address: input },
          success: function (data, textStatus, jqXHR) {
            window.location.reload()
          },

          error: function (jqXHR, textStatus, errorThrown) {
          // add에 실패하면 오류 출력
            _this.setStatus(_this.ui.addEmailBox, false, jqXHR.responseJSON.message)
          }
        })
      },

      confirm: function () {
        var input = this.ui.confirmCodeInput.val()
        if (input.length == 0 || this.checkedCode == input) {
          return
        } else {
          this.checkedCode = input
        }

        var _this = this

        // 이메일 인증 요청
        XE.ajax({
          url: this.options.confirmUrl,
          type: 'POST',
          dataType: 'json',
          data: { code: input },
          success: function (data, textStatus, jqXHR) {
            window.location.reload()
          },

          error: function (jqXHR, textStatus, errorThrown) {
          // add에 실패하면 오류 출력
            _this.setStatus(_this.ui.confirmEmailBox, false, jqXHR.responseJSON.message)
          }
        })
      },

      delete: function (btn) {
        var email = btn.data('email')
        var box = btn.parents('.__xe_mailItem')
        var _this = this
        XE.ajax({
          url: this.options.deleteUrl,
          type: 'POST',
          dataType: 'json',
          data: { address: email },
          success: function (data, textStatus, jqXHR) {
            box.remove()
            window.XE.toast('success', data.message)
          },

          error: function (jqXHR, textStatus, errorThrown) {
          // delete에 실패하면 오류 출력
            window.XE.toast('danger', jqXHR.responseJSON.message)
          }
        })
      },

      deletePending: function (btn) {
        var email = btn.data('email')
        var _this = this
        XE.ajax({
          url: this.options.deletePendingUrl,
          type: 'POST',
          dataType: 'json',
          data: { address: email },
          success: function (data, textStatus, jqXHR) {
            _this.ui.addEmailBox.show()
            _this.ui.confirmEmailBox.hide()
            window.XE.toast('success', data.message)
          },

          error: function (jqXHR, textStatus, errorThrown) {
          // delete에 실패하면 오류 출력
            window.XE.toast('danger', jqXHR.responseJSON.message)
          }
        })
      },

      resendPending: function (btn) {
        var email = btn.data('email')
        var _this = this
        XE.ajax({
          url: this.options.resendPendingUrl,
          type: 'POST',
          dataType: 'json',
          data: { address: email },
          success: function (data, textStatus, jqXHR) {
            window.XE.toast('success', data.message)
          },

          error: function (jqXHR, textStatus, errorThrown) {
          // resend에 실패하면 오류 출력
            window.XE.toast('danger', jqXHR.responseJSON.message)
          }
        })
      },

      save: function () {
        var input = this.ui.mailList.find('input[name=email]:checked').val()

        if (input == this.options.originEmail) {
          return
        }

        XE.ajax({
          url: this.options.saveUrl,
          type: 'POST',
          dataType: 'json',
          data: { address: input },
          success: function (data, textStatus, jqXHR) {
          // save에 성공하면 새로고침
            window.location.reload()
          },

          error: function (jqXHR, textStatus, errorThrown) {
          // save에 실패하면 오류 출력
            _this.setStatus(false, jqXHR.responseJSON.message)
          }
        })
      },

      setStatus: function (element, status, message) {
        if (message == undefined || message.length == 0) {
          message = ' '
        }

        element.toggleClass('wrong-input', !status)
        element.find('.text-message:not(.__xe_secure)').show().text(message)
      }
    }
  )
  $.fn.xeEmailSetting = window.XE.Setting.generate(EmailSetting)
})

window.jQuery(function ($) {
  var LeaveSetting = window.XE.Setting.extend(
    function (element, options) {
      this.init(element, options)
    }, {

      defaults: {
        checkUrl: false,
        saveUrl: false
      },
      init: function (element, options) {
        window.XE.Setting.prototype.init.call(this, element, options)

        var $this = this.$element

        this.ui = {
          settingBox: $this.find('.setting-detail-content'),
          messageText: $this.find('.__xe_message'),
          form: $this.find('.__xe_form')
        }
      },

      setStatus: function (pass, message) {
        this.ui.settingBox.toggleClass('wrong-input', !pass)
        this.ui.messageText.text(message)
      },

      save: function () {
        var input = this.$element.find('input#__xe_chkLeave:checked').val()

        if (input != 'Y') {
          return
        }

        this.ui.form.submit()
      }
    }
  )
  $.fn.xeLeaveSetting = window.XE.Setting.generate(LeaveSetting)
})

window.jQuery(function ($) {
  // menu toggle
  $('.xe-menu-toggle').click(function () {
    $('.snb-list').toggle()
  })

  window.XE.Component.timeago()

  $(window).resize(function () {
    // 모바일 메뉴 노출 상태에서 화면이 커졌을 경우 snb_lst가 정상 노출을 위해 적용
    if ($(window).innerWidth() > 768) {
      $('.snb-list').css('display', '')
    }
  })
})
