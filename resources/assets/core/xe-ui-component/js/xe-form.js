;(function (XE) {

  var _formCommon = (function () {
    return {
      init: function () {

        this.bindEvents();

        return this;
      },

      bindEvents: function () {
        $(document).on('submit', 'form[data-submit=xe-ajax]', function (e) {
          e.preventDefault();

          var $this = $(this);
          var callback = $this.data('callback');
          var validate = $this.data('validate');

          var objStack = callback ? callback.split('.') : [];
          var callbackFunc = (objStack.length > 0) ? window : '';
          var callbackObj = null;

          if (objStack.length > 0) {
            for (var i = 0, max = objStack.length; i < max; i += 1) {
              callbackObj = callbackFunc;
              callbackFunc = callbackFunc[objStack[i]];
            }
          }

          var formData = new FormData($this[0]);

          var options = {
            url: $this.attr('action'),
            type: $this.attr('method'),
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
              callbackFunc.call(callbackObj, data, textStatus, jqXHR);
            },
          };

          if (callbackFunc === '') {
            delete options.success;
          }

          if (_formCommon.isValidForm(options)) {

            if (validate == true) {
              XE.formValidate($this);
            }

            XE.ajax(options);
          }

        });
      },

      isValidForm: function (options) {
        if (!options.url) {
          console.error('form action값이 없음');
          return false;
        }

        if (!options.type) {
          console.error('form method값이 없음');
          return false;
        }

        return true;
      },
    };
  })().init();

})(XE);
