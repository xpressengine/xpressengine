(function(exports, Progress) {
  exports.XE.Request = function() {
    var self;

    var _options = {
      headers : {
        'X-CSRF-TOKEN': null
      }
    };

    // @FIXME
    $(document).ajaxSend(function(event, jqxhr, settings) {
      Progress.start(settings.context == undefined ? $('body') : settings.context);
    }).ajaxComplete(function(event, jqxhr, settings) {
      Progress.done(settings.context == undefined ? $('body') : settings.context);
    }).ajaxError(function(event, jqxhr, settings, thrownError) {
      self.error(jqxhr, settings, thrownError);
    });

    return {
      init: function() {
        self = this;

        return this;
      },
      options: _options,
      setup: function(options) {
        $.extend(_options, options);
        $.ajaxSetup(_options);
      },
      get: function(url, data, callback, type) {
        return $.get(url, data, callback, type)
      },
      post: function (url, data, callback, type) {
        return $.post(url, data, callback, type);
      },
      error: function (jqxhr, settings, thrownError) {
        var status = jqxhr.status,
            type = 'danger',
            errorMessage = 'Not defined error message ('+status+')';

        // @TODO dataType 에 따라 메시지 획득 방식을 추가 해야함.
        if (settings.dataType == 'json') {
          errorMessage = $.parseJSON(jqxhr.responseText).message;
        } else {
          errorMessage = jqxhr.statusText;
        }

        // @FIXME 의존성
        window.XE.toastByStatus(status, errorMessage);
      }
    }.init();
  }();
})(window, XE.Progress);
