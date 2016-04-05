(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['exports'], factory);
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports);
  } else {
    factory({});
  }
}(this, function (exports) {
  'use strict';

  var $ = window.jQuery;

  // @TODO ajax options

  exports.options = {
    headers : {
      'X-CSRF-TOKEN': null
    }
  };

  // $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
  //   $.extend(options, XE.Request.options);
  // });

  // @FIXME
  $(document).ajaxSend(function(event, jqxhr, settings) {
    XE.Progress.start(settings.context == undefined ? $('body') : settings.context);
  }).ajaxComplete(function(event, jqxhr, settings) {
    XE.Progress.done(settings.context == undefined ? $('body') : settings.context);
  }).ajaxError(function(event, jqxhr, settings, thrownError) {
    exports.error(jqxhr, settings, thrownError);
  });

  exports.setup = function(options) {
    $.extend(exports.options, options);
    $.ajaxSetup(exports.options);
  };

  exports.get = function(url, data, callback, type) {
    return $.get(url, data, callback, type)
  };

  exports.post = function(url, data, callback, type) {
    return $.post(url, data, callback, type);
  };

  // @TODO 여기를 많이 강화해야 한다.
  exports.error = function(jqxhr, settings, thrownError) {
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
  };
}));
