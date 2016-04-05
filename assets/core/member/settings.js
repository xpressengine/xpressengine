$(function ($) {

    Setting = function (element, options) {
        this.options = null;
        this.$element = null;
        this.init(element, options)
    };

    Setting.DEFAULTS = {
        siblings: '.__xe_setting',
        indicator: '.setting-group',
        editBtn: '.__xe_editBtn',
        editor: '.setting-detail',
        cancelBtn: '.__xe_cancelBtn',
        saveBtn: '.__xe_saveBtn',
    };

    Setting.prototype.init = function (element, options) {
        this.$element = $(element);
        this.options = this.getOptions(options);

        this.$element.find(this.options.indicator).on('click', this.options.editBtn, $.proxy(this.edit, this));
        this.$element.find(this.options.editor).on('click', this.options.cancelBtn, $.proxy(this.cancel, this));
        this.$element.find(this.options.editor).on('click', this.options.saveBtn, $.proxy(this.save, this));

        this.$element.on('xe.setting.cancel', $.proxy(this.cancel, this));
    };

    Setting.prototype.edit = function () {
        this.showEdit();
        $(this.options.siblings).not(this.$element).trigger('xe.setting.cancel')
        return false;
    };

    Setting.prototype.cancel = function () {
        this.hideEdit();
        return false;
    }

    Setting.prototype.save = function () {
        this.hideEdit();
        return false;
    }

    Setting.prototype.showEdit = function () {
        this.$element.find(this.options.indicator).hide();
        this.$element.find(this.options.editor).show();
    }

    Setting.prototype.hideEdit = function () {
        this.$element.find(this.options.indicator).show();
        this.$element.find(this.options.editor).hide();
    }

    Setting.prototype.getDefaults = function () {
        return Setting.DEFAULTS;
    }

    Setting.prototype.getOptions = function (options) {
        options = $.extend({}, this.getDefaults(), this.defaults, this.$element.data(), options);
        return options;
    }

    Setting.extend = function (sub, prototypes) {
        sub.prototype = $.extend({}, Setting.prototype);
        sub.prototype.constructor = sub;
        $.each(prototypes, function (index, value) {
                sub.prototype[index] = value;
            }
        );
        return sub;
    }

    Setting.generate = function (sub) {
        function Plugin(option) {
            return this.each(function () {
                var $this = $(this);
                var data = $this.data('xe.setting');
                var options = typeof option == 'object' && option;
                if (!data && /destroy|hide/.test(option)) return;
                if (!data) $this.data('xe.setting', (data = new sub(this, options)));
                if (typeof option == 'string') data[option]();
            });
        }

        Plugin.Constructor = sub;
        return Plugin;
    };

    XE.Setting = Setting;
})
;

$(function () {
    var DisplayNameSetting = XE.Setting.extend(
        function (element, options) {
            this.init(element, options);
        }, {
            defaults: {
                checkUrl: false,
                saveUrl: false
            },
            init: function (element, options) {
                XE.Setting.prototype.init.call(this, element, options);

                this.validated = false

                var $this = this.$element;

                this.ui = {
                    nameText: $this.find('.__xe_displayName'),
                    settingBox: $this.find('.setting_detail_con'),
                    nameInput: $this.find('.__xe_nameInput'),
                    messageText: $this.find('.__xe_message'),
                };

                this.ui.nameInput.keyup($.proxy(function (e) {
                    if (e.keyCode == 13) {
                        this.save();
                    } else {
                        this.check($.proxy(this.checked, this));
                    }
                }, this));

            },
            edit: function () {

                if (this.options.initName != undefined) {
                    this.ui.nameInput.val(this.options.initName);
                } else {
                    this.ui.nameInput.val(this.options.originName);
                }

                this.check();
                XE.Setting.prototype.edit.call(this);
                return false;
            },
            save: function () {
                var input = this.ui.nameInput.val();
                if (!this.validated || !this.beforeCheck()) {
                    return;
                }

                var self = this;

                $.ajax({
                    url: this.options.saveUrl,
                    type: "POST",
                    dataType: 'json',
                    data: {name: input},
                    success: function (data, textStatus, jqXHR) {
                        // save에 성공하면 새로고침
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // save에 실패하면 오류 출력
                        self.setStatus(false, jqXHR.responseJSON.message)
                    }
                });

                return false;
            },

            setStatus: function (pass, message) {
                this.ui.settingBox.toggleClass('wrong', !pass);
                this.ui.messageText.text(message);
            },
            beforeCheck: function () {
                var input = this.ui.nameInput.val();
                if (input.length == 0) {
                    this.setStatus(false, '회원 이름을 입력하세요.')
                    return false;
                }
                if (input == this.options.originName) {
                    this.setStatus(false, '현재 회원 이름입니다')
                    return false;
                }
                return true;
            },
            check: function (callback) {

                var input = this.ui.nameInput.val();

                if (this.checkedName != input) {
                    this.checkedName = input;
                } else {
                    return;
                }

                if (!this.beforeCheck()) {
                    return;
                }
              var self = this;
                $.ajax(
                    {
                        url: this.options.checkUrl,
                        type: "POST",
                        dataType: 'json',
                        data: {name: input},
                        success: function (data, textStatus, jqXHR) {
                            if(self.checkedName == input) {
                              if (callback != undefined) {
                                if (data.valid) {
                                  callback(true, data);
                                } else {
                                  callback(false, data);
                                }
                              }
                            }
                        },
                    }
                );
            },
            checked: function (result, data) {
                this.validated = result;
                this.setStatus(result, data.message);
            }
        }
    );
    $.fn.xeDisplayNameSetting = XE.Setting.generate(DisplayNameSetting);
});

