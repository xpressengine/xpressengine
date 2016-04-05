System.import('xecore:/common/js/xe').then(function(XE) {
  $(function ($) {
    $.fn.extend({
      xeSkinSetting: function (initOptions) {
        // support mutltiple elements
        if (this.length == 0) return this;
        if (this.length > 1) {
          this.each(function () {
            $(this).xeSkinSetting(initOptions)
          });
          return this;
        }
        if (this.data('xeSkinSetting')) return this;
        this.data('xeSkinSetting', true);

        var self = this;

        /* configuration */
        var options = $.extend({
          loadUrl: '',
          saveUrl: '',
        }, initOptions);
        options.skinId = $(this).data('skinId');
        options.instanceId = $(this).data('instanceId');

        /* ui binding */
        var ui = {
          editBtn: self.find('.__xe_editBtn'),
          saveBtn: self.find('.__xe_saveBtn'),
          cancelBtn: self.find('.__xe_cancelBtn'),
          indicator: self.find('.__xe_skinIndicator'),
          title: self.find('.__xe_skinTitle'),
          setter: self.find('.__xe_skinSetter'),
          skinSelector: self.find('.__xe_skinSelector select'),
          form: self.find('.__xe_skinSetter .__xe_skinForm'),
          forms: self.find('.__xe_skinSetter .__xe_skinForms')
        }

        /* events */

        // form submit
        ui.form.submit(function (e) {
          var skinId = ui.skinSelector.val();
          if (!skinId) {
            return;
          }
          var postData = $(this).serializeArray();
          self.saveSetting(options.saveUrl, postData, function (result, data) {
            if(result == 'success') {
              options.skinId = skinId;
              ui.title.text(data.skinTitle);
            }
            ui.setter.slideUp(100);
            // btn 숨기기
            ui.editBtn.show();
            ui.saveBtn.hide();
            ui.cancelBtn.hide();
          })
          e.preventDefault(); //STOP default action
        });

        // click edit btn
        ui.editBtn.click(function () {

          ui.editBtn.hide();

          // cancel other settings
          $('.__xe_skinSetting').not(self).trigger('skinSetting:cancel')

          // view 로드 후 setting 펼치기
          self.loadSettingView(options.skinId, options.instanceId, function () {
            ui.setter.slideDown(100);
            // btn 숨기기
            ui.saveBtn.show();
            ui.cancelBtn.show();
          })

        });

        $(this).on('skinSetting:cancel', function (e) {
          self.cancelSetting();
        });

        ui.cancelBtn.click(function () {
          self.cancelSetting();
        });

        ui.saveBtn.click(function () {
          ui.form.submit();
        })

        ui.skinSelector.change(function () {
          // select에 지정된 skinId 가져오기
          var skinId = ui.skinSelector.val();

          // view 로드 후 setting 펼치기
          self.loadSettingView(skinId, $(self).data('instanceId'));
        });

        this.cancelSetting = function () {
          // btn 숨기기
          ui.editBtn.show();
          ui.saveBtn.hide();
          ui.cancelBtn.hide();
          ui.skinSelector.val(options.skinId);
          ui.setter.slideUp(100);
        }

        this.loadSettingView = function (skinId, instanceId, callback) {
          ui.skinSelector.val(skinId);

          if (!skinId) {
            ui.forms.empty();
            if (callback) {
              callback();
            }
          } else {
            XE.ajax({
              url: options.loadUrl,
              type: 'get',
              dataType: 'json',
              data: {skinId: skinId, instanceId: instanceId},
              success: function (data) {
                ui.forms.html(data.view)
                if (callback) {
                  callback();
                }
              }
            })
          }
        }

        this.saveSetting = function (saveUrl, postData, callback) {
          XE.ajax(
            {
              url: saveUrl,
              type: "POST",
              dataType: 'json',
              data: postData,
              success: function (data, textStatus, jqXHR) {
                XE.toast('success', data.message);
                if (callback) {
                  callback('success', data, textStatus, jqXHR);
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {

                XE.toast('danger', '스킨을 지정하지 못했습니다');

                if (callback) {
                  callback('error', jqXHR, textStatus, errorThrown);
                }
              }
            });
        }

        return this;
      }
    });
    $('.__xe_skinSetting').xeSkinSetting(skinSection);
  });
});

