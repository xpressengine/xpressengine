(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['exports', 'jquery'], factory);
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports, require('jquery'));
  } else {
    factory((root.XeRequest = {}), root.b);
  }
}(this, function (exports, $) {
  'use strict';

  // @TODO ajax options

  exports.options = {
    headers : {
      'X-CSRF-TOKEN': null
    }
  };

  $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
    // $.extend(options, XE.Request.options);
  });

  $(document).ajaxSend(function(event, jqxhr, settings) {
    XE.Progress.start(settings.context == undefined ? $('body') : settings.context);
  }).ajaxComplete(function(event, jqxhr, settings) {
    XE.Progress.done(settings.context == undefined ? $('body') : settings.context);
  }).ajaxError(function(event, jqxhr, settings, thrownError) {
    exports.error(jqxhr, settings, thrownError);
  });

  exports.setup = function(options) {
    $.extend(this.options, options);

    // XE.$ 를 주입받아 사용해야 할 jquery 의 서드파티들...
    $.ajaxSetup(this.options);
  };

  // XE 인터페이스 확장
  // XE.ajax = Request.ajax = function(url, options) {
  //   if ( typeof url === "object" ) {
  //     options = $.extend({}, XE.Request.options, url);
  //     url = undefined;
  //   } else {
  //     options = $.extend({}, options, XE.Request.options, {url: url});
  //     url = undefined;
  //   }

  //   var jqXHR = $.ajax(url, options);
  //   return jqXHR;
  // };

  exports.get = function(url, data, callback, type) {
    return $.get(url, data, callback, type)
  };

  exports.post = function(url, data, callback, type) {
    return $.post(url, data, callback, type);
  };

  // 여기를 많이 강화해야 한다.
  exports.error = function(jqxhr, settings, thrownError) {
    var status = jqxhr.status,
    type = 'danger',
    errorMessage = 'Not defined error message ('+status+')';

    // dataType 에 따라 메시지 획득 방식을 추가 해야함.
    if (settings.dataType == 'json') {
      errorMessage = $.parseJSON(jqxhr.responseText).message;
    } else {
      errorMessage = jqxhr.statusText;
    }

    // XE.toastByStatus(status, errorMessage);
  };

  console.log('@ XE.request.JS');
  return exports;
}));