$(function () {

    var PasswordSetting = XE.Setting.extend(
        function (element, options) {
            this.init(element, options);
        }, {
            defaults: {
                checkUrl: false,
                saveUrl: false
            },
            init: function (element, options) {
                XE.Setting.prototype.init.call(this, element, options);

                var $this = this.$element;

                this.validated = false;

                this.ui = {
                    settingBox: $this.find('.setting_detail_con'),
                    form: $this.find('.__xe_form'),
                    currentBox: $this.find('.__xe_currentPassword'),
                    newBox: $this.find('.__xe_newPassword'),
                    confirmBox: $this.find('.__xe_passwordConfirm'),
                    inputCurrent: $this.find('[name=current_password]'),
                    inputNew: $this.find('[name=password]'),
                    inputConfirm: $this.find('[name=password_confirmation]'),
                };
                this.ui.inputNew.focusout($.proxy(this.check, this));
                this.ui.inputConfirm.focusout($.proxy(this.checkConfirm, this));
            },
            edit: function () {
                this.ui.inputCurrent.val('');
                this.ui.inputNew.val('');
                this.ui.inputConfirm.val('');
                this.setStatus(this.ui.currentBox, true);
                this.setStatus(this.ui.newBox, true);
                this.setStatus(this.ui.confirmBox, true);
                this.setSecureLevel()

                XE.Setting.prototype.edit.call(this);
                return false;
            },
            save: function () {
                var current_password = this.ui.inputCurrent.val();
                var password = this.ui.inputNew.val();
                var password_confirmation = this.ui.inputConfirm.val();
                if (!this.validated || !this.beforeCheck()) {
                    return;
                }

                $.ajax({
                    url: this.options.saveUrl,
                    type: "POST",
                    dataType: 'json',
                    data: {
                        current_password: current_password,
                        password: password,
                        password_confirmation: password_confirmation,
                    },
                    success: function (data, textStatus, jqXHR) {
                        // save에 성공하면 새로고침
                        if(data.result) {
                            location.reload();
                        } else {
                            if(data.target == 'password') {
                                self.setStatus(self.ui.newBox, false, data.message);
                            } else if(data.target == 'current_password') {
                                self.setStatus(self.ui.currentBox, false, data.message);
                            } else {
                                self.setStatus(self.ui.confirmBox, false, data.message);
                            }
                        }
                    },
                });
            },
            setStatus: function (element, status, message) {
                if (message == undefined || message.length == 0) {
                    message = ' ';
                }
                element.toggleClass('wrong', !status);
                element.find('.txt_message:not(.__xe_secure)').show().toggleClass('txt_blue', status).text(message);
            },
            setSecureLevel: function (level) {
                this.ui.newBox.removeClass('wrong');
                this.ui.newBox.find('.txt_message:not(.__xe_secure)').hide();
                this.ui.newBox.find('.__xe_secure span').hide();
                if(level != undefined) {
                    this.ui.newBox.find('.__xe_secure .__xe_' + level).show();
                    this.ui.newBox.find('.__xe_secure').show();
                } else {
                    this.ui.newBox.find('.__xe_secure').hide();
                }
            },
            beforeCheck: function () {
                var input = this.ui.inputNew.val();
                if (input.length == 0) {
                    return false;
                }
                return true;
            },
            check: function () {
                var input = this.ui.inputNew.val();

                if (this.checkedPassword != input) {
                    this.checkedPassword = input;
                } else {
                    return;
                }

                self = this;
                $.ajax(
                    {
                        url: this.options.checkUrl,
                        type: "POST",
                        dataType: 'json',
                        data: {password: input},
                        success: function (data, textStatus, jqXHR) {

                            if(data.valid) {
                                self.setSecureLevel(data.level);
                                self.checkConfirm();
                                self.validated = true;
                            } else {
                                self.setStatus(self.ui.newBox, false, data.message);
                                self.validated = false;
                            }
                        }
                    }
                );
            },
            checkConfirm: function () {
                var input = this.ui.inputNew.val();
                var input2 = this.ui.inputConfirm.val();

                if (input != input2) {
                    self.setStatus(self.ui.confirmBox, false, '확인을 위해 동일한 비밀번호를 입력해주세요');
                } else {
                    self.setStatus(self.ui.confirmBox, true, '비밀번호 확인');
                }
            }

        }
    );
    $.fn.xePasswordSetting = XE.Setting.generate(PasswordSetting);

});

