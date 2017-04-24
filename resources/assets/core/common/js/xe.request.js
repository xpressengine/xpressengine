import Progress from './xe.progress';

export default (function () {
  var _this;

  var _options = {
    headers: {
      'X-CSRF-TOKEN': null,
    },
  };

  // @FIXME
  $(document).ajaxSend(function (event, jqxhr, settings) {
    if (settings.useXeSpinner) {
      Progress.start(settings.context == undefined ? $('body') : settings.context);
    }
  }).ajaxComplete(function (event, jqxhr, settings) {
    if (settings.useXeSpinner) {
      Progress.done(settings.context == undefined ? $('body') : settings.context);
    }
  }).ajaxError(function (event, jqxhr, settings, thrownError) {
    if (settings.useXeSpinner) {
      Progress.done();
    }

    if (!settings.hasOwnProperty('error')) {
      _this.error(jqxhr, settings, thrownError);
    }
  });

  return {
    init: function () {
      _this = this;
      return this;
    },

    options: _options,
    setup: function (options) {
      $.extend(_options, options);
      $.ajaxSetup(_options);
    },

    get: function (url, data, callback, type) {
      return $.get(url, data, callback, type);
    },

    post: function (url, data, callback, type) {
      return $.post(url, data, callback, type);
    },

    error: function (jqxhr, settings, thrownError) {
      var status = jqxhr.status;
      var errorMessage = 'Not defined error message (' + status + ')';

      // @TODO dataType 에 따라 메시지 획득 방식을 추가 해야함.
      if (jqxhr.status == 422) {
        var list = $.parseJSON(jqxhr.responseText);

        errorMessage = '';
        errorMessage += '<ul>';
        for (var i = 0, max = list.length; i < max; i += 1) {
          errorMessage += '<li>' + list[i] + '</li>';
        }

        errorMessage += '</ul>';
      } else if (settings.dataType == 'json') {
        errorMessage = $.parseJSON(jqxhr.responseText).message;
      } else {
        errorMessage = jqxhr.statusText;
      }

      // @FIXME 의존성
      XE.toastByStatus(status, errorMessage);
    },
  }.init();
})();
