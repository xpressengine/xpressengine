import Progress from './xe.progress';

/**
 * @module Request
 * */
export default (function () {
  /** @private */
  var _this;

  /** @private */
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
    /**
     * Request module 초기화한다.
     * @method
     * @return this
     * */
    init: function () {
      _this = this;
      return this;
    },

    /**
     * @public
     * */
    options: _options,
    /**
     * ajax 옵션을 세팅한다.
     * @param {object} options jQuery ajax options
     * */
    setup: function (options) {
      $.extend(_options, options);
      $.ajaxSetup(_options);
    },

    /**
     * ajax를 method get 방식으로 호출한다.
     * @param {string} url
     * @param {object} data
     * @param {function} callback
     * @param {string} type
     * */
    get: function (url, data, callback, type) {
      return $.get(url, data, callback, type);
    },

    /**
     * ajax를 method post 방식으로 호출한다.
     * @param {string} url
     * @param {object} data
     * @param {function} callback
     * @param {string} type
     * */
    post: function (url, data, callback, type) {
      return $.post(url, data, callback, type);
    },

    /**
     * ajax 오류 메시지를 노출한다.
     * @param {object} jqxhr
     * @param {object} settings
     * @params {object} thrownError
     * */
    error: function (jqxhr, settings, thrownError) {
      var status = jqxhr.status;
      var errorMessage = 'Not defined error message (' + status + ')';

      // @TODO dataType 에 따라 메시지 획득 방식을 추가 해야함.
      if (jqxhr.status == 422) {
        var list = $.parseJSON(jqxhr.responseText).errors || {};

        errorMessage = '';
        errorMessage += '<ul>';
        for (var i in list) {
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