$(function () {
    var EmailSetting = XE.Setting.extend(
        function (element, options) {
            this.init(element, options);
        }, {
            defaults: {
                checkUrl: false,
                saveUrl: false
            },
            init: function (element, options) {
                XE.Setting.prototype.init.call(this, element, options);

                var $this = this.$element;
                var self = this;

                this.ui = {
                    mailList: $this.find('.__xe_mailList'),
                    addEmailBox: $this.find('.__xe_addEmailBox'),
                    addBtn: $this.find('.__xe_addBtn'),
                    addCancelBtn: $this.find('.__xe_addCancelBtn'),
                    addMessage: $this.find('.__xe_message'),
                    addInput: $this.find('.__xe_addInput'),
                    confirmEmailBox: $this.find('.__xe_confirmEmailBox'),
                    confirmCodeInput: $this.find('.__xe_confirmCodeInput'),
                    confirmCodeBtn: $this.find('.__xe_confirmCodeBtn'),
                    deletePendingBtn: $this.find('.__xe_deletePendingBtn'),
                    resendConfirmBtn: $this.find('.__xe_resendConfirmBtn')
                };

                // 삭제버튼 클릭
                this.ui.mailList.on('click', '.__xe_wantDeleteBtn', function(){
                    $(this).hide().siblings('.__xe_confirmDelete').show();
                });
                // 삭제취소 클릭
                this.ui.mailList.on('click', '.__xe_deleteCancelBtn', function(){
                    $(this).parents('.__xe_confirmDelete').hide().siblings('.__xe_wantDeleteBtn').show();
                });
                // 삭제확인 클릭
                this.ui.mailList.on('click', '.__xe_deleteConfirmBtn', function(){
                    self.delete($(this));
                });

                this.ui.addInput.change(function(){
                    self.setStatus(self.ui.addEmailBox, true);
                })
                // 추가버튼 클릭
                this.ui.addBtn.click($.proxy(this.add, this));

                this.ui.confirmCodeInput.change(function(){
                    self.setStatus(self.ui.confirmEmailBox, true);
                })
                // 인증버튼 클릭
                this.ui.confirmCodeBtn.click($.proxy(this.confirm, this));

                // 대기 이메일 삭제버튼 클릭
                this.ui.deletePendingBtn.click(function(){
                    self.deletePending($(this));
                });

                // 인증 재전송 버튼 클릭
                this.ui.resendConfirmBtn.click(function(){
                    self.resendPending($(this));
                });
            },
            add: function() {
                // 입력확인
                var input = this.ui.addInput.val();
                if(input.length == 0 || this.checkedEmail == input){
                    return;
                } else {
                    this.checkedEmail = input;
                }

                var self = this;

                // 이메일 추가 요청
                $.ajax({
                    url: this.options.addUrl,
                    type: "POST",
                    dataType: 'json',
                    data: {address: input},
                    success: function (data, textStatus, jqXHR) {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // add에 실패하면 오류 출력
                        self.setStatus(self.ui.addEmailBox, false, jqXHR.responseJSON.message)
                    }
                });
            },
            confirm: function() {
                var input = this.ui.confirmCodeInput.val();
                if(input.length == 0 || this.checkedCode == input){
                    return;
                } else {
                    this.checkedCode = input;
                }

                var self = this;

                // 이메일 인증 요청
                $.ajax({
                    url: this.options.confirmUrl,
                    type: "POST",
                    dataType: 'json',
                    data: {code: input},
                    success: function (data, textStatus, jqXHR) {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // add에 실패하면 오류 출력
                        self.setStatus(self.ui.confirmEmailBox, false, jqXHR.responseJSON.message)
                    }
                });
            },
            delete: function(btn) {
                var email = btn.data('email');
                var box = btn.parents('.__xe_mailItem');
                var self = this;
                $.ajax({
                    url: this.options.deleteUrl,
                    type: "POST",
                    dataType: 'json',
                    data: {address: email},
                    success: function (data, textStatus, jqXHR) {
                        box.remove();
                        alertBox('success', data.message);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // delete에 실패하면 오류 출력
                        alertBox('danger', jqXHR.responseJSON.message)
                    }
                });
            },
            deletePending: function(btn) {
                var email = btn.data('email');
                var self = this;
                $.ajax({
                    url: this.options.deletePendingUrl,
                    type: "POST",
                    dataType: 'json',
                    data: {address: email},
                    success: function (data, textStatus, jqXHR) {
                        self.ui.addEmailBox.show();
                        self.ui.confirmEmailBox.hide();
                        alertBox('success', data.message);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // delete에 실패하면 오류 출력
                        alertBox('danger', jqXHR.responseJSON.message)
                    }
                });
            },
            resendPending: function(btn) {
                var email = btn.data('email');
                var self = this;
                $.ajax({
                    url: this.options.resendPendingUrl,
                    type: "POST",
                    dataType: 'json',
                    data: {address: email},
                    success: function (data, textStatus, jqXHR) {
                        alertBox('success', data.message);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // resend에 실패하면 오류 출력
                        alertBox('danger', jqXHR.responseJSON.message)
                    }
                });
            },
            save: function () {
                var input = this.ui.mailList.find('input[name=email]:checked').val();

                if(input == this.options.originEmail) {
                    return;
                }

                $.ajax({
                    url: this.options.saveUrl,
                    type: "POST",
                    dataType: 'json',
                    data: {address: input},
                    success: function (data, textStatus, jqXHR) {
                        // save에 성공하면 새로고침
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // save에 실패하면 오류 출력
                        self.setStatus(false, jqXHR.responseJSON.message)
                    }
                });
            },
            setStatus: function (element, status, message) {
                if (message == undefined || message.length == 0) {
                    message = ' ';
                }
                element.toggleClass('wrong', !status);
                element.find('.txt_message:not(.__xe_secure)').show().toggleClass('txt_blue', status).text(message);
            },
        }
    );
    $.fn.xeEmailSetting = XE.Setting.generate(EmailSetting);
});

