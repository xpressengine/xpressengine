System.amdDefine('xe.request', ['xe.progress'], function(Progress) {

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
    window.error(jqxhr, settings, thrownError);
  });

  return {
    setup: setup,
    get: get,
    post: post,
    options: _options
  };

  function setup(options) {
    $.extend(_options, options);
    $.ajaxSetup(_options);
  }

  function get(url, data, callback, type) {
    return $.get(url, data, callback, type)
  }

  function post(url, data, callback, type) {
    return $.post(url, data, callback, type);
  }

  function error(jqxhr, settings, thrownError) {
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

});