$(function () {
    var LeaveSetting = XE.Setting.extend(
        function (element, options) {
            this.init(element, options);
        }, {
            defaults: {
                checkUrl: false,
                saveUrl: false
            },
            init: function (element, options) {
                XE.Setting.prototype.init.call(this, element, options);

                var $this = this.$element;

                this.ui = {
                    settingBox: $this.find('.setting_detail_con'),
                    messageText: $this.find('.__xe_message'),
                    form: $this.find('.__xe_form'),
                };

            },
            setStatus: function (pass, message) {
                this.ui.settingBox.toggleClass('wrong', !pass);
                this.ui.messageText.text(message);
            },
            save: function () {
                var input = this.$element.find('input#__xe_chkLeave:checked').val();

                if(input != 'Y') {
                    return;
                }

                form.submit();

            },
        }
    );
    $.fn.xeLeaveSetting = XE.Setting.generate(LeaveSetting);
});


$(function () {

    // menu toggle
    $('.xe-menu-toggle').click(function () {
        $('.snb-list').toggle();
    });

    XE.Component.timeago();
});

$(window).resize(function () {
    // 모바일 메뉴 노출 상태에서 화면이 커졌을 경우 snb_lst가 정상 노출을 위해 적용
    if ($(window).innerWidth() > 768) {
        $(".snb-list").css("display", '');
    }
});

